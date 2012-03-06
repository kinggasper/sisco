<?php
include '../../includes/constants.php';
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
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="content">
                <div class="page-header">
                    <h1>SISCO<small> Sistema Integrado de Cobranzas Online</small></h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario/">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Reporte</a><span class="divider">&raquo;</span></li>
                    <li>Listar</li>
                </ul>
                <div class="hero-unit">
                    <h1>Módulo de Reportes
                        <small> En construcción</small></h1>
                </div>
                <h2>M&oacute;dulos disponibles</h2>
                <div class="row">
                    <div class="span4">
                        <h2>Almacenes</h2>
                        <p>Almacenes disponibles</p><br/>
                        <a href="../almacen/listar.php" class="btn info small">Entrar</a>
                    </div>
                    <div class="span4">
                        <h2>Empresas</h2>
                        <p>Gestión de empresas</p><br/>
                        <a href="../empresa/listar.php" class="btn info small">Entrar</a>
                    </div>
                    <div class="span4">
                        <h2>Organismos</h2>
                        <p>Administra los organismos disponibles y sus clientes</p>
                        <a href="../organismo/listar.php" class="btn info small">Entrar</a>
                    </div>
                    <div class="span4">
                        <h2>Reportes</h2>
                        <p>Realice consultas al sistema y exp&oacute;rtelas en formato PDF.</p>
                        <a href="../reporte/listar.php" class="btn info small">Entrar</a>
                    </div>
                </div>
                <div class="row">
                    <div class="span4">
                        <h2>Clientes</h2>
                        <p>Administrar clientes</p>
                        <a class="btn info small" href="../cliente/listar.php">Entrar</a>
                    </div>
                    <div class="span4">
                        <h2>Productos</h2>
                        <p>Administrar Productos disponibles</p>
                        <a class="btn info small" href="../producto/listar.php">Entrar</a>
                    </div>
                    <div class="span4">
                        <h2>Usuarios</h2>
                        <p>Administrar usuarios disponibles</p>
                        <a class="btn info small" href="../usuario/listar.php">Entrar</a>
                    </div>
                    <div class="span4">
                        <h2>Vendedores</h2>
                        <p>Administrar Vendedores disponibles</p>
                        <a class="btn info small" href="../vendedor/listar.php">Entrar</a>
                    </div>
                </div>
                <div class="row">
                    <div class="span4">
                        <h2>Contratos</h2>
                        <p>Emite y revisa contratos emitidos</p>
                        <a href="../contrato/listar.php" class="btn small info">Entrar</a>
                    </div>
                    <div class="span4">
                        <h2>Lotes</h2>
                        <p>Crea y carga lote de cobros</p>
                        <a href="../lote/listar.php" class="btn small info">Entrar</a>
                    </div>
                    <div class="span4">
                        <h2>Bitacora</h2>
                        <p>Revisa la bitacora del sistema</p>
                        <a href="../bitacora/listar.php" class="btn small info">Entrar</a>
                    </div>
                </div>
            </div>
            <footer>
                <p>&copy; Aled Multimedia Solutions <?php echo date('Y'); ?></p>
            </footer>
        </div>
    </body>
</html>
