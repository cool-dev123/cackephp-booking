<?php $this->append('cssTopBlock', '<style>
h2.h1 {
    font-size: 25px;
}
.rechercheLanding {
    margin-right: 7% !important;
    margin-left: 7% !important;
    border-radius: 15px !important;
}
.imageheaderstation {
    border-radius: 20px;
    object-fit: cover;
}
.logotop {
    position: absolute;
    width: 20%;
    top: 35px;
    left: 2%;
}
.logotoprounded{
    border-radius: 10px;
}
.logobottom {
    position: absolute;
    bottom: 0;
    width: 35%;
}
.h1station {
    background: #0099ff;
    color: white;
    line-height: 2;
    -webkit-box-decoration-break: clone;
    -o-box-decoration-break: clone;
    box-decoration-break: clone;
}
.carreGris {
    background: #eeeeee;
    font-size: 15px;
    font-weight: bold;
}
.colorblue {
    color: #0099ff;
    border-color: #0099ff!important;
}
.card {
    height: 100%;
}
.smalllineheight{
    line-height: 1;
}
.alert.alert-success {
    background: #62b997;
    color: white;
    border-radius: 15px;
    text-align: center;
    font-size: 20px;
}
.nolinkcolor, .nolinkcolor:hover {
    color: #212529;
    font-size: 13px;
}
#partners {
    height: 150px;
}
.pisteCircle::before{
    content: "";
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 50%;
}
.success::before{
    background-color: #28a745;
}
.primary::before{
    background-color: #007bff;
}
.danger::before{
    background-color: red;
}
.dark::before{
    background-color: black;
}
.sizebigger{
    font-siez: 16px;
}
#magazine .thumbnail img {
    min-height: 200px;
}
.minheightimg{
    min-height: 380px;
}
@media screen and (max-width: 991px) {
    .paddingMap{
        padding: 0px 10px 0px 10px;
    } 
    .domaineSki{
        margin: 0px -7px 0px -7px;
    }

    .imageheaderstation {
        border-radius: 0px;
    }
    .pt-0.pt-md-4.h-100 {
        min-height: 250px;
    }
    .logobottom {
        width: 25%;
    }
    h1 {
        position: absolute;
        top: -235px;
    }
    .stationpage .rechercheLanding {
        margin-top: -5em!important;
    }
    .alert.alert-success {
        font-size: 12px;
        padding: 0px;
    }
} 
</style>'); ?>

<?php $this->Html->css("/css/item-quantity-dropdown.min.css", array('block' => 'cssTop')); ?>

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
<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<?php if(in_array(date("m"),array('05','06','07','08'))){
    $this->assign('title', __("Alpissime.com | Location à {0} - Vacances Eté", [$station->name]));
    $this->Html->meta(null, null, ['name' => 'title','content' => __("Alpissime.com | Location à {0} - Vacances Eté", [$station->name]) ,'block' => 'meta']);
    $this->Html->meta(null, null, ['property' => 'og:title','content' =>  __("Alpissime.com | Location à {0} - Vacances Eté", [$station->name]) ,'block' => 'meta']);
    $this->Html->meta(null, null, ['name' => 'description','content' => __("Réservez votre Location de Vacances Été à {0}.  Annonces vérifiées - Paiement 4x sans frais", [$station->name]) ,'block' => 'meta']);
    $this->Html->meta(null, null, ['property' => 'og:description','content' => __("Réservez votre Location de Vacances Été à {0}.  Annonces vérifiées - Paiement 4x sans frais", [$station->name]) ,'block' => 'meta']);
}else{ 
    $this->assign('title', __("Alpissime.com | Location à {0} - Séjour Ski", [$station->name]));
    $this->Html->meta(null, null, ['name' => 'title','content' => __("Alpissime.com | Location à {0} - Séjour Ski", [$station->name]) ,'block' => 'meta']);
    $this->Html->meta(null, null, ['property' => 'og:title','content' =>  __("Alpissime.com | Location à {0} - Séjour Ski", [$station->name]) ,'block' => 'meta']);
    $this->Html->meta(null, null, ['name' => 'description','content' => __("Séjour ski : Location appartement  ou chalet à {0}. Annonces vérifiées, Réductions Skis, Cours & Forfaits, paiement 4x sans frais", [$station->name]) ,'block' => 'meta']);
    $this->Html->meta(null, null, ['property' => 'og:description','content' => __("Séjour ski : Location appartement  ou chalet à {0}. Annonces vérifiées, Réductions Skis, Cours & Forfaits, paiement 4x sans frais", [$station->name]) ,'block' => 'meta']);
} ?>

