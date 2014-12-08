<?php
switch($_SESSION['NIVEL']){
	case '1':
		$tpl->newBlock('RELATORIOSCIMA');
		$tpl->newBlock('RELATORIOSBAIXO');
		$tpl->newBlock('MULTIPLOSCIMA');
		$tpl->newBlock('MULTIPLOSBAIXO');
		
		$tpl->newBlock('NEWSLETTER');
		$tpl->newBlock('CONFIGURACOESTOPO');
		$tpl->newBlock('ADMINSITRADORES');
		$tpl->newBlock('CONFIGURACOES');
		$tpl->newBlock('CARTOES');
		$tpl->gotoBlock('_ROOT');
	break;
	case '2':
		$tpl->newBlock('RELATORIOSCIMA');
		$tpl->newBlock('RELATORIOSBAIXO');
		$tpl->newBlock('MULTIPLOSCIMA');
		$tpl->newBlock('MULTIPLOSBAIXO');
		$tpl->gotoBlock('_ROOT');
	break;
	case '3':
		$tpl->newBlock('RELATORIOSCIMA');
		$tpl->newBlock('RELATORIOSBAIXO');
		$tpl->gotoBlock('_ROOT');
		$tpl->assignGlobal('mostraFerramentas','none');
	break;	
	case '5':
		$tpl->assignGlobal('mostraFerramentas','none');
	break;	
}
?>