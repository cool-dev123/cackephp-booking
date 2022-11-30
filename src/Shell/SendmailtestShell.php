<?php
namespace App\Shell;

use Cake\Console\Shell;
use Mustache_Engine;
use Cake\Log\Log;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Mailer\Email;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use mPDF;
use App\Controller\DisposController;

/**
 * Sendmailtest shell command.
 */
class SendmailtestShell extends Shell
{
    public function initialize()
    {
        parent::initialize();        
        $this->loadModel("Annonces");  
        $this->loadModel("Photos");
        $this->loadModel("Utilisateurs");
        $this->loadModel("Reservations");
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
        $this->loadModel("Residences");   
        $this->loadModel("Penalites"); 
        $this->loadModel("Calendarsynchro");
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
        $this->updateCalendarSynchro();
        // $this->anniversaireLocation();
        // $this->updateCalendarSynchro();
        // $this->generatePDFfacture();
        // $this->generateoldfacturecommission();
        // $this->out('Hello World');
        // $this->generateXML();
//        $email = new Email('production');
//        $email->template('annoncesNotContrat', 'default')
//                ->emailFormat('html')
//                ->to("maroua.c@ite.digital")
//                ->from("maroua.g@ite.digital")
//                ->subject("Envoie Mail Cron avec Shell")
//                ->viewVars(['annoncesNotContrat'=>"Mail envoyé avec success à partir du Shell avec Cron. <br> Excellent !"])
//                ->send();
    }

