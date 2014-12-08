<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/class.TemplatePower.inc.php');

$tpl = new TemplatePower('log_busca.html');
$tpl->prepare();

include_once('../../incs/permissoes.php');
include_once('../../incs/menu.php');

//ATRIBUINDO NOME DA CATEGORIA E TIPO
$tpl->assignGlobal('categoria', $nomesecao);
$tpl->assignGlobal('tipo', $tipo);
$tpl->assignGlobal('nomeLogin', $_SESSION['NOME']);


include_once('../adm/_niveis.php');

//SE VEM DA BUSCA, PEGA VARIAVEIS
$tpl->assignGlobal('busca',$busca);
$busca = base64_decode($busca);
$busca = utf8_decode($busca);

$tpl->assignGlobal('buscanome',$buscanome);

$tpl->assignGlobal('buscade',str_replace('-','/',$buscade));
$tpl->assignGlobal('buscaate',str_replace('-','/',$buscaate));

switch($buscasecao){
	case 'Cadastros':
	$tpl->assignGlobal('secaosel1','selected');
	break;
	case 'Imprensa':
	$tpl->assignGlobal('secaosel2','selected');
	break;
	case 'Instituições':
	$tpl->assignGlobal('secaosel3','selected');
	break;
	case 'Outros Cartões':
	$tpl->assignGlobal('secaosel4','selected');
	break;
	case 'Administradores':
	$tpl->assignGlobal('secaosel5','selected');
	break;
	case 'Funções Partidárias':
	$tpl->assignGlobal('secaosel6','selected');
	break;
	case 'Coordenadorias':
	$tpl->assignGlobal('secaosel7','selected');
	break;
	case 'Municípios do RS':
	$tpl->assignGlobal('secaosel8','selected');
	break;
	case 'Etiquetas':
	$tpl->assignGlobal('secaosel9','selected');
	break;
	case 'Cartões de Aniversário':
	$tpl->assignGlobal('secaosel10','selected');
	break;
}

switch($buscaacao){
	case 'editou':
	$tpl->assignGlobal('acaosel1','selected');
	break;
	case 'inseriu':
	$tpl->assignGlobal('acaosel2','selected');
	break;
	case 'excluiu':
	$tpl->assignGlobal('acaosel3','selected');
	break;
	case 'entrou':
	$tpl->assignGlobal('acaosel4','selected');
	break;	
}

$tpl->printToScreen();
?>