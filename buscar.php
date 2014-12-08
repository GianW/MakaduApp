<?php
include_once('incs/conn.php');
include_once('incs/funcoes.php');
include_once('incs/class.TemplatePower.inc.php');

$busca = utf8_decode($_POST['busca']);

header ('Content-type: text/html; charset=ISO-8859-1');

$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");

//if ($iphone || $ipad || $android || $palmpre || $ipod || $berry == true) 
//{ 	
	$tpl = new TemplatePower('buscar.html');
	$tpl->prepare();
	
	$sql = "SELECT * FROM eventos 
			WHERE datafim >= CURRENT_DATE 
			AND ativo = '1' 
			AND (nomeevento COLLATE latin1_swedish_ci LIKE '%$busca%'
			OR local COLLATE latin1_swedish_ci LIKE '%$busca%'
			OR cidade COLLATE latin1_swedish_ci LIKE '%$busca%'
			OR texto COLLATE latin1_swedish_ci LIKE '%$busca%')
			ORDER BY datainicio DESC";
	$rs = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($rs)){
		while($rsDados = mysql_fetch_array($rs)){
			$tpl->newBlock('EVENTO');
			$tpl->assign('idevento', $rsDados['idevento']);
			$tpl->assign('nomeevento', $rsDados['nomeevento']);
			$tpl->assign('datainicio', dataBR($rsDados['datainicio']));
			if($rsDados['datafim']){
				$tpl->assign('datafim', ' a '.dataBR($rsDados['datafim']));
			}
		}
	}
	
	$sql = "SELECT * FROM eventos 
			WHERE datafim < CURRENT_DATE 
			AND ativo = '1' 
			AND (nomeevento COLLATE latin1_swedish_ci LIKE '%$busca%'
			OR local COLLATE latin1_swedish_ci LIKE '%$busca%'
			OR cidade COLLATE latin1_swedish_ci LIKE '%$busca%'
			OR texto COLLATE latin1_swedish_ci LIKE '%$busca%') 
			ORDER BY datainicio DESC";
	$rs = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($rs)){
		$tpl->newBlock('TITULOPASSADO');
		while($rsDados = mysql_fetch_array($rs)){
			$tpl->newBlock('EVENTOPASSADO');
			$tpl->assign('idevento', $rsDados['idevento']);
			$tpl->assign('nomeevento', $rsDados['nomeevento']);
			$tpl->assign('datainicio', dataBR($rsDados['datainicio']));
			if($rsDados['datafim']){
				$tpl->assign('datafim', ' a '.dataBR($rsDados['datafim']));
			}
		}
	}	
	
	echo($tpl->printToScreen());
//}
?>