<!--Slide-->
<?php krsort($listevillages); ?>
<div class="container">
    <div class="row justify-content-start">
        <div class="col-lg-6 p-0 minheightimg">
            <?php if($station->image != ''){ ?>
                <div class="logotop d-none d-lg-block">
                    <picture>
                        <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.webp" type="image/webp">
                        <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.png" type="image/png">
                        <img class="logotoprounded" alt="Partenaire <?php echo $station->name;?>" src="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.png"/>
                    </picture>
                </div>
            <?php } ?>
            <div class="pt-0 pt-md-4 h-100">
            <?php if(in_array(date("m"),array('05','06','07','08'))){
                    if($station->image_header_ete != '') $mediaheaderimage = $station->image_header_ete;  
                ?>
                    <img alt="<?php echo $mediaheaderimage; ?>" class="img-fluid imageheaderstation h-100" src="<?php echo $this->Url->build('/')."images/header_station/".$mediaheaderimage;?>" >
                    <?php $this->Html->meta(null, null, ['property' => 'og:image','content' => $this->Url->build('/')."images/header_station/".$mediaheaderimage,'block' => 'meta']); ?>
            <?php }else{ 
                if($station->image_header_hiver != '') $mediaheaderimagehiver = $station->image_header_hiver;  
                ?>
                    <img alt="<?php echo $mediaheaderimagehiver; ?>" class="img-fluid imageheaderstation h-100" src="<?php echo $this->Url->build('/')."images/header_station/".$mediaheaderimagehiver;?>" >
                    <?php $this->Html->meta(null, null, ['property' => 'og:image','content' => $this->Url->build('/')."images/header_station/".$mediaheaderimagehiver,'block' => 'meta']); ?>
            <?php } ?>                          
            </div>
            <div class="logobottom">
                <img class="imageheaderstation" alt="Partenaire <?php echo $station->name;?>" src="<?php echo $this->Url->build('/',true)?>images/ico/Coin.png"/>
            </div>
            
        </div>
        <div class="col-lg-6">
            <h1 class="mt-5"><span class="h1station p-2"><?= __("Locations de vacances") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->preposition_a; else echo $station->_translations[$this->Session->read('Config.language')]->preposition_a; ?> <?php echo $station->name; ?></span></h1>            
            <div id="shrinkMe" class="shrinkable d-none d-lg-block">
                <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->descreption; else echo $station->_translations[$this->Session->read('Config.language')]->descreption; ?>
            </div>
            <div class="row pl-3 mb-5 d-none d-lg-flex">
                <?php if(count($listevillages) >= 2) {foreach ($listevillages as $key ) {  foreach ($key as $value) { ?>
                    <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
                        <a class="nolinkcolor" href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=<?php echo $station->id; ?>&village=<?php echo $value->id; ?>"><?php echo __("Location à {0}", [$value->name]); ?></a>
                    </div>
                <?php } } } ?>                
            </div>
            <div class="row mb-3"></div>
        </div>
    </div>
</div>							
<!--End Slide-->
<div class="container stationpage p-0">
    <?php echo $this->element("menu_recherche_station")?>
</div>
<div class="container mt-5 d-block d-lg-none">
    <div id="shrinkMe" class="shrinkable">
        <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->descreption; else echo $station->_translations[$this->Session->read('Config.language')]->descreption; ?>
    </div>
    <div class="row pl-3 mb-5">
        <?php if(count($listevillages) >= 2) {foreach ($listevillages as $key ) {  foreach ($key as $value) { ?>
            <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
                <a class="nolinkcolor" href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=<?php echo $station->id; ?>&village=<?php echo $value->id; ?>"><?php echo __("Location à {0}", [$value->name]); ?></a>
            </div>
        <?php } } } ?>                
    </div>
