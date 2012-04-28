<?php

/**
 * Description of categoria
 *
 * @author anyul
 */
class categoria extends db implements crud {

    const tabla = "categoria";

    public function actualizar($id, $data) {
        return $this->update(self::tabla, $data, array("id" => $id));
        $this->log("Categoria $id:{$data['nombre']} actualizada.");
    }

    public function borrar($id) {
        $temp = $this->ver($id);
        $result = $this->delete(self::tabla, array("id" => $id));
        $this->log("Categoria $id:{$temp['nombre']} borrado.");
        return $result;
    }

    public function insertar($data) {
        $result=$this->insert(self::tabla, $data);
        $this->log("Categoria {$result['insert_id']}:{$data['nombre']} creada.");
        return $result; 
    }

    public function listar() {
        return $this->dame_query("select id, nombre from " . self::tabla);
    }

    public function ver($id) {
        return $this->select("*", self::tabla, array("id" => $id));
    }

}

?>
