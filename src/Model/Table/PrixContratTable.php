<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PrixContrat Model
 *
 * @property \App\Model\Table\ContratsTable|\Cake\ORM\Association\BelongsTo $Contrats
 *
 * @method \App\Model\Entity\PrixContrat get($primaryKey, $options = [])
 * @method \App\Model\Entity\PrixContrat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PrixContrat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PrixContrat|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PrixContrat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PrixContrat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PrixContrat findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PrixContratTable extends Table
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

        $this->setTable('prix_contrat');
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
            ->numeric('prix')
            ->requirePresence('prix', 'create')
            ->notEmpty('prix');

        $validator
            ->date('date_create')
            ->requirePresence('date_create', 'create')
            ->notEmpty('date_create');

        return $validator;
    }

}
