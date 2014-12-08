<?php
include_once('incs/conn.php');
include_once('incs/session.php');

error_reporting(0);


	$datalog = date('Y-m-d');   
	$horalog = date('H:i:s');	
//LOG
/*$sqlLog = "INSERT INTO fl_log
					   (idusuario,
					   data,
					   hora,
					   acao,
					   titulo,
					   secao) VALUES ('".$_SESSION['ID']."',
									  '$datalog',
									  '$horalog',
									  'saiu',
									  '$nome',
									  '".$_SERVER['HTTP_REFERER']."')";
									  
$rsLog = mysql_query($sqlLog);	*/

session_start();
session_destroy();
header('location:index.php');
?>