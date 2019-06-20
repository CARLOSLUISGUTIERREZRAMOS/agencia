<?php
date_default_timezone_set('America/Lima');
require_once("../../cn/KIU/KIU_Controller_class.php");
$KIU = new KIU_Controller(array());


   $res = $KIU->AirCancelRQ(array('IdReserva'=> 'WWBKDR', 'IdTicket' => '1560201065094'),$err);
   echo "<pre>";
   var_dump($res);
   echo "</pre>";
   

