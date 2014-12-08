<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/class.date.php');
include_once('../../incs/class.TemplatePower.inc.php');
include_once('../../incs/pagination.class.php');

//INCLUINDO TIPOS DESTE SITE. ALTERAR config.php PARA NOVOS TIPOS

$modelo = 'log.htm';
$tpl = new TemplatePower('../adm/_adm_estrutura.htm');
$tpl->assignInclude('CONTEUDO',$modelo);
$tpl->prepare();

include_once('../../incs/permissoes.php');
include_once('../../incs/menu.php');

//MENSAGEM
session_start();
if(session_is_registered('MSG') && $_SESSION['MSG'] != ''){
	$tpl->assignGlobal('onload',' onload="wire()"');
}

include_once('../adm/_niveis.php');

//PREMISSOES-------------------------------------
$tpl->assignGlobal('nomeLogin', $_SESSION['NOME']);

//-----------------------------------------------

//BUSCA------------------------------------------
if($buscado == 'ok'){
	$nome = $buscanome;
	$tpl->assignGlobal('buscanome',$nome);
	$acao = $buscaacao;
	$tpl->assignGlobal('buscaacao',$acao);
	$secao = $buscasecao;
	$tpl->assignGlobal('buscasecao',$secao);
	
	$buscade = explode('/',$_POST['buscade']);
	$dia = $buscade[0];
	$mes = $buscade[1];
	$ano = $buscade[2];
	$tpl->assignGlobal('buscade',$dia.'-'.$mes.'-'.$ano);
	
	$buscaate = explode('/',$_POST['buscaate']);
	$dia2 = $buscaate[0];
	$mes2 = $buscaate[1];
	$ano2 = $buscaate[2];
	$tpl->assignGlobal('buscaate',$dia2.'-'.$mes2.'-'.$ano2);
}

$tpl->assignGlobal('tipo', $tipo);

//PAGINAÇÃO
//SETANDO LIMITE DE RESULTADOS POR PÁGINA
$sql = "SELECT *, fl.data AS dataLog, fl.hora AS horaLog, fa.nome AS nomeUsuario FROM fl_log fl
		LEFT JOIN fl_adm fa
		ON fa.id = fl.idusuario
		WHERE 1=1 ";
		
//BUSCA DATA NASCIMENTO
if(!empty($dia) && !empty($mes) && !empty($ano) && !empty($dia2) && !empty($mes2) && !empty($ano2) ) {
	$sql.= " AND (fl.data BETWEEN '$ano-$mes-$dia' AND '$ano2-$mes2-$dia2') ";	
} else if (!empty($dia) || !empty($dia2) && !empty($mes) || !empty($mes2) && !empty($ano2) || !empty($ano2) ) {
	if( empty($dia) && !empty($dia2) ) {		
		$dia = $dia2;
	}
	if( empty($mes) && !empty($mes2) ) {		
		$mes = $mes2;
	}
	if( empty($ano) && !empty($ano2) ) {		
		$ano = $ano2;
	}
	
	if(!empty($ano) && !empty($ano2)) {		
	$sql.= " AND YEAR(fl.data) BETWEEN '$ano' AND '$ano2' ";	
	
	} else if (!empty($dia) && !empty($mes) && !empty($dia2) && !empty($mes2)) {	
		$sql.= " AND (EXTRACT(MONTH From fl.data) + (EXTRACT(DAY From fl.data) / 100.00)) 
							BETWEEN ($mes + ($dia / 100.00)) AND ($mes2 + ($dia2 / 100.00)) ";								
	} else if(!empty($dia) && empty($mes) && empty($ano)) {
		$sql.= " AND (DAY(fl.data) = '$dia' ) ";
		
	} else if(empty($dia) && !empty($mes) && empty($ano)) {
		$sql.= " AND (MONTH(fl.data) = '$mes' ) ";
		
	} else if(!empty($dia) && !empty($mes) && empty($ano)) {
		$sql.= " AND (EXTRACT(MONTH From fl.data) + (EXTRACT(DAY From fl.data) / 100.00)) 
							= ($mes + ($dia / 100.00)) ";
	} else if(empty($dia) && !empty($mes) && !empty($ano)) {	
		$sql.= " AND (EXTRACT(YEAR From fl.data) + (EXTRACT(MONTH From fl.data) / 100.00)) 
						= ($ano + ($mes / 100.00)) ";
	} else if(!empty($dia) && !empty($mes) && !empty($ano)) {
		$sql.= " AND (fl.data = '$ano-$mes-$dia' ) ";		
	} 
} else if(!empty($dia) && !empty($dia2)) {
	$sql.= " AND DAY(fl.data) BETWEEN '$dia' AND '$dia2' ";
} else if(!empty($mes) && !empty($mes2)) {
	$sql.= " AND MONTH(fl.data) BETWEEN '$mes' AND '$mes2' ";	
} else if (!empty($mes) || !empty($mes2)) {
	if( empty($mes) && !empty($mes2) ) {		
		$mes = $mes2;
	}
	$sql.= " AND (MONTH(fl.data) = '$mes' ) ";
} else if (!empty($ano) || !empty($ano2)) {
	if( empty($ano) && !empty($ano2) ) {		
		$ano = $ano2;
	}
	$sql.= " AND (YEAR(fl.data) = '$ano' ) ";
}		
		
