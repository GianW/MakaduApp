<?php
//BUSCA------------------------------------------
if($limpado == 'ok'){
	$buscaPaginas = array('');
	$_SESSION['SESSAOBUSCA'] = $buscaPaginas;
}

if(!empty($_SESSION['SESSAOBUSCA']) && sizeof($_SESSION['SESSAOBUSCA']) > 0){
	if($disparabusca == 'ok'){	
		$buscaPaginas = array($bascaaviso,			//AVISO [0]
							  $buscadetalhes,		//DETALHES [1]
							  $buscahora,			//HORA [2]
							  $buscadata,			//DATA DE CADASTRO [3]
							  $buscadataate,		//DATA DE CADASTTRO ATÉ [4]
							  $ordenar,				//ORDENADO POR [5]
							  $ordem,				//ORDEM [6]
							  '1');					//PAGINA [7]
		$_SESSION['SESSAOBUSCA'] = $buscaPaginas;	
	}else{
		$bascaaviso			= $_SESSION['SESSAOBUSCA'][0];
		$buscadetalhes		= $_SESSION['SESSAOBUSCA'][1];
		$buscahora			= $_SESSION['SESSAOBUSCA'][2];
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
	$buscaPaginas = array($bascaaviso,			//AVISO [0]
						  $buscadetalhes,		//DETALHES [1]
						  $buscahora,			//HORA [2]
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
$sql = "SELECT * FROM avisos 
		WHERE aviso <> ''
		AND idevento = '$idevento' ";

//DATA CADASTRO
if($dataaviso != 'Array' || $dataaviso != ''){
	if(!empty($dia3) && !empty($mes3) && !empty($ano3) && !empty($dia4) && !empty($mes4) && !empty($ano4) ) {
		$sql.= " AND (dataaviso BETWEEN '$ano3-$mes3-$dia3' AND '$ano4-$mes4-$dia4') ";	
	} else if (!empty($dia3) || !empty($dia4) && !empty($mes3) || !empty($mes4) && !empty($ano4) || !empty($ano4) ) {
		if( empty($dia3) && !empty($dia4) ) {		
			$dia3 = $dia4;
		}
		if( empty($mes3) && !empty($mes4) ) {		
			$mes3 = $mes4;
		}
		if( empty($ano3) && !empty($ano4) ) {		
			$ano3 = $ano4;
		}
		
		if(!empty($ano3) && !empty($ano4)) {		
			$sql.= " AND YEAR(dataaviso) BETWEEN '$ano3' AND '$ano4' ";	
		
		} else if (!empty($dia3) && !empty($mes3) && !empty($dia4) && !empty($mes4)) {	
			$sql.= " AND (EXTRACT(MONTH From dataaviso) + (EXTRACT(DAY From dataaviso) / 100.00)) 
								BETWEEN ($mes3 + ($dia3 / 100.00)) AND ($mes4 + ($dia4 / 100.00)) ";								
		} else if(!empty($dia3) && empty($mes3) && empty($ano3)) {
			$sql.= " AND (DAY(dataaviso) = '$dia3' ) ";
			
		} else if(empty($dia3) && !empty($mes3) && empty($ano3)) {
			$sql.= " AND (MONTH(dataaviso) = '$mes3' ) ";
			
		} else if(!empty($dia3) && !empty($mes3) && empty($ano3)) {
			$sql.= " AND (EXTRACT(MONTH From dataaviso) + (EXTRACT(DAY From dataaviso) / 100.00)) 
								= ($mes3 + ($dia3 / 100.00)) ";
		} else if(empty($dia3) && !empty($mes3) && !empty($ano3)) {	
			$sql.= " AND (EXTRACT(YEAR From dataaviso) + (EXTRACT(MONTH From dataaviso) / 100.00)) 
							= ($ano3 + ($mes3 / 100.00)) ";
		} else if(!empty($dia3) && !empty($mes3) && !empty($ano3)) {
			$sql.= " AND (dataaviso = '$ano3-$mes3-$dia3' ) ";		
		} 
	} else if(!empty($dia3) && !empty($dia4)) {
		$sql.= " AND DAY(dataaviso) BETWEEN '$dia3' AND '$dia4' ";
	} else if(!empty($mes3) && !empty($mes4)) {
		$sql.= " AND MONTH(dataaviso) BETWEEN '$mes3' AND '$mes4' ";	
	} else if (!empty($mes3) || !empty($mes4)) {
		if( empty($mes3) && !empty($mes4) ) {		
			$mes3 = $mes4;
		}
		$sql.= " AND (MONTH(dataaviso) = '$mes3' ) ";
	} else if (!empty($ano3) || !empty($ano4)) {
		if( empty($ano3) && !empty($ano4) ) {		
			$ano3 = $ano4;
		}
		$sql.= " AND (YEAR(dataaviso) = '$ano3' ) ";
	}
}
	
//AVISO
if(isset($bascaaviso) && $bascaaviso != ''){
	$avisoArray = explode(' ', $bascaaviso);
	for($i = 0; $i < sizeof($avisoArray); $i++){
		$sql .= "AND aviso COLLATE latin1_swedish_ci LIKE '%$avisoArray[$i]%' ";
	}
}

//DETALHES
if(isset($buscadetalhes) && $buscadetalhes != ''){
	$detalhesArray = explode(' ', $buscadetalhes);
	for($i = 0; $i < sizeof($detalhesArray); $i++){
		$sql .= "AND detalhes COLLATE latin1_swedish_ci LIKE '%$detalhesArray[$i]%' ";
	}
}

//ORDEM
if(empty($ordenar) || $ordenar == '-' || $ordem == ''){
	$ordenar = "dataaviso";
}
if(empty($ordem) || $ordem == '-' || $ordem == ''){
	$ordem = "DESC";
}
$sql.= "ORDER BY $ordenar $ordem ";

?>