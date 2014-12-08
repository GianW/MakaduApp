<?php

//----------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------GERAIS-----------------------------------------------------------------------
setlocale(LC_CTYPE,'pt_BR');
ini_set('memory_limit','128M');
ini_set('post_max_size','50M');
ini_set('upload_max_filesize','64M');
ini_set('max_execution_time', 300);
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
set_time_limit(300);

header('Cache-Control: no-cache');
header('Pragma: no-cache');	

//REGISTERGLOBALS-------------------------------------------------------------------------------------------------------------------
if ( !isset( $_SERVER ) ) {
$_SERVER = $HTTP_SERVER_VARS;
}
if ( !isset( $_GET ) ) {
	$_GET = $HTTP_GET_VARS;
}
if ( !isset( $_FILES ) ) {
	$_FILES = $HTTP_POST_FILES;
	global $_FILES;
}

/*$colecoes=array('_POST','_GET','_SESSION','_FILES');
for($x=0;$x<sizeof($colecoes);$x++){
	if(isset($$colecoes[$x])){
		reset($$colecoes[$x]);
		while (list($chave, $valor) = each ($$colecoes[$x])) {
		   $$chave=$valor;
		}
	}
}*/
//----------------------------------------------------------------------------------------------------------------------------------


//----------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------TEXTOS-----------------------------------------------------------------------
//LIMPA TEXTO-----------------------------------------------------------------------------------------------------------------------
//limpaStr(texto:String, usa fck:Boolean);
function limpaStr($campoTexto, $fck = false) {
	$campoTexto = trim($campoTexto);
	$campoTexto = addslashes($campoTexto);
	$campoTexto = str_replace('</p>','<br /><br />',$campoTexto);
	//$campoTexto = str_replace('</div>','<br />',$campoTexto);
	$campoTexto = strip_tags($campoTexto,'<br><br /><object><param><embed><strong><em><img><a><table><tbody><div><font><h1><h2><h3><td><tr><b><i><u><ol><li><em><ul><hr><span>');
	$campoTexto = str_replace("\r",'',$campoTexto);
	$campoTexto = str_replace("\n",'',$campoTexto);
	$campoTexto = str_replace("&nbsp;",' ',$campoTexto);
	$campoTexto = str_replace('&quot;','',$campoTexto);
	$campoTexto = ereg_replace('(<br />|[[:space:]])+$', ' ', $campoTexto);
	
	if (!$fck){
		$campoTexto = htmlspecialchars($campoTexto, ENT_QUOTES);
	}
			
	return $campoTexto;
}
//---------------------------------------------------------------------------------------------------------------------------------

//UPPER PARA CHARS LATINOS---------------------------------------------------------------------------------------------------------
//upper(texto:String);
function upper($str) {
	$LATIN_UC_CHARS = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ';
	$LATIN_LC_CHARS = 'àáâãäåæçèéêëìíîïðñòóôõöøùúûüý';
	$str = strtr ($str, $LATIN_LC_CHARS, $LATIN_UC_CHARS);
	$str = strtoupper($str);
	return $str;
}
//---------------------------------------------------------------------------------------------------------------------------------

//TIRAR HTML-----------------------------------------------------------------------------------------------------------------------
//tiraTags(texto:String);
function tiraTags($campoTexto) {
	$campoTexto = strip_tags($campoTexto,'');

	return $campoTexto;
}
//---------------------------------------------------------------------------------------------------------------------------------

//FORM CHECK-----------------------------------------------------------------------------------------------------------------------
//confirmaCampos(texto:String);
function alpha_numeric($str) {
	return ( ! preg_match("/^([-a-z0-9])+$/i", $str)) ? FALSE : TRUE;
}

function valid_email($str) {
	return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}
//---------------------------------------------------------------------------------------------------------------------------------

//TRUNCAR FRASE--------------------------------------------------------------------------------------------------------------------
//trunc(texto:String, quantidade de palavras:Int);
function trunc($campoTexto, $max_words)
{
   $phrase_array = explode(' ',$campoTexto);
   if(count($phrase_array) > $max_words && $max_words > 0)
      $campoTexto = implode(' ',array_slice($phrase_array, 0, $max_words)).'...' ; 
   return $campoTexto;
}
//---------------------------------------------------------------------------------------------------------------------------------

