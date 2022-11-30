<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use function GuzzleHttp\json_encode;
use Cake\Routing\Router;
use Cake\Core\Exception\Exception;

class StationsController extends AppController
{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('Massif');
        $this->loadModel('Domaine');
        $this->loadModel('Lieugeos');
        $this->loadModel('WebcamLieugeos');
        //end loading models
        //check auth
        $manager_actions=['index','edit','allstations','webcams','allwebcams','addwebcam','editwebcam','deletewebcam'];
        $admin_actions=['all'];
        $session = $this->request->session();
        if(!$session->check("Gestionnaire.info")){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
        $gest=$session->read('Gestionnaire.info');
        if($gest['G']['role']=="gestionnaire" && !in_array($this->request->getParam('action'), $manager_actions) ){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
        if($admin_actions[0]!='all' && $gest['G']['role']=="admin" && !in_array($this->request->getParam('action'), $admin_actions)){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
        //end check auth
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        //set manager infos
        $session = $this->request->session();
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        //end set manager infos
        $this -> render('index','manager');
    }

    /**
     * allstations method
     * get all stations for data table
     *
     * @return \Cake\Http\json
     */
    public function allstations()
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $idGest=null;
        if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
            $idGest=$this->request->session()->read("Gestionnaire.info")['G']['id'];
        
        $stations = $this->Lieugeos->getAllLieugeos($idGest);
        $data=[];
        $url=Router::url('/',true).'manager/stations/edit/';
        $urlwebcams=Router::url('/',true).'manager/stations/webcams/';
        foreach($stations->toarray() as $station){
            $this->loadModel('Stations');
            //count open stations
            $stationsCount=$this->Stations->findByStationId($station->id)->where('ouverture <= STR_TO_DATE("'.date('Y-m-d').'", "%Y-%m-%d")')
            ->where('fermeture >= STR_TO_DATE("'.date('Y-m-d').'", "%Y-%m-%d")')->count();
            //end count open stations
            $row=[0=>$station->name];
            $row[1]=$stationsCount>0?'<span class="label label-success">Ouverte</span>':'<span class="label label-danger">Fermé</span>';
            $row[2]='';
            //get codes insse
            $this->loadModel('Villages');
            $villages=$this->Villages->findByLieugeoId($station->id)->join([
                'Frville'=>[
                      'table' => 'frvilles',
                      'type' => 'left',
                      'conditions' => 'Frville.id=Villages.id_ville'
                    ]
            ])->select('Frville.code_insee');
            //end get codes insse
            foreach($villages as $village)
            $row[2].="<span class=\"label label-default\">".$village['Frville']['code_insee']."</span> ";
            $row[3]=$station['Domaine']['nom']!=null?$station['Domaine']['nom']:'<span class="text-danger">Pas de domaine</span>';
            $row[4]=$station['Massif']['nom'];
            if($station->from_api == 0) $row[5]="<span class='text-danger'>Non</span>";
            else $row[5]="<span class='text-success'>Oui</span>";
            $row[6]='<div class="text-center">'
            .'<button class="btn btn-sm btn-primary btn-icon-anim btn-circle" onclick="location.href=\''.$urlwebcams.$station->id.'\';"><i class="fa fa-video-camera"></i></button>';
            //if($idGest==null)
            $row[6].='<button class="btn btn-sm btn-default btn-icon-anim btn-circle ml-10" onclick="location.href=\''.$url.$station->id.'\';"><i class="fa fa-pencil"></i></button>';
            if($idGest==null)
            $row[6].='<button class="btn btn-sm btn-info btn-icon-anim btn-circle ml-10 delete_station" data-name="'.$station->name.'" data-key="'.$station->id.'" ><i class="icon-trash"></i></button>'
            .'</div>';
            $data[]=$row;
        }
        echo json_encode(['data'=>$data]);die();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $session = $this->request->session();
        //set manager infos
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        //end set manager infos
        $Lieugeo = $this->Lieugeos->newEntity(null,['associated' => ['Lit']]);
        //check persist success
        if($session->check("Lieugeos.add")){
			$this->set('confirm_res',$session->read('Lieugeos.add'));
			$session->delete("Lieugeos.add");
        }
        //end check persist success
        //check persist error
		if($session->check("Lieugeos.addError")){
			$this->set('error_res',$session->read('Lieugeos.addError'));
			$session->delete("Lieugeos.addError");
        }
        //end check persist error
        if ($this->request->is('post')) {
            $data=$this->request->getData();
            //set null for blank inputs
            $data = array_map( 
                function($row) { return $row==''?null:$row; },
                $data
            );
            //end set null for blank inputs
            if($data['lit'][0]['anne']=='')
            {
                unset($data['lit']);
                $Lieugeo = $this->Lieugeos->newEntity($data);
            }
            else
            {
                $Lieugeo = $this->Lieugeos->patchEntity($Lieugeo, $data);
            }
            //image logo
            $prefixe = $_SERVER['DOCUMENT_ROOT'];
            $destname = "$prefixe/webroot/images/partners/";
            // $destname = "$prefixe/webroot/img/uploads/";
            $file = $this->request->data['image'];
            $ext=explode('/',$file['type']);
            $name="logo_station_".str_replace(" ", "_", $this->request->data['name']);
            $imagineJPG = new Imagine();
            if($ext[1] == "png"){
                $imageupload = $imagineJPG->open($this->request->data['image']['tmp_name']);
                $imageupload->resize(new Box(350, 150));
                $imageupload->save($destname.$name.".png", array('png_compression_level' => 5))
                            ->save($destname.$name.".webp", array('webp_quality' => 85));
            }            
            $Lieugeo->image=$name;
            //image logo
            /** Header été **/
            $destname = "$prefixe/webroot/images/header_station/";
            // $destname = "$prefixe/webroot/img/uploads/";
            $file = $this->request->data['image_header_ete'];
            $ext=explode('/',$file['type']);
            $nameInit = str_replace(' ', '_', $this->request->data['name']); 
            $namespecial = preg_replace('/[^A-Za-z0-9\-]/', '', $nameInit);
            $name="header_ete_station_".$namespecial.".jpg";
            $imagineJPG = new Imagine();
            $imageupload = $imagineJPG->open($this->request->data['image_header_ete']['tmp_name']);
            $imageupload->save($destname.$name, array('jpeg_quality' => 85));
            $Lieugeo->image_header_ete=$name;
            /** Header été **/
            /** Header hiver **/
            $destname = "$prefixe/webroot/images/header_station/";
            // $destname = "$prefixe/webroot/img/uploads/";
            $file = $this->request->data['image_header_hiver'];
            $ext=explode('/',$file['type']);
            $nameInit = str_replace(' ', '_', $this->request->data['name']); 
            $namespecial = preg_replace('/[^A-Za-z0-9\-]/', '', $nameInit);
            $name="header_hiver_station_".$namespecial.".jpg";
            $imagineJPG = new Imagine();
            $imageupload = $imagineJPG->open($this->request->data['image_header_hiver']['tmp_name']);
            $imageupload->save($destname.$name, array('jpeg_quality' => 85));
            $Lieugeo->image_header_hiver=$name;
            /** Header hiver **/

            if ($this->Lieugeos->save($Lieugeo)) {
                $session->write("Lieugeos.add","addLieugeo");
                return $this->redirect(['action' => 'add']);
            }
            else{
                $session->write("Lieugeos.addError","addLieugeo");
            }
        }
        //set massifs list
        $massifs= $this->Massif->find('list', [
            'keyField' => 'id',
            'valueField' => 'nom'
        ])->order('nom');
        $this->set('massifs',$massifs->toArray());
        //end set massifs list
        //set domaines list
        $tabDomaines = [];
        $tabDomaines[0] = "Pas de domaine";
        $domaines= $this->Domaine->find('list', [
            'keyField' => 'id',
            'valueField' => 'nom'
        ])->order('nom')->where(['massif_id'=>$massifs->first()->id]);        
        foreach ($domaines->toArray() as $key => $value) {
            $tabDomaines[$key] = $value;
        }          
        $this->set('domaines',$tabDomaines);
        //end set domaines list
        $this->set(compact('Lieugeo'));
        $this -> render('add','manager');
    }

    public function edit($id)
    {
        $session = $this->request->session();
        //set manager infos
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        //end set manager infos
        $Lieugeo = $this->Lieugeos->get($id);
        //check persist success
        if($session->check("Lieugeos.edit")){
			$this->set('confirm_res',$session->read('Lieugeos.edit'));
			$session->delete("Lieugeos.edit");
        }
        //end check persist success
        //check persist error
		if($session->check("Lieugeos.editError")){
			$this->set('error_res',$session->read('Lieugeos.editError'));
			$session->delete("Lieugeos.editError");
        }
        //end check persist error
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data=$this->request->getData();
            //set null for blank inputs
            $data = array_map( 
                function($row) { return $row==''?null:$row; }, 
                $data
            );
            //end set null for blank inputs
            $data['lit'][0]['lieugeo_id']=$id;
            if($data['lit'][0]['anne']=='')
            {
                $data['id']=$Lieugeo->id;
                unset($data['lit']);
            }   

            if($this->request->getData('image')['name']=='') $data['image']=$Lieugeo->image;   
            if($this->request->getData('image')['image_header_ete']=='')  $data['image_header_ete']=$Lieugeo->image_header_ete;  
            if($this->request->getData('image')['image_header_hiver']=='')  $data['image_header_hiver']=$Lieugeo->image_header_hiver;  

            $Lieugeo = $this->Lieugeos->patchEntity($Lieugeo, $data);   

            if($this->request->getData('image')['name']!=''){
                $prefixe = $_SERVER['DOCUMENT_ROOT'];
                $oldImagePath = "$prefixe/webroot/images/partners/".$Lieugeo->image.".png";
                $oldImagePathWebp = "$prefixe/webroot/images/partners/".$Lieugeo->image.".webp";
                //image
                $destname = "$prefixe/webroot/images/partners/";
                //$destname = "$prefixe/webroot/images/partners/";
                $file = $this->request->data['image'];
                $ext=explode('/',$file['type']);
                $name="logo_station_".str_replace(" ", "_", $this->request->data['name']);
                $imagineJPG = new Imagine();
                if($ext[1] == "png"){
                    unlink($oldImagePath);
                    unlink($oldImagePathWebp);
                    $imageupload = $imagineJPG->open($this->request->data['image']['tmp_name']);
                    $imageupload->resize(new Box(350, 150));
                    $imageupload->save($destname.$name.".png", array('png_compression_level' => 5))
                                ->save($destname.$name.".webp", array('webp_quality' => 85));
                }
                //image
                $Lieugeo->image=$name;
            }

            if($this->request->getData('image_header_ete')['name']!=''){
                /** Header été **/
                $prefixe = $_SERVER['DOCUMENT_ROOT'];
                $oldImageEtePath = "$prefixe/webroot/images/header_station/".$Lieugeo->image_header_ete.".png";
                unlink($oldImageEtePath);
                $destname = "$prefixe/webroot/images/header_station/";
                // $destname = "$prefixe/webroot/img/uploads/";
                $file = $this->request->data['image_header_ete'];
                $ext=explode('/',$file['type']);
                $nameInit = str_replace(' ', '_', $this->request->data['name']); 
                $namespecial = preg_replace('/[^A-Za-z0-9\-]/', '', $nameInit);
                $name="header_ete_station_".$namespecial.".jpg";
                $imagineJPG = new Imagine();
                $imageupload = $imagineJPG->open($this->request->data['image_header_ete']['tmp_name']);
                $imageupload->save($destname.$name, array('jpeg_quality' => 85));
                $Lieugeo->image_header_ete=$name;
                /** Header été **/
            }

            if($this->request->getData('image_header_hiver')['name']!=''){
                /** Header hiver **/
                $prefixe = $_SERVER['DOCUMENT_ROOT'];
                $oldImageHiverPath = "$prefixe/webroot/images/header_station/".$Lieugeo->image_header_hiver.".png";
                unlink($oldImageHiverPath);
                $destname = "$prefixe/webroot/images/header_station/";
                // $destname = "$prefixe/webroot/img/uploads/";
                $file = $this->request->data['image_header_hiver'];
                $ext=explode('/',$file['type']);
                $nameInit = str_replace(' ', '_', $this->request->data['name']); 
                $namespecial = preg_replace('/[^A-Za-z0-9\-]/', '', $nameInit);
                $name="header_hiver_station_".$namespecial.".jpg";
                $imagineJPG = new Imagine();
                $imageupload = $imagineJPG->open($this->request->data['image_header_hiver']['tmp_name']);
                $imageupload->save($destname.$name, array('jpeg_quality' => 85));
                $Lieugeo->image_header_hiver=$name;
                /** Header hiver **/
            }
            

            if ($this->Lieugeos->save($Lieugeo)) {                
                $session->write("Lieugeos.edit","editLieugeo");
                return $this->redirect(['action' => 'edit/'.$Lieugeo->id]);
            }
            else{
                $session->write("Lieugeos.editError","editLieugeo");
            }
        }
        //set massifs list
        $massifs= $this->Massif->find('list', [
            'keyField' => 'id',
            'valueField' => 'nom'
        ])->order('nom')->toArray();
        $this->set('massifs',$massifs);
        //end set massifs list
        //set domaines list
        $tabDomaines = [];
        $tabDomaines[0] = "Pas de domaine";
        $domaines= $this->Domaine->find('list', [
            'keyField' => 'id',
            'valueField' => 'nom'
        ])->order('nom')->where(['massif_id'=>$Lieugeo->massif_id==null?key($massifs):$Lieugeo->massif_id]);
        
        foreach ($domaines->toArray() as $key => $value) {
            $tabDomaines[$key] = $value;
        }          
        $this->set('domaines',$tabDomaines);
        //end set domaines list
        //get
        $this->loadModel('Lit');
        $lits=$this->Lit->find()->where(['lieugeo_id'=>$id])->order(['anne'=>'desc']);
        $this->set('lits',$lits);
        //end get
        $this->set(compact('Lieugeo'));
        $this -> render('edit','manager');
    }

