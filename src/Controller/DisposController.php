<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Chronos\Chronos;
use Cake\I18n\I18n;
use Cake\Log\Log;

/**
 * Dispos Controller
 *
 * @property \App\Model\Table\DisposTable $Dispos
 */
class DisposController extends AppController
{
    const AVAILABLE     = 0;
    const OPTIONAL      = 50;
    const RESERVED      = 90;
    const NOT_AVAILABLE = 100;

	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Flash');
		$this->loadComponent('RequestHandler');

		 $this->loadComponent('Auth', [
		 'loginAction' => [
            'controller' => 'Utilisateurs',
            'action' => 'erreurconnexion'
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
		$session = $this->request->session();
        $gestionnaire=$session->read('Gestionnaire.info');
		if($session->check("Gestionnaire.info")) {
			$this->Auth->allow(['view','edit','delete']);
        }
	    $this->Auth->allow(['chercherprixperiodeselect','calendarDispoLoc','chercherdisponibilite','chercherdisponibiliteres','calendarDispo','chercherdisponibilitedatepicker','supprimerCalend','calendarEdit','calendarAdd', 'calendarAddNew','listMyCalendar','deleteCalendar','calendarAddResMan','exportical','importical','iCalDecoder','calculertotalprixperiode','calculertotalprixperiodebyidreservation']);
        $this->loadModel("Lieugeos");
		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3, "etat = 1"],"order"=>"Lieugeos.name"]);
		$ar[]="Destination";
		foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		$this->set("l_lieugeos",$ar);
	}
  /**
   * Index method
   *
   * @return \Cake\Network\Response|null
   */
  public function index(){
		$this->paginate = ['contain' => ['Annonces', 'Utilisateurs', 'Reservations']];
    $dispos = $this->paginate($this->Dispos);
    $this->set(compact('dispos'));
    $this->set('_serialize', ['dispos']);
  }

    /**
     * View method
     *
     * @param string|null $id Dispo id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $datelien = null)
    {
        if (!$id) {
            $this->Flash->error(__("Période invalide"),['clear'=> true]);
            return $this->redirect(["controller" => "utilisateurs","action"=>"index"]);
        }
        $this->loadModel("Annonces");

        $session = $this->request->session();

        $gest = $session->read('Gestionnaire.info');
        $annonce = $this->Annonces->get($id, ['contain' => []]);
        $this->set("annonce_detail", $annonce);
        if ($annonce->proprietaire_id != $session->read('Auth.User.id') && $gest['G']['role'] != "gestionnaire" && $gest['G']['role'] != "admin") {
            //$annonce = "";
            $this->Flash->error(__("Vous ne pouvez pas voir l'annonce d'un autre utilisateur"),['clear'=> true]);
            $this->set("possible", "non");
        }

        // nombre de nuitées libre dans le futur
        $nbrnuiteetotal = 0;
        $listeperiodelibre = $this->Dispos->cherchernbrfuturenuitees($id);
        foreach ($listeperiodelibre as $nbrnuitee) {
            $nbrnuiteetotal += $nbrnuitee->duree;
        }
        $this->set("nbrnuiteetotal", $nbrnuiteetotal);

        $this->loadModel("Utilisateurs");
        $infoprop = $this->Utilisateurs->get($annonce->proprietaire_id, ['contain'=>['Cautions', 'Paiements', 'Annulations']]);
        $tauxcommession = ($infoprop->nature == "PRES" && !empty($infoprop->paiements) && $infoprop->paiements[0]->taux_commission != 0) ? $infoprop->paiements[0]->taux_commission : 3;
        $this->set("tauxcommession", $tauxcommession);

        if (!empty($this->request->data)) {
            if (isset($this->request->data['maj_annonce']) && $this->request->data['maj_annonce'] == "Valider") {
                $annonce->comment = $this->request->data['comment'];
                $this->Annonces->save($annonce);

                return $this->redirect(["controller" => "dispos", "action"=>"view", $annonce->id]);
            }

            if (isset($this->request->data['ajouter']) && $this->request->data['ajouter'] == "Ajouter") {
                $deb = explode('/', $this->request->data['dbt_at']);
                $fin = explode('/', $this->request->data['fin_at']);
                $s = strtotime( $fin[2] . '-' . $fin[1] . '-' . $fin[0])-strtotime($deb[2] . '-' . $deb[1] . '-' . $deb[0]);
                $d = intval($s/86400)+1;

                $exist = false;

                for ($i=0; $i < $d; $i++) {
                    $da_debut = $i==0 ? ($deb[2] . '-' . $deb[1] . '-' . $deb[0]) : date("Y-m-d", mktime(0, 0, 0, $deb[1]  , ($deb[0]+$i), $deb[2]));

                    if ($i==0) {
                        $da_fin = new Date($da_debut);
                        $da_fin->modify('+1 days');
                        $da_fin = $da_fin->i18nFormat('yyyy-MM-dd');

                        $data = $this->Dispos->find("all",["conditions"=>["Dispos.annonce_id"=>$this->request->data['annonce_id'],"Dispos.dbt_at < '$da_debut'","Dispos.fin_at > '$da_debut'"]])->orWhere(["(Dispos.annonce_id = ".$this->request->data['annonce_id']." AND Dispos.dbt_at = '".$da_debut."' AND Dispos.fin_at = '".$da_fin."')"]);
                    } else {
                        $data = $this->Dispos->find("all",["conditions"=>["Dispos.annonce_id"=>$this->request->data['annonce_id'],"Dispos.dbt_at < '$da_debut'","Dispos.fin_at > '$da_debut'"]]);
                    }

                    if (!empty($data->first())) {
                        $date_f = $deb[2] . '-' . $deb[1] . '-' . $deb[0];
                        $r_disp = $data->first();

                        if(strtotime($r_disp->fin_at) == strtotime($date_f)) {
                            $exist=false;
                        } else {
                            $exist=true;
                            break;
                        }
                    }
                }

                if (!$exist) {
                    $s_data = [
                        'annonce_id' => $this->request->data['annonce_id'],
                        'created_at' => $this->toDate(date('d-m-Y')),
                        'updated_at' => Time::now(),
                        'dbt_at'     => $this->toDate($this->request->data['dbt_at']),
                        'fin_at'     => $this->toDate($this->request->data['fin_at']),
                        'prix'       => $this->request->data['prix'],
                        'statut'     => $this->request->data['statut'],
                        'promo_yn'   => $this->request->data['promo_yn'],
                        'promo_px'   => $this->request->data['promo_px']
                    ];

                    $dispo = $this->Dispos->newEntity($s_data);

                    if ($this->Dispos->save($dispo)) {
                        $this->Flash->success(__('Votre Période a été créée'),['clear'=> true]);
                        return $this->redirect(["controller" => "dispos","action"=>"view",$this->request->data['annonce_id']]);
                    }
                } else {
                    $this->Flash->error(__('Cette  Période existe déja'),['clear'=> true]);
                    return $this->redirect(["controller" => "dispos","action"=>"view",$this->request->data['annonce_id']]);
                }
            }
        }

        $this->set("annonce_id", $id);
        $this->set("annonce", $annonce);
        $this->set("l_disposstatuts", ['0'=>'Libre','50'=>'Option','90'=>'Réservé']);

        $this->set("l_nombresemaine", [''=>'','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20']);

        $this->loadModel("Vacances");

        $listevacances = $this->Vacances->getListeVacances();
        $this->set('listevacances', $listevacances);

        $tabvacance = [];
        $drapeauvacance = [];
        $tabzones = [];

        foreach ($listevacances as $value) {
            $commvaca     = $value->commentaire_vac != "" ? " <strong>Remarques: </strong><span class='nouveauprix'>".$value->commentaire_vac."</span>" : "";
            $valzoneinput = $value->zone_champ_vac != ""  ? " (".$value->zone_champ_vac.")" : "";

            $tabvacance[$value['Pays']['fr']][] = $value->titre.$valzoneinput . " : </td><td><span class='nouveauprix'>du " . $value->dbt_vac . " au " . $value->fin_vac . "</span>" . $commvaca;
        }

        $this->loadModel("Pays");

        $subdivisions = [
            10 => "Canton",
            20 => "District",
            30 => "Lander",
            40 => "Province",
            50 => "Région",
            60 => "Zone",
            70 => "Comté",
            80 => "Voblast",
            90 => "Conseil régional",
        ];
        $payslistedr = $this->Pays->find("all");
        foreach ($payslistedr as $value) {
            if (isset($subdivisions[$value->subdivision])) {
                $zonevaca = $subdivisions[$value->subdivision];
            }

            $tabzones[$value->fr] = $value->subdivision != 0 ? " <span class='aligner'>subdivisé par " . $zonevaca . "</span>" : "";

            $drapeauvacance[$value->fr] = $value->code_pays;
        }

        $this->set('tabvacance', $tabvacance);
        $this->set('tabzones', $tabzones);
        $this->set('drapeauvacance', $drapeauvacance);

        $dispo= $this->Dispos->find("all", ["conditions" => ["Dispos.annonce_id"=>$id], "order" => "dbt_at"]);
        $this->set("l_ouinon", ['0' => 'Non', '1' => 'Oui']);
        $this->set('dispo', $dispo);
        $this->set('_serialize', ['dispo']);

        if ($datelien != null) {
            $this->set("datedajout", $datelien);
        }

        /** Statistique Prix Moyen **/
        /*** LISTE PRIX PAR SURFACE ***/
        $listePrixSurface = [];
        $listePrixSurfaceTotal = [];
        $total = [];
        $k = 0;

        if ($annonce->surface > 0 && $annonce->surface <= 19) {
            $surfacetext = 'A.surface > 0 AND A.surface <= 19';
            $setsurfaceid = 0;
        } else if($annonce->surface > 19 && $annonce->surface <= 30) {
            $surfacetext = 'A.surface > 19 AND A.surface <= 30';
            $setsurfaceid = 1;
        } else if ($annonce->surface > 30 && $annonce->surface <= 40) {
            $surfacetext = 'A.surface > 30 AND A.surface <= 40';
            $setsurfaceid = 2;
        } else if ($annonce->surface > 40 && $annonce->surface <= 50) {
            $surfacetext = 'A.surface > 40 AND A.surface <= 50';
            $setsurfaceid = 3;
        } else if ($annonce->surface > 50 && $annonce->surface <= 70) {
            $surfacetext = 'A.surface > 50 AND A.surface <= 70';
            $setsurfaceid = 4;
        } else if ($annonce->surface > 70 && $annonce->surface <= 100) {
            $surfacetext = 'A.surface > 70 AND A.surface <= 100';
            $setsurfaceid = 5;
        } else if ($annonce->surface > 100 && $annonce->surface <= 120) {
            $surfacetext = 'A.surface > 100 AND A.surface <= 120';
            $setsurfaceid = 6;
        } else if ($annonce->surface > 120 && $annonce->surface <= 150) {
            $surfacetext = 'A.surface > 120 AND A.surface <= 150';
            $setsurfaceid = 7;
        } else if($annonce->surface > 150 && $annonce->surface <= 180) {
            $surfacetext = 'A.surface > 150 AND A.surface <= 180';
            $setsurfaceid = 8;
        } else if($annonce->surface > 180) {
            $surfacetext = 'A.surface > 180';
            $setsurfaceid = 9;
        }

        $this->set("setsurfaceid", $setsurfaceid);
        $anneechoix = in_array(date("m"), ["09", "10", "11", "12"]) ? date("Y") : date("Y") - 1;

        $this->set("anneechoix", $anneechoix);
        $this->set("wheresurface", $surfacetext);
        $this->set("villageannonce", $annonce->village);

        if (!empty($gest) && $gest['G']['id']) {
            $gest_id = $gest['G']['id'];

            for ($i = 9; $i <= 12; $i++) {
                $prixGamme = $this->Dispos->get_price_surface($gest_id, $surfacetext, $anneechoix-1, $i, NULL, $annonce->village);
                $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, $surfacetext, $anneechoix-1, $i, NULL, $annonce->village);
                $listePrixSurface[] = is_null($prixGamme->total) ? 0 : round($prixGamme->total, 2);

                $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, $surfacetext, $anneechoix-1, $i, NULL, $annonce->village);
                $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, $surfacetext, $anneechoix-1, $i, NULL, $annonce->village);
                $listePrixSurfaceTotal[] = is_null($prixGammeTotal->total) ? 0 : round($prixGammeTotal->total, 2);

                $total[$k][] = $nbrAnnResTotalSurf;
                $total[$k][] = $nbrAnnResTotalSurfNnreser;
                $k++;
            }

            for ( $j=1; $j < 9; $j++) {
                $prixGamme = $this->Dispos->get_price_surface($gest_id, $surfacetext, $anneechoix, $j, NULL, $annonce->village);
                $nbrAnnResTotalSurf = $this->Dispos->count_get_price_surface_res($gest_id, $surfacetext, $anneechoix, $j, NULL, $annonce->village);
                $listePrixSurface[] = is_null($prixGamme->total) ? 0 : round($prixGamme->total, 2);

                $prixGammeTotal = $this->Dispos->get_price_surface_total($gest_id, $surfacetext, $anneechoix, $j, NULL, $annonce->village);
                $nbrAnnResTotalSurfNnreser = $this->Dispos->count_get_price_surface_total($gest_id, $surfacetext, $anneechoix, $j, NULL, $annonce->village);
                $listePrixSurfaceTotal[] = is_null($prixGammeTotal->total) ? 0 : round($prixGammeTotal->total, 2);

                $total[$k][] = $nbrAnnResTotalSurf;
                $total[$k][] = $nbrAnnResTotalSurfNnreser;
                $k++;
            }

            $this->set("listePrixSurface",$listePrixSurface);
            $this->set("listePrixSurfaceTotalNnReser",$listePrixSurfaceTotal);
            $this->set("listeTotal",$total);
        }

        // $this->loadModel("Calendarsynchro");
        // $listeCalendar = $this->Calendarsynchro->find("all")->where(['annonce_id' => $annonce->id]);
        // foreach ($listeCalendar as $value) {
        // 	$this->updateCalendarSynchro($value->url, $value->annonce_id, $value->id);
        // }
    }

	public function calendarDispoLoc($id){
		$events = array();
			if($id != 0){
			$dispo= $this->Dispos->find("all", ["conditions" => ["Dispos.annonce_id"=>$id], "order" => "prix_jour"]);
			$this->loadModel("Utilisateurs");
			$this->loadModel("Reservations");
			foreach ($dispo as $key => $value) { 
				$e = array();
				if($value->prix_jour == 0 && $value->prix != 0 && $value->promo_yn == 0){
					$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
					$prix_jour = $value->prix/$nbrDiff;
					$e['title'] = number_format(round($prix_jour, 2), 2, '.', '')." ".__('€ / J');
					$e['prix_jour'] = round($prix_jour, 2);
					$e['promo_jour'] = 0;
				}else if($value->promo_jour == 0 && $value->promo_px != 0 && $value->promo_yn == 1){
					$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
					$prix_jour = $value->prix/$nbrDiff;
					$e['prix_jour'] = round($prix_jour, 2);
					$promo_jour = $value->promo_px/$nbrDiff;
					$e['title'] = number_format(round($promo_jour, 2), 2, '.', '')." ".__('€ / J');
					$e['promo_jour'] = round($promo_jour, 2);
				}else if($value->promo_yn == 0){
					$e['title'] = number_format($value->prix_jour, 2, '.', '')." ".__('€ / J');
					$e['prix_jour'] = $value->prix_jour;
					$e['promo_jour'] = 0;
				}else if($value->promo_yn == 1){
					$e['title'] = number_format($value->promo_jour, 2, '.', '')." ".__('€ / J');
					$e['prix_jour'] = $value->prix_jour;
					$e['promo_jour'] = $value->promo_jour;
				}

				if($value->statut == 0){
					$e['color'] = "#4cc075";
				}elseif ($value->statut == 50) {
					$e['color'] = "#ff8800";
					if(!empty($value->utilisateur_id)){
					$utilisateur = $this->Utilisateurs->find()->where(['id' => $value->utilisateur_id]);
					$e['locataire'] = $utilisateur->prenom." ".$utilisateur->nom_famille;
					$query = $this->Reservations->find('all')->where(['id' => $value->reservation_id]);
						if(!empty($query = $query->first())){
							$e['nbrpersonnes'] = $query->nb_adultes+$query->nb_enfants;
							$e['nbrnuitees'] = $value->fin_at->diff($value->dbt_at)->days;
							$e['statutreservation'] = $query->statut;
						}
					}else{
						$e['locataire'] = '';
					}
				}elseif ($value->statut == 90) {
					$e['color'] = "#f54f4f";
					if(!empty($value->utilisateur_id)){
						$utilisateurRes = $this->Utilisateurs->find()->where(['id' => $value->utilisateur_id]);
						$e['locataire'] = $utilisateurRes->prenom." ".$utilisateurRes->nom_famille;
						$query = $this->Reservations->find('all')->where(['id' => $value->reservation_id]);
						if(!empty($query->first())){
							$e['nbrpersonnes'] = $query->nb_adultes+$query->nb_enfants;
							$e['nbrnuitees'] = $value->fin_at->diff($value->dbt_at)->days;
						}
					}else{
						$e['locataire'] = '';
					}
				}
				if ($value->statut == 100) {
					$e['color'] = "#f54f4f";
					$e['locataire'] = '';
				}
                                if(new Date($value->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date() && new Date() < new Date($value->fin_at->i18nFormat('dd-MM-yyyy')) ){                                    
                                    $e['statut'] = $value->statut;
                                    $e['start'] = new Date();
                                    $e['end'] = $value->fin_at;                                    
                                    $e['prix'] = $value->prix;
                                    $e['promotion'] = $value->promo_yn;
                                    $e['prix_promo'] = $value->promo_px;
                                    $e['nbr_jour'] = $value->nbr_jour;
                                    $e['conditionnbr'] = $value->conditionnbr;
                                    $e['dateant'] = "non";
                                    array_push($events, $e);
                                    
                                    $e['color'] = $e['color']."80";
                                    $e['dateant'] = "oui";
                                    $e['start'] = $value->dbt_at;
                                    $e['end'] = new Date();
                                    array_push($events, $e);
                                }else{  
                                    $e['dateant'] = "non";
                                    if(new Date($value->fin_at->i18nFormat('dd-MM-yyyy')) <= new Date() ){
                                        $e['color'] = $e['color']."80";
                                        $e['dateant'] = "oui";
                                    }
                                    $e['statut'] = $value->statut;
                                    $e['start'] = $value->dbt_at;
                                    $e['end'] = $value->fin_at;
                                    $e['prix'] = $value->prix;
                                    $e['promotion'] = $value->promo_yn;
                                    $e['prix_promo'] = $value->promo_px;
                                    $e['nbr_jour'] = $value->nbr_jour;
                                    $e['conditionnbr'] = $value->conditionnbr;
                                    // Merge the event array into the return array
                                    array_push($events, $e);  
                                }
				
			}
		}
		// Output json for our calendar
  	echo json_encode($events);
  	exit();
	}

	public function chercherdisponibilitedatepicker($id){
		$this->viewBuilder()->layout(false);
		$dispo = $this->Dispos->chercherdisponibilitedatepicker($id);
		$this->set('dispo', $dispo);

		$dispoPro = $this->Dispos->chercherdisponibilitePromodatepicker($id);
		$this->set('dispoPromo', $dispoPro);

		$dispoSamedi = $this->Dispos->chercherdisponibiliteSamedidatepicker($id);
		$this->set('dispoSamedi', $dispoSamedi);

		$dispoDimanche = $this->Dispos->chercherdisponibiliteDimanchedatepicker($id);
		$this->set('dispoDimanche', $dispoDimanche);
	}
	/**
	 * 
	 */
	public function chercherprixperiodeselect($id){
		$this->viewBuilder()->layout(false);
		$da_debut = date("Y-m-d", strtotime($this->request->data['debut']));
		$da_fin = date("Y-m-d", strtotime($this->request->data['fin']));

		$totalperiode = $this->Dispos->chercherdisponibiliteSansStatut($id, $da_debut, $da_fin);
		if($totalperiode->first()) $totalperiode = $totalperiode->first();
		else $totalperiode = "";
		$this->set('totalperiodecount', $totalperiode);
	}
	/**
	 * 
	 */
	public function cherchernbrdispoperiode($id){
		$this->viewBuilder()->layout(false);
		$da_debut = date("Y-m-d", strtotime($this->request->data['debut']));
		$da_fin = date("Y-m-d", strtotime($this->request->data['fin']));

		$totalperiode = $this->Dispos->chercherdisponibiliteCountTotByStatut($id, $da_debut, $da_fin);
		$this->set('totalperiodecount', $totalperiode->count());
	}
	/**
	 * 
	 */
	public function debloquerperiode($id){
		$this->viewBuilder()->layout(false);
		$da_debut = date("Y-m-d", strtotime($this->request->data['debut']));
		$da_fin = date("Y-m-d", strtotime($this->request->data['fin']));

		// chercher période bloqué par statut réservé ou bien indisponible
		$periodebloque = $this->Dispos->chercherdisponibilitebloque($id, $da_debut, $da_fin);
		foreach ($periodebloque as $value) {
			$s_data=array('updated_at'=>Time::now(), 'statut'=>0);
			$dispo = $this->Dispos->patchEntity($value, $s_data);
			$this->Dispos->save($dispo);
		}
		// $this->set('periodebloque', $periodebloque->count());
	}
	/**
	 * 
	 */
	public function chercherdisponibilitebloque($id){
		$this->viewBuilder()->layout(false);
		$da_debut = date("Y-m-d", strtotime($this->request->data['debut']));
		$da_fin = date("Y-m-d", strtotime($this->request->data['fin']));

		// chercher période bloqué par statut réservé ou bien indisponible
		$periodebloque = $this->Dispos->chercherdisponibilitebloque($id, $da_debut, $da_fin);
		$this->set('periodebloque', $periodebloque->count());
	}
	/**
	 * 
	 */
	public function chercherdisponibilite($id){
		$this->viewBuilder()->layout(false);
		$da_debut = date("Y-m-d", strtotime($this->request->data['debut']));
		$da_fin = date("Y-m-d", strtotime($this->request->data['fin']));
		$dispo = $this->Dispos->chercherdisponibilite($id, $da_debut, $da_fin);
		$dispoCount = $this->Dispos->chercherdisponibiliteCount($id, $da_debut, $da_fin);

		$totalperiode = $this->Dispos->chercherdisponibiliteCountTot($id, $da_debut, $da_fin);
		$this->set('totalperiodecount', $totalperiode->count());
		
		$i = 0;
		$k = 1;
		$fdate = '';
		$ddate = '';
		$tab = [];
		$detail = [];
		$nbrDiff = [];
		foreach ($dispo as $key => $value) {
			$i =$i + 1;
			if(new Date($value->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($this->request->data['debut'])) {
				$dbt = new Date($this->request->data['debut']);
			}	else {
				$dbt = new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'));
			}
			if(new Date($value->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($this->request->data['fin'])) {
				$fin = new Date($this->request->data['fin']);
			}else {
				$fin = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
			}
			if($dispoCount->count() != 1){
				if($fdate != ''){
					$now   = $fdate;
					$clone = clone $now;
					$tet = $clone->modify( '+1 day' );
					$e = $tet->format( 'd-m-Y' );
					if($fdate == new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'))){
						$t = $nbrDiff[$i-1][$i-1];
						$nbrDiff[$i-1][$k] = $n."_".$ddate."_".$fdate;
						$nbrDiff[$i-1][$k+1] = $value->nbr_jour."_".$value->dbt_at."_".$fin;
						$detail['debut'][$i-1] = $detail['debut'][$i-1];
						$detail['fin'][$i-1] = $fin;
						$tab[$i-1] = 'Période '.($i-1).' : du '.$detail['debut'][$i-1].' au '.$fin.' <br>';
						$i = $i-1;
						$k = $k + 1;
					}else{
						$nbrDiff[$i][$i] = $value->nbr_jour;
						$detail['debut'][$i] = $dbt;
						$detail['fin'][$i] = $fin;
						$tab[$i] = 'Période '.$i.' : du '.$dbt.' au '.$fin.' <br>';
					}
				}else{
					$nbrDiff[$i][$i] = $value->nbr_jour;
					$detail['debut'][$i] = $dbt;
					$detail['fin'][$i] = $fin;
					$tab[$i] = 'Période '.$i.' : du '.$dbt.' au '.$fin.' <br>';
				}
			}else{
				$nbrDiff[$i][$i] = $value->nbr_jour;
				$detail['debut'][$i] = $dbt;
				$detail['fin'][$i] = $fin;
				$tab[$i] = 'Période '.$i.' : du '.$dbt.' au '.$fin.' <br>';
			}
			$detail['condition'][$i] = $value->conditionnbr;
			$n = $value->nbr_jour;
			$fdate = $fin;
			$ddate = $dbt;
		}
		$this->set('nbrperiode', count($tab));
		$this->set('tabDispo', $dispo);
		$this->set('disponi', $tab);
		$this->set('details', $detail);
		$this->set('nbrDiff', $nbrDiff);
	}
	/**
	 * 
	 */
	public function chercherdisponibiliteres($id){
		$this->viewBuilder()->layout(false);
		$da_debut = date("Y-m-d", strtotime($this->request->data['debut']));
		$da_fin = date("Y-m-d", strtotime($this->request->data['fin']));
		$dispo = $this->Dispos->chercherdisponibilite($id, $da_debut, $da_fin);
		$dispoCount = $this->Dispos->chercherdisponibiliteCount($id, $da_debut, $da_fin);
		$i = 0;
		$k = 1;
		$fdate = '';
		$ddate = '';
		$tab = [];
		$detail = [];
		$nbrDiff = [];
		foreach ($dispo as $key => $value) {
			$i =$i + 1;
			if(new Date($value->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($this->request->data['debut'])) {
				$dbt = new Date($this->request->data['debut']);
			}	else {
				$dbt = new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'));
			}
			if(new Date($value->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($this->request->data['fin'])) {
				$fin = new Date($this->request->data['fin']);
			}else {
				$fin = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
			}
			if($dispoCount->count() != 1){
				if($fdate != ''){
					$now   = $fdate;
					$clone = clone $now;
					$tet = $clone->modify( '+1 day' );
					$e = $tet->format( 'd-m-Y' );
					if($fdate == new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'))){
						$t = $nbrDiff[$i-1][$i-1];
						$nbrDiff[$i-1][$k] = $n."_".$ddate."_".$fdate;
						$nbrDiff[$i-1][$k+1] = $value->nbr_jour."_".$value->dbt_at."_".$fin;
						$detail['debut'][$i-1] = $detail['debut'][$i-1];
						$detail['fin'][$i-1] = $fin;
						$tab[$i-1] = __('Du')." ".$detail['debut'][$i-1].' '.__("au").' '.$fin;
						$i = $i-1;
						$k = $k + 1;
					}else{
						$nbrDiff[$i][$i] = $value->nbr_jour;
						$detail['debut'][$i] = $dbt;
						$detail['fin'][$i] = $fin;
						$tab[$i] = __('Du')." ".$dbt.' '.__("au").' '.$fin;
					}
				}else{
					$nbrDiff[$i][$i] = $value->nbr_jour;
					$detail['debut'][$i] = $dbt;
					$detail['fin'][$i] = $fin;
					$tab[$i] = __('Du')." ".$dbt.' '.__("au").' '.$fin;
				}
			}else{
				$nbrDiff[$i][$i] = $value->nbr_jour;
				$detail['debut'][$i] = $dbt;
				$detail['fin'][$i] = $fin;
				$tab[$i] = __('Du')." ".$dbt.' '.__("au").' '.$fin;
			}
			$detail['condition'][$i] = $value->conditionnbr;
			$n = $value->nbr_jour;
			$fdate = $fin;
			$ddate = $dbt;
		}
		$this->set('nbrperiode', count($tab));
		$this->set('tabDispo', $dispo);
		$this->set('disponi', $tab);
		$this->set('details', $detail);
		$this->set('nbrDiff', $nbrDiff);
	}

    public function calendarDispo($annonce_id)
    {
//        @unlink(PATH_ALPISSIME."debug");
//        file_put_contents(PATH_ALPISSIME."debug",print_r("function calendarDispo\n", true),FILE_APPEND);

//        file_put_contents(PATH_ALPISSIME."debug",print_r("annonce_id = ", true),FILE_APPEND);
//        file_put_contents(PATH_ALPISSIME."debug",print_r($annonce_id, true),FILE_APPEND);
//        file_put_contents(PATH_ALPISSIME."debug",print_r("\n", true),FILE_APPEND);

        $this->loadModel("Utilisateurs");
        $this->loadModel("Reservations");
        $this->loadModel("Annonces");
        $this->loadModel("Contrats");

        $dispos = $this->Dispos->find("all", ["conditions" => ["Dispos.annonce_id"=>$annonce_id, "((Dispos.statut = 90 && Dispos.reservation_id IS NULL) OR (Dispos.statut <> 90))"], "order" => "dbt_at"]);

        $annonceinfo = $this->Annonces->get($annonce_id);

        $events = [];
        foreach ($dispos as $key => $dispo) {
//            file_put_contents(PATH_ALPISSIME."debug",print_r("dispo = ",true), FILE_APPEND);
//            file_put_contents(PATH_ALPISSIME."debug",print_r($dispo,true), FILE_APPEND);
//            file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true), FILE_APPEND);
            $event = [
                'dispo_id' => $dispo->id,
                'url_liste_reservation' => '',
                'titre_url_liste_reservation' => '',
                'locataire' => '',
                'color' => '#fc427b',
                'periode' => $dispo->dbt_at->i18nFormat('dd/MM/yyyy') . " - " . $dispo->fin_at->i18nFormat('dd/MM/yyyy'),
                'start' => $dispo->dbt_at,
                'end' => $dispo->fin_at,
                'prix' => $dispo->prix,
                'promotion' => $dispo->promo_yn,
                'prix_promo' => $dispo->promo_px,
                'nbr_jour' => $dispo->nbr_jour,
                'conditionnbr' => $dispo->conditionnbr,
                'calendarsynchro_id' => $dispo->calendarsynchro_id
            ];

            if ($dispo->calendarsynchro_id != 0) {
                $this->loadModel("Calendarsynchro");
                $findCalendarSynchro = $this->Calendarsynchro->find("all")->where(['id' => $dispo->calendarsynchro_id]);

                if ($synchrocalendar = $findCalendarSynchro->first()) {
                    $event['calendarsynchro_nom'] = $synchrocalendar->nom;
                }
            }

            if ($dispo->prix_jour == 0 && $dispo->prix != 0 && $dispo->promo_yn == 0) {
                $nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;
                $prix_jour = round($dispo->prix/$nbrDiff, 2);
                $event['prix_jour'] = $prix_jour;
                $event['prixnuitee'] = $prix_jour;
                $event['promo_jour'] = 0;
            } else if ($dispo->promo_jour == 0 && $dispo->promo_px != 0 && $dispo->promo_yn == 1) {
                $nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;
                $promo_jour = round($dispo->promo_px/$nbrDiff, 2);
                $event['prix_jour'] = round($dispo->prix/$nbrDiff, 2);
                $event['promo_jour'] = $promo_jour;
                $event['prixnuitee'] = $promo_jour;
            } else if ($dispo->promo_yn == 0) {
                $event['prix_jour'] = $dispo->prix_jour;
                $event['promo_jour'] = 0;
                $event['prixnuitee'] = round($dispo->prix_jour, 2);
            } else if ($dispo->promo_yn == 1) {
                $event['prix_jour'] = $dispo->prix_jour;
                $event['promo_jour'] = $dispo->promo_jour;
                $event['prixnuitee'] = round($dispo->promo_jour, 2);
            }

            switch ($dispo->statut) {
                case 0:
                    $event['title'] = "Libre";
                    break;
                case 50:
                    if (!empty($dispo->utilisateur_id)) {
                        if(!$this->Utilisateurs->find()->where(['id' => $dispo->utilisateur_id])->isEmpty()) {
                            $utilisateur = $this->Utilisateurs->get($dispo->utilisateur_id);
                            $event['locataire'] = $utilisateur->prenom." ".ucfirst($utilisateur->nom_famille).".";
                        }

                        $query = $this->Reservations->find('all')->where(['id' => $dispo->reservation_id]);
                        if (!empty($reservation = $query->first())) {
                            switch ($reservation->statut) {
                                case 50:
                                    $event['title'] = __("Réservation à valider");
                                    $event['url_liste_reservation'] = 'reservations/validation';
                                    break;
                                case 0:
                                    $event['title'] = __("Réservation en cours de création");
                                    break;
                            }

                            $event['nbrpersonnes'] = $reservation->nb_adultes + $reservation->nb_enfants;
                            $event['nbrnuitees'] = $dispo->fin_at->diff($dispo->dbt_at)->days;
                            $event['statutreservation'] = $reservation->statut;

                            // taxe de séjour
                            $resultatDetail = $this->calcultaxedesejour($annonce_id, $dispo->dbt_at->i18nFormat('dd-MM-yyyy')."/".$dispo->fin_at->i18nFormat('dd-MM-yyyy'), $reservation->nb_adultes, $reservation->nb_enfants);
                            $event['prixtaxeapayer'] = $resultatDetail['prixtaxeapayer'];
                            // END taxe de séjour

                            // Frais de services
                            $fraiserviceprop = 10.6;
                            $typefraiserviceprop = "pourcentage";

                            $proprietaire = $this->Utilisateurs->find("all")->contain(['Paiements'])->where(["Utilisateurs.id" => $annonceinfo->proprietaire_id]);
                            if($proprietaire = $proprietaire->first()){
                                if(!empty($proprietaire->paiements)){
                                    $fraiserviceprop = $proprietaire->paiements[0]->frais_service;
                                    $typefraiserviceprop = $proprietaire->paiements[0]->type_frais;
                                }
                            }
                            $fraisAlpissime = $typefraiserviceprop == "fixe" ? $fraiserviceprop : ($resultatDetail['total_price'] - $resultatDetail['automaticPromo']['value'])/100 * $fraiserviceprop;
                            $fraisStripe = (($resultatDetail['total_price'] - $resultatDetail['automaticPromo']['value'])/100 * 1.4);
                            $event['fraisService'] = $fraisAlpissime + $fraisStripe;
                            // END frais de services
                        }
                    }
                    break;
                case 100:
                    $event['title'] = "PeriodIndispo";
                    break;
            }
//            file_put_contents(PATH_ALPISSIME."debug",print_r("event = ",true),FILE_APPEND);
//            file_put_contents(PATH_ALPISSIME."debug",print_r($event,true),FILE_APPEND);
//            file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
            // Merge the event array into the return array
            array_push($events, $event);
        }

        // chercher les réservations pour les afficher par une seule barre
        $reservations = $this->Reservations->find("all")
            ->join([
                'Dispos' => [
                    'table' => 'dispos',
                    'type' => 'inner',
                    'conditions' => 'Dispos.reservation_id=Reservations.id',
                ]
            ])
            ->where(["Reservations.annonce_id" => $annonce_id, "Reservations.statut = 90"])
            ->select(["Reservations.id", "Dispos.calendarsynchro_id", "Reservations.utilisateur_id", "Reservations.nb_adultes", "Reservations.nb_enfants", "Reservations.fin_at", "Reservations.dbt_at"]);

        foreach ($reservations as $key => $reservation) {
//            file_put_contents(PATH_ALPISSIME."debug",print_r("reservation->id = ",true),FILE_APPEND);
//            file_put_contents(PATH_ALPISSIME."debug",print_r($reservation->id,true),FILE_APPEND);
//            file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
            $event = [
                'reservation_id' => $reservation->id,
                'url_liste_reservation' => '',
                'titre_url_liste_reservation' => '',
                'locataire' => '',
                'color' => '#fc427b',
                'periode' => $reservation->dbt_at->i18nFormat('dd/MM/yyyy') . " - " . $reservation->fin_at->i18nFormat('dd/MM/yyyy'),
                'start' => $reservation->dbt_at,
                'end' => $reservation->fin_at,
                'prixnuitee' => 0,
                'stautreserve' => 90,
                'calendarsynchro_id' => $reservation['Dispos']['calendarsynchro_id'],
            ];

            if ($reservation['Dispos']['calendarsynchro_id'] != 0) {
                $this->loadModel("Calendarsynchro");
                $findCalendarSynchro = $this->Calendarsynchro->find("all")->where(['id' => $reservation['Dispos']['calendarsynchro_id']]);
                if($synchrocalendar = $findCalendarSynchro->first()) {
                    $event['calendarsynchro_nom'] = $synchrocalendar->nom;
                }
            }

            if ($reservation['Dispos']['calendarsynchro_id'] == 0) {
                $event['title'] = __("Réservation confirmée");
                $event['url_liste_reservation'] = 'reservations/view';
            } else {
                $event['title'] = __("Réservation confirmée (Synchronisée)");
                $event['url_liste_reservation'] = 'reservations/reservationcalendar';

                // vérifier si en contrat pour envoyer mail
                if ($annonceinfo->contrat == 1 && $reservation->utilisateur_id == NULL) {
                    $contratannonce = $this->Contrats->find("all")->where(['annonce_id' => $annonceinfo->id, 'visible=1']);
                    if ($contratannonce->first()) {
                        $event['titre_url_liste_reservation'] = __("Attention : Complétez la réservation pour la faire apparaître dans le planning de votre conciergerie");
                    }
                }
            }

            if (!empty($reservation->utilisateur_id)) {
                if (!$this->Utilisateurs->find()->where(['id' => $reservation->utilisateur_id])->isEmpty()) {
                    $utilisateurRes = $this->Utilisateurs->get($reservation->utilisateur_id);
                    $event['locataire'] = $utilisateurRes->prenom." ".$utilisateurRes->nom_famille;
                }

                $event['nbrpersonnes'] = $reservation->nb_adultes + $reservation->nb_enfants;
                $event['nbrnuitees'] = $reservation->fin_at->diff($reservation->dbt_at)->days;

                // taxe de séjour
                $resultatDetail = $this->calcultaxedesejour($annonce_id, $reservation->dbt_at->i18nFormat('dd-MM-yyyy') . "/" .$reservation->fin_at->i18nFormat('dd-MM-yyyy'), $reservation->nb_adultes, $reservation->nb_enfants);
                $event['prixtaxeapayer'] = $resultatDetail['prixtaxeapayer'];
                // END taxe de séjour

                // Frais de services
                $fraiserviceprop = 10.6;
                $typefraiserviceprop = "pourcentage";

                $proprietaire = $this->Utilisateurs->find("all")->contain(['Paiements'])->where(["Utilisateurs.id" => $annonceinfo->proprietaire_id]);
                if($proprietaire = $proprietaire->first()){
                    if(!empty($proprietaire->paiements)){
                        $fraiserviceprop = $proprietaire->paiements[0]->frais_service;
                        $typefraiserviceprop = $proprietaire->paiements[0]->type_frais;
                    }
                }
                $fraisAlpissime = $typefraiserviceprop == "fixe" ? $fraiserviceprop : ($resultatDetail['total_price'] - $resultatDetail['automaticPromo']['value'])/100 * $fraiserviceprop;
                $fraisStripe = (($resultatDetail['total_price'] - $resultatDetail['automaticPromo']['value'])/100 * 1.4);
                $event['fraisService'] = $fraisAlpissime + $fraisStripe;
                // END frais de services
            }

//            file_put_contents(PATH_ALPISSIME."debug",print_r("event 2 = ",true),FILE_APPEND);
//            file_put_contents(PATH_ALPISSIME."debug",print_r($event,true),FILE_APPEND);
//            file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
            // Merge the event array into the return array
            array_push($events, $event);
        }
//        file_put_contents(PATH_ALPISSIME."debug",print_r("events = ",true),FILE_APPEND);
//        file_put_contents(PATH_ALPISSIME."debug",print_r($events,true),FILE_APPEND);
//        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
        // Output json for our calendar
        echo json_encode($events);
        exit();
    }

	/**
	 * 
	 */
	public function calendarDispo_OLD($id,$station){
		$dispo= $this->Dispos->find("all", ["conditions" => ["Dispos.annonce_id"=>$id], "order" => "dbt_at"]);
  	$events = array();
		$this->loadModel("Utilisateurs");
		$this->loadModel("Reservations");
		foreach ($dispo as $key => $value) {
			$e = array();
			if($value->prix_jour == 0 && $value->prix != 0 && $value->promo_yn == 0){
				$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
				$prix_jour = $value->prix/$nbrDiff;
				$e['title'] = number_format(round($prix_jour, 2), 2, '.', '')." ".__('€ / J');
				$e['prix_jour'] = round($prix_jour, 2);
				$e['promo_jour'] = 0;
			}else if($value->promo_jour == 0 && $value->promo_px != 0 && $value->promo_yn == 1){
				$nbrDiff = $value->fin_at->diff($value->dbt_at)->days;
				$prix_jour = $value->prix/$nbrDiff;
				$e['prix_jour'] = round($prix_jour, 2);
				$promo_jour = $value->promo_px/$nbrDiff;
				$e['title'] = number_format(round($promo_jour, 2), 2, '.', '')." ".__('€ / J');
				$e['promo_jour'] = round($promo_jour, 2);
			}else if($value->promo_yn == 0){
				$e['title'] = number_format($value->prix_jour, 2, '.', '')." ".__('€ / J');
				$e['prix_jour'] = $value->prix_jour;
				$e['promo_jour'] = 0;
			}else if($value->promo_yn == 1){
				$e['title'] = number_format($value->promo_jour, 2, '.', '')." ".__('€ / J');
				$e['prix_jour'] = $value->prix_jour;
				$e['promo_jour'] = $value->promo_jour;
			}
			if($value->statut == 0){
				$e['color'] = "#4cc075";
			}elseif ($value->statut == 50) {
				$e['color'] = "#ff8800";
				if(!empty($value->utilisateur_id)){
						if(! $this->Utilisateurs->find()->where(['id' => $value->utilisateur_id])->isEmpty()) {
                                                    $utilisateur = $this->Utilisateurs->get($value->utilisateur_id);
						    $e['locataire'] = $utilisateur->prenom." ".$utilisateur->nom_famille;
                                                }
						$query = $this->Reservations->find('all')->where(['id' => $value->reservation_id]);
							if(!empty($query = $query->first())){
								$e['nbrpersonnes'] = $query->nb_adultes+$query->nb_enfants;
								$e['nbrnuitees'] = $value->fin_at->diff($value->dbt_at)->days;
								$e['statutreservation'] = $query->statut;
							}
				}else{
					$e['locataire'] = '';
				}
			}elseif ($value->statut == 90) {
				if($value->calendarsynchro_id != 0) $e['color'] = "#ff3e7a9e";
				else $e['color'] = "#f54f4f";
				if(!empty($value->utilisateur_id)){
                                    if(! $this->Utilisateurs->find()->where(['id' => $value->utilisateur_id])->isEmpty()){
                                        $utilisateurRes = $this->Utilisateurs->get($value->utilisateur_id);
					$e['locataire'] = $utilisateurRes->prenom." ".$utilisateurRes->nom_famille; 
                                    }					
					$query = $this->Reservations->find('all')->where(['id' => $value->reservation_id]);
						if(!empty($query->first())){
							$e['nbrpersonnes'] = $query->nb_adultes+$query->nb_enfants;
							$e['nbrnuitees'] = $value->fin_at->diff($value->dbt_at)->days;
						}
				}else{
					$e['locataire'] = '';
				}
			}
			$e['annonce'] = $id;
			$e['id'] = $value->id;
			$e['statut'] = $value->statut;
			$e['start'] = $value->dbt_at;
			$e['end'] = $value->fin_at;
			$e['prix'] = $value->prix;
			$e['promotion'] = $value->promo_yn;
			$e['prix_promo'] = $value->promo_px;
			$e['nbr_jour'] = $value->nbr_jour;
			$e['conditionnbr'] = $value->conditionnbr;
			$e['calendarsynchro_id'] = $value->calendarsynchro_id;
			if($value->calendarsynchro_id != 0){
				$this->loadModel("Calendarsynchro");
				$findCalendarSynchro = $this->Calendarsynchro->find("all")->where(['id' => $value->calendarsynchro_id]);
				if($synchrocalendar = $findCalendarSynchro->first()) $e['calendarsynchro_nom'] = $synchrocalendar->nom;
			}
			
			// Merge the event array into the return array
	    	array_push($events, $e);
		}

		$this->loadModel("Vacances");
		$vacances= $this->Vacances->find("all");
		foreach ($vacances as $key => $value) {
			$e = array();
			$e['title'] = "Vacance";
			$e['color'] = "#e1f5f6";
			$e['start'] = $value->dbt_vac;
			$now   = $value->fin_vac;
			$clone = clone $now;
			$tet = $clone->modify( '+1 day' );
			$e['end'] = $tet->format( 'Y-m-d' );
			array_push($events, $e);
		}

		$this->loadModel("Stations");
		$stations= $this->Stations->find("all", ["conditions" => ["Stations.station_id"=>$station]]);
		foreach ($stations as $key => $value) {
			$e = array();
			$e['title'] = "Station";
			$e['color'] = "#ffffff";
			$e['start'] = $value->ouverture;
			$now   = $value->fermeture;
				$clone = clone $now;
				$tet = $clone->modify( '+1 day' );
			$e['end'] = $tet->format( 'Y-m-d' );
			array_push($events, $e);
		}
		// Output json for our calendar
  	echo json_encode($events);
  	exit();
	}

	public function supprimerCalend($id,$annonceID){
		$ar = explode('_', $id);
		$id = $ar[0];
		$dispo = $this->Dispos->get($id);
		if ($this->Dispos->delete($dispo)) {
			$this->Flash->success(__('Periode supprimée'),['clear'=> true]);
		} else {
			$this->Flash->error(__('Identifiant invalide pour la période'),['clear'=> true]);
		}
		$session = $this->request->session();
		if($session->read('Config.language') != "fr_FR"){
			$this->loadModel("Languages");
			$language_header_name = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();
			$urlLang = $language_header_name->url_code."/";
		} else {
			$urlLang = "";
		}
		$this->loadModel("Urlmultilingue");
		$urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
		$urlvaluemulti = [];
		foreach ($urlmultilinguelistes as $urlmultilingueliste) {
			$urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
		}
		return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['dispos']."/view/".$annonceID);
	}

	public function calendarEdit(){
		$session = $this->request->session();
		if($session->read('Config.language') != "fr_FR"){
			$this->loadModel("Languages");
			$language_header_name = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();
			$urlLang = $language_header_name->url_code."/";
		} else {
			$urlLang = "";
		}
		$this->loadModel("Urlmultilingue");
		$urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
		$urlvaluemulti = [];
		foreach ($urlmultilinguelistes as $urlmultilingueliste) {
			$urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
		}		
		
		if($this->request->data['locatairehidden'] != '' && $this->request->data['defaultstatuthidden'] != ''){
			if($this->request->data['defaultstatuthidden'] == '50'){
				$this->Flash->error(__('Merci d\'aller dans Réservations à valider'),['clear'=> true]);
			}else if($this->request->data['defaultstatuthidden'] == '90'){
				$this->Flash->error(__('Merci d\'aller dans Réservations en cours'),['clear'=> true]);
			}
			return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['dispos']."/view/".$this->request->data['annonce_id']);
		}

		$ar = explode('_', $this->request->data['ids']);
		$id = $ar[0];
		$dispo = $this->Dispos->get($id, ['contain' => []]);
		if (!$id && empty($this->request->data['dbt_at'])) {
			$this->Flash->error(__("Période invalide"),['clear'=> true]);
			return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['index']);
			// return $this->redirect(["controller" => "utilisateurs","action"=>"index"]);
		}
		if (!empty($this->request->data['dbt_at'])) {
			if (isset($this->request->data['valider']) && $this->request->data['valider'] == "Valider") {
				$deb = explode('-', $this->request->data['dbt_at']);
				$fin = explode('-', $this->request->data['fin_at']);
				$s = strtotime( $fin[2] . '-' . $fin[1] . '-' . $fin[0])-strtotime($deb[2] . '-' . $deb[1] . '-' . $deb[0]);
				$d = intval($s/86400)+1;
				$exist=false;
				for($i=0;$i<$d;$i++){
					if($i==0) $da_debut=$deb[2] . '-' . $deb[1] . '-' . $deb[0];
					else {
					 $da_debut=date("Y-m-d", mktime(0, 0, 0, $deb[1]  , ($deb[0]+$i), $deb[2]));
					}
					if($i==0){
						$da_fin = new Date($da_debut);
						$da_fin->modify('+1 days');
						$da_fin = $da_fin->i18nFormat('yyyy-MM-dd');
						$data = $this->Dispos->find("all",["conditions"=>["Dispos.annonce_id"=>$this->request->data['annonce_id'],"Dispos.id != '$id'","Dispos.dbt_at < '$da_debut'","Dispos.fin_at > '$da_debut'"]])->orWhere(["(Dispos.annonce_id = ".$this->request->data['annonce_id']." AND Dispos.id != ".$id." AND Dispos.dbt_at = '".$da_debut."' AND Dispos.fin_at = '".$da_fin."')"]);
					}else{
						$data = $this->Dispos->find("all",["conditions"=>["Dispos.annonce_id"=>$this->request->data['annonce_id'],"Dispos.id != '$id'","Dispos.dbt_at < '$da_debut'","Dispos.fin_at > '$da_debut'"]]);
					}
					if (!empty($data->first())) {
						 $date_f=$deb[2] . '-' . $deb[1] . '-' . $deb[0];
						$r_disp=$data->first();
						if(strtotime($r_disp->fin_at)==strtotime($date_f)) $exist=false;
						else {
							$exist=true;
							break;
						}
					}
				}
				if(!$exist){
					if(str_replace(' €', '', $this->request->data['promo_px']) == '' || str_replace(' €', '', $this->request->data['promo_px']) == 0){
						$propyn = 0;
					}else{
						$propyn = 1;
					}
					if($this->request->data['nbr_jour'] == 7){
						$nbrcondjour = $this->request->data['condition7'];
					}else{
						$nbrcondjour = 0;
					}
					$prixjouredit = str_replace(' €', '', $this->request->data['promo_jour']);
					if($prixjouredit == '') $prixjouredit = 0;

					$prixperiodeedit = str_replace(' €', '', $this->request->data['promo_px']);
					if($prixperiodeedit == '') $prixperiodeedit = 0;

					$s_data=array(	'updated_at'=>Time::now(),
						'dbt_at'=>$this->toDate($this->request->data['dbt_at']),
						'fin_at'=>$this->toDate($this->request->data['fin_at']),
						'prix'=> str_replace(' €', '', $this->request->data['prix']),
						'statut'=>$this->request->data['statut'],
						'promo_yn'=>$propyn,
						'nbr_jour'=> $this->request->data['nbr_jour'],
						'conditionnbr'=> $nbrcondjour,
						'prix_jour'=> str_replace(' €', '', $this->request->data['prix_jour']),
						'promo_jour'=> $prixjouredit,
						'promo_px'=> $prixperiodeedit);
					$dispo = $this->Dispos->patchEntity($dispo, $s_data);
					if ($dispo = $this->Dispos->save($dispo)) {
						/*** Update Annonce ***/
						$this->loadModel("Annonces");
						$annonce = $this->Annonces->get($dispo->annonce_id);
						$data=array('updated_at'=>Time::now());
						$annonce = $this->Annonces->patchEntity($annonce, $data);
						$this->Annonces->save($annonce);
						$this->Flash->success(__('Période modifiée'),['clear'=> true]);
						return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['dispos']."/view/".$this->request->data['annonce_id']."/".$this->request->data['dbt_at']);
					} else {
						$this->Flash->error(__('Période non modifiée'),['clear'=> true]);
						return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['dispos']."/view/".$this->request->data['annonce_id']."/".$this->request->data['dbt_at']);
					}
				}else{
					$this->Flash->error(__('Période non valide'),['clear'=> true]);
					return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['dispos']."/view/".$this->request->data['annonce_id']."/".$this->request->data['dbt_at']);
				}
			}
			return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['dispos']."/view/".$this->request->data['annonce_id']."/".$this->request->data['dbt_at']);
		}
		$this->autoRender = false;
  }
  	/**
	 * 
	 */
	public function calendarAddFraisFixes(){
		$this->viewBuilder()->layout(false);
		$enregistrement = "non";
		$this->loadModel("Annonces");
		$annonce = $this->Annonces->get($this->request->data['annonce_id']);
		if(isset($this->request->data['demande_frais_menage'])){
			if($this->request->data['montant_frais_menage'] != 0){
				$data_menage=array(
					'updated_at'=>Time::now(),
					'montant_frais_menage'=>$this->request->data['montant_frais_menage']
				);
				$annonce = $this->Annonces->patchEntity($annonce, $data_menage);
				if($this->Annonces->save($annonce)) $enregistrement = "oui";
			}
		}else{
			$data_menage=array(
				'updated_at'=>Time::now(),
				'montant_frais_menage'=>0
			);
			$annonce = $this->Annonces->patchEntity($annonce, $data_menage);
			if($this->Annonces->save($annonce)) $enregistrement = "oui";
		}
		if(isset($this->request->data['accept_animaux'])){
			if(isset($this->request->data['demande_frais_animaux'])){
				if($this->request->data['montant_frais_animaux'] != 0){
					$data_animaux=array(
						'updated_at'=>Time::now(),
						'accept_animaux'=> 1,
						'demande_frais_animaux'=>1,
						'montant_frais_animaux'=>$this->request->data['montant_frais_animaux']
					);
				}else{
					$data_animaux=array(
						'updated_at'=>Time::now(),
						'accept_animaux'=> 1,
						'demande_frais_animaux'=>0,
						'montant_frais_animaux'=>0
					);
				}
			}else{
				$data_animaux=array(
					'updated_at'=>Time::now(),
					'accept_animaux'=> 1,
					'demande_frais_animaux'=>0,
					'montant_frais_animaux'=>0
				);
			}
			$annonce = $this->Annonces->patchEntity($annonce, $data_animaux);
			if($this->Annonces->save($annonce)) $enregistrement = "oui";
		}else{
			$data_animaux=array(
				'updated_at'=>Time::now(),
				'accept_animaux'=> 0,
				'demande_frais_animaux'=>0,
				'montant_frais_animaux'=>0
			);
			$annonce = $this->Annonces->patchEntity($annonce, $data_animaux);
			if($this->Annonces->save($annonce)) $enregistrement = "oui";
		}
		if($enregistrement == "oui") $this->Flash->success(__('Les modifications sur votre annonce ont bien été sauvegardées'),['clear'=> true]);


		$session = $this->request->session();
		if($session->read('Config.language') != "fr_FR"){
			$this->loadModel("Languages");
			$language_header_name = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();
			$urlLang = $language_header_name->url_code."/";
		} else {
			$urlLang = "";
		}
		$this->loadModel("Urlmultilingue");
		$urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
		$urlvaluemulti = [];
		foreach ($urlmultilinguelistes as $urlmultilingueliste) {
			$urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
		}
		return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['dispos']."/view/".$this->request->data['annonce_id']."/".$this->request->data['dbt_at']);
		$this->autoRender = false;
	}
	/**
	 * 
	 */
	public function calendarAddLastMinute()
    {
        if ($this->request->params['isAjax']) {
            $this->loadModel("Annonces");
            $annonce = $this->Annonces->get($this->request->data['annonce_id']);

            $data = (isset($this->request->data['proposerlastminute']) && $this->request->data['delaislastminute'] != 0 && $this->request->data['montantlastminute'] != 0) ? [
                'updated_at'         => Time::now(),
                'proposerlastminute' => 1,
                'delaislastminute'   => $this->request->data['delaislastminute'],
                'montantlastminute'  => $this->request->data['montantlastminute']
            ] : [
                'updated_at'         => Time::now(),
                'proposerlastminute' => 0,
                'delaislastminute'   => 0,
                'montantlastminute'  => 0
            ];

            $annonce = $this->Annonces->patchEntity($annonce, $data);
            if ($this->Annonces->save($annonce)) {
                echo json_encode(['success' => true]);
                exit;
            }

            echo json_encode(['success' => false]);
            exit;
        }
	}
	/**
	 * 
	 */
	public function calendarAddEarlyBooking()
    {
        if ($this->request->params['isAjax']) {
            $this->loadModel("Annonces");
            $annonce = $this->Annonces->get($this->request->data['annonce_id']);

            $data = (isset($this->request->data['proposerearlybooking']) && $this->request->data['delaisearly'] != 0 && $this->request->data['montantearlybooking'] != 0) ? [
                'updated_at'           => Time::now(),
                'proposerearlybooking' => 1,
                'delaisearly'          => $this->request->data['delaisearly'],
                'montantearlybooking'  => $this->request->data['montantearlybooking']
            ] : [
                'updated_at'           => Time::now(),
                'proposerearlybooking' => 0,
                'delaisearly'          => 0,
                'montantearlybooking'  => 0
            ];

            $annonce = $this->Annonces->patchEntity($annonce, $data);
            if ($this->Annonces->save($annonce)) {
                echo json_encode(['success' => true]);
                exit;
            }

            echo json_encode(['success' => false]);
            exit;
        }
	}

	/**
	 * 
	 */
	public function calendarAddLongSejour()
    {
        if ($this->request->params['isAjax']) {
            $this->loadModel("Annonces");
            $annonce = $this->Annonces->get($this->request->data['annonce_id']);

            $data = (isset($this->request->data['proposerlongsejours']) && $this->request->data['delaislongsejours'] != 0 && $this->request->data['montantlongsejours'] != 0) ? [
                'updated_at'          => Time::now(),
                'proposerlongsejours' => 1,
                'delaislongsejours'   => $this->request->data['delaislongsejours'],
                'montantlongsejours'  => $this->request->data['montantlongsejours']
            ] : [
                'updated_at'          => Time::now(),
                'proposerlongsejours' => 0,
                'delaislongsejours'   => 0,
                'montantlongsejours'  => 0
            ];

            $annonce = $this->Annonces->patchEntity($annonce, $data);
            if ($this->Annonces->save($annonce)) {
                echo json_encode(['success' => true]);
                exit;
            }

            echo json_encode(['success' => false]);
            exit;
        }
	}
	/**
	 * 
	 */
	public function calendarAddParametres(){
		$this->viewBuilder()->layout(false);
		$enregistrement = "non";
		$this->loadModel("Annonces");
		$annonce = $this->Annonces->get($this->request->data['annonce_id']);
		if(isset($this->request->data['sejour_flexible'])){
			if($this->request->data['sejour_flexible'] != 0){
				$data_sejour=array(
					'updated_at'=>Time::now(),
					'sejour_flexible'=>$this->request->data['sejour_flexible']
				);
				$annonce = $this->Annonces->patchEntity($annonce, $data_sejour);
				if($this->Annonces->save($annonce)) $enregistrement = "oui";
			}
		}
		
		if($enregistrement == "oui") $this->Flash->success(__('Les modifications sur votre annonce ont bien été sauvegardées'),['clear'=> true]);


		$session = $this->request->session();
		if($session->read('Config.language') != "fr_FR"){
			$this->loadModel("Languages");
			$language_header_name = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();
			$urlLang = $language_header_name->url_code."/";
		} else {
			$urlLang = "";
		}
		$this->loadModel("Urlmultilingue");
		$urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
		$urlvaluemulti = [];
		foreach ($urlmultilinguelistes as $urlmultilingueliste) {
			$urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
		}
		return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['dispos']."/view/".$this->request->data['annonce_id']."/".$this->request->data['dbt_at']);
		$this->autoRender = false;
	}

    /**
     * @param  array $newData
     * @param  string $periodStartDate //date string yyyy-MM-dd
     * @param  string $periodEndDate
     * @return bool
     */
    private function createNewDispo($newData = [], $periodStartDate = '', $periodEndDate = '')
    {
        file_put_contents(PATH_ALPISSIME."debug",print_r("function createNewDispo\n",true),FILE_APPEND);

        file_put_contents(PATH_ALPISSIME."debug",print_r("periodStartDate = ",true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r($periodStartDate,true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);

        file_put_contents(PATH_ALPISSIME."debug",print_r("periodEndDate = ",true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r($periodEndDate,true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r("newData = ",true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r($newData,true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
        try {
            $dispos = $this->Dispos->getDisposForPeroid($newData['annonce_id'], $periodStartDate, $periodEndDate);
            if ($dispos->count() == 0) {
                $newDispo = $this->Dispos->newEntity($newData);
                return $this->Dispos->save($newDispo) ? true : false;
            }
        } catch (\Exception $e) {
            file_put_contents(PATH_ALPISSIME."debug",print_r("error = ",true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r($e->getMessage(),true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
        }

        return false;
    }

    /**
     *
     */
    public function calendarAddNew_()
    {
//                @unlink(PATH_ALPISSIME."debug");
        file_put_contents(PATH_ALPISSIME."debug",print_r("function calendarAddNew\n",true),FILE_APPEND);
        $this->viewBuilder()->layout(false);

        $this->set("datedajout", date("Y-m-d", strtotime($this->request->data['dbt_at'])));
        $da_debut = date("Y-m-d", strtotime($this->request->data['dbt_at']));
        $da_fin = date("Y-m-d", strtotime($this->request->data['fin_at']));

        $dispos = $this->Dispos->getDisposForPeroid($this->request->data['annonce_id'], $da_debut, $da_fin);
        if ($this->request->data['promo_jour'] == '' || $this->request->data['promo_jour'] == 0) {
            $propyn = 0;
            $promo_jour = 0;
        } else {
            $propyn = 1;
            $promo_jour = $this->request->data['promo_jour'];
        }

        $saved = false;
        if ($this->request->data['prix_jour'] != 0) {
            if ($dispos->count() == 0) {
                $newData = isset($this->request->data['statutdispo']) ? [
                    'annonce_id' => $this->request->data['annonce_id'],
                    'created_at' => $this->toDate(date('d-m-Y')),
                    'updated_at' => Time::now(),
                    'dbt_at'     => $this->toDate($this->request->data['dbt_at']),
                    'fin_at'     => $this->toDate($this->request->data['fin_at']),
                    'statut'     => self::AVAILABLE,
                    'promo_yn'   => $propyn,
                    'nbr_jour'   => $this->request->data['nbr_jour'],
                    'prix_jour'  => $this->request->data['prix_jour'],
                    'promo_jour' => $promo_jour
                ] : [
                    'annonce_id' => $this->request->data['annonce_id'],
                    'created_at' => $this->toDate(date('d-m-Y')),
                    'updated_at' => Time::now(),
                    'dbt_at'     => $this->toDate($this->request->data['dbt_at']),
                    'fin_at'     => $this->toDate($this->request->data['fin_at']),
                    'statut'     => self::NOT_AVAILABLE,
                    'promo_yn'   => $propyn,
                    'nbr_jour'   => 0,
                    'prix_jour'  => 0,
                    'promo_jour' => $promo_jour
                ];

                $saved = $this->createNewDispo($newData, (new Date($da_debut))->i18nFormat('yyyy-MM-dd'), (new Date($da_fin))->i18nFormat('yyyy-MM-dd'));
            } else {
                $dbtperid = new Date($this->request->data['dbt_at']);
                $finperid = new Date($this->request->data['fin_at']);
                $detailresultat = [
                    'debut' => [],
                    'fin' => [],
                    'statut' => [],
                ];
                $orderfin       = [];
                file_put_contents(PATH_ALPISSIME."debug",print_r("statutdispo = ",true),FILE_APPEND);
                file_put_contents(PATH_ALPISSIME."debug",print_r($this->request->data['statutdispo'],true),FILE_APPEND);
                file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);

                file_put_contents(PATH_ALPISSIME."debug",print_r("isset statutdispo = ",true),FILE_APPEND);
                file_put_contents(PATH_ALPISSIME."debug",print_r(isset($this->request->data['statutdispo']),true),FILE_APPEND);
                file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);

                file_put_contents(PATH_ALPISSIME."debug",print_r("empty statutdispo = ",true),FILE_APPEND);
                file_put_contents(PATH_ALPISSIME."debug",print_r(empty($this->request->data['statutdispo']),true),FILE_APPEND);
                file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                foreach ($dispos as $dispo) {
                    file_put_contents(PATH_ALPISSIME."debug",print_r("dispo id = ",true),FILE_APPEND);
                    file_put_contents(PATH_ALPISSIME."debug",print_r($dispo->id,true),FILE_APPEND);
                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);

                    file_put_contents(PATH_ALPISSIME."debug",print_r("dispo->dbt_at = ",true),FILE_APPEND);
                    file_put_contents(PATH_ALPISSIME."debug",print_r($dispo->dbt_at,true),FILE_APPEND);
                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);

                    file_put_contents(PATH_ALPISSIME."debug",print_r("dispo->fin_at = ",true),FILE_APPEND);
                    file_put_contents(PATH_ALPISSIME."debug",print_r($dispo->fin_at,true),FILE_APPEND);
                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                    if (!in_array($dispo->statut, [self::RESERVED, self::OPTIONAL])) { // not reserved or optional
                        file_put_contents(PATH_ALPISSIME."debug",print_r("not reserved or optional\n",true),FILE_APPEND);
                        $dispoEndDate   = new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy'));

                        if (new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) <= $dbtperid) { // selected start date is the same dispo start date or after dispo start date
                            file_put_contents(PATH_ALPISSIME."debug",print_r("selected start date is the same dispo start date or after dispo start date\n",true),FILE_APPEND);
                            if (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) > $finperid) { // selected end date is before dispo end date
                                array_push($detailresultat['debut'], $finperid);
                                array_push($detailresultat['fin'], new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')));
                                array_push($detailresultat['statut'], "a garder partie periode");
                                array_push($orderfin, $finperid);

                                //Update Existing dispo
                                $updateData = [
                                    'updated_at' => Time::now(),
                                    'fin_at'     => $this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
                                    'statut'     => self::NOT_AVAILABLE
                                ];

                                if (!empty($this->request->data['statutdispo'])) {
                                    $updateData['statut']     = self::AVAILABLE;
                                    $updateData['promo_yn']   = $propyn;
                                    $updateData['nbr_jour']   = $this->request->data['nbr_jour'];
                                    $updateData['prix_jour']  = $this->request->data['prix_jour'];
                                    $updateData['promo_jour'] = $promo_jour;
                                }

                                if (new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) < $dbtperid) {
                                    $updateData = [
                                        'updated_at' => Time::now(),
                                        'fin_at'     => $this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
                                    ];
                                }
                                file_put_contents(PATH_ALPISSIME."debug",print_r("updateData = ",true),FILE_APPEND);
                                file_put_contents(PATH_ALPISSIME."debug",print_r($updateData,true),FILE_APPEND);
                                file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                $updatedDispo = $this->Dispos->patchEntity($dispo, $updateData);
                                $saved = $this->Dispos->save($updatedDispo) ? true : false;

                                array_push($detailresultat['debut'], $dbtperid);
                                array_push($detailresultat['fin'], $finperid);
                                array_push($detailresultat['statut'], "a ajouter libre");
                                array_push($orderfin, new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')));

                                if ($finperid > $dbtperid) {
                                    $newData = [
                                        'annonce_id' => $this->request->data['annonce_id'],
                                        'created_at' => $this->toDate(date('d-m-Y')),
                                        'updated_at' => Time::now(),
                                        'dbt_at'     => $this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
                                        'fin_at'     => $this->toDate($dispoEndDate->i18nFormat('dd-MM-yyyy')),
                                        'nbr_jour'   => $dispo->nbr_jour,
                                        'prix_jour'  => $dispo->prix_jour,
                                        'statut'     => $dispo->statut,
                                        'promo_yn'   => $propyn,
                                        'promo_jour' => $promo_jour
                                    ];
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("newData 1 = ",true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r($newData,true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                    $saved = $this->createNewDispo($newData, (new Date($dbtperid))->i18nFormat('yyyy-MM-dd'), (new Date($finperid))->i18nFormat('yyyy-MM-dd'));
                                }

                                if (new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) < $dbtperid) {
                                    if ($finperid > $dbtperid) {
                                        $newData = [
                                            'annonce_id' => $this->request->data['annonce_id'],
                                            'created_at' => $this->toDate(date('d-m-Y')),
                                            'updated_at' => Time::now(),
                                            'dbt_at'     => $this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
                                            'fin_at'     => $this->toDate($dispoEndDate->i18nFormat('dd-MM-yyyy')),
                                            'nbr_jour'   => 0,
                                            'prix_jour'  => 0,
                                            'statut'     => self::NOT_AVAILABLE,
                                            'promo_yn'   => $propyn,
                                            'promo_jour' => $promo_jour
                                        ];

                                        if (!empty($this->request->data['statutdispo'])) {
                                            $newData['statut']     = self::AVAILABLE;
                                            $newData['nbr_jour']   = $this->request->data['nbr_jour'];
                                            $newData['prix_jour']  = $this->request->data['prix_jour'];
                                        }
                                        file_put_contents(PATH_ALPISSIME."debug",print_r("newData 2 = ",true),FILE_APPEND);
                                        file_put_contents(PATH_ALPISSIME."debug",print_r($newData,true),FILE_APPEND);
                                        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                        $saved = $this->createNewDispo($newData, (new Date($dbtperid))->i18nFormat('yyyy-MM-dd'), (new Date($finperid))->i18nFormat('yyyy-MM-dd'));
                                    }
                                }
                            } else { // selected end date is after dispo end date or the same as dispo end date
                                file_put_contents(PATH_ALPISSIME."debug",print_r("selected end date is after dispo end date or the same as dispo end date\n",true),FILE_APPEND);
                                if (new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) == $dbtperid) {  // slected start date the same as dispo start date
                                    array_push($detailresultat['debut'], $dbtperid);
                                    array_push($detailresultat['fin'], new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')));
                                    array_push($detailresultat['statut'], "a modifier libre");
                                    array_push($orderfin, new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')));

                                    $updateData = isset($this->request->data['statutdispo']) ? [
                                        'updated_at' => Time::now(),
                                        'dbt_at'     => $this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
                                        'fin_at'     => $this->toDate($dispo->fin_at->i18nFormat('dd-MM-yyyy')),
                                        'statut'     => self::AVAILABLE,
                                        'promo_yn'   => $propyn,
                                        'nbr_jour'   => $this->request->data['nbr_jour'],
                                        'prix_jour'  => $this->request->data['prix_jour'],
                                        'promo_jour' => $promo_jour
                                    ]: [
                                        'updated_at' => Time::now(),
                                        'dbt_at'     => $this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
                                        'fin_at'     => $this->toDate($dispo->fin_at->i18nFormat('dd-MM-yyyy')),
                                        'statut'     => self::NOT_AVAILABLE
                                    ];

                                    $updatedDispo = $this->Dispos->patchEntity($dispo, $updateData);

                                    if (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) > $dbtperid) {
                                        if ($this->Dispos->save($updatedDispo)) {
                                            $saved = true;
                                        }
                                    }

                                    $dbtperid = new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy'));
                                } else {   // selected start date is after dispo start date
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("selected start date is after dispo start date\n",true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("dbtperid = ",true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r($dbtperid,true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                    $debgardautiliser           = $dbtperid;
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("debgardautiliser = ",true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r($debgardautiliser,true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                    $finavantpatch              = new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy'));
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("finavantpatch = ",true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r($finavantpatch,true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                    array_push($detailresultat['debut'], new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')));
                                    array_push($detailresultat['fin'], $debgardautiliser);
                                    array_push($detailresultat['statut'], "a garder partie periode");
                                    array_push($orderfin, $debgardautiliser);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("detailresultat 1 = ",true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r($detailresultat,true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                    $updateData = [
                                        'updated_at' => Time::now(),
                                        'fin_at'     => $this->toDate($debgardautiliser->i18nFormat('dd-MM-yyyy')),
                                    ];
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("updateData = ",true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r($updateData,true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);

                                    file_put_contents(PATH_ALPISSIME."debug",print_r("dispo 1 = ",true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r($dispo,true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                    $updatedDispo = $this->Dispos->patchEntity($dispo, $updateData);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("dispo 2 = ",true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r($dispo,true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("updatedDispo = ",true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r($updatedDispo,true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                    if ($debgardautiliser > new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy'))) {
                                        if ($this->Dispos->save($updatedDispo))  {
                                            $saved = true;
                                        }
                                    }

                                    array_push($detailresultat['debut'], $dbtperid);
                                    array_push($detailresultat['fin'], $finavantpatch);
                                    array_push($detailresultat['statut'], "a ajouter libre");
                                    array_push($orderfin, $finavantpatch);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("detailresultat 2 = ",true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r($detailresultat,true),FILE_APPEND);
                                    file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                    if ($finavantpatch > $dbtperid) {
                                        $newData = [
                                            'annonce_id' => $this->request->data['annonce_id'],
                                            'created_at' => $this->toDate(date('d-m-Y')),
                                            'updated_at' => Time::now(),
                                            'dbt_at'     => $this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
                                            'fin_at'     => $this->toDate($finavantpatch->i18nFormat('dd-MM-yyyy')),
                                            'statut'     => self::NOT_AVAILABLE,
                                            'promo_yn'   => $propyn,
                                            'nbr_jour'   => 0,
                                            'prix_jour'  => 0,
                                            'promo_jour' => $promo_jour
                                        ];

                                        file_put_contents(PATH_ALPISSIME."debug",print_r("newData 1 = ",true),FILE_APPEND);
                                        file_put_contents(PATH_ALPISSIME."debug",print_r($newData,true),FILE_APPEND);
                                        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);

                                        if (!empty($this->request->data['statutdispo'])) {
                                            $newData['nbr_jour']  = $this->request->data['nbr_jour'];
                                            $newData['prix_jour'] = $this->request->data['prix_jour'];
                                            $newData['statut']    = self::AVAILABLE;
                                            file_put_contents(PATH_ALPISSIME."debug",print_r("newData 2 = ",true),FILE_APPEND);
                                            file_put_contents(PATH_ALPISSIME."debug",print_r($newData,true),FILE_APPEND);
                                            file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                        }


                                        $saved = $this->createNewDispo($newData, (new Date($dbtperid))->i18nFormat('yyyy-MM-dd'), (new Date($dispo->fin_at))->i18nFormat('yyyy-MM-dd'));
                                        file_put_contents(PATH_ALPISSIME."debug",print_r("saved = ",true),FILE_APPEND);
                                        file_put_contents(PATH_ALPISSIME."debug",print_r($saved,true),FILE_APPEND);
                                        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                                    }

//                                    $dbtperid = $finavantpatch;
                                }
                            }
                        } else { // selected start date is before dispo start date
                            $detailresultat['debut'][]  = $dbtperid;
                            $detailresultat['fin'][]    = new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy'));
                            $orderfin[]                 = new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy'));
                            $detailresultat['statut'][] = "a ajouter";

                            if (new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) > $dbtperid) {
                                $newData = isset($this->request->data['statutdispo']) ? [
                                    'annonce_id' => $this->request->data['annonce_id'],
                                    'created_at' => $this->toDate(date('d-m-Y')),
                                    'updated_at' => Time::now(),
                                    'dbt_at'     => $this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
                                    'fin_at'     => $this->toDate($dispo->dbt_at->i18nFormat('dd-MM-yyyy')),
                                    'statut'     => self::AVAILABLE,
                                    'promo_yn'   => $propyn,
                                    'nbr_jour'   => $this->request->data['nbr_jour'],
                                    'prix_jour'  => $this->request->data['prix_jour'],
                                    'promo_jour' => $promo_jour
                                ] : [
                                    'annonce_id' => $this->request->data['annonce_id'],
                                    'created_at' => $this->toDate(date('d-m-Y')),
                                    'updated_at' => Time::now(),
                                    'dbt_at'     => $this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
                                    'fin_at'     => $this->toDate($dispo->dbt_at->i18nFormat('dd-MM-yyyy')),
                                    'statut'     => self::NOT_AVAILABLE,
                                    'promo_yn'   => $propyn,
                                    'nbr_jour'   => 0,
                                    'prix_jour'  => 0,
                                    'promo_jour' => $promo_jour
                                ];

                                $saved = $this->createNewDispo($newData, (new Date($dbtperid))->i18nFormat('yyyy-MM-dd'), $dispo->dbt_at->i18nFormat('yyyy-MM-dd'));
                            }

                            if (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) <= $finperid) { // selected end date is after dispo end date or the same as dispo end date
                                $detailresultat['debut'][]  = new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy'));
                                $detailresultat['fin'][]    = new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy'));
                                $orderfin[]                 = new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy'));
                                $detailresultat['statut'][] = "a modifier libre";

                                $updateData = isset($this->request->data['statutdispo']) ? [
                                    'updated_at' => Time::now(),
                                    'dbt_at'     => $this->toDate($dispo->dbt_at->i18nFormat('dd-MM-yyyy')),
                                    'fin_at'     => $this->toDate($dispo->fin_at->i18nFormat('dd-MM-yyyy')),
                                    'statut'     => self::AVAILABLE,
                                    'promo_yn'   => $propyn,
                                    'nbr_jour'   => $this->request->data['nbr_jour'],
                                    'prix_jour'  => $this->request->data['prix_jour'],
                                    'promo_jour' => $promo_jour
                                ] : [
                                    'updated_at' => Time::now(),
                                    'dbt_at'     => $this->toDate($dispo->dbt_at->i18nFormat('dd-MM-yyyy')),
                                    'fin_at'     => $this->toDate($dispo->fin_at->i18nFormat('dd-MM-yyyy')),
                                    'statut'     => self::NOT_AVAILABLE
                                ];

                                $updatedDispo = $this->Dispos->patchEntity($dispo, $updateData);

                                if (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy'))) {
                                    if ($this->Dispos->save($updatedDispo)) {
                                        $saved = true;
                                    }
                                }

                                $dbtperid = new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy'));
                            } else { // selected end date is before dispo end date
                                $dbtavantpatch = $dispo->dbt_at->i18nFormat('dd-MM-yyyy');
                                $detailresultat['debut'][] = $finperid;
                                $detailresultat['fin'][] = new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy'));
                                $orderfin[] = new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy'));
                                $detailresultat['statut'][] = "a garder partie periode";

                                $updateData = [
                                    'updated_at'=>Time::now(),
                                    'dbt_at'=>$this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
                                ];

                                $updatedDispo = $this->Dispos->patchEntity($dispo, $updateData);

                                if (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) > $finperid) {
                                    if ($this->Dispos->save($updatedDispo)) {
                                        $saved = true;
                                    }
                                }

                                $detailresultat['debut'][] = new Date($dbtavantpatch);
                                $detailresultat['fin'][] = $finperid;
                                $orderfin[] = $finperid;
                                $detailresultat['statut'][] = "a ajouter libre";

                                if ($finperid > new Date($dbtavantpatch)) {
                                    $newData = isset($this->request->data['statutdispo']) ? [
                                        'annonce_id'=>$this->request->data['annonce_id'],
                                        'created_at'=>$this->toDate(date('d-m-Y')),
                                        'updated_at'=>Time::now(),
                                        'dbt_at'=>$this->toDate($dbtavantpatch),
                                        'fin_at'=>$this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
                                        'statut'=>self::AVAILABLE,
                                        'promo_yn'=>$propyn,
                                        'nbr_jour'=> $this->request->data['nbr_jour'],
                                        'prix_jour'=> $this->request->data['prix_jour'],
                                        'promo_jour'=> $promo_jour
                                    ] : [
                                        'annonce_id'=>$this->request->data['annonce_id'],
                                        'created_at'=>$this->toDate(date('d-m-Y')),
                                        'updated_at'=>Time::now(),
                                        'dbt_at'=>$this->toDate($dbtavantpatch),
                                        'fin_at'=>$this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
                                        'statut'=>self::NOT_AVAILABLE,
                                        'promo_yn'=>$propyn,
                                        'nbr_jour'=> 0,
                                        'prix_jour'=> 0,
                                        'promo_jour'=> $promo_jour
                                    ];

                                    $saved = $this->createNewDispo($newData, $dispo->dbt_at->i18nFormat('yyyy-MM-dd'), $finperid->i18nFormat('yyyy-MM-dd'));
                                }
                            }
                        }
                    } else { // dispo is reserved or optional
                        if($dbtperid < new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy'))) { // selected start date is before dispo start date
                            $detailresultat['debut'][] = $dbtperid;
                            $detailresultat['fin'][] = new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy'));
                            $orderfin[] = new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy'));
                            $detailresultat['statut'][] = "a ajouter libre";

                            $newData = isset($this->request->data['statutdispo']) ? [
                                'annonce_id'=>$this->request->data['annonce_id'],
                                'created_at'=>$this->toDate(date('d-m-Y')),
                                'updated_at'=>Time::now(),
                                'dbt_at'=>$this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
                                'fin_at'=>$this->toDate($dispo->dbt_at->i18nFormat('dd-MM-yyyy')),
                                'statut'=>self::AVAILABLE,
                                'promo_yn'=>$propyn,
                                'nbr_jour'=> $this->request->data['nbr_jour'],
                                'prix_jour'=> $this->request->data['prix_jour'],
                                'promo_jour'=> $promo_jour
                            ] : [
                                'annonce_id'=>$this->request->data['annonce_id'],
                                'created_at'=>$this->toDate(date('d-m-Y')),
                                'updated_at'=>Time::now(),
                                'dbt_at'=>$this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
                                'fin_at'=>$this->toDate($dispo->dbt_at->i18nFormat('dd-MM-yyyy')),
                                'statut'=>self::NOT_AVAILABLE,
                                'promo_yn'=>$propyn,
                                'nbr_jour'=> 0,
                                'prix_jour'=> 0,
                                'promo_jour'=> $promo_jour
                            ];

                            $saved = $this->createNewDispo($newData, (new Date($dbtperid))->i18nFormat('yyyy-MM-dd'), $dispo->dbt_at->i18nFormat('yyyy-MM-dd'));
                        }

                        $dbtperid = new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy'));
                    }
                }

                rsort($orderfin);
                file_put_contents(PATH_ALPISSIME."debug",print_r("orderfin = ",true),FILE_APPEND);
                file_put_contents(PATH_ALPISSIME."debug",print_r($orderfin,true),FILE_APPEND);
                file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);

                file_put_contents(PATH_ALPISSIME."debug",print_r("detailresultat = ",true),FILE_APPEND);
                file_put_contents(PATH_ALPISSIME."debug",print_r($detailresultat,true),FILE_APPEND);
                file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);

                file_put_contents(PATH_ALPISSIME."debug",print_r("dbtperid = ",true),FILE_APPEND);
                file_put_contents(PATH_ALPISSIME."debug",print_r($dbtperid,true),FILE_APPEND);
                file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
                if (!in_array($dbtperid, $detailresultat['debut'])) { // detailresultat['debut'] doesn't contain selected start date
                    file_put_contents(PATH_ALPISSIME."debug",print_r("detailresultat['debut'] doesn't contain selected start date\n",true),FILE_APPEND);
                    if ($finperid > $dbtperid) {
                        $detailresultat['fin'][] = $finperid;

                        if (isset($this->request->data['statutdispo'])) {
                            $detailresultat['statut'][] = "a ajouter libre";

                            $newData = [
                                'annonce_id'=>$this->request->data['annonce_id'],
                                'created_at'=>$this->toDate(date('d-m-Y')),
                                'updated_at'=>Time::now(),
                                'dbt_at'=>$this->toDate($dbtperid),
                                'fin_at'=>$this->toDate($finperid),
                                'statut'=>self::AVAILABLE,
                                'promo_yn'=>$propyn,
                                'nbr_jour'=> $this->request->data['nbr_jour'],
                                'prix_jour'=> $this->request->data['prix_jour'],
                                'promo_jour'=> $promo_jour
                            ];
                        } else {
                            $detailresultat['debut'][] = $orderfin[0];
                            $detailresultat['fin'][] = $finperid;
                            $detailresultat['statut'][] = "a ajouter indispo";

                            $newData = [
                                'annonce_id'=>$this->request->data['annonce_id'],
                                'created_at'=>$this->toDate(date('d-m-Y')),
                                'updated_at'=>Time::now(),
                                'dbt_at'=>$this->toDate($dbtperid),
                                'fin_at'=>$this->toDate($finperid),
                                'statut'=>self::NOT_AVAILABLE,
                                'promo_yn'=>$propyn,
                                'nbr_jour'=> 0,
                                'prix_jour'=> 0,
                                'promo_jour'=> $promo_jour
                            ];
                        }

                        $saved = $this->createNewDispo($newData, $dbtperid->i18nFormat('yyyy-MM-dd'), $finperid->i18nFormat('yyyy-MM-dd'));
                    }
                }

                if (!in_array($finperid, $detailresultat['fin'])) {
                    if ($finperid > $orderfin[0]) {
                        if (isset($this->request->data['statutdispo'])) {
                            $detailresultat['statut'][] = "a ajouter libre";

                            $newData = [
                                'annonce_id'=>$this->request->data['annonce_id'],
                                'created_at'=>$this->toDate(date('d-m-Y')),
                                'updated_at'=>Time::now(),
                                'dbt_at'=>$this->toDate($orderfin[0]),
                                'fin_at'=>$this->toDate($finperid),
                                'statut'=>self::AVAILABLE,
                                'promo_yn'=>$propyn,
                                'nbr_jour'=> $this->request->data['nbr_jour'],
                                'prix_jour'=> $this->request->data['prix_jour'],
                                'promo_jour'=> $promo_jour
                            ];
                        } else {
                            $detailresultat['debut'][] = $orderfin[0];
                            $detailresultat['fin'][] = $finperid;
                            $detailresultat['statut'][] = "a ajouter indispo";

                            $newData = [
                                'annonce_id'=>$this->request->data['annonce_id'],
                                'created_at'=>$this->toDate(date('d-m-Y')),
                                'updated_at'=>Time::now(),
                                'dbt_at'=>$this->toDate($orderfin[0]),
                                'fin_at'=>$this->toDate($finperid),
                                'statut'=>self::NOT_AVAILABLE,
                                'promo_yn'=>$propyn,
                                'nbr_jour'=> 0,
                                'prix_jour'=> 0,
                                'promo_jour'=> $promo_jour
                            ];
                        }

                        $saved = $this->createNewDispo($newData, $orderfin[0]->i18nFormat('yyyy-MM-dd'), $finperid->i18nFormat('yyyy-MM-dd'));
                    }
                }
            }

            if ($saved) {
                /*** Update Annonce ***/
                $this->loadModel("Annonces");
                $annonce = $this->Annonces->get($this->request->data['annonce_id']);
                $annonce = $this->Annonces->patchEntity($annonce, ['updated_at'=>Time::now()]);
                $this->Annonces->save($annonce);
                $this->Flash->success(__('Votre Période a été créée'),['clear'=> true]);
            } else {
                $this->Flash->error(__('Période non modifiée'),['clear'=> true]);
            }
        } else {
            $this->Flash->error(__('Période non modifiée'),['clear'=> true]);
        }

        $urlLang       = $this->getLanguage();
        $urlvaluemulti = $this->getUrlmulti();

        return $this->redirect(SITE_ALPISSIME . $urlLang . $urlvaluemulti['dispos'] . "/view/" . $this->request->data['annonce_id']. "/" . $this->request->data['dbt_at']);
        $this->autoRender = false;
    }

    public function calendarAddNew()
    {
        $this->viewBuilder()->layout(false);

        if ($this->request->data['prix_jour'] != 0) {
            $this->set("datedajout", date("Y-m-d", strtotime($this->request->data['dbt_at'])));

            $da_debut = date("Y-m-d", strtotime($this->request->data['dbt_at']));
            $da_fin   = date("Y-m-d", strtotime($this->request->data['fin_at']));

            $dispos = $this->Dispos->getDisposForPeroid($this->request->data['annonce_id'], $da_debut, $da_fin);

            if ($this->request->data['promo_jour'] == '' || $this->request->data['promo_jour'] == 0) {
                $propyn = 0;
                $promo_jour = 0;
            } else {
                $propyn = 1;
                $promo_jour = $this->request->data['promo_jour'];
            }

            $status     = !empty($this->request->data['statutdispo']) ? self::AVAILABLE : self::NOT_AVAILABLE;
            $insertData = [];
            $disposIds  = [];
            $dbtperid   = new Date($this->request->data['dbt_at']);
            $finperid   = new Date($this->request->data['fin_at']);

            if ($dispos->count() == 0) {
                array_push($insertData, [
                    'annonce_id'     => $this->request->data['annonce_id'],
                    'created_at'     => $this->toDate(date('d-m-Y')),
                    'updated_at'     => Time::now(),
                    'dbt_at'         => $this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
                    'fin_at'         => $this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
                    'statut'         => $status,
                    'promo_yn'       => $propyn,
                    'nbr_jour'       => $this->request->data['nbr_jour'],
                    'prix_jour'      => $this->request->data['prix_jour'],
                    'promo_jour'     => $promo_jour
                ]);
            } else {
                $disposArr  = $dispos->toArray();

                $reservedOrOptionalDispos = array_values(array_filter($disposArr, function ($dispo) {
                    return in_array($dispo->statut, [self::RESERVED, self::OPTIONAL]);
                }));

                $disposArr = array_filter($disposArr, function ($dispo) {
                    return !in_array($dispo->statut, [self::RESERVED, self::OPTIONAL]);
                });

                if (empty($reservedOrOptionalDispos)) {
                    $checkExisting = array_filter($insertData, function ($data) use ($dbtperid, $finperid) {
                        return (new Date($data['start_date']) == new Date($dbtperid) && new Date($data['end_date']) == new Date($finperid));
                    });

                    if (empty($checkExisting)) {
                        array_push($insertData, [
                            'annonce_id' => $this->request->data['annonce_id'],
                            'created_at' => $this->toDate(date('d-m-Y')),
                            'updated_at' => Time::now(),
                            'start_date' => new Date($dbtperid),
                            'end_date' => new Date($finperid),
                            'dbt_at' => $this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
                            'fin_at' => $this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
                            'statut' => $status,
                            'promo_yn' => $propyn,
                            'nbr_jour' => $this->request->data['nbr_jour'],
                            'prix_jour' => $this->request->data['prix_jour'],
                            'promo_jour' => $promo_jour
                        ]);
                    }
                } else {
                    $dispoFinAt = new Date($reservedOrOptionalDispos[0]->fin_at);
                    $startDate = new Date($dbtperid);
                    foreach ($reservedOrOptionalDispos as $dispo) {
                        if (new Date($dispo->dbt_at) > new Date($startDate)) {
                            $checkExisting = array_filter($insertData, function ($data) use ($startDate, $dispo) {
                                return (new Date($data['start_date']) == new Date($startDate) && new Date($data['end_date']) == new Date($dispo->dbt_at));
                            });

                            if (empty($checkExisting)) {
                                array_push($insertData, [
                                    'annonce_id' => $this->request->data['annonce_id'],
                                    'created_at' => $this->toDate(date('d-m-Y')),
                                    'updated_at' => Time::now(),
                                    'start_date' => new Date($startDate),
                                    'end_date' => new Date($dispo->dbt_at),
                                    'dbt_at' => $this->toDate($startDate->i18nFormat('dd-MM-yyyy')),
                                    'fin_at' => $this->toDate($dispo->dbt_at->i18nFormat('dd-MM-yyyy')),
                                    'statut' => $status,
                                    'promo_yn' => $propyn,
                                    'nbr_jour' => $this->request->data['nbr_jour'],
                                    'prix_jour' => $this->request->data['prix_jour'],
                                    'promo_jour' => $promo_jour
                                ]);
                            }
                        }
                        $startDate = new Date($dispo->fin_at);
                        $dispoFinAt = new Date($dispo->fin_at);
                    }

                    if (new Date($dispoFinAt) < new Date($finperid)) {
                        $checkExisting = array_filter($insertData, function ($data) use ($dispoFinAt, $finperid) {
                            return (new Date($data['start_date']) == new Date($dispoFinAt) && new Date($data['end_date']) == new Date($finperid));
                        });

                        if (empty($checkExisting)) {
                            array_push($insertData, [
                                'annonce_id' => $this->request->data['annonce_id'],
                                'created_at' => $this->toDate(date('d-m-Y')),
                                'updated_at' => Time::now(),
                                'start_date' => new Date($dispoFinAt),
                                'end_date' => new Date($finperid),
                                'dbt_at' => $this->toDate($dispoFinAt->i18nFormat('dd-MM-yyyy')),
                                'fin_at' => $this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
                                'statut' => $status,
                                'promo_yn' => $propyn,
                                'nbr_jour' => $this->request->data['nbr_jour'],
                                'prix_jour' => $this->request->data['prix_jour'],
                                'promo_jour' => $promo_jour
                            ]);
                        }
                    }
                }

                $disposIds = array_column($disposArr, 'id');
                foreach ($disposArr as $dispo) {
                    if (new Date($dispo->dbt_at) < new Date($dbtperid)) {
                        $checkExisting = array_filter($insertData, function ($data) use ($dispo, $dbtperid) {
                            return (new Date($data['start_date']) == new Date($dispo->dbt_at) && new Date($data['end_date']) == new Date($dbtperid));
                        });

                        if (empty($checkExisting)) {
                            array_push($insertData, [
                                'annonce_id' => $this->request->data['annonce_id'],
                                'created_at' => $this->toDate(date('d-m-Y')),
                                'updated_at' => Time::now(),
                                'start_date' => new Date($dispo->dbt_at),
                                'end_date' => new Date($dbtperid),
                                'dbt_at' => $this->toDate($dispo->dbt_at->i18nFormat('dd-MM-yyyy')),
                                'fin_at' => $this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
                                'prix' => $dispo->prix,
                                'statut' => $dispo->statut,
                                'utilisateur_id' => $dispo->utilisateur_id,
                                'promo_yn' => $dispo->promo_yn,
                                'reservation_id' => $dispo->reservation_id,
                                'promo_px' => $dispo->promo_px,
                                'nbr_jour' => $dispo->nbr_jour,
                                'conditionnbr' => $dispo->conditionnbr,
                                'prix_jour' => $dispo->prix_jour,
                                'promo_jour' => $dispo->promo_jour,
                                'calendarsynchro_id' => $dispo->calendarsynchro_id,
                                'doubleperiodesynchro' => $dispo->doubleperiodesynchro
                            ]);
                        }
                    }

                    if (new Date($dispo->fin_at) > new Date($finperid)) {
                        $checkExisting = array_filter($insertData, function ($data) use ($finperid, $dispo) {
                            return (new Date($data['start_date']) == new Date($finperid) && new Date($data['end_date']) == new Date($dispo->fin_at));
                        });

                        if (empty($checkExisting)) {
                            array_push($insertData, [
                                'annonce_id' => $this->request->data['annonce_id'],
                                'created_at' => $this->toDate(date('d-m-Y')),
                                'updated_at' => Time::now(),
                                'start_date' => new Date($finperid),
                                'end_date' => new Date($dispo->fin_at),
                                'dbt_at' => $this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
                                'fin_at' => $this->toDate($dispo->fin_at->i18nFormat('dd-MM-yyyy')),
                                'prix' => $dispo->prix,
                                'statut' => $dispo->statut,
                                'utilisateur_id' => $dispo->utilisateur_id,
                                'promo_yn' => $dispo->promo_yn,
                                'reservation_id' => $dispo->reservation_id,
                                'promo_px' => $dispo->promo_px,
                                'nbr_jour' => $dispo->nbr_jour,
                                'conditionnbr' => $dispo->conditionnbr,
                                'prix_jour' => $dispo->prix_jour,
                                'promo_jour' => $dispo->promo_jour,
                                'calendarsynchro_id' => $dispo->calendarsynchro_id,
                                'doubleperiodesynchro' => $dispo->doubleperiodesynchro
                            ]);
                        }
                    }
                }
            }

            $saved = false;
            if (!empty($insertData)) {
                if (!empty($disposIds)) {
                    $this->Dispos->deleteAll(['id IN' => $disposIds]);
                }

                foreach ($insertData as $data) {
                    try {
                        $newDispo = $this->Dispos->newEntity($data);
                        $this->Dispos->save($newDispo);
                    } catch (\Exception $e) {
                        break;
                    }
                }
                $saved = true;
            }

            if ($saved) {
                /*** Update Annonce ***/
                $this->loadModel("Annonces");
                $annonce = $this->Annonces->get($this->request->data['annonce_id']);
                $annonce = $this->Annonces->patchEntity($annonce, ['updated_at'=>Time::now()]);
                $this->Annonces->save($annonce);
                $this->Flash->success(__('Votre Période a été créée'),['clear'=> true]);
            } else {
                $this->Flash->error(__('Période non modifiée'),['clear'=> true]);
            }
        } else {
            $this->Flash->error(__('Période non modifiée'),['clear'=> true]);
        }

        $urlLang       = $this->getLanguage();
        $urlvaluemulti = $this->getUrlmulti();

        return $this->redirect(SITE_ALPISSIME . $urlLang . $urlvaluemulti['dispos'] . "/view/" . $this->request->data['annonce_id']. "/" . $this->request->data['dbt_at']);
        $this->autoRender = false;
    }

	public function calendarAdd(){

		if(isset($this->request->data['statutdispo'])) {
			$deb = explode('-', $this->request->data['dbt_at']);
			$fin = explode('-', $this->request->data['fin_at']);
			$s = strtotime( $fin[2] . '-' . $fin[1] . '-' . $fin[0])-strtotime($deb[2] . '-' . $deb[1] . '-' . $deb[0]);
			$d = intval($s/86400)+1;
			$exist=false;
			for($i=0;$i<$d;$i++){
				if($i==0) $da_debut=$deb[2] . '-' . $deb[1] . '-' . $deb[0];
				else {
					$da_debut=date("Y-m-d", mktime(0, 0, 0, $deb[1]  , ($deb[0]+$i), $deb[2]));
				}
				if($i==0){
					$da_fin = new Date($da_debut);
					$da_fin->modify('+1 days');
					$da_fin = $da_fin->i18nFormat('yyyy-MM-dd');
					$data = $this->Dispos->find("all",["conditions"=>["Dispos.annonce_id"=>$this->request->data['annonce_id'],"Dispos.dbt_at < '$da_debut'","Dispos.fin_at > '$da_debut'"]])->orWhere(["(Dispos.annonce_id = ".$this->request->data['annonce_id']." AND Dispos.dbt_at = '".$da_debut."' AND Dispos.fin_at = '".$da_fin."')"]);
				}else{
					$data = $this->Dispos->find("all",["conditions"=>["Dispos.annonce_id"=>$this->request->data['annonce_id'],"Dispos.dbt_at < '$da_debut'","Dispos.fin_at > '$da_debut'"]]);
				}			
				if (!empty($data->first())) {
					 $date_f=$deb[2] . '-' . $deb[1] . '-' . $deb[0];
					$r_disp=$data->first();
					if(strtotime($r_disp->fin_at)==strtotime($date_f)) $exist=false;
					else {
						$exist=true;
						break;
					}
				}
			}
	
			if (!$exist) {
				if($this->request->data['promo_jour'] == '' || $this->request->data['promo_jour'] == 0) $propyn = 0;
				else $propyn = 1;
				
				if($this->request->data['nbr_jour'] == 7){
					$nbrcondjour = $this->request->data['condition7'];
				}else{
					$nbrcondjour = 0;
				}
				$prixjouredit = str_replace(' €', '', $this->request->data['promo_jour']);
				if($prixjouredit == '') $prixjouredit = 0;
	
				$prixperiodeedit = str_replace(' €', '', $this->request->data['promo_px']);
				if($prixperiodeedit == '') $prixperiodeedit = 0;
	
				$s_data=array(	'annonce_id'=>$this->request->data['annonce_id'],
					'created_at'=>$this->toDate(date('d-m-Y')),
					'updated_at'=>Time::now(),
					'dbt_at'=>$this->toDate($this->request->data['dbt_at']),
					'fin_at'=>$this->toDate($this->request->data['fin_at']),
					'prix'=>str_replace(' €', '', $this->request->data['prix']),
					'statut'=>$this->request->data['statut'],
					'promo_yn'=>$propyn,
					'nbr_jour'=> $this->request->data['nbr_jour'],
					'conditionnbr'=> $nbrcondjour,
					'prix_jour'=> str_replace(' €', '', $this->request->data['prix_jour']),
					'promo_jour'=> $prixjouredit,
					'promo_px'=> $prixperiodeedit);
				$dispo = $this->Dispos->newEntity($s_data);
	
				if ($this->Dispos->save($dispo)) {
					/*** Update Annonce ***/
					$this->loadModel("Annonces");
					$annonce = $this->Annonces->get($this->request->data['annonce_id']);
					$data=array('updated_at'=>Time::now());
					$annonce = $this->Annonces->patchEntity($annonce, $data);
					$this->Annonces->save($annonce);
					$this->Flash->success(__('Votre Période a été créée'),['clear'=> true]);
				}
			} else {
				$this->Flash->error(__('Cette  Période existe déja'),['clear'=> true]);
			}
		}else{
			$s_data=array( 'annonce_id'=>$this->request->data['annonce_id'],
				'created_at'=>$this->toDate(date('d-m-Y')),
				'updated_at'=>Time::now(),
				'dbt_at'=>$this->toDate($this->request->data['dbt_at']),
				'fin_at'=>$this->toDate($this->request->data['fin_at']),
				'statut'=>100);
			$dispo = $this->Dispos->newEntity($s_data);

			if ($this->Dispos->save($dispo)) {
				/*** Update Annonce ***/
				$this->loadModel("Annonces");
				$annonce = $this->Annonces->get($this->request->data['annonce_id']);
				$data=array('updated_at'=>Time::now());
				$annonce = $this->Annonces->patchEntity($annonce, $data);
				$this->Annonces->save($annonce);
				$this->Flash->success(__('Votre Période a été créée'),['clear'=> true]);
			}
		}
		
		$session = $this->request->session();
		if($session->read('Config.language') != "fr_FR"){
			$this->loadModel("Languages");
			$language_header_name = $this->Languages->find("all")->where(['code' => $session->read('Config.language')])->first();
			$urlLang = $language_header_name->url_code."/";
		} else {
			$urlLang = "";
		}
		$this->loadModel("Urlmultilingue");
		$urlmultilinguelistes = $this->Urlmultilingue->find('translations', ['locales' => [$session->read('Config.language')]]);
		$urlvaluemulti = [];
		foreach ($urlmultilinguelistes as $urlmultilingueliste) {
			$urlvaluemulti[$urlmultilingueliste->name_key] = $urlmultilingueliste->_translations[$session->read('Config.language')]->name_value;
		}

		return $this->redirect(SITE_ALPISSIME.$urlLang.$urlvaluemulti['dispos']."/view/".$this->request->data['annonce_id']."/".$this->request->data['dbt_at']);
		$this->autoRender = false;
	}
	/**
	 * 
	 */
	public function calendarAddResMan()
	{
		$deb = explode('-', $this->request->data['dbt_at']);
		$fin = explode('-', $this->request->data['fin_at']);
		$s = strtotime( $fin[2] . '-' . $fin[1] . '-' . $fin[0])-strtotime($deb[2] . '-' . $deb[1] . '-' . $deb[0]);
		$d = intval($s/86400)+1;
		$exist=false;
		for($i=0;$i<$d;$i++){
			if($i==0) $da_debut=$deb[2] . '-' . $deb[1] . '-' . $deb[0];
			else {
				$da_debut=date("Y-m-d", mktime(0, 0, 0, $deb[1]  , ($deb[0]+$i), $deb[2]));
			}
			if($i==0){
				$da_fin = new Date($da_debut);
				$da_fin->modify('+1 days');
				$da_fin = $da_fin->i18nFormat('yyyy-MM-dd');
				$data = $this->Dispos->find("all",["conditions"=>["Dispos.annonce_id"=>$this->request->data['annonce_id'],"Dispos.dbt_at < '$da_debut'","Dispos.fin_at > '$da_debut'"]])->orWhere(["(Dispos.annonce_id = ".$this->request->data['annonce_id']." AND Dispos.dbt_at = '".$da_debut."' AND Dispos.fin_at = '".$da_fin."')"]);
			}else{
				$data = $this->Dispos->find("all",["conditions"=>["Dispos.annonce_id"=>$this->request->data['annonce_id'],"Dispos.dbt_at < '$da_debut'","Dispos.fin_at > '$da_debut'"]]);
			}
			if (!empty($data->first())) {
	 			$date_f=$deb[2] . '-' . $deb[1] . '-' . $deb[0];
				$r_disp=$data->first();
				if(strtotime($r_disp->fin_at)==strtotime($date_f)) $exist=false;
				else {
					$exist=true;
					break;
				}
			}
		}

		if (!$exist) {
			if(str_replace(' €', '', $this->request->data['promo_px']) == '' || str_replace(' €', '', $this->request->data['promo_jour']) == ''){
				$propyn = 0;
			}else{
				$propyn = 1;
			}
			if($this->request->data['nbr_jour'] == 7){
				$nbrcondjour = $this->request->data['condition7'];
			}else{
				$nbrcondjour = 0;
			}
			$prixjouredit = str_replace(' €', '', $this->request->data['promo_jour']);
			if($prixjouredit == '') $prixjouredit = 0;

			$prixperiodeedit = str_replace(' €', '', $this->request->data['promo_px']);
			if($prixperiodeedit == '') $prixperiodeedit = 0;

			$s_data=array(	'annonce_id'=>$this->request->data['annonce_id'],
				'created_at'=>$this->toDate(date('d-m-Y')),
				'updated_at'=>Time::now(),
				'dbt_at'=>$this->toDate($this->request->data['dbt_at']),
				'fin_at'=>$this->toDate($this->request->data['fin_at']),
				'prix'=>str_replace(' €', '', $this->request->data['prix']),
				'statut'=>$this->request->data['statut'],
				'promo_yn'=>$propyn,
				'nbr_jour'=> $this->request->data['nbr_jour'],
				'conditionnbr'=> $nbrcondjour,
				'prix_jour'=> str_replace(' €', '', $this->request->data['prix_jour']),
				'promo_jour'=> $prixjouredit,
				'promo_px'=> $prixperiodeedit);
			$dispo = $this->Dispos->newEntity($s_data);

			if ($this->Dispos->save($dispo)) {
				/*** Update Annonce ***/
				$this->loadModel("Annonces");
				$annonce = $this->Annonces->get($this->request->data['annonce_id']);
				$data=array('updated_at'=>Time::now());
				$annonce = $this->Annonces->patchEntity($annonce, $data);
				$this->Annonces->save($annonce);
				$this->set("msg", "OK");
				// $this->Flash->success(__('Votre Période a été créée'),['clear'=> true]);
			}
		} else {
			$this->set("msg", "NO");
			// $this->Flash->error(__('Cette  Période existe déja'),['clear'=> true]);
		}
		// return $this->redirect(['controller'=>'dispos','action' => 'view', $this->request->data['annonce_id'], $this->request->data['dbt_at']]);
		$this->autoRender = false;
	}
  /**
   * Add method
   *
   * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
   */
  public function add(){
		$dispo = $this->Dispos->newEntity();
    if ($this->request->is('post')) {
        $dispo = $this->Dispos->patchEntity($dispo, $this->request->data);
        if ($this->Dispos->save($dispo)) {
            // $this->Flash->success(__('The dispo has been saved.'),['clear'=> true]);
            return $this->redirect(['action' => 'index']);
        } else {
            // $this->Flash->error(__('The dispo could not be saved. Please, try again.'),['clear'=> true]);
        }
    }
    $annonces = $this->Dispos->Annonces->find('list', ['limit' => 200]);
    $utilisateurs = $this->Dispos->Utilisateurs->find('list', ['limit' => 200]);
    $reservations = $this->Dispos->Reservations->find('list', ['limit' => 200]);
    $this->set(compact('dispo', 'annonces', 'utilisateurs', 'reservations'));
    $this->set('_serialize', ['dispo']);
  }
  /**
   * Edit method
   *
   * @param string|null $id Dispo id.
   * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Network\Exception\NotFoundException When record not found.
   */
  public function edit($ids = null){
		$ar = explode('_', $ids);
    $id = $ar[0];
    $dispo = $this->Dispos->get($id, ['contain' => []]);
    if (!$id && empty($this->request->data['dbt_at'])) {
        $this->Flash->error(__("Période invalide"),['clear'=> true]);
        return $this->redirect(["controller" => "utilisateurs","action"=>"index"]);
    }
    if (!empty($this->request->data['dbt_at'])) {
      if (isset($this->request->data['valider']) && $this->request->data['valider'] == "Valider") {
				$deb = explode('/', $this->request->data['dbt_at']);
				$fin = explode('/', $this->request->data['fin_at']);
				$s = strtotime( $fin[2] . '-' . $fin[1] . '-' . $fin[0])-strtotime($deb[2] . '-' . $deb[1] . '-' . $deb[0]);
				$d = intval($s/86400)+1;
				$exist=false;
				for($i=0;$i<$d;$i++){
					if($i==0) $da_debut=$deb[2] . '-' . $deb[1] . '-' . $deb[0];
					else {
					 $da_debut=date("Y-m-d", mktime(0, 0, 0, $deb[1]  , ($deb[0]+$i), $deb[2]));
					}
					if($i==0){
						$da_fin = new Date($da_debut);
						$da_fin->modify('+1 days');
						$da_fin = $da_fin->i18nFormat('yyyy-MM-dd');
						$data = $this->Dispos->find("all",["conditions"=>["Dispos.annonce_id"=>$this->request->data['annonce_id'],"Dispos.id != '$id'","Dispos.dbt_at < '$da_debut'","Dispos.fin_at > '$da_debut'"]])->orWhere(["(Dispos.annonce_id = ".$this->request->data['annonce_id']." AND Dispos.id != ".$id." AND Dispos.dbt_at = '".$da_debut."' AND Dispos.fin_at = '".$da_fin."')"]);
					}else{
						$data = $this->Dispos->find("all",["conditions"=>["Dispos.annonce_id"=>$this->request->data['annonce_id'],"Dispos.id != '$id'","Dispos.dbt_at < '$da_debut'","Dispos.fin_at > '$da_debut'"]]);
					}
					if (!empty($data->first())) {
						 $date_f=$deb[2] . '-' . $deb[1] . '-' . $deb[0];
						$r_disp=$data->first();
						if(strtotime($r_disp->fin_at)==strtotime($date_f)) $exist=false;
						else {
							$exist=true;
							break;
						}
					}
				}
				if(!$exist){
					$s_data=array(	'updated_at'=>Time::now(),
						'dbt_at'=>$this->toDate($this->request->data['dbt_at']),
						'fin_at'=>$this->toDate($this->request->data['fin_at']),
						'prix'=>$this->request->data['prix'],
						'statut'=>$this->request->data['statut'],
						'promo_yn'=>$this->request->data['promo_yn'],
						'promo_px'=>$this->request->data['promo_px']);
					$dispo = $this->Dispos->patchEntity($dispo, $s_data);
          if ($this->Dispos->save($dispo)) {
              $this->Flash->success(__('Période modifiée'),['clear'=> true]);
              return $this->redirect(['controller'=>'dispos','action' => 'view', $this->request->data['annonce_id']]);
          } else {
              $this->Flash->error(__('Période non modifiée'),['clear'=> true]);
              return $this->redirect(['controller'=>'dispos','action' => 'edit', $this->request->data['ids']]);

          }
				}else{
					$this->Flash->error(__('Période non valide'),['clear'=> true]);
					return $this->redirect(['controller'=>'dispos','action' => 'edit', $this->request->data['ids']]);
				}
			}
      return $this->redirect(['controller'=>'dispos','action' => 'view', $this->request->data['annonce_id']]);
    }
    $this->set("l_disposstatuts", ['0'=>'Libre','50'=>'Option','90'=>'Réservé']);
    $this->set("annonce_id", $ar[1]);
    $this->set("ids", $ids);
		$this->set(compact('dispo'));
    $this->set('_serialize', ['dispo']);
  }
  /**
   * Delete method
   *
   * @param string|null $id Dispo id.
   * @return \Cake\Network\Response|null Redirects to index.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function delete($id = null){
		$dispo = $this->Dispos->get($id);
    if ($this->Dispos->delete($dispo)) {
			$this->Flash->success(__('Periode supprimée'),['clear'=> true]);
			return $this->redirect(['action' => 'view', $dispo->annonce_id]);
    } else {
			$this->Flash->error(__('Identifiant invalide pour la période'),['clear'=> true]);
    }
    return $this->redirect(['controller'=>'utilisateurs','action' => 'index']);
  }
  /*
   *
   */
  function delEchu($id = null){
		$datjour = date('Y-m-d');
    if ($this->Dispos->deleteAll(['annonce_id' => $id, 'fin_at <' => $datjour])) {
			$this->Flash->success(__('Periode supprimée'),['clear'=> true]);
      return $this->redirect(['action' => 'view', $id]);
    }
		return $this->redirect(['action' => 'view', $id]);
  }
  /*
   *
   */
  function delAll($id = null){
    if ($this->Dispos->deleteAll(['annonce_id' => $id])) {
        $this->Flash->success(__('Periodes supprimées', true));
        return $this->redirect(['action' => 'view', $id]);
    }
	}
	/**
	 * 
	 */
	public function chercherdisponibiliteTot($id){
		$this->viewBuilder()->layout(false);
		$da_debut = date("Y-m-d", strtotime($this->request->data['debut']));
		$da_fin = date("Y-m-d", strtotime($this->request->data['fin']));
		$dispo = $this->Dispos->chercherdisponibiliteTot($id, $da_debut, $da_fin);
		$dispoCount = $this->Dispos->chercherdisponibiliteCountTot($id, $da_debut, $da_fin);
		$i = 0;
		$k = 1;
		$fdate = '';
		$ddate = '';
		$tab = [];
		$detail = [];
		$nbrDiff = [];
		foreach ($dispo as $key => $value) {
			$i =$i + 1;
			if(new Date($value->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($this->request->data['debut'])) {
				$dbt = new Date($this->request->data['debut']);
			}	else {
				$dbt = new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'));
			}
			if(new Date($value->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($this->request->data['fin'])) {
				$fin = new Date($this->request->data['fin']);
			}else {
				$fin = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
			}
			if($dispoCount->count() != 1){
				if($fdate != ''){
					$now   = $fdate;
					$clone = clone $now;
					$tet = $clone->modify( '+1 day' );
					$e = $tet->format( 'd-m-Y' );
					if($fdate == new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'))){
						$t = $nbrDiff[$i-1][$i-1];
						$nbrDiff[$i-1][$k] = $n."_".$ddate."_".$fdate;
						$nbrDiff[$i-1][$k+1] = $value->nbr_jour."_".$value->dbt_at."_".$fin;
						$detail['debut'][$i-1] = $detail['debut'][$i-1];
						$detail['fin'][$i-1] = $fin;
						$detail['statut'][$i-1] = $value->statut;
						$tab[$i-1] = 'Période '.($i-1).' : du '.$detail['debut'][$i-1].' au '.$fin.' <br>';
						$i = $i-1;
						$k = $k + 1;
					}else{
						$nbrDiff[$i][$i] = $value->nbr_jour;
						$detail['debut'][$i] = $dbt;
						$detail['fin'][$i] = $fin;
						$detail['statut'][$i] = $value->statut;
						$tab[$i] = 'Période '.$i.' : du '.$dbt.' au '.$fin.' <br>';
					}
				}else{
					$nbrDiff[$i][$i] = $value->nbr_jour;
					$detail['debut'][$i] = $dbt;
					$detail['fin'][$i] = $fin;
					$detail['statut'][$i] = $value->statut;
					$tab[$i] = 'Période '.$i.' : du '.$dbt.' au '.$fin.' <br>';
				}
			}else{
				$nbrDiff[$i][$i] = $value->nbr_jour;
				$detail['debut'][$i] = $dbt;
				$detail['fin'][$i] = $fin;
				$detail['statut'][$i] = $value->statut;
				$tab[$i] = 'Période '.$i.' : du '.$dbt.' au '.$fin.' <br>';
			}
			$detail['condition'][$i] = $value->conditionnbr;
			$n = $value->nbr_jour;
			$fdate = $fin;
			$ddate = $dbt;
		}
		$this->set('nbrperiode', count($tab));
		$this->set('tabDispo', $dispo);
		$this->set('disponi', $tab);
		$this->set('details', $detail);
		$this->set('nbrDiff', $nbrDiff);
	}
	/**
	 * 
	 */
	public function exportical($id=null)
	{
		$this->viewBuilder()->layout(false);
		$this->loadModel("Utilisateurs");
		$this->loadModel("Reservations");
		$idannonce = base64_decode($id);
		$events = [];
		$i = 1;		
		$listreservations = $this->Dispos->find("all", ["conditions" => 
					["Dispos.annonce_id"=>$idannonce, 
					"Dispos.statut"=>90, 
					"Dispos.reservation_id IS NOT NULL", 
					"Dispos.reservation_id != 0",
					"Dispos.calendarsynchro_id = 0",
					"Dispos.dbt_at > CURRENT_DATE",
				], "order" => "dbt_at"]);
		foreach ($listreservations as $value) {
			$query = $this->Reservations->find('all')->where(['id' => $value->reservation_id]);
			if($query = $query->first()){
				if($query->type !== 2){
					$description = '';
					if(!empty($value->utilisateur_id) && $value->utilisateur_id != ""){
						$utilisateur = $this->Utilisateurs->find("all")->where(['id' => $value->utilisateur_id]);
						if($utilisateur = $utilisateur->first()){
							$locatairenomprenom = $utilisateur->prenom." ".$utilisateur->nom_famille;
							$description .= 'Locataire : '.$locatairenomprenom.' ,';
						}				
						
						if(!empty($query)){
							$nbrpersonnes = $query->nb_adultes.' adultes et '.$query->nb_enfants.' enfants';
							$description .= ' Nombre personnes : '.$nbrpersonnes;
							$nbrnuitees = $value->fin_at->diff($value->dbt_at)->days;
						}
					}
					$events[] = [
						'id' => $i,
						'title' => 'Reserved',
						// 'description' => $description,
						'datestart' => $value->dbt_at->i18nFormat('yyyyMMdd'),
						'dateend' => $value->fin_at->i18nFormat('yyyyMMdd')
					];
					$i++;
				}
			}
		}
		$this->set('eventsical', $events);
		$this->set('id', $id);
	}
	/**
	 * 
	 */
	public function updateCalendarSynchro($url, $annonce_id, $Calendarsynchro_id, $sendTime=NULL)
	{
        file_put_contents(PATH_ALPISSIME."debug",print_r("function updateCalendarSynchro\n",true),FILE_APPEND);

        file_put_contents(PATH_ALPISSIME."debug",print_r("url = ",true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r($url,true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);

        file_put_contents(PATH_ALPISSIME."debug",print_r("annonce_id = ",true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r($annonce_id,true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);

        file_put_contents(PATH_ALPISSIME."debug",print_r("Calendarsynchro_id = ",true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r($Calendarsynchro_id,true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);

        file_put_contents(PATH_ALPISSIME."debug",print_r("sendTime = ",true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r($sendTime,true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
		$file = $url;
		$ical = file_get_contents($file);
        file_put_contents(PATH_ALPISSIME."debug",print_r("ical = ",true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r($ical,true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
		preg_match_all('/(BEGIN:VEVENT.*?END:VEVENT)/si', $ical, $result, PREG_PATTERN_ORDER);
        file_put_contents(PATH_ALPISSIME."debug",print_r("result = ",true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r($result,true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
		for ($i = 0; $i < count($result[0]); $i++) {
			$result[0][$i] = str_replace("\r\n","\n",$result[0][$i]);
			$tmpbyline = explode("\n", $result[0][$i]);
            file_put_contents(PATH_ALPISSIME."debug",print_r("tmpbyline = ",true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r($tmpbyline,true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
			foreach ($tmpbyline as $item) {
				$tmpholderarray = explode(":",$item);
				
				if (count($tmpholderarray) >1) {
					$postart = strpos($tmpholderarray[0], "DTSTART");
					$posend = strpos($tmpholderarray[0], "DTEND");
					if($postart !== false) $majorarray["DTSTART"] = $tmpholderarray[1];
					else if($posend !== false) $majorarray["DTEND"] = $tmpholderarray[1];
					else $majorarray[$tmpholderarray[0]] = $tmpholderarray[1];
				}
			}
			
			$icalarray[] = $majorarray;
			unset($majorarray);
		}
		// print_r($icalarray);
		// exit;

		$events = $icalarray;
		$periodeajouter = "NON";
        file_put_contents(PATH_ALPISSIME."debug",print_r("events = ",true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r($events,true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
		// Les périodes venant de Airbnb : SUMMARY = Reserved / Airbnb (Not available)

		if(count($events) > 0){
			$this->loadModel("Annonces");
			$this->loadModel("Reservations");
			$this->loadModel("Registres");
			$this->loadModel("Contrats");
			$this->loadModel("Dispos");
			$this->loadModel("Calendarsynchro");

			$annonce = $this->Annonces->get($annonce_id, ['contain' => ['Utilisateurs'] ]);
			
			// Parcourir périodes et enregistrer celles réservées
			$envoiemail = "non";
			foreach($events as $event){
				// Tester si la période envoyée est une reservation
				if($event['SUMMARY'] == 'Reserved'){
					$datedu = $event['DTSTART'];
					$dateau = $event['DTEND'];

					$eventdatestart = date('Y-m-d', strtotime($event['DTSTART']));//user friendly date
					$eventdateend = date('Y-m-d', strtotime($event['DTEND']));//user friendly date

					$eventdatedu = date('d-m-Y', strtotime($datedu));//user friendly date
					$eventdateau = date('d-m-Y', strtotime($dateau));//user friendly date

					$dispo = $this->Dispos->chercherdisponibilitesynchro($annonce_id, $eventdatestart, $eventdateend);
					$dispoCount = $this->Dispos->chercherdisponibiliteCountsynchro($annonce_id, $eventdatestart, $eventdateend);

					$dispoperiode = $this->Dispos->chercherdisponibiliteSansStatut($annonce_id, $eventdatestart, $eventdateend);
					$nbrPeriodeDispos = $this->Dispos->chercherdisponibiliteCountSansStatut($annonce_id, $eventdatestart, $eventdateend);

					// Cas 1 : il n'y a pas de périodes dans calendrier
					// Cas 2 : il y a des periodes libres		
					if(($dispoCount->count() == 0 && $nbrPeriodeDispos->count() == 0) || ($dispoCount->count() == $nbrPeriodeDispos->count())){
						$dataReservation = array(
							"annonce_id" => $annonce_id,
							"statut" => 90,
							"dbt_at" => $this->toDate($eventdatedu),
							"fin_at" => $this->toDate($eventdateau),
							"created_at" => Time::now(),
							"updated_at" => Time::now(),
							"nb_enfants" => 0,
							"nb_adultes" => 1,
							"type" => 2
						);
						$reservationNew = $this->Reservations->newEntity($dataReservation);
						$idreserv = $this->Reservations->save($reservationNew);
						// vérifier si en contrat pour envoyer mail
						if($annonce->contrat == 1){							
							$contratannonce = $this->Contrats->find("all")->where(['annonce_id' => $annonce->id, 'visible=1']);
							if($contratannonce->first()){
								// Envoie mail PasserellesNouvelleReservation						
								$datamustache = array("prenomprop" => $annonce['utilisateur']['prenom'], "nomprop" => $annonce['utilisateur']['nom_famille']);
								$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
								$mail=$mails->first();
								// #####################################################
								$eventmail = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $annonce['utilisateur']['email'],'textEmail'=>"passerellesNouvelleReservation",
																		'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
																		]);
								$this->eventManager()->dispatch($eventmail);
								// #####################################################
							}
						}
						$periodeajouter = "OUI";
					}		
					if($dispoCount->count() == 0 && $nbrPeriodeDispos->count() == 0){
						// on ajoute une periode avec statut réservé et on indique l'id du calendar
						$dataNewDispo = array(
							"annonce_id" => $annonce_id, 
							"created_at" => $this->toDate(date('d-m-Y')),
							"updated_at" => Time::now(),
							"dbt_at" => $this->toDate($eventdatedu),
							"fin_at" => $this->toDate($eventdateau),
							"statut" => 90,
							"reservation_id" => $idreserv->id,
							"calendarsynchro_id" => $Calendarsynchro_id
						);
						$newDispo = $this->Dispos->newEntity($dataNewDispo);
						if(new Date($eventdateau) > new Date($eventdatedu)){
							if($dispoSave = $this->Dispos->save($newDispo)){
								$envoiemail = "oui";
							}
						}						
					}else if($dispoCount->count() == $nbrPeriodeDispos->count()){
						// CODE A MODIFIER ET TRAITER
						$dbtperid = new Date($eventdatestart);
						$finperid = new Date($eventdateend);
				
						$detailresultat = [];
						$orderfin = [];
						$enregistrement = "non";
						foreach ($dispo as $key => $value) {
							$prixJour = 0;
							$prixJourPromo = 0;
							$nbrjourmin = 0;
							if (new Date($value->dbt_at->i18nFormat('dd-MM-yyyy')) <= $dbtperid) {
								// print_r("cas1");
								if(new Date($value->fin_at->i18nFormat('dd-MM-yyyy')) > $finperid){
									// print_r("cas3");
									$detailresultat['debut'][] = $finperid;
									$detailresultat['fin'][] = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
									$orderfin[] = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
									$detailresultat['statut'][] = "a garder partie periode";									
									$s_data=array(
										'updated_at'=>Time::now(),
										'dbt_at'=>$this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
										);
									$dispo = $this->Dispos->patchEntity($value, $s_data);	
									if(new Date($value->fin_at->i18nFormat('dd-MM-yyyy')) > $finperid){
										$this->Dispos->save($dispo);
									}						
									$prixJour = $value->prix_jour;
									$prixJourPromo = $value->promo_jour;
									$nbrjourmin = $value->nbr_jour;
									$detailresultat['debut'][] = $dbtperid;
									$detailresultat['fin'][] = $finperid;
									$orderfin[] = $finperid;
									$detailresultat['statut'][] = "a ajouter réservé";

									$s_data=array(	
										"annonce_id" => $annonce_id, 
										"created_at" => $this->toDate(date('d-m-Y')),
										"updated_at" => Time::now(),
										'dbt_at'=>$this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
										'fin_at'=>$this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
										"statut" => 90,
										"prix_jour" => $prixJour,
										"promo_jour" => $prixJourPromo,
										"nbr_jour" => $nbrjourmin,
										"reservation_id" => $idreserv->id,
										"calendarsynchro_id" => $Calendarsynchro_id
									);
									$dispo = $this->Dispos->newEntity($s_data);
									
									$nbrPeriodeDisposcas1 = $this->Dispos->chercherdisponibiliteSansStatut($annonce_id, $this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')), $this->toDate($finperid->i18nFormat('dd-MM-yyyy')));
									if($nbrPeriodeDisposcas1->count() == 0 && $finperid > $dbtperid){
										if($this->Dispos->save($dispo)) $enregistrement = "oui";
									}							
									
								}else{
									if(new Date($value->dbt_at->i18nFormat('dd-MM-yyyy')) == $dbtperid){
										$detailresultat['debut'][] = $dbtperid;
										$detailresultat['fin'][] = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
										$orderfin[] = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
										$detailresultat['statut'][] = "a modifier réservée";
										$s_data=array(
											'updated_at'=>Time::now(),
											'dbt_at'=>$this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
											'fin_at'=>$this->toDate($value->fin_at->i18nFormat('dd-MM-yyyy')),
											"statut" => 90,
											"reservation_id" => $idreserv->id,
											"calendarsynchro_id" => $Calendarsynchro_id
										);
										$dispo = $this->Dispos->patchEntity($value, $s_data);									
										
										if(new Date($value->fin_at->i18nFormat('dd-MM-yyyy')) > $dbtperid){
											if($this->Dispos->save($dispo)) $enregistrement = "oui";
										}
					
										$dbtperid = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
										// print_r("cas4");
									}else{	
										$debgardautiliser = $dbtperid;
										
										$finavantpatch = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));

										$detailresultat['debut'][] = new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'));
										$detailresultat['fin'][] = $debgardautiliser; /////////////
										$orderfin[] = $debgardautiliser; /////////////
										$detailresultat['statut'][] = "a garder partie periode";
										$s_data=array(
											'updated_at'=>Time::now(),
											'fin_at'=>$this->toDate($debgardautiliser->i18nFormat('dd-MM-yyyy')),
											);
										$dispo = $this->Dispos->patchEntity($value, $s_data);
										if($debgardautiliser > new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'))){
											if($this->Dispos->save($dispo)) $enregistrement = "oui";
										}							
										$prixJour = $value->prix_jour;
										$prixJourPromo = $value->promo_jour;
										$nbrjourmin = $value->nbr_jour;
										$detailresultat['debut'][] = $dbtperid;
										$detailresultat['fin'][] = $finavantpatch;
										$orderfin[] = $finavantpatch;
										$detailresultat['statut'][] = "a ajouter réservé";
										// print_r("cas7");
										
										$s_data=array(	
											"annonce_id" => $annonce_id, 
											"created_at" => $this->toDate(date('d-m-Y')),
											"updated_at" => Time::now(),
											'dbt_at'=>$this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
											'fin_at'=>$this->toDate($finavantpatch),
											"statut" => 90,
											"prix_jour" => $prixJour,
											"promo_jour" => $prixJourPromo,
											"nbr_jour" => $nbrjourmin,
											"reservation_id" => $idreserv->id,
											"calendarsynchro_id" => $Calendarsynchro_id											
										);
										$dispo = $this->Dispos->newEntity($s_data);
										
										$nbrPeriodeDisposcas2 = $this->Dispos->chercherdisponibiliteSansStatut($annonce_id, $this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')), $this->toDate(new Date($value->fin_at->i18nFormat('dd-MM-yyyy'))));
										if($nbrPeriodeDisposcas2->count() == 0 && $finavantpatch > $dbtperid){
											if($this->Dispos->save($dispo)) $enregistrement = "oui";
										}

										$dbtperid = $finavantpatch;
										
									}
									
								}
							} else {
								// print_r("cas2");
								$prixJour = $value->prix_jour;
								$prixJourPromo = $value->promo_jour;
								$nbrjourmin = $value->nbr_jour;
								$detailresultat['debut'][] = $dbtperid;
								$detailresultat['fin'][] = new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'));
								$orderfin[] = new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'));
								$detailresultat['statut'][] = "a ajouter réservée";
								$s_data=array(	
									"annonce_id" => $annonce_id, 
									"created_at" => $this->toDate(date('d-m-Y')),
									"updated_at" => Time::now(),
									'dbt_at'=>$this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')),
									'fin_at'=>$this->toDate($value->dbt_at->i18nFormat('dd-MM-yyyy')),
									"statut" => 90,
									"prix_jour" => $prixJour,
									"promo_jour" => $prixJourPromo,
									"nbr_jour" => $nbrjourmin,
									"reservation_id" => $idreserv->id,
									"calendarsynchro_id" => $Calendarsynchro_id	
								);
								$dispo = $this->Dispos->newEntity($s_data);
								
								$nbrPeriodeDisposcas3 = $this->Dispos->chercherdisponibiliteSansStatut($annonce_id, $this->toDate($dbtperid->i18nFormat('dd-MM-yyyy')), $this->toDate($value->dbt_at->i18nFormat('dd-MM-yyyy')));
								if($nbrPeriodeDisposcas3->count() == 0 && new Date($value->dbt_at->i18nFormat('dd-MM-yyyy')) > $dbtperid){
									if($this->Dispos->save($dispo)) $enregistrement = "oui";
								}
				
								if(new Date($value->fin_at->i18nFormat('dd-MM-yyyy')) <= $finperid){
									// print_r("cas5");
									$detailresultat['debut'][] = new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'));
									$detailresultat['fin'][] = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
									$orderfin[] = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
									$detailresultat['statut'][] = "a modifier réservée";
									$s_data=array(
										'updated_at'=>Time::now(),
										'dbt_at'=>$this->toDate($value->dbt_at->i18nFormat('dd-MM-yyyy')),
										'fin_at'=>$this->toDate($value->fin_at->i18nFormat('dd-MM-yyyy')),
										"statut" => 90,
										"reservation_id" => $idreserv->id,
										"calendarsynchro_id" => $Calendarsynchro_id	
									);
									$dispo = $this->Dispos->patchEntity($value, $s_data);											
									if(new Date($value->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($value->dbt_at->i18nFormat('dd-MM-yyyy'))){
										if($this->Dispos->save($dispo)) $enregistrement = "oui";
									}

									$dbtperid = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
								}else{
									$dbtavantpatch = $value->dbt_at->i18nFormat('dd-MM-yyyy');
									$detailresultat['debut'][] = $finperid;
									$detailresultat['fin'][] = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
									$orderfin[] = new Date($value->fin_at->i18nFormat('dd-MM-yyyy'));
									$detailresultat['statut'][] = "a garder partie periode";
									$s_data=array(
										'updated_at'=>Time::now(),
										'dbt_at'=>$this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
										);
									$dispo = $this->Dispos->patchEntity($value, $s_data);	
									if(new Date($value->fin_at->i18nFormat('dd-MM-yyyy')) > $finperid){
										if($this->Dispos->save($dispo)) $enregistrement = "oui";
									}						
									$prixJour = $value->prix_jour;
									$prixJourPromo = $value->promo_jour;
									$nbrjourmin = $value->nbr_jour;
									// print_r("cas6");
									$detailresultat['debut'][] = new Date($dbtavantpatch);
									$detailresultat['fin'][] = $finperid;
									$orderfin[] = $finperid;
									$detailresultat['statut'][] = "a ajouter réservée";
									$s_data=array(	
										"annonce_id" => $annonce_id, 
										"created_at" => $this->toDate(date('d-m-Y')),
										"updated_at" => Time::now(),
										'dbt_at'=>$this->toDate($dbtavantpatch),
										'fin_at'=>$this->toDate($finperid->i18nFormat('dd-MM-yyyy')),
										"statut" => 90,
										"prix_jour" => $prixJour,
										"promo_jour" => $prixJourPromo,
										"nbr_jour" => $nbrjourmin,
										"reservation_id" => $idreserv->id,
										"calendarsynchro_id" => $Calendarsynchro_id
									);
									$dispo = $this->Dispos->newEntity($s_data);
									
									$nbrPeriodeDisposcas4 = $this->Dispos->chercherdisponibiliteSansStatut($annonce_id, $this->toDate($value->dbt_at->i18nFormat('dd-MM-yyyy')), $this->toDate($finperid->i18nFormat('dd-MM-yyyy')));
									if($nbrPeriodeDisposcas4->count() == 0 && $finperid > new Date($dbtavantpatch)){
										if($this->Dispos->save($dispo)) $enregistrement = "oui";
									}	
									
								}
							}								
						}
						
						rsort($orderfin);
						if (!in_array($finperid, $detailresultat['fin'])) {
							// print_r("new cas");
							if($finperid > $orderfin[0]){
								$s_data=array(	
									"annonce_id" => $annonce_id, 
									"created_at" => $this->toDate(date('d-m-Y')),
									"updated_at" => Time::now(),
									'dbt_at'=>$this->toDate($orderfin[0]),
									'fin_at'=>$this->toDate($finperid),
									"statut" => 90,
									"reservation_id" => $idreserv->id,
									"calendarsynchro_id" => $Calendarsynchro_id
								);
								$dispo = $this->Dispos->newEntity($s_data);
								
								$nbrPeriodeDisposcas6 = $this->Dispos->chercherdisponibiliteSansStatut($annonce_id, $this->toDate($dernierefin), $this->toDate($finperid));
								if($nbrPeriodeDisposcas6->count() == 0 ){
									if($this->Dispos->save($dispo)) $enregistrement = "oui";
								}
							}				
							
						}
						// print_r($dernierefin);
						// print_r($finperid);
						// print_r($orderfin);
						
						// print_r($detailresultat);
						// print_r($orderfin);
						// exit; 
													
					}else{
						// Confusion : il y en a une reservation ou option ou indisponible
						$getdispofirst = $dispoperiode->where(['statut = 90'])->first();
						$reservationdetail = $this->Reservations->find("all")
						->join([            
							'Dispos' => [
								'table' => 'dispos',
								'type' => 'inner',
								'conditions' => 'Dispos.reservation_id=Reservations.id',
							]
						])
						->where(['Dispos.id' => $getdispofirst->id])
						->group('Reservations.id')
						->select(['Dispos.calendarsynchro_id', 'Reservations.dbt_at', 'Reservations.fin_at']);
						if($reservationdetail = $reservationdetail->first()){
							if($reservationdetail["Dispos"]["calendarsynchro_id"] != $Calendarsynchro_id){
								if(($sendTime == "houres" && $getdispofirst->doubleperiodesynchro == 0) || $sendTime == NULL){
									// Envoie mail PasserellesAlerteDoubleReservation
									$findCalendarSynchro = $this->Calendarsynchro->get($Calendarsynchro_id);
									$datamustache = array("calendriernom" => $findCalendarSynchro->nom, "debut" => $reservationdetail->dbt_at, "fin" => $reservationdetail->fin_at, "annonce_id" => $annonce->id, "prenomprop" => $annonce['utilisateur']['prenom'], "nomprop" => $annonce['utilisateur']['nom_famille']);
									$mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
									$mail=$mails->first();
									// #####################################################
									$eventmail = new Event('Email.send', $this, ['from'=>[$mail->val=>FROM_MAIL],'to' => $annonce['utilisateur']['email'],'textEmail'=>"passerellesAlerteDoubleReservation",
																			'data'=>$datamustache,'template'=>'creationAnnonce','viewVars'=>'creationAnnonce','noReply'=>false
																			]);
									$this->eventManager()->dispatch($eventmail);
									// #####################################################
									$datadoubleinfo = array('doubleperiodesynchro' => 1);
									$doubleinfo = $this->Dispos->patchEntity($getdispofirst, $datadoubleinfo);
									$this->Dispos->save($doubleinfo);
								}
								$periodeajouter = "DOUBLE";
							}
						}
						// print_r($reservationdetail->first());
						// print_r("il y en a une reservation ou option ou indisponible !!!!!!!!");
						// exit;
					}
					
				}	
				if($event['SUMMARY'] == 'Airbnb (Not available)') {
					$datedu = $event['DTSTART'];
					$dateau = $event['DTEND'];

					$eventdatestart = date('Y-m-d', strtotime($event['DTSTART']));//user friendly date
					$eventdateend = date('Y-m-d', strtotime($event['DTEND']));//user friendly date

					$dispoperiode = $this->Dispos->chercherdisponibiliteSansStatut($annonce_id, $eventdatestart, $eventdateend);

					foreach ($dispoperiode as $dispoper) {
						if($dispoper->reservation_id != null){
							$reservation=$this->Reservations->get($dispoper->reservation_id);
							if($reservation->statut == 90 && $reservation->type == 2) {
								// reservation
								$a_reservation=array("statut"=>10,'updated_at'=>$this->toDate(date('d-m-Y')));
								$reservation=$this->Reservations->patchEntity($reservation,$a_reservation);
								$this->Reservations->save($reservation);
								// dispos
								$dispos=$this->Dispos->find('all',['conditions'=>['Dispos.reservation_id'=>$reservation->id]]);
								foreach ($dispos as $dispo) {
									$a_dispo=array('statut'=>0,'utilisateur_id'=>null,'reservation_id'=>null);
									$dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
									$this->Dispos->save($dispo);
								}
							}
						}													
					}
				}		
			}					
		}
		$this->set("periodeajouter", $periodeajouter);

	}
	/**
	 * 
	 */
	public function verifyAllSynchroDispo()
    {
		$this->loadModel("Calendarsynchro");
		$this->loadModel("Reservations");
		$this->loadModel("Dispos");
		$this->loadModel("Registres");
		
        $allAnonces = $this->Calendarsynchro->find()->where(['actif'=>1])->group(['annonce_id'])->extract('annonce_id');
        foreach ($allAnonces as $annonceId) {
            try {
                $tabStart = [];
                $tabEnd = [];
                $listCalendarAnnonce = $this->Calendarsynchro->find()->where(['annonce_id' => $annonceId, 'actif'=>1]);
                foreach ($listCalendarAnnonce as $calendarAnn) {
                    $file = $calendarAnn->url;
                    $ical = file_get_contents($file);
                    preg_match_all('/(BEGIN:VEVENT.*?END:VEVENT)/si', $ical, $result, PREG_PATTERN_ORDER);        
                    for ($i = 0; $i < count($result[0]); $i++) {
                        $result[0][$i] = str_replace("\r\n","\n",$result[0][$i]);
                        $tmpbyline = explode("\n", $result[0][$i]);
                        
                        foreach ($tmpbyline as $item) {
                            $tmpholderarray = explode(":",$item);
                            
                            if (count($tmpholderarray) >1) {
                                $postart = strpos($tmpholderarray[0], "DTSTART");
                                $posend = strpos($tmpholderarray[0], "DTEND");
                                if ($postart !== false){
                                    $majorarray["DTSTART"] = date('Y-m-d', strtotime($tmpholderarray[1]));
                                    $tabStart[] = date('Y-m-d', strtotime($tmpholderarray[1]));
                                } 
                                else if ($posend !== false){
                                    $majorarray["DTEND"] = date('Y-m-d', strtotime($tmpholderarray[1]));
                                    $tabEnd[] = date('Y-m-d', strtotime($tmpholderarray[1]));
                                } 
                                else {
                                    $majorarray[$tmpholderarray[0]] = $tmpholderarray[1];
                                }
                            }
                        }
                        
                        $icalarray[] = $majorarray;
                        unset($majorarray);
                    }
                }
                
                $listReservSynchrAnnonce = $this->Reservations->find()->where(['annonce_id' => $annonceId, 'statut' => 90, 'type' => 2]);
                foreach ($listReservSynchrAnnonce as $reservSynchroAnn) {	
                    if( $reservSynchroAnn->utilisateur_id == 0 && array_search($reservSynchroAnn->dbt_at->i18nFormat('yyyy-MM-dd'), $tabStart) === false && array_search($reservSynchroAnn->fin_at->i18nFormat('yyyy-MM-dd'), $tabEnd) === false) {
                        // reservation
                        $a_reservation=array("statut"=>10,'updated_at'=>new Time());
                        $reservation=$this->Reservations->patchEntity($reservSynchroAnn,$a_reservation);
                        $this->Reservations->save($reservation);
                        // dispos
                        $dispos=$this->Dispos->find('all',['conditions'=>['Dispos.reservation_id'=>$reservSynchroAnn->id]]);
                        foreach ($dispos as $dispo) {
                            $a_dispo=array('statut'=>0,'utilisateur_id'=>null,'reservation_id'=>null);
                            $dispo=$this->Dispos->patchEntity($dispo,$a_dispo);
                            $this->Dispos->save($dispo);
                        }
                        Log::write('info', 'Don\'t find synchro reservationID : '.$reservSynchroAnn->id); 
                    }
                }
            } catch (\Throwable $th) {
                // throw $th;
                $mails = $this->Registres->find("all", ["conditions" => ["app" => "ULYSSE", "bra" => "GEN", "cle" => "MAIL"]]);
                $mail=$mails->first();
                // #####################################################
                $email = new Email('production');
                $email->to('maroua.c@ite.digital')
                    ->from([$mail->val=>FROM_MAIL])
                    ->subject('Erreur dans fichier CRON')
                    ->emailFormat('html')
                    ->send('Bonjour, <br><br> Erreur Function verifyAllSynchroDispo : <br><br> '.$th);
            }
            
        }
    }
	
	/**
	 * 
	 */
	/*public function importical()
	{
		// $this->autoRender = false;
		$this->viewBuilder()->layout(false);
		$this->loadModel("Calendarsynchro");
		$listeCalendar = $this->Calendarsynchro->find("all")->where(['annonce_id' => $this->request->data['annonce_id']]);
		foreach ($listeCalendar as $value) {
			$this->updateCalendarSynchro($value->url, $value->annonce_id, $value->id);
		}
	}*/
	/**
	 * 
	 */
	public function listMyCalendar()
	{
		$this->viewBuilder()->layout(false);

		$this->loadModel("Calendarsynchro");
		$findCalendarSynchro = $this->Calendarsynchro->find("all")->where(['annonce_id' => $this->request->data["annonce_id"], 'actif'=>1]);

		$this->set('mycalendars', $findCalendarSynchro);
		$this->set('mycalendarscount', $findCalendarSynchro->count());
	}
	/**
	 * 
	 */
	public function deleteCalendar()
	{
		$this->viewBuilder()->layout(false);

		$this->loadModel("Calendarsynchro");
		$findCalendarSynchro = $this->Calendarsynchro->get($this->request->data["idcalendar"]);
		$datadelete = array("actif" => 0);
		$calendarModif = $this->Calendarsynchro->patchEntity($findCalendarSynchro, $datadelete);
		$this->Calendarsynchro->save($calendarModif);

	}
	/**
	 * 
	 */
	public function iCalDecoder()
	{
        @unlink(PATH_ALPISSIME."debug");

        file_put_contents(PATH_ALPISSIME."debug",print_r("function iCalDecoder\n",true),FILE_APPEND);
		$this->viewBuilder()->layout(false);

		$this->loadModel("Calendarsynchro");
		$findCalendarSynchro = $this->Calendarsynchro->find("all")->where(['url' => $this->request->data['iCalUrl'], 'annonce_id' => $this->request->data["annonce_id"]]);
        file_put_contents(PATH_ALPISSIME."debug",print_r("findCalendarSynchro 1 = ",true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r($findCalendarSynchro,true),FILE_APPEND);
        file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
		if(!$findCalendarSynchro->first()){
			// Ajout dans calendarsynchro
			$calendardata=array('nom'=>$this->request->data['iCalNom'],'url'=>$this->request->data['iCalUrl'], 'annonce_id' => $this->request->data["annonce_id"]);
            file_put_contents(PATH_ALPISSIME."debug",print_r("calendardata 1 = ",true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r($calendardata,true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
			$newCalendarsynchro = $this->Calendarsynchro->newEntity($calendardata);
            file_put_contents(PATH_ALPISSIME."debug",print_r("newCalendarsynchro 1 = ",true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r($newCalendarsynchro,true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
			if($Calendarsynchro = $this->Calendarsynchro->save($newCalendarsynchro)){
				$this->updateCalendarSynchro($this->request->data['iCalUrl'], $this->request->data["annonce_id"], $Calendarsynchro->id);
			}		
		}else{
			// Rendre actif
			$findCalendarSynchro = $findCalendarSynchro->first();
            file_put_contents(PATH_ALPISSIME."debug",print_r("findCalendarSynchro 2 = ",true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r($findCalendarSynchro,true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
			$calendardata=array('nom'=>$this->request->data['iCalNom'],'actif'=>1);
            file_put_contents(PATH_ALPISSIME."debug",print_r("calendardata 2 = ",true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r($calendardata,true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
			$newCalendarsynchro = $this->Calendarsynchro->patchEntity($findCalendarSynchro,$calendardata);
            file_put_contents(PATH_ALPISSIME."debug",print_r("newCalendarsynchro 2 = ",true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r($newCalendarsynchro,true),FILE_APPEND);
            file_put_contents(PATH_ALPISSIME."debug",print_r("\n",true),FILE_APPEND);
			if($Calendarsynchro = $this->Calendarsynchro->save($newCalendarsynchro)){
				$this->updateCalendarSynchro($this->request->data['iCalUrl'], $this->request->data["annonce_id"], $Calendarsynchro->id);
			}
		}

	}
	/**
	 * 
	 */
	public function adddisponibilite($annonce_id,$dbt_at, $fin_at, $disposID, $Calendarsynchro, $idreserv_id)
	{
		$session = $this->request->session();		
		/** MANIPULATION DES PERIODES DISPOS **/
		$this->loadModel("Dispos");
		$data = array();
		$evit = '';

		$dispo=$this->Dispos->get($disposID);
		if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($dbt_at)) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) == new Date($fin_at)))
		{
			/** METTRE A JOUR LA PERIODE DISPONIBLE **/
			$nbrDiffNew = (new Date($dbt_at))->diff(new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')))->days;
			$nbrDiffAjout = (new Date($fin_at))->diff(new Date($dbt_at))->days;
			$nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;
			if($dispo->prix_jour == 0 && $dispo->prix != 0 ){
				$data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
				$dataAjout["prix_jour"] = $data['prix_jour'];
				$data['prix'] = $data['prix_jour'] * $nbrDiffNew;
				$dataAjout["prix"] = $data['prix_jour'] * $nbrDiffAjout;
			}else{
				$dataAjout["prix_jour"] = $dispo->prix_jour;
				$data['prix'] = $dispo->prix_jour * $nbrDiffNew;
				$dataAjout["prix"] = $dispo->prix_jour * $nbrDiffAjout;
			}
			if($dispo->promo_jour == 0 && $dispo->promo_px != 0 ){
				$data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
				$dataAjout["promo_jour"] = $data['promo_jour'];
				$data['promo_px'] = $data['prix_jour'] * $nbrDiffNew;
				$dataAjout["promo_px"] = $data['prix_jour'] * $nbrDiffAjout;
			}else if($dispo->promo_yn == 1){
				$dataAjout["promo_jour"] = $dispo->promo_jour;
				$data['promo_px'] = $dispo->promo_jour * $nbrDiffNew;
				$dataAjout["promo_px"] = $dispo->promo_jour * $nbrDiffAjout;
			}else{
				$dataAjout["promo_jour"] = $dispo->promo_jour;
				$dataAjout["promo_px"] = $dispo->promo_px;
			}
			$data["updated_at"] = $this->toDate(date('d-m-Y'));
			$data["fin_at"] = $this->toDate($dbt_at);
			$dispoModif = $this->Dispos->patchEntity($dispo, $data);
			$this->Dispos->save($dispoModif);
			// Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
		}else if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) == new Date($dbt_at)) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($fin_at)))
		{
			/** METTRE A JOUR LA PERIODE DISPONIBLE **/
			$nbrDiffNew = (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')))->diff(new Date($fin_at))->days;
			$nbrDiffAjout = (new Date($fin_at))->diff(new Date($dbt_at))->days;
			$nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;
			if($dispo->prix_jour == 0 && $dispo->prix != 0 ){
				$data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
				$dataAjout["prix_jour"] = $data['prix_jour'];
				$data['prix'] = $data['prix_jour'] * $nbrDiffNew;
				$dataAjout["prix"] = $data['prix_jour'] * $nbrDiffAjout;
			}else{
				$dataAjout["prix_jour"] = $dispo->prix_jour;
				$data['prix'] = $dispo->prix_jour * $nbrDiffNew;
				$dataAjout["prix"] = $dispo->prix_jour * $nbrDiffAjout;
			}
			if($dispo->promo_jour == 0 && $dispo->promo_px != 0 ){
				$data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
				$dataAjout["promo_jour"] = $data['promo_jour'];
				$data['promo_px'] = $data['prix_jour'] * $nbrDiffNew;
				$dataAjout["promo_px"] = $data['prix_jour'] * $nbrDiffAjout;
			}else if($dispo->promo_yn == 1){
				$dataAjout["promo_jour"] = $dispo->promo_jour;
				$data['promo_px'] = $dispo->promo_jour * $nbrDiffNew;
				$dataAjout["promo_px"] = $dispo->promo_jour * $nbrDiffAjout;
			}else{
				$dataAjout["promo_jour"] = $dispo->promo_jour;
				$dataAjout["promo_px"] = $dispo->promo_px;
			}
			$data["updated_at"] = $this->toDate(date('d-m-Y'));
			$data["dbt_at"] = $this->toDate($fin_at);
			$dispoModif = $this->Dispos->patchEntity($dispo, $data);
			$this->Dispos->save($dispoModif);
			// Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
		}else if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) == new Date($dbt_at)) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) == new Date($fin_at)))
		{
			$evit = 'EviterAjout';
			/** METTRE A JOUR LA PERIODE DISPONIBLE **/
			$nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;
			if($dispo->prix_jour == 0 && $dispo->prix != 0 ){
				$data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
			}
			if($dispo->promo_jour == 0 && $dispo->promo_px != 0 ){
				$data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
			}
			$data["updated_at"] = $this->toDate(date('d-m-Y'));
			$data["statut"] = 90;
			$data["calendarsynchro_id"] = $Calendarsynchro;
			$data["reservation_id"] = $idreserv_id;
			$dispoModif = $this->Dispos->patchEntity($dispo, $data);
			$this->Dispos->save($dispoModif);
			// Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);
		}else if((new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')) < new Date($dbt_at)) && (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')) > new Date($fin_at)))
		{
			/** METTRE A JOUR LA PERIODE DISPONIBLE **/
			$nbrDiffNew = (new Date($dbt_at))->diff(new Date($dispo->dbt_at->i18nFormat('dd-MM-yyyy')))->days;
			$nbrDiffAjout = (new Date($fin_at))->diff(new Date($dbt_at))->days;
			$nbrDiffNew2 = (new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy')))->diff(new Date($fin_at))->days;
			$nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;
			$data2["fin_at"] = $this->toDate($dispo->fin_at);
			$data2["promo_yn"] = $dispo->promo_yn;
			$data2["nbr_jour"] = $dispo->nbr_jour;
			if($dispo->prix_jour == 0 && $dispo->prix != 0 ){
				$data['prix_jour'] = round(($dispo->prix/$nbrDiff), 2);
				$dataAjout["prix_jour"] = $data['prix_jour'];
				$data2["prix_jour"] = $data['prix_jour'];
				$data['prix'] = $data['prix_jour'] * $nbrDiffNew;
				$data2['prix'] = $data['prix_jour'] * $nbrDiffNew2;
				$dataAjout["prix"] = $data['prix_jour'] * $nbrDiffAjout;
			}else{
				$dataAjout["prix_jour"] = $dispo->prix_jour;
				$data2["prix_jour"] = $dispo->prix_jour;
				$data['prix'] = $dispo->prix_jour * $nbrDiffNew;
				$data2['prix'] = $dispo->prix_jour * $nbrDiffNew2;
				$dataAjout["prix"] = $dispo->prix_jour * $nbrDiffAjout;
			}
			if($dispo->promo_jour == 0 && $dispo->promo_px != 0 ){
				$data['promo_jour'] = round(($dispo->promo_px/$nbrDiff), 2);
				$dataAjout["promo_jour"] = $data['promo_jour'];
				$data2["promo_jour"] = $data['promo_jour'];
				$data['promo_px'] = $data['prix_jour'] * $nbrDiffNew;
				$data2['promo_px'] = $data['prix_jour'] * $nbrDiffNew2;
				$dataAjout["promo_px"] = $data['prix_jour'] * $nbrDiffAjout;
			}else if($dispo->promo_yn == 1){
				$dataAjout["promo_jour"] = $dispo->promo_jour;
				$data2["promo_jour"] = $dispo->promo_jour;
				$data['promo_px'] = $dispo->promo_jour * $nbrDiffNew;
				$data2['promo_px'] = $dispo->promo_jour * $nbrDiffNew2;
				$dataAjout["promo_px"] = $dispo->promo_jour * $nbrDiffAjout;
			}else{
				$dataAjout["promo_jour"] = $dispo->promo_jour;
				$data2["promo_jour"] = $dispo->promo_jour;
				$dataAjout["promo_px"] = $dispo->promo_px;
				$data2["promo_px"] = $dispo->promo_px;
			}
			$data["updated_at"] = $this->toDate(date('d-m-Y'));
			$data["fin_at"] = $this->toDate($dbt_at);
			$dispoModif = $this->Dispos->patchEntity($dispo, $data);
			$this->Dispos->save($dispoModif);
			// Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoModif->id.'__debut: '.$dispoModif->dbt_at.'__fin: '.$dispoModif->fin_at.'__reservationID: '.$reservation->id);

			$data2["annonce_id"] = $annonce_id;
			$data2["created_at"] = $this->toDate(date('d-m-Y'));
			$data2["updated_at"] = $this->toDate(date('d-m-Y'));
			$data2["dbt_at"] = $this->toDate($fin_at);
			$data2["statut"] = 0;
			$dispo2 = $this->Dispos->newEntity($data2);
			$this->Dispos->save($dispo2);
			// Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispo2->id.'__debut: '.$dispo2->dbt_at.'__fin: '.$dispo2->fin_at.'__reservationID: '.$reservation->id);
		}
		if($evit == ''){
			/** AJOUTER LA PERIODE RESERVEE **/
			$dataAjout["annonce_id"] = $annonce_id;
			$dataAjout["created_at"] = $this->toDate(date('d-m-Y'));
			$dataAjout["updated_at"] = $this->toDate(date('d-m-Y'));
			$dataAjout["dbt_at"] = $this->toDate($dbt_at);
			$dataAjout["fin_at"] = $this->toDate($fin_at);
			$dataAjout["statut"] = 90;
			$dataAjout["calendarsynchro_id"] = $Calendarsynchro;
			$dataAjout["promo_yn"] = $dispo->promo_yn;
			$dataAjout["reservation_id"] = $idreserv_id;
			$dataAjout["nbr_jour"] = $dispo->nbr_jour;

			$dispoAjout = $this->Dispos->newEntity($dataAjout);
			$this->Dispos->save($dispoAjout);
			// Log::write('info', 'Creation reservation par locataire (dispos) : dispoID: '.$dispoAjout->id.'__debut: '.$dispoAjout->dbt_at.'__fin: '.$dispoAjout->fin_at.'__reservationID: '.$reservation->id);
		}

		/** FIN **/
						
		return $idreserv->id;
	}
	/**
	 * 
	 */
	public function getallimportical()
	{
		// $this->autoRender = false;
		$this->viewBuilder()->layout(false);
		$this->loadModel("Annonces");
		$annonce = $this->Annonces->get($this->request->data['annonce_id']);
		$listeurl = [];
		if(!empty($annonce->urlimport))
		{
			$listeurl = explode(";", $annonce->urlimport);
		}
		$this->set('listeurl', $listeurl);
	}

    private function applyAutomaticPromo($annonce, &$resultatDetail)
    {
        $today = (new Date());

        $resultatDetail['automaticPromo'] = [
            'percent'     => 0,
            'text'        => '',
            'type'        => '',
            'total_price' => 0,
            'value'       => 0,
        ];

        if ($annonce->proposerlongsejours == 1 && $annonce->delaislongsejours != 0 && $annonce->montantlongsejours != 0) {
            $resultatDetail['automaticPromo']['percent'] = $annonce->montantlongsejours;
            $resultatDetail['automaticPromo']['text']    = __('Promotion Longs séjours');
            $resultatDetail['automaticPromo']['type']    = 'longstay';
        }

        if ($annonce->proposerlastminute == 1 && $annonce->delaislastminute != 0 && $annonce->montantlastminute != 0) {
            if ($annonce->montantlastminute >= $resultatDetail['automaticPromo']['percent']) {
                $resultatDetail['automaticPromo']['percent'] = $annonce->montantlastminute;
                $resultatDetail['automaticPromo']['text']    = __('Promotion Last Minute');
                $resultatDetail['automaticPromo']['type']    = 'longstay';
            }
        }

        if ($annonce->proposerearlybooking == 1 && $annonce->delaisearly != 0 && $annonce->montantearlybooking != 0) {
            if ($annonce->montantearlybooking >= $resultatDetail['automaticPromo']['percent']) {
                $resultatDetail['automaticPromo']['percent'] = $annonce->montantearlybooking;
                $resultatDetail['automaticPromo']['text']    = __('Promotion Early Booking');
                $resultatDetail['automaticPromo']['type']    = 'longstay';
            }
        }

        switch ($resultatDetail['automaticPromo']['type']) {
            case 'longstay':
                if ($resultatDetail['nights'] >= $annonce->delaislongsejours) {
                    foreach ($resultatDetail['period_price_dates'] as &$period_price_dates) {
                        foreach ($period_price_dates as &$date) {
                            $date['price'] -= $date['main_price'] * $resultatDetail['automaticPromo']['percent'] / 100;
                            $resultatDetail['automaticPromo']['total_price'] += $date['price'];
                        }
                    }
                }
                break;
            case 'lastminute':
                foreach ($resultatDetail['period_price_dates'] as &$period_price_dates) {
                    foreach ($period_price_dates as &$date) {
                        $daysSubtract = (new Date($date['day']))->modify('-' . $annonce->delaislastminute . ' days');
                        if ($today <= (new Date($date['day'])) && $today >= $daysSubtract) {
                            $date['price'] -= $date['main_price'] * $resultatDetail['automaticPromo']['percent'] / 100;
                        }
                        $resultatDetail['automaticPromo']['total_price'] += $date['price'];
                    }
                }
                break;
            case 'earlybooking':
                foreach ($resultatDetail['period_price_dates'] as &$period_price_dates) {
                    foreach ($period_price_dates as &$date) {
                        $daysSubtract = (new Date($date['day']))->modify('-' . $annonce->delaisearly . ' days');
                        if ($today < $daysSubtract) {
                            $date['price'] -= $date['main_price'] * $resultatDetail['automaticPromo']['percent'] / 100;
                        }
                        $resultatDetail['automaticPromo']['total_price'] += $date['price'];
                    }
                }
                break;
        }

        if ($resultatDetail['automaticPromo']['total_price']) {
            $resultatDetail['automaticPromo']['value'] = $resultatDetail['total_price'] - $resultatDetail['automaticPromo']['total_price'];
        }
    }

    private function calculateTaxes($nb_etoiles, $nbradulte, $nbrenfant, &$resultatDetail)
    {
        foreach ($resultatDetail['period_price_dates'] as $i => &$period_price_dates) {
            $taxValue = $resultatDetail['taxes'][$i]['valeur'];

            foreach ($period_price_dates as $date) {
                if ($nb_etoiles == 0) {
                    $nouvelletaxe = ($date['price'] / ($nbradulte + $nbrenfant)) * ($taxValue / 100);
                    if ($nouvelletaxe > 2.3) {
                        $nouvelletaxe = 2.3;
                    }
                    $nouvelletaxe = $nouvelletaxe * $nbradulte;

                    //// Ajouter 10% taxe departementale
                    /// //// Taxe Totale
                    $resultatDetail['prixtaxeapayer'] += $nouvelletaxe + ($nouvelletaxe * 1/10);
                } else {
                    $nouvelle_taxe = $taxValue * $nbradulte;

                    //// Ajouter 10% taxe departementale
                    $resultatDetail['prixtaxeapayer'] += $nouvelle_taxe + ($nouvelle_taxe * 1/10);
                }
            }
        }
    }

	/**
	 * 
	 */
	public function calcultaxedesejour($annonce_id, $dates, $nbradulte, $nbrenfant)
	{
        // $dates sous forme : dd-MM-yyyy/dd-MM-yyyy
		/*** TRAITER LA PERIODE DEMANDER *****/
		$this->loadModel("Annonces");
		$this->loadModel("Taxes");
		$this->loadModel("Dispos");

		$annonce = $this->Annonces->get($annonce_id);
        list($startDate, $endDate) = explode("/", $dates);
        $startDate = (new Date($startDate))->i18nFormat('yyyy-MM-dd');
        $endDate = (new Date($endDate))->i18nFormat('yyyy-MM-dd');

		/** Taxe séjour **/
        $taxe = $this->Taxes->find('all',["conditions"=>[
            "Taxes.id_villes" => $annonce->ville,
            "Taxes.nb_etoile" => $annonce->nb_etoiles,
            "Taxes.du <='" . $startDate . "'",
            "Taxes.au >='" . $startDate ."'"
        ]])->first();

		if (!$taxe) {
            $taxe = $this->Taxes->find('all',["conditions"=>[
                "Taxes.id_villes" => 32190,
                "Taxes.nb_etoile" => $annonce->nb_etoiles,
                "Taxes.du <='" . $startDate . "'",
                "Taxes.au >='" . $startDate . "'"
            ]])->first();

            $resultatDetail['messageimpotext']="Pas de taxe configurée pour la ville de cette annonce. La taxe est calculée sur la base de la ville de BOURG ST MAURICE";
        }

		$dispos = $this->Dispos->chercherdisponibiliteSansStatut($annonce_id, $startDate, $endDate);

        $resultatDetail = [
            'du'                 => new Date($startDate),
            'au'                 => new Date($endDate),
            'nbrperiode'         => $dispos->count(),
            'dispoID'            => '',
            'prixtaxeapayer'     => 0,
            'nights'             => 0,
            'total_price'        => 0,
            'totalSanspromo'     => 0,
            'period_price_dates' => [],
            'taxes'              => [],
        ];

		if ($dispos->count() == 1) {
            $dispo = $dispos->first();
            $nightPrice = 0;
            $nightPriceNoPromo = 0;
            $resultatDetail['nights'] = (new Date($endDate))->diff(new Date($startDate))->days;
            $nbrDiff = $dispo->fin_at->diff($dispo->dbt_at)->days;

			if ($dispo->prix_jour == 0 && $dispo->prix != 0 && $dispo->promo_yn == 0) {
                $nightPrice = round(($dispo->prix / $nbrDiff), 2);
			} else if ($dispo->promo_jour == 0 && $dispo->promo_px != 0 && $dispo->promo_yn == 1) {
                $nightPrice        = round(($dispo->promo_px / $nbrDiff), 2);
                $nightPriceNoPromo = round(($dispo->prix / $nbrDiff), 2);
			} else if ($dispo->promo_yn == 0) {
                $nightPrice = round($dispo->prix_jour, 2);
			} else if ($dispo->promo_yn == 1) {
                $nightPrice        = round($dispo->promo_jour, 2);
                $nightPriceNoPromo = round($dispo->prix_jour, 2);
			}

            $currentDate = new Date($startDate);
            $resultatDetail['period_price_dates'][0] = [];
            while ($currentDate < new Date($endDate)) {
                array_push($resultatDetail['period_price_dates'][0], [
                    'main_price' => $nightPrice,
                    'price'      => $nightPrice,
                    'day'        => new Date($currentDate)
                ]);
                $currentDate = $currentDate->addDay(1);
            }

            $resultatDetail['total_price']    = $nightPrice * $resultatDetail['nights'];
			$resultatDetail['totalSanspromo'] = $dispo->promo_yn == 1 ? $nightPriceNoPromo * $resultatDetail['nights'] : 0;

			$resultatDetail['dispoID'] .= $dispo->id;

			if ($taxe) {
                $resultatDetail['taxes'] = [$taxe];
			}
		} else {
            $startDate = new Date($startDate);
            $promoval  = 0;

			foreach ($dispos as $i => $dispo) {
                if ($dispo->fin_at != "") {
                    $nightNum = 0;
                    $nightPrice = 0;
                    $nightPriceNoPromo = 0;
					$nbrDiff = ($dispo->fin_at)->diff($dispo->dbt_at)->days;
                	$fn = new Date($dispo->fin_at->i18nFormat('dd-MM-yyyy'));

                	if($fn < new Date($endDate)){
                        $nightNum = $fn->diff($startDate)->days;
                        $resultatDetail['nights'] += $nightNum;
						$periodedu = $startDate;
						$periodeau = $fn;
                        $startDate = $fn;
					} else {
                        $nightNum = (new Date($endDate))->diff($startDate)->days;
                        $resultatDetail['nights'] += $nightNum;
                        $periodedu = $startDate;
                        $periodeau = new Date($endDate);
					}

					if ($dispo->prix_jour == 0 && $dispo->prix != 0 && $dispo->promo_yn == 0) {
                        $nightPrice = round(($dispo->prix / $nbrDiff), 2);
					} else if($dispo->promo_jour == 0 && $dispo->promo_px != 0 && $dispo->promo_yn == 1) {
                        $nightPrice        = round(($dispo->promo_px / $nbrDiff), 2);
                        $nightPriceNoPromo = round(($dispo->prix / $nbrDiff), 2);
					} else if($dispo->promo_yn == 0) {
                        $nightPrice = round($dispo->prix_jour, 2);
					} else if($dispo->promo_yn == 1) {
                        $nightPrice        = round($dispo->promo_jour, 2);
                        $nightPriceNoPromo = round($dispo->prix_jour, 2);
					}

                    $resultatDetail['period_price_dates'][$i] = [];
                    $currentDate = new Date($periodedu);
                    while($currentDate < $periodeau) {
                        array_push($resultatDetail['period_price_dates'][$i], [
                            'main_price' => $nightPrice,
                            'price'      => $nightPrice,
                            'day'        => new Date($currentDate)
                        ]);
                        $currentDate = $currentDate->addDay(1);
                    }

    				$resultatDetail['total_price'] += $nightPrice * $nightNum;

					if ($dispo->promo_yn == 1) {
						if ($promoval == 0) $promoval = 1;
						$resultatDetail['totalSanspromo'] += $nightPriceNoPromo * $nightNum;
					} else {
						$resultatDetail['totalSanspromo'] += $nightPrice * $nightNum;
					}

					$resultatDetail['dispoID'] .= $dispo->id . "_" . $periodedu . "_" . $periodeau . "-";

					/** Calcul taxe de séjour poue cette période **/
					/** Taxe séjour **/
                    $taxe=$this->Taxes->find('all',["conditions"=>["Taxes.id_villes"=>$annonce->ville,"Taxes.nb_etoile"=>$annonce->nb_etoiles,"Taxes.du <='".$dispo->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$dispo->dbt_at->i18nFormat('yyyy-MM-dd')."'"]])->first();

					if(!$taxe){
                        $taxe = $this->Taxes->find('all',["conditions"=>["Taxes.id_villes"=>32190,"Taxes.nb_etoile"=>$annonce->nb_etoiles,"Taxes.du <='".$dispo->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$dispo->dbt_at->i18nFormat('yyyy-MM-dd')."'"]])->first();
					}

                    $resultatDetail['taxes'][$i] = $taxe ? $taxe : [];
				}				
			}

			if ($promoval == 0) $resultatDetail['totalSanspromo'] = 0;
		}

        $this->applyAutomaticPromo($annonce, $resultatDetail);
        $this->calculateTaxes($annonce->nb_etoiles, $nbradulte, $nbrenfant, $resultatDetail);

		return $resultatDetail;
	}
	/**
	 * 
	 */
	public function calculertotalprixperiode()
	{
        $this->viewBuilder()->layout(false);

        // Info Propriétaire
        $this->loadModel("Annonces");
        $annonce = $this->Annonces->get($this->request->data["annonce_id"]);
        $this->set("fraisdemenage",$annonce->montant_frais_menage);
        $this->set("acceptanimal",$annonce->accept_animaux);
        $this->set("demandefraisanimal",$annonce->demande_frais_animaux);
        $this->set("fraisanimaux",$annonce->montant_frais_animaux);

		$resultatDetail = $this->calcultaxedesejour($this->request->data["annonce_id"], $this->request->data["sel"], $this->request->data["nbradulte"], $this->request->data["nbrenfant"]);
        $this->set("resultatDetail",$resultatDetail);
		$fraiserviceprop = 10.6;
		$typefraiserviceprop = "pourcentage";
		$this->loadModel("Utilisateurs");
		$proprietaire = $this->Utilisateurs->find("all")->contain(['Paiements'])->where(["Utilisateurs.id" => $annonce->proprietaire_id]);
		if($proprietaire = $proprietaire->first()){
			if(!empty($proprietaire->paiements)){
				$fraiserviceprop = $proprietaire->paiements[0]->frais_service;
				$typefraiserviceprop = $proprietaire->paiements[0]->type_frais;
			} 
		}
		$this->set("fraiserviceprop",$fraiserviceprop);
		$this->set("typefraiserviceprop",$typefraiserviceprop);
	}
	/**
	 * 
	 */
	public function prixtotalpourpetiteannonce($annonce_id, $sel, $nbradulte, $nbrenfant)
	{
		$this->viewBuilder()->layout(false);
		$resultatDetail = $this->calcultaxedesejour($annonce_id, $sel, $nbradulte, $nbrenfant);
		// Info Propriétaire
		$this->loadModel("Annonces");
		$annonce = $this->Annonces->get($annonce_id);
		$fraiserviceprop = 10.6;
		$typefraiserviceprop = "pourcentage";
		$this->loadModel("Utilisateurs");
		$proprietaire = $this->Utilisateurs->find("all")->contain(['Paiements'])->where(["Utilisateurs.id" => $annonce->proprietaire_id]);
		if($proprietaire = $proprietaire->first()){
			if(!empty($proprietaire->paiements)){
				$fraiserviceprop = $proprietaire->paiements[0]->frais_service;
				$typefraiserviceprop = $proprietaire->paiements[0]->type_frais;
			} 
		}

        $fraisAlpissime = $typefraiserviceprop == "fixe" ? $fraiserviceprop : ($resultatDetail['total_price'] - $resultatDetail['automaticPromo']['value'])/100 * $fraiserviceprop;
        $fraisStripe = ($resultatDetail['total_price'] - $resultatDetail['automaticPromo']['value'])/100 * 1.4;

        $retourresult = [
            'nbrjour'        => $resultatDetail['nights'],
            'totalSanspromo' => round($resultatDetail['totalSanspromo'],2),
            'prixTotal'      => round($resultatDetail['total_price'],2),
            'taxeDeSejour'   => round($resultatDetail['prixtaxeapayer'],2),
            'fraisService'   => round(($fraisAlpissime + $fraisStripe),2),
        ];
        $retourresult['totalPrixPayer'] = round(($retourresult['prixTotal'] + $retourresult['taxeDeSejour'] + $retourresult['fraisService'] - $resultatDetail['automaticPromo']['value']),2);

		return $retourresult;
	}
	/**
	 * 
	 */
	public function calculertotalprixperiodebyidreservation()
	{
		$this->viewBuilder()->layout(false);
		$this->loadModel("Reservations");
		$reservation = $this->Reservations->get($this->request->data["id_reservation"]);
		$dates = $reservation->dbt_at->i18nFormat('yyyy-MM-dd')."/".$reservation->fin_at->i18nFormat('yyyy-MM-dd');
		$resultatDetail = $this->calcultaxedesejour($reservation->annonce_id, $dates, $reservation->nb_adultes, $reservation->nb_enfants);
		$this->set("resultatDetail",$resultatDetail);
		// Info Propriétaire
		$this->loadModel("Annonces");
		$annonce = $this->Annonces->get($reservation->annonce_id);
		$this->set("fraisdemenage",$annonce->montant_frais_menage);
		$this->set("acceptanimal",$annonce->accept_animaux);
		$this->set("demandefraisanimal",$annonce->demande_frais_animaux);
		$this->set("fraisanimaux",$annonce->montant_frais_animaux);
		$tauxcommissionprop = 0;
		$this->loadModel("Utilisateurs");
		$proprietaire = $this->Utilisateurs->find("all")->contain(['Annulations', 'Paiements'])->where(["Utilisateurs.id" => $annonce->proprietaire_id]);
		if($proprietaire = $proprietaire->first()){
			// liste règle annulation
			$this->loadModel("Annulations");
			$listeannulation = $this->Annulations->find("all")->where(['name' => $proprietaire->annulations[0]->name]);
			$this->set("listeannulation",$listeannulation);
			if(!empty($proprietaire->paiements)) $tauxcommissionprop = $proprietaire->paiements[0]->taux_commission;
		}
		$this->set("tauxcommissionprop",$tauxcommissionprop);
	}
}