//LIMPA ARQUIVO--------------------------------------------------------------------------------------------------------------------
//limpaArquivo(nomeArquivo:String);
function limpaArquivo($nomeArquivo){
	$nomeArquivo = utf8_encode($nomeArquivo);
	$nomeArquivo = mysql_real_escape_string($nomeArquivo);
	
	$var = $nomeArquivo;
	$var = trim($var);

	$var = htmlspecialchars($var);
	$var = str_replace("\\&quot;","",$var);
	$var = str_replace("\\&#039;","",$var);
	$var = str_replace("\\&amp;quot;","",$var);	

	$chara = array('Ã','Â','À','Á','á','à','â','ã','ª');
	$var = str_replace($chara,"a",$var);
	$chare = array('É','È','Ê','é','è','ê');
	$var = str_replace($chare,"e",$var);
	$chari = array('Í','Ì','í','ì');
	$var = str_replace($chari,"i",$var);
	$charo = array('Ó','Ò','Ô','Õ','ó','ò','ô','õ','º');
	$var = str_replace($charo,"o",$var);	
	$charu = array('Ú','Ù','Û','ú','ù','û');
	$var = str_replace($charu,"u",$var);		
	$var = str_replace("  ","-",$var);
	$var = str_replace("Ç","C",$var);
	$var = str_replace("ç","c",$var);
	$var = str_replace('!',"",$var);
	$var = str_replace('?',"",$var);
	$var = str_replace('!?',"",$var);
	$var = str_replace('??',"",$var);
	$var = str_replace('???',"",$var);
	$var = str_replace('!!',"",$var);
	$var = str_replace('!!!',"",$var);
	$var = str_replace(" ","-",$var);
	$var = str_replace("`","",$var);
	$var = str_replace("'","",$var);
	$var = str_replace("\'","",$var);
	$var = str_replace('\"',"",$var);	
	$var = str_replace("/","",$var);	
	$var = str_replace('"',"",$var);
	$var = str_replace('...',"",$var);
	$var = str_replace('....',"",$var);
	$var = str_replace('..',"",$var);
	$var = str_replace(':',"",$var);
	$var = str_replace(',',"",$var);
	$var = str_replace(';',"",$var);
	$var = str_replace('&quot',"",$var);
	$var = str_replace('&',"",$var);
	$var = str_replace('ampquot',"",$var);
	$var = strtolower($var);
	
	return $var;
}
//---------------------------------------------------------------------------------------------------------------------------------

//LIMPA LATINOS--------------------------------------------------------------------------------------------------------------------
//limpaLatinos(texto:String);
function limpaLatinos($nomeArquivo){
	$nomeArquivo = utf8_encode($nomeArquivo);
	$nomeArquivo = mysql_real_escape_string($nomeArquivo);
	
	$var = $nomeArquivo;
	$var = trim($var);

	$var = htmlspecialchars($var);
	$var = str_replace("\\&quot;","",$var);
	$var = str_replace("\\&#039;","",$var);
	$var = str_replace("\\&amp;quot;","",$var);	

	$chara = array('Ã','Â','À','Á','á','à','â','ã','ª');
	$var = str_replace($chara,"a",$var);
	$chare = array('É','È','Ê','é','è','ê');
	$var = str_replace($chare,"e",$var);
	$chari = array('Í','Ì','í','ì');
	$var = str_replace($chari,"i",$var);
	$charo = array('Ó','Ò','Ô','Õ','ó','ò','ô','õ','º');
	$var = str_replace($charo,"o",$var);	
	$charu = array('Ú','Ù','Û','ú','ù','û');
	$var = str_replace($charu,"u",$var);		
	$var = str_replace("  ","-",$var);
	$var = str_replace("Ç","C",$var);
	$var = str_replace("ç","c",$var);
	$var = str_replace('!',"",$var);
	$var = str_replace('?',"",$var);
	$var = str_replace('!?',"",$var);
	$var = str_replace('??',"",$var);
	$var = str_replace('???',"",$var);
	$var = str_replace('!!',"",$var);
	$var = str_replace('!!!',"",$var);
	$var = str_replace("\'","",$var);
	$var = str_replace('\"',"",$var);	
	$var = str_replace("/","",$var);	
	$var = str_replace('"',"",$var);
	$var = str_replace('..',"",$var);
	$var = str_replace(',',"",$var);
	$var = str_replace('&quot',"",$var);
	$var = str_replace('ampquot',"",$var);
	$var = strtolower($var);
	
	return $var;
}
//---------------------------------------------------------------------------------------------------------------------------------

