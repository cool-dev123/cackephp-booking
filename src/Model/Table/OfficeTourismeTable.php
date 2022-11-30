<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OfficeTourisme Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Lieugeos
 * @property \App\Model\Table\CategorieOfficesTable|\Cake\ORM\Association\BelongsTo $CategorieOffices
 *
 * @method \App\Model\Entity\OfficeTourisme get($primaryKey, $options = [])
 * @method \App\Model\Entity\OfficeTourisme newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OfficeTourisme[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OfficeTourisme|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OfficeTourisme patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OfficeTourisme[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OfficeTourisme findOrCreate($search, callable $callback = null, $options = [])
 */
class OfficeTourismeTable extends Table
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

        $this->setTable('office_tourisme');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Villages', [
            'foreignKey' => 'village_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('VillagesForBackend', [
            'className' => 'villages',
            'foreignKey' => 'village_id',
            'joinType' => 'LEFT'
        ]);
        // $this->belongsTo('CategorieOffice', [
        //     'foreignKey' => 'categorie_office_id',
        //     'joinType' => 'INNER'
        // ]);
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
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmpty('type');
        
        $validator
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        $validator
            ->url('lien')
            ->maxLength('lien', 255)
            ->allowEmpty('lien');

        $validator
            ->integer('categorie')
            ->maxLength('lien', 255)
            ->requirePresence('categorie', 'create')
            ->notEmpty('categorie');

        $validator
            ->scalar('adresse2')
            ->maxLength('adresse2', 255)
            ->allowEmpty('adresse2');

        $validator
            ->scalar('code_postale')
            ->maxLength('code_postale', 255)
            ->allowEmpty('code_postale');

        $validator
            ->scalar('adresse')
            ->maxLength('adresse', 255)
            ->requirePresence('adresse', 'create')
            ->notEmpty('adresse');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 255)
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 255)
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

            $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->allowEmpty('email');

        $validator
            ->scalar('tel')
            ->maxLength('tel', 255)
            ->allowEmpty('tel');

        $validator
            ->scalar('portable')
            ->maxLength('portable', 255)
            ->requirePresence('portable', 'create')
            ->allowEmpty('portable');

        $validator
            ->email('email_pro')
            ->maxLength('email_pro', 255)
            ->allowEmpty('email_pro');

        $validator
            ->scalar('tel_pro')
            ->maxLength('tel_pro', 255)
            ->allowEmpty('tel_pro');

        $validator
            ->scalar('skype')
            ->maxLength('skype', 255)
            ->allowEmpty('skype');

        $validator
            ->scalar('telecopie')
            ->maxLength('telecopie', 255)
            ->allowEmpty('telecopie');

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
        $rules->add($rules->existsIn(['village_id'], 'Villages'));
        // $rules->add($rules->existsIn(['categorie_office_id'], 'CategorieOffice'));

        return $rules;
    }

    /**
     * Returns types of Office
     */
    private $types = [
        'Acceuil' => 'Acceuil',
        'Association' => 'Association',
        'Bureau d\'Accueil' => 'Bureau d\'Accueil',
        'Bureau d\'Information Touristique' => 'Bureau d\'Information Touristique',
        'Chalet d\'accueil' => 'Chalet d\'accueil',
        'Chalet du Tourisme' => 'Chalet du Tourisme',
        'Comité Départemental du Tourisme' => 'Comité Départemental du Tourisme',
        'Commission Syndicale' => 'Commission Syndicale',
        'Communauté de Communes' => 'Communauté de Communes',
        'Commune' => 'Commune',
        'Conseil Général' => 'Conseil Général',
        'Domaine skiable' => 'Domaine skiable',
        'EPIC' => 'EPIC',
        'Espace Nordique' => 'Espace Nordique',
        'Foyer de ski de fond' => 'Foyer de ski de fond',
        'Gite' => 'Gite',
        'M.' => 'M.',
        'Mairie' => 'Mairie',
        'Maison du Tourisme' => 'Maison du Tourisme',
        'Mlle' => 'Mlle',
        'Mme' => 'Mme',
        'Office de Tourisme' => 'Office de Tourisme',
        'Office de Tourisme Communal' => 'Office de Tourisme Communal',
        'Office de Tourisme Intercommunal' => 'Office de Tourisme Intercommunal',
        'Parc naturel régional' => 'Parc naturel régional',
        'Point Info Tourisme' => 'Point Info Tourisme',
        'Régie' => 'Régie',
        'Régie autonome des sports et loisirs' => 'Régie autonome des sports et loisirs',
        'Service du tourisme' => 'Service du tourisme',
        'Ski Club' => 'Ski Club',
        'Station' => 'Station',
        'Syndicat Mixte' => 'Syndicat Mixte',
        'Syndicat d\'initiative' => 'Syndicat d\'initiative',
        'Syndicat intercommunal' => 'Syndicat intercommunal',
        'Téléski' => 'Téléski'
    ];
    public function getStaticTypes()
    {
        asort($this->types);
        return $this->types;
    }

    public function findForDataTable($idGest){
        if($idGest==null)
            return $this->find()->order('nom');
        return $this->find()->join([
            'Village' => [
                'table' => 'villages',
                'type' => 'inner',
                'conditions' => ['Village.id=OfficeTourisme.village_id']
              ],
              'G' => [
                      'table' => 'gestionnaires',
                      'type' => 'inner',
                      'conditions' => ['G.id'=>$idGest]
              ],
              'GV' => [
                'table' => 'gestionnaires_villages',
                'type' => 'inner',
                'conditions' => ['GV.gestionnaire_id=G.id','Village.id=GV.villages_id']
              ],
        ])->order('nom');
    }

}
