<?php
namespace App\Model\Table;

use App\Model\Entity\Photo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Photos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Annonces
 */
class PhotosTable extends Table
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

        $this->table('photos');
        $this->displayField('id');
        $this->primaryKey('id');

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

        $validator
            ->integer('numero')
            ->requirePresence('numero', 'create')
            ->notEmpty('numero');

        $validator
            ->allowEmpty('titre');

        return $validator;
    }

}
