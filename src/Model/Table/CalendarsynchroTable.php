<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Calendarsynchro Model
 *
 * @property \App\Model\Table\DisposTable|\Cake\ORM\Association\HasMany $Dispos
 * @property \App\Model\Table\ReservationsTable|\Cake\ORM\Association\HasMany $Reservations
 *
 * @method \App\Model\Entity\Calendarsynchro get($primaryKey, $options = [])
 * @method \App\Model\Entity\Calendarsynchro newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Calendarsynchro[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Calendarsynchro|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Calendarsynchro patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Calendarsynchro[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Calendarsynchro findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CalendarsynchroTable extends Table
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

        $this->setTable('calendarsynchro');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Dispos', [
            'foreignKey' => 'calendarsynchro_id'
        ]);
        $this->hasMany('Reservations', [
            'foreignKey' => 'calendarsynchro_id'
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
            ->scalar('url')
            ->requirePresence('url', 'create')
            ->notEmpty('url');

        return $validator;
    }
}
