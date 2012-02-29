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
        //TODO validar que el contrato no tenga recibos cobrados
        return $this->delete(self::tabla, array("id" => $id));
    }
    public function insertar($data) {
        return $this->insert(self::tabla, $data);
        
    }
    public function listar() {
        return $this->dame_query("select * from ".self::tabla);
    }
    public function ver($id) {
        return $this->dame_query("select * from ".self::tabla." where id=".$id);
    }
    public function emitirContrato($data,$producto,$cantidad) {
        $resultado = array("suceed" => false);
        try {
            $this->exec_query("start transaction");
            $resultado['registrar_contrato'] = $this->insertar($data);
            if ($resultado['registrar_contrato']['insert_id'] > 0) {
                
                $contrato_id = $resultado['registrar_contrato']['insert_id'];
                if (is_array($producto) && is_array($cantidad)) {
                    for ($i = 0; $i < sizeof($producto); $i++) {
                        
                        while ($cantidad[$i]> 0) {
                            $producto_almacen = $this->actualizarProductoAlmacen($producto[$i], $cantidad[$i]);
                            
                            $resultado['contrato_productos'] = $this->insert(
                                    "contrato_productos", 
                                    Array("contrato_id"=>$contrato_id,
                                        "producto_id"=>$producto[$i],
                                        "almacen_id"=>$producto_almacen["almacen"],
                                        "cantidad"=>$producto_almacen["cantidad"]));
                        
                            $cantidad[$i] -= $producto_almacen["cantidad"];
                        }
                    }
                }
            }
            $this->exec_query("commit");
            $resultado['suceed'] = true;
            return $resultado;
        } catch (Exception $exc) {
            $this->exec_query("rollback");
            trigger_error("Error al emitir el contrato" . $exc->getTraceAsString());
            return $resultado;
        }
    }

    public function actualizarProductoAlmacen($producto_id,$cantidad) {
        $producto_almacen = Array("almacen"=>0,"cantidad"=>0);
        $query = "select almacen_id, cantidad from producto_almacen
            where producto_id=".$producto_id." and cantidad > 0
            order by cantidad DESC";
        $resultado = $this->dame_query($query);
        
        if ($resultado['suceed']&& count($resultado['data'])>0) {
            if($resultado['data'][0]['cantidad']>=$cantidad) {
                $query = "update producto_almacen set cantidad = cantidad-".$cantidad.
                        " where producto_id=".$producto_id.
                        " and almacen_id=".$resultado['data'][0]['almacen_id'];
                $producto_almacen['cantidad'] = $cantidad;
            } else {
                $query = "update producto_almacen set cantidad = 0 
                          where producto_id=".$producto_id.
                        " and almacen_id=".$resultado['data'][0]['almacen_id'];
                $producto_almacen['cantidad'] = $resultado['data'][0]['cantidad']; 
            }
            $this->exec_query($query);
            $producto_almacen['almacen'] = $resultado['data'][0]['almacen_id'];
        }
        return $producto_almacen;
    }
}

?>
