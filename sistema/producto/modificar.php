<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$producto = new producto();
$usuario = new usuario();
$usuario->confirmar_miembro();
$resultado = array("suceed" => false);
if (isset($_POST['submit'])) {
    $data = $_POST;
    unset($data['submit']);
    $resultado = $producto->actualizar($_POST['id'], $data);
} elseif (isset($_GET['id'])) {
    $empresas = new empresa();
    $categorias = new categoria();
    $registro = $producto->ver($_GET['id']);
    $empresas = $empresas->listar();
    $categorias = $categorias->listar();
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
                    <h1>Modificar producto</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Producto</a><span class="divider">&raquo;</span></li>
                    <li>Modificar</li>
                </ul>
                <?php if (isset($_POST) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>producto editado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                <?php if(isset($_POST['submit'])&& isset($resultado['suceed']) && !$resultado['suceed']): ?>
                <div class="alert-message block-message error">
                        <a class="close" href="#">×</a>
                        <p>Ha ocurrido un error al modificar el producto.</p>
                        <?php if(DEBUG):?>
                        <pre><?php var_dump($resultado); ?></pre>
                        <?php endif; ?>
                </div>
                <?php endif; ?>
                    <div class="row">
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Ingrese los datos para modificar un producto</p>
                        </div>
                        <div class="span16">
                            <?php if ($registro['suceed'] && count($registro['data']) > 0): ?>
                                <form method="post" action="">
                                    <?php $dato = $registro['data'][0]; ?>
                                    <fieldset>
                                        <legend>Datos del producto</legend>
                                        <input type="hidden" name="id" value="<?php echo $dato['id']; ?>"/>
                                        <div class="clearfix">
                                            <label for="codigo">Código:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="codigo" id="nombre" value="<?php echo $dato['codigo']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="nombre">Nombre:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="nombre" id="nombre" value="<?php echo $dato['nombre']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="empresa">Empresa:<sup>*</sup></label>
                                            <div class="input">
                                                <select class="required" name="empresa_id" id="empresa">
                                                    <?php foreach ($empresas['data'] as $empresa): ?>
                                                    <option value="<?php echo $empresa['id']; ?>"><?php echo $empresa['nombre']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="categoria">Categoria:<sup>*</sup></label>
                                            <div class="input">
                                                <select class="required" name="categoria_id" id="categoria">
                                                    <?php foreach ($categorias['data'] as $categoria): ?>
                                                    <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="precio_venta">Precio de Venta:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required digit" type="text" name="precio_venta" id="precio_venta" value="<?php echo $dato['precio_venta']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="precio_6">Precio de Venta: <br/><i>(6 meses)</i></label>
                                            <div class="input">
                                                <input class="required digit" type="text" name="precio_6" id="precio_6" value="<?php echo $dato['precio_6']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="precio_12">Precio de Venta: <br/><i>(12 meses)</i></label>
                                            <div class="input">
                                                <input class="required digit" type="text" name="precio_12" id="precio_12" value="<?php echo $dato['precio_12']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="precio_18">Precio de Venta: <br/><i>(18 meses)</i></label>
                                            <div class="input">
                                                <input class="required digit" type="text" name="precio_18" id="precio_18" value="<?php echo $dato['precio_18']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="cantidad_minima">Cantidad Minima:</label>
                                            <div class="input">
                                                <input class="required digit" type="text" name="cantidad_minima" id="cantidad_minima" value="<?php echo $dato['cantidad_minima']; ?>"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="observacion">Observaciones:</label>
                                            <div class="input">
                                                <textarea name="observacion" id="observacion"><?php echo $dato['Observacion']; ?></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="actions">
                                            <input class="btn primary" type="submit" name="submit" value="Modificar"/>
                                            <a class="btn info small" title="Verifica la existencia de este producto en los almacenes" href="almacen.php?producto=<?php echo $dato['id']; ?>">Existencia</a>
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