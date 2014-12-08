<?php
include_once('incs/conn.php');

$pergunta = utf8_decode($_POST['pergunta']);
$idprogramacao = $_POST['idprogramacao'];
$id = $_POST['id'];

$data = date('Y-m-d');   
$hora = date('H:i:s');

$sql = "INSERT INTO perguntas (pergunta, idprogramacao, idquestionador, data, hora) VALUES ('$pergunta', '$idprogramacao', '$id', '$data', '$hora')";
$rs = mysql_query($sql);

echo('OK');
?>