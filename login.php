<?php
include 'includes/constants.php';
$usuario = new usuario();
$empresa = new empresa();
$empresas = $empresa->listar();
$exito = array("suceed" => false);
if (isset($_POST['login'])) {
    $exito = $usuario->login($_POST['login'], $_POST['password'], $_POST['empresa']);
}
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
        <script type="text/javascript" src="js/jquery-validate/jquery.validate.pack.js"></script>
        <script type="text/javascript" src="js/jquery-validate/localization/messages_es.js"></script>
        <script type="text/javascript" src="js/forms.js"></script>
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="page-header">
                <h1>Iniciar Sesión</h1>
            </div>
            <section>
                <?php if (!$exito['suceed']): ?>
                    <?php if (isset($_POST['login'])): ?>
                        <div class="alert-message error block-message">
                            <p><strong>Error</strong> <?php echo $exito['error']; ?></p>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <fieldset>
                            <legend>Inicie sesi&oacute;n para ingresar al sistema</legend>
                            <div class="clearfix">
                                <label for="usuario">Usuario</label>
                                <div class="input">
                                    <input name="login" id="usuario" type="text" placeholder="Usuario" class="required"/>
                                </div>
                            </div>
                            <div class="clearfix">
                                <label for="password">Password</label>
                                <div class="input">
                                    <input name="password" id="password" type="password" placeholder="Password" class="required"/>
                                </div>
                            </div>
                            <div class="clearfix">
                                <label for="empresa">Empresa:</label>
                                <div class="input">
                                    <select name="empresa" id="empresa" class="required">
                                        <?php foreach ($empresas['data'] as $emp) : ?>
                                        <option value="<?php echo $emp['id']; ?>"><?php echo $emp['nombre']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="actions">
                                <button class="btn" type="submit" value="login">Iniciar Sesión</button>
                            </div>
                        </fieldset>
                    </form>
                <?php endif; ?>
            </section>
            <footer>
                <p>&copy; Aled Multimedia Solutions <?php echo date("Y"); ?></p>
            </footer>
        </div>
    </body>
</html>
