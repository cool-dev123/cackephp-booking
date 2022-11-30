<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FeedbackresponsesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FeedbackresponsesTable Test Case
 */
class FeedbackresponsesTableTest extends TestCase
{

    /**
     * Test subject     *
     * @var \App\Model\Table\FeedbackresponsesTable     */
    public $Feedbackresponses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.feedbackresponses',
        'app.utilisateurs',
        'app.feedback'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Feedbackresponses') ? [] : ['className' => 'App\Model\Table\FeedbackresponsesTable'];        $this->Feedbackresponses = TableRegistry::get('Feedbackresponses', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Feedbackresponses);

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
