<?php
include_once('../../incs/conn.php');
include_once("../../incs/session.php");
include_once('../../incs/funcoes.php');
include_once('../../fckeditor/fckeditor.php');
include_once('../../incs/class.TemplatePower.inc.php');

$modelo = 'eventos_edit.htm';
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
	$tpl->newBlock('PATROCINIO');
}

//---------------------------------------------------------------------------------------------
//EDIÇÃO---------------------------------------------------------------------------------------
if($acao == 'atu'){	
	$tpl->assignGlobal('edicao','<input name="idevento" type="hidden" id="idevento" value="'.$idevento.'">');
	$tpl->assignGlobal('idevento',$idevento);
	$tpl->assignGlobal('acao', 'atu');
	$tpl->assignGlobal('acaotitulo', 'edição');
	
	$sql = "SELECT * FROM eventos WHERE idevento = '$idevento'";
	$rs = mysql_query($sql) or die(mysql_error());

	if($rsDados = mysql_fetch_array($rs)){
		$tpl->assign('datainicio',dataBR($rsDados['datainicio']));
		$tpl->assign('datafim',dataBR($rsDados['datafim']));
		$tpl->assign('nomeevento',$rsDados['nomeevento']);
		$tpl->assign('local',$rsDados['local']);
		$tpl->assign('endereco',$rsDados['endereco']);
		$tpl->assign('cidade',$rsDados['cidade']);
		$tpl->assign('release',$rsDados['texto']);
		
		switch($rsDados['estado']){
				case 'AC': $tpl->assignGlobal('estado1','selected'); break;
				case 'AL': $tpl->assignGlobal('estado2','selected'); break;
				case 'AM': $tpl->assignGlobal('estado3','selected'); break;
				case 'AP': $tpl->assignGlobal('estado4','selected'); break;
				case 'BA': $tpl->assignGlobal('estado5','selected'); break;
				case 'CE': $tpl->assignGlobal('estado6','selected'); break;
				case 'DF': $tpl->assignGlobal('estado7','selected'); break;
				case 'ES': $tpl->assignGlobal('estado8','selected'); break;
				case 'GO': $tpl->assignGlobal('estado9','selected'); break;
				case 'MA': $tpl->assignGlobal('estado10','selected'); break;
				case 'MG': $tpl->assignGlobal('estado11','selected'); break;
				case 'MS': $tpl->assignGlobal('estado12','selected'); break;
				case 'MT': $tpl->assignGlobal('estado13','selected'); break;
				case 'PA': $tpl->assignGlobal('estado14','selected'); break;
				case 'PB': $tpl->assignGlobal('estado15','selected'); break;
				case 'PE': $tpl->assignGlobal('estado16','selected'); break;
				case 'PI': $tpl->assignGlobal('estado17','selected'); break;
				case 'PR': $tpl->assignGlobal('estado18','selected'); break;
				case 'RN': $tpl->assignGlobal('estado19','selected'); break;
				case 'RS': $tpl->assignGlobal('estado20','selected'); break;
				case 'RJ': $tpl->assignGlobal('estado21','selected'); break;
				case 'RO': $tpl->assignGlobal('estado22','selected'); break;
				case 'RR': $tpl->assignGlobal('estado23','selected'); break;
				case 'SP': $tpl->assignGlobal('estado24','selected'); break;				
				case 'SC': $tpl->assignGlobal('estado25','selected'); break;
				case 'SE': $tpl->assignGlobal('estado26','selected'); break;
				case 'TO': $tpl->assignGlobal('estado27','selected'); break;
		}		
		
		//FOTO
		$tpl->newBlock('FOTO');
		if($rsDados['logotipo'] != ''){
			$rand = rand(0, 10000);
			$tpl->newBlock('FOTO_EDIT');
			$tpl->assign('caminho','../../uploads/eventos/m_'.$rsDados['logotipo'].'?atu='.$rand);
		}		
		
		//PATROCINIO
		$tpl->newBlock('PATROCINIO');
		if($rsDados['patrocinio'] != ''){
			$rand = rand(0, 10000);
			$tpl->newBlock('PATROCINIO_EDIT');
			$tpl->assign('caminho','../../uploads/eventos/m_'.$rsDados['patrocinio'].'?atu='.$rand);
		}							
	}
}

$tpl->printToScreen();
?>