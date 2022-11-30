<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use \SoapClient;
use Mage;
use Mustache_Engine;
use Cake\Log\Log;
use Cake\Routing\Router;
use Cake\I18n\Date;
use Cake\I18n\I18n;
use Cake\Core\Configure;

/**
 * Utilisateurs Controller
 *
 * @property \App\Model\Table\UtilisateursTable $Utilisateurs
 */
class UtilisateursController extends AppController
{
    public $helpers = ['AnnonceFormater','Telephone'];

    public function initialize()
    {
        parent::initialize();
        if ($this->request->action === 'add' ) {
            // $this->loadComponent('InvisibleReCaptcha.InvisibleReCaptcha',
            //     [
            //         // 'secretkey' => '6LfWgbsZAAAAAB_Ey8rHRoeCTZ3ZR1VQKQyLc3ge',
            //         // 'sitekey' => '6LfWgbsZAAAAAOytZsO4ZNk6M-6KY7gJriJYtDzl'
            //         'secretkey' => '6Ld_sI8bAAAAAAnR-7FHvvpivhf-Ls6TZykwevtz',
            //         'sitekey' => '6Ld_sI8bAAAAAB8fRlz74t_tdw2e4YEv-ZG2KXug'
            //     ]);
            $session = $this->request->session();
            if($session->read('Config.language') && $session->read('Config.language') != "fr_FR"){
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

        if($this->request->action === 'ouvrircompte'){
			$this->loadComponent('Security');
            $this->loadComponent('Csrf');
		}

    }
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['confirmuser','add','connexion','ouvrircompte','logout','mdpPerdu','nouveauMdp','captcha','loginmanager','authmanager','getarraypays','getarraypaysvilles', 'getarrayregionfrance', 'getarrayfrancevilles', 'getdetailfrancecodepostal', 'ouvrircompteajax', 'addajax','renvoiemailconfirmation','getnbmessage','changearchived','getchats','changereadstatus']);
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
     *
     **/
    public function connexion()
    {
        $this->loadModel("Utilisateurs");
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $uss=$this->Utilisateurs->get($this->Auth->user('id'));
                $uss->connexion=1;
                $this->Utilisateurs->save($uss);
            }else{
                //$user=$this->Utilisateurs->findByEmail($this->request->data['email']);
                $user = $this->Utilisateurs->find()->where(['LOWER(email)'=>strtolower($this->request->data['email'])]);
                if($user->first()){
                    $u=$user->first();
                    if($u->connexion==0){
                        $mdp_en_clair = "";
                        $possible = "0123456789bcdfghjkmnpqrstvwxyz";
                        $i = 0;
                        while ($i < 8) {
                            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
                            if (!strstr($mdp_en_clair, $char)) {
                                $mdp_en_clair .= $char;
                                $i++;
                            }
                        }
                        $a_user=array('pwd'=>(new DefaultPasswordHasher)->hash($mdp_en_clair),'mot_passe'=>md5($mdp_en_clair),'date_update'=>Time::now());
                        $utilisateur = $this->Utilisateurs->patchEntity($u, $a_user);
                        $this->Utilisateurs->save($utilisateur);
                        $this->loadModel("Registres");
                        $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                        $mail=$mails->first();
                        $email = new Email('production');
                        $email->template('nouveauMdp', 'default')
                            ->emailFormat('html')
                            ->to($u->email)
                            ->from([$mail->val=>FROM_MAIL])
                            ->subject("Alpissime, votre nouveau mot de passe")
                            ->viewVars(['mdp' => $mdp_en_clair])
                            ->send();
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
                        $customerEmail = $u->email;   //à changer
                        if($u->prenom == '') $customer_fname = "_";
                        else $customer_fname = $u->prenom ; // prenom du client
                        $customer_lname = $u->nom_famille; // Nom du client
                        $password = $mdp_en_clair; // mot de passe
                        

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
                                    // "group_id" => $group_id,
                                    "email" => $customerEmail,  //à changer
                                    "firstname" => $customer_fname,     //à changer
                                    "lastname" => $customer_lname,      //à changer
                                    "storeId" => 1,
                                    "websiteId" => 1,
                                    "custom_attributes" => [
                                        [
                                            "attribute_code" => "client_id_loc",
                                            "value" => $u->id
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
                                    // "group_id" => $group_id,
                                    "email" => $customerEmail,  //à changer
                                    "firstname" => $customer_fname,          //à changer
                                    "lastname" => $customer_lname,         //à changer
                                    "storeId" => 1,
                                    "websiteId" => 1,
                                    "custom_attributes" => [
                                        [
                                            "attribute_code" => "client_id_loc",
                                            "value" => $u->id
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

                        // $this->Flash->error(__("newcake3"),['clear'=> true]);
                    }else{
                        $this->Flash->error(__("Nom d'utilisateur ou mot de passe incorrect, essayez à nouveau."),['clear'=> true]);
                    }
                }else
                    $this->Flash->error(__("Nom d'utilisateur ou mot de passe incorrect, essayez à nouveau."),['clear'=> true]);
            }
            return $this->redirect(['controller' => 'Annonces', 'action' => 'landing']);
        }
    }
    /**
     *
     */
    function erreurconnexion(){

    }
    /**
     *
     **/
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index(){
        $session = $this->request->session();
        if(!empty($session->read("SubmitOK"))){
            $this->set("SubmitOK",$session->read("SubmitOK"));
        }else{
            $this->set("SubmitOK","");
        }
        $session->delete("SubmitOK");
        $this->loadModel("Lieugeos");
        $enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
        $ar[]="";
        foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
        $this->set("l_lieugeos",$ar);
        $a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
        $this->set("l_nombre_personnes",$a_personne);

        $this->loadModel("Annonces");
        $proprietaire_id = $this->Auth->user('id');
        $this->set("annonces", $this->Annonces->find("all", ["conditions" => array("proprietaire_id" => $proprietaire_id), "order" => "Annonces.created_at desc"]));
        $utilisateur = $this->Utilisateurs->get($proprietaire_id, ['contain' => []]);
        $this->set('utilisateur', $utilisateur);
        $this->set('informationbancaire', $utilisateur->informationbancaire_id);

        // liste annonce proprietaire
        $this->loadModel("Dispos");
        $this->loadModel("Photos");        
        $annoncesTab = [];
        $annoncesProp = $this->Annonces->find("all")->where(["proprietaire_id" => $proprietaire_id, "statut != 10", "statut != 19", "statut != 40"])->order(['created_at desc']);
        foreach ($annoncesProp as $annonceProp) {
            $annoncesTab[$annonceProp->id]['id'] = $annonceProp->id;
            $annoncesTab[$annonceProp->id]['titre'] = $annonceProp->titre;
            $annoncesTab[$annonceProp->id]['justificatifDom'] = $annonceProp->justificatif_domicile;
            $nbrDispos = $this->Dispos->find("all")->where(["dbt_at > CURDATE()"]);
            $annoncesTab[$annonceProp->id]['nbrDispos'] = $nbrDispos->count();
            $chercheEquipement = $this->Annonces->find("all")->where([
                "id" => $annonceProp->id,
                "lave_linge" => 0,
                "seche_linge" => 0,
                "Radiateur_seche" => 0,
                "refrigerateur_top" => 0,
                "refrigerateur_comp" => 0,
                "refrigerateur_sup" => 0,
                "micro_onde" => 0,
                "four" => 0,
                "four_mini" => 0,
                "lave_vaissel_4" => 0,
                "lave_vaissel_8" => 0,
                "lave_vaissel_12" => 0,
                "table_cuisson" => 0,
                "hotte" => 0,
                "cafetiere" => 0,
                "grill_pain" => 0,
                "bouilloire" => 0,
                "autocuiseur" => 0,
                "mixeur" => 0,
                "aspirateur" => 0,
                "raclette" => 0,
                "pierrade" => 0,
                "crepiere" => 0,
                "fondue" => 0,
                "wok" => 0,
                "seche_cheveux" => 0,
                "fer_repasser" => 0,
                "table_repasser" => 0,
                "brasero" => 0,
                "barbecue" => 0,
                "plancha" => 0,
                "placard" => 0,
                "penderie" => 0,
                "table_120" => 0,
                "table_140" => 0,
                "table_160" => 0,
                "table_180" => 0,
                "table_200" => 0,
                "table_allonge" => 0,
                "chaises" => 0,
                "banquette_clic_130" => 0,
                "banquette_clic_140" => 0,
                "banquette_bz_80" => 0,
                "banquette_bz_120" => 0,
                "banquette_bz_140" => 0,
                "banquette_bz_160" => 0,
                "tabouret" => 0,
                "literie_70" => 0,
                "literie_80" => 0,
                "literie_90" => 0,
                "literie_140" => 0,
                "literie_160" => 0,
                "literie_2_70" => 0,
                "literie_rev" => 0,
                "literie_cig" => 0,
                "literie_peign" => 0,
                "literie_rapido" => 0,
                "oreillers" => 0,
                "couvertures" => 0,
                "couettes" => 0,
                "protege_matelas" => 0,
                "linge_lit" => 0,
                "serviettes" => 0,
                "tube_cathod" => 0,
                "cable_sat" => 0,
                "decodeur_canal" => 0,
                "ecran_plat" => 0,
                "tnt" => 0,
                "decodeur_sky" => 0,
                "ecran_plasma" => 0,
                "chaine_etranger" => 0,
                "cd" => 0,
                "hifi" => 0,
                "dvd" => 0,
                "wifi" => 0,
               // "wifi_gratuit" => 0,
               // "wifi_payant" => 0,
                "jeux_video" => 0,
                "jeux_societe" => 0,
                "quoi_lire" => 0,
                "baignoire_hydro" => 0,
                "appart_hammam" => 0,
                "appart_sauna" => 0,
                "espace_piscine" => 0,
                "salle_fitness" => 0,
                "poele_granule" => 0,
                "cheminee" => 0,
                "lit_bebe" => 0,
                "chaise_bebe" => 0,
                "baigoire_bebe" => 0,
                "reserv_sur_place" => 0,
                "centre_comm" => 0,
                "transport_public" => 0,
                "lieux_anim" => 0,
                "sentier_pedestre" => 0,
                "bien_etre" => 0,
                "espace_enfant" => 0,
                "espace_sportif" => 0,
            ]);
            if($chercheEquipement->count() == 1) $annoncesTab[$annonceProp->id]['equipements'] = 0;
            else $annoncesTab[$annonceProp->id]['equipements'] = 1;
            $annoncesTab[$annonceProp->id]['inventaire'] = $annonceProp->inventaire;
            $annoncesTab[$annonceProp->id]['photos'] = $this->Photos->find("all")->where(['annonce_id' => $annonceProp->id])->count();
            $annoncesTab[$annonceProp->id]['immatriculation'] = $annonceProp->num_enregistrement;
            $annoncesTab[$annonceProp->id]['contrat'] = $annonceProp->contrat;            
            $annoncesTab[$annonceProp->id]['blocinfoarrivee'] = $annonceProp->bloc_info_arrivee;
            $annoncesTab[$annonceProp->id]['blocinfodepart'] = $annonceProp->bloc_info_depart;            
        }
        $this->set('annoncesTab', $annoncesTab);
        $this->set('_serialize', ['utilisateur']);
    }
    /**
     *
     * locataire_index method
     *
     * @param string|null $id Utilisateur id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    function locataireIndex()
    {
        $session = $this->request->session();
        if(!empty($session->read("SubmitOK"))){
            $this->set("SubmitOK",$session->read("SubmitOK"));
        }else{
            $this->set("SubmitOK","");
        }
        $session->delete("SubmitOK");
        $locataire_id = $this->Auth->user('id');
        $utilisateur = $this->Utilisateurs->get($locataire_id, ['contain' => []]);
        $this->set('utilisateur', $utilisateur);
        $this->set('_serialize', ['utilisateur']);
    }
    /**
     * View method
     *
     * @param string|null $id Utilisateur id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $utilisateur = $this->Utilisateurs->get($id, ['contain' => []]);
        $this->set('utilisateur', $utilisateur);
        $this->set('_serialize', ['utilisateur']);
    }
    /**
     *
     */
    public function addajax(){
        $this->viewBuilder()->layout(false);
        $session = $this->request->session();
        $utilisateur = $this->Utilisateurs->newEntity();
        // if($this->request->data['g-recaptcha-response']) {
        // 	$captcha = $this->request->data['g-recaptcha-response'];
        // 	$secret = "6Lcu7zcUAAAAABkkxstN97NSgxpTGtcorYA3IXzH";
        // 	$json = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=". $secret . "&response=" . $captcha), true);
        // 	if($json['success']) {
        $emailForVerif=strtolower($this->request->data['email']);
        if(strrpos($emailForVerif, "airbnb",strrpos($emailForVerif, "@"))!==false || strrpos($emailForVerif, "abritel",strrpos($emailForVerif, "@"))!==false || strrpos($emailForVerif, "booking",strrpos($emailForVerif, "@"))!==false){
            $this->set('message','mailairbnb');
            //$this->Flash->error(__('Les emails Airbnb, Abritel et Booking ne sont pas acceptés.'),['clear'=> true]);
        }else{
            $user = $this->Utilisateurs->find()->where(['LOWER(email)'=>strtolower($this->request->data['email'])]);
            if(!$user->first()){
                $utilisateur = $this->Utilisateurs->newEntity($this->request->data);
                $utilisateur->pwd=(new DefaultPasswordHasher)->hash($this->request->data['pwd2']);
                $utilisateur->ident=$this->request->data['email'];
                $utilisateur->date_insert = Time::now();
                $utilisateur->email = strtolower($this->request->data['email']);
                $utilisateur->valide_at = null;
                $utilisateur->updated = 1;
                if($utilisateur = $this->Utilisateurs->save($utilisateur)) {
                    Log::write('emergency', 'Inscription nouveau Client: "'.$utilisateur->email.'"');
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

                    $datamustache = array('url' => $url,'login' => $this->request->data['email'],'password' => $this->request->data['pwd2']);
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
                    $password = $this->request->data['pwd2']; // mot de passe
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

                    //$session->write('affiche.email', $utilisateur->email);
                    $this->set('message','addCompte');
                }else{
                    $this->set('message','erreur');
                    //$this->Flash->error(__('Votre inscription n\'a pas pu être terminée.'),['clear'=> true]);
                }
            } else {
                $this->set('message','mailexiste');
                //$this->Flash->error(__('Cette adresse email existe déjà.'),['clear'=> true]);
            }
        }
        // 	} else {
        // 		$this->set('message','robot');
        // 	}
        // }  else {
        // 	$this->set('message','robot');
        // }
    }
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($etat=null)
    {
        $session = $this->request->session();
        $utilisateur = $this->Utilisateurs->newEntity();
        if ($this->request->is('post')) {
            // if ($this->InvisibleReCaptcha->verify()) {
            if ($this->Recaptcha->verify()) {
                $emailForVerif=strtolower($this->request->data['email']);
                if(strrpos($emailForVerif, "airbnb",strrpos($emailForVerif, "@"))!==false || strrpos($emailForVerif, "abritel",strrpos($emailForVerif, "@"))!==false || strrpos($emailForVerif, "booking",strrpos($emailForVerif, "@"))!==false){
                    $this->Flash->error(__('Les emails Airbnb, Abritel et Booking ne sont pas acceptés.'),['clear'=> true]);
                }
                elseif($this->request->data['email'] != "" && $this->request->data['email'] != " " ){
                    //$user=$this->Utilisateurs->findByEmail($this->request->data['email']);
                    $user = $this->Utilisateurs->find()->where(['LOWER(email)'=>strtolower($this->request->data['email'])]);
                    if(!$user->first()){
                        $utilisateur = $this->Utilisateurs->newEntity($this->request->data);
                        $utilisateur->pwd=(new DefaultPasswordHasher)->hash($this->request->data['pwd']);
                        $utilisateur->ident=$this->request->data['email'];
                        $utilisateur->date_insert = Time::now();
                        $utilisateur->email = strtolower($this->request->data['email']);
                        $utilisateur->valide_at = null;
                        $utilisateur->updated = 1;
                        if($utilisateur = $this->Utilisateurs->save($utilisateur)) {
                            Log::write('emergency', 'Inscription nouveau Client: "'.$utilisateur->email.'" avec mot de passe : "'.$this->request->data['pwd'].'"');
                            //$this->Flash->success(__('Votre inscription a été effectuée avec success.'),['clear'=> true]);
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

                            if($this->request->data['nature'] == "CLT"){
                                $session->write("SubmitOK","OK");
                                $session->write("visitorType","locataire");
                            }else{
                                $session->write("SubmitOK","OK");
                                $session->write("visitorType","proprietaire");
                            }
                            $session->write('affiche.email', $utilisateur->email);
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
                            // OUVRIR Compte
                            if($session->read('Auth.User.id')==""){
                                    unset($_COOKIE);
                                    $this->request->data['email'] = strtolower($this->request->data['email']);
                                    $user = $this->Auth->identify();
                                    // if ($user&&$user['valide_at']!=null) {
                                    $this->Auth->setUser($user);
                                    ////// IMPORTANT //////
                                    /*** Si locataire tester s'il a une prochaine réservation et déterminer sa station et sa correspondance avec boutique ***/
                                    if($session->read('Auth.User.nature') == 'CLT'){
                                        $this->loadModel("Reservations");
                                        $reservation = $this->Reservations->find("all")->contain(['Annonces'])->where(['Reservations.utilisateur_id = '.$session->read('Auth.User.id'), 'Reservations.statut = 90', 'Reservations.fin_at >= CURDATE()'])->order(['Reservations.dbt_at ASC']);
                                        if($reser = $reservation->first()){
                                            $this->loadModel("Lieugeos");
                                            $station = $this->Lieugeos->get($reser['annonce']['lieugeo_id']);
                                            if($station->query != "") $session->write('User.station', $station->query);
                                        }
                                    }
                                    /*** Station enregistrée en session ***/
                    
                                    /*** Connexion boutique ***/
                                    $this->loadModel("Utilisateurs");
                                    $utilis = $this->Utilisateurs->find()->where(['email' => $this->request->data['email']]);
                                    if($utilis->first()){
                                        $utilisa = $utilis->first();
                                        if($utilisa->prenom == '') $customer_fname = "_";
                                        else $customer_fname = $utilisa->prenom ; // prenom du client
                                        $customer_lname = $utilisa->nom_famille; // Nom du client
                                    }
                                    $email = $this->request->data['email'];// email client
                                    $password = $this->request->data['pwd'];// password
                                    
                                    // Nouveau code Magento2
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
                                    $this->loadModel("Utilisateurs");
                                    $utilis = $this->Utilisateurs->find()->where(['email' => $this->request->data['email']]);
                                    if($utilis->first()){
                                        $utilisa = $utilis->first();
                                        $customerEmail = $this->request->data['email'];   //à changer
                                        if($utilisa->prenom == '') $customer_fname = "_";
                                        else $customer_fname = $utilisa->prenom ; // prenom du client
                                        $customer_lname = $utilisa->nom_famille; // Nom du client
                                        $password = $this->request->data['pwd']; // mot de passe
                                        
                                    }
                    
                    
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
                                                // "group_id" => $group_id,
                                                "email" => $customerEmail,  //à changer
                                                "firstname" => $customer_fname,     //à changer
                                                "lastname" => $customer_lname,      //à changer
                                                "storeId" => 1,
                                                "websiteId" => 1,
                                                "custom_attributes" => [
                                                    [
                                                        "attribute_code" => "client_id_loc",
                                                        "value" => $utilisa->id
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
                                                // "group_id" => $group_id,
                                                "email" => $customerEmail,  //à changer
                                                "firstname" => $customer_fname,          //à changer
                                                "lastname" => $customer_lname,         //à changer
                                                "storeId" => 1,
                                                "websiteId" => 1,
                                                "custom_attributes" => [
                                                    [
                                                        "attribute_code" => "client_id_loc",
                                                        "value" => $utilisa->id
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
                                    /*** Fin Connexion boutique ***/
                    
                                    Log::write('emergency', 'Connexion réussite du client "'.$this->request->data['email'].'" ');
                                    if($session->read("Reservations.Dispo.annonce_id")==""){
                                        if($session->read('Auth.User.nature')=='CLT')
                                        {
                                            /** Magento 2 Module LOGIN redirect **/
                                            if($user){
                                                $email = $this->request->data['email'];
                                                $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));
                                                $return_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                                                $fail_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                                                $magentoURL = BOUTIQUE_ALPISSIME;
                                                $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                                                //var_dump($final_url);die('aa');
                                                return $this->redirect($final_url);
                                            }else{
                                                $return_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                                                return $this->redirect($return_url); 
                                            }
                                            
                                            /** End Magento 2 Module LOGIN redirect **/
                    
                                            //return $this->redirect(['action' => 'locataireIndex']);
                                        }
                                        else
                                        {
                                            if($user){
                                                /** Magento 2 Module LOGIN redirect **/
                                                $email = $this->request->data['email'];
                                                $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));
                    
                                                $return_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                                                $fail_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                                                $magentoURL = BOUTIQUE_ALPISSIME;
                                                $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                                                //var_dump($final_url);die('bb');
                                                return $this->redirect($final_url);
                                                /** End Magento 2 Module LOGIN redirect **/
                                                return $this->redirect(['action' => 'index']);
                                            }else{
                                                $return_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                                                return $this->redirect($return_url); 
                                            }
                                        }
                                        // $this->redirect(["controller" => "annonces", "action" => "index"]);
                                    }
                                    else{
                                        if($user){
                                            /** Magento 2 Module LOGIN redirect **/
                                            $email = $this->request->data['email'];
                                            $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));
                    
                                            $return_url = Router::url(["controller" => "reservations", "action" => "confirmreservations"], true);
                                            $fail_url = Router::url(["controller" => "reservations", "action" => "confirmreservations"], true);
                                            $magentoURL = BOUTIQUE_ALPISSIME;
                                            $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                                            //var_dump($final_url);die('bb');
                                            return $this->redirect($final_url);
                                            /** End Magento 2 Module LOGIN redirect **/
                                            //$this->redirect(["controller" => "reservations", "action" => "confirmreservations"]);
                                        }else{
                                            $return_url = Router::url(["controller" => "reservations", "action" => "confirmreservations"], true);
                                            return $this->redirect($return_url); 
                                        }
                                    }
                                    // }
                                    // elseif($user&&$user['valide_at']==null){
                                    // 	$this->Flash->error(__("Un email de confirmation vous a été déjà envoyé dans votre boite mail pour activer votre compte."),['clear'=> true]);
                                    // 	$session->write('emailconfirmation',$user['email']);
                    
                                    // 	return $this->redirect(['action' => 'ouvrircompte']);
                                    // }
                                    // else{
                                    // 	Log::write('emergency', 'Erreur connexion du client "'.$this->request->data['email'].'" ');
                                    // 	$this->Flash->error(__("Erreur au moment de la connexion - vérifiez votre mot de passe !"),['clear'=> true]);
                                    // 	return $this->redirect(['controller' => 'utilisateurs', 'action' => 'erreurconnexion']);
                                    // }
                                    $session->write('emailconfirmation',$user['email']);
                    
                                    if($session->read('Auth.User.nature')=='CLT')
                                    {
                                        if($user){
                                            /** Magento 2 Module LOGIN redirect **/
                                            $email = $this->request->data['email'];
                                            $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));
                    
                    
                                            $return_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                                            $fail_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                                            $magentoURL = BOUTIQUE_ALPISSIME;
                                            $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                                            //var_dump($final_url);die('aa');
                                            return $this->redirect($final_url);
                                            /** End Magento 2 Module LOGIN redirect **/
                                        }else{
                                            $return_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                                            return $this->redirect($return_url); 
                                        }
                    
                                        //return $this->redirect(['action' => 'locataireIndex']);
                                    }
                                    else
                                    {
                                        if($user){
                                            /** Magento 2 Module LOGIN redirect **/
                                            $email = $this->request->data['email'];
                                            $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));
                    
                                            $return_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                                            $fail_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                                            $magentoURL = BOUTIQUE_ALPISSIME;
                                            $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                                            //var_dump($final_url);die('bb');
                                            return $this->redirect($final_url);
                                            /** End Magento 2 Module LOGIN redirect **/
                                        }else{
                                            $return_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                                            return $this->redirect($return_url); 
                                        }
                                        //return $this->redirect(['action' => 'index']);
                                    }
                                
                    
                            }else{
                                // return $this->redirect(['controller' => 'annonces', 'action' => 'index']);
                                if($session->read('Auth.User.nature')=='CLT')
                                {
                                    if($user){
                                        /** Magento 2 Module LOGIN redirect **/
                                        $email = $this->request->data['email'];
                                        $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));
                    
                                        $return_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                                        $fail_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                                        $magentoURL = BOUTIQUE_ALPISSIME;
                                        $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                                        //var_dump($final_url);die('aa');
                                        return $this->redirect($final_url);
                                        /** End Magento 2 Module LOGIN redirect **/
                                    }else{
                                        $return_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                                        return $this->redirect($return_url); 
                                    }
                                    //return $this->redirect(['action' => 'locataireIndex']);
                                }
                                else
                                {
                                    if($user){
                                        /** Magento 2 Module LOGIN redirect **/
                                        $email = $this->request->data['email'];
                                        $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));
                                        $return_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                                        $fail_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                                        $magentoURL = BOUTIQUE_ALPISSIME;
                                        $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                                        //var_dump($final_url);die('bb');
                                        return $this->redirect($final_url);
                                        /** End Magento 2 Module LOGIN redirect **/
                                    }else{
                                        $return_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                                        return $this->redirect($return_url); 
                                    }
                                    //return $this->redirect(['action' => 'index']);
                                }
                            }
                            // return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['ouvrircompte']);
                            // return $this->redirect(['action' => 'ouvrircompte']);

                        }else{
                            $this->Flash->error(__('Votre inscription n\'a pas pu être terminée.'),['clear'=> true]);
                        }
                    } else {
                        $this->set('confirm_res','addCompte');
                        $this->Flash->error(__('Cette adresse email existe déjà.'),['clear'=> true]);
                    }
                }
            }else{
                $this->Flash->error(__('Erreur ReCaptcha.'),['clear'=> true]);
            }
        }
        $a_civi=array(
            'Melle'=>'Mademoiselle'
        ,'Mme'=>'Madame'
        ,'M.'=>'Monsieur'
        );
        $this->loadModel("Lieugeos");
        $enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
        $ar[]="";
        // foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
        // $this->set("l_lieugeos",$ar);
        $this->loadModel("Pays");
        $Pays=$this->Pays->find('all');
        $a_pay=array();
        $payNum=array();
        $a_pay[""] = __('Choisir votre pays');
        foreach($Pays as $pay){
            if($session->read('Config.language') == "fr_FR") $a_pay[$pay->id_pays]=$pay->fr;
            if($session->read('Config.language') == "en_US") $a_pay[$pay->id_pays]=$pay->en;
            $payNum[$pay->id_pays]=$pay->code_pays;
        }
        $this->set("etat", $etat);
        $this->set("no_connect_information", true);
        $this->set("l_civilites", $a_civi);
        $this->set("Pays", $a_pay);
        $this->set("paysNum", $payNum);

        $mail = [];
        $this->loadModel("Modelmailsysteme");
        $textEmail = $this->Modelmailsysteme->find('all');
        foreach ($textEmail as $key => $value) {
            $mail[$value->titre] = $value->txtmail;
        }
        $this->set("textmail",$mail);
        $this->set(compact('utilisateur'));
        $this->set('_serialize', ['utilisateur']);
    }
    /**
     * fonction confirmuser elle prend un token qui permet d'activer un utilisateur
     **/
    function confirmuser($token)
    {
        $this->loadModel('UtilisateursTokens');
        $user_token=$this->UtilisateursTokens->find()->where(['token'=>$token])->first();
        if($user_token!=null){
            $user=$this->Utilisateurs->find()->where(['id'=>$user_token->user_id])->first();
            if($user!=null){
                if($user->valide_at!=null)
                {
                    $this->Flash->success(__('Votre compte est déjà activé, vous pouvez vous connecter.'),['clear'=> true]);
                }
                else
                {
                    $this->Flash->success(__('Votre compte est activé avec succès, vous pouvez maintenant vous connecter.'),['clear'=> true]);
                }
                $user->valide_at=date('Y-m-d');
                $this->Utilisateurs->save($user);
                $session = $this->request->session();
                $session->write('Auth.User.valide_at', date('Y-m-d'));
                return $this->redirect(['action' => 'ouvrircompte']);
            }
            else{
                $this->Flash->error(__('Aucun compte n\'est lié à cette adresse email.'),['clear'=> true]);
                return $this->redirect(['action' => 'add']);
            }
        }
        $this->Flash->error(__('Ce token a expiré.'),['clear'=> true]);
        return $this->redirect(['action' => 'ouvrircompte']);
    }
    /**
     *
     **/
    function animateur(){
        if (!empty($this->request->data)) {
            if ($this->request->data['fileName']['error']) {
                switch ($this->request->data['fileName']['error']){
                    case 1: // UPLOAD_ERR_INI_SIZE
                        $this->Flash->success(__('Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !', true));
                        break;
                    case 2: // UPLOAD_ERR_FORM_SIZE
                        $this->Flash->success(__('Le fichier dépasse la limite autorisée dans le formulaire HTML !', true));
                        break;
                    case 3: // UPLOAD_ERR_PARTIAL
                        echo "L'envoi du fichier a été interrompu pendant le transfert !";
                        $this->Flash->success(__("L'envoi du fichier a été interrompu pendant le transfert !", true));
                        break;
                    case 4: // UPLOAD_ERR_NO_FILE
                        $this->Flash->success(__('Le fichier que vous avez envoyé a une taille nulle !', true));
                        break;
                }
            }else{
                $uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/webroot/';
                $tmp_name = $this->request->data["fileName"]["tmp_name"];
                $name = date("Y-m-d-H-i-s");
                $ext = pathinfo($this->request->data['fileName']['name'], PATHINFO_EXTENSION);
                $finalName = $name.'.'.$ext;
                if($ext === 'mp3' || $ext === 'MP3'){
                    move_uploaded_file($tmp_name, "$uploads_dir/podcastsFiles/$finalName");
                    // insert in parse
                    $className = "podcast";
                    $active = True;
                    $trackImageURL = 'https://www.alpissime.com/android/img/1_img_json.jpeg';
                    if(!empty($this->data['trackImageURL']['name'])){
                        move_uploaded_file($this->data['trackImageURL']['tmp_name'], "$uploads_dir/android/img/".$this->request->data['trackImageURL']['name']);
                        $trackImageURL = 'https://www.alpissime.com/android/img/'.$this->request->data['trackImageURL']['name'];
                    }
                    $trackName = $this->request->data['trackName'];
                    $trackURL = 'https://www.alpissime.com/podcastsFiles/'.$finalName;
                    $trackdescription = $this->request->data['trackdescription'];
                    $arr = array('active' => $active,'trackImageURL' => $trackImageURL,'trackName' => $trackName,'trackURL' => $trackURL,'trackdescription' => $trackdescription);
                    $objectData = json_encode($arr);
                    $url = 'https://api.parse.com/1/classes/' . $className;
                    $appId = 'hQtmfMlGjyCOJuzZbaqXCKWTBkW5Y5H5J8Kg8XP3';
                    $restKey = 'BUU1XHKvUDn003cvhLAslNHsS7m0ZlKgrWsaBtLx';
                    $rest = curl_init();
                    curl_setopt($rest,CURLOPT_URL,$url);
                    curl_setopt($rest,CURLOPT_PORT,443);
                    curl_setopt($rest,CURLOPT_POST,1);
                    curl_setopt($rest,CURLOPT_POSTFIELDS,$objectData);
                    curl_setopt($rest,CURLOPT_HTTPHEADER,
                        array("X-Parse-Application-Id: " . $appId,"X-Parse-REST-API-Key: " . $restKey, "Content-Type: application/json"));
                    curl_exec($rest);
                    $this->Flash->success(__("podcast envoyé avec succès", true));

                }else{
                    $this->Flash->success(__("Veuillez inserer un fichier de type mp3", true));
                }
            }
        }
    }
    /**
     * Edit method
     *
     * @param string|null $id Utilisateur id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel("Lieugeos");
        $enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
        $ar[]="";
        foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
        $this->set("l_lieugeos",$ar);
        $a_personne=array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20 +');
        $this->set("l_nombre_personnes",$a_personne);

        $session = $this->request->session();
        $gest=$session->read('Gestionnaire.info');
        $utilisateur = $this->Utilisateurs->get($id);
        if($utilisateur->id != $session->read('Auth.User.id') && $gest['G']['role'] != "gestionnaire" && $gest['G']['role'] != "admin"){
            //$annonce = "";
            $this->Flash->error(__("Vous ne pouvez pas voir les informations d'un autre utilisateur"),['clear'=> true]);
            $this->set("possible", "non");
        }

        $utilisateur = $this->Utilisateurs->getdetailuser($session->read('Auth.User.id'));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $oldmail = $utilisateur->email;
            $utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $this->request->data);
            $utilisateur->date_update=Time::now();
            $utilisateur->updated=1;
            $utilisateur->email = strtolower($this->request->data['email']);
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
            $customerEmail = $utilisateur->email;   //à changer
            if($utilisateur->prenom == '') $customer_fname = "_";
            else $customer_fname = $utilisateur->prenom ; // prenom du client
            $customer_lname = $utilisateur->nom_famille; // Nom du client
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
                        // "group_id" => $group_id,
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
                        // "group_id" => $group_id,
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

            if ($this->Utilisateurs->save($utilisateur)) {
                Log::write('emergency', 'Client "'.$utilisateur->email.'" a modifié son profil. ANCIEN email "'.$oldmail.'"');
                //SendInBlue edit
                $this->loadModel("Pays");

                if ($utilisateur->email==$oldmail){
                    if(PROD_ON == 1){
                        $sendinblue=new SendInBlueController();
                        $sendinblue->updateContactToSendInBlue($utilisateur->email,$utilisateur->prenom,$utilisateur->nom_famille,$utilisateur->portable,$utilisateur->civilite,$utilisateur->naissance,null,null,null,$this->Pays->get($utilisateur->pays)->fr);
                    }
                }
                elseif ($utilisateur->email!=$oldmail) {
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
                    $mail = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]])->first();
                    // #####################################################
                    $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $utilisateur,'textEmail'=>'validerCompteModifMail',
                        'data'=>$datamustache,'template'=>'validerCompte','viewVars'=>'validerCompte','noReply'=>false
                    ]);
                    $this->eventManager()->dispatch($event);
                    // #####################################################

                    //end resend mail
                    if(PROD_ON == 1){
                        $sendinblue=new SendInBlueController();
                        $sendinblue->updateContactEmail($oldmail,$utilisateur->email);
                        $sendinblue->updateContactToSendInBlue($utilisateur->email,$utilisateur->prenom,$utilisateur->nom_famille,$utilisateur->portable,$utilisateur->civilite,$utilisateur->naissance,$utilisateur->adresse,$utilisateur->code_postal,$Sville,$this->Pays->get($utilisateur->pays)->fr);
                    }
                    $this->Auth->logout();
                    $session = $this->request->session();
                    $session->write('affiche.email', $utilisateur->email);
                    return $this->redirect(['action' => 'ouvrircompte']);
                }

                $session = $this->request->session();
                $session->write('Auth.User.updated', 1);
                if($utilisateur->nature=='CLT')
                    return $this->redirect(['action' => 'locataireIndex']);
                else
                    return $this->redirect(['action' => 'index']);
            } else {
                Log::write('emergency', 'Client "'.$utilisateur->email.'" n\'a pas pu modifié son profil. ANCIEN email "'.$oldmail.'"');
                $this->Flash->error(__('L\'utilisateur ne peut pas etre supprimé'),['clear'=> true]);
            }
        }
        $this->loadModel("Pays");
        $Pays=$this->Pays->find('all');
        $a_pay=array();
        $payNum=array();
        $a_pay[0] = '';
        foreach($Pays as $pay){
            if($session->read('Config.language') == "fr_FR") $a_pay[$pay->id_pays]=$pay->fr;
            if($session->read('Config.language') == "en_US") $a_pay[$pay->id_pays]=$pay->en;
            $payNum[$pay->id_pays]=$pay->code_pays;
        }
        $this->set("Pays", $a_pay);

        $this->set("paysNum", $payNum);

        $this->set("l_civilites", array(''=>'','Melle'=>'Mademoiselle','Mme'=>'Madame','M.'=>'Monsieur'));
        $this->set(compact('utilisateur'));
        $this->set('_serialize', ['utilisateur']);
    }
    /**
     * change-mdp method
     *
     * @param string|null $id Utilisateur id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function changemdp($id=null)
    {
        $utilisateur = $this->Utilisateurs->get($id, ['contain' => []]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $session = $this->request->session();
            $utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $this->request->data);
            $utilisateur->pwd=(new DefaultPasswordHasher)->hash($this->request->data['mdp']);
            $utilisateur->mot_passe=md5($this->request->data['mdp']);
            $session->write("Inscription.utilisateur","addCompte");
            /*** MISE A JOUR BOUTIQUE ***/
            // /******* debut code a ne pas supprimer **/
            //  require_once '../../boutique/app/Mage.php'; //à modifier selon l'emplacement du fichier
            //  umask(0);
            //  Mage::app('admin');
            //  set_time_limit(0);
            //  Mage::init();
            //  /****** fin code a ne pas supprimer *******/
            //  $customer_email = $utilisateur->email; // email du client
            //  $customer_fname = $utilisateur->prenom ; // prenom du client
            //  $customer_lname = $utilisateur->nom_famille; // Nom du client
            //  $password = $this->request->data['mdp']; // mot de passe

            //  $customer = Mage::getModel('customer/customer');
            //  $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
            //  $customer->loadByEmail($customer_email);
            //  /*
            //  * tester si le client existe ou pas.
            //  * Si oui on mettera a jour son mot de passe, sinon on crée son compte sur la boutique.
            //  */
            //  if(!$customer->getId()) {
            //  	$customer->setEmail($customer_email);
            //  	$customer->setFirstname($customer_fname);
            //  	$customer->setLastname($customer_lname);
            //  	$customer->setPassword($password);
            //  	echo 'compte créé';
            //  	try {
            //  		$customer->save();
            //  		$customer->setConfirmation(null);
            //  		$customer->save();
            //  		// envoyer le mail de bienvenu depuis la boutique
            //  		$storeId = $customer->getSendemailStoreId();
            //  		$customer->sendNewAccountEmail('registered', '', $storeId);
            //  	}
            //  	catch (Exception $ex) {
            //  		echo 'error';
            //  	}
            //  } else {
            //  	$customer->setPassword($password);
            //  	try {
            //  		$customer->save();
            //  		$customer->setConfirmation(null);
            //  		$customer->save();
            //  		echo 'mot de passe mis a jour';
            //  	}
            //  	catch (Exception $ex) {
            //  		echo 'error';
            //  	}
            //  }
            // Nouveau Code magento 2
            //**** informations a utiliser toujours ********************//
            $magentoURL = BOUTIQUE_ALPISSIME;
            $data = array("username" => "API.ACCESS", "password" => "86>;];wzO+Q#");
            $data_string = json_encode($data);
            $ch = curl_init($magentoURL . "index.php/rest/V1/integration/admin/token");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Length: " . strlen($data_string)));
            $token = curl_exec($ch);
            $token = json_decode($token);
            $headers = array("Authorization: Bearer " . $token);
            //************************************************************//
            // **** mettre l'email du client depuis le site location **********//
            $customerEmail = $utilisateur->email;
            $newpassword = $this->request->data['mdp'];

            $requestUrl = $magentoURL . 'index.php/rest/V1/customers/search?searchCriteria[filter_groups][0][filters][0][field]=email&searchCriteria[filter_groups][0][filters][0][value]=%25' .
                $customerEmail . '%25&searchCriteria[filter_groups][0][filters][0][condition_type]=like';
            $ch = curl_init($requestUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $result = json_decode($result, true);
            //*********** Mise a jour du mot de passe du client et eventuellement son nom ...
            // si le client existe (email) dans la boutique ********//
            if ($result["items"]) {
                $id = $result['items'][0]['id'];

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => BOUTIQUE_ALPISSIME."index.php/rest/all/V1/cakephp/updatePassword?email=".$id."&newpassword=".$newpassword."",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                // echo $response;
            }

            // $requestUrl = $magentoURL.'index.php/rest/V1/customers/search?searchCriteria[filter_groups][0][filters][0][field]=email&searchCriteria[filter_groups][0][filters][0][value]=%25'.$customerEmail.'%25&searchCriteria[filter_groups][0][filters][0][condition_type]=like';
            // $ch = curl_init($requestUrl);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $result = curl_exec($ch);
            // $result = json_decode($result, true);
            // //*********** Mise a jour du mot de passe du client et eventuellement son nom ...
            // // si le client existe (email) dans la boutique ********//
            // if ($result["items"]) {
            // 	$id = $result['items'][0]['id'];
            // }

            // // echo '<pre>';print_r($token);

            // //*** activer le token clien pour pouvoir modifier ses informations ***//
            // $data = array("username" => $customerEmail, "password" => $oldPassword);
            // $data_string = json_encode($data);
            // $ch = curl_init($magentoURL."index.php/rest/V1/integration/customer/token");
            // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Content-Length: ".strlen($data_string)));
            // $token = curl_exec($ch);
            // // echo '<pre>';print_r($token);

            // $jsoneEconoded= '{"customer_id":"'.$id.'","currentPassword":"'.$oldPassword.'","newPassword":"'.$newPassword.'"}';

            // // echo '<pre>';print_r(json_decode($jsoneEconoded));

            // $ch = curl_init($magentoURL."/rest/V1/customers/me/password");

            // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsoneEconoded);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . json_decode($token)));

            // //echo $requestUrl;exit;
            // $result = json_decode(curl_exec($ch),1);
            // // echo '<pre>';print_r($result);
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
            
            if ($this->Utilisateurs->save($utilisateur)) {
                Log::write('emergency', 'Mot de passe modifié par le client "'.$utilisateur->email.'"');
                $this->Flash->success(__('Votre nouveau mot de passe est pris en compte'),['clear'=> true]);
                if($utilisateur->nature=='CLT')   return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index']);
                else return $this->redirect(['action' => 'index']);
            } else {
                Log::write('emergency', 'Anomalie au moment de l\'enregistrement du mot de passe par le client "'.$utilisateur->email.'"');
                $this->Flash->error(__("Anomalie au moment de l'enregistrement de votre mot de passe"),['clear'=> true]);
                if($utilisateur->nature=='CLT')   return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index']);
                else return $this->redirect(['action' => 'index']);
            }
        }
    }
    /**
     * Delete method
     *
     * @param string|null $id Utilisateur id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $utilisateur = $this->Utilisateurs->get($id);
        if ($this->Utilisateurs->delete($utilisateur)) {
            // $this->Flash->success(__('The utilisateur has been deleted.'),['clear'=> true]);
        } else {
            // $this->Flash->error(__('The utilisateur could not be deleted. Please, try again.'),['clear'=> true]);
        }
        return $this->redirect(['action' => 'index']);
    }
    /**
     *
     */
    function ouvrircompteajax(){
        $this->viewBuilder()->layout(false);
        $session = $this->request->session();
        unset($_COOKIE);
        $this->request->data['email'] = strtolower($this->request->data['email']);
        $user = $this->Auth->identify();
        // print_r($this->request->data);
        // exit;
        // if ($user&&$user['valide_at']!=null) {
        $this->Auth->setUser($user);
        ////// IMPORTANT //////
        /*** Si locataire tester s'il a une prochaine réservation et déterminer sa station et sa correspondance avec boutique ***/
        if($session->read('Auth.User.nature') == 'CLT'){
            $this->loadModel("Reservations");
            $reservation = $this->Reservations->find("all")->contain(['Annonces'])->where(['Reservations.utilisateur_id = '.$session->read('Auth.User.id'), 'Reservations.statut = 90', 'Reservations.fin_at >= CURDATE()'])->order(['Reservations.dbt_at ASC']);
            if($reser = $reservation->first()){
                $this->loadModel("Lieugeos");
                $station = $this->Lieugeos->get($reser['annonce']['lieugeo_id']);
                if($station->query != "") $session->write('User.station', $station->query);
            }
        }
        /*** Station enregistrée en session ***/

        /*** Vérifier utilisateur Boutique ***/
        // Nouveau code Magento2
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
        $this->loadModel("Utilisateurs");
        $utilis = $this->Utilisateurs->find()->where(['email' => $this->request->data['email']]);
        if($utilis->first()){
            $utilisa = $utilis->first();
            $customerEmail = $this->request->data['email'];   //à changer
            if($utilisa->prenom == '') $customer_fname = "_";
            else $customer_fname = $utilisa->prenom ; // prenom du client
            $customer_lname = $utilisa->nom_famille; // Nom du client
            $password = $this->request->data['pwd']; // mot de passe
            
        }


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
                    // "group_id" => $group_id,
                    "email" => $customerEmail,  //à changer
                    "firstname" => $customer_fname,     //à changer
                    "lastname" => $customer_lname,      //à changer
                    "storeId" => 1,
                    "websiteId" => 1,
                    "custom_attributes" => [
                        [
                            "attribute_code" => "client_id_loc",
                            "value" => $utilisa->id
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
                    // "group_id" => $group_id,
                    "email" => $customerEmail,  //à changer
                    "firstname" => $customer_fname,          //à changer
                    "lastname" => $customer_lname,         //à changer
                    "storeId" => 1,
                    "websiteId" => 1,
                    "custom_attributes" => [
                        [
                            "attribute_code" => "client_id_loc",
                            "value" => $utilisa->id
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

        if($user){
            // connexion boutique
            /** Magento 2 Module LOGIN redirect **/
            $email = $this->request->data['email'];
            $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));

            $return_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'ouvrircompteajax'], true);
            $fail_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'ouvrircompteajax'], true);
            $magentoURL = BOUTIQUE_ALPISSIME;
            $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
            //var_dump($final_url);die('aa');
            // return $this->redirect($final_url);
            /** End Magento 2 Module LOGIN redirect **/
            /*** FIN code boutique ***/
        }        

        Log::write('emergency', 'Connexion réussite du client "'.$this->request->data['email'].'" ');
        ///// set return value
        $this->set("retourmessage", "connexion");
        $this->set("retouruser", $user);


        // }
        // elseif($user&&$user['valide_at']==null){
        // 	//resend mail
        // 	$this->loadModel('UtilisateursTokens');
        // 	$token=$this->UtilisateursTokens->find('all')->where(['user_id'=>$user['id']])->first();
        // 	if($token==null){
        // 	  $this->loadModel('UtilisateursTokens');
        // 	  $token=sha1($user->email.$user->pwd);
        // 	  $this->UtilisateursTokens->deleteAll(['user_id' => $user->id]);
        // 	  $token=$this->UtilisateursTokens->newEntity([
        // 		'user_id'=>$user->id,
        // 		'token'=>$token,
        // 		'expired_at'=>date('Y-m-d', strtotime('+1 year'))
        // 	  ]);
        // 	  $this->UtilisateursTokens->save($user_token);
        // 	}
        // 	$url=Router::url(['controller' => 'Utilisateurs', 'action' => 'confirmuser','token'=>$token->token],true);
        // 	$datamustache = array('url' => $url,'email' => $user['email'],'prenom' => $user['prenom'],'nom' => $user['nom_famille']);
        // 	$this->loadModel('Registres');
        // 	$mail = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]])->first();
        // 	// #####################################################
        // 	$event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $user,'textEmail'=>'validerCompte','data'=>$datamustache,'template'=>'validerCompte','viewVars'=>'validerCompte','noReply'=>false]);
        // 	$this->eventManager()->dispatch($event);
        // 	// #####################################################
        // 	//end resend mail
        // 	///// set return value (Valider vitre email)
        // 	$this->set("retourmessage", "confirmationcompte");
        // }
        // else{
        // 	Log::write('emergency', 'Erreur connexion du client "'.$this->request->data['email'].'" ');
        // 	///// set return value (Erreur vérifier votre connexion)
        // 	$this->set("retourmessage", "erreurconnexion");


        // 	// $this->Flash->error(__("Erreur au moment de la connexion - vérifiez votre mot de passe !"),['clear'=> true]);
        // 	// return $this->redirect(['controller' => 'utilisateurs', 'action' => 'erreurconnexion']);
        // }
    }
    /**
     * 
     */
    function connectionwithajax()
    {
        /** Magento 2 Module LOGIN redirect **/
        $session = $this->request->session();
        $email = $session->read('Auth.User.email');
        $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));

        $return_url = Router::url(['controller'=> 'Annonces' ,'action' => 'add'], true);
        $fail_url = Router::url(['controller'=> 'Annonces' ,'action' => 'add'], true);
        $magentoURL = BOUTIQUE_ALPISSIME;
        $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
        $this->set("final_url", $final_url);
        //var_dump($final_url);die('aa');
        return $this->redirect($final_url);
    }
    /**
     *
     **/
    function ouvrircompte(){
        $session = $this->request->session();
        if(!empty($session->read("SubmitOK"))){
            $this->set("SubmitOK",$session->read("SubmitOK"));
            $this->set("visitorType",$session->read("visitorType"));
        }else{
            $this->set("SubmitOK","");
        }
        $session->delete("SubmitOK");
        $redirectAfterLoginUrl = $session->read('redirect_after_login');

        if($session->read('Auth.User.id')==""){
            if ($this->request->is('post')) {
                unset($_COOKIE);
                $this->request->data['email'] = strtolower($this->request->data['email']);
                $user = $this->Auth->identify();
                // if ($user&&$user['valide_at']!=null) {
                $this->Auth->setUser($user);
                ////// IMPORTANT //////
                /*** Si locataire tester s'il a une prochaine réservation et déterminer sa station et sa correspondance avec boutique ***/
                if($session->read('Auth.User.nature') == 'CLT'){
                    $this->loadModel("Reservations");
                    $reservation = $this->Reservations->find("all")->contain(['Annonces'])->where(['Reservations.utilisateur_id = '.$session->read('Auth.User.id'), 'Reservations.statut = 90', 'Reservations.fin_at >= CURDATE()'])->order(['Reservations.dbt_at ASC']);
                    if($reser = $reservation->first()){
                        $this->loadModel("Lieugeos");
                        $station = $this->Lieugeos->get($reser['annonce']['lieugeo_id']);
                        if($station->query != "") $session->write('User.station', $station->query);
                    }
                }
                /*** Station enregistrée en session ***/

                /*** Connexion boutique ***/
                $this->loadModel("Utilisateurs");
                $utilis = $this->Utilisateurs->find()->where(['email' => $this->request->data['email']]);
                if($utilis->first()){
                    $utilisa = $utilis->first();
                    if($utilisa->prenom == '') $customer_fname = "_";
                    else $customer_fname = $utilisa->prenom ; // prenom du client
                    $customer_lname = $utilisa->nom_famille; // Nom du client
                }
                $email = $this->request->data['email'];// email client
                $password = $this->request->data['pwd'];// password
                
                // Nouveau code Magento2
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
                $this->loadModel("Utilisateurs");
                $utilis = $this->Utilisateurs->find()->where(['email' => $this->request->data['email']]);
                if($utilis->first()){
                    $utilisa = $utilis->first();
                    $customerEmail = $this->request->data['email'];   //à changer
                    if($utilisa->prenom == '') $customer_fname = "_";
                    else $customer_fname = $utilisa->prenom ; // prenom du client
                    $customer_lname = $utilisa->nom_famille; // Nom du client
                    $password = $this->request->data['pwd']; // mot de passe
                    
                }


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
                            // "group_id" => $group_id,
                            "email" => $customerEmail,  //à changer
                            "firstname" => $customer_fname,     //à changer
                            "lastname" => $customer_lname,      //à changer
                            "storeId" => 1,
                            "websiteId" => 1,
                            "custom_attributes" => [
                                [
                                    "attribute_code" => "client_id_loc",
                                    "value" => $utilisa->id
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
                            // "group_id" => $group_id,
                            "email" => $customerEmail,  //à changer
                            "firstname" => $customer_fname,          //à changer
                            "lastname" => $customer_lname,         //à changer
                            "storeId" => 1,
                            "websiteId" => 1,
                            "custom_attributes" => [
                                [
                                    "attribute_code" => "client_id_loc",
                                    "value" => $utilisa->id
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
                /*** Fin Connexion boutique ***/

                Log::write('emergency', 'Connexion réussite du client "'.$this->request->data['email'].'" ');
                if($session->read("Reservations.Dispo.annonce_id")==""){
                    if($session->read('Auth.User.nature')=='CLT')
                    {
                        /** Magento 2 Module LOGIN redirect **/
                        if($user){
                            $email = $this->request->data['email'];
                            $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));
                            $return_url = $redirectAfterLoginUrl ? $redirectAfterLoginUrl : Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                            $fail_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                            $magentoURL = BOUTIQUE_ALPISSIME;
                            $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                            //var_dump($final_url);die('aa');
                            return $this->redirect($final_url);
                        }else{
                            $return_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                            return $this->redirect($return_url); 
                        }
                        
                        /** End Magento 2 Module LOGIN redirect **/

                        //return $this->redirect(['action' => 'locataireIndex']);
                    }
                    else
                    {
                        if($user){
                            /** Magento 2 Module LOGIN redirect **/
                            $email = $this->request->data['email'];
                            $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));

                            $return_url = $redirectAfterLoginUrl ? $redirectAfterLoginUrl : Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                            $fail_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                            $magentoURL = BOUTIQUE_ALPISSIME;
                            $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                            //var_dump($final_url);die('bb');
                            return $this->redirect($final_url);
                            /** End Magento 2 Module LOGIN redirect **/
                            return $this->redirect(['action' => 'index']);
                        }else{
                            $return_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                            return $this->redirect($return_url); 
                        }
                    }
                    // $this->redirect(["controller" => "annonces", "action" => "index"]);
                }
                else{
                    if($user){
                        /** Magento 2 Module LOGIN redirect **/
                        $email = $this->request->data['email'];
                        $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));

                        $return_url = $redirectAfterLoginUrl ? $redirectAfterLoginUrl : Router::url(["controller" => "reservations", "action" => "confirmreservations"], true);
                        $fail_url = Router::url(["controller" => "reservations", "action" => "confirmreservations"], true);
                        $magentoURL = BOUTIQUE_ALPISSIME;
                        $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                        //var_dump($final_url);die('bb');
                        return $this->redirect($final_url);
                        /** End Magento 2 Module LOGIN redirect **/
                        //$this->redirect(["controller" => "reservations", "action" => "confirmreservations"]);
                    }else{
                        $return_url = Router::url(["controller" => "reservations", "action" => "confirmreservations"], true);
                        return $this->redirect($return_url); 
                    }
                }
                // }
                // elseif($user&&$user['valide_at']==null){
                // 	$this->Flash->error(__("Un email de confirmation vous a été déjà envoyé dans votre boite mail pour activer votre compte."),['clear'=> true]);
                // 	$session->write('emailconfirmation',$user['email']);

                // 	return $this->redirect(['action' => 'ouvrircompte']);
                // }
                // else{
                // 	Log::write('emergency', 'Erreur connexion du client "'.$this->request->data['email'].'" ');
                // 	$this->Flash->error(__("Erreur au moment de la connexion - vérifiez votre mot de passe !"),['clear'=> true]);
                // 	return $this->redirect(['controller' => 'utilisateurs', 'action' => 'erreurconnexion']);
                // }
                $session->write('emailconfirmation',$user['email']);

                if($session->read('Auth.User.nature')=='CLT')
                {
                    if($user){
                        /** Magento 2 Module LOGIN redirect **/
                        $email = $this->request->data['email'];
                        $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));


                        $return_url = $redirectAfterLoginUrl ? $redirectAfterLoginUrl : Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                        $fail_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                        $magentoURL = BOUTIQUE_ALPISSIME;
                        $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                        //var_dump($final_url);die('aa');
                        return $this->redirect($final_url);
                        /** End Magento 2 Module LOGIN redirect **/
                    }else{
                        $return_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                        return $this->redirect($return_url); 
                    }

                    //return $this->redirect(['action' => 'locataireIndex']);
                }
                else
                {
                    if($user){
                        /** Magento 2 Module LOGIN redirect **/
                        $email = $this->request->data['email'];
                        $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));

                        $return_url = $redirectAfterLoginUrl ? $redirectAfterLoginUrl : Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                        $fail_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                        $magentoURL = BOUTIQUE_ALPISSIME;
                        $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                        //var_dump($final_url);die('bb');
                        return $this->redirect($final_url);
                        /** End Magento 2 Module LOGIN redirect **/
                    }else{
                        $return_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                        return $this->redirect($return_url); 
                    }
                    //return $this->redirect(['action' => 'index']);
                }
            }else{
                if($session->check('affiche.email')){
                    $this->set('afficheEmail',$session->consume('affiche.email'));
                }
            }

        }else{
            // return $this->redirect(['controller' => 'annonces', 'action' => 'index']);
            if($session->read('Auth.User.nature')=='CLT')
            {
                if($user){
                    /** Magento 2 Module LOGIN redirect **/
                    $email = $this->request->data['email'];
                    $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));

                    $return_url = $redirectAfterLoginUrl ? $redirectAfterLoginUrl : Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                    $fail_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                    $magentoURL = BOUTIQUE_ALPISSIME;
                    $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                    //var_dump($final_url);die('aa');
                    return $this->redirect($final_url);
                    /** End Magento 2 Module LOGIN redirect **/
                }else{
                    $return_url = Router::url(['controller'=> 'Annonces' ,'action' => 'landing'], true);
                    return $this->redirect($return_url); 
                }
                //return $this->redirect(['action' => 'locataireIndex']);
            }
            else
            {
                if($user){
                    /** Magento 2 Module LOGIN redirect **/
                    $email = $this->request->data['email'];
                    $hmac = hash_hmac('ripemd160', $email, date("YmdH").md5($email));
                    $return_url = $redirectAfterLoginUrl ? $redirectAfterLoginUrl : Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                    $fail_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                    $magentoURL = BOUTIQUE_ALPISSIME;
                    $final_url = $magentoURL.'cakelogin/cakelogin/login?email='.urlencode($email).'&token='.$hmac.'&redirect_url='.urlencode($return_url).'&login_failed='.urlencode($fail_url);
                    //var_dump($final_url);die('bb');
                    return $this->redirect($final_url);
                    /** End Magento 2 Module LOGIN redirect **/
                }else{
                    $return_url = Router::url(['controller'=> 'Utilisateurs' ,'action' => 'index'], true);
                    return $this->redirect($return_url); 
                }
                //return $this->redirect(['action' => 'index']);
            }
        }
    }
    /**
     *
     */
    public function renvoiemailconfirmation(){
        $this->viewBuilder()->layout(false);
        //resend mail
        $this->loadModel('UtilisateursTokens');
        $this->loadModel('Utilisateurs');
        $user = $this->Utilisateurs->find()->where(['email'=>$this->request->data['email']])->first();
        $token=$this->UtilisateursTokens->find('all')->where(['user_id'=>$user->id])->first();
        if($token==null){
            $this->loadModel('UtilisateursTokens');
            $token=sha1($user->email.$user->pwd);
            $this->UtilisateursTokens->deleteAll(['user_id' => $user->id]);
            $token=$this->UtilisateursTokens->newEntity([
                'user_id'=>$user->id,
                'token'=>$token,
                'expired_at'=>date('Y-m-d', strtotime('+1 year'))
            ]);
            $this->UtilisateursTokens->save($token);
        }
        $url=Router::url(['controller' => 'Utilisateurs', 'action' => 'confirmuser','token'=>$token->token],true);
        $datamustache = array('url' => $url,'email' => $user->email,'prenom' => $user->prenom,'nom' => $user->nom_famille);
        $this->loadModel('Registres');
        $mail = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]])->first();
        // #####################################################
        $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $user->email,'textEmail'=>'validerCompte','data'=>$datamustache,'template'=>'validerCompte','viewVars'=>'validerCompte','noReply'=>false]);
        $this->eventManager()->dispatch($event);
        // #####################################################
        //end resend mail
    }
    /*
     * Génération d'un nouveau mot de passe
     * Envoi du mot de passe par mél à l'adresse indiquée dans la fiche
     */
    public function mdpPerdu()
    {
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
    public function nouveauMdp()
    {
        if (empty($this->request->data) || $this->request->data["ident"] == "") {
            $this->Flash->error(__("Merci de préciser votre identifiant"),['clear'=> true]);
            return $this->redirect(['controller' => 'utilisateurs', 'action' => 'mdpPerdu']);
        }
        $mdp_en_clair = $this->request->data["mdpenclair"];
        //$users = $this->Utilisateurs->findByEmail($this->request->data["ident"]);
        $users = $this->Utilisateurs->find()->where(['LOWER(email)'=>strtolower($this->request->data["ident"])]);

        $user=$users->first();
        if(!empty($user)){
            $a_user=array('pwd'=>(new DefaultPasswordHasher)->hash($mdp_en_clair),'mot_passe'=>md5($mdp_en_clair),'date_update'=>Time::now());
            $utilisateur = $this->Utilisateurs->patchEntity($user, $a_user);
            if($this->Utilisateurs->save($utilisateur)){
                Log::write('emergency', 'Mot de passe perdu, mot de passe modifié du client "'.$this->request->data["ident"].'"');
                $datamustache = array('password' => $this->request->data["mdpenclair"],'prenom' => $user->prenom, 'nom'=>$user->nom_famille);

                $this->loadModel("Registres");
                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail=$mails->first();
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $user,'textEmail'=>'nouveauMdp',
                    'data'=>$datamustache,'template'=>'nouveauMdp','viewVars'=>'nouveauMdp','noReply'=>false
                ]);
                $this->eventManager()->dispatch($event);

                if($user&&$user->valide_at==null){
                    //resend mail
                    //get token
                    $this->loadModel('UtilisateursTokens');
                    $token=$this->UtilisateursTokens->find('all')->where(['user_id'=>$user['id']]);
                    if(!$token->first()){
                        $user_token=$this->UtilisateursTokens->newEntity([
                            'user_id'=>$user['id'],
                            'token'=>sha1($utilisateur->email.$utilisateur->pwd),
                            'expired_at'=>date('Y-m-d', strtotime('+1 year'))
                        ]);
                        $token = $this->UtilisateursTokens->save($user_token);
                    }else{
                        $token = $token->first();
                    }
                    $url=Router::url(['controller' => 'Utilisateurs', 'action' => 'confirmuser','token'=>$token->token],true);
                    //end get token
                    $datamustache = array('url' => $url,'email' => $user['email'],'prenom' => $user['prenom'],'nom' => $user['nom_famille']);
                    $this->loadModel('Registres');
                    $mail = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]])->first();
                    // #####################################################
                    $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $user,'textEmail'=>'validerCompte',
                        'data'=>$datamustache,'template'=>'validerCompte','viewVars'=>'validerCompte','noReply'=>false
                    ]);
                    $this->eventManager()->dispatch($event);
                    // #####################################################
                    //end resend mail
                }
                // #####################################################

                // **** mettre l'email du client depuis le site location **********//
                $customerEmail = $user->email;   //à changer
                if($user->prenom == '') $customer_fname = "_";
                else $customer_fname = $user->prenom ; // prenom du client
                $customer_lname = $user->nom_famille; // Nom du client
                $password = $mdp_en_clair; // mot de passe

                //**** informations a utiliser toujours ********************//
                $magentoURL = BOUTIQUE_ALPISSIME;
                $data = array("username" => "API.ACCESS", "password" => "86>;];wzO+Q#");
                $data_string = json_encode($data);
                $ch = curl_init($magentoURL . "index.php/rest/V1/integration/admin/token");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Length: " . strlen($data_string)));
                $token = curl_exec($ch);
                $token = json_decode($token);
                $headers = array("Authorization: Bearer " . $token);
                //************************************************************//
                // **** mettre l'email du client depuis le site location **********//
                $customerEmail = $user->email;
                $newpassword = $mdp_en_clair;

                $requestUrl = $magentoURL . 'index.php/rest/V1/customers/search?searchCriteria[filter_groups][0][filters][0][field]=email&searchCriteria[filter_groups][0][filters][0][value]=%25' .
                    $customerEmail . '%25&searchCriteria[filter_groups][0][filters][0][condition_type]=like';
                $ch = curl_init($requestUrl);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                $result = json_decode($result, true);
                //*********** Mise a jour du mot de passe du client et eventuellement son nom ...
                // si le client existe (email) dans la boutique ********//
                if ($result["items"]) {
                    $id = $result['items'][0]['id'];

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => BOUTIQUE_ALPISSIME."index.php/rest/all/V1/cakephp/updatePassword?email=".$id."&newpassword=".$newpassword."",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    // echo $response;
                }	else{
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
                                    "value" => $user->id
                                ]
                            ]
                        ],
                        "password" => $password            //à changer
                    ];
                    // print_r($customerData);
                    $ch = curl_init($magentoURL."index.php/rest/V1/customers");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
                    $result = curl_exec($ch);
                     
                    // print_r($result);
                    // exit;
                    // $this->Flash->info(__("création Compte"));
                }
                curl_close($ch);
            }else{
                $this->Flash->error(__("Anomalie au moment de l'enregistrement du mot de passe"),['clear'=> true]);
                Log::write('emergency', 'Mot de passe perdu, anomalie lors de l\'enregistrement du mot de passe du client "'.$this->request->data["ident"].'"');
                return $this->redirect(['controller' => 'utilisateurs', 'action' => 'mdpPerdu']);
            }
        }else{
            $this->Flash->error(__("Cette adresse email n'existe pas"),['clear'=> true]);
            Log::write('emergency', 'Mot de passe perdu, Email n\'existe pas du client "'.$this->request->data["ident"].'"');
            return $this->redirect(['controller' => 'utilisateurs', 'action' => 'mdpPerdu']);
        }
    }
    /*
     * Enregistrement d'un nouveau mail
     */
    public function changeMail($id=null)
    {
        if (!$id || empty($this->data)) {
            $this->Flash->success(__("Argument invalide"),['clear'=> true]);
            $this->redirect("index");
        }
        $this->Utilisateur->recursive = -1;
        $user = $this->Utilisateur->read(null, $id);
        $user["Utilisateur"]["email"] = $this->data["Utilisateur"]["email"];
        if ($this->Utilisateur->save($user,false)) {
            $this->Flash->success(__("Votre adresse email a bien été modifiée"),['clear'=> true]);
            $this->redirect("index");
        } else {
            $this->Flash->success(__("Anomalie au moment de l'enregistrement de votre email"),['clear'=> true]);
            $this->redirect("index");
        }
    }
    /**
     * Login method
     */
    function loginmanager(){
        $this->request->session()->delete('Gestionnaire.info');
        $this->viewBuilder()->layout('ajax');
    }
    /**
     *
     */
    function authmanager(){
        $session = $this->request->session();
        $this->loadModel('Gestionnaires');
        $this->Gestionnaires->find();
        $a_data=array();
        $gestionnaires = $this->Gestionnaires->find("all", ["conditions" => ["login" => $this->request->data["username"], "password" => md5($this->request->data["password"])]]);
        if($gestionnaires->first()){
            $gest=$gestionnaires->first();
            $InfoGes=array('G'=>array(	'id'=>$gest->id,
                'role'=>$gest->role,
                'name'=>$gest->name,
                'login'=>$gest->login,
                'email'=>$gest->email,
                'telephone'=>$gest->telephone));
            $session->write("Gestionnaire.info",$InfoGes);
            $a_data=array('status'=>$gest->role);
        }
        echo json_encode($a_data);
        exit;
    }

    function getchats()
    {
        $this->loadModel("Contactprops");
        $whereArr = [
            '(A.proprietaire_id = '.$this->Auth->user('id').' OR Contactprops.locataire_id = '.$this->Auth->user('id').')',
            '(A.contrat = 1 OR A.mise_relation = 1)',
            'Contactprops.parent_id = 0'
        ];

        if (!empty($this->request->query['filter'])) {
            $filterArr = explode(',', $this->request->query['filter']);
            $filterCondArr = [];

            foreach ($filterArr as $filterVal) {
                switch ($filterVal) {
                    case 2: // Read messages
                        $filterCondArr[] = 'Contactprops.lut = 1';
                        break;
                    case 3: // Unread messages
                        $filterCondArr[] = 'Contactprops.lut = 0';
                        break;
                    case 4: // Not archived messages
                        $filterCondArr[] = 'Contactprops.archived = 0';
                        break;
                    case 5: // Archived messages
                        $filterCondArr[] = 'Contactprops.archived = 1';
                        break;
                }
            }

            if (!empty($filterCondArr)) {
                $whereArr[] = '(' . implode(" OR ", $filterCondArr) . ')';
            }
        }

        if (!empty($this->request->query['search'])) {
            $searchTerm = htmlspecialchars(addslashes(strtolower($this->request->query['search'])));
            $whereArr[] = "(LOWER(U.prenom) LIKE '%" . $searchTerm . "%' OR LOWER(U.nom_famille) LIKE '%" . $searchTerm . "%')";
        }

        $joins = [
            'C' => [
                'table' => 'contactprops',
                'type' => 'inner',
                'conditions' => 'Contactprops.id = C.id OR Contactprops.id = C.parent_id',
            ],
            'A' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => 'A.id=Contactprops.id_annonce',
            ],
            'R' => [
                'table' => 'residences',
                'type' => 'left',
                'conditions' => 'A.batiment=R.id',
            ],
            'L' => [
                'table' => 'lieugeos',
                'type' => 'left',
                'conditions' => 'L.id=A.lieugeo_id',
            ],
            'Rs' => [
                'table' => 'reservations',
                'type' => 'left',
                'conditions' => 'Rs.id = Contactprops.reservation_id',
            ],
            'U' => [
                'table' => 'utilisateurs',
                'type' => 'inner',
                'conditions' => $this->Auth->user('nature') == "CLT" ? 'A.proprietaire_id = U.id' : 'Contactprops.locataire_id = U.id',
            ]
        ];

        $rResult = $this->Contactprops->find();
        $hasUnreadMsg = $rResult->newExpr()
            ->addCase($rResult->newExpr()->add(['C.lut' => 0]), 1, 'integer');
        $rResult->join($joins)
            ->select([
                "Contactprops.id",
                'hasUnreadMsg' => $hasUnreadMsg,
                "Contactprops.locataire_id",
                "Contactprops.parent_id",
                "Contactprops.id_annonce",
                "Contactprops.demande",
                "Contactprops.date_insert",
                "Contactprops.lut",
                "Contactprops.archived",
                "Contactprops.commentaire",
                "Contactprops.reservation_id",
                "A.titre",
                "R.name",
                "L.name",
                "Rs.statut",
                "Rs.dbt_at",
                "Rs.fin_at",
                "user_id" => "U.id",
                "U.prenom",
                "U.nom_famille"
            ]);
        $rResult->where($whereArr);
        $rResult->group('Contactprops.id');
        $data = $rResult->order(["Contactprops.archived asc", "hasUnreadMsg desc", "Contactprops.date_insert desc"]);

        $this->set('messages', $data);

        $unreadCount = [];
        foreach($data as $val){
            $result = $this->Contactprops->find()->select('id')
                ->where(['(Contactprops.parent_id = ' . $val->id . ' OR Contactprops.id = ' . $val->id . ')', 'Contactprops.lut = 0'])
                ->andWhere(['Contactprops.locataire_id != ' . $this->Auth->user('id')]);
            $unreadCount[$val->id] = $result->count();
        }

        $this->set('unreadCount', $unreadCount);
        $this->set('selectedMessageId', $this->request->query['selectedMessageId']);

        $content = $this->render('chats')->body();
        echo json_encode(['html' => $content]);
        exit;
    }

    /**
     * Liste des annonces liées à un propriétaire
     */
    function mesmessages()
    {
        if (!empty($this->request->query['message_id'])) {
            $this->set('selected_message_id', $this->request->query['message_id']);
        }
    }

    function mesmessages_old(){
        $this->loadModel("Contactprops");
        $rResult = $this->Contactprops->find();
        $rResult->join([
            'A' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => 'A.id=Contactprops.id_annonce',
            ],
            'R' => [
                'table' => 'residences',
                'type' => 'left',
                'conditions' => 'A.batiment=R.id',
            ],
            'L' => [
                'table' => 'lieugeos',
                'type' => 'left',
                'conditions' => 'L.id=A.lieugeo_id',
            ]
        ])
            ->select(["Contactprops.id","Contactprops.locataire_id","Contactprops.parent_id","Contactprops.id_annonce","Contactprops.nom","Contactprops.prenom","Contactprops.telephone","Contactprops.email","Contactprops.demande","Contactprops.date_insert","Contactprops.lut","A.titre","R.name","L.name"]);
        $rResult->where([
            '(A.proprietaire_id = ' . $this->Auth->user('id') . ' OR Contactprops.locataire_id = ' . $this->Auth->user('id') . ')',
            '(A.contrat = 1 OR A.mise_relation = 1)',
            'Contactprops.parent_id = 0'
        ]);
        $rResult->order(["Contactprops.date_insert desc"]);
        $data = $this->paginate($rResult);
        $this->set('message', $data);

        $listeCount = [];
        foreach($rResult as $val){
            $result = $this->Contactprops->find()->where(['Contactprops.parent_id' => $val->id, 'Contactprops.lut' => 0]);
            if($this->Auth->user('nature') == "CLT"){
                $result->andWhere(['Contactprops.locataire_id = 0']);
            }else{
                $result->andWhere(['Contactprops.locataire_id != 0']);
            }
            $listeCount[$val->id] = $result->count();
        }
        $this->set('listeCount', $listeCount);
    }

    /**
     *
     */
    public function detailmessage($id)
    {
        $whereArr1  = ['(id = ' . $id . ')'];
        $whereArr   = ['(parent_id = ' . $id . ')'];

        if (!empty($this->request->query['search'])) {
            $searchTerm  = htmlspecialchars(addslashes(strtolower($this->request->query['search'])));
            $this->set('searchTerm', $this->request->query['search']);  
            $searchCond  = "(LOWER(commentaire) LIKE '%" . $searchTerm . "%')";
            $whereArr[]  = $searchCond;
            $whereArr1[] = $searchCond;
        }

        $this->loadModel("Contactprops");
        $premiermessage = $this->Contactprops->find()->where($whereArr1);

        $prMessage = [];
        foreach ($premiermessage as $message) {
            $prMessage = $message;
        }
        $this->set('premiermessage', $prMessage);

        $listeresponses = $this->Contactprops->find()->where($whereArr)->order(['date_insert' => 'ASC']);
        $this->set('listeresponses', $listeresponses);

        $this->set('urlLang', $this->getLanguage());
        $this->setReadStatus(1, $id);

        if ($this->request->params['isAjax']) {
            $content = $this->render('detailmessage')->body();
            echo json_encode(['html' => $content]);
            exit;
        }
    }

    public function detailmessage_old($id)
    {
        $this->loadModel("Contactprops");
        $premiermessage = $this->Contactprops->get($id);
        $data=array('lut'=>1);
        $contactprop = $this->Contactprops->patchEntity($premiermessage, $data);
        $this->Contactprops->save($contactprop);

        $this->set('premiermessage', $premiermessage);
        $listereponses = $this->Contactprops->find()->where(['parent_id' => $id])->order(['date_insert' => 'ASC']);
        $this->set('listereponses', $listereponses);

        $session = $this->request->session();
        if($session->read('Auth.User.id') != $premiermessage->locataire_id){
            $listereponsesLut = $this->Contactprops->find()->where(['parent_id' => $id, "locataire_id != 0"])->order(['date_insert' => 'ASC']);
            foreach($listereponsesLut as $listereponselut){
                $data=array('lut'=>1);
                $contactprop = $this->Contactprops->patchEntity($listereponselut, $data);
                $this->Contactprops->save($contactprop);
            }
        }else{
            $listereponsesLut = $this->Contactprops->find()->where(['parent_id' => $id, "locataire_id" => 0])->order(['date_insert' => 'ASC']);
            foreach($listereponsesLut as $listereponselut){
                $data=array('lut'=>1);
                $contactprop = $this->Contactprops->patchEntity($listereponselut, $data);
                $this->Contactprops->save($contactprop);
            }
        }

    }

    /**
     *
     */
    public function repondremessageprop()
    {
        /* $messagetotest = preg_replace('`[^a-zA-Z0-9]`', '', $this->request->data["reponse"]);

        if(preg_match('[[0-9]{8}]', $messagetotest)){
            return $this->redirect(['action' => 'detailmessage', $this->request->data["idmessage"],'?' => ['error' => 1]]);
        }*/

//        $session = $this->request->session();
        $this->loadModel("Contactprops");
        $this->loadModel("Annonces");
        $this->loadModel("Utilisateurs");
        $messageactuel = $this->Contactprops->get($this->request->data["idmessage"]);

        $propannonce = $this->Annonces->get($messageactuel->id_annonce);

        $data = [
            'id_annonce'   => $messageactuel->id_annonce,
            'commentaire'  => $this->request->data["reponse"],
            'date_insert'  => Time::now(),
            'lut'          => 0,
            'locataire_id' => $this->request->data["user_id"],
            'parent_id'    => $this->request->data["idmessage"]
        ];

        $newreponse = $this->Contactprops->newEntity($data);
        $this->Contactprops->save($newreponse);
        /** ENVOYER UN MAIL A FAIRE **/
        $this->loadModel("Registres");
        $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
        $mail=$mails->first();
        // #####################################################
        $event = new Event('Email.send', $this, [
            'from'=>[$mail->val=>FROM_MAIL],
            'to' => $data['email'],
            'textEmail'=>'reponsemessageespaceutilisateur',
            'data'=>[$data['nom'], $data['prenom']],
            'template'=>'creationAnnonce',
            'viewVars'=>'creationAnnonce',
            'noReply'=>false
        ]);
        $this->eventManager()->dispatch($event);
        // #####################################################

        if ($this->request->params['isAjax']) {
            echo json_encode(['idmessage' => $this->request->data["idmessage"]]);
            exit;
        }

        return $this->redirect(['action' => 'detailmessage', $this->request->data["idmessage"]]);
    }

    public function repondremessageprop_()
    {
        $messagetotest = preg_replace('`[^a-zA-Z0-9]`', '', $this->request->data["reponse"]);
        if(preg_match('[[0-9]{8}]', $messagetotest)){
            return $this->redirect(['action' => 'detailmessage', $this->request->data["idmessage"],'?' => ['error' => 1]]);
        }

        $session = $this->request->session();
        $this->loadModel("Contactprops");
        $messageactuel = $this->Contactprops->get($this->request->data["idmessage"]);
        $this->loadModel("Annonces");
        $this->loadModel("Utilisateurs");
        $propannonce = $this->Annonces->get($messageactuel->id_annonce);
        if($propannonce->proprietaire_id == $session->read('Auth.User.id')){
            $data = array(
                'id_annonce' => $messageactuel->id_annonce,
                'commentaire' => $this->request->data["reponse"],
                'date_insert' => Time::now(),
                'lut' => 0,
                'locataire_id' => 0,
                'parent_id' => $this->request->data["idmessage"]
            );
            //$prop = $this->Utilisateurs->get($messageactuel->locataire_id);
            $to = $messageactuel->email;
            $datamustache = array('nom' => $messageactuel->nom, 'prenom' => $messageactuel->prenom);
        }else{
            $data = array(
                'id_annonce' => $messageactuel->id_annonce,
                'commentaire' => $this->request->data["reponse"],
                'date_insert' => Time::now(),
                'lut' => 0,
                'locataire_id' => $session->read('Auth.User.id'),
                'parent_id' => $this->request->data["idmessage"]
            );
            $prop = $this->Utilisateurs->get($propannonce->proprietaire_id);
            $to = $prop->email;
            $datamustache = array('nom' => $prop->nom_famille, 'prenom' => $prop->prenom);
        }
        $newreponse = $this->Contactprops->newEntity($data);
        $this->Contactprops->save($newreponse);
        /** ENVOYER UN MAIL A FAIRE **/
        $this->loadModel("Registres");
        $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
        $mail=$mails->first();
        // #####################################################
        $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $to,'textEmail'=>'reponsemessageespaceutilisateur',
            'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
        ]);
        $this->eventManager()->dispatch($event);
        // #####################################################
        return $this->redirect(['action' => 'detailmessage', $this->request->data["idmessage"]]);
    }

    /**
     *
     **/
    function getarraymessage(){
        $this->viewBuilder()->layout('ajax');
        $this->loadModel("Contactprops");
        $this->set('message',$this->Contactprops->getArrayMessageProp($this->Auth->user('id'),$this->request->query));
    }
    /**
     *
     **/
    function listannonce($id=null){
        $session = $this->request->session();
        $gest=$session->read('Gestionnaire.info');
        $utilisateur = $this->Utilisateurs->get($id);
        if($utilisateur->id != $session->read('Auth.User.id') && $gest['G']['role'] != "gestionnaire" && $gest['G']['role'] != "admin"){
            //$annonce = "";
            $this->Flash->error(__("Vous ne pouvez pas voir les annonces d'un autre utilisateur"),['clear'=> true]);
            $id = null;
            // $this->set("possible", "non");
        }

        $this->loadModel("Annonces");
		$l_annoncesstatuts=array('0'=>__('Brouillon'),'30'=>__('Comité d\'entreprise'),'10'=>__('Désactivée'),'19'=>__('Suspendue'),'50'=>__('Validée'),'40'=>__('Supprimée'));
        $this->set("l_annoncesstatuts",$l_annoncesstatuts);
        $annonces = $this->Annonces->find('all',["conditions"=>["Annonces.proprietaire_id"=>$id,"Annonces.statut != "=>40],'contain' => ['Lieugeos'],"order"=>"Annonces.updated_at desc"]);
        // $data = $this->paginate($annonces);
        // $this->set('annonces', $data);
        $this->set('annonces', $annonces);
        $this->loadModel("Photos");
        $firstphoto = [];
        foreach ($annonces as $value) {
            $firstphoto[$value->id] = $this->Photos->find("all",["order"=>"Photos.numero"])->where(['Photos.annonce_id'=>$value->id])->first();
        }
        $this->set('firstphoto', $firstphoto);        
    }
    /**
     *
     **/
    function getinfomessage($id=null){
        $this->viewBuilder()->layout('ajax');
        $this->loadModel("Contactprops");
        $sql=$this->Contactprops->get($id);
        $this->set("m", $sql);

        $this->loadModel("Reponsecontactprops");
        $reponse = $this->Reponsecontactprops->find('all')->where(["Reponsecontactprops.contactprops_id	= ".$id]);
        $this->set("reponse", $reponse);
    }
    /**
     *
     **/
    function reponsemessageprop($id=null){
        $this->viewBuilder()->layout('ajax');
        $this->loadModel("Contactprops");
        $this->loadModel("Annonces");
        $this->loadModel("Utilisateurs");
        $this->loadModel("Registres");
        $this->loadModel("Reponsecontactprops");
        $message = $this->Contactprops->get($id);
        $annonce = $this->Annonces->get($message->id_annonce);
        $this->set('msg', $message);
        $this->set('annonce', $annonce);
        //print_r($this->request->data);
        if (!empty($this->request->data)) {
            print_r("entree");
            print_r($this->request->data);
            $mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
            $mail=$mails->first();
            $to = $this->Utilisateurs->find()->where(['LOWER(Utilisateurs.email) = "'.strtolower($this->request->data["vTo"]).'"'])->first();
            if(!$to) $to = $this->request->data["vTo"];
            $prop = $this->Utilisateurs->get($annonce->proprietaire_id);
            $emailprop = new Email('production');
            $emailprop->template('msgToLocataire', 'default')
                ->emailFormat('html')
                ->to($this->request->data["vTo"])
                ->from($prop->email)
                ->bcc([$mail->val=>FROM_MAIL])
                ->subject("Reponse à votre demande - Annonce : ".html_entity_decode($this->request->data["vTitreAn"]))
                ->viewVars(['msg'=>html_entity_decode($this->request->data["vMsg"]), 'locataire'=>$to])
                ->send();

            $annonce = $this->Annonces->get($this->request->data["vIDAn"]);
            $emailadm = new Email('production');
            $emailadm->template('msgToAdminReponse', 'default')
                ->emailFormat('html')
                ->to([$mail->val=>FROM_MAIL])
                ->from($prop->email)
                ->subject("Reponse à une demande - Annonce : ".html_entity_decode($this->request->data["vTitreAn"]))
                ->viewVars(['msg'=>html_entity_decode($this->request->data["vMsg"]), 'locataire'=>$to, 'proprietaire'=>$prop, "locMail" => $this->request->data["vTo"]])
                ->send();

            $datareponse = array('contactprops_id'=>$this->request->data["vMsgID"],'message'=>$this->request->data["vMsg"]);
            $reponsemessage = $this->Reponsecontactprops->newEntity($datareponse);
            if($this->Reponsecontactprops->save($reponsemessage)){
                $this->Flash->success(__("votre message a été envoyé."),['clear'=> true]);
                return $this->redirect(['action' => 'mesmessages']);
            } else{
                $this->Flash->error(__("votre message n'a pas pu etre envoyé."),['clear'=> true]);
                return $this->redirect(['action' => 'mesmessages']);
            }
        }
    }
    /**
     *
     **/
