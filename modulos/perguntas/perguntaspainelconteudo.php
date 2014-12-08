<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/class.TemplatePower.inc.php');
include_once('../../incs/pagination.class.php');

$idevento = $_POST['idevento'];

$tpl = new TemplatePower('perguntaspainelconteudo.htm');
$tpl->prepare();

//PEGA ULTIMO ID CARREGADO
$sql = "SELECT * FROM perguntasrefresh WHERE idevento = '$idevento' ORDER BY id DESC";
$rs = mysql_query($sql);
if(mysql_num_rows($rs)){
	$ultimoid = mysql_result($rs, 0, 'idpergunta');
}else{
	$ultimoid = 0;
}
$ultimoid = (int)$ultimoid;

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
$sql .=	"AND pt.idpergunta > '$ultimoid'
		ORDER BY pt.idpergunta DESC";
$rs = mysql_query($sql);

if(mysql_num_rows($rs)){
	while($rsDados = mysql_fetch_array($rs)){
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
		
		$idpergunta = $rsDados['idpergunta'];
	}
	$sqlIns = "INSERT INTO perguntasrefresh (idpergunta, idevento) VALUES ('$idpergunta', '$idevento')";
	$rsIns = mysql_query($sqlIns) or die(mysql_error());
}
	

$tpl->printToScreen();
?>