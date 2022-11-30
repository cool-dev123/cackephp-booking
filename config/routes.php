<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;
use Cake\Routing\RouteBuilder;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('DashedRoute');

$routerCallback = function (RouteBuilder $routes) {
// Router::scope('/', function ($routes) {
    /**
    * Here, we are connecting '/' (base path) to a controller called 'Pages',
    * its action called 'display', and we pass a param to select the view file
    * to use (in this case, src/Template/Pages/home.ctp)...
    */
    $routes->extensions(['json', 'xml']);

    /*
     *Utilisateurs
     */
    $routes->connect('/utilisateurs/confirmer/:token',['controller' => 'Utilisateurs', 'action' => 'confirmuser'])->setPass(['token']);
    $routes->connect('/utilisateurs/connexion', ['controller' => 'Utilisateurs', 'action' => 'connexion']);
    $routes->connect('/utilisateurs/captcha', ['controller' => 'Utilisateurs', 'action' => 'captcha']);
    $routes->connect('/utilisateurs/logout', ['controller' => 'Utilisateurs', 'action' => 'logout']);
    $routes->connect('/utilisateurs/index/*', ['controller' => 'Utilisateurs', 'action' => 'index']);
    $routes->connect('/utilisateurs/', ['controller' => 'Utilisateurs', 'action' => 'index']);
    $routes->connect('/utilisateurs/locataire_index/*', ['controller' => 'Utilisateurs', 'action' => 'locataireIndex']);
    $routes->connect('/utilisateurs/view/*', ['controller' => 'Utilisateurs', 'action' => 'view']);
    $routes->connect('/utilisateurs/add/*', ['controller' => 'Utilisateurs', 'action' => 'add']);
    $routes->connect('/utilisateurs/animateur/*', ['controller' => 'Utilisateurs', 'action' => 'animateur']);
    $routes->connect('/utilisateurs/edit/', ['controller' => 'Utilisateurs', 'action' => 'edit']);
    $routes->connect('/utilisateurs/changemdp/*', ['controller' => 'Utilisateurs', 'action' => 'changemdp']);
    $routes->connect('/utilisateurs/delete/*', ['controller' => 'Utilisateurs', 'action' => 'delete']);
    $routes->connect('/utilisateurs/erreurconnexion/*', ['controller' => 'Utilisateurs', 'action' => 'erreurconnexion']);
    $routes->connect('/utilisateurs/ouvrircompte/*', ['controller' => 'Utilisateurs', 'action' => 'ouvrircompte']);
    $routes->connect('/utilisateurs/mdpPerdu', ['controller' => 'Utilisateurs', 'action' => 'mdpPerdu']);
    $routes->connect('/utilisateurs/nouveauMdp/*', ['controller' => 'Utilisateurs', 'action' => 'nouveauMdp']);
    $routes->connect('/utilisateurs/changeMail/*', ['controller' => 'Utilisateurs', 'action' => 'changeMail']);
    $routes->connect('/manager', ['controller' => 'Utilisateurs', 'action' => 'loginmanager']);
    $routes->connect('/utilisateurs/authmanager/*', ['controller' => 'Utilisateurs', 'action' => 'authmanager']);
    $routes->connect('/utilisateurs/delMessage', ['controller' => 'Utilisateurs', 'action' => 'delMessage']);
    $routes->connect('/utilisateurs/getarraypaysvilles', ['controller' => 'Utilisateurs', 'action' => 'getarraypaysvilles']);
    $routes->connect('/utilisateurs/getarrayregionfrance', ['controller' => 'Utilisateurs', 'action' => 'getarrayregionfrance']);
    $routes->connect('/utilisateurs/getarrayfrancevilles', ['controller' => 'Utilisateurs', 'action' => 'getarrayfrancevilles']);
    $routes->connect('/utilisateurs/getuserinfos', ['controller' => 'Utilisateurs', 'action' => 'getuserinfos']);
    $routes->connect('/utilisateurs/detailmessage/*', ['controller' => 'Utilisateurs', 'action' => 'detailmessage']);
    $routes->connect('/utilisateurs/repondremessageprop/*', ['controller' => 'Utilisateurs', 'action' => 'repondremessageprop']);
    $routes->connect('/utilisateurs/renvoiemailconfirmation/', ['controller' => 'Utilisateurs', 'action' => 'renvoiemailconfirmation']);
    $routes->connect('/utilisateurs/infobancaire/*', ['controller' => 'Utilisateurs', 'action' => 'infobancaire']);
    $routes->connect('/utilisateurs/changearchived', ['controller' => 'Utilisateurs', 'action' => 'changearchived']);
    $routes->connect('/utilisateurs/changereadstatus', ['controller' => 'Utilisateurs', 'action' => 'changereadstatus']);
    $routes->connect('/utilisateurs/getchats', ['controller' => 'Utilisateurs', 'action' => 'getchats']);

/*->setPatterns([
'lang' => 'en|fr',
])->setPersist(['lang']);*/

    /**
     * Annonces
     */
    $routes->connect('/', ['controller' => 'Annonces', 'action' => 'landing']);
    $routes->connect('/station/:nom', ['controller' => 'Annonces', 'action' => 'station'])->setPass(['nom']);
    $routes->connect('/station/:nom/:type', ['controller' => 'Annonces', 'action' => 'recherchebytype'])->setPass(['nom', 'type']);
    $routes->connect('/station/:nom/:type/:id_:slug', ['controller' => 'Annonces', 'action' => 'view'])->setPass(['id']);
    $routes->connect('/station/:nom/:type/:id_:slug/:send', ['controller' => 'Annonces', 'action' => 'view'])->setPass(['id']);
    $routes->connect('/station/:nom/:type/:id_:slug/:debutrech/:finrech', ['controller' => 'Annonces', 'action' => 'view'])->setPass(['id','debutrech','finrech']);
    $routes->connect('/station/:nom/:type/:id_:slug/:debutrech/:finrech/:nbradlt/:nbrenf', ['controller' => 'annonces', 'action' => 'view'])->setPass(['id','debutrech','finrech','nbradlt','nbrenf']);
    $routes->connect('/station/:nom/:type/:id_:slug/:debutrech/:finrech/:nbradlt/:nbrenf/:animaux', ['controller' => 'annonces', 'action' => 'view'])->setPass(['id','debutrech','finrech','nbradlt','nbrenf','animaux']);
    $routes->connect('/station/:nom/:type/:id/:debutrech/:finrech/:nbradlt/:nbrenf', ['controller' => 'annonces', 'action' => 'view'])->setPass(['id','debutrech','finrech','nbradlt','nbrenf']);
    $routes->connect('/station/:nom/:type/:id/:debutrech/:finrech/:nbradlt/:nbrenf/:animaux', ['controller' => 'annonces', 'action' => 'view'])->setPass(['id','debutrech','finrech','nbradlt','nbrenf','animaux']);
    $routes->connect('/massif/:nom', ['controller' => 'Annonces', 'action' => 'massif'])->setPass(['nom']);
    //   $routes->connect('/residence/:nom', ['controller' => 'Annonces', 'action' => 'residence'])->setPass(['nom']);
    $routes->connect('/galery/*', ['controller' => 'Annonces', 'action' => 'galery']);
    $routes->connect('/webcam/*', ['controller' => 'Annonces', 'action' => 'webcam']);
    $routes->connect('/sejour-ski-tout-compris', ['controller' => 'Annonces', 'action' => 'explicationpub']);
    $routes->connect('/val-d-allos', ['controller' => 'Annonces', 'action' => 'valdlanding']);
    $routes->connect('/les-arcs', ['controller' => 'Annonces', 'action' => 'lesarcslanding']);
    $routes->connect('/montchavin-les-coches', ['controller' => 'Annonces', 'action' => 'montchavinlescocheslanding']);
    $routes->connect('/detail/*', ['controller' => 'annonces', 'action' => 'redirectionNewView']);
    $routes->connect('/annonces/detail/*', ['controller' => 'annonces', 'action' => 'redirectionNewView']);
    $routes->connect('/annonces/view/*', ['controller' => 'annonces', 'action' => 'redirectionNewView']);
    $routes->connect('/viewprev/*', ['controller' => 'annonces', 'action' => 'viewprev']);
    $routes->connect('/annonces/wsdl', ['controller' => 'annonces', 'action' => 'wsdl']);
    $routes->connect('/annonces/service', ['controller' => 'annonces', 'action' => 'service']);
    $routes->connect('/annonces/rest/*', ['controller' => 'annonces', 'action' => 'rest']);
    $routes->connect('/annonces/liste', ['controller' => 'annonces', 'action' => 'liste']);
    $routes->connect('/annonces/depot_annonce', ['controller' => 'annonces', 'action' => 'depotannonce']);
    $routes->connect('/recherche', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/sitemap', ['controller' => 'annonces', 'action' => 'sitemap']);
    $routes->connect('/annonces/getimage/*', ['controller' => 'annonces', 'action' => 'getimage']);
    $routes->connect('/annonces/add/*', ['controller' => 'annonces', 'action' => 'add']);
    $routes->connect('/annonces/edit/*', ['controller' => 'annonces', 'action' => 'edit']);
    $routes->connect('/annonces/edit2/*', ['controller' => 'annonces', 'action' => 'edit2']);
    $routes->connect('/annonces/photo/*', ['controller' => 'annonces', 'action' => 'photo']);
    $routes->connect('/annonces/getresidence/*', ['controller' => 'annonces', 'action' => 'getresidence']);
    $routes->connect('/annonces/statistique/*', ['controller' => 'annonces', 'action' => 'statistique']);
    $routes->connect('/annonces/prop/*', ['controller' => 'annonces', 'action' => 'prop']);
    $routes->connect('/annonces/contact/*', ['controller' => 'annonces', 'action' => 'contact']);
    $routes->post('/annonces/annonce_delete', ['controller' => 'annonces', 'action' => 'annoncedelete']);
    $routes->post('/annonces/inscriptionnewslettre', ['controller' => 'annonces', 'action' => 'inscriptionnewslettre']);
    $routes->post('/annonces/uploadinventairelocataire/:id', ['controller' => 'annonces', 'action' => 'uploadinventairelocataire'])->setPass(['id']);
    $routes->connect('/montagne-mon-trip-location-de-vacances-savoie-haute-savoie', ['controller' => 'annonces', 'action' => 'pagesavoie']);
    $routes->connect('/ski-marrange-sejour-flexible-en-savoie-mont-blanc', ['controller' => 'annonces', 'action' => 'pagesavoiemontblanc']);
    $routes->connect('/appartement-les-arcs-1600', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/chalet-les-arcs-1600', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/gite-les-arcs-1600', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/studio-les-arcs-1600', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/villa-les-arcs-1600', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/appartement-les-arcs-1800-chantel', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/chalet-les-arcs-1800-chantel', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/gite-les-arcs-1800-chantel', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/studio-les-arcs-1800-chantel', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/villa-les-arcs-1800-chantel', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/appartement-les-arcs-1800-charmettoger', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/chalet-les-arcs-1800-charmettoger', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/gite-les-arcs-1800-charmettoger', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/studio-les-arcs-1800-charmettoger', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/villa-les-arcs-1800-charmettoger', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/appartement-les-arcs-1800-charvet', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/chalet-les-arcs-1800-charvet', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/gite-les-arcs-1800-charvet', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/studio-les-arcs-1800-charvet', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/villa-les-arcs-1800-charvet', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/appartement-les-arcs-1800-les-villards', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/chalet-les-arcs-1800-les-villards', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/gite-les-arcs-1800-les-villards', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/studio-les-arcs-1800-les-villards', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/villa-les-arcs-1800-les-villards', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/appartement-les-arcs-1950', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/chalet-les-arcs-1950', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/gite-les-arcs-1950', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/studio-les-arcs-1950', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/villa-les-arcs-1950', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/appartement-les-arcs-2000', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/chalet-les-arcs-2000', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/gite-les-arcs-2000', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/studio-les-arcs-2000', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/villa-les-arcs-2000', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/appartement-bourg-st-maurice', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/chalet-bourg-st-maurice', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/gite-bourg-st-maurice', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/studio-bourg-st-maurice', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/villa-bourg-st-maurice', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/appartement-val-d-allos-foux', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/chalet-val-d-allos-foux', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/gite-val-d-allos-foux', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/studio-val-d-allos-foux', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/appartement-val-d-allos-seignus', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/chalet-val-d-allos-seignus', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/gite-val-d-allos-seignus', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/studio-val-d-allos-seignus', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/appartement-val-d-allos-village', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/chalet-val-d-allos-village', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/gite-val-d-allos-village', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/studio-val-d-allos-village', ['controller' => 'annonces', 'action' => 'recherche']);

    /**
     *reservations
     */
    $routes->connect('/reservations/reservations_proprietaire/*', ['controller' => 'reservations', 'action' => 'reservationsProprietaire']);
    $routes->connect('/reservations/add', ['controller' => 'reservations', 'action' => 'add']);
    $routes->connect('/reservations/edit/*', ['controller' => 'reservations', 'action' => 'edit']);
    $routes->connect('/reservations/delete/*', ['controller' => 'reservations', 'action' => 'delete']);
    $routes->connect('/reservations/confirmreservations', ['controller' => 'reservations', 'action' => 'confirmreservations']);
    $routes->connect('/reservations/annule/*', ['controller' => 'reservations', 'action' => 'annule']);
    $routes->connect('/reservations/view', ['controller' => 'reservations', 'action' => 'view']);
    $routes->connect('/reservations/getReservationProprietaire/*', ['controller' => 'reservations', 'action' => 'getReservationProprietaire']);
    $routes->connect('/reservations/editReservationProprietaire/*', ['controller' => 'reservations', 'action' => 'editReservationProprietaire']);
    $routes->connect('/reservations/getReservationLocataire/*', ['controller' => 'reservations', 'action' => 'getReservationLocataire']);
    $routes->connect('/reservations/getReservationLocataireOld/*', ['controller' => 'reservations', 'action' => 'getReservationLocataireOld']); //Remove when task is finished
    $routes->connect('/reservations/editReservationLocataire/*', ['controller' => 'reservations', 'action' => 'editReservationLocataire']);
    $routes->connect('/reservations/addReservationComment/*', ['controller' => 'reservations', 'action' => 'addReservationComment']);
    $routes->connect('/reservations/locataire_addres/*', ['controller' => 'reservations', 'action' => 'locataireAddres']);
    $routes->connect('/reservations/tarifdispo/*', ['controller' => 'reservations', 'action' => 'tarifdispo']);
    $routes->connect('/reservations/locataire_view/*', ['controller' => 'reservations', 'action' => 'locataireView']);
    $routes->connect('/reservations/locataire_view_old/*', ['controller' => 'reservations', 'action' => 'locataireViewOld']); //Remove when task is finished
    $routes->connect('/reservations/reservations_locataire/*', ['controller' => 'reservations', 'action' => 'reservationsLocataire']);
    $routes->connect('/reservations/validation', ['controller' => 'reservations', 'action' => 'validation']);
    $routes->connect('/reservations/deletereservation/*', ['controller' => 'reservations', 'action' => 'deletereservation']);
    $routes->connect('/reservations/deletereservationlocataire/*', ['controller' => 'reservations', 'action' => 'deletereservationlocataire']);
    $routes->connect('/reservations/deletereservationlocatairejustif/*', ['controller' => 'reservations', 'action' => 'deletereservationlocatairejustif']);
    $routes->connect('/reservations/blockreduction/', ['controller' => 'reservations', 'action' => 'blockreduction']);
    $routes->connect('/reservations/getdetailreservations/', ['controller' => 'reservations', 'action' => 'getdetailreservations']);
    $routes->connect('/reservations/reservationcalendar/', ['controller' => 'reservations', 'action' => 'reservationcalendar']);
    $routes->connect('/reservations/editreservationcalendar/*', ['controller' => 'reservations', 'action' => 'editreservationcalendar']);
    $routes->connect('/reservations/view_reservation/', ['controller' => 'reservations', 'action' => 'viewReservation']);
    $routes->connect('/reservations/edit_reservation_dates/*', ['controller' => 'reservations', 'action' => 'editReservationDates']);

    /**
     *dispos
     */
    $routes->connect('/dispos/view/*', ['controller' => 'dispos', 'action' => 'view']);
    $routes->connect('/dispos/add', ['controller' => 'dispos', 'action' => 'add']);
    $routes->connect('/dispos/edit/*', ['controller' => 'dispos', 'action' => 'edit']);
    $routes->connect('/dispos/delete/*', ['controller' => 'dispos', 'action' => 'delete']);
    $routes->connect('/dispos/delEchu/*', ['controller' => 'dispos', 'action' => 'delEchu']);
    $routes->connect('/dispos/delAll/*', ['controller' => 'dispos', 'action' => 'delAll']);
    $routes->connect('/dispos/calendarDispo/*', ['controller' => 'dispos', 'action' => 'calendarDispo']);
    $routes->connect('/dispos/calendarEdit', ['controller' => 'dispos', 'action' => 'calendarEdit']);
    $routes->connect('/dispos/calendarAdd', ['controller' => 'dispos', 'action' => 'calendarAdd']);
    $routes->connect('/dispos/calendarDispoLoc/*', ['controller' => 'dispos', 'action' => 'calendarDispoLoc']);
    $routes->connect('/dispos/chercherdisponibilite/*', ['controller' => 'dispos', 'action' => 'chercherdisponibilite']);
    $routes->connect('/dispos/chercherdisponibilite_tot/*', ['controller' => 'dispos', 'action' => 'chercherdisponibiliteTot']);
    $routes->connect('/dispos/exportical/*', ['controller' => 'dispos', 'action' => 'exportical']);
    $routes->connect('/dispos/calendarAddEarlyBooking', ['controller' => 'dispos', 'action' => 'calendarAddEarlyBooking']);
    $routes->connect('/dispos/calendarAddLastMinute', ['controller' => 'dispos', 'action' => 'calendarAddLastMinute']);
    $routes->connect('/dispos/calendarAddLongSejour', ['controller' => 'dispos', 'action' => 'calendarAddLongSejour']);

    /**
     *photos
     */
    $routes->connect('/photos/delete/*', ['controller' => 'photos', 'action' => 'delete']);
    $routes->connect('/photos/upload', ['controller' => 'photos', 'action' => 'upload']);

    /**
     *pages
     */
    $routes->connect('/infos-plans-stations.html', ['controller' => 'pages', 'action' => 'infosplansstations']);
    $routes->connect('/infos-station-arc-1600.html', ['controller' => 'pages', 'action' => 'infosstationarc1600']);
    $routes->connect('/infos-station-arc-1800.html', ['controller' => 'pages', 'action' => 'infosstationarc1800']);
    $routes->connect('/infos-station-arc-1950.html', ['controller' => 'pages', 'action' => 'infosstationarc1950']);
    $routes->connect('/infos-station-arc-2000.html', ['controller' => 'pages', 'action' => 'infosstationarc2000']);
    $routes->connect('/infos-ville-bourg-saint-maurice.html', ['controller' => 'pages', 'action' => 'infosvillebourgsaintmaurice']);
    $routes->connect('/fr-carte-et-calendrier-vacances-scolaires-europe', ['controller' => 'pages', 'action' => 'cartevacanceseuropeennes']);

    /**      *webcam      */
    $routes->connect('/routes', ['controller' => 'webcam', 'action' => 'index']);
    $routes->connect('/camVideo', ['controller' => 'webcam', 'action' => 'camvideo']);
    $routes->get('/routesMobile', ['controller' => 'webcam', 'action' => 'indexMobile']);

    /*
    * English translate routes
    */
    $routes->connect('/search', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/listings/search', ['controller' => 'annonces', 'action' => 'recherche']);
    $routes->connect('/resort/:nom', ['controller' => 'Annonces', 'action' => 'station'])->setPass(['nom']);
    $routes->connect('/resort/:nom/:type', ['controller' => 'Annonces', 'action' => 'recherchebytype'])->setPass(['nom', 'type']);
    $routes->connect('/resort/:nom/:type/:id_:slug', ['controller' => 'annonces', 'action' => 'view'])->setPass(['id']);
    $routes->connect('/resort/:nom/:type/:id_:slug/:send', ['controller' => 'annonces', 'action' => 'view'])->setPass(['id']);
    $routes->connect('/resort/:nom/:type/:id_:slug/:debutrech/:finrech', ['controller' => 'annonces', 'action' => 'view'])->setPass(['id','debutrech','finrech']);
    $routes->connect('/resort/:nom/:type/:id_:slug/:debutrech/:finrech/:nbradlt/:nbrenf', ['controller' => 'annonces', 'action' => 'view'])->setPass(['id','debutrech','finrech','nbradlt','nbrenf']);
    $routes->connect('/resort/:nom/:type/:id/:debutrech/:finrech/:nbradlt/:nbrenf', ['controller' => 'annonces', 'action' => 'view'])->setPass(['id','debutrech','finrech','nbradlt','nbrenf']);
    $routes->connect('/region/:nom', ['controller' => 'Annonces', 'action' => 'massif'])->setPass(['nom']);
    $routes->connect('/listings/contact/*', ['controller' => 'annonces', 'action' => 'contact']);
    $routes->connect('/listings/add/*', ['controller' => 'annonces', 'action' => 'add']);
    $routes->connect('/listings/edit/*', ['controller' => 'annonces', 'action' => 'edit']);
    $routes->connect('/listings/edit2/*', ['controller' => 'annonces', 'action' => 'edit2']);
    $routes->connect('/listings/photo/*', ['controller' => 'annonces', 'action' => 'photo']);
    $routes->connect('/listings/preview/*', ['controller' => 'annonces', 'action' => 'previsualiser']);
    $routes->connect('/listings/addlisting', ['controller' => 'annonces', 'action' => 'depotannonce']);
    $routes->connect('/listings/checkAppartementUnique/*', ['controller' => 'annonces', 'action' => 'checkAppartementUnique']);
    $routes->connect('/listings/checkEmailUnique/*', ['controller' => 'annonces', 'action' => 'checkEmailUnique']);
    $routes->connect('/listings/addnewsteps/*', ['controller' => 'annonces', 'action' => 'addnewsteps']);
    
    $routes->connect('/users', ['controller' => 'Utilisateurs', 'action' => 'index']);
    $routes->connect('/users/add', ['controller' => 'Utilisateurs', 'action' => 'add']);
    $routes->connect('/users/pwLost', ['controller' => 'Utilisateurs', 'action' => 'mdpPerdu']);
    $routes->connect('/users/errorconnection/*', ['controller' => 'Utilisateurs', 'action' => 'erreurconnexion']);
    $routes->connect('/users/dashboard', ['controller' => 'Utilisateurs', 'action' => 'locataireIndex']);
    $routes->connect('/users/edit/*', ['controller' => 'Utilisateurs', 'action' => 'edit']);
    $routes->connect('/users/openaccount', ['controller' => 'Utilisateurs', 'action' => 'ouvrircompte']);
    $routes->connect('/users/mymessages', ['controller' => 'Utilisateurs', 'action' => 'mesmessages']);
    $routes->connect('/users/detailmessage/*', ['controller' => 'Utilisateurs', 'action' => 'detailmessage']);
    $routes->connect('/users/listinglist/*', ['controller' => 'Utilisateurs', 'action' => 'listannonce']);
    $routes->connect('/users/bankinfo/*', ['controller' => 'Utilisateurs', 'action' => 'infobancaire']);
    $routes->connect('/users/index/*', ['controller' => 'Utilisateurs', 'action' => 'index']);
    $routes->connect('/availability/view/*', ['controller' => 'dispos', 'action' => 'view']);
    $routes->connect('/summer-2022-holidays-in-the-french-alps', ['controller' => 'annonces', 'action' => 'pagesavoie']);
    $routes->connect('/free-time-ski-time-flexible-ski-holiday-in-savoie-mont-blanc', ['controller' => 'annonces', 'action' => 'pagesavoiemontblanc']);
    $routes->connect('/reservations/tenant_view/*', ['controller' => 'reservations', 'action' => 'locataireView']);
    $routes->connect('/reservations/tenant_view_old/*', ['controller' => 'reservations', 'action' => 'locataireViewOld']); //Remove when task is finished
    $routes->connect('/reservations/tenant_adres/*', ['controller' => 'reservations', 'action' => 'locataireAddres']);
	
    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */

    $routes->fallbacks('DashedRoute');
// });
};

// support only for 3 languages, other language will throw 404/NotFoundException
// or will cause different routing problem based on your routes
Router::scope('/', $routerCallback);
foreach (["en", "fr"] as $language) {
    Router::scope('/' . $language, ['language' => $language], $routerCallback);
}

Router::prefix('manager', function ($routes) {
	$routes->extensions(['json', 'xml']);
	$routes->prefix('sations', function ($routes) {
		$routes->fallbacks('DashedRoute');
		$routes->resources('/manager/sations/massif', ['controller' => 'Massif']);
	});
      $routes->connect('/manager/arrivees/', ['controller' => 'Arrivees', 'action' => 'index']);
      $routes->connect('/manager/full-calendar', ['controller' => 'FullCalendar']);
      $routes->connect('/manager/full-calendar/index', ['controller' => 'FullCalendar', 'action' => 'index']);
      $routes->connect('/manager/events', ['controller' => 'Events', 'action' => 'index']);
      $routes->connect('/manager/events/index', ['controller' => 'Events', 'action' => 'index']);
      $routes->connect('/manager/events/download', ['controller' => 'Events', 'action' => 'download']);
      $routes->connect('/manager/events/add', ['controller' => 'Events', 'action' => 'add']);
      $routes->connect('/manager/events/feed', ['controller' => 'Events', 'action' => 'feed']);
      $routes->connect('/manager/events/view/*', ['controller' => 'Events', 'action' => 'view']);
      $routes->connect('/manager/events/edit/*', ['controller' => 'Events', 'action' => 'edit']);
      $routes->connect('/manager/events/delete/*', ['controller' => 'Events', 'action' => 'delete']);
      $routes->connect('/manager/events/update/*', ['controller' => 'Events', 'action' => 'update']);
      $routes->connect('/manager/event-types', ['controller' => 'EventTypes', 'action' => 'index']);
      $routes->connect('/manager/event-types/index', ['controller' => 'EventTypes', 'action' => 'index']);
      $routes->connect('/manager/event-types/add', ['controller' => 'EventTypes', 'action' => 'add']);
      $routes->connect('/manager/event-types/view/*', ['controller' => 'EventTypes', 'action' => 'view']);
      $routes->connect('/manager/event-types/edit/*', ['controller' => 'EventTypes', 'action' => 'edit']);
      $routes->connect('/manager/event-types/delete/*', ['controller' => 'EventTypes', 'action' => 'delete']);
      $routes->connect('/manager/pages/*', ['plugin' => null, 'controller' => 'Pages', 'action' => 'display']);
      
      $routes->get('/parametrage/gps', ['controller' => 'Gps', 'action' => 'index']);
    $routes->get('/parametrage/gps/add', ['controller' => 'Gps', 'action' => 'add']);
    $routes->post('/parametrage/gps/add', ['controller' => 'Gps', 'action' => 'add']);
    $routes->get('/parametrage/gps/edit/:id', ['controller' => 'Gps', 'action' => 'edit'])->setPass(['id']);
    $routes->post('/parametrage/gps/edit/:id', ['controller' => 'Gps', 'action' => 'edit'])->setPass(['id']);
    $routes->delete('/parametrage/gps/delete/:id', ['controller' => 'Gps', 'action' => 'delete'])->setPass(['id']);
    
    $routes->get('/routes', ['controller' => 'webcam', 'action' => 'index']);
      
      $routes->fallbacks('DashedRoute');
    //$routes->fallbacks('InflectedRoute');

});

Router::scope('/api', function ($routes) {
    $routes->extensions(['json','xml']);
    $routes->get('/get_partners', ['controller' => 'Gps', 'action' => 'getResidances', 'prefix' => 'manager']);
    $routes->post('/get_location_user', ['controller'=>'Webservices','action'=>'getconnection']);
});

//-----------Changes on 22-02-07--------
	Router::connect(
	    '/service/eventsFeed',
	    array('controller' => 'Webservice', 'action' => 'feedService')
	);

	Router::connect(
	    '/service/eventsInsertFeed',
	    array('controller' => 'Webservice', 'action' => 'feedInsertService')
	);

	//----------Changes on 01-03-17---------
	Router::connect(
	    '/calendrier/report',
	    array('controller' => 'Report', 'action' => 'view')
	);
/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
