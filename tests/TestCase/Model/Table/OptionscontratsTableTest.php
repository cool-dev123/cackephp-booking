<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OptionscontratsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OptionscontratsTable Test Case
 */
class OptionscontratsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OptionscontratsTable
     */
    public $Optionscontrats;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.optionscontrats',
        'app.variables'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Optionscontrats') ? [] : ['className' => OptionscontratsTable::class];
        $this->Optionscontrats = TableRegistry::get('Optionscontrats', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Optionscontrats);

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
