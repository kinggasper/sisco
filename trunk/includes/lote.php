<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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

    public function generar_lote($tipo_medio_pago, $tipo_cobro, $organismo, $banco) {
        switch ($tipo_medio_pago) {
            case nomina:
                if ($tipo_cobro == nomina) {
                    // <editor-fold defaultstate="collapsed" desc="Query Nomina">
                    $query = "select * from recibo
                inner join medio_pago on recibo.medio_pago_id = medio_pago.id
                inner join tipo_medio_pago on medio_pago.tipo_medio_pago_id = tipo_medio_pago.id
                inner join contrato on recibo.contrato_id = contrato.id
                    where status_recibo_id =1
                    and contrato.organismo_id =$organismo
                    and tipo_medio_pago_id = $tipo_medio_pago
                    and recibo.fecha <= CURRENT_TIMESTAMP;";
                    // </editor-fold>
                } elseif ($tipo_cobro == rechazado) {
                    //TODO    
                }
                break;
            case banco:
                if ($tipo_cobro == nomina) {
                    // <editor-fold defaultstate="collapsed" desc="Query Banco">
                    $query = "select * from recibo 
                inner join contrato on contrato.id = recibo.contrato_id
                inner join medio_pago on recibo.medio_pago_id = medio_pago.id
                inner join tipo_medio_pago on medio_pago.tipo_medio_pago_id = tipo_medio_pago.id
                inner join banco on medio_pago.banco_id = banco.id
                    where contrato.status_contrato_id=1 and status_recibo_id = 1 
                    and tipo_medio_pago.id = $tipo_medio_pago
                    and banco.id = $banco
                    and recibo.fecha <= CURRENT_TIMESTAMP;";
                    // </editor-fold>
                } elseif ($tipo_cobro == rechazado) {
                    //TODO
                }
                break;
            default:
                die("Peticion invalida");
                break;
        }
        $recibos = $recibo->dame_query($query);
        return $recibos;
    }

    public

    function cargar_lote($tipo_lote) {
        //TODO
        echo $tipo_lote;
    }

}

?>
