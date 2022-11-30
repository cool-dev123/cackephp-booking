<?php define("BASE","");
        use Cake\Utility\Inflector;
?>

<?php 
$modal = $_GET['modal'];
if ($modal == 1 && $this->Session->read('Auth.User.nature') != '') {
  echo "<script type='text/javascript'>
  setTimeout(function() {
    $('#popup_contact').modal('show');
    // Execute recaptcha
    // grecaptcha.execute();
  }, 1000);
  </script>";
}
$modalError = $_GET['error'];
if ($modalError == 1 && $this->Session->read('Auth.User.nature') != '') {
  echo "<script type='text/javascript'>
  setTimeout(function() {
    $('#msgerrorphone').removeClass('d-none');
    $('#popup_contact').modal('show');
    // Execute recaptcha
    // grecaptcha.execute();
  }, 1000);
  </script>";
}
?>

<?php $this->Html->css("/css/star-rating.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<link href="<?php echo $this->Url->build('/',true)?>css/new/lightgallery.css" rel="stylesheet"> 

<?php $this->Html->script("/js/moment.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/locale/fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/star-rating.min.js", array('block' => 'scriptBottom')); ?>
<?php //$this->Html->script("/js/jquery.snippet.min.js", array('block' => 'scriptBottom')); INUTILE?>
<?php $this->Html->script("/js/jquery.easyPaginate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/intlTelInput.min.js", array('block' => 'scriptBottom')); ?>

<?php //$this->Html->css("/css/styleviewannonce.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->script("new/picturefill.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("new/lightgallery-all.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("new/jquery.mousewheel.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("jquery.sticky.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js", array('block' => 'scriptBottom')); ?>

<style>
  .disableno{
    pointer-events: none;
  }
/* Hide all steps by default: */
.tab {
  display: none;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: white;
  border: 1px solid black;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

/* Mark the active step: */
.step.active {
  opacity: 1;
  background-color: #0099ff;
  border-color: #0099ff;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4CAF50;
}

.disabledcss{
  pointer-events: none;
  opacity: 0.5;
  display: none;
}
.datasrc{	
  height: 191px;
  object-fit: cover;
}
@media only screen and (max-width: 480px) {
  .datasrc {	
    height: auto;
	  object-fit: cover;
  }
}
.carreBleuRes {
    font-size: 15px;
    border: 1px solid #1a9cfc;
    color: #1a9cfc;
}
.text-for-photo{
    position: absolute;
    bottom: 0;
    color: #fff;
    margin-bottom: 1em;
    z-index: 99;
    margin-left: 1em;
}
.carreGris {
    background: #eeeeee;
    font-size: 15px;
    font-weight: bold;
}
.newcarreGris{
  background: #eeeeee;
}
.image_annonce_res{
  width: 100%;
  height: 100%;
}
.rating-xxs{
  padding-top: 0 !important;
}
.rating-container .star{
  margin: 0 1px !important;
}
.filled-stars {
    color: #0096ff !important;
    -webkit-text-stroke: #0096ff !important;
    text-shadow: none !important;
}
svg {
    fill: #0099ff;
}
.fill-black {
    fill: #3b3c3c;
}
/* MAJ Calendrier */
.greenday td a, .promoday a{
  /* border: none !important; */
  text-align: center;
}


ul.pl-4.my-0{
  padding-left: 21px!important;
}
.dropdown-menu.detailtolat {
    width: 270px;
}
.detailtolat p {
    font-size: 15px !important;
}
u.dropdown-toggle::after{
    display: none !important;
}
.dropright:hover .dropdown-menu{
    display: block;
}
.dropright {
    cursor: pointer;
}

.fontsizechange {
    font-size: 13px;
}
.iqdropdown {
    height: 40px;
}
.iqdropdown .iqdropdown-item-controls button{
  border: none;
  padding: 0;
}
.iqdropdown .iqdropdown-item-controls button:hover{
  background-color: white;
}
.iqdropdown .iqdropdown-item-controls .counter {
  border: none;
  padding-right: 10px;
  padding-left: 10px;
}
.iqdropdown .icon-decrement::after, .iqdropdown .icon-decrement.icon-increment::before {
  background: black;  
  width: 10px;
  height: 2px;
}
.iqdropdown-disabled button{
  pointer-events: none !important;
  cursor: not-allowed !important;
}
.iqdropdown-disabled .iqdropdown-item-controls{
  opacity: 0.3;
}
p.iqdropdown-description {
    font-size: 12px !important;
}
.disabledlabel {
    opacity: 0.7;
}
/* SWITCHER */
.switch {
    position: relative;
    display: inline-block;
    width: 45px;
    height: 21px;
}
.switch input { 
    opacity: 0;
    width: 0;
    height: 0;
}
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}
.slider:before {
    position: absolute;
    content: "";
    height: 15px;
    width: 15px;
    bottom: 3px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    left: 2px;
}
input:checked + .slider {
    background-color: white;
}
input:checked + .slider:before {
    background-color: #2196F3;
}
input:focus + .slider {
    box-shadow: 0 0 1px white;
}
input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}
/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}
.slider.round:before {
    border-radius: 50%;
}
</style>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  if (n == (x.length - 1)) {
    // document.getElementById("nextBtn").innerHTML = "Réserver";
    document.getElementById("nextBtn").style.display = "none";
    document.getElementById("prevBtn").style.display = "initial";
  } 
  /*else {
    document.getElementById("nextBtn").innerHTML = "Suivant";
  } */
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:    
    /**/
    // $("#redirectboutiquemodal").modal("hide"); 
    window.location.href = $("#redirectUrl").val();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}

function redirecttoboutique(){
  window.location.assign($("#redirectUrl").val())
  window.location=$("#redirectUrl").val();
  window.location.href=$("#redirectUrl").val();
}
<?php $this->Html->scriptEnd(); ?>

<!-- Modal -->
<div class="modal fade" id="conditionannulationmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Conditions d'annulation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo $propannonceannulation; ?>
      </div>
    </div>
  </div>
</div>


<?php
function convertstr($titre)
{
   $str = strtr($titre,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
  $str = str_replace("é","e",$titre);
  $str = str_replace("è","e",$str);
  $str = str_replace("ê","e",$str);
  $str = str_replace("à","a",$str);
  $str = str_replace("â","a",$str);
  $str = str_replace("ä","a",$str);
  $str = str_replace("î","i",$str);
  $str = str_replace("ï","i",$str);
  $str = str_replace("ô","o",$str);
  $str = str_replace("ö","o",$str);
  $str = str_replace("ù","u",$str);
  $str = str_replace("û","u",$str);
  $str = str_replace("ü","u",$str);
  $str = str_replace(","," ",$str);
  $str = str_replace("'"," ",$str);
  $str = str_replace("É","e",$str);
  $str = str_replace("%","pourcent",$str);
  $str = str_replace("œ","oe",$str);
  $str = str_replace("Œ","oe",$str);
  $str = str_replace("€","euros",$str);
  $str = str_replace("/","-",$str);
  $str = str_replace("+","-",$str);
  $str = str_replace("ç","c",$str);
  $str = str_replace("*","",$str);
  $str = str_replace("?","",$str);
  $str = str_replace("!","",$str);
  $str = str_replace("°","",$str);
  $str = str_replace("<","",$str);
  $str = str_replace(">","",$str);
  $str = str_replace("----","-",$str);
  $str = str_replace("---","-",$str);
  $str = str_replace("--","-",$str);
  $str = str_replace("²","",$str);
  $str = str_replace(":","",$str);
  $str = str_replace("	  "," ",$str);
  $str = str_replace("\""," ",$str);
  return htmlentities($str);
}

$marqueurMaps = [];
$lannonce = trim(formatStr($annonce->titre));
$m = 1000;
foreach ($residenceAnnonce as $key) {
  if(isset($residenceAnnonce[$m]['bibliotheque'])){
    $marqueurMaps[$m]['lat'] = $residenceAnnonce[$m]['lat'];
    $marqueurMaps[$m]['lon'] = $residenceAnnonce[$m]['lon'];
    $marqueurMaps[$m]['title'] = convertstr($residenceAnnonce[$m]['title']);
    $marqueurMaps[$m]['bibliotheque'] = convertstr($residenceAnnonce[$m]['bibliotheque']);
    $marqueurMaps[$m]['imgbibliotheque'] = $residenceAnnonce[$m]['imgbibliotheque'];
    $m++;
  }else{
    $marqueurMaps[$annonce->batiment]['lat'] = $residenceAnnonce[$annonce->batiment]['lat'];
    $marqueurMaps[$annonce->batiment]['lon'] = $residenceAnnonce[$annonce->batiment]['lon'];
    $marqueurMaps[$annonce->batiment]['title'] = convertstr( $residenceAnnonce[$annonce->batiment]['title'] );
    $marqueurMaps[$annonce->batiment]['contenu'] = convertstr( $annonce->titre );
    // $marqueurMaps[$annonce->batiment]['url'] = $this->Url->build("/")."detail/".$annonce->id."-".$lannonce;
    $marqueurMaps[$annonce->batiment]['prix'] = $minprixannoncedetail[$annonce->id]['prixmin'];
  }

}
//print_r("<pre>");
//print_r($marqueurMaps);
//print_r("</pre>");
?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
function convertcaracterjson(strInput){
        strInput = strInput.replace("\u00c0", "À")
        strInput = strInput.replace("\u00c1", "Á")
        strInput = strInput.replace("\u00c2", "Â")
        strInput = strInput.replace("\u00c3", "Ã")
        strInput = strInput.replace("\u00c4", "Ä")
        strInput = strInput.replace("\u00c5", "Å")
        strInput = strInput.replace("\u00c6", "Æ")
        strInput = strInput.replace("\u00c7", "Ç")
        strInput = strInput.replace("\u00c8", "È")
        strInput = strInput.replace("\u00c9", "É")
        strInput = strInput.replace("\u00ca", "Ê")
        strInput = strInput.replace("\u00cb", "Ë")
        strInput = strInput.replace("\u00cc", "Ì")
        strInput = strInput.replace("\u00cd", "Í")
        strInput = strInput.replace("\u00ce", "Î")
        strInput = strInput.replace("\u00cf", "Ï")
        strInput = strInput.replace("\u00d1", "Ñ")
        strInput = strInput.replace("\u00d2", "Ò")
        strInput = strInput.replace("\u00d3", "Ó")
        strInput = strInput.replace("\u00d4", "Ô")
        strInput = strInput.replace("\u00d5", "Õ")
        strInput = strInput.replace("\u00d6", "Ö")
        strInput = strInput.replace("\u00d8", "Ø")
        strInput = strInput.replace("\u00d9", "Ù")
        strInput = strInput.replace("\u00da", "Ú")
        strInput = strInput.replace("\u00db", "Û")
        strInput = strInput.replace("\u00dc", "Ü")
        strInput = strInput.replace("\u00dd", "Ý")
        strInput = strInput.replace("\u00df", "ß")
        strInput = strInput.replace("\u00e0", "à")
        strInput = strInput.replace("\u00e1", "á")
        strInput = strInput.replace("\u00e2", "â")
        strInput = strInput.replace("\u00e3", "ã")
        strInput = strInput.replace("\u00e4", "ä")
        strInput = strInput.replace("\u00e5", "å")
        strInput = strInput.replace("\u00e6", "æ")
        strInput = strInput.replace("\u00e7", "ç")
        strInput = strInput.replace("\u00e8", "è")
        strInput = strInput.replace("\u00e9", "é")
        strInput = strInput.replace("\u00ea", "ê")
        strInput = strInput.replace("\u00eb", "ë")
        strInput = strInput.replace("\u00ec", "ì")
        strInput = strInput.replace("\u00ed", "í")
        strInput = strInput.replace("\u00ee", "î")
        strInput = strInput.replace("\u00ef", "ï")
        strInput = strInput.replace("\u00f0", "ð")
        strInput = strInput.replace("\u00f1", "ñ")
        strInput = strInput.replace("\u00f2", "ò")
        strInput = strInput.replace("\u00f3", "ó")
        strInput = strInput.replace("\u00f4", "ô")
        strInput = strInput.replace("\u00f5", "õ")
        strInput = strInput.replace("\u00f6", "ö")
        strInput = strInput.replace("\u00f8", "ø")
        strInput = strInput.replace("\u00f9", "ù")
        strInput = strInput.replace("\u00fa", "ú")
        strInput = strInput.replace("\u00fb", "û")
        strInput = strInput.replace("\u00fc", "ü")
        strInput = strInput.replace("\u00fd", "ý")
        strInput = strInput.replace("\u00ff", "ÿ")
        strInput = strInput.replace("&amp;", "&")
        return strInput;
    }
var markers = [];
  var map;
    function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: <?php echo $residenceAnnonce[$annonce->batiment]['lat']?$residenceAnnonce[$annonce->batiment]['lat']:45.5877732; ?>, lng: <?php echo $residenceAnnonce[$annonce->batiment]['lon']?$residenceAnnonce[$annonce->batiment]['lon']:6.82846816; ?>},
        zoom: <?php echo $residenceAnnonce[$annonce->batiment]['lat']?15:12; ?>,
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

      // IMAGE ICON
      var imageMarqueur = {
  		url: "<?php echo $this->Url->build('/',true)?>images/iconegooglemap.png",
  		//size: new google.maps.Size(44, 70),
  		//anchor: new google.maps.Point(28, 120)
    };


      var jsontab = JSON.parse('<?php echo JSON_encode($marqueurMaps);?>');
      $.each(jsontab, function(index, data) {
        latLng = new google.maps.LatLng(data.lat, data.lon);

        // ICON suivant bibliotheque
        if(data.imgbibliotheque){
          imageMarqueur = {
            url: "<?php echo $this->Url->build('/',true)?>images/"+data.imgbibliotheque,
          };
        }
        if(!data.imgbibliotheque){
          imageMarqueur = {
            url: "<?php echo $this->Url->build('/',true)?>images/google-marqueur.png",
            size: new google.maps.Size(20, 32)
          };
        }

        if(!data.bibliotheque){
          imageMarqueur = {
      		  url: "<?php echo $this->Url->build('/',true)?>images/iconegooglemap.png",
          };
        }
        var infowindow = new google.maps.InfoWindow({
            content: "<strong>"+convertcaracterjson(data.title)+"</strong>",
            maxWidth: 300
        });
        // Creating a marker and putting it on the map
        var marker = new google.maps.Marker({
          position: latLng,
          map: map,
          title: convertcaracterjson(data.title),
          icon: imageMarqueur,
          infowindow: infowindow
        });

        markers.push(marker);

        //Ajouter les infowindows
        marker.addListener('click', function() {
          hideAllInfoWindows(map);
          this.infowindow.open(map, this);
        });
      });


     }
    function hideAllInfoWindows(map) {
     markers.forEach(function(marker) {
       marker.infowindow.close(map, marker);
     });
    }
  
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&callback=initMap&language=".$language_header_name, array('block' => 'scriptBottom', 'defer' => 'defer')); ?>
<?php $this->assign('title', substr($annonce->titre, 0, 45)." ..."); ?>
<?php
// region, ville, station, residence
$keywordch = ", ".Inflector::humanize(strtolower($region->name.", ".$ville->name.", ".$lieugeo->name.", ".$residence->name));
// location + region / ville / station / residence
$keywordch .= ", ".Inflector::humanize(strtolower("locataion ".$region->name.", locataion ".$ville->name.", locataion ".$lieugeo->name.", locataion ".$residence->name));
$a_nature_loc=array('STD'=>__('Studio'),'APP'=>__('Appartement'),'CHA'=>__('Chalet'),'VIL'=>__('Villa'),'GIT'=>__('Gîte'));
if(!empty($a_nature_loc[$annonce->nature])){
  // type
  $keywordch .= ", ".$a_nature_loc[$annonce->nature];
  // type + region / ville / station / residence
  $keywordch .= ", ".Inflector::humanize(strtolower($a_nature_loc[$annonce->nature]." ".$region->name.", ".$a_nature_loc[$annonce->nature]." ".$ville->name.", ".$a_nature_loc[$annonce->nature]." ".$lieugeo->name.", ".$a_nature_loc[$annonce->nature]." ".$residence->name));
  // location + type + region / ville / station / residence
  $keywordch .= ", ".Inflector::humanize(strtolower("locataion ".$a_nature_loc[$annonce->nature]." ".$region->name.", locataion ".$a_nature_loc[$annonce->nature]." ".$ville->name.", locataion ".$a_nature_loc[$annonce->nature]." ".$lieugeo->name.", locataion ".$a_nature_loc[$annonce->nature]." ".$residence->name));
}
$this->assign('keywords', $keywordch); ?>

<?php
$natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
$village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
$village_nom = str_replace(" – ", "-", $village_nom);
$village_nom = str_replace(" ", "-", $village_nom);
$nomImgGLien = $this->Url->build('/',true)."images_ann/".$annonce->id."/".$photo->titre;
?>

<?php 
// print_r($dispos->first()); 
$dispo = $dispos->first();
// if($dispo->conditionnbr == 0) 
$conditionDipos = "Nombre de nuitée minimum : ".$dispo->nbr_jour;
// else if($dispo->conditionnbr == 1) $conditionDipos = "Du Samedi au Samedi";
// else if($dispo->conditionnbr == 2) $conditionDipos = "Du Dimanche au Dimanche";
?>

