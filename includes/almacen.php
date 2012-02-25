<?php

/**
 * Clase para el manejo de almacen
 *
 * @author Anyul Rivas
 */
class almacen extends db implements crud {

    const tabla = "almacen";
    const tabla_producto_almacen = "producto_almacen";

    public function actualizar($id, $data) {
        return $this->update(self::tabla, $data, array("id" => $id));
    }

    public function borrar($id) {
        $productos_almacen = $this->dame_query("select * from  producto_almacen where almacen_id =" . $id);
        if (count($productos_almacen['data']) > 0) {
//            var_dump($productos_almacen);
            foreach ($productos_almacen['data'] as $producto) {
                var_dump($producto);
                if ($producto['cantidad'] > 0) {
                    return array("suceed" => false, "error" => "No se puede borrar el almacen porque tiene productos asociados con existencia.");
                }
            }
        }
        return $this->delete(self::tabla, array("id" => $id));
    }

    public function insertar($data) {
        return $this->insert(self::tabla, $data);
    }

    public function ver($id) {
        return $this->dame_query("select almacen.id, almacen.nombre nombre, ifnull(cantidad,0) cantidad from almacen 
        left outer join producto_almacen on almacen.id = producto_almacen.almacen_id where almacen.id =" . $id);
    }

    public function listar() {
        return $this->dame_query("select id, nombre from " . self::tabla);
    }

    public function listarPorEmpresa($empresa_id) {
        return $this->select("*", self::tabla, array("empresa_id" => $empresa_id));
    }

    /**
     * Realiza una orden de compra para un almacen determinado
     * @param mixed $producto productos a cargar
     * @param mixed $cantidad cantidades a cargar en almacen
     * @param mixed $costo costo de los productos
     * @param int $almacen almacen destino
     */
    public function ordenDeCompra($producto, $cantidad, $costo, $almacen) {
        $resultado = array("suceed" => false);
        try {
            $this->exec_query("start transaction");
            if (is_array($producto) && is_array($cantidad) && is_array($costo)) {
                for ($i = 0; $i < sizeof($producto); $i++) {
                    $resultado['insert_producto_almacen'] = $this->exec_query("insert into producto_almacen(producto_id,almacen_id,cantidad) values({$producto[$i]}, $almacen, {$cantidad[$i]})
on duplicate key update cantidad = cantidad + {$cantidad[$i]};");
                }
                if ($resultado['insert_producto_almacen']['suceed']) {
                    $resultado['insert_entrada'] = $this->insert("entrada", array(
                        "usuario_id" => $_SESSION['usuario']['id'],
                        "empresa_id" => $_SESSION['usuario']['empresa_id']
                            ));
                    if ($resultado['insert_entrada']['insert_id'] > 0) {
                        for ($i = 0; $i < sizeof($producto); $i++) {
                            $resultado['insert_entrada_detalle'][$i] = $this->insert("entrada_detalle", array(
                                "entrada_id" => $resultado['insert_entrada']['insert_id'],
                                "producto_id" => $producto[$i],
                                "almacen_id" => $almacen,
                                "cantidad" => $cantidad[$i],
                                "costo" => $costo[$i]
                                    ));
                        }
                        $resultado['suceed'] = true;
                    }
                }
            }
            $this->exec_query("commit");
            return $resultado;
        } catch (Exception $exc) {
            $this->exec_query("rollback");
            trigger_error("Error al realizar orden de compra" . $exc->getTraceAsString());
            return $resultado;
        }
    }

    /**
     * Traspasa un producto o una serie de productos a un almacen o serie de almacenes
     * @param mixed $almacen
     * @param mixed $producto
     * @param mixed $cantidad 
     */
    public function traspasar($producto, $almacen_origen, $almacen_destino, $cantidad) {
        $resultado = array("suceed" => false);
        // <editor-fold defaultstate="collapsed" desc="Distintos productos/distintos almacenes">
        if (is_array($almacen_destino) && is_array($producto)) {

            for ($i = 0; $i < sizeof($producto); $i++) {
                $this->traspaso($producto[$i], $almacen_origen, $almacen_destino[$i], $cantidad[$i]);
            }
        }
        // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="distintos productos/mismo almacen">
        elseif (is_array($producto) && !is_array($almacen_destino)) {
            for ($i = 0; $i < sizeof($producto); $i++) {
                $this->traspaso($producto[$i], $almacen_origen, $almacen_destino, $cantidad[$i]);
            }
        }
        // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="un producto/un almacen">
        else {
            $resultado = $this->traspaso($producto, $almacen_origen, $almacen_destino, $cantidad);
            return $resultado;
        }
        // </editor-fold>
    }

    private function traspaso($producto, $almacen_origen, $almacen_destino, $cantidad) {
        $resultado = array("suceed" => false);
        // <editor-fold defaultstate="collapsed" desc="inserto /actualizo">
        try {
            $resultado['insert'] = $this->exec_query("insert into producto_almacen(producto_id,almacen_id,cantidad) values($producto, $almacen_destino, $cantidad)
on duplicate key update cantidad = cantidad + $cantidad;");
            // </editor-fold>
            if ($resultado['insert']['suceed']) {
                // <editor-fold defaultstate="collapsed" desc="actualizo la cantidad en el almacen de origen">
                $resultado['update'] = $this->exec_query("update " . self::tabla_producto_almacen . " set cantidad= cantidad -$cantidad where producto_id=$producto and almacen_id=$almacen_origen");
                // </editor-fold>
                // <editor-fold defaultstate="collapsed" desc="elimino en caso de no quedar existencia">
                $restante = $this->dame_query("select cantidad from producto_almacen where producto_id=$producto and almacen_id=$almacen_origen");
                if ($restante['suceed'] && intval($restante['data'][0]['cantidad']) === 0) {
                    $resultado['delete'] = $this->delete(self::tabla_producto_almacen, array("producto_id" => $producto, "almacen_id" => $almacen_origen));
                }
                // </editor-fold>
            }
        } catch (Exception $exc) {
            trigger_error("Error en el traspaso de productos:" . $exc->getTraceAsString());
            $resultado['suceed'] = false;
            $resultado['error'] = "No se pudo realizar el traspaso. Por favor comuníquese con el Administrador del sistema";
        }

        if ($resultado['insert']['suceed'] == true && $resultado['update']['suceed'] == true)
            $resultado['suceed'] = true;
        return $resultado;
    }

    public function verificar_existencias() {
        $producto = new producto();
        $productos = $producto->listar();
        $productos_faltantes = array();
        foreach ($productos['data'] as $registro) {
            $existencia_almacen = $this->dame_query("select * from producto_almacen where producto_id={$registro['id']}");
            if (count($existencia_almacen['data']) > 0) {
                foreach ($existencia_almacen['data'] as $almacen) {
                    if ($almacen['cantidad'] < $registro['cantidad_minima']) {
                        array_push($productos_faltantes, array("producto_id" => $registro['id'],
                            "almacen_id" => $almacen['almacen_id']));
                    }
                }
            }
        }
        return $productos_faltantes;
    }

}

?>
