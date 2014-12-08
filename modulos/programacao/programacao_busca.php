<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/class.TemplatePower.inc.php');

$tpl = new TemplatePower('programacao_busca.html');
$tpl->prepare();

//NOME DO EVENTO
$tpl->assignGlobal('idevento',$idevento);
$sqlEv = "SELECT nomeevento FROM eventos WHERE idevento = '$idevento'";
$rsEv = mysql_query($sqlEv);
if(mysql_num_rows($rsEv)){
	$tpl->assignGlobal('nomeevento', mysql_result($rsEv, 0, 'nomeevento'));	
}
$tpl->assignGlobal('idevento', $idevento);	

//ATRIBUINDO NOME DA CATEGORIA E TIPO
session_start();
$tpl->assignGlobal('categoria', $nomesecao);
$tpl->assignGlobal('tipo', $tipo);
$tpl->assignGlobal('nomeLogin', $_SESSION['NOME']);

$buscatitulo		= $_SESSION['SESSAOBUSCA'][0];
$buscalocal			= $_SESSION['SESSAOBUSCA'][1];
$buscadescricao		= $_SESSION['SESSAOBUSCA'][2];
$buscasobre			= $_SESSION['SESSAOBUSCA'][3];
$buscapalestrante	= $_SESSION['SESSAOBUSCA'][4];
$buscadata			= $_SESSION['SESSAOBUSCA'][5];
$buscahorainicio	= $_SESSION['SESSAOBUSCA'][6];
$buscahorafim		= $_SESSION['SESSAOBUSCA'][7];	
$buscaperguntas		= $_SESSION['SESSAOBUSCA'][8];	
$buscamaterial		= $_SESSION['SESSAOBUSCA'][9];	
$ordenar			= $_SESSION['SESSAOBUSCA'][10];
$ordem				= $_SESSION['SESSAOBUSCA'][11];
$buscapagina		= $_SESSION['SESSAOBUSCA'][12];

$tpl->assignGlobal('buscatitulo',$buscatitulo);
$tpl->assignGlobal('buscalocal',$buscalocal);
$tpl->assignGlobal('buscadescricao',$buscadescricao);
$tpl->assignGlobal('buscasobre',$buscasobre);
$tpl->assignGlobal('buscapalestrante',$buscapalestrante);
$tpl->assignGlobal('buscadata',$buscadata);
$tpl->assignGlobal('buscahorainicio',$buscahorainicio);
$tpl->assignGlobal('buscahorafim',$buscahorafim);
$tpl->assignGlobal('buscaperguntas',$buscaperguntas);
$tpl->assignGlobal('buscaarquivos',$buscaarquivos);

if($buscaperguntas == '1'){
	$tpl->assign('chkprt','checked');
}

if($buscamaterial == '1'){
	$tpl->assign('chkmat','checked');
}

//ORDENAR POR
switch($ordenar){
	case 'datainicio': $tpl->assignGlobal('orn1','selected'); break;
	case 'nome COLLATE latin1_swedish_ci': $tpl->assignGlobal('orn2','selected'); break;
	case 'local COLLATE latin1_swedish_ci': $tpl->assignGlobal('orn3','selected'); break;
}

//ORDEM
switch($ordem){
	case 'ASC': $tpl->assignGlobal('ord1','selected'); break;
	case 'DESC': $tpl->assignGlobal('ord2','selected'); break;
}

$tpl->printToScreen();
?>