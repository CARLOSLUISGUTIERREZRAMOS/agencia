
////////////////////////////////////IMPORTACION///////////////////////////////////////

function js(cad){
	
	var scripts = cad.split(",");

	for( i = 0; i< scripts.length; i++ ){
		document.write('<script src="' + scripts[i] + '" type="text/javascript" language="javascript" charset="utf-8"></script>');
	}
	
}



////////////////////////////////////GENERALES///////////////////////////////////////

//retorna el objeto con el id solicitado
function gId(id){	
	return 	document.getElementById(id);
}
//retorna el html del objeto con el id solicitado
function gHTML(id){
	var elm;
	if(id=='[object]'){
		elm = id;
	}else{
		elm = gId(id);
	}
	return 	elm.innerHTML;
}

function sHTML(id, valor){
	var elm;
	if(id=='[object]'){
		elm = id;
	}else{
		elm = gId(id);
	}
	elm.innerHTML = valor;
}
//retorna el texto del objeto con el id solicitado
function gTexto(id){
	var elm;
	if(id=='[object]'){
		elm = id;
	}else{
		elm = gId(id);
	}
	return 	elm.innerText;
}

function sTexto(id, valor){
	var elm;
	if(id=='[object]'){
		elm = id;
	}else{
		elm = gId(id);
	}
	elm.innerText = valor;
}

//retorna el valor del objeto con el id solicitado
function gVal(id){
	var val;
	var elm;
	
	if(id=='[object]'){
		elm = id;
	}else{
		elm = gId(id);
	}
	
	if(elm != undefined){
		if(elm.tagName=='INPUT' || elm.tagName=='TEXTAREA'){
			val = elm.value;
		}else if(elm.tagName=='SELECT'){
			val = elm.options[elm.selectedIndex].value;
		}
	}
	return val;
}

//retorna una lista con los valores del objeto con el name solicitado
function gVals(name){
	
	var lista = new MBLista();

	var inputs = document.getElementsByName(name);	
	
	if(inputs.length > 0 && inputs[0].type == 'checkbox'){
		for( i = 0; i < inputs.length; i++ ){
			if(inputs[i].checked){
				lista.agrega(inputs[i].value);		
			}	
		}		
	}else{		
		
		for( i = 0; i < inputs.length; i++ ){
				lista.agrega(inputs[i].value);
		}	
	}
	
	return lista;
}

//retorna el índice seleccionado en un combo
function gIndex(id){	
	var elm;
	
	if(id=='[object]'){
		elm = id;
	}else{
		elm = gId(id);
	}
	return elm.selectedIndex;	
}


//retorna un arreglo de todos los objetos con el name solicitado
function gNom(nombre){
	return 	document.getElementsByName(nombre);
}


function gTag(nombre, padre){

	if(padre == undefined){		
		return 	document.getElementsByTagName(nombre);
	}else{
		
		var elm;
		
		if(padre=='[object]'){
			elm = padre;
		}else{
			elm = gId(padre);
		}		
		
		return 	elm.getElementsByTagName(nombre);	
	}
	
}

function sVal(id, val){
	var val;
	var elm;
	
	if(id=='[object]'){
		elm = id;
	}else{
		elm = gId(id);
	}
	if(elm != undefined){
		if(elm.tagName=='INPUT'){
			elm.value = val;
		}else if(elm.tagName=='SELECT'){
			var i;
			for( i = 0; i<elm.options.length; i++ ){
				if(elm.options[i].value==val){
					elm.selectedIndex=i;
					break;
				}
			}
			if(i==elm.options.length){
				return -1;
			}else{
				return elm.selectedIndex;	
			}
		}
	}	
}


function gValR(nombre){	
	
	for(i=0;i<gNom(nombre).length;i++){
		if(gNom(nombre)[i].type=='radio' && gNom(nombre)[i].checked==true){
			return gNom(nombre)[i].value;
		}
	}
	
}


function sValR(nombre, valor){	
	
	for(i=0;i<gNom(nombre).length;i++){
		if(gNom(nombre)[i].type=='radio' && gNom(nombre)[i].value==valor){
			gNom(nombre)[i].checked=true;
		}
	}
	
}

//////////////LISTA///////////////////////////////

function MBLista() {
	this.objs = [];	
	this.llave = false;
	this.q = 0;
}

