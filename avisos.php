<?php
include_once('incs/conn.php');
include_once('incs/funcoes.php');
include_once('incs/class.TemplatePower.inc.php');

header ('Content-type: text/html; charset=ISO-8859-1');

$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");

//if ($iphone || $ipad || $android || $palmpre || $ipod || $berry == true) 
//{ 	
	$tpl = new TemplatePower('avisos.html');
	$tpl->prepare();
	
	$sql = "SELECT * FROM eventos WHERE idevento = '$idevento'";
	$rs = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($rs)){
		while($rsDados = mysql_fetch_array($rs)){
			$tpl->assign('nomeevento', $rsDados['nomeevento']);
		}
	}	
	
	$sql = "SELECT * FROM avisos WHERE ativo = '1' AND patrocinado = '1' AND idevento = '$idevento' ORDER BY dataaviso DESC, horaaviso DESC";
	$rs = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($rs)){
		$qtd = 1;
		$total = mysql_num_rows($rs);
		$patr = 1;
		$tpl->newBlock('TITULOPATROCINADOS');
		
		while($rsDados = mysql_fetch_array($rs)){
			$tpl->newBlock('PATROCINADO');
			$tpl->assign('idaviso', $rsDados['idaviso']);
			$tpl->assign('aviso', $rsDados['aviso']);
			$tpl->assign('detalhes', $rsDados['detalhes']);	
			if($qtd < $total){
				$tpl->newBlock('RISCOPATROCINADO');
			}
			$qtd++;
		}
	}
	
	$sql = "SELECT * FROM avisos WHERE ativo = '1' AND patrocinado <> '1' AND idevento = '$idevento' ORDER BY dataaviso DESC, horaaviso DESC";
	$rs = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($rs)){
		$qtd = 1;
		$total = mysql_num_rows($rs);
		
		while($rsDados = mysql_fetch_array($rs)){
			$tpl->newBlock('NORMAL');
			$tpl->assign('idaviso', $rsDados['idaviso']);
			$tpl->assign('aviso', $rsDados['aviso']);
			$tpl->assign('detalhes', $rsDados['detalhes']);	
			if($qtd < $total){
				$tpl->newBlock('RISCONORMAL');
			}
			$qtd++;
		}
		
		if($patr == 1){
			$tpl->newBlock('TITULONORMAIS');
		}		
	}
	
	if($qtd == 0){
		$tpl->newBlock('VAZIO');
	}
	
	$tpl->printToScreen();
//}
?>