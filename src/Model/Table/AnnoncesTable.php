<?php
namespace App\Model\Table;

use App\Model\Entity\Annonce;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\ORM\TableRegistry;

/**
 * Annonces Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Proprietaires
 * @property \Cake\ORM\Association\BelongsTo $Lieugeos
 * @property \Cake\ORM\Association\BelongsTo $Kmcomms
 * @property \Cake\ORM\Association\BelongsTo $Kmcvils
 * @property \Cake\ORM\Association\BelongsTo $Kmstats
 * @property \Cake\ORM\Association\HasMany $Clics
 * @property \Cake\ORM\Association\HasMany $Contrats
 * @property \Cake\ORM\Association\HasMany $Dispos
 * @property \Cake\ORM\Association\HasMany $Photos
 * @property \Cake\ORM\Association\HasMany $Reservations
 * @property \Cake\ORM\Association\HasMany $Selections
 */
class AnnoncesTable extends Table
{
    const PARKING_TYPES = [
      0 => 'Garage',
      1 => 'Parking',
      2 => 'à Proximité',
      3 => 'Réservation sur place',
      4 => 'Aucun',
    ];
 
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('annonces');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Utilisateurs', [
            'foreignKey' => 'proprietaire_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Lieugeos', [
            'foreignKey' => 'lieugeo_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Villages', [
          'foreignKey' => 'village',
          'joinType' => 'INNER'
        ]);
        $this->belongsTo('Residences', [
            'foreignKey' => 'batiment',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Dispos', [
            'foreignKey' => 'annonce_id'
        ]);
        $this->hasMany('Photos', [
            'foreignKey' => 'annonce_id'
        ]);
        $this->hasOne('Contrats', [
          'foreignKey' => 'annonce_id',
          'joinType' => 'INNER'
        ]);
    }
    /*
     *
     */
    function detailsannonce($url,$get){
      $annoncesWithperiod = $this->find();
      $annoncesWithperiod->join([
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'inner',
          'conditions' => 'U.id=Annonces.proprietaire_id',
        ],
        'R' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'Annonces.batiment=R.id',
        ],
        'G' => [
          'table' => 'gestionnaires',
          'type' => 'left',
          'conditions' => 'Annonces.id_gestionnaires=G.id'
        ],
        'D' => [
          'table' => 'dispos',
          'type' => 'inner',
          'conditions' => ['D.annonce_id=Annonces.id','DATE(D.fin_at) >=' => date('Y-m-d')],
        ],

      ])
      ->group(['Annonces.id']);
      $annoncesWithperiod->select(['Annonces.id','R.name','U.portable','U.telephone','D.id','U.email','U.id','G.name','Annonces.num_app','Annonces.created_at','U.prenom','U.nom_famille','Annonces.contrat','Annonces.mise_relation']);

      $annoncesWithoutperiod = $this->find();
      $annoncesWithoutperiod->join([
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'inner',
          'conditions' => 'U.id=Annonces.proprietaire_id',
        ],
        'R' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'Annonces.batiment=R.id',
        ],
        'G' => [
          'table' => 'gestionnaires',
          'type' => 'left',
          'conditions' => 'Annonces.id_gestionnaires=G.id'
        ],
        'D' => [
          'table' => 'dispos',
          'type' => 'left',
          'conditions' => ['D.annonce_id=Annonces.id','DATE(D.fin_at) >=' => date('Y-m-d')],
        ],

      ])
      ->where(['D.id IS NULL'])->group(['Annonces.id']);
      $annoncesWithoutperiod->select(['Annonces.id','R.name','U.portable','U.telephone','D.id','U.email','U.id','G.name','Annonces.num_app','Annonces.created_at','U.prenom','U.nom_famille','Annonces.contrat','Annonces.mise_relation']);
        
        $array=$annoncesWithperiod->union($annoncesWithoutperiod)->toArray();
        $output = array(
            "data" => array()
        );
        foreach($array as $res)
          {
            //Liste Feedbacks
            $feedbacks = TableRegistry::get('Feedbacks');
            $listerating = $feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$res->id]);
            // Notes Globales
            $notecara = [];
            foreach ($listerating as $key) {
              $notecommentaire = 0;
              foreach ($key['ratings'] as $value) {
                $notecara[$value->caracteristique] += $value->note;
                $notecommentaire += $value->note;
              }
              $notecommentaireuser[$key->id] = $notecommentaire;
            }
            if($listerating->count() != 0) $noteglobalmoy = $notecara['emplacement']/$listerating->count()+$notecara['confort']/$listerating->count()+$notecara['qualiteprix']/$listerating->count();
            else $noteglobalmoy = 0;
            if(count($notecara) > 0){
              $notationglobale = round(($noteglobalmoy/3), 1)." / 5 ";
            }else{
              $notationglobale = "<span class='label label-danger'>Pas de note</span>";
            }
                $row = array();
                //if(empty($res['D']['id'])){
                $row[0]=$res->id;
                $row[1]=$res['R']['name'];
                $row[2]=$res->num_app;//strftime('%d/%m/%y',strtotime($res['A']['created_at']));
                $row[3]=$res['U']['telephone'];
                $row[4]=$res['U']['portable'];
                $row[5]='<span>'.$res['U']['email'].'</span>'."<span><button data-target=\"editProp-modal\" class=\"buton_add btn btn-primary btn-icon-anim btn-square btn-sm pull-right editProp\" data-annonce=\"$res->id\" data-prop='".$res['U']['id']."' ><i class=\"fa fa-pencil\"></i></button></span>";
                $row[6]=$res['U']['nom_famille']." ".$res['U']['prenom'];
                if($res['G']['name'] == ''){
                    $row[7] = "<button  data-toggle=\"modal\" data-target=\"#responsive-modal\" class=\"buton_add btn btn-primary btn-icon-anim btn-square btn-sm\" data-key=\"$res->id\" ><i class=\"fa fa-plus\"></i></button>";
                }else{
                  $row[7]=$res['G']['name'];
                }
                $row[8]=$notationglobale;
                if($res['D']['id'] === NULL){
                    $row[9]="<span class=\"label label-danger\">Sans Période</span>";
                }else{
                    $row[9]="<span class=\"label label-success\">Avec periode</span>";
                }
                    
                $row[10]="<center>"
                        . "<a target=\"_blank\" href=\"".$url."annonces/edit/".$res->id."\"><button class=\"btn btn-sm btn-default btn-icon-anim btn-circle\"><i class=\"fa fa-pencil\"></i></button></a>"
                        . "<a target=\"_blank\" href=\"".$url."annonces/view/".$res->id."\"><button class=\"btn btn-sm btn-warning btn-icon-anim btn-circle\"><i class=\"fa fa-search\"></i></button></a>"
                        . "</center>";
                $output['data'][] = $row;
              //}
          }
      return  $output ;
    }
    /*
     *
     */
    public function detailsannoncedates($url, $get, $dbt, $fin){
$gestion= $this->find();

        $gestion->join([
              'U' => [
                'table' => 'utilisateurs',
                'type' => 'inner',
                'conditions' => 'U.id=Annonces.proprietaire_id',
              ],
              'R' => [
                'table' => 'residences',
                'type' => 'left',
                'conditions' => 'Annonces.batiment=R.id',
              ],
              // 'AN' => [
              //   'table' => 'annoncegestionnaires',
              //   'type' => 'left',
              //   'conditions' => 'Annonces.id=AN.id_annonces',
              // ],
              'G' => [
                'table' => 'gestionnaires',
                'type' => 'left',
                'conditions' => 'Annonces.id_gestionnaires=G.id',
              ],
              'D' => [
                'table' => 'dispos',
                'type' => 'left',
                'conditions' => ['D.annonce_id=Annonces.id', array('OR' => [["D.fin_at > '$dbt'","D.fin_at <= '$fin'"], ["D.dbt_at >= '$dbt'", "D.fin_at <= '$fin'"], ["D.dbt_at > '$dbt'","D.dbt_at < '$fin'"], ["D.dbt_at <= '$dbt'","D.fin_at > '$fin'"]])],
              ],

            ])
                ->where(['D.id IS NULL'])
            ->select(['Annonces.id','R.name','U.portable','U.telephone','D.id','U.email','U.id','G.name','Annonces.num_app','Annonces.created_at','U.prenom','U.nom_famille','Annonces.contrat','Annonces.mise_relation']);

        $gestion->group(['Annonces.id']);

        $output = array(
                        "data" => array()
                        );
          foreach($gestion as $res)
            {
                    //Liste Feedbacks
                  $feedbacks = TableRegistry::get('Feedbacks');
                  $listerating = $feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$res->id]);
                  // Notes Globales
                  $notecara = [];
                  foreach ($listerating as $key) {
                    $notecommentaire = 0;
                    foreach ($key['ratings'] as $value) {
                      $notecara[$value->caracteristique] += $value->note;
                      $notecommentaire += $value->note;
                    }
                    $notecommentaireuser[$key->id] = $notecommentaire;
                  }
                  $noteglobalmoy = $notecara['emplacement']/$listerating->count()+$notecara['confort']/$listerating->count()+$notecara['qualiteprix']/$listerating->count();
                  if(count($notecara) > 0){
                    $notationglobale = round(($noteglobalmoy/3), 1)." / 5 ";
                  }else{
                    $notationglobale = "<span class='label label-danger'>Pas de note</span>";
                  }
                $row = array();
                  $row[0]=$res->id;
                  $row[1]=$res['R']['name'];
                  $row[2]=$res->num_app;//strftime('%d/%m/%y',strtotime($res['A']['created_at']));
                  $row[3]=$res['U']['telephone'];
                  $row[4]=$res['U']['portable'];
                  $row[5]=$res['U']['email']."<button data-target=\"editProp-modal\" class=\"buton_add btn btn-primary btn-icon-anim btn-square btn-sm pull-right editProp\" data-annonce=\"$res->id\" data-prop='".$res['U']['id']."' ><i class=\"fa fa-pencil\"></i></button>";
                  $row[6]=$res['U']['nom_famille']." ".$res['U']['prenom'];
                  if($res['G']['name'] == ''){
                      $row[7] = "<button  data-toggle=\"modal\" data-target=\"#responsive-modal\" class=\"buton_add btn btn-primary btn-icon-anim btn-square btn-sm\" data-key=\"$res->id\" ><i class=\"fa fa-plus\"></i></button>";
                  }else{
                      $row[7]=$res['G']['name'];
                  }
                  $row[8]=$notationglobale;
                  $row[9]="<span class=\"label label-danger\">Aucune Période</span>";
                  $row[10]="<center>"
                          . "<a target=\"_blank\" href=\"".$url."annonces/edit/".$res->id."\"><button class=\"btn btn-sm btn-default btn-icon-anim btn-circle\"><i class=\"fa fa-pencil\"></i></button></a>"
                          . "<a target=\"_blank\" href=\"".$url."annonces/view/".$res->id."\"><button class=\"btn btn-sm btn-warning btn-icon-anim btn-circle\"><i class=\"fa fa-search\"></i></button></a>"
                          . "</center>";
                  $output['data'][] = $row;
            }
      return  $output ;
    }
  /*
   *
   */
    function get_array_annonce($url,$get){
		$aColumns = array( 'Annonces.id','R.name','Annonces.num_app','U.portable','U.email','U.nom_famille','Annonces.contrat' );
		$sOrder = array();
    if ( isset( $get['iSortCol_0'] ) )
    {
      for ( $i=0 ; $i<intval($get['iSortingCols'] ) ; $i++ )
      {
          if ( $get[ 'bSortable_'.intval($get['iSortCol_'.$i]) ] == "true" )
          {
                  $sOrder[$i]= $aColumns[ intval( $get['iSortCol_'.$i] ) ]." ".$get['sSortDir_'.$i];
          }
      }
    }
    $orWhere = array();
    if ( isset($get['sSearch']) && $get['sSearch'] != "" )
    {
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
                $orWhere[$i]= "LOWER(".$aColumns[$i].") LIKE '%". strtolower($get['sSearch'])."%'";
        }
    }
    $awhere=array();
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($get['bSearchable_'.$i]) && $get['bSearchable_'.$i] == "true" && $get['sSearch_'.$i] != '' )
        {
            $awhere[$i]= $aColumns[$i]." LIKE '%".$get['sSearch_'.$i]."%'";
        }
    }
      $gestion= $this->find();
	    $gCount = $this->find();
			$gestion->join([
						'U' => [
							'table' => 'utilisateurs',
							'type' => 'inner',
							'conditions' => 'U.id=Annonces.proprietaire_id',
						],
						'R' => [
							'table' => 'residences',
							'type' => 'left',
							'conditions' => 'Annonces.batiment=R.id',
						],
						// 'AN' => [
						// 	'table' => 'annoncegestionnaires',
						// 	'type' => 'left',
						// 	'conditions' => 'Annonces.id=AN.id_annonces',
						// ],
						'G' => [
							'table' => 'gestionnaires',
							'type' => 'left',
							'conditions' => 'Annonces.id_gestionnaires=G.id',
						]

					])
					->select(['Annonces.id','R.name','U.portable','U.telephone','U.email','G.name','Annonces.num_app','Annonces.created_at','Annonces.updated_at','U.prenom','U.nom_famille','Annonces.contrat','Annonces.mise_relation']);
			$gCount->join([
						'U' => [
							'table' => 'utilisateurs',
							'type' => 'inner',
							'conditions' => 'U.id=Annonces.proprietaire_id',
						],
						'R' => [
							'table' => 'residences',
							'type' => 'left',
							'conditions' => 'Annonces.batiment=R.id',
						]

					])
					->select(['nbr' => $gCount->func()->count('*')]);

			if(!empty($orWhere)){
        $gestion->where([$awhere,"OR"=>$orWhere]);
        $gCount->where([$awhere,"OR"=>$orWhere]);
			}
			$start=1;
			if($get['iDisplayStart']>0){
				$start=($get['iDisplayStart']/$get['iDisplayLength'])+1;
			}
			$gestion->order($sOrder);
			$count=$gCount->first();
      $output = array(
              "sEcho" => intval($get['sEcho']),
              "iTotalRecords" => $count["nbr"],
              "iTotalDisplayRecords" => $count["nbr"],
              "aaData" => array()
              );

      foreach($gestion as $res)
      {
        //Liste Feedbacks
        $feedbacks = TableRegistry::get('Feedbacks');
        $listerating = $feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$res->id]);
        // Notes Globales
        $notecara = [];
        foreach ($listerating as $key) {
          $notecommentaire = 0;
          foreach ($key['ratings'] as $value) {
            $notecara[$value->caracteristique] += $value->note;
            $notecommentaire += $value->note;
          }
          $notecommentaireuser[$key->id] = $notecommentaire;
        }
        $noteglobalmoy = $notecara['emplacement']/$listerating->count()+$notecara['confort']/$listerating->count()+$notecara['qualiteprix']/$listerating->count();
        if(count($notecara) > 0){
          $notationglobale = round(($noteglobalmoy/3), 1)." / 5 ";
        }else{
          $notationglobale = "<span class='label label-danger'>Pas de note</span>";
        }
          $row = array();
          $img="";
            if(empty($res->contrat)&&empty($res->mise_relation)){
                    $img="<a class=\"exclamation-circle\"><i class=\"fa fa-exclamation-circle\"></i></a>";
            }else{
                    $img="<a class=\"check-circle\"><i class=\"fa fa-check-circle\"></i></a>";
            }
          $fin="";
          $row[0]=$res->id;
          if($res->updated_at != null) $row[1]=$res->updated_at->i18nFormat('dd/MM/yyyy');
          else $row[1]=$res->updated_at;
          $row[2]=$res['R']['name'];
          $row[3]=$res->num_app;
          $row[4]=$res['U']['telephone'];
          $row[5]=$res['U']['portable'];
          $row[6]=$res['U']['email'];
          $row[7]=$res['U']['nom_famille']." ".$res['U']['prenom'];
          if($res['G']['name'] == ''){
            //$row[8] = "<a href='".$url."manager/annonces/attribuergestionnaire/".$res->id."' class='edit_locataire' title='Choisir Gestionnaire'><img src='".$url."images/plusalp.png' /></a>";
            $row[8] = "<button  data-toggle=\"modal\" data-target=\"#responsive-modal\" class=\"buton_add btn btn-primary btn-icon-anim btn-square btn-sm\" data-key=\"$res->id\" ><i class=\"fa fa-plus\"></i></button>";
          }else{
            $row[8]=$res['G']['name'];
          }
          $row[9] = $notationglobale;
          $row[10]=$img;
          $row[11]="<center><a target=\"_blank\" href=\"".$url."annonces/edit/".$res->id."\"><button class=\"btn btn-sm btn-default btn-icon-anim btn-circle\"><i class=\"fa fa-pencil\"></i></button></a>"
                  . "<a target=\"_blank\" href=\"".$url."annonces/view/".$res->id."\"><button class=\"btn btn-sm btn-warning btn-icon-anim btn-circle\"><i class=\"fa fa-search\"></i></button></a></center>";
          $output['aaData'][] = $row;
      }
      return  $output ;
    }
  /**
    *
    **/
    function get_array_menage($url,$get,$id_ges){
        $aColumns = array( 'R.name','U.prenom','Annonces.num_app','Annonces.surface' );
        $sOrder = array();
        if ( isset( $get['iSortCol_0'] ) )
        {
            for ( $i=0 ; $i<intval($get['iSortingCols'] ) ; $i++ )
            {
                if ( $get[ 'bSortable_'.intval($get['iSortCol_'.$i]) ] == "true" )
                {
                    $sOrder[$i]= $aColumns[ intval( $get['iSortCol_'.$i] ) ]." ".$get['sSortDir_'.$i];
                }
            }
        }
        $gestion= $this->find();
        $gCount = $this->find();
        $gestion->join([
            'RR' => [
                'table' => 'reservations',
                'type' => 'inner',
                'conditions' => ['RR.annonce_id=Annonces.id',"RR.statut=90"],
            ],
            'U' => [
                'table' => 'utilisateurs',
                'type' => 'inner',
                'conditions' => 'U.id=RR.utilisateur_id',
            ],
            'P' => [
                'table' => 'utilisateurs',
                'type' => 'inner',
                'conditions' => 'P.id=Annonces.proprietaire_id',
            ],
            'G' => [
              'table' => 'gestionnaires',
              'type' => 'inner',
              'conditions' => ['G.id'=>$id_ges,'Annonces.id_gestionnaires=G.id']
            ],
            // 'AG' => [
            //     'table' => 'annoncegestionnaires',
            //     'type' => 'inner',
            //     'conditions' => ['AG.id_annonces=Annonces.id','AG.id_gestionnaires'=>$id_ges],
            // ],
            'R' => [
                'table' => 'residences',
                'type' => 'left',
                'conditions' => ['R.id=Annonces.batiment','RR.menage>=1'],
            ]

        ])
            ->select(['Annonces.num_app','U.prenom','U.nom_famille','U.portable','P.prenom','P.nom_famille','P.portable','R.name','Annonces.id','Annonces.surface','RR.id','RR.menage','RR.dbt_at']);
        $gCount->join([
            'RR' => [
                'table' => 'reservations',
                'type' => 'inner',
                'conditions' => ['RR.annonce_id=Annonces.id',"RR.statut=90"],
            ],
            'U' => [
                'table' => 'utilisateurs',
                'type' => 'inner',
                'conditions' => 'U.id=RR.utilisateur_id',
            ],
            'P' => [
                'table' => 'utilisateurs',
                'type' => 'inner',
                'conditions' => 'P.id=Annonces.proprietaire_id',
            ],
            'G' => [
              'table' => 'gestionnaires',
              'type' => 'inner',
              'conditions' => ['G.id'=>$id_ges,'Annonces.id_gestionnaires=G.id']
            ],
            // 'AG' => [
            //     'table' => 'annoncegestionnaires',
            //     'type' => 'inner',
            //     'conditions' => ['AG.id_annonces=Annonces.id','AG.id_gestionnaires'=>$id_ges],
            // ],
            'R' => [
                'table' => 'residences',
                'type' => 'left',
                'conditions' => ['R.id=Annonces.batiment','RR.menage>=1'],
            ]
        ])
        ->select(['nbr' => $gCount->func()->count('*')]);
        $debut=date('Y-m-d', strtotime($get['from']));
        $fin=date('Y-m-d', strtotime($get['to']));
        $gestion->where(["RR.dbt_at >='$debut'" , "RR.dbt_at <='$fin'"]);
        $gCount->where(["RR.dbt_at >='$debut'" , "RR.dbt_at <='$fin'"]);
        $start=1;
        if($get['iDisplayStart']>0){
            $start=($get['iDisplayStart']/$get['iDisplayLength'])+1;
        }
        $gestion->order($sOrder)
            ->limit($get['iDisplayLength'])
            ->page($start);
        $count=$gCount->first();
       $output = array(
            "sEcho" => intval($get['sEcho']),
            "iTotalRecords" => $count["nbr"],
            "iTotalDisplayRecords" => $count["nbr"],
            "aaData" => array()
        );
        foreach($gestion as $res)
        {
            $row = array();
            $row[0]=$res['R']['name'];
            $row[1]=$res->id;
            $row[2]=$res->num_app;
            $row[3]=$res->surface." m²";
            $row[4]=date('d-m-Y', strtotime($res['RR']['dbt_at']));;
            $row[5]=$res['U']['prenom']." ".$res['U']['nom_famille'];
            $row[6]=$res['U']['portable'];
            $row[7]=$res['P']['prenom']." ".$res['P']['nom_famille'];
            $row[8]=$res['U']['portable'];
            if($res['RR']['menage']==1){
                $row[9]="<div class='iconBox gray' original-title='Valider le menage'> <a  class='validation_menage' data-key='".$res['RR']['id']."' data-name='".$res->num_app."'><img alt='valider' src='".$url."images/directional_right.png' style='opacity: 1;'></a></div><div class='iconBox gray' original-title='Envoi mail demande de reglement ménage'> <a  class='sendmail' href='".$url."manager/arrivees/sendmailmenage/".$res['RR']['id']."'><img alt='mail' src='".$url."images/mail.png' style='opacity: 1;'></a></div>";
            }else{
                $row[9]="<img title=' validation ' alt=' Delete ' src='".$url."images/val-sel.png'>";
            }
            $output['aaData'][] = $row;
        }
        return  $output ;
    }
    /**
     *
     **/
    function get_array_cle($get,$id_gest,$url,$arg,$cond){
      $contrat_cond=['CR.annonce_id=Annonces.id','CR.visible'=>1];
      if($id_gest!=null)
        $contrat_cond=['CR.annonce_id=Annonces.id','CR.visible'=>1,'Annonces.id_gestionnaires'=>$id_gest];
      $arrivee=$this->find();
        $arrivee->join([
            // 'AN' => [
            //   'table' => 'annoncegestionnaires',
            //   'type' => 'inner',
            //   'conditions' => ['Annonces.id=AN.id_annonces','AN.visible=1'],
            // ],
            'CR' => [
              'table' => 'contrats',
              'type' => 'INNER',
              'conditions' => $contrat_cond
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
            // ],
            'R' => [
              'table' => 'residences',
              'type' => 'left',
              'conditions' => ['Annonces.batiment=R.id'],
            ],
            'U' => [
              'table' => 'utilisateurs',
              'type' => 'inner',
              'conditions' => ['Annonces.proprietaire_id=U.id'],
            ]
          ]);
          
          if($cond=="appart")
            $arrivee->where(['OR' => ['Annonces.id LIKE '=>'%'.$arg.'%',
                                     'Annonces.num_app LIKE '=>'%'.$arg.'%']]);
          elseif ($cond=="prop")
            $arrivee->where(['OR' => [
                'LOWER(U.email) LIKE '=>'%'.strtolower($arg).'%',
                'LOWER(U.prenom) LIKE '=>'%'.strtolower($arg).'%',
                'LOWER(U.nom_famille) LIKE '=>'%'.strtolower($arg).'%'
            ]]);
          
          $arrivee->select(['Annonces.id','Annonces.num_app','Annonces.position_cle','Annonces.id','R.name','U.prenom','U.nom_famille','U.email'])
          ->distinct(['Annonces.id']);

          $output = array(
                      "data" => array()
                      );
          foreach($arrivee as $c)
          {
            $row = array();
            $row[1]=$c['R']['name'];
            $row[2]=$c->id;
            $row[3]=$c->num_app;
            $row[4]=$c['U']['prenom']." ".$c['U']['nom_famille'];
            $row[5]=$c['U']['email'];
            if($c->position_cle != '0'){
              $row[0]=$c->position_cle;
            }else{
              $row[0]="";
            }
            $idan = $c['AN']['id'];
            $output['data'][] = $row;
          }
          return $output;
    }
    
    function get_array_gestion_cle($get,$id_gest,$url){
      $arrivee=$this->find();
      $contrat_cond=['CR.annonce_id=Annonces.id','CR.visible'=>1];
      if($id_gest!=null)
        $contrat_cond=['CR.annonce_id=Annonces.id','CR.visible'=>1,'Annonces.id_gestionnaires'=>$id_gest];
      $arrivee->join([
            // 'AN' => [
            //   'table' => 'annoncegestionnaires',
            //   'type' => 'inner',
            //   'conditions' => ['Annonces.id=AN.id_annonces','AN.visible=1'],
            // ],
            'CR' => [
              'table' => 'contrats',
              'type' => 'INNER',
              'conditions' => $contrat_cond
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
            // ],
            'R' => [
              'table' => 'residences',
              'type' => 'left',
              'conditions' => ['Annonces.batiment=R.id'],
            ],
            'U' => [
              'table' => 'utilisateurs',
              'type' => 'inner',
              'conditions' => ['Annonces.proprietaire_id=U.id'],
            ]
          ])
          ->where('Annonces.visible=1')
        ->select(['Annonces.id','Annonces.num_app','Annonces.position_cle','R.name','U.prenom','U.nom_famille','U.email']);
        $output = array(
            "data" => array()
          );
          foreach($arrivee as $c)
          {
            $row = array();
            $row[0]=$c['R']['name'];
            $row[1]=$c->id;
            $row[2]=$c->num_app;
            $row[3]=$c['U']['prenom']." ".$c['U']['nom_famille'];
            $row[4]=$c['U']['email'];
            if($c->position_cle != '0'){
              $row[5]=$c->position_cle;
            }else{
              $row[5]="";
            }
            $row[6]="<div class='text-center'>"
                  . "<button data-toggle=\"modal\" data-target=\"#responsive-modal\" data-href='".$url."manager/annonces/modifierclegest/".$c->id."' class=\"btn btn-sm btn-warning btn-icon-anim btn-circle\"><i class=\"fa fa-pencil\"></i></button>"
                  . "</div>";
            $output['data'][] = $row;
          }
          return $output;
    }
  /**
   *
   **/
	public function setPasswordLocation($login=null,$password=null,$email=null,$npassword=null)
    {
      $rslt = array();
      $a_login=array('saber.boussada@gmail.com','gestion@alpissime.com','anis.agrebi@gmail.com');
  		$a_password=array('baraa12/*','mercure2016','anis/*2016');
  		if(in_array($login,$a_login)&&in_array($password,$a_password)){
  			if(!empty($res[0]['U']['id'])){
  				$pass_md5=md5($npassword);
  				$rslt['message']='modification mot de passe d location';
  				$rslt['modification']=true;
  			}else{
  				$rslt['message']='utilisateur n\'exist pas';
  				$rslt['modification']=false;
  			}
  		}else{
  			$rslt['message']='login ou password n\'exist pas';
  			$rslt['modification']=false;
  		}
      return (json_encode($rslt));
    }
    /**
     *
     **/
    public function chercheannonceprop($id){
      $annprop = $this->find();
      $annprop->join([
          'P' => [
              'table' => 'utilisateurs',
              'type' => 'inner',
              'conditions' => 'P.id=Annonces.proprietaire_id',
          ]
      ])
      ->select(['P.prenom','P.nom_famille','P.telephone','P.email']);
      $annprop->where(["Annonces.id" => $id]);
      return $annprop;
    }
    /**
     *
     **/
    public function get_array_rapport_stat_info_gener($id){
      $data = array();
      $nbrtotalvalide = $this->find();
      $nbrtotalvalide->where(["Annonces.statut = 50"]);
      $nbrtotalvalide->select(['nbr' => $nbrtotalvalide->func()->count('*')]);
      $nbrtv = $nbrtotalvalide->first();
      $data['annvalide'] = $nbrtv;

      $nbrtotalbrouillon = $this->find();
      $nbrtotalbrouillon->where(["Annonces.statut = 0"]);
      $nbrtotalbrouillon->select(['nbr' => $nbrtotalbrouillon->func()->count('*')]);
      $nbrtb = $nbrtotalbrouillon->first();
      $data['annbrouillon'] = $nbrtb;
      return $data;
    }
    /**
     *
     **/
    public function get_array_rapport_stat_info_detail($get,$gestId){
      $data = array();
      if($gestId['G']['role'] != 'admin'){
        $station = $gestId['G']['name'];
      }else{
        if($get['station'] != 0) {
          $lieugeos = TableRegistry::get('Lieugeos');
          $lieugeo = $lieugeos->find();
          $lieugeo->where(['Lieugeos.id = '.$get['station']]);
          $lieugeo->select(['Lieugeos.name']);
          $nbrlieugeo = $lieugeo->first();
          $station = $nbrlieugeo->name;
        }else $station = "Toutes Les Stations";
      }

      $data['stationname'] = $station;
      $data['stationperiode'] = $station. " Du ".$get['from']." Au ".$get['to'];

      $nbrannoncestation = $this->find();
      if($get['station'] != 0){
        $nbrannoncestation->join([
                        'L' => [
                          'table' => 'lieugeos',
                          'type' => 'inner',
                          'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$get['station']],
                        ]
                      ]);
      }
      if($gestId['G']['role'] != 'admin'){
        $nbrannoncestation->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        // $nbrannoncestation->join([
        //                 'AG' => [
        //                   'table' => 'annoncegestionnaires',
        //                   'type' => 'inner',
        //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //                 ]
        //               ]);
      }
      $nbrannoncestation->where(["Annonces.statut = 50 OR Annonces.statut = 0"]);
      $nbrannoncestation->select(['nbr' => $nbrannoncestation->func()->count('*')]);
      $nbrannstation = $nbrannoncestation->first();
      $data['annstation'] = $nbrannstation;

      $aWhere1=array();
      $surf1 = $this->find();
      if($get['station'] != 0){
        $surf1->join([
                      'L' => [
                        'table' => 'lieugeos',
                        'type' => 'inner',
                        'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$get['station']],
                      ]
                    ]);
      }
      if($gestId['G']['role'] != 'admin'){
        $surf1->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        // $surf1->join([
        //               'AG' => [
        //                 'table' => 'annoncegestionnaires',
        //                 'type' => 'inner',
        //                 'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //               ]
        //             ]);
      }
      $surf1->select(['nbr' => $surf1->func()->count('*')]);
      $aWhere1[] = ["Annonces.surface >= 0 AND Annonces.surface <= 30"];
      $surf1->where($aWhere1);
      $nbrsurf1 = $surf1->first();
      $data['nbrsurf1'] = $nbrsurf1;

      $aWhere2=array();
      $surf2 = $this->find();
      if($get['station'] != 0){
        $surf2->join([
                      'L' => [
                        'table' => 'lieugeos',
                        'type' => 'inner',
                        'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$get['station']],
                      ]
                    ]);
      }
      if($gestId['G']['role'] != 'admin'){
        $surf2->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        // $surf2->join([
        //               'AG' => [
        //                 'table' => 'annoncegestionnaires',
        //                 'type' => 'inner',
        //                 'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //               ]
        //             ]);
      }
      $surf2->select(['nbr' => $surf2->func()->count('*')]);
      $aWhere2[] = ["Annonces.surface > 30 AND Annonces.surface <= 90"];
      $surf2->where($aWhere2);
      $nbrsurf2 = $surf2->first();
      $data['nbrsurf2'] = $nbrsurf2;

      $aWhere3=array();
      $surf3 = $this->find();
      if($get['station'] != 0){
        $surf3->join([
                      'L' => [
                        'table' => 'lieugeos',
                        'type' => 'inner',
                        'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$get['station']],
                      ]
                    ]);
      }
      if($gestId['G']['role'] != 'admin'){
        $surf3->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        // $surf3->join([
        //               'AG' => [
        //                 'table' => 'annoncegestionnaires',
        //                 'type' => 'inner',
        //                 'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //               ]
        //             ]);
      }
      $surf3->select(['nbr' => $surf3->func()->count('*')]);
      $aWhere3[] = ["Annonces.surface > 90"];
      $surf3->where($aWhere3);
      $nbrsurf3 = $surf3->first();
      $data['nbrsurf3'] = $nbrsurf3;

      $dbt = new Date($get['from']);
      $fin = new Date($get['to']);
      $dbt = $dbt->i18nFormat('yyyy-MM-dd');
      $fin = $fin->i18nFormat('yyyy-MM-dd');

      $nbrrWhere=array();
      $nbrrWhere[] = ["R.dbt_at >= '$dbt'", "R.dbt_at < '$fin'"];
      $nbrreservation = $this->find();
      if($get['station'] != 0){
        $nbrreservation->join([
                        'L' => [
                          'table' => 'lieugeos',
                          'type' => 'inner',
                          'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$get['station']],
                        ]
                      ]);
      }
      if($gestId['G']['role'] != 'admin'){
        $nbrreservation->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        // $nbrreservation->join([
        //                 'AG' => [
        //                   'table' => 'annoncegestionnaires',
        //                   'type' => 'inner',
        //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //                 ]
        //               ]);
      }
      $nbrreservation->join([
                      'R' => [
                        'table' => 'reservations',
                        'type' => 'inner',
                        'conditions' => ['R.annonce_id = Annonces.id','R.statut = 90'],
                      ]
                    ]);
      $nbrreservation->where($nbrrWhere);
      $nbrreservation->select(['nbr' => $nbrreservation->func()->count('*')]);
      $nbrtotreservation = $nbrreservation->first();
      $data['nbrtotreservation'] = $nbrtotreservation;

      $rWhere=array();
      $rWhere[] = ["R.dbt_at >= '$dbt'", "R.fin_at <= '$fin'"];
      $annreserve = $this->find();
      if($get['station'] != 0){
        $annreserve->join([
                        'L' => [
                          'table' => 'lieugeos',
                          'type' => 'inner',
                          'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$get['station']],
                        ]
                      ]);
      }
      if($gestId['G']['role'] != 'admin'){
        $annreserve->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        // $annreserve->join([
        //                 'AG' => [
        //                   'table' => 'annoncegestionnaires',
        //                   'type' => 'inner',
        //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //                 ]
        //               ]);
      }
      $annreserve->join([
                      'R' => [
                        'table' => 'reservations',
                        'type' => 'inner',
                        'conditions' => ['R.annonce_id = Annonces.id','R.statut = 90'],
                      ]
                    ]);
      $annreserve->where($rWhere);
      $annreserve->select(['nbr' => $annreserve->func()->count('*')]);
      $annreserve->group(['Annonces.id']);
      $nbrAnnoncesRes = $annreserve->count();
      $data['nbrAnnoncesRes'] = $nbrAnnoncesRes;

      $aWhere=array();
      $aWhere[] = "Annonces.created_at >= '".$dbt."' AND Annonces.created_at <= '".$fin."'";
      $annonces = $this->find();
      if($get['station'] != 0){
        $annonces->join([
                        'L' => [
                          'table' => 'lieugeos',
                          'type' => 'inner',
                          'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$get['station']],
                        ]
                      ]);
      }
      if($gestId['G']['role'] != 'admin'){
        $annonces->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        // $annonces->join([
        //                 'AG' => [
        //                   'table' => 'annoncegestionnaires',
        //                   'type' => 'inner',
        //                   'conditions' => ['AG.id_annonces = Annonces.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
        //                 ]
        //               ]);
      }
      $annonces->where($aWhere);
      $annonces->select(['nbr' => $annonces->func()->count('*')]);
      $nbrAnnonces = $annonces->first();
      $data['nbrAnnoncescree'] = $nbrAnnonces;

      $weretotal=array();
      $weretotal[] = ["Reservations.dbt_at >= '$dbt'", "Reservations.dbt_at < '$fin'"];
      $reservationstable = TableRegistry::get('Reservations');
      $weretotal[] = ["Reservations.statut = 90"];
      $querytotal = $reservationstable->find();
      $querytotal->join([
                  'A' => [
                    'table' => 'annonces',
                    'type' => 'inner',
                    'conditions' => ['Reservations.annonce_id = A.id'],
                  ]
                ]);
      if($get['station'] != 0){
                  $querytotal->join([
                  'L' => [
                    'table' => 'lieugeos',
                    'type' => 'inner',
                    'conditions' => ["A.lieugeo_id = L.id", "L.id = ".$get['station']],
                  ]
                ]);
              }
     if($gestId['G']['role'] != 'admin'){
      $querytotal->where(['A.id_gestionnaires'=>$gestId['G']['id']]);
      //  $querytotal->join([
      //                  'AG' => [
      //                    'table' => 'annoncegestionnaires',
      //                    'type' => 'inner',
      //                    'conditions' => ['AG.id_annonces = A.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
      //                  ]
      //                ]);
     }
     $querytotal->where($weretotal);
     $querytotal->select(['count' => $querytotal->func()->sum('Reservations.nb_adultes')]);
     $nbradulttotal = $querytotal->first();

     $query2total = $reservationstable->find();
     $query2total->join([
                'A' => [
                  'table' => 'annonces',
                  'type' => 'inner',
                  'conditions' => ['Reservations.annonce_id = A.id'],
                ]
              ]);
     if($get['station'] != 0){
     $query2total->join([
                  'L' => [
                    'table' => 'lieugeos',
                    'type' => 'inner',
                    'conditions' => ["A.lieugeo_id = L.id", "L.id = ".$get['station']],
                  ]
                ]);
              }
     if($gestId['G']['role'] != 'admin'){
      $query2total->where(['A.id_gestionnaires'=>$gestId['G']['id']]);
      //  $query2total->join([
      //                  'AG' => [
      //                    'table' => 'annoncegestionnaires',
      //                    'type' => 'inner',
      //                    'conditions' => ['AG.id_annonces = A.id', 'AG.id_gestionnaires = '.$gestId['G']['id']],
      //                  ]
      //                ]);
     }
     $query2total->where($weretotal);
     $query2total->select(['count' => $query2total->func()->sum('Reservations.nb_enfants')]);
     $nbrenfanttotal = $query2total->first();

     if($nbrtotreservation->nbr==0) $nbrdulttotal = 0;
     else $nbrdulttotal = $nbradulttotal->count ;

     if($nbrtotreservation->nbr==0) $nbrenftotal = 0;
     else $nbrenftotal = $nbrenfanttotal->count ;
     $data['totalpersonne'] = ($nbrdulttotal+$nbrenftotal);

      return $data;
    }
    /**
     *
     **/
    public function get_array_rapport_stat($url,$get,$gestId){
      $sOrder = array();
      if ( isset( $get['iSortCol_0'] ) )
      {
          for ( $i=0 ; $i<intval($get['iSortingCols'] ) ; $i++ )
          {
              if ( $get[ 'bSortable_'.intval($get['iSortCol_'.$i]) ] == "true" )
              {
                      $sOrder[$i]= $aColumns[ intval( $get['iSortCol_'.$i] ) ]." ".$get['sSortDir_'.$i];
              }
          }
      }
      if(!empty($get['from']) && !empty($get['to'])){
        $dbt = new Date($get['from']);
        $fin = new Date($get['to']);
        $dbt = $dbt->i18nFormat('yyyy-MM-dd');
        $fin = $fin->i18nFormat('yyyy-MM-dd');
      }
      $output = array(
                    "sEcho" => intval($get['sEcho']),
                    "iTotalRecords" => 1,
                    "iTotalDisplayRecords" => 1,
                    "aaData" => array()
                    );
      $row = array();

      $dbt2 = new Date($get['from']);
      $fin2 = new Date($get['to']);
      $fin2 = $fin2->i18nFormat('yyyy-MM-dd');
      $dbtsemaine = $dbt2->i18nFormat('yyyy-MM-dd');
      $dbtaffichage = $dbt2->i18nFormat('dd/MM/yyyy');
      $finsem = $dbt2->modify('+7 day');
      $finsemaine = $finsem->i18nFormat('yyyy-MM-dd');
      $finaffichage = $finsem->i18nFormat('dd/MM/yyyy');

      while ($finsemaine <= $fin2) {
        $nbrrWhere2=array();
        $were= array();
        $aWhere12 = array();
        $aWhere22 = array();
        $aWhere32 = array();
        $nbrrWhere2[] = ["R.dbt_at >= '$dbtsemaine'", "R.dbt_at < '$finsemaine'"];
        $nbrreservation2 = $this->find();
        if($get['station'] != 0){
          $nbrreservation2->join([
                          'L' => [
                            'table' => 'lieugeos',
                            'type' => 'inner',
                            'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$get['station']],
                          ]
                        ]);
        }
        $nbrreservation2->join([
                        'R' => [
                          'table' => 'reservations',
                          'type' => 'inner',
                          'conditions' => ['R.annonce_id = Annonces.id','R.statut = 90'],
                        ]
                      ]);
        if($gestId['G']['role'] != 'admin'){
          $nbrreservation2->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        }
        $nbrreservation2->where($nbrrWhere2);
        $nbrreservation2->select(['nbr' => $nbrreservation2->func()->count('*')]);
        $nbrressem = $nbrreservation2->first();

        $surf12 = $this->find();
        if($get['station'] != 0){
          $surf12->join([
                          'L' => [
                            'table' => 'lieugeos',
                            'type' => 'inner',
                            'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$get['station']],
                          ]
                        ]);
        }
        $surf12->join([
                        'R' => [
                          'table' => 'reservations',
                          'type' => 'inner',
                          'conditions' => ['R.annonce_id = Annonces.id','R.statut = 90'],
                        ]
                      ]);
        if($gestId['G']['role'] != 'admin'){
          $surf12->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        }
        $surf12->select(['nbr' => $surf12->func()->count('*')]);
        $aWhere12[] = ["Annonces.surface >= 0 AND Annonces.surface <= 30"];
        $aWhere12[] = ["R.dbt_at >= '$dbtsemaine'", "R.dbt_at < '$finsemaine'"];
        $surf12->where($aWhere12);
        $surf12->group(['Annonces.id']);
        $nbrsurf12 = $surf12->count();

        $surf22 = $this->find();
        if($get['station'] != 0){
          $surf22->join([
                          'L' => [
                            'table' => 'lieugeos',
                            'type' => 'inner',
                            'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$get['station']],
                          ]
                        ]);
        }
        $surf22->join([
                        'R' => [
                          'table' => 'reservations',
                          'type' => 'inner',
                          'conditions' => ['R.annonce_id = Annonces.id','R.statut = 90'],
                        ]
                      ]);
        if($gestId['G']['role'] != 'admin'){
          $surf22->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        }
        $surf22->select(['nbr' => $surf22->func()->count('*')]);
        $aWhere22[] = ["Annonces.surface >= 31 AND Annonces.surface <= 90"];
        $aWhere22[] = ["R.dbt_at >= '$dbtsemaine'", "R.dbt_at < '$finsemaine'"];
        $surf22->where($aWhere22);
        $surf22->group(['Annonces.id']);
        $nbrsurf22 = $surf22->count();

        $surf32 = $this->find();
        if($get['station'] != 0){
          $surf32->join([
                          'L' => [
                            'table' => 'lieugeos',
                            'type' => 'inner',
                            'conditions' => ["Annonces.lieugeo_id = L.id", "L.id = ".$get['station']],
                          ]
                        ]);
        }
        $surf32->join([
                        'R' => [
                          'table' => 'reservations',
                          'type' => 'inner',
                          'conditions' => ['R.annonce_id = Annonces.id','R.statut = 90'],
                        ]
                      ]);
        if($gestId['G']['role'] != 'admin'){
          $surf32->where(['Annonces.id_gestionnaires'=>$gestId['G']['id']]);
        }
        $surf32->select(['nbr' => $surf32->func()->count('*')]);
        $aWhere32[] = ["Annonces.surface > 90"];
        $aWhere32[] = ["R.dbt_at >= '$dbtsemaine'", "R.dbt_at < '$finsemaine'"];
        $surf32->where($aWhere32);
        $surf32->group(['Annonces.id']);
        $nbrsurf32 = $surf32->count();

        $reservationstable = TableRegistry::get('Reservations');
        $were[] = ["Reservations.statut = 90"];
        $were[] = ["Reservations.dbt_at >= '$dbtsemaine'", "Reservations.dbt_at < '$finsemaine'"];
        $query = $reservationstable->find();
        $query->join([
                        'A' => [
                          'table' => 'annonces',
                          'type' => 'inner',
                          'conditions' => ['Reservations.annonce_id = A.id'],
                        ]
                      ]);
        if($get['station'] != 0){
          $query->join([
                          'L' => [
                            'table' => 'lieugeos',
                            'type' => 'inner',
                            'conditions' => ["A.lieugeo_id = L.id", "L.id = ".$get['station']],
                          ]
                        ]);
        }
        if($gestId['G']['role'] != 'admin'){
          $query->where(['A.id_gestionnaires'=>$gestId['G']['id']]);
        }
        $query->where($were);
        $query->select(['count' => $query->func()->sum('Reservations.nb_adultes')]);
        $nbradult = $query->first();

        $query2 = $reservationstable->find();
        $query2->join([
                        'A' => [
                          'table' => 'annonces',
                          'type' => 'inner',
                          'conditions' => ['Reservations.annonce_id = A.id'],
                        ]
                      ]);
        if($get['station'] != 0){
          $query2->join([
                          'L' => [
                            'table' => 'lieugeos',
                            'type' => 'inner',
                            'conditions' => ["A.lieugeo_id = L.id", "L.id = ".$get['station']],
                          ]
                        ]);
        }
        if($gestId['G']['role'] != 'admin'){
          $query2->where(['A.id_gestionnaires'=>$gestId['G']['id']]);
        }
        $query2->where($were);
        $query2->select(['count' => $query2->func()->sum('Reservations.nb_enfants')]);
        $nbrenfant = $query2->first();

        if($nbrressem->nbr==0) $nbrdult = 0;
        else $nbrdult = $nbradult->count ;

        if($nbrressem->nbr==0) $nbrenf = 0;
        else $nbrenf = $nbrenfant->count ;

        $row[0] = $dbtaffichage." - ".$finaffichage;
        $row[1] = $nbrressem->nbr;
        $row[2]= $nbrsurf12;
        $row[3]= $nbrsurf22;
        $row[4]= $nbrsurf32;
        $row[5]= $nbrdult;
        $row[6]= $nbrenf;
        $row[7]= ($nbrdult+$nbrenf);
        $output['aaData'][] = $row;

        $dbtsemaine = $finsemaine;
        $dbtaffichage = $finaffichage;
        $finsemaine = $finsem->modify('+7 day');
        $finaffichage = $finsemaine->i18nFormat('dd/MM/yyyy');
        $finsem = $finsemaine;
        $finsemaine = $finsemaine->i18nFormat('yyyy-MM-dd');
      }
      return  $output ;
    }
    /**
     *
     **/
    public function get_total_annonces_index($gest_id, $annee, $mois){
      $nbrAnn = $this->find();
      if($gest_id != NULL){
        $nbrAnn->where(['Annonces.id_gestionnaires'=>$gest_id]);
        // $nbrAnn->join([
        //       'AG' => [
        //           'table' => 'annoncegestionnaires',
        //           'type' => 'inner',
        //           'conditions' => ['AG.id_annonces=Annonces.id',"AG.id_gestionnaires"=>$gest_id],
        //         ]
        //     ]);
      }
      $nbrAnn->where('((Annonces.statut = 50 AND Annonces.contrat = 1 AND YEAR(Annonces.date_contrat) = "'.$annee.'" AND MONTH(Annonces.date_contrat)="'.$mois.'") OR (Annonces.statut = 50 AND Annonces.mise_relation = 1 AND YEAR(Annonces.date_mise_relation) = "'.$annee.'" AND MONTH(Annonces.date_mise_relation)="'.$mois.'"))');
      $nbrAnn->select(['nbr' => $nbrAnn->func()->count('*')]);
      $nbrAnn = $nbrAnn->first();
      return $nbrAnn;
    }
    /**
     * 
     */
    public function getAnnoncesInvalid($gest_id)
    {
      return $this->find()
                            ->join([
                                'L' => [
                                    'table' => 'lieugeos',
                                    'type' => 'inner',
                                    'conditions' => 'L.id=Annonces.lieugeo_id',
                                ],
                                'U' => [
                                    'table' => 'utilisateurs',
                                    'type' => 'inner',
                                    'conditions' => ['U.id=Annonces.proprietaire_id','Annonces.statut=0'],
                                ],
                                // 'G' => [
                                //         'table' => 'gestionnaires',
                                //         'type' => 'inner',
                                //         'conditions' => ['G.id'=>$gest_id]
                                // ],
                                // 'Village' => [
                                //   'table' => 'villages',
                                //   'type' => 'inner',
                                //   'conditions' => ['Village.id=Annonces.village']
                                // ],
                                // 'GV' => [
                                //   'table' => 'gestionnaires_villages',
                                //   'type' => 'inner',
                                //   'conditions' => ['GV.gestionnaire_id=G.id','Village.id=GV.villages_id']
                                // ],
                                'Contrat' => [
                                  'table' => 'contrats',
                                  'type' => 'inner',
                                  'conditions' => ['Contrat.annonce_id=Annonces.id','Contrat.visible'=>1]
                                ]
                            ])
                      ->where(['Annonces.id_gestionnaires'=>$gest_id])
                      ->select(['Annonces.id','Annonces.num_app','Annonces.created_at','Annonces.updated_at','U.prenom','U.nom_famille','U.email','L.name'])
                      ->order(['L.name']);
    }
    /**
     * 
     */
    public function getPropForContrat($idAnn,$email,$idGest)
    {
      $res2=$this->find()->join([
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'INNER',
          'conditions' => ['U.id=Annonces.proprietaire_id'],
        ],
        'R' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'Annonces.batiment=R.id',
        ],
        'V' => [
          'table' => 'villages',
          'type' => 'left',
          'conditions' => 'V.id=R.id_village',
        ],
        'L' => [
          'table' => 'lieugeos',
          'type' => 'inner',
          'conditions' => ['L.id=Annonces.lieugeo_id'],
        ],
        'G' => [
				  'table' => 'gestionnaires',
				  'type' => 'inner',
				  'conditions' => ['G.id'=>$idGest]
        ],
        'GV' => [
          'table' => 'gestionnaires_villages',
          'type' => 'inner',
          'conditions' => ['GV.gestionnaire_id=G.id','V.id=GV.villages_id']
        ],
        'Pays' => [
          'table' => 'pays',
          'type' => 'INNER',
          'conditions' => 'Pays.id_pays=Annonces.pays',
        ]
      ])
      ->select(['Annonces.id','Annonces.num_app','Annonces.surface','Annonces.code_postal','Annonces.pays','Annonces.ville','Annonces.region','Pays.code_pays','Pays.fr','R.name','V.name','L.name','U.ville',"U.id","U.prenom","U.nom_famille","U.adresse","U.adr2","U.portable","U.telephone","U.fax","U.portable2","U.telephone2","U.pays","U.code_postal"]);

      $res=$this->find()
      ->join([
        'U' => [
          'table' => 'utilisateurs',
          'type' => 'INNER',
          'conditions' => ['U.id=Annonces.proprietaire_id'],
        ],
        'R' => [
          'table' => 'residences',
          'type' => 'left',
          'conditions' => 'Annonces.batiment=R.id',
        ],
        'V' => [
          'table' => 'villages',
          'type' => 'left',
          'conditions' => 'V.id=R.id_village',
        ],
        'L' => [
          'table' => 'lieugeos',
          'type' => 'inner',
          'conditions' => ['L.id=Annonces.lieugeo_id'],
        ],
        'Pays' => [
          'table' => 'pays',
          'type' => 'INNER',
          'conditions' => 'Pays.id_pays=Annonces.pays',
        ]
      ])->where(['Annonces.id_gestionnaires'=>$idGest])
      ->select(['Annonces.id','Annonces.num_app','Annonces.surface','Annonces.code_postal','Annonces.pays','Annonces.ville','Annonces.region','Pays.code_pays','Pays.fr','R.name','V.name','L.name','U.ville',"U.id","U.prenom","U.nom_famille","U.adresse","U.adr2","U.portable","U.telephone","U.fax","U.portable2","U.telephone2","U.pays","U.code_postal"]);
      if($idAnn!=null){
        $res->where(['Annonces.id'=>$idAnn]);
        $res2->where(['Annonces.id'=>$idAnn]);
      }
      else{
        $res->where(['LOWER(U.email) LIKE '=>strtolower($email)]);
        $res2->where(['LOWER(U.email) LIKE '=>strtolower($email)]);
      }
      return $res->union($res2);
    }
  /**
   * 
   */
  public function getAllAnnonces($stationID=NULL, $nature=NULL, $villageID=NULL)
  {
    $ann=$this->find('all')->contain(['Lieugeos', 'Villages'])->where(["Annonces.statut"=>"50"]);
    if($stationID != NULL) $ann->where(["Annonces.lieugeo_id" => $stationID]);
    if($nature != NULL) $ann->where(["Annonces.nature" => $nature]);
    if($villageID != NULL) $ann->where(["Annonces.village" => $villageID]);
    return $ann;
  }
  /**
   * 
   */
  public function getAllAnnoncesWithPeriod($stationID=NULL, $nature=NULL, $villageID=NULL, $personnesNb=NULL)
  {
    $ann=$this->find('all')		
		->join([
			'dispo' => [
				'table' => 'dispos',
				'type' => 'inner',
				'conditions' => ['Annonces.id = dispo.annonce_id', 'dispo.statut = 0', 'dispo.fin_at > NOW()'],
			],
			'lieugeo' => [
				'table' => 'lieugeos',
				'type' => 'inner',
				'conditions' => ['Annonces.lieugeo_id = lieugeo.id'],
			],
			'village' => [
				'table' => 'villages',
				'type' => 'inner',
				'conditions' => ['village.id = Annonces.village'],
			],
			'Feedbacks' => [
				'table' => 'feedbacks',
				'type' => 'left',
				'conditions' => ['Annonces.id = Feedbacks.annonce_id', 'Feedbacks.activated = 1'],
			],
			'Ratings' => [
				'table' => 'ratings',
				'type' => 'left',
				'conditions' => ['Ratings.feedback_id = Feedbacks.id'],
			],
			'Utilisateurs' => [
				'table' => 'utilisateurs',
				'type' => 'left',
				'conditions' => ['Utilisateurs.id = Feedbacks.utilisateur_id'],
			]
		])
		->where(["Annonces.statut"=>"50"]);
    if($stationID != NULL) $ann->where(["Annonces.lieugeo_id" => $stationID]);
    if($nature != NULL) $ann->where(["Annonces.nature" => $nature]);
    if($villageID != NULL) $ann->where(["Annonces.village" => $villageID]);
    if($personnesNb != NULL) $ann->where(["Annonces.personnes_nb >=" => $personnesNb]);
		$ann->select(["Annonces.updated_at","dispo.prix_jour","village.name","lieugeo.name","lieugeo.nom_url","Annonces.village","Annonces.id","Annonces.titre","Annonces.surface","Annonces.vue","Annonces.kmstat_id","Annonces.lieugeo_id","Annonces.pieces_nb","Annonces.nature","Annonces.personnes_nb","Annonces.description","Annonces.wifi","Annonces.nb_etoiles","Annonces.batiment","Annonces.etage"]);
		$ann->select(["noteglobale"=>"IF(Utilisateurs.id IS NULL, 0,(SUM(Ratings.note)/COUNT(*)))"]);
		$ann->group(['Annonces.id']);
		$ann->order(['noteglobale DESC', 'Annonces.updated_at']);
    return $ann;
  }
  /**
   * 
   */
  public function getAllAnnoncesWithoutPeriod($stationID=NULL, $nature=NULL, $villageID=NULL, $personnesNb=NULL)
  {
    $ann=$this->find('all')		
		->join([
			'dispo' => [
				'table' => 'dispos',
				'type' => 'left',
				'conditions' => ['Annonces.id = dispo.annonce_id', 'dispo.statut = 0', 'dispo.fin_at > NOW()'],
			],
			'lieugeo' => [
				'table' => 'lieugeos',
				'type' => 'inner',
				'conditions' => ['Annonces.lieugeo_id = lieugeo.id'],
			],
			'village' => [
				'table' => 'villages',
				'type' => 'inner',
				'conditions' => ['village.id = Annonces.village'],
			],
			'Feedbacks' => [
				'table' => 'feedbacks',
				'type' => 'left',
				'conditions' => ['Annonces.id = Feedbacks.annonce_id', 'Feedbacks.activated = 1'],
			],
			'Ratings' => [
				'table' => 'ratings',
				'type' => 'left',
				'conditions' => ['Ratings.feedback_id = Feedbacks.id'],
			],
			'Utilisateurs' => [
				'table' => 'utilisateurs',
				'type' => 'left',
				'conditions' => ['Utilisateurs.id = Feedbacks.utilisateur_id'],
			]
		])
		->where(["Annonces.statut"=>"50", "dispo.id IS NULL"]);
    if($stationID != NULL) $ann->where(["Annonces.lieugeo_id" => $stationID]);
    if($nature != NULL) $ann->where(["Annonces.nature" => $nature]);
    if($villageID != NULL) $ann->where(["Annonces.village" => $villageID]);
    if($personnesNb != NULL) $ann->where(["Annonces.personnes_nb >=" => $personnesNb]);
		$ann->select(["Annonces.updated_at","dispo.prix_jour","village.name","lieugeo.name","lieugeo.nom_url","Annonces.village","Annonces.id","Annonces.titre","Annonces.surface","Annonces.vue","Annonces.kmstat_id","Annonces.lieugeo_id","Annonces.pieces_nb","Annonces.nature","Annonces.personnes_nb","Annonces.description","Annonces.wifi","Annonces.nb_etoiles","Annonces.batiment","Annonces.etage"]);
		$ann->select(["noteglobale"=>"IF(Utilisateurs.id IS NULL, 0,(SUM(Ratings.note)/COUNT(*)))"]);
		$ann->group(['Annonces.id']);
		$ann->order(['noteglobale DESC', 'Annonces.updated_at']);
    return $ann;
  }
  /**
   * 
   */
  public function getAllAnnoncesWithPeriodSavoie($stationID=NULL, $nbrPersonnes=NULL, $promos=NULL)
  {
    $ann=$this->find('all')		
		->join([
			'dispo' => [
				'table' => 'dispos',
				'type' => 'inner',
				'conditions' => ['Annonces.id = dispo.annonce_id', 'dispo.statut = 0', 'dispo.fin_at > NOW()'],
			],
			'lieugeo' => [
				'table' => 'lieugeos',
				'type' => 'inner',
				'conditions' => ['Annonces.lieugeo_id = lieugeo.id'],
			],
			'village' => [
				'table' => 'villages',
				'type' => 'inner',
				'conditions' => ['village.id = Annonces.village'],
			],
			'Feedbacks' => [
				'table' => 'feedbacks',
				'type' => 'left',
				'conditions' => ['Annonces.id = Feedbacks.annonce_id', 'Feedbacks.activated = 1'],
			],
			'Ratings' => [
				'table' => 'ratings',
				'type' => 'left',
				'conditions' => ['Ratings.feedback_id = Feedbacks.id'],
			],
			'Utilisateurs' => [
				'table' => 'utilisateurs',
				'type' => 'left',
				'conditions' => ['Utilisateurs.id = Feedbacks.utilisateur_id'],
			]
		])
		->where(["Annonces.statut"=>"50"]);
    if($stationID != NULL && !empty($stationID)) $ann->where(["Annonces.lieugeo_id IN ('".implode("','",$stationID)."')"]);
    if($nbrPersonnes != NULL && $nbrPersonnes==="famille") $ann->where(["(Annonces.personnes_nb >= 4 AND Annonces.personnes_nb <= 8)"]);
    if($nbrPersonnes != NULL && $nbrPersonnes==="groupe") $ann->where(["Annonces.personnes_nb >= 9"]);
    if($promos != NULL && $promos==="promos") $ann->where(["dispo.promo_yn = 1"]);
		$ann->select(["Annonces.updated_at","dispo.prix_jour","village.name","lieugeo.name","lieugeo.nom_url","Annonces.village","Annonces.id","Annonces.titre","Annonces.surface","Annonces.vue","Annonces.kmstat_id","Annonces.lieugeo_id","Annonces.pieces_nb","Annonces.nature","Annonces.personnes_nb","Annonces.description","Annonces.wifi","Annonces.nb_etoiles","Annonces.batiment","Annonces.etage"]);
		$ann->select(["noteglobale"=>"IF(Utilisateurs.id IS NULL, 0,(SUM(Ratings.note)/COUNT(*)))"]);
		$ann->group(['Annonces.id']);
		$ann->order(['noteglobale DESC', 'Annonces.updated_at']);
    return $ann;
  }
  /**
   * 
   */
  public function getAllAnnoncesWithoutPeriodSavoie($stationID=NULL, $nbrPersonnes=NULL, $promos=NULL)
  {
    $ann=$this->find('all')		
		->join([
			'dispo' => [
				'table' => 'dispos',
				'type' => 'left',
				'conditions' => ['Annonces.id = dispo.annonce_id', 'dispo.statut = 0', 'dispo.fin_at > NOW()'],
			],
			'lieugeo' => [
				'table' => 'lieugeos',
				'type' => 'inner',
				'conditions' => ['Annonces.lieugeo_id = lieugeo.id'],
			],
			'village' => [
				'table' => 'villages',
				'type' => 'inner',
				'conditions' => ['village.id = Annonces.village'],
			],
			'Feedbacks' => [
				'table' => 'feedbacks',
				'type' => 'left',
				'conditions' => ['Annonces.id = Feedbacks.annonce_id', 'Feedbacks.activated = 1'],
			],
			'Ratings' => [
				'table' => 'ratings',
				'type' => 'left',
				'conditions' => ['Ratings.feedback_id = Feedbacks.id'],
			],
			'Utilisateurs' => [
				'table' => 'utilisateurs',
				'type' => 'left',
				'conditions' => ['Utilisateurs.id = Feedbacks.utilisateur_id'],
			]
		])
		->where(["Annonces.statut"=>"50", "dispo.id IS NULL"]);
    if($stationID != NULL && !empty($stationID)) $ann->where(["Annonces.lieugeo_id IN ('".implode("','",$stationID)."')"]);
    if($nbrPersonnes != NULL && $nbrPersonnes==="famille") $ann->where(["(Annonces.personnes_nb >= 4 AND Annonces.personnes_nb <= 8)"]);
    if($nbrPersonnes != NULL && $nbrPersonnes==="groupe") $ann->where(["Annonces.personnes_nb >= 9"]);
    if($promos != NULL && $promos==="promos") $ann->where(["dispo.promo_yn = 1"]);
    $ann->select(["Annonces.updated_at","dispo.prix_jour","village.name","lieugeo.name","lieugeo.nom_url","Annonces.village","Annonces.id","Annonces.titre","Annonces.surface","Annonces.vue","Annonces.kmstat_id","Annonces.lieugeo_id","Annonces.pieces_nb","Annonces.nature","Annonces.personnes_nb","Annonces.description","Annonces.wifi","Annonces.nb_etoiles","Annonces.batiment","Annonces.etage"]);
		$ann->select(["noteglobale"=>"IF(Utilisateurs.id IS NULL, 0,(SUM(Ratings.note)/COUNT(*)))"]);
		$ann->group(['Annonces.id']);
		$ann->order(['noteglobale DESC', 'Annonces.updated_at']);
    return $ann;
  }
  /**
   * 
   */
  public function getAllAnnoncesSavoie($stationID=NULL, $nbrPersonnes=NULL)
  {
    $ann=$this->find('all')->contain(['Lieugeos', 'Villages'])->where(["Annonces.statut"=>"50"]);
    if($stationID != NULL && !empty($stationID)) $ann->where(["Annonces.lieugeo_id IN ('".implode("','",$stationID)."')"]);
    if($nbrPersonnes != NULL && $nbrPersonnes==="famille") $ann->where(["(Annonces.personnes_nb >= 4 AND Annonces.personnes_nb <= 8)"]);
    if($nbrPersonnes != NULL && $nbrPersonnes==="groupe") $ann->where(["Annonces.personnes_nb >= 9"]);
    return $ann;
  }

  public function getParkingTypes()
  {
    $parking_types_clean = [];
    $parking_types= $this->find()
        ->select(['stationnement'])
        ->distinct(['stationnement'])
        ->order(['stationnement ASC'])
        ->toArray();

    foreach($parking_types as $pt) {
      if(isset(self::PARKING_TYPES[$pt->stationnement])) {
        $parking_types_clean["{$pt->stationnement}"] = self::PARKING_TYPES[$pt->stationnement];
      }
    }
    return $parking_types_clean;
  }

  public function newEntity($data = null, array $options = [])
  {
    if(array_key_exists('wifi_appartment', $data) ||
      array_key_exists('wifi_gratuit', $data) ||
      array_key_exists('wifi_payant', $data)) {
        
        $wifi_appartment_mask = $wifi_gratuit_mask = $wifi_payant_mask = 0;

        $wifi_appartment = array_key_exists('wifi_appartment', $data)?$data['wifi_appartment']:0;
        if($wifi_appartment) {
          $wifi_appartment_mask = Annonce::WIFI_appartment; 
        }

        $wifi_gratuit = array_key_exists('wifi_gratuit', $data)?$data['wifi_gratuit']:0;
        if($wifi_gratuit) {
          $wifi_gratuit_mask = Annonce::WIFI_gratuit; 
        }

        $wifi_payant = array_key_exists('wifi_payant', $data)?$data['wifi_payant']:0;
        if($wifi_payant) {
          $wifi_payant_mask = Annonce::WIFI_payant; 
        }
        $data['wifi']= $wifi_appartment_mask | $wifi_gratuit_mask | $wifi_payant_mask;
        
        unset($data['wifi_appartment']);
        unset($data['wifi_gratuit']);
        unset($data['wifi_payant']);
		}
    return parent::newEntity($data, $options);
  } 
  
  public function patchEntity($anounceEntity, array $data, array $options = [])
  {
    if(array_key_exists('wifi_appartment', $data) ||
      array_key_exists('wifi_gratuit', $data) ||
      array_key_exists('wifi_payant', $data)) {
        
        $wifi_appartment_mask = $wifi_gratuit_mask = $wifi_payant_mask = 0;

        $wifi_appartment = array_key_exists('wifi_appartment', $data)?$data['wifi_appartment']:$anounceEntity->hasWifiAppartment();
        if($wifi_appartment) {
          $wifi_appartment_mask = Annonce::WIFI_appartment; 
        }

        $wifi_gratuit = array_key_exists('wifi_gratuit', $data)?$data['wifi_gratuit']:$anounceEntity->hasWifiResidence();
        if($wifi_gratuit) {
          $wifi_gratuit_mask = Annonce::WIFI_gratuit; 
        }

        $wifi_payant = array_key_exists('wifi_payant', $data)?$data['wifi_payant']:$anounceEntity->hasWifiAppartment();
        if($wifi_payant) {
          $wifi_payant_mask = Annonce::WIFI_payant; 
        }
        $data['wifi']= $wifi_appartment_mask | $wifi_gratuit_mask | $wifi_payant_mask;
        
        unset($data['wifi_appartment']);
        unset($data['wifi_gratuit']);
        unset($data['wifi_payant']);
		}
    return parent::patchEntity($anounceEntity,$data,$options );
  }

  public function getWifiAppartmentConst()
  {
    return Annonce::WIFI_appartment;
  }

  public function getWifiGratuitConst()
  {
    return Annonce::WIFI_gratuit;
  }

  public function getWifiPayantConst()
  {
    return Annonce::WIFI_payant;
  }
}
