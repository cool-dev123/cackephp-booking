<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\I18n\Date;
use \DateTime;
use \DateTimeZone;
use \Google_Client;
use \Google_Service_Calendar;
use \Google_Service_Drive;
use \Google_Service_Plus;
use \Google_Service_Calendar_Event;
use \Google_Service_Calendar_EventDateTime;
use \Google_Service_Calendar_Calendar;
use \Google_Service_Calendar_CalendarListEntry;

/**
 * GoogleCalendar Controller
 *
 *
 * @method \App\Model\Entity\GoogleCalendar[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GoogleCalendarController extends AppController
{
    /**
     * $MY_KEY attribute : the api key of GoogleCalendar
     */
    public $CREDENTIALS;
    public $TOKENPATH;

    function __construct() {
        parent::__construct();
        $this->CREDENTIALS = __DIR__.'/json/credentials.json';
        $this->TOKENPATH = __DIR__.'/json/token.json';

        // $this->CREDENTIALS = '';
        // $this->TOKENPATH = '';
    }

    public function initialize()
    {
        parent::initialize();
        $this->loadModel("Utilisateurs");
		$this->loadModel("Annonces");
		$this->loadModel("Reservations");
		$this->loadModel("Reservationtelephone");      
    }

    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Alpissime Google Calendar API');
        $client->setScopes(implode(' ', array(
            		Google_Service_Calendar::CALENDAR)
            ));
        $client->setAuthConfig($this->CREDENTIALS);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = $this->TOKENPATH;
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }


    /**
     * googlecalendarinsert method
     */
    public function googlecalendarinsert($reservation, $calendarId)
    {        
        $reservation = $this->Reservations->get($reservation->id);
        
		$client = $this->getClient();
		$service = new Google_Service_Calendar($client);
        /** INSERT EVENT **/
        $locataire = $this->Utilisateurs->get($reservation->utilisateur_id);
        $annonce = $this->Annonces->get($reservation->annonce_id);
        $prop = $this->Utilisateurs->get($annonce->proprietaire_id);
        $start = new Google_Service_Calendar_EventDateTime();
        $date = new DateTime($reservation->heure_arr->i18nFormat('yyyy-MM-dd HH:mm:ss'), new DateTimeZone('Europe/Paris'));
        $date->setDate($reservation->dbt_at->i18nFormat('YYY'), $reservation->dbt_at->i18nFormat('MM'), $reservation->dbt_at->i18nFormat('dd'));
        $start->setDateTime($date->format(DateTime::ATOM));
        $start->setTimeZone(new DateTimeZone('Europe/Paris'));
        $event = new Google_Service_Calendar_Event(array(
            'summary' => 'Réservation Annonce '.$reservation->annonce_id,
            'description' => 'Locataire: '.$locataire->email.' -- Locataire prénom: '.$locataire->prenom.' -- Locataire nom: '.$locataire->nom_famille.' -- Propriétaire: '.$prop->email.' -- Propriétaire prénom: '.$prop->prenom.' -- Propriétaire nom: '.$prop->nom_famille.' -- Départ: '.$reservation->fin_at.' -- Heure départ: '.$reservation->heure_dep,
            'start' => $start,
            'end' => $start,
        ));
        $event = $service->events->insert($calendarId, $event);
        return($event->id); 
    }

    /**
     * googlecalendarupdate method
     */
    public function googlecalendarupdate($reservation, $calendarId)
    {
        $client = $this->getClient();
		$service = new Google_Service_Calendar($client);
        /** UPDATE EVENT **/
        $locataire = $this->Utilisateurs->get($reservation->utilisateur_id);
        $annonce = $this->Annonces->get($reservation->annonce_id);
        $prop = $this->Utilisateurs->get($annonce->proprietaire_id);
        $event = $service->events->get($calendarId, $reservation->id_googlecalendar);
        $start = new Google_Service_Calendar_EventDateTime();
        $date = new DateTime($reservation->heure_arr->i18nFormat('yyyy-MM-dd HH:mm:ss'), new DateTimeZone('Europe/Paris'));
        $date->setDate($reservation->dbt_at->i18nFormat('YYY'), $reservation->dbt_at->i18nFormat('MM'), $reservation->dbt_at->i18nFormat('dd'));
        $start->setDateTime($date->format(DateTime::ATOM));
        $start->setTimeZone(new DateTimeZone('Europe/Paris'));
        $event->setStart($start);
        $event->setEnd($start);
        $event->setDescription('Locataire: '.$locataire->email.' -- Locataire prénom: '.$locataire->prenom.' -- Locataire nom: '.$locataire->nom_famille.' -- Propriétaire: '.$prop->email.' -- Propriétaire prénom: '.$prop->prenom.' -- Propriétaire nom: '.$prop->nom_famille.' -- Départ: '.$reservation->fin_at.' -- Heure départ: '.$reservation->heure_dep);
        $updatedEvent = $service->events->update($calendarId, $event->getId(), $event);
        return true; 
    }

    /**
     * googlecalendardelete method
     */
    public function googlecalendardelete($id_event, $calendarId)
    {
        $client = $this->getClient();
		$service = new Google_Service_Calendar($client);
        /** DELETE EVENT **/
        $service->events->delete($calendarId, $id_event);
        return true; 
    }

    /**
     * googlecalendarinsertoptioncontrat method
     */
    public function googlecalendarinsertoptioncontrat($valuedate, $calendarId)
    {      
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);
        /** INSERT EVENT **/   
        // Liste dates
        $listedates = explode(";", $valuedate->dates);
        foreach ($listedates as $value) {
            if($value != ""){
                $value = str_replace("/","-",$value);
                $event = new Google_Service_Calendar_Event(array(
                    'summary' => "Annonce ID : ".$valuedate['contrat']['annonce_id']." - Option : ".$valuedate['optionscontrat']['titre'],
                    'description' => "fgfg",
                    'start' => array(
                    'date' => (new Date($value))->i18nFormat('yyyy-MM-dd'),
                    'timeZone' => 'Europe/Paris',
                    ),
                    'end' => array(
                    'date' => (new Date($value))->i18nFormat('yyyy-MM-dd'),
                    'timeZone' => 'Europe/Paris',
                    ),
                    'recurrence' => array(
                    'RRULE:FREQ=YEARLY;COUNT=2'
                    ),
                ));
                $event = $service->events->insert($calendarId, $event);
            }
        }
      
    }

    /**
     * addnewcalendar method
     */
    public function addnewcalendar($nom_calendar=null)
    {
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);
        /** INSERT NEW CALENDAR **/
        $calendar = new Google_Service_Calendar_Calendar();
        $calendar->setSummary($nom_calendar);
        $calendar->setTimeZone(new DateTimeZone('Europe/Paris'));
        $createdCalendar = $service->calendars->insert($calendar);
        return $createdCalendar->getId();
    }
}
