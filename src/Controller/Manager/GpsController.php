<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;

/**
 * Gps Controller
 *
 *
 * @method \App\Model\Entity\Gp[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GpsController extends AppController
{
    
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('RequestHandler');
    }
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $actions=['index','add','edit','delete'];
        if (in_array($this->request->getParam('action'), $actions)){
            $session = $this->request->session();
            if(!$session->check("Gestionnaire.info") && $session->read('Gestionnaire.info')['G']['role']!="admin"){
                return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
            }
        }
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->viewBuilder()->layout('manager');	
        $session = $this->request->session();
        $gest=$session->read('Gestionnaire.info');
        $this->set('InfoGes',$gest);
        $this->loadModel('Residences');
        $this->loadModel('Annonces');
        $residences = $this->Residences->find('all')->contain(['Bibliotheques','Villages']);
        $nbrAnnonce = [];
        foreach ($residences as $value) {
            if($value->bibliotheque_id == 1){
                $listeannonce = $this->Annonces->find("all")->where(['batiment' => $value->id, "statut <> 40"]);
                $nbrAnnonce[$value->id] = $listeannonce->count();
            }
        }
        $this->set('nbrAnnonce', $nbrAnnonce);
        $this->set(compact('residences'));
        $this->render('/Manager/Gps/index');
    }

    /**
     * View method
     *
     * @param string|null $id Gp id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    //public function view($id = null)
    //{
    //    $gp = $this->Gps->get($id, [
    //        'contain' => []
    //    ]);
    //
    //    $this->set('gp', $gp);
    //}

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $session = $this->request->session();
        $this->viewBuilder()->layout('manager');
        $gest=$session->read('Gestionnaire.info');
        $this->set('InfoGes',$gest);
        
        $this->loadModel('Residences');
        $this->loadModel('Bibliotheques');
        $this->loadModel('Villages');
        $residence = $this->Residences->newEntity();
        if($session->check("Residence.add")){
                $this->set('confirm_res',$session->read('Residence.add'));
                $session->delete("Residence.add");
        }
        if($session->check("Residence.addError")){
                $this->set('error_res',$session->read('Residence.addError'));
                $session->delete("Residence.addError");
        }
        if ($this->request->is('post')) {
            
            $residence = $this->Residences->newEntity($this->request->getData());
            if($this->request->data['image_header']['tmp_name'] != ""){
                /** Header image **/
                $prefixe = PATH_ALPISSIME;
                $destname = "$prefixe/webroot/images/header_residence/";
                $file = $this->request->data['image_header'];
                $ext=explode('/',$file['type']);
                $nameInit = str_replace(' ', '_', $this->request->data['name']); 
                $namespecial = preg_replace('/[^A-Za-z0-9\-]/', '', $nameInit);
                $name="header_residence_".$this->request->data['name_url']."_".$this->request->data['id_village'].".jpg";
                $imagineJPG = new Imagine();
                $imageupload = $imagineJPG->open($this->request->data['image_header']['tmp_name']);
                $imageupload->save($destname.$name, array('jpeg_quality' => 85));
                $residence->image_header=$name;
                /** Header image **/
            }            
            if ($this->Residences->save($residence)) {
                $session->write("Residence.add","addvacance");
                return $this->redirect(['action' => 'add']);
            }else{
                $session->write("Residence.addError","addvacance");
                return $this->redirect(['action' => 'add']);
            }
        
        }
        $villages=$this->Villages->find()->order(['Villages.name ASC']);
        $bibliotheques=$this->Bibliotheques->find()->where('category is null')->order(['Bibliotheques.name ASC']);
        
        $this->set(compact('residence'));
        $this->set(compact('villages'));
        $this->set(compact('bibliotheques'));
        $this->render('/Manager/Gps/add');
    }

    public function addajax()
    {
        $this->viewBuilder()->layout(false);
        $this->loadModel('Residences');
        $residence = $this->Residences->newEntity($this->request->getData());
        $result = $this->Residences->save($residence);

        $this->set("residence_id",$result->id);
        $this->set("l_residence",$this->Residences->find("list",["conditions"=>["id_village"=>1]]));
    }

    /**
     * Edit method
     *
     * @param string|null $id Gp id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout('manager');
        $session = $this->request->session();
        $gest=$session->read('Gestionnaire.info');
        $this->set('InfoGes',$gest);
        
        $this->loadModel('Residences');
        $this->loadModel('Bibliotheques');
        $this->loadModel('Villages');
        $residance = $this->Residences->get($id, [
            'contain' => ['Bibliotheques','Villages']
        ]);
        if($session->check("Residence.add")){
                $this->set('confirm_res',$session->read('Residence.add'));
                $session->delete("Residence.add");
        }
        if($session->check("Residence.addError")){
                $this->set('error_res',$session->read('Residence.addError'));
                $session->delete("Residence.addError");
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            if($this->request->getData('image_header')['name']==''){
                $data = array("name" => $this->request->data['name'], "name_url" => $this->request->data['name_url'], "bibliotheque_id" => $this->request->data['bibliotheque_id'], "latitude" => $this->request->data['latitude'], "longitude" => $this->request->data['longitude'], "id_village" => $this->request->data['id_village']);
                $residance = $this->Residences->patchEntity($residance, $data);
            }else{
                $residance = $this->Residences->patchEntity($residance, $this->request->getData());
            }
            if($this->request->getData('image_header')['name']!=''){
                /** Header image **/
                $prefixe = PATH_ALPISSIME;
                $oldImageEtePath = "$prefixe/webroot/images/header_residence/".$residance->image_header.".png";
                unlink($oldImageEtePath);
                $destname = "$prefixe/webroot/images/header_residence/";
                $file = $this->request->data['image_header'];
                $ext=explode('/',$file['type']);
                $nameInit = str_replace(' ', '_', $this->request->data['name']); 
                $namespecial = preg_replace('/[^A-Za-z0-9\-]/', '', $nameInit);
                $name="header_residence_".$this->request->data['name_url']."_".$this->request->data['id_village'].".jpg";
                $imagineJPG = new Imagine();
                $imageupload = $imagineJPG->open($this->request->data['image_header']['tmp_name']);
                $imageupload->save($destname.$name, array('jpeg_quality' => 85));
                $residance->image_header=$name;
                /** Header image **/
            }
            if ($this->Residences->save($residance)) {
                $session->write("Residence.add","addvacance");
                return $this->redirect('/manager/parametrage/gps/edit/'.$id);
            }else{
                $session->write("Residence.addError","addvacance");
                return $this->redirect('/manager/parametrage/gps/edit/'.$id);
            }
        }
        
        $villages=$this->Villages->find()->ToArray();
        $bibliotheques=$this->Bibliotheques->find()->where('category is null')->order(['Bibliotheques.name ASC'])->ToArray();
        
        $this->set(compact('residance'));
        $this->set(compact('villages'));
        $this->set(compact('bibliotheques'));
        $this->render('/Manager/Gps/edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id Gp id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->loadModel('Residences');
        $this->request->allowMethod(['post', 'delete']);
        $gp = $this->Residences->get($id);
        $this->Residences->delete($gp);

        return $this->redirect(['action' => 'index']);
    }
    
    public function getResidances()
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->loadModel('Residences');
        $residences = $this->Residences->find('all', array( 'order' => 'Residences.id ASC', ) )->contain(['Bibliotheques','Villages']);
        $array=[];
        foreach ($residences as $residence){
            $array[]=[  'id'=>$residence->id.'',
                        'bibliotheque'=>$residence->bibliotheque->name,
                        'image'=>$residence->bibliotheque->image,
                        'latitude'=>$residence->latitude,
                        'longitude'=>$residence->longitude,
                        'section'=>$residence->village->name,
                        'nom'=>$residence->name
                ];
        }
        $this->set($array);
        $this->set('_serialize', array_keys($array));
    }
    /**
     * 
     */
    public function rassemplageresidences()
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->loadModel('Annonces');
        $this->loadModel('Residences');
        $listeIdRes=explode("||",$this->request->data['listeIdRes']);
        $nbrassemblage = 0;
        foreach ($listeIdRes as $value) {
            if($value != $this->request->data['choixResidence']){
                // Modifier batiment des annonces
                $listeannonce = $this->Annonces->find("all")->where(['batiment' => $value]);
                foreach ($listeannonce as $key) {
                    $datannonce = array('batiment' => $this->request->data['choixResidence']);
                    $annonce = $this->Annonces->patchEntity($key, $datannonce);
                    $this->Annonces->save($annonce);
                }
                // Supprimer cette résidence
                $batiment = $this->Residences->get($value);
                $this->Residences->delete($batiment);
            }
            $nbrassemblage++;
        }
        $this->set('nbrassemblage', $nbrassemblage);
        $this->set('data', "residence added");
        $this->set('_serialize', ['data', 'nbrassemblage']);
    }
}
