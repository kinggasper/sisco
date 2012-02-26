<?php

require_once 'constants.php';
$db = new db();
$result = array();

switch ($_GET['accion']) {
    case 'query':
        $result = $db->dame_query("select * from bitacora");
        break;
    case 'clientes_organismo':
        $cliente = new cliente();
        $result = $cliente->clientes_por_organismo($_GET['organismo']);
        break;
    case 'producto_existencia':
        $producto = new producto();
        $result = $producto->disponible($_GET['id']);
        break;
    
    default:
        $result = array("suceed" => false, "error" => "No ha seleccionado ninguna acción");
        break;
}
echo json_encode($result);
?>
