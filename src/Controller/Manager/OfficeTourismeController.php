<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Office De Tourisme Controller
 *
 * @property \App\Model\Table\OfficeTourismeTable $OfficeTourisme
 *
 * @method \App\Model\Entity\OfficeTourisme[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OfficeTourismeController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('OfficeTourisme');
        $this->loadModel('Lieugeos');
        $this->loadModel('Villages');
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
        $this -> render('/Manager/Stations/OfficeTourisme/index','manager');
    }

    /**
     * alloffices method
     * get all offices de tourismes for data table
     *
     * @return \Cake\Http\json
     */
    public function alloffices(){
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $idGest=null;
        if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
            $idGest=$this->request->session()->read("Gestionnaire.info")['G']['id'];
        $offices = $this->OfficeTourisme->findForDataTable($idGest);
        $data=[];
        $url=Router::url( '/', true ).'manager/OfficeTourisme/edit/';
        foreach($offices->toarray() as $office){
            $row=[0=>$office->type];
            $row[1]=[$office->nom];
            $row[2]=$office->getCategorie();
            $row[3]=$office->adresse;
            $row[4]='<center><button class="btn btn-sm btn-default btn-icon-anim btn-circle" onclick="location.href=\''.$url.$office->id.'\';"><i class="fa fa-pencil"></i></button>'
            .'&nbsp;&nbsp;&nbsp;'
            .'<button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_office" data-key="'.$office->id.'" ><i class="icon-trash"></i></button>'
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
        $idGest=null;
        if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
            $idGest=$this->request->session()->read("Gestionnaire.info")['G']['id'];
        //end set manager infos
        $office = $this->OfficeTourisme->newEntity();
        //check persist success
        if($session->check("Office.add")){
			$this->set('confirm_res',$session->read('Office.add'));
			$session->delete("Office.add");
        }
        //end check persist success
        //check persist error
		if($session->check("Office.addError")){
			$this->set('error_res',$session->read('Office.addError'));
			$session->delete("Office.addError");
        }
        //end check persist error
        if ($this->request->is('post')) {
            //set null for blank inputs
            $data = array_map( 
                function($row) { return $row==''?null:$row; }, 
                $this->request->getData()
            );
            //end set null for blank inputs
            $office = $this->OfficeTourisme->patchEntity($office, $data);
            if ($this->OfficeTourisme->save($office)) {
                $session->write("Office.add","addOffice");
                return $this->redirect(['action' => 'add']);
            }
            else{
                $session->write("Office.addError","addOffice");
            }
        }
        //set categories list
        $this->set('categories',[
            1=>'Catégorie I',
            2=>'Catégorie II',
            3=>'Catégorie III',
        ]);
        //end set categories list
        //set types list
        $this->set('types',$this->OfficeTourisme->getStaticTypes());
        //end set types list
        /////////if($idGest!=null){
            //set Departements list
            $this->loadModel('Departements');
            $departements=$this->Departements->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->order('name');
            $this->set('departements',$departements->toArray());
            //end set Departements list
            //set villes list
            $this->loadModel('Frvilles');
            $villes=$this->Frvilles->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->order('name');
            if($this->request->getData('departement_id'))
            {
                $villes->where(['departement_id'=>$this->request->getData('departement_id')]);
            }
            else
            {
                $villes->where(['departement_id'=>key($departements->toArray())]);
            }
            $this->set('villes',$villes->toArray());
            //end set villes list
        //////////}
        //set villages list
        $villages=$this->Villages->find('list',[
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order('name');
        if($idGest!=null){
            $villages->join([
                'GV'=>[
                    'table' => 'gestionnaires_villages',
                    'type' => 'inner',
                    'conditions' => ['GV.gestionnaire_id'=>$idGest,'Villages.id=GV.villages_id']
                ]
            ]);
        }
        else if($this->request->getData('id_ville'))
        {
            $villages->where(['id_ville'=>$this->request->getData('id_ville')]);
        }
        else
        {
            $villages->where(['id_ville'=>key($villes->toArray())]);
        }
        $this->set('villages',$villages->toArray());
        //end set villages list
        $this->set(compact('office'));
        $this -> render('/Manager/Stations/OfficeTourisme/add','manager');
    }

    /**
     * Edit method
     *
     * @param string|null $id OfficeTourisme id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $session = $this->request->session();
        //set manager infos
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        $idGest=null;
        if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
            $idGest=$this->request->session()->read("Gestionnaire.info")['G']['id'];
        //end set manager infos
        // $office = $this->OfficeTourisme->findById($id, [
        //     'contain' => ['Villages','Villages.Frvilles','Villages.Frvilles.Departements']
        // ])->first();
        $office = $this->OfficeTourisme->find("all")->contain(['Villages','Villages.Frvilles','Villages.Frvilles.Departements'])->where(['OfficeTourisme.id'=>$id])->first();
        //$office = $this->OfficeTourisme->find("all")->contain(['Villages','Villages.Frvilles','Villages.Frvilles.Departements']);
        // $office->departement_id=$office->village->frville->departement->id;
        // $office->id_ville=$office->village->id_ville;
        // print_r($office);
        // exit;
        //check persist success
        if($session->check("Office.edit")){
			$this->set('confirm_res',$session->read('Office.edit'));
			$session->delete("Office.edit");
        }
        //end check persist success
        //check persist error
		if($session->check("Office.editError")){
			$this->set('error_res',$session->read('Office.editError'));
			$session->delete("Office.editError");
        }
        //end check persist error
        if ($this->request->is(['patch', 'post', 'put'])) {
            //set null for blank inputs
            $data = array_map( 
                function($row) { return $row==''?null:$row; }, 
                $this->request->getData()
            );            
            //end set null for blank inputs
            $office = $this->OfficeTourisme->patchEntity($office, $this->request->getData());
            if ($this->OfficeTourisme->save($office)) {
                $session->write("Office.edit","editOffice");
                return $this->redirect(['action' => 'edit/'.$id]);
            }
            else{
                $session->write("Office.editError","editOffice");
            }
        }
        //set categories list
        $this->set('categories',[
            1=>'Catégorie I',
            2=>'Catégorie II',
            3=>'Catégorie III',
        ]);
        //end set categories list
        //set types list
        $this->set('types',$this->OfficeTourisme->getStaticTypes());
        //end set types list
        //if($idGest!=null){
            //set Departements list
            $this->loadModel('Departements');
            $departements=$this->Departements->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->order('name');
            $this->set('departements',$departements->toArray());
            //end set Departements list
            //set villes list
            $this->loadModel('Frvilles');
            $villes=$this->Frvilles->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->order('name');
            // print_r($office);
            // exit;
            if($this->request->getData('departement_id'))
            {
                $villes->where(['departement_id'=>$this->request->getData('departement_id')]);
            }
            else
            {
                $villes->where(['departement_id'=>$office->village->frville->departement_id]);
            }
            // print_r($villes->toArray());
            // exit;
            $this->set('villes',$villes->toArray());
            //end set villes list
        //}
        //set villages list
        $villages=$this->Villages->find('list',[
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order('name');
        if($idGest!=null){
            $villages->join([
                'GV'=>[
                    'table' => 'gestionnaires_villages',
                    'type' => 'inner',
                    'conditions' => ['GV.gestionnaire_id'=>$idGest,'Villages.id=GV.villages_id']
                ]
            ]);
        }
        else if($this->request->getData('id_ville'))
        {
            $villages->where(['id_ville'=>$this->request->getData('id_ville')]);
        }
        else
        {
            $villages->where(['id_ville'=>$office->village->id_ville]);
        }
        $this->set('villages',$villages->toArray());
        //end set villages list
        $this->set(compact('office'));
        $this -> render('/Manager/Stations/OfficeTourisme/edit','manager');
    }

    /**
     * Delete method
     *
     * @param string|null $id OfficeTourisme id.
     * @return Json
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $ot = $this->OfficeTourisme->get($id);
        if ($this->OfficeTourisme->delete($ot)) {
            $this->set('res','deleted');
        } else {
            throw new Exception(__('Error.'));
        }
        $this->set('_serialize', 'res');
    }
}