//LIMPA CSV--------------------------------------------------------------------------------------------------------------------
//limpaCSV(nomeArquivo:String);
function limpaCSV($nomeArquivo){
	$nomeArquivo = utf8_encode($nomeArquivo);
	$nomeArquivo = mysql_real_escape_string($nomeArquivo);
	
	$var = $nomeArquivo;
	$var = trim($var);

	$var = htmlspecialchars($var);
	$var = str_replace("\\&quot;","",$var);
	$var = str_replace("\\&#039;","",$var);
	$var = str_replace("\\&amp;quot;","",$var);	
	
	$var = str_replace('!?',"",$var);
	$var = str_replace('??',"",$var);
	$var = str_replace('???',"",$var);
	$var = str_replace('!!',"",$var);
	$var = str_replace('!!!',"",$var);
	$var = str_replace("`","",$var);
	$var = str_replace("'","",$var);
	$var = str_replace('\\',"",$var);
	$var = str_replace("\'","",$var);
	$var = str_replace('\"',"",$var);	
	$var = str_replace('"',"",$var);
	$var = str_replace('....',"",$var);
	$var = str_replace('..',"",$var);
	$var = str_replace('&quot',"",$var);
	$var = str_replace('&',"",$var);
	$var = str_replace('ampquot',"",$var);
	$var = utf8_decode($var);
	
	//$var = utf8_encode($var);
	
	return $var;
}
//---------------------------------------------------------------------------------------------------------------------------------

function getcurrentpath()
{   $curPageURL = "";
    if ($_SERVER["HTTPS"] != "on")
            $curPageURL .= "http://";
     else
        $curPageURL .= "https://" ;
    if ($_SERVER["SERVER_PORT"] == "80")
        $curPageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     else
        $curPageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        $count = strlen(basename($curPageURL));
        $path = substr($curPageURL,0, -$count);
    return $path ;
}

//---------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------DATAS-----------------------------------------------------------------------
//DATAUS: CONVERTE DD/MM/AAAA -> AAAA-MM-DD----------------------------------------------------------------------------------------
//dataUS(data:Date);
function dataUS($campoData) {
	if ($campoData) {
		$campoData = explode('/',$campoData);
		$campoData = $campoData[2].'-'.$campoData[1].'-'.$campoData[0];
	} 
	return $campoData;
}
//---------------------------------------------------------------------------------------------------------------------------------


//DATABR: CONVERTE AAAA-MM-DD -> DD/MM/AAAA ---------------------------------------------------------------------------------------
//dataBR(data:Date);
function dataBR($campoData) {
	if ($campoData) {
		$campoData = explode('-',$campoData);
		$campoData = $campoData[2].'/'.$campoData[1].'/'.$campoData[0];
	} 
	
	if ($campoData == '00/00/0000'){
		unset($campoData);
	}
		
	return $campoData;
}
//---------------------------------------------------------------------------------------------------------------------------------


//SOMAR DATAS: PASSE A DATA NO FORMATO DD/MM/YYYY----------------------------------------------------------------------------------
//somarData(data:Date, dias:Int, meses:Int, ano:Int);
function somarData($data, $dias, $meses, $ano)
{
   $data = explode("/", $data);
   $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano));
   return $newData;
}
//---------------------------------------------------------------------------------------------------------------------------------


//MES ABREVIADO--------------------------------------------------------------------------------------------------------------------
function abreviaMes($mes)
{
	switch($mes)
	{
		case '01': $mes = 'jan'; break;
		case '02': $mes = 'fev'; break;
		case '03': $mes = 'mar'; break;
		case '04': $mes = 'abr'; break;
		case '05': $mes = 'mai'; break;
		case '06': $mes = 'jun'; break;
		case '07': $mes = 'jul'; break;
		case '08': $mes = 'ago'; break;
		case '09': $mes = 'set'; break;
		case '10': $mes = 'out'; break;
		case '11': $mes = 'nov'; break;
		case '12': $mes = 'dez'; break;
	}
	
	return $mes;
}
//---------------------------------------------------------------------------------------------------------------------------------


