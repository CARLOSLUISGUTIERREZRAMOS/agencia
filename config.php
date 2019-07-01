<?php
    // base directory
	$base_dir = __DIR__;
	// server protocol
    $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    // domain name
    $domain = $_SERVER['SERVER_NAME'];
    // server port
	$port = $_SERVER['SERVER_PORT'];
	$disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
	// nombre proyecto ejm: agencia
	$project_name=basename(dirname(__FILE__));
	
	$url = "${protocol}://${domain}${disp_port}/${project_name}";
	defined("HTML_RECURSO_PATH")
    	or define("HTML_RECURSO_PATH", realpath(dirname(__FILE__) . '/recursos.php')); 
	defined("CABECERA_PATH")
    	or define("CABECERA_PATH", realpath(dirname(__FILE__) . '/cabecera.php'));
    defined("MENU_PATH")
    	or define("MENU_PATH", realpath(dirname(__FILE__) . '/menu.php'));
     
	defined("FOOTER_PATH")
    	or define("FOOTER_PATH", realpath(dirname(__FILE__) . '/footer.php'));
    // defined("CSS_PATH")
    // 	or define("CSS_PATH",  '/cp/css');
    // defined("JS_PATH")
    // 	or define("JS_PATH",  '/cp/js'));
?>