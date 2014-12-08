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
			$pergunta = limpaStr($pergunta);
						
			$sql = "INSERT INTO perguntas (idevento,
										   pergunta,
										   idquestionador,
										   idprogramacao,
										   data,
										   hora) VALUES ('$idevento',
											   			      '$pergunta',
															  '".$_SESSION['ID']."',
															  '$idprogramacao',
															  '$datalog',
															  '$horalog')";
			$rs = mysql_query($sql) or die(mysql_error());
			
			session_register('MSG');
			$_SESSION['MSG'] = "Pergunta inserida com sucesso.";	
			
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
			$pergunta = limpaStr($pergunta);		
			
			$sql = "UPDATE perguntas SET pergunta = '$pergunta',
									  idprogramacao = '$idprogramacao' WHERE idpergunta = '$id'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			session_register('MSG');
			$_SESSION['MSG'] = "Pergunta editada com sucesso.";	
			
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
			$sql = "DELETE FROM perguntas WHERE idpergunta = '$idpergunta'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			session_register('MSG');
			$_SESSION['MSG'] = "Pergunta removida com sucesso.";	
			
			
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
				$sql = "SELECT * FROM perguntas WHERE idpergunta = '$deletaveis[$i]'";
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
						$id = $rsDados['idpergunta'];
															
						$sqldel = "DELETE FROM perguntas WHERE idpergunta = '$id'";
						$rsdel = mysql_query($sqldel) or die(mysql_error());
					}
				}
			}
			session_register('MSG');
			$_SESSION['MSG'] = "Pergunta(s) removida(s) com sucesso.";		
		break;		
	}
}else{
	die('Ocorreu um erro: A ação não está determinada. Contate a Zeeppo.');
}

//RETORNANDO Á LISTA DE PUBLICAÇÕES
header("location:perguntas.php?idevento=".$idevento);
exit;

?>