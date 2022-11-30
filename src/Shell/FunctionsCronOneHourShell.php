<?php
namespace App\Shell;

use Cake\Console\Shell;
use Mustache_Engine;
use Cake\Mailer\Email;
use Cake\Log\Log;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\I18n\DateTime;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Event\EventManager;

/**
 * FunctionsCronOneHour shell command.
 */
class FunctionsCronOneHourShell extends Shell
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
        Log::write('info', 'START ALL FUNCTIONS CRON ONE HOUR');
        $this->findReservationOption2hours();
        Log::write('info', 'START ALL FUNCTIONS CRON ONE HOUR');
    }
    /**
     * findReservationOption2hours() method.
     */
    public function findReservationOption2hours()
    {
        Log::write('info', 'Start Execute findReservationOption2hours Function'); 
        $now = new Time('-2 hours');
        $hours = $now->format('Y-m-d H');
        // $this->out();
        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["DATE_FORMAT(Reservations.created_at, '%Y-%m-%d %H') = '".$hours."'", "Reservations.statut = 0", 'Reservations.quote_id <> 0', 'Reservations.increment_id = 0']);
        $this->out($listeReservations);
        foreach ($listeReservations as $reservation) {
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
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire->email,'textEmail'=>'findReservationOption2hours',
                                                     'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                    ]);
            $this->eventManager()->dispatch($event);
            // #####################################################

            Log::write('info', 'Send mail findReservationOption2hours to '.$proprietaire->email);
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
}
