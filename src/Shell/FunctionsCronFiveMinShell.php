<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Mustache_Engine;
use Cake\Mailer\Email;
use Cake\Log\Log;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\I18n\DateTime;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Event\EventManager;
use \Google_Client;
use \Google_Service_Calendar;
use \Google_Service_Drive;
use \Google_Service_Plus;
use \Google_Service_Calendar_Event;
use \Google_Service_Calendar_EventDateTime;
use App\Controller\GoogleCalendarController;
use SoapClient;

/**
 * FunctionsCronFiveMin shell command.
 */
class FunctionsCronFiveMinShell extends Shell
{

    private $eventManager;

    public function initialize()
    {
        parent::initialize();
        $this->loadModel("Utilisateurs");
        $this->loadModel("Lieugeos");
        $this->loadModel("Reservations");
        $this->loadModel("Annonces");
        $this->loadModel("Modelmailsysteme");
        $this->loadModel("Registres");
        $this->loadModel("Dispos");
        $this->eventManager = new EventManager();
    }
    
    private function eventManager(){
        return $this->eventManager;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        Log::write('info', 'START ALL FUNCTIONS CRON FIVE MIN');
        $this->findReservationOption30min(); 
        $this->verifierCommandePourProprietaire(); 
        Log::write('info', 'END ALL FUNCTIONS CRON FIVE MIN');
    }

    /**
     * findReservationOption30min() method
     */
    public function findReservationOption30min()
    {
        Log::write('info', 'Start Execute findReservationOption30min Function'); 
        $now = Time::now();
        $now->modify('-30 minutes');
        $hours = $now->format('Y-m-d H:i');
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'=>['Lieugeos','Villages']])->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d %H:%i') <= '".$hours."'", "Reservations.statut = 0", "Reservations.increment_id = 0"]);
        
