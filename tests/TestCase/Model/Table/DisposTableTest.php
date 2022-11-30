<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DisposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DisposTable Test Case
 */
class DisposTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DisposTable
     */
    public $Dispos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dispos',
        'app.annonces',
        'app.proprietaires',
        'app.lieugeos',
        'app.kmcomms',
        'app.kmcvils',
        'app.kmstats',
        'app.clics',
        'app.contrats',
        'app.photos',
        'app.reservations',
        'app.utilisateurs',
        'app.packs',
        'app.packs_reservations',
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
        $config = TableRegistry::exists('Dispos') ? [] : ['className' => 'App\Model\Table\DisposTable'];
        $this->Dispos = TableRegistry::get('Dispos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Dispos);

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
