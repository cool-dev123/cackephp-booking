<?php
namespace App\Model\Table;

use App\Model\Entity\Smslocataire;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Smslocataires Model
 *
 */
class SmslocatairesTable extends Table
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

        $this->table('smslocataires');
        $this->displayField('id');
        $this->primaryKey('id');
    }

}
