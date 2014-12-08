<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/inc.imgs.php');
include_once('../../incs/class.date.php');

//COMEÇO DAS AÇÕES
if(isset($acao) && $acao != ''){	
	
	$datalog = date('Y-m-d');   
	$horalog = date('H:i:s');
		
	switch($acao){
		//INSERÇÃO------------------------------------------------------------------------------------------------------------------------------------------------
		case 'ins':
			$resposta = limpaStr($resposta);
						
			$sql = "INSERT INTO respostas (idpergunta,
										   resposta,
										   idusuario,
										   data,
										   hora) VALUES ('$idpergunta',
														  '$resposta',
														  '".$_SESSION['ID']."',
														  '$datalog',
														  '$horalog')";
			$rs = mysql_query($sql) or die(mysql_error());
			
			session_register('MSG');
			$_SESSION['MSG'] = "Resposta inserida com sucesso.";	
			
			//LOG	
/*			$sqlLog = "INSERT INTO fl_log
								   (idusuario,
								   data,
								   hora,
								   acao,
								   titulo,
								   secao) VALUES ('".$_SESSION['ID']."',
								   				  '$datalog',
												  '$horalog',
												  'inseriu',
												  '$nome',
												  'Cadastros')";
			$rsLog = mysql_query($sqlLog);	*/								  
				
		break;
		
		//ATUALIZAÇÃO--------------------------------------------------------------------------------------------------------------------------------------------
		case 'atu':
			$resposta = limpaStr($resposta);		
			
			$sql = "UPDATE respostas SET resposta = '$resposta' WHERE idresposta = '$id'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			session_register('MSG');
			$_SESSION['MSG'] = "Resposta editada com sucesso.";	
			
			//LOG	
/*			$sqlLog = "INSERT INTO fl_log
								   (idusuario,
								   data,
								   hora,
								   acao,
								   titulo,
								   secao) VALUES ('".$_SESSION['ID']."',
								   				  '$datalog',
												  '$horalog',
												  'editou',
												  '$nome',
												  'Cadastros')";
			$rsLog = mysql_query($sqlLog);	*/									  
			
		break;
		
		//REMOÇÃO------------------------------------------------------------------------------------------------------------------------------------------------
		case 'rem':		
			$sql = "DELETE FROM respostas WHERE idresposta = '$idresposta'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			session_register('MSG');
			$_SESSION['MSG'] = "Resposta removida com sucesso.";	
			
			
			//LOG
/*			$sqlLog = "INSERT INTO fl_log
								   (idusuario,
								   data,
								   hora,
								   acao,
								   titulo,
								   secao) VALUES ('".$_SESSION['ID']."',
								   				  '$datalog',
												  '$horalog',
												  'excluiu',
												  '".mysql_result($rs,0,'nome')."',
												  'Cadastros')";
			$rsLog = mysql_query($sqlLog);	*/		
		break;
		
		//MULTIPLA REMOÇÃO-----------------------------------------------------------------------------------------------------------------------------------------
		case 'multirem':
			$deletaveis = explode(',',$deleta);
			
			for ($i = 0; $i < sizeof($deletaveis); $i++) {
				$sql = "SELECT * FROM respostas WHERE idresposta = '$deletaveis[$i]'";
				$rs = mysql_query($sql) or die(mysql_error());
				
				$rsNome = mysql_query($sql);
				
				//LOG
/*				$sqlLog = "INSERT INTO fl_log
								   (idusuario,
								   data,
								   hora,
								   acao,
								   titulo,
								   secao) VALUES ('".$_SESSION['ID']."',
								   				  '$datalog',
												  '$horalog',
												  'excluiu (diversos)',
												  '".mysql_result($rsNome,0,'nome')."',
												  'Cadastros')";
				$rsLog = mysql_query($sqlLog); */
				
				if(mysql_num_rows($rs)){
					while($rsDados = mysql_fetch_array($rs)){
						$id = $rsDados['idresposta'];
															
						$sqldel = "DELETE FROM respostas WHERE idresposta = '$id'";
						$rsdel = mysql_query($sqldel) or die(mysql_error());
					}
				}
			}
			session_register('MSG');
			$_SESSION['MSG'] = "Resposta(s) removida(s) com sucesso.";		
		break;		
	}
}else{
	die('Ocorreu um erro: A ação não está determinada. Contate a Zeeppo.');
}

//RETORNANDO Á LISTA DE PUBLICAÇÕES
header("location:respostas.php?idpergunta=".$idpergunta."&idevento=".$idevento);
exit;

?>