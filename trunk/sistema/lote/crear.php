<?php
// <editor-fold defaultstate="collapsed" desc="php">
include_once '../../includes/constants.php';
$usuario = new usuario();
$usuario->confirmar_miembro();
$resultado = array("suceed" => true);
$banco = new banco();
$organismo = new organismo();
$mediopago = new mediopago();
$organismos = $organismo->listar();
$bancos = $banco->listar();
$tipos_medio_pago = $mediopago->listar_tipo_medio_pagos();
// </editor-fold>
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
        <script type="text/javascript" src="<?php echo ROOT; ?>/js/forms.js"></script>
        <script type="text/javascript" src="<?php echo ROOT; ?>/js/jquery-validate/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo ROOT; ?>/js/jquery-validate/localization/messages_es.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#tipo_medio_pago").change(function(){
                    if($(this).val()==1){//nomina
                        $("#organismo_id").addClass("required").closest(".clearfix").show();
                        $("#banco_id").removeClass("required").closest(".clearfix").hide();
                    }else{//banco
                        $("#banco_id").addClass("required").closest(".clearfix").show();
                        $("#organismo_id").removeClass("required").closest(".clearfix").hide();
                    }
                }).trigger("change");
            });
        </script>
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
                    <li><a href="listar.php">Lote</a><span class="divider">&raquo;</span></li>
                    <li>Crear</li>
                </ul>
                <?php if (isset($_POST['enviar']) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>Lote creado con <strong>&Eacute;xito.</strong></p>
                        <p>En unos segundos se descargara el archivo</p>
                        <a class="btn small primary" href="listar.php">Volver al listado.</a>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                    <?php if (isset($_POST['submit']) && isset($resultado['suceed']) && !$resultado['suceed']): ?>
                        <div class="alert-message block-message error">
                            <a class="close" href="#">×</a>
                            <p>Ha ocurrido un error al crear el lote.</p>
                            <?php if (DEBUG): ?>
                                <pre><?php var_dump($resultado); ?></pre>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="row">
                    <div class="span16">
                        <form method="post">
                            <fieldset>
                                <legend>Crear Lote</legend>
                                <div class="clearfix">
                                    <label for="tipo_medio_pago">Tipo de Medio de Pago</label>
                                    <div class="input">
                                        <select id="tipo_medio_pago" name="tipo_medio_pago" class="required">
                                            <?php foreach ($tipos_medio_pago['data'] as $tipo_medio_pago): ?>
                                                <option value="<?php echo $tipo_medio_pago['id']; ?>"><?php echo $tipo_medio_pago['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <label for="tipo_cobro">Tipo de Cobro</label>
                                    <div class="input">
                                        <select id="tipo_cobro" name="tipo_cobro" class="required">
                                            <option>Pendientes</option>
                                            <option>Rechazadas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <label for="organismo_id">Organismo</label>
                                    <div class="input">
                                        <select id="organismo_id" name="organismo_id" >
                                            <?php foreach ($organismos['data'] as $organismo) : ?>
                                                <option value="<?php echo $organismo['id'] ?>"><?php echo $organismo['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <label for="banco_id">Banco</label>
                                    <div class="input">
                                        <select id="banco_id" name="banco_id">
                                            <?php foreach ($bancos['data'] as $banco) : ?>
                                                <option value="<?php echo $banco['id'] ?>"><?php echo $banco['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="actions">
                                    <input type="submit" class="btn primary" name="enviar" value="Generar"/>
                                    <a href="listar.php" class="btn">Volver al menú</a>
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
