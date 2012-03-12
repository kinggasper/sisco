<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$contrato = new contrato();
$empresa = new empresa();
$organismo = new organismo();
$cliente = new cliente();
$usuario = new usuario();
$usuario->confirmar_miembro();
$resultado = array("suceed" => false);
$empresas = $empresa->listar();
$organismos = $organismo->listar();
$estatus = $contrato->dame_query("select * from status_contrato order by id");
$clientes = $cliente->listar();
$frecuencia = $contrato->dame_query("select * from frecuencia");
if (isset($_POST['submit'])) {
    $data = $_POST;
    unset($data['submit']);
    $resultado = $contrato->actualizar($_POST['id'], $data);
} elseif (isset($_GET['id'])) {
    $registro = $contrato->ver($_GET['id']);
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
        <script src="<?php echo ROOT; ?>/js/jquery.ui.datepicker-es.js"></script>
        <script src="<?php echo ROOT; ?>/js/forms.js"></script>
        <script>
	$(function() {
		$( "#datepicker" ).datepicker();
	});
	</script>
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="content">
                <div class="page-header">
                    <h1>Modificar Contrato</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li>Contrato</li>
                </ul>
                <?php if (isset($_POST) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>Contrato editado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Ingrese los datos para modificar un Contrato</p>
                        </div>
                        
                        <div class="span16">
                            <div class="alert-message">
                                <a href="listar.php" class="close">x</a>
                                En Construcci&oacute;n
                            </div>
                            <?php if ($registro['suceed'] && count($registro['data']) > 0): ?>
                                <form method="post" action="">
                                    <?php $dato = $registro['data'][0]; ?>
                                    <fieldset>
                                    <legend>Datos del Contrato</legend>
                                    <div class="clearfix">
                                        <label for="numero">Número:<sup>*</sup></label>
                                        <div class="input">
                                            <input class="required" disabled="true" type="text" name="numero" id="numero"/> 
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="empresa_id">Empresa:<sup>*</sup></label>
                                        <div class="input">
                                            <select class="required" name="empresa_id" disabled="true">
                                                    <?php foreach ($empresas['data'] as $valor): ?>
                                                        <option value="<?php echo $valor['id'] ?>"><?php echo $valor['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="organismo_id">Organismo:<sup>*</sup></label>
                                        <div class="input">
                                            <select name="organismo_id" id="organismo_id" class="required" disabled="true">
                                                        <?php foreach ($organismos['data'] as $valor):?>
                                                    <option value="<?php echo $valor['id']; ?>"><?php echo $valor['nombre'] ?></option>
                                                            <?php endforeach;?>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="status_contrato_id">Estatus:<sup>*</sup></label>
                                        <div class="input">
                                            <select name="status_contrato_id" id="status_contrato_" class="required" disabled="true">
                                                        <?php foreach ($estatus['data'] as $valor):?>
                                                    <option value="<?php echo $valor['id']; ?>"><?php echo $valor['nombre'] ?></option>
                                                            <?php endforeach;?>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="cliente_id">Cliente:<sup>*</sup></label>
                                        <div class="input">
                                            <select name="cliente_id" id="cliente_id" class="required" disabled="true">
                                                        <?php foreach ($clientes['data'] as $valor):?>
                                                    <option value="<?php echo $valor['id']; ?>"><?php echo $valor['Nombre'] ?></option>
                                                            <?php endforeach;?>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="fecha">Fecha:<sup>*</sup></label>
                                        <div class="input">
                                            <input class="required" id="datepicker" name="fecha" type="text" disabled="true">
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="comision">Comisión:<sup>*</sup></label>
                                        <div class="input">
                                            <input type="text" name="comision" id="comision" disabled="ture"/>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="frecuencia">Frecuencia:<sup>*</sup></label>
                                        <div class="input">
                                            <select name="frecuencia" id="frecuencia" class="required" disabled="true">
                                                        <?php foreach ($frecuencia['data'] as $valor):?>
                                                    <option value="<?php echo $valor['id']; ?>"><?php echo $valor['nombre'] ?></option>
                                                            <?php endforeach;?>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label for="numero_cuenta">Dirección:<sup>*</sup></label>
                                        <div class="input">
                                            <input type="text" name="direccion" id="direccion" disabled="true" />
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