</div>
<section class="mt-4 d-none d-md-block">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-auto font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
                <?= __("En images"); ?>
            </div>
            <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
                <a class="nolinkcolor" href="<?php echo $this->Url->build('/',true).$urlLang; ?>webcam/<?php echo $nom_get; ?>"><?php echo __("Webcam")." ".$station->name; ?></a>
            </div>
            <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
                <a class="nolinkcolor" href="<?php echo $this->Url->build('/',true).$urlLang; ?>galery/<?php echo $nom_get; ?>"><?php echo __("Photos")." ".$station->name; ?></a>
            </div>
        </div>        
    </div>
</section>
<?php if($annonces->count() > 2) { ?>
<section class="mt-4">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-2 ">
                <h2 class="h1"><?= __("Toutes les locations de vacances") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->preposition_a; else echo $station->_translations[$this->Session->read('Config.language')]->preposition_a; ?> <?php echo $station->name; ?></h2>
            </div>
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-center d-none d-md-block">
                <a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=<?php echo $station->id; ?>" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
		</div>
        <div class="annonce block products row">

        <?php $annonceliste = $annonces; $c=0; foreach($annonceliste as $ann) { ?>
          <div class="col-6 col-sm-6 col-md-3" style="margin-bottom:10px">
            <div class="featured-product">
              <?php
              echo $this->element('petite_annonce', array('annonce'=>$ann, 'photo'=>$photos, 'residence'=>$residence, 'minprixannonce'=>$minprixannonce, 'noteglobalmoy'=>$noteglobalmoytab) );
              ?>
            </div>
          </div>
            <?php
            }
            ?>
        </div>
        <div class="row d-block d-md-none">
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-right sizebigger">
                <a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=<?php echo $station->id; ?>" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
        </div>
              
	</div>
</section>
<?php } ?>
<div class="container d-block d-md-none">
    <div class="row">
        <div class="col-sm-12 col-md-4 mb-5">
            <div class="shadow px-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="col-2 p-0 mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                    <img width="100" src="<?php echo $this->Url->build('/')?>images/ico/location-de-vacances-entre-particulier-station-de-ski-savoie.png" class="img-responsive">
                </div>
                <div><?= __("Alpissime est une plateforme française créée en Savoie en 2006. C'est également l'un des premiers services de conciergerie à la montagne.") ?></div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php $listeappartement = $annoncesappartement;
if($listeappartement->count() > 2) {
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-2 ">
                <h2 class="h1"><?= __("Location d'appartement") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->preposition_a; else echo $station->_translations[$this->Session->read('Config.language')]->preposition_a; ?> <?php echo $station->name; ?></h2>
            </div>
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-center d-none d-md-block">
                <a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=<?php echo $station->id; ?>&app=1" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
		</div>
        <div class="annonce block products row">

        <?php $c=0; foreach($listeappartement as $annappart) { ?>
          <div class="col-6 col-sm-6 col-md-3" style="margin-bottom:10px">
            <div class="featured-product">
              <?php
              echo $this->element('petite_annonce', array('annonce'=>$annappart, 'photo'=>$photos, 'residence'=>$residence, 'minprixannonce'=>$minprixannonce, 'noteglobalmoy'=>$noteglobalmoytab) );
              ?>
            </div>
          </div>
            <?php
            }
            ?>
        </div>
        <div class="row d-block d-md-none">
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-right sizebigger">
                <a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=<?php echo $station->id; ?>&app=1" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
        </div>
              
	</div>
</section>
<?php } ?>
<div class="container d-block d-md-none">
    <div class="row">
        <div class="col-sm-12 col-md-4 mb-5">
            <div class="shadow px-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                    <img width="100" src="<?php echo $this->Url->build('/')?>images/ico/annonces-de-particuliers-verifiees.png" class="img-responsive">
                </div>
                <div><?= __("Toutes les annonces présentes sur Alpissime ont été vérifiées manuellement par notre équipe.") ?></div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php $listechalet = $annonceschalet;
