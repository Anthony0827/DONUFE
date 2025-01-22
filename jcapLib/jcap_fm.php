<?
	header("Content-type: application/javascript");
	function v() {
		$cadena_buscar = "HWaddr";
		$tcad = strlen($cadena_buscar);

		$location = `/sbin/ifconfig eth0`;
		$pos = strpos($location,$cadena_buscar);
		if ($pos===false) {
			$tmp = "";
		} else {
			$tmp = trim(substr($location,$pos+$tcad,strpos($location," ",$pos+$tcad) - $tcad)) ;
		}
		
		$ret = "";
		for($i=0;$i<strlen($tmp);$i++) {
			if($i==0) {
				$ret .= "Chr(" . ord(substr($tmp,$i,1)) . ")";
			} else {
				$ret .= " + Chr(" . ord(substr($tmp,$i,1)) . ")";
			}
		}
		
		return $tmp;
	}
?>
var v = "<?php echo v(); ?>";
	if("00:19:d1:2b:d3:78" != v) {
		//window.location = "../";
	}
   
	function Asc(String)
	{
		return String.charCodeAt(0);
	}
	
	function Chr(AsciiNum)
	{
		return String.fromCharCode(AsciiNum)
	}

	function fLimpiaCampos(cadena) 
	{
		mat = cadena.split(",");	long=mat.length;
		for(i=1;i<=long;i++) 
		{ 	if(document.getElementById(mat[i-1])!=undefined )	{ document.getElementById(mat[i-1]).value=""; }
		}
	}
	
	function fDesactivaCampos(cadena) 
	{
		mat = cadena.split(",");	long=mat.length;
		for(i=1;i<=long;i++) 
		{ 	if(document.getElementById(mat[i-1])!=undefined )	{ document.getElementById(mat[i-1]).disabled="disabled"; }
		}
	}
	
	function fActivaCampos(cadena) 
	{
		mat = cadena.split(",");	long=mat.length;
		for(i=1;i<=long;i++) 
		{ 	if(document.getElementById(mat[i-1])!=undefined )	{ document.getElementById(mat[i-1]).disabled=""; }
		}
	}
	
	
	function fValidaCampos(cadena) 
	{
		mat = cadena.split(",");	
		long=mat.length;
		for(i=1;i<=long;i++) { 
			if (eval('trim(document.getElementById("'+mat[i-1]+'").value)==""')) { 
				
				msg = document.getElementById(mat[i-1]).getAttribute("mensaje");
				if(msg == null) {
					msg = mat[i-1];					
				}
				
				eval('alert("El Campo '+msg+' no debe estar vacio");'); 
				eval('document.getElementById("'+mat[i-1]+'").focus();');  
				return (false); 
			}
		}
	}
	
	function fReadonlyCamposCadena(cadena) 
	{
		mat = cadena.split(",");	long=mat.length;
		for(i=1;i<=long;i++) { eval('document.getElementById("'+mat[i-1]+'").readonly=true);');	}
	}
	
	function insertSelect(nom,val,tex)
	{
	  var elOptNew = document.createElement('option');
	  elOptNew.text = tex;
	  elOptNew.value = val;
	  var elSel = document.getElementById(nom);
	  try { elSel.add(elOptNew, null); } 
	  catch(ex) {   elSel.add(elOptNew); } 
	}
	
	function limpiaSelect(nom)
	{
	  var elSel = document.getElementById(nom);
	  if (elSel.length > 0)
	  { for (i = elSel.length - 1; i>=0; i--) 
		{    elSel.remove(i); }
	  }
	}

	/* Devuelve el objeto option seleccionado de un combo. Ejemplo: cmb_opcion('mi_cmb').text */
	function cmb_opcion(cmb_id, indice){
		if(indice == undefined ){
			return document.getElementById(cmb_id).options[document.getElementById(cmb_id).selectedIndex];
		}else{
			return document.getElementById(cmb_id).options[indice];
		}
	}
	
	
	/* para buscar el text de un elemento seleccionado en un combo */
	function buscar_option(id) 
	{	for(i=0; i<document.getElementById(id).length;i++)
		{	if (document.getElementById(id).options[i].selected) {
				return document.getElementById(id).options[i].text;
			}
		}
	}	

	function del_option(id){
		for(i=0; i<document.getElementById(id).options.length; i++){
			if (document.getElementById(id).options[i].selected) {
				document.getElementById(id).remove(i);
				return;
			}
		}
		alert("Debe seleccionar una opcion para borrar");
	}
	
	/* para buscar el atributo de un elemento seleccionado en un combo*/
	function buscar_atributo(id, att) 
	{	for(i=0; i<document.getElementById(id).length;i++)
		{	if (document.getElementById(id).options[i].selected) {
				return document.getElementById(id).options[i].getAttribute(att);
			}
		}
	}	

	/* Buscar el indice de una opción del combo a traves de su valor */
	function cmb_indice(id,valor){
		var i;
		for(i=0; i<document.getElementById(id).length; i++){
			if(cmb_opcion(id,i).value == valor){
				return i+1;
			}
		}
		return false;
	}
	
	function cmb_agregar(id, valor, txt){
		var i = document.getElementById(id).length+1;
		document.getElementById(id).length = i;
		document.getElementById(id).options[i-1].value = valor;
		document.getElementById(id).options[i-1].text = txt;
	}
	
	/* Para limpiar un combo cargado con ajax */
	function cmb_limpiar(cap, id, extra){
		if(extra == undefined){
			extra = '';
		}
		document.getElementById(cap).innerHTML = '<select id="'+id+'" name="'+id+'" class="caja_tex"><option value="">&nbsp;</option></select>'+extra;	
	}
	
	function smajax(metodo,url,parametros,destino,mesnsaje)
	{
		var vmetodo = metodo;
		var vurl =url;
		var vparametros = parametros;
		var vdestino = destino;
		var vmesnsaje = mesnsaje;
		var objeto=crearsmajax();
		var salida;
		var vfuncion='';
		this.vfuncion='';
		this.ejecutasmajax=ejecutasmajax;
		objeto.onreadystatechange=actualizasmajax;		
	
		function crearsmajax() 
		{ 
			try { 
				objetoajax = new ActiveXObject("Msxml2.XMLHTTP"); 
			} catch (e) { try { objetoajax= new ActiveXObject("Microsoft.XMLHTTP"); } 
						  catch (E) { objetoajax= false;  } 
			} 
			if (!objetoajax && typeof XMLHttpRequest!='undefined') { 
				objetoajax = new XMLHttpRequest(); 
			} 
			return objetoajax ;
		} 
	
		function ejecutasmajax() 
		{
			if(vmetodo.toUpperCase()=="GET" || vmetodo=="")
			{
				longitud = vurl.length;
				if (vurl.substr(longitud-1,1)!="?")
				{ vurl = vurl + "?" + vparametros;}
				else
				{ vurl = vurl + vparametros; }
				objeto.open("GET",vurl,true); 
				objeto.send('');
			} 
			else 
			{
				vparametros = generacampos();
				objeto.open("POST",vurl,true); 
				objeto.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				objeto.setRequestHeader("Content-length", vparametros.length);
				objeto.send(vparametros);		
			}
			vfuncion=this.vfuncion;
		}
	
		function actualizasmajax() 
		{

			if (bloquea_pantalla()!=undefined) { bloquea_pantalla(); }
			if (document.getElementById("vmesnsaje_bloquea_pantalla")!=undefined) 
			{
				if (objeto.readyState==1)  { document.getElementById("vmesnsaje_bloquea_pantalla").innerHTML="Cargando..."; 	      } 
				if (objeto.readyState==2)  { document.getElementById("vmesnsaje_bloquea_pantalla").innerHTML="Conetado con servidor..."; } 
				if (objeto.readyState==3)  { document.getElementById("vmesnsaje_bloquea_pantalla").innerHTML="Recibiendo datos"; } 
			}
			else
			{
				if (vmesnsaje!="") 
				{	if (document.getElementById(vmesnsaje)!=undefined) 
					{	document.getElementById(vmesnsaje).style.display = ""; 
						if (objeto.readyState==1) {	document.getElementById(vmesnsaje).innerHTML="Cargando"; 	} 
						if (objeto.readyState==2) {	document.getElementById(vmesnsaje).innerHTML="Carga completa paso al siguiente nivel";  } 
						if (objeto.readyState==3) {	document.getElementById(vmesnsaje).innerHTML="Recibiendo datos"; } 
					}
				}
			}
			if (objeto.readyState==4) 
			{
				if (document.getElementById("vmesnsaje_bloquea_pantalla")!=undefined) 
				{  
					document.getElementById("vmesnsaje_bloquea_pantalla").innerHTML="Operacion terminada";
				}
				else
				{
					if (vmesnsaje!="") 
					{
						if (document.getElementById(vmesnsaje)!=undefined) 
						{	document.getElementById(vmesnsaje).innerHTML="Operacion terminada"; 
							document.getElementById(vmesnsaje).style.display = "none"; 
						}
					}
				}
				if (desbloquea_pantalla()!=undefined) { desbloquea_pantalla(); }
		
				if(objeto.status>=500 && objeto.status<600) {
					alert("Se produjo un error en la peticion.");
				}
				if(objeto.status>=400 && objeto.status<=402) {
					alert("URL No autorizada. [Error "+objeto.status+"]");
				}
				if(objeto.status==403) {
					alert("URL No autorizada. [Error 403]");
				}
				if(objeto.status==404) {
					alert("No se encontro la direccion solicitada. [Error 404]");
				}
				if(objeto.status==200) { 
					if (vdestino!="ME") { 	
						if (document.getElementById(vdestino)==undefined) { alert("No esta definido el campo: "+vdestino); }
						document.getElementById(vdestino).innerHTML = objeto.responseText; 
						
						var arr_scripts = String(objeto.responseText).match(/(?!<script[^<]+>)[^<>]+?(?=<\/script>)/gim);
						if (arr_scripts!=null) {
							for (x_arr=0;x_arr<arr_scripts.length;x_arr++) {
								try {
									eval(arr_scripts[x_arr]);
								} catch (e) { alert("Error: " + e.description); }
							}
						}
						if (vfuncion!="") {	
							eval(vfuncion);
						}
					} else { 
						try {

							DeveloverValor(objeto.responseText);

						} catch(e){ alert("Debe definir la funcion DeveloverValor(str)") }
					}
				}
			} 
		}
	
		function generacampos() {
			var campos="";
			var form = document.getElementById(vparametros);
			for (i=0;i<form.elements.length;i++) {  
				if (form.elements[i].type!="file" || form.elements[i].type!="reset" || form.elements[i].type!="submit" || form.elements[i].type!="button") {
					nom=form.elements[i].name;
					tip=form.elements[i].type;
					val=form.elements[i].value;
					if ((form.elements[i].type == "checkbox" || form.elements[i].type == "radio") && form.elements[i].checked == false) { 
					} else {
						if (tip == "select-multiple") {
							val = "";
							for (x=0;x<form.elements[i].options.length;x++){
								if (form.elements[i].options[x].selected) {
									val=val+form.elements[i].options[x].value+';';
								}
							}
							val = val.substr(0,val.length-1);
						}
						if (campos.indexOf("&"+nom+"=")==-1 && form.elements[i].value!="" || form.elements[i].type == "checkbox") {
							if (campos!="") {
								campos += "&"+nom+"="+val;
							} else {
								campos = nom+"="+val;
							}
						}
					}
				 }
			}
			return campos; 
		}
	}


	function agregar_valor()
	{
		document.getElementById("txtcodigo").value = '';
		document.getElementById("txcodigosel").value = '';
	}
	

