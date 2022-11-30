<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CalendarsynchroTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CalendarsynchroTable Test Case
 */
class CalendarsynchroTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CalendarsynchroTable
     */
    public $Calendarsynchro;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.calendarsynchro',
        'app.dispos',
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
        $config = TableRegistry::exists('Calendarsynchro') ? [] : ['className' => CalendarsynchroTable::class];
        $this->Calendarsynchro = TableRegistry::get('Calendarsynchro', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Calendarsynchro);

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
}
