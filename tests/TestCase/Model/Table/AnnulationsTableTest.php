<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnnulationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnnulationsTable Test Case
 */
class AnnulationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AnnulationsTable
     */
    public $Annulations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.annulations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Annulations') ? [] : ['className' => AnnulationsTable::class];
        $this->Annulations = TableRegistry::get('Annulations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Annulations);

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
