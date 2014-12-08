<?php
//MENU
function hexDarker($hex,$factor = 30)
{
	$new_hex = '';
	
	$base['R'] = hexdec($hex{0}.$hex{1});
	$base['G'] = hexdec($hex{2}.$hex{3});
	$base['B'] = hexdec($hex{4}.$hex{5});
	
	foreach ($base as $k => $v)
		 {
		 $amount = $v / 100;
		 $amount = round($amount * $factor);
		 $new_decimal = $v - $amount;
	
		 $new_hex_component = dechex($new_decimal);
		 if(strlen($new_hex_component) < 2)
				 { $new_hex_component = "0".$new_hex_component; }
		 $new_hex .= $new_hex_component;
		 }
		 
	return $new_hex;        
}

//BUSCAR DINAMICAMENTE DAS OPCOES
$skin = 'win8';

if($skin == 'win8'){ 
	$myCol = "014051";
}
if($skin == 'preto'){
	$myCol = "000000";
}
$cor = 0;
$cont = sizeof($paginasMenu);
for($i = 1; $i <= sizeof($paginasMenu); $i++){
	$cor = -($cont * 8);
	$tpl->newBlock('BOTAOMENU');
	$tpl->assign('corbotao', hexDarker($myCol, $cor));
	$tpl->assign('linkmenu', $paginasMenu[$i - 1]);
	$tpl->assign('titulomenu', $titulosMenu[$i - 1]);
	$tpl->assign('imagemmenu', $imagensMenu[$i - 1]);
	$tpl->assign('numeromenu', $numeroMenu[$i - 1]);
	$tpl->assign('ordemmenu', $ordemMenu[$i - 1]);
	$cont--;
}
$tpl->gotoBlock('_ROOT');
?>