//CONVERTE DIA DA SEMANA DE NUMERO PARA POR EXTENSO. O MESMO COM O MES-------------------------------------------------------------
//diaSemana(data:Date);
function dataSemana($strDate)
{
	$arrDaysOfWeek = array('Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado');
	$arrMonthsOfYear = array(1 => 'janeiro','fevereiro','março','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro');
	$intDayOfWeek = date('w',strtotime($strDate));
	$intDayOfMonth = date('d',strtotime($strDate));
	$intMonthOfYear = date('n',strtotime($strDate));
	$intYear = date('Y',strtotime($strDate));
	return utf8_decode($arrDaysOfWeek[$intDayOfWeek]) . ', ' . $intDayOfMonth . ' de ' . utf8_decode($arrMonthsOfYear[$intMonthOfYear]) . ' de ' . $intYear;
}

function diaSemana($data) {
	$ano =  substr("$data", 0, 4);
	$mes =  substr("$data", 5, -3);
	$dia =  substr("$data", 8, 9);

	$data = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		
	switch($data) {
		case"0": $diasemana = "Dom"; break;
		case"1": $diasemana = "Seg"; break;
		case"2": $diasemana = "Ter"; break;
		case"3": $diasemana = "Qua"; break;
		case"4": $diasemana = "Qui"; break;
		case"5": $diasemana = "Sex"; break;
		case"6": $diasemana = "Sáb"; break;
	}
	return utf8_decode($diasemana);
}

function diaSemanaComp($data) {
	$ano =  substr("$data", 0, 4);
	$mes =  substr("$data", 5, -3);
	$dia =  substr("$data", 8, 9);

	$data = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		
	switch($data) {
		case"0": $diasemana = "Domingo"; break;
		case"1": $diasemana = "Segunda"; break;
		case"2": $diasemana = "Terça"; break;
		case"3": $diasemana = "Quarta"; break;
		case"4": $diasemana = "Quinta"; break;
		case"5": $diasemana = "Sexta"; break;
		case"6": $diasemana = "Sábado"; break;
	}
	return utf8_decode($diasemana);
}


//---------------------------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------OUTROS----------------------------------------------------------------------
//PARA FLASH-----------------------------------------------------------------------------------------------------------------------
//paraFlash(texto:String);
function paraFlash($campoTexto) {
	$campoTexto = trim($campoTexto);
	$campoTexto = addslashes($campoTexto);
	$campoTexto = str_replace('</p>','<br /><br />',$campoTexto);
	$campoTexto = str_replace('</div>','<br /><br />',$campoTexto);
	$campoTexto = strip_tags($campoTexto,'<br><br /><a>');	
	$campoTexto = str_replace("&amp;","&",$campoTexto);
	$campoTexto = str_replace("&quot;","\"",$campoTexto);
	$campoTexto = str_replace("&#039;","'",$campoTexto);
	$campoTexto = str_replace("&lt;","<",$campoTexto);
	$campoTexto = str_replace("&gt;",">",$campoTexto);
	$campoTexto = str_replace("&ldquo;","\"",$campoTexto);
	$campoTexto = str_replace("&rdquo;","\"",$campoTexto);
	$campoTexto = str_replace("&ndash;","-",$campoTexto);
	$campoTexto = str_replace("\r","",$campoTexto);
	$campoTexto = str_replace("<p>","",$campoTexto);
	return $campoTexto;
}

//CONVERSOES DE FORMATACAO DE TEXTO DE MOEDAS--------------------------------------------------------------------------------------
//CONVERTE REAL -> DOLAR. paraDolar(valor:Float);
function paraDolar($valor) {
	if ($valor) {
		$valor = str_replace('.','',$valor);
		$valor = str_replace(',','.',$valor);
	}
	return $valor;
}

//CONVERTE DOLAR -> REAL. paraReal(valor:Float);
function paraReal($valor) {
	if ($valor) {
		$valor = number_format($valor, 2, ',', '.');
	}
	return $valor;
}
//---------------------------------------------------------------------------------------------------------------------------------

