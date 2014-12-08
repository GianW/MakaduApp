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
			$aviso = limpaStr($aviso);
			$detalhes = limpaStr($detalhes);
						
			$sql = "INSERT INTO avisos (idevento,
										aviso,
									    detalhes,
									    dataaviso,
										patrocinado,
									    horaaviso) VALUES ('$idevento',
														   '$aviso',
														   '$detalhes',
														   '$datalog',
														   '$patrocinado',
														   '$horalog')";
			$rs = mysql_query($sql) or die(mysql_error());
			
			session_register('MSG');
			$_SESSION['MSG'] = "Aviso inserido com sucesso.";	
			
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
			$aviso = limpaStr($aviso);
			$detalhes = limpaStr($detalhes);		
			
			$sql = "UPDATE avisos SET aviso = '$aviso',
									  patrocinado = '$patrocinado', 
									  detalhes = '$detalhes' WHERE idaviso = '$id'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			session_register('MSG');
			$_SESSION['MSG'] = "Aviso editado com sucesso.";	
			
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
			$sql = "DELETE FROM avisos WHERE idaviso = '$idaviso'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			session_register('MSG');
			$_SESSION['MSG'] = "Aviso removido com sucesso.";	
			
			
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
				$sql = "SELECT * FROM avisos WHERE idaviso = '$deletaveis[$i]'";
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
						$id = $rsDados['idaviso'];
															
						$sqldel = "DELETE FROM avisos WHERE idaviso = '$id'";
						$rsdel = mysql_query($sqldel) or die(mysql_error());
					}
				}
			}
			session_register('MSG');
			$_SESSION['MSG'] = "Aviso(s) removido(s) com sucesso.";		
		break;		
	}
}else{
	die('Ocorreu um erro: A ação não está determinada. Contate a Zeeppo.');
}

//RETORNANDO Á LISTA DE PUBLICAÇÕES
header("location:avisos.php?idevento=".$idevento);
exit;

?>