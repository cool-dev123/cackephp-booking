<?php
namespace App\Test\TestCase\Shell;

use App\Shell\FunctionsGoogleSheetCatalogueShell;
use Cake\TestSuite\ConsoleIntegrationTestCase;

/**
 * App\Shell\FunctionsGoogleSheetCatalogueShell Test Case
 */
class FunctionsGoogleSheetCatalogueShellTest extends ConsoleIntegrationTestCase
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
     * @var \App\Shell\FunctionsGoogleSheetCatalogueShell
     */
    public $FunctionsGoogleSheetCatalogue;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();
        $this->FunctionsGoogleSheetCatalogue = new FunctionsGoogleSheetCatalogueShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FunctionsGoogleSheetCatalogue);

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
