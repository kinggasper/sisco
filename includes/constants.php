<?php

// <editor-fold defaultstate="collapsed" desc="configuracion regional">
date_default_timezone_set("America/Caracas");
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Acceso a la BD">
define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "root");
define("DB", "sisco");
// </editor-fold>
//<editor-fold defaultstate="collapsed" desc="configuracion de ficheros del sistema">
define("SISTEMA", "/sisco");
define("EMAIL_ERROR",false);
define("EMAIL_CONTACTO","anyulled@gmail.com");
define("EMAIL_TITULO","error");
define("MOSTRAR_ERROR",true);
define("DEBUG",true);

define("TITULO", "SISCO - Sistema Integrado de Cobranzas Online");
/**
 * para las urls
 */
define("ROOT", 'http://' . $_SERVER['SERVER_NAME'] . SISTEMA);
/**
 * para los includes
 */
define("SERVER_ROOT", $_SERVER['DOCUMENT_ROOT'] . SISTEMA);
set_include_path(SERVER_ROOT . "/sisco/");
define("TEMPLATE", SERVER_ROOT . "/template/");

//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="autoload">
function __autoload($clase) {
    include_once SERVER_ROOT . "/includes/" . $clase . ".php";
}

//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="cerrar sesión">
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    $user_logout = new usuario();
    $user_logout->logout();
}
//</editor-fold>
