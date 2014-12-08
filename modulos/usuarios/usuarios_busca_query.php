<?php
//BUSCA------------------------------------------
if($limpado == 'ok'){
	$buscaPaginas = array('');
	$_SESSION['SESSAOBUSCA'] = $buscaPaginas;
}

if(!empty($_SESSION['SESSAOBUSCA']) && sizeof($_SESSION['SESSAOBUSCA']) > 0){
	if($disparabusca == 'ok'){	
		$buscaPaginas = array($buscanome,			//TITULO [0]
							  $buscaemail,			//EMAIL [1]
							  $buscapalestrante,	//SÓ PALESTRANTES [2]
							  $buscaadministrador,	//SÓ ADMINISTRADORES [3]
							  $buscadatacad,		//DATA DE CADASTRO[4]
							  $buscadatacadate,		//DATA DE CADASTRO ATÉ [5]
							  $ordenar,				//ORDENADO POR [6]
							  $ordem,				//ORDEM [7]
							  '1');					//PAGINA [8]
		$_SESSION['SESSAOBUSCA'] = $buscaPaginas;	
	}else{
		$buscanome			= $_SESSION['SESSAOBUSCA'][0];
		$buscaemail			= $_SESSION['SESSAOBUSCA'][1];
		$buscapalestrante	= $_SESSION['SESSAOBUSCA'][2];
		$buscaadministrador	= $_SESSION['SESSAOBUSCA'][3];
		$buscadatacad		= $_SESSION['SESSAOBUSCA'][4];
		$buscadatacadate	= $_SESSION['SESSAOBUSCA'][5];		
		$ordenar			= $_SESSION['SESSAOBUSCA'][6];
		$ordem				= $_SESSION['SESSAOBUSCA'][7];
		$buscapagina		= $_SESSION['SESSAOBUSCA'][8];
	}
	//FIM DA BUSCA---------------------------------
}else{
	$buscaPaginas = array($buscanome,			//TITULO [0]
						  $buscaemail,			//EMAIL [1]
						  $buscapalestrante,	//SÓ PALESTRANTES [2]
						  $buscaadministrador,	//SÓ ADMINISTRADORES [3]
						  $buscadatacad,		//DATA DE CADASTRO[4]
						  $buscadatacadate,		//DATA DE CADASTRO ATÉ [5]
						  $ordenar,				//ORDENADO POR [6]
						  $ordem,				//ORDEM [7]
						  '1');					//PAGINA [8]
	$_SESSION['SESSAOBUSCA'] = $buscaPaginas;		
}

//FORMATANDO DATA DE CADASTRO
$buscadatacad = explode('/',$buscadatacad);
$dia3 = $buscadatacad[0];
$mes3 = $buscadatacad[1];
$ano3 = $buscadatacad[2];
//FORMATANDO DATA DE NASCIMENTO ATÉ	
$buscadatacadate = explode('/',$buscadatacadate);
$dia4 = $buscadatacadate[0];
$mes4 = $buscadatacadate[1];
$ano4 = $buscadatacadate[2];

$currentFile = $_SERVER["SCRIPT_NAME"];
$partes = Explode('/', $currentFile);
$currentFile = $partes[count($partes) - 1];

//QUERY----------------------------------------
$sql = "SELECT * FROM login 
		WHERE nome <> '' ";
		
//DATA CADASTRO
if($data != 'Array' || $data != ''){
	if(!empty($dia3) && !empty($mes3) && !empty($ano3) && !empty($dia4) && !empty($mes4) && !empty($ano4) ) {
		$sql.= " AND (data BETWEEN '$ano3-$mes3-$dia3' AND '$ano4-$mes4-$dia4') ";	
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
			$sql.= " AND YEAR(data) BETWEEN '$ano3' AND '$ano4' ";	
		
		} else if (!empty($dia3) && !empty($mes3) && !empty($dia4) && !empty($mes4)) {	
			$sql.= " AND (EXTRACT(MONTH From data) + (EXTRACT(DAY From data) / 100.00)) 
								BETWEEN ($mes3 + ($dia3 / 100.00)) AND ($mes4 + ($dia4 / 100.00)) ";								
		} else if(!empty($dia3) && empty($mes3) && empty($ano3)) {
			$sql.= " AND (DAY(data) = '$dia3' ) ";
			
		} else if(empty($dia3) && !empty($mes3) && empty($ano3)) {
			$sql.= " AND (MONTH(data) = '$mes3' ) ";
			
		} else if(!empty($dia3) && !empty($mes3) && empty($ano3)) {
			$sql.= " AND (EXTRACT(MONTH From data) + (EXTRACT(DAY From data) / 100.00)) 
								= ($mes3 + ($dia3 / 100.00)) ";
		} else if(empty($dia3) && !empty($mes3) && !empty($ano3)) {	
			$sql.= " AND (EXTRACT(YEAR From data) + (EXTRACT(MONTH From data) / 100.00)) 
							= ($ano3 + ($mes3 / 100.00)) ";
		} else if(!empty($dia3) && !empty($mes3) && !empty($ano3)) {
			$sql.= " AND (data = '$ano3-$mes3-$dia3' ) ";		
		} 
	} else if(!empty($dia3) && !empty($dia4)) {
		$sql.= " AND DAY(data) BETWEEN '$dia3' AND '$dia4' ";
	} else if(!empty($mes3) && !empty($mes4)) {
		$sql.= " AND MONTH(data) BETWEEN '$mes3' AND '$mes4' ";	
	} else if (!empty($mes3) || !empty($mes4)) {
		if( empty($mes3) && !empty($mes4) ) {		
			$mes3 = $mes4;
		}
		$sql.= " AND (MONTH(data) = '$mes3' ) ";
	} else if (!empty($ano3) || !empty($ano4)) {
		if( empty($ano3) && !empty($ano4) ) {		
			$ano3 = $ano4;
		}
		$sql.= " AND (YEAR(data) = '$ano3' ) ";
	}
}
		

//PALESTRANTE
if(isset($buscanome) && $buscanome != ''){
	$nomeArray = explode(' ', $buscanome);
	for($i = 0; $i < sizeof($nomeArray); $i++){
		$sql .= "AND nome COLLATE latin1_swedish_ci LIKE '%$nomeArray[$i]%' ";
	}
}

//E-MAIL
if(isset($buscaemail) && $buscaemail != ''){
	$sql .= "AND email LIKE '%$buscaemail%' ";
}

//PALESTRANTE
if(isset($buscapalestrante) && $buscapalestrante == '1'){
	$sql .= "AND palestrante = '1' ";
}

//ADMINISTRADOR
if(isset($buscaadministrador) && $buscaadministrador == '1'){
	$sql .= "AND administrador = '1' ";
}

//ORDEM
if(empty($ordenar) || $ordenar == '-' || $ordem == ''){
	$ordenar = "nome";
}
if(empty($ordem) || $ordem == '-' || $ordem == ''){
	$ordem = "ASC";
}
$sql.= "ORDER BY $ordenar $ordem ";

?>