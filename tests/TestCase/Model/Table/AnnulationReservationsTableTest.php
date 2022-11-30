<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnnulationReservationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnnulationReservationsTable Test Case
 */
class AnnulationReservationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AnnulationReservationsTable
     */
    public $AnnulationReservations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.annulation_reservations',
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
        $config = TableRegistry::exists('AnnulationReservations') ? [] : ['className' => AnnulationReservationsTable::class];
        $this->AnnulationReservations = TableRegistry::get('AnnulationReservations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AnnulationReservations);

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