if($listechalet->count() > 2) {
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-2 ">
                <h2 class="h1"><?= __("Location de chalet") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->preposition_a; else echo $station->_translations[$this->Session->read('Config.language')]->preposition_a; ?> <?php echo $station->name; ?></h2>
            </div>
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-center d-none d-md-block">
                <a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=<?php echo $station->id; ?>&cha=1" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
		</div>
        <div class="annonce block products row">

        <?php $c=0; foreach($listechalet as $annchalet) { ?>
          <div class="col-6 col-sm-6 col-md-3" style="margin-bottom:10px">
            <div class="featured-product">
              <?php
              echo $this->element('petite_annonce', array('annonce'=>$annchalet, 'photo'=>$photos, 'residence'=>$residence, 'minprixannonce'=>$minprixannonce, 'noteglobalmoy'=>$noteglobalmoytab) );
              ?>
            </div>
          </div>
            <?php
            }
            ?>
        </div>
        <div class="row d-block d-md-none">
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-right sizebigger">
                <a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=<?php echo $station->id; ?>&cha=1" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
        </div>
              
	</div>
</section>
<?php } ?>
<!-- Section Infos -->
<div class="container mt-0 mt-md-4">
    <div class="row">
        <div class="col-sm-12 col-md-4 mb-5 d-none d-md-block">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                    <img width="100" src="<?php echo $this->Url->build('/')?>images/ico/location-de-vacances-entre-particulier-station-de-ski-savoie.png" class="img-responsive">
                </div>
                <div><?= __("Plateforme française créée en Savoie en 2006") ?></div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-5 d-none d-md-block">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                    <img width="100" src="<?php echo $this->Url->build('/')?>images/ico/annonces-de-particuliers-verifiees.png" class="img-responsive">
                </div>
                <div><?= __("100% des annonces vérifiées manuellement") ?></div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-5">
            <div class="shadow px-3 py-0 py-md-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0">
                    <img width="100" src="<?php echo $this->Url->build('/')?>images/ico/service-client.png" class="img-responsive">
                </div>
                <div class="container d-block d-md-none"><?= __("Besoin d'assistance lors de votre réservation ? Posez-nous votre question par livechat !") ?></div>
                <div class="container d-none d-md-block"><?= __("Service client en direct par livechat et mail") ?></div>
            </div>
            </div>
        </div>    
    </div>
