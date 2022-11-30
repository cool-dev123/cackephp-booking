<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RegistresFixture
 *
 */
class RegistresFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'app' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => 'ULYSSE', 'comment' => '', 'precision' => null, 'fixed' => null],
        'bra' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'cle' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'val' => ['type' => 'string', 'length' => 4000, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'cpt' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        '_indexes' => [
            'index_2' => ['type' => 'index', 'columns' => ['app', 'bra', 'cle'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'MyISAM',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'app' => 'Lorem ipsum dolor ',
            'bra' => 'Lorem ipsum dolor ',
            'cle' => 'Lorem ipsum dolor ',
            'val' => 'Lorem ipsum dolor sit amet',
            'cpt' => 1,
            'id' => 1
        ],
    ];
}
