<?php
include_once '../../includes/constants.php';
$usuario = new usuario();
$usuario->confirmar_miembro();
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
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="content">
                <div class="page-header">
                    <h1>SISCO<small> Sistema Integrado de Cobranzas Online</small></h1>
                </div>
                <div class="hero-unit">
                    <h1>Gestion de Lotes</h1>
                    <p>Seleccione una operacion.</p>
                    <p>
                        <a href="crear.php" class="btn primary">Generar Lote</a>
                        <a href="cargar.php" class="btn info">Cargar Archivo Respuesta</a>
                    </p>
                </div>
            </div>
            <footer>
                <p>&copy; Aled Multimedia Solutions <?php echo date("Y"); ?></p>
            </footer>
        </div>
    </body>
</html>
