<?php
include_once 'includes/constants.php';
$almacen = new almacen();
$productos_faltantes = $almacen->verificar_existencias();


// <editor-fold defaultstate="collapsed" desc="Recibos Semanales">
function recibosSemanales($plazo) {
    $n = 0;
    $fecha_inicio = time();
    $fecha_inicio = strtotime('Next Friday', time());
    $fecha_fin = strtotime("+" . $plazo . "month", $fecha_inicio);
    echo "Fecha Inicio: " . date('d-m-Y', $fecha_inicio) . "<br>";
    echo "Fecha Fin: " . date('d-m-Y', $fecha_fin);

    while ($fecha_inicio < $fecha_fin) {
        echo "<br>" . date('d-m-Y', $fecha_inicio);
        $fecha_inicio = strtotime("+1 week", $fecha_inicio);
         echo "<br>Menor.";
        $n++;
    }
    echo "<br>" . $n . " recibos generados.";
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Recibos Quincenales">
function recibosQuincenales($plazo, $tipo_quincena) {
    $n = 0;
    $fecha_inicio = time();
    $q1 = $tipo_quincena == 3 ? '10' : '15';
    $q2 = $tipo_quincena == 3 ? '25' : 't';
    //$fecha_inicio = strtotime(time());
    $fecha_fin = strtotime("+" . $plazo . "month", $fecha_inicio);
    echo "Fecha Inicio: " . date('d-m-Y', $fecha_inicio) . "<br>";
    echo "Fecha Fin: " . date('d-m-Y', $fecha_fin);
    echo "<br>Primer dia del mes: " . date('d-m-Y', strtotime("Last day", $fecha_inicio));
    //$fecha_inicio < $fecha_fin
    while ($fecha_inicio <= $fecha_fin) {
        //primera quincena
        $fecha_recibo = strtotime(date($q1 . '-m-Y', $fecha_inicio));
        if ($fecha_recibo >= time() && $fecha_recibo <= $fecha_fin) {
            $n++;
            echo "<br>" . date('d-m-Y', $fecha_recibo);
        }

        //segunda quincena
        $fecha_recibo = strtotime(date($q2 . '-m-Y', $fecha_inicio));
        if ($fecha_recibo >= time() && $fecha_recibo <= $fecha_fin) {
            $n++;
            echo "<br>" . date('d-m-Y', $fecha_recibo);
        }
        $fecha_inicio = strtotime("+1 month", $fecha_inicio);
    
    }
    echo "<br>" . $n . " recibos generados.";
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Recibos Mensuales">
function recibosMensuales($plazo) {
    $recibo = new recibo();
    $n = 0;
    $fecha_inicio = time();
    $fecha_fin = strtotime("+" . $plazo . "month", $fecha_inicio);
    echo "Fecha Inicio: " . date('d-m-Y', $fecha_inicio) . "<br>";
    echo "Fecha Fin: " . date('d-m-Y', $fecha_fin);
    while ($fecha_inicio < $fecha_fin) {
//        echo "<br>" . date('Y-m-t 00:00:00', $fecha_inicio);
        $resultado = $recibo->insertar(
                Array(
                    "cliente_id" => 2,
                    "contrato_id" => 12,
                    "monto" => 0,
                    "fecha" => date('Y-m-t 00:00:00', $fecha_inicio),
                    "status_recibo_id" => 1,
                    "medio_pago_id" => 1
                    ));
        echo "<br>".$resultado['suceed'];
        $fecha_inicio = strtotime("+1 month", $fecha_inicio);
        $n++;
    }
    echo "<br>" . $n . " recibos generados.";
}

// </editor-fold>

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> Test </title>
    </head>
    <body>
        <?php
        //var_dump(misc::account_format("12345678901234567890"));
        //echo "<br>".date('j-m-Y', strtotime('Next Friday',time()));
        //for ($i=0; $i<5; $i++) {
            //echo "<br>".$i;
            //echo "<br>".date('t-m-Y',strtotime("+".$i." Month" ,time()));
        //}
        //echo "Recibos Semanales:<br>-------------------------<br>";
        //recibosSemanales(1);
        //echo "Recibos Quincenales:<br>-------------------------<br>";
        //recibosQuincenales(4,3);
        //echo "Recibos Semalanales:<br>-------------------------<br>";
        $contrato = new contrato();
        //$resultado = $contrato->generarRecibos(1, 18, 1, 12);
        if ($contrato->contratoRecibosPagados(28)) {
            echo "si";
        } else {
            echo "no";
        }
        
        ?>
        
    </body>
</html>
