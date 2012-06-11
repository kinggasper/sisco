<?php

// <editor-fold defaultstate="collapsed" desc="configuracion regional">
date_default_timezone_set("America/Caracas");
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Comprobando Servidor">
$user = "";
$password = "";
$db = "";
$email_error = false;
$mostrar_error = true;
$debug = true;
$sistema = "/sisco";
if ($_SERVER['SERVER_NAME'] == "www.inverelturco.com" | $_SERVER['SERVER_NAME'] == "inverelturco.com") {
    $user = "asgmul_sisco";
    $password = "asgmultiplex2012";
    $db = "asgmul_sisco";
    $email_error = true;
    $mostrar_error = false;
    $debug = true;
    $sistema = "";
} else {
    $user = "root";
    $password = "root";
    $db = "sisco";
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Acceso a la BD">
define("HOST", "localhost");
define("USER", $user);
define("PASSWORD", $password);
define("DB", $db);
// </editor-fold>
//<editor-fold defaultstate="collapsed" desc="configuracion de ficheros del sistema">
define("SISTEMA", $sistema);
define("EMAIL_ERROR", $email_error);
define("EMAIL_CONTACTO", "anyulled@gmail.com");
define("EMAIL_TITULO", "error");
define("MOSTRAR_ERROR", $mostrar_error);
define("DEBUG", $debug);

define("TITULO", "SISCO - Sistema Integrado de Cobranzas Online");
/**
 * para las urls
 */
define("ROOT", 'http://' . $_SERVER['SERVER_NAME'] . SISTEMA);
/**
 * para los includes
 */
define("SERVER_ROOT", $_SERVER['DOCUMENT_ROOT'] . SISTEMA);
set_include_path(SERVER_ROOT . $sistema);
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
