<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;

/**
 * Partenaire Controller
 *
 * @property \App\Model\Table\PartenairesTable $Partenaire
 *
 * @method \App\Model\Entity\Partenaires[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PartenaireController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('Partenaires');
        $this->loadModel('Lieugeos');
        $this->loadModel('Frvilles');
        $this->loadModel('Pvilles');
        $this->loadModel('Pays');
        //end loading models
        //check auth
        $session = $this->request->session();
        if(!($session->check("Gestionnaire.info")) || $session->read('Gestionnaire.info')['G']['role']=="gestionnaire")
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
        $this -> render('/Manager/Stations/Partenaires/index','manager');
    }

    /**
     * allpartenaires method
     * get all partenaires for data table
     *
     * @return \Cake\Http\json
     */
    public function allpartenaires(){
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $partenaires = $this->Partenaires->find('all')->contain(['Lieugeos']);
        $data=[];
        $url=Router::url( '/', true ).'manager/partenaire/edit/';
        foreach($partenaires->toarray() as $partenaire){
            $row=[$partenaire->part_code];
            $row[]=$partenaire->raison_sociale;
            $row[]=$partenaire->siriet;
            $row[]=$partenaire->fonction;
            $row[]=$partenaire->email;
            $row[]='<div class="text-center"><button class="btn btn-sm btn-default btn-icon-anim btn-circle mr-5" onclick="location.href=\''.$url.$partenaire->id.'\';"><i class="fa fa-pencil"></i></button>'
            .'<button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_domaine" data-name="'.$partenaire->nom.'" data-key="'.$partenaire->id.'" ><i class="icon-trash"></i></button>'
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
        $partenaire = $this->Partenaires->newEntity();
        //check persist success
        if($session->check("Partenaire.add")){
			$this->set('confirm_res',$session->read('Partenaire.add'));
			$session->delete("Partenaire.add");
        }
        //end check persist success
        //check persist error
		if($session->check("Partenaire.addError")){
			$this->set('error_res',$session->read('Partenaire.addError'));
			$session->delete("Partenaire.addError");
        }
        //end check persist error
        if ($this->request->is('post')) {
            //set null for blank inputs
            $data = array_map( 
                function($row) { return $row==''?null:$row; }, 
                $this->request->getData()
            );
            //end set null for blank inputs
            $partenaire = $this->Partenaires->patchEntity($partenaire, $data);
            
            // Liste id stations
            $listeID = '';
            foreach ($this->request->getData('lieugeo_id') as $value) {
                $listeID .= $value.";";
            }
            $partenaire->lieugeo_id=$listeID;
            if ($partenaire_new = $this->Partenaires->save($partenaire)) {
                //image
                $prefixe = $_SERVER['DOCUMENT_ROOT'];
                $destname = "$prefixe/webroot/images/partners/";
                // $destname = "$prefixe/webroot/img/uploads/";
                $file = $this->request->data['image'];
                $ext=explode('/',$file['type']);
                $name="logo_partner_".str_replace(" ", "_", $partenaire_new->id);
                $imagineJPG = new Imagine();
                if($ext[1] == "png"){
                    $imageupload = $imagineJPG->open($this->request->data['image']['tmp_name']);
                    $imageupload->resize(new Box(350, 150));
                    $imageupload->save($destname.$name.".png", array('png_compression_level' => 5))
                                ->save($destname.$name.".webp", array('webp_quality' => 85));
                }
                //image
                $partenaireNew = $this->Partenaires->patchEntity($partenaire_new, array('image' => $name));
                $this->Partenaires->save($partenaireNew);
                // $partenaire->image=$name;
                $session->write("Partenaire.add","addPartenaire");
                return $this->redirect(['action' => 'add']);
            }
            else{
                $session->write("Partenaire.addError","addPartenaire");
            }
        }
        //get pays list
        $this->loadModel('Pays');
        $this->set('pays',$this->Pays->find('list', [
            'keyField' => 'id_pays',
            'valueField' => 'fr'
        ])->order('fr')->toArray());
        //end get pays list
        //get departements list
        $this->loadModel('Departements');
        $deps=$this->Departements->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order('name')->toArray();
        $this->set('departements',$deps);
        //end get departements list
        //get frVilles list
        $this->loadModel('Frvilles');
        $this->set('villes',$this->Frvilles->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->where(['departement_id'=>$partenaire->departement_id==null?key($deps):$partenaire->departement_id])->order('name')->toArray());
        //end get frVilles list
        //get massifs list
        $this->loadModel('Massif');
        $massifs=$this->Massif->find('list', [
            'keyField' => 'id',
            'valueField' => 'nom'
        ])->toArray();
        $this->set('massifs',$massifs);
        //end get massifs list
        //set stations list
        if($partenaire->lieugeo_id==null)
        {
            $partenaire->massif_id=key($massifs);
        }
        $lieugeos=$this->Lieugeos->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order('name')->where(['massif_id'=>$partenaire->massif_id]);
        $this->set('lieugeos',$lieugeos);
        //end set stations list
        //get types list
        $this->set('types',$this->Partenaires->getStaticTypes());
        //end get types list
        $this->set(compact('partenaire'));
        $this -> render('/Manager/Stations/Partenaires/add','manager');
    }

    /**
     * Edit method
     *
     * @param string|null $id Partenaire id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $session = $this->request->session();
        //set manager infos
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        //end set manager infos
        $partenaire = $this->Partenaires->findById($id)->contain('Lieugeos')->first();
        $partenaire->massif_id=$partenaire->lieugeo->massif_id;
        // Liste selected ID lieugeos
        $ID_lieugeos = explode(";", $partenaire->lieugeo_id);
        $this->set('ID_lieugeos',$ID_lieugeos);
        // END Liste selected ID lieugeos
        //check persist success
        if($session->check("Partenaire.edit")){
			$this->set('confirm_res',$session->read('Partenaire.edit'));
			$session->delete("Partenaire.edit");
        }
        //end check persist success
        //check persist error
		if($session->check("Partenaire.editError")){
			$this->set('error_res',$session->read('Partenaire.editError'));
			$session->delete("Partenaire.editError");
        }
        //end check persist error
        if ($this->request->is(['patch', 'post', 'put'])) {
            //set null for blank inputs
            $data = array_map( 
                function($row) { return $row==''?null:$row; }, 
                $this->request->getData()
            );
            //end set null for blank inputs
            if($this->request->getData('image')['name']=='') $data['image']=$partenaire->image;
            $partenaire = $this->Partenaires->patchEntity($partenaire, $data);

            if($this->request->getData('image')['name'] != ''){
                $prefixe = $_SERVER['DOCUMENT_ROOT'];
                $oldImagePath = "$prefixe/webroot/images/partners/".$partenaire->image.".png";
                $oldImagePathWebp = "$prefixe/webroot/images/partners/".$partenaire->image.".webp";
                //image
                $destname = "$prefixe/webroot/images/partners/";
                //$destname = "$prefixe/webroot/images/partners/";
                $file = $this->request->data['image'];
                $ext=explode('/',$file['type']);
                $name="logo_partner_".str_replace(" ", "_", $id);
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
                $partenaire->image=$name;
            }            
            // Liste ID station
            $listeID = '';
            foreach ($this->request->getData('lieugeo_id') as $value) {
                $listeID .= $value.";";
            }
            $partenaire->lieugeo_id=$listeID;
            if ($this->Partenaires->save($partenaire)) {                
                $session->write("Partenaire.edit","editPartenaire");
                return $this->redirect(['action' => 'edit/'.$partenaire->id]);
            }
            else{
                $session->write("Partenaire.editError","editPartenaire");
            }
        }
        //get pays list
        $this->loadModel('Pays');
        $this->set('pays',$this->Pays->find('list', [
            'keyField' => 'id_pays',
            'valueField' => 'fr'
        ])->order('fr')->toArray());
        //end get pays list
        //get departements list
        $this->loadModel('Departements');
        $deps=$this->Departements->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order('name')->toArray();
        $this->set('departements',$deps);
        //end get departements list
        //get frVilles list
        $this->loadModel('Frvilles');
        $this->set('villes',$this->Frvilles->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->where(['departement_id'=>$partenaire->departement_id])->order('name')->toArray());
        //end get frVilles list
        //get massifs list
        $this->loadModel('Massif');
        $massifs=$this->Massif->find('list', [
            'keyField' => 'id',
            'valueField' => 'nom'
        ])->toArray();
        $this->set('massifs',$massifs);
        //end get massifs list
        //set stations list
        if($partenaire->lieugeo_id==null)
        {
            $partenaire->massif_id=key($massifs);
        }
        $lieugeos=$this->Lieugeos->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->order('name')->where(['massif_id'=>$partenaire->massif_id]);
        $this->set('lieugeos',$lieugeos);
        //end set stations list
        //get types list
        $this->set('types',$this->Partenaires->getStaticTypes());
        //end get types list
        $this->set(compact('partenaire'));
        $this -> render('/Manager/Stations/Partenaires/edit','manager');
    }

    /**
     * Delete method
     *
     * @param string|null $id Partenaire id.
     * @return Json
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $partenaire = $this->Partenaires->get($id);
        if ($this->Partenaires->delete($partenaire)) {
            $this->set('res','deleted');
        }
        $this->set('_serialize', 'res');
    }
}