//	function setmessage(){
//                $this->viewBuilder()->layout(false);
//		$this->loadModel("Utilisateurs");
//		$this->loadModel("Registres");
//                $this->loadModel("Annonces");
//                $this->loadModel("Reponsecontactprops");
//		$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
//		$mail=$mails->first();
//		$to = $this->Utilisateurs->find()->where(['Utilisateurs.email = "'.$this->request->data["vTo"].'"'])->first();
//		$emailprop = new Email('production');
//		$emailprop->template('msgToLocataire', 'default')
//					->emailFormat('html')
//					->to($this->request->data["vTo"])
//					->from([$mail->val=>FROM_MAIL])
//					->subject("Reponse à votre demande - Annonce : ".html_entity_decode($this->request->data["vTitreAn"]))
//					->viewVars(['msg'=>html_entity_decode($this->request->data["vMsg"]), 'locataire'=>$to])
//					->send();
//
//                $annonce = $this->Annonces->get($this->request->data["vIDAn"]);
//                $prop = $this->Utilisateurs->get($annonce->proprietaire_id);
//                $emailprop = new Email('production');
//		$emailprop->template('msgToAdminReponse', 'default')
//					->emailFormat('html')
//					->to([$mail->val=>FROM_MAIL])
//					->from($prop->email)
//					->subject("Reponse à une demande - Annonce : ".html_entity_decode($this->request->data["vTitreAn"]))
//					->viewVars(['msg'=>html_entity_decode($this->request->data["vMsg"]), 'locataire'=>$to, 'proprietaire'=>$prop])
//					->send();
//
//                $datareponse = array('contactprops_id'=>$this->request->data["vMsgID"],'message'=>$this->request->data["vMsg"]);
//                $reponsemessage = $this->Reponsecontactprops->newEntity($datareponse);
//                if($this->Reponsecontactprops->save($reponsemessage)){
//                    $this->Flash->success(__("votre message a été envoyé."),['clear'=> true]);
//                    $this->autoRender = false;
//                    return $this->redirect(['action' => 'mesmessages']);
//                }
//
////		echo "save";die();
//	}
    /**
     *
     **/
    function addmessage(){
        $this->viewBuilder()->layout('ajax');
        $this->loadModel("Gestionnaires");
        $query = $this->Gestionnaires->find('all');
        $data = $query->toArray();
        $this->set('a_gest',$query);
        $this->set('proprietaireId',$this->Auth->user('id'));
    }
    /**
     *
     **/
    function delMessage()
    {
        $tt ='';
        $this->loadModel("Contactprops");
        $tab = json_decode($this->request->data['testdata']);
        foreach ($tab as $key) {
            $message = $this->Contactprops->get($key);
            if($this->Contactprops->delete($message)){
                $listemessage = $this->Contactprops->find("all")->where(['parent_id'=>$key]);
                foreach ($listemessage as $value) {
                    $this->Contactprops->delete($value);
                }
            }
        }
        echo $this->set("msg",$tt);
    }
    /**
     *
     */
    function getarraypays(){
        $this->viewBuilder()->layout(false);
        $this->loadModel("Pays");
        // $listepays = $this->Pays->find();
        $listepays=$this->Pays->findByCode_pays('Fr')->union(
            $this->Pays->find('all')->where(['code_pays != ' =>'FR'])
        );
        $this->set("listepays", $listepays);
        $payNum=array();
        foreach($listepays as $pay){
            $payNum[$pay->id_pays]=$pay->code_pays;
        }
        $this->set("paysNum", $payNum);
    }
    /**
     *
     **/
    function getarraypaysvilles(){
        $this->viewBuilder()->layout(false);
        $this->loadModel("Pvilles");
        $listevilles = $this->Pvilles->find()->where(['Pvilles.pays_id = '.$this->request->data['paysid']])->order(['Pvilles.name ASC']);
        $this->set("listepville", $listevilles);
    }
    /**
     *
     */
    function getarrayfrancevilles(){
        $this->viewBuilder()->layout(false);
        $this->loadModel("Frvilles");
        $listevilles = $this->Frvilles->find()->where(['Frvilles.departement_id = '.$this->request->data['departementid']])->order(['Frvilles.name ASC']);
        $this->set("listepville", $listevilles);
    }
    /**
     *
     */
    function getarrayregionfrance(){
        $this->viewBuilder()->layout(false);
        $this->loadModel("Departements");
        $listefrregions = $this->Departements->find('all')->order(['Departements.name ASC']);
        $this->set("listefrregions", $listefrregions);
    }
    /**
     *
     */
    public function getdetailfrancecodepostal(){
        $this->viewBuilder()->layout(false);
        $this->loadModel("Frvilles");
        $listevilles = $this->Frvilles->find()->where(['code_postal' => $this->request->data['code']]);
        $this->set("listepville", $listevilles);
    }
    /**
     *
     */
    public function getuserinfos(){
        $idUser=$this->Auth->user('id');
        $this->autoRender = true ;
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $user=$this->Utilisateurs->get($idUser);
        $this->set('user',$user);
        $this->set('_serialize',['user']);
    }
    /**
	 * 
	 */
	public function getRegType($regionid){
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
		return json_decode($response); 
    }
    /**
     * 
     */
    public function listevirementprop()
    {
        $session = $this->request->session();
        $id = $session->read('Auth.User.id');

        $this->loadModel("Reservations");
        $listeVirement = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])->where(["Reservations.statut = 90", "Reservations.type = 0", "Annonces.proprietaire_id" => $id])
        ->join([            
            'dispo' => [
                'table' => 'dispos',
                'type' => 'inner',
                'conditions' => 'dispo.reservation_id=Reservations.id',
            ]
        ]);
        // $listeVirement->select(['Reservations.id','Reservations.date_virement','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','Utilisateurs.prenom','Utilisateurs.nom_famille','total'=>$listeVirement->func()->sum('IF (Reservations.prixreservation=0, IF (dispo.promo_yn=0 , dispo.prix , dispo.promo_px), Reservations.prixreservation)')])
        $listeVirement->select(['Reservations.id','Reservations.date_virement','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','Utilisateurs.prenom','Utilisateurs.nom_famille','Reservations.prixreservation','dispo.promo_yn' , 'dispo.prix' , 'dispo.promo_px']);
        // ->group('Reservations.id')
        $listeVirement->order(['Reservations.dbt_at'=>'desc']);
        // $this->set("listeVirement", $listeVirement);

        foreach ($listeVirement as $reservationSum) {
            if($reservationSum->prixreservation == 0){
                if($reservationSum['dispo']['promo_yn'] == 0) $prixtab[$reservationSum->id] += $reservationSum['dispo']['prix'];
                else $prixtab[$reservationSum->id] += $reservationSum['dispo']['promo_px'];
            }else{
                $prixtab[$reservationSum->id] = $reservationSum->prixreservation;
            }
        }

        $listeVirement->group('Reservations.id');
        $output = array(
			"data" => array()
			);
        $this->loadModel("Utilisateurs");
        $infoprop = $this->Utilisateurs->get($id, ['contain'=>['Cautions', 'Paiements', 'Annulations']]);
        if($infoprop->nature == "PRES" && !empty($infoprop->paiements) && $infoprop->paiements[0]->taux_commission != 0) $tauxcommession = $infoprop->paiements[0]->taux_commission;
        else $tauxcommession = 3;
		foreach ($listeVirement as $value) {
			$row[0] = $value->id;
			$row[1] = $value->dbt_at->i18nFormat('dd/MM/yyyy')." - ".$value->fin_at->i18nFormat('dd/MM/yyyy');
			$row[2] = $value->annonce_id;
			$row[3] = $value['utilisateur']['prenom']." ".$value['utilisateur']['nom_famille'];
			$row[4] = round(($prixtab[$value->id]-($prixtab[$value->id]*$tauxcommession/100)), 2)." €";

			$now   = $value->dbt_at;
			$clone = clone $now;
			$tet = $clone->modify( '+2 day' );
            
            if($value->date_virement != NULL){
				$row[5] = "<span class='text-success'>".__('Payé')." : ".$value->date_virement->i18nFormat('dd-MM-yyyy')."</span>";
			}else{
                // $row[5] = new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'))."***".$tet."***".new Date($tet->format( 'd-m-Y' ))."***".new Date();
                if(new Date() > new Date($tet->format( 'd-m-Y' ))) $row[5] = "<span class='text-success'>".__('Payé')."</span>";
                if(new Date() >= new Date($value->dbt_at->i18nFormat('dd-MM-yyyy')) && new Date() <= new Date($tet->format( 'd-m-Y' ))) $row[5] = "<span class='text-warning'>".__('En attente')."</span>";
                if(new Date() < new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'))) $row[5] = "<span class='text-danger'>".__('En attente')."</span>";
            }

			$output['data'][] = $row;
		}
		echo json_encode( $output );die();
    }
    /**
     *
     */
    public function infobancaire($id)
	{	
		$session = $this->request->session();
		if($id != $session->read('Auth.User.id')){
			//$annonce = "";
			$this->Flash->error(__("Vous ne pouvez pas voir les informations d'un autre utilisateur"),['clear'=> true]);
			if($session->read('Auth.User.nature')=='CLT')
					return $this->redirect(['action' => 'locataireIndex']);
			else
					return $this->redirect(['action' => 'index']);
		}

		$this->loadModel("Utilisateurs");
		$this->loadModel("Informationbancaires");	
		$utilisateur = $this->Utilisateurs->get($id);
		$this->set('utilisateur',$utilisateur);

		if($utilisateur->informationbancaire_id != 0){
			$oldinfo = $this->Informationbancaires->get($utilisateur->informationbancaire_id);
			$this->set('infobancaire',$oldinfo);
        }
                
        if ($this->request->data) {				
			if($utilisateur->informationbancaire_id == 0){
				$newinfo = $this->Informationbancaires->newEntity($this->request->data);
				$info = $this->Informationbancaires->save($newinfo);
				//update info utilisateur
				$newutil = $this->Utilisateurs->patchEntity($utilisateur, array("informationbancaire_id"=>$info->id));
				$this->Utilisateurs->save($newutil);				
				$this->Flash->success(__('Vos informations bancaires ont été enregistrées avec success.'),['clear'=> true]);				
			}else{
				$oldinfo = $this->Informationbancaires->get($utilisateur->informationbancaire_id);
				$newinfo = $this->Informationbancaires->patchEntity($oldinfo, $this->request->data);
				$info = $this->Informationbancaires->save($newinfo);				
				$this->Flash->success(__('Vos informations bancaires ont été modifiées avec success.'),['clear'=> true]);
			}			
			$this->set('infobancaire',$info);
			// Enregistrement adresse
			$newinfoadress = $this->Utilisateurs->patchEntity($utilisateur, $this->request->data);
            $utilisateur = $this->Utilisateurs->save($newinfoadress);
            
            // Send mail verificationIban
            $this->loadModel("Registres");
            $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
            $mail=$mails->first();

            $this->loadModel('Pays');
            $payscode = $this->Pays->get($utilisateur->pays);

            if($utilisateur->pays == 67){
                $this->loadModel('Frvilles');
			    $villeLivraison = $this->Frvilles->get($utilisateur->ville);
            }else{
                $this->loadModel("Pvilles");
                $villeLivraison = $this->Pvilles->get($utilisateur->ville);
            }        
			
			$datamustache = array('prenomprop' => $utilisateur->prenom, 'nomprop' => $utilisateur->nom_famille, 'iban' => $this->request->data['IBAN'], 'bic' => $this->request->data['BIC'], 'titulaire' => $this->request->data['titulaire_compte'], 'rue' => $this->request->data['adresse'], 'codepostal' => $this->request->data['code_postal'], 'ville' => $villeLivraison->name, 'pays' => $payscode->fr);
            // #####################################################
            $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $utilisateur,'textEmail'=>'verificationIban',
                'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
            ]);
            $this->eventManager()->dispatch($event);
            // #####################################################
			
			/**** MODIFICATION ADRESSE LIVRAISON SUR BOUTIQUE ****/
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
			$customerEmail = $utilisateur->email;   //à changer
			if($utilisateur->prenom == '') $customer_fname = "_";
			else $customer_fname = $utilisateur->prenom ; // prenom du client
			$customer_lname = $utilisateur->nom_famille; // Nom du client

			$requestUrl = $magentoURL.'index.php/rest/V1/customers/search?searchCriteria[filter_groups][0][filters][0][field]=email&searchCriteria[filter_groups][0][filters][0][value]=%25'.$customerEmail.'%25&searchCriteria[filter_groups][0][filters][0][condition_type]=like';
			$ch = curl_init($requestUrl);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			$result = json_decode($result, true);
			// print_r($result);
			
			//*********** Mise a jour du mot de passe du client et eventuellement son nom ...
			// si le client existe (email) dans la boutique ********//			
			
			
			$resultatregionshipping = $this->getRegType($utilisateur->region);
			
			if ($result["items"]){
				$id = $result['items'][0]['id'];
				$customerData = [
					'customer' => [
						'id' => $id,
						// "group_id" => '7',
						"email" => $customerEmail,
						"firstname" => $customer_fname,
						"lastname" => $customer_lname,
						"storeId" => 1,
						"websiteId" => 1,
						"addresses" => [						
							"1" => [
								"customer_id" => $id,
								"region" => [
									"region_code" => $resultatregionshipping[2], 
									"region" => $resultatregionshipping[4], 
									"region_id" => $resultatregionshipping[0] 
										],
								"region_id" => $resultatregionshipping[0], 
								"country_id" => $payscode->code_pays,
								"street" => [
									"0" => $utilisateur->adresse
								],
								"telephone" => $utilisateur->portable,
								"postcode" => $utilisateur->code_postal,
								"city" => $villeLivraison->name,
								"firstname" => $customer_fname,
								"lastname" => $customer_lname,
								"default_billing" => '1'
							],
						],
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

				// echo '<pre>';print_r($result);  //Tu peux enlever
				// exit;

                /**** ADRESSE FACTURATION BILLING TAMPON BASE ****/
                $this->loadModel('TamponAdresseClient');
                /*$shippingInfo = $this->TamponAdresseClient->find()->where(['client_id_loc' => $utilisateur->id, 'source <>' => 2])->order(['id DESC']);
                if($shippingInfo = $shippingInfo->first()){
                    $phone_shipping = $shippingInfo->phone_shipping;
                    $country_shipping = $shippingInfo->country_shipping;
                    $city_shipping = $shippingInfo->city_shipping;
                    $street_shipping = $shippingInfo->street_shipping;
                    $postcode_shipping = $shippingInfo->postcode_shipping;
                }else{
                    $phone_shipping = $utilisateur->portable;
                    $country_shipping = $payscode->code_pays;
                    $city_shipping = $villeLivraison->name;
                    $street_shipping = $utilisateur->adresse;
                    $postcode_shipping = $utilisateur->code_postal;
                }*/
                $dataTamponShipping = array(
                    'client_id_loc' => $utilisateur->id,
                    'firstname' => $utilisateur->prenom,
                    'lastname' => $utilisateur->nom_famille,
                    'phone_shipping' => "--",
                    'country_shipping' => "--",
                    'city_shipping' => "--",
                    'street_shipping' => "--",
                    'postcode_shipping' => "--",
                    'phone_biling' => $utilisateur->portable,
                    'country_biling' => $payscode->code_pays,
                    'city_biling' => $villeLivraison->name,
                    'street_biling' => $utilisateur->adresse,
                    'postcode_biling' => $utilisateur->code_postal,
                    'source' => 2,
                    'is_sync' => 0,
                    'created_at' => Time::now()
                );
                $TamponAdresseClient = $this->TamponAdresseClient->newEntity($dataTamponShipping);
                $this->TamponAdresseClient->save($TamponAdresseClient);
                /**** END ADRESSE FACTURATION BILLING TAMPON BASE ****/
			} 
			// exit;
			curl_close($ch);
			/**** END MODIFICATION ADRESSE FACTURATION SUR BOUTIQUE ****/
		}
		$this->loadModel("Pays");
	  	$Pays=$this->Pays->find('all');
		$a_pay=array();
		$payNum=array();
		$a_pay[0] = '';
		foreach($Pays as $pay){
            if($session->read('Config.language') == "fr_FR") $a_pay[$pay->id_pays]=$pay->fr;
            if($session->read('Config.language') == "en_US") $a_pay[$pay->id_pays]=$pay->en;
			$payNum[$pay->id_pays]=$pay->code_pays;
		}
		$this->set("Pays", $a_pay);

	}
    /**
     *
     */
    public function getnbmessage()
    {
        $this->viewBuilder()->layout(false);
        $this->autoRender = false;
        $session = $this->request->session();

        $nbr = 0;
        if($this->Auth->user('id') && $this->Auth->user('id') != ''){
            $this->loadModel("Contactprops");
            $rResult = $this->Contactprops->find();
            $rResult->join([
                'A' => [
                    'table' => 'annonces',
                    'type' => 'inner',
                    'conditions' => 'A.id=Contactprops.id_annonce',
                ]
            ]);
            $rResult->where([
                '(A.proprietaire_id = '.$this->Auth->user('id').' OR Contactprops.locataire_id = '.$this->Auth->user('id').')',
                '(A.contrat = 1 OR A.mise_relation = 1)',
                'Contactprops.parent_id = 0'
            ]);

            foreach($rResult as $val){
                $result = $this->Contactprops->find()->where([
                    'Contactprops.parent_id' => $val->id,
                    'Contactprops.lut' => 0,
                    'Contactprops.locataire_id != ' . $this->Auth->user('id')
                ]);

                $nbr += $result->count();
    
                if($val->lut == 0 && $val->locataire_id != $session->read('Auth.User.id')) $nbr++;
            }
        }      
        echo ($nbr);
        die();
    }

    function changearchived()
    {
        $this->loadModel("Contactprops");
        $premiermessage = $this->Contactprops->get($this->request->data['idmessage']);

        $contactprop = $this->Contactprops->patchEntity($premiermessage, ['archived' => $this->request->data['archived_value']]);
        $this->Contactprops->save($contactprop);

        echo json_encode(['res' => true]);
        exit;
    }

    function changereadstatus()
    {
        $this->setReadStatus($this->request->data['read_status_value'], $this->request->data['idmessage']);

        echo json_encode(['res' => true]);
        exit;
    }

    private function setReadStatus($status, $messageId)
    {
        $this->loadModel("Contactprops");
        $condition = [
            '(id = ' . $messageId . ' OR parent_id = '. $messageId .')',
            'Contactprops.locataire_id != ' . $this->Auth->user('id')
        ];

        $listereponsesLut = $this->Contactprops->find()->where($condition)->order(['date_insert' => 'ASC']);
        foreach($listereponsesLut as $listereponselut) {
            $contactprop = $this->Contactprops->patchEntity($listereponselut, ['lut' => $status]);
            $this->Contactprops->save($contactprop);
        }
    }

}
?>