<?php
// <editor-fold defaultstate="collapsed" desc="init">
include '../../includes/constants.php';
$organismo = new organismo();
$frecuencia = new frecuencia();
$usuario = new usuario();
$usuario->confirmar_miembro();
$frecuencias = $frecuencia->listar();
$frecuencias_organismo = $frecuencia->listar_por_organismo($_GET['id']);
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="procesado">
if (isset($_GET['id'])) {
    $mi_organismo = $organismo->ver($_GET['id']);
}
if (isset($_POST['submit'])) {
    $resultado = $organismo->configurar_frecuencias($mi_organismo['data'][0]['id'], $_POST['frecuencia_id']);
}
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
        <link href="<?php echo ROOT; ?>/css/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
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
                    <h1>Configurar frecuencias <small>por organismo</small></h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Organismo</a><span class="divider">&raquo;</span></li>
                    <li>Configurar Frecuencias</li>
                </ul>
                <div class="row">
                    <div class="span16">
                        <h1>Organismo: <?php echo $mi_organismo['data'][0]['nombre']; ?></h1>
                        <?php if (isset($_POST['submit'])): ?>
                            <?php if ($resultado['suceed'] == true): ?>
                                <div class="alert-message block-message success">
                                    <a class="close" href="#">×</a>
                                    <p>Frecuencias configurada con <strong>&Eacute;xito.</strong></p>
                                    <?php if (DEBUG): ?>
                                        <pre><?php var_dump($resultado); ?></pre>
                                    <?php endif; ?>
                                    <a class="btn small primary" href="listar.php">Volver al listado.</a>
                                    <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                                </div>
                            <?php else: ?>
                                <div class="alert-message block-message error">
                                    <a class="close" href="#">×</a>
                                    <p>Ha ocurrido un error al configurar las frecuencias.</p>
                                    <?php if (DEBUG): ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <form method="post">
                                <fieldset>
                                    <legend>Seleccione las frecuencias para este organismo</legend>
                                    <?php foreach ($frecuencias['data'] as $frecuencia): ?>
                                        <div class="clearfix">
                                            <label for="frecuencia_id[]"><?php echo $frecuencia['nombre']; ?></label>
                                            <div class="input">
                                                <input type="checkbox" name="frecuencia_id[]" value="<?php echo $frecuencia['id']; ?>"
                                                <?php foreach ($frecuencias_organismo['data'] as $frecuencia_organismo): ?>
                                                    <?php echo ($frecuencia['id'] == $frecuencia_organismo['id']) ? "checked='true'" : " "; ?>
                                                <?php endforeach; ?>
                                                       />
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </fieldset>
                                <fieldset>
                                    <div class="actions">
                                        <input class="btn primary" type="submit" name="submit" value="Enviar"/>
                                    </div>
                                </fieldset>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <footer class="footer">
                    <div class="container">
                        <p>&copy; Aled Multimedia Solutions <?php echo date('Y'); ?> </p>
                    </div>
                </footer>
            </div>
    </body>
</html>
