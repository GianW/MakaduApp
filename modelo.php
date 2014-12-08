<?php
include_once('incs/class.TemplatePower.inc.php');

$tpl = new TemplatePower('modelo.html');
$tpl->prepare();

$tpl->printToScreen();
?>