<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$usuario = new usuario();
$usuario->confirmar_miembro();
$cliente = new cliente();
$organismo = new organismo();
$organismos = $organismo->listar();
$resultado = array("suceed" => false);
if (isset($_POST['submit'])) {
    $data = $_POST;
    unset($data['submit']);
    $resultado = $cliente->insertar($data);
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
                    <h1>Crear cliente</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Cliente</a><span class="divider">&raquo;</span></li>
                    <li>Crear</li>
                </ul>
                <?php if (isset($_POST) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>cliente creado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small primary" href="listar.php">Volver al listado.</a>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                <?php if(isset($_POST['submit'])&& isset($resultado['suceed']) && !$resultado['suceed']): ?>
                <div class="alert-message block-message error">
                        <a class="close" href="#">×</a>
                        <p>Ha ocurrido un error al registrar el cliente.</p>
                        <?php if(DEBUG):?>
                        <pre><?php var_dump($resultado); ?></pre>
                        <?php endif; ?>
                </div>
                <?php endif; ?>
                    <div class="row">
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Ingrese los datos para crear un cliente</p>
                        </div>
                        <div class="span16">
                            <form method="post" action="">
                                 <fieldset>
                                        <legend>Datos del cliente</legend>
                                        <div class="clearfix">
                                            <label for="nombre">Nombre:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="nombre" id="nombre"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="apellido">apellido:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="apellido" id="apellido"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="nacionalidad">nacionalidad:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required mini" type="text" name="nacionalidad" id="nacionalidad"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="cedula">cedula:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required digits" type="text" name="cedula" id="cedula"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="email">email:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required email" type="text" name="email" id="email"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="telefono_local">telefono local:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required digits" type="text" name="telefono_local" id="telefono_local"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="telefono_trabajo">telefono trabajo:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required digits" type="text" name="telefono_trabajo" id="telefono_trabajo"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="direccion">direccion:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="direccion" id="direccion"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="cargo">cargo:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="cargo" id="cargo"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="departamento">departamento:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="departamento" id="departamento"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="organismo_id">organismo:<sup>*</sup></label>
                                            <div class="input">
                                                <select name="organismo_id" id="organismo_id" class="required">
                                                        <?php foreach ($organismos['data'] as $valor):?>
                                                    <option value="<?php echo $valor['id']; ?>"><?php echo $valor['nombre'] ?></option>
                                                            <?php endforeach;?>
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