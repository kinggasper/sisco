<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$usuario = new usuario();
$usuario->confirmar_miembro();
$resultado = array("suceed" => false);
if (isset($_POST['submit'])) {
    $data = $_POST;
    unset($data['clave2']);
    unset($data['submit']);
    $resultado = $usuario->actualizar($_POST['id'], $data);
} elseif (isset($_GET['id'])) {
    $registro = $usuario->ver($_GET['id']);
    $tipos_usuario = $usuario->dame_query("select * from tipo_usuario");
} else {
    $registro = $usuario->ver($_SESSION['usuario']['id']);
    $tipos_usuario = $usuario->dame_query("select * from tipo_usuario");
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
        <script type="text/javascript">
            $(document).ready(function(){
                $("#clave2").rules("add",{
                    equalTo:"#clave",
                    messages:{
                        equalTo:"Por favor repita su clave."
                    }
                });
            });
        </script>
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="content">
                <div class="page-header">
                    <h1>Modificar usuario</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Usuario</a><span class="divider">&raquo;</span></li>
                    <li>Modificar</li>
                </ul>
                <?php if (isset($_POST) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>Usuario editado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                    <?php if (isset($_POST['submit']) && isset($resultado['suceed']) && !$resultado['suceed']): ?>
                        <div class="alert-message block-message error">
                            <a class="close" href="#">×</a>
                            <p>Ha ocurrido un error al modificar el usuario.</p>
                            <?php if (DEBUG): ?>
                                <pre><?php var_dump($resultado); ?></pre>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Ingrese los datos para modificar un usuario</p>
                        </div>
                        <div class="span16">
                            <?php if ($registro['suceed'] && count($registro['data']) > 0): ?>
                                <form method="post" action="">
                                    <?php $dato = $registro['data'][0]; ?>
                                    <fieldset>
                                        <legend>Datos del usuario</legend>
                                        <input type="hidden" name="id" value="<?php echo $dato['id']; ?>"/>
                                        <div class="clearfix">
                                            <label for="nombre">Nombre:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="nombre" id="nombre" value="<?php echo $dato['Nombre']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="login">Login:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="login" id="login" value="<?php echo $dato['login']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="cedula">Cédula:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="cedula" id="cedula" value="<?php echo $dato['cedula']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="telefono">Teléfono:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="telefono" id="telefono" value="<?php echo $dato['telefono']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="correo">Correo:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="correo" id="correo" value="<?php echo $dato['correo']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="clave">Clave:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="password" name="clave" id="clave" value="<?php echo $dato['clave']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="clave2"> Confirme clave:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="password" name="clave2" id="clave2" value="<?php echo $dato['clave']; ?>"/> 
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
                                            <input class="btn primary" type="submit" name="submit" value="Modificar"/>
                                            <input class="btn" type="reset" name="reset" value="Borrar"/>
                                        </div>
                                    </fieldset>
                                </form>
                            <?php else: ?>
                                <div class="alert-message block-message error">
                                    <a href="#" class="close">x</a>
                                    <p>No se pudo cargar el Registro. Intente de nuevo o comun&iacute;quese con el administrador del sistema.</p>
                                    <div class="alert-actions">
                                        <a href="javascript:history.back();" class="btn">Volver Atr&aacute;s</a>
                                    </div>

                                </div>
                            </div>
                        <?php endif; ?>
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
<!--
id	int(11)	NO	PRI	NULL	auto_increment
login	varchar(50)	NO		NULL	
clave	varchar(100)	NO		NULL	
tipo_usuario_id	int(11)	NO	MUL	NULL	
Nombre	varchar(200)	NO		NULL	
cedula	varchar(20)	YES		NULL	
telefono	varchar(20)	YES		NULL	
correo	varchar(100)	YES		NULL	
-->
