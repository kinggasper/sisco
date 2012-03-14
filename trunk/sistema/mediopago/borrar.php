<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$mediopago = new mediopago();
$usuario = new usuario();
$usuario->confirmar_miembro();
$resultado = array("suceed" => false);
if (isset($_GET['id'])) {
    $resultado = $mediopago->borrar($_GET['id']);
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
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            
            <div class="content">
                <div class="page-header">
                    <h1>Borrar mediopago</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">medios de pago</a><span class="divider">&raquo;</span></li>
                    <li>Borrar</li>
                </ul>
                <?php if ($resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>Registro eliminado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small primary" href="listar.php">Volver al listado</a>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                    <div class="alert-message block-message error">
                        <a class="close" href="#">×</a>
                        <p>No se pudo borrar el Registro, intente de nuevo o contacte con el administrador del sistema.</p>
                        <a class="btn small info">Intentar de nuevo.</a>
                        <a class="btn small" href="../sistema">Volver al men&uacute;.</a>
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