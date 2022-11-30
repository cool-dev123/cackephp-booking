<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Time;

/**
 * Packs Controller
 *
 * @property \App\Model\Table\PacksTable $Packs
 */
class PacksController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $session = $this->request->session();
        $admin_actions=['index','add','edit'];
        if(!$session->check("Gestionnaire.info")){
                return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
        $gest=$session->read('Gestionnaire.info');
        if ($gest['G']['role']=="gestionnaire" && in_array($this->request->getParam('action'), $admin_actions)){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
    }
	/**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
  function index() {
   	$session = $this->request->session();
    if($session->check("Pub.edit")){
			$this->set('confirm_res',$session->read('Pub.edit'));
			$session->delete("Pub.edit");
		}
		$this->viewBuilder()->layout('manager');
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
		$this->set('packs', $this->Packs->find('all',["order"=>"titre asc"]));
	}
  /**
   * View method
   *
   * @param string|null $id Pack id.
   * @return \Cake\Network\Response|null
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function view($id = null)
  {
      $pack = $this->Packs->get($id, ['contain' => ['Reservations']]);
      $this->set('pack', $pack);
      $this->set('_serialize', ['pack']);
  }
  /**
   * Add method
   *
   * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
   */
  public function add()
  {
    $session = $this->request->session();
    if($session->check("Vacances.add")){
            $this->set('confirm_res',$session->read('Vacances.add'));
            $session->delete("Vacances.add");
    }
    if($session->check("Vacances.addError")){
            $this->set('error_res',$session->read('Vacances.addError'));
            $session->delete("Vacances.addError");
    }
    $this->viewBuilder()->layout('manager');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));
    $pack = $this->Packs->newEntity();
    if ($this->request->is('post')) {
        
      $pack = $this->Packs->patchEntity($pack, $this->request->data);
        if(isset($this->request->data['actif_yn']))
            $pack['actif_yn'] =true;
        else
            $pack['actif_yn'] =false;
      if ($this->Packs->save($pack)) {
          $session->write("Vacances.add","Le pack a bien été sauvegardé");
          return $this->redirect(['action' => 'add']);
      } else {
          $session->write("Vacances.addError","Le pack n'a pas été sauvegardé");
          return $this->redirect(['action' => 'add']);
      }
    }
  }
  /**
   * Edit method
   *
   * @param string|null $id Pack id.
   * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Network\Exception\NotFoundException When record not found.
   */
  public function edit($id = null)
  {
    $session = $this->request->session();
    if($session->check("Vacances.add")){
            $this->set('confirm_res',$session->read('Vacances.add'));
            $session->delete("Vacances.add");
    }
    if($session->check("Vacances.addError")){
            $this->set('error_res',$session->read('Vacances.addError'));
            $session->delete("Vacances.addError");
    }
    $this->viewBuilder()->layout('manager');
    $this->set('InfoGes',$session->read('Gestionnaire.info'));
    $pack = $this->Packs->get($id);
    if ($this->request->is(['patch', 'post', 'put'])) {
        $pack = $this->Packs->patchEntity($pack, $this->request->data);
        if(isset($this->request->data['actif_yn']))
            $pack['actif_yn'] =true;
        else
            $pack['actif_yn'] =false;
        if ($this->Packs->save($pack)) {
            $session->write("Vacances.add","Le pack a bien été sauvegardé");
            return $this->redirect(['action' => 'edit',$id]);
        } else {
            $session->write("Vacances.addError","Le pack n'a pas été sauvegardé");
            return $this->redirect(['action' => 'edit',$id]);
        }
    }
    $this->set(compact('pack'));
    $this->set('_serialize', ['pack']);
  }
  /**
   * Delete method
   *
   * @param string|null $id Pack id.
   * @return \Cake\Network\Response|null Redirects to index.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function delete($id = null)
  {
		$session = $this->request->session();
    $pack = $this->Packs->get($id);
    if ($this->Packs->delete($pack)) {
        $session->write("Pub.edit","Pack supprimé");
    } else {
       $session->write("Pub.edit","Pack invalide");
    }
    return $this->redirect(['action' => 'index']);
  }
	
}
