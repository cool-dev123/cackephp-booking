<?php
namespace App\Test\TestCase\Shell;

use App\Shell\SendmailtestShell;
use Cake\TestSuite\TestCase;

/**
 * App\Shell\SendmailtestShell Test Case
 */
class SendmailtestShellTest extends TestCase
{

    /**
     * ConsoleIo mock     *
     * @var \Cake\Console\ConsoleIo|\PHPUnit_Framework_MockObject_MockObject     */
    public $io;

    /**
     * Test subject     *
     * @var \App\Shell\SendmailtestShell     */
    public $Sendmailtest;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMock('Cake\Console\ConsoleIo');        $this->Sendmailtest = new SendmailtestShell($this->io);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Sendmailtest);

        parent::tearDown();
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testMain()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