//(atributo del objeto en lista, orden: asc o desc, tipo de dato)
MBLista.prototype.ordena = function(campo, orden, tipo){

	var temp;
	
	var mb_objetofecha = new MBFecha();
	
	if(orden == 'desc'){
		orden = '<';
	}else{
		orden = '>';
	}
	
	for (i = (this.objs.length - 1); i >= 0; i--){
		for (j = 1; j <= i; j++){
			if(tipo!='fecha'){
			eval('if (this.objs[j-1].' + campo + ' ' + orden + ' this.objs[j].' + campo + '){ temp = this.objs[j-1]; this.objs[j-1] = this.objs[j]; this.objs[j] = temp;	}');
			}else{
			eval('if (mb_objetofecha.fecha(this.objs[j-1].' + campo + ') ' + orden + ' mb_objetofecha.fecha(this.objs[j].' + campo + ')){ temp = this.objs[j-1]; this.objs[j-1] = this.objs[j]; this.objs[j] = temp;	}');	
			}
			
		}
	}
  
  
}

MBLista.prototype.g = function(index){
	return this.objs[index];    
}



MBLista.prototype.s = function(index, objeto){
	this.objs[index] = objeto;    
}


MBLista.prototype.agrega = function(objeto){
	this.objs.push(objeto);  
	this.q = this.q + 1;
}

MBLista.prototype.elimina = function(index){
	this.objs.splice(index, 1);  
	this.q = this.q - 1;
}

MBLista.prototype.getXLlave = function(valor){
	var i = this.getIndiceXLlave(valor);
	return this.g(i);
}

MBLista.prototype.getIndiceXLlave = function(valor){
	var indice = -1;
	for (i = 0; i < this.q; i++){
		eval('if (this.g(i).' + this.llave + ' == valor){ indice = i;}');		
	}  
	return indice;
}


//////////////FECHAS///////////////////////////////

function MBFecha() {
	this.NombreMeses = new Array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
	this.NombreDias = new Array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Dom','Lun','Mar','Mie','Jue','Vie','Sab');
	this.formato = 'dd/MM/yyyy';
}


MBFecha.prototype.LZ = function(x){return(x<0||x>9?"":"0")+x};

MBFecha.prototype.texto = function(date,format) {
	if(format == undefined){
		format = this.formato;
	}
	format=format+"";
	var result="";
	var i_format=0;
	var c="";
	var token="";
	var y=date.getYear()+"";
	var M=date.getMonth()+1;
	var d=date.getDate();
	var E=date.getDay();
	var H=date.getHours();
	var m=date.getMinutes();
	var s=date.getSeconds();
	var yyyy,yy,MMM,MM,dd,hh,h,mm,ss,ampm,HH,H,KK,K,kk,k;
	// Convert real date parts into formatted versions
	var value=new Object();
	if (y.length < 4) {y=""+(y-0+1900);}
	value["y"]=""+y;
	value["yyyy"]=y;
	value["yy"]=y.substring(2,4);
	value["M"]=M;
	value["MM"]=this.LZ(M);
	value["MMM"]=this.NombreMeses[M-1];
	value["NNN"]=this.NombreMeses[M+11];
	value["d"]=d;
	value["dd"]=this.LZ(d);
	value["E"]=this.NombreDias[E+7];
	value["EE"]=this.NombreDias[E];
	value["H"]=H;
	value["HH"]=this.LZ(H);
	if (H==0){value["h"]=12;}
	else if (H>12){value["h"]=H-12;}
	else {value["h"]=H;}
	value["hh"]=this.LZ(value["h"]);
	if (H>11){value["K"]=H-12;} else {value["K"]=H;}
	value["k"]=H+1;
	value["KK"]=this.LZ(value["K"]);
	value["kk"]=this.LZ(value["k"]);
	if (H > 11) { value["a"]="PM"; }
	else { value["a"]="AM"; }
	value["m"]=m;
	value["mm"]=this.LZ(m);
	value["s"]=s;
	value["ss"]=this.LZ(s);
	while (i_format < format.length) {
		c=format.charAt(i_format);
		token="";
		while ((format.charAt(i_format)==c) && (i_format < format.length)) {
			token += format.charAt(i_format++);
			}
		if (value[token] != null) { result=result + value[token]; }
		else { result=result + token; }
		}
	return result;
}