    public function delete($id){
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $lieugeo = $this->Lieugeos->get($id);
        if($this->Lieugeos->delete($lieugeo)) {
            $this->set('res','deleted');
        }else {
            if(!empty($lieugeo->getError('hasChilds')))
                $this->set('res', $lieugeo->getError('hasChilds')[0]);
            else
                throw new Exception(__($lieugeo->getError('hasChilds')[0]));
        }
        $this->set('_serialize', 'res');
    }

    /**
     * Index webcams for station
     *
     * @param $idStation Lieugeo id
     * @return \Cake\Http\Response|void
     */
    public function webcams($idStation){
        $session = $this->request->session();
        //set manager infos
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        //end set manager infos
        $lieugeo=$this->Lieugeos->get($idStation);
        $this->set('lieugeo',$lieugeo);
        $this -> render('stationwebcams','manager');
    }

    /**
     * allwebcams method
     * get all webcams to station for data table
     *
     * @param $idStation Lieugeo id
     * @return \Cake\Http\json
     */
    public function allwebcams($idStation){
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $lieugeo=$this->Lieugeos->findById($idStation)->contain(['WebcamLieugeos'])->first();
        $data=[];
        $url=Router::url( '/', true ).'manager/stations/editwebcam/';
        foreach ($lieugeo->webcam_lieugeos as $webcam){
            $row=[0=>$webcam->nom];
            $row[1]=$webcam->etat==true?'<span class="label label-success">Fonctionnelle</span>':'<span class="label label-danger">Non Fonctionnelle</span>';
            $row[2]=$webcam->url.' <a href="'.$webcam->url.'" target="_blank" class="pt-10 btn btn-warning btn-icon-anim btn-circle"><i class="fa fa-eye"></i></a>';
            $row[3]='<center><button class="btn btn-sm btn-default btn-icon-anim btn-circle editWebcam" data-url="'.$webcam->url.'" data-etat="'.($webcam->etat==true?'1':'0').'" data-nom="'.$webcam->nom.'"  data-href="'.$url.$webcam->id.'"><i class="fa fa-pencil"></i></button>'
            .'&nbsp;&nbsp;&nbsp;'
            .'<button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_webcam" data-key="'.$webcam->id.'" ><i class="icon-trash"></i></button>'
            .'</center>';
            $data[]=$row;
        }
        echo json_encode(['data'=>$data]);die();
    }

