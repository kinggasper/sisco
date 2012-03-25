<?php

/**
 * Description of bitacora
 *
 * @author Anyul Rivas
 */
class bitacora extends db implements crud {

    const tabla = 'bitacora';

    public function actualizar($id, $data) {
        return $this->update(self::tabla, $data, array("id" => $id));
    }

    public function borrar($id) {
        return $this->delete(self::tabla, array("id" => $id));
    }

    public function insertar($data) {
        return $this->insert(self::tabla, $data);
    }

    /**
     * inserta un registro en el log de bitacora
     * @param Integer $usuario_id id del usuario
     * @param String $modulo descripcion 
     * @return mixed 
     */
    public function insertar_log($usuario_id, $modulo) {
        return $this->insertar(array("usuario_id" => $usuario_id, "modulo" => $modulo));
    }

    public function ver($id) {
        return $this->select("*", self::tabla, array('id' => $id));
    }

    public function listar() {
        return $this->dame_query("select id, fecha from " . self::tabla);
    }

    public function log($mensaje) {
        return $this->insertar_log(isset($_SESSION['usuario']['id']) ? $_SESSION['usuario']['id'] : 0, $mensaje);
    }

}

?>
