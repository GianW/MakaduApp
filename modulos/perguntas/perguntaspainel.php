<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/class.TemplatePower.inc.php');
include_once('../../incs/pagination.class.php');

$modelo = 'perguntaspainel.htm';
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

$tpl->assignGlobal('idevento', $idevento);
if(isset($idprogramacao) && $idprogramacao != '' && $idprogramacao != '0'){
	$tpl->assignGlobal('idprogramacao', $idprogramacao);
}else{
	$tpl->assignGlobal('idprogramacao', '0');	
}

//LISTA DE PROGRAMAS
$sql = "SELECT * FROM programacao WHERE idevento = '$idevento' ORDER BY dataprograma ASC, horainicio ASC";
$rs = mysql_query($sql);

if(mysql_num_rows($rs)){
	while($rsDados = mysql_fetch_array($rs)){
		$tpl->newBlock('PROGRAMACAO');
		$tpl->assign('titulo', $rsDados['titulo']);
		$tpl->assign('idprogramacao', $rsDados['idprogramacao']);
		if($rsDados['idprogramacao'] == $idprogramacao){
			$tpl->assign('sel','selected');
		}
	}
}

//VE SE TEM UMA NOVA PERGUNTA PARA CARREGAR
$sql = "SELECT *, 
			   pt.data AS dataFinal, 
			   pt.hora AS horaFinal,
			   pt.ativo AS ativoFinal 
		FROM perguntas pt 
		INNER JOIN programacao pr
		ON pr.idprogramacao = pt.idprogramacao
		INNER JOIN login l
		ON l.id = pt.idquestionador
		WHERE pr.idevento = '$idevento' ";
if(isset($idprogramacao) && $idprogramacao != '' && $idprogramacao != '0'){
$sql .=	"AND pr.idprogramacao = '$idprogramacao' ";
}
$sql .=	"ORDER BY pt.idpergunta DESC";
$rs = mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($rs)){
	$primeira = 0;
	while($rsDados = mysql_fetch_array($rs)){
		if($primeira == 0){
			$primeira = 1;
			$idpergunta = $rsDados['idpergunta'];
			$sqlIns = "INSERT INTO perguntasrefresh (idpergunta, idevento) VALUES ('$idpergunta', '$idevento')";
			$rsIns = mysql_query($sqlIns) or die(mysql_error());			
		}
		$tpl->newBlock('PERGUNTA');
		$tpl->assign('pergunta', $rsDados['pergunta']);	
		$tpl->assign('titulo',$rsDados['titulo']);
		$tpl->assign('questionador',$rsDados['nome']);
		$tpl->assign('data',dataBR($rsDados['dataFinal']));
		$tpl->assign('hora', $rsDados['horaFinal']);
		$tpl->assign('idpergunta', $rsDados['idpergunta']);
		
		if ($rsDados['ativoFinal'] == 1){
			$tpl->assign('check','win8/checked.jpg');
			$tpl->assign('statusativo','1');
		}else{
			$tpl->assign('check','win8/unchecked.jpg');
			$tpl->assign('statusativo','0');
		}		
	}
}

$tpl->printToScreen();
?>