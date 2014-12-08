<?php
include_once('incs/conn.php');
include_once('incs/funcoes.php');
include_once('incs/class.TemplatePower.inc.php');
include_once('incs/class.date.php');
require_once('incs/class.phpmailer.php');

//RESGATANDO DADOS DO POST--------------
$idprogramacao = $_POST["idprogramacao"];
$id = $_POST["id"];

$data = date('Y-m-d');	
$tempo = date('H:i:s');
//----------------------------------------

$sql = "SELECT nome, email FROM login WHERE id = '$id'";
$rs = mysql_query($sql);

$nome = mysql_result($rs, 0, 'nome');
$email = mysql_result($rs, 0, 'email');

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
$tpl_contato = new TemplatePower('email_material.html');
$tpl_contato -> prepare();

//INFORMAÇÕEES DO E-MAIL---------------------------------
$tpl_contato -> assignGlobal('nomeevento',$nomeevento);
$tpl_contato -> assignGlobal('titulo',$titulo);
$tpl_contato -> assignGlobal('nome',$nome);
$tpl_contato -> assignGlobal('material',$material);

$modelo_contato = $tpl_contato -> getOutputContent();
$mail->Body = $modelo_contato;
$mail->Send();

echo('OK');
?>
