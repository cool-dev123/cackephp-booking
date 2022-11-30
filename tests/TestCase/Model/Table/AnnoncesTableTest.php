<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnnoncesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnnoncesTable Test Case
 */
class AnnoncesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AnnoncesTable
     */
    public $Annonces;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.annonces',
        'app.proprietaires',
        'app.lieugeos',
        'app.kmcomms',
        'app.kmcvils',
        'app.kmstats',
        'app.clics',
        'app.contrats',
        'app.dispos',
        'app.photos',
        'app.reservations',
        'app.selections'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Annonces') ? [] : ['className' => 'App\Model\Table\AnnoncesTable'];
        $this->Annonces = TableRegistry::get('Annonces', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Annonces);

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
