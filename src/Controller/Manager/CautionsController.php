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

class CautionsController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('Cautions');
        //end loading models
        //check auth
        // $manager_actions=['index','edit','allstations','webcams','allwebcams','addwebcam','editwebcam','deletewebcam'];
        // $admin_actions=['all'];
        $session = $this->request->session();
        if(!$session->check("Gestionnaire.info")){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
        /*$gest=$session->read('Gestionnaire.info');
        if($gest['G']['role']=="gestionnaire" && !in_array($this->request->getParam('action'), $manager_actions) ){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
        if($admin_actions[0]!='all' && $gest['G']['role']=="admin" && !in_array($this->request->getParam('action'), $admin_actions)){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }*/
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
        $this -> render('/Manager/PropResidence/Cautions/index','manager');
    }
    /**
     * 
     */
    public function allcautions()
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $cautions = $this->Cautions->find()->order('name');
        $data=[];
        $url=Router::url( '/', true ).'manager/cautions/edit/';
        foreach($cautions->toarray() as $caution){
            $row=[0=>$caution->name];
            $row[1]=$caution->description;
            $row[2]='<center><button class="btn btn-sm btn-default btn-icon-anim btn-circle" onclick="location.href=\''.$url.$caution->id.'\';"><i class="fa fa-pencil"></i></button>'
            .'&nbsp;&nbsp;&nbsp;'
            .'<button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_caution" data-name="'.$caution->name.'" data-key="'.$caution->id.'" ><i class="icon-trash"></i></button>'
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
        $caution = $this->Cautions->newEntity();
        //check persist success
        if($session->check("Caution.add")){
			$this->set('confirm_res',$session->read('Caution.add'));
			$session->delete("Caution.add");
        }
        //end check persist success
        //check persist error
		if($session->check("Caution.addError")){
			$this->set('error_res',$session->read('Caution.addError'));
			$session->delete("Caution.addError");
        }
        //end check persist error
        if ($this->request->is('post')) {
            $caution = $this->Cautions->patchEntity($caution, $this->request->getData());
            if ($this->Cautions->save($caution)) {
                $session->write("Caution.add","addCaution");
                return $this->redirect(['action' => 'add']);
            }
            else{
                $session->write("Caution.addError","addCaution");
            }
        }

        $this->set(compact('caution'));
        $this -> render('/Manager/PropResidence/Cautions/add','manager');
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
        $caution = $this->Cautions->get($id);
        //check persist success
        if($session->check("Caution.edit")){
			$this->set('confirm_res',$session->read('Caution.edit'));
			$session->delete("Caution.edit");
        }
        //end check persist success
        //check persist error
		if($session->check("Caution.editError")){
			$this->set('error_res',$session->read('Caution.editError'));
			$session->delete("Caution.editError");
        }
        //end check persist error
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data=$this->request->getData();
            $caution = $this->Cautions->patchEntity($caution, $data);
            if ($this->Cautions->save($caution)) {                
                $session->write("Caution.edit","addCaution");
                return $this->redirect(['action' => 'edit/'.$caution->id]);
            }
            $session->write("Caution.editError","editCaution");
        }

        $this->set(compact('caution'));
        $this -> render('/Manager/PropResidence/Cautions/edit','manager');
    }
    /**
     * 
     */
    public function getpropcautionrelation($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post']);
        $caution = $this->Cautions->get($id, ['contain' => 'Utilisateurs']);
        if(empty($caution->utilisateurs)) $this->set('res','vide');
        else $this->set('res','existe');
        $this->set('_serialize', 'res');
    }
    /**
     * 
     */
    public function deletecaution($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $caution = $this->Cautions->get($id);
        if ($this->Cautions->delete($caution)) {
            $this->set('res','deleted');
        } else {
            $errors=[];
            $errors = $caution->getErrors();
            $this->set('res',$errors);
        }
        $this->set('_serialize', 'res');
    }


}

?>