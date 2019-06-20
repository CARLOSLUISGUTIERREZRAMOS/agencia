$(document).ready(function(){
   $('#btn_login').click(function(){
        var usuario=$.trim($('#usuario').val());
        var password=$.trim($('#password').val());
        
        var error=0;
        var tipoError='';
        
        if(usuario==''){
            error=error+1;
            tipoError='U';
         }

        if(password==''){
            error=error+1;
            tipoError='C';
        }
        
        if(error==0){
//            $('#form1').submit();

            $.ajax({
                type: "POST",
                url : "cd/Controlador/LoginControl.php",
                data: "usuario="+usuario+"&deuda=1",
                success: function(msg){
                  var array = msg.split('*');
                  var deuda = array[0];
                  
                  if(deuda==1){
                      $('.error_login').text('Acceso no permitido. Por favor comunicarse con el área contable de StarPerú.');
                  }
                  else{
                      $('#form1').submit();
                  }
              }
            });
        }else{
             if(error==2){
                $('.error_login').text('Ud. debe ingresar un usuario y contraseña.');
             }else{
                 if(error==1){
                    if(tipoError=='U'){
                         $('.error_login').text('Ud. debe ingresar un usuario.');
                    }else{
                         $('.error_login').text('Ud. debe ingresar una contraseña.');
                    }
                }
             }
        }
   });
  
});
