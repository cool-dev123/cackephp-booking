<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HotelsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HotelsTable Test Case
 */
class HotelsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\HotelsTable
     */
    public $Hotels;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.hotels',
        'app.cities',
        'app.adultprices',
        'app.chambrepromos',
        'app.childprices',
        'app.children',
        'app.config_mail_news_letters',
        'app.contacts',
        'app.documents',
        'app.duedates',
        'app.hotelcommissions',
        'app.hotelequipements',
        'app.hotelimages',
        'app.hotelpensions',
        'app.hotelreductions',
        'app.hotelroomequipements',
        'app.hotelrooms',
        'app.hotelsthemes',
        'app.hotelstos',
        'app.infohotelpluses',
        'app.minimumstaes',
        'app.pensions',
        'app.reservations',
        'app.roomavaiblebonus',
        'app.roomavaibles',
        'app.roomcapacities',
        'app.rooms',
        'app.secondaryhotelpictures',
        'app.supplementhotels',
        'app.themes',
        'app.totalrooms'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Hotels') ? [] : ['className' => 'App\Model\Table\HotelsTable'];
        $this->Hotels = TableRegistry::get('Hotels', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Hotels);

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
