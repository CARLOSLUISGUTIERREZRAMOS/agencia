<?php 
session_start();
error_reporting(E_ALL);
ini_set("display_errors",0);
date_default_timezone_set('America/Lima');
if($_SESSION['s_entra']==0){
    header('Location:../../index.php');
}
require_once '../../cd/Controlador/PasarelaControl.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title></title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all">
<link type="text/css" href="css/jquery/jquery.ui.all.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.7.min.js"></script>
<script type="text/javascript" language="javascript1.2" src="js/funciones.js"></script>
<script type="text/javascript" src="js/paso4_principal.js"></script>
<script type="text/javascript" language="javascript1.2">
<!--

function ComboAdultos()
{
	var adultos=1;
	var t='';
	if(adultos>0)
	{
		t='<select name="contacto" id="contacto" class="reserva_option" style="width: 250px; text-transform: uppercase" onChange="Change()">';
		for(i=1; i<=adultos; i++)
		{
			var v_nombre_a=trim(dgEBI('nombre_a_' + i));
			var v_paterno_a=trim(dgEBI('paterno_a_' + i));
			var v_materno_a=trim(dgEBI('materno_a_' + </select	var v_tipo_doc_a=trim(dgEBI('tipo_doc_a_' + i));
			var v_num_doc_a=trim(dgEBI('num_doc_a_' + i));
			if(v_nombre_a.length>0 && v_paterno_a.length>0 && v_materno_a.length>0 && v_num_doc_a.length>0)
			{
				t+='<option value="' +  v_nombre_a + '|' + v_paterno_a + '|' + v_materno_a + '|' + v_tipo_doc_a + '|' + v_num_doc_a + '" style="text-transform: uppercase">' + v_nombre_a + ' ' + v_paterno_a + ' ' + v_materno_a + '</option>';
			}
		}
		t+='</select>';
	}
	document.getElementById('td_contacto').innerHTML=t;
}

function EnviaValores()
{
	var adu=1;
	var nin=0;
	var inf=0;
	
	var ok=1;
	var ok_a=0;
	var ok_n=0;
	var ok_f=0;
	var arr_docs=Array();
	
	
	document.getElementById("btnAceptar").style.display="none";
	document.getElementById("div_aviso_show").style.display="inline";
	
	
	for(var a=1; a<=adu; a++)
	{
		var v_nombre_a=trim(dgEBI('nombre_a_' + a.toString()));
		var v_paterno_a=trim(dgEBI('paterno_a_' + a.toString()));
		var v_tipo_doc_a=trim(dgEBI('tipo_doc_a_' + a.toString()));
		var v_num_doc_a=trim(dgEBI('num_doc_a_' + a.toString()));
		var v_email_a=trim(dgEBI('email_a_' + a.toString()));
		var v_ofic_a=trim(dgEBI('ofic_a_' + a.toString()));
		var v_ofic_ane_a=trim(dgEBI('ofic_ane_a_' + a.toString()));
		var v_celular_a=trim(dgEBI('celular_a_' + a.toString()));
		var v_rpm_a=trim(dgEBI('rpm_a_' + a.toString()));
		var v_rpc_a=trim(dgEBI('rpc_a_' + a.toString()));
		var v_nextel_a_1=trim(dgEBI('rpc_a_' + a.toString() + '_1'));
		var v_nextel_a_2=trim(dgEBI('rpc_a_' + a.toString() + '_2'));
		if(a==1)
		{
			
			if(v_nombre_a.length>0 && v_paterno_a.length>0 && v_tipo_doc_a.length>0 && v_num_doc_a.length>0 && v_email_a.length>0)
			{
				ok_a=1;
				if(ComprobarCaractValido(v_nombre_a)==1 && ComprobarCaractValido(v_paterno_a)==1 && ComprobarCaractValidoAlfa(v_num_doc_a)==1 && ComprobarCaractValidoEmail(v_email_a)==1 && comprobar_email(v_email_a)==1
				 && (v_ofic_a.length<=0 || (v_ofic_a.length>0 && ComprobarNumeroInt(v_ofic_a)==1))
				 && (v_ofic_ane_a.length<=0 || (v_ofic_ane_a.length>0 && ComprobarNumeroInt(v_ofic_ane_a)==1))
				 && (v_celular_a.length<=0 || (v_celular_a.length>0 && ComprobarNumeroInt(v_celular_a)==1))
				 && (v_rpm_a.length<=0 || (v_rpm_a.length>0 && ComprobarNumeroInt(v_rpm_a)==1))
				 && (v_rpc_a.length<=0 || (v_rpc_a.length>0 && ComprobarNumeroInt(v_rpc_a)==1))
				 && (v_nextel_a_1.length<=0 || (v_nextel_a_1.length>0 && ComprobarNumeroInt(v_nextel_a_1)==1))
				 && (v_nextel_a_2.length<=0 || (v_nextel_a_2.length>0 && ComprobarNumeroInt(v_nextel_a_2)==1))
				)
				{
					ok_a=1;
					arr_docs.push(v_tipo_doc_a + '|' + v_num_doc_a);
				}
				else
				{

					if(ComprobarCaractValido(v_nombre_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El nombre del pasajero adulto N&ordm; 0' + a.toString() + ' tiene car&aacute;cteres incorrectos.';
						Focus('nombre_a_' + a.toString());
					}
					else if(ComprobarCaractValido(v_paterno_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El apellido paterno del pasajero adulto N&ordm; 0' + a.toString() + ' tiene car&aacute;cteres incorrectos.';
						Focus('paterno_a_' + a.toString());
					}					
					else if(ComprobarCaractValidoAlfa(v_num_doc_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El n&uacute;mero de documento del pasajero adulto N&ordm; 0' + a.toString() + ' tiene car&aacute;cteres incorrectos.';
						Focus('num_doc_a_' + a.toString());
					}
					else if(ComprobarCaractValidoEmail(v_email_a)!=1 || comprobar_email(v_email_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El E-mail del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('email_a_' + a.toString());
					}
					else if(v_ofic_a.length>0 && ComprobarNumeroInt(v_ofic_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El tel&eacute;fono de oficina del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('ofic_a_' + a.toString());
					}
					else if(v_ofic_ane_a.length>0 && ComprobarNumeroInt(v_ofic_ane_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El an&eacute;xo del tel&eacute;fono de oficina del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('ofic_ane_a_' + a.toString());
					}
					else if(v_celular_a.length>0 && ComprobarNumeroInt(v_celular_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El celular del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('celular_a_' + a.toString());
					}
					else if(v_rpm_a.length>0 && ComprobarNumeroInt(v_rpm_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El n&uacute;mero RPM del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('rpm_a_' + a.toString());
					}
					else if(v_rpc_a.length>0 && ComprobarNumeroInt(v_rpc_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El n&uacute;mero RPC del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('rpc_a_' + a.toString());
					}
					else if(v_nextel_a_1.length>0 && ComprobarNumeroInt(v_nextel_a_1)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El nextel del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('nextel_a_' + a.toString() + '_1');
					}
					else if(v_nextel_a_2.length>0 && ComprobarNumeroInt(v_nextel_a_2)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El nextel del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('nextel_a_' + a.toString() + '_2');
					}
					else if(v_email_a.length<=0)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* Ingrese el E-mail del pasajero adulto N&ordm; 0' + a.toString() + ' (Obligatorio).';
						Focus('email_a_' + a.toString());
					}
	

					ok_a=0;
					a=adu+1;
				}
			}
			else
			{
				if(v_nombre_a.length<=0)
				{
					document.getElementById('resultado_a_' + a.toString()).innerHTML='* Ingrese el nombre del pasajero adulto N&ordm; 0' + a.toString() + '.';
					Focus('nombre_a_' + a.toString());
				}
				else if(v_paterno_a.length<=0)
				{
					document.getElementById('resultado_a_' + a.toString()).innerHTML='* Ingrese el apellido paterno del pasajero adulto N&ordm; 0' + a.toString() + '.';
					Focus('paterno_a_' + a.toString());
				}				
				else if(v_tipo_doc_a.length<=0)
				{
					document.getElementById('resultado_a_' + a.toString()).innerHTML='* Seleccione el tipo de documento del pasajero adulto N&ordm; 0' + a.toString() + '.';
					Focus('tipo_doc_a_' + a.toString());
				}
				else if(v_num_doc_a.length<=0)
				{
					document.getElementById('resultado_a_' + a.toString()).innerHTML='* Ingrese el n&uacute;mero de documento del pasajero adulto N&ordm; 0' + a.toString() + '.';
					Focus('num_doc_a_' + a.toString());
				}
				else if(v_email_a.length<=0)
				{
					document.getElementById('resultado_a_' + a.toString()).innerHTML='* Ingrese el E-mail del pasajero adulto N&ordm; 0' + a.toString() + ' (Obligatorio).';
					Focus('email_a_' + a.toString());
				}
				ok_a=0;
				a=adu+1;
			}
		}
		else if(a>1 && a<=adu)
		{  
			if(v_nombre_a.length>0 && v_paterno_a.length>0 && v_tipo_doc_a.length>0 && v_num_doc_a.length>0 && v_email_a.length>0)
			{
				ok_a=1;
				if(ComprobarCaractValido(v_nombre_a)==1 && ComprobarCaractValido(v_paterno_a)==1 && ComprobarCaractValidoAlfa(v_num_doc_a)==1 && (v_email_a.length<=0 || (v_email_a.length>0 && ComprobarCaractValidoEmail(v_email_a)==1 && comprobar_email(v_email_a)==1))
				 && (v_ofic_a.length<=0 || (v_ofic_a.length>0 && ComprobarNumeroInt(v_ofic_a)==1))
				 && (v_ofic_ane_a.length<=0 || (v_ofic_ane_a.length>0 && ComprobarNumeroInt(v_ofic_ane_a)==1))
				 && (v_celular_a.length<=0 || (v_celular_a.length>0 && ComprobarNumeroInt(v_celular_a)==1))
				 && (v_rpm_a.length<=0 || (v_rpm_a.length>0 && ComprobarNumeroInt(v_rpm_a)==1))
				 && (v_rpc_a.length<=0 || (v_rpc_a.length>0 && ComprobarNumeroInt(v_rpc_a)==1))
				 && (v_nextel_a_1.length<=0 || (v_nextel_a_1.length>0 && ComprobarNumeroInt(v_nextel_a_1)==1))
				 && (v_nextel_a_2.length<=0 || (v_nextel_a_2.length>0 && ComprobarNumeroInt(v_nextel_a_2)==1))
				)
				{
					ok_a=1;
					arr_docs.push(v_tipo_doc_a + '|' + v_num_doc_a);
				}
				else
				{
					if(ComprobarCaractValido(v_nombre_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El nombre del pasajero adulto N&ordm; 0' + a.toString() + ' tiene car&aacute;cteres incorrectos.';
						Focus('nombre_a_' + a.toString());
					}
					else if(ComprobarCaractValido(v_paterno_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El apellido paterno del pasajero adulto N&ordm; 0' + a.toString() + ' tiene car&aacute;cteres incorrectos.';
						Focus('paterno_a_' + a.toString());
					}
					
					else if(ComprobarCaractValidoAlfa(v_num_doc_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El n&uacute;mero de documento del pasajero adulto N&ordm; 0' + a.toString() + ' tiene car&aacute;cteres incorrectos.';
						Focus('num_doc_a_' + a.toString());
					}
					else if(v_email_a.length>0 && (ComprobarCaractValidoEmail(v_email_a)!=1 || comprobar_email(v_email_a)!=1))
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El E-mail del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('email_a_' + a.toString());
					}
					else if(v_ofic_a.length>0 && ComprobarNumeroInt(v_ofic_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El tel&eacute;fono de oficina del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('ofic_a_' + a.toString());
					}
					else if(v_ofic_ane_a.length>0 && ComprobarNumeroInt(v_ofic_ane_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El an&eacute;xo del tel&eacute;fono de oficina del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('ofic_ane_a_' + a.toString());
					}
					else if(v_celular_a.length>0 && ComprobarNumeroInt(v_celular_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El celular del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('celular_a_' + a.toString());
					}
					else if(v_rpm_a.length>0 && ComprobarNumeroInt(v_rpm_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El n&uacute;mero RPM del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('rpm_a_' + a.toString());
					}
					else if(v_rpc_a.length>0 && ComprobarNumeroInt(v_rpc_a)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El n&uacute;mero RPC del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('rpc_a_' + a.toString());
					}
					else if(v_nextel_a_1.length>0 && ComprobarNumeroInt(v_nextel_a_1)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El nextel del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('nextel_a_' + a.toString() + '_1');
					}
					else if(v_nextel_a_2.length>0 && ComprobarNumeroInt(v_nextel_a_2)!=1)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* El nextel del pasajero adulto N&ordm; 0' + a.toString() + ' es incorrecto.';
						Focus('nextel_a_' + a.toString() + '_2');
					}
					else if(v_email_a.length<=0)
					{
						document.getElementById('resultado_a_' + a.toString()).innerHTML='* Ingrese el E-mail del pasajero adulto N&ordm; 0' + a.toString() + ' (Obligatorio).';
						Focus('email_a_' + a.toString());
					}
					
					ok_a=0;
					a=adu+1;
				}
			}
			else
			{	

				if(v_nombre_a.length<=0)
				{
					document.getElementById('resultado_a_' + a.toString()).innerHTML='* Ingrese el nombre del pasajero adulto N&ordm; 0' + a.toString() + '.';
					Focus('nombre_a_' + a.toString());
				}
				else if(v_paterno_a.length<=0)
				{
					document.getElementById('resultado_a_' + a.toString()).innerHTML='* Ingrese el apellido paterno del pasajero adulto N&ordm; 0' + a.toString() + '.';
					Focus('paterno_a_' + a.toString());
				}				
				else if(v_tipo_doc_a.length<=0)
				{
					document.getElementById('resultado_a_' + a.toString()).innerHTML='* Seleccione el tipo de documento del pasajero adulto N&ordm; 0' + a.toString() + '.';
					Focus('tipo_doc_a_' + a.toString());
				}
				else if(v_num_doc_a.length<=0)
				{
					document.getElementById('resultado_a_' + a.toString()).innerHTML='* Ingrese el n&uacute;mero de documento del pasajero adulto N&ordm; 0' + a.toString() + '.';
					Focus('num_doc_a_' + a.toString());
				}
				else if(v_email_a.length<=0)
				{
					document.getElementById('resultado_a_' + a.toString()).innerHTML='* Ingrese el E-mail del pasajero adulto N&ordm; 0' + a.toString() + ' (Obligatorio).';
					Focus('email_a_' + a.toString());
				}

				ok_a=0;
				a=adu+1;
			}
		}
	}
	if(ok_a==1)
	{
		if(nin<=0)
		{
			ok_n=1;
		}
		for(var n=1; n<=nin; n++)
		{
			var v_nombre_n=trim(dgEBI('nombre_n_' + n.toString()));
			var v_paterno_n=trim(dgEBI('paterno_n_' + n.toString()));
			var v_tipo_doc_n=trim(dgEBI('tipo_doc_n_' + n.toString()));
			var v_num_doc_n=trim(dgEBI('num_doc_n_' + n.toString()));
			var v_email_n=trim(dgEBI('email_n_' + n.toString()));
			
			if(v_nombre_n.length>0 && v_paterno_n.length>0 && v_tipo_doc_n.length>0 && v_num_doc_n.length>0)
			{
				ok_n=1;
				if(ComprobarCaractValido(v_nombre_n)==1 && ComprobarCaractValido(v_paterno_n)==1 && ComprobarCaractValidoAlfa(v_num_doc_n)==1 && (v_email_n.length<=0 || (v_email_n.length>0 && ComprobarCaractValidoEmail(v_email_n)==1 && comprobar_email(v_email_n)==1)))
				{
					ok_n=1;
					arr_docs.push(v_tipo_doc_n + '|' + v_num_doc_n);
				}
				else
				{
					if(ComprobarCaractValido(v_nombre_n)!=1)
					{
						document.getElementById('resultado_n_' + n.toString()).innerHTML='* El nombre del pasajero ni&ntilde;o N&ordm; 0' + n.toString() + ' tiene car&aacute;cteres incorrectos.';
						Focus('nombre_n_' + n.toString());
					}
					else if(ComprobarCaractValido(v_paterno_n)!=1)
					{
						document.getElementById('resultado_n_' + n.toString()).innerHTML='* El apellido paterno del pasajero ni&ntilde;o N&ordm; 0' + n.toString() + ' tiene car&aacute;cteres incorrectos.';
						Focus('paterno_n_' + n.toString());
					}					
					else if(ComprobarCaractValidoAlfa(v_num_doc_n)!=1)
					{
						document.getElementById('resultado_n_' + n.toString()).innerHTML='* El n&uacute;mero de documento del pasajero ni&ntilde;o N&ordm; 0' + n.toString() + ' tiene car&aacute;cteres incorrectos.';
						Focus('num_doc_n_' + n.toString());
					}
					else if(v_email_n.length>0 && (ComprobarCaractValidoEmail(v_email_n)!=1 || comprobar_email(v_email_n)!=1))
					{
						document.getElementById('resultado_n_' + n.toString()).innerHTML='* El E-mail del pasajero ni&ntilde;o N&ordm; 0' + n.toString() + ' es incorrecto.';
						Focus('email_n_' + n.toString());
					}
					ok_n=0;
					n=nin+1;
				}
			}
			else
			{
				if(v_nombre_n.length<=0)
				{
					document.getElementById('resultado_n_' + n.toString()).innerHTML='* Ingrese el nombre del pasajero ni&ntilde;o N&ordm; 0' + n.toString() + '.';
					Focus('nombre_n_' + n.toString());
				}
				else if(v_paterno_n.length<=0)
				{
					document.getElementById('resultado_n_' + n.toString()).innerHTML='* Ingrese el apellido paterno del pasajero ni&ntilde;o N&ordm; 0' + n.toString() + '.';
					Focus('paterno_n_' + n.toString());
				}				
				else if(v_tipo_doc_n.length<=0)
				{
					document.getElementById('resultado_n_' + n.toString()).innerHTML='* Seleccione el tipo de documento del pasajero ni&ntilde;o N&ordm; 0' + n.toString() + '.';
					Focus('tipo_doc_n_' + n.toString());
				}
				else if(v_num_doc_n.length<=0)
				{
					document.getElementById('resultado_n_' + n.toString()).innerHTML='* Ingrese el n&uacute;mero de documento del pasajero ni&ntilde;o N&ordm; 0' + n.toString() + '.';
					Focus('num_doc_n_' + n.toString());
				}
				ok_n=0;
				n=nin+1;
			}
		}
	}
	if(ok_a==1 && ok_n==1)
	{
		if(inf<=0)
		{
			ok_f=1;
		}
		for(var f=1; f<=inf; f++)
		{
			var v_nombre_f=trim(dgEBI('nombre_f_' + f.toString()));
			var v_paterno_f=trim(dgEBI('paterno_f_' + f.toString()));
			var v_tipo_doc_f=trim(dgEBI('tipo_doc_f_' + f.toString()));
			var v_num_doc_f=trim(dgEBI('num_doc_f_' + f.toString()));
			var v_email_f=trim(dgEBI('email_f_' + f.toString()));
			 
			if(v_nombre_f.length>0 && v_paterno_f.length>0 && v_tipo_doc_f.length>0 && v_num_doc_f.length>0)
			{
				ok_f=1;
				if(ComprobarCaractValido(v_nombre_f)==1 && ComprobarCaractValido(v_paterno_f)==1 && ComprobarCaractValidoAlfa(v_num_doc_f)==1 && (v_email_f.length<=0 || (v_email_f.length>0 && ComprobarCaractValidoEmail(v_email_f)==1 && comprobar_email(v_email_f)==1)))
				{
					ok_f=1;
					arr_docs.push(v_tipo_doc_f + '|' + v_num_doc_f);
				}
				else
				{	
					if(ComprobarCaractValido(v_nombre_f)!=1)
					{
						document.getElementById('resultado_f_' + f.toString()).innerHTML='* El nombre del pasajero infante N&ordm; 0' + f.toString() + ' tiene car&aacute;cteres incorrectos.';
						Focus('nombre_f_' + f.toString());
					}
					else if(ComprobarCaractValido(v_paterno_f)!=1)
					{
						document.getElementById('resultado_f_' + f.toString()).innerHTML='* El apellido paterno del pasajero infante N&ordm; 0' + f.toString() + ' tiene car&aacute;cteres incorrectos.';
						Focus('paterno_f_' + f.toString());
					}					
					else if(ComprobarCaractValidoAlfa(v_num_doc_f)!=1)
					{
						document.getElementById('resultado_f_' + f.toString()).innerHTML='* El n&uacute;mero de documento del pasajero infante N&ordm; 0' + f.toString() + ' tiene car&aacute;cteres incorrectos.';
						Focus('num_doc_f_' + f.toString());
					}
					else if(v_email_f.length>0 && (ComprobarCaractValidoEmail(v_email_f)!=1 || comprobar_email(v_email_f)!=1))
					{
						document.getElementById('resultado_f_' + f.toString()).innerHTML='* El E-mail del pasajero infante N&ordm; 0' + f.toString() + ' es incorrecto.';
						Focus('email_f_' + f.toString());
					}
					ok_f=0;
					f=inf+1;
				}
			}
			else
			{	

				if(v_nombre_f.length<=0)
				{
					document.getElementById('resultado_f_' + f.toString()).innerHTML='* Ingrese el nombre del pasajero infante N&ordm; 0' + f.toString() + '.';
					Focus('nombre_f_' + f.toString());
				}
				else if(v_paterno_f.length<=0)
				{
					document.getElementById('resultado_f_' + f.toString()).innerHTML='* Ingrese el apellido paterno del pasajero infante N&ordm; 0' + f.toString() + '.';
					Focus('paterno_f_' + f.toString());
				}				
				else if(v_tipo_doc_f.length<=0)
				{
					document.getElementById('resultado_f_' + f.toString()).innerHTML='* Seleccione el tipo de documento del pasajero infante N&ordm; 0' + f.toString() + '.';
					Focus('tipo_doc_f_' + f.toString());
				}
				else if(v_num_doc_f.length<=0)
				{
					document.getElementById('resultado_f_' + f.toString()).innerHTML='* Ingrese el n&uacute;mero de documento del pasajero infante N&ordm; 0' + f.toString() + '.';
					Focus('num_doc_f_' + f.toString());
				}
				ok_f=0;
				f=inf+1;
			}
		}
	}
	
	if(ok_a==1 && ok_n==1 && ok_f==1)
	{
		var v_doc='';
		var ok_doc=1;
		for(var i=1; i<arr_docs.length; i++)
		{
			v_doc=arr_docs[i - 1];
			if(v_doc==arr_docs[i])
			{
				ok_doc=0;
				i=arr_docs.length;
			}
		}
		if(ok_doc==1)
		{
			document.form1.submit();
		}
		else
		{
			document.getElementById('resultado').innerHTML='* No puede duplicar el n&uacute;mero de documento de los pasajeros.';
		}
	}
	return false;
}

function Change()
{	
	var adu=1;
	var nin=0;
	var inf=0;
	for(var a=1; a<=adu; a++)
	{
		if(document.getElementById('resultado_a_' + a.toString()))
		{
			document.getElementById('resultado_a_' + a.toString()).innerHTML='';
		}
	}
	for(var n=1; n<=nin; n++)
	{
		if(document.getElementById('resultado_n_' + n.toString()))
		{
			document.getElementById('resultado_n_' + n.toString()).innerHTML='';
		}
	}
	for(var f=1; f<=inf; f++)
	{
		if(document.getElementById('resultado_f_' + f.toString()))
		{
			document.getElementById('resultado_f_' + f.toString()).innerHTML='';
		}
	}
}
-->
</script>
<script>
$(function()
{       
	$('.documento_a').blur(function(){
            
                var identificador=$(this).attr('id');
                var partes=identificador.split('_');
                var id=partes[3];
                var tipo=$("#tipo_doc_a_"+id).val();
                var numero=$.trim($("#num_doc_a_"+id).val());
            if(numero!=''){
                $.ajax({
                    url:"../../cd/Controlador/ReservaControl.php",
                    type: "POST", 
                    data:"obtener_datos_pasajero=1&tipo="+tipo+"&numero="+numero,
                    success: function(mensaje){
                     /*   alert(mensaje);*/
                                var datos=mensaje.split('_|_');
                                if($.trim(datos[0])=='OK'){
                                    if(datos[1]!=''){
                                         $('#nombre_a_'+id).val(datos[1]);
                                    }
                                     if(datos[2]!=''){
                                         $('#paterno_a_'+id).val(datos[2]);
                                    }
                                     if(datos[3]!=''){
                                         $('#materno_a_'+id).val(datos[3]);
                                    }
                                     if(datos[4]!=''){
                                          $('#email_a_'+id).val(datos[4]);
                                    }
                                     if(datos[5]!=''){
                                         $('#ofic_a_'+id).val(datos[5]);
                                    }
                                     if(datos[6]!=''){
                                         $('#ofic_ane_a_'+id).val(datos[6]);
                                    }
                                     if(datos[7]!=''){
                                         $('#celular_a_'+id).val(datos[7]);
                                    }
                                     if(datos[8]!=''){
                                         $('#nextel_a_'+id).val(datos[8]);
                                    }
                                     if(datos[9]!=''){
                                         $('#rpm_a_'+id).val(datos[9]);
                                    }
                                    if(datos[10]!=''){
                                         $('#rpc_a_'+id).val(datos[10]);
                                    }
                                    $('#resultado_a_'+id).html('');
                                }else if($.trim(datos[0])=='ERROR'){
//                                    $('#nombre_a_'+id).val('');
//                                    $('#paterno_a_'+id).val('');
//                                    $('#materno_a_'+id).val('');
//                                    $('#email_a_'+id).val('');
//                                    $('#ofic_a_'+id).val('');
//                                    $('#ofic_ane_a_'+id).val('');
//                                    $('#celular_a_'+id).val('');
//                                    $('#nextel_a_'+id).val('');
//                                    $('#rpm_a_'+id).val('');
//                                    $('#rpc_a_'+id).val('');
//                                    $('#resultado_a_'+id).html('El usuario nunca ha sido registrado, ingrese los datos faltantes manualmente.');
                                }
                                 
                            }
                   });
                   
               }else{
//                   $('#nombre_a_'+id).val('');
//                    $('#paterno_a_'+id).val('');
//                    $('#materno_a_'+id).val('');
//                    $('#email_a_'+id).val('');
//                    $('#ofic_a_'+id).val('');
//                    $('#ofic_ane_a_'+id).val('');
//                    $('#celular_a_'+id).val('');
//                    $('#nextel_a_'+id).val('');
//                    $('#rpm_a_'+id).val('');
//                    $('#rpc_a_'+id).val('');
                   $('#resultado_a_'+id).html('');
               }
	
         });
         $('.documento_m').blur(function(){
              
                var identificador=$(this).attr('id');
                var partes=identificador.split('_');
                var id=partes[3];
                var tipo=$("#tipo_doc_m_"+id).val();
                var numero=$.trim($("#num_doc_m_"+id).val());
              if(numero!=''){
                $.ajax({
                    url:"../../cd/Controlador/ReservaControl.php",
                    type: "POST", 
                    data:"obtener_datos_pasajero=1&tipo="+tipo+"&numero="+numero,
                    success: function(mensaje){
//                        alert(mensaje);
                                var datos=mensaje.split('_|_');
                                if($.trim(datos[0])=='OK'){
                                    if(datos[1]!=''){
                                         $('#nombre_m_'+id).val(datos[1]);
                                    }
                                     if(datos[2]!=''){
                                         $('#paterno_m_'+id).val(datos[2]);
                                    }
                                     if(datos[3]!=''){
                                         $('#materno_m_'+id).val(datos[3]);
                                    }
                                     if(datos[4]!=''){
                                          $('#email_m_'+id).val(datos[4]);
                                    }
                                     if(datos[5]!=''){
                                         $('#ofic_m_'+id).val(datos[5]);
                                    }
                                     if(datos[6]!=''){
                                         $('#ofic_ane_m_'+id).val(datos[6]);
                                    }
                                     if(datos[7]!=''){
                                         $('#celular_m_'+id).val(datos[7]);
                                    }
                                     if(datos[8]!=''){
                                         $('#nextel_m_'+id).val(datos[8]);
                                    }
                                     if(datos[9]!=''){
                                         $('#rpm_m_'+id).val(datos[9]);
                                    }
                                    if(datos[10]!=''){
                                         $('#rpc_m_'+id).val(datos[10]);
                                    }
                                    $('#resultado_m_'+id).html('');
                                }else if($.trim(datos[0])=='ERROR'){
//                                    $('#nombre_m_'+id).val('');
//                                    $('#paterno_m_'+id).val('');
//                                    $('#materno_m_'+id).val('');
//                                    $('#email_m_'+id).val('');
//                                    $('#ofic_m_'+id).val('');
//                                    $('#ofic_ane_m_'+id).val('');
//                                    $('#celular_m_'+id).val('');
//                                    $('#nextel_m_'+id).val('');
//                                    $('#rpm_m_'+id).val('');
//                                    $('#rpc_m_'+id).val('');
//                                    $('#resultado_m_'+id).html('El usuario nunca ha sido registrado, ingrese los datos faltantes manualmente.');
                                }
                                 
                            }
                   });
                   
               }else{
//                   $('#nombre_m_'+id).val('');
//                    $('#paterno_m_'+id).val('');
//                    $('#materno_m_'+id).val('');
//                    $('#email_m_'+id).val('');
//                    $('#ofic_m_'+id).val('');
//                    $('#ofic_ane_m_'+id).val('');
//                    $('#celular_m_'+id).val('');
//                    $('#nextel_m_'+id).val('');
//                    $('#rpm_m_'+id).val('');
//                    $('#rpc_m_'+id).val('');
                   $('#resultado_m_'+id).html('');
               }
	
         });
         $('.documento_i').blur(function(){
             
                var identificador=$(this).attr('id');
                var partes=identificador.split('_');
                var id=partes[3];
                var tipo=$("#tipo_doc_i_"+id).val();
                var numero=$.trim($("#num_doc_i_"+id).val());
             if(numero!=''){
                $.ajax({
                    url:"../../cd/Controlador/ReservaControl.php",
                    type: "POST", 
                    data:"obtener_datos_pasajero=1&tipo="+tipo+"&numero="+numero,
                    success: function(mensaje){
//                        alert(mensaje);
                                var datos=mensaje.split('_|_');
                                if($.trim(datos[0])=='OK'){
                                   if(datos[1]!=''){
                                         $('#nombre_i_'+id).val(datos[1]);
                                    }
                                     if(datos[2]!=''){
                                         $('#paterno_i_'+id).val(datos[2]);
                                    }
                                     if(datos[3]!=''){
                                         $('#materno_i_'+id).val(datos[3]);
                                    }
                                     if(datos[4]!=''){
                                          $('#email_i_'+id).val(datos[4]);
                                    }
                                     if(datos[5]!=''){
                                         $('#ofic_i_'+id).val(datos[5]);
                                    }
                                     if(datos[6]!=''){
                                         $('#ofic_ane_i_'+id).val(datos[6]);
                                    }
                                     if(datos[7]!=''){
                                         $('#celular_i_'+id).val(datos[7]);
                                    }
                                     if(datos[8]!=''){
                                         $('#nextel_i_'+id).val(datos[8]);
                                    }
                                     if(datos[9]!=''){
                                         $('#rpm_i_'+id).val(datos[9]);
                                    }
                                    if(datos[10]!=''){
                                         $('#rpc_i_'+id).val(datos[10]);
                                    }
                                    $('#resultado_i_'+id).html('');
                                }else if($.trim(datos[0])=='ERROR'){
//                                    $('#nombre_i_'+id).val('');
//                                    $('#paterno_i_'+id).val('');
//                                    $('#materno_i_'+id).val('');
//                                    $('#email_i_'+id).val('');
//                                    $('#ofic_i_'+id).val('');
//                                    $('#ofic_ane_i_'+id).val('');
//                                    $('#celular_i_'+id).val('');
//                                    $('#nextel_i_'+id).val('');
//                                    $('#rpm_i_'+id).val('');
//                                    $('#rpc_i_'+id).val('');
//                                    $('#resultado_i_'+id).html('El usuario nunca ha sido registrado, ingrese los datos faltantes manualmente.');
                                }
                                 
                            }
                   });
               }else{
//                   $('#nombre_i_'+id).val('');
//                    $('#paterno_i_'+id).val('');
//                    $('#materno_i_'+id).val('');
//                    $('#email_i_'+id).val('');
//                    $('#ofic_i_'+id).val('');
//                    $('#ofic_ane_i_'+id).val('');
//                    $('#celular_i_'+id).val('');
//                    $('#nextel_i_'+id).val('');
//                    $('#rpm_i_'+id).val('');
//                    $('#rpc_i_'+id).val('');
                   $('#resultado_i_'+id).html('');
               }
	
         });
 })
</script>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.reserva_option, .reserva_option option {
	padding: 3px 3px 3px 0px;
}
-->
.gradiante{
    background: linear-gradient(#f01515, darkred) !important;
    background: -webkit-linear-gradient(#f01515, darkred) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f01515', endColorstr='darkred');
}
</style>

</head>
<body class="waiting">


<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
             <td>&nbsp;</td>
        </tr>
        <tr>
              <td height="50" align="center">
                    <table id="menu_vuelo" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                                <td height="19"><a  style="color:#323131;" href="paso1.php" title="Ir al Paso 1">1. FECHA</a></td>
                                <td width="4"></td>
                                <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                                <td width="30"></td>
                                <td><a  style="color:#323131;"  href="paso2.php" title="Ir al Paso 2">2. VUELOS</a></td>
                                <td width="4"></td>
                                <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                                <td width="30"></td>
                                <td><a  style="color:#323131;" href="paso3.php" title="Volver al Paso 3">3. PRECIO</a></td>
                                <td width="4"></td>
                                <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                                <td width="30"></td>
                                <td class="activo">4. PASAJEROS</td>
                                <td width="4"></td>
                                <td width="89" style="background-image: url(images/line_off.png); background-repeat: repeat-x"></td>
                                <td width="30"></td>
                                <td>5. CONFIRMACI&Oacute;N</td>
                        </tr>
                   </table>
             </td>
        </tr>
	<tr>
            <td height="340" align="center" style="background-color: #FFFFFF">
        
                <form id="form1" name="form1" method="post" action="paso5.php" autocomplete="off" onSubmit="return ValidarCamposDetalle();">

                <table width="900" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                        <td colspan="7"  height="1"  style="background: #323131;"></td>
                  </tr> 
                   <tr>
                        <td colspan="7" align="left" height="30" class="titleTable" style="color:#323131;font-size: 24px;background: #f0f0f0;font-family:Tahoma, Geneva, sans-serif; ">Paso 4</td>
                  </tr>
                   <tr>
                        <td colspan="7"  height="1"  style="background: #323131;"></td>
                  </tr>  
                  <tr>
                    <td height="10" >&nbsp;</td>
                 </tr>  
                  <tr>
                        <td >
                        <?php echo $table_cabecera_4; ?>
                        </td>
                  </tr>
                  <tr>
                         <td height="30" ></td>
                  </tr>
                  <tr>
                        <td >
                            <?php echo $table_precio_4; ?>
                        </td>
                  </tr>
                  <tr>
                        <td height="30"></td>
                  </tr>
                    <tr>
                        <td height="10">*Puede ingresar el N° de Documento y obtener los datos del pasajero.</td>
                  </tr>
                  <tr>
                    <td align="center">
                         <!-- aqui va la las tablas que se generan -->
                         <?php echo $table_pasajeros;?>
                    </td>
				  </tr>   

				  <tr>
                    <td align="center">
                         <!-- aqui va la las tablas que se generan -->
						  <table width="898" border="0" cellpadding="0" cellspacing="0">
						 	<tbody>
						  		<tr>
                          			<td align="left" class="titleTable gradiante" style="color:white;">Formas de Pago</td>
                        		</tr>
                         		<tr>
                            		<td height="3" colspan="5" style="background:#fdb813;"></td>
                       			</tr>
                        		<tr>
								<td height="1" style="background-color: #FFFFFF"></td>
								</tr>
                        <tr>
                          <td height="30" align="center">
                         <table width="898" cellpadding="0" cellspacing="0" border="0">
							  <tbody>
							  <tr class="pasajeros">
                                <td></td>
                              </tr>
                              <tr>
                                <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                              </tr>
                              <tr class="pasajeros">
								<td align="left">
									<select name="forma_pago">
									<option value="TC">Tarjeta de Credito</option>
									</select>
								</td>
                              </tr>
                              <tr>
                                <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                              </tr>
                            
                              <tr>
                                <td height="1" colspan="17" style="background-color: #FFFFFF"></td>
                              </tr>
                              <tr class="pasajeros">
                                <td height="30"></td>
                                <td colspan="16" align="left" id="resultado_a_1" style="color: #CC0033"></td>
                              </tr>
                            </tbody></table>
                          </td>
                        </tr>
				</tbody>
				</table>                    
				</td>
				  </tr>
                  <tr>
                    <td align="right"><input name="btnAceptar" id="btnAceptar" value="Continuar" class="btn-red" type="submit" /></td>
                    <input type='hidden' value="1" name='paso5' id='paso5'/>
                    <input type="hidden" name="tipo_viaje_5" id="tipo_viaje_5" value="<?php echo $tipo_viaje_4;?>"/>
                    <input type="hidden" name="adultos_5" id="adultos_5" value="<?php echo $adultos_4;?>"/>
                    <input type="hidden" name="menores_5" id="menores_5" value="<?php echo $menores_4;?>"/>
                    <input type="hidden" name="infantes_5" id="infantes_5" value="<?php echo $infantes_4;?>"/>
                    <input type="hidden" name="total_pagar_5" id="total_pagar_5" value="<?php echo $total_pagar_4;?>"/>
                    <input type="hidden" name="tuua_5" id="tuua_5" value="<?php echo $tuua_4;?>"/>
                    <input type="hidden" name="igv_5" id="igv_5" value="<?php echo $igv_4;?>"/>
                    <input type="hidden" name="tipo_moneda_5" id="tipo_moneda_5" value="<?php echo $tipo_moneda_4;?>"/>
                    <!--datos de vuelo ida-->
                    <input type="hidden" name="tarifa_ida_5" id="tarifa_ida_5" value="<?php echo $tarifa_ida_4;?>"/>
                    <input type="hidden" name="numero_vuelo_ida_5" id="numero_vuelo_ida_5" value="<?php echo $numero_vuelo_ida_4;?>"/>
                    <input type="hidden" name="fecha_hora_salida_ida_5" id="fecha_hora_salida_ida_5" value="<?php echo $fecha_hora_salida_ida_4;?>"/>
                    <input type="hidden" name="fecha_hora_llegada_ida_5" id="fecha_hora_llegada_ida_5" value="<?php echo $fecha_hora_llegada_ida_4;?>"/>
                    <input type="hidden" name="clase_ida_5" id="clase_ida_5" value="<?php echo $clase_ida_4;?>"/>
                    <input type="hidden" name="origen_ida_5" id="origen_ida_5" value="<?php echo $origen_ida_4;?>"/>
                    <input type="hidden" name="destino_ida_5" id="destino_ida_5" value="<?php echo $destino_ida_4;?>"/>
                     <!--datos de vuelo ida-->
                    <input type="hidden" name="tarifa_vuelta_5" id="tarifa_vuelta_5" value="<?php echo $tarifa_vuelta_4;?>"/>
                    <input type="hidden" name="numero_vuelo_vuelta_5" id="numero_vuelo_vuelta_5" value="<?php echo $numero_vuelo_vuelta_4;?>"/>
                    <input type="hidden" name="fecha_hora_salida_vuelta_5" id="fecha_hora_salida_vuelta_5" value="<?php echo $fecha_hora_salida_vuelta_4;?>"/>
                    <input type="hidden" name="fecha_hora_llegada_vuelta_5" id="fecha_hora_llegada_vuelta_5" value="<?php echo $fecha_hora_llegada_vuelta_4;?>"/>
                    <input type="hidden" name="clase_vuelta_5" id="clase_vuelta_5" value="<?php echo $clase_vuelta_4;?>"/>
                    <input type="hidden" name="origen_vuelta_5" id="origen_vuelta_5" value="<?php echo $origen_vuelta_4;?>"/>
                    <input type="hidden" name="destino_vuelta_5" id="destino_vuelta_5" value="<?php echo $destino_vuelta_4;?>"/>
                     <!--precios de adultos-->
                    <input type="hidden" name="tarifa_adulto_5" id="tarifa_adulto_5" value="<?php echo $tarifa_adulto_4;?>"/>
                    <input type="hidden" name="tuua_adulto_5" id="tuua_adulto_5" value="<?php echo $tuua_adulto_4;?>"/>
                    <input type="hidden" name="igv_adulto_5" id="igv_adulto_5" value="<?php echo $igv_adulto_4;?>"/>
                    <input type="hidden" name="subtotal_adulto_5" id="subtotal_adulto_5" value="<?php echo $subtotal_adulto_4;?>"/>
                     <!--precios de menores-->
                    <input type="hidden" name="tarifa_chil_5" id="tarifa_chil_5" value="<?php echo $tarifa_chil_4;?>"/>
                    <input type="hidden" name="tuua_chil_5" id="tuua_chil_5" value="<?php echo $tuua_chil_4;?>"/>
                    <input type="hidden" name="igv_chil_5" id="igv_chil_5" value="<?php echo $igv_chil_4;?>"/>
                    <input type="hidden" name="subtotal_chil_5" id="subtotal_chil_5" value="<?php echo $subtotal_chil_4;?>"/>
                     <!--precios de infantes-->
                    <input type="hidden" name="tarifa_bb_5" id="tarifa_bb_5" value="<?php echo $tarifa_bb_4;?>"/>
                    <input type="hidden" name="tuua_bb_5" id="tuua_bb_5" value="<?php echo $tuua_bb_4;?>"/>
                    <input type="hidden" name="igv_bb_5" id="igv_bb_5" value="<?php echo $igv_bb_4;?>"/>
                    <input type="hidden" name="subtotal_bb_5" id="subtotal_bb_5" value="<?php echo $subtotal_bb_4;?>"/>
                  </tr>
                  <tr>
                    <td height="30" align="left" id="resultado" style="color: #CC0033"></td>
                  </tr>
				</table>
				
              </form>
	</td>
  </tr>
</table>
</body>
</html>