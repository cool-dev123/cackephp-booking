<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Departements Model
 *
 * @property \App\Model\Table\RegionsTable|\Cake\ORM\Association\BelongsTo $Regions
 * @property \App\Model\Table\FrvillesTable|\Cake\ORM\Association\HasMany $Frvilles
 *
 * @method \App\Model\Entity\Departement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Departement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Departement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Departement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Departement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Departement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Departement findOrCreate($search, callable $callback = null, $options = [])
 */
class DepartementsTable extends Table
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

        $this->setTable('departements');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        // $this->belongsTo('Regions', [
        //     'foreignKey' => 'region_id',
        //     'joinType' => 'INNER'
        // ]);
        $this->hasMany('Frvilles', [
            'foreignKey' => 'departement_id'
        ]);
    }

    // /**
    //  * Default validation rules.
    //  *
    //  * @param \Cake\Validation\Validator $validator Validator instance.
    //  * @return \Cake\Validation\Validator
    //  */
    // public function validationDefault(Validator $validator)
    // {
    //     $validator
    //         ->integer('id')
    //         ->allowEmpty('id', 'create');

    //     $validator
    //         ->scalar('name')
    //         ->maxLength('name', 255)
    //         ->requirePresence('name', 'create')
    //         ->notEmpty('name');

    //     return $validator;
    // }

    // /**
    //  * Returns a rules checker object that will be used for validating
    //  * application integrity.
    //  *
    //  * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
    //  * @return \Cake\ORM\RulesChecker
    //  */
    // public function buildRules(RulesChecker $rules)
    // {
    //     $rules->add($rules->existsIn(['region_id'], 'Regions'));

    //     return $rules;
    // }
}
