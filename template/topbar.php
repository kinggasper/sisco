<div class="topbar">
    <?php if (isset($_SESSION['usuario'])): ?>
        <div class="topbar-inner">
            <div class="container-fluid">
                <a class="brand" href="#">SISCO</a>
                <ul class="nav">
                    <li class="active"><a href="#">Inicio</a></li>
                    <li><a href="#about">Acerca de</a></li>
                    <li><a href="#contact">Contacto</a></li>
                </ul>
                <p class="pull-right">
                    Sesi&oacute;n iniciada como <a href="<?php echo ROOT . "/sistema/usuario" ?>"><?php echo $_SESSION['usuario']['Nombre']; ?></a>
                    - <span> <?php echo $_SESSION['usuario']['empresa']; ?></span>
                    | <a href="<?php echo $_SERVER['PHP_SELF'] . "?logout=1"; ?>">Cerrar Sesión</a>
                </p>
            </div>
        </div>
        <?php
    else:
        $emp = new empresa();
        $empresas_login = $emp->listar();
        ?>
        <div class="fill">
            <div class="container-fluid">
                <a class="brand" href="#">SISCO</a>
                <ul class="nav">
                    <li class="active"><a href="<?php echo ROOT; ?>">Inicio</a></li>
                    <li><a href="#about">Nosotros</a></li>
                    <li><a href="#contact">Contacto</a></li>
                </ul>
                <form action="<?php echo ROOT . "/login.php"; ?>" class="pull-right" method="post">
                    <input name="login" class="input-small" type="text" placeholder="Usuario"/>
                    <input name="password" class="input-small" type="password" placeholder="Password"/>
                    <select name="empresa" class="input-small">
                        <?php foreach ($empresas_login['data'] as $sesion_empresa): ?>
                            <option value="<?php echo $sesion_empresa['id']; ?>" ><?php echo $sesion_empresa['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn" value="login" type="submit">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
