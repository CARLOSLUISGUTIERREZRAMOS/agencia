<?php
class ConexionBD{
//      private $servidor="localhost";
//      private $usuario="user_pasarela";
//      private $password="t0p+s3cr3t";
      private $servidor="localhost";
      private $usuario="root";
      private $password="StarPeru12";
 
      function CrearConexion(){
         $conexion= mysqli_connect($this->servidor, $this->usuario, $this->password);
         if(!$conexion){
             die('No se pudo conectar'. mysqli_error($conexion));
         }else{
             return $conexion;
         }
      }
      
      function CerrarConexion($conexion){
          return mysqli_close($conexion);
      }
      
      function ConsultarDatos($consulta,$basedatos,$conexion){
          mysqli_select_db($conexion,$basedatos);
          return mysqli_query($conexion,$consulta);
      }
      
      function ObtenerDatos($resultado){
          return mysqli_fetch_assoc($resultado);
      }
      
      function ContarFilas($resultado){
          return mysqli_num_rows($resultado);
      }
      function FilasAfectadas(){
          return mysqli_affected_rows();
      }
      
      function ErrorEjecucion($conexion){
          $error=1;
          if(mysqli_error($conexion)){
              $error=0;
          }
          return $error;
      }
}
?>
