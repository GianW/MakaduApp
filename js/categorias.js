var xmlhttp;
function objAjax()
{
	try {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
	catch(e) {
	    try {
	    	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	    }
	    catch(ex) {
		      try {
		    	  xmlhttp = new XMLHttpRequest();
		      }
		      catch(exc) {
		      	alert("Esse browser não tem recursos para uso do Ajax");
		      	xmlhttp = null;
		      }
	    }
	}
	return xmlhttp;
}

var xmlhttpTipo;
function objAjaxTipo()
{
	try {
		xmlhttpTipo = new ActiveXObject("Microsoft.XMLHTTP");
    }
	catch(e) {
	    try {
			xmlhttpTipo = new ActiveXObject("Msxml2.XMLHTTP");
	    }
	    catch(ex) {
		      try {
				  xmlhttpTipo = new XMLHttpRequest();
		      }
		      catch(exc) {
		      	alert("Esse browser não tem recursos para uso do Ajax");
				xmlhttpTipo = null;
		      }
	    }
	}
	return xmlhttpTipo;
}
 
function buscarCategoria(idsecao,tipo){
	if(objAjax() != null) {
		var url="produtos_ajax_cat.php"
		url=url+"?idsecao="+idsecao;
		url=url+"&tipo="+tipo;

		xmlhttp.onreadystatechange = function() {
				  if(xmlhttp.readyState == 4 ) {
						if(xmlhttp.responseText){
							if(document.getElementById("ascategorias")){
								document.getElementById("ascategorias").innerHTML = xmlhttp.responseText;
							}
							if(document.getElementById("assubcategorias")){
								document.getElementById("assubcategorias").innerHTML = 'Escolha a Categoria';
							}
							//alert(document.getElementById("ascidades").innerHTML);
						}
				  }
			  }
		xmlhttp.open("GET",url,true)
		xmlhttp.send(null)
  	}
	
	if(objAjaxTipo() != null) {
		var url="produtos_ajax_tipo.php"
		url=url+"?idsecao="+idsecao;
		url=url+"&tipo="+tipo;

		xmlhttpTipo.onreadystatechange = function() {
				  if(xmlhttpTipo.readyState == 4 ) {
						if(xmlhttpTipo.responseText){
							if(xmlhttpTipo.responseText == '1'){
								document.getElementById("ostipos").style.display = 'block';
							}else{
								document.getElementById("ostipos").style.display = 'none';	
							}
						}
				  }
			  }
		xmlhttpTipo.open("GET",url,true)
		xmlhttpTipo.send(null)
	}
}

//---------