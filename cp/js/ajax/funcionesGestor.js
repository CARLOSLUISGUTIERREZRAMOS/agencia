$(document).ready(function(){
    
        //var id = $(this).val();
        var data = new FormData();
        data.append('ObtenerDepartamentos','1');
        //data.append('departamento',id);
        $.ajax({
            type: "POST",
            url: "../../cd/Controlador/DelegadoControl.php",
            data: data,
            processData: false,
            contentType: false,
            success: function(msg){
                $("#depa_d").html(msg);
            }
        });
    
     $.msgbox({
        open:false,type:'alert',title:'Alerta',content: ' ', overlay:true
    });
    $('#guarda_delegado').click(function(){
//        $.msgbox().content('hola');
//            $.msgbox().open();
        var dni=$.trim($('#dni_d').val());
        var apep=$.trim($('#apep_d').val());
        var apem=$.trim($('#apem_d').val());
        var nom=$.trim($('#nom_d').val());
        var email=$.trim($('#email_d').val());
        var ofic=$.trim($('#ofic_d').val());
        var anexo=$.trim($('#anexo_d').val());
        var celular=$.trim($('#celu_d').val());
        var rpm=$.trim($('#rpm_d').val());
        var depa=$.trim($('#depa_d').val());
        var prov=$.trim($('#prov_d').val());
        var dist=$.trim($('#dist_d').val());
        
        if(dni=='' || dni==null){
             $.msgbox().content('El campo dni es un campo requerido');
             $.msgbox().open();
             return false;
        }else if( !(/^\d{8}$/.test(dni))) {
            $.msgbox().content('El dni debe contener 8 n&uacute;meros');
            $.msgbox().open();
            return false;
              if(!(/^\d+$/.test(dni))){
                 $("#dni_d").val("");
                 return false;
                 }
         }
        if(apep=='' || apep==null){
             $.msgbox().content('El campo apellido paterno es un campo requerido');
             $.msgbox().open();
             return false;
        }
        if(apem=='' || apem==null){
             $.msgbox().content('El campo apellido materno es un campo requerido');
             $.msgbox().open();
             return false;
        }
        if(nom=='' || nom==null){
             $.msgbox().content('El campo nombre es un campo requerido');
             $.msgbox().open();
             return false;
        }
        if(email=='' || email==null){
             $.msgbox().content('El campo email es un campo requerido');
             $.msgbox().open();
             return false;
        }else if(!/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email)){
            $.msgbox().content('El email ingresado no es correcto');
            $.msgbox().open();
            return false;
        }
        if(ofic=='' || ofic==null){
             $.msgbox().content('El campo telefono oficina es un campo requerido');
             $.msgbox().open();
             return false;
        }
      
        
        $.ajax({
                url: "../../cd/Controlador/DelegadoControl.php",
                data: "guardar_delegado=1&dni="+dni+"&apep="+apep+"&apem="+apem+"&nom="+nom+
                        "&email="+email+"&ofic="+ofic+"&anexo="+anexo+"&celular="+celular+
                        "&rpm="+rpm+"&depa="+depa+"&prov="+prov+"&dist="+dist,
                type: "POST",
               
                success: function(html) {
                    var resultado=html.split('_|_')
                    if (resultado[0] == 1) {
                        $("#formRegistro").each(function() {
                            this.reset();
                        });
                          $.msgbox().content('El delegado fue guardado con &eacute;xito');
                          $.msgbox().open();
                           
                    }
                    else if(resultado[0] == 3){
                           $.msgbox().content('El dni ingresado ya existe');
                           $.msgbox().open();
                           
                    }
                    else if(resultado[0] == 4){
                           $.msgbox().content('El email ingresado es incorrecto');
                           $.msgbox().open();
                           
                    }else{
                         $.msgbox().content('lo sentimos hubo un error de conexion');
                           $.msgbox().open();
                    }
                },
                error: function(obj,mensaje,e) { 
                                       if(e=='Internal Server Error'){
                                           alert('Se ha producido un error interno. Consulte con el &Aacute;rea de Sistemas de StarPeru');
                                       }else{
                                           alert('Por favor revise su conexi&oacute;n a Internet y vuelva a intertarlo.');
                                       }
                                   }
            }); 
    });
    
    
    
    $('#editar_delegado').click(function(){

        var estado=$.trim($('#estado').val());
        var dni=$.trim($('#dni_d').val());
        var apep=$.trim($('#apep_d').val());
        var apem=$.trim($('#apem_d').val());
        var nom=$.trim($('#nom_d').val());
        var email=$.trim($('#email_d').val());
        var ofic=$.trim($('#ofic_d').val());
        var anexo=$.trim($('#anexo_d').val());
        var celular=$.trim($('#celu_d').val());
        var rpm=$.trim($('#rpm_d').val());
        var rpc=$.trim($('#rpc_d').val());
        var nextel=$.trim($('#nextel_d').val());
        

        if(estado == -1){
             $.msgbox().content('Debe seleccionar un estado para el Delegado');
             $.msgbox().open();
             return false;
        }
        
        if(apep=='' || apep==null){
             $.msgbox().content('El campo apellido paterno es un campo requerido');
             $.msgbox().open();
             return false;
        }
        if(apem=='' || apem==null){
             $.msgbox().content('El campo apellido materno es un campo requerido');
             $.msgbox().open();
             return false;
        }
        if(nom=='' || nom==null){
             $.msgbox().content('El campo nombre es un campo requerido');
             $.msgbox().open();
             return false;
        }
        if(email=='' || email==null){
             $.msgbox().content('El campo email es un campo requerido');
             $.msgbox().open();
             return false;
        }else if(!/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email)){
            $.msgbox().content('El email ingresado no es correcto');
            $.msgbox().open();
            return false;
        }
        if(ofic=='' || ofic==null){
             $.msgbox().content('El campo telefono oficina es un campo requerido');
             $.msgbox().open();
             return false;
        }
          
               
        $.ajax({
                url: "../../cd/Controlador/DelegadoControl.php",
                data: "editar_delegado=1&estado="+estado+"&dni="+dni+"&apep="+apep+
                       "&apem="+apem+"&nom="+nom+"&email="+email+"&ofic="+ofic+"&anexo="+anexo+
                        "&celular="+celular+"&rpm="+rpm+"&rpc="+rpc+"&nextel="+nextel,
                type: "POST",
                cache: false,
                success: function(html) {
                    var resultado=html.split('_|_')
                    if (resultado[0] == 1) {
                        $("#formRegistro").each(function() {
                            this.reset();
                        });
                        window.location.href='delegado_listado.php';
                           
                    }
                    else if(resultado[0] == 4){
                           $.msgbox().content('El email ingresado es incorrecto');
                           $.msgbox().open();
                           
                    }else{
                         $.msgbox().content('Lo sentimos hubo un error de conexion');
                           $.msgbox().open();
                    }
                },
                error: function(obj,mensaje,e) { 
                                       if(e=='Internal Server Error'){
                                           alert('Se ha producido un error interno. Consulte con el &Aacute;rea de Sistemas de StarPeru');
                                       }else{
                                           alert('Por favor revise su conexi&oacute;n a Internet y vuelva a intertarlo.');
                                       }
                                   }
            }); 
    });
    
    
    
    $('#resetear_clave').click(function(){

        var dni=$('#dni_d').val();
        var codigo_entidad=$('#codigo_entidad').val();
        var apellidopat=$('#apellido_pat').val();
        var apellidomat=$('#apellido_mat').val();
        var nombres=$('#nombres').val();
        var email=$('#email').val();
        
        $.ajax({
                url: "../../cd/Controlador/DelegadoControl.php",
                data: "resertear_clave=1&dni="+dni+"&codigo_entidad="+codigo_entidad+
                        "apellidopat="+apellidopat+"&apellidomat="+apellidomat+"&nombres="+nombres+
                        "&email="+email,
                type: "POST",
                cache: false,
                success: function(html) {
                    var resultado=html.split('_|_')
                    if (resultado[0] == 1) {
                         $.msgbox().content('La clave ha sido cambiada y enviada al correo del Delegado.');
                         $.msgbox().open();
                    }else{
                         $.msgbox().content('No se pudo cambiar la clave. Vuelva a intentarlo.');
                         $.msgbox().open();
                    }
                },
                error: function(obj,mensaje,e) { 
                                       if(e=='Internal Server Error'){
                                           alert('Se ha producido un error interno. Consulte con el &Aacute;rea de Sistemas de StarPeru');
                                       }else{
                                           alert('Por favor revise su conexi&oacute;n a Internet y vuelva a intertarlo.');
                                       }
                                   }
            }); 
    });
    
    
    $("#depa_d").change(function(){
        
        var id = $(this).val();
        var data = new FormData();
        data.append('ObtenerProvincias','1');
        data.append('departamento',id);
        $.ajax({
            type: "POST",
            url: "../../cd/Controlador/DelegadoControl.php",
            data: data,
            processData: false,
            contentType: false,
            success: function(msg){
                $("#prov_d").html(msg);
            }
        });
    });
    
    $("#prov_d").change(function(){
        
        var id = $(this).val();
        var data = new FormData();
        data.append('ObtenerDistritos','1');
        data.append('provincia',id);
        $.ajax({
            type: "POST",
            url: "../../cd/Controlador/DelegadoControl.php",
            data: data,
            processData: false,
            contentType: false,
            success: function(msg){
                $("#dist_d").html(msg);
            }
        });
    });
});

