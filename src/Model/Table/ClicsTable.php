<?php
namespace App\Model\Table;

use App\Model\Entity\Clic;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clics Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Annonces
 */
class ClicsTable extends Table
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

        $this->table('clics');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Annonces', [
            'foreignKey' => 'annonce_id',
            'joinType' => 'INNER'
        ]);
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
            ->date('clic_at')
            ->requirePresence('clic_at', 'create')
            ->notEmpty('clic_at');

        $validator
            ->integer('clic_nb')
            ->requirePresence('clic_nb', 'create')
            ->notEmpty('clic_nb');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['annonce_id'], 'Annonces'));
        return $rules;
    }
}
