<?php

/**
 * Gestión de Productos
 *
 * @author anyul
 */
class producto extends db implements crud {

    const tabla = "producto";

    public function actualizar($id, $data) {
        $result = $this->update(self::tabla, $data, array("id" => $id));
        $this->log("Producto $id:{$data['nombre']} actualizado");
        return $result;
    }

    public function borrar($id) {
        $temp = $this->ver($id);
        $result = $this->delete(self::tabla, array("id" => $id));
        $this->log("Producto {$temp['nombre']} borrado");
        return $result;
    }

    public function insertar($data) {
        $result = $this->insert(self::tabla, $data);
        $this->log("Producto {$result['insert_id']}:{$data['nombre']} creado");
        return $result;
    }

    public function ver($id) {
        $query = "select producto.*, categoria.nombre categoria, empresa.nombre empresa 
            from producto 
            inner join categoria on producto.categoria_id = categoria.id
            inner join empresa on producto.empresa_id = empresa.id 
            where producto.id = ";
        return $this->dame_query($query . $id);
    }

    public function listar() {
        return $this->dame_query("select id, nombre, cantidad_minima from " . self::tabla);
    }

    /**
     * Traspasa una cantidad de productos de un almacen a otro
     * @param Integer $producto
     * @param Integer $almacen
     * @param Integer $cantidad 
     * @return mixed
     */
    public function traspasar($producto, $almacen, $cantidad) {
        return $this->update($tabla, $datos, $condicion);
    }

    public function productosConExistencia() {
        return $this->dame_query("SELECT DISTINCT id, nombre 
        FROM producto p
        inner join producto_almacen pa on pa.producto_id = p.id
        where pa.cantidad > 0 ");
    }

    public function disponible($id) {
        return $this->dame_query("SELECT sum(pa.cantidad) as disponible, p.precio_venta
            FROM producto p
            inner join producto_almacen pa on pa.producto_id = p.id
            where pa.cantidad > 0 and p.id=" . $id);
    }

}

?>
