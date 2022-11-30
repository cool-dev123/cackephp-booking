<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResidencesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResidencesTable Test Case
 */
class ResidencesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResidencesTable
     */
    public $Residences;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.residences'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Residences') ? [] : ['className' => 'App\Model\Table\ResidencesTable'];
        $this->Residences = TableRegistry::get('Residences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Residences);

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
