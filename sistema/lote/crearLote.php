<?php
include_once '../../includes/constants.php';
$usuario = new usuario();
$usuario->confirmar_miembro();
$resultado=array("suceed"=>true);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo TITULO; ?></title>
        <link href="<?php echo ROOT; ?>/css/bootstrap.min.css" rel="stylesheet" media="all"/>
        <link href="<?php echo ROOT; ?>/css/style.css" rel="stylesheet" media="all"/>
        <script type="text/javascript" src="<?php echo ROOT; ?>/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="<?php echo ROOT; ?>/js/jquery-ui-1.8.16.custom.min.js"></script>
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="content">
                <div class="page-header">
                    <h1>Crear Lote</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Organismo</a><span class="divider">&raquo;</span></li>
                    <li>Crear</li>
                </ul>
                <?php if (isset($_POST) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>Organismo creado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small primary" href="listar.php">Volver al listado.</a>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                    <?php if (isset($_POST['submit']) && isset($resultado['suceed']) && !$resultado['suceed']): ?>
                        <div class="alert-message block-message error">
                            <a class="close" href="#">×</a>
                            <p>Ha ocurrido un error al registrar el organismo.</p>
                            <?php if (DEBUG): ?>
                                <pre><?php var_dump($resultado); ?></pre>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="row">
                    <div class="span12">
                        <form>
                            <fieldset>
                                <legend>Crear Lote</legend>
                            </fieldset>
                            <fieldset>
                                <div class="actions">
                                    <input type="submit" class="btn primary" name="enviar" value="Generar"/>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <footer>
                <p>&copy; Aled Multimedia Solutions 2011</p>
            </footer>
        </div>
    </body>
</html>
