<?php

class EmpresaEntidad{
    private $codigo_entidad;
    private $ruc;
    private $razon_social;
    private $abreviatura;
    private $direccion;
    private $codigo_ciudad;
    private $dni_funcionario;
    private $apellido_paterno;
    private $apellido_materno;
    private $nombres;
    private $email;
    private $telefono_oficina;
    private $anexo;
    private $celular;
    private $rpc;
    private $rpm;
    private $linea;
    private $acumulado;
    private $estado_registro;
    private $deuda_pendiente;

   // METODOS GET 
   public function getCodigoEntidad(){
       return $this->codigo_entidad;
   }
   public function getRUC(){
       return $this->ruc;
   }
   public function getRazonSocial(){
       return $this->razon_social;
   }
   public function getAbreviatura(){
       return $this->abreviatura;
   }
   public function getDireccion(){
       return $this->direccion;
   }
   public function getCodigoCiudad(){
       return $this->codigo_ciudad;
   }
   public function getDNIFuncionario(){
       return $this->dni_funcionario;
   }
   public function getApellidoPaterno(){
       return $this->apellido_paterno;
   }
   public function getApellioMaterno(){
       return $this->apellido_materno;
   }
   public function getNombres(){
       return $this->nombres;
   }
   public function getEmail(){
       return $this->email;
   }
   public function getTelefonoOficina(){
       return $this->telefono_oficina;
   }
   public function getAnexo(){
       return $this->anexo;
   }
   public function getCelular(){
       return $this->celular;
   }
   public function getRPC(){
       return $this->rpc;
   }
   public function getRPM(){
       return $this->rpm;
   }
   public function getLinea(){
       return $this->linea;
   }
   public function getAcumulado(){
       return $this->acumulado;
   }
   public function getEstadoRegistro(){
       return $this->estado_registro;
   }
   public function getDeudaPendiente() {
       return $this->deuda_pendiente;
   }
   
  // METODOS SET
   public function setCodigoEntidad($codigo_entidad){
       $this->codigo_entidad=$codigo_entidad;
   }
   public function setRUC($ruc){
       $this->ruc=$ruc;
   }
   public function setRazonSocial($razon_social){
       $this->razon_social=$razon_social;
   }
   public function setAbreviatura($abreviatura){
       $this->abreviatura=$abreviatura;
   }
   public function setDireccion($direccion){
       $this->direccion=$direccion;
   }
   public function setCodigoCiudad($codigo_ciudad){
       $this->codigo_ciudad=$codigo_ciudad;
   }
   public function setDNIFuncionario($dni_funcionario){
       $this->dni_funcionario=$dni_funcionario;
   }
   public function setApellidoPaterno($apellido_paterno){
       $this->apellido_paterno=$apellido_paterno;
   }
   public function setApellidoMaterno($apellido_materno){
       $this->apellido_materno=$apellido_materno;
   }
   public function setNombres($nombres){
       $this->nombres=$nombres;
   }
   public function setEmail($email){
       $this->email=$email;
   }
   public function setTelefonoOficina($telefono_oficina){
       $this->telefono_oficina=$telefono_oficina;
   }
   public function setAnexo($anexo){
       $this->anexo=$anexo;
   }
   public function setCelular($celular){
       $this->celular=$celular;
   }
   public function setPPC($rpc){
       $this->rpc=$rpc;
   }
   public function setRPM($rpm){
       $this->rpm=$rpm;
   }
   public function setLinea($linea){
       $this->linea=$linea;
   }
   public function setAcumulado($acumulado){
       $this->acumulado=$acumulado;
   }
   public function setEstadoRegistro($estado_registro){
       $this->estado_registro=$estado_registro;
   }
   public function setDeudaPendiente($deuda_pendiente){
       $this->deuda_pendiente=$deuda_pendiente;
   }
}

?>

