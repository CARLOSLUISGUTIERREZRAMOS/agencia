<?php

require_once("../../cn/STARPERU/Conexion/ConexionBD.php");
require_once("../../cn/STARPERU/Entidades/ReservaEntidad.php");
require_once("../../cn/STARPERU/Entidades/ReservaDetalleEntidad.php");
require_once("../../cn/STARPERU/Entidades/EmpresaEntidad.php");

class ReservaModelo{
    
    private $basedatos='db_agencia';
    
    public function ActualizarReserva($data){

    }

    public function ObtenerDataRerservaVisa($id_reserva){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT * FROM reserva WHERE Registro = $id_reserva";
        
        $resultado = $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        return $resultado;

    }
    
    public function ObtenerDatosPasajero($tipo_doc,$num_doc){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="SELECT Registro,Nombres,Apellidos,Email,Telefono,Anexo,Celular,Nextel,RPM,RPC FROM reserva_detalle WHERE Documento='$num_doc' AND Tipo_Doc='$tipo_doc' ORDER BY Registro DESC LIMIT 1";
        
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        
        if($numero_filas>0){
            $datos_pasajero='';
            $fila=  $obj_conexion->ObtenerDatos($resultado);
            $apellidos=  explode(' ', $fila["Apellidos"]);
            $datos_pasajero.=trim($fila["Nombres"]).'_|_'.trim($apellidos[0]).'_|_'.trim($apellidos[1]).'_|_'.trim($fila["Email"]).'_|_'.trim($fila["Telefono"]).'_|_'.trim($fila["Anexo"]).'_|_'.trim($fila["Celular"]).'_|_'.trim($fila["Nextel"]).'_|_'.trim($fila["RPM"]).'_|_'.trim($fila["RPC"]);
            
            $obj_conexion->CerrarConexion($conexion);
            
            return "OK_|_".$datos_pasajero;
        }else{
            return "ERROR_|_";
        }
        
    }
    
    public function ListaBoletosPorReserva($codigo_reserva,$codigo_entidad){
        $lista_boletos=array();
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="(SELECT     reserva.Registro,
            reserva_detalle.Detalle,
            reserva_detalle.Ticket,
            reserva.TipoVuelo,
            reserva.FechaRegistro,
            '1' Tramo,
            reserva.Vuelo_Salida,
            reserva.Origen,
            reserva.Fecha_Salida,
            reserva.Hora_Salida,
            reserva.Destino,
            reserva.Fecha_Salida,
            (SELECT Tiempo FROM ruta WHERE CodigoCiudadOrigen=reserva.Origen AND CodigoCiudadDestino=reserva.Destino) Duracion,
            reserva.Hora_Salida,
            reserva.Clase_Salida,
            reserva_detalle.Apellidos,
            reserva_detalle.Nombres,
            reserva_detalle.TotalPagar,
            reserva.EstadoRegistro,
            reserva_detalle.EstadoRegistro AS EstadoRegistroDetalle
            FROM reserva, reserva_detalle 
            WHERE reserva.Registro = reserva_detalle.Registro AND reserva.CodigoReserva = '$codigo_reserva' AND reserva.CodigoEntidad='$codigo_entidad' AND reserva_detalle.Ticket<>'' )

            UNION ALL

            (SELECT 
            reserva.Registro,
            reserva_detalle.Detalle,
            reserva_detalle.Ticket,
            reserva.TipoVuelo,
            reserva.FechaRegistro,
            '2' Tramo,
            reserva.Vuelo_Retorno,
            reserva.Destino,
            reserva.Fecha_Retorno,
            reserva.Hora_Retorno,
            reserva.Origen,
            reserva.Fecha_Retorno,
            (SELECT Tiempo FROM ruta WHERE CodigoCiudadOrigen=reserva.Destino AND CodigoCiudadDestino=reserva.Origen) Duracion,
            reserva.Hora_Retorno,
            reserva.Clase_Retorno,
            reserva_detalle.Apellidos,
            reserva_detalle.Nombres,
            reserva_detalle.TotalPagar,
            reserva.EstadoRegistro,
            reserva_detalle.EstadoRegistro AS EstadoRegistroDetalle
            FROM reserva, reserva_detalle 
            WHERE reserva.TipoVuelo = 'R' AND reserva.Registro = reserva_detalle.Registro AND reserva.CodigoReserva = '$codigo_reserva' AND reserva.CodigoEntidad='$codigo_entidad' AND reserva_detalle.Ticket<>'')
            ORDER BY Registro, Detalle,Tramo";
        
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
        
