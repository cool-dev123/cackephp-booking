<?php
namespace App\Model\Table;

use App\Model\Entity\Bibliotheque;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bibliotheques Model
 *
 * @property \Cake\ORM\Association\HasMany $Residences */
class BibliothequesTable extends Table
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

        $this->table('bibliotheques');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Residences', [
            'foreignKey' => 'bibliotheque_id'
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
            ->integer('id')            ->allowEmpty('id', 'create');
        $validator
            ->requirePresence('name', 'create')            ->notEmpty('name');
        $validator
            ->requirePresence('image', 'create')            ->notEmpty('image');
        return $validator;
    }
}
