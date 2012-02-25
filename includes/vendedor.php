<?php


/**
 * Clase para el manejo de los vendedores
 *
 * @author emessia
 */
class vendedor extends db implements crud {
    const tabla = "vendedor";
    
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
        return $this->dame_query("select id, nombre from ".self::tabla);
    }
    public function ver($id) {
        return $this->dame_query("select * from ".self::tabla." where id=".$id);
    }
    public function vendedor_por_empresa($empresa){
        return $this->dame_query("select * from ".self::tabla." where empresa_id=".$empresa);
        
    }
}

?>
