<?php
include '../../includes/constants.php';
$organismo = new organismo();
$frecuencia = new frecuencia();
$frecuencias = $frecuencia->listar();
$frecuencias_organismo = $frecuencia->listar_por_organismo($_GET['id']);
if (isset($_GET['id'])) {
    $mi_organismo = $organismo->ver($_GET['id']);
} else {
    echo "seleccione un organismo";
}
if (isset($_POST['enviar'])) {
    $result = $organismo->configurar_frecuencias($mi_organismo['data']['id'], $_POST['frecuencia']);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Configurar frecuencias por organismo</title>
    </head>
    <body>
        <h1>Organismo: <?php echo $mi_organismo['data'][0]['nombre']; ?></h1>
        <?php foreach ($frecuencias['data'] as $frecuencia): ?>
            <p><?php echo $frecuencia['nombre']; ?>
                    <?php foreach ($frecuencias_organismo['data'] as $mi_frecuencia) {
                        if($mi_frecuencia['id']== $frecuencia['id']){
                            echo "check <input type='checkbox' checked='true'/>";
                        } else{
                            echo "no check <input type='checkbox'/>";
                        }
                    } ?>
            </p>
        <?php endforeach; ?>
    </body>
</html>
