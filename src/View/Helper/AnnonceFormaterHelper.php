<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\StringTemplateTrait;

class AnnonceFormaterHelper extends Helper
{
  var $helpers = array("Html");

   /**
   * Vignette petite, uniquement libellé
   * @param enregistrement annonce
   * @param liste des distances
   */
  public function vignette_petite($data,$l_distances)
  {
    //$annonce = $data["Annonce"];
	//print_r($l_distances);die();
    $laville = strtolower(str_replace(" ","-",trim($data->lieugeo->name)));
    $lannonce = strtolower(str_replace(" ","-",trim($data->titre)));
    $lannonce.= ".html";
    $vignette = "vignette-".$data->id."-1.jpg";

    $formatSimple = "<table><tbody>";
    $formatSimple.= "<tr>";
    $formatSimple.= "<td><b>";
    $formatSimple.= $this->Html->link($data->titre,array(
                            "controller"=>"annonces","action"=>"view",$data->id."-".$lannonce));
    $formatSimple.= "</b><br>";
    $formatSimple.= $this->getLib($data)."<br>";
    $formatSimple.= "Remontées : ".$l_distances[$data->kmstat_id];
    $formatSimple.= "</td></tr></tbody></table>";
    return $formatSimple;
  }
  /*
   */
   function testName($test){
		return $test;
   }
  /**
   * Vignette simple, page index
   * @param enregistrement annonce
   * @param liste des distances
   */
  public function vignette($data,$l_distances,$url=false,$photo,$residence)
  {
    $annonce = $data;

	/*echo "<pre>";
	print_r($data);*/
  $vues=array('1'=>__('Vallée'),'2'=>__('Pistes'),'3'=>__('Station'),'4'=>__('Autre'));
    $laville = strtolower(str_replace(" ","-",trim($data['lieugeo']["name"])));
    $lannonce = strtolower(trim($this->formatStr($annonce["titre"])));
    $lannonce.= ".html";
	$num_pho = $photo[$annonce['id']][0];
    $vignette = "vignette-".$annonce['id']."-".$num_pho.".P.jpg?v=".(time()*1000);
	$img='<img class="produit-annonce-home" title="'.$laville.':'.htmlspecialchars(html_entity_decode($annonce["titre"])).'" alt="'.$laville.':'.$annonce["titre"].'" src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'">';
    $classe="";
    if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0)$classe="description-product wifi";else $classe="description-product";
    $formatSimple="<div class='featured-product'><div class='featured-image landing_img'>";

if($annonce['nb_etoiles']==5){$immmg="5stars";}
else if($annonce['nb_etoiles']==4){$immmg="4stars";}
else if($annonce['nb_etoiles']==3){$immmg="3stars";}
else if($annonce['nb_etoiles']==2){$immmg="2stars";}
    else if($annonce['nb_etoiles']==1){$immmg="1star";}
else {
  if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0) $immmg="wifi";
  else $immmg="alpissimeicon";
}
if(empty($annonce->etage)) $annonce->etage = "Non renseigné ";
    $formatSimple.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."'>$img<img src='".$url."images/ico/".$immmg.".png' alt='stars' class='product-etat'><div class='viewnew'>
    <div class='voirplusbut'>
    <img src='".$url."images/icon/surface.png' alt='icon-surface' title='Icon surface' />
     : ".$annonce->surface." m<sup>2</sup><br>
    <img src='".$url."images/icon/vue.png' alt='icon-vue' title='Icon vue' />
     : ".$vues[$annonce->vue]."<br>
    <img src='".$url."images/icon/personne.png' alt='icon-personne' title='Icon personne' />
     : ".$annonce->personnes_nb."<br>
    <img src='".$url."images/icon/residence.png' alt='icon-residence' title='Icon residence' />
     : ".$residence[$annonce->batiment]."<br>
    <img src='".$url."images/icon/etage.png' alt='icon-etage' title='Icon etage' />
     : ".$annonce->etage."<br>
    </div><span><img src='".$url."images/icon/loupe.png' alt='icon-loupe' title='Icon loupe' /> Voir Plus</span></div></a>";
    $formatSimple.="</div>";

	  $formatSimple.= "<div class='title-product'>Annonce n° ".$annonce['id']."</div>";
    $formatSimple.= "<div class='".$classe."' ><span class='text'>".$this->Html->link(ucfirst(strtolower($annonce['titre'])),array(
                            "controller"=>"annonces","action"=>"view",$annonce['id'].'-'.$lannonce))."</span>";
    $formatSimple.= "<p>";
    $formatSimple.= "Location ".$laville."<br>";
    $formatSimple.= $this->getLib($annonce)."<br>";
    $formatSimple.= "Remontées : ".$l_distances[$annonce['kmstat_id']]."</p></div></div>";
    
    return $formatSimple;
  }

  public function vignetterecherche($data,$l_distances,$url=false,$photo,$residence,$minprixannonce=null,$noteglobalmoy=null,$marqueurMaps=null, $db=null, $fn=null)
  {
    $annonce = $data;
    
    $vues=array('1'=>__('Vallée'),'2'=>__('Pistes'),'3'=>__('Station'),'4'=>__('Autre'));
    $laville = strtolower(str_replace(" ","-",trim($data['lieugeo']["name"])));
    $lannonce = strtolower(trim($this->formatStr($annonce["titre"])));
    $lannonce.= ".html";
    $num_pho = $photo[$annonce['id']][0];
    //$vignette = "vignette-".$annonce['id']."-".$num_pho.".P.jpg?v=".(time()*1000);
    //$img='<img class="produit-annonce-home" title="'.$laville.':'.htmlspecialchars(html_entity_decode($annonce["titre"])).'" alt="'.$laville.':'.$annonce["titre"].'" src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'">';
    $classe="";
    if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0)$classe="description-product wifi";else $classe="description-product";
    
    if(isset($residence[$annonce->batiment]['lat']) && isset($residence[$annonce->batiment]['lon'])) $formatSimple="<div class='featured-product hoverdiv' data-lat='".$residence[$annonce->batiment]['lat']."' data-lng='".$residence[$annonce->batiment]['lon']."'><div class='featured-image landing_img'>";
    else $formatSimple="<div class='featured-product hoverdiv' data-lat='' data-lng=''><div class='featured-image landing_img'>";

    if($annonce['nb_etoiles']==5){$immmg="stars5";}
    else if($annonce['nb_etoiles']==4){$immmg="stars4";}
    else if($annonce['nb_etoiles']==3){$immmg="stars3";}
    else if($annonce['nb_etoiles']==2){$immmg="stars2";}
    else if($annonce['nb_etoiles']==1){$immmg="star1";}
    else {
      if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0) $immmg="wifimg";
      else $immmg="alpissimeicon";
    }
    if(empty($annonce->etage)) $annonce->etage = "Non renseigné ";
    // if($db != '' || $fn != '') $formatSimple.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."/".$db."/".$fn."'>";
    // else $formatSimple.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."'>";
    //$formatSimple.=$img;
    $formatSimple.=' <div id="myCarousel'.$annonce['id'].'" class="carousel slide" data-ride="carousel" data-interval="false">
    <!-- Indicators -->
    <ol class="carousel-indicators">';
    $formatSimple.= '<li data-target="#myCarousel'.$annonce['id'].'" data-slide-to="0" class="active"></li>';
    if(count($photo[$annonce['id']])>4) $countphoto = 4;
    else $countphoto = count($photo[$annonce['id']]);
    for($p=1; $p<$countphoto; $p++){
        $formatSimple.= '<li data-target="#myCarousel'.$annonce['id'].'" data-slide-to="'.$p.'"></li>';
    }
    $formatSimple.= '</ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">';
    if(!empty($photo[$annonce['id']][0])){
      $vignette = $annonce['id'].'/'."vignette-".$annonce['id']."-".$photo[$annonce['id']][0].".P.jpg?v=".(time()*1000);
    }else{
      $vignette = "no_annonce_image.jpg";
    }
        
    $formatSimple.= '<div class="carousel-item active">';
    if($db != '' || $fn != '') $formatSimple.='<a href="'.$url.'detail/'.$annonce["id"].'-'.$lannonce."/".$db."/".$fn.'"><img class="datasrc" data-src="'.$url.'images_ann/'.$vignette.'" src="'.$url.'images_ann/'.$vignette.'" alt="Image '.$photo[$annonce['id']][0].' Annonce '.$annonce['id'].'" style="width:100%;"></a>';
    else $formatSimple.='<a href="'.$url.'detail/'.$annonce["id"].'-'.$lannonce.'"><img class="datasrc" data-src="'.$url.'images_ann/'.$vignette.'" src="'.$url.'images_ann/'.$vignette.'" alt="Image '.$photo[$annonce['id']][0].' Annonce '.$annonce['id'].'" style="width:100%;"></a>';
    $formatSimple.='</div>';
    for($ph=1; $ph<$countphoto; $ph++){
    //foreach ($photo[$annonce['id']] as $phot){
        $vignette = "vignette-".$annonce['id']."-".$photo[$annonce['id']][$ph].".P.jpg?v=".(time()*1000);
        $vignetteG = "vignette-".$annonce['id']."-".$photo[$annonce['id']][$ph].".P.jpg?v=".(time()*1000);
        $formatSimple.= '<div class="carousel-item">';
        if($db != '' || $fn != '') $formatSimple.='<a href="'.$url.'detail/'.$annonce["id"].'-'.$lannonce."/".$db."/".$fn.'"><img class="datasrc" data-src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'"  src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'" alt="Image '.$photo[$annonce['id']][$ph].' Annonce '.$annonce['id'].'" style="width:100%;"></a>';
        else $formatSimple.='<a href="'.$url.'detail/'.$annonce["id"].'-'.$lannonce.'"><img class="datasrc" data-src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'"  src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'" alt="Image '.$photo[$annonce['id']][$ph].' Annonce '.$annonce['id'].'" style="width:100%;"></a>';
      $formatSimple.='</div>';
    }
              
    $formatSimple.= '</div>
    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#myCarousel'.$annonce['id'].'" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel'.$annonce['id'].'" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div> ';
    $formatSimple.="<img src='".$url."images/icon/img_trans.gif' alt='stars' class='product-etat $immmg'>";

    if($db != '' && $fn != '' && $minprixannonce[$annonce['id']]['promo'] == 1) $formatSimple .= '<span class="product-etat-btn mr-1">Promotion</span>';
  
    if($minprixannonce[$annonce['id']]['prixmin'] == '' || $minprixannonce[$annonce['id']]['prixmin'] == 0) $minprixannonce[$annonce['id']]['prixmin']="";
    else $minprixannonce[$annonce['id']]['prixmin'] = "Dès ".$minprixannonce[$annonce['id']]['prixmin']." / Nuitée";
    
    $formatSimple.="</div>";

    // $formatSimple.= "<div class='title-product'>Annonce n° ".$annonce['id']."</div>";
    $formatSimple.= "<div class='".$classe."' >";
    $formatSimple.= "<p>";
    $formatSimple.= $data['village']["name"]." - ";
    $formatSimple.= $this->getLib($annonce)."</p>";

    //$formatSimple.= "<span class='text'>";
