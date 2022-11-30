<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Imagine\Gd\Imagine;
use Cake\Utility\Inflector;

/**
 * Nutile Controller
 *
 * @property \App\Model\Table\NumeroUtilesTable $Nutiles
 *
 * @method \App\Model\Entity\Village[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NutileController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('NumeroUtiles');
        $this->loadModel('Lieugeos');
        //end loading models
        //check auth
        $session = $this->request->session();
        if(!$session->check("Gestionnaire.info"))
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
        // //get massifs list
        // $this->loadModel('Massif');
        // $massifs=$this->Massif->find('list', [
        //     'keyField' => 'id',
        //     'valueField' => 'nom'
        // ])->order('nom')->toArray();
        // $this->set('massifs',$massifs);
        // //end get massifs list
        // //get stations list
        // reset($massifs);
        // $this->set('stations',$this->Lieugeos->find('list', [
        //     'keyField' => 'id',
        //     'valueField' => 'name'
        // ])->where('niveau >= 3')->where(['massif_id'=>key($massifs)])->order('name')->toArray());
        // //end get stations list
        $this -> render('/Manager/Stations/NumeroUtiles/index','manager');
    }

    /**
     * allnutiles method
     * get all numéros utiles for data table
     *
     * @return \Cake\Http\json
     */
    public function allnutiles(){
        if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
        $idGest=null;
        if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
            $idGest=$this->request->session()->read("Gestionnaire.info")['G']['id'];
        $nutiles=$this->NumeroUtiles->getNutiles($idGest);
        $data=[];
        $url=Router::url( '/', true ).'manager/nutile/edit/';
        foreach($nutiles as $nUtile){
            $row=[0=>$nUtile->nom];
            $row[1]=$nUtile->number;
            $row[2]=$nUtile->lieugeo['name'];
            $row[3]='<div calss="text-center"><button class="btn btn-sm btn-default btn-icon-anim btn-circle" onclick="location.href=\''.$url.$nUtile->id.'\';"><i class="fa fa-pencil"></i></button>'
            .'<button class="btn btn-sm btn-info btn-icon-anim btn-circle ml-5 delete_n" data-key="'.$nUtile->id.'" ><i class="icon-trash"></i></button>'
            .'</center>';
            $data[]=$row;
        }
        echo json_encode(['data'=>$data]);die();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void
     */
    public function add()
    {
        $this->loadModel('Bibliotheques');
        $session = $this->request->session();
        //set manager infos
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        $idGest=null;
        if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
            $idGest=$this->request->session()->read("Gestionnaire.info")['G']['id'];
        //end set manager infos
        $nUtile = $this->NumeroUtiles->newEntity();
        //check persist success
        if($session->check("NumeroUtiles.add")){
			$this->set('confirm_res',$session->read('NumeroUtiles.add'));
			$session->delete("NumeroUtiles.add");
        }
        //end check persist success
        //check persist error
		if($session->check("NumeroUtiles.addError")){
			$this->set('error_res',$session->read('NumeroUtiles.addError'));
			$session->delete("NumeroUtiles.addError");
        }
        if ($this->request->is('post')) {
            $nUtile = $this->NumeroUtiles->patchEntity($nUtile, $this->request->getData());
            if( (isset($this->request->data['bib_image'])) && (!empty($this->request->getData('bib_image')['tmp_name'])))
                {
                    $bib=$this->Bibliotheques->get($this->request->getData('id_bibliotheque'));
                    //image
                    $prefixe = $_SERVER['DOCUMENT_ROOT'];
                    $destname = "$prefixe/webroot/images/num_utiles/";
                    // $destname = "$prefixe/webroot/images/num_utiles/";
                    $file = $this->request->data['bib_image'];
                    $ext=explode('/',$file['type']);
                    if($ext[1]!='png' && $ext[1]!='jpeg')
                    {
                        $thumbError='S\'il vous plaît télécharger une image png ou jpeg.';
                        $this->set('thumbError',$thumbError);
                    }
                    else{
                        $name=Inflector::slug($bib->name).".".$ext[1];
                        $imagineJPG = new Imagine();
                        if($ext[1] == "png"){
                            $imageupload = $imagineJPG->open($this->request->data['bib_image']['tmp_name']);
                            $imageupload->save($destname.$name, array('png_compression_level' => 5)); 
                        }
                        else{
                            $imageupload = $imagineJPG->open($this->request->data['bib_image']['tmp_name']);
                            $imageupload->save($destname.$name, array('jpeg_quality' => 85));  
                        }
                        //image
                        $bib->image=$name;
                        $this->Bibliotheques->save($bib);
                    }
                }
            if (!isset($thumbError) && $this->NumeroUtiles->save($nUtile)) {
                $session->write("NumeroUtiles.add","addNumeroUtiles");
                return $this->redirect(['action' => 'add']);
            }
            else{
                $session->write("NumeroUtiles.addError","addNumeroUtiles");
            }
        }
        //set bibliotheques list
        $bibs=$this->Bibliotheques->find()->where('category is not null')->order('category')->order('name');
        $this->set('bibliotheques',$bibs);
        //end set bibliotheques list
        //set stations list
        $lieugeos=$this->Lieugeos->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order('Lieugeos.name')->where(['niveau >='=>3]);
        if($idGest!=null){
            $lieugeos->join([
                'Village' => [
                    'table' => 'villages',
                    'type' => 'inner',
                    'conditions' => ['Village.lieugeo_id=Lieugeos.id']
                ],
                'GV' => [
                    'table' => 'gestionnaires_villages',
                    'type' => 'inner',
                    'conditions' => ['GV.gestionnaire_id'=>$idGest,'Village.id=GV.villages_id']
                ],
            ]);
        }
        $this->set('lieugeos',$lieugeos);
        //end set stations list
        $this->set('nUtile',$nUtile);
        $this->render('/Manager/Stations/NumeroUtiles/add','manager');
    }

    /**
     * Edit method
     *
     * @param string|null $id Nutile id.
     * @return \Cake\Http\Response|void
     */
    public function edit($id = null)
    {
        $this->loadModel('Bibliotheques');
        $session = $this->request->session();
        //set manager infos
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        $idGest=null;
        if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
            $idGest=$this->request->session()->read("Gestionnaire.info")['G']['id'];
        //end set manager infos
        $nUtile = $this->NumeroUtiles->get($id);
        //check persist success
        if($session->check("NumeroUtiles.edit")){
			$this->set('confirm_res',$session->read('NumeroUtiles.edit'));
			$session->delete("NumeroUtiles.edit");
        }
        //end check persist success
        //check persist error
		if($session->check("NumeroUtiles.editError")){
			$this->set('error_res',$session->read('NumeroUtiles.editError'));
			$session->delete("NumeroUtiles.editError");
        }
        if ($this->request->is('PUT') || $this->request->is('PATCH')) {
            $nUtile = $this->NumeroUtiles->patchEntity($nUtile, $this->request->getData());
            if( (isset($this->request->data['bib_image'])) && (!empty($this->request->getData('bib_image')['tmp_name'])))
                {
                    $bib=$this->Bibliotheques->get($this->request->getData('id_bibliotheque'));
                    //image
                    $prefixe = $_SERVER['DOCUMENT_ROOT'];
                    $destname = "$prefixe/webroot/images/num_utiles/";
                    // $destname = "$prefixe/webroot/images/num_utiles/";
                    $file = $this->request->data['bib_image'];
                    $ext=explode('/',$file['type']);
                    if($ext[1]!='png' && $ext[1]!='jpeg')
                    {
                        $thumbError='S\'il vous plaît télécharger une image png ou jpeg.';
                        $this->set('thumbError',$thumbError);
                    }
                    else{
                        $name=Inflector::slug($bib->name).".".$ext[1];
                        $imagineJPG = new Imagine();
                        if($ext[1] == "png"){
                            $imageupload = $imagineJPG->open($this->request->data['bib_image']['tmp_name']);
                            $imageupload->save($destname.$name, array('png_compression_level' => 5)); 
                        }
                        else{
                            $imageupload = $imagineJPG->open($this->request->data['bib_image']['tmp_name']);
                            $imageupload->save($destname.$name, array('jpeg_quality' => 85));  
                        }
                        //image
                        $bib->image=$name;
                        $this->Bibliotheques->save($bib);
                    }
                }
            if (!isset($thumbError) && $this->NumeroUtiles->save($nUtile)) {
                $session->write("NumeroUtiles.edit","editNumeroUtiles");
                return $this->redirect(['action' => 'edit/'.$id]);
            }
            else{
                $session->write("NumeroUtiles.editError","editNumeroUtiles");
            }
        }
        //set bibliotheques list
        $bibs=$this->Bibliotheques->find()->where('category is not null')->order('category')->order('name');
        $this->set('bibliotheques',$bibs);
        //end set bibliotheques list
        //set stations list
        $lieugeos=$this->Lieugeos->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order('Lieugeos.name')->where(['niveau >='=>3]);
        if($idGest!=null){
            $lieugeos->join([
                'Village' => [
                    'table' => 'villages',
                    'type' => 'inner',
                    'conditions' => ['Village.lieugeo_id=Lieugeos.id']
                ],
                'GV' => [
                    'table' => 'gestionnaires_villages',
                    'type' => 'inner',
                    'conditions' => ['GV.gestionnaire_id'=>$idGest,'Village.id=GV.villages_id']
                ],
            ]);
        }
        $this->set('lieugeos',$lieugeos);
        //end set stations list
        $this->set('nUtile',$nUtile);
        $this->render('/Manager/Stations/NumeroUtiles/edit','manager');
    }

    /**
     * Delete method
     *
     * @param string|null $id Nutile id.
     * @return Json
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $nUtile = $this->NumeroUtiles->get($id);
        if ($this->NumeroUtiles->delete($nUtile)) {
            $this->set('res','deleted');
        }
        $this->set('_serialize', 'res');
    }
}