//AJAX CORREÇÃO DE ACENTOS;
function crossUrlDecode($source) {
	$decodedStr = '';
	$pos = 0;
	$len = strlen($source);
	
	while ($pos < $len) {
		$charAt = substr ($source, $pos, 1);
	
		if ($charAt == '?') {
			$char2 = substr($source, $pos, 2);
			$decodedStr .= htmlentities(utf8_decode($char2),ENT_QUOTES,'ISO-8859-1');
			$pos += 2;
		
		} elseif(ord($charAt) > 127) {
			$decodedStr .= "&#".ord($charAt).";";
			$pos++;
			
		} elseif($charAt == '%') {
			$pos++;
			$hex2 = substr($source, $pos, 2);
			$dechex = chr(hexdec($hex2));
	
			if($dechex == '?') {
					$pos += 2;
				
					if(substr($source, $pos, 1) == '%') {
						$pos++;
						$char2a = chr(hexdec(substr($source, $pos, 2)));
						$decodedStr .= htmlentities(utf8_decode($dechex . $char2a),ENT_QUOTES,'ISO-8859-1');
					} else {
						$decodedStr .= htmlentities(utf8_decode($dechex));
					}
					
			} else {
				$decodedStr .= $dechex;
			}
			$pos += 2;
				
		} else {
			$decodedStr .= $charAt;
			$pos++;
		}
	}
	
	return $decodedStr;
}
//---------------------------------------------------------------------------------------------------------------------------------

//LIMPA NOMES. limpaNome(nome:String);
function limpaNome($nome) {
	$arrReplace['a'] = array('Á', 'á', 'À', 'à', 'Ã', 'ã', 'Â', 'â');
	$arrReplace['e'] = array('É', 'é', 'È', 'è', 'Ê', 'ê');
	$arrReplace['i'] = array('Í', 'í', 'Ì', 'ì', 'Í', 'í', 'Î', 'î');
	$arrReplace['o'] = array('Ó', 'ó', 'Ò', 'ò', 'Õ', 'õ', 'Ô', 'ô');
	$arrReplace['u'] = array('Ú', 'ú', 'Ù', 'ù', 'Û', 'û');
	$arrReplace['_'] = array(' ', '&', ']', '[', '{', '}', '(', ')', '=', '^', '~', '´', '`', '#', '@', '%', '¨', "'", '"', ':', ';', ',', '!', '+', '$');
	$arrReplace['c'] = array('ç', 'Ç');
	
	$chrs = array('a', 'e', 'i', 'o', 'u', '_', 'c');
	while (list($key, $chr) = each($chrs)) {
		$nome = str_replace($arrReplace[$chr], $chr, $nome);
	}
	
	return $nome;
}

function utf8tohtml($utf8, $encodeTags) {
    $result = '';
    for ($i = 0; $i < strlen($utf8); $i++) {
        $char = $utf8[$i];
        $ascii = ord($char);
        if ($ascii < 128) {
            // one-byte character
            $result .= ($encodeTags) ? htmlentities($char) : $char;
        } else if ($ascii < 192) {
            // non-utf8 character or not a start byte
        } else if ($ascii < 224) {
            // two-byte character
            $result .= htmlentities(substr($utf8, $i, 2), ENT_QUOTES, 'ISO-8859-1');
            $i++;
        } else if ($ascii < 240) {
            // three-byte character
            $ascii1 = ord($utf8[$i+1]);
            $ascii2 = ord($utf8[$i+2]);
            $unicode = (15 & $ascii) * 4096 +
                       (63 & $ascii1) * 64 +
                       (63 & $ascii2);
            $result .= "&#$unicode;";
            $i += 2;
        } else if ($ascii < 248) {
            // four-byte character
            $ascii1 = ord($utf8[$i+1]);
            $ascii2 = ord($utf8[$i+2]);
            $ascii3 = ord($utf8[$i+3]);
            $unicode = (15 & $ascii) * 262144 +
                       (63 & $ascii1) * 4096 +
                       (63 & $ascii2) * 64 +
                       (63 & $ascii3);
            $result .= "&#$unicode;";
            $i += 3;
        }
    }
    return $result;
}

echo utf8tohtml($anyUTF8string, TRUE);
?>