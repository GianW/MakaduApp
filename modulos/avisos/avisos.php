<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/class.TemplatePower.inc.php');
include_once('../../incs/pagination.class.php');

$modelo = 'avisos.htm';
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

//PREMISSOES-------------------------------------
$tpl->assignGlobal('nomeLogin', $_SESSION['NOME']);
//-----------------------------------------------

if(!isset($idevento) || $idevento == '' || $idevento == '#'){
	
	//SE AINDA NÃO TEM EVENTO SELECIONADO
	$tpl->newBlock('POPUP');
	
}else{
	
	//NOME DO EVENTO
	$tpl->assignGlobal('idevento',$idevento);
	$sqlEv = "SELECT nomeevento FROM eventos WHERE idevento = '$idevento'";
	$rsEv = mysql_query($sqlEv);
	if(mysql_num_rows($rsEv)){
		$tpl->assignGlobal('nomeevento', mysql_result($rsEv, 0, 'nomeevento'));	
	}

	//QUERY
	include_once('avisos_busca_query.php');
	
	//PAGINAÇÃO
	//EXECUTA QUERY
	$rs = mysql_query($sql);
	$total = mysql_num_rows($rs);
	$tpl->assignGlobal('numtotal',$total);
	$lpp = 25;	
	
	if ($page == "" || !isset($page)) {
		if($buscapagina == "" || !isset($buscapagina)){
			$buscapagina = 1;	
		}
	}else{
		$buscapagina = $page;
	}
	$pagina = $buscapagina;
	if($disparabusca == 'ok'){
		$pagina = 1;
	}
	
	$tpl->assignGlobal('page',$pagina);
	$inicio = ($pagina * $lpp) - $lpp;
	
	$busca_av = "";
	
	$p = new pagination('paginacao');
	$p->Items($total);
	$p->limit($lpp);
	$p->currentPage($pagina);
	$p->nextLabel('');
	$p->prevLabel('');
	$tpl->assignGlobal('paginacao',$p-> show());
	
	//QUERY DO MYSQL
	$sql .= " LIMIT $inicio, $lpp";
	$rs = mysql_query($sql);
	
	//RESULTADOS-----------------------------------
	//SE RETORNOU ALGO, CRIA A LISTA DE PUBLICAÇÕES
	//include_once('../adm/_niveis.php');
	if(mysql_num_rows($rs) || $disparabusca == 'ok'){
		//SE NÃO ACHOU NADA EM CASO DE BUSCA
		if(mysql_num_rows($rs) == 0 && $disparabusca == 'ok'){
			session_register('MSG');
			$_SESSION['MSG'] = "Não foram encontrados avisos correspondentes à sua busca.";
			
			header("location:avisos.php");
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
			
			$tpl->assign('bg','fundoListaBranco');
			
			if($sortColor % 2 == 0){
				$tpl->assign('bg','fundoListaCor');
			}
			
			$sortColor++;
			
			$tpl->assign('aviso',$rsDados['aviso']);
			$tpl->assign('dataaviso',dataBR($rsDados['dataaviso']));
			$tpl->assign('horaaviso', $rsDados['horaaviso']);
	
			$tpl->assign('idaviso',$rsDados['idaviso']);
			$tpl->assign('pagina',$pagina);
			
			if ($rsDados['ativo'] == 1){
				$tpl->assign('check','win8/checked.jpg');
				$tpl->assign('statusativo','1');
			}else{
				$tpl->assign('check','win8/unchecked.jpg');
				$tpl->assign('statusativo','0');
			}
			
			if ($rsDados['patrocinado'] == 1){
				$tpl->assign('checkpatrocinado','win8/checked.jpg');
				$tpl->assign('statusativopatrocinado','1');
			}else{
				$tpl->assign('checkpatrocinado','win8/unchecked.jpg');
				$tpl->assign('statusativopatrocinado','0');
			}			
		}
	}else{
		$tpl-> newBlock('VAZIO'); //NENHUM REGISTRO ENCONTRADO
	}
}
//---------------------------------------------

if(session_is_registered('INSERIDO')){
	$tpl->assignGlobal('mensagem','alert("Aviso inserido com sucesso!");');
	session_unregister('INSERIDO');
}

$tpl->printToScreen();
?>