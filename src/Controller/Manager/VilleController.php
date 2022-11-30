<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Domaine Controller
 *
 * @property \App\Model\Table\FrvillesTable $ville
 *
 * @method \App\Model\Entity\Domaine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VilleController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('Frvilles');
        $this->loadModel('Departements');
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
        $this -> render('/Manager/Stations/villes/index','manager');
    }

    /**
     * allvilles method
     * get all villes for data table
     *
     * @return \Cake\Http\json
     */
    public function allvilles(){
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $villes = $this->Frvilles->find()->order('Frvilles.name')->contain(['Departements']);
        $data=[];
        $url=Router::url( '/', true ).'manager/ville/edit/';
        foreach($villes as $ville){
            $row=[0=>$ville->name];
            $row[1]=$ville->code_insee;
            $row[2]=$ville->code_postal;
            $row[3]=$ville->departement->name;
            $row[4]='<center><button class="btn btn-sm btn-default btn-icon-anim btn-circle" onclick="location.href=\''.$url.$ville->id.'\';"><i class="fa fa-pencil"></i></button>'
            .'&nbsp;&nbsp;&nbsp;'
            .'<button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_ville" data-name="'.$ville->nom.'" data-key="'.$ville->id.'" ><i class="icon-trash"></i></button>'
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
        $ville = $this->Frvilles->newEntity();
        //check persist success
        if($session->check("Ville.add")){
			$this->set('confirm_res',$session->read('Ville.add'));
			$session->delete("Ville.add");
        }
        //end check persist success
        //check persist error
		if($session->check("Ville.addError")){
			$this->set('error_res',$session->read('Ville.addError'));
			$session->delete("Ville.addError");
        }
        //end check persist error
        if ($this->request->is('post')) {
            $ville = $this->Frvilles->patchEntity($ville, $this->request->getData());
            if ($this->Frvilles->save($ville)) {
                $session->write("Ville.add","addVille");
                return $this->redirect(['action' => 'add']);
            }
            else{
                $session->write("Ville.addError","addVille");
            }
        }
        //get departements list
        $departements=$this->Departements->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ]);
        $this->set('departements',$departements->toArray());
        //end get departements list
        $this->set(compact('ville'));
        $this -> render('/Manager/Stations/villes/add','manager');
    }

    /**
     * Edit method
     *
     * @param string|null $id Ville id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $session = $this->request->session();
        //set manager infos
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        //end set manager infos
        $ville = $this->Frvilles->get($id);
        //check persist success
        if($session->check("Ville.edit")){
			$this->set('confirm_res',$session->read('Ville.edit'));
			$session->delete("Ville.edit");
        }
        //end check persist success
        //check persist error
		if($session->check("Ville.editError")){
			$this->set('error_res',$session->read('Ville.editError'));
			$session->delete("Ville.editError");
        }
        //end check persist error
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $ville = $this->Frvilles->patchEntity($ville, $this->request->getData());
            if ($this->Frvilles->save($ville)) {
                $session->write("Ville.edit","addVille");
                return $this->redirect(['action' => 'edit/'.$ville->id]);
            }
            $session->write("Ville.editError","editVille");
        }
        //get departements list
        $departements=$this->Departements->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ]);
        $this->set('departements',$departements->toArray());
        //end get departements list
        $this->set(compact('ville'));
        $this -> render('/Manager/Stations/villes/edit','manager');
    }

    /**
     * Delete method
     *
     * @param string|null $id Ville id.
     * @return Json
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $ville = $this->Frvilles->get($id);
        if ($this->Frvilles->delete($ville)) {
            $this->set('res','deleted');
        } else {
            if(!empty($ville->getError('hasChilds')))
                $this->set('res', $ville->getError('hasChilds')[0]);
            else
                throw new Exception(__($ville->getError('hasChilds')[0]));
        }
        $this->set('_serialize', 'res');
    }
}
