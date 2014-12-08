<?php

	//----------------------------------------------------------------------------------
	//CONFIGURAÇOES GERAIS--------------------------------------------------------------
	header('Cache-Control: no-cache');
  	header('Pragma: no-cache');
	ini_set('session.gc_maxlifetime', 30*60);	
	
	if ( !isset( $_SERVER ) ) {
    $_SERVER = $HTTP_SERVER_VARS;
	}
	if ( !isset( $_GET ) ) {
		$_GET = $HTTP_GET_VARS;
	}
	if ( !isset( $_FILES ) ) {
		$_FILES = $HTTP_POST_FILES;
		global $_FILES;
	}
	
	//CONFIGURAÇÕES DO SITE-------------------------------------------------------------
	$URLsite = 'http://www.flame.com.br/crm/'; //IMPORTANTE! URL do site, com / ao final
	$Nomesite = utf8_decode('José Silva - 99991'); //Nome (titulo) do site
	$emailCont = 'eduardo@flame.com.br'; //E-mail para onde vão os contatos do site
	$emailCad = 'eduardo@flame.com.br'; //E-mail para onde vão os cadastros da newsletter
	$dados1 = 'Av. Azenha 1495 - 301 - Azenha'; //Dados de endereço: Rua, numero, complemento, bairro
	$dados2 = '90220-210 - Porto Alegre - RS'; //Dados de endereço: CEP, cidade, estado
	$dados3 = '(51) 3333.3333 - contato@flame.com.br'; //Fones, email
	
	$ctFacebook = 'pages/Fredrik-Reinfeldt/314249689102'; //Conta da fan page do Facebook (em braco se não aplicável)
	$ctTwitter = 'realwbonner'; //Conta do Twitter (em braco se não aplicável)
	$ctGoogle = 'https://plus.google.com/109123466096880592981/posts'; //Conta do Google+ (em braco se não aplicável)
	$ctOrkut = 'http://www.orkut.com/Main#Community?cmm=39336986&hl=en-GB'; //Conta do Orkut (em braco se não aplicável)
	$ctYoutube = 'jnse78'; //Conta do canal do Youtube (em braco se não aplicável)
	$ctFlickr = ''; //Conta do Flickr (em braco se não aplicável)
	$ctLinkedin = ''; //Conta do Linkedin (em braco se não aplicável)
	$ctTumblr = ''; //Conta do Tumblr (em braco se não aplicável)
	$ctBlogger = ''; //Conta do Blogger (em braco se não aplicável)
	$ctWordpress = ''; //Conta do Wordpress (em braco se não aplicável)
	$ctMyspace = ''; //Conta do Myspace (em braco se não aplicável)
	
	$tipo_inicial = 'n'; //o tipo que irá aparecer logo após o login
	$imgFCKL = 500; //largura máxima das imagens no FCK
	$imgFCKA = 1800; //altura máxima das imagens no FCK
	$integraDestaque = false; //integra contagem de destaques em todos os tipos de publicacoes
	$integraCapa = false; //integra contagem de capas em todos os tipos de publicacoes
	
	//O CODIGO A SEGUIR DEVE SER LIBERADO CASO AS VARIAVEIS NÃO PASSEM DE UMA PAGINA A OUTRA
