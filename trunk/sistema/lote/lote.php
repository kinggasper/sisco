<?php

include_once '../../includes/constants.php';
$lote = new lote();
if (isset($_POST['enviar'])) {
    $recibos = $lote->generar_lote($_POST['tipo_medio_pago_id'], $_POST['tipo_cobro'], $_POST['organismo_id'], $_POST['banco_id']);

    // <editor-fold defaultstate="collapsed" desc="inserto lote">
    $result_lote = $lote->insertar(array(
        "usuario_id" => $_SESSION['usuario']['id'],
        "empresa_id" => $_SESSION['usuario']['empresa_id'],
        "tipo_lote_id" => 1));
    if ($result_lote['suceed'] == true && $result_lote['insert_id'] > 0) {
        // <editor-fold defaultstate="collapsed" desc="detalle_lote">
        $result_lote_detalle = array();
        foreach ($recibos['data'] as $recibo) {
            $result_lote_detalle = $this->insertar(array(
                "lote_id" => $result_lote['insert_id'],
                "recibo_id" => $recibo['id']));
            // </editor-fold>
        }
        // </editor-fold>
        if (isset($result_lote_detalle) && isset($result_lote_detalle['suceed']) && $result_lote_detalle['suceed']) {
            // <editor-fold defaultstate="collapsed" desc="Script de generacion de archivo de texto">
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=lote.txt');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            if (count($recibos['data']) > 0) {
                foreach ($recibos['data'] as $fila) {
                    echo implode(', ', $fila);
                }
            }
            // </editor-fold>
        } else {
            echo "no hay datos que mostrar";
        }
        // <editor-fold defaultstate="collapsed" desc="bitacora">
        $bitacora = new bitacora();
        $bitacora->log($_SESSION['usuario']['id'], "Modulo de Lotes");
        exit;
        // </editor-fold>
    }
} else {
    echo "no hay datos que mostrar";
}
?>
