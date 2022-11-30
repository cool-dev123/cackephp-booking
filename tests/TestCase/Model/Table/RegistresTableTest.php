<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegistresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegistresTable Test Case
 */
class RegistresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RegistresTable
     */
    public $Registres;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.registres'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Registres') ? [] : ['className' => 'App\Model\Table\RegistresTable'];
        $this->Registres = TableRegistry::get('Registres', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Registres);

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
