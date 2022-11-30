<?php
namespace App\Controller\Manager;

use App\Controller\AppController;

use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use SoapClient;
use mPDF;
use PHPExcel;
use PHPExcel_Writer_Excel5;
use PHPExcel_Style_Fill;
use PHPExcel_Style_Alignment;
use Cake\I18n\Date;
use Mustache_Engine;
use Cake\Validation\Validator;
use Cake\Log\Log;
use App\Controller\GoogleCalendarController;

/**
 * Gestionnaires Controller
 *
 * @property \App\Model\Table\GestionnairesTable $Gestionnaires
 */
class GestionnairesController extends AppController
{
    
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $actions=['index','pub','addpub','add','edit','contrat','statistique',
            'rapportstatistique','statistiquegenerale','statistiqueproprietaire',
            'populations','annoncesstatis','annoncesstatisgest','reservationsstatis',
            'occupationstatis','remplissagestatis','loyerprixmoyen','loyerprixmoyengest',
            'datasaisonloyerstatis','smslocataire','sms','message','mesannonces',
            'annonce','viewmessage','addmessage','generateexcelrapportstat',
            'modelcontrat','editmodelcontrat','stations','addperiodestation','editperiodestation',
            'vacances','addvacance','editvacance','codereduction','addcodereduction','editcodereduction',
            'commentaires','editcommentaire','sendmailCommentaire'];
        $manager_actions=['annoncesstatisgest','loyerprixmoyengest','editcodereduction','addcodereduction',
                            'mesannonces','annonce'];
        $admin_actions=['add','edit','vacances','addvacance','editvacance','contrat','modelcontrat','editmodelcontrat',
                        'sms','statistiquegenerale','populations','annoncesstatis','loyerprixmoyen','index'];
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
   * Index method
   *
   * @return \Cake\Network\Response|null
   */
  public function index()
  {
    	$session = $this->request->session();
    	if($session->check("Gestionnaire.manuelle")){
    		$this->set('confirm_res','reservation');
    		$session->delete("Gestionnaire.manuelle");
    	}
    	$this->viewBuilder()->layout('manager');
    	$this->set('InfoGes',$session->read('Gestionnaire.info'));
      $gestionnaires = $this->Gestionnaires->find('all');
      $this->set(compact('gestionnaires'));
  }
  /**
   * View method
   *
   * @param string|null $id Gestionnaire id.
   * @return \Cake\Network\Response|null
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function view($id = null)
  {
      $gestionnaire = $this->Gestionnaires->get($id, ['contain' => []]);
      $this->set('gestionnaire', $gestionnaire);
      $this->set('_serialize', ['gestionnaire']);
  }
  /**
	 *
	 **/
	public function pub($id=null){
		$session = $this->request->session();
		if($session->check("Pub.edit")){
			$this->set('confirm_res',$session->read('Pub.edit'));
			$session->delete("Pub.edit");
		}
		$this->loadModel('Images');
		$this->viewBuilder()->layout('manager');
		$this->set('images',$this->Images->find('all'));
		$gest=$session->read('Gestionnaire.info');
		$annonce=$this->Images->find()
							->join([
								'Gestionnaires' => [
								'table' => 'gestionnaires',
								'type' => 'INNER',
								'conditions' => 'Gestionnaires.id = Images.gestionnaire',
								]
							])
				->select(['Images.titre', 'Images.id', 'Images.visible'])
				->where(["Gestionnaires.id"=>$gest['G']['id']]);
		$this->set('images',$annonce);
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
  }
  /**
   *
   **/
	function addpub(){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		$this->loadModel('Lieugeos');
		$this->loadModel('Images');
		$gest=$session->read('Gestionnaire.info');
		$this->set('InfoGes',$gest);
		if($this->request->data) {
			$prefixe = $_SERVER['DOCUMENT_ROOT'];
			$destname = "$prefixe/webroot/img/uploads/";
			$file = $this->request->data['image'];
      $ext=explode('/',$file['type']);
			$name=date('YmdHis').".".$ext[1];
			move_uploaded_file($this->request->data['image']['tmp_name'], $destname.$name);
            $data=array("gestionnaire" => $gest['G']['id'],
						"image" => $name,
						"titre" => $this->request->data["titre"],
						"lien" => $this->request->data["lien"],
						"station" => serialize($this->request->data["lieugeo"]),
						"visible" => 0);
			$image = $this->Images->newEntity($data);
			if ($this->Images->save($image)) {
				$session->write("Pub.edit",'Vous avez ajouté une publicit&eacute;.');
			}
			else{
				$session->write("Pub.edit","Anomalie au moment de l'enregistrement de votre publicité");
			}
			return $this->redirect(['action' => 'pub']);
		}
		$enrs = $this->Lieugeos->find()
						->join([
							'A' => [
							'table' => 'annonces',
							'type' => 'INNER',
							'conditions' => 'Lieugeos.id = A.lieugeo_id',
							],
							// 'AG' => [
							// 'table' => 'annoncegestionnaires',
							// 'type' => 'INNER',
							// 'conditions' => 'A.id = AG.id_annonces',
							// ]
						])
				->select(['Lieugeos.id', 'Lieugeos.name'])
				->where(["A.id_gestionnaires"=>$gest['G']['id']])
				->group('Lieugeos.id');
		$this->set(compact('enrs'));
	}
  /**
	 *
	 **/
	function editpub($id=null){
		$session = $this->request->session();
		$this->loadModel('Lieugeos');
		$this->loadModel('Images');
		$gest=$session->read('Gestionnaire.info');
		$session = $this->request->session();
		$image = $this->Images->get($id);
		if($this->request->data){
			$data=array("titre" => $this->request->data["titre"],
						"lien" => $this->request->data["lien"],
						"station" => serialize($this->request->data["lieugeo"]),
						"visible" => 0);
			if(!empty($this->request->data['image']['name'])){
    			$prefixe = $_SERVER['DOCUMENT_ROOT'];
    			$destname = "$prefixe/webroot/img/uploads/";
    			$file = $this->request->data['image'];
          $ext=explode('/',$file['type']);
    			$name=date('YmdHis').".".$ext[1];
  				if(move_uploaded_file($this->request->data['image']['tmp_name'], $destname.$name))
  					$data['image']=$name;
      }
			$image = $this->Images->patchEntity($image, $data);
			if ($this->Images->save($image)) {
				$session->write("Pub.edit",'Vous avez modifié votre publicit&eacute;.');
			}
			else{
				$session->write("Pub.edit","Anomalie au moment de l'enregistrement de votre publicité");
			}
			return $this->redirect(['action' => 'pub']);
		}
		$stat=unserialize($image->station);
		$this->set('InfoGes',$gest);
		$enrs = $this->Lieugeos->find()
						->join([
							'A' => [
							'table' => 'annonces',
							'type' => 'INNER',
							'conditions' => 'Lieugeos.id = A.lieugeo_id',
							],
							// 'AG' => [
							// 'table' => 'annoncegestionnaires',
							// 'type' => 'INNER',
							// 'conditions' => 'A.id = AG.id_annonces',
							// ]
						])
				->select(['Lieugeos.id', 'Lieugeos.name'])
				->where(["A.id_gestionnaires"=>$gest['G']['id']])
				->group('Lieugeos.id');
		$this->viewBuilder()->layout('manager');
		$this->set(compact('image','enrs','stat'));
	}
  /**
	 *
	 **/
	function viewpub($id=null){
		$this->loadModel('Lieugeos');
		$this->loadModel('Images');
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
		$this->loadModel('Images');
		$session = $this->request->session();
		$annonce = $this->Images->get($id);
		$this->Images->delete($annonce);
		$session->write("Pub.edit",'Vous avez supprimé une publicité.');
    return $this->redirect(['action' => 'pub']);
	}
  /**
   * Add method
   *
   * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
   */
  public function add()
  {
    $this->loadModel('Villages');
    	$session = $this->request->session();
    	$this->viewBuilder()->layout('manager');
      $this->set('InfoGes',$session->read('Gestionnaire.info'));
      
    $this->loadModel('Pays');
    $pays=$this->Pays->find()->order('fr');
    $arrayPays=[0=>''];
    foreach($pays as $element)
    $arrayPays[$element->id_pays]=$element->fr;
    $this->set('pays',$arrayPays);

    	if($session->check("Gestionnaire.manuelle")){
    		$this->set('confirm_res','reservation');
    		$session->delete("Gestionnaire.manuelle");
    	}
      $gestionnaire = $this->Gestionnaires->newEntity();
      if ($this->request->is('post')) {
          $gestionnaire = $this->Gestionnaires->patchEntity($gestionnaire, $this->request->data);
          $gestionnaire->villages = $this->Villages->find()->where(['id IN' => $this->request->getData('villages')])->toArray();
          $gestionnaire->password=md5($this->request->data['password']);
          if(PROD_ON == 1){
            // Google Calendar
            $nom_calendar = $this->request->data['login']." Calendar";
            $googleCalendar = new GoogleCalendarController();
            $googleCalendar_id = $googleCalendar->addnewcalendar($nom_calendar);
            $gestionnaire->googlecalendar_id = $googleCalendar_id;
          }
          if ($this->Gestionnaires->save($gestionnaire)) {
      			$session->write("Gestionnaire.manuelle","addGestionnaire");
      			return $this->redirect(['action' => 'add']);
          } else {
              $this->Flash->error(__('The gestionnaire could not be saved. Please, try again.'));
          }
      }
    //get villages list
    $villages=$this->Villages->find('list', [
      'keyField' => 'id',
      'valueField' => 'name'
    ])->order('name');
    $this->set('villages',$villages->toArray());
    //end get villages list
      $this->set(compact('gestionnaire'));
      $this->set('_serialize', ['gestionnaire']);
  }
  /**
   * Edit method
   *
   * @param string|null $id Gestionnaire id.
   * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Network\Exception\NotFoundException When record not found.
   */
  public function edit($id = null,$modif=null)
  {
    	$session = $this->request->session();
    	$this->viewBuilder()->layout('manager');
      $this->set('InfoGes',$session->read('Gestionnaire.info'));
      //get pays dep ville station 
      $this->loadModel('Pays');
      $pays=$this->Pays->find()->order('fr');
      $arrayPays=[0=>''];
      foreach($pays as $element)
      $arrayPays[$element->id_pays]=$element->fr;
      $this->set('pays',$arrayPays);
      //get villages list
      $this->loadModel('Villages');
      $villages=$this->Villages->find('list', [
        'keyField' => 'id',
        'valueField' => 'name'
      ])->order('name');
      $this->set('villages',$villages->toArray());
      //end get villages list
    	if($session->check("Gestionnaire.manuelle")){
    		$this->set('confirm_res','reservation');
    		$session->delete("Gestionnaire.manuelle");
    	}
      $gestionnaire = $this->Gestionnaires->findById($id)->contain('Villages')->first();
      $this->set('gest_villages',array_map(function($value) { return $value->id; }, $gestionnaire->villages));
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
      $password=$gestionnaire->password;
      if ($this->request->is(['patch', 'post', 'put'])) {
          $gestionnaire = $this->Gestionnaires->patchEntity($gestionnaire, $this->request->data);
          $gestionnaire->villages = $this->Villages->find()->where(['id IN' => $this->request->getData('villages')])->toArray();
          if(!empty($this->request->data['password']))
      			$gestionnaire->password=md5($this->request->data['password']);
      		else
            $gestionnaire->password=$password;

          if(PROD_ON == 1){
            // Google Calendar
            if($gestionnaire->googlecalendar_id == ""){            
              $nom_calendar = $this->request->data['login']." Calendar";
              $googleCalendar = new GoogleCalendarController();
              $googleCalendar_id = $googleCalendar->addnewcalendar($nom_calendar);
              $gestionnaire->googlecalendar_id = $googleCalendar_id;
            } 
          }
                   
          if ($this->Gestionnaires->save($gestionnaire)) {
              $session->write("Gestionnaire.manuelle","addGestionnaire");
              return $this->redirect(['action' => 'edit',$gestionnaire->id]);
          } else {
              $this->Flash->error(__('The gestionnaire could not be saved. Please, try again.'));
          }
      }
      $this->set(compact('gestionnaire'));
      $this->set('_serialize', ['gestionnaire']);
  }
  /**
   * Delete method
   *
   * @param string|null $id Gestionnaire id.
   * @return \Cake\Network\Response|null Redirects to index.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function delete($id = null)
  {
    	$session = $this->request->session();
      $gestionnaire = $this->Gestionnaires->get($id);
      if ($this->Gestionnaires->delete($gestionnaire)) {
          $session->write("Gestionnaire.manuelle","addGestionnaire");
      }
      return $this->redirect(['action' => 'index']);
  }
  /**
	 *
	 **/
	function contrat(){
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
		$this->set('a_gest',$this->Gestionnaires->find('list',['fields' => ['Gestionnaires.id','Gestionnaires.name']]));
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
	function arraycontrat($id=null){
            $url=Router::url('/');
            $output=$this->Gestionnaires->getArrayContrat($url,$this->request->query);
            echo json_encode($output);die();
	}
        
//        function editvisble($id,$val){
//            $this->loadModel('Contrats');
//            $contrat=$this->Contrats->get($id);
//            $contrat->visible=$val;
//            $this->Contrats->save($contrat);
//            die();
//        }
  /**
   *
   **/
  function statistique(){
		$this->viewBuilder()->layout('manager');
    $session = $this->request->session();
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
  /**
	 *
	 **/
  public function rapportstatistique(){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));

    $this->loadModel("Lieugeos");
    $liste = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3, "etat = 1"],"order"=>"Lieugeos.name"]);
    $this->set("stations", $liste);

    $this->loadModel('Annonces');
    $donneesgenerale = $this->Annonces->get_array_rapport_stat_info_gener($gest);
    $this->set("annvalide", $donneesgenerale['annvalide']);
    $this->set("annbrouillon", $donneesgenerale['annbrouillon']);
  }
  /**
   *
   **/
  public function statistiquegenerale(){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));

    $this->loadModel("Utilisateurs");
    $utilTotal = $this->Utilisateurs->find('all')->where("Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT' OR Utilisateurs.nature = 'CLT'")->count();
    $this->set("utilsTotal", $utilTotal);
    $prop = $this->Utilisateurs->find()->where("Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT'")->count();
    $this->set("nbrProp", $prop);
    $loc = $this->Utilisateurs->find()->where("Utilisateurs.nature = 'CLT'")->count();
    $this->set("nbrLoc", $loc);

    $this->loadModel("Annonces");
    $ann = $this->Annonces->find()->where("Annonces.statut = 50")->count();
    $this->set("nbrAnn", $ann);
    $this->loadModel("Reservations");
    $res = $this->Reservations->find()->join([
                    'A' => [
                      'table' => 'annonces',
                      'type' => 'inner',
                      'conditions' => ['Reservations.annonce_id = A.id','Reservations.statut = 90'],
                    ]
                  ])->count();
    $this->set("nbrRes", $res);
    $month = date("n");
    if ($month<9){
        $year = date("Y")-1;
    }
    else{
        $year = date("Y");
    }
    $where = [];
    $where[] = "(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT' OR Utilisateurs.nature = 'CLT')";
    $where[] = '(Utilisateurs.telephone != "" OR Utilisateurs.portable != "")';
    $where[] = "(date_insert >= STR_TO_DATE('".$year."-09-01','%Y-%m-%d'))";
    $whereNumFR = [];
    $whereNumFR[] = "(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT' OR Utilisateurs.nature = 'CLT')";
    $whereNumFR[] = "(REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(06)[0-9]{8}$' OR REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(/+33|33|0033|330)[0-9]{9}$' OR REGEXP_REPLACE(IF (Utilisateurs.portable != '',Utilisateurs.portable, Utilisateurs.telephone ),'[^0-9]','') REGEXP '^(073|074|075|076|077|078|079)[0-9]{7}$')";
    $whereNumFR[] = "(date_insert >= STR_TO_DATE('".$year."-09-01','%Y-%m-%d'))";
    $totalUtilTel = $this->Utilisateurs->find()->where($where)->count();
    $totalUtilFran = $this->Utilisateurs->find()->where($whereNumFR)->count();
    if($totalUtilTel != 0) $pourcFR = ($totalUtilFran*100)/$totalUtilTel;
    else $pourcFR = 0;
    $this->set("pourcFR", round($pourcFR, 2));
    if($totalUtilTel != 0) $this->set("pourcETR", round(100-$pourcFR, 2));
    else $this->set("pourcETR", 0);

    $annApp = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.nature = "APP"')->count();
    $pourcAnnApp = ($annApp*100)/$ann;
    $this->set("annApp", round($pourcAnnApp, 2));
    $annStd = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.nature = "STD"')->count();
    $pourcAnnStd = ($annStd*100)/$ann;
    $this->set("annStd", round($pourcAnnStd, 2));
    $annCha = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.nature = "CHA"')->count();
    $pourcAnnCha = ($annCha*100)/$ann;
    $this->set("annCha", round($pourcAnnCha, 2));

    $annCont = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.contrat = 1')->count();
    $pourcAnnCont = ($annCont*100)/$ann;
    $this->set("annCont", round($pourcAnnCont, 2));
    $annMise = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.mise_relation = 1')->count();
    $pourcAnnMise = ($annMise*100)/$ann;
    $this->set("annMise", round($pourcAnnMise, 2));

    $nbrReAn = [];
    $annee = 2011;
    $month = date("n");
    if ($month<9){
        $year= date("Y");
    }
    else{
        $year = date("Y")+1;
    }
    while ($annee <= $year) {
      $nbrReAn[$annee] = 0;
      for ($i=9; $i <= 12 ; $i++) {
        $nbrReserv = $this->Reservations->find()->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at) = "'.($annee-1).'" AND MONTH(Reservations.dbt_at) = "'.$i.'"')->count();
        $nbrReAn[$annee] += $nbrReserv;
      }
      for ($j=1; $j < 9 ; $j++) {
        $nbrReserv = $this->Reservations->find()->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at) = "'.$annee.'" AND MONTH(Reservations.dbt_at) = "'.$j.'"')->count();
        $nbrReAn[$annee] += $nbrReserv;
      }
      $annee++;
    }
    $this->set("nbrReAn", $nbrReAn);

    $reserArc1800 = $this->Reservations->find()->join([
                    'A' => [
                      'table' => 'annonces',
                      'type' => 'inner',
                      'conditions' => ['Reservations.annonce_id = A.id','Reservations.statut = 90'],
                    ]
                  ])->where('A.lieugeo_id = 2')->count();
    $pourArc1800 = ($reserArc1800*100)/$res;
    $this->set("pouArc1800", round($pourArc1800, 2));
    $reserArcChantel = $this->Reservations->find()->join([
                    'A' => [
                      'table' => 'annonces',
                      'type' => 'inner',
                      'conditions' => ['Reservations.annonce_id = A.id','Reservations.statut = 90'],
                    ]
                  ])->where('A.lieugeo_id = 8')->count();
    $pourArcChantel = ($reserArcChantel*100)/$res;
    $this->set("pouArcChantel", round($pourArcChantel, 2));
    $reserArcCharvet = $this->Reservations->find()->join([
                    'A' => [
                      'table' => 'annonces',
                      'type' => 'inner',
                      'conditions' => ['Reservations.annonce_id = A.id','Reservations.statut = 90'],
                    ]
                  ])->where('A.lieugeo_id = 9')->count();
    $pourArcCharvet = ($reserArcCharvet*100)/$res;
    $this->set("pouArcCharvet", round($pourArcCharvet, 2));
    $reserArcCharm = $this->Reservations->find()->join([
                    'A' => [
                      'table' => 'annonces',
                      'type' => 'inner',
                      'conditions' => ['Reservations.annonce_id = A.id','Reservations.statut = 90'],
                    ]
                  ])->where('A.lieugeo_id = 10')->count();
    $pourArcCharm = ($reserArcCharm*100)/$res;
    $this->set("pouArcCharm", round($pourArcCharm, 2));
    $reserArcVil = $this->Reservations->find()->join([
                    'A' => [
                      'table' => 'annonces',
                      'type' => 'inner',
                      'conditions' => ['Reservations.annonce_id = A.id','Reservations.statut = 90'],
                    ]
                  ])->where('A.lieugeo_id = 11')->count();
    $pourArcVil = ($reserArcVil*100)/$res;
    $this->set("pouArcVil", round($pourArcVil, 2));

    $this->loadModel("Pays");
    $listpays = $this->Pays->find()->join([
                    'U' => [
                      'table' => 'utilisateurs',
                      'type' => 'inner',
                      'conditions' => ['Pays.id_pays = U.pays'],
                    ]
                  ])->group(['Pays.id_pays']);
    $paysTab = [];
    $events = [];
    foreach ($listpays as $value) {
      if($value->id_pays != 1){
        $paysTab['title'] = $value->fr;
        $paysTab['id'] = $value->code_pays;
        $paysTab['color'] = "#243f6b";
        array_push($events, $paysTab);
      }
    }
    $paysTab['title'] = "Belgique";
    $paysTab['id'] = "BE";
    $paysTab['color'] = "#243f6b";
    array_push($events, $paysTab);
    $paysTab['title'] = "Espagne";
    $paysTab['id'] = "ES";
    $paysTab['color'] = "#243f6b";
    array_push($events, $paysTab);
    $paysTab['title'] = "Russie";
    $paysTab['id'] = "RU";
    $paysTab['color'] = "#243f6b";
    array_push($events, $paysTab);
    $paysTab['title'] = "Luxembourg";
    $paysTab['id'] = "LU";
    $paysTab['color'] = "#243f6b";
    array_push($events, $paysTab);
    $paysTab['title'] = "Allemagne";
    $paysTab['id'] = "DE";
    $paysTab['color'] = "#243f6b";
    array_push($events, $paysTab);
    $paysTab['title'] = "Suisse";
    $paysTab['id'] = "CH";
    $paysTab['color'] = "#243f6b";
    array_push($events, $paysTab);
    $paysTab['title'] = "Pays-Bas";
    $paysTab['id'] = "NL";
    $paysTab['color'] = "#243f6b";
    array_push($events, $paysTab);
    $paysTab['title'] = "Royaume-Uni";
    $paysTab['id'] = "GB";
    $paysTab['color'] = "#243f6b";
    array_push($events, $paysTab);
    $paysTab['title'] = "Indonésie";
    $paysTab['id'] = "ID";
    $paysTab['color'] = "#243f6b";
    array_push($events, $paysTab);
    $paysTab['title'] = "Maroc";
    $paysTab['id'] = "MA";
    $paysTab['color'] = "#243f6b";
    array_push($events, $paysTab);
    $paysTab['title'] = "états-Unis";
    $paysTab['id'] = "US";
    $paysTab['color'] = "#243f6b";
    array_push($events, $paysTab);

    $this->set("listePays", $events);
  }
  /**
   * 
   */
  public function statnuitees(){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));
    //reservations par ans, nbadults-nbenfants
    $annee = 2011;
    $month = date("n");
    if ($month<9){
        $year= date("Y");
    }
    else{
        $year = date("Y")+1;
    }
    $this->loadModel('Reservations');
    $reservationsAns=[];
    $reservationsAge=[];
    for ($annee;$annee<=$year;$annee++){
        $reservationsAns[($annee-1).'-'.$annee]=$this->Reservations->nuitsans($annee)->first()->nbnuits;
        $reservationsAge[($annee-1).'-'.$annee]=$this->Reservations->reservationageans($annee)->first();
    }
    $this->set('reservationsAns',$reservationsAns);
    $this->set('reservationsAge',$reservationsAge);
    //end reservations par ans, nbadults-nbenfants
  }
  /**
	 *
	 **/
  public function statistiqueproprietaire(){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
    $this->loadModel("Vacances");
    $this->loadModel("Utilisateurs");
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }else{
      $gest_id = NULL;
    }
    $listProp = $this->Utilisateurs->getListeProp($gest_id);
    $this->set("listProp", $listProp);
    /*** STATISTIQUE TOUS LES PROPRIETAIRES ***/
    $this->loadModel("Dispos");
    $nbrInscrAn = [];
    $annee = 2011;
    $month = date("n");
    if ($month<9){
        $year= date("Y");
    }
    else{
        $year = date("Y")+1;
    }
    while ($annee <= $year) {
      $nbrTotal = 0;
      for ($i=9; $i <= 12; $i++) {
        $nbrTotal += $this->Dispos->get_chiffre_affaire($gest_id, $annee-1, $i)->total;
      }
      for ($j=1; $j < 9; $j++) {
        $nbrTotal += $this->Dispos->get_chiffre_affaire($gest_id, $annee, $j)->total;
      }
      $nbrInscrAn[$annee] = round($nbrTotal, 2);
      $annee++;
    }    
    $this->set("nbrInscrAnchiffre", $nbrInscrAn);

    /*** LISTE VACANCES ***/
    $listevacance = $this->Vacances->getListeVacances()->where('Pays.code_pays = "FR"');
    $this->set('listeVacances',$listevacance);
  }
  /**
   *
   **/
  public function populations(){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));

    $this->loadModel("Utilisateurs");
    $utilTotal = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT') AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle')")->count();
    $utilTotalNais = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT') AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle') AND Utilisateurs.naissance IS NOT NULL AND Utilisateurs.naissance != '0000-00-00'")->count();

    $utilFemme = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT') AND ( Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle')")->count();
    $pourFemme = ($utilFemme*100)/$utilTotal;
    $this->set("pourFemme", round($pourFemme, 2));

    $utilHomme = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT') AND ( Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' )")->count();
    $pourHomme = ($utilHomme*100)/$utilTotal;
    $this->set("pourHomme", round($pourHomme, 2));

    $utilSup60 = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT') AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle') AND (YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) >= 60)")->count();
    $pourutilSup60 = ($utilSup60*100)/$utilTotalNais;
    $this->set("utilSup60", round($pourutilSup60, 2));
    $utilinf60 = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT') AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle') AND (YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) >= 50 AND YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) < 60)")->count();
    $pourutilinf60 = ($utilinf60*100)/$utilTotalNais;
    $this->set("utilinf60", round($pourutilinf60, 2));
    $utilinf50 = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT') AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle') AND (YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) >= 40 AND YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) < 50)")->count();
    $pourutilinf50 = ($utilinf50*100)/$utilTotalNais;
    $this->set("utilinf50", round($pourutilinf50, 2));
    $utilinf40 = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT') AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle') AND (YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) >= 30 AND YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) < 40)")->count();
    $pourutilinf40 = ($utilinf40*100)/$utilTotalNais;
    $this->set("utilinf40", round($pourutilinf40, 2));
    $utilinf30 = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'ANNO' OR Utilisateurs.nature = 'MIXT') AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle') AND (YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) >= 16 AND YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) < 30)")->count();
    $pourutilinf30 = ($utilinf30*100)/$utilTotalNais;
    $this->set("utilinf30", round($pourutilinf30, 2));

    $utilTotalLoc = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'CLT' ) AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle')")->count();

    $utilFemmeLoc = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'CLT') AND ( Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle')")->count();
    $pourFemmeLoc = ($utilFemmeLoc*100)/$utilTotalLoc;
    $this->set("pourFemmeLoc", round($pourFemmeLoc, 2));

    $utilHommeLoc = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'CLT') AND ( Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' )")->count();
    $pourHommeLoc = ($utilHommeLoc*100)/$utilTotalLoc;
    $this->set("pourHommeLoc", round($pourHommeLoc, 2));

    $totalAgeLoc = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'CLT' ) AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle') AND Utilisateurs.naissance IS NOT NULL AND Utilisateurs.naissance != '0000-00-00'")->count();

    $utilSup60Loc = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'CLT') AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle') AND (YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) >= 60)")->count();
    $pourutilSup60Loc = ($utilSup60Loc*100)/$totalAgeLoc;
    $this->set("utilSup60Loc", round($pourutilSup60Loc, 2));
    $utilinf60Loc = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'CLT') AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle') AND (YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) >= 50 AND YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) < 60)")->count();
    $pourutilinf60Loc = ($utilinf60Loc*100)/$totalAgeLoc;
    $this->set("utilinf60Loc", round($pourutilinf60Loc, 2));
    $utilinf50Loc = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'CLT') AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle') AND (YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) >= 40 AND YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) < 50)")->count();
    $pourutilinf50Loc = ($utilinf50Loc*100)/$totalAgeLoc;
    $this->set("utilinf50Loc", round($pourutilinf50Loc, 2));
    $utilinf40Loc = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'CLT') AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle') AND (YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) >= 30 AND YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) < 40)")->count();
    $pourutilinf40Loc = ($utilinf40Loc*100)/$totalAgeLoc;
    $this->set("utilinf40Loc", round($pourutilinf40Loc, 2));
    $utilinf30Loc = $this->Utilisateurs->find('all')->where("(Utilisateurs.nature = 'CLT') AND (Utilisateurs.civilite = 'M.' OR Utilisateurs.civilite = 'Mr' OR Utilisateurs.civilite = 'Mme' OR Utilisateurs.civilite = 'Mlle') AND (YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) >= 16 AND YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`naissance`))) < 30)")->count();
    $pourutilinf30Loc = ($utilinf30Loc*100)/$totalAgeLoc;
    $this->set("utilinf30Loc", round($pourutilinf30Loc, 2));

    $nbrInscrAn = [];
    $annee = 2011;
    $month = date("n");
    if ($month<9){
        $year2= date("Y");
    }
    else{
        $year2 = date("Y")+1;
    }
    while ($annee <= $year2) {
      $nbrInscrAn[$annee] = 0;
      for ($i=9; $i <= 12 ; $i++) {
        $nbrInscr = $this->Utilisateurs->find()->where('(Utilisateurs.nature = "ANNO" OR Utilisateurs.nature = "MIXT") AND YEAR(Utilisateurs.date_insert)="'.($annee-1).'" AND MONTH(Utilisateurs.date_insert)="'.$i.'"')->count();
        $nbrInscrAn[$annee] += $nbrInscr;
      }
      for ($j=1; $j < 9; $j++) {
        $nbrInscr = $this->Utilisateurs->find()->where('(Utilisateurs.nature = "ANNO" OR Utilisateurs.nature = "MIXT") AND YEAR(Utilisateurs.date_insert)="'.$annee.'" AND MONTH(Utilisateurs.date_insert)="'.$j.'"')->count();
        $nbrInscrAn[$annee] += $nbrInscr;
      }
      $annee++;
    }
    $this->set("nbrInscrAn", $nbrInscrAn);

    $nbrInscrAnLoc = [];
    $annee = 2011;
    while ($annee <= $year2) {
      $nbrInscrAnLoc[$annee] = 0;
      for ($i=9; $i <= 12; $i++) {
        $nbrInscrLoc = $this->Utilisateurs->find()->where('(Utilisateurs.nature = "CLT") AND YEAR(Utilisateurs.date_insert)="'.($annee-1).'" AND MONTH(Utilisateurs.date_insert)="'.$i.'"')->count();
        $nbrInscrAnLoc[$annee] += $nbrInscrLoc;
      }
      for ($j=1; $j < 9; $j++) {
        $nbrInscrLoc = $this->Utilisateurs->find()->where('(Utilisateurs.nature = "CLT") AND YEAR(Utilisateurs.date_insert)="'.$annee.'" AND MONTH(Utilisateurs.date_insert)="'.$j.'"')->count();
        $nbrInscrAnLoc[$annee] += $nbrInscrLoc;
      }
      $annee++;
    }
    $this->set("nbrInscrAnLoc", $nbrInscrAnLoc);
  }
  /**
   *
   **/
  public function datamoisstatis($id){
    $this->viewBuilder()->layout(false);
    $this->loadModel("Utilisateurs");
    $nbrInscrAnLocMois = [];
    for ($mois=9; $mois <= 12; $mois++) {
      $nbrInscrLocMois = $this->Utilisateurs->find()->where('(Utilisateurs.nature = "CLT") AND YEAR(Utilisateurs.date_insert)="'.($id-1).'" AND MONTH(Utilisateurs.date_insert)="'.$mois.'"')->count();
      $nbrInscrAnLocMois[] = $nbrInscrLocMois;
    }
    for ($moi=1; $moi < 9; $moi++) {
      $nbrInscrLocMois = $this->Utilisateurs->find()->where('(Utilisateurs.nature = "CLT") AND YEAR(Utilisateurs.date_insert)="'.$id.'" AND MONTH(Utilisateurs.date_insert)="'.$moi.'"')->count();
      $nbrInscrAnLocMois[] = $nbrInscrLocMois;
    }
    $this->set("nbrInscrAnLocMois", $nbrInscrAnLocMois);

    $nbrInscrAnMois = [];
    for ($mois=9; $mois <= 12; $mois++) {
      $nbrInscrMois = $this->Utilisateurs->find()->where('(Utilisateurs.nature = "ANNO" OR Utilisateurs.nature = "MIXT") AND YEAR(Utilisateurs.date_insert)="'.($id-1).'" AND MONTH(Utilisateurs.date_insert)="'.$mois.'"')->count();
      $nbrInscrAnMois[] = $nbrInscrMois;
    }
    for ($moi=1; $moi < 9; $moi++) {
      $nbrInscrMois = $this->Utilisateurs->find()->where('(Utilisateurs.nature = "ANNO" OR Utilisateurs.nature = "MIXT") AND YEAR(Utilisateurs.date_insert)="'.$id.'" AND MONTH(Utilisateurs.date_insert)="'.$moi.'"')->count();
      $nbrInscrAnMois[] = $nbrInscrMois;
    }
    $this->set("nbrInscrAnMois", $nbrInscrAnMois);
  }
  /**
   *
   **/
  public function annoncesstatis(){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));
    $this->loadModel("Annonces");
    $totalAnn = $this->Annonces->find()->where("Annonces.statut = 50")->count();
    $annContrat = $this->Annonces->find()->where("Annonces.statut = 50 AND Annonces.contrat = 1")->count();
    $annContratPour = ($annContrat*100)/$totalAnn;
    $this->set("annContratPour", round($annContratPour, 2));
    $annMise = $this->Annonces->find()->where("Annonces.statut = 50 AND Annonces.mise_relation = 1")->count();
    $annMisePour = ($annMise*100)/$totalAnn;
    $this->set("annMisePour", round($annMisePour, 2));
    $annSans = $this->Annonces->find()->where("Annonces.statut = 50 AND Annonces.mise_relation = 0 AND Annonces.contrat = 0")->count();
    $annSansPour = ($annSans*100)/$totalAnn;
    $this->set("annSansPour", round($annSansPour, 2));

    $nbrInscrAn = [];
    $annee = 2014;
    $month = date("n");
    if ($month<9){
        $year2= date("Y");
    }
    else{
        $year2 = date("Y")+1;
    }
    while ($annee <= $year2) {
      $nbrInscrAn[$annee] = 0;
      for ($i=9; $i <= 12; $i++) {
        $nbrInscr = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.contrat = 1 AND YEAR(Annonces.date_contrat)="'.($annee-1).'" AND MONTH(Annonces.date_contrat)="'.$i.'"')->count();
        $nbrInscrAn[$annee] += $nbrInscr;
      }
      for ($j=1; $j < 9; $j++) {
        $nbrInscr = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.contrat = 1 AND YEAR(Annonces.date_contrat)="'.$annee.'" AND MONTH(Annonces.date_contrat)="'.$j.'"')->count();
        $nbrInscrAn[$annee] += $nbrInscr;
      }
      $annee++;
    }
    $this->set("nbrInscrAn", $nbrInscrAn);
    $nbrInscrMise = [];
    $annee = 2014;
    while ($annee <= $year2) {
      $nbrInscrMise[$annee] = 0;
      for ($i=9; $i <= 12; $i++) {
        $nbrInscrMisecount = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.mise_relation = 1 AND YEAR(Annonces.date_mise_relation)="'.($annee-1).'" AND MONTH(Annonces.date_mise_relation)="'.$i.'"')->count();
        $nbrInscrMise[$annee] += $nbrInscrMisecount;
      }
      for ($j=1; $j < 9; $j++) {
        $nbrInscrMisecount = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.mise_relation = 1 AND YEAR(Annonces.date_mise_relation)="'.$annee.'" AND MONTH(Annonces.date_mise_relation)="'.$j.'"')->count();
        $nbrInscrMise[$annee] += $nbrInscrMisecount;
      }
      $annee++;
    }
    $this->set("nbrInscrMise", $nbrInscrMise);
  }
  /**
   *
   **/
  public function annoncesstatisgest(){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));
    $this->loadModel("Annonces");
    $nbrInscrAn = [];
    $annee = 2014;
    $month = date("n");
    if ($month<9){
        $year= date("Y");
    }
    else{
        $year = date("Y")+1;
    }
    while ($annee <= $year) {
      $nbrInscrAn[$annee] = 0;
      for ($i=9; $i <= 12; $i++) {
        $nbrInscr = $this->Annonces->find()
        ->where('Annonces.id_gestionnaires = "'.$gest['G']['id'].'" AND Annonces.statut = 50 AND Annonces.contrat = 1 AND YEAR(Annonces.date_contrat)="'.($annee-1).'" AND MONTH(Annonces.date_contrat)="'.$i.'"')->count();
        $nbrInscrAn[$annee] += $nbrInscr;
      }
      for ($j=1; $j < 9; $j++) {
        $nbrInscr = $this->Annonces->find()
        ->where('Annonces.id_gestionnaires = "'.$gest['G']['id'].'" AND Annonces.statut = 50 AND Annonces.contrat = 1 AND YEAR(Annonces.date_contrat)="'.$annee.'" AND MONTH(Annonces.date_contrat)="'.$j.'"')->count();
        $nbrInscrAn[$annee] += $nbrInscr;
      }
      $annee++;
    }
    $this->set("nbrInscrAn", $nbrInscrAn);
  }
  /**
   *
   **/
  public function datamoisstatiscontratgest($id){
    $this->viewBuilder()->layout(false);
    $this->loadModel("Annonces");
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $nbrInscrAnMois = [];
    for ($mois=9; $mois <= 12; $mois++) {
      $nbrInscrMois = $this->Annonces->find()
      ->where('Annonces.id_gestionnaires = "'.$gest['G']['id'].'" AND Annonces.statut = 50 AND Annonces.contrat = 1 AND YEAR(Annonces.date_contrat)="'.($id-1).'" AND MONTH(Annonces.date_contrat)="'.$mois.'"')->count();
      $nbrInscrAnMois[] = $nbrInscrMois;
    }
    for ($moi=1; $moi < 9; $moi++) {
      $nbrInscrMois = $this->Annonces->find()
      ->where('Annonces.id_gestionnaires = "'.$gest['G']['id'].'" AND Annonces.statut = 50 AND Annonces.contrat = 1 AND YEAR(Annonces.date_contrat)="'.$id.'" AND MONTH(Annonces.date_contrat)="'.$moi.'"')->count();
      $nbrInscrAnMois[] = $nbrInscrMois;
    }
    $this->set("nbrInscrAnMois", $nbrInscrAnMois);
  }
  /**
   *
   **/
  public function datamoisstatiscontrat($id){
    $this->viewBuilder()->layout(false);
    $this->loadModel("Annonces");
    $nbrInscrAnLocMois = [];
    for ($mois=9; $mois <= 12; $mois++) {
      $nbrInscrLocMois = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.mise_relation = 1 AND YEAR(Annonces.date_mise_relation)="'.($id-1).'" AND MONTH(Annonces.date_mise_relation)="'.$mois.'"')->count();
      $nbrInscrAnLocMois[] = $nbrInscrLocMois;
    }
    for ($moi=1; $moi < 9; $moi++) {
      $nbrInscrLocMois = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.mise_relation = 1 AND YEAR(Annonces.date_mise_relation)="'.$id.'" AND MONTH(Annonces.date_mise_relation)="'.$moi.'"')->count();
      $nbrInscrAnLocMois[] = $nbrInscrLocMois;
    }
    $this->set("nbrInscrAnLocMois", $nbrInscrAnLocMois);

    $nbrInscrAnMois = [];
    for ($mois=9; $mois <= 12; $mois++) {
      $nbrInscrMois = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.contrat = 1 AND YEAR(Annonces.date_contrat)="'.($id-1).'" AND MONTH(Annonces.date_contrat)="'.$mois.'"')->count();
      $nbrInscrAnMois[] = $nbrInscrMois;
    }
    for ($moi=1; $moi < 9; $moi++) {
      $nbrInscrMois = $this->Annonces->find()->where('Annonces.statut = 50 AND Annonces.contrat = 1 AND YEAR(Annonces.date_contrat)="'.$id.'" AND MONTH(Annonces.date_contrat)="'.$moi.'"')->count();
      $nbrInscrAnMois[] = $nbrInscrMois;
    }
    $this->set("nbrInscrAnMois", $nbrInscrAnMois);
  }
  /**
   *
   **/
  public function reservationsstatis(){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));
    $this->loadModel("Reservations");
    $nbrInscrAn = [];
    $annee = 2011;
    $month = date("n");
    if ($month<9){
        $year= date("Y");
    }
    else{
        $year = date("Y")+1;
    }
    while ($annee <= $year) {
      $nbrInscrAn[$annee] = 0;
      for ($i=9; $i <= 12; $i++) {
        $nbrInscr = $this->Reservations->find();
          if($gest['G']['role'] == "gestionnaire"){
            $nbrInscr->join([
                  'Annonces' => [
                    'table' => 'annonces',
                    'type' => 'inner',
                    'conditions' => ['Annonces.id = Reservations.annonce_id'],
                  ]
                ]);
                $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
          }
        $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.($annee-1).'" AND MONTH(Reservations.dbt_at)="'.$i.'"');
        $nbrInscr->select(['nbr' => $nbrInscr->func()->count('*')]);
        $nbrInscr = $nbrInscr->first();
        $nbrInscrAn[$annee] += $nbrInscr->nbr;
      }
      for ($j=1; $j < 9; $j++) {
        $nbrInscr = $this->Reservations->find();
          if($gest['G']['role'] == "gestionnaire"){
            $nbrInscr->join([
                  'Annonces' => [
                    'table' => 'annonces',
                    'type' => 'inner',
                    'conditions' => ['Annonces.id = Reservations.annonce_id'],
                  ]
                ]);
              $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
          }
        $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$annee.'" AND MONTH(Reservations.dbt_at)="'.$j.'"');
        $nbrInscr->select(['nbr' => $nbrInscr->func()->count('*')]);
        $nbrInscr = $nbrInscr->first();
        $nbrInscrAn[$annee] += $nbrInscr->nbr;
      }
      $annee++;
    }
    $this->set("nbrInscrAn", $nbrInscrAn);
  }
  /**
   *
   **/
  public function datamoisstatisreservation($id){
    $this->viewBuilder()->layout(false);
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->loadModel("Reservations");
    $nbrInscrAn = [];
    for ($mois=9; $mois <= 12; $mois++) {
      $nbrInscr = $this->Reservations->find();
        if($gest['G']['role'] == "gestionnaire"){
          $nbrInscr->join([
            'Annonces' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => ['Annonces.id = Reservations.annonce_id'],
              ]
          ]);
          $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
        }
      $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.($id-1).'" AND MONTH(Reservations.dbt_at)="'.$mois.'"');
      $nbrInscr->select(['nbr' => $nbrInscr->func()->count('*')]);
      $nbrInscr = $nbrInscr->first();
      $nbrInscrAn[] = $nbrInscr->nbr;
    }
    for ($moi=1; $moi < 9; $moi++) {
      $nbrInscr = $this->Reservations->find();
        if($gest['G']['role'] == "gestionnaire"){
          $nbrInscr->join([
            'Annonces' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => ['Annonces.id = Reservations.annonce_id'],
              ]
          ]);
          $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
        }
      $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$id.'" AND MONTH(Reservations.dbt_at)="'.$moi.'"');
      $nbrInscr->select(['nbr' => $nbrInscr->func()->count('*')]);
      $nbrInscr = $nbrInscr->first();
      $nbrInscrAn[] = $nbrInscr->nbr;
    }
    $this->set("nbrInscrAnMois", $nbrInscrAn);
  }
  /**
   *
   **/
  public function datasemainestatisreservation($annee, $mois){
    $this->viewBuilder()->layout(false);
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->loadModel("Reservations");
    $time = mktime(0, 0, 0, $mois, 1, $annee);
    $firstWednesday = strtotime('Saturday', $time);
    $nbrInscrAn = [];
    $nbrInscrLabel = [];
    $moisperid =  strftime("%d", $firstWednesday);
    if($moisperid > 1){
      $deb = 1;
      $fin = $moisperid;
      $nbrInscr = $this->Reservations->find();
        if($gest['G']['role'] == "gestionnaire"){
          $nbrInscr->join([
            'Annonces' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => ['Annonces.id = Reservations.annonce_id'],
              ]
          ]);
          $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
        }
      $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$annee.'" AND MONTH(Reservations.dbt_at)="'.$mois.'" AND Reservations.dbt_at >= "'.$annee.'-'.$mois.'-'.$deb.'" AND Reservations.dbt_at < "'.$annee.'-'.$mois.'-'.$fin.'"');
      $nbrInscr->select(['nbr' => $nbrInscr->func()->count('*')]);
      $nbrInscr = $nbrInscr->first();
      $nbrInscrAn[] = $nbrInscr->nbr;
      $nbrInscrLabel[] = $deb." - ".($fin-1);
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
      $nbrInscr = $this->Reservations->find();
      if($gest['G']['role'] == "gestionnaire"){
        $nbrInscr->join([
          'Annonces' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['Annonces.id = Reservations.annonce_id'],
            ]
        ]);
        $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
      }
      $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$annee.'" AND MONTH(Reservations.dbt_at)="'.$mois.'" AND Reservations.dbt_at >= "'.$annee.'-'.$mois.'-'.$deb.'" AND Reservations.dbt_at <= "'.$annee.'-'.$mois.'-'.$fin.'"');
      $nbrInscr->select(['nbr' => $nbrInscr->func()->count('*')]);
      $nbrInscr = $nbrInscr->first();
      $nbrInscrAn[] = $nbrInscr->nbr;
      $nbrInscrLabel[] = $deb." - ".$fin;
      $firstWednesday = strtotime("+1 day", $afterweek);
      $moisperid = strftime("%d", $firstWednesday);
    }
    $this->set("nbrInscrAnSemaine", $nbrInscrAn);
    $this->set("labelsemaine", $nbrInscrLabel);
  }
  /**
   * 
   */
  public function remplissagestatis(){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));
    /*** LISTE STATIONS ***/
    $this->loadModel("Lieugeos");
    $listStat = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3, "etat = 1"],"order"=>"Lieugeos.name"]);
    $this->set("listStat",$listStat);
    /** LISTE VILLAGES **/
    $this->loadModel("Villages");
    $listevillageann = $this->Villages->find()->join([
      'Annonces' => [
        'table' => 'annonces',
        'type' => 'inner',
        'conditions' => ['Villages.id = Annonces.village', "Annonces.statut = 50"],
      ]
    ]);
    if($gest['G']['role'] == "gestionnaire"){      
      $gestionnaire = $this->Gestionnaires->findById($gest['G']['id'])->contain('Villages')->first();
      $gest_villages = array_map(function($value) { return $value->id; }, $gestionnaire->villages);
      $listevillageann->where(['Villages.id IN' => $gest_villages]);
      if($gest_villages[0] && $gest_villages[0] != ""){
        $vilstat = $this->Villages->get($gest_villages[0]);
        $this->set("vilstat",$vilstat->lieugeo_id);
      }
    }
    $listevillageann->group(['Villages.id'])->order(['Villages.name']);
    $this->set("listevillageann",$listevillageann);
    /** NBR LIT ANNONCES SYSTEME **/
    $this->loadModel("Annonces");
    $nbrLitAnnonce = $this->Annonces->find("all")->where(['Annonces.statut=50'])->select(['nbrmaxannonce' => 'SUM(Annonces.personnes_nb)'])->first();
    /** TAUX REMPLISSAGE **/
    $this->loadModel("Reservations");
    $nbrInscrAn = [];
    $annee = 2011;
    
    $month = date("n");
    if ($month<9){
        $year= date("Y");
    }
    else{
        $year = date("Y")+1;
    }
    while ($annee <= $year) {
      $nbrInscrAn[$annee] = 0;
      $nbreserv[$annee] = 0;
      for ($i=9; $i <= 12; $i++) {
          $nbrInscr = $this->Reservations->find();
          $nbrInscr->join([
            'Annonces' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['Annonces.id = Reservations.annonce_id'],
            ]
          ]);
          if($gest['G']['role'] == "gestionnaire"){            
            $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
          }
        $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.($annee-1).'" AND MONTH(Reservations.dbt_at)="'.$i.'"');
        $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
        $nbrInscr = $nbrInscr->first();
        $nbrInscrAn[$annee] += $nbrInscr->nbrpersonne;
        // $nbreserv[$annee] += $nbrInscr->nbrmaxannonce;
        
      }
      for ($j=1; $j < 9; $j++) {
        $nbrInscr = $this->Reservations->find();
        $nbrInscr->join([
          'Annonces' => [
            'table' => 'annonces',
            'type' => 'inner',
            'conditions' => ['Annonces.id = Reservations.annonce_id'],
          ]
        ]);
        if($gest['G']['role'] == "gestionnaire"){            
            $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);

        }
        $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$annee.'" AND MONTH(Reservations.dbt_at)="'.$j.'"');
        $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
        $nbrInscr = $nbrInscr->first();
        $nbrInscrAn[$annee] += $nbrInscr->nbrpersonne;
        // $nbreserv[$annee] += $nbrInscr->nbrmaxannonce;
      }
      // modifié calcul !!!!!!
      $nbreserv[$annee] = $nbrLitAnnonce->nbrmaxannonce;
      // modifié calcul !!!!!!
      $annee++;
    }
    $this->set("nbrInscrAn", $nbrInscrAn);
    $this->set("nbreserv", $nbreserv);

    /** DONNEES POUR TABLEAU **/
    // GERES
    $nbrInscrAntableau = 0;
    $nbreservtableau = 0;
    $nbrInscrtableau = $this->Reservations->find();
    $nbrInscrtableau->join([
      'Annonces' => [
        'table' => 'annonces',
        'type' => 'inner',
        'conditions' => ['Annonces.id = Reservations.annonce_id'],
      ]
    ]);        
    $nbrInscrtableau->where(['Reservations.statut = 90', 'Annonces.id_gestionnaires	<> 0']);
    $nbrInscrtableau->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)']);
    $nbrInscrtableau = $nbrInscrtableau->first();
    $nbrInscrAntableau = $nbrInscrtableau->nbrpersonne;
    $nbreservtableau = $nbrInscrtableau->nbrmaxannonce;     
    $this->set("nbrInscrAntableau", $nbrInscrAntableau);
    $this->set("nbreservtableau", $nbreservtableau);
    // NON GERES
    $nbrInscrAntableauNon = 0;
    $nbreservtableauNon = 0;
    $nbrInscrtableauNon = $this->Reservations->find();
    $nbrInscrtableauNon->join([
      'Annonces' => [
        'table' => 'annonces',
        'type' => 'inner',
        'conditions' => ['Annonces.id = Reservations.annonce_id'],
      ]
    ]);        
    $nbrInscrtableauNon->where(['Reservations.statut = 90', 'Annonces.id_gestionnaires = 0']);
    $nbrInscrtableauNon->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)']);
    $nbrInscrtableauNon = $nbrInscrtableauNon->first();
    $nbrInscrAntableauNon = $nbrInscrtableauNon->nbrpersonne;
    $nbreservtableauNon = $nbrInscrtableauNon->nbrmaxannonce;  
    $this->set("nbrInscrAntableauNon", $nbrInscrAntableauNon);
    $this->set("nbreservtableauNon", $nbreservtableauNon);
    
    // Liste gestionnaires
    $gestionnaires = $this->Gestionnaires->find('list', [
      'keyField' => 'id',
      'valueField' => 'name'
    ])->where(['role' => 'gestionnaire']);
    $this->set("gestionnaires", $gestionnaires);
  }
  /**
   * 
   */
  public function dataanneetatisremplissage($station, $village){
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    /** NBR LIT ANNONCES SYSTEME **/
    $this->loadModel("Annonces");
    $nbrLitAnnonce = $this->Annonces->find("all")->where(['Annonces.statut=50'])->select(['nbrmaxannonce' => 'SUM(Annonces.personnes_nb)'])->first();
    
    if(json_decode($this->request->query['gestionnairesvar']) == "tous"){
      $this->loadModel("Reservations");
      $nbrInscrAn = [];
      $annee = 2011;
      $gest_id = NULL;
      if($gest['G']['role'] == "gestionnaire"){
        $gest_id = $gest['G']['id'];
      }
      $month = date("n");
      if ($month<9){
          $year= date("Y");
      }
      else{
          $year = date("Y")+1;
      }
      while ($annee <= $year) {
        $nbrInscrAn[$annee] = 0;
        $nbreserv[$annee] = 0;
        for ($i=9; $i <= 12; $i++) {
            $nbrInscr = $this->Reservations->find();
            $nbrInscr->join([
              'Annonces' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => ['Annonces.id = Reservations.annonce_id'],
              ]
            ]);
            if($gest['G']['role'] == "gestionnaire"){            
                  $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
            }
            if($station != "tous" && $station != 0){
              $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
            }
            if($village != "tous" && $village != 0){
              $nbrInscr->where(['Annonces.village'=>$village]);
            }
          $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.($annee-1).'" AND MONTH(Reservations.dbt_at)="'.$i.'"');
          $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
          $nbrInscr = $nbrInscr->first();
          $nbrInscrAn[$annee] += $nbrInscr->nbrpersonne;
          // $nbreserv[$annee] += $nbrInscr->nbrmaxannonce;
          
        }
        for ($j=1; $j < 9; $j++) {
          $nbrInscr = $this->Reservations->find();
          $nbrInscr->join([
            'Annonces' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['Annonces.id = Reservations.annonce_id'],
            ]
          ]);
          if($gest['G']['role'] == "gestionnaire"){            
              $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
          }
          if($station != "tous" && $station != 0){
            $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
          }
          if($village != "tous" && $village != 0){
            $nbrInscr->where(['Annonces.village'=>$village]);
          }
          $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$annee.'" AND MONTH(Reservations.dbt_at)="'.$j.'"');
          $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
          $nbrInscr = $nbrInscr->first();
          $nbrInscrAn[$annee] += $nbrInscr->nbrpersonne;
          // $nbreserv[$annee] += $nbrInscr->nbrmaxannonce;
        }
        // modifié calcul !!!!!!
        $nbreserv[$annee] = $nbrLitAnnonce->nbrmaxannonce;
        // modifié calcul !!!!!!
        $annee++;
      }
    }else{
      foreach (json_decode($this->request->query['gestionnairesvar']) as $value) {
        $this->loadModel("Reservations");
        $nbrInscrAn[$value] = [];
        $annee = 2011;
        
        $month = date("n");
        if ($month<9){
            $year= date("Y");
        }
        else{
            $year = date("Y")+1;
        }
        while ($annee <= $year) {
          $nbrInscrAn[$value][$annee] = 0;
          $nbreserv[$value][$annee] = 0;
          for ($i=9; $i <= 12; $i++) {
              $nbrInscr = $this->Reservations->find();
              $nbrInscr->join([
                'Annonces' => [
                  'table' => 'annonces',
                  'type' => 'inner',
                  'conditions' => ['Annonces.id = Reservations.annonce_id'],
                ]
              ]);

              $nbrInscr->where(['Annonces.id_gestionnaires'=>$value]);

              if($station != "tous" && $station != 0){
                $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
              }
              if($village != "tous" && $village != 0){
                $nbrInscr->where(['Annonces.village'=>$village]);
              }
            $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.($annee-1).'" AND MONTH(Reservations.dbt_at)="'.$i.'"');
            $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
            $nbrInscr = $nbrInscr->first();
            $nbrInscrAn[$value][$annee] += $nbrInscr->nbrpersonne;
            // $nbreserv[$value][$annee] += $nbrInscr->nbrmaxannonce;
            
          }
          for ($j=1; $j < 9; $j++) {
            $nbrInscr = $this->Reservations->find();
            $nbrInscr->join([
              'Annonces' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => ['Annonces.id = Reservations.annonce_id'],
              ]
            ]);
                       
            $nbrInscr->where(['Annonces.id_gestionnaires'=>$value]);
            
            if($station != "tous" && $station != 0){
              $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
            }
            if($village != "tous" && $village != 0){
              $nbrInscr->where(['Annonces.village'=>$village]);
            }
            $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$annee.'" AND MONTH(Reservations.dbt_at)="'.$j.'"');
            $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
            $nbrInscr = $nbrInscr->first();
            $nbrInscrAn[$value][$annee] += $nbrInscr->nbrpersonne;
            // $nbreserv[$value][$annee] += $nbrInscr->nbrmaxannonce;
          }
          // modifié calcul !!!!!!
          $nbreserv[$annee] = $nbrLitAnnonce->nbrmaxannonce;
          // modifié calcul !!!!!!
          $annee++;
        }
      }
    }
    
    $this->set("nbrInscrAn", $nbrInscrAn);
    $this->set("nbreserv", $nbreserv);

    /** DONNEES POUR TABLEAU **/
    // GERES
    $nbrInscrAntableau = 0;
    $nbreservtableau = 0;
    $nbrInscrtableau = $this->Reservations->find();
    $nbrInscrtableau->join([
      'Annonces' => [
        'table' => 'annonces',
        'type' => 'inner',
        'conditions' => ['Annonces.id = Reservations.annonce_id'],
      ]
    ]);  
    if($station != "tous" && $station != 0){
      $nbrInscrtableau->where(['Annonces.lieugeo_id'=>$station]);
    }
    if($village != "tous" && $village != 0){
      $nbrInscrtableau->where(['Annonces.village'=>$village]);
    }      
    $nbrInscrtableau->where(['Reservations.statut = 90', 'Annonces.id_gestionnaires	<> 0']);
    $nbrInscrtableau->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)']);
    $nbrInscrtableau = $nbrInscrtableau->first();
    $nbrInscrAntableau = $nbrInscrtableau->nbrpersonne;
    $nbreservtableau = $nbrInscrtableau->nbrmaxannonce;     
    $this->set("nbrInscrAntableau", $nbrInscrAntableau);
    $this->set("nbreservtableau", $nbreservtableau);
    // NON GERES
    $nbrInscrAntableauNon = 0;
    $nbreservtableauNon = 0;
    $nbrInscrtableauNon = $this->Reservations->find();
    $nbrInscrtableauNon->join([
      'Annonces' => [
        'table' => 'annonces',
        'type' => 'inner',
        'conditions' => ['Annonces.id = Reservations.annonce_id'],
      ]
    ]); 
    if($station != "tous" && $station != 0){
      $nbrInscrtableauNon->where(['Annonces.lieugeo_id'=>$station]);
    }
    if($village != "tous" && $village != 0){
      $nbrInscrtableauNon->where(['Annonces.village'=>$village]);
    }        
    $nbrInscrtableauNon->where(['Reservations.statut = 90', 'Annonces.id_gestionnaires = 0']);
    $nbrInscrtableauNon->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)']);
    $nbrInscrtableauNon = $nbrInscrtableauNon->first();
    $nbrInscrAntableauNon = $nbrInscrtableauNon->nbrpersonne;
    $nbreservtableauNon = $nbrInscrtableauNon->nbrmaxannonce;  
    $this->set("nbrInscrAntableauNon", $nbrInscrAntableauNon);
    $this->set("nbreservtableauNon", $nbreservtableauNon);
  }
  /**
   * 
   */
  public function datamoisstatisremplissage($id, $station, $village){
    $this->viewBuilder()->layout(false);
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->loadModel("Reservations");
    /** NBR LIT ANNONCES SYSTEME **/
    $this->loadModel("Annonces");
    $nbrLitAnnonce = $this->Annonces->find("all")->where(['Annonces.statut=50'])->select(['nbrmaxannonce' => 'SUM(Annonces.personnes_nb)'])->first();
    
    if(json_decode($this->request->query['gestionnairesvar']) == "tous"){      
      $nbrInscrAn = [];
      $nbreserv = [];
      for ($mois=9; $mois <= 12; $mois++) {
        $nbrInscr = $this->Reservations->find();
        $nbrInscr->join([
          'Annonces' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['Annonces.id = Reservations.annonce_id'],
            ]
        ]);
        if($gest['G']['role'] == "gestionnaire"){          
          $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
        }
        if($station != "tous" && $station != 0){
          $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
        }
        if($village != "tous" && $village != 0){
          $nbrInscr->where(['Annonces.village'=>$village]);
        }
        $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.($id-1).'" AND MONTH(Reservations.dbt_at)="'.$mois.'"');
        $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
        $nbrInscr = $nbrInscr->first();
        $nbrInscrAn[] = $nbrInscr->nbrpersonne;
        // $nbreserv[] = $nbrInscr->nbrmaxannonce;
        // modifié calcul !!!!!!
        $nbreserv[] = $nbrLitAnnonce->nbrmaxannonce;
        // modifié calcul !!!!!!
      }
      for ($moi=1; $moi < 9; $moi++) {
        $nbrInscr = $this->Reservations->find();
        $nbrInscr->join([
          'Annonces' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['Annonces.id = Reservations.annonce_id'],
            ]
        ]);
        if($gest['G']['role'] == "gestionnaire"){          
          $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
        }
        if($station != "tous" && $station != 0){
          $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
        }
        if($village != "tous" && $village != 0){
          $nbrInscr->where(['Annonces.village'=>$village]);
        }
        $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$id.'" AND MONTH(Reservations.dbt_at)="'.$moi.'"');
        $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
        $nbrInscr = $nbrInscr->first();
        $nbrInscrAn[] = $nbrInscr->nbrpersonne;
        // $nbreserv[] = $nbrInscr->nbrmaxannonce;
        // modifié calcul !!!!!!
        $nbreserv[] = $nbrLitAnnonce->nbrmaxannonce;
        // modifié calcul !!!!!!
      }
    }else{
      foreach (json_decode($this->request->query['gestionnairesvar']) as $value){
        $nbrInscrAn[$value] = [];
        $nbreserv[$value] = [];
        for ($mois=9; $mois <= 12; $mois++) {
          $nbrInscr = $this->Reservations->find();
          $nbrInscr->join([
            'Annonces' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => ['Annonces.id = Reservations.annonce_id'],
              ]
          ]);
          
          $nbrInscr->where(['Annonces.id_gestionnaires'=>$value]);

          if($station != "tous" && $station != 0){
            $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
          }
          if($village != "tous" && $village != 0){
            $nbrInscr->where(['Annonces.village'=>$village]);
          }
          $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.($id-1).'" AND MONTH(Reservations.dbt_at)="'.$mois.'"');
          $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
          $nbrInscr = $nbrInscr->first();
          $nbrInscrAn[$value][] = $nbrInscr->nbrpersonne;
          // $nbreserv[$value][] = $nbrInscr->nbrmaxannonce;
          // modifié calcul !!!!!!
          $nbreserv[$value][] = $nbrLitAnnonce->nbrmaxannonce;
          // modifié calcul !!!!!!
        }
        for ($moi=1; $moi < 9; $moi++) {
          $nbrInscr = $this->Reservations->find();
          $nbrInscr->join([
            'Annonces' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => ['Annonces.id = Reservations.annonce_id'],
              ]
          ]);

          $nbrInscr->where(['Annonces.id_gestionnaires'=>$value]);

          if($station != "tous" && $station != 0){
            $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
          }
          if($village != "tous" && $village != 0){
            $nbrInscr->where(['Annonces.village'=>$village]);
          }
          $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$id.'" AND MONTH(Reservations.dbt_at)="'.$moi.'"');
          $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
          $nbrInscr = $nbrInscr->first();
          $nbrInscrAn[$value][] = $nbrInscr->nbrpersonne;
          // $nbreserv[$value][] = $nbrInscr->nbrmaxannonce;
          // modifié calcul !!!!!!
          $nbreserv[$value][] = $nbrLitAnnonce->nbrmaxannonce;
          // modifié calcul !!!!!!
        }
      }
    }

    $this->set("nbrInscrAnMois", $nbrInscrAn);
    $this->set("nbreserv", $nbreserv);

    /** DONNEES POUR TABLEAU **/
    // GERES
    $nbrInscrAntableau = 0;
    $nbreservtableau = 0;
    $nbrInscrtableau = $this->Reservations->find();
    $nbrInscrtableau->join([
      'Annonces' => [
        'table' => 'annonces',
        'type' => 'inner',
        'conditions' => ['Annonces.id = Reservations.annonce_id'],
      ]
    ]);  
    if($station != "tous" && $station != 0){
      $nbrInscrtableau->where(['Annonces.lieugeo_id'=>$station]);
    }
    if($village != "tous" && $village != 0){
      $nbrInscrtableau->where(['Annonces.village'=>$village]);
    }      
    $nbrInscrtableau->where(['Reservations.dbt_at >= "'.($id-1).'-09-01"', 'Reservations.dbt_at <= "'.($id).'-08-31"', 'Reservations.statut = 90', 'Annonces.id_gestionnaires	<> 0']);
    $nbrInscrtableau->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)']);
    $nbrInscrtableau = $nbrInscrtableau->first();
    $nbrInscrAntableau = $nbrInscrtableau->nbrpersonne;
    $nbreservtableau = $nbrInscrtableau->nbrmaxannonce;     
    $this->set("nbrInscrAntableau", $nbrInscrAntableau);
    $this->set("nbreservtableau", $nbreservtableau);
    // NON GERES
    $nbrInscrAntableauNon = 0;
    $nbreservtableauNon = 0;
    $nbrInscrtableauNon = $this->Reservations->find();
    $nbrInscrtableauNon->join([
      'Annonces' => [
        'table' => 'annonces',
        'type' => 'inner',
        'conditions' => ['Annonces.id = Reservations.annonce_id'],
      ]
    ]); 
    if($station != "tous" && $station != 0){
      $nbrInscrtableauNon->where(['Annonces.lieugeo_id'=>$station]);
    }
    if($village != "tous" && $village != 0){
      $nbrInscrtableauNon->where(['Annonces.village'=>$village]);
    }        
    $nbrInscrtableauNon->where(['Reservations.dbt_at >= "'.($id-1).'-09-01"', 'Reservations.dbt_at <= "'.($id).'-08-31"', 'Reservations.statut = 90', 'Annonces.id_gestionnaires = 0']);
    $nbrInscrtableauNon->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)']);
    $nbrInscrtableauNon = $nbrInscrtableauNon->first();
    $nbrInscrAntableauNon = $nbrInscrtableauNon->nbrpersonne;
    $nbreservtableauNon = $nbrInscrtableauNon->nbrmaxannonce;  
    $this->set("nbrInscrAntableauNon", $nbrInscrAntableauNon);
    $this->set("nbreservtableauNon", $nbreservtableauNon);
  }
  /**
   * 
   */
  public function datasemaineremplissage($station, $village, $annee, $mois)
  {
    $this->viewBuilder()->layout(false);
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->loadModel("Reservations");
    if($mois >= 9 && $mois <= 12) $annee = $annee-1;
    /** NBR LIT ANNONCES SYSTEME **/
    $this->loadModel("Annonces");
    $nbrLitAnnonce = $this->Annonces->find("all")->where(['Annonces.statut=50'])->select(['nbrmaxannonce' => 'SUM(Annonces.personnes_nb)'])->first();
    
    if(json_decode($this->request->query['gestionnairesvar']) == "tous"){
      $time = mktime(0, 0, 0, $mois, 1, $annee);
      $firstWednesday = strtotime('Saturday', $time);
      $nbrInscrAn = [];
      $nbreserv = [];
      $nbrInscrLabel = [];
      $moisperid =  strftime("%d", $firstWednesday);
      if($moisperid > 1){
        $deb = 1;
        $fin = $moisperid;
        $nbrInscr = $this->Reservations->find();
        $nbrInscr->join([
          'Annonces' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['Annonces.id = Reservations.annonce_id'],
            ]
        ]);
        if($gest['G']['role'] == "gestionnaire"){        
          $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
        }
        if($station != "tous" && $station != 0){
          $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
        }
        if($village != "tous" && $village != 0){
          $nbrInscr->where(['Annonces.village'=>$village]);
        }
        $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$annee.'" AND MONTH(Reservations.dbt_at)="'.$mois.'" AND Reservations.dbt_at >= "'.$annee.'-'.$mois.'-'.$deb.'" AND Reservations.dbt_at < "'.$annee.'-'.$mois.'-'.$fin.'"');
        $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
        $nbrInscr = $nbrInscr->first();
        $nbrInscrAn[] = $nbrInscr->nbrpersonne;
        // $nbreserv[] = $nbrInscr->nbrmaxannonce;
        // modifié calcul !!!!!!
        $nbreserv[] = $nbrLitAnnonce->nbrmaxannonce;
        // modifié calcul !!!!!!
        $nbrInscrLabel[] = $deb." - ".($fin-1);
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
        $nbrInscr = $this->Reservations->find();
        $nbrInscr->join([
          'Annonces' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['Annonces.id = Reservations.annonce_id'],
            ]
        ]);
        if($gest['G']['role'] == "gestionnaire"){
          $nbrInscr->where(['Annonces.id_gestionnaires'=>$gest['G']['id']]);
        }
        if($station != "tous" && $station != 0){
          $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
        }
        if($village != "tous" && $village != 0){
          $nbrInscr->where(['Annonces.village'=>$village]);
        }
        $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$annee.'" AND MONTH(Reservations.dbt_at)="'.$mois.'" AND Reservations.dbt_at >= "'.$annee.'-'.$mois.'-'.$deb.'" AND Reservations.dbt_at <= "'.$annee.'-'.$mois.'-'.$fin.'"');
        $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
        $nbrInscr = $nbrInscr->first();
        $nbrInscrAn[] = $nbrInscr->nbrpersonne;
        // $nbreserv[] = $nbrInscr->nbrmaxannonce;
        // modifié calcul !!!!!!
        $nbreserv[] = $nbrLitAnnonce->nbrmaxannonce;
        // modifié calcul !!!!!!
        $nbrInscrLabel[] = $deb." - ".$fin;
        $firstWednesday = strtotime("+1 day", $afterweek);
        $moisperid = strftime("%d", $firstWednesday);
      }
    }else{
      foreach (json_decode($this->request->query['gestionnairesvar']) as $value){
        $time = mktime(0, 0, 0, $mois, 1, $annee);
        $firstWednesday = strtotime('Saturday', $time);
        $nbrInscrAn[$value] = [];
        $nbreserv[$value] = [];
        $nbrInscrLabel[$value] = [];
        $moisperid =  strftime("%d", $firstWednesday);
        if($moisperid > 1){
          $deb = 1;
          $fin = $moisperid;
          $nbrInscr = $this->Reservations->find();
          $nbrInscr->join([
            'Annonces' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => ['Annonces.id = Reservations.annonce_id'],
              ]
          ]);
          
          $nbrInscr->where(['Annonces.id_gestionnaires'=>$value]);

          if($station != "tous" && $station != 0){
            $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
          }
          if($village != "tous" && $village != 0){
            $nbrInscr->where(['Annonces.village'=>$village]);
          }
          $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$annee.'" AND MONTH(Reservations.dbt_at)="'.$mois.'" AND Reservations.dbt_at >= "'.$annee.'-'.$mois.'-'.$deb.'" AND Reservations.dbt_at < "'.$annee.'-'.$mois.'-'.$fin.'"');
          $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
          $nbrInscr = $nbrInscr->first();
          $nbrInscrAn[$value][] = $nbrInscr->nbrpersonne;
          // $nbreserv[$value][] = $nbrInscr->nbrmaxannonce;
          // modifié calcul !!!!!!
          $nbreserv[$value][] = $nbrLitAnnonce->nbrmaxannonce;
          // modifié calcul !!!!!!
          $nbrInscrLabel[$value][] = $deb." - ".($fin-1);
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
          $nbrInscr = $this->Reservations->find();
          $nbrInscr->join([
            'Annonces' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => ['Annonces.id = Reservations.annonce_id'],
              ]
          ]);
          
          $nbrInscr->where(['Annonces.id_gestionnaires'=>$value]);

          if($station != "tous" && $station != 0){
            $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
          }
          if($village != "tous" && $village != 0){
            $nbrInscr->where(['Annonces.village'=>$village]);
          }
          $nbrInscr->where('Reservations.statut = 90 AND YEAR(Reservations.dbt_at)="'.$annee.'" AND MONTH(Reservations.dbt_at)="'.$mois.'" AND Reservations.dbt_at >= "'.$annee.'-'.$mois.'-'.$deb.'" AND Reservations.dbt_at <= "'.$annee.'-'.$mois.'-'.$fin.'"');
          $nbrInscr->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)','nbr' => $nbrInscr->func()->count('*'), 'remplissage' => 'SUM((Reservations.nb_adultes+Reservations.nb_enfants)/Annonces.personnes_nb)']);
          $nbrInscr = $nbrInscr->first();
          $nbrInscrAn[$value][] = $nbrInscr->nbrpersonne;
          // $nbreserv[$value][] = $nbrInscr->nbrmaxannonce;
          // modifié calcul !!!!!!
          $nbreserv[$value][] = $nbrLitAnnonce->nbrmaxannonce;
          // modifié calcul !!!!!!
          $nbrInscrLabel[$value][] = $deb." - ".$fin;
          $firstWednesday = strtotime("+1 day", $afterweek);
          $moisperid = strftime("%d", $firstWednesday);
        }
      }
    }

    $this->set("nbrInscrAnSemaine", $nbrInscrAn);
    $this->set("labelsemaine", $nbrInscrLabel);
    $this->set("nbreserv", $nbreserv);

    /** DONNEES POUR TABLEAU **/
    // GERES
    $nbrInscrAntableau = 0;
    $nbreservtableau = 0;
    $nbrInscrtableau = $this->Reservations->find();
    $nbrInscrtableau->join([
      'Annonces' => [
        'table' => 'annonces',
        'type' => 'inner',
        'conditions' => ['Annonces.id = Reservations.annonce_id'],
      ]
    ]);  
    if($station != "tous" && $station != 0){
      $nbrInscrtableau->where(['Annonces.lieugeo_id'=>$station]);
    }
    if($village != "tous" && $village != 0){
      $nbrInscrtableau->where(['Annonces.village'=>$village]);
    }      
    $nbrInscrtableau->where(['Reservations.dbt_at >= "'.$annee.'-'.$mois.'-01"', 'Reservations.dbt_at <= "'.$annee.'-'.$mois.'-31"', 'Reservations.statut = 90', 'Annonces.id_gestionnaires	<> 0']);
    $nbrInscrtableau->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)']);
    $nbrInscrtableau = $nbrInscrtableau->first();
    $nbrInscrAntableau = $nbrInscrtableau->nbrpersonne;
    $nbreservtableau = $nbrInscrtableau->nbrmaxannonce;     
    $this->set("nbrInscrAntableau", $nbrInscrAntableau);
    $this->set("nbreservtableau", $nbreservtableau);
    // NON GERES
    $nbrInscrAntableauNon = 0;
    $nbreservtableauNon = 0;
    $nbrInscrtableauNon = $this->Reservations->find();
    $nbrInscrtableauNon->join([
      'Annonces' => [
        'table' => 'annonces',
        'type' => 'inner',
        'conditions' => ['Annonces.id = Reservations.annonce_id'],
      ]
    ]); 
    if($station != "tous" && $station != 0){
      $nbrInscrtableauNon->where(['Annonces.lieugeo_id'=>$station]);
    }
    if($village != "tous" && $village != 0){
      $nbrInscrtableauNon->where(['Annonces.village'=>$village]);
    }        
    $nbrInscrtableauNon->where(['Reservations.dbt_at >= "'.$annee.'-'.$mois.'-01"', 'Reservations.dbt_at <= "'.$annee.'-'.$mois.'-31"', 'Reservations.statut = 90', 'Annonces.id_gestionnaires = 0']);
    $nbrInscrtableauNon->select(['nbrpersonne' => 'SUM(Reservations.nb_adultes+Reservations.nb_enfants)','nbrmaxannonce' => 'SUM(Annonces.personnes_nb)']);
    $nbrInscrtableauNon = $nbrInscrtableauNon->first();
    $nbrInscrAntableauNon = $nbrInscrtableauNon->nbrpersonne;
    $nbreservtableauNon = $nbrInscrtableauNon->nbrmaxannonce;  
    $this->set("nbrInscrAntableauNon", $nbrInscrAntableauNon);
    $this->set("nbreservtableauNon", $nbreservtableauNon);
  }
  /**
   * 
   */
  public function datasemaineremplissagenew($station, $village, $from_date, $to_date)
  {
    $this->viewBuilder()->layout(false);
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->loadModel("Reservations");
    // Total max annonces
    $annTo = new Date($to_date);
    $this->loadModel("Annonces");
    $nbrLitAnnonce = $this->Annonces->find("all")->where(['(Annonces.statut=50 OR Annonces.statut=30)', 'Annonces.created_at < "'.$annTo->i18nFormat('yyyy-MM-dd').'"'])->select(['nbrmaxannonce' => 'SUM(Annonces.personnes_nb)']);
    if($station != "tous" && $station != 0){
      $nbrLitAnnonce->where(['Annonces.lieugeo_id'=>$station]);
    }
    if($village != "tous" && $village != 0){
      $nbrLitAnnonce->where(['Annonces.village'=>$village]);
    }
    if(json_decode($this->request->query['gestionnairesvar']) == "tous") {
      // $nbrLitAnnonce = $nbrLitAnnonce->first();
      if($gest['G']['role'] == "gestionnaire"){
        $arrayVillage = [];
        $gestionnaireVillage = $this->Gestionnaires->findById($gest['G']['id'])->contain('Villages')->first();
        foreach ($gestionnaireVillage->villages as $key) {
          array_push($arrayVillage, $key->id);
        }
        $nbrLitAnnonce->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
        // $nbrLitAnnonce = $nbrLitAnnonce->first();
      }
    }else{
      $arrayVillage = [];
      foreach (json_decode($this->request->query['gestionnairesvar']) as $gestionnaire){
        $gestionnaireVillage = $this->Gestionnaires->findById($gestionnaire)->contain('Villages')->first();
        foreach ($gestionnaireVillage->villages as $key) {
          array_push($arrayVillage, $key->id);
        }
      }
      $nbrLitAnnonce->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
      // $nbrLitAnnonce = $nbrLitAnnonce->first();
    }
    
    $nbrLitAnnonce = $nbrLitAnnonce->first();
    $annFrom = new Date($from_date);
    $diffAnn = $annTo->diff($annFrom)->days+1;
    $nbrLit = $nbrLitAnnonce->nbrmaxannonce;
    $nbrLitAnnonce = $nbrLitAnnonce->nbrmaxannonce * $diffAnn;
    
    if(json_decode($this->request->query['gestionnairesvar']) == "tous"){
      $end = $to_date;
      $dbt = new Date($from_date);
      $to_date=new Date($to_date);
      $time = mktime(0, 0, 0, $dbt->month, $dbt->day, $dbt->year);
      $firstWednesday = strtotime('Saturday', $time);
      $nbrInscrLabel = [];
      $nbrInscrAn = [];
      $nbreserv = [];
      $moisperid =  strftime("%d", $firstWednesday);
      if(new Date($firstWednesday) >= $dbt){
        $deb = $dbt->day;
        $fin = $moisperid;
        $date_debut = $dbt;        
        if(new Date($firstWednesday) >= $to_date){
          $date_fin = $to_date;
          $moisperid =  strftime("%d", strtotime($end));
          $fin = $moisperid;
        } else {
          $date_fin = new Date($firstWednesday);
          $date_fin = $date_fin->modify('-1 days');
          $fin = $fin-1;
        }         
        if($date_fin >= $dbt){
          // traitement requete
          $nbrInscr = $this->Reservations->find()->contain(["Annonces"]);
         
          if($gest['G']['role'] == "gestionnaire"){
            $arrayVillage = [];
            $gestionnaireVillage = $this->Gestionnaires->findById($gest['G']['id'])->contain('Villages')->first();
            foreach ($gestionnaireVillage->villages as $key) {
              array_push($arrayVillage, $key->id);
            }
            $nbrInscr->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
          }
          if($station != "tous" && $station != 0){
            $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
          }
          if($village != "tous" && $village != 0){
            $nbrInscr->where(['Annonces.village'=>$village]);
          }
          $nbrInscr->where(['Annonces.created_at < "'.$date_fin->i18nFormat('yyyy-MM-dd').'"']);
          $nbrInscr->where('Reservations.statut = 90 AND ((Reservations.dbt_at <= "'.$date_debut->i18nFormat('yyyy-MM-dd').'" AND Reservations.fin_at > "'.$date_debut->i18nFormat('yyyy-MM-dd').'") OR (Reservations.dbt_at >= "'.$date_debut->i18nFormat('yyyy-MM-dd').'" AND Reservations.dbt_at <= "'.$date_fin->i18nFormat('yyyy-MM-dd').'"))');
          $nbrrpersreser = 0;
          foreach ($nbrInscr as $value) {
            if(new Date($value->dbt_at) < $date_debut) $dbtperiode = $date_debut;
            else $dbtperiode = new Date($value->dbt_at);
            if(new Date($value->fin_at) > $date_fin) $finperiode = $date_fin;
            else $finperiode = new Date($value->fin_at);
            $nbrDays = $finperiode->diff($dbtperiode)->days+1;
            if(($value->nb_adultes + $value->nb_enfants) <= $value['annonce']['personnes_nb']) $nbrrpersreser += ($value->nb_adultes + $value->nb_enfants)*$nbrDays;
            else $nbrrpersreser += ($value['annonce']['personnes_nb'])*$nbrDays;
            // $nbrrpersreser += ($value->nb_adultes + $value->nb_enfants)*$nbrDays;
          }      
          $nbrInscrAn[] = $nbrrpersreser;
          $nbreserv[] = $nbrLit*(($date_fin->diff($date_debut))->days+1);
          $nbrInscrLabel[] = $deb." - ".$fin;
        }
      
      } 

      $end = false;  
      if($date_fin != $to_date){
        while ($dbt < $to_date && $end === false) {
          $date_debut = $date_fin->modify('+1 days');
          $datedebut2 = clone $date_debut;
          $deb = $moisperid;
          $afterweek = strtotime("+6 day", $firstWednesday);
          if(new Date($afterweek) >= $to_date){
            $fin = $to_date->day;
            $date_fin = $to_date;
            $end = true;
          } else {
            $fin = strftime("%d", $afterweek);
            $date_fin = $datedebut2->modify('+6 days');
          }
          if($date_fin >= $date_debut){
            // traitement requete
            $nbrInscr = $this->Reservations->find()->contain(["Annonces"]);
            
            if($gest['G']['role'] == "gestionnaire"){
              $arrayVillage = [];
              $gestionnaireVillage = $this->Gestionnaires->findById($gest['G']['id'])->contain('Villages')->first();
              foreach ($gestionnaireVillage->villages as $key) {
                array_push($arrayVillage, $key->id);
              }
              $nbrInscr->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
            }
            if($station != "tous" && $station != 0){
              $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
            }
            if($village != "tous" && $village != 0){
              $nbrInscr->where(['Annonces.village'=>$village]);
            }
            $nbrInscr->where(['Annonces.created_at < "'.$date_fin->i18nFormat('yyyy-MM-dd').'"']);
            $nbrInscr->where('Reservations.statut = 90 AND ((Reservations.dbt_at <= "'.$date_debut->i18nFormat('yyyy-MM-dd').'" AND Reservations.fin_at > "'.$date_debut->i18nFormat('yyyy-MM-dd').'") OR (Reservations.dbt_at >= "'.$date_debut->i18nFormat('yyyy-MM-dd').'" AND Reservations.dbt_at <= "'.$date_fin->i18nFormat('yyyy-MM-dd').'"))');
            $nbrrpersreser = 0;
            foreach ($nbrInscr as $value) {
              if(new Date($value->dbt_at) < $date_debut) $dbtperiode = $date_debut;
              else $dbtperiode = new Date($value->dbt_at);
              if(new Date($value->fin_at) > $date_fin) $finperiode = $date_fin;
              else $finperiode = new Date($value->fin_at);
              $nbrDays = $finperiode->diff($dbtperiode)->days+1;
              if(($value->nb_adultes + $value->nb_enfants) <= $value['annonce']['personnes_nb']) $nbrrpersreser += ($value->nb_adultes + $value->nb_enfants)*$nbrDays;
              else $nbrrpersreser += ($value['annonce']['personnes_nb'])*$nbrDays;
              // $nbrrpersreser += ($value->nb_adultes + $value->nb_enfants)*$nbrDays;
            }      
            $nbrInscrAn[] = $nbrrpersreser;
            $nbreserv[] = $nbrLit*(($date_fin->diff($date_debut))->days+1);

            $nbrInscrLabel[] = $deb." - ".$fin;
            $firstWednesday = strtotime("+1 day", $afterweek);
            $moisperid = strftime("%d", $firstWednesday);
            $dbt = $dbt->modify('+6 days');
          }
                  
        }
      }
      
    }else{
      foreach (json_decode($this->request->query['gestionnairesvar']) as $gestionnaire){
        $end = $to_date;
        $dbt = new Date($from_date);
        $to_date=new Date($to_date);
        $time = mktime(0, 0, 0, $dbt->month, $dbt->day, $dbt->year);
        $firstWednesday = strtotime('Saturday', $time);
        $nbrInscrLabel[$gestionnaire] = [];
        $nbrInscrAn[$gestionnaire] = [];
        $nbreserv[$gestionnaire] = [];
        $moisperid =  strftime("%d", $firstWednesday);
        if(new Date($firstWednesday) >= $dbt){
          $deb = $dbt->day;
          $fin = $moisperid;
          $date_debut = $dbt;
          if(new Date($firstWednesday) >= $to_date){
            $date_fin = $to_date;
            $moisperid =  strftime("%d", strtotime($end));
            $fin = $moisperid;
          } else {
            $date_fin = new Date($firstWednesday);
            $date_fin = $date_fin->modify('-1 days');
            $fin = $fin-1;
          }  
          if($date_fin >= $dbt){
            // traitement requete
            $nbrInscr = $this->Reservations->find()->contain(["Annonces"]);
            
            $arrayVillage = [];
            $gestionnaireVillage = $this->Gestionnaires->findById($gestionnaire)->contain('Villages')->first();
            foreach ($gestionnaireVillage->villages as $key) {
              array_push($arrayVillage, $key->id);
            }
            $nbrInscr->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);

            if($gest['G']['role'] == "gestionnaire"){
              $arrayVillage = [];
              $gestionnaireVillage = $this->Gestionnaires->findById($gest['G']['id'])->contain('Villages')->first();
              foreach ($gestionnaireVillage->villages as $key) {
                array_push($arrayVillage, $key->id);
              }
              $nbrInscr->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
            }
            if($station != "tous" && $station != 0){
              $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
            }
            if($village != "tous" && $village != 0){
              $nbrInscr->where(['Annonces.village'=>$village]);
            }
            $nbrInscr->where(['Annonces.created_at < "'.$date_fin->i18nFormat('yyyy-MM-dd').'"']);
            $nbrInscr->where('Reservations.statut = 90 AND ((Reservations.dbt_at <= "'.$date_debut->i18nFormat('yyyy-MM-dd').'" AND Reservations.fin_at > "'.$date_debut->i18nFormat('yyyy-MM-dd').'") OR (Reservations.dbt_at >= "'.$date_debut->i18nFormat('yyyy-MM-dd').'" AND Reservations.dbt_at <= "'.$date_fin->i18nFormat('yyyy-MM-dd').'"))');
            // print_r($nbrInscr);
            $nbrrpersreser = 0;
            foreach ($nbrInscr as $value) {
              if(new Date($value->dbt_at) < $date_debut) $dbtperiode = $date_debut;
              else $dbtperiode = new Date($value->dbt_at);
              if(new Date($value->fin_at) > $date_fin) $finperiode = $date_fin;
              else $finperiode = new Date($value->fin_at);
              $nbrDays = $finperiode->diff($dbtperiode)->days+1;
              if(($value->nb_adultes + $value->nb_enfants) <= $value['annonce']['personnes_nb']) $nbrrpersreser += ($value->nb_adultes + $value->nb_enfants)*$nbrDays;
              else $nbrrpersreser += ($value['annonce']['personnes_nb'])*$nbrDays;
              // $nbrrpersreser += ($value->nb_adultes + $value->nb_enfants)*$nbrDays;
            }      
            $nbrInscrAn[$gestionnaire][] = $nbrrpersreser;
            $nbreserv[$gestionnaire][] = $nbrLit*(($date_fin->diff($date_debut))->days+1);
            $nbrInscrLabel[$gestionnaire][] = $deb." - ".$fin;
          }      
          
        }   
        
        $end = false;  
        if($date_fin != $to_date){
          while ($dbt < $to_date && $end === false) {
            $date_debut = $date_fin->modify('+1 days');
            $datedebut2 = clone $date_debut;
            $deb = $moisperid;
            $afterweek = strtotime("+6 day", $firstWednesday);
            if(new Date($afterweek) >= $to_date){
              $fin = $to_date->day;
              $date_fin = $to_date;
              $end = true;
            } else {
              $fin = strftime("%d", $afterweek);
              $date_fin = $datedebut2->modify('+6 days');
            }
            if($date_fin >= $date_debut){
              // traitement requete
              $nbrInscr = $this->Reservations->find()->contain(["Annonces"]);
              
              $arrayVillage = [];
              $gestionnaireVillage = $this->Gestionnaires->findById($gestionnaire)->contain('Villages')->first();
              foreach ($gestionnaireVillage->villages as $key) {
                array_push($arrayVillage, $key->id);
              }
              $nbrInscr->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);

              if($gest['G']['role'] == "gestionnaire"){
                $arrayVillage = [];
                $gestionnaireVillage = $this->Gestionnaires->findById($gest['G']['id'])->contain('Villages')->first();
                foreach ($gestionnaireVillage->villages as $key) {
                  array_push($arrayVillage, $key->id);
                }
                $nbrInscr->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
              }
              if($station != "tous" && $station != 0){
                $nbrInscr->where(['Annonces.lieugeo_id'=>$station]);
              }
              if($village != "tous" && $village != 0){
                $nbrInscr->where(['Annonces.village'=>$village]);
              }
              $nbrInscr->where(['Annonces.created_at < "'.$date_fin->i18nFormat('yyyy-MM-dd').'"']);
              $nbrInscr->where('Reservations.statut = 90 AND ((Reservations.dbt_at <= "'.$date_debut->i18nFormat('yyyy-MM-dd').'" AND Reservations.fin_at > "'.$date_debut->i18nFormat('yyyy-MM-dd').'") OR (Reservations.dbt_at >= "'.$date_debut->i18nFormat('yyyy-MM-dd').'" AND Reservations.dbt_at <= "'.$date_fin->i18nFormat('yyyy-MM-dd').'"))');
              $nbrrpersreser = 0;
              foreach ($nbrInscr as $value) {
                if(new Date($value->dbt_at) < $date_debut) $dbtperiode = $date_debut;
                else $dbtperiode = new Date($value->dbt_at);
                if(new Date($value->fin_at) > $date_fin) $finperiode = $date_fin;
                else $finperiode = new Date($value->fin_at);
                $nbrDays = $finperiode->diff($dbtperiode)->days+1;
                if(($value->nb_adultes + $value->nb_enfants) <= $value['annonce']['personnes_nb']) $nbrrpersreser += ($value->nb_adultes + $value->nb_enfants)*$nbrDays;
                else $nbrrpersreser += ($value['annonce']['personnes_nb'])*$nbrDays;
                // $nbrrpersreser += ($value->nb_adultes + $value->nb_enfants)*$nbrDays;
              }      
              $nbrInscrAn[$gestionnaire][] = $nbrrpersreser;
              $nbreserv[$gestionnaire][] = $nbrLit*(($date_fin->diff($date_debut))->days+1); 
              $nbrInscrLabel[$gestionnaire][] = $deb." - ".$fin;

              $firstWednesday = strtotime("+1 day", $afterweek);
              $moisperid = strftime("%d", $firstWednesday);
              $dbt = $dbt->modify('+6 days');      
            }
              
          }
        }
      }
    }
    // print_r($nbreserv);
    // print_r($nbrInscrAn);
    $this->set("nbrInscrAnSemaine", $nbrInscrAn);
    $this->set("labelsemaine", $nbrInscrLabel);
    $this->set("nbreserv", $nbreserv);

    /** DONNEES POUR TABLEAU **/
    // Total max annonces
    $this->loadModel("Annonces");
    $nbrLitAnnoncegere = $this->Annonces->find("all");
    if(json_decode($this->request->query['gestionnairesvar']) == "tous"){
      if($gest['G']['role'] == "gestionnaire"){
        $arrayVillage = [];
        $gestionnaireVillage = $this->Gestionnaires->findById($gest['G']['id'])->contain('Villages')->first();
        foreach ($gestionnaireVillage->villages as $key) {
          array_push($arrayVillage, $key->id);
        }
        $nbrLitAnnoncegere->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
        $nbrLitAnnoncegere->where(['Annonces.id_gestionnaires' => $gest['G']['id']]);
      }else{
        $nbrLitAnnoncegere->where(['Annonces.id_gestionnaires <> 0']);
      }
      
    }else{
      $arrayVillage = [];
      foreach (json_decode($this->request->query['gestionnairesvar']) as $gestionnaire){
        $nbrLitAnnoncegere->orWhere(['Annonces.id_gestionnaires' => $gestionnaire]);
        $gestionnaireVillage = $this->Gestionnaires->findById($gestionnaire)->contain('Villages')->first();
        foreach ($gestionnaireVillage->villages as $key) {
          array_push($arrayVillage, $key->id);
        }
      }
      $nbrLitAnnoncegere->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
    }
    
    $nbrLitAnnoncegere->where(['(Annonces.statut=50 OR Annonces.statut=30)']);  
    $nbrLitAnnoncegere->where(['Annonces.created_at < "'.$annTo->i18nFormat('yyyy-MM-dd').'"']); 
    if($station != "tous" && $station != 0){
      $nbrLitAnnoncegere->where(['Annonces.lieugeo_id'=>$station]);
    }
    if($village != "tous" && $village != 0){
      $nbrLitAnnoncegere->where(['Annonces.village'=>$village]);
    } 
    $nbrLitAnnoncegere->select(['nbrmaxannonce' => 'SUM(Annonces.personnes_nb)']);
    $nbrLitAnnoncegere = $nbrLitAnnoncegere->first();
    $nbrpersansannonce = $nbrLitAnnoncegere->nbrmaxannonce;
    $nbrdayAnnonce = $diffAnn;
    $nbrLitAnnoncegere = $nbrLitAnnoncegere->nbrmaxannonce * $diffAnn;
    // GERES
    $nbrInscrAntableau = [];
    $nbreservtableau = [];
    $nbrInscrtableau = $this->Reservations->find()->contain(["Annonces"]);
      
    if(json_decode($this->request->query['gestionnairesvar']) == "tous"){
      if($gest['G']['role'] == "gestionnaire"){
        $arrayVillage = [];
        $gestionnaireVillage = $this->Gestionnaires->findById($gest['G']['id'])->contain('Villages')->first();
        foreach ($gestionnaireVillage->villages as $key) {
          array_push($arrayVillage, $key->id);
        }
        $nbrInscrtableau->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
        $nbrInscrtableau->where(['Annonces.id_gestionnaires' => $gest['G']['id']]);
      } else{
        $nbrInscrtableau->where(['Annonces.id_gestionnaires <> 0']);
      }      
    }else{
      $arrayVillage = [];
      foreach (json_decode($this->request->query['gestionnairesvar']) as $gestionnaire){
        $nbrInscrtableau->orWhere(['Annonces.id_gestionnaires' => $gestionnaire]);
        $gestionnaireVillage = $this->Gestionnaires->findById($gestionnaire)->contain('Villages')->first();
        foreach ($gestionnaireVillage->villages as $key) {
          array_push($arrayVillage, $key->id);
        }
      }
      $nbrInscrtableau->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
    }
    
    if($station != "tous" && $station != 0){
      $nbrInscrtableau->where(['Annonces.lieugeo_id'=>$station]);
    }
    if($village != "tous" && $village != 0){
      $nbrInscrtableau->where(['Annonces.village'=>$village]);
    } 
    $nbrInscrtableau->where(['Annonces.created_at < "'.$annTo->i18nFormat('yyyy-MM-dd').'"']); 
    $nbrInscrtableau->where(['Reservations.statut = 90 AND ((Reservations.dbt_at <= "'.$annFrom->i18nFormat('yyyy-MM-dd').'" AND Reservations.fin_at > "'.$annFrom->i18nFormat('yyyy-MM-dd').'") OR (Reservations.dbt_at >= "'.$annFrom->i18nFormat('yyyy-MM-dd').'" AND Reservations.dbt_at <= "'.$annTo->i18nFormat('yyyy-MM-dd').'"))']);
    $nbrrpersreser = 0;
    $nbrpersans = 0;
    $nbrday = 0;
    // print_r($nbrInscrtableau);
    foreach ($nbrInscrtableau as $value) {
      if(new Date($value->dbt_at) < $annFrom) $dbtperiode = $annFrom;
      else $dbtperiode = new Date($value->dbt_at);
      if(new Date($value->fin_at) > $annTo) $finperiode = $annTo;
      else $finperiode = new Date($value->fin_at);
      $nbrDays = $finperiode->diff($dbtperiode)->days+1;
      if(($value->nb_adultes + $value->nb_enfants) <= $value['annonce']['personnes_nb']){
        $nbrrpersreser += ($value->nb_adultes + $value->nb_enfants)*$nbrDays;
        $nbrpersans += $value->nb_adultes + $value->nb_enfants;
      } else{
        $nbrrpersreser += ($value['annonce']['personnes_nb'])*$nbrDays;
        $nbrpersans += $value['annonce']['personnes_nb'];
      }
      // $nbrrpersreser += ($value->nb_adultes + $value->nb_enfants)*$nbrDays;
      // $nbrpersans += $value->nb_adultes + $value->nb_enfants;
      $nbrday += $nbrDays;
    }   
    $nbrInscrAntableau['total'] = $nbrrpersreser;
    $nbrInscrAntableau['nbrpersans'] = $nbrpersans;
    $nbrInscrAntableau['nbrday'] = $nbrday;
    $nbreservtableau['total'] = $nbrLitAnnoncegere; 
    $nbreservtableau['nbrpersans'] = $nbrpersansannonce; 
    $nbreservtableau['nbrday'] = $nbrdayAnnonce; 
    $this->set("nbrInscrAntableau", $nbrInscrAntableau);
    $this->set("nbreservtableau", $nbreservtableau);
    // NON GERES
    // Total max annonces
    $this->loadModel("Gestionnaires");
    $this->loadModel("Annonces");
    $nbrLitAnnoncenon = $this->Annonces->find("all");
    if(json_decode($this->request->query['gestionnairesvar']) == "tous"){      
      if($gest['G']['role'] == "gestionnaire"){
        $arrayVillage = [];
        $gestionnaireVillage = $this->Gestionnaires->findById($gest['G']['id'])->contain('Villages')->first();
        foreach ($gestionnaireVillage->villages as $key) {
          array_push($arrayVillage, $key->id);
        }
        $nbrLitAnnoncenon->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
        $nbrLitAnnoncenon->where(['Annonces.id_gestionnaires <>' => $gest['G']['id']]);
      } else {
        $nbrLitAnnoncenon->where(['Annonces.id_gestionnaires = 0']);  
      }
    }else{
      $arrayVillage = [];
      foreach (json_decode($this->request->query['gestionnairesvar']) as $gestionnaire){
        $nbrLitAnnoncenon->where(['Annonces.id_gestionnaires <>' => $gestionnaire]);
        $gestionnaireVillage = $this->Gestionnaires->findById($gestionnaire)->contain('Villages')->first();
        foreach ($gestionnaireVillage->villages as $key) {
          array_push($arrayVillage, $key->id);
        }
      }
      $nbrLitAnnoncenon->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
    }   
    
    $nbrLitAnnoncenon->where(['(Annonces.statut=50 OR Annonces.statut=30)']);
    $nbrLitAnnoncenon->where(['Annonces.created_at < "'.$annTo->i18nFormat('yyyy-MM-dd').'"']); 
    if($station != "tous" && $station != 0){
      $nbrLitAnnoncenon->where(['Annonces.lieugeo_id'=>$station]);
    }
    if($village != "tous" && $village != 0){
      $nbrLitAnnoncenon->where(['Annonces.village'=>$village]);
    } 
    $nbrLitAnnoncenon->select(['nbrmaxannonce' => 'SUM(Annonces.personnes_nb)']);
    $nbrLitAnnoncenon = $nbrLitAnnoncenon->first();
    $nbrpersansannonce = $nbrLitAnnoncenon->nbrmaxannonce;
    $nbrdayAnnonce = $diffAnn;
    $nbrLitAnnoncenon = $nbrLitAnnoncenon->nbrmaxannonce * $diffAnn;
    
    $nbrInscrAntableauNon = [];
    $nbreservtableauNon = [];
    $nbrInscrtableauNon = $this->Reservations->find()->contain(["Annonces"]);
    
    if($station != "tous" && $station != 0){
      $nbrInscrtableauNon->where(['Annonces.lieugeo_id'=>$station]);
    }
    if($village != "tous" && $village != 0){
      $nbrInscrtableauNon->where(['Annonces.village'=>$village]);
    } 
    if(json_decode($this->request->query['gestionnairesvar']) == "tous"){
      if($gest['G']['role'] == "gestionnaire"){
        $arrayVillage = [];
        $gestionnaireVillage = $this->Gestionnaires->findById($gest['G']['id'])->contain('Villages')->first();
        foreach ($gestionnaireVillage->villages as $key) {
          array_push($arrayVillage, $key->id);
        }
        $nbrInscrtableauNon->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
        $nbrInscrtableauNon->where(['Annonces.id_gestionnaires <>' => $gest['G']['id']]);
      }else{
        $nbrInscrtableauNon->where(['Annonces.id_gestionnaires = 0']);  
      }      
    }else{    
      $arrayVillage = [];
      foreach (json_decode($this->request->query['gestionnairesvar']) as $gestionnaire){
        $nbrInscrtableauNon->where(['Annonces.id_gestionnaires <>' => $gestionnaire]);
        $gestionnaireVillage = $this->Gestionnaires->findById($gestionnaire)->contain('Villages')->first();
        foreach ($gestionnaireVillage->villages as $key) {
          array_push($arrayVillage, $key->id);
        }
      }
      $nbrInscrtableauNon->where(["Annonces.village IN ('".implode("','",$arrayVillage)."')"]);
    }    
      
    $nbrInscrtableauNon->where(['Annonces.created_at < "'.$annTo->i18nFormat('yyyy-MM-dd').'"']); 
    $nbrInscrtableauNon->where(['Reservations.statut = 90 AND ((Reservations.dbt_at <= "'.$annFrom->i18nFormat('yyyy-MM-dd').'" AND Reservations.fin_at > "'.$annFrom->i18nFormat('yyyy-MM-dd').'") OR (Reservations.dbt_at >= "'.$annFrom->i18nFormat('yyyy-MM-dd').'" AND Reservations.dbt_at <= "'.$annTo->i18nFormat('yyyy-MM-dd').'"))']);
    $nbrrpersreserNon = 0;
    $nbrpersans = 0;
    $nbrday = 0;
    // print_r($nbrInscrtableauNon);
    foreach ($nbrInscrtableauNon as $valuenon) {
      if(new Date($valuenon->dbt_at) < $annFrom) $dbtperiode = $annFrom;
      else $dbtperiode = new Date($valuenon->dbt_at);
      if(new Date($valuenon->fin_at) > $annTo) $finperiode = $annTo;
      else $finperiode = new Date($valuenon->fin_at);
      $nbrDays = $finperiode->diff($dbtperiode)->days+1;
      if(($valuenon->nb_adultes + $valuenon->nb_enfants) <= $valuenon['annonce']['personnes_nb']){
        $nbrrpersreserNon += ($valuenon->nb_adultes + $valuenon->nb_enfants)*$nbrDays;
        $nbrpersans += $valuenon->nb_adultes + $valuenon->nb_enfants;
      } else{
        $nbrrpersreserNon += ($valuenon['annonce']['personnes_nb'])*$nbrDays;
        $nbrpersans += $valuenon['annonce']['personnes_nb'];
      }
      // $nbrrpersreserNon += ($valuenon->nb_adultes + $valuenon->nb_enfants)*$nbrDays;
      // $nbrpersans += $value->nb_adultes + $value->nb_enfants;
      $nbrday += $nbrDays;
    } 
    $nbrInscrAntableauNon['nbrpersans'] = $nbrpersans;
    $nbrInscrAntableauNon['nbrday'] = $nbrday;
    $nbrInscrAntableauNon['total'] = $nbrrpersreserNon;    
    $nbreservtableauNon['total'] = $nbrLitAnnoncenon; 
    $nbreservtableauNon['nbrpersans'] = $nbrpersansannonce; 
    $nbreservtableauNon['nbrday'] = $nbrdayAnnonce;  
    $this->set("nbrInscrAntableauNon", $nbrInscrAntableauNon);
    $this->set("nbreservtableauNon", $nbreservtableauNon);
  }
  /**
   *
   **/
  public function occupationstatis(){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));
    $this->loadModel("Villages");
    $this->loadModel("Vacances");
    /*** LISTE VACANCES ***/
    $listevacance = $this->Vacances->getListeVacances()->where('Pays.code_pays = "FR"');
    $this->set('listeVacances',$listevacance);
    /*** LISTE GESTIONNAIRES ***/
    $listGest = $this->Villages->find()->order(['Villages.name' => 'ASC']);
    $this->set("listGest",$listGest);

    $this->loadModel("Dispos");
    $nbrInscrAn = [];
    $annee = 2011;
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    $month = date("n");
    if ($month<9){
        $year= date("Y");
    }
    else{
        $year = date("Y")+1;
    }
    while ($annee <= $year) {
      $nbrTotalAnnee = 0;
      $nbrOccupeAnnee = 0;
      for ($i=9; $i <= 12; $i++) {
        $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $annee-1, $i);
        $nbrTotalAnnee += $nbrTotal->nbr;

        $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $annee-1, $i);
        $nbrOccupeAnnee += $nbrOccupe->nbr;
      }
      for ($j=1; $j < 9; $j++) {
        $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $annee, $j);
        $nbrTotalAnnee += $nbrTotal->nbr;

        $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $annee, $j);
        $nbrOccupeAnnee += $nbrOccupe->nbr;
      }
      if($nbrTotalAnnee != 0){
        $occupPour = ($nbrOccupeAnnee*100)/$nbrTotalAnnee;
        $nbrInscrAn[$annee] = round($occupPour, 2);
      }else{
        $nbrInscrAn[$annee] = 0;
      }      
      $annee++;
    }
    $this->set("nbrInscrAn", $nbrInscrAn);
    
    
    /*** TAUX REMPLISSAGE ***/
    $surfaces = array('0' => 'A.surface > 0 AND A.surface <= 19', '1' => 'A.surface >= 20 AND A.surface <= 30', '2' => 'A.surface >= 31 AND A.surface <= 40', '3' => 'A.surface >= 41 AND A.surface <= 50', '4' => 'A.surface >= 51 AND A.surface <= 70', '5' => 'A.surface >= 71 AND A.surface <= 100', '6' => 'A.surface >= 101 AND A.surface <= 120', '7' => 'A.surface >= 121 AND A.surface <= 150', '8' => 'A.surface >= 151 AND A.surface <= 180', '9' => 'A.surface >= 181');
    $listGestionaires = $this->Gestionnaires->find();
    $this->set("listGestionaires",$listGestionaires);
    
    $nbrInscrAn = [];
      for ($k=0; $k < 10; $k++) {
        $nbrTotalAnnee = 0;
        $nbrOccupeAnnee = 0;
        for ($i=9; $i <= 12; $i++) {
          $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $year-1, $i, $surfaces[$k]);
          $nbrTotalAnnee += $nbrTotal->nbr;

          $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $year-1, $i, $surfaces[$k]);
          $nbrOccupeAnnee += $nbrOccupe->nbr;
        }
        for ($j=1; $j < 9; $j++) {
          $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $year, $j, $surfaces[$k]);
          $nbrTotalAnnee += $nbrTotal->nbr;

          $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $year, $j, $surfaces[$k]);
          $nbrOccupeAnnee += $nbrOccupe->nbr;
        }
        if($nbrTotalAnnee != 0)  $occupPour = ($nbrOccupeAnnee*100)/$nbrTotalAnnee;
        else $occupPour = 0;
        $nbrInscrAn[$k] = round($occupPour, 2);
      }
    $this->set("listeRemplissage", $nbrInscrAn);
  }
  
  public function statistiquesarrivee(){
        $session = $this->request->session();
        $gest = $session->read('Gestionnaire.info');
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
      
      $this->viewBuilder()->layout('manager');
      $this->loadModel('Gestionnaires');
      $this->loadModel('Reservations');
    /*** LISTE GESTIONNAIRES ***/
        $listGest = $this->Gestionnaires->find();
        $this->set("listGest",$listGest);
      
    /*** LES ARRIVEES ***/
        $dernierjour = mktime(0, 0, 0, (date("m")+1), 1, date("Y"));
        $dernierjour--;
        $dateDernierJour = strftime("%d", $dernierjour);
        $i = 1;
        while ($i <= $dateDernierJour) {
          $listeArrivee = $this->Reservations->get_arriv_index($gest['G']['id'], date("Y"), date("m"), $i, 1);
          $listeStatArri[$i] = $listeArrivee->nbr;
          $i++;
        }
        $this->set("listeStatArri",$listeStatArri);
    /*** LISTE NON ARRIVEES ***/
        $j = 1;
        while ($j <= $dateDernierJour) {
          $listeNnArrivee = $this->Reservations->get_arriv_index($gest['G']['id'], date("Y"), date("m"), $j, 0);
          $listeStatNnArri[$j] = $listeNnArrivee->nbr;
          $j++;
        }
        $this->set("listeStatNnArri",$listeStatNnArri);
  }
  /**
   *
   **/
  public function datamoisstatisoccupation($id, $village){
    $this->viewBuilder()->layout(false);
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    $this->loadModel("Dispos");
    $nbrInscrAn = [];
    for ($mois=9; $mois <= 12; $mois++) {
      $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $id-1, $mois, NULL, NULL, $village);
      $nbrTotal = $nbrTotal->nbr;

      $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $id-1, $mois, NULL, NULL, $village);
      $nbrOccupe = $nbrOccupe->nbr;
      $occupPour = ($nbrOccupe*100)/$nbrTotal;
      $nbrInscrAn[] = round($occupPour, 2);
    }

    for ($moi=1; $moi < 9; $moi++) {
      $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $id, $moi, NULL, NULL, $village);
      $nbrTotal = $nbrTotal->nbr;

      $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $id, $moi, NULL, NULL, $village);
      $nbrOccupe = $nbrOccupe->nbr;
      $occupPour = ($nbrOccupe*100)/$nbrTotal;
      $nbrInscrAn[] = round($occupPour, 2);
    }
    $this->set("nbrInscrAnMois", $nbrInscrAn);
  }
  /**
	 *
	 **/
  public function datamoisstatisoccupationprop($id, $prop){
    $this->viewBuilder()->layout(false);
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    $this->loadModel("Dispos");
    $nbrInscrAn = [];
    for ($mois=9; $mois <= 12; $mois++) {
      $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $id-1, $mois, NULL, NULL, NULL, $prop);
      $nbrTotal = $nbrTotal->nbr;

      $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $id-1, $mois, NULL, NULL, NULL, $prop);
      $nbrOccupe = $nbrOccupe->nbr;
      $occupPour = ($nbrOccupe*100)/$nbrTotal;
      $nbrInscrAn[] = round($occupPour, 2);
    }

    for ($moi=1; $moi < 9; $moi++) {
      $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $id, $moi, NULL, NULL, NULL, $prop);
      $nbrTotal = $nbrTotal->nbr;

      $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $id, $moi, NULL, NULL, NULL, $prop);
      $nbrOccupe = $nbrOccupe->nbr;
      $occupPour = ($nbrOccupe*100)/$nbrTotal;
      $nbrInscrAn[] = round($occupPour, 2);
    }
    $this->set("nbrInscrAnMois", $nbrInscrAn);
  }
  /**
	 *
	 **/
  public function datasemaineremplissagestatisprop($id_prop){
    $this->loadModel('Dispos');
    $this->loadModel('Vacances');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    $nbrInscrAn = [];
    $nbrInscrLabel = [];
    $nbrInscrLabelindex = "";
    $k = 1;
    foreach ($this->request->data['liste'] as $value) {
      $detail = $this->Vacances->getListeVacances()->where(["Vacances.id=".$value])->first();
      $nbrTotalAnnee = 0;
      $nbrOccupeAnnee = 0;
      $nbrTotal = $this->Dispos->get_total_dispos_date($gest_id, $detail->dbt_vac->i18nFormat('yyyy-MM-dd'), $detail->fin_vac->i18nFormat('yyyy-MM-dd'), NULL, $id_prop);
      $nbrTotalAnnee = $nbrTotal->nbr;
      $nbrOccupe = $this->Dispos->get_dispos_occupe_date($gest_id, $detail->dbt_vac->i18nFormat('yyyy-MM-dd'), $detail->fin_vac->i18nFormat('yyyy-MM-dd'), NULL, $id_prop);
      $nbrOccupeAnnee = $nbrOccupe->nbr;
      $occupPour = ($nbrOccupeAnnee*100)/$nbrTotalAnnee;
      $nbrInscrAn[$k] = round($occupPour, 2);
      $nbrInscrLabelindex .= "<strong>Saison ".$k." : </strong>".$detail->titre."-".$detail['Pays']['fr']." - ".$detail->zone_champ_vac." : ".$detail->dbt_vac." - ".$detail->fin_vac."<br>";
      $nbrInscrLabel[$k] = "Saison ".$k;
      $k++;
    }
    $this->set("listeStatSemaineRemplissage", $nbrInscrAn);
    $this->set("listeStatSemaineRemplissageLabel", $nbrInscrLabel);
    $this->set("nbrInscrLabelindex", $nbrInscrLabelindex);
  }
  /**
   *
   */
  public function datasemaineremplissagestatisoccupation($village){
    $this->loadModel('Dispos');
    $this->loadModel('Vacances');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    $nbrInscrAn = [];
    $nbrInscrLabel = [];
    $nbrInscrLabelindex = "";
    $k = 1;
    foreach ($this->request->data['liste'] as $value) {
      $detail = $this->Vacances->getListeVacances()->where(["Vacances.id=".$value])->first();
      $nbrTotalAnnee = 0;
      $nbrOccupeAnnee = 0;
      $nbrTotal = $this->Dispos->get_total_dispos_date($gest_id, $detail->dbt_vac->i18nFormat('yyyy-MM-dd'), $detail->fin_vac->i18nFormat('yyyy-MM-dd'), NULL, NULL, $village);
      $nbrTotalAnnee = $nbrTotal->nbr;
      $nbrOccupe = $this->Dispos->get_dispos_occupe_date($gest_id, $detail->dbt_vac->i18nFormat('yyyy-MM-dd'), $detail->fin_vac->i18nFormat('yyyy-MM-dd'), NULL, NULL, $village);
      $nbrOccupeAnnee = $nbrOccupe->nbr;
      $occupPour = ($nbrOccupeAnnee*100)/$nbrTotalAnnee;
      $nbrInscrAn[$k] = round($occupPour, 2);
      $nbrInscrLabelindex .= "<strong>Saison ".$k." : </strong>".$detail->titre."-".$detail['Pays']['fr']." - ".$detail->zone_champ_vac." : ".$detail->dbt_vac." - ".$detail->fin_vac."<br>";
      $nbrInscrLabel[$k] = "Saison ".$k;
      $k++;
    }
    $this->set("listeStatSemaineRemplissage", $nbrInscrAn);
    $this->set("listeStatSemaineRemplissageLabel", $nbrInscrLabel);
    $this->set("nbrInscrLabelindex", $nbrInscrLabelindex);
  }
  /**
   *
   **/
  public function datasemainestatisoccupation($id, $mois, $village){
    $this->viewBuilder()->layout(false);
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $this->loadModel("Dispos");

    $time = mktime(0, 0, 0, $mois, 1, $id);
    $firstWednesday = strtotime('Saturday', $time);

    $nbrInscrAn = [];
    $nbrInscrLabel = [];
    $moisperid =  strftime("%d", $firstWednesday);

    if($moisperid > 1){
      $deb = 1;
      $fin = $moisperid;
      $nbrTotal = $this->Dispos->find()
      ->join([
          'A' => [
            'table' => 'annonces',
            'type' => 'inner',
            'conditions' => ['Dispos.annonce_id=A.id'],
          ],
        ]);
     if($gest['G']['role'] == "gestionnaire"){
      $nbrTotal->where(['A.id_gestionnaires'=>$gest['G']['id']]);
      }
      $nbrTotal->where('YEAR(Dispos.dbt_at)="'.$id.'" AND MONTH(Dispos.dbt_at)="'.$mois.'" AND Dispos.dbt_at >= "'.$id.'-'.$mois.'-'.$deb.'" AND Dispos.dbt_at <= "'.$id.'-'.$mois.'-'.$fin.'"');
      if($village != "tous") $nbrTotal->where('A.village='.$village);
      $nbrTotal->select(['nbr' => $nbrTotal->func()->count('*')]);
      $nbrTotal = $nbrTotal->first();
      $nbrTotal = $nbrTotal->nbr;
      $nbrOccupe = $this->Dispos->find()
      ->join([
          'R' => [
            'table' => 'reservations',
            'type' => 'inner',
            'conditions' => ['Dispos.reservation_id=R.id'],
          ],
          'A' => [
            'table' => 'annonces',
            'type' => 'inner',
            'conditions' => ['Dispos.annonce_id=A.id'],
          ],
        ]);
        if($gest['G']['role'] == "gestionnaire"){
          $nbrOccupe->where(['A.id_gestionnaires'=>$gest['G']['id']]);
        }
      $nbrOccupe->where('Dispos.statut = 90 AND YEAR(Dispos.dbt_at)="'.$id.'" AND MONTH(Dispos.dbt_at)="'.$mois.'" AND Dispos.dbt_at >= "'.$id.'-'.$mois.'-'.$deb.'" AND Dispos.dbt_at <= "'.$id.'-'.$mois.'-'.$fin.'"');
      if($village != "tous") $nbrOccupe->where('A.village='.$village);
      $nbrOccupe->select(['nbr' => $nbrOccupe->func()->count('*')]);
      $nbrOccupe = $nbrOccupe->first();
      $nbrOccupe = $nbrOccupe->nbr;
      $occupPour = ($nbrOccupe*100)/$nbrTotal;
      $nbrInscrAn[] = round($occupPour, 2);
      $nbrInscrLabel[] = $deb." - ".($fin-1);
    }

    while ($moisperid <= 31 && $mois == strftime("%m", $firstWednesday)) {
      $deb = $moisperid;
      $afterweek = strtotime("+6 day", $firstWednesday);
      if(strftime("%m", $afterweek) == $mois){
        $fin = strftime("%d", $afterweek);
      } else {
        $premierjour = mktime(0, 0, 0, $mois+1, 1, $id);
        $premierjour--;
        $fin = strftime("%d", $premierjour);
      }

      $nbrTotal = $this->Dispos->find()
      ->join([
          'A' => [
            'table' => 'annonces',
            'type' => 'inner',
            'conditions' => ['Dispos.annonce_id=A.id'],
          ],
        ]);
     if($gest['G']['role'] == "gestionnaire"){
      $nbrTotal->where(['A.id_gestionnaires'=>$gest['G']['id']]);
      }
      $nbrTotal->where('YEAR(Dispos.dbt_at)="'.$id.'" AND MONTH(Dispos.dbt_at)="'.$mois.'" AND Dispos.dbt_at >= "'.$id.'-'.$mois.'-'.$deb.'" AND Dispos.dbt_at <= "'.$id.'-'.$mois.'-'.$fin.'"');
      if($village != "tous") $nbrTotal->where('A.village='.$village);
      $nbrTotal->select(['nbr' => $nbrTotal->func()->count('*')]);
      $nbrTotal = $nbrTotal->first();
      $nbrTotal = $nbrTotal->nbr;
      $nbrOccupe = $this->Dispos->find()
      ->join([
          'R' => [
            'table' => 'reservations',
            'type' => 'inner',
            'conditions' => ['Dispos.reservation_id=R.id'],
          ],
          'A' => [
            'table' => 'annonces',
            'type' => 'inner',
            'conditions' => ['Dispos.annonce_id=A.id'],
          ],
        ]);
        if($gest['G']['role'] == "gestionnaire"){
          $nbrOccupe->where(['A.id_gestionnaires'=>$gest['G']['id']]);
        }
      $nbrOccupe->where('Dispos.statut = 90 AND YEAR(Dispos.dbt_at)="'.$id.'" AND MONTH(Dispos.dbt_at)="'.$mois.'" AND Dispos.dbt_at >= "'.$id.'-'.$mois.'-'.$deb.'" AND Dispos.dbt_at <= "'.$id.'-'.$mois.'-'.$fin.'"');
      if($village != "tous") $nbrOccupe->where('A.village='.$village);
      $nbrOccupe->select(['nbr' => $nbrOccupe->func()->count('*')]);
      $nbrOccupe = $nbrOccupe->first();
      $nbrOccupe = $nbrOccupe->nbr;
      $occupPour = ($nbrOccupe*100)/$nbrTotal;
      $nbrInscrAn[] = round($occupPour, 2);
      $nbrInscrLabel[] = $deb." - ".$fin;
      $firstWednesday = strtotime("+1 day", $afterweek);
      $moisperid = strftime("%d", $firstWednesday);
    }
    $this->set("nbrInscrAnSemaine", $nbrInscrAn);
    $this->set("labelsemaine", $nbrInscrLabel);
  }
  /**
   *
   **/
  public function dataanneetatisoccupation($village){
    $this->loadModel("Dispos");
    $nbrInscrAn = [];
    $annee = 2011;
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    $month = date("n");
    if ($month<9){
        $year2= date("Y");
    }
    else{
        $year2 = date("Y")+1;
    }
    while ($annee <= $year2) {
      $nbrTotalAnnee = 0;
      $nbrOccupeAnnee = 0;
      for ($i=9; $i <= 12; $i++) {
        $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $annee-1, $i, NULL, NULL, $village);
        $nbrTotalAnnee += $nbrTotal->nbr;

        $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $annee-1, $i, NULL, NULL, $village);
        $nbrOccupeAnnee += $nbrOccupe->nbr;
      }
      for ($j=1; $j < 9; $j++) {
        $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $annee, $j, NULL, NULL, $village);
        $nbrTotalAnnee += $nbrTotal->nbr;

        $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $annee, $j, NULL, NULL, $village);
        $nbrOccupeAnnee += $nbrOccupe->nbr;
      }

      $occupPour = ($nbrOccupeAnnee*100)/$nbrTotalAnnee;
      $nbrInscrAn[$annee] = round($occupPour, 2);
      $annee++;
    }
    $this->set("nbrInscrAnAnnee", $nbrInscrAn);
  }
  /**
	 *
	 **/
  public function dataanneetatisoccupationprop($prop){
    $this->loadModel("Dispos");
    $nbrInscrAn = [];
    $annee = 2011;
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    $month = date("n");
    if ($month<9){
        $year2= date("Y");
    }
    else{
        $year2 = date("Y")+1;
    }
    while ($annee <= $year2) {
      $nbrTotalAnnee = 0;
      $nbrOccupeAnnee = 0;
      for ($i=9; $i <= 12; $i++) {
        $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $annee-1, $i, NULL, NULL, NULL, $prop);
        $nbrTotalAnnee += $nbrTotal->nbr;

        $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $annee-1, $i, NULL, NULL, NULL, $prop);
        $nbrOccupeAnnee += $nbrOccupe->nbr;
      }
      for ($j=1; $j < 9; $j++) {
        $nbrTotal = $this->Dispos->get_total_dispos($gest_id, $annee, $j, NULL, NULL, NULL, $prop);
        $nbrTotalAnnee += $nbrTotal->nbr;

        $nbrOccupe = $this->Dispos->get_dispos_occupe($gest_id, $annee, $j, NULL, NULL, NULL, $prop);
        $nbrOccupeAnnee += $nbrOccupe->nbr;
      }

      $occupPour = ($nbrOccupeAnnee*100)/$nbrTotalAnnee;
      $nbrInscrAn[$annee] = round($occupPour, 2);
      $annee++;
    }
    $this->set("nbrInscrAnAnnee", $nbrInscrAn);
  }
  /**
	 *
	 **/
  public function dataanneetatisoccupationpropchiffre($prop){
    $this->loadModel("Dispos");
    $nbrInscrAn = [];
    $annee = 2011;
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $gest_id = NULL;
    $month = date("n");
    if ($month<9){
        $year2= date("Y");
    }
    else{
        $year2 = date("Y")+1;
    }
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    if($prop == "tous") $prop = NULL;
    while ($annee <= $year2) {
      $nbrTotal = 0;
      for ($i=9; $i <= 12; $i++) {
        $nbrTotal += $this->Dispos->get_chiffre_affaire($gest_id, $annee-1, $i, $prop)->total;
      }
      for ($j=1; $j < 9; $j++) {
        $nbrTotal += $this->Dispos->get_chiffre_affaire($gest_id, $annee, $j, $prop)->total;
      }
      $nbrInscrAn[$annee] = round($nbrTotal, 2);
      $annee++;
    }
    $this->set("nbrInscrAnAnneechiffre", $nbrInscrAn);
  }
  /**
	 *
	 **/
  public function datamoisstatisoccupationpropchiffre($id, $prop){
    $this->loadModel("Dispos");
    $nbrInscrAn = [];
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    if($prop == "tous") $prop = NULL;
    $nbrTotal = 0;
    for ($i=9; $i <= 12; $i++) {
      $nbrTotal = $this->Dispos->get_chiffre_affaire($gest_id, $id-1, $i, $prop)->total;
      $nbrInscrAn[] = round($nbrTotal, 2);
    }
    for ($j=1; $j < 9; $j++) {
      $nbrTotal = $this->Dispos->get_chiffre_affaire($gest_id, $id, $j, $prop)->total;
      $nbrInscrAn[] = round($nbrTotal, 2);
    }
    $this->set("nbrInscrAnMoischiffre", $nbrInscrAn);
  }
  /**
	 *
	 **/
  public function datasemaineremplissagestatispropchiffre($id_prop){
    $this->loadModel('Dispos');
    $this->loadModel('Vacances');
    $session = $this->request->session();
    $gest = $session->read('Gestionnaire.info');
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    if($id_prop == "tous") $id_prop = NULL;
    $nbrInscrAn = [];
    $nbrInscrLabel = [];
    $nbrInscrLabelindex = "";
    $k = 1;
    foreach ($this->request->data['liste'] as $value) {
      $detail = $this->Vacances->getListeVacances()->where(["Vacances.id=".$value])->first();
      $nbrTotalAnnee = 0;
      $nbrTotal = $this->Dispos->get_chiffre_affaire_date($gest_id, $detail->dbt_vac->i18nFormat('yyyy-MM-dd'), $detail->fin_vac->i18nFormat('yyyy-MM-dd'), $id_prop);
      $nbrTotalAnnee = $nbrTotal->total;
      $nbrInscrAn[$k] = round($nbrTotalAnnee, 2);
      $nbrInscrLabelindex .= "<strong>Saison ".$k." : </strong>".$detail->titre."-".$detail['Pays']['fr']." - ".$detail->zone_champ_vac." : ".$detail->dbt_vac." - ".$detail->fin_vac."<br>";
      $nbrInscrLabel[$k] = "Saison ".$k;
      $k++;
    }
    $this->set("listeStatSemainechiffre", $nbrInscrAn);
    $this->set("listeStatSemainechiffreLabelchiffre", $nbrInscrLabel);
    $this->set("nbrInscrLabelindexchiffre", $nbrInscrLabelindex);
  }
  /**
   *
   **/
  public function arrayinfodetailles(){
    $session = $this->request->session();
    $gest=$session->read('Gestionnaire.info');
    $this->loadModel('Annonces');
    $annonces = $this->Annonces->get_array_rapport_stat_info_detail($this->request->query,$gest);
    echo json_encode( $annonces );die();
  }
  /**
	 *
	 **/
	function arraystat(){
      $session = $this->request->session();
      $gest=$session->read('Gestionnaire.info');
      $url=Router::url('/');
      $this->loadModel('Utilisateurs');
      $annonces = $this->Utilisateurs->get_array_stat($url,$this->request->query,$gest);
      echo json_encode( $annonces );die();
	}
  /**
   *
   **/
  public function arrayrapportstat(){
    $session = $this->request->session();
    $gest=$session->read('Gestionnaire.info');
    $url=Router::url('/');
    $this->loadModel('Annonces');
    $annonces = $this->Annonces->get_array_rapport_stat($url,$this->request->query,$gest);
    echo json_encode( $annonces );die();
  }
  /**
   *
   **/
  public function loyerprixmoyen(){
      $month = date("n");
    if ($month<9){
        $annee = date("Y")-1;
        $annee2= date("Y");
    }
    else{
        $annee = date("Y");
        $annee2 = date("Y")+1;
    }
    $this->viewBuilder()->layout('manager');
	  $url=Router::url('/');
	  $session = $this->request->session();
	  if(!$session->check("Gestionnaire.info")){
      return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
	  }
    $gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    $this->loadModel('Villages');
    $this->loadModel('Dispos');
    $this->loadModel("Vacances");
    /*** LISTE VACANCES ***/
    $listevacance = $this->Vacances->getListeVacances()->where('Pays.code_pays = "FR"');
    $this->set('listeVacances',$listevacance);
    /*** LISTE VILLAGE ***/
    $listGest = $this->Villages->find()->order(['Villages.name' => 'ASC']);
    $this->set("listGest",$listGest);

    /*** LISTE PRIX PAR SURFACE ***/
    $listePrixSurface = [];
    $listePrixSurfaceTotal = [];
    $total = [];
    $k = 0;
    for ($i=9; $i <= 12; $i++) {
      $prixGamme = $this->Dispos->get_price_surface($gest_id, 'A.surface > 0 AND A.surface <= 19', '2010', $i);
      $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, 'A.surface > 0 AND A.surface <= 19', '2010', $i);
      if(is_null($prixGamme->total)) $listePrixSurface[] = 0;
      else $listePrixSurface[] = round($prixGamme->total, 2);

      $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, 'A.surface > 0 AND A.surface <= 19', '2010', $i);
      $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, 'A.surface > 0 AND A.surface <= 19', '2010', $i);
      if(is_null($prixGammeTotal->total)) $listePrixSurfaceTotal[] = 0;
      else $listePrixSurfaceTotal[] = round($prixGammeTotal->total, 2);

      $total[$k][] = $nbrAnnResTotalSurf;
      $total[$k][] = $nbrAnnResTotalSurfNnreser;
      $k++;
    }
    for ($j=1; $j < 9; $j++) {
      $prixGamme = $this->Dispos->get_price_surface($gest_id, 'A.surface > 0 AND A.surface <= 19', '2011', $j);
      $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, 'A.surface > 0 AND A.surface <= 19', '2011', $j);
      if(is_null($prixGamme->total)) $listePrixSurface[] = 0;
      else $listePrixSurface[] = round($prixGamme->total, 2);

      $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, 'A.surface > 0 AND A.surface <= 19', '2011', $j);
      $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, 'A.surface > 0 AND A.surface <= 19', '2011', $j);
      if(is_null($prixGammeTotal->total)) $listePrixSurfaceTotal[] = 0;
      else $listePrixSurfaceTotal[] = round($prixGammeTotal->total, 2);

      $total[$k][] = $nbrAnnResTotalSurf;
      $total[$k][] = $nbrAnnResTotalSurfNnreser;
      $k++;
    }
    $this->set("listePrixSurface",$listePrixSurface);
    $this->set("listePrixSurfaceTotalNnReser",$listePrixSurfaceTotal);
    $this->set("listeTotal",$total);
    
    
    /*** LISTE PRIX PAR SURFACE ***/
    $listePrixSurface = [];
    $listePrixSurfaceTotal = [];
    $total = [];
    $surfaces = array('0' => 'A.surface > 0 AND A.surface <= 19', '1' => 'A.surface >= 20 AND A.surface <= 30', '2' => 'A.surface >= 31 AND A.surface <= 40', '3' => 'A.surface >= 41 AND A.surface <= 50', '4' => 'A.surface >= 51 AND A.surface <= 70', '5' => 'A.surface >= 71 AND A.surface <= 100', '6' => 'A.surface >= 101 AND A.surface <= 120', '7' => 'A.surface >= 121 AND A.surface <= 150', '8' => 'A.surface >= 151 AND A.surface <= 180', '9' => 'A.surface >= 181');
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





      /*$prixTotalMois = 0;
      $prixTotalMoisTotal = 0;
      $nbrtotalannreser = 0;
      $nbrtotalannreserNnreser = 0;
      for ($i=9; $i <= 12; $i++) {
        $prixGamme = $this->Dispos->get_price_surface($gest_id, $surfaces[$k], date("Y")-1, $i);
        if(is_null($prixGamme->total)) $prixTotalMois += 0;
        else $prixTotalMois += $prixGamme->total;
        $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, $surfaces[$k], date("Y")-1, $i);
        $nbrtotalannreser += $nbrAnnResTotalSurf;

        $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, $surfaces[$k], date("Y")-1, $i);
        if(is_null($prixGammeTotal->total)) $prixTotalMoisTotal += 0;
        else $prixTotalMoisTotal += $prixGammeTotal->total;
        $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, $surfaces[$k], date("Y")-1, $i);
        $nbrtotalannreserNnreser += $nbrAnnResTotalSurfNnreser;
      }
      for ($j=1; $j < 9; $j++) {
        $prixGamme = $this->Dispos->get_price_surface($gest_id, $surfaces[$k], date("Y"), $j);
        if(is_null($prixGamme->total)) $prixTotalMois += 0;
        else $prixTotalMois += $prixGamme->total;
        $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, $surfaces[$k], date("Y"), $j);
        $nbrtotalannreser += $nbrAnnResTotalSurf;

        $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, $surfaces[$k], date("Y"), $j);
        if(is_null($prixGammeTotal->total)) $prixTotalMoisTotal += 0;
        else $prixTotalMoisTotal += $prixGammeTotal->total;
        $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, $surfaces[$k], date("Y"), $j);
        $nbrtotalannreserNnreser += $nbrAnnResTotalSurfNnreser;
      }*/
      $total[$k][] = $nbrtotalannreser;
      $total[$k][] = $nbrtotalannreserNnreser;
      // $listePrixSurface[] = round($prixTotalMois/$nbrtotalannreser, 2);
      // $listePrixSurfaceTotal[] = round($prixTotalMoisTotal/$nbrtotalannreserNnreser, 2);
    }
    $this->set("listePrixSurface2",$listePrixSurface);
    $this->set("listePrixSurfaceTotalNnReser2",$listePrixSurfaceTotal);
    $this->set("listeTotal2",$total);
    /*** TAUX REMPLISSAGE ***/

  }
  
  public function loyerprixmoyengest(){
        $month = date("n");
        if ($month<9){
            $annee = date("Y")-1;
            $annee2= date("Y");
        }
        else{
            $annee = date("Y");
            $annee2 = date("Y")+1;
        }
    $this->viewBuilder()->layout('manager');
	  $url=Router::url('/');
	  $session = $this->request->session();
	  if(!$session->check("Gestionnaire.info")){
      return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
	  }
    $gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    $this->loadModel('Dispos');
    $this->loadModel("Vacances");
    /*** LISTE VACANCES ***/
    $listevacance = $this->Vacances->getListeVacances()->where('Pays.code_pays = "FR"');
    $this->set('listeVacances',$listevacance);

    /*** LISTE PRIX PAR SURFACE ***/
    $listePrixSurface = [];
    $listePrixSurfaceTotal = [];
    $total = [];
    $k = 0;
    for ($i=9; $i <= 12; $i++) {
      $prixGamme = $this->Dispos->get_price_surface($gest_id, 'A.surface > 0 AND A.surface <= 19', '2010', $i);
      $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, 'A.surface > 0 AND A.surface <= 19', '2010', $i);
      if(is_null($prixGamme->total)) $listePrixSurface[] = 0;
      else $listePrixSurface[] = round($prixGamme->total, 2);

      $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, 'A.surface > 0 AND A.surface <= 19', '2010', $i);
      $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, 'A.surface > 0 AND A.surface <= 19', '2010', $i);
      if(is_null($prixGammeTotal->total)) $listePrixSurfaceTotal[] = 0;
      else $listePrixSurfaceTotal[] = round($prixGammeTotal->total, 2);

      $total[$k][] = $nbrAnnResTotalSurf;
      $total[$k][] = $nbrAnnResTotalSurfNnreser;
      $k++;
    }
    for ($j=1; $j < 9; $j++) {
      $prixGamme = $this->Dispos->get_price_surface($gest_id, 'A.surface > 0 AND A.surface <= 19', '2011', $j);
      $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, 'A.surface > 0 AND A.surface <= 19', '2011', $j);
      if(is_null($prixGamme->total)) $listePrixSurface[] = 0;
      else $listePrixSurface[] = round($prixGamme->total, 2);

      $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, 'A.surface > 0 AND A.surface <= 19', '2011', $j);
      $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, 'A.surface > 0 AND A.surface <= 19', '2011', $j);
      if(is_null($prixGammeTotal->total)) $listePrixSurfaceTotal[] = 0;
      else $listePrixSurfaceTotal[] = round($prixGammeTotal->total, 2);

      $total[$k][] = $nbrAnnResTotalSurf;
      $total[$k][] = $nbrAnnResTotalSurfNnreser;
      $k++;
    }
    $this->set("listePrixSurface",$listePrixSurface);
    $this->set("listePrixSurfaceTotalNnReser",$listePrixSurfaceTotal);
    $this->set("listeTotal",$total);
    
    
        /*** LISTE PRIX PAR SURFACE ***/
    $listePrixSurface = [];
    $listePrixSurfaceTotal = [];
    $total = [];
    $surfaces = array('0' => 'A.surface > 0 AND A.surface <= 19', '1' => 'A.surface >= 20 AND A.surface <= 30', '2' => 'A.surface >= 31 AND A.surface <= 40', '3' => 'A.surface >= 41 AND A.surface <= 50', '4' => 'A.surface >= 51 AND A.surface <= 70', '5' => 'A.surface >= 71 AND A.surface <= 100', '6' => 'A.surface >= 101 AND A.surface <= 120', '7' => 'A.surface >= 121 AND A.surface <= 150', '8' => 'A.surface >= 151 AND A.surface <= 180', '9' => 'A.surface >= 181');
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





      /*$prixTotalMois = 0;
      $prixTotalMoisTotal = 0;
      $nbrtotalannreser = 0;
      $nbrtotalannreserNnreser = 0;
      for ($i=9; $i <= 12; $i++) {
        $prixGamme = $this->Dispos->get_price_surface($gest_id, $surfaces[$k], date("Y")-1, $i);
        if(is_null($prixGamme->total)) $prixTotalMois += 0;
        else $prixTotalMois += $prixGamme->total;
        $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, $surfaces[$k], date("Y")-1, $i);
        $nbrtotalannreser += $nbrAnnResTotalSurf;

        $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, $surfaces[$k], date("Y")-1, $i);
        if(is_null($prixGammeTotal->total)) $prixTotalMoisTotal += 0;
        else $prixTotalMoisTotal += $prixGammeTotal->total;
        $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, $surfaces[$k], date("Y")-1, $i);
        $nbrtotalannreserNnreser += $nbrAnnResTotalSurfNnreser;
      }
      for ($j=1; $j < 9; $j++) {
        $prixGamme = $this->Dispos->get_price_surface($gest_id, $surfaces[$k], date("Y"), $j);
        if(is_null($prixGamme->total)) $prixTotalMois += 0;
        else $prixTotalMois += $prixGamme->total;
        $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, $surfaces[$k], date("Y"), $j);
        $nbrtotalannreser += $nbrAnnResTotalSurf;

        $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, $surfaces[$k], date("Y"), $j);
        if(is_null($prixGammeTotal->total)) $prixTotalMoisTotal += 0;
        else $prixTotalMoisTotal += $prixGammeTotal->total;
        $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, $surfaces[$k], date("Y"), $j);
        $nbrtotalannreserNnreser += $nbrAnnResTotalSurfNnreser;
      }*/
      $total[$k][] = $nbrtotalannreser;
      $total[$k][] = $nbrtotalannreserNnreser;
      // $listePrixSurface[] = round($prixTotalMois/$nbrtotalannreser, 2);
      // $listePrixSurfaceTotal[] = round($prixTotalMoisTotal/$nbrtotalannreserNnreser, 2);
    }
    $this->set("listePrixSurface2",$listePrixSurface);
    $this->set("listePrixSurfaceTotalNnReser2",$listePrixSurfaceTotal);
    $this->set("listeTotal2",$total);
    /*** TAUX REMPLISSAGE ***/

  }
  /**
   *
   **/
  function dataloyerstatischoixsurface($village, $annee, $surface){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
	  // if(!$session->check("Gestionnaire.info")){
    //   return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
	  // }
    $gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    if($village == "tous") $village = NULL;
    $this->loadModel('Dispos');
    /*** LISTE PRIX PAR SURFACE ***/
    $surfaces = array('0' => 'A.surface > 0 AND A.surface <= 19', '1' => 'A.surface >= 20 AND A.surface <= 30', '2' => 'A.surface >= 31 AND A.surface <= 40', '3' => 'A.surface >= 41 AND A.surface <= 50', '4' => 'A.surface >= 51 AND A.surface <= 70', '5' => 'A.surface >= 71 AND A.surface <= 100', '6' => 'A.surface >= 101 AND A.surface <= 120', '7' => 'A.surface >= 121 AND A.surface <= 150', '8' => 'A.surface >= 151 AND A.surface <= 180', '9' => 'A.surface >= 181');
    $listePrixSurface = [];
    $listePrixSurfaceTotal = [];
    $total = [];
    $k = 0;
    for ($i=9; $i <= 12; $i++) {
      $prixGamme = $this->Dispos->get_price_surface($gest_id, $surfaces[$surface], $annee-1, $i, NULL, $village);
      $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, $surfaces[$surface], $annee-1, $i, NULL, $village);
      if(is_null($prixGamme->total)) $listePrixSurface[] = 0;
      else $listePrixSurface[] = round($prixGamme->total, 2);

      $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, $surfaces[$surface], $annee-1, $i, NULL, $village);
      $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, $surfaces[$surface], $annee-1, $i, NULL, $village);
      if(is_null($prixGammeTotal->total)) $listePrixSurfaceTotal[] = 0;
      else $listePrixSurfaceTotal[] = round($prixGammeTotal->total, 2);

      $total[$k][] = $nbrAnnResTotalSurf;
      $total[$k][] = $nbrAnnResTotalSurfNnreser;
      $k++;
    }
    for ($j=1; $j < 9; $j++) {
      $prixGamme = $this->Dispos->get_price_surface($gest_id, $surfaces[$surface], $annee, $j, NULL, $village);
      $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, $surfaces[$surface], $annee, $j, NULL, $village);
      if(is_null($prixGamme->total)) $listePrixSurface[] = 0;
      else $listePrixSurface[] = round($prixGamme->total, 2);

      $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, $surfaces[$surface], $annee, $j, NULL, $village);
      $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, $surfaces[$surface], $annee, $j, NULL, $village);
      if(is_null($prixGammeTotal->total)) $listePrixSurfaceTotal[] = 0;
      else $listePrixSurfaceTotal[] = round($prixGammeTotal->total, 2);

      $total[$k][] = $nbrAnnResTotalSurf;
      $total[$k][] = $nbrAnnResTotalSurfNnreser;
      $k++;
    }
    $this->set("listeStatMoisLoyer",$listePrixSurface);
    $this->set("listeStatMoisLoyerTotal",$listePrixSurfaceTotal);
    $this->set("listeTotal",$total);
  }
  
  /**
   * 
   */
  function datasemaineloyerprix($mois, $village)
  {
    $this->viewBuilder()->layout(false);
    $this->loadModel('Dispos');
    
    $where = $this->request->data["wheresurface"];
    
    $moistest = array("09", "10", "11", "12");
    if(in_array(date("m"), $moistest)){
        $annee = date("Y");
    }else{
        $annee = date("Y")-1;
    }
    if(in_array($mois, ["9", "10", "11", "12"])){
        $annee = $annee - 1;
    }
     
    $time = mktime(0, 0, 0, $mois, 1, $annee);
    $firstWednesday = strtotime('Saturday', $time);
    $nbrInscrAn = [];
    $nbrInscrLabel = [];
    $moisperid =  strftime("%d", $firstWednesday);
    $k = 0;
    if($moisperid > 1){
      $deb = 1;
      $fin = $moisperid;
      /** Requete calcul **/
        $from = $annee.'-'.$mois.'-'.$deb;
        $to = $annee.'-'.$mois.'-'.$fin;
        $prixGamme = $this->Dispos->get_price_surface_date(NULL, $where, $from, $to, $village);
        $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res_date(NULL, $where, $from, $to, $village);
        if(is_null($prixGamme->total)) $listePrixSurface[] = 0;
        else $listePrixSurface[] = round($prixGamme->total, 2);

        $prixGammeTotal = $this->Dispos->get_price_surface_total_date(NULL, $where, $from, $to, $village);
        $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total_date(NULL, $where, $from, $to, $village);
        if(is_null($prixGammeTotal->total)) $listePrixSurfaceTotal[] = 0;
        else $listePrixSurfaceTotal[] = round($prixGammeTotal->total, 2);

        $total[$k][] = $nbrAnnResTotalSurf;
        $total[$k][] = $nbrAnnResTotalSurfNnreser;
        $k++;
      $nbrInscrLabel[] = $deb." - ".($fin-1);
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
      
      /** Requete calcul **/
        $from = $annee.'-'.$mois.'-'.$deb;
        $to = $annee.'-'.$mois.'-'.$fin;
        
        $prixGamme = $this->Dispos->get_price_surface_date(NULL, $where, $from, $to, $village);
        $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res_date(NULL, $where, $from, $to, $village);
        if(is_null($prixGamme->total)) $listePrixSurface[] = 0;
        else $listePrixSurface[] = round($prixGamme->total, 2);
        
        $prixGammeTotal = $this->Dispos->get_price_surface_total_date(NULL, $where, $from, $to, $village);
        $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total_date(NULL, $where, $from, $to, $village);
        if(is_null($prixGammeTotal->total)) $listePrixSurfaceTotal[] = 0;
        else $listePrixSurfaceTotal[] = round($prixGammeTotal->total, 2);

        $total[$k][] = $nbrAnnResTotalSurf;
        $total[$k][] = $nbrAnnResTotalSurfNnreser;
        $k++;
      
      $nbrInscrLabel[] = $deb." - ".$fin;
      $firstWednesday = strtotime("+1 day", $afterweek);
      $moisperid = strftime("%d", $firstWednesday);
    }
    
//    print_r($nbrInscrLabel);
//    exit;
        
    $this->set("listePrixSurface",$listePrixSurface);
    $this->set("listePrixSurfaceTotalNnReser",$listePrixSurfaceTotal);
    $this->set("nbrInscrLabel", $nbrInscrLabel);
    $this->set("listeTotal",$total);    
  }
  /**
   *
   **/
  function datasaisonloyerstatis($village, $surface){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
	  if(!$session->check("Gestionnaire.info")){
      return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
	  }
    $gest = $session->read('Gestionnaire.info');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
    $gest_id = NULL;
    if($gest['G']['role'] == "gestionnaire"){
      $gest_id = $gest['G']['id'];
    }
    if($village == "tous") $village = NULL;
    $this->loadModel('Dispos');
    $this->loadModel('Vacances');
    /*** LISTE PRIX PAR SURFACE ***/
    $surfaces = array('0' => 'A.surface > 0 AND A.surface <= 19', '1' => 'A.surface >= 20 AND A.surface <= 30', '2' => 'A.surface >= 31 AND A.surface <= 40', '3' => 'A.surface >= 41 AND A.surface <= 50', '4' => 'A.surface >= 51 AND A.surface <= 70', '5' => 'A.surface >= 71 AND A.surface <= 100', '6' => 'A.surface >= 101 AND A.surface <= 120', '7' => 'A.surface >= 121 AND A.surface <= 150', '8' => 'A.surface >= 151 AND A.surface <= 180', '9' => 'A.surface >= 181');
    $listePrixSurface = [];
    $listePrixSurfaceTotal = [];
    $total = [];
    $k = 1;
    $nbrInscrLabelindex = '';
    foreach ($this->request->data['liste'] as $value) {
      $detail = $this->Vacances->getListeVacances()->where(["Vacances.id=".$value])->first();
      $prixGamme = $this->Dispos->get_price_surface_date($gest_id, $surfaces[$surface], $detail->dbt_vac->i18nFormat('yyyy-MM-dd'), $detail->fin_vac->i18nFormat('yyyy-MM-dd'), $village);
      $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res_date($gest_id, $surfaces[$surface], $detail->dbt_vac->i18nFormat('yyyy-MM-dd'), $detail->fin_vac->i18nFormat('yyyy-MM-dd'), $village);
      if(is_null($prixGamme->total)) $listePrixSurface[] = 0;
      else $listePrixSurface[] = round($prixGamme->total, 2);

      $prixGammeTotal = $this->Dispos->get_price_surface_total_date($gest_id, $surfaces[$surface], $detail->dbt_vac->i18nFormat('yyyy-MM-dd'), $detail->fin_vac->i18nFormat('yyyy-MM-dd'), $village);
      $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total_date($gest_id, $surfaces[$surface], $detail->dbt_vac->i18nFormat('yyyy-MM-dd'), $detail->fin_vac->i18nFormat('yyyy-MM-dd'), $village);
      if(is_null($prixGammeTotal->total)) $listePrixSurfaceTotal[] = 0;
      else $listePrixSurfaceTotal[] = round($prixGammeTotal->total, 2);

      $total[$k-1][] = $nbrAnnResTotalSurf;
      $total[$k-1][] = $nbrAnnResTotalSurfNnreser;
      $nbrInscrLabelindex .= "<strong>Saison ".$k." : </strong>".$detail->titre."-".$detail['Pays']['fr']." - ".$detail->zone_champ_vac." : ".$detail->dbt_vac." - ".$detail->fin_vac."<br>";
      $nbrInscrLabel[$k] = "Saison ".$k;
      $k++;
    }

    $this->set("listeStatSemaineLoyer",$listePrixSurface);
    $this->set("listeStatSemaineLoyerTotal",$listePrixSurfaceTotal);
    $this->set("listeTotal",$total);
    $this->set("nbrInscrLabelindex",$nbrInscrLabelindex);
    $this->set("listeStatSemaineRemplissageLabel", $nbrInscrLabel);
  }
  /**
   *
   **/
	 function smslocataire(){
      $this->viewBuilder()->layout('manager');
      $session1 = $this->request->session();
      if($session1->check("Prop.sms")){
              $this->set('confirm_res',$session1->read('Prop.sms'));
              $session1->delete("Prop.sms");
      }
      $this->loadModel('Modelmails');
      $this->loadModel('Modelmessages');
      $this->loadModel('Lieugeos');
      $gestion=$session1->read('Gestionnaire.info');
    	if(!empty($this->request->data)){
    		$a_model=$this->Modelmessages->get($this->request->data["model"]);
  			$a_tel=explode(";",$this->request->data['telephone']);
  			$a_id=explode(";",$this->request->data['idlocataire']);
    		$soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.61.wsdl"); 	//login 	anthares2015
    		$session = $soap->login("dt29400-ovh", 'q}XcJ_"jLw',"fr", false);
    		foreach($a_tel as $v){
    			if(substr($v,0,2)=='00') $num=$v;
    			else $num =$this->getFormatFrenchPhoneNumber($v,true);
    		}
    		$session1->write("Prop.sms","send");
    		$soap->logout($session);
    		return $this->redirect(['action' => 'smslocataire']);
    	}
      $this->set('InfoGes',$gestion);
      $this->set("modelmail", $this->Modelmails->find("all",['conditions'=>['id_gestionnaire'=>$gestion['G']['id']]]));
      $this->set("modelsms", $this->Modelmessages->find("all",['conditions'=>['id_gestionnaire'=>$gestion['G']['id']]]));
      $enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3,"select_yn"=>1],"order"=>"Lieugeos.name"]);
      foreach($enrs as $enr)
              $ar[$enr->id]=$enr->name;
      $this->set("l_lieugeos",$ar);
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
  /**
   *
   **/
  function arraylocataires(){
    $url=Router::url('/');
    $session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
    $debut=Time::parse($this->request->query["debut"]);
    $fin=Time::parse($this->request->query["fin"]);
    $this->loadModel('Reservations');
		if($gestionnaire['G']['role']=='admin'){
                    $a_locataire = $this->Reservations->getArrayLocataires($this->request->query["locataire"],$debut->i18nFormat('yyyy-MM-dd'),$fin->i18nFormat('yyyy-MM-dd'),$this->request->query["station"]);
    }
		else{
                    $a_locataire = $this->Reservations->getArrayLocataires($this->request->query["locataire"],$debut->i18nFormat('yyyy-MM-dd'),$fin->i18nFormat('yyyy-MM-dd'),$this->request->query["station"],$gestionnaire['G']['id']);
    }
    $output = array(
                "data" => array()
            );
    foreach ($a_locataire as $v){
        $row=array();
        $row[0]="<div class=\"checkbox\">"
                    ."<input type=\"checkbox\" id='locataire_".$v['U']['id']."' data-mail='".$v['U']['email']."' data-portable='".$v['U']['portable']."'>"
                    ."<label></label>"
                ."</div>";
        $row[1]=$v['U']['prenom']." ".$v['U']['nom_famille'];
        $row[2]=$this->getimagepays($v['U']['portable'])."  ".$v['U']['portable'];
        $row[3]=$v['U']['email'];
        $row[4]=$v->dbt_at->i18nFormat('dd-MM-yyyy');
        $row[5]=$v['RS']['name'];
        $row[6]=$v['A']['num_app'];
        $row[7]='<center><button data-toggle="modal" data-target="#responsive-modal" class="btn btn-sm btn-default btn-icon-anim btn-circle modifier_loc" data-href="'.$url.'manager/gestionnaires/editlocataire/'.$v['U']['id'].'"><i class="fa fa-pencil"></i></button></center>';
        $output['data'][] = $row;
    }
    echo json_encode($output);die();
    
//    $tabpays = [];
//    foreach ($a_locataire as $loc){
//        $tabpays[$loc['U']['id']] = $this->getimagepays($loc['U']['portable']);
//    }
//    $this->set('tabpays',$tabpays);
  }
  /**
   *
   **/
  public function getimagepays($phoneNumber){
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
        $url=Router::url('/');
        if(($returnValue == 1) || ($value == 1) || ($valueFR == 1)){
                //On l'ecrit sous la forme +33(9chiffres)                
                $phoneNumber = "<img src='".$url."css/blank.gif' class='flag flag-fr' alt='france' />";
                return $phoneNumber;
        }elseif ($returnValueBelge == 1) {
                //On traite les cas des numéro en belgique
                $phoneNumber = "<img src='".$url."css/blank.gif' class='flag flag-be' alt='belgique' />";
                return $phoneNumber;
        }elseif (($returnValueUK == 1) || ($valueUK == 1)) {
                //On traite les cas des numéro en UK
                $phoneNumber = "<img src='".$url."css/blank.gif' class='flag flag-gb' alt='UK' />";
                return $phoneNumber;
        }elseif (($returnValueES == 1) || ($valueES == 1)) {
                //On traite les cas des numéro en espagne
                $phoneNumber = "<img src='".$url."css/blank.gif' class='flag flag-es' alt='espagne' />";
                return $phoneNumber;
        }elseif (($returnValueRU == 1) || ($valueRU == 1)) {
                //On traite les cas des numéro en russie
                $phoneNumber = "<img src='".$url."css/blank.gif' class='flag flag-ru' alt='russie' />";
                return $phoneNumber;
        }elseif ($returnValueLUX == 1) {
                //On traite les cas des numéro en luxembourg
                $phoneNumber = "<img src='".$url."css/blank.gif' class='flag flag-lu' alt='luxembourg' />";
                return $phoneNumber;
        }elseif (($returnValueAL == 1) || ($valueAL == 1)) {
                //On traite les cas des numéro en allemagne
                $phoneNumber = "<img src='".$url."css/blank.gif' class='flag flag-de' alt='allemagne' />";
                return $phoneNumber;
        }elseif (($returnValuePB == 1) || ($valuePAB == 1) || ($valuePB == 1)) {
                //On traite les cas des numéro en pays-bas
                $phoneNumber = "<img src='".$url."css/blank.gif' class='flag flag-nl' alt='allemagne' />";
                return $phoneNumber;
        }elseif ($returnValueSUI == 1) {
                //On traite les cas des numéro en suisse
                $phoneNumber = "<img src='".$url."css/blank.gif' class='flag flag-ch' alt='suisse' />";
                return $phoneNumber;
        }elseif ($returnValueSUED == 1){
            //On traite les cas des numéro en suède
                $phoneNumber = "<img src='".$url."css/blank.gif' class='flag flag-se' alt='suede' />";
                return $phoneNumber;
        }elseif ($returnValueDANEM == 1){
            //On traite les cas des numéro en danemark
                $phoneNumber = "<img src='".$url."css/blank.gif' class='flag flag-dk' alt='danemark' />";
                return $phoneNumber;
        }else{
                $phoneNumber = '';
                return $phoneNumber;
        }
  }
  /**
   *
   **/
  public function arrayproptaxe(){
    $session = $this->request->session();
	  $gestionnaire=$session->read('Gestionnaire.info');
  	$this->set('role',$gestionnaire['G']['role']);
    $this->loadModel("Utilisateurs");
    $utilisateurs = $this->Utilisateurs->arrayutilisateurspdf($gestionnaire['G']['id']);
    echo json_encode($utilisateurs);die();
  }
  /**
   *
   **/
  function editlocataire($id){
    $this->viewBuilder()->layout('ajax');
    $this->loadModel("Utilisateurs");
    $this->set("user", $this->Utilisateurs->get($id));
  }
  /**
	 *
	 **/
	function setlocataire(){
    $this->loadModel("Utilisateurs");
    $utilisateur=$this->Utilisateurs->get($this->request->data['vUtil']);
    $data_u=array('prenom'=>html_entity_decode($this->request->data['vPrenom']),'nom_famille'=>html_entity_decode($this->request->data['vNomFamille']),"email"=>strtolower($this->request->data['vEmail']),"portable"=>$this->request->data['vPortable'],'ident'=>$this->request->data['vEmail']);
    $utilisateur=$this->Utilisateurs->patchEntity($utilisateur,$data_u);
    $this->Utilisateurs->save($utilisateur);
    die();
	}
  /**
   *
   **/
  function sendmailandsms(){
		$session1 = $this->request->session();
		$gestion=$session1->read('Gestionnaire.info');
		if($this->request->data['vType']=='SMS'){
    		$this->loadModel('Modelmessages');
        $this->loadModel('Utilisateurs');
				$this->loadModel('Smslocataires');
        $a_model=$this->Modelmessages->get($this->request->data['vMsg']);
        if($a_model->typesms == 'commerce') $varbo = false;
        else $varbo = true;
    		$soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.61.wsdl"); 	//login
    		$session = $soap->login("dt29400-ovh", 'q}XcJ_"jLw',"fr", false);
    		$soap->telephonySmsSend($session, "sms-dt29400-1", "alpissime","+33612290615",$a_model->txtsms, "2880", "1", "0", "3", "1", "", $varbo);
    		$a_tel=explode("||",$this->request->data['vPortable']);
    		$nbr = 0;                
			  foreach($a_tel as $k=>$v){
					$num = $this->getFormatFrenchPhoneNumber($v,true);
					if($num != ''){
						$result = $soap->telephonySmsSend($session, "sms-dt29400-1", "alpissime",$num,$a_model->txtsms, "2880", "1", "0", "3", "1", "", $varbo);
						$data=array('type'=>'SMS','locataire'=>$num,'model'=>$a_model->id,'gestionnaire'=>$gestion['G']['id'],'d_create'=>Time::now());
						$smslocataire = $this->Smslocataires->newEntity();
        		$smslocataire = $this->Smslocataires->patchEntity($smslocataire, $data);
						$this->Smslocataires->save($smslocataire);
						$nbr++;
					}
				}
				$soap->logout($session);
				echo($nbr);
		}
		if($this->request->data['vType']=='MAIL'){
  		$this->loadModel('Modelmails');
  		$a_model=$this->Modelmails->get($this->request->data['vMsg']);
  		$this->loadModel("Registres");
  		$mails = $this->Registres->find("all",["conditions"=>["app"=>"ULYSSE","bra"=>"GEN","cle"=>"MAIL"]]);
      $mail=$mails->first();
  		$a_tel=explode("||",$this->request->data['vMail']);
      $emailLoc = new Email();
      $emailLoc->template('locmail', 'default')
      	->emailFormat('html')
      	->to($mail->val)
      	->from([$gestion['G']['email']=>$gestion['G']['name']])
      	->subject($a_model->sujet)
      	->viewVars(['modelmail' => $a_model->txtmail])
      	->send();
  		foreach($a_tel as $k=>$v){
          $emailLoc = new Email('production');
          $emailLoc->template('locmail', 'default')
                  ->emailFormat('html')
                  ->to($v)
                  ->from([$mail->val=>FROM_MAIL])
                  ->subject($a_model->sujet)
                  ->viewVars(['modelmail' => $a_model->txtmail])
                  ->send();
  		}
	  }
	  exit;
  }
  /**
	 *
	 **/
  function sms(){
		$this->viewBuilder()->layout('manager');
    $session = $this->request->session();
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
  /**
   *
   **/
  function message(){
			$this->viewBuilder()->layout('manager');
      $session = $this->request->session();
			$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}
  /**
	 *
	 **/
	function arraymessage($id=null){
		$this->loadModel('Messages');
		$session = $this->request->session();
		$url=Router::url('/');
		$gestionnaire=$session->read('Gestionnaire.info');
		$output=$this->Messages->getArrayMessage($url,$this->request->query,$gestionnaire['G']['id']);
		echo json_encode($output);die();
	}
  /**
	 *
	 **/
	function getarraysms(){
                $output = array(
                    "sEcho" => intval($get['sEcho']),
                    "iTotalRecords" => $count["nbr"],
                    "iTotalDisplayRecords" => $count["nbr"],
                    "aaData" => array()
                );
		$a_sms=$this->Gestionnaires->getNbSms();
		$a_gest=array();
		$i=0;
		foreach($a_sms as $v){
                    $row = array();
                    $envo =$this->Gestionnaires->getEnvoyerSms($v->id);
                    $row[0]=$v->name;
                    $row[1]=$v['S']['totalsms'];
                    $row[2]=$envo;
                    $row[3]=$v['S']['totalsms']-$envo;
                    $row[4]="<center><button data-toggle=\"modal\" data-target=\"#responsive-modal\" class=\"btn btn-sm btn-default btn-icon-anim btn-circle edit_sms\" data-key=\"".$v['S']['id']."\" data-name=\"".$v->name."\"><i class=\"fa fa-pencil\"></i></button></center>";
                    $output['aaData'][] = $row;
		}
		echo json_encode($output);die();
	}
  /**
	 *
	 **/
  function addsms($id=null,$val=null){
      $this->loadModel('Smsgestionnaires');
  		echo "add";
  		$smsgest=$this->Smsgestionnaires->get($id);
      $data=array('totalsms'=>($smsgest->totalsms+(int)$val));
      $smsgest=$this->Smsgestionnaires->patchEntity($smsgest,$data);
      $this->Smsgestionnaires->save($smsgest);
		  exit;
	}
  /**
	 *
	 **/
	function mesannonces(){
                $this->viewBuilder()->layout('manager');
                $session = $this->request->session();
                $this->set('InfoGes',$session->read('Gestionnaire.info'));
                $gestionnaire=$session->read('Gestionnaire.info');
                $this->loadModel("Utilisateurs");
                $props=$this->Utilisateurs->getProprietaires();
                $this->set('props',$props);
	}
  /**
	 *
	 **/
	function arrayannonce(){
			$this->loadModel("Residences");
			$session = $this->request->session();
			$gest=$session->read('Gestionnaire.info');
			$url=Router::url('/');
      $annonces = $this->Residences->get_array_annonce($url,$this->request->query,$gest['G']['id']);
      echo json_encode( $annonces );die();
	}
  /**
   *
   **/
  function annonce(){
      $this->viewBuilder()->layout('manager');
      $session = $this->request->session();
      if($session->check("Annonce.refuser")){
          $this->set('confirm_refuser','reservation');
          $session->delete("Annonce.refuser");
      }
      if($session->check("Annonce.accepter")){
          $this->set('confirm_accepter','reservation');
          $session->delete("Annonce.accepter");
      }
      $gest=$session->read('Gestionnaire.info');
      $this->loadModel("Annonces");
      $output=$this->Annonces->find()
                              ->join([
                                  'L'=>[
                                      'table' => 'lieugeos',
                                      'type' => 'inner',
                                      'conditions' => 'L.id=Annonces.lieugeo_id',
                                  ],
                                  'U' => [
                                      'table' => 'utilisateurs',
                                      'type' => 'inner',
                                      'conditions' => ['U.id=Annonces.proprietaire_id','Annonces.statut=0'],
                                  ],
                                  // 'AG' => [
                                  //     'table' => 'annoncegestionnaires',
                                  //     'type' => 'inner',
                                  //     'conditions' => ['AG.id_annonces=Annonces.id',"AG.id_gestionnaires"=>$gest['G']['id']],
                                  // ]

                              ])
                ->select(['Annonces.id','Annonces.justificatif_domicile','Annonces.num_app','Annonces.created_at','Annonces.updated_at','U.prenom','U.nom_famille','U.email','U.valide_at','L.name'])
                ->where(['Annonces.id_gestionnaires' => $gest['G']['id']])
                ->order(['L.name']);
      $this->set('annonces',$output);
      $this->set('InfoGes',$gest);
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
  function accepter($id=null){
      $this->viewBuilder()->layout(false);
      $this->loadModel("Annonces");
      $session = $this->request->session();
	    $gest=$session->read('Gestionnaire.info');
      $annonce = $this->Annonces->get($id);
      $data=array('statut'=>50,'updated_at'=>Time::now());
      $annonce = $this->Annonces->patchEntity($annonce, $data);
      if ($this->Annonces->save($annonce)) {
      		$this->loadModel("Registres");
      		$this->loadModel("Utilisateurs");
      		$this->loadModel("Lieugeos");
      		$lieugeo=$this->Lieugeos->get($annonce->lieugeo_id);
    			$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
    			$utilisateur=$this->Utilisateurs->get($annonce->proprietaire_id);
                        $datamustache = array('gestionnaire' => $gest['G']['name'], 'nomprop' => $utilisateur->nom_famille, 'prenomprop' => $utilisateur->prenom, 'annonce' => $annonce->id, 'station' => $lieugeo->name, 'appartement' => $annonce->num_app);
                        
    			$mail=$mails->first();
                        // #####################################################
                        $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $utilisateur,'textEmail'=>'annonceAccepter',
                                                                 'data'=>$datamustache,'template'=>'annonceAccepter','viewVars'=>'annonceAccepter','noReply'=>false
                                                                ]);
                        $this->eventManager()->dispatch($event);
                        // #####################################################
                        
                        // #####################################################
                        $event = new Event('Email.send', $this, ['from'=>[$gest['G']['email']=>$gest['G']['name']],'to' => $mail->val,'textEmail'=>'annonceAccepterAdmin',
                                                                 'data'=>$datamustache,'template'=>'annonceAccepterAdmin','viewVars'=>'annonceAccepterAdmin','noReply'=>false
                                                                ]);
                        $this->eventManager()->dispatch($event);
                        // #####################################################
          $session->write("Annonce.accepter","accepter");
      }
      $this->set("msg","OK");
      //return $this->redirect(['action' => 'annonce']);
  }
  /**
   *
   **/
  function refuser($id=null){
      $this->viewBuilder()->layout(false);
      $this->loadModel("Annonces");
      $session = $this->request->session();
      $annonce = $this->Annonces->get($id);
        $gest=$session->read('Gestionnaire.info');
      $data=array('statut'=>10,'updated_at'=>Time::now());
      $annonce = $this->Annonces->patchEntity($annonce, $data);
      if ($this->Annonces->save($annonce)) {
          $this->loadModel("Registres");
    			$this->loadModel("Utilisateurs");
    			$this->loadModel("Lieugeos");
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
                        
                        // #####################################################
                        $event = new Event('Email.send', $this, ['from'=>[$gest['G']['email']=>$gest['G']['name']],'to' => $mail->val,'textEmail'=>'annonceRejeteeAdmin',
                                                                 'data'=>$datamustache,'template'=>'annonceRejeteeAdmin','viewVars'=>'annonceRejeteeAdmin','noReply'=>false
                                                                ]);
                        $this->eventManager()->dispatch($event);
                        // #####################################################
          $session->write("Annonce.refuser","refuser");
        }
        $this->set("msg","OK");
        //return $this->redirect(['action' => 'annonce']);
    }
  /**
	 *
	 **/
	function viewmessage($id){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel("Messages");
		$this->loadModel("Gestionnaires");
    $this->loadModel("Utilisateurs");

		$message=$this->Messages->get($id);
    $this->set('deId',$message->de);
    if($message->de > 50) $this->set('gestionnaire',$this->Utilisateurs->get($message->de));
		else $this->set('gestionnaire',$this->Gestionnaires->get($message->de));

    $message=$this->Messages->get($id);
		$this->set('info',$message);
    $a_edit=array('lu'=>1);
    $message = $this->Messages->patchEntity($message, $a_edit);
    $this->Messages->save($message);
	}
  /**
	 *
	 **/
  function addmessage(){
      $this->viewBuilder()->layout('ajax');
      $session = $this->request->session();
      $gestionnaire=$session->read('Gestionnaire.info');
      $this->loadModel("Gestionnaires");
      $this->set('id_gest',$gestionnaire['G']['id']);
      $query = $this->Gestionnaires->find('list', [
          'keyField' => 'id',
          'valueField' => 'name'
      ]);
      $data = $query->toArray();
      $this->set('a_gest',$data);
  }
  /**
	 *
	 **/
  function getnbmessage(){
      $this->loadModel("Messages");
      $session = $this->request->session();
      $gestionnaire=$session->read('Gestionnaire.info');
      $output=$this->Messages->getNbMessage($gestionnaire['G']['id']);
      echo ($output);die();
  }
  /**
	 *
	 **/
  function setmessage(){
      $this->loadModel("Messages");
      foreach($this->request->data["vType"] as $v){
          $message = $this->Messages->newEntity();
          $a_message=array('id_gestionnaire'=>$v,'de'=>$this->request->data["vId"],'sujet'=>$this->request->data["vSujet"],'message'=>$this->request->data["vMsg"],'d_create'=>Time::now(),'lu'=>0);
          $message = $this->Messages->patchEntity($message, $a_message);
          $this->Messages->save($message);
      }
      echo "save";die();
  }
  /**
	 *
	 **/
	function gererfacture(){
		$res=$this->getpdf($this->request->data["vGest"],$this->request->data["vMois"],'2_3_5');
		echo $res;
		exit;
	}
  /**
	 *
	 **/
	protected function getpdf($gestionnaire,$mois,$data){
		// ROOT . DS . 'vendor' . DS . "MPDF" . DS . "mpdf.php";
		// require_once(ROOT . DS . 'vendor' . DS . "MPDF" . DS . "mpdf.php");
    // $mpdf=new mPDF('0','A4','','',10,10,10,0,16,13);
    $mpdf = new \Mpdf\Mpdf();
		$url=SITE_ALPISSIME."manager/gestionnaires/facturepdf/".$gestionnaire."/".$mois."/".base64_encode($data);
		// $url=SITE_ALPISSIME."/manager/gestionnaires/facturepdf/".$gestionnaire."/".$mois."/".base64_encode($data);
		$html=file_get_contents($url);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->list_indent_first_level = 0;
		$mpdf->WriteHTML($html,2);
		$this->loadModel("Gestionnaires");
		$gest=$this->Gestionnaires->get($gestionnaire);
		$a_mois=array(1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'nouvembre',12=>'decembre');
		$name=$a_mois[$mois]."_".strtolower(str_replace(" ","-",$gest->name));
		$mpdf->Output(ROOT.DS.'webroot'.DS.'gestionnaire'.DS."facture_".$name.'.pdf');
		return $name;
	}
  /**
	 *
	 **/
	function facturepdf($gest,$mois,$data){
		$session = $this->request->session();
		$this->viewBuilder()->layout('ajax');
		$this->loadModel("Annonces");
		$this->loadModel("Gestionnaires");
		$output=$this->Annonces->find()
							->join([
								'C' => [
									'table' => 'contrats',
									'type' => 'inner',
									'conditions' => ['Annonces.id=C.annonce_id','C.visible=1', 'C.payerGest=1'],
								],
								'L' => [
									'table' => 'lieugeos',
									'type' => 'inner',
									'conditions' => 'L.id=Annonces.lieugeo_id',
								],
								'U' => [
									'table' => 'utilisateurs',
									'type' => 'inner',
									'conditions' => 'U.id=Annonces.proprietaire_id',
                ],
                'G' => [
                  'table' => 'gestionnaires',
                  'type' => 'inner',
                  'conditions' => ['G.id'=>$gest,'G.id=Annonces.id_gestionnaires']
                ],								
								'CT' => [
									'table' => 'contratypes',
									'type' => 'inner',
									'conditions' => ['CT.id=C.type','CT.id!=3'],
								],
								'R' => [
									'table' => 'residences',
									'type' => 'left',
									'conditions' => ['Annonces.batiment=R.id'],
								],
								'V' => [
									'table' => 'villages',
									'type' => 'left',
									'conditions' => 'V.id=R.id_village',
                ],
                'PC' => [
                  'table' => 'prix_contrat',
                  'type' => 'left',
                  'conditions' => 'PC.contrat_id=C.id',
                ]
							])
					->select(['PC.prix','PC.date_create','Annonces.id','Annonces.num_app','U.prenom','U.nom_famille','U.email','L.name','V.name','CT.id','CT.type','C.date_create','C.id','C.prix','R.name','Annonces.visible','Annonces.id_gestionnaires'])
					->where(['MONTH(C.date_create)="'.$mois.'"', 'Annonces.id_gestionnaires'=>$gest, 'Annonces.contrat = 1']);
		$this->set("gestionnaire", $this->Gestionnaires->get($gest));

		$monfichier = fopen(ROOT.DS.'webroot'.DS.'facture.txt', 'r+');
		$pages_vues = fgets($monfichier); // On lit la première ligne (nombre de pages vues)
		$pages_vues++; // On augmente de 1 ce nombre de pages vues
		fseek($monfichier, 0); // On remet le curseur au début du fichier
		fputs($monfichier, $pages_vues); // On écrit le nouveau nombre de pages vues
	 	fclose($monfichier);

		$this->set('a_contrat',$output->toArray());
		$this->set('gest',$gest);
		$this->set('mois',$mois);
		$this->set('num_facture',date('Y')."_".str_pad($gest, 3, '0', STR_PAD_LEFT).'_'.str_pad($pages_vues, 4, '0', STR_PAD_LEFT));
	}
  /**
	 *
	 **/
	function sendmail(){
		$a_mois=array(1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Août',9=>'Septembre',10=>'Octobre',11=>'Nouvembre',12=>'Décembre');
		$url=$a_mois[$this->request->data["vMois"]].' '.date('Y');
		$this->loadModel("Gestionnaires");
		$gestionnaire=$this->Gestionnaires->get($this->request->data["vGest"]);
		$this->loadModel("Registres");
		$a_txtmois=array(1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'nouvembre',12=>'decembre');
		$name=$a_txtmois[$this->request->data["vMois"]]."_".strtolower(str_replace(" ","-",$gestionnaire->name));
                $datamustache = array('gestionnaire' => $gestionnaire['G']['name'], 'date' => $url);
                
		$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
		$mail=$mails->first();
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $gestionnaire,'textEmail'=>'facturecontrat',
                                                         'data'=>$datamustache,'template'=>'facturecontrat','viewVars'=>'facturecontrat','noReply'=>false,
                                                         'attachments'=>['facture.pdf' => ROOT.DS.'webroot'.DS.'gestionnaire'.DS."facture_".$name.'.pdf']
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################
		die();
	}
  /**
	 *
	 **/
	function setpdfremplissage(){
		$this->getpdfremplissage($this->request->data["sDu"],$this->request->data["sTo"],$this->request->data["sID"]);
		echo "pdfgerer";
		exit;
	}
  /**
	 *
	 **/
	protected function getpdfremplissage($from,$to,$id=null){
		// require_once(ROOT . DS . 'vendor' . DS . "MPDF" . DS . "mpdf.php");
    // $mpdf=new mPDF('0','A4','','',10,10,10,0,16,13);
    $mpdf = new \Mpdf\Mpdf();
		$session = $this->request->session();
		$gest=$session->read('Gestionnaire.info');
		$url=SITE_ALPISSIME."/manager/gestionnaires/getpdfstatremplissage/".$gest["G"]["id"]."/".$gest["G"]["role"]."/".$from."/".$to."/".$id;
		$html=file_get_contents($url);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->list_indent_first_level = 0;
		$mpdf->WriteHTML($html,2);
		$mpdf->Output(ROOT.DS.'webroot'.DS.'gestionnaire'.DS.'stat_remplissage.pdf');
	}
  /**
   *
   **/
  function generateexcelrapportstat(){
    $this->viewBuilder()->layout('ajax');
    $session = $this->request->session();
    $gestId=$session->read('Gestionnaire.info');
    
    require_once(ROOT . DS . 'vendor' . DS . "Excel/PHPExcel.php");
    $workbook = new PHPExcel;
    $sheet = $workbook->getActiveSheet();
    $sheet->setTitle('Rapport Statistique');

    $sheet->getColumnDimension('A')->setWidth(35);
    $sheet->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $sheet->getColumnDimension('B')->setWidth(20);
    $sheet->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $sheet->getColumnDimension('C')->setWidth(27);
    $sheet->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('C')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $sheet->getColumnDimension('D')->setWidth(29);
    $sheet->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('D')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $sheet->getColumnDimension('E')->setWidth(35);
    $sheet->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('E')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $sheet->getColumnDimension('F')->setWidth(15);
    $sheet->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('F')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $sheet->getColumnDimension('G')->setWidth(15);
    $sheet->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('G')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $sheet->getColumnDimension('H')->setWidth(15);
    $sheet->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('H')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    $sheet->setCellValue('A1', 'INFORMATION GENERALE');
    $sheet->getStyle("A1")->getFont()->setBold(true)->setName('Verdana')->setSize(12);
    $sheet->getStyle('A1:B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('3caffb');

    $sheet->setCellValue('A2', 'Total Annonces Brouillons du site');
    $sheet->getStyle("A2")->getFont()->setBold(true)->setName('Verdana')->setSize(10);

    $this->loadModel("Annonces");
    $nbrtotalbrouillon = $this->Annonces->find();
    $nbrtotalbrouillon->where(["Annonces.statut = 0"]);
    $nbrtotalbrouillon->select(['nbr' => $nbrtotalbrouillon->func()->count('*')]);
    $nbrtb = $nbrtotalbrouillon->first();

    $sheet->setCellValue('B2', $nbrtb->nbr);
    $sheet->getStyle("B2")->getFont()->setName('Verdana')->setSize(10);

    $sheet->setCellValue('A3', 'Total Annonces Validées du site');
    $sheet->getStyle("A3")->getFont()->setBold(true)->setName('Verdana')->setSize(10);

    $nbrtotalvalide = $this->Annonces->find();
    $nbrtotalvalide->where(["Annonces.statut = 50"]);
    $nbrtotalvalide->select(['nbr' => $nbrtotalvalide->func()->count('*')]);
    $nbrtv = $nbrtotalvalide->first();

    $sheet->setCellValue('B3', $nbrtv->nbr);
    $sheet->getStyle("B3")->getFont()->setName('Verdana')->setSize(10);

    $sheet->setCellValue('A5', 'INFORMATION DETAILLEE');
    $sheet->getStyle("A5")->getFont()->setBold(true)->setName('Verdana')->setSize(12);
    $sheet->getStyle('A5:E5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('3caffb');

    if($gestId['G']['role'] != 'admin'){
      $station = $gestId['G']['name'];
    }else{
      if($this->request->data['vStation'] != 0) {
        $this->loadModel('Lieugeos');
        $lieugeo = $this->Lieugeos->find();
        $lieugeo->where(['Lieugeos.id = '.$this->request->data['vStation']]);
        $lieugeo->select(['Lieugeos.name']);
        $nbrlieugeo = $lieugeo->first();
        $station = $nbrlieugeo->name;
      }else $station = "Toutes Les Stations";
    }

    $sheet->setCellValue('A6', "Station");
    $sheet->getStyle("A6")->getFont()->setBold(true)->setName('Verdana')->setSize(9);

    $sheet->setCellValue('A7', $station);
    $sheet->getStyle("A7")->getFont()->setName('Verdana')->setSize(10);

    $nbrannoncestation = $this->Annonces->find();
    if($this->request->data['vStation'] != 0){
      $nbrannoncestation->join([
                      'L' => [
                        'table' => 'lieugeos',
                        'type' => 'inner',
                        'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                      ]
                    ]);
    }
    if($gestId['G']['role'] != 'admin'){
      $nbrannoncestation->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
      // $nbrannoncestation->join([
      //                 'AG' => [
      //                   'table' => 'annoncegestionnaires',
      //                   'type' => 'inner',
      //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
      //                 ]
      //               ]);
    }
    $nbrannoncestation->where(["Annonces.statut = 50 OR Annonces.statut = 0"]);
    $nbrannoncestation->select(['nbr' => $nbrannoncestation->func()->count('*')]);
    $nbrannstation = $nbrannoncestation->first();
    $sheet->setCellValue('B6', 'Total Annonces:');
    $sheet->getStyle("B6")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
    $sheet->setCellValue('B7', $nbrannstation->nbr);
    $sheet->getStyle("B7")->getFont()->setName('Verdana')->setSize(10)->getColor()->setRGB('008000');

    $aWhere1=array();
    $surf1 = $this->Annonces->find();
    if($this->request->data['vStation'] != 0){
      $surf1->join([
                      'L' => [
                        'table' => 'lieugeos',
                        'type' => 'inner',
                        'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                      ]
                    ]);
    }
    if($gestId['G']['role'] != 'admin'){
      $surf1->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
      // $surf1->join([
      //                 'AG' => [
      //                   'table' => 'annoncegestionnaires',
      //                   'type' => 'inner',
      //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
      //                 ]
      //               ]);
    }
    $surf1->select(['nbr' => $surf1->func()->count('*')]);
    $aWhere1[] = ["Annonces.surface >= 0 AND Annonces.surface <= 30"];
    $surf1->where($aWhere1);
    $nbrsurf1 = $surf1->first();
    $sheet->setCellValue('C6', 'Total An Surface 0 à 30 m²:');
    $sheet->getStyle("C6")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
    $sheet->setCellValue('C7', $nbrsurf1->nbr);
    $sheet->getStyle("C7")->getFont()->setName('Verdana')->setSize(10)->getColor()->setRGB('008000');

    $aWhere2=array();
    $surf2 = $this->Annonces->find();
    if($this->request->data['vStation'] != 0){
      $surf2->join([
                      'L' => [
                        'table' => 'lieugeos',
                        'type' => 'inner',
                        'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                      ]
                    ]);
    }
    if($gestId['G']['role'] != 'admin'){
      $surf2->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
      // $surf2->join([
      //                 'AG' => [
      //                   'table' => 'annoncegestionnaires',
      //                   'type' => 'inner',
      //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
      //                 ]
      //               ]);
    }
    $surf2->select(['nbr' => $surf2->func()->count('*')]);
    $aWhere2[] = ["Annonces.surface > 30 AND Annonces.surface <= 90"];
    $surf2->where($aWhere2);
    $nbrsurf2 = $surf2->first();
    $sheet->setCellValue('D6', 'Total An Surface 31 à 90 m²:');
    $sheet->getStyle("D6")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
    $sheet->setCellValue('D7', $nbrsurf2->nbr);
    $sheet->getStyle("D7")->getFont()->setName('Verdana')->setSize(10)->getColor()->setRGB('008000');

    $aWhere3=array();
    $surf3 = $this->Annonces->find();
    if($this->request->data['vStation'] != 0){
      $surf3->join([
                      'L' => [
                        'table' => 'lieugeos',
                        'type' => 'inner',
                        'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                      ]
                    ]);
    }
    if($gestId['G']['role'] != 'admin'){
      $surf3->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
      // $surf3->join([
      //                 'AG' => [
      //                   'table' => 'annoncegestionnaires',
      //                   'type' => 'inner',
      //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
      //                 ]
      //               ]);
    }
    $surf3->select(['nbr' => $surf3->func()->count('*')]);
    $aWhere3[] = ["Annonces.surface > 90"];
    $surf3->where($aWhere3);
    $nbrsurf3 = $surf3->first();
    $sheet->setCellValue('E6', 'Total An Surface supérieur à 91 m²:');
    $sheet->getStyle("E6")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
    $sheet->setCellValue('E7', $nbrsurf3->nbr);
    $sheet->getStyle("E7")->getFont()->setName('Verdana')->setSize(10)->getColor()->setRGB('008000');

    $sheet->setCellValue('A9', 'Station / Période');
    $sheet->getStyle("A9")->getFont()->setBold(true)->setName('Verdana')->setSize(9);

    $sheet->setCellValue('A10', $station."\nDu ".$this->request->data['vDatedebut']." Au ".$this->request->data['vDatefin']);
    $sheet->getStyle("A10")->getFont()->setName('Verdana')->setSize(10);
    $sheet->getStyle('A10')->getAlignment()->setWrapText(true);

    $dbt = new Date($this->request->data['vDatedebut']);
    $fin = new Date($this->request->data['vDatefin']);
    $dbt = $dbt->i18nFormat('yyyy-MM-dd');
    $fin = $fin->i18nFormat('yyyy-MM-dd');

    $nbrrWhere=array();
    $nbrrWhere[] = ["R.dbt_at >= '$dbt'", "R.dbt_at < '$fin'"];
    $nbrreservation = $this->Annonces->find();
    if($this->request->data['vStation'] != 0){
      $nbrreservation->join([
                      'L' => [
                        'table' => 'lieugeos',
                        'type' => 'inner',
                        'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                      ]
                    ]);
    }
    if($gestId['G']['role'] != 'admin'){
      $nbrreservation->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
      // $nbrreservation->join([
      //                 'AG' => [
      //                   'table' => 'annoncegestionnaires',
      //                   'type' => 'inner',
      //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
      //                 ]
      //               ]);
    }
    $nbrreservation->join([
                    'R' => [
                      'table' => 'reservations',
                      'type' => 'inner',
                      'conditions' => ['R.annonce_id = Annonces.id','R.statut = 90'],
                    ]
                  ]);
    $nbrreservation->where($nbrrWhere);
    $nbrreservation->select(['nbr' => $nbrreservation->func()->count('*')]);
    $nbrtotreservation = $nbrreservation->first();
    $sheet->setCellValue('B9', 'Total Réservations');
    $sheet->getStyle("B9")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
    $sheet->setCellValue('B10', $nbrtotreservation->nbr);
    $sheet->getStyle("B10")->getFont()->setName('Verdana')->setSize(10)->getColor()->setRGB('008000');

    $rWhere=array();
    $rWhere[] = ["R.dbt_at >= '$dbt'", "R.fin_at <= '$fin'"];
    $annreserve = $this->Annonces->find();
    if($this->request->data['vStation'] != 0){
      $annreserve->join([
                      'L' => [
                        'table' => 'lieugeos',
                        'type' => 'inner',
                        'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                      ]
                    ]);
    }
    if($gestId['G']['role'] != 'admin'){
      $annreserve->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
      // $annreserve->join([
      //                 'AG' => [
      //                   'table' => 'annoncegestionnaires',
      //                   'type' => 'inner',
      //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
      //                 ]
      //               ]);
    }
    $annreserve->join([
                    'R' => [
                      'table' => 'reservations',
                      'type' => 'inner',
                      'conditions' => ['R.annonce_id = Annonces.id','R.statut = 90'],
                    ]
                  ]);
    $annreserve->where($rWhere);
    $annreserve->select(['nbr' => $annreserve->func()->count('*')]);
    $annreserve->group(['Annonces.id']);
    $nbrAnnoncesRes = $annreserve->count();
    $sheet->setCellValue('C9', 'Total Annonces Réservées');
    $sheet->getStyle("C9")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
    $sheet->setCellValue('C10', $nbrAnnoncesRes);
    $sheet->getStyle("C10")->getFont()->setName('Verdana')->setSize(10)->getColor()->setRGB('008000');

    $aWhere=array();
    $aWhere[] = "Annonces.created_at >= '".$dbt."' AND Annonces.created_at <= '".$fin."'";
    $annonces = $this->Annonces->find();
    if($this->request->data['vStation'] != 0){
      $annonces->join([
                      'L' => [
                        'table' => 'lieugeos',
                        'type' => 'inner',
                        'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                      ]
                    ]);
    }
    if($gestId['G']['role'] != 'admin'){
      $annonces->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
      // $annonces->join([
      //                 'AG' => [
      //                   'table' => 'annoncegestionnaires',
      //                   'type' => 'inner',
      //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
      //                 ]
      //               ]);
    }
    $annonces->where($aWhere);
    $annonces->select(['nbr' => $annonces->func()->count('*')]);
    $nbrAnnonces = $annonces->first();
    $sheet->setCellValue('D9', 'Total Annonces Créées');
    $sheet->getStyle("D9")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
    $sheet->setCellValue('D10', $nbrAnnonces->nbr);
    $sheet->getStyle("D10")->getFont()->setName('Verdana')->setSize(10)->getColor()->setRGB('008000');

    $weretotal=array();
    $weretotal[] = ["Reservations.dbt_at >= '$dbt'", "Reservations.dbt_at < '$fin'"];
    $this->loadModel('Reservations');
    $weretotal[] = ["Reservations.statut = 90"];
    $querytotal = $this->Reservations->find();
    $querytotal->join([
                'A' => [
                  'table' => 'annonces',
                  'type' => 'inner',
                  'conditions' => ['Reservations.annonce_id = A.id'],
                ]
              ]);
    if($this->request->data['vStation'] != 0){
                $querytotal->join([
                'L' => [
                  'table' => 'lieugeos',
                  'type' => 'inner',
                  'conditions' => ["A.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                ]
              ]);
            }
     if($gestId['G']['role'] != 'admin'){
      $querytotal->where(['A.id_gestionnaires'=>$gestId['G']['id']]);
      //  $querytotal->join([
      //                  'AG' => [
      //                    'table' => 'annoncegestionnaires',
      //                    'type' => 'inner',
      //                    'conditions' => ['AG.id_annonces = A.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
      //                  ]
      //                ]);
     }
     $querytotal->where($weretotal);
     $querytotal->select(['count' => $querytotal->func()->sum('Reservations.nb_adultes')]);
     $nbradulttotal = $querytotal->first();

     $query2total = $this->Reservations->find();
     $query2total->join([
                'A' => [
                  'table' => 'annonces',
                  'type' => 'inner',
                  'conditions' => ['Reservations.annonce_id = A.id'],
                ]
              ]);
     if($this->request->data['vStation'] != 0){
     $query2total->join([
                  'L' => [
                    'table' => 'lieugeos',
                    'type' => 'inner',
                    'conditions' => ["A.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                  ]
                ]);
              }
      if($gestId['G']['role'] != 'admin'){
        $query2total->where(['A.id_gestionnaires'=>$gestId['G']['id']]);
        // $query2total->join([
        //                 'AG' => [
        //                   'table' => 'annoncegestionnaires',
        //                   'type' => 'inner',
        //                   'conditions' => ['AG.id_annonces = A.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //                 ]
        //               ]);
      }
     $query2total->where($weretotal);
     $query2total->select(['count' => $query2total->func()->sum('Reservations.nb_enfants')]);
     $nbrenfanttotal = $query2total->first();

     if($nbrtotreservation->nbr==0) $nbrdulttotal = 0;
     else $nbrdulttotal = $nbradulttotal->count ;

     if($nbrtotreservation->nbr==0) $nbrenftotal = 0;
     else $nbrenftotal = $nbrenfanttotal->count ;
     $sheet->setCellValue('E9', 'Total Personnes');
     $sheet->getStyle("E9")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
     $sheet->setCellValue('E10', $nbrdulttotal+$nbrenftotal);
     $sheet->getStyle("E10")->getFont()->setName('Verdana')->setSize(10)->getColor()->setRGB('008000');

     $sheet->setCellValue('A12', 'INFORMATION DETAILLEE');
     $sheet->setCellValue('B12', 'PAR SEMAINE');
     $sheet->getStyle("A12")->getFont()->setBold(true)->setName('Verdana')->setSize(12);
     $sheet->getStyle("B12")->getFont()->setBold(true)->setName('Verdana')->setSize(12);
     $sheet->getStyle('A12:H12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('3caffb');

     $sheet->setCellValue('A13', 'Semaine');
     $sheet->getStyle("A13")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
     $sheet->setCellValue('B13', 'NB Réservations');
     $sheet->getStyle("B13")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
     $sheet->setCellValue('C13', 'NB An Surface (0 à 30 m²)');
     $sheet->getStyle("C13")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
     $sheet->setCellValue('D13', 'NB An Surface (31 à 90 m²)');
     $sheet->getStyle("D13")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
     $sheet->setCellValue('E13', 'NB An Surface (supérieur à 91 m²)');
     $sheet->getStyle("E13")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
     $sheet->setCellValue('F13', 'NB Adultes');
     $sheet->getStyle("F13")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
     $sheet->setCellValue('G13', 'NB Enfants');
     $sheet->getStyle("G13")->getFont()->setBold(true)->setName('Verdana')->setSize(9);
     $sheet->setCellValue('H13', 'NB Personnes');
     $sheet->getStyle("H13")->getFont()->setBold(true)->setName('Verdana')->setSize(9);

     $dbt2 = new Date($this->request->data['vDatedebut']);
     $fin2 = new Date($this->request->data['vDatefin']);
     $fin2 = $fin2->i18nFormat('yyyy-MM-dd');
     $dbtsemaine = $dbt2->i18nFormat('yyyy-MM-dd');
     $dbtaffichage = $dbt2->i18nFormat('dd/MM/yyyy');
     $finsem = $dbt2->modify('+7 day');
     $finsemaine = $finsem->i18nFormat('yyyy-MM-dd');
     $finaffichage = $finsem->i18nFormat('dd/MM/yyyy');

    $i=13;
    while ($finsemaine <= $fin2) {
      $i++;
      $nbrrWhere2=array();
      $were= array();
      $aWhere12 = array();
      $aWhere22 = array();
      $aWhere32 = array();

      $nbrrWhere2[] = ["R.dbt_at >= '$dbtsemaine'", "R.dbt_at < '$finsemaine'"];
      $nbrreservation2 = $this->Annonces->find();
      if($this->request->data['vStation'] != 0){
        $nbrreservation2->join([
                        'L' => [
                          'table' => 'lieugeos',
                          'type' => 'inner',
                          'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                        ]
                      ]);
      }
      $nbrreservation2->join([
                      'R' => [
                        'table' => 'reservations',
                        'type' => 'inner',
                        'conditions' => ['R.annonce_id = Annonces.id','R.statut = 90'],
                      ]
                    ]);
      if($gestId['G']['role'] != 'admin'){
        $nbrreservation2->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        // $nbrreservation2->join([
        //                 'AG' => [
        //                   'table' => 'annoncegestionnaires',
        //                   'type' => 'inner',
        //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //                 ]
        //               ]);
      }
      $nbrreservation2->where($nbrrWhere2);
      $nbrreservation2->select(['nbr' => $nbrreservation2->func()->count('*')]);
      $nbrressem = $nbrreservation2->first();

      $surf12 = $this->Annonces->find();
      if($this->request->data['vStation'] != 0){
        $surf12->join([
                        'L' => [
                          'table' => 'lieugeos',
                          'type' => 'inner',
                          'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                        ]
                      ]);
      }
      if($gestId['G']['role'] != 'admin'){
        $surf12->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        // $surf12->join([
        //                 'AG' => [
        //                   'table' => 'annoncegestionnaires',
        //                   'type' => 'inner',
        //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //                 ]
        //               ]);
      }
      $surf12->join([
                      'R' => [
                        'table' => 'reservations',
                        'type' => 'inner',
                        'conditions' => ['R.annonce_id = Annonces.id','R.statut = 90'],
                      ]
                    ]);
      $surf12->select(['nbr' => $surf12->func()->count('*')]);
      $aWhere12[] = ["Annonces.surface >= 0 AND Annonces.surface <= 30"];
      $aWhere12[] = ["R.dbt_at >= '$dbtsemaine'", "R.dbt_at < '$finsemaine'"];
      $surf12->where($aWhere12);
      $surf12->group(['Annonces.id']);
      $nbrsurf12 = $surf12->count();

      $surf22 = $this->Annonces->find();
      if($this->request->data['vStation'] != 0){
        $surf22->join([
                        'L' => [
                          'table' => 'lieugeos',
                          'type' => 'inner',
                          'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                        ]
                      ]);
      }
      if($gestId['G']['role'] != 'admin'){
        $surf22->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        // $surf22->join([
        //                 'AG' => [
        //                   'table' => 'annoncegestionnaires',
        //                   'type' => 'inner',
        //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //                 ]
        //               ]);
      }
      $surf22->join([
                      'R' => [
                        'table' => 'reservations',
                        'type' => 'inner',
                        'conditions' => ['R.annonce_id = Annonces.id','R.statut = 90'],
                      ]
                    ]);
      $surf22->select(['nbr' => $surf22->func()->count('*')]);
      $aWhere22[] = ["Annonces.surface >= 31 AND Annonces.surface <= 90"];
      $aWhere22[] = ["R.dbt_at >= '$dbtsemaine'", "R.dbt_at < '$finsemaine'"];
      $surf22->where($aWhere22);
      $surf22->group(['Annonces.id']);
      $nbrsurf22 = $surf22->count();

      $surf32 = $this->Annonces->find();
      if($this->request->data['vStation'] != 0){
        $surf32->join([
                        'L' => [
                          'table' => 'lieugeos',
                          'type' => 'inner',
                          'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                        ]
                      ]);
      }
      if($gestId['G']['role'] != 'admin'){
        $surf32->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        // $surf32->join([
        //                 'AG' => [
        //                   'table' => 'annoncegestionnaires',
        //                   'type' => 'inner',
        //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //                 ]
        //               ]);
      }
      $surf32->join([
                      'R' => [
                        'table' => 'reservations',
                        'type' => 'inner',
                        'conditions' => ['R.annonce_id = Annonces.id','R.statut = 90'],
                      ]
                    ]);
      $surf32->select(['nbr' => $surf32->func()->count('*')]);
      $aWhere32[] = ["Annonces.surface > 90"];
      $aWhere32[] = ["R.dbt_at >= '$dbtsemaine'", "R.dbt_at < '$finsemaine'"];
      $surf32->where($aWhere32);
      $surf32->group(['Annonces.id']);
      $nbrsurf32 = $surf32->count();

      $this->loadModel("Reservations");
      $were[] = ["Reservations.statut = 90"];
      $were[] = ["Reservations.dbt_at >= '$dbtsemaine'", "Reservations.dbt_at < '$finsemaine'"];
      $query = $this->Reservations->find();
      $query->join([
                      'A' => [
                        'table' => 'annonces',
                        'type' => 'inner',
                        'conditions' => ['Reservations.annonce_id = A.id'],
                      ]
                    ]);
      if($this->request->data['vStation'] != 0){
        $query->join([
                        'L' => [
                          'table' => 'lieugeos',
                          'type' => 'inner',
                          'conditions' => ["A.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                        ]
                      ]);
      }
      if($gestId['G']['role'] != 'admin'){
        $query->where(['A.id_gestionnaires'=>$gestId['G']['id']]);
        // $query->join([
        //                 'AG' => [
        //                   'table' => 'annoncegestionnaires',
        //                   'type' => 'inner',
        //                   'conditions' => ['AG.id_annonces = A.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //                 ]
        //               ]);
      }
      $query->where($were);
      $query->select(['count' => $query->func()->sum('Reservations.nb_adultes')]);
      $nbradult = $query->first();

      $query2 = $this->Reservations->find();
      $query2->join([
                      'A' => [
                        'table' => 'annonces',
                        'type' => 'inner',
                        'conditions' => ['Reservations.annonce_id = A.id'],
                      ]
                    ]);
      if($this->request->data['vStation'] != 0){
        $query2->join([
                        'L' => [
                          'table' => 'lieugeos',
                          'type' => 'inner',
                          'conditions' => ["A.lieugeo_id = L.id", "L.id = ".$this->request->data['vStation']],
                        ]
                      ]);
      }
      if($gestId['G']['role'] != 'admin'){
        $query2->where(['A.id_gestionnaires'=>$gestId['G']['id']]);
        // $query2->join([
        //                 'AG' => [
        //                   'table' => 'annoncegestionnaires',
        //                   'type' => 'inner',
        //                   'conditions' => ['AG.id_annonces = A.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //                 ]
        //               ]);
      }
      $query2->where($were);
      $query2->select(['count' => $query2->func()->sum('Reservations.nb_enfants')]);
      $nbrenfant = $query2->first();

      if($nbrressem->nbr==0) $nbrdult = 0;
      else $nbrdult = $nbradult->count ;

      if($nbrressem->nbr==0) $nbrenf = 0;
      else $nbrenf = $nbrenfant->count ;

      $sheet->setCellValue('A'.$i, $dbtaffichage." - ".$finaffichage);
      $sheet->getStyle('A'.$i)->getFont()->setName('Verdana')->setSize(10);
      $sheet->setCellValue('B'.$i, $nbrressem->nbr);
      $sheet->getStyle('B'.$i)->getFont()->setName('Verdana')->setSize(10);
      $sheet->setCellValue('C'.$i, $nbrsurf12);
      $sheet->getStyle('C'.$i)->getFont()->setName('Verdana')->setSize(10);
      $sheet->setCellValue('D'.$i, $nbrsurf22);
      $sheet->getStyle('D'.$i)->getFont()->setName('Verdana')->setSize(10);
      $sheet->setCellValue('E'.$i, $nbrsurf32);
      $sheet->getStyle('E'.$i)->getFont()->setName('Verdana')->setSize(10);
      $sheet->setCellValue('F'.$i, $nbrdult);
      $sheet->getStyle('F'.$i)->getFont()->setName('Verdana')->setSize(10);
      $sheet->setCellValue('G'.$i, $nbrenf);
      $sheet->getStyle('G'.$i)->getFont()->setName('Verdana')->setSize(10);
      $sheet->setCellValue('H'.$i, $nbrdult+$nbrenf);
      $sheet->getStyle('H'.$i)->getFont()->setName('Verdana')->setSize(10);

      $dbtsemaine = $finsemaine;
      $dbtaffichage = $finaffichage;
      $finsemaine = $finsem->modify('+7 day');
      $finaffichage = $finsemaine->i18nFormat('dd/MM/yyyy');
      $finsem = $finsemaine;
      $finsemaine = $finsemaine->i18nFormat('yyyy-MM-dd');
    }
    $writer = new PHPExcel_Writer_Excel5($workbook);

    $writer->save(ROOT.DS.'webroot'.DS.'gestionnaire'.DS.'rapport_statistique_'.$station.'_'.$this->request->data['vDatedebut'].'_'.$this->request->data['vDatefin'].'.xls');
    echo 'rapport_statistique_'.$station.'_'.$this->request->data['vDatedebut'].'_'.$this->request->data['vDatefin'].'.xls';
    die();
  }
  /**
   *
   **/
	function getpdfstatremplissage($id_g=null,$role_g=null,$from=null,$to=null,$id=null){
		$this->viewBuilder()->layout('ajax');
		$this->loadModel("Annonces");
		if($role_g=='gestionnaire'){
		  $res=$this->Annonces->find()
							->join([
								'R' => [
									'table' => 'reservations',
									'type' => 'inner',
									'conditions' => ['Annonces.id=R.annonce_id','R.statut'=>90],
								],
								'U' => [
									'table' => 'utilisateurs',
									'type' => 'inner',
									'conditions' => 'U.id=Annonces.proprietaire_id',
                ],
                'G' => [
                  'table' => 'gestionnaires',
                  'type' => 'inner',
                  'conditions' => ['G.id'=>$id_g,'G.id=Annonces.id_gestionnaires']
                ],
								// 'AG' => [
								// 	'table' => 'annoncegestionnaires',
								// 	'type' => 'inner',
								// 	'conditions' => ['AG.id_annonces=Annonces.id','AG.id_gestionnaires'=>$id_g],
								// ],
								'L' => [
									'table' => 'utilisateurs',
									'type' => 'inner',
									'conditions' => 'L.id=R.utilisateur_id',
								],
							]);
		}else{
			$res=$this->Annonces->find()
							->join([
								'R' => [
									'table' => 'reservations',
									'type' => 'inner',
									'conditions' => ['Annonces.id=R.annonce_id','R.statut'=>90],
								],
								'U' => [
									'table' => 'utilisateurs',
									'type' => 'inner',
									'conditions' => 'U.id=Annonces.proprietaire_id',
								],
								'L' => [
									'table' => 'utilisateurs',
									'type' => 'inner',
									'conditions' => 'L.id=R.utilisateur_id',
								],
							]);
		}
		if(!empty($from))
			$sWhere[]="R.dbt_at >= '".date('Y-m-d',strtotime($from))."' ";
		if(!empty($to))
			$sWhere[]= "R.dbt_at <= '".date('Y-m-d',strtotime($to))."' ";
		if(!empty($id))
			$sWhere[]= "Annonces.id = $id ";
		$res->select(['Annonces.id','Annonces.num_app', 'U.prenom', 'U.nom_famille', 'U.telephone', 'U.portable','L.prenom', 'L.nom_famille','L.email', 'L.telephone', 'L.portable', 'R.dbt_at', 'R.fin_at', 'R.nb_enfants', 'R.nb_adultes']);
		$res->where([$sWhere]);
		require_once(ROOT . DS . 'vendor' . DS . "Excel/PHPExcel.php");
   	$workbook = new PHPExcel;
		$sheet = $workbook->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setWidth(45);
		$sheet->getColumnDimension('D')->setWidth(20);
		$sheet->getColumnDimension('E')->setWidth(20);
		$sheet->getColumnDimension('F')->setWidth(13);
		$sheet->getColumnDimension('G')->setWidth(13);
		$sheet->getColumnDimension('H')->setWidth(45);
		$sheet->getColumnDimension('I')->setWidth(45);
		$sheet->getColumnDimension('J')->setWidth(30);
		$sheet->getColumnDimension('K')->setWidth(30);

		$sheet->setCellValue('A1', 'ID');
		$sheet->getStyle("A1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(13)
                                ->getColor()->setRGB('dd4b39');

		$sheet->setCellValue('B1', 'N°App');
		$sheet->getStyle("B1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(13)
                                ->getColor()->setRGB('dd4b39');
		$sheet->setCellValue('C1', 'Propriétaire');
		$sheet->getStyle("C1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(13)
                                ->getColor()->setRGB('dd4b39');

		$sheet->setCellValue('D1', 'Date début');
		$sheet->getStyle("D1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(13)
                                ->getColor()->setRGB('dd4b39');
		$sheet->setCellValue('E1', 'Date fin');
		$sheet->getStyle("E1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(13)
                                ->getColor()->setRGB('dd4b39');
		$sheet->setCellValue('F1', 'Adulte');
		$sheet->getStyle("F1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(13)
                                ->getColor()->setRGB('dd4b39');
		$sheet->setCellValue('G1', 'Enfant');
		$sheet->getStyle("G1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(13)
                                ->getColor()->setRGB('dd4b39');
		$sheet->setCellValue('H1', 'Locataire');
		$sheet->getStyle("H1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(13)
                                ->getColor()->setRGB('dd4b39');

		$sheet->setCellValue('I1', 'E-mail locataire');
		$sheet->getStyle("I1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(13)
                                ->getColor()->setRGB('dd4b39');
		$sheet->setCellValue('J1', 'Tél locataire');
		$sheet->getStyle("J1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(13)
                                ->getColor()->setRGB('dd4b39');
		$sheet->setCellValue('K1', 'Portable locataire');
		$sheet->getStyle("K1")->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(13)
                                ->getColor()->setRGB('dd4b39');
		$i=1;
		foreach($res as $key=>$val){
			$i++;
			$sheet->setCellValue('A'.$i, $val->id);
			$sheet->setCellValue('B'.$i, $val->num_app);
			$sheet->setCellValue('C'.$i, $val['U']['prenom']." ".$val['U']['nom_famille']);
			$sheet->setCellValue('D'.$i, date("d-m-Y", strtotime($val['R']['dbt_at'])));
			$sheet->setCellValue('E'.$i, date("d-m-Y", strtotime($val['R']['fin_at'])));
			$sheet->setCellValue('F'.$i, $val['R']['nb_adultes']);
			$sheet->setCellValue('G'.$i, $val['R']['nb_enfants']);
			$sheet->setCellValue('H'.$i, $val['L']['prenom']." ".$val['L']['nom_famille']);
			$sheet->setCellValue('I'.$i, $val['L']['email']);
			$sheet->setCellValue('J'.$i, $val['L']['telephone']);
			$sheet->setCellValue('K'.$i, $val['L']['portable']);
		}
		$writer = new PHPExcel_Writer_Excel5($workbook);
		$writer->save(ROOT.DS.'webroot'.DS.'gestionnaire'.DS.'stat_remplissage.xls');
		$this->set('a_contrat',$res);
	}
  /**
   *
   **/
	public function modelcontrat(){
		$this->viewBuilder()->layout('manager');

		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->set('InfoGes',$gestionnaire);

		$this->loadModel("Contratypes");
		$contrats = $this->Contratypes->find('all');
		$this->set('contrats',$contrats);
	}
  /**
   *
   **/
	public function editmodelcontrat($id=null){
		$this->viewBuilder()->layout('manager');

		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->set('InfoGes',$gestionnaire);

		if($session->check("Modelcontrat.add")){
			$this->set('confirm_res','reservation');
			$session->delete("Modelcontrat.add");
		}
		$this->loadModel("Contratypes");
		$modelcontrat = $this->Contratypes->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$data=array('type'=>$this->request->data['type'],'contrat'=>$this->request->data['contrat']);
      $modelcontrat = $this->Contratypes->patchEntity($modelcontrat, $data);
      if ($this->Contratypes->save($modelcontrat)) {
        $session->write("Modelcontrat.add","addcontrat");
				return $this->redirect(['action' => 'editmodelcontrat',$modelcontrat->id]);
      }
    }
		$this->set(compact('modelcontrat'));
    $this->set('_serialize', ['modelcontrat']);
    
    $this->loadModel("Variabledynamiques");
    $listab = [];
    //$listab[0] = "Choisir le nom";
    $l_variables = $this->Variabledynamiques->find();
    foreach ($l_variables as $value) {
      $listab[$value->id] = $value->nom;
    }
    $this->set('l_variables', $listab);

    $listabvardyn = [];
    $listvariablecontrat = explode(";", $modelcontrat->variables_id);
    foreach ($listvariablecontrat as $key) {
      if($key != 2){
        $vardyn = $this->Variabledynamiques->find()->where(['id' => $key])->first();
      if($vardyn) $listabvardyn[$key] = $vardyn->nom;
      }      
    }
    $this->set('listvariablecontrat', $listabvardyn);

    $this->loadModel("Optionscontrats");
    $listaboptions = [];
    $listoptionscontrat = explode(";", $modelcontrat->options_id);
    foreach ($listoptionscontrat as $key) {
      $varoption = $this->Optionscontrats->find()->where(['id' => $key])->first();
      if($varoption) $listaboptions[$key] = $varoption->titre;
    }
    $this->set('listoptioncontrat', $listaboptions);
	}
  /**
   *
   **/
	public function stations(){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
    $this->set('InfoGes',$gestionnaire);
    
    $this->loadModel("Stations");
    if($gestionnaire['G']['role']=='admin')
      $listestations = $this->Stations->getListeStations(null);
    else
		  $listestations = $this->Stations->getListeStations($gestionnaire['G']['id']);
		$this->set('listestations', $listestations);
	}
  /**
   *
   **/
	public function addperiodestation(){
           // dd($this->request->getParam('prefix'));
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->set('InfoGes',$gestionnaire);

		$this->loadModel("Stations");
		$this->loadModel("Lieugeos");
    $enrs = $this->Lieugeos->getLieugeosForGest($gestionnaire['G']);
    $ar[]="";
    foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		$this->set("l_lieugeos",$ar);
		if($session->check("Stations.add")){
			$this->set('confirm_res',$session->read('Stations.add'));
			$session->delete("Stations.add");
		}
		if($session->check("Stations.addError")){
			$this->set('error_res',$session->read('Stations.addError'));
			$session->delete("Stations.addError");
		}
		if ($this->request->is(['patch', 'post', 'put'])) {
//                    //test validator
//                        $validator = new Validator();
//                        $validator
//                            ->add('ouverture', 'validFormat', [
//                                'rule' => array('custom', '/^([0-2][0-9]|(3)[0-1])(-)(((0)[0-9])|((1)[0-2]))(-)\d{4}$/i'),
//                                'message' => 'E-mail must be valid'
//                            ])
//                            ->add('station', 'validFormat', [
//                                'rule' => 'email',
//                                'message' => 'E-mail must be valid'
//                            ]);
//                        $errors = $validator->errors($this->request->getData());
//                        if (!empty($errors)) {dd($errors);}
//                    //end test validator
			if($this->request->data['station'] != "" && $this->request->data['ouverture'] != "" && $this->request->data['fermeture'] != ""){
					$data=array('station_id'=>$this->request->data['station'],'ouverture'=>$this->request->data['ouverture'],'fermeture'=>$this->request->data['fermeture']);
          $periodestation = $this->Stations->newEntity($data);
          if ($this->Stations->save($periodestation)) {
              $session->write("Stations.add","addstation");
							return $this->redirect(['action' => 'addperiodestation']);
          }
			}else{
				$session->write("Stations.addError","addstation");
				return $this->redirect(['action' => 'addperiodestation']);
			}
    }
	}
  /**
   *
   **/
	public function editperiodestation($id){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->set('InfoGes',$gestionnaire);

		$this->loadModel("Stations");
		$periode_station = $this->Stations->get($id);
		$this->set('periode', $periode_station);

		$this->loadModel("Lieugeos");
    $enrs = $this->Lieugeos->getLieugeosForGest($gestionnaire['G']);
		$this->set("l_lieugeos",$enrs);

		if($session->check("Stations.add")){
			$this->set('confirm_res',$session->read('Stations.add'));
			$session->delete("Stations.add");
		}
		if($session->check("Stations.addError")){
			$this->set('error_res',$session->read('Stations.addError'));
			$session->delete("Stations.addError");
		}
		if ($this->request->is(['patch', 'post', 'put'])) {
			if($this->request->data['station'] != "" && $this->request->data['ouverture'] != "" && $this->request->data['fermeture'] != ""){
					$data=array('station_id'=>$this->request->data['station'],'ouverture'=>$this->request->data['ouverture'],'fermeture'=>$this->request->data['fermeture']);
					$periode_station = $this->Stations->get($this->request->data['id']);
          $periodestation = $this->Stations->patchEntity($periode_station,$data);
          if ($this->Stations->save($periodestation)) {
            $session->write("Stations.add","addstation");
						return $this->redirect(['action' => 'editperiodestation',$this->request->data['id']]);
          }
			}else{
				$session->write("Stations.addError","addstation");
				return $this->redirect(['action' => 'editperiodestation',$this->request->data['id']]);
			}
    }
	}
  /**
   *
   **/
	public function deleteperiodestation($id){
		$this->loadModel('Stations');
    $station = $this->Stations->get($id);
    $this->Stations->delete($station);
    die();
	}
  /**
   *
   **/
	public function vacances(){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->set('InfoGes',$gestionnaire);

		$this->loadModel("Vacances");
		$listevacances = $this->Vacances->getListeVacances();
		$this->set('listevacances', $listevacances);
	}
  /**
   *
   **/
	public function addvacance(){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->set('InfoGes',$gestionnaire);

		$this->loadModel("Vacances");
		$this->loadModel("Pays");
		$enrs = $this->Pays->find("all");
		$this->set("pays",$enrs);
		$type=array("0"=>"","10"=>"Afrique","20"=>"Amérique","30"=>"Asie","40"=>"Europe","50"=>"France","60"=>"France zone A","70"=>"France zone B","80"=>"France zone C","90"=>"Océanie");
		$this->set("type",$type);
		$zonesvac=array("0"=>"","10"=>"Canton","20"=>"District","30"=>"Lander","40"=>"Province","50"=>"Région","60"=>"Zone");
		$this->set("zonesvac",$zonesvac);
		if($session->check("Vacances.add")){
			$this->set('confirm_res',$session->read('Vacances.add'));
			$session->delete("Vacances.add");
		}
		if($session->check("Vacances.addError")){
			$this->set('error_res',$session->read('Vacances.addError'));
			$session->delete("Vacances.addError");
		}
		if ($this->request->is(['patch', 'post', 'put'])) {
			if($this->request->data['pays_id'] != "" && $this->request->data['titre'] != "" && $this->request->data['dbt_vac'] != "" && $this->request->data['fin_vac'] != "" && $this->request->data['type'] != ""){
					$data=array('pays_id'=>$this->request->data['pays_id'],'titre'=>$this->request->data['titre'],'dbt_vac'=>$this->request->data['dbt_vac'],'fin_vac'=>$this->request->data['fin_vac'],'type'=>$this->request->data['type'],'zone_champ_vac'=>$this->request->data['zonechampvac'],'commentaire_vac'=>$this->request->data['commentairevac']);
					$dataPays = array('subdivision'=>$this->request->data['zonevac']);
					$paysdata = $this->Pays->get($this->request->data['pays_id']);
					$paysupdate = $this->Pays->patchEntity($paysdata,$dataPays);
					$this->Pays->save($paysupdate);
          $nouvellevacance = $this->Vacances->newEntity($data);
          if ($this->Vacances->save($nouvellevacance)) {
              $session->write("Vacances.add","addvacance");
							return $this->redirect(['action' => 'addvacance']);
          }
			}else{
				$session->write("Vacances.addError","addvacance");
				return $this->redirect(['action' => 'addvacance']);
			}
    }
	}
  /**
   *
   **/
	public function deletevacance($id){
            $this->loadModel('Vacances');
            $vacance = $this->Vacances->get($id);
            $this->Vacances->delete($vacance);
            die();
	}
  /**
   *
   **/
	public function editvacance($id){
		$this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->set('InfoGes',$gestionnaire);

		$this->loadModel("Vacances");
		$periode_vacance = $this->Vacances->get($id);
		$this->set('vacance', $periode_vacance);

		$this->loadModel("Pays");
		$tabzonespays = [];
    $enrs = $this->Pays->find("all");
		foreach ($enrs as $value) {
			$tabzonespays[$value->id_pays] = $value->subdivision;
		}
		$this->set("pays",$enrs);
		$this->set("tabzonespays",$tabzonespays);

		if($session->check("Vacances.add")){
			$this->set('confirm_res',$session->read('Vacances.add'));
			$session->delete("Vacances.add");
		}
		if($session->check("Vacances.addError")){
			$this->set('error_res',$session->read('Vacances.addError'));
			$session->delete("Vacances.addError");
		}
		if ($this->request->is(['patch', 'post', 'put'])) {
			if($this->request->data['pays_id'] != "" && $this->request->data['titre'] != "" && $this->request->data['dbt_vac'] != "" && $this->request->data['fin_vac'] != "" && $this->request->data['type'] != ""){
					$data=array('pays_id'=>$this->request->data['pays_id'],'titre'=>$this->request->data['titre'],'dbt_vac'=>$this->request->data['dbt_vac'],'fin_vac'=>$this->request->data['fin_vac'],'type'=>$this->request->data['type'],'zone_champ_vac'=>$this->request->data['zonechampvac'],'commentaire_vac'=>$this->request->data['commentairevac']);
					$nouvellevacance = $this->Vacances->get($this->request->data['id']);
          $periodevacance = $this->Vacances->patchEntity($nouvellevacance,$data);
					$dataPays = array('subdivision'=>$this->request->data['zonevac']);
					$paysdata = $this->Pays->get($this->request->data['pays_id']);
					$paysupdate = $this->Pays->patchEntity($paysdata,$dataPays);
					$this->Pays->save($paysupdate);
          if ($this->Vacances->save($periodevacance)) {
              $session->write("Vacances.add","addvacance");
							return $this->redirect(['action' => 'editvacance',$this->request->data['id']]);
          }
			}else{
				$session->write("Vacances.addError","addvacance");
				return $this->redirect(['action' => 'editvacance',$this->request->data['id']]);
			}
    }
	}
  /**
   *
   **/
	public function editpartitionzone(){
		if(!empty($_FILES)){
  		$prefixe = $_SERVER['DOCUMENT_ROOT'];
  		$destname = $prefixe."/webroot/img/uploads/";
  		$name="partitionzones.jpg";
  		move_uploaded_file($_FILES["image"]["tmp_name"], $destname.$name);
		}
		return $this->redirect(['action' => 'editvacance',$this->request->data['id']]);
		$this->autoRender = false;
	}
  /**
   *
   **/
  public function codereduction(){
    $this->viewBuilder()->layout('manager');
  	$session = $this->request->session();
  	$this->set('InfoGes',$session->read('Gestionnaire.info'));

    $this->loadModel("Reductions");
    $g=$session->read('Gestionnaire.info');
    $codes = $this->Reductions->arraycodesreductions($g['G']['id']);
    $this->set("codes", $codes);
  }
  /**
   *
   **/
  public function addcodereduction(){
    $this->viewBuilder()->layout('manager');
    $session = $this->request->session();
    $this->set('InfoGes',$session->read('Gestionnaire.info'));
    if($session->check("Stations.add")){
     $this->set('confirm_res',$session->read('Stations.add'));
     $session->delete("Stations.add");
    }
    if($session->check("Stations.addError")){
     $this->set('error_res',$session->read('Stations.addError'));
     $session->delete("Stations.addError");
    }

    $this->loadModel("Reductions");
    $g=$session->read('Gestionnaire.info');
    if ($this->request->is(['patch', 'post', 'put'])) {
     if($this->request->data['code'] != "" && $this->request->data['valeur'] != "" && $this->request->data['ouverture'] != "" && $this->request->data['fermeture'] != ""){
         $data=array('code_reduction'=>$this->request->data['code'],'valeur'=>$this->request->data['valeur'],'dbt_validite'=>$this->request->data['ouverture'],'fin_validite'=>$this->request->data['fermeture'],'gestionnaire_id'=>$g['G']['id']);
         $codereduction = $this->Reductions->newEntity($data);
         if ($this->Reductions->save($codereduction)) {
             $session->write("Stations.add","addstation");
             return $this->redirect(['action' => 'addcodereduction']);
         }
     }else{
         $session->write("Stations.addError","addstation");
         return $this->redirect(['action' => 'addcodereduction']);
     }
   }
 }
 /**
  *
  **/
  public function editcodereduction($code_id){
    $this->viewBuilder()->layout('manager');
 		$session = $this->request->session();
 		$gestionnaire=$session->read('Gestionnaire.info');
 		$this->set('InfoGes',$gestionnaire);

 		$this->loadModel("Reductions");
 		$code = $this->Reductions->get($code_id);
 		$this->set('code', $code);

 		if($session->check("Stations.add")){
 			$this->set('confirm_res',$session->read('Stations.add'));
 			$session->delete("Stations.add");
 		}
 		if($session->check("Stations.addError")){
 			$this->set('error_res',$session->read('Stations.addError'));
 			$session->delete("Stations.addError");
 		}
    $this->loadModel("Reductions");
    $g=$session->read('Gestionnaire.info');
 		if ($this->request->is(['patch', 'post', 'put'])) {
      if($this->request->data['code'] != "" && $this->request->data['valeur'] != "" && $this->request->data['ouverture'] != "" && $this->request->data['fermeture'] != ""){
         $data=array('code_reduction'=>$this->request->data['code'],'valeur'=>$this->request->data['valeur'],'dbt_validite'=>$this->request->data['ouverture'],'fin_validite'=>$this->request->data['fermeture'],'gestionnaire_id'=>$g['G']['id']);
 				 $code_reduction = $this->Reductions->get($code_id);
         $codereduction = $this->Reductions->patchEntity($code_reduction,$data);
         if ($this->Reductions->save($codereduction)) {
            $session->write("Stations.add","addstation");
						return $this->redirect(['action' => 'editcodereduction',$code_id]);
         }
			}else{
				$session->write("Stations.addError","addstation");
				return $this->redirect(['action' => 'editcodereduction',$code_id]);
			}
   }
 }
 /**
  *
  **/
  public function deletecodereduction($code_id){
   $this->loadModel('Reductions');
   $code = $this->Reductions->get($code_id);
   $this->Reductions->delete($code);
   die();
  }
  /**
   *
   **/
  public function commentaires(){
    $this->viewBuilder()->layout('manager');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->set('InfoGes',$gestionnaire);

  }
  /**
   *
   **/
  public function editcommentaire($id){
    $this->viewBuilder()->layout('ajax');
    $this->loadModel('Ratings');
    $this->loadModel('Feedbacks');
    $listerations = $this->Ratings->find()->where(['feedback_id = '.$id]);
    $this->set('listerations', $listerations);
    $commentaire = $this->Feedbacks->get($id);
    $this->set('commentaire', $commentaire);
  }
  /**
   *
   **/
  public function arraycommentaires(){
    //Liste Feedbacks
    $this->loadModel('Feedbacks');
    $url=Router::url('/');
    $session = $this->request->session();
    $gestionnaire=$session->read('Gestionnaire.info');
    if($gestionnaire['G']['role'] != "admin") $gestInfo = $gestionnaire['G']['id'];
    else $gestInfo = null;
    $output = $this->Feedbacks->getarraycommentaires($url,$this->request->query,$gestInfo);
    echo json_encode($output);
    die();
  }
  /**
   *
   **/
  public function activatecommentaire($id){
    $this->loadModel('Feedbacks');
    $feedid = $this->Feedbacks->get($id);
    //envoiMail
        $this->loadModel('Ratings');
        $datamustache=[];
        $listerations = $this->Ratings->find()->where(['feedback_id = '.$id]);
        //calcul note globale
        $datamustache['noteGlobale']=0;
        foreach ($listerations as $reaction){
            $datamustache['noteGlobale']+=$reaction->note;
        }
        $datamustache['noteGlobale']=round($datamustache['noteGlobale']/3, 1);
        //fin calcul note globale
        
        $datamustache['commentaire']=$feedid->commentaire;
        
        $datamustache['annonce']=$feedid->annonce_id;
        
        $this->loadModel('Utilisateurs');
        $loc=$this->Utilisateurs->get($feedid->utilisateur_id);
        $datamustache['prenom']=$loc->prenom;
        $datamustache['nom']=$loc->nom_famille;
        
        $this->loadModel('Annonces');
        $prop=$this->Utilisateurs->get($this->Annonces->get($feedid->annonce_id)->proprietaire_id);
        $datamustache['prenomprop']=$prop->prenom;
        $datamustache['nomprop']=$prop->nom_famille;
        
        $this->loadModel('Modelmailsysteme');
        $mail_base = [];
        $mail_text_must = [];
        $textEmail = $this->Modelmailsysteme->find('all');
        foreach ($textEmail as $key => $value) {
                $mail_base[$value->titre] = $value->sujet;
                $mail_text_must[$value->titre] = $value->txtmail;
        }
        $m = new Mustache_Engine;
        $text = $m->render($mail_text_must['valideCommentaire'], $datamustache);
        $sujet = $m->render($mail_base['valideCommentaire'], $datamustache);
        $email = new Email('production');
        $this->loadModel('Registres');
        $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
        $mail=$mails->first();
        $email->template('valideCommentaire', 'default')
                    ->emailFormat('html')
                    ->to($prop->email)
                    ->from([$mail->val=>FROM_MAIL])
                    ->subject($sujet)
                    ->viewVars(['valideCommentaire'=>$text])
                    ->send();
        Log::write('info', 'Send mail "valideCommentaire" to '.$prop->email);
    //End envoiMail
    $data=array("activated" => 1);
    $feedback = $this->Feedbacks->patchEntity($feedid, $data);
    $this->Feedbacks->save($feedback);
    die;
  }
  /**
   *
   **/
  public function desactivatecommentaire($id){
    $this->loadModel('Feedbacks');
    $feedid = $this->Feedbacks->get($id);
    $data=array("activated" => 0);
    $feedback = $this->Feedbacks->patchEntity($feedid, $data);
    $this->Feedbacks->save($feedback);
    die;
  }
  /**
   *
   **/
  public function deletecommentaire($id){
    $this->loadModel('Feedbacks');
    $feedid = $this->Feedbacks->get($id);
    $result = $this->Feedbacks->delete($feedid);
    die;
  }
  
  public function checkLoginUnique($id = null,$requestedLogin = null){
      $this->loadModel('Gestionnaires');
        if($id!="null"){
            $utilisateur = $this->Gestionnaires->get($id);
              if($utilisateur->login==$requestedLogin) {echo 'true'; die();}
              else {
                  $user=$this->Gestionnaires->find()->where(['login' => $requestedLogin])->first();
                  if($user==null)  echo 'true';
                  else echo 'false';
              }
        }
        else{
            $user=$this->Gestionnaires->find()->where(['login' => $requestedLogin])->first();
                  if($user==null)  echo 'true';
                  else echo 'false';
        }
        die();
  }
  
  public function checkStationUnique($id = null,$requestedTelephone = null){
    $this->loadModel('Gestionnaires');
    if($id!="null"){
        $utilisateur = $this->Gestionnaires->get($id);
          if($utilisateur->telephone==$requestedTelephone) {echo 'true'; die();}
          else {
              $user=$this->Gestionnaires->find()->where(['station' => $requestedTelephone])->first();
              if($user==null)  echo 'true';
              else echo 'false';
          }
    }
    else{
        $user=$this->Gestionnaires->find()->where(['station' => $requestedTelephone])->first();
              if($user==null)  echo 'true';
              else echo 'false';
    }
    die();
  }
  public function checkPhoneUnique($id = null,$requestedIdStation = null){
    $this->loadModel('Gestionnaires');
      if($id!="null"){
          $utilisateur = $this->Gestionnaires->get($id);
            if($utilisateur->telephone==$requestedIdStation) {echo 'true'; die();}
            else {
                $user=$this->Gestionnaires->find()->where(['telephone' => $requestedIdStation])->first();
                if($user==null)  echo 'true';
                else echo 'false';
            }
      }
      else{
          $user=$this->Gestionnaires->find()->where(['telephone' => $requestedIdStation])->first();
                if($user==null)  echo 'true';
                else echo 'false';
      }
      die();
}

public function checkMobileUnique($id = null,$requestedmobile = null){
  $this->loadModel('Gestionnaires');
    if($id!="null"){
        $utilisateur = $this->Gestionnaires->get($id);
          if($utilisateur->mobile==$requestedmobile) {echo 'true'; die();}
          else {
              $user=$this->Gestionnaires->find()->where(['mobile' => $requestedmobile])->first();
              if($user==null)  echo 'true';
              else echo 'false';
          }
    }
    else{
        $user=$this->Gestionnaires->find()->where(['mobile' => $requestedmobile])->first();
              if($user==null)  echo 'true';
              else echo 'false';
    }
    die();
}

  public function checkEmailUnique($id = null,$requestedEmail = null){
      $this->loadModel('Gestionnaires');
        if($id!="null"){
            $utilisateur = $this->Gestionnaires->get($id);
              if($utilisateur->email==$requestedEmail) {echo 'true'; die();}
              else {
                  $user=$this->Gestionnaires->find()->where(['email' => $requestedEmail])->first();
                  if($user==null)  echo 'true';
                  else echo 'false';
              }
        }
        else{
            $user=$this->Gestionnaires->find()->where(['email' => $requestedEmail])->first();
                  if($user==null)  echo 'true';
                  else echo 'false';
        }
        die();
  }
  
    function sendmailCommentaire($mailprop){
		$this->viewBuilder()->layout('ajax');
		$session = $this->request->session();
		$gestionnaire=$session->read('Gestionnaire.info');
		$this->set('gestionn',$gestionnaire);
                $this->set('propmail',$mailprop);
    }
    
    function confirmsendmailCommentaire(){
		$email = new Email('production');
		$email->template('msgToLocataire', 'default')
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
   */
  function addvariabletocontratype($id, $newvariablesave){
    $this->viewBuilder()->layout(false);
    $this->loadModel('Contratypes');
    $contratype = $this->Contratypes->get($id);
    if(is_null($contratype->variables_id)) $variables_id = $newvariablesave.";";
    else $variables_id = ($contratype->variables_id).$newvariablesave.";";
    $data=array('variables_id'=>$variables_id);
    $newcontratype = $this->Contratypes->patchEntity($contratype, $data);
    $this->Contratypes->save($newcontratype);
  }
  /**
   * 
   */
  function addoptiontocontratype($id, $newoptionsave){
    $this->viewBuilder()->layout(false);
    $this->loadModel('Contratypes');
    $contratype = $this->Contratypes->get($id);
    if(is_null($contratype->options_id)) $options_id = $newoptionsave.";";
    else $options_id = ($contratype->options_id).$newoptionsave.";";
    $data=array('options_id'=>$options_id);
    $newcontratype = $this->Contratypes->patchEntity($contratype, $data);
    $this->Contratypes->save($newcontratype);
  }
  /**
   * 
   */
  function addvariabledynamique($id){
    $this->viewBuilder()->layout(false);
    $this->loadModel('Variabledynamiques');
    // $variable = $this->Variabledynamiques->find()->where(['id' => $this->request->data["nom"]]);
    // if(!$variable->first()){
      $newvariable = $this->Variabledynamiques->newEntity($this->request->data);
      if($newvariablesave = $this->Variabledynamiques->save($newvariable)){
        $this->addvariabletocontratype($id, $newvariablesave->id);
        $this->set('nouvelleID',$newvariablesave->id);
      }
    // }else{
    //   $this->addvariabletocontratype($id, $this->request->data["nom"]);
    //   $var = $variable->first();
    //   $this->set('nouvelleID',$var->id);
    // }
    $this->set('nouvelle',$this->request->data["nom"]);    
  }
  /**
   * 
   */
  function modifvariabledynamique(){
    $this->viewBuilder()->layout(false);
    $this->loadModel('Variabledynamiques');
    $variable = $this->Variabledynamiques->get($this->request->data["id"]);
    $data = array('nom' => $this->request->data["nom"]);
    $editvar = $this->Variabledynamiques->patchEntity($variable, $data);
    $this->Variabledynamiques->save($editvar);
    $this->set('nouvelle',$this->request->data["nom"]);  
  }
  /**
   * 
   */
  function supprimvariabledynamique(){
    $this->viewBuilder()->layout(false);
    $this->loadModel('Contratypes');
    //////supprimer du contrat/////
    $contratype = $this->Contratypes->get($this->request->data["id"]);
    $listabvardyn = [];
    $listnewvar = "";
    $listvariablecontrat = explode(";", $contratype->variables_id);
    $str = str_replace($this->request->data['idvar'].";", "", $contratype->variables_id);
    $data = array("variables_id" => $str);
    $suppvar = $this->Contratypes->patchEntity($contratype, $data);
    $this->Contratypes->save($suppvar);
  }
  /**
   * 
   */
  function supprimoptioncontrat(){
    $this->viewBuilder()->layout(false);
    $this->loadModel('Contratypes');
    //////supprimer du contrat/////
    $contratype = $this->Contratypes->get($this->request->data["id"]);
    $listabvardyn = [];
    $listnewvar = "";
    $listvariablecontrat = explode(";", $contratype->options_id);
    $pos = strpos($contratype->options_id, $this->request->data['idoption'].";");
    // print_r($pos);
    // print_r(gettype($pos));
    if($pos == 0){
      // $str = str_replace($this->request->data['idoption'].";", "", $contratype->options_id);
      $pos1 = strpos($contratype->options_id, $this->request->data['idoption'].";");
      $str = substr_replace($contratype->options_id, "", $pos1, strlen($this->request->data['idoption'].";"));
    }else{
      $pos2 = strpos($contratype->options_id, ";".$this->request->data['idoption'].";");
      $str = substr_replace($contratype->options_id, "", $pos2+1, strlen($this->request->data['idoption'].";"));      
    }
    $data = array("options_id" => $str);
    $suppvar = $this->Contratypes->patchEntity($contratype, $data);
    $this->Contratypes->save($suppvar);
  }
  /**
   * 
   */
  function addoptiontocontrat($id){
    $this->viewBuilder()->layout(false);
    $this->loadModel('Optionscontrats');
    $varoptions = '2;3;4;5;';
    foreach ($this->request->data['variables'] as $value) {
      $varoptions .= $value.";";
    }
    $data = array('titre' => $this->request->data['titre'], 'text' => $this->request->data['text'], 'variables_id' => $varoptions);
    $newoption = $this->Optionscontrats->newEntity($data);
    if($addnewoption = $this->Optionscontrats->save($newoption)){
      $this->addoptiontocontratype($id, $addnewoption->id);
      $this->set('nouvelleid',$addnewoption->id);
    }
    $this->set('nouvellenom',$this->request->data['titre']);
  }
  /**
   * 
   */
  function modifoptiontocontrat($id){
    $this->viewBuilder()->layout(false);
    $this->loadModel('Optionscontrats');
    $optionmodif = $this->Optionscontrats->get($this->request->data['idmodifoption']);
    $varoptions = '2;3;4;5;';
    foreach ($this->request->data['variables'] as $value) {
      $varoptions .= $value.";";
    }
    $data = array('titre' => $this->request->data['titre'], 'text' => $this->request->data['text'], 'variables_id' => $varoptions);
    $newoption = $this->Optionscontrats->patchEntity($optionmodif, $data);
    $addnewoption = $this->Optionscontrats->save($newoption);
    $this->set('nouvellenom',$this->request->data['titre']);
  }
  /**
   * 
   */
  function detailoption(){
    $this->viewBuilder()->layout(false);
    $this->loadModel('Optionscontrats');
    $this->loadModel('Variabledynamiques');
    $detailoption = $this->Optionscontrats->get($this->request->data['id']);
    $listabvardyn = [];
    $listvariablecontrat = explode(";", $detailoption->variables_id);
    foreach ($listvariablecontrat as $key) {
      $vardyn = $this->Variabledynamiques->find()->where(['id' => $key])->first();
      if($vardyn) $listabvardyn[$key] = $vardyn->nom;
    }
    $this->set('listevardynoption',$listabvardyn);
    $this->set('detailoption',$detailoption);

    if($this->request->data['contratid']){
      $this->loadModel('Contratypes');
      $contratype = $this->Contratypes->get($this->request->data['contratid']);
      $listabvardyncontrat = [];
      $listvariablecontrat = explode(";", $contratype->variables_id);
      foreach ($listvariablecontrat as $key) {
        $vardyn = $this->Variabledynamiques->find()->where(['id' => $key])->first();
        if($vardyn) $listabvardyncontrat[$key] = $vardyn->nom;
      }
      $this->set('listabvardyncontrat',$listabvardyncontrat);
    }
    
  }
  /**
   * 
   */
  function previewcontrat(){
    $this->viewBuilder()->layout(false);
    $searcharray = array();
    parse_str($this->request->data['listvar'], $searcharray);
    $datamustache = [];
    $this->loadModel('Contratypes');
    $contratype = $this->Contratypes->get($searcharray['type']);
    //ajouter les valeurs des variables du contrat
    $this->loadModel('Optionscontrats');
    $this->loadModel('Variabledynamiques');
    $this->loadModel('Varoptioncontrats');
    $listabvardyn = [];
    // $listvariablecontrat = explode(";", $contratype->variables_id);
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
      $msgperiode = "";     
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
          $text_option .= "<h4>".$vardynopt->titre."</h4><br>".$textcontratoption.$msgperiode."<br>";
        }
      }
      
    }    
    if(!empty($taboption)) $anciennevaleur = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id != '=>0, 'option_id NOT IN '=>$taboption]);
    else $anciennevaleur = $this->Varoptioncontrats->find()->where(['contrat_id'=>$searcharray['id'], 'option_id != '=>0]);
    // ->andWhere(function ($exp, $q) {
    //   return $exp->notIn('option_id', $taboption);
    // });
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
                  $date = $today->year."-".$searcharray['mois_date_'.$i.'_'.$keyopt]."-".$searcharray['jour_date_'.$i.'_'.$keyopt];
                  if(new Date($date) < $today) $date = ($today->year+1)."-".$searcharray['mois_date_'.$i.'_'.$keyopt]."-".$searcharray['jour_date_'.$i.'_'.$keyopt];
                  $dateAffiche = (new Date($date))->i18nFormat('dd/MM/yyyy');
                  $listedate .= $dateAffiche.", ";
                }
                if($listedate != '') $msgperiode = "<p>Pour le prix de ".$searcharray['optionvar5_'.$keyopt->option_id]." € (unitaire) prestations réalisées ".$searcharray['optionvar'.$value.'_'.$keyopt->option_id]." fois aux dates suivantes : ".$listedate."</p>";
              }
            }                
          }
          $m2 = new Mustache_Engine;
          $textcontratoption = $m2->render($vardynopt->text, $datamustacheoption); 
          $text_option .= "<h4>".$vardynopt->titre."</h4><br>".$textcontratoption.$msgperiode."<br>";
        }
      }
      
    }

    $this->set('previewtext',$textcontrat.$text_option);

  }
  /**
   * 
   */
  function detailvar(){
    $this->viewBuilder()->layout(false);
    $this->loadModel('Variabledynamiques');
    $vardyn = $this->Variabledynamiques->find()->where(['id' => $this->request->data['id']])->first();
    $this->set('nommodif',$vardyn->nom);
    $this->set('idmodif',$vardyn->id);

  }
  /**
   * 
   */
  function ajoutervariabledynamique(){
    $this->viewBuilder()->layout(false);
    $this->loadModel('Variabledynamiques');
    $newvariable = $this->Variabledynamiques->newEntity(array("nom" => $this->request->data['nom'], "type" => "gest"));
    $newvariablesave = $this->Variabledynamiques->save($newvariable);
    $this->set('nouvelleID',$newvariablesave->id);
    $this->set('nouveauNOM',$newvariablesave->nom);
    
  }
  /**
   * 
   */
  public function blocmailgestionnaire()
  {
    $session = $this->request->session();
    if($session->check("Gestionnaire.manuelle")){
      $this->set('confirm_res','reservation');
      $session->delete("Gestionnaire.manuelle");
    }
    $this->viewBuilder()->layout('manager');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));  
    $gest=$session->read('Gestionnaire.info');  

    $this->loadModel('BlocMailGestionnaires');
    if ($this->request->is(['patch', 'post', 'put'])) {
      $blocMailGestionnaire = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => $gest['G']['id']]);
      if($blocMailGestionnaire->first()){        
        $blocMailGestionnairenew = $this->BlocMailGestionnaires->patchEntity($blocMailGestionnaire->first(), $this->request->data);
        $blocMailGestionnaire = $this->BlocMailGestionnaires->save($blocMailGestionnairenew);
      }else{        
        $blocMailGestionnairenew = $this->BlocMailGestionnaires->newEntity($this->request->data);
        $blocMailGestionnaire = $this->BlocMailGestionnaires->save($blocMailGestionnairenew);
      } 
    }

    $blocMailGestionnaire = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => $gest['G']['id']]);
    if($blocMailGestionnaire->first()){
      $this->set('blocMailGestionnaire', $blocMailGestionnaire->first());
    }   
    $blocMailGestionnaireDefault = $this->BlocMailGestionnaires->find()->where(['gestionnaire_id' => 6])->first(); 
    $this->set('blocMailGestionnaireDefault', $blocMailGestionnaireDefault);
  }
  /**
   * 
   */
  public function blocservicemailgestionnaire()
  {
    $session = $this->request->session();
    if($session->check("Gestionnaire.manuelle")){
      $this->set('confirm_res','reservation');
      $session->delete("Gestionnaire.manuelle");
    }
    $this->viewBuilder()->layout('manager');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));

    $this->loadModel('BlocServicesMails');    
    $listeblocservices = $this->BlocServicesMails->find();
    $this->set('blocservicesmailsgests',$listeblocservices);

    $this->loadModel('Gestionnaires'); 
    $listegestionnaires = [];
    $gestionnaires = $this->Gestionnaires->find('all');
    foreach ($gestionnaires as $value) {
      $listegestionnaires[$value->id] = $value->name;
    }
    $this->set('listegestionnaires',$listegestionnaires);
  }
  /**
   * 
   */
  public function addblocservicemailsysteme()
  {
    $session = $this->request->session();
    if($session->check("Gestionnaire.manuelle")){
      $this->set('confirm_res','reservation');
      $session->delete("Gestionnaire.manuelle");
    }
    $this->viewBuilder()->layout('manager');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));

    // $gestionnaires = $this->Gestionnaires->find('all')->where(['id <> 6']);
    $this->loadModel('Lieugeos');
    $listestation = $this->Lieugeos->find('all')->where(["Lieugeos.niveau >= 3"])->order('name');
    $this->set('listegestionnaires',$listestation);

    if ($this->request->is(['patch', 'post', 'put'])) {
      if($this->request->data['bloc_services_mail'] != '' && $this->request->data['bloc_services_mail_en'] != '' && !empty($this->request->data['listegestionnaires'])){
        $this->loadModel('BlocServicesMails');
        $liste_id_gestionnaire = '';
        foreach ($this->request->data['listegestionnaires'] as $key => $value) {
          $liste_id_gestionnaire .= $value.";";
        }
        // $data = array('bloc_services_mail' => $varTexteArea= str_replace('\n', '<br />', nl2br($this->request->data['bloc_services_mail'])), 'liste_id_gestionnaire' =>$liste_id_gestionnaire);
        $data = array('bloc_services_mail' => $this->request->data['bloc_services_mail'], 'bloc_services_mail_en' => $this->request->data['bloc_services_mail_en'], 'liste_id_station' =>$liste_id_gestionnaire);
        $blocServicesMailnew = $this->BlocServicesMails->newEntity($data);
        $this->BlocServicesMails->save($blocServicesMailnew);
      }
    }
  }
  /**
   * 
   */
  public function editblocservice($id)
  {
    $session = $this->request->session();
    if($session->check("Gestionnaire.manuelle")){
      $this->set('confirm_res','reservation');
      $session->delete("Gestionnaire.manuelle");
    }
    $this->viewBuilder()->layout('manager');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));

    // $gestionnaires = $this->Gestionnaires->find('all')->where(['id <> 6']);
    $this->loadModel('Lieugeos');
    $listestation = $this->Lieugeos->find('all')->where(["Lieugeos.niveau >= 3"])->order('name');
    $this->set('listegestionnaires',$listestation);

    $this->loadModel('BlocServicesMails');
    $blocservice = $this->BlocServicesMails->get($id);
    $this->set('blocservice',$blocservice);
    $listegest = [];
    $listegest = explode(";", $blocservice->liste_id_station);
    $this->set('listegest',$listegest);

    if ($this->request->is(['patch', 'post', 'put'])) {      
      // $data = array('bloc_services_mail' => $varTexteArea= str_replace('\n', '<br />', nl2br($this->request->data['bloc_services_mail'])), 'liste_id_gestionnaire' =>$liste_id_gestionnaire);
      if($this->request->data['bloc_services_mail'] != '' && $this->request->data['bloc_services_mail_en'] != '' && !empty($this->request->data['listegestionnaires'])){
        $liste_id_gestionnaire = '';
        foreach ($this->request->data['listegestionnaires'] as $key => $value) {
          $liste_id_gestionnaire .= $value.";";
        }
        $data = array('bloc_services_mail' => $this->request->data['bloc_services_mail'], 'bloc_services_mail_en' => $this->request->data['bloc_services_mail_en'], 'liste_id_station' =>$liste_id_gestionnaire);
        $blocServicesMailnew = $this->BlocServicesMails->patchEntity($blocservice, $data);
        $this->BlocServicesMails->save($blocServicesMailnew);
      }
      
    }
  }

}
