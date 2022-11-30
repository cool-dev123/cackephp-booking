<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModelsmsystemeTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModelsmsystemeTable Test Case
 */
class ModelsmsystemeTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ModelsmsystemeTable
     */
    public $Modelsmsysteme;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.modelsmsysteme'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Modelsmsysteme') ? [] : ['className' => ModelsmsystemeTable::class];
        $this->Modelsmsysteme = TableRegistry::get('Modelsmsysteme', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Modelsmsysteme);

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
