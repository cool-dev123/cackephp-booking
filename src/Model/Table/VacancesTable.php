<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class VacancesTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('vacances'); // Name of the table in the database, if absent convention assumes lowercase version of file prefix
        $this->displayField('id'); // field or virtual field used for default display in associated models, if absent 'id' is assumed
        $this->primaryKey('id'); // Primary key field(s) in table, if absent convention assumes 'id' field

    }

    public function getListeVacances(){
      $stations = $this->find();
  		$stations->join([
  						'Pays' => [
  							'table' => 'pays',
  							'type' => 'inner',
  							'conditions' => ['Vacances.pays_id = Pays.id_pays'],
  						]])
  					->select(['Vacances.id','Vacances.dbt_vac','Vacances.fin_vac','Vacances.titre','Vacances.type','Vacances.zone_vac','Vacances.commentaire_vac','Vacances.zone_champ_vac','Pays.fr','Pays.code_pays'])
            ->order(['Vacances.dbt_vac'=>'asc']);
      return $stations;
    }

}
