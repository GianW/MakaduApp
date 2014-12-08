<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/inc.imgs.php');
include_once('../../incs/class.date.php');

//COMEÇO DAS AÇÕES
if(isset($acao) && $acao != ''){	
	
	$objDate = new Date();
	if(!isset($data) || $data == trim('')){
		$data = $objDate->now();
	}else{
		$data = $objDate->toMysql($data);
	}
	
	$datalog = date('Y-m-d');   
	$horalog = date('H:i:s');
		
	switch($acao){
		//INSERÇÃO------------------------------------------------------------------------------------------------------------------------------------------------
		case 'ins':
			$nome = limpaStr($nome);
			$senha = mysql_real_escape_string($senha);	
			
			$sql = "INSERT INTO login (nome,
									   email,
									   data,
									   senha,
									   palestrante,
									   administrador,
									   obs,
									   ativo) VALUES ('$nome',
									   				  '$email',
													  '$data',
													  MD5('$senha'),
													  '$palestrante',
													  '$administrador',
													  '$obs',
													  '1')";
			$rs = mysql_query($sql) or die(mysql_error());
			
			$idAtual = mysql_insert_id($conn);
			$pasta = '../../uploads/usuarios/';
			
			//IMAGEM
			if($_FILES['img']['tmp_name'] != ''){
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],800,1000,'gg_img',$idAtual,'login','img','id',$pasta);
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],500,700,'g_img',$idAtual,'login','img','id',$pasta);	
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],300,300,'m_img',$idAtual,'login','img','id',$pasta);			
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],90,150,'img',$idAtual,'login','img','id',$pasta);
			}
			
			session_register('MSG');
			$_SESSION['MSG'] = "Cadastro inserido com sucesso.";	
			
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
			$nome = limpaStr($nome);
			$senha = mysql_real_escape_string($senha);			
			
			$sql = "UPDATE login SET nome = '$nome', 
								     data = '$data',
									 email = '$email', ";
								if(isset($senha) && $senha != 'senhapadrao'){
									$sql .= "senha=MD5('$senha'), ";
								}
								$sql .="palestrante = '$palestrante',
										administrador = '$administrador',
										obs = '$obs' WHERE id = '$id'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			$idAtual = $id;
			$pasta = '../../uploads/usuarios/';
			
			//IMAGEM
			if($_FILES['img']['tmp_name'] != ''){
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],800,1000,'gg_img',$idAtual,'login','img','id',$pasta);
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],500,700,'g_img',$idAtual,'login','img','id',$pasta);	
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],300,300,'m_img',$idAtual,'login','img','id',$pasta);			
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],90,150,'img',$idAtual,'login','img','id',$pasta);
			}
			
			//EM CASO DE REMOÇÃO DAS FOTOS
			if(isset($remover_img)){
				rem_img($pasta,$idAtual,'login','img','id');
				$sql = "UPDATE login SET img = '' WHERE id = '$id'";
				$rs = mysql_query($sql) or die(mysql_error());			
			}
			
			session_register('MSG');
			$_SESSION['MSG'] = "Cadastro editado com sucesso.";	
			
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
			$pasta = '../../uploads/usuarios/';
			$sql = "SELECT * FROM login WHERE id = '$id'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			if($rsDados = mysql_fetch_array($rs)){
				if($rsDados['img']){
					rem_img($pasta,$id,'login','img','id');
				}	
			}
			$sql = "DELETE FROM login WHERE id = '$id'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			session_register('MSG');
			$_SESSION['MSG'] = "Cadastro removido com sucesso.";	
			
			
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
			$pasta = '../../uploads/usuarios/';
			
			for ($i = 0; $i < sizeof($deletaveis); $i++) {
				$sql = "SELECT * FROM login WHERE id = '$deletaveis[$i]'";
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
						$id = $rsDados['id'];
						
						if($rsDados['img']){
							rem_img($pasta,$id,'login','img','id');
						}
															
						$sqldel = "DELETE FROM login WHERE id = '$id'";
						$rsdel = mysql_query($sqldel) or die(mysql_error());
					}
				}
			}
			
			session_register('MSG');
			$_SESSION['MSG'] = "Cadastro(s) removido(s) com sucesso.";		
		break;		
	}
}else{
	die('Ocorreu um erro: A ação não está determinada. Contate a Zeeppo.');
}

//RETORNANDO Á LISTA DE PUBLICAÇÕES
header("location:usuarios.php");
exit;

?>