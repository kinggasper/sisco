<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$producto = new producto();
$empresa = new Empresa();
$usuario = new usuario();
$categoria = new categoria();
$usuario->confirmar_miembro();
$categorias = $categoria->listar();
$resultado = array("suceed" => false);
if (isset($_POST['submit'])) {
    $data = $_POST;
    unset($data['submit']);
    $resultado = $producto->insertar($data);
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
                    <h1>Crear producto</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Producto</a><span class="divider">&raquo;</span></li>
                    <li>Crear</li>
                </ul>
                <?php if (isset($_POST) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>producto creado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small primary" href="listar.php">Volver al listado.</a>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                <?php if(isset($_POST['submit'])&& isset($resultado['suceed']) && !$resultado['suceed']): ?>
                <div class="alert-message block-message error">
                        <a class="close" href="#">×</a>
                        <p>Ha ocurrido un error al registrar el producto.</p>
                        <?php if(DEBUG):?>
                        <pre><?php var_dump($resultado); ?></pre>
                        <?php endif; ?>
                </div>
                <?php endif; ?>
                    <div class="row">
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Ingrese los datos para crear un producto</p>
                        </div>
                        <div class="span16">
                            <form method="post" action="">
                                <input type="hidden" name="empresa_id" value=" <?php echo $_SESSION['usuario']['empresa_id']; ?>"/>
                                <fieldset>
                                        <legend>Datos del producto</legend>
                                        <div class="clearfix">
                                            <label for="codigo">Código:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="codigo" id="nombre"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="nombre">Nombre:<sup>*</sup></label>
                                            <div class="input">
                                                <input class="required" type="text" name="nombre" id="nombre"/> 
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
                                                <input class="required digit" type="text" name="precio_venta" id="precio_venta"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="precio_6">Precio de Venta: <br/><i>(6 meses)</i></label>
                                            <div class="input">
                                                <input class="required digit" type="text" name="precio_6" id="precio_6"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="precio_12">Precio de Venta: <br/><i>(12 meses)</i></label>
                                            <div class="input">
                                                <input class="required digit" type="text" name="precio_12" id="precio_12" /> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="precio_18">Precio de Venta: <br/><i>(18 meses)</i></label>
                                            <div class="input">
                                                <input class="required digit" type="text" name="precio_18" id="precio_18"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="cantidad_minima">Cantidad Minima:</label>
                                            <div class="input">
                                                <input class="required digit" type="text" name="cantidad_minima" id="cantidad_minima"/> 
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="observacion">Observaciones:</label>
                                            <div class="input">
                                                <textarea name="observacion" id="observacion"></textarea>
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