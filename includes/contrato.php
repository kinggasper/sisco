<?php

/**
 * Clase para el manejo de los vendedores
 *
 * @author emessia
 */
class contrato extends db implements crud {

    const tabla = "contrato";

    public function actualizar($id, $data) {
        return $this->update(self::tabla, $data, array("id" => $id));
    }

    public function borrar($id) {
        $resultado = array("suceed" => false);
        if (!$this->contratoRecibosPagados($id)) {
            try {
                $this->exec_query("start transaction");
                $this->exec_query("delete from recibo where contrato_id=" . $id);
                $this->exec_query("delete from contrato_productos where contrato_id=" . $id);
                $resultado = $this->delete(self::tabla, array("id" => $id));
                $this->exec_query("commit");
                return $resultado;
            } catch (Exception $exc) {
                $this->exec_query("rollback");
                trigger_error("Error al eliminar el contrato" . $exc->getTraceAsString());
            }
        } else {
            return Array("suceed" => false, "error" => "Contrato tiene recibos pagados.");
        }
    }

    public function contratoRecibosPagados($contrato) {
        $recibos = new recibo();
        $resultado = $recibos->recibos_pagados_por_contrato($contrato);
        if ($resultado['suceed']) {
            return count($resultado['data']) > 0;
        } else {
            return false;
        }
    }

    public function insertar($data) {
        return $this->insert(self::tabla, $data);
    }

    public function listar() {
        return $this->dame_query("select * from " . self::tabla);
    }

