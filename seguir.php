<?php
include_once('incs/conn.php');

$idevento = $_POST['idevento'];
$id = $_POST['id'];
$chave = $_POST['chave'];

if($chave == '0'){
	$sql = "INSERT INTO reluserevento (idevento, id) VALUES ('$idevento', '$id')";
}else{
	$sql = "DELETE FROM reluserevento WHERE idevento = '$idevento' AND id = '$id'";
}
$rs = mysql_query($sql);
?>