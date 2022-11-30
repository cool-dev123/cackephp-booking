<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Urlmultilingue Model
 *
 * @method \App\Model\Entity\Urlmultilingue get($primaryKey, $options = [])
 * @method \App\Model\Entity\Urlmultilingue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Urlmultilingue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Urlmultilingue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Urlmultilingue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Urlmultilingue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Urlmultilingue findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UrlmultilingueTable extends Table
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

        $this->setTable('urlmultilingue');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Translate', [
            'fields' => ['name_value'],
            'translationTable' => 'UrlmultilingueI18n'
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
            ->scalar('name_key')
            ->maxLength('name_key', 255)
            ->requirePresence('name_key', 'create')
            ->notEmpty('name_key');

        $validator
            ->scalar('name_value')
            ->maxLength('name_value', 255)
            ->requirePresence('name_value', 'create')
            ->notEmpty('name_value');

        return $validator;
    }
}
