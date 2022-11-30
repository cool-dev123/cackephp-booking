<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MassifI18n Model
 *
 * @method \App\Model\Entity\MassifI18n get($primaryKey, $options = [])
 * @method \App\Model\Entity\MassifI18n newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MassifI18n[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MassifI18n|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MassifI18n patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MassifI18n[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MassifI18n findOrCreate($search, callable $callback = null, $options = [])
 */
class MassifI18nTable extends Table
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

        $this->setTable('massif_i18n');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('locale')
            ->maxLength('locale', 6)
            ->requirePresence('locale', 'create')
            ->notEmpty('locale');

        $validator
            ->scalar('model')
            ->maxLength('model', 255)
            ->requirePresence('model', 'create')
            ->notEmpty('model');

        $validator
            ->integer('foreign_key')
            ->requirePresence('foreign_key', 'create')
            ->notEmpty('foreign_key');

        $validator
            ->scalar('field')
            ->maxLength('field', 255)
            ->requirePresence('field', 'create')
            ->notEmpty('field');

        $validator
            ->scalar('content')
            ->allowEmpty('content');

        return $validator;
    }
}
