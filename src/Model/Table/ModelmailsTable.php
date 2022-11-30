<?php
namespace App\Model\Table;

use App\Model\Entity\Modelmail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Modelmails Model
 *
 */
class ModelmailsTable extends Table
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

        $this->table('modelmails');
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
            ->integer('id_gestionnaire')
            ->requirePresence('id_gestionnaire', 'create')
            ->notEmpty('id_gestionnaire');

        $validator
            ->requirePresence('titre', 'create')
            ->notEmpty('titre');

        $validator
            ->requirePresence('sujet', 'create')
            ->notEmpty('sujet');

        $validator
            ->requirePresence('txtmail', 'create')
            ->notEmpty('txtmail');

        return $validator;
    }
}
