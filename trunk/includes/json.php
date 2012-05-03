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
    case 'agregar_medio_pago':
        $medio_pago = new mediopago();
        if ($_GET['tipo_medio_pago_id']==1) {
            $data=Array("tipo_medio_pago_id"=>$_GET['tipo_medio_pago_id'],
                "usuario_id"=>$_GET['usuario_id']);
        } else {
            $data = Array("tipo_medio_pago_id"=>$_GET['tipo_medio_pago_id'],
                "banco_id"=>$_GET['banco_id'],
                "numero_cuenta"=>$_GET['numero_cuenta'],
                "usuario_id"=>$_GET['usuario_id']);    
        }
        $result = $medio_pago->insertar($data);
        break;
    case 'listar_medio_pago':
        $medio_pago = new mediopago();
        $result = $medio_pago->medios_pago_usuario($_GET['cliente']);
        break;
    case 'calcular_numero_cuotas':
        $contrato = new contrato();
        $result = $contrato->obtenerNumeroDeCuotas($_GET['frecuencia_id'], $_GET['plazo_id']);
        break;
    default:
        $result = array("suceed" => false, "error" => "No ha seleccionado ninguna acción");
        break;
}
echo json_encode($result);
?>
