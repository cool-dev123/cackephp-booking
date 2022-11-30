<?php
namespace App\Model\Table;

use App\Model\Entity\Contrat;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Contrats Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Annonces
 */
class ContratsTable extends Table
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

        $this->table('contrats');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Annonces', [
            'foreignKey' => 'annonce_id',
            'joinType' => 'INNER'
        ]);
    }

	function get_array_contrat_admin($url,$get){

		$annoncesTab = TableRegistry::get('Annonces');
		$gestion = $annoncesTab->find();
		$gCount = $annoncesTab->find();
   
		$gestion->join([
			'C' => [
				'table' => 'contrats',
				'type' => 'inner',
				'conditions' => ['C.annonce_id=Annonces.id','C.visible'=>1],
			],
			'U' => [
				'table' => 'utilisateurs',
				'type' => 'inner',
				'conditions' => 'U.id=Annonces.proprietaire_id',
			],
			// 'AG' => [
			// 	'table' => 'annoncegestionnaires',
			// 	'type' => 'left',
			// 	'conditions' => 'AG.id_annonces=Annonces.id',
			// ],
			'G' => [
				'table' => 'gestionnaires',
				'type' => 'left',
				'conditions' => ['Annonces.id_gestionnaires=G.id']
			],
			'CT' => [
				'table' => 'contratypes',
				'type' => 'left',
				'conditions' => 'CT.id=C.type',
			]
   
		])
		->select(['G.name','Annonces.id','Annonces.num_app','Annonces.id_filemaker','Annonces.contrat','Annonces.mise_relation','U.id','U.prenom','U.nom_famille','U.email','CT.type','C.date_create','C.id']);
   
   
		$gCount->join([
			'C' => [
				'table' => 'contrats',
				'type' => 'inner',
				'conditions' => ['C.annonce_id=Annonces.id','C.visible'=>1],
			],
			'U' => [
				'table' => 'utilisateurs',
				'type' => 'inner',
				'conditions' => 'U.id=Annonces.proprietaire_id',
			],
			// 'AG' => [
			// 	'table' => 'annoncegestionnaires',
			// 	'type' => 'left',
			// 	'conditions' => 'AG.id_annonces=Annonces.id',
			// ],
			'G' => [
				'table' => 'gestionnaires',
				'type' => 'left',
				'conditions' => ['Annonces.id_gestionnaires=G.id']
			],
			'CT' => [
				'table' => 'contratypes',
				'type' => 'left',
				'conditions' => 'CT.id=C.type',
			]
		])->select(['nbr' => $gCount->func()->count('*')]);
   
   
		/*$gestion= $this->find();
		$gCount = $this->find();
			$gestion->join([
						'A' => [
							'table' => 'annonces',
							'type' => 'inner',
							'conditions' => ['A.id=Contrats.annonce_id','Contrats.visible'=>1, 'A.contrat = 1'],
						],
						'U' => [
							'table' => 'utilisateurs',
							'type' => 'inner',
							'conditions' => 'U.id=A.proprietaire_id',
						],
						// 'AG' => [
						// 	'table' => 'annoncegestionnaires',
						// 	'type' => 'left',
						// 	'conditions' => 'AG.id_annonces=A.id',
						// ],
						'G' => [
							'table' => 'gestionnaires',
							'type' => 'left',
							'conditions' => ['A.id_gestionnaires=G.id']
						],
						'CT' => [
							'table' => 'contratypes',
							'type' => 'inner',
							'conditions' => 'CT.id=Contrats.type',
						],
						'R' => [
							'table' => 'residences',
							'type' => 'left',
							'conditions' => 'A.batiment=R.id',
						]
					])
					->select(['G.name','A.id','A.num_app','U.id','U.prenom','U.nom_famille','U.email','CT.type','Contrats.date_create','Contrats.id','R.name']);
			$gCount->join([
						'A' => [
							'table' => 'annonces',
							'type' => 'inner',
							'conditions' => ['A.id=Contrats.annonce_id','Contrats.visible'=>1, 'A.contrat = 1'],
						],
						'U' => [
							'table' => 'utilisateurs',
							'type' => 'inner',
							'conditions' => 'U.id=A.proprietaire_id',
						],
						// 'AG' => [
						// 	'table' => 'annoncegestionnaires',
						// 	'type' => 'left',
						// 	'conditions' => 'AG.id_annonces=A.id',
						// ],
						'G' => [
							'table' => 'gestionnaires',
							'type' => 'left',
							'conditions' => ['A.id_gestionnaires=G.id']
						],
						'CT' => [
							'table' => 'contratypes',
							'type' => 'inner',
							'conditions' => 'CT.id=Contrats.type',
						],
						'R' => [
							'table' => 'residences',
							'type' => 'left',
							'conditions' => 'A.batiment=R.id',
						]

					])
			->select(['nbr' => $gCount->func()->count('*')]);*/
			$gestion->where(['Annonces.statut != 40']);
			$gCount->where(['Annonces.statut != 40']);
			$count=$gCount->first();
		  	$output = array(
					"sEcho" => intval($get['sEcho']),
					"iTotalRecords" => $count["nbr"],
					"iTotalDisplayRecords" => $count["nbr"],
					"aaData" => array(),
					);
   
			foreach($gestion as $res)
			{
			  $row = array();
			  $row[0]=$res->id;
			  $row[1]=$res['G']['name']==null || $res['G']['name']==""?'<span class="label label-warning">Sans Gestionnaire</span>':$res['G']['name'];
			  $row[2]=$res['U']['prenom']." ".$res['U']['nom_famille'];
			  $row[3]=$res['U']['email'];
			  $row[4]=$res->id_filemaker;
			  if($res->contrat){
				$fin="<a onclick='activate(\"".$res->id."\")' class=\"check-circle\" style='cursor:pointer' id='coeur_".$res->id."'><i class=\"fa fa-check-circle\"></i></a>";
			  }else{
				$fin="<a onclick='activate(\"".$res->id."\")' class=\"exclamation-circle\" style='cursor:pointer' id='coeur_".$res->id."'><i class=\"fa fa-exclamation-circle\"></i></a>";
			  }
			  $row[5]=$fin;
			  if($res->mise_relation){
				$fin2="<a onclick='activate_relation(\"".$res->id."\")' class=\"check-circle\" style='cursor:pointer' id='coeur_re_".$res->id."'><i class=\"fa fa-check-circle\"></i></a>";
			  }else{
				$fin2="<a onclick='activate_relation(\"".$res->id."\")' class=\"exclamation-circle\" style='cursor:pointer' id='coeur_re_".$res->id."'><i class=\"fa fa-exclamation-circle\"></i></a>";
			  }
			  $row[6]=$fin2;
			  //$row[6]=$res->date_create->i18nFormat('dd-MM-yyyy');
			  if(isset($res['C']['id'])){
				$row[7]="<div class='text-center'>"
				   ."<button class=\"btn btn-sm btn-info btn-icon-anim btn-circle delete_station\" data-name=\"".$res['U']['prenom']." ".$res['U']['nom_famille']."\" data-key=\"".$res['C']['id']."\" ><i class=\"icon-trash\"></i></button>"
				   .'</div>';
				$row[8]="<div class='text-center'><button class=\"btn btn-sm btn-info btn-icon-anim btn-circle archive_station\" data-name=\"".$res['U']['prenom']." ".$res['U']['nom_famille']."\" data-key=\"".$res['C']['id']."\" ><i class=\"fa fa-archive\"></i></button></div>";
			  }else{
				$row[7]="";
				$row[8]="";
			  }
   
			  $output['aaData'][] = $row;
			}
		  return  $output ;
	   }
   /**
    *
    **/
	function get_array_contrat($id,$url,$get){
		$gestion= $this->find();
		$gCount = $this->find();
		$gestion->join([
			'A' => [
				'table' => 'annonces',
				'type' => 'inner',
				'conditions' => ['A.id=Contrats.annonce_id','Contrats.visible'=>1,'A.id_gestionnaires'=>$id]
			],
			'U' => [
				'table' => 'utilisateurs',
				'type' => 'inner',
				'conditions' => 'U.id=A.proprietaire_id',
			],
			// 'AG' => [
			// 	'table' => 'annoncegestionnaires',
			// 	'type' => 'inner',
			// 	'conditions' => ['AG.id_annonces=A.id',"AG.id_gestionnaires=$id"],
			// ],
			'CT' => [
				'table' => 'contratypes',
				'type' => 'inner',
				'conditions' => 'CT.id=Contrats.type',
			],
			'R' => [
				'table' => 'residences',
				'type' => 'left',
				'conditions' => 'A.batiment=R.id',
			]

		])
			->select(['A.id','A.num_app','A.contrat','U.id','U.prenom','U.nom_famille','U.email','CT.type','Contrats.date_create','Contrats.id','R.name']);
		$gCount->join([
			'A' => [
				'table' => 'annonces',
				'type' => 'inner',
				'conditions' => ['A.id=Contrats.annonce_id','Contrats.visible'=>1,'A.id_gestionnaires'=>$id]
			],
			'U' => [
				'table' => 'utilisateurs',
				'type' => 'inner',
				'conditions' => 'U.id=A.proprietaire_id',
			],
			// 'AG' => [
			// 	'table' => 'annoncegestionnaires',
			// 	'type' => 'inner',
			// 	'conditions' => ['AG.id_annonces=A.id',"AG.id_gestionnaires=$id"],
			// ],
			'CT' => [
				'table' => 'contratypes',
				'type' => 'inner',
				'conditions' => 'CT.id=Contrats.type',
			],
			'R' => [
				'table' => 'residences',
				'type' => 'left',
				'conditions' => 'A.batiment=R.id',
			]
		])
		->select(['nbr' => $gCount->func()->count('*')]);

		
		$count=$gCount->first();
		$output = array(
			"iTotalRecords" => $count["nbr"],
			"iTotalDisplayRecords" => $count["nbr"],
			"data" => array()
		);
		foreach($gestion as $res)
		{
			$row = array();
			$row[0]=$res['CT']['type'];
                        $row[1]=$res['U']['id'];
                        $row[2]=$res['U']['email'];
                        $row[3]=html_entity_decode($res['U']['prenom']." ".$res['U']['nom_famille']);
                        $row[4]=$res['A']['id'];
			$row[5]=$res['A']['num_app'];
			$row[6]=$res['R']['name'];
			$row[7]=$res->date_create->i18nFormat('dd/MM/yyyy');
                        if($res['A']['contrat']){
                        //   $fin="<a id='coeur_".$res['A']['id']."' alt='desactiver' style='cursor:pointer' onclick='activate(\"".$res['A']['id']."\")' class=\"check-circle\" href=\"#\"><i class=\"fa fa-check-circle\"></i></a>";
                          $fin="<i class=\"fa fa-check-circle check-circle\"></i><span style='display:none'>1</span>";
                        }else{
                        //   $fin="<a id='coeur_".$res['A']['id']."' alt='activer' style='cursor:pointer' onclick='activate(\"".$res['A']['id']."\")' class=\"exclamation-circle\" href=\"#\"><i class=\"fa fa-exclamation-circle\"></i></a>";
                          $fin="<i class=\"fa fa-exclamation-circle exclamation-circle\"></i><span style='display:none'>0</span>";
                        }
                        $row[8]=$fin;
			$row[9]="<center>"
				. "<button class=\"btn btn-sm btn-info btn-icon-anim btn-circle delete_station\" data-name='".$res['U']['prenom']." ".$res['U']['nom_famille']."' data-key=\"$res->id\" ><i class=\"icon-trash\"></i></button>";
			if(!$res['A']['contrat']) $row[9] .= "<button onclick=\"location.href='".$url."manager/arrivees/editcontrat/".$res->id."';\" class=\"btn btn-sm btn-default btn-icon-anim btn-circle\"><i class=\"fa fa-pencil\"></i></button>";
				$row[9] .= "<button class=\"btn btn-sm btn-info btn-icon-anim btn-circle archive_station\" data-name='".$res['U']['prenom']." ".$res['U']['nom_famille']."' data-key=\"$res->id\" ><i class=\"fa fa-archive\"></i></button>";
			$row[9] .= "<button onclick=\"window.open('".$url."manager/arrivees/viewpdfcontrat/".$res->id."');\" class=\"btn btn-sm btn-default btn-icon-anim btn-circle\"><i class=\"fa fa-file-pdf-o\"></i></button>";
			// if(!$res['A']['contrat']) $row[9] .= "<button onclick=\"window.open('".$url."contrat/CT_".$res['U']['id']."_".$res['A']['id'].".pdf');\" class=\"btn btn-sm btn-default btn-icon-anim btn-circle\"><i class=\"fa fa-file-pdf-o\"></i></button>";

			$row[9] .= "</center>";
			$output['aaData'][] = $row;
		}
		return  $output ;
	}
}
