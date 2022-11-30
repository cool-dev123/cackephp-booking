<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Domaine Controller
 *
 * @property \App\Model\Table\DomaineTable $Domaine
 *
 * @method \App\Model\Entity\Domaine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DomaineController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('Domaine');
        $this->loadModel('Massif');
        //end loading models
        //check auth
        $session = $this->request->session();
        if(!$session->check("Gestionnaire.info") || $session->read("Gestionnaire.info")['G']['role']=='gestionnaire')
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
        $this -> render('/Manager/Stations/Domaines/index','manager');
    }

    /**
     * alldomaines method
     * get all domaines for data table
     *
     * @return \Cake\Http\json
     */
    public function alldomaines(){
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $domaines = $this->Domaine->find()->order('Domaine.nom')->contain(['Massif']);
        $data=[];
        $url=Router::url( '/', true ).'manager/domaine/edit/';
        foreach($domaines->toarray() as $domaine){
            $row=[0=>$domaine->nom];
            $row[1]=$domaine->descreption;
            $row[2]=$domaine->massif->nom;
            $row[3]='<center><button class="btn btn-sm btn-default btn-icon-anim btn-circle" onclick="location.href=\''.$url.$domaine->id.'\';"><i class="fa fa-pencil"></i></button>'
            .'&nbsp;&nbsp;&nbsp;'
            .'<button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_domaine" data-name="'.$domaine->nom.'" data-key="'.$domaine->id.'" ><i class="icon-trash"></i></button>'
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
        //end set manager infos
        $domaine = $this->Domaine->newEntity();
        //check persist success
        if($session->check("Domaine.add")){
			$this->set('confirm_res',$session->read('Domaine.add'));
			$session->delete("Domaine.add");
        }
        //end check persist success
        //check persist error
		if($session->check("Domaine.addError")){
			$this->set('error_res',$session->read('Domaine.addError'));
			$session->delete("Domaine.addError");
        }
        //end check persist error
        if ($this->request->is('post')) {
            $domaine = $this->Domaine->patchEntity($domaine, $this->request->getData());
            if ($this->Domaine->save($domaine)) {
                $session->write("Domaine.add","addDomaine");
                return $this->redirect(['action' => 'add']);
            }
            else{
                $session->write("Domaine.addError","addDomaine");
            }
        }
        //get massifs list
        $massifs=$this->Massif->find('list', [
            'keyField' => 'id',
            'valueField' => 'nom'
        ]);
        $this->set('massifs',$massifs->toArray());
        //end get massifs list
        $this->set(compact('domaine'));
        $this -> render('/Manager/Stations/Domaines/add','manager');
    }

    /**
     * Edit method
     *
     * @param string|null $id Domaine id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $session = $this->request->session();
        //set manager infos
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        //end set manager infos
        $domaine = $this->Domaine->get($id);
        //check persist success
        if($session->check("Domaine.edit")){
			$this->set('confirm_res',$session->read('Domaine.edit'));
			$session->delete("Domaine.edit");
        }
        //end check persist success
        //check persist error
		if($session->check("Domaine.editError")){
			$this->set('error_res',$session->read('Domaine.editError'));
			$session->delete("Domaine.editError");
        }
        //end check persist error
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $domaine = $this->Domaine->patchEntity($domaine, $this->request->getData());
            if ($this->Domaine->save($domaine)) {
                $session->write("Domaine.edit","addDomaine");
                return $this->redirect(['action' => 'edit/'.$domaine->id]);
            }
            $session->write("Domaine.editError","editDomaine");
        }
        //get massifs list
        $massifs=$this->Massif->find('list', [
            'keyField' => 'id',
            'valueField' => 'nom'
        ]);
        $this->set('massifs',$massifs->toArray());
        //end get massifs list
        $this->set(compact('domaine'));
        $this -> render('/Manager/Stations/Domaines/edit','manager');
    }

    /**
     * Delete method
     *
     * @param string|null $id Domaine id.
     * @return Json
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $domaine = $this->Domaine->get($id);
        if ($this->Domaine->delete($domaine)) {
            $this->set('res','deleted');
        } else {
            if(!empty($domaine->getError('hasChilds')))
                $this->set('res', $domaine->getError('hasChilds')[0]);
            else
                throw new Exception(__($domaine->getError('hasChilds')[0]));
        }
        $this->set('_serialize', 'res');
    }
}
