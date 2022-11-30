<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Log\Log;
use Cake\I18n\Time;

/**
 * FunctionsSynchroAdress shell command.
 */
class FunctionsSynchroAdressShell extends Shell
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel("TamponAdresseClient");
        $this->loadModel("Utilisateurs");
        $this->loadModel("Pays");
        $this->loadModel("Frvilles");
        
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        Log::write('info', 'START ALL FunctionsSynchroAdress FUNCTIONS');
        $this->synchroBillingAddressTampon();
        Log::write('info', 'END ALL FunctionsSynchroAdress FUNCTIONS');
    }
    
    /**
     * 
     */
    public function synchroBillingAddressTampon()
    {
        $billingInfos = $this->TamponAdresseClient->find()->where(['(source <> 2 OR source IS NULL)', 'is_sync' => 0]);
        foreach ($billingInfos as $billingInfo) {
            try {
            //  Mise à jour adresse utilisateur dans base location
            $utilisateur = $this->Utilisateurs->find("all")->where(['id' => $billingInfo->client_id_loc]);
            if($utilisateur = $utilisateur->first()){  
                if((!is_null($billingInfo->street_biling)) && $billingInfo->street_biling != "" && (!is_null($billingInfo->postcode_biling)) && $billingInfo->postcode_biling != "" && (!is_null($billingInfo->country_biling)) && $billingInfo->country_biling != ""){
                    $dataUtilisateur = array(
                        'adresse' => $billingInfo->street_biling,
                        'code_postal' => $billingInfo->postcode_biling,
                        'date_update' => Time::now()
                    );
                    $updateUtilisateur=$this->Utilisateurs->patchEntity($utilisateur,$dataUtilisateur);
    
                    // pays 
                    $pays_id = $this->Pays->find("all")->where(['code_pays' => $billingInfo->country_biling]);
                    if($pays_id = $pays_id->first()){
                        $updateUtilisateur->pays = $pays_id->id_pays;
                        // region
                        if($pays_id->id_pays == 67 && $billingInfo->postcode_biling != ""){
                            $listevilles = $this->Frvilles->find()->where(['code_postal' => $billingInfo->postcode_biling]);
                            if($ville = $listevilles->first()){
                                $updateUtilisateur->region = $ville->departement_id;
                            }
                        }
                    }                 
    
                    if($this->Utilisateurs->save($updateUtilisateur)){
                        // update is_sync tampon table
                        $dataTamponBilling = array(
                            'is_sync' => 1,
                            'sync_at' => Time::now()
                        );
                        $TamponAdresseClient = $this->TamponAdresseClient->patchEntity($billingInfo,$dataTamponBilling);
                        $this->TamponAdresseClient->save($TamponAdresseClient);
                        Log::write('info', 'Mise à jour tampon client ID '.$utilisateur->id);
                    }else{
                        // update ERREUR is_sync tampon table
                        $dataTamponBilling = array(
                            'is_sync' => 6,
                            'sync_at' => Time::now()
                        );
                        $TamponAdresseClient = $this->TamponAdresseClient->patchEntity($billingInfo,$dataTamponBilling);
                        $this->TamponAdresseClient->save($TamponAdresseClient);  
                        Log::write('info', 'Erreur Mise à jour tampon client ID '.$utilisateur->id);
                    }
                } 

            }else{
                // update ERREUR is_sync tampon table
                $dataTamponBilling = array(
                    'is_sync' => 6,
                    'sync_at' => Time::now()
                );
                $TamponAdresseClient = $this->TamponAdresseClient->patchEntity($billingInfo,$dataTamponBilling);
                $this->TamponAdresseClient->save($TamponAdresseClient); 
                Log::write('info', 'Erreur 2 Mise à jour tampon client ID '.$utilisateur->id);
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
                    ->send('Bonjour, <br><br> Erreur Function synchroBillingAddressTampon : <br><br> '.$th);
            }
        }
        
    }

}
