<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$pag = new paginacion();
$usuario = new usuario();
$usuario->confirmar_miembro();
if (isset($_GET['id']))
    $pag->paginar("select cuotas.*, status_recibo.nombre 'status' , recibo.contrato_id
        from cuotas
        inner join status_recibo on cuotas.status_recibo_id = status_recibo.id
        inner join recibo on cuotas.recibo_id = recibo.id
        where recibo_id={$_GET['id']} order by recibo.id ", 5);
$contrato = $pag->registros[0]['contrato_id'];
$cuotas_cobradas = 0;
$cuotas_pendientes = 0;
$monto_cobrado = 0;
$monto_pendiente = 0;
// </editor-fold>
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?php echo TITULO; ?></title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le styles -->
        <link href="<?php echo ROOT; ?>/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?php echo ROOT; ?>/css/style.css" rel="stylesheet"/>
        <script src="<?php echo ROOT; ?>/js/jquery-1.7.1.min.js"></script>
        <script src="<?php echo ROOT; ?>/js/listado.js"></script>
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="content">
                <div class="page-header">
                    <h1>Listar Cuotas por Recibo Rechazado</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Recibo</a><span class="divider">&raquo;</span></li>
                    <li>Listar Cuotas</li>
                </ul>
                <div class="row">
                    <div class="span16">
                        <?php if (count($pag->registros) > 0): ?>
                            <table class="zebra-striped bordered-table">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Monto</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pag->registros as $registro): ?>
                                        <?php
                                        if ($registro['status'] == 'Cobrado') {
                                            $monto_cobrado+=$registro['monto'];
                                            $cuotas_cobradas++;
                                        } else {
                                            $monto_pendiente+=$registro['monto'];
                                            $cuotas_pendientes++;
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $registro['id']; ?></td>
                                            <td><?php echo misc::number_format($registro['monto']); ?> Bsf.</td>
                                            <td><span class="label <?php
                                switch ($registro['status']) {
                                    case 'Rechazado':
                                        echo 'important';
                                        break;
                                    case 'Pendiente':
                                        echo 'warning';
                                        break;
                                    default:
                                        echo 'success';
                                        break;
                                }
                                        ?> "><?php echo $registro['status']; ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <p><span class="label success">Monto Cobrado:</span> <?php echo $monto_cobrado; ?> Bsf. </p>
                                            <p><span class="label important">Monto Pendiente:</span> <?php echo $monto_pendiente; ?> Bsf.</p>
                                        </td>
                                        <td colspan="3">
                                            <p><span class="label success">Total Cuotas Cobradas:</span> <?php echo $cuotas_cobradas; ?></p>
                                            <p><span class="label important">Total Cuotas Pendientes:</span> <?php echo $cuotas_pendientes; ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <?php $pag->mostrar_paginado_lista(); ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php else: ?>
                            <div class="alert-message">No hay resultados que mostrar</div>
                        <?php endif; ?>
                        <div class="actions">
                            <a href="../contrato/recibos.php?id=<? echo $contrato; ?>" class="btn small ">Volver al listado de recibos</a>
                        </div>
                    </div>
                    <div class="hide">
                        <h3>Ayuda</h3>
                        <p>Listado de organismos que emiten contratos</p>
                    </div>
                </div>
                <footer class="footer">
                    <div class="container">
                        <p>&copy; Aled Multimedia Solutions <?php echo date('Y'); ?> </p>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>