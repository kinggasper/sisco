<?php

// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$pag = new paginacion();
$query = "SELECT c.*, e.nombre as empresa , o.nombre as organismo,
    ec.nombre as estatus_contrato, concat(cli.Nombre, ' ', cli.Apellido) as cliente,
    ' ' as medio_pago,v.nombre as vendedor
    from contrato c 
    inner join empresa e on c.empresa_id = e.id
    inner join organismo o on c.organismo_id = o.id
    inner join status_contrato ec on c.status_contrato_id = ec.id 
    inner join cliente cli on c.cliente_id = cli.id
    inner join vendedor v on c.vendedor_id = c.id";
$pag->paginar($query, 5);

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
                    <h1>Contratos <small> Contratos Registrados</small> </h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li>Contratos</li>
                </ul>
                <div class="row">
                    <div class="span12">
                        <?php if (count($pag->registros) > 0): ?>
                            <table class="zebra-striped bordered-table">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Número</th>
                                        <th>Empresa</th>
                                        <th>Organismo</th>
                                        <th>Estatus</th>
                                        <th>Cliente</th>
                                        <th>Medio de pago</th>
                                        <th>Fecha</th>
                                        <th>Comision</th>
                                        <th>Vendedor</th>
                                        <th>Com. Vend.</th>
                                        <th>Monto</th>
                                        <th>Frecuencia</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pag->registros as $registro): ?>
                                        <tr>
                                            <td><?php echo $registro['id']; ?></td>
                                            <td><?php echo $registro['numero']; ?></td>
                                            <td><?php echo $registro['empresa']; ?></td>
                                            <td><?php echo $registro['organismo']; ?></td>
                                            <td><?php echo $registro['estatus_contrato']; ?></td>
                                            <td><?php echo $registro['cliente']; ?></td>
                                            <td><?php echo $registro['medio_pago']; ?></td>
                                            <td><?php echo $registro['fecha']; ?></td>
                                            <td><?php echo $registro['comision_vendedor']; ?></td>
                                            <td><?php echo $registro['vendedor']; ?></td>
                                            <td><?php echo $registro['porcentaje_vendedor']; ?></td>
                                            <td><?php echo $registro['monto']; ?></td>
                                            <td><?php echo $registro['frecuencia_id']; ?></td>
                                            <td>
                                                <a href="modificar.php?id=<?php echo $registro['id']; ?>" class="btn small info">Modificar</a>
                                                <a href="borrar.php?id=<?php echo $registro['id']; ?>" class="btn small danger">Eliminar</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <?php $pag->mostrar_paginado_lista(); ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php else: ?>
                            <div class="alert-message">No hay resultados que mostrar</div>
                        <?php endif; ?>
                        <div class="actions">
                            <a href="crear.php" class="btn small primary">Crear Contrato</a>
                            <a href="../usuario" class="btn small ">Volver al menu</a>
                        </div>
                    </div>
                    <div class="hide">
                        <h3>Ayuda</h3>
                        <p>Listado de Vendedores</p>
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