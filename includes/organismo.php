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
        $result = $this->dame_query("select id, nombre from " . self::tabla);
        return $result;
    }

    public function configurar_frecuencias($organismo, $frecuencias) {
        $result['suceed'] = false;
        if (is_numeric($organismo)) {
            $borrar_frecuencias = $this->delete("frecuencia_organismo", array("organismo_id" => $organismo));
            if ($borrar_frecuencias['suceed']) {
                foreach ($frecuencias as $frecuencia) {
                    $result = $this->insert("frecuencia_organismo", array(
                        "organismo_id" => $organismo,
                        "frecuencia_id" => $frecuencia));
                }
            }
        }
        return $result;
    }

}

?>
