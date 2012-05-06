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
        $result = $this->update(self::tabla, $data, array("id" => $id));
        $this->log("Almacen {$data['id']}:{$data['nombre']} actualizado con exito.");
        return $result;
    }

    public function borrar($id) {
        $productos_almacen = $this->dame_query("select * from  producto_almacen where almacen_id =" . $id);
        if (count($productos_almacen['data']) > 0) {
            foreach ($productos_almacen['data'] as $producto) {
                if ($producto['cantidad'] > 0) {
                    return array("suceed" => false, "error" => "No se puede borrar el almacen porque tiene productos asociados con existencia.");
                }
            }
        }
        $temp = $this->ver($id);
        $this->log("Almacen {$temp['data'][0]['id']}:{$temp['data'][0]['nombre']} borrado con exito");
        $result = $this->delete(self::tabla, array("id" => $id));
        return $result;
    }

    public function insertar($data) {
        $result = $this->insert(self::tabla, $data);
        $this->log("Almacen {$result['insert_id']}:{$data['nombre']} creado con exito.");
        return $result;
    }

    public function ver($id) {
        return $this->dame_query("select almacen.id, almacen.nombre nombre from almacen 
        where id =" . $id);
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
            $almacen_temp = $this->ver($almacen);
            $this->log("Orden de compra realizada para almacen {$almacen_temp['data'][0]['id']}:{$almacen_temp['data'][0]['nombre']}.");
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
            $temp_almacen_origen = $this->ver($almacen_origen);
            $temp_almacen_destino = $this->ver($almacen_destino);
            $this->log("Traspaso realizado  
                    desde almacen {$temp_almacen_origen['data'][0]['id']}:{$temp_almacen_origen['data'][0]['nombre']} 
                    a {$temp_almacen_destino['data'][0]['id']}:{$temp_almacen_destino['data'][0]['nombre']} 
                    ");
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
        return $this->dame_query("
            select 
                producto.id 'producto_id', producto.nombre 'producto', 
                almacen.id 'almacen_id', almacen.nombre 'almacen',
                producto.cantidad_minima, ifnull(producto_almacen.cantidad, 0)'existencia'
                from producto 
                    left outer join producto_almacen on producto.id = producto_almacen.producto_id
                    left outer join almacen on almacen.id = producto_almacen.almacen_id
                        where ifnull(producto_almacen.cantidad, 0) < producto.cantidad_minima
                            order by producto.id");
    }


}

?>
