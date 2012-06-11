<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$usuario = new usuario();
$usuario->confirmar_miembro();
$banco = new banco();
$resultado = array("suceed" => false);
if (isset($_POST['submit'])) {
    $data = $_POST;
    unset($data['submit']);
    $resultado = $banco->insertar($data);
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
                    <h1>Crear banco</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">banco</a><span class="divider">&raquo;</span></li>
                    <li>Crear</li>
                </ul>
                <?php if (isset($_POST) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>banco creado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small primary" href="listar.php">Volver al listado.</a>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                <?php if(isset($_POST['submit'])&& isset($resultado['suceed']) && !$resultado['suceed']): ?>
                <div class="alert-message block-message error">
                        <a class="close" href="#">×</a>
                        <p>Ha ocurrido un error al registrar el banco.</p>
                        <?php if(DEBUG):?>
                        <pre><?php var_dump($resultado); ?></pre>
                        <?php endif; ?>
                </div>
                <?php endif; ?>
                    <div class="row">
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Ingrese los datos para crear un banco</p>
                        </div>
                        <div class="span16">
                            <form method="post" action="">
                                <fieldset>
                                    <legend>Datos del banco</legend>
                                    <div class="clearfix">
                                        <label for="nombre">Nombre:<sup>*</sup></label>
                                        <div class="input">
                                            <input class="required" type="text" name="nombre" id="nombre"/> 
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="numero_cuenta">C&oacute;digo:</label>
                                        <div class="input">
                                            <input type="text" name="codigo" id="codigo" class="required"/>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="web">Web:</label>
                                        <div class="input">
                                            <input type="text" name="web" id="web" class="required"/>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="actions">
                                        <input class="btn primary" type="submit" name="submit" value="Crear"/>
                                        <input class="btn" type="reset" name="reset" value="Borrar"/>
                                    </div>
                                </fieldset>
                            </form>
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