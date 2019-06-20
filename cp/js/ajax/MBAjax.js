function MBAjax(){	
	this.respuesta = MBAjaxInit();
//	this.mensaje = '';	
	this.mensaje = "<img src='../images/small_loader.gif' />";
	this.valores = '';	
	this.url = '';	
	this.metodo = '';	
	this.flag = true;	
	this.funcion = '';	
	this.texto = '';
	this.xml = '';
}

function MBAjaxInit(){
		var objXHTR=false;
		if ( typeof XMLHttpRequest == "undefined" )
		{
		  XMLHttpRequest = function(){
			  return new ActiveXObject(
				  navigator.userAgent.indexOf("MSIE 5") >= 0 ? "Microsoft.XMLHTTP" : "Msxml2.XMLHTTP"
			  );
		  };
		}
		objXHTR= new XMLHttpRequest();
		return objXHTR;
}

MBAjax.prototype.ajax = function(){
	
	if(this.metodo.toUpperCase()=='POST'){
		this.respuesta.open('POST', this.url, this.flag);
		var objMBAjax = this;
		
		if(this.flag==true){
			objMBAjax.respuesta.onreadystatechange = function() {
				if (objMBAjax.respuesta.readyState==1) {
					/* reemplazo  */
					//objMBAjax.mensaje="Cargando.......";
					//objMBAjax.mensaje = "<img src='images/small_loader.gif'/>";
				}else if (objMBAjax.respuesta.readyState==4){
					if(objMBAjax.respuesta.status==200){
						/* reemplazo  */
						//objMBAjax.mensaje = "Listo";
						objMBAjax.texto = objMBAjax.respuesta.responseText;
						objMBAjax.xml = objMBAjax.respuesta.responseXML;
						if(objMBAjax.funcion!=''){
							eval(objMBAjax.funcion);
						}	
					}else if(objMBAjax.respuesta.status==404){
						objMBAjax.mensaje = "La direccion no existe";
					}else{
						objMBAjax.mensaje = "Error: " + objMBAjax.respuesta.status;
					}
				}
			}
		}
		
		this.respuesta.setRequestHeader('Content-Type','application/x-www-form-urlencoded');	
		this.respuesta.send(encodeURI(this.valores));
		if(this.flag==false){
			/* reemplazo  */
			//objMBAjax.mensaje = "Listo";
			objMBAjax.mensaje = "<img src='images/small_loader.gif'/>";
			objMBAjax.texto = objMBAjax.respuesta.responseText;
			objMBAjax.xml = objMBAjax.respuesta.responseXML;
			if(objMBAjax.funcion!=''){
				eval(objMBAjax.funcion);
			}
		}	
		
		return;
	}

	if (this.metodo.toUpperCase()=='GET'){	
		this.respuesta.open ('GET', this.url+'?'+encodeURI(this.valores), this.flag);
		var objMBAjax = this;
		
		if(this.flag==true){
			objMBAjax.respuesta.onreadystatechange = function() {
				if (objMBAjax.respuesta.readyState==1) {
					objMBAjax.mensaje = "Cargando.......";
				}else if (objMBAjax.respuesta.readyState==4){
					if(objMBAjax.respuesta.status==200){
						objMBAjax.mensaje = "Listo";
						objMBAjax.texto = objMBAjax.respuesta.responseText;
						objMBAjax.xml = objMBAjax.respuesta.responseXML;
						if(objMBAjax.funcion!=''){
							eval(objMBAjax.funcion);	
						}	
						
					}else if(objMBAjax.respuesta.status==404){
						objMBAjax.mensaje = "La direccion no existe";
					}else{
						objMBAjax.mensaje = "Error: " + objMBAjax.respuesta.status;
					}
				}
			}
		}
		
		this.respuesta.send(null);	
		
		if(this.flag==false){
			//objMBAjax.mensaje = "Listo";
			objMBAjax.mensaje = "<img src='images/small_loader.gif'/>";
			objMBAjax.texto = objMBAjax.respuesta.responseText;
			objMBAjax.xml = objMBAjax.respuesta.responseXML;
			eval(objMBAjax.funcion);
		}	

		return;
	}
} 
