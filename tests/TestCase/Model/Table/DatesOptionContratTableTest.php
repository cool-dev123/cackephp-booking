<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DatesOptionContratTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DatesOptionContratTable Test Case
 */
class DatesOptionContratTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DatesOptionContratTable
     */
    public $DatesOptionContrat;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dates_option_contrat',
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
        $config = TableRegistry::exists('DatesOptionContrat') ? [] : ['className' => DatesOptionContratTable::class];
        $this->DatesOptionContrat = TableRegistry::get('DatesOptionContrat', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DatesOptionContrat);

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
