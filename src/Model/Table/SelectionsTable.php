<?php
namespace App\Model\Table;

use App\Model\Entity\Selection;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Selections Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Utilisateurs
 * @property \Cake\ORM\Association\BelongsTo $Annonces
 */
class SelectionsTable extends Table
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

        $this->table('selections');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Utilisateurs', [
            'foreignKey' => 'utilisateur_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Annonces', [
            'foreignKey' => 'annonce_id',
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
        $rules->add($rules->existsIn(['utilisateur_id'], 'Utilisateurs'));
        $rules->add($rules->existsIn(['annonce_id'], 'Annonces'));
        return $rules;
    }
}
