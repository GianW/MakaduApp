<?php
function rem_img($caminho,$id,$tabelaimg,$campo,$campoid) {
	$sql="select $campo from $tabelaimg where $campoid=$id";
	$rsImg=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($rsImg)<=0) return;
	$img=mysql_result($rsImg,0,$campo);
	
	if (file_exists($caminho.$img))
		unlink($caminho.$img);

	$iniNome = array("pp_","p_","m_","g_","gg_");
	for ($i=0; $i<sizeof($iniNome); $i++) {
		if(file_exists($caminho.$iniNome[$i].$img)){
			unlink($caminho.$iniNome[$i].$img);
		}
	}	
}

function upload($imagem,$type,$maxWidth,$maxHeight,$radical,$id,$tabelaimg,$campoimg,$campoid,$destino){
	if ($imagem!='none') {
		$picInfos = getimagesize($imagem);
		$width = $picInfos[0];
		$height = $picInfos[1];
		if ($width > $maxWidth & $height <= $maxHeight) {
			$ratio = $maxWidth / $width;
		} elseif ($height > $maxHeight & $width <= $maxWidth) {
			$ratio = $maxHeight / $height;
		} elseif ($width > $maxWidth & $height > $maxHeight ) {
			$ratio1 = $maxWidth / $width;
			$ratio2 = $maxHeight / $height;
			$ratio = ($ratio1 < $ratio2)? $ratio1:$ratio2;
		} else {
			$ratio = 1;
		}
		$nWidth = floor($width*$ratio);
		$nHeight = floor($height*$ratio);
		
		switch ($type) {
			case 'jpeg':
				$ext = '.jpg';
				$nome = $radical.'_'.$id.$ext;
				$sql = "UPDATE $tabelaimg SET $campoimg = '$nome' WHERE $campoid=$id";
				$rs = mysql_query($sql);
				if (file_exists($destino.$nome))
					unlink($destino.$nome);
				$img = imagecreatefromjpeg($imagem);
				$canvas = imagecreatetruecolor ($nWidth,$nHeight);
				imagecopyresampled($canvas, $img, 0, 0, 0, 0, $nWidth, $nHeight, $width, $height);
				imagejpeg($canvas,"$destino".$nome,100);
			break;
			case 'jpg':
				$ext = '.jpg';
				$nome = $radical.'_'.$id.$ext;
				$sql = "UPDATE $tabelaimg SET $campoimg = '$nome' WHERE $campoid=$id";
				$rs = mysql_query($sql);
				if (file_exists($destino.$nome))
					unlink($destino.$nome);
				$img = imagecreatefromjpeg($imagem);
				$canvas = imagecreatetruecolor ($nWidth,$nHeight);
				imagecopyresampled($canvas, $img, 0, 0, 0, 0, $nWidth, $nHeight, $width, $height);
				imagejpeg($canvas,"$destino".$nome,100);			
			break;
			case 'gif' :
				$ext = '.gif';
				$nome = $radical.'_'.$id.$ext;
				$sql = "UPDATE $tabelaimg SET $campoimg = '$nome' WHERE $campoid=$id";
				$rs = mysql_query($sql);
				if (file_exists($destino.$nome))
					unlink($destino.$nome);
				$img = imagecreatefromgif($imagem);	
				$canvas = imagecreatetruecolor ($nWidth,$nHeight);
				imagecopyresampled($canvas, $img, 0, 0, 0, 0, $nWidth, $nHeight, $width, $height);
				imagegif($canvas,"$destino".$nome);		
			break;
			case 'png' :
				$ext = '.png';
				$nome = $radical.'_'.$id.$ext;
				$sql = "UPDATE $tabelaimg SET $campoimg = '$nome' WHERE $campoid=$id";
				$rs = mysql_query($sql);
				if (file_exists($destino.$nome))
					unlink($destino.$nome);
				$img = imagecreatefrompng($imagem);
				imagesavealpha($img,true);
				
				$canvas = imagecreatetruecolor ($nWidth,$nHeight);
				imagesavealpha($canvas,true);
				
				$trans = imagecolorallocatealpha($canvas,255,255,255,127);
				imagefill($canvas,0,0,$trans);
				imagecopyresampled($canvas,$img,0,0,0,0,$nWidth,$nHeight,$width,$height);
				imagepng($canvas,"$destino".$nome);			
			break;
		}
	}
}
?>