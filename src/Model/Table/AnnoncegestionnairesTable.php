<?php
namespace App\Model\Table;

use App\Model\Entity\Annoncegestionnaire;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Annoncegestionnaires Model
 *
 */
class AnnoncegestionnairesTable extends Table
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
        $this->table('annoncegestionnaires');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->integer('id_gestionnaires')
            ->requirePresence('id_gestionnaires', 'create')
            ->notEmpty('id_gestionnaires');

        $validator
            ->integer('id_annonces')
            ->requirePresence('id_annonces', 'create')
            ->notEmpty('id_annonces');

        $validator
            ->integer('modifiable')
            ->requirePresence('modifiable', 'create')
            ->notEmpty('modifiable');

        $validator
            ->requirePresence('position_cle', 'create')
            ->notEmpty('position_cle');

        $validator
            ->integer('visible')
            ->requirePresence('visible', 'create')
            ->notEmpty('visible');

        return $validator;
    }
}