if(isset($buscanome) && $buscanome != ''){
	$sql .= "AND fa.nome LIKE '%$nome%' ";
}

if(isset($buscaacao) && $buscaacao != '-' && $buscaacao != ''){
	$sql .= "AND fl.acao = '$acao' ";
}

if(isset($buscasecao) && $buscasecao != '-' && $buscaacao != ''){
	$sql .= "AND fl.secao = '$secao' ";
}

//die($sql);
$sql .= "ORDER BY fl.data DESC, fl.hora DESC";

//PAGINAÇÃO-----------------------------------
//EXECUTA QUERY
$rs = mysql_query($sql) or die(mysql_error());

$total = mysql_num_rows($rs);
$tpl->assignGlobal('numtotal',$total);
$lpp = 50;	

$pagina = $_REQUEST['page'];
if ($pagina == "" || !isset($pagina)) {
	$pagina = 1;
}

$tpl->assignGlobal('page',$pagina);
$inicio = ($pagina * $lpp) - $lpp;

$busca = utf8_encode($busca);
$busca = base64_encode($busca);
$busca_av = "buscanome=$nome&buscaacao=$acao&buscasecao=$secao&buscade=$buscade&buscaate=$buscaate";

$p = new pagination('paginacao');
$p->Items($total);

if($buscado == 'ok'){
	$p->queryS($busca_av.'&buscado=ok');
}else{
	$p->queryS($busca_av);
}

$p->limit($lpp);
$p->currentPage($pagina);
$p->nextLabel('');
$p->prevLabel('');
$tpl->assignGlobal('paginacao',$p-> show());

//QUERY DO MYSQL
$sql .= " LIMIT $inicio, $lpp";
$rs = mysql_query($sql);
//--------------------------------------------


//SE RETORNOU ALGO, CRIA A LISTA DE PUBLICAÇÕES
if(mysql_num_rows($rs)  || $buscado == 'ok'){
	//SE NÃO ACHOU NADA EM CASO DE BUSCA
	if(mysql_num_rows($rs) == 0 && $buscado == 'ok'){
		session_register('MSG');
		$_SESSION['MSG'] = "Não foram encontrados registros correspondentes à sua busca.";
		
		header("location:log.php");
		exit;
	}
	$tpl->newBlock('BLOCO');
	
	
	//CRIANDO LOOP DA LISTA DE PUBLICACOES
	$sortColor = 1;
	while($rsDados = mysql_fetch_array($rs)){
		$tpl->newBlock('PUBLICACOES');
		
		$confirm = 'Voc&ecirc; tem certeza que deseja remover este registro?';
		$tpl->assign('confirm',$confirm);
		
		$tpl->assign('bg','#FFFFFF');
		$tpl->assign('sep','spacer.gif');
		
		$tpl->assign('bg','sortB');
		$tpl->assign('color','#FFFFFF');
		
		if($sortColor % 2 == 0){
			$tpl->assign('bg','sortC');
			$tpl->assign('color','#EAEAEA');
		}
		
		$sortColor++;

		$tpl->assign('nome',$rsDados['nomeUsuario']);
		$tpl->assign('idusuario',$rsDados['idusuario']);
		$tpl->assign('acao',$rsDados['acao']);
		$tpl->assign('titulo',$rsDados['titulo']);
		$tpl->assign('secao',$rsDados['secao']);
		$tpl->assign('data',dataBR($rsDados['dataLog']));
		$tpl->assign('hora',$rsDados['horaLog']);

	}
}else{
	$tpl-> newBlock('VAZIO'); //NENHUM REGISTRO ENCONTRADO
}

$tpl->printToScreen();
?>