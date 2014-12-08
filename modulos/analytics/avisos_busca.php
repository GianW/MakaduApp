<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/class.TemplatePower.inc.php');

$tpl = new TemplatePower('avisos_busca.html');
$tpl->prepare();

//ATRIBUINDO NOME DA CATEGORIA E TIPO
session_start();
$tpl->assignGlobal('categoria', $nomesecao);
$tpl->assignGlobal('tipo', $tipo);
$tpl->assignGlobal('nomeLogin', $_SESSION['NOME']);

$bascaaviso			= $_SESSION['SESSAOBUSCA'][0];
$buscadetalhes		= $_SESSION['SESSAOBUSCA'][1];
$buscahora			= $_SESSION['SESSAOBUSCA'][2];
$buscadata			= $_SESSION['SESSAOBUSCA'][3];
$buscadataate		= $_SESSION['SESSAOBUSCA'][4];	
$ordenar			= $_SESSION['SESSAOBUSCA'][5];
$ordem				= $_SESSION['SESSAOBUSCA'][6];
$buscapagina		= $_SESSION['SESSAOBUSCA'][7];

$tpl->assignGlobal('bascaaviso',$bascaaviso);
$tpl->assignGlobal('buscadetalhes',$buscadetalhes);
$tpl->assignGlobal('buscahora',$buscahora);
$tpl->assignGlobal('buscadata',$buscadata);
$tpl->assignGlobal('buscadataate',$buscadataate);

//ORDENAR POR
switch($ordenar){
	case 'dataaviso': $tpl->assignGlobal('orn1','selected'); break;
	case 'horaaviso': $tpl->assignGlobal('orn2','selected'); break;
	case 'aviso COLLATE latin1_swedish_ci': $tpl->assignGlobal('orn2','selected'); break;
}

//ORDEM
switch($ordem){
	case 'ASC': $tpl->assignGlobal('ord1','selected'); break;
	case 'DESC': $tpl->assignGlobal('ord2','selected'); break;
}

$tpl->printToScreen();
?>