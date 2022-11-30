<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Statistiquetauxremplissage Model
 *
 * @method \App\Model\Entity\Statistiquetauxremplissage get($primaryKey, $options = [])
 * @method \App\Model\Entity\Statistiquetauxremplissage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Statistiquetauxremplissage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Statistiquetauxremplissage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Statistiquetauxremplissage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Statistiquetauxremplissage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Statistiquetauxremplissage findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StatistiquetauxremplissageTable extends Table
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

        $this->setTable('statistiquetauxremplissage');
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
            ->requirePresence('nbr_annonce_active', 'create')
            ->notEmpty('nbr_annonce_active');

        $validator
            ->requirePresence('nbr_lit_lie', 'create')
            ->notEmpty('nbr_lit_lie');

        return $validator;
    }
}
