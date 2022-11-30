<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UtilisateursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UtilisateursTable Test Case
 */
class UtilisateursTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UtilisateursTable
     */
    public $Utilisateurs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.utilisateurs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Utilisateurs') ? [] : ['className' => 'App\Model\Table\UtilisateursTable'];
        $this->Utilisateurs = TableRegistry::get('Utilisateurs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Utilisateurs);

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
