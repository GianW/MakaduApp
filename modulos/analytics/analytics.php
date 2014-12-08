<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/class.TemplatePower.inc.php');
include_once('../../incs/pagination.class.php');

$modelo = 'analytics.htm';
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

if(!isset($idevento) || $idevento == '' || $idevento == '#'){
	
	//SE AINDA NÃO TEM EVENTO SELECIONADO
	$tpl->newBlock('POPUP');
	
}else{
	$tpl->newBlock('ANALYTICS');
	
	//NOME DO EVENTO
	$tpl->assignGlobal('idevento',$idevento);
	$sqlEv = "SELECT nomeevento FROM eventos WHERE idevento = '$idevento'";
	$rsEv = mysql_query($sqlEv);
	$tpl->assignGlobal('nomeevento', mysql_result($rsEv, 0, 'nomeevento'));	
	
	//Acessou o App
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'app'";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd1', mysql_num_rows($rs));
	
	//Acessou Eventos
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'eventos'";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd2', mysql_num_rows($rs));
	$numeventos = mysql_num_rows($rs);
	
	//Acessou Perfil
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'perfil'";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd3', mysql_num_rows($rs));
	$numperfil = mysql_num_rows($rs);
	
	//Abriu Cadastro
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'abriu' AND secao = 'cadastro'";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd4', mysql_num_rows($rs));	
	
	//Cadastrou Usuário
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'cadastrou' AND secao = 'usuario'";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd5', mysql_num_rows($rs));	
	
	//Editou Perfil
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'editou' AND secao = 'perfil'";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd6', mysql_num_rows($rs));
	
	//NUMEROS EVENTO
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'evento'";
	$rs = mysql_query($sql) or die(mysql_error());
	$numevento = mysql_num_rows($rs);	
	
	//NUMEROS PROGRAMACAO
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'programacao'";
	$rs = mysql_query($sql) or die(mysql_error());
	$numprogramacao = mysql_num_rows($rs);	
	
	//NUMEROS AVISOS
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'avisos'";
	$rs = mysql_query($sql) or die(mysql_error());
	$numavisos = mysql_num_rows($rs);	
	
	$total = $numeventos + $numperfil + $numevento + $numprogramacao + $numavisos;

	$tpl->assignGlobal('pct1', number_format(($numeventos * 100) / $total, 2));
	$tpl->assignGlobal('pct2', number_format(($numevento * 100) / $total, 2));
	$tpl->assignGlobal('pct3', number_format(($numprogramacao * 100) / $total, 2));
	$tpl->assignGlobal('pct4', number_format(($numavisos * 100) / $total, 2));
	$tpl->assignGlobal('pct5', number_format(($numperfil * 100) / $total, 2));
	
	//----------------------------------------------------------------------------------	
	
	//PROGRAMAS MAIS ACESSADOS
	$sql = "SELECT idlog, idprogramacao, COUNT(idlog) AS numeros FROM analytics 
			WHERE tipo = 'acessou' 
			AND secao = 'programa' 
			AND idevento = '$idevento' 
			GROUP BY idprogramacao 
			ORDER BY numeros DESC";
	$rs = mysql_query($sql) or die(mysql_error());
	
	$sortColor = 1;
	if(mysql_num_rows($rs)){
		while($rsDados = mysql_fetch_array($rs)){
			$idprogramacaoQtd = $rsDados['idprogramacao'];
			$sqlProgQtd = "SELECT * FROM programacao WHERE idprogramacao = '$idprogramacaoQtd'";
			$rsProgQtd = mysql_query($sqlProgQtd);
			
			if(mysql_num_rows($rsProgQtd)){
				while($rsDadosProgQtd = mysql_fetch_array($rsProgQtd)){			
					$tpl->newBlock('QTDPROGRAMA');
					$tpl->assign('titulo', $rsDadosProgQtd['titulo']);
					$tpl->assign('qtdpr', $rsDados['numeros']);
					
					$tpl->assign('bg','fundoListaCor');
					
					if($sortColor % 2 == 0){
						$tpl->assign('bg','fundoListaBranco');
					}
					
					$sortColor++;				
					
					//Abriu "Sobre a Palestra"
					$sqlEsp = "SELECT idlog FROM analytics WHERE tipo = 'abriu' AND secao = 'sobre esta palestra' AND idprogramacao = '$idprogramacaoQtd'";
					$rsEsp = mysql_query($sqlEsp) or die(mysql_error());
					$tpl->assign('qtdsp', mysql_num_rows($rsEsp));	
					
					//Enviou pergunta
					$sqlEsp = "SELECT idlog FROM analytics WHERE tipo = 'enviou' AND secao = 'pergunta' AND idprogramacao = '$idprogramacaoQtd'";
					$rsEsp = mysql_query($sqlEsp) or die(mysql_error());
					$tpl->assign('qtdep', mysql_num_rows($rsEsp));	
					
					//Baixou Material
					$sqlEsp = "SELECT idlog FROM analytics WHERE tipo = 'baixou' AND secao = 'material' AND idprogramacao = '$idprogramacaoQtd'";
					$rsEsp = mysql_query($sqlEsp) or die(mysql_error());
					$tpl->assign('qtdbm', mysql_num_rows($rsEsp));	
					
					//Agendou Material
					$sqlEsp = "SELECT idlog FROM analytics WHERE tipo = 'agendou' AND secao = 'material' AND idprogramacao = '$idprogramacaoQtd'";
					$rsEsp = mysql_query($sqlEsp) or die(mysql_error());
					$tpl->assign('qtdam', mysql_num_rows($rsEsp));																									
				}
			}
		}
	}	
	
	//Acessou o Evento
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'evento' AND idevento = '$idevento'";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd7', mysql_num_rows($rs));
	
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'evento' AND idevento = '$idevento' AND iduser <> '0' GROUP BY token";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd72', mysql_num_rows($rs));	
	
	//Seguiu Evento
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'seguiu' AND secao = 'evento' AND idevento = '$idevento'";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd8', mysql_num_rows($rs));
	
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'seguiu' AND secao = 'evento' AND idevento = '$idevento' AND iduser <> '0' GROUP BY token";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd82', mysql_num_rows($rs));	
	
	//Acessou Programação
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'programacao' AND idevento = '$idevento'";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd9', mysql_num_rows($rs));
	
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'programacao' AND idevento = '$idevento' AND iduser <> '0' GROUP BY token";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd92', mysql_num_rows($rs));	
	
	//Acessou Avisos
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'avisos' AND idevento = '$idevento'";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd10', mysql_num_rows($rs));
	
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'avisos' AND idevento = '$idevento' AND iduser <> '0' GROUP BY token";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd102', mysql_num_rows($rs));		
	
	//Acessou Perguntas da Capa
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'pergunta de capa' AND idevento = '$idevento'";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd11', mysql_num_rows($rs));	
	
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'pergunta de capa' AND idevento = '$idevento' AND iduser <> '0' GROUP BY token";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd112', mysql_num_rows($rs));		
	
	//Acessou Downloads da Capa
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'download de capa' AND idevento = '$idevento'";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd12', mysql_num_rows($rs));	
	
	$sql = "SELECT idlog FROM analytics WHERE tipo = 'acessou' AND secao = 'download de capa' AND idevento = '$idevento' AND iduser <> '0' GROUP BY token";
	$rs = mysql_query($sql) or die(mysql_error());
	$tpl->assignGlobal('qtd122', mysql_num_rows($rs));	
	
	//----------------------------------------------------------------------------------	
	
	$sql = "SELECT idprogramacao, COUNT(idlog) AS numeros 
			FROM analytics 
			WHERE idevento = '$idevento' 
			AND idprogramacao <> '0' 
			GROUP BY idprogramacao
			ORDER BY numeros DESC";
	$rs = mysql_query($sql);
	
	if(mysql_num_rows($rs)){
		while($rsDados = mysql_fetch_array($rs)){
			$idprogramacao = $rsDados['idprogramacao'];
			$sqlProg = "SELECT pg.titulo FROM programacao pg
						INNER JOIN perguntas pt
						ON pt.idprogramacao = pg.idprogramacao
						WHERE pg.idprogramacao = '$idprogramacao'
						GROUP BY pg.idprogramacao";
			$rsProg = mysql_query($sqlProg);
			
			if(mysql_num_rows($rsProg)){
				$tpl->newblock('PROGRAMA');	
				while($rsDadosProg = mysql_fetch_array($rsProg)){
					$tpl->assign('titulo', $rsDadosProg['titulo']);
					$sqlPr = "SELECT idpergunta, pergunta FROM perguntas WHERE idprogramacao = '$idprogramacao' AND ativo = '1'";
					$rsPr = mysql_query($sqlPr);
					if(mysql_num_rows($rsPr)){
						while($rsDadosPr = mysql_fetch_array($rsPr)){
							$tpl->newblock('PERGUNTA');	
							$idpergunta	= $rsDadosPr['idpergunta'];
							$tpl->assign('pergunta', $rsDadosPr['pergunta']);
							
							//Abriu Respostas da Pergunta
							$sql = "SELECT idlog FROM analytics WHERE tipo = 'abriu' AND secao = 'resposta' AND idpergunta = '$idpergunta'";
							$rs = mysql_query($sql) or die(mysql_error());
							$tpl->assign('abriurespostas', mysql_num_rows($rs));	
							
							//Enviou Resposta
							$sql = "SELECT idlog FROM analytics WHERE tipo = 'respondeu' AND secao = 'pergunta' AND idpergunta = '$idpergunta'";
							$rs = mysql_query($sql) or die(mysql_error());
							$tpl->assign('enviouresposta', mysql_num_rows($rs));								
						}
					}
				}
			}
		}
	}

}

$tpl->printToScreen();
?>