<?php ($listerating->count() != 0 ? $noteglobalmoy = $notecara['emplacement']/$listerating->count()+$notecara['confort']/$listerating->count()+$notecara['qualiteprix']/$listerating->count() : $noteglobalmoy = 0); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<?php if($language_header_name == "en"){
    $urlorig = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $urlorig = str_replace("/en/","/",$urlorig);
    $urlorig = str_replace("/resort","/station",$urlorig);
    $urlorig = str_replace("/apartment","/appartement",$urlorig);
    $this->assign('canonicalUrl', $urlorig); 
    
    $this->assign('hreflang', $urlorig);
    $this->assign('hreflangen', "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    ?>
<?php }else{
  $urlorig = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $urlorig = str_replace($_SERVER['SERVER_NAME'],$_SERVER['SERVER_NAME']."/en",$urlorig);
  $urlorig = str_replace("/station","/resort",$urlorig);
  $urlorig = str_replace("/appartement","/apartment",$urlorig);
  $this->assign('hreflang', "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  $this->assign('hreflangen', $urlorig);
}  ?>

<div itemscope itemtype="http://schema.org/LodgingBusiness" id="details_annonce">
  <meta itemprop="priceRange" content="EUR">
  <meta itemprop="address" content="<?php echo Inflector::humanize(strtolower($region->name)).' '.Inflector::humanize(strtolower($ville->name)).' '.$annonce->code_postal.' France'; ?>">
  <!-- photo -->
  <?php  
            if (!empty($photos)) {
              $nbrphoto = $photos->count();              
              ?>
              <div class="container-fluid px-0 delete-border-top">
                <div id="lightgallery">                
                  <div class="row no-gutters position-relative">
                  <?php if($propannonce->nature == "PRES"){ ?>
                    <span class="align-left text-for-photo"><?= __("Photographies fournies par la résidence"); ?></span>
                  <?php } ?>
                    <?php if($nbrphoto > 1){ ?>
                    <button class="align-left btn" id="voir-photo"><?= __("Voir les {0} photos", $nbrphoto) ?></button>
                    <?php } ?>
              <?php
              if($nbrphoto >= 5){
                $i=0; 
                foreach($photos as $photo) {
                  $nomImg = "vignette-".$photo->annonce_id."-".$photo->numero;                  
                  $nomImgG = $photo->titre;
                  $nomImgGAlt = "location-".$natureAnnURL[$annonce['nature']]."-".$village_nom."-".$annonce->personnes_nb."-personnes-".$photo->annonce_id."-".$photo->numero."-Alpissime";
                  if($i == 0){
                    $this->Html->meta(null, null, ['property' => 'og:image','content' => $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImgG,'block' => 'meta']);
              ?>
              <div class="col-md-6 px-0 h-100" data-responsive="img/1-375.jpg 375, img/1-480.jpg 480, img/1.jpg 800">
              <a class="item-light disableno" href="<?php echo $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImgG; ?>">
                  <img alt="<?php echo $nomImgGAlt; ?>" title="<?php echo $nomImgGAlt; ?>" class="img-fluid" src="<?php echo $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImgG; ?>">
                  <meta itemprop="image" content="<?php echo $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImgG; ?>">
              </a>
              </div>
              <?php } 
              if($i == 1){ ?>
              <div class="col-md-6 d-none d-md-block">
                <div class="row no-gutters h-50 pl-1 mt-1">
              <?php } ?>
              <?php if($i != 0 and $i < 5) { ?>
                <div class="col-md-6 px-1" data-responsive="img/1-375.jpg 375, img/1-480.jpg 480, img/1.jpg 800">
                  <a class="item-light disableno" href="<?php echo $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImgG; ?>">
                    <img alt="<?php echo $nomImgGAlt; ?>" title="<?php echo $nomImgGAlt; ?>" class="img-fluid-thumb <?php if($i == 1 || $i == 2){?>  <?php }elseif($i == 3 || $i == 4){ ?>  <?php }?>" src="#" data-src="<?php echo $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImg.'.P.jpg'; ?>">
                  </a>
                </div>
                <?php if($i == 2){?>
                  </div>
                  <div class="row no-gutters h-50 pl-1">
              <?php } }
               if($i == 4){?>
              </div>
              </div>
              <div class="d-none">
               <?php } if($i > 4){?>
                <a class="item-light disableno" href="<?php echo $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImgG; ?>">
                    <img class="img-fluid" src="#" data-src="<?php echo $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImg.'.P.jpg'; ?>">
                </a>
                <?php } if($i == $nbrphoto){?>
               </div>
                <?php } $i++; } ?>
    </div>
  </div>
</div>
</div>
<!-- nombre photo < 5 -->
<?php }else{ 
  $j=0; 
  foreach($photos as $photo) {
    $nomImg = "vignette-".$photo->annonce_id."-".$photo->numero;
    $village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
    $village_nom = str_replace(" – ", "-", $village_nom);
    $village_nom = str_replace(" ", "-", $village_nom);
    $nomImgG = $photo->titre;
    $nomImgGAlt = "location-".$natureAnnURL[$annonce['nature']]."-".$village_nom."-".$annonce->personnes_nb."-personnes-".$photo->annonce_id."-".$photo->numero."-Alpissime";
    if($j == 0){ 
      ?>
              <div class="col-12 px-0" data-responsive="img/1-375.jpg 375, img/1-480.jpg 480, img/1.jpg 800">
                <a class="item-light disableno one-photo" href="<?php echo $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImgG; ?>">
                    <img alt="<?php echo $nomImgGAlt; ?>" title="<?php echo $nomImgGAlt; ?>" class="img-fluid" src="#" data-src="<?php echo $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImgG; ?>">
                </a>
              </div>
              <?php }else{ ?>
                <div class="d-none">
                <a class="item-light disableno" href="<?php echo $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImgG; ?>">
                    <img alt="<?php echo $nomImgGAlt; ?>" title="<?php echo $nomImgGAlt; ?>" class="img-fluid" src="#" data-src="<?php echo $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImgG; ?>">
                </a>
                </div>
            <?php }
            if($j == 0){
              $contentimg = $this->Url->build('/',true).'images_ann/'.$photo["annonce_id"].'/'.$nomImg.'.P.jpg';
              $this->Html->meta(null, null, ['property' => 'og:image','content' => $contentimg,'block' => 'meta']);
          }
            $j++;} ?>
              </div>
  </div>
</div>
<?php }} ?>
<!-- End photo -->
<div class="container mt-5">
  <div class="row">
  <div class="col-lg-8">
    <div class="row px-3">
      <div class="col-auto carreBleuRes font-weight-normal mr-2 mb-2 px-2 py-0 rounded">
        <?php if($propannonce->nature == "PRES"){ 
          echo __("Résidence de tourisme"); 
        }else{ 
          echo __("Annonce de particulier");
        } ?>     
      </div>
    </div>
    <h3 class="mb-4 mt-2 font-weight-normal"><a class="text-dark" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=massif_<?php echo $annonce['lieugeo']['massif']['id']; ?>"><u><?php echo $annonce['lieugeo']['massif']['nom']; ?></u></a> > <a class="text-dark" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['station']; ?>/<?php echo $annonce['lieugeo']['nom_url']; ?>"><u><?php echo $annonce['lieugeo']['name']; ?></u></a><?php if(strtolower($annonce['lieugeo']['name']) != strtolower($annonce['village']['name'])){ ?> > <a class="text-dark" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['recherche']; ?>?village=<?php echo $annonce['village']['id']; ?>"><u><?php echo $annonce['village']['name']; ?></u></a><?php } ?></h2>
    <div class="descriptiondiv mb-5">
      <h1 itemprop="name"><?php echo ucfirst(mb_strtolower($annonce->titre))?></h1>
      <?php $this->Html->meta(null, null, ['property' => 'og:title','content' => ucfirst(mb_strtolower($annonce->titre)),'block' => 'meta']); ?>
      <div class="description-details block">
        <div id="shrinkMe" class="shrinkable" itemprop="description">
          <?php
          echo nl2br($annonce->description); ?>          
        </div>
        <?php $this->Html->meta(null, null, ['property' => 'og:description','content' => __("Location {0} {1} {2} pour {3} personne(s) ▶ Composez vos vacances à la montagne sur Alpissime : Hébergements vérifiés, Paiement 4x sans frais", [$a_nature_loc[$annonce->nature],$annonce['lieugeo']['preposition_a'],$annonce['lieugeo']['name'],$annonce->personnes_nb]) ,'block' => 'meta']); ?>
        <?php $this->Html->meta(null, null, ['name' => 'description','content' => __("Location {0} {1} {2} pour {3} personne(s) ▶ Composez vos vacances à la montagne sur Alpissime : Hébergements vérifiés, Paiement 4x sans frais", [$a_nature_loc[$annonce->nature],$annonce['lieugeo']['preposition_a'],$annonce['lieugeo']['name'],$annonce->personnes_nb]) ,'block' => 'meta']); ?>
        <?php $this->Html->meta(null, null, ['name' => 'title','content' => "Alpissime.com | ".substr($annonce->titre, 0, 45)." ..." ,'block' => 'meta']); ?>
      </div>
      <?php if($annonce->nb_etoiles > 0){ ?>
        <div class="row px-3 mt-4">
          <div class="col-auto carreGris px-3 py-1 rounded">
            <?= __("Appartement classé") ?> : <?php for ($i=0; $i < $annonce->nb_etoiles; $i++) { ?>
              <i class="fa fa-star"></i> 
            <?php } ?>
          </div>
        </div>      
      <?php } ?>
    </div>
    <h2 class="h1 mb-3"><?= __("A propos") ?></h2>
    <div class="row mb-3">
      <div class="col-6 mb-2 pr-1 d-flex align-items-center">
        <svg class="mr-3 fill-black" aria-hidden="true" width="30" height="30" viewBox="0 0 78.94 78.94">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/appartement.svg#Calque_2"></use>
        </svg>
        <span><?php echo $a_nature_loc[$annonce->nature]; ?> <?php if($annonce->surface) echo $annonce->surface." m²"; ?> </span>
      </div>
      <div class="col-6 mb-2 pl-1 d-flex align-items-center">
        <svg class="mr-3 fill-black" aria-hidden="true" width="30" height="30" viewBox="0 0 75.96 57.53">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/chambre.svg#Calque_2"></use>
        </svg>
        <span><?php echo $annonce->pieces_nb; ?> <?= __("pièce(s)") ?> - <?php echo $annonce->chambres_nb; ?> <?= __("chambre(s)") ?></span>
      </div>
      <div class="col-6 mb-2 pr-1 d-flex align-items-center">
        <svg class="mr-3 fill-black" aria-hidden="true" width="30" height="30" viewBox="0 0 65.66 79.33">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/personnes.svg#Calque_2"></use>
        </svg>
        <?php echo $annonce->personnes_nb; ?> <?= __("personnes") ?>
      </div>
      <div class="col-6 mb-2 pl-1 d-flex align-items-center">
        <svg class="mr-3 fill-black" aria-hidden="true" width="30" height="30" viewBox="0 0 60.3 79.21">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/salle_de_bain.svg#Calque_2"></use>
        </svg>
        <?php echo $annonce->sdb_nb; ?> <?= __("salle(s) de bain") ?> - <?php echo $annonce->baignoire_nb; ?> <?= __("baignoire(s)") ?>
      </div>
    </div>
    <?php 
      $choix=array(__('Non'),__('Oui')); 
      $choixfumeur=array(__('Acceptés'),__('Non-Fumeur')); 
      $stationnement=array('0'=>' '.__("Garage").' ','1'=>' '.__("Parking").' ','2'=>' '.__("à Proximité").' ','3'=>' '.__("Réservation sur place").' ','4'=>' '.__("Aucun").' ');
      $exposition=array('0'=>__('Non précisée'),'1'=>__('Nord'),'2'=>__('Sud'),'3'=>__('Est'),'4'=>__('Ouest'),'5'=>__('Nord-Est'),'6'=>__('Nord-Ouest'), '7'=>__('Sud-Est'), '8'=>__('Sud-Ouest'));
      $vues=array('1'=>__('Vallée'),'2'=>__('Pistes'),'3'=>__('Station'),'4'=>__('Autre'));
    ?>
    <div class="row px-3">
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Animaux Acceptés") ?> : <?php if($choix[$annonce->ani_co_yn]==''){echo __("non précisé");} else{echo $choix[$annonce->ani_co_yn];}?>
      </div>
      <?php if($annonce->stationnement){ ?>
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Stationnement") ?> : <?php echo $stationnement[$annonce->stationnement] ;if($annonce->parking_couvert==1){ echo ' '.__("Couvert");}?>               
      </div>
      <?php } ?> 
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Accès mobilité réduite") ?> : <?php  if($choix[$annonce->personne_reduite]=='') {echo __('Non');} else {echo $choix[$annonce->personne_reduite];}?>
      </div>
      <?php if($annonce->ascenseur_yn){ ?>
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Ascenseur") ?> : <?php echo $choix[$annonce->ascenseur_yn]?>
      </div>
      <?php } ?>
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("WIFI") ?> : <?php if($annonce->hasWifiAppartment()){echo ' '.__('Wifi Gratuit (box dans l\'appartement)');} elseif ($annonce->hasPaidWifi()){echo '  '.__('Wifi Payant');} elseif ($annonce->hasWifiResidence()){echo '  '.__('Wifi Gratuit (dans la résidence)');} else {echo ' '.__('Non');}?>
      </div>
      <?php if($annonce->exposition){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <?= __("Exposition") ?> : <?php echo $exposition[$annonce->exposition];?>
        </div>
      <?php } ?> 
      <?php if($annonce->vue){ ?>     
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Vue") ?> : <?php echo $vues[$annonce->vue]?>
      </div>
      <?php } ?>
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Fumeurs") ?> : <?php if($choix[$annonce->non_fumeur]=="") {echo __('Acceptés');} else {echo $choixfumeur[$annonce->non_fumeur];} ?>
      </div>
      <?php if($annonce->balcon_yn==1){ ?>
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Balcon") ?> 
      </div>
      <?php } ?>
      <?php if($annonce->terasse_yn==1){ ?>
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Terrasse") ?> 
      </div>
      <?php } ?>
      <?php if($annonce->jardin_yn==1){ ?>
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Jardin") ?> 
      </div>
      <?php } ?>
      <?php if($annonce->espace_plein_air==1){ ?>
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Espace pour les repas en plein air") ?> 
      </div>
      <?php } ?>
      <?php if($propannonce->nature == "PRES"){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <img class="img-fluid mr-2" src="#" data-src="<?php echo $this->Url->build('/',true).'images/icon/Fichier_icon_key.png'; ?>"><?= __("Remise des clés à la réception") ?>
        </div>
      <?php }else if($encontrat == "ouicontrat"){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <img class="img-fluid mr-2" src="#" data-src="<?php echo $this->Url->build('/',true).'images/icon/Fichier_icon_key.png'; ?>"><?= __("Remise de clés assurée par votre conciergerie Alpissime") ?>
        </div>
      <?php }else if($encontrat == "noncontrat"){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <img class="img-fluid mr-2" src="#" data-src="<?php echo $this->Url->build('/',true).'images/icon/Fichier_icon_key.png'; ?>"><?= __("Remise de clés organisée par le propriétaire") ?>
        </div>
      <?php } ?>
    </div>
    <?php if($annonce->lave_linge==1 || $annonce->seche_linge==1 || $annonce->Radiateur_seche==1 || $annonce->lave_vaissel_4|| $annonce->lave_vaissel_8 || $annonce->lave_vaissel_12 || $annonce->refrigerateur_top|| $annonce->refrigerateur_comp || $annonce->refrigerateur_sup || $annonce->micro_onde==1 || $annonce->hotte==1 || $annonce->four || $annonce->four_mini || $annonce->table_cuisson || $annonce->cafetiere || $annonce->grill_pain || $annonce->bouilloire || $annonce->autocuiseur || $annonce->autocuiseur || $annonce->mixeur || $annonce->pierrade || $annonce->crepiere || $annonce->fondue || $annonce->wok || $annonce->seche_cheveux || $annonce->fer_repasser || $annonce->table_repasser || $annonce->aspirateur || $annonce->televiseur || $annonce->tube_cathod || $annonce->cable_sat || $annonce->decodeur_canal || $annonce->ecran_plat || $annonce->tnt || $annonce->decodeur_sky || $annonce->ecran_plasma || $annonce->chaine_etranger || $annonce->dvd || $annonce->cd || $annonce->hifi || $annonce->jeux_video || $annonce->jeux_societe || $annonce->quoi_lire || $annonce->brasero || $annonce->barbecue || $annonce->plancha){ ?>
    <h2 class="h1 mb-3"><?= __("Equipements") ?></h2>
    <?php } ?>
    <?php $electromenager = ""; if($annonce->lave_linge==1 || $annonce->seche_linge==1 || $annonce->Radiateur_seche==1 || $annonce->lave_vaissel_4|| $annonce->lave_vaissel_8 || $annonce->lave_vaissel_12 || $annonce->refrigerateur_top|| $annonce->refrigerateur_comp || $annonce->refrigerateur_sup || $annonce->micro_onde==1 || $annonce->hotte==1 || $annonce->four || $annonce->four_mini || $annonce->table_cuisson){ ?>
    <div class="row px-3 mb-3 align-items-center">
      <div class="col col-md-1">
        <svg class="fill-black" aria-hidden="true" width="30" height="30" viewBox="0 0 46 78.94">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/electromenager.svg#Calque_2"></use>
        </svg>
      </div>
      <div class="col-10 col-md-11">
        <?= __("Electroménager") ?> : <?php if($annonce->lave_linge==1){?>
                          <?= __("Lave-linge").', ' ?>
                        <?php $electromenager .= "Lave-linge, "; }?>
                        <?php if($annonce->seche_linge==1){?>
                          <?= __("Sèche-linge").', ' ?>
                        <?php $electromenager .= "Sèche-linge, "; }?>
                        <?php if($annonce->Radiateur_seche==1){?>
                          <?= __("Radiateur sèche-serviettes").', ' ?>
                        <?php $electromenager .= "Radiateur sèche-serviettes, "; }?>
                        <?php if($annonce->lave_vaissel_4|| $annonce->lave_vaissel_8 || $annonce->lave_vaissel_12){?>
                          <?= __("Lave vaisselle").', ' ?> 
                        <?php $electromenager .= "Lave vaisselle, "; if($annonce->lave_vaissel_4)echo '4 '.__('Couverts').', ';?>
                        <?php if($annonce->lave_vaissel_8)echo '8 '.__('Couverts').', ';?>
                        <?php if($annonce->lave_vaissel_12)echo '12 '.__('Couverts').', ';?>
                        <?php }?>
                        <?php if($annonce->refrigerateur_top|| $annonce->refrigerateur_comp || $annonce->refrigerateur_sup){?>
                          <?= __("Réfrigerateur").', ' ?> :
                        <?php $electromenager .= "Réfrigerateur, "; if($annonce->refrigerateur_top)echo ' '.__('Table Top 140 Litres').', ';?>
                        <?php if($annonce->refrigerateur_comp)echo ' '.__('Table Top et Compartiment Congélateur').', ';?>
                        <?php if($annonce->refrigerateur_sup)echo ' '.__('Supérieur à 140 litres').', ';?>
                        <?php }?>
                        <?php if($annonce->micro_onde==1){?>
                          <?= __("Micro-ondes").', ' ?> <?php if($annonce->multi_fonction==1){?><?= __("Multi-fonctions").', ' ?> <?php }?>
                        <?php $electromenager .= "Micro-ondes, "; }?>
                        <?php if($annonce->hotte==1){?>
                          <?= __("Hotte").', ' ?>
                        <?php $electromenager .= "Hotte, "; }?>
                        <?php if($annonce->four) {echo ' '.__('Four').', '; $electromenager .= "Four, "; }?>
                        <?php if($annonce->four_mini) {echo ' '.__('Mini Four').', '; $electromenager .= "Mini Four, "; }?>
                        <?php if($annonce->table_cuisson) {
                          echo __('Table de Cuisson').', ';
                          $electromenager .= "Table de Cuisson, ";
                          if($annonce->table_cuisson==0) echo " ".__("Electrique").', ';
                          if($annonce->table_cuisson==1) echo " ".__("Gaz").', ';
                          if($annonce->table_cuisson==2) echo " ".__("Vitrocéramique").', ';
                          if($annonce->table_cuisson==3) echo " ".__("Induction").', ';
                          if($annonce->table_cuisson_feu==0) echo " 2 ".__("feux");
                          if($annonce->table_cuisson_feu==1) echo " 3 ".__("feux");
                          if($annonce->table_cuisson_feu==2) echo " 4 ".__("feux");
                        }
                        ?>
      </div>      
    </div>
    <?php } ?>
    <?php if($annonce->cafetiere || $annonce->grill_pain || $annonce->bouilloire || $annonce->autocuiseur || $annonce->autocuiseur || $annonce->mixeur || $annonce->pierrade || $annonce->crepiere || $annonce->fondue || $annonce->wok || $annonce->seche_cheveux || $annonce->fer_repasser || $annonce->table_repasser || $annonce->aspirateur || $annonce->brasero || $annonce->barbecue || $annonce->plancha){ ?>
    <div class="row px-3 mb-3 align-items-center">
      <div class="col col-md-1">
        <svg class="fill-black" aria-hidden="true" width="30" height="30" viewBox="0 0 78.43 53.4">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/menage.svg#Calque_2"></use>
        </svg>
      </div>
      <div class="col-10 col-md-11">
        <?= __("Petit ménager") ?> : <?php if($annonce->cafetiere) echo __('Cafetière').', ';?>
                        <?php if($annonce->grill_pain)echo __('Grille-pain').', ';?>
                        <?php if($annonce->bouilloire)echo __('Bouilloire').', ';?>
                        <?php if($annonce->autocuiseur)echo __('Auto-cuiseur').', ';?>
                        <?php if($annonce->autocuiseur)echo __('Mixeur').', ';?>
                        <?php if($annonce->mixeur)echo __('Raclette').', ';?>
                        <?php if($annonce->pierrade)echo __('Pierrade').', ';?>
                        <?php if($annonce->crepiere)echo __('Crépière').', ';?>
                        <?php if($annonce->fondue)echo __('Fondue').', ';?>
                        <?php if($annonce->wok)echo __('Wok').', ';?>
                        <?php if($annonce->seche_cheveux)echo __('Sèche-cheveux').', ';?>
                        <?php if($annonce->fer_repasser)echo __('Fer à repasser').', ';?>
                        <?php if($annonce->table_repasser)echo __('Table à repasser').', ';?>
                        <?php if($annonce->aspirateur) echo __('Aspirateur').', '; ?>
                        <?php if($annonce->brasero) echo __('Brasero').', '; ?>
                        <?php if($annonce->barbecue) echo __('Barbecue').', '; ?>
                        <?php if($annonce->plancha) echo __('Plancha'); ?>
      </div>      
    </div>
    <?php } ?>
    <?php $espaceLudique = ""; if($annonce->televiseur || $annonce->tube_cathod || $annonce->cable_sat || $annonce->decodeur_canal || $annonce->ecran_plat || $annonce->tnt || $annonce->decodeur_sky || $annonce->ecran_plasma || $annonce->chaine_etranger || $annonce->dvd || $annonce->cd || $annonce->hifi || $annonce->jeux_video || $annonce->jeux_societe || $annonce->quoi_lire){ ?>
    <div class="row px-3 mb-3 align-items-center">
      <div class="col col-md-1">
        <svg class="fill-black" aria-hidden="true" width="30" height="30" viewBox="0 0 78.94 66.17">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/tv.svg#Calque_2"></use>
        </svg>
      </div>
      <div class="col-10 col-md-11">
        <?= __("Multimédia et espace ludique") ?> : <?php if($annonce->televiseur) $espaceLudique .= __('Téléviseur').', '; ?>
                        <?php if($annonce->tube_cathod) $espaceLudique .= __('Tube Cathodique').', ';?>
                        <?php if($annonce->cable_sat) $espaceLudique .= __('Cable Satellite').', ';?>
                        <?php if($annonce->decodeur_canal) $espaceLudique .= __('Décodeur Canal+').', ';?>
                        <?php if($annonce->ecran_plat) $espaceLudique .= __('Ecran Plat LCD-LED').', ';?>
                        <?php if($annonce->tnt) $espaceLudique .= __('TNT').', ';?>
                        <?php if($annonce->decodeur_sky) $espaceLudique .= __('Décodeur Sky').', ';?>
                        <?php if($annonce->ecran_plasma) $espaceLudique .= __('Ecran Plasma').', ';?>
                        <?php if($annonce->chaine_etranger) $espaceLudique .= __('Chaines Etrangères').', ';?>
                        <?php if($annonce->dvd) $espaceLudique .= __('Lecteur DVD').', ';?>
                        <?php if($annonce->cd) $espaceLudique .= __('Lecteur CD').', ';?>
                        <?php if($annonce->hifi) $espaceLudique .= __('Chaine HIFI').', ';?>
                        <?php if($annonce->jeux_video) $espaceLudique .= __('Jeux Vidéos').', ';?>
                        <?php if($annonce->jeux_societe) $espaceLudique .= __('Jeux de société').', ';?>  
                        <?php if($annonce->quoi_lire) $espaceLudique .= __('De quoi lire');?>  
                        <?php echo $espaceLudique; ?>                      
      </div>
    </div>
    <?php } ?>
    <?php 
      $nbrequisup = 0;
      if($annonce->baignoire_hydro == 1 || $annonce->appart_hammam == 1 || $annonce->appart_sauna == 1 || $annonce->espace_piscine == 1 || $annonce->salle_fitness == 1 || $annonce->poele_granule == 1 || $annonce->cheminee == 1 || $annonce->lit_bebe == 1 || $annonce->chaise_bebe == 1 || $annonce->baigoire_bebe == 1 || $annonce->reserv_sur_place == 1) $nbrequisup = 1;
    ?>
    <?php if($nbrequisup > 0) { ?>
    <h2 class="h1 mb-3"><?= __("Equipements supplémentaires") ?></h2>
    <div class="row px-3">
      <?php if($annonce->baignoire_hydro == 1){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <?= __('Baignoire Hydromassage') ?>  
        </div>
      <?php } ?>
      <?php if($annonce->appart_hammam == 1){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <?= __('Hammam') ?>  
        </div>
      <?php } ?>
      <?php if($annonce->appart_sauna == 1){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <?= __('Sauna') ?>  
        </div>
      <?php } ?>
      <?php if($annonce->espace_piscine == 1){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <?= __('Piscine') ?>  
        </div>
      <?php } ?>
      <?php if($annonce->salle_fitness == 1){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <?= __('Salle de fitness dans la résidence') ?>  
        </div>
      <?php } ?>
      <?php if($annonce->poele_granule == 1){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <?= __('Poêle à granule') ?>  
        </div>
      <?php } ?>
      <?php if($annonce->cheminee == 1){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <?= __('Cheminée') ?>  
        </div>
      <?php } ?>
      <?php if($annonce->lit_bebe == 1){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <?= __('Lit bébé') ?>  
        </div>
      <?php } ?>
      <?php if($annonce->chaise_bebe == 1){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <?= __('Chaise bébé') ?>  
        </div>
      <?php } ?>
      <?php if($annonce->baigoire_bebe == 1){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <?= __('Baigoire bébé') ?>  
        </div>
      <?php } ?>
      <?php if($annonce->reserv_sur_place == 1){ ?>
        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
          <?= __('Matériel pour enfant').' : '.__('Réservation sur place possible') ?>  
        </div>
      <?php } ?>
    </div>
    <?php } ?>
    <!-- Nouvelle partie pour propriétaire-résidence -->
    <?php if($propannonce->nature == "PRES" && $annoncepropres->count() > 0){ ?>
      <h2 class="h1 mb-3"><?= __("Découvrez les autres hébergements de la résidence {0}", convertstr($residenceAnnonce[$annonce->batiment]['title'])) ?></h2>
      <?php foreach ($annoncepropres as $annoncepropre) { ?>
        <div class="row border ml-1 mt-2 text-center mr-1">
          <div class="col-sm-12 col-md p-0">
            <?php 
              $natureAnn = array("STD"=>__("Studio"),"APP"=>__("Appart."),"CHA"=>__("Chalet"),"DIV"=>__("Location"),"VIL"=>__("Villa"),"GIT"=>__("Gîte"));
              $natureAnnURL = array("STD"=>__("studio"),"APP"=>__("appartement"),"CHA"=>__("chalet"),"DIV"=>__("location"),"VIL"=>__("villa"),"GIT"=>__("gite"));
              $lannonce = strtolower(str_replace(" ","-",trim($annonce["titre"])));

              $url = $this->Url->build('/', true);
              if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = "";
              if($annoncepropre['lieugeo']['nom_url'] != "") $hrefDetailAnn = $url.$urlLang.$urlvaluemulti['station'].'/'.$annoncepropre['lieugeo']['nom_url'].'/'.$natureAnnURL[$annoncepropre->nature].'/'.$annoncepropre->id."_".$lannonce;
              else $hrefDetailAnn = $url.$urlLang.$urlvaluemulti['station'].'/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annoncepropre->nature].'/'.$annoncepropre->id."_".$lannonce;
              if($debutrech != '' || $finrech != '') echo '<a href="'.$hrefDetailAnn.'/'.$debutrech.'/'.$finrech.'">'; 
              else echo '<a href="'.$hrefDetailAnn.'">';
            ?>
              <?php
              if(!empty($photosCont[$annoncepropre->id][0])){
                $vignette = $annoncepropre->id.'/'."vignette-".$annoncepropre->id."-".$photosCont[$annoncepropre->id][0].".P.jpg?v=".(time()*1000);
              }else{
                $vignette = "no_annonce_image.jpg";
              }
              ?>
              <img src="<?php echo $this->Url->build('/', true); ?>images_ann/<?php echo $vignette; ?>" class="image_annonce_res"> 
            </a>
          </div>
          <div class="col-sm-12 col-md border-right d-md-flex py-3">
            <span class="align-self-center">
              <h3><?php echo ucfirst(mb_strtolower($annoncepropre->titre))?></h3>
              <p class="mb-0"><?php echo $a_nature_loc[$annoncepropre->nature]; ?> - <?php echo $annoncepropre->personnes_nb; ?> <?= __("personnes") ?><?php if($annoncepropre->surface) echo ", ".$annoncepropre->surface." m²"; ?>, <?php echo $annoncepropre->chambres_nb; ?> <?= __("chambre(s)") ?></p>
            </span>            
          </div>
          <div class="col-sm-12 col-md-4 mx-auto d-md-flex newcarreGris py-3 pr-1 pl-2">
            <span class="align-self-center w-100">
              <?php if(!empty($minprixannonceres)){
                if($minprixannonceres[$annoncepropre->id]['prixmin'] != ""){ ?>
                  <p id="partoneprice_<?php echo $annoncepropre->id; ?>" class="mb-1"><?= __("Dès ").$minprixannonceres[$annoncepropre->id]['prixmin']." / ".__("Nuitée"); ?></p>
                  <!-- <p id="parttwoprice_<?php //echo $annoncepropre->id; ?>" class="mt-1"> -->
                  <?php if($debutrech != '' && $finrech != '' && $prixtotalpourpetiteannonceres[$annoncepropre->id]['totalPrixPayer'] != 0 && $prixtotalpourpetiteannonceres[$annoncepropre->id]['nbrjour'] != 0){ ?>
                    <div class="d-flex flex-wrap justify-content-center my-2 fontsizechange"> 
                      <span class="my-auto pr-1"><?php echo $minprixannonceres[$annoncepropre->id]['prixmin']." / ".__("Nuitée"); ?></span>
                      <span>
                        <ul class='pl-4 my-0'>
                            <li>
                                <div class="btn-group dropright">
                                    <u class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $prixtotalpourpetiteannonceres[$annoncepropre->id]['totalPrixPayer']."€ total"; ?>
                                    </u>
                                    <div class="dropdown-menu detailtolat p-3">
                                        <h3><?= __("Prix de réservation"); ?></h3>
                                        <p class="border-bottom pb-3"><span class="resleft"><?php echo $prixtotalpourpetiteannonceres[$annoncepropre->id]['nbrjour']; ?> <?= __("nuitées"); ?> <span class="col-auto carreBleuRes mr-2 mb-2 px-2 py-0 rounded"><?= __('Promo'); ?></span></span><?php if($prixtotalpourpetiteannonceres[$annoncepropre->id]['totalSanspromo'] != 0) { ?><span class="float-right"><span class="totalSpromo mr-2"><?php echo number_format($prixtotalpourpetiteannonceres[$annoncepropre->id]['totalSanspromo'],2)." €"; ?></span><span class="totalWpromo"><?php echo number_format($prixtotalpourpetiteannonceres[$annoncepropre->id]['prixTotal'],2)." €"; ?></span></span><?php }else{ ?><span class="float-right"><?php echo number_format($prixtotalpourpetiteannonceres[$annoncepropre->id]['prixTotal'],2)." €"; ?></span><?php } ?></p>             
                                        <p class="border-bottom pb-3"><span class="resleft"><?= __("Taxe de séjour"); ?> </span><span class="float-right"><?php echo number_format($prixtotalpourpetiteannonceres[$annoncepropre->id]['taxeDeSejour'],2); ?> €</span></p>             
                                        <p class="border-bottom pb-3"><span class="resleft tooltipservice"><?= __("Frais de service"); ?> </span><span class="float-right"><?php echo number_format($prixtotalpourpetiteannonceres[$annoncepropre->id]['fraisService'],2); ?> €</span></p>                           
                                        <p class=""><span class="resleft tooltipservice"><?= __("Total"); ?></span><span class="float-right"><?php echo number_format($prixtotalpourpetiteannonceres[$annoncepropre->id]['totalPrixPayer'],2); ?> €</span></p>             
                                    </div>
                                </div>
                            </li>
                        </ul> 
                      </span>
                    </div>
                  <?php } ?>                    
                  <!-- </p> -->
              <?php  }         
              }else{ ?>
                <p id="partoneprice_<?php echo $annoncepropre->id; ?>" class="mb-1"></p>
                <p id="parttwoprice_<?php echo $annoncepropre->id; ?>" class="mt-1"></p> 
              <?php } ?>
              <?php 
                if($debutrech != '' && $finrech != ''){
                  if($nbradlt != '' && $nbrenf != '') $urlreservan = $hrefDetailAnn.'/'.$debutrech.'/'.$finrech.'/'.$nbradlt.'/'.$nbrenf;
                  else $urlreservan = $hrefDetailAnn.'/'.$debutrech.'/'.$finrech;
                }else{
                  $urlreservan = $hrefDetailAnn;
                } 
              ?>
              <a class="btn btn-blue text-white rounded-0 w-75" href="<?php echo $urlreservan; ?>">Réserver</a>
            </span>
          </div>
        </div>
      <?php } ?>      
    <?php } ?>
    <!-- FIN Nouvelle partie pour propriétaire-résidence -->
    <h2 class="h1 mb-3"><?= __("Localisation") ?></h2>
    <div class="row px-3">
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Bâtiment") ?> : <?php if($residence->name_url != "") { ?><a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['station'].'/'.$residence['village']['lieugeo']->nom_url.'/residence-'.$residence->name_url; ?>"> <?php echo convertstr($residenceAnnonce[$annonce->batiment]['title']); ?></a> <?php }else { echo convertstr($residenceAnnonce[$annonce->batiment]['title']); } ?> 
      </div>
      <?php if($propannonce->nature != "PRES"){ ?>
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Etage") ?> : <?php echo $annonce->etage; ?>               
      </div>
      <?php } ?>
      <?php if($annonce->ski_pied==1 || $annonce->moins_50_piste==1){ ?>
      <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
        <?= __("Pistes") ?> : <?php if($annonce->ski_pied==1){?>
                  <?= __("Skis aux pieds") ?>
                <?php }?>
                <?php if($annonce->moins_50_piste==1){?>
                  <?= __("Moins de 50 m") ?>
                <?php }?>
      </div>
      <?php } ?>
    </div>

    <div id="mapdiv" class="col-md-12 maprelative px-0 mt-4 mb-3">
      <div id="map" style="width:100%; height:100%"></div>
    </div>
    <?php $situationListe = ""; if($annonce->centre_comm==1 || $annonce->bien_etre==1 || $annonce->espace_sportif==1 || $annonce->lieux_anim==1|| $annonce->espace_enfant==1 || $annonce->sentier_pedestre==1){ ?>
    <div class="row px-3 mb-3 align-items-center">
      <div class="col col-md-1">
        <svg class="fill-black" aria-hidden="true" width="30" height="30" viewBox="0 0 61.45 78.8">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/localisation.svg#Calque_2"></use>
        </svg>
      </div>
      <div class="col-10 col-md-11">
        <?= __("Situation") ?> : <?php if($annonce->centre_comm==1){ echo __('Proche d\'un centre Commercial').', '; $situationListe .= 'Proche d\'un centre Commercial, ';?>
                    <?php if($annonce->restaurant==1){ echo __('Restaurants').', ';}?>
                    <?php if($annonce->velos==1){ echo __('Location de vélos').', ';}?>
                    <?php if($annonce->loc_ski==1){ echo __('Location de ski').', ';}?>
                    <?php if($annonce->remontee_caisse==1){ echo __('Caisses de remontés mécaniques').', ';}?>
                    <?php if($annonce->transport_public==1){ echo __('Proche des transports publics').', ';}?>
                    <?php }?>
                    <?php if($annonce->bien_etre==1){ echo __('Proche des centres de bien etre').', '; $situationListe .= 'Proche des centres de bien etre, ';?>
                    <?php if($annonce->spa==1){ echo __('Spas').', ';}?>
                    <?php if($annonce->hammam==1){ echo __('Hammam').', ';}?>
                    <?php if($annonce->sauna==1){ echo __('Sauna').', ';}?>
                    <?php if($annonce->jacuzzi==1){ echo __('Jacuzzi').', ';}?>
                    <?php if($annonce->massage==1){ echo __('Massage').', ';}?>
                    <?php if($annonce->accespiscine==1){ echo __('Acces Piscine').', ';}?>
                    <?php }?>
                    <?php if($annonce->espace_sportif==1){ echo __('Proche des espaces sportifs été/hiver').', '; $situationListe .= 'Proche des espaces sportifs été/hiver, ';?>
                    <?php if($annonce->ski_pied==1){ echo __('Skis aux pieds').', ';}?>
                    <?php if($annonce->cours_tennis==1){ echo __('Cours de Tennis').', ';}?>
                    <?php if($annonce->piscine==1){ echo __('Piscine').', ';}?>
                    <?php if($annonce->squash==1){ echo __('Squash').', ';}?>
                    <?php if($annonce->patinoire==1){ echo __('Patinoire').', ';}?>
                    <?php if($annonce->golf==1){ echo __('Golf').', ';}?>
                    <?php } ?>
                    <?php if($annonce->lieux_anim==1|| $annonce->espace_enfant==1){?>
                    <?php if($annonce->espace_enfant==1){ echo __('Proche des espaces enfants').', '; $situationListe .= 'Proche des espaces enfants, ';?>
                    <?php if($annonce->luge==1){ echo __('Luge').', ';}?>
                    <?php if($annonce->club_enfant==1){ echo __('Club Enfant').', ';}?>
                    <?php if($annonce->garderie==1){ echo __('Garderie').', ';}?>
                    <?php if($annonce->ecole_ski==1){ echo __('Ecole de Ski').', ';}?>
                    <?php }?>
                    <?php if($annonce->lieux_anim==1){ echo __('Proche des lieux d\'animation').', '; $situationListe .= 'Proche des lieux d\'animation, ';?>
                    <?php if($annonce->bar==1){ echo __('Bars').', ';}?>
                    <?php if($annonce->pub==1){ echo __('Pubs').', ';}?>
                    <?php if($annonce->Disco==1){ echo __('Discothèques').', ';}?>
                    <?php }}?>
                    <?php if($annonce->sentier_pedestre==1){ echo __('Sentiers pédestres').', '; $situationListe .= 'Sentiers pédestres, ';
                    if($annone->moins_50_sentiers==1) {echo __('Moins de 50 m'); $situationListe .= 'Moins de 50 m ';}
                    } ?>
      </div>
    </div> 
    <?php } ?>   

<script type="application/ld+json"> {
"@context": "http://schema.org",
<?php if($listerating->count() > 0){ ?>
"@type": ["Product", "Accommodation"],
<?php }else{ ?>
"@type": ["Accommodation"],
<?php } ?>
"name": "<?php echo $annonce->titre; ?>",
"description": "<?php echo $annonce->titre; ?>", 
"petsAllowed": <?php if($annonce->ani_co_yn == 0){echo "false";} else{echo "true";}?>,
"image": "<?php echo $nomImgGLien; ?>",
<?php if($listerating->count() > 0){ ?>
// CHAMPS AGGREGATERATING À CACHER SI PAS DE RATING SUR L’ANNONCE //
"aggregateRating": {
  "@type": "AggregateRating", 
  "bestRating": 5, 
  "ratingValue": <?php echo round(($noteglobalmoy/3), 1); ?>, 
  "reviewCount": <?php echo $listerating->count() ?>
},
// CHAMPS AGGREGATERATING À CACHER SI PAS DE RATING SUR L’ANNONCE //
<?php } ?>
"amenityFeature": [
  {"@type": "LocationFeatureSpecification", "name": "Montagne", "value": "true"},
  {"@type": "LocationFeatureSpecification", "name": "Location entre particuliers", "value": "true"},
  {"@type": "LocationFeatureSpecification", "name": "Station de ski", "value": "true"},
  {"@type": "LocationFeatureSpecification", "name": "Ski", "value": "true"},
  {"@type": "LocationFeatureSpecification", "name": "Pied des pistes", "value": "true"},
  {"@type": "LocationFeatureSpecification", "name": "Ski", "value": "true"}, 
  {"@type": "LocationFeatureSpecification", "name": "VTT", "value": "true"},
  {"@type": "LocationFeatureSpecification", "name": "Alpinisme", "value": "true"}, 
  {"@type": "LocationFeatureSpecification", "name": "Randonnée", "value": "true"}, 
  {"@type": "LocationFeatureSpecification", "name": "Patinage", "value": "true"}, 
  {"@type": "LocationFeatureSpecification", "name": "Escalade", "value": "true"}, 
  {"@type": "LocationFeatureSpecification", "name": "Rafting", "value": "true"}, 
  {"@type": "LocationFeatureSpecification", "name": "Luge", "value": "true"},
  {"@type": "LocationFeatureSpecification", "name": "Eaux Vives", "value": "true"}, 
  {"@type": "LocationFeatureSpecification", "name": "<?php echo $conditionDipos; ?>", "value": "true"}, 
  {"@type": "LocationFeatureSpecification", "name": "<?php echo $annonce->chambres_nb; ?> chambres", "value": "true"},
  {"@type": "LocationFeatureSpecification", "name": "Non-fumeur : <?php if($annonce->non_fumeur == 0) echo "Non"; else echo "Oui"; ?>" , "value": "true"},
  <?php if($espaceLudique != ""){ ?>
  {"@type": "LocationFeatureSpecification", "name": "Espace ludique : <?php echo $espaceLudique; ?>", "value": "true"},
  <?php } ?>
  {"@type": "LocationFeatureSpecification", "name": "Vue : <?php if($annonce->vue == 1) echo "Vallée"; else if($annonce->vue == 2) echo "Pistes";else if($annonce->vue == 3) echo "Station"; else if($annonce->vue == 4) echo "Autre"; ?>", "value": "true"}, 
  {"@type": "LocationFeatureSpecification", "name": "Surface : <?php echo $annonce->surface." m²"; ?>", "value": "true"},
  {"@type": "LocationFeatureSpecification", "name": "Extérieur : <?php if($annonce->balcon_yn == 1) echo "Balcon "; if($annonce->terasse_yn == 1) echo "Terrasse "; if($annonce->jardin_yn) echo "Jardin "; if($annonce->espace_plein_air) echo "Espace pour les repas en plein air "; ?>", "value": "true"},
  {"@type": "LocationFeatureSpecification", "name": "Mobilier : <?php 
  if($annonce->placard == 1) echo "Placards ";
  if($annonce->penderie == 1) echo "Penderie ";
  if($annonce->Table_existe == 1) echo "Table ";
  if($annonce->chaises == 1) echo "Chaises ";
  if($annonce->clic_clac_existe == 1) echo "Banquette Clic Clac ";
  if($annonce->BZ_existe == 1) echo "Banquette BZ ";
  if($annonce->tabouret == 1) echo "Tabourets ";
  if($annonce->literie_existe == 1) echo "Literie ";
  if($annonce->oreillers == 1) echo "Oreillers ";
  if($annonce->couvertures == 1) echo "Couvertures ";
  if($annonce->couettes == 1) echo "Couettes ";
  if($annonce->protege_matelas == 1) echo "Protèges Matelas ou Alèzes ";
   ?>", "value": "true"},
  {"@type": "LocationFeatureSpecification", "name": "Électroménager : <?php echo $electromenager; ?>", "value": "true"},
  {"@type": "LocationFeatureSpecification", "name": "Situation : <?php echo $situationListe; ?>", "value": "true"}
] }
</script>

    <div class="row mb-3 mt-5">
      <div class="col-auto">
        <h2 class="h1 mb-3"><?= __("Découvrez ce qu'ils en ont pensé") ?></h2>
      </div>
      <?php if ($this->Session->check('Auth.User.id') && in_array($this->Session->read('Auth.User.id'), $listlocataires) && ($locnote->count()==0) && $this->Session->read('Auth.User.id') != $propannonce->id && isset($statutreservation) && !empty($statutreservation->toArray())) { ?>
      <div class="col noter px-0">
        <button class="btn btn-blue text-white rounded-0" type="button" style="float:right" data-toggle="modal" data-target="#noterModal"><?= __("Noter cette annonce") ?></button>
      </div>
      <?php } ?>
    </div>
    <?php if($listerating->count() > 0){ ?>
    <div class="row px-3" <?php echo ($listerating->count() > 0 ? 'itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"' : '');?> >
      <?php if($listerating->count() > 0){ ?>
        <meta itemprop="itemReviewed" content="Annonce <?php echo $annonce->id; ?>" />
        <meta itemprop="ratingCount" content="<?php echo $listerating->count() ?>" />
        <meta itemprop="ratingValue" content="<?php echo round(($noteglobalmoy/3), 1); ?>">
      <?php } ?>
      <div class="col carreGris p-3 mr-1 mb-1 text-center font-weight-normal rounded">
        <?= __("Confort") ?> <br> 
        <input id="confortrating" name="confortrating" value="<?php echo ($listerating->count() != 0 ? round(($notecara['confort']/$listerating->count()), 1) : 0) ;?>" class="rating-loading form-control">
      </div>
      <div class="col carreGris p-3 mr-1 mb-1 text-center font-weight-normal rounded">
        <?= __("Emplacement") ?> <br>  
        <input id="emplacementrating" name="emplacementrating" value="<?php echo ($listerating->count() != 0 ? round(($notecara['emplacement']/$listerating->count()), 1) : 0) ; ?>" class="rating-loading form-control">
      </div>
      <div class="col carreGris p-3 mr-1 mb-1 text-center font-weight-normal rounded">
        <?= __("Qualité / prix") ?> <br>  
        <input id="qualiterating" name="qualiterating" value="<?php echo ($listerating->count() != 0 ? round(($notecara['qualiteprix']/$listerating->count()), 1) : 0) ; ?>" class="rating-loading form-control">
      </div>
    </div>
    <?php }else{ ?>
      <div class="row px-3 mt-3">
        <p><?= __("Aucun voyageur n'a laissé d'avis sur l'hébergement de {0} pour l'instant. Vous pouvez cependant réserver cet hébergement en toute confiance, toutes les annonces présentes sur Alpissime sont vérifiées par notre équipe", ucfirst($propannonce->prenom)) ?>.</p>
      </div>
    <?php } ?>

    <?php if($listerating->count() > 0){ ?>
    <div class="row px-3 mt-3">      
      <p><?= __("L'hébergement de {0} est noté {1}/5 par {2} vacanciers y ayant séjourné", [ucfirst($propannonce->prenom), round(($noteglobalmoy/3), 1), $listerating->count()]) ?>.</p>
    </div>

    <?php $i=1; foreach ($listerating as $value) { ?>
      <div class="row px-3 mb-2 contentimg" itemprop="review" itemscope itemtype="http://schema.org/Review" <?php if($i > 3) echo "style='display:none;'"; ?>>
        <meta itemprop="author" content = "<?php echo $value['utilisateur']['prenom']." ".substr($value['utilisateur']['nom_famille'], 0, 1)."."; ?>">
        <meta itemprop="itemReviewed" content="Rate <?php echo $value->id ?>">
        <div class="col carreGris rounded px-4 pb-4 pt-3" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
          <meta itemprop="worstRating" content = "0">
          <meta itemprop="ratingValue" content="<?php echo round(($notecommentaireuser[$value->id]/3), 1); ?>">
          <meta itemprop="bestRating" content="5">
          <meta itemprop="name" content="<?php echo $value->titre ?>">
          <input id="rate<?php echo $i; ?>" name="rate<?php echo $i; ?>" value="<?php echo round(($notecommentaireuser[$value->id]/3), 1); ?>" class="rating-loading"><span class="float-right"><?= __("Publié le") ?> <?php echo $value->created->i18nFormat('dd/MM/yyyy'); ?></span>
          <p class="m-0"><strong><?php echo ucfirst($value['utilisateur']['prenom'])." ".substr($value['utilisateur']['nom_famille'], 0, 1)."."; ?></strong></p>
          <p class="m-0 pb-1 font-weight-light font-italic"><?= __("A séjourné en") ?> <?php echo ucfirst($reservationDate[$value->id]->dbt_at->i18nFormat('MMMM yyyy')); ?></p>
          <p class="m-0 pb-3 font-weight-normal" itemprop="description"><?php echo $value->commentaire ?></p>
          <?php if($this->Session->read('Auth.User.id') == $propannonce->id && $reponsefeedback[$value->id] == ""){ ?>
            <button type="button" class="btn btn-blue text-white rounded-0 repondreavis mt-3 float-right" onclick="openrepondreavis(<?php echo $value->id ?>)"><?= __("Répondre") ?></button>
          <?php } ?>
          <?php if($reponsefeedback[$value->id] != ""){ ?>
            <?php $reponsefeed = $reponsefeedback[$value->id]; ?>
            <a class="font-weight-normal" id="link<?php echo $value->id ?>" onclick="afficherreponse(this, <?php echo $value->id ?>)"><u><?= __("Afficher la réponse") ?></u></a>
            <div class="font-weight-normal" id="<?php echo $value->id ?>" style="display:none;">
              <strong><?= __("Réponse propriétaire") ?> : </strong><br>
              <p class="m-0 py-2"><?php echo $reponsefeed->reponse; ?></p>
              <a id="linkhide" onclick="cacherreponse(<?php echo $value->id ?>)"><u><?= __("Masquer la réponse") ?></u></a>
            </div>
          <?php } ?>
        </div>
        
      </div>
      <?php $i++; } ?>
      
      <?php if($listerating->count() > 3){ ?>
          <div class="row py-3">
              <div class="col-auto">
                <u><a class="font-weight-500" id="loadMore"><?= __("Afficher plus d'avis") ?></a></u>
              </div>
          </div> 
      <?php } ?>

      <p class="font-weight-light font-italic"><?= __("Pour déposer un avis, un voyageur doit avoir séjournée dans l'hébergement concerné. Les avis font l'objet d'une vérification manuelle par notre équipe") ?>.</p>
    <?php } ?>

    <h2 class="h1 mb-3"><?= __("Composez votre séjour montagne n'a jamais été aussi simple avec Alpissime") ?>.</h2>
    <div class="row px-3">
      <div class="col-sm-12 col-md carreGris pt-4 pb-3 px-3 mb-1 mr-1 text-center font-weight-normal rounded">
        <svg aria-hidden="true" width="50" height="50" viewBox="0 0 20 20">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/Fichier 1check.svg#Calque_2"></use>
        </svg> 
        <h4 class="mt-4"><?= __("Réservez en un clic") ?></h4> 
        <p class="m-0"><?= __("Vos vacances seront confirmées dès que {0} aura accepté votre demande de réservation", ucfirst($propannonce->prenom)) ?></p> 
      </div>
      <div class="col-sm-12 col-md carreGris pt-4 pb-3 px-3 mb-1 mr-1 text-center font-weight-normal rounded">
        <svg aria-hidden="true" width="50" height="50" viewBox="0 0 79.79 79.79">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/Fichier 1lock.svg#Calque_2"></use>
        </svg>
        <h4 class="mt-4"><?= __("Location PAP Vérifié") ?></h4> 
        <p class="m-0"><?= __("Toutes nos annonces sont 100% vérifiées par l'équipe Alpissime. Ici, pas d'arnaque à la location !") ?></p>   
      </div>
      <div class="col-sm-12 col-md carreGris pt-4 pb-3 px-3 mb-1 mr-1 text-center font-weight-normal rounded">
        <svg aria-hidden="true" width="50" height="50" viewBox="0 0 17.29 17.29">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/Fichier 1star2.svg#Calque_2"></use>
        </svg>          
        <h4 class="mt-4"><?= __("Composez votre séjour") ?></h4> 
        <p class="m-0"><?= __("A la prochaine étape, ajoutez des services et activités et payez jusqu'à 4x sans frais") ?>.</p>  
      </div>
    </div>
    <?php if($annonces->count()>0){ ?>
      <h2 class="h1 my-5"><?= __("D'autres voyageurs ont aussi consulté") ?></h2>
      <div class="annonce block products row">
        <?php  $c=1; foreach($annonces as $ann) { ?>
          <div class="col-6 col-sm-6 col-md-4 px-2 <?php if($c == 4) echo 'd-block d-md-none d-lg-none';?> " style="margin-bottom:10px">
            <div class="featured-product">

            <?php echo $this->element('petite_annonce', array('annonce'=>$ann, 'photo'=>$photosCont, 'residence'=>$residenceAnnonce, 'minprixannonce'=>$minprixannonce, 'noteglobalmoy'=>$noteglobalmoytab, 'db'=>$debutrech, 'fn'=>$finrech, 'prixtotalpourpetiteannonce' => $prixtotalpourpetiteannonce) ); ?>

            </div>
          </div>
        <?php
          $c++; }
        ?>
      </div>
      <a class="btn btn-blue text-white rounded-0 float-right" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['recherche'];?>?<?php echo $similaire; ?>">
      <?= __("Voir les annonces similaires") ?></a>
    <?php } ?>
    
            
          
      </div>
      <div class="col-lg-4">
         
         <div id="accordion" role="tablist" aria-multiselectable="true" class="mt-3">
           <div class="shadow-sm border p-3 block-resv rounded-top">
            <h2 class="text-center h1"><?= __("Réservation") ?></h2>
    
        <div class="block search" id="reservationloc">
          <div class='ad_search_content'>
          <div class="form-group mb-1">
								<!-- <label><?= __("Dates") ?></label> -->
								<div class="row">
								    <div class="col-md-6 col-sm-12 pr-md-0 location_du">
                                        <div class="input-group mb-2">
                                            <input id="location_du" class="form-control location calendrier" name="dbt" placeholder="jj-mm-aaaa" readonly />
                                            <div class="input-group-append">
                                                <div class="input-group-text"><label class="add-on mb-0" for="location_du"><i class="fa fa-calendar"></i></label></div>
                                            </div>
                                        </div>
                                    </div>
							        <div class="col-md-6 col-sm-12 pl-md-0 mt-3 mt-md-0 location_au">
                                        <div class="input-group mb-2">
                                            <input id="location_au" class="form-control location calendrier" name="fin" placeholder="jj-mm-aaaa" readonly />
                                            <div class="input-group-append">
                                                <div class="input-group-text"><label class="add-on mb-0" for="location_au"><i class="fa fa-calendar"></i></label></div>
                                            </div>
                                        </div>
                                    </div>
								</div>
              </div>
              <div class="form-group nbCouchage-group reservetion-group mb-4">
								<!-- <label><?= __("Voyageurs") ?></label> -->
								<!-- <div class="row">
								    <div class="col-6 pr-0 nbradulte">
								        <input id="nbradulte" name="nbradulte" data-prefix="<?= __('Adultes') ?>" value="1" min="1" step="1" type="number" />
								    </div>
								    <div class="col-6 pl-0 nbrenfant">
								        <input id="nbrenfant" name="nbrenfant" data-prefix="<?= __('Enfants') ?>" value="0" min="0" step="1" type="number" />
								    </div>
								</div>   -->
                <div class="row">
                  <div class="iqdropdown mx-3">
                    <p class="iqdropdown-selection"></p>
                    <div class="iqdropdown-menu px-3">
                      <div class="iqdropdown-menu-option border-bottom p-0" data-defaultcount="1" data-id="nbradulte">
                        <div>
                          <p class="iqdropdown-item"><?= __('Adultes') ?></p>
                          <p class="iqdropdown-description"><?= __('Vacanciers de plus de 18 ans') ?></p>
                        </div>
                      </div>
                      <div class="iqdropdown-menu-option border-bottom p-0" data-id="nbrenfant">
                        <div>
                          <p class="iqdropdown-item"><?= __('Enfants') ?></p>
                          <p class="iqdropdown-description"><?= __('Vacanciers de moins de 18 ans') ?></p>
                        </div>
                      </div>
                      <div class="py-3 row">
                        <div class="col-9">
                            <label <?php if($annonce->accept_animaux == 0) echo 'class="disabledlabel"' ?> for=""><?= __("Animaux Acceptés") ?></label>
                        </div>
                        <label class="switch">
                            <input id="<?php echo $urlvaluemulti["animaux"]; ?>" name="<?php echo $urlvaluemulti["animaux"]; ?>" type="checkbox" <?php if($annonce->accept_animaux == 0) echo "disabled='disabled'"; ?>>
                            <span class="slider round shadow-sm"></span>
                        </label>
                        <?php 
                        // if($annonce->accept_animaux == 0) echo $this->Form->input($urlvaluemulti["animaux"],[
                        //               'id'=>'animaux',
                        //               'label'=>false,
                        //               'templates' => ['inputContainer' => "{{content}}"],
                        //               'type'=>'checkbox',
                        //               //'size'=>'auto',
                        //               'disabled'=>"disabled",
                        //               'hiddenField'=>false,
                        //               'checked'=>$this->request->query['animaux']]);
                        //       else echo $this->Form->input($urlvaluemulti["animaux"],[
                        //         'id'=>'animaux',
                        //         'label'=>false,
                        //         'templates' => ['inputContainer' => "{{content}}"],
                        //         'type'=>'checkbox',
                        //         //'size'=>'auto',
                        //         'hiddenField'=>false,
                        //         'checked'=>$this->request->query['animaux']]);
                                      ?>
                        <?php // if($annonce->accept_animaux == 0){ ?>
                          <!-- <label for="animaux" class="disabledlabel"><?= __("Animaux Apportés") ?></label> -->
                        <?php // }else{ ?>
                          <!-- <label for="animaux"><?= __("Animaux Apportés") ?></label> -->
                        <?php // } ?>
                        <?php if($annonce->accept_animaux == 0) echo "<p class='iqdropdown-description px-3'>".__("Le propriétaire a choisi de ne pas accepter les animaux de compagnie")."</p>"; ?>
                      </div>
                    </div>
                  </div>
                </div> 
							</div>
            
            
            <div id="blockdetailprix" style="display:none">
              <p id="nombretotalnuitee" class="border-bottom pb-3"></p>             
              <p id="automaticPromo" class="border-bottom pb-3"></p>
              <p id="taxesejourtotal" class="border-bottom pb-3"></p>
                <p id="fraisdeservice" class="border-bottom pb-3"><span class="resleft tooltipservice"><?= __("Frais de service") ?> <a href="#" class="tooltipsvc" data-toggle="tooltip" data-placement="right" title="<p><?= __('Les frais de services permettent le fonctionnement d\'Alpissime, la réservation en ligne sécurisée et l\'accès au service client.') ?></p> <p><?= __('Les frais de services incluent la TVA à 20%') ?></p>"><i class="fa fa-question-circle-o"></i></a> </span><span class="resright">119 €</span></p>
              <p id="fraisdemenage" class="border-bottom pb-3"></p>    
              <p id="fraisanimaux" class="border-bottom pb-3"></p> 
              <p id="totalpayer" class=""><span class="resleft tooltipservice"><?= __("Total") ?>

              <?php if(!empty($propannonce->cautions)){ ?>
                <a href="#" class="tooltipsvc" data-toggle="tooltip" data-placement="right" title="<p><?php echo htmlentities($propannonce->cautions[0]->description); ?></p>">
              <?php }else{ ?>
                <a href="#" class="tooltipsvc" data-toggle="tooltip" data-placement="right" title="<p><?= __('Une empreinte de votre moyen de paiement sera stockée de manière sécurisée par notre partenaire de paiement afin d’assurer la caution de l’hébergement') ?>
                <?php if($annonce->caution != 0){ ?>(<?= __('à hauteur') ?> de <?php echo $annonce->caution; ?>€) <?php } ?>
                . <br><?= __('Celle-ci sera automatiquement effacée si aucun dommage n’est signalé.') ?></p>">
              <?php } ?>      
              <i class="fa fa-question-circle-o"></i>
              </a> 
              </span><span class="resright"></span></p>             
              <p id="resultatdispo" class="border-bottom pb-3"></p>
            </div>
            <?php echo $this->Form->create(null,['id'=>'reserverform', 'url'=>['controller'=>'reservations','action'=>'confirmreservations']]); ?>
            <?php echo $this->Form->input("annonce_id",["type"=>"hidden","value"=>$annonce->id])?>
            <input type="hidden" id="totalapayer" name="totalapayer" />
            <input type="hidden" id="prixreservation" name="prixreservation" />
            <input type="hidden" id="prixtaxesejour" name="prixtaxesejour" />
            <input type="hidden" id="prixfraiservice" name="prixfraiservice" />
            <input type="hidden" id="nbradultehidden" name="nbradultehidden" value="1" />
            <input type="hidden" id="nbrenfanthidden" name="nbrenfanthidden" value="0" />
            <input type="hidden" id="apporteranimauxhidden" name="apporteranimauxhidden" />
            <?php echo $this->Form->input("creationReservationLocpaiementdirectHidden",['type'=>'hidden','value'=>'']); ?>
            
            <span id="periodedispo"></span>            
            <button style="display:none;" type="button" class="submit_reserv btn btn-pink left w-100 text-white" name="valider" id="valider"><?= __("Réserver") ?> </button>
            <span class='text-danger' id='informationtext'></span>
            <div class="text-small text-annulation" style="display:none;"></div>
            <?php echo $this->Form->end();?>
          </div>
          <button type="button" class="submit_reserv btn btn-success hvr-sweep-to-top right d-none" onclick="chercherdisponibilite()" id="validersearch"><?= __("Chercher") ?></button>
          <div class="clearfix"></div>
        </div>
        
        </div><!-- #accordion -->        
        <div class="overlay-rsv"></div>
        <div class="col-12 d-lg-none position-fixed fixed-bottom">
          <div class="bg-white shadow-lg p-2 d-flex flex-wrap justify-content-between align-items-center rounded-top">
            <?php if($minprixannoncedetail[$annonce->id]['prixmin']) {
              if($debutrech != "" && $finrech != ""){ ?>
                <span class="font-weight-bold my-auto" style="font-size:1rem;"> <?php echo $minprixannoncedetail[$annonce->id]['prixmin']; ?> / <?= __("nuit") ?></span>
                <span class="my-auto font-weight-bold" style="font-size:1rem;"><ul class="mb-0"><li><?php echo $prixtotalpourpetiteannoncedetail[$annonce->id]['totalPrixPayer']." € au total"; ?></li></ul></span> 
                <button type="button" class="submit_reserv btn btn-pink left rounded-0 text-white my-auto mx-auto" name="reserver-show" id="reserver-show"><?= __("Réserver") ?> </button>
              <?php }else{ ?>
                <span class="font-weight-bold" style="font-size:1rem;"> Dès <?php echo $minprixannoncedetail[$annonce->id]['prixmin']; ?> / <?= __("nuit") ?></span> 
                <button type="button" class="submit_reserv btn btn-pink left rounded-0 text-white" name="reserver-show" id="reserver-show"><?= __("Réserver") ?> </button>
            <?php }
            } ?>
          </div>
        </div> 
        <?php if($propannonce->nature == "PRES"){ ?>
          <div class="shadow-sm border p-3 mt-3 text-center">
            <h4><?php echo ucfirst($propannonce->prenom); ?></h4>
            <p>
              <?php echo $propannonce->description; ?>
            </p>
            <?php if(!empty($propannonce->annulations)){ ?>
              <p><a href="#" data-toggle="modal" data-target="#conditionannulationmodal"><u>Conditions d'annulation</u></a> <?php echo ucfirst($propannonce->prenom); ?></p>
            <?php } ?>
          </div>
        <?php }else{ ?>
          <div class="shadow-sm border p-3 mt-3 text-center">
            <?php $Name =  $propannonce->nom_famille;
            $firstlettername = $Name[0]; ?>
            <h4><?php echo ucfirst($propannonce->prenom)." ".ucfirst($firstlettername)."."; ?></h4>
            <a href="#" id="clickcontactprop" class="font-weight-bold text-blue"><?= __("Contacter le propriétaire") ?></a>
          </div>
        <?php } ?>
        
        <div class="shadow-sm border p-3 mt-3 text-center btn-sociaux">
          <h4><?= __("Partager cet hébergement") ?></h4>
          <div class="form-group">
            <span class="share_this">
              <?php
              function formatStr($titre)
              {
                $str = strtr($titre,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
                $str = str_replace("é","e",$titre);
                $str = str_replace("è","e",$str);
                $str = str_replace("ê","e",$str);
                $str = str_replace("à","a",$str);
                $str = str_replace("â","a",$str);
                $str = str_replace("ä","a",$str);
                $str = str_replace("î","i",$str);
                $str = str_replace("ï","i",$str);
                $str = str_replace("ô","o",$str);
                $str = str_replace("ö","o",$str);
                $str = str_replace("ù","u",$str);
                $str = str_replace("û","u",$str);
                $str = str_replace("ü","u",$str);
                $str = str_replace(",","-",$str);
                $str = str_replace("'","-",$str);
                $str = str_replace(" ","-",$str);
                $str = str_replace("(","",$str);
                $str = str_replace(")","",$str);
                $str = str_replace("É","e",$str);
                $str = str_replace("%","pourcent",$str);
                $str = str_replace("œ","oe",$str);
                $str = str_replace("Œ","oe",$str);
                $str = str_replace("€","euros",$str);
                $str = str_replace("/","-",$str);
                $str = str_replace("+","-",$str);
                $str = str_replace("ç","c",$str);
                $str = str_replace("*","",$str);
                $str = str_replace("?","",$str);
                $str = str_replace("!","",$str);
                $str = str_replace("°","",$str);
                $str = str_replace("<","",$str);
                $str = str_replace(">","",$str);
                $str = str_replace("----","-",$str);
                $str = str_replace("---","-",$str);
                $str = str_replace("--","-",$str);
                $str = str_replace("²","",$str);
                $str = str_replace(":","",$str);
                return htmlentities($str);
              }

                  ?>
                    <?php 
                    $natureAnnURL = array("STD"=>__("studio"),"APP"=>__("appartement"),"CHA"=>__("chalet"),"DIV"=>__("location"),"VIL"=>__("villa"),"GIT"=>__("gite"));
                    $lannonce = strtolower(str_replace(" ","-",trim(formatStr($annonce["titre"]))));
                    $url = $this->Url->build('/', true);
                    $hrefDetailAnn = $urlvaluemulti['station'].'/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;
                    $adr = $this->Url->build('/',true).$urlLang.$hrefDetailAnn; ?>

                    <span><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $adr ?>&amp;src=sdkpreparse" target="_blank"><i class="fa fa-facebook"></i></a></span>
                    <span><a href="https://twitter.com/share?url=<?php echo urlencode($adr) ?>" target="_blank"><i class="fa fa-twitter"></i></a></span>
                    <span><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($adr) ?>" target="_blank"><i class="fa fa-linkedin"></i></a></span>
                    <span><a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($adr) ?>" target="_blank"><i class="fa fa-pinterest-p"></i></a></span>
             </span>                                
           </div>
          </div>
        <?php if($propannonce->nature != "PRES"){ ?>
          <div class="shadow-sm border p-3 mt-3 text-center">
            <h4><?= __("A propos") ?></h4>
            <p><span style="font-size: 15px">
              <?= __("Référence de l'annonce") ?> : <span class="font-weight-bold"><?php echo $annonce->id; ?></span>
            <?php if($annonce->num_enregistrement != ''){ ?>
              <br>
              <?= __("Numéro d'immatriculation") ?> : <span class="font-weight-bold"><?php echo $annonce->num_enregistrement; ?></span>
            <?php } ?>  
              <br>
              <?= __("Propriétaire") ?> : <span class="font-weight-bold"><?php if($annonce->statut_loueur == 0) echo __("Loueur particulier"); else echo __("Loueur professionnel"); ?></span>      
            </span></p>
          </div>
        <?php } ?>  
        
         </div><!-- #accordion-sticky-wrapper -->
      </div> <!-- col-md-4-->
        
</div> <!-- row-->
  


  <!-- Rating -->
    
  <!-- <div class="rowrating2"> -->
                
  
  <!-- <hr> -->
  <!-- Modal -->
  <div class="modal fade" id="noterModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><?= __("Partager votre expérience") ?> !</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="post" accept-charset="utf-8" class="form-horizontal" onsubmit="return confirmratingadd()" action="<?php echo $this->Url->build('/',true)?>annonces/ratingadd">

        <div class="modal-body">
            <input type="hidden" name="annonce_id" value="<?php echo $annonce->id; ?>">
            <input type="hidden" id="noterutilid" name="utilisateur_id" value="<?php echo $this->Session->read('Auth.User.id')?>">
            <div class="col-md-12 block">
              <label><strong> <?= __("Comment évaluez-vous les critères suivants ?") ?></strong></label>
            </div>
            <div class="col-md-12 block">
              <div class="row">
              <div class="col-md-4">
                <label class="label-avis"><?= __("Confort et équipement") ?></label>
                <input id="confortratingadd" name="confort" value="0" class="rating-loading">
                <label id="confortratingaddLabel" style="display: none;"><span class="error_formul"> <?= __("Choix obligatoire") ?></span></label>
              </div>
              <div class="col-md-4">
                <label class="label-avis"><?= __("Localisation") ?></label>
                <input id="emplacementratingadd" name="emplacement" value="0" class="rating-loading">
                <label id="emplacementratingaddLabel" style="display: none;"><span class="error_formul"> <?= __("Choix obligatoire") ?></span></label>
              </div>
              <div class="col-md-4">
                <label class="label-avis"><?= __("Rapport Qualité/Prix") ?></label>
                <input id="qualiteratingadd" name="qualiteprix" value="0" class="rating-loading">
                <label id="qualiteratingaddLabel" style="display: none;"><span class="error_formul"> <?= __("Choix obligatoire") ?></span></label>
              </div>
              </div>
            </div>
            <div class="col-md-12 block">
              <label><strong> <?= __("Donner un titre à votre avis") ?><sup class="orange">*</sup></strong></label>
              <input type="text" class="form-control" id="titrefeedback" name="titre">
              <label id="titrefeedbackLabel" style="display: none;"><span class="error_formul"> <?= __("Merci de renseigner le titre de votre avis.") ?></span></label>
            </div>
            <div class="col-md-12 block">
              <label><strong><?= __("Votre Commentaire") ?><sup class="orange">*</sup></strong></label>
              <textarea maxlength="360" id="commentairefeedback" name="commentaire" class="form-control" rows="8" cols="80"></textarea>
              <label><span class="commentairecaractere"> *<?= __("Votre commentaire ne doit pas dépasser 360 caractères") ?></span></label>
              <label id="commentairefeedbackLabel" style="display: none;"><span class="error_formul"> <?= __("S'il vous plaît, entrez un Commentaire") ?></span></label>
            </div>
            <div class="col-md-12 block">
              <div class="checkbox">
                <label><input id="validationchecked" type="checkbox" value=""><?= __("Je certifie que cet avis est authentique et reflète ma propre expérience. Je ne suis pas liée personnellement ou professionnellement au propriétaire de cet hébergement, et n'ai reçu aucune compensation (financière ou autre). En contrepartie, je comprends que dans le cas contraire, mon avis pourra etre supprimé") ?>. </label>
              </div>
              <label id="validationcheckedLabel" style="display: none;"><span class="error_formul"> <?= __("Merci de cocher la case certifiant que votre avis est authentique.") ?></span></label>
            </div>
            <div class="row justify-content-end">
          <div class="col-auto">
            <button type="submit" class="btn btn-blue text-white rounded-0" value="Envoyer"><?= __("ENVOYER") ?></button>
          </div>
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        </div>
        </div>
        

        </form>
      </div>
    </div>
  </div>
  <!-- Modal Reponse Avis-->
  <div class="modal fade" id="repondreavis" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <span class="orange h1modal"><?= __("Répondre à cet Avis") ?></span>
        </div>
        <form method="post" accept-charset="utf-8" class="form-horizontal" onsubmit="return confirmresponseavis()" action="<?php echo $this->Url->build('/',true)?>annonces/responseavis">

        <div class="modal-body">
          <input type="hidden" name="annonce_id" value="<?php echo $annonce->id; ?>">
          <input type="hidden" name="utilisateur_id" value="<?php echo $this->Session->read('Auth.User.id')?>">
          <input type="hidden" id="feedbackid" name="feedback_id" value="">
            <div class="col-md-12 block">
              <label><strong><?= __("Votre Réponse") ?><sup class="orange">*</sup></strong></label>
              <textarea maxlength="360" id="reponsefeedback" name="reponse" class="form-control" rows="8" cols="80"></textarea>
              <label><span class="commentairecaractere"> *<?= __("Votre commentaire ne doit pas dépasser 360 caractères") ?></span></label>
              <label id="reponsefeedbackLabel" style="display: none;"><span class="error_formul"> <?= __("Merci de renseigner votre réponse.") ?></span></label>
            </div>
        </div>
        <div class="modal-footer">
          <div class="pull-right">
            <button type="submit" class="btn btn-success hvr-sweep-to-top " value="Envoyer"><?= __("ENVOYER") ?></button>
          </div>
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        </div>

        </form>
      </div>
    </div>
  </div>
  <!-- End Rating -->
          <!-- </div> -->
</div><!--/details_annonce-->
</div>
<!-- Modal -->
<div class="modal fade" id="ModalEdit2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">

  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel"><?= __("Détails période") ?></h4>
  </div>
  <div class="modal-body">
    <label class="col-sm-6 control-label"><?= __("Statut ") ?> : </label>
    <div class="col-sm-6">
      <p id="statut"></p>
    </div>
    <label class="col-sm-6 control-label"><?= __("Durée minimum de séjour") ?></label>
    <div class="col-sm-6">
      <p id="nbr_jour"></p>
    </div>
    <label class="col-sm-6 control-label"><?= __("Prix /nuitée") ?> </label>
    <div class="col-sm-6">
      <p id="prix_jour"></p>
    </div>
    <div id="divpromojour">
    <label class="col-sm-6 control-label"><?= __("Prix promotion /nuitée") ?> </label>
    <div class="col-sm-6">
      <p id="promo_jour"></p>
    </div>
    </div>
    <label class="col-sm-6 control-label"><?= __("Date de départ") ?></label>
    <div class="col-sm-6">
      <p id="date_depart"></p>
    </div>
    <label class="col-sm-6 control-label" id="labelprix"> </label>
    <div class="col-sm-6">
      <p id="prix_apartir"></p>
    </div>
  </div>
  <br><br>
  <div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Fermer") ?></button>
  </div>
</div>
</div>
</div>

<!-- popup connexion -->
<div class="modal fade" id="popup_connexion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <span class="orange h1modal text-center"><?= __("Connectez-vous pour continuer") ?></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body pt-3">
      
        <div class="alert alert-danger alert-connexion">          
        </div>
        <div class="alert alert-success">          
        </div>
        <div class="col-md-11 mx-auto">
          <form class="form-horizontal">
            <div class="form-group">
              <div class="col-12">
                <input type="email" class="form-control rounded-0" id="email" placeholder="<?= __('Entrer votre email') ?>">
              </div>
            </div>
            <div class="form-group">
              
              <div class="col-12">
                <input type="password" class="form-control rounded-0" id="pwd" placeholder="<?= __('Entrer votre mot de passe') ?>">
              </div>
            </div>
            <div class="form-row mx-3">
              <div class="col-md-6">
                <a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mdpPerdu'];?>" class="paword_link text-secondary"><u><?= __("Mot de passe oublié !") ?></u></a>
              </div>
              <div class="form-group col-md-6 text-md-right">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="souvenirmoi">
                  <!-- <label class="custom-control-label text-secondary" for="souvenirmoi">Se souvenir de moi</label> -->
                </div>
              </div>
            </div>            
            <div class="form-group">
              <div class="col-12">
                <button type="button" class="btn btn-blue text-white rounded-0 mt-3 w-100" value="connexion" id="submitconnexion"><?= __("Connexion") ?></button>
              </div>
            </div>
          </form>
          <div class="form-group">
            <div class="col-12">
              <p class="right">  
               <span><?= __("Vous n'avez pas de compte ?") ?></span> <a href="#" class="paword_link orange" id="clickinscription"><?= __("Inscription") ?></a>
              </p>
            </div>
          </div>
        </div>
        
      </div>
      
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Fin popup connexion -->

<!-- popup inscription -->
<div class="modal fade" id="popup_inscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <span class="orange h1modal font-weight-bold"><?= __("Inscrivez-vous") ?> </span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger alert-inscription">
          
        </div>
        <div class="col-md-12">
        <?php echo $this->Form->create($utilisateur,['id'=>'UtilisateurAddForm']);?>
            <?php echo $this->Form->hidden('id');?>
            <?php echo $this->Form->hidden('etat',['value'=>$etat]);?>
            <?php echo $this->Form->hidden('updated',['value'=>1]);?>
            <!-- <input type="hidden" id="telephone" name="telephone" /> -->
            <input type="hidden" id="portable" name="portable" />
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label><?= __("Vous êtes") ?> <sup class="orange">*</sup></label>
                  <?php echo $this->Form->input('nature',['type'=>'select','label'=>false,'class'=>'form-control','options'=>[''=>'Sélectionnez votre profil','CLT'=>'Locataire','ANNO'=>'Propriétaire']]);?>                           
                </div>
          </div>
            </div>
            <!-- /.row -->
            <div class="row">
            <div class="col-12"><label for="information"><?= __("Vos informations") ?></label></div>
            <div class="col-sm-6">
                    <div class="form-group">
                      <?php echo $this->Form->input('emailinscri',['type'=>'text','class'=>'form-control validate[required,custom[email]]','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45', 'placeholder'=>__('Votre adresse email').' *']);?>
                      <input type="hidden" name="ident" id="ident" value="">
                    </div>
                </div>
                <!-- /.col-sm-6 -->
                <div class="col-sm-6">
                    <div class="form-group">
                      <?php echo $this->Form->input('pays',['type'=>'select','class'=>'form-control','label'=>false,'options'=>$Pays,'default'=>'0']);?>
                    </div>
                </div>
                <!-- /.col-sm-6 -->
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo $this->Form->input('pwd2',['type'=>'password','class'=>'form-control validate[required,minSize[6]]','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Votre mot de passe').' *']);?>
                        <input type="hidden" name="pwd" id="pwd" value="">
                    </div>
                </div>
                <!-- /.col-sm-6 -->
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo $this->Form->input('pwd2_confirm',['type'=>'password','class'=>'form-control validate[required,equals[pwd2]]','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Confirmez votre mot de passe').' *']);?>
                    </div>
                </div>
                <!-- /.col-sm-6 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                      <?php echo $this->Form->input('nom_famille',['type'=>'text','class'=>'form-control validate[required]','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Votre nom').' *']);?>
                    </div>
                </div>
                <!-- /.col-sm-6 -->
                <div class="col-sm-6">
                    <div class="form-group">
                      <?php echo $this->Form->input('prenom',['type'=>'text','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Votre prénom').' *']);?>                    
                    </div>
                </div>
                <!-- /.col-sm-6 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-6">
                    <div id="date_naissance" class="input-group">
                        <?php echo $this->Form->input('naissance',['type'=>'text','readonly'=>'readonly','class'=>'form-control calendrier validate[required]','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Date de naissance').' *']);?>
                        <div class="input-group-append">
                          <div class="input-group-text"><label class="add-on mb-0" for="naissance"><i class="fa fa-calendar"></i></label></div>
                        </div>
                      </div>
                </div>
                <!-- /.col-sm-6 -->
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo $this->Form->input('portableNum',['type'=>'number','class'=>'form-control validate[required]','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45']);?>
                        <span id="error-msg2" class="hide"><?= __("Numéro invalide") ?></span>
                    </div>
                </div>
                <!-- /.col-sm-6 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-6">
                </div>
            </div>
            <div class="form-row">
          <div class="form-group col-md-7">
            <div class="custom-control custom-checkbox mt-4">
              <input type="checkbox" class="custom-control-input" id="conditiongen" name="conditiongen" required>
              <label class="custom-control-label text-secondary text-small" for="conditiongen"><?= __("J'accepte les") ?> <a class="text-secondary" href="<?php echo BLOG_ALPISSIME?>/conditions-generales-dutilisation-alpissime-com-2/" target="blanc"><u><?= __("Conditions Générales d'Utilisations") ?></u></a> * </label>
              <div class="invalid-feedback">
              <?= __("Vous devez accepter avant de valider.") ?>
              </div>
            </div>
          </div>
          <div class="form-group col-md-5">
				    <button type="submit" class="btn btn-blue text-white rounded-0 px-auto mt-3 w-100"><?= __("Inscription") ?></button>
          </div>
        </div>
           
          <?php echo $this->Form->end()?>
          
        </div>
      </div>
      <div class="modal-footer">
          <div class="pull-right">
          </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Fin popup inscription -->

