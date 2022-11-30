<?php
namespace App\Test\TestCase\Shell;

use App\Shell\ModifGroupeShell;
use Cake\TestSuite\ConsoleIntegrationTestCase;

/**
 * App\Shell\ModifGroupeShell Test Case
 */
class ModifGroupeShellTest extends ConsoleIntegrationTestCase
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
     * @var \App\Shell\ModifGroupeShell
     */
    public $ModifGroupeShell;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();
        $this->ModifGroupeShell = new ModifGroupeShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ModifGroupeShell);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
