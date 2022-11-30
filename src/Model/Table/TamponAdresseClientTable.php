<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TamponAdresseClient Model
 *
 * @method \App\Model\Entity\TamponAdresseClient get($primaryKey, $options = [])
 * @method \App\Model\Entity\TamponAdresseClient newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TamponAdresseClient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TamponAdresseClient|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TamponAdresseClient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TamponAdresseClient[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TamponAdresseClient findOrCreate($search, callable $callback = null, $options = [])
 */
class TamponAdresseClientTable extends Table
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

        $this->setTable('tampon_adresse_client');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->integer('client_id_loc')
            ->requirePresence('client_id_loc', 'create')
            ->notEmpty('client_id_loc');

        $validator
            ->scalar('suffix')
            ->maxLength('suffix', 255)
            ->allowEmpty('suffix');

        $validator
            ->scalar('firstname')
            ->maxLength('firstname', 255)
            ->requirePresence('firstname', 'create')
            ->notEmpty('firstname');

        $validator
            ->scalar('lastname')
            ->maxLength('lastname', 255)
            ->requirePresence('lastname', 'create')
            ->notEmpty('lastname');

        $validator
            ->scalar('middlename')
            ->maxLength('middlename', 255)
            ->allowEmpty('middlename');

        $validator
            ->scalar('vat_number')
            ->maxLength('vat_number', 255)
            ->allowEmpty('vat_number');

        $validator
            ->scalar('phone_shipping')
            ->maxLength('phone_shipping', 255)
            ->requirePresence('phone_shipping', 'create')
            ->notEmpty('phone_shipping');

        $validator
            ->scalar('fax_shipping')
            ->maxLength('fax_shipping', 255)
            ->allowEmpty('fax_shipping');

        $validator
            ->scalar('country_shipping')
            ->maxLength('country_shipping', 255)
            ->requirePresence('country_shipping', 'create')
            ->notEmpty('country_shipping');

        $validator
            ->scalar('postcode_shipping')
            ->maxLength('postcode_shipping', 255)
            ->allowEmpty('postcode_shipping');

        $validator
            ->scalar('city_shipping')
            ->maxLength('city_shipping', 255)
            ->requirePresence('city_shipping', 'create')
            ->notEmpty('city_shipping');

        $validator
            ->scalar('company_shipping')
            ->maxLength('company_shipping', 255)
            ->allowEmpty('company_shipping');

        $validator
            ->scalar('region_shipping')
            ->maxLength('region_shipping', 255)
            ->allowEmpty('region_shipping');

        $validator
            ->scalar('street_shipping')
            ->requirePresence('street_shipping', 'create')
            ->notEmpty('street_shipping');

        $validator
            ->scalar('phone_biling')
            ->maxLength('phone_biling', 255)
            ->requirePresence('phone_biling', 'create')
            ->notEmpty('phone_biling');

        $validator
            ->scalar('fax_biling')
            ->maxLength('fax_biling', 255)
            ->allowEmpty('fax_biling');

        $validator
            ->scalar('country_biling')
            ->maxLength('country_biling', 255)
            ->requirePresence('country_biling', 'create')
            ->notEmpty('country_biling');

        $validator
            ->scalar('postcode_biling')
            ->maxLength('postcode_biling', 255)
            ->allowEmpty('postcode_biling');

        $validator
            ->scalar('city_biling')
            ->maxLength('city_biling', 255)
            ->requirePresence('city_biling', 'create')
            ->notEmpty('city_biling');

        $validator
            ->scalar('company_biling')
            ->maxLength('company_biling', 255)
            ->allowEmpty('company_biling');

        $validator
            ->scalar('region_biling')
            ->maxLength('region_biling', 255)
            ->allowEmpty('region_biling');

        $validator
            ->scalar('street_biling')
            ->requirePresence('street_biling', 'create')
            ->notEmpty('street_biling');

        $validator
            ->allowEmpty('source');

        $validator
            ->requirePresence('is_sync', 'create')
            ->notEmpty('is_sync');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');

        $validator
            ->dateTime('sync_at')
            ->allowEmpty('sync_at');

        return $validator;
    }

    /**
     * Returns the database connection name to use by default.
     *
     * @return string
     */
    public static function defaultConnectionName()
    {
        return 'tampon';
    }
}