<!-- popup redirectboutiquemodal -->
<div class="modal fade" id="redirectboutiquemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      
      <div class="modal-body pt-3 text-center">
        <input type="hidden" id="IDreserv" name="IDreserv" />
        <input type="hidden" id="redirectUrl" name="redirectUrl" />
        
        <img class="img-fluid" style="width:30%;" src="#" data-src="<?php echo $this->Url->build('/',true).'images/loading_tampon.gif'; ?>">

        <!-- One "tab" for each step in the form: -->
        <div class="tab mt-4">
          <p><?= __("Votre réservation est en cours. <br>Vous allez être redirigé(e) vers notre marketplace pour procéder au paiement.") ?></p>
        </div>

        <div class="tab">
          <p><?= __("Votre réservation vous attendra dans votre panier. <br>Vous pouvez également compléter votre séjour en y ajoutant des activités et des services (cours, matériel, forfaits de ski et bien plus encore).") ?></p>
        </div>

        <div class="tab">
          <p><?= __("Si {0} refuse votre demande de réservation, votre commande sera annulée et vous n’aurez rien à payer.", ucfirst($propannonce->prenom)) ?></p>
        </div>

        <div class="tab finaletape">
          <!-- <p>Les dates de réservation sélectionnées vous permettent de payer jusqu’à <span id="Xfois"></span> fois sans frais.</p> -->
          <p><?= __("Nous sommes en train de préparer votre commande") ?> ...</p>
        </div>

        <!-- Circles which indicates the steps of the form: -->
        <div style="text-align:center;">
          <span class="step"></span>
          <span class="step"></span>
          <span class="step"></span>
          <span class="step"></span>
        </div>

        <div style="overflow:auto;">
          <button type="button" class="btn btn-blue text-white rounded-1 mt-4 pr-5 pl-5 pt-1 pb-1 disabledcss" id="prevBtn" onclick="redirecttoboutique()"><?= __("Merci de patienter") ?>...</button>
          <button type="button" class="btn btn-blue text-white rounded-1 mt-4 pr-5 pl-5 pt-1 pb-1" id="nextBtn" onclick="nextPrev(1)"><?= __("Suivant") ?></button>
        </div>
        

      </div> 
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Fin popup redirectboutiquemodal -->

