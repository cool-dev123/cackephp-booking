<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BlocMailGestionnairesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BlocMailGestionnairesTable Test Case
 */
class BlocMailGestionnairesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BlocMailGestionnairesTable
     */
    public $BlocMailGestionnaires;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bloc_mail_gestionnaires',
        'app.gestionnaires'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BlocMailGestionnaires') ? [] : ['className' => BlocMailGestionnairesTable::class];
        $this->BlocMailGestionnaires = TableRegistry::get('BlocMailGestionnaires', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BlocMailGestionnaires);

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
