<?php

/**
 * Manejo de Organismos
 *
 * @author Anyul Rivas
 */
class organismo extends db implements crud {

    const tabla = "organismo";

    public function actualizar($id, $data) {
        $result = $this->update(self::tabla, $data, array("id" => $id));
        $this->log("Organismo $id actualizado ");
        return $result;
    }

    public function borrar($id) {
        $result = $this->delete(self::tabla, array("id" => $id));
        $this->log("Organismo $id borrado.");
        return $result;
    }

    public function insertar($data) {
        $result = $this->insert(self::tabla, $data);
        $this->log("Organismo {$result['insert_id']}:{$data['nombre']}");
        return $result;
    }

    public function ver($id) {
        return $this->select("*", self::tabla, array("id" => $id));
    }

    public function listar() {
        return $this->dame_query("select id, nombre from " . self::tabla);
    }

}

?>