MBFecha.prototype.fecha = function(val,format) {
	if(format == undefined){
		format = this.formato;
	}
	val=val+"";
	format=format+"";
	var i_val=0;
	var i_format=0;
	var c="";
	var token="";
	var token2="";
	var x,y;
	var now=new Date();
	var year=now.getYear();
	var month=now.getMonth()+1;
	var date=1;
	var hh=now.getHours();
	var mm=now.getMinutes();
	var ss=now.getSeconds();
	var ampm="";
	
	while (i_format < format.length) {
		// Get next token from format string
		c=format.charAt(i_format);
		token="";
		while ((format.charAt(i_format)==c) && (i_format < format.length)) {
			token += format.charAt(i_format++);
			}
		// Extract contents of value based on format token
		if (token=="yyyy" || token=="yy" || token=="y") {
			if (token=="yyyy") { x=4;y=4; }
			if (token=="yy")   { x=2;y=2; }
			if (token=="y")    { x=2;y=4; }
			year=gE(val,i_val,x,y);
			if (year==null) { return 0; }
			i_val += year.length;
			if (year.length==2) {
				if (year > 70) { year=1900+(year-0); }
				else { year=2000+(year-0); }
				}
			}
		else if (token=="MMM"||token=="NNN"){
			month=0;
			for (var i=0; i<this.NombreMeses.length; i++) {
				var month_name=this.NombreMeses[i];
				if (val.substring(i_val,i_val+month_name.length).toLowerCase()==month_name.toLowerCase()) {
					if (token=="MMM"||(token=="NNN"&&i>11)) {
						month=i+1;
						if (month>12) { month -= 12; }
						i_val += month_name.length;
						break;
						}
					}
				}
			if ((month < 1)||(month>12)){return 0;}
			}
		else if (token=="EE"||token=="E"){
			for (var i=0; i<this.NombreDias.length; i++) {
				var day_name=this.NombreDias[i];
				if (val.substring(i_val,i_val+day_name.length).toLowerCase()==day_name.toLowerCase()) {
					i_val += day_name.length;
					break;
					}
				}
			}
		else if (token=="MM"||token=="M") {
			month=gE(val,i_val,token.length,2);
			if(month==null||(month<1)||(month>12)){return 0;}
			i_val+=month.length;}
		else if (token=="dd"||token=="d") {
			date=gE(val,i_val,token.length,2);
			if(date==null||(date<1)||(date>31)){return 0;}
			i_val+=date.length;}
		else if (token=="hh"||token=="h") {
			hh=gE(val,i_val,token.length,2);
			if(hh==null||(hh<1)||(hh>12)){return 0;}
			i_val+=hh.length;}
		else if (token=="HH"||token=="H") {
			hh=gE(val,i_val,token.length,2);
			if(hh==null||(hh<0)||(hh>23)){return 0;}
			i_val+=hh.length;}
		else if (token=="KK"||token=="K") {
			hh=gE(val,i_val,token.length,2);
			if(hh==null||(hh<0)||(hh>11)){return 0;}
			i_val+=hh.length;}
		else if (token=="kk"||token=="k") {
			hh=gE(val,i_val,token.length,2);
			if(hh==null||(hh<1)||(hh>24)){return 0;}
			i_val+=hh.length;hh--;}
		else if (token=="mm"||token=="m") {
			mm=gE(val,i_val,token.length,2);
			if(mm==null||(mm<0)||(mm>59)){return 0;}
			i_val+=mm.length;}
		else if (token=="ss"||token=="s") {
			ss=gE(val,i_val,token.length,2);
			if(ss==null||(ss<0)||(ss>59)){return 0;}
			i_val+=ss.length;}
		else if (token=="a") {
			if (val.substring(i_val,i_val+2).toLowerCase()=="am") {ampm="AM";}
			else if (val.substring(i_val,i_val+2).toLowerCase()=="pm") {ampm="PM";}
			else {return 0;}
			i_val+=2;}
		else {
			if (val.substring(i_val,i_val+token.length)!=token) {return 0;}
			else {i_val+=token.length;}
			}
		}
	// If there are any trailing characters left in the value, it doesn't match
	if (i_val != val.length) { return 0; }
	// Is date valid for month?
	if (month==2) {
		// Check for leap year
		if ( ( (year%4==0)&&(year%100 != 0) ) || (year%400==0) ) { // leap year
			if (date > 29){ return 0; }
			}
		else { if (date > 28) { return 0; } }
		}
	if ((month==4)||(month==6)||(month==9)||(month==11)) {
		if (date > 30) { return 0; }
		}
	// Correct hours value
	if (hh<12 && ampm=="PM") { hh=hh-0+12; }
	else if (hh>11 && ampm=="AM") { hh-=12; }
	var newdate=new Date(year,month-1,date,hh,mm,ss);
	return newdate;
}




////////////////////////////////////STRINGS///////////////////////////////////////

	
	
//get entero (cadena, posicion_inicial, mincaracteres,  maxcaracteres)
function gE(str,i,minlength,maxlength) {
	for (var x=maxlength; x>=minlength; x--) {
		
		var token=str.substring(i,i+x);
		
		if (token.length < minlength) { 
			return null; 
		}
		if (esE(token)) { 
			return token; 
		}
		
	}
	return null;
}

 // Reemplaza parte de una cadena
 //flagI = true no diferencia May y Min
 //flagG = true todas las coincidencias
 
