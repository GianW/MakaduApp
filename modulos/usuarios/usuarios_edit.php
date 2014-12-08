<?php
include_once('../../incs/conn.php');
include_once("../../incs/session.php");
include_once('../../incs/funcoes.php');
include_once('../../fckeditor/fckeditor.php');
include_once('../../incs/class.TemplatePower.inc.php');

$modelo = 'usuarios_edit.htm';
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
	
	//INICIA FOTO
	$tpl->newBlock('FOTO');
}

//---------------------------------------------------------------------------------------------
//EDIÇÃO---------------------------------------------------------------------------------------
if($acao == 'atu'){	
	$tpl->assignGlobal('edicao','<input name="id" type="hidden" id="id" value="'.$id.'">');
	$tpl->assignGlobal('id',$id);
	$tpl->assignGlobal('acao', 'atu');
	$tpl->assignGlobal('acaotitulo', 'edição');
	
	$sql = "SELECT * FROM login WHERE id = '$id'";
	$rs = mysql_query($sql) or die(mysql_error());

	if($rsDados = mysql_fetch_array($rs)){
		$tpl->assign('data',dataBR($rsDados['data']));
		$tpl->assign('nome',$rsDados['nome']);
		$tpl->assign('email',$rsDados['email']);
		$tpl->assign('obs',$rsDados['obs']);
		
		if($rsDados['palestrante'] == '1'){
			$tpl->assign('chkpls','checked');
		}
		
		if($rsDados['administrador'] == '1'){
			$tpl->assign('chkadm','checked');
		}		
		
		//FOTO
		$tpl->newBlock('FOTO');
		if($rsDados['img'] != ''){
			$rand = rand(0, 10000);
			$tpl->newBlock('FOTO_EDIT');
			$tpl->assign('caminho','../../uploads/usuarios/m_'.$rsDados['img'].'?atu='.$rand);
		}						
	}
}

$tpl->printToScreen();
?>