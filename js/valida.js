//USO:
/*<script src="js/valida.js" language="javascript"></script>*/
//<form action="{action}" method="post" enctype="multipart/form-data" name="form1" onSubmit="return checkCampos(this,'pagina');">

function checkCampos(frm,pagina){
	var msgAlert = "Complete os seguintes campos:\n\n";
	var msg = msgAlert.length;
	
	switch(pagina){
		case "usuarios":
			var nomedocampo = Array("nome");
			var descricao   = Array("Nome");		
		break;	
		case "newsletter":
			var nomedocampo = Array("titulo");
			var descricao   = Array("Título");		
		break;
		case "adminstradores":
			var nomedocampo = Array("nomeadm", "login", "senha", "nivel");
			var descricao   = Array("Nome", "Login", "Senha", "Nível");		
		break;	
		case "municipio":
			var nomedocampo = Array("municipio");
			var descricao   = Array("Município");		
		break;	
		case "aniversario":
			var nomedocampo = Array("titulo");
			var descricao   = Array("Título");		
		break;	
		case "coord":
			var nomedocampo = Array("coordenadoria");
			var descricao   = Array("Coordenadoria");		
		break;
		case "funcoes":
			var nomedocampo = Array("funcao");
			var descricao   = Array("Nome da função partidária");		
		break;	
		case "gruposnews":
			var nomedocampo = Array("grupo");
			var descricao   = Array("Nome do grupo");		
		break;														
		//OUTROS-------------------------------------------------
		case "publicacoes":
			var nomedocampo = Array("titulo");
			var descricao   = Array("Título");		
		break;			
		case "produtos":
			var nomedocampo = Array("titulo", "secao");
			var descricao   = Array("Título", "Seção");		
		break;		
		case "contato":
			var nomedocampo = Array("nome", "email", "assunto", "mensagem");
			var descricao   = Array("Nome", "E-mail", "Assunto", "Mensagem");		
		break;	
		case "esqueci":
			var nomedocampo = Array("email");
			var descricao   = Array("E-mail");		
		break;	
		case "enquete":
			var nomedocampo = Array("titulo");
			var descricao   = Array("Título");		
		break;	
		case "cadastro":
			var nomedocampo = Array("nome", "rg", "nascimento", "cpf", "email", "sexo", "senha", "cidade", "estado", "endereco", "numero", "cep");
			var descricao   = Array("Nome", "RG", "Data de nascimento", "CPF", "E-mail", "Sexo", "Senha", "Cidade", "Estado", "Endereço", "Número", "CEP");		
		break;
		case "login":
			var nomedocampo = Array("email", "senha");
			var descricao   = Array("E-mail", "Senha");		
		break;		
	}

	for (var i = 0; i < nomedocampo.length; i++){
		var objetos = frm.elements[nomedocampo[i]];
		if (objetos){
			switch(objetos.type){
				case "select-one":
					if (objetos.selectedIndex == -1 || 
						objetos.options[objetos.selectedIndex].text == "" ||
						objetos.options[objetos.selectedIndex].text == "%" ||
						objetos.options[objetos.selectedIndex].text == "-"){
						msgAlert += " - " + descricao[i] + "\n";
					}
					break;
				case "password":
						if(frm.senha.value == ""){
							msgAlert += " - " + "Senha" + "\n";	
						}
/*						if(frm.senha.value != frm.senha2.value){
							msgAlert += " - " + "Senhas diferentes" + "\n";
						}
						if(frm.senha2.value == ""){
							msgAlert += " - " + "Confirmação da senha" + "\n";	
						}*/
					break;					
				case "select-multiple":
					if (objetos.selectedIndex == -1){
						msgAlert += " - " + descricao[i] + "\n";
					}
					break;
				case "file":
					if (objetos.value == "" || objetos.value == null){
						msgAlert += " - " + descricao[i] + "\n";
					}
				break;	
				case "text":
					if(objetos.name == "site"){
						if(frm.site.value == "http://"){
							msgAlert += " > " + "Digite o site corretamente" + "\n";	
						}
					}
					
					if(objetos.name == "email"){
						if(objetos.value != ""){
							if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(objetos.value))){
								msgAlert += " > " + "Email inválido" + "\n";	
							}
						}
					}
				case "textarea":
					if (objetos.value == "" || objetos.value == null){
						msgAlert += " - " + descricao[i] + "\n";
					}
					break;
				default:
			}
			
			if (objetos.type == undefined){
				var blnchecked = false;
				for (var j = 0; j < objetos.length; j++){
					if (objetos[j].checked){
						blnchecked = true;
					}
				}
				if (!blnchecked){
					msgAlert += " - " + descricao[i] + "\n";
				}
			}
		}
	}
/*	if(fck=='true'){
		var EditorInstance = FCKeditorAPI.GetInstance('descricao'); 
		if(EditorInstance.EditorDocument.body.innerText.length<=0){
			msgAlert += " - Descrição\n";
		}
	}*/

	if (msgAlert.length == msg){
		return true;
	}else{
		alert(msgAlert);
		return false;
	}
} 