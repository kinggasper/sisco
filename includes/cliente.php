<?php

/**
 * Description of cliente
 *
 * @author Anyul Rivas
 */
class cliente extends db implements crud {

    const tabla = "cliente";

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
        return $this->dame_query("select * from cliente");
    }

    public function ver($id) {
        return $this->dame_query("select cliente.*, organismo.nombre organismo from cliente 
inner join organismo on cliente.organismo_id = organismo.id where cliente.id=" . $id);
    }

    public function clientes_por_organismo($organismo) {
        return $this->dame_query("select * from cliente WHERE organismo_id =$organismo ");
    }

}

?>
