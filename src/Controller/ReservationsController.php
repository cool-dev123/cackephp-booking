<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Log\Log;
use \DateTime;
use \DateTimeZone;
use \Google_Client;
use \Google_Service_Calendar;
use \Google_Service_Drive;
use \Google_Service_Plus;
use \Google_Service_Calendar_Event;
use \Google_Service_Calendar_EventDateTime;
use Mage;
use \Mage_Core_Model_App;
use \Varien_Object;
use Mustache_Engine;
use Cake\Core\Configure;
use Cake\I18n\I18n;

/**
 * Reservations Controller
 *
 * @property \App\Model\Table\ReservationsTable $Reservations
 */
class ReservationsController extends AppController
{
	public $helpers = ['AnnonceFormater','Telephone','Time'];

	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Flash');
		$this->loadComponent('RequestHandler');
     	$this->loadComponent('Auth', [
			'loginAction' => [
				'controller' => 'Utilisateurs',
				'action' => 'erreurconnexion'
			],
			'logoutRedirect' => [
					'controller' => 'annonces',
					'action' => 'landing'
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
		// $this->loadComponent('InvisibleReCaptcha.InvisibleReCaptcha',
		// 	[
		// 		// 'secretkey' => '6LfWgbsZAAAAAB_Ey8rHRoeCTZ3ZR1VQKQyLc3ge',
		// 		// 'sitekey' => '6LfWgbsZAAAAAOytZsO4ZNk6M-6KY7gJriJYtDzl'
		// 		'secretkey' => '6Ld_sI8bAAAAAAnR-7FHvvpivhf-Ls6TZykwevtz',
		// 		'sitekey' => '6Ld_sI8bAAAAAB8fRlz74t_tdw2e4YEv-ZG2KXug'
		// 	]);
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
		
		if($this->request->action === 'getReservationProprietaire' || $this->request->action === 'editReservationProprietaire' || $this->request->action === 'view'){
			$this->loadComponent('Csrf');
		}	

    }
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(["index", "reservationsProprietaire", "confirmreservations", "envoiFTP","anto","pdf","create_pdf","getReservationProprietaire", "blockreduction", "getdetailreservations", "deletereservation", "deletereservationlocataire", "deletereservationlocatairejustif", "validation", "editReservationLocataire", "addReservationComment", "editReservationProprietaire", "ajoutreservationpanier", "sendmessagefromreservation", "shownumber", "viewReservation"]);
		$this->loadModel("Lieugeos");
		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3, "etat = 1"],"order"=>"Lieugeos.name"]);
		$ar[]="Destination";
		foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		$this->set("l_lieugeos",$ar);
		// Vérifier si locataire a une réservation dans panier
		$session = $this->request->session();
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
	}
  /**
   * Index method
   *
   * @return \Cake\Network\Response|null
   */
  public function index(){
      $this->paginate = ['contain' => ['Annonces', 'Utilisateurs']];
      $reservations = $this->paginate($this->Reservations);
      $this->set(compact('reservations'));
      $this->set('_serialize', ['reservations']);
  }
    /**
     * View method
     *
     * @param string|null $id Reservation id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        //$msgannul = "";
        //$session  = $this->request->session();
        //        $nbrannulation = $session->read('Auth.User.nbr_annulation');
        // if($session->read('Auth.User.nature') != "PRES"){
        // 	if(fmod($nbrannulation, 3) == 0){
        // 		// 3eme annulation
        // 		$msgannul = "Vous êtes sur le point d’annuler une réservation. Une annulation faite par le propriétaire entraîne un remboursement complet du locataire. Si la demande provient du locataire, il peut lui-même l’annuler en se connectant sur Alpissime. <br><br> En cas d’annulation multiples et consécutives de votre part, une pénalité pourrait être appliquée. <br><br> Attention : il s'agît de votre 3ème annulation consécutive. Celle-ci peut donner lieu à une pénalité sur votre prochain virement.";
        // 	}else if(fmod($nbrannulation, 3) == 1){
        // 		// 1ere annulation
        // 		$msgannul = "Annuler la réservation ? <br><br> Vous êtes sur le point d’annuler une réservation. Attention, une annulation faite par le propriétaire entraîne un remboursement complet du locataire. Si la demande provient du locataire, il peut lui-même l’annuler en se connectant sur Alpissime. <br><br> En cas d’annulation multiples et consécutives de votre part, une pénalité pourrait être appliquée.";
        // 	}else if(fmod($nbrannulation, 3) == 2){
        // 		// 2eme annulation
        // 		$msgannul = "Annuler la réservation ? <br><br> Vous êtes sur le point d’annuler une réservation. Attention, une annulation faite par le propriétaire entraîne un remboursement complet du locataire. Si la demande provient du locataire, il peut lui-même l’annuler en se connectant sur Alpissime. <br><br> En cas d’annulation multiples et consécutives de votre part, une pénalité pourrait être appliquée.";
        // 	}
        // }else{
        // 	$msgannul = "";
        // }

        $this->set('msgannul', '');

        $mail = [];
        $data = [];
        $this->loadModel("Modelmailsysteme");
        $textEmail = $this->Modelmailsysteme->find('all');

        foreach ($textEmail as $key => $value) {
            $mail[$value->titre] = $value->txtmail;
        }

        $this->set("textmail",$mail);

        $l_reservationsstatuts = [
            '0'   => 'En cours',
            '10'  => 'Supprimee',
            '90'  => 'Validee Proprietaire',
            '100' => 'Demande annulation en attente',
            '110' => 'Annulée'
        ];

        $this->set("l_reservationsstatuts", $l_reservationsstatuts);

        if ($this->request->data['motcleres'] != '') {
            $key = preg_grep("#" . $this->request->data['motcleres'] . "#", $l_reservationsstatuts);

            $data = $this->paginate($this->Reservations->getReservationsProprietaireRecherche($this->Auth->user('id'),$this->request->data['motcleres'], $key));

            $this->set('reservations', $data);
            $this->set('motcleres', $this->request->data['motcleres']);
        } else {
            if ($id == null) {
                $data = $this->paginate($this->Reservations->getReservationsProprietaire($this->Auth->user('id')));
            } else {
                $data = $this->paginate($this->Reservations->getReservations($id));

                $session = $this->request->session();
                $session->write('Reserv.id',$id);
                $this->set('annonce_id', $id);
            }
        }

        $this->set('reservations', $data);
    }
  	/**
	 * 
	 */
	public function reservationcalendar()
	{
		$listeReservationsynchro = $this->Reservations->find("all")
		->join([            
            'Dispos' => [
                'table' => 'dispos',
                'type' => 'inner',
                'conditions' => 'Dispos.reservation_id=Reservations.id',
			],
			'annonce' => [
				'table' => 'annonces',
				'type' => 'inner',
				'conditions' => 'annonce.id = Reservations.annonce_id',
			]
        ])
		->where(['Dispos.calendarsynchro_id != 0', 'Reservations.utilisateur_id = 0', 'annonce.proprietaire_id' => $this->Auth->user('id')])
		->group('Reservations.id');
		$this->set('reservations', $listeReservationsynchro);
	}
	/**
	 * 
	 */
	public function editreservationcalendar($id)
	{
		$reservationsynchro = $this->Reservations->get($id);
		$this->set('reservation', $reservationsynchro);

		/** Liste pays **/
		$this->loadModel("Pays");
		$Pays=$this->Pays->findByCode_pays('Fr')->union(
		$this->Pays->find('all')->where(['code_pays != ' =>'FR']));
		$payNum=array();
		$a_pay=array();
		$a_pay[0] = '';
		foreach($Pays as $pay){
			$session = $this->request->session();
			if($session->read('Config.language') == "fr_FR") $a_pay[$pay->id_pays]=$pay->fr;
            if($session->read('Config.language') == "en_US") $a_pay[$pay->id_pays]=$pay->en;
			$payNum[$pay->id_pays]=$pay->code_pays;
		}
		$this->set("paysNum", $payNum);
		$this->set("Pays", $a_pay);
        $mainURL = Router::url('/', true);
		if(!empty($this->request->data)){
			// verifier locataire
			$this->loadModel("Utilisateurs");
			$this->loadModel("Annonces");
			$annonce=$this->Annonces->get($reservationsynchro->annonce_id, ['contain' => ['Lieugeos','Villages']]);
			$info_prop=$this->Utilisateurs->find("all")->where(['id' => $annonce->proprietaire_id]);
			$res_uti=$this->Utilisateurs->find('all',['conditions'=>["lcase(email) LIKE '".trim(strtolower($this->request->data['email']))."'"]]);
			$utilisLocataire = $res_uti->first();
			if($utilisLocataire && $utilisLocataire->email == $info_prop->email){
				///Update proprietaire
				$a_utlisateur=array('email'=>strtolower($this->request->data['email']),
																'portable'=>$this->request->data['portableNum1'],
																'date_update'=>Time::now()
																);
				$utilisateur=$this->Utilisateurs->patchEntity($info_prop, $a_utlisateur);
				$this->Utilisateurs->save($utilisateur);
				$id_loc=$utilisLocataire->id;
			}else{
				$nouveau=0;
				if(empty($res_uti->first())){
					$mdp_en_clair = $this->request->data['mdpenclair'];
					$a_utlisateur=array('email'=>strtolower($this->request->data['email']),
															'mot_passe'=>md5($mdp_en_clair),
															'prenom'=>$this->request->data['prenom'],
															'nom_famille'=>$this->request->data['nom'],
															'telephone'=>$this->request->data['portableNum2'],
															'portable'=>$this->request->data['portableNum1'],
															'pays'=>$this->request->data['pays'],
															'statut'=>"90",
															'ident'=>$this->request->data['email'],
															'nature'=>"CLT");
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
						$sendinblue->addContactToSendInBlue($utilisateur->email,$utilisateur->prenom,$utilisateur->nom_famille,$utilisateur->portable,null,$utilisateur->naissance,null,null,null, $this->Pays->get($utilisateur->pays)->fr ,'CLT');
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
					$this->loadModel("Registres");
					$mail = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]])->first();
					$url=Router::url(['controller' => 'Utilisateurs', 'action' => 'confirmuser','token'=>$token],true);
					
					$this->UtilisateursTokens->save($user_token);
					Log::write('emergency', 'Création compte (Reservation Manuelle) client : "'.$utilisateur->email.'"');
						
					$this->loadModel('BlocServicesMails');
					$bloc_services_mail_first = $this->BlocServicesMails->find()->where(["(liste_id_station LIKE '$info_ann->lieugeo_id;%' OR liste_id_station LIKE '%;$info_ann->lieugeo_id;%')"])->first();
					$this->loadModel("Photos");
      				$photo = $this->Photos->find()->where(['annonce_id' => $reservation->annonce_id])->order(['numero ASC'])->first();
					$nomImgG = $photo->titre;
					$urlimage1 = 'https://www.alpissime.com/images_ann/'.$reservationsynchro->annonce_id.'/'.$nomImgG;
					$desc160 = substr($annonce->description, 0, 160);
      				if(strlen($annonce->description) > 160) $desc160 = $desc160." ...";
					$natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
					$lannonce = $this->string2url($annonce["titre"]);
					$hrefDetailAnn = 'station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;
					
					$datamustache = [
                        'bloc_services_mail'    => $bloc_services_mail_first->bloc_services_mail,
                        'bloc_services_mail_en' => $bloc_services_mail_first->bloc_services_mail_en,
                        'url'                   => $url,
                        'annonce'               => $annonce->id,
                        'prenom'                => $utilisateur->prenom,
                        'nom'                   => $utilisateur->nom_famille,
                        'tel'                   => $utilisateur->portable,
                        'email'                 => $utilisateur->email,
                        'prenomprop'            => $info_prop->prenom,
                        'nomprop'               => $info_prop->nom_famille,
                        'nbrEnfant'             => $reservationsynchro->nb_enfants,
                        'nbrAdulte'             => $reservationsynchro->nb_adultes,
                        'debut'                 => $reservationsynchro->dbt_at,
                        'fin'                   => $reservationsynchro->fin_at,
                        'login'                 => $utilisateur->email,
                        'password'              => $mdp_en_clair,
                        'imageannonce'          => $urlimage1,
                        'description'           => $desc160,
                        'annonceURL'            => $mainURL . $hrefDetailAnn
                    ];

                    // #####################################################
                    $event = new Event('Email.send', $this,
                        [
                            'from'      => [$mail->val=>FROM_MAIL],
                            'to'        => $utilisateur,
                            'textEmail' => 'confirmationInscription',
                            'data'      => $datamustache,
                            'template'  => 'confirmationInscription',
                            'viewVars'  => 'confirmationInscription',
                            'noReply'   => false
                        ]
                    );
                    $this->eventManager()->dispatch($event);
					// #####################################################
                    $event = new Event('Email.send', $this,
                        [
                            'from'      => [$mail->val=>FROM_MAIL],
                            'to'        => $info_loc,
                            'textEmail' => 'creationCompteManuelle',
						    'data'      => array_merge($datamustache, ['reservationURL' => $mainURL . "reservations/view_reservation/" . $reservationsynchro->id]),
                            'template'  => 'creationCompteManuelle',
                            'viewVars'  => 'creationCompteManuelle',
                            'noReply'   => false
				   	    ]
                    );
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
                    $customer_lname = $this->request->data['nom']; // Nom du client
                    $password = $mdp_en_clair; // mot de passe
                    $group_id = 10;

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
				}else{
					$util=$res_uti->first();
					$id_loc=$util->id;
				}
			}
			// update reservation
			$datareservation = array("updated_at" => $this->toDate(date('d-m-Y')),
								"nb_enfants" => $this->request->data["enfant"],
								"nb_adultes" => $this->request->data["adult"],
								"comment" => $this->request->data["comment"],
								"utilisateur_id" => $id_loc);
			$reservation = $this->Reservations->patchEntity($reservationsynchro, $datareservation);
			if($this->Reservations->save($reservation)){
				// update dispos
				$this->loadModel("Dispos");
				$listedispos = $this->Dispos->find("all")->where(['reservation_id' => $reservationsynchro->id]);
				foreach ($listedispos as $dispo) {
					$datadispo = array("updated_at" => $this->toDate(date('d-m-Y')),
								"utilisateur_id" => $id_loc);
					$disponibilite = $this->Dispos->patchEntity($dispo, $datadispo);
					$this->Dispos->save($disponibilite);		
				}
			}
			$this->Flash->success(__('Votre réservation a bien été modifiée'),['clear'=> true]);
			return $this->redirect(["action"=>"view"]);
		}
	}
  /**
	 *
	 **/
	function reservationsProprietaire(){
			$path = Router::url('/', true);
			$l_reservationsstatuts=array('0'=>'<span class="text-warning">'.__("En attente de validation").'</span>','50'=>'<span class="text-warning">'.__("En attente de validation (payé)").'</span>','10'=>'<span class="text-danger">'.__("Refusée").'</span>','60'=>'<span class="text-danger">'.__("Supprimé (non payé)").'</span>','90'=>'<span class="text-success">'.__("Validee Proprietaire").'</span>', '100'=>'<span class="text-primary">'.__("Demande annulation en attente").'</span>','110'=>'<span class="text-danger">'.__("Annulée").'</span>');
			$this->loadModel("Utilisateurs");
			if($this->Auth->user('id') == ''){
				$session = $this->request->session();
				$idres = $session->read('Reserv.id');
				$this->loadModel("Annonces");
				$arrivee = $this->Annonces->find()
						->join([
							'utilisateur' => [
								'table' => 'utilisateurs',
								'type' => 'INNER',
								'conditions' => 'utilisateur.id = Annonces.proprietaire_id',
							]
						])
						->select(['utilisateur.id'])
						->where(["Annonces.id "=>$idres]);
				$utilis = $arrivee->first();
				$propid =$utilis['utilisateur']['id'];
				$res=$this->Reservations->getReservationsProprietaire($propid);
				$infoprop = $this->Utilisateurs->get($propid, ['contain'=>['Paiements']]);
			}else{
				$res=$this->Reservations->getReservationsProprietaire($this->Auth->user('id'));
				$infoprop = $this->Utilisateurs->get($this->Auth->user('id'), ['contain'=>['Paiements']]);
			}
			if($infoprop->nature == "PRES" && !empty($infoprop->paiements) && $infoprop->paiements[0]->taux_commission != 0) $tauxcommession = $infoprop->paiements[0]->taux_commission;
			else $tauxcommession = 3;
			$output = array(
                  "sEcho" => intval($_GET['sEcho']),
                  "iTotalRecords" => 4,
                  "iTotalDisplayRecords" => 4,
                  "aaData" => array()
                  );
			$new = new Date();
			foreach($res as $key=>$enr){
				$textannul = str_replace("'","`",__("En acceptant la réservation de {0}, vous vous êtes engagé à l'accueillir dans votre hébergement. Si vous annulez cette réservation, une pénalité de 50€ sera appliquée à votre compte. Êtes-vous sûr de vouloir l'annuler ?", [$enr->utilisateur['nom_famille']." ".$enr->utilisateur['prenom']]));
				$calendarsynchro_id = $enr['dispo']['calendarsynchro_id'];
				// $textannul = $enr->utilisateur['nom_famille']." ".$enr->utilisateur['prenom'];
				$row[0]=html_entity_decode($enr['annonce']['num_app']);
				$row[1]=$enr['lieugeo']['name']; 
				$row[2]=html_entity_decode($enr->utilisateur['nom_famille']." ".$enr->utilisateur['prenom']);
				$row[3]=$enr->dbt_at->i18nFormat('dd/MM/yy')." - ".$enr->fin_at->i18nFormat('dd/MM/yy');				       		
				if($enr->prixreservation == 0) $row[4]= round(($enr->total-($enr->total*$tauxcommession/100)), 2); 		
				else $row[4]=round(($enr->prixreservation-($enr->prixreservation*$tauxcommession/100)), 2);
				if($enr->inventaire_loc != "") $row[5]='<a onclick="aPlanPistes('.$enr->id.')" id="aPlanPistes"><i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></a>';
				else $row[5]='';
				if($enr->num_facture_commission != "") $row[6]='<a href="'.SITE_ALPISSIME.'facturecommission/facture_'.$enr->num_facture_commission.'_reservation_'.$enr->id.'.pdf" target="_blanck"><i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></a>';
				else $row[6]='';
				// $row[5]=$enr->utilisateur['email'];
				// if($enr->statut == 90 && $new < new Date($enr->fin_at->i18nFormat('dd-MM-yyyy'))){
				// 	$row[5]=$enr->utilisateur['email']."<br>".$enr->utilisateur['portable'];
				// }else{
					$row[7]='<button class="btn px-2 py-0" onclick="sendmsg('.$enr->id.')"><i class="fa fa-envelope-o fa-lg" aria-hidden="true"></i></button>';
					if($new <= new Date($enr->fin_at->i18nFormat('dd-MM-yyyy')) && $enr->statut != 100 && $enr->statut != 110 && $enr->statut != 10){
						$row[7] .= '<button class="btn px-2 py-0" onclick="showNumber('.$enr->id.')"><i class="fa fa-phone fa-lg" aria-hidden="true"></i></button>';
					}
				// }
				if($enr->statut == 90 && $enr['dispo']['calendarsynchro_id'] != 0){
					$row[8]='<span class="text-success">'.__("Validee Proprietaire").' ('.__("Synchronisée").')</span>';	
				}else{
					$row[8]=$l_reservationsstatuts[$enr->statut];	
				}
				
				if($new > new Date($enr->fin_at->i18nFormat('dd-MM-yyyy'))){
					$row[9]="";
				}else{
					if($enr->arrivee == 0 && $enr->statut != 100 && $enr->statut != 110 && $enr->statut != 10 && $enr->statut != 60){
						// if($enr->statut == 90 && $enr->type == 0){
						// 	$row[9]="<a title='Modifier' style='cursor:pointer' onclick='open_dialog(\"".$enr->id."\")' src='".$path."images/edit.png'><i class='fa fa-eye fa-lg'></i></a>";
						// }else{
							$row[9]="<div class='d-flex'><a title='Modifier' class='mr-3' style='cursor:pointer' onclick='open_dialog(\"".$enr->id."\")' src='".$path."images/edit.png'><i class='fa fa-eye fa-lg'></i></a><a title='Supprimer' style='cursor:pointer' onclick='open_dialog_delete(\"".$enr->id."\", \"".$enr->type."\", \"".$textannul."\", \"".$calendarsynchro_id."\")' src='".$path."images/delete.png'><i class='fa fa-times fa-lg'></i></a></div>";
						// }
					}else{
						if($enr->statut != 100 && $enr->statut != 110 && $enr->statut != 10 && $enr->statut != 60) $row[9]="<a title='Modifier' style='cursor:pointer' onclick='open_dialog(\"".$enr->id."\")' src='".$path."images/edit.png'><i class='fa fa-eye fa-lg'></i></a>";
						else $row[9]="";
					}
				}
				
				$output['aaData'][] = $row;
			}
			echo json_encode($output);die();
	}
    /**
     * Création (ou non) d'une nouvelle réservation
     *
     * Le client est inscrit, vient de choisir ses packs, à valider sa réservation.
     * -> Provoque un mail à destination du loueur
     *
     * Dans le cas où le client ne valide pas sa réservation, il est renvoyé
     * vers le détail de l'annonce
     */
    function add()
    {
        $session = $this->request->session();

        if (empty($this->request->data)) {
            $this->Flash->error(__("Anomalie au moment de l'enregistrement de votre réservation"),['clear'=> true]);
        } else {
            if (isset($this->request->data['annuler'])) {
                return $this->redirect(["action"=>"annule",$this->request->data["annonce_id"]]);
            }

            $id_reservation = $session->read("Reseservation.key");

            if (empty($id_reservation)) {
                $data = [
                    "annonce_id"       => $this->request->data["annonce_id"],
					"utilisateur_id"   => $this->request->data["utilisateur_id"],
					"statut"           => $this->request->data["statut"],
					"dbt_at"           => $this->toDate($this->request->data["dbt_at"]),
					"fin_at"           => $this->toDate($this->request->data["fin_at"]),
					"created_at"       => Time::now(),
					"updated_at"       => Time::now(),
					"nb_enfants"       => $this->request->data["nb_enfants"],
					"nb_adultes"       => $this->request->data["nb_adultes"],
					"prixapayer"       => $this->request->data["totalapayer"],
					"commentlocataire" => $this->request->data["commentlocataire"]
                ];

                $reservation = $this->Reservations->newEntity($data);

                if ($this->Reservations->save($reservation)) {
                    Log::write('info', 'Creation Reservation par locataire: reservationID: '.$reservation->id.'__debut: '.$this->request->data["dbt_at"].'__fin: '.$this->request->data["fin_at"].'__annonceID: '.$this->request->data["annonce_id"].'__locataireID: '.$this->request->data["utilisateur_id"]);

                    /** Enregistrer les numeros de telephone **/
					$this->loadModel("Reservationtelephone");
                    for ($x = 1; $x < $this->request->data["nb_adultes"]; $x++) {
						if($this->request->data['telephoneNum'.$x] != ''){
							$datatelres = [
                                "num_tel"        => $this->request->data['telephoneNum'.$x],
								"reservation_id" => $reservation->id
                            ];
							$restel = $this->Reservationtelephone->newEntity($datatelres);
							$this->Reservationtelephone->save($restel);
						}
					}
					/** Fin enregistrement tel **/
					/** MANIPULATION DES PERIODES DISPOS **/
					$this->loadModel("Dispos");

                    $data = [];
					$periodes = explode("-", $this->request->data["disposID"]);
					$evit = '';

                    if (count($periodes) == 1) {
                        $dispo=$this->Dispos->get($periodes[0]);

						if ((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($this->request->data["dbt_at"])) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) == new Date($this->request->data["fin_at"]))) {
						    /** METTRE A JOUR LA PERIODE DISPONIBLE **/
							$nbrDiffNew = (new Date($this->request->data["dbt_at"]))->diff(new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')))->days;
							$nbrDiffAjout = (new Date($this->request->data["fin_at"]))->diff(new Date($this->request->data["dbt_at"]))->days;
							$nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;

							if ($dispo->prix_jour == 0 && $dispo->prix != 0 ) {
								$data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
								$dataAjout["prix_jour"] = $data['prix_jour'];
								$data['prix'] = $data['prix_jour'] * $nbrDiffNew;
								$dataAjout["prix"] = $data['prix_jour'] * $nbrDiffAjout;
							} else {
								$dataAjout["prix_jour"] = $dispo->prix_jour;
								$data['prix'] = $dispo->prix_jour * $nbrDiffNew;
								$dataAjout["prix"] = $dispo->prix_jour * $nbrDiffAjout;
							}

							if ($dispo->promo_jour == 0 && $dispo->promo_px != 0 ) {
								$data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
								$dataAjout["promo_jour"] = $data['promo_jour'];
								$data['promo_px'] = $data['prix_jour'] * $nbrDiffNew;
								$dataAjout["promo_px"] = $data['prix_jour'] * $nbrDiffAjout;
							} else if($dispo->promo_yn == 1) {
								$dataAjout["promo_jour"] = $dispo->promo_jour;
								$data['promo_px'] = $dispo->promo_jour * $nbrDiffNew;
								$dataAjout["promo_px"] = $dispo->promo_jour * $nbrDiffAjout;
							} else {
								$dataAjout["promo_jour"] = $dispo->promo_jour;
								$dataAjout["promo_px"] = $dispo->promo_px;
							}

							$data["updated_at"] = $this->toDate(date('d-m-Y'));
							$data["fin_at"] = $this->toDate($this->request->data["dbt_at"]);
							$dispoModif = $this->Dispos->patchEntity($dispo, $data);

                            $this->Dispos->save($dispoModif);

							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
						} else if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) == new Date($this->request->data["dbt_at"])) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($this->request->data["fin_at"]))) {
						    /** METTRE A JOUR LA PERIODE DISPONIBLE **/
							$nbrDiffNew = (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')))->diff(new Date($this->request->data["fin_at"]))->days;
							$nbrDiffAjout = (new Date($this->request->data["fin_at"]))->diff(new Date($this->request->data["dbt_at"]))->days;
							$nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;

							if ($dispo->prix_jour == 0 && $dispo->prix != 0 ) {
								$data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
								$dataAjout["prix_jour"] = $data['prix_jour'];
								$data['prix'] = $data['prix_jour'] * $nbrDiffNew;
								$dataAjout["prix"] = $data['prix_jour'] * $nbrDiffAjout;
							} else {
								$dataAjout["prix_jour"] = $dispo->prix_jour;
								$data['prix'] = $dispo->prix_jour * $nbrDiffNew;
								$dataAjout["prix"] = $dispo->prix_jour * $nbrDiffAjout;
							}

							if ($dispo->promo_jour == 0 && $dispo->promo_px != 0 ) {
								$data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
								$dataAjout["promo_jour"] = $data['promo_jour'];
								$data['promo_px'] = $data['prix_jour'] * $nbrDiffNew;
								$dataAjout["promo_px"] = $data['prix_jour'] * $nbrDiffAjout;
							} else if($dispo->promo_yn == 1) {
								$dataAjout["promo_jour"] = $dispo->promo_jour;
								$data['promo_px'] = $dispo->promo_jour * $nbrDiffNew;
								$dataAjout["promo_px"] = $dispo->promo_jour * $nbrDiffAjout;
							} else {
								$dataAjout["promo_jour"] = $dispo->promo_jour;
								$dataAjout["promo_px"] = $dispo->promo_px;
							}

							$data["updated_at"] = $this->toDate(date('d-m-Y'));
							$data["dbt_at"] = $this->toDate($this->request->data["fin_at"]);
							$dispoModif = $this->Dispos->patchEntity($dispo, $data);
                            $this->Dispos->save($dispoModif);

							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
						} else if ((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) == new Date($this->request->data["dbt_at"])) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) == new Date($this->request->data["fin_at"]))) {
						    $evit = 'EviterAjout';
							/** METTRE A JOUR LA PERIODE DISPONIBLE **/
							$nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;

							if ($dispo->prix_jour == 0 && $dispo->prix != 0 ) {
								$data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
							}

							if ($dispo->promo_jour == 0 && $dispo->promo_px != 0 ) {
								$data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
							}

							$data["updated_at"] = $this->toDate(date('d-m-Y'));
							$data["statut"] = 50;
							$data["utilisateur_id"] = $this->request->data["utilisateur_id"];
							$data["reservation_id"] = $reservation->id;
							$dispoModif = $this->Dispos->patchEntity($dispo, $data);
                            $this->Dispos->save($dispoModif);

							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
						} else if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($this->request->data["dbt_at"])) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($this->request->data["fin_at"]))) {
							/** METTRE A JOUR LA PERIODE DISPONIBLE **/
							$nbrDiffNew = (new Date($this->request->data["dbt_at"]))->diff(new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')))->days;
							$nbrDiffAjout = (new Date($this->request->data["fin_at"]))->diff(new Date($this->request->data["dbt_at"]))->days;
							$nbrDiffNew2 = (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')))->diff(new Date($this->request->data["fin_at"]))->days;
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
							$data["fin_at"] = $this->toDate($this->request->data["dbt_at"]);
							$dispoModif = $this->Dispos->patchEntity($dispo, $data);
                            $this->Dispos->save($dispoModif);

							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);

							$data2["annonce_id"] = $this->request->data["annonce_id"];
							$data2["created_at"] = $this->toDate(date('d-m-Y'));
							$data2["updated_at"] = $this->toDate(date('d-m-Y'));
							$data2["dbt_at"] = $this->toDate($this->request->data["fin_at"]);
							$data2["statut"] = 0;
							$dispo2 = $this->Dispos->newEntity($data2);
                            $this->Dispos->save($dispo2);

							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispo2->id.'__debut: '.$dispo2->dbt_at.'__fin: '.$dispo2->fin_at.'__reservationID: '.$reservation->id);
						}

						if($evit == ''){
							/** AJOUTER LA PERIODE RESERVEE **/
							$dataAjout["annonce_id"] = $this->request->data["annonce_id"];
							$dataAjout["created_at"] = $this->toDate(date('d-m-Y'));
							$dataAjout["updated_at"] = $this->toDate(date('d-m-Y'));
							$dataAjout["dbt_at"] = $this->toDate($this->request->data["dbt_at"]);
							$dataAjout["fin_at"] = $this->toDate($this->request->data["fin_at"]);
							$dataAjout["statut"] = 50;
							$dataAjout["utilisateur_id"] = $this->request->data["utilisateur_id"];
							$dataAjout["promo_yn"] = $dispo->promo_yn;
							$dataAjout["reservation_id"] = $reservation->id;
							$dataAjout["nbr_jour"] = $dispo->nbr_jour;

							$dispoAjout = $this->Dispos->newEntity($dataAjout);
                            $this->Dispos->save($dispoAjout);

							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id);
						}
					} else {
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
							$data["statut"] = 50;
							$data["utilisateur_id"] = $this->request->data["utilisateur_id"];
							$data["reservation_id"] = $reservation->id;
							$dispoModif = $this->Dispos->patchEntity($disporeser, $data);
                            $this->Dispos->save($dispoModif);

							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
						}
						/** TESTS SUR DEBUT **/
						$detper = explode("_", $periodes[0]);
						$disres=$this->Dispos->get($detper[0]);
						if(new Date($disres->dbt_at->i18nFormat('dd-MM-yyyy')) == new Date($this->request->data["dbt_at"])){
							$nbrDiff = $disres->fin_at->diff($disres->dbt_at)->days;
							if($disres->prix_jour == 0 && $disres->prix != 0 ){
								$datad['prix_jour'] = round(($disres->prix/$nbrDiff), 2);
							}
							if($disres->promo_jour == 0 && $disres->promo_px != 0 ){
								$datad['promo_jour'] = round(($disres->promo_px/$nbrDiff), 2);
							}
							$datad["updated_at"] = $this->toDate(date('d-m-Y'));
							$datad["statut"] = 50;
							$datad["utilisateur_id"] = $this->request->data["utilisateur_id"];
							$datad["reservation_id"] = $reservation->id;
							$dispoModif = $this->Dispos->patchEntity($disres, $datad);
                            $this->Dispos->save($dispoModif);

							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);

						}else if(new Date($disres->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($this->request->data["dbt_at"])){
							$date = Time::createFromFormat('d/m/Y', $detper[2]);
							$dd = $date->format('d-m-Y');
							$nbrDiffNew = (new Date($dd))->diff(new Date($this->request->data["dbt_at"]))->days;
							$nbrDiffAjout = (new Date($this->request->data["dbt_at"]))->diff(new Date($disres->dbt_at->i18nFormat('dd-MM-yyyy')))->days;
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
							$datadd["dbt_at"] = $this->toDate($this->request->data["dbt_at"]);
							$dataAjout["annonce_id"] = $this->request->data["annonce_id"];
							$dataAjout["created_at"] = $this->toDate(date('d-m-Y'));
							$dataAjout["updated_at"] = $this->toDate(date('d-m-Y'));
							$dataAjout["dbt_at"] = $this->toDate($disres->dbt_at);
							$dataAjout["fin_at"] = $this->toDate($this->request->data["dbt_at"]);
							$dataAjout["statut"] = 0;
							$datadd["statut"] = 50;
							$datadd["utilisateur_id"] = $this->request->data["utilisateur_id"];
							$dataAjout["promo_yn"] = $disres->promo_yn;
							$datadd["reservation_id"] = $reservation->id;
							$dataAjout["nbr_jour"] = $disres->nbr_jour;

							$dispoAjout = $this->Dispos->newEntity($dataAjout);
	            $this->Dispos->save($dispoAjout);
							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id);

							$dispoModif = $this->Dispos->patchEntity($disres, $datadd);
	            $this->Dispos->save($dispoModif);
							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
						}
						/** TESTS SUR FIN **/
						$detper = explode("_", $periodes[count($periodes)-2]);
						$disres=$this->Dispos->get($detper[0]);

						if(new Date($disres->fin_at->i18nFormat('dd-MM-yyyy')) == new Date($this->request->data["fin_at"])){
							$nbrDiff = $disres->fin_at->diff($disres->dbt_at)->days;
							if($disres->prix_jour == 0 && $disres->prix != 0 ){
								$datad2['prix_jour'] = round(($disres->prix/$nbrDiff), 2);
							}
							if($disres->promo_jour == 0 && $disres->promo_px != 0 ){
								$datad2['promo_jour'] = round(($disres->promo_px/$nbrDiff), 2);
							}
							$datad2["updated_at"] = $this->toDate(date('d-m-Y'));
							$datad2["statut"] = 50;
							$datad2["utilisateur_id"] = $this->request->data["utilisateur_id"];
							$datad2["reservation_id"] = $reservation->id;
							$dispoModif = $this->Dispos->patchEntity($disres, $datad2);
	            $this->Dispos->save($dispoModif);
							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);

						}else if(new Date($disres->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($this->request->data["fin_at"])){

							$date = Time::createFromFormat('d/m/Y', $detper[1]);
							$dd = $date->format('d-m-Y');
							$nbrDiffNew = (new Date($this->request->data["fin_at"]))->diff(new Date($dd))->days;
							$nbrDiffAjout = (new Date($disres->fin_at->i18nFormat('dd-MM-yyyy')))->diff(new Date($this->request->data["fin_at"]))->days;
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
							$datadd2["fin_at"] = $this->toDate($this->request->data["fin_at"]);

							$dataAjoutd2["annonce_id"] = $this->request->data["annonce_id"];
							$dataAjoutd2["created_at"] = $this->toDate(date('d-m-Y'));
							$dataAjoutd2["updated_at"] = $this->toDate(date('d-m-Y'));
							$dataAjoutd2["dbt_at"] = $this->toDate($this->request->data["fin_at"]);
							$dataAjoutd2["fin_at"] = $this->toDate($disres->fin_at);
							$dataAjoutd2["statut"] = 0;
							$datadd2["statut"] = 50;
							$datadd2["utilisateur_id"] = $this->request->data["utilisateur_id"];
							$dataAjoutd2["promo_yn"] = $disres->promo_yn;
							$datadd2["reservation_id"] = $reservation->id;
							$dataAjoutd2["nbr_jour"] = $disres->nbr_jour;

							$dispoAjout = $this->Dispos->newEntity($dataAjoutd2);
	            $this->Dispos->save($dispoAjout);
							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id);

							$dispoModif = $this->Dispos->patchEntity($disres, $datadd2);
	            $this->Dispos->save($dispoModif);
							Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);

						}
					}
					/** FIN **/
					$session->write("Reseservation.key","addReservation");
					$this->loadModel("Utilisateurs");
					$this->loadModel("Annonces");
					$user = $this->Utilisateurs->get($this->request->data['proprietaire_id']);
					$locataire = $this->Utilisateurs->get($this->request->data['utilisateur_id']);
					$annonce = $this->Annonces->get($this->request->data['annonce_id']);
					$this->loadModel("Registres");
					$this->loadModel("Lieugeos");
					$lieugeo=$this->Lieugeos->get($annonce->lieugeo_id);

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
                        'blockreduction' => $this->request->data['creationReservationLocpaiementdirectHidden']
                    ];
                                        
					$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
					$mail=$mails->first();
					// if(!empty($annonce->contrat)||!empty($annonce->mise_relation)){
					// récupération de l'adresse mail de l'administrateur
					if ($annonce->paiement_reservation == 0) {
					    // #####################################################
						$event = new Event('Email.send', $this,
                            [
                                'from'      => [$mail->val=>FROM_MAIL],
                                'to'        => $user,
                                'textEmail' => 'creationReservation',
								'data'      => $datamustache,
                                'template'  => 'creationReservation',
                                'viewVars'  => 'creationReservation',
                                'noReply'   => false
                            ]
                        );
						$this->eventManager()->dispatch($event);
						// #####################################################
					} else {
					    // #####################################################
						$event = new Event('Email.send', $this,
                            [
                                'from'      => [$mail->val=>FROM_MAIL],
                                'to'        => $user,
                                'textEmail' => 'creationReservationpaiementdirect',
								'data'      => $datamustache,
                                'template'  => 'creationReservation',
                                'viewVars'  => 'creationReservation',
                                'noReply'   => false
                            ]
                        );
						$this->eventManager()->dispatch($event);
						// #####################################################
					}
						
					// }else{
                    //                         // #####################################################
                    //                         $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $user,'textEmail'=>'creationReservationNoContrat',
                    //                                                                  'data'=>$datamustache,'template'=>'creationReservationNoContrat','viewVars'=>'creationReservationNoContrat','noReply'=>false]);
                    //                         $this->eventManager()->dispatch($event);
                    //                         // #####################################################
					// 	}
					//mail pour le locataire qu'il à fait une demande de reservation
					if ($annonce->paiement_reservation == 0) {
						// #####################################################
						$event = new Event('Email.send', $this,
                            [
                                'from'      => [$mail->val=>FROM_MAIL],
                                'to'        => $locataire,
                                'textEmail' => 'creationReservationLoc',
								'data'      => array_merge($datamustache, ['reservationURL' => Router::url('/', true) . "reservations/view_reservation/" . $reservation->id]),
                                'template'  => 'creationReservationLoc',
                                'viewVars'  => 'creationReservationLoc',
                                'noReply'   => false
                            ]
                        );
						$this->eventManager()->dispatch($event);
						// #####################################################

						// #####################################################
						$event = new Event('Email.send', $this,
                            [
                                'from'      => $user->email,
                                'to'        => $mail->val,
                                'textEmail' => 'creationReservationAdm',
								'data'      => $datamustache,
                                'template'  => 'creationReservationAdm',
                                'viewVars'  => 'creationReservationAdm',
                                'noReply'   => false
                            ]
                        );
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
							$event = new Event('Email.send', $this,
                                [
                                    'from'      => $user->email,
                                    'to'        => $gestio->email,
                                    'textEmail' => 'creationReservationAdm',
									'data'      => $datamustache,
                                    'template'  => 'creationReservationAdm',
                                    'viewVars'  => 'creationReservationAdm',
                                    'noReply'   => false
                                ]
                            );
							$this->eventManager()->dispatch($event);
						}
					}else{
						// #####################################################
						$event = new Event('Email.send', $this,
                            [
                                'from'      => [$mail->val=>FROM_MAIL],
                                'to'        => $locataire,
                                'textEmail' => 'creationReservationLocpaiementdirect',
								'data'      => array_merge($datamustache, ['reservationURL' => Router::url('/', true) . "reservations/view_reservation/" . $reservation->id]),
                                'template'  => 'creationReservationLoc',
                                'viewVars'  => 'creationReservationLoc',
                                'noReply'   => false
                            ]
                        );
						$this->eventManager()->dispatch($event);
						// #####################################################
						
						// #####################################################
						$event = new Event('Email.send', $this,
                            [
                                'from'      => $user->email,
                                'to'        => $mail->val,
                                'textEmail' => 'creationReservationAdmpaiementdirect',
								'data'      => $datamustache,
                                'template'  => 'creationReservationAdm',
                                'viewVars'  => 'creationReservationAdm',
                                'noReply'   => false
                            ]
                        );
						$this->eventManager()->dispatch($event);
						// #####################################################
					}
					/* Ajout Enregistrement googlecalendar en cas paiement direct */
					if($annonce->paiement_reservation == 1){
						if(PROD_ON == 1){
							/*** ADD GOOGLE CALENDAR ***/
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
							/*** END ADD GOOGLE CALENDAR ***/ 
						}
					}
					/* FIN Ajout Enregistrement googlecalendar en cas paiement direct */
					
				} else {
					$this->Flash->error(__("Votre Réservation n'a pas été créée"),['clear'=> true]);
					return $this->redirect(["controller"=>"annonces","action"=>"view",$this->request->data["annonce_id"]]);
				}
			}
    }
  }
  /**
   * Edit method
   *
   * @param string|null $id Reservation id.
   * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Network\Exception\NotFoundException When record not found.
   */
  public function edit($id = null){
		$reservation = $this->Reservations->get($id, ['contain' => ['Packs']]);
    if ($this->request->is(['patch', 'post', 'put'])) {
        $reservation = $this->Reservations->patchEntity($reservation, $this->request->data);
        if ($this->Reservations->save($reservation)) {
            // $this->Flash->success(__('The reservation has been saved.'),['clear'=> true]);
						Log::write('info', 'Edit Reservation: reservationID: '.$reservation->id);
            return $this->redirect(['action' => 'index']);
        } else {
            // $this->Flash->error(__('The reservation could not be saved. Please, try again.'),['clear'=> true]);
        }
    }
    $annonces = $this->Reservations->Annonces->find('list', ['limit' => 200]);
    $utilisateurs = $this->Reservations->Utilisateurs->find('list', ['limit' => 200]);
    $packs = $this->Reservations->Packs->find('list', ['limit' => 200]);
    $this->set(compact('reservation', 'annonces', 'utilisateurs', 'packs'));
    $this->set('_serialize', ['reservation']);
  }
  /**
   * Delete method
   *
   * @param string|null $id Reservation id.
   * @return \Cake\Network\Response|null Redirects to index.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function delete($id = null){
      $this->request->allowMethod(['post', 'delete']);
	  $reservation = $this->Reservations->get($id);
	  $dataannulreserv = array("statut"=>10);
	  $reservationannul=$this->Reservations->patchEntity($reservation,$dataannulreserv);		
      if ($this->Reservations->save($reservationannul)) {
				Log::write('info', 'Suppression Reservation (delete): reservationID: '.$id);
				$this->loadModel("Dispos");
				$dispos=$this->Dispos->find('all')->where(['Dispos.reservation_id'=>$id]);
				foreach ($dispos as $dispo) {
					$a_dispo=array('statut'=>0,'utilisateur_id'=>null,'reservation_id'=>null);
					$dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
					$this->Dispos->save($dispo);
					Log::write('info', 'Suppression Reservation + Dispos (delete): reservationID: '.$id.'__modifDispoID: '.$dispo->id);
				}
          $this->Flash->success(__('La réservation a été supprimée.'),['clear'=> true]);
      } else {
          $this->Flash->error(__('La réservation ne peut pas etre supprimée. Essayez une autre fois.'),['clear'=> true]);
      }
      return $this->redirect(['action' => 'index']);
  }
  /**
   * 
   */
  public function addreservation($reservationData, $disposID, $proprietaire_id, $creationReservationLocpaiementdirectHidden)
  {
      $dbt_at = $reservationData['dbt_at'];
      $fin_at = $reservationData['fin_at'];
      $reservationData['dbt_at'] = $this->toDate($dbt_at);
      $reservationData['fin_at'] = $this->toDate($fin_at);
	$session = $this->request->session();
		$reservation = $this->Reservations->newEntity($reservationData);

	if($idreserv = $this->Reservations->save($reservation)){
		Log::write('info', 'Creation Reservation par locataire: reservationID: '.$reservation->id.'__debut: '.$dbt_at.'__fin: '.$fin_at.'__annonceID: '.$reservationData["annonce_id"].'__locataireID: '.$reservationData["utilisateur_id"]);
		
		/** MANIPULATION DES PERIODES DISPOS **/
		$this->loadModel("Dispos");
		$data = array();
		$periodes = explode("-", $disposID);
		$evit = '';
        if(count($periodes) == 1){
			$dispo=$this->Dispos->get($periodes[0]);
			if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($dbt_at)) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) == new Date($fin_at)))
			{
				/** METTRE A JOUR LA PERIODE DISPONIBLE **/
				$nbrDiffNew = (new Date($dbt_at))->diff(new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')))->days;
				$nbrDiffAjout = (new Date($fin_at))->diff(new Date($dbt_at))->days;
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
				$data["fin_at"] = $this->toDate($dbt_at);
				$dispoModif = $this->Dispos->patchEntity($dispo, $data);
				$this->Dispos->save($dispoModif);
				Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
			}else if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) == new Date($dbt_at)) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($fin_at)))
			{
                /** METTRE A JOUR LA PERIODE DISPONIBLE **/
				$nbrDiffNew = (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')))->diff(new Date($fin_at))->days;
				$nbrDiffAjout = (new Date($fin_at))->diff(new Date($dbt_at))->days;
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
				$data["dbt_at"] = $this->toDate($fin_at);
				$dispoModif = $this->Dispos->patchEntity($dispo, $data);
				$this->Dispos->save($dispoModif);
				Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
			}else if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) == new Date($dbt_at)) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) == new Date($fin_at)))
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
				$data["statut"] = 50;
				$data["utilisateur_id"] = $reservationData["utilisateur_id"];
				$data["reservation_id"] = $reservation->id;
				$dispoModif = $this->Dispos->patchEntity($dispo, $data);
				$this->Dispos->save($dispoModif);
				Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
			}else if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($dbt_at)) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($fin_at)))
			{
                /** METTRE A JOUR LA PERIODE DISPONIBLE **/
				$nbrDiffNew = (new Date($dbt_at))->diff(new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')))->days;
				$nbrDiffAjout = (new Date($fin_at))->diff(new Date($dbt_at))->days;
				$nbrDiffNew2 = (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')))->diff(new Date($fin_at))->days;
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
				$data["fin_at"] = $this->toDate($dbt_at);
				$dispoModif = $this->Dispos->patchEntity($dispo, $data);
				$this->Dispos->save($dispoModif);
				Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);

				$data2["annonce_id"] = $reservationData["annonce_id"];
				$data2["created_at"] = $this->toDate(date('d-m-Y'));
				$data2["updated_at"] = $this->toDate(date('d-m-Y'));
				$data2["dbt_at"] = $this->toDate($fin_at);
				$data2["statut"] = 0;
				$dispo2 = $this->Dispos->newEntity($data2);
				$this->Dispos->save($dispo2);
				Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispo2->id.'__debut: '.$dispo2->dbt_at.'__fin: '.$dispo2->fin_at.'__reservationID: '.$reservation->id);
			}
            if($evit == ''){
                /** AJOUTER LA PERIODE RESERVEE **/
				$dataAjout["annonce_id"] = $reservationData["annonce_id"];
				$dataAjout["created_at"] = $this->toDate(date('d-m-Y'));
				$dataAjout["updated_at"] = $this->toDate(date('d-m-Y'));
				$dataAjout["dbt_at"] = $this->toDate($dbt_at);
				$dataAjout["fin_at"] = $this->toDate($fin_at);
				$dataAjout["statut"] = 50;
				$dataAjout["utilisateur_id"] = $reservationData["utilisateur_id"];
				$dataAjout["promo_yn"] = $dispo->promo_yn;
				$dataAjout["reservation_id"] = $reservation->id;
				$dataAjout["nbr_jour"] = $dispo->nbr_jour;
                if (!isset($dataAjout["prix_jour"])) {
                    $dataAjout["prix_jour"] = $dispo->prix_jour;
                }
                $dispoAjout = $this->Dispos->newEntity($dataAjout);
                $this->Dispos->save($dispoAjout);
                Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id);
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
				$data["statut"] = 50;
				$data["utilisateur_id"] = $reservationData["utilisateur_id"];
				$data["reservation_id"] = $reservation->id;
				$dispoModif = $this->Dispos->patchEntity($disporeser, $data);
				$this->Dispos->save($dispoModif);
				Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
			}
			/** TESTS SUR DEBUT **/
			$detper = explode("_", $periodes[0]);
			$disres=$this->Dispos->get($detper[0]);
			if(new Date($disres->dbt_at->i18nFormat('dd-MM-yyyy')) == new Date($dbt_at)){
				$nbrDiff = $disres->fin_at->diff($disres->dbt_at)->days;
				if($disres->prix_jour == 0 && $disres->prix != 0 ){
					$datad['prix_jour'] = round(($disres->prix/$nbrDiff), 2);
				}
				if($disres->promo_jour == 0 && $disres->promo_px != 0 ){
					$datad['promo_jour'] = round(($disres->promo_px/$nbrDiff), 2);
				}
				$datad["updated_at"] = $this->toDate(date('d-m-Y'));
				$datad["statut"] = 50;
				$datad["utilisateur_id"] = $reservationData["utilisateur_id"];
				$datad["reservation_id"] = $reservation->id;
				$dispoModif = $this->Dispos->patchEntity($disres, $datad);
				$this->Dispos->save($dispoModif);
				Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);

			}else if(new Date($disres->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($dbt_at)){
				$date = Time::createFromFormat('d/m/Y', $detper[2]);
				$dd = $date->format('d-m-Y');
				$nbrDiffNew = (new Date($dd))->diff(new Date($dbt_at))->days;
				$nbrDiffAjout = (new Date($dbt_at))->diff(new Date($disres->dbt_at->i18nFormat('dd-MM-yyyy')))->days;
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
				$datadd["dbt_at"] = $this->toDate($dbt_at);
				$dataAjout["annonce_id"] = $reservationData["annonce_id"];
				$dataAjout["created_at"] = $this->toDate(date('d-m-Y'));
				$dataAjout["updated_at"] = $this->toDate(date('d-m-Y'));
				$dataAjout["dbt_at"] = $this->toDate($disres->dbt_at);
				$dataAjout["fin_at"] = $this->toDate($dbt_at);
				$dataAjout["statut"] = 0;
				$datadd["statut"] = 50;
				$datadd["utilisateur_id"] = $reservationData["utilisateur_id"];
				$dataAjout["promo_yn"] = $disres->promo_yn;
				$datadd["reservation_id"] = $reservation->id;
				$dataAjout["nbr_jour"] = $disres->nbr_jour;

				$dispoAjout = $this->Dispos->newEntity($dataAjout);
				$this->Dispos->save($dispoAjout);
				Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id);

				$dispoModif = $this->Dispos->patchEntity($disres, $datadd);
				$this->Dispos->save($dispoModif);
				Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
			}
			/** TESTS SUR FIN **/
			$detper = explode("_", $periodes[count($periodes)-2]);
			$disres=$this->Dispos->get($detper[0]);

			if(new Date($disres->fin_at->i18nFormat('dd-MM-yyyy')) == new Date($fin_at)){
				$nbrDiff = $disres->fin_at->diff($disres->dbt_at)->days;
				if($disres->prix_jour == 0 && $disres->prix != 0 ){
					$datad2['prix_jour'] = round(($disres->prix/$nbrDiff), 2);
				}
				if($disres->promo_jour == 0 && $disres->promo_px != 0 ){
					$datad2['promo_jour'] = round(($disres->promo_px/$nbrDiff), 2);
				}
				$datad2["updated_at"] = $this->toDate(date('d-m-Y'));
				$datad2["statut"] = 50;
				$datad2["utilisateur_id"] = $reservationData["utilisateur_id"];
				$datad2["reservation_id"] = $reservation->id;
				$dispoModif = $this->Dispos->patchEntity($disres, $datad2);
				$this->Dispos->save($dispoModif);
				Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);

			}else if(new Date($disres->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($fin_at)){

				$date = Time::createFromFormat('d/m/Y', $detper[1]);
				$dd = $date->format('d-m-Y');
				$nbrDiffNew = (new Date($fin_at))->diff(new Date($dd))->days;
				$nbrDiffAjout = (new Date($disres->fin_at->i18nFormat('dd-MM-yyyy')))->diff(new Date($fin_at))->days;
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
				$datadd2["fin_at"] = $this->toDate($fin_at);

				$dataAjoutd2["annonce_id"] = $reservationData["annonce_id"];
				$dataAjoutd2["created_at"] = $this->toDate(date('d-m-Y'));
				$dataAjoutd2["updated_at"] = $this->toDate(date('d-m-Y'));
				$dataAjoutd2["dbt_at"] = $this->toDate($fin_at);
				$dataAjoutd2["fin_at"] = $this->toDate($disres->fin_at);
				$dataAjoutd2["statut"] = 0;
				$datadd2["statut"] = 50;
				$datadd2["utilisateur_id"] = $reservationData["utilisateur_id"];
				$dataAjoutd2["promo_yn"] = $disres->promo_yn;
				$datadd2["reservation_id"] = $reservation->id;
				$dataAjoutd2["nbr_jour"] = $disres->nbr_jour;

				$dispoAjout = $this->Dispos->newEntity($dataAjoutd2);
				$this->Dispos->save($dispoAjout);
				Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id);

				$dispoModif = $this->Dispos->patchEntity($disres, $datadd2);
				$this->Dispos->save($dispoModif);
				Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);

			}
		}
		/** FIN **/
		$session->write("Reseservation.key","addReservation");
		$this->loadModel("Utilisateurs");
		$this->loadModel("Annonces");
		$user = $this->Utilisateurs->get($proprietaire_id);
        $locataire = $this->Utilisateurs->get($reservationData["utilisateur_id"]);
		$annonce = $this->Annonces->get($reservationData["annonce_id"]);
		$this->loadModel("Registres");
		$this->loadModel("Lieugeos");
		$lieugeo=$this->Lieugeos->get($annonce->lieugeo_id);

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
		
		//mail pour le locataire qu'il à fait une demande de reservation
		// #####################################################
		$event = new Event('Email.send', $this, [
            'from'=>[$mail->val=>FROM_MAIL],
            'to' => $locataire,
            'textEmail'=>'creationReservationLoc',
		 	'data'=>$datamustache,
            'template'=>'creationReservationLoc',
            'viewVars'=>'creationReservationLoc',
            'noReply'=>false
        ]);
		$this->eventManager()->dispatch($event);
		// #####################################################
	}

	return $idreserv->id;
  }

    /**
     *
     **/
    public function confirmreservations()
    {
        $this->viewBuilder()->layout(false);

        /*** TRAITER LA PERIODE DEMANDER *****/
        $this->loadModel("Dispos");
        $perid = explode("/", $this->request->data["sel"]);

        // X fois
        $this->loadModel("Utilisateurs");
        $this->loadModel("Annonces");

        $annonce = $this->Annonces->get($this->request->data["annonce_id"]);
        $propreglepaiement = $this->Utilisateurs->get($annonce->proprietaire_id, ['contain' => 'Paiements']);

        if($propreglepaiement->nature == "PRES" && !empty($propreglepaiement->paiements)){
            $nbr_jour = $propreglepaiement->paiements[0]->nbr_jour;
            $date_sub_15_days = (new Date($perid[0]))->modify( '-'.$nbr_jour.' days' );
        }else{
            $date_sub_15_days = (new Date($perid[0]))->modify( '-15 days' );
        }
        $date_sub_15_days = (new Date($perid[0]))->modify( '-15 days' );
        $diff_date_and_today = ($date_sub_15_days)->diff(new Date());

        $Number_of_installment_Value = $diff_date_and_today->m;
        if($Number_of_installment_Value > 4) {
            $Number_of_installment_Value = 4;
        }
        $this->set("Xfois", $Number_of_installment_Value);
        // End X fois

        $dispo = $this->Dispos->chercherdisponibilite($this->request->data["annonce_id"], $perid[0], $perid[1]);
        $dispoCount = $this->Dispos->chercherdisponibiliteCount($this->request->data["annonce_id"], $perid[0], $perid[1]);

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
        $this->set("resultatDetail",$resultatDetail);

        $mail = [];
        $this->loadModel("Modelmailsysteme");
        $textEmail = $this->Modelmailsysteme->find('all');
        foreach ($textEmail as $key => $value) {
            $mail[$value->titre] = $value->txtmail;
        }
        $this->set("textmail",$mail);

        $session = $this->request->session();
        $id_utilisateur=$session->read('Auth.User.id');
        $utilisateur = $this->Utilisateurs->get($id_utilisateur);

        $this->loadModel("Lieugeos");
        $this->loadModel("Packs");
        $proprietaire = $this->Utilisateurs->get($annonce->proprietaire_id);
        // $this->set("proprietaire", $proprietaire);
        $lieugeo = $this->Lieugeos->get($annonce->lieugeo_id);
        // $packs = $this->Packs->find("all");
        // $this->set(compact("annonce","packs","lieugeo","utilisateur"));
        // $this->set("totalapayer", $this->request->data['totalapayer']);
        // $this->set("nbradultehidden", $this->request->data['nbradultehidden']);
        // $this->set("nbrenfanthidden", $this->request->data['nbrenfanthidden']);

        $apporteranimaux = 0;
        if($this->request->data["apporteranimauxhidden"]) $apporteranimaux = $this->request->data["apporteranimauxhidden"];

        // Créer la réservation
        $createdAt = Time::now();
        $reservationData = [
            "annonce_id"      => $this->request->data["annonce_id"],
            "utilisateur_id"  => $id_utilisateur,
            "statut"          => 0,
            "dbt_at"          => $resultatDetail['du']->i18nFormat('dd-MM-yyyy'),
            "fin_at"          => $resultatDetail['au']->i18nFormat('dd-MM-yyyy'),
            "created_at"      => $createdAt,
            "updated_at"      => $createdAt,
            "nb_enfants"      => $this->request->data['nbrenfanthidden'],
            "nb_adultes"      => $this->request->data['nbradultehidden'],
            "prixapayer"      => $this->request->data['totalapayer'],
            "prixreservation" => $this->request->data['prixreservation'],
            "prixtaxesejour"  => $this->request->data['prixtaxesejour'],
            "prixfraiservice" => $this->request->data['prixfraiservice'],
            "apporteranimaux" => $apporteranimaux
        ];

        $IDreserv = $this->addreservation($reservationData, $resultatDetail['dispoID'], $annonce->proprietaire_id, '');
        $this->set("IDreserv", $IDreserv);
    }
	/**
	 * 
	 */
	public function ajoutreservationpanier()
	{
		// Configure::write('debug', 2);
		$this->viewBuilder()->layout(false);
		$reservDetail = $this->Reservations->get($this->request->data['IDreserv'], ['contain' => ['Utilisateurs','Annonces'=>'Villages']]);
		// Code boutique ajout reservation panier
		//**** informations a utiliser toujours ********************//
		// $station = "fr";
		$station = $reservDetail['annonce']['village']['input_boutique'];
        $data_string = json_encode(["username" => "API.ACCESS", "password" => "86>;];wzO+Q#"]);
        $tokenUrl = BOUTIQUE_ALPISSIME . "index.php/rest/" . $station . "/V1/integration/admin/token";
        $ch = curl_init($tokenUrl);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Length: " . strlen($data_string)));
		$token = curl_exec($ch);
		$token = json_decode($token);
        $headers = ["Authorization: Bearer " . $token];
		//************************* Recherche du client ***********************************//
		$customeremail = $reservDetail['utilisateur']['email'];  // email du client ( il faut bien verifier q"il existe sinon il faut le créer
        $customerSearchUrl = BOUTIQUE_ALPISSIME . '/rest/' . $station . '/V1/customers/search?searchCriteria[filter_groups][0][filters][0][field]=email&searchCriteria[filter_groups][0][filters][0][value]=%25' . $customeremail . '%25&searchCriteria[filter_groups][0][filters][0][condition_type]=like';
        $ch = curl_init($customerSearchUrl);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
		$result = curl_exec($ch);
		$customer = json_decode($result, true);
        if ($customer['total_count'] != 0) {
			$id = $customer['items'][0]['id'];
			/**** MODIFICATION ADRESSE LIVRAISON SUR BOUTIQUE ****/
            $resultatregionshipping = $this->getRegType($reservDetail['annonce']['region']);
            $this->loadModel('Pays');
            $payscode = $this->Pays->get($reservDetail['annonce']["pays"]);
            $this->loadModel('Residences');
            $residence = $this->Residences->get($reservDetail['annonce']['batiment']);
            $this->loadModel('Villages');
            $village = $this->Villages->get($reservDetail['annonce']['village']['id']);
            $adressefacture = $reservDetail['annonce']['num_app'].", ".$residence->name.", ".$village->name.", ".$station->name;
            $this->loadModel('Frvilles');
            $villeLivraison = $this->Frvilles->get($reservDetail['annonce']['ville']);
            
			if($reservDetail['utilisateur']['prenom'] == '') $customer_fname = "_";
			else $customer_fname = $reservDetail['utilisateur']['prenom'] ; // prenom du client
			$customer_lname = $reservDetail['utilisateur']['nom_famille']; // Nom du client

            $customerAddress = [
             'data' => [
                 'customerId' => $id,
                 'street' => $adressefacture
             ]
            ];

            $ch = curl_init(BOUTIQUE_ALPISSIME . "rest/" . $station . "/V1/cakephp/fixCustomerAddressStreet");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerAddress));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
            curl_exec($ch);

			$customerData = [
                'customer' => [
                    'id' => $id,
                    "storeId" => 1,
                    "websiteId" => 1,
                    "addresses" => [
                        "1" => [
                            "customer_id" => $id,
                            "region" => [
                                "region_code" => $resultatregionshipping[2], //OU TROUVER!!???
                                "region" => $resultatregionshipping[4], // ??????
                                "region_id" => $resultatregionshipping[0] // ???????
                            ],
                            "region_id" => $resultatregionshipping[0], // ??????
                            "country_id" => $payscode->code_pays,
                            "street" => [
                                "0" => $adressefacture
                            ],
                            "telephone" => $reservDetail['utilisateur']['portable'],
                            "postcode" => $reservDetail['annonce']['code_postal'],
                            "city" => $villeLivraison->name,
							"firstname" => $customer_fname,
							"lastname" => $customer_lname,
                            "default_shipping" => '1'
                        ],
                    ],
                ],
                // "password" => $password
            ];

            $link = BOUTIQUE_ALPISSIME.'index.php/rest/V1/customers/'.$id;
            $ch = curl_init($link);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
            curl_exec($ch);
			/**** END MODIFICATION ADRESSE LIVRAISON SUR BOUTIQUE ****/
			$customerData = [
				'customer_id' => $id
			];
			$ch = curl_init(BOUTIQUE_ALPISSIME . "rest/" . $station . "/V1/carts/mine");
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			$result = curl_exec($ch);
			$quote_id = json_decode($result, true);

			// Vider panier
			$ch = curl_init(BOUTIQUE_ALPISSIME . "rest/" . $station . "/V1/carts/" . $quote_id . "/emptyCart");
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			$result = curl_exec($ch);
			$result = json_decode($result, true);

			// Enregistrer quote_id dans table reservations
			$reservationsave = $this->Reservations->get($this->request->data['IDreserv']);
			$data = array("quote_id"=>$quote_id);
			$reservationsavenew = $this->Reservations->patchEntity($reservationsave,$data);
			$this->Reservations->save($reservationsavenew);

			// 0 aucune taxe et 6 20%

			/* [option_id] => 8224  [title] => Start Date
			[option_id] => 8225  [title] => End date
			[option_id] => 8226  [title] => Date d'annulation du token de caution
			[option_id] => 8227  [title] => Number of installment
			[option_id] => 8228  [title] => Montant de la Caution
			*/

			// $Start_Date = 8380;
			// $End_date = 8381;
			// $Date_d_annulation_du_token = 8382;
			// $Number_of_installment = 8379;
			// $Montant_de_la_caution = 8378;
			// $Id_reservation = 8377;
			// $reservation_description_id = 8376;

			// Les ID du .com
			$Start_Date = 8505;
			$End_date = 8506;
			$Date_d_annulation_du_token = 8507;
			$Number_of_installment = 8504;
			$Montant_de_la_caution = 8503;
			$Id_reservation = 8502;
			$reservation_description_id = 8501;

			$this->loadModel("Utilisateurs");
			$propreglepaiement = $this->Utilisateurs->get($reservDetail['annonce']['proprietaire_id'], ['contain' => 'Paiements']);

			$reservation_description = '#'.$reservDetail['annonce']['id'].' - '.$reservDetail['annonce']['titre'];
			$Start_Date_Value = $reservDetail->dbt_at->i18nFormat('dd/MM/yyyy');
			$End_date_Value = $reservDetail->fin_at->i18nFormat('dd/MM/yyyy');
			if($propreglepaiement->nature == "PRES"){
				$Montant_de_la_caution_Value = 0;
			}else{
				$Montant_de_la_caution_Value = $reservDetail['annonce']['caution'];
			}
			$Id_reservation_Value = $reservDetail->id;
			// Date_d_annulation_du_token
			$start_add_7_days = (new Time($reservDetail->fin_at))->addDays(14);
			$Date_d_annulation_du_token_Value = $start_add_7_days->i18nFormat('dd/MM/yyyy'); // c'est la date de reservation + 7 jours
			// Number_of_installment_Value			
			if($propreglepaiement->nature == "PRES" && !empty($propreglepaiement->paiements)){
				$nbr_jour = $propreglepaiement->paiements[0]->nbr_jour;
				$date_sub_15_days = (new Date($reservDetail->dbt_at))->modify( '-'.$nbr_jour.' days' );
			}else{
				$date_sub_15_days = (new Date($reservDetail->dbt_at))->modify( '-15 days' );
			}
			$diff_date_and_today = ($date_sub_15_days)->diff(new Date());
			$Number_of_installment_Value = $diff_date_and_today->m; 
			if($Number_of_installment_Value > 4) $Number_of_installment_Value = 4;

			$prix_de_la_reservation = $reservDetail->prixreservation;
			$Prix_taxe_sejour = $reservDetail->prixtaxesejour;
			$Prix_frais_services = $reservDetail->prixfraiservice;

			// Ajout frais de ménage s'il existe
			if($reservDetail['annonce']['montant_frais_menage'] != 0){
				$prix_de_la_reservation = $prix_de_la_reservation + $reservDetail['annonce']['montant_frais_menage'];
				$reservation_description .= ' - Ménage inclus';
			}
			// Ajout frais animaux s'il existe
			if($reservDetail->apporteranimaux != 0){
				if($reservDetail['annonce']['demande_frais_animaux'] == 1){
					$prix_de_la_reservation = $prix_de_la_reservation + $reservDetail['annonce']['montant_frais_animaux'];
					$reservation_description .= ' - Frais animaux inclus';
				}
			}

			/* **********************   1) Insert product in cart reservation ipc   ************************** */


			$product = '{
			"cartItem": {
					"sku": "reservation-ipc",
					"qty": 1,
					"name": "' . $reservation_description . '",
					"price": ' . $prix_de_la_reservation . ',
					"quote_id": "' . $quote_id . '",
					"product_option": {
							"extension_attributes": {
								"custom_options": [
										{
										"option_id": "' . $reservation_description_id . '",
										"option_value": "' . $reservation_description . '",
										"extension_attributes": {}
										},
										{
										"option_id": "' . $Number_of_installment . '",
										"option_value": "' . $Number_of_installment_Value . '",
										"extension_attributes": {}
										},
										{
										"option_id": ' . $Date_d_annulation_du_token . ',
										"option_value": "' . $Date_d_annulation_du_token_Value . '",
										"extension_attributes": {}
										},
										{
										"option_id": "' . $End_date . '",
										"option_value": "' . $End_date_Value . '",
										"extension_attributes": {}
										},
										{
										"option_id": "' . $Start_Date . '",
										"option_value": "' . $Start_Date_Value . '",
										"extension_attributes": {}
										},
										{
										"option_id": "' . $Montant_de_la_caution . '",
										"option_value": "' . $Montant_de_la_caution_Value . '",
										"extension_attributes": {}
										},
										{
										"option_id": "' . $Id_reservation . '",
										"option_value": "' . $Id_reservation_Value . '",
										"extension_attributes": {}
										}
										]
									}
								}
			}
			}';

			$ch = curl_init(BOUTIQUE_ALPISSIME . "rest/" . $station . "/V1/carts/mine/items");
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $product);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			$result = curl_exec($ch);
			if (!$result) {
				Log::write('info', 'Reservation ID : '.$reservDetail->id.' Error 1 : "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
				die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
			}

			$result = json_decode($result, true);
			// echo '<pre>';print_r($result);

			$itemId = $result['item_id'];

			/* **********************  2)  Update price in cart reservation ipc  ************************** */

			// echo '<pre>';
			// echo ' Mise a jours info Réservation';

			$ch = curl_init(BOUTIQUE_ALPISSIME . "rest/" . $station . "/V1/cakephp/updateCartItem?QuoteId=" . $quote_id . "&ItemId=" . $itemId . "&Price=" . $prix_de_la_reservation);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $product);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			$result = curl_exec($ch);
			$result = json_decode($result, true);
			// echo '<pre>';print_r($result);


			/* **********************  3)  Validate price in cart reservation ipc  ************************** */


			$product = '{
			"cartItem": {
					"sku": "reservation-ipc",
					"qty": 1,
					"name": "' . $reservation_description . '",
					"price": ' . $prix_de_la_reservation . ',
					"quote_id": "' . $quote_id . '"
			}
			}';

			$ch = curl_init(BOUTIQUE_ALPISSIME . "rest/" . $station . "/V1/carts/" . $quote_id . "/items/" . $itemId );
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $product);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			$result = curl_exec($ch);
			if (!$result) {
				Log::write('info', 'Reservation ID : '.$reservDetail->id.' Error 2 : "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
				die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
			}
			$result = json_decode($result, true);
			// echo '<pre>';print_r($result);


			/* **********************   1) Insert product in cart Taxe de sejour************************** */

			$product = '{
			"cartItem": {
					"sku": "taxe-de-sejour",
					"qty": 1,
					"price": ' . $Prix_taxe_sejour . ',
					"quote_id": "' . $quote_id . '"
			}
			}';

			$ch = curl_init(BOUTIQUE_ALPISSIME . "rest/" . $station . "/V1/carts/mine/items");
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $product);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			$result = curl_exec($ch);
			if (!$result) {
				Log::write('info', 'Reservation ID : '.$reservDetail->id.' Error 3 : "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
				die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
			}

			$result = json_decode($result, true);
			$itemId = $result['item_id'];


			/* **********************  2)  Update price in cart  Taxe de sejour  ************************** */


			// echo '<pre>';
			// echo ' Mise a jours info taxe de séjour';

			$ch = curl_init(BOUTIQUE_ALPISSIME . "rest/" . $station . "/V1/cakephp/updateCartItem?QuoteId=" . $quote_id . "&ItemId=" . $itemId . "&Price=" . $Prix_taxe_sejour);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $product);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			$result = curl_exec($ch);
			$result = json_decode($result, true);
			// echo '<pre>';print_r($result);


			/* **********************  3)  Validate price in cart  Taxe de sejour  ************************** */

			$product = '{
			"cartItem": {
					"item_id": "' . $itemId . '",
					"sku": "taxe-de-sejour",
					"qty": 1,
					"price": ' . $Prix_taxe_sejour . ',
					"quote_id": "' . $quote_id . '"
			}
			}';

			$ch = curl_init(BOUTIQUE_ALPISSIME . "rest/" . $station . "/V1/carts/" . $quote_id . "/items/" . $itemId );
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $product);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			$result = curl_exec($ch);
			if (!$result) {
				Log::write('info', 'Reservation ID : '.$reservDetail->id.' Error 4 : "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
				die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
			}
			$result = json_decode($result, true);
			// echo '<pre>';print_r($result);


			/* **********************   1) Insert product in cart  Frais Service      ************************** */

			// echo ' Ajout Frais Service au panier';
			// echo '<pre>';

			$product = '{
			"cartItem": {
					"sku": "frais-de-service",
					"qty": 1,
					"price": ' . $Prix_frais_services . ',
					"quote_id": "' . $quote_id . '"
			}
			}';

			$ch = curl_init(BOUTIQUE_ALPISSIME . "rest/" . $station . "/V1/carts/" . $quote_id . "/items");
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $product);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			$result = curl_exec($ch);
			if (!$result) {
				Log::write('info', 'Reservation ID : '.$reservDetail->id.' Error 5 : "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
				die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
			}
			$result = json_decode($result, true);
			$itemId = $result['item_id'];
			// echo '<pre>';print_r($result);

			/* **********************  2)  Update price in cart Frais Service    ************************** */


			// echo ' Mise a jours info Frais Service';

			$ch = curl_init(BOUTIQUE_ALPISSIME . "rest/" . $station . "/V1/cakephp/updateCartItem?QuoteId=" . $quote_id . "&ItemId=" . $itemId . "&Price=" . $Prix_frais_services);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $product);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			$result = curl_exec($ch);
			$result = json_decode($result, true);
			// echo '<pre>';print_r($result);

			/* **********************  3)  Validate price in cart  Frais Service      ************************** */

			$product = '{
			"cartItem": {
					"item_id": "' . $itemId . '",
					"sku": "frais-de-service",
					"qty": 1,
					"price": ' . $Prix_frais_services . ',
					"quote_id": "' . $quote_id . '"
			}
			}';

			$ch = curl_init(BOUTIQUE_ALPISSIME . "rest/" . $station . "/V1/carts/" . $quote_id . "/items/" . $itemId );
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $product);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			$result = curl_exec($ch);
			if (!$result) {
				Log::write('info', 'Reservation ID : '.$reservDetail->id.' Error 6 : "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
				die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
			}
			$result = json_decode($result, true);
			// echo '<pre>';print_r($result);


		} else {
			Log::write('info', 'Reservation ID : '.$reservDetail->id.' Error 7 : " customer doesn\'t exist " ');
			echo 'customer doesn\'t exist';
		}
		// FIN Code boutique ajout reservation panier
		// Changer groupID prop/loc
		$this->loadModel("Utilisateurs");
		$this->loadModel("Contrats");
		$locEmail = $reservDetail['utilisateur']['email'];
		$propEmail = $this->Utilisateurs->get($reservDetail['annonce']['proprietaire_id'])->email;
		$findContrat = $this->Contrats->find()->where(['annonce_id' => $reservDetail->annonce_id]);
		if($findContrat->first() && $reservDetail['annonce']['contrat'] == 1){
			/* 7 Prop-contrat-conciergerie */
			$customerEmail = $propEmail;
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
			/* 8 Locataire-avec-Contrat */	
			$customerEmail = $locEmail;
			$groupId = "8";
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
		}else{
			/* 9 Prop-sans-contrat */
			$customerEmail = $propEmail;
			$groupId = "9";
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
			/* 10 Locataire-sans-contrat */
			$customerEmail = $locEmail;
			$groupId = "10";
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
		Log::write('info', 'Reservation ID : '.$reservDetail->id.' Changer groupID prop/loc '.$groupId);
		// FIN Changer groupID prop/loc
		
		/**** ADRESSE LIVRAISON SHIPPING TAMPON BASE ****/
		$this->loadModel('TamponAdresseClient');
		/*$bilingInfo = $this->TamponAdresseClient->find()->where(['client_id_loc' => $reservDetail['utilisateur']['id'], 'source <>' => 2])->order(['id DESC']);
		if($bilingInfo = $bilingInfo->first()){
			$phone_biling = $bilingInfo->phone_biling;
			$country_biling = $bilingInfo->country_biling;
			$city_biling = $bilingInfo->city_biling;
			$street_biling = $bilingInfo->street_biling;
			$postcode_biling = $bilingInfo->postcode_biling;
		}else{
			$phone_biling = $reservDetail['utilisateur']['portable'];
			$country_biling = $payscode->code_pays;
			$city_biling = $villeLivraison->name;
			$street_biling = $adressefacture;
			$postcode_biling = $reservDetail['annonce']['code_postal'];
		}*/
		$dataTamponShipping = array(
			'client_id_loc' => $reservDetail['utilisateur']['id'],
			'firstname' => $reservDetail['utilisateur']['prenom'],
			'lastname' => $reservDetail['utilisateur']['nom_famille'],
			'phone_shipping' => $reservDetail['utilisateur']['portable'],
			'country_shipping' => $payscode->code_pays,
			'city_shipping' => $villeLivraison->name,
			'street_shipping' => $adressefacture,
			'postcode_shipping' => $reservDetail['annonce']['code_postal'],
			'phone_biling' => "--",
			'country_biling' => "--",
			'city_biling' => "--",
			'street_biling' => "--",
			'postcode_biling' => "--",
			'source' => 2,
			'is_sync' => 0,
			'created_at' => Time::now()
		);
		$TamponAdresseClient = $this->TamponAdresseClient->newEntity($dataTamponShipping);
		$this->TamponAdresseClient->save($TamponAdresseClient);
		Log::write('info', 'Reservation ID : '.$reservDetail->id.' ADRESSE LIVRAISON SHIPPING TAMPON BASE ');
		/**** END ADRESSE LIVRAISON SHIPPING TAMPON BASE ****/

		// Connexion automatique + url redirect panier boutique
		$email = $reservDetail['utilisateur']['email'];
		// $station = $reservDetail['annonce']['village']['input_boutique'];
		// if($station == "fr" || $station == "en") $station = $reservDetail['annonce']['village']['input_boutique']."/checkout/cart";
		$station = $reservDetail['annonce']['village']['input_boutique']."/checkout/cart";
		$hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));
		$return_url = BOUTIQUE_ALPISSIME.$station;
		$fail_url = BOUTIQUE_ALPISSIME.$station;
		$final_url = BOUTIQUE_ALPISSIME.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
		$this->set("redirectUrl",$final_url);				
		$this->set("msg","OK");
		Log::write('info', 'Reservation ID : '.$reservDetail->id.' Connexion automatique + url redirect panier boutique ');
	}
	/**
     *
     * @param <type> $data
     * @return <type>
     */
    function annule($id)
    {
        $this->set('annonce_id',$id);
    }
	/*
	 *
	 */
	 function blockreduction(){
		$this->viewBuilder()->layout(false);
		$this->loadModel("Reductions");
		$deb = explode('-', $this->request->data['debut']);
		$datedebut=date("Y-m-d", mktime(0, 0, 0, $deb[1],$deb[0],$deb[2]));
		$fin = explode('-', $this->request->data['fin']);
		$datefin = date("Y-m-d", mktime(0, 0, 0, $fin[1],$fin[0],$fin[2]));
		$existeCode = $this->Reductions->existecodereservation($datedebut,$datefin,$this->request->data['ann_id']);
		$block = '';
                
		if($existeCode->count() >= 1){
                    $this->loadModel("Modelmailsysteme");
                    $textEmail = $this->Modelmailsysteme->find()->where(['titre' => $this->request->data['modelemail']])->first();
                    $mail_text_must = $textEmail->blockreduction;
                    
                    $m = new Mustache_Engine;                                        
                    $block = '';                    
                    foreach ($existeCode as $key=>$value) {                    
                        $datamustache = array('codereduction' => $value->code_reduction, 'valeurreduction' => $value->valeur, 'debutreduction' => $value->dbt_validite, 'finreduction' => $value->fin_validite);
                        $block .=  $m->render($mail_text_must, $datamustache); 
                        $block .= "<br>";
                    }
		}
		$this->set("blockdetail",$block);
	 }
	/**
	 *
	 **/
	 public function getdetailreservations(){
		 $this->viewBuilder()->layout(false);
		 $id_res = $this->request->data['reservID'];
		 $this->loadModel("Reservations");
		 $res = $this->Reservations->find()
		 ->join([
			 'A' => [
				 'table' => 'annonces',
				 'type' => 'inner',
				 'conditions' => 'A.id=Reservations.annonce_id',
			 ],
			 'U' => [
				 'table' => 'utilisateurs',
				 'type' => 'inner',
				 'conditions' => 'U.id=Reservations.utilisateur_id',
			 ]
		 ]);
		 $res->select(['A.titre', 'A.proprietaire_id', 'U.prenom', 'U.nom_famille', 'Reservations.dbt_at', 'Reservations.fin_at', 'Reservations.inventaire_loc', 'Reservations.commentaire_inventaire'])
		 ->where(["Reservations.id = ".$id_res]);
		 $this->set("detailReservation", $res->first());

		 $this->loadModel("Utilisateurs");
		 $res = $res->first();
		 $util = $this->Utilisateurs->get($res["A"]["proprietaire_id"]);
		 $this->set("detailProp", $util);
		 $this->set("dbtat", $res->dbt_at->i18nFormat("dd-MM-YYY"));
		 $this->set("finat", $res->fin_at->i18nFormat("dd-MM-YYY"));
	 }
	 /**
	  * 
	  */
	public function shownumber()
	{
		$this->viewBuilder()->layout(false);
		$session = $this->request->session();
		$id=$this->request->data['id'];
		$reservation=$this->Reservations->get($id);	
		$this->loadModel("Utilisateurs");	
		if(!empty($session->read('Auth.User.nature'))){
			if($session->read('Auth.User.nature') == "CLT"){
				$this->loadModel("Annonces");
				$annonce=$this->Annonces->get($reservation->annonce_id);
				$proprietaire=$this->Utilisateurs->find("all")->where(['id' => $annonce->proprietaire_id]);
				if($proprietaire = $proprietaire->first()){
					$this->set("num_utilisateur",$proprietaire->portable);
				}else{
					$this->set("num_utilisateur","Aucun numéro à afficher");
				}
			}else{				
				$locataire = $this->Utilisateurs->find("all")->where(['id' => $reservation->utilisateur_id]);
				if($locataire = $locataire->first()){
					$this->set("num_utilisateur",$locataire->portable);
				}else{
					$this->set("num_utilisateur","Aucun numéro à afficher");
				}	
			}
		}else{
			$this->set("num_utilisateur","Aucun numéro à afficher");
		}
	}

    /**
     *
     */
    public function sendmessagefromreservation()
    {
        $this->viewBuilder()->layout(false);
        $this->loadModel("Contactprops");

        $session       = $this->request->session();
        $id_message    = 0;

        $reservation = $this->Reservations->get($this->request->data['id']);
        $parentMessage = $this->Contactprops->find()->where([
            'id_annonce' => $reservation->annonce_id,
            'parent_id'  => 0,
            '(locataire_id = ' . $reservation->utilisateur_id . ' OR locataire_id = ' . $session->read('Auth.User.id') . ')'
        ])->first();

        if ($parentMessage) {
            $id_message = $parentMessage->id;

            if ($parentMessage->reservation_id == 0) {
                $contactprop = $this->Contactprops->patchEntity($parentMessage, ['reservation_id' => $this->request->data['id']]);
                $this->Contactprops->save($contactprop);
            }
        }

        if (!empty($id_message)) {
            $path          = Router::url('/', true);
            $urlLang       = $this->getLanguage();
            $urlvaluemulti = $this->getUrlmulti();
            $redirectUrl   = $path . $urlLang . $urlvaluemulti['utilisateurs'] . '/' . $urlvaluemulti['mesmessages'] . '?message_id=' . $id_message;

            $this->set("redirect_url", $redirectUrl);
        } else {
            $this->set("dbt_msg",$reservation->dbt_at);
            $this->set("fin_msg",$reservation->fin_at);
            $this->set("nbCouchage_ad_msg",$reservation->nb_adultes);
            $this->set("nbCouchage_enf_msg",$reservation->nb_enfants);
            $this->set("id",$reservation->annonce_id);
            $this->set("utilisateur_id",$reservation->utilisateur_id);
        }
    }
	/**
	 * 
	 */
	public function prop()
	{
		$this->viewBuilder()->layout(false);
		$this->autoRender = false;
		$session = $this->request->session();
		if ($this->request->is(['patch', 'post', 'put'])) {  

			/*$messagetotest = preg_replace('`[^a-zA-Z0-9]`', '', $this->request->data["message"]);
			if(preg_match('[[0-9]{8}]', $messagetotest)){
				
				if(!empty($session->read('Auth.User.nature'))){
					if($session->read('Auth.User.nature') == "CLT"){
						return $this->redirect(['action' => 'locataireView', '?' => ['error' => 1]]);
					}else{
						return $this->redirect(['action' => 'view', '?' => ['error' => 1]]);	
					}
				}
			}*/

			$this->loadModel("Annonces");               
			$this->loadModel("Utilisateurs");               
			$annonce=$this->Annonces->get($this->request->data["id"]);
//			$proprietaire=$this->Utilisateurs->get($annonce->proprietaire_id);

			/*$str = str_replace("é","e",$annonce->titre);
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
			$str = str_replace("²","",$str);*/

			$path = Router::url('/', true);
			// if ($this->InvisibleReCaptcha->verify()) {	
			if ($this->Recaptcha->verify()) {
				$this->loadModel("Annoncegestionnaires");
                $this->loadModel("Contactprops");
                $data = [
                    "id_annonce"   => $this->request->data["id"],
                    "demande"      => "Demande Location",
                    "commentaire"  => "Date Début : " . $this->request->data["dbt_msg"] . " -- Date Fin : " . $this->request->data["fin_msg"] . " -- Nbr Adultes : " . $this->request->data["nbCouchage_ad_msg"] . " -- Nbr Enfants : " . $this->request->data["nbCouchage_enf_msg"] . " -- ".$this->request->data["message"],
                    "date_insert"  => Time::now(),
                    "lut"          => "0",
                    "locataire_id" => $this->request->data["idUser"],
                    "reservation_id" => $this->request->data["reservation_id"],
                    "parent_id"    => 0
                ];

                $contact     = $this->Contactprops->newEntity($data);
                $messagesend = $this->Contactprops->save($contact);

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

				$this->Flash->success(__('Votre message a été bien envoyé.'),['clear'=> true]);
				return $this->redirect($path . $urlLang . $urlvaluemulti['utilisateurs'] . '/' . $urlvaluemulti['mesmessages']);
			}
		}
	}
	 /**
 	  *
 	  **/
	function getReservationProprietaire(){
		$this->viewBuilder()->layout('ajax');
		$id=$this->request->data['id'];
		$reservation=$this->Reservations->get($id);
		$this->loadModel("Utilisateurs");
		$this->set("reservation",$reservation);
		$this->set("utilisateur", $this->Utilisateurs->get($reservation->utilisateur_id));
		$mail = [];
		$this->loadModel("Modelmailsysteme");
		$textEmail = $this->Modelmailsysteme->find('all');
		foreach ($textEmail as $key => $value) {
			$mail[$value->titre] = $value->txtmail;
		}
		$this->set("textmail",$mail);
		$this->loadModel("Reservationtelephone");
		$restel=$this->Reservationtelephone->getListeTelephone($id);
		$this->set("restel",$restel);
		$this->set("nbrrestel",$restel->count());
		$this->loadModel("Annonces");
		$annonce = $this->Annonces->get($reservation->annonce_id);
		$this->set("annonceContrat",$annonce->contrat);
		$infoprop = $this->Utilisateurs->get($annonce->proprietaire_id, ['contain'=>['Cautions', 'Paiements', 'Annulations']]);
		if($infoprop->nature == "PRES" && !empty($infoprop->paiements) && $infoprop->paiements[0]->taux_commission != 0) $tauxcommession = $infoprop->paiements[0]->taux_commission;
		else $tauxcommession = 3;
		$this->set("infoprop",$infoprop);

        $listeVirements = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.id" => $id])
        ->join([            
            'dispo' => [
                'table' => 'dispos',
                'type' => 'inner',
                'conditions' => 'dispo.reservation_id=Reservations.id',
            ]
        ]);
        $listeVirements->select(['dispo.calendarsynchro_id','Reservations.id','Reservations.date_virement','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','Utilisateurs.prenom','Utilisateurs.nom_famille','total'=>'IF(Reservations.prixreservation=0,SUM(IF (dispo.promo_yn=0 , dispo.prix , dispo.promo_px)) ,Reservations.prixreservation)'])
        ->group('Reservations.id');
		foreach ($listeVirements as $listeVirement) {
			$this->set("calendarsynchroid",$listeVirement['dispo']['calendarsynchro_id']);

			$prixVirement = round(($listeVirement->total-($listeVirement->total*$tauxcommession/100)), 2);
			$this->set("prixVirement",$prixVirement);

			$now   = $listeVirement->dbt_at;
			$clone = clone $now;
			$tet = $clone->modify( '+2 day' );

			if($listeVirement->date_virement != NULL){
				$EtatVirement = "Réservation payée";
			}else{
				if(new Date() > new Date($tet->format( 'd-m-Y' ))) $EtatVirement = __("Réservation payée");
				if(new Date() >= new Date($listeVirement->dbt_at->i18nFormat('dd-MM-yyyy')) && new Date() <= new Date($tet->format( 'd-m-Y' ))) $EtatVirement = __("Réservation en attente de paiement");
				if(new Date() < new Date($listeVirement->dbt_at->i18nFormat('dd-MM-yyyy'))) $EtatVirement = __("Réservation en attente de paiement");
			}			
			$this->set("EtatVirement",$EtatVirement);

			if($listeVirement->date_virement != NULL){
				$this->set("dateVirement",$listeVirement->date_virement->i18nFormat('dd-MM-yyyy'));
			}else{
				$now2   = $listeVirement->dbt_at;
				$clone2 = clone $now2;
				$tet2 = $clone2->modify( '+1 day' );
				$this->set("dateVirement",$tet2->format( 'd-m-Y' ));
			}
			
		}
		
	}
	/*
	 *
	 */
	function editReservationProprietaire(){
		$this->loadModel('Annoncegestionnaires');
    	$this->loadModel('Gestionnaires');
		$reservation=$this->Reservations->get($this->request->data['hdid']);
		$oldcommentprop = $reservation->comment;
		if(isset($this->request->data['taxe']) && $this->request->data['taxe'] != "") $data=array("nb_adultes"=>$this->request->data['nb_adult_get'],"nb_enfants"=>$this->request->data['nb_child_get'],"comment"=>html_entity_decode($this->request->data['comment']),"taxe"=>$this->request->data['taxe'],"arrivee"=>$this->request->data['dt_d']);
		else $data=array("nb_adultes"=>$this->request->data['nb_adult_get'],"nb_enfants"=>$this->request->data['nb_child_get'],"comment"=>html_entity_decode($this->request->data['comment']),"arrivee"=>$this->request->data['dt_d']);
		if(!(isset($this->request->data['sel']) && $this->request->data['sel']!=null))
		{
				$data["dbt_at"]=$this->toDate($this->request->data['dbt_at']);
		}
		$reservation=$this->Reservations->patchEntity($reservation,$data);
		$this->Reservations->save($reservation);
		Log::write('info', 'Edit Reservation par Proprietaire : reservationID: '.$this->request->data['hdid'].'__debut: '.$this->request->data['dbt_at'].'__fin: '.$this->request->data['dt_d']);
                if(isset($this->request->data['sel']) && $this->request->data['sel']!=null){
                    $evit = 'EviterAjout';
                    $dateToT=explode("/", $this->request->data['sel'])[0];
                    $this->loadModel("Dispos");
                    $data=array();
                    $dispo1=$this->Dispos->getFirstDispoInBooking($reservation->id);
                    $fin_at = new Date($dispo1->dbt_at->i18nFormat('dd-MM-yyyy'));
                    $periodes = $this->Dispos->chercherdisponibilite($reservation->annonce_id, (new Date($dateToT))->i18nFormat('yyyy-MM-dd'), $dispo1->dbt_at->i18nFormat('yyyy-MM-dd'));
                    $periodes = $periodes->toArray();
                    $dataAjout=[];
                    if(count($periodes)==0){
                        $dispo1=$this->Dispos->getFirstDispoInBooking($reservation->id);
                        $evit = 'EviterAjout';
                        $nbrDiff = (new Date($dateToT))->diff($dispo1->dbt_at)->days;
                        $data=[
                            'dbt_at' => new Date($dateToT),
                            'fin_at' => $dispo1->dbt_at,
                            "created_at" => $this->toDate(date('d-m-Y')),
                            "updated_at" => $this->toDate(date('d-m-Y')),
                            'annonce_id' => $reservation->annonce_id,
                            "prix" => $dispo1->prix_jour*$nbrDiff,
                            "statut" => 90,
                            "utilisateur_id" => $reservation->utilisateur_id,
                            "promo_yn" => $dispo1->promo_yn,
                            "reservation_id"=>$reservation->id,
                            "promo_px"=>$dispo1->promo_jour*$nbrDiff,
                            "nbr_jour"=>$nbrDiff,
                            "conditionnbr"=>0,
                            "prix_jour"=>$dispo1->prix_jour,
                            "promo_jour"=>$dispo1->promo_jour
                        ];
                        $dispoAjout = $this->Dispos->newEntity($data);
                        $this->Dispos->save($dispoAjout);
                    }
                    elseif(count($periodes)==1 && $periodes[0]->statut==0)
                    {
                        $dbt_at = new Date($dateToT);
                        $dispo1=$this->Dispos->getFirstDispoInBooking($reservation->id);
                        $dispo=$periodes[0];
                        if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) < $dbt_at) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) == $fin_at))
                        {
                                                        $evit = 'Ajout';
							/** METTRE A JOUR LA PERIODE DISPONIBLE **/
                                                        $dataDiff= $dispo->dbt_at->diff($dbt_at)->days;
							$dataAjout["nbr_jour"] = $dispo->fin_at->diff($dbt_at)->days;
							$nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;
							if($dispo->prix_jour == 0 && $dispo->prix != 0 ){
								$data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
								$data['prix'] = $data['prix_jour'] * $dataDiff;
                                                                $dataAjout["prix_jour"]= $data['prix_jour'];
                                                                $dataAjout["prix"]= $dataAjout["prix_jour"]*$dataAjout["nbr_jour"];
							}else{
								$data['prix'] = $dispo->prix_jour * $dataDiff;
                                                                $dataAjout["prix"]= $dispo->prix_jour*$dataAjout["nbr_jour"];
                                                                $dataAjout["prix_jour"] = $dispo->prix_jour;
							}
							if($dispo->promo_jour == 0 && $dispo->promo_px != 0 ){
								$data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
								$data['promo_px'] = $data['promo_jour'] * $dataDiff;
                                                                $dataAjout["promo_jour"]= $data['promo_jour'];
                                                                $dataAjout["promo_px"]= $dataAjout["promo_jour"]*$dataAjout["nbr_jour"];
							}else if($dispo->promo_yn == 1){
								$data['promo_px'] = $dispo->promo_jour * $dataDiff;
                                                                $dataAjout["promo_px"]= $dispo->promo_jour*$dataAjout["nbr_jour"];
                                                                $dataAjout["promo_jour"] = $dispo->promo_jour;
							}
                                                        $dataAjout["promo_yn"]=$dispo->promo_yn;
							$data["updated_at"] = $this->toDate(date('d-m-Y'));
							$data["fin_at"] = new Date($dateToT);
                                                        $data['nbr_jour']=$dataDiff;
							$dispoModif = $this->Dispos->patchEntity($dispo, $data);
                        $this->Dispos->save($dispoModif);
                                                            Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
                                                    }else if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) == $dbt_at) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) == $fin_at))
                                                    {
                                                            $evit = 'EviterAjout';
                                                            $data["updated_at"] = $this->toDate(date('d-m-Y'));
                                                            $data["statut"] = 90;
                                                            $data["utilisateur_id"] = $reservation->utilisateur_id;
                                                            $data["reservation_id"] = $reservation->id;
                                                            $data['nbr_jour']=$dispo->fin_at->diff($dispo->dbt_at)->days;
                                                            $dispoModif = $this->Dispos->patchEntity($dispo, $data);
                        $this->Dispos->save($dispoModif);
                                                            Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
                                                    }
                    }
                    elseif(count($periodes)>1)
                    {
                        for($i=1;$i<count($periodes);$i++)
                        {
                            $dispo=$periodes[$i];
                            $data["updated_at"] = $this->toDate(date('d-m-Y'));
                            $data["statut"] = 90;
                            $data["utilisateur_id"] = $reservation->utilisateur_id;
                            $data["reservation_id"] = $reservation->id;
                            $data['nbr_jour'] = $dispo->fin_at->diff($dispo->dbt_at)->days;
                            $dispoModif = $this->Dispos->patchEntity($dispo, $data);
                            $this->Dispos->save($dispoModif);
                            Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
                        }
                        $data=array();
                        $dbt_at = new Date($dateToT);
                        $dispo=$periodes[0];
                        $fin_at=$dispo->fin_at;
                        if(new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) < $dbt_at)
                        {
                            $evit = 'Ajout';
                            /** METTRE A JOUR LA PERIODE DISPONIBLE **/
                            $dataDiff= $dispo->dbt_at->diff($dbt_at)->days;
                            $dataAjout["nbr_jour"] = $dispo->fin_at->diff($dbt_at)->days;
                            $nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;
                            if($dispo->prix_jour == 0 && $dispo->prix != 0 ){
                                    $data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
                                    $data['prix'] = $data['prix_jour'] * $dataDiff;
                                    $dataAjout["prix_jour"]= $data['prix_jour'];
                                    $dataAjout["prix"]= $dataAjout["prix_jour"]*$dataAjout["nbr_jour"];
                            }else{
                                    $data['prix'] = $dispo->prix_jour * $dataDiff;
                                    $dataAjout["prix"]= $dispo->prix_jour*$dataAjout["nbr_jour"];
                                    $dataAjout["prix_jour"] = $dispo->prix_jour;
                            }
                            if($dispo->promo_jour == 0 && $dispo->promo_px != 0 ){
                                    $data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
                                    $data['promo_px'] = $data['promo_jour'] * $dataDiff;
                                    $dataAjout["promo_jour"]= $data['promo_jour'];
                                    $dataAjout["promo_px"]= $dataAjout["promo_jour"]*$dataAjout["nbr_jour"];
                            }else if($dispo->promo_yn == 1){
                                    $data['promo_px'] = $dispo->promo_jour * $dataDiff;
                                    $dataAjout["promo_px"]= $dispo->promo_jour*$dataAjout["nbr_jour"];
                                    $dataAjout["promo_jour"] = $dispo->promo_jour;
                            }
                            $dataAjout["promo_yn"]=$dispo->promo_yn;
                            $data["updated_at"] = $this->toDate(date('d-m-Y'));
                            $data["fin_at"] = $dbt_at;
                            $data['nbr_jour']=$dataDiff;
                            $fin_at=$dispo->fin_at;
                            $dispoModif = $this->Dispos->patchEntity($dispo, $data);
                            $this->Dispos->save($dispoModif);
                            $dbt_at=$dispo->fin_at;
                            Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
                        }else if(new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) == $dbt_at)
                        {
                            $evit = 'EviterAjout';
                            $data["updated_at"] = $this->toDate(date('d-m-Y'));
                            $data["statut"] = 90;
                            $data["utilisateur_id"] = $reservation->utilisateur_id;
                            $data["reservation_id"] = $reservation->id;
                            $data['nbr_jour']=$dispo->fin_at->diff($dispo->dbt_at)->days;
                            $dispoModif = $this->Dispos->patchEntity($dispo, $data);
                            $this->Dispos->save($dispoModif);
                            Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
                        }
                    }
                    if($evit == 'Ajout'){
                        //pr(new Date($dbt_at));pr(new Date($fin_at));exit;
                        /** AJOUTER LA PERIODE RESERVEE **/
                        $dataAjout["annonce_id"] = $reservation->annonce_id;
                        $dataAjout["created_at"] = $this->toDate(date('d-m-Y'));
                        $dataAjout["updated_at"] = $this->toDate(date('d-m-Y'));
                        $dataAjout["dbt_at"] = new Date($dbt_at);
                        $dataAjout["fin_at"] = new Date($fin_at);
                        $dataAjout["statut"] = 90;
                        $dataAjout["utilisateur_id"] = $reservation->utilisateur_id;
                        $dataAjout["reservation_id"] = $reservation->id;
                        $dataAjout["annonce_id"] = $dispo->annonce_id;
                        $dispoAjout = $this->Dispos->newEntity($dataAjout);
                        $this->Dispos->save($dispoAjout);
                        Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id);
                    }
                    $reservation->dbt_at=new Date($dateToT);
                    $this->Reservations->save($reservation);
                }                
		$this->loadModel("Utilisateurs");
		$utilisateur=$this->Utilisateurs->get($this->request->data['utilisteur_id']);
		$this->loadModel("Annonces");
		$annonce=$this->Annonces->get($reservation->annonce_id);
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
		$this->loadModel("Registres");
		$this->loadModel("Utilisateurs");		
		$prop=$this->Utilisateurs->get($annonce->proprietaire_id);
		$loc=$this->Utilisateurs->get($reservation->utilisateur_id);

		// Update portable + email si réservation manuelle
		if($reservation->type != 0){
			$oldmail = $loc->email;
			if($this->request->data['email'] != ""){
				$dataLoc = array('email' => $this->request->data['email']);
				$locataireInfo=$this->Utilisateurs->patchEntity($loc,$dataLoc);
				$loc = $this->Utilisateurs->save($locataireInfo);
			}
			if($this->request->data['portable'] != ""){
				$dataLoc = array('portable' => $this->request->data['portable']);
				$locataireInfo=$this->Utilisateurs->patchEntity($loc,$dataLoc);
				$loc = $this->Utilisateurs->save($locataireInfo);
			}
			
			if($this->request->data['email'] != "" && $oldmail != $this->request->data['email']){
				/*** MISE A JOUR BOUTIQUE ***/            
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
				if($loc->prenom == '') $customer_fname = "_";
				else $customer_fname = $loc->prenom ; // prenom du client
				$customer_lname = $loc->nom_famille; // Nom du client
				$password = $this->request->data['password']; // mot de passe
				
				$requestUrl = $magentoURL.'index.php/rest/V1/customers/search?searchCriteria[filter_groups][0][filters][0][field]=email&searchCriteria[filter_groups][0][filters][0][value]=%25'.$oldmail.'%25&searchCriteria[filter_groups][0][filters][0][condition_type]=like';
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
							"email" => $customerEmail,  //à changer
							"firstname" => $customer_fname,     //à changer
							"lastname" => $customer_lname,      //à changer
							"storeId" => 1,
							"websiteId" => 1,
							"custom_attributes" => [
								[
									"attribute_code" => "client_id_loc",
									"value" => $loc->id
								]
							]
						],
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
							"email" => $customerEmail,  //à changer
							"firstname" => $customer_fname,          //à changer
							"lastname" => $customer_lname,         //à changer
							"storeId" => 1,
							"websiteId" => 1,
							"custom_attributes" => [
								[
									"attribute_code" => "client_id_loc",
									"value" => $loc->id
								]
							]
						],
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
			}
		}
		
		$this->loadModel('BlocServicesMails');
		$bloc_services_mail_first = $this->BlocServicesMails->find()->where(["(liste_id_station LIKE '$annonce->lieugeo_id;%' OR liste_id_station LIKE '%;$annonce->lieugeo_id;%')"])->first();

		$datamustache = array('bloc_services_mail' => $bloc_services_mail_first->bloc_services_mail, 'bloc_services_mail_en' => $bloc_services_mail_first->bloc_services_mail_en, 'date' => $reservation->dbt_at, 'prenom' => $loc->prenom, 'nom' => $loc->nom_famille, 'blockreduction' => $this->request->data['editReservationPropHidden']);
                
                
		$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
		$mail=$mails->first();
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $loc,'textEmail'=>'editReservationProp',
                                                         'data'=>$datamustache,'template'=>'editReservationProp','viewVars'=>'editReservationProp','noReply'=>false
                                                        ]);
				$this->eventManager()->dispatch($event);
				/*** Envoi mail commentaire proprietaire/locataire à l'admin s'il existe ***/
				if($reservation->comment != "" && $oldcommentprop == ""){
					$datamustachecomment = array('annonce' => $reservation->annonce_id, 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'commentaire' => $reservation->comment, 'role' => 'Propriétaire');
					$event = new Event('Email.send', $this, ['from'=>$prop->email,'to' => $mail->val,'textEmail'=>'commentairereservation',
										'data'=>$datamustachecomment,'template'=>'acceptationReservationAdm','viewVars'=>'acceptationReservationAdm','noReply'=>false
									]);
					$this->eventManager()->dispatch($event);
					// Copie gestionnaire s'il existe
					if($annonce->id_gestionnaires != 0){
						// $this->loadModel("Gestionnaires");
						$gestio = $this->Gestionnaires->get($annonce->id_gestionnaires);
						$event = new Event('Email.send', $this, ['from'=>$prop->email,'to' => $gestio->email,'textEmail'=>'commentairereservation',
																'data'=>$datamustachecomment,'template'=>'creationReservationAdm','viewVars'=>'creationReservationAdm','noReply'=>false]);
						$this->eventManager()->dispatch($event);
					}	
				}				
                // #####################################################
		return $this->redirect(["controller"=>"reservations",'action' => 'view']);
	}

    /*
	 *
	 */
    function getReservationLocataireOld(){
        $this->viewBuilder()->layout('ajax');
        $id=$this->request->data['id'];
        $reservation=$this->Reservations->get($id);
        $this->loadModel("Utilisateurs");
        $this->loadModel("Annonces");
        $this->set("reservation",$reservation);
        $ann = $this->Annonces->get($reservation->annonce_id);
        $this->set("proprietaire", $this->Utilisateurs->get($ann->proprietaire_id));
        $this->set("utilisateur", $this->Utilisateurs->get($reservation->utilisateur_id));

        $mail = [];
        $this->loadModel("Modelmailsysteme");
        $textEmail = $this->Modelmailsysteme->find('all');
        foreach ($textEmail as $key => $value) {
            $mail[$value->titre] = $value->txtmail;
        }
        $this->set("textmail",$mail);

        $this->loadModel("Reservationtelephone");
        $restel=$this->Reservationtelephone->getListeTelephone($id);
        $this->set("restel",$restel);
        $this->set("nbrrestel",$restel->count());
        $this->loadModel("Annonces");
        $annonce = $this->Annonces->get($reservation->annonce_id);
        $this->set("annonceContrat",$annonce->contrat);
    }
    /*
     *
     */
    function getReservationLocataire()
    {
        $this->viewBuilder()->layout('ajax');

        $id = $this->request->data['id'];
        $reservation = $this->Reservations->getReservationById($id);
        $this->set("reservation",$reservation);
        $this->set("urlLang", $this->getLanguage());
    }

	/*
	 *
	 */
	function editReservationLocataire(){
		$this->loadModel('Annoncegestionnaires');
    $this->loadModel('Gestionnaires');
		$reservation=$this->Reservations->get($this->request->data['hdid']);
		$oldcommentloc = $reservation->commentlocataire;
		$data=array("dbt_at"=>$this->toDate($this->request->data['dbt_at']), "commentlocataire"=>$this->request->data['commentlocataire']);
		$reservation=$this->Reservations->patchEntity($reservation,$data);
		$this->Reservations->save($reservation);
		Log::write('info', 'Edit Reservation par Locataire : reservationID: '.$this->request->data['hdid'].'__debut: '.$this->request->data['dbt_at'].'__fin: '.$this->request->data['dt_d']);

		$this->loadModel("Utilisateurs");
		$utilisateur=$this->Utilisateurs->get($this->request->data['utilisteur_id']);
		
		$this->loadModel("Annonces");
		$annonce=$this->Annonces->get($reservation->annonce_id);
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
		$this->loadModel("Registres");
		$this->loadModel("Utilisateurs");		
		$prop=$this->Utilisateurs->get($annonce->proprietaire_id);
		$loc=$this->Utilisateurs->get($reservation->utilisateur_id);

		// Update portable + email si réservation manuelle
		if($reservation->type != 0){
			$oldmail = $loc->email;
			if($this->request->data['email'] != ""){
				$dataLoc = array('email' => $this->request->data['email']);
				$locataireInfo=$this->Utilisateurs->patchEntity($loc,$dataLoc);
				$loc = $this->Utilisateurs->save($locataireInfo);
			}
			if($this->request->data['portable'] != ""){
				$dataLoc = array('portable' => $this->request->data['portable']);
				$locataireInfo=$this->Utilisateurs->patchEntity($loc,$dataLoc);
				$loc = $this->Utilisateurs->save($locataireInfo);
			}
			
			if($this->request->data['email'] != "" && $oldmail != $this->request->data['email']){
				/*** MISE A JOUR BOUTIQUE ***/            
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
				if($loc->prenom == '') $customer_fname = "_";
				else $customer_fname = $loc->prenom ; // prenom du client
				$customer_lname = $loc->nom_famille; // Nom du client
				$password = $this->request->data['password']; // mot de passe
				
				$requestUrl = $magentoURL.'index.php/rest/V1/customers/search?searchCriteria[filter_groups][0][filters][0][field]=email&searchCriteria[filter_groups][0][filters][0][value]=%25'.$oldmail.'%25&searchCriteria[filter_groups][0][filters][0][condition_type]=like';
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
							"email" => $customerEmail,  //à changer
							"firstname" => $customer_fname,     //à changer
							"lastname" => $customer_lname,      //à changer
							"storeId" => 1,
							"websiteId" => 1,
							"custom_attributes" => [
								[
									"attribute_code" => "client_id_loc",
									"value" => $loc->id
								]
							]
						],
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
							"email" => $customerEmail,  //à changer
							"firstname" => $customer_fname,          //à changer
							"lastname" => $customer_lname,         //à changer
							"storeId" => 1,
							"websiteId" => 1,
							"custom_attributes" => [
								[
									"attribute_code" => "client_id_loc",
									"value" => $loc->id
								]
							]
						],
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
			}
		}

                $datamustache = array('date' => $reservation->dbt_at, 'prenomprop' => $prop->prenom, 'nomprop' => $prop->nom_famille, 'prenom' => $loc->prenom, 'nom' => $loc->nom_famille);
                
		$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
		$mail=$mails->first();
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $prop,'textEmail'=>'editDateArrivee',
                                                         'data'=>$datamustache,'template'=>'editDateArrivee','viewVars'=>'editDateArrivee','noReply'=>false
                                                        ]);
				$this->eventManager()->dispatch($event);
				if($reservation->commentlocataire != "" && $oldcommentloc == ""){
					$datamustachecommentloc = array('annonce' => $annonce->id, 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'commentaire' => $reservation->commentlocataire, 'role' => 'Locataire');
					$event = new Event('Email.send', $this, ['from'=>$loc->email,'to' => $mail->val,'textEmail'=>'commentairereservation',
										'data'=>$datamustachecommentloc,'template'=>'acceptationReservationAdm','viewVars'=>'acceptationReservationAdm','noReply'=>false
									]);
					$this->eventManager()->dispatch($event);
					//copie gestionnaire
					if($annonce->id_gestionnaires != 0){
						$this->loadModel("Gestionnaires");
						$gestio = $this->Gestionnaires->get($annonce->id_gestionnaires);
						$event = new Event('Email.send', $this, ['from'=>$prop->email,'to' => $gestio->email,'textEmail'=>'commentairereservation',
																'data'=>$datamustachecommentloc,'template'=>'creationReservationAdm','viewVars'=>'creationReservationAdm','noReply'=>false]);
						$this->eventManager()->dispatch($event);
					}
				}
                // #####################################################
		return $this->redirect(["controller"=>"reservations",'action' => 'locataireView']);
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
	 **/
	function googlecalendarinsert($reservation, $calendarId){
		// $this->loadModel("Utilisateurs");
		// $this->loadModel("Annonces");
		// $this->loadModel("Reservations");
		// $this->loadModel("Reservationtelephone");
		// $reservation = $this->Reservations->get($reservation->id);
		// /*** GOOGLE CALENDAR API ***/
		// putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/json/service_key.json');
		// $client = new Google_Client();
		// $client->useApplicationDefaultCredentials();
		// $client->setAuthConfig(__DIR__.'/json/client_secret.json');
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
		// 	$chnum = '';
		// 	$i = 1;
		// 	$listenum = $this->Reservationtelephone->getListeTelephone($reservation->id);
		// 	foreach ($listenum as $value) {
		// 		if(!empty($value->num_tel)){
		// 			$chnum .= ' -- Téléphone '.$i.': '.$value->num_tel;
		// 			$i++;
		// 		}
		// 	}
		// 	$start = new Google_Service_Calendar_EventDateTime();
		// 	$date = new DateTime($reservation->heure_arr->i18nFormat('yyyy-MM-dd HH:mm:ss'), new DateTimeZone('Europe/Paris'));
		// 	$date->setDate($reservation->dbt_at->i18nFormat('YYY'), $reservation->dbt_at->i18nFormat('MM'), $reservation->dbt_at->i18nFormat('dd'));
		//   $start->setDateTime($date->format(DateTime::ATOM));
		// 	$start->setTimeZone(new DateTimeZone('Europe/Paris'));
		// 	$event = new Google_Service_Calendar_Event(array(
		// 		'summary' => 'Réservation Annonce '.$reservation->annonce_id,
		// 		'description' => 'Locataire: '.$locataire->email.' -- Locataire prénom: '.$locataire->prenom.' -- Locataire nom: '.$locataire->nom_famille.' -- Propriétaire: '.$prop->email.' -- Propriétaire prénom: '.$prop->prenom.' -- Propriétaire nom: '.$prop->nom_famille.' -- Départ: '.$reservation->fin_at.' -- Heure départ: '.$reservation->heure_dep.$chnum,
		// 		'start' => $start,
		// 		'end' => $start,
		// 	));
		// 	$event = $service->events->insert($calendarId, $event);
		// 	return($event->id);
	}
	/**
	 *
	 **/
	function googlecalendardelete($id_event, $calendarId){
		// /*** GOOGLE CALENDAR API ***/
		// putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/json/service_key.json');
		// $client = new Google_Client();
		// $client->useApplicationDefaultCredentials();
		// $client->setAuthConfig(__DIR__.'/json/client_secret.json');
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
		// 	/** DELETE EVENT **/
		// 	$service->events->delete($calendarId, $id_event);
		// 	return true;
	}
	/**
	 *
	 **/
	function googlecalendarupdate($reservation, $calendarId){
		// $this->loadModel("Utilisateurs");
		// $this->loadModel("Annonces");
		// $this->loadModel("Reservations");
		// $this->loadModel("Reservationtelephone");
		// /*** GOOGLE CALENDAR API ***/
		// putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/json/service_key.json');
		// $client = new Google_Client();
		// $client->useApplicationDefaultCredentials();
		// $client->setAuthConfig(__DIR__.'/json/client_secret.json');
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
		// 	$locataire = $this->Utilisateurs->get($reservation->utilisateur_id);
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
		// 	$event = $service->events->get($calendarId, $reservation->id_googlecalendar);
		// 	$start = new Google_Service_Calendar_EventDateTime();
		// 	$date = new DateTime($reservation->heure_arr->i18nFormat('yyyy-MM-dd HH:mm:ss'), new DateTimeZone('Europe/Paris'));
		// 	$date->setDate($reservation->dbt_at->i18nFormat('YYY'), $reservation->dbt_at->i18nFormat('MM'), $reservation->dbt_at->i18nFormat('dd'));
		//   $start->setDateTime($date->format(DateTime::ATOM));
		// 	$start->setTimeZone(new DateTimeZone('Europe/Paris'));
		//   $event->setStart($start);
		// 	$event->setEnd($start);
		// 	$event->setDescription('Locataire: '.$locataire->email.' -- Locataire prénom: '.$locataire->prenom.' -- Locataire nom: '.$locataire->nom_famille.' -- Propriétaire: '.$prop->email.' -- Propriétaire prénom: '.$prop->prenom.' -- Propriétaire nom: '.$prop->nom_famille.' -- Départ: '.$reservation->fin_at.' -- Heure départ: '.$reservation->heure_dep.$chnum);
		// 	$updatedEvent = $service->events->update($calendarId, $event->getId(), $event);
		// 	return true;
	}
	/**
	 *
	 **/
	function locataireAddres(){
		$session = $this->request->session();
		if($session->check("Reseservation.manuelle")){
			$this->set('confirm_res','reservation');
			$session->delete("Reseservation.manuelle");
		}
		$this->loadModel("Dispos");
		$this->loadModel("Packs");
		$this->loadModel("Annonces");
		$this->loadModel("Annoncegestionnaires");
		$this->loadModel("Gestionnaires");
        $mainURL = Router::url('/', true);

		if (!empty($this->request->data)) {
			$emailForVerif=strtolower($this->request->data['email']);
			if(strrpos($emailForVerif, "airbnb",strrpos($emailForVerif, "@"))!==false || strrpos($emailForVerif, "abritel",strrpos($emailForVerif, "@"))!==false || strrpos($emailForVerif, "booking",strrpos($emailForVerif, "@"))!==false){
				$this->Flash->error(__('Les emails Airbnb, Abritel et Booking ne sont pas acceptés.'),['clear'=> true]);
				$session->write("SubmitOK","");
			}
			else{
				$this->loadModel("Registres");
				$registre= $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
				$mail =$registre->first();
				$this->loadModel("Utilisateurs");
				$info_prop = $this->Utilisateurs->get($this->request->data['proprietaire_id']);
				//verfication l'existance de locataire
				$res_uti=$this->Utilisateurs->find('all',['conditions'=>["lcase(email) LIKE '".trim(strtolower($this->request->data['email']))."'"]]);
				
				if($utilisLocataire = $res_uti->first()){
					$session = $this->request->session();
					if($session->read('Config.language') != "fr_FR"){
						$this->loadModel("Languages");
						$language_header_name = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();
						$urlLang = $language_header_name->url_code."/";
					} else {
						$urlLang = "";
					}

					if($utilisLocataire->email == $info_prop->email && $this->request->data['occupationcheck'] == 1){
						// Update proprietaire
						$a_utlisateur=array('email'=>strtolower($this->request->data['email']),
							'portable'=>$this->request->data['portable1'],
							'date_update'=>Time::now()
						);
						$utilisateur=$this->Utilisateurs->patchEntity($info_prop, $a_utlisateur);
						$this->Utilisateurs->save($utilisateur);						
					}else if($utilisLocataire->email == $info_prop->email && $this->request->data['occupationcheck'] == 0){
						$this->Flash->error(__('Vous ne pouvez pas utiliser cette adresse email'),['clear'=> true]);
						return $this->redirect(SITE_ALPISSIME.$urlLang."reservations/locataireAddres");
					}else if($utilisLocataire->nature != "CLT"){
						$this->Flash->error(__('Vous ne pouvez pas utiliser cette adresse email'),['clear'=> true]);
						return $this->redirect(SITE_ALPISSIME.$urlLang."reservations/locataireAddres");
					}	
					$id_loc=$utilisLocataire->id;                
				}else{
                                    $nouveau=0;
                                    if(empty($res_uti->first())){
                                            $mdp_en_clair = $this->request->data['mdpenclair'];
                                            $a_utlisateur=array('email'=>strtolower($this->request->data['email']),
                                                                                    'mot_passe'=>md5($mdp_en_clair),
                                                                                    'prenom'=>$this->request->data['prenom'],
                                                                                    'nom_famille'=>$this->request->data['nom'],
                                                                                    'telephone'=>$this->request->data['portable2'],
                                                                                    'portable'=>$this->request->data['portable1'],
                                                                                    'pays'=>$this->request->data['pays'],
                                                                                    'statut'=>"90",
                                                                                    'ident'=>$this->request->data['email'],
                                                                                    'nature'=>"CLT");
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
												$sendinblue->addContactToSendInBlue($utilisateur->email,$utilisateur->prenom,$utilisateur->nom_famille,$utilisateur->portable,null,$utilisateur->naissance,null,null,null, $this->Pays->get($utilisateur->pays)->fr ,'CLT');
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
                                            $this->loadModel("Registres");
                                            $mail = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]])->first();
                                            $url=Router::url(['controller' => 'Utilisateurs', 'action' => 'confirmuser','token'=>$token],true);
                                            
                                            $this->UtilisateursTokens->save($user_token);
                                            Log::write('emergency', 'Création compte (Reservation Manuelle)avec mot de passe : "'.$mdp_en_clair.'" ; client : "'.$utilisateur->email.'"');
                                            
                                    }else{
                                             $util=$res_uti->first();
                                             $id_loc=$util->id;
                                    }
                                }
				
				if(!empty($this->request->data["sel"])){
					/** Traitement periodes **/
					$perid = explode("/", $this->request->data["sel"]);
					$apporteranimaux = 0;
					if($this->request->data["apporteranimauxhidden"]) $apporteranimaux = $this->request->data["apporteranimauxhidden"];
					$data=array("annonce_id" => $this->request->data["annonceid"],
								"utilisateur_id" => $id_loc,
								"statut" => 90,
								"dbt_at" => new Date($perid[0]),
								"fin_at" => new Date($perid[1]),
								"created_at" => $this->toDate(date('d-m-Y')),
								"updated_at" => $this->toDate(date('d-m-Y')),
								"nb_enfants" => $this->request->data["enfant"],
								"nb_adultes" => $this->request->data["adult"],
								"taxe" => $this->request->data["taxe"],
								"prixapayer" => $this->request->data["totalapayer"],
								"prixreservation" => $this->request->data["prixreservation"],
								"prixtaxesejour" => $this->request->data["prixtaxesejour"],
								"prixfraiservice" => $this->request->data["prixfraiservice"],
								"type" => 1,
								"comment" => $this->request->data["comment"],
								"apporteranimaux" => $apporteranimaux);
					$reservation = $this->Reservations->newEntity($data);
					if($this->Reservations->save($reservation)){
						$session->write("SubmitOK","OK");
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
						$this->loadModel("Annonces");
						$annonce=$this->Annonces->get($this->request->data["annonceid"]);
						if(PROD_ON == 1){
							/*** ADD GOOGLE CALENDAR ***/
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
							/*** END ADD GOOGLE CALENDAR ***/
						}
						$dispoID = $this->retournerDisposID($this->request->data["sel"],$this->request->data["annonceid"]);
						if($dispoID != ''){
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
								$data["fin_at"] = new Date($perid[0]);
								$dispoModif = $this->Dispos->patchEntity($dispo, $data);
		            $this->Dispos->save($dispoModif);
								Log::write('info', 'Reservation manuelle (dispos)1 : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispoModif->statut);
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
								$data["dbt_at"] = new Date($perid[1]);
								$dispoModif = $this->Dispos->patchEntity($dispo, $data);
		            $this->Dispos->save($dispoModif);
								Log::write('info', 'Reservation manuelle (dispos)2 : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispoModif->statut);

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
								Log::write('info', 'Reservation manuelle (dispos)3 : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispoModif->statut);

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
								$data["fin_at"] = new Date($perid[0]);
								$dispoModif = $this->Dispos->patchEntity($dispo, $data);
		            $this->Dispos->save($dispoModif);
								Log::write('info', 'Reservation manuelle (dispos)4 : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispoModif->statut);

								$data2["annonce_id"] = $this->request->data["annonceid"];
								$data2["created_at"] = $this->toDate(date('d-m-Y'));
								$data2["updated_at"] = $this->toDate(date('d-m-Y'));
								$data2["dbt_at"] = new Date($perid[1]);
								$data2["statut"] = 0;
								$dispo2 = $this->Dispos->newEntity($data2);
		            $this->Dispos->save($dispo2);
								Log::write('info', 'Reservation manuelle (dispos)5 : dispoID: '.$dispo2->id.'__debut: '.$dispo2->dbt_at.'__fin: '.$dispo2->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispo2->statut);

							}
							if($evit == ''){
								/** AJOUTER LA PERIODE RESERVEE **/
								$dataAjout["annonce_id"] = $this->request->data["annonceid"];
								$dataAjout["created_at"] = $this->toDate(date('d-m-Y'));
								$dataAjout["updated_at"] = $this->toDate(date('d-m-Y'));
								$dataAjout["dbt_at"] = new Date($perid[0]);
								$dataAjout["fin_at"] = new Date($perid[1]);
								$dataAjout["statut"] = 90;
								$dataAjout["utilisateur_id"] = $id_loc;
								$dataAjout["promo_yn"] = $dispo->promo_yn;
								$dataAjout["reservation_id"] = $reservation->id;
								$dataAjout["nbr_jour"] = $dispo->nbr_jour;
								$dispoAjout = $this->Dispos->newEntity($dataAjout);
		            $this->Dispos->save($dispoAjout);
								Log::write('info', 'Reservation manuelle (dispos)6 : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispoAjout->statut);
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
								Log::write('info', 'Reservation manuelle (dispos)7 : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispoModif->statut);

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
								Log::write('info', 'Reservation manuelle (dispos)8 : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispoModif->statut);

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
								$datadd["dbt_at"] = new Date($perid[0]);

								$dataAjout["annonce_id"] = $this->request->data["annonceid"];
								$dataAjout["created_at"] = $this->toDate(date('d-m-Y'));
								$dataAjout["updated_at"] = $this->toDate(date('d-m-Y'));
								$dataAjout["dbt_at"] = $this->toDate($disres->dbt_at);
								$dataAjout["fin_at"] = new Date($perid[0]);
								$dataAjout["statut"] = 0;
								$datadd["statut"] = 90;
								$datadd["utilisateur_id"] = $id_loc;
								$dataAjout["promo_yn"] = $disres->promo_yn;
								$datadd["reservation_id"] = $reservation->id;
								$dataAjout["nbr_jour"] = $disres->nbr_jour;
								$dispoAjout = $this->Dispos->newEntity($dataAjout);
		            $this->Dispos->save($dispoAjout);
								Log::write('info', 'Reservation manuelle (dispos)9 : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispoAjout->statut);

								$dispoModif = $this->Dispos->patchEntity($disres, $datadd);
		            $this->Dispos->save($dispoModif);
								Log::write('info', 'Reservation manuelle (dispos)10 : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispoModif->statut);

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
								Log::write('info', 'Reservation manuelle (dispos)11 : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispoModif->statut);

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
								$datadd2["fin_at"] = new Date($perid[1]);

								$dataAjoutd2["annonce_id"] = $this->request->data["annonceid"];
								$dataAjoutd2["created_at"] = $this->toDate(date('d-m-Y'));
								$dataAjoutd2["updated_at"] = $this->toDate(date('d-m-Y'));
								$dataAjoutd2["dbt_at"] = new Date($perid[1]);
								$dataAjoutd2["fin_at"] = $this->toDate($disres->fin_at);
								$dataAjoutd2["statut"] = 0;
								$datadd2["statut"] = 90;
								$datadd2["utilisateur_id"] = $id_loc;
								$dataAjoutd2["promo_yn"] = $disres->promo_yn;
								$datadd2["reservation_id"] = $reservation->id;
								$dataAjoutd2["nbr_jour"] = $disres->nbr_jour;
								$dispoAjout = $this->Dispos->newEntity($dataAjoutd2);
		            $this->Dispos->save($dispoAjout);
								Log::write('info', 'Reservation manuelle (dispos)12 : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispoAjout->statut);

								$dispoModif = $this->Dispos->patchEntity($disres, $datadd2);
		            $this->Dispos->save($dispoModif);
								Log::write('info', 'Reservation manuelle (dispos)13 : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id.'__disposStatut: '.$dispoModif->statut);

							}
						}
					}
					$info_loc = $this->Utilisateurs->get($id_loc);
					$info_ann = $this->Annonces->get($this->request->data["annonceid"]);

					// Ajout variable {{imageannonce}}
					$this->loadModel("Photos");
					$photo = $this->Photos->find()->where(['annonce_id' => $this->request->data["annonceid"]])->order(['numero ASC'])->first();
					// $nomImg = "vignette-".$photo->annonce_id."-".$photo->numero;

					$annonce=$this->Annonces->get($photo->annonce_id, ['contain' => ['Lieugeos','Villages']]);
					$natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
					$village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
					$village_nom = str_replace(" – ", "-", $village_nom);
					$village_nom = str_replace(" ", "-", $village_nom);
					$nomImgG = $photo->titre;

					$urlimage1 = 'https://www.alpissime.com/images_ann/'.$this->request->data["annonceid"].'/'.$nomImgG;

					//Ajout variable {{description}} (160 premiers caractères de la description de l'annonce et finir par "..." si la description contient plus de 160 caractères)
					$desc160 = substr($info_ann->description, 0, 160);
					if(strlen($info_ann->description) > 160) $desc160 = $desc160." ...";

					$this->loadModel('BlocServicesMails');
					$bloc_services_mail_first = $this->BlocServicesMails->find()->where(["(liste_id_station LIKE '$info_ann->lieugeo_id;%' OR liste_id_station LIKE '%;$info_ann->lieugeo_id;%')"])->first();

					// $annonce = $this->Annonces->get($this->request->data["annonceid"], ['contain' => ['Lieugeos']]);
					$natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
					$lannonce = $this->string2url($annonce["titre"]);
					$hrefDetailAnn = 'station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;

					$datamustache = [
                        'bloc_services_mail'    => $bloc_services_mail_first->bloc_services_mail,
                        'bloc_services_mail_en' => $bloc_services_mail_first->bloc_services_mail_en,
                        'url'                   => $url,
                        'annonce'               => $this->request->data["annonceid"],
                        'prenom'                => $info_loc->prenom,
                        'nom'                   => $info_loc->nom_famille,
                        'tel'                   => $info_loc->portable,
                        'email'                 => $info_loc->email,
                        'prenomprop'            => $info_prop->prenom,
                        'nomprop'               => $info_prop->nom_famille,
                        'nbrEnfant'             => $reservation->nb_enfants,
                        'nbrAdulte'             => $reservation->nb_adultes,
                        'debut'                 => $reservation->dbt_at,
                        'fin'                   => $reservation->fin_at,
                        'login'                 => $this->request->data['email'],
                        'password'              => $this->request->data['mdpenclair'],
                        'blockreduction'        => $this->request->data['creationCompteManuelleHidden'],
                        'imageannonce'          => $urlimage1,
                        'description'           => $desc160,
                        'annonceURL'            => $mainURL . $hrefDetailAnn,
                        'reservationURL'        => $mainURL . "reservations/view_reservation/" . $reservation->id
                    ];
                                        
					//envoi compte locataire
					if ($nouveau == 1) {
                        // #####################################################
                        $event = new Event('Email.send', $this,
                            [
                                'from'      => [$mail->val=>FROM_MAIL],
                                'to'        => $info_loc,
                                'textEmail' => 'creationCompteManuelle',
                                'data'      => $datamustache,
                                'template'  => 'creationCompteManuelle',
                                'viewVars'  => 'creationCompteManuelle',
                                'noReply'   => false
                            ]
                        );
                        $this->eventManager()->dispatch($event);
                        // #####################################################
					}

					$this->loadModel("Lieugeos");
					$lieugeo = $this->Lieugeos->get($info_ann->lieugeo_id);
                    // #####################################################
                    $event = new Event('Email.send', $this,
                        [
                            'from'      => [$mail->val=>FROM_MAIL],
                            'to'        => $info_prop,
                            'textEmail' => 'creationReservationManuelle',
                            'data'      => $datamustache,
                            'template'  => 'creationReservationManuelle',
                            'viewVars'  => 'creationReservationManuelle',
                            'noReply'   => false
                        ]
                    );
                    $this->eventManager()->dispatch($event);
                    // #####################################################

                    $this->loadModel('BlocMailGestionnaires');
                    $blocsinfos = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => $anngest->id_gestionnaires])->first();
                    $datamustachedata = [
                        'bloc_services_mail'    => $bloc_services_mail_first->bloc_services_mail,
                        'bloc_services_mail_en' => $bloc_services_mail_first->bloc_services_mail_en,
                        'bloc_info_arrivee'     => $blocsinfos->bloc_info_arrivee,
                        'bloc_info_arrivee_en'  => $blocsinfos->bloc_info_arrivee_en,
                        'bloc_info_depart'      => $blocsinfos->bloc_info_depart,
                        'bloc_info_depart_en'   => $blocsinfos->bloc_info_depart_en,
                        'bloc_info_horaires'    => $blocsinfos->bloc_info_horaires,
                        'bloc_info_horaires_en' => $blocsinfos->bloc_info_horaires_en,
                        'prenom'                => $info_loc->prenom,
                        'nom'                   => $info_loc->nom_famille,
                        'prenomprop'            => $info_prop->prenom,
                        'nomprop'               => $info_prop->nom_famille,
                        'debut'                 => $reservation->dbt_at,
                        'fin'                   => $reservation->fin_at,
                        'annonce'               => $this->request->data["annonceid"],
                        'blockreduction'        => $this->request->data['creationReservationLocManuelleHidden'],
                        'reservationURL'        => $mainURL . "reservations/view_reservation/" . $reservation->id
                    ];
                    // #####################################################
                    $event = new Event('Email.send', $this,
                        [
                            'from'      => [$mail->val=>FROM_MAIL],
                            'to'        => $info_loc,
                            'textEmail' => 'creationReservationLocManuelle',
                            'data'      => $datamustachedata,
                            'template'  => 'creationReservationLocManuelle',
                            'viewVars'  => 'creationReservationLocManuelle',
                            'noReply'   => false
                        ]
                    );
                    $this->eventManager()->dispatch($event);
					// #####################################################
										
					// #####################################################
					//Send to admin
					$event = new Event('Email.send', $this,
                        [
                            'from'=>$info_prop->email,
                            'to' => $mail->val,
                            'textEmail'=>'creationReservationManuelleAdm',
                            'data'=>$datamustache,
                            'template'=>'creationReservationLocManuelle',
                            'viewVars'=>'creationReservationLocManuelle',
                            'noReply'=>false
                        ]
                    );
					$this->eventManager()->dispatch($event);

					//Send to gestionnaire
					if ($info_ann->id_gestionnaires != 0) {
					    $this->loadModel("Gestionnaires");
						$gestio = $this->Gestionnaires->get($info_ann->id_gestionnaires);
						$event = new Event('Email.send', $this,
                            [
                                'from'=>$info_prop->email,
                                'to' => $gestio->email,
                                'textEmail'=>'creationReservationManuelleAdm',
                                'data'=>$datamustache,
                                'template'=>'creationReservationLocManuelle',
                                'viewVars'=>'creationReservationLocManuelle','noReply'=>false
                            ]
                        );
						$this->eventManager()->dispatch($event);

                        if($reservation->comment != ""){
						    $datamustachecomment = [
                                'annonce' => $this->request->data["annonceid"],
                                'debut' => $reservation->dbt_at,
                                'fin' => $reservation->fin_at,
                                'commentaire' => $reservation->comment,
                                'role' => 'Propriétaire'
                            ];
							$event = new Event('Email.send', $this,
                                [
                                    'from'=>$info_prop->email,
                                    'to' => $gestio->email,
                                    'textEmail'=>'commentairereservation',
									'data'=>$datamustachecomment,
                                    'template'=>'acceptationReservationAdm',
                                    'viewVars'=>'acceptationReservationAdm',
                                    'noReply'=>false
								]
                            );
							$this->eventManager()->dispatch($event);
						}
					}

					/*** Envoi mail commentaire proprietaire/locataire à l'admin s'il existe ***/
										if($reservation->comment != ""){
											$datamustachecomment = array('annonce' => $this->request->data["annonceid"], 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'commentaire' => $reservation->comment, 'role' => 'Propriétaire');
											$event = new Event('Email.send', $this, ['from'=>$info_prop->email,'to' => $mail->val,'textEmail'=>'commentairereservation',
																'data'=>$datamustachecomment,'template'=>'acceptationReservationAdm','viewVars'=>'acceptationReservationAdm','noReply'=>false
															]);
											$this->eventManager()->dispatch($event);
										}
                                        // #####################################################
					$this->Flash->success(__('Votre réservation a bien été créée'),['clear'=> true]);
					$this->set("SubmitOK","OK");
					$session->write("Reseservation.manuelle","addReservation");
					Log::write('info', 'Reservation manuelle : reservationID '.$reservation->id.'__debut '.$perid[0].'__fin '.$perid[1].'__locataireID '.$id_loc.'__annonceID '.$this->request->data["annonceid"]);
					
					/**** MODIFICATION ADRESSE LIVRAISON SUR BOUTIQUE ****/
					/**** informations a utiliser toujours ********************/
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
					$customerEmail = $info_loc->email;   //à changer
					if($info_loc->prenom == '') $customer_fname = "_";
					else $customer_fname = $info_loc->prenom ; // prenom du client
					$customer_lname = $info_loc->nom_famille; // Nom du client
					$password = $this->request->data['mdpenclair']; // mot de passe
					$group_id = '10';
					if($reservationDetail['annonce']['contrat'] == 1){
						$this->loadModel('Contrats');
						$contrat = $this->Contrats->find()->where(['annonce_id' => $reservationDetail['annonce']['id']]);
						if($contrat->first()) $group_id = '8';
					}

					$requestUrl = $magentoURL.'index.php/rest/V1/customers/search?searchCriteria[filter_groups][0][filters][0][field]=email&searchCriteria[filter_groups][0][filters][0][value]=%25'.$customerEmail.'%25&searchCriteria[filter_groups][0][filters][0][condition_type]=like';
					$ch = curl_init($requestUrl);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch);
					$result = json_decode($result, true);
					// print_r($result);
					
					//*********** Mise a jour du mot de passe du client et eventuellement son nom ...
					// si le client existe (email) dans la boutique ********//
					
					$reservationDetail = $this->Reservations->getReservationById($reservation->id);
					$this->loadModel('Frvilles');
					$villeLivraison = $this->Frvilles->get($reservationDetail['annonce']['ville']);
					// $regiontab = $this->getRegType();
					$this->loadModel('Pays');
					$payscode = $this->Pays->get($reservationDetail['annonce']["pays"]);
					$this->loadModel('Residences');
					$residence = $this->Residences->get($reservationDetail['annonce']['batiment']);
					$this->loadModel('Lieugeos');
					$station = $this->Lieugeos->get($reservationDetail['annonce']['lieugeo_id']);
					
					// $villeBilling = $this->Frvilles->get($reservationDetail['utilisateur']['ville']);
					// $payscodeBilling = $this->Pays->get($reservationDetail['utilisateur']["pays"]);
					
					if($reservationDetail['utilisateur']['adresse'] == "") $reservationDetail['utilisateur']['adresse'] = $station->name;
					// $resultatregionbilling = $this->getRegType($reservationDetail['utilisateur']['region']);
					$resultatregionshipping = $this->getRegType($reservationDetail['annonce']['region']);
					// print_r($resultatregionbilling);
					// print_r($resultatregionshipping);
					// exit;
					$this->loadModel('Villages');
					if($reservationDetail['annonce']['village'] != "") $village = $this->Villages->get($reservationDetail['annonce']['village']['id']);
					else $village = "";
					$adressefacture = $reservationDetail['annonce']['num_app'].", ".$residence->name.", ".$village->name.", ".$station->name;

					if ($result["items"]){
						$id = $result['items'][0]['id'];
						$customerData = [
							'customer' => [
								'id' => $id,
								"group_id" => $group_id,
								"email" => $customerEmail,
								"firstname" => $customer_fname,
								"lastname" => $customer_lname,
								"storeId" => 1,
								"websiteId" => 1,
								"addresses" => [
									"0" => [
										"customer_id" => $id,
										"region" => [
											"region_code" => $resultatregionshipping[2], //OU TROUVER!!???
											"region" => $resultatregionshipping[4], // ??????
											"region_id" => $resultatregionshipping[0] // ???????
												],
										"region_id" => $resultatregionshipping[0], // ??????
										"country_id" => $payscode->code_pays,
										"street" => [
											"0" => $adressefacture
										],
										"telephone" => $reservationDetail['utilisateur']['portable'],
										"postcode" => $reservationDetail['annonce']['code_postal'],
										"city" => $villeLivraison->name,
										"firstname" => $customer_fname,
										"lastname" => $customer_lname,
										"default_shipping" => '1'
									],
								],
							],
							"password" => $password
						];
						// print_r($customerData);
						// print_r("******");

						$link = $magentoURL.'index.php/rest/V1/customers/'.$id;
						$ch = curl_init($link);
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
						curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
						$result = curl_exec($ch);

						// echo '<pre>';print_r($result);  //Tu peux enlever
						// exit;

						/**** ADRESSE LIVRAISON SHIPPING TAMPON BASE ****/
						$this->loadModel('TamponAdresseClient');
						/*$bilingInfo = $this->TamponAdresseClient->find()->where(['client_id_loc' => $reservationDetail['utilisateur']['id'], 'source <>' => 2])->order(['id DESC']);
						if($bilingInfo = $bilingInfo->first()){
							$phone_biling = $bilingInfo->phone_biling;
							$country_biling = $bilingInfo->country_biling;
							$city_biling = $bilingInfo->city_biling;
							$street_biling = $bilingInfo->street_biling;
							$postcode_biling = $bilingInfo->postcode_biling;
						}else{
							$phone_biling = $reservationDetail['utilisateur']['portable'];
							$country_biling = $payscode->code_pays;
							$city_biling = $villeLivraison->name;
							$street_biling = $adressefacture;
							$postcode_biling = $reservationDetail['annonce']['code_postal'];
						}*/
						$dataTamponShipping = array(
							'client_id_loc' => $reservationDetail['utilisateur']['id'],
							'firstname' => $reservationDetail['utilisateur']['prenom'],
							'lastname' => $reservationDetail['utilisateur']['nom_famille'],
							'phone_shipping' => $reservationDetail['utilisateur']['portable'],
							'country_shipping' => $payscode->code_pays,
							'city_shipping' => $villeLivraison->name,
							'street_shipping' => $adressefacture,
							'postcode_shipping' => $reservationDetail['annonce']['code_postal'],
							'phone_biling' => "--",
							'country_biling' => "--",
							'city_biling' => "--",
							'street_biling' => "--",
							'postcode_biling' => "--",
							'source' => 2,
							'is_sync' => 0,
							'created_at' => Time::now()
						);
						$TamponAdresseClient = $this->TamponAdresseClient->newEntity($dataTamponShipping);
						$this->TamponAdresseClient->save($TamponAdresseClient);
						/**** END ADRESSE LIVRAISON SHIPPING TAMPON BASE ****/
					} else {
						//******** créer le client ***********//
						$customerData = [
							'customer' => [
								"group_id" => $group_id,
								"email" => $customerEmail,
								"firstname" => $customer_fname,
								"lastname" => $customer_lname,
								"storeId" => 1,
								"websiteId" => 1,
								"addresses" => [
									"0" => [
										"customer_id" => $id,
										"region" => [
											"region_code" => $resultatregionshipping[2], //OU TROUVER!!???
											"region" => $resultatregionshipping[4], // ??????
											"region_id" => $resultatregionshipping[0] // ???????
												],
										"region_id" => $resultatregionshipping[0], // ?????
										"country_id" => $payscode->code_pays,
										"street" => [
											"0" => $adressefacture
										],
										"telephone" => $reservationDetail['utilisateur']['portable'],
										"postcode" => $reservationDetail['annonce']['code_postal'],
										"city" => $villeLivraison->name,
										"firstname" => $customer_fname,
										"lastname" => $customer_lname,
										"default_shipping" => '1'
									],
								],
							],
							"password" => $password
						];
						// print_r($customerData);
						// print_r("######");
						
						$ch = curl_init($magentoURL."index.php/rest/V1/customers");
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
						curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
						$result = curl_exec($ch);

						// echo '<pre>';print_r($result);          //Tu peux enlever
						// exit;

						/*** Creation compte sur site location NEW TABLE TAMPON ***/
						/*$customerData = [
							'customer' => [
								"group_id" => $group_id,
								"email" => $customerEmail,  //à changer
								"firstname" => $customer_fname,          //à changer
								"lastname" => $customer_lname,         //à changer
								"storeId" => 1,
								"websiteId" => 1
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
						curl_close($ch);*/
						/**** ADRESSE LIVRAISON SHIPPING TAMPON BASE ****/
						$this->loadModel('TamponAdresseClient');
						/*$bilingInfo = $this->TamponAdresseClient->find()->where(['client_id_loc' => $reservationDetail['utilisateur']['id'], 'source <>' => 2])->order(['id DESC']);
						if($bilingInfo = $bilingInfo->first()){
							$phone_biling = $bilingInfo->phone_biling;
							$country_biling = $bilingInfo->country_biling;
							$city_biling = $bilingInfo->city_biling;
							$street_biling = $bilingInfo->street_biling;
							$postcode_biling = $bilingInfo->postcode_biling;
						}else{
							$phone_biling = $reservationDetail['utilisateur']['portable'];
							$country_biling = $payscode->code_pays;
							$city_biling = $villeLivraison->name;
							$street_biling = $adressefacture;
							$postcode_biling = $reservationDetail['annonce']['code_postal'];
						}*/
						$dataTamponShipping = array(
							'client_id_loc' => $reservationDetail['utilisateur']['id'],
							'firstname' => $reservationDetail['utilisateur']['prenom'],
							'lastname' => $reservationDetail['utilisateur']['nom_famille'],
							'phone_shipping' => $reservationDetail['utilisateur']['portable'],
							'country_shipping' => $payscode->code_pays,
							'city_shipping' => $villeLivraison->name,
							'street_shipping' => $adressefacture,
							'postcode_shipping' => $reservationDetail['annonce']['code_postal'],
							'phone_biling' => "--",
							'country_biling' => "--",
							'city_biling' => "--",
							'street_biling' => "--",
							'postcode_biling' => "--",
							'source' => 2,
							'is_sync' => 0,
							'created_at' => Time::now()
						);
						$TamponAdresseClient = $this->TamponAdresseClient->newEntity($dataTamponShipping);
						$this->TamponAdresseClient->save($TamponAdresseClient);
						/**** END ADRESSE LIVRAISON SHIPPING TAMPON BASE ****/
					}
					// exit;
					
					/**** END MODIFICATION ADRESSE LIVRAISON SUR BOUTIQUE ****/

				}
			}else{
				$session->write("SubmitOK","");
				$this->Flash->error(__('Votre réservation n\'a pas pu être enregistrée'),['clear'=> true]);
			}
			}

		}
		$mail = [];
		$this->loadModel("Modelmailsysteme");
		$textEmail = $this->Modelmailsysteme->find('all');
		foreach ($textEmail as $key => $value) {
			$mail[$value->titre] = $value->txtmail;
		}
		$this->set("textmail",$mail);
                /** Liste pays **/
				$this->loadModel("Pays");
				$Pays=$this->Pays->findByCode_pays('Fr')->union(
				$this->Pays->find('all')->where(['code_pays != ' =>'FR']));
                //$Pays=$this->Pays->find('all');
                $payNum=array();
		$session = $this->request->session();
		$a_pay=array();
		$a_pay[0] = '';
		foreach($Pays as $pay){
			if($session->read('Config.language') == "fr_FR") $a_pay[$pay->id_pays]=$pay->fr;
            if($session->read('Config.language') == "en_US") $a_pay[$pay->id_pays]=$pay->en;
			$payNum[$pay->id_pays]=$pay->code_pays;
		}
                $this->set("paysNum", $payNum);
                $this->set("Pays", $a_pay);
		$this->loadModel("Utilisateurs");
		
		$id_utilisateur=$session->read('Auth.User.id');
		$utilisateur = $this->Utilisateurs->get($id_utilisateur);
		$this->set("proprietaire", $utilisateur);
		$this->loadModel("Annonces");
		$gestionnaireInfo=$this->Annonces->find()
						->join([
							// 'AG' => [
							// 	'table' => 'annoncegestionnaires',
							// 	'type' => 'left',
							// 	'conditions' => 'AG.id_annonces=Annonces.id',
							// ]
							// ,
							'G' => [
								'table' => 'gestionnaires',
								'type' => 'left',
								'conditions' => 'Annonces.id_gestionnaires=G.id',
							]

						])
						->select(['G.telephone','Annonces.id']);
		$gestInfo = [];
		foreach ($gestionnaireInfo as $key => $value) {
				$gestInfo[$value->id] = $value['G']['telephone'];
		}
		$this->set("gestionnaireIfo", $gestInfo);
		$annoncesids = [];
		$surfacesAnnonces = [];
		$menageAnnonces = [];
		$annoncesids[0] = '';
		$annids = $this->Annonces->find('all',["conditions"=>["Annonces.proprietaire_id"=>$id_utilisateur],'contain' => ['Lieugeos'],"order"=>"Annonces.updated_at desc"])
														->where(["(Annonces.statut=50 OR Annonces.statut=30)", "(Annonces.contrat=1 OR Annonces.mise_relation=1)"]);
		if($annids->count() != 0){
			foreach ($annids as $key => $value) {
				$surfacesAnnonces[$value->id] = $value->surface;
					$annoncesids[$value->id] = "Appartement ".$value->num_app;
			}
		}else{
			$annoncesids[0] = 'Aucune Annonce Valide';
		}
		$this->set("annoncesids", $annoncesids);
		$packs = $this->Packs->find("all");
		$this->set(compact("packs"));
		/*** Récupérer liste services à partir du boutique ***/
		//// On commence par le ménage suivant la surface de l'annonce
		// require_once "../../boutique/app/Mage.php"; //à modifier selon l'emplacement du fichier
		// umask(0);
		// set_time_limit(0);
		// Mage::init();

		// $websiteId = Mage::app()->getWebsite()->getId();
		// $storeId = Mage::app()->getStore();

		// $Collection=Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('superficie_min')->groupByAttribute('superficie_min');
		// $Collection = $Collection->addAttributeToSelect('entity_id');
		// foreach ($surfacesAnnonces as $keyy => $valuee) {
		// 	$bool = false;
	  //   foreach($Collection as $each)
	  //   {
	  //   	$product = Mage::getModel('catalog/product')->load($each['entity_id']);
		// 		if(($valuee >= $product["superficie_min"]) && ($valuee <= $product["superficie_max"]))
		// 		{		    	
		// 			$menageAnnonces[$keyy] = $product["name"];
		// 			$bool = true;
		// 		}
		// 		if($bool) break;
	  //   }
		// }
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
	function tarifdispo(){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel("Annonces");
		$this->loadModel("Dispos");
		$a_annonce=array();
		$annonce=$this->Annonces->find('all',['conditions'=>['Annonces.proprietaire_id'=>$this->Auth->user('id')]]);
		$i=0;
		foreach($annonce as $ann){
		  $a_annonce[$i]['num_app']=$ann->num_app;
			$a_annonce[$i]['id']=$ann->id;
			$a_annonce[$i]['titre']=$ann->titre;
			$packs=$this->Dispos->find('all',['conditions'=>['Dispos.annonce_id'=>$ann->id,"Dispos.dbt_at >= '".date("Y-m-d")."'"], "order" => "dbt_at"]);
			if(!empty($packs->first())){
				$j=0;
				$packs=$this->Dispos->find('all',['conditions'=>['Dispos.annonce_id'=>$ann->id,"Dispos.dbt_at >= '".date("Y-m-d")."'"], "order" => "dbt_at"]);
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
		}
		$this->set("l_disposstatuts",['0'=>'Libre','50'=>'Option','90'=>'Réservé']);
  	$this->set('annonce', $a_annonce);
	}

    /*
	 *
	 */
    function locataireViewOld()
    {
        $mail = [];
        $this->loadModel("Modelmailsysteme");
        $textEmail = $this->Modelmailsysteme->find('all');
        foreach ($textEmail as $key => $value) {
            $mail[$value->titre] = $value->txtmail;
        }
        $this->set("textmail",$mail);
        $l_reservationsstatuts=array('0'=>'<span class="text-warning">'.__('En attente de validation').'</span>','50'=>'<span class="text-warning">'.__('En attente de validation (payé)').'</span>','10'=>'<span class="text-danger">'.__('Refusée').'</span>','60'=>'<span class="text-danger">'.__('Supprimé (non payé)').'</span>','90'=>'<span class="text-success">'.__('Validee Proprietaire').'</span>', '100'=>'<span class="text-primary">'.__('Demande annulation en attente').'</span>','110'=>'<span class="text-danger">'.__('Annulée').'</span>');
        $this->set("l_reservationsstatuts", $l_reservationsstatuts);
        $reservations = $this->Reservations->getReservationsLocataireOld($this->Auth->user('id'));


        $this->set('reservations', $reservations);
    }

	/*
	 *
	 */
	function locataireView()
    {
        $reservations = $this->Reservations->getReservationsLocataire($this->Auth->user('id'));

        //Make data structure
        $currentDate = new Date();
        $resData = [
            '50'      => [
                'title' => __('Réservation%s en attente '),
                'data'  => [],
            ],
            '90'      => [
                'title' => __('Réservation%s confirmée'),
                'data'  => [],
            ],
            '90_past' => [
                'title' => __('Réservation%s passée'),
                'data'  => [],
            ],
            '100'     => [
                'title' => __('Réservation%s annulée'),
                'data'  => [],
            ]
        ];

        $allowedStatuses = [10, 50, 90, 100, 110];

        foreach ($reservations as $reservation) {
            if (in_array($reservation['statut'], $allowedStatuses)) {
                $endDate = new Date($reservation['fin_at']);

                switch ($reservation['statut']) {
                    case 50:
                        $resData[$reservation['statut']]['data'][] = $reservation;
                        break;
                    case 90:
                        if ($currentDate > new Date($endDate)) {
                            $resData['90_past']['data'][] = $reservation;
                        } else {
                            $resData[$reservation['statut']]['data'][] = $reservation;
                        }
                        break;
                    case 10:
                    case 100:
                    case 110:
                        $resData['100']['data'][] = $reservation;
                        break;
                }
            }
        }

        $session = $this->request->session();
        $selected_reservation_id = 0;

        if (!empty($this->request->query['res_id'])) {
            $selected_reservation_id = $this->request->query['res_id'];
        } elseif (!empty($session->read("reservation_id"))) {
            $selected_reservation_id = $session->read("reservation_id");
            $session->delete('reservation_id');
        }

        $this->set('reservations', $resData);
        $this->set('selected_reservation_id', $selected_reservation_id);
    }
	/*
	 *
	 */
	function reservationsLocataire(){
			$path = Router::url('/', true);
			$l_reservationsstatuts=array('0'=>'En cours','10'=>'Supprimee','90'=>'Validee Proprietaire','100'=>'Demande annulation en attente','110'=>'Annulée');
			$res=$this->Reservations->getReservationsLocataire($this->Auth->user('id'));
			$output = array(
                    "sEcho" => intval($_GET['sEcho']),
                    "iTotalRecords" => 4,
                    "iTotalDisplayRecords" => 4,
                    "aaData" => array()
                    );
			foreach($res as $key=>$enr){
        $row[0]="du ".$enr->dbt_at->i18nFormat('dd-MM')." au ".$enr->fin_at->i18nFormat('dd-MM-yyyy');
				$row[1]=$enr->dispo['total'];
				$row[2]=$l_reservationsstatuts[$enr->statut];
				$row[3]=html_entity_decode($enr->utilisateur['nom_famille']." ".$enr->utilisateur['prenom']);
				$row[4]=$enr->utilisateur['telephone']." ".$enr->utilisateur['email'];
				$row[5]="<a title='Modifier' style='cursor:pointer' onclick='open_dialog(\"".$enr->id."\")' src='".$path."images/edit.png'><i class='fa fa-edit fa-lg'></i></a>";
				$row[6]="<a title='Supprimer' style='cursor:pointer' onclick='open_dialog_delete(\"".$enr->id."\")' src='".$path."images/delete.png'><i class='fa fa-times fa-lg'></i></a>";
				$output['aaData'][] = $row;
			}
			echo json_encode($output);die();
	}
    /**
     * Validation par le propriétaire, des demandes de réservation
     */
    function validation($id_annonce=NULL)
    {
        $this->loadModel("Annonces");
        $this->loadModel("Utilisateurs");

        if ($id_annonce != NULL) {
            $ann = $this->Annonces->get($id_annonce);
            $prop_id = $ann->proprietaire_id;
        } else {
            $prop_id = $this->Auth->user('id');
        }

        $infoprop = $this->Utilisateurs->get($prop_id, ['contain'=>['Cautions', 'Paiements', 'Annulations']]);

        $tauxcommession = ($infoprop->nature == "PRES" && !empty($infoprop->paiements) && $infoprop->paiements[0]->taux_commission != 0) ? $infoprop->paiements[0]->taux_commission : 3;

        $this->set('tauxcommession', $tauxcommession);

        if (!empty($this->request->data)) {
            $statut = 0;

            $retourmsg = "";

            if (isset($this->request->data['accepter']) && $this->request->data['accepter'] == "Accepter") {
                $statut = 90;
                $this->Flash->success(__('La réservation a bien été acceptée'),['clear'=> true]);
            }

            if (isset($this->request->data['refuser']) && $this->request->data['refuser'] == "Refuser"){
                $statut = 10;
                $this->Flash->error(__('La réservation a bien été refusée'),['clear'=> true]);
            }

            if ($statut > 0) {
                $cpt = 0;
                $rfs = 0;

                foreach ($this->request->data["sel"] as $sel) {
                    if ($sel > 0) {
                        $cpt++;

                        if ($statut == 10) {
                            $this->refusReservation($sel, $prop_id, $this->request->data["refusReservationCltHidden".$sel], $this->request->data["note_refus"], $this->request->data["raison_refus"]);
                            $rfs++;
                        } else {
                            $this->acceptReservation($sel, $prop_id, $this->request->data["acceptationReservationCltHidden".$sel], $this->request->data["acceptationReservationAdmHidden".$sel]);

                            $this->set('accept_res',$sel);
                        }
                    }
                }
            }

            if ($cpt == 0)  $this->Flash->error(__('Aucune ligne sélectionnée'),['clear'=> true]);

            if($rfs != 0) $retourmsg = "refusnote";

            $this->set('retourmsg', $retourmsg);
        }

        $mail = [];

        $this->loadModel("Modelmailsysteme");
        $textEmail = $this->Modelmailsysteme->find('all');

        foreach ($textEmail as $key => $value) {
            $mail[$value->titre] = $value->txtmail;
        }

        $this->set("textmail",$mail);

        $proprietaire = $this->Utilisateurs->get($prop_id);

        $this->set('proprietaire', $proprietaire);

        // verifier Commande Pour Proprietaire
        $this->loadModel("Lieugeos");
        $this->loadModel("Registres");
        $this->loadModel("Annoncegestionnaires");
        $this->loadModel("Gestionnaires");

        $listeReservations = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(['Annonces.proprietaire_id' => $prop_id,"Reservations.dbt_at > CURDATE()", "Reservations.statut = 0", "Reservations.increment_id <> 0", "Reservations.verif_for_prop = 0"]);

        foreach ($listeReservations as $reservation) {
            /* On récupère l'ID commande */
            $magentoURL = BOUTIQUE_ALPISSIME; // a changer pour le com

            $IncrementId = $reservation->increment_id; //tu le récupère de ta base de donnée

            $ch = curl_init($magentoURL . "index.php/rest/all/V1/cakephp/getOrderId?IncrementId=".$IncrementId);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            $resultat = curl_exec($ch);
            $commande_id = json_decode($resultat);
            curl_close($ch);

            if (!is_numeric($commande_id)) {
                // throw $th;
                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail = $mails->first();

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
            $a_reservation = [
                "statut"         =>50,
                'updated_at'     => date('d-m-Y'),
                "verif_for_prop" => 1,
                "commande_id"    => $commande_id
            ];

            $reservationnew = $this->Reservations->patchEntity($reservation, $a_reservation);

            $this->Reservations->save($reservation);

            /* on lance les emails vers prop + admin + gestionnaire */
            $user      = $this->Utilisateurs->get($reservation['annonce']['proprietaire_id']);
            $locataire = $this->Utilisateurs->get($reservation->utilisateur_id);
            $annonce   = $this->Annonces->get($reservation->annonce_id);
            $lieugeo   = $this->Lieugeos->get($reservation['annonce']['lieugeo_id']);

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
            $mail  = $mails->first();

            // #####################################################
            $event = new Event('Email.send', $this, [
                'from'      => [$mail->val=>FROM_MAIL],
                'to'        => $user,
                'textEmail' => 'creationReservation',
                'data'      => $datamustache,
                'template'  => 'creationReservation',
                'viewVars'  => 'creationReservation',
                'noReply'   => false
            ]);

            $this->eventManager()->dispatch($event);
            Log::write('info', 'Send mail creationReservation to '.$user->email);
            // #####################################################

            // #####################################################
            $event = new Event('Email.send', $this, [
                'from'      => $user->email,
                'to'        => $mail->val,
                'textEmail' => 'creationReservationAdm',
                'data'      => $datamustache,
                'template'  => 'creationReservationAdm',
                'viewVars'  => 'creationReservationAdm',
                'noReply'   => false
            ]);
            $this->eventManager()->dispatch($event);
            // #####################################################

            //Envoyer copie pour gestionnaire s'il existe
            $this->loadModel("Gestionnaires");
            if ($annonce->id_gestionnaires != 0) {
                $anngest = $this->Gestionnaires->find()->where(['id'=>$annonce->id_gestionnaires]);
            } else {
                $anngest = $this->Gestionnaires->find("all")->join([
                    'GV' => [
                         'table'      => 'gestionnaires_villages',
                         'type'       => 'inner',
                         'conditions' => ['Gestionnaires.id=GV.gestionnaire_id','GV.villages_id'=>$annonce->village]
                    ]
                ]);
            }

            if ($anngestnew = $anngest->first()) {
                $gestio = $anngestnew;

                // #####################################################
                $event = new Event('Email.send', $this, [
                    'from'      => $user->email,
                    'to'        => $gestio->email,
                    'textEmail' => 'creationReservationAdm',
                    'data'      => $datamustache,
                    'template'  => 'creationReservationAdm',
                    'viewVars'  => 'creationReservationAdm',
                    'noReply'   => false
                ]);
                $this->eventManager()->dispatch($event);
                // #####################################################
            }
        }

        $data = $this->paginate($this->Reservations->getReservationsAValider($prop_id));

        $this->set('reservations', $data);
    }
	 /**
     *
     */
    public function deletereservation($id_reservation = null, $textmail = null)
    {
			$this->viewBuilder()->layout(false);
			$this->autoRender = false;
			$textmail = $this->request->data['textmail'];
	    	$reservation=$this->Reservations->get($id_reservation, ['contain' => ['Annonces'=>['Lieugeos','Villages']]]);
			/*** LOCATAIRE ***/
			$this->loadModel("Utilisateurs");
			$locataire = $this->Utilisateurs->get($reservation->utilisateur_id);
			/*** PROPRIETAIRE ***/
			$this->loadModel("Annonces");
			$annonce = $this->Annonces->get($reservation->annonce_id);
			$proprietaire = $this->Utilisateurs->get($annonce->proprietaire_id);					
			/*** SUPPRESSION RESERVATION ***/
			$this->loadModel('Annoncegestionnaires');
	    	$this->loadModel('Gestionnaires');
			$id_googlecalendar = $reservation->id_googlecalendar;
                        $debreservation = $reservation->dbt_at;
                        $fnreservation = $reservation->fin_at;
                        $anidreservation = $reservation->annonce_id;
			// $gest_resp = $this->Annoncegestionnaires->find()->where(["Annoncegestionnaires.id_annonces=".$reservation->annonce_id])->select(["Annoncegestionnaires.id_gestionnaires"]);
			$entity_id = $reservation->commande_id;
			if($reservation->statut != 90) {
				$dataannulreserv = array("statut"=>10);
				$reservationannul=$this->Reservations->patchEntity($reservation,$dataannulreserv);
				$this->Reservations->save($reservationannul);
				/*** Modification Statut de disponibilité ***/
				$this->loadModel("Dispos");
				$dispos=$this->Dispos->find('all')->where(['Dispos.reservation_id'=>$id_reservation]);
				foreach ($dispos as $dispo) {
					$a_dispo=array('statut'=>0,'utilisateur_id'=>null,'reservation_id'=>null);
					$dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
					$this->Dispos->save($dispo);
					Log::write('info', 'Suppression Reservation + Dispos (deletereservation) : reservationID: '.$id_reservation.'__modifDispoID: '.$dispo->id);
				}
				// $reservation=$this->Reservations->delete($reservation);
				$order = '{
					"entity": {
					"entity_id": '.$entity_id.',
						"state": "canceled",
						"status": "reservation_annulee"
					}
				}';

				/*** ENVOI MAIL ***/
				$datamustache = array('prenom' => $locataire->prenom, 'nom' => $locataire->nom_famille, 'prenomprop' => $proprietaire->prenom, 'nomprop' => $proprietaire->nom_famille, 'debut' => $debreservation, 'fin' => $fnreservation, 'annonce' => $anidreservation);
							
				$this->loadModel("Registres");
				$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
				$mail=$mails->first();
				// #####################################################
				$event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $locataire,'textEmail'=>'supressionReservationProp',
				'data'=>$datamustache,'template'=>'supressionReservationProp','viewVars'=>'supressionReservationProp','noReply'=>false
			   ]);
				$this->eventManager()->dispatch($event);
				// #####################################################

				// #####################################################
				$event = new Event('Email.send', $this, ['from'=>$proprietaire->email,'to' => $mail->val,'textEmail'=>'supressionReservationProp',
								'data'=>$datamustache,'template'=>'supressionReservationProp','viewVars'=>'supressionReservationProp','noReply'=>false
							]);
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
				// $this->loadModel("Annoncegestionnaires");
				// $anngest = $this->Annoncegestionnaires->find()->where(['id_annonces'=>$anidreservation]);
				if($anngestnew = $anngest->first()){
					$gestio = $anngestnew;
					$event = new Event('Email.send', $this, ['from'=>$proprietaire->email,'to' => $gestio->email,'textEmail'=>'supressionReservationProp',
									'data'=>$datamustache,'template'=>'creationReservationAdm','viewVars'=>'creationReservationAdm','noReply'=>false]);
					$this->eventManager()->dispatch($event);
				}	
			}
			else{
				$dataannulreserv = array("statut"=>110);
				$reservationannul=$this->Reservations->patchEntity($reservation,$dataannulreserv);
				$this->Reservations->save($reservationannul);
				/*** Modification Statut de disponibilité ***/
				$this->loadModel("Dispos");
				$dispos=$this->Dispos->find('all')->where(['Dispos.reservation_id'=>$id_reservation]);
				foreach ($dispos as $dispo) {
					$a_dispo=array('statut'=>0,'utilisateur_id'=>null,'reservation_id'=>null);
					$dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
					$this->Dispos->save($dispo);
					Log::write('info', 'Suppression Reservation + Dispos (deletereservation) : reservationID: '.$id_reservation.'__modifDispoID: '.$dispo->id);
				}
				if($reservation->type == 0){
					$this->loadModel("Penalitepropannulation");
					$penaliteprop = $this->Penalitepropannulation->find("all")->where(['utilisateur_id' => $proprietaire->id]);
					if($penaliteprop = $penaliteprop->first()){
						$nbrpenalite = $penaliteprop->nbr_penalite + 1;
						$annulationprop=array('nbr_penalite'=>$nbrpenalite);
						$annulationpropupdate=$this->Penalitepropannulation->patchEntity($penaliteprop,$annulationprop);
						$this->Penalitepropannulation->save($annulationpropupdate);
					}else{
						$annulationprop=array('nbr_penalite'=>1, 'utilisateur_id'=>$proprietaire->id);
						$annulationpropupdate=$this->Penalitepropannulation->newEntity($annulationprop);
						$this->Penalitepropannulation->save($annulationpropupdate);
					}
				}
				// Envoie mail 
				// annulationreservationprop vers locataire + admin
				$datamustache = array('prenom' => $locataire->prenom, 'nom' => $locataire->nom_famille, 'prenomprop' => $proprietaire->prenom, 'nomprop' => $proprietaire->nom_famille, 'datedebut' => $reservation->dbt_at, 'datefin' => $reservation->fin_at);                       
				$this->loadModel("Registres");
				$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
				$mail=$mails->first();
				// #####################################################
				$event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $locataire,'textEmail'=>'annulationreservationprop',
					'data'=>$datamustache,'template'=>'supressionReservationProp','viewVars'=>'supressionReservationProp','noReply'=>false
				]);
				$this->eventManager()->dispatch($event);
				// #####################################################
				$event = new Event('Email.send', $this, ['from'=>$proprietaire->email,'to' => $mail->val,'textEmail'=>'annulationreservationprop',
					'data'=>$datamustache,'template'=>'supressionReservationProp','viewVars'=>'supressionReservationProp','noReply'=>false
				]);
				$this->eventManager()->dispatch($event);
				// Send SMS to locataire
				if(PROD_ON == 1){
					/** Send Sms to Locataire **/				
					$datamustachesms = array('prenomprop' => $proprietaire->prenom, 'nomprop' => $proprietaire->nom_famille);
					$sendTo = $locataire->portable;
					// #####################################################
					$event = new Event('Email.sendSms', $this, ['from'=>"alpissime",'to' => $sendTo,'textSms'=>'annulationreservationprop',
															'data'=>$datamustachesms
															]);
					$this->eventManager()->dispatch($event);
					// #####################################################
					Log::write('info', 'Send sms annulationreservationprop to '.$loc->email);
				}  
				if($reservation->type == 0){
					// #####################################################
					$m = new Mustache_Engine;
					$data = array('prenom' => $locataire->prenom, 'nom' => $locataire->nom_famille, 'prenomprop' => $proprietaire->prenom, 'nomprop' => $proprietaire->nom_famille, 'annonce_id' => $reservation->annonce_id, 'reservation_id' => $reservation->id, 'commande_id' => $reservation->commande_id, 'datedebut' => $reservation->dbt_at, 'datefin' => $reservation->fin_at, 'annulation' => 'Propriétaire');
					$contenueText = "Nouvelle annulation de réservation donnant lieu à remboursement : 
					<br>
					Annonce # {{annonce_id}}<br>
					Réservation #{{reservation_id}}<br>
					Commande #{{commande_id}}<br><br>				
					Dates : {{datedebut}} {{datefin}}<br>
					Locataire : {{prenom}} {{nom}}<br>
					Propriétaire : {{prenomprop}} {{nomprop}}<br><br>				
					Réservation annulée par : {{annulation}}";
					$text = $m->render($contenueText, $data);
					$sujet = "Nouvelle annulation de réservation donnant lieu à remboursement";
					$email = new Email('production');
					$email->template('supressionReservationProp', 'default')
						->emailFormat('html')
						->to("annulations@alpissime.com")
						->from([$mail->val=>FROM_MAIL]);
					$email->subject($sujet)
						->viewVars(['supressionReservationProp' => $text]);
					$email->send();
					// #####################################################
				}
				
				/*** REMBOURSEMENT LOCATAIRE SUR SITE BOUTIQUE ***/
				// A FAIRE

				$order = '{
					"entity": {
					"entity_id": '.$entity_id.',
						"state": "canceled",
						"status": "reservation_annulee"
					}
				}';
			}
			// Changer statut commande vers "Annulée"
			//**** informations a utiliser toujours ********************//
			$magentoURL = BOUTIQUE_ALPISSIME; // a changer pour le com
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
			
			$ch = curl_init($magentoURL . "rest/" . $station . "/V1/orders");
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $order);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
			$result = curl_exec($ch);
			$result = json_decode($result, true);
			curl_close($curl); 
			// FIN Changer statut commande vers "Annulée"

			Log::write('info', 'Suppression Reservation (deletereservation) : reservationID: '.$id_reservation);
			if(PROD_ON == 1){
				/*** DELETE GOOGLE CALENDAR ***/
				if($id_googlecalendar != NULL) {
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
			}	
			
                        
	}
	/**
	 * 
	 */
	public function deletereservationlocatairejustif($id_reservation = null, $textmail = null)
	{
		$this->viewBuilder()->layout(false);
		$this->autoRender = false;
		$this->loadModel("AnnulationReservations");
		$reservation=$this->Reservations->get($id_reservation, ['contain' => ['Annonces'=>['Lieugeos','Villages']]]);
		/*** LOCATAIRE ***/
		$this->loadModel("Utilisateurs");
		$locataire = $this->Utilisateurs->get($reservation->utilisateur_id);
		/*** PROPRIETAIRE ***/
		$this->loadModel("Annonces");
		$annonce = $this->Annonces->get($reservation->annonce_id);
		$proprietaire = $this->Utilisateurs->get($annonce->proprietaire_id);
		/*** Paramètre mail ***/
		$this->loadModel("Registres");
		$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
		$mail=$mails->first();

		// $params = array();
		// print_r($this->request->data);
		// parse_str($this->request->data["formdata"], $params);
		// $motif = "";

		if($this->request->data["justificatif"] == 1){
			// Motif String
			// if(isset($this->request->data["maladie"])) $motif .= "maladie;";
			// if(isset($this->request->data["deces"])) $motif .= "deces;";
			// if(isset($this->request->data["officielle"])) $motif .= "officielle;";
			// if(isset($this->request->data["autre"])) $motif .= "autre;";

			// UPLOAD FILE
			$msgUpload = "";
			$target_dir = "annulation_files/";
			$target_file = $target_dir . basename($_FILES["fileJustificatif"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if file already exists
			if (file_exists($target_file)) {
				// echo "Sorry, file already exists.";
				$msgUpload = "fileExist";
				$uploadOk = 0;
			}
			// Check file size
			// if ($_FILES["fileJustificatif"]["size"] > 500000) {
			// 	echo "Sorry, your file is too large.";
			// 	$uploadOk = 0;
			// }
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf") {
				echo "Sorry, only JPG, JPEG, PNG, GIF & pdf files are allowed.";
				$msgUpload = "fileTypeError";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileJustificatif"]["tmp_name"], $target_file)) {
					// echo "The file ". basename( $_FILES["fileJustificatif"]["name"]). " has been uploaded.";
					$msgUpload = "OK";
				} else {
					$msgUpload = "problem";
					// echo "Sorry, there was an error uploading your file.";
				}
			}
			// END UPLOAD FILE

			$datannulation = array("justificatif" => $this->request->data["justificatif"], "motif_annulation" => $this->request->data["motif"], "file"=>basename($_FILES["fileJustificatif"]["name"]), "commentaire" => $this->request->data["commentaire"], "reservation_id" => $this->request->data["idreservation"], "statut" => "Demande en attente", "annulationpar" => "Locataire");
			// MODIFIER STATUT DE RESERVATION VERS NOUVEAU STATUT ATTENTE VALIDATION ANNULATION
			$reservation=$this->Reservations->get($id_reservation);
			$dataReserv = array("statut" => 110);
			$newstatut=$this->Reservations->patchEntity($reservation,$dataReserv);
			$this->Reservations->save($newstatut);
			// NOUVEAU TEMPLATE EMAIL DEMANDE ANNULATION
			// A FAIRE
			$datamustache = array();		
			#####################################################
			$event = new Event('Email.send', $this, ['from'=>$locataire->email,'to' => $mail->val,'textEmail'=>'demandeacceptationjustif',
														'data'=>$datamustache,'template'=>'supressionReservationLoc','viewVars'=>'supressionReservationLoc','noReply'=>false
													]);
			$this->eventManager()->dispatch($event);
			#####################################################
			 
		}else{
			$datannulation = array("justificatif" => $this->request->data["justificatif"], "motif_annulation" => "_", "file"=>"_", "commentaire" => "_", "reservation_id" => $this->request->data["idreservation"], "statut" => "Annulation validée", "montant_rembourser" => $this->request->data["prixremboursement"], "annulationpar" => "Locataire");
			/** ENVOYER MONTANT A REMBORSER VERS LA BOUTIQUE **/
			//print_r($this->request->data["prixremboursement"]);
			// MODIFIER STATUT DE RESERVATION VERS SUPPRIMER
			$reservation=$this->Reservations->get($id_reservation);
			$dataannulreserv = array("statut"=>110);
			$reservationannul=$this->Reservations->patchEntity($reservation,$dataannulreserv);
			$this->Reservations->save($reservationannul);
			// {{prenom}} {{prenomprop}} {{datedebut}} {{datefin}} {{montant}}
			$montant = $this->request->data["inputMontantProp"];
			$datamustache = array('prenom' => $locataire->prenom, 'nom' => $locataire->nom_famille, 'prenomprop' => $proprietaire->prenom, 'nomprop' => $proprietaire->nom_famille, 'datedebut'=>$reservation->dbt_at, 'datefin'=>$reservation->fin_at, 'montant' => $montant);		
			#####################################################
			$event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire,'textEmail'=>$this->request->data["inputMailSansJustification"],
														'data'=>$datamustache,'template'=>'supressionReservationLoc','viewVars'=>'supressionReservationLoc','noReply'=>false
													]);
			$this->eventManager()->dispatch($event);
			#####################################################
			$event = new Event('Email.send', $this, ['from'=>$proprietaire->email,'to' => $mail->val,'textEmail'=>$this->request->data["inputMailSansJustification"],
													'data'=>$datamustache,'template'=>'supressionReservationLoc','viewVars'=>'supressionReservationLoc','noReply'=>false
												]);
			$this->eventManager()->dispatch($event);
			#####################################################
		}
		if($reservation->type == 0){
			// #####################################################
			$m = new Mustache_Engine;
			$data = array('prenom' => $locataire->prenom, 'nom' => $locataire->nom_famille, 'prenomprop' => $proprietaire->prenom, 'nomprop' => $proprietaire->nom_famille, 'annonce_id' => $reservation->annonce_id, 'reservation_id' => $reservation->id, 'commande_id' => $reservation->commande_id, 'datedebut' => $reservation->dbt_at, 'datefin' => $reservation->fin_at, 'annulation' => 'Locataire');
			$contenueText = "Nouvelle annulation de réservation donnant lieu à remboursement : 
			<br>
			Annonce # {{annonce_id}}<br>
			Réservation #{{reservation_id}}<br>
			Commande #{{commande_id}}<br><br>				
			Dates : {{datedebut}} {{datefin}}<br>
			Locataire : {{prenom}} {{nom}}<br>
			Propriétaire : {{prenomprop}} {{nomprop}}<br><br>				
			Réservation annulée par : {{annulation}}";
			$text = $m->render($contenueText, $data);
			$sujet = "Nouvelle annulation de réservation donnant lieu à remboursement";
			$email = new Email('production');
			$email->template('supressionReservationProp', 'default')
				->emailFormat('html')
				->to("annulations@alpissime.com")
				->from([$mail->val=>FROM_MAIL]);
			$email->subject($sujet)
				->viewVars(['supressionReservationProp' => $text]);
			$email->send();
			// #####################################################
		}
		
		$AnnulationReservations = $this->AnnulationReservations->newEntity($datannulation);
		$this->AnnulationReservations->save($AnnulationReservations);
		// print_r($params);
		// Envoie mail prop / admin
		// $datamustache = array();		
		// #####################################################
		// $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire,'textEmail'=>'annulationreservationloc',
		// 											'data'=>$datamustache,'template'=>'supressionReservationLoc','viewVars'=>'supressionReservationLoc','noReply'=>false
		// 										]);
		// $this->eventManager()->dispatch($event);
		// #####################################################
		
		
		/*** SUPPRESSION RESERVATION ***/
		$this->loadModel('Annoncegestionnaires');
					$this->loadModel('Gestionnaires');
		$id_googlecalendar = $reservation->id_googlecalendar;
					$debreservation = $reservation->dbt_at;
					$fnreservation = $reservation->fin_at;
					$anidreservation = $reservation->annonce_id;
		// $gest_resp = $this->Annoncegestionnaires->find()->where(["Annoncegestionnaires.id_annonces=".$reservation->annonce_id])->select(["Annoncegestionnaires.id_gestionnaires"]);
		// $reservation=$this->Reservations->delete($reservation);		
		Log::write('info', 'Suppression Reservation (deletereservationlocatairejustif) : reservationID: '.$id_reservation);
		/*** Modification Statut de disponibilité ***/
		$this->loadModel("Dispos");
		$dispos=$this->Dispos->find('all')->where(['Dispos.reservation_id'=>$id_reservation]);
		foreach ($dispos as $dispo) {
			$a_dispo=array('statut'=>0,'utilisateur_id'=>null,'reservation_id'=>null);
			$dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
			$this->Dispos->save($dispo);
			Log::write('info', 'Suppression Reservation + Dispos (deletereservationlocatairejustif) : reservationID: '.$id_reservation.'__modifDispoID: '.$dispo->id);
		}
		if(PROD_ON == 1){
			/*** DELETE GOOGLE CALENDAR ***/
			if($id_googlecalendar != NULL) {
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
		}	
		// Changer le statut de la commande vers annulé
		//**** informations a utiliser toujours ********************//
		$magentoURL = BOUTIQUE_ALPISSIME;
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
		
		/*** ENVOI MAIL ***/
		$datamustache = array('prenom' => $locataire->prenom, 'nom' => $locataire->nom_famille, 'debut' => $debreservation, 'fin' => $fnreservation, 'annonce' => $anidreservation);
					
		$this->loadModel("Registres");
		$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
		$mail=$mails->first();
	}
		/**
		 *
		 **/
		public function deletereservationlocataire($id_reservation = null, $textmail = null){
			$this->viewBuilder()->layout(false);
			$textmail = $this->request->data['textmail'];
			$reservation=$this->Reservations->get($id_reservation, ['contain' => ['Annonces'=>['Lieugeos','Villages']]]);
			/*** LOCATAIRE ***/
			$this->loadModel("Utilisateurs");
			$locataire = $this->Utilisateurs->get($reservation->utilisateur_id);
			/*** PROPRIETAIRE ***/
			$this->loadModel("Annonces");
			$annonce = $this->Annonces->get($reservation->annonce_id);
			$proprietaire = $this->Utilisateurs->get($annonce->proprietaire_id);
			/*** SUPPRESSION RESERVATION ***/
			$this->loadModel('Annoncegestionnaires');
                        $this->loadModel('Gestionnaires');
			$id_googlecalendar = $reservation->id_googlecalendar;
                        $debreservation = $reservation->dbt_at;
                        $fnreservation = $reservation->fin_at;
                        $anidreservation = $reservation->annonce_id;
			// $gest_resp = $this->Annoncegestionnaires->find()->where(["Annoncegestionnaires.id_annonces=".$reservation->annonce_id])->select(["Annoncegestionnaires.id_gestionnaires"]);
			$dataannulreserv = array("statut"=>10);
			$reservationannul=$this->Reservations->patchEntity($reservation,$dataannulreserv);
			$this->Reservations->save($reservationannul);
			// Changer statut commande vers "Annulée"
			if($reservation->commande_id != 0){
				//**** informations a utiliser toujours ********************//
				$magentoURL = BOUTIQUE_ALPISSIME; // a changer pour le com
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
				// FIN Changer statut commande vers "Annulée"
			}			
			// $reservation=$this->Reservations->delete($reservation);
			Log::write('info', 'Suppression Reservation (deletereservationlocataire) : reservationID: '.$id_reservation);
			if(PROD_ON == 1){
				/*** DELETE GOOGLE CALENDAR ***/
				if($id_googlecalendar != NULL) {
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
			}
			/*** Modification Statut de disponibilité ***/
			$this->loadModel("Dispos");
			$dispos=$this->Dispos->find('all')->where(['Dispos.reservation_id'=>$id_reservation]);
			foreach ($dispos as $dispo) {
				$a_dispo=array('statut'=>0,'utilisateur_id'=>null,'reservation_id'=>null);
				$dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
				$this->Dispos->save($dispo);
				Log::write('info', 'Suppression Reservation + Dispos (deletereservationlocataire) : reservationID: '.$id_reservation.'__modifDispoID: '.$dispo->id);
			}
			/*** ENVOI MAIL ***/
                        $datamustache = array('prenom' => $locataire->prenom, 'nom' => $locataire->nom_famille, 'debut' => $debreservation, 'fin' => $fnreservation, 'annonce' => $anidreservation);
                        
			$this->loadModel("Registres");
			$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
			$mail=$mails->first();
                        // #####################################################
                        $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire,'textEmail'=>'supressionReservationLoc',
                                                                 'data'=>$datamustache,'template'=>'supressionReservationLoc','viewVars'=>'supressionReservationLoc','noReply'=>false
                                                                ]);
                        $this->eventManager()->dispatch($event);
                        // #####################################################
                        
                        // #####################################################
                        $event = new Event('Email.send', $this, ['from'=>$locataire->email,'to' => $mail->val,'textEmail'=>'supressionReservationLoc',
                                                                 'data'=>$datamustache,'template'=>'supressionReservationLoc','viewVars'=>'supressionReservationLoc','noReply'=>false
                                                                ]);
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
						// $this->loadModel("Annoncegestionnaires");
						// $anngest = $this->Annoncegestionnaires->find()->where(['id_annonces'=>$anidreservation]);
						if($anngestnew = $anngest->first()){
							$gestio = $anngestnew;
							$event = new Event('Email.send', $this, ['from'=>$proprietaire->email,'to' => $gestio->email,'textEmail'=>'supressionReservationLoc',
																 'data'=>$datamustache,'template'=>'creationReservationAdm','viewVars'=>'creationReservationAdm','noReply'=>false]);
							$this->eventManager()->dispatch($event);
						}	
		}
	/**
     * Traitements liés au refus de la réservation par le propriétaire
     *
     * - envoi d'un mail d'annulation de la réservation pour le client
     *
     * @param <array> $annonce
     * @param <array> $reservation
     * @param <array> $client
     * @param <int> $proprietaire_id
     */
  	private function refusReservation($id_reservation, $proprietaire_id, $textEmail, $note_refus, $raison_refus)
  	{
		//modification le statut de la réservation
		$reservation=$this->Reservations->get($id_reservation, ['contain' => ['Annonces'=>['Lieugeos','Villages']]]);
		$a_reservation=array("statut"=>10,'updated_at'=>$this->toDate(date('d-m-Y')), "note_refus"=>$note_refus, "raison_refus"=>$raison_refus);
		$reservation=$this->Reservations->patchEntity($reservation,$a_reservation);
		$this->Reservations->save($reservation);
		//modficataion le statu de disponibilité
		$this->loadModel("Dispos");
    	$dispos=$this->Dispos->find('all',['conditions'=>['Dispos.reservation_id'=>$id_reservation]]);
		foreach ($dispos as $dispo) {
			$a_dispo=array('statut'=>100,'utilisateur_id'=>null,'reservation_id'=>null);
			$dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
			$this->Dispos->save($dispo);
			Log::write('info', 'Refus Reservation : reservationID: '.$id_reservation.'__modifDispoID: '.$dispo->id);
		}		
		// Ajout annulation par proprietaire
		$this->loadModel("Annonces");
		$annonce=$this->Annonces->get($reservation->annonce_id);
		$this->loadModel("Utilisateurs");
		$prop=$this->Utilisateurs->get($annonce->proprietaire_id);
		if($prop->nature != "PRES"){
			/*** Nbr Annulation Prop ***/
			$nbrannulation = $prop->nbr_annulation + 1;	
			$prop_data=array('nbr_annulation'=>$nbrannulation);
			$new_prop=$this->Utilisateurs->patchEntity($prop,$prop_data);
			$this->Utilisateurs->save($new_prop);
		}				

		// Changer statut commande vers "Annulée"
		//**** informations a utiliser toujours ********************//
		$magentoURL = BOUTIQUE_ALPISSIME; // a changer pour le com
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
		// FIN Changer statut commande vers "Annulée"

		$this->loadModel("Registres");				
		$loc=$this->Utilisateurs->get($reservation->utilisateur_id);
		$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
		$mail=$mails->first();
                $datamustache = array('nomprop' => $prop->nom_famille, 'prenomprop' => $prop->prenom, 'annonce' => $annonce->id, 'prenom' => $loc->prenom, 'nom' => $loc->nom_famille, 'debut' => $reservation->dbt_at, 'fin' =>$reservation->fin_at, 'note_refus'=>$note_refus);
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $loc,'textEmail'=>'refusReservationClt',
                                                         'data'=>$datamustache,'template'=>'refusReservationClt','viewVars'=>'refusReservationClt','noReply'=>false
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################

				if(PROD_ON == 1){
					/** Send Sms to Locataire **/				
					$datamustachesms = array('prenomprop' => $prop->prenom, 'nomprop' => $prop->nom_famille, 'reservation' => $reservation->id);
					$sendTo = $loc->portable;
					// #####################################################
					$event = new Event('Email.sendSms', $this, ['from'=>"alpissime",'to' => $sendTo,'textSms'=>'refusReservationClt',
															'data'=>$datamustachesms
															]);
					$this->eventManager()->dispatch($event);
					// #####################################################
					Log::write('info', 'Send sms refusReservationClt to '.$loc->email);
				}                

                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>$prop->email,'to' => $mail->val,'textEmail'=>'refusReservationClt',
                                                         'data'=>$datamustache,'template'=>'refusReservationClt','viewVars'=>'refusReservationClt','noReply'=>false
                                                        ]);
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
					$event = new Event('Email.send', $this, ['from'=>$prop->email,'to' => $gestio->email,'textEmail'=>'refusReservationClt',
														 'data'=>$datamustache,'template'=>'creationReservationAdm','viewVars'=>'creationReservationAdm','noReply'=>false]);
					$this->eventManager()->dispatch($event);
				}	
    }
    /**
     * Traitements liés à l'acceptation d'une réservation par le propriétaire
     *
     * - extraction en CSV de la réservation et de ses packs
     * - envoi d'un mail récap. pour AMSA
     * - envoi d'un mail confirmation pour le client
     *
     * @param <array> $annonce : détail de l'annonce
     * @param <array> $reservation
     * @param <array> $pack
     * @param <array> $client
     * @param <int> $proprietaire_id*
     */
	private function acceptReservation($id_reservation, $proprietaire_id, $textmail, $textmailAdm)
    {
		$this->loadModel('Annoncegestionnaires');
	    $this->loadModel('Gestionnaires');
    	//modification le statut de la réservation
		$reservation=$this->Reservations->get($id_reservation, ['contain' => ['Annonces'=>['Lieugeos','Villages']]]);
		$a_reservation=array("statut"=>90,'updated_at'=>$this->toDate(date('d-m-Y')));
		$reservation=$this->Reservations->patchEntity($reservation,$a_reservation);
		$this->Reservations->save($reservation);
		/*** INSERT GOOGLE CALENDAR ***/
		$this->loadModel("Annonces");
		$annonce=$this->Annonces->get($reservation->annonce_id);
        $mainURL = Router::url('/', true);
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
		//modficataion le statut de disponibilité
		$this->loadModel("Dispos");
    	$dispos=$this->Dispos->find('all',['conditions'=>['Dispos.reservation_id'=>$id_reservation]]);
		foreach ($dispos as $dispo) {
			$a_dispo=array('statut'=>90,'updated_at'=>$this->toDate(date('d-m-Y')));
			$dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
			$this->Dispos->save($dispo);
			Log::write('info', 'Acceptation Reservation : reservationID: '.$id_reservation.'__modifDispoID: '.$dispo->id);
		}
		// Vérifier pénalité
		$this->loadModel("Utilisateurs");
		$prop=$this->Utilisateurs->get($annonce->proprietaire_id, ['contain'=>['Cautions', 'Paiements', 'Annulations']]);
		$this->loadModel("Penalites");
		if($prop->nbr_annulation >= 3){
			$penaliteData = array("utilisateur_id" => $prop->id, "reservation_id" => $id_reservation, "nbr_penalite" => intdiv($prop->nbr_annulation, 3));
			$penalite = $this->Penalites->newEntity($penaliteData);
			$this->Penalites->save($penalite);
			// mettre à jour la valeur de nbr_annulation			
			$utilannulationdata = array("nbr_annulation" => fmod($prop->nbr_annulation, 3));
			$propentity = $this->Utilisateurs->patchEntity($prop, $utilannulationdata);
			$this->Utilisateurs->save($propentity);
		}

		$this->loadModel("Registres");
		try{
			// Changer statut commande vers "Paiement en cours"
			//**** informations a utiliser toujours ********************//
			$magentoURL = BOUTIQUE_ALPISSIME; // a changer pour le com
			// $station = "fr";
			$order_id = $reservation->commande_id;
			$status = "paiement_en_cours";
			$states = "processing";
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $magentoURL . "rest/fr/V1/cakephp/setOrderStatus?orderId=" . $order_id . "&Status=" . $status . "&States=" . $states . "",
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
			// FIN Changer statut commande vers "Paiement en cours"
		} catch (\Throwable $th) {
			// throw $th;
			$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
			$mail=$mails->first();
			// #####################################################
			$email = new Email('production');
			$email->to('maroua.c@ite.digital')
				->from([$mail->val=>FROM_MAIL])
				->subject('Erreur dans setOrderStatus')
				->emailFormat('html')
				->send('Bonjour, <br><br> Erreur Function setOrderStatus : <br><br> '.$th);
		}
				
		$this->loadModel("Annonces");
		$this->loadModel("Photos");
		$annonce=$this->Annonces->get($reservation->annonce_id, ['contain' => ['Lieugeos','Villages']]);
		$loc=$this->Utilisateurs->get($reservation->utilisateur_id);
		$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
		$mail=$mails->first();
		$mail_base = [];
                $mail_text_must = [];
		$this->loadModel("Modelmailsysteme");
		$textEmail = $this->Modelmailsysteme->find('all');
		foreach ($textEmail as $key => $value) {
			$mail_base[$value->titre] = $value->sujet;
                        $mail_text_must[$value->titre] = $value->txtmail;
		}
                
                $m = new Mustache_Engine;
				// Ajout variable {{imageannonce}}
				$photo = $this->Photos->find()->where(['annonce_id' => $annonce->id])->order(['numero ASC'])->first();
				$nomImg = "vignette-".$photo->annonce_id."-".$photo->numero;

				$natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
				$village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
				$village_nom = str_replace(" – ", "-", $village_nom);
				$village_nom = str_replace(" ", "-", $village_nom);
				$nomImgG = $photo->titre;

				$urlimage1 = 'https://www.alpissime.com/images_ann/'.$annonce->id.'/'.$nomImgG;

				//Ajout variable {{description}} (160 premiers caractères de la description de l'annonce et finir par "..." si la description contient plus de 160 caractères)
				$desc160 = substr($annonce->description, 0, 160);
				if(strlen($annonce->description) > 160) $desc160 = $desc160." ...";

				$natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
				$lannonce = $this->string2url($annonce["titre"]);
				$hrefDetailAnn = 'station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;

				$listeVirement = $this->Reservations->find()->where(["Reservations.id" => $reservation->id])
				->join([   
					'annonce' => [
						'table' => 'annonces',
						'type' => 'inner',
						'conditions' => 'annonce.id=Reservations.annonce_id',
					],         
					'dispo' => [
						'table' => 'dispos',
						'type' => 'inner',
						'conditions' => 'dispo.reservation_id=Reservations.id',
					],
					'utilisateur' => [
						'table' => 'utilisateurs',
						'type' => 'inner',
						'conditions' => 'utilisateur.id=annonce.proprietaire_id',
					]
				]);
				$listeVirement->select(['Reservations.id','Reservations.date_virement','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','utilisateur.id','utilisateur.prenom','utilisateur.nom_famille','Reservations.prixreservation','dispo.promo_yn' , 'dispo.prix' , 'dispo.promo_px']);
				$listeVirement->order(['Reservations.dbt_at'=>'desc']);

				foreach ($listeVirement as $reservationSum) {
					if($reservationSum->prixreservation == 0){
						if($reservationSum['dispo']['promo_yn'] == 0) $prixtab[$reservationSum->id] += $reservationSum['dispo']['prix'];
						else $prixtab[$reservationSum->id] += $reservationSum['dispo']['promo_px'];
					}else{
						$prixtab[$reservationSum->id] = $reservationSum->prixreservation;
					}
				}
				if($prop->nature == "PRES" && !empty($prop->paiements) && $prop->paiements[0]->taux_commission != 0) $tauxcommession = $prop->paiements[0]->taux_commission;
				else $tauxcommession = 3;
				$montantreservation = round(($prixtab[$reservation->id]-($prixtab[$reservation->id]*$tauxcommession/100)), 2);
				
				$date_debut_dbt = new Date($reservation->dbt_at->i18nFormat('dd-MM-yyyy'));
				if($prop->nature == "PRES"){
					if(!empty($prop->paiements)){
						$datedevirement = $date_debut_dbt->modify( '-'.$prop->paiements[0]->nbr_jour.' days' );
					}else{
						$datedevirement = $date_debut_dbt;
					}
					if(new Date() >= $datedevirement) $datedevirement = (new Date())->modify( '+1 days' );
				}else{
					$datedevirement = $date_debut_dbt->modify( '+1 days' );
				}

				$this->loadModel('Gestionnaires');
				$this->loadModel('Residences');
				$this->loadModel('Lieugeos');
				$this->loadModel('Frvilles');
				$this->loadModel('BlocMailGestionnaires');
				$this->loadModel('Contrats');
				
				if($annonce->id_gestionnaires != 0) $blocsinfos = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => $annonce->id_gestionnaires])->first();
				else $blocsinfos = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => 6])->first();

				$redisence = $this->Residences->find()->where(['id' => $annonce->batiment])->first();
				$station = $this->Lieugeos->get($annonce->lieugeo_id);
				$ville = $this->Frvilles->find()->where(['id' => $annonce->ville])->first();
				
				if($annonce->contrat == 1){
					$bloc_info_arrivee = $blocsinfos->bloc_info_arrivee;
					$bloc_info_arrivee_en = $blocsinfos->bloc_info_arrivee_en;
					$bloc_info_depart = $blocsinfos->bloc_info_depart;
					$bloc_info_depart_en = $blocsinfos->bloc_info_depart_en;
	
					$arriveeDemainProp = "arriveeDemainProp";
				}else{
					$bloc_info_arrivee = $annonce->bloc_info_arrivee;
					$bloc_info_arrivee_en = "";
					$bloc_info_depart = $annonce->bloc_info_depart;
					$bloc_info_depart_en = "";
	
					$arriveeDemainProp = "arriveeDemainPropSansContart";
				}
				$adresse_gestionnaire = "";
				$ville_gestionnaire = "";
				$code_postal_gestionnaire = "";
				$gestionnaire_name = "";
				$gestionnaire = $this->Gestionnaires->find()->where(['id' => $annonce->id_gestionnaires]);
				if($gest = $gestionnaire->first()){
					$adresse_gestionnaire = $gest->adresse;
					$ville_gest = $this->Frvilles->find()->where(['id' => $gest->ville])->first();
					$ville_gestionnaire = $ville_gest->name;
					$code_postal_gestionnaire = $gest->code_postal;
					$gestionnaire_name = $gest->name;
				}

                $datamustache = [
                    'num_annonce'              => $annonce->num_app,
                    'residence'                => $redisence->name,
                    'station'                  => $station->name,
                    'code_postal'              => $annonce->code_postal,
                    'ville'                    => $ville->name,
                    'gestionnaire'             => $gestionnaire_name,
                    'adresse_gestionnaire'     => $adresse_gestionnaire,
                    'ville_gestionnaire'       => $ville_gestionnaire,
                    'code_postal_gestionnaire' => $code_postal_gestionnaire,
                    'bloc_info_arrivee'        => $bloc_info_arrivee,
                    'bloc_info_depart'         => $bloc_info_depart,
                    'bloc_info_horaires'       => $blocsinfos->bloc_info_horaires,
                    'bloc_info_arrivee_en'     => $bloc_info_arrivee_en,
                    'bloc_info_depart_en'      => $bloc_info_depart_en,
                    'bloc_info_horaires_en'    => $blocsinfos->bloc_info_horaires_en,
                    'datedevirement'           => $datedevirement,
                    'montantreservation'       => $montantreservation,
                    'nbrEnfant'                => $reservation->nb_enfants,
                    'nbrAdulte'                => $reservation->nb_adultes,
                    'nomprop'                  => $prop->nom_famille,
                    'prenomprop'               => $prop->prenom,
                    'annonce'                  => $annonce->titre,
                    'prenom'                   => $loc->prenom,
                    'nom'                      => $loc->nom_famille,
                    'tel'                      => $loc->portable,
                    'email'                    => $loc->email,
                    'debut'                    => $reservation->dbt_at,
                    'fin'                      => $reservation->fin_at,
                    'blockreduction'           => $textmail,
                    'imageannonce'             => $urlimage1,
                    'description'              => $desc160,
                    'annonceURL'               => $mainURL . $hrefDetailAnn,
                    'reservationURL'           => $mainURL . "reservations/view_reservation/" . $id_reservation
                ];
                // #####################################################
				$event = new Event('Email.send', $this,
                    [
                        'from'      => [$mail->val=>FROM_MAIL],
                        'to'        => $loc,
                        'textEmail' => "acceptationReservationClt",
                        'data'      => $datamustache,
                        'template'  =>'acceptationReservationClt',
                        'viewVars'  =>'acceptationReservationClt',
                        'noReply'   => false
                    ]
                );
                $this->eventManager()->dispatch($event);
				// #####################################################

				if(PROD_ON == 1){
					/** Send Sms to Locataire **/	
					$frais_menage = "";
					if($annonce->montant_frais_menage != 0)	$frais_menage = "Pensez à réserver le ménage réglé par le vacancier.";		
					$datamustachesms = array('prenomprop' => $prop->prenom, 'nomprop' => $prop->nom_famille, 'reservation' => $reservation->id, 'datedebut' => $reservation->dbt_at, 'datefin' => $reservation->fin_at, 'station' => $station->name, 'frais_menage' => $frais_menage);
					$sendTo = $loc->portable;
					// #####################################################
					$event = new Event('Email.sendSms', $this, ['from'=>"alpissime",'to' => $sendTo,'textSms'=>'acceptationReservationClt',
															'data'=>$datamustachesms
															]);
					$this->eventManager()->dispatch($event);
					// #####################################################
					Log::write('info', 'Send sms acceptationReservationClt to '.$loc->email);
				}
				
				// #####################################################
				$contrat = $this->Contrats->find("all")->where(['annonce_id' => $annonce->id]);
				if($prop->nature == "PRES") $textemail = "arriveePrevueLocResidence";
				else if($annonce->contrat == 1 && $contrat->first()) $textemail = "arriveePrevueLoc";
				else $textemail = "arriveePrevueLocSansContrat";
				
                $event = new Event('Email.send', $this,
                    [
                        'from'      => [$mail->val=>FROM_MAIL],
                        'to'        => $loc,
                        'textEmail' => $textemail,
                        'data'      => $datamustache,
                        'template'  => 'acceptationReservationClt',
                        'viewVars'  => 'acceptationReservationClt',
                        'noReply'   => false
                    ]
                );
                $this->eventManager()->dispatch($event);
                // #####################################################				
                $event = new Event('Email.send', $this,
                    [
                        'from'      => [$mail->val=>FROM_MAIL],
                        'to'        => $prop->email,
                        'textEmail' => 'acceptationReservationProp',
                        'data'      => $datamustache,
                        'template'  => 'acceptationReservationClt',
                        'viewVars'  => 'acceptationReservationClt',
                        'noReply'   => false
                    ]
                );
                $this->eventManager()->dispatch($event);
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>$prop->email,'to' => $mail->val,'textEmail'=>'acceptationReservationAdm',
                                                         'data'=>$datamustache,'template'=>'acceptationReservationAdm','viewVars'=>'acceptationReservationAdm','noReply'=>false
                                                        ]);
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
						$event = new Event('Email.send', $this, ['from'=>$prop->email,'to' => $gestio->email,'textEmail'=>'acceptationReservationAdm',
															 'data'=>$datamustache,'template'=>'creationReservationAdm','viewVars'=>'creationReservationAdm','noReply'=>false]);
						$this->eventManager()->dispatch($event);
						/*** Envoi mail commentaire proprietaire/locataire au gestionnaire s'il existe ***/
						if($reservation->comment != ""){
							$datamustachecomment = array('annonce' => $annonce->id, 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'commentaire' => $reservation->comment, 'role' => 'Propriétaire');
							$event = new Event('Email.send', $this, ['from'=>$prop->email,'to' => $gestio->email,'textEmail'=>'commentairereservation',
												'data'=>$datamustachecomment,'template'=>'acceptationReservationAdm','viewVars'=>'acceptationReservationAdm','noReply'=>false
											]);
							$this->eventManager()->dispatch($event);
						}
						if($reservation->commentlocataire != ""){
							$datamustachecommentloc = array('annonce' => $annonce->id, 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'commentaire' => $reservation->commentlocataire, 'role' => 'Locataire');
							$event = new Event('Email.send', $this, ['from'=>$loc->email,'to' => $gestio->email,'textEmail'=>'commentairereservation',
												'data'=>$datamustachecommentloc,'template'=>'acceptationReservationAdm','viewVars'=>'acceptationReservationAdm','noReply'=>false
											]);
							$this->eventManager()->dispatch($event);
						}
						/*** FIN Envoi mail commentaire proprietaire/locataire au gestionnaire s'il existe ***/
					}
				/*** Envoi mail commentaire proprietaire/locataire à l'admin s'il existe ***/
				if($reservation->comment != ""){
					$datamustachecomment = array('annonce' => $annonce->id, 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'commentaire' => $reservation->comment, 'role' => 'Propriétaire');
					$event = new Event('Email.send', $this, ['from'=>$prop->email,'to' => $mail->val,'textEmail'=>'commentairereservation',
										'data'=>$datamustachecomment,'template'=>'acceptationReservationAdm','viewVars'=>'acceptationReservationAdm','noReply'=>false
									]);
                	$this->eventManager()->dispatch($event);
				}
				if($reservation->commentlocataire != ""){
					$datamustachecommentloc = array('annonce' => $annonce->id, 'debut' => $reservation->dbt_at, 'fin' => $reservation->fin_at, 'commentaire' => $reservation->commentlocataire, 'role' => 'Locataire');
					$event = new Event('Email.send', $this, ['from'=>$loc->email,'to' => $mail->val,'textEmail'=>'commentairereservation',
										'data'=>$datamustachecommentloc,'template'=>'acceptationReservationAdm','viewVars'=>'acceptationReservationAdm','noReply'=>false
									]);
                	$this->eventManager()->dispatch($event);
				}
				/*** FIN Envoi mail commentaire proprietaire/locataire à l'admin s'il existe ***/
				
    }
		/**
		 *
		 **/
		public function supprimertel(){
			$this->viewBuilder()->layout(false);
			$this->loadModel("Reservationtelephone");
			$restel = $this->Reservationtelephone->get($this->request->data['idtel']);
			$this->Reservationtelephone->delete($restel);
		}
		/**
		 *
		 **/
		public function calculerprixperiode($res_id, $dbt_res, $fin_res){
			$this->loadModel("Dispos");
			$ddd = $dbt_res;
			$fff = $fin_res;
			$dispo = $this->Dispos->chercherdispocalcul($res_id, $ddd->format('Y-m-d'), $fff->format('Y-m-d'));
			$dispoCount = $this->Dispos->chercherdispocalculCount($res_id, $ddd->format('Y-m-d'), $fff->format('Y-m-d'));

			$resultatDetail = [];
			$resultatDetail['nbrperiode'] = $dispoCount;
			if($dispoCount == 1){
				$value = $dispo->first();
				$resultatDetail['nbrsejour'][1] = (new Date($fff->format('Y-m-d')))->diff(new Date($ddd->format('Y-m-d')))->days;
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
			}else{
				$i = 1;
				$resultatDetail['total'] = 0;
				$perid[0] = new Date($ddd->format('Y-m-d'));
				foreach ($dispo as $value) {
					$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
					$fn = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
					if($fn < new Date($fff->format('Y-m-d'))){
						$resultatDetail['nbrsejour'][$i] = $fn->diff($perid[0])->days;
						$resultatDetail['periodedu'][$i] = $perid[0];
						$resultatDetail['periodeau'][$i] = $fn;
						$perid[0] = $fn;
					}else{
						$resultatDetail['nbrsejour'][$i] = (new Date($fff->format('Y-m-d')))->diff($perid[0])->days;
						$resultatDetail['periodedu'][$i] = $perid[0];
						$resultatDetail['periodeau'][$i] = new Date($fff->format('Y-m-d'));
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
					$i = $i + 1;
				}
			}
			return $resultatDetail;
		}
		/**
		 * 
		 */
		public function getRegType($regionid){
			// $collection = Mage::getModel('directory/region_api')->items('FR');
			// $i=1;  
			// foreach ($collection as $values)  
			// {  
			// 		$regionModel = Mage::getModel('directory/region')->load($values['region_id']); 
			// 		$region = $regionModel->getName(); 
			// 		$resArr[$values['region_id']] = $region;
			// 			// $resArr[$i]['value']=$values['region_id'];  
			// 			// $resArr[$i]['label']=$region;  
			// 			// $i=$i+1;  
			// }  
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
	// public function payerboutique($res_id){

 	// 		session_start();
	// 		//These next few lines make me uneasy, but I can't remove the existing session code for magento
	// 		session_write_close(); // Write the data, end session
	// 		unset($_SESSION); // unset the session, magento uses isset($_SESSION) to check if it// should start a session
	// 		session_name("frontend");// change the session name to frontend
 	// 		require_once "../../boutique/app/Mage.php";
 	// 		umask(0);
 	// 		Mage::app();
 	// 		set_time_limit(0);
 	// 		Mage::getSingleton('core/session', array('name' => 'frontend'));


 	// 	$this->autoRender = false;
 	// 	/*** Préparer la liste des variables ***/
 	// 	$this->loadModel("Reservations");
 	// 	$this->loadModel("Lieugeos");
	// 	$this->loadModel("Utilisateurs");
    //             $this->loadModel("Dispos");
 	// 	$reservationDetail = $this->Reservations->getReservationById($res_id);
 	// 	$data = [];
 	// 		/** Détail annonce **/
 	// 		$data['res_Id'] = $res_id;
 	// 		$data['annonceId'] = $reservationDetail->annonce_id;
 	// 		$data['appartementNum'] = $reservationDetail['annonce']['num_app'];
 	// 		$data['station'] = $this->Lieugeos->get($reservationDetail['annonce']['lieugeo_id'])->name;
 	// 		$data['classementMunicipal'] = $reservationDetail['annonce']['nb_etoiles'];
 	// 		/** Détail locataire **/
 	// 		$data['prenomLocataire'] = $reservationDetail['utilisateur']['prenom'];
 	// 		$data['nomLocataire'] = $reservationDetail['utilisateur']['nom_famille'];
 	// 		$data['emailLocataire'] = $reservationDetail['utilisateur']['email'];
 	// 		$data['portableLocataire'] = $reservationDetail['utilisateur']['portable'];
 	// 		$data["code_postalLocataire"] = $reservationDetail['utilisateur']["code_postal"];
 	// 		$data["villeLocataire"] =  $reservationDetail['utilisateur']["ville"];
 	// 		$data["paysLocataire"] = $reservationDetail['utilisateur']["pays"];
 	// 		 if ($reservationDetail['utilisateur']["region"]==NULL) {$data["regionLocataire"] ='256';} else { $data["regionLocataire"] =$reservationDetail['utilisateur']["region"];} ;
 	// 		/** Détail réservation **/
 	// 		$data['dateArrivee'] = $reservationDetail->dbt_at->i18nFormat('dd-MM-yyyy');
 	// 		$data['dateDepart'] = $reservationDetail->fin_at->i18nFormat('dd-MM-yyyy');
 	// 		$data['nbrEnfant'] = $reservationDetail->nb_enfants;
 	// 		$data['nbrAdulte'] = $reservationDetail->nb_adultes;
 	// 		$data["comment"] = $reservationDetail['commentlocataire'];
 	// 		//var_dump( $reservationDetail['commentlocataire']);
	// 		//die();
	// 		/** Détail propriétaire **/
	// 		$proprietaire = $this->Utilisateurs->get($reservationDetail['annonce']['proprietaire_id']);
	// 		$data['prenomProprietaire'] = $proprietaire->prenom;
	// 		$data['nomProprietaire'] = $proprietaire->nom_famille;
	// 		$data['portableProprietaire'] = $proprietaire->portable;
	// 		$data["adr2"] = $proprietaire->adr2;
	// 		/** Détail Appartement **/
	// 		$data["adresseFacturation"]= $reservationDetail['utilisateur']['adresse'];
	// 		/*$data["code_postalApp"]=
	// 		$data["villeApp"]=
	// 		$data["paysApp"]=  */

 	// 		/** Détail prix **/
 	// 		$resultatDetail = $this->calculerprixperiode($reservationDetail->id, $reservationDetail->dbt_at, $reservationDetail->fin_at);
 	// 		if($resultatDetail['nbrperiode'] == 1){
 	// 			// Si la réservation est l'origine d'UNE SEULE période
 	// 			$data['prixparnuite'] = number_format($resultatDetail['prixjour'][1], 2, '.', '').' €';
 	// 			$data['nbrnuitees'] = $resultatDetail['nbrsejour'][1];
 	// 			$data['totalprixperiode'] = number_format($resultatDetail['total'], 2, '.', '');
 	// 		}else{
 	// 			// Si la réservation est l'origine d'UN ENSEMBLE de périodes
 	// 			for($i = 1; $i <= $resultatDetail['nbrperiode']; $i++){
 	// 				$data['periode'][$i] = "du ".$resultatDetail['periodedu'][$i]." au ".$resultatDetail['periodeau'][$i];
 	// 				$data['prixparnuite'][$i] = number_format($resultatDetail['prixjour'][$i], 2, '.', '').' €';
 	// 				$data['nbrnuitees'][$i] = $resultatDetail['nbrsejour'][$i];
 	// 				$data['totalperiode'][$i] = number_format($resultatDetail['totalperiode'][$i], 2, '.', '');
 	// 			}
 	// 			$data['totalprixperiode'] = number_format($resultatDetail['total'], 2, '.', '');
 	// 		}
 	// 		/* IMPORTANT :
 	// 			 SI la réservation est l'origine d'une seule période vous aurez ===> prixparnuite, nbrnuitees
 	// 		   SINON vous aurez un tableaux qui cotient ===> liste des periodes (periode), liste prixparnuite, liste nbrnuitees, liste totalperiode
 	// 			 DANS les 2 cas vous avez une seule variable => totalprixperiode */
 	// 		/** Détail taxe de séjour **/
 	// 		$data['prixtaxeapayer'] = 0;
 	// 		// On vérifie si la taxe est gérée par Alpissime
 	// 		if($reservationDetail->taxe == 1){
 	// 			$this->loadModel('Taxes');
 	// 			$r_taxe=$this->Taxes->find('all',["conditions"=>["Taxes.id_villes"=>$reservationDetail['annonce']['ville'],"Taxes.nb_etoile"=>$reservationDetail['annonce']['nb_etoiles'],"Taxes.du <='".$reservationDetail->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$reservationDetail->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
 	// 			$s = strtotime( $reservationDetail->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($reservationDetail->dbt_at->i18nFormat('yyyy-MM-dd'));
 	// 			$d = intval($s/86400);
 	// 			$v_taxe=0;
 	// 			if($r_taxe->first()){
	// 				$taxe=$r_taxe->first();
	// 			  }else{
	// 				$r_taxe=$this->Taxes->find('all',["conditions"=>["Taxes.id_villes"=>32190,"Taxes.nb_etoile"=>$reservationDetail['annonce']['nb_etoiles'],"Taxes.du <='".$reservationDetail->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$reservationDetail->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
	// 				$taxe=$r_taxe->first();
	// 			  }
	// 			  if($taxe){
                                        
    //                                 $v_taxe = 0;
                                    
    //                                 if($reservationDetail['annonce']['nb_etoiles'] == 0){
    //                                     /** Nouveau calcul Taxe 0* **/
    //                                     $list_dispos = $this->Dispos->find()->where(['Dispos.reservation_id = '.$reservationDetail->id]);

    //                                     foreach ($list_dispos as $ldispo){
    //                                         $ss = strtotime( $ldispo->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($ldispo->dbt_at->i18nFormat('yyyy-MM-dd'));
    //                                         $dd = intval($ss/86400);
    //                                         //// CALCUL PRIX NUITEE
    //                                         if($ldispo->prix_jour == 0 && $ldispo->prix != 0 && $ldispo->promo_yn == 0){
    //                                             $prixnuitee = $ldispo->prix / $dd;
    //                                         }else if($ldispo->promo_jour == 0 && $ldispo->promo_px != 0 && $ldispo->promo_yn == 1){
    //                                             $prixnuitee = $ldispo->promo_px / $dd;
    //                                         }else if($ldispo->promo_yn == 0){
    //                                             $prixnuitee = $ldispo->prix_jour;
    //                                         }else if($ldispo->promo_yn == 1){
    //                                             $prixnuitee = $ldispo->promo_jour;
    //                                         }
    //                                         //// Taxe par nuitée/personne
    //                                         $nouvelletaxe = ($prixnuitee / ($reservationDetail->nb_adultes + $reservationDetail->nb_enfants)) * ($taxe->valeur / 100);
    //                                         if($nouvelletaxe > 2.3) {
    //                                             $nouvelletaxe = 2.3 * $reservationDetail->nb_adultes;                        
    //                                         }else {
    //                                             $nouvelletaxe = $nouvelletaxe * $reservationDetail->nb_adultes;                        
    //                                         }
    //                                         //// Ajouter 10% taxe departementale
    //                                         $nouvelletaxe10 = $nouvelletaxe + ($nouvelletaxe * 1/10);
    //                                         //// Taxe Totale
    //                                         $v_taxe += $nouvelletaxe10 * $dd;                       
    //                                     }
    //                                    /** Fin Nouveau calcul Taxe 0* **/ 
    //                                 }else{
 	// 				$v_taxe=$taxe->valeur*$reservationDetail->nb_adultes*$d;
 	// 			}
                                        
 	// 				//$v_taxe=$taxe->valeur*$reservationDetail->nb_adultes*$d;
 	// 			}
 	// 		//print_r($v_taxe);
 	// 		//die();
 	// 			// prxi taxe à payer
 	// 		$data['prixtaxeapayer'] = $v_taxe;
 	// 		}
 	// 		// préparer les variables pour envoie URL
 	// 		//$str = serialize($data);
    // 		//$strenc = urlencode($str);
    // 		$productId = '2524';
    // 		$taxeID = '2525';
    // 		 	$res_id = htmlspecialchars($data['res_Id']);
	// 	        $idannonce = htmlspecialchars($data["annonceId"]);
	// 					$email =$data['emailLocataire'];
	// 					$prix = floatval($data['totalprixperiode']);
	// 	        $taxe = floatval($data['prixtaxeapayer']);
	// 	        //var_dump($prix);
	// 	        //die();
	// 	        $datearrivee = htmlspecialchars($data['dateArrivee']);
	// 	        $dateDepart = htmlspecialchars($data["dateDepart"]);
	// 	        $proprietairenom_prenom = htmlspecialchars($data['prenomProprietaire'])." ".htmlspecialchars($data['nomProprietaire']);
	// 					$proprietairenomportable = htmlspecialchars($data['portableProprietaire']);
	// 					$adresse = "appartement N° : ".htmlspecialchars($data['appartementNum'])." ".htmlspecialchars($data["adr2"])." ".htmlspecialchars($data["station"]);
	// 	        $code_postalLocataire = htmlspecialchars($data["code_postalLocataire"]);
	// 	        $villeLocataire = htmlspecialchars($data["villeLocataire"]);
	// 	        $paysLocataire = htmlspecialchars($data["paysLocataire"]);
	// 	        $portableLocataire = htmlspecialchars($data['portableLocataire']);
	// 	        $adresseFacturation = htmlspecialchars($data["adresseFacturation"]);
	// 	        $regionLocataire = htmlspecialchars($data["regionLocataire"]);

	// 		 /*** Customer ***/
	// 		$customer = Mage::getModel("customer/customer");
	// 		$customer->setWebsiteId(Mage::app()->getWebsite()->getId());

	// 		$customer->loadByEmail($email);
	// 		$session = Mage::getSingleton("customer/session");
	// 		$session->loginById($customer->getId());
	// 		$session->setCustomerAsLoggedIn($customer);
	// 		/********* Modification addresse Customer *********/
	// 		$customer->cleanAllAddresses();
	// 		// Get current address
	// 		$address = $customer->getPrimaryBillingAddress();

	// 		$this->loadModel('Frvilles');
	// 		$villeLivraison = $this->Frvilles->get($reservationDetail['annonce']['ville']);
	// 		$regiontab = $this->getRegType();
	// 		$this->loadModel('Pays');
	// 		$payscode = $this->Pays->get($reservationDetail['utilisateur']["pays"]);
	// 		//Adresse de l'appartement
	// 		$address_data = array (
	// 						'company' => $data['appartementNum'], #Appartement N°
	// 						'firstname' => $data['prenomLocataire'],
	// 						'lastname' => $data['nomLocataire'],
	// 						'street' => $data['adresseFacturation'],
	// 						'city' => $villeLivraison->name,
	// 						'region_id' => $reservationDetail['annonce']['region'],
	// 						'region' => $regiontab[$reservationDetail['annonce']['region']],
	// 						'postcode' => $reservationDetail['annonce']['code_postal'],
	// 						'country_id' => $payscode->code_pays,
	// 						'telephone' => $data['portableLocataire'], #portableLocataire
	// 						'email' => $data['emailLocataire'] #emailLocataire
	// 		);
	// 		// Do we add a new address
	// 		if (!$address) {
	// 				$address = Mage::getModel('customer/address');
	// 				$address->setCustomer($customer);
	// 				// Append data
	// 				$address->addData($address_data);
	// 				$address->save();
	// 				// Add address to customer and save
	// 				$customer->addAddress($address)
	// 						->setDefaultBilling($address->getId())
	// 						->save();
	// 		}
	// 		/********* END Modification addresse Customer *********/

	// 	    /**************** ADD items to cart  ***************/
	// 	    $cart = Mage::getModel('checkout/cart');
	// 	        $cart->init();

	// 	        $productInstance = Mage::getModel('catalog/product')->load($productId);
	// 	        //$productInstance->setSpecialPrice($prix);
	// 	        $param = array(
	// 	            'product' => $productInstance->getId(),
	// 	            'form_key' => Mage::getSingleton('core/session')->getFormKey(),
	// 	            'qty' => 1,
	// 	            'options' => array(
	// 	                5896 => $adresse, //adresse
	// 	                5893 => $proprietairenomportable, //tel propriétaire
	// 	                5894 => $dateDepart,
	// 	                5895 => $datearrivee,
	// 	                5898 => $idannonce,
	// 	                5897 => $proprietairenom_prenom,
	// 	                5899 => $res_id,
	// 	                5906 => $data["comment"],

	// 	            )
	// 	        );
	// 	        $request = new Varien_Object();
	// 	        $request->setData($param);

	// 	        /**************** remove items from cart  ***************/
	// 			if ($customer) {
	// 		        $storeId = Mage::app()->getWebsite(true)->getDefaultGroup()->getDefaultStoreId();
	// 		        // get quote table cart detail of all customer added
	// 		        $quote = Mage::getModel('sales/quote')->setStoreId($storeId)->loadByCustomer($customer);

	// 		        if ($quote) {
	// 		            $collection = $quote->getItemsCollection(false);

	// 		            if ($collection->count() > 0) {
	// 		                foreach( $collection as $item ) {
	// 		                	$allOptions = $item->getProduct()
	// 				                          ->getTypeInstance(true)
	// 				                          ->getOrderOptions($item->getProduct());
	// 				    		$customOptions = $allOptions['options'];
	// 				    		foreach ($customOptions as $option){
	// 		                    if (($item && $item->getId()) and ($option['value'] == $res_id)) {

	// 		                        $quote->removeItem($item->getId());
	// 		                        $quote->collectTotals()->save();
	// 		                    	}
	// 		                	}
	// 		                }
	// 		            }
	// 		        }
	// 		    }
	// 	    	/******************************************************/

	// 	        try {
	// 	        $cart->addProduct($productInstance, $request);
	// 	        //$cart->save();
	// 			    } catch (Exception $e) {
	// 			        print_r($e->getMessage());
	// 			    }
	// 			if($reservationDetail->taxe == 1){
	// 	    	$producttaxeID = Mage::getModel('catalog/product')->load($taxeID);
	// 	        //$productInstance->setSpecialPrice($prix);
	// 	        $paramtaxeID = array(
	// 	            'product' => $producttaxeID->getId(),
	// 	            'form_key' => Mage::getSingleton('core/session')->getFormKey(),
	// 	            'qty' => 1,
	// 	            'options' => array(
	// 	                5900 => $data['nbrEnfant'],  //Nombre d'enfants
	// 	                5901 => $data['nbrAdulte'], //Nombre d'adultes
	// 	                5902 => $data['classementMunicipal'], //nombre étoiles
	// 	                5903 => $data['nbrnuitees'],//NB Nuité
	// 	                5904 => $data['prixparnuite'], // parix par nuité
	// 	                5905 => $res_id, // ID réservation
	// 	            )
	// 	        );
	// 	        $requesttaxeID = new Varien_Object();
	// 	        $requesttaxeID->setData($paramtaxeID);
	// 	        $cart->addProduct($producttaxeID, $requesttaxeID);
	// 		   }
	// 		   //$cart->addProduct($productInstance, $request);
	// 	       $cart->save();
	// 		/******************************************************/

	// 		$itemsCollection = Mage::getSingleton('checkout/session')->getQuote()->getAllVisibleItems();

	// 		/******************************************************/

	// 		/**************** MODIFY item price in cart  ***************/
	// 		//$quote = Mage::getSingleton('checkout/session')->getQuote();

	// 		    foreach ($itemsCollection  as $item) {
	// 		    		/*echo "<pre>";
	// 		      						print_r($item->getProduct()->getId());
	// 								echo "</pre>";*/
	// 		         if($item->getProduct()->getId() == $productId) {
	// 		         	 $allOptions = $item->getProduct()
	// 				                          ->getTypeInstance(true)
	// 				                          ->getOrderOptions($item->getProduct());
	// 				    $customOptions = $allOptions['options'];

	// 		         if ($prix >= 0) {
	// 		         			foreach ($customOptions as $option) {
	// 		         				if ($option['value'] == $res_id) {
	// 									$item->setCustomPrice($prix);
	// 									$item->setPrice($prix);
	// 									$item->setPriceInclTax($prix);
	// 									$item->setOriginalCustomPrice($prix);
	// 									$item->getProduct()->setIsSuperMode(true);
	// 									$item->save();
	// 									//$quote->save();
	// 						}
	// 						}
	// 		         }
	// 		     }
	// 		     if($item->getProduct()->getId() == $taxeID) {
	// 		         	 $allOptions = $item->getProduct()
	// 				                          ->getTypeInstance(true)
	// 				                          ->getOrderOptions($item->getProduct());
	// 				    $customOptions = $allOptions['options'];

	// 		         if ($data['prixtaxeapayer'] >= 0) {
	// 		         			foreach ($customOptions as $option) {
	// 		         				if ($option['value'] == $res_id) {
	// 									$item->setCustomPrice($data['prixtaxeapayer']);
	// 									$item->setPrice($data['prixtaxeapayer']);
	// 									$item->setPriceInclTax($data['prixtaxeapayer']);
	// 									$item->setOriginalCustomPrice($data['prixtaxeapayer']);
	// 									$item->getProduct()->setIsSuperMode(true);
	// 									$item->save();
	// 									//$quote->save();
	// 						}
	// 						}
	// 		         }
	// 		     }
	// 		    }



	// 	    Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
	// 		//die();
 	// 		if (!$test) {
 	// 			/*** connecte le client sur la boutique / on ajoute l'article au panier / on le redirige sur le panier pour payer ***/
 	// 			//header("Location: https://www.boutique.alpissime.org/customer_login.php?data=".$strenc);
 	// 			header("Location: https://www.boutique.alpissime.org/fr/checkout/cart/");
	// 		die();
 	// 		} else{
 	// 			// echo "produit existe deja dans le panier ";
 	// 			$this->Flash->error(__("Vous avez déjà payé cette réservation  "),['clear'=> true]);
 	// 			return $this->redirect(["controller"=>"reservations",'action' => 'locataireView']);
 	// 		}
	// }

	/**
	 * 
	 */
	public function annulationlocataire()
	{
		// Liste des demandes annulation réservation
		$this->loadModel("AnnulationReservations");
		$listeAnnulReserv = $this->AnnulationReservations->find('all')->contain(['Reservations'=>['Utilisateurs']]);
		$data = $this->paginate($listeAnnulReserv);
        $this->set('annulations', $data);
	}

    function addReservationComment($id)
    {
        if ($this->request->params['isAjax']) {
            $reservation = $this->Reservations->get($id);
            $reservation = $this->Reservations->patchEntity($reservation, ["commentlocataire" => $this->request->data['comment']]);
            $this->Reservations->save($reservation);

            echo json_encode(['success' => true]);
            exit;
        }

        echo json_encode(['success' => false]);
        exit;
    }

    function viewReservation($id)
    {
        $session       = $this->request->session();

        $basePath      = Router::url('/', true) . $this->getLanguage();
        $urlvaluemulti = $this->getUrlmulti();
        $redirectUrl   = $basePath . "reservations/" . $urlvaluemulti['locataire_view'];

        $session->write('redirect_after_login', $redirectUrl);
        $session->write('reservation_id', $id);

        if (empty($this->Auth->user())) {
            $redirectUrl = $basePath . $urlvaluemulti['utilisateurs'] . "/" . $urlvaluemulti['ouvrircompte'];
        }

        return $this->redirect($redirectUrl);
    }

    function editReservationDates()
    {
        if ($this->request->params['isAjax']) {
            $reservation = $this->Reservations->get($this->request->data['id']);
            $reservation = $this->Reservations->patchEntity($reservation, ["dbt_at" => new Date($this->request->data['dbt_at']), "fin_at" => new Date($this->request->data['fin_at'])]);
            $this->Reservations->save($reservation);

            echo json_encode(['success' => true]);
            exit;
        }

        echo json_encode(['success' => false]);
        exit;
    }
}