    /**
     * addwebcam method
     *
     * @param $idStation Lieugeo id
     * @return Json
     */
    public function addwebcam($idStation){
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $webcam = $this->WebcamLieugeos->newEntity();
        if ($this->request->is('post')) {
            $data=$this->request->getData();
            $data['lieugeo_id']=$idStation;
            $webcam = $this->WebcamLieugeos->patchEntity($webcam, $data);
            if(!empty($webcam->errors())){
                $this->set('errors',$webcam->errors());
                $this->set('res','error');
                $this->set('_serialize', ['res','errors']);
                return;
            }
            if ($this->WebcamLieugeos->save($webcam))
                $this->set('res','webcam added');
            else {
                $this->set('errors',$webcam);
                $this->set('res','error');
                $this->set('_serialize', ['res','errors']);
                return;
            }
        }
        $this->set('_serialize', 'res');
    }

    /**
     * editwebcam method
     *
     * @param $idWebcam WebcamLieugeos id
     * @return Json
     */
    public function editwebcam($idWebcam){
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $webcam = $this->WebcamLieugeos->get($idWebcam);
        if ($this->request->is('post')) {
            $webcam = $this->WebcamLieugeos->patchEntity($webcam, $this->request->getData());
            if(!empty($webcam->errors())){
                $this->set('errors',$webcam->errors());
                $this->set('res','error');
                $this->set('_serialize', ['res','errors']);
                return;
            }
            if ($this->WebcamLieugeos->save($webcam))
                $this->set('res','webcam added');
            else {
                $this->set('errors',$webcam);
                $this->set('res','error');
                $this->set('_serialize', ['res','errors']);
                return;
            }
        }
        $this->set('_serialize', 'res');
    }