//            .$this->Html->link(ucfirst(strtolower($annonce['titre'])),array(
//                            "controller"=>"annonces","action"=>"view",$annonce['id'].'-'.$lannonce.'/'.$db.'/'.$fn))
    if($db != '' || $fn != '') $formatSimple.= "<a class='text' href='".$url."detail/".$annonce['id']."-".$lannonce."/".$db."/".$fn."'>".ucfirst(strtolower($annonce['titre']))."</a>";
    else $formatSimple.= "<a class='text' href='".$url."detail/".$annonce['id']."-".$lannonce."'>".ucfirst(strtolower($annonce['titre']))."</a>";
    //$formatSimple.="</span>";
    
    // $formatSimple.= $annonce->surface." m<sup>2</sup>";
    $formatSimple.= "<p> ".$minprixannonce[$annonce['id']]['prixmin'];
    
    if($noteglobalmoy[$annonce['id']] > 0){
        $etoile1 = ''; 
        $etoile2 = '';
        $etoile3 = '';
        $etoile4 = '';
        $etoile5 = '';
        if($noteglobalmoy[$annonce['id']] >= 1) $etoile1 = "gold";
        if($noteglobalmoy[$annonce['id']] >= 2) $etoile2 = "gold";
        if($noteglobalmoy[$annonce['id']] >= 3) $etoile3 = "gold";
        if($noteglobalmoy[$annonce['id']] >= 4) $etoile4 = "gold";
        if($noteglobalmoy[$annonce['id']] >= 5) $etoile5 = "gold";
        $formatSimple.= "<span class='stars'>
		<i class='fa fa-star newnote ".$etoile1."'></i>
		<i class='fa fa-star newnote ".$etoile2."'></i>
		<i class='fa fa-star newnote ".$etoile3."'></i>
		<i class='fa fa-star newnote ".$etoile4."'></i>
		<i class='fa fa-star newnote ".$etoile5."'></i>
	</span>";
    }
    
    $formatSimple.= "</p></div></div>";
    
    return $formatSimple;
  }

  public function vignette_avec_dispo($data,$lieugeo,$l_distances,$url=false,$photo,$residence)
  {
    $annonce = $data;
    $vues=array('1'=>__('Vallée'),'2'=>__('Pistes'),'3'=>__('Station'),'4'=>__('Autre'));
  /*echo "<pre>";
  print_r($data);*/
  //  $laville = strtolower(str_replace(" ","-",trim($data['lieugeo']["name"])));
    $lannonce = strtolower(trim($this->formatStr($annonce["titre"])));
    $lannonce.= ".html";
	$num_pho = $photo[$annonce['id']][0];
    $vignette = "vignette-".$annonce['id']."-".$num_pho.".P.jpg?v=".(time()*1000);
  $img='<img class="produit-annonce-home" title="'.$lieugeo[$annonce['lieugeo_id']].':'.htmlspecialchars(html_entity_decode($annonce["titre"])).'" alt="'.$laville.':'.$annonce["titre"].'" src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'">';
    $classe="";
    if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0)$classe="description-product wifi";else $classe="description-product";
    $formatSimple="<div class='featured-product'><div class='featured-image landing_img'>";

    if($annonce['nb_etoiles']==5){$immmg="5stars";}
    else if($annonce['nb_etoiles']==4){$immmg="4stars";}
    else if($annonce['nb_etoiles']==3){$immmg="3stars";}
    else if($annonce['nb_etoiles']==2){$immmg="2stars";}
    else if($annonce['nb_etoiles']==1){$immmg="1star";}
    else {
      if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0) $immmg="wifi";
      else $immmg="alpissimeicon";
    }
