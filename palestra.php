<?php
include_once('incs/conn.php');
include_once('incs/funcoes.php');
include_once('incs/class.TemplatePower.inc.php');

header ('Content-type: text/html; charset=ISO-8859-1');

$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");

//if ($iphone || $ipad || $android || $palmpre || $ipod || $berry == true) 
//{ 	
	$tpl = new TemplatePower('palestra.html');
	$tpl->prepare();
	
	$sql = "SELECT * FROM programacao WHERE idevento = '$idevento' && idprogramacao = '$idprogramacao'";
	$rs = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($rs)){		
		while($rsDados = mysql_fetch_array($rs)){
			$tpl->assign('titulo', $rsDados['titulo']);
			if($rsDados['localprograma']){
				$tpl->assign('localprograma', $rsDados['localprograma'].' - ');
			}
			$tpl->assign('dataprograma',dataBR($rsDados['dataprograma']));
			$tpl->assign('horainicio', date('G:i',strtotime($rsDados['horainicio'])));
			if($rsDados['descricao'] || $rsDados['sobrepalestrante']){
				$tpl -> newBlock('SOBREPAL');
				if($rsDados['descricao']){
					$tpl->newBlock('DESCRICAO');
					$tpl->assign('descricao', nl2br($rsDados['descricao']));	
				}
				
				$sqlPls = "SELECT l.nome FROM login l
						   INNER JOIN relprogpal rpp
						   ON rpp.idpalestrante = l.id
						   WHERE rpp.idprogramacao = '$idprogramacao'";
				$rsPls = mysql_query($sqlPls);
				if(mysql_num_rows($rsPls)){
					if(mysql_num_rows($rsPls) > 1){
						$tpl->newBlock('MULTIPLOS');
					}else{
						$tpl->newBlock('UNICO');
					}
					while($rsDadosPls = mysql_fetch_array($rsPls)){
						$tpl->newBlock('PALESTRANTE');
						$tpl->assign('nome', $rsDadosPls['nome']);	
					}
				}
				
				if($rsDados['sobrepalestrante']){
					$tpl->newBlock('SOBREPALESTRANTE');
					$tpl->assign('sobrepalestrante', nl2br($rsDados['sobrepalestrante']));	
				}
			}
			//HORA DO FIM---------------O
			
			if($rsDados['arquivos'] == '1'){
				if($rsDados['material'] != ''){
					$tpl->newBlock('ARQUIVO');
				}else{
					$tpl->newBlock('ARQUIVOQUANDO');
				}
			}
			
			if($rsDados['perguntas'] == '1'){
				$tpl->newBlock('PERGUNTAS');
				$perguntas = 1;
			}			
		}	
	}
	
	if($perguntas == 1){
		$sql = "SELECT *, p.idpergunta AS idperguntaAtual, p.data AS datapergunta FROM perguntas p
				INNER JOIN login l
				ON l.id = p.idquestionador
				WHERE p.idprogramacao = '$idprogramacao'
				AND p.ativo = '1'";
		$rs = mysql_query($sql);
		
		if(mysql_num_rows($rs)){	
			$tpl->newBlock('BLOCOPERGUNTAS');
			while($rsDados = mysql_fetch_array($rs)){
				$tpl->newBlock('APERGUNTA');
				$tpl->assign('pergunta', $rsDados['pergunta']);
				$tpl->assign('questionador', $rsDados['nome'].', '.dataBR($rsDados['datapergunta']).' às '.$rsDados['hora']);
				$tpl->assign('idpergunta', $rsDados['idperguntaAtual']);
				
				$sqlR = "SELECT r.*, l.nome FROM respostas r
						 INNER JOIN login l
						 ON l.id = r.idusuario
						 WHERE r.idpergunta = '".$rsDados['idperguntaAtual']."' 
						 ORDER BY r.data DESC, r.hora DESC";
				$rsR = mysql_query($sqlR);
				
				if(mysql_num_rows($rsR)){	
					while($rsDadosR = mysql_fetch_array($rsR)){
						$tpl->newBlock('RESPOSTA');
						$tpl->assign('resposta', $rsDadosR['resposta']);
						$tpl->assign('pessoa', $rsDadosR['nome'].', '.dataBR($rsDadosR['data']).' às '.$rsDadosR['hora']);
					}
				}
				
				$tpl->newBlock('RESPONDER');
				$tpl->assign('idpergunta', $rsDados['idperguntaAtual']);
			}
		}
	}
	
	$tpl->printToScreen();
//}
?>