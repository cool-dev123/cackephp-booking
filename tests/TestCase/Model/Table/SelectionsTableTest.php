<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SelectionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SelectionsTable Test Case
 */
class SelectionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SelectionsTable
     */
    public $Selections;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.selections',
        'app.utilisateurs',
        'app.annonces',
        'app.proprietaires',
        'app.lieugeos',
        'app.kmcomms',
        'app.kmcvils',
        'app.kmstats',
        'app.clics',
        'app.contrats',
        'app.dispos',
        'app.reservations',
        'app.packs',
        'app.packs_reservations',
        'app.photos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Selections') ? [] : ['className' => 'App\Model\Table\SelectionsTable'];
        $this->Selections = TableRegistry::get('Selections', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Selections);

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