        foreach ($listeReservations as $reservation) {
            try {
            // Supprimer la réservation + libérer la période + envoyer un email au locataire
            /* modification le statut de la réservation à 60 (supprimé non payé) */
            $a_reservation=array("statut"=>60,'updated_at'=>date('d-m-Y'));
            $reservationnew=$this->Reservations->patchEntity($reservation,$a_reservation);
            $this->Reservations->save($reservation);
            /* Libérer la période */
            $dispos=$this->Dispos->find('all',['conditions'=>['Dispos.reservation_id'=>$reservation->id]]);
            foreach ($dispos as $dispo) {
                $a_dispo=array('statut'=>0,'utilisateur_id'=>null,'reservation_id'=>null);
                $dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
                $this->Dispos->save($dispo);
            }
            /* Envoyer un email au locataire */
            $annonce=$this->Annonces->get($reservation->annonce_id);
            $prop=$this->Utilisateurs->get($annonce->proprietaire_id);
            $loc=$this->Utilisateurs->get($reservation->utilisateur_id);
            $mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
            $mail=$mails->first();
            $datamustache = array('nomprop' => $prop->nom_famille, 'prenomprop' => $prop->prenom, 'annonce' => $annonce->id, 'prenom' => $loc->prenom, 'nom' => $loc->nom_famille, 'debut' => $reservation->dbt_at, 'fin' =>$reservation->fin_at);
            // #####################################################
            Log::write('info', 'findReservationOption30min ReservationID '.$reservation->id);
            // #####################################################
            // Supprimer panier dans boutique
            //**** informations a utiliser toujours ********************//
            $magentoURL = 'https://www.boutique.alpissime.com/';
            // $station = "fr";
            $station = $reservation['annonce']['village']['input_boutique'];
            // Récupérer  le token
            $data = array("username" => "API.ACCESS", "password" => "86>;];wzO+Q#");
            $data_string = json_encode($data);
            $ch = curl_init($magentoURL . "index.php/rest/" . $station . "/V1/integration/admin/token");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Length: " . strlen($data_string)));
            $token = curl_exec($ch);
            $token = json_decode($token);
            $quote_id = $reservation->quote_id;
            if($quote_id != 0){
                //  Vider panier apres 30 min sans mettre info bancaire
                $ch = curl_init($magentoURL . "rest/" . $station . "/V1/carts/" . $quote_id . "/emptyCart");
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
                $result = curl_exec($ch);
                $result = json_decode($result, true);
                // echo '<pre>';print_r($result);
            }            
            } catch (\Throwable $th) {
                // throw $th;
                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail=$mails->first();
                // #####################################################
                $email = new Email('production');
                $email->to('maroua.c@ite.digital')
                    ->addTo('hello@alpissime.com')
                    ->from([$mail->val=>FROM_MAIL])
                    ->subject('Erreur dans fichier CRON')
                    ->emailFormat('html')
                    ->send('Bonjour, <br><br> Erreur Function findReservationOption30min : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute findReservationOption30min Function'); 
    }
    /**
     * verifierCommandePourProprietaire() method
     */
    public function verifierCommandePourProprietaire()
    {
        Log::write('info', 'Start Execute verifierCommandePourProprietaire Function'); 
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.dbt_at > CURDATE()", "Reservations.statut = 0", "Reservations.increment_id <> 0", "Reservations.verif_for_prop = 0"]);
        foreach ($listeReservations as $reservation) {
            try {
            // Fonction boutique qui retourne statut commande à partir de son id
            // On a changer par : si on a commande_id c'est qu'il a bien entrer ses infos !!!!!!
            // 
            // Si le statut "attente validation propriétaire" on change statut réservation vers 50 (option payé) + on lance les emails vers prop + admin + gestionnaire
            // if($statut_boutique == 0){
                /* On récupère l'ID commande */
                $magentoURL = 'https://www.boutique.alpissime.com/'; // a changer pour le com
                $IncrementId = $reservation->increment_id; //tu le récupère de ta base de donnée
                $ch = curl_init($magentoURL . "index.php/rest/all/V1/cakephp/getOrderId?IncrementId=".$IncrementId);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
                $resultat = curl_exec($ch);
                $commande_id = json_decode($resultat);
                curl_close($curl); 

                if(!is_numeric($commande_id)){
                    // throw $th;
                    $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                    $mail=$mails->first();
                    // #####################################################
                    $email = new Email('production');
                    $email->to('maroua.c@ite.digital')
                        // ->addTo('hello@alpissime.com')
                        ->from([$mail->val=>FROM_MAIL])
                        ->subject('Retour Commande_id')
                        ->emailFormat('html')
                        ->send('Bonjour, <br><br> Erreur verifier Commande Pour Proprietaire : <br><br> '.$resultat.'<br><br> commande_id : '.$commande_id.'<br><br> increment_id : '.$IncrementId);
                }

                /* modification le statut de la réservation à 50 (option payé) */
                $a_reservation=array("statut"=>50,'updated_at'=>date('d-m-Y'), "verif_for_prop"=>1, "commande_id"=>$commande_id);
                $reservationnew=$this->Reservations->patchEntity($reservation,$a_reservation);
                $this->Reservations->save($reservation);                               
                /* on lance les emails vers prop + admin + gestionnaire */  
                $user = $this->Utilisateurs->get($reservation['annonce']['proprietaire_id']);
                $locataire = $this->Utilisateurs->get($reservation->utilisateur_id);          
                $annonce = $this->Annonces->get($reservation->annonce_id);
                $lieugeo=$this->Lieugeos->get($reservation['annonce']['lieugeo_id']);

                $datamustache = [
                    'nomprop'        => $user->nom_famille,
                    'prenomprop'     => $user->prenom,
                    'telprop'        => $user->portable,
                    'emailprop'      => $user->email,
                    'annonce'        => $annonce->id,
                    'station'        => $lieugeo->name,
                    'debut'          => $reservation->dbt_at,
                    'fin'            => $reservation->fin_at,
                    'nbrEnfant'      => $reservation->nb_enfants,
                    'nbrAdulte'      => $reservation->nb_adultes,
                    'prenom'         => $locataire->prenom,
                    'nom'            => $locataire->nom_famille,
                    'tel'            => $locataire->portable,
                    'email'          => $locataire->email,
                    'blockreduction' => $creationReservationLocpaiementdirectHidden
                ];
                                    
                $mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
                $mail=$mails->first();
                // #####################################################
                $event = new Event('Email.send', $this,
                    [
                        'from'=>[$mail->val=>FROM_MAIL],
                        'to' => $user,
                        'textEmail'=>'creationReservation',
                        'data'=>$datamustache,
                        'template'=>'creationReservation',
                        'viewVars'=>'creationReservation',
                        'noReply'=>false
                    ]
                );
                $this->eventManager()->dispatch($event);
                Log::write('info', 'Send mail creationReservation to '.$user->email);
                // #####################################################
                $event = new Event('Email.send', $this,
                    [
                        'from'=>[$mail->val=>FROM_MAIL],
                        'to' => $locataire,
                        'textEmail'=>'creationReservationLoc',
                		'data'=>array_merge($datamustache, ['reservationURL' => Configure::read('site_url', 'https://www.alpissime.com/') . "reservations/view_reservation/" . $reservation->id]),
                        'template'=>'creationReservationLoc',
                        'viewVars'=>'creationReservationLoc',
                        'noReply'=>false
                    ]
                );
                $this->eventManager()->dispatch($event);
		        // #####################################################
                $event = new Event('Email.send', $this, ['from'=>trim($user->email),'to' => $mail->val,'textEmail'=>'creationReservationAdm',
                                                            'data'=>$datamustache,'template'=>'creationReservationAdm','viewVars'=>'creationReservationAdm','noReply'=>false]);
                $this->eventManager()->dispatch($event);
                // #####################################################
                //Envoyer copie pour gestionnaire s'il existe 
                $this->loadModel("Gestionnaires");
                if($annonce->id_gestionnaires != 0){
                    $anngest = $this->Gestionnaires->find()->where(['id'=>$annonce->id_gestionnaires]);
                }else{
                    $anngest = $this->Gestionnaires->find("all")->join([
                        'GV' => [
                            'table' => 'gestionnaires_villages',
                            'type' => 'inner',
                            'conditions' => ['Gestionnaires.id=GV.gestionnaire_id','GV.villages_id'=>$annonce->village]
                        ]
                    ]);
                }                
                if($anngestnew = $anngest->first()){
                    $gestio = $anngestnew;
                    $event = new Event('Email.send', $this, ['from'=>trim($user->email),'to' => $gestio->email,'textEmail'=>'creationReservationAdm',
                            'data'=>$datamustache,'template'=>'creationReservationAdm','viewVars'=>'creationReservationAdm','noReply'=>false]);
                    $this->eventManager()->dispatch($event);
                }
                // if(PROD_ON == 1){
                    /* envoie sms vers propriétaire */
                    $datamustachesms = array('prenom' => $locataire->prenom, 'nom' => $locataire->nom_famille);
                    $sendToprop = $user->portable;
                    // #####################################################
                    $event = new Event('Email.sendSms', $this, ['from'=>"alpissime",'to' => $sendToprop,'textSms'=>'verifierCommandePourProprietaire',
                                                            'data'=>$datamustachesms
                                                            ]);
                    $this->eventManager()->dispatch($event);
                    // #####################################################
                    Log::write('info', 'Send sms verifierCommandePourProprietaire to '.$user->email);
                    /* envoie sms vers locataire */
                    $datamustachesmsloc = array('prenomprop' => $user->prenom, 'nomprop' => $user->nom_famille);
                    $sendToloc = $locataire->portable;
                    // #####################################################
                    $event = new Event('Email.sendSms', $this, ['from'=>"alpissime",'to' => $sendToloc,'textSms'=>'confirmationDemandeReservationLoc',
                                                            'data'=>$datamustachesmsloc
                                                            ]);
                    $this->eventManager()->dispatch($event);
                    // #####################################################
                    Log::write('info', 'Send sms confirmationDemandeReservationLoc to '.$locataire->email);
                // }                

            // }
            } catch (\Throwable $th) {
                // throw $th;
                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail=$mails->first();
                // #####################################################
                $email = new Email('production');
                $email->to('maroua.c@ite.digital')
                    ->addTo('hello@alpissime.com')
                    ->from([$mail->val=>FROM_MAIL])
                    ->subject('Erreur dans fichier CRON')
                    ->emailFormat('html')
                    ->send('Bonjour, <br><br> Erreur Function verifierCommandePourProprietaire : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute verifierCommandePourProprietaire Function'); 
    }
    /**
     *
     **/
	function getFormatFrenchPhoneNumber($phoneNumber, $international = false){
        //Supprimer tous les caractères qui ne sont pas des chiffres
        $phoneNumber = preg_replace('/[^0-9]+/', '', $phoneNumber);
        //On commence par traiter les cas des numéros en france
          $returnValue = preg_match('#^(33|0033)[0-9]{9}$#', $phoneNumber);
          $value = preg_match('#^(06)[0-9]{8}$#', $phoneNumber);
          $valueFR = preg_match('#^(073|074|075|076|077|078|079)[0-9]{7}$#', $phoneNumber);                
          $returnValueBelge = preg_match('/^((32|0032)\s?|0)4(60|[56789]\d)(\s?\d{2}){3}$/', $phoneNumber);
          $returnValueUK = preg_match('#^(44|0044)[0-9]{10}$#', $phoneNumber);
          $valueUK = preg_match('#^(07|7)[0-9]{9}$#', $phoneNumber);
          $returnValueES = preg_match('#^(34|0034)[0-9]{9}$#', $phoneNumber);
          $valueES = preg_match('#^(6)[0-9]{8}$#', $phoneNumber);
          $returnValueRU = preg_match('#^(7|007)[0-9]{10}$#', $phoneNumber);
          $valueRU = preg_match('#^(4|8|9)[0-9]{9}$#', $phoneNumber);
          $returnValueLUX = preg_match('#^(352|00352)[0-9]{9}$#', $phoneNumber);
          $returnValueAL = preg_match('#^(49|0049)[0-9]{11}$#', $phoneNumber);
          $valueAL = preg_match('#^(15|16|17|015|016|017)[0-9]{9}$#', $phoneNumber);
          $returnValuePB = preg_match('#^(31|0031)[0-9]{9}$#', $phoneNumber);
          $valuePAB = preg_match('#^(03|3|01|1|04|4|05|5)[0-9]{8}$#', $phoneNumber);
          $valuePB = preg_match('#^(071|71|070|70|072|72)[0-9]{7}$#', $phoneNumber);
          $returnValueSUI = preg_match('#^(41|0041)[0-9]{9}$#', $phoneNumber);
                  $returnValueSUED = preg_match('#^(46|0046)[0-9]{9}$#', $phoneNumber);
                  $returnValueDANEM = preg_match('#^(45|0045)[0-9]{8}$#', $phoneNumber);
          if(($returnValue == 1) || ($value == 1) || ($valueFR == 1)){
              //On l'ecrit sous la forme +33(9chiffres)
              $phoneNumber = substr($phoneNumber, -9);
              $motif = $international ? '+33\1\2\3\4\5' : '0\1\2\3\4\5';
              $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
              return $phoneNumber;
          }elseif ($returnValueBelge == 1) {
              //On traite les cas des numéro en belgique
              $phoneNumber = substr($phoneNumber, -9);
              $motif = $international ? '+32\1\2\3\4\5' : '0\1\2\3\4\5';
              $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
              return $phoneNumber;
          }elseif (($returnValueUK == 1) || ($valueUK == 1)) {
              //On traite les cas des numéro en UK
              $phoneNumber = substr($phoneNumber, -10);
              $motif = $international ? '+44\1\2\3\4\5' : '0\1\2\3\4\5';
              $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
              return $phoneNumber;
          }elseif (($returnValueES == 1) || ($valueES == 1)) {
              //On traite les cas des numéro en espagne
              $phoneNumber = substr($phoneNumber, -9);
              $motif = $international ? '+34\1\2\3\4\5' : '0\1\2\3\4\5';
              $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
              return $phoneNumber;
          }elseif (($returnValueRU == 1) || ($valueRU == 1)) {
              //On traite les cas des numéro en russie
              $phoneNumber = substr($phoneNumber, -10);
              $motif = $international ? '+7\1\2\3\4\5' : '0\1\2\3\4\5';
              $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
              return $phoneNumber;
          }elseif ($returnValueLUX == 1) {
              //On traite les cas des numéro en luxembourg
              $phoneNumber = substr($phoneNumber, -9);
              $motif = $international ? '+352\1\2\3\4\5' : '0\1\2\3\4\5';
              $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
              return $phoneNumber;
          }elseif (($returnValueAL == 1) || ($valueAL == 1)) {
              //On traite les cas des numéro en allemagne
              $phoneNumber = substr($phoneNumber, -11);
              $motif = $international ? '+49\1\2\3\4\5' : '0\1\2\3\4\5';
              $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
              return $phoneNumber;
          }elseif (($returnValuePB == 1) || ($valuePAB == 1) || ($valuePB == 1)) {
              //On traite les cas des numéro en pays-bas
              $phoneNumber = substr($phoneNumber, -9);
              $motif = $international ? '+31\1\2\3\4\5' : '0\1\2\3\4\5';
              $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
              return $phoneNumber;
          }elseif ($returnValueSUI == 1) {
              //On traite les cas des numéro en suisse
              $phoneNumber = substr($phoneNumber, -9);
              $motif = $international ? '+41\1\2\3\4\5' : '0\1\2\3\4\5';
              $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
              return $phoneNumber;
          }elseif ($returnValueSUED == 1){
                      //On traite les cas des numéro en suède
              $phoneNumber = substr($phoneNumber, -9);
              $motif = $international ? '+46\1\2\3\4\5' : '0\1\2\3\4\5';
              $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
              return $phoneNumber;
                  }elseif ($returnValueDANEM == 1) {
                    //On traite les cas des numéro en danemark
              $phoneNumber = substr($phoneNumber, -8);
              $motif = $international ? '+45\1\2\3\4\5' : '0\1\2\3\4\5';
              $phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
              return $phoneNumber;  
                  }else{
              $phoneNumber = '';
              return $phoneNumber;
          }
    }
}
