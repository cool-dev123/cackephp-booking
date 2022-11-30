<?php
namespace App\Model\Table;

use App\Model\Entity\Residence;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;
use Cake\I18n\Date;
use \DateTime;
use Cake\ORM\TableRegistry;

/**
 * Residences Model
 *
 */
class ResidencesTable extends Table
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

        $this->setTable('residences');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('Bibliotheques', [
            'foreignKey' => 'bibliotheque_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Villages', [
            'foreignKey' => 'id_village',
            'joinType' => 'INNER'
        ]); 
 

    }

    function get_array_annonce($url,$get,$id)
    {
        $util = $this->find();
        $util->join([
            'A' => [
                    'table' => 'annonces',
                    'type' => 'inner',
                    'conditions' => ['A.batiment=Residences.id','A.id_gestionnaires'=>$id],
            ],
            'U' => [
                    'table' => 'utilisateurs',
                    'type' => 'inner',
                    'conditions' => 'U.id=A.proprietaire_id',
            ],
            'G' => [
              'table' => 'gestionnaires',
              'type' => 'inner',
              'conditions' => ['G.id'=>$id]
            ],
            'Village' => [
              'table' => 'villages',
              'type' => 'inner',
              'conditions' => ['Village.id=A.village']
            ],
            'GV' => [
              'table' => 'gestionnaires_villages',
              'type' => 'left',
              'conditions' => ['GV.gestionnaire_id=G.id','Village.id=GV.villages_id']
            ],
            'Contrat' => [
              'table' => 'contrats',
              'type' => 'inner',
              'conditions' => 'Contrat.annonce_id=A.id'
            ]
        ])
        ->select(['A.id','Residences.name','U.email','U.id','A.num_app','A.created_at','A.updated_at','U.prenom','U.nom_famille','A.contrat','A.mise_relation']);
			  
      $util->group(['A.id']);

      $output = array(
                  "data" => array()
                  );
      $i=0;
      foreach($util as $res)
      {
        //Liste Feedbacks
        $feedbacks = TableRegistry::get('Feedbacks');
        $listerating = $feedbacks->find()->contain(['Ratings','Utilisateurs'])->where(["annonce_id = ".$res['A']['id']]);
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
        $fin="";
        $row[0]=$res['A']['id'];

        $d = new Time(strtotime($res['A']['updated_at']));
        $row[1]=$d->i18nFormat('dd/MM/yyyy');

        $row[2]=$res->name;
				$row[3]=$res['A']['num_app'];
        $row[4]=$res['U']['email']."<button data-target=\"editProp-modal\" class=\"buton_add btn btn-primary btn-icon-anim btn-square btn-sm pull-right editProp\" data-annonce='".$res['A']['id']."' data-prop='".$res['U']['id']."' ><i class=\"fa fa-pencil\"></i></button>";
        $row[5]=$res['U']['nom_famille']." ".$res['U']['prenom'];
        $row[6]=$notationglobale;
        $row[7]="<center>"
                . "<a target=\"_blank\" href=\"".$url."annonces/edit/".$res['A']['id']."\"><button class=\"btn btn-sm btn-default btn-icon-anim btn-circle\"><i class=\"fa fa-pencil\"></i></button></a>"
                . "<a target=\"_blank\" href=\"".$url."annonces/view/".$res['A']['id']."\"><button class=\"btn btn-sm btn-warning btn-icon-anim btn-circle\"><i class=\"fa fa-search\"></i></button></a>"
                . "</center>";
        $output['data'][] = $row;
      }
    return  $output ;
  }

}