</div>
<!-- End Section Infos -->
<!--begin services section -->
<section id="services_prop" class="bg-light py-5">
    <div class="container">
        <div class="row pl-0">
			<!-- <div class="col-md-12 "> -->
				<h2 class="h1 col-sm-12 col-md-9 m-0 mb-2"><?= __("Découvrez la station") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->article_de; else echo $station->_translations[$this->Session->read('Config.language')]->article_de; ?> <?php echo $station->name; ?></h2>
                <?php if($date_station->first()){
                    $date_station = $date_station->first(); ?>
                    <div class="col-sm-12 col-md-3 font-size-small text-center font-weight-bold px-2">
                        <div class="border rounded colorblue px-1 py-2">
                            <?= __("OUVERTURE") ?> : <?= __("DU") ?> <?php echo $date_station->ouverture->i18nFormat('dd/MM/yy'); ?> <?= __("AU") ?> <?php echo $date_station->fermeture->i18nFormat('dd/MM/yy'); ?>
                        </div>
                    </div>
                <?php } ?>
                
			<!-- </div> -->
		</div>       
        <div class="row paddingMap">
            <div id="mapdiv" class="col-md-12 maprelative px-0 mt-4 shadow rounded">
                <div id="map" style="width:100%; height:100%" class="rounded"></div>
            </div>
        </div>
        <div class="row mt-3 p-3 bg-white shadow rounded domaineSki">
            <div class="col-md-12 p-3 h-100">
                <h3><?= __("Domaine skiable") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->article_de; else echo $station->_translations[$this->Session->read('Config.language')]->article_de; ?> <?php echo $station->name; ?> :</h3>
            </div>
            <div class="col-md-3"><?= __("Domaine") ?> : <span class="font-weight-bold"><?php echo $remonteMecanique->nom; ?></span></div>
            <div class="col-md-3"><?= __("Altitude basse") ?> : <span class="font-weight-bold"><?php echo $station->ALT_BAS; ?>m</span></div>
            <div class="col-md-3"><?= __("Altitude haute") ?> : <span class="font-weight-bold"><?php echo $station->ALT_HAUT; ?>m</span></div>
            <div class="col-md-3"><?= __("Km de pistes") ?> : <span class="font-weight-bold"><?php echo $remonteMecanique->km_pistes; ?></span></div>
            
            <div class="col-md-3 mt-3">
                <div class="d-flex">
                    <span class="pisteCircle success mr-1"></span><?= __("Pistes vertes") ?> : <span class="font-weight-bold"><?php echo $remonteMecanique->nbrpistes_verte; ?></span>
                </div>
            </div>
            <div class="col-md-3 mt-3">
                <div class="d-flex">
                    <span class="pisteCircle primary mr-1"></span><?= __("Pistes bleues") ?> : <span class="font-weight-bold"><?php echo $remonteMecanique->nbrpistes_bleu; ?></span>
                </div>
            </div>
            <div class="col-md-3 mt-3">
                <div class="d-flex">
                    <span class="pisteCircle danger mr-1"></span><?= __("Pistes rouges") ?> : <span class="font-weight-bold"><?php echo $remonteMecanique->nbrpistes_rouge; ?></span>
                </div>
            </div>
            <div class="col-md-3 mt-3">
                <div class="d-flex">
                    <span class="pisteCircle dark mr-1"></span><?= __("Pistes noires") ?> : <span class="font-weight-bold"><?php echo $remonteMecanique->nbrpistes_noir; ?></span>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4 pl-0 pr-2 pr-lg-1 pl-2 pl-lg-0 pl-md-0 mb-2 mb-lg-0 mb-md-0"> 
                <div class="card bg-white shadow rounded border-0">
                    <div class="card-body">
                        <h3><?= __("Informations pratiques") ?> :</h3>
                        <p>
                            <?= __("Office(s) de tourisme") ?> : 
                            <ul>
                            <?php foreach ($offices as $office) {
                                echo "<li><a href='#office' class='officedetailcl' data-toggle='modal' data-id='".$office->id."' >".$office->nom."</a></li>";
                            } ?>
                            </ul>
                        </p>
                        <p><?= __("Plan des pistes") ?> : <a href='#plan_pistes' data-toggle='modal' data-target="#planPistes"><?= __("Voir le plan") ?></a> </p>
                    </div>
                </div>
            </div>

            <!-- Modal Office -->
            <div class="modal fade" id="officedetail" tabindex="-1" role="dialog" aria-labelledby="officedetail">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header px-5 pb-3 pt-4">
                            <span class="orange h1modal text-center"><h2 class="font-weight-bold"><?= __("Office de Tourisme") ?> : <span id="nomoffice"></span></h2></span>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
                        </div>
                        <div class="modal-body px-5 py-4">                              
                            <div class="row">
                                <div class="col-md-6">
                                    <h4><?= __("Adresse") ?></h4>
                                    <p><span id="adresseoffice"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <h4><?= __("Contact") ?></h4>
                                    <p><span id="contactoffice"></span></p>
                                </div>
                            </div>                          
                        </div> 
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- End Modal Office -->
            <!-- Modal Plan Pistes -->
            <div class="modal fade" id="planPistes" tabindex="-1" role="dialog" aria-labelledby="planPistes">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header p-3">
                            <span class="orange h1modal text-center"><h2 class="font-weight-bold"><?= __("Plan des pistes") ?></h2></span>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
                        </div>
                        <div class="modal-body p-1">                              
                            <div class="row">
                                <div class="col-md-12">
                                    <object data="<?php echo $station->plan_piste; ?>" type="application/pdf" width="100%" height="500"><span class="text-center"> <?= __("Le lien est inaccessible pour le moment. Merci de réessayer plus tard.") ?> </span></object>
                                </div>
                            </div>                          
                        </div> 
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- End Modal Plan Pistes -->
            <div class="mt-4 d-block d-md-none">
                <div class="container">
                    <div class="row">
                        <div class="col-auto font-weight-normal mr-2 mb-2 pl-3 pr-0 py-1 rounded">
                            <?= __("En images"); ?>
                        </div>
                        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 mx-3 py-1 rounded">
                            <a class="nolinkcolor" href="<?php echo $this->Url->build('/',true).$urlLang; ?>webcam/<?php echo $nom_get; ?>"><?php echo __("Webcam")." ".$station->name; ?></a>
                        </div>
                        <div class="col-auto carreGris font-weight-normal mr-2 mb-2 mx-3 py-1 rounded">
                            <a class="nolinkcolor" href="<?php echo $this->Url->build('/',true).$urlLang; ?>galery/<?php echo $nom_get; ?>"><?php echo __("Photos")." ".$station->name; ?></a>
                        </div>
                    </div>        
                </div>
            </div>
            <div class="col-md-8 pr-0 pl-2 pl-lg-1 pr-2 pr-md-0 pr-lg-0">
                <div class="card bg-white shadow rounded border-0">
                    <div class="card-body">
                        <h3><?= __("Accessibilité") ?> :</h3>
                        <p><?php if($this->Session->read('Config.language') == 'fr_FR') echo nl2br($station->description_acc);else echo nl2br($station->_translations[$this->Session->read('Config.language')]->description_acc); ?></p>
                    </div>
                </div>
            </div>
        </div>      
    </div>
