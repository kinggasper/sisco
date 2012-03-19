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
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="content">
                <div class="page-header">
                    <h1>SISCO<small> Sistema Integrado de Cobranzas Online</small></h1>
                </div>
                <ul class="breadcrumb">
                    <li>Sistema</li>
                </ul>
                <div class="hero-unit">
                    <h1><?php echo $_SESSION['usuario']['Nombre']; ?> 
                        <small><?php echo $_SESSION['usuario']['empresa']; ?> - <?php echo $_SESSION['usuario']['tipo_usuario']; ?>.</small> </h1>
                    <p>
                        <a href="modificar.php" class="btn primary">Modificar Datos</a>
                        <a href="<?php echo $_SERVER['PHP_SELF'] . "?logout=1"; ?>" class="btn danger">Cerrar Sesión</a>
                    </p>
                </div>
                <h2>M&oacute;dulos disponibles</h2>
                <div class="row">
                    <div class="span4">
                        <h3>Almacenes</h3>
                        <p>Almacenes disponibles</p><br/>
                        <a href="../almacen/listar.php" class="btn info small">Entrar</a>
                    </div>
                    <div class="span4">
                        <h3>Empresas</h3>
                        <p>Gestión de empresas</p><br/>
                        <a href="../empresa/listar.php" class="btn info small">Entrar</a>
                    </div>
                    <div class="span4">
                        <h3>Organismos</h3>
                        <p>Administra los organismos disponibles y sus clientes</p>
                        <a href="../organismo/listar.php" class="btn info small">Entrar</a>
                    </div>
                    <div class="span4">
                        <h3>Reportes</h3>
                        <p>Realice consultas al sistema y exp&oacute;rtelas en formato PDF.</p>
                        <a href="../reporte/listar.php" class="btn info small">Entrar</a>
                    </div>
                </div>
                <div class="row">
                    <div class="span4">
                        <h3>Clientes</h3>
                        <p>Administrar clientes</p>
                        <a class="btn info small" href="../cliente/listar.php">Entrar</a>
                    </div>
                    <div class="span4">
                        <h3>Productos</h3>
                        <p>Administrar Productos disponibles</p>
                        <a class="btn info small" href="../producto/listar.php">Entrar</a>
                    </div>
                    <div class="span4">
                        <h3>Usuarios</h3>
                        <p>Administrar usuarios disponibles</p>
                        <a class="btn info small" href="../usuario/listar.php">Entrar</a>
                    </div>
                    <div class="span4">
                        <h3>Vendedores</h3>
                        <p>Administrar Vendedores disponibles</p>
                        <a class="btn info small" href="../vendedor/listar.php">Entrar</a>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="span4">
                        <h3>Contratos</h3>
                        <p>Emite y revisa contratos emitidos</p>
                        <a href="../contrato/listar.php" class="btn small info">Entrar</a>
                    </div>
                    <div class="span4">
                        <h3>Lotes</h3>
                        <p>Crea y carga lote de cobros</p>
                        <a href="../lote/listar.php" class="btn small info">Entrar</a>
                    </div>
                    <div class="span4">
                        <h3>Bitacora</h3>
                        <p>Revisa la bitacora del sistema</p>
                        <a href="../bitacora/listar.php" class="btn small info">Entrar</a>
                    </div>
                    <div class="span4">
                        <h3>Banco</h3>
                        <p>Administraci&oacute;n de Banco</p>
                        <a href="../banco/listar.php" class="btn small info">Entrar</a>
                    </div>
                </div>
            </div>
            <footer>
                <p>&copy; Aled Multimedia Solutions 2011</p>
            </footer>
        </div>
    </body>
</html>
