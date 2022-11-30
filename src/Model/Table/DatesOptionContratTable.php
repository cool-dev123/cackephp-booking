<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DatesOptionContrat Model
 *
 * @property \App\Model\Table\ContratsTable|\Cake\ORM\Association\BelongsTo $Contrats
 * @property \App\Model\Table\OptionsTable|\Cake\ORM\Association\BelongsTo $Options
 *
 * @method \App\Model\Entity\DatesOptionContrat get($primaryKey, $options = [])
 * @method \App\Model\Entity\DatesOptionContrat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DatesOptionContrat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DatesOptionContrat|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DatesOptionContrat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DatesOptionContrat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DatesOptionContrat findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DatesOptionContratTable extends Table
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

        $this->setTable('dates_option_contrat');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Optionscontrats')
        ->setForeignKey('option_id')
        ->setJoinType('INNER');

        $this->belongsTo('Contrats')
        ->setForeignKey('contrat_id')
        ->setJoinType('INNER');
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
            ->scalar('dates')
            ->requirePresence('dates', 'create')
            ->notEmpty('dates');

        return $validator;
    }

}
