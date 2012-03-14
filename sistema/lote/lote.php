<?php

include_once '../../includes/constants.php';
$lote = new lote();
$usuario = new usuario();
$usuario->confirmar_miembro();
if (isset($_POST['enviar'])) {
    $recibos = $lote->generar_lote($_POST['tipo_medio_pago'], $_POST['tipo_cobro'], $_POST['organismo_id'], $_POST['banco_id'], $_SESSION['usuario']);
    if (count($recibos['data']) > 0) {
        // <editor-fold defaultstate="collapsed" desc="Script de generacion de archivo de texto">
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=lote.txt');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        foreach ($recibos['data'] as $fila) {
            echo implode(', ', $fila).PHP_EOL;
        }
        // </editor-fold>
    } else {
        echo "no hay datos que mostrar";
    }
} else {
    echo "no deberias estar aqui.";
}
?>
