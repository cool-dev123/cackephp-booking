<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link type="text/css" rel="stylesheet" href="<?php echo $this->Url->build('/',true)?>js/lity-2.3.1/dist/lity.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <style>
            body {height:100%; width: 100%; margin:0; position:absolute; }
            
            .hidden{
                display:none;
            }
            #contentNotice{
                text-align: center;
            }
            .showCamButton{
                margin-left: 2%;
            }
            #map{
                width:100%;
            }
            .tipsInfo{
                margin-left: 1%; margin-right: 1%;
                padding: 10px;
                text-align: center;
                border-radius: 5px;
                background-color: #332F2E;
                color: white;
                cursor: pointer;
            }
            .orange{
                color: #FF8700;
            }
            .tipsInfo h3{
                margin-top: 10px !important;
            }
            .tipsInfo span{
                float: right;
                position: inherit;
            }
            @media screen and (max-width: 1000px) {
                h2.firstHeading {
                    font-size: 16px;
                }
                button.showCamButton{
                    font-size: 12px;
                }
            }
            @media screen and (max-width: 1500px) and (min-width: 1001px) {
                h2.firstHeading {
                    font-size: 18px;
                }
                button.showCamButton{
                    font-size: 13px;
                }
            }
            @media screen and (min-width: 1501px) {
                h2.firstHeading {
                    font-size: 20px;
                }
                button.showCamButton{
                    font-size: 12px;
                }
            }
            @media screen and (min-width: 534px) {
                .orange{
                    margin-bottom: 7px;
                }
            }
            table{
                margin: auto;
            }
            .flex{
                margin-top: 10px;
                display: flex;
                margin-bottom: 10px;
                margin-right: 5px;
            }
            .ml-16{
                margin-left: 16px;
                margin-top: 1%;
                margin-right: 5px;
            }
            /*select*/
            select {
                -webkit-appearance: none;
                -moz-appearance: none;
                -ms-appearance: none;
                appearance: none;
                outline: 0;
                box-shadow: none;
                border: 0 !important;
                background: #332F2E;
                background-image: none;
            }
              /* Custom Select */
            .select {
                position: relative;
                display: block;
                width: 20em;
                height: 3em;
                line-height: 3;
                background: #332F2E;
                overflow: hidden;
                border-radius: .25em;
            }
            select {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0 0 0 .5em;
                color: #fff;
                cursor: pointer;
            }
            select::-ms-expand {
                display: none;
            }
              /* Arrow */
            .select::after {
                content: '\25BC';
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                padding: 0 1em;
                background: #332F2E;
                pointer-events: none;
                color: #FF8700;
            }
              /* Transition */
            .select:hover::after {
                color: white;
            }
            .select::after {
                -webkit-transition: .25s all ease;
                -o-transition: .25s all ease;
                transition: .25s all ease;
            }
            
        </style>
    </head>
    <body>
        <div id="header">
            <div onclick="hide(this)" class="tipsInfo">
                <span>x</span>
                <table>
                    <tr>
                        <td>
                            <i class="fa fa-info-circle fa-2x orange"></i>
                        </td>
                        <td>
                            <h3> Vous pouvez agrandir la carte pour voir plus de caméras</h3>
                        </td>
                    </tr>
                </table>
                
            </div>
            <div class="row flex">
                <label class="ml-16">Choisir une section : </label>
                <div class="input select">
                    <select size="auto" class="form-control" id="palce">
                        <?php foreach ($places as $place=>$value): ?>
                            <option value="<?=$place?>"><?=$place?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div id="map"></div>
      

        <!-- jQuery -->
        <script src="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&amp;callback=initMap" async="async" defer="defer"></script>
        
        <script src="<?php echo $this->Url->build('/',true)?>js/lity-2.3.1/dist/lity.js"></script>
        <script>
        var markers = [];
        var infowindows = [];
        var contentStrings = [];
        var map;
        var opened=null;
        var icon="<?php echo $this->Url->build('/',true)?>images/cctv.png";
        var places =[] ;
        <?php foreach ($places as $place=>$value): ?>
            var place=[];
            place['location']= {lat: <?=$value['lat']?>, lng: <?=$value['lng']?>};
            place['zoom']= <?=$value['zoom']?>;
            places["<?= $place?>"]=place
        <?php endforeach; ?>
            function initMap() {
                var uluru = places['tous']['location'];
                    map = new google.maps.Map(document.getElementById('map'), {
                    zoom: places['tous']['zoom'],
                    center: uluru,
                    streetViewControl: false,
                    fullscreenControl: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    styles:[
                              {
                                "elementType": "geometry",
                                "stylers": [
                                  {
                                    "color": "#f5f5f5"
                                  }
                                ]
                              },
                              {
                                "elementType": "labels.icon",
                                "stylers": [
                                  {
                                    "visibility": "on"
                                  }
                                ]
                              },
                              {
                                "elementType": "labels.text.fill",
                                "stylers": [
                                  {
                                    "color": "#616161"
                                  }
                                ]
                              },
                              {
                                "elementType": "labels.text.stroke",
                                "stylers": [
                                  {
                                    "color": "#f5f5f5"
                                  }
                                ]
                              },
                              {
                                "featureType": "administrative.land_parcel",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                  {
                                    "color": "#bdbdbd"
                                  }
                                ]
                              },
                              {
                                "featureType": "poi",
                                "elementType": "geometry",
                                "stylers": [
                                  {
                                    "color": "#eeeeee"
                                  }
                                ]
                              },
                              {
                                "featureType": "poi",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                  {
                                    "color": "#757575"
                                  }
                                ]
                              },
                              {
                                "featureType": "poi.park",
                                "elementType": "geometry",
                                "stylers": [
                                  {
                                    "color": "#e5e5e5"
                                  }
                                ]
                              },
                              {
                                "featureType": "poi.park",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                  {
                                    "color": "#9e9e9e"
                                  }
                                ]
                              },
                              {
                                "featureType": "road",
                                "elementType": "geometry",
                                "stylers": [
                                  {
                                    "color": "#ffffff"
                                  }
                                ]
                              },
                              {
                                "featureType": "road.arterial",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                  {
                                    "color": "#757575"
                                  }
                                ]
                              },
                              {
                                "featureType": "road.highway",
                                "elementType": "geometry",
                                "stylers": [
                                  {
                                    "color": "#dadada"
                                  }
                                ]
                              },
                              {
                                "featureType": "road.highway",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                  {
                                    "color": "#616161"
                                  }
                                ]
                              },
                              {
                                "featureType": "road.local",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                  {
                                    "color": "#9e9e9e"
                                  }
                                ]
                              },
                              {
                                "featureType": "transit.line",
                                "elementType": "geometry",
                                "stylers": [
                                  {
                                    "color": "#e5e5e5"
                                  }
                                ]
                              },
                              {
                                "featureType": "transit.station",
                                "elementType": "geometry",
                                "stylers": [
                                  {
                                    "color": "#eeeeee"
                                  }
                                ]
                              },
                              {
                                "featureType": "water",
                                "stylers": [
                                  {
                                    "color": "#3cacff"
                                  },
                                  {
                                    "visibility": "on"
                                  }
                                ]
                              },
                              {
                                "featureType": "water",
                                "elementType": "geometry",
                                "stylers": [
                                  {
                                    "color": "#c9c9c9"
                                  }
                                ]
                              },
                              {
                                "featureType": "water",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                  {
                                    "color": "#9e9e9e"
                                  }
                                ]
                              }
                    ]
                });
                <?php foreach ($cams as $cam): ?>
                var marker = new google.maps.Marker({
                    position: {lat: <?= $cam['lat'] ?>, lng: <?= $cam['lng'] ?>},
                    map: map,
                    title: '<?= $cam['titre'] ?>',
                    animation: google.maps.Animation.DROP,
                    icon: icon
                });
                markers["<?= $cam['titre'] ?>"]=marker;

                var contentString = '<div id="contentNotice" style="contentNotice">'+
                    '<h2 id="firstHeading" class="firstHeading"><?= $cam['titre'] ?></h2>'+
                    '<p>Direction : <?= $cam['direction'] ?>'+
                    '</p>'+
                    '<button type="buton" data-target="#popup_contact" data-url="<?= $cam['url'] ?>" class="btn btn-warning hvr-sweep-to-top showCamButton">Afficher webcam</button>'+
                    '</div>'+
                    '</div>';
                contentStrings["<?= $cam['titre'] ?>"]=contentString;
                var infowindow = new google.maps.InfoWindow({
                  content: contentStrings["<?= $cam['titre'] ?>"],
                  minWidth: 300
                });
                infowindows["<?= $cam['titre'] ?>"]=infowindow;

                markers["<?= $cam['titre'] ?>"].addListener('click', function() {
                    if(opened!=null){
                        opened.close();
                    }
                    infowindows["<?= $cam['titre'] ?>"].open(map, markers["<?= $cam['titre'] ?>"]);
                    opened = infowindows["<?= $cam['titre'] ?>"];
                });

                // Add the circle for this city to the map.
                  var cityCircle = new google.maps.Circle({
                    strokeColor: '#74B9FF',
                    strokeWeight: 0,
                    fillColor: '#74B9FF',
                    fillOpacity: 0.20,
                    map: map,
                    center: {lat: <?= $cam['lat'] ?>, lng: <?= $cam['lng'] ?>},
                    radius: 5700
                  });

                <?php endforeach; ?>
            }
            $( document ).ready(function() {
                resizeMap();
                $('#palce').change(function (){
                    map.setCenter(places[$(this).val()]['location']);
                    map.setZoom(places[$(this).val()]['zoom']);
                });
                $(document).on('click', ".showCamButton", function () {
                    var lightbox = lity("<?php echo $this->Url->build('/',true)?>camVideo?link="+$(this).attr('data-url'));
                    $(document).on('click', '[data-lightbox]', lity);
                    if(opened!=null){
                        opened.close();
                    }
                    opened=null;
                });
            });
            $( window ).resize(function() {
                resizeMap();
            });
            function resizeMap(){
                $('#map').height($('body').height()-$('#header').height()-10);
            }
            function hide(object){
                $(object).addClass('hidden');
                resizeMap();
            }
        </script>
    </body>
</html>
