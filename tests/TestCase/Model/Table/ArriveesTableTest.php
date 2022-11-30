<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ArriveesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ArriveesTable Test Case
 */
class ArriveesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ArriveesTable
     */
    public $Arrivees;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.arrivees'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Arrivees') ? [] : ['className' => 'App\Model\Table\ArriveesTable'];
        $this->Arrivees = TableRegistry::get('Arrivees', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Arrivees);

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
