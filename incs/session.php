<?php
$cliente = mysql_result(mysql_query('SELECT nome FROM login'), 0, 'nome');

session_start($cliente);
$sid = $_SESSION['NOME'];

session_start();
if(!session_is_registered('NOME')){
	header('Location: ../../index.php');
}
?>