        if($numero_filas>0){
            
            while($fila=  $obj_conexion->ObtenerDatos($resultado)){
                
                      $reserva = new ReservaEntidad();
                      $reserva_detalle = new ReservaDetalleEntidad();
                      $tramo='';
                      $duracion ='';
                      $boleto= array();

                      $reserva_detalle->setTicket($fila['Ticket']);
                      $reserva->setTipoVuelo($fila['TipoVuelo']);
                      $reserva->setFechaRegistro($fila['FechaRegistro']);
                      $tramo= $fila['Tramo'];
                      
                      $reserva->setVueloSalida($fila['Vuelo_Salida']);                 
                      $reserva->setOrigen($fila['Origen']);
                      $reserva->setFechaSalida($fila['Fecha_Salida']);
                      $reserva->setHoraSalida($fila['Hora_Salida']);
                      
                      $reserva->setDestino($fila['Destino']);                 
                      $duracion= $fila['Duracion'];
                      $reserva->setClaseSalida($fila['Clase_Salida']);   
                      $reserva_detalle->setApellidos($fila['Apellidos']); 
                      $reserva_detalle->setNombres($fila['Nombres']); 
                      $reserva_detalle->setTotalPagar($fila['TotalPagar']); 
                      $reserva_detalle->setEstadoRegistro($fila['EstadoRegistroDetalle']); 

                      
                      $boleto[]=$reserva;
                      $boleto[]=$reserva_detalle;
                      $boleto[]=$tramo;
                      $boleto[]=$duracion;
                      $lista_boletos[]=$boleto;
            }
            
            $obj_conexion->CerrarConexion($conexion);
            
           return $lista_boletos;
        }else{
           return "";
        }
        
    }

    public function IdReserva($codigo_reserva){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="SELECT Registro FROM reserva WHERE CodigoReserva = '$codigo_reserva'";
        $resultado = $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $fila = $obj_conexion->ObtenerDatos($resultado);
        return $fila['Registro'];
        $obj_conexion->CerrarConexion($conexion);
    }

    public function ListaMovimientos($codigo_entidad,$fecha_inicio,$fecha_fin,$usuario_dni,$boleto,$pnr,$limit,$extra,$formaPago,$estado){
        $filtro='';
         if($fecha_inicio!='' and $fecha_fin!=''){
            $filtro.=" AND r.FechaRegistro BETWEEN '$fecha_inicio 00:00:00' AND '$fecha_fin 23:59:59'";
        }
        if($boleto!=''){
            $filtro.=" AND rd.Ticket='$boleto'";
        }
        if($pnr!=''){
            $filtro.=" AND r.CodigoReserva='$pnr'";
        }
        if($formaPago!=''){
            $filtro.=" AND r.forma_pago='$formaPago'";
        }
         if($usuario_dni!=''){
             $filtro.="AND p.CodigoPersonal = r.CodigoPersonal  AND p.DNI='$usuario_dni'";
         }
         if($estado!=''){
             $filtro.="AND r.Registro = v.reserva_id  AND v.anulado='$estado'";
         }
//        if($usuario!=''){
//            $filtro.=" AND (SELECT CASE Tipo WHEN 'G' THEN '' WHEN 'DNI' THEN DNI END FROM Personal WHERE Personal.CodigoPersonal = Reserva.CodigoPersonal)='$usuario'";
//        }
        if($extra==1){
            $limite= $limit;
        }else{
            $limite='';
        }
        $lista_movimientos=array();
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="(SELECT r.Registro,
                           rd.Detalle, 
                           rd.ComisionTarifa, 
                           r.Porcentaje, 
                           r.RUC as ruc_pasajero,
                           r.CodigoReserva,
                           rd.Celular,
                           v.brand,
                          v.card,
                          v.purchase_number,
                          v.fechahora_transaccion,
                          v.amount,
                          v.quota_number,
                           e.RUC,  
                           'EM' Tipo_Operacion,     
                           r.FechaRegistro,
                           rd.Ticket,
                           SUBSTRING_INDEX(rd.Apellidos, ' ', 1) PAS_APEP,
                           SUBSTRING_INDEX(rd.Apellidos, ' ', -1) PAS_APEM,
                           rd.Nombres PAS_NOMB,
                          (SELECT DNI FROM personal as p WHERE CodigoEntidad = e.CodigoEntidad AND CodigoTipo = 'G' AND EstadoRegistro = 1 LIMIT 1) Gestor,
                          (SELECT CASE Tipo WHEN 'Administrador' THEN '' WHEN 'Counter' THEN DNI END FROM personal as p WHERE p.CodigoPersonal = r.CodigoPersonal) 'Usuario',
                          CONCAT(p.Nombres,' ',p.ApellidoPaterno,' ',p.ApellidoMaterno) 'NomUsuario',
                          '1' Cantidad,	
                          CASE r.TipoVuelo WHEN 'O' THEN 'OW' WHEN 'R' THEN 'RT' END 'TipoVuelo',
                          '1' Tramo,
                          CONCAT('2I ', r.Vuelo_Salida) 'Vuelo_Salida',
                          r.Origen,
                          CAST(CONCAT(CAST(DATE(r.Fecha_Salida) AS CHAR), ' ', r.Hora_Salida) AS DATETIME) HoraVueloSalida,
                          r.Destino,
                          DATE_ADD(CAST(CONCAT(CAST(DATE(r.Fecha_Salida) AS CHAR), ' ' , r.Hora_Salida) AS DATETIME),INTERVAL (SELECT IFNULL(Minutos, 0) FROM ruta WHERE CodigoCiudadOrigen = r.Origen AND CodigoCiudadDestino = r.Destino) MINUTE)  HoraVueloRetorno,
                          CONCAT(rd.Documento) Documento,
                          ROUND(rd.EQ, 2) Tarifa,
                            ROUND(rd.PE, 2) IGV,
                            ROUND(rd.HW, 2) TUUA,
                            ROUND(rd.TotalPagar, 2) TotalPagar,
                            rd.EstadoRegistro		
                      FROM reserva as r
                      INNER JOIN reserva_detalle as rd ON rd.Registro = r.Registro 
                      LEFT JOIN personal as p ON r.CodigoPersonal = p.CodigoPersonal
                      LEFT JOIN entidad as e ON p.CodigoEntidad = e.CodigoEntidad 
                      LEFT JOIN visa as v ON v.reserva_id= r.Registro
		      WHERE e.CodigoEntidad = $codigo_entidad $filtro)

                    UNION ALL

                    (SELECT r.Registro,
                         rd.Detalle,
                         rd.ComisionTarifa, 
                         r.Porcentaje, 
                         r.RUC as ruc_pasajero,
                         r.CodigoReserva,
                         rd.Celular,
                         v.brand,
                          v.card,
                          v.purchase_number,
                          v.fechahora_transaccion,
                          v.amount,
                          v.quota_number,
                          e.RUC,  
                          'EM' Tipo_Operacion,
                          r.FechaRegistro,
                          rd.Ticket,
                          SUBSTRING_INDEX(rd.Apellidos, ' ', 1) PAS_APEP,
                           SUBSTRING_INDEX(rd.Apellidos, ' ', -1)PAS_APEM,
                            rd.Nombres PAS_NOMB,
                          (SELECT DNI FROM personal as p WHERE CodigoEntidad = e.CodigoEntidad AND CodigoTipo = 'G' AND EstadoRegistro = 1 LIMIT 1) Gestor,
                          (SELECT CASE Tipo WHEN 'Administrador' THEN '' WHEN 'Counter' THEN DNI END FROM personal as p WHERE p.CodigoPersonal = r.CodigoPersonal) 'Usuario',
                          CONCAT(p.Nombres,' ',p.ApellidoPaterno,' ',p.ApellidoMaterno) 'NomUsuario',                          
                          '1' Cantidad,	
                          CASE r.TipoVuelo WHEN 'O' THEN 'OW' WHEN 'R' THEN 'RT' END 'TipoVuelo',
                          '2' Tramo,
                          CONCAT('2I ', r.Vuelo_Retorno) 'Vuelo_Salida',
                          r.Destino,
                          CAST(CONCAT(CAST(DATE(r.Fecha_Retorno) AS CHAR), ' ', r.Hora_Retorno) AS DATETIME),
                          r.Origen,
                          DATE_ADD(CAST(CONCAT(CAST(DATE(r.Fecha_Retorno) AS CHAR), ' ', r.Hora_Retorno) AS DATETIME), INTERVAL (SELECT IFNULL(Minutos, 0) FROM ruta WHERE CodigoCiudadOrigen = r.Destino AND CodigoCiudadDestino = r.Origen) MINUTE),
                          CONCAT(rd.Documento) Documento,
                          ROUND(rd.EQ, 2) Tarifa,
                          ROUND(rd.PE, 2) IGV,
                          ROUND(rd.HW, 2) TUUA,
                          ROUND(rd.TotalPagar, 2) TotalPagar,
                          rd.EstadoRegistro	
			FROM reserva as r
			INNER JOIN reserva_detalle as rd ON rd.Registro = r.Registro 
			LEFT JOIN personal as p ON r.CodigoPersonal = p.CodigoPersonal
			LEFT JOIN entidad as e ON p.CodigoEntidad = e.CodigoEntidad 
			LEFT JOIN visa as v ON v.reserva_id= r.Registro
			WHERE  r.TipoVuelo = 'R' AND e.CodigoEntidad =  $codigo_entidad $filtro)
                    
                        ORDER BY Registro ,Detalle, Tramo   $limite";
        
