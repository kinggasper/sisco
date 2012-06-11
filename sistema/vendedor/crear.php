<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$vendedor = new vendedor();
$usuario = new usuario();
$usuario->confirmar_miembro();
$resultado = array("suceed" => false);
if (isset($_POST['submit'])) {
    $data = $_POST;
    unset($data['submit']);
    $resultado = $vendedor->insertar($data);
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
                    <h1>Crear Vendedor</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Vendedor</a><span class="divider">&raquo;</span></li>
                    <li>Crear</li>
                </ul>
                <?php if (isset($_POST) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>Vendedor creado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small primary" href="listar.php">Volver al listado.</a>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Ingrese los datos para crear un Vendedor</p>
                        </div>
                        <div class="span16">
                            <form method="post" action="">
                                <input type="hidden" name="empresa_id" value="<?php echo $_SESSION['usuario']['empresa_id']; ?>"/>
                                <fieldset>
                                    <legend>Datos del Vendedor</legend>
                                    <div class="clearfix">
                                        <label for="nombre">Nombre:<sup>*</sup></label>
                                        <div class="input">
                                            <input class="required" type="text" name="nombre" id="nombre"/> 
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="rif">Teléfono 1:<sup>*</sup></label>
                                        <div class="input">
                                            <input class="required" type="text" name="telefono_1" id="telefono_1"/>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="rif">Teléfono 2:</label>
                                        <div class="input">
                                            <input type="text" name="telefono_2" id="telefono_2"/>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="numero_cuenta">E-mail:</label>
                                        <div class="input">
                                            <input type="text" name="email" id="email" />
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="numero_cuenta">Dirección:</label>
                                        <div class="input">
                                            <input type="text" name="direccion" id="direccion" />
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="comision">Comisión:</label>
                                        <div class="input">
                                            <input type="text" name="comision" id="comision" class="required digits" />
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