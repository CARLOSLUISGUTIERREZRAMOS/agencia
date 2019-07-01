<?php
	defined("HTML_RECURSO_PATH")
    	or define("HTML_RECURSO_PATH", realpath(dirname(__FILE__) . '/recursos.php')); 
	defined("CABECERA_PATH")
    	or define("CABECERA_PATH", realpath(dirname(__FILE__) . '/cabecera.php'));
    defined("MENU_PATH")
    	or define("MENU_PATH", realpath(dirname(__FILE__) . '/menu.php'));
     
	defined("FOOTER_PATH")
    	or define("FOOTER_PATH", realpath(dirname(__FILE__) . '/footer.php'));
    defined("CSS_PATH")
    	or define("CSS_PATH", realpath(dirname(__FILE__) . '/cp/css/'));
    defined("JS_PATH")
    	or define("JS_PATH", realpath(dirname(__FILE__) . '/cp/js/'));
?>