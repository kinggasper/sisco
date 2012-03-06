<?php
include_once 'constants.php';

/**
 * Clase para el manejo de la Base de Datos
 * @author Anyul Rivas
 * @version 3.2
 */
Class db {

    /**
     * host
     * @var string Host
     */
    private $host = HOST;
    /**
     * nombre de usuario
     * @var string usuario
     */
    private $user = USER;
    /**
     * contraseña de acceso
     * @var string contraseña
     */
    private $password = PASSWORD;
    /**
     * Tabla
     * @var string tabla
     */
    private $db = DB;
    /**
     * mysqli instance
     * @var msqli sql
     */
    protected $mysqli = null;
    /**
     * Debug indica si está en modo debug y muestra en un campo las consultas realizadas;
     */
    private $debug = true;

    final public function __construct() {
        try {
            set_error_handler('Misc::error_handler');
            $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->db);
            $this->mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);

            $this->mysqli->query("SET NAMES 'utf8'");
        } catch (Exception $exc) {
            echo $this->mysqli->connect_errno . " " . $this->mysqli->connect - error;
            echo $exc->getTraceAsString();
            exit("No se pudo conectar con la Base de Datos. Consulte al administrador del sistema.");
        }
    }

    public function __destruct() {
        //if(is_object($this->msqli)
        $this->mysqli->close();
        restore_error_handler();
    }

    /**
     * Realiza una consulta y devuelve un array con los resultados
     * @param string $query Consulta
     * @return array El array de los resultados
     */
    public function dame_query($query) {
        try {
            $resultado = $this->mysqli->query($query);
            $result = array();
            $r['suceed'] = true;
            if ($this->debug) {
                $r['query'] = $query;
            }

            if ($this->mysqli->errno == 0) {
                while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                    $result[] = $fila;
                }
                $r['data'] = $result;
                $r['stats']['affected_rows'] = $this->mysqli->affected_rows;
            } else {
                throw new Exception;
            }
        } catch (Exception $exc) {
            $r['suceed'] = false;
            if ($this->debug) {
                $r['query'] = $query;
            }
            $r['stats']['errno'] = $this->mysqli->errno;
            $r['stats']['error'] = $this->mysqli->error;
            $r['data'] = $exc->getTraceAsString();
        }

        return $r;
    }

    /**
     * ejecuta una sentencia SQL y devuelve el resultado
     * @param string $query instrucción SQL
     * @return mysqli query
     */
    public function exec_query($query) {
        try {
            $r = array();
            $r['suceed'] = true;
            $r['data'] = $this->mysqli->query($query);
            $r['stats']['affected_rows'] = $this->mysqli->affected_rows;
            $r['stats']['errno'] = $this->mysqli->errno;
            $r['stats']['error'] = $this->mysqli->error;
        } catch (Exception $exc) {
            $r['suceed'] = false;
            $r['stats']['errno'] = $this->mysqli->errno;
            $r['stats']['error'] = $this->mysqli->error;
            $r['data'] = $exc->getTraceAsString();
        }
        return $r;
    }

    /**
     * Realiza una consulta y devuelve los resultados en una matriz asociativa
     * @param array $columnas un arreglo de las columnas a seleccionar ['col1','col2','col3'] o un solo campo
     * @param array $tablas un arreglo de las tablas a seleccionar ['tabla1','tabla2','tabla3'] o una sola tabla
     * @param array $condicion una cadena o un arreglo con las condiciones de la busqueda
     * @param array $join una cadena o un arreglo con los join {por desarrollar}
     * @param array $order una cadena o un arreglo con el orden del select
     * @param array $groupby una cadena o un arreglo con los campos a agrupar
     * @return array el arreglo asociativo con los resultados de la consulta
     */
    public function select($columnas=null, $tablas=null, $condicion=null, $join=null, $order=null, $groupby=null) {
        try {
            $r = array();
            if ($columnas != null && $tablas != null) {
                $query = "select ";
                if (is_array($columnas)) {
                    for ($i = 0; $i < count($columnas); $i++) {
                        $query.= $columnas[$i] . (($i < (count($columnas) - 1)) ? ", " : " ");
                    }
                } else {
                    $query.= $columnas;
                }
                $query.= " from ";
                if (is_array($tablas)) {
                    
                } else {
                    $query.= $this->db . "." . $tablas;
                }

                if ($condicion != null) {
                    if (count(array_keys($condicion)) == 1) {
                        $query.= " where " . key($condicion) . " = " . $condicion[key($condicion)];
                    } else {
                        $columnasCondicion = array_keys($condicion);
                        $valoresCondicion = array_values($condicion);
                        for ($q = 0; $q < count($condicion); $q++) {
                            if ($q == 0) {
                                $query.=' where ';
                            } else {
                                $query.= ' and ';
                            }
                            $query.= $columnasCondicion[$q] . " = '" . $valoresCondicion[$q] . "'";
                        }
                    }
                }
                if ($join != null) {
                    //TODO falta por desarrollar
                }
                if ($order != null) {
                    $query.= " order by ";
                    if (is_array($order)) {
                        foreach ($order as $key => $val) {
                            $query.= $key . " " . $val;
                        }
                    }
                }
                if ($groupby != null) {
                    //TODO falta por desarrollar
                }
                $resultado = $this->mysqli->query($query);

                $a = array();
                if ($this->mysqli->errno == 0) {
                    while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                        $a[] = $fila;
                    }
                    if ($this->debug) {
                        $r['query'] = $query;
                    }
                    $r['suceed'] = true;
                    $r['data'] = $a;
                    $r['stats']['affected_rows'] = $this->mysqli->affected_rows;
                } else {
                    throw new Exception;
                }
            }
        } catch (Exception $exc) {
            if ($this->debug) {
                $r['query'] = $query;
            }
            $r['suceed'] = false;
            $r['stats']['errno'] = $this->mysqli->errno;
            $r['stats']['error'] = $this->mysqli->error;
            $r['data'] = $exc->getTraceAsString();
        }

        return $r;
    }

    /**
     * Inserta Valores en una tabla del sistema (utiliza mysqli)
     * @param string $tabla la tabla en la que se insertarán los autos
     * @param array $datos los datos en una matriz asociativa con las columnas y valores
     * @return bool true si la operación fue efectiva, false si hubo algún fallo.
     */
    public function insert($tabla=null, $datos=null) {
        try {
            if ($tabla != null && $datos != null) {
                $columnas = array_keys($datos);
                $valores = array_values($datos);
                $query = "insert into ";
                $query.= $tabla;
                $query.= "(";
                for ($i = 0; $i < count($columnas); $i++) {
                    $query.= ' ' . (isset($columnas[$i]) ? $columnas[$i] : '');
                    if ($i < (count($columnas) - 1)) {
                        $query.=",";
                    }
                }
                $query.= ") values(";
                for ($z = 0; $z < count($valores); $z++) {
                    $query.= " '" . (isset($valores[$z]) ? $this->mysqli->real_escape_string($valores[$z]) . "'" : '');
                    if ($z < (count($valores) - 1)) {
                        $query.=",";
                    }
                }
                $query.= ")";
            }
            $r = array();
            $resultado = $this->mysqli->query($query);
            if ($this->mysqli->errno == 0) {
                $r['suceed'] = $resultado;
                $r['insert_id'] = $this->mysqli->insert_id;
                if ($this->debug) {
                    $r['query'] = $query;
                }
                $r['stats']['affected_rows'] = $this->mysqli->affected_rows;
            } else {
                throw new Exception;
            }
        } catch (Exception $exc) {
            if ($this->debug) {
                $r['query'] = $query;
            }
            $r['suceed'] = false;
            $r['stats']['errno'] = $this->mysqli->errno;
            $r['stats']['error'] = $this->mysqli->error;
            $r['data'] = $exc->getTraceAsString();
        }
        return $r;
    }

    /**
     * Actualiza los datos de una tabla
     * @param string $tabla la tabla objetivo
     * @param array $datos matriz asociativa con las columnas y valores
     * @param array $condicion matriz asociativa con las condiciones y valores
     * @return bool true si es exitoso, false en caso de error
     */
    public function update($tabla=null, $datos=null, $condicion=null) {
        try {
            if ($tabla != null && $datos != null) {
                $columnas = array_keys($datos);
                $valores = array_values($datos);
                $query = "update ";
                $query.= $this->db . "." . $tabla;
                $query.= " SET ";
                for ($i = 0; $i < count($datos); $i++) {
                    $query.= $columnas[$i] . " = '" . $valores[$i] . "'";
                    if ($i < (count($datos) - 1)) {
                        $query.= ", ";
                    }
                }
                if ($condicion != null) {
                    if (count(array_keys($condicion)) == 1) {
                        $query.= " where " . key($condicion) . " = " . $condicion[key($condicion)];
                    } else {
                        $columnasCondicion = array_keys($condicion);
                        $valoresCondicion = array_values($condicion);
                        for ($q = 0; $q < count($condicion); $q++) {
                            if ($q == 0) {
                                $query.=' where ';
                            } else {
                                $query.= ' and ';
                            }
                            $query.= $columnasCondicion[$q] . " = '" . $valoresCondicion[$q] . "'";
                        }
                    }
                }
            }
            $r = array();
            if ($this->debug) {
                $r['query'] = $query;
            }
            $r['suceed'] = $this->mysqli->query($query);
            $r['stats']['affected_rows'] = $this->mysqli->affected_rows;
            if ($r['suceed'] != TRUE) {
                $r['stats']['errno'] = $this->mysqli->errno;
                $r['stats']['error'] = $this->mysqli->error;
            }
        } catch (Exception $exc) {
            $r['stats']['errno'] = $this->mysqli->errno;
            $r['stats']['error'] = $this->mysqli->error;
            $r['suceed'] = false;
            $r['data'] = $exc->getTraceAsString();
        }
        return $r;
    }

    /**
     *  Elimina datos de una tabla
     * @param string tabla la tabla objetivo
     * @param array matriz asociativa con las codiciones y valores
     * @return bool true si la operación fue exitosa, false en caso contrario
     */
    public function delete($tabla=null, $condicion=null) {
        try {
            if ($tabla != null && $condicion != null) {
                $query = 'delete from ';
                $query.= $this->db . "." . $tabla;
                if ($condicion != null) {
                    if (count(array_keys($condicion)) == 1) {
                        $query.= " where " . key($condicion) . " = " . $condicion[key($condicion)];
                    } else {
                        $columnasCondicion = array_keys($condicion);
                        $valoresCondicion = array_values($condicion);
                        for ($q = 0; $q < count($condicion); $q++) {
                            if ($q == 0) {
                                $query.=' where ';
                            } else {
                                $query.= ' and ';
                            }
                            $query.= $columnasCondicion[$q] . " = '" . $valoresCondicion[$q] . "'";
                        }
                    }
                }
            }
            $r = array();
            if ($this->debug) {
                $r['query'] = $query;
            }
            $r['suceed'] = $this->mysqli->query($query);
            if ($this->mysqli->errno == 0) {
                $r['stats']['affected_rows'] = $this->mysqli->affected_rows;
            } else {
                throw new Exception;
            }
        } catch (Exception $exc) {
            if ($this->debug) {
                $r['query'] = $query;
            }
            $r['suceed'] = false;
            $r['stats']['errno'] = $this->mysqli->errno;
            $r['stats']['error'] = $this->mysqli->error;
            $r['data'] = $exc->getTraceAsString();
        }
        return $r;
    }

    /*
     * Creando las funciones estáticas
     */

    /**
     * Función estática para relizar consultas
     * @param string $query consulta sql
     */
    public static function query($consulta) {
        $a = new db();
        return $a->dame_query($consulta);
    }

}

