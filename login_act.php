<?php
include_once('incs/conn.php');
include_once('incs/funcoes.php');

if(!isset($login) || trim($login)=='' || !isset($senha) || trim($senha)==''){
	session_register('MSG');
	$_SESSION['MSG'] = "Login ou senha inválidos";		
	header('location:index.php');
	exit;
}

$login = mysql_real_escape_string($login);
$senha = mysql_real_escape_string($senha);

$sql = "SELECT * FROM login WHERE email = '$login' AND senha = MD5('$senha') AND administrador = '1'";

$rs = mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($rs) == 1){
	$cliente = mysql_result($rs,0,'cliente');
	session_start($cliente);
	session_name($cliente);		
	
	session_register('ID');
	session_register('NOME');
	session_register('EMAIL');
	session_register('PALESTRANTE');
	
	$_SESSION['NOME'] = mysql_result($rs,0,'nome');
	$_SESSION['EMAIL'] = mysql_result($rs,0,'email');
	$_SESSION['ID'] = mysql_result($rs,0,'id');
	$_SESSION['PALESTRANTE'] = mysql_result($rs,0,'palestrante');
	
	$destino='modulos/usuarios/usuarios.php';
	
	//LOG--------------------------------------------------------------------------------------------------
/*	$datalog = date('Y-m-d');   
	$horalog = date('H:i:s');	
	
	//LOG
		$sqlLog = "INSERT INTO log
							   (idusuario,
							   data,
							   hora,
							   acao,
							   titulo,
							   secao) VALUES ('".$_SESSION['ID']."',
											  '$datalog',
											  '$horalog',
											  'entrou',
											  '$nome',
											  'login')";
											  
		$rsLog = mysql_query($sqlLog);	*/
	//-----------------------------------------------------------------------------------------------------	
} else {
	session_register('MSG');
	$_SESSION['MSG'] = "Login ou senha inválidos";		
	$destino = 'index.php';
}
header('location:'.$destino);
?>