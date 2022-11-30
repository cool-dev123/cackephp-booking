<?php
/*
 * Controller/EventsController.php
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */

namespace FullCalendar\Controller;

use FullCalendar\Controller\FullCalendarAppController;
use Cake\Routing\Router;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;

/**
 * Events Controller
 *
 * @property \FullCalendar\Model\Table\EventsTable $Events
 */
class EventsController extends FullCalendarAppController
{
    public $name = 'Events';
    public $paginate = ['limit' => 15];
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $session = $this->request->session();
        $events = $this->Events->find('all')->contain(['EventTypes']);
        if ($this->request->is('requested')) {
            $this->paginate = [
                'limit'   => 2,
                'order'   => ['Events.start' => 'desc']
            ];
            $this->response->body(json_encode($this->paginate($events)));
            return $this->response;
        } else {
            $this->paginate = [
                'limit'   => 12,
                'order'   => ['Events.start' => 'desc']
            ];
            $this->set('events', $this->paginate($events));
            $this->set('_serialize', ['events']);
        }
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
    }

    /**
     * View method
     *
     * @param string|null $id Event id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $event = $this->Events->get($id, [
            'contain' => ['EventTypes']
        ]);
        $this->set('event', $event);
        $this->set('_serialize', ['event']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $session = $this->request->session();
        $event = $this->Events->newEntity();
        if ($this->request->is('post')) {
            $event = $this->Events->patchEntity($event, $this->request->data);
            if ($this->Events->save($event)) {
                $this->Flash->success(__('The event has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The event could not be saved. Please, try again.'));
            }
        }
        $this->set('eventTypes', $this->Events->EventTypes->find('list'));
        $this->set(compact('event'));
        $this->set('_serialize', ['event']);
        $this->set('InfoGes',$session->read('Gestionnaire.info'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Event id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $event = $this->Events->get($id, ['contain' => []]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $event = $this->Events->patchEntity($event, $this->request->data);
            if ($event_id = $this->Events->save($event)) {
                $this->Flash->success(__('The event has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The event could not be saved. Please, try again.'));
            }
        }
        $eventTypes = $this->Events->EventTypes->find('list');
        $this->set(compact('event', 'eventTypes'));
        $this->set('_serialize', ['event', 'eventTypes']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Event id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $event = $this->Events->get($id);
        if ($this->Events->delete($event)) {
            $this->Flash->success(__('The event has been deleted.'));
        } else {
            $this->Flash->error(__('The event could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    // The feed action is called from "webroot/js/ready.js" to get the list of events (JSON)
public function feed_old($id=null) {
        $this->viewBuilder()->layout('ajax');
        $vars = $this->request->query([]);
        $conditions = ['UNIX_TIMESTAMP(start) >=' => $vars['start'],'UNIX_TIMESTAMP(start) <=' => $vars['end'],'order'    => array('start DESC')];

        $events = $this->Events->find('all', $conditions)->contain(['EventTypes']);
       $childArray= '';
       $json = array();
       $mainarray = array();
       $loopStdate = '';
        foreach($events as $event) {

            if($event->all_day === 1) {
                $allday = true;
                $end = $event->start;
            } else {
                $allday = false;
                $end = $event->end;
            }
            if($loopStdate == ''){

               // echo $event->title.'<br>';
                $loopStdate = $event->start;
                $crStDate = date("d-M-Y", strtotime($event->start));

                $childArray .= '<b>'.$event->title.'</b><hr/>';
                /*array_push($childArray, array('id' => $event->id,
                                    'title'=> $event->title,
                                    'start'=> $event->start,
                                    'end' => $end,
                                    'allDay' => $allday,
                                    'url' => Router::url(['action' => 'view', $event->id]),
                                    'details' => $event->details)) ;*/

            }
            else{


                 if($crStDate == date("d-M-Y", strtotime($event->start)))
                {
                	$childArray .= '<b>'.$event->title.'</b><hr/>';

                        /*array_push($childArray, array('id' => $event->id,
                                    'title'=> $event->title,
                                    'start'=> $event->start,
                                    'end' => $end,
                                    'allDay' => $allday,
                                    'url' => Router::url(['action' => 'view', $event->id]),
                                    'details' => $event->details)) ;*/

                }else{


                    $mainarray ['className'] = $event->event_type->color;
                    $mainarray ['start'] = $loopStdate;
                    $mainarray ['title'] = 'Start';
                    $mainarray ['details'] = $childArray;


                    $childArray = '';
                    $loopStdate = $event->start;
                    $crStDate = date("d-M-Y", strtotime($event->start));
                    $childArray .= '<b>'.$event->title.'</b><hr/>';
                    /*array_push($childArray, array('id' => $event->id,
                                    'title'=> $event->title,
                                    'start'=> $event->start,
                                    'end' => $end,
                                    'allDay' => $allday,
                                    'url' => Router::url(['action' => 'view', $event->id]),
                                    'details' => $event->details)) ;*/

                }
                if(!empty($mainarray)):
                array_push($json, $mainarray);
                $mainarray = array();
                endif;
            }
           // echo $event->start.'>>>>>'.$end;   exit;
           /* $json[] = [
                    'id' => $event->id,
                    'title'=> $event->title,
                    'start'=> $event->start,
                    'end' => $end,
                    'allDay' => $allday,
                    'url' => Router::url(['action' => 'view', $event->id]),
                    'details' => $event->details,
                    'className' => $event->event_type->color
            ];*/

        }
        $this->set(compact('json'));
        $this->set('_serialize', 'json');

        //echo '<pre>';
        //print_r($json); exit;
    }

    public function feed(){
        //Fetch the session stored information
        $session = $this->request->session();
        //echo "<pre>";
        $session_array = array();
        $session_array = $session->read('Gestionnaire.info');

        $session_id = $session_array[G][id];
        $session_role = $session_array[G][role];


        $this->viewBuilder()->layout('ajax');
        $conn = ConnectionManager::get('default');

        //$stmt = $conn->execute("select concat(P.prenom,' ',P.nom_famille) as proprietaire,concat(L.prenom,' ',L.nom_famille) as locataire,L.adresse,R.dbt_at,R.fin_at,IF(D.promo_yn = 0, D.prix, D.promo_px) as prix,D.id from reservations R inner join utilisateurs L on R.utilisateur_id=L.id inner join annonces A on A.id=R.annonce_id inner join utilisateurs P on P.id=A.proprietaire_id inner join dispos D on D.reservation_id=R.id where R.statut= 90 order by R.dbt_at DESC");

        //If logged in user is Super Admin
        if($session_role=='admin')
        {
            $stmt = $conn->execute("select A.id as id_annonce, P.prenom as prenom_proprio,P.nom_famille as nom_proprio, P.email as email_proprio,
                L.prenom as prenom_loc,L.nom_famille as nom_loc,R.dbt_at,R.fin_at,R.heure_arr,R.heure_dep,IF(D.promo_yn = 0, D.prix, D.promo_px)
                                    as prix,G.name as gestionnaire,RS.name as residence,LG.name as station,L.email as
                                    mail_locataire,L.portable as locataire_port1,L.portable2 as locataire_port2,P.email as
                                    mail_prop,P.portable as proprietaire_port1,P.portable2 as
                                    proprietaire_port2,A.num_app,DATEDIFF(R.fin_at,R.dbt_at) as duration,R.comment as
                                    commentaire
                                    from reservations R
                                    inner join utilisateurs L on R.utilisateur_id=L.id
                                    inner join annonces A on A.id=R.annonce_id
                                    inner join lieugeos LG on A.lieugeo_id=LG.id
                                    inner join utilisateurs P on P.id=A.proprietaire_id
                                    inner join dispos D on D.reservation_id=R.id
                                    inner join residences RS on A.batiment=RS.id ".
                                    // left join annoncegestionnaires AG on AG.id_annonces=A.id
                                    "left join gestionnaires G on A.id_gestionnaires=G.id
                                    where R.statut= 90 and R.dbt_at>=NOW()
                                    group by R.id order by R.dbt_at DESC");
        }
        //Else of logged in user is a manager
        elseif($session_role=='gestionnaire')
        {
            $stmt = $conn->execute("select A.id as id_annonce, P.prenom as prenom_proprio,P.nom_famille as nom_proprio, P.email as email_proprio, L.prenom as prenom_loc,L.nom_famille as nom_loc,R.dbt_at,R.fin_at,R.heure_arr,R.heure_dep,IF(D.promo_yn = 0, D.prix, D.promo_px)
                                    as prix,G.name as gestionnaire,RS.name as residence,LG.name as station,L.email as
                                    mail_locataire,L.portable as locataire_port1,L.portable2 as locataire_port2,P.email as
                                    mail_prop,P.portable as proprietaire_port1,P.portable2 as
                                    proprietaire_port2,A.num_app,DATEDIFF(R.fin_at,R.dbt_at) as duration,R.comment as
                                    commentaire
                                    from reservations R
                                    inner join utilisateurs L on R.utilisateur_id=L.id
                                    inner join annonces A on A.id=R.annonce_id
                                    inner join lieugeos LG on A.lieugeo_id=LG.id
                                    inner join utilisateurs P on P.id=A.proprietaire_id
                                    inner join dispos D on D.reservation_id=R.id
                                    inner join residences RS on A.batiment=RS.id ".
                                    // inner join annoncegestionnaires AG on AG.id_annonces=A.id
                                    "inner join gestionnaires G on A.id_gestionnaires=G.id
                                    where R.statut= 90 and R.dbt_at>=NOW() and G.id=".$session_id."
                                    group by R.id order by R.dbt_at DESC");
        }

        $results = $stmt ->fetchAll('assoc');
        $tabDate = [];
        foreach($results as $event) {
            $childArray = '';
          if($session_role=='admin')
          {
              $childArray .= '<b>Gestionnaire : '.$event['gestionnaire'].'</b><br/>';
          }

          $portable_prop2 = ($event['proprietaire_port2']=='') ? '000000000' : $event['proprietaire_port2'];
          $portable_locataire2 = ($event['locataire_port2']=='') ? '000000000' : $event['locataire_port2'];

          $childArray .=  'Station: '.$event['station'].'<br/>';
          $childArray .=  'Résidence: '.$event['residence'].'<br/>';
          $childArray .=  'Propriétaire nom: '.$event['nom_proprio'].'<br/>';
          $childArray .=  'Propriétaire prénom: '.$event['prenom_proprio'].'<br/>';
          $childArray .=  'Propriétaire email: '.$event['email_proprio'].'<br/>';
          $childArray .=  'Propriétaire n° de portable 1: '.$event['proprietaire_port1'].'<br/>';
          if($event['proprietaire_port2']!='')
          $childArray .=  'Propriétaire n° de portable 2: '.$portable_prop2.'<br/>';
          $childArray .=  'Locataire nom: '.$event['nom_loc'].'<br/>';
          $childArray .=  'Locataire prénom: '.$event['prenom_loc'].'<br/>';
          $childArray .=  'Locataire email: '.$event['mail_locataire'].'<br/>';
          $childArray .=  'Locataire n° de portable 1: '.$event['locataire_port1'].'<br/>';
          if($event['locataire_port2']!='')
          $childArray .=  'Locataire n° de portable 2: '.$portable_locataire2.'<br/>';
          $childArray .=  'Locataire date d\'arrivée: '.$event['dbt_at']." ".$event['heure_arr'].'<br/>';
          $childArray .=  'Locataire date de départ: '.$event['fin_at']." ".$event['heure_dep'].'<br/>';
          $childArray .=  'Appartement prix periode: '. number_format($event['prix'], 2).' €'.'<br/>';
          $childArray .=  'Date periode from date hour to date hour ( PERIOD ) (Number of days): '. $event['duration'].'<br/>';
          $childArray .=  'Appartement prix taxe de séjour: '.'0'.'<br/>';
          $childArray .=  'Commentaires: '.mb_strimwidth($event['commentaire'], 0, 100, "...");

          $tabDate[$event['dbt_at']][] = [$childArray,$event];
        }

        $json = array();
        $mainarray = array();
//        foreach ($tabDate as $k => $value) {
//          $mainarray ['className'] = 'Blue';
//          $mainarray ['start'] = $k;
//          $mainarray ['title'] = 'Début';
//          $mainarray ['details'] = '';
//          foreach ($value as $key ) {
//            $mainarray ['details'] .= $key;
//          }
//          array_push($json, $mainarray);
//          $mainarray = array();
//        }
        
        foreach ($tabDate as $k => $value) {
            foreach ($value as $key ) {
                $mainarray ['className'] = 'Blue';
                $mainarray ['start'] = $k;
                $mainarray ['title'] = 'annonce N° '.$key[1]['id_annonce'];
                $mainarray ['details'] = $key[0];
                array_push($json, $mainarray);
                $mainarray = array();
            }
        }

        $this->set(compact('json'));
        $this->set('_serialize', 'json');
    }


    // The update action is called from "webroot/js/ready.js" to update date/time when an event is dragged or resized
    public function update($id = null)
    {
        if ($this->request->is('ajax')) {
            $this->request->accepts('application/json');
            $debuggedData = debug($this->request->data);
            $event = $this->Events->get($id);
            $event = $this->Events->patchEntity($event, $this->request->data);
            $this->Events->save($event);
            $this->set(compact('event'));
            $this->response->body(json_encode($this->request->data));
            return $this->response;
        }
    }

    public function dateToCal($timestamp) {
        return date('Ymd\THis\Z', $timestamp);
    }

    // Escapes a string of characters
    public function escapeString($string) {
      return preg_replace('/([\,;])/','\\\$1', $string);
    }

    public function download(){

        //Fetch the session stored information
        $session = $this->request->session();
        //echo "<pre>";
        $session_array = array();
        $session_array = $session->read('Gestionnaire.info');

        $session_id = $session_array[G][id];
        $session_role = $session_array[G][role];


        $this->viewBuilder()->layout('ajax');
        $conn = ConnectionManager::get('default');

        $this->viewBuilder()->layout('ajax');
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        //define('DATE_ICAL', 'Ymd\THis\Z');
        define('DATE_ICAL', 'Ymd');
        $conn = ConnectionManager::get('default');

        //$stmt = $conn->execute("select concat(P.prenom,' ',P.nom_famille) as proprietaire,concat(L.prenom,' ',L.nom_famille) as locataire,L.adresse,R.dbt_at,R.fin_at,IF(D.promo_yn = 0, D.prix, D.promo_px) as prix,D.id from reservations R inner join utilisateurs L on R.utilisateur_id=L.id inner join annonces A on A.id=R.annonce_id inner join utilisateurs P on P.id=A.proprietaire_id inner join dispos D on D.reservation_id=R.id where R.statut= 90 order by R.dbt_at DESC");

        //If logged in user is Super Admin
        if($session_role=='admin')
        {
            $stmt = $conn->execute("select P.prenom as prenom_proprio,P.nom_famille as nom_proprio,L.prenom as
                                    prenom_loc,L.nom_famille as nom_loc,R.dbt_at,R.fin_at,IF(D.promo_yn = 0, D.prix, D.promo_px)
                                    as prix,G.name as gestionnaire,RS.name as residence,LG.name as station,L.email as
                                    mail_locataire,L.portable as locataire_port1,L.portable2 as locataire_port2,P.email as
                                    mail_prop,P.portable as proprietaire_port1,P.portable2 as
                                    proprietaire_port2,A.num_app,DATEDIFF(R.fin_at,R.dbt_at) as duration,R.comment as
                                    commentaire 
                                    from reservations R 
                                    inner join utilisateurs L on R.utilisateur_id=L.id 
                                    inner join annonces A on A.id=R.annonce_id 
                                    inner join lieugeos LG on A.lieugeo_id=LG.id 
                                    inner join utilisateurs P on P.id=A.proprietaire_id 
                                    inner join dispos D on D.reservation_id=R.id 
                                    inner join residences RS on A.batiment=RS.id ".
                                    // left join annoncegestionnaires AG on AG.id_annonces=A.id
                                    " left join gestionnaires G on A.id_gestionnaires=G.id 
                                    where R.statut= 90 and R.dbt_at>=NOW() 
                                    group by R.id order by R.dbt_at DESC");
        }
        //Else of logged in user is a manager
        elseif($session_role=='gestionnaire')
        {
            $stmt = $conn->execute("select P.prenom as prenom_proprio,P.nom_famille as nom_proprio,L.prenom as
                                    prenom_loc,L.nom_famille as nom_loc,R.dbt_at,R.fin_at,IF(D.promo_yn = 0, D.prix, D.promo_px)
                                    as prix,G.name as gestionnaire,RS.name as residence,LG.name as station,L.email as
                                    mail_locataire,L.portable as locataire_port1,L.portable2 as locataire_port2,P.email as
                                    mail_prop,P.portable as proprietaire_port1,P.portable2 as
                                    proprietaire_port2,A.num_app,DATEDIFF(R.fin_at,R.dbt_at) as duration,R.comment as
                                    commentaire 
                                    from reservations R 
                                    inner join utilisateurs L on R.utilisateur_id=L.id 
                                    inner join annonces A on A.id=R.annonce_id 
                                    inner join lieugeos LG on A.lieugeo_id=LG.id 
                                    inner join utilisateurs P on P.id=A.proprietaire_id 
                                    inner join dispos D on D.reservation_id=R.id 
                                    inner join residences RS on A.batiment=RS.id ".
                                    // inner join annoncegestionnaires AG on AG.id_annonces=A.id
                                    " inner join gestionnaires G on A.id_gestionnaires=G.id 
                                    where R.statut= 90 and R.dbt_at>=NOW() and G.id=".$session_id."
                                    group by R.id order by R.dbt_at DESC");
        }

        $results = $stmt ->fetchAll('assoc');

        /*$output = "BEGIN:VCALENDAR
METHOD:PUBLISH
VERSION:2.0
PRODID:-//Thomas Multimedia//Clinic Time//EN\n";

        foreach($results as $event) {
              $output .="BEGIN:VEVENT
SUMMARY:".$event['proprietaire']."
UID:".$event['id']."
STATUS:CONFIRMED
DTSTART:" . date(DATE_ICAL, strtotime($event['dbt_at'])) . "
DTEND:" . date(DATE_ICAL, strtotime($event['fin_at'])) . "
LAST-MODIFIED:" . date(DATE_ICAL, strtotime($event['dbt_at'])) . "
LOCATION:".$event['locataire']."
END:VEVENT\n";
        }

$output .= "END:VCALENDAR";*/


$output = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Thomas Multimedia//Clinic Time//EN\n";

        foreach($results as $event) {

            //fetch the event informations
            $eventInfo='';
            $eventInfo .= '<b>Gestionnaire : '.$event['gestionnaire'].'</b><br/>';
            $eventInfo .=  'Station: '.$event['station'].'<br/>';
            $eventInfo .=  'Résidence: '.$event['residence'].'<br/>';
            $eventInfo .=  'Propriétaire nom: '.$event['nom_proprio'].'<br/>';
            $eventInfo .=  'Propriétaire prénom: '.$event['prenom_proprio'].'<br/>';
            $eventInfo .=  'Propriétaire email: '.$event['email_proprio'].'<br/>';
            $eventInfo .=  'Propriétaire n° de portable 1: '.$event['proprietaire_port1'].'<br/>';
            $eventInfo .=  'Propriétaire n° de portable 2: '.$event['proprietaire_port2'].'<br/>';
            $eventInfo .=  'Propriétaire n° de portable 3: '.'000000000'.'<br/>';
            $eventInfo .=  'Propriétaire n° de portable 4: '.'000000000'.'<br/>';
            $eventInfo .=  'Locataire nom: '.$event['nom_loc'].'<br/>';
            $eventInfo .=  'Locataire prénom: '.$event['prenom_loc'].'<br/>';
            $eventInfo .=  'Locataire email: '.$event['mail_locataire'].'<br/>';
            $eventInfo .=  'Locataire n° de portable 1: '.$event['locataire_port1'].'<br/>';
            $eventInfo .=  'Locataire n° de portable 2: '.$event['locataire_port2'].'<br/>';
            $eventInfo .=  'Locataire n° de portable 3: '.'000000000'.'<br/>';
            $eventInfo .=  'Locataire n° de portable 4: '.'000000000'.'<br/>';
            $eventInfo .=  'Locataire date d\'arrivée: '.date('d/m/Y H:i', strtotime($event['dbt_at'])).'<br/>';
            $eventInfo .=  'Locataire date de départ: '.date('d/m/Y H:i', strtotime($event['fin_at'])).'<br/>';
            $eventInfo .=  'Appartement prix periode: '. number_format($event['prix'], 2).' €'.'<br/>';
            $eventInfo .=  'Date periode from date hour to date hour ( PERIOD ) (Number of days): '. $event['duration'].'<br/>';
            $eventInfo .=  'Appartement prix taxe de séjour: '.'0'.'<br/>';
            $eventInfo .=  'Commentaires: '.mb_strimwidth($event['commentaire'], 0, 100, "...").'<hr/>';


              $output .="BEGIN:VEVENT
CLASS:PUBLIC
DESCRIPTION:".$eventInfo."
DTSTART:" . date(DATE_ICAL, strtotime($event['dbt_at'])) . "
DTEND:" . date(DATE_ICAL, strtotime($event['fin_at'])) . "
LOCATION:
SUMMARY;LANGUAGE=en-us:Début
TRANSP:TRANSPARENT
END:VEVENT\n";
        }

$output .= "END:VCALENDAR";







      // return $output;
       echo $output;

    }


}
