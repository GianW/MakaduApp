<?php
include_once('incs/conn.php');

$nome = utf8_decode($_POST['nome']);
$email = $_POST['email'];
$data = date('Y-m-d');

$sql = "INSERT INTO login (data, nome, email, ativo) VALUES ('$data', '$nome', '$email', '1')";
$rs = mysql_query($sql) or die(mysql_error());

$id = mysql_insert_id($conn);
echo($id);
?>