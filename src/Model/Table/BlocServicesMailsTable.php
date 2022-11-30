<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BlocServicesMails Model
 *
 * @method \App\Model\Entity\BlocServicesMail get($primaryKey, $options = [])
 * @method \App\Model\Entity\BlocServicesMail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BlocServicesMail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BlocServicesMail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BlocServicesMail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BlocServicesMail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BlocServicesMail findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BlocServicesMailsTable extends Table
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

        $this->setTable('bloc_services_mails');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

}
