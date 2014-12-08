<?php
$nivel = 0;
$paginasMenu = array();

if($nivel == 0){
	$paginasMenu[0] = '../usuarios/usuarios.php?limpado=ok';	
	$paginasMenu[1] = '../eventos/eventos.php?limpado=ok';	
	$paginasMenu[2] = '../programacao/programacao.php?limpado=ok';		
	$paginasMenu[3] = '../perguntas/perguntas.php?limpado=ok';	
	$paginasMenu[4] = '../avisos/avisos.php?limpado=ok';	
	$paginasMenu[5] = '../analytics/analytics.php';		
	$paginasMenu[6] = '../../logout.php';	
	
	$titulosMenu[0] = 'Cadastros';	
	$titulosMenu[1] = 'Eventos';	
	$titulosMenu[2] = 'Programaחדo';	
	$titulosMenu[3] = 'Perguntas';	
	$titulosMenu[4] = 'Avisos';	
	$titulosMenu[5] = 'Analytics';
	$titulosMenu[6] = 'Sair';		
	
	$imagensMenu[0] = 'cadastros';	
	$imagensMenu[1] = 'mapa';	
	$imagensMenu[2] = 'agenda';	
	$imagensMenu[3] = 'visitas';	
	$imagensMenu[4] = 'eleicoes';	
	$imagensMenu[5] = 'dados';	
	$imagensMenu[6] = 'sair';	
	
	$numeroMenu[0] = '0';	
	$numeroMenu[1] = '1';					
	$numeroMenu[2] = '2';	
	$numeroMenu[3] = '3';	
	$numeroMenu[4] = '4';	
	$numeroMenu[5] = '5';	
	$numeroMenu[6] = '6';		
	
	$ordemMenu[0] = '0';	
	$ordemMenu[1] = '1';					
	$ordemMenu[2] = '2';	
	$ordemMenu[3] = '3';	
	$ordemMenu[4] = '4';	
	$ordemMenu[5] = '5';
	$ordemMenu[6] = '6';			
}
?>