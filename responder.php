<?php
include_once('incs/conn.php');

$idpergunta = $_POST['idpergunta'];
$idprogramacao = $_POST['idprogramacao'];
$id = $_POST['id'];
$resposta = utf8_decode($_POST['resposta']);

$data = date('Y-m-d');   
$hora = date('H:i:s');

$sql = "INSERT INTO respostas (idpergunta, idusuario, resposta, data, hora) VALUES ('$idpergunta', '$id', '$resposta', '$data', '$hora')";
$rs = mysql_query($sql);

echo('OK');
?>