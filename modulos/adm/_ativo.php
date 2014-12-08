<?php
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');

//INCLUINDO TIPOS DESTE SITE. ALTERAR config.php PARA NOVOS TIPOS
include_once('_config.php');

//CADASTROS-----------------------------------------------------------------------------------
if($tipoativo == 'ativo'){
	if(isset($id)){
		$sql = "UPDATE login SET ativo = abs(ativo - 1) WHERE id = '$id'";
		mysql_query($sql) or die(mysql_error());
	}
}

if($tipoativo == 'palestrante'){
	if(isset($id)){
		$sql = "UPDATE login SET palestrante = abs(palestrante - 1) WHERE id = '$id'";
		mysql_query($sql) or die(mysql_error());
	}
}

if($tipoativo == 'administrador'){
	if(isset($id)){
		$sql = "UPDATE login SET administrador = abs(administrador - 1) WHERE id = '$id'";
		mysql_query($sql) or die(mysql_error());
	}
}

//EVENTOS-----------------------------------------------------------------------------------
if($tipoativo == 'eventos'){
	if(isset($id)){
		$sql = "UPDATE eventos SET ativo = abs(ativo - 1) WHERE idevento = '$id'";
		mysql_query($sql) or die(mysql_error());
	}
}

//PROGRAMAÇÃO-------------------------------------------------------------------------------
if($tipoativo == 'programacao'){
	if(isset($id)){
		$sql = "UPDATE programacao SET ativo = abs(ativo - 1) WHERE idprogramacao = '$id'";
		mysql_query($sql) or die(mysql_error());
	}
}

if($tipoativo == 'perguntas'){
	if(isset($id)){
		$sql = "UPDATE programacao SET perguntas = abs(perguntas - 1) WHERE idprogramacao = '$id'";
		mysql_query($sql) or die(mysql_error());
	}
}

if($tipoativo == 'arquivos'){
	if(isset($id)){
		$sql = "UPDATE programacao SET arquivos = abs(arquivos - 1) WHERE idprogramacao = '$id'";
		mysql_query($sql) or die(mysql_error());
	}
}

//AVISOS-----------------------------------------------------------------------------------
if($tipoativo == 'aviso'){
	if(isset($id)){
		$sql = "UPDATE avisos SET ativo = abs(ativo - 1) WHERE idaviso = '$id'";
		mysql_query($sql) or die(mysql_error());
	}
}

if($tipoativo == 'patrocinado'){
	if(isset($id)){
		$sql = "UPDATE avisos SET patrocinado = abs(patrocinado - 1) WHERE idaviso = '$id'";
		mysql_query($sql) or die(mysql_error());
	}
}

//PERGUNTAS-----------------------------------------------------------------------------------
if($tipoativo == 'pergunta'){
	if(isset($id)){
		$sql = "UPDATE perguntas SET ativo = abs(ativo - 1) WHERE idpergunta = '$id'";
		mysql_query($sql) or die(mysql_error());
	}
}

if($tipoativo == 'resposta'){
	if(isset($id)){
		$sql = "UPDATE respostas SET ativo = abs(ativo - 1) WHERE idresposta = '$id'";
		mysql_query($sql) or die(mysql_error());
	}
}
?>