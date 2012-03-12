<?php
//<editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$recibo = new recibo();
if (isset($_GET['recibo'])) {
    $dato = $recibo->ver($_GET['recibo']);
    if (count($dato['data']) > 0) {
        $dato = $dato['data'][0];
    }
}
if (isset($_POST['submit'])) {
    $resultado = $recibo->segmentar_recibo($_POST['recibo_id'], $_POST['monto'], $_POST['cuotas']);
}
//</editor-fold>
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
        <script src="<?php echo ROOT; ?>/js/jquery-ui-1.8.16.custom.min.js"></script>
        <script src="<?php echo ROOT; ?>/js/jquery-validate/jquery.validate.pack.js"></script>
        <script src="<?php echo ROOT; ?>/js/jquery-validate/localization/messages_es.js"></script>
        <script src="<?php echo ROOT; ?>/js/forms.js"></script>
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
                    <li>Segmentar</li>
                </ul>
                <?php if (isset($_POST['submit']) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>Recibo segmentado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small primary" href="listar.php">Volver al listado.</a>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                    <?php if (isset($_POST['submit']) && isset($resultado['suceed']) && !$resultado['suceed']): ?>
                        <div class="alert-message block-message error">
                            <a class="close" href="#">×</a>
                            <p>Ha ocurrido un error al segmentar el recibo.</p>
                            <?php if (DEBUG): ?>
                                <pre><?php var_dump($resultado); ?></pre>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="span16">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="recibo_id" value="<?php echo $dato['id']; ?>"/>
                                <div class="clearfix">
                                    <label>fecha</label>
                                    <div class="input">
                                        <input class="small" type="text" name="fecha" value="<?php echo Misc::date_format($dato['fecha']); ?>" readonly="true"/>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <label>Monto</label>
                                    <div class="input">
                                        <input class="small" type="text" name="monto" value="<?php echo $dato['monto'] ?>" readonly="true"/> Bsf.
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <label>Cuotas</label>
                                    <div class="input">
                                        <select class="required input-small" name="cuotas">
                                            <option value="">Seleccione</option>
                                            <?php for ($index = 0; $index <= 20; $index+=5) : ?>
                                                <?php if ($index != 0): ?>
                                                    <option value="<?php echo $index; ?>"><?php echo $index; ?></option>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="actions">
                                    <input class="btn primary" type="submit" name="submit" value="Segmentar"/>
                                </div>
                            </form>
                        </div>
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Listado de organismos que emiten contratos</p>
                        </div>
                    </div>
                <?php endif; ?>
                <footer class="footer">
                    <div class="container">
                        <p>&copy; Aled Multimedia Solutions <?php echo date('Y'); ?> </p>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>