<?php
$req = $_SERVER['REQUEST_URI'];
$cadena = explode("?", $req);
$mi_url = $cadena[0];
$resto = $cadena[1];

//O QUE NÃO PODE CONSTAR NO URL APÓS O ?
$inyecc='/script|http|<|>|%3c|%3e|SELECT|UNION|UPDATE|AND|exe|exec|INSERT|tmp/i'; 

//SE CONSTA
if (preg_match($inyecc, $resto)) {
	//ENTRA NUM LOOP INFINITO
	$i=1;
	while($i){
		//echo('');
	}
	die();
}

$dbHost	= '186.202.152.193';
$dbLogin	= '******';
$dbSenha	= '******';
$dbBanco	= 'makadu';		

$conn = mysql_connect($dbHost, $dbLogin, $dbSenha) or die('Erro na conexão. Favor contatar o desenvolvedor.');
$db = mysql_select_db($dbBanco) or die('Erro no Banco de Dados. Favor contatar o desenvolvedor.');

$sqlBig = "SET SQL_BIG_SELECTS=1";
$rsBig = mysql_query($sqlBig) or die(mysql_error()); 

header ('Content-type: text/html; charset=ISO-8859-1');
?>