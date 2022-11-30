<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AnneLieugeos Model
 *
 * @property \App\Model\Table\LieugeosTable|\Cake\ORM\Association\BelongsTo $Lieugeos
 *
 * @method \App\Model\Entity\AnneLieugeo get($primaryKey, $options = [])
 * @method \App\Model\Entity\AnneLieugeo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AnneLieugeo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AnneLieugeo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AnneLieugeo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AnneLieugeo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AnneLieugeo findOrCreate($search, callable $callback = null, $options = [])
 */
class AnneLieugeosTable extends Table
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

        $this->setTable('anne_lieugeos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('RemonteMecanique', [
            'foreignKey' => 'remonte_mecanique_id',
            'joinType' => 'INNER',
            'cascadeCallbacks' => true,
            'dependent' => true
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
            ->integer('anne')
            ->requirePresence('anne', 'create')
            ->notEmpty('anne');

        $validator
            ->integer('prixJourne')
            ->requirePresence('prixJourne', 'create')
            ->notEmpty('prixJourne');

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
        $rules->add($rules->existsIn(['remonte_mecanique_id'], 'RemonteMecanique'));

        return $rules;
    }

    public function getAnnesForRM($rmId){
        return $this->find()->where(['remonte_mecanique_id'=>$rmId])->order('anne');
    }
}
