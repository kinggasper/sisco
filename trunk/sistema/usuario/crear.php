<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$usuario = new usuario();
$usuario->confirmar_miembro();
$resultado = array("suceed" => false);
$tipos_usuario = $usuario->dame_query("select * from tipo_usuario");
if (isset($_POST['submit'])) {
    $data = $_POST;
    unset($data['submit']);
    unset($data['clave2']);
    $resultado = $usuario->insertar($data);
    var_dump($resultado);
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
                    <h1>Crear usuario</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Usuario</a><span class="divider">&raquo;</span></li>
                    <li>Crear</li>
                </ul>
                <?php if (isset($_POST) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>usuario creado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small primary" href="listar.php">Volver al listado.</a>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                <?php if(isset($_POST['submit'])&& isset($resultado['suceed']) && !$resultado['suceed']): ?>
                <div class="alert-message block-message error">
                        <a class="close" href="#">×</a>
                        <p>Ha ocurrido un error al registrar el usuario.</p>
                        <?php if(DEBUG):?>
                        <pre><?php var_dump($resultado); ?></pre>
                        <?php endif; ?>
                </div>
                <?php endif; ?>
                    <div class="row">
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Ingrese los datos para crear un usuario</p>
                        </div>
                        <div class="span12">
                            <form method="post" action="">
                                <input type="hidden" name="empresa_id" value="<?php echo $_SESSION['usuario']['empresa_id']; ?>"/>
                                <fieldset>
                                        <legend>Datos del usuario</legend>
                                        <div class="clearfix">
                                            <label for="nombre">Nombre:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="nombre" id="nombre" /> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="login">Login:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="login" id="login" /> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="cedula">Cédula:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="cedula" id="cedula" /> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="telefono">Teléfono:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="telefono" id="telefono"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="correo">Correo:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="correo" id="correo" /> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="clave">Clave:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="password" name="clave" id="clave" /> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="clave2"> Confirme clave:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="password" name="clave2" id="clave2" /> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="tipo_usuario_id">Tipo de Usuario:<sup>*</sup></label>
                                            <div class="input">
                                                <select class="required" name="tipo_usuario_id">
                                                    <?php foreach ($tipos_usuario['data'] as $tipo_usuario): ?>
                                                        <option value="<?php echo $tipo_usuario['id'] ?>"><?php echo $tipo_usuario['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
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