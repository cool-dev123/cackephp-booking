<?php
namespace App\Test\TestCase\Controller;

use App\Controller\HotelsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\HotelsController Test Case
 */
class HotelsControllerTest extends IntegrationTestCase
{

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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
