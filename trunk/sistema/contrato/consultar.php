<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$contrato = new contrato();
if (isset($_GET['id'])) {
    $registro = $contrato->ver($_GET['id']);
    $productos = $contrato->productos_por_contrato($_GET['id']);
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
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="content">
                <div class="page-header">
                    <h1>Consultar Contrato</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Contrato</a><span class="divider">&raquo;</span></li>
                    <li>Consultar</li>
                </ul>
                <div class="row">
                    <div class="hide">
                        <h3>Ayuda</h3>
                        <p>Ingrese los datos para modificar un Contrato</p>
                    </div>
                    <div class="span16">
                        <?php if (count($registro['data']) > 0): ?>
                            <form method="post" action="">
                                <?php $dato = $registro['data'][0]; ?>
                                <fieldset>
                                    <legend>Datos del Contrato</legend>
                                    <div class="row">
                                        <div class="span8">
                                            <div class="clearfix">
                                                <label for="numero">Número:</label>
                                                <div class="input">
                                                    <input class="small" readonly="true" type="text" name="numero" id="numero" value="<?php echo $dato['numero']; ?>"/> 
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <label for="empresa_id">Empresa:</label>
                                                <div class="input">
                                                    <input readonly="true" type="text" name="empresa" id="empresa" value="<?php echo $dato['empresa']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <label for="organismo_id">Organismo:</label>
                                                <div class="input">
                                                    <input readonly="true" type="text" name="organismo" id="organismo" value="<?php echo $dato['organismo']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <label for="status_contrato_id">Estatus:</label>
                                                <div class="input">
                                                    <input class="small" readonly="true" type="text" name="status" id="status" value="<?php echo $dato['status_contrato']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <label for="cliente_id">Cliente:</label>
                                                <div class="input">
                                                    <input type="text" readonly="true" name="cliente" id="cliente" value="<?php echo $dato['cliente']; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span8">
                                            <div class="clearfix">
                                                <label for="fecha">Fecha:</label>
                                                <div class="input">
                                                    <input class="small" id="datepicker" class="small" name="fecha" type="text" readonly="true" value="<?php echo misc::date_format($dato['fecha']); ?>">
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <label for="comision">Comisión:</label>
                                                <div class="input">
                                                    <input type="text" name="comision" class="small" id="comision" readonly="ture" value="<?php echo Misc::number_format($dato['comision_vendedor']) ?> Bsf"/>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <label for="vendedor">vendedor:</label>
                                                <div class="input">
                                                    <input type="text" name="vendedor" id="vendedor" readonly="ture" value="<?php echo $dato['vendedor']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <label for="frecuencia">Frecuencia:</label>
                                                <div class="input">
                                                    <input type="text" readonly="true" class="small" name="frecuencia" id="frecuencia" value="<?php echo $dato['frecuencia']; ?>"/>
                                                    <span class="help-inline">
                                                        Plazo:
                                                    </span>
                                                    <input type="text" name="plazo" id="plazo" class="small" readonly="true" value="<?php echo $dato['plazo']; ?> Meses" />
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <label>Monto</label>
                                                <div class="input">
                                                    <input class="small" type="text" name="monto" id="monto" value="<?php echo Misc::number_format($dato['monto']); ?> Bsf" readonly="true" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="span16">
                                            <?php if (count($productos['data']) > 0): ?>
                                                <table class="zebra-striped bordered-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Categoria</th>
                                                            <th>Precio</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($productos['data'] as $producto): ?>
                                                            <tr>
                                                                <td><?php echo $producto['nombre']; ?></td>
                                                                <td><?php echo $producto['categoria']; ?></td>
                                                                <td style="text-align: right"><?php echo misc::number_format($producto['precio']); ?> Bsf.</td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td align="right" style="text-align: right" colspan="3">Total <b><?php echo Misc::number_format($dato['monto']); ?> Bsf.</b></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="actions">
                                        <a href="recibos.php?id=<?php echo $_GET['id']; ?>" class="btn primary">Consultar Recibos</a>
                                        <input class="btn info" type="submit" name="submit" value="Modificar"/>
                                        <a href="javascript:history.back()" class="btn">Volver al listado</a>
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
            <footer class="footer">
                <div class="container">
                    <p>&copy; Aled Multimedia Solutions <?php echo date('Y'); ?> </p>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>