<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UrlmultilingueTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UrlmultilingueTable Test Case
 */
class UrlmultilingueTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UrlmultilingueTable
     */
    public $Urlmultilingue;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.urlmultilingue'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Urlmultilingue') ? [] : ['className' => UrlmultilingueTable::class];
        $this->Urlmultilingue = TableRegistry::get('Urlmultilingue', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Urlmultilingue);

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
