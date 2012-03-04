<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$mediopago = new mediopago();
$usuario = new usuario();
$usuario->confirmar_miembro();
$cliente = new cliente();
$tipos_medio_pago = $mediopago->listar_tipo_medio_pagos();
$bancos = $mediopago->select("*", "banco");
$resultado = array("suceed" => false);
if (isset($_GET['usuario'])) {
    $usuario_temp = $cliente->ver($_GET['usuario']);
    $usuario_temp = $usuario_temp['data'][0];
}
if (isset($_POST['submit'])) {
    $data = $_POST;
    unset($data['submit']);
    $resultado = $mediopago->insertar($data);
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
                $("#banco_id").rules('add',{
                   required: function(){ return ($("#tipo_medio_pago_id").val()==2)},
                   messages:{
                       required:"Debe seleccionar un banco para este tipo de medio de pago"
                   }
                });
                $("#numero_cuenta").rules('add',{
                    required: function(){ return ($("#tipo_medio_pago_id").val()==2)},
                    messages:{
                        required:"Debe agregar un numero de cuenta para este tipo de medio de pago"
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
                    <h1>Crear medio de Pago</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Medios de Pago</a><span class="divider">&raquo;</span></li>
                    <li>Crear</li>
                </ul>
                <?php if (isset($_POST) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>Medio de pago creado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small primary" href="listar.php">Volver al listado.</a>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                    <?php if (isset($_POST['submit']) && isset($resultado['suceed']) && !$resultado['suceed']): ?>
                        <div class="alert-message block-message error">
                            <a class="close" href="#">×</a>
                            <p>Ha ocurrido un error al registrar el medio de pago.</p>
                            <?php if (DEBUG): ?>
                                <pre><?php var_dump($resultado); ?></pre>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Ingrese los datos para crear un medio de pago</p>
                        </div>
                        <div class="span12">
                            <form method="post" action="">
                                <fieldset>
                                    <legend>Datos del Medio de pago</legend>
                                    <div class="clearfix">
                                        <label for="nombre">Tipo:<sup>*</sup></label>
                                        <div class="input">
                                            <select name="tipo_medio_pago_id" class="required" id="tipo_medio_pago_id">
                                                <?php foreach ($tipos_medio_pago['data'] as $tipos): ?>
                                                    <option value="<?php echo $tipos['id']; ?>"> <?php echo $tipos['nombre']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="banco_id">Banco</label>
                                        <div class="input">
                                            <select name="banco_id" id="banco_id">
                                                <?php foreach ($bancos['data'] as $banco): ?>
                                                    <option value=" <?php echo $banco['id']; ?>"><?php echo $banco['nombre']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="numero_cuenta">Numero de Cuenta:</label>
                                        <div class="input">
                                            <input type="text" name="numero_cuenta" id="numero_cuenta"/>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label>Usuario</label>
                                        <div class="input">
                                            <input type="hidden" name="usuario_id" value="<?php echo $usuario_temp['id'] ?>"/>
                                            <input type="text" name="usuario" value="<?php echo $usuario_temp['Nombre']." ".$usuario_temp['Apellido']; ?>" disabled="true"/>
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