if(empty($annonce['etage'])) $annonce['etage'] = "Non renseigné ";
if($db != '' || $fn != '') $formatSimple.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."/".$db."/".$fn."'>";
else $formatSimple.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."'>";
    $formatSimple.= $img."<img src='".$url."images/ico/".$immmg.".png' alt='stars' class='product-etat'><div class='viewnew'>
    <div class='voirplusbut'>
    <img src='".$url."images/icon/surface.png' alt='icon-surface' title='Icon surface' />
     : ".$annonce['surface']." m<sup>2</sup><br>
    <img src='".$url."images/icon/vue.png' alt='icon-vue' title='Icon vue' />
     : ".$vues[$annonce['vue']]."<br>
    <img src='".$url."images/icon/personne.png' alt='icon-personne' title='Icon personne' />
     : ".$annonce['personnes_nb']."<br>
     <img src='".$url."images/icon/residence.png' alt='icon-residence' title='Icon residence' />
      : ".$residence[$annonce['batiment']]."<br>
     <img src='".$url."images/icon/etage.png' alt='icon-etage' title='Icon etage' />
      : ".$annonce['etage']."<br>
    </div><span><img src='".$url."images/icon/loupe.png' alt='icon-loupe' title='Icon loupe' /> Voir Plus</span></div></a>";
    $formatSimple.="</div>";

    $formatSimple.= "<div class='title-product'>Annonce n° ".$annonce['id']."</div>";
    $formatSimple.= "<div class='".$classe."' ><span class='text'>";
    if($db != '' || $fn != '') $formatSimple.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."/".$db."/".$fn."'>".ucfirst(strtolower($annonce['titre']))."</a>";
    else $formatSimple.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."'>".ucfirst(strtolower($annonce['titre']))."</a>";
//            .$this->Html->link(ucfirst(strtolower($annonce['titre'])),array(
//                            "controller"=>"annonces","action"=>"view",$annonce['id'].'-'.$lannonce.'/'.$db.'/'.$fn))
    $formatSimple.= "</span>";
    $formatSimple.= "<p>";
    $formatSimple.= "Location ".$lieugeo[$annonce['lieugeo_id']]."<br>";
    $formatSimple.= $this->getLib_avec_dispo($annonce)."<br>";
    $formatSimple.= "Remontées : ".$l_distances[$annonce['kmstat_id']]."</p></div></div>";

    return $formatSimple;
  }

  public function vignette_avec_disporecherche($data,$lieugeo,$l_distances,$url=false,$photo,$residence,$minprixannonce=null,$noteglobalmoy=null,$marqueurMaps=null, $db=null, $fn=null)
  {
    $annonce = $data['Annonces'];
    $vues=array('1'=>__('Vallée'),'2'=>__('Pistes'),'3'=>__('Station'),'4'=>__('Autre'));
  /*echo "<pre>";
  print_r($data);*/
  //  $laville = strtolower(str_replace(" ","-",trim($data['lieugeo']["name"])));
    $lannonce = strtolower(trim($this->formatStr($annonce["titre"])));
    $lannonce.= ".html";
	$num_pho = $photo[$annonce['id']][0];
    $vignette = "vignette-".$annonce['id']."-".$num_pho.".P.jpg?v=".(time()*1000);
  $img='<img class="produit-annonce-home" title="'.$lieugeo[$annonce['lieugeo_id']].':'.htmlspecialchars(html_entity_decode($annonce["titre"])).'" alt="'.$laville.':'.$annonce["titre"].'" src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'">';
    $classe="";
    if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0)$classe="description-product wifi";else $classe="description-product";
    $formatSimple="<div class='featured-product hoverdiv' data-lat='".$residence[$annonce['batiment']]['lat']."' data-lng='".$residence[$annonce['batiment']]['lon']."'><div class='featured-image landing_img'>";

    if($annonce['nb_etoiles']==5){$immmg="5stars";}
    else if($annonce['nb_etoiles']==4){$immmg="4stars";}
    else if($annonce['nb_etoiles']==3){$immmg="3stars";}
    else if($annonce['nb_etoiles']==2){$immmg="2stars";}
    else if($annonce['nb_etoiles']==1){$immmg="1star";}
    else {
      if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0) $immmg="wifi";
      else $immmg="alpissimeicon";
    }
    if(empty($annonce['etage'])) $annonce['etage'] = "Non renseigné ";
    if($minprixannonce[$annonce['id']]['prixmin'] == '' || $minprixannonce[$annonce['id']]['prixmin'] == 0) $minprixannonce[$annonce['id']]['prixmin']="";
    else $minprixannonce[$annonce['id']]['prixmin'] = "Dès ".$minprixannonce[$annonce['id']]['prixmin']." / Nuitée";
    $formatSimple.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."'>";
    //$formatSimple.=$img;
    $formatSimple.=' <div id="myCarousel'.$annonce['id'].'" class="carousel slide" data-ride="carousel" data-interval="false">
    <!-- Indicators -->
    <ol class="carousel-indicators">';
    $formatSimple.= '<li data-target="#myCarousel'.$annonce['id'].'" data-slide-to="0" class="active"></li>';
    if(count($photo[$annonce['id']])>4) $countphoto = 4;
    else $countphoto = count($photo[$annonce['id']]);
    for($p=1; $p<$countphoto; $p++){
        $formatSimple.= '<li data-target="#myCarousel'.$annonce['id'].'" data-slide-to="'.$p.'"></li>';
    }
    $formatSimple.= '</ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">';
    $vignette = "vignette-".$annonce['id']."-".$photo[$annonce['id']][0].".P.jpg?v=".(time()*1000);
    $formatSimple.= '<div class="carousel-item  active">';
    $formatSimple.= '<img src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'" alt="Photo '.$photo[$annonce['id']][0].' Annonce '.$annonce['id'].'" style="width:100%;">';
    $formatSimple.= '</div>';
    for($ph=1; $ph<$countphoto; $ph++){
    //foreach ($photo[$annonce['id']] as $phot){
        $vignette = "vignette-".$annonce['id']."-".$photo[$annonce['id']][$ph].".P.jpg?v=".(time()*1000);
        $formatSimple.= '<div class="carousel-item ">
        <img src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'" alt="Photo '.$photo[$annonce['id']][$ph].' Annonce '.$annonce['id'].'" style="width:100%;">
      </div>';
    }
              
    $formatSimple.= '</div>
    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#myCarousel'.$annonce['id'].'" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel'.$annonce['id'].'" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div> ';
    $formatSimple.="<img src='".$url."images/ico/".$immmg.".png' alt='stars' class='product-etat'>";

    if($db != '' && $fn != '' && $minprixannonce[$annonce['id']]['promo'] == 1) $formatSimple .= '<span class="product-etat-btn mr-1">Promotion</span>';

    // $formatSimple.= "<div class='viewnew'>
    // <div class='voirplusbut'>
    // <img src='".$url."images/icon/surface.png' alt='icon-surface' title='Icon surface' />
    //  : ".$annonce['surface']." m<sup>2</sup><br>
    // <img src='".$url."images/icon/vue.png' alt='icon-vue' title='Icon vue' />
    //  : ".$vues[$annonce['vue']]."<br>
    // <img src='".$url."images/icon/personne.png' alt='icon-personne' title='Icon personne' />
    //  : ".$annonce['personnes_nb']."<br>
    //  <img src='".$url."images/icon/residence.png' alt='icon-residence' title='Icon residence' />
    //   : ".$residence[$annonce['id']]['name']."<br>
    //  <img src='".$url."images/icon/etage.png' alt='icon-etage' title='Icon etage' />
    //   : ".$annonce['etage']."<br>
    // </div><span><img src='".$url."images/icon/loupe.png' alt='icon-loupe' title='Icon loupe' /> Voir Plus</span></div></a>";
    $formatSimple.="</div>";

    //$formatSimple.= "<div class='title-product'>Annonce n° ".$annonce['id']."</div>";
    $formatSimple.= "<div class='".$classe."' >";
    $formatSimple.= "<p>";
    $formatSimple.= $data['Villages']['name']." - ";
    $formatSimple.= $this->getLib2($annonce)."</p>";

    //$formatSimple.= "<span class='text'>";