function captura_campos(vparametros)
{   
	var campos="";
	var form = document.getElementById(vparametros);
	n=form.elements.length;   
	for (i=0;i<n;i++)
	{ 
		if ((form.elements[i].type=="hidden") || (form.elements[i].type=="text") || (form.elements[i].type=="textarea")  || (form.elements[i].type=="checkbox") || (form.elements[i].type=="radio") || (form.elements[i].type=="select-one") || (form.elements[i].type=="password")) 
		 {
			nom=form.elements[i].name;
			tip=form.elements[i].type;
			
			val=form.elements[i].value;
			if (form.elements[i].type == "checkbox" && form.elements[i].checked == false) { val = ""; }

			if (tip == "select-multiple") 
			{ 
				val = "";
				for (x=0;x<form.elements[i].options.length;x++){ 
					if (form.elements[i].options[x].selected) {
						val=val+form.elements[i].options[x].value+';'; 
					}
				}
				val = val.substr(0,val.length-1);
			} 
			
			if (campos!="")
			{ campos = campos+"&"+nom+"="+val; }
			else
			{ campos = nom+"="+val; }
		 }
	}
	return campos; 
}



function smgrid(ngrid,ndestino,sololectura,botoneli,botonsel)
{
	var nombregrid = ngrid;
	var nombredestino = ndestino;
	var totalcampos = "";
	var totaltipos = "";
	var totalanchos = "";
	var slectura="";
	var belimina = botoneli;
	var bseleccionar = botonsel;
	var class_celda=' font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; border-top-width: thin; border-right-width: thin; border-bottom-width: thin; border-left-width: thin; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: none; border-top-color: #B5C4D2; border-right-color: #B5C4D2; border-bottom-color: #B5C4D2; border-left-color: #B5C4D2;  ';
	var class_titulo=' font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #0000CC; background-color: #CCCCCC; border-top-width: thin; border-right-width: thin; border-bottom-width: thin; border-left-width: thin; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: #E2E2E2; border-right-color: #AEAEAE; border-bottom-color: #AEAEAE; border-left-color: #E2E2E2; ';
	var class_item=' font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #0000CC; background-color: #CCCCCC; border-top-width: thin; border-right-width: thin; border-bottom-width: thin; border-left-width: thin; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: #E2E2E2; border-right-color: #AEAEAE; border-bottom-color: #AEAEAE; border-left-color: #E2E2E2; ';
	if (sololectura!="")
	{ slectura = "yes";	}

	this.evt_elimina='';
	this.evt_sel='';
	this.generacampos=generacampos;
	this.agregafila=agregafila;
	this.agregar=agregar;
	this.limpiar=limpiar;
	
	function generacampos(nvalores,ntipos,nanchos)
	{	
		totalcampos = nvalores;
		totaltipos = ntipos;
		totalanchos = nanchos;
		ncampos=nvalores.split(",");
		ncamptipos = totaltipos.split(",");
		ncampanchos = totalanchos.split(",");		
		clinea = '<input type=\"hidden\" name=\"smlineagrid\" id="smlineagrid" value=\"\">';
		clinea +='<input type=\"hidden\" name=\"smcolumnagrid\" id="smcolumnagrid" value=\"'+ncampos.length+'\">';
		clinea +='<input type=\"hidden\" name=\"smcamposgrid\" id="smcamposgrid" value=\"'+nvalores+'\">';
		ctabla = '<table border="0" id="'+nombregrid+'" name="'+nombregrid+'"  cellpadding="0" cellspacing="0">';
		ctabla += '<tr style="'+class_titulo+'"><td>&nbsp;</td>';
		for (i=0;i<=ncampos.length-1;i++)
		{ 
			if (ncamptipos[i]==undefined)
			{ ctabla += "<td>&nbsp;"+ncampos[i].toUpperCase()+"<input type='hidden' name='smf0_c"+(i+1)+"' id='smf0_c"+(i+1)+"' value=''></td>"; }
			else if (ncamptipos[i]=="hidden")
			{ ctabla += "<td><input type='hidden' name='smf0_c"+(i+1)+"' id='smf0_c"+(i+1)+"' value=''></td>"; }		
			else
			{ ctabla += "<td>&nbsp;"+ncampos[i].toUpperCase()+"<input type='hidden' name='smf0_c"+(i+1)+"' id='smf0_c"+(i+1)+"' value=''></td>"; }		
		}
		
		if (belimina!="")
		{ctabla += "<td>&nbsp;</td>";}
		
		if (botonsel!="")
		{ctabla += "<td>&nbsp;</td>";}
		ctabla += "</tr></table>"+clinea;
		
		document.getElementById(nombredestino).innerHTML = ctabla;
	}
	
	function agregafila()
	{	
		var ntabla = document.getElementById(nombregrid);
		var cantfilas = ntabla.rows.length;
		var nfila = ntabla.insertRow(cantfilas);
		var nnodo=0;
		document.getElementById("smlineagrid").value=cantfilas;
		for (i=1;i<=cantfilas;i++)
		{
			if (document.getElementById("SMFila"+i)!=undefined)
			{
				if (document.getElementById("SMFila"+i).style.display!="none")
				{
					nnodo++;
				}
			}	
		}
		nnodo++;

		nfila.setAttribute("id","SMFila"+cantfilas);
		nfila.setAttribute("name","SMFila"+cantfilas);

		ncampos = totalcampos.split(",");
		ncamptipos = totaltipos.split(",");
		ncampanchos = totalanchos.split(",");
		
		ncelda = nfila.insertCell(0);
		ncelda.appendChild(document.createTextNode(nnodo));		
		ncelda.setAttribute("style",class_item);
		ncelda.setAttribute("id","n"+cantfilas);
		
		for(i=0;i<=ncampos.length-1;i++)
		{
			nroc = i+1;
			ncelda = nfila.insertCell(nroc);
			var ncolumna = document.createElement("input");
			ncolumna.setAttribute("type","text");
			if (ncamptipos[i]==undefined)
			{ ncolumna.setAttribute("type","text");}
			else
			{ ncolumna.setAttribute("type",ncamptipos[i]);}
			ncolumna.setAttribute("name","smf" + cantfilas + "_c" + nroc);
			ncolumna.setAttribute("id","smf" + cantfilas + "_c" + nroc);
			if (ncampanchos[i]!=undefined)
			{ncolumna.setAttribute("size",ncampanchos[i]);}
			ncolumna.setAttribute("value",document.getElementById(ncampos[i]).value);
			if (slectura!="")
			{ ncolumna.setAttribute("readOnly",slectura);}
			ncolumna.setAttribute("style",class_celda);
			ncelda.appendChild(ncolumna);
			document.getElementById(ncampos[i]).value="";
		}

		if (botonsel!="")
		{
			ncelda = nfila.insertCell(ncampos.length+1);
			var nboton = document.createElement("input");
			nboton.setAttribute("type","button");
			nboton.setAttribute("name","BotonS"+cantfilas);
			nboton.setAttribute("id","BotonS"+cantfilas);
			nboton.setAttribute("style",class_item);
			nboton.setAttribute("value","S");
			var evento_sel = "";
			if (this.evt_sel!="") { evento_sel = this.evt_sel+"("+cantfilas+");"; }
			nboton.setAttribute("onClick","seleccionacelda("+cantfilas+","+nroc+",'"+nombregrid+"');"+evento_sel);
			ncelda.appendChild(nboton);			
		}

		if (belimina!="")
		{
			ncelda = nfila.insertCell(ncampos.length+1);
			var nboton = document.createElement("input");
			nboton.setAttribute("type","button");
			nboton.setAttribute("name","BotonE"+cantfilas);
			nboton.setAttribute("id","BotonE"+cantfilas);
			nboton.setAttribute("style",class_item);
			nboton.setAttribute("value","X");
			ncelda.appendChild(nboton);	
			var evt_elimina = this.evt_elimina;
			document.getElementById('BotonE'+cantfilas).onclick = function(){ eliminacelda(cantfilas, nroc, nombregrid, evt_elimina); };
		}
	}
	
	function agregar(valor){
		for(i=0;i<=ncampos.length-1;i++){
			document.getElementById(ncampos[i]).disabled = !valor;
		}
		document.getElementById('bIngresar').disabled = !valor;
	}
	
	function limpiar(){
		document.getElementById(nombredestino).innerHTML="";
		generacampos(totalcampos,totaltipos,totalanchos);
	}

}

