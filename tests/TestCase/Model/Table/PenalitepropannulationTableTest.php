<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PenalitepropannulationTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PenalitepropannulationTable Test Case
 */
class PenalitepropannulationTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PenalitepropannulationTable
     */
    public $Penalitepropannulation;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.penalitepropannulation',
        'app.utilisateurs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Penalitepropannulation') ? [] : ['className' => PenalitepropannulationTable::class];
        $this->Penalitepropannulation = TableRegistry::get('Penalitepropannulation', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Penalitepropannulation);

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
