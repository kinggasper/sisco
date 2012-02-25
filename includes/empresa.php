<?php
/**
 * Clase para el manejo de empresas
 *
 * @author anyul
 */
class Empresa extends db implements crud {
    const tabla = "empresa";

    //put your code here
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
        return $this->dame_query("select * from ".self::tabla." where id=".$id);
    }
public function listar() {
        return $this->dame_query("select id, nombre from ".self::tabla);
    }
}

?>
