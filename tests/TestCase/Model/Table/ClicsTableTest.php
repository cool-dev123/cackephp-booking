<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClicsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClicsTable Test Case
 */
class ClicsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClicsTable
     */
    public $Clics;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.clics',
        'app.annonces',
        'app.utilisateurs',
        'app.lieugeos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Clics') ? [] : ['className' => 'App\Model\Table\ClicsTable'];
        $this->Clics = TableRegistry::get('Clics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Clics);

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
