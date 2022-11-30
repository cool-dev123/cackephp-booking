<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Time;
/**
 * Registres Controller
 *
 * @property \App\Model\Table\RegistresTable $Registres
 */
class RegistresController extends AppController
{
	/*
	 *
	 */
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $session = $this->request->session();
        if(!$session->check("Gestionnaire.info")){
                return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
        $gest=$session->read('Gestionnaire.info');
        if ($gest['G']['role']!="admin" && $this->request->getParam('action') == 'pages'){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $registres = $this->paginate($this->Registres);
        $this->set(compact('registres'));
        $this->set('_serialize', ['registres']);
    }
    /**
     * View method
     *
     * @param string|null $id Registre id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $registre = $this->Registres->get($id, ['contain' => []]);
        $this->set('registre', $registre);
        $this->set('_serialize', ['registre']);
    }
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $registre = $this->Registres->newEntity();
        if ($this->request->is('post')) {
            $registre = $this->Registres->patchEntity($registre, $this->request->data);
            if ($this->Registres->save($registre)) {
                $this->Flash->success(__('The registre has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The registre could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('registre'));
        $this->set('_serialize', ['registre']);
    }
    /**
     * Edit method
     *
     * @param string|null $id Registre id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $registre = $this->Registres->get($id, ['contain' => []]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $registre = $this->Registres->patchEntity($registre, $this->request->data);
            if ($this->Registres->save($registre)) {
                $this->Flash->success(__('The registre has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The registre could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('registre'));
        $this->set('_serialize', ['registre']);
    }
    /**
     * Delete method
     *
     * @param string|null $id Registre id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $registre = $this->Registres->get($id);
        if ($this->Registres->delete($registre)) {
            $this->Flash->success(__('The registre has been deleted.'));
        } else {
            $this->Flash->error(__('The registre could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
	/*
	 *
	 */
	public function pages($id=null)
    {
			$session = $this->request->session();
			$this->viewBuilder()->layout('manager');
			$this->set('InfoGes',$session->read('Gestionnaire.info'));
			if($session->check("Inscription.manuelle")){
				$this->set('confirm_res','reservation');
				$session->delete("Inscription.manuelle");
			}
			$registre = $this->Registres->get($id, ['contain' => []  ]);
      if ($this->request->is(['patch', 'post', 'put'])) {
            $registre = $this->Registres->patchEntity($registre, $this->request->data);
            if ($this->Registres->save($registre)) {
                $session->write("Inscription.manuelle","addCompte");
                return $this->redirect(['action' => 'pages',$registre->id]);
            } else {
                $this->Flash->error(__('The registre could not be saved. Please, try again.'));
            }
      }
      $this->set(compact('registre'));
      $this->set('_serialize', ['registre']);
	}
}
