<?php
require_once 'phpUserAgent.php';
require_once 'phpUserAgentStringParser.php';
$userAgent = new phpUserAgent();
if($userAgent->getEngine()!='trident' && $userAgent->getEngine()!='webkit' && $userAgent->getEngine()!='gecko'){
   //   header('Location:http://www.starperu.com');
   echo "No provienes de un navegador, lo sentimos.";
   die;
}  
?>