//        $consulta="(SELECT reserva.Registro,
//                           reserva_detalle.Detalle, 
//                           reserva_detalle.ComisionTarifa, 
//                           reserva.Porcentaje, 
//                           reserva.RUC as ruc_pasajero,
//                           reserva.CodigoReserva,
//                           reserva_detalle.Celular,
//                           visa.*,
//                           E.RUC,  
//                           'EM' Tipo_Operacion,     
//                           reserva.FechaRegistro,
//                           reserva_detalle.Ticket,
//                           SUBSTRING_INDEX(reserva_detalle.Apellidos, ' ', 1) PAS_APEP,
//                           SUBSTRING_INDEX(reserva_detalle.Apellidos, ' ', -1) PAS_APEM,
//                           reserva_detalle.Nombres PAS_NOMB,
//                          (SELECT DNI FROM personal WHERE CodigoEntidad = E.CodigoEntidad AND CodigoTipo = 'G' AND EstadoRegistro = 1 LIMIT 1) Gestor,
//                          (SELECT CASE Tipo WHEN 'Administrador' THEN '' WHEN 'Counter' THEN DNI END FROM personal WHERE personal.CodigoPersonal = reserva.CodigoPersonal) 'Usuario',
//                          CONCAT(personal.Nombres,' ',personal.ApellidoPaterno,' ',personal.ApellidoMaterno) 'NomUsuario',
//                          '1' Cantidad,	
//                          CASE reserva.TipoVuelo WHEN 'O' THEN 'OW' WHEN 'R' THEN 'RT' END 'TipoVuelo',
//                          '1' Tramo,
//                          CONCAT('2I ', reserva.Vuelo_Salida) 'Vuelo_Salida',
//                          reserva.Origen,
//                          CAST(CONCAT(CAST(DATE(reserva.Fecha_Salida) AS CHAR), ' ', reserva.Hora_Salida) AS DATETIME) HoraVueloSalida,
//                          reserva.Destino,
//                          DATE_ADD(CAST(CONCAT(CAST(DATE(reserva.Fecha_Salida) AS CHAR), ' ' , reserva.Hora_Salida) AS DATETIME),INTERVAL (SELECT IFNULL(Minutos, 0) FROM ruta WHERE CodigoCiudadOrigen = reserva.Origen AND CodigoCiudadDestino = reserva.Destino) MINUTE)  HoraVueloRetorno,
//                          CONCAT(reserva_detalle.Documento) Documento,
//                          ROUND(reserva_detalle.EQ, 2) Tarifa,
//                            ROUND(reserva_detalle.PE, 2) IGV,
//                            ROUND(reserva_detalle.HW, 2) TUUA,
//                            ROUND(reserva_detalle.TotalPagar, 2) TotalPagar,
//                            reserva_detalle.EstadoRegistro		
//                      FROM reserva_detalle, reserva, personal, entidad E ,visa
//                      WHERE visa.reserva_id= reserva.Registro AND reserva_detalle.Registro = reserva.Registro AND reserva.CodigoPersonal = personal.CodigoPersonal AND personal.CodigoEntidad = E.CodigoEntidad AND E.CodigoEntidad = $codigo_entidad $filtro)
//
//                    UNION ALL
//
//                    (SELECT reserva.Registro,
//                         reserva_detalle.Detalle,
//                         reserva_detalle.ComisionTarifa, 
//                         reserva.Porcentaje, 
//                         reserva.RUC as ruc_pasajero,
//                         reserva.CodigoReserva,
//                         reserva_detalle.Celular,
//                         visa.*,
//                          E.RUC,  
//                          'EM' Tipo_Operacion,
//                          reserva.FechaRegistro,
//                          reserva_detalle.Ticket,
//                          SUBSTRING_INDEX(reserva_detalle.Apellidos, ' ', 1) PAS_APEP,
//                           SUBSTRING_INDEX(reserva_detalle.Apellidos, ' ', -1)PAS_APEM,
//                            reserva_detalle.Nombres PAS_NOMB,
//                          (SELECT DNI FROM personal WHERE CodigoEntidad = E.CodigoEntidad AND CodigoTipo = 'G' AND EstadoRegistro = 1 LIMIT 1) Gestor,
//                          (SELECT CASE Tipo WHEN 'Administrador' THEN '' WHEN 'Counter' THEN DNI END FROM personal WHERE personal.CodigoPersonal = reserva.CodigoPersonal) 'Usuario',
//                          CONCAT(personal.Nombres,' ',personal.ApellidoPaterno,' ',personal.ApellidoMaterno) 'NomUsuario',                          
//                          '1' Cantidad,	
//                          CASE reserva.TipoVuelo WHEN 'O' THEN 'OW' WHEN 'R' THEN 'RT' END 'TipoVuelo',
//                          '2' Tramo,
//                          CONCAT('2I ', reserva.Vuelo_Retorno) 'Vuelo_Salida',
//                          reserva.Destino,
//                          CAST(CONCAT(CAST(DATE(reserva.Fecha_Retorno) AS CHAR), ' ', reserva.Hora_Retorno) AS DATETIME),
//                          reserva.Origen,
//                          DATE_ADD(CAST(CONCAT(CAST(DATE(reserva.Fecha_Retorno) AS CHAR), ' ', reserva.Hora_Retorno) AS DATETIME), INTERVAL (SELECT IFNULL(Minutos, 0) FROM ruta WHERE CodigoCiudadOrigen = reserva.Destino AND CodigoCiudadDestino = reserva.Origen) MINUTE),
//                          CONCAT(reserva_detalle.Documento) Documento,
//                          ROUND(reserva_detalle.EQ, 2) Tarifa,
//                          ROUND(reserva_detalle.PE, 2) IGV,
//                          ROUND(reserva_detalle.HW, 2) TUUA,
//                          ROUND(reserva_detalle.TotalPagar, 2) TotalPagar,
//                          reserva_detalle.EstadoRegistro	
//                    FROM reserva_detalle, reserva, personal, entidad E , visa
//                    WHERE visa.reserva_id= reserva.Registro AND reserva.TipoVuelo = 'R' AND reserva_detalle.Registro = reserva.Registro AND reserva.CodigoPersonal = personal.CodigoPersonal AND personal.CodigoEntidad = E.CodigoEntidad AND E.CodigoEntidad = $codigo_entidad $filtro)
//
//                   
//                    ORDER BY Registro ,Detalle, Tramo   $limite";
//        
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
      
       
          $cant=0;
        if($numero_filas>0){
          
            while($fila=  $obj_conexion->ObtenerDatos($resultado)){
                    $movimiento=array();
                    $reserva = new ReservaEntidad();
                    $reserva_detalle = new ReservaDetalleEntidad();
                    $empresa=new EmpresaEntidad();
                    $tipo_operacion='';
                    $cantidad=0;
                    $tramo=0;
                    $documento='';
                    $dni_gestor='';
                    $dni_delegago='';
                    $brand='';
                    $card='';
                    $nom_usuario='';
                    $num_compra='';
                    $monto='';
                    $num_cuotas='';
                    $fec_hora_transaccion='';
                    $reserva->setRegistro($fila['Registro']);
                    // $reserva_detalle->setRegistro($fila['Registro_detalle']);
                    $reserva_detalle->setDetalle($fila['Detalle']);
                    $reserva->setRegistro($fila['Registro']);
                    $reserva->setCodigoReserva($fila['CodigoReserva']);
                    $reserva->setRUCPasajero($fila['ruc_pasajero']);
                    $empresa->setRUC($fila['RUC']);
                    $tipo_operacion=$fila['Tipo_Operacion'];
                    $reserva->setFechaRegistro($fila['FechaRegistro']);
                    $reserva_detalle->setTicket($fila['Ticket']);
                    $reserva_detalle->setApellidos($fila['PAS_APEP']);
                    $reserva_detalle->setApellidos2($fila['PAS_APEM']);
                    $reserva_detalle->setNombres($fila['PAS_NOMB']);
                    $dni_gestor=$fila['Gestor'];
                    // $dni_delegado=$fila['Delegado'];
                    $dni_delegado='47922169';
                    $cantidad=$fila['Cantidad'];
                    $reserva->setTipoVuelo($fila['TipoVuelo']);
                    $tramo=$fila['Tramo'];
                    $reserva->setVueloSalida($fila['Vuelo_Salida']);
                    $reserva->setOrigen($fila['Origen']);
                    $reserva->setFechaSalida($fila['HoraVueloSalida']);
                    $reserva->setDestino($fila['Destino']);
                    $reserva->setHoraRetorno($fila['HoraVueloRetorno']);
                    $documento=$fila['Documento'];
                    $reserva_detalle->setEQ($fila['Tarifa']);
                    $reserva_detalle->setPE($fila['IGV']);
                    $reserva_detalle->setHW($fila['TUUA']);
                    $reserva_detalle->setTotalPagar($fila['TotalPagar']);
                    $reserva_detalle->setEstadoRegistro($fila['EstadoRegistro']);
                    $reserva_detalle->setComisionTarifa($fila['ComisionTarifa']);
                    $reserva->setPorcentaje($fila['Porcentaje']);
                    $brand=$fila['brand'];
                    $card=$fila['card'];
                    $nom_usuario=$fila['NomUsuario'];
                    $num_compra=$fila['purchase_number'];
                    $fec_hora_transaccion=$fila['fechahora_transaccion'];
                    $monto=$fila['amount'];
                    $num_cuotas=$fila['quota_number'];
                    $reserva_detalle->setCelular($fila['Celular']);
                    
                    $movimiento[]=$empresa;
                    $movimiento[]=$dni_gestor;
                    $movimiento[]=$dni_delegado;
                    $movimiento[]=$tipo_operacion;
                    $movimiento[]=$cantidad;
                    $movimiento[]=$tramo;
                    $movimiento[]=$documento;
                    $movimiento[]=$reserva;
                    $movimiento[]=$reserva_detalle;
                    $movimiento[]=$brand;
                    $movimiento[]=$card;
                    $movimiento[]=$nom_usuario;
                    $movimiento[]=$num_compra;
                    $movimiento[]=$fec_hora_transaccion;
                    $movimiento[]=$monto;
                    $movimiento[]=$num_cuotas;
                    $lista_movimientos[]=$movimiento;
            }
            $obj_conexion->CerrarConexion($conexion);
        }
           return $lista_movimientos;
    }
    
    public function TotalMovimientos($codigo_entidad,$fecha_inicio,$fecha_fin,$usuario,$boleto,$pnr){
        $filtro='';
         if($fecha_inicio!='' and $fecha_fin!=''){
            $filtro=" AND reserva.FechaRegistro BETWEEN '$fecha_inicio 00:00:00' AND '$fecha_fin 23:59:59'";
        }
        if($boleto!=''){
            $filtro=" AND reserva_detalle.Ticket='$boleto'";
        }
        if($pnr!=''){
            $filtro=" AND reserva.CodigoReserva='$pnr'";
        }
        if($usuario!=''){
            $filtro=" AND (SELECT CASE CodigoTipo WHEN 'G' THEN '' WHEN 'DNI' THEN DNI END FROM personal WHERE personal.CodigoPersonal = reserva.CodigoPersonal)='$usuario'";
        }
        $lista_movimientos=array();
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="SELECT RIGHT(CONCAT('00000000', reserva.Registro),8) Registro,
                            reserva_detalle.Registro as Registro_detalle,
                            reserva_detalle.Detalle, 
                            reserva.CodigoReserva,
                            E.RUC,  
                            'EM' Tipo_Operacion,     
                            reserva.FechaRegistro,
                            reserva_detalle.Ticket,
                            CONCAT(reserva_detalle.Apellidos, ', ', reserva_detalle.Nombres) 'Pasajero',
                            (SELECT DNI FROM personal WHERE CodigoEntidad = E.CodigoEntidad AND CodigoTipo = 'G' AND EstadoRegistro = 1 LIMIT 1) Gestor,
                            (SELECT CASE CodigoTipo WHEN 'G' THEN '' WHEN 'DNI' THEN DNI END FROM personal WHERE personal.CodigoPersonal = reserva.CodigoPersonal) 'Delegado',
                            '1' Cantidad,	
                            CASE reserva.TipoVuelo WHEN 'O' THEN 'OW' WHEN 'R' THEN 'RT' END 'TipoVuelo',
                            '1' Tramo,
                            CONCAT('2I ', reserva.Vuelo_Salida) 'Vuelo_Salida',
                            reserva.Origen,
                            CAST(CONCAT(CAST(DATE(reserva.Fecha_Salida) AS CHAR), ' ', reserva.Hora_Salida) AS DATETIME) HoraVueloSalida,
                            reserva.Destino,
                            DATE_ADD(CAST(CONCAT(CAST(DATE(reserva.Fecha_Salida) AS CHAR), ' ' , reserva.Hora_Salida) AS DATETIME),INTERVAL (SELECT IFNULL(Minutos, 0) FROM Ruta WHERE CodigoCiudadOrigen = reserva.Origen AND CodigoCiudadDestino = reserva.Destino) MINUTE)  HoraVueloRetorno,
                            CONCAT(reserva_detalle.Tipo_Doc, reserva_detalle.Documento) Documento,
                            ROUND(reserva_detalle.TotalPagar, 2) TotalPagar,
                            reserva_detalle.EstadoRegistro		
                      FROM reserva_detalle, reserva, personal, entidad E 
                      WHERE reserva_detalle.Registro = reserva.Registro AND reserva.CodigoPersonal = personal.CodigoPersonal AND personal.CodigoEntidad = E.CodigoEntidad AND E.CodigoEntidad = $codigo_entidad $filtro

                    UNION

                    SELECT RIGHT(CONCAT('00000000', reserva.Registro),8) Registro,
                        reserva.Registro as Registro_detalle,
                         reserva_detalle.Detalle, 
                         reserva.CodigoReserva,
                          E.RUC,  
                          'EM' Tipo_Operacion,
                          reserva.FechaRegistro,
                          reserva_detalle.Ticket,
                          CONCAT(reserva_detalle.Apellidos, ', ', reserva_detalle.Nombres) 'Pasajero',
                          (SELECT DNI FROM personal WHERE CodigoEntidad = E.CodigoEntidad AND CodigoTipo = 'G' AND EstadoRegistro = 1 LIMIT 1) Gestor,
                          (SELECT CASE CodigoTipo WHEN 'G' THEN '' WHEN 'DNI' THEN DNI END FROM personal WHERE personal.CodigoPersonal = reserva.CodigoPersonal) 'Delegado',
                          '1' Cantidad,	
                          CASE reserva.TipoVuelo WHEN 'O' THEN 'OW' WHEN 'R' THEN 'RT' END 'TipoVuelo',
                          '2' Tramo,
                          CONCAT('2I ', reserva.Vuelo_Retorno) 'Vuelo_Salida',
                          reserva.Destino,
                          CAST(CONCAT(CAST(DATE(reserva.Fecha_Retorno) AS CHAR), ' ', reserva.Hora_Retorno) AS DATETIME),
                          reserva.Origen,
                          DATE_ADD(CAST(CONCAT(CAST(DATE(reserva.Fecha_Retorno) AS CHAR), ' ', reserva.Hora_Retorno) AS DATETIME), INTERVAL (SELECT IFNULL(Minutos, 0) FROM Ruta WHERE CodigoCiudadOrigen = reserva.Destino AND CodigoCiudadDestino = reserva.Origen) MINUTE),
                          CONCAT(reserva_detalle.Tipo_Doc, reserva_detalle.Documento) Documento,
                          ROUND(reserva_detalle.TotalPagar, 2) TotalPagar,
                          reserva_detalle.EstadoRegistro	
                    FROM reserva_detalle, reserva, personal, entidad E 
                    WHERE reserva.TipoVuelo = 'R' AND reserva_detalle.Registro = reserva.Registro AND reserva.CodigoPersonal = personal.CodigoPersonal AND personal.CodigoEntidad = E.CodigoEntidad AND E.CodigoEntidad = $codigo_entidad $filtro

                    UNION

                    SELECT RIGHT(CONCAT('00000000', reserva.Registro),8) Registro,
                        reserva.Registro as Registro_detalle,
                         reserva_detalle.Detalle, 
                         reserva.CodigoReserva,
                          E.RUC,  
                          'SA' Tipo_Operacion,
                          reserva.FechaRegistro,
                          reserva_detalle.Ticket,
                          CONCAT(reserva_detalle.Apellidos, ', ', reserva_detalle.Nombres) 'Pasajero',
                          (SELECT DNI FROM personal WHERE CodigoEntidad = E.CodigoEntidad AND CodigoTipo = 'G' AND EstadoRegistro = 1 LIMIT 1) 'Gestor',
                          (SELECT CASE CodigoTipo WHEN 'G' THEN '' WHEN 'DNI' THEN DNI END FROM personal WHERE personal.CodigoPersonal = reserva.CodigoPersonal) 'Delegado',
                          '1' Cantidad,	
                          CASE reserva.TipoVuelo WHEN 'O' THEN 'OW' WHEN 'R' THEN 'RT' END 'TipoVuelo',
                          '1' Tramo,
                          CONCAT('2I ', reserva.Vuelo_Salida) 'Vuelo_Salida',
                          reserva.Origen,
                          CAST(CONCAT(CAST(DATE(reserva.Fecha_Salida) AS CHAR), ' ', reserva.Hora_Salida) AS DATETIME) HoraVueloSalida,
                          reserva.Destino,
                          DATE_ADD(CAST(CONCAT(CAST(DATE(reserva.Fecha_Salida) AS CHAR),' ', reserva.Hora_Salida) AS DATETIME),INTERVAL (SELECT IFNULL(Minutos, 0) FROM Ruta WHERE CodigoCiudadOrigen = reserva.Origen AND CodigoCiudadDestino = reserva.Destino) MINUTE)  HoraVueloRetorno,
                          CONCAT(reserva_detalle.Tipo_Doc, reserva_detalle.Documento) Documento,
                          ROUND(reserva_detalle.TotalPagar, 2) * (-1),
                          reserva_detalle.EstadoRegistro		
                    FROM reserva_detalle, reserva, personal, entidad E 
                    WHERE reserva_detalle.EstadoRegistro = 0 AND reserva_detalle.Registro = reserva.Registro AND reserva.CodigoPersonal = personal.CodigoPersonal AND personal.CodigoEntidad = E.CodigoEntidad AND E.CodigoEntidad = $codigo_entidad  $filtro

                    UNION

                    SELECT RIGHT(CONCAT('00000000', reserva.Registro),8) Registro,
                          reserva.Registro as Registro_detalle,
                          reserva_detalle.Detalle, 
                          reserva.CodigoReserva,
                          E.RUC,  
                          'SA' Tipo_Operacion,
                          reserva.FechaRegistro,
                          reserva_detalle.Ticket,
                          CONCAT(reserva_detalle.Apellidos, ', ', reserva_detalle.Nombres) 'Pasajero',
                          (SELECT DNI FROM personal WHERE CodigoEntidad = E.CodigoEntidad AND CodigoTipo = 'G' AND EstadoRegistro = 1 LIMIT 1) 'Gestor',
                          (SELECT CASE CodigoTipo WHEN 'G' THEN '' WHEN 'DNI' THEN DNI END FROM personal WHERE personal.CodigoPersonal = reserva.CodigoPersonal) 'Delegado',
                          '1' Cantidad,	
                          CASE reserva.TipoVuelo WHEN 'O' THEN 'OW' WHEN 'R' THEN 'RT' END 'TipoVuelo',
                          '2' Tramo,
                          CONCAT('2I ', reserva.Vuelo_Retorno) 'Vuelo_Salida',
                          reserva.Destino,
                          CAST(CONCAT(CAST(DATE(reserva.Fecha_Retorno) AS CHAR), ' ', reserva.Hora_Retorno) AS DATETIME),
                          reserva.Origen,
                          DATE_ADD(CAST(CONCAT(CAST(DATE(reserva.Fecha_Retorno) AS CHAR), ' ', reserva.Hora_Retorno) AS DATETIME),INTERVAL (SELECT IFNULL(Minutos, 0) FROM Ruta WHERE CodigoCiudadOrigen = reserva.Destino AND CodigoCiudadDestino = reserva.Origen) MINUTE) HoraVueloRetorno,      
                          CONCAT(reserva_detalle.Tipo_Doc, reserva_detalle.Documento) Documento,
                          ROUND(reserva_detalle.TotalPagar, 2) * (-1),
                          reserva_detalle.EstadoRegistro	
                    FROM reserva_detalle, reserva, personal, entidad E 
                    WHERE reserva.TipoVuelo = 'R' AND reserva_detalle.EstadoRegistro = 0 AND reserva_detalle.Registro = reserva.Registro AND reserva.CodigoPersonal = personal.CodigoPersonal AND personal.CodigoEntidad = E.CodigoEntidad AND E.CodigoEntidad = $codigo_entidad $filtro
                    ORDER BY 5, 10";

        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
      
       
           return $numero_filas;
    }
    public function FormaPago($registro){
        $formaPago=array();
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="SELECT visa.*,reserva.*
                FROM reserva ,visa
                WHERE  visa.reserva_id = reserva.Registro AND reserva.Registro = $registro";

        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $numero_filas=$obj_conexion->ContarFilas($resultado);
      
        $cant=0;
        if($numero_filas>0){
          
          while($fila=  $obj_conexion->ObtenerDatos($resultado)){
                    $forma_pago=array();
                    $brand='';
                    $card='';
                    $num_compra='';
                    $monto='';
                    $num_cuotas='';
                    $fec_hora_transaccion='';
                   
                    $brand=$fila['brand'];
                    $card=$fila['card'];
                    $num_compra=$fila['purchase_number'];
                    $fec_hora_transaccion=$fila['fechahora_transaccion'];
                    $monto=$fila['amount'];
                    $num_cuotas=$fila['quota_number'];
                    $estado=$fila['anulado'];
                    $token_id=$fila['token_id'];
                                        
                    $forma_pago[]=$brand;
                    $forma_pago[]=$card;
                    $forma_pago[]=$num_compra;
                    $forma_pago[]=$fec_hora_transaccion;
                    $forma_pago[]=$monto;
                    $forma_pago[]=$num_cuotas;
                    $forma_pago[]=$estado;
                    $forma_pago[]=$token_id;
                    $formaPago[]=$forma_pago;
            }
            $obj_conexion->CerrarConexion($conexion);
           return $formaPago;
    }
}

