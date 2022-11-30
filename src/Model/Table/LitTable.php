<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Lit Model
 *
 * @property \App\Model\Table\LieugeosTable|\Cake\ORM\Association\BelongsTo $Lieugeos
 *
 * @method \App\Model\Entity\Lit get($primaryKey, $options = [])
 * @method \App\Model\Entity\Lit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Lit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Lit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Lit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Lit findOrCreate($search, callable $callback = null, $options = [])
 */
class LitTable extends Table
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

        $this->setTable('lit');
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
            ->integer('meublesClasses')
            ->allowEmpty('meublesClasses');

        $validator
            ->integer('rtClassesNon')
            ->allowEmpty('rtClassesNon');

        $validator
            ->integer('hotels')
            ->allowEmpty('hotels');

        $validator
            ->integer('litsCamping')
            ->allowEmpty('litsCamping');

        $validator
            ->integer('litsDivers')
            ->allowEmpty('litsDivers');

        $validator
            ->integer('litsRefuges')
            ->allowEmpty('litsRefuges');

        $validator
            ->integer('clesVacancesGites')
            ->allowEmpty('clesVacancesGites');

        $validator
            ->integer('anne')
            ->add('anne', 'custom', [
                'rule' => function ($value, $context) {
                    if($context['newRecord']==true && !isset($context['data']['lieugeo_id']))
                        return true;
                    else{
                        return $this->find()->where(['lieugeo_id'=>$context['data']['lieugeo_id'],'anne'=>$context['data']['anne']])->first()==null;
                    }
                },
                'message' => 'Le champ année doit être unique.'
            ])
            //->add('anne', 'unique', ['rule' => 'validateUnique', 'provider' => 'table','message'=>'Le champ année doit être unique'])
            ->minLength( 'anne' , 4 )
            ->maxLength( 'anne' , 4 )
            ->allowEmpty('anne', 'create');

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