/*	$colecoes=array('_POST','_GET','_SESSION','_FILES');
	for($x=0;$x<sizeof($colecoes);$x++){
		if(isset($$colecoes[$x])){
			reset($$colecoes[$x]);
			while (list($chave, $valor) = each ($$colecoes[$x])) {
			   $$chave=$valor;
			}
		}
	}*/

	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------


	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//TIPO NOTICIAS
	if($tipo == 'n'){
		$nomesecao = utf8_decode('Notícias'); //o nome da seção
		
		$modelo = 'publicacoes';
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'publicacoes'; //tabela do tipo
		
		$pub_ordem = false; //ativa ordem (drag and drop) das publicações
		$pub_categorias = true; //ativa uso de categorias da publicação
		$pub_destaque = true; //ativa uso de destaque da publicação
		$qtd_destaque = 5; //quantidade de destaques. Máximo de 2
		$pub_capa = true; //ativa uso de capas da publicação
		$qtd_capa = 2; //quantidade de capas. Máximo de 3
		$pub_galeria = true; //ativa uso de galerias da publicação
		$qtd_destaquefotos = 1; //quantidade de fotos destaques
		$pub_video = true; //ativa uso de videos da publicação
		$qtd_destaquevideo = 1; //quantidade de vídeos destaques
		$pub_comentarios = true; //ativa uso de comentários da publicação
		$pub_relacionadas = true; //ativa uso de notícias relacionadas à publicação
		$pub_nome_dest = 'Destaque'; //Nome da coluna destaque na lista de publicações
		$pub_nome_capa = 'Capa'; //Nome da coluna capa na lista de publicações
				
		$limite_paginacao = 20; //limite de resultados por pagina
		
		if($pub_ordem == true){
			$sort = 'ORDER BY IF(ordem = NULL, id, ordem)'; //ordem da busca SQL conforme ordem
		}else{
			$sort = 'ORDER BY data DESC, id DESC'; //ordem da busca SQL normal
		}
		
		$usa_permalink = true;  //ativa uso de permalink no site. OBS: requer permissão 777 na pasta desejada.
		$pagina_perm = 'publicacoes.php'; //pagina do site modelo para uso do permalink
		
		$usa_crop = true; //ativa uso de crop de foto de capa da publicação
		$crop_width = '509'; //largura inicial do crop
		$crop_height = '284'; //altura inicial do crop
		$crop_ratio = $crop_width / $crop_height; //ratio do crop
		$usa_hd = true; //ativa uso de upload de imagem sem perda de qualidade (HD) -> somente para álbuns

		$imgPL = 120; $imgPA = 90; //tamanho da imagem p
		$imgML = 300; $imgMA = 290; //tamanho da imagem m
		$imgGL = 400; $imgGA = 390; //tamanho da imagem g
		$imgGGL = 700; $imgGGA = 900; //tamanho da imagem gg
					
		if($pub_categorias == true){
			$uni_cat = true; //ativa categoria unica
			$multi_cat = false; //ativa categorias múltiplas
		}

		$foto_capa = true; //ativa foto de capa da publicação
		$foto_cred = true; //ativa créditos da foto de capa (caso foto_capa = true)
		$foto_int = true; //ativa foto interna de publicação
		$foto_credint = true; //ativa créditos da foto interna (caso foto_int = true)
		$foto_leg = true; //ativa legenda da foto interna (caso foto_int = true)
		$check_video = true; //ativa video principal da publicacao
		$check_autor = true; //ativa campo de autor
		$check_tags = true; //ativa uso de tags
		$check_upload = false; //ativa upload de arquivo (somente 1 arquivo)
		$check_link = false; //ativa link (somente 1 link)
		$check_resumo = true; //ativa textbox de resumo
		$check_FCK = true; //ativa FCK Editor
		$check_estatisticas = true; //ativa estatísticas da publicação
	}
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------
	


	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//TIPO NOTICIAS
	if($tipo == 'ar'){
		$nomesecao = utf8_decode('Artigos'); //o nome da seção
		
		$modelo = 'publicacoes';
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'publicacoes'; //tabela do tipo
		
		$pub_ordem = false; //ativa ordem (drag and drop) das publicações
		$pub_categorias = false; //ativa uso de categorias da publicação
		$pub_destaque = false; //ativa uso de destaque da publicação
		$qtd_destaque = 1; //quantidade de destaques. Máximo de 2
		$pub_capa = false; //ativa uso de capas da publicação
		$qtd_capa = 3; //quantidade de capas. Máximo de 3
		$pub_galeria = false; //ativa uso de galerias da publicação
		$qtd_destaquefotos = 1; //quantidade de fotos destaques
		$pub_video = false; //ativa uso de videos da publicação
		$qtd_destaquevideo = 1; //quantidade de vídeos destaques
		$pub_comentarios = true; //ativa uso de comentários da publicação
		$pub_relacionadas = true; //ativa uso de notícias relacionadas à publicação
		$pub_nome_dest = 'Destaque'; //Nome da coluna destaque na lista de publicações
		$pub_nome_capa = 'Capa'; //Nome da coluna capa na lista de publicações
				
		$limite_paginacao = 20; //limite de resultados por pagina
		
		if($pub_ordem == true){
			$sort = 'ORDER BY IF(ordem = NULL, id, ordem)'; //ordem da busca SQL conforme ordem
		}else{
			$sort = 'ORDER BY data DESC, id DESC'; //ordem da busca SQL normal
		}
		
		$usa_permalink = true;  //ativa uso de permalink no site. OBS: requer permissão 777 na pasta desejada.
		$pagina_perm = 'publicacoes.php'; //pagina do site modelo para uso do permalink
		
		$usa_crop = true; //ativa uso de crop de foto de capa da publicação
		$crop_width = '509'; //largura inicial do crop
		$crop_height = '284'; //altura inicial do crop
		$crop_ratio = $crop_width / $crop_height; //ratio do crop
		$usa_hd = true; //ativa uso de upload de imagem sem perda de qualidade (HD) -> somente para álbuns

		$imgPL = 120; $imgPA = 90; //tamanho da imagem p
		$imgML = 300; $imgMA = 290; //tamanho da imagem m
		$imgGL = 400; $imgGA = 390; //tamanho da imagem g
		$imgGGL = 700; $imgGGA = 900; //tamanho da imagem gg
					
		if($pub_categorias == true){
			$uni_cat = true; //ativa categoria unica
			$multi_cat = false; //ativa categorias múltiplas
		}

		$foto_capa = false; //ativa foto de capa da publicação
		$foto_cred = false; //ativa créditos da foto de capa (caso foto_capa = true)
		$foto_int = true; //ativa foto interna de publicação
		$foto_credint = true; //ativa créditos da foto interna (caso foto_int = true)
		$foto_leg = true; //ativa legenda da foto interna (caso foto_int = true)
		$check_video = false; //ativa video principal da publicacao
		$check_autor = true; //ativa campo de autor
		$check_tags = false; //ativa uso de tags
		$check_upload = false; //ativa upload de arquivo (somente 1 arquivo)
		$check_link = false; //ativa link (somente 1 link)
		$check_resumo = true; //ativa textbox de resumo
		$check_FCK = true; //ativa FCK Editor
		$check_estatisticas = true; //ativa estatísticas da publicação
	}
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------


	
	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//TIPO GALERIAS
	if($tipo == 'g'){
		$nomesecao = utf8_decode('Galerias de Fotos'); //o nome da seção
		
		$modelo = 'publicacoes';
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'publicacoes'; //tabela do tipo
		
		$pub_ordem = false; //ativa ordem (drag and drop) das publicações
		$pub_categorias = false; //ativa uso de categorias da publicação
		$pub_destaque = true; //ativa uso de destaque da publicação
		$qtd_destaque = 1; //quantidade de destaques. Máximo de 2
		$pub_capa = false; //ativa uso de capas da publicação
		$qtd_capa = 3; //quantidade de capas. Máximo de 3
		$pub_galeria = true; //ativa uso de galerias da publicação
		$qtd_destaquefotos = 1; //quantidade de fotos destaques
		$pub_video = false; //ativa uso de videos da publicação
		$qtd_destaquevideo = 1; //quantidade de vídeos destaques
		$pub_comentarios = false; //ativa uso de comentários da publicação
		$pub_relacionadas = false; //ativa uso de notícias relacionadas à publicação
		$pub_nome_dest = 'Destaque'; //Nome da coluna destaque na lista de publicações
		$pub_nome_capa = 'Capa'; //Nome da coluna capa na lista de publicações
				
		$limite_paginacao = 20; //limite de resultados por pagina
		
		if($pub_ordem == true){
			$sort = 'ORDER BY IF(ordem = NULL, id, ordem)'; //ordem da busca SQL conforme ordem
		}else{
			$sort = 'ORDER BY data DESC, id DESC'; //ordem da busca SQL normal
		}
		
		$usa_permalink = false;  //ativa uso de permalink no site. OBS: requer permissão 777 na pasta desejada.
		$pagina_perm = 'publicacoes.php'; //pagina do site modelo para uso do permalink
		
		$usa_crop = false; //ativa uso de crop de foto de capa da publicação
		$crop_width = '509'; //largura inicial do crop
		$crop_height = '284'; //altura inicial do crop
		$crop_ratio = $crop_width / $crop_height; //ratio do crop
		$usa_hd = true; //ativa uso de upload de imagem sem perda de qualidade (HD) -> somente para álbuns

		$imgPL = 160; $imgPA = 120; //tamanho da imagem p
		$imgML = 300; $imgMA = 290; //tamanho da imagem m
		$imgGL = 400; $imgGA = 390; //tamanho da imagem g
		$imgGGL = 700; $imgGGA = 900; //tamanho da imagem gg
			
		if($pub_categorias == true){
			$uni_cat = true; //ativa categoria unica
			$multi_cat = false; //ativa categorias múltiplas
		}

		$foto_capa = false; //ativa foto de capa da publicação
		$foto_cred = false; //ativa créditos da foto de capa (caso foto_capa = true)
		$foto_int = false; //ativa foto interna de publicação
		$foto_credint = false; //ativa créditos da foto interna (caso foto_int = true)
		$foto_leg = false; //ativa legenda da foto interna (caso foto_int = true)
		$check_autor = false; //ativa campo de autor
		$check_tags = false; //ativa uso de tags
		$check_upload = false; //ativa upload de arquivo (somente 1 arquivo)
		$check_link = false; //ativa link (somente 1 link)
		$check_resumo = false; //ativa textbox de resumo
		$check_FCK = false; //ativa FCK Editor
	}
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------		
	
	
	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//TIPO AGENDA
	if($tipo == 'a'){
		$nomesecao = utf8_decode('Agenda'); //o nome da seção
		
		$modelo = 'agenda';
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'agenda'; //tabela do tipo
			
		$limite_paginacao = 20; //limite de resultados por pagina
			
		$usa_crop = false; //ativa uso de crop de foto de capa da publicação
		$crop_width = '234'; //largura inicial do crop
		$crop_height = '107'; //altura inicial do crop
		$crop_ratio = $crop_width / $crop_height; //ratio do crop		
			
		$agnd_permalink = false;  //ativa uso de permalink no site. OBS: requer permissão 777 na pasta desejada.
		$pagina_perm = 'publicacoes.php'; //pagina do site modelo para uso do permalink
		
		$imgPL = 120; $imgPA = 90; //tamanho da imagem p
		$imgML = 300; $imgMA = 290; //tamanho da imagem m
		$imgGL = 400; $imgGA = 390; //tamanho da imagem g
		$imgGGL = 700; $imgGGA = 900; //tamanho da imagem gg
		$agnd_qtd_destaquefotos = 1; //quantidade de fotos destaques	
		$agnd_impressao = true; //ativa impressao da agenda
		$agnd_galeria = true; //ativa album de fotos do evento
		$agnd_categorias = false; //ativa categorias de eventos
		$check_termino = true; //ativa data de termino do evento
		$check_local = true; //ativa campo de local do evento
		$check_maps = true; //ativa campo de google maps do evento
		$check_hora = true; //ativa campo de horario do evento
		$check_foto = true; //ativa campo de foto do evento
		$check_endereco = true; //ativa campo de endereco do evento
		$check_contato = false; //ativa campo de pessoa de contato do evento
		$check_duracao = false; //ativa campo de duracao do evento
		$check_link = false; //ativa campo de link do evento
		$check_edicao = false; //ativa campo da edicao do evento
		$check_tema = false; //ativa campo de tema do evento
		$check_preco = false; //ativa valor do evento	
		$check_inscricoes = false; //ativa inscricoes do evento	
		$check_palestrante = false; //ativa campod e palestrante do evento				
		$check_obs = false; //ativa textbox de observações do evento
		$check_release = true; //ativa FCK de release do evento		
	}
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------	
		
	
	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//TIPO USUÁRIOS
	if($tipo == 'u'){
		$nomesecao = utf8_decode('Usu&aacute;rios'); //o nome da seção
		
		$modelo = 'usuarios';
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'usuarios'; //tabela do tipo
			
		$limite_paginacao = 30; //limite de resultados por pagina
		
		$usa_grupos = true;
		$usa_senha = true;
		$usa_foto = true;
		$usa_dados = true;
		$usa_endereco = true;
		$usa_telefone = true;
		$usa_profissional = true;
		$usa_internet = true;
		$usa_obs = true;
		$usa_newsletter = true;
	}
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------	
	
	
	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//TIPO LIVRE
	if($tipo == 'bio'){
		$nomesecao = utf8_decode('Biografia'); //o nome da seção
		
		$modelo = 'publicacoes_edit'; //publicacoes, blog, galeria, link, agenda, uploads, usuarios
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'publicacoes'; //tabela do tipo
		
		$usa_permalink = true;  //ativa uso de permalink no site. OBS: requer permissão 777 na pasta desejada.
		$pagina_perm = 'publicacoes.php'; //pagina do site modelo para uso do permalink
		
		$imgPL = 104; $imgPA = 76; //tamanho da imagem p
		$imgML = 300; $imgMA = 290; //tamanho da imagem m
		$imgGL = 400; $imgGA = 390; //tamanho da imagem g
		$imgGGL = 700; $imgGGA = 900; //tamanho da imagem gg
		$foto_int = true; //ativa foto de capa da publicação		
		
		$check_FCK = true; //ativa FCK Editor
	}
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//TIPO ARQUIVOS
	if($tipo == 'd'){
		$nomesecao = utf8_decode('Arquivos para Downloads'); //o nome da seção
		
		$modelo = 'arquivos';
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'arquivos'; //tabela do tipo
			
		$limite_paginacao = 20; //limite de resultados por pagina
	}
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------		
	
	
	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//PRODUTOS--------------------------------------------------------------------------