function columna_readonly(col,valor)
{
	for(y=1; y<=document.getElementById("smlineagrid").value; y++){
		document.getElementById('smf'+y+'_c'+col).readOnly = !valor;
	}
}
	
function eliminacelda(efila, nc, ntab, evt)
{
	var ntabla = document.getElementById(ntab);
	var cantfilas = ntabla.rows.length;	
	var ncont = 0;
	
	for (b=1; b<=nc;b++)
	{
		nnom = "smf"+efila+"_c"+b;
		if (document.getElementById(nnom)!=undefined)
		{ 
		  document.getElementById(nnom).disabled="disabled";
		  document.getElementById(nnom).value="";
		}
	}

	if (document.getElementById("SMFila"+efila)!=undefined)
	{ 
		document.getElementById("SMFila"+efila).style.display="none"; 
	}

	for (b=1;b<=cantfilas;b++)
	{
		if (document.getElementById("SMFila"+b)!=undefined)
		{
			if (document.getElementById("SMFila"+b).style.display!="none")
			{
				ncont++;
				document.getElementById("n"+b).innerHTML=ncont;
			}
		}
	}

	eval(evt); //evento adicional una vez que se elimina

}

function seleccionacelda(efila, nc, ntab)
{
	var ntabla = document.getElementById(ntab);
	var cantfilas = ntabla.rows.length;	
	for (b=1;b<=cantfilas;b++)
	{
		if (document.getElementById("SMFila"+b)!=undefined)
		{
			if (document.getElementById("SMFila"+b).style.display!="none")
			{
					if (b==efila)
					{
						for (c=1;c<=nc;c++)
						{
							nnom = "smf"+b+"_c"+c;
							nnom2 = "smf0_c"+c;
							if (document.getElementById(nnom)!=undefined)
							{ 
							document.getElementById(nnom2).value=document.getElementById(nnom).value; 
							document.getElementById(nnom).style.backgroundColor ="#B9E3FF"; 
							}
						}
					}
					else
					{  
						for (c=1;c<=nc;c++)
						{
							nnom = "smf"+b+"_c"+c;
							if (document.getElementById(nnom)!=undefined)
							{ document.getElementById(nnom).style.backgroundColor ="#FFFFFF"; }
						}
					}
			 }
		}
	}
}