public function DetalleMovimiento($registro,$detalle){
        $lista_movimientos=array();
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="SELECT RIGHT(CONCAT('00000000', reserva.Registro), 8) Registro, 
                        '20342868844' RUCEmpresa, 
                        reserva_detalle.ComisionTarifa, 
                        reserva_detalle.Celular, 
                        reserva.Porcentaje, 
                        entidad.RUC RUCEntidad, 
                        entidad.DNIFuncionario, 
                        (SELECT DNI FROM personal WHERE EstadoRegistro = 1 AND CodigoEntidad = reserva.CodigoEntidad AND CodigoTipo = 'G' LIMIT 1) DNIGestor,
                        (SELECT IFNULL(CASE CodigoTipo WHEN 'G' THEN '' WHEN 'D' THEN DNI END, '') FROM personal WHERE EstadoRegistro = 1 AND personal.CodigoPersonal = reserva.CodigoPersonal AND personal.CodigoEntidad = reserva.CodigoEntidad ) DNIDelegado,
                        RIGHT(CONCAT('00000000', reserva.Registro), 8) Operacion, 
                        (CASE reserva_detalle.EstadoRegistro WHEN 0 THEN 'SA' WHEN 1 THEN 'EM' END) TipoOperacion,
                        1 Cantidad,
                        CASE reserva.TipoVuelo WHEN 'O' THEN 'OW' WHEN 'R' THEN 'RT' END TipoServicio,
                        reserva.FechaRegistro,
                        reserva_detalle.Ticket,
                        reserva_detalle.Referencia,
                        CONCAT('2I ', reserva.Vuelo_Salida) Vuelo_Salida,
                        Origen,
                        CONCAT(DATE(reserva.Fecha_Salida), ' ', reserva.Hora_Salida) Salida,
                        Destino,
                        (SELECT Tiempo FROM ruta WHERE CodigoCiudadOrigen = Origen AND CodigoCiudadDestino = Destino) Duracion,
                        reserva.Clase_Salida,
                        CONCAT(reserva_detalle.Tipo_Doc, ' ', reserva_detalle.Documento) Documento,
                        CASE reserva_detalle.Tipo_Pax WHEN 'A' THEN 'Adulto' WHEN 'N' THEN 'Niño' WHEN 'B' THEN 'Infante' END TipoPasajero,
                        CONCAT(reserva_detalle.Apellidos, ', ', reserva_detalle.Nombres) Pasajero,
                        reserva_detalle.Email,
                        reserva_detalle.Telefono,
                        reserva_detalle.Anexo,
                        reserva_detalle.EQ Tarifa,
                        0 TarifaCombustible,
                        reserva_detalle.EQ TarifaTotal,
                        reserva_detalle.PE IGV,
                        reserva_detalle.HW TUUA,
                        0 IGVTUUA,
                        reserva_detalle.Total PrecioFinal,
                        0 ComisionServicio, 
                        0 Penalidad,
                        0 DiferenciaTarifaria,
                        'USD' TipoMoneda,
                        reserva_detalle.Total PrecioFinal2,
                        0 DescuentoTarifa,
                        0 DescuentoAcumulado,
                        reserva_detalle.Total CostoTramo
                FROM entidad, reserva, reserva_detalle 
                WHERE entidad.CodigoEntidad = reserva.CodigoEntidad AND reserva.Registro = reserva_detalle.Registro AND reserva_detalle.Registro = $registro AND reserva_detalle.Detalle=$detalle";

        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        // var_dump($resultado);die;
        $numero_filas=$obj_conexion->ContarFilas($resultado);
      
       
          $cant=0;
        if($numero_filas>0){
          
          while($fila=  $obj_conexion->ObtenerDatos($resultado)){
                    
                    $movimiento=array();
                    $reserva = new ReservaEntidad();
                    $reserva_detalle = new ReservaDetalleEntidad();
                    $empresa=new EmpresaEntidad();
                    $ruc='';
                    $gestor='';
                    $delegado='';
                    $operacion='';
                    $tipo_operacion='';
                    $cantidad='';
                    $duracion='';
                    $documento='';
                    $combustible='';
                    $igvtuua='';
                    $comision_servicio='';
                    $penalidad='';
                    $diferencia_tarifaria='';
                    $tipo_moneda='';
                    $descuento_tarifa='';
                    $descuento_acumulado='';
                    
            
                    $reserva_detalle->setRegistro($fila['Registro']);
                    $ruc=$fila['RUCEmpresa'];
                    $empresa->setRUC($fila['RUCEntidad']);
                    $empresa->setDNIFuncionario($fila['DNIFuncionario']);
                    $gestor=$fila['DNIGestor'];
                    $delegado=$fila['DNIDlegado'];
                    $diferencia_tarifaria=$fila['DiferenciaTarifaria'];
                    $operacion=$fila['Operacion'];
                    $tipo_operacion=$fila['TipoOperacion'];
                    $cantidad=$fila['Cantidad'];
                    $reserva->setTipoVuelo($fila['TipoServicio']);
                    $reserva->setFechaRegistro($fila['FechaRegistro']);
                    $reserva_detalle->setTicket($fila['Ticket']);
                    $reserva_detalle->setReferencia($fila['Referencia']);
                    $reserva->setVueloSalida($fila['VueloSalida']);
                    $reserva->setOrigen($fila['Origen']);
                    $reserva->setFechaSalida($fila['Salida']);
                    $reserva->setDestino($fila['Destino']);
                    $duracion=$fila['Duracion'];
                    $penalidad=$fila['Penalidad'];
                    $reserva->setClaseSalida($fila['Clase_Salida']);
                    $documento=$fila['Documento'];
                    $reserva_detalle->setTipoPax($fila['TipoPasajero']);
                    $reserva_detalle->setNombres($fila['Pasajero']);
                    $reserva_detalle->setEmail($fila['Email']);
                    $reserva_detalle->setTelefono($fila['Telefono']);
                    $reserva_detalle->setAnexo($fila['Anexo']);
                    $reserva_detalle->setEQ($fila['Tarifa']);
                    $combustible=$fila['Combustible'];
                    $reserva_detalle->setPE($fila['IGV']);
                    $reserva_detalle->setHW($fila['TUUA']);
                    $igvtuua=$fila['IGVTUUA'];
                    $reserva_detalle->setTotalPagar($fila['PrecioFinal']);
                    $comision_servicio=$fila['ComisionServicio'];
                    $tipo_moneda=$fila['TipoMoneda'];
                    $descuento_tarifa=$fila['DescuentoTarifa'];
                    $descuento_acumulado=$fila['DescuentoAcumulado'];
                    $reserva->setPorcentaje($fila['Porcentaje']);
                    $reserva_detalle->setComisionTarifa($fila['ComisionTarifa']);
                    $reserva_detalle->setCelular($fila['Celular']);

                    
                    
                    $movimiento[]=$empresa;
                    $movimiento[]=$ruc;
                    $movimiento[]=$gestor;
                    $movimiento[]=$delegado;
                    $movimiento[]=$operacion;
                    $movimiento[]=$tipo_operacion;
                    $movimiento[]=$cantidad;
                    $movimiento[]=$duracion;
                    $movimiento[]=$documento;
                    $movimiento[]=$combustible;
                    $movimiento[]=$igvtuua;
                    $movimiento[]=$comision_servicio;
                    $movimiento[]=$penalidad;
                    $movimiento[]=$diferencia_tarifaria;
                    $movimiento[]=$tipo_moneda;
                    $movimiento[]=$descuento_tarifa;
                    $movimiento[]=$descuento_acumulado;
                    $movimiento[]=$reserva;
                    $movimiento[]=$reserva_detalle;
                    $lista_movimientos[]=$movimiento;
            }
            $obj_conexion->CerrarConexion($conexion);
            
       
           return $lista_movimientos;
    }

          
}
public function AnularTicket($ticket){
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="UPDATE reserva_detalle SET EstadoRegistro=0 WHERE Ticket='$ticket'";

        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }
    
