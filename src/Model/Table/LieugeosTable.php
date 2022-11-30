<?php
namespace App\Model\Table;

use App\Model\Entity\Lieugeo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Lieugeos Model
 *
 * @property \App\Model\Table\LieugeosTable|\Cake\ORM\Association\BelongsTo $ParentLieugeos
 * @property |\Cake\ORM\Association\BelongsTo $Domaines
 * @property |\Cake\ORM\Association\BelongsTo $Villes
 * @property |\Cake\ORM\Association\BelongsTo $Villages
 * @property |\Cake\ORM\Association\HasMany $AnneLieugeos
 * @property \App\Model\Table\AnnoncesTable|\Cake\ORM\Association\HasMany $Annonces
 * @property \App\Model\Table\LieugeosTable|\Cake\ORM\Association\HasMany $ChildLieugeos
 * @property |\Cake\ORM\Association\HasMany $RemonteMecanique
 * @property |\Cake\ORM\Association\HasMany $WebcamLieugeos
 *
 * @method \App\Model\Entity\Lieugeo get($primaryKey, $options = [])
 * @method \App\Model\Entity\Lieugeo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Lieugeo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Lieugeo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lieugeo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Lieugeo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Lieugeo findOrCreate($search, callable $callback = null, $options = [])
 */
class LieugeosTable extends Table
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

        $this->setTable('lieugeos');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        // $this->belongsTo('ParentLieugeos', [
        //     'className' => 'Lieugeos',
        //     'foreignKey' => 'parent_id'
        // ]);
        $this->belongsTo('Domaine', [
            'foreignKey' => 'domaine_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Massif', [
            'foreignKey' => 'massif_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasOne('Gestionnaires', [
            'foreignKey' => 'station_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AnneLieugeos', [
            'foreignKey' => 'lieugeo_id'
        ]);
        $this->hasMany('Annonces', [
            'foreignKey' => 'lieugeo_id'
        ]);
        // $this->hasMany('ChildLieugeos', [
        //     'className' => 'Lieugeos',
        //     'foreignKey' => 'parent_id'
        // ]);
        $this->belongsTo('RemonteMecanique', [
            'foreignKey' => 'RM_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('WebcamLieugeos', [
            'foreignKey' => 'lieugeo_id'
        ]);
        $this->hasMany('Villages', [
            'foreignKey' => 'lieugeo_id',
            'conditions' => ['Lieugeos.niveau >= 3']
        ]);

        $this->hasMany('VillagesPrivate', [
            'foreignKey' => 'lieugeo_id',
            'className' => 'Villages',
        ]);
        
        $this->hasMany('Stations',[
            'foreignKey' => 'station_id',
        ]);

        $this->hasMany('Lit',[
            'foreignKey' => 'lieugeo_id',
        ]);

        $this->hasMany('NumeroUtiles',[
            'foreignKey' => 'id_lieugeo',
        ]);

        $this->addBehavior('Translate', [
            'fields' => ['descreption', 'sous_description', 'description_api', 'description_ete', 'description_act_ete', 'description_hiver', 'description_act_hiver', 'description_acc', 'preposition_a', 'article_de'],
            'translationTable' => 'LieugeosI18n'
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
            ->scalar('name')
            ->maxLength('name', 200)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('niveau');

        $validator
            ->scalar('query')
            ->maxLength('query', 255)
            ->allowEmpty('query');

        $validator
            ->integer('select_yn')
            ->allowEmpty('select_yn');

            $validator
            ->decimal('latitude')
            ->maxLength('latitude', 255)
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->decimal('longitude')
            ->maxLength('longitude', 255)
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

        $validator
            ->scalar('descreption')
            ->allowEmpty('descreption');

        $validator
            ->decimal('ALT_BAS')
            ->requirePresence('ALT_BAS', 'create')
            ->notEmpty('ALT_BAS');

        $validator
            ->decimal('ALT_HAUT')
            ->requirePresence('ALT_HAUT', 'create')
            ->notEmpty('ALT_HAUT');

        // $validator
        //     ->boolean('etat')
        //     ->requirePresence('etat', 'create')
        //     ->notEmpty('etat');

        $validator
            ->url('urlBlog')
            ->maxLength('urlBlog', 255)
            ->allowEmpty('urlBlog');

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
        // $rules->add($rules->isUnique(['portable']));
        // $rules->add($rules->isUnique(['tel_pro']));
        // $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['name']));
        // $rules->add($rules->isUnique(['email_pro']));
        // $rules->add($rules->isUnique(['tel']));
        // $rules->add($rules->existsIn(['parent_id'], 'ParentLieugeos', ['allowNullableNulls' => true]));
        //$rules->add($rules->existsIn(['domaine_id'], 'Domaine'));
        //$rules->add($rules->existsIn(['ville_id'], 'Frvilles'));
        
        return $rules;
    }

    public function hasRm($id){
        $RemonteMecaniqueLieugeos = TableRegistry::get('RemonteMecaniqueLieugeos');
        return $RemonteMecaniqueLieugeos->find()->where(['lieugeo_id'=>$id])->count()>0;
    }
    public function hasAnnonces($id){
        return $this->Annonces->find()->where(['lieugeo_id'=>$id])->count()>0;
    }
    private function deleteallWebcams($idStation){
        $this->WebcamLieugeos->deleteAll(['lieugeo_id' => $idStation]);
    }
    
    function beforeDelete($event,$entity){
        if ($this->hasRm($entity->id) || $this->hasAnnonces($entity->id) ) {
            $entity->setError('hasChilds', ['']);
            return false;
        } else {
            $this->deleteallWebcams($entity->id);
            return true;
        }
    }

    function getAllLieugeos($gestId){
        $stations = $this->find()->join([
            'Domaine' => [
                'table' => 'domaine',
                'type' => 'left',
                'conditions' => 'Lieugeos.domaine_id = Domaine.id',
            ],
            'Massif' => [
                'table' => 'massif',
                'type' => 'inner',
                'conditions' => 'Lieugeos.massif_id = Massif.id',
            ]
        ])
        ->select(['Lieugeos.etat','Lieugeos.name','Lieugeos.id','Domaine.nom','Massif.nom','Lieugeos.from_api']);
        if($gestId!=null)
            $stations->join([
                'Village' => [
                  'table' => 'villages',
                  'type' => 'left',
                  'conditions' => 'Village.lieugeo_id=Lieugeos.id'
                ],
                'G' => [
                    'table' => 'gestionnaires',
                    'type' => 'inner',
                    'conditions' => ['G.id'=>$gestId]
                ],
                'GV' => [
                    'table' => 'gestionnaires_villages',
                    'type' => 'inner',
                    'conditions' => ['GV.gestionnaire_id=G.id','Village.id=GV.villages_id']
                ],
            ])
            ->group('Lieugeos.id');
        $stations->where(["Lieugeos.niveau >="=>3]);
        return $stations;
    }

    function getLieugeosForGest($gest){
        $return = $this->find("all",["conditions"=>["niveau >="=>3],"order"=>"Lieugeos.name"]);
        if($gest['role']!='admin')
            $return->join([
                'Village' => [
                    'table' => 'villages',
                    'type' => 'inner',
                    'conditions' => ['Village.lieugeo_id=Lieugeos.id']
                ],
                'G' => [
                    'table' => 'gestionnaires',
                    'type' => 'inner',
                    'conditions' => ['G.id'=>$gest['id']]
                ],
                'GV' => [
                    'table' => 'gestionnaires_villages',
                    'type' => 'inner',
                    'conditions' => ['GV.gestionnaire_id=G.id','Village.id=GV.villages_id']
                ]
            ]);
        return $return;
    }
}
