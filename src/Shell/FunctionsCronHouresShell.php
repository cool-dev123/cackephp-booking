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
use App\Controller\DisposController;
use SoapClient;

/**
 * FunctionsCronHoures shell command.
 */
class FunctionsCronHouresShell extends Shell
{

    private $eventManager;

    public function initialize()
    {
        parent::initialize();
        $this->loadModel("Utilisateurs");
        $this->loadModel("Reservations");
        $this->loadModel("Annonces");
        $this->loadModel("Modelmailsysteme");
        $this->loadModel("Registres");
        $this->loadModel("Contrats");
        $this->loadModel("Annoncegestionnaires");
        $this->loadModel("Gestionnaires");
        $this->loadModel("Dispos");
        $this->loadModel("Taxes");
        $this->loadModel("Lieugeos");        
        $this->loadModel("Villages"); 
        $this->loadModel("Calendarsynchro");       
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
        Log::write('info', 'START ALL FUNCTIONS CRON HOURES');
        // $this->findReservationOption10hours(); // Change it to "findReservationOption30min()" in FunctionsCronFiveMin
        // $this->verifierCommandePourProprietaire(); // Basculer vers FunctionsCronFiveMin
        $this->verifierAnnulationCommandeBoutique();
        $this->creationReservationRappel8h();
        $this->creationReservationRappel4hExpiration();
        $this->creationReservationExpiration();
        $this->infoInventaireLocataire();
        // $this->findReservationOption2hours();
        $this->infojustificatifdomicile24hours();
        $this->expirationdemandereservation24h();
        $this->expirationdemandereservation4h();
        $this->inscriptionPropSansAnnonce4h();
        $this->updateCalendarSynchro();
        $this->completerInventaireLoc();
        Log::write('info', 'END ALL FUNCTIONS CRON HOURES');
    }
    /**
     * creationReservationRappel8h() method.
     */
    public function creationReservationRappel8h()
    {
        Log::write('info', 'Start Execute creationReservationRappel8h Function'); 
        $now = new Time('-8 hours');
        $hours = $now->format('Y-m-d H');
        // $this->out();
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d %H') = '".$hours."'", "Reservations.statut = 50"]);
        // $this->out($listeReservations);
        foreach ($listeReservations as $reservation) {
            try {
            $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
            $lieugeo=$this->Lieugeos->get($reservation['annonce']->lieugeo_id);
            /**** Send Mail ****/
            $datamustache = array('prenomprop' => $proprietaire->prenom,'nomprop' => $proprietaire->nom_famille,'annonce' => $reservation['annonce']->id, 'station' => $lieugeo->name, 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'nbrEnfant' => $reservation->nb_enfants, 'nbrAdulte' => $reservation->nb_adultes, 'nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom, 'tel' => $reservation['utilisateur']->portable, 'email' => $reservation['utilisateur']->email);

            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();

            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire->email,'textEmail'=>'creationReservationRappel8h',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################

            Log::write('info', 'Send mail creationReservationRappel8h to '.$proprietaire->email);
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
                    ->send('Bonjour, <br><br> Erreur Function creationReservationRappel8h : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute creationReservationRappel8h Function'); 
    }
    /**
     * creationReservationRappel4hExpiration() method
     */
    public function creationReservationRappel4hExpiration()
    {
        Log::write('info', 'Start Execute creationReservationRappel4hExpiration Function'); 
        $now = Time::now();
        $now->subDays(2); 
        $now->modify('-4 hours');
        $hours = $now->format('Y-m-d H');
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d %H') = '".$hours."'", "Reservations.statut = 50"]);
        
        foreach ($listeReservations as $reservation) {
            try {
            $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
            $lieugeo=$this->Lieugeos->get($reservation['annonce']->lieugeo_id);
            /**** Send Mail ****/
            $datamustache = array('prenomprop' => $proprietaire->prenom,'nomprop' => $proprietaire->nom_famille,'annonce' => $reservation['annonce']->id, 'station' => $lieugeo->name, 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'nbrEnfant' => $reservation->nb_enfants, 'nbrAdulte' => $reservation->nb_adultes, 'nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom, 'tel' => $reservation['utilisateur']->portable, 'email' => $reservation['utilisateur']->email);

            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();

            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire->email,'textEmail'=>'creationReservationRappel4hExpiration',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################

            Log::write('info', 'Send mail creationReservationRappel4hExpiration to '.$proprietaire->email);
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
                    ->send('Bonjour, <br><br> Erreur Function creationReservationRappel4hExpiration : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute creationReservationRappel4hExpiration Function'); 
    }
    /**
     * creationReservationExpiration() method
     */
    public function creationReservationExpiration()
    {
        Log::write('info', 'Start Execute creationReservationExpiration Function'); 
        $now = Time::now();
        $now->subDays(2); 
        $hours = $now->format('Y-m-d H');
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d %H') = '".$hours."'", "Reservations.statut = 50"]);
        
        foreach ($listeReservations as $reservation) {
            try {
            $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
            $lieugeo=$this->Lieugeos->get($reservation['annonce']->lieugeo_id);
            $village=$this->Villages->get($reservation['annonce']->village);
            /**** Annulation de la réservation ****/
            //modification le statut de la réservation
            $a_reservation=array("statut"=>10,'updated_at'=>date('d-m-Y'));
            $reservation=$this->Reservations->patchEntity($reservation,$a_reservation);
            $this->Reservations->save($reservation);
            //modficataion le statu de disponibilité
            $this->loadModel("Dispos");
            $dispos=$this->Dispos->find('all',['conditions'=>['Dispos.reservation_id'=>$reservation->id]]);
            foreach ($dispos as $dispo) {
                $a_dispo=array('statut'=>100,'utilisateur_id'=>null,'reservation_id'=>null);
                $dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
                $this->Dispos->save($dispo);
            }
            // Changer le statut de la commande vers annulé
            //**** informations a utiliser toujours ********************//
            $magentoURL = 'https://www.boutique.alpissime.com/';
            // $station = "fr";
            $station = $village->input_boutique;
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
            $entity_id = $reservation->commande_id;
            // Mettre a jour le statut de la commande (il faut avoir le token)
            $order = '{
                "entity": {
                "entity_id": '.$entity_id.',
                    "state": "canceled",
                    "status": "reservation_annulee"
                }
            }';
            $ch = curl_init($magentoURL . "rest/" . $station . "/V1/orders");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $order);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
            $result = curl_exec($ch);
            $result = json_decode($result, true);            
            curl_close($curl);           

            /**** Send Mail ****/
            $datamustache = array('prenomprop' => $proprietaire->prenom,'nomprop' => $proprietaire->nom_famille,'annonce' => $reservation['annonce']->id, 'station' => $lieugeo->name, 'debut' => $reservation->dbt_at,'datedebut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'datefin' => $reservation->fin_at, 'nbrEnfant' => $reservation->nb_enfants, 'nbrAdulte' => $reservation->nb_adultes, 'nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom, 'tel' => $reservation['utilisateur']->portable, 'email' => $reservation['utilisateur']->email);

            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();

            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire->email,'textEmail'=>'creationReservationExpiration',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################

            // if(PROD_ON == 1){
                /* envoie sms vers locataire */
                $datamustachesms = array('prenomprop' => $proprietaire->prenom, 'nomprop' => $proprietaire->nom_famille, 'reservation' => $reservation->id);
                $sendTo = $reservation['utilisateur']->portable;
                // #####################################################
                $event = new Event('Email.sendSms', $this, ['from'=>"alpissime",'to' => $sendTo,'textSms'=>'creationReservationExpiration',
                                                        'data'=>$datamustachesms
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################
                Log::write('info', 'Send sms creationReservationExpiration to '.$reservation['utilisateur']->email);

                /* envoie sms vers proprietaire */
                $datamustachesmsprop = array('prenom' => $reservation['utilisateur']->prenom, 'nom' => $reservation['utilisateur']->nom_famille, 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at);
                $sendToProp = $proprietaire->portable;
                // #####################################################
                $event = new Event('Email.sendSms', $this, ['from'=>"alpissime",'to' => $sendToProp,'textSms'=>'creationReservationExpirationProp',
                                                        'data'=>$datamustachesmsprop
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################
                Log::write('info', 'Send sms creationReservationExpirationProp to '.$proprietaire->email);
            // }
            
            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur']->email,'textEmail'=>'annulationreservationautomatique',
                                'data'=>$datamustache,'template'=>'refusReservationClt','viewVars'=>'refusReservationClt','noReply'=>false
                            ]);
            $this->eventManager()->dispatch($event);
            // #####################################################

            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>$proprietaire->email,'to' => $mail->val,'textEmail'=>'refusReservationClt',
                        'data'=>$datamustache,'template'=>'refusReservationClt','viewVars'=>'refusReservationClt','noReply'=>false
                    ]);
            $this->eventManager()->dispatch($event);

            Log::write('info', 'Send mail creationReservationExpiration to '.$proprietaire->email);
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
                    ->send('Bonjour, <br><br> Erreur Function creationReservationExpiration : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute creationReservationExpiration Function'); 
    }
    /**
     * findReservationOption10hours() method
     */
    public function findReservationOption10hours()
    {
        Log::write('info', 'Start Execute findReservationOption10hours Function'); 
        $now = Time::now();
        $now->modify('-5 hours');
        $hours = $now->format('Y-m-d H');
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'=>['Lieugeos','Villages']])->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d %H') <= '".$hours."'", "Reservations.statut = 0", "Reservations.increment_id = 0"]);
        
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
            // $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $loc,'textEmail'=>'findReservationOption10hours',
            //                                             'data'=>$datamustache,'template'=>'refusReservationClt','viewVars'=>'refusReservationClt','noReply'=>false
            //                                         ]);
            // $this->eventManager()->dispatch($event);
            // Log::write('info', 'Send mail findReservationOption10hours to '.$loc->email);
            Log::write('info', 'findReservationOption10hours ReservationID '.$reservation->id);
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
            //  Vider panier apres 10 heures sans mettre info bancaire
            $ch = curl_init($magentoURL . "rest/" . $station . "/V1/carts/" . $quote_id . "/emptyCart");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
            $result = curl_exec($ch);
            $result = json_decode($result, true);
            // echo '<pre>';print_r($result);
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
                    ->send('Bonjour, <br><br> Erreur Function findReservationOption10hours : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute findReservationOption10hours Function'); 
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
                    'nomprop' => $user->nom_famille,
                    'prenomprop' => $user->prenom,
                    'telprop' => $user->portable,
                    'emailprop' => $user->email,
                    'annonce' => $annonce->id,
                    'station' => $lieugeo->name,
                    'debut' => $reservation->dbt_at,
                    'fin' => $reservation->fin_at,
                    'nbrEnfant' => $reservation->nb_enfants,
                    'nbrAdulte' => $reservation->nb_adultes,
                    'prenom' => $locataire->prenom,
                    'nom' => $locataire->nom_famille,
                    'tel' => $locataire->portable,
                    'email' => $locataire->email,
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
                $event = new Event('Email.send', $this, ['from'=>$user->email,'to' => $mail->val,'textEmail'=>'creationReservationAdm',
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
                    $event = new Event('Email.send', $this, ['from'=>$user->email,'to' => $gestio->email,'textEmail'=>'creationReservationAdm',
                            'data'=>$datamustache,'template'=>'creationReservationAdm','viewVars'=>'creationReservationAdm','noReply'=>false]);
                    $this->eventManager()->dispatch($event);
                }
                /* envoie sms vers propriétaire */
                $soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.61.wsdl"); 	//login
                $session = $soap->login("dt29400-ovh", 'q}XcJ_"jLw',"fr", false);
                $portableprop = $this->getFormatFrenchPhoneNumber($user->portable,true);
                $smstext = "Vous avez une nouvelle demande de réservation de la part de ".$locataire->prenom." ".substr($locataire->nom_famille, 0, 1).". sur Alpissime.com ! Rendez-vous vite dans votre espace propriétaire pour l'accepter.";
                $soap->telephonySmsSend($session, "sms-dt29400-1", "alpissime",$portableprop,$smstext, "2880", "1", "0", "3", "1", "", true);
                $soap->logout($session);
                Log::write('info', 'Send sms to '.$user->email);

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
     * verifierAnnulationCommandeBoutique() method
     */
    public function verifierAnnulationCommandeBoutique()
    {
        Log::write('info', 'Start Execute verifierAnnulationCommandeBoutique Function');
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'=>['Lieugeos','Villages']])->where(["Reservations.dbt_at > CURDATE()", "Reservations.commande_id <> 0", "Reservations.statut <> 110", "Reservations.statut <> 10"]);
        foreach ($listeReservations as $reservation) {
            try {
            // Fonction boutique qui retourne statut commande à partir de son id
            $magentoURL = 'https://www.boutique.alpissime.com/'; // a changer pour le com
            // $station = "fr";
            $station = $reservation['annonce']['village']['input_boutique'];
            $entity_id = $reservation->commande_id;
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
            // Récupérer le statut actuel de la commande (il faut avoir le token)
            $ch = curl_init($magentoURL . "index.php/rest/" . $station . "/V1/orders/" . $entity_id . "/statuses");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
            $resultat = curl_exec($ch);
            $statut_commande = json_decode($resultat);
            curl_close($curl); 
            // Si le statut "annulé" on change statut réservation vers 110 (annulée)
            // Est ce qu'il y a d'autres statuts pour lesquelles je dois annulée ma réservation ??
            if($statut_commande == "\"reservation_annulee\""){
                /*** SUPPRESSION RESERVATION ***/			
                $id_googlecalendar = $reservation->id_googlecalendar;
                $debreservation = $reservation->dbt_at;
                $fnreservation = $reservation->fin_at;
                $anidreservation = $reservation->annonce_id;
                $dataannulreserv = array("statut"=>110);
				$reservationannul=$this->Reservations->patchEntity($reservation,$dataannulreserv);
				$this->Reservations->save($reservationannul);
				// Envoie mail (A FAIRE)
				// annulationreservationboutique vers locataire + admin
				// $datamustache = array('prenom' => $locataire->prenom, 'nom' => $locataire->nom_famille, 'prenomprop' => $proprietaire->prenom, 'nomprop' => $proprietaire->nom_famille, 'datedebut' => $reservation->dbt_at, 'datefin' => $reservation->fin_at);                       
				// $this->loadModel("Registres");
				// $mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
				// $mail=$mails->first();
				// // #####################################################
				// $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $locataire,'textEmail'=>'annulationreservationboutique',
				// 	'data'=>$datamustache,'template'=>'supressionReservationProp','viewVars'=>'supressionReservationProp','noReply'=>false
				// ]);
				// $this->eventManager()->dispatch($event);
				// // #####################################################
				// $event = new Event('Email.send', $this, ['from'=>$proprietaire->email,'to' => $mail->val,'textEmail'=>'annulationreservationboutique',
				// 	'data'=>$datamustache,'template'=>'supressionReservationProp','viewVars'=>'supressionReservationProp','noReply'=>false
				// ]);
				// $this->eventManager()->dispatch($event);
                // #####################################################
                // if(PROD_ON == 1){
                    /*** DELETE GOOGLE CALENDAR ***/
                    if($id_googlecalendar != NULL) {
                        $annonce=$this->Annonces->get($reservation->annonce_id);
                        if($annonce->id_gestionnaires != 0){
                            $gest_mail = $this->Gestionnaires->get($annonce->id_gestionnaires);
                            if($gest_mail->googlecalendar_id != "") $calendarID = $gest_mail->googlecalendar_id;
                            else $calendarID = 'admin@alpissime.com';
                        }else{
                            $calendarID = 'admin@alpissime.com';
                        }
                        $googleCalendar = new GoogleCalendarController();
                        $eventDelete = $googleCalendar->googlecalendardelete($id_googlecalendar, $calendarID);
                    }
                // }
                /*** Modification Statut de disponibilité ***/
                $dispos=$this->Dispos->find('all')->where(['Dispos.reservation_id'=>$id_reservation]);
                foreach ($dispos as $dispo) {
                    $a_dispo=array('statut'=>0,'utilisateur_id'=>null,'reservation_id'=>null);
                    $dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
                    $this->Dispos->save($dispo);
                }

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
                    ->send('Bonjour, <br><br> Erreur Function verifierAnnulationCommandeBoutique : <br><br> Token : '.$token.' <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute verifierAnnulationCommandeBoutique Function');
    }

    /**
     * infoInventaireLocataire() method
     */
    public function infoInventaireLocataire()
    {
        Log::write('info', 'Start Execute infoInventaireLocataire Function');
        $now = Time::now();
        $hours = $now->format('Y-m-d 17:00');

        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["DATE_FORMAT(Reservations.dbt_at, '%Y-%m-%d %H:%i') = '".$hours."'", "Reservations.statut = 90"]);

        // $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.id = 18360"]);
        foreach ($listeReservations as $reservation) {
            try {
                if ($reservation['annonce']->contrat == 0) {
                    /**** Send Mail ****/
                    $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
                    $urlInventaire = Configure::read('site_url', 'https://www.alpissime.com/') . "inventaires/" . $reservation['annonce']['inventaire'];
                    $urlInventairelocataire = Configure::read('site_url', 'https://www.alpissime.com/') . "annonces/uploadinventairelocataire/" . $reservation->id . "?token=".md5($reservation['utilisateur']->id);

                    $this->loadModel('BlocServicesMails');
                    $stat_annonce = $reservation['annonce']->lieugeo_id;
                    $bloc_services_mail_first = $this->BlocServicesMails->find()->where(["(liste_id_station LIKE '$stat_annonce;%' OR liste_id_station LIKE '%;$stat_annonce;%')"])->first();

                    $datamustache = [
                        'bloc_services_mail' => $bloc_services_mail_first->bloc_services_mail,
                        'bloc_services_mail_en' => $bloc_services_mail_first->bloc_services_mail_en,
                        'nom' => $reservation['utilisateur']->nom_famille,
                        'prenom' => $reservation['utilisateur']->prenom,
                        'nomprop' => $proprietaire->nom_famille,
                        'prenomprop' => $proprietaire->prenom,
                        'url_inventaire' => $urlInventaire,
                        'url_inventaire_locataire' => $urlInventairelocataire
                    ];
                    $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                    $mail=$mails->first();

                    if(isset($reservation['annonce']['inventaire']) && $reservation['annonce']['inventaire'] != '') $textEmail = 'ArriveeLocataireSansContratInventaire';
                    else $textEmail = 'ArriveeLocataireSansContratSansInventaire';

                    // #####################################################
                    $event = new Event('Email.send', $this,
                        [
                            'from'=>[$mail->val=>FROM_MAIL],
                            'to' => $reservation['utilisateur'],
                            'textEmail'=>$textEmail,
                            'data'=>$datamustache,
                            'template'=>'creationAnnonce',
                            'viewVars'=>'creationAnnonce',
                            'noReply'=>false
                        ]
                    );
                    $this->eventManager()->dispatch($event);
                    // #####################################################

                    Log::write('info', 'Send mail infoInventaireLocataire "'.$textEmail.'" to '.$reservation['utilisateur']->email);
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
                    ->send('Bonjour, <br><br> Erreur Function infoInventaireLocataire : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute infoInventaireLocataire Function');
    }

   /**
     *
     */
    public function findReservationOption2hours()
    {
        Log::write('info', 'Start Execute findReservationOption2hours Function'); 
        $now = new Time('-2 hours');
        $hours = $now->format('Y-m-d H');
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d %H') = '".$hours."'", "Reservations.statut = 60"]);
        foreach ($listeReservations as $reservation) {
            try {
                $dispo = $this->Dispos->chercherdisponibilite($reservation['annonce']->id, $reservation->dbt_at->i18nFormat('yyyy-MM-dd'), $reservation->fin_at->i18nFormat('yyyy-MM-dd'));
				$dispoCount = $this->Dispos->chercherdisponibiliteCount($reservation['annonce']->id, $reservation->dbt_at->i18nFormat('yyyy-MM-dd'), $reservation->fin_at->i18nFormat('yyyy-MM-dd'));
				$dispoperiode = $this->Dispos->chercherdisponibiliteSansStatut($reservation['annonce']->id, $reservation->dbt_at->i18nFormat('yyyy-MM-dd'), $reservation->fin_at->i18nFormat('yyyy-MM-dd'));
				$nbrPeriodeDispos = $this->Dispos->chercherdisponibiliteCountSansStatut($reservation['annonce']->id, $reservation->dbt_at->i18nFormat('yyyy-MM-dd'), $reservation->fin_at->i18nFormat('yyyy-MM-dd'));

                if($dispoCount->count() != 0 && $dispoCount->count() == $nbrPeriodeDispos->count()){
                    $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
                    $lieugeo=$this->Lieugeos->get($reservation['annonce']->lieugeo_id);
                    /**** Send Mail ****/
                    $path = "https://www.alpissime.com";

                    $this->loadModel("Photos");
                    $photo = $this->Photos->find()->where(['annonce_id' => $reservation['annonce']->id])->order(['numero ASC'])->first();
                    // $nomImg = "vignette-".$photo->annonce_id."-".$photo->numero;

                    $annonce=$this->Annonces->get($photo->annonce_id, ['contain' => ['Lieugeos','Villages']]);
                    $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
                    $village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
                    $village_nom = str_replace(" – ", "-", $village_nom);
                    $village_nom = str_replace(" ", "-", $village_nom);
                    $nomImgG = $photo->titre;

                    $urlimage1 = 'https://www.alpissime.com/images_ann/'.$reservation['annonce']->id.'/'.$nomImgG;

                    $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
                    $lannonce = $this->string2url($annonce["titre"]);
                    $hrefDetailAnn = 'station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;
                    
                    $datamustache = array('titre_annonce' => $reservation['annonce']->titre,'description' => $reservation['annonce']->description,'imageannonce' => $urlimage1,'lien_boutique' => 'https://www.boutique.alpissime.com/'.$lieugeo->input_boutique.'/checkout/cart/','lien_annonce' => $path."/".$hrefDetailAnn,'date_debut' => $reservation->dbt_at,'date_fin' => $reservation->fin_at,'nb_adulte' => $reservation->nb_adultes,'nb_enfant' => $reservation->nb_enfants);

                    $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                    $mail=$mails->first();

                    // #####################################################
                    $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur']->email,'textEmail'=>'findReservationOption2hours',
                                                            'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                            ]);
                    $this->eventManager()->dispatch($event);
                    // #####################################################

                    Log::write('info', 'Send mail findReservationOption2hours to '.$reservation['utilisateur']->email);
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
                    ->send('Bonjour, <br><br> Erreur Function findReservationOption2hours : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute findReservationOption2hours Function'); 
    }
    /**
     * 
     */
    public function infojustificatifdomicile24hours()
    {
        Log::write('info', 'Start Execute infojustificatifdomicile24hours Function'); 
        $now = Time::now();
        $now->modify('-24 hours');
        $hours = $now->format('Y-m-d H');
        $listeAnnonces = $this->Annonces->find()->where(["DATE_FORMAT(Annonces.created_at, '%Y-%m-%d %H') = '".$hours."'", "(Annonces.statut = 0 OR Annonces.statut = 30 OR Annonces.statut = 50)", 'Annonces.justificatif_domicile = ""']);
        foreach ($listeAnnonces as $annonce) {
            try {
                /**** Send Mail ****/
                $proprietaire = $this->Utilisateurs->get($annonce->proprietaire_id);

                $datamustache = array('nomprop' => $proprietaire->nom_famille, 'prenomprop' => $proprietaire->prenom, 'numero_d_annonce' => $annonce->id);

                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail=$mails->first();

                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire->email,'textEmail'=>"infojustificatifdomicile24hours",
                                                        'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################

                Log::write('info', 'Send mail infojustificatifdomicile24hours to '.$proprietaire->email);
            
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
                    ->send('Bonjour, <br><br> Erreur Function infojustificatifdomicile24hours : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute infojustificatifdomicile24hours Function');
    }
    /**
     * 
     */
    public function expirationdemandereservation24h()
    {
        Log::write('info', 'Start Execute expirationdemandereservation24h Function'); 
        $now = Time::now();
        $now->subDays(2);
        $now->modify('-24 hours');
        $hours = $now->format('Y-m-d H');
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d %H') = '".$hours."'", "Reservations.statut = 50"]);
        foreach ($listeReservations as $reservation) {
            try{
                // if(PROD_ON == 1){
                    $datamustache = array('prenom' => $reservation['utilisateur']->prenom, 'nom' => $reservation['utilisateur']->nom_famille, 'reservation' => $reservation->id);
                    // print_r($reservation['annonce']->proprietaire_id);
                    $proprietaire = $this->Utilisateurs->find("all")->where(['id' => $reservation['annonce']->proprietaire_id]);
                    if($proprietaire = $proprietaire->first()){
                        $sendTo = $proprietaire->portable;
                        // #####################################################
                        $event = new Event('Email.sendSms', $this, ['from'=>"alpissime",'to' => $sendTo,'textSms'=>'expirationdemandereservation24h',
                                                                'data'=>$datamustache
                                                                ]);
                        $this->eventManager()->dispatch($event);
                        // #####################################################
                        Log::write('info', 'Send sms expirationdemandereservation24h to '.$proprietaire->email);
                    }
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
                    ->send('Bonjour, <br><br> Erreur Function expirationdemandereservation24h : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute expirationdemandereservation24h Function');
    }
    /**
     * 
     */
    public function expirationdemandereservation4h()
    {
        Log::write('info', 'Start Execute expirationdemandereservation4h Function'); 
        $now = Time::now();
        $now->subDays(2);
        $now->modify('-4 hours');
        $hours = $now->format('Y-m-d H');
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d %H') = '".$hours."'", "Reservations.statut = 50"]);
        foreach ($listeReservations as $reservation) {
            try{
                // if(PROD_ON == 1){
                    $datamustache = array('prenom' => $reservation['utilisateur']->prenom, 'nom' => $reservation['utilisateur']->nom_famille, 'reservation' => $reservation->id);
                    // print_r($reservation['annonce']->proprietaire_id);
                    $proprietaire = $this->Utilisateurs->find("all")->where(['id' => $reservation['annonce']->proprietaire_id]);
                    if($proprietaire = $proprietaire->first()){
                        $sendTo = $proprietaire->portable;
                        // #####################################################
                        $event = new Event('Email.sendSms', $this, ['from'=>"alpissime",'to' => $sendTo,'textSms'=>'expirationdemandereservation4h',
                                                                'data'=>$datamustache
                                                                ]);
                        $this->eventManager()->dispatch($event);
                        // #####################################################
                        Log::write('info', 'Send sms expirationdemandereservation4h to '.$proprietaire->email);
                    }
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
                    ->send('Bonjour, <br><br> Erreur Function expirationdemandereservation4h : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute expirationdemandereservation4h Function');
    }
    /**
     *
     */
    public function completerInventaireLoc()
    {
        Log::write('info', 'Start Execute completerInventaireLoc Function');
        $now = Time::now();
        $hours = $now->format('Y-m-d 18:00');
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["DATE_FORMAT(Reservations.dbt_at, '%Y-%m-%d %H') = '".$hours."'", "Reservations.statut = 90"]);

        foreach ($listeReservations as $reservation) {
            try{
                // if(PROD_ON == 1){
                if ($reservation['annonce']->inventaire != "") {
                    // #####################################################
                    $event = new Event('Email.sendSms', $this,
                        [
                            'from'=>"alpissime",
                            'to' => $reservation['utilisateur']->portable,
                            'textSms'=>'completerInventaireLoc',
                            'data'=>['lien' => Configure::read('site_url', 'https://www.alpissime.com/') . "annonces/uploadinventairelocataire/" . $reservation->id . "?token=".md5($reservation['utilisateur']->id)]
                        ]
                    );
                    $this->eventManager()->dispatch($event);
                    // #####################################################
                    Log::write('info', 'Send sms completerInventaireLoc to '.$reservation['utilisateur']->email);
                }
                // }
            } catch (\Throwable $th) {
                // throw $th;
                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail=$mails->first();
                // #####################################################
                $email = new Email('production');
                $email->to('maroua.c@ite.digital')
                    // ->addTo('hello@alpissime.com')
                    ->from([$mail->val=>FROM_MAIL])
                    ->subject('Erreur dans fichier CRON')
                    ->emailFormat('html')
                    ->send('Bonjour, <br><br> Erreur Function expirationdemandereservation4h : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute expirationdemandereservation4h Function');
    }
    /**
     * inscriptionPropSansAnnonce4h() method
     */
    public function inscriptionPropSansAnnonce4h()
    {
        Log::write('info', 'Start Execute inscriptionPropSansAnnonce4h Function'); 
        $now = Time::now();
        $now->modify('-4 hours');
        $hours = $now->format('Y-m-d H');
        $listeUtilisateurs = $this->Utilisateurs->find("all")->where(["DATE_FORMAT(Utilisateurs.date_insert, '%Y-%m-%d %H') = '".$hours."'", "Utilisateurs.nature <> 'CLT'"]);
        
        foreach ($listeUtilisateurs as $utilisateur) {
            try {
                $annonces = $this->Annonces->find("all")->where(['Annonces.proprietaire_id' => $utilisateur->id])->count();
                if($annonces == 0){
                    /**** Send Mail ****/
                    $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                    $mail=$mails->first();
                    $messagemail = "Le propriétaire ".$utilisateur->prenom." ".$utilisateur->nom_famille." s'est inscrit sur Alpissime sans déposer d'annonce.<br>".$utilisateur->portable." ".$utilisateur->email;
                    // #####################################################
                    $email = new Email('production');
                        $email->to('hello@alpissime.com')
                            ->from([$mail->val=>FROM_MAIL])
                            ->subject('Nouveau propriétaire inscrit sans annonce')
                            ->emailFormat('html')
                            ->send($messagemail);
                    // #####################################################

                    Log::write('info', 'Send mail inscriptionPropSansAnnonce4h Prop : '.$utilisateur->email);
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
                    ->send('Bonjour, <br><br> Erreur Function inscriptionPropSansAnnonce4h : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute inscriptionPropSansAnnonce4h Function'); 
    }
    /**
     * updateCalendarSynchro () method
     */
    public function updateCalendarSynchro()
    {
        Log::write('info', 'Start Execute updateCalendarSynchroHoures Function'); 
        $listeCalendar = $this->Calendarsynchro->find("all")->where(['actif'=>1]);
        foreach ($listeCalendar as $value) {
            try {
                (new DisposController())->updateCalendarSynchro($value->url, $value->annonce_id, $value->id, "houres");
                Log::write('info', 'Update updateCalendarSynchroHoures id : '.$value->id);
            } catch (\Throwable $th) {
                // throw $th;
                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail=$mails->first();
                // #####################################################
                $email = new Email('production');
                $email->to('maroua.c@ite.digital')
                    ->from([$mail->val=>FROM_MAIL])
                    ->subject('Erreur dans fichier CRON')
                    ->emailFormat('html')
                    ->send('Bonjour, <br><br> Erreur Function updateCalendarSynchroHoures : <br><br> '.$th);
            }
        }
        
        try {
            (new DisposController())->verifyAllSynchroDispo();
            Log::write('info', 'Update verifyAllSynchroDispo');
        } catch (\Throwable $th) {
            // throw $th;
            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();
            // #####################################################
            $email = new Email('production');
            $email->to('maroua.c@ite.digital')
                ->from([$mail->val=>FROM_MAIL])
                ->subject('Erreur dans fichier CRON')
                ->emailFormat('html')
                ->send('Bonjour, <br><br> Erreur Function verifyAllSynchroDispo : <br><br> '.$th);
        }
        Log::write('info', 'End Execute updateCalendarSynchroHoures Function'); 
    }
    /**
     * 
     */
    public function findReservationOption2hoursOLD()
    {
        Log::write('info', 'Start Execute findReservationOption2hours Function'); 
        $now = new Time('-2 hours');
        $hours = $now->format('Y-m-d H');
        // $this->out();
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d %H') = '".$hours."'", "Reservations.statut = 0", 'Reservations.quote_id <> 0', 'Reservations.increment_id = 0']);
        // $this->out($listeReservations);
        foreach ($listeReservations as $reservation) {
            try {
            $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
            $lieugeo=$this->Lieugeos->get($reservation['annonce']->lieugeo_id);
            /**** Send Mail ****/
            $path = "https://www.alpissime.com";

            $this->loadModel("Photos");
            $photo = $this->Photos->find()->where(['annonce_id' => $reservation['annonce']->id])->order(['numero ASC'])->first();
            // $nomImg = "vignette-".$photo->annonce_id."-".$photo->numero;

            $annonce=$this->Annonces->get($photo->annonce_id, ['contain' => ['Lieugeos','Villages']]);
            $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
            $village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
            $village_nom = str_replace(" – ", "-", $village_nom);
            $village_nom = str_replace(" ", "-", $village_nom);
            $nomImgG = $photo->titre;

            $urlimage1 = 'https://www.alpissime.com/images_ann/'.$reservation['annonce']->id.'/'.$nomImgG;

            $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
            $lannonce = $this->string2url($annonce["titre"]);
            $hrefDetailAnn = 'station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;
            
            $datamustache = array('titre_annonce' => $reservation['annonce']->titre,'description' => $reservation['annonce']->description,'imageannonce' => $urlimage1,'lien_boutique' => 'https://www.boutique.alpissime.com/'.$lieugeo->input_boutique.'/checkout/cart/','lien_annonce' => $path."/".$hrefDetailAnn,'date_debut' => $reservation->dbt_at,'date_fin' => $reservation->fin_at,'nb_adulte' => $reservation->nb_adultes,'nb_enfant' => $reservation->nb_enfants);

            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();

            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur']->email,'textEmail'=>'findReservationOption2hours',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################

            Log::write('info', 'Send mail findReservationOption2hours to '.$reservation['utilisateur']->email);
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
                    ->send('Bonjour, <br><br> Erreur Function findReservationOption2hours : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute findReservationOption2hours Function'); 
    }
    /**
	 * 
	 */
	function string2url($chaine) 
	{ 
		$chaine = trim($chaine); 
		$chaine = strtr($chaine, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"); 
		$chaine = strtr($chaine,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz"); 
		$chaine = preg_replace('#([^.a-z0-9]+)#i', '-', $chaine); 
		$chaine = preg_replace('#-{2,}#','-',$chaine); 
		$chaine = preg_replace('#-$#','',$chaine); 
		$chaine = preg_replace('#^-#','',$chaine); 
		return $chaine; 
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
