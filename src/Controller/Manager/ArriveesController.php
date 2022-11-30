<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\I18n\Date;
use mPDF;
use Cake\Log\Log;
use \DateTime;
use \DateTimeZone;
use \Google_Client;
use \Google_Service_Calendar;
use \Google_Service_Drive;
use \Google_Service_Plus;
use \Google_Service_Calendar_Event;
use \Google_Service_Calendar_EventDateTime;
use Mustache_Engine;
use App\Controller\SendInBlueController;
use App\Controller\GoogleCalendarController;
use Cake\ORM\TableRegistry;
use Mage;
/**
 * Arrivees Controller
 *
 * @property \App\Model\Table\ArriveesTable $Arrivees
 */
class ArriveesController extends AppController
{
    
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $actions=['profile','index','admincontrat','adminnonarrive','adminarrive','taxe',
            'addtaxe','sendmail','edittaxe','nonarrive','arraynonarrive','gestiontaxesejourgest',
            'gestionclearrigest','ficheclient','fichearrivee','newarrive','taxedesejour',
            'paiementtaxedesejour','envoietaxedesejour','arraynewarrive',
            'inscription','mescontrat','activationcontrat','listecontactprop','utilisateurgestionnaire',
            'editcontrat','contrat','menage','sendmailmenage','taxesejour','location','getreservation',
            'arraytaxe','codereduction'];
        $manager_actions=['nonarrive','newarrive','mescontrat','editcontrat','contrat'
            ,'taxedesejour','paiementtaxedesejour','envoietaxedesejour','listecontactprop','inscription',
            'utilisateurgestionnaire','inscription','location'];
        $admin_actions=['adminnonarrive','admincontrat','taxe'];
        if (in_array($this->request->getParam('action'), $actions)){
            $session = $this->request->session();
            if(!$session->check("Gestionnaire.info")){
                return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
            }
            $gest=$session->read('Gestionnaire.info');
            if($gest['G']['role']=="gestionnaire" && in_array($this->request->getParam('action'), $admin_actions)){
                return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
            }
            if($gest['G']['role']=="admin" && in_array($this->request->getParam('action'), $manager_actions)){
                return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
            }
        } 
    }
	/**
     * Profile method
     *
     * @return \Cake\Network\Response|null
     */
    public $paginate = [
        'limit' => 10,
        'Articles' => ['scope' => 'article'],
        'Tags' => ['scope' => 'tag']
    ];
    
    public function profile(){
      $this->loadModel('Gestionnaires');
  		$this->loadModel('Absences');
  		$this->viewBuilder()->layout('manager');
      $session = $this->request->session();
  		$gest=$session->read('Gestionnaire.info');
  		$gestionnaire=$this->Gestionnaires->get($gest['G']['id']);
  		if ($this->request->is(['patch', 'post', 'put'])) {
  			if(empty($this->request->data["absence"])){
          $gestionnaire = $this->Gestionnaires->patchEntity($gestionnaire, $this->request->data);
          
    			if(!empty($this->request->data['password'] )){
    				$gestionnaire->password = md5($this->request->data["password"]);
    			}
                        else{
                            unset($gestionnaire->password);
                        }
          if ($this->Gestionnaires->save($gestionnaire)) {
              $InfoGes=array('G'=>array('id'=>$gestionnaire->id,
                                        'role'=>$gestionnaire->role,
                                        'name'=>$gestionnaire->name,
                                        'login'=>$gestionnaire->login,
                                        'email'=>$gestionnaire->email,
                                        'telephone'=>$gestionnaire->telephone
                                        ));
			$session->write("Gestionnaire.info",$InfoGes);
            $this->set('msg','Profil modifié');
          } else {
            $this->Flash->error(__('The arrivee could not be saved. Please, try again.'));
          }
  			}else{
  				$arrivee = $this->Absences->newEntity();
  				$data=array('du'=>$this->toDate($this->request->data['debut']),
  							  'au'=>$this->toDate($this->request->data['fin']),
  							  'id_gestionnaire_present'=>$this->request->data['gestionnaire_id'],
  							  'id_gestionnaire_absent'=>$this->request->data['id']);
          $arrivee = $this->Absences->patchEntity($arrivee, $data);
  				if ($this->Absences->save($arrivee)) {
  				  $this->set('msg','Affectation avec succes');
  				}
  			}
      }
      //get pays dep ville station
      $this->loadModel('Pays');
      $pays=$this->Pays->find()->order('fr');
      $arrayPays=[0=>''];
      foreach($pays as $element)
      $arrayPays[$element->id_pays]=$element->fr;
      $this->set('pays',$arrayPays);
      //end get pays dep ville station
      if($gestionnaire->pays_id==67)
      {
          $this->loadModel('Departements');
          $departements=$this->Departements->find('all')->order('name');
          $arrayDepartements=[0=>''];
          foreach($departements as $element)
            $arrayDepartements[$element->id]= ucfirst(strtolower($element->name));
          $this->set('departements',$arrayDepartements);
          $this->loadModel('Frvilles');
          $villes=$this->Frvilles->find('all')->where(['departement_id'=>$gestionnaire->departements_id])->order('name');
      }
      elseif($gestionnaire->pays_id!=67&&$gestionnaire->pays_id!=0)
      {
          $this->loadModel('Pvilles');
          $villes=$this->Pvilles->find('all')->where(['pays_id'=>$gestionnaire->pays_id])->order('name');
      }
      $arrayVilles=[0=>''];
      foreach($villes as $element)
        $arrayVilles[$element->id]=ucfirst(strtolower($element->name));
      $this->set('ville',$arrayVilles);
      //Fin get pays dep ville station
  		$ann=$this->Gestionnaires->find('all',["conditions"=>["Gestionnaires.id!='".$gest['G']['id']."'"]]);
  		$this->set('InfoGes',$session->read('Gestionnaire.info'));
  		$this->set('gestionnaire',$gestionnaire);
  		$this->set('a_gestionnaire',$ann);
    }
    
    public function checkEmailUnique($id = null,$requestedEmail = null)
    {
          $this->loadModel('Gestionnaires');
          $utilisateur = $this->Gestionnaires->get($id);
          if(strtolower($utilisateur->email)==($requestedEmail)) {echo 'true'; die();}
          else {
              $user=$this->Gestionnaires->find()->where(['LOWER(email) LIKE ' => '%'.strtolower($requestedEmail).'%'])->first();
              if($user==null)  echo 'true';
              else echo 'false';
          }
          die();
    }
    public function checkLoginUnique($id = null,$requestedLogin = null)
    {
          $this->loadModel('Gestionnaires');
          $utilisateur = $this->Gestionnaires->get($id);
          if($utilisateur->login==$requestedLogin) {echo 'true'; die();}
          else {
              $user=$this->Gestionnaires->find()->where(['login' => $requestedLogin])->first();
              if($user==null)  echo 'true';
              else echo 'false';
          }
          die();
    }
    
    public function datasaisonremplissage($id_vacance){
        $this->loadModel('Vacances');
        if($id_vacance != 0){
          $vacance = $this->Vacances->get($id_vacance);
          $this->set('dbt',$vacance->dbt_vac);
          $this->set('fin',$vacance->fin_vac);
        }else{
          $this->set('dbt','');
          $this->set('fin','');
        }
    }
    /**
  	 *
  	 **/
    function googlecalendarinsert($reservation, $calendarId){
    //  $this->loadModel("Utilisateurs");
 		// $this->loadModel("Annonces");
 		// $this->loadModel("Reservations");
    //  $this->loadModel("Reservationtelephone");
 		// $reservation = $this->Reservations->get($reservation->id);
 		// /*** GOOGLE CALENDAR API ***/
    //  $url = str_replace('\Manager',"",__DIR__);
    //  $url = str_replace('/Manager',"",$url);
 		// putenv('GOOGLE_APPLICATION_CREDENTIALS='.$url.'/json/service_key.json');
 		// $client = new Google_Client();
 		// $client->useApplicationDefaultCredentials();
 		// $client->setAuthConfig($url.'/json/client_secret.json');
 		// $client->setAccessType("offline");        // offline access
 		// $client->setApprovalPrompt('force');
 		// $client->setScopes(implode(' ', array(
 		// 		Google_Service_Calendar::CALENDAR)
 		// ));
 		// $client->addScope(Google_Service_Plus::PLUS_ME);
 		// $client->setRedirectUri('https://accounts.google.com/o/oauth2/auth');
 		// $client->setDeveloperKey('AIzaSyDx_QCL7yY6FzNVCLazCIWLgOBr8MdoNFQ');

 		// $service = new Google_Service_Calendar($client);
 		// // $calendarId = 'admin@alpissime.com';
 		//  /** INSERT EVENT **/
 		//  	$locataire = $this->Utilisateurs->get($reservation->utilisateur_id);
 		// 	$annonce = $this->Annonces->get($reservation->annonce_id);
 		// 	$prop = $this->Utilisateurs->get($annonce->proprietaire_id);
    //    $chnum = '';
 		// 	$i = 1;
 		// 	$listenum = $this->Reservationtelephone->getListeTelephone($reservation->id);
 		// 	foreach ($listenum as $value) {
 		// 		if(!empty($value->num_tel)){
 		// 			$chnum .= ' -- Téléphone '.$i.': '.$value->num_tel;
 		// 			$i++;
 		// 		}
 		// 	}
 		// 	$start = new Google_Service_Calendar_EventDateTime();
    //    $date = new DateTime($reservation->heure_arr->i18nFormat('yyyy-MM-dd HH:mm:ss'), new DateTimeZone('Europe/Paris'));
 		// 	$date->setDate($reservation->dbt_at->i18nFormat('YYY'), $reservation->dbt_at->i18nFormat('MM'), $reservation->dbt_at->i18nFormat('dd'));
 		//   $start->setDateTime($date->format(DateTime::ATOM));
 		// 	$start->setTimeZone(new DateTimeZone('Europe/Paris'));
 		// 	$event = new Google_Service_Calendar_Event(array(
 		// 		'summary' => 'Réservation Annonce '.$reservation->annonce_id,
    //      'description' => 'Locataire: '.$locataire->email.' -- Locataire prénom: '.$locataire->prenom.' -- Locataire nom: '.$locataire->nom_famille.' -- Propriétaire: '.$prop->email.' -- Propriétaire prénom: '.$prop->prenom.' -- Propriétaire nom: '.$prop->nom_famille.' -- Départ: '.$reservation->fin_at.' -- Heure départ: '.$reservation->heure_dep.$chnum,
 		// 		'start' => $start,
 		// 		'end' => $start,
 		// 	));
 		// 	$event = $service->events->insert($calendarId, $event);
 		// 	return($event->id);
    }
    /**
     * 
     */
    function googlecalendarinsertoptioncontrat($valuedate, $calendarId)
    {
      
      // /*** GOOGLE CALENDAR API ***/
      // $url = str_replace('\Manager',"",__DIR__);
      // $url = str_replace('/Manager',"",$url);
      // putenv('GOOGLE_APPLICATION_CREDENTIALS='.$url.'/json/service_key.json');
      // $client = new Google_Client();
      // $client->useApplicationDefaultCredentials();
      // $client->setAuthConfig($url.'/json/client_secret.json');
      // $client->setAccessType("offline");        // offline access
      // $client->setApprovalPrompt('force');
      // $client->setScopes(implode(' ', array(
      //     Google_Service_Calendar::CALENDAR)
      // ));
      // $client->addScope(Google_Service_Plus::PLUS_ME);
      // $client->setRedirectUri('https://accounts.google.com/o/oauth2/auth');
      // $client->setDeveloperKey('AIzaSyDx_QCL7yY6FzNVCLazCIWLgOBr8MdoNFQ');

      // $service = new Google_Service_Calendar($client);
      // // $calendarId = 'admin@alpissime.com';
      // /** INSERT EVENT **/   
      // // Liste dates
      // $listedates = explode(";", $valuedate->dates);
      // foreach ($listedates as $value) {
      //   if($value != ""){
      //     $value = str_replace("/","-",$value);

      //     $event = new Google_Service_Calendar_Event(array(
      //       'summary' => "Annonce ID : ".$valuedate['contrat']['annonce_id']." - Option : ".$valuedate['optionscontrat']['titre'],
      //       'description' => "fgfg",
      //       'start' => array(
      //         'date' => (new Date($value))->i18nFormat('yyyy-MM-dd'),
      //         'timeZone' => 'Europe/Paris',
      //       ),
      //       'end' => array(
      //         'date' => (new Date($value))->i18nFormat('yyyy-MM-dd'),
      //         'timeZone' => 'Europe/Paris',
      //       ),
      //       'recurrence' => array(
      //         'RRULE:FREQ=YEARLY;COUNT=2'
      //       ),
      //     ));
      //     $event = $service->events->insert($calendarId, $event);
      //   }
      // }
      
    }
    /**
  	 *
  	 **/
    function googlecalendarupdate($reservation, $calendarId)
    {
    //  $this->loadModel("Utilisateurs");
 		// $this->loadModel("Annonces");
 		// $this->loadModel("Reservations");
 		// $this->loadModel("Reservationtelephone");
 		// /*** GOOGLE CALENDAR API ***/
    //  $url = str_replace('\Manager',"",__DIR__);
    //  $url = str_replace('/Manager',"",$url);
 		// putenv('GOOGLE_APPLICATION_CREDENTIALS='.$url.'/json/service_key.json');
 		// $client = new Google_Client();
 		// $client->useApplicationDefaultCredentials();
 		// $client->setAuthConfig($url.'/json/client_secret.json');
 		// $client->setAccessType("offline");        // offline access
 		// $client->setApprovalPrompt('force');
 		// $client->setScopes(implode(' ', array(
 		// 		Google_Service_Calendar::CALENDAR)
 		// ));
 		// $client->addScope(Google_Service_Plus::PLUS_ME);
 		// $client->setRedirectUri('https://accounts.google.com/o/oauth2/auth');
 		// $client->setDeveloperKey('AIzaSyDx_QCL7yY6FzNVCLazCIWLgOBr8MdoNFQ');

 		// $service = new Google_Service_Calendar($client);
 		// // $calendarId = 'admin@alpissime.com';
 		// 	/** UPDATE EVENT **/
    //    $locataire = $this->Utilisateurs->get($reservation->utilisateur_id);
 		// 	$annonce = $this->Annonces->get($reservation->annonce_id);
 		// 	$prop = $this->Utilisateurs->get($annonce->proprietaire_id);
 		// 	$chnum = '';
 		// 	$i = 1;
 		// 	$listenum = $this->Reservationtelephone->getListeTelephone($reservation->id);
 		// 	foreach ($listenum as $value) {
 		// 		if(!empty($value->num_tel)){
 		// 			$chnum .= ' -- Téléphone '.$i.': '.$value->num_tel;
 		// 			$i++;
 		// 		}
 		// 	}
    //    $event = $service->events->get($calendarId, $reservation->id_googlecalendar);
 		// 	$start = new Google_Service_Calendar_EventDateTime();
    //    $date = new DateTime($reservation->heure_arr->i18nFormat('yyyy-MM-dd HH:mm:ss'), new DateTimeZone('Europe/Paris'));
 		// 	$date->setDate($reservation->dbt_at->i18nFormat('YYY'), $reservation->dbt_at->i18nFormat('MM'), $reservation->dbt_at->i18nFormat('dd'));
 		//   $start->setDateTime($date->format(DateTime::ATOM));
 		// 	$start->setTimeZone(new DateTimeZone('Europe/Paris'));
 		//   $event->setStart($start);
 		// 	$event->setEnd($start);
    //    $event->setDescription('Locataire: '.$locataire->email.' -- Locataire prénom: '.$locataire->prenom.' -- Locataire nom: '.$locataire->nom_famille.' -- Propriétaire: '.$prop->email.' -- Propriétaire prénom: '.$prop->prenom.' -- Propriétaire nom: '.$prop->nom_famille.' -- Départ: '.$reservation->fin_at.' -- Heure départ: '.$reservation->heure_dep.$chnum);
 		// 	$updatedEvent = $service->events->update($calendarId, $event->getId(), $event);
 		// 	return true;
  	}
        public function getChanges($idG=null){
            $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
            $this->loadModel('Annonces');
            $annonces=$this->Annonces->find()
                    ->where(['Annonces.titre is not null','Annonces.updated_at is not null','Annonces.created_at is not null'])
                    ->order(['updated_at' => 'desc'])->contain(['Utilisateurs']);
            
            if($idG!=null)
                $annonces->join([
                  // 'AN' => [
                  //         'table' => 'annoncegestionnaires',
                  //         'type' => 'inner',
                  //         'conditions' => ['Annonces.id=AN.id_annonces','AN.visible=1'],
                  //       ],
                        'G' => [
                          'table' => 'gestionnaires',
                          'type' => 'INNER',
                          'conditions' => ['G.id=Annonces.id_gestionnaires',"G.id=".$idG,'Annonces.visible=1'],
                        ]
                        ]);
            $annonces->limit(8)
                    ->select(['creation'=>'Annonces.created_at=Annonces.updated_at','Annonces.id','Annonces.titre','Annonces.created_at','Annonces.updated_at','Utilisateurs.prenom','Utilisateurs.nom_famille']);
            $this->set('annonces',$annonces->toArray());
            $this->set('_serialize', 'annonces');
        }
	/**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
  public function index(){
    $this->viewBuilder()->layout('manager');
    $url=Router::url('/');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));
    $this->loadModel('Reservations');
    $this->loadModel('Utilisateurs');
    $this->loadModel('Residences');
    $this->loadModel('Villages');
    $this->loadModel('Annonces');
    $this->loadModel('Annoncegestionnaires');
    $this->loadModel('Gestionnaires');
    $this->loadModel('Dispos');
    $now = Time::parse( date('d-m-Y') );
    $after7days = Time::parse( date('d-m-Y') );
    $after7days->modify('+7 day');
    //calcul des taxes
        if($gest['G']['role']=="gestionnaire"){
          $taxes=$this->Reservations->find()
                ->join([
                        'A' => [
                          'table' => 'annonces',
                          'type' => 'inner',
                          'conditions' => ['A.id = Reservations.annonce_id','A.visible=1'],
                        ],
                        'U' => [
                          'table' => 'utilisateurs',
                          'type' => 'INNER',
                          'conditions' => ['U.id = Reservations.utilisateur_id'],
                        ],
                        'RS' => [
                          'table' => 'residences',
                          'type' => 'left',
                          'conditions' => 'A.batiment=RS.id',
                        ],
                        'V' => [
                          'table' => 'villages',
                          'type' => 'left',
                          'conditions' => 'V.id=RS.id_village',
                        ],
                        // 'AN' => [
                        //   'table' => 'annoncegestionnaires',
                        //   'type' => 'inner',
                        //   'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
                        // ],
                        'CR' => [
                          'table' => 'contrats',
                          'type' => 'INNER',
                          'conditions' => 'CR.annonce_id=A.id',
                        ],
                        'CT' => [
                          'table' => 'contratypes',
                          'type' => 'inner',
                          'conditions' => ['CT.id=CR.type'],
                        ],
                        'G' => [
                          'table' => 'gestionnaires',
                          'type' => 'INNER',
                          'conditions' => ['G.id=A.id_gestionnaires',"G.id=".$gest['G']['id']],
                        ],
                        'dispo' => [
                            'table' => 'dispos',
                            'type' => 'inner',
                            'conditions' => 'dispo.reservation_id=Reservations.id',
                        ]
                      ]);
        }
        else
        {
            $taxes=$this->Reservations->find()
                ->join([
                        'A' => [
                          'table' => 'annonces',
                          'type' => 'inner',
                          'conditions' => ['A.id = Reservations.annonce_id','A.visible=1'],
                        ],
                        'U' => [
                          'table' => 'utilisateurs',
                          'type' => 'INNER',
                          'conditions' => ['U.id = Reservations.utilisateur_id'],
                        ],
                        'RS' => [
                          'table' => 'residences',
                          'type' => 'left',
                          'conditions' => 'A.batiment=RS.id',
                        ],
                        'V' => [
                          'table' => 'villages',
                          'type' => 'left',
                          'conditions' => 'V.id=RS.id_village',
                        ],
                        // 'AN' => [
                        //   'table' => 'annoncegestionnaires',
                        //   'type' => 'inner',
                        //   'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
                        // ],
                        'CR' => [
                          'table' => 'contrats',
                          'type' => 'INNER',
                          'conditions' => 'CR.annonce_id=A.id',
                        ],
                        'CT' => [
                          'table' => 'contratypes',
                          'type' => 'inner',
                          'conditions' => ['CT.id=CR.type'],
                        ],
                        'G' => [
                          'table' => 'gestionnaires',
                          'type' => 'INNER',
                          'conditions' => 'G.id=A.id_gestionnaires',
                        ],'dispo' => [
                            'table' => 'dispos',
                            'type' => 'inner',
                            'conditions' => 'dispo.reservation_id=Reservations.id',
                        ]
                      ]);
        }
          $taxes->where(['Reservations.dbt_at <= "'.$now->format('Y-m-d').'"','Reservations.statut=90','Reservations.taxe_paye=0','Reservations.taxe=1','Reservations.fin_at >= "'.$now->format('Y-m-d').'"','Reservations.fin_at <= "'.$after7days->format('Y-m-d').'"'])
                ->group('Reservations.id')
                ->order(['Reservations.dbt_at'])
                ->select(['Reservations.id','Reservations.annonce_id','Reservations.nb_adultes', 'Reservations.nb_enfants','Reservations.dbt_at','Reservations.fin_at',
                    'Reservations.heure_dep','U.prenom','U.nom_famille','U.email','U.portable','A.ville','A.nb_etoiles','G.name']);
        $taxes = $taxes->toArray();
        
        $Taxes = TableRegistry::get('Taxes');
        for ($i = 0; $i < count($taxes); $i++) {
          $dispocontroller = new \App\Controller\DisposController();
          $dates = $taxes[$i]->dbt_at->i18nFormat('dd-MM-yyyy')."/".$taxes[$i]->fin_at->i18nFormat('dd-MM-yyyy');
		      $resultatDetail = $dispocontroller->calcultaxedesejour($taxes[$i]->annonce_id, $dates, $taxes[$i]->nb_adultes, $taxes[$i]->nb_enfants);
          $v_taxe = $resultatDetail['prixtaxeapayer'];
          // $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>$taxes[$i]['A']['ville'],"Taxes.nb_etoile"=>$taxes[$i]['A']['nb_etoiles'],"Taxes.du <='".$taxes[$i]->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$taxes[$i]->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
          // $s = strtotime( $taxes[$i]->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($taxes[$i]->dbt_at->i18nFormat('yyyy-MM-dd'));
          // $d = intval($s/86400);
          // $v_taxe=0;
          // if($r_taxe->first()){
          //   $taxe=$r_taxe->first();
          // }else{
          //   $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>32190,"Taxes.nb_etoile"=>$taxes[$i]['A']['nb_etoiles'],"Taxes.du <='".$taxes[$i]->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$taxes[$i]->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
          //   $taxe=$r_taxe->first();
          // }
          // if($taxe){
          //   $v_taxe = 0;
          //   if($taxes[$i]['A']['nb_etoiles'] == 0){
          //       /** Nouveau calcul Taxe 0* **/
          //       $list_dispos = $this->Dispos->find()->where(['Dispos.reservation_id = '.$taxes[$i]->id]);
                
          //       foreach ($list_dispos as $ldispo){
          //           $ss = strtotime( $ldispo->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($ldispo->dbt_at->i18nFormat('yyyy-MM-dd'));
          //           $dd = intval($ss/86400);
          //           //// CALCUL PRIX NUITEE
          //           if($ldispo->prix_jour == 0 && $ldispo->prix != 0 && $ldispo->promo_yn == 0){
          //               $prixnuitee = $ldispo->prix / $dd;
          //           }else if($ldispo->promo_jour == 0 && $ldispo->promo_px != 0 && $ldispo->promo_yn == 1){
          //               $prixnuitee = $ldispo->promo_px / $dd;
          //           }else if($ldispo->promo_yn == 0){
          //               $prixnuitee = $ldispo->prix_jour;
          //           }else if($ldispo->promo_yn == 1){
          //               $prixnuitee = $ldispo->promo_jour;
          //           }
          //           //// Taxe par nuitée
          //           $nouvelletaxe = ($prixnuitee / ($taxes[$i]->nb_adultes + $taxes[$i]->nb_enfants)) * ($taxe->valeur / 100);
          //           if($nouvelletaxe > 2.3) {
          //               $nouvelletaxe = 2.3 * $taxes[$i]->nb_adultes;                        
          //           }else {
          //               $nouvelletaxe = $nouvelletaxe * $taxes[$i]->nb_adultes;                        
          //           }
          //           //// Ajouter 10% taxe departementale
          //           $nouvelletaxe10 = $nouvelletaxe + ($nouvelletaxe * 1/10);
          //           //// Taxe Totale
          //           $v_taxe += $nouvelletaxe10 * $dd;                       
          //       }
          //      /** Fin Nouveau calcul Taxe 0* **/ 
          //   }else{
          //   $v_taxe=$taxe->valeur*$taxes[$i]->nb_adultes*$d;
          // }
          // }          
          $taxes[$i]['taxe']=abs(number_format($v_taxe, 2, '.', ''));
        }
        $this->set('Taxes',$taxes);
    //fin calcul des taxes
    //calcul Non Arrivee today
        $aCount = $this->Reservations->find();
        $nonArrivee = $this->Reservations->find();
        
        $nonArrivee->join([
                            'A' => [
                                    'table' => 'annonces',
                                    'type' => 'inner',
                                    'conditions' => ['A.id = Reservations.annonce_id','Reservations.dbt_at'=>  $now->i18nFormat('yyyy-MM-dd'),'A.visible=1'],// for test '2017-12-30'
                            ],
                            'U' => [
                                    'table' => 'utilisateurs',
                                    'type' => 'INNER',
                                    'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=0','Reservations.statut=90'],
                            ],
                            'RS' => [
                                    'table' => 'residences',
                                    'type' => 'left',
                                    'conditions' => 'A.batiment=RS.id',
                            ],
                            'V' => [
                                    'table' => 'villages',
                                    'type' => 'left',
                                    'conditions' => 'V.id=RS.id_village',
                            ],
                            // 'AN' => [
                            //         'table' => 'annoncegestionnaires',
                            //         'type' => 'left',
                            //         'conditions' => ['A.id=AN.id_annonces', 'AN.visible=1'],
                            // ],
                            'G' => [
                                    'table' => 'gestionnaires',
                                    'type' => 'left',
                                    'conditions' => ['G.id=A.id_gestionnaires'],
                            ],
                            'CR' => [
                              'table' => 'contrats',
                              'type' => 'INNER',
                              'conditions' => 'CR.annonce_id=A.id',
                            ],
                            'CT' => [
                                    'table' => 'contratypes',
                                    'type' => 'inner',
                                    'conditions' => ['CT.id=CR.type'],
                            ],
                            'dispo' => [
                              'table' => 'dispos',
                              'type' => 'inner',
                              'conditions' => 'dispo.reservation_id=Reservations.id',
                            ]
                            ]);
        if($gest['G']['role']!='admin'){
            $nonArrivee->where(['G.id = '=>$gest['G']['id']]);
        }
                $nonArrivee->group(['Reservations.id']);
                $nonArrivee->order(['Reservations.heure_arr'])
                ->limit(3)
                ->select(['Reservations.heure_arr','U.prenom','U.nom_famille']);
        $this->set('nonArrivee',$nonArrivee);
        $aCount->join([
						'A' => [
							'table' => 'annonces',
							'type' => 'inner',
							'conditions' => ['A.id = Reservations.annonce_id','Reservations.dbt_at'=>$now->i18nFormat('yyyy-MM-dd'),'A.visible=1'],
						],
						'U' => [
							'table' => 'utilisateurs',
							'type' => 'INNER',
							'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=1','Reservations.statut=90'],
						],
						'RS' => [
							'table' => 'residences',
							'type' => 'left',
							'conditions' => 'A.batiment=RS.id',
						],
						'V' => [
							'table' => 'villages',
							'type' => 'left',
							'conditions' => 'V.id=RS.id_village',
						],
						// 'AN' => [
						// 	'table' => 'annoncegestionnaires',
						// 	'type' => 'left',
						// 	'conditions' => ['A.id=AN.id_annonces'],
						// ],
						'G' => [
							'table' => 'gestionnaires',
							'type' => 'left',
							'conditions' => ['G.id=A.id_gestionnaires'],
						],
           'dispo' => [
             'table' => 'dispos',
             'type' => 'inner',
             'conditions' => 'dispo.reservation_id=Reservations.id',
           ]
          ]);
          if($gest['G']['role']!='admin'){
            $aCount->where(['G.id = '=>$gest['G']['id']]);
          }
          $aCount->select(['nbr' => $aCount->func()->count('*')]);
                $aCount=$aCount->first()->nbr;
                $this->set('nbArrivee',$aCount); 
    //Fin calcul Non Arrivee today
    //calcul Contrats à activer
    $NbContratsDiabled=$this->Utilisateurs->find();
    $NbContratsDiabled->join([
                            'Annonce' => [
                                    'table' => 'annonces',
                                    'type' => 'inner',
                                    'conditions' => ['Utilisateurs.id = Annonce.proprietaire_id','Annonce.contrat = 0'],
                            ],
                            'CR' => [
                              'table' => 'contrats',
                              'type' => 'INNER',
                              'conditions' => 'CR.annonce_id=Annonce.id',
                            ],
                            'CT' => [
                                    'table' => 'contratypes',
                                    'type' => 'inner',
                                    'conditions' => ['CT.id=CR.type'],
                            ],
                            ]);
    if($gest['G']['role']!='admin'){
      $NbContratsDiabled->where(['Annonce.id_gestionnaires'=>$gest['G']['id']]);
    }
    $NbContratsDiabled->select(['nbr' => $NbContratsDiabled->func()->count('*')]);   
    $NbContratsDiabled=$NbContratsDiabled->first()->nbr;
                $this->set('NbContratsDiabled',$NbContratsDiabled);
    //fin calcul Contrats à activer
    if($gest['G']['role']=='admin'){
    $annonces=$this->Annonces->find();
    $annonces->join([
            'Utilisateur' => [
            'table' => 'utilisateurs',
            'type' => 'INNER',
            'conditions' => 'Utilisateur.id = Annonces.proprietaire_id',
            ],
            'Lieugeo' => [
              'table' => 'lieugeos',
              'type' => 'inner',
              'conditions' => 'Lieugeo.id=Annonces.lieugeo_id',
            ],
            'G' => [
              'table' => 'gestionnaires',
              'type' => 'left',
              'conditions' => 'Annonces.id_gestionnaires=G.id'
            ]
      ])->where(["Annonces.statut"=>0]);
                                            
    }else{
        $annonces = $this->Residences->find();
        $annonces->join([
          'A' => [
            'table' => 'annonces',
            'type' => 'inner',
            'conditions' => ['A.batiment=Residences.id','A.id_gestionnaires'=>$gest['G']['id']]
          ],
          'U' => [
            'table' => 'utilisateurs',
            'type' => 'inner',
            'conditions' => 'U.id=A.proprietaire_id',
          ]])
          ->where(["A.statut"=>0]);
    }
            $annonces->select(['nbr' => $annonces->func()->count('*')]);
    $annonces=$annonces->first()->nbr;
    $this->set('annoncesWaitingForConfurm',$annonces);
  }
    /*
     * datamoisloyerstatisindex method
     */
    public function datamoisloyerstatisindex($id_gest, $annee, $mois){
      $this->loadModel('Dispos');
      $session = $this->request->session();
      $gest = $session->read('Gestionnaire.info');
      $gest_id = NULL;
      if($gest['G']['role'] == "gestionnaire"){
        $gest_id = $gest['G']['id'];
      }
      if($id_gest != "tous"){
        $gest_id = $id_gest;
      }
      $listePrixSurface = [];
      $listePrixSurfaceTotal = [];
      $surfaces = array('0' => 'A.surface > 0 AND A.surface <= 19', '1' => 'A.surface >= 20 AND A.surface <= 30', '2' => 'A.surface >= 31 AND A.surface <= 40', '3' => 'A.surface >= 41 AND A.surface <= 50', '4' => 'A.surface >= 51 AND A.surface <= 70', '5' => 'A.surface >= 71 AND A.surface <= 100', '6' => 'A.surface >= 101 AND A.surface <= 120', '7' => 'A.surface >= 121 AND A.surface <= 150', '8' => 'A.surface >= 151 AND A.surface <= 180', '9' => 'A.surface >= 181');
      for ($k=0; $k < 10; $k++) {
        $prixGamme = $this->Dispos->get_price_surface($gest_id, $surfaces[$k], $annee, $mois);
        $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, $surfaces[$k], $annee, $mois);
        $nbrtotalannreser = $nbrAnnResTotalSurf;
        if(is_null($prixGamme->total)) $listePrixSurface[] = 0;
        else $listePrixSurface[] = round($prixGamme->total, 2);

        $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, $surfaces[$k], $annee, $mois);
        $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, $surfaces[$k], $annee, $mois);
        $nbrtotalannreserNnreser = $nbrAnnResTotalSurfNnreser;
        if(is_null($prixGammeTotal->total)) $listePrixSurfaceTotal[] = 0;
        else $listePrixSurfaceTotal[] = round($prixGammeTotal->total, 2);

        $total[$k][] = $nbrtotalannreser;
        $total[$k][] = $nbrtotalannreserNnreser;
      }
      $this->set("listeStatMoisLoyer",$listePrixSurface);
      $this->set("listeStatMoisLoyerTotal",$listePrixSurfaceTotal);
      $this->set("listeTotal",$total);
    }
    /*
     * datasemaineloyerstatisindex method
     */
    public function datasemaineloyerstatisindex($id_gest, $from, $to){
      $this->loadModel('Dispos');
      $session = $this->request->session();
      $gest = $session->read('Gestionnaire.info');
      $gest_id = NULL;
      if($gest['G']['role'] == "gestionnaire"){
        $gest_id = $gest['G']['id'];
      }
      if($id_gest != "tous"){
        $gest_id = $id_gest;
      }
      $listePrixSurface = [];
      $listePrixSurfaceTotal = [];
      $surfaces = array('0' => 'A.surface > 0 AND A.surface <= 19', '1' => 'A.surface >= 20 AND A.surface <= 30', '2' => 'A.surface >= 31 AND A.surface <= 40', '3' => 'A.surface >= 41 AND A.surface <= 50', '4' => 'A.surface >= 51 AND A.surface <= 70', '5' => 'A.surface >= 71 AND A.surface <= 100', '6' => 'A.surface >= 101 AND A.surface <= 120', '7' => 'A.surface >= 121 AND A.surface <= 150', '8' => 'A.surface >= 151 AND A.surface <= 180', '9' => 'A.surface >= 181');
      for ($k=0; $k < 10; $k++) {
        $prixGamme = $this->Dispos->get_price_surface_date($gest_id, $surfaces[$k], $from, $to);
        $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res_date($gest_id, $surfaces[$k], $from, $to);
        $nbrtotalannreser = $nbrAnnResTotalSurf;
        if(is_null($prixGamme->total)) $listePrixSurface[] = 0;
        else $listePrixSurface[] = round($prixGamme->total, 2);

        $prixGammeTotal = $this->Dispos->get_price_surface_total_date($gest_id, $surfaces[$k], $from, $to);
        $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total_date($gest_id, $surfaces[$k], $from, $to);
        $nbrtotalannreserNnreser = $nbrAnnResTotalSurfNnreser;
        if(is_null($prixGammeTotal->total)) $listePrixSurfaceTotal[] = 0;
        else $listePrixSurfaceTotal[] = round($prixGammeTotal->total, 2);
        $total[$k][] = $nbrtotalannreser;
        $total[$k][] = $nbrtotalannreserNnreser;
      }
      $this->set("listeStatSemaineLoyer",$listePrixSurface);
      $this->set("listeStatSemaineLoyerTotal",$listePrixSurfaceTotal);
      $this->set("listeTotal",$total);
    }
    /*
     * dataanneeloyerstatisindex method
     */
    public function dataanneeloyerstatisindex($id_gest){
      $this->loadModel('Dispos');
      $session = $this->request->session();
      $gest = $session->read('Gestionnaire.info');
      $gest_id = NULL;
      if($gest['G']['role'] == "gestionnaire"){
        $gest_id = $gest['G']['id'];
      }
      if($id_gest != "tous"){
        $gest_id = $id_gest;
      }
      $listePrixSurface = [];
      $listePrixSurfaceTotal = [];
      $surfaces = array('0' => 'A.surface > 0 AND A.surface <= 19', '1' => 'A.surface >= 20 AND A.surface <= 30', '2' => 'A.surface >= 31 AND A.surface <= 40', '3' => 'A.surface >= 41 AND A.surface <= 50', '4' => 'A.surface >= 51 AND A.surface <= 70', '5' => 'A.surface >= 71 AND A.surface <= 100', '6' => 'A.surface >= 101 AND A.surface <= 120', '7' => 'A.surface >= 121 AND A.surface <= 150', '8' => 'A.surface >= 151 AND A.surface <= 180', '9' => 'A.surface >= 181');
      $month = date("n");
        if ($month<9){
            $annee = date("Y")-1;
            $annee2= date("Y");
        }
        else{
            $annee = date("Y");
            $annee2 = date("Y")+1;
        }
      for ($k=0; $k < 10; $k++) {
          
        $from = date("01-09-".$annee);
        $to = date("31-08-".$annee2);
        $prixGamme = $this->Dispos->get_price_surface_date($gest_id, $surfaces[$k], $from, $to);
        $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res_date($gest_id, $surfaces[$k], $from, $to);
        $nbrtotalannreser = $nbrAnnResTotalSurf;
        if(is_null($prixGamme->total)) $listePrixSurface[] = 0;
        else $listePrixSurface[] = round($prixGamme->total, 2);


        $prixGammeTotal = $this->Dispos->get_price_surface_total_date($gest_id, $surfaces[$k], $from, $to);
        $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total_date($gest_id, $surfaces[$k], $from, $to);
        $nbrtotalannreserNnreser = $nbrAnnResTotalSurfNnreser;
        if(is_null($prixGammeTotal->total)) $listePrixSurfaceTotal[] = 0;
        else $listePrixSurfaceTotal[] = round($prixGammeTotal->total, 2);

        $total[$k][] = $nbrtotalannreser;
        $total[$k][] = $nbrtotalannreserNnreser;
      }
      $this->set("listeStatAnneeLoyer",$listePrixSurface);
      $this->set("listeStatAnneeLoyerTotal",$listePrixSurfaceTotal);
      $this->set("listeTotal",$total);
    }
    /*
     * datamoisstatisindex method
     */
    public function datamoisstatisindex($id_gest,$year){
      $session = $this->request->session();
      $gest = $session->read('Gestionnaire.info');
      $this->loadModel('Reservations');
      $gest_id = NULL;
      if($gest['G']['role'] == "gestionnaire"){
        $gest_id = $gest['G']['id'];
      }
      if($id_gest != "tous"){
        $gest_id = $id_gest;
      }
      $listeStatArri = [];
      $listeStatNnArri = [];
      
          $annee = $year-1;
          $annee2= $year;
          
        for ($i=9; $i <= 12; $i++) {
          /*** LES ARRIVEES ***/
          $listeArrivee=$this->Reservations->get_arriv_index($gest_id, $annee , $i, NULL, 1);
          $listeStatArri[] = $listeArrivee->nbr;
          /*** LES NON ARRIVEES ***/
          $listeNnArrivee=$this->Reservations->get_arriv_index($gest_id, $annee, $i, NULL, 0);
          $listeStatNnArri[] = $listeNnArrivee->nbr;
        }
        for ($j=1; $j < 9; $j++) {
          /*** LES ARRIVEES ***/
          $listeArrivee=$this->Reservations->get_arriv_index($gest_id, $annee2, $j, NULL, 1);
          $listeStatArri[] = $listeArrivee->nbr;
          /*** LES NON ARRIVEES ***/
          $listeNnArrivee=$this->Reservations->get_arriv_index($gest_id, $annee2, $j, NULL, 0);
          $listeStatNnArri[] = $listeNnArrivee->nbr;
        }
      $this->set("listeStatArriMois",$listeStatArri);
      $this->set("listeStatNnArriMois",$listeStatNnArri);
    }
      /*
       * datasemainestatisindex method
       */
    public function datasemainestatisindex($id_gest, $annee, $mois){
      $session = $this->request->session();
      $gest = $session->read('Gestionnaire.info');
      $this->loadModel('Reservations');
      $gest_id = NULL;
      if($gest['G']['role'] == "gestionnaire"){
        $gest_id = $gest['G']['id'];
      }
      if($id_gest != "tous"){
        $gest_id = $id_gest;
      }
      $listeStatArri = [];
      $listeStatNnArri = [];
      $listeStatLabelSem = [];
      $time = mktime(0, 0, 0, $mois, 1, $annee);
      $firstWednesday = strtotime('Saturday', $time);
      $moisperid =  strftime("%d", $firstWednesday);
      if($moisperid > 1){
        $deb = 1;
        $fin = $moisperid;
        /*** LES ARRIVEES ***/
        $listeArrivee=$this->Reservations->get_arriv_semaine_index($gest_id, $annee, $mois, $deb, $fin-1, 1);
        $listeStatArri[] = $listeArrivee->nbr;
        /*** LES NON ARRIVEES ***/
        $listeNnArrivee=$this->Reservations->get_arriv_semaine_index($gest_id, $annee, $mois, $deb, $fin-1, 0);
        $listeStatNnArri[] = $listeNnArrivee->nbr;
        /*** LABELS ***/
        $listeStatLabelSem[] = $deb." - ".($fin-1);
      }
      while ($moisperid <= 31 && $mois == strftime("%m", $firstWednesday)) {
        $deb = $moisperid;
        $afterweek = strtotime("+6 day", $firstWednesday);
        if(strftime("%m", $afterweek) == $mois){
          $fin = strftime("%d", $afterweek);
        } else {
          $premierjour = mktime(0, 0, 0, $mois+1, 1, $annee);
          $premierjour--;
          $fin = strftime("%d", $premierjour);
        }
        /*** LES ARRIVEES ***/
        $listeArrivee=$this->Reservations->get_arriv_semaine_index($gest_id, $annee, $mois, $deb, $fin, 1);
        $listeStatArri[] = $listeArrivee->nbr;
        /*** LES NON ARRIVEES ***/
        $listeNnArrivee=$this->Reservations->get_arriv_semaine_index($gest_id, $annee, $mois, $deb, $fin, 0);
        $listeStatNnArri[] = $listeNnArrivee->nbr;
        /*** LABELS ***/
        $listeStatLabelSem[] = $deb." - ".$fin;
        $firstWednesday = strtotime("+1 day", $afterweek);
        $moisperid = strftime("%d", $firstWednesday);
      }
      $this->set("listeStatArriSem",$listeStatArri);
      $this->set("listeStatNnArriSem",$listeStatNnArri);
      $this->set("listeStatLabelSem",$listeStatLabelSem);
    }
    /*
     * datajourstatisindex method
     */
    public function datajourstatisindex($id_gest, $annee, $mois){
      $session = $this->request->session();
      $gest = $session->read('Gestionnaire.info');
      $this->loadModel('Reservations');
      $listeStatArri = [];
      $listeStatNnArri = [];
      $listeStatLabelSem = [];
      $dernierjour = mktime(0, 0, 0, (date("m")+1), 1, date("Y"));
      $dernierjour--;
      $dateDernierJour = strftime("%d", $dernierjour);
      $out = array(1=>'Jan', 2=>'Fev', 3=>'Mar', 4=>'Avr', 5=>'Mai', 6=>'Jun', 7=>'Jul', 8=>'Aou', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dec');
      $i = 1;
      while ($i <= $dateDernierJour) {
        /*** LES ARRIVEES ***/
        $gest_id = NULL;
        if($gest['G']['role'] == "gestionnaire"){
          $gest_id = $gest['G']['id'];
        }
        if($id_gest != "tous"){
          $gest_id = $id_gest;
        }
        $listeArrivee = $this->Reservations->get_arriv_index($gest_id, $annee, $mois, $i, 1);
        $listeStatArri[] = $listeArrivee->nbr;
        /*** LES NON ARRIVEES ***/
        $gest_id = NULL;
        if($gest['G']['role'] == "gestionnaire"){
            $gest_id = $gest['G']['id'];
        }
        if($id_gest != "tous"){
          $gest_id = $id_gest;
        }
        $listeNnArrivee = $this->Reservations->get_arriv_index($gest_id, $annee, $mois, $i, 0);
        $listeStatNnArri[] = $listeNnArrivee->nbr;
        $listeStatLabelJour[] = $i.$out[$mois];
        $i++;
      }
      $this->set("listeStatArriJour",$listeStatArri);
      $this->set("listeStatNnArriJour",$listeStatNnArri);
      $this->set("listeStatLabelJour",$listeStatLabelJour);
    }
    /*
     * dataanneeremplissagestatisindex method
     */
     public function dataanneeremplissagestatisindex($id_gest){
       $this->loadModel('Dispos');
       $session = $this->request->session();
       $gest = $session->read('Gestionnaire.info');
       $surfaces = array('0' => 'A.surface > 0 AND A.surface <= 19', '1' => 'A.surface >= 20 AND A.surface <= 30', '2' => 'A.surface >= 31 AND A.surface <= 40', '3' => 'A.surface >= 41 AND A.surface <= 50', '4' => 'A.surface >= 51 AND A.surface <= 70', '5' => 'A.surface >= 71 AND A.surface <= 100', '6' => 'A.surface >= 101 AND A.surface <= 120', '7' => 'A.surface >= 121 AND A.surface <= 150', '8' => 'A.surface >= 151 AND A.surface <= 180', '9' => 'A.surface >= 181');
       $gest_id = NULL;
       if($gest['G']['role'] == "gestionnaire"){
         $gest_id = $gest['G']['id'];
       }
       if($id_gest != "tous"){
         $gest_id = $id_gest;
       }
       $month = date("n");
        if ($month<9){
            $annee = date("Y")-1;
            $annee2= date("Y");
        }
        else{
            $annee = date("Y");
            $annee2 = date("Y")+1;
        }
       $nbrInscrAn = [];
       for ($k=0; $k < 10; $k++) {
         $nbrTotalAnnee = 0;
         $nbrOccupeAnnee = 0;
         for ($i=9; $i <= 12; $i++) {
           $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $annee, $i, $surfaces[$k]);
           $nbrTotalAnnee += $nbrTotal->nbr;

           $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $annee, $i, $surfaces[$k]);
           $nbrOccupeAnnee += $nbrOccupe->nbr;
         }
         for ($j=1; $j < 9; $j++) {
           $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $annee2, $j, $surfaces[$k]);
           $nbrTotalAnnee += $nbrTotal->nbr;

           $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $annee2, $j, $surfaces[$k]);
           $nbrOccupeAnnee += $nbrOccupe->nbr;
         }
         $occupPour = ($nbrOccupeAnnee*100)/$nbrTotalAnnee;
         $nbrInscrAn[$k] = round($occupPour, 2);
       }
       $this->set("listeStatAnneeRemplissage", $nbrInscrAn);
     }
     /*
     * datamoisremplissagestatisindex method
     */
     public function datamoisremplissagestatisindex($id_gest, $annee, $mois){
       $this->loadModel('Dispos');
       $session = $this->request->session();
       $gest = $session->read('Gestionnaire.info');
       $surfaces = array('0' => 'A.surface > 0 AND A.surface <= 19', '1' => 'A.surface >= 20 AND A.surface <= 30', '2' => 'A.surface >= 31 AND A.surface <= 40', '3' => 'A.surface >= 41 AND A.surface <= 50', '4' => 'A.surface >= 51 AND A.surface <= 70', '5' => 'A.surface >= 71 AND A.surface <= 100', '6' => 'A.surface >= 101 AND A.surface <= 120', '7' => 'A.surface >= 121 AND A.surface <= 150', '8' => 'A.surface >= 151 AND A.surface <= 180', '9' => 'A.surface >= 181');
       $gest_id = NULL;
       if($gest['G']['role'] == "gestionnaire"){
         $gest_id = $gest['G']['id'];
       }
       if($id_gest != "tous"){
         $gest_id = $id_gest;
       }
       $nbrInscrAn = [];
       for ($k=0; $k < 10; $k++) {
         $nbrTotalAnnee = 0;
         $nbrOccupeAnnee = 0;
         $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $annee-1, $mois, $surfaces[$k]);
         $nbrTotalAnnee = $nbrTotal->nbr;
         $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $annee-1, $mois, $surfaces[$k]);
         $nbrOccupeAnnee = $nbrOccupe->nbr;
         $occupPour = ($nbrOccupeAnnee*100)/$nbrTotalAnnee;
         $nbrInscrAn[$k] = round($occupPour, 2);
       }
       $this->set("listeStatMoisRemplissage", $nbrInscrAn);
     }
     /*
     * datasemaineremplissagestatisindex method
     */
     public function datasemaineremplissagestatisindex($id_gest, $from, $to){
       $this->loadModel('Dispos');
       $session = $this->request->session();
       $gest = $session->read('Gestionnaire.info');
       $surfaces = array('0' => 'A.surface > 0 AND A.surface <= 19', '1' => 'A.surface >= 20 AND A.surface <= 30', '2' => 'A.surface >= 31 AND A.surface <= 40', '3' => 'A.surface >= 41 AND A.surface <= 50', '4' => 'A.surface >= 51 AND A.surface <= 70', '5' => 'A.surface >= 71 AND A.surface <= 100', '6' => 'A.surface >= 101 AND A.surface <= 120', '7' => 'A.surface >= 121 AND A.surface <= 150', '8' => 'A.surface >= 151 AND A.surface <= 180', '9' => 'A.surface >= 181');
       $gest_id = NULL;
       if($gest['G']['role'] == "gestionnaire"){
         $gest_id = $gest['G']['id'];
       }
       if($id_gest != "tous"){
         $gest_id = $id_gest;
       }
       $nbrInscrAn = [];
       for ($k=0; $k < 10; $k++) {
         $nbrTotalAnnee = 0;
         $nbrOccupeAnnee = 0;
         $nbrTotal = $this->Dispos->get_total_dispos_date($gest_id, $from, $to, $surfaces[$k]);
         $nbrTotalAnnee = $nbrTotal->nbr;
         $nbrOccupe = $this->Dispos->get_dispos_occupe_date($gest_id, $from, $to, $surfaces[$k]);
         $nbrOccupeAnnee = $nbrOccupe->nbr;
         $occupPour = ($nbrOccupeAnnee*100)/$nbrTotalAnnee;
         $nbrInscrAn[$k] = round($occupPour, 2);
       }
       $this->set("listeStatSemaineRemplissage", $nbrInscrAn);
     }
    /**
     * View method
     *
     * @param string|null $id Arrivee id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $arrivee = $this->Arrivees->get($id, ['contain' => []]);
        $this->set('arrivee', $arrivee);
        $this->set('_serialize', ['arrivee']);
    }
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $arrivee = $this->Arrivees->newEntity();
        if ($this->request->is('post')) {
            $arrivee = $this->Arrivees->patchEntity($arrivee, $this->request->data);
            if ($this->Arrivees->save($arrivee)) {
                $this->Flash->success(__('The arrivee has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The arrivee could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('arrivee'));
        $this->set('_serialize', ['arrivee']);
    }
    /**
     * Edit method
     *
     * @param string|null $id Arrivee id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $arrivee = $this->Arrivees->get($id, ['contain' => []]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $arrivee = $this->Arrivees->patchEntity($arrivee, $this->request->data);
            if ($this->Arrivees->save($arrivee)) {
                $this->Flash->success(__('The arrivee has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The arrivee could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('arrivee'));
        $this->set('_serialize', ['arrivee']);
    }
    /**
     * Delete method
     *
     * @param string|null $id Arrivee id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $arrivee = $this->Arrivees->get($id);
        if ($this->Arrivees->delete($arrivee)) {
            $this->Flash->success(__('The arrivee has been deleted.'));
        } else {
            $this->Flash->error(__('The arrivee could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
	/**
     * Login method
     */
    function logout(){
  		$session = $this->request->session();
  		$session->delete('Gestionnaire.info');
  		return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>'manager']);
	  }
	/**
     * Admincontrat method
     *
     * @return \Cake\Network\Response|null
     */
    public function admincontrat()
    {
        $this->viewBuilder()->layout('manager');
        $session = $this->request->session();
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
    }
  /**
	 *
	 **/
	function arraycontratadmin(){
		$url=Router::url('/');
		$this->loadModel('Contrats');
		$output=$this->Contrats->get_array_contrat_admin($url,$this->request->query);
		echo json_encode($output);die();
	}
  /**
	 *
	 **/
	function adminnonarrive(){
		$this->viewBuilder()->layout('manager');
    $session = $this->request->session();
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
  /**
	 *
	 **/
	function arrayadminnonarrive(){
		$url=Router::url('/');
		$this->loadModel('Reservations');
    if(isset($this->request->query['nonArrives']) && isset($this->request->query['arrives']))
        $output=$this->Reservations->get_array_arrive_non_arrive_admin($this->request->query);
    else if(isset($this->request->query['nonArrives']))
        $output=$this->Reservations->get_array_non_arrive_admin($this->request->query);
    else if(isset($this->request->query['arrives']))
        $output=$this->Reservations->get_array_arrive_admin($this->request->query);
		echo json_encode($output);die();
	}
  /**
	 *
	 **/
	function adminarrive(){
		$this->viewBuilder()->layout('manager');
    $session = $this->request->session();
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
  /**
	 *
	 **/
	function arrayadminarrive(){
		$url=Router::url('/');
		$this->loadModel('Reservations');
		$output=$this->Reservations->get_array_arrive_admin($this->request->query);
		echo json_encode($output);die();
	}
  /**
	 *
	 **/
	function taxe(){
		$this->viewBuilder()->layout('manager');
    $session = $this->request->session();
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
  /**
   * 
   */
  public function recapitulatiftaxedesejour()
  {
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
    $this->loadModel('Gestionnaires');
    $gestionnaire = $this->Gestionnaires->find("all")->where(['role = "gestionnaire"']);
    $this->set('gestionnaire',$gestionnaire);
    $this->loadModel('Frvilles');
    $ville = $this->Frvilles->find("all")->join([
      'Taxes' => [
        'table' => 'taxes',
        'type' => 'inner',
        'conditions' => 'Frvilles.id=Taxes.id_villes',
      ]
    ])
    ->group(['Frvilles.id'])
    ->order(['name ASC']);
    $this->set('ville',$ville);
  }
  /**
	 *
	 **/
	function listtaxe(){
		$url=Router::url('/');
		$this->loadModel('Taxes');
		$output=$this->Taxes->getArrayTaxe($url,$this->request->query);
		echo json_encode($output);die();
	}
  /**
   * 
   */
  public function listrecapitulatiftaxe()
  {
		$this->loadModel('Reservations');
    $dbt = "";
    $fin = "";
    if($this->request->query['from'] != '' || $this->request->query['to'] != ''){
      if($this->request->query['from'] != ''){
        $dbt_at = $this->toDate($this->request->query['from']);
        $dbt = $dbt_at["year"]."-".$dbt_at["month"]."-".$dbt_at["day"];
      }else if($this->request->query['from'] == ''){
        $dbt_at = $this->toDate(date('d-m-Y'));
        $dbt = $dbt_at["year"]."-".$dbt_at["month"]."-".$dbt_at["day"];
      }
      if($this->request->query['to'] != ''){
        $fin_at = $this->toDate($this->request->query['to']);
        $fin = $fin_at["year"]."-".$fin_at["month"]."-".$fin_at["day"];
      }else if($this->request->query['to'] == ''){
        $fin_at = $this->toDate(date('d-m-Y'));
        $fin = $fin_at["year"]."-".$fin_at["month"]."-".$fin_at["day"];
      }
    }
		$output=$this->Reservations->getArrayTaxe($dbt, $fin, $this->request->query['gestionnaire'], $this->request->query['ville']);
		echo json_encode($output);die();
  }
  /**
	 *
	 **/
  function addtaxe(){
		$this->viewBuilder()->layout('ajax');
	}
  /**
	 *
	 **/
	function sendmail($id_gest=null,$id=null){
		$this->viewBuilder()->layout('ajax');
		$session = $this->request->session();
		$this->loadModel('Reservations');
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->set('gestionn',$gestionnaire);
		$this->set('reservation',$this->Reservations->find()->where(['Reservations.id' =>$id])->contain(['Utilisateurs'])->first());
	}
  /**
	 *
	 **/
	function sendmailvalidate(){
		$emailprop = new Email('production');
		$emailprop->template('msgToLocataire', 'default')
					->emailFormat('html')
					->to($this->request->data["vTo"])
					->from([$this->request->data["vFrom"]=>'Gestionnaire'])
					->subject(html_entity_decode($this->request->data["vObjet"]))
					->viewVars(['msg'=>$this->request->data["vMsg"]])
					->send();
		die();
	}
  /**
	 *
	 **/
	function edittaxe($id=null){
		$this->viewBuilder()->layout('ajax');
    $this->loadModel('Taxes');
    $a_taxe = $this->Taxes->get($id);
    $this->set('a_taxe',$a_taxe);
    $this->loadModel('Frvilles');
    $ville = $this->Frvilles->get($a_taxe->id_villes);
    $this->set('a_ville',$ville);
	}
  /**
	 *
	 **/
	function majtaxe(){
    $this->loadModel('Taxes');
		$data=array('du'=>$this->toDate($this->request->data["vDu"]),'au'=>$this->toDate($this->request->data["vAu"]),'nb_etoile'=>$this->request->data["vNbEtoile"],'id_villes'=>$this->request->data["vVille"],'valeur'=>$this->request->data["vTaxe"]);
		switch($this->request->data["vType"]){
			case 'add':
				$taxe=$this->Taxes->newEntity($data);
        $this->Taxes->save($taxe);
				echo "add";
			break;
			case 'modifier':
        $taxe=$this->Taxes->get($this->request->data['vId']);
				$taxe=$this->Taxes->patchEntity($taxe,$data);
				$this->Taxes->save($taxe);
				echo 'modifier';
			break;
		}
		die();
	}
  /**
	 *
	 **/
	function deletetaxe($id=null){
		$this->loadModel('Taxes');
                $taxe = $this->Taxes->get($id);
                $this->Taxes->delete($taxe);
		die();
	}
        
        function nonarriveForLayout(){
          $date = Time::parse( date('d-m-Y') );
          $session = $this->request->session();
          $info=$session->read('Gestionnaire.info');
          $this->loadModel('Absences');
          $this->loadModel('Reservations');
          if($info['G']['role']=='admin'){
              echo $this->Reservations->getArrivees($date,null,$date,null,0)->count();die();
          }
          //nombre des arrivees pour le gestionaire
          $id_gest=$info['G']['id'];
          $count=$this->Reservations->getArrivees($date,$id_gest,$date,null,0)->count();
          //chercher les abscents
          $now=date('Y-m-d');
          $abscent=$this->Absences->find()
                                  ->join([
                                          'G' => [
                                            'table' => 'gestionnaires',
                                            'type' => 'inner',
                                            'conditions' => ['G.id=Absences.id_gestionnaire_absent','Absences.id_gestionnaire_present'=>$info['G']['id']],
                                          ],
                                    ])
                                  ->select(['Absences.id','Absences.du','Absences.id_gestionnaire_absent','Absences.id_gestionnaire_present','Absences.id_gestionnaire_present','G.name','G.id' ])
                                  ->where(["Absences.du <= '$now'","Absences.au >= '$now'"])
                                  ->group(['G.id']);
          foreach ($abscent as $gst){
            $count+=$this->Reservations->getArrivees($date,$gst->id_gestionnaire_absent,$date,null,0)->count();
          }
          echo $count;die;
        }
  /**
	 *
	 **/
	function nonarrive($date = null){    
    if($date==null)  
        {
            $date = Time::parse( date('d-m-Y') );
            $this->set('dateChoisis',$date->i18nFormat('dd-MM-yyyy'));
        }
    else
        {
          $date = Time::parse($date);
          $this->set('dateChoisis',$date);
        }
    if(isset($this->request->query['datefin'])&&$this->request->query['datefin']!='')  
        {
          $this->set('dateFinChoisis',$this->request->query['datefin']);
        }
    else
        {
          $date = Time::parse( date('d-m-Y') );
          $this->set('dateFinChoisis',$date->i18nFormat('dd-MM-yyyy'));
          $this->request->query['datefin']=$date->i18nFormat('dd-MM-yyyy');
        }
        $this->set('url',Router::url('/'));

$this->viewBuilder()->layout('manager');
$session = $this->request->session();
$info=$session->read('Gestionnaire.info');
        $id_gest=$info['G']['id'];
$this->set('InfoGes',$info);
        $this->loadModel('Taxes');
$this->loadModel('Absences');
        $now=date('Y-m-d');
$res=$this->Absences->find()
                    ->join([
                      'G' => [
                              'table' => 'gestionnaires',
                              'type' => 'inner',
                              'conditions' => ['G.id=Absences.id_gestionnaire_absent','Absences.id_gestionnaire_present'=>$info['G']['id']],
                      ],
                    ])
->select(['Absences.id','Absences.du','Absences.id_gestionnaire_absent','Absences.id_gestionnaire_present','Absences.id_gestionnaire_present','G.name','G.id' ])
->where(["Absences.du <= '$now'","Absences.au >= '$now'"])
->group(['G.id']);
$this->set('res',$res);          
        $this->loadModel('Reservations');
        $this->loadModel('Utilisateurs');
        $this->loadModel('Dispos');
        if ( isset($this->request->query['absent']) && $this->request->query['absent'] != "" ){
            $arrive=$this->Reservations->find();
            $arrive->join([
                            'A' => [
                                    'table' => 'annonces',
                                    'type' => 'inner',
                                    'conditions' => ['A.id = Reservations.annonce_id','Reservations.dbt_at >= '=>$date->i18nFormat('yyyy-MM-dd'),'A.visible=1'],
                            ],
                            'U' => [
                                    'table' => 'utilisateurs',
                                    'type' => 'INNER',
                                    'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=0'],
                            ],
                            'RS' => [
                                    'table' => 'residences',
                                    'type' => 'left',
                                    'conditions' => 'A.batiment=RS.id',
                            ],
                            'V' => [
                                    'table' => 'villages',
                                    'type' => 'left',
                                    'conditions' => 'V.id=RS.id_village',
                            ],
                            // 'AN' => [
                            //         'table' => 'annoncegestionnaires',
                            //         'type' => 'inner',
                            //         'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
                            // ],
                            'CR' => [
                                    'table' => 'contrats',
                                    'type' => 'INNER',
                                    'conditions' => 'CR.annonce_id=A.id',
                            ],
                            'CT' => [
                                    'table' => 'contratypes',
                                    'type' => 'inner',
                                    'conditions' => ['CT.id=CR.type'],
                            ],
                            'G' => [
                                    'table' => 'gestionnaires',
                                    'type' => 'INNER',
                                    'conditions' => ['G.id=A.id_gestionnaires',"G.id=".$this->request->query['absent'],'Reservations.statut=90'],
                            ],
                            'dispo' => [
                              'table' => 'dispos',
                              'type' => 'inner',
                              'conditions' => 'dispo.reservation_id=Reservations.id',
                            ]
                    ]);
                    if(isset($this->request->query['datefin'])&&$this->request->query['datefin']!=''){
                      $fin = Time::parse($this->request->query['datefin']);
                      $arrive->where('(Reservations.dbt_at <= "'.$fin->i18nFormat('yyyy-MM-dd').'")');
                    }
                    if(isset($this->request->query['supp']))
                        $arrive->where(['OR' => [
                                            'LOWER(U.prenom) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
                                            'LOWER(U.nom_famille) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
                                            'LOWER(A.num_app) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
                                            'LOWER(RS.name) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
                                                ]]);
            $arrive->order(['RS.name','A.num_app + 0'])->group('Reservations.id');
            $arrive->select(['Reservations.id','Reservations.id','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.proprietaire_id','A.nb_etoiles','A.ville','A.num_app','RS.name','V.name']);
            //$arrive->group(['Reservations.id']);
            $this->set('nbArrivees',count($arrive->toArray()));
            $this->paginate = [
                'limit' => $this->request->query['limite']?intval($this->request->query['limite']):10,
            ];
            $this->set('nbArrivees',count($this->Reservations->getArrivees($date,$id_gest,$this->request->query['datefin'],$this->request->query['supp'],0)->toArray()));
            $this->set('tabArr', $this->paginate($arrive, ['model' => 'Reservations']));

            $taxes=[];
            $messageimpo=[];
            foreach($arrive as $c)
            {
              $dispocontroller = new \App\Controller\DisposController();
              $dates = $c->dbt_at->i18nFormat('dd-MM-yyyy')."/".$c->fin_at->i18nFormat('dd-MM-yyyy');
              $resultatDetail = $dispocontroller->calcultaxedesejour($c->annonce_id, $dates, $c->nb_adultes, $c->nb_enfants);
              $v_taxe = $resultatDetail['prixtaxeapayer'];
              $messageimpotext = $resultatDetail['messageimpotext'];
                $messageimpo[$c->id] = $messageimpotext;
                $taxes[$c->id]=number_format($v_taxe, 2, ',', '');

            }
            $this->set('messageimpo',$messageimpo);
            $this->set('absent',$this->request->query['absent']);
        }
        else{
            $arrive=$this->Reservations->find();
            $arrive->join([
                            'A' => [
                                    'table' => 'annonces',
                                    'type' => 'inner',
                                    'conditions' => ['A.id = Reservations.annonce_id','Reservations.dbt_at >='=>$date->i18nFormat('yyyy-MM-dd'),'Reservations.dbt_at !='=>'0000-00-00','A.visible=1'],
                            ],
                            'U' => [
                                    'table' => 'utilisateurs',
                                    'type' => 'INNER',
                                    'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=0'],
                            ],
                            'RS' => [
                                    'table' => 'residences',
                                    'type' => 'left',
                                    'conditions' => 'A.batiment=RS.id',
                            ],
                            'V' => [
                                    'table' => 'villages',
                                    'type' => 'left',
                                    'conditions' => 'V.id=RS.id_village',
                            ],
                            // 'AN' => [
                            //         'table' => 'annoncegestionnaires',
                            //         'type' => 'inner',
                            //         'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
                            // ],
                            'CR' => [
                                    'table' => 'contrats',
                                    'type' => 'INNER',
                                    'conditions' => 'CR.annonce_id=A.id',
                            ],
                            'CT' => [
                                    'table' => 'contratypes',
                                    'type' => 'inner',
                                    'conditions' => ['CT.id=CR.type'],
                            ],
                            'G' => [
                                    'table' => 'gestionnaires',
                                    'type' => 'INNER',
                                    'conditions' => ['G.id=A.id_gestionnaires',"G.id=".$id_gest,'Reservations.statut=90'],
                            ],
                            'dispo' => [
                              'table' => 'dispos',
                              'type' => 'inner',
                              'conditions' => 'dispo.reservation_id=Reservations.id',
                            ]
            ]);
            if(isset($this->request->query['datefin']) && $this->request->query['datefin']!=''){
              $fin = Time::parse($this->request->query['datefin']);
              $arrive->where('(Reservations.dbt_at <= "'.$fin->i18nFormat('yyyy-MM-dd').'")');
            }
            if(isset($this->request->query['supp']))
                            $arrive->where(['OR' => [
                                            'LOWER(U.prenom) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
                                            'LOWER(U.nom_famille) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
                                            'LOWER(A.num_app) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
                                            'LOWER(RS.name) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
                                                ]]);
            $arrive->order(['RS.name','A.num_app + 0'])->group('Reservations.id');
            $arrive->select(['Reservations.id','Reservations.dbt_at','Reservations.annonce_id','Reservations.fin_at','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.proprietaire_id','A.nb_etoiles','A.ville','A.num_app','RS.name','V.name']);
            $count=count($arrive->toArray());
            $this->set('nbArrivees',$count);
            $this->paginate['Reservations'] = [
              'limit' => $this->request->query['limite']?intval($this->request->query['limite']):10,
            ];
            $this->set('tabArr', $this->paginate($arrive));

            $taxes=[];
            $messageimpo=[];
            foreach($arrive as $c)
            {
              $dispocontroller = new \App\Controller\DisposController();
              $dates = $c->dbt_at->i18nFormat('dd-MM-yyyy')."/".$c->fin_at->i18nFormat('dd-MM-yyyy');
              $resultatDetail = $dispocontroller->calcultaxedesejour($c->annonce_id, $dates, $c->nb_adultes, $c->nb_enfants);
              $v_taxe = $resultatDetail['prixtaxeapayer'];
              $messageimpotext = $resultatDetail['messageimpotext'];
                    
                    $messageimpo[$c->id] = $messageimpotext;
                    $taxes[$c->id]=number_format($v_taxe, 2, ',', '');

                  }
            $this->set('messageimpo',$messageimpo);
        }
//dd($arrive->toArray());
$gestArr=[];
// dd($res->toArray());
foreach ($res as $gst){
        $arrive=$this->Reservations->find();
            $arrive->join([
                            'A' => [
                                    'table' => 'annonces',
                                    'type' => 'inner',
                                    'conditions' => ['A.id = Reservations.annonce_id','Reservations.dbt_at >= '=>$date->i18nFormat('yyyy-MM-dd'),'A.visible=1'],
                            ],
                            'U' => [
                                    'table' => 'utilisateurs',
                                    'type' => 'INNER',
                                    'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=0'],
                            ],
                            'RS' => [
                                    'table' => 'residences',
                                    'type' => 'left',
                                    'conditions' => 'A.batiment=RS.id',
                            ],
                            'V' => [
                                    'table' => 'villages',
                                    'type' => 'left',
                                    'conditions' => 'V.id=RS.id_village',
                            ],
                            // 'AN' => [
                            //         'table' => 'annoncegestionnaires',
                            //         'type' => 'inner',
                            //         'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
                            // ],
                            'CR' => [
                                    'table' => 'contrats',
                                    'type' => 'INNER',
                                    'conditions' => 'CR.annonce_id=A.id',
                            ],
                            'CT' => [
                                    'table' => 'contratypes',
                                    'type' => 'inner',
                                    'conditions' => ['CT.id=CR.type'],
                            ],
                            'G' => [
                                    'table' => 'gestionnaires',
                                    'type' => 'INNER',
                                    'conditions' => ['G.id=A.id_gestionnaires',"G.id=".$gst->id_gestionnaire_absent,'Reservations.statut=90'],
                            ],
                            'dispo' => [
                              'table' => 'dispos',
                              'type' => 'inner',
                              'conditions' => 'dispo.reservation_id=Reservations.id',
                            ]
                    ]);
            if(isset($this->request->query['datefin']) && $this->request->query['datefin']!=''){
              $fin = Time::parse($this->request->query['datefin']);
              $arrive->where('(Reservations.dbt_at <= "'.$fin->i18nFormat('yyyy-MM-dd').'")');
            }
            if(isset($this->request->query['supp']))
                            $arrive->where(['OR' => [
                                            'LOWER(U.prenom) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
                                            'LOWER(U.nom_famille) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
                                            'LOWER(A.num_app) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
                                            'LOWER(RS.name) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
                                                ]]);
                            $arrive->group('Reservations.id');
                            $arrive->select(['Reservations.id','Reservations.id','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.proprietaire_id','A.nb_etoiles','A.ville','A.num_app','RS.name','V.name']);
            $gestArr[]=["gestionaire"=> $gst->G,"NonArrives"=>$arrive->count()];
        
}
        $this->set('gestArr',$gestArr);
        $this->set('taxes',$taxes);
/////////////////////////////////////
    $tabMailInfo = [];
    foreach ($arrive as $c) {
      $tabMailInfo[$c->id] = [];

      // Taxe de séjour
      $dispocontroller = new \App\Controller\DisposController();
      $dates = $c->dbt_at->i18nFormat('dd-MM-yyyy')."/".$c->fin_at->i18nFormat('dd-MM-yyyy');
      $resultatDetail = $dispocontroller->calcultaxedesejour($c->annonce_id, $dates, $c->nb_adultes, $c->nb_enfants);
      $v_taxe = $resultatDetail['prixtaxeapayer'];

      $r_prop=$this->Utilisateurs->find('all',["conditions"=>["Utilisateurs.id"=>$c['A']['proprietaire_id']]]);
      if($r_prop->first()){
        $prop=$r_prop->first();
        $tabMailInfo[$c->id]['prenomprop']=$prop->prenom;
        $tabMailInfo[$c->id]['nomprop']=$prop->nom_famille;
      }
      $tabMailInfo[$c->id]['taxe'] = number_format($v_taxe, 2, ',', '');
      $tabMailInfo[$c->id]['prenom'] = $c['U']['prenom'];
      $tabMailInfo[$c->id]['nom'] = $c['U']['nom_famille'];
    }
    $this->set('tabMailInfo', $tabMailInfo);
    $mail = [];
    $this->loadModel("Modelmailsysteme");
    $textEmail = $this->Modelmailsysteme->find('all');
    foreach ($textEmail as $key => $value) {
    $mail[$value->titre] = $value->txtmail;
    }
    $this->set("textmail",$mail);
  }
  /**
	 *
	 **/
		function arraynonarrive(){
		$this->viewBuilder()->layout('ajax');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		if(!empty($this->request->query['id_gest'])){
			$id_gest=$this->request->query['id_gest'];
		}else{
			$id_gest=$gestionnaire['G']['id'];
		}
		$url=Router::url('/');
		$aColumns = array( 'A.num_app','RS.name','U.nom_famille');
		$sOrder=array();
		if ( isset( $this->request->query['iSortCol_0'] ) )
		{
			for ( $i=0 ; $i<intval($this->request->query['iSortingCols'] ) ; $i++ )
			{
				if ( $this->request->query[ 'bSortable_'.intval($this->request->query['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder [$i]= $aColumns[ intval( $this->request->query['iSortCol_'.$i] ) ]." ".$this->request->query['sSortDir_'.$i]  ;
				}
			}
		}
		$orWhere = array();
		if ( isset($this->request->query['sRechercher']) && $this->request->query['sRechercher'] != "" )
		{
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$orWhere[$i]= " LOWER(".$aColumns[$i].") LIKE '%". strtolower($this->request->query['sRechercher'])."%'";
			}
		}
		$awhere=array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( isset($this->request->query['bSearchable_'.$i]) && $this->request->query['bSearchable_'.$i] == "true" && $this->request->query['sSearch_'.$i] != '' )
			{
				$aWhere[$i]= $aColumns[$i]." LIKE '%".$this->request->query['sSearch_'.$i]."%'";
			}
		}
		$this->loadModel('Reservations');
		$now = Time::parse($this->request->data['from']);
		$arrive=$this->Reservations->find();
		$cArrive=$this->Reservations->find();
		$arrive->join([
				'A' => [
					'table' => 'annonces',
					'type' => 'inner',
					'conditions' => ['A.id = Reservations.annonce_id','Reservations.dbt_at'=>$now->i18nFormat('yyyy-MM-dd')],
				],
				'U' => [
					'table' => 'utilisateurs',
					'type' => 'INNER',
					'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=0'],
				],
				'RS' => [
					'table' => 'residences',
					'type' => 'left',
					'conditions' => 'A.batiment=RS.id',
				],
				'V' => [
					'table' => 'villages',
					'type' => 'left',
					'conditions' => 'V.id=RS.id_village',
				],
				// 'AN' => [
				// 	'table' => 'annoncegestionnaires',
				// 	'type' => 'inner',
				// 	'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
				// ],
				'CR' => [
					'table' => 'contrats',
					'type' => 'INNER',
					'conditions' => 'CR.annonce_id=A.id',
				],
				'CT' => [
					'table' => 'contratypes',
					'type' => 'inner',
					'conditions' => ['CT.id=CR.type'],
				],
				'G' => [
					'table' => 'gestionnaires',
					'type' => 'INNER',
					'conditions' => ['G.id=A.id_gestionnaires',"G.id=".$id_gest,'Reservations.statut=90'],
				],
        'dispo' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => 'dispo.reservation_id=Reservations.id',
        ]
			])
			->select(['Reservations.id','Reservations.dbt_at','Reservations.annonce_id','Reservations.fin_at','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.nb_etoiles','A.ville','A.num_app','RS.name','V.name']);
		$cArrive->join([
				'A' => [
					'table' => 'annonces',
					'type' => 'inner',
					'conditions' =>['A.id = Reservations.annonce_id','Reservations.dbt_at'=>$now->i18nFormat('yyyy-MM-dd')],
				],
				'U' => [
					'table' => 'utilisateurs',
					'type' => 'INNER',
					'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=0'],
				],
				'RS' => [
					'table' => 'residences',
					'type' => 'left',
					'conditions' => 'A.batiment=RS.id',
				],
				'V' => [
					'table' => 'villages',
					'type' => 'left',
					'conditions' => 'V.id=RS.id_village',
				],
				// 'AN' => [
				// 	'table' => 'annoncegestionnaires',
				// 	'type' => 'inner',
				// 	'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
				// ],
				'CR' => [
					'table' => 'contrats',
					'type' => 'INNER',
					'conditions' => 'CR.annonce_id=A.id',
				],
				'CT' => [
					'table' => 'contratypes',
					'type' => 'inner',
					'conditions' => ['CT.id=CR.type'],
				],
				'G' => [
					'table' => 'gestionnaires',
					'type' => 'INNER',
					'conditions' => ['G.id=A.id_gestionnaires',"G.id=".$id_gest,'Reservations.statut=90'],
				],
        'dispo' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => 'dispo.reservation_id=Reservations.id',
        ]
			]);
      $arrive->group('Reservations.id');
      $cArrive->group('Reservations.id');
		if(!empty($orWhere)){
			$arrive->where([$awhere,"OR"=>$orWhere]);
			$cArrive->where([$awhere,"OR"=>$orWhere]);
		}
		$start=1;
		if($this->request->query['iDisplayStart']>0){
			$start=($this->request->query['iDisplayStart']/$this->request->query['iDisplayLength'])+1;
		}
		$arrive->order($sOrder)
			->limit($this->request->query['iDisplayLength'])
			->page($start);
		$count=$cArrive->count();
		$output = array(
			"sEcho" => intval($this->request->query['sEcho']),
			"iTotalRecords" => $count,
			"iTotalDisplayRecords" => $count,
			"data" => array()
		);
                $tot="";
		$this->loadModel('Taxes');
		$i=0;
		foreach($arrive as $c)
		{
      $row = array();
      // Taxe de séjour
      $dispocontroller = new \App\Controller\DisposController();
      $dates = $c->dbt_at->i18nFormat('dd-MM-yyyy')."/".$c->fin_at->i18nFormat('dd-MM-yyyy');
      $resultatDetail = $dispocontroller->calcultaxedesejour($c->annonce_id, $dates, $c->nb_adultes, $c->nb_enfants);
      $v_taxe = $resultatDetail['prixtaxeapayer'];

			// $r_taxe=$this->Taxes->find('all',["conditions"=>["Taxes.id_villes"=>$c['A']['ville'],"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
			// $s = strtotime( $c->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($c->dbt_at->i18nFormat('yyyy-MM-dd'));
			// $d = intval($s/86400);
			// $v_taxe=0;
			// if($r_taxe->first()){
      //   $taxe=$r_taxe->first();
      // }else{
      //   $r_taxe=$this->Taxes->find('all',["conditions"=>["Taxes.id_villes"=>32190,"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
      //   $taxe=$r_taxe->first();
      // }
      // if($taxe){
                                
      //                           $v_taxe = 0;
      //                           if($c['A']['nb_etoiles'] == 0){
      //                               /** Nouveau calcul Taxe 0* **/
      //                               $list_dispos = $this->Dispos->find()->where(['Dispos.reservation_id = '.$c->id]);

      //                               foreach ($list_dispos as $ldispo){
      //                                   $ss = strtotime( $ldispo->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($ldispo->dbt_at->i18nFormat('yyyy-MM-dd'));
      //                                   $dd = intval($ss/86400);
      //                                   //// CALCUL PRIX NUITEE
      //                                   if($ldispo->prix_jour == 0 && $ldispo->prix != 0 && $ldispo->promo_yn == 0){
      //                                       $prixnuitee = $ldispo->prix / $dd;
      //                                   }else if($ldispo->promo_jour == 0 && $ldispo->promo_px != 0 && $ldispo->promo_yn == 1){
      //                                       $prixnuitee = $ldispo->promo_px / $dd;
      //                                   }else if($ldispo->promo_yn == 0){
      //                                       $prixnuitee = $ldispo->prix_jour;
      //                                   }else if($ldispo->promo_yn == 1){
      //                                       $prixnuitee = $ldispo->promo_jour;
      //                                   }
      //                                   //// Taxe par nuitée/personne
      //                                   $nouvelletaxe = ($prixnuitee / ($c->nb_adultes + $c->nb_enfants)) * ($taxe->valeur / 100);
      //                                   if($nouvelletaxe > 2.3) {
      //                                       $nouvelletaxe = 2.3  * $c->nb_adultes;                        
      //                                   }else {
      //                                       $nouvelletaxe = $nouvelletaxe  * $c->nb_adultes;                        
      //                                   }
      //                                   //// Ajouter 10% taxe departementale
      //                                   $nouvelletaxe10 = $nouvelletaxe + ($nouvelletaxe * 1/10);
      //                                   //// Taxe Totale
      //                                   $v_taxe += $nouvelletaxe10 * $dd;                       
      //                               }
      //                              /** Fin Nouveau calcul Taxe 0* **/ 
      //                           }else{
			// 	$v_taxe=$taxe->valeur*$c->nb_adultes*$d;
			// }
                                
			// 	//$v_taxe=$taxe->valeur*$c->nb_adultes*$d;
      // }
      

			if($i%2) $arr="<table class='tbl_info_arr' >";
			else $arr="<table class='tbl_info_arr bg-c' >";
			if($i==0){
				$arr.="<tr><td width='18%' class='td_title'>Date d'arrivée</td><td width='10%' class='td_title'>Date de départ</td><td width='12%' class='td_title'>Nom du locataire</td><td width='10%' class='td_title'>Téléphone</td><td width='14%' class='td_title'>E-mail</td><td width='8%'class='td_title'><center>NB adulte(s)</center></td><td width='8%' class='td_title'><center>enfant(s)</center></td></tr>";
			}
			$arr.="<tr><td width='18%'>".$c->dbt_at->i18nFormat('dd-MM-yyyy')."</td><td width='10%'>".$c->fin_at->i18nFormat('dd-MM-yyyy')."</td><td width='12%'>".$c['U']['prenom']." ".$c['U']['nom_famille']."</td><td width='10%'>".$c['U']['portable']."</td><td width='14%'>".$c['U']['email']."</td><td width='8%'><center>".$c->nb_adultes."</center></td><td width='8%'><center>".$c->nb_enfants."</center></td></tr>";
			$arr.="<tr><th >Village : ".$c['V']['name']."</th><td></td><th colspan=2>Résidence : ".$c['RS']['name']."</th><th >N° app  : ".$c['A']['num_app']."</th><th colspan=2>Position clé : ".$c['A']['position_cle']."</th></tr>";
      $arr.="<tr><td colspan=6 class='td_title'><center>COMMENTAIRES</center></td></tr>";
      $arr.="<tr><td colspan=3><strong>Propriétaire : </strong>".$c->comment."</td><td colspan=4><strong>Locataire : </strong>".$c->commentlocataire."</td></tr>";
			$taxe="<strong style='font-size:14px;color:#f00'>Non</strong>";
      $gestiontaxe = "";
			if($c->taxe==1){
        $taxe="<strong style='font-size:14px;color:#51a351'>Oui</strong>";
        $gestiontaxe = "<a href='".$url."manager/arrivees/gestiontaxesejourgest/".$c->id."' class='btn btn-info btn-gestiontaxe edit_locataire'>Gestion Taxe</a>&nbsp;&nbsp;";
      }
			$arr.="<tr><th colspan=2>Taxe de séjour gérée par alpissime : ".$taxe."</th><th >Taxe : ".number_format($v_taxe, 2, ',', '')." &euro;</th><td style='text-align:right;' colspan=4>".$gestiontaxe."<a href='".$url."manager/arrivees/gestionclearrigest/".$c['A']['id']."/".$c->id."' class='btn btn-info edit_locataire'>Gestion Clé</a>&nbsp;&nbsp;<a href='".$url."manager/arrivees/ficheclient/".$c['A']['id']."' class='btn btn-info edit_locataire'>Fiche proprietaire</a>&nbsp;&nbsp;<a href='".$url."manager/arrivees/sendmail/".$gestionnaire['G']['id']."/".$c->id."' class='btn btn-success edit_locataire'>Envoyer message</a>&nbsp;&nbsp;<a href='".$url."manager/arrivees/fichearrivee/".$gestionnaire['G']['id']."/".$c->id."' class='btn btn-success edit_locataire'>Modifier l'arrivée</a>&nbsp;&nbsp;<a data-G='".$gestionnaire['G']['id']."' data-key=\"".$c->id."\" class='btn btn-success validation_".$gestionnaire['G']['id']."' data-name=\"".$c['U']['prenom']." ".$c['U']['nom_famille']."\"  title=\"Supprimé\">Valider l'arrivée</a></td></tr>";
			$arr.="<table>";
			$row[0]=$arr;
			$output['data'][] = $row;
                        if($c->taxe==1) $taxe="Oui"; else $taxe="Non";
                        $tot = "<div class=\"row panel_content\">"
                                                    ."<div class=\"col-sm-2\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">Date d'arrivée :&nbsp;</span>&nbsp;".$c->dbt_at->i18nFormat('dd-MM-yyyy')."</div>"
                                                    ."<div class=\"col-sm-2\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">Date de départ :&nbsp;</span>&nbsp;".$c->fin_at->i18nFormat('dd-MM-yyyy')."</div>"
                                                    ."<div class=\"col-sm-3\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">Nom du locataire :&nbsp;</span>&nbsp;".$c['U']['prenom']." ".$c['U']['nom_famille']."</div>"
                                                    ."<div class=\"col-sm-2\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">Téléphone :&nbsp;</span>&nbsp;".$c['U']['portable']."</div>"
                                                    ."<div class=\"col-sm-3\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">E-mail :&nbsp;</span>&nbsp;".$c['U']['email']."</div>"
                                                    ."<div class=\"col-sm-2\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">NB adulte(s) :&nbsp;</span>&nbsp;".$c->nb_adultes."</div>"
                                                    ."<div class=\"col-sm-2\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">enfant(s) :&nbsp;</span>&nbsp;".$c->nb_enfants."</div>"
                                                    ."<div class=\"col-sm-3\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">Village :&nbsp;</span>&nbsp;".$c['V']['name']."</div>"
                                                    ."<div class=\"col-sm-2\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">Résidence :&nbsp;</span>&nbsp;".$c['RS']['name']."</div>"
                                                    ."<div class=\"col-sm-2\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">N° app :&nbsp;</span>&nbsp;".$c['A']['num_app']."</div>"
                                                    ."<div class=\"col-sm-2\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">Position clé :&nbsp;</span>&nbsp;".$c['A']['position_cle']."</div>"
                                                    ."<div class=\"col-sm-5\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">Taxe de séjour gérée par alpissime :&nbsp;</span>&nbsp;".$taxe."</div>"
                                                    ."<div class=\"col-sm-5\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">Taxe :&nbsp;</span>&nbsp;".number_format($v_taxe, 2, ',', '')." &euro;</div>"
                                                    ."<div class=\"col-sm-6\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">Commentaire Propriétaire :&nbsp;</span>&nbsp;".$c->comment."</div>"
                                                    ."<div class=\"col-sm-6\"><span class=\"pull-left weight-600 txt-dark uppercase-font\">Commentaire Locataire :&nbsp;</span>&nbsp;".$c->commentlocataire."</div>"
                                                    ."<div class=\"col-sm-12\">Buttons</div>"
                                                ."</div>";
			$i++;
		}
		echo $tot;die();
	}
  /**
	 *
	 **/
  public function gestiontaxesejourgest($res_id = null){
    $this->viewBuilder()->layout('ajax');
    $this->set("reservid",$res_id);
    $this->loadModel('Reservations');
    $reserv = $this->Reservations->get($res_id);
    $this->set("reservation",$reserv);
  }
  /**
	 *
	 **/
  public function gestionclearrigest($id = null, $res_id = null, $new = null){
    $this->viewBuilder()->layout('ajax');
		$this->loadModel('Annonces');
		$clepos = $this->Annonces->find()->where(['id'=>$id]);
		$this->set("clepos",$clepos->first());
    $this->loadModel('Reservations');
    $reserv = $this->Reservations->get($res_id);
    $this->set("reservation",$reserv);
    $this->set("reservid",$res_id);
    if($new != null){
      $this->set("new", $new);
    }else{
      $this->set("new", "");
    }
    $derlocataire = $this->Reservations->dernierlocatairearr($id);
    $this->set("dernierelocataire",$derlocataire->first());
  }
  /**
	 *
	 **/
  public function modifiergesttaxearrivee(){
    $this->loadModel('Reservations');
    $datareser=array("taxe_paye" => $this->request->data['vTaxepaye'], "methode_paye" => $this->request->data['vTaxepaye']=="1"?$this->request->data['vMethodepaye']:'0');
    $res = $this->Reservations->get($this->request->data['vReservid']);
    $reserpat = $this->Reservations->patchEntity($res, $datareser);
    $this->Reservations->save($reserpat);
    die();
  }
  /**
	 *
	 **/
  public function modifiergestclearrivee(){
    $this->loadModel('Annonces');
    $this->loadModel('Reservations');
    $datareser=array("p_cle" => $this->request->data['vPcle']);
    $res = $this->Reservations->get($this->request->data['vReservid']);
    $reserpat = $this->Reservations->patchEntity($res, $datareser);
    $this->Reservations->save($reserpat);
		if( $this->request->data['vPoscle'] == ""){
			$pos = 0;
		}else{
			$pos = $this->request->data['vPoscle'];
		}
		$data=array("position_cle" => $pos);
		$anngestcle = $this->Annonces->find()->where(['id'=>$res->annonce_id]);
		$anngest = $this->Annonces->patchEntity($anngestcle->first(), $data);
    $this->Annonces->save($anngest);
    echo $pos;
    die();
  }
  /**
	 *
	 **/
	public function ficheclient($id=null){
		$this->loadModel('Annonces');
		$this->loadModel('Utilisateurs');
		$this->viewBuilder()->layout('ajax');
		$ann=$this->Annonces->get($id);
                $user=$this->Utilisateurs->getdetailuser($ann->proprietaire_id);
                $this->loadModel("Frvilles");
                if($user->pays == 67){
                    $paysuser = $this->Frvilles->find()->where(['id' => $user->ville])->first();                    
                    $paysname = $paysuser->name;
                }else{
                    $paysname = $user['PV']['name'];
                }
                $this->set('paysname',$paysname);
		$this->set('user',$user);
	}
  /**
	 *
	 **/
	function fichearrivee($id_gest=null,$id){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel('Reservations');
		$this->loadModel('Utilisateurs');
		$reservation=$this->Reservations->get($id);
    $this->loadModel('Annonces');
    $positioncle = $this->Annonces->find()->where(['id'=>$reservation->annonce_id]);
    $this->set('positioncle',$positioncle->first());

		$user=$this->Utilisateurs->get($reservation->utilisateur_id);
		$this->set('id_gest',$id_gest);
		$this->set('reservation',$reservation);
		$this->set('user',$user);

    $this->loadModel("Reservationtelephone");
		$restel=$this->Reservationtelephone->getListeTelephone($id);
		$this->set("restel",$restel);
		$this->set("nbrrestel",$restel->count());
	}
  /**
	 *
	 **/
	function editarrive(){
		$this->loadModel('Reservations');
		$this->loadModel('Utilisateurs');
		$this->loadModel('Annonces');
    $this->loadModel('Annoncegestionnaires');
    $this->loadModel('Gestionnaires');

		$reservation=$this->Reservations->get($this->request->data['vId']);
    $heureArr = date("H:i", strtotime($this->request->data['vheureArr']));
    $heureDep = date("H:i", strtotime($this->request->data['vheureDep']));
    $dateariv = Time::parse($this->request->data['vArrive']);
    $differencemail = '';
    if($reservation->dbt_at->i18nFormat('yyyy-MM-dd') != $dateariv->i18nFormat('yyyy-MM-dd')){
      $differencemail = "different";
    }
		$data=array("heure_arr"=>$heureArr,"heure_dep"=>$heureDep,"dbt_at"=>$this->toDate($this->request->data['vArrive']),"nb_adultes"=>$this->request->data['vAdult'],"nb_enfants"=>$this->request->data['vEnfant'],"comment"=>$this->request->data['vComment'],"commentlocataire"=>$this->request->data['vCommentlocataire'],"taxe"=>$this->request->data['vTaxe']);
		$reservation=$this->Reservations->patchEntity($reservation,$data);
		$this->Reservations->save($reservation);
    Log::write('info', 'Manager Edit Arrivee Reservation: reservationID: '.$this->request->data['vId'].'__debut: '.$this->request->data['vArrive']);

		$this->loadModel("Utilisateurs");
		$utilisateur=$this->Utilisateurs->get($this->request->data['vIdUtil']);
		$data_u=array("email"=>strtolower($this->request->data['vEmail']),"prenom"=>$this->request->data['vPrenom'],"nom_famille"=>$this->request->data['vNom'],"telephone"=>$this->request->data['vTel'],"portable"=>$this->request->data['vPort'],"ident"=>$this->request->data['vEmail']);
                $oldmail=$utilisateur->email;
                $utilisateur=$this->Utilisateurs->patchEntity($utilisateur,$data_u);
		$this->Utilisateurs->save($utilisateur);
                if($oldmail!=$utilisateur->email){
                    //resend mail
                        //get token
                        $this->loadModel('UtilisateursTokens');
                        $this->UtilisateursTokens->deleteAll(['user_id' => $utilisateur->id]);
                        $token=sha1($utilisateur->email.$utilisateur->pwd);
                        $user_token=$this->UtilisateursTokens->newEntity([
                            'user_id'=>$utilisateur->id,
                            'token'=>$token,
                            'expired_at'=>date('Y-m-d', strtotime('+1 year'))
                        ]);
                        $this->UtilisateursTokens->save($user_token);
                        $url=Router::url(['controller' => 'Utilisateurs', 'action' => 'confirmuser','token'=>$token],true);
                        //end get token
                    $utilisateur->valide_at=null;
                    $this->Utilisateurs->save($utilisateur);
                    $datamustache = array('url' => $url,'email' => $utilisateur->email,'prenom' => $utilisateur->prenom,'nom' => $utilisateur->nom_famille);

                    $this->loadModel("Registres");
                    $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                    $mail=$mails->first();
                    // #####################################################
                    $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $utilisateur,'textEmail'=>'validerCompteModifMail',
                                                             'data'=>$datamustache,'template'=>'validerCompte','viewVars'=>'validerCompte','noReply'=>false
                                                            ]);
                    $this->eventManager()->dispatch($event);
                    // #####################################################
                    //end resend mail
                }
		$loc=$this->Utilisateurs->get($reservation->utilisateur_id);
		$annonce=$this->Annonces->get($reservation->annonce_id);
		$user=$this->Utilisateurs->get($annonce->proprietaire_id);
    /** Enregistrer les numeros de telephone **/
    $this->loadModel("Reservationtelephone");
    $vlistnumtel = $this->request->data['vlistnumtel'];
    $numtel = explode("/", $vlistnumtel);
    if((count($numtel)-1) > intval($this->request->data['vnbrrestel'])){
      $ajt = intval($this->request->data['vnbrrestel']);
      while ((count($numtel)-1) > $ajt) {
          $datatelres=array("num_tel" => $numtel[$ajt],
                "reservation_id" => $this->request->data['vId']);
          $restel = $this->Reservationtelephone->newEntity($datatelres);
          $this->Reservationtelephone->save($restel);
          $ajt = $ajt+1;
      }
    }
    $vidtels = $this->request->data['vidtels'];
    $idtels = explode("/", $vidtels);
    for($i = 0; $i < intval($this->request->data['vnbrrestel']); $i++){
      $reservtel=$this->Reservationtelephone->get($idtels[$i]);
      $datareservtel=array("num_tel" => $numtel[$i]);
      $reservatel=$this->Reservationtelephone->patchEntity($reservtel,$datareservtel);
      $this->Reservationtelephone->save($reservatel);
    }
    /** Fin enregistrement tel **/
    if(PROD_ON == 1){
      /*** UPDATE GOOGLE CALENDAR ***/
      if($reservation->id_googlecalendar != NULL){
        if($annonce->id_gestionnaires != 0){
          $gest_mail = $this->Gestionnaires->get($annonce->id_gestionnaires);
          if($gest_mail->googlecalendar_id != "") $calendarID = $gest_mail->googlecalendar_id;
          else $calendarID = 'admin@alpissime.com';
        }else{
          $calendarID = 'admin@alpissime.com';
        }
        $googleCalendar = new GoogleCalendarController();
        $event_id = $googleCalendar->googlecalendarupdate($reservation, $calendarID);
      }
      /*** END UPDATE GOOGLE CALENDAR ***/
    }
    if($differencemail == "different"){
      
      $datamustache = array('nom' => $loc->nom_famille, 'prenom' => $loc->prenom, 'date' => $reservation->dbt_at, 'nomprop' => $user->nom_famille, 'prenomprop' => $user->prenom);
      
  		$this->loadModel("Registres");
  		$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
  		$mail=$mails->first();
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $loc,'textEmail'=>'editDateArriveeLocataire',
                                                         'data'=>$datamustache,'template'=>'editDateArriveeLocataire','viewVars'=>'editDateArriveeLocataire','noReply'=>false
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################
                
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $user,'textEmail'=>'editDateArriveeProprietaire',
                                                         'data'=>$datamustache,'template'=>'editDateArriveeProprietaire','viewVars'=>'editDateArriveeProprietaire','noReply'=>false
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################
    }
		die();
	}
  /**
	 *
	 **/
	function valider($id_g=null,$id_r=null){
		$this->loadModel("Registres");
		$this->loadModel('Reservations');
		$this->loadModel('Annonces');
		$this->loadModel('Utilisateurs');
		$this->loadModel('Taxes');
    $this->loadModel('Dispos');

    $mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
    $mail=$mails->first();
    $reservation=$this->Reservations->get($id_r);
    $annonce=$this->Annonces->get($reservation->annonce_id);
    
    // Taxe de séjour
    $dispocontroller = new \App\Controller\DisposController();
    $dates = $reservation->dbt_at->i18nFormat('dd-MM-yyyy')."/".$reservation->fin_at->i18nFormat('dd-MM-yyyy');
    $resultatDetail = $dispocontroller->calcultaxedesejour($reservation->annonce_id, $dates, $reservation->nb_adultes, $reservation->nb_enfants);
    $v_taxe = $resultatDetail['prixtaxeapayer'];
    $v_taxe=number_format($v_taxe, 2, ',', '');
    $mail_base = [];
    $mail_text_must = [];
    $this->loadModel("Modelmailsysteme");
    $textEmail = $this->Modelmailsysteme->find('all');
    foreach ($textEmail as $key => $value) {
      $mail_base[$value->titre] = $value->sujet;
      $mail_text_must[$value->titre] = $value->txtmail;
    }
		$loc=$this->Utilisateurs->get($reservation->utilisateur_id);
		$user=$this->Utilisateurs->get($annonce->proprietaire_id);
		$data=array('arrivee'=>1);
		$reservation=$this->Reservations->patchEntity($reservation,$data);
    $this->Reservations->save($reservation);
    

    if($annonce->contrat == 1)
    {
      if(isset($annonce->inventaire) && $annonce->inventaire != '') $textEmailTitre = 'ArriveeLocataireContratInventaire';
      else $textEmailTitre = 'ArriveeLocataireContratSansInventaire';
      
      $path = SITE_ALPISSIME;
      $urlInventaire = $path."inventaires/".$annonce->inventaire;

      $this->loadModel('BlocServicesMails');
      $stat_annonce = $annonce->lieugeo_id;
      $bloc_services_mail_first = $this->BlocServicesMails->find()->where(["(liste_id_station LIKE '$stat_annonce;%' OR liste_id_station LIKE '%;$stat_annonce;%')"])->first();

      $datamustache = array('bloc_services_mail' => $bloc_services_mail_first->bloc_services_mail, 'bloc_services_mail_en' => $bloc_services_mail_first->bloc_services_mail_en, 'nom' => $loc->nom_famille, 'prenom' => $loc->prenom, 'nomprop' => $user->nom_famille, 'prenomprop' => $user->prenom, 'url_inventaire' => $urlInventaire, 'annonce' => $annonce->titre, 'taxe' => $v_taxe);
      
      // #####################################################
      $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $user,'textEmail'=>'validationArriveeProp',
                                                'data'=>$datamustache,'template'=>'validationArriveeProp','viewVars'=>'validationArriveeProp','noReply'=>false
                                              ]);
      $this->eventManager()->dispatch($event);
      
      // #####################################################
      $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $loc,'textEmail'=>$textEmailTitre,
                                                'data'=>$datamustache,'template'=>'validationArriveeLoc','viewVars'=>'validationArriveeLoc','noReply'=>false
                                              ]);
      $this->eventManager()->dispatch($event);
      // #####################################################
      //envoi mail vers proprietaire
    }
		$data=array('id_reservation'=>$id_r,'id_gestionnaire'=>$id_g,'d_create'=>Time::now());
		$arrivee = $this->Arrivees->newEntity($data);
		$this->Arrivees->save($arrivee);
		die();
	}
  /**
	 *
	 **/
	function newarrive($date = null){
    if($date==null)  
    {
        $now = Time::parse( date('d-m-Y') );
        $this->set('dateChoisis',$now->i18nFormat('dd-MM-yyyy'));
    }
    else
    {
        $now = Time::parse($date);
        $this->set('dateChoisis',$date);   
                    $this->set('dateChoisis',$date);
        $this->set('dateChoisis',$date);   
                    $this->set('dateChoisis',$date);
        $this->set('dateChoisis',$date);   
                    $this->set('dateChoisis',$date);
        $this->set('dateChoisis',$date);   
    }
    if(isset($this->request->query['datefin'])&&$this->request->query['datefin']!='')  
    {
      $this->set('dateFinChoisis',$this->request->query['datefin']);
    }
    else
    {
      $date = Time::parse( date('d-m-Y') );
      $this->set('dateFinChoisis',$date->i18nFormat('dd-MM-yyyy'));
      $this->request->query['datefin']=$date->i18nFormat('dd-MM-yyyy');
    }
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $this->set('InfoGes',$session->read('Gestionnaire.info'));
        $gestionnaire=$session->read('Gestionnaire.info');
        $this->set('url',Router::url('/'));
    $this->loadModel('Reservations');
    $this->loadModel('Dispos');

    $arrive=$this->Reservations->find();
    $conditions=['A.id = Reservations.annonce_id','Reservations.dbt_at >= '=>$now->i18nFormat('yyyy-MM-dd')];
    if(isset($this->request->query['datefin'])&&$this->request->query['datefin']!=''){
    $fin = Time::parse($this->request->query['datefin']);
    $conditions['Reservations.dbt_at <= ']=$fin->i18nFormat('yyyy-MM-dd');
    $conditions['A.visible = ']=1;
    }
  $arrive->join([
    'A' => [
    'table' => 'annonces',
    'type' => 'inner',
    'conditions' => $conditions,
    ],
    'U' => [
    'table' => 'utilisateurs',
    'type' => 'INNER',
    'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=1'],
    ],
    'RS' => [
    'table' => 'residences',
    'type' => 'left',
    'conditions' => 'A.batiment=RS.id',
    ],
    'V' => [
    'table' => 'villages',
    'type' => 'left',
    'conditions' => 'V.id=RS.id_village',
    ],
    // 'AN' => [
    // 'table' => 'annoncegestionnaires',
    // 'type' => 'inner',
    // 'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
    // ],
    'CR' => [
    'table' => 'contrats',
    'type' => 'INNER',
    'conditions' => 'CR.annonce_id=A.id',
    ],
    'CT' => [
    'table' => 'contratypes',
    'type' => 'inner',
    'conditions' => ['CT.id=CR.type','CT.id!=3'],
    ],
    'G' => [
    'table' => 'gestionnaires',
    'type' => 'INNER',
    'conditions' => ['G.id=A.id_gestionnaires',"G.id=".$gestionnaire['G']['id'],'Reservations.statut=90'],
    ]
  ]);
  if(isset($this->request->query['supp']))
  $arrive->where(['OR' => [
  'LOWER(U.nom_famille) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
  'LOWER(U.prenom) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
  'LOWER(A.num_app) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
  'LOWER(RS.name) LIKE '=>'%'.strtolower($this->request->query['supp']).'%',
  ]]);
  $arrive->order(['RS.name','A.num_app + 0'])->group('Reservations.id');
  $arrive->select(['Reservations.id','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.nb_etoiles','A.ville','A.num_app','RS.name','V.name'])
  ->group(['Reservations.id']);
  $this->loadModel('Taxes');
    
    $taxes=[];
    $messageimpo=[];
    $this->paginate = [
            'limit' => intval($this->request->query['limite']?intval($this->request->query['limite']):10),
        ];
    $this->set('countArrives',count($arrive->toArray()));
    $this->set('arrives',$this->paginate($arrive));
    
    foreach($arrive as $c)
    {
      $dispocontroller = new \App\Controller\DisposController();
      $dates = $c->dbt_at->i18nFormat('dd-MM-yyyy')."/".$c->fin_at->i18nFormat('dd-MM-yyyy');
      $resultatDetail = $dispocontroller->calcultaxedesejour($c->annonce_id, $dates, $c->nb_adultes, $c->nb_enfants);
      $v_taxe = $resultatDetail['prixtaxeapayer'];
      $messageimpotext = $resultatDetail['messageimpotext'];

    //   $messageimpotext="";

    // $r_taxe=$this->Taxes->find('all',["conditions"=>["Taxes.id_villes"=>$c['A']['ville'],"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
    // $s = strtotime( $c->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($c->dbt_at->i18nFormat('yyyy-MM-dd'));
    // $d = intval($s/86400);
    // $v_taxe=0;
    // if($r_taxe->first()){
    //   $taxe=$r_taxe->first();
    // }else{
    //   $r_taxe=$this->Taxes->find('all',["conditions"=>["Taxes.id_villes"=>32190,"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
    //   $taxe=$r_taxe->first();
    //   $messageimpotext="Pas de taxe configurée pour la ville de cette annonce. La taxe est calculée sur la base de la ville de BOURG ST MAURICE";
    // }
    // if($taxe){            
    //             $v_taxe = 0;
    //             if($c['A']['nb_etoiles'] == 0){
    //                 /** Nouveau calcul Taxe 0* **/
    //                 $list_dispos = $this->Dispos->find()->where(['Dispos.reservation_id = '.$c->id]);

    //                 foreach ($list_dispos as $ldispo){
    //                     $ss = strtotime( $ldispo->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($ldispo->dbt_at->i18nFormat('yyyy-MM-dd'));
    //                     $dd = intval($ss/86400);
    //                     //// CALCUL PRIX NUITEE
    //                     if($ldispo->prix_jour == 0 && $ldispo->prix != 0 && $ldispo->promo_yn == 0){
    //                         $prixnuitee = $ldispo->prix / $dd;
    //                     }else if($ldispo->promo_jour == 0 && $ldispo->promo_px != 0 && $ldispo->promo_yn == 1){
    //                         $prixnuitee = $ldispo->promo_px / $dd;
    //                     }else if($ldispo->promo_yn == 0){
    //                         $prixnuitee = $ldispo->prix_jour;
    //                     }else if($ldispo->promo_yn == 1){
    //                         $prixnuitee = $ldispo->promo_jour;
    //                     }
    //                     //// Taxe par nuitée/personne
    //                     $nouvelletaxe = ($prixnuitee / ($c->nb_adultes + $c->nb_enfants)) * ($taxe->valeur / 100);
    //                     if($nouvelletaxe > 2.3) {
    //                         $nouvelletaxe = 2.3  * $c->nb_adultes;                        
    //                     }else {
    //                         $nouvelletaxe = $nouvelletaxe  * $c->nb_adultes;                       
    //                     }
    //                     //// Ajouter 10% taxe departementale
    //                     $nouvelletaxe10 = $nouvelletaxe + ($nouvelletaxe * 1/10);
    //                     //// Taxe Totale
    //                     $v_taxe += $nouvelletaxe10 * $dd;                   
    //                 }
    //                /** Fin Nouveau calcul Taxe 0* **/ 
    //             }else{
    // $v_taxe=$taxe->valeur*$c->nb_adultes*$d;
    // }
                        
    // //				$v_taxe=$taxe->valeur*$c->nb_adultes*$d;
    //   $messageimpo[$c->id] = $messageimpotext;
    // }
      $messageimpo[$c->id] = $messageimpotext;
      $taxes[$c->id]=number_format($v_taxe, 2, ',', '');

    }
        $this->set('messageimpo',$messageimpo);
        $this->set('taxes',$taxes);
    }
  /**
	 *
	 **/
   public function taxedesejour(){
     $this->viewBuilder()->layout('manager');
 		 $session = $this->request->session();
 		 $this->set('InfoGes',$session->read('Gestionnaire.info'));

     $this->loadModel("Utilisateurs");
     $g=$session->read('Gestionnaire.info');
     $utilisateurs = $this->Utilisateurs->arrayutilisateurspdf($g['G']['id']);
     $this->set('utilisateursPDF',$utilisateurs);

     $mail = [];
     $this->loadModel("Modelmailsysteme");
     $textEmail = $this->Modelmailsysteme->find('all');
     foreach ($textEmail as $key => $value) {
       $mail[$value->titre] = $value->txtmail;
     }
     $this->set("textmail",$mail);
   }
  /**
 	 *
 	 **/
   public function paiementtaxedesejour(){
     $this->viewBuilder()->layout('manager');
 		 $session = $this->request->session();
 		 $this->set('InfoGes',$session->read('Gestionnaire.info'));
   }
  /**
 	 *
 	 **/
   public function envoietaxedesejour(){
     $this->viewBuilder()->layout('manager');
 		 $session = $this->request->session();
 		 $this->set('InfoGes',$session->read('Gestionnaire.info'));
     $mail = [];
     $this->loadModel("Modelmailsysteme");
     $textEmail = $this->Modelmailsysteme->find('all');
     foreach ($textEmail as $key => $value) {
       $mail[$value->titre] = $value->txtmail;
     }
     $this->set("textmail",$mail);
   }
  /**
 	 *
 	 **/
   public function gestioncle(){
     $this->viewBuilder()->layout('manager');
 		 $session = $this->request->session();
 		 $this->set('InfoGes',$session->read('Gestionnaire.info'));
                 if(isset($this->request->data['cleInput'])){
                     $this->set('cleInput',$this->request->data['cleInput']);
                     $this->set('cleSelect',$this->request->data['cleSelect']);
                 };
   }
   /**
    *
    **/
   public function arraygestioncle(){
     $url=Router::url('/');
     $session = $this->request->session();
     $gestionnaire=$session->read('Gestionnaire.info');
     $this->loadModel('Annonces');
     $gestID=null;
     if($gestionnaire['G']['role']=="gestionnaire")
         $gestID=$gestionnaire['G']['id'];
     if(isset($this->request->query['arg']))
        $output=$this->Annonces->get_array_cle($this->request->query,$gestID,$url,$this->request->query['arg'],$this->request->query['cond']);
     else
        $output=$this->Annonces->get_array_gestion_cle($this->request->query,$gestID,$url);
     echo json_encode($output);die();
   }
   /**
    *
    **/
   public function arraypaiementtaxedesejour(){
     $url=Router::url('/');
     $this->loadModel('Reservations');
     $session = $this->request->session();
     $gestionnaire=$session->read('Gestionnaire.info');
     if($this->request->query['from'] == '' && $this->request->query['to'] == ''){
       $output=$this->Reservations->get_array_paiement_taxe_de_sejour($this->request->query,$gestionnaire['G']['id'],$this->request->query['taxe_geree'],$url);
     }else{
       if($this->request->query['from'] != ''){
         $dbt_at = $this->toDate($this->request->query['from']);
         $dbt = $dbt_at["year"]."-".$dbt_at["month"]."-".$dbt_at["day"];
       }else if($this->request->query['from'] == ''){
         $dbt_at = $this->toDate(date('d-m-Y'));
         $dbt = $dbt_at["year"]."-".$dbt_at["month"]."-".$dbt_at["day"];
       }
       if($this->request->query['to'] != ''){
         $fin_at = $this->toDate($this->request->query['to']);
         $fin = $fin_at["year"]."-".$fin_at["month"]."-".$fin_at["day"];
       }else if($this->request->query['to'] == ''){
         $fin_at = $this->toDate(date('d-m-Y'));
         $fin = $fin_at["year"]."-".$fin_at["month"]."-".$fin_at["day"];
       }
       $output=$this->Reservations->get_array_paiement_taxe_de_sejour_recherche($this->request->query,$gestionnaire['G']['id'], $dbt, $fin,$this->request->query['taxe_geree'],$url);
     }
     echo json_encode($output);die();
   }
   
   public function arraypaiementtaxedesejourForIndex(){
        $url=Router::url('/');
        $this->loadModel('Reservations');
        $session = $this->request->session();
        $gestionnaire=$session->read('Gestionnaire.info');
        $output=$this->Reservations->get_array_paiement_taxe_de_sejour($this->request->query,$gestionnaire['G']['id'],$this->request->query['taxe_geree'],$url);
        echo json_encode($output);die();
   }
   /**
    *
    **/
   public function arraytaxedesejour(){
      $url=Router::url('/');
 		  $this->loadModel('Reservations');
      $session = $this->request->session();
      $gestionnaire=$session->read('Gestionnaire.info');
      if($this->request->query['from'] == '' && $this->request->query['to'] == ''){
        $output=$this->Reservations->get_array_taxe_de_sejour($this->request->query,$gestionnaire['G']['id'],$this->request->query['taxe_geree']);
      }else{
        if($this->request->query['from'] != ''){
          $dbt_at = $this->toDate($this->request->query['from']);
          $dbt = $dbt_at["year"]."-".$dbt_at["month"]."-".$dbt_at["day"];
        }else if($this->request->query['from'] == ''){
          $dbt_at = $this->toDate(date('d-m-Y'));
          $dbt = $dbt_at["year"]."-".$dbt_at["month"]."-".$dbt_at["day"];
        }

        if($this->request->query['to'] != ''){
          $fin_at = $this->toDate($this->request->query['to']);
          $fin = $fin_at["year"]."-".$fin_at["month"]."-".$fin_at["day"];
        }else if($this->request->query['to'] == ''){
          $fin_at = $this->toDate(date('d-m-Y'));
          $fin = $fin_at["year"]."-".$fin_at["month"]."-".$fin_at["day"];
        }
        $output=$this->Reservations->get_array_taxe_de_sejour_recherche($this->request->query,$gestionnaire['G']['id'], $dbt, $fin,$this->request->query['taxe_geree']);
      }
 		  echo json_encode($output);die();
   }
   /**
    *
    **/
	function arraynewarrive(){
		$this->viewBuilder()->layout('ajax');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		
		$orWhere = array();
		if ( isset($this->request->query['sRechercher']) && $this->request->query['sRechercher'] != "" )
		{
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$orWhere[$i]= " LOWER(".$aColumns[$i].") LIKE '%". strtolower($this->request->query['sRechercher'])."%'";
			}
		}
		$awhere=array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( isset($this->request->query['bSearchable_'.$i]) && $this->request->query['bSearchable_'.$i] == "true" && $this->request->query['sSearch_'.$i] != '' )
			{
				$aWhere[$i]= $aColumns[$i]." LIKE '%".$this->request->query['sSearch_'.$i]."%'";
			}
		}
		$this->loadModel('Reservations');
		$now = Time::parse($this->request->query['from']);
		$arrive=$this->Reservations->find();
		$arrive->join([
			'A' => [
				'table' => 'annonces',
				'type' => 'inner',
				'conditions' => ['A.id = Reservations.annonce_id','Reservations.dbt_at'=>$now->i18nFormat('yyyy-MM-dd')],
			],
			'U' => [
				'table' => 'utilisateurs',
				'type' => 'INNER',
				'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=1'],
			],
			'RS' => [
				'table' => 'residences',
				'type' => 'left',
				'conditions' => 'A.batiment=RS.id',
			],
			'V' => [
				'table' => 'villages',
				'type' => 'left',
				'conditions' => 'V.id=RS.id_village',
			],
			// 'AN' => [
			// 	'table' => 'annoncegestionnaires',
			// 	'type' => 'inner',
			// 	'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
			// ],
			'CR' => [
				'table' => 'contrats',
				'type' => 'INNER',
				'conditions' => 'CR.annonce_id=A.id',
			],
			'CT' => [
				'table' => 'contratypes',
				'type' => 'inner',
				'conditions' => ['CT.id=CR.type','CT.id!=3'],
			],
			'G' => [
				'table' => 'gestionnaires',
				'type' => 'INNER',
				'conditions' => ['G.id=A.id_gestionnaires',"G.id=".$gestionnaire['G']['id'],'Reservations.statut=90'],
			]
		])
			->select(['Reservations.id','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.nb_etoiles','A.ville','A.num_app','RS.name','V.name']);
		
		if(!empty($orWhere)){
			$arrive->where([$awhere,"OR"=>$orWhere]);
		}
		$start=1;
		if($this->request->query['iDisplayStart']>0){
			$start=($this->request->query['iDisplayStart']/$this->request->query['iDisplayLength'])+1;
		}
		$arrive->order($sOrder);

		$this->loadModel('Taxes');
                $this->loadModel('Dipos');
                
                $taxes=[];
		foreach($arrive as $c)
		{
      $dispocontroller = new \App\Controller\DisposController();
      $dates = $c->dbt_at->i18nFormat('dd-MM-yyyy')."/".$c->fin_at->i18nFormat('dd-MM-yyyy');
      $resultatDetail = $dispocontroller->calcultaxedesejour($c->annonce_id, $dates, $c->nb_adultes, $c->nb_enfants);
      $v_taxe = $resultatDetail['prixtaxeapayer'];
      
			// $r_taxe=$this->Taxes->find('all',["conditions"=>["Taxes.id_villes"=>$c['A']['ville'],"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
			// $s = strtotime( $c->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($c->dbt_at->i18nFormat('yyyy-MM-dd'));
			// $d = intval($s/86400);
			// $v_taxe=0;
			// if($r_taxe->first()){
      //   $taxe=$r_taxe->first();
      // }else{
      //   $r_taxe=$this->Taxes->find('all',["conditions"=>["Taxes.id_villes"=>32190,"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
      //   $taxe=$r_taxe->first();
      // }
      // if($taxe){
                                
      //                       $v_taxe = 0;
      //                       if($c['A']['nb_etoiles'] == 0){
      //                           /** Nouveau calcul Taxe 0* **/
      //                           $list_dispos = $this->Dispos->find()->where(['Dispos.reservation_id = '.$c->id]);

      //                           foreach ($list_dispos as $ldispo){
      //                               $ss = strtotime( $ldispo->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($ldispo->dbt_at->i18nFormat('yyyy-MM-dd'));
      //                               $dd = intval($ss/86400);
      //                               //// CALCUL PRIX NUITEE
      //                               if($ldispo->prix_jour == 0 && $ldispo->prix != 0 && $ldispo->promo_yn == 0){
      //                                   $prixnuitee = $ldispo->prix / $dd;
      //                               }else if($ldispo->promo_jour == 0 && $ldispo->promo_px != 0 && $ldispo->promo_yn == 1){
      //                                   $prixnuitee = $ldispo->promo_px / $dd;
      //                               }else if($ldispo->promo_yn == 0){
      //                                   $prixnuitee = $ldispo->prix_jour;
      //                               }else if($ldispo->promo_yn == 1){
      //                                   $prixnuitee = $ldispo->promo_jour;
      //                               }
      //                               //// Taxe par nuitée/personne
      //                               $nouvelletaxe = ($prixnuitee / ($c->nb_adultes + $c->nb_enfants)) * ($taxe->valeur / 100);
      //                               if($nouvelletaxe > 2.3) {
      //                                   $nouvelletaxe = 2.3  * $c->nb_adultes;                        
      //                               }else {
      //                                   $nouvelletaxe = $nouvelletaxe  * $c->nb_adultes;                        
      //                               }
      //                               //// Ajouter 10% taxe departementale
      //                               $nouvelletaxe10 = $nouvelletaxe + ($nouvelletaxe * 1/10);
      //                               //// Taxe Totale
      //                               $v_taxe += $nouvelletaxe10 * $dd;                       
      //                           }
      //                          /** Fin Nouveau calcul Taxe 0* **/ 
      //                       }else{
			// 	$v_taxe=$taxe->valeur*$c->nb_adultes*$d;
			// }
                                
			// 	//$v_taxe=$taxe->valeur*$c->nb_adultes*$d;
			// }
                        $taxes[$c->id]=number_format($v_taxe, 2, ',', '');
			
		}
	}
  /**
	 *
	 **/
	function inscription(){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		if($session->check("Inscription.manuelle")){
			$this->set('confirm_res','reservation');
			$session->delete("Inscription.manuelle");
		}
		$info_ges=$session->read('Gestionnaire.info');
    $this->set('gestInfo', $info_ges);
		$this->loadModel('Utilisateurs');
		$this->loadModel('Annonces');
		$this->loadModel('Annoncegestionnaires');
		if ($this->request->is('post')) {
      $mdp_en_clair = $this->request->data['mdpenclair'];
			$a_uti=array(	"email"=>strtolower($this->request->data['email']),
                                        "mot_passe"=>md5($mdp_en_clair),
                                        "prenom"=>$this->request->data['prenom'],
                                        "nom_famille"=>$this->request->data['nom'],
                                        "societe"=>$this->request->data['genre'],
                                        "telephone"=>$this->request->data['tel'],
                                        "telephone2"=>$this->request->data['mobile2'],
                                        "portable2"=>$this->request->data['tel2'],
                                        "fax"=>$this->request->data['fax'],
                                        "portable"=>$this->request->data['mobile'],
                                        "code_postal"=>$this->request->data['codepostal'],
                                        "adresse"=>$this->request->data['adresse'],
                                        "adr2"=>$this->request->data['adresse2'],
                                        "ville"=>$this->request->data['villeprop'],
                                        "societe"=>$this->request->data['genre'],
                                        "pays"=>$this->request->data['pays'],
                                        "statut"=>"90",
                                        "nature"=>"ANNO"
                                    );
                        if($this->request->data['pays']==67){
                           $a_uti["region"] = $this->request->data['region'];
                        }
                        
			$id_loc=0;
			if(empty($this->request->data['id'])){
				$utilisateur = $this->Utilisateurs->newEntity($a_uti);
				$utilisateur->pwd=(new DefaultPasswordHasher)->hash($mdp_en_clair);
				$utilisateur->ident=$this->request->data['email'];
				$utilisateur->date_insert=Time::now();
				$utilisateur->date_update=Time::now();
				$this->Utilisateurs->save($utilisateur);
        $id_loc=$utilisateur->id;
        
        //verification mail
        $this->loadModel('UtilisateursTokens');
        $token=sha1($utilisateur->email.$utilisateur->pwd);
        $this->UtilisateursTokens->deleteAll(['user_id' => $utilisateur->id]);
        $user_token=$this->UtilisateursTokens->newEntity([
          'user_id'=>$utilisateur->id,
          'token'=>$token,
          'expired_at'=>date('Y-m-d', strtotime('+1 year'))
        ]);
        $this->UtilisateursTokens->save($user_token);
        $url=Router::url(['controller' => 'Utilisateurs', 'action' => 'confirmuser','token'=>$token],true);

				$a_info_mail=array('password'=>$mdp_en_clair,'login'=>$this->request->data['email'],"bureau"=>$info_ges['G']['name']);
           
          $this->loadModel('BlocMailGestionnaires');
          $blocsinfos = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => $info_ges['G']['id']])->first();
          $datamustache = array('bloc_service_proprietaire' => $blocsinfos->bloc_service_proprietaire, 'bloc_service_proprietaire_en' => $blocsinfos->bloc_service_proprietaire_en, 'url' => $url,'bureau' => $info_ges['G']['name'], 'login' => $this->request->data['email'], 'password' => $mdp_en_clair);
                                
					$this->loadModel("Registres");
					$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
					$mail=$mails->first();
          // #####################################################
          $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $this->request->data['email'],'textEmail'=>'creationCompteGestionnaire',
                                                    'data'=>$datamustache,'template'=>'creationCompteGestionnaire','viewVars'=>'creationCompteGestionnaire','noReply'=>false
                                                  ]);
          $this->eventManager()->dispatch($event);
          // #####################################################
          /*** MISE A JOUR BOUTIQUE ***/
          // // Nouveau Code magento 2
					// //**** informations a utiliser toujours ********************//
					// $magentoURL = BOUTIQUE_ALPISSIME;
					// $data = array("username" => "API.ACCESS", "password" => "86>;];wzO+Q#");
					// $data_string = json_encode($data);
					// $ch = curl_init($magentoURL."index.php/rest/V1/integration/admin/token");
					// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					// curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
					// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					// curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Content-Length: ".strlen($data_string)));
					// $token = curl_exec($ch);
					// $token= json_decode($token);
					// $headers = array("Authorization: Bearer ".$token);
					// //************************************************************//
					// // **** mettre l'email du client depuis le site location **********//
          // $customerEmail = $this->request->data['email'];   //à changer
          // if($this->request->data['prenom'] == '') $customer_fname = "_";
          // else $customer_fname = $this->request->data['prenom'] ; // prenom du client
          // $customer_lname = $this->request->data['nom']; // Nom du client
          // $password = $mdp_en_clair; // mot de passe          

					// $requestUrl = $magentoURL.'index.php/rest/V1/customers/search?searchCriteria[filter_groups][0][filters][0][field]=email&searchCriteria[filter_groups][0][filters][0][value]=%25'.$customerEmail.'%25&searchCriteria[filter_groups][0][filters][0][condition_type]=like';
					// $ch = curl_init($requestUrl);
					// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					// $result = curl_exec($ch);
					// $result = json_decode($result, true);
					// 	//*********** Mise a jour du mot de passe du client et eventuellement son nom ...
					// 	// si le client existe (email) dans la boutique ********//
					// if ($result["items"]){
					// 	$id = $result['items'][0]['id'];
					// 	$customerData = [
					// 		'customer' => [
					// 			'id' => $id,
					// 			"group_id" => 9,
					// 			"email" => $customerEmail,  //à changer
					// 			"firstname" => $customer_fname,     //à changer
					// 			"lastname" => $customer_lname,      //à changer
					// 			"storeId" => 1,
					// 			"websiteId" => 1
					// 		],
					// 		"password" => $password            //à changer
					// 	];

					// 	$link = $magentoURL.'index.php/rest/V1/customers/'.$id;
					// 	$ch = curl_init($link);
					// 	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					// 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
					// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					// 	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
					// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
					// 	$result = curl_exec($ch);

					// 	//echo '<pre>';print_r($result);  //Tu peux enlever

					// } else {
					// 	//******** créer le client ***********//
					// 	$customerData = [
					// 		'customer' => [
          //       "group_id" => 9,
					// 			"email" => $customerEmail,  //à changer
					// 			"firstname" => $customer_fname,          //à changer
					// 			"lastname" => $customer_lname,         //à changer
					// 			"storeId" => 1,
					// 			"websiteId" => 1
					// 		],
					// 		"password" => $password            //à changer
					// 	];
					// 	$ch = curl_init($magentoURL."index.php/rest/V1/customers");
					// 	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					// 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					// 	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
					// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
					// 	$result = curl_exec($ch);

					// 	//echo '<pre>';print_r($result);          //Tu peux enlever
					// }
					// curl_close($ch);
          /*** END MISE A JOUR BOUTIQUE ***/
			}else{
				$utilisateur = $this->Utilisateurs->get($this->request->data['id']);
				$utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $a_uti);
				$utilisateur->pwd=(new DefaultPasswordHasher)->hash($mdp_en_clair);
				$utilisateur->ident=$this->request->data['email'];
				$utilisateur->date_update=Time::now();
				$this->Utilisateurs->save($utilisateur);
				$id_loc=$this->request->data['id'];
			}
      if($this->request->data['publication'] == 1) $statutann = 50;
      else $statutann = 0;
      $a_annonce=array('proprietaire_id'=>$id_loc,'num_app'=>$this->request->data['numapp'],'village'=>$this->request->data['village'],'batiment'=>$this->request->data['residence'],'statut'=>$statutann,'surface'=>$this->request->data['surafce']);
			$annonce = $this->Annonces->newEntity($a_annonce);
			$annonce->created_at=Time::now();
      $annonce->updated_at=Time::now();
      $annonce->pays = 67;

      $this->loadModel("Villages");
      $village_info = $this->Villages->find()->contain(['Frvilles'])->where(['Villages.id' => $this->request->data['village']])->first();
      $annonce->code_postal = $village_info->frville->code_postal;
      $annonce->ville = $village_info->frville->id;
      $annonce->region = $village_info->frville->departement_id;
      $annonce->lieugeo_id = 	$village_info->lieugeo_id;
      $annonce->village = $this->request->data['village'];
      // if($this->request->data['ville'] == 1){
      //   $annonce->code_postal = 73700;
      //   $annonce->ville = 32190;
      //   $annonce->region = 255;
      // }else if($this->request->data['ville'] == 2){
      //   $annonce->code_postal = 73210;
      //   $annonce->ville = 31983;
      //   $annonce->region = 255;
      // }else if($this->request->data['ville'] == 3){
      //   $annonce->code_postal = 73210;
      //   $annonce->ville = 31987;
      //   $annonce->region = 255;
      // }else if($this->request->data['ville'] == 4){
      //   $annonce->code_postal = 4260;
      //   $annonce->ville = 1727;
      //   $annonce->region = 185;
      // }
			$this->Annonces->save($annonce);
      if($this->request->data['gestionnaire'] == 1){
        $a_gest=array("id_gestionnaires"=>$info_ges['G']['id'],
                  "position_cle"=>0,
                  "visible"=>1);
        $annonce=$this->Annonces->patchEntity($annonce,$a_gest);
        $this->Annonces->save($annonce);
      }
     //here SendInBlue add
           $this->loadModel("Pays");
        if(PROD_ON == 1){    
          $sendinblue=new SendInBlueController();       
          $sendinblue->addContactToSendInBlue($utilisateur->email,$utilisateur->prenom,$utilisateur->nom_famille,$utilisateur->portable,$utilisateur->civilite,$utilisateur->naissance,null,null,null, $this->Pays->get($utilisateur->pays)->fr ,$this->request->data['nature']);
        }
			$session->write("Inscription.manuelle","addCompte");
			$this->redirect($this->referer());
		}
		$this->set('InfoGes',$info_ges);
		$this->loadModel("Lieugeos");
		$this->loadModel("Villes");
		$this->loadModel("Residences");
		$this->loadModel("Villages");
    $this->loadModel("Pays");
	  $Pays=$this->Pays->find('all');
    $a_pay=array();
    $payNum=array();
    $a_pay[0] = '';
    foreach($Pays as $pay){
		   $a_pay[$pay->id_pays]=$pay->fr;
		   $payNum[$pay->id_pays]=$pay->code_pays;
		  }
    $this->set("Pays", $a_pay);
		$this->set("paysNum", $payNum);
        $enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
		$a_genres=array(
           'Agence'=>'Agence'
          ,'Association syndicat Libre'=>'Association syndicat Libre'
          ,'Association'=>'Association'
		  ,"Comité d'entreprise"=>"Comité d'entreprise"
          ,'Copropriété'=>'Copropriété'
          ,'EPIC'=>'EPIC'
		  ,'Etablissement'=>'Etablissement'
          ,'Hotel'=>'Hotel'
          ,'Indivision'=>'Indivision'
		  ,'Madame'=>'Madame'
          ,'Mademoiselle'=>'Mademoiselle'
          ,'mairie de'=>'mairie de'
		  ,'Monsieurs'=>'Monsieurs'
		  ,'Monsieur'=>'Monsieur'
          ,'Monsieur et Madame'=>'Monsieur et Madame'
          ,'Parking'=>'Parking'
		  ,'Restaurant'=>'Restaurant'
          ,'S.A'=>'S.A'
          ,'S.A.S'=>'S.A.S'
		  ,'Sarl'=>'Sarl'
		  ,'SC'=>'SC'
		  ,'SCI'=>'SCI'
		  ,'SET'=>'SET'
		  ,'SNC'=>'SNC'
		  ,'Société'=>'Société'
		  ,'Société familiale'=>'Société familiale'
        );
    $a_ville=$this->Villes->find("all");
    $this->loadModel("Gestionnaires");
    $gestionnaire = $this->Gestionnaires->findById($info_ges['G']['id'])->contain('Villages')->first();
    $this->set('a_village',$gestionnaire->villages);
		// $a_village=$this->Villages->find('all',["order"=>"Villages.name"]);
		$a_residence=$this->Residences->find("all",["conditions"=>["(bibliotheque_id = 1 OR bibliotheque_id = 7)", "id_village IN "=>array_map(function($value) { return $value->id; }, $gestionnaire->villages)],"order"=>"Residences.name"]);
    $this->set('lieu_geo',$enrs);
		$this->set('a_genre',$a_genres);
		$this->set('a_ville',$a_ville);
		$this->set('a_residence',$a_residence);
		// $this->set('a_village',$a_village);

    $mail = [];
		$this->loadModel("Modelmailsysteme");
		$textEmail = $this->Modelmailsysteme->find('all');
		foreach ($textEmail as $key => $value) {
			$mail[$value->titre] = $value->txtmail;
		}
    $this->set("textmail",$mail);

    // Recherche ville/pays/code postale/departement suivant villages du gestionnaire
    $gestionnaire = $this->Gestionnaires->find()->contain(['Villages.Frvilles.Departements'])->where(['Gestionnaires.id' => $info_ges['G']['id']]);
    $this->set("adresse_annonce",$gestionnaire->first());
	}
  /**
	 *
	 **/
	function mescontrat(){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$this->set('InfoGes',$session->read('Gestionnaire.info'));

    $this->loadModel("Contactprops");
    $this->loadModel("Utilisateurs");
    $util = $this->Utilisateurs->find();
    $util->join([
            'Annonce' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => 'Utilisateurs.id = Annonce.proprietaire_id',
            ]])
          ->select(['Utilisateurs.id', 'Utilisateurs.nom_famille', 'Utilisateurs.prenom', 'Utilisateurs.email','Annonce.id_filemaker', 'Annonce.id', 'Annonce.contrat','Annonce.mise_relation', 'Annonce.titre']);

    $mailInfo = [];
		$demandes = [];
		foreach ($util as $value) {
			$mailInfo[$value['Annonce']['id']] = [];
			$mailInfo[$value['Annonce']['id']]['prenomprop'] = $value->prenom;
			$mailInfo[$value['Annonce']['id']]['nomprop'] = $value->nom_famille;
			$mailInfo[$value['Annonce']['id']]['annonce'] = $value['Annonce']['titre'];
			$demandes[$value['Annonce']['id']]=$this->Contactprops->find('all',["conditions"=>["Contactprops.id_annonce"=>$value['Annonce']['id'],"lut"=>0]]);
		}
		$this->set('mailInfo', $mailInfo);
		$this->set('demandeContactMail', $demandes);
		$mail = [];
    $this->loadModel("Modelmailsysteme");
    $textEmail = $this->Modelmailsysteme->find('all');
    foreach ($textEmail as $key => $value) {
      $mail[$value->titre] = $value->txtmail;
    }
    $this->set("textmail",$mail);
	}
  /**
	 *
	 **/
  function activationcontrat(){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $this->set('InfoGes',$session->read('Gestionnaire.info'));
    $session = $this->request->session();
 		$this->viewBuilder()->layout('manager');
 		$this->set('InfoGes',$session->read('Gestionnaire.info'));
 		$this->loadModel("Utilisateurs");
 		$this->loadModel("Contactprops");
 		$util = $this->Utilisateurs->find();
 		$util->join([
 						'Annonce' => [
 							'table' => 'annonces',
 							'type' => 'inner',
 							'conditions' => 'Utilisateurs.id = Annonce.proprietaire_id',
 						]])
 					->select(['Utilisateurs.id', 'Utilisateurs.nom_famille', 'Utilisateurs.prenom', 'Utilisateurs.email','Annonce.id_filemaker', 'Annonce.id', 'Annonce.contrat','Annonce.mise_relation', 'Annonce.titre']);
 		$mailInfo = [];
 		$demandes = [];
 		foreach ($util as $value) {
 			$mailInfo[$value['Annonce']['id']] = [];
 			$mailInfo[$value['Annonce']['id']]['prenomprop'] = $value->prenom;
 			$mailInfo[$value['Annonce']['id']]['nomprop'] = $value->nom_famille;
 			$mailInfo[$value['Annonce']['id']]['annonce'] = $value['Annonce']['titre'];
 			$demandes[$value['Annonce']['id']]=$this->Contactprops->find('all',["conditions"=>["Contactprops.id_annonce"=>$value['Annonce']['id'],"lut"=>0]]);
 		}
 		$this->set('mailInfo', $mailInfo);
 		$this->set('demandeContactMail', $demandes);
 		$mail = [];
     $this->loadModel("Modelmailsysteme");
     $textEmail = $this->Modelmailsysteme->find('all');
     foreach ($textEmail as $key => $value) {
       $mail[$value->titre] = $value->txtmail;
     }
     $this->set("textmail",$mail);
   }
  /**
 	 *
 	 **/
 	public function listecontactprop(){
 		$session = $this->request->session();
 		$this->viewBuilder()->layout('manager');
 		$this->set('InfoGes',$session->read('Gestionnaire.info'));
 	}
  /**
	 *
	 **/
   public function utilisateurgestionnaire(){
  		$session = $this->request->session();
  		$this->viewBuilder()->layout('manager');
  		$this->set('InfoGes',$session->read('Gestionnaire.info'));
  	}
  /**
	 *
	 **/
	function arraycontrat($id=null){
		$url=Router::url('/');
		$this->loadModel('Contrats');
		$output=$this->Contrats->get_array_contrat($id,$url,$this->request->query);
		echo json_encode($output);die();
	}
  /**
	 *
	 **/
	function archivercontrat($id=null){
		$this->loadModel('Contrats');
		$contrat=$this->Contrats->get($id);
		$data=array('visible'=>0);
		$contrat = $this->Contrats->patchEntity($contrat, $data);
		$this->Contrats->save($contrat);
		die();
  }
  /**
   * 
	 *
   * 
	 *
   * 
	 *
   * 
   */
  function supprimercontrat($id=null){
    $this->loadModel('Contrats');
    $contrat=$this->Contrats->get($id);

    $this->loadModel('Annonces');
    $annonce = $this->Annonces->get($contrat->annonce_id);
    $data=array('contrat'=>0);
		$annonceedit = $this->Annonces->patchEntity($annonce, $data);
		$this->Annonces->save($annonceedit);

    $this->Contrats->delete($contrat);
		die();
  }
  /**
   * 
   */
  function viewpdfcontrat($id){
    $this->viewBuilder()->layout(false);
    $this->autoRender = false;
    $this->loadModel('Contrats');
    $this->loadModel('Annonces');
    $this->loadModel('Utilisateurs');
    $this->loadModel('Varoptioncontrats');
    $this->loadModel('DatesOptionContrat');
    $session = $this->request->session();
    $gestionnaire=$session->read('Gestionnaire.info');
    $getcontrat = $this->Contrats->get($id);
    $annonce = $this->Annonces->get($getcontrat->annonce_id);
    $utilisateur = $this->Utilisateurs->get($annonce->proprietaire_id);
    $data = [];
    $data['type'] = $getcontrat->type;
    $data['id'] = $id;
    //Liste des variables
    $variablecontrat = $this->Varoptioncontrats->find()->where(['contrat_id'=>$id, 'option_id'=>0])->first();
    $listvarvaleurcontrat = explode("////", $variablecontrat->variable_valeur);
    foreach ($listvarvaleurcontrat as $valeur) {
      if($valeur){
        $vardyna = explode(":", $valeur);
        $data['variable'.$vardyna[0]] = $vardyna[1];
      }      
    }
    //Liste des variables option
    $varvaleurop = $this->Varoptioncontrats->find()->where(['contrat_id' => $id, 'option_id !=' => 0]);    
    foreach ($varvaleurop as $optionval) {
      $data['option'.$optionval->option_id] = 1;
      $varvaleur = $this->Varoptioncontrats->find()->where(['contrat_id' => $id, 'option_id' => $optionval->option_id])->first();
      $listvarvaleurcontrat = explode("////", $varvaleur->variable_valeur);
      foreach ($listvarvaleurcontrat as $valeur2) {
        if($valeur2){
          $vardyna2 = explode(":", $valeur2);
          $data['optionvar'.$vardyna2[0].'_'.$optionval->option_id] = $vardyna2[1];
        }  
        // Enregistrement des dates option
        if($valeur2 == 4){
          $listedate = '';
          $datescontrat = $this->DatesOptionContrat->find()->where(['contrat_id' => $id, 'option_id' => $optionval->option_id])->first();
          $listedates = explode(";", $datescontrat->dates);
          foreach ($listedates as $key => $val) {
            $data['date_'.($key+1).'_'.$optionval->option_id] = $val;
            $data['mois_date_'.($key+1).'_'.$optionval->option_id] = (new Date($val))->i18nFormat('MM');
            $data['jour_date_'.($key+1).'_'.$optionval->option_id] = (new Date($val))->i18nFormat('dd');
          }
         
        }    
      }
    }
    
    // Générer PDF
    $mpdf = new \Mpdf\Mpdf([
      'mode' => 'utf-8',
    ]);
    switch($getcontrat->type){
      case "2":
        $url=SITE_ALPISSIME."manager/arrivees/viewpdf/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($data));
        // $url=SITE_ALPISSIME."/manager/arrivees/viewpdf/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
      break;
      case "1":
        $url=SITE_ALPISSIME."manager/arrivees/viewpdfmaint/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($data));
        // $url=SITE_ALPISSIME."/manager/arrivees/viewpdfmaint/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
      break;
      case "4":
        $url=SITE_ALPISSIME."manager/arrivees/viewpdfmaint/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($data));
        // $url=SITE_ALPISSIME."/manager/arrivees/viewpdfmaint/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
      break;
      case "3":
        $url=SITE_ALPISSIME."manager/arrivees/viewpdfrelation/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($data));
        // $url=SITE_ALPISSIME."/manager/arrivees/viewpdfrelation/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
      break;
      case "5":
        $url=SITE_ALPISSIME."manager/arrivees/viewpdfcommercialisation/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($data));
      break;
    }
    
    $html=file_get_contents($url);
    // print_r($html);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;
    $mpdf->setAutoBottomMargin = 'stretch';
    $mpdf->SetFooter('{PAGENO}');
    $mpdf->WriteHTML(mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8"));
    $mpdf->Output(ROOT.DS.'webroot'.DS.'contrat'.DS."CT_".$utilisateur->id."_".$annonce->id.'.pdf','F');
    return $this->redirect('/contrat'.DS."CT_".$utilisateur->id."_".$annonce->id.'.pdf');
    // FIN générer PDF
  }
  /**
	 *
	 **/
	function editcontrat($id=null){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
		if($session->check("Contrat.manuelle")){
			$this->set('confirm_res','reservation');
			$session->delete("Contrat.manuelle");
		}
		if($session->check("Contrat.annule")){
			$this->set('msg_annulation','reservation');
			$session->delete("Contrat.annule");
		}
		$this->loadModel("Contrats");
		$this->loadModel("Utilisateurs");
		$this->loadModel("Annoncegestionnaires");
		$this->loadModel("Contratypes");
		$this->loadModel("Annonces");
		$this->loadModel("Gestionnaires");
    $gestionnaire=$session->read('Gestionnaire.info');
    $this->set('gestInfo', $gestionnaire);   
		if ($this->request->is(['patch', 'post', 'put'])) {	
    //  print_r($this->request->data);
    //  exit;
    			$dateDepartTimestamp = date("d-m-Y", strtotime($this->request->data['date_mise_route']));
    			$date_echeance=date("d-m-Y",strtotime('+3 month', strtotime($dateDepartTimestamp)));
    			$date_rappel=date("d-m-Y",strtotime('+1 year', strtotime($dateDepartTimestamp)));
    			$contrat=$this->Contrats->get($this->request->data['id']);
    			$data_contrat=array("date_create"=>$this->toDate($dateDepartTimestamp)
                                                        ,"date_echeance"=>$this->toDate($date_echeance)
    								,"date_rappel"=>$this->toDate($date_rappel)
    								,"type"=>$this->request->data['type']
                    ,"visible"=>1
                    ,"prix"=>$this->request->data['variable1']
                    ,"payerGest"=>$this->request->data['payerGest']
                    ,"id_produit_contrat_boutique"=>$this->request->data['id_produit_contrat_boutique']);
    			$contrat = $this->Contrats->patchEntity($contrat, $data_contrat);
    			$getcontrat = $this->Contrats->save($contrat);
    			$res=$this->Annonces->get($this->request->data["annonce_id"]);
    			// if($res->first()) {
    				$annoncegestionnaire = $res;
            if( $this->request->data["position_cle"] == ""){
        			$pos = 0;
        		}else{
        			$pos = $this->request->data["position_cle"];
        		}
    				$a_annoncegestionnaires = array("position_cle" => $pos);
    				$annoncegestionnaire = $this->Annonces->patchEntity($annoncegestionnaire, $a_annoncegestionnaires);
    				$this->Annonces->save($annoncegestionnaire);
    			// }
    			$utilisateur=$this->Utilisateurs->get($this->request->data['proprietaire_id']);
    			$data_util=array("prenom"=>$this->request->data['prenom'],"nom_famille"=>$this->request->data['nom_famille'],"telephone"=>$this->request->data['tel1'],"portable"=>$this->request->data['portable1'],"telephone2"=>$this->request->data['tel2'],"portable2"=>$this->request->data['portable2'],"adr2"=>$this->request->data['adr2'],"adresse"=>$this->request->data['adresse']);
    			$utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $data_util);
    			$this->Utilisateurs->save($utilisateur);
          $annonce=$this->Annonces->get($this->request->data["annonce_id"]);
          if($this->request->data['valider']=="valider"){
            $a_ann=array("num_app"=>$this->request->data['num_app'],"surface"=>$this->request->data['surface'],'date_contrat'=>Time::now());
            $session->write("Contrat.manuelle","addReservation");
          }else{
            $a_ann=array("num_app"=>$this->request->data['num_app'],"surface"=>$this->request->data['surface'],'contrat'=>0);
            $session->write("Contrat.annule","addReservation");
          }
          $annonce = $this->Annonces->patchEntity($annonce, $a_ann);
          if($this->request->data['valider']=="valider"){
            $annonce->contrat = 1;
          }
          $this->Annonces->save($annonce);
          
          //ajouter les valeurs des variables du contrat
        $this->loadModel('Optionscontrats');
        $this->loadModel('Variabledynamiques');
        $contratype = $this->Contratypes->get($this->request->data['type']);
        $listabvardyn = [];
        $listvar = [];
        $listvariablecontrat = explode(";", $contratype->variables_id);
        $varval = "";
        foreach ($listvariablecontrat as $key) {
          $vardyn = $this->Variabledynamiques->find()->where(['id' => $key])->first();
          if($vardyn){
            if($this->request->data['variable'.$key]){
              $listvar[] = $key;
              $varval .= $key.":".$this->request->data['variable'.$key]."////";
            }
          } 
        }
        $this->loadModel('Varoptioncontrats');
        $oldvaroption = $this->Varoptioncontrats->find()->where(['contrat_id'=>$getcontrat->id, 'option_id'=>0])->first();        
        
        if($oldvaroption){
          $listvariablecontrat = explode("////", $oldvaroption->variable_valeur);
          foreach ($listvariablecontrat as $key) {
            $valeurvar = explode(":", $key);
            if (!in_array($valeurvar[0], $listvar)){
              $vardyn = $this->Variabledynamiques->find()->where(['id' => $valeurvar[0]])->first();
              if($vardyn){
                if($this->request->data['variable'.$valeurvar[0]]){
                  $varval .= $valeurvar[0].":".$this->request->data['variable'.$valeurvar[0]]."////";
                }
              } 
            }            
          }
          
          $datavariables = array('variable_valeur'=>$varval);
          $newvaroption = $this->Varoptioncontrats->patchEntity($oldvaroption, $datavariables);
          $this->Varoptioncontrats->save($newvaroption);
        }else{
          $datavariables = array('contrat_id'=>$getcontrat->id, 'variable_valeur'=>$varval, 'option_id'=>0);
          $newvaroption = $this->Varoptioncontrats->newEntity($datavariables);
          $this->Varoptioncontrats->save($newvaroption);
        }
        
        //ajouter les valeurs variables option du contrat
        $this->loadModel('DatesOptionContrat');
        $listoptioncontrat = explode(";", $contratype->options_id);
        foreach ($listoptioncontrat as $keyopt) {
          $vardynopt = $this->Optionscontrats->find()->where(['id' => $keyopt])->first();
          if($vardynopt){
            if($this->request->data['option'.$keyopt]){
              $listvariableopt = explode(";", $vardynopt->variables_id);
              $varvalop = "";
              foreach ($listvariableopt as $value) {
                $var2opt = "";
                $vardynop = $this->Variabledynamiques->find()->where(['id' => $value])->first();
                if($vardynop){
                  if($this->request->data['optionvar'.$value.'_'.$keyopt]){
                    if($value == 2 && is_array($this->request->data['optionvar'.$value.'_'.$keyopt])){
                      foreach ($this->request->data['optionvar'.$value.'_'.$keyopt] as $valueval) {
                        $var2opt .= $valueval."__";
                      }
                      $varvalop .= $value.":".$var2opt."////";
                    }else{
                      $varvalop .= $value.":".$this->request->data['optionvar'.$value.'_'.$keyopt]."////";
                    }                    
                  }
                  // Enregistrement des dates option
                  if($value == 4){
                    $listedate = '';
                    $today = new Date();
                    for ($i=1; $i <= $this->request->data['optionvar'.$value.'_'.$keyopt]; $i++) { 
                      $date = $today->year."-".$this->request->data['mois_date_'.$i.'_'.$keyopt]."-".$this->request->data['jour_date_'.$i.'_'.$keyopt];
                      if(new Date($date) < $today) $date = ($today->year+1)."-".$this->request->data['mois_date_'.$i.'_'.$keyopt]."-".$this->request->data['jour_date_'.$i.'_'.$keyopt];
                  
                      $listedate .= $date.";";
                    }
                    //ajouter les dates
                    $rechercheval = $this->DatesOptionContrat->find()->where(['contrat_id'=>$getcontrat->id, 'option_id'=>$keyopt]);
                    if($rechercheval->first()){
                      $datadatesvar = array('dates'=>$listedate);
                      $newdatesvaroption = $this->DatesOptionContrat->patchEntity($rechercheval->first(), $datadatesvar);
                      $this->DatesOptionContrat->save($newdatesvaroption);
                    }else{
                      $datadatesvar = array('contrat_id'=>$getcontrat->id, 'option_id'=>$keyopt, 'dates'=>$listedate);
                      $newdatesvaroption = $this->DatesOptionContrat->newEntity($datadatesvar);
                      $this->DatesOptionContrat->save($newdatesvaroption);
                    }
                    
                  }
                }                
              }              
              if($varvalop == "") $varvalop = "0:0////";
              $oldvaroption = $this->Varoptioncontrats->find()->where(['contrat_id'=>$getcontrat->id, 'option_id'=>$keyopt])->first();
              // print_r($oldvaroption);
              if($oldvaroption){
                $datavariablesop = array('variable_valeur'=>$varvalop);
                $newvaroptionop = $this->Varoptioncontrats->patchEntity($oldvaroption, $datavariablesop);
                $this->Varoptioncontrats->save($newvaroptionop);
              }else{
                $datavariablesop = array('contrat_id'=>$getcontrat->id,'variable_valeur'=>$varvalop, 'option_id'=>$keyopt);
                $newvaroptionop = $this->Varoptioncontrats->newEntity($datavariablesop);
                $this->Varoptioncontrats->save($newvaroptionop);
              }              
            }else{
              $oldvaroption = $this->Varoptioncontrats->find()->where(['contrat_id'=>$getcontrat->id, 'option_id'=>$keyopt])->first();
              if($oldvaroption) $this->Varoptioncontrats->delete($oldvaroption);
            }            
          }
          
          
        }
        
        // Vérifier les anciennes valeurs
        $anciennevaleur = $this->Varoptioncontrats->find()->where(['contrat_id'=>$getcontrat->id, 'option_id != '=>0]);
        foreach ($anciennevaleur as $ancienneval) {
          $vardynopt = $this->Optionscontrats->find()->where(['id' => $ancienneval->option_id])->first();
          if($vardynopt){
            if($this->request->data['option'.$ancienneval->option_id]){
              $listvariableopt = explode(";", $vardynopt->variables_id);
              $varvalop = "";
              foreach ($listvariableopt as $value) {
                $var2opt2 = "";
                $vardynop = $this->Variabledynamiques->find()->where(['id' => $value])->first();
                if($vardynop){
                  if($this->request->data['optionvar'.$value.'_'.$ancienneval->option_id]){
                    if($value == 2 && is_array($this->request->data['optionvar'.$value.'_'.$ancienneval->option_id])){
                      foreach ($this->request->data['optionvar'.$value.'_'.$ancienneval->option_id] as $valueval) {
                        $var2opt2 .= $valueval."__";
                      }
                      $varvalop .= $value.":".$var2opt2."////";
                    }else{
                      $varvalop .= $value.":".$this->request->data['optionvar'.$value.'_'.$ancienneval->option_id]."////";
                    }  
                    // $varvalop .= $value.":".$this->request->data['optionvar'.$value.'_'.$ancienneval->option_id]."////";
                    
                  }
                  // Enregistrement des dates option
                  if($value == 4){
                    $listedate = '';
                    $today = new Date();
                    for ($i=1; $i <= $this->request->data['optionvar'.$value.'_'.$ancienneval->option_id]; $i++) {
                      $date = $today->year."-".$this->request->data['mois_date_'.$i.'_'.$ancienneval->option_id]."-".$this->request->data['jour_date_'.$i.'_'.$ancienneval->option_id];
                      if(new Date($date) < $today) $date = ($today->year+1)."-".$this->request->data['mois_date_'.$i.'_'.$ancienneval->option_id]."-".$this->request->data['jour_date_'.$i.'_'.$ancienneval->option_id];
                   
                      $listedate .= $date.";";
                    }                    
                    //ajouter les dates
                    $rechercheval = $this->DatesOptionContrat->find()->where(['contrat_id'=>$getcontrat->id, 'option_id'=>$ancienneval->option_id]);
                    if($rechercheval->first()){
                      $datadatesvar = array('dates'=>$listedate);
                      $newdatesvaroption = $this->DatesOptionContrat->patchEntity($rechercheval->first(), $datadatesvar);
                      $this->DatesOptionContrat->save($newdatesvaroption);
                    }else{
                      $datadatesvar = array('contrat_id'=>$getcontrat->id, 'option_id'=>$ancienneval->option_id, 'dates'=>$listedate);
                      $newdatesvaroption = $this->DatesOptionContrat->newEntity($datadatesvar);
                      $this->DatesOptionContrat->save($newdatesvaroption);
                    }                    
                  }
                }                
              }
              if($varvalop == "") $varvalop = "0:0////";
              $oldvaroption = $this->Varoptioncontrats->find()->where(['contrat_id'=>$getcontrat->id, 'option_id'=>$ancienneval->option_id])->first();
              // print_r($oldvaroption);
              if($oldvaroption){
                $datavariablesop = array('variable_valeur'=>$varvalop);
                $newvaroptionop = $this->Varoptioncontrats->patchEntity($oldvaroption, $datavariablesop);
                $this->Varoptioncontrats->save($newvaroptionop);
              }else{
                $datavariablesop = array('contrat_id'=>$getcontrat->id,'variable_valeur'=>$varvalop, 'option_id'=>$ancienneval->option_id);
                $newvaroptionop = $this->Varoptioncontrats->newEntity($datavariablesop);
                $this->Varoptioncontrats->save($newvaroptionop);
              }              
            }else{
              $oldvaroption = $this->Varoptioncontrats->find()->where(['contrat_id'=>$getcontrat->id, 'option_id'=>$ancienneval->option_id])->first();
              if($oldvaroption) $this->Varoptioncontrats->delete($oldvaroption);
            }
          }
        }

        // Ajout périodicité option sur googleCalendar
        if($this->request->data['valider']=="valider"){
          $datesContrat = $this->DatesOptionContrat->find()->where(['contrat_id'=>$getcontrat->id])->contain(['Optionscontrats', 'Contrats']);
          // $gest_resp = $this->Annoncegestionnaires->find()->where(["Annoncegestionnaires.id_annonces=".$this->request->data["annonce_id"]])->select(["Annoncegestionnaires.id_gestionnaires"]);
          if($annonce->id_gestionnaires != 0){
            $gest_mail = $this->Gestionnaires->get($annonce->id_gestionnaires);
            if($gest_mail->googlecalendar_id != "") $calendarID = $gest_mail->googlecalendar_id;
            else $calendarID = 'admin@alpissime.com';
          }else{
            $calendarID = 'admin@alpissime.com';
          }
          foreach ($datesContrat as $valuedate) {  
            if(PROD_ON == 1){
              $googleCalendar = new GoogleCalendarController();          
              $googleCalendar->googlecalendarinsertoptioncontrat($valuedate, $calendarID);
            }
          }
        }
        
        // END Ajout périodicité option sur googleCalendar
        // exit;

    			$msg="";
    				switch($this->request->data['type']){
    					case "2":
    						$url="gestion de clé";
    						$msg="de gestion de clé";
    					break;
    					case "1":
    						$url="contrat technique";
    						$msg="technique";
    					break;
              case "4":
    						$url="contrat technique";
    						$msg="technique";
    					break;
    					case "3":
    						$url="mise en relation";
    						$msg="de mise en relation";
    					break;
              case "5":
    						$url="commercialisation";
    						$msg="de commercialisation";
    					break;
            }
            
            // Générer PDF
        $mpdf = new \Mpdf\Mpdf([
          'mode' => 'utf-8',
        ]);
        switch($this->request->data['type']){
          case "2":
            $url=SITE_ALPISSIME."manager/arrivees/viewpdf/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
            // $url=SITE_ALPISSIME."/manager/arrivees/viewpdf/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
          break;
          case "1":
            $url=SITE_ALPISSIME."manager/arrivees/viewpdfmaint/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
            // $url=SITE_ALPISSIME."/manager/arrivees/viewpdfmaint/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
          break;
          case "4":
            $url=SITE_ALPISSIME."manager/arrivees/viewpdfmaint/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
            // $url=SITE_ALPISSIME."/manager/arrivees/viewpdfmaint/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
          break;
          case "3":
            $url=SITE_ALPISSIME."manager/arrivees/viewpdfrelation/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
            // $url=SITE_ALPISSIME."/manager/arrivees/viewpdfrelation/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
          break;
          case "5":
            $url=SITE_ALPISSIME."manager/arrivees/viewpdfcommercialisation/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
          break;
        }
        $html=file_get_contents($url);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->SetFooter('{PAGENO}');
        $mpdf->WriteHTML(mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8"));
        $mpdf->Output(ROOT.DS.'webroot'.DS.'contrat'.DS."CT_".$utilisateur->id."_".$annonce->id.'.pdf','F');
        // FIN générer PDF

            $datamustache = array('nomprop' => $utilisateur->nom_famille, 'prenomprop' => $utilisateur->prenom, 'contrat' => $msg, 'gestionnaire' => $gestionnaire['G']['name']);
            
    				$this->loadModel("Registres");
    				$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();
            if($this->request->data['valider']=="valider"){
              // Enregistrer prix contrat
              $this->loadModel("PrixContrat");
              $dataprixcontrat = array('contrat_id' => $getcontrat->id, 'prix' => $this->request->data['variable1'], 'date_create' => $this->toDate($dateDepartTimestamp));
              $newprixcontrat = $this->PrixContrat->newEntity($dataprixcontrat);
              $this->PrixContrat->save($newprixcontrat);
              // #####################################################
              $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $utilisateur,'textEmail'=>'creationContrat',
                                  'data'=>$datamustache,'template'=>'creationContrat','viewVars'=>'creationContrat','noReply'=>false,
                                  'attachments'=>['contrat.pdf' => ROOT.DS.'webroot'.DS.'contrat'.DS."CT_".$utilisateur->id."_".$annonce->id.'.pdf']
                                ]);
              $this->eventManager()->dispatch($event);
              // ############ Copie Administration ####################
              $event = new Event('Email.send', $this, ['from'=>$utilisateur->email,'to' => $mail->val,'textEmail'=>'creationContrat',
                                  'data'=>$datamustache,'template'=>'creationContrat','viewVars'=>'creationContrat','noReply'=>false,
                                  'attachments'=>['contrat.pdf' => ROOT.DS.'webroot'.DS.'contrat'.DS."CT_".$utilisateur->id."_".$annonce->id.'.pdf']
                                ]);
              $this->eventManager()->dispatch($event);
              // #####################################################  
              
              // changer group prop dans boutique
              /* 7 Prop-contrat-conciergerie */
              $customerEmail = $utilisateur->email;
              $groupId = "7";
              $curl = curl_init();
              curl_setopt_array($curl, array(
                  CURLOPT_URL => BOUTIQUE_ALPISSIME."index.php/rest/all/V1/cakephp/updateCustomerGroup?customerEmail=".$customerEmail."&groupId=".$groupId."",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_HTTPHEADER => array("Content-Type: application/json"),
              ));
              $response = curl_exec($curl);
              curl_close($curl);
            }
            if(!isset($this->request->data['generercommande'])){
              // AJOUTER FONCTION BOUTIQUE GENERATION COMMANDE
              // FIN AJOUTER FONCTION BOUTIQUE GENERATION COMMANDE
            }
    				    // $session->write("Contrat.manuelle","addReservation");
    				return $this->redirect(['action' => 'editcontrat',$this->request->data['id']]);
		  // }else{
			// 	$session->write("Contrat.annule","addReservation");
			// 	return $this->redirect(['action' => 'editcontrat',$this->request->data['id']]);
			// }
		}else{
			$a_contrat=$this->Annonces->find();
			$a_contrat->join([
				// 'AG' => [
				// 	'table' => 'annoncegestionnaires',
				// 	'type' => 'INNER',
				// 	'conditions' => ['AG.id_annonces=Annonces.id'],
				// ],
				'C' => [
					'table' => 'contrats',
					'type' => 'inner',
					'conditions' => ['Annonces.id=C.annonce_id','C.id'=>$id],
				],
				'U' => [
					'table' => 'utilisateurs',
					'type' => 'INNER',
					'conditions' => ['U.id=Annonces.proprietaire_id'],
				],
				'R' => [
					'table' => 'residences',
					'type' => 'left',
					'conditions' => 'Annonces.batiment=R.id',
				],
				'V' => [
					'table' => 'villages',
					'type' => 'left',
					'conditions' => 'V.id=R.id_village',
				],
				'L' => [
					'table' => 'lieugeos',
					'type' => 'inner',
					'conditions' => ['L.id=Annonces.lieugeo_id'],
				],
        'Pays' => [
					'table' => 'pays',
					'type' => 'left',
					'conditions' => ['Pays.id_pays=Annonces.pays'],
				],
			])
				->select(['Annonces.id','Annonces.num_app','Annonces.surface','Annonces.region','Annonces.ville','Annonces.code_postal','R.name','V.name','L.name','Pays.fr','Pays.code_pays','Pays.id_pays',"U.id","U.prenom","U.nom_famille","U.adresse","U.adr2","U.portable","U.email","U.portable2","U.telephone2","U.telephone","U.fax","C.date_create","C.id","C.type","C.id_produit_contrat_boutique","Annonces.position_cle"]);
			$contrat=$a_contrat->first();
                        if($contrat['Pays']['id_pays']+0==67 || strtoupper($contrat['Pays']['code_pays'])=='FR'){
                            if($contrat->region!=null){
                                $this->loadModel('Departements');
                                $dep=$this->Departements->get($contrat->region);
                                $this->set('region',$dep->name);
                            }
                            if($contrat->ville!=null){
                                $this->loadModel('Frvilles');
                                $ville=$this->Frvilles->get($contrat->ville);
                                $this->set('ville',$ville->name);
                            }
                        }else{
                            if($contrat->ville!=null){
                                $this->loadModel('Pvilles');
                                $ville=$this->Pvilles->get($contrat->ville);
                                $this->set('ville',$ville->name);
                            }
                        }
			$this->set('a_contrat',$contrat);
		}

    $mail = [];
    $this->loadModel("Modelmailsysteme");
    $textEmail = $this->Modelmailsysteme->find('all');
    foreach ($textEmail as $key => $value) {
      $mail[$value->titre] = $value->txtmail;
    }
    $this->set("textmail",$mail);
    $contratypes = [];
		$modelcontratypes = $this->Contratypes->find('all');
    foreach ($modelcontratypes as $key => $value) {
      $contratypes[$value->type] = $value->contrat;
    }
    $this->set('contratypes',$contratypes);
    if($gestionnaire['G']['id'] == 9 || $gestionnaire['G']['id'] == 10) $this->set('a_type',$this->Contratypes->find('list',['keyField' => 'id',  'valueField' => 'type'])->where(['id <> 3', 'id <> 1', 'id <> 5']));
    else if($gestionnaire['G']['id'] == 3 || $gestionnaire['G']['id'] == 4) $this->set('a_type',$this->Contratypes->find('list',['keyField' => 'id',  'valueField' => 'type'])->where(['id <> 3', 'id <> 4']));
		else $this->set('a_type',$this->Contratypes->find('list',['keyField' => 'id',  'valueField' => 'type'])->where(['id <> 3', 'id <> 4', 'id <> 5']));
	}
  /**
	 *
	 **/
	function contrat(){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		if($session->check("Contrat.manuelle")){
			$this->set('confirm_res','reservation');
			$session->delete("Contrat.manuelle");
		}
		if($session->check("Contrat.annule")){
			$this->set('msg_annulation','reservation');
			$session->delete("Contrat.annule");
		}
    $this->loadModel("Annonces");
    $this->loadModel("Utilisateurs");
		$this->loadModel("Contrats");
		$this->loadModel("Annoncegestionnaires");
    $this->loadModel("Contratypes");
    $this->loadModel("Gestionnaires");
		if($this->request->is('post')){
      $gestionnaire=$session->read('Gestionnaire.info');
      $contrat = $this->Contrats->newEntity();
      $dateDepartTimestamp = date("d-m-Y", strtotime($this->request->data['date_mise_route']));
      $date_echeance=date("d-m-Y",strtotime('+3 month', strtotime($dateDepartTimestamp)));
      $date_rappel=date("d-m-Y",strtotime('+1 year', strtotime($dateDepartTimestamp)));
      $data_contrat=array('date_create'=>$this->toDate($dateDepartTimestamp)
									,"date_echeance"=>$this->toDate($date_echeance)
									,"date_rappel"=>$this->toDate($date_rappel)
									,"annonce_id"=>$this->request->data['annonce_id']
									,"type"=>$this->request->data['type']
									,"taxe"=>0
									,"visible"=>1
                  ,"prix"=>$this->request->data['variable1']
                  ,"payerGest"=>$this->request->data['payerGest']
                  ,"id_produit_contrat_boutique"=>$this->request->data['id_produit_contrat_boutique']);
      $contrat = $this->Contrats->patchEntity($contrat, $data_contrat);
      $getcontrat = $this->Contrats->save($contrat);
      $annonce=$this->Annonces->get($this->request->data['annonce_id']);
				
			if($this->request->data['valider']=="valider"){
				$data_annonce=array("num_app"=>$this->request->data['num_app'],"surface"=>$this->request->data['surface'],'date_contrat'=>Time::now());
        $session->write("Contrat.manuelle","addReservation");
		  }else{
        $data_annonce=array("num_app"=>$this->request->data['num_app'],"surface"=>$this->request->data['surface']);
				$session->write("Contrat.annule","addReservation");
			}
								
      $annonce = $this->Annonces->patchEntity($annonce, $data_annonce);
      if($this->request->data['valider']=="valider"){
        $annonce->contrat = 1;
      }
      $this->Annonces->save($annonce);

      $utilisateur=$this->Utilisateurs->get($this->request->data['proprietaire_id']);
      $data_util=array("prenom"=>$this->request->data['prenom'],"nom_famille"=>$this->request->data['nom_famille'],"telephone"=>$this->request->data['tel1'],
                                                "portable"=>$this->request->data['portable1'],"telephone2"=>$this->request->data['tel2'],"portable2"=>$this->request->data['portable2'],
                                                "adr2"=>$this->request->data['adr2'],"adresse"=>$this->request->data['adresse'],
                                                "pays"=>$this->request->data['paysProp'],"code_postal"=>$this->request->data['codePostalProp'],"ville"=>$this->request->data['villeProp']);
      $utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $data_util);
      $this->Utilisateurs->save($utilisateur);

      // $res=$this->Annoncegestionnaires->find('all',['conditions'=>['id_gestionnaires'=>$gestionnaire['G']['id'],'id_annonces'=>$this->request->data["annonce_id"]]]);
      if($this->request->data["position_cle"] == ''){
        $poscle = 0;
      }else{
        $poscle = $this->request->data["position_cle"];
      }
      // $resanngest=$this->Annoncegestionnaires->find('all',['conditions'=>['id_annonces'=>$this->request->data["annonce_id"]]]);
      // if($res->first()){
      //   $annoncegestionnaire=$res->first();
      //   $a_annoncegestionnaires=array("position_cle"=>$poscle);
      //   $annoncegestionnaire = $this->Annoncegestionnaires->patchEntity($annoncegestionnaire, $a_annoncegestionnaires);
      //   $this->Annoncegestionnaires->save($annoncegestionnaire);
      // }else if($resanngest->first()){
      //   $annoncegestionnaire=$resanngest->first();
      //   $a_annoncegestionnaires=array("position_cle"=>$poscle, 'id_gestionnaires'=>$gestionnaire['G']['id']);
      //   $annoncegestionnaire = $this->Annoncegestionnaires->patchEntity($annoncegestionnaire, $a_annoncegestionnaires);
      //   $this->Annoncegestionnaires->save($annoncegestionnaire);
      // }else{
        $annoncegestionnaire=$this->Annonces->get($this->request->data['annonce_id']);
        $a_annoncegestionnaires=array("position_cle"=>$poscle
        ,"id_gestionnaires"=>$gestionnaire['G']['id']
        ,"visible"=>1);
        $annoncegestionnaire = $this->Annonces->patchEntity($annoncegestionnaire, $a_annoncegestionnaires);
        $this->Annonces->save($annoncegestionnaire);
      // }
      
      //ajouter les valeurs des variables du contrat
      $this->loadModel('Optionscontrats');
      $this->loadModel('Variabledynamiques');
      $contratype = $this->Contratypes->get($this->request->data['type']);
      $listabvardyn = [];
      $listvariablecontrat = explode(";", $contratype->variables_id);
      $varval = "";
      foreach ($listvariablecontrat as $key) {
        $vardyn = $this->Variabledynamiques->find()->where(['id' => $key])->first();
        if($vardyn){
          if($this->request->data['variable'.$key]){
            $varval .= $key.":".$this->request->data['variable'.$key]."////";
          }
        } 
      }
      $datavariables = array('contrat_id'=>$getcontrat->id, 'variable_valeur'=>$varval, 'option_id'=>0);
      $this->loadModel('Varoptioncontrats');
      $newvaroption = $this->Varoptioncontrats->newEntity($datavariables);
      $this->Varoptioncontrats->save($newvaroption);

      //ajouter les valeurs variables option du contrat
      $this->loadModel('DatesOptionContrat');
      $listoptioncontrat = explode(";", $contratype->options_id);
      foreach ($listoptioncontrat as $keyopt) {
        $vardynopt = $this->Optionscontrats->find()->where(['id' => $keyopt])->first();
        if($vardynopt){
          if($this->request->data['option'.$keyopt]){
            $listvariableopt = explode(";", $vardynopt->variables_id);
            $varvalop = "";
            foreach ($listvariableopt as $value) {
              $vardynop = $this->Variabledynamiques->find()->where(['id' => $value])->first();
              if($vardynop){
                if($this->request->data['optionvar'.$value.'_'.$keyopt]){
                  $varvalop .= $value.":".$this->request->data['optionvar'.$value.'_'.$keyopt]."////";
                }
                // Enregistrement des dates option
                if($value == 4){
                  $listedate = '';
                  $today = new Date();
                  for ($i=1; $i <= $this->request->data['optionvar'.$value.'_'.$keyopt]; $i++) { 
                    $date = $today->year."-".$this->request->data['mois_date_'.$i.'_'.$keyopt]."-".$this->request->data['jour_date_'.$i.'_'.$keyopt];
                    if(new Date($date) < $today) $date = ($today->year+1)."-".$this->request->data['mois_date_'.$i.'_'.$keyopt]."-".$this->request->data['jour_date_'.$i.'_'.$keyopt];
                   
                    $listedate .= $date.";";
                  }
                  //ajouter les dates
                  $datadatesvar = array('contrat_id'=>$getcontrat->id, 'option_id'=>$keyopt, 'dates'=>$listedate);
                  $newdatesvaroption = $this->DatesOptionContrat->newEntity($datadatesvar);
                  $this->DatesOptionContrat->save($newdatesvaroption);
                }
              }                
            }
            if($varvalop == "") $varvalop = "0:0////";
            $datavariablesop = array('contrat_id'=>$getcontrat->id, 'variable_valeur'=>$varvalop, 'option_id'=>$keyopt);
            $newvaroptionop = $this->Varoptioncontrats->newEntity($datavariablesop);
            $this->Varoptioncontrats->save($newvaroptionop);
          }
        }
        // print_r("///".$keyopt."///");
        
      }
      // Ajout périodicité option sur googleCalendar
      if($this->request->data['valider']=="valider"){
        $datesContrat = $this->DatesOptionContrat->find()->where(['contrat_id'=>$getcontrat->id])->contain(['Optionscontrats', 'Contrats']);
        // $gest_resp = $this->Annoncegestionnaires->find()->where(["Annoncegestionnaires.id_annonces=".$this->request->data["annonce_id"]])->select(["Annoncegestionnaires.id_gestionnaires"]);
        if($annonce->id_gestionnaires != 0){
          $gest_mail = $this->Gestionnaires->get($annonce->id_gestionnaires);
          if($gest_mail->googlecalendar_id != "") $calendarID = $gest_mail->googlecalendar_id;
          else $calendarID = 'admin@alpissime.com';
        }else{
          $calendarID = 'admin@alpissime.com';
        }
        foreach ($datesContrat as $valuedate) {  
          if(PROD_ON == 1){
            $googleCalendar = new GoogleCalendarController();           
            $googleCalendar->googlecalendarinsertoptioncontrat($valuedate, $calendarID);
          }
        }
      }      
      // END Ajout périodicité option sur googleCalendar

      // exit;

      $msg="";
      switch($this->request->data['type']){
        case "2":
          $url="gestion de clé";
          $msg="de gestion de clé";
        break;
        case "1":
          $url="contrat technique";
          $msg="contrat technique";
        break;
        case "4":
          $url="contrat technique";
          $msg="contrat technique";
        break;
        case "3":
          $url="mise en relation";
          $msg="de mise en relation";
        break;
        case "5":
          $url="commercialisation";
          $msg="de commercialisation";
        break;
      }
      
      // Générer PDF
      $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
      ]);
      switch($this->request->data['type']){
        case "2":
          $url=SITE_ALPISSIME."manager/arrivees/viewpdf/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
          // $url=SITE_ALPISSIME."/manager/arrivees/viewpdf/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
        break;
        case "1":
          $url=SITE_ALPISSIME."manager/arrivees/viewpdfmaint/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
          // $url=SITE_ALPISSIME."/manager/arrivees/viewpdfmaint/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
        break;
        case "4":
          $url=SITE_ALPISSIME."manager/arrivees/viewpdfmaint/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
          // $url=SITE_ALPISSIME."/manager/arrivees/viewpdfmaint/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
        break;
        case "3":
          $url=SITE_ALPISSIME."manager/arrivees/viewpdfrelation/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
          // $url=SITE_ALPISSIME."/manager/arrivees/viewpdfrelation/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
        break;
        case "5":
          $url=SITE_ALPISSIME."manager/arrivees/viewpdfcommercialisation/".$utilisateur->id."/".$annonce->id."/".$gestionnaire['G']['id']."/".$getcontrat->date_create->i18nFormat('dd-MM-yyyy')."/". urlencode(serialize($this->request->data));
        break;
      }
      $html=file_get_contents($url);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->list_indent_first_level = 0;
      $mpdf->setAutoBottomMargin = 'stretch';
      $mpdf->SetFooter('{PAGENO}');
      $mpdf->WriteHTML(mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8"));
      $mpdf->Output(ROOT.DS.'webroot'.DS.'contrat'.DS."CT_".$utilisateur->id."_".$annonce->id.'.pdf','F');
      // FIN générer PDF

      $datamustache = array('nomprop' => $utilisateur->nom_famille, 'prenomprop' => $utilisateur->prenom, 'contrat' => $msg, 'gestionnaire' => $gestionnaire['G']['name']);

      $this->loadModel("Registres");
      $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);

      $mail=$mails->first();
      if($this->request->data['valider']=="valider"){
        // Enregistrer prix contrat
        $this->loadModel("PrixContrat");
        $dataprixcontrat = array('contrat_id' => $getcontrat->id, 'prix' => $this->request->data['variable1'], 'date_create' => $this->toDate($dateDepartTimestamp));
        $newprixcontrat = $this->PrixContrat->newEntity($dataprixcontrat);
        $this->PrixContrat->save($newprixcontrat);
        // #####################################################
        $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $utilisateur,'textEmail'=>'creationContrat',
                                                  'data'=>$datamustache,'template'=>'creationContrat','viewVars'=>'creationContrat','noReply'=>false,
                                                  'attachments'=>['contrat.pdf' => ROOT.DS.'webroot'.DS.'contrat'.DS."CT_".$utilisateur->id."_".$annonce->id.'.pdf']
                                                ]);
        $this->eventManager()->dispatch($event);
        // ############ Copie Administration ####################
        $event = new Event('Email.send', $this, ['from'=>$utilisateur->email,'to' => $mail->val,'textEmail'=>'creationContrat',
                                                  'data'=>$datamustache,'template'=>'creationContrat','viewVars'=>'creationContrat','noReply'=>false,
                                                  'attachments'=>['contrat.pdf' => ROOT.DS.'webroot'.DS.'contrat'.DS."CT_".$utilisateur->id."_".$annonce->id.'.pdf']
                                                ]);
        $this->eventManager()->dispatch($event);
        // #####################################################   
        
        // changer group prop dans boutique
        /* 7 Prop-contrat-conciergerie */
        $customerEmail = $utilisateur->email;
        $groupId = "7";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => BOUTIQUE_ALPISSIME."index.php/rest/all/V1/cakephp/updateCustomerGroup?customerEmail=".$customerEmail."&groupId=".$groupId."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array("Content-Type: application/json"),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
      }
      if(!isset($this->request->data['generercommande'])){
        // AJOUTER FONCTION BOUTIQUE GENERATION COMMANDE
        // FIN AJOUTER FONCTION BOUTIQUE GENERATION COMMANDE
      }
      
      return $this->redirect(['action' => 'contrat']);
    
		}
    $this->loadModel("Pays");
    $Pays=$this->Pays->find('all')->order(['Pays.fr' => 'ASC']);
    $a_pay=array();
    $payNum=array();
    $a_pay[0] = '';
    foreach($Pays as $pay){
        $a_pay[$pay->id_pays]=$pay->fr;
        $payNum[$pay->id_pays]=$pay->code_pays;
    }
    $this->set("Pays", $a_pay);
    $mail = [];
    $this->loadModel("Modelmailsysteme");
    $textEmail = $this->Modelmailsysteme->find('all');
    foreach ($textEmail as $key => $value) {
      $mail[$value->titre] = $value->txtmail;
    }
    $this->set("textmail",$mail);
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->set('gestionnaire',$gestionnaire);
    if($gestionnaire['G']['id'] == 9 || $gestionnaire['G']['id'] == 10) $this->set('a_type',$this->Contratypes->find('list',['keyField' => 'id',  'valueField' => 'type'])->where(['id <> 3', 'id <> 1', 'id <> 5']));
    else if($gestionnaire['G']['id'] == 3 || $gestionnaire['G']['id'] == 4) $this->set('a_type',$this->Contratypes->find('list',['keyField' => 'id',  'valueField' => 'type'])->where(['id <> 3', 'id <> 4']));
		else $this->set('a_type',$this->Contratypes->find('list',['keyField' => 'id',  'valueField' => 'type'])->where(['id <> 3', 'id <> 4', 'id <> 5']));
		$this->set('InfoGes',$gestionnaire);

    $contratypes = [];
		$modelcontratypes = $this->Contratypes->find('all')->where(['id <> 3']);
    foreach ($modelcontratypes as $key => $value) {
      $contratypes[$value->type] = $value->contrat;
    }
    $this->set('contratypes',$contratypes);
	}
  /**
	 *
	 **/
	function getproprietaire(){
		$this->loadModel("Annonces");
		$this->loadModel("Contrats");
		$res=$this->Annonces->find();
		if(!empty($this->request->query['id_ann'])){
			$res->join([
					'U' => [
						'table' => 'utilisateurs',
						'type' => 'INNER',
						'conditions' => ['U.id=Annonces.proprietaire_id'],
					],
					'R' => [
						'table' => 'residences',
						'type' => 'left',
						'conditions' => 'Annonces.batiment=R.id',
					],
					'V' => [
						'table' => 'villages',
						'type' => 'left',
						'conditions' => 'V.id=R.id_village',
					],
					'L' => [
						'table' => 'lieugeos',
						'type' => 'inner',
						'conditions' => ['L.id=Annonces.lieugeo_id'],
					],
					'Pays' => [
						'table' => 'pays',
						'type' => 'INNER',
						'conditions' => 'Pays.id_pays=Annonces.pays',
					]
				])
				->select(['Annonces.id','Annonces.num_app','Annonces.surface','Annonces.code_postal','Annonces.pays','Annonces.ville','Annonces.region','Pays.code_pays','Pays.fr','R.name','V.name','L.name','U.ville',"U.id","U.prenom","U.nom_famille","U.adresse","U.adr2","U.portable","U.telephone","U.fax","U.portable2","U.telephone2","U.pays","U.code_postal"])
				->where(['Annonces.id'=>$this->request->query['id_ann'], '(Annonces.statut=30 OR Annonces.statut=50 OR Annonces.statut=0)']);
		}else{
			$res->join([
					'U' => [
						'table' => 'utilisateurs',
						'type' => 'INNER',
						'conditions' => ['U.id=Annonces.proprietaire_id'],
					],
					'R' => [
						'table' => 'residences',
						'type' => 'left',
						'conditions' => 'Annonces.batiment=R.id',
					],
					'V' => [
						'table' => 'villages',
						'type' => 'left',
						'conditions' => 'V.id=R.id_village',
					],
					'L' => [
						'table' => 'lieugeos',
						'type' => 'inner',
						'conditions' => ['L.id=Annonces.lieugeo_id'],
					],
					'Pays' => [
						'table' => 'pays',
						'type' => 'INNER',
						'conditions' => 'Pays.id_pays=Annonces.pays',
					]
				])
				->select(['Annonces.id','Annonces.num_app','Annonces.surface','Annonces.code_postal','Annonces.pays','Annonces.ville','Annonces.region','Pays.code_pays','Pays.fr','R.name','V.name','L.name','U.ville',"U.id","U.prenom","U.nom_famille","U.adresse","U.adr2","U.portable","U.telephone","U.fax","U.portable2","U.telephone2","U.pays","U.code_postal"])
				->where(['LOWER(U.email) LIKE '=>strtolower($this->request->query['term']), '(Annonces.statut=30 OR Annonces.statut=50 OR Annonces.statut=0)']);
		}
		$i=0;$j=0;
		foreach($res as $re){
			$j++;
			$query = $this->Contrats->find();
			$query->where(['Contrats.annonce_id'=>$re->id,'Contrats.visible'=>1]);
			$query->select(['nb' => $query->func()->count('*')]);
			$a_contrat=$query->first();
			if($a_contrat['nb']==0){
                            if(intval($re['U']['pays'])==67){
                              $this->loadModel("Frvilles");
                              $ville_id = $this->Frvilles->find()->where(['id =' => $re['U']['ville']])->first()->id;
                              $departement_id = $this->Frvilles->find()->where(['id =' => $re['U']['ville']])->first()->departement_id;
                              }
                            else{
                              $this->loadModel("Pvilles");
                              $ville_id = $this->Pvilles->find()->where(['id =' => $re['U']['ville']])->first()->id;
                              $departement_id=0;
                            }
                                if($re['Pays']['id_pays']+0==67 || strtoupper($re['Pays']['code_pays'])=='FR'){
                                    if($re->region!=null){
                                        $this->loadModel('Departements');
                                        $dep=$this->Departements->get($re->region);
                                    }
                                    if($re->ville!=null){
                                        $this->loadModel('Frvilles');
                                        $ville=$this->Frvilles->get($re->ville);
                                    }
                                }else{
                                    if($re->ville!=null){
                                        $this->loadModel('Pvilles');
                                        $ville=$this->Pvilles->get($re->ville);
                                    }
                                }
                                $a_response[0]['adresse']=array("pays"=>$re['Pays']['fr'],"code_postal"=>$re->code_postal,'ville'=>$ville->name,'region'=>$dep->name);
				$a_response[0]['user']=array("id"=>$re['U']['id'],"prenom"=>$re['U']['prenom'],"nom_famille"=>$re['U']['nom_famille'],"adresse"=>$re['U']['adresse'],"adr2"=>$re['U']['adr2'],"portable"=>$re['U']['portable'],"telephone"=>$re['U']['telephone'],"portable1"=>$re['U']['portable2'],"telephone1"=>$re['U']['telephone2'],'departement'=>$departement_id,'ville'=>$ville_id,"fax"=>$re['U']['fax'],"pays"=>intval($re['U']['pays']),"code_postal"=>$re['U']['code_postal']);
				$a_response[0]['annonce'][$i]=array("id"=>$re->id,"num_app"=>$re->num_app,"surface"=>$re->surface);
				$a_response[0]['residence'][$i]=array("name"=>$re['R']['name']);
				$a_response[0]['village'][$i]=array("name"=>$re['V']['name']);
				$a_response[0]['ville'][$i]=array("name"=>$re['VV']['name']);
				$a_response[0]['lieugeo'][$i]=array("name"=>$re['L']['name']);
				$i++;
			}
		}
		if($j==0){
			echo json_encode(array('label'=>'recherchevide'));
			exit();
		}
		$a_response[0]['nb_app']=$i;                
		if($i>0)
                    echo json_encode($a_response);
		else
			echo json_encode(array('label'=>'contratexist'));

    exit();
	}
  /**
	 *
	 **/
	function menage($id=null)
	{
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$this->set('InfoGes', $session->read('Gestionnaire.info'));
    $gestionnaire=$session->read('Gestionnaire.info');
    $this->loadModel("Annonces");
    $gestion= $this->Annonces->find();
    $gestion->join([
        'RR' => [
            'table' => 'reservations',
            'type' => 'inner',
            'conditions' => ['RR.annonce_id=Annonces.id',"RR.statut=90"],
        ],
        'U' => [
            'table' => 'utilisateurs',
            'type' => 'inner',
            'conditions' => 'U.id=RR.utilisateur_id',
        ],
        'P' => [
            'table' => 'utilisateurs',
            'type' => 'inner',
            'conditions' => 'P.id=Annonces.proprietaire_id',
        ],
        'G'=>[
          'table' => 'gestionnaires',
          'type' => 'inner',
          'conditions' => ['G.id=Annonces.id_gestionnaires','Annonces.id_gestionnaires'=>$gestionnaire['G']['id']]
        ],
        'R' => [
            'table' => 'residences',
            'type' => 'left',
            'conditions' => ['R.id=Annonces.batiment','RR.menage>=1'],
        ]

    ])
        ->select(['Annonces.num_app','U.prenom','U.nom_famille','U.portable','P.prenom','P.nom_famille','P.portable','R.name','Annonces.id','Annonces.surface','RR.id','RR.menage','RR.dbt_at']);

    $tabMailInfo = [];
    foreach ($gestion as $k) {
      $tabMailInfo[$k['RR']['id']] = [];
      $tabMailInfo[$k['RR']['id']]['prenom'] = $k['U']['prenom'];
      $tabMailInfo[$k['RR']['id']]['nom'] = $k['U']['nom_famille'];
      $tabMailInfo[$k['RR']['id']]['appartement'] = $k->num_app;
    }
    $this->set('tabMailInfo',$tabMailInfo);

    $mail = [];
    $this->loadModel("Modelmailsysteme");
    $textEmail = $this->Modelmailsysteme->find('all');
    foreach ($textEmail as $key => $value) {
      $mail[$value->titre] = $value->txtmail;
    }
    $this->set("textmail",$mail);
	}
  /**
	 *
	 **/
	function arraymenage(){
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->loadModel("Annonces");
		$url=Router::url('/');
		$output=$this->Annonces->get_array_menage($url,$this->request->query,$gestionnaire['G']['id']);
		echo json_encode($output);die();
	}
  /**
	 *
	 **/
	function validermenage($id=null){
		$this->loadModel("Reservations");
		$users=$this->Reservations->find()
								->join([
									'A' => [
										'table' => 'annonces',
										'type' => 'inner',
										'conditions' => 'Reservations.annonce_id=A.id',
									],
									'U' => [
										'table' => 'utilisateurs',
										'type' => 'inner',
										'conditions' => 'U.id=Reservations.utilisateur_id',
									],
								])
								->select(['A.num_app','U.email','Reservations.dbt_at','U.prenom', 'U.nom_famille','U.portable'])
								->where(['Reservations.id'=>$id]);
		$user=$users->first();
		$reservation=$this->Reservations->get($id);
		$a_res=array('menage'=>2);
		$reservation=$this->Reservations->patchEntity($reservation,$a_res);
		$reservation=$this->Reservations->save($reservation);

                $datamustache = array('nom' => $user['U']['nom_famille'], 'prenom' => $user['U']['prenom'], 'appartement' => $user['A']['num_app']);
                
		$this->loadModel("Registres");
		$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
		$mail=$mails->first();
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $user['U'],'textEmail'=>'validationMenage',
                                                         'data'=>$datamustache,'template'=>'validationMenage','viewVars'=>'validationMenage','noReply'=>false
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################
		die();
	}
  /**
	 *
	 **/
	function sendmailmenage($id=null){
		$this->viewBuilder()->layout('ajax');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->loadModel("Reservations");
		$users=$this->Reservations->find()
			->join([
				'A' => [
					'table' => 'annonces',
					'type' => 'inner',
					'conditions' => 'Reservations.annonce_id=A.id',
				],
				'U' => [
					'table' => 'utilisateurs',
					'type' => 'inner',
					'conditions' => 'A.proprietaire_id=U.id',
				],
			])
			->select(['U.email'])
			->where(['Reservations.id'=>$id]);
		$prop=$users->first();
		$this->set('mail_gest',$gestionnaire['G']['email']);
		$this->set('mail_prop',$prop['U']['email']);
	}
  /**
	 *
	 **/
	function setmailmenage($id=null){
		$emailAd = new Email('production');
		$emailAd->template('emailPropMenage', 'default')
			->emailFormat('html')
			->to($this->request->data["vTo"])
			->from([$this->request->data["vFrom"]=>'Gestionnaire'])
			->subject($this->request->data["vObjet"])
			->viewVars(["comment"=>$this->request->data["vMsg"]])
			->send();
		die();
	}
  /**
	 *
	 **/
	function taxesejour(){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$this->set('InfoGes', $session->read('Gestionnaire.info'));
	}
  /**
	 *
	 **/
   function retournerDisposID($dataSel,$dataAnnonceID){
     $this->loadModel("Dispos");
     $perid = explode("/", $dataSel);
     $dispo = $this->Dispos->chercherdisponibilite($dataAnnonceID, $perid[0], $perid[1]);
     $dispoCount = $this->Dispos->chercherdisponibiliteCount($dataAnnonceID, $perid[0], $perid[1]);
     $resultatDetail = [];
     $resultatDetail['du'] = new Date($perid[0]);
     $resultatDetail['au'] = new Date($perid[1]);
     $resultatDetail['nbrperiode'] = $dispoCount->count();
     $resultatDetail['dispoID'] = '';
     if($dispoCount->count() == 1){
       $value = $dispo->first();
       $resultatDetail['nbrsejour'][1] = (new Date($perid[1]))->diff(new Date($perid[0]))->days;
       $nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
       if($value->prix_jour == 0 && $value->prix != 0 && $value->promo_yn == 0){
         $resultatDetail['prixjour'][1] = round(($value->prix/$nbrDiff), 2);
       }else if($value->promo_jour == 0 && $value->promo_px != 0 && $value->promo_yn == 1){
         $resultatDetail['prixjour'][1] = round(($value->promo_px/$nbrDiff), 2);
       }else if($value->promo_yn == 0){
         $resultatDetail['prixjour'][1]  = round($value->prix_jour, 2);
       }else if($value->promo_yn == 1){
         $resultatDetail['prixjour'][1]  = round($value->promo_jour, 2);
       }
       $resultatDetail['total'] = $resultatDetail['prixjour'][1] * $resultatDetail['nbrsejour'][1];
       $resultatDetail['dispoID'] .= $value->id;
     }else{
       $i = 1;
       $resultatDetail['total'] = 0;
       $perid[0] = new Date($perid[0]);
       foreach ($dispo as $value) {
         $nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
         $fn = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
         if($fn < new Date($perid[1])){
           $resultatDetail['nbrsejour'][$i] = $fn->diff($perid[0])->days;
           $resultatDetail['periodedu'][$i] = $perid[0];
           $resultatDetail['periodeau'][$i] = $fn;
           $perid[0] = $fn;
         }else{
           $resultatDetail['nbrsejour'][$i] = (new Date($perid[1]))->diff($perid[0])->days;
           $resultatDetail['periodedu'][$i] = $perid[0];
           $resultatDetail['periodeau'][$i] = new Date($perid[1]);
         }

         if($value->prix_jour == 0 && $value->prix != 0 && $value->promo_yn == 0){
           $resultatDetail['prixjour'][$i] = round(($value->prix/$nbrDiff), 2);
         }else if($value->promo_jour == 0 && $value->promo_px != 0 && $value->promo_yn == 1){
           $resultatDetail['prixjour'][$i] = round(($value->promo_px/$nbrDiff), 2);
         }else if($value->promo_yn == 0){
           $resultatDetail['prixjour'][$i]  = round($value->prix_jour, 2);
         }else if($value->promo_yn == 1){
           $resultatDetail['prixjour'][$i]  = round($value->promo_jour, 2);
         }
         $resultatDetail['totalperiode'][$i] = $resultatDetail['prixjour'][$i] * $resultatDetail['nbrsejour'][$i];
         $resultatDetail['total'] = $resultatDetail['total']+$resultatDetail['totalperiode'][$i];
         $resultatDetail['dispoID'] .= $value->id."_".$resultatDetail['periodedu'][$i]."_".$resultatDetail['periodeau'][$i]."-";
         $i = $i + 1;
       }
     }
     return $resultatDetail['dispoID'];
   }
  /**
   *
   */
  public function getRegType(){
    // $collection = Mage::getModel('directory/region_api')->items('FR');
    // $i=1;
    // foreach ($collection as $values)
    // {
    //     $regionModel = Mage::getModel('directory/region')->load($values['region_id']);
    //     $region = $regionModel->getName();
    //     $resArr[$values['region_id']] = $region;
    // }
    // return $resArr;
    $curl = curl_init();
			$regionid = $regionid;

			curl_setopt_array($curl, array(
				CURLOPT_URL => BOUTIQUE_ALPISSIME."index.php/rest/all/V1/cakephp/getRegionById?regionId=".$regionid."",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array("Content-Type: application/json"),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			// print_r(json_decode($response));
			// exit;
			return json_decode($response);
  }
  /**
 	 *
 	 **/
	function location(){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		if($session->check("Reseservation.manuelle")){
			$this->set('confirm_res','reservation');
			$session->delete("Reseservation.manuelle");
		}
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->set('InfoGes',$gestionnaire);
		$this->loadModel("Utilisateurs");
		$this->loadModel("Dispos");
		$this->loadModel("Packs");
		$this->loadModel("Annonces");
		$this->loadModel("Reservations");
    $this->loadModel('Annoncegestionnaires');
    $this->loadModel('Gestionnaires');
		if (!empty($this->request->data)) {
		/** verification l'existance de periode **/
		 $dispos=$this->Dispos->find('all',['conditions'=>[	'Dispos.annonce_id'=>$this->request->data["annonce_id"],
													'Dispos.dbt_at'=>date("Y-m-d", strtotime($this->request->data["debut"])),
													'Dispos.fin_at'=>date("Y-m-d", strtotime($this->request->data["fin"])),
													'Dispos.statut'=>0
													]]);
		$this->loadModel("Registres");
		$registre= $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
		$mail =$registre->first();
		$info_ann = $this->Annonces->get($this->request->data['annonce_id']);
		$info_prop = $this->Utilisateurs->get($info_ann->proprietaire_id);
		//verfication l'exiqtance de locataire
		$res_uti=$this->Utilisateurs->find('all',['conditions'=>["lcase(email) LIKE '".trim(strtolower($this->request->data['email']))."'"]]);
		$nouveau=0;
		if(empty($res_uti->first())){
                        $mdp_en_clair = $this->request->data['mdpenclair'];
			$a_utlisateur=array('email'=>strtolower($this->request->data['email']),
								'mot_passe'=>md5($mdp_en_clair),
								'civilite'=>$this->request->data['civilite'],
								'prenom'=>$this->request->data['prenom'],
								'nom_famille'=>$this->request->data['nom'],
								'telephone'=>$this->request->data['portable2'],
								'portable'=>$this->request->data['portable1'],
								'code_postal'=>$this->request->data['code_postal'],
								'ville'=>$this->request->data['villeprop'],
                                                                'pays'=>$this->request->data['pays'],
								'statut'=>"90",
								'ident'=>$this->request->data['email'],
								'nature'=>"CLT");
                        if($this->request->data['pays'] == 67){
                            $a_utlisateur['region'] = $this->request->data['region'];
                        }
                        
			$utilisateur = $this->Utilisateurs->newEntity($a_utlisateur);
			$utilisateur->pwd=(new DefaultPasswordHasher)->hash($mdp_en_clair);
			$utilisateur->date_insert=Time::now();
			$utilisateur->date_update=Time::now();
			$utilisateur=$this->Utilisateurs->save($utilisateur);

      $id_loc=$utilisateur->id;
      //Add SendInBlue 
      $this->loadModel("Pays");
      if(PROD_ON == 1){
        $sendinblue=new SendInBlueController();
        $sendinblue->addContactToSendInBlue($utilisateur->email,$utilisateur->prenom,$utilisateur->nom_famille,$utilisateur->portable,$utilisateur->civilite,$utilisateur->naissance,null,null,null, $this->Pays->get($utilisateur->pays)->fr ,'CLT');
      }
      //END SendInBlue
      $nouveau=1;
      $this->loadModel('UtilisateursTokens');
      $token=sha1($utilisateur->email.$utilisateur->pwd);
      $this->UtilisateursTokens->deleteAll(['user_id' => $utilisateur->id]);
      $user_token=$this->UtilisateursTokens->newEntity([
          'user_id'=>$utilisateur->id,
          'token'=>$token,
          'expired_at'=>date('Y-m-d', strtotime('+1 year'))
      ]);
      
      $url=Router::url(['controller' => 'Utilisateurs', 'action' => 'confirmuser','token'=>$token],true);
      
      $this->UtilisateursTokens->save($user_token);
      Log::write('emergency', 'Création compte (Reservation Manuelle)avec mot de passe : "'.$mdp_en_clair.'" ; client : "'.$utilisateur->email.'"');
      
		}else{
			 $utilisateur=$res_uti->first();
			 $id_loc=$utilisateur->id;
    }
    
		/** Traitement periodes **/
		$perid = explode("/", $this->request->data["sel"]);
		$data=array("annonce_id" => $this->request->data["annonce_id"],
					"utilisateur_id" => $id_loc,
					"statut" => 90,
					"dbt_at" => $this->toDate(new Date($perid[0])),
					"fin_at" => $this->toDate(new Date($perid[1])),
					"created_at" => $this->toDate(date('d-m-Y')),
					"updated_at" => $this->toDate(date('d-m-Y')),
          "nb_enfants" => $this->request->data["enfant"],
          "prixapayer" => $this->request->data["totalapayer"],
					"nb_adultes" => $this->request->data["adult"]);
		$reservation = $this->Reservations->newEntity($data);

		if($this->Reservations->save($reservation)){
      Log::write('info', '1/Manager Creation Reservation: reservationID: '.$reservation->id.'__debut: '.$perid[0].'__fin: '.$perid[1].'__locataireID: '.$id_loc.'__annonceID: '.$this->request->data["annonce_id"].'__gestionnaireID: '.$gestionnaire['G']['id']);

  		/** Enregistrer les numeros de telephone **/
  		$this->loadModel("Reservationtelephone");
  		for ($x = 1; $x < $this->request->data["adult"]; $x++) {
  			if($this->request->data['telephoneNum'.$x] != ''){
  				$datatelres=array("num_tel" => $this->request->data['telephoneNum'.$x],
  							"reservation_id" => $reservation->id);
  				$restel = $this->Reservationtelephone->newEntity($datatelres);
  				$this->Reservationtelephone->save($restel);
  			}
  		}
  		/** Fin enregistrement tel **/
      /*** ADD GOOGLE CALENDAR ***/
      $this->loadModel("Annonces");
		  $annonce=$this->Annonces->get($this->request->data["annonce_id"]);
      if(PROD_ON == 1){
        if($annonce->id_gestionnaires != 0){
          $gest_mail = $this->Gestionnaires->get($annonce->id_gestionnaires);
          if($gest_mail->googlecalendar_id != "") $calendarID = $gest_mail->googlecalendar_id;
          else $calendarID = 'admin@alpissime.com';
        }else{
          $calendarID = 'admin@alpissime.com';
        }
        $googleCalendar = new GoogleCalendarController();
        $event_id = $googleCalendar->googlecalendarinsert($reservation, $calendarID);
        $dataEvent=array("id_googlecalendar" => $event_id);
        $reservation = $this->Reservations->patchEntity($reservation, $dataEvent);
        $this->Reservations->save($reservation);
      }
      /*** END ADD GOOGLE CALENDAR ***/
  		$dispoID = $this->retournerDisposID($this->request->data["sel"],$this->request->data["annonce_id"]);
  		/** MANIPULATION DES PERIODES DISPOS **/
  		$this->loadModel("Dispos");
  		$data = array();
  		$periodes = explode("-", $dispoID);
  		$evit = '';
  		if(count($periodes) == 1){
  			$dispo=$this->Dispos->get($periodes[0]);
  			if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($perid[0])) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) == new Date($perid[1])))
  			{
  				/** METTRE A JOUR LA PERIODE DISPONIBLE **/
  				$nbrDiffNew = (new Date($perid[0]))->diff(new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')))->days;
  				$nbrDiffAjout = (new Date($perid[1]))->diff(new Date($perid[0]))->days;
  				$nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;
  				if($dispo->prix_jour == 0 && $dispo->prix != 0 ){
  					$data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
  					$dataAjout["prix_jour"] = $data['prix_jour'];
  					$data['prix'] = $data['prix_jour'] * $nbrDiffNew;
  					$dataAjout["prix"] = $data['prix_jour'] * $nbrDiffAjout;
  				}else{
  					$dataAjout["prix_jour"] = $dispo->prix_jour;
  					$data['prix'] = $dispo->prix_jour * $nbrDiffNew;
  					$dataAjout["prix"] = $dispo->prix_jour * $nbrDiffAjout;
  				}
  				if($dispo->promo_jour == 0 && $dispo->promo_px != 0 ){
  					$data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
  					$dataAjout["promo_jour"] = $data['promo_jour'];
  					$data['promo_px'] = $data['prix_jour'] * $nbrDiffNew;
  					$dataAjout["promo_px"] = $data['prix_jour'] * $nbrDiffAjout;
  				}else if($dispo->promo_yn == 1){
  					$dataAjout["promo_jour"] = $dispo->promo_jour;
  					$data['promo_px'] = $dispo->promo_jour * $nbrDiffNew;
  					$dataAjout["promo_px"] = $dispo->promo_jour * $nbrDiffAjout;
  				}else{
  					$dataAjout["promo_jour"] = $dispo->promo_jour;
  					$dataAjout["promo_px"] = $dispo->promo_px;
  				}
  				$data["updated_at"] = $this->toDate(date('d-m-Y'));
  				$data["fin_at"] = $this->toDate(new Date($perid[0]));
  				$dispoModif = $this->Dispos->patchEntity($dispo, $data);
          $this->Dispos->save($dispoModif);
          Log::write('info', 'Manager Creation Reservation (dispos 1) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);

  			}else if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) == new Date($perid[0])) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($perid[1])))
  			{
  				/** METTRE A JOUR LA PERIODE DISPONIBLE **/
  				$nbrDiffNew = (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')))->diff(new Date($perid[1]))->days;
  				$nbrDiffAjout = (new Date($perid[1]))->diff(new Date($perid[0]))->days;
  				$nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;
  				if($dispo->prix_jour == 0 && $dispo->prix != 0 ){
  					$data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
  					$dataAjout["prix_jour"] = $data['prix_jour'];
  					$data['prix'] = $data['prix_jour'] * $nbrDiffNew;
  					$dataAjout["prix"] = $data['prix_jour'] * $nbrDiffAjout;
  				}else{
  					$dataAjout["prix_jour"] = $dispo->prix_jour;
  					$data['prix'] = $dispo->prix_jour * $nbrDiffNew;
  					$dataAjout["prix"] = $dispo->prix_jour * $nbrDiffAjout;
  				}
  				if($dispo->promo_jour == 0 && $dispo->promo_px != 0 ){
  					$data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
  					$dataAjout["promo_jour"] = $data['promo_jour'];
  					$data['promo_px'] = $data['prix_jour'] * $nbrDiffNew;
  					$dataAjout["promo_px"] = $data['prix_jour'] * $nbrDiffAjout;
  				}else if($dispo->promo_yn == 1){
  					$dataAjout["promo_jour"] = $dispo->promo_jour;
  					$data['promo_px'] = $dispo->promo_jour * $nbrDiffNew;
  					$dataAjout["promo_px"] = $dispo->promo_jour * $nbrDiffAjout;
  				}else{
  					$dataAjout["promo_jour"] = $dispo->promo_jour;
  					$dataAjout["promo_px"] = $dispo->promo_px;
  				}
  				$data["updated_at"] = $this->toDate(date('d-m-Y'));
  				$data["dbt_at"] = $this->toDate(new Date($perid[1]));
  				$dispoModif = $this->Dispos->patchEntity($dispo, $data);
          $this->Dispos->save($dispoModif);
          Log::write('info', 'Manager Creation Reservation (dispos 2) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);

  			}else if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) == new Date($perid[0])) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) == new Date($perid[1])))
  			{
  				$evit = 'EviterAjout';
  				/** METTRE A JOUR LA PERIODE DISPONIBLE **/
  				$nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;
  				if($dispo->prix_jour == 0 && $dispo->prix != 0 ){
  					$data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
  				}
  				if($dispo->promo_jour == 0 && $dispo->promo_px != 0 ){
  					$data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
  				}
  				$data["updated_at"] = $this->toDate(date('d-m-Y'));
  				$data["statut"] = 90;
  				$data["utilisateur_id"] = $id_loc;
  				$data["reservation_id"] = $reservation->id;
  				$dispoModif = $this->Dispos->patchEntity($dispo, $data);
          $this->Dispos->save($dispoModif);
          Log::write('info', 'Manager Creation Reservation (dispos 3) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);

  			}else if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($perid[0])) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($perid[1])))
  			{
  				/** METTRE A JOUR LA PERIODE DISPONIBLE **/
  				$nbrDiffNew = (new Date($perid[0]))->diff(new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')))->days;
  				$nbrDiffAjout = (new Date($perid[1]))->diff(new Date($perid[0]))->days;
  				$nbrDiffNew2 = (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')))->diff(new Date($perid[1]))->days;
  				$nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;
  				$data2["fin_at"] = $this->toDate($dispo->fin_at);
  				$data2["promo_yn"] = $dispo->promo_yn;
  				$data2["nbr_jour"] = $dispo->nbr_jour;
  				if($dispo->prix_jour == 0 && $dispo->prix != 0 ){
  					$data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
  					$dataAjout["prix_jour"] = $data['prix_jour'];
  					$data2["prix_jour"] = $data['prix_jour'];
  					$data['prix'] = $data['prix_jour'] * $nbrDiffNew;
  					$data2['prix'] = $data['prix_jour'] * $nbrDiffNew2;
  					$dataAjout["prix"] = $data['prix_jour'] * $nbrDiffAjout;
  				}else{
  					$dataAjout["prix_jour"] = $dispo->prix_jour;
  					$data2["prix_jour"] = $dispo->prix_jour;
  					$data['prix'] = $dispo->prix_jour * $nbrDiffNew;
  					$data2['prix'] = $dispo->prix_jour * $nbrDiffNew2;
  					$dataAjout["prix"] = $dispo->prix_jour * $nbrDiffAjout;
  				}
  				if($dispo->promo_jour == 0 && $dispo->promo_px != 0 ){
  					$data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
  					$dataAjout["promo_jour"] = $data['promo_jour'];
  					$data2["promo_jour"] = $data['promo_jour'];
  					$data['promo_px'] = $data['prix_jour'] * $nbrDiffNew;
  					$data2['promo_px'] = $data['prix_jour'] * $nbrDiffNew2;
  					$dataAjout["promo_px"] = $data['prix_jour'] * $nbrDiffAjout;
  				}else if($dispo->promo_yn == 1){
  					$dataAjout["promo_jour"] = $dispo->promo_jour;
  					$data2["promo_jour"] = $dispo->promo_jour;
  					$data['promo_px'] = $dispo->promo_jour * $nbrDiffNew;
  					$data2['promo_px'] = $dispo->promo_jour * $nbrDiffNew2;
  					$dataAjout["promo_px"] = $dispo->promo_jour * $nbrDiffAjout;
  				}else{
  					$dataAjout["promo_jour"] = $dispo->promo_jour;
  					$data2["promo_jour"] = $dispo->promo_jour;
  					$dataAjout["promo_px"] = $dispo->promo_px;
  					$data2["promo_px"] = $dispo->promo_px;
  				}
  				$data["updated_at"] = $this->toDate(date('d-m-Y'));
  				$data["fin_at"] = $this->toDate(new Date($perid[0]));
  				$dispoModif = $this->Dispos->patchEntity($dispo, $data);
          $this->Dispos->save($dispoModif);
          Log::write('info', 'Manager Creation Reservation (dispos 4) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);

  				$data2["annonce_id"] = $this->request->data["annonce_id"];
  				$data2["created_at"] = $this->toDate(date('d-m-Y'));
  				$data2["updated_at"] = $this->toDate(date('d-m-Y'));
  				$data2["dbt_at"] = $this->toDate(new Date($perid[1]));
  				$data2["statut"] = 0;
  				$dispo2 = $this->Dispos->newEntity($data2);
          $this->Dispos->save($dispo2);
          Log::write('info', 'Manager Creation Reservation (dispos 5) : dispoID: '.$dispo2->id.'__debut: '.$dispo2->dbt_at.'__fin: '.$dispo2->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);

  			}
  			if($evit == ''){
  				/** AJOUTER LA PERIODE RESERVEE **/
  				$dataAjout["annonce_id"] = $this->request->data["annonce_id"];
  				$dataAjout["created_at"] = $this->toDate(date('d-m-Y'));
  				$dataAjout["updated_at"] = $this->toDate(date('d-m-Y'));
  				$dataAjout["dbt_at"] = $this->toDate(new Date($perid[0]));
  				$dataAjout["fin_at"] = $this->toDate(new Date($perid[1]));
  				$dataAjout["statut"] = 90;
  				$dataAjout["utilisateur_id"] = $id_loc;
  				$dataAjout["promo_yn"] = $dispo->promo_yn;
  				$dataAjout["reservation_id"] = $reservation->id;
  				$dataAjout["nbr_jour"] = $dispo->nbr_jour;
  				$dispoAjout = $this->Dispos->newEntity($dataAjout);
          $this->Dispos->save($dispoAjout);
          Log::write('info', 'Manager Creation Reservation (dispos 6) : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);

  			}

  		}else{
  			for($i=1;$i<count($periodes)-2;$i++){
  				$detailsperiode = explode("_", $periodes[$i]);
  				$disporeser=$this->Dispos->get($detailsperiode[0]);
  				$nbrDiff = $disporeser->fin_at->diff($disporeser->dbt_at)->days;
  				if($disporeser->prix_jour == 0 && $disporeser->prix != 0 ){
  					$data['prix_jour'] = round(($disporeser->prix/$nbrDiff), 2);
  				}
  				if($disporeser->promo_jour == 0 && $disporeser->promo_px != 0 ){
  					$data['promo_jour'] = round(($disporeser->promo_px/$nbrDiff), 2);
  				}
  				$data["updated_at"] = $this->toDate(date('d-m-Y'));
  				$data["statut"] = 90;
  				$data["utilisateur_id"] = $id_loc;
  				$data["reservation_id"] = $reservation->id;
  				$dispoModif = $this->Dispos->patchEntity($disporeser, $data);
          $this->Dispos->save($dispoModif);
          Log::write('info', 'Manager Creation Reservation (dispos 7) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);

  			}
  			/** TESTS SUR DEBUT **/
  			$detper = explode("_", $periodes[0]);
  			$disres=$this->Dispos->get($detper[0]);
  			if(new Date($disres->dbt_at->i18nFormat('dd-MM-yyyy')) == new Date($perid[0])){
  				$nbrDiff = $disres->fin_at->diff($disres->dbt_at)->days;
  				if($disres->prix_jour == 0 && $disres->prix != 0 ){
  					$datad['prix_jour'] = round(($disres->prix/$nbrDiff), 2);
  				}
  				if($disres->promo_jour == 0 && $disres->promo_px != 0 ){
  					$datad['promo_jour'] = round(($disres->promo_px/$nbrDiff), 2);
  				}
  				$datad["updated_at"] = $this->toDate(date('d-m-Y'));
  				$datad["statut"] = 90;
  				$datad["utilisateur_id"] = $id_loc;
  				$datad["reservation_id"] = $reservation->id;
  				$dispoModif = $this->Dispos->patchEntity($disres, $datad);
          $this->Dispos->save($dispoModif);
          Log::write('info', 'Manager Creation Reservation (dispos 8) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);

  			}else if(new Date($disres->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($perid[0])){
  				$date = Time::createFromFormat('d/m/Y', $detper[2]);
  				$dd = $date->format('d-m-Y');
  				$nbrDiffNew = (new Date($dd))->diff(new Date($perid[0]))->days;
  				$nbrDiffAjout = (new Date($perid[0]))->diff(new Date($disres->dbt_at->i18nFormat('dd-MM-yyyy')))->days;
  				$nbrDiff = $disres->fin_at->diff($disres->dbt_at)->days;
  				if($disres->prix_jour == 0 && $disres->prix != 0 ){
  					$datadd['prix_jour'] = round(($disres->prix/$nbrDiff), 2);
  					$dataAjout["prix_jour"] = $datadd['prix_jour'];
  					$datadd['prix'] = $datadd['prix_jour'] * $nbrDiffNew;
  					$dataAjout["prix"] = $datadd['prix_jour'] * $nbrDiffAjout;
  				}else{
  					$dataAjout["prix_jour"] = $disres->prix_jour;
  					$datadd['prix'] = $disres->prix_jour * $nbrDiffNew;
  					$dataAjout["prix"] = $disres->prix_jour * $nbrDiffAjout;
  				}
  				if($disres->promo_jour == 0 && $disres->promo_px != 0 ){
  					$datadd['promo_jour'] = round(($disres->promo_px/$nbrDiff), 2);
  					$dataAjout["promo_jour"] = $datadd['promo_jour'];
  					$datadd['promo_px'] = $datadd['prix_jour'] * $nbrDiffNew;
  					$dataAjout["promo_px"] = $datadd['prix_jour'] * $nbrDiffAjout;
  				}else if($disres->promo_yn == 1){
  					$dataAjout["promo_jour"] = $disres->promo_jour;
  					$datadd['promo_px'] = $disres->promo_jour * $nbrDiffNew;
  					$dataAjout["promo_px"] = $disres->promo_jour * $nbrDiffAjout;
  				}else{
  					$dataAjout["promo_jour"] = $disres->promo_jour;
  					$dataAjout["promo_px"] = $disres->promo_px;
  				}
  				$datadd["updated_at"] = $this->toDate(date('d-m-Y'));
  				$datadd["dbt_at"] = $this->toDate(new Date($perid[0]));
  				$dataAjout["annonce_id"] = $this->request->data["annonce_id"];
  				$dataAjout["created_at"] = $this->toDate(date('d-m-Y'));
  				$dataAjout["updated_at"] = $this->toDate(date('d-m-Y'));
  				$dataAjout["dbt_at"] = $this->toDate($disres->dbt_at);
  				$dataAjout["fin_at"] = $this->toDate(new Date($perid[0]));
  				$dataAjout["statut"] = 0;
  				$datadd["statut"] = 90;
  				$datadd["utilisateur_id"] = $id_loc;
  				$dataAjout["promo_yn"] = $disres->promo_yn;
  				$datadd["reservation_id"] = $reservation->id;
  				$dataAjout["nbr_jour"] = $disres->nbr_jour;
  				$dispoAjout = $this->Dispos->newEntity($dataAjout);
          $this->Dispos->save($dispoAjout);
          Log::write('info', 'Manager Creation Reservation (dispos 9) : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);

  				$dispoModif = $this->Dispos->patchEntity($disres, $datadd);
          $this->Dispos->save($dispoModif);
          Log::write('info', 'Manager Creation Reservation (dispos 10) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);
  			}
  			/** TESTS SUR FIN **/
  			$detper = explode("_", $periodes[count($periodes)-2]);
  			$disres=$this->Dispos->get($detper[0]);
  			if(new Date($disres->fin_at->i18nFormat('dd-MM-yyyy')) == new Date($perid[1])){
  				$nbrDiff = $disres->fin_at->diff($disres->dbt_at)->days;
  				if($disres->prix_jour == 0 && $disres->prix != 0 ){
  					$datad2['prix_jour'] = round(($disres->prix/$nbrDiff), 2);
  				}
  				if($disres->promo_jour == 0 && $disres->promo_px != 0 ){
  					$datad2['promo_jour'] = round(($disres->promo_px/$nbrDiff), 2);
  				}
  				$datad2["updated_at"] = $this->toDate(date('d-m-Y'));
  				$datad2["statut"] = 90;
  				$datad2["utilisateur_id"] = $id_loc;
  				$datad2["reservation_id"] = $reservation->id;
  				$dispoModif = $this->Dispos->patchEntity($disres, $datad2);
          $this->Dispos->save($dispoModif);
          Log::write('info', 'Manager Creation Reservation (dispos 11) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);

  			}else if(new Date($disres->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($perid[1])){
  				$date = Time::createFromFormat('d/m/Y', $detper[1]);
  				$dd = $date->format('d-m-Y');
  				$nbrDiffNew = (new Date($perid[1]))->diff(new Date($dd))->days;
  				$nbrDiffAjout = (new Date($disres->fin_at->i18nFormat('dd-MM-yyyy')))->diff(new Date($perid[1]))->days;
  				$nbrDiff = $disres->fin_at->diff($disres->dbt_at)->days;
  				if($disres->prix_jour == 0 && $disres->prix != 0 ){
  					$datadd2['prix_jour'] = round(($disres->prix/$nbrDiff), 2);
  					$dataAjoutd2["prix_jour"] = $datadd2['prix_jour'];
  					$datadd2['prix'] = $datadd2['prix_jour'] * $nbrDiffNew;
  					$dataAjoutd2["prix"] = $datadd2['prix_jour'] * $nbrDiffAjout;
  				}else{
  					$dataAjoutd2["prix_jour"] = $disres->prix_jour;
  					$datadd2['prix'] = $disres->prix_jour * $nbrDiffNew;
  					$dataAjoutd2["prix"] = $disres->prix_jour * $nbrDiffAjout;
  				}
  				if($disres->promo_jour == 0 && $disres->promo_px != 0 ){
  					$datadd2['promo_jour'] = round(($disres->promo_px/$nbrDiff), 2);
  					$dataAjoutd2["promo_jour"] = $datadd2['promo_jour'];
  					$datadd2['promo_px'] = $datadd2['prix_jour'] * $nbrDiffNew;
  					$dataAjoutd2["promo_px"] = $datadd2['prix_jour'] * $nbrDiffAjout;
  				}else if($disres->promo_yn == 1){
  					$dataAjoutd2["promo_jour"] = $disres->promo_jour;
  					$datadd2['promo_px'] = $disres->promo_jour * $nbrDiffNew;
  					$dataAjoutd2["promo_px"] = $disres->promo_jour * $nbrDiffAjout;
  				}else{
  					$dataAjoutd2["promo_jour"] = $disres->promo_jour;
  					$dataAjoutd2["promo_px"] = $disres->promo_px;
  				}
  				$datadd2["updated_at"] = $this->toDate(date('d-m-Y'));
  				$datadd2["fin_at"] = $this->toDate(new Date($perid[1]));
  				$dataAjoutd2["annonce_id"] = $this->request->data["annonce_id"];
  				$dataAjoutd2["created_at"] = $this->toDate(date('d-m-Y'));
  				$dataAjoutd2["updated_at"] = $this->toDate(date('d-m-Y'));
  				$dataAjoutd2["dbt_at"] = $this->toDate(new Date($perid[1]));
  				$dataAjoutd2["fin_at"] = $this->toDate($disres->fin_at);
  				$dataAjoutd2["statut"] = 0;
  				$datadd2["statut"] = 90;
  				$datadd2["utilisateur_id"] = $id_loc;
  				$dataAjoutd2["promo_yn"] = $disres->promo_yn;
  				$datadd2["reservation_id"] = $reservation->id;
  				$dataAjoutd2["nbr_jour"] = $disres->nbr_jour;
  				$dispoAjout = $this->Dispos->newEntity($dataAjoutd2);
          $this->Dispos->save($dispoAjout);
          Log::write('info', 'Manager Creation Reservation (dispos 12) : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);

  				$dispoModif = $this->Dispos->patchEntity($disres, $datadd2);
          $this->Dispos->save($dispoModif);
          Log::write('info', 'Manager Creation Reservation (dispos 13) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__gestionnaireID: '.$gestionnaire['G']['id']);
  			}
  		}
      /** FIN **/
      $this->loadModel("Annonces");
      $info_loc = $this->Utilisateurs->get($id_loc);
      $info_ann = $this->Annonces->get($reservation->annonce_id);
      Log::write('info', 'test1');

      // Ajout variable {{imageannonce}}
      $this->loadModel("Photos");
      $photo = $this->Photos->find()->where(['annonce_id' => $reservation->annonce_id])->order(['numero ASC'])->first();
      // $nomImg = "vignette-".$photo->annonce_id."-".$photo->numero;

      $annonce=$this->Annonces->get($reservation->annonce_id, ['contain' => ['Lieugeos','Villages']]);
      $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
      $village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
      $village_nom = str_replace(" – ", "-", $village_nom);
      $village_nom = str_replace(" ", "-", $village_nom);
      $nomImgG = $photo->titre;

      $urlimage1 = 'https://www.alpissime.com/images_ann/'.$reservation->annonce_id.'/'.$nomImgG;
      Log::write('info', 'test2');
      //Ajout variable {{description}} (160 premiers caractères de la description de l'annonce et finir par "..." si la description contient plus de 160 caractères)
      $desc160 = substr($info_ann->description, 0, 160);
      if(strlen($info_ann->description) > 160) $desc160 = $desc160." ...";
          
      $this->loadModel('BlocServicesMails');
      $bloc_services_mail_first = $this->BlocServicesMails->find()->where(["(liste_id_station LIKE '$info_ann->lieugeo_id;%' OR liste_id_station LIKE '%;$info_ann->lieugeo_id;%')"])->first();

      $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
      $lannonce = $this->string2url($annonce["titre"]);
      $hrefDetailAnn = 'station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;
      
      $datamustache = array('bloc_services_mail' => $bloc_services_mail_first->bloc_services_mail, 'bloc_services_mail_en' => $bloc_services_mail_first->bloc_services_mail_en, 'nomprop' => $info_prop->nom_famille, 'prenomprop' => $info_prop->prenom, 'prenom' => $utilisateur->prenom, 'nom' => $utilisateur->nom_famille, 'tel' => $utilisateur->portable, 'email' => $utilisateur->email, 'annonce' => $reservation->annonce_id, 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'nbrEnfant' => $reservation->nb_enfants, 'nbrAdulte' => $reservation->nb_adultes, 'login' => $this->request->data['email'], 'password' => $mdp_en_clair, 'blockreduction' => $this->request->data['creationCompteManuelleHidden'], 'imageannonce' => $urlimage1, 'description' => $desc160,'annonceURL' => "https://www.alpissime.com/".$hrefDetailAnn);
      
      $this->loadModel('BlocMailGestionnaires');
      // $this->loadModel('Annoncegestionnaires');
      // $anngest = $this->Annoncegestionnaires->find()->where(['id_annonces' =>$this->request->data["annonceid"] ])->first();
      $blocsinfos = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => $anngest->id_gestionnaires])->first();
      $datamustachetwo = array('bloc_services_mail' => $bloc_services_mail_first->bloc_services_mail, 'bloc_services_mail_en' => $bloc_services_mail_first->bloc_services_mail_en, 'bloc_info_arrivee' => $blocsinfos->bloc_info_arrivee, 'bloc_info_arrivee_en' => $blocsinfos->bloc_info_arrivee_en, 'bloc_info_depart' => $blocsinfos->bloc_info_depart, 'bloc_info_depart_en' => $blocsinfos->bloc_info_depart_en, 'bloc_info_horaires' => $blocsinfos->bloc_info_horaires, 'bloc_info_horaires_en' => $blocsinfos->bloc_info_horaires_en, 'nomprop' => $info_prop->nom_famille, 'prenomprop' => $info_prop->prenom, 'prenom' => $utilisateur->prenom, 'nom' => $utilisateur->nom_famille, 'annonce' => $reservation->annonce_id, 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'blockreduction' => $this->request->data['creationReservationLocManuelleHidden']);
      Log::write('info', 'test3');                 
			//envoi compte locataire
			if($nouveau==1){
                            // #####################################################
                            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $info_loc,'textEmail'=>'creationCompteManuelle',
                                                                     'data'=>$datamustache,'template'=>'creationCompteManuelle','viewVars'=>'creationCompteManuelle','noReply'=>false
                                                                    ]);
                            $this->eventManager()->dispatch($event);
                            // #####################################################
      }
      Log::write('info', 'test4');
			$this->loadModel("Lieugeos");
			$lieugeo=$this->Lieugeos->get($info_ann->lieugeo_id);
                        // #####################################################
                        $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $info_prop,'textEmail'=>'creationReservationManuelle',
                                                                 'data'=>$datamustache,'template'=>'creationReservationManuelle','viewVars'=>'creationReservationManuelle','noReply'=>false
                                                                ]);
                        $this->eventManager()->dispatch($event);
                        // #####################################################
                        
                        // #####################################################
                        $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $info_loc,'textEmail'=>'creationReservationLocManuelle',
                                                                 'data'=>$datamustachetwo,'template'=>'creationReservationLocManuelle','viewVars'=>'creationReservationLocManuelle','noReply'=>false
                                                                ]);
                        $this->eventManager()->dispatch($event);
                        // #####################################################

                        // #####################################################
                        //Send to admin
                        $event = new Event('Email.send', $this, ['from'=>$info_prop->email,'to' => $mail->val,'textEmail'=>'creationReservationManuelleAdm',
                          'data'=>$datamustache,'template'=>'creationReservationLocManuelle','viewVars'=>'creationReservationLocManuelle','noReply'=>false
                        ]);
                        $this->eventManager()->dispatch($event);
                        //Send to gestionnaire
                        if($info_ann->id_gestionnaires != 0){
                        $this->loadModel("Gestionnaires");
                        $gestio = $this->Gestionnaires->get($info_ann->id_gestionnaires);
                        $event = new Event('Email.send', $this, ['from'=>$info_prop->email,'to' => $gestio->email,'textEmail'=>'creationReservationManuelleAdm',
                                            'data'=>$datamustache,'template'=>'creationReservationLocManuelle','viewVars'=>'creationReservationLocManuelle','noReply'=>false
                                          ]);
                        $this->eventManager()->dispatch($event);
                        }
                        // #####################################################

      $session->write("Reseservation.manuelle","addReservation");
      Log::write('info', 'test5');
      /**** MODIFICATION ADRESSE LIVRAISON SUR BOUTIQUE ****/
      // // Nouveau code Magento 2
      // //**** informations a utiliser toujours ********************//
			// 		$magentoURL = BOUTIQUE_ALPISSIME;
			// 		$data = array("username" => "API.ACCESS", "password" => "86>;];wzO+Q#");
			// 		$data_string = json_encode($data);
			// 		$ch = curl_init($magentoURL."index.php/rest/V1/integration/admin/token");
			// 		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			// 		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// 		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Content-Length: ".strlen($data_string)));
			// 		$token = curl_exec($ch);
			// 		$token= json_decode($token);
			// 		$headers = array("Authorization: Bearer ".$token);
			// 		//************************************************************//
			// 		// **** mettre l'email du client depuis le site location **********//
      //     $customer_email = $utilisateur->email; // email du client
      //     if($utilisateur->prenom == '') $customer_fname = "_";
      //     else $customer_fname = $utilisateur->prenom ; // prenom du client
      //     $customer_lname = $utilisateur->nom_famille; // Nom du client
      //     $password = $this->request->data['mdpenclair']; // mot de passe
      //     if($utilisateur->nature == "CLT") $group_id = '10';
      //     else $group_id = '9';

			// 		$requestUrl = $magentoURL.'index.php/rest/V1/customers/search?searchCriteria[filter_groups][0][filters][0][field]=email&searchCriteria[filter_groups][0][filters][0][value]=%25'.$customerEmail.'%25&searchCriteria[filter_groups][0][filters][0][condition_type]=like';
			// 		$ch = curl_init($requestUrl);
			// 		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// 		$result = curl_exec($ch);
			// 		$result = json_decode($result, true);
			// 		// print_r($result);
					
			// 		//*********** Mise a jour du mot de passe du client et eventuellement son nom ...
			// 		// si le client existe (email) dans la boutique ********//
					
			// 		$reservationDetail = $this->Reservations->getReservationById($reservation->id);
			// 		$this->loadModel('Frvilles');
			// 		$villeLivraison = $this->Frvilles->get($reservationDetail['annonce']['ville']);
			// 		// $regiontab = $this->getRegType();
			// 		$this->loadModel('Pays');
			// 		$payscode = $this->Pays->get($reservationDetail['annonce']["pays"]);
			// 		$this->loadModel('Residences');
			// 		$residence = $this->Residences->get($reservationDetail['annonce']['batiment']);
			// 		$this->loadModel('Lieugeos');
			// 		$station = $this->Lieugeos->get($reservationDetail['annonce']['lieugeo_id']);
					
			// 		// $villeBilling = $this->Frvilles->get($reservationDetail['utilisateur']['ville']);
			// 		// $payscodeBilling = $this->Pays->get($reservationDetail['utilisateur']["pays"]);
					
			// 		if($reservationDetail['utilisateur']['adresse'] == "") $reservationDetail['utilisateur']['adresse'] = $station->name;
			// 		// $resultatregionbilling = $this->getRegType($reservationDetail['utilisateur']['region']);
			// 		$resultatregionshipping = $this->getRegType($reservationDetail['annonce']['region']);
          
      //     $this->loadModel('Villages');
      //     $village = $this->Villages->get($reservationDetail['annonce']['village']);
      //     $adressefacture = $reservationDetail['annonce']['num_app'].", ".$residence->name.", ".$village->name.", ".$station->name;

			// 		if ($result["items"]){
			// 			$id = $result['items'][0]['id'];
			// 			$customerData = [
			// 				'customer' => [
			// 					'id' => $id,
			// 					"group_id" => $group_id,
			// 					"email" => $customerEmail,
			// 					"firstname" => $customer_fname,
			// 					"lastname" => $customer_lname,
			// 					"storeId" => 1,
			// 					"websiteId" => 1,
			// 					"addresses" => [
			// 						"0" => [
			// 							"customer_id" => $id,
			// 							"region" => [
			// 								"region_code" => $resultatregionshipping[2], //OU TROUVER!!???
			// 								"region" => $resultatregionshipping[4], // ??????
			// 								"region_id" => $resultatregionshipping[0] // ???????
			// 									],
			// 							"region_id" => $resultatregionshipping[0], // ??????
			// 							"country_id" => $payscode->code_pays,
			// 							"street" => [
			// 								"0" => $adressefacture
			// 							],
			// 							"telephone" => $reservationDetail['utilisateur']['portable'],
			// 							"postcode" => $reservationDetail['annonce']['code_postal'],
			// 							"city" => $villeLivraison->name,
			// 							"firstname" => $customer_fname,
			// 							"lastname" => $customer_lname,
			// 							"default_shipping" => '1'
			// 						],
			// 					],
			// 				],
			// 				"password" => $password
			// 			];

			// 			$link = $magentoURL.'index.php/rest/V1/customers/'.$id;
			// 			$ch = curl_init($link);
			// 			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			// 			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			// 			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// 			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
			// 			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			// 			$result = curl_exec($ch);

			// 			// echo '<pre>';print_r($result);  //Tu peux enlever
			// 			// exit;
			// 		} else {
			// 			//******** créer le client ***********//
			// 			$customerData = [
			// 				'customer' => [
			// 					"group_id" => $group_id,
			// 					"email" => $customerEmail,
			// 					"firstname" => $customer_fname,
			// 					"lastname" => $customer_lname,
			// 					"storeId" => 1,
			// 					"websiteId" => 1,
			// 					"addresses" => [
			// 						"0" => [
			// 							"customer_id" => $id,
			// 							"region" => [
			// 								"region_code" => $resultatregionshipping[2], //OU TROUVER!!???
			// 								"region" => $resultatregionshipping[4], // ??????
			// 								"region_id" => $resultatregionshipping[0] // ???????
			// 									],
			// 							"region_id" => $resultatregionshipping[0], // ?????
			// 							"country_id" => $payscode->code_pays,
			// 							"street" => [
			// 								"0" => $adressefacture
			// 							],
			// 							"telephone" => $reservationDetail['utilisateur']['portable'],
			// 							"postcode" => $reservationDetail['annonce']['code_postal'],
			// 							"city" => $villeLivraison->name,
			// 							"firstname" => $customer_fname,
			// 							"lastname" => $customer_lname,
			// 							"default_shipping" => '1'
			// 						],
			// 					],
			// 				],
			// 				"password" => $password
			// 			];
			// 			// print_r($customerData);
			// 			// print_r("######");
						
			// 			$ch = curl_init($magentoURL."index.php/rest/V1/customers");
			// 			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			// 			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			// 			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// 			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
			// 			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			// 			$result = curl_exec($ch);

			// 			// echo '<pre>';print_r($result);          //Tu peux enlever
			// 			// exit;
			// 		}
			// 		// exit;
			// 		curl_close($ch);
      /**** END MODIFICATION ADRESSE LIVRAISON SUR BOUTIQUE ****/
      Log::write('info', 'test8');

			return $this->redirect(['action' => 'location']);
		}
		$this->Flash->success(__('Cette semaine est déja occupée, merci de vérifier votre planning et vos disponibilités', true));
	 }
    $a_contrat=$this->Annonces->find();
    $a_contrat->join([
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'INNER',
          'conditions' => ['U.id=Annonces.proprietaire_id'],
        ],
        'Contrat' => [
          'table' => 'contrats',
          'type' => 'inner',
          'conditions' => ['Contrat.annonce_id=Annonces.id','Contrat.visible'=>1]
        ],
        'R' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'Annonces.batiment=R.id',
        ]
    	])
      ->select(['Annonces.id','Annonces.num_app','Annonces.surface','U.id','U.prenom','U.nom_famille','R.name'])
      ->where(['(Annonces.contrat = 1 OR Annonces.mise_relation = 1)', 'Annonces.id_gestionnaires' => $gestionnaire['G']['id']]);
    	$this->set('annonce',$a_contrat);
      $prop = [];
      foreach ($a_contrat as $ann) {
        $prop[$ann->id] = [];
        $prop[$ann->id]['nom'] = $ann['U']['nom_famille'];
        $prop[$ann->id]['prenom'] = $ann['U']['prenom'];
      }
      $this->set('annonceProp',$prop);
      $mail = [];
      $this->loadModel("Modelmailsysteme");
      $textEmail = $this->Modelmailsysteme->find('all');
      foreach ($textEmail as $key => $value) {
        $mail[$value->titre] = $value->txtmail;
      }
      $this->set("textmail",$mail);
      $this->loadModel("Pays");
  	  $Pays=$this->Pays->find('all');
  		$a_pay=array();
  		$payNum=array();
  		$a_pay[0] = '';
  		foreach($Pays as $pay){
  			$a_pay[$pay->id_pays]=$pay->fr;
  			$payNum[$pay->id_pays]=$pay->code_pays;
  		}
  		$this->set("Pays", $a_pay);

  		$this->set("paysNum", $payNum);
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
	function getreservation($id=null){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel("Annonces");
		$this->loadModel("Dispos");
		$a_annonce=array();
		$annonce=$this->Annonces->get($id);
		$i=0;
	  $a_annonce[$i]['num_app']=$annonce->num_app;
		$a_annonce[$i]['id']=$annonce->id;
		$a_annonce[$i]['titre']=$annonce->titre;
		$packs=$this->Dispos->find('all',['conditions'=>['Dispos.annonce_id'=>$annonce->id,"Dispos.dbt_at >= '".date("Y-m-d")."'"]]);
		if(!empty($packs->first())){
			$j=0;
			$packs=$this->Dispos->find('all',['conditions'=>['Dispos.annonce_id'=>$annonce->id,"Dispos.dbt_at >= '".date("Y-m-d")."'"]]);
			foreach($packs as $pak){
				$a_annonce[$i]['Dispo'][$j]['id']=$pak->id;
				$a_annonce[$i]['Dispo'][$j]['statut']=$pak->statut;
				$a_annonce[$i]['Dispo'][$j]['dbt_at']=$pak->dbt_at;
				$a_annonce[$i]['Dispo'][$j]['fin_at']=$pak->fin_at;
				$a_annonce[$i]['Dispo'][$j]['prix']=$pak->prix;
				$a_annonce[$i]['Dispo'][$j]['promo_px']=$pak->promo_px;
				$j++;
			}
		}
		$i++;
		$this->set("l_disposstatuts",['0'=>'Libre','50'=>'Option','90'=>'Réservé']);
    $this->set('annonce', $a_annonce);
	}
  /**
	 *
	 **/
	function arraytaxe($id=null){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel("Taxes");
		$this->loadModel("Reservations");
		$debut=$this->request->data['vDebut'];
		$s = strtotime( $this->request->data['vFin'])-strtotime($debut);
		$d = intval($s/86400);
		$a_res=array();
		for($i=0;$i<$d;$i++){
			if($i==0) $date=date("Y-m-d", strtotime($debut));
			else $date=date("Y-m-d", strtotime("$debut +$i days"));
			$res=$this->Reservations->find()
				->join([
					'A' => [
						'table' => 'annonces',
						'type' => 'inner',
						'conditions' => ['Reservations.annonce_id=A.id','A.visible=1'],
					],
					// 'GA' => [
					// 	'table' => 'annoncegestionnaires',
					// 	'type' => 'inner',
					// 	'conditions' => 'GA.id_annonces=A.id',
					// ],
				])
				->select(['Reservations.id','Reservations.nb_adultes','A.id_ville','A.nb_etoiles','A.id_gestionnaires'])
				->where(['A.id_gestionnaires'=>$id,"Reservations.dbt_at='$date'","Reservations.taxe=1"]);
			$val_taxe=0;
			if(!empty($res)){
				foreach($res as $tx){
					$stx=$this->Taxes->find('all',['conditions'=>['Taxes.id_villes'=>$tx['A']['id_ville'],'Taxes.nb_etoile'=>$tx['A']['nb_etoiles']]]);
					if($stx->first()){
						$stx=$stx->first();
						$val_taxe=$val_taxe+($stx->valeur*$tx->nb_adultes);
					}
				}
			}
			$a_res[$date]=$val_taxe;
		}
		$this->set('a_taxe',$a_res);
	}
  /**
	 *
	 **/
	function getinfo($id_prop,$id_ann){
		$session = $this->request->session();
		$this->getpdf($id_prop,$id_ann,$this->request->data['vType'],$this->request->data['vComment'],$this->request->data['vDate']);
		$msg="";
		switch($this->request->data['vType']){
			case "2":
				$url="gestion de clé";
				$msg="de gestion de clé";
			break;
			case "1":
				$url="contrat technique";
				$msg="technique";
			break;
      case "4":
				$url="contrat technique";
				$msg="technique";
			break;
			case "3":
				$url="mise en relation";
				$msg="de mise en relation";
			break;
      case "5":
        $url="commercialisation";
        $msg="de commercialisation";
      break;
		}
                $this->loadModel("Utilisateurs");
                $utilisateur = $this->Utilisateurs->get($id_prop);

  	$gestionnaire=$session->read('Gestionnaire.info');
        
        $datamustache = array('nomprop' => $utilisateur->nom_famille, 'prenomprop' => $utilisateur->prenom, 'contrat' => $msg, 'gestionnaire' => $gestionnaire['G']['name']);
        
  	$this->loadModel("Registres");
  	$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
  	$mail=$mails->first();
        // #####################################################
        $user=$this->Utilisateurs->find('all')->where(['email'=>$this->request->data['vMail']])->first();
        if($user==null)$user=$this->request->data['vMail'];
        $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $user,'textEmail'=>'creationContrat',
                                                 'data'=>$datamustache,'template'=>'creationContrat','viewVars'=>'creationContrat','noReply'=>false,
                                                 'attachments'=>['contrat.pdf' => ROOT.DS.'webroot'.DS.'contrat'.DS."CT_".$id_prop."_".$id_ann.'.pdf']
                                                ]);
        $this->eventManager()->dispatch($event);
        // #####################################################
		die();
	}
  /**
	 *
	 **/
  function generatepdftaxetableau(){
    set_time_limit(300);
    $this->loadModel("Utilisateurs");
    $this->loadModel("Reservations");
    $session = $this->request->session();
    $g=$session->read('Gestionnaire.info');
    if(empty($this->request->data['vTaxegere'])) $this->request->data['vTaxegere']=2;
    if(empty($this->request->data['vRechercheinput'])) $this->request->data['vRechercheinput']="_";
    $this->getpdftaxetableau($this->request->data['vDatedebut'],$this->request->data['vDatefin'],$this->request->data['vTaxegere'],$this->request->data['vRechercheinput']);
    echo "TaxeDeSejourTableau_".$this->request->data['vDatedebut']."_".$this->request->data['vDatefin']."_".$this->request->data['vRechercheinput'].'.pdf';
    die();
  }
  /**
	 *
	 **/
  function generatepdftaxe(){
    set_time_limit(300);
    $this->loadModel("Utilisateurs");
    $this->loadModel("Reservations");
    $session = $this->request->session();
    $g=$session->read('Gestionnaire.info');
    $utilisateurs=explode("||",$this->request->data['vPropid']);
    foreach ($utilisateurs as $id) {
      $util = $this->Utilisateurs->get($id);
      $output=$this->Reservations->get_array_taxe_de_sejour_recherche_pdf_count($g['G']['id'], $this->request->data['vDatedebut'], $this->request->data['vDatefin'], $util->id);
      if(!empty($output->nbr)){
        $this->getpdftaxe($this->request->data['vDatedebut'],$this->request->data['vDatefin'],$util->id);
        /* Envoyer Email */
        $datamustache = array('datedebu' => $this->request->data['vDatedebut'], 'datefin' => $this->request->data['vDatefin']);
        
        $this->loadModel("Registres");
  			$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
  			$mail=$mails->first();
                        // #####################################################
                        $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $util,'textEmail'=>'taxeSejour',
                                                                 'data'=>$datamustache,'template'=>'taxeSejour','viewVars'=>'taxeSejour','noReply'=>false,
                                                                 'attachments'=>[
                                                                                'Rapport_taxe_de_sejour.pdf'=> [
                                                                                    'file'=> ROOT.DS.'webroot'.DS.'taxesejour'.DS."TaxeDeSejour_".$this->request->data['vDatedebut']."_".$this->request->data['vDatefin']."_".$util->id.'.pdf',
                                                                                    'mimetype'=>'application/pdf',
                                                                                    'contentId'=>'123alpissime456'
                                                                                    ]
                                                                                  ]
                                                                ]);
                        $this->eventManager()->dispatch($event);
                        // #####################################################
          /* Fin Envoyer Email */
        echo "TaxeDeSejour_".$this->request->data['vDatedebut']."_".$this->request->data['vDatefin']."_".$util->id.'.pdf';
      }
    }
    die();
  }
  /**
	 *
	 **/
  function getpdftaxetableau($datedebut,$datefin,$taxegere,$recherche){
    // require_once(ROOT . DS . 'vendor' . DS . "MPDF" . DS . "mpdf.php");
    // $mpdf=new mPDF('c','A4','','',10,10,10,0,16,13);
    $mpdf = new \Mpdf\Mpdf();
    $session = $this->request->session();
    $g=$session->read('Gestionnaire.info');
    $url=SITE_ALPISSIME."/manager/arrivees/viewpdftaxetableau/".$datedebut."/".$datefin."/".$g['G']['id']."/".$taxegere."/".$recherche;
    $html=file_get_contents($url, false, $context);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;
    $mpdf->setAutoBottomMargin = 'stretch';
    $mpdf->SetFooter('{PAGENO}');
    $mpdf->WriteHTML($html,2);
    $mpdf->Output(ROOT.DS.'webroot'.DS.'taxesejour'.DS."TaxeDeSejourTableau_".$datedebut."_".$datefin."_".$recherche.'.pdf','F');
    $this->autoRender = false;
  }
  /**
	 *
	 **/
   function getpdftaxe($datedebut,$datefin,$utilid){
      // require_once(ROOT . DS . 'vendor' . DS . "MPDF" . DS . "mpdf.php");
      // $mpdf=new mPDF('c','A4','','',10,10,10,0,16,13);
      $mpdf = new \Mpdf\Mpdf();
      $session = $this->request->session();
      $g=$session->read('Gestionnaire.info');
      $url=SITE_ALPISSIME."/manager/arrivees/viewpdftaxe/".$datedebut."/".$datefin."/".$g['G']['id']."/".$utilid;
      $html=file_get_contents($url, false, $context);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->list_indent_first_level = 0;
      $mpdf->setAutoBottomMargin = 'stretch';
      $mpdf->SetFooter('{PAGENO}');
      $mpdf->WriteHTML($html,2);
      $mpdf->Output(ROOT.DS.'webroot'.DS.'taxesejour'.DS."TaxeDeSejour_".$datedebut."_".$datefin."_".$utilid.'.pdf','F');
      $this->autoRender = false;
  }
  /**
	 *
	 **/
  function viewpdftaxetableau($datedebut,$datefin,$idgest,$taxegere,$recherche){
    $this->viewBuilder()->layout(false);
    $this->loadModel("Gestionnaires");
		$gestionnaire=$this->Gestionnaires->get($idgest);
    $this->set("gestionnaire",$gestionnaire);
    $this->loadModel("Reservations");
    $output=$this->Reservations->get_array_taxe_de_sejour_recherche_pdf_tableau($idgest, $datedebut, $datefin, $taxegere, "");
    $this->set("listeTaxes", $output);
    $this->set("debutperiode",$datedebut);
    $this->set("finperiode",$datefin);
  }
  /**
	 *
	 **/
  function viewpdftaxe($datedebut,$datefin,$idgest,$idutil){
    $this->viewBuilder()->layout(false);
    $this->loadModel("Gestionnaires");
		$gestionnaire=$this->Gestionnaires->get($idgest);
    $this->set("gestionnaire",$gestionnaire);

    $this->loadModel("Utilisateurs");
    $proprietaire = $this->Utilisateurs->get($idutil);
    $this->set("proprietaire", $proprietaire);

    $this->loadModel("Reservations");
    $output=$this->Reservations->get_array_taxe_de_sejour_recherche_pdf($idgest, $datedebut, $datefin, $idutil);
    $this->set("listeTaxes", $output);

    $this->set("debutperiode",$datedebut);
    $this->set("finperiode",$datefin);
  }
  /**
	 *
	 **/
	function generatepdf($id_prop,$id_ann){
		$session = $this->request->session();
		$this->getpdf($id_prop,$id_ann,$this->request->data['vType'],$this->request->data['vComment'],$this->request->data['vDate']);
		$msg="";
		switch($this->request->data['vType']){
			case "2":
				$url="gestion de clé";
			break;
			case "1":
				$url="contrat technique";
			break;
      case "4":
				$url="contrat technique";
			break;
			case "3":
				$url="mise en relation";
			break;
		}
	  echo "CT_".$id_prop."_".$id_ann.'.pdf';
		die();
	}
  /**
	 *
	 **/
	protected function getpdf($id_prop,$id_ann,$type,$comment,$date){
			$session = $this->request->session();
      // require_once(ROOT . DS . 'vendor' . DS . "MPDF" . DS . "mpdf.php");
      // $mpdf=new mPDF('c','A4','','',10,10,10,0,16,13);
      $mpdf = new \Mpdf\Mpdf();
			$gestionnaire=$session->read('Gestionnaire.info');
			switch($type){
				case "2":
					$url=SITE_ALPISSIME."/manager/arrivees/viewpdf/".$id_prop."/".$id_ann."/".$gestionnaire['G']['id']."/".$date."/".base64_encode($comment);
				break;
				case "1":
					$url=SITE_ALPISSIME."/manager/arrivees/viewpdfmaint/".$id_prop."/".$id_ann."/".$gestionnaire['G']['id']."/".$date."/".base64_encode($comment);
				break;
        case "4":
					$url=SITE_ALPISSIME."/manager/arrivees/viewpdfmaint/".$id_prop."/".$id_ann."/".$gestionnaire['G']['id']."/".$date."/".base64_encode($comment);
				break;
				case "3":
					$url=SITE_ALPISSIME."/manager/arrivees/viewpdfrelation/".$id_prop."/".$id_ann."/".$gestionnaire['G']['id']."/".$date."/".base64_encode($comment);
				break;
        case "5":
					$url=SITE_ALPISSIME."/manager/arrivees/viewpdfcommercialisation/".$id_prop."/".$id_ann."/".$gestionnaire['G']['id']."/".$date."/".base64_encode($comment);
				break;
			}
      $html=file_get_contents($url);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->list_indent_first_level = 0;
      $mpdf->WriteHTML($html,2);
      $mpdf->Output(ROOT.DS.'webroot'.DS.'contrat'.DS."CT_".$id_prop."_".$id_ann.'.pdf');
  }
  /**
	 *
	 **/
	function viewpdf($id_prop,$id_ann,$id_gest,$date,$searcharray){
    $searcharray = unserialize($searcharray);
		$session = $this->request->session();
		$this->viewBuilder()->layout('ajax');
		$this->loadModel("Annonces");
		$this->loadModel("Gestionnaires");
    $this->loadModel("Contratypes");
		if(isset($id_gest)&&!empty($id_gest)){
			$gestionnaire=$this->Gestionnaires->get($id_gest);
		}else{
			$g=$session->read('Gestionnaire.info');
			$gestionnaire=$this->Gestionnaires->get($g['G']['id']);
		}
		$res=$this->Annonces->find()
				->join([
					'U' => [
						'table' => 'utilisateurs',
						'type' => 'inner',
						'conditions' => 'U.id=Annonces.proprietaire_id',
					],
					'R' => [
						'table' => 'residences',
						'type' => 'left',
						'conditions' => 'Annonces.batiment=R.id',
					],
				])
			->select(['Annonces.num_app','R.name','U.prenom','U.nom_famille','U.adresse','U.code_postal','U.ville','U.email'])
			->where(['U.id'=>$id_prop,"Annonces.id"=>$id_ann]);
		$this->set('contrat',$res->first());
		$this->set('gestionnaire',$gestionnaire);
		$this->set('comment',base64_decode($comment));
		$this->set('vdate',$date);
    
    $datamustache = [];
    $this->loadModel('Contratypes');
    $contratype = $this->Contratypes->get($searcharray['type']);
    //ajouter les valeurs des variables du contrat
    $this->loadModel('Optionscontrats');
    $this->loadModel('Variabledynamiques');
    $this->loadModel('Varoptioncontrats');
    $listabvardyn = [];
    $optioncontrat = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id = '=>0])->first();
    $listvariablecontrat = explode("////", $optioncontrat->variable_valeur);
    // $listvariablecontrat = explode(";", $contratype->variables_id);
    $varval = "";
    foreach ($listvariablecontrat as $key) {
      $valeurvar = explode(":", $key);
      $vardyn = $this->Variabledynamiques->find()->where(['id' => $valeurvar[0]])->first();
      if($vardyn){
        if($searcharray['variable'.$valeurvar[0]]){
          $datamustache[$vardyn->nom] = $searcharray['variable'.$valeurvar[0]];
        }
      } 
    }
    $listvariablecontrat2 = explode(";", $contratype->variables_id);
    foreach ($listvariablecontrat2 as $key) {
      $vardyn = $this->Variabledynamiques->find()->where(['id' => $key])->first();
      if($vardyn){
        if($searcharray['variable'.$key]){
          $datamustache[$vardyn->nom] = $searcharray['variable'.$key];
        }
      } 
    }
    $m = new Mustache_Engine;
    $textcontrat = $m->render($contratype->contrat, $datamustache); 

    //ajouter les valeurs variables option du contrat
    $datamustacheoption = [];
    $text_option = "";
    $taboption = array();
    $listoptioncontrat = explode(";", $contratype->options_id);    
    foreach ($listoptioncontrat as $keyopt) {
      $msgperiode = '';
      $vardynopt = $this->Optionscontrats->find()->where(['id' => $keyopt])->first();
      if($vardynopt){
        if($searcharray['option'.$keyopt]){
          $listvariableopt = explode(";", $vardynopt->variables_id);
          $varvalop = "";
          foreach ($listvariableopt as $value) {
            $vardynop = $this->Variabledynamiques->find()->where(['id' => $value])->first();
            if($vardynop){
              if($searcharray['optionvar'.$value.'_'.$keyopt]){
                array_push($taboption, $keyopt);
                $datamustacheoption[$vardynop->nom] = $searcharray['optionvar'.$value.'_'.$keyopt];
              }
              // Enregistrement des dates option
              if($value == 4){                
                $listedate = '';
                $today = new Date();
                for ($i=1; $i <= $searcharray['optionvar'.$value.'_'.$keyopt]; $i++) { 
                  $date = $today->year."-".$searcharray['mois_date_'.$i.'_'.$keyopt]."-".$searcharray['jour_date_'.$i.'_'.$keyopt];
                  if(new Date($date) < $today) $date = ($today->year+1)."-".$searcharray['mois_date_'.$i.'_'.$keyopt]."-".$searcharray['jour_date_'.$i.'_'.$keyopt];
                  $dateAffiche = (new Date($date))->i18nFormat('dd/MM/yyyy');
                  $listedate .= $dateAffiche.", ";
                }                
                if($listedate != '') $msgperiode = "<p>Pour le prix de ".$searcharray['optionvar5_'.$keyopt]." € (unitaire) prestations réalisées ".$searcharray['optionvar'.$value.'_'.$keyopt]." fois aux dates suivantes : ".$listedate."</p>";
              }   
            }                
          }
          $m2 = new Mustache_Engine;
          $textcontratoption = $m2->render($vardynopt->text, $datamustacheoption); 
          $text_option .= "<h4>".$vardynopt->titre."</h4>".$textcontratoption.$msgperiode."<br>";
        }
      }
      
      
    }
    

    if(!empty($taboption)) $anciennevaleur = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id != '=>0, 'option_id NOT IN '=>$taboption]);
    else $anciennevaleur = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id != '=>0]);
    foreach ($anciennevaleur as $keyopt) {
      $msgperiode = '';
      $vardynopt = $this->Optionscontrats->find()->where(['id' => $keyopt->option_id])->first();
      if($vardynopt){
        if($searcharray['option'.$keyopt->option_id]){
          $listvariableopt = explode(";", $vardynopt->variables_id);
          $varvalop = "";
          foreach ($listvariableopt as $value) {
            $vardynop = $this->Variabledynamiques->find()->where(['id' => $value])->first();
            if($vardynop){
              if($searcharray['optionvar'.$value.'_'.$keyopt->option_id]){
                $datamustacheoption[$vardynop->nom] = $searcharray['optionvar'.$value.'_'.$keyopt->option_id];
              }
              // Enregistrement des dates option
              if($value == 4){                
                $listedate = '';
                $today = new Date();
                for ($i=1; $i <= $searcharray['optionvar'.$value.'_'.$keyopt->option_id]; $i++) { 
                  $date = $today->year."-".$searcharray['mois_date_'.$i.'_'.$keyopt->option_id]."-".$searcharray['jour_date_'.$i.'_'.$keyopt->option_id];
                  if(new Date($date) < $today) $date = ($today->year+1)."-".$searcharray['mois_date_'.$i.'_'.$keyopt->option_id]."-".$searcharray['jour_date_'.$i.'_'.$keyopt->option_id];
                  $dateAffiche = (new Date($date))->i18nFormat('dd/MM/yyyy');
                  $listedate .= $dateAffiche.", ";
                }                
                if($listedate != '') $msgperiode = "<p>Pour le prix de ".$searcharray['optionvar5_'.$keyopt->option_id]." € (unitaire) prestations réalisées ".$searcharray['optionvar'.$value.'_'.$keyopt->option_id]." fois aux dates suivantes : ".$listedate."</p>";
              } 
            }                
          }
          $m2 = new Mustache_Engine;
          $textcontratoption = $m2->render($vardynopt->text, $datamustacheoption); 
          $text_option .= "<h4>".$vardynopt->titre."</h4>".$textcontratoption.$msgperiode."<br>";
        }
      }
      
    }

    $this->set('previewtext',$textcontrat.$text_option);
	}
  /**
	 *
	 **/
	function viewpdfrelation($id_prop,$id_ann,$id_gest,$date,$searcharray){
    $searcharray = unserialize($searcharray);
		$session = $this->request->session();
		$this->viewBuilder()->layout('ajax');
		$this->loadModel("Annonces");
		$this->loadModel("Gestionnaires");
    $this->loadModel("Contratypes");
		if(isset($id_gest)&&!empty($id_gest)){
			$gestionnaire=$this->Gestionnaires->get($id_gest);
		}else{
			$g=$session->read('Gestionnaire.info');
			$gestionnaire=$this->Gestionnaires->get($g['G']['id']);
		}
		$res=$this->Annonces->find()
				->join([
					'U' => [
						'table' => 'utilisateurs',
						'type' => 'inner',
						'conditions' => 'U.id=Annonces.proprietaire_id',
					],
					'R' => [
						'table' => 'residences',
						'type' => 'left',
						'conditions' => 'Annonces.batiment=R.id',
					],
				])
				->select(['Annonces.num_app','R.name','U.prenom','U.nom_famille','U.adresse','U.code_postal','U.ville','U.email'])
				->where(['U.id'=>$id_prop,"Annonces.id"=>$id_ann]);
		$this->set('contrat',$res->first());
		$this->set('gestionnaire',$gestionnaire);
		$this->set('comment',base64_decode($comment));
		$this->set('vdate',$date);
    
    $datamustache = [];
    $this->loadModel('Contratypes');
    $contratype = $this->Contratypes->get($searcharray['type']);
    //ajouter les valeurs des variables du contrat
    $this->loadModel('Optionscontrats');
    $this->loadModel('Variabledynamiques');
    $this->loadModel('Varoptioncontrats');
    $listabvardyn = [];
    $optioncontrat = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id = '=>0])->first();
    $listvariablecontrat = explode("////", $optioncontrat->variable_valeur);
    // $listvariablecontrat = explode(";", $contratype->variables_id);
    $varval = "";
    foreach ($listvariablecontrat as $key) {
      $valeurvar = explode(":", $key);
      $vardyn = $this->Variabledynamiques->find()->where(['id' => $valeurvar[0]])->first();
      if($vardyn){
        if($searcharray['variable'.$valeurvar[0]]){
          $datamustache[$vardyn->nom] = $searcharray['variable'.$valeurvar[0]];
        }
      } 
    }
    $listvariablecontrat2 = explode(";", $contratype->variables_id);
    foreach ($listvariablecontrat2 as $key) {
      $vardyn = $this->Variabledynamiques->find()->where(['id' => $key])->first();
      if($vardyn){
        if($searcharray['variable'.$key]){
          $datamustache[$vardyn->nom] = $searcharray['variable'.$key];
        }
      } 
    }
    $m = new Mustache_Engine;
    $textcontrat = $m->render($contratype->contrat, $datamustache); 

    //ajouter les valeurs variables option du contrat
    $datamustacheoption = [];
    $text_option = "";
    $taboption = array();
    $listoptioncontrat = explode(";", $contratype->options_id);
    foreach ($listoptioncontrat as $keyopt) {
      $msgperiode = '';
      $vardynopt = $this->Optionscontrats->find()->where(['id' => $keyopt])->first();
      if($vardynopt){
        if($searcharray['option'.$keyopt]){
          $listvariableopt = explode(";", $vardynopt->variables_id);
          $varvalop = "";
          foreach ($listvariableopt as $value) {
            $vardynop = $this->Variabledynamiques->find()->where(['id' => $value])->first();
            if($vardynop){
              if($searcharray['optionvar'.$value.'_'.$keyopt]){
                array_push($taboption, $keyopt);
                $datamustacheoption[$vardynop->nom] = $searcharray['optionvar'.$value.'_'.$keyopt];
              }
              // Enregistrement des dates option
              if($value == 4){                
                $listedate = '';
                $today = new Date();
                for ($i=1; $i <= $searcharray['optionvar'.$value.'_'.$keyopt]; $i++) { 
                  $date = $today->year."-".$searcharray['mois_date_'.$i.'_'.$keyopt]."-".$searcharray['jour_date_'.$i.'_'.$keyopt];
                  if(new Date($date) < $today) $date = ($today->year+1)."-".$searcharray['mois_date_'.$i.'_'.$keyopt]."-".$searcharray['jour_date_'.$i.'_'.$keyopt];
                  $dateAffiche = (new Date($date))->i18nFormat('dd/MM/yyyy');
                  $listedate .= $dateAffiche.", ";
                }                
                if($listedate != '') $msgperiode = "<p>Pour le prix de ".$searcharray['optionvar5_'.$keyopt]." € (unitaire) prestations réalisées ".$searcharray['optionvar'.$value.'_'.$keyopt]." fois aux dates suivantes : ".$listedate."</p>";
              } 
            }                
          }
          $m2 = new Mustache_Engine;
          $textcontratoption = $m2->render($vardynopt->text, $datamustacheoption); 
          $text_option .= "<h4>".$vardynopt->titre."</h4>".$textcontratoption.$msgperiode."<br>";
        }
      }
      
    }

    if(!empty($taboption)) $anciennevaleur = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id != '=>0, 'option_id NOT IN '=>$taboption]);
    else $anciennevaleur = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id != '=>0]);
    foreach ($anciennevaleur as $keyopt) {
      $msgperiode = '';
      $vardynopt = $this->Optionscontrats->find()->where(['id' => $keyopt->option_id])->first();
      if($vardynopt){
        if($searcharray['option'.$keyopt->option_id]){
          $listvariableopt = explode(";", $vardynopt->variables_id);
          $varvalop = "";
          foreach ($listvariableopt as $value) {
            $vardynop = $this->Variabledynamiques->find()->where(['id' => $value])->first();
            if($vardynop){
              if($searcharray['optionvar'.$value.'_'.$keyopt->option_id]){
                $datamustacheoption[$vardynop->nom] = $searcharray['optionvar'.$value.'_'.$keyopt->option_id];
              }
              // Enregistrement des dates option
              if($value == 4){                
                $listedate = '';
                $today = new Date();
                for ($i=1; $i <= $searcharray['optionvar'.$value.'_'.$keyopt->option_id]; $i++) { 
                  $date = $today->year."-".$searcharray['mois_date_'.$i.'_'.$keyopt->option_id]."-".$searcharray['jour_date_'.$i.'_'.$keyopt->option_id];
                  if(new Date($date) < $today) $date = ($today->year+1)."-".$searcharray['mois_date_'.$i.'_'.$keyopt->option_id]."-".$searcharray['jour_date_'.$i.'_'.$keyopt->option_id];
                  $dateAffiche = (new Date($date))->i18nFormat('dd/MM/yyyy');
                  $listedate .= $dateAffiche.", ";
                }                
                if($listedate != '') $msgperiode = "<p>Pour le prix de ".$searcharray['optionvar5_'.$keyopt->option_id]." € (unitaire) prestations réalisées ".$searcharray['optionvar'.$value.'_'.$keyopt->option_id]." fois aux dates suivantes : ".$listedate."</p>";
              } 
            }                
          }
          $m2 = new Mustache_Engine;
          $textcontratoption = $m2->render($vardynopt->text, $datamustacheoption); 
          $text_option .= "<h4>".$vardynopt->titre."</h4>".$textcontratoption.$msgperiode."<br>";
        }
      }
      
    }

    $this->set('previewtext',$textcontrat.$text_option);
	}
  /**
	 *
	 **/
	function viewpdfmaint($id_prop,$id_ann,$id_gest,$date,$searcharray){
    $searcharray = unserialize($searcharray);
		$session = $this->request->session();
		$this->viewBuilder()->layout('ajax');
		$this->loadModel("Annonces");
		$this->loadModel("Gestionnaires");
    $this->loadModel("Contratypes");
		if(isset($id_gest)&&!empty($id_gest)){
			$gestionnaire=$this->Gestionnaires->get($id_gest);
		}else{
			$g=$session->read('Gestionnaire.info');
			$gestionnaire=$this->Gestionnaires->get($g['G']['id']);
		}
		$res=$this->Annonces->find()
				->join([
					'U' => [
						'table' => 'utilisateurs',
						'type' => 'inner',
						'conditions' => 'U.id=Annonces.proprietaire_id',
					],
					'R' => [
						'table' => 'residences',
						'type' => 'left',
						'conditions' => 'Annonces.batiment=R.id',
					],
				])
			->select(['Annonces.num_app','R.name','U.prenom','U.nom_famille','U.adresse','U.code_postal','U.ville','U.email'])
			->where(['U.id'=>$id_prop,"Annonces.id"=>$id_ann]);
		$this->set('contrat',$res->first());
		$this->set('gestionnaire',$gestionnaire);
		$this->set('comment',base64_decode($comment));
    $this->set('vdate',$date);
    
    $datamustache = [];
    $this->loadModel('Contratypes');
    $contratype = $this->Contratypes->get($searcharray['type']);
    //ajouter les valeurs des variables du contrat
    $this->loadModel('Optionscontrats');
    $this->loadModel('Variabledynamiques');
    $this->loadModel('Varoptioncontrats');
    $listabvardyn = [];
    $optioncontrat = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id = '=>0])->first();
    $listvariablecontrat = explode("////", $optioncontrat->variable_valeur);
    $varval = "";
    foreach ($listvariablecontrat as $key) {
      $valeurvar = explode(":", $key);
      $vardyn = $this->Variabledynamiques->find()->where(['id' => $valeurvar[0]])->first();
      if($vardyn){
        if($searcharray['variable'.$valeurvar[0]]){
          $datamustache[$vardyn->nom] = $searcharray['variable'.$valeurvar[0]];
        }
      } 
    }
    $listvariablecontrat2 = explode(";", $contratype->variables_id);
    foreach ($listvariablecontrat2 as $key) {
      $vardyn = $this->Variabledynamiques->find()->where(['id' => $key])->first();
      if($vardyn){
        if($searcharray['variable'.$key]){
          $datamustache[$vardyn->nom] = $searcharray['variable'.$key];
        }
      } 
    }
    $m = new Mustache_Engine;
    $textcontrat = $m->render($contratype->contrat, $datamustache); 

    //ajouter les valeurs variables option du contrat
    $datamustacheoption = [];
    $text_option = "";
    $taboption = array();
    $listoptioncontrat = explode(";", $contratype->options_id);
    foreach ($listoptioncontrat as $keyopt) {
      $msgperiode = '';
      $vardynopt = $this->Optionscontrats->find()->where(['id' => $keyopt])->first();
      if($vardynopt){
        if($searcharray['option'.$keyopt]){
          $listvariableopt = explode(";", $vardynopt->variables_id);
          $varvalop = "";
          foreach ($listvariableopt as $value) {
            $vardynop = $this->Variabledynamiques->find()->where(['id' => $value])->first();
            if($vardynop){
              if($searcharray['optionvar'.$value.'_'.$keyopt]){
                array_push($taboption, $keyopt);
                $datamustacheoption[$vardynop->nom] = $searcharray['optionvar'.$value.'_'.$keyopt];
              }
              // Enregistrement des dates option
              if($value == 4){                
                $listedate = '';
                $today = new Date();
                for ($i=1; $i <= $searcharray['optionvar'.$value.'_'.$keyopt]; $i++) { 
                  $date = $today->year."-".$searcharray['mois_date_'.$i.'_'.$keyopt]."-".$searcharray['jour_date_'.$i.'_'.$keyopt];
                  if(new Date($date) < $today) $date = ($today->year+1)."-".$searcharray['mois_date_'.$i.'_'.$keyopt]."-".$searcharray['jour_date_'.$i.'_'.$keyopt];
                  $dateAffiche = (new Date($date))->i18nFormat('dd/MM/yyyy');
                  $listedate .= $dateAffiche.", ";
                }                
                if($listedate != '') $msgperiode = "<p>Pour le prix de ".$searcharray['optionvar5_'.$keyopt]." € (unitaire) prestations réalisées ".$searcharray['optionvar'.$value.'_'.$keyopt]." fois aux dates suivantes : ".$listedate."</p>";
              } 
            }                
          }
          $m2 = new Mustache_Engine;
          $textcontratoption = $m2->render($vardynopt->text, $datamustacheoption); 
          $text_option .= "<h4>".$vardynopt->titre."</h4>".$textcontratoption.$msgperiode."<br>";
        }
      }
      
    }

    if(!empty($taboption)) $anciennevaleur = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id != '=>0, 'option_id NOT IN '=>$taboption]);
    else $anciennevaleur = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id != '=>0]);
    foreach ($anciennevaleur as $keyopt) {
      $msgperiode = '';
      $vardynopt = $this->Optionscontrats->find()->where(['id' => $keyopt->option_id])->first();
      if($vardynopt){
        if($searcharray['option'.$keyopt->option_id]){
          $listvariableopt = explode(";", $vardynopt->variables_id);
          $varvalop = "";
          foreach ($listvariableopt as $value) {
            $vardynop = $this->Variabledynamiques->find()->where(['id' => $value])->first();
            if($vardynop){
              if($searcharray['optionvar'.$value.'_'.$keyopt->option_id]){
                $datamustacheoption[$vardynop->nom] = $searcharray['optionvar'.$value.'_'.$keyopt->option_id];
              }
              // Enregistrement des dates option
              if($value == 4){                
                $listedate = '';
                $today = new Date();
                for ($i=1; $i <= $searcharray['optionvar'.$value.'_'.$keyopt->option_id]; $i++) { 
                  $date = $today->year."-".$searcharray['mois_date_'.$i.'_'.$keyopt->option_id]."-".$searcharray['jour_date_'.$i.'_'.$keyopt->option_id];
                  if(new Date($date) < $today) $date = ($today->year+1)."-".$searcharray['mois_date_'.$i.'_'.$keyopt->option_id]."-".$searcharray['jour_date_'.$i.'_'.$keyopt->option_id];
                  $dateAffiche = (new Date($date))->i18nFormat('dd/MM/yyyy');
                  $listedate .= $dateAffiche.", ";
                }                
                if($listedate != '') $msgperiode = "<p>Pour le prix de ".$searcharray['optionvar5_'.$keyopt->option_id]." € (unitaire) prestations réalisées ".$searcharray['optionvar'.$value.'_'.$keyopt->option_id]." fois aux dates suivantes : ".$listedate."</p>";
              } 
            }                
          }
          $m2 = new Mustache_Engine;
          $textcontratoption = $m2->render($vardynopt->text, $datamustacheoption); 
          $text_option .= "<h4>".$vardynopt->titre."</h4>".$textcontratoption.$msgperiode."<br>";
        }
      }
      
    }

    $this->set('previewtext',$textcontrat.$text_option);
	}
  /**
   * 
   */
  function viewpdfcommercialisation($id_prop,$id_ann,$id_gest,$date,$searcharray){
    $searcharray = unserialize($searcharray);
		$session = $this->request->session();
		$this->viewBuilder()->layout('ajax');
		$this->loadModel("Annonces");
		$this->loadModel("Gestionnaires");
    $this->loadModel("Contratypes");
		if(isset($id_gest)&&!empty($id_gest)){
			$gestionnaire=$this->Gestionnaires->get($id_gest);
		}else{
			$g=$session->read('Gestionnaire.info');
			$gestionnaire=$this->Gestionnaires->get($g['G']['id']);
		}
		$res=$this->Annonces->find()
				->join([
					'U' => [
						'table' => 'utilisateurs',
						'type' => 'inner',
						'conditions' => 'U.id=Annonces.proprietaire_id',
					],
					'R' => [
						'table' => 'residences',
						'type' => 'left',
						'conditions' => 'Annonces.batiment=R.id',
					],
				])
			->select(['Annonces.num_app','R.name','U.prenom','U.nom_famille','U.adresse','U.code_postal','U.ville','U.email'])
			->where(['U.id'=>$id_prop,"Annonces.id"=>$id_ann]);
		$this->set('contrat',$res->first());
		$this->set('gestionnaire',$gestionnaire);
		$this->set('comment',base64_decode($comment));
    $this->set('vdate',$date);
    
    $datamustache = [];
    $this->loadModel('Contratypes');
    $contratype = $this->Contratypes->get($searcharray['type']);
    //ajouter les valeurs des variables du contrat
    $this->loadModel('Optionscontrats');
    $this->loadModel('Variabledynamiques');
    $this->loadModel('Varoptioncontrats');
    $listabvardyn = [];
    $optioncontrat = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id = '=>0])->first();
    $listvariablecontrat = explode("////", $optioncontrat->variable_valeur);
    $varval = "";
    foreach ($listvariablecontrat as $key) {
      $valeurvar = explode(":", $key);
      $vardyn = $this->Variabledynamiques->find()->where(['id' => $valeurvar[0]])->first();
      if($vardyn){
        if($searcharray['variable'.$valeurvar[0]]){
          $datamustache[$vardyn->nom] = $searcharray['variable'.$valeurvar[0]];
        }
      } 
    }
    $listvariablecontrat2 = explode(";", $contratype->variables_id);
    foreach ($listvariablecontrat2 as $key) {
      $vardyn = $this->Variabledynamiques->find()->where(['id' => $key])->first();
      if($vardyn){
        if($searcharray['variable'.$key]){
          $datamustache[$vardyn->nom] = $searcharray['variable'.$key];
        }
      } 
    }
    $m = new Mustache_Engine;
    $textcontrat = $m->render($contratype->contrat, $datamustache); 

    //ajouter les valeurs variables option du contrat
    $datamustacheoption = [];
    $text_option = "";
    $taboption = array();
    $listoptioncontrat = explode(";", $contratype->options_id);
    foreach ($listoptioncontrat as $keyopt) {
      $msgperiode = '';
      $vardynopt = $this->Optionscontrats->find()->where(['id' => $keyopt])->first();
      if($vardynopt){
        if($searcharray['option'.$keyopt]){
          $listvariableopt = explode(";", $vardynopt->variables_id);
          $varvalop = "";
          foreach ($listvariableopt as $value) {
            $vardynop = $this->Variabledynamiques->find()->where(['id' => $value])->first();
            if($vardynop){
              if($searcharray['optionvar'.$value.'_'.$keyopt]){
                array_push($taboption, $keyopt);
                $datamustacheoption[$vardynop->nom] = $searcharray['optionvar'.$value.'_'.$keyopt];
              }
              // Enregistrement des dates option
              if($value == 4){                
                $listedate = '';
                $today = new Date();
                for ($i=1; $i <= $searcharray['optionvar'.$value.'_'.$keyopt]; $i++) { 
                  $date = $today->year."-".$searcharray['mois_date_'.$i.'_'.$keyopt]."-".$searcharray['jour_date_'.$i.'_'.$keyopt];
                  if(new Date($date) < $today) $date = ($today->year+1)."-".$searcharray['mois_date_'.$i.'_'.$keyopt]."-".$searcharray['jour_date_'.$i.'_'.$keyopt];
                  $dateAffiche = (new Date($date))->i18nFormat('dd/MM/yyyy');
                  $listedate .= $dateAffiche.", ";
                }                
                if($listedate != '') $msgperiode = "<p>Pour le prix de ".$searcharray['optionvar5_'.$keyopt]." € (unitaire) prestations réalisées ".$searcharray['optionvar'.$value.'_'.$keyopt]." fois aux dates suivantes : ".$listedate."</p>";
              } 
            }                
          }
          $m2 = new Mustache_Engine;
          $textcontratoption = $m2->render($vardynopt->text, $datamustacheoption); 
          $text_option .= "<h4>".$vardynopt->titre."</h4>".$textcontratoption.$msgperiode."<br>";
        }
      }
      
    }

    if(!empty($taboption)) $anciennevaleur = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id != '=>0, 'option_id NOT IN '=>$taboption]);
    else $anciennevaleur = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id != '=>0]);
    foreach ($anciennevaleur as $keyopt) {
      $msgperiode = '';
      $vardynopt = $this->Optionscontrats->find()->where(['id' => $keyopt->option_id])->first();
      if($vardynopt){
        if($searcharray['option'.$keyopt->option_id]){
          $listvariableopt = explode(";", $vardynopt->variables_id);
          $varvalop = "";
          foreach ($listvariableopt as $value) {
            $vardynop = $this->Variabledynamiques->find()->where(['id' => $value])->first();
            if($vardynop){
              if($searcharray['optionvar'.$value.'_'.$keyopt->option_id]){
                $datamustacheoption[$vardynop->nom] = $searcharray['optionvar'.$value.'_'.$keyopt->option_id];
              }
              // Enregistrement des dates option
              if($value == 4){                
                $listedate = '';
                $today = new Date();
                for ($i=1; $i <= $searcharray['optionvar'.$value.'_'.$keyopt->option_id]; $i++) { 
                  $date = $today->year."-".$searcharray['mois_date_'.$i.'_'.$keyopt->option_id]."-".$searcharray['jour_date_'.$i.'_'.$keyopt->option_id];
                  if(new Date($date) < $today) $date = ($today->year+1)."-".$searcharray['mois_date_'.$i.'_'.$keyopt->option_id]."-".$searcharray['jour_date_'.$i.'_'.$keyopt->option_id];
                  $dateAffiche = (new Date($date))->i18nFormat('dd/MM/yyyy');
                  $listedate .= $dateAffiche.", ";
                }                
                if($listedate != '') $msgperiode = "<p>Pour le prix de ".$searcharray['optionvar5_'.$keyopt->option_id]." € (unitaire) prestations réalisées ".$searcharray['optionvar'.$value.'_'.$keyopt->option_id]." fois aux dates suivantes : ".$listedate."</p>";
              } 
            }                
          }
          $m2 = new Mustache_Engine;
          $textcontratoption = $m2->render($vardynopt->text, $datamustacheoption); 
          $text_option .= "<h4>".$vardynopt->titre."</h4>".$textcontratoption.$msgperiode."<br>";
        }
      }
      
    }

    $this->set('previewtext',$textcontrat.$text_option);
  }
  /**
	 *
	 **/
	function getmail(){
		$data=array("id"=>0);
		$this->loadModel("Utilisateurs");
		$utilCount=$this->Utilisateurs->find();
    $utilCount->select(['nbr' => $utilCount->func()->count('*')])
              ->where(['LOWER(email)'=>strtolower($this->request->data['email'])]);
    $count=$utilCount->first();
		if($count["nbr"]>0){
			$res=$this->Utilisateurs->find();
      $res->join([
              'PV' => [
                'table' => 'pvilles',
                'type' => 'left',
                'conditions' => ['Utilisateurs.ville=PV.id'],
              ],
              'P' => [
                  'table' => 'pays',
                  'type' => 'left',
                  'conditions' => ['Utilisateurs.pays=P.id_pays'],
              ]
            ])
						->select(['PV.name','Utilisateurs.id','Utilisateurs.prenom','Utilisateurs.nom_famille','Utilisateurs.adresse','Utilisateurs.code_postal','Utilisateurs.ville','Utilisateurs.email','Utilisateurs.telephone','Utilisateurs.portable','Utilisateurs.telephone2','Utilisateurs.portable2','Utilisateurs.adr2','Utilisateurs.mot_passe','Utilisateurs.pwd','Utilisateurs.fax','Utilisateurs.societe','Utilisateurs.pays'])
						->where(['LOWER(email)'=>strtolower($this->request->data['email'])]);
			$util=$res->first();
                        $this->loadModel("Frvilles");
                        if($util->pays == 67){
                            $paysuser = $this->Frvilles->find()->where(['id' => $util->ville])->first();                    
                            $paysname = $paysuser->name;
                        }else{
                            $paysname = $util['PV']['name'];
                        }
			$data=array('id'=>$util->id,"email"=>$util->email,"prenom"=>$util->prenom,"nom_famille"=>$util->nom_famille,"adresse"=>$util->adresse,"code_postal"=>$util->code_postal,"telephone"=>$util->telephone,"telephone2"=>$util->telephone2,"portable"=>$util->portable,"portable2"=>$util->portable2,"ville"=>$paysname,"adresse2"=>$util->adr2,"mot_passe"=>$util->mot_passe,"pwd"=>$util->pwd,"fax"=>$util->fax,"societe"=>$util->societe,"pays"=>$util->pays);
		}
		echo json_encode($data);
		die();
	}
  /**
	 *
	 **/
	protected function getpdfme($id_gest,$from,$to){
		// require_once(ROOT . DS . 'vendor' . DS . "MPDF" . DS . "mpdf.php");
    // $mpdf=new mPDF('c','A4','','',10,10,10,0,16,13);
    $mpdf = new \Mpdf\Mpdf();
		$html=file_get_contents(SITE_ALPISSIME."/manager/arrivees/setpdfmenage/".$id_gest."/".$from."/".$to);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->list_indent_first_level = 0;
		$mpdf->WriteHTML($html,2);
		$mpdf->Output(ROOT.DS.'webroot'.DS.'menage'.DS.'menage.pdf');
	}
  /**
	 *
	 **/
	function getpdfmenage(){
			$session = $this->request->session();
			$gestionnaire=$session->read('Gestionnaire.info');
			$this->getpdfme($gestionnaire['G']['id'],$this->request->data["vFrom"],$this->request->data["vTo"]);
			echo SITE_ALPISSIME."/menage/menage.pdf";
			die();
	}
  /**
	 *
	 **/
	function setpdfmenage($id=null,$from=null,$to=null){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel("Annonces");
		$this->loadModel("Gestionnaires");
		$gestionnaire=$this->Gestionnaires->get($id);
		$debut=date('Y-m-d', strtotime($from));
		$fin=date('Y-m-d', strtotime($to));
		$res=$this->Annonces->find()
							->join([
								'RR' => [
									'table' => 'reservations',
									'type' => 'inner',
									'conditions' => ['Annonces.id=RR.annonce_id','RR.statut'=>90],
								],
								'U' => [
									'table' => 'utilisateurs',
									'type' => 'inner',
									'conditions' => 'U.id=RR.utilisateur_id',
								],
								'P' => [
									'table' => 'utilisateurs',
									'type' => 'inner',
									'conditions' => 'P.id=Annonces.proprietaire_id',
								],
								'G' => [
                  'table' => 'gestionnaires',
                  'type' => 'inner',
                  'conditions' => ['G.id=Annonces.id_gestionnaires','Annonces.id_gestionnaires'=>$id]
                ],
								'R' => [
									'table' => 'residences',
									'type' => 'left',
									'conditions' => ['Annonces.batiment=R.id','RR.menage>=1'],
								]
							])
				->select(['Annonces.num_app','U.prenom','U.nom_famille','U.portable','P.prenom','P.nom_famille','P.portable','R.name','Annonces.id','Annonces.surface','RR.id','RR.menage','RR.dbt_at'])
				->where(['RR.dbt_at>="'.$debut.'"','RR.dbt_at<="'.$fin.'"']);
		$this->set('menage',$res);
		$this->set('gestionnaire',$gestionnaire);
	}
  /**
	 *
	 **/
  public function codereduction(){
    $this->viewBuilder()->layout('manager');
  	$session = $this->request->session();
  	$this->set('InfoGes',$session->read('Gestionnaire.info'));
    $this->loadModel("Reductions");
    $codes = $this->Reductions->arraycodesreductionsadmin();
    $this->set("codes", $codes);
  }
  /**
   * 
   */
  function getvariablecontrattype($id = null)
  {
    $this->viewBuilder()->layout(false);
    $this->loadModel('Contratypes');
    $this->loadModel('Variabledynamiques');
    $this->loadModel('Varoptioncontrats');
    $varvaleur = $this->Varoptioncontrats->find()->where(['contrat_id' => $id, 'option_id' => 0])->first();
    // print_r($varvaleur);
    $listabvardyn = [];
    $listvarvaleur = [];
    $listvarvaleurcontrat = explode("////", $varvaleur->variable_valeur);
    foreach ($listvarvaleurcontrat as $valeur) {
      if($valeur){
        $vardyna = explode(":", $valeur);
        $vardyn = $this->Variabledynamiques->find()->where(['id' => $vardyna[0]])->first();
        if($vardyn) $listabvardyn[$vardyna[0]] = $vardyn->nom;
        $listvarvaleur[$vardyna[0]] = $vardyna[1];
      }      
    }
    // Lister les nouvelles valeurs dans contrat
    $contratype = $this->Contratypes->get($this->request->data['id']);
    $listvariablecontrat = explode(";", $contratype->variables_id);
    foreach ($listvariablecontrat as $key) {
      $vardyn = $this->Variabledynamiques->find()->where(['id' => $key])->first();
      if($vardyn) $listabvardyn[$key] = $vardyn->nom;
    }
    $this->set('listevardynoption',$listabvardyn);
    $this->set('listevardynoptionvaleur',$listvarvaleur);
  }
  /**
   * 
   */
  function getoptioncontrattype($id = null)
  {
    $this->viewBuilder()->layout(false);
    $this->loadModel('Contratypes');
    $this->loadModel('Optionscontrats');
    $this->loadModel('Varoptioncontrats');
    $listabvardyn = [];
    $varvaleurop = $this->Varoptioncontrats->find()->where(['contrat_id' => $id, 'option_id !=' => 0]);
    
    foreach ($varvaleurop as $optionval) {
      $vardyn = $this->Optionscontrats->find()->where(['id' => $optionval->option_id])->first();
      if($vardyn) $listabvardyn[$optionval->option_id] = $vardyn->titre;
      $listvarvaleuroption[$optionval->option_id] = $listvarvaleur;

      $varvaleur = $this->Varoptioncontrats->find()->where(['contrat_id' => $id, 'option_id' => $optionval->option_id])->first();
      $listvarvaleur = [];
      $listvarvaleurcontrat = explode("////", $varvaleur->variable_valeur);
      foreach ($listvarvaleurcontrat as $valeur) {
        if($valeur){
          $vardyna = explode(":", $valeur);
          if($vardyna[0] == 2){
            $listevar2 = explode("__", $vardyna[1]);
            foreach ($listevar2 as $key) {
              $listvarvaleur[$vardyna[0]][] = $key;
            }
          }else{
            $listvarvaleur[$vardyna[0]] = $vardyna[1];
          }          
        }      
      }
      $listvarvaleuroption[$optionval->option_id] = $listvarvaleur;
    }
    $this->set('listeoptionchecked',$listabvardyn);
    // Pour le cas d'une nouvelle option
    $contratype = $this->Contratypes->get($this->request->data['id']);
    $listvariablecontrat = explode(";", $contratype->options_id);
    foreach ($listvariablecontrat as $key) {
      $vardyn = $this->Optionscontrats->find()->where(['id' => $key])->first();
      if($vardyn) $listabvardyn[$key] = $vardyn->titre;

      $varvaleur = $this->Varoptioncontrats->find()->where(['contrat_id' => $id, 'option_id' => $key])->first();
      // $listvarvaleur = [];
      $listvarvaleurcontrat = explode("////", $varvaleur->variable_valeur);
      foreach ($listvarvaleurcontrat as $valeur) {
        if($valeur){
          $vardyna = explode(":", $valeur);
          if($vardyna[0] == 2){
            $listevar2 = explode("__", $vardyna[1]);
            foreach ($listevar2 as $key) {
              $listvarvaleur[$vardyna[0]][] = $key;
            }
          }else{
            $listvarvaleur[$vardyna[0]] = $vardyna[1];
          } 
          // $listvarvaleur[$vardyna[0]] = $vardyna[1];
        }      
      }
      $listvarvaleuroption[$key] = $listvarvaleur;
    }
    $this->set('listvarvaleuroption',$listvarvaleuroption);
    $this->set('listeoption',$listabvardyn);
  }
  /**
   * 
   */
  public function getprixcontratboutique()
  {
    $this->viewBuilder()->layout(false);
    // $tab = array("7-13095" => "320", "test1" => "400", "1" => "100", "2" => "200", "3" => "300");
    $tabCharvet = array("5-26064" => "120", "5-CO-001" => "89", "5-34210" => "89", "5-34209" => "259", "5-34208" => "239", "5-34207" => "229", "5-34206" => "209", "5-34205" => "199", "5-34204" => "169", "5-34203" => "139", "5-34202" => "119", "edl-les-arcs-14-30" => "33.9", "edl-les-arcs-31-70-2" => "36.9", "edl-les-arcs-71-100-2" => "39.9", "edl-les-arcs-101-150-2-1" => "46.9", "ALA-VFS-1" => "30", "ALA-VFS-2" => "35", "ALA-VFS-3" => "39.9", "ALA-VFS-4" => "46.9", "ALP-LA-CC" => "0", "7-13096" => "359", "5-19292" => "540", "5-19291" => "595", "5-19288" => "699", "5-14097" => "759", "5-15769" => "779", "5-13092" => "798", "5-19293" => "829", "5-15283" => "1079", "8-19297" => "49");
    $tabValdallos = array("5-CO-0001" => "89", "59-contrat-de-gestion-de-cles" => "319", "59-mise-en-relation" => "49");
    $tabVillard = array("5-26064-1" => "120", "5-CO-0001" => "89", "5-34210-2" => "289", "5-34209-3" => "259", "5-34208-2" => "239", "5-34207-2" => "229", "5-34206-2" => "209", "5-34205-2" => "199", "5-34204-3" => "169", "5-34203-2" => "139", "5-34202-2" => "119", "5-16335-1" => "33.9", "5-20467-1" => "36.9", "5-20468-1" => "39.9", "5-16249-2" => "46.9", "ALA-VFS-1-1" => "30", "ALA-VFS-2-1" => "35", "ALA-VFS-3-1" => "39.9", "ALA-VFS-4-1" => "46.9", "ALP-LA-CC-1" => "0", "7-13096-1" => "359", "5-19292-1" => "540", "5-19291-2" => "595", "5-19288-1" => "699", "5-14097-2" => "759", "5-15769-1" => "779", "5-13092-2" => "798", "5-19293-1" => "829", "5-15283-1" => "1079");
    $tabArc200 = array("5-26064" => "120", "5-CO-0001" => "89", "5-34210" => "289", "5-34209" => "259", "5-34208" => "239", "5-34207" => "229", "5-34206" => "209", "5-34205" => "199", "5-34204" => "169", "5-34203" => "139", "5-34202" => "119", "5-16335" => "33.9", "5-20467" => "36.9", "5-20468" => "39.9", "5-16249" => "46.9", "5-19298" => "30", "5-19299" => "35", "5-19300" => "39.9", "5-26063" => "46.9", "7-13095" => "339", "5-19292" => "550", "5-19291" => "610", "5-19288" => "715", "5-14097" => "775", "5-15769" => "795", "5-13092" => "815", "5-19293" => "845", "5-15283" => "889", "8-19297" => "49");
    $tabStephane = array("M-DEC-01" => "40", "M-DEC-02" => "50", "M-DEC-03" => "60", "SM-DEC-01" => "100", "SM-DEC-02" => "150", "SM-DEC-03" => "200", "SM-DEC-04" => "250", "MFS-DEC-01" => "200", "MFS-DEC-02" => "250", "VOF-DEC" => "20", "CG-DEC" => "99", "CICS-DEC-01" => "25", "CICS-DEC-02" => "250", "CIS-DEC-01" => "40", "CIS-DEC-02" => "400", "MAB-DEC-01" => "60", "MAB-DEC-02" => "80", "MAB-DEC-03" => "100", "MAB-DEC-04" => "150", "MAB-DEC-05" => "200", "MAB-DEC-06" => "250");
    $tabMontchavin = array("JR-CGT-1" => "569", "JR-CGT-2" => "629", "JR-CGT-3" => "739", "JR-CGT-4" => "799", "JR-CGT-5" => "819", "JR-CGT-6" => "839", "JR-CGT-7" => "869", "JR-CGT-8" => "1129", "JR-CGC-3" => "400", "JR-EDL-1" => "40", "JR-EDL-2" => "50", "JR-EDL-3" => "60", "JR-EDL-4" => "70", "JR-EDL-5" => "80", "JR-MLC-MAB-T1" => "125", "JR-MLC-MAB-T2" => "145", "JR-MLC-MAB-T3" => "175", "JR-MLC-MAB-T4" => "195", "JR-MLC-MAB-T5" => "225", "JR-GCG-RT" => "0");
    $tabCoches = array("JR-CGT-1" => "569", "JR-CGT-2" => "629", "JR-CGT-3" => "739", "JR-CGT-4" => "799", "JR-CGT-5" => "819", "JR-CGT-6" => "839", "JR-CGT-7" => "869", "JR-CGT-8" => "1129", "JR-CGC-3" => "400", "JR-EDL-1" => "40", "JR-EDL-2" => "50", "JR-EDL-3" => "60", "JR-EDL-4" => "70", "JR-EDL-5" => "80", "JR-MLC-MAB-T1" => "125", "JR-MLC-MAB-T2" => "145", "JR-MLC-MAB-T3" => "175", "JR-MLC-MAB-T4" => "195", "JR-MLC-MAB-T5" => "225", "JR-GCG-RT" => "0");
    $session = $this->request->session();
    $gest=$session->read('Gestionnaire.info');
    if($gest['G']['id'] == 3) $tab = $tabCharvet;
    if($gest['G']['id'] == 4) $tab = $tabVillard;
    if($gest['G']['id'] == 7) $tab = $tabValdallos;
    if($gest['G']['id'] == 8) $tab = $tabStephane;
    if($gest['G']['id'] == 5) $tab = $tabArc200;
    if($gest['G']['id'] == 9) $tab = $tabMontchavin;
    if($gest['G']['id'] == 10) $tab = $tabCoches;
    // Fonction Boutique Anis
    if(is_array($this->request->data['idboutique'])){
      $prixboutique = 0;
      foreach ($this->request->data['idboutique'] as $value) {
        $prixboutique += $tab[$value];
      }
    }else{
      $prixboutique = $tab[$this->request->data['idboutique']];
    }    
    // FIN Fonction Boutique Anis
    $this->set('prixboutique',$prixboutique);
  }
  /**
   * 
   */
  public function getlisteidoptionboutique()
  {
    $this->viewBuilder()->layout(false);
    // $tab = array("0" => "-- choisissez un produit --","7-13095" => "Contrat de gestion de clé", "test1" => "Contrat de maintenance", "1" => "Reportage photo", "2" => "Etat des lieux", "3" => "Ménage");
    $tabCharvet = array("0" => "-- choisissez un produit --", "5-26064" => "Reportage photo", "5-CO-0001" => "Redaction Annonce", "5-34210" => "Menage a blanc 151 a 180m2", "5-34209" => "Menage a blanc 121 a 150m2", "5-34208" => "Menage a blanc 101 a 120m2", "5-34207" => "Menage a blanc 71 a 100m2", "5-34206" => "Menage a blanc 51 a 70m2", "5-34205" => "Menage a blanc 41 a 50m2", "5-34204" => "Menage a blanc 31 a 40m2", "5-34203" => "Menage a blanc 19 a 30m2", "5-34202" => "Menage a blanc 13 a 18m2", "edl-les-arcs-14-30" => "Etat des lieux 14 à 30m2", "edl-les-arcs-31-70-2" => "Etat des lieux 31 à 70m2", "edl-les-arcs-71-100-2" => "Etat des lieux 71 à 100m2", "edl-les-arcs-101-150-2-1" => "Etat des lieux 101 à 150m2", "ALA-VFS-1" => "Visite de début / fin de saison - 13 à 30 m²", "ALA-VFS-2" => "Visite de début / fin de saison - 31 à 70 m²", "ALA-VFS-3" => "Visite de début / fin de saison - 71 à 100 m²", "ALA-VFS-4" => "Visite de début / fin de saison - 101 à 150 m²", "ALP-LA-CC" => "Contrat de commercialisation", "7-13096" => "Contrat de gestion de clés", "5-19292" => "Contrat de gestion technique - Hébergement de 13 à 19 m²", "5-19291" => "Contrat de gestion technique - Hébergement de 20 à 30 m²", "5-19288" => "Contrat de gestion technique - Hébergement de 31 à 39 m²", "5-14097" => "Contrat de gestion technique - Hébergement de 40 à 59 m²", "5-15769" => "Contrat de gestion technique - Hébergement de 60 à 79 m²", "5-13092" => "Contrat de gestion technique - Hébergement de 80 à 99 m²", "5-19293" => "Contrat de gestion technique - Hébergement de 100 à 120 m²", "5-15283" => "Contrat de gestion technique - Hébergement supérieur à 120 m²", "8-19297" => "Contrat de mise en relation");
    $tabValdallos = array("0" => "-- choisissez un produit --","5-CO-0001" => "Redaction Annonce", "59-contrat-de-gestion-de-cles" => "Contrat de gestion de clés", "59-mise-en-relation" => "Contrat de mise en relation");
    $tabVillard = array("0" => "-- choisissez un produit --", "5-26064-1" => "Reportage photo", "5-CO-0001" => "Redaction Annonce", "5-34210-2" => "Menage a blanc 151 a 180m2", "5-34209-3" => "Menage a blanc 121 a 150m2", "5-34208-2" => "Menage a blanc 101 a 120m2", "5-34207-2" => "Menage a blanc 71 a 100m2", "5-34206-2" => "Menage a blanc 51 a 70m2", "5-34205-2" => "Menage a blanc 41 a 50m2", "5-34204-3" => "Menage a blanc 31 a 40m2", "5-34203-2" => "Menage a blanc 19 a 30m2", "5-34202-2" => "Menage a blanc 13 a 18m2", "5-16335-1" => "Etat des lieux 14 à 30m2", "5-20467-1" => "Etat des lieux 31 à 70m2", "5-20468-1" => "Etat des lieux 71 à 100m2", "5-16249-2" => "Etat des lieux 101 à 150m2", "ALA-VFS-1-1" => "Visite de début / fin de saison - 13 à 30 m²", "ALA-VFS-2-1" => "Visite de début / fin de saison - 31 à 70 m²", "ALA-VFS-3-1" => "Visite de début / fin de saison - 71 à 100 m²", "ALA-VFS-4-1" => "Visite de début / fin de saison - 101 à 150 m²", "ALP-LA-CC-1" => "Contrat de commercialisation", "7-13096-1" => "Contrat de gestion de clés", "5-19292-1" => "Contrat de gestion technique - Hébergement de 13 à 19 m²", "5-19291-2" => "Contrat de gestion technique - Hébergement de 20 à 30 m²", "5-19288-1" => "Contrat de gestion technique - Hébergement de 31 à 39 m²", "5-14097-2" => "Contrat de gestion technique - Hébergement de 40 à 59 m²", "5-15769-1" => "Contrat de gestion technique - Hébergement de 60 à 79 m²", "5-13092-2" => "Contrat de gestion technique - Hébergement de 80 à 99 m²", "5-19293-1" => "Contrat de gestion technique - Hébergement de 100 à 120 m²", "5-15283-1" => "Contrat de gestion technique - Hébergement de 121 à 150 m²");
    $tabArc200 = array("0" => "-- choisissez un produit --","5-26064" => "Reportage photo", "5-CO-0001" => "Redaction Annonce", "5-34210" => "Menage a blanc 151 a 180m2", "5-34209" => "Menage a blanc 121 a 150m2", "5-34208" => "Menage a blanc 101 a 120m2", "5-34207" => "Menage a blanc 71 a 100m2", "5-34206" => "Menage a blanc 51 a 70m2", "5-34205" => "Menage a blanc 41 a 50m2", "5-34204" => "Menage a blanc 31 a 40m2", "5-34203" => "Menage a blanc 19 a 30m2", "5-34202" => "Menage a blanc 13 a 18m2", "5-16335" => "Etat des lieux 14 à 30m2", "5-20467" => "Etat des lieux 31 à 70m2", "5-20468" => "Etat des lieux 71 à 100m2", "5-16249" => "Etat des lieux 101 à 150m2", "5-19298" => "Visite de début / fin de saison - 13 à 30 m²", "5-19299" => "Visite de début / fin de saison - 31 à 70 m²", "5-19300" => "Visite de début / fin de saison - 71 à 100 m²", "5-26063" => "Visite de début / fin de saison - 101 à 150 m²", "7-13095" => "Contrat de gestion de clés", "5-19292" => "Contrat de gestion technique - Hébergement de 13 à 19 m²", "5-19291" => "Contrat de gestion technique - Hébergement de 20 à 30 m²", "5-19288" => "Contrat de gestion technique - Hébergement de 31 à 39 m²", "5-14097" => "Contrat de gestion technique - Hébergement de 40 à 59 m²", "5-15769" => "Contrat de gestion technique - Hébergement de 60 à 79 m²", "5-13092" => "Contrat de gestion technique - Hébergement de 80 à 99 m²", "5-19293" => "Contrat de gestion technique - Hébergement de 100 à 120 m²", "5-15283" => "Contrat de gestion technique - Hébergement supérieur à 120 m²", "8-19297" => "Contrat de mise en relation");
    $tabStephane = array("0" => "-- choisissez un produit --","M-DEC-01" => "Menage T1", "M-DEC-02" => "Menage T2", "M-DEC-03" => "Menage T3", "SM-DEC-01" => "Shampoing moquette T1", "SM-DEC-02" => "Shampoing moquette T2", "SM-DEC-03" => "Shampoing moquette T3", "SM-DEC-04" => "Shampoing moquette T4", "MFS-DEC-01" => "Menage fin de saison T1/T2", "MFS-DEC-02" => "Menage fin de saison T3/T4", "VOF-DEC" => "Visite d'ouverture / fermeture", "CG-DEC" => "Contrat de gestion", "CICS-DEC-01" => "1 Check-in/check-out court séjour", "CICS-DEC-02" => "10 Check-in/check-out court séjour", "CIS-DEC-01" => "1 Check-in/check-out semaine", "CIS-DEC-02" => "10 Check-in/check-out semaine", "MAB-DEC-01" => "Menage a blanc < 20m2", "MAB-DEC-02" => "Menage a blanc 21 à 40 m2", "MAB-DEC-03" => "Menage a blanc 41 à 70 m2", "MAB-DEC-04" => "Menage a blanc 71 à 100 m2", "MAB-DEC-05" => "Menage a blanc 101 à 150 m2", "MAB-DEC-06" => "Menage a blanc 151 à 200 m2");
    $tabMontchavin = array("0" => "-- choisissez un produit --","JR-CGT-1" => "Contrat de gestion technique 13 à 19 m2", "JR-CGT-2" => "Contrat de gestion technique 20 à 30 m2", "JR-CGT-3" => "Contrat de gestion technique 31 à 40 m2", "JR-CGT-4" => "Contrat de gestion technique 41 à 59 m2", "JR-CGT-5" => "Contrat de gestion technique 60 à 79 m2", "JR-CGT-6" => "Contrat de gestion technique 80 à 99 m2", "JR-CGT-7" => "Contrat de gestion technique 100 à 120 m2", "JR-CGT-8" => "Contrat de gestion technique > 120 m2", "JR-CGC-3" => "Contrat de gestion de clés (année)", "JR-EDL-1" => "Etat des lieux T1", "JR-EDL-2" => "Etat des lieux T2", "JR-EDL-3" => "Etat des lieux T3", "JR-EDL-4" => "Etat des lieux T4", "JR-EDL-5" => "Etat des lieux T5", "JR-MLC-MAB-T1" => "Menage a blanc T1", "JR-MLC-MAB-T2" => "Menage a blanc T2", "JR-MLC-MAB-T3" => "Menage a blanc T3", "JR-MLC-MAB-T4" => "Menage a blanc T4", "JR-MLC-MAB-T5" => "Menage a blanc T5", "JR-GCG-RT" => "Contrat de gestion de clés - Résidence de Tourisme");
    $tabCoches = array("0" => "-- choisissez un produit --","JR-CGT-1" => "Contrat de gestion technique 13 à 19 m2", "JR-CGT-2" => "Contrat de gestion technique 20 à 30 m2", "JR-CGT-3" => "Contrat de gestion technique 31 à 40 m2", "JR-CGT-4" => "Contrat de gestion technique 41 à 59 m2", "JR-CGT-5" => "Contrat de gestion technique 60 à 79 m2", "JR-CGT-6" => "Contrat de gestion technique 80 à 99 m2", "JR-CGT-7" => "Contrat de gestion technique 100 à 120 m2", "JR-CGT-8" => "Contrat de gestion technique > 120 m2", "JR-CGC-3" => "Contrat de gestion de clés (année)", "JR-EDL-1" => "Etat des lieux T1", "JR-EDL-2" => "Etat des lieux T2", "JR-EDL-3" => "Etat des lieux T3", "JR-EDL-4" => "Etat des lieux T4", "JR-EDL-5" => "Etat des lieux T5", "JR-MLC-MAB-T1" => "Menage a blanc T1", "JR-MLC-MAB-T2" => "Menage a blanc T2", "JR-MLC-MAB-T3" => "Menage a blanc T3", "JR-MLC-MAB-T4" => "Menage a blanc T4", "JR-MLC-MAB-T5" => "Menage a blanc T5", "JR-GCG-RT" => "Contrat de gestion de clés - Résidence de Tourisme");
    $session = $this->request->session();
    $gest=$session->read('Gestionnaire.info');
    if($gest['G']['id'] == 3) $tab = $tabCharvet;
    if($gest['G']['id'] == 4) $tab = $tabVillard;
    if($gest['G']['id'] == 7) $tab = $tabValdallos;
    if($gest['G']['id'] == 8) $tab = $tabStephane;
    if($gest['G']['id'] == 5) $tab = $tabArc200;
    if($gest['G']['id'] == 9) $tab = $tabMontchavin;
    if($gest['G']['id'] == 10) $tab = $tabCoches;
    // Fonction Boutique Anis
    
    // FIN Fonction Boutique Anis
    $this->set('listeidoptionboutique',$tab);
  }
  /**
   * 
   */
  public function getlistedatesoption()
  {
    $this->viewBuilder()->layout(false);
    $this->loadModel('DatesOptionContrat');
    $getvaleur = $this->DatesOptionContrat->find()->where(['contrat_id' => $this->request->data['contratID'], 'option_id' => $this->request->data['optionID']])->first();
    $listdateoption = explode(";", $getvaleur->dates);
    $this->set('datesoption',$listdateoption);
  }

}
