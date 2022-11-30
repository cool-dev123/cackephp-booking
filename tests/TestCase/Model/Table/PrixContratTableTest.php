<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrixContratTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrixContratTable Test Case
 */
class PrixContratTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PrixContratTable
     */
    public $PrixContrat;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.prix_contrat',
        'app.contrats'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PrixContrat') ? [] : ['className' => PrixContratTable::class];
        $this->PrixContrat = TableRegistry::get('PrixContrat', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PrixContrat);

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
