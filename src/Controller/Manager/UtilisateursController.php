<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use App\Controller\SendInBlueController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use SoapClient;
use Mage;
use Mustache_Engine;
/**
 * Utilisateurs Controller
 *
 * @property \App\Model\Table\UtilisateursTable $Utilisateurs
 */
class UtilisateursController extends AppController
{
	/*
	 *
	 */
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $admin_actions=['listuser','gestion','modelmailsysteme','modelsmsysteme','editmodelsysteme','smscsv','statPays'];
        $session = $this->request->session();
        if(!$session->check("Gestionnaire.info")){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
        $gest=$session->read('Gestionnaire.info');
        if ($gest['G']['role']=="gestionnaire" && in_array($this->request->getParam('action'), $admin_actions)){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
    }
	/**
	 *
	 **/
	public function gestion()
	{
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
	public function gpaginate(){
		$url=Router::url('/');
		$hotels = $this->Utilisateurs->get_array_utilisateur($url,$this->request->query);
		echo json_encode( $hotels );die();
	}
        
	public function contratsDisabled(){
		$url=Router::url('/');
		$hotels = $this->Utilisateurs->get_array_contrats_disabled($url,$this->request->query);
		echo json_encode( $hotels );die();
	}
	/**
	 *
	 **/
	public function gpaginategestionnaire(){
		$url=Router::url('/');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		$hotels = $this->Utilisateurs->get_array_utilisateur_gestionnaire($url,$this->request->query,$gestionnaire['G']['id']);
		echo json_encode( $hotels );die();
	}
	/**
	 *
	 **/
	public function contactprop(){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
	/**
	 *
	 **/
	public function listuser(){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
	/**
	 *
	 **/
	 public function jsonutilisateur(){
		$url=Router::url('/');
		$hotels = $this->Utilisateurs->get_json_user($url,$this->request->query);
		echo json_encode( $hotels );die();
	}
	/**
	 *
	 **/
	 public function jsonutilisateurgestionnaire(){
		$url=Router::url('/');
		$session = $this->request->session();
 	 	$gestionnaire=$session->read('Gestionnaire.info');
		$hotels = $this->Utilisateurs->get_json_user_gestionnaire($url,$this->request->query,$gestionnaire['G']['id']);
		echo json_encode( $hotels );die();
	}
	/**
	 *
	 **/
	function ficheuser($id=null){
            $this->viewBuilder()->layout('ajax');
			$session = $this->request->session();
			//set manager infos
			$this->set('InfoGes',$session->read('Gestionnaire.info'));
			//end set manager infos
            $res=$this->Utilisateurs->getdetailuser($id);
            $this->set('user',$res);
            $this->loadModel("Pays");
            $Pays=$this->Pays->find('all')->order(['Pays.fr' => 'ASC']);
            $a_pay=array();
            $payNum=array();
            $a_pay[0] = 'Choisir pays';
            foreach($Pays as $pay){
                    $a_pay[$pay->id_pays]=$pay->fr;
                    $payNum[$pay->id_pays]=$pay->code_pays;
            }
            $this->set("Pays", $a_pay);
            $this->set("paysNum", $payNum);
	}
	/**
	 *
	 **/
	function edituser(){
		$utilisateur=$this->Utilisateurs->get($this->request->data['vId']);
		$oldmail = $utilisateur->email;
		if($this->request->data['vType'] == "PRES") $this->request->data['vNom'] = "--";
		$data_u=array("email"=>strtolower($this->request->data['vEmail']),"prenom"=>$this->request->data['vPrenom'],"description"=>$this->request->data['vDescription'],"nom_famille"=>$this->request->data['vNom'],"nature"=>$this->request->data['vType'],"telephone"=>$this->request->data['vTel'],"portable"=>$this->request->data['vPortable'],"ident"=>$this->request->data['vEmail'],"adresse"=>$this->request->data['vAdres'],"code_postal"=>$this->request->data['vPostal'],"ville"=>$this->request->data['vVille'],"pays"=>$this->request->data['vPays'],"region"=>$this->request->data['vRegion']);
		$utilisateur=$this->Utilisateurs->patchEntity($utilisateur,$data_u);
		if(!empty($this->request->data['vPassword'])){
			$utilisateur->pwd=(new DefaultPasswordHasher)->hash($this->request->data['vPassword']);
			$utilisateur->mot_passe=md5($this->request->data['vPassword']);
		}
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
		$customerEmail = $this->request->data['vEmail'];   //à changer
		if($this->request->data['vPrenom'] == '') $customer_fname = "_";
		else $customer_fname = $this->request->data['vPrenom'] ; // prenom du client
		$customer_lname = $this->request->data['vNom']; // Nom du client
		$password = $this->request->data['vPassword']; // mot de passe
		

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
		if(!empty($this->request->data['vPassword'])) {
			// **** mettre l'email du client depuis le site location **********//
			$newpassword = $this->request->data['vPassword'];
			
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
		}
		curl_close($ch);
		/*** END MISE A JOUR BOUTIQUE ***/
		$utilisateur->date_update=Time::now();
		$this->Utilisateurs->save($utilisateur);
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
                        
                        echo 'editmail';
                        //end resend mail
						if(PROD_ON == 1){
							$sendinblue=new SendInBlueController();
							$sendinblue->updateContactEmail($oldmail,$utilisateur->email);
							$sendinblue->updateContactToSendInBlue($utilisateur->email,$utilisateur->prenom,$utilisateur->nom_famille,$utilisateur->portable,$utilisateur->civilite,$utilisateur->naissance,$utilisateur->adresse,$utilisateur->code_postal,$Sville,$this->Pays->get($utilisateur->pays)->fr);
                		}
					}
                //End SendInBlue
		die();
	}
	/**
	 *
	 **/
	function deleteuser($id=null){
            $user = $this->Utilisateurs->get($id);
            $email=$user->email;
            if($this->Utilisateurs->delete($user))
            {
				if(PROD_ON == 1){
					$sendinblue=new SendInBlueController();
					$res=$sendinblue->deleteContact($email);
			   	}
            }
    
		die();
	}
	/**
	 *
	 **/
	public function paginatecontact(){
		$url=Router::url('/');
		$this->loadModel("Contactprops");
		$hotels = $this->Contactprops->get_array_prop($url,$this->request->query);
		echo json_encode( $hotels );die();
	}
	/**
	 *
	 **/
 public function paginatecontactgestionnaire(){
	 $url=Router::url('/');
	 $this->loadModel("Contactprops");
	 $session = $this->request->session();
	 $gestionnaire=$session->read('Gestionnaire.info');
	 $hotels = $this->Contactprops->get_array_prop_gestionnaire($url,$this->request->query,$gestionnaire['G']['id']);
	 echo json_encode( $hotels );die();
 }
 /**
	*
	**/
	function getmessage($id=null){
            $this->viewBuilder()->layout('ajax');
            $this->loadModel("Contactprops");
            $res=$this->Contactprops->get($id);
            $this->set('comment',$res->commentaire);

            $this->loadModel("Reponsecontactprops");
            $reponse = $this->Reponsecontactprops->find('all')->where(["Reponsecontactprops.contactprops_id	= ".$id]);
            $this->set("reponse", $reponse);
	}
	/**
	 *
	 **/
	function deletemodelsms($id=null){
		$session = $this->request->session();
		$this->loadModel("Modelmessages");
		$sms = $this->Modelmessages->get($id);
		if ($this->Modelmessages->delete($sms)) {
		    $session->write("Modelmessage.delete","delete");
			return $this->redirect(['action' => 'modelsms']);
		}
		return $this->redirect(['action' => 'modelsms']);
	}
	/**
		*
		**/
	 function deletemodel($id=null){
		$this->loadModel("Modelmails");
		$session = $this->request->session();
		$mail = $this->Modelmails->get($id);
		if ($this->Modelmails->delete($mail)) {
		    $session->write("Modelmail.delete","delete");
				return $this->redirect(['action' => 'modelmail']);
		}
		return $this->redirect(['action' => 'modelmail']);
	}
	/**
	 *
	 **/
	 function modelmail(){
		 $session = $this->request->session();
 		$this->viewBuilder()->layout('manager');

 		if($session->check("Modelmail.delete")){
 			$this->set('confirm_res','reservation');
 			$session->delete("Modelmail.delete");
 		}
 		$gestionnaire=$session->read('Gestionnaire.info');
 		$this->loadModel('Modelmails');
 		$this->set('modelmessage', $this->Modelmails->find('all',['conditions'=>['id_gestionnaire'=>$gestionnaire['G']['id']]]));
 		$this->set('InfoGes',$gestionnaire);
	 }
	 /**
	  *
	  **/
	 function modelmailsysteme(){
	  $session = $this->request->session();
	  $this->viewBuilder()->layout('manager');

	  if($session->check("Modelmail.delete")){
	 	 $this->set('confirm_res','reservation');
	 	 $session->delete("Modelmail.delete");
	  }
	  $gestionnaire=$session->read('Gestionnaire.info');
	  $this->loadModel('Modelmailsysteme');
		$result = $this->Modelmailsysteme->find('all');
		$this->set('modelmessage', $result);
	  $this->set('InfoGes',$gestionnaire);
	 }
	 /**
	  * 
	  */
	  public function modelsmsysteme()
	  {
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
  
		if($session->check("Modelmail.delete")){
			$this->set('confirm_res','reservation');
			$session->delete("Modelmail.delete");
		}
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->loadModel('Modelsmsysteme');
		$result = $this->Modelsmsysteme->find('all');
		$this->set('modelmessage', $result);
		$this->set('InfoGes',$gestionnaire); 
	  }
	 /**
	  *
	  **/
	 function modelsms(){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');

		if($session->check("Modelmessage.delete")){
			$this->set('confirm_res','reservation');
			$session->delete("Modelmessage.delete");
		}
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->loadModel('Modelmessages');
		$this->set('modelmessage', $this->Modelmessages->find('all',['conditions'=>['id_gestionnaire'=>$gestionnaire['G']['id']]]));
		$this->set('InfoGes',$gestionnaire);
	 }
	/**
 	 *
 	 **/
	 function addmodel(){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		if($session->check("Modelmail.add")){
			$this->set('confirm_res','reservation');
			$session->delete("Modelmail.add");
		}
		$this->loadModel('Modelmails');

		$modelmessage = $this->Modelmails->newEntity();
    if ($this->request->is('post')) {
				$data=array('titre'=>$this->request->data['titre'],'sujet'=>$this->request->data['sujet'],'txtmail'=>$this->request->data['quellePage'],'id_gestionnaire'=>$this->request->data['id_gestionnaire']);
				$modelmessage = $this->Modelmails->patchEntity($modelmessage, $data);
		    if ($this->Modelmails->save($modelmessage)) {
		      	$session->write("Modelmail.add","addmail");
						return $this->redirect(['action' => 'addmodel']);
				}
		}
		$this->set(compact('modelmessage'));
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	 }
	/**
 	 *
 	 **/
	 function addmodelsms(){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		if($session->check("Modelmessage.add")){
			$this->set('confirm_res','reservation');
			$session->delete("Modelmessage.add");
		}
		$this->loadModel('Modelmessages');
		$modelmessage = $this->Modelmessages->newEntity();
    if ($this->request->is('post')) {
				$modelmessage = $this->Modelmessages->patchEntity($modelmessage, $this->request->data);
      	if ($this->Modelmessages->save($modelmessage)) {
          	$session->write("Modelmessage.add","addmail");
						return $this->redirect(['action' => 'addmodelsms']);
				}
		}
		$this->set(compact('modelmessage'));
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	 }
	 /**
	  *
	  **/
	 function editmodelsms($id=null){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		if($session->check("Modelmessage.add")){
			$this->set('confirm_res','reservation');
			$session->delete("Modelmessage.add");
		}
		$this->loadModel('Modelmessages');
		$modelmessage = $this->Modelmessages->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {
        $modelmessage = $this->Modelmessages->patchEntity($modelmessage, $this->request->data);
        if ($this->Modelmessages->save($modelmessage)) {
          	$session->write("Modelmessage.add","addmail");
						return $this->redirect(['action' => 'editmodelsms',$modelmessage->id]);
        }
    }
    $this->set(compact('modelmessage'));
    $this->set('_serialize', ['modelmessage']);
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	 }
	/**
 	 *
 	 **/
	 function editmodel($id=null){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		if($session->check("Modelmessage.add")){
			$this->set('confirm_res','reservation');
			$session->delete("Modelmessage.add");
		}
		$this->loadModel('Modelmails');
		$modelmessage = $this->Modelmails->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {
				$data=array('titre'=>$this->request->data['titre'],'sujet'=>$this->request->data['sujet'],'txtmail'=>$this->request->data['txtmail'],'id_gestionnaire'=>$this->request->data['id_gestionnaire']);
        $modelmessage = $this->Modelmails->patchEntity($modelmessage, $data);
        if ($this->Modelmails->save($modelmessage)) {
            $session->write("Modelmessage.add","addmail");
						return $this->redirect(['action' => 'editmodel',$modelmessage->id]);
        }
    }
    $this->set(compact('modelmessage'));
    $this->set('_serialize', ['modelmessage']);
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	 }
	 /**
	  *
	  **/
	 function editmodelsysteme($id=null){
            $session = $this->request->session();
            $this->viewBuilder()->layout('manager');
            if($session->check("Modelmessage.add")){
                    $this->set('confirm_res','reservation');
                    $session->delete("Modelmessage.add");
            }
            $this->loadModel('Modelmailsysteme');
            $modelmessage = $this->Modelmailsysteme->get($id);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $modelmessage = $this->Modelmailsysteme->patchEntity($modelmessage, $this->request->data);
                if ($this->Modelmailsysteme->save($modelmessage)) {
                    $session->write("Modelmessage.add","addmail");
                    return $this->redirect(['action' => 'editmodelsysteme',$modelmessage->id]);
                }
            }
            $this->set(compact('modelmessage'));
            $this->set('_serialize', ['modelmessage']);
            $this->set('InfoGes',$session->read('Gestionnaire.info'));
	 }
	/**
	 * 
	 */
	public function editmodelsmsysteme($id=null)
	{
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		if($session->check("Modelmessage.add")){
			$this->set('confirm_res','reservation');
			$session->delete("Modelmessage.add");
		}
		$this->loadModel('Modelsmsysteme');
		$modelmessage = $this->Modelsmsysteme->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$modelmessage = $this->Modelsmsysteme->patchEntity($modelmessage, $this->request->data);
			if ($this->Modelsmsysteme->save($modelmessage)) {
				$session->write("Modelmessage.add","addmail");
				return $this->redirect(['action' => 'editmodelsmsysteme',$modelmessage->id]);
			}
		}
		$this->set(compact('modelmessage'));
		$this->set('_serialize', ['modelmessage']);
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
	 /**
	  *
	  **/
		function smscsv(){
			$this->viewBuilder()->layout('manager');
			$session1 = $this->request->session();
			$this->set('InfoGes',$session1->read('Gestionnaire.info'));
				if($session1->check("Prop.sms")){
					$this->set('confirm_res',$session1->read('Prop.sms'));
					$session1->delete("Prop.sms");
				}
				if($session1->check("Error.sms")){
					$this->set('error_res',$session1->read('Error.sms'));
					$session1->delete("Error.sms");
				}
				if($session1->check("olddesc")){
					$this->set('olddesc',$session1->read('olddesc'));
				}
				if(!empty($this->request->data)){
					$csv=array();
					if (($handle = fopen($this->request->data['filename']['tmp_name'], "r")) !== FALSE) {
						while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
							if(!empty($data[0])){
								$num= str_replace(" ", "", $data[0]);
								if (preg_match('/^(\+|)[0-9]+$/',$num)==1)
								{
									$csv[]=$num;
								}
								else
								{
									$session1->write("Error.sms","Le fichier csv contient un numéro invalide : ".$data[0]);
									$session1->write("olddesc",$this->request->data["description"]);
									return $this->redirect(['action' => 'smscsv']);
								}
							}
						}
					}
					if($this->request->data['tabtype'][0] == 'commerce') $varbo = false;
					else $varbo = true;
					$soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.61.wsdl"); 	//login
					$session = $soap->login("dt29400-ovh", 'q}XcJ_"jLw',"fr", false);					
					foreach($csv as $ligne){
						if(!empty($ligne)){
							try{								
								$result = $soap->telephonySmsSend($session, "sms-dt29400-1", "alpissime",'+'.$ligne,$this->request->data["description"], "2880", "1", "0", "3", "1", "", $varbo);
							}catch(Exception $e){
								$session1->write("Error.sms","L'envoi des SMS interrompue par le numéro : ".$ligne);
								$session1->write("olddesc",$this->request->data["description"]);
								return $this->redirect(['action' => 'smscsv']);
							}
						}
					}
					if(isset($this->request->data['Copie_administrateur'])){
						$result = $soap->telephonySmsSend($session, "sms-dt29400-1", "alpissime","0033612290615",$this->request->data["description"], "2880", "1", "0", "3", "1", "", $varbo);
					}
					$session1->write("Prop.sms","send");
					$soap->logout($session);
					return $this->redirect(['action' => 'smscsv']);
				}
		}
	/*
	 *
	 */
	function getFormatFrenchPhoneNumber($phoneNumber, $international = false){
		//Supprimer tous les caract�res qui ne sont pas des chiffres
		$phoneNumber = preg_replace('/[^0-9]+/', '', $phoneNumber);
		//Garder les 9 derniers chiffres
		$v_au=substr($autre,0,2);
		if($v_au=='33'){
			return '+'.$phoneNumber;
		}else{
			$phoneNumber = substr($phoneNumber, -9);
			//On ajoute +33 si la variable $international vaut true et 0 dans tous les autres cas
			$motif = $international ? '+33\1\2\3\4\5' : '0\1\2\3\4\5';
			$phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
			return $phoneNumber;
		}
	}
	/**
	 *
	 **/
	function add(){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
		if ($this->request->is('post')) {
				$data=array('prenom' => $this->request->data["prenom"],
							'nom_famille' => $this->request->data["nom_famille"],
							'civilite' => $this->request->data["civilite"],
							'email' => strtolower($this->request->data["email"]),
							'telephone' => $this->request->data["telephone"],
							'code_postal' => $this->request->data["code_postal"],
							'ville' => $this->request->data["ville"],
							'adresse' => $this->request->data["adresse"],
							'mot_passe' => md5($this->request->data["mdp"]),
							'ident' => $this->request->data["email"],
							'naissance' => $this->toDate($this->request->data["naissance"]),
							'nature' => "ANIM",
							'statut' => 90,
							'priv' => 'util');
      $utilisateur = $this->Utilisateurs->newEntity($data);
			$utilisateur->pwd=(new DefaultPasswordHasher)->hash($this->request->data['mdp']);
      $this->Utilisateurs->save($utilisateur);
			return $this->redirect(['action' => 'animlist']);
		}
		$a_civi=array('Melle'=>'Mademoiselle','Mme'=>'Madame','M.'=>'Monsieur');
		$this->set("l_civilites", $a_civi);
	}
	/**
	 *
	 **/
	 function animlist(){
			$this->viewBuilder()->layout('manager');
			$session = $this->request->session();
			$this->loadModel('Utilisateurs');
			$this->set('InfoGes',$session->read('Gestionnaire.info'));
			if($session->check("Animateur.edit")){
				$this->set('confirm_res',$session->read('Animateur.edit'));
				$session->delete("Animateur.edit");
			}
			$this->set('animateur', $this->Utilisateurs->find("all", ["conditions"=>"Utilisateurs.nature='ANIM'"]));
	 }
	/**
 	 *
 	 **/
	function edit($id=null){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
		$this->loadModel('Utilisateurs');
		$utilisateur = $this->Utilisateurs->get($id, ['contain' => []]);
		if ($this->request->is(['patch', 'post', 'put'])) {
				$data=array('prenom' => $this->request->data["prenom"],
							'nom_famille' => $this->request->data["nom_famille"],
							'civilite' => $this->request->data["civilite"],
							'email' => strtolower($this->request->data["email"]),
							'telephone' => $this->request->data["telephone"],
							'code_postal' => $this->request->data["code_postal"],
							'ville' => $this->request->data["ville"],
							'adresse' => $this->request->data["adresse"],
							'ident' => $this->request->data["email"],
							'naissance' => $this->toDate($this->request->data["naissance"]),
							'nature' => "ANIM",
							'statut' => 90,
							'priv' => '');
      $utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $data);
			if(!empty($this->request->data['mdp']))
				$utilisateur->pwd=(new DefaultPasswordHasher)->hash($this->request->data['mdp']);
      $this->Utilisateurs->save($utilisateur);
			return $this->redirect(['action' => 'animlist']);
		}
		$a_civi=array('Melle'=>'Mademoiselle','Mme'=>'Madame','M.'=>'Monsieur');
		$this->set("l_civilites", $a_civi);
		$this->set(compact('utilisateur'));
  	$this->set('_serialize', ['utilisateur']);
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
		$this->loadModel('Utilisateurs');
    $utilisateur = $this->Utilisateurs->get($id);
    $this->Utilisateurs->delete($utilisateur);
    return $this->redirect(['action' => 'animlist']);
  }
  
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
  
