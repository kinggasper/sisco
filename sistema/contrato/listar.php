<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$usuario = new usuario();
$usuario->confirmar_miembro();
$pag = new paginacion();
$query = "SELECT c.*,
        status_contrato.nombre 'status_contrato',
        organismo.nombre 'organismo',
        concat(cliente.Nombre, ' ', cliente.Apellido) cliente,
        vendedor.Nombre vendedor,
        frecuencia.nombre frecuencia
    FROM contrato c 
    inner join status_contrato on status_contrato.id = c.status_contrato_id
    inner join organismo on c.organismo_id = organismo.id
    inner join cliente on c.cliente_id = cliente.id
    inner join vendedor on c.vendedor_id = vendedor.id
    inner join frecuencia on frecuencia.id = c.frecuencia_id
    where c.empresa_id = {$_SESSION['usuario']['empresa_id']}";
if (isset($_GET['filtrar'])) {
    $query.=" and (organismo.nombre like '%{$_GET['filtrar']}%' 
        or concat(cliente.Nombre, ' ', cliente.Apellido) like '%{$_GET['filtrar']}%' 
        or vendedor.nombre like '%{$_GET['filtrar']}%')";
}
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
                    <li><a href="listar.php">Contratos</a><span class="divider">&raquo;</span></li>
                    <li>Listar</li>
                </ul>
                <div class="row">
                    <div class="span16">
                        <?php if (count($pag->registros) > 0): ?>
                            <div class="pull-right">
                                <form class="">
                                    <label>Filtrar</label>
                                    <div class="input">
                                        <input type="search" name="filtrar" id="filtrar" placeholder="Buscar contrato" value="<?php echo isset($_GET['filtrar']) ? $_GET['filtrar'] : ""; ?>" />
                                    </div>
                                </form>
                            </div>
                            <table class="zebra-striped bordered-table">
                                <thead>
                                    <tr>
                                        <th><a href="<?php echo Misc::url_sortable(); ?>">id</a></th>
                                        <th><a href="<?php echo Misc::url_sortable("numero"); ?>">Número</a></th>
                                        <th><a href="<?php echo Misc::url_sortable("organismo"); ?>">Organismo<a/></th>
                                        <th><a href="<?php echo Misc::url_sortable("cliente"); ?>">Cliente</a></th>
                                        <th><a href="<?php echo Misc::url_sortable("fecha"); ?>">Fecha</a></th>
                                        <th><a href="<?php echo Misc::url_sortable("monto"); ?>">Monto</a></th>
                                        <th><a href="<?php echo Misc::url_sortable("vendedor"); ?>">Vendedor</a></th>
                                        <th><a href="<?php echo Misc::url_sortable("comision_vendedor"); ?>">Comision Vendedor</a></th>
                                        <th><a href="<?php echo Misc::url_sortable("frecuencia"); ?>">Frecuencia</a></th>
                                        <th><a href="<?php echo Misc::url_sortable("status_contrato"); ?>">Estatus</a></th>
                                        <th>Operaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pag->registros as $registro): ?>
                                        <tr>
                                            <td><?php echo $registro['id']; ?></td>
                                            <td><?php echo $registro['numero']; ?></td>
                                            <td><?php echo $registro['organismo']; ?></td>
                                            <td><?php echo $registro['cliente']; ?></td>
                                            <td><?php echo misc::date_format($registro['fecha']); ?></td>
                                            <td><?php echo misc::number_format($registro['monto']); ?> Bsf.</td>
                                            <td><?php echo $registro['vendedor']; ?></td>
                                            <td><?php echo misc::number_format($registro['comision_vendedor']); ?> Bsf.</td>
                                            <td><?php echo $registro['frecuencia']; ?></td>
                                            <td><?php echo $registro['status_contrato']; ?></td>
                                            <td>
                                                <a href="modificar.php?id=<?php echo $registro['id']; ?>" class="btn small">Modificar</a>
                                                <a href="recibos.php?id=<?php echo $registro['id']; ?>" class="btn small info">Recibos</a>
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
                            <div class="alert-message">
                                <a href="listar.php" class="close">x</a>
                                No hay resultados que mostrar
                            </div>
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