</section>
<!--end services section -->
<!-- Section Infos -->
<div class="container my-5">
    <h2 class="h1"><?php echo __('Comment ça marche ?'); ?></h2>
    <div class="row">
        <div class="col-sm-12 col-md-4 mb-4">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                    <img width="100" src="<?php echo $this->Url->build('/')?>images/ico/location-vacances-ski.png" class="img-responsive">
                </div>
                <div class="smalllineheight"><h3 class="m-0 smalllineheight"><?= __("Trouvez la location de vacances idéale") ?></h3><small><?= __("Parmi les centaines d'annonces vérifiées par notre équipe.") ?></small></div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-4">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                    <img width="100" src="<?php echo $this->Url->build('/')?>images/ico/forfaits-cours-location-de-ski.png" class="img-responsive">
                </div>
                <div class="smalllineheight"><h3 class="m-0 smalllineheight"><?= __("Ajoutez des activités à prix réduit") ?></h3><small><?= __("Location, cours, forfaits de ski et bien plus encore.") ?></small></div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-4">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0">
                    <img width="100" src="<?php echo $this->Url->build('/')?>images/ico/paiement-securise-4-fois-sans-frais.png" class="img-responsive">
                </div>
                <div class="smalllineheight"><h3 class="m-0 smalllineheight"><?= __("Réglez jusqu'à 4x sans frais") ?></h3><small><?= __("Et profitez de votre séjour ski, tout simplement !") ?></small></div>
            </div>
            </div>
        </div>    
    </div>
    <div class="alert alert-success py-1 mt-1" role="alert">
        <i class="fa fa-check-circle fa-lg mr-3" aria-hidden="true"></i> <?= __("Votre séjour remboursé à 100% en cas de COVID-19") ?>
    </div>
