<?php
namespace App\Test\TestCase\Shell;

use App\Shell\FunctionsCronFiveMinShell;
use Cake\TestSuite\ConsoleIntegrationTestCase;

/**
 * App\Shell\FunctionsCronFiveMinShell Test Case
 */
class FunctionsCronFiveMinShellTest extends ConsoleIntegrationTestCase
{

    /**
     * ConsoleIo mock
     *
     * @var \Cake\Console\ConsoleIo|\PHPUnit_Framework_MockObject_MockObject
     */
    public $io;

    /**
     * Test subject
     *
     * @var \App\Shell\FunctionsCronFiveMinShell
     */
    public $FunctionsCronFiveMin;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();
        $this->FunctionsCronFiveMin = new FunctionsCronFiveMinShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FunctionsCronFiveMin);

        parent::tearDown();
    }

    /**
     * Test getOptionParser method
     *
     * @return void
     */
    public function testGetOptionParser()
    {
        $this->markTestIncomplete('Not implemented yet.');
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
