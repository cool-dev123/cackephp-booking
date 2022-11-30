<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
		$this->set('mois_fr',array("","janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août",
        "septembre", "octobre", "novembre", "décembre"));
		$this->set('title_for_layout',"Location Les Arcs vacances été hiver de particulier à particulier");
    }
	/*
     *
     * Transforme une date format dd/mm/yyyy en tableau compatible cakePHP
     * Retourne vide si la date fournie en paramètre est vide
     * @param date au format dd/mm/yyyy
     * @result array[day][month][year]
     */
    public function toDate($str)
    {
        $result = [];

        if ($str != "" && $str != "0000-00-00") {
            $str = str_replace("-","/",$str);
            list($day, $month, $year) = explode("/",$str);

            if (!empty($day) && !empty($month) && !empty($year)) {
                $result = [
                    'day'   => $day,
                    'month' => $month,
                    'year'  => $year
                ];

				if ($result['year']< 25) $result['year']='20'.$result['year'];
				if ($result['year']< 1900) $result['year']='19'.$result['year'];
            }
        } else {
            $result = [
                "day"   => "",
                "month" => "",
                "year"  => ""
            ];
        }

        return $result;
    }
    /**
     * Change language
     */
    public function changelanguage($language=null)
    {
        $this->loadModel("Urlmultilingue");
        $urlmultilinguereturn = $this->Urlmultilingue->find('translations');

        $session = $this->request->session();
        $session->write('changelanguage', 'oui');
        if($language != null)
        {          
            $languagefind = $this->Languages->find("all")->where(['url_code' => $language]);
            if($languagefind = $languagefind->first()){
                $session->write('Config.language', $languagefind->code);
            }else{
                $session->write('Config.language', I18n::locale());
            }
            $newUrl = $this->referer();
            foreach ($urlmultilinguereturn as $urlmultilingueretu) {
                foreach ($urlmultilingueretu->_translations as $keyurl=>$valueurl) {
                    if($keyurl != $session->read('Config.language')){
                        if(strpos($newUrl, "/".$valueurl->name_value) !== FALSE && strpos($newUrl, "/".$valueurl->name_value."s-") === FALSE && strpos($newUrl, "/".$valueEn."-") === FALSE){
                            $newUrl = str_replace($valueurl->name_value,$urlmultilingueretu->_translations[$session->read('Config.language')]->name_value,$newUrl);
                        }
                        
                    }
                }
            }
            return $this->redirect($newUrl);
        }else{
            $session->write('Config.language', I18n::locale());
            $newUrl = $this->referer();
            foreach ($urlmultilinguereturn as $urlmultilingueretu) {
                foreach ($urlmultilingueretu->_translations as $keyurl=>$valueurl) {
                    if($keyurl != $session->read('Config.language')){
                        if(strpos($newUrl, "/".$valueurl->name_value) !== FALSE && strpos($newUrl, "/".$valueurl->name_value."s-") === FALSE && strpos($newUrl, "/".$valueEn."-") === FALSE){
                            $newUrl = str_replace($valueurl->name_value,$urlmultilingueretu->_translations[$session->read('Config.language')]->name_value,$newUrl);
                        }
                    }
                }
            }
            return $this->redirect($newUrl);
        }
    }
    /**
     * beforeFilter Function
     */
    public function beforeFilter(Event $event)
    {
        $this->loadModel("Languages");
        $session = $this->request->session();   
          
        // if($session->check('changelanguage') && $session->read('changelanguage') == "oui") {
            if($session->check('Config.language'))
            {
                I18n::setLocale($session->read('Config.language'));
            }
            else{
                if($this->request->getParam('language')){
                    $language = $this->Languages->find("all")->where(['url_code' => $this->request->getParam('language')]);
                    if($language = $language->first()){
                        I18n::setLocale($language->code);
                        $session->write('Config.language', $language->code);
                    }else{
                        $session->write('Config.language', I18n::locale());
                    }
                }else{
                    $session->write('Config.language', I18n::locale());
                }            
            }
        // }else{
        //     if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) == "fr"){
        //         I18n::setLocale("fr_FR");
        //         $session->write('Config.language', "fr_FR");
        //     }else{
        //         I18n::setLocale("en_US");
        //         $session->write('Config.language', "en_US"); 
        //     } 
        // }        
        
        $language_header_name = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();

        $this->loadModel("Urlmultilingue");
        $touslangue = $this->Urlmultilingue->find('translations')->where(['Urlmultilingue.id NOT IN (1,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33)']);
        $tableEnToFr = [];
        $tableFrToEn = [];
        foreach ($touslangue as $value) {
            $tableEnToFr[$value->_translations['en_US']->name_value] = $value->_translations['fr_FR']->name_value;
            $tableFrToEn[$value->_translations['fr_FR']->name_value] = $value->_translations['en_US']->name_value;
        }

        $touslangueSearch = $this->Urlmultilingue->find('translations')->where(['Urlmultilingue.id IN (1,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33)']);
        $tableEnToFrSearch = [];
        $tableFrToEnSearch = [];
        foreach ($touslangueSearch as $value) {
            $tableEnToFrSearch[$value->_translations['en_US']->name_value] = $value->_translations['fr_FR']->name_value;
            $tableFrToEnSearch[$value->_translations['fr_FR']->name_value] = $value->_translations['en_US']->name_value;
        }
        
        // Ajout condition liste url non traduit )
        $actionMultilingueAjax = array("calendarDispoLoc","uploadjustificatifdomicile","uploadnew","sitemap","getReservationLocataire","getReservationLocataireOld","getReservationProprietaire","prop","repondremessageprop","erreurconnexion","getresidence", "getvillefromvillage", "getarraypays", "ouvrircompteajax", "addajax", "inscriptionnewslettre", "renvoiemailconfirmation", "getnbmessage", "uploadnumberone", "deletefirst", "getId", "getservicesmap", "getdetailoffice", "calculertotalprixperiode", "chercherdisponibilite", "confirmreservations", "ajoutreservationpanier", "blockreduction", "getarrayregionfrance", "getarrayfrancevilles", "getarraypaysvilles", "getdetailfrancecodepostal", "chercherdisponibilitedatepicker", "getimage", "delAll", "iCalDecoder", "calculertotalprixperiodebyidreservation", "edit_reservation_locataire","editReservationLocataire", "addReservationComment", "deletereservation", "get_reservation_locataire", "annulations_locataire", "annulationsLocataire", "supprimertel", "chercherdisponibiliteTot", "getcontratinfo", "getuserinfos", "calendarAddResMan", "shownumber", "sendmessagefromreservation", "deletereservationlocatairejustif", "deletereservationlocataire", "editReservationProprietaire", "getdetailreservations", "activer", "reservations_locataire", "reservationsLocataire", "statistique", "annonce_delete", "annonceDelete", "delMessage", "getarraymessage", "addmessage", "reponsemessageprop", "getinfomessage", "setmessage", "calendarAdd", "calendarEdit", "supprimerCalend", "changearchived", "getchats", "changereadstatus", "editReservationDates", "uploadinventairelocataire", "calendarAddEarlyBooking", "calendarAddLastMinute", "calendarAddLongSejour");

        $actionMultilingueFormSubmit = ["calendarAddNew"];

        if(stripos($this->request->url, "manager") === false && !in_array($this->request->params["action"], $actionMultilingueAjax) && !in_array($this->request->params["action"], $actionMultilingueFormSubmit) && ($this->request->params["controller"] != "photos" && $this->request->params["action"] != "delete")){
            if($language_header_name->url_code != "fr" && !$this->request->getParam('language')){
                if((stripos($this->request->url, "/") > 2 || (stripos($this->request->url, "/") === false)) && stripos($this->request->url, "App/changelanguage") === false){
                    // Cas des urls Annonces/edit .... ou Recherche simplement
                    $newUrl = "/".$language_header_name->url_code."/".$this->request->url;
                    if($_SERVER['QUERY_STRING']) $newUrl .= "?".$_SERVER['QUERY_STRING'];
                    if($session->read('Config.language') == "fr_FR"){
                        if($this->request->params["action"] != "recherche"){
                            foreach ($tableEnToFr as $valueEn => $valueFr) {
                                if(strpos($newUrl, "/".$valueEn) !== FALSE && strpos($newUrl, "/".$valueEn."s-") === FALSE && strpos($newUrl, "/".$valueEn."-") === FALSE) {
                                    $newUrl = str_replace($valueEn,$valueFr,$newUrl);
                                } 
                            }
                        }else{
                            foreach ($tableEnToFrSearch as $valueEn => $valueFr) {
                                if(strpos($newUrl, $valueEn) !== FALSE) {
                                    $newUrl = str_replace($valueEn,$valueFr,$newUrl);
                                } 
                            }
                        }
                        
                    }else if($session->read('Config.language') == "en_US"){
                        if($this->request->params["action"] != "recherche"){
                            foreach ($tableFrToEn as $valueEn => $valueFr) {
                                if(strpos($newUrl, "/".$valueEn) !== FALSE && strpos($newUrl, "/".$valueEn."s-") === FALSE && strpos($newUrl, "/".$valueEn."-") === FALSE) {
                                    $newUrl = str_replace($valueEn,$valueFr,$newUrl);
                                }                    
                            }
                        }else{
                            foreach ($tableFrToEnSearch as $valueEn => $valueFr) {
                                if(strpos($newUrl, $valueEn) !== FALSE) {
                                    $newUrl = str_replace($valueEn,$valueFr,$newUrl);
                                }                    
                            }
                        }
                        
                    }
                    return $this->redirect($newUrl);
                }
            }
            if($this->request->getParam('language') && $this->request->getParam('language') != $language_header_name->url_code){
                if($language_header_name->url_code != "fr"){
                    $newUrl = "/".substr_replace($this->request->url, $language_header_name->url_code, 0, 2);
                }else{
                    $newUrl = "/".substr_replace($this->request->url, "/", 0, 2); 
                }
                $newUrl = str_replace(["///", "//"], "/", $newUrl);
                if($_SERVER['QUERY_STRING']) $newUrl .= "?".$_SERVER['QUERY_STRING'];
                if($session->read('Config.language') == "fr_FR"){
                    if($this->request->params["action"] != "recherche"){
                        foreach ($tableEnToFr as $valueEn => $valueFr) {
                            if(strpos($newUrl, "/".$valueEn) !== FALSE && strpos($newUrl, "/".$valueEn."s-") === FALSE && strpos($newUrl, "/".$valueEn."-") === FALSE) {
                                $newUrl = str_replace($valueEn,$valueFr,$newUrl);
                            } 
                        }
                    }else{
                        foreach ($tableEnToFrSearch as $valueEn => $valueFr) {
                            if(strpos($newUrl, $valueEn) !== FALSE) {
                                $newUrl = str_replace($valueEn,$valueFr,$newUrl);
                            } 
                        }
                    }
                    
                }else if($session->read('Config.language') == "en_US"){
                    if($this->request->params["action"] != "recherche"){
                        foreach ($tableFrToEn as $valueEn => $valueFr) {
                            if(strpos($newUrl, "/".$valueEn) !== FALSE && strpos($newUrl, "/".$valueEn."s-") === FALSE && strpos($newUrl, "/".$valueEn."-") === FALSE) {
                                $newUrl = str_replace($valueEn,$valueFr,$newUrl);
                            }                    
                        }
                    }else{
                        foreach ($tableFrToEnSearch as $valueEn => $valueFr) {
                            if(strpos($newUrl, $valueEn) !== FALSE) {
                                $newUrl = str_replace($valueEn,$valueFr,$newUrl);
                            }                    
                        }
                    }
                    
                }
                return $this->redirect($newUrl);
            }

            $newUrl = "/".$this->request->url;
            $existe = "non";
            if($session->read('Config.language') == "fr_FR"){
                if($this->request->params["action"] != "recherche"){
                    foreach ($tableEnToFr as $valueEn => $valueFr) {
                        if(strpos($newUrl, "/".$valueEn) !== FALSE && strpos($newUrl, "/".$valueEn."s-") === FALSE && strpos($newUrl, "/".$valueEn."-") === FALSE) {
                            $newUrl = str_replace($valueEn,$valueFr,$newUrl);
                            $existe = "oui";
                        }                    
                    }
                }else{
                    foreach ($tableEnToFrSearch as $valueEn => $valueFr) {
                        if(strpos($newUrl, $valueEn) !== FALSE) {
                            $newUrl = str_replace($valueEn,$valueFr,$newUrl);
                            $existe = "oui";
                        }                    
                    }
                }
                
            }else if($session->read('Config.language') == "en_US"){
                if($this->request->params["action"] != "recherche"){
                    foreach ($tableFrToEn as $valueEn => $valueFr) {
                        if(strpos($newUrl, "/".$valueEn) !== FALSE && strpos($newUrl, "/".$valueEn."s-") === FALSE && strpos($newUrl, "/".$valueEn."-") === FALSE) {
                            $newUrl = str_replace($valueEn,$valueFr,$newUrl);
                            $existe = "oui";
                        }                    
                    }
                }else{
                    foreach ($tableFrToEnSearch as $valueEn => $valueFr) {
                        if(strpos($newUrl, $valueEn) !== FALSE) {
                            $newUrl = str_replace($valueEn,$valueFr,$newUrl);
                            $existe = "oui";
                        }                    
                    }
                }
                
            }
            
            if($existe == "oui") return $this->redirect($newUrl);
        }  
                       

        $this->set('language_header_name',$language_header_name->url_code);
        $this->set('datatable_file',$language_header_name->datatable_file);

		$languages = $this->Languages->find("all");
		$this->set('languages',$languages);

        $this->loadModel("Media");
		$medialogo = $this->Media->find('translations', ['locales' => [$session->read('Config.language')]])->where(['name_key = "logo_alpissime"']);
		$this->set("medialogo",$medialogo->first());
        
        $mediacarremobile = $this->Media->find('translations', ['locales' => [$session->read('Config.language')]])->where(['name_key = "carre_menu_mobile"']);
		$this->set("mediacarremobile",$mediacarremobile->first());

        $mediapaiementmobile = $this->Media->find('translations', ['locales' => [$session->read('Config.language')]])->where(['name_key = "paiement_securise_mobile"']);
		$this->set("mediapaiementmobile",$mediapaiementmobile->first());

        $mediapaiementdesktop = $this->Media->find('translations', ['locales' => [$session->read('Config.language')]])->where(['name_key = "paiement_securise_desktop"']);
		$this->set("mediapaiementdesktop",$mediapaiementdesktop->first());

        $urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
        $urlvaluemulti = [];
        foreach ($urlmultilinguelistes as $urlmultilingueliste) {
            $urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
        }
        
        $this->set("urlvaluemulti",$urlvaluemulti);
    }

    /**
     * @return string
     */
    protected function getLanguage()
    {
        $session = $this->request->session();

        if ($session->read('Config.language') != "fr_FR") {
            $this->loadModel("Languages");
            $language_header_name = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();
            return $language_header_name->url_code . "/" ;
        }

        return "";
    }

    /**
     * @return array
     */
    protected function getUrlmulti()
    {
        $this->loadModel("Urlmultilingue");

        $session = $this->request->session();
        $urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
        $urlvaluemulti = [];
        foreach ($urlmultilinguelistes as $urlmultilingueliste) {
            $urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
        }

        return $urlvaluemulti;
    }
}