</div>
<!-- End Section Infos -->
<?php $i=0; foreach ($listevillages as $vil) { foreach ($vil as $village) {
    $annvillage[$village->id] = $annvillage[$village->id]->limit(4);
// foreach ($annvillage as $annonceliste) {
    if($annvillage[$village->id]->count() > 2) { ?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3 pb-2 ">
                    <h2 class="h1"><?= __("Toutes les locations à") ?> <?php echo $village->name; ?></h2>
                </div>
                <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-center d-none d-md-block">
                    <a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=<?php echo $station->id; ?>&village=<?php echo $village->id; ?>" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
                </div>
            </div>
            <div class="annonce block products row">

            <?php $c=0; foreach($annvillage[$village->id] as $ann) { ?>
            <div class="col-6 col-sm-6 col-md-3" style="margin-bottom:10px">
                <div class="featured-product">
                <?php
                echo $this->element('petite_annonce', array('annonce'=>$ann, 'photo'=>$photos, 'residence'=>$residence, 'minprixannonce'=>$minprixannonce, 'noteglobalmoy'=>$noteglobalmoytab) );
                ?>
                </div>
            </div>
                <?php
                }
                ?>
            </div>
            <div class="row d-block d-md-none">
                <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-right sizebigger">
                    <a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=<?php echo $station->id; ?>&village=<?php echo $village->id; ?>" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
                </div>
            </div>
                
        </div>
    </section>
    <?php if(count($listeresidences[$village->id]) > 0){ ?>
        <div class="container mt-2">
            <h3><?php echo __("Locations à {0}", [$village->name])." ".__("par résidence"); ?></h3>
            <div class="row pl-3 mb-5">
            <?php foreach ($listeresidences[$village->id] as $residence) {
                if($residence->name_url != "") $nameurl = $residence->name_url;
                else $nameurl = str_replace(' ', '_', $residence->name);
                ?>
                    <div class="col-auto carreGris font-weight-normal mr-2 mb-2 px-3 py-1 rounded">
                        <a class="nolinkcolor" href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['station']; ?>/<?php echo $station->nom_url.'/residence-'.$nameurl; ?>"><?php echo $residence->name; ?></a>
                    </div>
            <?php } ?>
            </div>
        </div>
    <?php } ?>    
<?php }
$i++;
}
} ?>
<?php 
// Get the JSON
$json = file_get_contents('https://www.alpissime.com/blog/wp-json/wp/v2/posts?categories='.$station->input_blog.'&per_page=3');
// Convert the JSON to an array of posts
$posts = json_decode($json);
?>
<?php if(count($posts) > 0 && $language_header_name == "fr"){ ?>
<section id="magazine">
    <div class="container">
        <div class="row pt-4 pb-2">
            <div class="col-12 mt-3 pb-0 ">
                <h2 class="h1"><?= __("Pour préparer vos vacances") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->preposition_a; else echo $station->_translations[$this->Session->read('Config.language')]->preposition_a; ?> <?php echo $station->name; ?></h2>
            </div>
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-center d-none d-md-block">
                <a href="<?php echo BLOG_ALPISSIME ?>" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
		</div>
        <div class="row">
            <?php foreach ($posts as $p) { 
                $featured_media = $p->featured_media;
                $json_media = file_get_contents('https://www.alpissime.com/blog/wp-json/wp/v2/media/'.$featured_media);
                $media = json_decode($json_media);
                if($media->media_details->sizes->medium_large->source_url) $url_media = $media->media_details->sizes->medium_large->source_url;
                else if($media->media_details->sizes->medium->source_url) $url_media = $media->media_details->sizes->medium->source_url;
                else $url_media = $media->media_details->sizes->large->source_url;                
                ?>
            <div class="col-md-4 mb-5">
            <div class="shadow-sm border h-100">
            <a class="magazine-link" href="<?php echo $p->link ?>" target="blanc">
                <div class="thumbnail">
                    <img src="#" data-src="<?php echo $url_media; ?>">
                    <div class="caption p-4">
                        <h3><?php echo  $p->title->rendered;?></h3>
                        <?php echo  $p->excerpt->rendered;?>
                    </div>
                </div>
            </a>
            </div>
            </div>
            <?php }?>
        </div>
    </div>
</section>
<?php } ?>
<!-- End Section magazine -->
<!-- Section pourquoi alpissime -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
			<div class="col-md-12">
				<h2 class="h1 text-center"><?= __("Vos prochaines vacances") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->preposition_a; else echo $station->_translations[$this->Session->read('Config.language')]->preposition_a; ?> <?php echo $station->name; ?></h2>                
                <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->sous_description; else echo $station->_translations[$this->Session->read('Config.language')]->sous_description; ?>
			</div>           
		</div>
    </div>
