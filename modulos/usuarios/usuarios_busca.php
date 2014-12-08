<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/class.TemplatePower.inc.php');

$tpl = new TemplatePower('usuarios_busca.html');
$tpl->prepare();

//ATRIBUINDO NOME DA CATEGORIA E TIPO
session_start();
$tpl->assignGlobal('categoria', $nomesecao);
$tpl->assignGlobal('tipo', $tipo);
$tpl->assignGlobal('nomeLogin', $_SESSION['NOME']);

$buscanome			= $_SESSION['SESSAOBUSCA'][0];
$buscaemail			= $_SESSION['SESSAOBUSCA'][1];
$buscapalestrante	= $_SESSION['SESSAOBUSCA'][2];
$buscaadministrador	= $_SESSION['SESSAOBUSCA'][3];
$buscadatacad		= $_SESSION['SESSAOBUSCA'][4];
$buscadatacadate	= $_SESSION['SESSAOBUSCA'][5];		
$ordenar			= $_SESSION['SESSAOBUSCA'][6];
$ordem				= $_SESSION['SESSAOBUSCA'][7];
$buscapagina		= $_SESSION['SESSAOBUSCA'][8];

$tpl->assignGlobal('buscanome',$buscanome);
$tpl->assignGlobal('buscaemail',$buscaemail);
$tpl->assignGlobal('buscadatacad',$buscadatacad);
$tpl->assignGlobal('buscadatacadate',$buscadatacadate);

if($buscapalestrante == '1'){
	$tpl->assign('chkpls','checked');
}

if($buscaadministrador == '1'){
	$tpl->assign('chkadm','checked');
}

//ORDENAR POR
switch($ordenar){
	case 'nome COLLATE latin1_swedish_ci': $tpl->assignGlobal('orn1','selected'); break;
	case 'email': $tpl->assignGlobal('orn2','selected'); break;
	case 'datacadastro': $tpl->assignGlobal('orn3','selected'); break;
}

//ORDEM
switch($ordem){
	case 'ASC': $tpl->assignGlobal('ord1','selected'); break;
	case 'DESC': $tpl->assignGlobal('ord2','selected'); break;
}

$tpl->printToScreen();
?>