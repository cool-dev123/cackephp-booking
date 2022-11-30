<?php
echo "test code";
/*$host = 'localhost';
$user = 'alpissime-org';
$bdd = 'admin_location_org';
$passwd = '4oBk49_c';
$email = "testproprietaire2@protonmail.com";
// Connexion au serveur
$con = mysqli_connect($host, $user, $passwd, $bdd) or die("erreur de connexion au serveur");
mysqli_set_charset( $con, 'utf8' );
// Creation et envoi de la requete
$query = 'SELECT * FROM utilisateurs WHERE email = "'.$email.'"';
$result = mysqli_query($con, $query);
// Recuperation des resultats
$user = mysqli_fetch_assoc($result);
if($user && $user['nature'] != 'CLT'){
  // Traitement pour propriétaire
  $anContQuery = "SELECT * FROM annonces AS a INNER JOIN contrats AS c ON c.annonce_id = a.id WHERE a.statut = 50 AND a.contrat = 1 AND a.proprietaire_id = ".$user['id'];
  $anContResult =  mysqli_query($con, $anContQuery);
  $annContrat = mysqli_fetch_assoc($anContResult);
//   print_r($annContrat);
  if($annContrat != ''){
      echo 7;
    return 7;
  }else{
    $anQuery = "SELECT * FROM annonces AS a WHERE a.statut = 50 AND a.proprietaire_id = ".$user['id'];
    $anResult =  mysqli_query($con, $anQuery);
    $annonce = mysqli_fetch_assoc($anResult);
    if($annonce != ''){
        echo 9;
        return 9;
    }else{
        echo 5;
        return 5; 
    }
      
  }
}else if($user && $user['nature'] == 'CLT'){
  // Traitement pour locataire
  $reservContQuery = "SELECT * FROM reservations AS r INNER JOIN annonces AS a ON r.annonce_id = a.id INNER JOIN contrats AS c ON c.annonce_id = a.id WHERE a.statut = 50 AND r.fin_at > CURRENT_DATE AND r.statut <> 10 AND r.statut <> 60 AND r.statut <> 100 AND r.statut <> 110 AND a.contrat = 1 AND r.utilisateur_id = ".$user['id'];
  $reservContResult = mysqli_query($con, $reservContQuery);
  $reservContrat = mysqli_fetch_assoc($reservContResult);
  if($reservContrat != ''){
      echo 8;
    return 8;
  }else{
    $reservQuery = "SELECT * FROM reservations AS r INNER JOIN annonces AS a ON r.annonce_id = a.id WHERE a.statut = 50 AND r.fin_at > CURRENT_DATE AND r.statut <> 10 AND r.statut <> 60 AND r.statut <> 100 AND r.statut <> 110 AND r.utilisateur_id = ".$user['id'];
    $reservResult = mysqli_query($con, $reservQuery);
    $reserv = mysqli_fetch_assoc($reservResult);
    if($reserv != ''){
        echo 10;
        return 10;
    }else{
        echo 5;
        return 5; 
    }
    
  }
}else{
    echo 5;
  return 5;
}*/
?>