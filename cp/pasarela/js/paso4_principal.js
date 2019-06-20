function  ValidarCamposDetalle(){
    
    var adultos=$.trim($('#adultos_5').val());
    var menores=$.trim($('#menores_5').val());
    var infantes=$.trim($('#infantes_5').val());
    var cantidad=parseInt(adultos)+parseInt(menores)+parseInt(infantes);
    
   for(var i=1;i<=adultos;i++){

         if ($.trim($('#nombre_a_'+i).val()) == "") {
            alert("Por favor ingrese el Nombre del Adulto N° "+i);
            return false;
         }
         if(ComprobarCaractValido($('#nombre_a_'+i).val())!=1){
             alert("El Nombre del Adulto N° "+i+" contiene caracteres incorrectos");
            return false;  
         }
         
         if ($.trim($('#paterno_a_'+i).val()) == "") {
            alert("Por favor ingrese el Apellido Paterno del Adulto N° "+i);
            return false;
         }
           if(ComprobarCaractValido($('#paterno_a_'+i).val())!=1){
             alert("El Apellido Paterno del Adulto N° "+i+" contiene caracteres incorrectos");
            return false;  
         }
         
         if ($.trim($('#tipo_doc_a_'+i).val()) == "NI") {
             if ( !(/^\d{8}$/.test($.trim($('#num_doc_a_'+i).val())))) {
                alert("El DNI del Adulto N° "+i+" debe contener 8 dígitos");
                return false;
             }
            if ($.trim($('#materno_a_' + i).val()) == "") {
                alert("Por favor ingrese el Apellido Materno del Adulto N° " + i);
                return false;
            }
            if (ComprobarCaractValido($('#materno_a_' + i).val()) != 1) {
                alert("El Apellido Materno del Adulto N° " + i + " contiene caracteres incorrectos");
                return false;
            }
         }
         
         if ($.trim($('#tipo_doc_a_'+i).val()) == "PP") {
            
             if (!(/^[A-Z0-9]+$/.test($.trim($('#num_doc_a_'+i).val())))) {

                alert("Por favor verifique el Numero de Pasaporte del Adulto N° "+i);
                return false;
             }
         }
         
          if ($.trim($('#tipo_doc_a_'+i).val()) == "ID") {
            
             if ($.trim($('#num_doc_a_'+i).val())=='') {

                alert("Por favor verifique el Carné de Extranjería del Adulto N° "+i);
                return false;
             }
          }
         
          if ($.trim($('#email_a_'+i).val()) == "") {
            alert("Por favor ingrese el Email del Adulto N° "+i);
            return false;
         }
         
         var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
         if(!filter.test($.trim($('#email_a_'+i).val()))){
              alert("El Email del Adulto N° "+i+" no es válido");
              return false;
         }
         
          if ($.trim($('#celular_a_'+i).val()) == "" ) {
            alert("Por favor un Número de celular del Adulto N° "+i);
            return false;
         }else{
              if ( !(/^\d{9}$/.test($.trim($('#celular_a_'+i).val())))) {
                alert("El celular del Adulto N° "+i+" debe contener 9 dígitos");
                return false;
             }
         }
    }
    
    for(var j=1;j<=menores;j++){

         if ($.trim($('#nombre_m_'+j).val()) == "") {
            alert("Por favor ingrese el Nombre del Niño N° "+j);
            return false;
         }
          if(ComprobarCaractValido($('#nombre_m_'+i).val())!=1){
             alert("El Nombre del Niño N° "+i+" contiene caracteres incorrectos");
            return false;  
         }
         
         if ($.trim($('#paterno_m_'+j).val()) == "") {
            alert("Por favor ingrese el Apellido Paterno del Niño N° "+j);
            return false;
         }
         if(ComprobarCaractValido($('#paterno_m_'+i).val())!=1){
             alert("El Apellido Paterno del Niño N° "+i+" contiene caracteres incorrectos");
            return false;  
         }
         
       
         
         if ($.trim($('#tipo_doc_m_'+j).val()) == "NI") {
             if ( !(/^\d{8}$/.test($.trim($('#num_doc_m_'+j).val())))) {
                alert("El DNI del Niño N° "+j+" debe contener 8 dígitos");
                return false;
             }
            if ($.trim($('#materno_m_' + j).val()) == "") {
                alert("Por favor ingrese el Apellido Materno del Niño N° " + j);
                return false;
            }
            if (ComprobarCaractValido($('#materno_m_' + i).val()) != 1) {
                alert("El Apellido Materno del Niño N° " + i + " contiene caracteres incorrectos");
                return false;
            }
         }
         
         if ($.trim($('#tipo_doc_m_'+j).val()) == "PP") {
            
             if (!(/^[A-Z0-9]+$/.test($.trim($('#num_doc_m_'+i).val())))) {
                alert("Por favor verifique el Numero de Pasaporte del Niño N° "+j);
                return false;
             }
         }
         
         if ($.trim($('#tipo_doc_m_'+i).val()) == "ID") {
            
             if ($.trim($('#num_doc_m_'+i).val())=='') {

                alert("Por favor verifique el Carné de Extranjería del Niño N° "+i);
                return false;
             }
          }
         
          if ($.trim($('#email_m_'+j).val()) == "") {
            alert("Por favor ingrese el Email del Niño N° "+j);
            return false;
         }
         
         var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
         if(!filter.test($.trim($('#email_m_'+j).val()))){
              alert("El Email del Niño N° "+j+" no es válido");
              return false;
         }
         
          if ($.trim($('#celular_m_'+j).val()) == "" ) {
            alert("Por favor un Número de celular del Niño N° "+j);
            return false;
         }else{
              if ( !(/^\d{9}$/.test($.trim($('#celular_m_'+j).val())))) {
                alert("El celular del Niño N| "+j+" debe contener 9 dígitos");
                return false;
             }
         }
    }
    
    for(var k=1;k<=infantes;k++){

         if ($.trim($('#nombre_i_'+k).val()) == "") {
            alert("Por favor ingrese el Nombre del Infante N° "+k);
            return false;
         }
          if(ComprobarCaractValido($('#nombre_i_'+i).val())!=1){
             alert("El Nombre del Infante N° "+i+" contiene caracteres incorrectos");
            return false;  
         }
         
         if ($.trim($('#paterno_i_'+k).val()) == "") {
            alert("Por favor ingrese el Apellido Paterno del Infante N° "+k);
            return false;
         }
         if(ComprobarCaractValido($('#paterno_i_'+i).val())!=1){
             alert("El Apellido Paterno del Infante N° "+i+" contiene caracteres incorrectos");
            return false;  
         }
         
         if ($.trim($('#tipo_doc_i_'+k).val()) == "NI") {
             if ( !(/^\d{8}$/.test($.trim($('#num_doc_i_'+k).val())))) {
                alert("El DNI del Infante N° "+k+" debe contener 8 dígitos");
                return false;
             }
            if ($.trim($('#materno_i_' + k).val()) == "") {
                alert("Por favor ingrese el Apellido Materno del Infante N° " + k);
                return false;
            }
            if (ComprobarCaractValido($('#materno_i_' + i).val()) != 1) {
                alert("El Apellido Materno del Infante N° " + i + " contiene caracteres incorrectos");
                return false;
            }
         }
         
         if ($.trim($('#tipo_doc_i_'+k).val()) == "PP") {
           
               if (!(/^[A-Z0-9]+$/.test($.trim($('#num_doc_i_'+i).val())))) {
                alert("Por favor verifique el Numero de Pasaporte del Infante N° "+k);
                return false;
             }
         }
         
         if ($.trim($('#tipo_doc_i_'+i).val()) == "ID") {
            
             if ($.trim($('#num_doc_i_'+i).val())=='') {

                alert("Por favor verifique el Carné de Extranjería del Infante N° "+i);
                return false;
             }
          }
         
          if ($.trim($('#email_i_'+k).val()) == "") {
            alert("Por favor ingrese el Email del Infante N° "+k);
            return false;
         }
         
         var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
         if(!filter.test($.trim($('#email_i_'+k).val()))){
              alert("El Email del Infante N° "+k+" no es válido");
              return false;
         }
         
          if ($.trim($('#celular_i_'+k).val()) == "" ) {
            alert("Por favor un Número de celular del Infante N° "+k);
            return false;
         }else{
              if ( !(/^\d{9}$/.test($.trim($('#celular_i_'+k).val())))) {
                alert("El celular del Infante N° "+k+" debe contener 9 dígitos");
                return false;
             }
         }
    }
     return true;
}