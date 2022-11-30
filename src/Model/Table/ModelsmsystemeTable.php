<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Modelsmsysteme Model
 *
 * @method \App\Model\Entity\Modelsmsysteme get($primaryKey, $options = [])
 * @method \App\Model\Entity\Modelsmsysteme newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Modelsmsysteme[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Modelsmsysteme|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Modelsmsysteme patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Modelsmsysteme[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Modelsmsysteme findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ModelsmsystemeTable extends Table
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

        $this->setTable('modelsmsysteme');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('titre')
            ->maxLength('titre', 255)
            ->requirePresence('titre', 'create')
            ->notEmpty('titre');

        $validator
            ->scalar('txtsms')
            ->requirePresence('txtsms', 'create')
            ->notEmpty('txtsms');

        $validator
            ->scalar('indication')
            ->requirePresence('indication', 'create')
            ->notEmpty('indication');

        $validator
            ->scalar('destinataire')
            ->maxLength('destinataire', 255)
            ->requirePresence('destinataire', 'create')
            ->notEmpty('destinataire');

        $validator
            ->scalar('txtsmsEn')
            ->requirePresence('txtsmsEn', 'create')
            ->allowEmpty('txtsmsEn');

        return $validator;
    }
}
