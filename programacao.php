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
	$tpl = new TemplatePower('programacao.html');
	$tpl->prepare();
	
	$sql = "SELECT * FROM eventos WHERE idevento = '$idevento'";
	$rs = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($rs)){
		while($rsDados = mysql_fetch_array($rs)){
			$tpl->assign('nomeevento', $rsDados['nomeevento']);
			$tpl->assign('local', $rsDados['local']);
			$tpl->assign('endereco', $rsDados['endereco']);
			$tpl->assign('cidade', $rsDados['cidade']);
			$tpl->assign('estado', $rsDados['estado']);
			$tpl->assign('datainicio', dataBR($rsDados['datainicio']));
			if($rsDados['datafim']){
				$tpl->assign('datafim', ' a '.dataBR($rsDados['datafim']));
			}
		}
	}	
	
	$sql = "SELECT * FROM programacao WHERE idevento = '$idevento' AND ativo = '1' ORDER BY dataprograma ASC, horainicio ASC";
	$rs = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($rs)){
		
		$dataAtual = "0000-00-00";
		$horaAtual = "00";
		$qtd = 0;
		
		while($rsDados = mysql_fetch_array($rs)){
			$qtd += 1;
			if($dataAtual != $rsDados['dataprograma']){
				$tpl->newBlock('DIA');
				$tpl->assign('data', diaSemanaComp($rsDados['dataprograma']).", ".dataBR($rsDados['dataprograma']));
				$dataAtual = $rsDados['dataprograma'];
				$horaAtual = "00";
			}
							
			if($horaAtual != date('G',strtotime($rsDados['horainicio']))){				
				$tpl->newBlock('HORA');
				
				$tpl->assign('hora', date('G',strtotime($rsDados['horainicio']))."h");
				$tpl->assign('data', str_replace('-','',$rsDados['dataprograma']));
				$horaAtual = date('G',strtotime($rsDados['horainicio']));
				
				$tpl->newBlock('VAR');
				$tpl->assign('horaid', date('G',strtotime($rsDados['horainicio']))."h");
				$tpl->assign('data', str_replace('-','',$rsDados['dataprograma']));	
				$tpl->assign('pos', $qtd);				
			}else{
				$tpl->newBlock('RISCO');
			}	
			
			$tpl->newBlock('PROGRAMA');	
			$tpl->assign('titulo', $rsDados['titulo']);
			$tpl->assign('idprogramacao', $rsDados['idprogramacao']);
			if($rsDados['localprograma']){
				$tpl->assign('localprograma', $rsDados['localprograma'].' -');
			}
			$tpl->assign('dataprograma',dataBR($rsDados['dataprograma']));
			$tpl->assign('horainicio', date('G:i',strtotime($rsDados['horainicio'])));
			if($rsDados['horafim'] && $rsDados['horainicio'] != '00:00:00'){
				$tpl->assign('horafim', 'às '.date('G:i',strtotime($rsDados['horafim'])));
			}
			
			$sqlPls = "SELECT l.nome FROM login l
					   INNER JOIN relprogpal rpp
					   ON rpp.idpalestrante = l.id
					   WHERE rpp.idprogramacao = '".$rsDados['idprogramacao']."'";
			$rsPls = mysql_query($sqlPls);
			if(mysql_num_rows($rsPls)){
				$tpl->newBlock('BREAK');
				while($rsDadosPls = mysql_fetch_array($rsPls)){
					$tpl->newBlock('PALESTRANTE');
					$tpl->assign('nome', $rsDadosPls['nome']);	
				}
			}					
		}
		
		$tpl->assignGlobal('qtd', $qtd);
	}
	
	$sql = "SELECT * FROM programacao WHERE idevento = '$idevento' AND ativo = '1' ORDER BY dataprograma ASC, horainicio ASC";
	$rs = mysql_query($sql) or die(mysql_error());
	
	if(mysql_num_rows($rs)){
		
		$dataAtual = "0000-00-00";
		$horaAtual = "00";
		$tamanho = 0;
		$diferenca = 0;
		$qtd = 0;
		
		while($rsDados = mysql_fetch_array($rs)){
			if($dataAtual != $rsDados['dataprograma']){
				$tpl->newBlock('NOVODIA');
				$tpl->assign('dia', diaSemana($rsDados['dataprograma'])." ".date('d',strtotime($rsDados['dataprograma'])));
				$dataAtual = $rsDados['dataprograma'];
				$tamanho += 75;
				$diferenca += 75;
			}
			if($horaAtual != date('G',strtotime($rsDados['horainicio']))){
				$tamanho += 55;
				$qtd += 1;
								
				$tpl->newBlock('NOVAHORA');
				$tpl->assign('horaid', date('G',strtotime($rsDados['horainicio']))."h");
				$tpl->assign('hora', date('G',strtotime($rsDados['horainicio'])));
				$tpl->assign('data', str_replace('-','',$rsDados['dataprograma']));
				$tpl->assign('pos', $qtd);	
				$horaAtual = date('G',strtotime($rsDados['horainicio']));
				
				$tpl->newBlock('VAR');
				$tpl->assign('horaid', date('G',strtotime($rsDados['horainicio']))."h");
				$tpl->assign('data', str_replace('-','',$rsDados['dataprograma']));	
				$tpl->assign('pos', $qtd);			
			}
		}
		
		$tpl->assignGlobal('diferenca', $diferenca);
		$tpl->assignGlobal('tamanho', $tamanho);
		$tpl->assignGlobal('qtd', $qtd);
	}	
	
	$tpl->printToScreen();
//}
?>