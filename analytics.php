<?php
include_once('incs/conn.php');

$id = $_POST['id'];
$token = $_POST['token'];
$idevento = $_POST['idevento'];
$idprogramacao = $_POST['idprogramacao'];
$idaviso = $_POST['idaviso'];
$idpergunta = $_POST['idpergunta'];
$tipo = $_POST['tipo'];
$secao = $_POST['secao'];

$data = date('Y-m-d');   
$hora = date('H:i:s');

$sql = "SELECT administrador FROM login WHERE id = '$id'";
$rs = mysql_query($sql);
$admin = mysql_result($rs, 0, 'administrador');

if($admin != '1'){
	$sql = "INSERT INTO analytics (data,
								   hora,
								   iduser,
								   token,
								   idevento,
								   idprogramacao,
								   idaviso,
								   idpergunta,
								   tipo,
								   secao) VALUES ('$data',
												  '$hora',
												  '$id',
												  '$token',
												  '$idevento',
												  '$idprogramacao',
												  '$idaviso',
												  '$idpergunta',
												  '$tipo',
												  '$secao')";
	$rs = mysql_query($sql);
}

echo('OK');
?>