<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/inc.imgs.php');
include_once('../../incs/class.date.php');

//COMEÇO DAS AÇÕES
if(isset($acao) && $acao != ''){	
	
	$objDate = new Date();
	if(!isset($dataprograma) || $dataprograma == trim('')){
		$dataprograma = $objDate->now();
	}else{
		$dataprograma = $objDate->toMysql($dataprograma);
	}	
	
	$datalog = date('Y-m-d');   
	$horalog = date('H:i:s');
		
	switch($acao){
		//INSERÇÃO------------------------------------------------------------------------------------------------------------------------------------------------
		case 'ins':
			$titulo = limpaStr($titulo);
			$localprograma = limpaStr($localprograma);
			$palestrante = limpaStr($palestrante);
			//$sobrepalestrante = limpaStr($sobrepalestrante);
			//$descricao = limpaStr($descricao);
						
			$sql = "INSERT INTO programacao (titulo,
											 idevento,
											 localprograma,
											 dataprograma,
											 data,
											 horainicio,
											 horafim,
											 perguntas,
											 arquivos,
											 palestra,
											 sopalestrante,
											 sobrepalestrante,
											 descricao) VALUES ('$titulo',
															    '$idevento',
															    '$localprograma',
															    '$dataprograma',
																'$datalog',
															    '$horainicio',
															    '$horafim',
															    '$perguntas',
																'$arquivos',
																'$arquivos',
																'$sopalestrante',
																'$sobrepalestrante',
															    '$descricao')";
			$rs = mysql_query($sql) or die(mysql_error());
			
			$idAtual = mysql_insert_id($conn);
			$pasta = '../../uploads/programacao/';
			
			//IMAGEM
			if($_FILES['img']['tmp_name'] != ''){
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],800,1000,'gg_img',$idAtual,'programacao','foto','idprogramacao',$pasta);
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],500,700,'g_img',$idAtual,'programacao','foto','idprogramacao',$pasta);	
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],300,300,'m_img',$idAtual,'programacao','foto','idprogramacao',$pasta);			
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],90,150,'img',$idAtual,'programacao','foto','idprogramacao',$pasta);
			}
			
			//ENVIO DE ARQUIVO
			if(isset($material) && $material != '' && $_FILES['material']['tmp_name'] != ''){
				$arquivofinal = limpaArquivo($_FILES['material']['name']);
				if(move_uploaded_file($_FILES['material']['tmp_name'] , $pasta.$arquivofinal)) {
					$sql = "UPDATE programacao SET material = '$arquivofinal' WHERE idprogramacao = '$idAtual'";
					$rs = mysql_query($sql) or die(mysql_error());	
				}
			}
			
			//PALESTRANTES
			if (sizeof($idpalestrante) > 0){
				for ($i = 0; $i < sizeof($idpalestrante); $i++){
					$sql_op = "INSERT INTO relprogpal (idprogramacao, 
													   idpalestrante) VALUES ('$idAtual',
																	 		  '$idpalestrante[$i]')";
					$rs_op = mysql_query($sql_op) or die(mysql_error());
				}				
			} 						
			
			session_register('MSG');
			$_SESSION['MSG'] = "Programação inserida com sucesso.";	
			
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
			$titulo = limpaStr($titulo);
			$localprograma = limpaStr($localprograma);
			$palestrante = limpaStr($palestrante);
			//$sobrepalestrante = limpaStr($sobrepalestrante);
			//$descricao = limpaStr($descricao);		
			
			$sql = "UPDATE programacao SET titulo = '$titulo', 
										   localprograma = '$localprograma',
										   dataprograma = '$dataprograma',
										   horainicio = '$horainicio',
										   horafim = '$horafim',
										   perguntas = '$perguntas',
										   arquivos = '$arquivos',
										   palestra = '$palestra',
										   sopalestrante = '$sopalestrante',
										   sobrepalestrante = '$sobrepalestrante',
										   descricao = '$descricao' WHERE idprogramacao = '$idprogramacao'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			$idAtual = $idprogramacao;
			$pasta = '../../uploads/programacao/';
			
			//IMAGEM
			if($_FILES['img']['tmp_name'] != ''){
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],800,1000,'gg_img',$idAtual,'programacao','foto','idprogramacao',$pasta);
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],500,700,'g_img',$idAtual,'programacao','foto','idprogramacao',$pasta);	
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],300,300,'m_img',$idAtual,'programacao','foto','idprogramacao',$pasta);			
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],90,150,'img',$idAtual,'programacao','foto','idprogramacao',$pasta);
			}
			
			//EM CASO DE REMOÇÃO DAS FOTOS
			if(isset($remover_img)){
				rem_img($pasta,$idAtual,'programacao','foto','idprogramacao');
				$sql = "UPDATE programacao SET foto = '' WHERE idprogramacao = '$idprogramacao'";
				$rs = mysql_query($sql) or die(mysql_error());			
			}
			
			//ENVIO DE ARQUIVO
			if(isset($material) && $material != '' && $_FILES['material']['tmp_name'] != ''){
				$sql = "SELECT material FROM programacao WHERE idprogramacao = '$idprogramacao'";
				$rs = mysql_query($sql) or die(mysql_error());
				
				if(mysql_result($rs, 0, 'material') != ''){
					unlink($pasta.mysql_result($rs, 0, 'material'));
				}
				
				$arquivofinal = limpaArquivo($_FILES['material']['name']);
				if(move_uploaded_file($_FILES['material']['tmp_name'] , $pasta.$arquivofinal)) {
					$sql = "UPDATE programacao SET material = '$arquivofinal' WHERE idprogramacao = '$idprogramacao'";
					$rs = mysql_query($sql) or die(mysql_error());	
				}
				
				//ENVIA ARQUIVO PARA CADASTRADOS
				$sqlEnv = "SELECT * FROM agendamento WHERE idprogramacao = '$idprogramacao' GROUP BY email";
				$rsEnv = mysql_query($sqlEnv);
				if(mysql_num_rows($rsEnv)){
					include_once('../../incs/class.TemplatePower.inc.php');
					include_once('../../incs/class.date.php');
					require_once('../../incs/class.phpmailer.php');

					while($rsDadosEnv = mysql_fetch_array($rsEnv)){
						$email = $rsDadosEnv['email'];
						$nome = $rsDadosEnv['nome'];
						$data = date('Y-m-d');	
						$tempo = date('H:i:s');
						
						$sql = "SELECT pr.titulo, pr.material, e.nomeevento
								FROM programacao pr
								INNER JOIN eventos e
								ON e.idevento = pr.idevento
								WHERE pr.idprogramacao = '$idprogramacao'";
						$rs = mysql_query($sql);
						
						$titulo = mysql_result($rs, 0, 'titulo');
						$material = mysql_result($rs, 0, 'material');	
						$nomeevento = mysql_result($rs, 0, 'nomeevento');	
						
						//CLASSE DO E-MAIL
						$mail = new phpmailer();
						
						$mail->PluginDir		= "";
						$mail->Mailer			= "mail";
						$mail->Priority			= "Normal";
						$mail->CharSet			= "iso-8859-1";
						$mail->Encoding			= "8bit";
						$mail->WordWrap			= 80;
						$mail->From     		= "no-reply@makadu.net";
						$mail->ReplyTo     		= "no-reply@makadu.net";
						$mail->Sender     		= "no-reply@makadu.net";
						$mail->FromName			= 'Makadu';
						$mail->AddAddress($email, 'Material da palestra '.$titulo);
						
						$mail->IsHTML(TRUE);
						$mail->Subject = 'Material da palestra '.$titulo;
						
						// INICIO - FORMULARIO DE CONTATO
						$tpl_contato = new TemplatePower('../../email_material.html');
						$tpl_contato -> prepare();
						
						//INFORMAÇÕEES DO E-MAIL---------------------------------
						$tpl_contato -> assignGlobal('nomeevento',$nomeevento);
						$tpl_contato -> assignGlobal('titulo',$titulo);
						$tpl_contato -> assignGlobal('nome',$nome);
						$tpl_contato -> assignGlobal('material',$material);
						
						$modelo_contato = $tpl_contato -> getOutputContent();
						$mail->Body = $modelo_contato;
						$mail->Send();	
						
						$sqlDel = "DELETE FROM agendamento WHERE email = '$email' AND idprogramacao = '$idprogramacao'";
						$rsDel = mysql_query($sqlDel);
					}
				}
			}
			
			//REMOÇÃO DE ARQUIVO
			if(isset($remover_arquivo)){
				$sql = "SELECT material FROM programacao WHERE idprogramacao = '$idprogramacao'";
				$rs = mysql_query($sql) or die(mysql_error());
				
				if(mysql_result($rs, 0, 'material') != ''){
					unlink($pasta.mysql_result($rs, 0, 'material'));
				}
				
				$sql = "UPDATE programacao SET material = '' WHERE idprogramacao = '$idprogramacao'";
				$rs = mysql_query($sql) or die(mysql_error());			
			}			
			
			//PALESTRANTES
			if (sizeof($idpalestrante) > 0){
				$sql = "DELETE FROM relprogpal WHERE idprogramacao = '$idprogramacao'";
				$rs = mysql_query($sql) or die(mysql_error());	
			
				for ($i = 0; $i < sizeof($idpalestrante); $i++){
					$sql_op = "INSERT INTO relprogpal (idprogramacao, 
													   idpalestrante) VALUES ('$idprogramacao',
																	 		  '$idpalestrante[$i]')";
					$rs_op = mysql_query($sql_op) or die(mysql_error());
				}				
			} 			
			
			session_register('MSG');
			$_SESSION['MSG'] = "Programação editada com sucesso.";	
			
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
			$pasta = '../../uploads/programacao/';
			$sql = "SELECT * FROM programacao WHERE idprogramacao = '$idprogramacao'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			if($rsDados = mysql_fetch_array($rs)){
				if($rsDados['foto']){
					rem_img($pasta,$idprogramacao,'programacao','foto','idprogramacao');
				}	
				if($rsDados['material']){
					unlink($pasta.$rsDados['material']);
				}
			}
			
			$sql = "DELETE FROM relprogpal WHERE idprogramacao = '$idprogramacao'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			$sql = "DELETE FROM programacao WHERE idprogramacao = '$idprogramacao'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			session_register('MSG');
			$_SESSION['MSG'] = "Programação removida com sucesso.";	
			
			
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
			$pasta = '../../uploads/programacao/';
			
			for ($i = 0; $i < sizeof($deletaveis); $i++) {
				$sql = "SELECT * FROM programacao WHERE idprogramacao = '$deletaveis[$i]'";
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
						$id = $rsDados['idprogramacao'];
						
						if($rsDados['foto']){
							rem_img($pasta,$id,'programacao','foto','idprogramacao');
						}
								
						if($rsDados['material']){
							unlink($pasta.$rsDados['material']);
						}	
						
						$sqldel = "DELETE FROM relprogpal WHERE idprogramacao = '$id'";
						$rsdel = mysql_query($sqldel) or die(mysql_error());											
															
						$sqldel = "DELETE FROM programacao WHERE idprogramacao = '$id'";
						$rsdel = mysql_query($sqldel) or die(mysql_error());
					}
				}
			}
			session_register('MSG');
			$_SESSION['MSG'] = "Programação(ões) removida(s) com sucesso.";		
		break;		
	}
}else{
	die('Ocorreu um erro: A ação não está determinada. Contate a Zeeppo.');
}

//RETORNANDO Á LISTA DE PUBLICAÇÕES
header("location:programacao.php?idevento=".$idevento);
exit;

?>