<!--popup reservation-->
<div class="modal fade" id="popup_contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>

function showMore(id){
    // document.getElementById(id+'Overflow').className='';
    document.getElementById(id+'MoreLink').className='hidden';
    $('.'+id+'MoreLink').each(function() {
      $(this).addClass("hidden");
    });
    $("#shrinkMe").html("<?php $annonce->description = str_ireplace(array('"'),'\'', $annonce->description); echo str_ireplace(array("\r\n",'\n'),'</br>', $annonce->description); ?>");
    // document.getElementById(id+'LessLink').className='';
}

// function showLess(id){
//     document.getElementById(id+'Overflow').className='hidden';
//     document.getElementById(id+'MoreLink').className='';
//     document.getElementById(id+'LessLink').className='hidden';
// }

var len = 250;
var shrinkables = document.getElementsByClassName('shrinkable');
if (shrinkables.length > 0) {
    for (var i = 0; i < shrinkables.length; i++){
        var fullText = shrinkables[i].innerHTML;
        if(fullText.length > len){
            var trunc = fullText.substring(0, len).replace(/\w+$/, '');
            var remainder = "";
            var id = shrinkables[i].id;
            remainder = fullText.substring(len, fullText.length);
            shrinkables[i].innerHTML = '<span>' + trunc + '</span><span class="' + id + 'MoreLink">... </span>&nbsp;<a id="' + id + 'MoreLink" href="#!" onclick="showMore(\''+ id + '\');"><u><?= __("Voir plus") ?></u></a>';
            // <a class="hidden" href="#!" id="' + id + 'LessLink" onclick="showLess(\''+ id + '\');">Less</a>
        }
    }
}

