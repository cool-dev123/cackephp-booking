<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Log\Log;
use App\Controller\GoogleSheetsController;

/**
 * FunctionsGoogleSheetCatalogue shell command.
 */
class FunctionsGoogleSheetCatalogueShell extends Shell
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel("Annonces");
        $this->loadModel("Photos");
        $this->loadModel("Frvilles");
        $this->loadModel("Residences");
        $this->loadModel("Dispos");
        $this->loadModel("Departements");
        $this->loadModel("Feedbacks");
        
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        Log::write('info', 'START ALL FunctionsGoogleSheetCatalogue FUNCTIONS');
        $this->getGoogleSheets();
        Log::write('info', 'END ALL FunctionsGoogleSheetCatalogue FUNCTIONS');
    }

    /**
     * 
     */
    public function getGoogleSheets()
    {
        // Nouvelle Entete
        // $row = ["hotel_id", "name", "image[0].url", "image[0].tag", "url", "address.addr1",	"address.city",	"address.region", "address.country", "neighborhood[0]", "latitude", "longitude", "brand", "base_price", "star_rating", "description"];  
        // $googleSheet = new GoogleSheetsController();
        // $event_id = $googleSheet->googleSheetInsertRow($row, 1);


        // Liste des annonces valide sur alpissime
        $annonces = $this->Annonces->find('all')->contain(['Lieugeos','Villages'])->where(["Annonces.statut"=>"50", "Annonces.google_sheet = 0"])->order(['Annonces.id DESC'])->limit(60);
        if($annonces->count() != 0){
            $derniereAnnonce = $this->Annonces->find('all')->where(["Annonces.statut"=>"50"])->order(['Annonces.google_sheet_line DESC'])->first();
            $num_ligne = $derniereAnnonce->google_sheet_line + 1;
            foreach ($annonces as $annonce) {
                try {
                // Image URL
                $photo = $this->Photos->find()->where(['annonce_id' => $annonce->id])->order(['numero ASC'])->first();
                $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
                $village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
                $village_nom = str_replace(" – ", "-", $village_nom);
                $village_nom = str_replace(" ", "-", $village_nom);
                $nomImgG = $photo->titre;
                $urlimage1 = 'https://www.alpissime.com/images_ann/'.$annonce->id.'/'.$nomImgG;

                // Annonce titre
                $annoncetitre = $this->stringFormat($annonce->titre);

                // Adresse (street) => Nom du bâtiment + station
                $batiment = $this->Residences->find()->where(['id' => $annonce->batiment]);
                if($batiment = $batiment->first()){
                    $batimentName = $batiment->name;
                    $latitude = $batiment->latitude;
                    $longitude = $batiment->longitude;
                }else{
                    $batimentName = "";
                    $latitude = "";
                    $longitude = "";
                } 
                $adresseStreet = $batimentName." ".$annonce['lieugeo']['name'];

                // Nom ville de l'annonce
                if($annonce->pays==67&&$annonce->pays>0){
                    $ville = $this->Frvilles->get($annonce->ville);
                    $villeName = $ville->name;
                    $codePostal = $ville->code_postal;
                    $region = $this->Departements->find("all")->where(['id' => $annonce->region]);
                    if($region = $region->first()) $regionName = $region->name;
                    else $regionName = "";
                }else{
                    $villeName = "";
                    $codePostal = "";
                    $regionName = "";
                }

                // Annonce URL
                $lannonce = strtolower(str_replace(" ","-",$annoncetitre));
                $hrefDetailAnn0 = 'https://www.alpissime.com/station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;
                $hrefDetailAnn1 = str_replace("----","-",$hrefDetailAnn0);
                $hrefDetailAnn2 = str_replace("---","-",$hrefDetailAnn1);
                $hrefDetailAnn = str_replace("--","-",$hrefDetailAnn2);

                // Prix le plus bas
                $minprixannonce = '';
                $condi = ["Annonces.statut"=>"50", "Annonces.lieugeo_id = "=>$annonce->lieugeo_id, "Annonces.nature = "=>$annonce->nature, "Annonces.personnes_nb >= "=>$annonce->personnes_nb];
                if($da_debut != '' && $da_fin != '') $tousperiodes = $this->Dispos->chercherdisponibilite($annonce->id, '', '', $condi);
                else $tousperiodes = $this->Dispos->find('all', array(
                                'conditions' => array('Dispos.annonce_id' => $annonce->id, 'Dispos.fin_at > NOW()', 'Dispos.statut <> 90'),
                                'fields' => array('Dispos.prix','Dispos.fin_at','Dispos.dbt_at','Dispos.prix_jour','Dispos.promo_px','Dispos.promo_jour','Dispos.promo_yn')));

                foreach ($tousperiodes as $value) {
                    if (!empty(str_replace(array("0", "-", ":", " "), "", $value->fin_at)) && !empty(str_replace(array("0", "-", ":", " "), "", $value->dbt_at))){
                        if($value->prix_jour == 0){
                            $nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
                            $prix_jour = $value->prix/$nbrDiff;
                        }else{
                            $prix_jour = $value->prix_jour;
                        }

                        if($value->promo_yn == 0){
                            if($minprixannonce == '' || $prix_jour < $minprixannonce){
                                    $minprixannonce = round($prix_jour, 2);
                            }
                        }else{
                            if($value->promo_jour == 0){
                                    $nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
                                    $promo_jour = $value->promo_px/$nbrDiff;
                            }else{
                                    $promo_jour = $value->promo_jour;
                            }
                            if($promo_jour < $prix_jour){
                                    if($minprixannonce == '' || $promo_jour < $minprixannonce ) $minprixannonce = round($promo_jour, 2);
                            }else{
                                    if($minprixannonce == '' || $prix_jour < $minprixannonce ) $minprixannonce = round($prix_jour, 2);
                            }
                        }
                    }
                } /** Fin parcour periodes **/
                if($minprixannonce == '') $minprixannonce = "0";

                // star_rating
                $listerating = $this->Feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$annonce->id, "activated = 1"]);
                // Notes Globales
                $notecara = [];
                foreach ($listerating as $keyval) {
                    foreach ($keyval['ratings'] as $valueval) {
                            $notecara[$valueval->caracteristique] += $valueval->note;
                    }
                }

                if($listerating->count() != 0){
                    $noteglobalmoy = ($notecara['emplacement']/$listerating->count())+($notecara['confort']/$listerating->count())+($notecara['qualiteprix']/$listerating->count());
                    $noteglobalmoytab = round(($noteglobalmoy/3), 1);
                }else{
                    $noteglobalmoy = 0;
                    $noteglobalmoytab = "";
                }
                if($noteglobalmoytab != ""){
                    $output = round($noteglobalmoytab / 0.5);
                    $noteglobalmoytab = $output * 0.5;
                }
                $noteglobalmoytab = str_replace(",",".",$noteglobalmoytab);



                if($latitude != "" && $longitude != "" && $latitude != 0 && $longitude != 0 && $villeName != "" && $codePostal != "" && $regionName != ""){
                    $row = [$annonce->id, ucfirst(strtolower($annoncetitre)), $urlimage1, "['Overview']", $hrefDetailAnn, $codePostal,	$villeName,	$regionName, "FRANCE", $annonce['lieugeo']['name'], $latitude, $longitude, "Alpissime.com", $minprixannonce.' EUR', $noteglobalmoytab, substr(str_ireplace(array("\r","\n",'\r','\n'),' ', $annonce->description), 0, 4999)];                   
                    $googleSheet = new GoogleSheetsController();
                    $event_id = $googleSheet->googleSheetInsertRow($row, $num_ligne);
                    $queryAnnonce = $this->Annonces->query();
                    $queryAnnonce->update()
                        ->set(['google_sheet' => 1, 'google_sheet_line' => $num_ligne])
                        ->where(['id' => $annonce->id])
                        ->execute();
                    $num_ligne++;
                    Log::write('info', json_encode([$annonce->id, ucfirst(strtolower($annoncetitre)), $urlimage1, "['Overview']", $hrefDetailAnn, $codePostal,	$villeName,	$regionName, "FRANCE", $annonce['lieugeo']['name'], $latitude, $longitude, "Alpissime.com", $minprixannonce.' EUR', $noteglobalmoytab, substr(str_ireplace(array("\r","\n",'\r','\n'),' ', $annonce->description), 0, 10)]));
                }else{
                    $queryAnnonce = $this->Annonces->query();
                    $queryAnnonce->update()
                        ->set(['google_sheet' => 1])
                        ->where(['id' => $annonce->id])
                        ->execute();
                }  
                } catch (\Throwable $th) {
                    // throw $th;
                    $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                    $mail=$mails->first();
                    // #####################################################
                    $email = new Email('production');
                    $email->to('maroua.c@ite.digital')
                    ->addTo('hello@alpissime.com')
                        ->from([$mail->val=>FROM_MAIL])
                        ->subject('Erreur dans fichier CRON')
                        ->emailFormat('html')
                        ->send('Bonjour, <br><br> Erreur Function getGoogleSheets : <br><br> '.$th);
                }
            }
        }else{
            $query = $this->Annonces->query();
            $query->update()
                ->set(['google_sheet' => 0, 'google_sheet_line' => 1])
                ->where(['google_sheet' => 1])
                ->execute();
        }
        
    }
    /**
     * 
     */
    function stringFormat($titre)
    {
        $str = str_replace("é","e",$titre);
        $str = str_replace("è","e",$str);
        $str = str_replace("ê","e",$str);
        $str = str_replace("à","a",$str);
        $str = str_replace("â","a",$str);
        $str = str_replace("ä","a",$str);
        $str = str_replace("î","i",$str);
        $str = str_replace("ï","i",$str);
        $str = str_replace("ô","o",$str);
        $str = str_replace("ö","o",$str);
        $str = str_replace("ù","u",$str);
        $str = str_replace("û","u",$str);
        $str = str_replace("ü","u",$str);
        $str = str_replace(","," ",$str);
        $str = str_replace("'"," ",$str);
        $str = str_replace("É","e",$str);
        $str = str_replace("%","pourcent",$str);
        $str = str_replace("œ","oe",$str);
        $str = str_replace("Œ","oe",$str);
        $str = str_replace("€","euros",$str);
        $str = str_replace("/","-",$str);
        $str = str_replace("+","-",$str);
        $str = str_replace("ç","c",$str);
        $str = str_replace("*","",$str);
        $str = str_replace("?","",$str);
        $str = str_replace("!","",$str);
        $str = str_replace("°","",$str);
        $str = str_replace("<","",$str);
        $str = str_replace(">","",$str);
        $str = str_replace("----","-",$str);
        $str = str_replace("---","-",$str);
        $str = str_replace("--","-",$str);
        $str = str_replace("²","",$str);
        $str = str_replace(":","",$str);
        return $str;
    }

}
