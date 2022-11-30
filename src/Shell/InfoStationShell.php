<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Http\Client;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Log\Log;
use Cake\Utility\Xml;
use App\Controller\GoogleCalendarController;

class InfoStationShell extends Shell
{
    private $http;
    public function initialize()
    {
        parent::initialize();
        $this->http = new Client();
        $this->loadModel("Massif");
        $this->loadModel("Lieugeos");
        $this->loadModel("Stations");
        $this->loadModel("WebcamLieugeos");        
        $this->loadModel("OfficeTourisme");        
        $this->loadModel("Villages");        
        $this->loadModel("Annonces");    
        $this->loadModel("Residences");    
        $this->loadModel("Frvilles");    
        $this->loadModel("Annoncegestionniares");    
    }
    
    public function main()
    {
        Log::write('info', 'START testUrls FUNCTION');
        /** Fonction API **/
        // $this->infoStation();
        // $this->infoStationAnglais();
        // $this->webcamStation();
        /** Fonction Base de données **/
        // $this->stationVillage();
        // $this->renommerVillage();
        // $this->rassemblerVillage();
        // $this->adapterStation();
        // $this->addNewVillage();
        // $this->correctionAnciennesAnnonces();
        // $this->correctionVillagesVide();
        Log::write('info', 'END testUrls FUNCTION');
    }
        
