<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WebcamLieugeos Model
 *
 * @property \App\Model\Table\LieugeosTable|\Cake\ORM\Association\BelongsTo $Lieugeos
 *
 * @method \App\Model\Entity\WebcamLieugeo get($primaryKey, $options = [])
 * @method \App\Model\Entity\WebcamLieugeo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WebcamLieugeo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WebcamLieugeo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WebcamLieugeo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WebcamLieugeo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WebcamLieugeo findOrCreate($search, callable $callback = null, $options = [])
 */
class WebcamLieugeosTable extends Table
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

        $this->setTable('webcam_lieugeos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Lieugeos', [
            'foreignKey' => 'lieugeo_id',
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
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        $validator
            ->url('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmpty('url')
            ->add('url', [
                'unique' => [
                   'rule' => 'validateUnique',
                   'provider' => 'table',
                   'message' => 'Ce url existe.']
                ]);

        $validator
            ->boolean('etat')
            ->requirePresence('etat', 'create')
            ->notEmpty('etat');

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
        $rules->add($rules->existsIn(['lieugeo_id'], 'Lieugeos'));

        return $rules;
    }
}
