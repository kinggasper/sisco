<?php

/**
 * Manejo de Organismos
 *
 * @author Anyul Rivas
 */
class organismo extends db implements crud {

    const tabla = "organismo";

    public function actualizar($id, $data) {
        return $this->update(self::tabla, $data, array("id" => $id));
    }

    public function borrar($id) {
        return $this->delete(self::tabla, array("id" => $id));
    }

    public function insertar($data) {
        return $this->insert(self::tabla, $data);
    }

    public function ver($id) {
        return $this->select("*", self::tabla, array("id" => $id));
    }
public function listar() {
        return $this->dame_query("select id, nombre from ".self::tabla);
    }
}

?>
