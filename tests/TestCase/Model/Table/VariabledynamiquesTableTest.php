<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VariabledynamiquesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VariabledynamiquesTable Test Case
 */
class VariabledynamiquesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VariabledynamiquesTable
     */
    public $Variabledynamiques;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.variabledynamiques'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Variabledynamiques') ? [] : ['className' => VariabledynamiquesTable::class];
        $this->Variabledynamiques = TableRegistry::get('Variabledynamiques', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Variabledynamiques);

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
