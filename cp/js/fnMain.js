function Focus(id_obj){
	setTimeout("document.getElementById('"+id_obj+"').focus();",75);
}
function Numero(ev){
    var tecla = (document.all) ? ev.keyCode : ev.which;
	if (tecla==8 || tecla==13 || tecla==0)
	{
		return true;
	}
	var regEx=/\d/;
    var teAsc = String.fromCharCode(tecla);
    return regEx.test(teAsc);
}
function MontoPrecio(ev) {
    var tecla= (document.all) ? ev.keyCode : ev.which;
	if (tecla==8 || tecla==13 || tecla==0)
	{
		return true;
	}
	var regEx=/[0-9,.]/;
    var teAsc = String.fromCharCode(tecla);
    return regEx.test(teAsc);
}
function NumeroRPM(ev) {
    var tecla= (document.all) ? ev.keyCode : ev.which;
	if (tecla==8 || tecla==13 || tecla==0)
	{
		return true;
	}
	var regEx=/[0-9*#]/;
    var teAsc = String.fromCharCode(tecla);
    return regEx.test(teAsc);
}
function NumeroNextel(ev) {
    var tecla= (document.all) ? ev.keyCode : ev.which;
	if (tecla==8 || tecla==13 || tecla==0)
	{
		return true;
	}
	var regEx=/[0-9*]/;
    var teAsc = String.fromCharCode(tecla);
    return regEx.test(teAsc);
}