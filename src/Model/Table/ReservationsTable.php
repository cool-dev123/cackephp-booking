<?php
namespace App\Model\Table;

use App\Model\Entity\Reservation;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\ORM\TableRegistry;

/**
 * Reservations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Annonces
 * @property \Cake\ORM\Association\BelongsTo $Utilisateurs
 * @property \Cake\ORM\Association\HasMany $Dispos
 * @property \Cake\ORM\Association\BelongsToMany $Packs
 */
class ReservationsTable extends Table
{
    
    

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('reservations');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Annonces', [
            'foreignKey' => 'annonce_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Utilisateurs', [
            'foreignKey' => 'utilisateur_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Utilisateurs', [
            'foreignKey' => 'utilisateur_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Dispos', [
            'foreignKey' => 'reservation_id'
        ]);
    }
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');
		    $validator
            ->integer('nb_enfants')
            ->allowEmpty('nb_enfants');

        $validator
            ->integer('nb_adultes')
            ->allowEmpty('nb_adultes');

        return $validator;
    }

    function beforeSave($event, $entity, $options)
    {
        if ($entity->isNew()) {
            if (!isset($entity->comment)) {
                $entity->comment = '';
            }

            if (!isset($entity->commentaire_inventaire)) {
                $entity->commentaire_inventaire = '';
            }

            if (!isset($entity->commentlocataire)) {
                $entity->commentlocataire = '';
            }

            if (!isset($entity->commande_id)) {
                $entity->commande_id = 0;
            }

            if (!isset($entity->verif_for_prop)) {
                $entity->verif_for_prop = 0;
            }

            if (!isset($entity->increment_id)) {
                $entity->increment_id = 0;
            }

            if (!isset($entity->quote_id)) {
                $entity->quote_id = 0;
            }

            if (!isset($entity->inventaire_loc)) {
                $entity->inventaire_loc = '';
            }

            if (!isset($entity->num_facture_commission)) {
                $entity->num_facture_commission = '';
            }
        }

        return true;
    }
    /**
     *
     **/
   function dernierlocatairearr($id){
     $a_where[]='Reservations.arrivee=1';
     $a_where[]='Reservations.annonce_id='.$id;
     $arrivee = $this->find()
 					->join([
 						'U' => [
 							'table' => 'utilisateurs',
 							'type' => 'INNER',
 							'conditions' => 'U.id = Reservations.utilisateur_id',
             ],
             'dispo' => [
							'table' => 'dispos',
							'type' => 'inner',
							'conditions' => 'dispo.reservation_id=Reservations.id',
						]
 					])
 					->select(['U.prenom','U.nom_famille','U.email','U.portable','Reservations.dbt_at','Reservations.fin_at','Reservations.p_cle'])
 					->where($a_where)
          ->order(['Reservations.dbt_at'=>'desc']);
 			return $arrivee;
   }
   /**
    *
    **/
	function searchArrivees($url,$get,$id_ges){
		$a_where[]='Reservations.arrivee=0';
		$arrivee = $this->find()
					->join([
						'A' => [
							'table' => 'annonces',
							'type' => 'inner',
							'conditions' => 'A.id = reservations.id',
						],
						'U' => [
							'table' => 'utilisateurs',
							'type' => 'INNER',
							'conditions' => 'U.id = reservations.utilisateur_id',
						],
						'RS' => [
							'table' => 'residences',
							'type' => 'left',
							'conditions' => 'A.batiment=RS.id',
						],
						'V' => [
							'table' => 'villages',
							'type' => 'left',
							'conditions' => 'V.id=RS.id_village',
						],
						// 'AN' => [
						// 	'table' => 'annoncegestionnaires',
						// 	'type' => 'inner',
						// 	'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
						// ],
						'CR' => [
							'table' => 'contrats',
							'type' => 'INNER',
							'conditions' => 'CR.annonce_id=A.id',
						],
						'CT' => [
							'table' => 'contratypes',
							'type' => 'inner',
							'conditions' => ['CT.id=CR.type','CT.id!=3'],
						],
						'G' => [
							'table' => 'gestionnaires',
							'type' => 'INNER',
							'conditions' => ['G.id=A.id_gestionnaires',"G.id=$id_ges",'Reservations.statut=90'],
            ],
            'dispo' => [
							'table' => 'dispos',
							'type' => 'inner',
							'conditions' => 'dispo.reservation_id=Reservations.id',
						]
					])
					->select(['Reservations.id','Reservations.dbt_at','Reservations.fin_at','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','A.position_cle','A.id','A.nb_etoiles','A.id_ville','A.num_app','RS.name','V.name'])
					->where($a_where);
			return $arrivee;
		}
    /**
     *
     **/
		function getReservationsProprietaire($id){
			$arrivee = $this->find()
					->join([
						'annonce' => [
							'table' => 'annonces',
							'type' => 'inner',
							'conditions' => 'annonce.id = Reservations.annonce_id',
						],
						'utilisateur' => [
							'table' => 'utilisateurs',
							'type' => 'INNER',
							'conditions' => 'utilisateur.id = Reservations.utilisateur_id',
						],
						'lieugeo' => [
							'table' => 'lieugeos',
							'type' => 'inner',
							'conditions' => 'lieugeo.id=annonce.lieugeo_id',
						],
						'dispo' => [
							'table' => 'dispos',
							'type' => 'inner',
							'conditions' => 'dispo.reservation_id=Reservations.id',
						],
						'residences' => [
							'table' => 'residences',
							'type' => 'left',
							'conditions' => 'residences.id=annonce.batiment',
						]
					]);
					$arrivee->select(['dispo.calendarsynchro_id','Reservations.num_facture_commission','Reservations.inventaire_loc','residences.name','lieugeo.name', 'annonce.titre','annonce.num_app', 'annonce.id', 'Reservations.dbt_at','Reservations.arrivee', 'Reservations.fin_at', 'Reservations.type', 'utilisateur.nom_famille', 'utilisateur.prenom', 'utilisateur.code_postal','utilisateur.ville','utilisateur.telephone', 'utilisateur.portable', 'utilisateur.email', 'Reservations.id','Reservations.statut','Reservations.prixreservation','dispo.id','dispo.promo_yn','total'=>$arrivee->func()->sum('IF (dispo.promo_yn=0 , dispo.prix , dispo.promo_px)')])
					->where(['Reservations.statut <> 0','Reservations.statut <> 50',"Reservations.statut <> 60","annonce.proprietaire_id "=>$id])
          ->group('Reservations.id')
					->order(['Reservations.dbt_at'=>'desc']);
			return $arrivee;
    }
    /**
     * 
     */
    function getSumReservationsXML($tabwhere)
    {
      $arrivee = $this->find()
					->join([
						'annonce' => [
							'table' => 'annonces',
							'type' => 'inner',
							'conditions' => 'annonce.id = Reservations.annonce_id',
						],
						'utilisateur' => [
							'table' => 'utilisateurs',
							'type' => 'INNER',
							'conditions' => 'utilisateur.id = Reservations.utilisateur_id',
						],
						'lieugeo' => [
							'table' => 'lieugeos',
							'type' => 'inner',
							'conditions' => 'lieugeo.id=annonce.lieugeo_id',
						],
						'dispo' => [
							'table' => 'dispos',
							'type' => 'inner',
							'conditions' => ['dispo.reservation_id=Reservations.id', 'dispo.calendarsynchro_id=0'],
						],
						'residences' => [
							'table' => 'residences',
							'type' => 'left',
							'conditions' => 'residences.id=annonce.batiment',
						]
					]);
					// $arrivee->select(['Reservations.id','count'=>$arrivee->func()->count('*'),'total'=>$arrivee->func()->sum('IF (Reservations.prixreservation=0, IF (dispo.promo_yn=0 , dispo.prix , dispo.promo_px), Reservations.prixreservation)')])
					$arrivee->select(['Reservations.id','Reservations.prixreservation', 'dispo.promo_yn', 'dispo.prix', 'dispo.promo_px', "annonce.proprietaire_id"])
					->where($tabwhere)
          // ->group('Reservations.id')
					->order(['Reservations.dbt_at'=>'desc']);
			return $arrivee;
    }
    /**
     *
     **/
		function getReservationsProprietaireRecherche($id,$mot,$statut){
			$arrivee = $this->find()
					->join([
						'annonce' => [
							'table' => 'annonces',
							'type' => 'inner',
							'conditions' => 'annonce.id = Reservations.annonce_id',
						],
						'utilisateur' => [
							'table' => 'utilisateurs',
							'type' => 'INNER',
							'conditions' => 'utilisateur.id = Reservations.utilisateur_id',
						],
						'lieugeo' => [
							'table' => 'lieugeos',
							'type' => 'inner',
							'conditions' => 'lieugeo.id=annonce.lieugeo_id',
						],
						'dispo' => [
							'table' => 'dispos',
							'type' => 'inner',
							'conditions' => 'dispo.reservation_id=Reservations.id',
						]
					]);
					$arrivee->select(['lieugeo.name', 'annonce.titre','annonce.statut','Reservations.arrivee', 'Reservations.dbt_at', 'Reservations.fin_at','utilisateur.nom_famille', 'utilisateur.prenom', 'utilisateur.code_postal','utilisateur.ville','utilisateur.telephone', 'utilisateur.email', 'Reservations.id','Reservations.statut','dispo.id','dispo.promo_yn','total'=>$arrivee->func()->sum('IF (dispo.promo_yn=0 , dispo.prix , dispo.promo_px)')])
          ->group('Reservations.id');

					if(!empty($statut)){
						$arrivee = $arrivee->where(['Reservations.statut <> 10', "Reservations.fin_at > CURDATE()" ,"annonce.proprietaire_id "=>$id,'OR' => [["utilisateur.nom_famille LIKE '%".$mot."%'"], ["Reservations.statut = ".key($statut)], ["utilisateur.prenom LIKE '%".$mot."%'"]]])
						->order(['Reservations.dbt_at'=>'desc']);
					}else{
						$arrivee = $arrivee->where(['Reservations.statut <> 10', "Reservations.fin_at > CURDATE()" ,"annonce.proprietaire_id "=>$id,'OR' => [["utilisateur.nom_famille LIKE '%".$mot."%'"], ["utilisateur.prenom LIKE '%".$mot."%'"]]])
						->order(['Reservations.dbt_at'=>'desc']);
					}
			return $arrivee;
		}
    /**
     *
     **/
		function getReservations($id){
			$arrivee = $this->find()
					->join([
						'annonce' => [
							'table' => 'annonces',
							'type' => 'inner',
							'conditions' => 'annonce.id = Reservations.annonce_id',
						],
						'utilisateur' => [
							'table' => 'utilisateurs',
							'type' => 'INNER',
							'conditions' => 'utilisateur.id = Reservations.utilisateur_id',
						],
						'lieugeo' => [
							'table' => 'lieugeos',
							'type' => 'inner',
							'conditions' => 'lieugeo.id=annonce.lieugeo_id',
						],
						'dispo' => [
							'table' => 'dispos',
							'type' => 'inner',
							'conditions' => 'dispo.reservation_id=Reservations.id',
						]
					])
					->select(['lieugeo.name', 'annonce.titre', 'Reservations.dbt_at', 'Reservations.fin_at','utilisateur.nom_famille', 'utilisateur.prenom', 'utilisateur.code_postal','utilisateur.ville','utilisateur.telephone', 'utilisateur.email', 'Reservations.id','Reservations.statut','dispo.id','dispo.promo_yn','dispo.promo_px','dispo.prix'])
					->where(['Reservations.statut <> 10',"annonce.id "=>$id])
					->order(['Reservations.dbt_at'=>'desc']);
			return $arrivee;
		}

    /**
     *
     **/
    public function getReservationById($id)
    {
        $reservation = $this->find()
            ->contain([
                'Utilisateurs',
                'Annonces' => [
                    'Villages' => 'Frvilles',
                    'Residences',
                    'Utilisateurs'
                ],
                'Dispos'
            ])
            ->where(['Reservations.id'=> $id])
            ->first();

        return $reservation;
    }
		 /*
     * Liste des r�servations � valider
     */
    public function getReservationsAValider($proprietaire_id)
	    {
        $arrivee = $this->find()
					->join([
						'annonce' => [
							'table' => 'annonces',
							'type' => 'inner',
							'conditions' => 'annonce.id = Reservations.annonce_id',
						],
						'utilisateur' => [
							'table' => 'utilisateurs',
							'type' => 'INNER',
							'conditions' => 'utilisateur.id = Reservations.utilisateur_id',
						],
						'lieugeo' => [
							'table' => 'lieugeos',
							'type' => 'inner',
							'conditions' => 'lieugeo.id=annonce.lieugeo_id',
						],
						'dispo' => [
							'table' => 'dispos',
							'type' => 'inner',
							'conditions' => 'dispo.reservation_id=Reservations.id',
						]
					]);
					$arrivee->select(['lieugeo.name', 'annonce.titre','annonce.id', 'annonce.contrat','annonce.mise_relation','Reservations.dbt_at', 'Reservations.fin_at','utilisateur.nom_famille', 'utilisateur.prenom', 'utilisateur.code_postal','utilisateur.ville','utilisateur.telephone', 'utilisateur.portable', 'utilisateur.email', 'Reservations.id','Reservations.statut','Reservations.prixreservation','dispo.id','dispo.promo_yn','total'=>$arrivee->func()->sum('IF (dispo.promo_yn=0 , dispo.prix , dispo.promo_px)')])
					->where(['dispo.statut = 50',"annonce.proprietaire_id "=>$proprietaire_id, "Reservations.fin_at > CURDATE()", "Reservations.statut = 50"])
          ->group('Reservations.id')
					->order(['Reservations.dbt_at'=>'desc']);
			return $arrivee;
    }

    /**
     *
     **/
    function getReservationsLocataireOld($id){
        $arrivee = $this->find()
            ->join([
                'annonce' => [
                    'table' => 'annonces',
                    'type' => 'inner',
                    'conditions' => 'annonce.id = Reservations.annonce_id',
                ],
                'utilisateur' => [
                    'table' => 'utilisateurs',
                    'type' => 'INNER',
                    'conditions' => 'utilisateur.id = annonce.proprietaire_id',
                ],
                'lieugeo' => [
                    'table' => 'lieugeos',
                    'type' => 'left',
                    'conditions' => 'lieugeo.id=annonce.lieugeo_id',
                ],
                'dispo' => [
                    'table' => 'dispos',
                    'type' => 'inner',
                    'conditions' => 'dispo.reservation_id=Reservations.id',
                ]
            ]);
        $arrivee->select(['lieugeo.name','lieugeo.nom_url', 'annonce.titre','annonce.nature', 'Reservations.annonce_id', 'Reservations.prixreservation', 'Reservations.prixapayer', 'Reservations.dbt_at','Reservations.arrivee', 'Reservations.fin_at','utilisateur.nom_famille', 'utilisateur.prenom', 'utilisateur.code_postal','utilisateur.ville','utilisateur.telephone', 'utilisateur.email', 'utilisateur.portable', 'Reservations.id','Reservations.statut'])
            ->where(["Reservations.utilisateur_id "=>$id, "Reservations.statut <> 0"])
            ->group('Reservations.id')
            ->order(['Reservations.dbt_at'=>'desc']);
        return $arrivee;
    }

    /**
     *
     **/
    function getReservationsLocataire($id)
    {
        $query = $this->find()
            ->contain([
                'Utilisateurs',
                'Annonces' => [
                    'Utilisateurs',
                    'Photos' => function (Query $query) {
                        return $query->order(['numero' => 'asc']);
                    }
                ],
                'Dispos'
            ])
            ->where([
                "Reservations.utilisateur_id " => $id,
                "Reservations.statut <> 0"
            ])
            ->group('Reservations.id')
            ->order(['Reservations.dbt_at'=>'desc']);
//        file_put_contents("/var/www/html/alpissime-location/debug", print_r("query = ", true), FILE_APPEND);
//        file_put_contents("/var/www/html/alpissime-location/debug", print_r($query, true), FILE_APPEND);
//        file_put_contents("/var/www/html/alpissime-location/debug", print_r("\n", true), FILE_APPEND);

        return $query;
    }
  /**
   *
   **/
  function get_array_taxe_de_sejour_recherche_pdf_count($id_gest, $dbt, $fin, $idutil){
    $awhere[] = 'Reservations.arrivee=1';
    $awhere[] = 'Reservations.statut=90';
    $awhere[] = 'Reservations.taxe=1';
    $dbtre = new Date($dbt);
    $dbtre = $dbtre->format('Y-m-d');
    $finre = new Date($fin);
    $finre = $finre->format('Y-m-d');
    $awhere[] = array('OR' => [["Reservations.fin_at > '$dbtre'","Reservations.fin_at <= '$finre'"], ["Reservations.dbt_at >= '$dbtre'", "Reservations.fin_at <= '$finre'"], ["Reservations.dbt_at > '$dbtre'","Reservations.dbt_at < '$finre'"], ["Reservations.dbt_at <= '$dbtre'","Reservations.fin_at > '$finre'"]]);

    $arrivee=$this->find();
    $arrivee->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['A.id = Reservations.annonce_id', 'A.proprietaire_id='.$idutil,'A.visible=1','Annonces.id_gestionnaires'=>$id_gest],
        ],
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'INNER',
          'conditions' => ['U.id = Reservations.utilisateur_id'],
        ],
        'RS' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'A.batiment=RS.id',
        ],
        'V' => [
          'table' => 'villages',
          'type' => 'left',
          'conditions' => 'V.id=RS.id_village',
        ],
        // 'AN' => [
        //   'table' => 'annoncegestionnaires',
        //   'type' => 'inner',
        //   'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
        // ],
        'CR' => [
          'table' => 'contrats',
          'type' => 'INNER',
          'conditions' => ['CR.annonce_id=A.id','CR.visible'=>1]
        ],
        'CT' => [
          'table' => 'contratypes',
          'type' => 'inner',
          'conditions' => ['CT.id=CR.type'],
        ],
        'dispo' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => 'dispo.reservation_id=Reservations.id',
        ]
        // 'G' => [
        //   'table' => 'gestionnaires',
        //   'type' => 'INNER',
        //   'conditions' => ['G.id=AN.id_gestionnaires',"G.id=".$id_gest],
        // ]
      ])
      ->select(['nbr' => $arrivee->func()->count('*')]);
      $arrivee->where([$awhere]);
      $arrivee->order(['Reservations.dbt_at'=>'desc']);
      $arrivee->group(['Reservations.id']);
      $count=$arrivee->first();
      return $count;
  }
  /**
   *
   **/
  function get_array_taxe_de_sejour_recherche_pdf_tableau($id_gest, $datedebut, $datefin, $taxe, $recherche){
        $awhere=array();
        $awhere[] = 'Reservations.arrivee=1';
        $awhere[] = 'Reservations.statut=90';
        if($taxe != 2) $awhere[] = 'Reservations.taxe='.$taxe;
        $recherche = strtoupper($recherche);
        if($recherche != "_") $awhere[] = array('OR' => [["UCASE(U.prenom) LIKE '%$recherche%'"], ["UCASE(U.nom_famille) LIKE '%$recherche%'"], ["UCASE(RS.name) LIKE '%$recherche%'"], ["UCASE(A.num_app) LIKE '%$recherche%'"]]);
        $dbt = new Date($datedebut);
        $fin = new Date($datefin);
        $dbt = $dbt->i18nFormat('yyyy-MM-dd');
        $fin = $fin->i18nFormat('yyyy-MM-dd');
        $awhere[] = array('OR' => [["Reservations.fin_at > '$dbt'","Reservations.fin_at <= '$fin'"], ["Reservations.dbt_at >= '$dbt'", "Reservations.fin_at <= '$fin'"], ["Reservations.dbt_at > '$dbt'","Reservations.dbt_at < '$fin'"], ["Reservations.dbt_at <= '$dbt'","Reservations.fin_at > '$fin'"]]);

        $arrivee=$this->find();
        $arrivee->join([
            'A' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['A.id = Reservations.annonce_id','A.visible=1','A.id_gestionnaires'=>$id_gest],
            ],
            'U' => [
              'table' => 'utilisateurs',
              'type' => 'INNER',
              'conditions' => ['U.id = Reservations.utilisateur_id'],
            ],
            'RS' => [
              'table' => 'residences',
              'type' => 'left',
              'conditions' => 'A.batiment=RS.id',
            ],
            'V' => [
              'table' => 'villages',
              'type' => 'left',
              'conditions' => 'V.id=RS.id_village',
            ],
            // 'AN' => [
            //   'table' => 'annoncegestionnaires',
            //   'type' => 'inner',
            //   'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
            // ],
            'CR' => [
              'table' => 'contrats',
              'type' => 'INNER',
              'conditions' => ['CR.annonce_id=A.id','CR.visible'=>1]
            ],
            'CT' => [
              'table' => 'contratypes',
              'type' => 'inner',
              'conditions' => ['CT.id=CR.type'],
            ],
            'dispo' => [
							'table' => 'dispos',
							'type' => 'inner',
							'conditions' => 'dispo.reservation_id=Reservations.id',
						]
            // 'G' => [
            //   'table' => 'gestionnaires',
            //   'type' => 'INNER',
            //   'conditions' => ['G.id=AN.id_gestionnaires',"G.id=".$id_gest],
            // ]
          ])
          ->select(['Reservations.id','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','Reservations.methode_paye','Reservations.taxe','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.nb_etoiles','A.ville','A.num_app','A.proprietaire_id','RS.name','V.name']);

          $arrivee->where([$awhere]);
          $arrivee->order(['Reservations.dbt_at'=>'desc']);
          $arrivee->group(['Reservations.id']);

          $output = array();
          $totaltaxe = 0;
          $totalcheque = 0;
          $totalespece = 0;
          $totalCB = 0;
          foreach($arrivee as $c)
          {
            $row = array();
            $Taxes = TableRegistry::get('Taxes');
            $Dispos = TableRegistry::get('Dispos');

            if($c->dbt_at < new Date($dbt)) $c->dbt_at = new Date($dbt);
            if($c->fin_at > new Date($fin)) $c->fin_at = new Date($fin);

            // Taxe de séjour
            $dispocontroller = new \App\Controller\DisposController();
            $dates = $c->dbt_at->i18nFormat('dd-MM-yyyy')."/".$c->fin_at->i18nFormat('dd-MM-yyyy');
            $resultatDetail = $dispocontroller->calcultaxedesejour($c->annonce_id, $dates, $c->nb_adultes, $c->nb_enfants);
            $v_taxe = $resultatDetail['prixtaxeapayer'];

            // $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>$c['A']['ville'],"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
            // $s = strtotime( $c->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($c->dbt_at->i18nFormat('yyyy-MM-dd'));
            // $d = intval($s/86400);
            // $v_taxe=0;

            // if($r_taxe->first()){
            //   $taxe=$r_taxe->first();
            // }else{
            //   $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>32190,"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
            //   $taxe=$r_taxe->first();
            // }
            // if($taxe){
              
            //     $v_taxe = 0;
            //     if($c['A']['nb_etoiles'] == 0){
            //         /** Nouveau calcul Taxe 0* **/
            //         $list_dispos = $Dispos->find()->where(['Dispos.reservation_id = '.$c->id]);

            //         foreach ($list_dispos as $ldispo){
            //             $ss = strtotime( $ldispo->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($ldispo->dbt_at->i18nFormat('yyyy-MM-dd'));
            //             $dd = intval($ss/86400);
            //             //// CALCUL PRIX NUITEE
            //             if($ldispo->prix_jour == 0 && $ldispo->prix != 0 && $ldispo->promo_yn == 0){
            //                 $prixnuitee = $ldispo->prix / $dd;
            //             }else if($ldispo->promo_jour == 0 && $ldispo->promo_px != 0 && $ldispo->promo_yn == 1){
            //                 $prixnuitee = $ldispo->promo_px / $dd;
            //             }else if($ldispo->promo_yn == 0){
            //                 $prixnuitee = $ldispo->prix_jour;
            //             }else if($ldispo->promo_yn == 1){
            //                 $prixnuitee = $ldispo->promo_jour;
            //             }
            //             //// Taxe par nuitée/personne
            //             $nouvelletaxe = ($prixnuitee / ($c->nb_adultes + $c->nb_enfants)) * ($taxe->valeur / 100);
            //             if($nouvelletaxe > 2.3) {
            //                 $nouvelletaxe = 2.3 * $c->nb_adultes;                        
            //             }else {
            //                 $nouvelletaxe = $nouvelletaxe * $c->nb_adultes;                        
            //             }
            //             //// Ajouter 10% taxe departementale
            //             $nouvelletaxe10 = $nouvelletaxe + ($nouvelletaxe * 1/10);
            //             //// Taxe Totale
            //             $v_taxe += $nouvelletaxe10 * $dd;                       
            //         }
            //        /** Fin Nouveau calcul Taxe 0* **/ 
            //     }else{
            //         $v_taxe=$taxe->valeur*$c->nb_adultes*$d;
            //     }
              
            //   //$v_taxe=$taxe->valeur*$c->nb_adultes*$d;
            // }

            $row[0]=$c->dbt_at->i18nFormat('dd/MM/yyyy');
            $row[1]=$c->fin_at->i18nFormat('dd/MM/yyyy');
            $row[2]=$c['U']['prenom']." ".$c['U']['nom_famille'];
            $row[3]=$c['RS']['name'];
            $row[4]=$c['A']['num_app'];
            if($c->methode_paye == 2){
              $row[5]=abs(number_format($v_taxe, 2, '.', ''));
              $row[6]="";
              $row[7]="";
              $totalcheque = $totalcheque + abs(number_format($v_taxe, 2, '.', ''));
            }else if($c->methode_paye == 1){
              $row[5]="";
              $row[6]=abs(number_format($v_taxe, 2, '.', ''));
              $row[7]="";
              $totalespece = $totalespece + abs(number_format($v_taxe, 2, '.', ''));
            }else if($c->methode_paye == 3){
              $row[5]="";
              $row[6]="";
              $row[7]=abs(number_format($v_taxe, 2, '.', ''));
              $totalCB = $totalCB + abs(number_format($v_taxe, 2, '.', ''));
            }else{
              $row[5]="";
              $row[6]="";
              $row[7]="";
            }
            $row[8]=abs(number_format($v_taxe, 2, '.', ''));
            $totaltaxe = $totaltaxe + $row[8];
            $row[9] = $totaltaxe;
            $row[10] = $totalespece;
            $row[11] = $totalcheque;
            $row[12] = $totalCB;
            $output[] = $row;
          }
        return $output;
  }
  /**
   *
   **/
  function get_array_taxe_de_sejour_recherche_pdf($id_gest, $dbt, $fin, $idutil){
    $awhere[] = 'Reservations.arrivee=1';
    $awhere[] = 'Reservations.statut=90';
    $awhere[] = 'Reservations.taxe=1';

    $dbtre = new Date($dbt);
    $dbtre = $dbtre->format('Y-m-d');
    $finre = new Date($fin);
    $finre = $finre->format('Y-m-d');
    $awhere[] = array('OR' => [["Reservations.fin_at > '$dbtre'","Reservations.fin_at <= '$finre'"], ["Reservations.dbt_at >= '$dbtre'", "Reservations.fin_at <= '$finre'"], ["Reservations.dbt_at > '$dbtre'","Reservations.dbt_at < '$finre'"], ["Reservations.dbt_at <= '$dbtre'","Reservations.fin_at > '$finre'"]]);

    $arrivee=$this->find();
    $arrivee->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['A.id = Reservations.annonce_id','A.visible=1','A.id_gestionnaires'=>$id_gest],
        ],
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'INNER',
          'conditions' => ['U.id = Reservations.utilisateur_id'],
        ],
        'RS' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'A.batiment=RS.id',
        ],
        'V' => [
          'table' => 'villages',
          'type' => 'left',
          'conditions' => 'V.id=RS.id_village',
        ],
        // 'AN' => [
        //   'table' => 'annoncegestionnaires',
        //   'type' => 'inner',
        //   'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
        // ],
        'CR' => [
          'table' => 'contrats',
          'type' => 'INNER',
          'conditions' => ['CR.annonce_id=A.id','CR.visible'=>1]
        ],
        'CT' => [
          'table' => 'contratypes',
          'type' => 'inner',
          'conditions' => ['CT.id=CR.type'],
        ],
        'dispo' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => 'dispo.reservation_id=Reservations.id',
        ]
        // 'G' => [
        //   'table' => 'gestionnaires',
        //   'type' => 'INNER',
        //   'conditions' => ['G.id=AN.id_gestionnaires',"G.id=".$id_gest],
        // ]
      ])
      ->select(['Reservations.id','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','Reservations.methode_paye','Reservations.taxe','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.nb_etoiles','A.ville','A.num_app','A.proprietaire_id','RS.name','V.name']);
      $arrivee->where([$awhere]);
      $arrivee->order(['Reservations.dbt_at'=>'desc']);
      $arrivee->group(['Reservations.id']);

      $output = array();
      $totaltaxe = 0;
      $totalcheque = 0;
      $totalespece = 0;
      $totalCB = 0;
      foreach($arrivee as $c)
      {
        $row = array();
        $Taxes = TableRegistry::get('Taxes');
        $Dispos = TableRegistry::get('Dispos');

        if($c->dbt_at < new Date($dbt)) $c->dbt_at = new Date($dbt);
        if($c->fin_at > new Date($fin)) $c->fin_at = new Date($fin);

        // Taxe de séjour
        $dispocontroller = new \App\Controller\DisposController();
        $dates = $c->dbt_at->i18nFormat('dd-MM-yyyy')."/".$c->fin_at->i18nFormat('dd-MM-yyyy');
        $resultatDetail = $dispocontroller->calcultaxedesejour($c->annonce_id, $dates, $c->nb_adultes, $c->nb_enfants);
        $v_taxe = $resultatDetail['prixtaxeapayer'];

        // $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>$c['A']['ville'],"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
        // $s = strtotime( $c->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($c->dbt_at->i18nFormat('yyyy-MM-dd'));
        // $d = intval($s/86400);
        // $v_taxe=0;

        // if($r_taxe->first()){
        //   $taxe=$r_taxe->first();
        // }else{
        //   $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>32190,"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
        //   $taxe=$r_taxe->first();
        // }
        // if($taxe){
          
        //     $v_taxe = 0;
        //     if($c['A']['nb_etoiles'] == 0 && $c->dbt_at->i18nFormat('yyyy') == '2019'){
        //         /** Nouveau calcul Taxe 0* **/
        //         $list_dispos = $Dispos->find()->where(['Dispos.reservation_id = '.$c->id]);

        //         foreach ($list_dispos as $ldispo){
        //             $ss = strtotime( $ldispo->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($ldispo->dbt_at->i18nFormat('yyyy-MM-dd'));
        //             $dd = intval($ss/86400);
        //             //// CALCUL PRIX NUITEE
        //             if($ldispo->prix_jour == 0 && $ldispo->prix != 0 && $ldispo->promo_yn == 0){
        //                 $prixnuitee = $ldispo->prix / $dd;
        //             }else if($ldispo->promo_jour == 0 && $ldispo->promo_px != 0 && $ldispo->promo_yn == 1){
        //                 $prixnuitee = $ldispo->promo_px / $dd;
        //             }else if($ldispo->promo_yn == 0){
        //                 $prixnuitee = $ldispo->prix_jour;
        //             }else if($ldispo->promo_yn == 1){
        //                 $prixnuitee = $ldispo->promo_jour;
        //             }
        //             //// Taxe par nuitée/personne
        //             $nouvelletaxe = ($prixnuitee / ($c->nb_adultes + $c->nb_enfants)) * ($taxe->valeur / 100);
        //             if($nouvelletaxe > 2.3) {
        //                 $nouvelletaxe = 2.3 * $c->nb_adultes;                        
        //             }else {
        //                 $nouvelletaxe = $nouvelletaxe * $c->nb_adultes;                        
        //             }
        //             //// Ajouter 10% taxe departementale
        //             $nouvelletaxe10 = $nouvelletaxe + ($nouvelletaxe * 1/10);
        //             //// Taxe Totale
        //             $v_taxe += $nouvelletaxe10 * $dd;                       
        //         }
        //        /** Fin Nouveau calcul Taxe 0* **/ 
        //     }else{
        //         $v_taxe=$taxe->valeur*$c->nb_adultes*$d;
        //     }
          
        //   //$v_taxe=$taxe->valeur*$c->nb_adultes*$d;
        // }
        $row[0]=$c->dbt_at->i18nFormat('dd/MM/yyyy');
        $row[1]=$c->fin_at->i18nFormat('dd/MM/yyyy');
        $row[2]=$c['RS']['name'];
        $row[3]=$c['A']['num_app'];
        $row[4]=$c['U']['prenom']." ".$c['U']['nom_famille'];
        $row[5]=$c->nb_adultes;
        $row[6]=$c->nb_enfants;
        if($c->methode_paye == 1){
          $row[7]= "Espèce";
          $totalespece = $totalespece + abs(number_format($v_taxe, 2, '.', ''));
        }else if($c->methode_paye == 2){
          $row[7]= "Chèque";
          $totalcheque = $totalcheque + abs(number_format($v_taxe, 2, '.', ''));
        }else if($c->methode_paye == 3){
          $row[7]= "Carte Bancaire";
          $totalCB = $totalCB + abs(number_format($v_taxe, 2, '.', ''));
        }else{
          $row[7] = "";
        }
        $row[8]=abs(number_format($v_taxe, 2, '.', ''));
        $totaltaxe = $totaltaxe + $row[8];
        $row[9] = $totaltaxe;
        $row[10] = $totalespece;
        $row[11] = $totalcheque;
        $row[12] = $totalCB;
        $output[] = $row;
      }
      return $output;
  }
  /**
   *
   **/
  function get_array_paiement_taxe_de_sejour_recherche($get, $id_gest, $dbt, $fin, $taxe, $url){
    $awhere=array();
    $awhere[] = 'Reservations.arrivee=1';
    $awhere[] = 'Reservations.statut=90';
    $awhere[] = 'Reservations.taxe=1';
    if($taxe != "") $awhere[] = 'Reservations.taxe_paye='.$taxe;
    $awhere[] = array('OR' => [["Reservations.fin_at > '$dbt'","Reservations.fin_at <= '$fin'"], ["Reservations.dbt_at >= '$dbt'", "Reservations.fin_at <= '$fin'"], ["Reservations.dbt_at > '$dbt'","Reservations.dbt_at < '$fin'"], ["Reservations.dbt_at <= '$dbt'","Reservations.fin_at > '$fin'"]]);

    $arrivee=$this->find();
    $aCount=$this->find();
    $arrivee->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['A.id = Reservations.annonce_id','A.visible=1'],
        ],
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'INNER',
          'conditions' => ['U.id = Reservations.utilisateur_id'],
        ],
        'RS' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'A.batiment=RS.id',
        ],
        'V' => [
          'table' => 'villages',
          'type' => 'left',
          'conditions' => 'V.id=RS.id_village',
        ],
        // 'AN' => [
        //   'table' => 'annoncegestionnaires',
        //   'type' => 'inner',
        //   'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
        // ],
        'CR' => [
          'table' => 'contrats',
          'type' => 'INNER',
          'conditions' => 'CR.annonce_id=A.id',
        ],
        'CT' => [
          'table' => 'contratypes',
          'type' => 'inner',
          'conditions' => ['CT.id=CR.type'],
        ],
        'G' => [
          'table' => 'gestionnaires',
          'type' => 'INNER',
          'conditions' => ['G.id=A.id_gestionnaires',"G.id=".$id_gest],
        ],
        'dispo' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => 'dispo.reservation_id=Reservations.id',
        ]
      ])
      ->select(['Reservations.id','Reservations.annonce_id','Reservations.dbt_at','Reservations.taxe_paye','Reservations.methode_paye','Reservations.fin_at','Reservations.taxe','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.nb_etoiles','A.ville','A.num_app','A.proprietaire_id','RS.name','V.name']);
    $aCount->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' =>['A.id = Reservations.annonce_id','A.visible=1'],
        ],
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'INNER',
          'conditions' => ['U.id = Reservations.utilisateur_id'],
        ],
        'RS' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'A.batiment=RS.id',
        ],
        'V' => [
          'table' => 'villages',
          'type' => 'left',
          'conditions' => 'V.id=RS.id_village',
        ],
        // 'AN' => [
        //   'table' => 'annoncegestionnaires',
        //   'type' => 'inner',
        //   'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
        // ],
        'CR' => [
          'table' => 'contrats',
          'type' => 'INNER',
          'conditions' => ['CR.annonce_id=A.id','CR.visible'=>1]
        ],
        'CT' => [
          'table' => 'contratypes',
          'type' => 'inner',
          'conditions' => ['CT.id=CR.type'],
        ],
        // 'G' => [
        //   'table' => 'gestionnaires',
        //   'type' => 'INNER',
        //   'conditions' => ['G.id=AN.id_gestionnaires',"G.id=".$id_gest],
        // ]
      ])
      ->select(['Reservations.id','Reservations.dbt_at','Reservations.taxe_paye','Reservations.methode_paye','Reservations.fin_at','Reservations.taxe','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.nb_etoiles','A.id_ville','A.num_app','A.proprietaire_id','RS.name','V.name']);
    
      $arrivee->where([$awhere]);

      $arrivee->group(['Reservations.id']);

        $output = array(
                       "data" => array()
                      );
        foreach($arrivee as $c)
        {
          $row = array();
          $Taxes = TableRegistry::get('Taxes');
          $Dispos = TableRegistry::get('Dispos');

          if($c->dbt_at < new Date($dbt)) $c->dbt_at = new Date($dbt);
          if($c->fin_at > new Date($fin)) $c->fin_at = new Date($fin);

          // Taxe de séjour
          $dispocontroller = new \App\Controller\DisposController();
          $dates = $c->dbt_at->i18nFormat('dd-MM-yyyy')."/".$c->fin_at->i18nFormat('dd-MM-yyyy');
          $resultatDetail = $dispocontroller->calcultaxedesejour($c->annonce_id, $dates, $c->nb_adultes, $c->nb_enfants);
          $v_taxe = $resultatDetail['prixtaxeapayer'];

//           $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>$c['A']['ville'],"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
//           $s = strtotime( $c->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($c->dbt_at->i18nFormat('yyyy-MM-dd'));
//           $d = intval($s/86400);
//           $v_taxe=0;

//           if($r_taxe->first()){
//             $taxe=$r_taxe->first();
//           }else{
//             $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>32190,"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
//             $taxe=$r_taxe->first();
//           }
//           if($taxe){
            
//             $v_taxe = 0;
//             if($c['A']['nb_etoiles'] == 0 && $c->dbt_at->i18nFormat('yyyy') == '2019'){
//                 /** Nouveau calcul Taxe 0* **/
//                 $list_dispos = $Dispos->find()->where(['Dispos.reservation_id = '.$c->id]);

//                 foreach ($list_dispos as $ldispo){
//                     $ss = strtotime( $ldispo->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($ldispo->dbt_at->i18nFormat('yyyy-MM-dd'));
//                     $dd = intval($ss/86400);
//                     //// CALCUL PRIX NUITEE
//                     if($ldispo->prix_jour == 0 && $ldispo->prix != 0 && $ldispo->promo_yn == 0){
//                         $prixnuitee = $ldispo->prix / $dd;
//                     }else if($ldispo->promo_jour == 0 && $ldispo->promo_px != 0 && $ldispo->promo_yn == 1){
//                         $prixnuitee = $ldispo->promo_px / $dd;
//                     }else if($ldispo->promo_yn == 0){
//                         $prixnuitee = $ldispo->prix_jour;
//                     }else if($ldispo->promo_yn == 1){
//                         $prixnuitee = $ldispo->promo_jour;
//                     }
//                     //// Taxe par nuitée/personne
//                     $nouvelletaxe = ($prixnuitee / ($c->nb_adultes + $c->nb_enfants)) * ($taxe->valeur / 100);
//                     if($nouvelletaxe > 2.3) {
//                         $nouvelletaxe = 2.3 * $c->nb_adultes;                        
//                     }else {
//                         $nouvelletaxe = $nouvelletaxe * $c->nb_adultes;                        
//                     }
//                     //// Ajouter 10% taxe departementale
//                     $nouvelletaxe10 = $nouvelletaxe + ($nouvelletaxe * 1/10);
//                     //// Taxe Totale
//                     $v_taxe += $nouvelletaxe10 * $dd;                       
//                 }
//                /** Fin Nouveau calcul Taxe 0* **/ 
//             }else{
//                 $v_taxe=$taxe->valeur*$c->nb_adultes*$d;
//             }
            
// //            $v_taxe=$taxe->valeur*$c->nb_adultes*$d;
//           }

          $utilisateurstab = TableRegistry::get('Utilisateurs');
          $ropo = $utilisateurstab->get($c['A']['proprietaire_id']);

          $row[0]=$c->dbt_at->i18nFormat('dd/MM/yyyy');
          $row[1]=$c->fin_at->i18nFormat('dd/MM/yyyy');
          $row[2]=$ropo->prenom." ".$ropo->nom_famille;
          $row[3]=$c['RS']['name'];
          $row[4]=$c['A']['num_app'];
          $row[5]=$c['U']['prenom']." ".$c['U']['nom_famille'];
          $row[6]=$c->nb_adultes;
          $row[7]=$c->nb_enfants;
          $row[8]=abs(number_format($v_taxe, 2, '.', ''));
          if($c->taxe_paye == 1){
            $row[9]= "<span class=\"label label-success\">Payée</span>";
          }else{
            $row[9]= "<span class=\"label label-danger\">Non Payée</span>";
          }
          if($c->methode_paye == 1){
            $row[10]= "Espèce";
          }else if($c->methode_paye == 2){
            $row[10]= "Chèque";
          }else if($c->methode_paye == 3){
            $row[10]= "Carte Bancaire";
          }else{
            $row[10]= "";
          }
          $row[11] = "<center>"
                  . "<button data-toggle=\"modal\" data-target=\"#responsive-modal\" data-href='".$url."manager/arrivees/gestiontaxesejourgest/".$c->id."' class=\"edittax btn btn-sm btn-warning btn-icon-anim btn-circle\"><i class=\"fa fa-pencil\"></i></button>"
                  . "</center>";
          $output['data'][] = $row;
        }
      return $output;
  }
  /**
   *
   **/
  function get_array_taxe_de_sejour_recherche($get, $id_gest, $dbt, $fin, $taxe){
    
    $awhere[] = 'Reservations.arrivee=1';
    $awhere[] = 'Reservations.statut=90';
    if($taxe != "") $awhere[] = 'Reservations.taxe='.$taxe;
    $awhere[] = array('OR' => [["Reservations.fin_at > '$dbt'","Reservations.fin_at <= '$fin'"], ["Reservations.dbt_at >= '$dbt'", "Reservations.fin_at <= '$fin'"], ["Reservations.dbt_at > '$dbt'","Reservations.dbt_at < '$fin'"], ["Reservations.dbt_at <= '$dbt'","Reservations.fin_at > '$fin'"]]);

    $arrivee=$this->find();
    $aCount=$this->find();
    $arrivee->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['A.id = Reservations.annonce_id','A.visible=1'],
        ],
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'INNER',
          'conditions' => ['U.id = Reservations.utilisateur_id'],
        ],
        'RS' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'A.batiment=RS.id',
        ],
        'V' => [
          'table' => 'villages',
          'type' => 'left',
          'conditions' => 'V.id=RS.id_village',
        ],
        // 'AN' => [
        //   'table' => 'annoncegestionnaires',
        //   'type' => 'inner',
        //   'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
        // ],
        'CR' => [
          'table' => 'contrats',
          'type' => 'INNER',
          'conditions' => 'CR.annonce_id=A.id',
        ],
        'CT' => [
          'table' => 'contratypes',
          'type' => 'inner',
          'conditions' => ['CT.id=CR.type'],
        ],
        'G' => [
          'table' => 'gestionnaires',
          'type' => 'INNER',
          'conditions' => ['G.id=A.id_gestionnaires',"G.id=".$id_gest],
        ],
        'dispo' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => 'dispo.reservation_id=Reservations.id',
        ]
      ])
      ->select(['Reservations.id','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','Reservations.methode_paye','Reservations.taxe','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.nb_etoiles','A.ville','A.num_app','A.proprietaire_id','RS.name','V.name']);
    $aCount->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' =>['A.id = Reservations.annonce_id','A.visible=1'],
        ],
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'INNER',
          'conditions' => ['U.id = Reservations.utilisateur_id'],
        ],
        'RS' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'A.batiment=RS.id',
        ],
        'V' => [
          'table' => 'villages',
          'type' => 'left',
          'conditions' => 'V.id=RS.id_village',
        ],
        // 'AN' => [
        //   'table' => 'annoncegestionnaires',
        //   'type' => 'inner',
        //   'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
        // ],
        'CR' => [
          'table' => 'contrats',
          'type' => 'INNER',
          'conditions' => ['CR.annonce_id=A.id','CR.visible'=>1]
        ],
        'CT' => [
          'table' => 'contratypes',
          'type' => 'inner',
          'conditions' => ['CT.id=CR.type'],
        ],
        // 'G' => [
        //   'table' => 'gestionnaires',
        //   'type' => 'INNER',
        //   'conditions' => ['G.id=AN.id_gestionnaires',"G.id=".$id_gest],
        // ]
      ])
      ->select(['Reservations.id','Reservations.dbt_at','Reservations.fin_at','Reservations.methode_paye','Reservations.taxe','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.nb_etoiles','A.id_ville','A.num_app','A.proprietaire_id','RS.name','V.name']);
    
      $arrivee->where([$awhere]);
      $arrivee->group(['Reservations.id']);

        $output = array(
            "data" => array()
          );
        foreach($arrivee as $c)
        {
          $row = array();
          $Taxes = TableRegistry::get('Taxes');
          $Dispos = TableRegistry::get('Dispos');

          if($c->dbt_at < new Date($dbt)) $c->dbt_at = new Date($dbt);
          if($c->fin_at > new Date($fin)) $c->fin_at = new Date($fin);

          // Taxe de séjour
          $dispocontroller = new \App\Controller\DisposController();
          $dates = $c->dbt_at->i18nFormat('dd-MM-yyyy')."/".$c->fin_at->i18nFormat('dd-MM-yyyy');
          $resultatDetail = $dispocontroller->calcultaxedesejour($c->annonce_id, $dates, $c->nb_adultes, $c->nb_enfants);
          $v_taxe = $resultatDetail['prixtaxeapayer'];

//           $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>$c['A']['ville'],"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
//           $s = strtotime( $c->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($c->dbt_at->i18nFormat('yyyy-MM-dd'));
//           $d = intval($s/86400);
//           $v_taxe=0;

//           if($r_taxe->first()){
//             $taxe=$r_taxe->first();
//           }else{
//             $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>32190,"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
//             $taxe=$r_taxe->first();
//           }
//           if($taxe){
            
//             $v_taxe = 0;
//             if($c['A']['nb_etoiles'] == 0 && $c->dbt_at->i18nFormat('yyyy') == '2019'){
//                 /** Nouveau calcul Taxe 0* **/
//                 $list_dispos = $Dispos->find()->where(['Dispos.reservation_id = '.$c->id]);

//                 foreach ($list_dispos as $ldispo){
//                     $ss = strtotime( $ldispo->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($ldispo->dbt_at->i18nFormat('yyyy-MM-dd'));
//                     $dd = intval($ss/86400);
//                     //// CALCUL PRIX NUITEE
//                     if($ldispo->prix_jour == 0 && $ldispo->prix != 0 && $ldispo->promo_yn == 0){
//                         $prixnuitee = $ldispo->prix / $dd;
//                     }else if($ldispo->promo_jour == 0 && $ldispo->promo_px != 0 && $ldispo->promo_yn == 1){
//                         $prixnuitee = $ldispo->promo_px / $dd;
//                     }else if($ldispo->promo_yn == 0){
//                         $prixnuitee = $ldispo->prix_jour;
//                     }else if($ldispo->promo_yn == 1){
//                         $prixnuitee = $ldispo->promo_jour;
//                     }
//                     //// Taxe par nuitée/personne
//                     $nouvelletaxe = ($prixnuitee / ($c->nb_adultes + $c->nb_enfants)) * ($taxe->valeur / 100);
//                     if($nouvelletaxe > 2.3) {
//                         $nouvelletaxe = 2.3 * $c->nb_adultes;                        
//                     }else {
//                         $nouvelletaxe = $nouvelletaxe * $c->nb_adultes;                        
//                     }
//                     //// Ajouter 10% taxe departementale
//                     $nouvelletaxe10 = $nouvelletaxe + ($nouvelletaxe * 1/10);
//                     //// Taxe Totale
//                     $v_taxe += $nouvelletaxe10 * $dd;                       
//                 }
//                /** Fin Nouveau calcul Taxe 0* **/ 
//             }else{
//                 $v_taxe=$taxe->valeur*$c->nb_adultes*$d;
//             }
            
// //            $v_taxe=$taxe->valeur*$c->nb_adultes*$d;
//           }

          $utilisateurstab = TableRegistry::get('Utilisateurs');
          $ropo = $utilisateurstab->find()->where(['id' => $c['A']['proprietaire_id']]);

          $row[0]=$c->dbt_at->i18nFormat('dd/MM/yyyy');
          $row[1]=$c->fin_at->i18nFormat('dd/MM/yyyy');
          if($roprop = $ropo->first())
            $row[2]=$roprop->prenom." ".$roprop->nom_famille;
          else
            $row[2]=" ";
          $row[3]=$c['RS']['name'];
          $row[4]=$c['A']['num_app'];
          $row[5]=$c['A']['nb_etoiles']==0 ? "Non classé" : $c['A']['nb_etoiles']."*";
          if($c->methode_paye == 2){
            $row[6]=abs(number_format($v_taxe, 2, '.', ''));
            $row[7]="";
            $row[8]="";
          }else if($c->methode_paye == 1){
            $row[6]="";
            $row[7]=abs(number_format($v_taxe, 2, '.', ''));
            $row[8]="";
          }else if($c->methode_paye == 3){
            $row[6]="";
            $row[7]="";
            $row[8]=abs(number_format($v_taxe, 2, '.', ''));
          }else{
            $row[6]="";
            $row[7]="";
            $row[8]="";
          }
          $row[9]=abs(number_format($v_taxe, 2, '.', ''));
          $output['aaData'][] = $row;
        }
        return $output;
  }
  /**
   *
   **/
  function get_array_paiement_taxe_de_sejour($get,$id_gest,$taxe,$url){
    $awhere=array();
    $awhere[] = 'Reservations.arrivee=1';
    $awhere[] = 'Reservations.statut=90';
    $awhere[] = 'Reservations.taxe=1';
    if($taxe != "") $awhere[] = 'Reservations.taxe_paye='.$taxe;

    $arrivee=$this->find();
    $aCount=$this->find();
    $arrivee->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['A.id = Reservations.annonce_id','A.visible=1','A.id_gestionnaires'=>$id_gest],
        ],
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'INNER',
          'conditions' => ['U.id = Reservations.utilisateur_id'],
        ],
        'RS' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'A.batiment=RS.id',
        ],
        'V' => [
          'table' => 'villages',
          'type' => 'left',
          'conditions' => 'V.id=RS.id_village',
        ],
        // 'AN' => [
        //   'table' => 'annoncegestionnaires',
        //   'type' => 'inner',
        //   'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
        // ],
        'CR' => [
          'table' => 'contrats',
          'type' => 'INNER',
          'conditions' => ['CR.annonce_id=A.id','CR.visible'=>1]
        ],
        'CT' => [
          'table' => 'contratypes',
          'type' => 'inner',
          'conditions' => ['CT.id=CR.type'],
        ],
        'dispo' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => 'dispo.reservation_id=Reservations.id',
        ]
        // 'G' => [
        //   'table' => 'gestionnaires',
        //   'type' => 'INNER',
        //   'conditions' => ['G.id=AN.id_gestionnaires',"G.id=".$id_gest],
        // ]
      ])
      ->select(['Reservations.id','Reservations.annonce_id','Reservations.dbt_at','Reservations.taxe_paye','Reservations.methode_paye','Reservations.fin_at','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.nb_etoiles','A.ville','A.num_app','Reservations.taxe','A.proprietaire_id','RS.name','V.name']);
    $aCount->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' =>['A.id = Reservations.annonce_id'],
        ],
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'INNER',
          'conditions' => ['U.id = Reservations.utilisateur_id','A.visible=1'],
        ],
        'RS' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'A.batiment=RS.id',
        ],
        'V' => [
          'table' => 'villages',
          'type' => 'left',
          'conditions' => 'V.id=RS.id_village',
        ],
        // 'AN' => [
        //   'table' => 'annoncegestionnaires',
        //   'type' => 'inner',
        //   'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
        // ],
        'CR' => [
          'table' => 'contrats',
          'type' => 'INNER',
          'conditions' => 'CR.annonce_id=A.id',
        ],
        'CT' => [
          'table' => 'contratypes',
          'type' => 'inner',
          'conditions' => ['CT.id=CR.type'],
        ],
        'G' => [
          'table' => 'gestionnaires',
          'type' => 'INNER',
          'conditions' => ['G.id=A.id_gestionnaires',"G.id=".$id_gest,'Reservations.statut=90'],
        ]
      ])
      ->select(['nbr' => $aCount->func()->count('*')]);
    
        if(!empty($orWhere)){
          $arrivee->where([$awhere,"OR"=>$orWhere]);
          $aCount->where([$awhere,"OR"=>$orWhere]);
        }else{
          $arrivee->where([$awhere]);
          $aCount->where([$awhere]);
        }
        $start=1;
        if($get['iDisplayStart']>0){
          $start=($get['iDisplayStart']/$get['iDisplayLength'])+1;
        }
        $arrivee->order($sOrder);

        $arrivee->group(['Reservations.id']);
        $output = array(
                      "data" => array()
                      );
        if(isset($get['limit'])){
            $arrivee->where(['Reservations.taxe_paye'=>0])
                    ->order(['Reservations.dbt_at DESC'])
                    ->limit(10);
        }
        foreach($arrivee as $c)
        {
          $row = array();
          // Taxe de séjour
          $dispocontroller = new \App\Controller\DisposController();
          $dates = $c->dbt_at->i18nFormat('dd-MM-yyyy')."/".$c->fin_at->i18nFormat('dd-MM-yyyy');
          $resultatDetail = $dispocontroller->calcultaxedesejour($c->annonce_id, $dates, $c->nb_adultes, $c->nb_enfants);
          $v_taxe = $resultatDetail['prixtaxeapayer'];

          // $Taxes = TableRegistry::get('Taxes');
          // $Dispos = TableRegistry::get('Dispos');
          // $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>$c['A']['ville'],"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
          // $s = strtotime( $c->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($c->dbt_at->i18nFormat('yyyy-MM-dd'));
          // $d = intval($s/86400);
          // $v_taxe=0;
          // if($r_taxe->first()){
          //   $taxe=$r_taxe->first();
          // }else{
          //   $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>32190,"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
          //   $taxe=$r_taxe->first();
          // }
          // if($taxe){
            
          //   $v_taxe = 0;
          //   if($c['A']['nb_etoiles'] == 0 && $c->dbt_at->i18nFormat('yyyy') == '2019'){
          //       /** Nouveau calcul Taxe 0* **/
          //       $list_dispos = $Dispos->find()->where(['Dispos.reservation_id = '.$c->id]);

          //       foreach ($list_dispos as $ldispo){
          //           $ss = strtotime( $ldispo->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($ldispo->dbt_at->i18nFormat('yyyy-MM-dd'));
          //           $dd = intval($ss/86400);
          //           //// CALCUL PRIX NUITEE
          //           if($ldispo->prix_jour == 0 && $ldispo->prix != 0 && $ldispo->promo_yn == 0){
          //               $prixnuitee = $ldispo->prix / $dd;
          //           }else if($ldispo->promo_jour == 0 && $ldispo->promo_px != 0 && $ldispo->promo_yn == 1){
          //               $prixnuitee = $ldispo->promo_px / $dd;
          //           }else if($ldispo->promo_yn == 0){
          //               $prixnuitee = $ldispo->prix_jour;
          //           }else if($ldispo->promo_yn == 1){
          //               $prixnuitee = $ldispo->promo_jour;
          //           }
          //           //// Taxe par nuitée/personne
          //           $nouvelletaxe = ($prixnuitee / ($c->nb_adultes + $c->nb_enfants)) * ($taxe->valeur / 100);
          //           if($nouvelletaxe > 2.3) {
          //               $nouvelletaxe = 2.3 * $c->nb_adultes;                        
          //           }else {
          //               $nouvelletaxe = $nouvelletaxe * $c->nb_adultes;                        
          //           }
          //           //// Ajouter 10% taxe departementale
          //           $nouvelletaxe10 = $nouvelletaxe + ($nouvelletaxe * 1/10);
          //           //// Taxe Totale
          //           $v_taxe += $nouvelletaxe10 * $dd;                       
          //       }
          //      /** Fin Nouveau calcul Taxe 0* **/ 
          //   }else{
          //       $v_taxe=$taxe->valeur*$c->nb_adultes*$d;
          //   }
            
          //   //$v_taxe=$taxe->valeur*$c->nb_adultes*$d;
          // }

          $utilisateurstab = TableRegistry::get('Utilisateurs');
          $ropo = $utilisateurstab->find()->where(["id" => $c['A']['proprietaire_id']]);
          if($ropo = $ropo->first()){
            $row[0]=$c->dbt_at->i18nFormat('dd/MM/yyyy');
            $row[1]=$c->fin_at->i18nFormat('dd/MM/yyyy');
            $row[2]=$ropo->prenom." ".$ropo->nom_famille;
            $row[3]=$c['RS']['name'];
            $row[4]=$c['A']['num_app'];
            $row[5]=$c['U']['prenom']." ".$c['U']['nom_famille'];
            $row[6]=$c->nb_adultes;
            $row[7]=$c->nb_enfants;
            $row[8]=abs(number_format($v_taxe, 2, '.', ''));
            if($c->taxe_paye == 1){
              $row[9]= "<span class=\"label label-success\">Payée</span>";
            }else{
              $row[9]= "<span class=\"label label-danger\">Non Payée</span>";
            }
            if($c->methode_paye == 1){
              $row[10]= "Espèce";
            }else if($c->methode_paye == 2){
              $row[10]= "Chèque";
            }else if($c->methode_paye == 3){
              $row[10]= "Carte Bancaire";
            }else{
              $row[10]= "";
            }
            $row[11] = "<div class='text-center'>"
                    . "<button data-toggle=\"modal\" data-target=\"#responsive-modal\" data-href='".$url."manager/arrivees/gestiontaxesejourgest/".$c->id."' class=\"edittax btn btn-sm btn-warning btn-icon-anim btn-circle\"><i class=\"fa fa-pencil\"></i></button>"
                    . "</div>";
            $output['data'][] = $row;
          }
          
        }
    return $output;
  }
  /**
   *
   **/
  function get_array_taxe_de_sejour($get,$id_gest,$taxe){
    $awhere=array();
    $awhere[] = 'Reservations.arrivee=1';
    $awhere[] = 'Reservations.statut=90';
    if($taxe != "") $awhere[] = 'Reservations.taxe='.$taxe;

		$arrivee=$this->find();
    $aCount=$this->find();
		$arrivee->join([
				'A' => [
					'table' => 'annonces',
					'type' => 'inner',
					'conditions' => ['A.id = Reservations.annonce_id'],
				],
				'U' => [
					'table' => 'utilisateurs',
					'type' => 'INNER',
					'conditions' => ['U.id = Reservations.utilisateur_id'],
				],
				'RS' => [
					'table' => 'residences',
					'type' => 'left',
					'conditions' => 'A.batiment=RS.id',
				],
				'V' => [
					'table' => 'villages',
					'type' => 'left',
					'conditions' => 'V.id=RS.id_village',
				],
				// 'AN' => [
				// 	'table' => 'annoncegestionnaires',
				// 	'type' => 'inner',
				// 	'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
				// ],
				'CR' => [
					'table' => 'contrats',
					'type' => 'INNER',
					'conditions' => 'CR.annonce_id=A.id',
				],
				'CT' => [
					'table' => 'contratypes',
					'type' => 'inner',
					'conditions' => ['CT.id=CR.type'],
				],
				'G' => [
					'table' => 'gestionnaires',
					'type' => 'INNER',
					'conditions' => ['G.id=A.id_gestionnaires',"G.id=".$id_gest],
        ],
        'dispo' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => 'dispo.reservation_id=Reservations.id',
        ]
			])
			->select(['Reservations.id','Reservations.annonce_id','Reservations.dbt_at','Reservations.fin_at','Reservations.statut','Reservations.methode_paye','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.nb_etoiles','A.ville','A.num_app','Reservations.taxe','A.proprietaire_id','RS.name','V.name']);
		$aCount->join([
				'A' => [
					'table' => 'annonces',
					'type' => 'inner',
					'conditions' =>['A.id = Reservations.annonce_id'],
				],
				'U' => [
					'table' => 'utilisateurs',
					'type' => 'INNER',
					'conditions' => ['U.id = Reservations.utilisateur_id'],
				],
				'RS' => [
					'table' => 'residences',
					'type' => 'left',
					'conditions' => 'A.batiment=RS.id',
				],
				'V' => [
					'table' => 'villages',
					'type' => 'left',
					'conditions' => 'V.id=RS.id_village',
				],
				// 'AN' => [
				// 	'table' => 'annoncegestionnaires',
				// 	'type' => 'inner',
				// 	'conditions' => ['A.id=AN.id_annonces','AN.visible=1'],
				// ],
				'CR' => [
					'table' => 'contrats',
					'type' => 'INNER',
					'conditions' => ['CR.annonce_id=A.id','CR.visible'=>1]
				],
				'CT' => [
					'table' => 'contratypes',
					'type' => 'inner',
					'conditions' => ['CT.id=CR.type'],
				],
				// 'G' => [
				// 	'table' => 'gestionnaires',
				// 	'type' => 'INNER',
				// 	'conditions' => ['G.id=AN.id_gestionnaires',"G.id=".$id_gest],
				// ]
			])
			->select(['Reservations.id','Reservations.dbt_at','Reservations.fin_at','Reservations.statut','Reservations.methode_paye','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.nb_etoiles','A.id_ville','A.num_app','Reservations.taxe','A.proprietaire_id','RS.name','V.name']);
    
      $arrivee->where([$awhere]);

        $arrivee->group(['Reservations.id']);
        $output = array(
                      "data" => array()
                      );
        foreach($arrivee as $c)
        {
          $row = array();
          // Taxe de séjour
          $dispocontroller = new \App\Controller\DisposController();
          $dates = $c->dbt_at->i18nFormat('dd-MM-yyyy')."/".$c->fin_at->i18nFormat('dd-MM-yyyy');
          $resultatDetail = $dispocontroller->calcultaxedesejour($c->annonce_id, $dates, $c->nb_adultes, $c->nb_enfants);
          $v_taxe = $resultatDetail['prixtaxeapayer'];

//           $Taxes = TableRegistry::get('Taxes');
//           $Dispos = TableRegistry::get('Dispos');
//           $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>$c['A']['ville'],"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
//     			$s = strtotime( $c->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($c->dbt_at->i18nFormat('yyyy-MM-dd'));
//     			$d = intval($s/86400);
//     			$v_taxe=0;
//     			if($r_taxe->first()){
//             $taxe=$r_taxe->first();
//           }else{
//             $r_taxe=$Taxes->find('all',["conditions"=>["Taxes.id_villes"=>32190,"Taxes.nb_etoile"=>$c['A']['nb_etoiles'],"Taxes.du <='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'","Taxes.au >='".$c->dbt_at->i18nFormat('yyyy-MM-dd')."'"]]);
//             $taxe=$r_taxe->first();
//           }
//           if($taxe){
                                
//                                 $v_taxe = 0;
//                             if($c['A']['nb_etoiles'] == 0 && $c->dbt_at->i18nFormat('yyyy') == '2019'){
//                                 /** Nouveau calcul Taxe 0* **/
//                                 $list_dispos = $Dispos->find()->where(['Dispos.reservation_id = '.$c->id]);

//                                 foreach ($list_dispos as $ldispo){
//                                     $ss = strtotime( $ldispo->fin_at->i18nFormat('yyyy-MM-dd'))-strtotime($ldispo->dbt_at->i18nFormat('yyyy-MM-dd'));
//                                     $dd = intval($ss/86400);
//                                     //// CALCUL PRIX NUITEE
//                                     if($ldispo->prix_jour == 0 && $ldispo->prix != 0 && $ldispo->promo_yn == 0){
//                                         $prixnuitee = $ldispo->prix / $dd;
//                                     }else if($ldispo->promo_jour == 0 && $ldispo->promo_px != 0 && $ldispo->promo_yn == 1){
//                                         $prixnuitee = $ldispo->promo_px / $dd;
//                                     }else if($ldispo->promo_yn == 0){
//                                         $prixnuitee = $ldispo->prix_jour;
//                                     }else if($ldispo->promo_yn == 1){
//                                         $prixnuitee = $ldispo->promo_jour;
//                                     }
//                                     //// Taxe par nuitée/personne
//                                     $nouvelletaxe = ($prixnuitee / ($c->nb_adultes + $c->nb_enfants)) * ($taxe->valeur / 100);
//                                     if($nouvelletaxe > 2.3) {
//                                         $nouvelletaxe = 2.3 * $c->nb_adultes;                        
//                                     }else {
//                                         $nouvelletaxe = $nouvelletaxe * $c->nb_adultes;                        
//                                     }
//                                     //// Ajouter 10% taxe departementale
//                                     $nouvelletaxe10 = $nouvelletaxe + ($nouvelletaxe * 1/10);
//                                     //// Taxe Totale
//                                     $v_taxe += $nouvelletaxe10 * $dd;                       
//                                 }
//                                /** Fin Nouveau calcul Taxe 0* **/ 
//                             }else{
//                                 $v_taxe=$taxe->valeur*$c->nb_adultes*$d;
//                             }
                                
// //    				$v_taxe=$taxe->valeur*$c->nb_adultes*$d;
//     			}
          $utilisateurstab = TableRegistry::get('Utilisateurs');
          $ropo = $utilisateurstab->get($c['A']['proprietaire_id']);

          $row[0]=$c->dbt_at->i18nFormat('dd/MM/yyyy');
          $row[1]=$c->fin_at->i18nFormat('dd/MM/yyyy');
          $row[2]=$ropo->prenom." ".$ropo->nom_famille;
          $row[3]=$c['RS']['name'];
          $row[4]=$c['A']['num_app'];
          if($c->methode_paye == 2){
            $row[5]=abs(number_format($v_taxe, 2, '.', ''));
            $row[6]="";
            $row[7]="";
          }else if($c->methode_paye == 1){
            $row[5]="";
            $row[6]=abs(number_format($v_taxe, 2, '.', ''));
            $row[7]="";
          }else if($c->methode_paye == 3){
            $row[5]="";
            $row[6]="";
            $row[7]=abs(number_format($v_taxe, 2, '.', ''));
          }else{
            $row[5]="";
            $row[6]="";
            $row[7]="";
          }
          $row[8]=abs(number_format($v_taxe, 2, '.', ''));
          $output['data'][] = $row;
        }
      return $output;
  }
  /**
   *
   **/
  function get_array_arrive_non_arrive_admin($get){		
		$now = Time::parse($get['from']);
		$arrivee = $this->find();
				$arrivee->join([
          'A' => [
            'table' => 'annonces',
            'type' => 'inner',
            'conditions' => ['A.id = Reservations.annonce_id','Reservations.dbt_at >= '=>$now->i18nFormat('yyyy-MM-dd'), '(A.statut = 50 OR A.statut = 30)'],
          ],
          'U' => [
            'table' => 'utilisateurs',
            'type' => 'INNER',
            'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.statut=90'],
          ],
          'RS' => [
            'table' => 'residences',
            'type' => 'left',
            'conditions' => 'A.batiment=RS.id',
          ],
          'V' => [
            'table' => 'villages',
            'type' => 'left',
            'conditions' => 'V.id=RS.id_village',
          ],
          // 'AN' => [
          //   'table' => 'annoncegestionnaires',
          //   'type' => 'left',
          //   'conditions' => ['A.id=AN.id_annonces'],
          // ],
          'G' => [
            'table' => 'gestionnaires',
            'type' => 'left',
            'conditions' => ['G.id=A.id_gestionnaires'],
          ],
          'D' => [
            'table' => 'dispos',
            'type' => 'inner',
            'conditions' => ['D.reservation_id=Reservations.id'],
          ]
        ])->group(['Reservations.id']);
          if(isset($get['to'])&&$get['to']!=''){
            $fin = Time::parse($get['to']);
            $arrivee->where('(Reservations.dbt_at <= "'.$fin->i18nFormat('yyyy-MM-dd').'")');
          }
          //filtrer selon type de reservation
          // if($type===true)
          //   $arrivee->where('Reservations.arrivee=1');
          // elseif($type===false)
          //   $arrivee->where('Reservations.arrivee=0');
          //end filtrer selon type de reservation
          if(isset($get['supp']))
              $arrivee->where(['(U.nom_famille like "%'.$get['supp'].'%" or U.prenom like "%'.$get['supp'].'%" or A.num_app like "%'.$get['supp']
                      .'%" or RS.name like "%'.$get['supp'].'%")']);
					$arrivee->select(['Reservations.arrivee','Reservations.id','Reservations.dbt_at','Reservations.fin_at','U.prenom','U.nom_famille','A.num_app','G.name','RS.name','V.name']);
				
				$output = array(
                                    "data" => array()
                                    );
				foreach($arrivee as $c)
				{
					$row = array();
					$row[0]=$c->dbt_at->i18nFormat('dd-MM-yyyy');
					$row[1]=$c->fin_at->i18nFormat('dd-MM-yyyy');
					$row[2]=$c['RS']['name'];
					$row[3]=$c['A']['num_app'];
					$row[4]=$c['G']['name']==null || $c['G']['name']==""?'<span class="label label-warning">Sans Gestionnaire</span>':$c['G']['name'];
					$row[5]=($c['U']['prenom']." ".$c['U']['nom_famille']);
          if($c->arrivee == 1)
              $row[6]='<span class="label label-success">Arrivés</span>';
          elseif($c->arrivee == 0)
              $row[6]='<span class="label label-danger">Pas arrivés</span>';
					$output['data'][] = $row;
				}
		return $output;
	}
  /**
   *
   **/
  // function get_array_arrive_non_arrive_admin($get){
		
	// 	$now = Time::parse($get['from']);
	// 	$arrivee = $this->find();
  //               $nonarrivee = $this->find();
	// 			$arrivee->join([
	// 					'A' => [
	// 						'table' => 'annonces',
	// 						'type' => 'inner',
	// 						'conditions' => ['A.id = Reservations.annonce_id','Reservations.dbt_at >= '=>$now->i18nFormat('yyyy-MM-dd')],
	// 					],
	// 					'U' => [
	// 						'table' => 'utilisateurs',
	// 						'type' => 'INNER',
	// 						'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=1','Reservations.statut=90'],
	// 					],
	// 					'RS' => [
	// 						'table' => 'residences',
	// 						'type' => 'left',
	// 						'conditions' => 'A.batiment=RS.id',
	// 					],
	// 					'V' => [
	// 						'table' => 'villages',
	// 						'type' => 'left',
	// 						'conditions' => 'V.id=RS.id_village',
	// 					],
	// 					'AN' => [
	// 						'table' => 'annoncegestionnaires',
	// 						'type' => 'left',
	// 						'conditions' => ['A.id=AN.id_annonces'],
	// 					],
	// 					'G' => [
	// 						'table' => 'gestionnaires',
	// 						'type' => 'left',
	// 						'conditions' => ['G.id=AN.id_gestionnaires'],
	// 					]
  //         ]);
  //         if(isset($get['to'])&&$get['to']!=''){
  //           $fin = Time::parse($get['to']);
  //           $arrivee->where('(Reservations.dbt_at <= "'.$fin->i18nFormat('yyyy-MM-dd').'")');
  //         }
  //         if(isset($get['supp']))
  //             $arrivee->andWhere(['(U.nom_famille like "%'.$get['supp'].'%" or U.prenom like "%'.$get['supp'].'%" or A.num_app like "%'.$get['supp']
  //                     .'%" or RS.name like "%'.$get['supp'].'%")']);
	// 				$arrivee->select(['DISTINCT Reservations.id','Reservations.arrivee','Reservations.dbt_at','Reservations.fin_at','U.prenom','U.nom_famille','A.num_app','G.name','RS.name','V.name']);
  //                               $nonarrivee->join([
	// 					'A' => [
	// 						'table' => 'annonces',
	// 						'type' => 'inner',
	// 						'conditions' => ['A.id = Reservations.annonce_id','Reservations.dbt_at >= '=>$now->i18nFormat('yyyy-MM-dd')],
	// 					],
	// 					'U' => [
	// 						'table' => 'utilisateurs',
	// 						'type' => 'INNER',
	// 						'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=0','Reservations.statut=90'],
	// 					],
	// 					'RS' => [
	// 						'table' => 'residences',
	// 						'type' => 'left',
	// 						'conditions' => 'A.batiment=RS.id',
	// 					],
	// 					'V' => [
	// 						'table' => 'villages',
	// 						'type' => 'left',
	// 						'conditions' => 'V.id=RS.id_village',
	// 					],
	// 					'AN' => [
	// 						'table' => 'annoncegestionnaires',
	// 						'type' => 'left',
	// 						'conditions' => ['A.id=AN.id_annonces'],
	// 					],
	// 					'G' => [
	// 						'table' => 'gestionnaires',
	// 						'type' => 'left',
	// 						'conditions' => ['G.id=AN.id_gestionnaires'],
	// 					]
  //         ]);
  //         if(isset($get['to'])&&$get['to']!=''){
  //           $fin = Time::parse($get['to']);
  //           $nonarrivee->where('(Reservations.dbt_at <= "'.$fin->i18nFormat('yyyy-MM-dd').'")');
  //         }
  //         if(isset($get['supp']))
  //             $nonarrivee->andWhere(['(U.nom_famille like "%'.$get['supp'].'%" or U.prenom like "%'.$get['supp'].'%" or A.num_app like "%'.$get['supp']
  //                     .'%" or RS.name like "%'.$get['supp'].'%")']);
	// 				$nonarrivee->select(['DISTINCT Reservations.id','Reservations.arrivee','Reservations.dbt_at','Reservations.fin_at','U.prenom','U.nom_famille','A.num_app','G.name','RS.name','V.name']);
				
  //                               $totarrive=$arrivee->union($nonarrivee);
				
	// 			$output = array(
  //                     "data" => array()
  //                     );
	// 			foreach($totarrive as $c)
	// 			{
	// 				$row = array();
	// 				$row[0]=$c->dbt_at->i18nFormat('dd-MM-yyyy');
	// 				$row[1]=$c->fin_at->i18nFormat('dd-MM-yyyy');
	// 				$row[2]=$c['RS']['name'];
	// 				$row[3]=$c['A']['num_app'];
	// 				$row[4]=$c['G']['name'];
	// 				$row[5]=($c['U']['prenom']." ".$c['U']['nom_famille']);
  //                                       if($c->arrivee == 1)
  //                                           $row[6]='<span class="label label-success">&nbsp;&nbsp;Arrivés&nbsp;&nbsp;</span>';
  //                                       elseif($c->arrivee == 0)
  //                                           $row[6]='<span class="label label-danger">Pas arrivés</span>';
	// 				$output['data'][] = $row;
	// 			}
	// 	return $output;
	// }
  /** 
   *  
   **/      
	function get_array_arrive_admin($get){
		$now = Time::parse($get['from']);
		$arrivee = $this->find();
				$arrivee->join([
          'A' => [
            'table' => 'annonces',
            'type' => 'inner',
            'conditions' => ['A.id = Reservations.annonce_id','Reservations.dbt_at >= '=>$now->i18nFormat('yyyy-MM-dd'), '(A.statut = 50 OR A.statut = 30)'],
          ],
          'U' => [
            'table' => 'utilisateurs',
            'type' => 'INNER',
            'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=1','Reservations.statut=90'],
          ],
          'RS' => [
            'table' => 'residences',
            'type' => 'left',
            'conditions' => 'A.batiment=RS.id',
          ],
          'V' => [
            'table' => 'villages',
            'type' => 'left',
            'conditions' => 'V.id=RS.id_village',
          ],
          // 'AN' => [
          //   'table' => 'annoncegestionnaires',
          //   'type' => 'left',
          //   'conditions' => ['A.id=AN.id_annonces'],
          // ],
          'G' => [
            'table' => 'gestionnaires',
            'type' => 'left',
            'conditions' => ['G.id=A.id_gestionnaires'],
          ],
          'D' => [
            'table' => 'dispos',
            'type' => 'inner',
            'conditions' => ['D.reservation_id=Reservations.id'],
          ]
        ])->group(['Reservations.id']);
          if(isset($get['to'])&&$get['to']!=''){
            $fin = Time::parse($get['to']);
            $arrivee->where('(Reservations.dbt_at <= "'.$fin->i18nFormat('yyyy-MM-dd').'")');
          }
          if(isset($get['supp']))
              $arrivee->where(['(U.nom_famille like "%'.$get['supp'].'%" or U.prenom like "%'.$get['supp'].'%" or A.num_app like "%'.$get['supp']
                      .'%" or RS.name like "%'.$get['supp'].'%")']);
					$arrivee->select(['Reservations.id','Reservations.dbt_at','Reservations.fin_at','U.prenom','U.nom_famille','A.num_app','G.name','RS.name','V.name']);
				
				$output = array(
                                    "data" => array()
                                );
				foreach($arrivee as $c)
				{
					$row = array();
					$row[0]=$c->dbt_at->i18nFormat('dd-MM-yyyy');
					$row[1]=$c->fin_at->i18nFormat('dd-MM-yyyy');
					$row[2]=$c['RS']['name'];
					$row[3]=$c['A']['num_app'];
					$row[4]=$c['G']['name'];
					$row[5]=($c['U']['prenom']." ".$c['U']['nom_famille']);
                                        $row[6]='<span class="label label-success">&nbsp;&nbsp;Arrivés&nbsp;&nbsp;</span>';
					$output['data'][] = $row;
				}
		return $output;
	}
  /**
   * 
   */
  function get_array_non_arrive_admin($get){
		$now = Time::parse($get['from']);
		$arrivee = $this->find();
				$arrivee->join([
          'A' => [
            'table' => 'annonces',
            'type' => 'inner',
            'conditions' => ['A.id = Reservations.annonce_id','Reservations.dbt_at >= '=>$now->i18nFormat('yyyy-MM-dd'), '(A.statut = 50 OR A.statut = 30)'],
          ],
          'U' => [
            'table' => 'utilisateurs',
            'type' => 'INNER',
            'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee=0','Reservations.statut=90'],
          ],
          'RS' => [
            'table' => 'residences',
            'type' => 'left',
            'conditions' => 'A.batiment=RS.id',
          ],
          'V' => [
            'table' => 'villages',
            'type' => 'left',
            'conditions' => 'V.id=RS.id_village',
          ],
          // 'AN' => [
          //   'table' => 'annoncegestionnaires',
          //   'type' => 'left',
          //   'conditions' => ['A.id=AN.id_annonces'],
          // ],
          'G' => [
            'table' => 'gestionnaires',
            'type' => 'left',
            'conditions' => ['G.id=A.id_gestionnaires'],
          ],
          'D' => [
            'table' => 'dispos',
            'type' => 'inner',
            'conditions' => ['D.reservation_id=Reservations.id'],
          ]
        ])->group(['Reservations.id']);
          if(isset($get['to'])&&$get['to']!=''){
            $fin = Time::parse($get['to']);
            $arrivee->where('(Reservations.dbt_at <= "'.$fin->i18nFormat('yyyy-MM-dd').'")');
          }
          if(isset($get['supp']))
              $arrivee->where(['(U.nom_famille like "%'.$get['supp'].'%" or U.prenom like "%'.$get['supp'].'%" or A.num_app like "%'.$get['supp']
                      .'%" or RS.name like "%'.$get['supp'].'%")']);
					$arrivee->select(['Reservations.id','Reservations.dbt_at','Reservations.fin_at','U.prenom','U.nom_famille','A.num_app','G.name','RS.name','V.name']);
				
				$output = array(
                                    "data" => array()
                                );
				foreach($arrivee as $c)
				{
					$row = array();
					$row[0]=$c->dbt_at->i18nFormat('dd-MM-yyyy');
					$row[1]=$c->fin_at->i18nFormat('dd-MM-yyyy');
					$row[2]=$c['RS']['name'];
					$row[3]=$c['A']['num_app'];
					$row[4]=$c['G']['name'];
					$row[5]=($c['U']['prenom']." ".$c['U']['nom_famille']);
          $row[6]='<span class="label label-danger">Pas arrivés</span>';
					$output['data'][] = $row;
				}
		return $output;
	}
  /**
   *
   **/
  public function getArrayPropTaxe($debut,$fin,$id_ges){
    $comm = $this->find();
    $comm->join([
              'A' => [
                      'table' => 'annonces',
                      'type' => 'inner',
                      'conditions' => ['A.id=Reservations.annonce_id'],
              ],
              'U' => [
                      'table' => 'utilisateurs',
                      'type' => 'INNER',
                      'conditions' => ['Reservations.utilisateur_id=U.id','Reservations.statut=90'],
              ],
              'RS' => [
                      'table' => 'residences',
                      'type' => 'left',
                      'conditions' => 'A.batiment=RS.id',
              ],
              'dispo' => [
                'table' => 'dispos',
                'type' => 'inner',
                'conditions' => 'dispo.reservation_id=Reservations.id',
              ]
              // 'AN' => [
              //         'table' => 'annoncegestionnaires',
              //         'type' => 'inner',
              //         'conditions' => ['A.id=AN.id_annonces'],
              // ]
            ]);
    $comm->join(['G' => [
                        'table' => 'gestionnaires',
                        'type' => 'INNER',
                        'conditions' => ['G.id=A.id_gestionnaires',"G.id=$id_ges" ]
                        ]
                    ]);
    $comm->select(['Reservations.dbt_at','U.id','U.email','U.portable','U.prenom','U.nom_famille','A.num_app','RS.name']);
    $sWhere=array();
    $sWhere[]="Reservations.dbt_at >= '".$debut."' ";
    $sWhere[]="Reservations.dbt_at <= '".$fin."' ";
    $comm->where($sWhere);
    return $comm;
  }
  /**
   *
   **/
  function getArrayLocataires($locataire,$debut,$fin,$lieu,$id_ges=false){
      $comm = $this->find();
      $comm->join([
                  'A' => [
                          'table' => 'annonces',
                          'type' => 'inner',
                          'conditions' => 'A.id=Reservations.annonce_id',
                  ],
                  'U' => [
                          'table' => 'utilisateurs',
                          'type' => 'INNER',
                          'conditions' => ['Reservations.utilisateur_id=U.id','Reservations.statut=90'],
                  ],
                  'RS' => [
                          'table' => 'residences',
                          'type' => 'left',
                          'conditions' => 'A.batiment=RS.id',
                  ],
                  'dispo' => [
                    'table' => 'dispos',
                    'type' => 'inner',
                    'conditions' => 'dispo.reservation_id=Reservations.id',
                  ]
                  // 'AN' => [
                  //         'table' => 'annoncegestionnaires',
                  //         'type' => 'inner',
                  //         'conditions' => ['A.id=AN.id_annonces'],
                  // ]
                ]);
    if(!empty($id_ges)){
      $comm->join([
                'Contrats' => [
                  'table' => 'contrats',
                  'type' => 'inner',
                  'conditions' => ['A.id=Contrats.annonce_id','Contrats.visible'=>1]
                ],
                // 'Village' => [
                //   'table' => 'villages',
                //   'type' => 'inner',
                //   'conditions' => ['Village.id=A.village']
                // ],
                // 'G' => [
                //   'table' => 'gestionnaires',
                //   'type' => 'inner',
                //   'conditions' => ['G.id'=>$id_ges]
                // ],
                // 'GV' => [
                //     'table' => 'gestionnaires_villages',
                //     'type' => 'inner',
                //     'conditions' => ['GV.gestionnaire_id=G.id','Village.id=GV.villages_id']
                // ]
                ])
                ->where(['A.id_gestionnaires'=>$id_ges]);
      }
      $comm->select(['Reservations.dbt_at','U.id','U.email','U.portable','U.prenom','U.nom_famille','A.num_app','RS.name']);
      $sWhere=array();
      if($locataire != 2) $sWhere[]="Reservations.arrivee = '".$locataire."' ";
      $sWhere[]="Reservations.dbt_at >= '".$debut."' ";
      $sWhere[]="Reservations.dbt_at <= '".$fin."' ";
      if($lieu>0)
        $sWhere[]="A.lieugeo_id=$lieu ";
      $comm->where($sWhere);
      $comm->group(["Reservations.id"]);
      $comm->order(["Reservations.dbt_at"]);
      return $comm;
	}
  /**
   *
   **/
  public function get_total_resr_index($gest_id, $annee, $mois){
    $nbrRes = $this->find()
    ->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['A.id = Reservations.annonce_id','Reservations.statut = 90'],
        ],
        'dispo' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => 'dispo.reservation_id=Reservations.id',
        ]
      ]);
    if($gest_id != NULL){
      $nbrRes->where(['A.id_gestionnaires'=>$gest_id]);
      // $nbrRes->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=Reservations.annonce_id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $nbrRes->where('YEAR(Reservations.dbt_at) = "'.$annee.'" AND MONTH(Reservations.dbt_at)="'.$mois.'"');
    $nbrRes->select(['nbr' => $nbrRes->func()->count('*')]);
    $nbrRes = $nbrRes->first();
    return $nbrRes;
  }
  /**
   *
   **/
  public function get_arriv_index($gest_id, $annee, $mois, $jour, $arrivee){
    $where = [];
    $where[] = 'Reservations.arrivee='.$arrivee;
    $where[] = 'YEAR(Reservations.dbt_at)="'.$annee.'"';
    $where[] = 'MONTH(Reservations.dbt_at)="'.$mois.'"';
    if($jour != NULL){
      $where[] = 'DAY(Reservations.dbt_at)="'.$jour.'"';
    }
    $listeNnArrivee=$this->find();
    $listeNnArrivee->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['A.id = Reservations.annonce_id','Reservations.statut = 90'],
        ],
        'dispo' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => 'dispo.reservation_id=Reservations.id',
        ]
      ]);
    if($gest_id != NULL){
      $listeNnArrivee->where(['A.id_gestionnaires'=>$gest_id]);
      // $listeNnArrivee->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=Reservations.annonce_id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $listeNnArrivee->where($where);
    $listeNnArrivee->select(['nbr' => $listeNnArrivee->func()->count('*')]);
    $listeNnArrivee = $listeNnArrivee->first();
    return $listeNnArrivee;
  }
  /**
   *
   **/
  public function get_arriv_semaine_index($gest_id, $annee, $mois, $deb, $fin, $arrivee){
    $where = [];
    $where[] = 'Reservations.arrivee='.$arrivee;
    $where[] = 'YEAR(Reservations.dbt_at)="'.$annee.'"';
    $where[] = 'MONTH(Reservations.dbt_at)="'.$mois.'"';
    $where[] = 'DAY(Reservations.dbt_at) >= "'.$deb.'"';
    $where[] = 'DAY(Reservations.dbt_at) <= "'.$fin.'"';
    $listeNnArrivee=$this->find();
    $listeNnArrivee->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['A.id = Reservations.annonce_id','Reservations.statut = 90'],
        ],
        'dispo' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => 'dispo.reservation_id=Reservations.id',
        ]
      ]);
    if($gest_id != NULL){
      $listeNnArrivee->where(['A.id_gestionnaires'=>$gest_id]);
      // $listeNnArrivee->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=Reservations.annonce_id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $listeNnArrivee->where($where);
    $listeNnArrivee->select(['nbr' => $listeNnArrivee->func()->count('*')]);
    $listeNnArrivee = $listeNnArrivee->first();
    return $listeNnArrivee;
  }
  /**
   * 
   */
  public function nuitsans($anne){
    return $this->find()
            ->where("(Reservations.statut = 90)")
            ->where("(Reservations.fin_at > Reservations.dbt_at)")
            ->where("( (Reservations.dbt_at >= STR_TO_DATE('".($anne-1)."-09-01','%Y-%m-%d')) AND (Reservations.dbt_at <= STR_TO_DATE('".($anne)."-08-31','%Y-%m-%d')) )")
            ->select(['nbnuits'=>"SUM(DATEDIFF(Reservations.fin_at,Reservations.dbt_at))"]);
  }
  /**
   * 
   */
  public function reservationageans($anne){
      return $this->find()
              ->where("(Reservations.statut = 90)")
              ->where("( (Reservations.dbt_at >= STR_TO_DATE('".($anne-1)."-09-01','%Y-%m-%d')) AND (Reservations.dbt_at <= STR_TO_DATE('".($anne)."-08-31','%Y-%m-%d')) )")
              ->select(['nb_adultes'=>"SUM(Reservations.nb_adultes)",'nb_enfants'=>"SUM(Reservations.nb_enfants)"]);
  }

  public function getArrivees($datedeb,$id_gest,$datefin,$supp,$arrivee)
    {
      $annonces_cond=['A.id = Reservations.annonce_id','Reservations.dbt_at >='=>$datedeb->i18nFormat('yyyy-MM-dd'),'Reservations.dbt_at !='=>'0000-00-00'];
      if($id_gest!=null)
        $annonces_cond=['Reservations.statut=90','A.id_gestionnaires'=>$id_gest,'A.id = Reservations.annonce_id','Reservations.dbt_at >='=>$datedeb->i18nFormat('yyyy-MM-dd'),'Reservations.dbt_at !='=>'0000-00-00'];
      $arrive=$this->find();
      $arrive->join([
                      'A' => [
                        'table' => 'annonces',
                        'type' => 'inner',
                        'conditions' => $annonces_cond,
                      ],
                      'U' => [
                        'table' => 'utilisateurs',
                        'type' => 'INNER',
                        'conditions' => ['U.id = Reservations.utilisateur_id','Reservations.arrivee'=>$arrivee],
                      ],
                      'RS' => [
                        'table' => 'residences',
                        'type' => 'left',
                        'conditions' => 'A.batiment=RS.id',
                      ],
                      'V' => [
                        'table' => 'villages',
                        'type' => 'left',
                        'conditions' => 'V.id=RS.id_village',
                      ],
                      'dispo' => [
                        'table' => 'dispos',
                        'type' => 'inner',
                        'conditions' => 'dispo.reservation_id=Reservations.id',
                      ],
                      'G' => [
                        'table' => 'gestionnaires',
                        'type' => 'left',
                        'conditions' => ['G.id=A.id_gestionnaires','Reservations.statut=90']
                      ],
                      'CR' => [
                        'table' => 'contrats',
                        'type' => 'INNER',
                        'conditions' => ['CR.annonce_id=A.id','CR.visible'=>1]
                      ],
                      'CT' => [
                              'table' => 'contratypes',
                              'type' => 'inner',
                              'conditions' => ['CT.id=CR.type'],
                      ]
      ]);
      if($datefin!=null && $datefin!=''){
        $fin = Time::parse($datefin);
        $arrive->where('(Reservations.dbt_at <= "'.$fin->i18nFormat('yyyy-MM-dd').'")');
      }
      if($supp!=null)
                      $arrive->where(['OR' => [
                                      'LOWER(U.prenom) LIKE '=>'%'.strtolower($supp).'%',
                                      'LOWER(U.nom_famille) LIKE '=>'%'.strtolower($supp).'%',
                                      'LOWER(A.num_app) LIKE '=>'%'.strtolower($supp).'%',
                                      'LOWER(RS.name) LIKE '=>'%'.strtolower($supp).'%',
                                          ]]);      
      $arrive->select(['Reservations.id','Reservations.dbt_at','Reservations.fin_at','Reservations.statut','Reservations.nb_enfants','Reservations.nb_adultes','Reservations.comment','Reservations.commentlocataire','Reservations.taxe','U.prenom','U.nom_famille','U.portable','U.email','A.position_cle','A.id','A.proprietaire_id','A.nb_etoiles','A.id_ville','A.num_app','RS.name','V.name']);
      $arrive->distinct(['Reservations.id']);
      $arrive->order(['RS.name','A.num_app + 0']);
      return $arrive;
    }

    public function calculTaxes($now,$after7days,$idGest){
      $annonce_cond=['A.id = Reservations.annonce_id','A.visible=1'];
      if($idGest!=null)
        $annonce_cond=['A.id = Reservations.annonce_id','A.id_gestionnaires'=>$idGest,'A.visible=1'];
        return $this->find()
                                  ->join([
                                          'A' => [
                                            'table' => 'annonces',
                                            'type' => 'inner',
                                            'conditions' => $annonce_cond,
                                          ],
                                          'U' => [
                                            'table' => 'utilisateurs',
                                            'type' => 'INNER',
                                            'conditions' => ['U.id = Reservations.utilisateur_id'],
                                          ],
                                          'RS' => [
                                            'table' => 'residences',
                                            'type' => 'left',
                                            'conditions' => 'A.batiment=RS.id',
                                          ],
                                          'V' => [
                                            'table' => 'villages',
                                            'type' => 'left',
                                            'conditions' => 'V.id=RS.id_village',
                                          ],
                                          'CR' => [
                                            'table' => 'contrats',
                                            'type' => 'INNER',
                                            'conditions' => 'CR.annonce_id=A.id',
                                          ],
                                          'CT' => [
                                            'table' => 'contratypes',
                                            'type' => 'inner',
                                            'conditions' => ['CT.id=CR.type'],
                                          ],
                                          'G' => [
                                            'table' => 'gestionnaires',
                                            'type' => 'INNER',
                                            'conditions' => 'G.id=A.id_gestionnaires',
                                          ],
                                          'dispo' => [
                                            'table' => 'dispos',
                                            'type' => 'inner',
                                            'conditions' => 'dispo.reservation_id=Reservations.id',
                                          ]
                  ])
                  ->where(['Reservations.dbt_at <= "'.$now->format('Y-m-d').'"','Reservations.statut=90','Reservations.taxe_paye=0','Reservations.taxe=1','Reservations.fin_at >= "'.$now->format('Y-m-d').'"','Reservations.fin_at <= "'.$after7days->format('Y-m-d').'"'])
                  ->group('Reservations.id')
                  ->order(['Reservations.dbt_at'])
                  ->select(['Reservations.id','Reservations.nb_adultes', 'Reservations.nb_enfants','Reservations.dbt_at','Reservations.fin_at',
                      'Reservations.heure_dep','U.prenom','U.nom_famille','U.email','U.portable','A.id_ville','A.nb_etoiles','G.name']);
    }

  public function getArrayTaxe($dbt, $fin, $gestionnaire, $ville)
  {
    $where = array();
    // recherche date
    if($dbt != "" && $fin != ""){
      $where[] = 'Reservations.dbt_at >= "'.$dbt.'"';
      $where[] = 'Reservations.fin_at <= "'.$fin.'"';
    } 
    // recherche gestionnaire
    if($gestionnaire != -1){
      $where[] = 'Annonces.id_gestionnaires = '.$gestionnaire;
      $where[] = 'Reservations.type = 1';
    } 
    // recherche ville
    if($ville != -1) $where[] = 'Annonces.ville = '.$ville;

    $reservations = $this->find("all")->contain(['Annonces'=>['Utilisateurs', 'Lieugeos']])
      ->join([
        'Dispos' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => 'Reservations.id=Dispos.reservation_id',
        ]
      ])
      ->where(['Reservations.statut = 90', 'Reservations.dbt_at <= CURDATE()'])
      ->group(['Reservations.id'])
      ->order(['Reservations.dbt_at DESC']); 
    if(!empty($where)) $reservations->andWhere($where);
    
    $output = array("data" => array());

    $residencestab = TableRegistry::get('Residences');
    foreach($reservations as $reservation){
      if($reservation->type == 0 || ($reservation->type == 1 && $reservation->taxe == 1)){
        $batiment = $residencestab->find()->where(['id' => $reservation['annonce']->batiment]);
        if($batiment = $batiment->first()) $batimentval = $batiment->name;
        else $batimentval = "";
  
        if($reservation['annonce']->nb_etoiles == 0) $classement = "Non classé";
        else $classement = $reservation['annonce']->nb_etoiles."*";
  
        // Taxe de séjour
        $dispocontroller = new \App\Controller\DisposController();
        $dates = $reservation->dbt_at->i18nFormat('dd-MM-yyyy')."/".$reservation->fin_at->i18nFormat('dd-MM-yyyy');
        $resultatDetail = $dispocontroller->calcultaxedesejour($reservation->annonce_id, $dates, $reservation->nb_adultes, $reservation->nb_enfants);
        $v_taxe = $resultatDetail['prixtaxeapayer'];
  
        // perçue par
        if($reservation->type == 0){
          $percuepar = "Payée via Alpissime";
        }else{
          if($reservation->taxe_paye == 0){
            $percuepar = "Non perçue";
          }else{
            if($reservation->methode_paye == 1) $percuepar = "Gestionnaire - Espèce";
            if($reservation->methode_paye == 2) $percuepar = "Gestionnaire - Chèque";
            if($reservation->methode_paye == 3) $percuepar = "Gestionnaire - Carte Bancaire";
          }
        }
  
        $row = array();
        $row[0]=$reservation->id;
        $row[1]=$reservation->dbt_at->i18nFormat('dd/MM/yyyy');
        $row[2]=$reservation->fin_at->i18nFormat('dd/MM/yyyy');
        $row[3]=$reservation['annonce']['utilisateur']->prenom." ".$reservation['annonce']['utilisateur']->nom_famille;
        $row[4]=$reservation['annonce']->num_app;
        $row[5]=$batimentval;
        $row[6]=$reservation['annonce']['lieugeo']->name;
        $row[7]=$classement;
        $row[8]=$reservation->nb_enfants + $reservation->nb_adultes;
        $row[9]=abs(number_format($v_taxe, 2, '.', ''));
        $row[10]=$percuepar;
        
        $output['data'][] = $row;
      }

    }
    return  $output ;
  }

}
