<?php
include_once('../../incs/conn.php');
include_once("../../incs/session.php");
include_once('../../incs/funcoes.php');
include_once('../../fckeditor/fckeditor.php');
include_once('../../incs/class.TemplatePower.inc.php');

$modelo = 'respostas_edit.htm';
$tpl = new TemplatePower('../adm/_adm_estrutura.htm');
$tpl->assignInclude('CONTEUDO',$modelo);
$tpl->prepare();

include_once('../../incs/permissoes.php');
include_once('../../incs/menu.php');

//ATRIBUINDO A��O, TIPOS E DATA DE HOJE NO CAMPO DATA
$tpl->assignGlobal('nomeLogin', $_SESSION['NOME']);

//---------------------------------------------------------------------------------------------
//INSER��O-------------------------------------------------------------------------------------
if($acao == 'ins'){	
	$tpl->assignGlobal('acao', 'ins');
	$tpl->assignGlobal('acaotitulo', 'inser��o');
	$tpl->assignGlobal('data', date('d/m/Y'));
	$tpl->assignGlobal('idevento',$idevento);
	$tpl->assignGlobal('idpergunta',$idpergunta);
	$tpl->assignGlobal('idevento',$idevento);
}

//---------------------------------------------------------------------------------------------
//EDI��O---------------------------------------------------------------------------------------
if($acao == 'atu'){	
	$tpl->assignGlobal('edicao','<input name="id" type="hidden" id="id" value="'.$idresposta.'">');
	$tpl->assignGlobal('idpergunta',$idpergunta);
	$tpl->assignGlobal('idevento',$idevento);
	$tpl->assignGlobal('acao', 'atu');
	$tpl->assignGlobal('acaotitulo', 'edi��o');
	
	$sql = "SELECT * FROM respostas WHERE idresposta = '$idresposta'";
	$rs = mysql_query($sql) or die(mysql_error());

	if($rsDados = mysql_fetch_array($rs)){
		$tpl->assign('resposta',$rsDados['resposta']);								
	}
}

$tpl->printToScreen();
?>