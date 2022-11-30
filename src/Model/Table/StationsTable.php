<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class StationsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('stations'); // Name of the table in the database, if absent convention assumes lowercase version of file prefix
        $this->displayField('id'); // field or virtual field used for default display in associated models, if absent 'id' is assumed
        $this->primaryKey('id'); // Primary key field(s) in table, if absent convention assumes 'id' field
        
        $this->belongsTo('Lieugeos', [
            'foreignKey' => 'station_id',
            'joinType' => 'INNER'
        ]);
    }

    public function getListeStations($id_gest){
      $stations = $this->find();
  		$stations->join([
  						'Lieugeos' => [
  							'table' => 'lieugeos',
  							'type' => 'inner',
  							'conditions' => 'Stations.station_id = Lieugeos.id',
  						]]);
      if($id_gest!=null)
      $stations->join([
        'G' => [
          'table' => 'gestionnaires',
          'type' => 'inner',
          'conditions' => ['G.id'=>$id_gest],
        ],
        'Village' => [
          'table' => 'villages',
          'type' => 'inner',
          'conditions' => ['Lieugeos.id=Village.lieugeo_id']
        ],
        'GV' => [
          'table' => 'gestionnaires_villages',
          'type' => 'inner',
          'conditions' => ['GV.gestionnaire_id=G.id','Village.id=GV.villages_id']
        ],
      ]);
      $stations->select(['Stations.id', 'Stations.ouverture', 'Stations.fermeture', 'Lieugeos.name']);
      return $stations;
    }
}
