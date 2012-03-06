<?php
include_once '../../includes/constants.php';
$lote = new lote();
$recibo = new recibo();
if (isset($_POST[''])) {
$recibos = $recibo->dame_query("
    select * from recibo 
        inner join contrato on contrato.id = recibo.contrato_id
            where contrato.status_contrato_id=1 and status_recibo_id = 1 and recibo.fecha <= CURRENT_TIMESTAMP
");    
    // <editor-fold defaultstate="collapsed" desc="inserto lote">
    $data = array(
        "usuario_id" => $_SESSION['usuario']['id'],
        "empresa_id" => $_SESSION['usuario']['empresa_id'],
        "tipo_lote_id" => $_POST['tipo_lote_id']);
    $result_lote = $lote->insertar($data);
    if ($result_lote['suceed'] == true && $result_lote['insert_id'] > 0) {
        // <editor-fold defaultstate="collapsed" desc="detalle_lote">
        $result_lote_detalle = array();
        foreach ($recibos['data'] as $recibo) {
            $data_recibo = array(
                "lote_id" => $result_lote['insert_id'],
                "recibo_id" => $recibo['id']);
            $result_lote_detalle = $this->insertar($data_recibo);
            // </editor-fold>
        }
        // </editor-fold>

        if ($result_lote_detalle['suceed']) {
            // <editor-fold defaultstate="collapsed" desc="Script de generacion de archivo de texto">
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=lote.txt');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            Echo "prueba";
            exit;
            // </editor-fold>
            // <editor-fold defaultstate="collapsed" desc="bitacora">
            $bitacora = new bitacora();
            $bitacora->log($_SESSION['usuario']['id'], "Modulo de Lotes");
            // </editor-fold>
        }
    }
} else {
    
}
?>