//            .$this->Html->link(ucfirst(strtolower($annonce['titre'])),array(
//                            "controller"=>"annonces","action"=>"view",$annonce['id'].'-'.$lannonce.'/'.$db.'/'.$fn))
    if($db != '' || $fn != '') $formatSimple.= "<a class='text' href='".$url."detail/".$annonce['id']."-".$lannonce."/".$db."/".$fn."'>".ucfirst(strtolower($annonce['titre']))."</a>";
    else $formatSimple.= "<a class='text' href='".$url."detail/".$annonce['id']."-".$lannonce."'>".ucfirst(strtolower($annonce['titre']))."</a>";
    //$formatSimple.="</span>";
    
    // $formatSimple.= $annonce->surface." m<sup>2</sup>";
    $formatSimple.= "<p> ".$minprixannonce[$annonce['id']]['prixmin'];
    
    if($noteglobalmoy[$annonce['id']] > 0){
        $etoile1 = ''; 
        $etoile2 = '';
        $etoile3 = '';
        $etoile4 = '';
        $etoile5 = '';
        if($noteglobalmoy[$annonce['id']] >= 1) $etoile1 = "gold";
        if($noteglobalmoy[$annonce['id']] >= 2) $etoile2 = "gold";
        if($noteglobalmoy[$annonce['id']] >= 3) $etoile3 = "gold";
        if($noteglobalmoy[$annonce['id']] >= 4) $etoile4 = "gold";
        if($noteglobalmoy[$annonce['id']] >= 5) $etoile5 = "gold";
        $formatSimple.= "<span class='stars'>
		<i class='fa fa-star newnote ".$etoile1."'></i>
		<i class='fa fa-star newnote ".$etoile2."'></i>
		<i class='fa fa-star newnote ".$etoile3."'></i>
		<i class='fa fa-star newnote ".$etoile4."'></i>
		<i class='fa fa-star newnote ".$etoile5."'></i>
	</span>";
    }
    
    $formatSimple.= "</p></div></div>";

    return $formatSimple;
  }
  
  private function getLib_avec_dispo($annonce)
  {
      if($annonce['pieces_nb']==99)$annonce['pieces_nb']=" plus que 5";
    static $ar = array("STD"=>"Studio","APP"=>"Appart.","CHA"=>"Chalet","DIV"=>"Location","VIL"=>"Villa","GIT"=>"Gîte");

    $getLib="";
    if (array_key_exists($annonce['nature'],$ar))
        $getLib = $ar[$annonce['nature']];
    if ($annonce['nature']!="STD")
        $getLib.= " ".$annonce['pieces_nb']." pièces";
    $getLib.= " ".$annonce['personnes_nb']." personnes";
    return $getLib;
  }

  public function vignette_landing($data,$l_distances,$url=false,$photo,$residence)
  {
    $annonce = $data;
    $vues=array('1'=>__('Vallée'),'2'=>__('Pistes'),'3'=>__('Station'),'4'=>__('Autre'));
  /*echo "<pre>";
  print_r($data);*/
    $laville = strtolower(str_replace(" ","-",trim($data['lieugeo']["name"])));
    $lannonce = strtolower(trim($this->formatStr($annonce["titre"])));
    $lannonce.= ".html";
	$num_pho = $photo[$annonce['id']][0];
    $vignette = "vignette-".$annonce['id']."-".$num_pho.".P.jpg?v=".(time()*1000);
  $img='<img class="produit-annonce-home" title="'.$laville.':'.htmlspecialchars(html_entity_decode($annonce["titre"])).'" alt="'.$laville.':'.$annonce["titre"].'" src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'">';
    $classe="";
    if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0)$classe="description-product wifi";else $classe="description-product";
    $formatSimple="<div class='featured-product'><div class='featured-image landing_img'>";

    if($annonce['nb_etoiles']==5){$immmg="5stars";}
    else if($annonce['nb_etoiles']==4){$immmg="4stars";}
    else if($annonce['nb_etoiles']==3){$immmg="3stars";}
    else if($annonce['nb_etoiles']==2){$immmg="2stars";}
    else if($annonce['nb_etoiles']==1){$immmg="1star";}
    else {
      if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0) $immmg="wifi";
      else $immmg="alpissimeicon";
    }
