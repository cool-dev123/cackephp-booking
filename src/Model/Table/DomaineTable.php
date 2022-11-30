<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Domaine Model
 *
 * @method \App\Model\Entity\Domaine get($primaryKey, $options = [])
 * @method \App\Model\Entity\Domaine newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Domaine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Domaine|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Domaine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Domaine[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Domaine findOrCreate($search, callable $callback = null, $options = [])
 */
class DomaineTable extends Table
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

        $this->setTable('domaine');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Massif', [
            'foreignKey' => 'massif_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('Lieugeos', [
            'foreignKey' => 'domaine_id'
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
            ->notEmpty('nom')
            ->add('nom', [
                'unique' => [
                   'rule' => 'validateUnique',
                   'provider' => 'table',
                   'message' => 'Ce domaine existe.']
                ]);

        $validator
            ->scalar('desc')
            ->allowEmpty('descreption');

        // $validator
        //     ->url('url')
        //     ->maxLength('url', 255)
        //     ->allowEmpty('url');

        // $validator
        //     ->integer('massif_id')
        //     ->requirePresence('massif_id')
        //     ->notEmpty('massif_id');
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
        $rules->add($rules->existsIn(['massif_id'], 'Massif'));
        return $rules;
    }
    function beforeDelete($event,$entity){
        $count = $this->Lieugeos->find()->where(['domaine_id'=>$entity->id])->count();
        if ($count == 0) {
            return true;
        } else {
            $entity->setError('hasChilds', ['']);
            return false;
        }
    }
}
