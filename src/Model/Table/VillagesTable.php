<?php
namespace App\Model\Table;

use App\Model\Entity\Village;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Villages Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Lieugeos
 *
 * @method \App\Model\Entity\Village get($primaryKey, $options = [])
 * @method \App\Model\Entity\Village newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Village[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Village|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Village patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Village[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Village findOrCreate($search, callable $callback = null, $options = [])
 */
class VillagesTable extends Table
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

        $this->setTable('villages');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('OfficeTourisme', [
            'foreignKey' => 'village_id',
        ]);

        $this->belongsTo('Lieugeos', [
            'foreignKey' => 'lieugeo_id',
            'joinType' => 'INNER',
            'conditions' => ['Lieugeos.niveau >= 3']
        ]);

        $this->belongsTo('hasLieugeosOrNot', [
            'className' => 'Lieugeos',
            'foreignKey' => 'lieugeo_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Frvilles', [
            'foreignKey' => 'id_ville',
            'joinType' => 'INNER'
        ]);

        $this->belongsToMany('Gestionnaires', [
			'joinTable' => 'gestionnaires_villages',
            'foreignKey'=>'villages_id',
            'targetForeignKey'=> 'gestionnaire_id'
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
            ->integer('id_ville')
            ->requirePresence('id_ville', 'create')
            ->notEmpty('id_ville');

        $validator
            ->integer('lieugeo_id')
            ->requirePresence('lieugeo_id', 'create')
            ->notEmpty('lieugeo_id');

        $validator
            ->scalar('input_boutique')
            ->maxLength('input_boutique', 255)
            ->requirePresence('input_boutique', 'create')
            ->notEmpty('input_boutique');

        $validator
            ->scalar('input_boutique_EN')
            ->maxLength('input_boutique_EN', 255)
            ->requirePresence('input_boutique_EN', 'create')
            ->notEmpty('input_boutique_EN');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', [
                'unique' => [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Cette village existe.']
                ]);

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
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->existsIn(['lieugeo_id'], 'Lieugeos'));
        $rules->add($rules->existsIn(['id_ville'], 'Frvilles'));
        return $rules;
    }

    public function beforeSave($event, $entity, $options) {
        if($entity->id_bureau==null)
            $entity->id_bureau=0;
    }

    function beforeDelete($event,$entity){
        $countOfficeTourisme = $this->OfficeTourisme->find()->where(['village_id'=>$entity->id])->count();
        if ($countOfficeTourisme == 0) {
            return true;
        } else {
            $entity->setError('hasOfficeTourisme', ['']);
            return false;
        }
    }

    function getAllVillages($gestId){
        $villages=$this->find();
        $villages->join([
            'Lieugeo'=>[
                'table' => 'lieugeos',
                'type' => 'left',
                'conditions' => 'Lieugeo.id = Villages.lieugeo_id'
            ],
            'Frville'=>[
                'table' => 'frvilles',
                'type' => 'inner',
                'conditions' => 'Frville.id = Villages.id_ville'
            ],
            'Annonces'=>[
                'table' => 'annonces',
                'type' => 'left',
                'conditions' => ['Annonces.village = Villages.id', 'Annonces.statut <> 40']
            ]
        ])
        ->select(['count' => $villages->func()->count('Annonces.id'),'Villages.id','Villages.name','Villages.input_boutique','Villages.input_boutique_EN','Lieugeo.id','Lieugeo.name','Lieugeo.massif_id','Frville.name','Frville.id','Frville.departement_id']);
        if($gestId!=null)
            $villages->join([
                'G' => [
                    'table' => 'gestionnaires',
                    'type' => 'inner',
                    'conditions' => ['G.id'=>$gestId]
                ],
                'GV' => [
                    'table' => 'gestionnaires_villages',
                    'type' => 'inner',
                    'conditions' => ['GV.gestionnaire_id=G.id','Villages.id=GV.villages_id']
                ],
            ]);
        $villages->group('Villages.id');
        return $villages;
    }
}
