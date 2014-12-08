<?php
include_once('incs/conn.php');

$nome = $_POST['nome'];
$email = $_POST['email'];

$sql = "UPDATE login SET nome = '$nome', email = '$email' WHERE id = '$id'";
$rs = mysql_query($sql);

echo('OK');
?>