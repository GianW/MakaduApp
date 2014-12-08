<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/inc.imgs.php');
include_once('../../incs/class.date.php');

//COMEÇO DAS AÇÕES
if(isset($acao) && $acao != ''){	
	
	$objDate = new Date();
	if(!isset($datainicio) || $datainicio == trim('')){
		$datainicio = $objDate->now();
	}else{
		$datainicio = $objDate->toMysql($datainicio);
	}
	
	$objDate = new Date();
	if(!isset($datafim) || $datafim == trim('')){
		$datafim = $objDate->now();
	}else{
		$datafim = $objDate->toMysql($datafim);
	}	
	
	$datalog = date('Y-m-d');   
	$horalog = date('H:i:s');
		
	switch($acao){
		//INSERÇÃO------------------------------------------------------------------------------------------------------------------------------------------------
		case 'ins':
			$nomeevento = limpaStr($nomeevento);
			$local = limpaStr($local);
			$endereco = limpaStr($endereco);
			$cidade = limpaStr($cidade);
			$release = limpaStr($release);
						
			$sql = "INSERT INTO eventos (nomeevento,
									     local,
									     datainicio,
									     datafim,
									     endereco,
									     cidade,
									     estado,
									     texto) VALUES ('$nomeevento',
														  '$local',
														  '$datainicio',
														  '$datafim',
														  '$endereco',
														  '$cidade',
														  '$estado',
														  '$release')";
			$rs = mysql_query($sql) or die(mysql_error());
			
			$idAtual = mysql_insert_id($conn);
			$pasta = '../../uploads/eventos/';
			
			//IMAGEM
			if($_FILES['img']['tmp_name'] != ''){
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],800,1000,'gg_img',$idAtual,'eventos','logotipo','idevento',$pasta);
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],500,700,'g_img',$idAtual,'eventos','logotipo','idevento',$pasta);	
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],300,300,'m_img',$idAtual,'eventos','logotipo','idevento',$pasta);			
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],90,150,'img',$idAtual,'eventos','logotipo','idevento',$pasta);
			}
			
			//PATROCINIO
			if($_FILES['patrocinio']['tmp_name'] != ''){
				upload($_FILES['patrocinio']['tmp_name'],$_FILES['patrocinio']['type'],800,1000,'gg_imgp',$idAtual,'eventos','patrocinio','idevento',$pasta);
				upload($_FILES['patrocinio']['tmp_name'],$_FILES['patrocinio']['type'],500,700,'g_imgp',$idAtual,'eventos','patrocinio','idevento',$pasta);	
				upload($_FILES['patrocinio']['tmp_name'],$_FILES['patrocinio']['type'],300,300,'m_imgp',$idAtual,'eventos','patrocinio','idevento',$pasta);			
				upload($_FILES['patrocinio']['tmp_name'],$_FILES['patrocinio']['type'],90,150,'imgp',$idAtual,'eventos','patrocinio','idevento',$pasta);
			}			
			
			session_register('MSG');
			$_SESSION['MSG'] = "Evento inserido com sucesso.";	
			
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
			$nomeevento = limpaStr($nomeevento);
			$local = limpaStr($local);
			$endereco = limpaStr($endereco);
			$cidade = limpaStr($cidade);
			$release = limpaStr($release);
			
			$sql = "UPDATE eventos SET nomeevento = '$nomeevento', 
								       local = '$local',
									   datainicio = '$datainicio',
									   datafim = '$datafim',
									   endereco = '$endereco',
									   cidade = '$cidade',
									   estado = '$estado',
									   texto = '$release' WHERE idevento = '$idevento'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			$idAtual = $idevento;
			$pasta = '../../uploads/eventos/';
			
			//IMAGEM
			if($_FILES['img']['tmp_name'] != ''){
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],800,1000,'gg_img',$idAtual,'eventos','logotipo','idevento',$pasta);
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],500,700,'g_img',$idAtual,'eventos','logotipo','idevento',$pasta);	
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],300,300,'m_img',$idAtual,'eventos','logotipo','idevento',$pasta);			
				upload($_FILES['img']['tmp_name'],$_FILES['img']['type'],90,150,'img',$idAtual,'eventos','logotipo','idevento',$pasta);
			}
			
			//EM CASO DE REMOÇÃO DAS FOTOS
			if(isset($remover_img)){
				rem_img($pasta,$idAtual,'eventos','logotipo','idevento');
				$sql = "UPDATE eventos SET logotipo = '' WHERE idevento = '$idevento'";
				$rs = mysql_query($sql) or die(mysql_error());			
			}
			
			//PATROCINIO
			if($_FILES['patrocinio']['tmp_name'] != ''){
				upload($_FILES['patrocinio']['tmp_name'],$_FILES['patrocinio']['type'],800,1000,'gg_imgp',$idAtual,'eventos','patrocinio','idevento',$pasta);
				upload($_FILES['patrocinio']['tmp_name'],$_FILES['patrocinio']['type'],500,700,'g_imgp',$idAtual,'eventos','patrocinio','idevento',$pasta);	
				upload($_FILES['patrocinio']['tmp_name'],$_FILES['patrocinio']['type'],300,300,'m_imgp',$idAtual,'eventos','patrocinio','idevento',$pasta);			
				upload($_FILES['patrocinio']['tmp_name'],$_FILES['patrocinio']['type'],90,150,'imgp',$idAtual,'eventos','patrocinio','idevento',$pasta);
			}
			
			//EM CASO DE REMOÇÃO DAS FOTOS
			if(isset($remover_patrocinio)){
				rem_img($pasta,$idAtual,'eventos','patrocinio','idevento');
				$sql = "UPDATE eventos SET patrocinio = '' WHERE idevento = '$idevento'";
				$rs = mysql_query($sql) or die(mysql_error());			
			}			
			
			session_register('MSG');
			$_SESSION['MSG'] = "Evento editado com sucesso.";	
			
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
			$pasta = '../../uploads/eventos/';
			$sql = "SELECT * FROM eventos WHERE idevento = '$idevento'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			if($rsDados = mysql_fetch_array($rs)){
				if($rsDados['logotipo']){
					rem_img($pasta,$idevento,'eventos','logotipo','idevento');
				}
				if($rsDados['patrocinio']){
					rem_img($pasta,$idevento,'eventos','patrocinio','idevento');
				}					
			}
			$sql = "DELETE FROM eventos WHERE idevento = '$idevento'";
			$rs = mysql_query($sql) or die(mysql_error());
			
			session_register('MSG');
			$_SESSION['MSG'] = "Evento removido com sucesso.";	
			
			
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
			$pasta = '../../uploads/eventos/';
			
			for ($i = 0; $i < sizeof($deletaveis); $i++) {
				$sql = "SELECT * FROM eventos WHERE idevento = '$deletaveis[$i]'";
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
						$id = $rsDados['idevento'];
						
						if($rsDados['logotipo']){
							rem_img($pasta,$id,'eventos','logotipo','idevento');
						}
															
						$sqldel = "DELETE FROM eventos WHERE idevento = '$id'";
						$rsdel = mysql_query($sqldel) or die(mysql_error());
					}
				}
			}
			session_register('MSG');
			$_SESSION['MSG'] = "Evento(s) removido(s) com sucesso.";		
		break;		
	}
}else{
	die('Ocorreu um erro: A ação não está determinada. Contate a Zeeppo.');
}

//RETORNANDO Á LISTA DE PUBLICAÇÕES
header("location:eventos.php");
exit;

?>