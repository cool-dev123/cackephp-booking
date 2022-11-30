<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BibliothequesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BibliothequesTable Test Case
 */
class BibliothequesTableTest extends TestCase
{

    /**
     * Test subject     *
     * @var \App\Model\Table\BibliothequesTable     */
    public $Bibliotheques;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bibliotheques',
        'app.residences'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Bibliotheques') ? [] : ['className' => 'App\Model\Table\BibliothequesTable'];        $this->Bibliotheques = TableRegistry::get('Bibliotheques', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bibliotheques);

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
