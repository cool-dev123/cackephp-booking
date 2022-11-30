<?php
namespace App\Model\Table;

use App\Model\Entity\Pack;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Packs Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Reservations
 */
class PacksTable extends Table
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

        $this->table('packs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsToMany('Reservations', [
            'foreignKey' => 'pack_id',
            'targetForeignKey' => 'reservation_id',
            'joinTable' => 'packs_reservations'
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
            ->allowEmpty('titre');

        $validator
            ->decimal('cout')
            ->allowEmpty('cout');

        $validator
            ->integer('actif_yn')
            ->allowEmpty('actif_yn');

        $validator
            ->allowEmpty('comment');

        return $validator;
    }
}
