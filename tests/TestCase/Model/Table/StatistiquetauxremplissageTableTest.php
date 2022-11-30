<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StatistiquetauxremplissageTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StatistiquetauxremplissageTable Test Case
 */
class StatistiquetauxremplissageTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StatistiquetauxremplissageTable
     */
    public $Statistiquetauxremplissage;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.statistiquetauxremplissage'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Statistiquetauxremplissage') ? [] : ['className' => StatistiquetauxremplissageTable::class];
        $this->Statistiquetauxremplissage = TableRegistry::get('Statistiquetauxremplissage', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Statistiquetauxremplissage);

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
