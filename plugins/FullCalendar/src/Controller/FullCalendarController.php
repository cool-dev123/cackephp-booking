<?php

/*
 * Controller/FullCalendarController.php
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */

namespace FullCalendar\Controller;

use Cake\Event\Event;
use FullCalendar\Controller\FullCalendarAppController;

class FullCalendarController extends FullCalendarAppController
{
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $session = $this->request->session();
                                if(!$session->check("Gestionnaire.info")){
                                        return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
                                }
    }
	public $name = 'FullCalendar';

	public function index() {
		$session = $this->request->session();
		$this->viewBuilder()->layout('manager');
		
		if(!$session->check("Gestionnaire.info")){
			return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
		}
		$this->set('InfoGes',$session->read('Gestionnaire.info'));
	}

}
