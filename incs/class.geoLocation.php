<?php
date_default_timezone_set('America/Sao_Paulo');
 
/**
 
 Geolocation Class is stupid simple it's uses Google Maps Webservice to grab geo location or just simple
 Latitude and Logitude from requested address
 
   We have two simple methods getGeoInfo and getLatLong
 
    getGeoInfo - Returns all Data from requested address
	getLatLong - Returns only coordinates of Latitude and Longitude
 
 
	This class is provided by twitter.com/igorcosta
 
	For more info on Google geocoding visit http://code.google.com/apis/maps/documentation/geocoding
 */
class Geolocation {
 
 
			/**
			Return all geo information against requested address
			*/
 
			public function getGeoInfo($endereco)
			{
				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($endereco). "&sensor=false&language=pt-BR";
				$retorno = false;
 
				if(!is_string($endereco))
					die('Precisa ser em String');
				else
					$resultado = file_get_contents($url);
 
					$retorno = json_decode($resultado);
 
				return $retorno;
			}
 
			/**
			 Status : "OK"  indicates that no errors occurred; the address was successfully parsed and at least one geocode was returned.
			 Status : "ZERO_RESULTS" indicates that the geocode was successful but returned no results.
			 Status : "OVER_QUERY_LIMIT" indicates that you are over your quota.
			 Status : "REQUEST_DENIED" indicates that your request was denied, generally because of lack of a sensor parameter.
			 Status : "INVALID_REQUEST" generally indicates that the query (address or latlng) is missing.
			*/
			public function getLatLong($endereco)
			{
				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($endereco). "&sensor=false&language=pt-BR";
				$retorno = false;
 
					$resultado = file_get_contents($url);
					$retorno = json_decode($resultado);
					if($retorno->status == "OK")
					{
						foreach ($retorno->results as $item)
						{
							$loc = $item->geometry;
							foreach ($loc as $location)
							{
								$lat = $loc->location->lat;
								$long = $loc->location->lng;
							}
						}
						$coordenadas = array($lat,$long);
						$retorno = $coordenadas;
					}else{
						$resp['resposta'] = $retorno->status;
						$retorno = $resp;
 
					}
 
				return $retorno;
			}
 
}
?>