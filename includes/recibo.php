<?php
/**
 * Description of recibo
 *
 * @author Anyul Rivas
 */
class recibo extends db implements crud {
    const tabla = "recibo";
    //put your code here
    public function actualizar($id, $data) {
        return $this->update(self::tabla, $data, array("id"=>$id));
    }
    public function borrar($id) {
        return $this->delete(self::tabla, array("id"=>$id));
    }
    public function insertar($data) {
        return $this->insert(self::tabla, $data);
    }
    public function listar() {
        return $this->dame_query("select * from recibo");
    }
    public function ver($id) {
        return $this->dame_query("select recibo.*,
                status_recibo.nombre 'status_recibo',
                medio_pago.id 'medio_pago_id'
                from recibo
                inner join status_recibo on recibo.status_recibo_id = status_recibo.id
                inner join medio_pago on recibo.medio_pago_id = medio_pago.id
                where recibo.id=$id");
    }
    public function recibos_por_contrato($contrato){
        return $this->dame_query("
                select recibo.*, 
        status_recibo.nombre 'status_recibo',
        tipo_medio_pago.nombre 'tipo_medio_pago',
        banco.nombre 'banco'
            from recibo
                inner join status_recibo on recibo.status_recibo_id = status_recibo.id
                inner join medio_pago on recibo.medio_pago_id = medio_pago.id
                inner join tipo_medio_pago on medio_pago.tipo_medio_pago_id = tipo_medio_pago.id
                left join banco on medio_pago.banco_id = banco.id
                    where recibo.contrato_id = $contrato 
                        order by recibo.id
                ");
    }
    
    public function recibos_pagados_por_contrato($contrato) {
        $query="select * from recibo 
            where contrato_id=".$contrato." and status_recibo_id=2";
        return $this->dame_query($query);
    }
}

?>
