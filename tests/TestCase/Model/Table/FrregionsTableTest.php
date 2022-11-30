<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FrregionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FrregionsTable Test Case
 */
class FrregionsTableTest extends TestCase
{

    /**
     * Test subject     *
     * @var \App\Model\Table\FrregionsTable     */
    public $Frregions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.frregions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Frregions') ? [] : ['className' => 'App\Model\Table\FrregionsTable'];        $this->Frregions = TableRegistry::get('Frregions', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Frregions);

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
