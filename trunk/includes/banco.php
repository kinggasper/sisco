<?php

/**
 * clase Banco
 *
 * @author Anyul Rivas
 */
class banco extends db implements crud {

    const tabla = 'banco';

    public function actualizar($id, $data) {
        $result = $this->update(self::tabla, $data, array("id" => $id));
        $this->log(" Banco $id:{$data['nombre']} actualizado.");
        return $result;
    }

    public function borrar($id) {
        $temp_banco = $this->ver($id);
        $result = $this->delete(self::tabla, array("id" => $id));
        $this->log("Usuario $id:{$temp_banco['nombre']} borrado.");
        return $result;
    }

    public function insertar($data) {
        $result = $this->insert(self::tabla, $data);
        return $result;
        $this->log("Banco {$result['insert_id']}:{$data['nombre']} creado");
    }

    public function listar() {
        return $this->dame_query("select id, nombre from " . self::tabla);
    }

    public function ver($id) {
        return $this->select("*", self::tabla, array('id' => $id));
    }

}

?>
