<?php

/**
 * Description of plazo
 *
 * @author emessia
 */
class plazo extends db implements crud  {
    const tabla = "plazo";
    
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
        return $this->dame_query("select * from ".self::tabla);
    }
    public function ver($id) {
        return $this->dame_query("select * from ".self::tabla." where id=".$id);
    }
}

?>
