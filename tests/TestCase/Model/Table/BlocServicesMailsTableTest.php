<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BlocServicesMailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BlocServicesMailsTable Test Case
 */
class BlocServicesMailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BlocServicesMailsTable
     */
    public $BlocServicesMails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bloc_services_mails'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BlocServicesMails') ? [] : ['className' => BlocServicesMailsTable::class];
        $this->BlocServicesMails = TableRegistry::get('BlocServicesMails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BlocServicesMails);

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
