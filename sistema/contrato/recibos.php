<?php
include '../../includes/constants.php';
$usuario = new usuario();
$usuario->confirmar_miembro();
if (isset($_GET['id'])) {
    $recibo = new recibo();
    $recibos = $recibo->recibos_por_contrato($_GET['id']);
}
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
                    <h1>Listar Recibos </h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Recibos</a><span class="divider">&raquo;</span></li>
                    <li>Listar</li>
                </ul>
                <div class="row">
                    <div class="span16">
                        <?php if ($recibos['suceed'] && count($recibos['data']) > 0): ?>
                            <table class="zebra-striped bordered-table">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                        <th>Status</th>
                                        <th>Tipo Medio de Pago</th>
                                        <th>Operaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recibos['data'] as $registro): ?>
                                        <tr>
                                            <td><?php echo $registro['id']; ?></td>
                                            <td><?php echo misc::date_format($registro['fecha']); ?></td>
                                            <td><?php echo misc::number_format($registro['monto']); ?> Bsf.</td>
                                            <td><?php echo $registro['status_recibo']; ?></td>
                                            <td><?php echo $registro['tipo_medio_pago']; ?></td>
                                            <td>
                                                <a href="../mediopago/recibo.php?id=<?php echo $registro['id']; ?>" class="btn small info" title="Modificar Medio de Pago">Modificar</a>
                                                <?php if ($registro['status_recibo'] == 'Rechazado'): ?>
                                                    <a href="../recibo/cuotas.php?id=<?php echo $registro['id']; ?>" class="btn small info" title="Revisar cuotas pagadas/por cobrar">Cuotas</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert-message">No hay resultados que mostrar</div>
                        <?php endif; ?>
                        <div class="actions">
                            <a href="../contrato/crear.php" class="btn small primary">Crear Contrato</a>
                            <a href="../usuario" class="btn small ">Volver al menu</a>
                        </div>
                    </div>
                    <div class="hide">
                        <h3>Ayuda</h3>
                        <p>Listado de recibos</p>
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