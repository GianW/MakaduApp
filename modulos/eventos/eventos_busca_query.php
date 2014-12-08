<?php
//BUSCA------------------------------------------
if($limpado == 'ok'){
	$buscaPaginas = array('');
	$_SESSION['SESSAOBUSCA'] = $buscaPaginas;
}

if(!empty($_SESSION['SESSAOBUSCA']) && sizeof($_SESSION['SESSAOBUSCA']) > 0){
	if($disparabusca == 'ok'){	
		$buscaPaginas = array($buscanome,			//NOME [0]
							  $buscalocal,			//EMAIL [1]
							  $buscarelease,		//PALESTRANTE [2]
							  $buscadata,			//DATA DE CADASTRO [3]
							  $buscadataate,		//DATA DE CADASTTRO ATÉ [4]
							  $ordenar,				//ORDENADO POR [5]
							  $ordem,				//ORDEM [6]
							  '1');					//PAGINA [7]
		$_SESSION['SESSAOBUSCA'] = $buscaPaginas;	
	}else{
		$buscanome			= $_SESSION['SESSAOBUSCA'][0];
		$buscalocal			= $_SESSION['SESSAOBUSCA'][1];
		$buscarelease		= $_SESSION['SESSAOBUSCA'][2];
		$buscadata			= $_SESSION['SESSAOBUSCA'][3];
		$buscadataate		= $_SESSION['SESSAOBUSCA'][4];	
		$ordenar			= $_SESSION['SESSAOBUSCA'][5];
		$ordem				= $_SESSION['SESSAOBUSCA'][6];
		$buscapagina		= $_SESSION['SESSAOBUSCA'][7];
	}

	//FORMATANDO DATA DE CADASTRO
	$buscadata = explode('/',$buscadata);
	$dia3 = $buscadata[0];
	$mes3 = $buscadata[1];
	$ano3 = $buscadata[2];
	//FORMATANDO DATA DE CADASTRO ATÉ	
	$buscadataate = explode('/',$buscadataate);
	$dia4 = $buscadataate[0];
	$mes4 = $buscadataate[1];
	$ano4 = $buscadataate[2];
	//FIM DA BUSCA---------------------------------
}else{
	$buscaPaginas = array($buscanome,			//NOME [0]
						  $buscalocal,			//EMAIL [1]
						  $buscarelease,		//PALESTRANTE [2]
						  $buscadata,			//DATA DE CADASTRO [3]
						  $buscadataate,		//DATA DE CADASTTRO ATÉ [4]
						  $ordenar,				//ORDENADO POR [5]
						  $ordem,				//ORDEM [6]
						  '1');					//PAGINA [7]
	$_SESSION['SESSAOBUSCA'] = $buscaPaginas;		
}

$currentFile = $_SERVER["SCRIPT_NAME"];
$partes = Explode('/', $currentFile);
$currentFile = $partes[count($partes) - 1];

//QUERY----------------------------------------
$sql = "SELECT * FROM eventos 
		WHERE nomeevento <> '' ";

//DATA INICIO
if(isset($dia3) && $dia3 != ''){
	$sql .= "AND datainicio = '$ano3-$mes3-$dia3' ";
}

//DATA FIM
if(isset($dia4) && $dia4 != ''){
	$sql .= "AND datafim = '$ano4-$mes4-$dia4' ";
}

//NOME
if(isset($buscanome) && $buscanome != ''){
	$nomeArray = explode(' ', $buscanome);
	for($i = 0; $i < sizeof($nomeArray); $i++){
		$sql .= "AND nomeevento COLLATE latin1_swedish_ci LIKE '%$nomeArray[$i]%' ";
	}
}

//LOCAL
if(isset($buscalocal) && $buscalocal != ''){
	$localArray = explode(' ', $buscalocal);
	for($i = 0; $i < sizeof($localArray); $i++){
		$sql .= "AND local COLLATE latin1_swedish_ci LIKE '%$localArray[$i]%' ";
	}
}

//RELEASE
if(isset($buscarelease) && $buscarelease != ''){
	$releaseArray = explode(' ', $buscarelease);
	for($i = 0; $i < sizeof($releaseArray); $i++){
		$sql .= "AND texto COLLATE latin1_swedish_ci LIKE '%$releaseArray[$i]%' ";
	}
}

//ORDEM
if(empty($ordenar) || $ordenar == '-' || $ordem == ''){
	$ordenar = "data";
}
if(empty($ordem) || $ordem == '-' || $ordem == ''){
	$ordem = "DESC";
}
$sql.= "ORDER BY $ordenar $ordem ";

?>