<?php

class ReservaEntidad{
    private $registro;
    private $codigo_reserva;
    private $apellidos;
    private $nombres;
    private $tipo_doc;
    private $documento;
    private $codigo_transaccion;
    private $codigo_salida;
    private $codigo_retorno;
    private $ddi_celular;
    private $pre_celular;
    private $celular;
    private $ddi_telefono;
    private $pre_telefono;
    private $telefono;
    private $email;
    private $fecha_registro;
    private $fecha_limite;
    private $tipo_vuelo;
    private $adultos;
    private $ninos;
    private $bebes;
    private $origen;
    private $destino;
    private $vuelo_salida;
    private $clase_salida;
    private $fecha_salida;
    private $hora_salida;
    private $vuelo_retorno;
    private $clase_retorno;
    private $fecha_retorno;
    private $hora_retorno;
    private $pais;
    private $ciudad;
    private $ip;
    private $ticket=array();
    private $flete;
    private $TUA;
    private $impuesto;
    private $total;
    private $codigo_entidad;
    private $codigo_personal;
    private $estado_registro;
    private $ruc_pasajero;

   // METODOS GET 
   public function getRegistro(){
       return $this->registro;
   }
   public function getCodigoReserva(){
       return $this->codigo_reserva;
   }
   public function getApellidos(){
       return $this->apellidos;
   }
    public function getNombres(){
       return $this->nombres;
   }
   public function getTipoDoc(){
       return $this->tipo_doc;
   }
   public function getDocumento(){
       return $this->documento;
   }
   public function getCodigoTransaccion(){
       return $this->codigo_transaccion;
   }
   public function getCodigoSalida(){
       return $this->codigo_salida;
   }

   public function getCodigoRetorno(){
       return $this->codigo_retorno;
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
   public function getEmail(){
       return $this->email;
   }
   public function getFechaRegistro(){
       return $this->fecha_registro;
   }
   public function getFechaLimite(){
       return $this->fecha_limite;
   }
   public function getTipoVuelo(){
       return $this->tipo_vuelo;
   }
   public function getAdultos(){
       return $this->adultos;
   }
   public function getNinos(){
       return $this->ninos;
   }
   public function getBebes(){
       return $this->bebes;
   }
   public function getOrigen(){
       return $this->origen;
   }
   public function getDestino(){
       return $this->destino;
   }
   public function getVueloSalida(){
       return $this->vuelo_salida;
   }
   public function getClaseSalida(){
       return $this->clase_salida;
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
   public function getClaseRetorno(){
       return $this->clase_retorno;
   }
    public function getFechaRetorno(){
       return $this->fecha_retorno;
   }
   public function getHoraRetorno(){
       return $this->hora_retorno;
   }
   public function getPais(){
       return $this->pais;
   }
   public function getCiudad(){
       return $this->ciudad;
   }
   public function getIP(){
       return $this->ip;
   }
   public function getTicket(){
       return $this->ticket;
   }
    public function getFlete(){
       return $this->flete;
   }
   public function getTUA(){
       return $this->TUA;
   }
   public function getImpuesto(){
       return $this->impuesto;
   }
   public function getTotal(){
       return $this->total;
   }
   public function getCodigoEntidad(){
       return $this->codigo_entidad;
   }
   public function getCodigoPersonal(){
       return $this->codigo_personal;
   }
   public function getEstadoRegistro(){
       return $this->estado_registro;
   }
   public function getRUCPasajero(){
      return $this->ruc_pasajero;
   }
   public function getPorcentaje(){
       return $this->porcentaje;
   }

  // METODOS SET
  
    public function setRegistro($registro){
      $this->registro=$registro;
   }
   public function setCodigoReserva($codigo_reserva){
       $this->codigo_reserva=$codigo_reserva;
   }
   public function setApellidos($apellidos){
      $this->apellidos=$apellidos;
   }
    public function setNombres($nombres){
      $this->nombres=$nombres;
   }
   public function setTipoDoc($tipo_doc){
       $this->tipo_doc=$tipo_doc;
   }
   public function setDocumento($documento){
       $this->documento=$documento;
   }
   public function setCodigoTransaccion($codigo_transaccion){
       $this->codigo_transaccion=$codigo_transaccion;
   }
   public function setCodigoSalida($codigo_salida){
       $this->codigo_salida=$codigo_salida;
   }
   public function setCodigoRetorno($codigo_retorno){
       $this->codigo_retorno=$codigo_retorno;
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
   public function setEmail($email){
       $this->email=$email;
   }
   public function setFechaRegistro($fecha_registro){
       return $this->fecha_registro=$fecha_registro;
   }
   public function setFechaLimite($fecha_limite){
       $this->fecha_limite=$fecha_limite;
   }
   public function setTipoVuelo($tipo_vuelo){
       $this->tipo_vuelo=$tipo_vuelo;
   }
   public function setAdultos($adultos){
        $this->adultos=$adultos;
   }
   public function setNinos($ninos){
        $this->ninos=$ninos;
   }
   public function setBebes($bebes){
       $this->bebes=$bebes;
   }
   public function setOrigen($origen){
      $this->origen=$origen;
   }
   public function setDestino($destino){
       $this->destino=$destino;
   }
   public function setVueloSalida($vuelo_salida){
       $this->vuelo_salida=$vuelo_salida;
   }
   public function setClaseSalida($clase_salida){
       $this->clase_salida=$clase_salida;
   }
   public function setFechaSalida($fecha_salida){
       $this->fecha_salida=$fecha_salida;
   }
   public function setHoraSalida($hora_salida){
       $this->hora_salida=$hora_salida;
   }
   
   public function setVueloRetorno($vuelo_retorno){
       $this->vuelo_retorno=$vuelo_retorno;
   }
   public function setClaseRetorno($clase_retorno){
       $this->clase_retorno=$clase_retorno;
   }
    public function setFechaRetorno($fecha_retorno){
       $this->fecha_retorno=$fecha_retorno;
   }
   public function setHoraRetorno($hora_retorno){
       $this->hora_retorno=$hora_retorno;
   }
   public function setPais($pais){
       $this->pais=$pais;
   }
   public function setCiudad($ciudad){
       $this->ciudad=$ciudad;
   }
   public function setIP($ip){
       $this->ip=$ip;
   }
   public function setTicket($ticket){
       $this->ticket[]=$ticket;
   }
    public function setFlete($flete){
       $this->flete=$flete;
   }
   public function setTUA($TUA){
      $this->TUA=$TUA;
   }
   public function setImpuesto($impuesto){
       $this->impuesto=$impuesto;
   }
   public function setTotal($total){
       $this->total=$total;
   }
   public function setCodigoEntidad($codigo_entidad){
       $this->codigo_entidad=$codigo_entidad;
   }
   public function setCodigoPersonal($codigo_personal){
       $this->codigo_personal=$codigo_personal;
   }
   public function setEstadoRegistro($estado_registro){
       $this->estado_registro=$estado_registro;
   }
   public function setRUCPasajero($ruc_pasajero){
       $this->ruc_pasajero=$ruc_pasajero;
   }
   public function setPorcentaje($porcentaje){
       $this->porcentaje=$porcentaje;
   }
}

?>

