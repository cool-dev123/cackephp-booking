<?php
namespace App\Shell;

use Cake\Console\Shell;
use Mustache_Engine;
use Cake\Mailer\Email;
use Cake\Log\Log;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\I18n\DateTime;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Event\EventManager;


/**
 * FunctionsCron5H shell command.
 */
class FunctionsCron5HShell extends Shell
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel("Reservations");
        $this->loadModel("Gestionnaires");
        $this->loadModel("Registres");
        $this->eventManager = new EventManager();
    }
    
    private function eventManager(){
        return $this->eventManager;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        Log::write('info', 'START ALL FUNCTIONS CRON 5 H');
        $this->recapQuotidienGestionnaire(); 
        Log::write('info', 'END ALL FUNCTIONS CRON 5 H');
    }

    /**
     * 
     */
    public function recapQuotidienGestionnaire()
    {
        Log::write('info', 'Start Execute recapQuotidienGestionnaire Function'); 
        // Liste des gestionnaires
        $gestionnaires = $this->Gestionnaires->find("all")->where(['id <> 6']);
        foreach ($gestionnaires as $gestionnaire) {
            try{
            $today = Time::now();
            $listeReservationsToday = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])
            ->join([            
                'Dispos' => [
                    'table' => 'dispos',
                    'type' => 'inner',
                    'conditions' => 'Dispos.reservation_id=Reservations.id',
                ]
            ])
            ->where(["Reservations.dbt_at = '".$today->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90", "Annonces.id_gestionnaires" => $gestionnaire->id])
            ->group('Reservations.id');
            $nbrarriveetoday = $listeReservationsToday->count();

            if($nbrarriveetoday != 0){
                $tomorrow = Time::now();
                $tomorrow->addDays(1);  
                $listeReservationsTomorrow = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])
                ->join([            
                    'Dispos' => [
                        'table' => 'dispos',
                        'type' => 'inner',
                        'conditions' => 'Dispos.reservation_id=Reservations.id',
                    ]
                ])
                ->where(["Reservations.dbt_at = '".$tomorrow->i18nFormat('yyyy-MM-dd')."'", "Reservations.statut = 90", "Annonces.id_gestionnaires" => $gestionnaire->id])
                ->group('Reservations.id');
                $nbrarriveetomorrow = $listeReservationsTomorrow->count();

                $sevendays = Time::now();
                $sevendays->subDays(7);
                $anciennesReservationsMontantaxe = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])
                ->join([            
                    'Dispos' => [
                        'table' => 'dispos',
                        'type' => 'inner',
                        'conditions' => 'Dispos.reservation_id=Reservations.id',
                    ]
                ])
                ->where(["Reservations.dbt_at < '".$today->i18nFormat('yyyy-MM-dd')."'", "Reservations.dbt_at >= '".$sevendays->i18nFormat('yyyy-MM-dd')."'", "Reservations.prixtaxesejour <> 0", "Reservations.taxe = 1", "Reservations.taxe_paye = 0", "Reservations.statut = 90", "Annonces.id_gestionnaires" => $gestionnaire->id])
                ->group('Reservations.id');
                $montant_taxe = 0;
                foreach ($anciennesReservationsMontantaxe as $taxemontant) {
                    $montant_taxe += $taxemontant->prixtaxesejour;
                }
    
                $anciennesReservationsNbrtaxe = $this->Reservations->find()->contain(['Utilisateurs', 'Annonces'])
                ->join([            
                    'Dispos' => [
                        'table' => 'dispos',
                        'type' => 'inner',
                        'conditions' => 'Dispos.reservation_id=Reservations.id',
                    ]
                ])
                ->where(["Reservations.dbt_at < '".$today->i18nFormat('yyyy-MM-dd')."'", "Reservations.dbt_at >= '".$sevendays->i18nFormat('yyyy-MM-dd')."'", "Reservations.prixtaxesejour <> 0", "Reservations.taxe = 1", "Reservations.taxe_paye = 0", "Reservations.statut = 90", "Annonces.id_gestionnaires" => $gestionnaire->id])
                ->group('Reservations.id');
                $taxe_retard = $anciennesReservationsNbrtaxe->count();
    
                $datamustache = array("nombre_arrivees" => $nbrarriveetoday, "arrivees_demain" => $nbrarriveetomorrow, "taxe_retard" => $taxe_retard, "montant_taxe" => $montant_taxe);
                
                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail=$mails->first();
                // #####################################################
                $event = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $gestionnaire->email,'textEmail'=>"recapQuotidienGestionnaire",
                                                         'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
                                                        ]);
                $this->eventManager()->dispatch($event);
                // #####################################################
                
                Log::write('info', 'Send mail "recapQuotidienGestionnaire" to '.$gestionnaire->email);
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
                    ->send('Bonjour, <br><br> Erreur function recapQuotidienGestionnaire : <br><br> '.$th);
            }
        }
        
        Log::write('info', 'End Execute recapQuotidienGestionnaire Function'); 
    }
}
