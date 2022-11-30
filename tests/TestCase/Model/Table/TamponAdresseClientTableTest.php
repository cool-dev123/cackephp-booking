<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TamponAdresseClientTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TamponAdresseClientTable Test Case
 */
class TamponAdresseClientTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TamponAdresseClientTable
     */
    public $TamponAdresseClient;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tampon_adresse_client'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TamponAdresseClient') ? [] : ['className' => TamponAdresseClientTable::class];
        $this->TamponAdresseClient = TableRegistry::get('TamponAdresseClient', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TamponAdresseClient);

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
     * Test defaultConnectionName method
     *
     * @return void
     */
    public function testDefaultConnectionName()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