    /**
     * deletewebcam method
     *
     * @param $idWebcam WebcamLieugeos id
     * @return Json
     */
    public function deletewebcam($idWebcam){
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $webcam = $this->WebcamLieugeos->get($idWebcam);
        if ($this->WebcamLieugeos->delete($webcam)) {
            $this->set('res','deleted');
        } else {
            throw new Exception(__('Error.'));
        }
        $this->set('_serialize', 'res');
    }

    /**
     * getLit method
     *
     * @param $litId Lit id
     * @return Json
     */
    public function getLit($litId)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->loadModel('Lit');
        $this->set('res',$this->Lit->get($litId));
        $this->set('_serialize', 'res');
    }

    /**
     * updateLit method
     *
     * @return Json
     */
    public function updateLit()
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        if ($this->request->is('post')) {
            $this->loadModel('Lit');
            $lit = $this->Lit->get($this->request->getData('id'));
            $lit = $this->Lit->patchEntity($lit,$this->request->getData());
            if(!empty($lit->errors())){
                $this->set('errors',$lit->errors());
                $this->set('res','error');
                $this->set('_serialize', ['res','errors']);
                return;
            }
            if ($this->Lit->save($lit)){
                $this->set('res',$lit);
                $this->set('_serialize', 'res');
                return;
            }
            else {
                $this->set('errors',$lit);
                $this->set('res','error');
                $this->set('_serialize', ['res','errors']);
                return;
            }
        }
    }

    public function deletelit($id)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        if ($this->request->is('delete')) {
            $this->loadModel('Lit');
            $lit = $this->Lit->get($id);
            if ($this->Lit->delete($lit)) {
                $this->set('res','deleted');
            } else {
                throw new Exception(__('Error.'));
            }
            $this->set('_serialize', 'res');
        }
    }
}