<?php
include_once('../../incs/conn.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/class.TemplatePower.inc.php');

$tpl = new TemplatePower('popup.html');
$tpl->prepare();

include_once('../../incs/permissoes.php');
include_once('../../incs/menu.php');

$sql = "SELECT idevento, nomeevento FROM eventos WHERE ativo = '1' ORDER BY datainicio DESC";
$rs = mysql_query($sql);

if(mysql_num_rows($rs)){
	while($rsDados = mysql_fetch_array($rs)){
		$tpl->newBlock('EVENTO');
		$tpl->assign('idevento', $rsDados['idevento']);
		$tpl->assign('nomeevento', $rsDados['nomeevento']);
	}
}

$tpl->printToScreen();
?>