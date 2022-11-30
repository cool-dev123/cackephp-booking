<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PvillesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PvillesTable Test Case
 */
class PvillesTableTest extends TestCase
{

    /**
     * Test subject     *
     * @var \App\Model\Table\PvillesTable     */
    public $Pvilles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pvilles',
        'app.pays'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Pvilles') ? [] : ['className' => 'App\Model\Table\PvillesTable'];        $this->Pvilles = TableRegistry::get('Pvilles', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pvilles);

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
