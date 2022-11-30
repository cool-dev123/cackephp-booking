<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Controller\SendInBlueController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Utility\Xml;
use Cake\View\View;
use \SoapServer;
use \Panier;
use \SoapClient;
use Mustache_Engine;
use Mage;
use Mage_Core_Model_Store;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Cake\I18n\I18n;
use Cake\Core\Configure;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Log\Log;
use Cake\Collection\Collection;

/**
 * Annonces Controller
 *
 * @property \App\Model\Table\AnnoncesTable $Annonces
 */
class AnnoncesController extends AppController
{
	public $helpers = ['Text','AnnonceFormater'];

	private $_new_announces_period = 14;//days

	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Flash');
		$this->loadComponent('RequestHandler');

		if ($this->request->action === 'view' || $this->request->action === 'prop' || $this->request->action === 'contact' || $this->request->action === 'viewprev' || $this->request->action === 'add' || $this->request->action === 'addnewsteps') {
			// $this->loadComponent('InvisibleReCaptcha.InvisibleReCaptcha',
			// [
			// 	// 'secretkey' => '6LfWgbsZAAAAAB_Ey8rHRoeCTZ3ZR1VQKQyLc3ge',
			// 	// 'sitekey' => '6LfWgbsZAAAAAOytZsO4ZNk6M-6KY7gJriJYtDzl'
			// 	'secretkey' => '6Ld_sI8bAAAAAAnR-7FHvvpivhf-Ls6TZykwevtz',
			// 	'sitekey' => '6Ld_sI8bAAAAAB8fRlz74t_tdw2e4YEv-ZG2KXug'
			// ]);
			$session = $this->request->session();
            if($session->read('Config.language')){
                $this->loadModel("Languages");
                $language = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();
                Configure::write('Recaptcha', [
                    'sitekey' => '6Lcu7zcUAAAAALO8dq1CAaPIukNdzFKvib-qSV_d',
                    'secret' => '6Lcu7zcUAAAAABkkxstN97NSgxpTGtcorYA3IXzH',
                    'lang' => $language->url_code,
                    'theme' => 'light',
                    'type' => 'image',
                    'size' => 'normal'
               ]);
            }
			$this->loadComponent('Recaptcha.Recaptcha');
		}

		$this->loadModel("Residences");
		$this->loadModel("Utilisateurs");
		$this->loadModel("Dispos");
		$this->loadModel("Villages");
		$this->loadModel("Images");
		$this->loadModel("Photos");
		$this->loadModel("Lieugeos");
		$this->loadModel("Contacts");

		$this->loadComponent('Auth', [
			'loginAction' => [
				'controller' => 'Utilisateurs',
				'action' => 'erreurconnexion'
			],
			'loginRedirect' => [
				'controller' => 'annonces',
				'action' => 'landing'
			],
			'authError' => __('Connexion impossible, merci de vérifier vos identifiants'),
			'authenticate' => [
				'Form' => [
					'fields' => ["username"=>"email","password"=>"pwd"],
					'userModel'=>'Utilisateurs'
				]
			],
			'storage' => 'Session'
		]);

