<?php
namespace App\Model\Table;

use App\Model\Entity\Absence;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Absences Model
 *
 */
class AbsencesTable extends Table
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
        $this->table('absences');
        $this->displayField('id');
        $this->primaryKey('id');
    }    

}
