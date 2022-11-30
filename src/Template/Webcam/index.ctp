<?php $this->assign('title', __('Sur la route des vacances | Trafic routier dans les Alpes du Nord')); ?>
<?php $this->Html->meta(null, null, ['property' => 'og:title','content' => __('Sur la route des vacances | Trafic routier dans les Alpes du Nord'),'block' => 'meta']); ?>
<?php $this->Html->meta(null, null, ['name' => 'description','content' => __("Webcam du trafic en direct - Avant de prendre la route, consultez l'aperçu de la circulation, en temps réel.") ,'block' => 'meta']); ?>

<?php $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&callback=initMap", array('async','defer','block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/lity-2.3.1/dist/lity.js", array('async','defer','block' => 'scriptBottom')); ?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
//var browser = 'notSafari';
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
        // var ua = navigator.userAgent.toLowerCase();
        // if (ua.indexOf('safari') != -1) {
        //   if (ua.indexOf('chrome') > -1) {
        //   } else {
        //     browser='safari';
        //   }
        // }
        var uluru = places['Toutes']['location'];
            map = new google.maps.Map(document.getElementById('map'), {
            zoom: places['Toutes']['zoom'],
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
        // if(browser == 'notSafari'){
            var contentString = '<div id="contentNotice" style="contentNotice">'+
                '<h2 id="firstHeading" class="firstHeading"><?= $cam['titre'] ?></h2>'+
                '<p>Direction : <?= $cam['direction'] ?>'+
                '</p>'+
                '<button type="buton" data-target="#popup_contact" data-url="<?= $cam['url'] ?>" class="btn btn-warning hvr-sweep-to-top showCamButton">Afficher webcam</button>'+
                '</div>'+
                '</div>';
        // }else{
        //     var contentString = '<div id="contentNotice" style="contentNotice">'+
        //         '<h2 id="firstHeading" class="firstHeading"><?php// $cam['titre'] ?></h2>'+
        //         '<p>Direction : <?php // $cam['direction'] ?>'+
        //         '</p>'+
        //         '<a href="<?php // $cam['url'] ?>" target="_blank" class="btn btn-warning hvr-sweep-to-top">Afficher webcam</a>'+
        //         '</div>'+
        //         '</div>';
        // }
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
//</script>
<?php $this->Html->scriptEnd(); ?>

<?php $this->start('cssTop'); ?>
<style>
    #contentNotice{
        text-align: center;
    }
    .showCamButton{
        margin-left: 2%;
    }
    #map{
        width:100%;
        height: 600px;
    }
    .tipsInfo{
        width:100%;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
        background-color: #332F2E;
        margin-bottom: 10px;
        color: white;
        cursor: pointer;
    }
    .tipsInfo h2{
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
    .flex{
        display: flex;
        margin-bottom: 10px;
    }
    .ml-16{
        margin-left: 16px;
        margin-top: 7px;
        margin-right: 5px;
    }
    .none{
        display: none;
    }
</style>
<?php $this->end(); ?>
<?php $this->Html->css("/js/lity-2.3.1/dist/lity.css", array('block' => 'cssTop')); ?>
<h1><?= __("Webcams") ?></h1>
<div onclick="this.classList.add('hidden')" class="tipsInfo">
    <span>x</span>
    <h2 class="styleh3"><i class="fa fa-info-circle fa-2x orange"></i> <?= __("Vous pouvez agrandir la carte pour voir plus de caméras") ?></h2>
</div>
<div class="row flex">
    <label class="ml-16"><?= __("Choisir une section") ?> : </label>
    <div class="input select">
        <select size="auto" class="form-control" id="palce">
            <?php foreach ($places as $place=>$value): ?>
                <option value="<?=$place?>"><?=$place?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="none">

</div>
<div id="map"></div>
