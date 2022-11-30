<?php
namespace App\Model\Table;

use App\Model\Entity\Contactprop;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;
/**
 * Contactprops Model
 *
 */
class ContactpropsTable extends Table
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
        $this->table('contactprops');
        $this->displayField('id');
        $this->primaryKey('id');
    }
    /**
     *
     **/
    function get_array_prop($url,$get){
			$rResult = $this->find();
                        
                        if(isset($get['limit']) && $get['limit'] != "")
                        $rResult->limit(10);
      $rResult->where(['Contactprops.parent_id = 0']);         
			$rResult->select(["Contactprops.id","Contactprops.id_annonce","Contactprops.nom","Contactprops.prenom","Contactprops.telephone","Contactprops.email","Contactprops.demande","Contactprops.date_insert"]);

			$output = array(
                      "sEcho" => intval($get['sEcho']),
                      "data" => array()
                      );

      foreach($rResult as $res)
        {
            $row = array();
            $row[0]=$res->id_annonce;
      			if(!empty($res->date_insert))
      				$row[1]=$res->date_insert->i18nFormat('dd-MM-yyyy H:m:s');
      			else
      				$row[1]=$res->date_insert;
			      $row[2]=$res->prenom." ".$res->nom;
            $row[3]=$res->telephone;
            $row[4]=$res->email;
            $row[5]=$res->demande;
            if(isset($get['limit']) && $get['limit'] != "")
                $row[6]='<i data-key="'.$res->id.'" data-toggle="modal" data-target="#myModal" class="fa fa-search pointer txt-warning view_contactProp" aria-hidden="true"></i>';
            else
            $row[6]="<div class='center'><button data-key=\"".$res->id."\" data-toggle=\"modal\" data-target=\"#myModal\" class=\"btn btn-sm btn-warning btn-icon-anim btn-circle view_station\"><i class=\"fa fa-search\"></i></button></div>";
            $output['data'][] = $row;
        }
    return  $output ;
	}
  /**
   *
   **/
  function get_array_prop_gestionnaire($url,$get,$id){
    $rResult = $this->find();
    $utilCount = $this->find();
    
    $rResult->join([
      'Annonce' => [
        'table' => 'annonces',
        'type' => 'inner',
        'conditions' => ['Contactprops.id_annonce=Annonce.id','Annonce.id_gestionnaires'=>$id],
      ],
      'Contrat' => [
        'table' => 'contrats',
        'type' => 'inner',
        'conditions' => ['Contrat.annonce_id=Annonce.id','Contrat.visible'=>1]
      ],
      'Village' => [
        'table' => 'villages',
        'type' => 'inner',
        'conditions' => ['Village.id=Annonce.village']
      ],
      // 'G' => [
      //     'table' => 'gestionnaires',
      //     'type' => 'inner',
      //     'conditions' => ['G.id'=>$id]
      // ],
      // 'GV' => [
      //   'table' => 'gestionnaires_villages',
      //   'type' => 'inner',
      //   'conditions' => ['GV.gestionnaire_id=G.id','Village.id=GV.villages_id']
      // ],
    ]);

    $utilCount->join([
      'Annonce' => [
        'table' => 'annonces',
        'type' => 'inner',
        'conditions' => ['Contactprops.id_annonce=Annonce.id','Annonce.id_gestionnaires'=>$id],
      ],
      'Contrat' => [
        'table' => 'contrats',
        'type' => 'inner',
        'conditions' => ['Contrat.annonce_id=Annonce.id','Contrat.visible'=>1]
      ],
      'Village' => [
        'table' => 'villages',
        'type' => 'inner',
        'conditions' => ['Village.id=Annonce.village']
      ],
      // 'G' => [
      //     'table' => 'gestionnaires',
      //     'type' => 'inner',
      //     'conditions' => ['G.id'=>$id]
      // ],
      // 'GV' => [
      //   'table' => 'gestionnaires_villages',
      //   'type' => 'inner',
      //   'conditions' => ['GV.gestionnaire_id=G.id','Village.id=GV.villages_id']
      // ],
    ]);

    if(isset($get['limit']) && $get['limit'] != "")
    $rResult->limit(10);
    
    // $utilCount->join([
    //   'AG' => [
    //           'table' => 'annoncegestionnaires',
    //           'type' => 'inner',
    //           'conditions' => ["Contactprops.id_annonce=AG.id_annonces","AG.id_gestionnaires='".$id."'"],
    //   ]
    // ]);
    $utilCount->where(['Contactprops.parent_id = 0']);  
    $rResult->where(['Contactprops.parent_id = 0']);
    $rResult->select(["Contactprops.id","Contactprops.id_annonce","Contactprops.nom","Contactprops.prenom","Contactprops.telephone","Contactprops.email","Contactprops.demande","Contactprops.date_insert"]);
    $utilCount->select(['nbr' => $utilCount->func()->count('*')]);
    if(!empty($orWhere)){
      $rResult->where([$awhere,"OR"=>$orWhere]);
      $utilCount->where([$awhere,"OR"=>$orWhere]);
    }
    $start=1;
    if($get['iDisplayStart']>0){
      $start=($get['iDisplayStart']/$get['iDisplayLength'])+1;
    }
    $rResult->order($sOrder);

    $count=$utilCount->first();
    $output = array(
                  "data" => array()
                  );

    foreach($rResult as $res)
    {
        $row = array();
        $img="";
        $fin="";
        $row[0]=$res->id_annonce;
        if(!empty($res->date_insert))
          $row[1]=$res->date_insert->i18nFormat('dd-MM-yyyy H:m:s');
        else
          $row[1]=$res->date_insert;
        $row[2]=$res->prenom." ".$res->nom;
        $row[3]=$res->telephone;
        $row[4]=$res->email;
        $row[5]=$res->demande;
        if(isset($get['limit']) && $get['limit'] != "")
            $row[6]='<i data-key="'.$res->id.'" data-toggle="modal" data-target="#myModal" class="fa fa-search pointer txt-warning view_contactProp" aria-hidden="true"></i>';
        else
        $row[6]="<div class='text-cneter'><button data-key=\"".$res->id."\" data-toggle=\"modal\" data-target=\"#myModal\" class=\"btn btn-sm btn-warning btn-icon-anim btn-circle view_station\"><i class=\"fa fa-search\"></i></button></div>";
        $output['data'][] = $row;
    }
  return  $output ;
}
  /**
   *
   **/
	function getArrayMessageProp($id_prop,$search){
		$sWhere = "";
		$aColumns = array( 'L.name','R.name','M.nom','M.prenom', 'M.demande' );
		if ( isset($search) && $search != "" )
		{
				$sWhere = "WHERE (";
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
						$sWhere .= "".$aColumns[$i]." LIKE '%". $search."%' OR ";
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';
		}
		$rResult = $this->find();
		$rResult->join([
						'A' => [
							'table' => 'annonces',
							'type' => 'inner',
							'conditions' => 'A.id=Contactprops.id_annonce',
						],
						'R' => [
							'table' => 'residences',
							'type' => 'left',
							'conditions' => 'A.batiment=R.id',
						],
						'L' => [
							'table' => 'lieugeos',
							'type' => 'left',
							'conditions' => 'L.id=A.lieugeo_id',
						]
					])
					->select(["Contactprops.id","Contactprops.id_annonce","Contactprops.nom","Contactprops.prenom","Contactprops.telephone","Contactprops.email","Contactprops.demande","Contactprops.date_insert","A.titre","R.name","L.name"]);
		$rResult->where([$awhere]);
		$rResult->order(["Contactprops.date_insert desc"]);
		return $rResult;
	}
}
