<?php
namespace App\Model\Table;

use App\Model\Entity\Registre;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Registres Model
 *
 */
class RegistresTable extends Table
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

        $this->table('registres');
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
            ->requirePresence('app', 'create')
            ->notEmpty('app');

        $validator
            ->requirePresence('bra', 'create')
            ->notEmpty('bra');

        $validator
            ->requirePresence('cle', 'create')
            ->notEmpty('cle');

        $validator
            ->allowEmpty('val');

        $validator
            ->integer('cpt')
            ->allowEmpty('cpt');

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        return $validator;
    }
}
