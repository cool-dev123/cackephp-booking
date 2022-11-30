<?php $this->append('cssTopBlock', '<style>
body {
    overflow: visible;
}

    .maprelative {
    /*height: 855px !important;*/
    /* margin-top: 12px !important; */
    overflow: hidden;
    z-index: 3;
    border-radius: 9px;
    padding-right: 0px;
    }

    div#map {
    z-index: 3;
    border-radius: 9px;
  }
    .title-product {
    background: #3caffb;
    text-transform: none;
    padding: 0px;
}
.description-product {
    background: white;
}
.featured-product {
    background: white;
}
.btnrecherchebande {
    margin-top: 15px;
    padding: 2px;
    width: 95%;
    bottom: 60px;
    margin-left: 7px;
}
.prixminbloc {
    color: #3caffb;
    margin-left: 5px;
    bottom: 10%;
    position: absolute;
    width: 92%;
}
.prixminbloc .stars {
  float: right;
}
.description-product .text a {
    font-size: 15px !important;
}
.description-product p {
    font-size: 12px;
}
/*.featured-product {
    height: 400px;
}*/
/* Images Annonces */

.glyphicon-chevron-right:before {
    content: "\e258";
}
.glyphicon-chevron-left:before {
    content: "\e257";
}
.optionsaffichage{
    display: flex;
    float: right;
}
.optionsaffichageleft{
    display: flex;
}
h1.gray_fonce.blue {
  margin-top: 0px;
}
.optionsaffichage .form-group {
    /*margin-right: 15px;*/
}
#slide {
    margin-bottom: 0px;
}
.rowaffichage{
    margin-bottom: 0 !important;
}
.mt-5 {
  margin-top: -8px !important; }

  /*#mes_annonces.mes_annonces .pagination .list-inline .last, #mes_annonces.mes_annonces .pagination .list-inline .first {
  background-color: #efefef;
  border: 1px solid #cccccc;
  box-shadow: 0px 3px 0px #cccccc;
  color: #333;
  cursor: pointer;
  display: inline-block;
  margin: -1px 3px 10px 0;
  outline: medium none;
  overflow: visible;
  padding: 6px 14px;
  position: relative;
  text-align: center;
  text-decoration: none;
  border-radius: 3px;
  text-transform: initial;
  transition: all 0.2s ease-out 0s;
  z-index: 0;
  font-size: 17px;
  font-weight: 300;
  margin-left: 10px;
  margin-right: 10px;
}*/
.zero_result {
  font-size: 20px;
  font-style: italic;
  color: #90949c;
}

img.img-rounded.img-responsive {
  width: 100%;
}
.datasrc{	
  height: 164px;
  object-fit: cover;
}
/*@media only screen and (max-width: 480px) {
  .datasrc {	
    height: 135px;
	  object-fit: cover;
  }
}*/

