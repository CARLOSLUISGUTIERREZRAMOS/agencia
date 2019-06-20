<?php

class CiudadEntidad{
    private $id_ciudad;
    private $ciudad;
    private $vigente;
    private $id_operador;
    private $enviar;
    private $exonerado;


   // METODOS GET 
   public function getIdCiudad(){
       return $this->id_ciudad;
   }
   public function getCiudad(){
       return $this->ciudad;
   }
   public function getVigente(){
       return $this->vigente;
   }
   public function getIdOperador(){
       return $this->id_operador;
   }
   public function getEnviar(){
       return $this->enviar;
   }
   public function getExonerado(){
       return $this->exonerado;
   }
   
   
   //METEDOS SET
   public function setIdCiudad($id_ciudad){
       $this->id_ciudad=$id_ciudad;
   }
   public function setCiudad($ciudad){
       $this->ciudad=$ciudad;
   }
   public function setVigente($vigente){
       $this->vigente=$vigente;
   }
   public function setIdOperador($id_operador){
       $this->id_operador=$id_operador;
   }
   public function setEnviar($enviar){
       $this->enviar=$enviar;
   }
   public function setExonerado($exonerado){
       $this->exonerado=$exonerado;
   }
   
}