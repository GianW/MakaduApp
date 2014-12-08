<?php
$modelo='login.htm';
include_once('incs/conn.php');
include_once('incs/class.TemplatePower.inc.php');

$tpl=new TemplatePower($modelo);
$tpl->prepare();

//MENSAGEM
session_start();
if(session_is_registered('MSG')){
	$tpl->assignGlobal('onload','true');
}

$tpl->printToScreen();
?>