public function AnularReserva($pnr){
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="UPDATE reserva SET EstadoRegistro=0 WHERE  CodigoReserva='$pnr'";
        
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);

        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
        return $flag;
    }
    
        function cantidadInfantes($registro){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="SELECT Bebes from reserva WHERE Registro=$registro";
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion); 
        $data_bebe=$obj_conexion->ObtenerDatos($resultado);
        $cantBebes = $data_bebe['Bebes'];
        return (int)$cantBebes;
    }
function EnviaAlertaNinoEmail($registro){
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="SELECT CodigoReserva, Apellidos, Nombres, Origen, Destino, Fecha_Salida, Vuelo_Salida, Fecha_Retorno, Vuelo_Retorno, Telefono, Celular, Email FROM reserva WHERE Registro=$registro";
        $resultado=$obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion); 
        $data_nino=$obj_conexion->ObtenerDatos($resultado);
        //return $resultado1;
        
        $titulo = 'Alerta de emision de tickets con infantes PERU COMPRAS - '.$data_nino['CodigoReserva'];

            //EMAIL DESTINO
            //$para = "williams.castillo@starperu.com, diego.cortes@starperu.com";
            $para = "controles.general@starperu.com, gabriela.monge@starperu.com,ricardo.jaramillo@starperu.com,diego.cortes@starperu.com";
            
            
            //ARMADO DE LA CABECERA
            $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $cabeceras .= 'From: StarPeru <ecel@starperu.com>' . "\r\n";

            //ARMADO DEL MENSAJE
            $mensaje.='<table width="50%" border="0"><tr><td BGCOLOR="#C90E14"><center><img src="http://starpanel.starperu.com/cp/imagenes/LogoStarPie.png"></center><td></tr>';
            $mensaje.='<tr><td BGCOLOR="#B0B0B0">ALERTA - RESERVA CON INFANTES</td></tr>';
    //        $mensaje.="<span BGCOLOR=\"YELOW\" color=\"white\">SISTEMA DE REPORTES DE SEGURIDAD OPERACIONAL</span>"."<br><br>";
            $mensaje.='<tr><td BGCOLOR="WHITE" color="red">Se informa que se ha generado una reserva que cuenta con infantes.</td></tr>';
            $mensaje.='<tr><td BGCOLOR="WHITE" color="black"><strong>COD RESERVA:</strong> '.$data_nino['CodigoReserva'].'</td></tr>';
            $mensaje.='<tr><td BGCOLOR="WHITE" color="black"><strong>PASAJERO:</strong> '.$data_nino['Apellidos'].' ,'.$data_nino['Nombres'].'</td></tr>';
            $mensaje.='<tr><td BGCOLOR="WHITE" color="black"><strong>RUTA:</strong> '.$data_nino['Origen'].'-'.$data_nino['Destino'].'</td></tr>';
            $mensaje.='<tr><td BGCOLOR="WHITE" color="black"><strong>FECHA / VUELO IDA:</strong> '.$data_nino['Fecha_Salida'].'/'.$data_nino['Vuelo_Salida'].'</td></tr>';
            if(empty($data_nino['Vuelo_Retorno'])):
                $mensaje.='<tr><td BGCOLOR="WHITE" color="black"><strong>FECHA / VUELO VUELTA:</strong> '.$data_nino['Fecha_Retorno'].'/'.$data_nino['Vuelo_Retorno'].'</td></tr>';
            endif;
            $mensaje.='<tr><td BGCOLOR="WHITE" color="black"><strong>TELEFONO / CELULAR:</strong> '.$data_nino['Telefono'].' / '.$data_nino['Celular'].'</td></tr>';
            $mensaje.='<tr><td BGCOLOR="WHITE" color="black"><strong>E-MAIL:</strong> '.$data_nino['Email'].'</td></tr>';
            $mensaje.='<tr><td BGCOLOR="WHITE" color="black">-------------------------------------------------------------------------------------</td></tr>';
            $mensaje.='</table>';
            mail($para, $titulo, $mensaje, $cabeceras);
    }