/**
 * Clases miscelaneas
 * @author Anyul Rivas
 */
Class Misc {
    /**
     * Carga automatica de archivos de clases
     */
    public function __autoload($clase){
        $filename = SERVER_ROOT."/includes/".$clase.".php";
        if(file_exists($filename)){
            include $filename;
        }
    }

    /**
     * Determina el país de visita de una ip
     * @param string $ipAddr la dirección ip. ($_SERVER['REMOTE_ADDR'])
     * @return matriz asociativa con el país y código.
     */
    public static function countryCityFromIP($ipAddr) {

        if (ip2long($ipAddr) == -1 || ip2long($ipAddr) === false) {
            trigger_error("invalid class", E_USER_ERROR);
        }
        $ipDetail = array();

        $xml = file_get_contents("http://api.hostip.info/?ip=" . $ipAddr);

        preg_match("@<Hostip>(\s)*<gml:name>(.*?)</gml:name>@si", $xml, $match);

        $ipDetail['city'] = $match[2];

        preg_match("@<countryName>(.*?)</countryName>@si", $xml, $matches);

        $ipDetail['<strong class="highlight">country</strong>'] = $matches[1];

        preg_match("@<countryAbbrev>(.*?)</countryAbbrev>@si", $xml, $cc_match);
        $ipDetail['country_code'] = $cc_match[1]; //assing the <strong class="highlight">country</strong> code to array

        return $ipDetail;
    }

    /**
     * Manejador de errores en el sistema. Envía un correo detallando lo sucedido y las peticiones hechas.
     * @param Integer $num El tipo de Error
     * @param String $err el mensaje de error
     * @param String $file el archivo asociado
     * @param Integer $line la línea del error
     */
    public static function error_handler($num, $err, $file, $line) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: BuscoCarro Daemon <info@buscocarro.com.ve>' . "\r\n";
        $html = "";

        // <editor-fold defaultstate="collapsed" desc="tipos de errores">
        $errortype = array(
            1 => "Error",
            2 => "Advertencia",
            4 => "Error de interpretación",
            8 => "Noticia",
            16 => "Error en el núcleo",
            32 => "Advertencia en el núcleo",
            64 => "Error de compilación",
            128 => "Advertencia de compilación",
            256 => "Error de Usuario",
            512 => "Advertencia de Usuario",
            1024 => "Noticia de Usuario",
            2048 => "E_ALL",
            2049 => "PHP5 E_STRICT");
        // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="Armando mensaje">
        $html.="<fieldset>";
        $html.= "<legend>" . (isset($errortype[@$num]) ? $errortype[@$num] : ('Error Desconocido ' . $num)) . '</legend>';
        $html.="<p><b> Error: </b>" . $err . '</p>';
        $html.= "<p><b> Archivo: </b>" . $file . '</p>';
        $html.= "<p><b> Línea: </b>" . $line . '</p>';
        if (isset($_GET) && sizeof($_GET) > 0) {
            $html.="<hr/>";
            $html.= "<pre><b>Petición GET</b></pre><code>" . misc::dump($_GET) . "</code>";
        }
        if (isset($_POST) && sizeof($_POST) > 0) {
            $html.="<hr/>";
            $html.= "<pre><b>Petición POST</b></pre><code>" . misc::dump($_POST, 1) . "</code>";
        }
		if (isset($_FILES) && sizeof($_FILES) > 0) {
            $html.="<hr/>";
            $html.= "<pre><b>Archivos Cargados</b></pre><code>" . misc::dump($_FILES, 1) . "</code>";
		}
		if (isset($_SESSION) && sizeof($_SESSION) > 0) {
            $html.="<hr/>";
            $html.= "<pre><b>Variables de Sesión</b></pre><code>" . misc::dump($_SESSION, 1) . "</code>";
		}

        $html.="<hr/>";
        $html.= "<pre><b>Server:</b></pre><code>" . misc::dump($_SERVER) . "</code>";
        $html.="</fieldset>";
        // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="comprobacion de errores">
        if ((!stristr($file, "simplepie.inc") && !stristr($file, "krumo")) && ($num == 1 || $num == 2 || $num == 4 || $num == 8 || $num == 16 || $num == 256 || $num == 2048 || $num == 2049)) {
//            echo "<code style='border:1px solid black; background-color:white!important; border-radius:5px;'>" . $html . "</code>";
            if (EMAIL_ERROR)
                mail(EMAIL_CONTACTO, EMAIL_TITULO, $html, $headers);
            if (MOSTRAR_ERROR)
                echo $html;
        } elseif (!stristr($file, "simplepie.inc") && !stristr($file, "krumo.php")) {
//            echo "<code style='border:1px solid black; background-color:white!important; border-radius:5px;'>" . $html . "</code>";
            if (EMAIL_ERROR)
                mail(EMAIL_CONTACTO, EMAIL_TITULO, $html, $headers);
            if (MOSTRAR_ERROR)
                echo $html;
            exit("<h2>Ocurrió algo inesperado. Contacte con el Administrador del Sistema.</h2>");
        } else {
            //mail("anyulled@gmail.com", "BuscoCarro.com.ve: Error", $html, $headers);
        }
        // </editor-fold>
    }

    /**
     * Recorta un texto en la longitud especificada sin cortar las palabras
     * @param String $input Texto a recortar
     * @param Integer $length Longitud a recortar
     * @param Boolean $ellipses indica si agrega puntos suspensivos al final del texto
     * @param Boolean $strip_html inidica si remueve las etiquetas html
     * @param Boolean $output_entities indica si reemplaza los caracteres especiales por entidades html
     * @return <type>
     */
    public static function trim_text($input, $length, $ellipses = true, $strip_html = true, $output_entities = false) {
        // Strip tags, if desired
        if ($strip_html) {
            $input = strip_tags($input);
        }

        // No need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }

        // Find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);

        // Add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= '...';
        }

        if ($output_entities) {
            $trimmed_text = htmlentities($trimmed_text);
        }

        return $trimmed_text;
    }

    /**
     * Comprueba si una variable es de tipo entero
     * @param String $variable la variable de ingreso
     * @return Boolean 
     */
    public static function comprobar_tipo($variable) {
        settype($variable, "integer");
        return $variable;
    }

    /**
     * Especifica el tipo de error ocurrido en la carga de imagen
     * @param mixed $error el arreglo con los datos de la imagen cargada
     * @return string el mensaje de error
     */
    public static function error_carga_imagen($error) {
        switch ($error) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $mensaje_error = ' El tamaño del archivo es demasiado grande. ';
            case UPLOAD_ERR_PARTIAL:
                $mensaje_error = ' El archivo fue subido parcialmente ';
            case UPLOAD_ERR_NO_FILE:
                $mensaje_error = ' No se cargó el archivo ';
            case UPLOAD_ERR_NO_TMP_DIR:
                $mensaje_error = ' No se pudo encontrar la carpeta temporal ';
            case UPLOAD_ERR_CANT_WRITE:
                $mensaje_error = ' Error al guardar el archivo en disco ';
            case UPLOAD_ERR_EXTENSION:
                $mensaje_error = ' Extensión incorrecta ';
            default:
                $mensaje_error = ' Error desconocido ';
        }
        return $mensaje_error;
    }

    public static function comprobar_query($query) {
        $blacklist = array('union', 'unhex', 'hex', 'char', 'UNION', 'UNHEX', 'HEX', 'CHAR', 'INFORMATION_SCHEMA');
        $query = str_replace(array('(', ')', ','), ' ', $query);
        $words = explode(" ", $query);
        $result = array_intersect($blacklist, $words);
        if (count($result) > 0) {
            $db = new db();
            $db->insert("log", array(
                "ip" => $_SERVER['REMOTE_ADDR'],
                "querystring" => $_SERVER['QUERY_STRING'],
                "php_server" => var_export($_SERVER, 1)
            ));
            trigger_error("Consulta no permitida.<br/>" . var_export($_SERVER, 1), E_USER_NOTICE);
            die("Consulta no permitida");
        } else {
            return true;
        }
    }

    public static function dump($args) {
        $salida = null;
        $parametros = func_get_args();
        foreach ($parametros as $variable) {
            if (is_array($variable)) {
                foreach ($variable as $indice => $valor) {
                    $salida.= "<p><b>" . $indice . ":</b> <span>" . $valor . "</span></p>\n";
                }
            } else {
                $type = null;
                if (is_string($variable))
                    $type = "string";
                if (is_bool($variable))
                    $type = "bool";
                if (is_float($variable))
                    $type = "long";
                if (is_double($variable))
                    $type = "double";
                if (is_int($variable))
                    $type = "integer";
                if (is_null($variable))
                    $type = "null";
                $salida.= "<p><b>" . $type . ":</b> <span>" . $variable . "</span></p>\n";
            }
        }
        return $salida;
    }
