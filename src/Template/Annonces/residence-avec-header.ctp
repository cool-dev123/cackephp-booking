<style>
    .header_landing_page {
        <?php 
        if($residence_info->image_header != '') echo "background: url(".$this->Url->build('/')."images/header_residence/".$residence_info->image_header.") no-repeat;";
        ?>
        background-size: cover;
        background-position: 0 69%;
    }
    
    div#header_landing_page {
        height: 460px;
    }

    .text-header{
        padding-top: 10%;
        height: 100%;
        background: rgba(0,0,0,.2);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.32);
    } 

    .contentimg{
        display: none;
    }
</style>
    <?php if($language_header_name == "en"){
        $urlorig = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $urlorig = str_replace("/en/","/",$urlorig);
        $urlorig = str_replace("/resort","/station",$urlorig);
        $this->assign('hreflang', $urlorig);
    $this->assign('hreflangen', "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
         ?>

    <?php }else{ 
        $urlorig = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $urlorig = str_replace($_SERVER['SERVER_NAME'],$_SERVER['SERVER_NAME']."/en",$urlorig);
        $urlorig = str_replace("/station","/resort",$urlorig);
        $this->assign('hreflang', "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    $this->assign('hreflangen', $urlorig);
    ?>
    <?php }  ?>
<div id="header_landing_page" class="header_landing_page">
<?php 
    $this->Html->meta(null, null, ['property' => 'og:image','content' => $this->Url->build('/')."images/header_massif/".$residence_info->image_header_hiver,'block' => 'meta']);

    $this->assign('title', __('Résidence {0} à {1}', [$residence_info->name, $residence_info['village']->name])); 
    $this->Html->meta(null, null, ['property' => 'og:title','content' => __('Résidence {0} à {1} | Alpissime.com', [$residence_info->name, $residence_info['village']->name]), 'block' => 'meta']);
    $this->Html->meta(null, null, ['name' => 'title','content' => __('Résidence {0} à {1} | Alpissime.com', [$residence_info->name, $residence_info['village']->name]), 'block' => 'meta']); 
    $this->Html->meta(null, null, ['property' => 'og:description','content' => __('Locations résidence {0} à {1}.  Créez votre séjour montagne sur Alpissime : Hébergements vérifiés, Paiement 4x sans frais', [$residence_info->name, $residence_info['village']->name]) ,'block' => 'meta']); 
    $this->Html->meta(null, null, ['name' => 'description','content' => __('Locations résidence {0} à {1}.  Créez votre séjour montagne sur Alpissime : Hébergements vérifiés, Paiement 4x sans frais', [$residence_info->name, $residence_info['village']->name]) ,'block' => 'meta']); 
?>

    <div class="text-center text-header">
        <h1 class="text-white display-5 font-weight-bold"><?= __("Locations de vacances à {0} : Résidence {1}", [$residence_info['village']->name, $residence_info->name]); ?></h1>
        <h2 class="text-white px-2"><u><a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['station'];?>/<?php echo $residence_info['village']['lieugeo']->nom_url; ?>" class="text-white" > <?= $residence_info['village']['lieugeo']->name ?></a></u> > <u><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=<?php echo $residence_info['village']['lieugeo_id']; ?>&village=<?php echo $residence_info['village']['id']; ?>" class="text-white" > <?= $residence_info['village']->name ?></a></u> > <?= __("Résidence")." ".$residence_info->name ?></h2>
    </div>							
</div>
<!--End Slide--> 
<section class="mt-5 mb-4">
    <div class="container">
        <!-- Liste Annonces -->
        <div class="col-12">
            <div class="annonce block products row">
            <?php $i = 0; foreach($listeAnnonce as $ann) { ?>
                <div class="col-6 col-sm-6 col-md-3 px-2 contentimg" style="margin-bottom:10px">
                    <div class="featured-product">
                        <?php echo $this->element('petite_annonce', array('annonce'=>$ann, 'photo'=>$photosCont, 'residence'=>$residenceAnnonce, 'minprixannonce'=>$minprixannonce, 'noteglobalmoy'=>$noteglobalmoytab) ); ?>
                    </div>
                </div>
            <?php $i++; } ?>
            </div>                   
        </div>
        <?php if($listeAnnonce->count() > 12){ ?>
            <div class="row">
                <div class="col-md-12 text-center p-4">
                    <a class="btn btn-blue text-white rounded-0" href="#" id="loadMore">
                        <?= __("Charger plus") ?>
                    </a>
                </div>
            </div> 
        <?php } ?>
        <!-- Map -->
        <h2 class="h1 mb-3"><?= __("Découvrez la résidence {0} à {1}", [$residence_info->name, $residence_info['village']->name]) ?></h2>
        <div id="mapdiv" class="col-md-12 maprelative px-0 mt-4 mb-3">
            <div id="map" style="width:100%; height:100%"></div>
        </div>
    </div>
</section>

<?php $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&callback=initMap&language=".$language_header_name, array('block' => 'scriptBottom', 'defer' => 'defer')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
$(document).ready(function () {
    $("section.main").removeClass('py-5');

    $(".contentimg").slice(0, 12).show();
    $("#loadMore").on("click", function(e){
        e.preventDefault();
        $(".contentimg:hidden").slice(0, 12).slideDown();
        if($(".contentimg:hidden").length == 0) {
            $("#loadMore").css("display", "none");
        }
    });
});
var markers = [];
var map;
function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: <?php echo $residence_info->latitude?$residence_info->latitude:45.5877732; ?>, lng: <?php echo $residence_info->longitude?$residence_info->longitude:6.82846816; ?>},
        zoom: 10,
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
                "visibility": "off"
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

    var marker = new google.maps.Marker({
        position: {
            lat: <?php if(!empty($residence_info->latitude) ) echo $residence_info->latitude.''; else echo 46.734255.''; ?>,
            lng: <?php if(!empty($residence_info->longitude) ) echo $residence_info->longitude.''; else echo 2.418815.''; ?>
        },
        map :map,
        draggable: true
    });
    
    // IMAGE ICON
    /*var imageMarqueur = {
        url: "<?php echo $this->Url->build('/',true)?>images/iconegooglemap.png",
        //size: new google.maps.Size(44, 70),
        //anchor: new google.maps.Point(28, 120)
    };*/

}
<?php $this->Html->scriptEnd(); ?>