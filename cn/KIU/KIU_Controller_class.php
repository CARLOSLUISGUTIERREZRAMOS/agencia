<?php
include "KIU_Model_class.php";
class KIU_Controller extends KIU_Model
{
    function KIU_Controller()
    {
    	$this->TimeStamp = date("c");
    }
    public function AirAvailRQ($args,&$err)
    {
        $this->ErrorCode=0;
        $this->ErrorMsg='';
		$xml = $this->Model_AirAvailRQ($args);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
        $err=array('ErrorCode'=>$this->ErrorCode, 'ErrorMsg'=>$this->ErrorMsg);
		return $array;
    }
    
    public function AirBookRQ($args,&$err)
    {
        $this->ErrorCode=0;
        $this->ErrorMsg='';
        $xml = $this->Model_AirBookRQ($args);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        $err=array('ErrorCode'=>$this->ErrorCode, 'ErrorMsg'=>$this->ErrorMsg);
        return $array;
    }

    public function AirPriceRQ($args,&$err)
    {
        $this->ErrorCode=0;
        $this->ErrorMsg='';
        $xml = $this->Model_AirPriceRQ($args);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        $err=array('ErrorCode'=>$this->ErrorCode, 'ErrorMsg'=>$this->ErrorMsg);
        return $array;
    }

    public function AirDemandTicketRQ($args,&$err)
    {
        $this->ErrorCode=0;
        $this->ErrorMsg='';
		$respuesta_model = $this->Model_AirDemandTicketRQ($args);
        $xml=$respuesta_model[0];
        $json = json_encode($xml);
		$array = json_decode($json,TRUE);
        $err=array('ErrorCode'=>$this->ErrorCode, 'ErrorMsg'=>$this->ErrorMsg);
        $salida=array();
        $salida[]=$array;
        $salida[]=$respuesta_model[1];
        $salida[]=$respuesta_model[2];
        $salida[]=$respuesta_model[3];
		return $salida;
    }
 
    public function TravelItineraryReadRQ($args,&$err)
    {
        $this->ErrorCode=0;
        $this->ErrorMsg='';
		$xml = $this->Model_TravelItineraryReadRQ($args);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
        $err=array('ErrorCode'=>$this->ErrorCode, 'ErrorMsg'=>$this->ErrorMsg);
		return $array;
    }

    public function TravelItineraryReadRQPnr($args,&$err)
    {   
        $this->ErrorCode=0;
        $this->ErrorMsg='';
        $respuesta_model = $this->Model_TravelItineraryReadRQPnr($args);
        $xml=$respuesta_model[0];
        $json = json_encode($xml);
		$array = json_decode($json,TRUE);
        $err=array('ErrorCode'=>$this->ErrorCode, 'ErrorMsg'=>$this->ErrorMsg);
        $salida=array();
        $salida[]=$array;
        $salida[]=$respuesta_model[1];
        $salida[]=$respuesta_model[2];
        $salida[]=$respuesta_model[3];
		return $salida;
    }

    public function AirCancelRQ($args,&$err)
    {
        $this->ErrorCode=0;
        $this->ErrorMsg='';
	    $xml = $this->Model_AirCancelRQ($args);
	    $json = json_encode($xml);
	    $array = json_decode($json,TRUE);
        $err=array("ErrorCode"=>$this->ErrorCode, "ErrorMsg"=>$this->ErrorMsg);
	    return $array;
    }
    
    public function AirRulesRQ($args,&$err){
        $this->ErrorCode=0;
        $this->ErrorMsg='';
	    $xml = $this->Model_AirRulesRQ($args);
	    $json = json_encode($xml);
	    $array = json_decode($json,TRUE);
        $err=array("ErrorCode"=>$this->ErrorCode, "ErrorMsg"=>$this->ErrorMsg);
	    return $array;
    }
    
    public function AirFareDisplayRQ($args,&$err){
        $this->ErrorCode=0;
        $this->ErrorMsg='';
	    $xml = $this->Model_AirFareDisplayRQ($args);
	    $json = json_encode($xml);
	    $array = json_decode($json,TRUE);
        $err=array("ErrorCode"=>$this->ErrorCode, "ErrorMsg"=>$this->ErrorMsg);
	    return $array;
    }
 }
 ?>