$(document).ready(function(){

  $("#loadMore").on("click", function(e){
    // console.log($("#loadMore").text());
    if ($("#loadMore").text() == 'Afficher plus d\'avis') {
      $('.contentimg:not(":visible"):lt(3)').show();
    } else {
      $('.contentimg:gt(2)').hide();
      $("#loadMore").text('Afficher plus d\'avis');
    }     
      
    var notVisible = $('.contentimg:not(":visible")').length;

    if (notVisible == 0) {
      $("#loadMore").text('Afficher moins d\'avis');
    }
  });


  var utilisateurconnecte = "<?php echo $this->Session->read('Auth.User.nature') ?>";
	var utilisateurvalid = "<?php echo $this->Session->read('Auth.User.valide_at') ?>";
	if(utilisateurconnecte != "" && utilisateurvalid == ""){
		$("#clickcontactprop").css("pointer-events", "none");
		$("#clickcontactprop").css("color", "rgba(33, 150, 243, 0.49)");		
	}

  $('#lightgallery').lightGallery({
    selector: '.item-light',
    share: false,
    actualSize: false,
    download: false
  });
  var listimg = [];
  $( ".item-light" ).each(function( index, element ) {
    // console.log($(element).attr('href'));
    // var srcimg = $(element).children("img").attr('src');
    listimg.push({"src":$(element).attr('href'),"thumb":$(element).attr('href')});
    
  });
  $( ".item-light" ).removeClass("disableno");
$("#voir-photo").on('click', function(e) {
  //console.log(listimg);
  $(this).lightGallery({
    dynamic: true,
    dynamicEl: listimg,
    share: false,
    actualSize: false,
    download: false
  });
});
$("#nbradulte").inputSpinner({
	id: "nbradulte"
});
$("#nbrenfant").inputSpinner({
	id: "nbrenfant"
});
});
<?php if($i){ ?>
var nbrTotal = <?php echo $i; ?>;
for(var i=1; i < nbrTotal; i++){
  $("#rate"+i).rating({
    displayOnly: true,
    step: 0.5,
    size: 'xm',
    theme: 'krajee-fa'
  });
  $("#emplacementrating"+i).rating({
    displayOnly: true,
    step: 0.5,
    size: 'xxs',
    theme: 'krajee-fa'
  });
  $("#confortrating"+i).rating({
    displayOnly: true,
    step: 0.5,
    size: 'xxs',
    theme: 'krajee-fa'
  });
  $("#qualiteprixrating"+i).rating({
    displayOnly: true,
    step: 0.5,
    size: 'xxs',
    theme: 'krajee-fa'
  });
}
<?php } ?>
  $(document).ready(function(){
      if (window.matchMedia("(max-width: 991px)").matches) {
        $("#accordion").unstick();
        $("#reserver-show").on("click", function(e){
          $(".overlay-rsv").show();
          $(".block-resv").slideDown("slow");
          $('body').css('overflow','hidden');
          $(".block-resv").addClass('shown');
          e.stopPropagation();
        });
        $(document).click(function(){
          $(".overlay-rsv").hide();  
          $(".block-resv").slideUp("slow")
          $(".block-resv").removeClass('shown');
          $('body').css('overflow','auto');
        });
        $(".block-resv").click(function(e) {
          e.stopPropagation();
        });
        $("#ui-datepicker-div").click(function(e) {
          e.stopPropagation();
        });
      } else {
        var heightmapsticky = $("#bottom").height() + $("#bottom-first").height() + 150;
        // console.log(heightmapsticky);
        //heightmapsticky = 2050;
        $("#accordion").sticky({topSpacing:0, bottomSpacing:heightmapsticky});
      }

      $( window ).on( "orientationchange", function( event ) {
        setTimeout(function(){
          if (window.matchMedia("(max-width: 991px)").matches) {
            $("#accordion").unstick();
            $("#reserver-show").on("click", function(e){
          $(".overlay-rsv").show();
          $(".block-resv").slideDown("slow");
          $('body').css('overflow','hidden');
          $(".block-resv").addClass('shown');
          e.stopPropagation();
        });
        $(document).click(function(){
          $(".overlay-rsv").hide();  
          $(".block-resv").slideUp("slow")
          $(".block-resv").removeClass('shown');
          $('body').css('overflow','auto');
        });
        $(".block-resv").click(function(e) {
          e.stopPropagation();
        });
        $("#ui-datepicker-div").click(function(e) {
          e.stopPropagation();
        });
          } else {
            var heightmapsticky = $("#bottom").height() + $("#bottom-first").height() + $("#annoncesimilaire").height() + $(".rowrating").height() + $(".rowrating2").height() + 350;
            //console.log(heightmapsticky);
            //heightmapsticky = 2050;
            $("#accordion").sticky({topSpacing:0, bottomSpacing:heightmapsticky});
          }
        }, 500);
      });


    if (window.matchMedia("(max-width: 1200px)").matches) {
      $( "span[id^='spanprix'] ul" ).addClass('list-unstyled');
      $( "span[id^='spanprix'] ul" ).removeClass('pl-4');
    }
    $( window ).on( "orientationchange", function( event ) {
      setTimeout(function(){
        if (window.matchMedia("(max-width: 767px)").matches) {
          $( "span[id^='spanprix'] ul" ).addClass('list-unstyled');
      $( "span[id^='spanprix'] ul" ).removeClass('pl-4');
        }
      }, 500);
    });

  /*if (window.matchMedia("(max-width: 767px)").matches) {
      $(".featured-product").height($(".featured-product").width()+150);
    }*/

    /*$( window ).on( "orientationchange", function( event ) {
      setTimeout(function(){
        if (window.matchMedia("(max-width: 767px)").matches) {
            $(".featured-product").height($(".featured-product").width()+150);
        }
      }, 500);
    });*/

    $("#generalrating").rating({
      displayOnly: true,
      step: 0.5,
      size: 'xs',
      theme: 'krajee-fa'
    });
    $("#emplacementrating").rating({
      displayOnly: true,
      step: 0.5,
      size: 'xxs',
      theme: 'krajee-fa'
    });
    $("#confortrating").rating({
      displayOnly: true,
      step: 0.5,
      size: 'xxs',
      theme: 'krajee-fa'
    });
    $("#qualiterating").rating({
      displayOnly: true,
      step: 0.5,
      size: 'xxs',
      theme: 'krajee-fa'
    });
    $("#emplacementratingadd").rating({
      step: 1,
      starCaptions: {1: 'Mauvais', 2: 'Moyen', 3: 'Bon', 4: 'Très Bon', 5: 'Excellent'},
      starCaptionClasses: {1: 'captionClass', 2: 'captionClass', 3: 'captionClass', 4: 'captionClass', 5: 'captionClass'},
      size: 'xxs',
      theme: 'krajee-fa',
      clearCaption: 'Médiocre',
      clearCaptionClass: 'captionClass'
    });
    $("#confortratingadd").rating({
      step: 1,
      starCaptions: {1: 'Mauvais', 2: 'Moyen', 3: 'Bon', 4: 'Très Bon', 5: 'Excellent'},
      starCaptionClasses: {1: 'captionClass', 2: 'captionClass', 3: 'captionClass', 4: 'captionClass', 5: 'captionClass'},
      size: 'xxs',
      theme: 'krajee-fa',
      clearCaption: 'Médiocre',
      clearCaptionClass: 'captionClass'
    });
    $("#qualiteratingadd").rating({
      step: 1,
      starCaptions: {1: 'Mauvais', 2: 'Moyen', 3: 'Bon', 4: 'Très Bon', 5: 'Excellent'},
      starCaptionClasses: {1: 'captionClass', 2: 'captionClass', 3: 'captionClass', 4: 'captionClass', 5: 'captionClass'},
      size: 'xxs',
      theme: 'krajee-fa',
      clearCaption: 'Médiocre',
      clearCaptionClass: 'captionClass'
    });
    $('#easyPaginate').easyPaginate({
      paginateElement: 'div.commentaire',
      elementsPerPage: 3,
      effect: 'climb'
    });

    document.getElementById("resultatdispo").style.display = 'none';
    
    var dbtrech = "<?php echo $debutrech ?>";
    var finrech = "<?php echo $finrech ?>";
    var nbradlt = "<?php echo $nbradlt ?>";
    var nbrenf = "<?php echo $nbrenf ?>";
    var animaux = "<?php echo $animaux ?>";
    if(dbtrech != "" && finrech != ""){
        $("#location_du").val(dbtrech);
        $("#location_au").val(finrech);
        if(nbradlt != "" && nbrenf != ""){
          $("div[data-id='nbradulte']").attr("data-defaultcount",nbradlt);
          $("div[data-id='nbrenfant']").attr("data-defaultcount",nbrenf);
          $("#nbradultehidden").val(nbradlt);
          $("#nbrenfanthidden").val(nbrenf);
        } 
        if(animaux == 1){
          $("#animaux").prop('checked', true);
          $('#apporteranimauxhidden').val(1);
        }       
        chercherdisponibilite();
        var passedArray = <?php echo json_encode($listeidannonceres); ?>;
        $.each(passedArray, function(index, value) {
          chercherdisponibiliteannoncesresidence(value, dbtrech, finrech);
          // calculertotalprixperioderes(value, $('#location_du').val()+"/"+$('#location_au').val());
        });
        
    }

 });

  function chercherdisponibiliteannoncesresidence(annonceID, debutDate, finDate){
    $.ajax({
      type: "POST",
      dataType : 'json',
      url: "<?php echo $this->Url->build('/',true)?>dispos/chercherdisponibiliteres/"+annonceID,
      data: {debut:debutDate, fin:finDate},
      success:function(xml){
         if(xml.nbrperiode == 1){
            var deb = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
            var debCal = moment($('#location_du').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
            var fn = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
            var fnCal = moment($('#location_au').val(),'DD-MM-YYYY').format('YYYY-MM-DD');

            var elim = '';
            var elimCon = '';
            var dureemin = [];
            $.each(xml.nbrDiff[1], function(index, value) {                
              if(value.toString().indexOf("_") != -1){
                  var tab = value.split("_");
                  var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var Diff = fnDiff.diff(dbtDiff, 'days');
                  var d = tab[0];
                  dureemin.push(parseInt(d));
                  // if(Diff < parseInt(d)){
                  //   if(dbtDiff.format('YYYY-MM-DD') == deb){
                  //     deb = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                  //   }else{
                  //     fn = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                  //   }
                  //   elim = d;
                  // }

                  // if(d == 7){
                  //   if(xml.details['condition'][1] == 1 && (moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi' || moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi')){
                  //       elimCon = "samedi";
                  //   }else if (xml.details['condition'][1] == 2 && (moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche' || moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche')){
                  //     elimCon = "dimanche";
                  //   }
                  // }

                  }else{
                    var dbtDiff = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                    var fnDiff = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                    var Diff = fnDiff.diff(dbtDiff, 'days');
                    var d = value;
                    dureemin.push(parseInt(d));
                    // if(Diff < parseInt(d)){
                    //   if(dbtDiff.format('YYYY-MM-DD') == deb){
                    //     deb = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                    //   }else{
                    //     fn = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                    //   }
                    //   elim = d;
                    // }

                    // if(d == 7){
                    //   if(xml.details['condition'][1] == 1 && (moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi' || moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi')){
                    //     elimCon = "samedi";
                    //   }else if (xml.details['condition'][1] == 2 && (moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche' || moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche')){
                    //     elimCon = "dimanche";
                    //   }
                    // }

                  }
              });

              
              var maxMinduree = Math.max(...dureemin);
              var debutdiffmin = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
              var findiffmin = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
              var DiffDateCal = findiffmin.diff(debutdiffmin, 'days');
              if(DiffDateCal < maxMinduree){
                if(debutdiffmin.format('YYYY-MM-DD') == deb){
                  deb = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                }else{
                  fn = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                }
                elim = maxMinduree;
              }  
              
              if( elimCon == ''){
                if((deb == debCal) && (fn == fnCal)){
                  if(deb > fn){
                    // $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE</span>");
                  }else{
                    $("#partoneprice_"+annonceID).html(xml.disponi[1]);
                    // $('#resultatdispo').html("<span style='color: #106710;font-size: 15px;font-weight: 600;'>PERIODE DISPONIBLE</span>");
                    if(xml.disponi[1] != ''){
                      // $('#periodedispo').html("<input type='hidden' name='sel' value='"+deb+"/"+fn+"' id='"+deb+"/"+fn+"'>");
                    }
                  }

                }else{
                   if(elim != ''){
                    $("#partoneprice_"+annonceID).html(xml.disponi[1]);
                    //  $('#resultatdispo').html("<span style='font-size: 13px;'><?= __('Le propriétaire a choisi de n\'accepter que les réservations de') ?>' "+elim + elimCon +" <?= __('nuitées minimum. Merci de modifier votre sélection.') ?></span><br>");
                   }else{
                    //  $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span><br>");
                   }
                }
              }else{
                if(elimCon == "samedi"){
                  $("#partoneprice_"+annonceID).html(xml.disponi[1]);
                    // $('#resultatdispo').html("<span style='font-size: 13px;'><?= __('Le propriétaire a choisi de n\'accepter que les réservations allant du samedi au samedi. Merci de modifier votre sélection.') ?></span>");
                }else if(elimCon == "dimanche"){
                  $("#partoneprice_"+annonceID).html(xml.disponi[1]);
                    // $('#resultatdispo').html("<span style='font-size: 13px;'><?= __('Le propriétaire a choisi de n\'accepter que les réservations allant du dimanche au dimanche. Merci de modifier votre sélection.') ?></span>");
                }else {
                    //$('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span>");
                }
              }
         }else{
            for (i = 1; i <= xml.nbrperiode; i++) {
              var elimCon = '';
              var deb = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
              var debCal = moment($('#location_du').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
              var fn = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
              var fnCal = moment($('#location_au').val(),'DD-MM-YYYY').format('YYYY-MM-DD');

              var elim = '';var elimCon = '';
              $.each(xml.nbrDiff[i], function(index, value) {
                if(value.toString().indexOf("_") != -1){
                  var tab = value.split("_");
                  var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var Diff = fnDiff.diff(dbtDiff, 'days');
                  var d = tab[0];
                  if(Diff < parseInt(d)){
                    if(dbtDiff.format('YYYY-MM-DD') == deb){
                      deb = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                    }else{
                      fn = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                    }
                    elim = "ui";
                  }
                  // if(elim == '' && d == 7){
                  //   if(xml.details['condition'][i] == 1 && (moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi' || moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi' )){
                  //       elimCon = "samedi";
                  //   }else if (xml.details['condition'][i] == 2 && (moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche' || moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche')){
                  //     elimCon = "dimanche";
                  //   }
                  // }
                }else{
                  var dbtDiff = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var fnDiff = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var Diff = fnDiff.diff(dbtDiff, 'days');
                  var d = value;
                  if(Diff < parseInt(d)){
                    if(dbtDiff.format('YYYY-MM-DD') == deb){
                      deb = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                    }else{
                      fn = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                    }
                    elim = "ui";
                  }
                  // if(elim == '' && d == 7){
                  //   if(xml.details['condition'][i] == 1 && (moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi' || moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi')){
                  //       elimCon = "samedi";
                  //   }else if (xml.details['condition'][i] == 2 && (moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche' || moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche')){
                  //     elimCon = "dimanche";
                  //   }
                  // }
                }
              });
            }

            if( elimCon == ''){
              //  $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span><br>");
            }else{
              if(elimCon == "samedi"){
                $("#partoneprice_"+annonceID).html(xml.disponi[1]);
                  // $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('Période doit être du Samedi au Samedi') ?> </span>");
              }else if(elimCon == "dimanche"){
                $("#partoneprice_"+annonceID).html(xml.disponi[1]);
                  // $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('Période doit être du Dimanche au Dimanche') ?> </span>");
              }else {
                  // $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span>");
              }
            }
         }
      }
    });
    
  }

  function calculertotalprixperioderes(idannonce, periode){
    $.ajax({
      type: "POST",
      dataType : 'json',
      url: "<?php echo $this->Url->build('/',true)?>dispos/calculertotalprixperiode",
      data: {annonce_id:idannonce, sel:periode, nbradulte:1, nbrenfant:0},
      success:function(xml){
        if (xml.resultatDetail['nbrperiode'] > 0) {
          var prixTotal = (xml.resultatDetail['total_price']).toFixed(2);

          if (xml.resultatDetail['totalSanspromo'] == 0) {
            $("#parttwoprice_"+idannonce).html("<span class='resright'>"+prixTotal+" €</span>");
          } else {
            var prixTotalSpromo = (xml.resultatDetail['totalSanspromo']).toFixed(2);
            $("#parttwoprice_"+idannonce).html("<span class='resright'><span class='totalSpromo mr-2'>"+prixTotalSpromo+" €</span><span class='totalWpromo'>"+prixTotal+" €</span></span>");
          }
        }
      }
    });
  }

    function calculertotalprixperiode(idannonce, periode, nbradulte, nbrenfant) {
        $.ajax({
            type: "POST",
            dataType : 'json',
            url: "<?php echo $this->Url->build('/',true)?>dispos/calculertotalprixperiode",
            data: {
                annonce_id: idannonce,
                sel:periode,
                nbradulte:nbradulte,
                nbrenfant:nbrenfant
            },
            success:function(xml) {
               $("#blockdetailprix").show();

                var prixTotal = (xml.resultatDetail['total_price']).toFixed(2);
                if (xml.resultatDetail['totalSanspromo'] == 0) {
                    $("#nombretotalnuitee").html("<span class='resleft'>" + xml.resultatDetail['nights'] + " <?= __('nuitées') ?> </span><span class='resright'>" + prixTotal + " €</span>");
                } else {
                    var prixTotalSpromo = (xml.resultatDetail['totalSanspromo']).toFixed(2);

                    $("#nombretotalnuitee").html("<span class='resleft'>" + xml.resultatDetail['nights'] + " <?= __('nuitées') ?> <span class='col-auto carreBleuRes mr-2 mb-2 px-2 py-0 rounded'> <?= __('Promo') ?></span></span><span class='resright'><span class='totalSpromo mr-2'>" + prixTotalSpromo + " €</span><span class='totalWpromo'>" + prixTotal + " €</span></span>");
                }

                var taxeDeSejour = (xml.resultatDetail['prixtaxeapayer']).toFixed(2);
                $("#taxesejourtotal").html("<span class='resleft'><?= __('Taxe de séjour') ?> </span><span class='resright'>"+taxeDeSejour+" €</span>");
                $("#prixtaxesejour").val(taxeDeSejour);

                var fraisdemenage = 0;
                $("#fraisdemenage").css("display", "none");
                if (parseFloat(xml.fraisdemenage) != 0) {
                    fraisdemenage = parseFloat(xml.fraisdemenage).toFixed(2);
                    $("#fraisdemenage").html("<span class='resleft'><?= __('Frais de ménage') ?> </span><span class='resright'>"+(parseFloat(xml.fraisdemenage).toFixed(2))+" €</span>").css("display", "block");
                }

                var fraisanimaux = 0;
                $("div[data-id='animaux']").addClass('iqdropdown-disabled');
                $("div[data-id='animaux'] .iqdropdown-description").html('<?= __("Le propriétaire a choisi de ne pas accepter les animaux de compagnie") ?>');
                $("#fraisanimaux").css("display", "none");
                if (xml.acceptanimal == 1) {
                    // $(".rowanimaux").css('display', 'block');
                    $("div[data-id='animaux']").removeClass('iqdropdown-disabled');
                    // if($('#animaux').is(":checked")){

                    if ($('#apporteranimauxhidden').val() > 0) {
                        // $('#apporteranimauxhidden').val(1);
                        if (xml.demandefraisanimal == 1) {
                            fraisanimaux = parseFloat(xml.fraisanimaux).toFixed(2);
                            $("#fraisanimaux").html("<span class='resleft'><?= __('Frais pour animaux') ?> </span><span class='resright'>"+(parseFloat(xml.fraisanimaux).toFixed(2))+" €</span>").css("display", "block");
                        }
                    }
                }

                $("#automaticPromo").hide();
                if (xml.resultatDetail.automaticPromo.percent > 0 && xml.resultatDetail.automaticPromo.value > 0) {
                    $("#automaticPromo").html("<span class='resleft'>" + xml.resultatDetail.automaticPromo.text + " </span><span class='resright'> - " + parseFloat(xml.resultatDetail.automaticPromo.value).toFixed(2) + " €</span>");
                    $("#automaticPromo").show();
                }

                var fraisAlpissime = xml.typefraiserviceprop == "fixe" ? xml.fraiserviceprop : ((xml.resultatDetail['total_price'] - xml.resultatDetail.automaticPromo.value)/100 * xml.fraiserviceprop);
                var fraisStripe = ((xml.resultatDetail['total_price'] - xml.resultatDetail.automaticPromo.value)/100 * 1.4);
                var fraisService = (fraisAlpissime + fraisStripe).toFixed(2);
                $("#fraisdeservice .resright").html(fraisService+" €");
                $("#prixfraiservice").val(fraisService);

                // Verifier le montant à mettre dans XML virement
                $("#prixreservation").val((parseFloat(prixTotal) - parseFloat(xml.resultatDetail.automaticPromo.value)).toFixed(2));
                var totalPrixPayer = (parseFloat(prixTotal) + parseFloat(taxeDeSejour) + parseFloat(fraisService) + parseFloat(fraisdemenage) + parseFloat(fraisanimaux) - parseFloat(xml.resultatDetail.automaticPromo.value)).toFixed(2);
                $("#totalpayer .resright").html(totalPrixPayer+" €");
                $("#totalapayer").val(totalPrixPayer);

                // $('#valider').css("display", "block");
                $('.text-annulation').css("display", "block");
                $('#validersearch').css("display", "none");
            }
        });
    }

   function chercherdisponibilite(){
      $.ajax({
       type: "POST",
       dataType : 'json',
       url: "<?php echo $this->Url->build('/',true)?>dispos/chercherdisponibilite/<?php echo $annonce->id?>",
       data: {debut:$('#location_du').val(), fin:$('#location_au').val()},
       success:function(xml){
         document.getElementById("resultatdispo").style.display = 'block';
         if(xml.nbrperiode == 1){
          //  console.log("nbr1");
           var deb = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
           var debCal = moment($('#location_du').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
           var fn = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
           var fnCal = moment($('#location_au').val(),'DD-MM-YYYY').format('YYYY-MM-DD');

            var elim = '';
            var elimCon = '';
            var dureemin = [];
              $.each(xml.nbrDiff[1], function(index, value) {                
                if(value.toString().indexOf("_") != -1){
                  var tab = value.split("_");
                  var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var Diff = fnDiff.diff(dbtDiff, 'days');
                  var d = tab[0];

                  dureemin.push(parseInt(d));
                  //console.log(Diff);
                    //console.log("----------");
                  // if(Diff < parseInt(d)){
                  //   if(dbtDiff.format('YYYY-MM-DD') == deb){
                  //     deb = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                  //   }else{
                  //     fn = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                  //   }
                  //   elim = d;
                  // }

                  // console.log("nbr d : "+d);

                  // if(d == 7){
                  //   if(xml.details['condition'][1] == 1 && (moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi' || moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi')){
                  //       elimCon = "samedi";
                  //   }else if (xml.details['condition'][1] == 2 && (moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche' || moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche')){
                  //     elimCon = "dimanche";
                  //   }
                  // }

                  }else{
                    var dbtDiff = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                    var fnDiff = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                    var Diff = fnDiff.diff(dbtDiff, 'days');
                    var d = value;

                    dureemin.push(parseInt(d));
                    //console.log(Diff);
                    //console.log("----------");
                    // if(Diff < parseInt(d)){
                    //   if(dbtDiff.format('YYYY-MM-DD') == deb){
                    //     deb = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                    //   }else{
                    //     fn = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                    //   }
                    //   elim = d;
                    // }

                    // console.log("nbr 2 d : "+d);
                    // console.log("nbr 2 elim : "+elim);

                    // if(d == 7){
                    //   if(xml.details['condition'][1] == 1 && (moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi' || moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi')){
                    //     elimCon = "samedi";
                    //   }else if (xml.details['condition'][1] == 2 && (moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche' || moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche')){
                    //     elimCon = "dimanche";
                    //   }
                    // }

                  }
              });

              // console.log(fnCal);
              var maxMinduree = Math.max(...dureemin);
              var debutdiffmin = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
              var findiffmin = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
              var DiffDateCal = findiffmin.diff(debutdiffmin, 'days');
              if(DiffDateCal < maxMinduree){
                if(debutdiffmin.format('YYYY-MM-DD') == deb){
                  deb = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                }else{
                  fn = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                }
                elim = maxMinduree;
              }             


              if(deb < fn){
                xml.disponi[1] = 'Période : du '+moment(deb,'YYYY-MM-DD').format('DD/MM/YYYY')+' au '+moment(fn,'YYYY-MM-DD').format('DD/MM/YYYY')+' <br>';
              }else{
                xml.disponi[1] = '';
              }
              //console.log(elimCon);
              //console.log("****");
              //console.log(elim);
              //console.log("____");

              if( elimCon == ''){
                if((deb == debCal) && (fn == fnCal)){

                  // document.getElementById("periodedispo").style.marginBottom = '0';

                  if(deb > fn){
                    document.getElementById("valider").style.display = 'none';
                    // $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE</span>");
                    $('#resultatdispo').css("display", "none");
                    // $('#periodedispo').html('');
                  }else{
                    document.getElementById("valider").style.display = 'block';
                    var utilisateurconnecte = "<?php echo $this->Session->read('Auth.User.nature') ?>";
                    var utilisateurvalid = "<?php echo $this->Session->read('Auth.User.valide_at') ?>";
                    if(utilisateurconnecte != "" && utilisateurvalid == ""){
                      $('#valider').prop('disabled', true);
                      $('#informationtext').html("<?= __('Vous devez activer votre adresse email pour réserver') ?>");
                    }else if(utilisateurconnecte != "" && utilisateurconnecte != "CLT"){
                      $('#valider').prop('disabled', true);
                      $('#informationtext').html("<?= __('Vous devez avoir un compte Locataire pour réserver') ?>");
                    }else{
                      $('#valider').prop('disabled', false);
                    }

                    // $('#resultatdispo').html("<span style='color: #106710;font-size: 15px;font-weight: 600;'>PERIODE DISPONIBLE</span>");
                    $('#resultatdispo').css("display", "none");
                    // $('#periodedispo').html('');
                    if(xml.disponi[1] != ''){
                      //$('#periodedispo').append("<div style='visibility: hidden;' class='form-group radios'><label class='radio-inline'><input type='radio' onclick='afficherbouton(this.id, \""+ deb +"\", \""+ fn +"\");' name='sel' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"' checked><span></span></label></div>");
                      $('#periodedispo').html("<input type='hidden' name='sel' value='"+deb+"/"+fn+"' id='"+deb+"/"+fn+"'>");
                    }
                  }

                 }else{
                   if(elim != ''){
                     document.getElementById("valider").style.display = 'none';
                     $('#resultatdispo').css("display", "block");
                     $('#resultatdispo').html("<span style='font-size: 13px;'><?= __('Le propriétaire a choisi de n\'accepter que les réservations de') ?>' "+elim + elimCon +" <?= __('nuitées minimum. Merci de modifier votre sélection.') ?></span><br>");
                    //  $('#periodedispo').html('');
                   }else{
                     document.getElementById("valider").style.display = 'none';
                    //  $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span><br>");
                    $('#resultatdispo').css("display", "none");
                    //  $('#periodedispo').html('');
                   }

                  $.each(xml.disponi, function(index, value) {
                    if(xml.disponi[index] != ''){
                      // $('#periodedispo').append("<div class='form-group radios'><label class='radio-inline'><input type='radio' onclick='afficherbouton(this.id, \""+ deb +"\", \""+ fn +"\");' name='sel' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"'><span> "+value+"</span></label></div>");
                      $('#periodedispo').html("<input type='hidden' name='sel' value='"+deb+"/"+fn+"' id='"+deb+"/"+fn+"'>");
                    }
                  });
                }
              }else{
                if(elimCon == "samedi"){
                    document.getElementById("valider").style.display = 'none';
                    $('#resultatdispo').css("display", "block");
                    $('#resultatdispo').html("<span style='font-size: 13px;'><?= __('Le propriétaire a choisi de n\'accepter que les réservations allant du samedi au samedi. Merci de modifier votre sélection.') ?></span>");
                    // $('#periodedispo').html('');
                }else if(elimCon == "dimanche"){
                    document.getElementById("valider").style.display = 'none';
                    $('#resultatdispo').css("display", "block");
                    $('#resultatdispo').html("<span style='font-size: 13px;'><?= __('Le propriétaire a choisi de n\'accepter que les réservations allant du dimanche au dimanche. Merci de modifier votre sélection.') ?></span>");
                    // $('#periodedispo').html('');
                }else {
                    document.getElementById("valider").style.display = 'none';
                    //$('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span>");
                    $('#resultatdispo').css("display", "none");
                    // $('#periodedispo').html('');
                }

              }

         }else{
           //var i = 1;
           for (i = 1; i <= xml.nbrperiode; i++) {
             var elimCon = '';
             //console.log(xml.nbrDiff[i]);
             //console.log("____");
               // $.each(xml.nbrDiff[i], function(index, value) {


                 var deb = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                 var debCal = moment($('#location_du').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
                 var fn = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                 var fnCal = moment($('#location_au').val(),'DD-MM-YYYY').format('YYYY-MM-DD');

                  var elim = '';var elimCon = '';
                    $.each(xml.nbrDiff[i], function(index, value) {
                      if(value.toString().indexOf("_") != -1){
                        var tab = value.split("_");
                        var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                        var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                        var Diff = fnDiff.diff(dbtDiff, 'days');
                        var d = tab[0];
                        if(Diff < parseInt(d)){
                          if(dbtDiff.format('YYYY-MM-DD') == deb){
                            deb = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                          }else{
                            fn = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                          }
                          elim = "ui";
                        }
                        // if(elim == '' && d == 7){
                        //   if(xml.details['condition'][i] == 1 && (moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi' || moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi' )){
                        //       elimCon = "samedi";
                        //   }else if (xml.details['condition'][i] == 2 && (moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche' || moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche')){
                        //     elimCon = "dimanche";
                        //   }
                        // }

                        }else{
                          var dbtDiff = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                          var fnDiff = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                          var Diff = fnDiff.diff(dbtDiff, 'days');
                          var d = value;
                          if(Diff < parseInt(d)){
                            if(dbtDiff.format('YYYY-MM-DD') == deb){
                              deb = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                            }else{
                              fn = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                            }
                            elim = "ui";
                          }
                          // if(elim == '' && d == 7){
                          //   if(xml.details['condition'][i] == 1 && (moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi' || moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi')){
                          //       elimCon = "samedi";
                          //   }else if (xml.details['condition'][i] == 2 && (moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche' || moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche')){
                          //     elimCon = "dimanche";
                          //   }
                          // }

                        }

                    });
                    if(deb < fn){
                      xml.disponi[i] = 'Période  : du '+moment(deb,'YYYY-MM-DD').format('DD/MM/YYYY')+' au '+moment(fn,'YYYY-MM-DD').format('DD/MM/YYYY')+' <br>';
                    }else{
                      xml.disponi[i] = '';
                    }

               // });

           }

           if( elimCon == ''){
             document.getElementById("valider").style.display = 'none';
            //  $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span><br>");
            $('#resultatdispo').css("display", "none");
            //  $('#periodedispo').html('');
             $.each(xml.disponi, function(index, value) {
               var deb = moment(xml.details['debut'][index], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
               var fn = moment(xml.details['fin'][index], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
               if(xml.disponi[index] != ''){
                //  $('#periodedispo').append("<div class='form-group radios'><label class='radio-inline'><input type='radio' onclick='afficherbouton(this.id, \""+ deb +"\", \""+ fn +"\");' name='sel' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"'><span> "+value+"</span></label></div>");
                 $('#periodedispo').html("<input type='hidden' name='sel' value='"+deb+"/"+fn+"' id='"+deb+"/"+fn+"'>");
               }
             });
           }else{
                if(elimCon == "samedi"){
                    document.getElementById("valider").style.display = 'none';
                    $('#resultatdispo').css("display", "block");
                    $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('Période doit être du Samedi au Samedi') ?> </span>");
                    // $('#periodedispo').html('');
                }else if(elimCon == "dimanche"){
                    document.getElementById("valider").style.display = 'none';
                    $('#resultatdispo').css("display", "block");
                    $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('Période doit être du Dimanche au Dimanche') ?> </span>");
                    // $('#periodedispo').html('');
                }else {
                    document.getElementById("valider").style.display = 'none';
                    // $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PERIODE NON DISPONIBLE </span>");
                    $('#resultatdispo').css("display", "none");
                    // $('#periodedispo').html('');
                }

           }
         }
        }
       });
       var now = new Date();
    if(moment($('#location_du').val(), ["DD-MM-YYYY"]).subtract(1, 'months') > moment(now)){
      $('.text-annulation').css("display", "block");
      $('.text-annulation').html('<svg aria-hidden="true" width="12" height="12" viewBox="0 0 12 12"><use xlink:href="<?php echo $this->Url->build('/')?>images/svg/annulation.svg#Calque_2"></use></svg>&nbsp;Annulation gratuite jusqu\'au '+moment($('#location_du').val(), ["DD-MM-YYYY"]).subtract(1, 'months').format('DD-MM-YYYY'));
    }else{
      $('.text-annulation').css("display", "none");
    }
     /** Calculer prix total période + taxe de séjour **/
     calculertotalprixperiode(<?php echo $annonce->id?>, $('#location_du').val()+"/"+$('#location_au').val(), $('#nbradultehidden').val(), $('#nbrenfanthidden').val());
    //  $('#nbradultehidden').val($('#nbradultehidden').val());
    //  $('#nbrenfanthidden').val($('#nbrenfanthidden').val());
   }

   function afficherbouton(id, dbt, fin)
   {
     if(document.getElementById(id).checked){
        $("#location_du").val(moment(dbt, ["YYYY-MM-DD", "DD/MM/YYYY"]).format('DD-MM-YYYY'));
        $("#location_au").val(moment(fin, ["YYYY-MM-DD", "DD/MM/YYYY"]).format('DD-MM-YYYY'));
        //document.getElementById("valider").style.display = 'block';
     }
     else document.getElementById("valider").style.display = 'none';
   }

  function confirmratingadd(){
    var msg="";
    if($('#confortratingadd').val() === ""){
      document.getElementById("confortratingaddLabel").style.display = 'block';
      msg+="confortratingadd";      
    }else{
      document.getElementById("confortratingaddLabel").style.display = 'none';
    }
    if($('#emplacementratingadd').val() === ""){
      document.getElementById("emplacementratingaddLabel").style.display = 'block';
      msg+="emplacementratingadd";      
    }else{
      document.getElementById("emplacementratingaddLabel").style.display = 'none';
    }
    if($('#qualiteratingadd').val() === ""){
      document.getElementById("qualiteratingaddLabel").style.display = 'block';
      msg+="qualiteratingadd";      
    }else{
      document.getElementById("qualiteratingaddLabel").style.display = 'none';
    }
    if($('#titrefeedback').val() === ""){
      document.getElementById("titrefeedbackLabel").style.display = 'block';
      msg+="titre";
     }else{
       document.getElementById("titrefeedbackLabel").style.display = 'none';
     }
   if($('#commentairefeedback').val() === ""){
     document.getElementById("commentairefeedbackLabel").style.display = 'block';
     msg+="commentaire";
    }else{
      document.getElementById("commentairefeedbackLabel").style.display = 'none';
    }
    if(!$('#validationchecked').is(":checked")){
      document.getElementById("validationcheckedLabel").style.display = 'block';
      msg+="notchecked";
    }else{
      document.getElementById("validationcheckedLabel").style.display = 'none';
    }
    if(msg==""){
      return true;
    }else{
      return false;
    }
  }

  function confirmresponseavis(){
    var msg="";
    if($('#reponsefeedback').val() === ""){
       document.getElementById("reponsefeedbackLabel").style.display = 'block';
       msg+="commentaire";
    }else{
      document.getElementById("reponsefeedbackLabel").style.display = 'none';
    }

    if(msg==""){
      return true;
    }else{
      return false;
    }
  }

  function openrepondreavis(id){
    document.getElementById("reponsefeedbackLabel").style.display = 'none';
    $('#reponsefeedback').val("");
    $('#feedbackid').val(id);
    $('#repondreavis').modal('show');
  }

  function afficherreponse(e, id){
    e.style.display = 'none';
    $("#"+id).delay(200).fadeIn();
  }

  function cacherreponse(id){
    $("#"+id).fadeOut();
    $("#link"+id).delay(200).fadeIn();
  }

  function validateForm(){

      var nameReg = /^[A-Za-z]+$/;
      var numberReg =  /^[0-9]+$/;
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var msg="";

    /*if($('#name').val() == ""){
      document.getElementById("nameLabel").style.display = 'block';
      msg+="nom";
     }else{
       document.getElementById("nameLabel").style.display = 'none';
     }
  if($('#prenom').val() == ""){
      document.getElementById("companyLabel").style.display = 'block';
      msg+="prenom";
     }else{
      document.getElementById("companyLabel").style.display = 'none';
     }
  if($('#tel').val() == ""){
      document.getElementById("telephoneLabel").style.display = 'block';
      msg+="tel";
     }else if(!(telInput.intlTelInput("isValidNumber"))){
       document.getElementById("telephoneLabel").style.display = 'none';
            document.getElementById("telephoneLabelerr").style.display = 'block';
        msg+="tel";
          }else{
        document.getElementById("telephoneLabel").style.display = 'none';
        document.getElementById("telephoneLabelerr").style.display = 'none';
      }
  if($('#email').val() == ""){
      document.getElementById("emailLabel").style.display = 'block';
      msg+="email";
     }else if(!emailReg.test($('#email').val())){
       document.getElementById("emailLabel").style.display = 'none';
      document.getElementById("emailLabelerr").style.display = 'block';
        msg+="mail";
          }else{
       document.getElementById("emailLabel").style.display = 'none';
       document.getElementById("emailLabelerr").style.display = 'none';
      }*/
  // if($('#demande').val() == 0){
  //     document.getElementById("demandeLabel").style.display = 'block';
  //     msg+="demande";
  //    }else{
  //     document.getElementById("demandeLabel").style.display = 'none';
  //    }
    // if($('#elmt').val() == ""){
    //   document.getElementById("messageLabel").style.display = 'block';
    //   msg+="message";
    //  }else{
    //   document.getElementById("messageLabel").style.display = 'none';
    //  }
    //  if($('#location_du_msg').val() == ""){
    //   document.getElementById("locduLabel").style.display = 'block';
    //   msg+="message";
    //  }else{
    //   document.getElementById("locduLabel").style.display = 'none';
    //  }



    if(msg==""){
        var str = $('#elmt').val();
        var messagesansmail = str.replace(/([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/, '');
        //messagesansmail = messagesansmail.replace(new RegExp(/([0-9]+[\- ]?[0-9]+)/, "g"), '');
        $('#messagehiddensans').val(messagesansmail);
        return true;
    }else{
        return false;
      }

  }

$('#animaux').change(function () {
  calculertotalprixperiode(<?php echo $annonce->id?>, $('#location_du').val()+"/"+$('#location_au').val(), $('#nbradultehidden').val(), $('#nbrenfanthidden').val());
});
  <?php $this->Html->scriptEnd(); ?>

  <?php echo $this->Flash->render() ?>
    <div class="modal-dialog modal-dialog-centered" style="width:650px; max-width:700px;">
        <div class="modal-content">
            <div class="modal-header">
            <h5><?= __("Vous avez un message pour") ?> <?php echo ucfirst($propannonce->prenom)." ".ucfirst($firstlettername)."."; ?> ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                 
            </div>
            <?php echo $this->Form->create(null,['url'=>['action'=>'prop'],'class'=>'form-horizontal propform','onsubmit'=>'return validateForm()','novalidate']); ?>
            <?php echo $this->Form->hidden('id', ['value' =>$annonce->id]); ?>

                <div class="modal-body">
                  <div class="alert alert-danger d-none" role="alert" id="msgerrorphone">
                    <?= __("Votre message ne peut pas être envoyé car il viole les conditions générales de Alpissime.com.<br> Il est interdit de communiquer une adresse email ou un numéro de téléphone par la messagerie.") ?>
                  </div>
                    <div class="col-md-12 block">
                        <div class="form-group row">
                            <label class="col-sm-4 font-weight-bold"><?= __("Nom et prénom") ?> :</label>

                            <div class="col-sm-6">
                              <?php echo $this->Session->read('Auth.User.nom_famille')." ".$this->Session->read('Auth.User.prenom') ?>
                              <?php echo $this->Form->hidden('idUser', ['value' =>$this->Session->read('Auth.User.id')]); ?>

                              <?php echo $this->Form->hidden('name', ['value' =>$this->Session->read('Auth.User.nom_famille')]); ?>
                              <?php echo $this->Form->hidden('prenom', ['value' =>$this->Session->read('Auth.User.prenom')]); ?>
                              <?php echo $this->Form->hidden('tel', ['value' =>$this->Session->read('Auth.User.portable')]); ?>
                              <?php echo $this->Form->hidden('email', ['value' =>$this->Session->read('Auth.User.email')]); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                             <label class="col-sm-4 font-weight-bold"><?= __("Dates") ?> :</label>
                            <div class="col-sm-8">
                              <div class="row">
                                <div class="col-md-6 col-sm-12 pr-md-0 location_du">
                                    <div class="input-group mb-2">
                                        <input id="location_du_msg" class="form-control" name="dbt_msg" placeholder="jj-mm-aaaa" required="required" readonly />
                                        <div class="invalid-feedback">
                                          <?= __("Champs obligatoires") ?>.
                                        </div>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><label class="add-on mb-0" for="location_du_msg"><i class="fa fa-calendar"></i></label></div>
                                        </div>                                        
                                    </div>                                    
                                </div>
                                  <div class="col-md-6 col-sm-12 pl-md-0 mt-3 mt-md-0 location_au">
                                      <div class="input-group mb-2">
                                          <input id="location_au_msg" class="form-control" name="fin_msg" placeholder="jj-mm-aaaa" required="required" readonly />
                                          <div class="invalid-feedback">
                                            <?= __("Champs obligatoires") ?>.
                                          </div>
                                          <div class="input-group-append">
                                              <div class="input-group-text"><label class="add-on mb-0" for="location_au_msg"><i class="fa fa-calendar"></i></label></div>
                                          </div>                                          
                                      </div>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="form-group row nbCouchage-group">
                            <label class="col-sm-4 font-weight-bold"><?= __("Voyageurs") ?> :</label>
                            <div class="col-sm-8">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 pr-md-0 nbCouchage_ad">
                                    <input id="nbCouchage_ad_msg" name="nbCouchage_ad_msg" data-prefix="<?= __('Adultes') ?>" value="1" min="1" step="1" type="number" required="required" />
                                    <div class="invalid-feedback">
                                      <?= __("Champs obligatoires") ?>.
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 pl-md-0 mt-3 mt-md-0 nbCouchage_enf">
                                    <input id="nbCouchage_enf_msg" name="nbCouchage_enf_msg" data-prefix="<?= __('Enfants') ?>" value="0" min="0" step="1" type="number" required="required" />
                                    <div class="invalid-feedback">
                                      <?= __("Champs obligatoires") ?>.
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-4 font-weight-bold"><?= __("Votre message") ?> :</label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->input('message', ['label'=>false,'templates' => ['inputContainer' => "{{content}}"], 'class' => 'form-control', 'rows' => 3,'id'=>'elmt', 'required']); ?>
                                <input type="hidden" id="messagehiddensans" name="messagehiddensans" />
                            </div>
                            <span class="text-danger interditext" style="display:none;"><?= __("Votre message ne peut pas être envoyé car il viole les conditions générales de Alpissime.com.<br> Il est interdit de communiquer une adresse email ou un numéro de téléphone par la messagerie.") ?></span>
                        </div>

                        <div class="form-group row justify-content-end">
                          <?php
                            // echo $this->InvisibleReCaptcha->render();
                          ?>
                          <?= $this->Recaptcha->display() ?>
                        <div class="col-sm-8"><button type="submit" class="interdibtn btn btn-pink left w-100 rounded-0 text-white" value="Envoyer"><?= __("Envoyer") ?></button></div>
                        </div>
                    </div>
                </div>
                
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<?php //$this->Html->script("/js/jquery.bxslider.js", array('block' => 'scriptBottom')); ?>
<?php //$this->Html->script("/js/jquery.nicescroll.plus.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/manager-arr/components/validationEngine/validationEngine.jquery.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/manager-arr/components/validationEngine/jquery.validationEngine.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/css/item-quantity-dropdown.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/item-quantity-dropdown.min.js", array('block' => 'scriptBottom')); ?>
<?php //$this->Html->script("/manager-arr/components/validationEngine/jquery.validationEngine-en.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-".$language_header_name.".min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
$('#elmt').on('keyup', function (event) {

  var VAL = $(this).val();
  var result = false; 

  var pattschaine = ["zéro", "zero", "z e r o", "zero.", "zéro.", "0six", "0sept", "z€ro", "z € r o", "pointcom", " om ", "il.c", "gma", "arobase", "(arobase)", "(at)", "(pointcom)", "(point)com", "yahoo", "gmail", "outlook", "hotmail", ". f r", ". b e", ". c h", "deux", "d e u x", "trois", "t r o i s", "quatre", "q u a t r e", "cinq", "c i n q", "six", "s i x", "sept", "s e p t", "huit", "h u i t", "neuf", "n e u f", "dix", "d i x", "vingt", "v i n g t", '@', ' tel', 'téléphone', 'telephone', 'portable', 'fixe', ' port.', 'adresse', '.com', '.fr', 'point com', 'point fr', '{at}', '{a}', 'mail', 'email', 'skype', '$kype', 'zero un', 'zero deux', 'zero trois', 'zero quatre', 'zero cinq', 'zero six', 'zero sept', 'zero huit', 'zero neuf', 'contacter au zero', 'contacter au 0', 'z e r o', 't e l', 'T-e-l', 'Z-e-ro', 'gmail', 'yahoo', 'hotmail', 'protonmail', 'outlook', 'orange', 'free', 'sfr', 'bouygues', 'icloud', 'gmx', 'caramail', 'tutanota', 'advalvas', 'aol', 'bluemail', 'bluewin', 'bbox', 'cyberposte', 'emailasso', 'fastmail', 'francite', 'hashmail', 'icqmail', 'iiiha', 'iname', 'juramail', 'katamail', 'laposte', 'libero', 'mailfence', 'mailplazza', 'mixmail', 'myway', 'No-log', 'openmailbox', 'peru', 'Safe-mail', 'tranquille.ch', 'vmail', 'vivalvi.net', 'webmail', 'webmails', 'yandex', 'zoho', '.com', '.fr', '.co.uk', '.ch', '.be', '.nl', '.at', '.es', '.cz', '.eu', '.de', '.gr', '.gal', '.it', '.li', '.lt', '.lu', '.pt', '.nl', '.se', '.eu', '.org', '.net', '.es', '.ee', '.fi', '(a)', '(at)', '[a]', '[at]', '+336', '+337', '06', '07', '+355', '+49', '+376', '+374', '+43', '+32', '+375', '+387', '+359', '+357', '+385', '+45', '+32', '+372', '+358', '+33', '+350', '+30', '+36', '+353', '+354', '+39', '+371', '+370', '+423', '+352', '+389', '+356', '+373', '+377', '+382', '+47', '+31', '+48', '+351', '+420', '+40', '+44', '+378', '+421', '+386', '+46', '+41', '+380', '+379']
  pattschaine.forEach(function(pattchaine, index){    
    if (VAL.indexOf(pattchaine) != -1) {
      result = true;
    }
  });
  
  if (result) {
    $(".interdibtn").attr("disabled","disabled");
    $(".interditext").css("display", "block");
  }else{
    $(".interdibtn").removeAttr("disabled");
    $(".interditext").css("display", "none");
  }
  
});
//<script>
// Since confModal is essentially a nested modal it's enforceFocus method
// must be no-op'd or the following error results 
// "Uncaught RangeError: Maximum call stack size exceeded"
// But then when the nested modal is hidden we reset modal.enforceFocus
var enforceModalFocusFn = $.fn.modal.Constructor.prototype._enforceFocus;
$.fn.modal.Constructor.prototype._enforceFocus = function() {};


var validNum = "non";
var validNum2 = "non";
$(".alert-connexion").css("display", "none");
$(".alert-inscription").css("display", "none");
$(".alert-success").css("display", "none");
/* Ajax submit inscription */
jQuery("#UtilisateurAddForm").validationEngine({
  prettySelect : true,
  useSuffix: "_chzn"
});
$('#UtilisateurAddForm').submit(function(event) {  
    var valreturn = '';
  if(validNum2 == "non")
  {
    valreturn="non";
  }
  // else if($("#num_tel").val()!='' && validNum == "non"){
  //   valreturn="non";
  //   console.log("2");
  // }else if($("#num_tel").val()=='' && validNum == "non"){
  //   $("#portable").val(validNum2);
  //   $("#telephone").val();
  //   $("#ident").val($("#email").val());
  //   $("#pwd").val($("#pwd2").val());

  //   valreturn="oui";
  // }
  else {
    $("#portable").val(validNum2);
    //$("#telephone").val(validNum);
    $("#ident").val($("#email").val());
    $("#pwd").val($("#pwd2").val());

    valreturn="oui";
  }
  //alert(valreturn);
  // get the form data
  // there are many ways to get this data using jQuery (you can use the class or id also)
  var formData = {
      'nature' : $('#nature').val(),
      'email' : $('#emailinscri').val(),
      'pwd2' : $('#pwd2').val(),
      'pays' : $('#pays').val(),
      //'civilite' : $('#civilite').val(),
      'nom_famille' : $('#nom-famille').val(),
      'prenom' : $('#prenom').val(),
      //'adresse' : $('#adresse').val(),
      //'code_postal' : $('#code-postal').val(),
      //'ville' : $('#ville').val(),
      //'telephone' : $('#telephone').val(),
      'naissance' : $('#naissance').val(),
      'portable' : $('#portable').val(),
      //'g-recaptcha-response' : grecaptcha.getResponse()
      //'g-recaptcha-response' : $('.recaptcha-css #g-recaptcha-response').val()      
  };
  //console.log(formData);
  if ($("#UtilisateurAddForm").validationEngine('validate') && valreturn == "oui"){
    $.ajax({
      type : 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url : '<?php echo $this->Url->build('/',true)?>utilisateurs/addajax', // the url where we want to POST
      data : formData, // our data object
      dataType : 'json', // what type of data do we expect back from the server
      encode : true
    })
      // using the done promise callback
    .done(function(data) {
      if(data.message == "mailairbnb"){
        $(".alert-inscription").css("display", "block");
        $(".alert-inscription").html("<?= __('Les emails Airbnb, Abritel et Booking ne sont pas acceptés.') ?>");
        $("#popup_inscription .modal-dialog .modal-content .modal-body").animate({
            scrollTop: 0
        }, 1000);
      }else if(data.message == "erreur"){
        $(".alert-inscription").css("display", "block");
        $(".alert-inscription").html("<?= __('Votre inscription n\'a pas pu être terminée.') ?>");
        $("#popup_inscription .modal-dialog .modal-content .modal-body").animate({
            scrollTop: 0
        }, 1000);
      }else if(data.message == "mailexiste"){
        $(".alert-inscription").css("display", "block");
        $(".alert-inscription").html("<?= __('Cette adresse email existe déjà.') ?>");
        $("#popup_inscription .modal-dialog .modal-content .modal-body").animate({
            scrollTop: 0
        }, 1000);
      }else if(data.message == "robot"){
        $(".alert-inscription").css("display", "block");
        $(".alert-inscription").html("<?= __('Veuillez prouver que vous n\'êtes pas un robot !') ?> ");
        $("#popup_inscription .modal-dialog .modal-content .modal-body").animate({
            scrollTop: 0
        }, 1000);
      }else{
        $.ajax({
          type: "POST",
          dataType : 'json',
          url: "<?php echo $this->Url->build('/',true)?>utilisateurs/ouvrircompteajax",
          data: {email: $('#emailinscri').val(), pwd: $('#pwd2').val()},
          success:function(xml){
            $(".alert-inscription").css("display", "none");
            $("#popup_inscription").modal('hide');
            $(".alert-connexion").css("display", "none");
          
            if($.cookie("modalshow") == 1){
              var pageURL = $(location).attr("href");
              pageURL = pageURL.replace("#", "");
              window.location.href = pageURL+'?modal='+$.cookie("modalshow");
            }
            if($.cookie("modalshow") == 2){
              // console.log(xml.retouruser.nature);
              // console.log(xml.retouruser.valide_at);
              var utilisateurconnecte = xml.retouruser.nature;
              var utilisateurvalid = xml.retouruser.valide_at;
              if(utilisateurconnecte != "" && utilisateurvalid == null){
                $("#popup_connexion").modal('hide');
                $('#valider').prop('disabled', true);
                $('#informationtext').html("<?= __('Vous devez activer votre adresse email pour réserver') ?>");
                // console.log("ddd");
                if(utilisateurconnecte == "CLT"){
                  $('#navbarSupportedContent .navbar-nav').html('<li class="nav-item"><a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a></li><li class="nav-item"><a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a></li><li class="nav-item"><a class="nav-link ml-lg-3 mr-lg-3" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><i class="fa fa-envelope-o"></i></a></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle nav-user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><img class="img-responsive" src="#" data-src="<?php echo $this->Url->build('/')?>images/user-icon.png" ></a><div class="dropdown-menu user-menu" aria-labelledby="navbarDropdown"><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index'];?>"><?= __("Profil") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a></div></li>');
                }else{
                  $('#navbarSupportedContent .navbar-nav').html('<li class="nav-item"><a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a></li><li class="nav-item"><a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a></li><li class="nav-item"><a class="nav-link ml-lg-3 mr-lg-3" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><i class="fa fa-envelope-o"></i></a></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle nav-user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><img class="img-responsive" src="#" data-src="<?php echo $this->Url->build('/')?>images/user-icon.png" ></a><div class="dropdown-menu user-menu" aria-labelledby="navbarDropdown"><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs'];?>"><?= __("Espace Propriétaire") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang;?>reservations/validation"><?= __("Réservations") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Mes annonces") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a></div></li><li><button class="btn btn-sm btn-primary btn-alpissime ml-3" type="button" onclick="location.href=\'<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['ouvrircompte'];?>\'"><?= __("Créer une annonce") ?></button></li>');
                } 
                $(".notvalidiv").css("display", "block");
              }else if(utilisateurconnecte != "" && utilisateurconnecte != "CLT"){
                $("#popup_connexion").modal('hide');
                $('#valider').prop('disabled', true);
                $('#informationtext').html("<?= __('Vous devez avoir un compte Locataire pour réserver') ?>");              
                $('#navbarSupportedContent .navbar-nav').html('<li class="nav-item"><a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a></li><li class="nav-item"><a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a></li><li class="nav-item"><a class="nav-link ml-lg-3 mr-lg-3" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><i class="fa fa-envelope-o"></i></a></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle nav-user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><img class="img-responsive" src="#" data-src="<?php echo $this->Url->build('/')?>images/user-icon.png" ></a><div class="dropdown-menu user-menu" aria-labelledby="navbarDropdown"><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs'];?>"><?= __("Espace Propriétaire") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang;?>reservations/validation"><?= __("Réservations") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Mes annonces") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a></div></li><li><button class="btn btn-sm btn-primary btn-alpissime ml-3" type="button" onclick="location.href=\'<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['ouvrircompte'];?>\'"><?= __("Créer une annonce") ?></button></li>');  
              }else{
                $('#valider').prop('disabled', false);
                // $('#reserverform').submit();

                var formData = {
                  'annonce_id' : $('#annonce-id').val(),
                  'totalapayer' : $('#totalapayer').val(),
                  'prixreservation' : $('#prixreservation').val(),
                  'prixtaxesejour' : $('#prixtaxesejour').val(),
                  'prixfraiservice' : $('#prixfraiservice').val(),
                  'nbradultehidden' : $('#nbradultehidden').val(),
                  'nbrenfanthidden' : $('#nbrenfanthidden').val(),
                  'apporteranimauxhidden' : $('#apporteranimauxhidden').val(),
                  'creationReservationLocpaiementdirectHidden' : $('#creationReservationLocpaiementdirectHidden').val(), 
                  'sel' : $('input[name="sel"]').val(),
                };              
                $.ajax({
                  type : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                  url : '<?php echo $this->Url->build('/',true)?>reservations/confirmreservations', // the url where we want to POST
                  data : formData, // our data object
                  dataType : 'json', // what type of data do we expect back from the server
                  encode : true,
                  beforeSend: function(){
                    $("#popup_connexion").modal('hide');
                    $("#redirectboutiquemodal").modal({
                          backdrop: 'static',
                          keyboard: true, 
                          show: true
                    });
                  },
                  success:function(xml){ 
                    $("#IDreserv").val(xml.IDreserv);                  
                    if(parseInt(xml.Xfois) > 1){
                      $(".finaletape").html("<p><?= __('Les dates de réservation sélectionnées vous permettent de payer jusqu’à <span id=\'Xfois\'></span> fois sans frais.') ?></p><p><?= __("Nous sommes en train de préparer votre commande") ?> ...</p>");
                    }else{
                      $(".finaletape").html("<p><?= __("Nous sommes en train de préparer votre commande") ?> ...</p>");
                    }
                    $("#Xfois").html(xml.Xfois);
                    // $("#redirectboutiquemodal").modal("show");
                    // $("#redirectboutiquemodal").modal({
                    //       backdrop: 'static',
                    //       keyboard: true, 
                    //       show: true
                    // });
                    $.ajax({
                      type: "POST",
                      dataType : 'json',
                      url: "<?php echo $this->Url->build('/',true)?>reservations/ajoutreservationpanier",
                      data: {IDreserv: $("#IDreserv").val()},
                      success:function(xml){ 
                        // console.log(xml.redirectUrl); 
                        $("#redirectUrl").val(xml.redirectUrl); 
                        $("#prevBtn").html("<?= __('Réserver') ?>");
                        $("#prevBtn").removeClass("disabledcss");                   
                        // document.getElementById("prevBtn").classList.remove("disabledcss");
                        // $("#redirectboutiquemodal").modal("hide"); 
                        // window.location.href = xml.redirectUrl;
                        // console.log(xml);
                      }
                    });
                  }
                });
                
                // $("#redirectboutiquemodal").modal("show");
                
                // console.log("555");
              }
              
            }
          }
        });
        // $(".alert-inscription").css("display", "none");
        // $("#popup_inscription").modal('hide');
        // $("#popup_connexion").modal('show');
        // $(".alert-success").css("display", "block");
        // $(".alert-success").html("<?= __('Votre inscription a été effectuée avec success.') ?>");
      }
        //mailairbnb
        //erreur
        //mailexiste
        //robot

        // log data to the console so we can see
        //console.log(data); 

        // here we will handle errors and validation messages
    });
  }


  // stop the form from submitting the normal way and refreshing the page
  event.preventDefault();
});
/* Ajax submit connexion function */
function ajaxsubmitconnexion(){
  $(".alert-success").css("display", "none");
  if($("#email").val() == ''){
    $(".alert-connexion").css("display", "block");
    $(".alert-connexion").html("<?= __('Le champ Email ne doit pas être vide !') ?>");
  }else if($("#pwd").val() == ''){
    $(".alert-connexion").css("display", "block");
    $(".alert-connexion").html("<?= __('Le champ Mot de passe ne doit pas être vide !') ?>");
  }else{
    $.ajax({
      type: "POST",
      dataType : 'json',
      url: "<?php echo $this->Url->build('/',true)?>utilisateurs/ouvrircompteajax",
      data: {email: $("#email").val(), pwd: $("#pwd").val()},
      success:function(xml){
        //console.log(xml.retourmessage);
        if(xml.retourmessage == "erreurconnexion"){
          $(".alert-connexion").css("display", "block");
          $(".alert-connexion").html("<?= __('Erreur au moment de la connexion ! Vérifier vos données') ?>");          
        }else if(xml.retourmessage == "confirmationcompte"){
          $(".alert-connexion").css("display", "block");
          $(".alert-connexion").html("<?= __('Un email de confirmation vous a été envoyé par Alpissime (administration@alpissime.com). Veuillez consulter votre boite mail pour activer votre compte.') ?>");
        }else{
          $(".alert-connexion").css("display", "none");
          
          if($.cookie("modalshow") == 1){
            var pageURL = $(location).attr("href");
            pageURL = pageURL.replace("#", "");
            window.location.href = pageURL+'?modal='+$.cookie("modalshow");
          }
          if($.cookie("modalshow") == 2){
            // console.log(xml.retouruser.nature);
            // console.log(xml.retouruser.valide_at);
            var utilisateurconnecte = xml.retouruser.nature;
            var utilisateurvalid = xml.retouruser.valide_at;
            if(utilisateurconnecte != "" && utilisateurvalid == null){
              $("#popup_connexion").modal('hide');
              $('#valider').prop('disabled', true);
              $('#informationtext').html("<?= __('Vous devez activer votre adresse email pour réserver') ?>");
              // console.log("ddd");
              if(utilisateurconnecte == "CLT"){
                $('#navbarSupportedContent .navbar-nav').html('<li class="nav-item"><a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a></li><li class="nav-item"><a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a></li><li class="nav-item"><a class="nav-link ml-lg-3 mr-lg-3" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><i class="fa fa-envelope-o"></i></a></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle nav-user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><img class="img-responsive" src="#" data-src="<?php echo $this->Url->build('/')?>images/user-icon.png" ></a><div class="dropdown-menu user-menu" aria-labelledby="navbarDropdown"><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index'];?>"><?= __("Profil") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a></div></li>');
              }else{
                $('#navbarSupportedContent .navbar-nav').html('<li class="nav-item"><a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a></li><li class="nav-item"><a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a></li><li class="nav-item"><a class="nav-link ml-lg-3 mr-lg-3" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><i class="fa fa-envelope-o"></i></a></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle nav-user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><img class="img-responsive" src="#" data-src="<?php echo $this->Url->build('/')?>images/user-icon.png" ></a><div class="dropdown-menu user-menu" aria-labelledby="navbarDropdown"><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs'];?>"><?= __("Espace Propriétaire") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang;?>reservations/validation"><?= __("Réservations") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Mes annonces") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a></div></li><li><button class="btn btn-sm btn-primary btn-alpissime ml-3" type="button" onclick="location.href=\'<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['ouvrircompte'];?>\'"><?= __("Créer une annonce") ?></button></li>');
              } 
              $(".notvalidiv").css("display", "block");
            }else if(utilisateurconnecte != "" && utilisateurconnecte != "CLT"){
              $("#popup_connexion").modal('hide');
              $('#valider').prop('disabled', true);
              $('#informationtext').html("<?= __('Vous devez avoir un compte Locataire pour réserver') ?>");              
              $('#navbarSupportedContent .navbar-nav').html('<li class="nav-item"><a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a></li><li class="nav-item"><a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a></li><li class="nav-item"><a class="nav-link ml-lg-3 mr-lg-3" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><i class="fa fa-envelope-o"></i></a></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle nav-user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><img class="img-responsive" src="#" data-src="<?php echo $this->Url->build('/')?>images/user-icon.png" ></a><div class="dropdown-menu user-menu" aria-labelledby="navbarDropdown"><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs'];?>"><?= __("Espace Propriétaire") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang;?>reservations/validation"><?= __("Réservations") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Mes annonces") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a></div></li><li><button class="btn btn-sm btn-primary btn-alpissime ml-3" type="button" onclick="location.href=\'<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['ouvrircompte'];?>\'"><?= __("Créer une annonce") ?></button></li>');  
            }else{
              $('#valider').prop('disabled', false);
              // $('#reserverform').submit();

              var formData = {
                'annonce_id' : $('#annonce-id').val(),
                'totalapayer' : $('#totalapayer').val(),
                'prixreservation' : $('#prixreservation').val(),
                'prixtaxesejour' : $('#prixtaxesejour').val(),
                'prixfraiservice' : $('#prixfraiservice').val(),
                'nbradultehidden' : $('#nbradultehidden').val(),
                'nbrenfanthidden' : $('#nbrenfanthidden').val(),
                'apporteranimauxhidden' : $('#apporteranimauxhidden').val(),
                'creationReservationLocpaiementdirectHidden' : $('#creationReservationLocpaiementdirectHidden').val(), 
                'sel' : $('input[name="sel"]').val(),
              };              
              $.ajax({
                type : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url : '<?php echo $this->Url->build('/',true)?>reservations/confirmreservations', // the url where we want to POST
                data : formData, // our data object
                dataType : 'json', // what type of data do we expect back from the server
                encode : true,
                beforeSend: function(){
                  $("#popup_connexion").modal('hide');
                  $("#redirectboutiquemodal").modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                  });
                },
                success:function(xml){ 
                  $("#IDreserv").val(xml.IDreserv);                  
                  if(parseInt(xml.Xfois) > 1){
                    $(".finaletape").html("<p><?= __('Les dates de réservation sélectionnées vous permettent de payer jusqu’à <span id=\'Xfois\'></span> fois sans frais.') ?></p><p><?= __("Nous sommes en train de préparer votre commande") ?> ...</p>");
                  }else{
                    $(".finaletape").html("<p><?= __("Nous sommes en train de préparer votre commande") ?> ...</p>");
                  }
                  $("#Xfois").html(xml.Xfois);
                  // $("#redirectboutiquemodal").modal("show");
                  // $("#redirectboutiquemodal").modal({
                  //       backdrop: 'static',
                  //       keyboard: true, 
                  //       show: true
                  // });
                  $.ajax({
                    type: "POST",
                    dataType : 'json',
                    url: "<?php echo $this->Url->build('/',true)?>reservations/ajoutreservationpanier",
                    data: {IDreserv: $("#IDreserv").val()},
                    success:function(xml){ 
                      // console.log(xml.redirectUrl); 
                      $("#redirectUrl").val(xml.redirectUrl); 
                      $("#prevBtn").html("<?= __('Réserver') ?>");
                      $("#prevBtn").removeClass("disabledcss");                   
                      // document.getElementById("prevBtn").classList.remove("disabledcss");
                      // $("#redirectboutiquemodal").modal("hide"); 
                      // window.location.href = xml.redirectUrl;
                      // console.log(xml);
                    }
                  });
                }
              });
              
              // $("#redirectboutiquemodal").modal("show");
              
              // console.log("555");
            }
            
          }
          
          //$("#popup_contact").modal('show');
          
        }
      }
    });
  } 
}
/* Fonction remplir champs inscription popup */
var monTableauJS;
function remplirchampsinscription(){
  $("#UtilisateurAddForm")[0].reset();
  /* remplir pays, ville, région */
  $.ajax({
    type: "POST",
    dataType : 'json',
    url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarraypays",
    data: {},
    success:function(xml){   
      $('#regiondiv').css('display','none');
      $("#ville").empty();
      data = xml.listepays;
      monTableauJS = xml.paysNum;      
      $('#pays').empty();
      $('#pays').append('<option value=0> Choisir votre pays </option>');
      for (var i = 0; i < data.length; i++) {
          $('#pays').append('<option value=' + data[i].id_pays + '>' + data[i].fr + '</option>');
      }
    }
  });

  /* remplir date naissance */
  $('#naissance').datepicker({
      language: 'fr-FR',
      changeMonth: true,
      changeYear: true,
      yearRange :"-100:+0",
      dateFormat: 'dd/mm/yy'
  });

  

  /* remplir portable */
  
  var telInputP = $("#portablenum"),
  errorMsg2 = $("#error-msg2");
  telInputP.intlTelInput({
    utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
    initialCountry: 'fr',
    autoPlaceholder: true
  });
  var reset = function() {
    telInputP.removeClass("errorNumberTel");
    errorMsg2.addClass("hide");
  };
  reset();
  // on blur: validate
  telInputP.blur(function() {
    reset();
    if ($.trim(telInputP.val())) {
      if (telInputP.intlTelInput("isValidNumber")) {
        validNum2 = telInputP.intlTelInput("getNumber");
      } else {
        validNum2 = "non";
        telInputP.addClass("errorNumberTel");
        errorMsg2.removeClass("hide");
        errorMsg2.addClass("errorNumberTel");
      }
    }
  });
}
$("#conditionannulation").click(function(){
  $("#conditionannulationmodal").modal('show');
});
/* Ouvrir popup connexion */
  $("#clickcontactprop").click(function(){
    var utilisateur = "<?php echo $this->Session->read('Auth.User.nature') ?>";
    if(utilisateur == ''){
      $(".alert-success").css("display", "none");
      $("#popup_connexion").modal('show');
      $.cookie("modalshow", 1);
    }else{
      $('#msgerrorphone').removeClass('d-none');
      $('#msgerrorphone').addClass('d-none');
      $("#popup_contact").modal('show');
      // Execute recaptcha
      // grecaptcha.execute();
    }
  });
/* Ouvrir connexion réservation */
  $("#valider").click(function(){
    var utilisateur = "<?php echo $this->Session->read('Auth.User.nature') ?>";
    if(utilisateur == ''){
      $(".alert-success").css("display", "none");
      $("#popup_connexion").modal('show');
      $.cookie("modalshow", 2);
      // return false;
    }else{
      var block;
      $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>reservations/blockreduction/",
        data: {debut:$("#location_du").val(), fin:$("#location_au").val(), ann_id: <?php echo $annonce->id ?>, modelemail: "creationReservationLocpaiementdirect"},
        success:function(xml){
          block = xml.blockdetail;
          $("#creationReservationLocpaiementdirectHidden").val(block);

          // $("#reserverform").submit();
          var formData = {
                'annonce_id' : $('#annonce-id').val(),
                'totalapayer' : $('#totalapayer').val(),
                'prixreservation' : $('#prixreservation').val(),
                'prixtaxesejour' : $('#prixtaxesejour').val(),
                'prixfraiservice' : $('#prixfraiservice').val(),
                'nbradultehidden' : $('#nbradultehidden').val(),
                'nbrenfanthidden' : $('#nbrenfanthidden').val(),
                'apporteranimauxhidden' : $('#apporteranimauxhidden').val(),
                'creationReservationLocpaiementdirectHidden' : $('#creationReservationLocpaiementdirectHidden').val(), 
                'sel' : $('input[name="sel"]').val(),
              };              
              $.ajax({
                type : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url : '<?php echo $this->Url->build('/',true)?>reservations/confirmreservations', // the url where we want to POST
                data : formData, // our data object
                dataType : 'json', // what type of data do we expect back from the server
                encode : true,
                beforeSend: function(){
                  $("#redirectboutiquemodal").modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                  });
                },
                success:function(xml){ 
                  $("#IDreserv").val(xml.IDreserv);
                  if(parseInt(xml.Xfois) > 1){
                    $(".finaletape").html("<p><?= __('Les dates de réservation sélectionnées vous permettent de payer jusqu’à <span id=\'Xfois\'></span> fois sans frais.') ?></p><p><?= __("Nous sommes en train de préparer votre commande") ?> ...</p>");
                  }else{
                    $(".finaletape").html("<p><?= __("Nous sommes en train de préparer votre commande") ?> ...</p>");
                  }
                  $("#Xfois").html(xml.Xfois);
                  // $("#redirectboutiquemodal").modal("show");
                  
                  $.ajax({
                    type: "POST",
                    dataType : 'json',
                    url: "<?php echo $this->Url->build('/',true)?>reservations/ajoutreservationpanier",
                    data: {IDreserv: $("#IDreserv").val()},
                    success:function(xml){ 
                      // console.log(xml.redirectUrl); 
                      $("#redirectUrl").val(xml.redirectUrl); 
                      $("#prevBtn").html("<?= __('Réserver') ?>");
                      $("#prevBtn").removeClass("disabledcss");                   
                      // document.getElementById("prevBtn").classList.remove("disabledcss");
                      // $("#redirectboutiquemodal").modal("hide"); 
                      // window.location.href = xml.redirectUrl;
                      // console.log(xml);
                    }
                  });
                }
              });
              
          // $("#redirectboutiquemodal").modal("show");
        }
      });      
      // return true;
    }    
  });
