<?php
//BUSCA------------------------------------------
if($limpado == 'ok'){
	$buscaPaginas = array('');
	$_SESSION['SESSAOBUSCA'] = $buscaPaginas;
}

if(!empty($_SESSION['SESSAOBUSCA']) && sizeof($_SESSION['SESSAOBUSCA']) > 0){
	if($disparabusca == 'ok'){	
		$buscaPaginas = array($buscatitulo,			//TITULO [0]
							  $buscalocal,			//LOCAL [1]
							  $buscadescricao,		//DESCRIÇÃO [2]
							  $buscasobre,			//SOBRE O PALESTRANTE [3]
							  $buscapalestrante,	//NOME DO PALESTRANTE [4]
							  $buscadata,			//DATA [5]
							  $buscahorainicio,		//HORA DE INÍCIO [6]
							  $buscahorafim,		//HORA DO FIM [7]
							  $buscaperguntas,		//ACEITA PERGUNTAS [8]
							  $buscamaterial,		//TEM ARQUIVO DO MATERIAL [9]
							  $ordenar,				//ORDENADO POR [10]
							  $ordem,				//ORDEM [11]
							  '1');					//PAGINA [12]
		$_SESSION['SESSAOBUSCA'] = $buscaPaginas;	
	}else{
		$buscatitulo		= $_SESSION['SESSAOBUSCA'][0];
		$buscalocal			= $_SESSION['SESSAOBUSCA'][1];
		$buscadescricao		= $_SESSION['SESSAOBUSCA'][2];
		$buscasobre			= $_SESSION['SESSAOBUSCA'][3];
		$buscapalestrante	= $_SESSION['SESSAOBUSCA'][4];
		$buscadata			= $_SESSION['SESSAOBUSCA'][5];
		$buscahorainicio	= $_SESSION['SESSAOBUSCA'][6];
		$buscahorafim		= $_SESSION['SESSAOBUSCA'][7];	
		$buscaperguntas		= $_SESSION['SESSAOBUSCA'][8];	
		$buscamaterial		= $_SESSION['SESSAOBUSCA'][9];	
		$ordenar			= $_SESSION['SESSAOBUSCA'][10];
		$ordem				= $_SESSION['SESSAOBUSCA'][11];
		$buscapagina		= $_SESSION['SESSAOBUSCA'][12];
	}
	//FIM DA BUSCA---------------------------------
}else{
	$buscaPaginas = array($buscatitulo,			//TITULO [0]
						  $buscalocal,			//LOCAL [1]
						  $buscadescricao,		//DESCRIÇÃO [2]
						  $buscasobre,			//SOBRE O PALESTRANTE [3]
						  $buscapalestrante,	//NOME DO PALESTRANTE [4]
						  $buscadata,			//DATA [5]
						  $buscahorainicio,		//HORA DE INÍCIO [6]
						  $buscahorafim,		//HORA DO FIM [7]
						  $buscaperguntas,		//ACEITA PERGUNTAS [8]
						  $buscamaterial,		//TEM ARQUIVO DO MATERIAL [9]
						  $ordenar,				//ORDENADO POR [10]
						  $ordem,				//ORDEM [11]
						  '1');					//PAGINA [12]
	$_SESSION['SESSAOBUSCA'] = $buscaPaginas;		
}

//FORMATANDO DATA
$buscadata = explode('/',$buscadata);
$dia = $buscadata[0];
$mes = $buscadata[1];
$ano = $buscadata[2];

$currentFile = $_SERVER["SCRIPT_NAME"];
$partes = Explode('/', $currentFile);
$currentFile = $partes[count($partes) - 1];

//QUERY----------------------------------------
$sql = "SELECT *, p.idprogramacao AS idprog, p.ativo AS ativoprog FROM programacao p
		LEFT JOIN relprogpal rpp
		ON rpp.idprogramacao = p.idprogramacao
		LEFT JOIN login l
		ON l.id = rpp.idpalestrante
		WHERE p.titulo <> ''
		AND p.idevento = '$idevento' ";

//DATA
if(isset($dia) && $dia != ''){
	$sql .= "AND p.dataprograma = '$ano-$mes-$dia' ";
}

//TITULO
if(isset($buscatitulo) && $buscatitulo != ''){
	$nomeArray = explode(' ', $buscatitulo);
	for($i = 0; $i < sizeof($nomeArray); $i++){
		$sql .= "AND p.titulo COLLATE latin1_swedish_ci LIKE '%$nomeArray[$i]%' ";
	}
}

//LOCAL
if(isset($buscalocal) && $buscalocal != ''){
	$localArray = explode(' ', $buscalocal);
	for($i = 0; $i < sizeof($localArray); $i++){
		$sql .= "AND p.localprograma COLLATE latin1_swedish_ci LIKE '%$localArray[$i]%' ";
	}
}

//SOBRE PALESTRANTE
if(isset($buscasobre) && $buscasobre != ''){
	$sobreArray = explode(' ', $buscasobre);
	for($i = 0; $i < sizeof($sobreArray); $i++){
		$sql .= "AND p.sobrepalestrante COLLATE latin1_swedish_ci LIKE '%$sobreArray[$i]%' ";
	}
}

//DESCRIÇÃO
if(isset($buscadescricao) && $buscadescricao != ''){
	$descricaoArray = explode(' ', $buscadescricao);
	for($i = 0; $i < sizeof($descricaoArray); $i++){
		$sql .= "AND p.descricao COLLATE latin1_swedish_ci LIKE '%$descricaoArray[$i]%' ";
	}
}

//HORA DE INICIO
if(isset($buscahorainicio) && $buscahorainicio != ''){
	$sql .= "AND p.horainicio = '$buscahorainicio:00' ";
}

//FORA DO FIM
if(isset($buscahorafim) && $buscahorafim != ''){
	$sql .= "AND p.horafim = '$buscahorafim:00' ";
}

//ACEITA PERGUNTAS
if(isset($buscaperguntas) && $buscaperguntas == '1'){
	$sql .= "AND p.perguntas = '1' ";
}

//MATERIAL
if(isset($buscamaterial) && $buscamaterial == '1'){
	$sql .= "AND p.material <> '' ";
}

//PALESTRANTES
if(isset($buscapalestrante) && $buscapalestrante != ''){
	$palestranteArray = explode(' ', $buscapalestrante);
	for($i = 0; $i < sizeof($palestranteArray); $i++){
		$sql .= "AND l.nome COLLATE latin1_swedish_ci LIKE '%$palestranteArray[$i]%' ";
	}
}

//ORDEM
if(empty($ordenar) || $ordenar == '-' || $ordem == ''){
	$ordenar = "dataprograma, horainicio";
}
if(empty($ordem) || $ordem == '-' || $ordem == ''){
	$ordem = "ASC";
}
$sql.= "GROUP BY p.idprogramacao ORDER BY $ordenar $ordem ";

?>