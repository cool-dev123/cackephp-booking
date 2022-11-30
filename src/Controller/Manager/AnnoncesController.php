<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Mustache_Engine;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Cake\I18n\Date;
/**
 * Annonces Controller
 *
 * @property \App\Model\Table\AnnoncesTable $Annonces
 */
class AnnoncesController extends AppController
{
	public $helpers = ['AnnonceFormater'];

	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Flash');
		$this->loadComponent('RequestHandler');
		$this->loadModel("Residences");
		$this->loadModel("Utilisateurs");
		$this->loadModel("Dispos");
		$this->loadModel("Villages");
		$this->loadModel("Images");
		$this->loadModel("Photos");
		$this->loadModel("Lieugeos");
		$this->loadModel("Contacts");
  }
	/*
	 *
	 */
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $session = $this->request->session();
        $admin_actions=['pub','addpub','editpub','index','periodeannonces'];
        if(!$session->check("Gestionnaire.info")){
                return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
        $gest=$session->read('Gestionnaire.info');
        if ($gest['G']['role']=="gestionnaire" && in_array($this->request->getParam('action'), $admin_actions)){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
    }
	/*
	 *
	 */
	public function pub($id=null){
		$session = $this->request->session();
		if($session->check("Pub.edit")){
			$this->set('confirm_res',$session->read('Pub.edit'));
			$session->delete("Pub.edit");
		}
		$this->viewBuilder()->layout('manager');
		$this->set('images',$this->Images->find('all'));
		$gest=$session->read('Gestionnaire.info');
		$annonce=$this->Images->find()
								->join([
									'G' => [
									'table' => 'gestionnaires',
									'type' => 'INNER',
									'conditions' => 'G.id = Images.gestionnaire',
									]
								])
								->select(['Images.titre', 'Images.id', 'Images.visible','G.name']);
		$this->set('images',$annonce);
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
  }
	/**
	 *
	 **/
	function addpub(){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
                if($session->check("Vacances.add")){
			$this->set('confirm_res',$session->read('Vacances.add'));
			$session->delete("Vacances.add");
		}
		if($session->check("Vacances.addError")){
			$this->set('error_res',$session->read('Vacances.addError'));
			$session->delete("Vacances.addError");
		}
		if($this->request->data){
                    $prefixe = $_SERVER['DOCUMENT_ROOT'];
                    $destname = "$prefixe/webroot/img/uploads/";
                    $file = $this->request->data['image'];
                    $ext=explode('/',$file['type']);
                    $name=date('YmdHis').".".$ext[1];
                    $imagineJPG = new Imagine();
                    if($ext[1] == "png"){
                      $imageupload = $imagineJPG->open($this->request->data['image']['tmp_name']);
                      $imageupload->save($destname.$name, array('png_compression_level' => 5)); 
                    }else{
                      $imageupload = $imagineJPG->open($this->request->data['image']['tmp_name']);
                      $imageupload->save($destname.$name, array('jpeg_quality' => 85));  
                    }
                    //move_uploaded_file($this->request->data['image']['tmp_name'], $destname.$name);
                    $data=array("image" => $name,
                                            "gestionnaire" => 6,
                                            "titre" => $this->request->data["titre"],
                                            "lien" => $this->request->data["lien"],
                                            "station" => serialize($this->request->data["lieugeo"]),
                                            "visible" => 0);
                    $image = $this->Images->newEntity($data);
                    if ($this->Images->save($image)) {
                            $session->write("Vacances.add","addvacance");
                    }
                    else{
                            $session->write("Vacances.addError","addvacance");
                    }
                    return $this->redirect(['action' => 'addpub']);
		}
		$this->set(compact('enrs'));
	}
	/**
	 *
	 **/
	function editpub($id=null){
            $session = $this->request->session();
            if($session->check("Vacances.add")){
			$this->set('confirm_res',$session->read('Vacances.add'));
			$session->delete("Vacances.add");
		}
		if($session->check("Vacances.addError")){
			$this->set('error_res',$session->read('Vacances.addError'));
			$session->delete("Vacances.addError");
		}
		if($this->request->data){
                    $data=array("titre" => $this->request->data["titre"],
                                            "lien" => $this->request->data["lien"],
                                            "station" => serialize($this->request->data["lieugeo"]));
                    $image = $this->Images->get($id);
                    if(!empty($this->request->data['image']['name'])){
                        $prefixe = $_SERVER['DOCUMENT_ROOT'];
                        $destname = "$prefixe/webroot/img/uploads/";
                        $file = $this->request->data['image'];
                        $ext=explode('/',$file['type']);
                        $name=date('YmdHis').".".$ext[1];
                        $imagineJPG = new Imagine();
                        if($ext[1] == "png"){
                          $imageupload = $imagineJPG->open($this->request->data['image']['tmp_name']);
                          if($imageupload->save($destname.$name, array('png_compression_level' => 5)))
                                  $image['image']=$name; 
                        }else{
                          $imageupload = $imagineJPG->open($this->request->data['image']['tmp_name']);
                          if($imageupload->save($destname.$name, array('jpeg_quality' => 85)))
                                  $image['image']=$name;  
                        }
                        //if(move_uploaded_file($this->request->data['image']['tmp_name'], $destname.$name))
                    }
                    $image = $this->Images->patchEntity($image, $data);
                    if ($this->Images->save($image)) {
                            $session->write("Vacances.add","addvacance");
                    }
                    else{
                            $session->write("Vacances.addError","addvacance");
                    }
                    return $this->redirect(['action' => 'editpub',$id]);
		}
		
		$image = $this->Images->get($id);
		$stat=unserialize($image->station);
		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
		$this->viewBuilder()->layout('manager');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
		$this->set(compact('image','enrs','stat'));
	}
	/**
	 *
	 **/
	function viewpub($id=null){
		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
		$image=$this->Images->get($id);
		$this->set('image',$image);
		$station=unserialize($image->station);
		$v_station="";
		foreach($enrs as $er){
			foreach($station as $v){
				if($er->id==$v){
					$v_station.=",".$er->name." ";
				}
			}
		}
		$this->set('station',$v_station);
	}
	/**
	 *
	 **/
	function deletepub($id=null){
		$session = $this->request->session();
		$annonce = $this->Images->get($id);
		$this->Images->delete($annonce);
		$session->write("Pub.edit",'Vous avez supprimé une publicité.');
    return $this->redirect(['action' => 'pub']);
	}
	/**
	 *
	 **/
	function activerpub($id=null){
		$session = $this->request->session();
		$annonce = $this->Images->get($id);
		$data['visible']=1;
                $annonce = $this->Images->patchEntity($annonce, $data);
		if($this->Images->save($annonce)){
			if($annonce->gestionnaire!=6){
					$this->loadModel("Messages");
					$a_message=array('id_gestionnaire'=>$annonce->gestionnaire,
									  'de'=>6,
									  'sujet'=>"Activation de votre publicité ".$annonce->titre,
									  'message'=>"Bonjour,<br/> L'administrateur à activé votre publicité ".$annonce->titre,
									  "d_create" => Time::now(),
									  "lut" => 0);
					 $message = $this->Messages->newEntity($a_message);
					 $this->Messages->save($message);
			}
			$session->write("Pub.edit",'Vous avez activé votre publicité.');
		}
		$session->write("Pub.edit",'Vous avez activé votre publicité.');
    return $this->redirect(['action' => 'pub']);
	}
	/**
	 *
	 **/
	function blockerpub($id=null){
		$session = $this->request->session();
		$annonce = $this->Images->get($id);
		$data['visible']=0;
                $annonce = $this->Images->patchEntity($annonce, $data);
		if($this->Images->save($annonce)){
			if($annonce->gestionnaire!=6){
					$this->loadModel("Messages");
					$a_message=array('id_gestionnaire'=>$annonce->gestionnaire,
									  'de'=>6,
									  'sujet'=>"Désactivation de votre publicité ".$annonce->titre,
									  'message'=>"Bonjour,<br/> L'administrateur à désactivé votre publicité ".$annonce->titre,
									  "d_create" => Time::now(),
									  "lut" => 0);
					 $message = $this->Messages->newEntity($a_message);
					 $this->Messages->save($message);
			}
			$session->write("Pub.edit",'Vous avez désactivé votre publicité.');
		}
		$session->write("Pub.edit",'Vous avez désactivé votre publicité.');
    return $this->redirect(['action' => 'pub']);
	}
	/**
	 *
	 **/
	function idfilemaker(){
		$annonce = $this->Annonces->get($this->request->data["id"]);
		$data=array('id_filemaker'=>$this->request->data["idfilemaker"]);
    $annonce = $this->Annonces->patchEntity($annonce, $data);
		$this->Annonces->save($annonce);
    echo $this->request->data["id"]."_".$this->request->data["idfilemaker"];
		exit;
	}
	/**
	 *
	 **/
		public function activer(){
		$annonce=$this->Annonces->get($this->request->data["id"], ['contain' => ['Lieugeos','Villages']]);
		if($annonce->contrat==1){
			$data=array('contrat'=>0);
			$annonce = $this->Annonces->patchEntity($annonce, $data);
			$this->Annonces->save($annonce);
			echo "notok";
	  }else{
			$data2=array('contrat'=>1,'date_contrat'=>Time::now());
			$annonce = $this->Annonces->patchEntity($annonce, $data2);
			$this->Annonces->save($annonce);
			$this->loadModel("Contactprops");
			$contacts=$this->Contactprops->find("all",["conditions"=>["id_annonce"=>$this->request->data["id"],"lut"=>0]]);
			$user=$this->Utilisateurs->get($annonce->proprietaire_id);
                        $this->loadModel("Modelmailsysteme");
                        $this->loadModel("Registres");
                        $mail = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]])->first();

			foreach($contacts as $res){
						// Ajout variable {{imageannonce}}
				$photo = $this->Photos->find()->where(['annonce_id' => $annonce->id])->order(['numero ASC'])->first();
				// $nomImg = "vignette-".$photo->annonce_id."-".$photo->numero;

				$natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
				$village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
				$village_nom = str_replace(" – ", "-", $village_nom);
				$village_nom = str_replace(" ", "-", $village_nom);
				$nomImgG = $photo->titre;

				$urlimage1 = 'https://www.alpissime.com/images_ann/'.$annonce->id.'/'.$nomImgG;

				$natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
				$lannonce = $this->string2url($annonce["titre"]);
				$hrefDetailAnn = 'station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;

				$datamustache = array('nomprop' => $user->nom_famille, 'prenomprop' => $user->prenom, 'annonce' => $annonce->id, 'prenom' => $res->prenom, 'nom' => $res->nom, 'email' => $res->email, 'tel' => $res->telephone, 'commentaire' => $res->commentaire, 'demande' => $res->demande, 'imageannonce' => $urlimage1, 'annonceURL' => "https://www.alpissime.com/".$hrefDetailAnn);
  
				// #####################################################
				$event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $user,'textEmail'=>'contactProprietaireContact',
															'data'=>$datamustache,'template'=>'contactProprietaireContact','viewVars'=>'contactProprietaireContact','noReply'=>false
														]);
				$this->eventManager()->dispatch($event);
				// #####################################################
				$contact=$this->Contactprops->get($res->id);
				$a_c=array("lut"=>1);
				$contact = $this->Contactprops->patchEntity($contact, $a_c);
				$this->Contactprops->save($contact);
			}
			echo "ok";
		}
		exit;
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
	public function activateRelation(){
		$annonce=$this->Annonces->get($this->request->data["id"], ['contain' => ['Lieugeos','Villages']]);
		if($annonce->mise_relation==1){
			$data=array('mise_relation'=>0);
			$annonce = $this->Annonces->patchEntity($annonce, $data);
			$this->Annonces->save($annonce);
			echo "notok";
	  }else{
			$data=array('mise_relation'=>1,'date_mise_relation'=>Time::now());
			$annonce = $this->Annonces->patchEntity($annonce, $data);
			$this->Annonces->save($annonce);
			$this->loadModel("Contactprops");
			$contacts=$this->Contactprops->find("all",["conditions"=>["id_annonce"=>$this->request->data["id"],"lut"=>0]]);
			$user=$this->Utilisateurs->get($annonce->proprietaire_id);
                        $this->loadModel("Modelmailsysteme");
			
			foreach($contacts as $res){
                            // Ajout variable {{imageannonce}}
				$photo = $this->Photos->find()->where(['annonce_id' => $annonce->id])->order(['numero ASC'])->first();
				// $nomImg = "vignette-".$photo->annonce_id."-".$photo->numero;

				$natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
				$village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
				$village_nom = str_replace(" – ", "-", $village_nom);
				$village_nom = str_replace(" ", "-", $village_nom);
				$nomImgG = $photo->titre;

				$urlimage1 = 'https://www.alpissime.com/images_ann/'.$annonce->id.'/'.$nomImgG;

				$natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
				$lannonce = $this->string2url($annonce["titre"]);
				$hrefDetailAnn = 'station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;
				
				$datamustache = array('nomprop' => $user->nom_famille, 'prenomprop' => $user->prenom, 'annonce' => $annonce->id, 'prenom' => $res->prenom, 'nom' => $res->nom, 'email' => $res->email, 'tel' => $res->telephone, 'commentaire' => $res->commentaire, 'demande' => $res->demande, 'imageannonce' => $urlimage1, 'annonceURL' => "https://www.alpissime.com/".$hrefDetailAnn); 

				// #####################################################
				$event = new Event('Email.send', $this, ['from'=>[$res->email=>$res->nom_famille." ".$res->prenom],'to' => $user,'textEmail'=>'contactProprietaireContact',
															'data'=>$datamustache,'template'=>'contactProprietaireContact','viewVars'=>'contactProprietaireContact','noReply'=>false
														]);
				$this->eventManager()->dispatch($event);
				// #####################################################
				$contact=$this->Contactprops->get($res->id);
				$a_c=array("lut"=>1);
				$contact = $this->Contactprops->patchEntity($contact, $a_c);
				$this->Contactprops->save($contact);
			}
			echo "ok";
		}
		exit;
  }
	/**
	 *
	 **/
  function index(){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
		if($session->check("Annonce.refuser")){
			$this->set('confirm_refuser','reservation');
			$session->delete("Annonce.refuser");
		}
		if($session->check("Annonce.accepter")){
			$this->set('confirm_accepter','reservation');
			$session->delete("Annonce.accepter");
		}
		$annonce=$this->Annonces->find()
								->join([
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
										'conditions' => 'Annonces.id_gestionnaires=G.id',
									]

								])
				->select(['Lieugeo.name', 'Annonces.justificatif_domicile', 'Annonces.created_at', 'Annonces.updated_at', 'Annonces.nature', 'Annonces.id','Utilisateur.nom_famille', 'Utilisateur.prenom', 'Utilisateur.email', 'Utilisateur.valide_at','G.name'])
				->where(["Annonces.statut"=>0])

				->order(['Annonces.created_at'=>'desc']);
		$a_ann=array();
		$i=0;
		$a_nature=array('STD'=>'Studio','APP'=>'Appartement','CHA'=>'Chalet','VIL'=>'Villa','GIT'=>'Gîte','DIV'=>'Autre');
		$this->set('annonces', $annonce);
    $this->set("l_natures_location",$a_nature);
		$mail = [];
		$this->loadModel("Modelmailsysteme");
		$textEmail = $this->Modelmailsysteme->find('all');
		foreach ($textEmail as $key => $value) {
			$mail[$value->titre] = $value->txtmail;
		}
		$this->set("textmail",$mail);
		$this->loadModel('Gestionnaires');
		$gestionnaire = $this->Gestionnaires->find();
		$this->set("gestionnaire",$gestionnaire);
	}
	/**
	 *
	 **/
	public function periodeannonces(){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
                $this->loadModel("Utilisateurs");
                $props=$this->Utilisateurs->getProprietaires();
                $this->set('props',$props);
	}
        
        public function setProprietaire(){
            $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
            $this->loadModel("Annonces");
            $annonce=$this->Annonces->get($this->request->data['IdAnnonce']);
            $this->Annonces->patchEntity($annonce, ['proprietaire_id'=>$this->request->data['IDprop']]);
            $saved=$this->Annonces->save($annonce);
            $this->set('saved',$saved);
            $this->set('_serialize', 'saved');
        }
	/**
	 *
	 **/
	public function arraysansperiodes(){
		$url=Router::url('/');
		$this->loadModel('Reservations');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		if($this->request->query['from'] == '' && $this->request->query['to'] == ''){
			$anndetail = $this->Annonces->detailsannonce($url,$this->request->query);
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
			$anndetail = $this->Annonces->detailsannoncedates($url,$this->request->query,$dbt, $fin);
		}
		echo json_encode( $anndetail );
		die();
	}
	/**
	 *
	 **/
	function accepter($id=null){
            $this->viewBuilder()->layout(false);
		$session = $this->request->session();
		$annonce = $this->Annonces->get($id);
		$data=array('statut'=>50,'updated_at'=>Time::now());
		$annonce = $this->Annonces->patchEntity($annonce, $data);
		if ($this->Annonces->save($annonce)) {
			$this->loadModel("Gestionnaires");
			$objgest=$this->Gestionnaires->find()
								->join([
									'Annonces' => [
										'table' => 'annonces',
										'type' => 'INNER',
										'conditions' => 'Gestionnaires.id = Annonces.id_gestionnaires',
										]
								])
					->select(['Gestionnaires.email', 'Gestionnaires.email'])
					->where(["Annonces.id"=>$id]);

			$this->loadModel("Registres");
			$this->loadModel("Utilisateurs");
			$this->loadModel("Lieugeos");

			$lieugeo=$this->Lieugeos->get($annonce->lieugeo_id);
			$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
			$utilisateur=$this->Utilisateurs->get($annonce->proprietaire_id);
                        
                        $gest = $objgest->first();
                        $datamustache = array('gestionnaire' => $gest['G']['name'], 'nomprop' => $utilisateur->nom_famille, 'prenomprop' => $utilisateur->prenom, 'annonce' => $annonce->id, 'station' => $lieugeo->name, 'appartement' => $annonce->num_app);
                        
			$mail=$mails->first();
                        // #####################################################
                        $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $utilisateur,'textEmail'=>'annonceAccepter',
                                                                 'data'=>$datamustache,'template'=>'annonceAccepter','viewVars'=>'annonceAccepter','noReply'=>false
                                                                ]);
                        $this->eventManager()->dispatch($event);
                        // #####################################################
			
			if($objgest->first()){
				$g=$objgest->first();
                                // #####################################################
                                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $g,'textEmail'=>'annonceAccepterAdmin',
                                                                         'data'=>$datamustache,'template'=>'acceptationAnnonceAdmin','viewVars'=>'acceptationAnnonceAdmin','noReply'=>false
                                                                        ]);
                                $this->eventManager()->dispatch($event);
                                // #####################################################
			}
			$session->write("Annonce.accepter","accepter");
		}
                $this->set("msg","OK");
		//return $this->redirect(['action' => 'index']);
	}
	/**
	 *
	 **/
	function refuser($id=null){
		$session = $this->request->session();
		$annonce = $this->Annonces->get($id);
		$data=array('statut'=>10,'updated_at'=>Time::now());
		$annonce = $this->Annonces->patchEntity($annonce, $data);
		if ($this->Annonces->save($annonce)) {
			$this->loadModel("Registres");
			$this->loadModel("Utilisateurs");
			$this->loadModel("Lieugeos");
			$session = $this->request->session();
        	$gest=$session->read('Gestionnaire.info');
			$lieugeo=$this->Lieugeos->get($annonce->lieugeo_id);
			$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
			$utilisateur=$this->Utilisateurs->get($annonce->proprietaire_id);
                        
          	$datamustache = array('nomprop' => $utilisateur->nom_famille, 'prenomprop' => $utilisateur->prenom, 'annonce' => $annonce->id, 'station' => $lieugeo->name, 'gestionnaire' => $gest['G']['name']);
                        
			$mail=$mails->first();
			// #####################################################
			$event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $utilisateur,'textEmail'=>'annonceRejetee',
														'data'=>$datamustache,'template'=>'annonceRejetee','viewVars'=>'annonceRejetee','noReply'=>false
													]);
			$this->eventManager()->dispatch($event);
			// #####################################################
			
			$session->write("Annonce.refuser","refuser");
		}
		return $this->redirect(['action' => 'index']);
	}
	/**
	 *
	 **/
	public function liste(){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
	/**
	 *
	 **/
	public function paginateannonce(){
			$url=Router::url('/');
      $annonces = $this->Annonces->get_array_annonce($url,$this->request->query);
      echo json_encode( $annonces );die();
	}
	/**
	 *
	 **/
	public function attribuergestionnaire($id = null){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel('Gestionnaires');
		$annonce=$this->Annonces->find()->contain('Villages')
					// ->select(['Lieugeo.name', 'Annonces.created_at', 'Annonces.nature', 'Annonces.id'])
					->where(['Annonces.id'=>$id]);
		$this->set("annonce",$annonce->first());
		$village_id=$annonce->first()->village->id;
		$gestionnaire = $this->Gestionnaires->find()->join([
			'GV' => [
				'table' => 'gestionnaires_villages',
				'type' => 'inner',
				'conditions' => ['Gestionnaires.id=GV.gestionnaire_id','GV.villages_id'=>$village_id]
			]
		]);
		$this->set("gestionnaire",$gestionnaire);
	}
	/**
	 *
	 **/
	public function modifierclegest($id = null){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel('Annonces');
		$clepos = $this->Annonces->get($id);
		$this->set("clepos",$clepos);
		$this->set("cleid", $id);
	}
	/**
	 *
	 **/
	public function popupattribgest($id = null){
		$this->viewBuilder()->layout('ajax');
		$annoncegestann=$this->Annonces->find()
								->join([
									'Lieugeo' => [
										'table' => 'lieugeos',
										'type' => 'inner',
										'conditions' => 'Lieugeo.id=Annonces.lieugeo_id',
									]
								])
					->select(['Lieugeo.name', 'Annonces.id'])
					->where(['Annonces.id'=>$id]);
		echo json_encode( $annoncegestann->first() );die();
	}
	/**
	 *
	 **/
	public function modifiergestioncle(){
		$this->loadModel('Annonces');
		if( $this->request->data['vCle'] == ""){
			$pos = 0;
		}else{
			$pos = $this->request->data['vCle'];
		}
		$data=array("position_cle" => $pos);
		$anncle = $this->Annonces->get($this->request->data['vIdAnn']);
		$ann = $this->Annonces->patchEntity($anncle, $data);
                $this->Annonces->save($ann);
		die();
	}
	/**
	 *
	 **/
	public function modifiergest(){
		$this->loadModel('Annonces');
		if( $this->request->data['vCle'] == ""){
			$pos = 0;
		}else{
                            $pos = $this->request->data['vCle'];
		}
		$relation = $this->Annonces->find()->where(["id = ".$this->request->data['vIdAnnonce']]);
		
		$data=array("id_gestionnaires" => $this->request->data['vIdGest'],
						"position_cle" => $pos,
						"visible" => 1);
		$annoncegestionnaire = $this->Annonces->patchEntity($relation->first(), $data);
		$this->Annonces->save($annoncegestionnaire);
				
		die();
	}
	/**
	 *
	 **/
	public function modifiergestpopup(){
		$this->loadModel('Annonces');
		$this->loadModel('Gestionnaires');
		if( $this->request->data['vCle'] == ""){
			$pos = 0;
		}else{
			$pos = $this->request->data['vCle'];
		}
		$data=array("id_gestionnaires" => $this->request->data['vIdGest'],
				"position_cle" => $pos,
				"visible" => 1);
		$relation = $this->Annonces->find()->where(["id = ".$this->request->data['vIdAnnonce']]);
		$annoncegestionnaire = $this->Annonces->patchEntity($relation->first(), $data);
    	$this->Annonces->save($annoncegestionnaire);
		$gestid = $this->Gestionnaires->get($this->request->data['vIdGest']);
		echo $gestid->name;die();
	}
	/**
	 * 
	 */
	public function reservationsannulees()
	{
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
		$this->loadModel("Utilisateurs");
		$props=$this->Utilisateurs->getProprietaires();
		$this->set('props',$props);

		// Liste des demandes annulation réservation
		$this->loadModel("AnnulationReservations");
		$listeAnnulReserv = $this->AnnulationReservations->find('all')->contain(['Reservations'=>['Utilisateurs']])->where(['Reservations.type = 0']);
		$this->set('listeAnnulReserv',$listeAnnulReserv);
	}
	/**
	 * 
	 */
	public function payerannulationreservation()
	{
		$this->viewBuilder()->layout(false);
		$this->loadModel("AnnulationReservations");
		$annulation = $this->AnnulationReservations->get($this->request->data['annulationID']);
		$annulation->payer = 1;
		$data = array("payer" => 1);
		$AnnulationReservations = $this->AnnulationReservations->patchEntity($annulation, $data);
		$this->AnnulationReservations->save($AnnulationReservations);
		$this->set("msg", "OK");
	}
	/**
	 * 
	 */
	public function virementsreservations()
	{
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
		$this->loadModel("Utilisateurs");
		$props=$this->Utilisateurs->getProprietaires();
		$this->set('props',$props);

		
	}
	/**
	 * 
	 */
	public function listevirementreservation()
	{
		$wheretab = [];
		if(isset($this->request->query['paye']) && isset($this->request->query['enattente'])){
			// on ne fait rien de spécial
		}else if(isset($this->request->query['paye'])){
			$wheretab[] = "(Reservations.date_virement IS NOT NULL OR DATE_ADD(Reservations.dbt_at , INTERVAL 2 DAY) < CURDATE())";
		}else if(isset($this->request->query['enattente'])){
			$wheretab[] = "(Reservations.date_virement IS NULL";
			$wheretab[] = "DATE_ADD(Reservations.dbt_at , INTERVAL 2 DAY) >= CURDATE())";
		}
		if($this->request->query['from'] != ""){
			$bdtfrom = Time::parse($this->request->query['from']);
			$wheretab[] = 'Reservations.dbt_at = "'.$bdtfrom->i18nFormat('yyyy-MM-dd').'"';
		} 

		// Liste reservations
		$this->loadModel("Reservations");
		$wheretab[] = 'YEAR(Reservations.dbt_at) >= "2018"';
		// $listeVirement = $this->Reservations->getSumReservationsXML(["Reservations.statut = 90", "Reservations.type = 0"]);
        $listeVirement = $this->Reservations->find()->where(["Reservations.statut = 90", "Reservations.type = 0"])
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
        // $listeVirement->select(['Reservations.id','Reservations.date_virement','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','utilisateur.prenom','utilisateur.nom_famille','total'=>$listeVirement->func()->sum('IF (Reservations.prixreservation=0, IF (dispo.promo_yn=0 , dispo.prix , dispo.promo_px), Reservations.prixreservation)')])
        $listeVirement->select(['Reservations.id','Reservations.date_virement','Reservations.annonce_id','Reservations.utilisateur_id','Reservations.dbt_at','Reservations.fin_at','utilisateur.id','utilisateur.prenom','utilisateur.nom_famille','Reservations.prixreservation','dispo.promo_yn' , 'dispo.prix' , 'dispo.promo_px']);
        if(!empty($wheretab)) $listeVirement->where($wheretab);
		$listeVirement->order(['Reservations.dbt_at'=>'desc']);

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
		foreach ($listeVirement as $value) {
			$infoprop = $this->Utilisateurs->get($value['utilisateur']['id'], ['contain'=>['Cautions', 'Paiements', 'Annulations']]);
			if($infoprop->nature == "PRES" && !empty($infoprop->paiements) && $infoprop->paiements[0]->taux_commission != 0) $tauxcommession = $infoprop->paiements[0]->taux_commission;
			else $tauxcommession = 3;

			$now   = $value->dbt_at;
			$clone = clone $now;
			$tet = $clone->modify( '+2 day' );

			if($value->date_virement == NULL && new Date() <= new Date($tet->format( 'd-m-Y' ))){
				$row[0] = "<div class=\"checkbox\">"
					."<input type=\"checkbox\" name='listeres[]' id='reservation_".$value->id."' value='".$value->id."' >"
					."<label></label>"
				."</div>";
			}else{
				$row[0] = "";
			}			
			$row[1] = $value->id;
			$row[2] = $value->dbt_at->i18nFormat('dd/MM/yyyy')." - ".$value->fin_at->i18nFormat('dd/MM/yyyy');
			$infolocataire = $this->Utilisateurs->find()->where(["id" => $value->utilisateur_id]);
			if($infolocataire = $infolocataire->first()) $row[3] = $infolocataire->prenom." ".$infolocataire->nom_famille;
			else $row[3] = "";
			$row[4] = $value->annonce_id;
			$row[5] = $value['utilisateur']['prenom']." ".$value['utilisateur']['nom_famille'];
			$row[6] = round(($prixtab[$value->id]-($prixtab[$value->id]*$tauxcommession/100)), 2)." €";

			if($value->date_virement != NULL){
				$row[7] = "<span class='text-success'>Payé le ".$value->date_virement->i18nFormat('dd-MM-yyyy')."</span>";
			}else{
				// $row[7] = new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'))."***".$tet."***".new Date($tet->format( 'd-m-Y' ))."***".new Date();
				if(new Date() > new Date($tet->format( 'd-m-Y' ))) $row[7] = "<span class='text-success'>Payé</span>";
				if(new Date() >= new Date($value->dbt_at->i18nFormat('dd-MM-yyyy')) && new Date() <= new Date($tet->format( 'd-m-Y' ))) $row[7] = "<span class='text-danger'>En attente</span>";
				if(new Date() < new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'))) $row[7] = "<span class='text-danger'>En attente</span>";
			}
			

			$output['data'][] = $row;
		}
		echo json_encode( $output );die();
	}
	/**
	 * 
	 */
	public function validervirementreservation()
	{
		$this->viewBuilder()->layout(false);
		$this->loadModel("Reservations");
		$today = Time::now();
		$i = 0;
		foreach ($this->request->data['listevirement'] as $value) {
			$reservation = $this->Reservations->get($value);
			// Enregistrer date_virement danst reservations
			$data = array('date_virement' => $today);
			$newReservation = $this->Reservations->patchEntity($reservation, $data);
			if($this->Reservations->save($newReservation)) $i++;
		}
		if($i > 0) $this->set('msg','OK');
	}
	/**
	 * 
	 */
	public function detaildemandeannulationreservation()
	{
		$this->viewBuilder()->layout(false);
		// Détail demande annulation réservation
		$this->loadModel("AnnulationReservations");
		$detailAnnulReserv = $this->AnnulationReservations->get($this->request->data['demandeID'], [
			'contain' => ['Reservations']
		]);
		$detailAnnulReserv['reservation']['dbt_at'] = $detailAnnulReserv['reservation']['dbt_at']->i18nFormat("dd-MM-YYYY");
		$this->set('detailAnnulReserv',$detailAnnulReserv);
	}
	/**
	 * 
	 */
	public function refusdemandeannulationreservation()
	{
		$this->viewBuilder()->layout(false);
		// Envoie montant remboursement vers la boutique
		// print_r($this->request->data['prixremboursement']);
		// Changer etat + montant à rembourser
		$this->loadModel("AnnulationReservations");
		$annulation = $this->AnnulationReservations->get($this->request->data['idDemande'], [
			'contain' => ['Reservations']
		]);
		$this->loadModel("Annonces");
		$annnce = $this->Annonces->get($annulation['reservation']['annonce_id']);
		$this->loadModel("Utilisateurs");
		$proprietaire = $this->Utilisateurs->get($annnce->proprietaire_id);
		$locataire = $this->Utilisateurs->get($annulation['reservation']['utilisateur_id']);

		$dataannulation = array("statut"=>"Justificatif refusé", "montant_rembourser"=>$this->request->data['prixremboursement']);
		$AnnulationReservations = $this->AnnulationReservations->patchEntity($annulation, $dataannulation);
		$this->AnnulationReservations->save($AnnulationReservations);
		// Envoie mail vers locataire
		/*** Paramètre mail ***/
		$this->loadModel("Registres");
		$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
		$mail=$mails->first();
		$datamustache = array('nom' => $locataire->nom_famille, 'prenom' => $locataire->prenom, 'montant' =>$this->request->data['prixremboursement']);		
		$montant = $this->request->data["inputMontantProp"];
		$datamustacheprop = array('prenom' => $locataire->prenom, 'nom' => $locataire->nom_famille, 'annonce' => $annulation['reservation']['annonce_id'], 'prenomprop' => $proprietaire->prenom, 'nomprop' => $proprietaire->nom_famille, 'datedebut'=>$annulation['reservation']['dbt_at'], 'datefin'=>$annulation['reservation']['fin_at'], 'montant' => $montant);		
		#####################################################
		$event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $proprietaire,'textEmail'=>$this->request->data["inputMailSansJustification"],
													'data'=>$datamustacheprop,'template'=>'supressionReservationLoc','viewVars'=>'supressionReservationLoc','noReply'=>false
												]);
		$this->eventManager()->dispatch($event);
		#####################################################
		$event = new Event('Email.send', $this, ['from'=>$mail->val,'to' => $locataire->email,'textEmail'=>'refusjustificatif',
													'data'=>$datamustache,'template'=>'supressionReservationLoc','viewVars'=>'supressionReservationLoc','noReply'=>false
												]);
		$this->eventManager()->dispatch($event);
		#####################################################
	}
	/**
	 * 
	 */
	public function acceptationdemandeannulationreservation()
	{
		$this->viewBuilder()->layout(false);
		// Envoie remboursement TOTAL vers la boutique
		// Changer etat
		$this->loadModel("AnnulationReservations");
		$annulation = $this->AnnulationReservations->get($this->request->data['idDemande'], [
			'contain' => ['Reservations']
		]);
		$this->loadModel("Annonces");
		$annnce = $this->Annonces->get($annulation['reservation']['annonce_id']);
		$this->loadModel("Utilisateurs");
		$proprietaire = $this->Utilisateurs->get($annnce->proprietaire_id);
		$locataire = $this->Utilisateurs->get($annulation['reservation']['utilisateur_id']);
		$dataannulation = array("statut"=>"Annulation validée", "montant_rembourser"=>$annulation['reservation']['prixapayer']);
		$AnnulationReservations = $this->AnnulationReservations->patchEntity($annulation, $dataannulation);
		$this->AnnulationReservations->save($AnnulationReservations);
		// Envoie mail vers locataire
		/*** Paramètre mail ***/
		$this->loadModel("Registres");
		$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
		$mail=$mails->first();
		$datamustache = array('prenom' => $locataire->prenom, 'nom' => $locataire->nom_famille, 'prenomprop' => $proprietaire->prenom, 'nomprop' => $proprietaire->nom_famille, 'annonce' => $annulation['reservation']['annonce_id'], 'datedebut'=>$annulation['reservation']['dbt_at'], 'datefin'=>$annulation['reservation']['fin_at']);					
		#####################################################
		$event = new Event('Email.send', $this, ['from'=>$mail->val,'to' => $locataire->email,'textEmail'=>'acceptationjustificatif',
													'data'=>$datamustache,'template'=>'supressionReservationLoc','viewVars'=>'supressionReservationLoc','noReply'=>false
												]);
		$this->eventManager()->dispatch($event);
		#####################################################
		$event = new Event('Email.send', $this, ['from'=>$mail->val,'to' => $proprietaire->email,'textEmail'=>'AnnulationJustifProp',
													'data'=>$datamustache,'template'=>'supressionReservationLoc','viewVars'=>'supressionReservationLoc','noReply'=>false
												]);
		$this->eventManager()->dispatch($event);
		#####################################################
	}
	/**
	 * 
	 */
	public function stationlanguage()
	{
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
	/**
	 * 
	 */
	public function allstationsmultilingue()
	{
		$this->RequestHandler->renderAs($this, 'json'/*or xml*/);
		$idGest=null;
		if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
			$idGest=$this->request->session()->read("Gestionnaire.info")['G']['id'];
		
		$stations = $this->Lieugeos->getAllLieugeos($idGest);
		$this->loadModel("Languages");
		$languages = $this->Languages->find("all")->where(['code <> "fr_FR"']);
		$data=[];
		$url=Router::url('/',true).'manager/annonces/editstationlang/';
		foreach($stations->toarray() as $station){
			$row=[0=>$station->name];
			$row[1]=$station['Massif']['nom'];
			if($station->etat == 0) $row[2]="<span class='label label-danger'>Non</span>";
			else $row[2]="<span class='label label-success'>Oui</span>";
			if($station->from_api == 0) $row[3]="<span class='text-danger'>Non</span>";
			else $row[3]="<span class='text-success'>Oui</span>";
			$row[4]="";
			foreach ($languages as $language) {
				$LieugeoTranslate = $this->Lieugeos->find('translations', ['locales' => [$language->code]])->where(['Lieugeos.id' => $station->id])->first();
				$countnbr = 0;
				if($LieugeoTranslate->_translations[$language->code]){
					foreach (($LieugeoTranslate->_translations[$language->code])->toArray() as $key => $value) {
						if(in_array($key, ['descreption', 'sous_description', 'description_api', 'description_acc', 'preposition_a', 'article_de']) && $value != "" && $value != $language->code) $countnbr++;
					}
				}
				$pourcentage = round($countnbr*100/6, 0);
				$row[4] .= $language->name.' : <div class="progress">
				<div class="progress-bar" role="progressbar" style="width: '.$pourcentage.'%;" aria-valuenow="'.$pourcentage.'" aria-valuemin="0" aria-valuemax="100">'.$countnbr.'/6</div>
			  </div>';
			}
			$row[5]='<div class="dropdown">
						<a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-default btn-sm" data-target="#" href="#">
							Modifier <span class="caret ml-5"></span>
						</a>
						<ul class="dropdown-menu multi-level btn-sm" role="menu" aria-labelledby="dropdownMenu">';
						foreach ($languages as $lang) {
							$row[5] .= '<li><a href="'.$url.$station->id.'/'.$lang->code.'">'.$lang->name.'</a></li>';
						}
						$row[5] .= '</ul>
					</div>';
			$data[]=$row;
		}
		echo json_encode(['data'=>$data]);die();
	}
	/**
	 * 
	 */
	public function editstationlang($id, $lang=null)
	{
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));

		$Lieugeo = $this->Lieugeos->find('translations')->where(['Lieugeos.id' => $id])->first();
		// $Lieugeo = $this->Lieugeos->get($id);
		$this->loadModel("Languages");
		$language = $this->Languages->find("all")->where(['code' => $lang])->first();
		$this->set('language',$language);

		if ($this->request->is(['patch', 'post', 'put'])){
			// Update valeur par defaut fr
			$dataFr = array(
				'preposition_a' => $this->request->data['preposition_a'],
				'article_de' => $this->request->data['article_de'],
				'descreption' => $this->request->data['descreption'],
				'sous_description' => $this->request->data['sous_description'],
				'description_acc' => $this->request->data['description_acc'],
				'description_api' => $this->request->data['description_api']
			);
			$Lieugeo = $this->Lieugeos->patchEntity($Lieugeo, $dataFr);
			$this->Lieugeos->save($Lieugeo);
			// Enregistrer En_US version
			$translations = [
				$language->code => [
					'preposition_a' => $this->request->data['preposition_a_en'],
					'article_de' => $this->request->data['article_de_en'],
					'descreption' => $this->request->data['descreption_en'],
					'sous_description' => $this->request->data['sous_description_en'],
					'description_acc' => $this->request->data['description_acc_en'],
					'description_api' => $this->request->data['description_api_en']
				]
			];			
			foreach ($translations as $lang => $data) {
				$Lieugeo->translation($lang)->set($data, ['guard' => false]);
			}			
			$this->Lieugeos->save($Lieugeo);			
		}

		$this->set(compact('Lieugeo'));
	}
	/**
	 * 
	 */
	public function massiflanguage()
	{
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
	/**
	 * 
	 */
	public function allmassifsmultilingue()
	{
		$this->RequestHandler->renderAs($this, 'json'/*or xml*/);
		$idGest=null;
		if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
			$idGest=$this->request->session()->read("Gestionnaire.info")['G']['id'];
		
		$this->loadModel("Massif");
		$massifs = $this->Massif->find()->order('nom');
		$this->loadModel("Languages");
		$languages = $this->Languages->find("all")->where(['code <> "fr_FR"']);
		$data=[];
		$url=Router::url('/',true).'manager/annonces/editmassiflang/';
		foreach($massifs->toarray() as $massif){
			$row=[0=>$massif->nom];
			if($massif->from_api == 0) $row[1]="<span class='text-danger'>Non</span>";
			else $row[1]="<span class='text-success'>Oui</span>";
			$row[2]="";
			foreach ($languages as $language) {
				$MassifTranslate = $this->Massif->find('translations', ['locales' => [$language->code]])->where(['Massif.id' => $massif->id])->first();
				$countnbr = 0;
				if($MassifTranslate->_translations[$language->code]){
					foreach (($MassifTranslate->_translations[$language->code])->toArray() as $key => $value) {
						if(in_array($key, ['descreption','nom_url']) && $value != "" && $value != $language->code) $countnbr++;
					}
				}
				$pourcentage = round($countnbr*100/2, 0);
				$row[2] .= $language->name.' : <div class="progress">
				<div class="progress-bar" role="progressbar" style="width: '.$pourcentage.'%;" aria-valuenow="'.$pourcentage.'" aria-valuemin="0" aria-valuemax="100">'.$countnbr.'/2</div>
			</div>';
			}
			$row[3]='<div class="dropdown">
						<a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-default btn-sm" data-target="#" href="#">
							Modifier <span class="caret ml-5"></span>
						</a>
						<ul class="dropdown-menu multi-level btn-sm" role="menu" aria-labelledby="dropdownMenu">';
						foreach ($languages as $lang) {
							$row[3] .= '<li><a href="'.$url.$massif->id.'/'.$lang->code.'">'.$lang->name.'</a></li>';
						}
						$row[3] .= '</ul>
					</div>';
			$data[]=$row;
		}
		echo json_encode(['data'=>$data]);die();
	}
	/**
	 * 
	 */
	public function editmassiflang($id, $lang=null)
	{
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));

		$this->loadModel("Massif");
		$Massif = $this->Massif->find('translations')->where(['Massif.id' => $id])->first();
		$this->loadModel("Languages");
		$language = $this->Languages->find("all")->where(['code' => $lang])->first();
		$this->set('language',$language);

		if ($this->request->is(['patch', 'post', 'put'])){
			// Update valeur par defaut fr
			$dataFr = array(
				'descreption' => $this->request->data['descreption'],
				'nom_url' => $this->request->data['nom_url'],
			);
			$Massif = $this->Massif->patchEntity($Massif, $dataFr);
			$this->Massif->save($Massif);
			// Enregistrer En_US version
			$translations = [
				$language->code => [
					'descreption' => $this->request->data['descreption_en'],
					'nom_url' => $this->request->data['nom_url_en'],
				]
			];			
			foreach ($translations as $lang => $data) {
				$Massif->translation($lang)->set($data, ['guard' => false]);
			}			
			$this->Massif->save($Massif);
			// Ajout ou Modif dans Urlmultilingue
			$this->loadModel("Urlmultilingue"); 
			$Urlmultilingue = $this->Urlmultilingue->find('translations')->where(['name_key' => $this->request->data['nom_url']]);
			if($Urlmultilingue->first()){
				$Urlmultilingue = $Urlmultilingue->first();
			}else{
				$dataddurl = array(
					'name_value' => $this->request->data['nom_url'],
					'name_key' => $this->request->data['nom_url'],
				);
				$Urlmultilinguenew = $this->Urlmultilingue->newEntity($dataddurl);				
                $Urlmultilingue = $this->Urlmultilingue->save($Urlmultilinguenew);				
			}
			// Enregistrer En_US version
			$translationsUrl = [
				$language->code => [
					'name_value' => $this->request->data['nom_url_en'],
				],
				"fr_FR" => [
					'name_value' => $this->request->data['nom_url'],
				]
			];			
			foreach ($translationsUrl as $lang => $data) {
				$Urlmultilingue->translation($lang)->set($data, ['guard' => false]);
			}			
			$this->Urlmultilingue->save($Urlmultilingue);
		}

		$this->set(compact('Massif'));
	}
	/**
	 * 
	 */
	public function medialanguage()
	{
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
	/**
	 * 
	 */
	public function allmediamultilingue()
	{
		$this->RequestHandler->renderAs($this, 'json'/*or xml*/);
		$idGest=null;
		if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
			$idGest=$this->request->session()->read("Gestionnaire.info")['G']['id'];
		
		$this->loadModel("Media");
		$medias = $this->Media->find("all");
		$this->loadModel("Languages");
		$languages = $this->Languages->find("all")->where(['code <> "fr_FR"']);
		$data=[];
		$url=Router::url('/',true).'manager/annonces/editmedialang/';
		foreach($medias->toarray() as $media){
			$row=[0=>$media->name_key];
			$row[1]="";
			foreach ($languages as $language) {
				$MediaTranslate = $this->Media->find('translations', ['locales' => [$language->code]])->where(['Media.id' => $media->id])->first();
				$countnbr = 0;
				if($MediaTranslate->_translations[$language->code]){
					foreach (($MediaTranslate->_translations[$language->code])->toArray() as $key => $value) {
						if(in_array($key, ['title_ete','title_hiver','lien_ete','lien_hiver']) && $value != "" && $value != $language->code) $countnbr++;
					}
				}
				if($media->title_hiver == "--") $totalpourcent = 2;
				else $totalpourcent = 4;
				$pourcentage = round($countnbr*100/$totalpourcent, 0);
				$row[1] .= $language->name.' : <div class="progress">
				<div class="progress-bar" role="progressbar" style="width: '.$pourcentage.'%;" aria-valuenow="'.$pourcentage.'" aria-valuemin="0" aria-valuemax="100">'.$countnbr.'/'.$totalpourcent.'</div>
				</div>';
			}
			$row[2]='<div class="dropdown">
						<a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-default btn-sm" data-target="#" href="#">
							Modifier <span class="caret ml-5"></span>
						</a>
						<ul class="dropdown-menu multi-level btn-sm" role="menu" aria-labelledby="dropdownMenu">';
						foreach ($languages as $lang) {
							$row[2] .= '<li><a href="'.$url.$media->id.'/'.$lang->code.'">'.$lang->name.'</a></li>';
						}
						$row[2] .= '</ul>
					</div>';
			$data[]=$row;
		}
		echo json_encode(['data'=>$data]);die();
	}
	/**
	 * 
	 */
	public function editmedialang($id, $lang=null)
	{
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));

		$this->loadModel("Media");
		$Media = $this->Media->find('translations')->where(['Media.id' => $id])->first();
		$this->loadModel("Languages");
		$language = $this->Languages->find("all")->where(['code' => $lang])->first();
		$this->set('language',$language);

		if ($this->request->is(['patch', 'post', 'put'])){  
			$data = array();
			// Update valeur par defaut fr
			if(isset($this->request->data['title_hiver'])){
				$dataFr = array(
					'title_ete' => $this->request->data['title_ete'],
					'title_hiver' => $this->request->data['title_hiver'],
				);
			}else{
				$dataFr = array(
					'title_ete' => $this->request->data['title_ete'],
				);
			}			
			$Media = $this->Media->patchEntity($Media, $dataFr);
			$this->Media->save($Media);
			// Enregistrer En_US version
			if(isset($this->request->data['title_hiver_en'])){
				$translations = [
					$language->code => [
						'title_ete' => $this->request->data['title_ete_en'],
						'title_hiver' => $this->request->data['title_hiver_en'],
					]
				];
			}else{
				$translations = [
					$language->code => [
						'title_ete' => $this->request->data['title_ete_en'],
					]
				];
			}						
			foreach ($translations as $lang => $data) {
				$Media->translation($lang)->set($data, ['guard' => false]);
			}			
			$this->Media->save($Media);
            if($this->request->getData('lien_ete')['name']!=''){
                // $prefixe = $_SERVER['DOCUMENT_ROOT'];
                $prefixe = "./";
                $oldImagePath = "$prefixe/webroot/".$Media->lien_ete.".png";
                $oldImagePathWebp = "$prefixe/webroot/".$Media->lien_ete.".webp";
                //image
                $file = $this->request->data['lien_ete'];
                $ext=explode('/',$file['type']);
                $name="images/media/".$Media->name_key.'_ete';
                $imagineJPG = new Imagine();
				unlink($oldImagePath);
				unlink($oldImagePathWebp);
				$imageupload = $imagineJPG->open($this->request->data['lien_ete']['tmp_name']);
				if($Media->name_key == "header_bloc_information" || $Media->name_key == 'logo_alpissime' || $Media->name_key == 'paiement_securise_desktop' || $Media->name_key == 'paiement_securise_mobile'){
					$imageupload->save($prefixe.$name.".png", array('png_compression_level' => 5))
								->save($prefixe.$name.".webp", array('webp_quality' => 85));
				}else{
					$imageupload->save($prefixe.$name.".jpg", array('jpeg_quality' => 85))
								->save($prefixe.$name.".webp", array('webp_quality' => 85));
				}
				
            }
			if($this->request->getData('lien_ete_en')['name']!=''){
                // $prefixe = $_SERVER['DOCUMENT_ROOT'];
                $prefixe = "./";
                $oldImagePath = "$prefixe/webroot/".$Media->lien_ete."_".$language->url_code.".png";
                $oldImagePathWebp = "$prefixe/webroot/".$Media->lien_ete."_".$language->url_code.".webp";
                //image
                $file = $this->request->data['lien_ete_en'];
                $ext=explode('/',$file['type']);
                $name="images/media/".$Media->name_key."_ete_".$language->url_code;
                $imagineJPG = new Imagine();
				unlink($oldImagePath);
				unlink($oldImagePathWebp);
				$imageupload = $imagineJPG->open($this->request->data['lien_ete_en']['tmp_name']);
				if($Media->name_key == "header_bloc_information" || $Media->name_key == 'logo_alpissime' || $Media->name_key == 'paiement_securise_desktop' || $Media->name_key == 'paiement_securise_mobile'){
					$imageupload->save($prefixe.$name.".png", array('png_compression_level' => 5))
								->save($prefixe.$name.".webp", array('webp_quality' => 85));
				}else{
					$imageupload->save($prefixe.$name.".jpg", array('jpeg_quality' => 85))
							->save($prefixe.$name.".webp", array('webp_quality' => 85));
				}			
				// Enregistrer En_US version
				$translations = [
					$language->code => [
						'lien_ete' => $name,
					]
				];			
				foreach ($translations as $lang => $data) {
					$Media->translation($lang)->set($data, ['guard' => false]);
				}			
				$this->Media->save($Media);
			}

			if($this->request->getData('lien_hiver')['name']!=''){
                // $prefixe = $_SERVER['DOCUMENT_ROOT'];
                $prefixe = "./";
                $oldImagePath = "$prefixe/webroot/".$Media->lien_hiver.".png";
                $oldImagePathWebp = "$prefixe/webroot/".$Media->lien_hiver.".webp";
                //image
                $file = $this->request->data['lien_hiver'];
                $ext=explode('/',$file['type']);
                $name="images/media/".$Media->name_key.'_hiver';
                $imagineJPG = new Imagine();
				unlink($oldImagePath);
				unlink($oldImagePathWebp);
				$imageupload = $imagineJPG->open($this->request->data['lien_hiver']['tmp_name']);
				if($Media->name_key == "header_bloc_information" || $Media->name_key == 'logo_alpissime' || $Media->name_key == 'paiement_securise_desktop' || $Media->name_key == 'paiement_securise_mobile'){
					$imageupload->save($prefixe.$name.".png", array('png_compression_level' => 5))
								->save($prefixe.$name.".webp", array('webp_quality' => 85));
				}else{
					$imageupload->save($prefixe.$name.".jpg", array('jpeg_quality' => 85))
							->save($prefixe.$name.".webp", array('webp_quality' => 85));
				}			
            }
			if($this->request->getData('lien_hiver_en')['name']!=''){
                // $prefixe = $_SERVER['DOCUMENT_ROOT'];
                $prefixe = "./";
                $oldImagePath = "$prefixe/webroot/".$Media->lien_hiver."_".$language->url_code.".png";
                $oldImagePathWebp = "$prefixe/webroot/".$Media->lien_hiver."_".$language->url_code.".webp";
                //image
                $file = $this->request->data['lien_hiver_en'];
                $ext=explode('/',$file['type']);
                $name="images/media/".$Media->name_key."_hiver_".$language->url_code;
                $imagineJPG = new Imagine();
				unlink($oldImagePath);
				unlink($oldImagePathWebp);
				$imageupload = $imagineJPG->open($this->request->data['lien_hiver_en']['tmp_name']);
				if($Media->name_key == "header_bloc_information" || $Media->name_key == 'logo_alpissime' || $Media->name_key == 'paiement_securise_desktop' || $Media->name_key == 'paiement_securise_mobile'){
					$imageupload->save($prefixe.$name.".png", array('png_compression_level' => 5))
								->save($prefixe.$name.".webp", array('webp_quality' => 85));
				}else{
					$imageupload->save($prefixe.$name.".jpg", array('jpeg_quality' => 85))
							->save($prefixe.$name.".webp", array('webp_quality' => 85));
				}			
				// Enregistrer En_US version
				$translations = [
					$language->code => [
						'lien_hiver' => $name,
					]
				];			
				foreach ($translations as $lang => $data) {
					$Media->translation($lang)->set($data, ['guard' => false]);
				}			
				$this->Media->save($Media);
			}		
		}

		$this->set(compact('Media'));
	}

}
