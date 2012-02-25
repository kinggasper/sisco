<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mediopago
 *
 * @author Anyul Rivas
 */
class mediopago extends db implements crud {

    const tabla = "medio_pago";
    const tipo_medio_pago = "tipo_medio_pago";

    public function actualizar($id, $data) {
        return $this->update(self::tabla, $data, array("id" => $id));
    }

    public function borrar($id) {
        $recibos_asociados = $this->select("*", "recibo", array("medio_pago_id" => $id));
        if (count($recibos_asociados['data']) > 0) {
            return array("suceed" => false, "error" => "No se puede borrar el medio de pago porque tiene recibos asociados a este.");
        }
        return $this->delete(self::tabla, array("id" => $id));
    }

    public function insertar($data) {
        return $this->insert(self::tabla, $data);
    }

    public function listar() {
        return $this->select("*", self::tabla);
    }

    public function listar_tipo_medio_pagos(){
        return $this->select("*", self::tipo_medio_pago);
    }
    public function ver($id) {
        return $this->dame_query("
        select medio_pago.*, tipo_medio_pago.nombre 'medio_pago' , banco.nombre 'banco'
                from medio_pago
        inner join tipo_medio_pago on medio_pago.tipo_medio_pago_id = tipo_medio_pago.id
        left join banco on banco_id = banco.id
        where medio_pago.id=$id
        ");
    }

    public function medios_pago_usuario($usuario) {
        return $this->dame_query("
        select medio_pago.*, tipo_medio_pago.nombre 'medio_pago' , banco.nombre 'banco'
                from medio_pago
        inner join tipo_medio_pago on medio_pago.tipo_medio_pago_id = tipo_medio_pago.id
        left join banco on banco_id = banco.id
        where medio_pago.usuario_id = $usuario");
    }

}

?>
