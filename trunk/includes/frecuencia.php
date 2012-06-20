<?php

/**
 * Description of frecuencia
 *
 * @author Edgar Messia
 */
class frecuencia extends db implements crud {

    const tabla = "frecuencia";

    public function actualizar($id, $data) {
        $result = $this->update(self::tabla, $data, array("id" => $id));
        $this->log("Frecuencia $id:{$data['nombre']} actualizada");
        return $result;
    }

    public function borrar($id) {
        $temp = $this->ver($id);
        $result = $this->delete(self::tabla, array("id" => $id));
        $this->log("Frecuencia $id:{$temp['nombre']} borrada.");
        return $result;
    }

    public function insertar($data) {
        $result = $this->insert(self::tabla, $data);
        $this->log("Frecuencia {$result['insert_id']}:{$data['nombre']} creada.");
        return $result;
    }

    public function listar() {
        return $this->select("*", self::tabla);
    }

    public function ver($id) {
        return $this->select("*", self::tabla, array("id" => $id));
    }

    public function listar_por_organismo($organismo) {
        $result = $this->dame_query("select frecuencia.* from frecuencia 
                inner join organismo_frecuencia on frecuencia.id = organismo_frecuencia.frecuencia_id
                and organismo_id = " . $organismo);
        return $result;
    }
}

?>
