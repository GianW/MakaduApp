<?php
include_once('../../incs/conn.php');
include_once("../../incs/session.php");
include_once('../../incs/funcoes.php');
include_once('../../fckeditor/fckeditor.php');
include_once('../../incs/class.TemplatePower.inc.php');

$modelo = 'perguntas_edit.htm';
$tpl = new TemplatePower('../adm/_adm_estrutura.htm');
$tpl->assignInclude('CONTEUDO',$modelo);
$tpl->prepare();

include_once('../../incs/permissoes.php');
include_once('../../incs/menu.php');

//ATRIBUINDO AÇÃO, TIPOS E DATA DE HOJE NO CAMPO DATA
$tpl->assignGlobal('nomeLogin', $_SESSION['NOME']);

//---------------------------------------------------------------------------------------------
//INSERÇÃO-------------------------------------------------------------------------------------
if($acao == 'ins'){	
	$tpl->assignGlobal('acao', 'ins');
	$tpl->assignGlobal('acaotitulo', 'inserção');
	$tpl->assignGlobal('data', date('d/m/Y'));
	$tpl->assignGlobal('idevento',$idevento);
	$tpl->assignGlobal('idprogramacao',$idprogramacao);
	
	//PROGRAMAS
	$sqlPl = "SELECT idprogramacao, dataprograma, horainicio, titulo FROM programacao
			  WHERE idevento = '$idevento'
			  AND perguntas = '1'
			  ORDER BY dataprograma, horainicio";
	$rsPl = mysql_query($sqlPl);
		
	if(mysql_num_rows($rsPl)){
		while($rsDadosPl = mysql_fetch_array($rsPl)){
			$tpl->newBlock('PROGRAMACAO');
			$tpl->assign('idprogramacao', $rsDadosPl['idprogramacao']);	
			$tpl->assign('titulo', dataBR($rsDadosPl['dataprograma']).' - '.$rsDadosPl['horainicio'].' - '.$rsDadosPl['titulo']);
		}
	}	
}

//---------------------------------------------------------------------------------------------
//EDIÇÃO---------------------------------------------------------------------------------------
if($acao == 'atu'){	
	$tpl->assignGlobal('edicao','<input name="id" type="hidden" id="id" value="'.$idpergunta.'">');
	$tpl->assignGlobal('idpergunta',$idpergunta);
	$tpl->assignGlobal('idevento',$idevento);
	$tpl->assignGlobal('idprogramacao',$idprogramacao);
	$tpl->assignGlobal('acao', 'atu');
	$tpl->assignGlobal('acaotitulo', 'edição');
	
	$sql = "SELECT * FROM perguntas WHERE idpergunta = '$idpergunta'";
	$rs = mysql_query($sql) or die(mysql_error());

	if($rsDados = mysql_fetch_array($rs)){
		$tpl->assign('pergunta',$rsDados['pergunta']);								
	}
	
	//PROGRAMAS
	$sqlPl = "SELECT idprogramacao, dataprograma, horainicio, titulo FROM programacao
			  WHERE idevento = '$idevento'
			  AND perguntas = '1'
			  ORDER BY dataprograma, horainicio";
	$rsPl = mysql_query($sqlPl);
		
	if(mysql_num_rows($rsPl)){
		while($rsDadosPl = mysql_fetch_array($rsPl)){
			$tpl->newBlock('PROGRAMACAO');
			$tpl->assign('idprogramacao', $rsDadosPl['idprogramacao']);	
			$tpl->assign('titulo', dataBR($rsDadosPl['dataprograma']).' - '.$rsDadosPl['horainicio'].' - '.$rsDadosPl['titulo']);
			if($rsDadosPl['idprogramacao'] == $rsDados['idprogramacao']){
				$tpl->assign('sel','selected="selected"');
			}
		}
	}	
}

$tpl->printToScreen();
?>