function gridsumacol(col){
	var suma = 0;
	for(i=1; i<=document.getElementById("smlineagrid").value; i++){
		if(document.getElementById('smf'+i+'_c'+col).value != ''){
			suma += parseFloat(document.getElementById('smf'+i+'_c'+col).value.replace(/\./g,'').replace(/,/g,'.'));
		}
	}
	return suma;
}

function gridexiste(valor, col){
	if(document.getElementById("smlineagrid").value != '' && document.getElementById("smlineagrid").value != '0'){
		var i;
		for(i=1; i<=document.getElementById("smlineagrid").value; i++){
			if(document.getElementById('smf'+i+'_c'+col).value == valor){
				return i;
			}
		}
		return false;
	}
	return false;
}

function gridvacio(){
	var valor = true, i;
	for(i=1; i<=document.getElementById("smlineagrid").value; i++){
		if(document.getElementById('smf'+i+'_c1').value != ''){
			valor = false;
			continue;
		}
	}
	return valor;
}

function asignaParametros(param,cadena) {
	mat = cadena.split(",");	long=mat.length-1;
	for(i=0;i<=long;i++) 
	{	eval('param=param+"&'+mat[i]+'="+trim(document.getElementById("'+mat[i]+'").value);'); 
	}
	return param;
}

function abreventana(prog)
{
	window.open(prog,"","status=0,toolbar=0,scrollbars=1,width=750,height=550");
	
}

function bloquea_pantalla()
{
	document.getElementById("bloquea_pantalla").style.height=document.body.clientHeight;
	document.getElementById("contenido_bloquea_pantalla").style.top=((document.body.clientHeight/2)-75);
	document.getElementById('contenido_bloquea_pantalla').style.left=((document.body.clientWidth/2)-100);
	document.getElementById("vmesnsaje_bloquea_pantalla").innerHTML="";
	document.getElementById("bloquea_pantalla").style.display=""; 
	document.getElementById("contenido_bloquea_pantalla").style.display=""; 

	var navegador = navigator.appName;
	if (navegador == "Microsoft Internet Explorer")
	{
		document.getElementById('bloquea_pantalla').style.width= document.body.clientWidth;	// ie only
		document.getElementById('bloquea_pantalla').style.top="110px";	// ie only
	}
}

function desbloquea_pantalla()
{
	document.getElementById("vmesnsaje_bloquea_pantalla").innerHTML="";
	document.getElementById("bloquea_pantalla").style.display="none"; 
	document.getElementById("contenido_bloquea_pantalla").style.display="none"; 
}
	
function esObjeto(obj) { 
	if (document.getElementById(obj)){
		return true;
	} else {
		return false;
	}
}