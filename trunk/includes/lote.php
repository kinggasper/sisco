<?php

/**
 * Description of lote
 *
 * @author Anyul Rivas
 */
class lote extends db implements crud {

    const tabla = 'lote';
    const nomina = "1";
    const banco = "2";
    const pendiente = "1";
    const rechazado = "3";

    public function actualizar($id, $data) {
        return $this->update(self::tabla, $data, array("id" => $id));
    }

    public function borrar($id) {
        return $this->delete(self::tabla, array("id" => $id));
    }

    public function insertar($data) {
        return $this->insert(self::tabla, $data);
    }

    public function listar() {
        return $this->select("*", self::tabla);
    }

    public function ver($id) {
        return $this->select("*", self::tabla, array("id" => $id));
    }

    public function generar_lote($tipo_medio_pago, $tipo_cobro, $organismo, $banco, $session) {
        $recibo = new recibo();
        // <editor-fold defaultstate="collapsed" desc="query">
        switch ($tipo_medio_pago) {
            case self::nomina:
                if ($tipo_cobro == self::pendiente) {
                    // <editor-fold defaultstate="collapsed" desc="Query Nomina">
                    $query = "select * from recibo
                inner join medio_pago on recibo.medio_pago_id = medio_pago.id
                inner join tipo_medio_pago on medio_pago.tipo_medio_pago_id = tipo_medio_pago.id
                inner join contrato on recibo.contrato_id = contrato.id
                    where status_recibo_id =1
                    and contrato.organismo_id =$organismo
                    and tipo_medio_pago_id = $tipo_medio_pago
                    ";
                    // </editor-fold>
                } elseif ($tipo_cobro == self::rechazado) {
                    //TODO    
                }
                break;
            case self::banco:
                if ($tipo_cobro == self::pendiente) {
                    // <editor-fold defaultstate="collapsed" desc="Query Banco">
                    $query = "select * from recibo 
                inner join contrato on contrato.id = recibo.contrato_id
                inner join medio_pago on recibo.medio_pago_id = medio_pago.id
                inner join tipo_medio_pago on medio_pago.tipo_medio_pago_id = tipo_medio_pago.id
                inner join banco on medio_pago.banco_id = banco.id
                    where contrato.status_contrato_id=1 and status_recibo_id = 1 
                    and tipo_medio_pago.id = $tipo_medio_pago
                    and banco.id = $banco
                    ";
                    // </editor-fold>
                } elseif ($tipo_cobro == self::rechazado) {
                    //TODO
                }
                break;
            default:
                die("Peticion invalida");
                break;
        }
        // </editor-fold>

        $recibos = $recibo->dame_query($query);
        // <editor-fold defaultstate="collapsed" desc="inserto lote en bd">
        $result_lote = $this->insertar(array(
            "usuario_id" => $session['id'],
            "empresa_id" => $session['empresa_id'],
            "tipo_lote_id" => 1));
        if ($result_lote['suceed'] == true && $result_lote['insert_id'] > 0) {
            // <editor-fold defaultstate="collapsed" desc="detalle lote">
            $result_lote_detalle = array();
            foreach ($recibos['data'] as $recibo) {
                $result_lote_detalle = $this->insert('lote_detalle', array(
                    "lote_id" => $result_lote['insert_id'],
                    "recibo_id" => $recibo['id']));
                // </editor-fold>
            }
        }
        // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="bitacora">
        $bitacora = new bitacora();
        $bitacora->log($_SESSION['usuario']['id'], "Modulo de Lotes");
        // </editor-fold>
        return $recibos;
    }

    public function cargar_lote($tipo_medio_pago, $tipo_cobro, $organismo, $banco, $archivo) {
        //TODO mover archivo cargado a carpeta de archivos de respuesta
        $mover_archivo = move_uploaded_file($archivo, SERVER_ROOT . '/lote/');
        //TODO leer respuesta de archivo
        fopen(SERVER_ROOT . '', $mode);
        //TODO actualizar recibos cobrados
        //TODO cancelar contratos con todos los recibos cobrados
        //TODO actualizar recibos rechazados
        //TODO cambiar a incobrables contratos con recibos morosos
        echo $tipo_lote;
    }

}

?>
