<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Partenaires Model
 *
 * @property \App\Model\Table\LieugeosTable|\Cake\ORM\Association\BelongsTo $Lieugeos
 * @property \App\Model\Table\PartsTable|\Cake\ORM\Association\BelongsTo $Parts
 * @property \App\Model\Table\VillesTable|\Cake\ORM\Association\BelongsTo $Villes
 * @property \App\Model\Table\PaysTable|\Cake\ORM\Association\BelongsTo $Pays
 *
 * @method \App\Model\Entity\Partenaire get($primaryKey, $options = [])
 * @method \App\Model\Entity\Partenaire newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Partenaire[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Partenaire|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Partenaire patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Partenaire[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Partenaire findOrCreate($search, callable $callback = null, $options = [])
 */
class PartenairesTable extends Table
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

        $this->setTable('partenaires');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Lieugeos', [
            'foreignKey' => 'lieugeo_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Frvilles', [
            'foreignKey' => 'id_ville',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Pvilles', [
            'foreignKey' => 'id_ville',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Pays', [
            'foreignKey' => 'pays_id',
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
            ->integer('part_code')
            ->allowEmpty('part_code');

        // $validator
        //     ->integer('part_id')
        //     ->requirePresence('part_id', 'create')
        //     ->notEmpty('part_id');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->scalar('type2')
            ->maxLength('type2', 255)
            ->allowEmpty('type2');

        $validator
            ->scalar('type3')
            ->maxLength('type3', 255)
            ->allowEmpty('type3');

        $validator
            ->scalar('type4')
            ->maxLength('type4', 255)
            ->allowEmpty('type4');

        $validator
            ->scalar('type5')
            ->maxLength('type5', 255)
            ->allowEmpty('type5');

        $validator
            ->date('date_creation','dmy')
            ->allowEmpty('date_creation');

        $validator
            ->scalar('aContacter')
            ->maxLength('aContacter', 10)
            ->requirePresence('aContacter', 'create')
            ->allowEmpty('aContacter');

        $validator
            ->scalar('langue')
            ->maxLength('langue', 255)
            ->allowEmpty('langue');

        $validator
            ->scalar('lat')
            ->maxLength('lat', 255)
            ->allowEmpty('lat');

        $validator
            ->scalar('lng')
            ->maxLength('lng', 255)
            ->allowEmpty('lng');

        $validator
            ->scalar('forme_juridique')
            ->maxLength('forme_juridique', 255)
            ->allowEmpty('forme_juridique');

        $validator
            ->scalar('raison_sociale')
            ->maxLength('raison_sociale', 255)
            ->requirePresence('raison_sociale', 'create')
            ->allowEmpty('raison_sociale');

        $validator
            ->scalar('genre')
            ->maxLength('genre', 10)
            ->allowEmpty('genre');

        $validator
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->allowEmpty('nom');

        $validator
            ->scalar('prenom')
            ->maxLength('prenom', 255)
            ->allowEmpty('prenom');

        $validator
            ->scalar('fonction')
            ->maxLength('fonction', 255)
            ->allowEmpty('fonction');

        $validator
            ->scalar('adresse')
            ->maxLength('adresse', 255)
            ->requirePresence('adresse', 'create')
            ->allowEmpty('adresse');

        $validator
            ->integer('code_postal')
            ->requirePresence('code_postal', 'create')
            ->allowEmpty('code_postal');

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
            ->scalar('fax')
            ->maxLength('fax', 255)
            ->allowEmpty('fax');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->scalar('skype')
            ->maxLength('skype', 255)
            ->allowEmpty('skype');

        $validator
            ->scalar('ftp')
            ->maxLength('ftp', 255)
            ->allowEmpty('ftp');

        $validator
            ->scalar('url_adress')
            ->maxLength('url_adress', 255)
            ->allowEmpty('url_adress');

        $validator
            ->scalar('code_ape')
            ->maxLength('code_ape', 255)
            ->allowEmpty('code_ape');

        $validator
            ->scalar('siriet')
            ->maxLength('siriet', 255)
            ->allowEmpty('siriet');

        $validator
            ->decimal('capital')
            ->allowEmpty('capital');

        $validator
            ->integer('effectif')
            ->allowEmpty('effectif');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['lieugeo_id'], 'Lieugeos'));
        // $rules->add($rules->existsIn(['ville_id'], 'Villes'));
        $rules->add($rules->existsIn(['pays_id'], 'Pays'));

        return $rules;
    }

    /**
     * Returns types of Partenaire
     */
    private $types = [
        'Association de Consommateurs'=>'Association de Consommateurs',
        'Association de Propriétaires'=>'Association de Propriétaires',
        'Agence de Voyage'=>'Agence de Voyage',
        'Blanchisserie'=>'Blanchisserie',
        'Conciergerie'=>'Conciergerie',
        'Laverie'=>'Laverie',
        'Moniteur de Ski'=>'Moniteur de Ski',
        'Ménage'=>'Ménage',
        'Pressing'=>'Pressing',
        'Remontées Mécaniques'=>'Remontées Mécaniques',
        'Service Technique'=>'Service Technique',
        'Site internet'=>'Site internet',
        'Baby Sitter'=>'Baby Sitter',
        'Garderie'=>'Garderie',
        'Agent immobilier'=>'Agent immobilier',
        'Architecte d\'interieur'=>'Architecte d\'interieur',
        'Antiquités'=>'Antiquités',
        'Bagagerie'=>'Bagagerie',
        'Cadeaux'=>'Cadeaux',
        'Coiffure'=>'Coiffure',
        'Couture'=>'Couture',
        'Cuisine à Domicile'=>'Cuisine à Domicile',
        'Cuisines et Bains'=>'Cuisines et Bains',
        'Décoration'=>'Décoration',
        'Développement Economique'=>'Développement Economique',
        'Editions'=>'Editions',
        'Electricité'=>'Electricité',
        'Equipements de la maison'=>'Equipements de la maison',
        'Electroménager'=>'Electroménager',
        'Esthétique'=>'Esthétique',
        'Gardien'=>'Gardien',
        'Guide'=>'Guide',
        'Guide du Patrimoine'=>'Guide du Patrimoine',
        'Loisir/Détente'=>'Loisir/Détente',
        'Location de Linge'=>'Location de Linge',
        'Location de Matériel'=>'Location de Matériel',
        'Luminaires'=>'Luminaires',
        'Maintenance'=>'Maintenance',
        'Mobilier'=>'Mobilier',
        'Matériel de sport'=>'Matériel de sport',
        'Multiservice'=>'Multiservice',
        'Notaire'=>'Notaire',
        'Objets de Décoration'=>'Objets de Décoration',
        'Plomberie'=>'Plomberie',
        'Puériculture'=>'Puériculture',
        'Presse'=>'Presse',
        'Professionnels du sport'=>'Professionnels du sport',
        'Quincaillerie'=>'Quincaillerie',
        'Souvenirs'=>'Souvenirs',
        'Services Financiers'=>'Services Financiers',
        'Tabac'=>'Tabac',
        'Tapissier Décorateur'=>'Tapissier Décorateur',
        'Travaux'=>'Travaux',
        'Taxis - Transport de personnes'=>'Taxis - Transport de personnes',
        'Helicoptère'=>'Helicoptère',
        'Chiens de traineaux'=>'Chiens de traineaux'
    ];
    public function getStaticTypes()
    {
        asort($this->types);
        return [null=>'Pas de type']+$this->types;
    }
}
