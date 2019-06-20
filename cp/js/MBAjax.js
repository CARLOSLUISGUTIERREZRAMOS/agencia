
function MBAjax(){	
	this.respuesta = MBAjaxInit();
	this.mensaje = '';	
	this.valores = '';	
	this.url = '';	
	this.metodo = '';	
	this.flag = true;	
	this.funcion = '';	
	this.texto = '';
	this.xml = '';
}



MBAjax.prototype.valoresURL = function(nombre, nombreparam){
	
	var inputs = document.getElementsByName(nombre);
	var cadena = '';
	
		
	if(nombreparam == undefined){
		nombreparam = nombre;
	}	
	
	if(inputs.length > 0 && inputs[0].type == 'checkbox'){
		for( i = 0; i < inputs.length; i++ ){
			if(inputs[i].checked){
				if( cadena != '' ){
					cadena = cadena + '&';	
				}
				cadena = cadena + nombreparam + '=' + inputs[i].value;		
			}	
		}		
	}else{		
		
		for( i = 0; i < inputs.length; i++ ){
				if( cadena != '' ){
					cadena = cadena + '&';	
				}
			cadena = cadena + nombreparam + '=' + inputs[i].value;
		}	
	}
	
	return cadena;
	
}




function MBAjaxInit(){
         var objetoAjax=false;
         try {
        
          objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
         } catch (e) {
          try {
                 
                   objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
                   }
                   catch (E) {
                   objetoAjax = false;
          }
         }

         if (!objetoAjax && typeof XMLHttpRequest!='undefined') {
          objetoAjax = new XMLHttpRequest();
         }
         return objetoAjax;
}



MBAjax.prototype.ajax = function(){
	
	if(this.metodo.toUpperCase()=='POST'){
		this.respuesta.open('POST', this.url, this.flag);
		var objMBAjax = this;
		
		if(this.flag==true){
			objMBAjax.respuesta.onreadystatechange = function() {
				if (objMBAjax.respuesta.readyState==1) {
					objMBAjax.mensaje="Cargando.......";
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
		
		this.respuesta.setRequestHeader('Content-Type','application/x-www-form-urlencoded');	
		this.respuesta.send(encodeURI(this.valores));	
		if(this.flag==false){
			objMBAjax.mensaje = "Listo";
			objMBAjax.texto = objMBAjax.respuesta.responseText;
			objMBAjax.xml = objMBAjax.respuesta.responseXML;
			eval(objMBAjax.funcion);
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
			objMBAjax.mensaje = "Listo";
			objMBAjax.texto = objMBAjax.respuesta.responseText;
			objMBAjax.xml = objMBAjax.respuesta.responseXML;
			eval(objMBAjax.funcion);
		}	

		return;
	}
} 


MBAjax.prototype.listaSimple = function(nodopadre){

	var MBListaTemporal = new MBLista();

	
	var nodos;

	if(nodopadre==undefined){
		nodos = this.xml.childNodes[0].childNodes;
	}else{
		
		nodos = this.xml.childNodes[0].getElementsByTagName(nodopadre);
		
		if(nodos.length>0){
			nodos = nodos[0].childNodes;	
		}
		
	}
	
	
	
	if(nodos.length>0){	
		var nodo = nodos[0];
		var atributos = nodo.attributes;
		var nombreObj = 'objMB' + nodo.tagName;
		var strIni = 'function ' + nombreObj + '(';
		var strMed = '';
		var strTemp = '';
		strCons = 'new ' + nombreObj + '(';
		
		for( i=0; i<atributos.length; i++ ){
			strIni = strIni + atributos[i].name;
			strMed = strMed + '\tthis.' + atributos[i].name + ' = ' + atributos[i].name + ';\n';
			strCons = strCons + '"(?)"';
			
			if(i<atributos.length-1){
				strIni = strIni + ', ';
				strCons = strCons + ', ';
			}else{
				strIni = strIni + '){\n';
				strMed = strMed + '}';
				strCons = strCons + ')';
			}
		}
		eval(strIni+strMed);
		
	
		for( i=0; i<nodos.length; i++ ){
			strTemp = strCons;
			for( j=0; j<atributos.length; j++ ){
				
				strTemp = strTemp.replace('(?)',nodos[i].getAttribute(atributos[j].name));
			}
			eval('MBListaTemporal.agrega(' + strTemp + ');');
		
			
		}		
		
		
	}
	
	return MBListaTemporal;
	
}

MBAjax.prototype.objetoSimple = function(){


	var nodos = this.xml.childNodes[0].childNodes;

	if(nodos.length>0){	
		var nodo = nodos[0];
		var atributos = nodo.attributes;
		var nombreObj = 'MBObjetoTemporal';
		var strIni = 'function ' + nombreObj + '(';
		var strMed = '';

		strCons = 'new ' + nombreObj + '(';
		
		for( i=0; i<atributos.length; i++ ){
			strIni = strIni + atributos[i].name;
			strMed = strMed + '\tthis.' + atributos[i].name + ' = ' + atributos[i].name + ';\n';
			strCons = strCons + '"(?)"';
			
			if(i<atributos.length-1){
				strIni = strIni + ', ';
				strCons = strCons + ', ';
			}else{
				strIni = strIni + '){\n';
				strMed = strMed + '}';
				strCons = strCons + ')';
			}
		}
		eval(strIni+strMed);	

		
		for( j=0; j<atributos.length; j++ ){
			
			strCons = strCons.replace('(?)',nodo.getAttribute(atributos[j].name));
			
		}
		
		eval('MBObjetoTemporal = ' + strCons + ';');
		
		return MBObjetoTemporal;
		
	}
	
	return null;
	
}
