<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ReductionsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('reductions'); // Name of the table in the database, if absent convention assumes lowercase version of file prefix
        $this->displayField('id'); // field or virtual field used for default display in associated models, if absent 'id' is assumed
        $this->primaryKey('id'); // Primary key field(s) in table, if absent convention assumes 'id' field

    }
    /**
     *
     **/
    public function arraycodesreductions($gest_id){
       $codes = $this->find()->where("Reductions.gestionnaire_id = ".$gest_id);
       return $codes;
    }
    /**
     *
     **/
    public function arraycodesreductionsadmin(){
      $codes = $this->find()
      ->join([
        'G'=> [
          'table' => 'gestionnaires',
          'type' => 'inner',
          'conditions' => ['G.id=Reductions.gestionnaire_id'],
        ],
      ])
      ->select(['Reductions.id', 'Reductions.fin_validite', 'Reductions.dbt_validite', 'Reductions.code_reduction', 'Reductions.valeur', 'G.name']);
      return $codes;
    }
    /**
     *
     **/
    public function existecodereservation($datedbt, $datefin, $ann_id){
      $codes = $this->find()->join([
        // 'AN' => [
        //   'table' => 'annoncegestionnaires',
        //   'type' => 'inner',
        //   'conditions' => ['AN.id_annonces='.$ann_id,'AN.visible=1'],
        // ],
        'A' => [
          'table' => 'annonces',
          'type' => 'inner',
          'conditions' => ['A.id'=>$ann_id,'A.visible=1'],
        ],
        'G' => [
          'table' => 'gestionnaires',
          'type' => 'INNER',
          'conditions' => ['G.id=A.id_gestionnaires', 'Reductions.gestionnaire_id=G.id'],
        ]
      ])
      ->where(
        [
            'OR' => [["Reductions.fin_validite > '$datedbt'","Reductions.fin_validite <= '$datefin'"], ["Reductions.dbt_validite >= '$datedbt'", "Reductions.fin_validite <= '$datefin'"], ["Reductions.dbt_validite > '$datedbt'","Reductions.dbt_validite < '$datefin'"], ["Reductions.dbt_validite <= '$datedbt'","Reductions.fin_validite > '$datefin'"]],
        ]
      );
      return $codes;
    }
}
