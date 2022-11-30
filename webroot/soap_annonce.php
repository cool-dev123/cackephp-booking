<?php 
$wsdl="http://www.alpissime.biz/app/webroot/location3/annonces/wsdl";
$service=new SoapClient($wsdl);
print_r($service);
$taballservices=$service->setUtilisateurLocation('saber','boussada','saber_123@gmail.fr','saber_123','CLT','23015133','20145879');
//On renvoie le résutat de notre méthode, pour voir....
print_r(json_decode($taballservices));

		
?>