</section>
<!-- End Section pourquoi alpissime -->
<!-- Section partners -->
<?php if($listePart->count() > 0){ ?>
<section id="partners" class="mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center text-md-left">
                <h2 class="title-newsletter pb-3"><?= __("Nos partenaires") ?></h2>
            </div>
			<div class="col-md-12">
                <div class="regular slider">                   
                    <?php foreach ($listePart as $parten) {
                        if($parten->image != ""){ ?>
                        <div >
                            <picture>
                                <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $parten->image; ?>.webp" type="image/webp">
                                <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $parten->image; ?>.png" type="image/png">
                                <img alt="Partenaire <?php echo $parten->raison_sociale; ?>" src="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $parten->image; ?>.png"/>
                            </picture>
                        </div>
                    <?php    }
                    } ?>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<!-- End Section partners -->


<!-- Modal -->
<div class="modal fade" id="readMoreModal" tabindex="-1" role="dialog" aria-labelledby="readMoreModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="readMoreModalLabel"><?= __("Description de la station"); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="readMoreModalBody">
        <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->descreption; else echo $station->_translations[$this->Session->read('Config.language')]->descreption; ?>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<?php if($this->Session->read('Config.language') == 'fr_FR') $stationdescription = $station->descreption; else $stationdescription = $station->_translations[$this->Session->read('Config.language')]->descreption; ?>

<?php $this->Html->script("/js/item-quantity-dropdown.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$('body').on('click',function(event){
    if(!$(event.target).is('.iqdropdown-selection') && !$(event.target).is('#animaux')){
      $(".iqdropdown").removeClass("menu-open")
    }
});
  
$('#animaux').change(function () {
    if($('#animaux').is(":checked")){
        $('#animaux').val(1);
    }else{
        $('#animaux').val(0);
    }
});

function showMore(id){    
    $("#readMoreModal").modal("show");     
}

var len = 350;
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
        }
    }
}

$(document).ready(function () {
    $("section.main").removeClass('py-5');

    $('.iqdropdown').iqDropdown({
        selectionText: '<?= __("Vacancier(s)"); ?>',
        textPlural: '<?= __("Vacancier(s)"); ?>',
        onChange: (id, count, totalItems) => {
            if(id == 'nbradulte'){
                $('#nbCouchage_ad').val(count); 
            } 
            if(id == 'nbrenfant'){
                $('#nbCouchage_enf').val(count);
            } 
        },
    });

    $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);

    $('#location_du').datepicker({
        language: 'fr-FR',
        minDate: 0,
        dateFormat: "dd-mm-yy"
    });
    $('#location_du').on( "change", function() {
          $('#location_du').datepicker( "option", "minDate", $.datepicker.parseDate( "dd-mm-yy", this.value ) );
          $('#location_au').datepicker( "option", "minDate", $.datepicker.parseDate( "dd-mm-yy", this.value ) );
        });
    $('#location_au').datepicker({
        language: 'fr-FR',
        minDate: 0,
        dateFormat: "dd-mm-yy"
    });
});

var markers = [];
var map;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: <?php echo $station->latitude?$station->latitude:45.5877732; ?>, lng: <?php echo $station->longitude?$station->longitude:6.82846816; ?>},
        zoom: 6,
    });
    
    latLng = new google.maps.LatLng(<?php echo $station->latitude?$station->latitude:45.5877732; ?>, <?php echo $station->longitude?$station->longitude:6.82846816; ?>);

    // Creating a marker and putting it on the map
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
    });

    markers.push(marker);

}
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&callback=initMap&language=".$language_header_name, array('block' => 'scriptBottom')); ?>