//    function Cantidad_nino($registro){
//        $obj_conexion=new ConexionBD();
//        $conexion=$obj_conexion->CrearConexion();
//        
//         $consulta="UPDATE Reserva SET EstadoRegistro=0 WHERE  Registro='$registro'";
//         return $res;
//    }
public function GuardarReservaCabecera($codigo_reserva,$nombres,$apellidos,$email,
                    $tipo_documento,$numero_documento,$telefono,
                    $anexo,$celular,$nextel,$rpm,
                    $rpc,$pasajero_ruc,$fecha_registro,$fecha_limite,$adultos_5,$menores_5,$infantes_5,$origen_ida_5,$destino_ida_5,$numero_vuelo_ida_5,
                    $clase_ida_5,$fecha_salida_ida_5,$hora_salida_ida_5,$numero_vuelo_vuelta_5,$clase_vuelta_5,$fecha_salida_vuelta_5,$hora_salida_vuelta_5,
                    $pais,$ciudad,$ip,$flete,$tuua_5,$igv_5,$total_pagar_5,$usuario,$entidad,$tipo_vuelo_letras){
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="INSERT INTO reserva(CodigoReserva,Apellidos,Nombres,Tipo_Doc,Documento,Telefono,Celular,Email,FechaRegistro,FechaLimite,TipoVuelo,Adultos,Ninos,Bebes,Origen,"
                . "Destino,Vuelo_Salida,Clase_Salida,Fecha_Salida,Hora_Salida,Vuelo_Retorno,Clase_Retorno,Fecha_Retorno,Hora_Retorno,Pais,Ciudad,IP,Flete,TUA,"
                . "Impuesto,Total,CodigoEntidad,CodigoPersonal,RUC) "
                . "VALUES('$codigo_reserva','$apellidos','$nombres','$tipo_documento','$numero_documento','$telefono','$celular','$email','$fecha_registro','$fecha_limite','$tipo_vuelo_letras',$adultos_5,$menores_5,$infantes_5,"
                . "'$origen_ida_5','$destino_ida_5','$numero_vuelo_ida_5','$clase_ida_5','$fecha_salida_ida_5','$hora_salida_ida_5','$numero_vuelo_vuelta_5','$clase_vuelta_5','$fecha_salida_vuelta_5','$hora_salida_vuelta_5','$pais','$ciudad',"
                . "'$ip',$flete,$tuua_5,$igv_5,$total_pagar_5,$entidad,$usuario,'$pasajero_ruc')";
        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
        $registro=  mysqli_insert_id($conexion);
        // $error=$obj_conexion->ErrorEjecucion();
        $obj_conexion->CerrarConexion($conexion);

//       if($error==1){
//            $flag=1;
//           return $flag;
//        }else{
            return $registro;
//        }        
    }
    public function GuardarReservaDetalle($registro,$j,$tipo_documento,$numero_documento,$apellidos,
                    $nombres,$tipo_pax,$celular,$telefono,$anexo,$rpc,
                    $rpm,$email,$tarifa_unitaria,$igv_unitaria,$tuua_unitaria,$total,$total_pagar,$fecNac){
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        $consulta="INSERT INTO reserva_detalle(Registro,Detalle,Tipo_Doc,Documento,Apellidos,Nombres,Tipo_Pax,Celular,Telefono,Anexo,RPM,RPC,Email,EQ,FA,MS,PE,HW,Total,TotalPagar,FechaNacimiento)"
                . " VALUES('$registro',$j,'$tipo_documento','$numero_documento','$apellidos','$nombres','$tipo_pax','$celular','$telefono','$anexo','$rpm','$rpc','$email',$tarifa_unitaria,$tarifa_unitaria,$total_pagar,$igv_unitaria,$tuua_unitaria,$total,$total_pagar,'$fecNac')";
        
        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
       
        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
      
            return $flag;
    }
    
