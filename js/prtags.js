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
 
function buscarTags(){
	if(objAjax() != null) {
		var url="prod_ajax_select.php"
		
		xmlhttp.onreadystatechange = function() {
				  if(xmlhttp.readyState == 4 ) {
						if(xmlhttp.responseText){
							//alert('resultados: ' + xmlhttp.responseText);
							jQuery('#successo').html(xmlhttp.responseText);
							//document.getElementById("sucesso").innerHTML = xmlhttp.responseText;
						}
				  }
			  }
		xmlhttp.open("GET",url,true)
		xmlhttp.send(null)
  	}
}