if(empty($annonce->etage)) $annonce->etage = "Non renseigné ";
    $formatSimple.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."'>$img<img src='".$url."images/ico/".$immmg.".png' alt='stars' class='product-etat'><div class='viewnew'>
    <div class='voirplusbut'>
    <img src='".$url."images/icon/surface.png' alt='icon-surface' title='Icon surface' />
     : ".$annonce->surface." m<sup>2</sup><br>
    <img src='".$url."images/icon/vue.png' alt='icon-vue' title='Icon vue' />
     : ".$vues[$annonce->vue]."<br>
    <img src='".$url."images/icon/personne.png' alt='icon-personne' title='Icon personne' />
     : ".$annonce->personnes_nb."<br>
     <img src='".$url."images/icon/residence.png' alt='icon-residence' title='Icon residence' />
      : ".$residence[$annonce->batiment]."<br>
     <img src='".$url."images/icon/etage.png' alt='icon-etage' title='Icon etage' />
      : ".$annonce->etage."<br>
    </div><span><img src='".$url."images/icon/loupe.png' alt='icon-loupe' title='Icon loupe' /> Voir Plus</span></div></a>";
    $formatSimple.="</div>";

    $formatSimple.= "<div class='title-product'>Annonce n° ".$annonce['id']."</div>";
    $formatSimple.= "<div class='".$classe."' ><span class='text'>".$this->Html->link(ucfirst(strtolower($annonce['titre'])),array(
                            "controller"=>"annonces","action"=>"view",$annonce['id'].'-'.$lannonce))."</span>";
    $formatSimple.= "<p>";
    $formatSimple.= "Location ".$laville."<br>";
    $formatSimple.= $this->getLib($annonce)."<br>";
    $formatSimple.= "Remontées : ".$l_distances[$annonce['kmstat_id']]."</p></div></div>";

    return $formatSimple;
  }


 public function vignette2($data,$l_distances,$url=false,$photo,$residence,$minprixannonce=null,$noteglobalmoy=null)
  {
    $annonce = $data;
    $vues=array('1'=>__('Vallée'),'2'=>__('Pistes'),'3'=>__('Station'),'4'=>__('Autre'));
    $laville = strtolower(str_replace(" ","-",trim($data["lieugeo"]["name"])));
    $lannonce = strtolower(trim($this->formatStr($annonce["titre"])));
    $lannonce.= ".html";
  $num_pho = $photo[$annonce['id']][0];
  
  if(!empty($photo[$annonce['id']][0])){
    $vignette = $annonce['id'].'/'."vignette-".$annonce['id']."-".$num_pho.".P.jpg?v=".(time()*1000);
  }else{
    $vignette = "no_annonce_image.jpg";
  }
    
    $img='<img class="produit-annonce-home datasrc" src="'.$url.'images_ann/'.$vignette.'" title="'.$laville.':'.$annonce["titre"].'" alt="'.$laville.':'.$annonce["titre"].'" >';
    $formatSimple = "<div class='featured-product'>";
    $formatSimple.= "<div class='featured-image landing_img'>";

    if($annonce['nb_etoiles']==5){$immmg="stars5";}
    else if($annonce['nb_etoiles']==4){$immmg="stars4";}
    else if($annonce['nb_etoiles']==3){$immmg="stars3";}
    else if($annonce['nb_etoiles']==2){$immmg="stars2";}
    else if($annonce['nb_etoiles']==1){$immmg="star1";}
    else {
      if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0) $immmg="wifimg";
      else $immmg="alpissimeicon";
    }
if(empty($annonce->etage)) $annonce->etage = "Non renseigné ";
 if($minprixannonce[$annonce['id']]['prixmin'] == '' || $minprixannonce[$annonce['id']]['prixmin'] == 0) $minprixannonce[$annonce['id']]['prixmin']="";
    else $minprixannonce[$annonce['id']]['prixmin'] = "Dès ".$minprixannonce[$annonce['id']]['prixmin']." / Nuitée";
    
    $formatSimple.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."'>$img<img src='".$url."images/icon/img_trans.gif' alt='WIFI' class='product-etat $immmg'>
    </a>";
    $formatSimple.="</div>";
    // $formatSimple.= "<div class='title-product'>";
	  // $formatSimple.= "Annonce n° ".$annonce['id']."</div>";
    $formatSimple.= "<div class='description-product'>";
    $formatSimple.= "<p>";
    $formatSimple.= $data["lieugeo"]["name"]." - ";
    $formatSimple.= $this->getLib($annonce);    
    //$formatSimple.= $annonce->surface." m<sup>2</sup></p><p class='prixminbloc'> ".$minprixannonce[$annonce['id']]['prixmin'];
    $formatSimple.= "</p>";
    $formatSimple.= "<span class='text' >".$this->Html->link(ucfirst(strtolower($annonce['titre'])),array(
                            "controller"=>"annonces","action"=>"view",$annonce['id']."-".$lannonce))."</span>";
    
    $formatSimple.= "<p > ".$minprixannonce[$annonce['id']]['prixmin'];
    
    if($noteglobalmoy[$annonce['id']] != 0){
        $etoile1 = ''; 
        $etoile2 = '';
        $etoile3 = '';
        $etoile4 = '';
        $etoile5 = '';
        if($noteglobalmoy[$annonce['id']] >= 1) $etoile1 = "gold";
        if($noteglobalmoy[$annonce['id']] >= 2) $etoile2 = "gold";
        if($noteglobalmoy[$annonce['id']] >= 3) $etoile3 = "gold";
        if($noteglobalmoy[$annonce['id']] >= 4) $etoile4 = "gold";
        if($noteglobalmoy[$annonce['id']] >= 5) $etoile5 = "gold";
        $formatSimple.= "<span class='stars'>
		<i class='fa fa-star newnote ".$etoile1."'></i>
		<i class='fa fa-star newnote ".$etoile2."'></i>
		<i class='fa fa-star newnote ".$etoile3."'></i>
		<i class='fa fa-star newnote ".$etoile4."'></i>
		<i class='fa fa-star newnote ".$etoile5."'></i>
	</span>";
    }
    
    $formatSimple.= "</p></div></div>";
    return $formatSimple;
  }
  public function vignette3($data,$l_distances,$url=false,$photo)
   {
     if($annonce->pieces_nb==99)$annonce->pieces_nb=" plus que 5";
     $annonce = $data;
     $vues=array('1'=>__('Vallée'),'2'=>__('Pistes'),'3'=>__('Station'),'4'=>__('Autre'));
	 $num_pho = $photo[$annonce['id']][0];
     $vignette = "vignette-".$annonce->id."-".$num_pho.".P.jpg?v=".(time()*1000);
     $lannonce = strtolower(trim($this->formatStr($annonce->titre)));
     $lannonce.= ".html";
     //$result.="<div class='bas_annonce'>Location annonce n° ".$annonce->id." . <a href='".$url."detail/".$annonce->id."-".$lannonce."'><b>Consultez le détail de la location</b></a></div>";
 	$img='<img title="'.$lieugeo[$annonce->lieugeo_id].":".$annonce->titre.'" alt="'.$lieugeo[$annonce->lieugeo_id].":".$annonce->titre.'" src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'"  class="image_annonce">';

  if($annonce['nb_etoiles']==5){$immmg="5stars";}
  else if($annonce['nb_etoiles']==4){$immmg="4stars";}
  else if($annonce['nb_etoiles']==3){$immmg="3stars";}
  else if($annonce['nb_etoiles']==2){$immmg="2stars";}
    else if($annonce['nb_etoiles']==1){$immmg="1star";}
  else {
    if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0) $immmg="wifi";
    else $immmg="alpissimeicon";
  }

     $img1='<img src="'.$url.'images/ico/'.$immmg.'.png" alt="stars" class="product-etat">';
     $result.= "<div class='row'>";
     $result.= "<div class='col-md-3'>";
     $result.= "<div class='image-list'>";
 	  $result.= "<div class='featured-image'>";
 	  $result.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."'>".$img." ".$img1;
     $result.= "</a>";
     $result.= "</div>"; // featured-image
     $result.= "</div>"; // image-list
     $result.= "</div>"; // end col-md-3
     $result.= "<div class='col-md-9 desc-list'>";// col-md-9 desc-list
     $result.= "<div class='row'>";
     $result.= "<div class='col-md-9 block parag_b'>";// col-md-9 block
     $result.= "<h2>".$annonce->titre."</h2>";
     $result.= "</div>";//end col-md-9 block
     $result.="<div class='col-md-3 block'>";//col-md-3 block
 	$result.="<h3>ANNONCE N°".$annonce->id."</h3>";
 	$result.="</div>";// end col-md-3 block
     $result.="</div>";// end row
     $result.=" <div style='display:none' class='row'>";//row details

     $result.="<div class='col-md-2 block'>";//col-md-2 block
 	$result.="<span class='fa fa-home fa-lg orange'></span>";
 	$result.="<b>".$annonce->pieces_nb."</b>";
 	$result.="</div>";//end col-md-2 block
 	$result.="<div class='col-md-2 block'>";//col-md-2 block
 	$result.="<span class='fa fa-user fa-lg orange'></span>";
 	$result.="<b>".$annonce->personnes_nb."</b>";
 	$result.="</div>";//end col-md-2 block
 	$result.="<div class='col-md-2 block'>";//col-md-2 block
     $result.="<span class='fa fa-arrows-alt fa-lg orange'></span>";
 	$result.="<b>".$annonce->surface."<sup>2</sup></b>";
     $result.="</div>";// end col-md-2 block
 	$result.="<div class='col-md-2 block'>";//col-md-2 block
 	$result.="<span class='fa fa-eye fa-lg orange'></span>";
     $result.="<b>".$vues[$annonce->vue]."</b>";
 	$result.="</div>";// end col-md-2 block
     $result.="</div>";//end row
     //$result.= "<td><h3>".$this->Html->link(strtoupper($annonce->titre),array(
     //"controller"=>"annonces","action"=>"view",$annonce->id."-".$lannonce),null,null,false)."</h3>";
     //$result.= "<p>";
     // if(array_key_exists($annonce->nature,$l_natures_location))
     //  $result.= "<b>Type : </b>".$l_natures_location[$annonce->nature]." , ";
 	//$result.= "<b>Pièces : </b>".$annonce->pieces_nb." , ";
 	//$result.= "<b>Nombre de personnes : </b>".$annonce->personnes_nb."<br>";
 	//$result.= $annonce->description;
 	//$result.= "</p>";
     $result.= "<div class='row'>";
     $result.= "<div class='col-md-9 block parag'><p>".str_ireplace(array("\r","\n",'\r','\n'),' ', $annonce->description)."</p></div><div class='col-md-3 block'><a href='".$url."detail/".$annonce['id']."-".$lannonce."'><button class='btn btn-success hvr-sweep-to-top' type='submit'>PLUS DE DETAILS</button></a></div></div>";
     $result.= "</div>"; // end row
     $result.= "</div>";
     $result.= "<hr>";
     return $result;
   }