/* Ouvrir popup inscription  */
  $("#clickinscription").click(function(){    
      $("#popup_connexion").modal('hide');
      remplirchampsinscription();
      $("#popup_inscription").modal('show');
  });
/* Submit connexion */
  $("#submitconnexion").click(function(){    
      ajaxsubmitconnexion();
  });
/* Fermer connexion popup */
  $("#popup_connexion").on("hidden.bs.modal", function () {
    $(".alert-connexion").css("display", "none");
  });
/* Fermer connexion popup */
  $("#popup_inscription").on("hidden.bs.modal", function () {
    $(".alert-inscription").css("display", "none");
  });
/* Enter action for connexion popup */
  $('#pwd').keypress(function(e){
    if(e.keyCode == 13)
    {
      ajaxsubmitconnexion();
    }
  });
/* Changer pays */
$( "#pays" ).change(function() {    
  if($(this).val() == 67){
    $('#regiondiv').css('display','block');
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayregionfrance/",
        success:function(xml){
          data = xml.listefrregions;
          $('#region').empty();
          for (var i = 0; i < data.length; i++) {
              $('#region').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
        }
    });
    
   $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
        data: {departementid: 182},
        success:function(xml){
          data = xml.listepville;
          $('#ville').empty();
          for (var i = 0; i < data.length; i++) {
              $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
        }
    });
  }else{
    $('#regiondiv').css('display','none');
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarraypaysvilles/",
        data: {paysid: $(this).val()},
        success:function(xml){
          data = xml.listepville;
          $('#ville').empty();
          for (var i = 0; i < data.length; i++) {
              $('#ville').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
          }
        }
    });
  }
  //var monTableauJS = <?php //echo json_encode($paysNum) ?>;
  $("#num_tel").intlTelInput("setCountry", monTableauJS[$(this).val()]);
  $("#num_tel").val('');
  $("#portablenum").intlTelInput("setCountry", monTableauJS[$(this).val()]);
  $("#portablenum").val('');
});
/* Changer département */
$("#region").change(function() {  
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
        data: {departementid: $(this).val()},
        success:function(xml){
          data = xml.listepville;
          $('#ville').empty();
          for (var i = 0; i < data.length; i++) {
              $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
        }
    });
});
/* Saisi Code postal */
$("#code-postal").on('input',function(e){
    if($( "#pays" ).val() == 67 && ($( "#code-postal" ).val().length == 4 || $( "#code-postal" ).val().length == 5)){
        $.ajax({
            type: "POST",
            dataType : 'json',
            url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getdetailfrancecodepostal/",
            data: {code: $("#code-postal").val()},
            success:function(xml){                
                data = xml.listepville;
                if(data.length > 0){
                  $('#ville').empty();
                  for (var i = 0; i < data.length; i++) {
                      $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                      $('#region').val(data[i].departement_id);
                  }
                }
               
            }
        });
    }
    if($( "#pays" ).val() == 67 && $( "#code-postal" ).val().length > 5){
        $("#code-postal").val($("#code-postal").val().substr(0, 5));
    }
});

