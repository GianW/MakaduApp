<?php
include_once('../../incs/conn.php');

$nomeUsuario = utf8_decode($_GET['term']);	
$sql = "SELECT id, nome FROM login
		WHERE nome COLLATE latin1_swedish_ci LIKE '".$nomeUsuario."%'
		AND palestrante = '1'
		ORDER BY nome COLLATE latin1_swedish_ci
		LIMIT 0,5";
$rs = mysql_query($sql);

$json = Array();
while ($rsDados = mysql_fetch_array($rs)){
	array_push($json, Array("value" => utf8_encode($rsDados['nome'])));
}
echo json_encode($json);
?>