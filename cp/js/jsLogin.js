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
             $('#form1').submit();
         }else{
              if(error==2){
                 $('.error_login').text('Ud. debe ingresar un usuario y contraseÃ±a.');
              }else{
                  if(tipoError=='U'){
                       $('.error_login').text('Ud. debe ingresar un usuario.');
                  }else{
                       $('.error_login').text('Ud. debe ingresar una contraseÃ±a.');
                  }
              }
         }
    });
   
});

$(document).on('submit','#registrar-agencia',function (event) {
    event.preventDefault();
    var data=$(this).serialize();
    debugger
    $.ajax({
        type: 'POST',
        url: 'cd/Controlador/RegistroAgencia.php',
        data: data,
        success: function (data) {
            debugger
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });

    return false;
    return;
});