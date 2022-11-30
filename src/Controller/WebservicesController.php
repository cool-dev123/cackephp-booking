<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Xml;
use soap_server;
use Cake\Event\Event;
/**
 * Webservices Controller
 */
 ini_set('soap.wsdl_cache_enabled', 0);
class WebservicesController extends AppController
{
  var $helpers = ['Text', 'Xml'];

  public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
      	$this->autoRender = false ;
      	$this->viewBuilder()->layout(false);
        $this->loadComponent('Auth', [
        'loginAction' => [
            'controller' => 'Utilisateurs',
            'action' => 'erreurconnexion'
        ],
		'logoutRedirect' => [
                'controller' => 'annonces',
                'action' => 'landing'
        ],
        'loginRedirect' => [
            'controller' => 'annonces',
            'action' => 'landing'
        ],
        'authError' => __('Connexion impossible, merci de vérifier vos identifiants'),
        'authenticate' => [
            'Form' => [
				'fields' => ["username"=>"email","password"=>"pwd"],
				'userModel'=>'Utilisateurs'
            ]
        ],
        'storage' => 'Session'
    ]);
    }
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }

    function process()
    {
        require_once(ROOT . DS . 'vendor' . DS . 'nusoap'.DS.'lib'.DS.'nusoap.php');
        $server = new soap_server();
        $endpoint = 'http://alpissime.com/webservices/process';
        //initialize WSDL support
        $server->configureWSDL('helloWorldwsdl', 'urn:helloWorldwsdl', $endpoint);
        $server->soap_defencoding='UTF-8';
        $server->decode_utf8 = false;
        $server->register('helloWorld',
    		    array ('txt'  => 'xsd:txt'),                // method name
            array('return' => 'xsd:string'),    // output parameters
                'urn:helloWorldwsdl',                    // namespace
                'urn:helloWorldwsdl#helloWorld',                // soapaction
                'rpc',                                // style
                'encoded',                            // use
                'Says hello to the caller'            // documentation
            );
        $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : array('test'=>'test');
        $server->service($HTTP_RAW_POST_DATA);
        exit();
    }
    
    public function getconnection(){
        $this->autoRender = true ;
        $this->RequestHandler->renderAs($this, 'json'/*or xml*/);
        $data=$this->request->getData();
        $user = $this->Auth->identify();
        if($user && $user['valide_at']!=null){
            $this->Auth->setUser($user);
            $this->set('status','connected');
        }
        elseif($user && $user['valide_at']==null){
            $this->set('status','account deactivate');
        }
        else
            $this->set('status','unauthorized');
        $this->set('_serialize','status');
    }
    /**
  	 *
  	 **/
     function helloWorld($txt) {
          return 'Hello'.$txt;
    }

}