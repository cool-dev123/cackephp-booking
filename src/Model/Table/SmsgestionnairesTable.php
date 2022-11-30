<?php
namespace App\Model\Table;

use App\Model\Entity\Smsgestionnaire;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Smsgestionnaires Model
 *
 */
class SmsgestionnairesTable extends Table
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

        $this->table('smsgestionnaires');
        $this->displayField('id');
        $this->primaryKey('id');
    }

   
}
