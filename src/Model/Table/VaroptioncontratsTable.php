<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Varoptioncontrats Model
 *
 * @property \App\Model\Table\ContratsTable|\Cake\ORM\Association\BelongsTo $Contrats
 * @property \App\Model\Table\OptionsTable|\Cake\ORM\Association\BelongsTo $Options
 *
 * @method \App\Model\Entity\Varoptioncontrat get($primaryKey, $options = [])
 * @method \App\Model\Entity\Varoptioncontrat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Varoptioncontrat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Varoptioncontrat|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Varoptioncontrat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Varoptioncontrat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Varoptioncontrat findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VaroptioncontratsTable extends Table
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

        $this->setTable('varoptioncontrats');
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

        // $validator
        //     ->scalar('variable_valeur')
        //     ->requirePresence('variable_valeur', 'create')
        //     ->notEmpty('variable_valeur');

        return $validator;
    }

}
