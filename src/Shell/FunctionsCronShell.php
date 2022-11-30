<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Mustache_Engine;
use Cake\Mailer\Email;
use Cake\Log\Log;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Utility\Xml;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
// App::import('Controller', 'Dispos');
// use App\Controller\AppController;

/**
 * FunctionsCron shell command.
 */
class FunctionsCronShell extends Shell
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
        $this->loadModel("Frvilles");   
        $this->loadModel("Pays");   
        $this->loadModel("Pvilles");   
        $this->loadModel("Photos");   
        $this->loadModel("Residences");   
        $this->loadModel("Penalites");   
        $this->loadModel("Penalitepropannulation");   
        
        $this->eventManager = new EventManager();
    }
    
    private function eventManager(){
        return $this->eventManager;
    }

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main()
    {
        Log::write('info', 'START ALL FUNCTIONS');
        $today = Time::now();
        // Si on est le 15 Septembre  
        $dateseptembre = "15-09-".$today->year; 
        if($today->i18nFormat('dd-MM-yyyy') == $dateseptembre){
            $mailaenvoyer = "premiermailrappelannonceperiode";
            $this->rappelAnnonceSansPeriode($mailaenvoyer);
        }        
        // Si on est le 15 Octobre
        $dateoctobre = "15-10-".$today->year;
        if($today->i18nFormat('dd-MM-yyyy') == $dateoctobre){
            $mailaenvoyer = "deuxiememailrappelannonceperiode";
            $this->rappelAnnonceSansPeriode($mailaenvoyer);
        }
        // Si on est le 15 Novembre
        $datenovembre = "15-11-".$today->year;
        if($today->i18nFormat('dd-MM-yyyy') == $datenovembre){
            $mailaenvoyer = "troisiememailrappelannonceperiode";
            $this->rappelAnnonceSansPeriode($mailaenvoyer);
        }
        $this->arriveeDemain();
        $this->infoDepart();
        $this->infoCleLocataireDeuxJours();
        $this->demandeNoteAppartement();
        $this->infoCleLocataireSemaine();
        $this->demandeMenageDepart();
        // $this->telechargerApplication();
        $this->expirationContrat();
        $this->anniversaireLocation();
        $this->paiementTaxeDeSejour();
        $this->paiementTaxeDeSejourGestionnaire();
        $this->creationReservationRappel3j();
        // $this->infoInventaireLocataireUnJour(); // Remplacer par une autre dans FunctionCronHoures
        $this->generateXML();
        $this->generateXMLpropRes();
        $this->rappelRIB();
        $this->arc1800RappelLingeMenage1mois();
        $this->generatePDFcommission();
        $this->statistiquetauxremplissage();
        $this->updateCalendarSynchro();
        // $this->compressImage();
        Log::write('info', 'END ALL FUNCTIONS');
        //$this->out('Main of FunctionsCron');
    }

    /**
     * arriveeDemain() method.
     */
    public function arriveeDemain()
    {
        Log::write('info', 'Start Execute arriveeDemain Function');
        $now = Time::now();
        $now->addDays(1);
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90"]);
//        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.dbt_at = CURDATE()"]);
        foreach ($listeReservations as $reservation) {
            try {            
            $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
            // $gestionnaire = $this->Gestionnaires->get($reservation['annonce']->id_gestionnaires);
            /* Variable pour mail : prenomprop, nomprop, prenom, nom, date, annonce, gestionnaire */
            /**** Send Mail ****/

            $this->loadModel('BlocMailGestionnaires');
            if($reservation['annonce']->id_gestionnaires != 0) $blocsinfos = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => $reservation['annonce']->id_gestionnaires])->first();
            else $blocsinfos = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => 6])->first();
            
            $redisence = $this->Residences->find()->where(['id' => $reservation['annonce']->batiment])->first();
            $station = $this->Lieugeos->get($reservation['annonce']->lieugeo_id);
            $ville = $this->Frvilles->find()->where(['id' => $reservation['annonce']->ville])->first();
            // 'num_appt' => ,

            if($reservation['annonce']->contrat == 1){
                $bloc_info_arrivee = $blocsinfos->bloc_info_arrivee;
                $bloc_info_arrivee_en = $blocsinfos->bloc_info_arrivee_en;
                $bloc_info_depart = $blocsinfos->bloc_info_depart;
                $bloc_info_depart_en = $blocsinfos->bloc_info_depart_en;

                $arriveeDemainProp = "arriveeDemainProp";
            }else{
                $bloc_info_arrivee = $reservation['annonce']->bloc_info_arrivee;
                $bloc_info_arrivee_en = "";
                $bloc_info_depart = $reservation['annonce']->bloc_info_depart;
                $bloc_info_depart_en = "";

                $arriveeDemainProp = "arriveeDemainPropSansContart";
            }

            $this->loadModel('Gestionnaires');
            $gestionnaire = $this->Gestionnaires->find()->where(['id' => $reservation['annonce']->id_gestionnaires]);
            if($gestionnaire = $gestionnaire->first()){
                $adresse_gestionnaire = $gestionnaire->adresse;
                $ville_gest = $this->Frvilles->find()->where(['id' => $gestionnaire->ville])->first();
                $ville_gestionnaire = $ville_gest->name;
                $code_postal_gestionnaire = $gestionnaire->code_postal;
            }             
             
            $datamustache = [
                'adresse_gestionnaire'     => $adresse_gestionnaire,
                'ville_gestionnaire'       => $ville_gestionnaire,
                'code_postal_gestionnaire' => $code_postal_gestionnaire,
                'residence'                => $redisence->name,
                'station'                  => $station->name,
                'code_postal'              => $reservation['annonce']->code_postal,
                'ville'                    => $ville->name,
                'bloc_info_arrivee'        => $bloc_info_arrivee,
                'bloc_info_arrivee_en'     => $bloc_info_arrivee_en,
                'bloc_info_depart'         => $bloc_info_depart,
                'bloc_info_depart_en'      => $bloc_info_depart_en,
                'bloc_info_horaires'       => $blocsinfos->bloc_info_horaires,
                'bloc_info_horaires_en'    => $blocsinfos->bloc_info_horaires_en,
                'nomprop'                  => $proprietaire->nom_famille,
                'prenomprop'               => $proprietaire->prenom,
                'nom'                      => $reservation['utilisateur']->nom_famille,
                'prenom'                   => $reservation['utilisateur']->prenom,
                'date'                     => $now->i18nFormat('dd-MM-yyyy'),
                'annonce'                  => $reservation['annonce']->num_app,
                'gestionnaire'             => $gestionnaire->name,
                'adresseGest'              => $gestionnaire->adresse,
                'reservationURL'           =>  Configure::read('site_url', 'https://www.alpissime.com/') . "reservations/view_reservation/" . $reservation['id']
            ];

            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();
            // #####################################################
            $event = new Event('Email.send', $this,
                [
                    'from'=>[$mail->val=>FROM_MAIL],
                    'to' => $proprietaire,
                    'textEmail'=>$arriveeDemainProp,
                    'data'=>$datamustache,
                    'template'=>'creationAnnonce',
                    'viewVars'=>'creationAnnonce',
                    'noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################
            
            Log::write('info', 'Send mail "arriveeDemainProp" to '.$proprietaire->email.' for NumApp : '.$reservation['annonce']->num_app);

            // #####################################################
            $contrat = $this->Contrats->find("all")->where(['annonce_id' => $reservation['annonce']->id]);
            if ($proprietaire->nature == "PRES") {
                $textemail = "arriveeDemainLocResidence";
            } else if($reservation['annonce']->contrat == 1 && $contrat->first()) {
                $textemail = "arriveeDemainLoc";
            } else {
                $textemail = "arriveeDemainLocSansContrat";
            }

            $event = new Event('Email.send', $this,
                [
                    'from'      => [$mail->val=>FROM_MAIL],
                    'to'        => $reservation['utilisateur'],
                    'textEmail' => $textemail,
                    'data'      => $datamustache,
                    'template'  => 'creationAnnonce',
                    'viewVars'  => 'creationAnnonce',
                    'noReply'   => false
                ]
            );
            $this->eventManager()->dispatch($event);
            // #####################################################
            Log::write('info', 'Send mail '.$textemail.' to '.$reservation['utilisateur']->email);
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
                    ->send('Bonjour, <br><br> Erreur Function arriveeDemain : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute arriveeDemain Function');
    }
    
    /**
     * infoDepart() method
     */
    public function infoDepart()
    {
        Log::write('info', 'Start Execute infoDepart Function');
        $now = Time::now();
        $now->addDays(1); 
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.fin_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90"]);
        foreach ($listeReservations as $reservation) {
            try {   
            /* Variable pour mail : prenom, nom, annonceURL */
            /**** Send Mail ****/
            //$path = Router::url('/', true);
            $path = "https://www.alpissime.com";
            $this->loadModel('BlocMailGestionnaires');
            $this->loadModel('Annoncegestionnaires');
            $blocsinfos = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => $reservation['annonce']->id_gestionnaires])->first();

            $annonce=$this->Annonces->get($reservation['annonce']->id, ['contain' => ['Lieugeos']]);
            $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
            $lannonce = $this->string2url($annonce["titre"]);
            $hrefDetailAnn = 'station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;
      
            $datamustache = array('bloc_info_depart' => $blocsinfos->bloc_info_depart, 'bloc_info_depart_en' => $blocsinfos->bloc_info_depart_en, 'nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom, 'annonceURL' => $path."/".$hrefDetailAnn."?token=".$reservation['utilisateur']->id);
            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();
            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur'],'textEmail'=>'infoDepart',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################
            Log::write('info', 'Send mail "infoDepart" to '.$reservation['utilisateur']->email.' for NumApp : '.$reservation['annonce']->num_app);
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
                    ->send('Bonjour, <br><br> Erreur function infoDepart : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute infoDepart Function'); 
    }
    
    /**
     * demandeNoteAppartement() mehod
     */
    public function demandeNoteAppartement() {
        Log::write('info', 'Start Execute demandeNoteAppartement Function');
        $now = Time::now();
        $now->subDays(2);        
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.fin_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90"]);
        foreach ($listeReservations as $reservation) {
            try {   
            /* Variable pour mail : prenom, nom, annonceURL */
            /**** Send Mail ****/
            //$path = Router::url('/', true);
            $path = "https://www.alpissime.com";

            $annonce=$this->Annonces->get($reservation['annonce']->id, ['contain' => ['Lieugeos']]);
            $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
            $lannonce = $this->string2url($annonce["titre"]);
            $hrefDetailAnn = 'station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;

            $datamustache = array('nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom, 'annonceURL' => $path."/".$hrefDetailAnn."?token=".$reservation['utilisateur']->id);
            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();
            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur'],'textEmail'=>'demandeNoteAppartement',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################
            Log::write('info', 'Send mail "demandeNoteAppartement" to '.$reservation['utilisateur']->email.' for NumApp : '.$reservation['annonce']->num_app);
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
                    ->send('Bonjour, <br><br> Erreur function demandeNoteAppartement : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute demandeNoteAppartement Function');  
    }
    
    /**
     * demandeMenagedepart() method
     */
    // public function demandeMenageDepart() {
    //     Log::write('info', 'Start Execute demandeMenageDepart Function');
    //     $now = Time::now();
    //     $now->addDays(3);  
    //     $specialDates = array("2019-02-09", "2019-02-16", "2019-02-23", "2019-03-02", "2019-03-09");
    //     if(!in_array($now->i18nFormat('yyyy-MM-dd'), $specialDates)){
    //         $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.fin_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90"]);
    //     foreach ($listeReservations as $reservation) {
    //         /* Pas d'envoie si vacance de février */
    //         $moisFin = new Time($reservation->fin_at);
    //         if($moisFin->month != 2){
    //             /* Variable pour mail : prenom, nom */
    //             /**** Send Mail ****/
    //             $this->loadModel('BlocMailGestionnaires');
    //             $this->loadModel('Annoncegestionnaires');
    //             $anngest = $this->Annoncegestionnaires->find()->where(['id_annonces' =>$reservation['annonce']['id'] ])->first();
    //             $blocsinfos = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => $anngest->id_gestionnaires])->first();
    //             $datamustache = array('bloc_menage_depart' => $blocsinfos->bloc_menage_depart, 'bloc_menage_depart_en' => $blocsinfos->bloc_menage_depart_en, 'nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom);
    //             $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
    //             $mail=$mails->first();
    //             // #####################################################
    //             $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur'],'textEmail'=>'demandeMenageDepart',
    //                                                      'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
    //                                                     ]);
    //             $this->eventManager()->dispatch($event);
    //             // #####################################################
    //             Log::write('info', 'Send mail "demandeMenageDepart" to '.$reservation['utilisateur']->email.' for NumApp : '.$reservation['annonce']->num_app);
            
    //         }            
    //     }
    //     }        
    //     Log::write('info', 'End Execute demandeMenageDepart Function');  
    // }
    
    /**
     * telechargerApplication() mathod
     */
    public function telechargerApplication() {
        Log::write('info', 'Start Execute telechargerApplication Function');
        $now = Time::now();
        $now->addDays(7);  
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90"]);
        foreach ($listeReservations as $reservation) {
            try {   
            /* Variable pour mail : prenom, nom */
            /**** Send Mail ****/
            $datamustache = array('nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom);
            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();
            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur'],'textEmail'=>'telechargerApplication',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################
            Log::write('info', 'Send mail "telechargerApplication" to '.$reservation['utilisateur']->email.' for NumApp : '.$reservation['annonce']->num_app);
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
                    ->send('Bonjour, <br><br> Erreur function telechargerApplication : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute telechargerApplication Function'); 
    }
    
    /**
     * expirationContrat() method
     */
    public function expirationContrat() {
        Log::write('info', 'Start Execute expirationContrat Function');
        $now = Time::now();
        $now->addDays(14);
        $annee = $now->year;
        $mois = $now->month;
        $jour = $now->day;
         //
        /** Seulement pour contrat de séjour/clé **/
        $listeContrats = $this->Contrats->find()
                ->join([
                    'A' => [
                        'table' => 'annonces',
                        'type' => 'inner',
                        'conditions' => ['A.id = Contrats.annonce_id'],
                      ],
                    'U' => [
                        'table' => 'utilisateurs',
                        'type' => 'inner',
                        'conditions' => ['U.id = A.proprietaire_id'],
                      ]
                  ])               
                ->where(["Contrats.date_create < '".$annee."-01-15'", "DAY(Contrats.date_create) = ".$jour, "MONTH(Contrats.date_create) = ".$mois, "Contrats.type = 2", "Contrats.visible = 1", "A.statut != 10", "A.statut != 19", "A.contrat = 1"])   
                ->select(["A.proprietaire_id", "Contrats.annonce_id"]);
        foreach ($listeContrats as $contrat) {
            try {   
            $proprietaire = $this->Utilisateurs->get($contrat['A']["proprietaire_id"]);
            /* Variable pour mail : prenomprop, nomprop, annonce */
            /**** Send Mail ****/
            $datamustache = array('nomprop' => $proprietaire->nom_famille, 'prenomprop' => $proprietaire->prenom, 'annonce' => $contrat->annonce_id);
            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();
            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire,'textEmail'=>'expirationContrat',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################
            Log::write('info', 'Send mail "expirationContrat" to '.$proprietaire->email.' for Annonce ID : '.$contrat->annonce_id);
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
                    ->send('Bonjour, <br><br> Erreur function expirationContrat : <br><br> '.$th);
            }
        }        
        Log::write('info', 'End Execute expirationContrat Function'); 
    }
    
    /**
     * anniversaireLocation() method
     */
    public function anniversaireLocation() {
        Log::write('info', 'Start Execute anniversaireLocation Function');
        $now = Time::now();
        $now->addMonths(1);
        $now->subYears(1); 
        //$this->out(print_r($now->i18nFormat('yyyy-MM-dd'), true));
        $path = "https://www.alpissime.com";
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90"]);
        foreach ($listeReservations as $reservation) {
            try {   
            /* Variable pour mail : prenom, nom, prenomprop, nomprop, annonce, annonceURL */
            $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
            /**** Send Mail ****/
            $this->loadModel("Annonces");
            $info_ann = $this->Annonces->get($reservation->annonce_id);
            // Ajout variable {{imageannonce}}
            $this->loadModel("Photos");
            $photo = $this->Photos->find()->where(['annonce_id' => $reservation['annonce']->id])->order(['numero ASC']);
            // $nomImg = "vignette-".$photo->annonce_id."-".$photo->numero;

            $annonce=$this->Annonces->get($reservation->annonce_id, ['contain' => ['Lieugeos','Villages']]);
            $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
            $village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
            $village_nom = str_replace(" – ", "-", $village_nom);
            $village_nom = str_replace(" ", "-", $village_nom);
            if($photo = $photo->first()) $nomImgG = $photo->titre;
            else $nomImgG = "";

            $urlimage1 = 'https://www.alpissime.com/images_ann/'.$reservation['annonce']->id.'/'.$nomImgG;

            //Ajout variable {{description}} (160 premiers caractères de la description de l'annonce et finir par "..." si la description contient plus de 160 caractères)
            $desc160 = substr($info_ann->description, 0, 160);
            if(strlen($info_ann->description) > 160) $desc160 = $desc160." ...";

            $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
            $lannonce = $this->string2url($annonce["titre"]);
            $hrefDetailAnn = 'station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;

            $datamustache = array('nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom, 'prenomprop' => $proprietaire->prenom, 'nomprop' => $proprietaire->nom_famille, 'annonce' => $reservation['annonce']->id, 'annonceURL' => $path."/".$hrefDetailAnn, 'imageannonce' => $urlimage1, 'description' => $desc160);
            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();
            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur'],'textEmail'=>'anniversaireLocation',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################
            Log::write('info', 'Send mail "anniversaireLocation" to '.$reservation['utilisateur']->email);
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
                    ->send('Bonjour, <br><br> Erreur function anniversaireLocation : <br><br> '.$th);
            }
        }        
        Log::write('info', 'End Execute anniversaireLocation Function');
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
     * paiementTaxeDeSejour() method
     */
    public function paiementTaxeDeSejour(){
        Log::write('info', 'Start Execute paiementTaxeDeSejour Function');
        $now = Time::now();
        $now->subDays(2);        
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90", "Reservations.taxe = 1", "Reservations.taxe_paye = 0"])
        ->join([            
            'dispo' => [
                'table' => 'dispos',
                'type' => 'inner',
                'conditions' => 'dispo.reservation_id=Reservations.id',
            ]
        ])->group('Reservations.id');
        foreach ($listeReservations as $reservation){
            try {   
            /**** Send Mail ****/
            // Calcul valeur taxe 
            $dispocontroller = new \App\Controller\DisposController();
            // dd-MM-yyyy/dd-MM-yyyy
            $dates = $reservation->dbt_at->i18nFormat('dd-MM-yyyy')."/".$reservation->fin_at->i18nFormat('dd-MM-yyyy');
		    $resultatDetail = $dispocontroller->calcultaxedesejour($reservation->annonce_id, $dates, $reservation->nb_adultes, $reservation->nb_enfants);
            $montant_taxe=number_format($resultatDetail['prixtaxeapayer'], 2, ',', '');           
            // FIN Calcul valeur taxe            
            $datamustache = array('montant_taxe' => $montant_taxe);
            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();
            
            $email = new Email('production');
            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur']->email,'textEmail'=>'paiementTaxeDeSejour',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################
            Log::write('info', 'Send mail "paiementTaxeDeSejour" to '.$reservation['utilisateur']->email.' for ReservationID : '.$reservation->id);
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
                    ->send('Bonjour, <br><br> Erreur function paiementTaxeDeSejour : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute paiementTaxeDeSejour Function');
    }
    /**
     * paiementTaxeDeSejourGestionnaire() method
     */
    public function paiementTaxeDeSejourGestionnaire(){
        Log::write('info', 'Start Execute paiementTaxeDeSejourGestionnaire Function');
        $now = Time::now();
        $now->subDays(2);        
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90", "Reservations.taxe = 1", "Reservations.taxe_paye = 0"])
        ->join([            
            'dispo' => [
                'table' => 'dispos',
                'type' => 'inner',
                'conditions' => 'dispo.reservation_id=Reservations.id',
            ]
        ])->group('Reservations.id');
        foreach ($listeReservations as $reservation){
            try {   
            /**** Send Mail ****/
            // Calcul valeur taxe 
            $dispocontroller = new \App\Controller\DisposController();
            // dd-MM-yyyy/dd-MM-yyyy
            $dates = $reservation->dbt_at->i18nFormat('dd-MM-yyyy')."/".$reservation->fin_at->i18nFormat('dd-MM-yyyy');
		    $resultatDetail = $dispocontroller->calcultaxedesejour($reservation->annonce_id, $dates, $reservation->nb_adultes, $reservation->nb_enfants);
            $v_taxe=number_format($resultatDetail['prixtaxeapayer'], 2, ',', ''); 
           
            // FIN Calcul valeur taxe
            $datamustache = array('nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom, 'datearrivee' => $reservation->dbt_at, 'taxe' => $v_taxe);
            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();
            // copie gestionnaire / admin            
            if($reservation['annonce']->id_gestionnaires != 0){
                $gestio = $this->Gestionnaires->get($reservation['annonce']->id_gestionnaires);
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>$reservation['utilisateur']->email,'to' => $gestio->email,'textEmail'=>'paiementTaxeDeSejourGestionnaire',
                                    'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                    ]);
                $this->eventManager()->dispatch($event);
            }else{
                $event = new Event('Email.send', $this, ['from'=>$reservation['utilisateur']->email,'to' => $mail->val,'textEmail'=>'paiementTaxeDeSejourGestionnaire',
                                    'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                    ]);
                $this->eventManager()->dispatch($event);
            }
            Log::write('info', 'Send mail "paiementTaxeDeSejourGestionnaire" to '.$reservation['utilisateur']->email.' for ReservationID : '.$reservation->id);
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
                    ->send('Bonjour, <br><br> Erreur function paiementTaxeDeSejourGestionnaire : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute paiementTaxeDeSejourGestionnaire Function');
    }
    /**
     * rappelAnnonceSansPeriode() method
     */
    public function rappelAnnonceSansPeriode($txtmail)
    {
        Log::write('info', 'Start Execute rappelAnnonceSansPeriode Function');
        // Condition d'envoi : si nombre de jours des période (n'importe quel statut) < 28j entre Décembre et avril
        $now = Time::now()->year;
        //Parcourir les annonces
        $listeannonces = $this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50"]]);
        foreach ($listeannonces as $annonce) {     
            try {   
            $listeperiode = $this->Dispos->find()->where(['Dispos.annonce_id = '.$annonce->id,'Dispos.dbt_at >= "'.$now.'-12-01"', 'Dispos.dbt_at <= "'.($now+1).'-04-30"']);
            $nbrjours = 0;
            foreach ($listeperiode as $value) {
                if(new Date($value->fin_at) > new Date(($now+1)."-04-30")){                    
                    $datefin = new Date(($now+1)."-04-30");                    
                }else{
                    $datefin = new Date($value->fin_at);
                }  
                $datedebut = new Date($value->dbt_at);  
                $interval = $datedebut->diff($datefin);
                $nbrjours = $nbrjours + (int)$interval->days;            
            }
            if($nbrjours < 28){
                /**** Send Mail ****/
                $prop = $this->Utilisateurs->get($annonce->proprietaire_id);
                $datamustache = array('nom' => $prop->nom_famille, 'prenom' => $prop->prenom);
                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail=$mails->first();
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $prop,'textEmail'=>$txtmail,
                                                        'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################
                Log::write('info', 'Send mail '.$txtmail.' to '.$prop->email);
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
                    ->send('Bonjour, <br><br> Erreur Function rappelAnnonceSansPeriode : <br><br> '.$th);
            }           
        }        
        
        Log::write('info', 'End Execute rappelAnnonceSansPeriode Function');
    }
    /**
     * infoCleLocataireSemaine() method
     */
    public function infoCleLocataireSemaine()
    {
        Log::write('info', 'Start Execute infoCleLocataireSemaine Function'); 
        $now = Time::now();
        $now->addDays(7); 
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90"])
        ->andWhere(function ($exp, $q) {
            return $exp->in('lieugeo_id', [15, 16, 17]);
        });
        foreach ($listeReservations as $reservation) {
            try {   
            /* Variable pour mail : prenom, nom*/
            /**** Send Mail ****/
            $datamustache = array('nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom);
            
            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();

            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur'],'textEmail'=>'infoCleLocataire',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################

            Log::write('info', 'Send mail infoCleLocataireSemaine to '.$reservation['utilisateur']->email);
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
                    ->send('Bonjour, <br><br> Erreur Function infoCleLocataireSemaine : <br><br> '.$th);
            }  
        }
        Log::write('info', 'End Execute infoCleLocataireSemaine Function'); 
    }
    /**
     * infoCleLocataireDeuxJours() method
     */
    public function infoCleLocataireDeuxJours()
    {
        Log::write('info', 'Start Execute infoCleLocataireDeuxJours Function'); 
        $now = Time::now();
        $now->addDays(2); 
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90"])
        ->andWhere(function ($exp, $q) {
            return $exp->in('lieugeo_id', [15, 16, 17]);
        });
        foreach ($listeReservations as $reservation) {
            try {   
            /* Variable pour mail : prenom, nom*/
            /**** Send Mail ****/
            $datamustache = array('nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom);

            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();

            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur'],'textEmail'=>'infoCleLocataire',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################

            Log::write('info', 'Send mail infoCleLocataireDeuxJours to '.$reservation['utilisateur']->email);
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
                    ->send('Bonjour, <br><br> Erreur Function infoCleLocataireDeuxJours : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute infoCleLocataireDeuxJours Function'); 
    }
    /**
     * icreationReservationRappel3j() method
     */
    public function creationReservationRappel3j()
    {
        Log::write('info', 'Start Execute creationReservationRappel3j Function'); 
        $now = Time::now();
        $now->subDays(3); 
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d') = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 50"]);
        
        foreach ($listeReservations as $reservation) {
            try {   
            $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
            $lieugeo=$this->Lieugeos->get($reservation['annonce']->lieugeo_id);
            /**** Send Mail ****/
            $datamustache = array('prenomprop' => $proprietaire->prenom,'nomprop' => $proprietaire->nom_famille,'annonce' => $reservation['annonce']->id, 'station' => $lieugeo->name, 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'nbrEnfant' => $reservation->nb_enfants, 'nbrAdulte' => $reservation->nb_adultes, 'nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom, 'tel' => $reservation['utilisateur']->portable, 'email' => $reservation['utilisateur']->email);

            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();

            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire->email,'textEmail'=>'creationReservationRappel3j',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################

            Log::write('info', 'Send mail creationReservationRappel3j to '.$proprietaire->email);
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
                    ->send('Bonjour, <br><br> Erreur Function creationReservationRappel3j : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute creationReservationRappel3j Function'); 
    }
    /**
     * passerellesNouvellesPeriodes () method
     */
    // public function passerellesNouvellesPeriodes()
    // {
    //     Log::write('info', 'Start Execute passerellesNouvellesPeriodes Function'); 
    //     $now = Time::now();
    //     $now->subDays(1); 
    //     $listeReservations = $this->Reservations->find()->contain(['Annonces'])
    //     ->join([
    //         'Dispos' => [
    //             'table' => 'dispos',
    //             'type' => 'inner',
    //             'conditions' => ['Dispos.annonce_id=Reservations.annonce_id', 'Dispos.calendarsynchro_id <> 0'],
    //         ]
    //     ])
    //     ->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d') = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.utilisateur_id = 0"]);
    //     foreach ($listeReservations as $reservation) {
    //         try {   
    //         $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
    //         /**** Send Mail ****/
    //         $datamustache = array('prenomprop' => $proprietaire->prenom,'nomprop' => $proprietaire->nom_famille);

    //         $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
    //         $mail=$mails->first();

    //         // #####################################################
    //         $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire->email,'textEmail'=>'passerellesNouvellesPeriodes',
    //                                                  'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
    //                                                 ]);
    //         $this->eventManager()->dispatch($event);
    //         // #####################################################

    //         Log::write('info', 'Send mail passerellesNouvellesPeriodes to '.$proprietaire->email);
    //         } catch (\Throwable $th) {
    //             // throw $th;
    //             $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
    //             $mail=$mails->first();
    //             // #####################################################
    //             $email = new Email('production');
    //             $email->to('maroua.c@ite.digital')
    //                 ->addTo('hello@alpissime.com')
    //                 ->from([$mail->val=>FROM_MAIL])
    //                 ->subject('Erreur dans fichier CRON')
    //                 ->emailFormat('html')
    //                 ->send('Bonjour, <br><br> Erreur Function passerellesNouvellesPeriodes : <br><br> '.$th);
    //         }
    //     }
    //     Log::write('info', 'End Execute passerellesNouvellesPeriodes Function'); 
    // }     
    /**
     * infoInventaireLocataireUnJour() method
     */
    // public function infoInventaireLocataireUnJour()
    // {
    //     Log::write('info', 'Start Execute infoInventaireLocataireUnJour Function'); 
    //     $now = Time::now();
    //     $now->addDays(1); 
    //     $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90"]);
    //     foreach ($listeReservations as $reservation) {
    //         /**** Send Mail ****/
    //         $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
    //         $path = "https://www.alpissime.com";
    //         $urlInventaire = $path."/inventaires/".$reservation['annonce']['inventaire'];

    //         $this->loadModel('BlocServicesMails');
    //         $stat_annonce = $reservation['annonce']->lieugeo_id;
    //         $bloc_services_mail_first = $this->BlocServicesMails->find()->where(["(liste_id_station LIKE '$stat_annonce;%' OR liste_id_station LIKE '%;$stat_annonce;%')"])->first();

    //         $datamustache = array('bloc_services_mail' => $bloc_services_mail_first->bloc_services_mail, 'bloc_services_mail_en' => $bloc_services_mail_first->bloc_services_mail_en, 'nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom, 'nomprop' => $proprietaire->nom_famille, 'prenomprop' => $proprietaire->prenom, 'url_inventaire' => $urlInventaire);

    //         $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
    //         $mail=$mails->first();

    //         if(isset($reservation['annonce']['inventaire']) && $reservation['annonce']['inventaire'] != '') $textEmail = 'inventairepourloc';
    //         else $textEmail = 'sansinventairepourloc';
    //         // #####################################################
    //         $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur'],'textEmail'=>$textEmail,
    //                                                  'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
    //                                                 ]);
    //         $this->eventManager()->dispatch($event);
    //         // #####################################################

    //         Log::write('info', 'Send mail infoInventaireLocataireUnJour "'.$textEmail.'" to '.$reservation['utilisateur']->email);
    //     }
    //     Log::write('info', 'End Execute infoInventaireLocataireUnJour Function'); 
    // }
    /**
     * 
     */
    public function generateXML()
    {
        Log::write('info', 'Start Execute generateXML Function'); 
        $now = Time::now();
        $now->subDays(1); 

        $today = Time::now();

        $totalreservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'=>'Utilisateurs'])->where(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90", "Reservations.type = 0", "Reservations.commande_id <> 0"])
        ->join([            
            'dispo' => [
                'table' => 'dispos',
                'type' => 'inner',
                'conditions' => ['dispo.reservation_id=Reservations.id', 'dispo.calendarsynchro_id=0'],
            ]
        ])->group('Reservations.id');
        // $totalreservationsCount = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90", "Reservations.type = 0"])
        // ->join([            
        //     'dispo' => [
        //         'table' => 'dispos',
        //         'type' => 'inner',
        //         'conditions' => 'dispo.reservation_id=Reservations.id',
        //     ]
        // ])->group('Reservations.id')->count();
        $totalreservationsSum = $this->Reservations->getSumReservationsXML(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90", "Reservations.type = 0", "Reservations.commande_id <> 0"]);
       
        // A enlever !!!!!!
        // $totalreservations = $this->Reservations->find()->contain(['Utilisateurs', 'Dispos','Annonces'=>'Utilisateurs'])->where(["Reservations.dbt_at = '2021-09-24'", "Reservations.statut = 90", "Reservations.type = 0"])
        // ->join([            
        //     'dispo' => [
        //         'table' => 'dispos',
        //         'type' => 'inner',
        //         'conditions' => 'dispo.reservation_id=Reservations.id',
        //     ]
        // ])->group('Reservations.id');
        // $totalreservationsCount = $this->Reservations->find()->contain(['Utilisateurs', 'Dispos', 'Annonces'])->where(["Reservations.dbt_at = '2021-09-24'", "Reservations.statut = 90", "Reservations.type = 0"])
        // ->join([            
        //     'dispo' => [
        //         'table' => 'dispos',
        //         'type' => 'inner',
        //         'conditions' => 'dispo.reservation_id=Reservations.id',
        //     ]
        // ])->group('Reservations.id')->count();
        // $totalreservationsSum = $this->Reservations->getSumReservationsXML(["Reservations.dbt_at = '2021-09-24'", "Reservations.statut = 90", "Reservations.type = 0"]);
        // Fin A enlever !!!!!!

        // vérifier que les prop ne sont pas de type PRES
        $nbrpropnonres = 0;
        $listeresautorise = [];
        foreach ($totalreservations as $reservationune) {
            if($reservationune['annonce']['utilisateur']->nature != "PRES"){
                $listeresautorise[] = $reservationune->id;
                $nbrpropnonres++;
            }            
        }
        
        $prixTotalRes = 0;
        $prixtab = [];
        foreach ($totalreservationsSum as $reservationSum) {
            if(in_array($reservationSum->id, $listeresautorise)){
                if($reservationSum->prixreservation == 0){
                    if($reservationSum['dispo']['promo_yn'] == 0) $prixtab[$reservationSum->id] += $reservationSum['dispo']['prix'];
                    else $prixtab[$reservationSum->id] += $reservationSum['dispo']['promo_px'];
                }else{
                    $prixtab[$reservationSum->id] = $reservationSum->prixreservation;
                }
            }
        }
        
        foreach ($prixtab as $valuetot => $key) {
            $prixtab[$valuetot] = $key-($key*3/100);
            // Vérifier penalités
            $penalite = $this->Penalites->find("all")->where(['reservation_id' => $valuetot]);
            if($penalite = $penalite->first()) $prixtab[$valuetot] = $prixtab[$valuetot] - (50 * $penalite->nbr_penalite);            
            $reservationprop = $this->Reservations->get($valuetot);
            $annonceprop = $this->Annonces->get($reservationprop->annonce_id);
            $propannulinfo = $this->Utilisateurs->get($annonceprop->proprietaire_id);
            $penaliteannulation = $this->Penalitepropannulation->find("all")->where(['utilisateur_id' => $propannulinfo->id]);
            if($penaliteannulation = $penaliteannulation->first()){
                if($penaliteannulation->nbr_penalite > 0){
                    $prixtab[$valuetot] = $prixtab[$valuetot] - (50 * $penaliteannulation->nbr_penalite);
                    $annulationprop=array('nbr_penalite'=>0);
                    $annulationpropupdate=$this->Penalitepropannulation->patchEntity($penaliteannulation,$annulationprop);
                    $this->Penalitepropannulation->save($annulationpropupdate);
                }
            }
            $prixTotalRes += round($prixtab[$valuetot],2);
        }

        if($nbrpropnonres != 0){
            try {   

            $msgId = "Virement-Location--".$now->i18nFormat('dd/MM/yyyy'); 
            $CreDtTm = $now->i18nFormat("yyyy-MM-dd'T'HH:mm:ss");
            $NbOfTxs = $nbrpropnonres;
            $CtrlSum = $prixTotalRes;
            $PmtInfId = "Virement-Location--".$now->i18nFormat('dd/MM/yyyy');
            $ReqdExctnDt = $today->i18nFormat('yyyy-MM-dd');
    
    
            $xml = new \XMLWriter();
            $xml->openURI("webroot/xml/Virement-Location--".$now->i18nFormat('dd-MM-yyyy').".xml");
            $xml->setIndent(true);
            $xml->setIndentString(''); 
            $xml->startDocument('1.0', 'UTF-8');
                $xml->startElement('Document');            
                    $xml->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
                    $xml->writeAttribute('xmlns', 'urn:iso:std:iso:20022:tech:xsd:pain.001.001.03');
                        $xml->startElement('CstmrCdtTrfInitn');
                            $xml->startElement('GrpHdr');
                                $xml->writeElement('MsgId', $msgId);
                                $xml->writeElement('CreDtTm', $CreDtTm);
                                $xml->writeElement('NbOfTxs', $NbOfTxs);
                                $xml->writeElement('CtrlSum', $CtrlSum);
                                    $xml->startElement('InitgPty');
                                        $xml->writeElement('Nm', 'Alpissime');
                                    $xml->endElement();
                            $xml->endElement();  
                            $xml->startElement('PmtInf'); 
                                $xml->writeElement('PmtInfId', $PmtInfId); 
                                $xml->writeElement('PmtMtd', "TRF"); 
                                $xml->writeElement('BtchBookg', "false"); 
                                $xml->writeElement('NbOfTxs', $NbOfTxs); 
                                $xml->writeElement('CtrlSum', $CtrlSum);
                                $xml->startElement('PmtTpInf');
                                    $xml->startElement('SvcLvl');
                                        $xml->writeElement('Cd', 'SEPA');
                                    $xml->endElement();
                                $xml->endElement();
                                $xml->writeElement('ReqdExctnDt', $ReqdExctnDt);
                                $xml->startElement('Dbtr');
                                    $xml->writeElement('Nm', 'SARL AMSA');
                                    $xml->startElement('PstlAdr');
                                        $xml->writeElement('PstCd', '73700');
                                        $xml->writeElement('TwnNm', 'Bourg Saint-Maurice');
                                        $xml->writeElement('Ctry', 'FR');
                                        $xml->writeElement('AdrLine', 'Galerie Pierra Menta a Arc 1800');
                                    $xml->endElement();
                                $xml->endElement();
                                $xml->startElement('DbtrAcct');
                                    $xml->startElement('Id');
                                        $xml->writeElement('IBAN', "FR7630004017100001013970791");
                                    $xml->endElement();
                                $xml->endElement();
                                $xml->startElement('DbtrAgt');
                                    $xml->startElement('FinInstnId');
                                        $xml->writeElement('BIC', "BNPAFRPP");
                                        // $xml->startElement('Othr');
                                        //     $xml->writeElement('Id', "BNPAFRPP");                                
                                        // $xml->endElement();
                                    $xml->endElement();
                                $xml->endElement();
                                $xml->writeElement('ChrgBr', "SLEV");
                                // Traitement pour chaque transaction
                                foreach ($totalreservations as $reservation) {
                                    if(in_array($reservation->id, $listeresautorise)){
                                        $propinfo = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id, ['contain' => ['Informationbancaires']]);
                                        // On lance la création que pour les proprietaire qui ont saisi leurs info bancaire
                                        // if($propinfo->informationbancaire_id != 0){
                                            $paysprop = $this->Pays->find()->where(['id_pays' => $propinfo->pays])->first();
                                            if($paysprop->id_pays == 67) $villeprop = $this->Frvilles->find()->where(['id' => $propinfo->ville])->first(); 
                                            else $villeprop = $this->Pvilles->find()->where(['id' => $propinfo->ville])->first(); 
                                            /* Liste variables d'une transaction */
                                            $InstrId = $reservation->id."--".$now->i18nFormat('dd/MM/yyyy')."--".$reservation['annonce']['utilisateur']->nom_famille; 
                                            $EndToEndId = $reservation->id."--".$now->i18nFormat('dd/MM/yyyy')."--".$reservation['annonce']['utilisateur']->nom_famille;
                                            // $InstdAmt = $prixtab[$reservation->id]; 
                                            $InstdAmt = round($prixtab[$reservation->id],2);
                                            $BIC = str_replace(' ','',$propinfo['informationbancaire']->BIC);
                                            $Nm = $propinfo['informationbancaire']->titulaire_compte;                        
                                            $PstCd = $propinfo->code_postal;
                                            $TwnNm = $villeprop->name;
                                            $Ctry = $paysprop->code_pays;
                                            if($propinfo['informationbancaire']->adresse != "") $AdrLine = $propinfo['informationbancaire']->adresse;
                                            else $AdrLine = "NOTPROVIDED";
                                            $IBAN = str_replace(' ','',$propinfo['informationbancaire']->IBAN);
                                            $Ustrd = $reservation->id."--".$reservation['utilisateur']->nom_famille."--".$now->i18nFormat('dd-MM-yyyy')."--467102-PROPRIETAIRE"; 
        
                                            $xml->startElement('CdtTrfTxInf');
                                                $xml->startElement('PmtId');
                                                    $xml->writeElement('InstrId', $InstrId);
                                                    $xml->writeElement('EndToEndId', $EndToEndId);
                                                $xml->endElement();
                                                $xml->startElement('Amt');
                                                    $xml->startElement('InstdAmt');
                                                        $xml->writeAttribute('Ccy', 'EUR');
                                                        $xml->text($InstdAmt);
                                                    $xml->endElement();
                                                $xml->endElement();
                                                $xml->startElement('CdtrAgt');
                                                    $xml->startElement('FinInstnId');
                                                        $xml->writeElement('BIC', $BIC);                                
                                                    $xml->endElement();                                
                                                $xml->endElement();
                                                $xml->startElement('Cdtr');
                                                    $xml->writeElement('Nm', $Nm);
                                                    $xml->startElement('PstlAdr');
                                                        $xml->writeElement('PstCd', $PstCd);
                                                        $xml->writeElement('TwnNm', $TwnNm);
                                                        $xml->writeElement('Ctry', $Ctry);
                                                        $xml->writeElement('AdrLine', $AdrLine);
                                                    $xml->endElement();
                                                    $xml->writeElement('CtryOfRes', $Ctry); 
                                                $xml->endElement();
                                                $xml->startElement('CdtrAcct');
                                                    $xml->startElement('Id');
                                                        $xml->writeElement('IBAN', $IBAN);
                                                    $xml->endElement();
                                                $xml->endElement();
                                                $xml->startElement('RmtInf');
                                                    $xml->writeElement('Ustrd', $Ustrd);
                                                $xml->endElement();                            
                                            $xml->endElement();
                                            // END transaction
                                            // Enregistrer date_virement danst reservations
                                            // $data = array('date_virement' => $today);
                                            // $newReservation = $this->Reservations->patchEntity($reservation, $data);
                                            // $this->Reservations->save($newReservation);
                                        // }
                                    }
                                }
                                // END all transaction
                        $xml->endElement();            
                    $xml->endElement();            
                $xml->endElement();
            $xml->endDocument();
            $xml->flush();
            unset($xml);
    
            // Envoie par mail à qui ???
            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();
            // #####################################################
            $email = new Email('production');
            $email->to('paiements@alpissime.com')
                ->from([$mail->val=>FROM_MAIL])
                ->subject('Fichier XML - Virement '.$now->i18nFormat('dd-MM-yyyy'))
                ->emailFormat('html')
                ->attachments(array(
                    "Virement-Location--".$now->i18nFormat('dd-MM-yyyy').".xml" => array(
                        'file' => "webroot/xml/Virement-Location--".$now->i18nFormat('dd-MM-yyyy').".xml",
                        'mimetype' => 'application/xml'
                    ),    
                ))
                ->send('Bonjour, <br><br> Vous trouvez ci-joint le fichier XML pour les réservations du '.$now->i18nFormat('dd-MM-yyyy').'.');
            // #####################################################
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
                    ->send('Bonjour, <br><br> Erreur Function generateXML : <br><br> '.$th);
            }
        }else{
           // Envoie par mail à qui ???
           $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
           $mail=$mails->first();
           // #####################################################
           $email = new Email('production');
           $email->to('paiements@alpissime.com')
               ->from([$mail->val=>FROM_MAIL])
               ->subject('Fichier XML - Pas de Virement ')
               ->emailFormat('html')
               ->send('Bonjour, <br><br> Pas de fichier XML pour Aujourd\'hui');
           // ##################################################### 
        }
 
       
        Log::write('info', 'End Execute generateXML Function');
    }
    /**
     * 
     */
    public function generateXMLpropRes()
    {
        Log::write('info', 'Start Execute generateXMLpropRes Function'); 
         
        $today = Time::now();

        $listepropres = $this->Utilisateurs->find("all")->contain(['Paiements'])->where(['Utilisateurs.nature = "PRES"']);
        $listetotalreservations = [];
        $listetotalreservationsSum = [];
        $listetauxcommission = [];
        foreach ($listepropres as $propres) {
            $now = Time::now();
            if(!empty($propres->paiements)){
                $now->addDays($propres->paiements[0]->nbr_jour);
                $nbr_de_jour = $propres->paiements[0]->nbr_jour;
            }else{
                $now->addDays(0);
                $nbr_de_jour = 0;
            } 
            
            $listetotalreservations[] = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'=>'Utilisateurs'])->where(["Annonces.proprietaire_id" => $propres->id, "(Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."' OR (Reservations.created_at > SUBDATE(Reservations.dbt_at, ".$nbr_de_jour.") AND Reservations.created_at < Reservations.dbt_at AND DATE_FORMAT(Reservations.created_at, '%Y-%m-%d') = SUBDATE(CURRENT_DATE, 1)))", "Reservations.statut = 90", "Reservations.type = 0", "Reservations.commande_id <> 0"])
            // $listetotalreservations[] = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'=>'Utilisateurs'])->where(["Annonces.proprietaire_id" => $propres->id, "Reservations.statut = 90", "Reservations.type = 0"])
            ->join([            
                'dispo' => [
                    'table' => 'dispos',
                    'type' => 'inner',
                    'conditions' => ['dispo.reservation_id=Reservations.id', 'dispo.calendarsynchro_id=0'],
                ]
            ])->group('Reservations.id');
            $listetotalreservationsSum[] = $this->Reservations->getSumReservationsXML(["annonce.proprietaire_id" => $propres->id, "(Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."' OR (Reservations.created_at > SUBDATE(Reservations.dbt_at, ".$nbr_de_jour.") AND Reservations.created_at < Reservations.dbt_at AND DATE_FORMAT(Reservations.created_at, '%Y-%m-%d') = SUBDATE(CURRENT_DATE, 1)))", "Reservations.statut = 90", "Reservations.type = 0", "Reservations.commande_id <> 0"]);
            // $listetotalreservationsSum[] = $this->Reservations->getSumReservationsXML(["annonce.proprietaire_id" => $propres->id, "Reservations.statut = 90", "Reservations.type = 0"]);
        
            if(!empty($propres->paiements)) $listetauxcommission[$propres->id] = $propres->paiements[0]->taux_commission;
            else $listetauxcommission[$propres->id] = 0;
        }

        $nbrpropnonres = 0;
        foreach ($listetotalreservations as $totalreservations) {
            foreach ($totalreservations as $reservationune) {
                $nbrpropnonres++;
            }
        }
        
        $prixTotalRes = 0;
        $prixtab = [];
        $listpropreserv = [];
        foreach ($listetotalreservationsSum as $totalreservationsSum) {
            foreach ($totalreservationsSum as $reservationSum) {
                if($reservationSum->prixreservation == 0){
                    if($reservationSum['dispo']['promo_yn'] == 0) $prixtab[$reservationSum->id] += $reservationSum['dispo']['prix'];
                    else $prixtab[$reservationSum->id] += $reservationSum['dispo']['promo_px'];
                }else{
                    $prixtab[$reservationSum->id] = $reservationSum->prixreservation;
                }
                $listpropreserv[$reservationSum->id] = $reservationSum['annonce']['proprietaire_id'];
            }
        }
        
        foreach ($prixtab as $valid => $key) {
            if($listetauxcommission[$listpropreserv[$valid]] != 0) $prixTotalRes += round(($key-($key*$listetauxcommission[$listpropreserv[$valid]]/100)), 2);
            else $prixTotalRes += round(($key-($key*3/100)), 2);
        }

        if($nbrpropnonres != 0){
            try {   

            $msgId = "Virement-Location--".$now->i18nFormat('dd/MM/yyyy'); 
            $CreDtTm = $now->i18nFormat("yyyy-MM-dd'T'HH:mm:ss");
            $NbOfTxs = $nbrpropnonres;
            $CtrlSum = $prixTotalRes;
            $PmtInfId = "Virement-Location--".$now->i18nFormat('dd/MM/yyyy');
            $ReqdExctnDt = $today->i18nFormat('yyyy-MM-dd');
    
    
            $xml = new \XMLWriter();
            $xml->openURI("webroot/xml/Virement-Location-Prop-Residence--".$now->i18nFormat('dd-MM-yyyy').".xml");
            $xml->setIndent(true);
            $xml->setIndentString(''); 
            $xml->startDocument('1.0', 'UTF-8');
                $xml->startElement('Document');            
                    $xml->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
                    $xml->writeAttribute('xmlns', 'urn:iso:std:iso:20022:tech:xsd:pain.001.001.03');
                        $xml->startElement('CstmrCdtTrfInitn');
                            $xml->startElement('GrpHdr');
                                $xml->writeElement('MsgId', $msgId);
                                $xml->writeElement('CreDtTm', $CreDtTm);
                                $xml->writeElement('NbOfTxs', $NbOfTxs);
                                $xml->writeElement('CtrlSum', $CtrlSum);
                                    $xml->startElement('InitgPty');
                                        $xml->writeElement('Nm', 'Alpissime');
                                    $xml->endElement();
                            $xml->endElement();  
                            $xml->startElement('PmtInf'); 
                                $xml->writeElement('PmtInfId', $PmtInfId); 
                                $xml->writeElement('PmtMtd', "TRF"); 
                                $xml->writeElement('BtchBookg', "false"); 
                                $xml->writeElement('NbOfTxs', $NbOfTxs); 
                                $xml->writeElement('CtrlSum', $CtrlSum);
                                $xml->startElement('PmtTpInf');
                                    $xml->startElement('SvcLvl');
                                        $xml->writeElement('Cd', 'SEPA');
                                    $xml->endElement();
                                $xml->endElement();
                                $xml->writeElement('ReqdExctnDt', $ReqdExctnDt);
                                $xml->startElement('Dbtr');
                                    $xml->writeElement('Nm', 'SARL AMSA');
                                    $xml->startElement('PstlAdr');
                                        $xml->writeElement('PstCd', '73700');
                                        $xml->writeElement('TwnNm', 'Bourg Saint-Maurice');
                                        $xml->writeElement('Ctry', 'FR');
                                        $xml->writeElement('AdrLine', 'Galerie Pierra Menta a Arc 1800');
                                    $xml->endElement();
                                $xml->endElement();
                                $xml->startElement('DbtrAcct');
                                    $xml->startElement('Id');
                                        $xml->writeElement('IBAN', "FR7630004017100001013970791");
                                    $xml->endElement();
                                $xml->endElement();
                                $xml->startElement('DbtrAgt');
                                    $xml->startElement('FinInstnId');
                                        $xml->writeElement('BIC', "BNPAFRPP");
                                        // $xml->startElement('Othr');
                                        //     $xml->writeElement('Id', "BNPAFRPP");                                
                                        // $xml->endElement();
                                    $xml->endElement();
                                $xml->endElement();
                                $xml->writeElement('ChrgBr', "SLEV");
                                // Traitement pour chaque transaction
                                foreach ($listetotalreservations as $totalreservations) {
                                    foreach ($totalreservations as $reservation) {
                                        $propinfo = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id, ['contain' => ['Informationbancaires', 'Paiements']]);
                                        // On lance la création que pour les proprietaire qui ont saisi leurs info bancaire
                                        // if($propinfo->informationbancaire_id != 0){
                                            $paysprop = $this->Pays->find()->where(['id_pays' => $propinfo->pays])->first();
                                            if($paysprop->id_pays == 67) $villeprop = $this->Frvilles->find()->where(['id' => $propinfo->ville])->first(); 
                                            else $villeprop = $this->Pvilles->find()->where(['id' => $propinfo->ville])->first(); 
                                            /* Liste variables d'une transaction */
                                            $InstrId = $reservation->id."--".($reservation->dbt_at)->i18nFormat('dd/MM/yyyy')."--".$reservation['annonce']['utilisateur']->prenom; 
                                            $EndToEndId = $reservation->id."--".($reservation->dbt_at)->i18nFormat('dd/MM/yyyy')."--".$reservation['annonce']['utilisateur']->prenom;
                                            // $InstdAmt = $prixtab[$reservation->id]; 
                                            if(!empty($propinfo->paiements) && $propinfo->paiements[0]->taux_commission != 0) $InstdAmt = round(($prixtab[$reservation->id]-($prixtab[$reservation->id]*($propinfo->paiements[0]->taux_commission)/100)), 2);
                                            else $InstdAmt = round(($prixtab[$reservation->id]-($prixtab[$reservation->id]*3/100)), 2);
                                            $BIC = str_replace(' ','',$propinfo['informationbancaire']->BIC);
                                            $Nm = $propinfo['informationbancaire']->titulaire_compte;                        
                                            $PstCd = $propinfo->code_postal;
                                            $TwnNm = $villeprop->name;
                                            $Ctry = $paysprop->code_pays;
                                            if($propinfo['informationbancaire']->adresse != "") $AdrLine = $propinfo['informationbancaire']->adresse;
                                            else $AdrLine = "NOTPROVIDED";
                                            $IBAN = str_replace(' ','',$propinfo['informationbancaire']->IBAN);
                                            $Ustrd = $reservation->id."--".$reservation['utilisateur']->nom_famille."--".($reservation->dbt_at)->i18nFormat('dd-MM-yyyy')."--467102-PROPRIETAIRE"; 
        
                                            $xml->startElement('CdtTrfTxInf');
                                                $xml->startElement('PmtId');
                                                    $xml->writeElement('InstrId', $InstrId);
                                                    $xml->writeElement('EndToEndId', $EndToEndId);
                                                $xml->endElement();
                                                $xml->startElement('Amt');
                                                    $xml->startElement('InstdAmt');
                                                        $xml->writeAttribute('Ccy', 'EUR');
                                                        $xml->text($InstdAmt);
                                                    $xml->endElement();
                                                $xml->endElement();
                                                $xml->startElement('CdtrAgt');
                                                    $xml->startElement('FinInstnId');
                                                        $xml->writeElement('BIC', $BIC);                                
                                                    $xml->endElement();                                
                                                $xml->endElement();
                                                $xml->startElement('Cdtr');
                                                    $xml->writeElement('Nm', $Nm);
                                                    $xml->startElement('PstlAdr');
                                                        $xml->writeElement('PstCd', $PstCd);
                                                        $xml->writeElement('TwnNm', $TwnNm);
                                                        $xml->writeElement('Ctry', $Ctry);
                                                        $xml->writeElement('AdrLine', $AdrLine);
                                                    $xml->endElement();
                                                    $xml->writeElement('CtryOfRes', $Ctry); 
                                                $xml->endElement();
                                                $xml->startElement('CdtrAcct');
                                                    $xml->startElement('Id');
                                                        $xml->writeElement('IBAN', $IBAN);
                                                    $xml->endElement();
                                                $xml->endElement();
                                                $xml->startElement('RmtInf');
                                                    $xml->writeElement('Ustrd', $Ustrd);
                                                $xml->endElement();                            
                                            $xml->endElement();
                                            // END transaction
                                            // Enregistrer date_virement danst reservations
                                            // $data = array('date_virement' => $today);
                                            // $newReservation = $this->Reservations->patchEntity($reservation, $data);
                                            // $this->Reservations->save($newReservation);
                                        // }
                                    }
                                }
                                // END all transaction
                        $xml->endElement();            
                    $xml->endElement();            
                $xml->endElement();
            $xml->endDocument();
            $xml->flush();
            unset($xml);
    
            // Envoie par mail à qui ???
            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();
            // #####################################################
            $email = new Email('production');
            $email->to('paiements@alpissime.com')
                ->from([$mail->val=>FROM_MAIL])
                ->subject('Fichier XML - Virement Proprietaire-Residence '.$now->i18nFormat('dd-MM-yyyy'))
                ->emailFormat('html')
                ->attachments(array(
                    "Virement-Location-Prop-Residence--".$now->i18nFormat('dd-MM-yyyy').".xml" => array(
                        'file' => "webroot/xml/Virement-Location-Prop-Residence--".$now->i18nFormat('dd-MM-yyyy').".xml",
                        'mimetype' => 'application/xml'
                    ),    
                ))
                ->send('Bonjour, <br><br> Vous trouvez ci-joint le fichier XML pour les réservations du '.$now->i18nFormat('dd-MM-yyyy').'.');
            // #####################################################
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
                    ->send('Bonjour, <br><br> Erreur Function generateXMLpropRes : <br><br> '.$th);
            }
        }

        Log::write('info', 'End Execute generateXMLpropRes Function'); 
    }
    /**
     * 
     */
    public function rappelRIB()
    {
        Log::write('info', 'Start Execute rappelRIB Function'); 

        $totalreservations = $this->Reservations->find()->contain(['Annonces'=>'Utilisateurs'])->where(["DATEDIFF( Reservations.dbt_at, CURDATE() ) >= 0", "DATEDIFF( Reservations.dbt_at, CURDATE() ) <= 4", "Utilisateurs.informationbancaire_id = 0", "Reservations.statut = 90", "Reservations.type = 0", "Reservations.commande_id <> 0"])
        ->join([            
            'dispo' => [
                'table' => 'dispos',
                'type' => 'inner',
                'conditions' => 'dispo.reservation_id=Reservations.id',
            ]
        ])->group(['Reservations.id', 'Utilisateurs.id']);

        $datamustache = [];
        foreach ($totalreservations as $reservation) {
            try { 
                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail=$mails->first();
    
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['annonce']['utilisateur'],'textEmail'=>'rappelRIB',
                                                         'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################
    
                Log::write('info', 'Send mail rappelRIB to '.$reservation['annonce']['utilisateur']->email);
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
                    ->send('Bonjour, <br><br> Erreur Function rappelRIB : <br><br> '.$th);
            }
        }

        Log::write('info', 'End Execute rappelRIB Function'); 
    }
    /**
     * 
     */
    public function arc1800RappelLingeMenage1mois()
    {
        Log::write('info', 'Start Execute arc1800RappelLingeMenage1mois Function'); 

        $now = Time::now();
        $now->addDays(30);

        $totalreservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90", "Annonces.village IN (4,7,8,9)"]);
        $datamustache = [];
        foreach ($totalreservations as $reservation) {
            try { 
                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail=$mails->first();
    
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur'],'textEmail'=>'arc1800RappelLingeMenage1mois',
                                                         'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################
    
                Log::write('info', 'Send mail arc1800RappelLingeMenage1mois to '.$reservation['utilisateur']->email);
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
                    ->send('Bonjour, <br><br> Erreur Function arc1800RappelLingeMenage1mois : <br><br> '.$th);
            }
        }

        Log::write('info', 'End Execute arc1800RappelLingeMenage1mois Function'); 
    }
    /**
     * 
     */
    public function generatePDFcommission()
    {
        Log::write('info', 'Start Execute generatePDFcommission Function');
        $now = Time::now();
        
        $listeReservations = $this->Reservations->find("all")->contain(['Annonces' => 'Utilisateurs'])
        ->join([
            'Annonces' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => ['Annonces.id=Reservations.annonce_id'],
            ],
            'Dispos' => [
                'table' => 'dispos',
                'type' => 'inner',
                'conditions' => ['Dispos.reservation_id=Reservations.id'],
            ],
            'C' => [
                'table' => 'contrats',
                'type' => 'left',
                'conditions' => ['Annonces.id=C.annonce_id'],
            ],
            'CT' => [
                'table' => 'contratypes',
                'type' => 'left',
                'conditions' => ['CT.id=C.type'],
            ],
        ])
        ->group(['Reservations.id'])
        ->where(["Reservations.fin_at = '".$now->i18nFormat('yyyy-MM-dd')."'", 'Reservations.statut = 90', 'Reservations.type = 0', '(CT.id IS NULL OR CT.id <> 5)', 'Utilisateurs.nature <> "PRES"'])
        ->order(['Reservations.dbt_at ASC','Reservations.created_at ASC']);

        $dernierNum = $this->Reservations->find("all")->order(['Reservations.num_facture_commission DESC'])->first();
        
        if(strlen($dernierNum->num_facture_commission) == substr_count($dernierNum->num_facture_commission, '9')) $nbrdechiffre = strlen($dernierNum->num_facture_commission) + 2;
        else $nbrdechiffre = strlen($dernierNum->num_facture_commission);
        
        $dernierNumInt = intval($dernierNum->num_facture_commission);
        $num = $dernierNumInt + 1;
        foreach ($listeReservations as $reservation) {
            // Ville
            $ville = $this->Frvilles->find("all")->where(['id' => $reservation['annonce']['utilisateur']->ville]);
            if($ville = $ville->first()) $villeprop = $ville->name;
            else $villeprop = "";
            // date virement
            $now2   = $reservation->dbt_at;
            $clone2 = clone $now2;
            $tet2 = $clone2->modify( '+1 day' );
            $dateVirement = $tet2->format( 'd/m/Y' );            
            // commission
            $prixreservation = 0;
            if($reservation->prixreservation != 0){
                $prixreservation = $reservation->prixreservation;
            }else{
                // ON CHERCHE DANS DISPOS
                $listeDispos = $this->Dispos->find("all")->where(['Dispos.reservation_id' => $reservation->id]);
                foreach ($listeDispos as $listeDispo) {
                    if($listeDispo->promo_yn == 0) $prixreservation += $listeDispo->prix;
                    else $prixreservation += $listeDispo->promo_px;
                }
            }
                // Vérifier si un PRES pour savoir le % de commission
            if($reservation['annonce']['utilisateur']->nature == "PRES"){
                $propres = $this->Utilisateurs->find("all")->contain(['Paiements'])->where(['Utilisateurs.id' => $reservation['annonce']['utilisateur']->id]);
                if($propres = $propres->first()){
                    if(!empty($propres->paiements)) $pourcentCommission = $propres->paiements[0]->taux_commission;
                    else $pourcentCommission = 3;
                }else{
                    $pourcentCommission = 3;
                }
            }else{
                $pourcentCommission = 3;
            }
            $commissionTTC = round($prixreservation*$pourcentCommission/100,2);
            $commissionHT = round($commissionTTC/1.2,2);
            $commissionTVA = round($commissionHT*0.2,2);
            // génération pdf
            $mpdf = new \Mpdf\Mpdf();
            $html= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
            <head>
            </head>
            <body style="font-family:\'Open Sans\',sans-serif">
                <div style="width:100%">
                    <div style="width:70%;float:left">
                        <img style="padding:5px" src="https://www.alpissime.com/images/logo_landing_page.png"/>
                    </div>
                </div>
                <div style="width:100%;">
                    <div style="width:70%;float:left">
                        <p>SARL AMSA - BP 12<br>GALERIE PIERRA MENTA<br>73706 ARC 1800 CEDEX<br>Capital : 7622,45€ TVA : FR 21 405 097 320</p><br>
                    </div>
                    <div style="width:30%;float:right">
                        <p>'.$reservation['annonce']['utilisateur']->prenom.' '.$reservation['annonce']['utilisateur']->nom_famille.'<br>'.$reservation['annonce']['utilisateur']->adresse.'<br>'.$reservation['annonce']['utilisateur']->code_postal.', '.$villeprop.'</p>
                    </div>
                </div>
                <hr style="width:100%">
                <div style="width:100%;">
                    <p><span style="font-weight: bold;font-size: 1.17em;"><br>Facture #ALPISSIME-RESA'.sprintf("%'.0".$nbrdechiffre."d", $num).'<br></span>'.$dateVirement.'</p><br>
                </div>
                <hr style="width:100%">
                <p><span style="font-weight: bold;font-size: 1.17em;"><br>'.ucfirst(mb_strtolower($reservation['annonce']['titre'])).'<br></span>Du '.$reservation->dbt_at->i18nFormat('dd/MM/yyyy').' au '.$reservation->fin_at->i18nFormat('dd/MM/yyyy').'</p><br>
                <table style="width:100%;" border="1" cellpadding="0" cellspacing="0" style="width:100%">
                <tr style="border-bottom: 1px solid black;">
                    <th style="padding: 15px;">Frais de services HT</th>
                    <th style="padding: 15px;">TVA frais de services</th>
                    <th style="padding: 15px;">Frais de services TTC</th>
                </tr>
                <tr>
                    <td style="padding: 15px;">'.$commissionHT.' €</td>
                    <td style="padding: 15px;">'.$commissionTVA.' €</td>
                    <td style="padding: 15px;">'.$commissionTTC.' €</td>
                </tr>
                </table>
                <p><br>Les frais de services ont été prélevés lors du virement correspondant à la réservation #'.$reservation->id.'</p>
            </body>
            </html>';
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->list_indent_first_level = 0;
            $mpdf->WriteHTML($html,2);
            $name="facture_".sprintf("%'.0".$nbrdechiffre."d", $num)."_reservation_".$reservation->id;
            $mpdf->Output(ROOT.DS.'webroot'.DS.'facturecommission'.DS.$name.'.pdf');
            // Fin génération pdf
            $dataReservation = array('num_facture_commission' => sprintf("%'.0".$nbrdechiffre."d", $num));
            $reservationNew = $this->Reservations->patchEntity($reservation, $dataReservation);
            $this->Reservations->save($reservationNew);
            Log::write('info', 'Enregistrement facture commission '.sprintf("%'.0".$nbrdechiffre."d", $num).' pour reservation ID : '.$reservation->id);
            $num++;
            // exit;            
        }
        Log::write('info', 'End Execute generatePDFcommission Function');
    }
    /**
     * 
     */
    public function statistiquetauxremplissage()
    {
        Log::write('info', 'Start Execute statistiquetauxremplissage Function');
        // tester si c'est samedi
        if(date('N') == 6){
            try { 
                $nbrAnnonceActive = $this->Annonces->find("all")->where(['Annonces.statut=50'])->count();
                $nbrLitAnnonce = $this->Annonces->find("all")->where(['Annonces.statut=50'])->select(['nbrmaxannonce' => 'SUM(Annonces.personnes_nb)'])->first();
                $nbrLitAnnonce = $nbrLitAnnonce->nbrmaxannonce;
                // $nbr_annonce_active = $this->Annonces->find("all")->where
                $data = array("nbr_annonce_active" => $nbrAnnonceActive, "nbr_lit_lie" => $nbrLitAnnonce);
                $this->loadModel("Statistiquetauxremplissage");
                $newstat = $this->Statistiquetauxremplissage->newEntity($data);
                if($this->Statistiquetauxremplissage->save($newstat)) Log::write('info', 'data enregistrée dans table Statistiquetauxremplissage');
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
                    ->send('Bonjour, <br><br> Erreur Function statistiquetauxremplissage : <br><br> '.$th);
            }
        } 
        Log::write('info', 'End Execute statistiquetauxremplissage Function');
    }
    /**
     * updateCalendarSynchro () method
     */
    public function updateCalendarSynchro()
    {
        Log::write('info', 'Start Execute updateCalendarSynchro Function'); 
        $listeCalendar = $this->Calendarsynchro->find("all")->where(['actif'=>1]);
        foreach ($listeCalendar as $value) {
            try {
                (new DisposController())->updateCalendarSynchro($value->url, $value->annonce_id, $value->id);
                Log::write('info', 'Update updateCalendarSynchro id : '.$value->id);
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
                    ->send('Bonjour, <br><br> Erreur Function updateCalendarSynchro : <br><br> '.$th);
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
                ->send('Bonjour, <br><br> Erreur Function verifyAllSynchroDispo 2h matin : <br><br> '.$th);
        }
        Log::write('info', 'End Execute updateCalendarSynchro Function'); 
    }
    /**
     * 
     */
    public function compressImage()
    {
        Log::write('info', 'Execute compressImage Function');       
        
        // $listeannonces = $this->Annonces->find();
        $listeannonces = array(1330, 1316, 1247, 1328, 1331, 1332, 1333, 1334, 1335, 1336, 1338, 1339, 139, 1340, 1341, 1342, 1329, 1325, 1322, 1291, 1323, 1324);
        foreach ($listeannonces as $value) {
            
            $prefixe = ".";
            $destname = "$prefixe/webroot/images_ann/$value/";  
            
            $data = $this->Photos->find("all",["conditions"=>["Photos.annonce_id"=>$value]]);
            // $count = $data->count();
            // if($count < 10){
            foreach ($data as $key) {
                $num = $key->numero;
                $vignette ="vignette-$value-".$num.".jpg";
                $vignetteP ="vignette-$value-".$num.".P.jpg";
                $vignetteG="vignette-$value-".$num.".G.jpg";
                $vignetteGOrigine="vignette-$value-".$num.".GOrigine.jpg";

                $filename = "$prefixe/webroot/images_ann/$value/$vignetteG";      
        
                $sizes = getimagesize($filename);
                /* on verifie taille image */
                $largeur = $sizes[0] ;
                $hauteur = $sizes[1];
                
                $imagine = new Imagine();
               
                $image = $imagine->open($filename);
                if($hauteur>$largeur){
                    $image->resize(new Box(525, 700));   
                }else{
                    $image->resize(new Box(700, 525));   
                }   
                /********** IL FAUT METTRE : $destname.$vignette ************/
                $image->save("$prefixe/webroot/images_ann/$value/$vignetteG", array('jpeg_quality' => 75));
                
                
                $imageP = $imagine->open("$prefixe/webroot/images_ann/$value/$vignetteP");
                /********** IL FAUT METTRE : $destname.$vignette ************/
                $imageP->save("$prefixe/webroot/images_ann/$value/$vignetteP", array('jpeg_quality' => 75));
                
                
                $imagepetite = $imagine->open("$prefixe/webroot/images_ann/$value/$vignette");
                /********** IL FAUT METTRE : $destname.$vignette ************/
                $imagepetite->save("$prefixe/webroot/images_ann/$value/$vignette", array('jpeg_quality' => 75));
                
                    
            } 
            print_r($value);
            print_r("******");
        } 
        
        
        Log::write('info', 'End Execute compressImage Function');
    }
    /**
     * 
     */
    public function demandeMenageDepart()
    {
        Log::write('info', 'Start Execute demandeMenageDepart Function'); 
        $now = Time::now();
        $now->addDays(4); 
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.fin_at = '".$now->i18nFormat('yyyy-MM-dd HH:mm:ss')."'", "Reservations.statut = 90"]);
        
        foreach ($listeReservations as $reservation) {
            try {   
            if($reservation['annonce']->contrat == 1){
                /**** Send Mail ****/
                $this->loadModel('BlocMailGestionnaires');            
                $blocsinfos = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => $reservation['annonce']->id_gestionnaires])->first();
                $datamustache = array('bloc_menage_depart' => $blocsinfos->bloc_menage_depart, 'bloc_menage_depart_en' => $blocsinfos->bloc_menage_depart_en, 'nom' => $reservation['utilisateur']->nom_famille, 'prenom' => $reservation['utilisateur']->prenom);

                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail=$mails->first();

                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $reservation['utilisateur']->email,'textEmail'=>'demandeMenageDepart',
                                                        'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################

                Log::write('info', 'Send mail demandeMenageDepart to '.$reservation['utilisateur']->email);
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
                    ->send('Bonjour, <br><br> Erreur Function demandeMenageDepart : <br><br> '.$th);
            }          
        }
        Log::write('info', 'End Execute demandeMenageDepart Function');
    }
        
     
}
