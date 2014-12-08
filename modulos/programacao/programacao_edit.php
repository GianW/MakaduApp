<?php
include_once('../../incs/conn.php');
include_once("../../incs/session.php");
include_once('../../incs/funcoes.php');
include_once('../../fckeditor/fckeditor.php');
include_once('../../incs/class.TemplatePower.inc.php');

$modelo = 'programacao_edit.htm';
$tpl = new TemplatePower('../adm/_adm_estrutura.htm');
$tpl->assignInclude('CONTEUDO',$modelo);
$tpl->prepare();

include_once('../../incs/permissoes.php');
include_once('../../incs/menu.php');

//ATRIBUINDO AÇÃO, TIPOS E DATA DE HOJE NO CAMPO DATA
$tpl->assignGlobal('nomeLogin', $_SESSION['NOME']);

$tpl->assignGlobal('idevento',$idevento);
$sqlEv = "SELECT nomeevento FROM eventos WHERE idevento = '$idevento'";
$rsEv = mysql_query($sqlEv);
if(mysql_num_rows($rsEv)){
	$tpl->assignGlobal('nomeevento', mysql_result($rsEv, 0, 'nomeevento'));	
}

//---------------------------------------------------------------------------------------------
//INSERÇÃO-------------------------------------------------------------------------------------
if($acao == 'ins'){	
	$tpl->assignGlobal('acao', 'ins');
	$tpl->assignGlobal('acaotitulo', 'inserção');
	
	$sqlPl = "SELECT id, nome FROM login
			  WHERE palestrante = '1'
			  ORDER BY nome ASC";
	$rsPl = mysql_query($sqlPl);
	
	$tpl->assign('chk1', 'checked="checked"');
	$tpl->assign('chk3', 'checked="checked"');
	$tpl->assign('chk4', 'checked="checked"');
	
	//PALESTRANTES
	if(mysql_num_rows($rsPl)){
		while($rsDadosPl = mysql_fetch_array($rsPl)){
			$tpl->newBlock('PALESTRANTE');
			$tpl->assign('id', $rsDadosPl['id']);	
			$tpl->assign('nome', $rsDadosPl['nome']);
		}
	}
	
	//INICIA FOTO
	$tpl->newBlock('FOTO');
	
	//INICIA ARQUIVO
	$tpl->newBlock('ARQUIVO');
}

//---------------------------------------------------------------------------------------------
//EDIÇÃO---------------------------------------------------------------------------------------
if($acao == 'atu'){	
	$tpl->assignGlobal('edicao','<input name="idprogramacao" type="hidden" id="idprogramacao" value="'.$idprogramacao.'">');
	$tpl->assignGlobal('idevento',$idevento);
	$tpl->assignGlobal('acao', 'atu');
	$tpl->assignGlobal('acaotitulo', 'edição');
	
	$sql = "SELECT * FROM programacao WHERE idprogramacao = '$idprogramacao'";
	$rs = mysql_query($sql) or die(mysql_error());

	if($rsDados = mysql_fetch_array($rs)){
		$tpl->assign('horainicio',$rsDados['horainicio']);
		$tpl->assign('horafim',$rsDados['horafim']);
		$tpl->assign('dataprograma',dataBR($rsDados['dataprograma']));
		$tpl->assign('titulo',$rsDados['titulo']);
		$tpl->assign('localprograma',$rsDados['localprograma']);
		$tpl->assign('sobrepalestrante',$rsDados['sobrepalestrante']);
		$tpl->assign('descricao',$rsDados['descricao']);
		
		if($rsDados['perguntas'] == '1'){
			$tpl->assign('chk1', 'checked="checked"');
		}
		
		if($rsDados['sopalestrante'] == '1'){
			$tpl->assign('chk2', 'checked="checked"');
		}
		
		if($rsDados['palestra'] == '1'){
			$tpl->assign('chk3', 'checked="checked"');
		}
		
		if($rsDados['arquivos'] == '1'){
			$tpl->assign('chk4', 'checked="checked"');
		}						
		
		//PALESTRANTES
		$sqlC = mysql_query("SELECT * FROM login
							 WHERE palestrante = '1'
							 ORDER BY nome ASC");

		while( $rC = mysql_fetch_array($sqlC) ) {
			$tpl-> newBlock('PALESTRANTE');
			
			$id = $rC['id'];
			
			$sqlRel = mysql_query("SELECT * FROM relprogpal rpp
								   INNER JOIN login l
								   ON l.id = rpp.idpalestrante
								   WHERE rpp.idpalestrante = '$id'
								   AND rpp.idprogramacao = '$idprogramacao'");
			
			if(mysql_num_rows($sqlRel)){
				$tpl->assign('sel','selected="selected"');
			}
								
			$tpl->assign('id',$rC['id']);
			$tpl->assign('nome',$rC['nome']);
		}		
		
		//FOTO
		$tpl->newBlock('FOTO');
		if($rsDados['foto'] != ''){
			$rand = rand(0, 10000);
			$tpl->newBlock('FOTO_EDIT');
			$tpl->assign('caminho','../../uploads/programacao/m_'.$rsDados['foto'].'?atu='.$rand);
		}	
		
		//ARQUIVO
		$tpl->newBlock('ARQUIVO');
		if($rsDados['material'] != ''){
			$tpl->newBlock('ARQUIVO_EDIT');
			$tpl->assign('linkarquivo','../../uploads/programacao/'.$rsDados['material']);
		}							
	}
}

$tpl->printToScreen();
?>