<?php
namespace App\Model\Table;

use App\Model\Entity\Mail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LastSentSubscriptions
 * @property \Cake\ORM\Association\BelongsToMany $Groups
 */
class MailsTable extends Table
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

        $this->table('mails');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('LastSentSubscriptions', [
            'foreignKey' => 'last_sent_subscription_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Groups', [
            'foreignKey' => 'mail_id',
            'targetForeignKey' => 'group_id',
            'joinTable' => 'groups_mails'
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
            ->allowEmpty('from');

        $validator
            ->allowEmpty('from_email');

        $validator
            ->allowEmpty('subject');

        $validator
            ->allowEmpty('content');

        $validator
            ->allowEmpty('read_confirmation_code');

        $validator
            ->integer('sent')
            ->requirePresence('sent', 'create')
            ->notEmpty('sent');

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
        $rules->add($rules->existsIn(['last_sent_subscription_id'], 'LastSentSubscriptions'));
        return $rules;
    }
}