public function vignette_mail($data,$l_distances,$server)
  {

    $annonce = $data["Annonce"];
    $laville = strtolower(str_replace(" ","-",trim($data["Lieugeo"]["name"])));
    $lannonce = strtolower(trim($this->formatStr($annonce["titre"])));
    $lannonce.= ".html";
    $vignette = "vignette-".$annonce['id']."-1.jpg";

    $formatSimple = "<table><tbody>";
    $formatSimple.= "<tr><td>";

    $formatSimple.= '<a href="http://'.$server.'/detail/'.$annonce['id'].'-'.$lannonce.'"><img src="'.$server.'/app/webroot/img/png/'.$vignette.'" alt=""/></a>';
    $formatSimple.= "</td>";
    $formatSimple.= "<td>";
	$formatSimple.= "Annonce n° ".$annonce['id']." .<br /><strong>";

     $formatSimple.= '<a  href="http://'.$server.'/detail/'.$annonce['id'].'-'.$lannonce.'">'.ucfirst(strtolower($annonce['titre'])).'</a>';
    $formatSimple.= "</strong><br>";
    $formatSimple.= "Location ".$laville."<br>";
    $formatSimple.= $this->getLib($annonce)."<br>";
    $formatSimple.= "Remontées : ".$l_distances[$annonce['kmstat_id']];
    $formatSimple.= "</td></tr></tbody></table>";
    return $formatSimple;
  }
  /**
   * Vignette grand format, page index
   * Utiliser pour mettre en valeur la dernière annonce saisie
   * @param enregistrement annonce
   */
  public function grande_vignette($data,$url=false)
  {
    $annonce = $data["Annonce"];

    $laville = strtolower(str_replace(" ","-",trim($data["Lieugeo"]["name"])));
    $lannonce = strtolower(str_replace(" ","-",trim($annonce["titre"])));
    $lannonce.= ".html";
    $vignette = "vignette-".$annonce['id']."-1.png";
	$img='<img title="'.$laville.':'.$annonce["titre"].'" alt="'.$laville.':'.$annonce["titre"].'" src="'.$url.'images_ann/'.$annonce['id'].'/'.$vignette.'">';
    $grande_vignette = "<table><tr>";
    $grande_vignette.= "<tr><td>";
	$grande_vignette.= "<a href='$url/detail/".$annonce['id']."-".$lannonce."'>$img</a>";

    $grande_vignette.= "</td>";
    $grande_vignette.= "<td><h3>";
    $grande_vignette.= $this->Html->link(ucfirst(strtolower($annonce['titre'])),array(
                            "controller"=>"annonces","action"=>"view",$annonce['id']."-".$lannonce));
    $grande_vignette.= "</td>";
    $grande_vignette.= "</tr></table>";
    return $grande_vignette;
  }

  /**
   * Vignette grande taille
   * VIEW rececherche Annonce
   * @param enregistrement annonce
   * @param enregistrement lieu géographique correspondant
   * @param liste des natures de logement
   * @param liste des lieux géographiques
   */
   public function vignette_recherche($annonce,$lieugeo,$l_natures_location,$url=false,$photo)
   {
 	//print_r($annonce);
     if($annonce->pieces_nb==99)$annonce->pieces_nb=" plus que 5";
	 $num_pho = $photo[$annonce['id']][0];
     $vignette = "vignette-".$annonce->id."-".$num_pho.".P.jpg?v=".(time()*1000);
     $lannonce = strtolower(trim($this->formatStr($annonce->titre)));
     $lannonce.= ".html";
     $vues=array('1'=>__('Vallée'),'2'=>__('Pistes'),'3'=>__('Station'),'4'=>__('Autre'));
 	   $img='<img title="'.$lieugeo[$annonce->lieugeo_id].":".$annonce->titre.'" alt="'.$lieugeo[$annonce->lieugeo_id].":".$annonce->titre.'" src="'.$url.'images_ann/'.$annonce->id.'/'.$vignette.'"  class="image_annonce">';

     if($annonce['nb_etoiles']==5){$immmg="5stars";}
     else if($annonce['nb_etoiles']==4){$immmg="4stars";}
     else if($annonce['nb_etoiles']==3){$immmg="3stars";}
     else if($annonce['nb_etoiles']==2){$immmg="2stars";}
    else if($annonce['nb_etoiles']==1){$immmg="1star";}
     else {
       if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0) $immmg="wifi";
       else $immmg="alpissimeicon";
     }

     $img1='<img src="'.$url.'webroot/images/ico/'.$immmg.'.png" alt="5 stars" class="product-etat">';
     $result.= "<div class='row'>";
     $result.= "<div class='col-md-3'>";
     $result.= "<div class='image-list'>";
 	$result.= "<div class='featured-image'>";
 	$result.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."'>".$img." ".$img1;
     $result.= "</a>";
     $result.= "</div>"; // featured-image
     $result.= "</div>"; // image-list
     $result.= "</div>"; // end col-md-3
     $result.= "<div class='col-md-9 desc-list'>";// col-md-9 desc-list
     $result.= "<div class='row'>";
     $result.= "<div class='col-md-9 block parag_b'>";// col-md-9 block
     $result.= "<h2>".$annonce->titre."</h2>";
     $result.= "</div>";//end col-md-9 block
     $result.="<div class='col-md-3 block'>";//col-md-3 block
 	$result.="<h3>ANNONCE N°".$annonce->id."</h3>";
 	$result.="</div>";// end col-md-3 block
     $result.="</div>";// end row
     $result.=" <div style='display:none' class='row'>";//row détails
 	/*$result.="<div class='col-md-3 block''>";//col-md-3 block
 	$result.="<span class='orange'>05/08/2016 : </span>";
     $result.="<b>300.000€</b>";
 	$result.="</div>";//end col-md-3 block*/
  $result.="<div class='col-md-2 block'>";//col-md-2 block
 	$result.="<span class='fa fa-home fa-lg orange'></span>";
 	$result.="<b>".$annonce->pieces_nb."</b>";
 	$result.="</div>";//end col-md-3 block
 	$result.="<div class='col-md-2 block'>";//col-md-2 block
 	$result.="<span class='fa fa-user fa-lg orange'></span>";
 	$result.="<b>".$annonce->personnes_nb."</b>";
 	$result.="</div>";//end col-md-2 block
 	$result.="<div class='col-md-2 block'>";//col-md-2 block
     $result.="<span class='fa fa-arrows-alt fa-lg orange'></span>";
 	$result.="<b>".$annonce->surface." m<sup>2</sup></b>";
     $result.="</div>";// end col-md-2 block
 	$result.="<div class='col-md-2 block'>";//col-md-2 block
 	$result.="<span class='fa fa-eye fa-lg orange'></span>";
     $result.="<b>".$vues[$annonce->vue]."</b>";
 	$result.="</div>";// end col-md-2 block
     $result.="</div>";//end row
     //$result.= "<td><h3>".$this->Html->link(strtoupper($annonce->titre),array(
     //"controller"=>"annonces","action"=>"view",$annonce->id."-".$lannonce),null,null,false)."</h3>";
     //$result.= "<p>";
     // if(array_key_exists($annonce->nature,$l_natures_location))
     //  $result.= "<b>Type : </b>".$l_natures_location[$annonce->nature]." , ";
 	//$result.= "<b>Pièces : </b>".$annonce->pieces_nb." , ";
 	//$result.= "<b>Nombre de personnes : </b>".$annonce->personnes_nb."<br>";
 	//$result.= $annonce->description;
 	//$result.= "</p>";
     $result.= "<div class='row'>";
     $result.= "<div class='col-md-9 block parag'><p>".$annonce->description."</p></div><div class='col-md-3 block'><a href='".$url."detail/".$annonce['id']."-".$lannonce."' class='btn btn-success hvr-sweep-to-top ' >PLUS DE DETAILS</a></div></div>";
     $result.= "</div>"; // end row
     $result.= "</div>";
     $result.= "<hr>";
     return $result;
   }

    public function vignette_previsualiser($annonce,$lieugeo,$l_natures_location,$url=false,$photo)
   {
 	//print_r($annonce);
     if($annonce->pieces_nb==99)$annonce->pieces_nb=" plus que 5";
	 $num_pho = $photo[$annonce['id']][0];
     $vignette = "vignette-".$annonce->id."-".$num_pho.".P.jpg?v=".(time()*1000);
     $lannonce = strtolower(trim($this->formatStr($annonce->titre)));
     $lannonce.= ".html";
     $vues=array('1'=>__('Vallée'),'2'=>__('Pistes'),'3'=>__('Station'),'4'=>__('Autre'));
 	   $img='<img title="'.$lieugeo[$annonce->lieugeo_id].":".$annonce->titre.'" alt="'.$lieugeo[$annonce->lieugeo_id].":".$annonce->titre.'" src="'.$url.'images_ann/'.$annonce->id.'/'.$vignette.'"  class="image_annonce img-fluid">';

     if($annonce['nb_etoiles']==5){$immmg="5stars";}
     else if($annonce['nb_etoiles']==4){$immmg="4stars";}
     else if($annonce['nb_etoiles']==3){$immmg="3stars";}
     else if($annonce['nb_etoiles']==2){$immmg="2stars";}
    else if($annonce['nb_etoiles']==1){$immmg="1star";}
     else {
       if($annonce['wifi_appartment'] > 0||$annonce['wifi_payant'] > 0) $immmg="wifi";
       else $immmg="alpissimeicon";
     }

     $img1='<img src="'.$url.'webroot/images/ico/'.$immmg.'.png" alt="5 stars" class="product-etat">';
     $result.= "<div class='row my-3'><div class='col-md-12'><div class='row border mx-0'>";
     $result.= "<div class='col-lg-4 p-0'>";
     $result.= "<div class='image-list'>";
     
    $result.= "<div class='featured-image landing_img'>";
    if($annonce['statut'] != 0){
      $result.= "<a href='".$url."detail/".$annonce['id']."-".$lannonce."'>".$img." ".$img1;
      $result.= "</a>";
     }else{
      $result.= $img." ".$img1;
     }
     $result.= "</div>"; // featured-image
     $result.= "</div>"; // image-list
     $result.= "</div>"; // end col-md-4
     $result.= "<div class='col-lg-8 my-3 align-self-center desc-list'>";// col-md-9 desc-list
     $result.= "<div class='row justify-content-between'>";
     $result.= "<div class='col block parag_b'>";// col-md-9 block
     $result.= "<h2>".$annonce['lieugeo']['name']." - ".$l_natures_location[$annonce->nature]." - ".$annonce->personnes_nb." Personnes</h2>";
     $result.= "</div>";//end col-md-9 block
     $result.="<div class='col-auto block'>";//col-md-3 block
 	   //$result.="<a href='".$url."viewprev/".$annonce['id']."' target='_blanck' class='btn text-white bg-orange px-4 py-0 ' ><span class=''>ANNONCE N°".$annonce->id."</span></a>";
    $result.="<span class='btn text-white bg-orange cursor-auto px-4 py-0'>".__('Annonce N°')." ".$annonce->id."</span>";
    $result.="</div>";// end col-auto block
     $result.="</div>";// end row
     $result.=" <div style='display:none' class='row'>";//row détails
 	/*$result.="<div class='col-md-3 block''>";//col-md-3 block
 	$result.="<span class='orange'>05/08/2016 : </span>";
     $result.="<b>300.000€</b>";
 	$result.="</div>";//end col-md-3 block*/
  $result.="<div class='col-md-2 block'>";//col-md-2 block
 	$result.="<span class='fa fa-home fa-lg orange'></span>";
 	$result.="<b>".$annonce->pieces_nb."</b>";
 	$result.="</div>";//end col-md-3 block
 	$result.="<div class='col-md-2 block'>";//col-md-2 block
 	$result.="<span class='fa fa-user fa-lg orange'></span>";
 	$result.="<b>".$annonce->personnes_nb."</b>";
 	$result.="</div>";//end col-md-2 block
 	$result.="<div class='col-md-2 block'>";//col-md-2 block
     $result.="<span class='fa fa-arrows-alt fa-lg orange'></span>";
 	$result.="<b>".$annonce->surface." m<sup>2</sup></b>";
     $result.="</div>";// end col-md-2 block
 	$result.="<div class='col-md-2 block'>";//col-md-2 block
 	$result.="<span class='fa fa-eye fa-lg orange'></span>";
     $result.="<b>".$vues[$annonce->vue]."</b>";
 	$result.="</div>";// end col-md-2 block
     $result.="</div>";//end row
     //$result.= "<td><h3>".$this->Html->link(strtoupper($annonce->titre),array(
     //"controller"=>"annonces","action"=>"view",$annonce->id."-".$lannonce),null,null,false)."</h3>";
     //$result.= "<p>";
     // if(array_key_exists($annonce->nature,$l_natures_location))
     //  $result.= "<b>Type : </b>".$l_natures_location[$annonce->nature]." , ";
 	//$result.= "<b>Pièces : </b>".$annonce->pieces_nb." , ";
 	//$result.= "<b>Nombre de personnes : </b>".$annonce->personnes_nb."<br>";
 	//$result.= $annonce->description;
 	//$result.= "</p>";
     $result.= "<div class='row'>";
     $result.= "<div class='col-md-12 block parag'><h1 class='mt-3'>".$annonce->titre."</h1><p class='line-clamp-2ligne mt-3'>".$annonce->description."</p></div>";
     $result.= "</div>"; // end row
     $result.= "</div></div></div></div>";
     
     return $result;
   }




  /**
   * Vignette grande taille
   * VIEW rececherche Annonce
   * @param enregistrement annonce
   * @param enregistrement lieu géographique correspondant
   * @param liste des natures de logement
   * @param liste des lieux géographiques
   */
  public function vignette_recherche_avec_dispo($annonce,$lieugeo,$l_natures_location,$url=false)
  {
	/*echo "<pre>";
	print_r($annonce['Annonces']->id);
	echo "</pre>";*/
      if($annonce->pieces_nb==99)$annonce->pieces_nb=" plus que 5";
    $vignette = "vignette-".$annonce->id."-1.jpg";
    $lannonce = strtolower(trim($this->formatStr(htmlspecialchars(html_entity_decode($annonce->titre)))));
    $lannonce.= ".html";
    $result.="<div class='bas_annonce'>Location annonce n° ".$annonce->id." . <a href='$url/detail/".$annonce->id."-".$lannonce."'><b>Consultez le détail de la location</b></a></div>";
	$img='<img title="'.$lieugeo[$annonce->lieugeo_id].":".htmlspecialchars(html_entity_decode($annonce->titre)).'" alt="'.$lieugeo[$annonce->lieugeo_id].":".htmlspecialchars(html_entity_decode($annonce->titre)).'" src="'.$url.'images_ann/'.$annonce->id.'/'.$vignette.'" width="120" height="90">';
    $result.= "<div id='annonce'>";
    $result.= "<div class='bas_annonce'>Localisation du bien : ".$lieugeo[$annonce->lieugeo_id]."</div>";
	$result.= "<table><tr><td><a href='$url/detail/".$annonce->id."-".$lannonce."'>$img</a></td>";
    $result.= "<td><h3>".$this->Html->link(strtoupper(htmlspecialchars(html_entity_decode($annonce->titre))),array(
                            "controller"=>"annonces","action"=>"view",$annonce->id."-".$lannonce),null,null,false)."</h3>";
    $result.= "<p>";
    if(array_key_exists($annonce->nature,$l_natures_location))
        $result.= "<b>Type : </b>".$l_natures_location[$annonce->nature]." , ";
		$result.= "<b>Pièces : </b>".$annonce->pieces_nb." , ";
		$result.= "<b>Nombre de personnes : </b>".$annonce->personnes_nb."<br>";
		$result.= htmlspecialchars(html_entity_decode($annonce->description));
		$result.= "</p>";
		$result.= "</td></tr></table>";
        $result.= "</div>";
    return $result;
  }
  public function lien($annonce,$url=false)
  {
	$lannonce = strtolower(trim($this->formatStr($annonce["titre"])));
    $lannonce.= ".html";
    $lib = "<b>Location Les Arcs</b><br>".$this->getLib($annonce);
    $lien = "<li><a href='$url/detail/".$annonce['id']."-".$lannonce."'>$lib</a></li>";
	return $lien;
  }

  private function getLib($annonce)
  {
      if($annonce->pieces_nb==99)$annonce->pieces_nb=" plus que 5";
    static $ar = array("STD"=>"Studio","APP"=>"Appart.","CHA"=>"Chalet","DIV"=>"Location","VIL"=>"Villa","GIT"=>"Gîte");

    $getLib="";
    if (array_key_exists($annonce->nature,$ar))
        $getLib = $ar[$annonce->nature];
    // if ($annonce->nature!="STD")
    //     $getLib.= " ".$annonce->pieces_nb." pièces";
    $getLib.= " ".$annonce->personnes_nb." personnes";
    return $getLib;
  }

  private function getLib2($annonce)
  {
      if($annonce->pieces_nb==99)$annonce['pieces_nb']=" plus que 5";
    static $ar = array("STD"=>"Studio","APP"=>"Appart.","CHA"=>"Chalet","DIV"=>"Location","VIL"=>"Villa","GIT"=>"Gîte");

    $getLib="";
    if (array_key_exists($annonce['nature'],$ar))
        $getLib = $ar[$annonce['nature']];
    // if ($annonce->nature!="STD")
    //     $getLib.= " ".$annonce->pieces_nb." pièces";
    $getLib.= " ".$annonce['personnes_nb']." personnes";
    return $getLib;
  }

  public function formatStr($titre)
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

  private function getNomVignette($vignette)
  {
	global $_SERVER;
	$path = $_SERVER['DOCUMENT_ROOT'].$this->base."/app/webroot/img/png/";
	if (file_exists($path.$vignette))
		$result = "1/vignette-39-9.png";
	else
		$result = "default.jpg";
	return $result;
  }
}
?>