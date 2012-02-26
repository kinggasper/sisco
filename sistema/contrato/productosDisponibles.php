<?php
require '../../includes/constants.php';
$producto = new producto();
$disponible = $producto->disponible($_GET['id']);

if ($disponible['suceed'] == true && count($disponible['data'])>0) {
    echo $disponible['data'][0]['disponible']."|".$disponible['data'][0]['precio_venta'];
} else {
    echo "0|0";
}

?>
