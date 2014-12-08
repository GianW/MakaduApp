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
	$tpl = new TemplatePower('perfil.html');
	$tpl->prepare();
	
	$sql = "SELECT * FROM login WHERE id = '$id'";
	$rs = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($rs)){
		while($rsDados = mysql_fetch_array($rs)){
			$tpl->assign('nome', $rsDados['nome']);
			$tpl->assign('email', $rsDados['email']);
			$tpl->assign('id', $rsDados['id']);
		}
	}
	
	$tpl->printToScreen();
//}
?>