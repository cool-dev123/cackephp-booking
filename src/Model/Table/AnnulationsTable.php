<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Annulations Model
 *
 * @method \App\Model\Entity\Annulation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Annulation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Annulation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Annulation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Annulation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Annulation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Annulation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AnnulationsTable extends Table
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

        $this->setTable('annulations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Utilisateurs', [
			'joinTable' => 'utilisateurs_annulations',
            'foreignKey'=>'annulation_id',
            'targetForeignKey'=> 'utilisateur_id'
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('interval_1')
            ->requirePresence('interval_1', 'create')
            ->notEmpty('interval_1');

        $validator
            ->integer('interval_2')
            ->requirePresence('interval_2', 'create')
            ->notEmpty('interval_2');

        $validator
            ->integer('service_pourc')
            ->requirePresence('service_pourc', 'create')
            ->notEmpty('service_pourc');

        $validator
            ->integer('reservation_pourc')
            ->requirePresence('reservation_pourc', 'create')
            ->notEmpty('reservation_pourc');

        return $validator;
    }
}
