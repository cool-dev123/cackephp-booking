<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Village Controller
 *
 * @property \App\Model\Table\VillagesTable $Villages
 *
 * @method \App\Model\Entity\Village[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VillageController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('Lieugeos');
        $this->loadModel('Villages');
        //end loading models
        if($this->request->getParam('action')=='')
        //check auth
        $manager_actions=['getVillage'];
        $admin_actions=['all'];
        $autorased=['getStationVillages', 'getStationVillagesWithAnnonces'];
        $session = $this->request->session();
        if(!$session->check("Gestionnaire.info") && !in_array($this->request->getParam('action'), $autorased)){
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
        //End set manager infos
        if($this->request->session()->read("Gestionnaire.info")['G']['role']!='gestionnaire'){
            //get massifs list
            $this->loadModel('Massif');
            $massifs=$this->Massif->find('list', [
                'keyField' => 'id',
                'valueField' => 'nom'
            ])->order('nom')->toArray();
            $this->set('massifs',$massifs);
            //end get massifs list
            //get stations list
            reset($massifs);
            $this->set('stations',$this->Lieugeos->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->where('niveau >= 3')->where(['massif_id'=>key($massifs)])->order('name')->toArray());
            //end get stations list
        }
        //get departements list
        $this->loadModel('Departements');
        $deps=$this->Departements->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order('name')->toArray();
        $this->set('departements',$deps);
        //end get departements list
        //get villes list for first department
        $this->loadModel('Frvilles');
        reset($deps);
        $this->set('villes',$this->Frvilles->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order('name')->where(['departement_id'=>key($deps)])->toArray());
        //end get villes list for first department
        $this -> render('/Manager/Stations/Villages/index','manager');
    }

    /**
     * allvillages method
     * get all villages for data table
     *
     * @return \Cake\Http\json
     */
    public function allvillages(){
        // $villages=$this->Villages->find()->contain(['Frvilles','hasLieugeosOrNot'])->order('villages.name');
        $gestId=null;
        if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
            $gestId=$this->request->session()->read("Gestionnaire.info")['G']['id'];
        $villages=$this->Villages->getAllVillages($gestId);
        $data=[];
        $url=Router::url( '/', true ).'manager/village/edit/';
        // if($this->request->session()->read("Gestionnaire.info")['G']['role']=='gestionnaire')
        // $villages->where(['lieugeo_id'=>$this->request->session()->read("Gestionnaire.info")['G']['station']]);
        //dd($villages->toarray());
        foreach($villages->toarray() as $village){
            $row=[0=>$village->name];
            $row[1]=$village->Frville['name'];
            $row[2]=$village->Lieugeo['name']!=null?
                $village->Lieugeo['name']:
                '<button data-toggle="modal" data-target="#modal-addStation" class="buton_add btn btn-primary btn-icon-anim btn-square btn-sm" data-lieugeo_id="'.$village->Lieugeo['id'].'" data-name="'.$village['name'].'" data-key="'.$village['id'].'" data-name="'.$village['name'].'"><i class="fa fa-plus"></i></button>';
            $row[3]=$village->count;
            $row[4]='<center><button class="btn btn-sm btn-default btn-icon-anim btn-circle editVillage" data-departement_id="'.$village->Frville['departement_id'].'" data-ville_id="'.$village->Frville['id'].'" data-massif_id="'.$village->Lieugeo['massif_id'].'" data-lieugeo_id="'.$village->Lieugeo['id'].'"  data-name="'.$village['name'].'" data-input_boutique="'.$village['input_boutique'].'" data-input_boutique_EN="'.$village['input_boutique_EN'].'" data-key="'.$village['id'].'" data-href="'.$url.$village['id'].'"><i class="fa fa-pencil"></i></button>'
            .'&nbsp;&nbsp;&nbsp;'
            .'<button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_village" data-name="'.$village['name'].'" data-key="'.$village['id'].'" ><i class="icon-trash"></i></button>'
            .'</center>';
            $data[]=$row;
        }
        echo json_encode(['data'=>$data]);die();
    }

    /**
     * Add method
     *
     * @return Json.
     */
    public function add()
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $village = $this->Villages->newEntity();
        if ($this->request->is('post')) {
            $village = $this->Villages->patchEntity($village, $this->request->getData());
            if(!empty($village->errors())){
                $this->set('errors',$village->errors());
                $this->set('res','error');
                $this->set('_serialize', ['res','errors']);
                return;
            }
            if ($this->Villages->save($village))
                $this->set('res','village added');
            else {
                $this->set('errors',$village);
                $this->set('res','error');
                $this->set('_serialize', ['res','errors']);
                return;
            }
        }
        $this->set('_serialize', 'res');
    }

    /**
     * Edit method
     *
     * @param string|null $id Village id.
     * @return Json
     */
    public function edit($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $village = $this->Villages->get($id);
        if ($this->request->is('post')) {
            $village = $this->Villages->patchEntity($village, $this->request->getData());
            if(!empty($village->errors())){
                $this->set('errors',$village->errors());
                $this->set('res','error');
                $this->set('_serialize', ['res','errors']);
                return;
            }
            if ($this->Villages->save($village))
                $this->set('res','village added');
            else {
                $this->set('errors',$village);
                $this->set('res','error');
                $this->set('_serialize', ['res','errors']);
                return;
            }
        }
        $this->set('_serialize', 'res');
    }

    /**
     * Delete method
     *
     * @param string|null $id Village id.
     * @return Json
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $villages = $this->Villages->get($id);
        if ($this->Villages->delete($villages)) {
            $this->set('res','deleted');
        } else {
            if(!empty($villages->getError('hasOfficeTourisme')))
                $errors['hasOfficeTourisme']=$villages->getError('hasOfficeTourisme')[0];
            $this->set('res',$errors);
        }
        $this->set('_serialize', 'res');
    }

    /**
     * setStationToVillage method
     *
     * @param string|null $villageId Village id.
     * @param string|null $stationId Station id.
     * @return Json
     * assign village to station(lieugeo)
     */
    public function setStationToVillage($villageId,$stationId){
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $village=$this->Villages->get($villageId);
        $village->lieugeo_id=$stationId;
        if($this->Villages->save($village))
            $this->set('res','updated');
        else 
            throw new Exception(__('Error.'));
        $this->set('_serialize', 'res');
    }

    /**
     * getVillage method
     *
     * @param string|null $idVille ville id.
     * @return Json
     * get villages of ville
     */
    public function getVillage($idVille)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->set('res',$this->Villages->find('list',[
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order('name')->where(['id_ville'=>$idVille])->toArray());
        $this->set('_serialize', 'res');
    }

    /**
     * getStationVillages method
     *
     * @param string|null $idVille ville id.
     * @return Json
     * get villages of ville
     */
    public function getStationVillages($idStation)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->set('res',$this->Villages->find('list',[
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order('name')->where(['lieugeo_id'=>$idStation])->toArray());
        $this->set('_serialize', 'res');
    }

    /**
     * getStationVillagesWithAnnonces method
     *
     * @param string|null $idStation station id.
     * @return Json
     * get villages of station with annonces 
     */
    public function getStationVillagesWithAnnonces($idStation)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $where = [];
        if(is_numeric($idStation)){
            if($idStation != 0){
                $where = ['Villages.lieugeo_id'=>$idStation];
            }
        }else if(is_string($idStation)){
            $pos = stripos($idStation, "massif_");							
            if ($pos !== false) {
                $str = str_replace("massif_", "", $idStation);	
                $this->loadModel('Lieugeos');
                $stations = $this->Lieugeos->find("list", [
                    'keyField' => 'name',
                    'valueField' => 'id'
                ])->where(['massif_id' => intval($str)]);					
                $where = ["Villages.lieugeo_id IN " => $stations->toArray()];
            }
        }
        $this->set('res',$this->Villages->find('all')->join([
            'Annonces' => [
                'table' => 'annonces',
                'type' => 'inner',
                'conditions' => ['Villages.id = Annonces.village', "Annonces.statut = 50"],
            ]
        ])->group(['Villages.id'])->order('Villages.name')->where($where)->toArray());
        $this->set('_serialize', 'res');
    }
}