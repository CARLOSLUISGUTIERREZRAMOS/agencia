// JavaScript Document

function CargaDatosAjax(url, valores)
{
	objA.valores=valores;
	objA.metodo="POST";
	objA.flag=false;
	objA.url=url;
	objA.ajax();
	return objA.texto;
}

function Focus(id_obj)
{
	if(document.getElementById(id_obj))
	{
		setTimeout("document.getElementById('"+id_obj+"').focus();",75);
	}
}

function Change()
{

	if(document.getElementById('resultado'))
	{
		document.getElementById('resultado').innerHTML='';
	}
}

function trim(texto)
{
	return texto.replace(/^\s+|\s+$/g,"");
}

function dgEBI(obj)
{
	var val='';
	if(document.getElementById(obj))
	{
		val=trim(document.getElementById(obj).value);
	}
	return val;
}

function formatCurrency(num) 
{ 
	num = num.toString().replace(/$|,/g,'');
	if(isNaN(num))
	{
		num = "0";
	}
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
	{
		cents = "0" + cents;
	}
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	{
		num = num.substring(0,num.length-(4*i+3))+','+num.substring(num.length-(4*i+3));
	}
	return (((sign)?'':'-') + num + '.' + cents);
}

function CaractValido(ev)
{
	tecla=(document.all) ? ev.keyCode : ev.which;
	if(tecla==8 || tecla==13 || tecla==0)
	{
		return true;
	}
	regEx=/^[a-z ]+$/i;
	teAsc=String.fromCharCode(tecla);
	return regEx.test(teAsc);
}

function ComprobarCaractValido(texto)
{
	var v_texto=trim(texto);
	var ok=1;
	var regEx=/^[a-z ]+$/i;
	//if(v_texto.match('[�,�,�,�,�,a,e,i,o,u,�,�,i,�,�,n,�,�,�,�,�,A,E,I,O,U,�,�,I,�,�,N,@,.]'))
	if(v_texto.length>0)
	{
		ok=0;
		if(v_texto.match(regEx))
		{
			ok=1;
		}
	}
	return ok;
}

function CaractValidoAlfa(ev)
{
	tecla=(document.all) ? ev.keyCode : ev.which;
	if(tecla==8 || tecla==13 || tecla==0)
	{
		return true;
	}
	regEx=/^[a-z0-9]+$/i;
	teAsc=String.fromCharCode(tecla);
	return regEx.test(teAsc);
}

function ComprobarCaractValidoAlfa(texto)
{
	var v_texto=trim(texto);
	var ok=1;
	var regEx=/^[a-z0-9]+$/i;
	//if(v_texto.match('[�,�,�,�,�,a,e,i,o,u,�,�,i,�,�,n,�,�,�,�,�,A,E,I,O,U,�,�,I,�,�,N,@,.]'))
	if(v_texto.length>0)
	{
		ok=0;
		if(v_texto.match(regEx))
		{
			ok=1;
		}
	}
	return ok;
}

function CaractValidoEmail(ev)
{
	tecla=(document.all) ? ev.keyCode : ev.which;
	if(tecla==8 || tecla==13 || tecla==0)
	{
		return true;
	}
	regEx=/^[a-z0-9@._-]+$/i;
	teAsc=String.fromCharCode(tecla);
	return regEx.test(teAsc);
}

function ComprobarCaractValidoEmail(texto)
{
	var v_texto=trim(texto);
	var ok=1;
	var regEx=/^[a-z0-9@._-]+$/i;
	//if(v_texto.match('[�,�,�,�,�,a,e,i,o,u,�,�,i,�,�,n,�,�,�,�,�,A,E,I,O,U,�,�,I,�,�,N,@,.]'))
	if(v_texto.length>0)
	{
		ok=0;
		if(v_texto.match(regEx))
		{
			ok=1;
		}
	}
	return ok;
}

function comprobar_email(texto)
{
	mensaje=1;
	if(texto.length>0)
	{
		var er_email=/^(.+\@.+\..+)$/
		if(!er_email.test(texto))
		{
			mensaje=0;
		}
	}
	return mensaje;
}

function NumeroInt(ev)
{
	tecla=(document.all) ? ev.keyCode : ev.which;
	if(tecla==8 || tecla==13 || tecla==0)
	{
		return true;
	}
	regEx=/\d/;
	teAsc = String.fromCharCode(tecla);
	return regEx.test(teAsc);
}

function ComprobarNumeroInt(texto)
{
	var v_texto=trim(texto);
	var ok=1;
	var regEx=/^[0-9]+$/i;
	if(v_texto.length>0)
	{
		ok=0;
		if(v_texto.match(regEx))
		{
			ok=1;
		}
	}
	return ok;
}