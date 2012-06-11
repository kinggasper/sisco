<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$vendedor = new vendedor();
$empresa = new empresa();
$usuario = new usuario();
$usuario->confirmar_miembro();
$resultado = array("suceed" => false);
$empresas = $empresa->listar();
if (isset($_POST['submit'])) {
    $data = $_POST;
    unset($data['submit']);
    $resultado = $vendedor->actualizar($_POST['id'], $data);
} elseif (isset($_GET['id'])) {
    $registro = $vendedor->ver($_GET['id']);
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
                    <h1>Modificar Vendedor</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Vendedor</a><span class="divider">&raquo;</span></li>
                    <li>Modificar</li>
                </ul>
                <?php if (isset($_POST) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>Vendedor editado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Ingrese los datos para modificar un Vendedor</p>
                        </div>
                        
                        <div class="span16">
                            <?php if ($registro['suceed'] && count($registro['data']) > 0): ?>
                                <form method="post" action="">
                                    <?php $dato = $registro['data'][0]; ?>
                                    <fieldset>
                                    <legend>Datos del Vendedor</legend>
                                    <input type="hidden" name="id" value="<?php echo $dato['id']; ?>"/>
                                    <div class="clearfix">
                                        <label for="nombre">Nombre:<sup>*</sup></label>
                                        <div class="input">
                                            <input class="required" type="text" name="nombre" id="nombre" value="<?php echo $dato['Nombre']; ?>"/> 
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="rif">Teléfono 1:<sup>*</sup></label>
                                        <div class="input">
                                            <input class="required" type="text" name="telefono_1" id="telefono_1" value="<?php echo $dato['telefono_1']; ?>"/>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="rif">Teléfono 2:</label>
                                        <div class="input">
                                            <input type="text" name="telefono_2" id="telefono_2" value="<?php echo $dato['telefono_2']; ?>"/>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="numero_cuenta">Empresa:<sup>*</sup></label>
                                        <div class="input">
                                            <select class="required" name="empresa_id">
                                                    <?php foreach ($empresas['data'] as $inf_empresa):
                                                        $selected = "";
                                                        if ($dato['empresa_id']== $inf_empresa['id']) {
                                                            $selected = "selected='selected'";
                                                        }
                                                        ?>
                                                        <option value="<?php echo $inf_empresa['id'] ?>" <?php echo $selected ?>><?php echo $inf_empresa['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="numero_cuenta">E-mail:</label>
                                        <div class="input">
                                            <input type="text" name="email" id="email" value="<?php echo $dato['email']; ?>"/>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="numero_cuenta">Dirección:</label>
                                        <div class="input">
                                            <input type="text" name="direccion" id="direccion" value="<?php echo $dato['direccion']; ?>"/>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="comision">Comisión:</label>
                                        <div class="input">
                                            <input type="text" name="comision" id="comision" class="required digits" value="<?php echo $dato['comision']; ?>"/>
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
                                        <a href="javascript:history.back();" class="btn">Volver Atr&aacute;s.</a>
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