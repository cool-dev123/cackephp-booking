<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Reponsecontactprops Model
 *
 * @property \App\Model\Table\ContactpropsTable|\Cake\ORM\Association\BelongsTo $Contactprops
 *
 * @method \App\Model\Entity\Reponsecontactprop get($primaryKey, $options = [])
 * @method \App\Model\Entity\Reponsecontactprop newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Reponsecontactprop[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reponsecontactprop|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reponsecontactprop patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Reponsecontactprop[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reponsecontactprop findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReponsecontactpropsTable extends Table
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

        $this->setTable('reponsecontactprops');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Contactprops', [
            'foreignKey' => 'contactprops_id',
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
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmpty('message');

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
        $rules->add($rules->existsIn(['contactprops_id'], 'Contactprops'));

        return $rules;
    }
}
