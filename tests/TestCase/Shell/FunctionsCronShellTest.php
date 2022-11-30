<?php
namespace App\Test\TestCase\Shell;

use App\Shell\FunctionsCronShell;
use Cake\TestSuite\TestCase;

/**
 * App\Shell\FunctionsCronShell Test Case
 */
class FunctionsCronShellTest extends TestCase
{

    /**
     * ConsoleIo mock     *
     * @var \Cake\Console\ConsoleIo|\PHPUnit_Framework_MockObject_MockObject     */
    public $io;

    /**
     * Test subject     *
     * @var \App\Shell\FunctionsCronShell     */
    public $FunctionsCron;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMock('Cake\Console\ConsoleIo');        $this->FunctionsCron = new FunctionsCronShell($this->io);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FunctionsCron);

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