		if($this->request->action === 'recherche' || $this->request->action === 'landing' || $this->request->action === 'contact'){
			$this->loadComponent('Csrf');
		}

    }

	public function beforeFilter(Event $event)
    {
      	parent::beforeFilter($event);
		$session = $this->request->session();
        $gestionnaire = $session->read('Gestionnaire.info');
		if ($session->check("Gestionnaire.info")) {
			$this->set('confirm_accepter','reservation');
			$this->Auth->allow(['pagesavoiemontblanc','sendmailtobecontact','checkEmailUnique','getvillefromvillage','addnewsteps','add','checkAppartementUnique','pagesavoie','setcenrlatlong','index','rest','view','getimage','detail','prop','recherche','recherchebytype','redirectionNewView','getresidence','service','sitemap','wsdl','edit','edit2','photo','contact','landing','liste','previsualiser','viewprev', 'getservicesmap', 'ratingadd', 'inscriptionnewslettre','valdlanding','depotannonce','getcontratinfo','lesarcslanding','montchavinlescocheslanding', 'setchoixstationsession', 'station', 'massif', 'getdetailoffice', 'galery', 'webcam', 'explicationpub', 'residence', 'uploadinventairelocataire']);
		} else {
			$this->Auth->allow(['pagesavoiemontblanc','sendmailtobecontact','checkEmailUnique','getvillefromvillage','addnewsteps','add','checkAppartementUnique','pagesavoie','setcenrlatlong','index','rest','view','getimage','detail','prop','recherche','recherchebytype','redirectionNewView','getresidence','service','sitemap','wsdl','contact','landing','liste','previsualiser','viewprev', 'getservicesmap', 'ratingadd', 'inscriptionnewslettre','valdlanding','depotannonce','getcontratinfo','lesarcslanding','montchavinlescocheslanding', 'setchoixstationsession', 'station', 'massif', 'getdetailoffice', 'galery', 'webcam', 'explicationpub', 'residence', 'uploadinventairelocataire', 'activatedpromotions']);
		}
		$this->loadModel("Lieugeos");
		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3, "etat = 1"],"order"=>"Lieugeos.name"]);
		$ar[]="Destination";
		foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		$this->set("l_lieugeos",$ar);
		// Vérifier si locataire a une réservation dans panier
		$affiche_alert = "non";
		$station_annonce = "fr";
		if(!empty($session->read('Auth.User.nature'))){
			if($session->read('Auth.User.nature') == "CLT"){
				$this->loadModel("Reservations");
				$reservation = $this->Reservations->find()->contain(['Annonces'=>['Lieugeos','Villages']])->where(['Reservations.utilisateur_id' => $session->read('Auth.User.id'), 'Reservations.statut = 0', 'Reservations.quote_id <> 0', 'Reservations.increment_id = 0']);
				if($resv = $reservation->first()){
					$affiche_alert = "oui";
					if($resv['annonce']['village']['input_boutique'] != "") $station_annonce = $resv['annonce']['village']['input_boutique'];
				}
			}
		}
		$this->set("affiche_alert",$affiche_alert);
		$this->set("station_annonce",$station_annonce);

		$session->write("main_station",0);
	}

	function service() {
		$this->viewBuilder()->layout(false);
		$this->render(false);		ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache
		ini_set("default_socket_timeout", 200);
		$server = new SoapServer('https://www.alpissime.com/annonces/wsdl');
		require_once(ROOT . DS . 'vendor' . DS .'classann'.DS.'panier.php');
    $pan = new Panier();
		$server->setClass('Panier');
		$server->handle();
	}

	function wsdl() {
		$this->viewBuilder()->layout(false);
		$this->RequestHandler->renderAs($this, 'xml');
	}

	function rest(){
		require_once(ROOT . DS . 'vendor' . DS .'classann'.DS.'panier.php');
    $pan = new Panier();
		$station="";
		$nbr="";
		$deb="";
		$fin="";
		$ref="";
		if(!empty($this->request->query['station']))
			$station =$this->request->query['station'];
		if(!empty($this->request->query['nbr']))
			$nbr =$this->request->query['nbr'];
		if(!empty($this->request->query['deb']))
			$deb =$this->request->query['deb'];
		if(!empty($this->request->query['fin']))
			$fin =$this->request->query['fin'];
		if(!empty($this->request->query['ref']))
			$ref =$this->request->query['ref'];
		// $this->set('a_json',$pan->recherche_service($station,$nbr,$deb,$fin,$ref));
		// $this->RequestHandler->renderAs($this, 'json');
		echo json_encode($pan->recherche_service($station,$nbr,$deb,$fin,$ref));
  	exit();
	}
	/**
	 * 
	 */
	public function sendmailtobecontact()
	{
		$this->loadModel("Registres");
		/**** Send Mail ****/
		$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
		$mail=$mails->first();
		$messagemail = $this->request->data['nomprenom']." demande à être rappelé.<br>Numéro de portable : ".$this->request->data['portable'];
		// #####################################################
		$email = new Email('production');
			$email->to('hello@alpissime.com')
				->from([$mail->val=>FROM_MAIL])
				->subject('Demande à être rappelé')
				->emailFormat('html')
				->send($messagemail);
		// #####################################################
	}
		/**
			 * Landing method
			 *
			 * @return \Cake\Network\Response|null
			 */
	public function landing(){   
		/*** FIN Nouveau code ***/

		$this->loadModel("Residences");
		$resid = $this->Residences->find('all');
		foreach ($resid as $value) {
			$residence[$value->id] = $value->name;
		}
		$this->set('residence', $residence);

		$this->viewBuilder()->layout('landing');
		$session = $this->request->session();
		$session->delete('Reseservation.key');

		if($session->check("Inscription.utilisateur")){
			$this->set('confirm_res','reservation');
			$session->delete("Inscription.utilisateur");
		}

		if($session->read('main_station') != 0)
			$ann=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50",'Annonces.lieugeo_id'=>$session->read('main_station')],'contain' => ['Lieugeos','Villages'],"order"=>"Annonces.updated_at desc","limit"=>16])->toArray();
		else
			$ann=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50"],'contain' => ['Lieugeos','Villages'],"order"=>"Annonces.updated_at desc","limit"=>16])->toArray();
		
		$this->set('annonces', $ann);
                $this->loadModel("Feedbacks");
                /*** MINIMUM PRIX ANNONCES ***/
                $minprixannonce = [];
                $noteglobalmoytab = [];
                $condi = ["Annonces.statut"=>"50"];
                foreach ($ann as $key ) {
                        $minprixannonce[$key->id]['prixmin'] = '';
                        if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($key->id, '', '', $condi);
                        else $tousperiodes = $this->Dispos->find('all', array(
                                        'conditions' => array('Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0',$condiPrixMin),
                                        'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

                        foreach ($tousperiodes as $value) {
                                if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at)))
                                {
                                        if($value->prix_jour == 0){
                                                $nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
                                                $prix_jour = $value->prix/$nbrDiff;
                                        }else{
                                                $prix_jour = $value->prix_jour;
                                        }

                                        if($value->promo_yn == 0){
                                                if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
                                                        $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
                                                }
                                        }else{
                                                if($value->promo_jour == 0){
                                                        $nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
                                                        $promo_jour = $value->promo_px/$nbrDiff;
                                                }else{
                                                        $promo_jour = $value->promo_jour;
                                                }
                                                if($promo_jour < $prix_jour){
                                                        if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
                                                }else{
                                                        if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
                                                }
                                        }
                                }
                         } /** Fin parcour periodes **/
                    //Liste Feedbacks
                    $listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
                    // Notes Globales
                    $notecara = [];
                    foreach ($listerating as $keyval) {
                        foreach ($keyval['ratings'] as $valueval) {
                                $notecara[$valueval->caracteristique] += $valueval->note;
                        }
                    }

					if($listerating->count() != 0){
						$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
						$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);
					}else{
						$noteglobalmoy = 0;
						$noteglobalmoytab[$key->id] = 0;
					}
                    

				} /** Fin parcour annonces **/

                $this->set('noteglobalmoytab', $noteglobalmoytab);
                $this->set('minprixannonce',$minprixannonce);

		$a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
    $this->set("l_distances",$a_distance);

    $images=$this->Images->find()->where(['Images.visible = 1']);
		$photos=$this->Photos->find("all",["order"=>"Photos.numero"]);
    foreach($photos as $e) $ar_ph[$e->annonce_id][]=$e->numero;
		$this->set("photos",$ar_ph);

    $enrs = $this->Lieugeos->find("all",["conditions"=>["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"],"order"=>"Lieugeos.name"]);
		$ar[]="";
		$ara2=[];
    foreach($enrs as $enr){
			$ar[$enr->id]=$enr->name;
			if($enr->query != NULL || $enr->query != "")	$ara2[$enr->id]=$enr->query;
		}  
		//$this->set("l_lieugeos",$ar);
		$this->set("l_lieugeos_query",$ara2);

		$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
    $this->set("l_nombre_personnes",$a_personne);

		$this->loadModel("Registres");
		$this->set("title_for_layout","Alpissime : Location vacances aux Arcs - Bourg Saint Maurice");
		$this->set("description","Location les Arcs - Plus de 400 appartements en location de particuliers à particuliers stations les arcs 1600, les arcs 1800, les arcs 1950, les arcs 2000, bourg saint maurice");
		$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('ACCUEIL')]);
		$this->set("registres",$registre);
	$this->set("images",$images);
	

		$this->loadModel("Massif");
		$stations = $this->Massif->find("all")->contain('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id", "Lieugeos.image"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->matching('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id", "Lieugeos.image"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->group(['Massif.id'])->order(['Massif.nom']);
		$this->set("stations",$stations);

		
		$massifStat = [];
		foreach ($stations as $valueStation) {
			$massifStat[] = $valueStation->nom;
		}
		$this->set("listeMassifStation",$massifStat);
	
		
		$massifs = $this->Massif->find('translations', ['locales' => [$session->read('Config.language')]]);
		$this->set("massifs",$massifs);

		$this->loadModel("Partenaires");
		$listePart = $this->Partenaires->find("all")->where(['image <> ""', 'aAfficher = "OUI"']);
		$this->set("listePart",$listePart);

		$this->loadModel("Villages");
		$listevillageann = $this->Villages->find()->join([
			'Annonces' => [
				'table' => 'annonces',
				'type' => 'inner',
				'conditions' => ['Villages.id = Annonces.village', "Annonces.statut = 50"],
			]
		])->group(['Villages.id'])->order(['Villages.name']);
		$this->set("listevillageann",$listevillageann);

		$this->loadModel("Media");
		$mediaheader = $this->Media->find('translations', ['locales' => [$session->read('Config.language')]])->where(['name_key = "header_bloc_information"']);
		$this->set("mediaheader",$mediaheader->first());

		$mediabandeau = $this->Media->find('translations', ['locales' => [$session->read('Config.language')]])->where(['name_key = "bandeau_conciergerie"']);
		$this->set("mediabandeau",$mediabandeau->first());
	}
	/**
	 * 
	 */
	public function massif($nom)
	{
		$session = $this->request->session();  
		$this->loadModel("Massif");
		if($session->read('Config.language') == "fr_FR"){
			$massif = $this->Massif->find('translations', ['locales' => [$session->read('Config.language')]])->where(['nom_url' => $nom]);
			if($massif->first()) $massif = $massif->first();
			else $massif = "";
		}else{
			$this->loadModel("MassifI18n");	
			$massifI18n = $this->MassifI18n->find("all")->where(['content' => $nom]);
			if($massifI18n = $massifI18n->first()){				
				$massif = $this->Massif->find('translations', ['locales' => [$session->read('Config.language')]])->where(['id' => $massifI18n->foreign_key]);
				if($massif->first()) $massif = $massif->first();
				else $massif = "";
			}else{
				$massif = $this->Massif->find('translations', ['locales' => [$session->read('Config.language')]])->where(['nom_url' => $nom]);
				if($massif->first()) $massif = $massif->first();
				else $massif = "";
			}
		}
		
		$this->set("massif",$massif);

		$stations = $this->Massif->find("all")->contain('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id", "Lieugeos.image"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->matching('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id", "Lieugeos.image"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->group(['Massif.id'])->order(['Massif.nom']);
		$this->set("listeStations",$stations);

		if($massif != ""){
			$this->loadModel("Lieugeos");
			$listeStation = $this->Lieugeos->find('translations', ['locales' => [$session->read('Config.language')]])->where(['massif_id' => $massif->id, "Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
			$this->set("stations",$listeStation);
			$this->paginate = ['limit' => 5];
			$this->set("listeStation",$this->paginate($listeStation));

			$listeAnnonce = [];
			$minprixannonceStat = [];
			$noteglobalmoytabStat = [];
			$listePartStat = [];
			$this->loadModel("Dispos");
			$this->loadModel("Feedbacks");			
			foreach ($listeStation as $station) {
				$ann=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50", "Annonces.lieugeo_id" => $station->id],'contain' => ['Lieugeos','Villages'],"order"=>"Annonces.updated_at desc","limit"=>4])->toArray();
				$listeAnnonce[$station->id] = $ann;

				/*** MINIMUM PRIX ANNONCES ***/
				$minprixannonce = [];
				$noteglobalmoytab = [];
				$condi = ["Annonces.statut"=>"50"];
				foreach ($ann as $key ) {
					$minprixannonce[$key->id]['prixmin'] = '';
					if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($key->id, '', '', $condi);
					else $tousperiodes = $this->Dispos->find('all', array(
									'conditions' => array('Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0',$condiPrixMin),
									'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

					foreach ($tousperiodes as $value) {
						if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at))){
							if($value->prix_jour == 0){
								$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
								$prix_jour = $value->prix/$nbrDiff;
							}else{
								$prix_jour = $value->prix_jour;
							}

							if($value->promo_yn == 0){
								if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
										$minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
								}
							}else{
								if($value->promo_jour == 0){
										$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
										$promo_jour = $value->promo_px/$nbrDiff;
								}else{
										$promo_jour = $value->promo_jour;
								}
								if($promo_jour < $prix_jour){
										if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
								}else{
										if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
								}
							}
						}
					} /** Fin parcour periodes **/
					//Liste Feedbacks
					$listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
					// Notes Globales
					$notecara = [];
					foreach ($listerating as $keyval) {
						foreach ($keyval['ratings'] as $valueval) {
								$notecara[$valueval->caracteristique] += $valueval->note;
						}
					}

					if($listerating->count() != 0){
						$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
						$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);
					}else{
						$noteglobalmoy = 0;
						$noteglobalmoytab[$key->id] = 0;
					}
					

				} /** Fin parcour annonces **/

				$minprixannonceStat[$station->id] = $minprixannonce;
				$noteglobalmoytabStat[$station->id] = $noteglobalmoytab;
				
				// Liste partenaires
				$this->loadModel("Partenaires");
				$listePart = $this->Partenaires->find("all")->where(["(lieugeo_id LIKE '$station->id;%' OR lieugeo_id LIKE '%;$station->id;%')"]);
				$listePartStat[] = $listePart;
				
			}
			$this->set("listeAnnonce",$listeAnnonce);
			$this->set('noteglobalmoytab', $noteglobalmoytabStat);
			$this->set('minprixannonce', $minprixannonceStat);
			$this->set("listePart",$listePartStat);

			$this->loadModel("Photos");
			$photos=$this->Photos->find("all")->order(['Photos.numero' => 'ASC']);
			foreach($photos as $e)  $ar_ph[$e->annonce_id][]=$e->numero;
			$this->set("photosCont",$ar_ph);

			$residencesmarqueurs = [];
			$this->loadModel("Residences");
			$residences=$this->Residences->find('all')->where(["bibliotheque_id = 1 OR bibliotheque_id = 7"]);
			foreach ($residences as $value) {
                                $residencesmarqueurs[$value->id]["lat"] = $value->latitude;
                                $residencesmarqueurs[$value->id]["lon"] = $value->longitude;
                                $residencesmarqueurs[$value->id]["title"] = $value->name;
			}
			$this->set('residenceAnnonce', $residencesmarqueurs);
		}
		

	}
	/**
	 * 
	 */
	public function residence($nom)
	{
		$this->loadModel("Residences");
		$residence=$this->Residences->find('all')->contain(['Villages'=>'Lieugeos'])->where(["bibliotheque_id = 1", "name_url" => $nom])->first();
		if($residence) $this->set("residence_info", $residence);
		else $this->set("residence_info", "");

		$listeAnnonce = "";
		$minprixannonceStat = "";
		$noteglobalmoytabStat = "";
		$this->loadModel("Dispos");
		$this->loadModel("Feedbacks");			
		$ann=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50", "Annonces.batiment" => $residence->id],'contain' => ['Lieugeos','Villages'],"order"=>"Annonces.updated_at desc"]);
		$listeAnnonce = $ann;

		/*** MINIMUM PRIX ANNONCES ***/
		$minprixannonce = [];
		$noteglobalmoytab = [];
		$condi = ["Annonces.statut"=>"50"];
		foreach ($ann as $key ) {
			$minprixannonce[$key->id]['prixmin'] = '';
			if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($key->id, '', '', $condi);
			else $tousperiodes = $this->Dispos->find('all', array(
							'conditions' => array('Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0',$condiPrixMin),
							'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

			foreach ($tousperiodes as $value) {
				if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at))){
					if($value->prix_jour == 0){
						$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
						$prix_jour = $value->prix/$nbrDiff;
					}else{
						$prix_jour = $value->prix_jour;
					}

					if($value->promo_yn == 0){
						if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
								$minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}else{
						if($value->promo_jour == 0){
								$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
								$promo_jour = $value->promo_px/$nbrDiff;
						}else{
								$promo_jour = $value->promo_jour;
						}
						if($promo_jour < $prix_jour){
								if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
						}else{
								if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}
				}
			} /** Fin parcour periodes **/
			//Liste Feedbacks
			$listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
			// Notes Globales
			$notecara = [];
			foreach ($listerating as $keyval) {
				foreach ($keyval['ratings'] as $valueval) {
						$notecara[$valueval->caracteristique] += $valueval->note;
				}
			}

			if($listerating->count() != 0){
				$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
				$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);
			}else{
				$noteglobalmoy = 0;
				$noteglobalmoytab[$key->id] = 0;
			}

		} /** Fin parcour annonces **/

		$minprixannonceStat = $minprixannonce;
		$noteglobalmoytabStat = $noteglobalmoytab;
			
		$this->set("listeAnnonce",$listeAnnonce);
		$this->set('noteglobalmoytab', $noteglobalmoytabStat);
		$this->set('minprixannonce', $minprixannonceStat);

		if($residence->image_header != "") $this->render('/Annonces/residence-avec-header');
		else $this->render('/Annonces/residence-sans-header');
	}
	/**
	 * 
	 */
	public function station($nom = null)
	{
		$this->loadModel("Residences");
		$resid = $this->Residences->find('all');
		foreach ($resid as $value) {
			$residence[$value->id] = $value->name;
		}
		$this->set('residence', $residence);

		$session = $this->request->session();
		$session->delete('Reseservation.key');

		if($session->check("Inscription.utilisateur")){
			$this->set('confirm_res','reservation');
			$session->delete("Inscription.utilisateur");
		}

		$station = $this->Lieugeos->find("translations")->contain(['Massif', 'Domaine'])->where(['Lieugeos.nom_url' => $nom]);
		if(!$station->first()){
			$nom_station = str_replace("-", " ", $nom);
			$station = $this->Lieugeos->find("all")->contain(['Massif', 'Domaine'])->where(['Lieugeos.name' => $nom_station]);
			if($station = $station->first()) return $this->redirect(['action' => 'station',$station->nom_url]);
			else return $this->redirect(['action' => 'landing']);
		}		
		$this->set('station', $station->first());
		$this->set('nom_get', $nom);

		$station = $station->first();
		$this->loadModel("Stations");
		$date_station = $this->Stations->find()->where(["station_id" =>$station->id]);
		$this->set('date_station', $date_station);

		$this->loadModel("Villages");
		$this->loadModel("Residences");
		$listevillages = $this->Villages->find("all")->where(['lieugeo_id' => $station->id]);		

		
		$allannonceswithperiod = $this->Annonces->getAllAnnoncesWithPeriod($station->id)->limit(4);
		if($allannonceswithperiod->count() < 4){
			$allannonces = $this->Annonces->getAllAnnonces($station->id);
			if($allannonces->count() >= 4){
				$countlimit = 4-$allannonceswithperiod->count();
				$allannonceswithoutperiod = $this->Annonces->getAllAnnoncesWithoutPeriod($station->id)->limit($countlimit);
				$allannonceswithperiod->union($allannonceswithoutperiod);
			}
		}
		$this->set('annonces', $allannonceswithperiod);

		
		$allannonceswithperiodapprt = $this->Annonces->getAllAnnoncesWithPeriod($station->id, "APP")->limit(4);
		if($allannonceswithperiodapprt->count() < 4){
			$allannoncesapprt = $this->Annonces->getAllAnnonces($station->id, "APP");
			if($allannoncesapprt->count() >= 4){
				$countlimitapprt = 4-$allannonceswithperiodapprt->count();
				$allannonceswithoutperiodapprt = $this->Annonces->getAllAnnoncesWithoutPeriod($station->id, "APP")->limit($countlimitapprt);
				$allannonceswithperiodapprt->union($allannonceswithoutperiodapprt);
			}
		}		
		$this->set('annoncesappartement', $allannonceswithperiodapprt);

		$allannonceswithperiodchalet = $this->Annonces->getAllAnnoncesWithPeriod($station->id, "CHA")->limit(4);
		if($allannonceswithperiodchalet->count() < 4){
			$allannonceschalet = $this->Annonces->getAllAnnonces($station->id, "CHA");
			if($allannonceschalet->count() >= 4){
				$countlimitchalet = 4-$allannonceswithperiodchalet->count();
				$allannonceswithoutperiodchalet = $this->Annonces->getAllAnnoncesWithoutPeriod($station->id, "CHA")->limit($countlimitchalet);
				$allannonceswithperiodchalet->union($allannonceswithoutperiodchalet);
			}
		}	
		$this->set('annonceschalet', $allannonceswithperiodchalet);

		$annvillage = [];
		$listevillagestab = [];
		$listeresidencestab = [];
		foreach ($listevillages as $key => $value) {
			$listevill = $this->Annonces->getAllAnnoncesWithPeriod($station->id, NULL, $value->id)->limit(4);
			if($listevill->count() < 4){
				$allannonceschalet = $this->Annonces->getAllAnnonces($station->id, NULL, $value->id);
				if($allannonceschalet->count() >= 4){
					$countlimitchalet = 4-$listevill->count();
					$allannonceswithoutperiodchalet = $this->Annonces->getAllAnnoncesWithoutPeriod($station->id, NULL, $value->id)->limit($countlimitchalet);
					$listevill->union($allannonceswithoutperiodchalet);
				}
			}
			$annvillage[$value->id] = $listevill;
			if($listevill->count() > 0){
				$listevillagestab[$listevill->count()][] = $value;
				$listeresidences = $this->Residences->find()->where(['id_village = '.$value->id.' AND bibliotheque_id = 1'])->order(['Residences.name ASC']);
				foreach ($listeresidences as $resid) {
					$annonce_par_residence = $this->Annonces->find("all")->where(["statut = 50", "batiment"=>$resid->id]);
					if($annonce_par_residence->count() > 0) $listeresidencestab[$value->id][] = $resid;
				}
			} 
		}
		// print_r($listevillagestab);
		// exit;
		$this->set('annvillage', $annvillage);
		$this->set('listevillages', $listevillagestab);
		$this->set('listeresidences', $listeresidencestab);

		$villagetrois = [];
		foreach ($listevillages as $valuevillage) {
			$villagetrois[] = $valuevillage;
		}
		$this->set('villagetrois', $villagetrois);

		$this->loadModel("Feedbacks");
		/*** MINIMUM PRIX ANNONCES ***/
		$minprixannonce = [];
		$noteglobalmoytab = [];
		$condi = ["Annonces.statut"=>"50"];
		$touteann = $this->Annonces->find('all')->contain(['Lieugeos', 'Villages'])->where(["Annonces.statut"=>"50"]);
		foreach ($touteann as $key ) {
			$minprixannonce[$key->id]['prixmin'] = '';
			// if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($key->id, '', '', $condi);
			// else 
			$tousperiodes = $this->Dispos->find('all', array(
							'conditions' => array('Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0'),
							'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

			foreach ($tousperiodes as $value) {
				if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at))){
					if($value->prix_jour == 0){
						$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
						$prix_jour = $value->prix/$nbrDiff;
					}else{
						$prix_jour = $value->prix_jour;
					}

					if($value->promo_yn == 0){
						if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
								$minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}else{
						if($value->promo_jour == 0){
								$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
								$promo_jour = $value->promo_px/$nbrDiff;
						}else{
								$promo_jour = $value->promo_jour;
						}
						if($promo_jour < $prix_jour){
								if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
						}else{
								if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}
				}
			} /** Fin parcour periodes **/
			//Liste Feedbacks
			$listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
			// Notes Globales
			$notecara = [];
			foreach ($listerating as $keyval) {
				foreach ($keyval['ratings'] as $valueval) {
						$notecara[$valueval->caracteristique] += $valueval->note;
				}
			}

			if($listerating->count() != 0){
				$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
				$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);
			}else{
				$noteglobalmoy = 0;
				$noteglobalmoytab[$key->id] = 0;
			}
			

		} /** Fin parcour annonces **/

		$this->set('noteglobalmoytab', $noteglobalmoytab);
		$this->set('minprixannonce',$minprixannonce);

		$a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
    	$this->set("l_distances",$a_distance);

    	$images=$this->Images->find()->where(['Images.visible = 1']);
		$photos=$this->Photos->find("all",["order"=>"Photos.numero"]);
		foreach($photos as $e) $ar_ph[$e->annonce_id][]=$e->numero;
		$this->set("photos",$ar_ph);

		$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
		$this->set("l_nombre_personnes",$a_personne);

		$this->loadModel("Registres");
		$this->set("title_for_layout","Alpissime : Location vacances aux Arcs - Bourg Saint Maurice");
		$this->set("description","Location les Arcs - Plus de 400 appartements en location de particuliers à particuliers stations les arcs 1600, les arcs 1800, les arcs 1950, les arcs 2000, bourg saint maurice");
		$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('ACCUEIL')]);
		$this->set("registres",$registre);
		$this->set("images",$images);
		
		$this->loadModel("Massif");
		$listeStations = $this->Massif->find("all")->contain('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->matching('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->group(['Massif.id'])->order(['Massif.nom']);
		$this->set("listeStations",$listeStations);
		
		$massifs = $this->Massif->find("all");
		$this->set("massifs",$massifs);

		$this->loadModel("Partenaires");
		$listePart = $this->Partenaires->find("all")->where(["(lieugeo_id LIKE '$station->id;%' OR lieugeo_id LIKE '%;$station->id;%')"]);
		$this->set("listePart",$listePart);

		$this->loadModel("RemonteMecanique");
		if($station->RM_id != 0) $remonteMecanique = $this->RemonteMecanique->get($station->RM_id);
		else $remonteMecanique = null;
		$this->set("remonteMecanique",$remonteMecanique);

		$this->loadModel("villages");
		$villages = $this->villages->find("list", [
			'keyField' => 'name',
			'valueField' => 'id'
		])->where(['lieugeo_id' => $station->id]);
		
		$this->loadModel("OfficeTourisme");
		if(!empty($villages->toArray())) $offices = $this->OfficeTourisme->find("all")->where(['village_id IN '=> $villages->toArray()]);
		else $offices = null;
		$this->set("offices",$offices);
	}
	/**
	 * 
	 */
	public function galery($nom = null)
	{
		$this->viewBuilder()->layout(false);

		$station = $this->Lieugeos->find("all")->contain(['Massif', 'Domaine'])->where(['Lieugeos.nom_url' => $nom]);
		// if(!$station->first()){
		// 	$nom_station = str_replace("-", " ", $nom);
		// 	$station = $this->Lieugeos->find("all")->contain(['Massif', 'Domaine'])->where(['Lieugeos.name' => $nom_station]);
		// }		
		$this->set('station', $station->first());
	}
	/**
	 * 
	 */
	public function webcam($nom = null)
	{
		$this->viewBuilder()->layout(false);

		$station = $this->Lieugeos->find("all")->contain(['Massif', 'Domaine'])->where(['Lieugeos.nom_url' => $nom]);
		// if(!$station->first()){
		// 	$nom_station = str_replace("-", " ", $nom);
		// 	$station = $this->Lieugeos->find("all")->contain(['Massif', 'Domaine'])->where(['Lieugeos.name' => $nom_station]);
		// }	
		$this->set('station', $station->first());

		$station = $station->first();
		$this->loadModel('WebcamLieugeos');
		$listeWebcam = $this->WebcamLieugeos->find()->where(['lieugeo_id' => $station->id]);
		$this->set('listeWebcam', $listeWebcam);
	}
	/**
	 * 
	 */
	public function explicationpub()
	{
		$this->viewBuilder()->layout("default");

		// Liste Annonces
		$ann=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50"],'contain' => ['Lieugeos','Villages'],"order"=>"Annonces.updated_at desc","limit"=>16])->toArray();
		$this->set('annonces', $ann);
		
		// Liste Photos
		$photos=$this->Photos->find("all",["order"=>"Photos.numero"]);
		foreach($photos as $e) $ar_ph[$e->annonce_id][]=$e->numero;
		$this->set("photos",$ar_ph);

		// Liste residence
		$this->loadModel("Residences");
		$resid = $this->Residences->find('all');
		foreach ($resid as $value) {
			$residence[$value->id] = $value->name;
		}
		$this->set('residence', $residence);

		// Liste minprixannonce // Liste noteglobalmoytab
		$this->loadModel("Feedbacks");
		/*** MINIMUM PRIX ANNONCES ***/
		$minprixannonce = [];
		$noteglobalmoytab = [];
		$condi = ["Annonces.statut"=>"50"];
		foreach ($ann as $key ) {
			$minprixannonce[$key->id]['prixmin'] = '';
			if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($key->id, '', '', $condi);
			else $tousperiodes = $this->Dispos->find('all', array(
							'conditions' => array('Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0',$condiPrixMin),
							'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

			foreach ($tousperiodes as $value) {
				if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at)))
				{
					if($value->prix_jour == 0){
						$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
						$prix_jour = $value->prix/$nbrDiff;
					}else{
						$prix_jour = $value->prix_jour;
					}

					if($value->promo_yn == 0){
						if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
							$minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}else{
						if($value->promo_jour == 0){
							$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
							$promo_jour = $value->promo_px/$nbrDiff;
						}else{
							$promo_jour = $value->promo_jour;
						}
						if($promo_jour < $prix_jour){
							if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
						}else{
							if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}
				}
			} /** Fin parcour periodes **/
			//Liste Feedbacks
			$listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
			// Notes Globales
			$notecara = [];
			foreach ($listerating as $keyval) {
				foreach ($keyval['ratings'] as $valueval) {
						$notecara[$valueval->caracteristique] += $valueval->note;
				}
			}

			if($listerating->count() != 0){
				$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
				$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);
			}else{
				$noteglobalmoy = 0;
				$noteglobalmoytab[$key->id] = 0;
			}                 

		} /** Fin parcour annonces **/
		$this->set('noteglobalmoytab', $noteglobalmoytab);
		$this->set('minprixannonce',$minprixannonce);

		// Liste stations
		$this->loadModel("Massif");
		$stations = $this->Massif->find("all")->contain('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id", "Lieugeos.image", "Lieugeos.nom_url"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->matching('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id", "Lieugeos.image", "Lieugeos.nom_url"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->group(['Massif.id'])->order(['Massif.nom']);
		$this->set("stations",$stations);

		$this->loadModel("Media");
		$session = $this->request->session();
		$mediasejour = $this->Media->find('translations', ['locales' => [$session->read('Config.language')]])->where(['name_key = "sejour_montagne_paiement_4_fois_sans_frais"']);
		$this->set("mediasejour",$mediasejour->first());
	}
	/**
	 * 
	 */
    public function getdetailoffice()
    {
		$this->RequestHandler->renderAs($this, 'json'/*or xml*/); 
		$this->loadModel('OfficeTourisme');
        $office = $this->OfficeTourisme->get($this->request->data['office_id']);
        $this->set('office',$office);
        $this->loadModel('Villages');
        $village = $this->Villages->find("all")->contain(['Frvilles'])->where(['Villages.id' => $office->village_id])->first();
        $this->set('ville',$village['frville']['name']);
    }
	/**
	 * 
	 */
	public function valdlanding()
	{
		$this->redirect(['action' => 'station','val-d-allos']);

		$this->loadModel("Residences");
		$resid = $this->Residences->find('all');
		foreach ($resid as $value) {
			$residence[$value->id] = $value->name;
		}
		$this->set('residence', $residence);

		$this->viewBuilder()->layout(false);
		$session = $this->request->session();
		$session->delete('Reseservation.key');

		if($session->check("Inscription.utilisateur")){
			$this->set('confirm_res','reservation');
			$session->delete("Inscription.utilisateur");
		}

		$ann=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50", "lieugeo_id IN (15, 16, 17)"],'contain' => ['Lieugeos'],"order"=>"Annonces.updated_at desc","limit"=>8])->toArray();
		$this->set('annonces', $ann);
		$this->loadModel("Feedbacks");
		/*** MINIMUM PRIX ANNONCES ***/
		$minprixannonce = [];
		$noteglobalmoytab = [];
		$condi = ["Annonces.statut"=>"50"];
		foreach ($ann as $key ) {
			$minprixannonce[$key->id]['prixmin'] = '';
			if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($key->id, '', '', $condi);
			else $tousperiodes = $this->Dispos->find('all', array(
							'conditions' => array('Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0',$condiPrixMin),
							'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

			foreach ($tousperiodes as $value) {
				if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at))){
					if($value->prix_jour == 0){
						$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
						$prix_jour = $value->prix/$nbrDiff;
					}else{
						$prix_jour = $value->prix_jour;
					}

					if($value->promo_yn == 0){
						if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
								$minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}else{
						if($value->promo_jour == 0){
								$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
								$promo_jour = $value->promo_px/$nbrDiff;
						}else{
								$promo_jour = $value->promo_jour;
						}
						if($promo_jour < $prix_jour){
								if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
						}else{
								if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}
				}
			} /** Fin parcour periodes **/
			//Liste Feedbacks
			$listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
			// Notes Globales
			$notecara = [];
			foreach ($listerating as $keyval) {
				foreach ($keyval['ratings'] as $valueval) {
						$notecara[$valueval->caracteristique] += $valueval->note;
				}
			}

			if($listerating->count() != 0){
				$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
				$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);
			}else{
				$noteglobalmoy = 0;
				$noteglobalmoytab[$key->id] = 0;
			}
			

		} /** Fin parcour annonces **/

		$this->set('noteglobalmoytab', $noteglobalmoytab);
		$this->set('minprixannonce',$minprixannonce);

		$a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
    	$this->set("l_distances",$a_distance);

    	$images=$this->Images->find()->where(['Images.visible = 1']);
		$photos=$this->Photos->find("all",["order"=>"Photos.numero"]);
		foreach($photos as $e) $ar_ph[$e->annonce_id][]=$e->numero;
		$this->set("photos",$ar_ph);

    	$enrs = $this->Lieugeos->find("all",["conditions"=>["Lieugeos.niveau >= 3", "id IN (15, 16, 17)"],"order"=>"Lieugeos.name"]);
		$ar[]="";
		$ara2[]="";
    	foreach($enrs as $enr){
			$ar[$enr->id]=$enr->name;
			$ara2[$enr->id]=$enr->query;
		}  
		$this->set("l_lieugeos",$ar);
		$this->set("l_lieugeos_query",$ara2);

		$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
		$this->set("l_nombre_personnes",$a_personne);

		$this->loadModel("Registres");
		$this->set("title_for_layout","Alpissime : Location vacances aux Arcs - Bourg Saint Maurice");
		$this->set("description","Location les Arcs - Plus de 400 appartements en location de particuliers à particuliers stations les arcs 1600, les arcs 1800, les arcs 1950, les arcs 2000, bourg saint maurice");
		$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('ACCUEIL')]);
		$this->set("registres",$registre);
    	$this->set("images",$images);
	}
	/**
	 * 
	 */
	public function lesarcslanding()
	{
		$this->redirect(['action' => 'station','les-arcs']);

		$this->loadModel("Residences");
		$resid = $this->Residences->find('all');
		foreach ($resid as $value) {
			$residence[$value->id] = $value->name;
		}
		$this->set('residence', $residence);

		$this->viewBuilder()->layout(false);
		$session = $this->request->session();
		$session->delete('Reseservation.key');

		if($session->check("Inscription.utilisateur")){
			$this->set('confirm_res','reservation');
			$session->delete("Inscription.utilisateur");
		}

		$ann=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50", "lieugeo_id IN (1, 2, 3, 4, 8, 9, 10, 11)"],'contain' => ['Lieugeos'],"order"=>"Annonces.updated_at desc","limit"=>8])->toArray();
		$this->set('annonces', $ann);
		$this->loadModel("Feedbacks");
		/*** MINIMUM PRIX ANNONCES ***/
		$minprixannonce = [];
		$noteglobalmoytab = [];
		$condi = ["Annonces.statut"=>"50"];
		foreach ($ann as $key ) {
			$minprixannonce[$key->id]['prixmin'] = '';
			if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($key->id, '', '', $condi);
			else $tousperiodes = $this->Dispos->find('all', array(
							'conditions' => array('Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0',$condiPrixMin),
							'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

			foreach ($tousperiodes as $value) {
				if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at))){
					if($value->prix_jour == 0){
						$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
						$prix_jour = $value->prix/$nbrDiff;
					}else{
						$prix_jour = $value->prix_jour;
					}

					if($value->promo_yn == 0){
						if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
								$minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}else{
						if($value->promo_jour == 0){
								$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
								$promo_jour = $value->promo_px/$nbrDiff;
						}else{
								$promo_jour = $value->promo_jour;
						}
						if($promo_jour < $prix_jour){
								if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
						}else{
								if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}
				}
			} /** Fin parcour periodes **/
			//Liste Feedbacks
			$listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
			// Notes Globales
			$notecara = [];
			foreach ($listerating as $keyval) {
				foreach ($keyval['ratings'] as $valueval) {
						$notecara[$valueval->caracteristique] += $valueval->note;
				}
			}

			if($listerating->count() != 0){
				$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
				$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);
			}else{
				$noteglobalmoy = 0;
				$noteglobalmoytab[$key->id] = 0;
			}
			

		} /** Fin parcour annonces **/

		$this->set('noteglobalmoytab', $noteglobalmoytab);
		$this->set('minprixannonce',$minprixannonce);

		$a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
    	$this->set("l_distances",$a_distance);

    	$images=$this->Images->find()->where(['Images.visible = 1']);
		$photos=$this->Photos->find("all",["order"=>"Photos.numero"]);
		foreach($photos as $e) $ar_ph[$e->annonce_id][]=$e->numero;
		$this->set("photos",$ar_ph);

    	$enrs = $this->Lieugeos->find("all",["conditions"=>["Lieugeos.niveau >= 3", "id IN (1, 2, 3, 4, 8, 9, 10, 11)"],"order"=>"Lieugeos.name"]);
		$ar[]="";
		$ara2[]="";
    	foreach($enrs as $enr){
			$ar[$enr->id]=$enr->name;
			$ara2[$enr->id]=$enr->query;
		}  
		$this->set("l_lieugeos",$ar);
		$this->set("l_lieugeos_query",$ara2);

		$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
		$this->set("l_nombre_personnes",$a_personne);

		$this->loadModel("Registres");
		$this->set("title_for_layout","Alpissime : Location vacances aux Arcs - Bourg Saint Maurice");
		$this->set("description","Location les Arcs - Plus de 400 appartements en location de particuliers à particuliers stations les arcs 1600, les arcs 1800, les arcs 1950, les arcs 2000, bourg saint maurice");
		$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('ACCUEIL')]);
		$this->set("registres",$registre);
    	$this->set("images",$images);
	}
	/**
	 * 
	 */
	public function montchavinlescocheslanding()
	{
		$this->redirect(['action' => 'station','montchavin-les-coches']);

		$this->loadModel("Residences");
		$resid = $this->Residences->find('all');
		foreach ($resid as $value) {
			$residence[$value->id] = $value->name;
		}
		$this->set('residence', $residence);

		$this->viewBuilder()->layout(false);
		$session = $this->request->session();
		$session->delete('Reseservation.key');

		if($session->check("Inscription.utilisateur")){
			$this->set('confirm_res','reservation');
			$session->delete("Inscription.utilisateur");
		}

		$ann=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50", "lieugeo_id IN (19, 20)"],'contain' => ['Lieugeos'],"order"=>"Annonces.updated_at desc","limit"=>8])->toArray();
		$this->set('annonces', $ann);
		$this->loadModel("Feedbacks");
		/*** MINIMUM PRIX ANNONCES ***/
		$minprixannonce = [];
		$noteglobalmoytab = [];
		$condi = ["Annonces.statut"=>"50"];
		foreach ($ann as $key ) {
			$minprixannonce[$key->id]['prixmin'] = '';
			if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($key->id, '', '', $condi);
			else $tousperiodes = $this->Dispos->find('all', array(
							'conditions' => array('Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0',$condiPrixMin),
							'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

			foreach ($tousperiodes as $value) {
				if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at))){
					if($value->prix_jour == 0){
						$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
						$prix_jour = $value->prix/$nbrDiff;
					}else{
						$prix_jour = $value->prix_jour;
					}

					if($value->promo_yn == 0){
						if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
								$minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}else{
						if($value->promo_jour == 0){
								$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
								$promo_jour = $value->promo_px/$nbrDiff;
						}else{
								$promo_jour = $value->promo_jour;
						}
						if($promo_jour < $prix_jour){
								if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
						}else{
								if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}
				}
			} /** Fin parcour periodes **/
			//Liste Feedbacks
			$listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
			// Notes Globales
			$notecara = [];
			foreach ($listerating as $keyval) {
				foreach ($keyval['ratings'] as $valueval) {
						$notecara[$valueval->caracteristique] += $valueval->note;
				}
			}

			if($listerating->count() != 0){
				$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
				$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);
			}else{
				$noteglobalmoy = 0;
				$noteglobalmoytab[$key->id] = 0;
			}
			

		} /** Fin parcour annonces **/

		$this->set('noteglobalmoytab', $noteglobalmoytab);
		$this->set('minprixannonce',$minprixannonce);

		$a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
    	$this->set("l_distances",$a_distance);

    	$images=$this->Images->find()->where(['Images.visible = 1']);
		$photos=$this->Photos->find("all",["order"=>"Photos.numero"]);
		foreach($photos as $e) $ar_ph[$e->annonce_id][]=$e->numero;
		$this->set("photos",$ar_ph);

    	$enrs = $this->Lieugeos->find("all",["conditions"=>["Lieugeos.niveau >= 3", "id IN (19, 20)"],"order"=>"Lieugeos.name"]);
		$ar[]="";
		$ara2[]="";
    	foreach($enrs as $enr){
			$ar[$enr->id]=$enr->name;
			$ara2[$enr->id]=$enr->query;
		}  
		$this->set("l_lieugeos",$ar);
		$this->set("l_lieugeos_query",$ara2);

		$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
		$this->set("l_nombre_personnes",$a_personne);

		$this->loadModel("Registres");
		$this->set("title_for_layout","Alpissime : Location vacances aux Arcs - Bourg Saint Maurice");
		$this->set("description","Location les Arcs - Plus de 400 appartements en location de particuliers à particuliers stations les arcs 1600, les arcs 1800, les arcs 1950, les arcs 2000, bourg saint maurice");
		$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('ACCUEIL')]);
		$this->set("registres",$registre);
    	$this->set("images",$images);
	}
	/**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
  public function index(){
	return $this->redirect(['action' => 'landing']);
	$session = $this->request->session();
	if(!empty($session->read("SubmitOK"))){
		$this->set("SubmitOK",$session->read("SubmitOK"));
	}else{
		$this->set("SubmitOK","");
	}
	$session->delete("SubmitOK");
    $session->delete('Reseservation.key');
    if($session->check("Inscription.utilisateur")){
            $this->set('confirm_res','reservation');
            $session->delete("Inscription.utilisateur");
	}
	
	if($session->read('main_station') != 0)
    	$ann=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50","Lieugeos.id" => $session->read('main_station')],'contain' => ['Lieugeos'],"order"=>"Annonces.updated_at desc","limit"=>20])->toArray();
	else 
		$ann=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50"],'contain' => ['Lieugeos'],"order"=>"Annonces.updated_at desc","limit"=>20])->toArray();
	$this->set('annonces', $ann);
	
	$annvaldallos=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50", "lieugeo_id IN (15, 16, 17)"],'contain' => ['Lieugeos'],"order"=>"Annonces.updated_at desc","limit"=>20])->toArray();
    $this->set('annoncesvaldallos', $annvaldallos);

    $this->loadModel("Feedbacks");
    /*** MINIMUM PRIX ANNONCES ***/
    $minprixannonce = [];
    $noteglobalmoytab = [];
    $condi = ["Annonces.statut"=>"50"];
    foreach ($ann as $key ) {
            $minprixannonce[$key->id]['prixmin'] = '';
            if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($key->id, '', '', $condi);
            else $tousperiodes = $this->Dispos->find('all', array(
                            'conditions' => array('Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0',$condiPrixMin),
                            'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

            foreach ($tousperiodes as $value) {
                    if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at)))
                    {
                            if($value->prix_jour == 0){
                                    $nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
                                    $prix_jour = $value->prix/$nbrDiff;
                            }else{
                                    $prix_jour = $value->prix_jour;
                            }

                            if($value->promo_yn == 0){
                                    if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
                                            $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
                                    }
                            }else{
                                    if($value->promo_jour == 0){
                                            $nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
                                            $promo_jour = $value->promo_px/$nbrDiff;
                                    }else{
                                            $promo_jour = $value->promo_jour;
                                    }
                                    if($promo_jour < $prix_jour){
                                            if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
                                    }else{
                                            if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
                                    }
                            }
                    }
             } /** Fin parcour periodes **/
        //Liste Feedbacks
		$listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
		if($listerating->count() != 0){
			// Notes Globales
			$notecara = [];
			foreach ($listerating as $keyval) {
				foreach ($keyval['ratings'] as $valueval) {
						$notecara[$valueval->caracteristique] += $valueval->note;
				}
			}
	
			$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());	
		}else{
			$noteglobalmoy = 0;
		}
		$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);

     } /** Fin parcour annonces **/

    $this->set('noteglobalmoytab', $noteglobalmoytab);
    $this->set('minprixannonce',$minprixannonce);

		$this->loadModel("Residences");
		$resid = $this->Residences->find('all');
		foreach ($resid as $value) {
			$residence[$value->id] = $value->name;
		}
		$this->set('residence', $residence);

		$a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
    $this->set("l_distances",$a_distance);

		//chercher les publicités
		$images=$this->Images->find()->where(['Images.visible = 1'])->toArray();
		if($session->read('main_station') != 0){
			$images=array_filter($images, function($v, $k) use ($session) {
				return in_array($session->read('main_station'), unserialize($v->station));
			}, ARRAY_FILTER_USE_BOTH);
		}		
		$this->set("images",$images);
		//fin chercher les publicités

		$photos=$this->Photos->find("all",["order"=>"Photos.numero"]);
    foreach($photos as $e) $ar_ph[$e->annonce_id][]=$e->numero;
		$this->set("photos",$ar_ph);

    $enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3, "etat = 1"],"order"=>"Lieugeos.name"]);
	  $ar[]="Destination";
    foreach($enrs as $enr) $ar[$enr->id]=$enr->name;
    // $this->set("l_lieugeos",$ar);

		$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
    $this->set("l_nombre_personnes",$a_personne);

		$this->loadModel("Registres");
		$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('ACCUEIL')]);
		$this->set("registres",$registre);
		$this->set("title_for_layout","Alpissime : Location vacances aux Arcs - Bourg Saint Maurice");
		$this->set("description","Location les Arcs - Plus de 400 appartements en location de particuliers à particuliers stations les arcs 1600, les arcs 1800, les arcs 1950, les arcs 2000, bourg saint maurice");
	}
		/**
			 * Liste method
			 *
			 * @return \Cake\Network\Response|null
			 */
		public function liste(){
			return $this->redirect('/recherche');
			$this->paginate['conditions']=array('Annonces.statut =' => '50');
			$this->paginate['order']=array('Annonces.updated_at desc');
	    $data = $this->paginate($this->Annonces);
	    $this->set('annonces',$data);

			$a_annoces=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50"],"order"=>"Annonces.updated_at desc","limit"=>21]);
			$this->set('annonces_slide',$a_annoces);

			$a_nature=array('STD'=>__('Studio'),'APP'=>__('Appartement'),'CHA'=>__('Chalet'),'VIL'=>__('Villa'),'GIT'=>__('Gîte'),'DIV'=>__('Autre'));
			$this->set("l_natures_location",$a_nature);

			$a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
			$this->set("l_distances",$a_distance);

			$images=$this->Images->find()->where(['Images.visible = 1']);
			$this->set("images",$images);

			$photos=$this->Photos->find("all",["order"=>"Photos.numero"]);
      foreach($photos as $e) $ar_ph[$e->annonce_id][]=$e->numero;
			$this->set("photos",$ar_ph);

			$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
			$ar[]="";
			foreach($enrs as $enr) $ar[$enr->id]=$enr->name;
			// $this->set("l_lieugeos",$ar);

			$a_lieu=$this->Lieugeos->find("list",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"])->toArray();
		  $this->set("a_lieugeos",$a_lieu);
			$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
			$this->set("l_nombre_personnes",$a_personne);

			$this->loadModel("Registres");
			$registre=$this->Registres->find('all')->where(['Registres.app ' => strtoupper('ULYSSE'),'Registres.bra ' => strtoupper('TXT'),'Registres.cle ' => strtoupper('ACCUEIL')]);
			$this->set("registres",$registre);
		}
		/**
		 * 
		 */
		public function recherchebytype($nom = null, $type = null){
			if($type != null){
				$station = "";
				if($nom != null){
					$station = $this->Lieugeos->find()->where(['nom_url' => $nom])->first();
					$station = $station->id;
				} 
				$pos1 = stripos($type, "residence-");
				if($pos1 !== false && $pos1 == 0){
					$nom = substr($type, 10);
					$this->loadModel("Residences");
					if($station != "") $residence=$this->Residences->find('all')->contain(['Villages'=>'Lieugeos'])->where(["Lieugeos.id" => $station, "bibliotheque_id = 1", "name_url" => $nom])->first();
					else $residence=$this->Residences->find('all')->contain(['Villages'=>'Lieugeos'])->where(["bibliotheque_id = 1", "name_url" => $nom])->first();
					if($residence){
						$this->set("residence_info", $residence);
					}else{						
						if($station != "") $residence=$this->Residences->find('all')->contain(['Villages'=>'Lieugeos'])->where(["Lieugeos.id" => $station, "bibliotheque_id = 1", "Residences.name" => str_replace('_', ' ', $nom)])->first();
						else $residence=$this->Residences->find('all')->contain(['Villages'=>'Lieugeos'])->where(["bibliotheque_id = 1", "Residences.name" => str_replace('_', ' ', $nom)])->first();
						if($residence) $this->set("residence_info", $residence);
						else $this->set("residence_info", "");
					} 
			
					$listeAnnonce = "";
					$minprixannonceStat = "";
					$noteglobalmoytabStat = "";
					$this->loadModel("Dispos");
					$this->loadModel("Feedbacks");			
					$ann=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50", "Annonces.batiment" => $residence->id],'contain' => ['Lieugeos','Villages'],"order"=>"Annonces.updated_at desc"]);
					$listeAnnonce = $ann;
			
					/*** MINIMUM PRIX ANNONCES ***/
					$minprixannonce = [];
					$noteglobalmoytab = [];
					$condi = ["Annonces.statut"=>"50"];
					foreach ($ann as $key ) {
						$minprixannonce[$key->id]['prixmin'] = '';
						if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($key->id, '', '', $condi);
						else $tousperiodes = $this->Dispos->find('all', array(
										'conditions' => array('Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0',$condiPrixMin),
										'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));
			
						foreach ($tousperiodes as $value) {
							if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at))){
								if($value->prix_jour == 0){
									$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
									$prix_jour = $value->prix/$nbrDiff;
								}else{
									$prix_jour = $value->prix_jour;
								}
			
								if($value->promo_yn == 0){
									if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
											$minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
									}
								}else{
									if($value->promo_jour == 0){
											$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
											$promo_jour = $value->promo_px/$nbrDiff;
									}else{
											$promo_jour = $value->promo_jour;
									}
									if($promo_jour < $prix_jour){
											if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
									}else{
											if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
									}
								}
							}
						} /** Fin parcour periodes **/
						//Liste Feedbacks
						$listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
						// Notes Globales
						$notecara = [];
						foreach ($listerating as $keyval) {
							foreach ($keyval['ratings'] as $valueval) {
									$notecara[$valueval->caracteristique] += $valueval->note;
							}
						}
			
						if($listerating->count() != 0){
							$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
							$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);
						}else{
							$noteglobalmoy = 0;
							$noteglobalmoytab[$key->id] = 0;
						}
			
					} /** Fin parcour annonces **/
			
					$minprixannonceStat = $minprixannonce;
					$noteglobalmoytabStat = $noteglobalmoytab;
						
					$this->set("listeAnnonce",$listeAnnonce);
					$this->set('noteglobalmoytab', $noteglobalmoytabStat);
					$this->set('minprixannonce', $minprixannonceStat);

					$photos=$this->Photos->find("all")->order(['Photos.numero' => 'ASC']);
					foreach($photos as $e)  $ar_ph[$e->annonce_id][]=$e->numero;
					$this->set("photosCont",$ar_ph);
			
					if($residence->image_header != "") $this->render('/Annonces/residence-avec-header');
					else $this->render('/Annonces/residence-sans-header');


					// print_r($pieces);
					// exit;
				}else{					
					$a_nature_loc=array('studio'=>'std','appartement'=>'app','chalet'=>'cha','villa'=>'vil','gite'=>'git');
					return $this->redirect('/recherche?lieugeo='.$station.'&'.$a_nature_loc[$type].'=1');
				}
				// print_r($pos1);
				// exit;
				// if($pos1 = stripos($mystring1, $findme))
			}
			
		}
	/**
	 * 
	 */
	public function pagesavoie()
	{
		$this->loadModel("Massif");
		$listeStations = $this->Massif->find("all")->contain('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id", "Lieugeos.image", "Lieugeos.nom_url"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->matching('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id", "Lieugeos.image", "Lieugeos.nom_url"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->where(['Massif.id IN (7,8)'])->group(['Massif.id'])->order(['Lieugeos.name']);
		$this->set("listeStations",$listeStations);

		$this->loadModel("Partenaires");
		$nbrannonces = [];
		foreach ($listeStations as $value) { 
			foreach ($value['lieugeos'] as $key) { 
				if($key->name){
					$listeannonces = $this->Annonces->find("all")->where(["Annonces.statut"=>"50", 'Annonces.lieugeo_id' => $key->id])->count();
					$nbrannonces[$key->id] = $listeannonces;
				}

				// Liste partenaires				
				$listePart = $this->Partenaires->find("all")->where(["(lieugeo_id LIKE '$key->id;%' OR lieugeo_id LIKE '%;$key->id;%')"]);
				$listePartStat[] = $listePart;
			}
		}
		$this->set("nbrannonces",$nbrannonces);

		// annonces qui ont une période dans été Savoie
		if(date("m") < 9){
			$Year = date("Y");
		}else{
			$Year = date("Y")+1;
		}
		$anncondition = $this->Annonces->find("all")->innerJoinWith(
			'Dispos', function ($q) use ($Year) {
				return $q->where(['Dispos.statut' => '0', 'Dispos.conditionnbr <> 1', 'Dispos.dbt_at > "'.$Year.'-04-30"', 'Dispos.dbt_at < "'.$Year.'-09-01"']);
			}
		);
		$anncondition->select([
			'count' => $anncondition->func()->count('Dispos.id'),
			'Annonces.id'
		])
		->group('Annonces.id')
		->having(['count >' => 0]);
		$listeAnnonce = [];
		foreach ($anncondition as $value) {
			array_push($listeAnnonce, $value->id);
		}
		$ann=$this->Annonces->find('all',["conditions"=>["Annonces.id IN ('".implode("','",$listeAnnonce)."')", "Annonces.statut"=>"50", "Massif.id = 7"],'contain' => ['Lieugeos' => 'Massif','Villages'],"order"=>"Annonces.updated_at desc","limit"=>4]);
		$this->set('annoncesavoie', $ann);

		// annonces qui ont une période dans été Haute-Savoie
		if(date("m") < 9){
			$Year = date("Y");
		}else{
			$Year = date("Y")+1;
		}
		$annconditionhaute = $this->Annonces->find("all")->innerJoinWith(
			'Dispos', function ($q) use ($Year) {
				return $q->where(['Dispos.statut' => '0', 'Dispos.conditionnbr <> 1', 'Dispos.dbt_at > "'.$Year.'-04-30"', 'Dispos.dbt_at < "'.$Year.'-09-01"']);
			}
		);
		$annconditionhaute->select([
			'count' => $annconditionhaute->func()->count('Dispos.id'),
			'Annonces.id'
		])
		->group('Annonces.id')
		->having(['count >' => 0]);
		$listeAnnonceHaute = [];
		foreach ($annconditionhaute as $key) {
			array_push($listeAnnonceHaute, $key->id);
		}
		$annhautesavoie = $this->Annonces->find('all',["conditions"=>["Annonces.id IN ('".implode("','",$listeAnnonceHaute)."')", "Annonces.statut"=>"50", "Massif.id = 8"],'contain' => ['Lieugeos' => 'Massif','Villages'],"order"=>"Annonces.updated_at desc","limit"=>4]);
		$this->set('annoncehautesavoie', $annhautesavoie);

		$this->loadModel("Residences");
		$resid = $this->Residences->find('all');
		foreach ($resid as $value) {
			$residence[$value->id] = $value->name;
		}
		$this->set('residence', $residence);

		$ar_ph=[];
		$photos=$this->Photos->find("all",["order"=>"Photos.numero"]);
		foreach($photos as $e) $ar_ph[$e->annonce_id][]=$e->numero;
		$this->set("photos",$ar_ph);

		$this->loadModel("Feedbacks");
		/*** MINIMUM PRIX ANNONCES ***/
		$minprixannonce = [];
		$noteglobalmoytab = [];
		$condi = ["Annonces.statut"=>"50"];

		$condAnn = [];
		if(!empty($listeAnnonceHaute)){
			$condAnn[] = "Annonces.id IN ('".implode("','",$listeAnnonceHaute)."')";
		}
		if(!empty($listeAnnonce)){
			$condAnn[] = "Annonces.id IN ('".implode("','",$listeAnnonce)."')";
		}
		$annon=$this->Annonces->find('all',["conditions"=>$condAnn,'contain' => ['Lieugeos' => 'Massif','Villages']]);
		foreach ($annon as $key ) {
			$minprixannonce[$key->id]['prixmin'] = '';
			$tousperiodes = $this->Dispos->chercherdisponibilite($key->id, $Year.'-04-30', $Year.'-09-01');

			foreach ($tousperiodes as $value) {
				if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at))){
					if($value->prix_jour == 0){
						$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
						$prix_jour = $value->prix/$nbrDiff;
					}else{
						$prix_jour = $value->prix_jour;
					}

					if($value->promo_yn == 0){
						if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
								$minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}else{
						if($value->promo_jour == 0){
								$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
								$promo_jour = $value->promo_px/$nbrDiff;
						}else{
								$promo_jour = $value->promo_jour;
						}
						if($promo_jour < $prix_jour){
								if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
						}else{
								if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}
				}
			} /** Fin parcour periodes **/
			//Liste Feedbacks
			$listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
			// Notes Globales
			$notecara = [];
			foreach ($listerating as $keyval) {
				foreach ($keyval['ratings'] as $valueval) {
						$notecara[$valueval->caracteristique] += $valueval->note;
				}
			}

			if($listerating->count() != 0){
				$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
				$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);
			}else{
				$noteglobalmoy = 0;
				$noteglobalmoytab[$key->id] = 0;
			}
			

		} /** Fin parcour annonces **/
		
		$this->set('noteglobalmoytab', $noteglobalmoytab);
		$this->set('minprixannonce',$minprixannonce);

		$this->set("stations",$listeStations);

		$this->set("listePart",$listePartStat);
	}
	/**
	 * 
	 */
	public function pagesavoiemontblanc()
	{
		$this->loadModel("Massif");
		$listeStations = $this->Massif->find("all")->contain('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id", "Lieugeos.image", "Lieugeos.nom_url"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->matching('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id", "Lieugeos.image", "Lieugeos.nom_url"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->where(['Massif.id IN (7,8)'])->group(['Massif.id'])->order(['Lieugeos.name']);
		$this->set("listeStations",$listeStations);

		// $massifStat = [];
		// foreach ($listeStations as $valueStation) {
		// 	$massifStat[] = $valueStation->nom;
		// }
		// $this->set("listeMassifStation",$massifStat);

		$this->loadModel("Partenaires");
		$nbrannonces = [];
		$stationsIds = [];
		foreach ($listeStations as $value) { 
			foreach ($value['lieugeos'] as $key) { 
				$stationsIds[] = $key->id;

				if($key->name){
					$listeannonces = $this->Annonces->find("all")->where(["Annonces.statut"=>"50", 'Annonces.lieugeo_id' => $key->id])->count();
					$nbrannonces[$key->id] = $listeannonces;
				}

				// Liste partenaires				
				$listePart = $this->Partenaires->find("all")->where(["(lieugeo_id LIKE '$key->id;%' OR lieugeo_id LIKE '%;$key->id;%')"]);
				$listePartStat[] = $listePart;
			}
		}
		$this->set("nbrannonces", $nbrannonces);

        $listeAnnonce = [];

		$allannonceswithperiod = $this->Annonces->getAllAnnoncesWithPeriodSavoie($stationsIds)->where(['Annonces.sejour_flexible = 1'])->limit(4);
		if($allannonceswithperiod->count() < 4){
			$allannonces = $this->Annonces->getAllAnnoncesSavoie($stationsIds)->where(['Annonces.sejour_flexible = 1']);
			if($allannonces->count() >= 4){
				$countlimit = 4-$allannonceswithperiod->count();
				$allannonceswithoutperiod = $this->Annonces->getAllAnnoncesWithoutPeriodSavoie($stationsIds)->where(['Annonces.sejour_flexible = 1'])->limit($countlimit);
				$allannonceswithperiod->union($allannonceswithoutperiod);
			}
		}

        if ($allannonceswithperiod->count() > 0) {
            $listeAnnonce = array_merge($listeAnnonce, array_column($allannonceswithperiod->toArray(), 'id'));
        }
		$this->set('annonces', $allannonceswithperiod);

		/*$allannonceswithperiodhors = $this->Annonces->getAllAnnoncesWithPeriodSavoie($stationsIds)->where(['Annonces.sejour_flexible = 2'])->limit(4);
		if($allannonceswithperiodhors->count() < 4){
			$allannonces = $this->Annonces->getAllAnnoncesSavoie($stationsIds)->where(['Annonces.sejour_flexible = 2']);
			if($allannonces->count() >= 4){
				$countlimit = 4-$allannonceswithperiodhors->count();
				$allannonceswithoutperiodhors = $this->Annonces->getAllAnnoncesWithoutPeriodSavoie($stationsIds)->where(['Annonces.sejour_flexible = 2'])->limit($countlimit);
				$allannonceswithperiodhors->union($allannonceswithoutperiodhors);
			}
		}

        if ($allannonceswithperiodhors->count() > 0) {
            $listeAnnonce = array_merge($listeAnnonce, array_column($allannonceswithperiodhors->toArray(), 'id'));
        }
		$this->set('annonceshorsvacances', $allannonceswithperiodhors);*/

		$allannonceswithperiodFamille = $this->Annonces->getAllAnnoncesWithPeriodSavoie($stationsIds, "famille")->where(['(Annonces.sejour_flexible = 1 OR Annonces.sejour_flexible = 2)'])->limit(4);
		if($allannonceswithperiodFamille->count() < 4){
			$allannoncesFamille = $this->Annonces->getAllAnnoncesSavoie($stationsIds, "famille")->where(['(Annonces.sejour_flexible = 1 OR Annonces.sejour_flexible = 2)']);
			if($allannoncesFamille->count() >= 4){
				$countlimit = 4-$allannonceswithperiodFamille->count();
				$allannonceswithoutperiodFamille = $this->Annonces->getAllAnnoncesWithoutPeriodSavoie($stationsIds, "famille")->where(['(Annonces.sejour_flexible = 1 OR Annonces.sejour_flexible = 2)'])->limit($countlimit);
				$allannonceswithperiodFamille->union($allannonceswithoutperiodFamille);
			}
		}

        if ($allannonceswithperiodFamille->count() > 0) {
            $listeAnnonce = array_merge($listeAnnonce, array_column($allannonceswithperiodFamille->toArray(), 'id'));
        }
		$this->set('annoncesFamille', $allannonceswithperiodFamille);

		/*$allannonceswithperiodgroupe = $this->Annonces->getAllAnnoncesWithPeriodSavoie($stationsIds, "groupe")->where(['(Annonces.sejour_flexible = 1 OR Annonces.sejour_flexible = 2)'])->limit(4);
		if($allannonceswithperiodgroupe->count() < 4){
			$allannoncesgroupe = $this->Annonces->getAllAnnoncesSavoie($stationsIds, "groupe")->where(['(Annonces.sejour_flexible = 1 OR Annonces.sejour_flexible = 2)']);
			if($allannoncesgroupe->count() >= 4){
				$countlimit = 4-$allannonceswithperiodgroupe->count();
				$allannonceswithoutperiodgroupe = $this->Annonces->getAllAnnoncesWithoutPeriodSavoie($stationsIds, "groupe")->where(['(Annonces.sejour_flexible = 1 OR Annonces.sejour_flexible = 2)'])->limit($countlimit);
				$allannonceswithperiodgroupe->union($allannonceswithoutperiodgroupe);
			}
		}

        if ($allannonceswithperiodgroupe->count() > 0) {
            $listeAnnonce = array_merge($listeAnnonce, array_column($allannonceswithperiodgroupe->toArray(), 'id'));
        }
		$this->set('annoncesgroupe', $allannonceswithperiodgroupe);*/

		$allannonceswithperiodpromos = $this->Annonces->getAllAnnoncesWithPeriodSavoie($stationsIds, "", "promos")->where(['(Annonces.sejour_flexible = 1 OR Annonces.sejour_flexible = 2)'])->limit(4);
		if($allannonceswithperiodpromos->count() < 4){
			$allannoncespromos = $this->Annonces->getAllAnnoncesSavoie($stationsIds)->where(['(Annonces.sejour_flexible = 1 OR Annonces.sejour_flexible = 2)']);
			if($allannoncespromos->count() >= 4){
				$countlimit = 4-$allannonceswithperiodpromos->count();
				$allannonceswithoutperiodpromos = $this->Annonces->getAllAnnoncesWithoutPeriodSavoie($stationsIds, "", "promos")->where(['(Annonces.sejour_flexible = 1 OR Annonces.sejour_flexible = 2)'])->limit($countlimit);
				$allannonceswithperiodpromos->union($allannonceswithoutperiodpromos);
			}
		}

        if ($allannonceswithperiodpromos->count() > 0) {
            $listeAnnonce = array_merge($listeAnnonce, array_column($allannonceswithperiodpromos->toArray(), 'id'));
        }
		$this->set('annoncespromos', $allannonceswithperiodpromos);

		$photosArr = [];
		$photos = $this->Photos->find("all",  ["condition" => ['annonce_id IN' => $listeAnnonce], "order"=>"Photos.numero"]);
		foreach($photos as $e) {
            $photosArr[$e->annonce_id][]=$e->numero;
        }

		$this->set("photos", $photosArr);

		$this->loadModel("Feedbacks");
		/*** MINIMUM PRIX ANNONCES ***/
		$minprixannonce = [];
		$noteglobalmoytab = [];

		$condAnn = [];
		if(!empty($listeAnnonceHaute)){
			$condAnn[] = "Annonces.id IN ('".implode("','",$listeAnnonceHaute)."')";
		}
		if(!empty($listeAnnonce)){
			$condAnn[] = "Annonces.id IN ('".implode("','",$listeAnnonce)."')";
		}

		$annon=$this->Annonces->find('all',["conditions" => $condAnn,'contain' => ['Lieugeos' => 'Massif','Villages']]);
		foreach ($annon as $key ) {
			$minprixannonce[$key->id]['prixmin'] = '';
			$tousperiodes = $this->Dispos->find('all', [
				'conditions' => ['Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0'],
				'fields'     => ['Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn']
            ]);

			foreach ($tousperiodes as $value) {
				if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at))){
					if($value->prix_jour == 0){
						$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
						$prix_jour = $value->prix/$nbrDiff;
					}else{
						$prix_jour = $value->prix_jour;
					}

					if($value->promo_yn == 0){
						if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
								$minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}else{
						if($value->promo_jour == 0){
								$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
								$promo_jour = $value->promo_px/$nbrDiff;
						}else{
								$promo_jour = $value->promo_jour;
						}
						if($promo_jour < $prix_jour){
								if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
						}else{
								if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
						}
					}
				}
			} /** Fin parcour periodes **/
			//Liste Feedbacks
			$listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
			// Notes Globales
			$notecara = [];
			foreach ($listerating as $keyval) {
				foreach ($keyval['ratings'] as $valueval) {
						$notecara[$valueval->caracteristique] += $valueval->note;
				}
			}

			if($listerating->count() != 0){
				$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
				$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);
			}else{
				$noteglobalmoy = 0;
				$noteglobalmoytab[$key->id] = 0;
			}
			

		} /** Fin parcour annonces **/

        $this->set('urlLang', $this->getLanguage());
		$this->set('noteglobalmoytab', $noteglobalmoytab);
		$this->set('minprixannonce',$minprixannonce);
	}
		/**
	     * Recherche method
	     *
	     * @return \Cake\Network\Response|null
	     */
	public function recherche() {

		$session = $this->request->session();
		$this->loadModel("Urlmultilingue");
        $urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
        $urlvaluemulti = [];
        foreach ($urlmultilinguelistes as $urlmultilingueliste) {
            $urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
        }
		
		$this->request->query['lieugeo'] = $this->request->query[$urlvaluemulti['lieugeo']];
		$this->request->query['dbt'] = $this->request->query[$urlvaluemulti['dbt']];
		$this->request->query['fin'] = $this->request->query[$urlvaluemulti['fin']];
		$this->request->query['nbCouchage_ad'] = $this->request->query[$urlvaluemulti['nbCouchage_ad']];
		$this->request->query['nbCouchage_enf'] = $this->request->query[$urlvaluemulti['nbCouchage_enf']];
		$this->request->query['surfaceDe'] = $this->request->query[$urlvaluemulti['surfaceDe']];
		$this->request->query['surfaceA'] = $this->request->query[$urlvaluemulti['surfaceA']];
		$this->request->query['prixbudget'] = $this->request->query[$urlvaluemulti['prixbudget']];
		$this->request->query['budgetDe'] = $this->request->query[$urlvaluemulti['budgetDe']];
		$this->request->query['budgetA'] = $this->request->query[$urlvaluemulti['budgetA']];
		$this->request->query['conditionSemaine'] = $this->request->query[$urlvaluemulti['conditionSemaine']];
		$this->request->query['nb_etoiles'] = $this->request->query[$urlvaluemulti['nb_etoiles']];
		$this->request->query['nbPiece'] = $this->request->query[$urlvaluemulti['nbPiece']];
		$this->request->query['drap'] = $this->request->query[$urlvaluemulti['drap']];
		$this->request->query['animaux'] = $this->request->query[$urlvaluemulti['animaux']];
		$this->request->query['motcle'] = $this->request->query[$urlvaluemulti['motcle']];
		
		$search_query_keys = ['parking','personne_reduite', 'balcon', 'terasse', 'jardin', 'espace_plein_air', 
			'baignoire_hydro', 'appart_hammam', 'appart_sauna', 'espace_piscine', 'salle_fitness',
			'wifi_appartment', 'wifi_gratuit', 'wifi_payant', 'lave_linge', 'lave_vaissel',
			'espace_enfant', 'lieux_anim', 'tours_localisations', 'average_rating',
		];

		foreach($search_query_keys as $key) {
			$this->request->query[$key] = $this->request->query[(isset($urlvaluemulti[$key])?$urlvaluemulti[$key]:$key)];
		}

		$oldstation = [1,2,3,4,5,6,7,8,9,10,11,12,15,16,17,18,19,20];			
		if(in_array($this->request->query['lieugeo'], $oldstation)){
			$newstation = array(1=>['station'=>66, 'village'=>1],
				3=>['station'=>66, 'village'=>5],
				4=>['station'=>66, 'village'=>2],
				5=>['station'=>66, 'village'=>3],
				8=>['station'=>66, 'village'=>4],
				9=>['station'=>66, 'village'=>7],
				10=>['station'=>66, 'village'=>8],
				11=>['station'=>66, 'village'=>9],
				12=>['station'=>73, 'village'=>11],
				15=>['station'=>22, 'village'=>18],
				16=>['station'=>22, 'village'=>19],
				17=>['station'=>22, 'village'=>21],
				18=>['station'=>22, 'village'=>24],
				19=>['station'=>115, 'village'=>26],
				20=>['station'=>115, 'village'=>27]);
			$typeredirect = "";
			if($this->request->query['cha'] == 1) $typeredirect = "&cha=1";
			if($this->request->query['app'] == 1) $typeredirect = "&app=1";
			if($this->request->query['std'] == 1) $typeredirect = "&std=1";
			if($this->request->query['git'] == 1) $typeredirect = "&git=1";
			if($this->request->query['vil'] == 1) $typeredirect = "&vil=1";
			$chredirect = "recherche?lieugeo=".$newstation[$this->request->query['lieugeo']]['station']."&village=".$newstation[$this->request->query['lieugeo']]['village'].$typeredirect;
			$path = Router::url('/', true);
			return $this->redirect($path.$chredirect);
		}

		$this->loadModel("Lieugeos");
		$session = $this->request->session();

		$residencesmarqueurs = [];
		$this->loadModel("Residences");
		$residences=$this->Residences->find('all')->where(["bibliotheque_id = 1 OR bibliotheque_id = 7"]);
		foreach ($residences as $value) {
			$residencesmarqueurs[$value->id]["lat"] = $value->latitude;
			$residencesmarqueurs[$value->id]["lon"] = $value->longitude;
			$residencesmarqueurs[$value->id]["title"] = $value->name;
		}
		$this->set('residenceAnnonce', $residencesmarqueurs);

		
		if($session->check("Recherche") && empty($this->request->query)) $this->request->query = $session->read('Recherche');

		$this->loadModel("Dispos");
		$this->loadModel("Annonces");
		$this->loadModel("Feedbacks");
		$select = array();
		$order = array();
		$joindispos = '';
		$select[] = "Annonces.statut = 50";
		$per_page_total = 9;
		/*** CONDITION SITUATION GEOGRAPHIQUE ***/
					$tabzoomstation = [];
		
		// if($this->request->query['lieugeo'] != 0){
			$stationDetail = array('a' => '', 'name' => '');
			if(is_numeric($this->request->query['lieugeo'])){
				if($this->request->query['lieugeo'] != 0){
					$select[] = "Annonces.lieugeo_id = ".$this->request->query['lieugeo'];
					$stationAnnDetail = $this->Lieugeos->get($this->request->query['lieugeo']);
					$stationDetail['a'] = $stationAnnDetail->preposition_a;
					$stationDetail['name'] = $stationAnnDetail->name;
				}
			}else if(is_string($this->request->query['lieugeo'])){
				$pos = stripos($this->request->query['lieugeo'], "massif_");							
				if ($pos !== false) {
					$str = str_replace("massif_", "", $this->request->query['lieugeo']);						
					$select[] = "Massifs.id = ".intval($str);
					$this->loadModel("Massif");
					$stationAnnDetail = $this->Massif->get(intval($str));
					$stationDetail['name'] = $stationAnnDetail->nom;
				} 
			}
			$this->set("stationDetail", $stationDetail);
			
		// }
		
		// A REFAIRE tabzoomstation!!!!!!
		$this->set("tabzoomstation", $tabzoomstation);
					
		/*** Tri : il faut mettre ce bloc ici pour donner la priorité au filtres de tri ***/
		if($this->request->query['TRI']==3)
			$order[] = "Annonces.surface ASC";
		elseif($this->request->query['TRI']==4)
			$order[] = "Annonces.surface DESC";
		elseif($this->request->query['TRI']==6)
			$order[] = "Annonces.nb_etoiles ASC";
		elseif($this->request->query['TRI']==7)
			$order[] = "Annonces.nb_etoiles DESC";
		/*** END Tri surface / Classement ***/
					
		/*** CONDITION SAMEDI/DIMANCHE ***/
		if($this->request->query['conditionSemaine'] && !$this->request->query['dbt'] && !$this->request->query['fin']){
			$select[] = "Dispos.conditionnbr = ".$this->request->query['conditionSemaine'];
			$joindispos = "oui";
		}
		/*** CONDITION TYPE LOCATION ***/
					$chtype = '';
					$m = 1;
					$natureAPP = "";
					if($this->request->query['cha'] == 1) {
						if($m != 1) $chtype .= ' OR ';
						$chtype .= "Annonces.nature = 'CHA'";
						$m++;
						$natureAPP = 'CHA';
					}
					if($this->request->query['app'] == 1) {
						if($m != 1) $chtype .= ' OR ';
						$chtype .= "Annonces.nature = 'APP'";
						$m++;
						$natureAPP = 'APP';
					}
					if($this->request->query['std'] == 1) {
						if($m != 1) $chtype .= ' OR ';
						$chtype .= "Annonces.nature = 'STD'";
						$m++;
						$natureAPP = 'STD';
					}
					if($this->request->query['git'] == 1) {
						if($m != 1) $chtype .= ' OR ';
						$chtype .= "Annonces.nature = 'GIT'";
						$m++;
						$natureAPP = 'GIT';
					}
					if($this->request->query['vil'] == 1) {
						if($m != 1) $chtype .= ' OR ';
						$chtype .= "Annonces.nature = 'VIL'";
						$m++;
						$natureAPP = 'VIL';
					}
					$this->set("natureAPP", $natureAPP);
					if($chtype != '') $select[] = "( ".$chtype." )";
		/*** CONDITION NOMBRE DE COUCHAGE ***/
		if(isset($this->request->query['nbCouchage_ad']) && isset($this->request->query['nbCouchage_enf'])){
			$nbCouchage = $this->request->query['nbCouchage_ad'] + $this->request->query['nbCouchage_enf'];
			$select[] = "Annonces.personnes_nb >= {$nbCouchage} AND Annonces.personnes_nb <= ".( $nbCouchage + 3 );
		}
		/*** CONDITION SURFACE ***/
		if($this->request->query['surfaceDe']){
			$select[] = "Annonces.surface >= ".$this->request->query['surfaceDe'];
		}
		if($this->request->query['surfaceA']){
			$select[] = "Annonces.surface <= ".$this->request->query['surfaceA'];
		}
		/*** CONDITION CLASSEMENT ***/
		if($this->request->query['nb_etoiles']){
			$select[] = "Annonces.nb_etoiles >= ".$this->request->query['nb_etoiles'];
		}
		/*** CONDITION NOMBRE PIECES ***/
		if($this->request->query['nbPiece']){
			$select[] = "Annonces.pieces_nb = ".$this->request->query['nbPiece'];
		}
		/*** CONDITION BUDGET ***/
		if($this->request->query['budgetDe'] && !$this->request->query['dbt'] && !$this->request->query['fin']){
			if($this->request->query['prixbudget'] && $this->request->query['prixbudget'] == 2){
				//Prix Période
				$select[] = "IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, Dispos.promo_px, Dispos.prix) >= ".$this->request->query['budgetDe'];
				$joindispos = "oui";
			}else if($this->request->query['prixbudget'] && $this->request->query['prixbudget'] == 1){
				//Prix Nuitée
				$select[] = "IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)) >= ".$this->request->query['budgetDe'];
				$joindispos = "oui";
			}else{
				//Prix Nuitée
				$select[] = "IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)) >= ".$this->request->query['budgetDe'];
				$joindispos = "oui";
			}
		}
		if($this->request->query['budgetA'] && !$this->request->query['dbt'] && !$this->request->query['fin']){
			if($this->request->query['prixbudget'] && $this->request->query['prixbudget'] == 2){
				//Prix Période
				$select[] = "IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, Dispos.promo_px, Dispos.prix) <= ".$this->request->query['budgetA'];
				$joindispos = "oui";
			}else if($this->request->query['prixbudget'] && $this->request->query['prixbudget'] == 1){
				//Prix Nuitée
				$select[] = "IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)) <= ".$this->request->query['budgetA'];
				$joindispos = "oui";
			}else{
				//Prix Nuitée
				$select[] = "IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)) <= ".$this->request->query['budgetA'];
				$joindispos = "oui";
			}
		}
		/*** CONDITION OPTIONS ***/
		//promotion
		if($this->request->query['promotions'] && !$this->request->query['dbt'] && !$this->request->query['fin']){
			$select[] = "Dispos.promo_yn = 1";
			$joindispos = "oui";
		}
		//parking
		if($this->request->query['parking'] ) {
			$select[] = "Annonces.stationnement = '{$this->request->query['parking']}'";
		}
		//personne_reduite
		if($this->request->query['personne_reduite'] ) {
			$select[] = "Annonces.personne_reduite = 1";
		}
		//balcon
		if($this->request->query['balcon'] && !empty($this->request->query['balcon']) ) {
			$select[] = "Annonces.balcon_yn = 1";
		}
		//terrase
		if($this->request->query['terasse'] && !empty($this->request->query['terasse']) ) {
			$select[] = "Annonces.terasse_yn = 1";
		}
		//Garden
		if($this->request->query['jardin'] && !empty($this->request->query['jardin']) ) {
			$select[] = "Annonces.jardin_yn = 1";
		}
		//espace_plein_air
		if($this->request->query['espace_plein_air'] && !empty($this->request->query['espace_plein_air']) ) {
			$select[] = "Annonces.espace_plein_air = 1";
		}
		//baignoire_hydro
		if($this->request->query['baignoire_hydro'] && !empty($this->request->query['baignoire_hydro']) ) {
			$select[] = "Annonces.baignoire_hydro = 1";
		}
		//appart_hammam
		if($this->request->query['appart_hammam'] && !empty($this->request->query['appart_hammam']) ) {
			$select[] = "Annonces.appart_hammam = 1";
		}
		//appart_sauna
		if($this->request->query['appart_sauna'] && !empty($this->request->query['appart_sauna']) ) {
			$select[] = "Annonces.appart_sauna = 1";
		}
		//espace_piscine
		if($this->request->query['espace_piscine'] && !empty($this->request->query['espace_piscine']) ) {
			$select[] = "Annonces.espace_piscine = 1";
		}
		//salle_fitness
		if($this->request->query['salle_fitness'] && !empty($this->request->query['salle_fitness']) ) {
			$select[] = "Annonces.salle_fitness = 1";
		}

		//wifi_appartment
		if($this->request->query['wifi_appartment'] && !empty($this->request->query['wifi_appartment']) ) {
			//$select[] = "Annonces.wifi = 1";
			$select[] = "Annonces.wifi & ".$this->Annonces->getWifiAppartmentConst();
		}
		//wifi_gratuit
		if($this->request->query['wifi_gratuit'] && !empty($this->request->query['wifi_gratuit']) ) {
			///$select[] = "Annonces.wifi_gratuit = 1";
			$select[] = "Annonces.wifi & ".$this->Annonces->getWifiGratuitConst();
		}
		//wifi_payant
		if($this->request->query['wifi_payant'] && !empty($this->request->query['wifi_payant']) ) {
			//$select[] = "Annonces.wifi_payant = 1";
			$select[] = "Annonces.wifi & ".$this->Annonces->getWifiPayantConst();
		}
		
		//lave_linge
		if($this->request->query['lave_linge'] && !empty($this->request->query['lave_linge']) ) {
			$select[] = "Annonces.lave_linge = 1";
		}
		//lave_vaissel
		if($this->request->query['lave_vaissel'] && !empty($this->request->query['lave_vaissel']) ) {
			$select[] = "(Annonces.lave_vaissel_4 = 1 OR Annonces.lave_vaissel_8=1 OR Annonces.lave_vaissel_8 = 1)";
		}

		//tours_localisations
		if($this->request->query['tours_localisations'] && !empty($this->request->query['tours_localisations'])) {
			switch($this->request->query['tours_localisations']) {
				case 'ski_pied':
					$select[] = "Annonces.ski_pied = 1";
				break;
				case 'moins_50_piste':
					$select[] = "Annonces.moins_50_piste = 1";
				break;
			}
		}
		//espace_enfant
		if($this->request->query['espace_enfant'] && !empty($this->request->query['espace_enfant']) ) {
			$select[] = "Annonces.espace_enfant = 1";
		}
		//lieux_anim
		if($this->request->query['lieux_anim'] && !empty($this->request->query['lieux_anim']) ) {
			$select[] = "Annonces.lieux_anim = 1";
		}
		
		//internet
		// if($this->request->query['internet']){
		// 	$select[] = "((Annonces.wifi = 1) OR (Annonces.wifi_payant = 1))";
		// }
		//Draps et linge fournis
		if($this->request->query['drap']){
			$select[] = "( (Annonces.serv_drap_type = 1) OR (Annonces.serv_drap_type = 2) OR (Annonces.serv_linge_type = 1) OR (Annonces.serv_linge_type = 2) )";
		}
		//Animaux acceptés
		if($this->request->query['animaux']){
			$select[] = "Annonces.accept_animaux = 1";
		}
		/*** CONDITION REFERENCE ***/
		if($this->request->query['reference'] && intval($this->request->query['reference'])){
			$select[] = "Annonces.id = ".$this->request->query['reference'];
		}
		/*** CONDITION MOT CLE ***/
		if($this->request->query['motcle']){
			$motcll = $this->request->query['motcle'];
							if(is_numeric($motcll)) $select[] = "((Annonces.description like '%".$motcll."%') OR (Annonces.titre like '%".$motcll."%') OR (Annonces.id = ".$motcll."))";
			else $select[] = "((Annonces.description like '%".$motcll."%') OR (Annonces.titre like '%".$motcll."%'))";
		}
		/*** CONDITION VILLAGE ***/
		if($this->request->query['village'] && intval($this->request->query['village'])){
			$select[] = "Annonces.village = ".$this->request->query['village'];
			$this->loadModel("Villages");
			$villageinfo = $this->Villages->get($this->request->query['village'], ['contain' => ['Lieugeos']]);
			$this->set("villageinfo", $villageinfo);
		}

		/*** REQUETE ***/
		$da_debut = '';
		if(!empty($this->request->query['dbt'])) {
			$da_debut = date("Y-m-d", strtotime($this->request->query['dbt']));
		}
		$da_fin = '';
		if(!empty($this->request->query['fin'])) {
			$da_fin = date("Y-m-d", strtotime($this->request->query['fin']));
		}
		if(!empty($da_debut)) {
			$select[] = "Dispos.dbt_at <= '{$da_debut}'";
			$joindispos = 'oui';
		} if(!empty($da_fin)) {
			$select[] = "Dispos.fin_at >= '{$da_fin}'";
			$joindispos = 'oui';
		} else if(empty($da_debut) && empty($da_fin) && $joindispos == 'oui' ) {
			$select[] = 'Dispos.fin_at > NOW()';
		}
		
		if($joindispos == "oui") {
			//get all listings which available for selected dates
			$select[] = "Dispos.statut = 0";
			$listeannonces = $this->Annonces->find();
			$listeannonces->join([
				'Dispos' => [
					'table' => 'dispos',
					'type' => 'inner',
					'conditions' => ['Annonces.id = Dispos.annonce_id'],
					],
				'lieugeo' => [
					'table' => 'lieugeos',
					'type' => 'inner',
					'conditions' => ['Annonces.lieugeo_id = lieugeo.id'],
				],
				'Massifs' => [
					'table' => 'massif',
					'type' => 'inner',
					'conditions' => ['Massifs.id = lieugeo.massif_id'],
				],
				'village' => [
					'table' => 'villages',
					'type' => 'inner',
					'conditions' => ['village.id = Annonces.village'],
				],
				'Feedbacks' => [
					'table' => 'feedbacks',
					'type' => 'left',
					'conditions' => ['Annonces.id = Feedbacks.annonce_id', 'Feedbacks.activated = 1'],
				],
				'Ratings' => [
					'table' => 'ratings',
					'type' => 'left',
					'conditions' => ['Ratings.feedback_id = Feedbacks.id'],
				],
				'Utilisateurs' => [
					'table' => 'utilisateurs',
					'type' => 'left',
					'conditions' => ['Utilisateurs.id = Feedbacks.utilisateur_id AND Utilisateurs.pays > 0'],
				],
			]);
			$listeannonces->select(["village.name","lieugeo.name","lieugeo.nom_url","Annonces.village","Annonces.id","Annonces.titre","Annonces.surface","Annonces.vue","Annonces.kmstat_id","Annonces.lieugeo_id","Annonces.pieces_nb","Annonces.nature","Annonces.personnes_nb","Annonces.description","Annonces.wifi","Annonces.nb_etoiles","Annonces.batiment","Annonces.etage","Dispos.prix","Dispos.fin_at","Dispos.dbt_at","Dispos.prix_jour","Dispos.promo_px","Dispos.promo_jour","Dispos.promo_yn"]);
			$listeannonces->select([
				'average_rating' => "IF(Utilisateurs.id IS NULL, 0, ROUND(AVG(Ratings.note)))",
			]);
			$listeannonces->where($select);
			$listeannonces->group(['Annonces.id']);


			$annTotal = $this->Annonces->find();
			$annTotal->join([
				'Dispos' => [
					'table' => 'dispos',
					'type' => 'inner',
					'conditions' => ['Annonces.id = Dispos.annonce_id'],
					],
							'lieugeo' => [
					'table' => 'lieugeos',
					'type' => 'inner',
					'conditions' => ['Annonces.lieugeo_id = lieugeo.id'],
					],
					'Massifs' => [
						'table' => 'massif',
						'type' => 'inner',
						'conditions' => ['Massifs.id = lieugeo.massif_id'],
					],
				'village' => [
					'table' => 'villages',
					'type' => 'inner',
					'conditions' => ['village.id = Annonces.village'],
				],
				'Feedbacks' => [
					'table' => 'feedbacks',
					'type' => 'left',
					'conditions' => ['Annonces.id = Feedbacks.annonce_id', 'Feedbacks.activated = 1'],
				],
				'Ratings' => [
					'table' => 'ratings',
					'type' => 'left',
					'conditions' => ['Ratings.feedback_id = Feedbacks.id'],
				],
				'Utilisateurs' => [
					'table' => 'utilisateurs',
					'type' => 'left',
					'conditions' => ['Utilisateurs.id = Feedbacks.utilisateur_id AND Utilisateurs.pays > 0'],
				],
			]);
			$annTotal->select(["village.name","lieugeo.name","lieugeo.nom_url","Annonces.village","Annonces.id","Annonces.titre","Annonces.surface","Annonces.vue","Annonces.kmstat_id","Annonces.lieugeo_id","Annonces.pieces_nb","Annonces.nature","Annonces.personnes_nb","Annonces.description","Annonces.wifi","Annonces.nb_etoiles","Annonces.batiment","Annonces.etage","Dispos.prix","Dispos.fin_at","Dispos.dbt_at","Dispos.prix_jour","Dispos.promo_px","Dispos.promo_jour","Dispos.promo_yn"]);
			$annTotal->select([
				'average_rating' => "IF(Utilisateurs.id IS NULL, 0, ROUND(AVG(Ratings.note)))",
			]);
			$annTotal->where($select);
			$annTotal->group(['Annonces.id']);
		}else{
			$listeannonces = $this->Annonces->find();
			$listeannonces->join([
							'lieugeo' => [
					'table' => 'lieugeos',
					'type' => 'inner',
					'conditions' => ['Annonces.lieugeo_id = lieugeo.id'],
					],
					'Massifs' => [
						'table' => 'massif',
						'type' => 'inner',
						'conditions' => ['Massifs.id = lieugeo.massif_id'],
					],
				'village' => [
					'table' => 'villages',
					'type' => 'inner',
					'conditions' => ['village.id = Annonces.village'],
				],
				'Feedbacks' => [
					'table' => 'feedbacks',
					'type' => 'left',
					'conditions' => ['Annonces.id = Feedbacks.annonce_id', 'Feedbacks.activated = 1'],
				],
				'Ratings' => [
					'table' => 'ratings',
					'type' => 'left',
					'conditions' => ['Ratings.feedback_id = Feedbacks.id'],
				],
				'Utilisateurs' => [
					'table' => 'utilisateurs',
					'type' => 'left',
					'conditions' => ['Utilisateurs.id = Feedbacks.utilisateur_id AND Utilisateurs.pays > 0'],
				],
			]);
			$listeannonces->select(["village.name","lieugeo.name","lieugeo.nom_url","Annonces.village","Annonces.id","Annonces.titre","Annonces.surface","Annonces.vue","Annonces.kmstat_id","Annonces.lieugeo_id","Annonces.pieces_nb","Annonces.nature","Annonces.personnes_nb","Annonces.description","Annonces.wifi","Annonces.nb_etoiles","Annonces.batiment","Annonces.etage"]);
			$listeannonces->select([
				'average_rating' => "IF(Utilisateurs.id IS NULL, 0, ROUND(AVG(Ratings.note)))",
			]);
			$listeannonces->where($select);
			$listeannonces->group(['Annonces.id']);

			$annTotal = $this->Annonces->find();
			$annTotal->join([
				'lieugeo' => [
					'table' => 'lieugeos',
					'type' => 'inner',
					'conditions' => ['Annonces.lieugeo_id = lieugeo.id'],
				],
				'Massifs' => [
					'table' => 'massif',
					'type' => 'inner',
					'conditions' => ['Massifs.id = lieugeo.massif_id'],
				],
				'village' => [
					'table' => 'villages',
					'type' => 'inner',
					'conditions' => ['village.id = Annonces.village'],
				],
				'Feedbacks' => [
					'table' => 'feedbacks',
					'type' => 'left',
					'conditions' => ['Annonces.id = Feedbacks.annonce_id', 'Feedbacks.activated = 1'],
				],
				'Ratings' => [
					'table' => 'ratings',
					'type' => 'left',
					'conditions' => ['Ratings.feedback_id = Feedbacks.id'],
				],
				'Utilisateurs' => [
					'table' => 'utilisateurs',
					'type' => 'left',
					'conditions' => ['Utilisateurs.id = Feedbacks.utilisateur_id AND Utilisateurs.pays > 0'],
				],
				]);
				$annTotal->select(["village.name","lieugeo.name","lieugeo.nom_url","Annonces.village","Annonces.id","Annonces.titre","Annonces.surface","Annonces.vue","Annonces.kmstat_id","Annonces.lieugeo_id","Annonces.pieces_nb","Annonces.nature","Annonces.personnes_nb","Annonces.description","Annonces.wifi","Annonces.nb_etoiles","Annonces.batiment","Annonces.etage"]);
				$annTotal->select([
					'average_rating' => "IF(Utilisateurs.id IS NULL, 0, ROUND(AVG(Ratings.note)))",
				]);
				$annTotal->where($select);
				$annTotal->group(['Annonces.id']);
		}

		if($this->request->query['average_rating']) {
			$average_rating = (int)$this->request->query['average_rating'];
			$listeannonces->having(['average_rating >= '.$average_rating]);
			$annTotal->having(['average_rating >= '.$average_rating]);
		}

		// $order[] = "Annonces.updated_at DESC";
		$listeannonces->order($order);
		$annTotal->order($order);
		
		/*** CONDITION PERIODE DU AU ***/
		$avecconditionper = '';
		if(!empty($da_debut) || !empty($da_fin)) {
			$avecconditionper = 'oui';
			$tabAnnoncesAvecPeriode = [];
			
			foreach ($listeannonces as $key) {
				
				//if($joindispos == "oui"){
				//	$key->id = $key['Annonces']['id'];
				//}
				
				/*** DEBUT ***/
				
				$condi = [];
				if($this->request->query['conditionSemaine']){
					$condi[] = "Dispos.conditionnbr = ".$this->request->query['conditionSemaine'];
				}
				if($this->request->query['budgetDe']){
					if($this->request->query['prixbudget'] && $this->request->query['prixbudget'] == 2){
						//Prix Période
						$condi[] = "IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, Dispos.promo_px, Dispos.prix) >= ".$this->request->query['budgetDe'];
					}else if($this->request->query['prixbudget'] && $this->request->query['prixbudget'] == 1){
						//Prix Nuitée
						$condi[] = "IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)) >= ".$this->request->query['budgetDe'];
					}else{
						//Prix Nuitée
						$condi[] = "IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)) >= ".$this->request->query['budgetDe'];
					}
				}
				if($this->request->query['budgetA']){
					if($this->request->query['prixbudget'] && $this->request->query['prixbudget'] == 2){
						//Prix Période
						$condi[] = "IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, Dispos.promo_px, Dispos.prix) <= ".$this->request->query['budgetA'];
					}else if($this->request->query['prixbudget'] && $this->request->query['prixbudget'] == 1){
						//Prix Nuitée
						$condi[] = "IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)) <= ".$this->request->query['budgetA'];
					}else{
						//Prix Nuitée
						$condi[] = "IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)) <= ".$this->request->query['budgetA'];
					}
				}
				if($this->request->query['promotions']){
					$condi[] = "Dispos.promo_yn = 1";
				}
				
				$dispo = $this->Dispos->chercherdisponibilite($key->id, $da_debut, $da_fin, $condi);
				//$dispoCount = $this->Dispos->chercherdisponibiliteCount($key->id, $da_debut, $da_fin, $condi);
				$dispoCount = $dispo->count();
				
				$i = $n = 0;
				$k = 1;
				$fdate = '';
				$ddate = '';
				$tab = [];
				$detail = [];
				$nbrDiff = [];

				foreach ($dispo as $value) {
					
					$i =$i + 1;
					if(new Date($value->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($this->request->query['dbt'])) {
						$dbt = new Date($this->request->query['dbt']);
					}	else {
						$dbt = new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'));
					}
					if(new Date($value->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($this->request->query['fin'])) {
						$fin = new Date($this->request->query['fin']);
					}else {
						$fin = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
					}
					
					if($dispoCount != 1){
						if($fdate != ''){
							$now   = $fdate;
							$clone = clone $now;
							$tet = $clone->modify( '+1 day' );
							$e = $tet->format( 'd-m-Y' );
							if($fdate == new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'))){
								$t = $nbrDiff[$i-1][$i-1];
								$nbrDiff[$i-1][$k] = $n."_".((new Date($ddate))->i18nFormat('dd/MM/yyyy'))."_".((new Date($fdate))->i18nFormat('dd/MM/yyyy'));
								$nbrDiff[$i-1][$k+1] = $value->nbr_jour."_".((new Date($value->dbt_at))->i18nFormat('dd/MM/yyyy'))."_".((new Date($fin))->i18nFormat('dd/MM/yyyy'));
								$detail['debut'][$i-1] = $detail['debut'][$i-1];
								$detail['fin'][$i-1] = $fin;
								$tab[$i-1] = 'Période '.($i-1).' : du '.$detail['debut'][$i-1].' au '.$fin.' <br>';
								$i = $i-1;
								$k = $k + 1;
							}else{
								$nbrDiff[$i][$i] = $value->nbr_jour;
								$detail['debut'][$i] = $dbt;
								$detail['fin'][$i] = $fin;
								$tab[$i] = 'Période '.$i.' : du '.$dbt.' au '.$fin.' <br>';
							}
						}else{
							$nbrDiff[$i][$i] = $value->nbr_jour;
							$detail['debut'][$i] = $dbt;
							$detail['fin'][$i] = $fin;
							$tab[$i] = 'Période '.$i.' : du '.$dbt.' au '.$fin.' <br>';
						}
					}else{
						$nbrDiff[$i][$i] = $value->nbr_jour;
						$detail['debut'][$i] = $dbt;
						$detail['fin'][$i] = $fin;
						$tab[$i] = 'Période '.$i.' : du '.$dbt.' au '.$fin.' <br>';
					}
					$detail['condition'][$i] = $value->conditionnbr;
					$n = $value->nbr_jour;
					$fdate = $fin;
					$ddate = $dbt;
				}
				
				// WHY? What if multiple periods available?
				// if(count($tab) == 1) { 
				// 	$deb = $detail['debut'][1];
				// 	$debCal = new Date($this->request->query['dbt']);
				// 	$fn = $detail['fin'][1];
				// 	$fnCal = new Date($this->request->query['fin']);

				// 	$elim = '';
				// 	$elimCon = '';
				// 	foreach ($nbrDiff[1] as $value2) {
				// 		if(strpos($value2,"_")){
				// 			$tab = explode("_",$value2);
				// 			$dbtDiff = Time::parseDate($tab[1]);
				// 			$fnDiff = Time::parseDate($tab[2]);
				// 			$Diff = $fnDiff->diff($dbtDiff)->days;
				// 			$d = $tab[0];
				// 			if($Diff < $d){
				// 				if($dbtDiff == $deb){
				// 					 $clone = Time::parseDate($tab[2]);
				// 					 $tet = $clone->modify( '+1 day' );
				// 					 $deb = $tet->format( 'Y-m-d' );
				// 				}else{
				// 					$clone = Time::parseDate($tab[1]);
				// 					$tet = $clone->modify('-1 day');
				// 					$fn = $tet->format( 'Y-m-d' );
				// 				}
				// 				$elim = $d;
				// 			}

				// 			if($Diff == 7){
				// 				$clonecl = $detail['debut'][1];
				// 				$fncl = $clonecl->format( 'D' );

				// 				if($detail['condition'][1] == 1 && $fncl != 'Sat'){
				// 					$elimCon = "ui";
				// 				}else if ($detail['condition'][1] == 2 && $fncl != 'Sun'){
				// 					$elimCon = "ui";
				// 				}
				// 			}
				// 		/** IF strpos($value2,"_") **/
				// 		}else{
				// 			$dbtDiff = $detail['debut'][1];
				// 			$fnDiff = $detail['fin'][1];
				// 			$Diff = $fnDiff->diff($dbtDiff)->days;
				// 			$d = $value2;

				// 			if($Diff < $d){
				// 				if($dbtDiff == $deb){
				// 					$clone = $detail['fin'][1];
				// 					$tet = $clone->modify( '+1 day' );
				// 					$deb = $tet->format( 'Y-m-d' );
				// 					// print_r("deb : ".$deb);
				// 				}else{
				// 					$clone = $detail['debut'][1];
				// 					$tet = $clone->modify( '-1 day' );
				// 					$fn = $tet->format( 'Y-m-d' );
				// 					// print_r("fn : ".$fn);
				// 				}
				// 				$elim = $d;
				// 			}
				// 			if($Diff == 7){
				// 				$clonecl = $detail['debut'][1];
				// 				$fncl = $clonecl->format( 'D' );
				// 				if($detail['condition'][1] == 1 && $fncl != 'Sat'){
				// 					$elimCon = "ui";
				// 				}else if ($detail['condition'][1] == 2 && $fncl != 'Sun'){
				// 					$elimCon = "ui";
				// 				}
				// 			}

				// 		 } /*** END ELSE ***/
				// 		} /*** END FOREACH ***/

				// 		if( $elimCon == ''){
				// 			if(($deb == $debCal) && ($fn == $fnCal)){
				// 				if($deb <= $fn){
				// 					// print_r("PERIODE DISPONIBLE");
				// 					$tabAnnoncesAvecPeriode[] = $key->id;
				// 				}
				// 			}
				// 		}

				// 	}/** IF COUNT 1 **/

				//If multiple periods available
				foreach($tab as $i => $t) {
					$deb = $detail['debut'][$i];
					$debCal = new Date($this->request->query['dbt']);
					$fn = $detail['fin'][$i];
					$fnCal = new Date($this->request->query['fin']);

					$elim = '';
					$elimCon = '';
					foreach ($nbrDiff[$i] as $value2) {
						if(strpos($value2,"_")){
							$tab = explode("_",$value2);
							
							$dbtDiff = Time::parseDate($tab[1]);
							$fnDiff = Time::parseDate($tab[2]);
							$Diff = $fnDiff->diff($dbtDiff)->days;
							$d = $tab[0];
							if($Diff < $d){
								if($dbtDiff == $deb){
										$clone = Time::parseDate($tab[2]);
										$tet = $clone->modify( '+1 day' );
										$deb = $tet->format( 'Y-m-d' );
								}else{
									$clone = Time::parseDate($tab[1]);
									$tet = $clone->modify('-1 day');
									$fn = $tet->format( 'Y-m-d' );
								}
								$elim = $d;
							}

							if($Diff == 7){
								$clonecl = $detail['debut'][$i];
								$fncl = $clonecl->format( 'D' );

								if($detail['condition'][$i] == 1 && $fncl != 'Sat'){
									$elimCon = "ui";
								}else if ($detail['condition'][$i] == 2 && $fncl != 'Sun'){
									$elimCon = "ui";
								}
							}
						/** IF strpos($value2,"_") **/
						}else{
							$dbtDiff = $detail['debut'][$i];
							$fnDiff = $detail['fin'][$i];
							$Diff = $fnDiff->diff($dbtDiff)->days;
							$d = $value2;

							if($Diff < $d){
								if($dbtDiff == $deb){
									$clone = $detail['fin'][$i];
									$tet = $clone->modify( '+1 day' );
									$deb = $tet->format( 'Y-m-d' );
									// print_r("deb : ".$deb);
								}else{
									$clone = $detail['debut'][$i];
									$tet = $clone->modify( '-1 day' );
									$fn = $tet->format( 'Y-m-d' );
									// print_r("fn : ".$fn);
								}
								$elim = $d;
							}
							if($Diff == 7){
								$clonecl = $detail['debut'][$i];
								$fncl = $clonecl->format( 'D' );
								if($detail['condition'][$i] == 1 && $fncl != 'Sat'){
									$elimCon = "ui";
								}else if ($detail['condition'][$i] == 2 && $fncl != 'Sun'){
									$elimCon = "ui";
								}
							}

							} /*** END ELSE ***/
						} /*** END FOREACH ***/

						if( $elimCon == ''){
							if(($deb == $debCal) && ($fn == $fnCal)){
								if($deb <= $fn){
									// print_r("PERIODE DISPONIBLE");
									$tabAnnoncesAvecPeriode[] = $key->id;
								}
							}
						}
				} ///End foreach

			} /*** PARCOUR ANNONCES ***/
			/*** END ***/
		}
		/*** END DBT FIN IF ***/
		$listeIds = implode(',', $tabAnnoncesAvecPeriode);
		if($avecconditionper == 'oui' && !empty($listeIds)) {
			$listeannonces->andWhere(['Annonces.id IN ('.$listeIds.')']);
			$annTotal->andWhere(['Annonces.id IN ('.$listeIds.')']);
				
			if($this->request->query['TRI']==1) {
				if($joindispos != "oui") {
					$listeannonces->leftJoinWith('Dispos', function ($q) {
						return $q->where(['Dispos.prix <> 0', 'Dispos.fin_at > NOW()', 'Dispos.statut <> 90']);
					});
					if($da_debut != '' && $da_fin != '') $listeannonces->where([
						'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
					]);
				}
								
				$listeannonces->select(["minprix"=>"MIN(IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)))"]);
				$listeannonces->order(['minprix ASC']);
			}else if($this->request->query['TRI']==2) {
				if($joindispos != "oui"){
					$listeannonces->leftJoinWith('Dispos', function ($q) {
						return $q->where(['Dispos.prix <> 0', 'Dispos.fin_at > NOW()', 'Dispos.statut <> 90']);
					});
					if($da_debut != '' && $da_fin != '') $listeannonces->where([
						'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
					]);
				}
				$listeannonces->select(["minprix"=>"MIN(IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)))"]);
				$listeannonces->order(['minprix DESC']);
			}else if($this->request->query['TRI']==5) {
				$listeannonces->order(['average_rating DESC']);
			} else {
				//Sort by rated highest by holidaymakers who have already booked 
				// and  received / accepted ratio
				$listeannonces->join([
					'_reservations' => [
						'table' => "(SELECT 
								id,
								annonce_id,
								COUNT(id) AS received,
								(SUM(CASE WHEN reservations.statut = '90' THEN 1 ELSE 0 END)) AS accepted 
							FROM reservations GROUP BY annonce_id)",
						'type' => 'left',
						'conditions' => ['_reservations.annonce_id = Annonces.id'],
					],
				]);
				$listeannonces->group(['Annonces.id']);
				$listeannonces->select([
					'ratio' => "ROUND((_reservations.accepted/_reservations.received), 2)"
				]);
				$listeannonces->order(['average_rating DESC', 'ratio DESC']);
			}
			if($nbCouchage > 0) $listeannonces->order(["Annonces.personnes_nb ASC"]);
			$listeannonces->order(["Annonces.updated_at DESC"]);							
			// print_r("<pre>");
			// print_r($listeannonces);
			// print_r("</pre>");
			
		}else if($avecconditionper == 'oui' && empty($listeIds)){
			$annTotal = [];
			$listeannonces = [];
		} else {
			
			if($this->request->query['TRI']==1) {
				if($joindispos != "oui"){
					$listeannonces->leftJoinWith('Dispos', function ($q) {
						return $q->where(['Dispos.prix <> 0', 'Dispos.fin_at > NOW()', 'Dispos.statut <> 90']);
					});
				}
				$listeannonces->andWhere($condi);
				if($da_debut != '' && $da_fin != '') $listeannonces->where([
					'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
				]);
				
				$listeannonces->select(["minprix"=>"MIN(IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)))"]);
				$listeannonces->order(['minprix ASC']);
			}else if($this->request->query['TRI']==2){
				if($joindispos != "oui"){
					$listeannonces->leftJoinWith('Dispos', function ($q) {
						return $q->where(['Dispos.prix <> 0', 'Dispos.fin_at > NOW()', 'Dispos.statut <> 90']);
					});
				}
				$listeannonces->andWhere($condi);
				if($da_debut != '' && $da_fin != '') $listeannonces->where([
					'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
				]);
				
				$listeannonces->select(["minprix"=>"MIN(IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)))"]);
				$listeannonces->order(['minprix DESC']);
			}else if($this->request->query['TRI']==5){
				$listeannonces->order(['average_rating DESC']);
			} else {
				//Sort by rated highest by holidaymakers who have already booked 
				// and  received / accepted ratio
				$listeannonces->join([
					'_reservations' => [
						'table' => "(SELECT 
								id,
								annonce_id,
								COUNT(id) AS received,
								(SUM(CASE WHEN reservations.statut = '90' THEN 1 ELSE 0 END)) AS accepted 
							FROM reservations GROUP BY annonce_id)",
						'type' => 'left',
						'conditions' => ['_reservations.annonce_id = Annonces.id'],
					],
				]);
				$listeannonces->select([
					'ratio' => "ROUND((_reservations.accepted/_reservations.received), 2)"
				]);
				$listeannonces->order(['average_rating DESC', 'ratio DESC']);
			}
			if($nbCouchage > 0) $listeannonces->order(["Annonces.personnes_nb ASC"]);
			$listeannonces->order(["Annonces.updated_at DESC"]);
		}

		$this->paginate = ['limit' => $per_page_total];
		//Get new ads
		if(!empty($listeannonces)) {
			$total_ads = $listeannonces->count();
			$total_pages = ceil($total_ads/$per_page_total);
			
			$per_page_with_new_ads = $per_page_total - 1;

			$new_listeannonces = clone $listeannonces;
			$all_listeannonces = clone $listeannonces;

			$new_listeannonces->where(["Annonces.created_at >= DATE_SUB(CURDATE(),INTERVAL {$this->_new_announces_period} DAY)" ]);
			$new_listeannonces->order('Annonces.updated_at DESC', true);
			$total_new_ads = $new_listeannonces->count();
			
			$total_general_ads = $total_ads - $total_new_ads;
			$total_general_ads_pages = ceil($total_general_ads/$per_page_with_new_ads);
			$total_pages_with_new_ads = min($total_new_ads, $total_general_ads_pages);

			//If new ads > available slots 
			if($total_new_ads > $total_general_ads_pages) {
				//1 per page
				$total_new_ads = $total_general_ads_pages;
				//Total pages recalculate
				$total_ads = $total_general_ads + $total_new_ads;
				$total_pages = ceil($total_ads/$per_page_total);
				$new_listeannonces->limit($total_pages);
			}

			//If all found Annonces are at one page - new adds already included
			if($total_new_ads > 0/* && $total_ads > $per_page_total*/) {
				//Create custom pagination
				//Exclude new ads from Annonces
				$listeannonces->where(["Annonces.created_at < DATE_SUB(CURDATE(),INTERVAL {$this->_new_announces_period} DAY)" ]);
				$annTotal->where(["Annonces.created_at < DATE_SUB(CURDATE(),INTERVAL {$this->_new_announces_period} DAY)" ]);

				$this->paginate = ['limit' => $per_page_with_new_ads];
				
				$current_page = $this->request->query['page'];
				if(empty($current_page)) $current_page = 1;

				$new_listeannonces = $new_listeannonces->toArray();
				
				if(array_key_exists($current_page-1, $new_listeannonces)) {
					//Add one new add
					$new_add = $new_listeannonces[$current_page-1];
					$new_add->new_annonce = 1;
					
					$listeannonces = $this->paginate($listeannonces);
					//Add new add to listings
					$chunked = $listeannonces->chunk(round($per_page_with_new_ads/2))->toList();
					if(isset($chunked[1])) {
						$listeannonces = (new Collection([$chunked[0], [$new_add], $chunked[1]]))->unfold();
					} else {
						$listeannonces = (new Collection([$chunked[0], [$new_add]]))->unfold();
					}
				} else {
					$offset = (($total_pages_with_new_ads * $per_page_with_new_ads) + $per_page_total * ($current_page - 1 - $total_pages_with_new_ads));
					//get custom query
					$listeannonces = $listeannonces->limit($per_page_total)->offset($offset);
					//Fake paginator because it doesn't support CUSTOM offset $%$$^((((
					$this->paginate = ['limit' => $per_page_total];
					$all_listeannonces = $this->paginate($all_listeannonces);
				}
				
				$annTotal = $annTotal->append(array_slice($new_listeannonces, 0, $total_pages ));
				
				$annTotal = $annTotal->toList();

				$this->set('includes_new_annonces', 1);
			} else {
				unset($new_listeannonces);
				$listeannonces = $this->paginate($listeannonces);
			}
		}
		
		$this->set('annTotal', $annTotal);
		$this->set('annonces', $listeannonces);
		$session->write("Recherche",$this->request->query);

		//$this->set('avecdispoval', false/*$joindispos*/);
		/*** MINIMUM PRIX ANNONCES ***/
		$minprixannonce = [];
		$noteglobalmoytab = [];
		$prixtotalpourpetiteannonce = [];
		foreach ($annTotal as $key ) {
			
			// if($joindispos == "oui"){
			// 	$key->id = $key['Annonces']['id'];
			// }
			$minprixannonce[$key->id]['prixmin'] = '';
			$minprixannonce[$key->id]['prixminvalue'] = 0;
			if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($key->id, $da_debut, $da_fin, $condi);
				else $tousperiodes = $this->Dispos->find('all', array(
					'conditions' => array('Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0', $condiPrixMin),
					'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

			$promoval = 0;
			foreach ($tousperiodes as $value) {
				if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at)))
				{
					if($value->prix_jour == 0){
						$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
						$prix_jour = $value->prix/$nbrDiff;
					}else{
						$prix_jour = $value->prix_jour;
					}

					if($value->promo_yn == 0){
						if(($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']) && ($prix_jour > 0)){
							$minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
															$minprixannonce[$key->id]['prixminvalue'] = round($prix_jour, 2);
						}
					}else{
						if($promoval == 0) $promoval = 1;
						if($value->promo_jour == 0){
							$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
							$promo_jour = $value->promo_px/$nbrDiff;
						}else{
							$promo_jour = $value->promo_jour;
						}
													if($promo_jour < $prix_jour){
															if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] )
																{ 
																$minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
																$minprixannonce[$key->id]['prixminvalue'] = round($promo_jour, 2);
																}
						}else{
															if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] )
																{
																$minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
																$minprixannonce[$key->id]['prixminvalue'] = round($prix_jour, 2);
																}
						}
					}
				}
				} /** Fin parcour periodes **/
				// Promo ou non
				$minprixannonce[$key->id]['promo'] = $promoval;
						//Liste Feedbacks
						$listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
						// Notes Globales
						$notecara = [];
						foreach ($listerating as $keyval) {
							foreach ($keyval['ratings'] as $valueval) {
									$notecara[$valueval->caracteristique] += $valueval->note;
							}
						}

			if($listerating->count() != 0) $noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count()); 
			else $noteglobalmoy = 0;
			round(($noteglobalmoy/3), 1)>-1?$noteAVG=round(($noteglobalmoy/3), 1):$noteAVG=-1;
						$noteglobalmoytab[$key->id] = $noteAVG;
			
			// recuperer prix total
			if($da_debut != '' && $da_fin != ''){
				if(isset($this->request->query['nbCouchage_ad']) && isset($this->request->query['nbCouchage_enf'])){
					if($this->request->query['nbCouchage_ad'] != 0) $nbradulte = $this->request->query['nbCouchage_ad'];
					else $nbradulte = 1;
					$nbrenfant = $this->request->query['nbCouchage_enf'];
				}else{
					$nbradulte = 1;
					$nbrenfant = 0;
				}
				$prixtotalpourpetiteannonce[$key->id] = (new DisposController())->prixtotalpourpetiteannonce($key->id, $da_debut."/".$da_fin, $nbradulte, $nbrenfant);
			} 
		} /** Fin parcour annonces **/
		$this->set('prixtotalpourpetiteannonce', $prixtotalpourpetiteannonce);
		if($this->request->query['TRI']==5) arsort($noteglobalmoytab);
						
		$this->set('noteglobalmoy', $noteglobalmoytab);

		if($this->request->query['TRI']==1){
			//asort($minprixannonce);
				uasort($minprixannonce, function ($item1, $item2) {
					if ($item1['prixminvalue'] == $item2['prixminvalue']) {
						return 0;
						}
						return ($item1['prixminvalue'] < $item2['prixminvalue']) ? -1 : 1;
		});
		}elseif($this->request->query['TRI']==2){
			//arsort ($minprixannonce);
				uasort($minprixannonce, function ($item1, $item2) {
					if ($item1['prixminvalue'] == $item2['prixminvalue']) {
						return 0;
						}
						return ($item1['prixminvalue'] > $item2['prixminvalue']) ? -1 : 1;
				});
		}                                
		$this->set('minprixannonce',$minprixannonce);

		$a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
		$this->set("l_distances",$a_distance);

		$images=$this->Images->find()->where(['Images.visible = 1']);
		$this->set("images",$images);
		$photos=$this->Photos->find("all",["order"=>"Photos.numero"]);
		foreach($photos as $e)  $ar_ph[$e->annonce_id][]=$e->numero;
		$this->set("photos",$ar_ph);

		$a_lieu=$this->Lieugeos->find("list",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"])->toArray();
		$this->set("a_lieugeos",$a_lieu);

		$this->loadModel("Massif");
		$stations = $this->Massif->find("all")->contain('Lieugeos', function ($q) {
			return $q
					->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id"])
					->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		})->matching('Lieugeos', function ($q) {
			return $q
					->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id"])
					->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		})->group(['Massif.id'])->order(['Massif.nom']);
		$this->set("stations",$stations);
		
		$this->loadModel("Villages");
		$listevillageann = $this->Villages->find()->join([
			'Annonces' => [
				'table' => 'annonces',
				'type' => 'inner',
				'conditions' => ['Villages.id = Annonces.village', "Annonces.statut = 50"],
			]
		])->group(['Villages.id'])->order(['Villages.name']);
		$this->set("listevillageann",$listevillageann);
	
		$this->loadModel("Media");
		$mediabanner = $this->Media->find('translations', ['locales' => [$session->read('Config.language')]])->where(['name_key = "banner_recherche_desktop"']);
		$this->set("mediabanner",$mediabanner->first());
		
		$mediabannermobile = $this->Media->find('translations', ['locales' => [$session->read('Config.language')]])->where(['name_key = "banner_recherche_mobile"']);
		$this->set("mediabannermobile",$mediabannermobile->first());

		//Get Parking types
		$parking_types = $this->Annonces->getParkingTypes();
		$parking_types = [NULL => "Tous"] + $parking_types;
		foreach($parking_types as &$pt) {
			$pt = __($pt);
		}
		$this->set("parking_types", $parking_types);
	}
   /**
	  *
		**/
	 public function viewprev($id = null,$send=null){
		if (!$id) {
			return $this->redirect(['action' => 'landing']);
  	}
		$this->loadModel("Clics");
		$clics=$this->Clics->find('all',['conditions'=>['Clics.annonce_id'=>(int)$id,"Clics.clic_at"=>date("Y-m-d")]]);
		if($clics->first()){
			$clic=$clics->first();
			$clic->clic_nb=$clic->clic_nb+1;
			$this->Clics->save($clic);
		}else{
			$s_data=array('annonce_id'=>(int)$id,'clic_nb'=>1,'clic_at'=>$this->toDate(date('d-m-Y')));
			$clic = $this->Clics->newEntity($s_data);
			$this->Clics->save($clic);
		}
		$session = $this->request->session();
		$session->delete('Reseservation.key');

  	$annonce = $this->Annonces->get($id, ['contain' => [] ]);
		$an = $annonce->toArray();
		if($an['statut'] != 50){
			if(empty($session->read('Gestionnaire.info'))){
				if(empty($session->read('Auth.User.id'))) return $this->redirect(['action' => 'landing']);
				else if($an['proprietaire_id'] != $session->read('Auth.User.id')) $this->redirect(['action' => 'landing']);
			}
		}
		$photo=$this->Photos->find('all',['conditions'=>['Photos.annonce_id'=>$id],'limit'=>10]);
		$this->set('photos', $photo);
		$this->set('l_natures_parking',['0'=>'Non','1'=>'Oui','2'=>'Privatif']);
		$a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
    $this->set('l_distances',$a_distance);
    $this->set("l_disposstatuts",['0'=>'Libre','50'=>'Option','90'=>'Réservé']);
    $enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
    $ar[]="";
    foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
    // $this->set("l_lieugeos",$ar);
		$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
    $this->set("l_nombre_personnes",$a_personne);

		$id=(int)$id;
		if(!empty($annonce->b_title))  $this->set('title_for_layout',html_entity_decode($annonce->b_title));
		else  $this->set('title_for_layout',"Locations de vacances et services de conciergerie");
		$this->set('send', $send);
		$this->set('description',html_entity_decode($annonce->m_description));
		$ann=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50"],'contain' => ['Lieugeos'],"order"=>"Annonces.updated_at desc","limit"=>7])->toArray();
		$this->set('annonces', $ann);
    $this->set('annonces_modif', $this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50"],"order"=>"Annonces.updated_at desc","limit"=>28]));
		$this->set("lieugeo",$this->Lieugeos->get($annonce->lieugeo_id, ['contain' => [] ]));
		if($annonce->batiment != NULL && $annonce->batiment != 0){
			$residenceAnn = $this->Residences->find('all')->where(['id' => $annonce->batiment]);
			if($residenceAnn->first()) $this->set("residence",$residenceAnn->first());
			else $this->set("residence","");
		} else {
			$this->set("residence","");
		}
		$this->set('dispos', $this->Dispos->find('all',["conditions"=>["Dispos.annonce_id"=>$id,"Dispos.dbt_at >= '".date("Y-m-d")."'"],"order"=>"Dispos.dbt_at asc"]));
		$this->set('annonce', $annonce);
    $this->set('_serialize', ['annonce']);
	}
	/**
	 * 
	 */
	public function redirectionNewView($id = null,$debutrech=null,$finrech=null)
	{
		$session = $this->request->session();
		if($session->read('Config.language') != "fr_FR"){
			$this->loadModel("Languages");
			$language_header_name = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();
			$urlLang = $language_header_name->url_code."/";
		} else {
			$urlLang = "";
		}
		$this->loadModel("Urlmultilingue");
        $urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
        $urlvaluemulti = [];
        foreach ($urlmultilinguelistes as $urlmultilingueliste) {
            $urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
        }
		$path = Router::url('/', true).$urlLang;
		$annonce=$this->Annonces->get($id, ['contain' => ['Lieugeos']]);
		$natureAnnURL = array("STD"=>__("studio"),"APP"=>__("appartement"),"CHA"=>__("chalet"),"DIV"=>__("location"),"VIL"=>__("villa"),"GIT"=>__("gite"));
		$lannonce = $this->string2url($annonce["titre"]);
		$hrefDetailAnn = $urlvaluemulti['station'].'/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;
		return $this->redirect($path.$hrefDetailAnn);
	}
  /**
   * View method
   *
   * @param string|null $id Annonce id.
   * @return \Cake\Network\Response|null
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function view($id = null,$debutrech=null,$finrech=null,$nbradlt=null,$nbrenf=null,$animaux=null){
    if (!$id) {
        return $this->redirect(['action' => 'landing']);
    }

    $m = 1000;
    $residenceAnnonce = [];
    $this->loadModel("Residences");
    $residences=$this->Residences->find('all')->contain(['Bibliotheques']);
	//    print_r($residences->toArray());
    foreach ($residences as $value) {
        if($value->bibliotheque_id == 1 || $value->bibliotheque_id == 7){
                $residenceAnnonce[$value->id]["lat"] = $value->latitude;
                $residenceAnnonce[$value->id]["lon"] = $value->longitude;
                $residenceAnnonce[$value->id]["title"] = $value->name;
        }else{
                $residenceAnnonce[$m]["lat"] = $value->latitude;
                $residenceAnnonce[$m]["lon"] = $value->longitude;
                $residenceAnnonce[$m]["title"] = $value->name;
                $residenceAnnonce[$m]["bibliotheque"] = $value['bibliotheque']['name'];
                $residenceAnnonce[$m]["imgbibliotheque"] = $value['bibliotheque']['image'];
                $m++;
        }
	//            $residenceAnnonce[$value->id] = $value->name;
    }
    $this->set('residenceAnnonce', $residenceAnnonce);
    /* Models Mails systeme */
    $mail = [];
    $this->loadModel("Modelmailsysteme");
    $textEmail = $this->Modelmailsysteme->find('all');
    foreach ($textEmail as $key => $value) {
            $mail[$value->titre] = $value->txtmail;
    }
    $this->set("textmail",$mail);

    $prop = $this->Annonces->chercheannonceprop($id);
    $this->set('propdetail', $prop->first());

    $this->loadModel("Clics");
    $clics=$this->Clics->find('all',['conditions'=>['Clics.annonce_id'=>(int)$id,"Clics.clic_at"=>date("Y-m-d")]]);
    if($clics->first()){
            $clic=$clics->first();
            $clic->clic_nb=$clic->clic_nb+1;
            $this->Clics->save($clic);
    }else{
            $s_data=array('annonce_id'=>(int)$id,'clic_nb'=>1,'clic_at'=>$this->toDate(date('d-m-Y')));
            $clic = $this->Clics->newEntity($s_data);
            $this->Clics->save($clic);
    }
    $session = $this->request->session();
    $session->delete('Reseservation.key');
    $annonce = $this->Annonces->get($id, ['contain' => ['Villages', 'Lieugeos'=>'Massif'] ]);
    $an = $annonce->toArray();
    if($an['statut'] != 50){
            if(empty($session->read('Gestionnaire.info'))){
                    if(empty($session->read('Auth.User.id'))) return $this->redirect(['action' => 'landing']);
                    else if($an['proprietaire_id'] != $session->read('Auth.User.id')) $this->redirect(['action' => 'landing']);
            }
    }
    $photo=$this->Photos->find('all',['conditions'=>['Photos.annonce_id'=>$id],'limit'=>20])->order(['Photos.numero' => 'ASC']);
    $photos=$this->Photos->find("all")->order(['Photos.numero' => 'ASC']);
    foreach($photos as $e)  $ar_ph[$e->annonce_id][]=$e->numero;
    $this->set("photosCont",$ar_ph);

    $this->set('l_natures_parking',['0'=>'Non','1'=>'Oui','2'=>'Privatif']);
    $a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
    $this->set('l_distances',$a_distance);

    $this->set("l_disposstatuts",['0'=>'Libre','50'=>'Option','90'=>'Réservé']);
    $enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
    $ar[]="";
    foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
    // $this->set("l_lieugeos",$ar);

    $a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
    $this->set("l_nombre_personnes",$a_personne);

    $id=(int)$id;
    if(!empty($annonce->b_title))  $this->set('title_for_layout',html_entity_decode($annonce->b_title));
    else  $this->set('title_for_layout',"Locations de vacances et services de conciergerie");
	//    $this->set('send', $send);
    $this->set('description',html_entity_decode($annonce->m_description));
    $ann=$this->Annonces->find('all',["conditions"=>["Annonces.id <>"=>$id, "Annonces.statut"=>"50", "Annonces.lieugeo_id = "=>$annonce->lieugeo_id, "Annonces.nature = "=>$annonce->nature, "Annonces.personnes_nb >= "=>$annonce->personnes_nb],'contain' => ['Lieugeos'=>'Massif','Villages'],"order"=>["Annonces.personnes_nb"=>"ASC","Annonces.updated_at"=>"DESC"],"limit"=>4])->toArray();
	$similaire = "lieugeo=".$annonce->lieugeo_id."&".strtolower($annonce->nature)."=1&nbCouchage=".$annonce->personnes_nb;
	if(count($ann) == 0){
		$ann=$this->Annonces->find('all',["conditions"=>["Annonces.id <>"=>$id, "Annonces.statut"=>"50", "Annonces.nature = "=>$annonce->nature, "Annonces.personnes_nb >= "=>$annonce->personnes_nb],'contain' => ['Lieugeos'=>'Massif','Villages'],"order"=>["Annonces.personnes_nb"=>"ASC","Annonces.updated_at"=>"DESC"],"limit"=>4])->toArray();
		$similaire = strtolower($annonce->nature)."=1&nbCouchage=".$annonce->personnes_nb;
	} 
	// $this->set('annonces', $ann);
	$this->set('similaire', $similaire);

	// annonces with new orders
	$allannonceswithperiod = $this->Annonces->getAllAnnoncesWithPeriod($annonce->lieugeo_id, $annonce->nature, null, $annonce->personnes_nb)->where(["Annonces.id <>"=>$id])->limit(4);
	if($allannonceswithperiod->count() < 4){
		$allannonces = $this->Annonces->getAllAnnonces($annonce->lieugeo_id);
		if($allannonces->count() >= 4){
			$countlimit = 4-$allannonceswithperiod->count();
			$allannonceswithoutperiod = $this->Annonces->getAllAnnoncesWithoutPeriod($annonce->lieugeo_id, $annonce->nature, null, $annonce->personnes_nb)->where(["Annonces.id <>"=>$id])->limit($countlimit);
			// $allannonceswithperiod->union($allannonceswithoutperiod);
		}
	}
	$this->set('annonces', $allannonceswithperiod);

    $this->loadModel("Feedbacks");
    /*** MINIMUM PRIX ANNONCES ***/
    $minprixannonce = [];
    $noteglobalmoytab = [];
	$prixtotalpourpetiteannonce = [];
    // $condi = ["Annonces.statut"=>"50", "Annonces.lieugeo_id = "=>$annonce->lieugeo_id, "Annonces.nature = "=>$annonce->nature, "Annonces.personnes_nb >= "=>$annonce->personnes_nb];
    foreach ($allannonceswithperiod as $key ) {
            $minprixannonce[$key->id]['prixmin'] = '';
            // if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($key->id, '', '', $condi);
            // else 
			$tousperiodes = $this->Dispos->find('all', array(
                            'conditions' => array('Dispos.annonce_id' => $key->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0', 'Dispos.prix_jour <> 0'),
                            'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

            foreach ($tousperiodes as $value) {
                    if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at)))
                    {
                            if($value->prix_jour == 0){
                                    $nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
                                    $prix_jour = $value->prix/$nbrDiff;
                            }else{
                                    $prix_jour = $value->prix_jour;
                            }

                            if($value->promo_yn == 0){
                                    if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin']){
                                            $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
                                    }
                            }else{
                                    if($value->promo_jour == 0){
                                            $nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
                                            $promo_jour = $value->promo_px/$nbrDiff;
                                    }else{
                                            $promo_jour = $value->promo_jour;
                                    }
                                    if($promo_jour < $prix_jour){
                                            if($minprixannonce[$key->id]['prixmin'] == '' || $promo_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($promo_jour, 2)." € ";
                                    }else{
                                            if($minprixannonce[$key->id]['prixmin'] == '' || $prix_jour < $minprixannonce[$key->id]['prixmin'] ) $minprixannonce[$key->id]['prixmin'] = round($prix_jour, 2)." € ";
                                    }
                            }
                    }
             } /** Fin parcour periodes **/
        //Liste Feedbacks
        $listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$key->id, "activated = 1"]);
        // Notes Globales
        $notecara = [];
        foreach ($listerating as $keyval) {
            foreach ($keyval['ratings'] as $valueval) {
                    $notecara[$valueval->caracteristique] += $valueval->note;
            }
        }

		if($listerating->count() != 0){
			$noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
        	$noteglobalmoytab[$key->id] = round(($noteglobalmoy/3), 1);
		}else{
			$noteglobalmoy = 0;
			$noteglobalmoytab[$key->id] = 0;
		}
        
		// recuperer prix total
		if($debutrech != '' && $finrech != ''){
			if($nbradlt != null && $nbrenf != null){
				if($nbradlt != 0) $nbradulte = $nbradlt;
				else $nbradulte = 1;
				$nbrenfant = $nbrenf;
			}else{
				$nbradulte = 1;
				$nbrenfant = 0;
			}
			$prixtotalpourpetiteannonce[$key->id] = (new DisposController())->prixtotalpourpetiteannonce($key->id, $debutrech."/".$finrech, $nbradulte, $nbrenfant);
		} 

	} /** Fin parcour annonces **/
	//     print_r($noteglobalmoytab);
	//     exit;
    $this->set('noteglobalmoytab', $noteglobalmoytab);
    $this->set('minprixannonce',$minprixannonce);
    $this->set('prixtotalpourpetiteannonce',$prixtotalpourpetiteannonce);


    $this->set('annonces_modif', $this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50"],"order"=>"Annonces.updated_at desc","limit"=>28]));
    $this->set("lieugeo",$this->Lieugeos->get($annonce->lieugeo_id, ['contain' => [] ]));
    if($annonce->batiment != NULL && $annonce->batiment != 0){
		$residenceAnn = $this->Residences->find('all')->contain(['Villages'=>'Lieugeos'])->where(['Residences.id' => $annonce->batiment]);
		if($residenceAnn->first()) $this->set("residence",$residenceAnn->first());
		else $this->set("residence","");
	} else {
		$this->set("residence","");
	}
    $this->set('dispos', $this->Dispos->find('all',["conditions"=>["Dispos.annonce_id"=>$id,"Dispos.dbt_at >= '".date("Y-m-d")."'"],"order"=>"Dispos.dbt_at asc"]));
    $this->set('photos', $photo);
    $this->set('annonce', $annonce);
    if($annonce->pays==67&&$annonce->pays>0){
        $this->loadModel('Frvilles');
        $this->set('ville',$this->Frvilles->get($annonce->ville));
        $this->loadModel('Departements');
        $reg = $this->Departements->find()->where(['id'=>$annonce->region]);
		if($reg->first()) $reg = $reg->first();
		else $reg = "";
        $this->set('region',$reg);
    }
    elseif($annonce->pays!=67&&$annonce->pays>0){
        $this->loadModel('Pvilles');
        $this->set('ville',$this->Pvilles->get($annonce->ville));
    }
    $this->set('_serialize', ['annonce']);
    // Liste locataires qui ont passé séjour à cette annonce
    $this->loadModel("Reservations");
    $listlocatairesannonce = $this->Reservations->find()->where(["annonce_id = ".$id, "statut = 90"])->select(["utilisateur_id"]);
    foreach ($listlocatairesannonce as $value) {
            $listlocataires[] = $value->utilisateur_id;
    }
    $this->set('listlocataires', $listlocataires);
    $this->loadModel("Feedbackresponses");
	// Vérifier si le locataire connecté a déjà noté l'annonce		
    $this->loadModel("Feedbacks");
	$locnote = $this->Feedbacks->find()->where(["annonce_id = ".$id, "utilisateur_id = ".$session->read('Auth.User.id')]);
	$this->set('locnote', $locnote);
	if(isset($this->request->query['token'])){
		$locnotetoken = $this->Feedbacks->find()->where(["annonce_id = ".$id, "utilisateur_id = ".$this->request->query['token']]);
		$this->set('locnotetoken', $locnotetoken);
	}
    // Vérifier que le locataire a une moin une réservation pour cette annonce (non en option)
    $this->loadModel("Dispos");
    $statutreservation = $this->Dispos->find()->where(["Dispos.annonce_id = ".$id, "Dispos.statut = 90", "Dispos.utilisateur_id = ".$session->read('Auth.User.id')]);
	$this->set('statutreservation', $statutreservation);
	if(isset($this->request->query['token'])){
		$statutreservationtoken = $this->Dispos->find()->where(["Dispos.annonce_id = ".$id, "Dispos.statut = 90", "Dispos.utilisateur_id = ".$this->request->query['token']]);
		$this->set('statutreservationtoken', $statutreservationtoken);
	}
    //Liste Feedbacks
    $listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$id, "activated = 1"])->order(['Feedbacks.created DESC']);
    $this->set('listerating', $listerating);
	// Notes Globales
	$notecara = [];
    foreach ($listerating as $key) {
        $notecommentaire = 0;
        foreach ($key['ratings'] as $value) {
                $notecara[$value->caracteristique] += $value->note;
                $notecommentaire += $value->note;
        }
        $notecommentaireuser[$key->id] = $notecommentaire;
        // Chercher s'il y a une réponse
        $reponse = $this->Feedbackresponses->find()->where(["feedback_id = ".$key->id]);
        if($reponse->first()) $reponsefeedback[$key->id] = $reponse->first();
        else $reponsefeedback[$key->id] = "";
		// Chercher la date de réservation
		$reservationDate = $this->Reservations->find("all")->where(['annonce_id' => $key->annonce_id, 'utilisateur_id' => $key->utilisateur_id])->order(['dbt_at' => 'DESC'])->first();
		$reservationDateFeed[$key->id] = $reservationDate;
	}
    $this->set('reponsefeedback', $reponsefeedback);
    $this->set('notecara', $notecara);
    $this->set('notecommentaireuser', $notecommentaireuser);
    $this->set('reservationDate', $reservationDateFeed);
    // Propriétaire de l'annonce
    $this->loadModel("Utilisateurs");
    $propannonce = $this->Utilisateurs->get($annonce->proprietaire_id, ['contain'=>['Cautions', 'Paiements', 'Annulations']]);
    $this->set('propannonce', $propannonce);
	// Liste règle annulation
	$this->loadModel("Annulations");
	$annulations = $this->Annulations->find()->where(['name' => $propannonce->annulations[0]->name])->order(['interval_1 DESC']);
	$msgretour = "";
	foreach ($annulations as $annulation) {
		if($annulation->interval_1 == 0){
			$msgretour .= "<p> - ".__("Moins de {0} jours avant la date d'arrivée : {1} % du montant du séjour seront retenus", [$annulation->interval_2, $annulation->reservation_pourc])."</p>";
		}else if($annulation->interval_2 == 100){
			if($annulation->reservation_pourc == 0) $msgretour .= "<p> - ".__("Plus de {0} jours avant la date d'arrivée : Sans frais", [$annulation->interval_1])."</p>";
			else $msgretour .= "<p> - ".__("Plus de {0} jours avant la date d'arrivée : {1} % du montant du séjour seront retenus", [$annulation->interval_1, $annulation->reservation_pourc])."</p>";
		}else{
			$msgretour .= "<p> - ".__("Entre {0} et {1} jours avant la date d'arrivée : {2} % du montant du séjour seront retenus", [$annulation->interval_1, $annulation->interval_2, $annulation->reservation_pourc])."</p>";
		} 
	}
	$msgretour .= "<p>".__("Remboursement à 100% de la taxe de séjour. Les frais de service ne sont pas remboursés.")."</p>";
	$this->set('propannonceannulation', $msgretour);
    $this->set('debutrech', $debutrech);
	$this->set('finrech', $finrech);
	$this->set('nbradlt', $nbradlt);
	$this->set('nbrenf', $nbrenf);
	$this->set('animaux', $animaux);
	
	// Min prix
	$annTotal = $this->Annonces->get($id, ['contain' => ['lieugeos'] ]);
	/*** MINIMUM PRIX ANNONCES ***/
	$minprixannoncedetail = [];
		$minprixannoncedetail[$id]['prixmin'] = '';
		if($debutrech != '') $da_debut = new Date($debutrech);
		if($finrech != '') $da_fin = new Date($finrech);
		if($debutrech != '' && $finrech != '') $tousperiodes = $this->Dispos->chercherdisponibilite($id, $da_debut->i18nFormat('yyyy-MM-dd'), $da_fin->i18nFormat('yyyy-MM-dd'));
		else $tousperiodes = $this->Dispos->find('all', array(
						'conditions' => array('Dispos.annonce_id' => $id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0'),
						'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

			foreach ($tousperiodes as $value) {
					if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at)))
					{
							if($value->prix_jour == 0){
									$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
									$prix_jour = $value->prix/$nbrDiff;
							}else{
									$prix_jour = $value->prix_jour;
							}

							if($value->promo_yn == 0){
									if($minprixannoncedetail[$id]['prixmin'] == '' || $prix_jour < $minprixannoncedetail[$id]['prixmin']){
											$minprixannoncedetail[$id]['prixmin'] = round($prix_jour, 2)." € ";
									}
							}else{
									if($value->promo_jour == 0){
											$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
											$promo_jour = $value->promo_px/$nbrDiff;
									}else{
											$promo_jour = $value->promo_jour;
									}
									if($promo_jour < $prix_jour){
											if($minprixannoncedetail[$id]['prixmin'] == '' || $promo_jour < $minprixannoncedetail[$id]['prixmin'] ) $minprixannoncedetail[$id]['prixmin'] = round($promo_jour, 2)." € ";
									}else{
											if($minprixannoncedetail[$id]['prixmin'] == '' || $prix_jour < $minprixannoncedetail[$id]['prixmin'] ) $minprixannoncedetail[$id]['prixmin'] = round($prix_jour, 2)." € ";
									}
							}
					}
			 } /** Fin parcour periodes **/


	// recuperer prix total
	$prixtotalpourpetiteannoncedetail = [];
	if($debutrech != '' && $finrech != ''){
		if($nbradlt != null && $nbrenf != null){
			if($nbradlt != 0) $nbradulte = $nbradlt;
			else $nbradulte = 1;
			$nbrenfant = $nbrenf;
		}else{
			$nbradulte = 1;
			$nbrenfant = 0;
		}
		$prixtotalpourpetiteannoncedetail[$id] = (new DisposController())->prixtotalpourpetiteannonce($id, $debutrech."/".$finrech, $nbradulte, $nbrenfant);
	} 
	$this->set('prixtotalpourpetiteannoncedetail',$prixtotalpourpetiteannoncedetail);
	$this->set('minprixannoncedetail',$minprixannoncedetail); 

	//  Liste annonces de meme résidence dans le cas de propriétaire-résidence
	if($propannonce->nature == "PRES"){
		$annoncepropres = $this->Annonces->find("all")->contain(['Lieugeos'])->where(['Annonces.id <> ' => $id,'Annonces.proprietaire_id' => $propannonce->id, 'Annonces.batiment' => $annTotal->batiment, 'Annonces.statut' => 50])->limit(4);
		// $annoncepropres = $this->Annonces->find("all")->contain(['Lieugeos'])
		// ->join([
		// 	'Dispos' => [
        //         'table' => 'dispos',
        //         'type' => 'inner',
        //         'conditions' => ['Dispos.annonce_id=Annonces.id', 'Dispos.dbt_at > CURDATE()'],
        //     ]
		// ])
		// ->where(['Annonces.id <> ' => $id,'Annonces.batiment' => $annTotal->batiment])->limit(4)->order(['Annonces.id DESC'])->group(['Annonces.id']);
		$this->set('annoncepropres',$annoncepropres);
		$minprixannonceres = [];
		$listeidannonceres = [];
			/*** MINIMUM PRIX ANNONCES ***/	
			$prixtotalpourpetiteannonceres = [];		
			foreach ($annoncepropres as $keyres ) {
				$minprixannonceres[$keyres->id]['prixmin'] = '';
				if($debutrech != '') $da_debut = new Date($debutrech);
				if($finrech != '') $da_fin = new Date($finrech);
				if($debutrech != '' && $finrech != '') $tousperiodes = $this->Dispos->chercherdisponibilite($keyres->id, $da_debut->i18nFormat('yyyy-MM-dd'), $da_fin->i18nFormat('yyyy-MM-dd'));
				else $tousperiodes = $this->Dispos->find('all', array(
								'conditions' => array('Dispos.annonce_id' => $keyres->id, 'Dispos.fin_at > NOW()', 'Dispos.statut = 0',$condiPrixMin),
								'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));
		
				foreach ($tousperiodes as $value) {
					if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at)))
					{
						if($value->prix_jour == 0){
							$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
							$prix_jour = $value->prix/$nbrDiff;
						}else{
							$prix_jour = $value->prix_jour;
						}

						if($value->promo_yn == 0){
							if($minprixannonceres[$keyres->id]['prixmin'] == '' || $prix_jour < $minprixannonceres[$keyres->id]['prixmin']){
									$minprixannonceres[$keyres->id]['prixmin'] = round($prix_jour, 2)." € ";
							}
						}else{
							if($value->promo_jour == 0){
								$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
								$promo_jour = $value->promo_px/$nbrDiff;
							}else{
								$promo_jour = $value->promo_jour;
							}
							if($promo_jour < $prix_jour){
								if($minprixannonceres[$keyres->id]['prixmin'] == '' || $promo_jour < $minprixannonceres[$keyres->id]['prixmin'] ) $minprixannonceres[$keyres->id]['prixmin'] = round($promo_jour, 2)." € ";
							}else{
								if($minprixannonceres[$keyres->id]['prixmin'] == '' || $prix_jour < $minprixannonceres[$keyres->id]['prixmin'] ) $minprixannonceres[$keyres->id]['prixmin'] = round($prix_jour, 2)." € ";
							}
						}
					}
				} /** Fin parcour periodes **/
				// recuperer prix total		
				if($debutrech != '' && $finrech != ''){
					if($nbradlt != null && $nbrenf != null){
						if($nbradlt != 0) $nbradulte = $nbradlt;
						else $nbradulte = 1;
						$nbrenfant = $nbrenf;
					}else{
						$nbradulte = 1;
						$nbrenfant = 0;
					}
					$prixtotalpourpetiteannonceres[$keyres->id] = (new DisposController())->prixtotalpourpetiteannonce($keyres->id, $debutrech."/".$finrech, $nbradulte, $nbrenfant);
				} 	

				$listeidannonceres[] = $keyres->id;
			} /** Fin parcour annonces **/
		$this->set('prixtotalpourpetiteannonceres',$prixtotalpourpetiteannonceres);	
		$this->set('minprixannonceres',$minprixannonceres);
		$this->set('listeidannonceres',$listeidannonceres);
		
	}
	// chercher si l'annonce est en contrat avec gestionniare
	$encontrat = "noncontrat";
	if($annTotal->contrat == 1){
		$this->loadModel("Contrats");
		$contratannonce = $this->Contrats->find("all")->where(['annonce_id' => $annTotal->id, 'visible=1']);
		if($contratannonce->first()){
			$encontrat = "ouicontrat";
		}
	}
	$this->set('encontrat',$encontrat);
  }


	function getimage($id=null){
		$this->viewBuilder()->layout(false);
		$annonce = $this->Annonces->get($id);
		$photo=$this->Photos->find('all',['conditions'=>['Photos.annonce_id'=>$id],'limit'=>10])->order(['Photos.numero' => 'ASC']);
		$this->set('utilsateur',$this->Utilisateurs->get($annonce->proprietaire_id));
    $this->set('annonce', $photo);
	}


	function detail($id=null){
		$annonce = $this->Annonces->get($id, ['contain' => [] ]);
		$this->set('annonce', $annonce);
		$this->set('l_natures_parking',['0'=>'Non','1'=>'Oui','2'=>'Privatif']);
		$a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
    $this->set('l_distances',$a_distance);
    $this->set("l_disposstatuts",['0'=>'Libre','50'=>'Option','90'=>'Réservé']);
		$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
    $this->set("l_nombre_personnes",$a_personne);
	}
	/**
	 * 
	 */
	public function checkAppartementUnique($numapp = null, $batiment = null, $nature = null)
	{
		$this->loadModel('Annonces');
		$ann=$this->Annonces->find('all',["conditions"=>["Annonces.num_app"=>$numapp,"Annonces.batiment"=>$batiment, "Annonces.statut <> 40"]]);
		if(($nature=="STD" || $nature=="APP") && $ann->first()) echo 'false';
		else echo 'true';
		die();
	}
	/**
	 * 
	 */
	public function checkEmailUnique($id = null,$requestedEmail = null)
	{
		$this->loadModel('Utilisateurs');
		if($id=="null"){
			$user=$this->Utilisateurs->find()->where(['LOWER(email) LIKE ' => '%'.strtolower($requestedEmail).'%'])->first();
				if($user==null)  echo 'true';
				else echo 'false';
			die();
		}
		$utilisateur = $this->Utilisateurs->get($id);
		if(strtolower($utilisateur->email)==strtolower($requestedEmail)) {echo 'true'; die();}
		else {
			$user=$this->Utilisateurs->find()->where(['LOWER(email) LIKE ' => '%'.strtolower($requestedEmail).'%'])->first();
			if($user==null)  echo 'true';
			else echo 'false';
		}
		die();
	}
	/**
	 * 
	 */
	public function addnewsteps()
	{
		// print_r($this->request->data);
		// print_r($this->Recaptcha->verify());
		// exit;
		$this->viewBuilder()->layout(false);
		$this->autoRender = false;
		// if ($this->request->is('post')) {
		$msgerreur = "";
		$annonceid = 0;
		$nbrimages = 0;
		$nbrdispo = 0;
		$numenregistrement = "";
		$justifdomicile = "";
		$ann=$this->Annonces->find('all',["conditions"=>["Annonces.num_app"=>$this->request->data['num_app'],"Annonces.batiment"=>$this->request->data['batiment'], "Annonces.statut <> 40"]]);
		if(($this->request->data['nature']=="STD" || $this->request->data['nature']=="APP") && $ann->first()){
			// $msgerreur = __("Cette appartement est lié à une annonce");
		}else{
			$session = $this->request->session();
			if(empty($session->read('Auth.User.id'))){
				// inscription
				if ($this->Recaptcha->verify()) {
					if($this->request->data['email'] != "" && $this->request->data['email'] != " " ){
						$user = $this->Utilisateurs->find()->where(['LOWER(email)'=>strtolower($this->request->data['email'])]);
						if(!$user->first()){
							$utilisateur = $this->Utilisateurs->newEntity($this->request->data);
							$utilisateur->pwd=(new DefaultPasswordHasher)->hash($this->request->data['pwd']);
							$utilisateur->ident=$this->request->data['email'];
							$utilisateur->date_insert = Time::now();
							$utilisateur->email = strtolower($this->request->data['email']);
							$utilisateur->valide_at = null;
							$utilisateur->updated = 1;
							$utilisateur->nature = "ANNO";
							if($utilisateur = $this->Utilisateurs->save($utilisateur)) {
								Log::write('emergency', 'Inscription nouveau Client: "'.$utilisateur->email.'" avec mot de passe : "'.$this->request->data['pwd'].'"');
								//here SendInBlue add
								$this->loadModel("Pays");
								if(PROD_ON == 1){
									$sendinblue=new SendInBlueController();
									$sendinblue->addContactToSendInBlue($utilisateur->email,$utilisateur->prenom,$utilisateur->nom_famille,$utilisateur->portable,$utilisateur->civilite,$utilisateur->naissance,null,null,null, $this->Pays->get($utilisateur->pays)->fr ,$this->request->data['nature']);
								}
								//verification mail
								$this->loadModel('UtilisateursTokens');
								$token=sha1($utilisateur->email.$utilisateur->pwd);
								$this->UtilisateursTokens->deleteAll(['user_id' => $utilisateur->id]);
								$user_token=$this->UtilisateursTokens->newEntity([
									'user_id'=>$utilisateur->id,
									'token'=>$token,
									'expired_at'=>date('Y-m-d', strtotime('+1 year'))
								]);
								$this->loadModel("Registres");
								$mail = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]])->first();
								$url=Router::url(['controller' => 'Utilisateurs', 'action' => 'confirmuser','token'=>$token],true);
	
								$this->UtilisateursTokens->save($user_token);
								//end verification mail
	
								$datamustache = array('url' => $url,'login' => $this->request->data['email'],'password' => $this->request->data['pwd']);
	
								// #####################################################
								$event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $utilisateur,'textEmail'=>'confirmationInscription',
									'data'=>$datamustache,'template'=>'confirmationInscription','viewVars'=>'confirmationInscription','noReply'=>false
								]);
								$this->eventManager()->dispatch($event);
								// #####################################################
	
								/*** MISE A JOUR BOUTIQUE ***/
								// Nouveau Code magento 2
								//**** informations a utiliser toujours ********************//
								$magentoURL = BOUTIQUE_ALPISSIME;
								$data = array("username" => "API.ACCESS", "password" => "86>;];wzO+Q#");
								$data_string = json_encode($data);
								$ch = curl_init($magentoURL."index.php/rest/V1/integration/admin/token");
								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Content-Length: ".strlen($data_string)));
								$token = curl_exec($ch);
								$token= json_decode($token);
								$headers = array("Authorization: Bearer ".$token);
								//************************************************************//
								// **** mettre l'email du client depuis le site location **********//
								$customerEmail = $this->request->data['email'];   //à changer
								if($this->request->data['prenom'] == '') $customer_fname = "_";
								else $customer_fname = $this->request->data['prenom'] ; // prenom du client
								$customer_lname = $this->request->data['nom_famille']; // Nom du client
								$password = $this->request->data['pwd']; // mot de passe
								if($this->request->data['nature'] == "CLT") $group_id = 10;
								else $group_id = 9;
	
								$requestUrl = $magentoURL.'index.php/rest/V1/customers/search?searchCriteria[filter_groups][0][filters][0][field]=email&searchCriteria[filter_groups][0][filters][0][value]=%25'.$customerEmail.'%25&searchCriteria[filter_groups][0][filters][0][condition_type]=like';
								$ch = curl_init($requestUrl);
								curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								$result = curl_exec($ch);
								$result = json_decode($result, true);
								//*********** Mise a jour du mot de passe du client et eventuellement son nom ...
								// si le client existe (email) dans la boutique ********//
								if ($result["items"]){
									$id = $result['items'][0]['id'];
									$customerData = [
										'customer' => [
											'id' => $id,
											"group_id" => $group_id,
											"email" => $customerEmail,  //à changer
											"firstname" => $customer_fname,     //à changer
											"lastname" => $customer_lname,      //à changer
											"storeId" => 1,
											"websiteId" => 1,
											"custom_attributes" => [
												[
													"attribute_code" => "client_id_loc",
													"value" => $utilisateur->id
												]
											]
										],
										"password" => $password            //à changer
									];
	
									$link = $magentoURL.'index.php/rest/V1/customers/'.$id;
									$ch = curl_init($link);
									curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
									curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
									curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
									$result = curl_exec($ch);
	
									//echo '<pre>';print_r($result);  //Tu peux enlever
	
								} else {
									//******** créer le client ***********//
									$customerData = [
										'customer' => [
											"group_id" => $group_id,
											"email" => $customerEmail,  //à changer
											"firstname" => $customer_fname,          //à changer
											"lastname" => $customer_lname,         //à changer
											"storeId" => 1,
											"websiteId" => 1,
											"custom_attributes" => [
												[
													"attribute_code" => "client_id_loc",
													"value" => $utilisateur->id
												]
											]
										],
										"password" => $password            //à changer
									];
									$ch = curl_init($magentoURL."index.php/rest/V1/customers");
									curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
									curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
									curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
									$result = curl_exec($ch);
	
									//echo '<pre>';print_r($result);          //Tu peux enlever
								}
								curl_close($ch);
								/*** END MISE A JOUR BOUTIQUE ***/

								$useraut = $this->Auth->identify();
								$this->Auth->setUser($useraut);
							}else{
								$msgerreur = __('Votre inscription n\'a pas pu être terminée.');
								// $this->Flash->error(__('Votre inscription n\'a pas pu être terminée.'),['clear'=> true]);
							}
						} else {
							$this->set('confirm_res','addCompte');
							$msgerreur = __('Cette adresse email existe déjà.');
							// $this->Flash->error(__('Cette adresse email existe déjà.'),['clear'=> true]);
						}
					}
				}else{
					$msgerreur = __('Erreur ReCaptcha.');
					// $this->Flash->error(__('Erreur ReCaptcha.'),['clear'=> true]);
				}
			} 
			
			if(!empty($session->read('Auth.User.id')) || $utilisateur->id){
				$annonce = $this->Annonces->newEntity($this->request->data);
				$annonce->created_at=Time::now();
				$annonce->updated_at=Time::now();
				$annonce->village = $this->request->data['village'];
				$annonce->pays = $this->request->data['pays_annonce'];
				if($this->request->data['proprietaire_id'] == "") $annonce->proprietaire_id = $utilisateur->id;
				if ($annew = $this->Annonces->save($annonce)) {
					$annonceid = $annew->id;
					if($_FILES["uploadfileinventaire"]["name"]){
						// UPLOAD FILE
						$msgUpload = "";
						$target_dir = "inventaires/";
						$target_file = $target_dir . basename($_FILES["uploadfileinventaire"]["name"]);
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));		
						$namefile = "inventaire_annonce_".$annew->id.".".$imageFileType;
						$target_file = $target_dir . $namefile;		
						// Allow certain file formats
						if($imageFileType != "pdf") {
							$msgUpload = "fileTypeError";
							$uploadOk = 0;
						}
						// Check if $uploadOk is set to 0 by an error
						if ($uploadOk == 0) {
							$msgerreur = __('Le fichier n\'a pas pu etre enregistré');
							// $this->Flash->error(__('Le fichier n\'a pas pu etre enregistré'),['clear'=> true]);
							// if everything is ok, try to upload file
						} else {
							if (move_uploaded_file($_FILES["uploadfileinventaire"]["tmp_name"], $target_file)) {
								// echo "The file ". basename( $_FILES["uploadfile"]["name"]). " has been uploaded.";
								$msgUpload = "OK";
								$datainventaire = array("inventaire"=>$namefile);					
								$annonce = $this->Annonces->patchEntity($annew, $datainventaire);
								$annew = $this->Annonces->save($annonce);
								// $this->Flash->success(__('Le fichier a été bien enregistré'),['clear'=> true]);
							} else {
								$msgUpload = "problem";
								$msgerreur = __('Le fichier n\'a pas pu etre enregistré');
								// $this->Flash->error(__('Le fichier n\'a pas pu etre enregistré'),['clear'=> true]);
								// echo "Sorry, there was an error uploading your file.";
							}
						}
						// END UPLOAD FILE
					}				
	
					$this->loadModel("Registres");
					$mail = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]])->first();
					$utilisateur=$this->Utilisateurs->get($annonce->proprietaire_id);
	
					$datamustache = array('nomprop' => $utilisateur->nom_famille, 'prenomprop' => $utilisateur->prenom, 'annonce' => $annonce->titre);
									
					// #####################################################
					$event = new Event('Email.send', $this, ['from'=>$utilisateur->email,'to' => $mail->val,'textEmail'=>'creationAnnonce',
																'data'=>$datamustache,'template'=>'annoncesNotContrat','viewVars'=>'annoncesNotContrat','noReply'=>false
															]);
					$this->eventManager()->dispatch($event);
					// #####################################################
					//Envoyer copie pour gestionnaire s'il existe
					$this->loadModel("Gestionnaires");
					$anngest = $this->Gestionnaires->find("all")->join([
						'GV' => [
							'table' => 'gestionnaires_villages',
							'type' => 'inner',
							'conditions' => ['Gestionnaires.id=GV.gestionnaire_id','GV.villages_id'=>$this->request->data['village']]
						]
					]);
					if($anngestnew = $anngest->first()){
						$gestio = $anngestnew;
						$event = new Event('Email.send', $this, ['from'=>$utilisateur->email,'to' => $gestio->email,'textEmail'=>'creationAnnonce',
															'data'=>$datamustache,'template'=>'creationReservationAdm','viewVars'=>'creationReservationAdm','noReply'=>false]);
						$this->eventManager()->dispatch($event);
					}	
					
					// Traitement images
					$prefixe = $_SERVER['DOCUMENT_ROOT'];
					$this->loadModel("Photos");
					$this->loadModel("Villages");
					$listephotos = $this->Photos->find("all")->where(['annonce_id' => $this->request->data['annonce_id']]);
					foreach ($listephotos as $onephoto) {
						$natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
						$villageann = $this->Villages->get($this->request->data['village']);
						$village_nom = str_replace(" - ", "-", $villageann->name);
						$village_nom = str_replace(" – ", "-", $village_nom);
						$village_nom = str_replace(" ", "-", $village_nom);
						$vignetteG = "location-".$natureAnnURL[$annew->nature]."-".$village_nom."-".$annew->personnes_nb."-personnes-".$annew->id."-".$onephoto->numero."-Alpissime.jpg";
						$dataphoto = array(
							"annonce_id" => $annew->id,
							"titre" => $vignetteG
						);
						$updatephoto = $this->Photos->patchEntity($onephoto, $dataphoto);
						$this->Photos->save($updatephoto);
						rename("$prefixe/webroot/images_ann/".$this->request->data['annonce_id']."/vignette-".$this->request->data['annonce_id']."-".$onephoto->numero.".jpg", "$prefixe/webroot/images_ann/".$this->request->data['annonce_id']."/vignette-".$annew->id."-".$onephoto->numero.".jpg");
						rename("$prefixe/webroot/images_ann/".$this->request->data['annonce_id']."/vignette-".$this->request->data['annonce_id']."-".$onephoto->numero.".P.jpg", "$prefixe/webroot/images_ann/".$this->request->data['annonce_id']."/vignette-".$annew->id."-".$onephoto->numero.".P.jpg");
						rename("$prefixe/webroot/images_ann/".$this->request->data['annonce_id']."/".$this->request->data['annonce_id']."-".$onephoto->numero."-Alpissime.jpg", "$prefixe/webroot/images_ann/".$this->request->data['annonce_id']."/".$vignetteG);
					}					
					rename("$prefixe/webroot/images_ann/".$this->request->data['annonce_id'], "$prefixe/webroot/images_ann/".$annew->id);
					
					$nbrimages = $this->Photos->find('all',['conditions'=>['Photos.annonce_id'=>$annew->id]])->count();
					// Chercher prochaine periode
					$this->loadModel("Dispos");
					$nbrdispo = $this->Dispos->find('all',["conditions"=>["Dispos.annonce_id"=>$annew->id,"Dispos.dbt_at >= '".date("Y-m-d")."'"]])->count();
					
					$numenregistrement = $annew->num_enregistrement;
					$justifdomicile = $annew->justificatif_domicile;
				} else {
					$msgerreur = __("L'annonce n'a pas été sauvegardée");
					// $this->Flash->error(__("L'annonce n'a pas été sauvegardée"),['clear'=> true]);
				}
			}			

			$session->delete('lieugeo_id');
			$session->delete('nature');
			$session->delete('personnes_nb');
		}
		$blocks["msgerreur"] = $msgerreur;
		$blocks["annonceid"] = $annonceid;
		$blocks["nbrimages"] = $nbrimages;
		$blocks["nbrdispo"] = $nbrdispo;
		$blocks["numenregistrement"] = $numenregistrement;
		$blocks["justifdomicile"] = $justifdomicile;
		
		$this->response->body(json_encode($blocks));
		return $this->response;
		// }
	}
  /**
   * Add method
   *
   * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
   */
  public function add(){
    $session = $this->request->session(); 
    if($session->read('Auth.User.nature') == 'CLT') return $this->redirect(['action' => 'landing']);
    
		$annonce = $this->Annonces->newEntity();
    if ($this->request->is('post')) {
		return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce']."/".$this->Session->read('Auth.User.id'));
			// $ann=$this->Annonces->find('all',["conditions"=>["Annonces.num_app"=>$this->request->data['num_app'],"Annonces.batiment"=>$this->request->data['batiment'], "Annonces.statut <> 40"]]);
			// if(($this->request->data['nature']=="STD" || $this->request->data['nature']=="APP") && $ann->first()){
			// 	$this->Flash->error(__("Cette appartement est lié à une annonce"),['clear'=> true]);
			// }else{
			// 	$annonce = $this->Annonces->newEntity($this->request->data);
			// 	$annonce->created_at=Time::now();
			// 	$annonce->updated_at=Time::now();
			// 	$annonce->village = $this->request->data['village'];
			// 	if ($annew = $this->Annonces->save($annonce)) {
			// 		// UPLOAD FILE
			// 		$msgUpload = "";
			// 		$target_dir = "inventaires/";
			// 		$target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
			// 		$uploadOk = 1;
			// 		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));		
			// 		$namefile = "inventaire_annonce_".$annew->id.".".$imageFileType;
			// 		$target_file = $target_dir . $namefile;		
			// 		// Allow certain file formats
			// 		if($imageFileType != "pdf") {
			// 			$msgUpload = "fileTypeError";
			// 			$uploadOk = 0;
			// 		}
			// 		// Check if $uploadOk is set to 0 by an error
			// 		if ($uploadOk == 0) {
			// 			$this->Flash->error(__('Le fichier n\'a pas pu etre enregistré'),['clear'=> true]);
			// 			// if everything is ok, try to upload file
			// 		} else {
			// 			if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
			// 				// echo "The file ". basename( $_FILES["uploadfile"]["name"]). " has been uploaded.";
			// 				$msgUpload = "OK";
			// 				$datainventaire = array("inventaire"=>$namefile);					
			// 				$annonce = $this->Annonces->patchEntity($annew, $datainventaire);
			// 				$annew = $this->Annonces->save($annonce);
			// 				$this->Flash->success(__('Le fichier a été bien enregistré'),['clear'=> true]);
			// 			} else {
			// 				$msgUpload = "problem";
			// 				$this->Flash->error(__('Le fichier n\'a pas pu etre enregistré'),['clear'=> true]);
			// 				// echo "Sorry, there was an error uploading your file.";
			// 			}
			// 		}
			// 		// END UPLOAD FILE

			// 		$this->loadModel("Registres");
			// 		$mail = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]])->first();
			// 		$utilisateur=$this->Utilisateurs->get($annonce->proprietaire_id);

			// 		$datamustache = array('nomprop' => $utilisateur->nom_famille, 'prenomprop' => $utilisateur->prenom, 'annonce' => $annonce->titre);
            //                             // #####################################################
            //                             // $event = new Event('Email.send', $this, ['from'=>$mail->val,'to' => $utilisateur,'textEmail'=>'annoncesNotContrat',
            //                             //                                          'data'=>$datamustache,'template'=>'annoncesNotContrat','viewVars'=>'annoncesNotContrat','noReply'=>false
            //                             //                                         ]);
            //                             // $this->eventManager()->dispatch($event);
            //                             // #####################################################
                                        
            //                             // #####################################################
            //                             $event = new Event('Email.send', $this, ['from'=>$utilisateur->email,'to' => $mail->val,'textEmail'=>'creationAnnonce',
            //                                                                      'data'=>$datamustache,'template'=>'annoncesNotContrat','viewVars'=>'annoncesNotContrat','noReply'=>false
            //                                                                     ]);
            //                             $this->eventManager()->dispatch($event);
			// 							// #####################################################
			// 								//Envoyer copie pour gestionnaire s'il existe
			// 								$this->loadModel("Gestionnaires");
			// 								$anngest = $this->Gestionnaires->find("all")->join([
			// 									'GV' => [
			// 										'table' => 'gestionnaires_villages',
			// 										'type' => 'inner',
			// 										'conditions' => ['Gestionnaires.id=GV.gestionnaire_id','GV.villages_id'=>$this->request->data['village']]
			// 									]
			// 								]);
			// 								if($anngestnew = $anngest->first()){
			// 									$gestio = $anngestnew;
			// 									$event = new Event('Email.send', $this, ['from'=>$utilisateur->email,'to' => $gestio->email,'textEmail'=>'creationAnnonce',
			// 																		'data'=>$datamustache,'template'=>'creationReservationAdm','viewVars'=>'creationReservationAdm','noReply'=>false]);
			// 									$this->eventManager()->dispatch($event);
			// 								}	
					
			// 		$this->Flash->success(__('Votre annonce a bien été sauvegardée'),['clear'=> true]);
			// 		$session->write("SubmitOK","OK");
			// 		if($session->read('Config.language') != "fr_FR"){
			// 			$this->loadModel("Languages");
			// 			$language_header_name = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();
			// 			$urlLang = $language_header_name->url_code."/";
			// 		} else {
			// 			$urlLang = "";
			// 		}
			// 		$this->loadModel("Urlmultilingue");
			// 		$urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
			// 		$urlvaluemulti = [];
			// 		foreach ($urlmultilinguelistes as $urlmultilingueliste) {
			// 			$urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
			// 		}					
			// 		return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['annonces']."/edit2/".$annonce->id);
			// 	} else {
			// 		$this->Flash->error(__("L'annonce n'a pas été sauvegardée"),['clear'=> true]);
			// 	}
			// }
    }
    $this->loadModel("Lieugeos");

	$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
	$ar[""]="Choisir station";
    foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
	// 	$this->set("l_lieugeos",$ar);
		$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
    $this->set("l_nombre_personnes",$a_personne);
		$this->set("l_residence",$this->Residences->find("list",["conditions"=>["id_village"=>1]]));
		$this->set("l_village",$this->Villages->find("list")->where(['lieugeo_id'=>$enrs->toArray()[0]->id]));
    $this->set("annonce_id","");
		$a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
    $this->set("l_distances",$a_distance);
	$a_nature_loc=array('STD'=>__('Studio'),'APP'=>__('Appartement'),'CHA'=>__('Chalet'),'VIL'=>__('Villa'),'GIT'=>__('Gîte'),'DIV'=>__('Autre'));
    $this->set("l_natures_location",$a_nature_loc);
		$a_expo=array('1'=>__('Nord'),'2'=>__('Sud'),'3'=>__('Est'),'4'=>__('Ouest'),'5'=>__('Nord-Est'),'6'=>__('Nord-Ouest'),'7'=>__('Sud-Est'),'8'=>__('Sud-Ouest'));
    $this->set("list_exposition",$a_expo);
		$a_nb_piece=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15');
    $this->set("l_nombre_pieces",$a_nb_piece);
		$a_ann_village=array(''=>'','Le Charvet'=>'Le Charvet','Les Villards'=>'Les Villards','Charmettoger'=>'Charmettoger','Le Chantel'=>'Le Chantel');
    $this->set("l_villages",$a_ann_village);
		// $mail = [];
		// $this->loadModel("Modelmailsysteme");
		// $textEmail = $this->Modelmailsysteme->find('all');
		// foreach ($textEmail as $key => $value) {
		// 	$mail[$value->titre] = $value->txtmail;
		// }
		// $this->set("textmail",$mail);
		$session = $this->request->session();
		if($session->read('Auth.User.id')){
			$this->loadModel("Utilisateurs");
			$prop = $this->Utilisateurs->get($session->read('Auth.User.id'), [
				'contain' => ['Cautions']
			]);
			$this->set("propdetail",$prop);
		}
		
    $this->set(compact('annonce'));
    $this->set('_serialize', ['annonce']);
		$this->set('title_for_layout',"Locations de vacances et services de conciergerie");
    $this->loadModel('Pays');
    $pays=$this->Pays->findByCode_pays('Fr')->union(
    $this->Pays->find('all')->where(['code_pays != ' =>'FR']));
    $this->set('pays',$pays);
	$Paysinscr=$this->Pays->find('all');
	$a_pay=array();
	$payNum=array();
	$a_pay[""] = __('Choisir votre pays');
	foreach($Paysinscr as $pay){
		if($session->read('Config.language') == "fr_FR") $a_pay[$pay->id_pays]=$pay->fr;
		if($session->read('Config.language') == "en_US") $a_pay[$pay->id_pays]=$pay->en;
		$payNum[$pay->id_pays]=$pay->code_pays;
	}
	$this->set("Paysinscr", $a_pay);
	$this->set("paysNum", $payNum);
    $this->loadModel('Departements');
    $deps=$this->Departements->find('all')->order('name');
    $idDep=$this->Departements->find('all')->order('name')->first()->id;
    $this->set('departements',$deps);
    $this->loadModel('Frvilles');
	$this->set('villes',$this->Frvilles->find('all')->where(['departement_id'=>$idDep])->order('name'));
	$this->loadModel('Villages');
	$villages=$this->Villages->find()->order(['Villages.name ASC']);
	$this->set('villages',$villages);
	$listestationgps = $this->Residences->find("all",["conditions"=>["id IN"=>array(101, 110, 107, 109, 108, 111, 112, 115, 266, 267, 268, 270)]]);
	$l_station_gps = [];
	foreach ($listestationgps as $val) {
		$l_station_gps[$val->id]['lat'] = $val->latitude;
		$l_station_gps[$val->id]['long'] = $val->longitude;
	}
	$this->set("l_station_gps",$l_station_gps);

	$this->loadModel("Massif");
	$stations = $this->Massif->find("all")->contain('Lieugeos', function ($q) {
		return $q
				->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id"])
				->where(["Lieugeos.niveau >= 3", "Lieugeos.name NOT LIKE '%Non Affichée%'"])->order(['Lieugeos.name']);
		})->matching('Lieugeos', function ($q) {
		return $q
				->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id"])
				->where(["Lieugeos.niveau >= 3", "Lieugeos.name NOT LIKE '%Non Affichée%'"])->order(['Lieugeos.name']);
		})->group(['Massif.id'])->order(['Massif.nom']);
	$this->set("stations",$stations);

	// $this->loadModel("Photos");
	// $this->set("photos",$this->Photos->find("all",["conditions"=>["Photos.annonce_id"=>$id]]));
  }
  /**
   * Edit method
   *
   * @param string|null $id Annonce id.
   * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Network\Exception\NotFoundException When record not found.
   */
	public function edit($id = null){
		//on vérifie que l'annonce est celle du prop connecté ou que le connecté est un gest ou admin
		$session = $this->request->session();
		$gest=$session->read('Gestionnaire.info');
     
		$annonce = $this->Annonces->get($id, ['contain' => []]);
		if($annonce->proprietaire_id != $session->read('Auth.User.id') && $gest['G']['role'] != "gestionnaire" && $gest['G']['role'] != "admin"){
			$annonce = "";
			$this->Flash->error(__("Vous ne pouvez pas voir l'annonce d'un autre utilisateur"),['clear'=> true]);
		}else{
			$annonce = $this->Annonces->get($id, ['contain' => []]);
		}

		
		 if ($this->request->is(['patch', 'post', 'put'])) {
			 //on vérifie que l'annonce est celle du prop connecté ou que le connecté est un gest ou admin
			if($annonce->proprietaire_id != $session->read('Auth.User.id') && $gest['G']['role'] != "gestionnaire" && $gest['G']['role'] != "admin"){
				$this->Flash->error(__("Vous ne pouvez pas modifier l'annonce d'un autre utilisateur"),['clear'=> true]);
			}else{
				$ann=$this->Annonces->find('all',["conditions"=>["Annonces.num_app"=>$this->request->data['num_app'],"Annonces.batiment"=>$this->request->data['batiment'], "Annonces.statut <> 40"]]);
				if(($this->request->data['nature']=="STD" || $this->request->data['nature']=="APP") &&$ann->first() && $ann->first()->id != $id){
					$this->Flash->error(__("Cette appartement est lié à une annonce"),['clear'=> true]);
				}else{
					$annonce = $this->Annonces->patchEntity($annonce, $this->request->data);
					$annonce->updated_at=Time::now();
					$annonce->village = $this->request->data['village'];
					if ($oldannonce = $this->Annonces->save($annonce)) {
						if($_FILES["uploadfile"]["name"]){
							// UPLOAD FILE
							$msgUpload = "";
							$target_dir = "inventaires/";
							$target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
							$uploadOk = 1;
							$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));	
							$namefile = "inventaire_annonce_".$oldannonce->id.".".$imageFileType;
							$target_file = $target_dir . $namefile;			
							// Allow certain file formats
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf") {
								$msgUpload = "fileTypeError";
								$uploadOk = 0;
							}
							// Check if $uploadOk is set to 0 by an error
							if ($uploadOk == 0) {
								$this->Flash->error(__('Le fichier n\'a pas pu etre enregistré'),['clear'=> true]);
								// if everything is ok, try to upload file
							} else {
								if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
									// echo "The file ". basename( $_FILES["uploadfile"]["name"]). " has been uploaded.";
									$msgUpload = "OK";
									$this->Flash->success(__('Le fichier a été bien enregistré'),['clear'=> true]);
								} else {
									$msgUpload = "problem";
									$this->Flash->error(__('Le fichier n\'a pas pu etre enregistré'),['clear'=> true]);
									// echo "Sorry, there was an error uploading your file.";
								}
							}
							// END UPLOAD FILE
							$datainventaire = array("inventaire"=>$namefile);

							$annonce = $this->Annonces->patchEntity($oldannonce, $datainventaire);
							$this->Annonces->save($annonce);
						}				

						$this->Flash->success(__('Les modifications sur votre annonce ont bien été sauvegardées'),['clear'=> true]);
						if($session->read('Config.language') != "fr_FR"){
							$this->loadModel("Languages");
							$language_header_name = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();
							$urlLang = $language_header_name->url_code."/";
						} else {
							$urlLang = "";
						}
						$this->loadModel("Urlmultilingue");
						$urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
						$urlvaluemulti = [];
						foreach ($urlmultilinguelistes as $urlmultilingueliste) {
							$urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
						}					
						return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['annonces']."/edit2/".$annonce->id);
					} else {
							$this->Flash->error(__("L'annonce n'a pas été sauvegardée"),['clear'=> true]);
					}
				}
			}
			
		 }
		 $this->loadModel("Lieugeos");
		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3, "Lieugeos.etat = 1"],"order"=>"Lieugeos.name"]);
		 foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		 $this->set("l_lieugeos",$ar);
		$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
		$this->set("l_nombre_personnes",$a_personne);
		if($annonce->batiment != NULL && $annonce->batiment != 0){
			$a_residence = $this->Residences->find('all')->where(['id' => $annonce->batiment]);
			if($a_residence->first()){
				$a_residence = $a_residence->first();
				$this->set("l_residence",$this->Residences->find("list",["conditions"=>["id_village"=>$a_residence->id_village]]));
			}else{
				$this->set("l_residence","");
			}
		 }else{
		 $this->set("l_residence","");
	 }
	 $this->set("l_village",$this->Villages->find("list")->where(['lieugeo_id'=>$annonce->lieugeo_id]));

		$this->set("annonce_id","");
		$a_distance=array("1"=>"moins de 50m","2"=>"entre 50 et 100m","3"=>"entre 100 et 200m","4"=>"entre 200 et 300m","5"=>"entre 300 et 500m","6"=>"entre 500 et 1km","7"=>"entre 1 et 2km","8"=>"entre 2 et 3km","9"=>"plus de 3km");
		$this->set("l_distances",$a_distance);
		$a_nature_loc=array('STD'=>__('Studio'),'APP'=>__('Appartement'),'CHA'=>__('Chalet'),'VIL'=>__('Villa'),'GIT'=>__('Gîte'),'DIV'=>__('Autre'));
		$this->set("l_natures_location",$a_nature_loc);
		$a_expo=array('1'=>__('Nord'),'2'=>__('Sud'),'3'=>__('Est'),'4'=>__('Ouest'),'5'=>__('Nord-Est'),'6'=>__('Nord-Ouest'),'7'=>__('Sud-Est'),'8'=>__('Sud-Ouest'));
		$this->set("list_exposition",$a_expo);
		$a_nb_piece=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15');
		$this->set("l_nombre_pieces",$a_nb_piece);
		$a_ann_village=array(''=>'','Le Charvet'=>'Le Charvet','Les Villards'=>'Les Villards','Charmettoger'=>'Charmettoger','Le Chantel'=>'Le Chantel');
		$l_annoncesstatuts=array('0'=>__('Brouillon'),'30'=>__('Comité d\'entreprise'),'10'=>__('Désactivée'),'19'=>__('Suspendue'),'50'=>__('Validée'),'40'=>__('Supprimée'));
		$this->set("l_annoncesstatuts",$l_annoncesstatuts);
	 $this->set("l_villages",$a_ann_village);
	 $this->loadModel("Utilisateurs");
		$prop = $this->Utilisateurs->get($annonce->proprietaire_id, [
			'contain' => ['Cautions']
		]);
		$this->set("propdetail",$prop);
	 $this->set('annonce_id',$id);
	 $this->set(compact('annonce'));
	 $this->set('_serialize', ['annonce']);
		$this->set('title_for_layout',"Locations de vacances et services de conciergerie");
							 $this->loadModel('Pays');
							 $this->set('pays',$this->Pays->find('all'));
							 if($annonce->pays==67)
							 {
									 $this->loadModel('Departements');
									 $this->set('departements',$this->Departements->find('all'));
									 $this->loadModel('Frvilles');
									 $this->set('villes',$this->Frvilles->find('all')->where(['departement_id'=>$annonce->region]));
							 }
							 elseif($annonce->pays!=67&&$annonce->pays!=0)
							 {
									 $this->loadModel('Pvilles');
									 $this->set('villes',$this->Pvilles->find('all')->where(['pays_id'=>$annonce->pays]));
							 }
		$this->set('annonce_inventaire', $annonce->inventaire);

		$this->loadModel("Massif");
		$stations = $this->Massif->find("all")->contain('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.name NOT LIKE '%Non Affichée%'"])->order(['Lieugeos.name']);
		 })->matching('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.name NOT LIKE '%Non Affichée%'"])->order(['Lieugeos.name']);
		 })->group(['Massif.id'])->order(['Massif.nom']);
		$this->set("stations",$stations);
	}

	/*
	 *
	 */
	function edit2($id=null){
	// 	$annonce = $this->Annonces->get($id, ['contain' => []]);
    // if ($this->request->is(['patch', 'post', 'put'])) {
	//on vérifie que l'annonce est celle du prop connecté ou que le connecté est un gest ou admin
	$session = $this->request->session();
	$gest=$session->read('Gestionnaire.info');
	$annonce = $this->Annonces->get($id, ['contain' => []]);
	if($annonce->proprietaire_id != $session->read('Auth.User.id') && $gest['G']['role'] != "gestionnaire" && $gest['G']['role'] != "admin"){
		//$annonce = "";
		$this->Flash->error(__("Vous ne pouvez pas voir l'annonce d'un autre utilisateur"),['clear'=> true]);
	}else{
		$annonce = $this->Annonces->get($id, ['contain' => []]);
	}

	
	 if ($this->request->is(['patch', 'post', 'put'])) {
		 //on vérifie que l'annonce est celle du prop connecté ou que le connecté est un gest ou admin
		if($annonce->proprietaire_id != $session->read('Auth.User.id') && $gest['G']['role'] != "gestionnaire" && $gest['G']['role'] != "admin"){
			$this->Flash->error(__("Vous ne pouvez pas modifier l'annonce d'un autre utilisateur"),['clear'=> true]);
		}else{
			$annonce = $this->Annonces->patchEntity($annonce, $this->request->data);
			$annonce->updated_at=Time::now();
			if ($this->Annonces->save($annonce)) {
						$this->Flash->success(__('Les modifications sur votre annonce ont bien été sauvegardées'),['clear'=> true]);
				return $this->redirect(['action' => 'photo',$annonce->id]);
			} else {
				$this->Flash->error(__("L'annonce n'a pas été sauvegardée"),['clear'=> true]);
			}
		}			
    }
		$this->set('annonce_id',$id);
		$this->set(compact('annonce'));
    $this->set('_serialize', ['annonce']);
		$this->set('title_for_layout',"Locations de vacances et services de conciergerie");
	}
  /**
   * Gestion des photos
   * @param id identifiant unique de l'annonce à traiter
   */
  function photo($id = null){
	$session = $this->request->session();
	$gest=$session->read('Gestionnaire.info');
	$annonce = $this->Annonces->get($id, ['contain' => []]);
	if($annonce->proprietaire_id != $session->read('Auth.User.id') && $gest['G']['role'] != "gestionnaire" && $gest['G']['role'] != "admin"){
		//$annonce = "";
		$this->Flash->error(__("Vous ne pouvez pas voir l'annonce d'un autre utilisateur"),['clear'=> true]);
		$id = null;
	}

		$this->set("annonce_id",$id);
		$this->loadModel("Photos");
		$this->set("photos",$this->Photos->find("all",["conditions"=>["Photos.annonce_id"=>$id]]));
		$this->set('title_for_layout',"Locations de vacances et services de conciergerie");
  }
	/**
	 *
	 */
	function getresidence(){
            $this->viewBuilder()->layout(false);
            $listeresidences = $this->Residences->find()->where(['id_village = '.$this->request->data['id_vil'].' AND (bibliotheque_id = 7 OR bibliotheque_id = 1)'])->order(['Residences.name ASC']);
            $this->set("listeresidences", $listeresidences);
	}
	/**
	 * 
	 */
	public function getvillefromvillage()
	{
		$this->viewBuilder()->layout(false);
		$ville = $this->Villages->find()->join([
			'Frvilles' => [
				'table' => 'frvilles',
				'type' => 'inner',
				'conditions' => ['Villages.id_ville = Frvilles.id'],
			]
		])->where(['Villages.id' => $this->request->data['id_vil']])
		->select(['Villages.id_ville', 'Frvilles.code_postal', 'Frvilles.departement_id']);
		
		if($ville->first())
		{
			$vil = $ville->first();
			$this->set("code_postal_val", $vil['Frvilles']['code_postal']);
			$this->set("ville_val", $vil->id_ville);
			$this->set("region_val", $vil['Frvilles']['departement_id']);
			$this->set("pays_val", 67);
		}
		
	}
  /**
   * Delete method
   *
   * @param string|null $id Annonce id.
   * @return \Cake\Network\Response|null Redirects to index.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function delete($id = null){
		$this->request->allowMethod(['post', 'delete']);
    $annonce = $this->Annonces->get($id);
    if ($this->Annonces->delete($annonce)) {
			$this->Flash->success(__('L\'annonce a été supprimée.'),['clear'=> true]);
    } else {
      $this->Flash->error(__('L\'annonce ne peut pas etre supprimée. Essayer une autre fois.'),['clear'=> true]);
    }
    return $this->redirect(['action' => 'landing']);
  }
	/**
  	* Affichage de statistiques liées à l'annonce
    */
  function statistique($id){
		$this->loadModel("Clics");
		$this->paginate= [
			"order"=>"Clics.clic_at desc",
      "limit"=>30,
      "fields"=>["Clics.id","Clics.clic_nb","Clics.clic_at"],
			"conditions"=>["Clics.annonce_id"=>$id],
			];
		$clics = $this->paginate($this->Clics);
    $this->set(compact('clics'));
    $this->set('_serialize', ['clics']);
	  $this->set("annonce_id",$id);
		$this->set('title_for_layout',"Locations de vacances et services de conciergerie");
  }
    /*
     *
     */
    function prop($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $annonce      = $this->Annonces->get($this->request->data["id"], ['contain' => ['Lieugeos','Villages']]);
            $proprietaire = $this->Utilisateurs->get($annonce->proprietaire_id);

            $path = Router::url('/', true);
            $hrefDetailAnn = '';
            //if ($this->InvisibleReCaptcha->verify()) {
            if ($this->Recaptcha->verify()) {
                // Ajout variable {{imageannonce}}
                $photo = $this->Photos->find()->where(['annonce_id' => $annonce->id])->order(['numero ASC'])->first();
                $urlimage1 = 'https://www.alpissime.com/images_ann/' . $annonce->id . '/' . $photo->titre;

                $natureAnnURL = [
                    "STD" => __("studio"),
                    "APP" => __("appartement"),
                    "CHA" => __("chalet"),
                    "DIV" => __("location"),
                    "VIL" => __("villa"),
                    "GIT" => __("gite")
                ];

                $lannonce = $this->string2url($annonce["titre"]);
                $session = $this->request->session();
                if ($session->read('Config.language') != "fr_FR") {
                    $this->loadModel("Languages");
                    $language_header_name = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();
                    $urlLang = $language_header_name->url_code."/";
                } else {
                    $urlLang = "";
                }

                $this->loadModel("Urlmultilingue");
                $urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
                $urlvaluemulti = [];

                foreach ($urlmultilinguelistes as $urlmultilingueliste) {
                    $urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
                }

                $hrefDetailAnn = $urlLang.$urlvaluemulti['station'].'/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;
                $messagetotest = preg_replace('`[^a-zA-Z0-9]`', '', $this->request->data["message"]);

                if (preg_match('[[0-9]{8}]', $messagetotest)) {
                    return $this->redirect($path.$hrefDetailAnn."?error=1");
                }

                $sendTo = [
                    'email'    => $this->request->data['email'],
                    'portable' => $this->request->data['tel']
                ];

                $datamustache = [
                    'nomprop'       => $proprietaire->nom_famille,
                    'prenomprop'    => $proprietaire->prenom,
                    'emailprop'     => $proprietaire->email,
                    'telephoneprop' => $proprietaire->portable,
                    'nom'           => $this->request->data['name'],
                    'prenom'        => $this->request->data['prenom'],
                    'annonce'       => $annonce->id,
                    'demande'       => "Demande location",
                    'email'         => $this->request->data['email'],
                    'tel'           => $this->request->data['tel'],
                    'message'       => "Date Début : ".$this->request->data["dbt_msg"]." -- Date Fin : ".$this->request->data["fin_msg"]." -- Nbr Adultes : ".$this->request->data["nbCouchage_ad_msg"]." -- Nbr Enfants : ".$this->request->data["nbCouchage_enf_msg"]." -- ".$this->request->data["message"],
                    'imageannonce'  => $urlimage1,
                    'annonceURL'    => "https://www.alpissime.com/".$hrefDetailAnn
                ];

                $this->loadModel("Registres");
                $mail = $this->Registres->find("all",["conditions" => [
                    "app" => "ULYSSE",
                    "bra" => "GEN",
                    "cle" => "MAIL"
                ]])->first();
                // #####################################################
                $event = new Event('Email.send', $this, [
                    'from'      => [$mail->val=>FROM_MAIL],
                    'to'        => $sendTo,
                    'textEmail' => 'infoLocataire',
                    'data'      => $datamustache,
                    'template'  => 'infoLocataire',
                    'viewVars'  => 'infoLocataire',
                    'noReply'   => true
                ]);
                $this->eventManager()->dispatch($event);
                // #####################################################

                $this->loadModel("Annoncegestionnaires");

                $propEventData = [
                    'from' => [$mail->val=>FROM_MAIL],
                    'to'   => $proprietaire
                ];

                $adminEventData = [
                    'from' => $this->request->data["email"],
                    'to'   => $mail->val
                ];

                if ((!empty($annonce->contrat) && ($annonce->contrat == 1)) || (!empty($annonce->mise_relation) && ($annonce->mise_relation == 1))) {
                    $propEventData = array_merge($propEventData, [
                        'textEmail' => 'contactProprietaire',
                        'data'      => $datamustache,
                        'template'  => 'contactProprietaire',
                        'viewVars'  => 'contactProprietaire',
                        'noReply'   => true
                    ]);

                    $adminEventData = array_merge($adminEventData, [
                        'textEmail' => 'contactProprietaireAdmin',
                        'data'      => $datamustache,
                        'template'  => 'contactProprietaireAdmin',
                        'viewVars'  => 'contactProprietaireAdmin',
                        'noReply'   => true
                    ]);
                } else {
                    $propEventData = array_merge($propEventData, [
                        'textEmail' => 'annoncesNotContrat',
                        'data'      => $datamustache,
                        'template'  => 'annoncesNotContrat',
                        'viewVars'  => 'annoncesNotContrat',
                        'noReply'   => true
                    ]);

                    $adminEventData = array_merge($adminEventData, [
                        'textEmail' => 'contactProprietaireAdminNotContrat',
                        'data'      => $datamustache,
                        'template'  => 'contactProprietaireAdminNotContrat',
                        'viewVars'  => 'contactProprietaireAdminNotContrat',
                        'noReply'   => true
                    ]);
                }

                $this->loadModel("Contactprops");
                $messageData = [
                    "id_annonce"     => $this->request->data["id"],
                    "demande"        => "Demande Location",
                    "commentaire"    => "Date Début : ".$this->request->data["dbt_msg"]." -- Date Fin : ".$this->request->data["fin_msg"]." -- Nbr Adultes : ".$this->request->data["nbCouchage_ad_msg"]." -- Nbr Enfants : ".$this->request->data["nbCouchage_enf_msg"]." -- ".$this->request->data["message"],
                    "date_insert"    => Time::now(),
                    "lut"            => "0",
                    "locataire_id"   => $this->request->data["idUser"],
                    "reservation_id" => 0,
                    "parent_id"      => 0
                ];

                $contact = $this->Contactprops->newEntity($messageData);
                if ($this->Contactprops->save($contact)) {
                    // #####################################################
                    
                    $event = new Event('Email.send', $this, $propEventData);
                    $this->eventManager()->dispatch($event);
                    // #####################################################

                    // #####################################################
                    $event = new Event('Email.send', $this, $adminEventData);
                    $this->eventManager()->dispatch($event);
                    // #####################################################
                }

                $this->Flash->success(__('Votre message a été bien envoyé.'),['clear'=> true]);

                return $this->redirect($path.$hrefDetailAnn."/send");
                /*} else {
                      $str = str_replace("é","e",$annonce->titre);
                      $str = str_replace("è","e",$str);
                      $str = str_replace("ê","e",$str);
                      $str = str_replace("à","a",$str);
                      $str = str_replace("â","a",$str);
                      $str = str_replace("ä","a",$str);
                      $str = str_replace("î","i",$str);
                      $str = str_replace("ï","i",$str);
                      $str = str_replace("ô","o",$str);
                      $str = str_replace("ö","o",$str);
                      $str = str_replace("ù","u",$str);
                      $str = str_replace("û","u",$str);
                      $str = str_replace("ü","u",$str);
                      $str = str_replace(",","-",$str);
                      $str = str_replace("'","-",$str);
                      $str = str_replace(" ","-",$str);
                      $str = str_replace("(","",$str);
                      $str = str_replace(")","",$str);
                      $str = str_replace("%","pourcent",$str);
                      $str = str_replace("œ","oe",$str);
                      $str = str_replace("Œ","oe",$str);
                      $str = str_replace("€","euros",$str);
                      $str = str_replace("/","-",$str);
                      $str = str_replace("+","-",$str);
                      $str = str_replace("ç","c",$str);
                      $str = str_replace("*","",$str);
                      $str = str_replace("?","",$str);
                      $str = str_replace("!","",$str);
                      $str = str_replace("°","",$str);
                      $str = str_replace("<","",$str);
                      $str = str_replace(">","",$str);
                      $str = str_replace("----","-",$str);
                      $str = str_replace("---","-",$str);
                      $str = str_replace("--","-",$str);
                      $str = str_replace("²","",$str);
                      $this->Flash->error(__("Votre message n'a pas été envoyé, Veuillez prouver que vous n'êtes pas un robot."),['clear'=> true]);
                      return $this->redirect($path."detail/".$this->request->data["id"]."-".strtolower($str).".html");
                */
            } else {
                return $this->redirect($path . $hrefDetailAnn);
            }
        }

        $this->set("id_prop", $id);
    }

	/*
	 *
	 */
	function contact(){
		$contact = $this->Contacts->newEntity();
                if ($this->request->is('post')) {
			// if ($this->InvisibleReCaptcha->verify()) {
			if ($this->Recaptcha->verify()) {
				$contact = $this->Contacts->newEntity($this->request->data);
				if ($this->Contacts->save($contact)) {
					$this->loadModel("Registres");
					$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
					$mail=$mails->first();
					$email = new Email('production');
					$email->to($this->request->data['gestionnaire'])
								->emailFormat('html')
								->from($this->request->data['email'])
								->subject("Contact")
								->send($this->request->data['message']);
					$this->Flash->success(__("votre message a été envoyé."),['clear'=> true]);
					return $this->redirect(['action' => 'contact']);
				} else {
					$this->Flash->error(__("Erreur d'envoi de votre message"),['clear'=> true]);
				}

			}else{
				$this->Flash->error(__("Votre message n'a pas été envoyé, Veuillez prouver que vous n'êtes pas un robot."),['clear'=> true]);
				return $this->redirect(['action' => 'contact']);
			}
                }
                $this->loadModel("Gestionnaires");
                $gestionnaires = $this->Gestionnaires->find();
                $listegest["gestion@alpissime.com"] = "Administrateur";
                foreach ($gestionnaires as $value) {
                    if($value->id != 6) $listegest[$value->email] = $value->name;
                }
				$this->set("listegestionnaires", $listegest);
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
	/*
	 *
	 */
	function sitemap() {
		$this->RequestHandler->respondAs('xml');
		$this->viewBuilder()->layout(false);
		$annonces=$this->Annonces->find('all',["conditions"=>["Annonces.statut"=>"50"],'contain' => ['Lieugeos'],"order"=>"Annonces.updated_at desc"])->toArray();

		// Liste Stations
		$this->loadModel("Lieugeos");
		$stationsliste = $this->Lieugeos->find('all')->where(['etat = 1']);

		// Liste Massifs
		$this->loadModel("Massif");
		$stations = $this->Massif->find("all")->contain('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id", "Lieugeos.image"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->matching('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id", "Lieugeos.image"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.etat = 1"])->order(['Lieugeos.name']);
		 })->group(['Massif.id'])->order(['Massif.nom']);
		$this->set("stations",$stations);
		
		$massifStat = [];
		foreach ($stations as $valueStation) {
			if($valueStation->nom_url != "") $massifStat[] = $valueStation->nom_url;
		}

		// Liste Résidences
		$this->loadModel("Residences");
		$residences = $this->Residences->find("all")->contain(['Villages'=>'Lieugeos'])
		->join([
			'Annonces' => [
				'table' => 'annonces',
				'type' => 'inner',
				'conditions' => ['Residences.id = Annonces.batiment', "Annonces.statut = 50"],
			]
		])->where(['bibliotheque_id' => 1, 'name_url <> ""'])
		->group(['Residences.id']);

		$this->loadModel("Languages");
		$allanguages = $this->Languages->find("all");

		$session = $this->request->session();
		$this->loadModel("Urlmultilingue");
		$urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => ["en_US"]]);
		$urlvaluemulti = [];
		foreach ($urlmultilinguelistes as $urlmultilingueliste) {
			$urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations["en_US"]->name_value;
		}
		
		// '<xhtml:link rel="alternate" hreflang="en" href="http://www.example.com/en/" />'

		$sitemap = '<?xml version="1.0" encoding="utf-8"?>
		  <?xml-stylesheet href="https://'.$_SERVER["HTTP_HOST"].'/xml/tent.xsl" type="text/xsl"?>
		  <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
		    <url>
		  <loc>'.SITE_ALPISSIME.'</loc>';
		  	foreach ($allanguages as $allanguage) {
				if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/" />';
				else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'" />';
			}
			$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>1.00</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'en/</loc>';
		  	foreach ($allanguages as $allanguage) {
				if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/" />';
				else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'" />';
			}
			$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>1.00</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'utilisateurs/ouvrircompte/</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['utilisateurs'].'/'.$urlvaluemulti['ouvrircompte'].'/" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'utilisateurs/ouvrircompte/" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.80</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'en/'.$urlvaluemulti['utilisateurs'].'/'.$urlvaluemulti['ouvrircompte'].'/</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['utilisateurs'].'/'.$urlvaluemulti['ouvrircompte'].'/" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'utilisateurs/ouvrircompte/" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.80</priority>
		</url>

		    <url>
		  <loc>'.SITE_ALPISSIME.'annonces/contact</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['annonces'].'/contact/" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'annonces/contact" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.80</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'en/'.$urlvaluemulti['annonces'].'/contact/</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['annonces'].'/contact/" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'annonces/contact" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.80</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'utilisateurs/add</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['utilisateurs'].'/add/" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'utilisateurs/add" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.64</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'en/'.$urlvaluemulti['utilisateurs'].'/add/</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['utilisateurs'].'/add/" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'utilisateurs/add" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.64</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'utilisateurs/mdpPerdu</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['utilisateurs'].'/'.$urlvaluemulti['mdpPerdu'].'" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'utilisateurs/mdpPerdu" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.64</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'en/'.$urlvaluemulti['utilisateurs'].'/'.$urlvaluemulti['mdpPerdu'].'</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['utilisateurs'].'/'.$urlvaluemulti['mdpPerdu'].'" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'utilisateurs/mdpPerdu" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.64</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'annonces/liste</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/annonces/liste/" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'annonces/liste" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.64</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'annonces/recherche</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['annonces'].'/'.$urlvaluemulti['recherche'].'/" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'annonces/recherche" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'en/'.$urlvaluemulti['annonces'].'/'.$urlvaluemulti['recherche'].'/</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['annonces'].'/'.$urlvaluemulti['recherche'].'/" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'annonces/recherche" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'utilisateurs/erreurconnexion</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['utilisateurs'].'/'.$urlvaluemulti['erreurconnexion'].'" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'utilisateurs/erreurconnexion" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'en/'.$urlvaluemulti['utilisateurs'].'/'.$urlvaluemulti['erreurconnexion'].'</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['utilisateurs'].'/'.$urlvaluemulti['erreurconnexion'].'" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'utilisateurs/erreurconnexion" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'fr-services-et-contrats-proprietaires-de-residences-secondaires/index.php</loc>
		  <lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'fr-services-et-contrats-proprietaires-de-residences-secondaires/les-arcs-conciergerie-arc-1800.php</loc>
		  <lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'fr-services-et-contrats-proprietaires-de-residences-secondaires/les-arcs-conciergerie-arc-2000.php</loc>
		  <lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'fr-services-et-contrats-proprietaires-de-residences-secondaires/conciergerie-val-d-allos.php</loc>
		  <lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'fr-services-et-contrats-proprietaires-de-residences-secondaires/conciergerie-montchavin-les-coches.php</loc>
		  <lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'sejour-ski-tout-compris</loc>
		  <lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'montagne-mon-trip-location-de-vacances-savoie-haute-savoie</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['montagne-mon-trip-location-de-vacances-savoie-haute-savoie'].'" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'montagne-mon-trip-location-de-vacances-savoie-haute-savoie" />';
		}
		  $sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'en/'.$urlvaluemulti['montagne-mon-trip-location-de-vacances-savoie-haute-savoie'].'</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['montagne-mon-trip-location-de-vacances-savoie-haute-savoie'].'" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'montagne-mon-trip-location-de-vacances-savoie-haute-savoie" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'ski-marrange-sejour-flexible-en-savoie-mont-blanc</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/free-time-ski-time-flexible-ski-holiday-in-savoie-mont-blanc" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'ski-marrange-sejour-flexible-en-savoie-mont-blanc" />';
		}
		  $sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>
		<url>
		  <loc>'.SITE_ALPISSIME.'en/free-time-ski-time-flexible-ski-holiday-in-savoie-mont-blanc'.'</loc>';
		  foreach ($allanguages as $allanguage) {
			if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/free-time-ski-time-flexible-ski-holiday-in-savoie-mont-blanc" />';
			else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'ski-marrange-sejour-flexible-en-savoie-mont-blanc" />';
		}
		$sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		  <changefreq>always</changefreq>
		  <priority>0.51</priority>
		</url>';

		foreach ($massifStat as $massif) {
			$sitemap .= '<url>
				<loc>'.SITE_ALPISSIME.'massif/'.$massif.'</loc>';
				foreach ($allanguages as $allanguage) {
				  if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['massif'].'/'.$massif.'/" />';
				  else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'massif/'.$massif.'" />';
			  }
			  $sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
				<changefreq>always</changefreq>
				<priority>0.51</priority>
			</url>';
			$sitemap .= '<url>
				<loc>'.SITE_ALPISSIME.'en/'.$urlvaluemulti['massif'].'/'.$massif.'/</loc>';
				foreach ($allanguages as $allanguage) {
				  if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['massif'].'/'.$massif.'/" />';
				  else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'massif/'.$massif.'" />';
			  }
			  $sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
				<changefreq>always</changefreq>
				<priority>0.51</priority>
			</url>';
		}

		foreach($stationsliste as $station) {
			if($station->nom_url != "") $chainetitre = $station->nom_url;
			else $chainetitre = str_replace(" ", "-", $station->name);
			$sitemap .= '<url>
		        <loc>'.SITE_ALPISSIME.'station/'.$chainetitre.'</loc>';
				foreach ($allanguages as $allanguage) {
				  if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['station'].'/'.$chainetitre.'/" />';
				  else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'station/'.$chainetitre.'" />';
			  }
			  $sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		        <changefreq>always</changefreq>
		  		<priority>0.51</priority>
		    </url>';
			$sitemap .= '<url>
		        <loc>'.SITE_ALPISSIME.'en/'.$urlvaluemulti['station'].'/'.$chainetitre.'/</loc>';
				foreach ($allanguages as $allanguage) {
				  if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['station'].'/'.$chainetitre.'/" />';
				  else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'station/'.$chainetitre.'" />';
			  }
			  $sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
		        <changefreq>always</changefreq>
		  		<priority>0.51</priority>
		    </url>';
			$a_nature_loc=array('studio'=>'std','appartement'=>'app','chalet'=>'cha','villa'=>'vil','gite'=>'git');
			foreach ($a_nature_loc as $key => $value) {
				$sitemap .= '<url>
					<loc>'.SITE_ALPISSIME.'station/'.$chainetitre.'/'.$key.'</loc>';
					foreach ($allanguages as $allanguage) {
					  if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['station'].'/'.$chainetitre.'/'.$key.'/" />';
					  else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'station/'.$chainetitre.'/'.$key.'" />';
				  }
				  $sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
					<changefreq>always</changefreq>
					<priority>0.51</priority>
				</url>';
				$sitemap .= '<url>
					<loc>'.SITE_ALPISSIME.'en/'.$urlvaluemulti['station'].'/'.$chainetitre.'/'.$key.'/</loc>';
					foreach ($allanguages as $allanguage) {
					  if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['station'].'/'.$chainetitre.'/'.$key.'/" />';
					  else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'station/'.$chainetitre.'/'.$key.'" />';
				  }
				  $sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
					<changefreq>always</changefreq>
					<priority>0.51</priority>
				</url>';
			}
		}

		foreach ($residences as $residence) {
			$sitemap .= '<url>
				<loc>'.SITE_ALPISSIME.'station/'.$residence['village']['lieugeo']->nom_url.'/residence-'.$residence->name_url.'</loc>';
				foreach ($allanguages as $allanguage) {
				  if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['station'].'/'.$residence['village']['lieugeo']->nom_url.'/residence-'.$residence->name_url.'/" />';
				  else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'station/'.$residence['village']['lieugeo']->nom_url.'/residence-'.$residence->name_url.'" />';
			  }
			  $sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
				<changefreq>always</changefreq>
				<priority>0.51</priority>
			</url>';
			$sitemap .= '<url>
				<loc>'.SITE_ALPISSIME.'en/'.$urlvaluemulti['station'].'/'.$residence['village']['lieugeo']->nom_url.'/residence-'.$residence->name_url.'/</loc>';
				foreach ($allanguages as $allanguage) {
				  if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['station'].'/'.$residence['village']['lieugeo']->nom_url.'/residence-'.$residence->name_url.'/" />';
				  else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'station/'.$residence['village']['lieugeo']->nom_url.'/residence-'.$residence->name_url.'" />';
			  }
			  $sitemap .= '<lastmod>'.date("Y-m-d").'</lastmod>
				<changefreq>always</changefreq>
				<priority>0.51</priority>
			</url>';
		}
		

		foreach($annonces as $annonce) {
			// $chainetitre = $this->string2url($annonce["titre"]);
			$natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
			$lannonce = $this->string2url($annonce["titre"]);
			$hrefDetailAnnFr = $annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;
			$hrefDetailAnnEn = $annonce['lieugeo']['nom_url'].'/'.__($natureAnnURL[$annonce['nature']]).'/'.$annonce['id']."_".$lannonce;
			$sitemap .= '<url>
		        <loc>'.SITE_ALPISSIME.'station/'.$hrefDetailAnnFr.'/'.'</loc>';
				foreach ($allanguages as $allanguage) {
				  if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['station'].'/'.$hrefDetailAnnEn.'/" />';
				  else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'station/'.$hrefDetailAnnFr.'/" />';
			  }
			  $sitemap .= '<lastmod>'.$annonce["updated_at"]->i18nFormat('yyyy-MM-dd').'</lastmod>
		        <priority>1.0</priority>
		        <changefreq>daily</changefreq>
		    </url>';
			$sitemap .= '<url>
		        <loc>'.SITE_ALPISSIME.'en/'.$urlvaluemulti['station'].'/'.$hrefDetailAnnEn.'/</loc>';
				foreach ($allanguages as $allanguage) {
				  if($allanguage->url_code != "fr") $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.$allanguage->url_code.'/'.$urlvaluemulti['station'].'/'.$hrefDetailAnnEn.'/" />';
				  else $sitemap .= '<xhtml:link rel="alternate" hreflang="'.$allanguage->url_code.'" href="'.SITE_ALPISSIME.'station/'.$hrefDetailAnnFr.'/" />';
			  }
			  $sitemap .= '<lastmod>'.$annonce["updated_at"]->i18nFormat('yyyy-MM-dd').'</lastmod>
		        <priority>1.0</priority>
		        <changefreq>daily</changefreq>
		    </url>';
		}

		$sitemap .= '</urlset>';

		$this->set('sitemap', $sitemap);
	}
	/*
	 *
	 */
	function previsualiser($id=null){
		$annonce = $this->Annonces->get($id, ['contain' => ['Utilisateurs', 'Lieugeos'] ]);
    	$this->set('annonce', $annonce);
		$session = $this->request->session();
		$an = $annonce->toArray();
		if($an['statut'] != 50){
			if(empty($session->read('Gestionnaire.info'))){
				if(empty($session->read('Auth.User.id'))) return $this->redirect(['action' => 'landing']);
				else if($an['proprietaire_id'] != $session->read('Auth.User.id')) $this->redirect(['action' => 'landing']);
			}
		}
		$photo=$this->Photos->find('all',['conditions'=>['Photos.annonce_id'=>$id],"order"=>"Photos.numero",'limit'=>10]);
		foreach($photo as $e)  $ar_ph[$e->annonce_id][]=$e->numero;
		$this->set('photos', $ar_ph);
		$a_lieu=$this->Lieugeos->find("list",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"])->toArray();
		$this->set("a_lieugeos",$a_lieu);
		$this->set('dispos', $this->Dispos->find('all',["conditions"=>["Dispos.annonce_id"=>$id,"Dispos.dbt_at >= '".date("Y-m-d")."'"],"order"=>"Dispos.dbt_at asc"]));
		$this->set('annonce_id',$id);
		$a_nature=array('STD'=>__('Studio'),'APP'=>__('Appartement'),'CHA'=>__('Chalet'),'VIL'=>__('Villa'),'GIT'=>__('Gîte'),'DIV'=>__('Autre'));
		$this->set("l_natures_location",$a_nature);
		// Nbr images
		$nbrimages = $this->Photos->find('all',['conditions'=>['Photos.annonce_id'=>$id]])->count();
		$this->set('nbrimages', $nbrimages);
		// Chercher prochaine periode
		$nbrdispo = $this->Dispos->find('all',["conditions"=>["Dispos.annonce_id"=>$id,"Dispos.dbt_at >= '".date("Y-m-d")."'"]])->count();
		$this->set('nbrdispo', $nbrdispo);
	}
	/**
	 * 
	 */
	function uploadjustificatifdomicile(){
		$this->viewBuilder()->layout(false);
		$this->autoRender = false;
		$session = $this->request->session();
		$annonce = $this->Annonces->get($this->request->data['annonce_id']);
		// UPLOAD FILE
		$msgUpload = "";
		$target_dir = "justificatifdomicile/";
		$imageFileType = strtolower(pathinfo($_FILES["uploadfile"]["name"],PATHINFO_EXTENSION));
		$namefile = "justificatif_domicile_".$annonce->id.".".$imageFileType;
		$target_file = $target_dir . $namefile;
		$uploadOk = 1;									
		// Allow certain file formats
		if($imageFileType != "pdf") {
			$msgUpload = "fileTypeError";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$msgUpload = "problem";
			$this->Flash->error(__('Le fichier n\'a pas pu etre enregistré'),['clear'=> true]);
		} else {
			if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
				$msgUpload = "OK";
				$datainjustifdomicile = array("justificatif_domicile"=>$namefile);									
				$justificatifdomicile = $this->Annonces->patchEntity($annonce, $datainjustifdomicile);
				$this->Annonces->save($justificatifdomicile);
				$this->Flash->success(__('Le fichier a été bien enregistré'),['clear'=> true]);
			} else {
				$msgUpload = "problem";
				$this->Flash->error(__('Le fichier n\'a pas pu etre enregistré'),['clear'=> true]);
			}
		}
		// END UPLOAD FILE
		$this->set('msgUpload', $msgUpload);
		$this->loadModel("Urlmultilingue");
        $urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
        $urlvaluemulti = [];
        foreach ($urlmultilinguelistes as $urlmultilingueliste) {
            $urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
        }
		$path = Router::url('/', true).$urlLang;
		return $this->redirect($path.$urlvaluemulti['annonces']."/".$urlvaluemulti['previsualiser']."/".$this->request->data['annonce_id']);
	}
	/*
	 *
	 */
	function ratingadd(){
		$this->viewBuilder()->layout(false);
		$this->loadModel("Feedbacks");
		$this->loadModel("Ratings");
		$feedback = $this->Feedbacks->newEntity($this->request->data);
		if($feed = $this->Feedbacks->save($feedback)){
			$dataconfort = array("caracteristique" => "confort",
						"note" => $this->request->data['confort'],
						"feedback_id" => $feed->id);
			$ratingconfort = $this->Ratings->newEntity($dataconfort);
			$this->Ratings->save($ratingconfort);

			$dataemplacement = array("caracteristique" => "emplacement",
						"note" => $this->request->data['emplacement'],
						"feedback_id" => $feed->id);
			$ratingemplacement = $this->Ratings->newEntity($dataemplacement);
			$this->Ratings->save($ratingemplacement);

			$dataqualiteprix = array("caracteristique" => "qualiteprix",
						"note" => $this->request->data['qualiteprix'],
						"feedback_id" => $feed->id);
			$ratingqualiteprix = $this->Ratings->newEntity($dataqualiteprix);
			$this->Ratings->save($ratingqualiteprix);
			$this->Flash->success(__('Votre commentaire a bien été envoyé. En attente de validation du gestionnaire'),['clear'=> true]);
		}
		return $this->redirect(['action' => 'view', $this->request->data['annonce_id']]);
	}
	/**
	 *
	 **/
	public function responseavis(){
		$this->viewBuilder()->layout(false);
		$this->loadModel("Feedbackresponses");
		$response = $this->Feedbackresponses->newEntity($this->request->data);
		$this->Feedbackresponses->save($response);
		return $this->redirect(['action' => 'view', $this->request->data['annonce_id']]);
	}
        /**
         * 
         */
        public function getservicesmap(){
            $this->viewBuilder()->layout(false);            
            $this->loadModel("Residences");
            $residences=$this->Residences->find('all')->contain(['Bibliotheques'])->where(["bibliotheque_id <> 1 AND bibliotheque_id <> 7"]);
            $residencesmarqueurs = [];
            foreach ($residences as $value) {
                $residencesmarqueurs[$value->id]["lat"] = $value->latitude;
                $residencesmarqueurs[$value->id]["lon"] = $value->longitude;
                $residencesmarqueurs[$value->id]["title"] = $value->name;
                $residencesmarqueurs[$value->id]["bibliotheque"] = $value['bibliotheque']['name'];
                $residencesmarqueurs[$value->id]["imgbibliotheque"] = $value['bibliotheque']['image'];
            }
            
            $this->set('residencesmap', $residencesmarqueurs);
        }
        /**
         * 
         */
        public function annoncedelete()
        {
            $this->autoRender = true ;
            $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
            $idAnnonce=$this->request->getData('annonceId');
            $annonce=$this->Annonces->get($idAnnonce);
            if($annonce==null){
                $this->set('error','undifined annonce');
                $this->set('_serialize',['error']);
                return;
            }
            $annonce->statut=40;
            $this->Annonces->save($annonce);
            $this->set('annonce',$annonce);
            $this->set('_serialize',['annonce']);
        }
	/**
	 * 
	 */
	public function inscriptionnewslettre()
	{
		$this->viewBuilder()->layout(false);
		if($this->request->data['email'] != ''){
			if(PROD_ON == 1){
				$sendinblue=new SendInBlueController();
				$result = $sendinblue->addContactNewslettreToSendInBlue($this->request->data['email']);
			}
			$this->set('result',"OK");
		}else{
			$this->set('result',"NO");
		}
		
		
	}
	/**
	 * 
	 */
	public function getcontratinfo()
	{
		$this->viewBuilder()->layout(false);
		$annonce=$this->Annonces->get($this->request->data['annonceId']);
		$this->set('contratinfo',$annonce->contrat);
		$this->set('acceptanimaux',$annonce->accept_animaux);
	}
	/**
	 * 
	 */
	public function uploadinventaire($id)
	{
		$oldannonce = $this->Annonces->get($id);
		if($this->request->data){
			// UPLOAD FILE
			$msgUpload = "";
			$target_dir = "inventaires/";
			$target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$namefile = "inventaire_annonce_".$id.".".$imageFileType;
			$target_file = $target_dir . $namefile;
			// Check if file already exists
			// if (file_exists($target_file)) {
			// 	// echo "Sorry, file already exists.";
			// 	$msgUpload = "fileExist";
			// 	$uploadOk = 0;
			// }
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf") {
				$msgUpload = "fileTypeError";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				$this->Flash->error(__('Le fichier n\'a pas pu etre enregistré'),['clear'=> true]);
				// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
					// echo "The file ". basename( $_FILES["uploadfile"]["name"]). " has been uploaded.";
					$msgUpload = "OK";
					$this->Flash->success(__('Le fichier a été bien enregistré'),['clear'=> true]);
				} else {
					$msgUpload = "problem";
					$this->Flash->error(__('Le fichier n\'a pas pu etre enregistré'),['clear'=> true]);
					// echo "Sorry, there was an error uploading your file.";
				}
			}
			// END UPLOAD FILE
			$datainventaire = array("inventaire"=>$namefile);
			
			$annonce = $this->Annonces->patchEntity($oldannonce, $datainventaire);
			$this->Annonces->save($annonce);
		}
		$this->set('annonce_inventaire', $oldannonce->inventaire);
		$this->set('annonce_id', $id);
	}
	/**
	 * 
	 */
	public function depotannonce()
	{
		$session = $this->request->session();
		if(!empty($session->read('Auth.User.id'))) return $this->redirect(['action' => 'add']);

		$this->loadModel("Lieugeos");
		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
		// $ar[""]="Choisir station";
    	foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		$this->set("l_lieugeos",$ar);

		$a_nature_loc=array('STD'=>__('Studio'),'APP'=>__('Appartement'),'CHA'=>__('Chalet'),'VIL'=>__('Villa'),'GIT'=>__('Gîte'),'DIV'=>__('Autre'));
		$this->set("l_natures_location",$a_nature_loc);
		
		$a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
		$this->set("l_nombre_personnes",$a_personne);
		
		$this->loadModel("Massif");
		$listeStations = $this->Massif->find("all")->contain('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.name NOT LIKE '%Non Affichée%'"])->order(['Lieugeos.name']);
		 })->matching('Lieugeos', function ($q) {
			return $q
				 ->select(['Lieugeos.id', 'Lieugeos.name', 'Lieugeos.niveau', 'Lieugeos.etat', "Lieugeos.massif_id"])
				 ->where(["Lieugeos.niveau >= 3", "Lieugeos.name NOT LIKE '%Non Affichée%'"])->order(['Lieugeos.name']);
		 })->group(['Massif.id'])->order(['Massif.nom']);
		$this->set("listeStations",$listeStations);

		if($this->request->is(['post'])){
			$session->write("lieugeo_id",$this->request->data['lieugeo_id']);
			$session->write("nature",$this->request->data['nature']);
			$session->write("personnes_nb",$this->request->data['personnes_nb']);
			return $this->redirect(['action' => 'add']);
		} 

		if($_GET['modal']){
			return $this->redirect(['action' => 'add']);
		// 	print_r($this->request->data);
		// 	print_r($_COOKIE);
		// 	echo "ok";
		// 	exit;
		}
	}
	/**
	 *  
	 */
	public function setchoixstationsession(){
		$this->viewBuilder()->layout(false);
		$session = $this->request->session();
		// $session->write("main_station",$this->request->data['setstation']);
		$this->set('setstation',$this->request->data['setstation']);
	}
	/**
	 * 
	 */
	public function setcenrlatlong($idStation)
	{
		$this->RequestHandler->renderAs($this, 'json'/*or xml*/);
		$this->loadModel('Lieugeos');
		$this->loadModel('Massif');
		$latInfo = "46.5782742";
        $longInfo = "4.8072428";
        $zoomInfo = 6.5; 
		if(is_numeric($idStation)){
            if($idStation != 0){
                $stationInfo = $this->Lieugeos->get($idStation);
                $latInfo = $stationInfo->latitude;
                $longInfo = $stationInfo->longitude;
                $zoomInfo = 12;
            }            
        }else if(is_string($idStation)){
            $pos = stripos($idStation, "massif_");							
            if ($pos !== false) {
                $str = str_replace("massif_", "", $idStation);   
				$massifinfo = $this->Massif->get(intval($str));
				if($massifinfo->latitude != "" && $massifinfo->longitude != ""){
					$latInfo = $massifinfo->latitude;
                    $longInfo = $massifinfo->longitude;
                    $zoomInfo = 9;
				}else{
					$stationInfo = $this->Lieugeos->find("all")->where(['massif_id' => intval($str)]);
					if($stationInfo = $stationInfo->first()){
						$latInfo = $stationInfo->latitude;
						$longInfo = $stationInfo->longitude;
						$zoomInfo = 9;
					}
				}          
            }
        }
		$this->set('latInfo', $latInfo);
        $this->set('longInfo', $longInfo);
        $this->set('zoomInfo', $zoomInfo);
        $this->set('_serialize', ['latInfo', 'longInfo', 'zoomInfo']);
	}

    /**
     *
     */
    public function uploadinventairelocataire($id)
    {
        $message  = __('Le fichier a été bien enregistré');
        $uploaded = true;
        $uploadedFileUrl = '';

        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->loadModel('Reservations');
            $reservation = $this->Reservations->find("all")->contain(['Utilisateurs', 'Annonces'])->where(['Reservations.id' => $id]);

            if ($reservation = $reservation->first()) {
                if ($this->request->query['token'] == md5($reservation->utilisateur_id)) {
                    // UPLOAD FILE
                    $imageFileType = strtolower(pathinfo($_FILES["uploadfile"]["name"],PATHINFO_EXTENSION));

                    if ($imageFileType == "pdf") {
                        $namefile    = "inventaire_locataire_".$reservation->utilisateur_id."_reservation_".$reservation->id.".".$imageFileType;

                        if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "inventaireslocataire/" . $namefile)) {
                            $datainventaire = [
                                "inventaire_loc"         => $namefile,
                                "commentaire_inventaire" => $this->request->data['commentaire_inventaire'] ? $this->request->data['commentaire_inventaire'] : ''
                            ];

                            try {
                                $inventairelocataire = $this->Reservations->patchEntity($reservation, $datainventaire);
                                $this->Reservations->save($inventairelocataire);

                                $this->loadModel("Registres");
                                $mail = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]])->first();
                                $this->loadModel("Utilisateurs");
                                $proprietaire = $this->Utilisateurs->get($reservation['annonce']->proprietaire_id);
                                $uploadedFileUrl = SITE_ALPISSIME . "inventaireslocataire/" . $reservation->inventaire_loc;
                                $datamustache = [
                                    'nom'                      => $reservation['utilisateur']->nom_famille,
                                    'prenom'                   => $reservation['utilisateur']->prenom,
                                    'prenomprop'               => $proprietaire->prenom,
                                    'nomprop'                  => $proprietaire->nom_famille,
                                    'url_inventaire_locataire' => $uploadedFileUrl,
                                    'commentaire_inventaire'   => $this->request->data['commentaire_inventaire']
                                ];
                                #####################################################
                                /*$event = new Event('Email.send', $this,
                                    [
                                        'from'      => [$mail->val=>FROM_MAIL],
                                        'to'        => $proprietaire,
                                        'textEmail' => 'recevoirInventaireLocataire',
                                        'data'      => $datamustache,
                                        'template'  => 'annoncesNotContrat',
                                        'viewVars'  => 'annoncesNotContrat',
                                        'noReply'   => false
                                ]);
                                $this->eventManager()->dispatch($event);*/
                                #####################################################
                                if (PROD_ON == 1) {
                                    $datamustachesms = [
                                        'prenom' => $reservation['utilisateur']->prenom,
                                        'nom'    => $reservation['utilisateur']->nom_famille
                                    ];
                                    // #####################################################
                                    $event = new Event('Email.sendSms', $this,
                                        [
                                            'from'    => "alpissime",
                                            'to'      => $proprietaire->portable,
                                            'textSms' => 'inventaireRempliProp',
                                            'data'    => $datamustachesms
                                        ]
                                    );
                                    $this->eventManager()->dispatch($event);
                                    // #####################################################
                                }

                                $this->loadModel("Contrats");
                                $contrat = $this->Contrats->find("all")->where(['annonce_id' => $reservation['annonce']->id]);
                                if ($reservation['annonce']->contrat == 1 && $contrat->first()) {
                                    // conciergerie si en contrat
                                    $this->loadModel("Gestionnaires");
                                    if ($annonce->id_gestionnaires != 0) {
                                        $anngest = $this->Gestionnaires->find()->where(['id'=>$annonce->id_gestionnaires]);
                                        if ($anngestnew = $anngest->first()) {
                                            $gestio = $anngestnew;
                                            /*$event = new Event('Email.send', $this,
                                                [
                                                    'from'      => $reservation['utilisateur']->email,
                                                    'to'        => $gestio->email,
                                                    'textEmail' => 'recevoirInventaireLocataire',
                                                    'data'      => $datamustache,
                                                    'template'  => 'creationReservationAdm',
                                                    'viewVars'  => 'creationReservationAdm',
                                                    'noReply'   => false
                                                ]
                                            );
                                            $this->eventManager()->dispatch($event);*/
                                        }
                                    }
                                }
                            } catch (\Exception $e) {
                                $message  = __('Le fichier n\'a pas pu etre enregistré');
                                $uploaded = false;
                            }
                        } else {
                            $message  = __('Le fichier n\'a pas pu etre enregistré');
                            $uploaded = false;
                        }
                    }
                    // END UPLOAD FILE
                } else {
                    $message  = __('Token invalide');
                    $uploaded = false;
                }
            }
        }

        if ($this->request->params['isAjax']) {
            echo json_encode([
                'success'  => $uploaded,
                'message'  => $message,
                'file_url' => $uploadedFileUrl,
            ]);
            exit;
        }

        if ($uploaded) {
            $this->Flash->success($message, ['clear'=> true]);
        } else {
            $this->Flash->error($message, ['clear'=> true]);
        }
    }

    function activatedpromotions()
    {
        @unlink(PATH_ALPISSIME."debug");
        if ($this->request->params['isAjax']) {
            $this->viewBuilder()->layout('ajax');
            $annonce = $this->Annonces->get($this->request->data['annonce_id']);
            $html = __("Vous n'avez pas activé de promotions");
            if ($annonce->proposerlastminute !== 0 || $annonce->proposerearlybooking !== 0 || $annonce->proposerlongsejours !== 0) {
                $html = __("Les promotions suivantes sont activées");
                $html .= "<ul>";

                if ($annonce->proposerearlybooking !== 0) {
                    $html .= "<li>" . __("Promotion Early Booking.") ."</li>";
                }

                if ($annonce->proposerlastminute !== 0) {
                    $html .= "<li>" . __("Promotion Last Minute.") ."</li>";
                }

                if ($annonce->proposerlongsejours !== 0) {
                    $html .= "<li>" . __("Promotion pour les Longs Séjours.") ."</li>";
                }

                $html .= "</ul>";
            }

            echo json_encode(['html' => $html]);
            exit;
        }
    }
}
