<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
//require '../../includes/paginacion.php';
$pag = new paginacion();
$producto = new producto();
$usuario = new usuario();
$usuario->confirmar_miembro();
if (isset($_GET['producto'])) {
    $producto = $producto->ver($_GET['producto']);
    $pag->paginar("select almacen.id, almacen.nombre,
        producto_almacen.cantidad,
        producto_almacen.producto_id
        FROM producto 
        inner join producto_almacen on producto_almacen.producto_id = producto.id
        inner join almacen on producto_almacen.almacen_id = almacen.id
        where producto_almacen.producto_id = {$_GET['producto']}
        and almacen.empresa_id={$_SESSION['usuario']['empresa_id']}", 5);
    if ($producto['suceed'] && count($producto['data'] > 0)) {
        $producto = $producto['data'][0];
    }
}
// </editor-fold>
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?php echo TITULO; ?> - Productos en Almacen</title>
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
        <script src="<?php echo ROOT; ?>/js/listado.js"></script>
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="content">
                <div class="page-header">
                    <h1><?php echo $producto['nombre']; ?> <small> Existencia en almacenes</small> </h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Producto</a><span class="divider">&raquo;</span></li>
                    <li>Productos en Almacen</li>
                </ul>
                <div class="row">
                    <div class="span16">
                        <?php if (count($pag->registros) > 0): ?>
                            <table class="zebra-striped bordered-table">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Nombre</th>
                                        <th>Cantidad</th>
                                        <th>Operaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pag->registros as $registro): ?>
                                        <tr>
                                            <td><?php echo $registro['id']; ?></td>
                                            <td><?php echo $registro['nombre']; ?></td>
                                            <td style="text-align: right;"><?php echo $registro['cantidad']; ?></td>
                                            <td>
                                                <a href="traspasar.php?almacen=<?php echo $registro['id']; ?>&producto=<?php echo $registro['producto_id']; ?>" class="btn small info">Traspasar</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <?php $pag->mostrar_paginado_lista(); ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php else: ?>
                            <div class="alert-message">No hay resultados que mostrar</div>
                        <?php endif; ?>
                        <div class="actions">
                            <a href="crear.php" class="btn small primary">Registrar Producto</a>
                            <a href="../usuario" class="btn small ">Volver al menu</a>
                        </div>
                    </div>
                    <div class="hide">
                        <h3>Ayuda</h3>
                        <p>Listado de productos en el almace</p>
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