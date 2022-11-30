<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VillagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VillagesTable Test Case
 */
class VillagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VillagesTable
     */
    public $Villages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.villages'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Villages') ? [] : ['className' => 'App\Model\Table\VillagesTable'];
        $this->Villages = TableRegistry::get('Villages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Villages);

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
