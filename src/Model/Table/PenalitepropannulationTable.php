<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Penalitepropannulation Model
 *
 * @property \App\Model\Table\UtilisateursTable|\Cake\ORM\Association\BelongsTo $Utilisateurs
 *
 * @method \App\Model\Entity\Penalitepropannulation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Penalitepropannulation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Penalitepropannulation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Penalitepropannulation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Penalitepropannulation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Penalitepropannulation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Penalitepropannulation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PenalitepropannulationTable extends Table
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

        $this->setTable('penalitepropannulation');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Utilisateurs', [
            'foreignKey' => 'utilisateur_id',
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
            ->integer('nbr_penalite')
            ->requirePresence('nbr_penalite', 'create')
            ->notEmpty('nbr_penalite');

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
        $rules->add($rules->existsIn(['utilisateur_id'], 'Utilisateurs'));

        return $rules;
    }
}
