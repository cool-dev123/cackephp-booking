<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\Utility\Xml;
use \SoapServer;
use \Panier;
use Cake\Datasource\ConnectionManager;
/**
 * Webservice Controller
 *
 *
 */
class WebserviceController extends AppController
{
    public $name = 'Events';
    public $paginate = ['limit' => 15];
	//Create on date 22-02-17
    public function feedService()
    {
        $this->viewBuilder()->layout('ajax');
        $conn = ConnectionManager::get('default');
        $stmt = $conn->execute("select P.prenom as prenom_proprio,P.nom_famille as nom_proprio, P.email as email_proprio,
            L.prenom as prenom_loc,L.nom_famille as nom_loc,R.dbt_at,R.fin_at,IF(D.promo_yn = 0, D.prix, D.promo_px)
                                as prix,G.name as gestionnaire,RS.name as residence,LG.name as station,L.email as
                                mail_locataire,L.portable as locataire_port1,L.portable2 as locataire_port2,P.email as
                                mail_prop,P.portable as proprietaire_port1,P.portable2 as
                                proprietaire_port2,A.num_app,DATEDIFF(R.fin_at,R.dbt_at) as duration,R.comment as
                                commentaire
                                from reservations R
                                inner join utilisateurs L on R.utilisateur_id=L.id
                                inner join annonces A on A.id=R.annonce_id
                                inner join lieugeos LG on A.lieugeo_id=LG.id
                                inner join utilisateurs P on P.id=A.proprietaire_id
                                inner join dispos D on D.reservation_id=R.id
                                inner join residences RS on A.batiment=RS.id
                                left join annoncegestionnaires AG on AG.id_annonces=A.id
                                left join gestionnaires G on AG.id_gestionnaires=G.id
                                where R.statut= 90 and R.dbt_at>=NOW()
                                group by R.id order by R.dbt_at DESC");

        $results = $stmt ->fetchAll('assoc');
        $mainarray = array();
        foreach($results as $event) {
          $portable_prop2 = ($event['proprietaire_port2']=='') ? '000000000' : $event['proprietaire_port2'];
          $portable_locataire2 = ($event['locataire_port2']=='') ? '000000000' : $event['locataire_port2'];
          $mainarray[] = array(
                              "Gestionnaire" => $event['gestionnaire'],
                              "Station" => $event['station'],
                              "Résidence" => $event['residence'],
                              "Propriétaire nom" => $event['nom_proprio'],
                              "Propriétaire prénom" => $event['prenom_proprio'],
                              "Propriétaire email" => $event['email_proprio'],
                              "Propriétaire n° de portable 1" => $event['proprietaire_port1'],
                              "Propriétaire n° de portable 2" => $portable_prop2,
                              "Propriétaire n° de portable 3" => "000000000",
                              "Propriétaire n° de portable 4" => "000000000",
                              "Locataire nom" => $event['nom_loc'],
                              "Locataire prénom" => $event['prenom_loc'],
                              "Locataire email" => $event['mail_locataire'],
                              "Locataire n° de portable 1" => $event['locataire_port1'],
                              "Locataire n° de portable 2" => $portable_locataire2,
                              "Locataire n° de portable 3" => "000000000",
                              "Locataire n° de portable 4" => "000000000",
                              "Locataire date d'arrivée" => $event['dbt_at'],
                              "Locataire date de départ" => $event['fin_at'],
                              "Appartement prix periode" => $event['prix'],
                              "Date periode" => $event['duration'],
                              "Appartement prix taxe de séjour" => "0",
                              "Commentaires" => $event['commentaire']

                          );
        }
       print_r(json_encode($mainarray)); die;
    }
    /**
  	 *
  	 **/
    public function feedInsertService()
    {
        $url = SITE_ALPISSIME."/service/eventsFeed";
        //  Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);
        echo "<pre>";
        print_r(json_decode($result, true));
        die;
    }

}