    /**
     * updateCalendarSynchro () method
     */
    public function updateCalendarSynchro()
    {
        Log::write('info', 'Start Execute updateCalendarSynchroHoures Function'); 
        // $listeCalendar = $this->Calendarsynchro->find("all")->where(['actif'=>1]);
        // foreach ($listeCalendar as $value) {
            try {
                (new DisposController())->updateCalendarSynchro("https://www.airbnb.fr/calendar/ical/693785240942586123.ics?s=e890092f82b67a7017bf25505792ce0f", 172, 25, "houres");
                Log::write('info', 'Update updateCalendarSynchroHoures id : '.$value->id);
                exit;
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
        // }
        
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
    public function verifysynchrodispo()
    {
        Log::write('info', 'Start Execute verifysynchrodispo Function'); 
        $allAnonces = $this->Calendarsynchro->find()->group(['annonce_id'])->extract('annonce_id');
        foreach ($allAnonces as $annonceId) {
            try {
                $tabStart = [];
                $tabEnd = [];
                $listCalendarAnnonce = $this->Calendarsynchro->find()->where(['annonce_id' => $annonceId]);
                foreach ($listCalendarAnnonce as $calendarAnn) {
                    $file = $calendarAnn->url;
                    $ical = file_get_contents($file);
                    preg_match_all('/(BEGIN:VEVENT.*?END:VEVENT)/si', $ical, $result, PREG_PATTERN_ORDER);        
                    for ($i = 0; $i < count($result[0]); $i++) {
                        $result[0][$i] = str_replace("\r\n","\n",$result[0][$i]);
                        $tmpbyline = explode("\n", $result[0][$i]);
                        
                        foreach ($tmpbyline as $item) {
                            $tmpholderarray = explode(":",$item);
                            
                            if (count($tmpholderarray) >1) {
                                $postart = strpos($tmpholderarray[0], "DTSTART");
                                $posend = strpos($tmpholderarray[0], "DTEND");
                                if ($postart !== false){
                                    $majorarray["DTSTART"] = date('Y-m-d', strtotime($tmpholderarray[1]));
                                    $tabStart[] = date('Y-m-d', strtotime($tmpholderarray[1]));
                                } 
                                else if ($posend !== false){
                                    $majorarray["DTEND"] = date('Y-m-d', strtotime($tmpholderarray[1]));
                                    $tabEnd[] = date('Y-m-d', strtotime($tmpholderarray[1]));
                                } 
                                else {
                                    $majorarray[$tmpholderarray[0]] = $tmpholderarray[1];
                                }
                            }
                        }
                        
                        $icalarray[] = $majorarray;
                        unset($majorarray);
                    }
                }
                
                $listReservSynchrAnnonce = $this->Reservations->find()->where(['annonce_id' => $annonceId, 'statut' => 90, 'type' => 2]);
                foreach ($listReservSynchrAnnonce as $reservSynchroAnn) {
                    if( !array_search($reservSynchroAnn->dbt_at, $tabStart) && !array_search($reservSynchroAnn->fin_at, $tabEnd)) {
                        // reservation
                        $a_reservation=array("statut"=>10,'updated_at'=>new Time());
                        $reservation=$this->Reservations->patchEntity($reservSynchroAnn,$a_reservation);
                        $this->Reservations->save($reservation);
                        // dispos
                        $dispos=$this->Dispos->find('all',['conditions'=>['Dispos.reservation_id'=>$reservSynchroAnn->id]]);
                        foreach ($dispos as $dispo) {
                            $a_dispo=array('statut'=>0,'utilisateur_id'=>null,'reservation_id'=>null);
                            $dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
                            $this->Dispos->save($dispo);
                        }
                        Log::write('info', 'Don\'t find synchro reservationID : '.$reservSynchroAnn->id); 
                    }
                }
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
                    ->send('Bonjour, <br><br> Erreur Function verifysynchrodispo : <br><br> '.$th);
            }
            
        }
        Log::write('info', 'End Execute verifysynchrodispo Function'); 
    }
    /**
     * 
     */
    public function generateXML()
    {
        Log::write('info', 'Start Execute generateXML Function'); 
        $now = Time::now();
        $now->subDays(1); 

        $today = Time::now();

        // $totalreservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'=>'Utilisateurs'])->where(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90", "Reservations.type = 0", "Reservations.commande_id <> 0"])
        // ->join([            
        //     'dispo' => [
        //         'table' => 'dispos',
        //         'type' => 'inner',
        //         'conditions' => ['dispo.reservation_id=Reservations.id', 'dispo.calendarsynchro_id=0'],
        //     ]
        // ])->group('Reservations.id');
        // $totalreservationsSum = $this->Reservations->getSumReservationsXML(["Reservations.dbt_at = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90", "Reservations.type = 0", "Reservations.commande_id <> 0"]);
       
        // A enlever !!!!!!
        $totalreservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'=>'Utilisateurs'])->where(["Reservations.dbt_at = '2022-07-13'", "Reservations.statut = 90", "Reservations.type = 0", "Reservations.commande_id <> 0"])
        ->join([            
            'dispo' => [
                'table' => 'dispos',
                'type' => 'inner',
                'conditions' => ['dispo.reservation_id=Reservations.id', 'dispo.calendarsynchro_id=0'],
            ]
        ])->group('Reservations.id');
        $totalreservationsSum = $this->Reservations->getSumReservationsXML(["Reservations.dbt_at = '2022-07-13'", "Reservations.statut = 90", "Reservations.type = 0", "Reservations.commande_id <> 0"]);

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
        // print_r($prixtab);
        // exit;
        foreach ($prixtab as $valuetot => $key) {
            $prixtab[$valuetot] = $key-($key*2/100);
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
        }
 
       
        Log::write('info', 'End Execute generateXML Function');
    }
    /**
     * updateCalendarSynchro () method
     */
    public function updateCalendarSynchro_old()
    {
        Log::write('info', 'Start Execute updateCalendarSynchro Function'); 
        $listeCalendar = $this->Calendarsynchro->find("all");
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
        Log::write('info', 'End Execute updateCalendarSynchro Function'); 
    }
    /**
     * passerellesNouvellesPeriodes () method
     */
    public function passerellesNouvellesPeriodes()
    {
        Log::write('info', 'Start Execute passerellesNouvellesPeriodes Function'); 
        $now = Time::now();
        $now->subDays(1); 
        $listeReservations = $this->Reservations->find()->contain(['Annonces'])
        ->join([
            'Dispos' => [
                'table' => 'dispos',
                'type' => 'inner',
                'conditions' => ['Dispos.annonce_id=Reservations.annonce_id', 'Dispos.calendarsynchro_id <> 0'],
            ]
        ])
        ->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d') = '".$now->i18nFormat('yyyy-MM-dd')."'", "Reservations.utilisateur_id = 0"]);
        foreach ($listeReservations as $reservation) {
            try {   
            $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
            /**** Send Mail ****/
            $datamustache = array('prenomprop' => $proprietaire->prenom,'nomprop' => $proprietaire->nom_famille);

            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();

            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire->email,'textEmail'=>'passerellesNouvellesPeriodes',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################

            Log::write('info', 'Send mail passerellesNouvellesPeriodes to '.$proprietaire->email);
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
                    ->send('Bonjour, <br><br> Erreur Function passerellesNouvellesPeriodes : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute passerellesNouvellesPeriodes Function'); 
    } 

    public function InscriptionPropSansAnnonce4h()
    {
        Log::write('info', 'Start Execute InscriptionPropSansAnnonce4h Function'); 
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

                    Log::write('info', 'Send mail InscriptionPropSansAnnonce4h Prop : '.$utilisateur->email);
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
                    ->send('Bonjour, <br><br> Erreur Function InscriptionPropSansAnnonce4h : <br><br> '.$th);
            }
        }
        Log::write('info', 'End Execute InscriptionPropSansAnnonce4h Function'); 
    }

    /**
     * anniversaireLocation() method
     */
    public function anniversaireLocation() {
        Log::write('info', 'Start Execute anniversaireLocation Function');
        $now = Time::now();
        $now = new Time("2022-04-11");
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
     * 
     */
    public function generateoldfacturecommission()
    {
        $this->loadModel("Reservations");
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
        ->where(['Reservations.dbt_at > "2020-10-01"', 'Reservations.fin_at <= CURDATE()', 'Reservations.statut = 90', 'Reservations.type = 0', '(CT.id IS NULL OR CT.id <> 5)', 'Utilisateurs.nature <> "PRES"'])
        ->order(['Reservations.dbt_at ASC','Reservations.created_at ASC']);

        // print_r($listeReservations->sql());
        // exit;
        $this->loadModel("Frvilles");
        $this->loadModel("Dispos");
        $this->loadModel("Utilisateurs");

        $num = 1;
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
                    else $pourcentCommission = 2;
                }else{
                    $pourcentCommission = 2;
                }
            }else{
                $pourcentCommission = 2;
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
                    <p><span style="font-weight: bold;font-size: 1.17em;"><br>Facture #ALPISSIME-RESA'.sprintf("%'.07d", $num).'<br></span>'.$dateVirement.'</p><br>
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
            $name="facture_".sprintf("%'.07d", $num)."_reservation_".$reservation->id;
            $mpdf->Output(ROOT.DS.'webroot'.DS.'facturecommission'.DS.$name.'.pdf');
            // Fin génération pdf
            $dataReservation = array('num_facture_commission' => sprintf("%'.07d", $num));
            $reservationNew = $this->Reservations->patchEntity($reservation, $dataReservation);
            $this->Reservations->save($reservationNew);
            $num++;
            // exit;
        }
    }
    /**
     * 
     */
    public function generatePDFfacture()
    {
        // $i = 1;
        // $numfacture = sprintf("%'.07d", $i);

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
                    <p>{proprietaire nom/prenom}<br>{Adresse}<br>{code postal}, {ville}</p>
                </div>
            </div>
            <hr style="width:100%">
            <div style="width:100%;">
                <p><span style="font-weight: bold;font-size: 1.17em;"><br>Facture #ALPISSIME-RESA0000001<br></span>01/01/2022</p><br>
            </div>
            <hr style="width:100%">
            <p><span style="font-weight: bold;font-size: 1.17em;"><br>Titre de l\'annonce<br></span>Du XX/XX/XX au XX/XX/XX</p><br>
            <table style="width:100%;" border="1" cellpadding="0" cellspacing="0" style="width:100%">
              <tr style="border-bottom: 1px solid black;">
                <th style="padding: 15px;">Frais de services HT</th>
                <th style="padding: 15px;">TVA frais de services</th>
                <th style="padding: 15px;">Frais de services TTC</th>
              </tr>
              <tr>
                <td style="padding: 15px;">8.33 €</td>
                <td style="padding: 15px;">1.67 €</td>
                <td style="padding: 15px;">10 €</td>
              </tr>
            </table>
            <p><br>Les frais de services ont été prélevés lors du virement correspondant à la réservation #IDRéservation</p>
        </body>
        </html>';
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->list_indent_first_level = 0;
		$mpdf->WriteHTML($html,2);
		$name="reservation_idreserv";
		$mpdf->Output(ROOT.DS.'webroot'.DS.'facturecommission'.DS."facture_".$name.'.pdf');
    }
    /**
     * 
     */
    public function generationPhotosAnnonces()
    {
        $prefixe = "C:/xampp/htdocs".$_SERVER['DOCUMENT_ROOT'];
        
        $listeAnnonces = $this->Annonces->find();
        foreach ($listeAnnonces as $value) {
            $i = 1;
            while($i<11){
                $f = $this->Photos->find("all",["conditions"=>["Photos.numero"=>$i,"Photos.annonce_id"=>$value->id]])->count();
                if($f == 1)
                {
                    $num = $i;
                    $vignetteG="vignette-".$value->id."-".$num.".G.jpg";
                    $vignetteP ="vignette-".$value->id."-".$num.".P.jpg";
                    $vignette ="vignette-".$value->id."-".$num.".jpg";
                    $imagine = new Imagine();
                    $watermark = $imagine->open('C:\xampp\htdocs\alpissime\webroot\logoalpissimecertif.png');
                    $bottomRight = new Point(5, 5);                    

                    if(file_exists("$prefixe/alpissime/webroot/images_ann/".$value->id."/$vignetteG")){
                        $imagepetite = $imagine->open("$prefixe/alpissime/webroot/images_ann/".$value->id."/$vignetteG");
                        $imagepetite->resize(new Box(363, 272));
                        $imagepetite->paste($watermark, $bottomRight);
                        /********** IL FAUT METTRE : $destname.$vignette ************/
                        $imagepetite->save("$prefixe/alpissime/webroot/images_ann/".$value->id."/$vignetteP", array('jpeg_quality' => 85)); 
                        
                        $image = $imagine->open("$prefixe/alpissime/webroot/images_ann/".$value->id."/$vignetteG");
                        $image->resize(new Box(170, 120));
                        //$image->paste($watermark, $bottomRight);
                        /********** IL FAUT METTRE : $destname.$vignette ************/
                        $image->save("$prefixe/alpissime/webroot/images_ann/".$value->id."/$vignette", array('jpeg_quality' => 85)); 
                    }
                    
                    $i++;
                }else{                    
                    $i++;
                }
            }
        }
        
    }
    
    public function compressPhotos(){
        $directories = array(
            "C:/xampp/htdocs".$_SERVER['DOCUMENT_ROOT']."/alpissime/webroot/images", 
            "C:/xampp/htdocs".$_SERVER['DOCUMENT_ROOT']."/alpissime/webroot/images/ico", 
            "C:/xampp/htdocs".$_SERVER['DOCUMENT_ROOT']."/alpissime/webroot/images/icon", 
            "C:/xampp/htdocs".$_SERVER['DOCUMENT_ROOT']."/alpissime/webroot/images/partners", 
            "C:/xampp/htdocs".$_SERVER['DOCUMENT_ROOT']."/alpissime/webroot/images/slider", 
            "C:/xampp/htdocs".$_SERVER['DOCUMENT_ROOT']."/alpissime/webroot/images/slider/icone", 
            "C:/xampp/htdocs".$_SERVER['DOCUMENT_ROOT']."/alpissime/webroot/img", 
            "C:/xampp/htdocs".$_SERVER['DOCUMENT_ROOT']."/alpissime/webroot/img/uploads");
        foreach ($directories as $directory) {
            //print_r($directory . "\n");
            //$directory = "C:/xampp/htdocs".$_SERVER['DOCUMENT_ROOT']."/alpissime/webroot/images/slider";
            $imagesJPG = glob($directory . '/*.jpg');
            $imagesPNG = glob($directory . '/*.png');
            $i = 1;
            foreach ($imagesJPG as $fileJPG){
                print_r("JPG \n");
                print_r($fileJPG."\n");
                $imagineJPG = new Imagine();
                $imagineJPG->open($fileJPG)->save($fileJPG, array('jpeg_quality' => 85));
                $i++;
            }

            foreach ($imagesPNG as $filePNG){
//                print_r("PNG \n");
//                print_r($filePNG."\n");
                $imaginePNG = new Imagine();
                $imaginePNG->open($filePNG)->save($filePNG, array('png_compression_level' => 5));
                $i++;
            }
            print_r($i); 
        }
        
    }
}