$('body').on('click',function(event){
  if(!$(event.target).is('.iqdropdown-selection') && !$(event.target).is('#animaux')){
    $(".iqdropdown").removeClass("menu-open")
  }
});

$('#animaux').change(function () {
    if($(this).is(':checked')){
      $('#apporteranimauxhidden').val(1);
      calculertotalprixperiode(<?php echo $annonce->id?>, $('#location_du').val()+"/"+$('#location_au').val(), $('#nbradultehidden').val(), $('#nbrenfanthidden').val());  
    }else{
      $('#apporteranimauxhidden').val(0);
      calculertotalprixperiode(<?php echo $annonce->id?>, $('#location_du').val()+"/"+$('#location_au').val(), $('#nbradultehidden').val(), $('#nbrenfanthidden').val());  
    }    
});

 $(document).ready(function () {

  $('.iqdropdown').iqDropdown({
    selectionText: '<?= __("Vacancier(s)"); ?>',
    textPlural: '<?= __("Vacancier(s)"); ?>',
    onChange: (id, count, totalItems) => {
      if(id == 'nbradulte'){
        $('#nbradultehidden').val(count);
        /** Calculer prix total période + taxe de séjour **/
        calculertotalprixperiode(<?php echo $annonce->id?>, $('#location_du').val()+"/"+$('#location_au').val(), $('#nbradultehidden').val(), $('#nbrenfanthidden').val());
        // $('#resultatdispo').html("");
        $('#resultatdispo').css("display", "none");
        $('#valider').css("display", "none");
        $('.text-annulation').css("display", "none");
        chercherdisponibilite();
      } 
      if(id == 'nbrenfant'){
        $('#nbrenfanthidden').val(count);
        /** Calculer prix total période + taxe de séjour **/
        calculertotalprixperiode(<?php echo $annonce->id?>, $('#location_du').val()+"/"+$('#location_au').val(), $('#nbradultehidden').val(), $('#nbrenfanthidden').val());
        // $('#resultatdispo').html("");
        $('#resultatdispo').css("display", "none");
        $('#valider').css("display", "none");
        $('.text-annulation').css("display", "none");
        chercherdisponibilite();
      }
      // if(id == 'animaux'){
      //   console.log("on est la");
      //   $('#apporteranimauxhidden').val(count);
      //   calculertotalprixperiode(<?php echo $annonce->id?>, $('#location_du').val()+"/"+$('#location_au').val(), $('#nbradultehidden').val(), $('#nbrenfanthidden').val());
      // } 
    },
  });

  $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);

var eventsadd = [];
var eventsaddpromo = [];
var eventsaddsamedi = [];
var eventsadddimanche = [];
// An array of dates
$.ajax({
  type: "POST",
  dataType : 'json',
  url: "<?php echo $this->Url->build('/',true)?>dispos/chercherdisponibilitedatepicker/<?php echo $annonce->id?>",
  data: {},
  success:function(xml){
    $.each(xml.dispo, function (index, value) {
      start = moment(value.dbt_at);
      end = moment(value.fin_at);
      end.add(1, 'd');
      while( start.format('YYYY-MM-DD') != end.format('YYYY-MM-DD') ){
        eventsadd.push(new Date(start.format('MM/DD/YYYY')));
        start.add(1, 'd');
      }
    });

    $.each(xml.dispoPromo, function (index, value) {
      start = moment(value.dbt_at);
      end = moment(value.fin_at);
      end.add(1, 'd');
      while( start.format('YYYY-MM-DD') != end.format('YYYY-MM-DD') ){
        eventsaddpromo.push(new Date(start.format('MM/DD/YYYY')));
        start.add(1, 'd');
      }
    });

    // $.each(xml.dispoSamedi, function (index, value) {
    //   start = moment(value.dbt_at);
    //   end = moment(value.fin_at);
    //   end.add(1, 'd');
    //   while( start.format('YYYY-MM-DD') != end.format('YYYY-MM-DD') ){
    //     eventsaddsamedi.push(new Date(start.format('MM/DD/YYYY')));
    //     start.add(1, 'd');
    //   }
    // });

    // $.each(xml.dispoDimanche, function (index, value) {
    //   start = moment(value.dbt_at);
    //   end = moment(value.fin_at);
    //   end.add(1, 'd');
    //   while( start.format('YYYY-MM-DD') != end.format('YYYY-MM-DD') ){
    //     eventsadddimanche.push(new Date(start.format('MM/DD/YYYY')));
    //     start.add(1, 'd');
    //   }
    // });
  }
});

$('#location_du').datepicker({
    language: 'fr-FR',
    minDate: 1,
    dateFormat: "dd-mm-yy",
    showOtherMonths: true,
    selectOtherMonths: true,
    beforeShowDay: function( date ) {
      var result = [false, '', null];
      var today = new Date();

      var matching = $.grep(eventsadd, function(event) {
          return event.valueOf() === date.valueOf();
      });
      if (matching.length) {
          result = [ true, 'greenday', 'Disponible !' ];
      }
      var matchingpromo = $.grep(eventsaddpromo, function(event) {
          return event.valueOf() === date.valueOf();
      });
      if (matchingpromo.length) {
          result = [ true, 'promoday', 'Disponible - En promotion' ];
      }
      // var matchingsamedi = $.grep(eventsaddsamedi, function(event) {
      //     return event.valueOf() === date.valueOf();
      // });
      // if (matchingsamedi.length) {
      //   if(date.getDay()==6) result = [ true, 'samediday', 'Disponible - Condition samedi/samedi' ];
      //   else if(date > today) result = [ false , 'samedidayfalse', 'Disponible - Condition samedi/samedi'];
      // }
      // var matchingdeimanche = $.grep(eventsadddimanche, function(event) {
      //     return event.valueOf() === date.valueOf();
      // });
      // if (matchingdeimanche.length) {
      //   if(date.getDay()==0) result = [ true, 'samediday', 'Disponible - Condition dimanche/dimanche' ];
      //   else if(date > today) result = [ false , 'samedidayfalse', 'Disponible - Condition dimanche/dimanche'];
      // }       
      return result;
    }
});
$('#location_du').on( "change", function() {
      //$('#location_du').datepicker( "option", "minDate", $.datepicker.parseDate( "dd-mm-yy", this.value ) );
      var d = moment(this.value,"DD-MM-YYYY").add(1, 'd');
      $('#location_au').datepicker( "option", "minDate", d.format('DD-MM-YYYY') );
      /** Calculer prix total période + taxe de séjour **/
      if($('#location_au').val() != ''){
        calculertotalprixperiode(<?php echo $annonce->id?>, $('#location_du').val()+"/"+$('#location_au').val(), $('#nbradultehidden').val(), $('#nbrenfanthidden').val());
        // $('#resultatdispo').html("");
        $('#resultatdispo').css("display", "none");
        $('#valider').css("display", "none");
        $('.text-annulation').css("display", "none");
        chercherdisponibilite();
      }
    });
$('#location_au').datepicker({
    language: 'fr-FR',
    minDate: 1,
    dateFormat: "dd-mm-yy",
    showOtherMonths: true,
    selectOtherMonths: true,
    beforeShowDay: function( date ) {
      var result = [false, '', null];
      var today = new Date();

       var matching = $.grep(eventsadd, function(event) {
           return event.valueOf() === date.valueOf();
       });
       if (matching.length) {
           result = [ true, 'greenday', 'Disponible !' ];
       }
       var matchingpromo = $.grep(eventsaddpromo, function(event) {
           return event.valueOf() === date.valueOf();
       });
       if (matchingpromo.length) {
           result = [ true, 'promoday', 'Disponible - En promotion' ];
       }
      //  var matchingsamedi = $.grep(eventsaddsamedi, function(event) {
      //      return event.valueOf() === date.valueOf();
      //  });
      //  if (matchingsamedi.length) {
      //     if(date.getDay()==6) result = [ true, 'samediday', 'Disponible - Condition samedi/samedi' ];
      //     else if(date > today) result = [ false , 'samedidayfalse', 'Disponible - Condition samedi/samedi'];
      //  }
      //  var matchingdeimanche = $.grep(eventsadddimanche, function(event) {
      //      return event.valueOf() === date.valueOf();
      //  });
      //  if (matchingdeimanche.length) {
      //     if(date.getDay()==0) result = [ true, 'samediday', 'Disponible - Condition dimanche/dimanche' ];
      //     else if(date > today) result = [ false , 'samedidayfalse', 'Disponible - Condition dimanche/dimanche'];
      //  }
       return result;
    }
});
  $('#location_au').on( "change", function() {
    /** Calculer prix total période + taxe de séjour **/
    calculertotalprixperiode(<?php echo $annonce->id?>, $('#location_du').val()+"/"+$('#location_au').val(), $('#nbradultehidden').val(), $('#nbrenfanthidden').val());
    // $('#resultatdispo').html("");
    $('#resultatdispo').css("display", "none");
    $('#valider').css("display", "none");
    $('.text-annulation').css("display", "none");
    chercherdisponibilite();
  });
  $("#nbradulte").on( "change", function() {
    /** Calculer prix total période + taxe de séjour **/
    calculertotalprixperiode(<?php echo $annonce->id?>, $('#location_du').val()+"/"+$('#location_au').val(), $('#nbradultehidden').val(), $('#nbrenfanthidden').val());
    // $('#resultatdispo').html("");
    $('#resultatdispo').css("display", "none");
    //$('#valider').css("display", "none");
    $('.text-annulation').css("display", "none");
    chercherdisponibilite();
  });
  $("#nbrenfant").on( "change", function() {
    /** Calculer prix total période + taxe de séjour **/
    calculertotalprixperiode(<?php echo $annonce->id?>, $('#location_du').val()+"/"+$('#location_au').val(), $('#nbradultehidden').val(), $('#nbrenfanthidden').val());
    // $('#resultatdispo').html("");
    $('#resultatdispo').css("display", "none");
    $('#valider').css("display", "none");
    $('.text-annulation').css("display", "none");
    chercherdisponibilite();
  });
});

