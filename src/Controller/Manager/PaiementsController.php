<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Core\Exception\Exception;

class PaiementsController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('Paiements');
        //end loading models
        $session = $this->request->session();
        if(!$session->check("Gestionnaire.info")){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
        //end check auth
    }
    /**
     * 
     */
    public function index()
    {
        //set manager infos
        $session = $this->request->session();
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        //End set manager infos
        $this -> render('/Manager/PropResidence/Paiements/index','manager');
    }
    /**
     * 
     */
    public function allpaiements()
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $paiements = $this->Paiements->find()->order('name');
        $data=[];
        $url=Router::url( '/', true ).'manager/paiements/edit/';
        $typefrais = array("pourcentage" => "%", "fixe" => "€");
        foreach($paiements->toarray() as $paiement){
            $row=[0=>$paiement->name];
            $row[1]=$paiement->nbr_jour;
            if($paiement->taux_commission != 0) $row[2]=$paiement->taux_commission;
            else $row[2]="";
            if($paiement->frais_service != 0) $row[3]=$paiement->frais_service." ".$typefrais[$paiement->type_frais];
            else $row[3]="";
            $row[4]='<center><button class="btn btn-sm btn-default btn-icon-anim btn-circle" onclick="location.href=\''.$url.$paiement->id.'\';"><i class="fa fa-pencil"></i></button>'
            .'&nbsp;&nbsp;&nbsp;'
            .'<button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_paiement" data-name="'.$paiement->name.'" data-key="'.$paiement->id.'" ><i class="icon-trash"></i></button>'
            .'</center>';
            $data[]=$row;
        }
        echo json_encode(['data'=>$data]);die();
    }
    /**
     * 
     */
    public function add()
    {
        //set manager infos
        $session = $this->request->session();
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        //End set manager infos
        $paiement = $this->Paiements->newEntity();
        //check persist success
        if($session->check("paiement.add")){
			$this->set('confirm_res',$session->read('paiement.add'));
			$session->delete("paiement.add");
        }
        //end check persist success
        //check persist error
		if($session->check("paiement.addError")){
			$this->set('error_res',$session->read('paiement.addError'));
			$session->delete("paiement.addError");
        }
        //end check persist error
        if ($this->request->is('post')) {
            $paiement = $this->Paiements->patchEntity($paiement, $this->request->getData());
            if ($this->Paiements->save($paiement)) {
                $session->write("paiement.add","addpaiement");
                return $this->redirect(['action' => 'add']);
            }
            else{
                $session->write("paiement.addError","addpaiement");
            }
        }

        $this->set(compact('paiement'));
        $this -> render('/Manager/PropResidence/Paiements/add','manager');
    }
    /**
     * 
     */
    public function edit($id = null)
    {
        $session = $this->request->session();
        //set manager infos
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
        //end set manager infos
        $paiement = $this->Paiements->get($id);
        //check persist success
        if($session->check("Paiement.edit")){
			$this->set('confirm_res',$session->read('Paiement.edit'));
			$session->delete("Paiement.edit");
        }
        //end check persist success
        //check persist error
		if($session->check("Paiement.editError")){
			$this->set('error_res',$session->read('Paiement.editError'));
			$session->delete("Paiement.editError");
        }
        //end check persist error
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data=$this->request->getData();
            $paiement = $this->Paiements->patchEntity($paiement, $data);
            if ($this->Paiements->save($paiement)) {                
                $session->write("Paiement.edit","addPaiement");
                return $this->redirect(['action' => 'edit/'.$paiement->id]);
            }
            $session->write("Paiement.editError","editPaiement");
        }

        $this->set(compact('paiement'));
        $this -> render('/Manager/PropResidence/Paiements/edit','manager');
    }
    /**
     * 
     */
    public function getproppaiementrelation($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post']);
        $paiement = $this->Paiements->get($id, ['contain' => 'Utilisateurs']);
        if(empty($paiement->utilisateurs)) $this->set('res','vide');
        else $this->set('res','existe');
        $this->set('_serialize', 'res');
    }
    /**
     * 
     */
    public function deletepaiement($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $paiement = $this->Paiements->get($id);
        if ($this->Paiements->delete($paiement)) {
            $this->set('res','deleted');
        } else {
            $errors=[];
            $errors = $paiement->getErrors();
            $this->set('res',$errors);
        }
        $this->set('_serialize', 'res');
    }

}
?>