<style>
    .header_landing_page {
        background: url("<?php echo $this->Url->build('/'); ?>images/header-Savoie-Mont-Blanc-Montagne-Mon-Trip-Alpissime.jpg") no-repeat;
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

    .pagination ul li.active {
        background: #0096FF;
        padding: 6px 15px !important;
        border-radius: 5px !important;
    }
    .pagination ul li, #mes_annonces.mes_annonces .pagination .list-inline .last, #mes_annonces.mes_annonces .pagination .list-inline .first {
        background: #eeeeee;
        padding: 6px 15px !important;
        border-radius: 5px !important;
        margin: 0 2px;
    }
    .pagination ul li.active a {
        color: white;
        font-weight: bold;
    }
    .pagination ul li a {
        color: #464646;
    }

    .thumbnailcircle {
        border: 3px solid black;
        border-radius: 100%;
        width: 220px;
        height: 200px;
        display: table-cell;
        vertical-align: middle;
    }

    .header-second-log {
        position: absolute;
        right: 2rem;
        top: 6em;
        width: 15%;
    }

    .changewidth{
        padding-right: 15px;
        padding-left: 15px;
        -ms-flex-positive: 1;
        flex-grow: 1;
    }

    @media ( max-width : 991px ) {
        .changewidth{
            width: 240px;            
        }
    }
    @media ( min-width : 992px ){
        .changewidth{
            width: 220px;
        }   
    }

</style>

<?php 
    $this->Html->meta(null, null, ['property' => 'og:image','content' => $this->Url->build('/')."images/header_massif/".$massif->image_header_hiver,'block' => 'meta']);