    private function infoStation()
    {
        // IL FAUT PRENDRE EN COMPTE S IL Y A DES CHAMPS MODOFIE SUR ESPACE MANAGER (RECUPERER SEULEMENT OUVERTURE/FERMETURE)
        
        $response = $this->http->get("http://wcf.tourinsoft.com/Syndication/3.0/anmsm/944a9785-d239-41c2-81bb-ef0b27516198/Objects");
        $body = str_replace('&#x0', '', $response->body());
        $xml = Xml::build($body);        
        foreach($xml as $entry){
            if($entry->content->count() > 0){
                $nom = $entry->content->children('m', true)->children('d', true)->NOMSTATION;                
                $nom_massif = $entry->content->children('m', true)->children('d', true)->MASSIF;
                $latitude = $entry->content->children('m', true)->children('d', true)->LATITUDE;
                $longitude = $entry->content->children('m', true)->children('d', true)->LONGITUDE;
                $altbas = $entry->content->children('m', true)->children('d', true)->ALTBAS;
                $althaut = $entry->content->children('m', true)->children('d', true)->ALTHAUT;
                $description_api = $entry->content->children('m', true)->children('d', true)->ACCROCHE;
                $description_ete = $entry->content->children('m', true)->children('d', true)->DESCETEFR;
                $description_act_ete = $entry->content->children('m', true)->children('d', true)->DESCACTFR;
                $description_hiver = $entry->content->children('m', true)->children('d', true)->DESCHIVERFR;
                $description_act_hiver = $entry->content->children('m', true)->children('d', true)->DESCACTHIVERFR;
                // $description_acc = $entry->content->children('m', true)->children('d', true)->DESCACCHFR; // Plus besoin de mise à jour
                $plan_piste_api = $entry->content->children('m', true)->children('d', true)->PLANPISTESTRACK;
                $galery = $entry->content->children('m', true)->children('d', true)->PHOTOS;
                
                if((string)$plan_piste_api != ""){
                    $decoupe1 = explode('href="', (string)$plan_piste_api);
                    $decoupe2 = explode('"', $decoupe1[1]);
                    $plan_piste = $decoupe2[0];
                } else {
                    $plan_piste = "";
                } 

                $galery_liste = "";
                if((string)$galery != ""){                    
                    $decoupe1 = explode('||', (string)$galery);
                    foreach ($decoupe1 as $value) {
                        if (preg_match('/(\.jpg|\.jpeg|\.png)$/i', $value)) {
                            $galery_liste .= $value.";";
                        }
                    }
                }

                // $nom_office = $entry->content->children('m', true)->children('d', true)->NOMOT;
                // $adresse_office = $entry->content->children('m', true)->children('d', true)->ADRESSEOT;
                // $site_office_api = $entry->content->children('m', true)->children('d', true)->WEBOTTRACK;
                // if((string)$site_office_api != ""){
                //     $decoupe1office = explode('href="', (string)$site_office_api);
                //     $decoupe2office = explode('"', $decoupe1office[1]);
                //     $site_office = $decoupe2office[0];
                // } else {
                //     $site_office = "";
                // }
                
                // $tel_office = $entry->content->children('m', true)->children('d', true)->TELOT;
                // $codepostal_office = $entry->content->children('m', true)->children('d', true)->CPOT;

                /*** INSERTION MASSIF ***/
                $massif = $this->Massif->find()->where(['nom_api' => (string)$nom_massif]);                
                if(!$massif->first()){
                    $massif_data=array('nom' => (string)$nom_massif, 'nom_api' => (string)$nom_massif, 'from_api' => 1);
                    $new_massif = $this->Massif->newEntity($massif_data);
                    $result = $this->Massif->save($new_massif);
                    $id_massif = $result->id;
                }else{
                    $id_massif = $massif->first()->id;
                }
                /*** FIN INSERTION MASSIF ***/
                /*** INSERTION OU MODIFICATION STATION ***/
                $station = $this->Lieugeos->find()->where(['nom_api' => ucfirst(strtolower((string)$nom))]);
                $station_data=array('nom_api' => ucfirst(strtolower((string)$nom)),'niveau' => 3, 'massif_id' => $id_massif, 'latitude' => (float)$latitude, 'longitude' => (float)$longitude, 'ALT_BAS' => (float)$altbas, 'ALT_HAUT' => (float)$althaut,
                'description_api' => (string)$description_api, 'description_ete' => (string)$description_ete, 'description_act_ete' => (string)$description_act_ete, 'description_hiver' => (string)$description_hiver, 'description_act_hiver' => (string)$description_act_hiver, 'plan_piste' => (string)$plan_piste, 'from_api' => 1, 'galery' => $galery_liste);
                if(!$station->first()){
                    $new_station = $this->Lieugeos->newEntity($station_data);
                    $new_station->name = ucfirst(strtolower((string)$nom));
                    $result_station = $this->Lieugeos->save($new_station);
                }else{
                    $update_station = $this->Lieugeos->patchEntity($station->first(), $station_data);
                    $result_station = $this->Lieugeos->save($update_station);
                }            
                /*** FIN INSERTION OU MODIFICATION STATION ***/
                /*** AJOUT OUVERT/FERM STATION ***/
                $ouver_station = $entry->content->children('m', true)->children('d', true)->OUVPART; 
                $ferm_station = $entry->content->children('m', true)->children('d', true)->FERMPART;
                if((string)$ouver_station != "" && (string)$ferm_station != ""){
                    $date_ouvert = explode("/", (string)$ouver_station);
                    $dateOuvert = $date_ouvert[2]."-".$date_ouvert[1]."-".$date_ouvert[0];

                    $date_fermeture = explode("/", (string)$ferm_station);
                    $dateFermeture = $date_fermeture[2]."-".$date_fermeture[1]."-".$date_fermeture[0];

                    $date_station = $this->Stations->find()->where(["station_id" =>$result_station->id]);
                    if(!$date_station->first()){
                        $date_station_data=array("ouverture" => (new Time($dateOuvert)), "fermeture" => (new Time($dateFermeture)), "station_id" =>$result_station->id);
                        $new_date_station = $this->Stations->newEntity($date_station_data);
                        $this->Stations->save($new_date_station); 
                    }else{
                        $date_station_data=array("ouverture" => (new Time($dateOuvert)), "fermeture" => (new Time($dateFermeture)));
                        $new_date_station = $this->Stations->patchEntity($date_station->first(),$date_station_data);
                        $this->Stations->save($new_date_station); 
                    }
                }            
                /*** FIN AJOUT OUVERT/FERM STATION ***/
                /*** INSERTION OFFICE DE TOURISME ***/
                // $office = $this->OfficeTourisme->find()->where(['nom' => (string)$nom_office]);
                // if(!$office->first()){
                //     $office_data=array('nom' => (string)$nom_office, 'adresse'=>(string)$adresse_office, 'code_postal'=>(string)$codepostal_office, 'portable'=>(string)$tel_office, 'lien'=>(string)$site_office);
                //     $new_office = $this->OfficeTourisme->newEntity($office_data);
                //     $resultoffice = $this->OfficeTourisme->save($new_office);
                // }
                /** Il y a des Champs obligatoires dans la base de données qui n'exsite pas dans API **/
                /*** FIN INSERTION OFFICE DE TOURISME ***/
            }
            
        }
                
    }
    /**
     * 
     */
    private function infoStationAnglais()
    {
        $response = $this->http->get("http://wcf.tourinsoft.com/Syndication/3.0/anmsm/944a9785-d239-41c2-81bb-ef0b27516198/Objects");
        $body = str_replace('&#x0', '', $response->body());
        $xml = Xml::build($body);        
        foreach($xml as $entry){
            if($entry->content->count() > 0){

                $nom = $entry->content->children('m', true)->children('d', true)->NOMSTATION;                
                $description_ete = $entry->content->children('m', true)->children('d', true)->DESCETEGB;
                $description_act_ete = $entry->content->children('m', true)->children('d', true)->DESCACTGB;
                $description_hiver = $entry->content->children('m', true)->children('d', true)->DESCHIVERGB;
                $description_act_hiver = $entry->content->children('m', true)->children('d', true)->DESCACTHIVERGB;
                $description_acc = $entry->content->children('m', true)->children('d', true)->DESCACCHGB; // Plus besoin de mise à jour
                
                /*** INSERTION OU MODIFICATION STATION ***/
                $station = $this->Lieugeos->find()->where(['nom_api' => ucfirst(strtolower((string)$nom))]);
                if($Lieugeo = $station->first()){
                    // Enregistrer En_US version
                    $translations = [
                        'en_US' => [
                            'description_ete' => (string)$description_ete, 
                            'description_act_ete' => (string)$description_act_ete, 
                            'description_hiver' => (string)$description_hiver, 
                            'description_act_hiver' => (string)$description_act_hiver, 
                            'description_acc' => (string)$description_acc
                        ]
                    ];			
                    foreach ($translations as $lang => $data) {
                        $Lieugeo->translation($lang)->set($data, ['guard' => false]);
                    }			
                    $this->Lieugeos->save($Lieugeo);
                }           
                /*** FIN INSERTION OU MODIFICATION STATION ***/
            }
            
        } 
    }
    /**
     * 
     */
    private function webcamStation()
    {
        $response = $this->http->get("http://wcf.tourinsoft.com/Syndication/3.0/anmsm/ed7f2fa6-9726-414f-b304-b400225331e8/Objects");
        $xml = $response->xml;        
        foreach($xml as $entry){

            if($entry->content->count() > 0){
                $webcams = $entry->content->children('m', true)->children('d', true)->WEBCAM;
                $stationLat = $entry->content->children('m', true)->children('d', true)->GmapLatitude;
                $stationLong = $entry->content->children('m', true)->children('d', true)->GmapLongitude;
    
                /*** INSERTION WEBCAM ***/            
                $listeWebcam = explode("##", (string)$webcams);
                foreach ($listeWebcam as $value) {
                    $listeWebcamOui = explode("||||", $value);
                    foreach ($listeWebcamOui as $key){
                        if(strpos($key, '||') !== FALSE){
                            $exportURL = explode("||", $key);
                            $nom = $exportURL[0];
                            $URLwebcam = $exportURL[sizeof($exportURL)-1];
                            if(strpos($URLwebcam, '.jpg') === FALSE){
                                $station = $this->Lieugeos->find()->where(['latitude' => (float)$stationLat, 'longitude' => (float)$stationLong])->first();
                                $urlInBase = $this->WebcamLieugeos->find()->where(['url' => (string)$URLwebcam, 'lieugeo_id' => $station->id])->first();
                                if(!$urlInBase){
                                    $new_url_data=array("nom" => (string)$nom, "url" => (string)$URLwebcam, "etat" => 1, "lieugeo_id" => $station->id);
                                    $new_date_url = $this->WebcamLieugeos->newEntity($new_url_data);
                                    $this->WebcamLieugeos->save($new_date_url); 
                                }
                            }
                        }
                    }
                    
                }
                
                /*** FIN INSERTION WEBCAM ***/
            }
            
        }
    } 
    /**
     * 
     */  
    public function stationVillage()
    {
        $village_station_tab = array(
            'arc 1600'=>'Les arcs bourg st maurice',
            'arc 2000'=>'Les arcs bourg st maurice',
            'bourg saint maurice'=>'Les arcs bourg st maurice',
            'les alpages du chantel'=>'Les arcs bourg st maurice',
            'arc 1950'=>'Les arcs bourg st maurice',
            'courbaton'=>'Les arcs bourg st maurice',
            'le charvet'=>'Les arcs bourg st maurice',
            'charmettoger'=>'Les arcs bourg st maurice',
            'les villards'=>'Les arcs bourg st maurice',
            'arc 1800'=>'Les arcs bourg st maurice',

            // 'vallandry'=>'Peisey vallandry',
            'Vallandry'=>'Peisey vallandry',
            'la maitaz'=>'Peisey vallandry',
            'Peisey'=>'Peisey vallandry',
            'Nancroix'=>'Peisey vallandry',
            'Plan Peisey'=>'Peisey vallandry',

            'La Foux - La Foux'=>'Val d\'allos',
            'Le Seignus - Centre Station'=>'Val d\'allos',
            'Le Seignus - Le Seignus bas'=>'Val d\'allos',
            'Le village - Centre Village'=>'Val d\'allos',
            'Le village - Le village'=>'Val d\'allos',
            'Le Seignus - Le Seignus Haut'=>'Val d\'allos',
            'Le Haut Verdon'=>'Val d\'allos',

            'Montchavin'=>'Montchavin la plagne',
            'Les Coches'=>'Montchavin la plagne',              
        );

        foreach ($village_station_tab as $village_name => $station_name) {
            $village = $this->Villages->find("all")->where(['name' => $village_name])->first();
            $newStation = $this->Lieugeos->find('all')->where(['nom_api' => $station_name])->first();
    
            // Attribuer village à la bonne station
            $village_data = array('lieugeo_id' => $newStation->id);
            $update_village = $this->Villages->patchEntity($village, $village_data);
            $this->Villages->save($update_village);
    
            // Attribuer station à l'annonce suivant l'id village
            $listeAnnonce = $this->Annonces->find('all')->where(['village' => $village->id]);
            foreach ($listeAnnonce as $annonce) {
                $annonce_data = array('lieugeo_id' => $newStation->id);
                $update_annonce = $this->Annonces->patchEntity($annonce, $annonce_data);
                $this->Annonces->save($update_annonce);
            }
        }
        
    } 
    /**
     * 
     */
    public function renommerVillage()
    {
        $village_new_name = array(
            'arc 1600'=>'Arc 1600 – Station',
            'arc 2000'=>'Arc 2000',
            'bourg saint maurice'=>'Bourg Saint-Maurice',
            'les alpages du chantel'=>'Arc 1800 – Alpages du Chantel',
            'arc 1950'=>'Arc 1950',
            'courbaton'=>'Arc 1600 – Courbaton',
            'le charvet'=>'Arc 1800 – Charvet',
            'charmettoger'=>'Arc 1800 – Charmettoger',
            'les villards'=>'Arc 1800 – Villards',
            // 'arc 1800'=>'', /** A supprimer **/

            // 'vallandry'=>'', /** A rassembler **/
            // 'Vallandry'=>'', /** A rassembler **/
            'la maitaz'=>'La Maïtaz',

            'La Foux - La Foux'=>'Val d\'Allos – La Foux',
            'Le Seignus - Centre Station'=>'Val d\'Allos – Le Seignus',
            // 'Le Seignus - Le Seignus bas'=>'', /** A rassembler **/
            // 'Le Seignus - Le Seignus Haut'=>'', /** A rassembler **/
            'Le village - Centre Village'=>'Val d\'Allos – Le Village',
            // 'Le village - Le village'=>'', /** A rassembler **/            
            'Le Haut Verdon'=>'Val d\'Allos – Le Haut Verdon', 
        );

        foreach ($village_new_name as $old_name => $new_name) {
            $village = $this->Villages->find("all")->where(['name' => $old_name])->first();
            $village_data = array('name' => $new_name);
            $update_village = $this->Villages->patchEntity($village, $village_data);
            $this->Villages->save($update_village);
        }
    }
    /**
     * 
     */
    public function rassemblerVillage()
    {
        $village_liste = array(
            // 'vallandry'=>'Vallandry',

            'Le Seignus - Le Seignus bas'=>'Val d\'Allos – Le Seignus', 
            'Le Seignus - Le Seignus Haut'=>'Val d\'Allos – Le Seignus', 

            'Le village - Le village'=>'Val d\'Allos – Le Village',
        );

        foreach ($village_liste as $old_village => $new_rassemblage) {
            $old_village = $this->Villages->find("all")->where(['name' => $old_village])->first();
            $new_village = $this->Villages->find("all")->where(['name' => $new_rassemblage])->first();

            // on cherche les annonces avec les anciens villages à rassembler
            $listeAnnonce = $this->Annonces->find('all')->where(['village' => $old_village->id]);
            foreach ($listeAnnonce as $annonce) {
                $annonce_data = array('village' => $new_village->id);
                $update_annonce = $this->Annonces->patchEntity($annonce, $annonce_data);
                $this->Annonces->save($update_annonce);
            }

            // on cherche residences pour modifier id_village
            $listeResidences = $this->Residences->find('all')->where(['id_village' => $old_village->id]);
            foreach ($listeResidences as $key => $residence) {
                $residence_data = array('id_village' => $new_village->id);
                $update_residence = $this->Residences->patchEntity($residence, $residence_data);
                $this->Residences->save($update_residence);
            }
        }
    }
    /**
     * 
     */
    public function adapterStation()
    {
        $station_liste = array(
            'Arcs 1950'=>'Les arcs bourg st maurice',
            'Arcs 2000'=>'Les arcs bourg st maurice',
            'Bourg St Maurice'=>'Les arcs bourg st maurice',
            'Station des Arcs'=>'Les arcs bourg st maurice',
            'Regions de montagne'=>'Les arcs bourg st maurice',
            'Arcs 1800 (Chantel)'=>'Les arcs bourg st maurice',
            'Arcs 1800 (Charvet)'=>'Les arcs bourg st maurice',
            'Arcs 1800 (Charmettoger)'=>'Les arcs bourg st maurice',
            'Arcs 1800 (Les Villards)'=>'Les arcs bourg st maurice',
            'Arcs 1800'=>'Les arcs bourg st maurice',
            'Arcs 1600'=>'Les arcs bourg st maurice',

            'Vallandry'=>'Peisey vallandry',
            
            'Val d\'Allos - La Foux'=>'Val d\'allos',
            'Val d\'Allos - Le Seignus'=>'Val d\'allos',
            'Val d’Allos - Le Village'=>'Val d\'allos',
            'Val d\'Allos - Le Haut verdon'=>'Val d\'allos',

            'Montchavin'=>'Montchavin la plagne',
            'Les Coches'=>'Montchavin la plagne'            
        );

        foreach ($station_liste as $old_station => $new_station) {
            $oldStation = $this->Lieugeos->find('all')->where(['name' => $old_station])->first();
            $newStation = $this->Lieugeos->find('all')->where(['nom_api' => $new_station])->first();
            
            // // update info new station
            // $new_station_data = array('input_boutique' => $oldStation->query);
            // $update_new_station = $this->Lieugeos->patchEntity($newStation, $new_station_data);
            // $this->Lieugeos->save($update_new_station);

            // update info old station
            $old_station_data = array('niveau' => 1);
            $update_old_station = $this->Lieugeos->patchEntity($oldStation, $old_station_data);
            $this->Lieugeos->save($update_old_station);

            // update ouverture/fermeture station_id
            $liste_date = $this->Stations->find('all')->where(['station_id' => $oldStation->id]);
            foreach ($liste_date as $dateStation) {
                $station_data = array('station_id' => $newStation->id);
                $update_station = $this->Stations->patchEntity($dateStation, $station_data);
                $this->Stations->save($update_station);
            }
        }
    }
    /**
     * 
     */
    public function addNewVillage()
    {
        $new_stations = array(
            ['name' => 'Pra Loup', 'massif_id' => 'Alpes du Sud', 'latitude' => 44.3701507, 'longitude' => 6.6025028, 'ALT_BAS' => 1500, 'ALT_HAUT' => 2600]
        );
        $new_village_praloup = array(
            ['id_ville' => 4226, 'id_bureau' => 0, 'name' => 'Pra Loup 1600', 'lieugeo_id' => 'Pra Loup'],
            ['id_ville' => 4226, 'id_bureau' => 0, 'name' => 'Pra Loup - Molane', 'lieugeo_id' => 'Pra Loup']
        );

        // Add Pra Loup station et ses village
        foreach ($new_stations as $station) {
            $massif = $this->Massif->find('all')->where(['nom_api' => $station['massif_id']])->first();
            $station['massif_id'] = $massif->id;
            $new_station_enter = $this->Lieugeos->newEntity($station);
            $this->Lieugeos->save($new_station_enter); 

            foreach ($new_village_praloup as $village_praloup) {
                $ville = $this->Frvilles->find('all')->where(['code_insee' => $village_praloup['id_ville']])->first();
                $station_result_praloup = $this->Lieugeos->find('all')->where(['name' => $village_praloup['lieugeo_id']])->first();
                $village_praloup['id_ville'] = $ville->id;
                $village_praloup['lieugeo_id'] = $station_result_praloup->id;
                $new_village_enter = $this->Villages->newEntity($village_praloup);
                $this->Villages->save($new_village_enter); 
            }
        }

        $new_villages = array(
            ['id_ville' => 73142, 'id_bureau' => 0, 'name' => 'Landry', 'lieugeo_id' => 'Peisey vallandry'],

            ['id_ville' => 73006, 'id_bureau' => 0, 'name' => 'Plagne Vallée', 'lieugeo_id' => 'La plagne'],
            ['id_ville' => 73006, 'id_bureau' => 0, 'name' => 'Plagne 1800', 'lieugeo_id' => 'La plagne'],
            ['id_ville' => 73006, 'id_bureau' => 0, 'name' => 'Plagne Montalbert', 'lieugeo_id' => 'La plagne'],
            ['id_ville' => 73006, 'id_bureau' => 0, 'name' => 'Aime 2000', 'lieugeo_id' => 'La plagne'],
            ['id_ville' => 73006, 'id_bureau' => 0, 'name' => 'Plagne Centre', 'lieugeo_id' => 'La plagne'],
            ['id_ville' => 73006, 'id_bureau' => 0, 'name' => 'Plagne Bellecôte', 'lieugeo_id' => 'La plagne'],
            ['id_ville' => 73006, 'id_bureau' => 0, 'name' => 'Belle Plagne', 'lieugeo_id' => 'La plagne'],
            ['id_ville' => 73006, 'id_bureau' => 0, 'name' => 'Plagne Soleil', 'lieugeo_id' => 'La plagne'],
            ['id_ville' => 73006, 'id_bureau' => 0, 'name' => 'Plagne Villages', 'lieugeo_id' => 'La plagne'],

            ['id_ville' => 73071, 'id_bureau' => 0, 'name' => 'Champagny en Vanoise', 'lieugeo_id' => 'Champagny en vanoise'],

            ['id_ville' => 73054, 'id_bureau' => 0, 'name' => 'Arc 1800 – Chantel', 'lieugeo_id' => 'Les arcs bourg st maurice'],
            
        );

        foreach ($new_villages as $key => $village_info) {
            $ville = $this->Frvilles->find('all')->where(['code_insee' => $village_info['id_ville']])->first();
            $station_result = $this->Lieugeos->find('all')->where(['nom_api' => $village_info['lieugeo_id']])->first();
            $village_info['id_ville'] = $ville->id;
            $village_info['lieugeo_id'] = $station_result->id;
            $new_village_enter = $this->Villages->newEntity($village_info);
            $this->Villages->save($new_village_enter); 
        }
    }
    /**
     * 
     */
    public function replaceTableannoncegestionniares()
    {
        $listeAnnGest = $this->Annoncegestionniares->find('all');
        foreach ($listeAnnGest as $annGest) {
            $annonceID = $this->Annonces->find()->where(['id' => $annGest->id_annonces]);
            if($annonce = $annonceID->first()){
                $data = array('position_cle' => $annGest->position_cle, 'visible' => $annGest->visible, 'id_gestionnaires' => $annGest->id_gestionnaires);
                $update_annonce = $this->Annonces->patchEntity($annonce, $data);
                $this->Annonces->save($update_annonce);
            }
        }
    }
    /**
     * 
     */
    public function correctionAnciennesAnnonces()
    {
        $listeAnnonce = $this->Annonces->find('all')->where(['Annonces.statut = 50', 'Annonces.lieugeo_id < 21']);
        foreach ($listeAnnonce as $annonce) {
            $residence = $this->Residences->find('all')->contain(['Villages'])->where(['Residences.id' => $annonce->batiment]);
            if($residence->first()){
                $residence = $residence->first();
                $data = array('lieugeo_id' => $residence['village']['lieugeo_id'], 'village' => $residence->id_village);
                $update_annonce = $this->Annonces->patchEntity($annonce, $data);
                $this->Annonces->save($update_annonce);
            }
            
            // print_r($residence->first());
        }
        // print_r($listeAnnonce->count());
    }
    /**
     * 
     */
    public function correctionVillagesVide()
    {
        $listeAnnonce = $this->Annonces->find('all')->where(['Annonces.statut = 50', 'Annonces.village IS NULL']);
        foreach ($listeAnnonce as $annonce) {
            $residence = $this->Residences->find('all')->contain(['Villages'])->where(['Residences.id' => $annonce->batiment]);
            if($residence->first()){
                $residence = $residence->first();
                $data = array('lieugeo_id' => $residence['village']['lieugeo_id']);
                $annonce->village = $residence->id_village;
                $update_annonce = $this->Annonces->patchEntity($annonce, $data);
                $this->Annonces->save($update_annonce);
                // print_r($data);
            }
            
            // print_r($residence->first());
        } 
    }
        

}
?>