  public function checkPhoneUnique($id = null,$requestedPhone = null)
  {
      $this->loadModel('Utilisateurs');
      if($id=="null"){
        $user=$this->Utilisateurs->find()->where(['portable' => $requestedPhone])->first();
            if($user==null)  echo 'true';
            else echo 'false';
        die();
      }
        $requestedPhone= "+".$requestedPhone;
        $requestedPhone = str_replace(' ', '', $requestedPhone);
        $utilisateur = $this->Utilisateurs->get($id);
        if($utilisateur->portable==$requestedPhone) {echo 'true'; die();}
        else {
            $user=$this->Utilisateurs->find()->where(['portable' => $requestedPhone])->first();
            if($user==null)  echo 'true';
            else echo 'false';
        }
        die();
	}
	/**
	 * 
	 */
	public function populationetrangers($anne){
		$this->RequestHandler->renderAs($this, 'json'/*or xml*/);
		$this->loadModel('Utilisateurs');
		$tousLesPays=$this->Utilisateurs->find('all')->where(["(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT' OR Utilisateurs.nature = 'CLT')", '(Utilisateurs.telephone != "" OR Utilisateurs.portable != "")', '(Utilisateurs.telephone IS NOT NULL OR Utilisateurs.portable IS NOT NULL)']);
		if(strtoupper($anne)!='ALL')
		{
				$anne=intval($anne);
				$tousLesPays->where(["( (date_insert >= STR_TO_DATE('".($anne-1)."-09-01','%Y-%m-%d')) AND (date_insert <= STR_TO_DATE('".($anne)."-08-31','%Y-%m-%d')) )"]);
		}else
		{
				$tousLesPays->where(["( (date_insert >= STR_TO_DATE('2017-09-01','%Y-%m-%d')) )"]);
		}
		$tousLesPays=$tousLesPays->count();
		$francePays=$this->Utilisateurs->getStatsPays('Tous',null,$anne);
		$paysStats=$this->Utilisateurs->getStatsPays('Belgique',"(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^((32|0032)|0)4(60|[56789][0-9])([0-9]{2}){3}$')",$anne)
						->union($this->Utilisateurs->getStatsPays('Pays-bas',"(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(03|3|01|1|04|4|05|5)[0-9]{8}$' OR REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(31|0031)[0-9]{9}$' OR REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(071|71|070|70|072|72)[0-9]{7}$')",$anne))
						->union($this->Utilisateurs->getStatsPays('Grande Bretagne',"(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(44|0044)[0-9]{10}$' OR REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(07|7)[0-9]{9}$')",$anne))
						->union($this->Utilisateurs->getStatsPays('Suisse',"(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(41|0041)[0-9]{9}$')",$anne))
						->union($this->Utilisateurs->getStatsPays('Allemagne',"(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(15|16|17|015|016|017)[0-9]{9}$' OR REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(49|0049)[0-9]{11}$')",$anne))
						->union($this->Utilisateurs->getStatsPays('Espagne',"(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(6)[0-9]{8}$' OR REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(34|0034)[0-9]{9}$')",$anne))
						->union($this->Utilisateurs->getStatsPays('Russie',"(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(4|8|9)[0-9]{9}$' OR REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(7|007)[0-9]{10}$')",$anne))
						->union($this->Utilisateurs->getStatsPays('Luxembourg',"(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(352|00352)[0-9]{9}$')",$anne))   
	//                ->union($this->Utilisateurs->getStatsPays('Irlande',"(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(353|00353)[0-9]{9}$')",$anne))
	//                ->union($this->Utilisateurs->getStatsPays('Italie',"(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(00|)39[0-9]{10}$')",$anne))
	//                ->union($this->Utilisateurs->getStatsPays('Suède',"(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(46|0046)[0-9]{9}$')",$anne))
	//                ->union($this->Utilisateurs->getStatsPays('Danemark',"(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(45|0045)[0-9]{8}$')",$anne))
						;
		$this->set('paysStats',$paysStats);
		$this->set('total',$tousLesPays-$francePays->first()->total);
		$this->set('_serialize',['paysStats','total']);
	}
	/**
	 * 
	 */
	public function populationfrancais($anne)
	{
		$this->RequestHandler->renderAs($this, 'json'/*or xml*/);
		$this->loadModel('Utilisateurs');
		$franceStats=$this->Utilisateurs->populationfrancais($anne,false);
		
		$this->set('franceStats',$franceStats);
		$totalFrance= $this->Utilisateurs->populationfrancais($anne,true);
		$this->set('totalFrance',$totalFrance);
		$this->set('_serialize',['franceStats','totalFrance']);
	}
	/**
	 * 
	 */
	public function statPays(){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
	/**
	 * 
	 */
	public function populationparregion($anne)
	{
		$this->RequestHandler->renderAs($this, 'json'/*or xml*/);
		$this->loadModel('Utilisateurs');
		$totalRegion= $this->Utilisateurs->populationregion($anne,true);
		$this->set('totalRegion',$totalRegion);
		$this->set('_serialize','totalRegion');
	}
	/**
	 * 
	 */
	public function populationparzone($anne)
	{
		$this->RequestHandler->renderAs($this, 'json'/*or xml*/);
		$this->loadModel('Utilisateurs');
		$totalZone= $this->Utilisateurs->populationzones($anne,true);
		$this->set('totalZone',$totalZone);
		$this->set('_serialize','totalZone');
	}
	/**
	 * 
	 */
	public function testgetids(){
		$anne=2019;
		$this->RequestHandler->renderAs($this, 'json'/*or xml*/);
		$this->loadModel('Utilisateurs');
		$totalZone= $this->Utilisateurs->populationzones($anne,true);
		dd($totalZone->toArray());
		$this->set('totalZone',$totalZone);
		$this->set('_serialize','totalZone');
	}
	/**
	 * 
	 */
	public function envoyermaildetest(){
		$this->viewBuilder()->layout(false);
		$this->loadModel('Registres');
		$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
		$mail=$mails->first();
		$datamustache = array('nomprop' => 'NOMPROP', 'prenomprop' => 'PRENOMPROP', 'annonce' => 'ANNONCE', 'prenom' => 'PRENOM', 'nom' => 'NOM', 'debut' => 'DEBUT', 'fin' =>'FIN',
		'codereduction'=> 'CODEREDUCTION', 'valeurreduction'=>'VALEURREDUCTION', 'debutreduction'=>'DEBUTREDUCTION', 'finreduction'=>'FINREDUCTION','demande'=>'DEMANDE','email'=>'EMAIL','tel'=>'TEL',
		'message'=>'MESSAGE', 'emailprop'=>'EMAILPROP', 'telephoneprop'=>'TELPROP', 'login'=>"LOGIN", 'password'=>'PASSWORD', 'url'=>"URL",'nbrEnfant'=>'NBRENFANT','nbrAdulte'=>'NBRADULTE',
		'contrat'=>'CONTRAT', 'gestionnaire'=>'GESTIONNAIRE', 'date'=>'DATE','taxe'=>'TAXE','appartement'=>'APPARTEMENT', 'annonceURL'=>'ANNONCEURL','noteGlobale'=>'NOTEGLOBALE','commentaire'=>'COMMENTAIRE');
		// #####################################################
		$event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $this->request->data["email"],'textEmail'=>$this->request->data["titre"],
													'data'=>$datamustache,'template'=>'creationReservation','viewVars'=>'creationReservation','noReply'=>false,null,null,$this->request->data["langue"]
												]);
		$this->eventManager()->dispatch($event);
		// #####################################################
	}
	/**
	 * 
	 */
	function getFormatPhoneNumber($phoneNumber, $international = false){
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
		$returnValueTUNIS = preg_match('#^(216|00216)[0-9]{8}$#', $phoneNumber);
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
		}elseif($returnValueTUNIS == 1){
			//On traite les cas des numéro en tunisie
			$phoneNumber = substr($phoneNumber, -8);
			$motif = $international ? '+216\1\2\3\4\5' : '0\1\2\3\4\5';
			$phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
			return $phoneNumber; 
		}else{
			$phoneNumber = '';
			return $phoneNumber;
		}
	}
	/**
	 * 
	 */
	public function envoyersmsdetest(){
		$this->viewBuilder()->layout(false);
		$datamustache = array('prenom' => 'PRENOM', 'nom' => 'NOM', 'reservation' => 'RESERVATION');
		$sendTo = $this->request->data["email"];
		$num = $this->getFormatPhoneNumber($sendTo,true);
		if($num != ''){
			// #####################################################
			$event = new Event('Email.sendSms', $this, ['from'=>"alpissime",'to' => $sendTo,'textSms'=>$this->request->data["titre"],
			'data'=>$datamustache,$this->request->data["langue"]
			]);
			$this->eventManager()->dispatch($event);
			// #####################################################
			$this->set('msgretour','OK');
		}else{
			$this->set('msgretour','NON');
		}
		
	}
	/**
	 * 
	 */
	public function activermailuser($id){
		$this->viewBuilder()->layout(false);
		$this->autoRender = false;
		$this->loadModel('UtilisateursTokens');
		$user_token=$this->UtilisateursTokens->deleteAll(['user_id'=>$id]);

		$this->loadModel('Utilisateurs');
		$user=$this->Utilisateurs->find()->where(['id'=>$id])->first();
		$user->valide_at=date('Y-m-d');
        $this->Utilisateurs->save($user);
	}
	
}