function rCad(cadena, reemplazar, reemplazo, flagI, flagG){

	
	if(flagG==true || flagG==undefined){
		tipo='g';
	}
	
	if(flagI==true || flagI==undefined){
		tipo=tipo+'i';
	}
	
	eval('cadena = cadena.replace(/' + reemplazar + '/' + tipo + ', reemplazo)');
	
	return cadena;
}

 // retorna el texto entre dos límites
 
function gCadHitos(cadena, hizq, hder){
	
	var posi;
	var posf;	
	
	
	posi = cadena.indexOf(hizq) + hizq.length;
	posf = cadena.indexOf(hder);
	
	if(posi>0 && posf>0 && posi<posf){
		cadena = cadena.substring(posi, posf);
	}
	
	return cadena;
}



////////////VALIDACIÓN////////////////////////

//es hora
function esH(str) {

   
	if(!esE(str) || str > 23 || str < 0){
		return false;
	}
	
	return true;	   
	
}


//es minuto o segundo
function esM(str) {

	if(!esE(str) || str > 59 || str < 0){
		return false;
	}
	
	return true;	
	
}

//es correo
function esC(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)

		if (str.indexOf(at)==-1){		  
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   
		   return false;
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		  
		    return false;
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		   
		    return false;
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		  
		    return false;
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    
		    return false;
		 }
		
		 if (str.indexOf(" ")!=-1){
		   
		    return false;
		 }

 		 return true;				
}


//Es entero
function esE(val) {
	var digits="1234567890";
	for (var i=0; i < val.length; i++) {
		if (digits.indexOf(val.charAt(i))==-1) { 
			return false; 
		}
	}
	return true;
}

//Es numérico
function esN(str) {

    if(isNaN(str)){
        return false;	
    }
    return true;
	
}

//Es URL

function esURL(urlStr){
	if (urlStr.indexOf(" ")!=-1){		
		return false;
	}
	if(urlStr==""||urlStr==null){
		return false;
	}
	urlStr=urlStr.toLowerCase();
	var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
	var validChars="\[^\\s" + specialChars + "\]";
	var atom=validChars + '+';
	var urlPat=/^http:\/\/(\w*)\.([\-\+a-z0-9]*)\.(\w*)/;
	var matchArray=urlStr.match(urlPat);
	if (matchArray==null){		
		return false;
	}
	var user=matchArray[2];
	var domain=matchArray[3];
	for (i=0; i<user.length; i++) {
		if (user.charCodeAt(i)>127) {			
			return false;
		}
	}
	for (i=0; i<domain.length; i++) {
		if (domain.charCodeAt(i)>127) {			
			return false;
		}
	}
	var atomPat=new RegExp("^" + atom + "$");
	var domArr=domain.split(".");
	var len=domArr.length;
	for (i=0;i<len;i++) {
		if (domArr[i].search(atomPat)==-1) {			
			return false;
		}
	}

	return true;
}


//Es fecha
function esF(str, formato) {
	var mb_objetofecha = new MBFecha();
	if (mb_objetofecha.fecha(str, formato)==0){ 
		return false; 
	}
	return true;
}

////     MATH

function aleatorio(inferior,superior){ 
    numPosibilidades = superior - inferior;
    aleat = Math.random() * numPosibilidades;
    aleat = Math.floor(aleat);
    return parseInt(inferior) + aleat;
} 


/////POSICION

function gPos(obj){
	
	var left = obj.offsetLeft;
	var top = obj.offsetTop;
	while(obj.offsetParent!=null){
		
		parentelm = obj.offsetParent;
		left+=parentelm.offsetLeft;
		top+=parentelm.offsetTop;
		obj = parentelm;
	}
 	return [left,top];
}
//MEDIDA
function gAlto(obj) {
		yPos = obj.offsetHeight;
		return yPos;
}

function gAncho(obj) {	
		xPos = obj.offsetWidth;
		return xPos;
}

function gMed(obj) {
	var width = gAncho(obj);
	var height = gAlto(obj); 
	return [width,height];
}
//POPUP
//scrollbars=no,resizable=no,toolbar=no,menubar=no,location=no,directories=no,width=300px,height=180px,left=40,top=120,screenX=40,screenY=120';
function popUp(url, nombre, props){	
	var newWindow;
	newWindow = window.open(url, nombre, props);
	newWindow.opener = window;
}
