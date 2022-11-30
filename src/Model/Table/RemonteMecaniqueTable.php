<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RemonteMecanique Model
 *
 * @property \App\Model\Table\LieugeosTable|\Cake\ORM\Association\BelongsTo $Lieugeos
 * @property |\Cake\ORM\Association\HasMany $AnneLieugeos
 *
 * @method \App\Model\Entity\RemonteMecanique get($primaryKey, $options = [])
 * @method \App\Model\Entity\RemonteMecanique newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RemonteMecanique[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RemonteMecanique|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RemonteMecanique patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RemonteMecanique[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RemonteMecanique findOrCreate($search, callable $callback = null, $options = [])
 */
class RemonteMecaniqueTable extends Table
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

        $this->setTable('remonte_mecanique');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('Massif', [
            'foreignKey' => 'massif_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Lieugeos', [
            'foreignKey' => 'RM_id'
        ]);

        $this->hasMany('AnneLieugeos', [
            'foreignKey' => 'remonte_mecanique_id',
            'cascadeCallbacks' => true,
            'dependent' => true
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
            ->notEmpty('nom')
            ->add('nom', [
                'unique' => [
                   'rule' => 'validateUnique',
                   'provider' => 'table',
                   'message' => 'Cette RM existe.']
                ]);

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->scalar('societe_RM')
            ->maxLength('societe_RM', 255)
            ->requirePresence('societe_RM', 'create')
            ->notEmpty('societe_RM');

        $validator
            ->scalar('descreption')
            ->allowEmpty('descreption');

        $validator
            ->integer('nbrpistes_verte')
            ->requirePresence('nbrpistes_verte', 'create')
            ->notEmpty('nbrpistes_verte');

        $validator
            ->integer('nbrpistes_bleu')
            ->requirePresence('nbrpistes_bleu', 'create')
            ->notEmpty('nbrpistes_bleu');

        $validator
            ->integer('nbrpistes_rouge')
            ->requirePresence('nbrpistes_rouge', 'create')
            ->notEmpty('nbrpistes_rouge');

        $validator
            ->integer('nbrpistes_noir')
            ->requirePresence('nbrpistes_noir', 'create')
            ->notEmpty('nbrpistes_noir');

        $validator
            ->decimal('km_pistes')
            ->requirePresence('km_pistes', 'create')
            ->notEmpty('km_pistes');


        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    // public function buildRules(RulesChecker $rules)
    // {
    //     $rules->add($rules->existsIn(['lieugeo_id'], 'Lieugeos'));

    //     return $rules;
    // }

    public function allRm($gest_id){
        $rms=$this->find()->contain(['lieugeos']);
        if($gest_id!=null){
            $rms->join([
                'lieugeo' => [
                    'table' => 'lieugeos',
                    'type' => 'inner',
                    'conditions' => ['lieugeo.RM_id=RemonteMecanique.id']
                ],
                'Village' => [
                    'table' => 'villages',
                    'type' => 'inner',
                    'conditions' => ['Village.lieugeo_id=lieugeo.id']
                ],
                'GV' => [
                    'table' => 'gestionnaires_villages',
                    'type' => 'inner',
                    'conditions' => ['GV.gestionnaire_id'=>$gest_id,'Village.id=GV.villages_id']
                ],
            ]);
        }
        $rms->order('RemonteMecanique.nom')
        ->select(['RemonteMecanique.id','RemonteMecanique.nom','RemonteMecanique.type','RemonteMecanique.km_pistes','nbrpistes_verte','nbrpistes_bleu','nbrpistes_rouge','nbrpistes_noir'])
        ->toArray();
        foreach($rms as $key=>$rm){
            $rm->anne_lieugeos=$this->AnneLieugeos->getAnnesForRM($rm->id)->toArray();
            $_rms[$key]=$rm;
        }
        return $_rms;
    }
}
