<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BlocMailGestionnaires Model
 *
 * @property \App\Model\Table\GestionnairesTable|\Cake\ORM\Association\BelongsTo $Gestionnaires
 *
 * @method \App\Model\Entity\BlocMailGestionnaire get($primaryKey, $options = [])
 * @method \App\Model\Entity\BlocMailGestionnaire newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BlocMailGestionnaire[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BlocMailGestionnaire|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BlocMailGestionnaire patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BlocMailGestionnaire[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BlocMailGestionnaire findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BlocMailGestionnairesTable extends Table
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

        $this->setTable('bloc_mail_gestionnaires');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Gestionnaires', [
            'foreignKey' => 'gestionnaire_id',
            'joinType' => 'INNER'
        ]);
    }

}
