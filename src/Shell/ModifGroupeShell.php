<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Log\Log;

/**
 * ModifGroupeShell shell command.
 */
class ModifGroupeShell extends Shell
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel("Utilisateurs");
        $this->loadModel("Contrats");
        $this->loadModel("Annonces");
        $this->loadModel("Photos");
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        Log::write('info', 'START ALL ModifGroupe FUNCTIONS');
        // $this->modifGroupProp();
        // $this->renameImageFiles();
        $this->listerLesNomImages();
        Log::write('info', 'END ALL ModifGroupe FUNCTIONS');
    }
    /**
     * 
     */
    public function modifGroupProp()
    {
        Log::write('info', 'Start Execute modifGroupProp Function');
        $listeProp = $this->Utilisateurs->find("all")->contain('Annonces')->where(['Utilisateurs.nature <> "CLT"']);
        foreach ($listeProp as $prop) {
            // Parcourir les annonces du propriétaire
            $withContrat = 0;
            foreach ($prop['annonces'] as $annonce) {
                if($annonce->contrat == 1){
                    $contrat = $this->Contrats->find()->where(['annonce_id' => $annonce->id]);
                    if($contrat->first()) $withContrat = 1;
                }
            }
            
            if($withContrat == 1){
                /* 7 Prop-contrat-conciergerie */
                $customerEmail = $prop->email;
                $groupId = "7";
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => BOUTIQUE_ALPISSIME."index.php/rest/all/V1/cakephp/updateCustomerGroup?customerEmail=".$customerEmail."&groupId=".$groupId."",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_HTTPHEADER => array("Content-Type: application/json"),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                Log::write('info', 'Le propriétaire '.$customerEmail.' Prop-contrat-conciergerie .');
            }else{
                /* 9 Prop-sans-contrat */
                $customerEmail = $prop->email;
                $groupId = "9";
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => BOUTIQUE_ALPISSIME."index.php/rest/all/V1/cakephp/updateCustomerGroup?customerEmail=".$customerEmail."&groupId=".$groupId."",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_HTTPHEADER => array("Content-Type: application/json"),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                Log::write('info', 'Le propriétaire '.$customerEmail.' Prop-sans-contrat .');
            }            
        }
        Log::write('info', 'End Execute modifGroupProp Function');
    }
    /**
     * 
     */
    public function renameImageFiles()
    {
        Log::write('info', 'Start Execute renameImageFiles Function');

        $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
        $prefixe = PATH_ALPISSIME;

        // Liste des annonces
        $liste_annonces = $this->Annonces->find('all');
        foreach ($liste_annonces as $value) {
            $annonce_id = $value->id; // A CHANGER
            $directory = $prefixe."webroot/images_ann/".$annonce_id."/"; 
            // $directory = "C:/xampp/htdocs/alpissime/webroot/images_ann/".$annonce_id."/";    
            // Open a directory, and read its contents
            if (is_dir($directory)){
                if ($opendirectory = opendir($directory)){
                    while (($file = readdir($opendirectory)) !== false){                      
                        if (strpos($file, ".G.jpg") !== false)
                        {
                            $annonce = $this->Annonces->find()->where(['Annonces.id' => $annonce_id])->contain(['Lieugeos', 'Villages']);
                            if($annonce = $annonce->first()){
                                $partie1 = explode('vignette-'.$annonce_id.'-',$file);
                                $partie2 = explode('.G.jpg',$partie1[1]);

                                $village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
                                $village_nom = str_replace(" – ", "-", $village_nom);
                                $village_nom = str_replace(" ", "-", $village_nom);
                                
                                $file2= "location-".$natureAnnURL[$annonce['nature']]."-".$village_nom."-".$annonce->personnes_nb."-personnes-".$annonce_id."-".$partie2[0]."-Alpissime.jpg";
                                rename($directory.$file, $directory.$file2);
                            }
                            
                        }
                        
                    }
                    closedir($opendirectory);
                }
            }
        }
        
        Log::write('info', 'End Execute renameImageFiles Function');
    }
    /**
     * 
     */
    public function listerLesNomImages()
    {
        Log::write('info', 'Start Execute listerLesNomImages Function');
        $prefixe = PATH_ALPISSIME;
        // Liste des annonces
        $liste_annonces = $this->Annonces->find('all');
        foreach ($liste_annonces as $value) {
            $annonce_id = $value->id; // A CHANGER
            $directory = $prefixe."webroot/images_ann/".$annonce_id."/"; 
            // $directory = "C:/xampp/htdocs/alpissime/webroot/images_ann/".$annonce_id."/";    
            // Open a directory, and read its contents
            if (is_dir($directory)){
                if ($opendirectory = opendir($directory)){
                    while (($file = readdir($opendirectory)) !== false){  
                        $tabnumber = array(1,2,3,4,5,6,7,8,9,10);
                        foreach ($tabnumber as $valuenumber) {
                            if (strpos($file, "-".$valuenumber."-Alpissime.jpg") !== false)
                            {
                                $photo = $this->Photos->find("all",array(
                                    "conditions"=>array(
                                        "Photos.annonce_id"=>$annonce_id,
                                        "Photos.numero"=>$valuenumber
                                    )
                                ));
                                if($photo = $photo->first()){
                                    $datatitre = array("titre" => $file);
                                    $photo = $this->Photos->patchEntity($photo, $datatitre);
                                    $this->Photos->save($photo);
                                }
                            }
                        }                        
                        
                    }
                    closedir($opendirectory);
                }
            }
        }
        Log::write('info', 'End Execute listerLesNomImages Function');
    }
}
