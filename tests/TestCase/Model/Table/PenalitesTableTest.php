<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PenalitesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PenalitesTable Test Case
 */
class PenalitesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PenalitesTable
     */
    public $Penalites;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.penalites',
        'app.utilisateurs',
        'app.reservations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Penalites') ? [] : ['className' => PenalitesTable::class];
        $this->Penalites = TableRegistry::get('Penalites', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Penalites);

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
