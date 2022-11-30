<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;

/**
 * Massif Controller
 *
 * @property \App\Model\Table\MassifTable $Massif
 *
 * @method \App\Model\Entity\Massif[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MassifController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('Massif');
        $this->loadModel('Domaine');
        //end loading models
        $admin_actions=['index','allmassifs','add','edit','delete'];
        //check auth
        $session = $this->request->session();
        if(!$session->check("Gestionnaire.info") || ($session->read("Gestionnaire.info")['G']['role']=='gestionnaire' && in_array($this->request->getParam('action'),$admin_actions) ))
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
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
        //End set manager infos
        $this -> render('/Manager/Stations/Massifs/index','manager');
    }

    /**
     * allmassifs method
     * get all massifs for data table
     *
     * @return \Cake\Http\json
     */
    public function allmassifs(){
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $massifs = $this->Massif->find()->order('nom');
        $data=[];
        $url=Router::url( '/', true ).'manager/massif/edit/';
        foreach($massifs->toarray() as $massif){
            $row=[0=>$massif->nom];
            $row[1]=$massif->descreption;
            if($massif->from_api == 0) $row[2]='<span class="text-danger">Non</span>';
            else $row[2]='<span class="text-success">Oui</span>';
            $row[3]='<center><button class="btn btn-sm btn-default btn-icon-anim btn-circle" onclick="location.href=\''.$url.$massif->id.'\';"><i class="fa fa-pencil"></i></button>'
            .'&nbsp;&nbsp;&nbsp;'
            .'<button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_massif" data-name="'.$massif->nom.'" data-key="'.$massif->id.'" ><i class="icon-trash"></i></button>'
            .'</center>';
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
        //End set manager infos
        $massif = $this->Massif->newEntity();
        //check persist success
        if($session->check("Massif.add")){
			$this->set('confirm_res',$session->read('Massif.add'));
			$session->delete("Massif.add");
        }
        //end check persist success
        //check persist error
		if($session->check("Massif.addError")){
			$this->set('error_res',$session->read('Massif.addError'));
			$session->delete("Massif.addError");
        }
        //end check persist error
        if ($this->request->is('post')) {
            $massif = $this->Massif->patchEntity($massif, $this->request->getData());
            // dd($massif);
            //image
            $prefixe = $_SERVER['DOCUMENT_ROOT'];
            $destname = "$prefixe/webroot/img/uploads/";
            // $destname = "$prefixe/webroot/img/uploads/";
            $file = $this->request->data['image'];
            $ext=explode('/',$file['type']);
            $name=date('YmdHis').".".$ext[1];
            $imagineJPG = new Imagine();
            if($ext[1] == "png"){
                $imageupload = $imagineJPG->open($this->request->data['image']['tmp_name']);
                $imageupload->resize(new Box(265, 300));
                $imageupload->save($destname.$name, array('png_compression_level' => 5)); 
            }
            else{
                $imageupload = $imagineJPG->open($this->request->data['image']['tmp_name']);
                $imageupload->resize(new Box(265, 300));
                $imageupload->save($destname.$name, array('jpeg_quality' => 85));  
            }
            //image
            $massif->image=$name;

            /** Header été **/
            $destname = "$prefixe/webroot/images/header_massif/";
            // $destname = "$prefixe/webroot/img/uploads/";
            $file = $this->request->data['image_header_ete'];
            $ext=explode('/',$file['type']);
            $nameInit = str_replace(' ', '_', $this->request->data['nom']); 
            $namespecial = preg_replace('/[^A-Za-z0-9\-]/', '', $nameInit);
            $name="header_ete_massif_".$namespecial.".jpg";
            $imagineJPG = new Imagine();
            $imageupload = $imagineJPG->open($this->request->data['image_header_ete']['tmp_name']);
            $imageupload->save($destname.$name, array('jpeg_quality' => 85));
            $massif->image_header_ete=$name;
            /** Header été **/
            /** Header hiver **/
            $destname = "$prefixe/webroot/images/header_massif/";
            // $destname = "$prefixe/webroot/img/uploads/";
            $file = $this->request->data['image_header_hiver'];
            $ext=explode('/',$file['type']);
            $nameInit = str_replace(' ', '_', $this->request->data['nom']); 
            $namespecial = preg_replace('/[^A-Za-z0-9\-]/', '', $nameInit);
            $name="header_hiver_massif_".$namespecial.".jpg";
            $imagineJPG = new Imagine();
            $imageupload = $imagineJPG->open($this->request->data['image_header_hiver']['tmp_name']);
            $imageupload->save($destname.$name, array('jpeg_quality' => 85));
            $massif->image_header_hiver=$name;
            /** Header hiver **/

            if ($this->Massif->save($massif)) {
                $session->write("Massif.add","addMassif");
                return $this->redirect(['action' => 'add']);
            }
            else{
                $session->write("Massif.addError","addMassif");
            }
        }
        $this->set(compact('massif'));
        $this -> render('/Manager/Stations/Massifs/add','manager');
    }

    /**
     * Edit method
     *
     * @param string|null $id Massif id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $session = $this->request->session();
        //set manager infos
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        //end set manager infos
        $massif = $this->Massif->get($id);
        //check persist success
        if($session->check("Massif.edit")){
			$this->set('confirm_res',$session->read('Massif.edit'));
			$session->delete("Massif.edit");
        }
        //end check persist success
        //check persist error
		if($session->check("Massif.editError")){
			$this->set('error_res',$session->read('Massif.editError'));
			$session->delete("Massif.editError");
        }
        //end check persist error
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data=$this->request->getData();
            if($this->request->getData('image')['name']=='')
                $data=['nom'=>$this->request->getData('nom'),'nom_url'=>$this->request->getData('nom_url'),'descreption'=>$this->request->getData('descreption'),'latitude'=>$this->request->getData('latitude'),'longitude'=>$this->request->getData('longitude')];
            else
            {
                $prefixe = $_SERVER['DOCUMENT_ROOT'];
                $oldImagePath = "$prefixe/webroot/img/uploads/".$massif->image;
                unlink($oldImagePath);
                //image
                $destname = "$prefixe/webroot/img/uploads/";
                //$destname = "$prefixe/webroot/img/uploads/";
                $file = $this->request->data['image'];
                $ext=explode('/',$file['type']);
                $name=date('YmdHis').".".$ext[1];
                $imagineJPG = new Imagine();
                if($ext[1] == "png"){
                    $imageupload = $imagineJPG->open($this->request->data['image']['tmp_name']);
                    $imageupload->resize(new Box(265, 300));
                    $imageupload->save($destname.$name, array('png_compression_level' => 5)); 
                }else{
                    $imageupload = $imagineJPG->open($this->request->data['image']['tmp_name']);
                    $imageupload->resize(new Box(265, 300));
                    $imageupload->save($destname.$name, array('jpeg_quality' => 85));  
                }
                //image
            }

            $massif = $this->Massif->patchEntity($massif, $data);
            if($this->request->getData('image')['name']!='') $massif->image=$name;

            if($this->request->getData('image_header_ete')['name']!=''){
                /** Header été **/
                // $prefixe = $_SERVER['DOCUMENT_ROOT'];
                $prefixe = PATH_ALPISSIME;
                $oldImageEtePath = "$prefixe/webroot/images/header_massif/".$massif->image_header_ete.".png";
                unlink($oldImageEtePath);
                $destname = "$prefixe/webroot/images/header_massif/";
                // $destname = "$prefixe/webroot/img/uploads/";
                $file = $this->request->data['image_header_ete'];
                $ext=explode('/',$file['type']);
                $nameInit = str_replace(' ', '_', $this->request->data['nom']); 
                $namespecial = preg_replace('/[^A-Za-z0-9\-]/', '', $nameInit);
                $name="header_ete_massif_".$namespecial.".jpg";
                $imagineJPG = new Imagine();
                $imageupload = $imagineJPG->open($this->request->data['image_header_ete']['tmp_name']);
                $imageupload->save($destname.$name, array('jpeg_quality' => 85));
                $massif->image_header_ete=$name;
                /** Header été **/
            }

            if($this->request->getData('image_header_hiver')['name']!=''){
                /** Header hiver **/
                // $prefixe = $_SERVER['DOCUMENT_ROOT'];
                $prefixe = PATH_ALPISSIME;
                $oldImageHiverPath = "$prefixe/webroot/images/header_massif/".$massif->image_header_hiver.".png";
                unlink($oldImageHiverPath);
                $destname = "$prefixe/webroot/images/header_massif/";
                // $destname = "$prefixe/webroot/img/uploads/";
                $file = $this->request->data['image_header_hiver'];
                $ext=explode('/',$file['type']);
                $nameInit = str_replace(' ', '_', $this->request->data['nom']); 
                $namespecial = preg_replace('/[^A-Za-z0-9\-]/', '', $nameInit);
                $name="header_hiver_massif_".$namespecial.".jpg";
                $imagineJPG = new Imagine();
                $imageupload = $imagineJPG->open($this->request->data['image_header_hiver']['tmp_name']);
                $imageupload->save($destname.$name, array('jpeg_quality' => 85));
                $massif->image_header_hiver=$name;
                /** Header hiver **/
            }            

            if ($this->Massif->save($massif)) {                
                $session->write("Massif.edit","addMassif");
                return $this->redirect(['action' => 'edit/'.$massif->id]);
            }
            $session->write("Massif.editError","editMassif");
        }
        $this->set(compact('massif'));
        $this -> render('/Manager/Stations/Massifs/edit','manager');
    }

    /**
     * Delete method
     *
     * @param string|null $id Massif id.
     * @return Json
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $massif = $this->Massif->get($id);
        // $prefixe = $_SERVER['DOCUMENT_ROOT'];
        // $destname = "$prefixe/webroot/img/uploads/".$massif->image;
        //$destname = "$prefixe/webroot/img/uploads/".$massif->image;
        if ($this->Massif->delete($massif)) {
            // unlink($destname);
            $this->set('res','deleted');
        } else {
            $errors=[];
            if(!empty($massif->getError('hasDomaines')))
                $errors['hasDomaines']=$massif->getError('hasDomaines')[0];
            if(!empty($massif->getError('hasLieugeos')))
                $errors['hasLieugeos']=$massif->getError('hasLieugeos')[0];
            $this->set('res',$errors);
        }
        $this->set('_serialize', 'res');
    }

    /**
     * getDomaines method
     *
     * @param string|null $id Massif id.
     * @return Json
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getDomaines($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->set('res',$this->Domaine->find()->where(['massif_id'=>$id])->toArray());
        $this->set('_serialize', 'res');
    }

    /**
     * getStations method
     *
     * @param string|null $id Massif id.
     * @return Json
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getStations($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->loadModel('Lieugeos');
        $this->set('res',$this->Lieugeos->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->where(['massif_id'=>$id])->toArray());
        $this->set('_serialize', 'res');
    }
}
