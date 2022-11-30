<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Frvilles Model
 *
 * @property \App\Model\Table\DepartementsTable|\Cake\ORM\Association\BelongsTo $Departements
 *
 * @method \App\Model\Entity\Frville get($primaryKey, $options = [])
 * @method \App\Model\Entity\Frville newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Frville[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Frville|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Frville patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Frville[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Frville findOrCreate($search, callable $callback = null, $options = [])
 */
class FrvillesTable extends Table
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

        $this->setTable('frvilles');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Villages', [
            'foreignKey' => 'id_ville'
        ]);

        $this->belongsTo('Departements', [
            'foreignKey' => 'departement_id',
            'joinType' => 'INNER'
        ]);

        // $this->belongsTo('Lieugeos', [
        //     'foreignKey' => 'lieugeo_id',
        //     'joinType' => 'LEFT',
        // ]);
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
            ->integer('code_postal')
            ->requirePresence('code_postal', 'create')
            ->notEmpty('code_postal');

        $validator
            ->integer('code_insee')
            ->requirePresence('code_insee', 'create')
            ->notEmpty('code_insee');

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
        $rules->add($rules->existsIn(['departement_id'], 'Departements'));

        return $rules;
    }

    function beforeDelete($event,$entity)
    {
        $count = $this->Villages->find()->where(['id_ville'=>$entity->id])->count();
        if ($count == 0) {
            return true;
        } else {
            $entity->setError('hasChilds', ['']);
            return false;
        }
    }
}
