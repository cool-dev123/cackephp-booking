<?php
namespace App\Model\Table;

use App\Model\Entity\Arrivee;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Arrivees Model
 *
 */
class ArriveesTable extends Table
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

        $this->table('arrivees');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->integer('id_reservation')
            ->requirePresence('id_reservation', 'create')
            ->notEmpty('id_reservation');

        $validator
            ->integer('id_gestionnaire')
            ->requirePresence('id_gestionnaire', 'create')
            ->notEmpty('id_gestionnaire');

        $validator
            ->dateTime('d_create')
            ->requirePresence('d_create', 'create')
            ->notEmpty('d_create');

        return $validator;
    }
}
