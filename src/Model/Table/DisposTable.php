<?php
namespace App\Model\Table;

use App\Model\Entity\Dispo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Dispos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Annonces
 * @property \Cake\ORM\Association\BelongsTo $Utilisateurs
 * @property \Cake\ORM\Association\BelongsTo $Reservations
 */
class DisposTable extends Table
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

        $this->table('dispos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Annonces', [
            'foreignKey' => 'annonce_id',
	          'joinType' => 'INNER'
        ]);
        $this->belongsTo('Utilisateurs', [
            'foreignKey' => 'utilisateur_id'
        ]);
        $this->belongsTo('Reservations', [
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
            ->date('created_at')
            ->allowEmpty('created_at');

        $validator
            ->date('updated_at')
            ->allowEmpty('updated_at');

        $validator
            ->date('dbt_at')
            ->requirePresence('dbt_at', 'create')
            ->notEmpty('dbt_at');

        $validator
            ->date('fin_at')
            ->requirePresence('fin_at', 'create')
            ->notEmpty('fin_at');

        $validator
            ->decimal('prix')
            ->allowEmpty('prix');

        $validator
            ->integer('statut')
            ->allowEmpty('statut');

        $validator
            ->integer('promo_yn')
            ->allowEmpty('promo_yn');

        $validator
            ->decimal('promo_px')
            ->allowEmpty('promo_px');

        return $validator;
    }
  /**
   *
   **/
  public function chercherdisponibilitedatepicker($id){
    $dispo = $this->find()
    ->where(['Dispos.annonce_id' => $id, 'Dispos.statut' => 0])
    ->select(['Dispos.dbt_at', 'Dispos.fin_at'])
    ->order(['dbt_at' => 'ASC']);
    return $dispo;
  }
  /**
   * 
   */
  public function chercherdisponibilitePromodatepicker($id){
    $dispo = $this->find()
    ->where(['Dispos.annonce_id' => $id, 'Dispos.statut' => 0, 'Dispos.promo_yn' => 1])
    ->select(['Dispos.dbt_at', 'Dispos.fin_at'])
    ->order(['dbt_at' => 'ASC']);
    return $dispo;
  }
  /**
   * 
   */
  public function chercherdisponibiliteSamedidatepicker($id)
  {
    $dispo = $this->find()
    ->where(['Dispos.annonce_id' => $id, 'Dispos.statut' => 0, 'Dispos.conditionnbr' => 1])
    ->select(['Dispos.dbt_at', 'Dispos.fin_at', 'Dispos.conditionnbr'])
    ->order(['dbt_at' => 'ASC']);
    return $dispo;
  }
  /**
   * 
   */
  public function chercherdisponibiliteDimanchedatepicker($id)
  {
    $dispo = $this->find()
    ->where(['Dispos.annonce_id' => $id, 'Dispos.statut' => 0, 'Dispos.conditionnbr' => 2])
    ->select(['Dispos.dbt_at', 'Dispos.fin_at', 'Dispos.conditionnbr'])
    ->order(['dbt_at' => 'ASC']);
    return $dispo;
  }
  /**
   *
   **/
  public function chercherdisponibilite($id, $da_debut, $da_fin, $condi=null){
    $dispo = $this->find()
    ->where([
        ['Dispos.annonce_id' => $id, 'Dispos.statut' => 0],
        'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
      ]);
    if($condi != null) {
      $dispo->andWhere($condi);
    }
    $dispo->order(['dbt_at' => 'ASC']);
    return $dispo;
  }
  /**
   *
   **/
  public function chercherdisponibilitesynchro($id, $da_debut, $da_fin, $condi=null){
    $dispo = $this->find()
    ->where([
        ['Dispos.annonce_id' => $id, '(Dispos.statut=0 OR Dispos.statut=100)'],
        'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
      ]);
    if($condi != null) {
      $dispo->andWhere($condi);
    }
    $dispo->order(['dbt_at' => 'ASC']);
    return $dispo;
  }
  /**
   * 
   */
  public function cherchernbrfuturenuitees($id){
    $dispo = $this->find();
    $dispo->select([
      'duree' => 'DATEDIFF(Dispos.fin_at,Dispos.dbt_at)'
    ])
    ->where([
        ['Dispos.annonce_id' => $id, 'Dispos.statut' => 0, "Dispos.dbt_at > CURDATE()"]
    ]);
    return $dispo;
  }
  /**
   * 
   */
  public function chercherdisponibilitebloque($id, $da_debut, $da_fin, $condi=null){
    $dispo = $this->find()
    ->where([
        ['Dispos.annonce_id' => $id, '((Dispos.statut = 90 AND utilisateur_id IS NULL) OR (Dispos.statut = 50 AND utilisateur_id IS NULL) OR (Dispos.statut = 100 AND prix_jour <> 0))'],
        'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
      ]);
    if($condi != null) {
      $dispo->andWhere($condi);
    }
    $dispo->order(['dbt_at' => 'ASC']);
    return $dispo;
  }
  /**
   * 
   */
  public function chercherdisponibiliteSansStatut($id, $da_debut, $da_fin){
    $dispo = $this->find()
    ->where([
        ['Dispos.annonce_id' => $id],
        'OR' => [
            ["Dispos.fin_at > '$da_debut'", "Dispos.fin_at <= '$da_fin'"],
            ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"],
            ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"],
            ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]
        ],
      ]);
    $dispo->order(['dbt_at' => 'ASC']);
    return $dispo;
  }
  /**
   *
   **/
  public function chercherdisponibiliteCount($id, $da_debut, $da_fin, $condi=null){
    $dispo = $this->find()
    ->where([
        ['Dispos.annonce_id' => $id, 'Dispos.statut' => 0],
        'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
      ]);
    if($condi != null) {
      $dispo->andWhere($condi);
    }
    $dispo->count();
    return $dispo;
  }
  /**
   *
   **/
  public function chercherdisponibiliteCountsynchro($id, $da_debut, $da_fin, $condi=null){
    $dispo = $this->find()
    ->where([
        ['Dispos.annonce_id' => $id, '(Dispos.statut=0 OR Dispos.statut=100)'],
        'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
      ]);
    if($condi != null) {
      $dispo->andWhere($condi);
    }
    $dispo->count();
    return $dispo;
  }
  /**
   * 
   */
  public function chercherdisponibiliteCountSansStatut($id, $da_debut, $da_fin){
    $dispo = $this->find()
    ->where([
        ['Dispos.annonce_id' => $id],
        'OR' => [
            ["Dispos.fin_at > '$da_debut'", "Dispos.fin_at <= '$da_fin'"],
            ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"],
            ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"],
            ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]
        ],
      ]);
    $dispo->count();
    return $dispo;
  }
  /**
   *
   **/
  public function chercherdispocalcul($id, $da_debut, $da_fin){
    $dispo = $this->find()
    ->where([
        ['Dispos.reservation_id' => $id],
        'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
      ])->order(['dbt_at' => 'ASC']);
    return $dispo;
  }
  /**
   *
   **/
  public function chercherdispocalculCount($id, $da_debut, $da_fin){
    $dispo = $this->find()
    ->where([
        ['Dispos.reservation_id' => $id],
        'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
      ])->count();
    return $dispo;
  }
  /**
   *
   **/
  public function chercherdisponibilitenuitee($id, $da_debut, $da_fin){
    $dispo = $this->find()
    ->where([
        ['Dispos.annonce_id' => $id, 'Dispos.dbt_at' => $da_debut, 'Dispos.fin_at' => $da_fin ],
        'OR' => [['Dispos.statut' => 50], ['Dispos.statut' => 90]],
      ])->count();
    return $dispo;
  }
  /**
   *
   **/
  public function get_price_surface($gest_id, $where, $annee, $mois=NULL, $semaine=NULL, $village=NULL){
    $whereTab = [];
    $whereTab[] = $where;
    $whereTab[] = 'YEAR(R.dbt_at)="'.$annee.'"';
    if($mois != NULL) $whereTab[] = 'MONTH(R.dbt_at)="'.$mois.'"';
    if($semaine != NULL){
      $tabDate = explode(" - ", $semaine);
      $deb = $tabDate[0];
      $fin = $tabDate[1];
      $whereTab[] = 'DAY(R.dbt_at) >= "'.$deb.'"';
      $whereTab[] = 'DAY(R.dbt_at) <= "'.$fin.'"';
    }
    if($village != "tous" && $village != NULL) $whereTab[] = 'A.village='.$village;
    $prixGamme = $this->find()
    ->join([
          'A' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['A.id = Dispos.annonce_id'],
            ],
          'R' => [
              'table' => 'reservations',
              'type' => 'inner',
              'conditions' => ['R.id = Dispos.reservation_id','R.statut = 90'],
            ],
        ]);
    if($gest_id != NULL){
      $prixGamme->where(['A.id_gestionnaires'=>$gest_id]);
      // $prixGamme->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=A.id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $prixGamme->select(["total"=>"SUM(IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)))/COUNT(Dispos.id)"])
    ->where($whereTab);
    $prixGamme = $prixGamme->first();
    return $prixGamme;
  }
  /**
   *
   **/
  public function get_price_surface_date($gest_id, $where, $from, $to, $village=NULL){
    $whereTab = [];
    $whereTab[] = $where;
    $fromDate = date("Y-m-d", strtotime($from));
    $toDate = date("Y-m-d", strtotime($to));
    $whereTab[] = 'R.dbt_at >= "'.$fromDate.'"';
    $whereTab[] = 'R.dbt_at <= "'.$toDate.'"';
    $whereTab[] = 'Dispos.prix IS NOT NULL AND Dispos.prix != 0 AND Dispos.prix > 10';
    if($village != "tous" && $village != NULL) $whereTab[] = 'A.village='.$village;
    $prixGamme = $this->find()
    ->join([
          'A' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['A.id = Dispos.annonce_id'],
            ],
          'R' => [
              'table' => 'reservations',
              'type' => 'inner',
              'conditions' => ['R.id = Dispos.reservation_id','R.statut = 90'],
            ],
        ]);
    if($gest_id != NULL){
      $prixGamme->where(['A.id_gestionnaires'=>$gest_id]);
      // $prixGamme->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=A.id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $prixGamme->select(["total"=>"SUM(IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)))/COUNT(Dispos.id)"])
    ->where($whereTab);
    $prixGamme = $prixGamme->first();
    return $prixGamme;
  }
  /**
   *
   **/
  public function get_price_surface_total_date($gest_id, $where, $from, $to, $village=NULL){
    $whereTab = [];
    $whereTab[] = $where;
    $fromDate = date("Y-m-d", strtotime($from));
    $toDate = date("Y-m-d", strtotime($to));
    $whereTab[] = 'Dispos.dbt_at >= "'.$fromDate.'"';
    $whereTab[] = 'Dispos.dbt_at <= "'.$toDate.'"';
    $whereTab[] = 'Dispos.prix IS NOT NULL AND Dispos.prix != 0 AND Dispos.prix > 10';
    if($village != "tous" && $village != NULL) $whereTab[] = 'A.village='.$village;
    $prixGamme = $this->find()
    ->join([
          'A' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['A.id = Dispos.annonce_id'],
            ],
        ]);
    if($gest_id != NULL){
      $prixGamme->where(['A.id_gestionnaires'=>$gest_id]);
      // $prixGamme->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=A.id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $prixGamme->select(["total"=>"SUM(IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)))/COUNT(Dispos.id)"])
    ->where($whereTab);
    $prixGamme = $prixGamme->first();
    return $prixGamme;
  }
  /**
   *
   **/
  public function get_price_surface_total($gest_id, $where, $annee, $mois=NULL, $semaine=NULL, $village=NULL){
    $whereTab = [];
    $whereTab[] = $where;
    $whereTab[] = 'YEAR(Dispos.dbt_at)="'.$annee.'"';
    if($mois != NULL) $whereTab[] = 'MONTH(Dispos.dbt_at)="'.$mois.'"';
    if($semaine != NULL){
      $tabDate = explode(" - ", $semaine);
      $deb = $tabDate[0];
      $fin = $tabDate[1];
      $whereTab[] = 'DAY(Dispos.dbt_at) >= "'.$deb.'"';
      $whereTab[] = 'DAY(Dispos.dbt_at) <= "'.$fin.'"';
    }
    if($village != "tous" && $village != NULL) $whereTab[] = 'A.village='.$village;
    $prixGamme = $this->find()
    ->join([
          'A' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['A.id = Dispos.annonce_id'],
            ],
        ]);
    if($gest_id != NULL){
      $prixGamme->where(['A.id_gestionnaires'=>$gest_id]);
      // $prixGamme->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=A.id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $prixGamme->select(["total"=>"SUM(IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, (Dispos.promo_px)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at), (Dispos.prix)/DATEDIFF(Dispos.fin_at, Dispos.dbt_at)))/COUNT(Dispos.id)"])
    ->where($whereTab);
    $prixGamme = $prixGamme->first();
    return $prixGamme;
  }
  /**
   *
   **/
  public function count_get_price_surface_total($gest_id, $where, $annee, $mois=NULL, $semaine=NULL, $village=NULL){
    $whereTab = [];
    $whereTab[] = $where;
    $whereTab[] = 'YEAR(Dispos.dbt_at)="'.$annee.'"';
    if($mois != NULL) $whereTab[] = 'MONTH(Dispos.dbt_at)="'.$mois.'"';
    if($semaine != NULL){
      $tabDate = explode(" - ", $semaine);
      $deb = $tabDate[0];
      $fin = $tabDate[1];
      $whereTab[] = 'DAY(Dispos.dbt_at) >= "'.$deb.'"';
      $whereTab[] = 'DAY(Dispos.dbt_at) <= "'.$fin.'"';
    }
    if($village != "tous" && $village != NULL) $whereTab[] = 'A.village='.$village;
    $prixGamme = $this->find()
    ->join([
          'A' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['A.id = Dispos.annonce_id'],
            ],
        ]);
    if($gest_id != NULL){
      $prixGamme->where(['A.id_gestionnaires'=>$gest_id]);
      // $prixGamme->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=A.id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $prixGamme->select(["total"=>"COUNT(*)"])
    ->where($whereTab)
    ->group(['A.id']);
    $prixGamme = $prixGamme->count();
    return $prixGamme;
  }
  /**
   *
   **/
  public function count_get_price_surface_total_date($gest_id, $where, $from, $to, $village=NULL){
    $whereTab = [];
    $whereTab[] = $where;
    $fromDate = date("Y-m-d", strtotime($from));
    $toDate = date("Y-m-d", strtotime($to));
    $whereTab[] = 'Dispos.dbt_at >= "'.$fromDate.'"';
    $whereTab[] = 'Dispos.dbt_at <= "'.$toDate.'"';
    $whereTab[] = 'Dispos.prix IS NOT NULL AND Dispos.prix != 0 AND Dispos.prix > 10';
    if($village != "tous" && $village != NULL) $whereTab[] = 'A.village='.$village;
    $prixGamme = $this->find()
    ->join([
          'A' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['A.id = Dispos.annonce_id'],
            ],
        ]);
    if($gest_id != NULL){
      $prixGamme->where(['A.id_gestionnaires'=>$gest_id]);
      // $prixGamme->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=A.id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $prixGamme->select(["total"=>"COUNT(*)"])
    ->where($whereTab)
    ->group(['A.id']);
    $prixGamme = $prixGamme->count();
    return $prixGamme;
  }
  /**
   *
   **/
  public function count_get_price_surface_res($gest_id, $where, $annee, $mois=NULL, $semaine=NULL, $village=NULL){
    $whereTab = [];
    $whereTab[] = $where;
    $whereTab[] = 'YEAR(R.dbt_at)="'.$annee.'"';
    if($mois != NULL) $whereTab[] = 'MONTH(R.dbt_at)="'.$mois.'"';
    if($semaine != NULL){
      $tabDate = explode(" - ", $semaine);
      $deb = $tabDate[0];
      $fin = $tabDate[1];
      $whereTab[] = 'DAY(R.dbt_at) >= "'.$deb.'"';
      $whereTab[] = 'DAY(R.dbt_at) <= "'.$fin.'"';
    }
    if($village != "tous" && $village != NULL) $whereTab[] = 'A.village='.$village;
    $prixGamme = $this->find()
    ->join([
          'A' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['A.id = Dispos.annonce_id'],
            ],
          'R' => [
              'table' => 'reservations',
              'type' => 'inner',
              'conditions' => ['R.id = Dispos.reservation_id','R.statut = 90'],
            ],
        ]);
    if($gest_id != NULL){
      $prixGamme->where(['A.id_gestionnaires'=>$gest_id]);
      // $prixGamme->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=A.id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $prixGamme->select(["total"=>"COUNT(*)"])
    ->where($whereTab)
    ->group(['A.id']);
    $prixGamme = $prixGamme->count();
    return $prixGamme;
  }
  /**
   *
   **/
  public function count_get_price_surface_res_date($gest_id, $where, $from, $to, $village=NULL){
    $whereTab = [];
    $whereTab[] = $where;
    $fromDate = date("Y-m-d", strtotime($from));
    $toDate = date("Y-m-d", strtotime($to));
    $whereTab[] = 'R.dbt_at >= "'.$fromDate.'"';
    $whereTab[] = 'R.dbt_at <= "'.$toDate.'"';
    $whereTab[] = 'Dispos.prix IS NOT NULL AND Dispos.prix != 0 AND Dispos.prix > 10';
    if($village != "tous" && $village != NULL) $whereTab[] = 'A.village='.$village;
    $prixGamme = $this->find()
    ->join([
          'A' => [
              'table' => 'annonces',
              'type' => 'inner',
              'conditions' => ['A.id = Dispos.annonce_id'],
            ],
          'R' => [
              'table' => 'reservations',
              'type' => 'inner',
              'conditions' => ['R.id = Dispos.reservation_id','R.statut = 90'],
            ],
        ]);
    if($gest_id != NULL){
      $prixGamme->where(['A.id_gestionnaires'=>$gest_id]);
      // $prixGamme->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=A.id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $prixGamme->select(["total"=>"COUNT(*)"])
    ->where($whereTab)
    ->group(['A.id']);
    $prixGamme = $prixGamme->count();
    return $prixGamme;
  }
  /**
   *
   **/
  public function get_total_dispos($gest_id, $annee, $mois=NULL, $wre=NULL, $semaine=NULL, $village=NULL, $prop=NULL){
    $where = [];
    $where[] = 'YEAR(Dispos.dbt_at)="'.$annee.'"';
    
    if($mois != NULL)
    $where[] = 'MONTH(Dispos.dbt_at)="'.$mois.'"';
    
    if($wre != NULL){
      $where[] = $wre;
    }
    if($village != "tous" && $village != NULL) $where[] = 'A.village='.$village;
    if($prop != "0" && $prop != NULL) $where[] = 'A.proprietaire_id='.$prop;
    if($semaine != NULL){
      $tabDate = explode(" - ", $semaine);
      $deb = $tabDate[0];
      $fin = $tabDate[1];
      $where[] = 'DAY(Dispos.dbt_at) >= "'.$deb.'"';
      $where[] = 'DAY(Dispos.dbt_at) <= "'.$fin.'"';
    }
    $nbrTotal = $this->find();
    $nbrTotal->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['Dispos.annonce_id=A.id'],
        ],
      ]);
    if($gest_id != NULL){
      $nbrTotal->where(['A.id_gestionnaires'=>$gest_id]);
      // $nbrTotal->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=Dispos.annonce_id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $nbrTotal->where( $where );
    $nbrTotal->select(['nbr' => $nbrTotal->func()->count('*')]);
      $nbrTotal = $nbrTotal->first();
    return $nbrTotal;
  }
  /**
   *
   **/
  public function get_total_dispos_date($gest_id, $from, $to, $wre=NULL, $prop=NULL, $village=NULL){
    $where = [];
    $fromDate = date("Y-m-d", strtotime($from));
    $toDate = date("Y-m-d", strtotime($to));
    $where[] = 'Dispos.dbt_at >= "'.$fromDate.'"';
    $where[] = 'Dispos.dbt_at <= "'.$toDate.'"';
    if($wre != NULL){
      $where[] = $wre;
    }
    if($prop != "0" && $prop != NULL) $where[] = 'A.proprietaire_id='.$prop;
    if($village != "tous" && $village != NULL) $where[] = 'A.village='.$village;
    $nbrTotal = $this->find();
    $nbrTotal->join([
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['Dispos.annonce_id=A.id'],
        ],
      ]);
    if($gest_id != NULL){
      $nbrTotal->where(['A.id_gestionnaires'=>$gest_id]);
      // $nbrTotal->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=Dispos.annonce_id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $nbrTotal->where( $where );
    $nbrTotal->select(['nbr' => $nbrTotal->func()->count('*')]);
    $nbrTotal = $nbrTotal->first();
    return $nbrTotal;
  }
  /**
   *
   **/
  public function get_dispos_occupe($gest_id, $annee, $mois, $wre=NULL, $semaine=NULL, $village=NULL, $prop=NULL){
    $where = [];
    $where[] = 'Dispos.statut = 90';
    $where[] = 'YEAR(Dispos.dbt_at)="'.$annee.'"';
    $where[] = 'MONTH(Dispos.dbt_at)="'.$mois.'"';
    if($wre != NULL){
      $where[] = $wre;
    }
    if($village != "tous" && $village != NULL) $where[] = 'A.village='.$village;
    if($prop != "0" && $prop != NULL) $where[] = 'A.proprietaire_id='.$prop;
    if($semaine != NULL){
      $tabDate = explode(" - ", $semaine);
      $deb = $tabDate[0];
      $fin = $tabDate[1];
      $where[] = 'DAY(Dispos.dbt_at) >= "'.$deb.'"';
      $where[] = 'DAY(Dispos.dbt_at) <= "'.$fin.'"';
    }
    $nbrOccupe = $this->find()
    ->join([
        'R' => [
          'table' => 'reservations',
          'type' => 'inner',
          'conditions' => ['Dispos.reservation_id=R.id','R.statut = 90'],
        ],
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['Dispos.annonce_id=A.id'],
        ],
      ]);
    if($gest_id != NULL){
      $nbrOccupe->where(['A.id_gestionnaires'=>$gest_id]);
      // $nbrOccupe->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=Dispos.annonce_id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $nbrOccupe->where( $where );
    $nbrOccupe->select(['nbr' => $nbrOccupe->func()->count('*')]);
    $nbrOccupe = $nbrOccupe->first();
    return $nbrOccupe;
  }
  /**
   *
   **/
  public function get_dispos_occupe_date($gest_id, $from, $to, $wre=NULL, $prop=NULL, $village=NULL){
    $where = [];
    $where[] = 'Dispos.statut = 90';
    $fromDate = date("Y-m-d", strtotime($from));
    $toDate = date("Y-m-d", strtotime($to));
    $where[] = 'Dispos.dbt_at >= "'.$fromDate.'"';
    $where[] = 'Dispos.dbt_at <= "'.$toDate.'"';
    if($wre != NULL){
      $where[] = $wre;
    }
    if($prop != "0" && $prop != NULL) $where[] = 'A.proprietaire_id='.$prop;
    if($village != "tous" && $village != NULL) $where[] = 'A.village='.$village;
    $nbrOccupe = $this->find()
    ->join([
        'R' => [
          'table' => 'reservations',
          'type' => 'inner',
          'conditions' => ['Dispos.reservation_id=R.id','R.statut = 90'],
        ],
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['Dispos.annonce_id=A.id'],
        ],
      ]);
    if($gest_id != NULL){
      $nbrOccupe->where(['A.id_gestionnaires'=>$gest_id]);
      // $nbrOccupe->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=Dispos.annonce_id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $nbrOccupe->where( $where );
    $nbrOccupe->select(['nbr' => $nbrOccupe->func()->count('*')]);
    $nbrOccupe = $nbrOccupe->first();
    return $nbrOccupe;
  }
  /**
   *
   **/
  public function get_chiffre_affaire($gest_id, $annee, $mois, $prop=NULL){
    $where = [];
    $where[] = 'Dispos.statut = 90';
    $where[] = 'YEAR(Dispos.dbt_at)="'.$annee.'"';
    $where[] = 'MONTH(Dispos.dbt_at)="'.$mois.'"';
    if($prop != "0" && $prop != NULL) $where[] = 'A.proprietaire_id='.$prop;
    $chiffre = $this->find()
    ->join([
        'R' => [
          'table' => 'reservations',
          'type' => 'inner',
          'conditions' => ['Dispos.reservation_id=R.id','R.statut = 90'],
        ],
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['Dispos.annonce_id=A.id'],
        ],
      ]);
    if($gest_id != NULL){
      $chiffre->where(['A.id_gestionnaires'=>$gest_id]);
      // $chiffre->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=Dispos.annonce_id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $chiffre->select(["total"=>"SUM(IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, Dispos.promo_px, Dispos.prix))"]);
    $chiffre->where( $where );
    $chiffre = $chiffre->first();
    return $chiffre;
  }
  /**
   *
   **/
  public function get_chiffre_affaire_date($gest_id, $from, $to, $prop){
    $where = [];
    $where[] = 'Dispos.statut = 90';
    $fromDate = date("Y-m-d", strtotime($from));
    $toDate = date("Y-m-d", strtotime($to));
    $where[] = 'Dispos.dbt_at >= "'.$fromDate.'"';
    $where[] = 'Dispos.dbt_at <= "'.$toDate.'"';
    if($prop != "0" && $prop != NULL) $where[] = 'A.proprietaire_id='.$prop;
    $chiffre = $this->find()
    ->join([
        'R' => [
          'table' => 'reservations',
          'type' => 'inner',
          'conditions' => ['Dispos.reservation_id=R.id','R.statut = 90'],
        ],
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['Dispos.annonce_id=A.id'],
        ],
      ]);
    if($gest_id != NULL){
      $chiffre->where(['A.id_gestionnaires'=>$gest_id]);
      // $chiffre->join([
      //       'AG' => [
      //           'table' => 'annoncegestionnaires',
      //           'type' => 'inner',
      //           'conditions' => ['AG.id_annonces=Dispos.annonce_id',"AG.id_gestionnaires"=>$gest_id],
      //         ]
      //     ]);
    }
    $chiffre->select(["total"=>"SUM(IF(Dispos.promo_px IS NOT NULL AND Dispos.promo_px != 0, Dispos.promo_px, Dispos.prix))"]);
    $chiffre->where( $where );
    $chiffre = $chiffre->first();
    return $chiffre;
  }
  /**
   * 
   */
  function getFirstDispoInBooking($bookingId){
    return  $this->find('all')
                ->order('dbt_at')
                ->where(['reservation_id'=>$bookingId])
                ->first();
  }
  /**
   * 
   */
  function findPeriodesInDate($date,$idAnnonce){
      return $this->find('all')
              ->where(['dbt_at <= '=>$date])
              ->where(['fin_at >= '=>$date])
              ->where(['annonce_id'=>$idAnnonce]);
  }
  /**
   * 
   */
  public function chercherdisponibiliteTot($id, $da_debut, $da_fin, $condi=null){
    $dispo = $this->find()
    ->where([
        ['Dispos.annonce_id' => $id],
        'OR' => [
            ["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"],
            ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"],
            ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"],
            ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]
        ],
      ]);
    if ($condi != null) {
      $dispo->andWhere($condi);
    }
    $dispo->order(['dbt_at' => 'ASC']);
    return $dispo;
  }
  /**
   *
   **/
  public function chercherdisponibiliteCountTot($id, $da_debut, $da_fin, $condi=null){
    $dispo = $this->find()
    ->where([
        ['Dispos.annonce_id' => $id],
        'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
      ]);
    if($condi != null) {
      $dispo->andWhere($condi);
    }
    $dispo->count();
    return $dispo;
  }
  /**
   * 
   */
  public function chercherdisponibiliteCountTotByStatut($id, $da_debut, $da_fin, $condi=null){
    $dispo = $this->find()
    ->where([
        ['Dispos.annonce_id' => $id],
        'OR' => [["Dispos.fin_at > '$da_debut'","Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at >= '$da_debut'", "Dispos.fin_at <= '$da_fin'"], ["Dispos.dbt_at > '$da_debut'","Dispos.dbt_at < '$da_fin'"], ["Dispos.dbt_at <= '$da_debut'","Dispos.fin_at > '$da_fin'"]],
      ]);
    if($condi != null) {
      $dispo->andWhere($condi);
    }
    $dispo->group(['Dispos.statut']);
    $dispo->count();
    return $dispo;
  }

  function getDisposForPeroid($annonceId, $startDate, $endDate, $condition = null)
  {
      $dispo = $this->find()
          ->where([
              ['Dispos.annonce_id' => $annonceId],
              'OR' => [
                  ["Dispos.fin_at > '$startDate'","Dispos.fin_at <= '$endDate'"],
                  ["Dispos.dbt_at >= '$startDate'", "Dispos.fin_at <= '$endDate'"],
                  ["Dispos.dbt_at > '$startDate'","Dispos.dbt_at < '$endDate'"],
                  ["Dispos.dbt_at <= '$startDate'","Dispos.fin_at > '$endDate'"]
              ],
          ]);

      if ($condition != null) {
          $dispo->andWhere($condition);
      }

      $dispo->order(['dbt_at' => 'ASC']);

      return $dispo;
  }

}
