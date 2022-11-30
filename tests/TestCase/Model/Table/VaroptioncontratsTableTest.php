<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VaroptioncontratsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VaroptioncontratsTable Test Case
 */
class VaroptioncontratsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VaroptioncontratsTable
     */
    public $Varoptioncontrats;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.varoptioncontrats',
        'app.contrats',
        'app.options'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Varoptioncontrats') ? [] : ['className' => VaroptioncontratsTable::class];
        $this->Varoptioncontrats = TableRegistry::get('Varoptioncontrats', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Varoptioncontrats);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
