<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$usuario = new usuario();
$usuario->confirmar_miembro();
//require '../../includes/paginacion.php';
$pag = new paginacion();
$pag->paginar("select 
    producto.id 'producto_id', producto.nombre 'producto', 
    almacen.id 'almacen_id', almacen.nombre 'almacen',
    producto.cantidad_minima, ifnull(producto_almacen.cantidad, 0)'existencia'
    from producto 
        left outer join producto_almacen on producto.id = producto_almacen.producto_id
        left outer join almacen on almacen.id = producto_almacen.almacen_id
            where ifnull(producto_almacen.cantidad, 0) < producto.cantidad_minima
            and producto.empresa_id ={$_SESSION['usuario']['empresa_id']}", 5);
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
        <link href="<?php echo ROOT; ?>/css/style.css" rel="stylesheet"/>
        <script src="<?php echo ROOT; ?>/js/jquery-1.7.1.min.js"></script>
        <script src="<?php echo ROOT; ?>/js/listado.js"></script>
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="content">
                <div class="page-header">
                    <h1>Productos Faltantes <small> por almacen</small> </h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Almacen</a><span class="divider">&raquo;</span></li>
                    <li>Productos Faltantes</li>
                </ul>
                <div class="row">
                    <div class="span16">
                        <?php if (count($pag->registros) > 0): ?>
                            <table class="zebra-striped bordered-table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Almacen</th>
                                        <th>Cantidad minima</th>
                                        <th>Existencia</th>
                                        <th>Operaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pag->registros as $registro): ?>
                                        <tr>
                                            <td><?php echo $registro['producto']; ?></td>
                                            <td><?php echo $registro['almacen']; ?></td>
                                            <td><?php echo $registro['cantidad_minima']; ?></td>
                                            <td><?php echo $registro['existencia']; ?></td>
                                            <td>
                                                <?php if ($registro['existencia'] > 0): ?>
                                                <a href="../producto/traspasar.php?almacen=<?php echo $registro['almacen_id'];?>&producto=<?php echo $registro['producto_id'];?>" class="btn info">Traspasar</a>
                                                <?php endif; ?>
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
                            <a href="crear.php" class="btn small primary">Crear almacen</a>
                            <a href="ordenDeCompra.php" class="btn small">Orden de compra</a>
                            <a href="../usuario" class="btn small ">Volver al menu</a>
                        </div>
                    </div>
                    <div class="hide">
                        <h3>Ayuda</h3>
                        <p>Listado de almacenes que emiten contratos</p>
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