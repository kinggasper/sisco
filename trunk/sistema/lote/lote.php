<?php

include_once '../../includes/constants.php';
$lote = new lote();
$usuario = new usuario();
$usuario->confirmar_miembro();

if (isset($_POST['enviar'])) {
    $recibos = $lote->generar_lote($_POST['tipo_medio_pago'], $_POST['tipo_cobro'], $_POST['organismo_id'], $_POST['banco_id'], $_SESSION['usuario']);
    if (count($recibos['detalle']['data']) > 0) {
        // <editor-fold defaultstate="collapsed" desc="Script de generacion de archivo de texto">
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=lote.txt');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $rif = str_replace("-","",$recibos['detalle']['data'][0]['rif']);
        $rif = str_pad($rif,10,'0',STR_PAD_RIGHT);
        $i = 0;
        $total = 0;
        
        foreach ($recibos['detalle']['data'] as $fila) {
            
            $registro[$i] = '02C00'.str_pad($fila['numero_cuenta'],20,'0',STR_PAD_LEFT).str_pad('0',27,'0')
                    .str_pad('0',50,'0').date('d/m/Y').PHP_EOL;
            $total += $fila['monto'];
            $i++;
        }
        $total = str_replace(",", "", $total);
        
        echo '01'.$rif.str_pad($i,10,'0',STR_PAD_LEFT).str_pad($total,13,'0',STR_PAD_LEFT);
        echo date('d/m/Y').str_pad($recibos['lote']['insert_id'],10,'0',STR_PAD_LEFT);
        echo str_pad('0',60,'0',STR_PAD_LEFT).date('d/m/Y').date('d/m/Y').PHP_EOL.PHP_EOL;
        
        for($z=0; $z < $i; $z++) {
            echo $registro[$z];
        }
        // </editor-fold>
    } else {
        echo "no hay datos que mostrar";
    }
} else {
    echo "no deberias estar aqui.";
}
?>
