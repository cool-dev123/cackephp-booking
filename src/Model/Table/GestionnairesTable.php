<?php
namespace App\Model\Table;

use App\Model\Entity\Gestionnaire;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Gestionnaires Model
 *
 */
class GestionnairesTable extends Table
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

        $this->table('gestionnaires');
        $this->displayField('name');
		$this->primaryKey('id');
		
		$this->belongsToMany('Villages', [
			'joinTable' => 'gestionnaires_villages',
			'foreignKey'=> 'gestionnaire_id',
			'targetForeignKey'=>'villages_id'
		]);
    }
	function getArrayContrat($url,$get){
		$aColumns = array( 'Gestionnaires.name', 'R.name', 'C.type', 'U.prenom','U.nom_famille','U.email', 'A.num_app' );
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
    $sWhere[0] = "MONTH(C.date_create)='".$get['from']."'";

		if(!empty($get['gestionnaire']))
			$sWhere[1]= "Gestionnaires.id=".$get['gestionnaire'];

		$gestion= $this->find();
    $gCount = $this->find();
			$gestion->join([
						// 'AG' => [
						// 	'table' => 'annoncegestionnaires',
						// 	'type' => 'inner',
						// 	'conditions' => 'Gestionnaires.id = AG.id_gestionnaires',
						// ],
						'A' => [
							'table' => 'annonces',
							'type' => 'INNER',
							'conditions' => ['Gestionnaires.id = A.id_gestionnaires', 'A.contrat = 1'],
						],
						'U' => [
							'table' => 'utilisateurs',
							'type' => 'inner',
							'conditions' => 'U.id=A.proprietaire_id',
						],
						'L' => [
							'table' => 'lieugeos',
							'type' => 'INNER',
							'conditions' => 'L.id=A.lieugeo_id',
						],
						// 'R' => [
						// 	'table' => 'residences',
						// 	'type' => 'left',
						// 	'conditions' => 'A.batiment=R.id',
						// ],
						// 'V' => [
						// 	'table' => 'villages',
						// 	'type' => 'left',
						// 	'conditions' => 'V.id=R.id_village',
						// ],
						'C' => [
							'table' => 'contrats',
							'type' => 'inner',
							'conditions' => ['A.id=C.annonce_id','C.payerGest=1'],
						]
						,
						'CT' => [
							'table' => 'contratypes',
							'type' => 'inner',
							'conditions' => ['CT.id=C.type','CT.id!=3'],
						]
						,
						'PC' => [
							'table' => 'prix_contrat',
							'type' => 'left',
							'conditions' => 'PC.contrat_id=C.id',
						]

					])
					->select(['PC.prix','PC.date_create','Gestionnaires.name','Gestionnaires.commission_maint','Gestionnaires.commission_sejour','Gestionnaires.commission_relation','A.id','A.num_app','U.prenom','U.nom_famille','U.email','L.name','CT.id','CT.type','C.date_create','C.id','C.prix','A.visible']);
			$gCount->join([
						// 'AG' => [
						// 	'table' => 'annoncegestionnaires',
						// 	'type' => 'inner',
						// 	'conditions' => 'Gestionnaires.id = AG.id_gestionnaires',
						// ],
						'A' => [
							'table' => 'annonces',
							'type' => 'INNER',
							'conditions' => ['Gestionnaires.id = A.id_gestionnaires', 'A.contrat = 1'],
						],
						'U' => [
							'table' => 'utilisateurs',
							'type' => 'inner',
							'conditions' => 'U.id=A.proprietaire_id',
						],
						'L' => [
							'table' => 'lieugeos',
							'type' => 'INNER',
							'conditions' => 'L.id=A.lieugeo_id',
						],
						// 'R' => [
						// 	'table' => 'residences',
						// 	'type' => 'left',
						// 	'conditions' => 'A.batiment=R.id',
						// ],
						// 'V' => [
						// 	'table' => 'villages',
						// 	'type' => 'left',
						// 	'conditions' => 'V.id=R.id_village',
						// ],
						'C' => [
							'table' => 'contrats',
							'type' => 'inner',
							'conditions' => ['A.id=C.annonce_id','C.payerGest=1'],
						]
						,
						'CT' => [
							'table' => 'contratypes',
							'type' => 'inner',
							'conditions' => 'CT.id=C.type',
						],
						'PC' => [
							'table' => 'prix_contrat',
							'type' => 'left',
							'conditions' => 'PC.contrat_id=C.id',
						]

					])
					->select(['nbr' => $gCount->func()->count('*')]);

			if(!empty($sWhere)){
				$gestion->where($sWhere);
				$gCount->where($sWhere);
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
      $i=0;
      foreach($gestion as $res)
      {
        $row = array();
        $row[0]=$res->name==null?'<span class="label label-warning">Sans Gestionnaire</span>':$res->name;
		$row[1]=$res['L']['name'];
		// $row[2]=$res['V']['name'];
		// $row[3]=$res['R']['name'];
		$row[2]=$res['A']['num_app'];
		$row[3]=$res['U']['prenom']." ".$res['U']['nom_famille'];
        $row[4]=$res['CT']['type'];
        $row[5]=$res['C']['prix'];
			//   switch($res['CT']['id']){
  			// 		case 1:
		$row[6]=(($res['C']['prix']*$res->commission_maint)/100);
  					// break;
  					// case 2:
  					// $row[6]=(($res['C']['prix']*$res->commission_sejour)/100);
  					// break;
  					// case 3:
  					// $row[6]=(($res['C']['prix']*$res->commission_relation)/100);
  					// break;
				//   }
		if($res['PC']['date_create'] != "") $row[7]=date("d-m-Y", strtotime($res['PC']['date_create']));
		else $row[7]="";		  
        $row[8]=date("d-m-Y", strtotime($res['C']['date_create']));
		if($res['AG']['visible']==1)
			$row[9]="<a href='javascript:void(0)' class=\"suspendu check-circle\" data-key='".$res['AG']['id']."' data-val='0' style=\"font-size: 20px; color:green;\"><i class=\"fa fa-check-circle\"></i></a>";
						else
			$row[9]="<a href='javascript:void(0)' class=\"suspendu exclamation-circle\" data-key='".$res['AG']['id']."' data-val='1' style=\"font-size: 20px; color:red;\"><i class=\"fa fa-exclamation-circle\"></i></a>";
		$output['aaData'][] = $row;
      }
    return  $output ;
	}
  /**
   *
   **/
    public function getNbSms(){
        $gestion= $this->find()
                        ->join([
                                'S' => [
                                  'table' => 'smsgestionnaires',
                                  'type' => 'inner',
                                  'conditions' => 'Gestionnaires.id=S.id_gestionnaire',
                                ]
			                  ])
                        ->select(['Gestionnaires.id','Gestionnaires.name','S.totalsms','S.id']);
        return $gestion;
    }
    /**
     *
     **/
    public function getEnvoyerSms($id){
        $gestion= $this->find();
        $gestion->join([
                      'SL' => [
                              'table' => 'smslocataires',
                              'type' => 'inner',
                              'conditions' => ['Gestionnaires.id=SL.gestionnaire',"Gestionnaires.id=$id"],
                      ]
		                ])
                  ->select(['nbr' => $gestion->func()->count('*')]);
        $count=$gestion->first();
        return $count['nbr'];
    }
}
