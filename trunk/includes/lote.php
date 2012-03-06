<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lote
 *
 * @author Anyul Rivas
 */
class lote extends db implements crud {
    //put your code here

    const tabla = 'lote';

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
        return $this->select("*", self::tabla);
    }

    public function ver($id) {
        return $this->select("*", self::tabla, array("id" => $id));
    }

}

?>