public function UpdateReservaDetalleTicket($ticket,$i,$registro,$ComisionTarifa){
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="UPDATE reserva_detalle SET Ticket='$ticket',ComisionTarifa=$ComisionTarifa WHERE Registro=$registro AND Detalle=$i";
        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
       
        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
      
        return $flag;
        
    }
public function UpdateReservaTicket($codigo_reserva_c,$campos_consulta,$porcentaje,$cc_code=NULL){
        $flag=0;
        $obj_conexion=new ConexionBD();
        $conexion=$obj_conexion->CrearConexion();
        
        $consulta="UPDATE reserva SET $campos_consulta forma_pago = '$cc_code' ,EstadoRegistro=1, Porcentaje=$porcentaje WHERE CodigoReserva='$codigo_reserva_c'";
        $obj_conexion->ConsultarDatos($consulta,$this->basedatos,$conexion);
       
        $error=$obj_conexion->ErrorEjecucion($conexion);
        if($error==1){
            $flag=1;
        }
        $obj_conexion->CerrarConexion($conexion);
              
        return $consulta;
        
    }
    
public function EnviarAlertaGestor($correo,$cod_reserva,$tickets) {
    if(is_string($tickets)){
        $lista_tickets = (string)$tickets;
    }else{
        $lista_tickets = implode(',', $tickets);    
    }
    $entidad = $_SESSION["nombre_entidad"];
//    $gestor = 
    
    $mail ="<html>";
        $mail .="<body style='font-family:Trebuchet MS;font-size:13px'>";
        $mail .="<center>";
        $mail .='<div style="border: 1px solid #69778d;width:720px;padding-bottom: 10px;">';
        $mail .="<table width='700' border='0' align='center'>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td  colspan='2' align='center' style='font-size: 18px;'><font color='#4e99bf'><strong>ALERTA DE EMISIÓN DE TICKET</strong></font></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2' bgcolor='#4e99bf'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'><p>Estimada Agencia, se le informa que la entidad <font color='#080897'><strong>$entidad</strong></font> ha realizado la emisi&oacute;n de tickets a trav&eacute;s del portal de STARPERU.";//<font color='#080897'><strong>$gestor</strong></font>, en virtud de su acreditaci&oacute;n como 
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td><font color='#33333'><strong>C&oacute;digo de Reserva:</strong></font></td><td><font color='#33333'><strong>$cod_reserva</strong></font></td></tr>";
        $mail .="<tr><td><font color='#33333'><strong>Tickets:</strong></font></td><td><font color='#080897'><strong>$lista_tickets</strong></font></td></tr>";
        $mail .="<tr><td colspan='2' bgcolor='#4e99bf'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2'></td></tr>";
        $mail .="<tr><td colspan='2' style='font-size: 14px;'><font color='#000000'><strong>Se le recuerda que los tickets emitidos son de entera responsabilidad de la Agencia y que el plazo m&aacute;ximo para su cancelaci&oacute;n será hasta las 23:59:59.</strong></font></td></tr>";
        $mail .="</table>";
        $mail .="</div>";
        $mail .="</center>";
        $mail .="</body>";
        $mail .="</html>";

        $email = $correo.", "."carlos.gutierrez@starperu.com";
        //$email = $correo.", "."ricardo.jaramillo@starperu.com";
        $remitente ="ecel@starperu.com";
        $to=$email;
        $subject='Web Agencias - Alerta de emisión de tickets';
        $message=$mail;
        $cabeceras = "Content-type: text/html; charset=UTF-8\r\n"; 
        $cabeceras.= "From: Web Agencias <$remitente>\r\n";
        mail($to, $subject,$message,$cabeceras ); 
}
    

}
?>