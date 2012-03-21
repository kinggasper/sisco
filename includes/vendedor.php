<?php

/**
 * Clase para el manejo de los vendedores
 *
 * @author emessia
 */
class vendedor extends db implements crud {

    const tabla = "vendedor";

    public function actualizar($id, $data) {
        $result = $this->update(self::tabla, $data, array("id" => $id));
        $this->log("Vendedor $id {$data['Nombre']} actualizado");
        return $result;
    }

    public function borrar($id) {
        $temp = $this->ver($id);
        $result = $this->delete(self::tabla, array("id" => $id));
        $this->log("Vendedor $id {$temp['Nombre']} borrado");
        return $result;
    }

    public function insertar($data) {
        $result = $this->insert(self::tabla, $data);
        $this->log("Vendedor {$data['Nombre']} creado ");
        return $result;
    }

    public function listar() {
        return $this->dame_query("select id, nombre from " . self::tabla);
    }

    public function ver($id) {
        return $this->dame_query("select * from " . self::tabla . " where id=" . $id);
    }

    public function vendedor_por_empresa($empresa) {
        return $this->dame_query("select * from " . self::tabla . " where empresa_id=" . $empresa);
    }

}

?>