$this->assign('title', __("Réserve tes vacances d'été 2022 à la montagne")); 
$this->Html->meta(null, null, ['property' => 'og:title','content' => __("Réserve tes vacances d'été 2022 à la montagne - Alpissime"), 'block' => 'meta']);
$this->Html->meta(null, null, ['name' => 'title','content' => __("Réserve tes vacances d'été 2022 à la montagne - Alpissime"), 'block' => 'meta']); 
$this->Html->meta(null, null, ['property' => 'og:description','content' => substr(__('Montagne Mon Trip : découvre la montagne en été. En mode aventurier, en impro, en groupe ou en couple, réserve ton séjour idéal. Partenaire Savoie Mont-Blanc'), 0, 155)." ..." ,'block' => 'meta']); 
$this->Html->meta(null, null, ['name' => 'description','content' => substr(__('Montagne Mon Trip : découvre la montagne en été. En mode aventurier, en impro, en groupe ou en couple, réserve ton séjour idéal. Partenaire Savoie Mont-Blanc'), 0, 155)." ..." ,'block' => 'meta']); 
?>
<?php $this->Html->css("/css/item-quantity-dropdown.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/item-quantity-dropdown.min.js", array('block' => 'scriptBottom')); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<?php if($language_header_name == "en"){
    $urlorig = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $urlorig = str_replace("/en/","/",$urlorig);
    $urlorig = str_replace("/summer-2022-holidays-in-the-french-alps","/montagne-mon-trip-location-de-vacances-savoie-haute-savoie",$urlorig);
    $this->assign('canonicalUrl', $urlorig);

    $this->assign('hreflang', $urlorig);
    $this->assign('hreflangen', "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}else{
    $urlorig = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $urlorig = str_replace($_SERVER['SERVER_NAME'],$_SERVER['SERVER_NAME']."/en",$urlorig);
    $urlorig = str_replace("/montagne-mon-trip-location-de-vacances-savoie-haute-savoie","/summer-2022-holidays-in-the-french-alps",$urlorig);
    $this->assign('hreflang', "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    $this->assign('hreflangen', $urlorig);
}  ?>

<div id="header_landing_page" class="header_landing_page">
    <div class="text-center text-header">
        <span class="header-second-log d-none d-md-block mr-1"><img src="#" data-src="<?php echo $this->Url->build('/'); ?>images/montagne-mon-trip-3.png"></span>
        <h1 class="text-white display-4 font-weight-bold"><?php echo __("Montagne, mon trip !"); ?></h1>
        <h2 class="text-white px-2"><?= __("Ton séjour montagne Savoie Mont Blanc en mode bons plans") ?></h2>
    </div>							
</div>
<!--End Slide--> 
<div class="container p-0">
    <?php echo $this->element("menu_recherche_station")?>
</div>
<?php if($annoncesavoie->count() > 0) { ?>
<section class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-10 mt-3 pb-4 ">
                <h2 class="h1"><?= __("Locations de vacances")." ".__("en") ?> savoie</h2>
            </div>
            <div class="col-2 mt-3 text-center">
                <a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=massif_7" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
		</div>
        <div class="annonce block products row">

        <?php  $c=0; foreach($annoncesavoie as $ann) { ?>
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
        </div><!--annonce block -->              
	</div>
</section>
<?php } ?>

<?php if($annoncehautesavoie->count() > 0) { ?>
<section class="mt-3">
    <div class="container">
        <div class="row">
            <div class="col-10 mt-3 pb-4 ">
                <h2 class="h1"><?= __("Locations de vacances")." ".__("en") ?> haute-savoie</h2>
            </div>
            <div class="col-2 mt-3 text-center">
                <a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=massif_8" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
		</div>
        <div class="annonce block products row">

        <?php  $c=0; foreach($annoncehautesavoie as $annhaute) { ?>
          <div class="col-6 col-sm-6 col-md-3" style="margin-bottom:10px">
            <div class="featured-product">
              <?php
              echo $this->element('petite_annonce', array('annonce'=>$annhaute, 'photo'=>$photos, 'residence'=>$residence, 'minprixannonce'=>$minprixannonce, 'noteglobalmoy'=>$noteglobalmoytab) );
              ?>
            </div>
          </div>
            <?php
            }
            ?>
        </div><!--annonce block -->              
	</div>
</section>
<?php } ?>

<section class="mt-3">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-4 ">
                <h2 class="h1"><?= __("Séjours montagne été par thème") ?></h2>
            </div>
            <div class="col-md-4 mb-5 px-1">
                <div class="shadow-sm h-100">
                    <a class="magazine-link" href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=massif_7&<?php echo $urlvaluemulti['nbCouchage_ad']; ?>=5&<?php echo $urlvaluemulti['nbCouchage_enf']; ?>=0" target="blanc">
                        <div class="thumbnail">
                            <?php if($language_header_name == "fr"){ ?>
                                <img src="#" data-src="<?php echo $this->Url->build('/'); ?>images/en-groupe.jpg">
                            <?php }else{ ?>
                                <img src="#" data-src="<?php echo $this->Url->build('/'); ?>images/en-groupe-EN.jpg">
                            <?php } ?>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 mb-5 px-1">
                <div class="shadow-sm h-100">
                    <a class="magazine-link" href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=massif_7&<?php echo $urlvaluemulti['nbCouchage_ad']; ?>=2&<?php echo $urlvaluemulti['nbCouchage_enf']; ?>=0" target="blanc">
                        <div class="thumbnail">
                            <?php if($language_header_name == "fr"){ ?>
                                <img src="#" data-src="<?php echo $this->Url->build('/'); ?>images/en-amoureux.jpg">
                            <?php }else{ ?>
                                <img src="#" data-src="<?php echo $this->Url->build('/'); ?>images/en-amoureux-EN.jpg">
                            <?php } ?>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 mb-5 px-1">
                <div class="shadow-sm h-100">
                    <a class="magazine-link" href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=massif_7&promotions=1" target="blanc">
                        <div class="thumbnail">
                            <?php if($language_header_name == "fr"){ ?>
                                <img src="#" data-src="<?php echo $this->Url->build('/'); ?>images/Bons-plans.jpg">
                            <?php }else{ ?>
                                <img src="#" data-src="<?php echo $this->Url->build('/'); ?>images/Bons-plans-EN.jpg">
                            <?php } ?>
                        </div>
                    </a>
                </div>
            </div>
		</div>
    </div>
</section>

<section class="mt-3">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-4 ">
                <h2 class="h1"><?= __("Séjours montagne été par destination") ?></h2>
            </div>
            <div class="row">
            <?php $count = 0; foreach ($listeStations as $value) { ?>
                <?php foreach ($value['lieugeos'] as $key) { 
                    if($key->name){ ?>
                        <?php if(fmod($count, 5) == 0){
                            $conteur = 0; ?>
                            <!-- <div class="row"> -->
                        <?php } ?>
                            <!-- <div class="col-md-4 col-lg mb-0"> -->
                            <div class="changewidth mb-0">
                                <div class="h-100 text-center">
                                    <a class="magazine-link" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['station'];?>/<?php echo $key->nom_url; ?>" target="blanc">
                                        <div class="thumbnailcircle p-3">
                                            <img class="img-fluid" src="#" data-src="<?php echo $this->Url->build('/')?>images/partners/<?php echo $key->image; ?>.png">
                                        </div>
                                        <div class="caption text-center p-4">
                                            <h3 class="m-0"><?php echo $key->name; ?></h3>
                                            <span class="font-italic">(<?php echo $nbrannonces[$key->id]." ".__("Annonces"); ?>)</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php if($conteur == 4){ ?>
                            <!-- </div> -->
                        <?php } ?>
                    <?php $conteur++; $count++; } ?>
                <?php } ?>                                    
            <?php } ?>
            </div>
        </div>
    </div>
</section>

<!-- Section Infos -->
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12 col-md-4 mb-5">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                <svg class="icon-reassurance1" aria-hidden="true" width="75" height="65" viewBox="0 0 166.69 133.37">
                <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/reassurance-home.svg#Calque_2"></use>
                </svg>
                </div>
                <div><?= __("Spécialiste français du séjour montagne depuis 2006") ?></div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-5">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                    <svg class="icon-reassurance2" aria-hidden="true" width="75" height="65" viewBox="0 0 151.72 150.37">
                    <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/reassurance-home2.svg#Calque_3"></use>
                    </svg>
                </div>
                <div><?= __("Partenaire officiel de Savoie Mont-Blanc Tourisme") ?></div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-5">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0">
                    <svg class="icon-reassurance3" aria-hidden="true" width="75" height="65" viewBox="0 0 46 46">
                    <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/reassurance-paiement.svg#Calque_4"></use>
                    </svg>
                </div>
                <div><?= __("Paiement sécurisé jusqu'à 4x sans frais") ?></div>
            </div>
            </div>
        </div>
    
    </div>
</div>
<!-- End Section Infos -->
<!-- Section pourquoi alpissime -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
			<div class="col-md-12 text-center">
				<h2 class="h1"><?= __("Montagne Mon Trip, ton séjour Savoie Mont Blanc en mode bons plans") ?></h2>
                <p class="p-3"><?= __("En 2022, tout ce qu’on veut, c’est partir sur un coup de tête, décider au dernier moment sans forcément exploser son budget. Avec <b>Montagne Mon Trip</b>, c’est toi qui décides : escalade, kayak, tyrolienne, paddle… viens tester le meilleur de l’outdoor au cœur des Alpes. Pars avec qui tu veux, reste autant que tu veux et profite d’un max de bons plans. Pour trois jours ou pour une semaine, en club ou en appart, version tout compris ou en totale impro, ça aussi, c’est toi qui vois.") ?></p>
                <button class="btn btn-blue text-white rounded-circle collapse-button-chevron p-0" type="button" data-toggle="collapse" data-target="#collapsePourquoi" aria-expanded="false" aria-controls="collapsePourquoi">
                <i class="fa fa-chevron-up font-size-small"></i>
                <i class="fa fa-chevron-down font-size-small"></i>
                </button>
			</div>
            <div class="collapse bg-white m-3 p-3 p-md-5" id="collapsePourquoi">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="font-weight-bold py-3 h2"><?= __("Ou partir en Savoie l'été ?") ?></h3>
                    <p><?= __("Réserve ta <b>location de vacances en Savoie</b> auprès de particuliers vérifiés. Plus de 10 destinations t'attendent sur Alpissime. Adepte des grosses stations de ski ou amateur des stations-village authentiques, tu trouveras forcément ton bonheur parmi les plus de 500 annonces disponibles en Savoie et Haute-Savoie.") ?></p>
                    <h3 class="font-weight-bold py-3 h2"><?= __("Ou partir en Haute-Savoie l'été ?") ?></h3>
                    <p><?= __("Plutôt chalet ou appartement ? La Haute-Savoie offre des paysages à couper le souffle pour un dépaysement garanti. De quoi changer radicalement du métro, boulot, dodo ! ") ?> </p>
                    <h3 class="font-weight-bold py-3 h2"><?= __("Location de vacances été à la montagne") ?></h3>
                    <p><?= __("Compose ton séjour comme tu l'entends et profite de tes vacances en toute tranquillité ! Avec Savoie Mont Blanc, Alpissime te propose des offres et bons plans flexibles, pour partir ou tu veux, quand tu veux. De quoi profiter d'un <b>séjour montagne été</b> en famille ou entre amis pour découvrir les magnifiques paysages de montagne et s'essayer à de nouvelles activités comme la randonnée ou les sports d'eaux vives, ou tout simplement se relaxer sous le soleil.") ?></p>
                </div>
                <div class="col-md-6">
                    <h3 class="font-weight-bold py-3 h2"><?= __("Avec Montagne Mon Trip, ton séjour facilité") ?></h3>
                    <p>
                        <ul>
                            <li><?= __("FLEX : break de trois jours ou semaine complète") ?></li>
                            <li><?= __("FORT : au moins une nouvelle aventure par jour") ?></li>
                            <li><?= __("CHILL : hébergements et formules au choix") ?></li>
                            <li><?= __("COOL : max de bons plans pour ne pas exploser ton budget") ?> </li>
                        </ul>
                    </p>
                    <h3 class="font-weight-bold py-3 h2"><?= __("Séjour à la montagne en été") ?></h3>
                    <p><?= __("Découvrir la faune et la flore de montagne, profiter de l'air pur, prendre le soleil en famille ou entre amis dans le cadre exceptionnel d'un village de montagne, c'est ça, <b>un séjour en été en Savoie </b>ou </b>Haute-Savoie</b> ! <br>Part à la découverte des stations de <b>montagne en été </b>en réservant un appartement ou un chalet sur Alpissime avec une garantie de flexibilité : annulation gratuite 1 mois avant le voyage ou annulation COVID gratuite jusqu'à J-1.<br>Fini le classique séjour du samedi au samedi et les bouchons infinis sur la route des vacances ! En réservant tes <b>vacances montagne été</b> sur Alpissime avec Savoie Mont Blanc, réserve le séjour de tes envies grâce à nos bons plan montagne été.") ?></p>
                </div>
            </div>
            </div>
		</div>
    </div>
</section>
<!-- End Section pourquoi alpissime -->


<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
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

$(document).ready(function () {
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

    $("section.main").removeClass('py-5');
    $("#bottom-first").removeClass('mt-5');

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
<?php $this->Html->scriptEnd(); ?>