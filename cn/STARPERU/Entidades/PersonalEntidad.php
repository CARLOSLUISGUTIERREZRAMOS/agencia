<?php

class PersonalEntidad{
    private $codigo_personal;
    private $codigo_entidad;
    private $dni;
    private $apellido_paterno;
    private $apellido_materno;
    private $nombres;
    private $email;
    private $telefono_oficina;
    private $anexo;
    private $celular;
    private $rpc;
    private $rpm;
    private $nextel;
    private $codigo_tipo;
    private $estado;
    private $presentacion;
    private $cambio_clave;
    private $codigo_usuario;
    private $password;
    private $idDepartamento;
    private $idProvincia;
    private $idDistrito;
    private $estado_registro;
    
    
   public function getCodigoPersonal(){
       return $this->codigo_personal;
   }
   public function getCodigoEntidad(){
       return $this->codigo_entidad;
   }
   public function getDNI(){
       return $this->dni;
   }
   public function getApellidoPaterno(){
       return $this->apellido_paterno;
   }
   public function getApellidoMaterno(){
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
   public function getNextel(){
       return $this->nextel;
   }
   public function getCodigoTipo(){
       return $this->codigo_tipo;
   }
   public function getEstado(){
       return $this->estado;
   }
   public function getPresentacion(){
       return $this->presentacion;
   }
   public function getCambioClave(){
       return $this->cambio_clave;
   }
   public function getCodigoUsuario(){
       return $this->codigo_usuario;
   }
   public function getPassword(){
       return $this->password;
   }
   public function getEstadoRegistro(){
       return $this->estado_registro;
   }
   public function getIdDepartamento(){
       return $this->idDepartamento;
   }
   public function getIdProvincia(){
       return $this->idProvincia;
   }
   public function getIdDistrito(){
       return $this->idDistrito;
   }
   
   public function setCodigoPersonal($codigo_personal){
       $this->codigo_personal=$codigo_personal;
   }
   public function setCodigoEntidad($codigo_entidad){
       $this->codigo_entidad=$codigo_entidad;
   }
   public function setDNI($dni){
       $this->dni=$dni;
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
   public function setRPC($rpc){
       $this->rpc=$rpc;
   }
   public function setRPM($rpm){
       $this->rpm=$rpm;
   }
   public function setNextel($nextel){
       $this->nextel=$nextel;
   }
   public function setCodigoTipo($codigo_tipo){
       $this->codigo_tipo=$codigo_tipo;
   }
   public function setEstado($estado){
       $this->estado=$estado;
   }
   public function setPresentacion($presentacion){
       $this->presentacion=$presentacion;
   }
   public function setCambioClave($cambio_clave){
       $this->cambio_clave=$cambio_clave;
   }
   public function setCodigoUsuario($codigo_usuario){
       $this->codigo_usuario=$codigo_usuario;
   }
   public function setPassword($password){
       $this->password=$password;
   }
   public function setEstadoRegistro($estado_registro){
       $this->estado_registro=$estado_registro;
   }
   public function setIdDepartamento($idDepartamento){
       $this->idDepartamento=$idDepartamento;
   }
   public function setIdProvincia($idProvincia){
       $this->idProvincia=$password;
   }
   public function setIdDistrito($idDistrito){
       $this->idDistrito=$idDistrito;
   }
}


?>

