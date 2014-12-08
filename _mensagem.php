<?php
include_once('incs/conn.php');
include_once('incs/funcoes.php');
include_once('incs/class.TemplatePower.inc.php');

$tpl = new TemplatePower('_mensagem.html');
$tpl->prepare();

if(isset($idmsg) && $idmsg != ''){
	$sql = "SELECT * FROM publicacoes 
			WHERE id = '$idmsg'";
	$rs = mysql_query($sql);
	if(mysql_num_rows($rs)){
		while($rsDados = mysql_fetch_array($rs)){	
			if($usa_permalink == true){
				$tpl->assignGlobal('mensagem',$URLsite.'site/'.$rsDados['permalink']);
			}else{
				$tpl->assignGlobal('mensagem',$rsDados['titulo']);
			}
		}
	}
	$tpl->assignGlobal('largura','700');
}elseif(isset($tipomsg) && $tipomsg != ''){
	switch($tipomsg){
		case '1': $tpl->assignGlobal('mensagem',utf8_encode('Imagem de capa muito pequena para constar no banner. Adicione uma imagem mais larga (mínimo 680 pixel de largura), ou retire a publicação do destaque.')); break;
		case '2': $tpl->assignGlobal('largura','700'); $tpl->assignGlobal('mensagem',utf8_encode('<br /><div style="text-align:left; color:#FFFFFF; font-weight:none; font-size:12px;">Nome: Clique no nome para visualizar informações rápidas.<br /><br/><hr noshade /><br/>Funções Partidárias: As funções partidárias estão ordenadas por prioridade dos cargos em caso de duas ou mais funções.<br /><br/><hr noshade /><br/>Arquivo: Clique para visualizar e editar antigas funções partidárias do usuário.<br /><br/><hr noshade /><br/>Cidade: Clique no nome da cidade para visualizá-la no mapa.<br /><br/><hr noshade /><br/>E-Mail: Clique no e-mail para enviar uma mensagem ao usuário.<br /><br/><hr noshade /><br/>Telefone: Será mostrado na lista o celular, caso esteja cadastrado, senão o número comercial, senão o número residencial. Para lista completa de telefones, clique no nome do usuário ou no botão editar.<br /><br/><hr noshade /><br/>Ativo: Usuários não ativos não receberão e-mails da newsletter nem terão suas etiquetas impressas.</div><br />')); break;
	}
}else{
	session_start();
	$mensagem = $_SESSION['MSG'];
	$tpl->assignGlobal('mensagem',$mensagem);	
	session_unregister('MSG');
	$tpl->assignGlobal('largura','400');
}

$tpl->printToScreen();
?>