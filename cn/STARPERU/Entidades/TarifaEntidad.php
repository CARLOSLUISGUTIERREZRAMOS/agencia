<?php

class TarifaEntidad{
    private $nombre_familia;
    private $clase;
    private $tarifa;
    

   // METODOS GET 
   public function getNombreFamilia(){
       return $this->nombre_familia;
   }
   public function getClase(){
       return $this->clase;
   }
   public function getTarifa(){
       return $this->tarifa;
   }
  
   
  // METODOS SET
   public function setNombreFamilia($nombre_familia){
       $this->nombre_familia=$nombre_familia;
   }
   public function setClase($clase){
       $this->clase=$clase;
   }
   public function setTarifa($tarifa){
       $this->tarifa=$tarifa;
   }
   
}

?>

