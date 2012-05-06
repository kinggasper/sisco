<?php
// <editor-fold defaultstate="collapsed" desc="Traspaso">
require '../../includes/constants.php';
$producto = new producto();
$almacen = new almacen();
$usuario = new usuario();
$usuario->confirmar_miembro();
$almacenes = $almacen->listarPorEmpresa($_SESSION['usuario']['empresa_id']);
if (isset($_GET['producto']) && isset($_GET['almacen'])) {
    $mi_almacen = $almacen->ver($_GET['almacen']);
    $mi_producto = $producto->ver($_GET['producto']);
    $existencia = $almacen->dame_query("select cantidad from producto_almacen where producto_id=" . $mi_producto['data'][0]['id'] .
            " and almacen_id=" . $mi_almacen['data'][0]['id']);
    if (count($existencia['data'] > 0)) {
        $existencia = (int) $existencia['data'][0]['cantidad'];
    }
} else {
    //TODO cargar listado de almacenes y de productos
    //TODO Procesar selección del usuario via ajax en sesión
    //TODO crear pantalla de confirmación de productos
    //TODO traspaso masivo
}
if (isset($_POST['traspasar'])) {
    $resultado = $almacen->traspasar($_POST['producto_id'], $_POST['almacen_origen'], $_POST['almacen_id'], $_POST['cantidad']);
}
// </editor-fold>
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo TITULO; ?> - Traspasar producto</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le styles -->
        <link href="<?php echo ROOT; ?>/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?php echo ROOT; ?>/css/style.css" rel="stylesheet"/>
        <script src="<?php echo ROOT; ?>/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="<?php echo ROOT; ?>/js/jquery-ui-1.8.16.custom.min.js"></script>
        <script src="<?php echo ROOT; ?>/js/jquery-validate/jquery.validate.pack.js"></script>
        <script src="<?php echo ROOT; ?>/js/jquery-validate/localization/messages_es.js"></script>
        <script src="<?php echo ROOT; ?>/js/forms.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#cantidad").rules("add",{
                    min:1,
                    max:<?php echo $existencia; ?>,
                    messages:{
                        min:"Introduzca una cantidad mayor a cero.",
                        max:"Introduzca una cantidad menor a la existencia en este almacen."
                    }
                });
            });
        </script>
    </head>
</head>
<body>
    <?php include TEMPLATE . 'topbar.php'; ?>
    <div class="container">
        <div class="content">
            <div class="page-header">
                <?php if (isset($_GET['producto']) && isset($_GET['almacen'])) : ?>
                    <h1>Traspasar Producto <small><?php echo $mi_producto['data'][0]['nombre']; ?> - <?php echo $mi_almacen['data'][0]['nombre']; ?></small></h1>
                <?php endif; ?>
            </div>
            <ul class="breadcrumb">
                <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                <li><a href="listar.php">Producto</a><span class="divider">&raquo;</span></li>
                <li>Traspasar</li>
            </ul>
            <?php if (isset($_POST['traspasar']) && !$resultado['suceed']): ?>
                <div class="alert-message block-message error">
                    <a class="close" href="#">×</a>
                    <p>Ha ocurrido un error al realizar el traspaso.</p>
                    <?php if (DEBUG): ?>
                        <pre><?php var_dump($resultado); ?></pre>
                    <?php endif; ?>
                </div>
            <?php elseif (isset($_POST['traspasar']) && $resultado['suceed']): ?>
                <div class="alert-message block-message success">
                    <a class="close" href="#">×</a>
                    <p>Traspaso realizado con <strong>&Eacute;xito.</strong></p>
                    <pre>
                        
                    </pre>
                    <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                </div>
            <?php elseif (isset($_GET['producto']) && isset($_GET['almacen']) && is_int($existencia)) : ?>
                <div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <input type="hidden" name="producto_id" value="<?php echo $mi_producto['data'][0]['id']; ?>">
                        <input type="hidden" name="almacen_origen" value="<?php echo $mi_almacen['data'][0]['id']; ?>">
                        <fieldset>
                            <legend>Producto</legend>
                            <div class="clearfix">
                                <label for="producto_origen">Producto Seleccionado</label>
                                <div class="input">
                                    <input type="text" name="producto_origen" value="<?php echo $mi_producto['data'][0]['nombre']; ?>" readonly="true"/>
                                    <input type="text" class="small" name="almacen_origen_texto" value="<?php echo $mi_almacen['data'][0]['nombre']; ?>" readonly="true"/>
                                    <input type="text" class="mini" name="cantidad_origen" value="<?php echo $existencia; ?>" readonly="true"/>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Seleccione Almacen</legend>
                            <div class="clearfix">
                                <label for="almacen_id">Almacen</label>
                                <div class="input">
                                    <select id="almacen_id" name="almacen_id" class="required">
                                        <?php foreach ($almacenes['data'] as $data_almacen) : ?>
                                            <?php if ($data_almacen['id'] != $mi_almacen['data'][0]['id']): ?>
                                                <option value="<?php echo $data_almacen['id'] ?>"><?php echo $data_almacen['nombre']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix">
                                <label for="cantidad">Cantidad</label>
                                <div class="input">
                                    <input id="cantidad" type="text" name="cantidad" class="required mini" value="<?php echo $existencia; ?>"/>
                                </div>
                            </div>
                            <div class="actions">
                                <input class="btn primary" type="submit" name="traspasar" value="Traspasar"/>
                            </div>
                        </fieldset>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert-message block-message error">
                    <a class="close" href="#">×</a>
                    <p>Hubo un error al cargar los datos.</p>
                    <?php if (DEBUG): ?>
                        <pre><?php var_dump($existencia); ?></pre>
                    <?php endif; ?>
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
