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
        $this->log("Cliente $id:{$data['nombre']} actualizado.");
    }

    public function borrar($id) {
        $temp = $this->ver($id);
        $result = $this->delete(self::tabla, array("id" => $id));
        $this->log("Cliente $id:{$temp['Nombre']} {$temp['Apellido']} borrado.");
        return $result;
    }

    public function insertar($data) {
        $result = $this->insert(self::tabla, $data);
        $this->log("Cliente {$result['insert_id']}:{$temp['Nombre']} {$temp['Apellido']}");
        return $result;
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
