<?php

/**
 * Frecuencia
 *
 * @author Edgar
 */
class producto extends db implements crud {
    const tabla = "frecuencia";

    public function actualizar($id, $data) {
        return $this->update(self::tabla, $data, array("id"=>$id));
    }

    public function borrar($id) {
        return $this->delete(self::tabla, array("id"=>$id));
    }

    public function insertar($data) {
        return $this->insert(self::tabla, $data);
    }

    public function ver($id) {
        $query = "";
        return $this->dame_query($query.$id);
    }
    public function listar() {
        return $this->dame_query("select id, nombre from ".self::tabla);
    }
   
}

?>
