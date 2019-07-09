window.onload=function(){ $('#dni_d').focus(); };

/* =============================== AJAX ======================================= */
var objAjax= new MBAjax();

function sendData()
{
	objAjax.flag=false;
	objAjax.ajax();
}

/* ============================= LISTADO ====================================== */
function iniciarListado()
{
	listaDelegado(1);
}

function listaDelegado(pag)
{
	var lista;
	objAjax.valores='pag='+pag;
	objAjax.metodo='POST';
	objAjax.url='ajax/ajax_listar_delegado.php';
	sendData();
	if(objAjax.texto.length!=0)
	{
		eval(objAjax.texto);
		$('#recargar-lista').empty();
		$('#listaResultado').html(lista[0]);
		$('#listaResultado').css({'font-weight': 'normal', 'font-size': '11px', 'color':'#000000'})
	}else{
		$('#listaResultado').html('<p>No existen Datos para Visualizar. Por favor ingrese nuevos registros.</p>').css({'font-weight': 'bold', 'font-size': '15px', 'color':'#000099'});
	}
}

function ver(id)
{
	window.location='delegado_info.php' + '?id='+id;
}

function editar(id)
{
	window.location='delegado_edicion.php' + '?id='+id;
}

function editar_agencia(id) {
  window.location='agencia_edicion.php' + '?id='+id;
}

function cambiaEstado(dni,estado)
{
	var consulta;
	if(estado==1){
		consulta= confirm("\xBFDesea activar al Delegado seleccionado?");
	}else if(estado==0){
                consulta=confirm("\xBFDesea descativar al Delegado seleccioando?.");
	}
	if(consulta){      
		$.ajax({
                    url:"../../cd/Controlador/DelegadoControl.php",
                    type: "POST", 
                    data:"activar_desactivar=1&dni="+dni+"&estado="+estado,
                    success: function(mensaje){
                                       
                             if($.trim(mensaje)=='1'){
                                  location.reload();
                             }else{
                                   alert('No se pudo realizar el proceso. Inténtelo nuevamente');
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
	}
}


/* ============================= REGISTRO ====================================== */


function verPanelResetPassword()
{	
	document.getElementById('div-panel-reset').style.display='block';
}

function resetPasswordDelegado(opcion)
{	
	if(opcion==1)
	{
		var dni=$('#dni_d').val();
                var codigo_entidad=$('#codigo_entidad').val();
                var apellidopat=$('#apellido_pat').val();
                var apellidomat=$('#apellido_mat').val();
                var nombres=$('#nombres').val();
                var email=$('#email').val();

                $.ajax({
                        url: "../../cd/Controlador/DelegadoControl.php",
                        data: "resetear_clave=1&dni="+dni+"&codigo_entidad="+codigo_entidad+"&apellidopat="+apellidopat+"&apellidomat="+apellidomat+"&nombres="+nombres+"&email="+email,
                        type: "POST",

                        success: function(html) {
                             document.getElementById('div-panel-reset').style.display='none';
                            var resultado=html.split('_|_')
                            if (resultado[0] == 1) {
                                 alert('La clave ha sido cambiada y enviada al correo del Delegado.');
                            }else{
                                 alert('No se pudo cambiar la clave. Vuelva a intentarlo.');
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
	}if (opcion==0){
             document.getElementById('div-panel-reset').style.display='none';
        }
	
}

