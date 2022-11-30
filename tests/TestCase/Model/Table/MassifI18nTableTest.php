<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MassifI18nTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MassifI18nTable Test Case
 */
class MassifI18nTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MassifI18nTable
     */
    public $MassifI18n;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.massif_i18n'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MassifI18n') ? [] : ['className' => MassifI18nTable::class];
        $this->MassifI18n = TableRegistry::get('MassifI18n', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MassifI18n);

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