    public function ver($id) {
        return $this->dame_query("
                select 
                contrato.*, 
                empresa.nombre empresa,
                plazo.nombre plazo,
                organismo.nombre organismo,
                status_contrato.nombre status_contrato,
                concat(cliente.nombre,' ',cliente.apellido) cliente,
                frecuencia.nombre frecuencia,
                vendedor.nombre vendedor
                from contrato
                inner join empresa on contrato.empresa_id = empresa.id
                inner join plazo on contrato.plazo_id = plazo.id
                inner join organismo on contrato.organismo_id = organismo.id
                inner join status_contrato on contrato.status_contrato_id = status_contrato.id
                inner join cliente on contrato.cliente_id = cliente.id
                inner join frecuencia on contrato.frecuencia_id = frecuencia.id
                inner join vendedor on contrato.vendedor_id = vendedor.id
                where contrato.id= $id");
    }

    public function productos_por_contrato($id) {
        return $this->dame_query("select 
            producto.*, 
            categoria.nombre categoria,
            contrato_productos.precio
            from contrato_productos 
            inner join producto on contrato_productos.producto_id = producto.id 
            inner join categoria on producto.categoria_id = categoria.id
            where contrato_productos.contrato_id = $id");
    }

    public function emitirContrato($data, $producto, $cantidad, $costo, $medio_pago) {
        $resultado = array("suceed" => false);
        try { 
            $this->exec_query("start transaction");
            $resultado['registrar_contrato'] = $this->insertar($data);
            // registramos ahora los productos
            if ($resultado['registrar_contrato']['insert_id'] > 0) {

                $contrato_id = $resultado['registrar_contrato']['insert_id'];
                var_dump($producto);
                var_dump($cantidad);
                if (is_array($producto) && is_array($cantidad)) {
                    $monto = 0;
                    for ($i = 0; $i < sizeof($producto); $i++) {
                        while ($cantidad[$i] > 0) {
                            $producto_almacen = $this->actualizarProductoAlmacen($producto[$i], $cantidad[$i]);
                            
                            $resultado['contrato_productos'] = $this->insert(
                                    "contrato_productos", Array(
                                "contrato_id" => $contrato_id,
                                "producto_id" => $producto[$i],
                                "almacen_id" => $producto_almacen["almacen"],
                                "cantidad" => $producto_almacen["cantidad"],
                                "precio" => $costo[$i]));
                            $cantidad[$i] -= $producto_almacen["cantidad"];
                            $monto += ($costo[$i] * $cantidad[$i]);
                        }
                    }
                    
                }
                
                // registramos ahora los recibos
                $plazos = new plazo();
                $plazo = $plazos->ver($data['plazo_id']);

                $res = $this->generarRecibos($data['cliente_id'], $contrato_id, $data['frecuencia_id'], $plazo['data'][0]['nombre']);
                $monto_recibo = $monto / $res;
                $this->exec_query("update recibo set monto=" . $monto_recibo . 
                        ", medio_pago_id=".$medio_pago." where contrato_id=" . $contrato_id);
                $comision = $monto * ($data['porcentaje_vendedor'] / 100);

                $this->exec_query("update contrato join configuracion set contrato.monto=" . $monto . ", 
                        contrato.comision_vendedor=" . $comision . ", contrato.iva=configuracion.iva 
                        where id=" . $contrato_id);
            }
            $resultado['suceed'] = true;
            $this->exec_query("commit");
            return $resultado;
        } catch (Exception $exc) {
            $this->exec_query("rollback");
            trigger_error("Error al emitir el contrato" . $exc->getTraceAsString());
            return $resultado;
        }
    }

    public function actualizarProductoAlmacen($producto_id, $cantidad) {
        $producto_almacen = Array("almacen" => 0, "cantidad" => 0);
        $query = "select almacen_id, cantidad from producto_almacen
            where producto_id=" . $producto_id . " and cantidad > 0
            order by cantidad DESC";
        $resultado = $this->dame_query($query);

        if ($resultado['suceed'] && count($resultado['data']) > 0) {
            if ($resultado['data'][0]['cantidad'] >= $cantidad) {
                $query = "update producto_almacen set cantidad = cantidad-" . $cantidad .
                        " where producto_id=" . $producto_id .
                        " and almacen_id=" . $resultado['data'][0]['almacen_id'];
                $producto_almacen['cantidad'] = $cantidad;
            } else {
                $query = "update producto_almacen set cantidad = 0 
                          where producto_id=" . $producto_id .
                        " and almacen_id=" . $resultado['data'][0]['almacen_id'];
                $producto_almacen['cantidad'] = $resultado['data'][0]['cantidad'];
            }
            $this->exec_query($query);
            $producto_almacen['almacen'] = $resultado['data'][0]['almacen_id'];
        }
        return $producto_almacen;
    }

    public function generarRecibos($cliente_id, $contrato_id, $frecuencia, $plazo) {

        switch ($frecuencia) {
            // semanal
            case 2:
                $resultado = $this->recibosSemanales($cliente_id, $contrato_id, $plazo);
                break;
            // quincenal 10 y 25
            case 3:
                $resultado = $this->recibosQuincenales($cliente_id, $contrato_id, $plazo, $frecuencia);
                break;
            // quincenal 15 y último
            case 4:
                $resultado = $this->recibosQuincenales($cliente_id, $contrato_id, $plazo, $frecuencia);
                break;
            //mensual
            default:
                $resultado = $this->recibosMensuales($cliente_id, $contrato_id, $plazo);
                break;
        }
        return $resultado;
    }

// <editor-fold defaultstate="collapsed" desc="Recibos Semanales">
    function recibosSemanales($cliente_id, $contrato_id, $plazo) {
        $n = 0;
        $fecha_inicio = time();
        $fecha_inicio = strtotime('Next Friday', time());
        $fecha_fin = strtotime("+" . $plazo . "month", $fecha_inicio);

        while ($fecha_inicio < $fecha_fin) {
            $resultado = $this->insert("recibo", Array(
                "cliente_id" => $cliente_id,
                "contrato_id" => $contrato_id,
                "monto" => 0,
                "fecha" => date('Y-m-d 00:00:00', $fecha_inicio),
                "status_recibo_id" => 1,
                "medio_pago_id" => 1
                    ));
            if ($resultado['suceed'] == true)
                $n++;

            $fecha_inicio = strtotime("+1 week", $fecha_inicio);
        }
        return $n;
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Recibos Quincenales">
    function recibosQuincenales($cliente_id, $contrato_id, $plazo, $tipo_quincena) {
        $fecha_inicio = time();
        $q1 = $tipo_quincena == 3 ? '10' : '15';
        $q2 = $tipo_quincena == 3 ? '25' : 't';
        $fecha_fin = strtotime("+" . $plazo . "month", $fecha_inicio);
        $n = 0;
        while ($fecha_inicio <= $fecha_fin) {
            //primera quincena
            $fecha_recibo = strtotime(date($q1 . '-m-Y', $fecha_inicio));
            if ($fecha_recibo >= time() && $fecha_recibo <= $fecha_fin) {

                $resultado = $this->insert("recibo", Array(
                    "cliente_id" => $cliente_id,
                    "contrato_id" => $contrato_id,
                    "monto" => 0,
                    "fecha" => date('Y-m-d 00:00:00', $fecha_recibo),
                    "status_recibo_id" => 1,
                    "medio_pago_id" => 1
                        ));
                if ($resultado['suceed'] == true)
                    $n++;
            }

            //segunda quincena
            $fecha_recibo = strtotime(date($q2 . '-m-Y', $fecha_inicio));
            if ($fecha_recibo >= time() && $fecha_recibo <= $fecha_fin) {
                $resultado = $this->insert("recibo", Array(
                    "cliente_id" => $cliente_id,
                    "contrato_id" => $contrato_id,
                    "monto" => 0,
                    "fecha" => date('Y-m-d 00:00:00', $fecha_recibo),
                    "status_recibo_id" => 1,
                    "medio_pago_id" => 1
                        ));
                if ($resultado['suceed'])
                    $n++;
            }
            $fecha_inicio = strtotime("+1 month", $fecha_inicio);
        }
        return $n;
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Recibos Mensuales">
    function recibosMensuales($cliente_id, $contrato_id, $plazo) {
        $fecha_inicio = time();
        $fecha_fin = strtotime("+" . $plazo . "month", $fecha_inicio);
        $n = 0;
        while ($fecha_inicio < $fecha_fin) {
//        $query = "insert into recibo (cliente_id,contrato_id,monto,fecha,status_recibo_id,
//            medio_pago_id) values(".$cliente_id.",".$contrato_id.",0,"
//                .date('Y-m-t 00:00:00',$fecha_inicio).",1,1)";
//        $this->exec_query($query);
            $resultado = $this->insert("recibo", Array(
                "cliente_id" => $cliente_id,
                "contrato_id" => $contrato_id,
                "monto" => 0,
                "fecha" => date('Y-m-t 00:00:00', $fecha_inicio),
                "status_recibo_id" => 1,
                "medio_pago_id" => 1
                    ));
            $fecha_inicio = strtotime("+1 month", $fecha_inicio);
            $n++;
        }
        return $n;
    }

// </editor-fold>
}

?>
