<?php
//use App\Controller\SendInBlueController;

  function getbyemail($email){
    // Déclaration des paramètres de connexion
    $host = 'localhost';
    $user = 'goalpissimechjq7';
    $bdd = 'goalpissimechjq7';
    $passwd = 'AeBie8pheif0';

    // Connexion au serveur
    $con = mysqli_connect($host, $user, $passwd, $bdd) or die("erreur de connexion au serveur");
    mysqli_set_charset( $con, 'utf8' );
    // Creation et envoi de la requete
    $query = 'SELECT * FROM utilisateurs WHERE email = "'.$email.'"';
    $result = mysqli_query($con, $query);
    // Recuperation des resultats
    $user = mysqli_fetch_assoc($result);
    if (!$user) {
      return "non";
    }else {
      return $user;
    }
  }

  function updatemailuser($oldemail,$newemail){
    // Déclaration des paramètres de connexion
    $host = 'localhost';
    $user = 'goalpissimechjq7';
    $bdd = 'goalpissimechjq7';
    $passwd = 'AeBie8pheif0';

    // Connexion au serveur
    $con = mysqli_connect($host, $user, $passwd, $bdd) or die("erreur de connexion au serveur");
    mysqli_set_charset( $con, 'utf8' );
    // Creation et envoi de la requete
    $query = 'UPDATE utilisateurs SET email="'.$newemail.'" WHERE email = "'.$oldemail.'"';

    if (mysqli_query($con, $query)) {
      return true;
    } else {
      return false;
    }
  }

  function updateuser($oldemail, $firstname, $lastname, $password, $newemail){
    // Déclaration des paramètres de connexion
    $host = 'localhost';
    $user = 'goalpissimechjq7';
    $bdd = 'goalpissimechjq7';
    $passwd = 'AeBie8pheif0';

    // Connexion au serveur
    $con = mysqli_connect($host, $user, $passwd, $bdd) or die("erreur de connexion au serveur");
    mysqli_set_charset( $con, 'utf8' );
    //Hash password
    $hashpass = password_hash($password,PASSWORD_DEFAULT);
    // Creation et envoi de la requete
    $query = 'UPDATE utilisateurs SET prenom= "'.$firstname.'", nom_famille="'.$lastname.'", email="'.$newemail.'", pwd="'.$hashpass.'" WHERE email = "'.$oldemail.'"';

    if (mysqli_query($con, $query)) {
//        $sendinblue=new SendInBlueController();
//      if($oldemail!=$newemail)
//          $sendinblue->updateContactEmail($oldemail,$newemail);
//      
//       $sendinblue->updateContactToSendInBlue($newemail,$firstname,$lastname,null,null,null,null,null,null,null);
      // Last ID inserted
      $lastuser = getbyemail($newemail);
      return $lastuser['id'];
      // return true;
    } else {
      return false;
    }
  }

  function adduser($firstname, $lastname, $password, $newemail, $nature){
    // Déclaration des paramètres de connexion
    $host = 'localhost';
    $user = 'goalpissimechjq7';
    $bdd = 'goalpissimechjq7';
    $passwd = 'AeBie8pheif0';

    // Connexion au serveur
    $con = mysqli_connect($host, $user, $passwd, $bdd) or die("erreur de connexion au serveur");
    mysqli_set_charset( $con, 'utf8' );
    //Hash password
    $hashpass = password_hash($password,PASSWORD_DEFAULT);
    // Creation et envoi de la requete
    $query = 'INSERT INTO utilisateurs (email, prenom, nom_famille, ident, pwd, nature) VALUES ("'.$newemail.'", "'.$firstname.'", "'.$lastname.'", "'.$newemail.'", "'.$hashpass.'", "'.$nature.'")';

    if (mysqli_query($con, $query)) {
      //verification mail
      $id_user = mysqli_insert_id($con);
      $dateexpire = date('Y-m-d', strtotime('+1 year'));
      $token=sha1($newemail.$hashpass);

      // $queryDelAll = 'DELETE FROM utilisateurs_tokens WHERE user_id = '.mysqli_insert_id($con);
      // mysqli_query($con, $queryDelAll);

      $queryTokenUtilisateur = 'INSERT INTO utilisateurs_tokens (user_id, token, expired_at) VALUES ("'.$id_user.'", "'.$token.'", "'.$dateexpire.'")';
      mysqli_query($con, $queryTokenUtilisateur);
      //end verification mail
//        $sendinblue=new SendInBlueController();
//       $sendinblue->addContactToSendInBlue($newemail,$firstname,$lastname,null,null,null,null,null,null,null,$nature);
      $lastuser = getbyemail($newemail);
      return $lastuser['id'];
      // return true;
    } else {
      return false;
    }
  }

  function getGroup($email){
    // Déclaration des paramètres de connexion
    $host = 'localhost';
    $user = 'goalpissimechjq7';
    $bdd = 'goalpissimechjq7';
    $passwd = 'AeBie8pheif0';

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
      if($annContrat != ''){
        return 7;
      }else{
        $anQuery = "SELECT * FROM annonces AS a WHERE a.statut = 50 AND a.proprietaire_id = ".$user['id'];
        $anResult =  mysqli_query($con, $anQuery);
        $annonce = mysqli_fetch_assoc($anResult);
        if($annonce != ''){
            return 9;
        }else{
            return 5; 
        }          
      }
    }else if($user && $user['nature'] == 'CLT'){
      // Traitement pour locataire
      $reservContQuery = "SELECT * FROM reservations AS r INNER JOIN annonces AS a ON r.annonce_id = a.id INNER JOIN contrats AS c ON c.annonce_id = a.id WHERE a.statut = 50 AND r.fin_at > CURRENT_DATE AND r.statut <> 10 AND r.statut <> 60 AND r.statut <> 100 AND r.statut <> 110 AND a.contrat = 1 AND r.utilisateur_id = ".$user['id'];
      $reservContResult = mysqli_query($con, $reservContQuery);
      $reservContrat = mysqli_fetch_assoc($reservContResult);
      if($reservContrat != ''){
        return 8;
      }else{
        $reservQuery = "SELECT * FROM reservations AS r INNER JOIN annonces AS a ON r.annonce_id = a.id WHERE a.statut = 50 AND r.fin_at > CURRENT_DATE AND r.statut <> 10 AND r.statut <> 60 AND r.statut <> 100 AND r.statut <> 110 AND r.utilisateur_id = ".$user['id'];
        $reservResult = mysqli_query($con, $reservQuery);
        $reserv = mysqli_fetch_assoc($reservResult);
        if($reserv != ''){
            return 10;
        }else{
            return 5; 
        }    
      }
    }else{
      return 5;
    }
  }
  
  function connect($email,$password){
    try {
        if (!empty($email) && !empty($password))
        {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://www.alpissime.com/api/get_location_user"); // changer alpissime.org par alpissime.com lors MEP
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "email=" . $email . "&pwd=" . $password);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output_location = curl_exec($ch); // return "connected" si connecté sinon "unauthorized"
                //var_dump($output_location);
                //$this->request->getPostValue('login')->getUsername();
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $cookie = substr($output_location, 0, $header_size);
                $headers = explode("\n", $cookie);
                foreach ($headers as $head) {
                    if (strpos($head, 'Set-Cookie') !== false) {
                        $cookie = $head;
                        break;
                    }
                }
                $val = explode('=', $cookie);
                $cookie_name = $val[0];
                $cookie_name = substr($cookie_name, strpos($cookie_name, ':') + 2, strlen($cookie_name));
                $cookie_val = substr($val[1], 0, strpos($val[1], ';'));
                if (isset($_COOKIE[$cookie_name])) unset($_COOKIE[$cookie_name]);
                setcookie($cookie_name, $cookie_val, 0, "/", '.alpissime.com'); // changer .alpissime.org par .alpissime.com lors MEP
                //$logger->info('AfterAddressSaveObserver.php: connexion sur alpissime.com'); //
                return true;
        }
        return false;
    } catch (\Exception $e){
        return $e;
    }
  }

  function setcommandeid($reservation_id, $commande_id)
  {
    // Déclaration des paramètres de connexion
    $host = 'localhost';
    $user = 'goalpissimechjq7';
    $bdd = 'goalpissimechjq7';
    $passwd = 'AeBie8pheif0';

    // Connexion au serveur
    $con = mysqli_connect($host, $user, $passwd, $bdd) or die("erreur de connexion au serveur");
    mysqli_set_charset( $con, 'utf8' );
    // Creation et envoi de la requete
    $query = 'UPDATE reservations SET increment_id="'.$commande_id.'" WHERE id = "'.$reservation_id.'"';

    if (mysqli_query($con, $query)) {
      return true;
    } else {
      return false;
    }
  }

  function getreservationdetails($reservation_id)
  {
    // Déclaration des paramètres de connexion
    $host = 'localhost';
    $user = 'goalpissimechjq7';
    $bdd = 'goalpissimechjq7';
    $passwd = 'AeBie8pheif0';

    // Connexion au serveur
    $con = mysqli_connect($host, $user, $passwd, $bdd) or die("erreur de connexion au serveur");
    mysqli_set_charset( $con, 'utf8' );
    // Creation et envoi de la requete
    $query = 'SELECT dbt_at, fin_at, prixreservation, prixtaxesejour, prixfraiservice, prixapayer, caution FROM reservations INNER JOIN annonces ON reservations.annonce_id = annonces.id WHERE reservations.id = "'.$reservation_id.'"';
    $result = mysqli_query($con, $query);
    // Recuperation des resultats
    $reservation = mysqli_fetch_assoc($result);
    return $reservation;

    /* Exemple Résultat : 
    Array
    (
        [dbt_at] => 2020-09-17
        [fin_at] => 2020-09-19
        [prixreservation] => 40
        [prixtaxesejour] => 4.8
        [prixfraiservice] => 2.56
        [caution] => 0
    )
    */

  }

  function deletereservation($quote_id)
  {
    // Déclaration des paramètres de connexion
    $host = 'localhost';
    $user = 'goalpissimechjq7';
    $bdd = 'goalpissimechjq7';
    $passwd = 'AeBie8pheif0';

    // Connexion au serveur
    $con = mysqli_connect($host, $user, $passwd, $bdd) or die("erreur de connexion au serveur");
    mysqli_set_charset( $con, 'utf8' );
    // Creation et envoi de la requete
    $query = 'SELECT * FROM reservations WHERE reservations.statut = 0 AND reservations.quote_id = "'.$quote_id.'"';
    $result = mysqli_query($con, $query);
    // Recuperation des resultats
    while($reservation = mysqli_fetch_array( $result )) {
      // changer statut reservation
      $reservation_id = $reservation['id'];
      $querystatut = 'UPDATE reservations SET statut=60 WHERE id = "'.$reservation_id.'"';
      $resultstatut = mysqli_query($con, $querystatut);
      // libérer dispos
      $querydispo = 'SELECT * FROM dispos WHERE reservation_id = "'.$reservation_id.'"';
      $resultdispo = mysqli_query($con, $querydispo);
      while($dispo = mysqli_fetch_array( $resultdispo )) {
        $querystatutdispo = 'UPDATE dispos SET statut=0, utilisateur_id=NULL, reservation_id=NULL WHERE id = "'.$dispo['id'].'"';
        $resultstatutdispo = mysqli_query($con, $querystatutdispo);    
      }   
    } 
      
    return true;
    
  }
  

 ?>
