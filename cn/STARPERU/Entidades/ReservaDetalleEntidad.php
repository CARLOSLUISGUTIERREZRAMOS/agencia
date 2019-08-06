<?php

class ReservaDetalleEntidad{
    private $registro;
    private $detalle;
    private $tipo_doc;
    private $documento;
    private $apellidos;
    private $apellidos2;
    private $nombres;
    private $tipo_pax;
    private $ddi_celular;
    private $pre_celular;
    private $celular;
    private $ddi_telefono;
    private $pre_telefono;
    private $telefono;
    private $anexo;
    private $email;
    private $ticket;
    private $EQ;
    private $FA;
    private $MS;
    private $PE;
    private $HW;
    private $total;
    private $total_pagar;
    private $referencia;
    private $codigo_tipo;
    private $vuelo_salida;
    private $fecha_salida;
    private $hora_salida;
    private $vuelo_retorno;
    private $fecha_retorno;
    private $hora_retorno;
    private $fecha_registro;
    private $estado_registro;

   // METODOS GET 
   public function getRegistro(){
       return $this->registro;
   }
   public function getDetalle(){
       return $this->detalle;
   }
   public function getTipoDoc(){
       return $this->tipo_doc;
   }
   public function getDocumento(){
       return $this->documento;
   }
   public function getApellidos(){
       return $this->apellidos;
   }
   public function getApellidos2(){
       return $this->apellidos2;
   }
    public function getNombres(){
       return $this->nombres;
   }
   public function getTipoPax(){
       return $this->tipo_pax;
   }
   public function getDdiCelular(){
       return $this->ddi_celular;
   }
   public function getPreCelular(){
       return $this->pre_celular;
   }
   public function getCelular(){
       return $this->celular;
   }
  
   public function getDdiTelefono(){
       return $this->ddi_telefono;
   }
   public function getPreTelefono(){
       return $this->pre_telefono;
   }
   public function getTelefono(){
       return $this->telefono;
   }
  
   public function getAnexo(){
       return $this->rpc;
   }
   
   public function getEmail(){
       return $this->email;
   }
   public function getTicket(){
       return $this->ticket;
   }
   public function getEQ(){
       return $this->EQ;
   }
   public function getFA(){
       return $this->FA;
   }
   public function getMS(){
       return $this->MS;
   }
   public function getPE(){
       return $this->PE;
   }
   public function getHW(){
       return $this->HW;
   }
   public function getTotal(){
       return $this->total;
   }
   public function getTotalPagar(){
       return $this->total_pagar;
   }
   public function getReferencia(){
       return $this->referencia;
   }
   public function getCodigoTipo(){
       return $this->codigo_tipo;
   }
   public function getVueloSalida(){
       return $this->vuelo_salida;
   }
   public function getFechaSalida(){
       return $this->fecha_salida;
   }
   public function getHoraSalida(){
       return $this->hora_salida;
   }
   public function getVueloRetorno(){
       return $this->vuelo_retorno;
   }
   public function getFechaRetorno(){
       return $this->fecha_retorno;
   }
   public function getHoraRetorno(){
       return $this->hora_retorno;
   }
   public function getFechaRegistro(){
       return $this->fecha_registro;
   }
   public function getEstadoRegistro(){
       return $this->estado_registro;
   }
   public function getComisionTarifa(){
       return $this->comision_tarifa;
   }
   
  // METODOS SET
   public function setRegistro($registro){
       $this->registro=$registro;
   }
   public function setDetalle($detalle){
       $this->detalle=$detalle;
   }
   public function setTipoDoc($tipo_doc){
       $this->tipo_doc=$tipo_doc;
   }
   public function setDocumento($documento){
       $this->documento=$documento;
   }
   public function setApellidos($apellidos){
       $this->apellidos=$apellidos;
   }
   public function setApellidos2($apellidos2){
       $this->apellidos2=$apellidos2;
   }
   public function setNombres($nombres){
       $this->nombres=$nombres;
   }
   public function setTipoPax($tipo_pax){
       $this->tipo_pax=$tipo_pax;
   }
   public function setDdiCelular($ddi_celular){
       $this->ddi_celular=$ddi_celular;
   }
   public function setPreCelular($pre_celular){
       $this->pre_celular=$pre_celular;
   }
   public function setCelular($celular){
       $this->celular=$celular;
   }
   public function setDdiTelefono($ddi_telefono){
       $this->ddi_telefono=$ddi_telefono;
   }
   public function setPreTelefono($pre_telefono){
       $this->pre_telefono=$pre_telefono;
   }
   public function setTelefono($telefono){
       $this->telefono=$telefono;
   }
   public function setAnexo($anexo){
       $this->anexo=$anexo;
   }

   public function setEmail($email){
       $this->email=$email;
   }
   public function setTicket($ticket){
       $this->ticket=$ticket;
   }
   public function setEQ($EQ){
       $this->EQ=$EQ;
   }
   public function setFA($FA){
       $this->FA=$FA;
   }
   public function setMS($MS){
       $this->MS=$MS;
   }
   public function setPE($PE){
       $this->PE=$PE;
   }
   public function setHW($HW){
       $this->HW=$HW;
   }
   public function setTotal($total){
       $this->total=$total;
   }
   public function setTotalPagar($total_pagar){
       $this->total_pagar=$total_pagar;
   }
   public function setReferencia($referencia){
       $this->referencia=$referencia;
   }
   public function setCodigoTipo($codigo_tipo){
       $this->codigo_tipo=$codigo_tipo;
   }
   public function setVueloSalida($vuelo_salida){
       $this->vuelo_salida=$vuelo_salida;
   }
   public function setFechaSalida($fecha_salida){
       $this->fecha_salida=$fecha_salida;
   }
   public function setHoraSalida($hora_salida){
       $this->hora_salida=$hora_salida;
   }
   public function setVuelRetorno($vuelo_retorno){
       $this->vuelo_retorno=$vuelo_retorno;
   }
   public function setFechaRetorno($fecha_retorno){
       $this->fecha_retorno=$fecha_retorno;
   }
   public function setHoraRetorno($hora_retorno){
       $this->hora_retorno=$hora_retorno;
   }
   public function setFechaRegistro($fecha_registro){
       $this->fecha_registro=$fecha_registro;
   }
   public function setEstadoRegistro($estado_registro){
       $this->estado_registro=$estado_registro;
   }
   public function setComisionTarifa($comision_tarifa){
       $this->comision_tarifa=$comision_tarifa;
   }

}

?>

