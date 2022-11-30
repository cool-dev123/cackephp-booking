<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PacksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PacksTable Test Case
 */
class PacksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PacksTable
     */
    public $Packs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.packs',
        'app.reservations',
        'app.annonces',
        'app.proprietaires',
        'app.lieugeos',
        'app.kmcomms',
        'app.kmcvils',
        'app.kmstats',
        'app.clics',
        'app.contrats',
        'app.dispos',
        'app.utilisateurs',
        'app.photos',
        'app.selections',
        'app.packs_reservations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Packs') ? [] : ['className' => 'App\Model\Table\PacksTable'];
        $this->Packs = TableRegistry::get('Packs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Packs);

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