$('#location_du_msg').datepicker({
    language: 'fr-FR',
    minDate: 1,
    dateFormat: "dd-mm-yy",
    showOtherMonths: true,
    selectOtherMonths: true
    /*beforeShowDay: function( date ) {
      var result = [false, '', null];
       var matching = $.grep(eventsadd, function(event) {
           return event.valueOf() === date.valueOf();
       });
       if (matching.length) {
           result = [ true, 'greenday', 'Disponible !' ];
       }
       return result;
    }*/
});
$('#location_du_msg').on( "change", function() {
    var d = moment(this.value,"DD-MM-YYYY").add(1, 'd');
    $('#location_au_msg').datepicker( "option", "minDate", d.format('DD-MM-YYYY') );
});
$('#location_au_msg').datepicker({
    language: 'fr-FR',
    minDate: 1,
    dateFormat: "dd-mm-yy",
    showOtherMonths: true,
    selectOtherMonths: true
    /*beforeShowDay: function( date ) {
      var result = [false, '', null];
       var matching = $.grep(eventsadd, function(event) {
           return event.valueOf() === date.valueOf();
       });
       if (matching.length) {
           result = [ true, 'greenday', 'Disponible !' ];
       }
       return result;
    }*/
});
$("#nbCouchage_ad_msg").inputSpinner({
	id: "nbradultemsg"
});
$("#nbCouchage_enf_msg").inputSpinner({
	id: "nbrenfantmsg"
});
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('propform');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }        
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

$(document).ready(function () {
  $(".tooltipsvc").tooltip({
    html: true
    });
  <?php if($_GET['token']){ ?>
    $("#noterutilid").val(<?php echo $_GET['token'];?>)
    $("#noterModal").modal('show');
  <?php } ?>

	$(".navbar-header").css("display","block");

    $.ajax({
      type: "POST",
      url: "<?php echo $this->Url->build('/',true)?>annonces/getimage/<?php echo $annonce->id?>",
      data: {id_a:1},
      success:function(xml){
        $('#image_grand').html(xml);
        }
  });


    $(".tdmiddle").click(function () {
        if ($(".detailliste2").css('display') == 'none') {
            $(this).html('<?= __("cacher") ?>');
            $(".tdmiddle").html('<button class="btn btn-blue text-white rounded-circle collapse-button-chevron p-0 line-height-0-5" type="button"><i class="fa fa-chevron-up font-size-small"></i></button>');
        } else {
            // $(this).html('voir plus');
            $(".tdmiddle").html('<button class="btn btn-blue text-white rounded-circle collapse-button-chevron p-0" type="button"><i class="fa fa-chevron-down font-size-small"></i></button>');
        }
        $(".detailliste2").toggle("slow");
    });

    function number_format (number, decimals, decPoint, thousandsSep) {
      number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
      var n = !isFinite(+number) ? 0 : +number
      var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
      var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
      var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
      var s = ''
      var toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec)
        return '' + (Math.round(n * k) / k)
          .toFixed(prec)
      }
      // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
      }
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || ''
        s[1] += new Array(prec - s[1].length + 1).join('0')
      }
      return s.join(dec)
    }
  //   var telInput = $("#tel");
  //   errorMsg = $("#telephoneLabelerr");
  //   telInput.intlTelInput({
  //                 utilsScript: '<?php //echo $this->Url->build('/',true) ?>js/utils.js',
  //                 initialCountry: 'fr',
  //                 autoPlaceholder: true
  //               });
  //               var reset = function() {
  //                 telInput.removeClass("errorNumberTel");
  //                 errorMsg.addClass("hide");
  //               };
  //               // on blur: validate
  // telInput.blur(function() {
  //   reset();
  //   if ($.trim(telInput.val())) {
  //     if (telInput.intlTelInput("isValidNumber")) {
  //       validNum = telInput.intlTelInput("getNumber");
  //       //alert(telInput.intlTelInput("getNumber"));
  //     } else {
  //       validNum = "non";
  //       telInput.addClass("errorNumberTel");
  //       errorMsg.removeClass("hide");
  //       errorMsg.addClass("errorNumberTel");
  //     }
  //   }
  // });

  // on keyup / change flag: reset
  // telInput.on("keyup change", reset);
  });
    // function clickroute(lati,long) {
    //       map.setZoom(20);
    //       var latLng = new google.maps.LatLng(lati, long); //Makes a latlng
    //       map.panTo(latLng); //Make map global
    //       var myDiv = document.getElementById('mapdiv');
    //       scrollTo(document.body, myDiv.offsetTop, 100);
    //   }
<?php $this->Html->scriptEnd(); ?>
