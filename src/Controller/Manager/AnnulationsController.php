<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Core\Exception\Exception;

class AnnulationsController extends AppController
{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        //loading models
        $this->loadModel('Annulations');
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
        $this -> render('/Manager/PropResidence/Annulations/index','manager');
    }
    /**
     * 
     */
    public function allannulations()
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $annulations = $this->Annulations->find()->group(['name'])->order('name');
        $data=[];
        $url=Router::url( '/', true ).'manager/annulations/edit/';
        foreach($annulations->toarray() as $annulation){
            $row=[0=>$annulation->name];
            $row[1]='<center>';
            // $row[1].='<button class="btn btn-sm btn-default btn-icon-anim btn-circle" onclick="location.href=\''.$url.$annulation->id.'\';"><i class="fa fa-pencil"></i></button>'.'&nbsp;&nbsp;&nbsp;';
            $row[1].='<button data-key="'.$annulation->name.'" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-warning btn-icon-anim btn-circle view_annulation" onclick=""><i class="fa fa-search"></i></button>'.'&nbsp;&nbsp;&nbsp;';
            // $row[1].='<button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_annulation" data-name="'.$annulation->name.'" data-key="'.$annulation->id.'" ><i class="icon-trash"></i></button>'
            $row[1].='</center>';
            $data[]=$row;
        }
        echo json_encode(['data'=>$data]);die();
    }
    /**
     * 
     */
    public function getdetailannulation($name)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $annulations = $this->Annulations->find()->where(['name' => $name])->order(['interval_1 DESC']);
        $msgretour = "";
        foreach ($annulations as $annulation) {
            if($annulation->interval_1 == 0){
                $msgretour .= "<p> - Moins de ".$annulation->interval_2." jours avant la date d'arrivée : ".$annulation->reservation_pourc." % du montant du séjour seront retenus</p>";
            }else if($annulation->interval_2 == 100){
                if($annulation->reservation_pourc == 0) $msgretour .= "<p> - Plus de ".$annulation->interval_1." jours avant la date d'arrivée : Sans frais";
                else $msgretour .= "<p> - Plus de ".$annulation->interval_1." jours avant la date d'arrivée : ".$annulation->reservation_pourc." % du montant du séjour seront retenus</p>";
            }else{
                $msgretour .= "<p> - Entre ".$annulation->interval_1." et ".$annulation->interval_2." jours avant la date d'arrivée : ".$annulation->reservation_pourc." % du montant du séjour seront retenus</p>";
            } 
        }
        $msgretour .= "<p>Remboursement à 100% de la taxe de séjour. Les frais de service ne sont pas remboursés.</p>";
        echo json_encode(['data'=>$msgretour]);die();
    }
    /**
     * 
     */
    public function getpropannulationrelation($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post']);
        $annulation = $this->Annulations->get($id, ['contain' => 'Utilisateurs']);
        if(empty($annulation->utilisateurs)) $this->set('res','vide');
        else $this->set('res','existe');
        $this->set('_serialize', 'res');
    }
    /**
     * 
     */
    public function deleteannulation($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $this->request->allowMethod(['post', 'delete']);
        $annulation = $this->Annulations->get($id);
        if ($this->Annulations->delete($annulation)) {
            $this->set('res','deleted');
        } else {
            $errors=[];
            $errors = $annulation->getErrors();
            $this->set('res',$errors);
        }
        $this->set('_serialize', 'res');
    }

}
?>