/**
 * genera una cadena formateada para insertar en url de previsualizacion de carros
 * @param type $marca La marca
 * @param type $modelo El modelo
 * @param type $anio el año
 * @return string la cadena formateada
 */

    public static function number_format($numero){
        return number_format($numero, 2, ',', '.');
    }
    public static function date_format($fecha){
        return date('d/m/Y',  strtotime($fecha));
    }
    public static function phone_format($phone){
        return substr($phone, 0, 4)."-".substr($phone, 4, 3).".".substr($phone, 7, 2).".".substr($phone, 9, 2);
    }
    public static function account_format($number){
        return substr($number, 0, 4)."-".substr($number, 4, 4)."-".substr($number, 8, 4)."-".substr($number, 12, 4)."-".substr($number, 16, 4);
    }

}

/**
 * Acortador de URl de Google
 * @author David Walsh
 * @author Anyul Rivas
 * @version 1.1
 */
class GoogleUrlApi {

    var $key = 'AIzaSyDNK-CJQBBisWGj7huMvQSjjmWT8RJkLiA';

    // Constructor
    public function GoogleURLAPI($key= '', $apiURL = 'https://www.googleapis.com/urlshortener/v1/url') {
        if ($key == '')
            $key == $this->key;
        $this->apiURL = $apiURL . '?key=' . $key;
    }

    /**
     * Acorta una url
     * @param String $url
     * @return Boolean
     */
    public function shorten($url) {
        $response = $this->send($url);
        return isset($response['id']) ? $response['id'] : false;
    }

    /**
     * Expande una url acortada
     * @param String $url
     * @return Boolean
     */
    public function expand($url) {
        $response = $this->send($url, false);
        return isset($response['longUrl']) ? $response['longUrl'] : false;
    }

    /**
     * Envía la información a los servidores de Google
     * @param String $url
     * @param Boolean $shorten
     * @return Json
     */
    private function send($url, $shorten = true) {
        $ch = curl_init();
        if ($shorten) {
            curl_setopt($ch, CURLOPT_URL, $this->apiURL);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("longUrl" => $url)));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        } else {
            curl_setopt($ch, CURLOPT_URL, $this->apiURL . '&shortUrl=' . $url);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

}

?>