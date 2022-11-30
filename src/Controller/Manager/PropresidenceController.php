<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use function GuzzleHttp\json_encode;
use Cake\Routing\Router;
use Cake\Core\Exception\Exception;

class PropresidenceController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('Utilisateurs');
        $this->loadModel('Cautions');
        $this->loadModel('Paiements');
        $this->loadModel('Annulations');
        //end loading models
        //check auth
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
        $this -> render('/Manager/PropResidence/index','manager');
    }
    /**
     * 
     */
    public function allpropresidence()
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $propresidence = $this->Utilisateurs->find()->contain(['Cautions', 'Paiements', 'Annulations'])->where(['nature' => 'PRES']);
        $data=[];
        $url=Router::url( '/', true ).'manager/propresidence/edit/';
        foreach($propresidence->toarray() as $pres){
            $row=[0=>$pres->prenom];
            $row[1]=$pres->email;
            $row[2]=$pres->cautions[0]->name;
            $row[3]=$pres->paiements[0]->name;
            $row[4]=$pres->annulations[0]->name;
            $row[5]='<center><button class="btn btn-sm btn-default btn-icon-anim btn-circle" onclick="location.href=\''.$url.$pres->id.'\';"><i class="fa fa-pencil"></i></button>'
            .'</center>';
            $data[]=$row;
        }
        echo json_encode(['data'=>$data]);die();
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
        $propresidence = $this->Utilisateurs->get($id);
        //check persist success
        if($session->check("Utilisateur.edit")){
			$this->set('confirm_res',$session->read('Utilisateur.edit'));
			$session->delete("Utilisateur.edit");
        }
        //end check persist success
        //check persist error
		if($session->check("Utilisateur.editError")){
			$this->set('error_res',$session->read('Utilisateur.editError'));
			$session->delete("Utilisateur.editError");
        }
        //end check persist error
        // Liste cautions
        $listecautions = $this->Cautions->find("all");
        $this->set('listecautions',$listecautions);
        // Liste paiements
        $listepaiements = $this->Paiements->find("all");
        $this->set('listepaiements',$listepaiements);
        // Liste annulations
        $listeannulations = $this->Annulations->find("all")->group(['name']);
        $this->set('listeannulations',$listeannulations);
        // Utilisateur
        $utilisateur = $this->Utilisateurs->findById($id)->contain(['Cautions', 'Paiements', 'Annulations'])->first();
        $this->set('util_cautions',array_map(function($value) { return $value->id; }, $utilisateur->cautions));
        $this->set('util_paiements',array_map(function($value) { return $value->id; }, $utilisateur->paiements));
        $this->set('util_annulations',array_map(function($value) { return $value->id; }, $utilisateur->annulations));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $this->request->data);
            // Enregistrer règle caution
            if(!empty($this->request->getData('listecautions'))) $utilisateur->cautions = $this->Cautions->find()->where(['id IN' => $this->request->getData('listecautions')])->toArray();
            else $utilisateur->cautions = array();
            // Enregistrer règle paiement
            if(!empty($this->request->getData('listepaiements'))) $utilisateur->paiements = $this->Paiements->find()->where(['id IN' => $this->request->getData('listepaiements')])->toArray();
            else $utilisateur->paiements = array();
            // Enregistrer règle annulation
            if(!empty($this->request->getData('listeannulations'))) $utilisateur->annulations = $this->Annulations->find()->where(['id IN' => $this->request->getData('listeannulations')])->toArray();
            else $utilisateur->annulations = array();

            if ($this->Utilisateurs->save($utilisateur)) {                
                $session->write("Utilisateur.edit","addUtilisateur");
                return $this->redirect(['action' => 'edit/'.$utilisateur->id]);
            }
            $session->write("Utilisateur.editError","editUtilisateur");
        }

        $this->set(compact('utilisateur'));
        $this -> render('/Manager/PropResidence/edit','manager');
    }

    
}

?>