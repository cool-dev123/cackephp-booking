<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Rmecanique Controller
 *
 * @property \App\Model\Table\DomaineTable $Domaine
 *
 * @method \App\Model\Entity\Domaine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RmecaniqueController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('RemonteMecanique');
        $this->loadModel('AnneLieugeos');
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
        $this -> render('/Manager/Stations/RM/index','manager');
    }

    /**
     * allrm method
     * get all remontés mecaniques for data table
     *
     * @return \Cake\Http\json
     */
    public function allrm()
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
            $idGest=null;
            if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
                $idGest=$this->request->session()->read("Gestionnaire.info")['G']['id'];
        $rms=$this->RemonteMecanique->allRm($idGest);
        $data=[];
        $url=Router::url( '/', true ).'manager/Rmecanique/edit/';
        foreach($rms as $rm){
            $row=[$rm->nom];
            // $row[]=$rm->lieugeo;
            $row[]=$rm->type;
            $row[]=$rm->km_pistes;
            $row[]='<span class="label label-success mr-5">'.$rm->nbrpistes_verte.'</span><span class="label label-primary mr-5">'.$rm->nbrpistes_bleu.'</span>'
            .'<span class="label label-danger mr-5">'.$rm->nbrpistes_rouge.'</span><span class="label label-noir">'.$rm->nbrpistes_noir.'</span>';
            $row[]=$rm->anne_lieugeos[0]->prixJourne!=null?$rm->anne_lieugeos[0]->prixJourne.'&euro;':'Non encore défini';
            $row[]='<div calss="text-center"><button class="btn btn-sm btn-default btn-icon-anim btn-circle mr-5" onclick="location.href=\''.$url.$rm->id.'\';"><i class="fa fa-pencil"></i></button>'
            .'<button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_rm" data-key="'.$rm->id.'"><i class="icon-trash"></i></button>'
            .'</div>';
            $data[]=$row;
        }
        // dd($data);
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
        $rm = $this->RemonteMecanique->newEntity(null,['associated' => ['AnneLieugeos']]);
        //check persist success
        if($session->check("Rm.add")){
			$this->set('confirm_res',$session->read('Rm.add'));
			$session->delete("Rm.add");
        }
        //end check persist success
        //check persist error
		if($session->check("Rm.addError")){
			$this->set('error_res',$session->read('Rm.addError'));
			$session->delete("Rm.addError");
        }
        //end check persist error
        if ($this->request->is('post')) {
            $data=$this->request->getData();
            //set anne this year
            $data['anne_lieugeos'][0]['anne']=date('Y');
            //end set anne this year
            $rm = $this->RemonteMecanique->patchEntity($rm, $data,['associated' => ['AnneLieugeos']]);                   
            if ($rm_new = $this->RemonteMecanique->save($rm)) {
                foreach ($this->request->getData('lieugeos') as $value) {
                    $lieugeo = $this->Lieugeos->get($value);
                    $lieugeo_data = array('RM_id' => $rm_new->id);
                    $lieugeo_new = $this->Lieugeos->patchEntity($lieugeo, $lieugeo_data);
                    $this->Lieugeos->save($lieugeo_new);
                }
                $session->write("Rm.add","addRm");
                return $this->redirect(['action' => 'add']);
            }
            else{
                $session->write("Rm.addError","addRm");
            }
        }
        if($idGest!=null){
            //set stations list
            $lieugeos=$this->Lieugeos->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->order('Lieugeos.name')->join([
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
        else{
            //set massifs list
            $this->loadModel('Massif');
            $massifs=$this->Massif->find('list', [
                'keyField' => 'id',
                'valueField' => 'nom'
            ])->order('nom')->toArray();
            $this->set('massifs',$massifs);
            //end set massifs list
            //set stations list
            if($rm->lieugeo_id==null)
            {
                reset($massifs);
                $rm->massif_id=key($massifs);
            }
            $lieugeos=$this->Lieugeos->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->order('name')->where(['massif_id'=>$rm->massif_id]);
        }
        $this->set('lieugeos',$lieugeos);
        //end set stations list
        $this->set(compact('rm'));
        $this -> render('/Manager/Stations/RM/add','manager');
    }

    /**
     * Edit method
     *
     * @param string|null $id RemonteMecanique id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $session = $this->request->session();
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        $idGest=null;
        if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
            $idGest=$this->request->session()->read("Gestionnaire.info")['G']['id'];
        //get Mechanical Remonte to edit with the associated station and price for this year
        $rm = $this->RemonteMecanique->findById($id)->contain('Lieugeos')->contain('AnneLieugeos', function ($q) {
            return $q
                ->limit(1)
                ->where(['anne'=>date('Y')]);
        })->first();
        // $rm->massif_id = $rm->lieugeo->massif_id;
        //end get Mechanical Remonte to edit with the associated station and price for this year
        //check persist success
        if($session->check("Rm.edit")){
			$this->set('confirm_res',$session->read('Rm.edit'));
			$session->delete("Rm.edit");
        }
        //end check persist success
        //check persist error
		if($session->check("Rm.editError")){
			$this->set('error_res',$session->read('Rm.editError'));
			$session->delete("Rm.editError");
        }
        //end check persist error
        $RM = $this->Lieugeos->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->where(['RM_id' => $rm->id])->toArray();
        $this->set('RM_lieugeos',array_keys($RM));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data=$this->request->getData();
            $data['anne_lieugeos'][0]['id']=$rm->anne_lieugeos[0]->id;
            $data['anne_lieugeos'][0]['anne']=date('Y');
            $rm = $this->RemonteMecanique->patchEntity($rm, $data);
            $liste_lieugeos = $this->Lieugeos->find()->where(['RM_id' => $rm->id]);                  
            if ($rm_new = $this->RemonteMecanique->save($rm)) {
                foreach ($liste_lieugeos as $value) {
                    if(!in_array($value, $this->request->getData('lieugeos'))){
                        $lieugeo_data = array('RM_id' => 0);
                        $lieugeo_new = $this->Lieugeos->patchEntity($value, $lieugeo_data);
                        $this->Lieugeos->save($lieugeo_new);
                    }
                }
                foreach ($this->request->getData('lieugeos') as $key) {
                    $lieugeo = $this->Lieugeos->get($key);
                    $lieugeo_data = array('RM_id' => $rm_new->id);
                    $lieugeo_new = $this->Lieugeos->patchEntity($lieugeo, $lieugeo_data);
                    $this->Lieugeos->save($lieugeo_new);
                }
                $session->write("Rm.edit","editRm");
                return $this->redirect(['action' => 'edit/'.$id]);
            }
            else{
                $session->write("Rm.editError","editRm");
            }
        }
        //get prices by year for Mechanical Remonte
        $prix=$this->AnneLieugeos->find()->where(['remonte_mecanique_id'=>$id])->order(['anne'=>'desc']);
        $this->set('prix',$prix);
        //end get prices by year for Mechanical Remonte
        if($idGest!=null){
            //set stations list
            $lieugeos=$this->Lieugeos->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->order('Lieugeos.name')->join([
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
        else{
            //set massifs list
            $this->loadModel('Massif');
            $massifs=$this->Massif->find('list', [
                'keyField' => 'id',
                'valueField' => 'nom'
            ])->order('nom')->toArray();
            $this->set('massifs',$massifs);
            //end set massifs list
            //set stations list
            $lieugeos=$this->Lieugeos->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->order('name')->where(['massif_id'=>$rm->massif_id]);
        }
        $this->set('lieugeos',$lieugeos);
        //end set stations list
        $this->set(compact('rm'));
        $this -> render('/Manager/Stations/RM/edit','manager');
    }

    /**
     * Delete method
     *
     * @param string|null $id Rmecanique id.
     * @return Json
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $rm = $this->RemonteMecanique->get($id);
        if ($this->RemonteMecanique->delete($rm)) {
            $liste_lieugeos = $this->Lieugeos->find()->where(['RM_id' => $id]);
            foreach ($liste_lieugeos as $value) {
                $lieugeo_data = array('RM_id' => 0);
                $lieugeo_new = $this->Lieugeos->patchEntity($value, $lieugeo_data);
                $this->Lieugeos->save($lieugeo_new);
            }
            $this->set('res','deleted');
        } else {
            throw new Exception(__('Error.'));
        }
        $this->set('_serialize', 'res');
    }
}