/*	if($tipo == 'p'){
		$nomesecao = utf8_decode('Produtos'); //o nome da seção
		
		$modelo = 'produtos'; //publicacoes, blog, agenda, uploads, usuarios, produtos
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'produtos'; //tabela do tipo
		
		$prod_ordem = true; //ativa ordem (drag and drop) dos produtos
		$prod_secoes = true; //ativa uso de seções dos produtos
		$prod_categorias = true; //ativa uso de categorias dos produtos
		$prod_subcategorias = true; //ativa uso de subcategorias dos produtos
		$prod_destaque = true; //ativa uso de destaque dos produtos
		$qtd_destaque = 3; //quantidade dos produtos. Máximo de 2
		$prod_capa = true; //ativa uso de capas dos produtos
		$qtd_capa = 3; //quantidade de capas. Máximo de 3
		$prod_galeria = true; //ativa uso de galerias dos produtos
		$prod_video = true; //ativa uso de videos dos produtos
		$prod_tags = true; //ativa uso de tags dos produtos
		$prod_comentarios = true; //ativa uso de comentários dos produtos

		if($prod_secoes == true){
			$sec_foto = true;
			$secPL = 110; $secPA = 110; //tamanho da imagem p
			$secML = 300; $secMA = 250; //tamanho da imagem m		
		}		

		if($prod_categorias == true){
			$cat_foto = true;
			$catPL = 110; $catPA = 110; //tamanho da imagem p
			$catML = 300; $catMA = 250; //tamanho da imagem m		
		}
		
		if($prod_subcategorias == true){
			$subcat_foto = true;
			$subPL = 110; $subPA = 110; //tamanho da imagem p
			$subML = 300; $subMA = 250; //tamanho da imagem m		
		}		
			
		$limite_paginacao = 20; //limite de resultados por pagina
		
		if($prod_ordem == true){
			$sort = 'ORDER BY IF(ordem = NULL, p.idproduto, p.ordem)'; //ordem da busca SQL conforme ordem
		}else{
			$sort = 'ORDER BY p.idsecao, p.nome, p.data DESC, p.idproduto DESC'; //ordem da busca SQL normal
		}
		
		$usa_crop = true; //ativa uso de crop de foto de capa da publicação
		$crop_width = 135; //largura inicial do crop
		$crop_height = 240; //altura inicial do crop
		$crop_ratio = $crop_width / $crop_height; //ratio do crop
		$crop_tam = ''; //tamanho de saida do crop: m, g, gg	

		$imgPL = 135; $imgPA = 240; //tamanho da imagem p
		$imgML = 250; $imgMA = 350; //tamanho da imagem m
		$imgGL = 450; $imgGA = 650; //tamanho da imagem g
		$imgGGL = 700; $imgGGA = 800; //tamanho da imagem gg
		$foto_capa = true; //ativa foto de capa da publicação
		$prod_link = true; //ativa campo de link
		$prod_upload = true; //ativa upload de arquivo (somente 1 arquivo)
		$prod_FCK = true; //ativa FCK Editor
		$prod_obs = true; //ativa Observações
	}*/
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------	
	
	
	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//TIPO FOTOS
