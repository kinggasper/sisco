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
        $result = $this->update(self::tabla, $data, array("id" => $id));
        $this->log("Empresa $id:{$data['nombre']} actualizada.");
        return $result;
    }

    public function borrar($id) {
        $temp = $this->ver($id);
        $result = $this->delete(self::tabla, array("id" => $id));
        $this->log("Empresa $id:{$temp['nombre']} borrada");
        return $result;
    }

    public function insertar($data) {
        $result = $this->insert(self::tabla, $data);
        $this->log("Empresa {$result['insert_id']}:{$data['nombre']} creada.");
        return $result;
    }

    public function ver($id) {
        return $this->dame_query("select * from " . self::tabla . " where id=" . $id);
    }

    public function listar() {
        return $this->dame_query("select id, nombre from " . self::tabla);
    }

}

?>
