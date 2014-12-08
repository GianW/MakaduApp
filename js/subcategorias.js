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
 
function buscarSubCategoria(idcategoria,idproduto){
	if(objAjax() != null) {
		var url="produtos_ajax_sub.php"
		url=url+"?idcategoria="+idcategoria+"&idproduto="+idproduto;

		xmlhttp.onreadystatechange = function() {
				  if(xmlhttp.readyState == 4 ) {
						if(xmlhttp.responseText){
							document.getElementById("assubcategorias").innerHTML = xmlhttp.responseText;
							//alert(document.getElementById("ascidades").innerHTML);
						}
				  }
			  }
		xmlhttp.open("GET",url,true)
		xmlhttp.send(null)
  	}
}

//---------