/*	if($tipo == 'f'){
		$nomesecao = utf8_decode('Fotos'); //o nome da seção
		
		$modelo = 'fotos';
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'uploads'; //tabela do tipo
			
		$limite_paginacao = 20; //limite de resultados por pagina
		$qtd_destaquefotos = 2; //quantidade de fotos em destaque
		
		$imgPL = 106; $imgPA = 80; //tamanho da imagem p
		$imgML = 245; $imgMA = 161; //tamanho da imagem m
		$imgGL = 511; $imgGA = 286; //tamanho da imagem g
		$imgGGL = 800; $imgGGA = 650; //tamanho da imagem gg		
	}*/
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------		
	
	
	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//TIPO ENQUETE
/*	if($tipo == 'e'){
		$nomesecao = utf8_decode('Enquete'); //o nome da seção
		
		$modelo = 'enquete';
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'enquete'; //tabela do tipo
			
		$limite_paginacao = 20; //limite de resultados por pagina
		$qtddest = 1; //quantidade de destaques
	}*/
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------	
	
	
	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//TIPO REPRESENTANTES
/*	if($tipo == 'r'){
		$nomesecao = utf8_decode('Representantes'); //o nome da seção
		
		$modelo = 'empresas';
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'empresas'; //tabela do tipo		
		$limite_paginacao = 999; //limite de resultados por pagina

		$empPL = 160; $empPA = 94; //tamanho da imagem p
		$empML = 180; $empMA = 130; //tamanho da imagem m
		$empGL = 346; $empGA = 203; //tamanho da imagem g
		$empGGL = 750; $empGGA = 480; //tamanho da imagem gg
	}*/
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//TIPO BLOG
/*	if($tipo == 'b'){
		$nomesecao = utf8_decode('Blog'); //o nome da seção
		
		$modelo = 'publicacoes';
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'publicacoes'; //tabela do tipo
		
		$pub_ordem = true; //ativa ordem (drag and drop) das publicações
		$pub_categorias = true; //ativa uso de categorias da publicação
		$pub_destaque = true; //ativa uso de destaque da publicação
		$qtd_destaque = 1; //quantidade de destaques. Máximo de 2
		$pub_capa = true; //ativa uso de capas da publicação
		$qtd_capa = 3; //quantidade de capas. Máximo de 3
		$pub_galeria = true; //ativa uso de galerias da publicação
		$qtd_destaquefotos = 1; //quantidade de fotos destaques
		$pub_video = true; //ativa uso de videos da publicação
		$qtd_destaquevideo = 1; //quantidade de vídeos destaques
		$pub_comentarios = true; //ativa uso de comentários da publicação
		$pub_relacionadas = true; //ativa uso de notícias relacionadas à publicação
		$pub_nome_dest = 'Destaque'; //Nome da coluna destaque na lista de publicações
		$pub_nome_capa = 'Capa'; //Nome da coluna capa na lista de publicações
				
		$limite_paginacao = 20; //limite de resultados por pagina
		
		if($pub_ordem == true){
			$sort = 'ORDER BY IF(ordem = NULL, id, ordem)'; //ordem da busca SQL conforme ordem
		}else{
			$sort = 'ORDER BY data DESC, id DESC'; //ordem da busca SQL normal
		}
		
		$usa_permalink = true;  //ativa uso de permalink no site. OBS: requer permissão 777 na pasta desejada.
		$pagina_perm = 'publicacoes.php'; //pagina do site modelo para uso do permalink
		
		$usa_crop = true; //ativa uso de crop de foto de capa da publicação
		$crop_width = '509'; //largura inicial do crop
		$crop_height = '284'; //altura inicial do crop
		$crop_ratio = $crop_width / $crop_height; //ratio do crop
		$crop_tam = 'g'; //tamanho de saida do crop: m, g, gg
		$usa_hd = false; //ativa uso de upload de imagem sem perda de qualidade (HD) -> somente para álbuns

		$imgPL = 106; $imgPA = 80; //tamanho da imagem p
		$imgML = 245; $imgMA = 161; //tamanho da imagem m
		$imgGL = 511; $imgGA = 286; //tamanho da imagem g
		$imgGGL = 800; $imgGGA = 650; //tamanho da imagem gg
			
		if($pub_categorias == true){
			$uni_cat = true; //ativa categoria unica
			$multi_cat = false; //ativa categorias múltiplas
		}

		$foto_capa = true; //ativa foto de capa da publicação
		$foto_cred = true; //ativa créditos da foto de capa (caso foto_capa = true)
		$foto_int = true; //ativa foto interna de publicação
		$foto_credint = true; //ativa créditos da foto interna (caso foto_int = true)
		$foto_leg = true; //ativa legenda da foto interna (caso foto_int = true)
		$check_autor = true; //ativa campo de autor
		$check_tags = true; //ativa uso de tags
		$check_upload = true; //ativa upload de arquivo (somente 1 arquivo)
		$check_link = true; //ativa link (somente 1 link)
		$check_resumo = true; //ativa textbox de resumo
		$check_FCK = true; //ativa FCK Editor
	}*/
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------		

	
	//----------------------------------------------------------------------------------
	//NOVO TIPO-------------------------------------------------------------------------
	//TIPO VÍDEOS
	if($tipo == 'v'){
		$nomesecao = utf8_decode('Videos'); //o nome da seção
		
		$modelo = 'videos';
		$permissao = 3; //3: todos, 2: administrador, 1: somente root
		$tabela = 'videos'; //tabela do tipo
			
		$limite_paginacao = 20; //limite de resultados por pagina
		
		$qtd_destaquevideo = 2; //quantidade de videos em destaque
	}
	//----------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------
?>