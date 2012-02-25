<?php
include_once 'includes/constants.php';
$almacen = new almacen();
$productos_faltantes = $almacen->verificar_existencias()
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> Test </title>
    </head>
    <body>
        <?php
        var_dump(misc::account_format("12345678901234567890"));
        ?>
    </body>
</html>
