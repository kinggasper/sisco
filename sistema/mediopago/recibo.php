<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$recibo = new recibo();
$usuario = new usuario();
$usuario->confirmar_miembro();
$mediopago = new mediopago();
if (isset($_GET['id'])) {
    $reciboTemp = $recibo->ver($_GET['id']);
    if (count($reciboTemp['data']) > 0) {
        $registro = $mediopago->ver($reciboTemp['data'][0]['medio_pago_id']);
        $medios_pago_usuario = $mediopago->medios_pago_usuario($registro['data'][0]['usuario_id']);
    }
}
if (isset($_POST['submit'])) {
    $resultado = $recibo->actualizar($_POST['recibo_id'], array("medio_pago_id" => $_POST['medio_pago_id']));
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
                    <h1>Modificar Medio de Pago de Recibo</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Medio de Pago</a><span class="divider">&raquo;</span></li>
                    <li>Modificar</li>
                </ul>
                <?php if (isset($_POST['submit']) && isset($resultado['suceed']) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>Medio de pago modificado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small" href="../contrato/recibos.php?id=<?php echo $reciboTemp['data'][0]['contrato_id']; ?>">Volver al men&uacute;.</a>
                        <?php if (DEBUG): ?>
                            <pre><?php var_dump($resultado); ?></pre>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <?php if (isset($_POST['submit']) && isset($resultado['suceed']) && !$resultado['suceed']): ?>
                        <div class="alert-message block-message error">
                            <a class="close" href="#">×</a>
                            <p>Ha ocurrido un error al modificar el medio de Pago.</p>
                            <?php if (DEBUG): ?>
                                <pre><?php var_dump($resultado); ?></pre>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Ingrese los datos para modificar el medio de Pago del Recibo</p>
                        </div>
                        <div class="span16">
                            <?php if ($reciboTemp['data'][0]['status_recibo'] == "Cobrado"): ?>
                                <div class="alert-message warning">
                                    <a class="close" href="#">×</a>
                                    <p>Este Recibo ha sido cobrado. No se puede modificar el medio de pago</p>
                                </div>
                            <?php endif; ?>
                            <?php if ($registro['suceed'] && count($registro['data']) > 0): ?>
                                <form method="post" action="">
                                    <?php $dato = $registro['data'][0]; ?>
                                    <fieldset>
                                        <legend>Medio de Pago actual</legend>
                                        <input type="hidden" name="id" value="<?php echo $dato['id']; ?>"/>
                                        <input type="hidden" name="usuario_id" value="<?php echo $dato['usuario_id']; ?>"/>
                                        <input type="hidden" name="recibo_id" value="<?php echo $reciboTemp['data'][0]['id']; ?>"/>
                                        <div class="clearfix">
                                            <label for="nombre">Tipo de Medio de Pago:<sup>*</sup></label>
                                            <div class="input">
                                                <input readonly="true" type="text" name="tipo_medio_pago" id="tipo_medio_pago" value="<?php echo $dato['medio_pago']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="rif">Banco:</label>
                                            <div class="input">
                                                <input type="text" readonly="true"name="banco" id="banco" value="<?php echo $dato['banco'] ?>"/>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="numero_cuenta">N&uacute;mero de cuenta:</label>
                                            <div class="input">
                                                <input type="text" readonly="true" name="numero_cuenta" id="numero_cuenta" value="<?php echo $dato['numero_cuenta'] ?>"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <legend>Nuevo Medio de Pago</legend>
                                        <div>
                                            <label for="medio_pago_id">Medio de Pago:</label>
                                            <div class="input">
                                                <select name="medio_pago_id" class="required" id="medio_pago_id" <?php echo ($reciboTemp['data'][0]['status_recibo'] == "Cobrado") ? " disabled='disabled'" : ""; ?>>
                                                    <?php foreach ($medios_pago_usuario['data'] as $mi_medio_pago): ?>
                                                        <option value="<?php echo $mi_medio_pago['id'] ?>" <?php echo ($mi_medio_pago['id'] == $registro['data'][0]['id']) ? "selected='selected'" : ""; ?>><?php echo $mi_medio_pago['medio_pago'] . ": " . $mi_medio_pago['banco'] . " " . $mi_medio_pago['numero_cuenta']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="help-block">Medios de Pago disponibles</span>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="actions">
                                            <input class="btn primary" type="submit" name="submit" value="Modificar"/>
                                            <a href="../mediopago/crear.php?usuario=<?php echo $registro['data'][0]['usuario_id']; ?>" class="btn info">Crear nuevo Medio de Pago</a>
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