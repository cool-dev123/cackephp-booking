<?php
namespace App\Model\Table;

use App\Model\Entity\Pay;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pays Model
 *
 */
class PaysTable extends Table
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

        $this->table('pays');
        $this->displayField('id_pays');
        $this->primaryKey('id_pays');
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
            ->integer('id_pays')
            ->allowEmpty('id_pays', 'create');

        $validator
            ->requirePresence('code_pays', 'create')
            ->notEmpty('code_pays');

        $validator
            ->requirePresence('fr', 'create')
            ->notEmpty('fr');

        $validator
            ->requirePresence('en', 'create')
            ->notEmpty('en');

        return $validator;
    }
}