.pagination ul li.active {
  background: #0096FF;
  padding: 6px 15px !important;
  border-radius: 5px !important;
}
.pagination ul li, #mes_annonces.mes_annonces .pagination .list-inline .last, #mes_annonces.mes_annonces .pagination .list-inline .first {
  background: #eeeeee;
  padding: 6px 15px !important;
  border-radius: 5px !important;
  margin: 5px 2px;
}
.pagination ul li.active a {
  color: white;
  font-weight: bold;
}
.pagination ul li a {
  color: #464646;
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
.dropright:hover>.dropdown-menu{
  display: block;
}
.dropright {
  cursor: pointer;
}
</style>'); ?>
<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<?php if($language_header_name == "en"){
  $urlorig = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $urlorig = str_replace("/en/","/",$urlorig);
  $urlorig = str_replace("/listings","/annonces",$urlorig);
  $urlorig = str_replace("/search","/recherche",$urlorig);
  $urlorig = str_replace("geolocation=","lieugeo=",$urlorig);
  $urlorig = str_replace("start=","dbt=",$urlorig);
  $urlorig = str_replace("end=","fin=",$urlorig);
  $urlorig = str_replace("nbSleeping_ad=","nbCouchage_ad=",$urlorig);
  $urlorig = str_replace("nbSleeping_ch=","nbCouchage_enf=",$urlorig);
  $urlorig = str_replace("areaFrom=","surfaceDe=",$urlorig);
  $urlorig = str_replace("areaTo=","surfaceA=",$urlorig);
  $urlorig = str_replace("budgetFrom=","budgetDe=",$urlorig);
  $urlorig = str_replace("budgetTo=","budgetA=",$urlorig);
  $urlorig = str_replace("conditionWeek=","conditionSemaine=",$urlorig);
  $urlorig = str_replace("nb_stars=","nb_etoiles=",$urlorig);
  $urlorig = str_replace("nbRoom=","nbPiece=",$urlorig);
  $urlorig = str_replace("carpark=","parking=",$urlorig);
  $urlorig = str_replace("sheet=","drap=",$urlorig);
  $urlorig = str_replace("animals=","animaux=",$urlorig);
  $urlorig = str_replace("keyword=","motcle=",$urlorig);
  $urlorig = str_replace("disabled_person=","personne_reduite=",$urlorig);
  $this->assign('canonicalUrl', $urlorig);

  $this->assign('hreflang', $urlorig);
  $this->assign('hreflangen', "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}else{
  $urlorig = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $urlorig = str_replace($_SERVER['SERVER_NAME'],$_SERVER['SERVER_NAME']."/en",$urlorig);
  $urlorig = str_replace("/annonces","/listings",$urlorig);
  $urlorig = str_replace("/recherche","/search",$urlorig);
  $urlorig = str_replace("lieugeo=","geolocation=",$urlorig);
  $urlorig = str_replace("dbt=","start=",$urlorig);
  $urlorig = str_replace("fin=","end=",$urlorig);
  $urlorig = str_replace("nbCouchage_ad=","nbSleeping_ad=",$urlorig);
  $urlorig = str_replace("nbCouchage_enf=","nbSleeping_ch=",$urlorig);
  $urlorig = str_replace("surfaceDe=","areaFrom=",$urlorig);
  $urlorig = str_replace("surfaceA=","areaTo=",$urlorig);
  $urlorig = str_replace("budgetDe=","budgetFrom=",$urlorig);
  $urlorig = str_replace("budgetA=","budgetTo=",$urlorig);
  $urlorig = str_replace("conditionSemaine=","conditionWeek=",$urlorig);
  $urlorig = str_replace("nb_etoiles=","nb_stars=",$urlorig);
  $urlorig = str_replace("nbPiece=","nbRoom=",$urlorig);
  $urlorig = str_replace("parking=","carpark=",$urlorig);
  $urlorig = str_replace("drap=","sheet=",$urlorig);
  $urlorig = str_replace("animaux=","animals=",$urlorig);
  $urlorig = str_replace("motcle=","keyword=",$urlorig);
  $urlorig = str_replace("personne_reduite=","disabled_person=",$urlorig);
  $this->assign('hreflang', "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  $this->assign('hreflangen', $urlorig);
}  ?>


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
  //$str = str_replace(" ","-",$str);
  $str = str_replace("("," ",$str);
  $str = str_replace(")"," ",$str);
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
//print_r("<pre>");
//print_r($marqueurs);
//print_r("</pre>");
function convertForJson($titre)
{
  $str = str_replace("	  "," ",$titre);
  $str = str_replace("\""," ",$str);
  return $str;
}
$marqueurMaps = [];
if($avecdispoval != 'oui'){
  if(!empty($annTotal)){
    $annoncestotal = is_array($annTotal)?$annTotal:$annTotal->toArray(); //Liste des annonces de la recherche
//    print_r("<pre>");
//    print_r($annoncestotal);
//    print_r("</pre>");
    for($j=0;$j<=(count($annoncestotal) -1);$j++){
        $lannonce = trim(formatStr($annoncestotal[$j]->titre));

        $natureAnnURL = array("STD"=>__("studio"),"APP"=>__("appartement"),"CHA"=>__("chalet"),"DIV"=>__("location"),"VIL"=>__("villa"),"GIT"=>__("gite"));
        $url = $this->Url->build('/', true).$urlLang;
        $hrefDetailAnn = $url.$urlvaluemulti['station'].'/'.$annoncestotal[$j]['lieugeo']['nom_url'].'/'.$natureAnnURL[$annoncestotal[$j]['nature']].'/'.$annoncestotal[$j]['id']."_".$lannonce;

        $marqueurMaps[$annoncestotal[$j]->batiment]['lat'] = $residenceAnnonce[$annoncestotal[$j]->batiment]['lat'];
        $marqueurMaps[$annoncestotal[$j]->batiment]['lon'] = $residenceAnnonce[$annoncestotal[$j]->batiment]['lon'];
        $marqueurMaps[$annoncestotal[$j]->batiment]['title'] = convertForJson(convertstr( $residenceAnnonce[$annoncestotal[$j]->batiment]['title'] ));
        $marqueurMaps[$annoncestotal[$j]->batiment]['contenu'][] = convertForJson(convertstr( $annoncestotal[$j]->titre ));
        $marqueurMaps[$annoncestotal[$j]->batiment]['url'][] = $hrefDetailAnn;
        $marqueurMaps[$annoncestotal[$j]->batiment]['prix'][] = $minprixannonce[$annoncestotal[$j]->id]['prixmin'];
        $marqueurMaps[$annoncestotal[$j]->batiment]['image'][] = $this->Url->build("/")."images_ann/".$annoncestotal[$j]->id."/vignette-".$annoncestotal[$j]->id."-".$photos[$annoncestotal[$j]->id][0].".P.jpg";

    }

  }

}else{
    if(!empty($annTotal)){
      $annoncestotal = is_array($annTotal)?$annTotal:$annTotal->toArray(); //Liste des annonces de la recherche

      for($j=0;$j<=(count($annoncestotal) -1);$j++){
        $lannonce = trim(formatStr($annoncestotal[$j]['Annonces']['titre']));

        $natureAnnURL = array("STD"=>__("studio"),"APP"=>__("appartement"),"CHA"=>__("chalet"),"DIV"=>__("location"),"VIL"=>__("villa"),"GIT"=>__("gite"));
        $url = $this->Url->build('/', true).$urlLang;
        $hrefDetailAnn = $url.$urlvaluemulti['station'].'/'.$annoncestotal[$j]['Annonces']['lieugeo']['nom_url'].'/'.$natureAnnURL[$annoncestotal[$j]['Annonces']['nature']].'/'.$annoncestotal[$j]['Annonces']['id']."_".$lannonce;

        $marqueurMaps[$annoncestotal[$j]['Annonces']['batiment']]['lat'] = $residenceAnnonce[$annoncestotal[$j]['Annonces']['batiment']]['lat'];
        $marqueurMaps[$annoncestotal[$j]['Annonces']['batiment']]['lon'] = $residenceAnnonce[$annoncestotal[$j]['Annonces']['batiment']]['lon'];
        $marqueurMaps[$annoncestotal[$j]['Annonces']['batiment']]['title'] = convertForJson(convertstr( $residenceAnnonce[$annoncestotal[$j]['Annonces']['batiment']]['title'] ));
        $marqueurMaps[$annoncestotal[$j]['Annonces']['batiment']]['contenu'][] = convertForJson(convertstr( $annoncestotal[$j]['Annonces']['titre'] ));
        $marqueurMaps[$annoncestotal[$j]['Annonces']['batiment']]['url'][] = $hrefDetailAnn;
        $marqueurMaps[$annoncestotal[$j]['Annonces']['batiment']]['prix'][] = $minprixannonce[$annoncestotal[$j]['Annonces']['id']]['prixmin'];
        $marqueurMaps[$annoncestotal[$j]['Annonces']['batiment']]['image'][] = $this->Url->build("/")."images_ann/".$annoncestotal[$j]['Annonces']['id']."/vignette-".$annoncestotal[$j]['Annonces']['id']."-".$photos[$annoncestotal[$j]['Annonces']['id']][0].".P.jpg";;

      }
    }
}

 ?>
 
 <?php $this->Html->script("jquery.sticky.js", array('block' => 'scriptBottom')); ?>
 <?php $this->Html->script("new/bootstrap-input-spinner.js", array('block' => 'scriptBottom')); ?>
 

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
      center: {lat: 46.5782742, lng: 4.8072428},
      zoom: 6.5,
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


    var jsontab = JSON.parse('<?php echo JSON_encode($marqueurMaps, JSON_UNESCAPED_UNICODE);?>');
    $.each(jsontab, function(index, data) {
       //console.log(data);
      var contenue = '<strong style="font-weight: bold;font-size: 15px;padding-bottom:.5em;border-bottom:1px solid grey;display:block;margin-bottom:1em;">'+ data.title +'</strong>';
      $.each(data.contenu, function(index, datat) {
        //console.log(datat);
        if(data.prix[index]) contenue = contenue +" <div style='display: inline-block;margin-bottom: 1em;'><img style='float:left;margin-right: 10px;border-radius: 5px;' width='80' src='"+data.image[index]+"'> <a style='color:black;'  href='"+data.url[index]+"' target='_blanck'>"+datat+ "</a> <br><span style='color:#3caffb'> à partir de "+data.prix[index]+" / nuitée </span></div>";
        else contenue = contenue +" <div style='display: inline-block;margin-bottom: 1em;'><img style='float:left;margin-right: 10px;border-radius: 5px;' width='80' src='"+data.image[index]+"'> <a style='color:black;'  href='"+data.url[index]+"' target='_blanck'>"+datat+ "</a> </div>";
      })

      latLng = new google.maps.LatLng(data.lat, data.lon);

      var infowindow = new google.maps.InfoWindow({
         content: contenue,
         maxWidth: 300
       });
      // Creating a marker and putting it on the map
      var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        title: data.title,
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


    var tabzoomstation = JSON.parse('<?php echo JSON_encode($tabzoomstation);?>');
    $.each(tabzoomstation, function(index, data) {
        if(data.titre != "Arcs 1800"){
           map.setCenter({
                  lat : Number(data.lat),
                  lng : Number(data.lon)
          });
          map.setZoom(15);
        }else{
          map.setCenter({
                  lat : 45.5749229,
                  lng : 6.779972
          });
          map.setZoom(15);
        }

    });

  }

  $(document).ready(function(){
      $(".maprelative").css('height', $(window).height()-30);
      if (window.matchMedia("(max-width: 767px)").matches) {
        $("#mapdiv").unstick();
        //$(".featured-product").height($(".featured-product").width()+150);
      } else {
        var heightmapsticky = $("#bottom").outerHeight() + $("#bottom-first").outerHeight() + 140;
        $("#mapdiv").sticky({topSpacing:0, bottomSpacing:heightmapsticky});
      }
      if (window.matchMedia("(max-width: 1200px)").matches) {
        $( "span[id^='spanprix'] ul" ).addClass('list-unstyled');
        $( "span[id^='spanprix'] ul" ).removeClass('pl-4');
      }

      $( window ).on( "orientationchange", function( event ) {
        setTimeout(function(){
          if (window.matchMedia("(max-width: 767px)").matches) {
              $("#mapdiv").unstick();
              //$(".featured-product").height($(".featured-product").width()+150);
          } else {
              var heightmapsticky = $("#bottom").outerHeight() + $("#bottom-first").outerHeight() + 140;
              $("#mapdiv").sticky({topSpacing:0, bottomSpacing:heightmapsticky});
          }
          if (window.matchMedia("(max-width: 1200px)").matches) {
            $( "span[id^='spanprix'] ul" ).addClass('list-unstyled');
            $( "span[id^='spanprix'] ul" ).removeClass('pl-4');
          }
        }, 500);

      });
  
    var markerservices = [];
    /** Ajout immeubles et services **/
    $('#affichageservicesimmeubles').on('click',function () {
        if ($('#affichageservicesimmeubles').is(':checked')) {
            if(markers.length == 0){
                var jsontab = JSON.parse('<?php echo JSON_encode($marqueurMaps);?>');
                // IMAGE ICON
                var imageMarqueur = {
                    url: "<?php echo $this->Url->build('/',true)?>images/iconegooglemap.png",
                };
                $.each(jsontab, function(index, data) {
                  var contenue = '<strong style="font-weight: bold;font-size: 15px;padding-bottom:.5em;border-bottom:1px solid grey;display:block;margin-bottom:1em;">'+ data.title +'</strong>';
                  $.each(data.contenu, function(index, datat) {
                    if(data.prix[index]) contenue = contenue +" <div style='display: inline-block;margin-bottom: 1em;'><img style='float:left;margin-right: 10px;border-radius: 5px;' width='80' src='"+data.image[index]+"'> <a style='color:black;'  href='"+data.url[index]+"' target='_blanck'>"+datat+ "</a> <br><span style='color:#3caffb'> à partir de "+data.prix[index]+" / nuitée </span></div>";
                    else contenue = contenue +" <div style='display: inline-block;margin-bottom: 1em;'><img style='float:left;margin-right: 10px;border-radius: 5px;' width='80' src='"+data.image[index]+"'> <a style='color:black;'  href='"+data.url[index]+"' target='_blanck'>"+datat+ "</a> </div>";
                  })

                  latLng = new google.maps.LatLng(data.lat, data.lon);

                  var infowindow = new google.maps.InfoWindow({
                     content: contenue,
                     maxWidth: 300
                   });
                  // Creating a marker and putting it on the map
                  var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: data.title,
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
            if(markerservices.length == 0){
                $.ajax({
                    type: "POST",
                    dataType : 'json',
                    url: "<?php echo $this->Url->build('/',true)?>annonces/getservicesmap",
                    success:function(xml){
                        var jsontab = xml.residencesmap;
                        //console.log(jsontab);
                        markerservices = [];
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

                        var infowindowservice = new google.maps.InfoWindow({
                            content: "<strong>"+convertcaracterjson(data.title)+"</strong>",
                            maxWidth: 300
                        });
                        // Creating a marker and putting it on the map
                        var marker = new google.maps.Marker({
                          position: latLng,
                          map: map,
                          title: convertcaracterjson(data.title),
                          icon: imageMarqueur,
                          //infowindow: infowindowservice
                        });
                        marker.addListener('click', function() {
                            infowindowservice.open(map, marker);
                        });

                        //markers.push(marker);
                        marker.setMap(map);
                        markerservices.push(marker);

                      });
                    }
                });
            }
        }
    });
    /** Ajouter immeubles **/
    $('#affichageimmeubles').on('click',function () {
        if ($('#affichageimmeubles').is(':checked')) {
            for(i=0; i < markerservices.length; i++){
                markerservices[i].setMap(null);
            }
            markerservices = [];
            for(i=0; i < markers.length; i++){
                markers[i].setMap(null);
            }
            markers = [];
            var jsontab = JSON.parse('<?php echo JSON_encode($marqueurMaps);?>');
            // IMAGE ICON
            var imageMarqueur = {
                url: "<?php echo $this->Url->build('/',true)?>images/iconegooglemap.png",
            };
            $.each(jsontab, function(index, data) {
              var contenue = '<strong style="font-weight: bold;font-size: 15px;padding-bottom:.5em;border-bottom:1px solid grey;display:block;margin-bottom:1em;">'+ data.title +'</strong>';
              $.each(data.contenu, function(index, datat) {
                if(data.prix[index]) contenue = contenue +" <div style='display: inline-block;margin-bottom: 1em;'><img style='float:left;margin-right: 10px;border-radius: 5px;' width='80' src='"+data.image[index]+"'> <a style='color:black;'  href='"+data.url[index]+"' target='_blanck'>"+datat+ "</a> <br><span style='color:#3caffb'> à partir de "+data.prix[index]+" / nuitée </span></div>";
                else contenue = contenue +" <div style='display: inline-block;margin-bottom: 1em;'><img style='float:left;margin-right: 10px;border-radius: 5px;' width='80' src='"+data.image[index]+"'> <a style='color:black;'  href='"+data.url[index]+"' target='_blanck'>"+datat+ "</a> </div>";
              })

              latLng = new google.maps.LatLng(data.lat, data.lon);

              var infowindow = new google.maps.InfoWindow({
                 content: contenue,
                 maxWidth: 300
               });
              // Creating a marker and putting it on the map
              var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: data.title,
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
    });
  /** Ajouter different services **/
  $('#affichageservices').on('click',function () {
        if ($('#affichageservices').is(':checked')) {
            for(i=0; i < markers.length; i++){
                markers[i].setMap(null);
            }
            markers = [];
            for(i=0; i < markerservices.length; i++){
                markerservices[i].setMap(null);
            }
            markerservices = [];
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: "<?php echo $this->Url->build('/',true)?>annonces/getservicesmap",
                success:function(xml){
                    var jsontab = xml.residencesmap;
                    //console.log(jsontab);
                    markerservices = [];
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
                    
                    var infowindowservice = new google.maps.InfoWindow({
                        content: "<strong>"+convertcaracterjson(data.title)+"</strong>",
                        maxWidth: 300
                    });
                    // Creating a marker and putting it on the map
                    var marker = new google.maps.Marker({
                      position: latLng,
                      map: map,
                      title: convertcaracterjson(data.title),
                      icon: imageMarqueur,
                      //infowindow: infowindowservice
                    });
                    marker.addListener('click', function() {
                        infowindowservice.open(map, marker);
                    });

                    //markers.push(marker);
                    marker.setMap(map);
                    markerservices.push(marker);

                  });
                }
            });
            //alert('You have Checked it');
        } 
//        else {
//            for(i=0; i < markerservices.length; i++){
//                markerservices[i].setMap(null);
//            }
//            //alert('You Un-Checked it');
//        }
    });
  /** Fin Ajouter different services **/
  
$( ".hoverdiv" ).mouseenter(function() {
    var latlngclicked = new google.maps.LatLng($(this).attr("data-lat"), $(this).attr("data-lng"));
    markers.forEach(function(marker) {
        if(latlngclicked.equals(marker.getPosition())) {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }else{
           marker.setAnimation(null);
        }
    });
});

$( ".hoverdiv" ).mouseleave(function() {
    var latlngclicked = new google.maps.LatLng($(this).attr("data-lat"), $(this).attr("data-lng"));
    markers.forEach(function(marker) {
        if(latlngclicked.equals(marker.getPosition())) {
           marker.setAnimation(null);
        }
    });
});

  function clickroute(lati,long) {
        map.setZoom(19);
        var latLng = new google.maps.LatLng(lati, long); //Makes a latlng
        map.panTo(latLng); //Make map global
        if (window.matchMedia("(max-width: 767px)").matches) {
            var positiondiv = $("#mapdiv").offset();
            scrollTo(document.body, positiondiv.top-30);
        }

    }

});
function hideAllInfoWindows(map) {
   markers.forEach(function(marker) {
     marker.infowindow.close(map, marker);
    });
  }
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&callback=initMap&language=".$language_header_name, array('block' => 'scriptBottom')); ?>
 <?php $this->Html->script("jquery.pin.js", array('block' => 'scriptBottom')); ?>
 
 
 
 <!--Form Annomnce -->
 <div class="container-fluid mt-n4">
    <?php  echo $this->element("menu_recherche_bande")?>
 <!--************* End Form Annomnce-->
<?php  $idStation=$this->request->query["annonce"]["lieugeo"]; //recuperer identifiant de la station afin de pouvoir faire afficher un message special pour chaque station//echo $idStation;?>

<?php 
  if(isset($includes_new_annonces) && $includes_new_annonces) {
    $totalPageCount = count($annoncestotal);
  } else {
    $paginatorInformation = $this->Paginator->params(); 
    $totalPageCount = $paginatorInformation['count'];
  }
?>
<?php  ?>

<?php 
$natureAnn = array("STD"=>"Studio","APP"=>"Appart.","CHA"=>"Chalet","DIV"=>"Location","VIL"=>"Villa","GIT"=>"Gîte"); 
if($natureAPP != "") $natureAPP = $natureAnn[$natureAPP];
?>
<?php // print_r($villageinfo['lieugeo']->name); 
//  print_r($villageinfo->name); 
if(count($_GET) == 1 && isset($_GET['village'])){
  $this->Html->meta(null, null, ['name' => 'description','content' => __("Location appartements et chalets à {0}. Réservez votre séjour en station de ski : Annonces vérifiées, paiement sécurisé jusqu'à 4x sans frais.", [$villageinfo->name]) ,'block' => 'meta']);
  $this->assign('title', __('Location à {0} - Appartements et chalets à {1} | Alpissime.com', [$villageinfo->name, $villageinfo['lieugeo']->name]));
  $this->Html->meta(null, null, ['property' => 'og:title','content' => 'Alpissime.com | '. __('Location à {0} - Appartements et chalets à {1} | Alpissime.com', [$villageinfo->name, $villageinfo['lieugeo']->name]),'block' => 'meta']);
}else{ 
  $this->Html->meta(null, null, ['name' => 'description','content' => __("Séjour ski - Réservez vos vacances sur Alpissime | Hébergements vérifiés ⛷ Activités en station ⭐ Services de conciergerie | Paiement en 4x sans frais") ,'block' => 'meta']);
  $this->assign('title', __('Location {0} {1} {2}', [$natureAPP, $stationDetail['a'], $stationDetail['name']]));
  $this->Html->meta(null, null, ['property' => 'og:title','content' => 'Alpissime.com | '. __('Location {0} {1} {2}', [$natureAPP, $stationDetail['a'], $stationDetail['name']]),'block' => 'meta']);
} ?>


<div id="mes_annonces" class="mes_annonces"> <!--mes_annonces-->
      <?php foreach($annonces as $enr){ $id=$a_lieugeos[$enr->lieugeo_id];}?>
      
			<div class="row px-sm-2 px-md-4">
        <div class="annonce block px-sm-0 px-md-3 col-lg-7"><!--annonce block-->
        <div class="row pt-3">
        <div class="col-md-5">
          <h1 class="text-blue pt-2"><?php echo $totalPageCount ?> <?= __("résultats de location") ?> <?php 
          // if($this->request->query['lieugeo'] == 100) echo "Les Arcs";
          // else if($this->request->query['lieugeo'] == 200) echo "Val d'Allos";
          // else if($this->request->query['lieugeo'] == 300) echo "Montchavin Les Coches";
          // else 
          echo $nom_lieugeo;
          ?> </h1>
        </div>
        <div class="col-md-5">
          <div class="form-group row">
            <label class="col-md-4 col-form-label"><?= __("Trié par") ?> :  </label>
            <div class="col-md-8">
               <?php echo $this->Form->input("TRI",[
                  'label'=>false,
                  'div'=>false,
                  'id'=>'triselect',
                  'type'=>'select',
                  'options'=>[0=>'---',1=>__('Prix').' ('.__('croissant').')',2=>__('Prix').' ('.__('décroissant').')',3=>__('Surface').' ('.__('croissante').')',4=>__('Surface').' ('.__('décroissante').')',6=>__('Classement').' ('.__('croissant').')',7=>__('Classement').' ('.__('décroissant').')',5=>__('Popularité')],
                  // 'size'=>'auto',
                  'class'=>'form-control custom-select', 'value'=>$this->request->query['TRI']])?>
  
            </div>
          </div>
        </div>
        </div>
          <?php  if ($this->Paginator->counter()>0)
        { //foreach($annonces as $enr) {
          $annonces = $annonces->toArray();
         ?>
        <div class="product">
                <div class="">
                    <div class="list-inline products row">
	                     <?php for($i=0;$i<count($annonces);$i++) {?>
                       <?php if($avecdispoval != 'oui'){
                         $idpourtest = $annonces[$i]->id;
                       }else{
                         if($annonces[$i]){
                          $lid[$i] = $annonces[$i]->toArray();
                          $idpourtest = $lid[$i]['Annonces']['id'];
                         }
                         
                       }
                        if($idpourtest){ ?>
                          <div class="col-6 col-md-4 col-xl-4 mb-3" id="<?php echo $annonces[$i]->id ?>">
                                    <div class="featured-product">
                                        <?php
                                        $db = $this->request->query['dbt'];
                                        $fn = $this->request->query['fin'];
                                        $nbradlt = $this->request->query['nbCouchage_ad'];
                                        $nbrenf = $this->request->query['nbCouchage_enf'];
                                        $animaux = $this->request->query['animaux'];
                                        if($avecdispoval != 'oui'){

                                          echo $this->element('petite_annonce', array('annonce'=>$annonces[$i], 'photo'=>$photos, 'residence'=>$residenceAnnonce, 'minprixannonce'=>$minprixannonce, 'noteglobalmoy'=>$noteglobalmoy, 'db'=>$db, 'fn'=>$fn, 'nbradlt'=>$nbradlt, 'nbrenf'=>$nbrenf, 'animaux'=>$animaux, 'prixtotalpourpetiteannonce' => $prixtotalpourpetiteannonce) );

                                        }else{
                                         /** CAS A TRAITER POUR LISTE MARQUEURS **/
                                         if($annonces[$i]) $annonces[$i] = $annonces[$i]->toArray();

                                        echo $this->element('petite_annonce', array('annonce'=>$annonces[$i]['Annonces'], 'photo'=>$photos, 'residence'=>$residenceAnnonce, 'minprixannonce'=>$minprixannonce, 'noteglobalmoy'=>$noteglobalmoy, 'db'=>$db, 'fn'=>$fn, 'prixtotalpourpetiteannonce' => $prixtotalpourpetiteannonce, 'rechercheDispoVillage'=>$annonces[$i]['village']['name'], 'rechercheDispoLieugeo'=>$annonces[$i]['lieugeo']['nom_url']) );

                                     }?>
                                    </div>
                                </div>
                       <?php } ?>
                            
	                  <?php } ?>
                    <div class="col-6 col-md-4 d-block d-md-none">
                      <a href="<?php echo $this->Url->build('/',true).$urlLang;?>sejour-ski-tout-compris" target="_blanck"> 
                        <?php if(in_array(date("m"),array('05','06','07','08'))){
                          if($this->Session->read('Config.language') == 'fr_FR') $mediabannerimagemobile = $mediabannermobile->lien_ete; else $mediabannerimagemobile = $mediabannermobile->_translations[$this->Session->read('Config.language')]->lien_ete;  
                        ?>
                          <picture>
                              <source srcset="<?php echo $this->Url->build('/',true).$mediabannerimagemobile;?>.webp" type="image/webp">
                              <source srcset="<?php echo $this->Url->build('/',true).$mediabannerimagemobile;?>.jpg" type="image/jpg">
                              <img class="img-fluid" src="<?php echo $this->Url->build('/').$mediabannerimagemobile;?>.jpg" class="img-rounded img-responsive">
                          </picture> 
                          <!-- <img src="<?php // echo $this->Url->build('/', true); ?>images/carre-slide-in-menu-(mobile)-ETE.jpg" class="img-rounded img-responsive" alt="reductions-en-station-alpissime"> -->
                        <?php }else{ 
                          if($this->Session->read('Config.language') == 'fr_FR') $mediabannerimagehivermobile = $mediabannermobile->lien_hiver; else $mediabannerimagehivermobile = $mediabannermobile->_translations[$this->Session->read('Config.language')]->lien_hiver;
                        ?>
                          <picture>
                              <source srcset="<?php echo $this->Url->build('/',true).$mediabannerimagehivermobile;?>.webp" type="image/webp">
                              <source srcset="<?php echo $this->Url->build('/',true).$mediabannerimagehivermobile;?>.jpg" type="image/jpg">
                              <img class="img-fluid" src="<?php echo $this->Url->build('/').$mediabannerimagehivermobile;?>.jpg" class="img-rounded img-responsive">
                          </picture>
                          <!-- <img src="<?php // echo $this->Url->build('/', true); ?>images/carre-slide-in-menu-(mobile)-HIVER.jpg" class="img-rounded img-responsive" alt="reductions-en-station-alpissime"> -->
                        <?php } ?> 
                      </a>
                    </div>

                    </div>
                  </div>
        </div>
        
<?php
  }
  if($totalPageCount == 0){
    echo "<div class='zero_result'>Aucune résultat pour cette recherche</div>";
  }
    ?>
    <a class="d-none d-md-block" href="<?php echo $this->Url->build('/',true).$urlLang;?>sejour-ski-tout-compris" target="_blanck"> 
      <?php if(in_array(date("m"),array('05','06','07','08'))){
              if($this->Session->read('Config.language') == 'fr_FR') $mediabannerimage = $mediabanner->lien_ete; else $mediabannerimage = $mediabanner->_translations[$this->Session->read('Config.language')]->lien_ete;  
          ?>
          <picture>
              <source srcset="<?php echo $this->Url->build('/',true).$mediabannerimage;?>.webp" type="image/webp">
              <source srcset="<?php echo $this->Url->build('/',true).$mediabannerimage;?>.jpg" type="image/jpg">
              <img class="img-fluid" src="<?php echo $this->Url->build('/').$mediabannerimage;?>.jpg" class="img-rounded img-responsive">
          </picture> 
        <!-- <img src="<?php // echo $this->Url->build('/', true); ?>images/Banner-Recherche-(desktop)-ETE.jpg" class="img-rounded img-responsive" alt="reductions-en-station-alpissime"> -->
      <?php }else{
        if($this->Session->read('Config.language') == 'fr_FR') $mediabannerimagehiver = $mediabanner->lien_hiver; else $mediabannerimagehiver = $mediabanner->_translations[$this->Session->read('Config.language')]->lien_hiver;
        ?>
          <picture>
              <source srcset="<?php echo $this->Url->build('/',true).$mediabannerimagehiver;?>.webp" type="image/webp">
              <source srcset="<?php echo $this->Url->build('/',true).$mediabannerimagehiver;?>.jpg" type="image/jpg">
              <img class="img-fluid" src="<?php echo $this->Url->build('/').$mediabannerimagehiver;?>.jpg" class="img-rounded img-responsive">
          </picture> 
        <!-- <img src="<?php //echo $this->Url->build('/', true); ?>images/Banner-Recherche-(desktop)-HIVER.jpg" class="img-rounded img-responsive" alt="reductions-en-station-alpissime"> -->
      <?php } ?> 
    </a>
			  </div><!-- end annances block-->
        <div class="col-lg-5 pl-2 pr-2 pt-3" style="padding: 0;">
        <div class="row">
        <div class="col-md-12">
          <div class="optionsaffichage pt-2">
              <div class="form-group">
            <label class="mr-2"><?= __("Options D'affichage") ?> :  </label>
            </div>
            <div class="form-group radios">
                <input type="radio" value="1" id="affichageimmeubles" CHECKED name="affichageoption">
                <label for="affichageimmeubles"><?= __("Immeubles") ?> </label>
                <input type="radio" value="2" id="affichageservices"  <?php if($this->request->query["affichageoption"]==2) echo "CHECKED"?> name="affichageoption">
                <label for="affichageservices"><?= __("Services") ?> </label>                
                <input type="radio" value="3" id="affichageservicesimmeubles"  <?php if($this->request->query["affichageoption"]==3) echo "CHECKED"?> name="affichageoption">
                <label for="affichageservicesimmeubles"><?= __("Immeubles et Services") ?></label>                
            </div> 
          </div>
        </div>
        </div>
          <div id="mapdiv" class="maprelative">
                            
            <div id="map" style="width:100%; height:100%"></div>
          </div>
        </div>
        </div>
  <div class="row px-sm-2 px-md-4">
    <div class="col-md-12 mt-4">
			<div class="pagination mt-4">
                    <ul class="list-inline"><?php if(!empty($this->Paginator->first('<<'))){ ?>
                      <?php echo $this->Paginator->first('<<'); ?>
                            <?php } ?>
                     <?php $affichePages=$this->Paginator->numbers(['modulus'=>5]); if ($affichePages=='') {} else { $affichePages=$this->Paginator->numbers(['modulus'=>5]); echo ($affichePages); } ?>
                 <?php if(!empty($this->Paginator->last('>>'))){ ?>
                    <?php echo $this->Paginator->last('>>'); ?>
                   <?php } ?>
                            </ul>			</div><!--end pagination-->
	      </div><!--end col-md-12-->
  </div>
</div> <!-- end mes_annonces-->
</div>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
    var villageinfo = "<?php echo $_GET['village'];?>";
    var countVarGet = <?php echo count($_GET)>0?count($_GET):0;?>;
    if(villageinfo != "" && countVarGet == 1){
      $("#lieugeo").val(<?php echo $villageinfo['lieugeo']->id;?>);
      get_village($("#lieugeo").val());
      $("#village").val(<?php echo $villageinfo->id;?>);
    }
    $("#triselect").change(function() {
    var input = $("<input>")
               .attr("type", "hidden")
               .attr("name", "TRI").val($('#triselect').val());
    $('#annonceRechercheForm').append(input);
    $("#annonceRechercheForm").submit();
});
<?php $this->Html->scriptEnd(); ?>