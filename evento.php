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
	$tpl = new TemplatePower('evento.html');
	$tpl->prepare();
	
	$sql = "SELECT * FROM eventos WHERE idevento = '$idevento'";
	$rs = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($rs)){
		while($rsDados = mysql_fetch_array($rs)){
			$tpl->assign('nomeevento', $rsDados['nomeevento']);
			$tpl->assign('local', $rsDados['local']);
			$tpl->assign('endereco', $rsDados['endereco']);
			$tpl->assign('cidade', $rsDados['cidade']);
			$tpl->assign('estado', $rsDados['estado']);
			$tpl->assign('datainicio', dataBR($rsDados['datainicio']));
			if($rsDados['datafim']){
				$tpl->assign('datafim', ' a '.dataBR($rsDados['datafim']));
			}
			$tpl->assign('release', $rsDados['texto']);
			
			if($rsDados['patrocinio'] != ''){
				$rand = rand(0, 10000);
				$tpl->newBlock('PATROCINIO');
				$tpl->assign('caminho','uploads/eventos/g_'.$rsDados['patrocinio'].'?atu='.$rand);
			}			
		}
	}
	
	if($id != '0' && $id != 0){
		$sql = "SELECT * FROM reluserevento WHERE idevento = '$idevento' AND id = '$id'";
		$rs = mysql_query($sql);
		
		if(mysql_num_rows($rs)){
			$tpl->assignGlobal('chave', 'de');
			$tpl->assignGlobal('nome', '1');
			$tpl->assignGlobal('textoseguir', 'NÃO RECEBER NOTIFICAÇÕES');
		}else{
			$tpl->assignGlobal('nome', '0');
			$tpl->assignGlobal('textoseguir', 'RECEBER NOTIFICAÇÕES');
		}
	}else{
		$tpl->assignGlobal('nome', '0');
		$tpl->assignGlobal('textoseguir', 'RECEBER NOTIFICAÇÕES');
	}		
	
	$tpl->printToScreen();
//}
?>