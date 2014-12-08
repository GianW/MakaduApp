<?php
include_once('../../incs/conn.php');

$nomeUsuario = utf8_decode($_GET['term']);	
$sql = "SELECT idevento, nomeevento FROM eventos
		WHERE nomeevento COLLATE latin1_swedish_ci LIKE '".$nomeUsuario."%'
		ORDER BY nomeevento COLLATE latin1_swedish_ci
		LIMIT 0,5";
$rs = mysql_query($sql);

$json = Array();
while ($rsDados = mysql_fetch_array($rs)){
	array_push($json, Array("value" => utf8_encode($rsDados['nomeevento'])));
}
echo json_encode($json);
?>