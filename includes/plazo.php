<?php

/**
 * Description of plazo
 *
 * @author emessia
 */
class plazo extends db implements crud {

    const tabla = "plazo";

    public function actualizar($id, $data) {
        $result = $this->update(self::tabla, $data, array("id" => $id));
        $this->log("Plazo $id actualizado");
        return $result;
    }

    public function borrar($id) {
        $result = $this->delete(self::tabla, array("id" => $id));
        $this->log("Plazo $id borrado");
        return $result;
    }

    public function insertar($data) {
        $result = $this->insert(self::tabla, $data);
        $this->log("Plazo {$result['insert_id']} creado");
        return $result;
    }

    public function listar() {
        return $this->dame_query("select * from " . self::tabla);
    }

    public function ver($id) {
        return $this->dame_query("select * from " . self::tabla . " where id=" . $id);
    }

}

?>
