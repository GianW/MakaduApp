<?php    
include_once('../../incs/conn.php');
include_once('../../incs/session.php');
include_once('../../incs/funcoes.php');
include_once('../../incs/class.date.php');

//QUERY PRINCIPAL
$sql = "";

$busca = mysql_query($sql);		
		
if(mysql_num_rows($busca)) {
	$_file = "analytics.csv";
	if(is_file("analytics.csv")){
		unlink($_file);
	}
	$_fp = fopen($_file, 'w');

	fwrite( $_fp, "NOME;E-MAIL\n");
	while ($reg = mysql_fetch_array($busca)) {			
			$_csv_data = "$nome;$email;\n";
			$_csv_data = utf8_decode($_csv_data);
			fwrite( $_fp, $_csv_data );				
	}
	fclose($_fp); 	
}

if(is_file("analytics.csv")){
	header('Content-Type: application/csv'); 
	header('Content-Disposition: attachment; filename=analytics.csv'); 
	header('Pragma: no-cache'); 
	readfile('analytics.csv'); 
}

?>