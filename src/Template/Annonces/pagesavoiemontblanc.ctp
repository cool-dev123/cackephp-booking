<?php $this->append('cssTopBlock', '<style>
.blocleft{
    margin-left: -12em !important;
    max-width: 100% !important;
    width: 65% !important;
}
h1{
    position: relative;
    font-size: 45px;
    margin-top: 9%;
}
.rechercheLanding{
    margin-top: 15px!important;
    margin-right: 0 !important;
    margin-left: 0 !important;
    border-radius: 0px !important;
    padding: 5px 10px 0px 6px !important;
}
.iqdropdown {
    width: 77%;
    margin-right: 0 !important;
}
#recherchelogement {
    width: 130%!important;
    left: -20px!important;
    position: relative!important;
}
label.m-0 {
    font-size: 12px!important;
}
.changewidth{
    border-radius: 20px;
}
.imageblocvacance{
    border-radius: 20px 0px 0px 20px;
    object-fit: cover;
}
.roundeddiv{
    border-radius: 10px;
}

h2.h1 {
    font-size: 25px;
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
@media screen and (max-width: 991px) {
    .blocleft{
        margin-left: 0px !important;
        max-width: 100% !important;
        width: 100% !important;
    }
    .iqdropdown {
        width: 100%;
        margin-right: 1rem !important;
    }
    .rechercheLanding{
        padding: 1rem!important;
    }
    #recherchelogement {
        width: 100%!important;
        left: 0px!important;
        position: relative!important;
    }
    h1 {
        position: absolute;
        top: 180px;
        left: 25%;
    }
    .no-gutters .p-5 {
        padding: 15px !important;
    }
    .no-gutters .p-5 img{
        width: 50%;
    }
    .no-gutters .p-5 p {
        margin-top: 10px !important;
        font-size: 13px;
    }
    .h1station{
        display: none;
    }
    .changewidth{width: 95%;}
    .change-width{width: 75%;}



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
    $this->assign('title', __("Ski m'Arrange - Séjour Ski Flexible en Savoie Mont Blanc"));
    $this->Html->meta(null, null, ['name' => 'title','content' => __("Ski m'Arrange - Séjour Ski Flexible en Savoie Mont Blanc") ,'block' => 'meta']);
    $this->Html->meta(null, null, ['property' => 'og:title','content' =>  __("Ski m'Arrange - Séjour Ski Flexible en Savoie Mont Blanc") ,'block' => 'meta']);
    $this->Html->meta(null, null, ['name' => 'description','content' => __("Spontané ou en avance. En court ou en long séjour. Seul ou à plusieurs. Réservez votre séjour ski flexible avec Alpissime • Partenaire officiel Savoie Mont Blanc") ,'block' => 'meta']);
    $this->Html->meta(null, null, ['property' => 'og:description','content' => __("Spontané ou en avance. En court ou en long séjour. Seul ou à plusieurs. Réservez votre séjour ski flexible avec Alpissime • Partenaire officiel Savoie Mont Blanc") ,'block' => 'meta']);

    $url = $this->Url->build('/', true);

    $rechercheUrl = $url . $urlLang . $urlvaluemulti['recherche'];

    if (isset($station->id)) {
        $rechercheUrl .= '?'. $urlvaluemulti['lieugeo'] . '=' . $station->id;
    }
?>

<!--Slide-->
<div class="container">
    <div class="row justify-content-start">
        <div class="col-lg-6 p-0">
            <div class="pt-0 pt-md-4 h-100">
                <img class="img-fluid imageheaderstation h-100" alt="Ski m'arrange savoie mont blanc" src="/images/pagesavoie/HEADER-SAVOIE-MONT-BLANC-SEJOUR-FLEXIBLE-SKI-M-ARRANGE.jpg"/>
            </div>
            <div class="logobottom">
                <img class="imageheaderstation" alt="" src="/images/ico/Coin.png"/>
            </div>            
        </div>
        <div class="blocleft">
            <h1 class=""><span class="h1station p-2"><?= __("Séjour ski flexible en <br>Savoie Mont Blanc") ?></span></h1>
            <div class="container stationpage p-0">
                <?php echo $this->element("menu_recherche_station")?>
            </div>
            <div class="row mb-3"></div>
        </div>
    </div>
</div>							
<!--End Slide-->
<?php if($annonces->count() > 2) { ?>
<section class="mt-4">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-2 ">
                <h2 class="h1"><?= __("Séjours ski flexibles toute l'année") ?></h2>
            </div>
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-center d-none d-md-block">
                <a href="<?= $rechercheUrl ?>" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
		</div>
        <div class="annonce block products row">

        <?php foreach($annonces as $ann) { ?>
          <div class="col-6 col-sm-6 col-md-3" style="margin-bottom:10px">
            <div class="featured-product">
              <?php
              echo $this->element('petite_annonce', [
                  'annonce'        => $ann,
                  'photo'          => $photos,
                  'minprixannonce' => $minprixannonce,
                  'noteglobalmoy'  => $noteglobalmoytab
              ]);
              ?>
            </div>
          </div>
            <?php
            }
            ?>
        </div>
        <div class="row d-block d-md-none">
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-right sizebigger">
                <a href="<?= $rechercheUrl ?>" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
        </div>
	</div>
</section>
<?php } ?>
<!-- Section Infos -->
<div class="container mt-0 mt-md-4">
    <div class="row">
        <div class="col-sm-12 col-md-4 mb-sm-2 mb-md-5">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                    <img width="100" src="/images/ico/location-de-vacances-entre-particulier-station-de-ski-savoie.png" class="img-responsive change-width">
                </div>
                <div><?= __("Plateforme française créée en Savoie en 2006") ?></div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-sm-2 mb-md-5">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                    <img width="100" src="/images/ico/annonces-de-particuliers-verifiees.png" class="img-responsive change-width">
                </div>
                <div><?= __("100% des annonces vérifiées manuellement") ?></div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-5">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0">
                    <img width="100" src="/images/ico/service-client.png" class="img-responsive">
                </div>
                <div class="container d-block d-md-none"><?= __("Besoin d'assistance lors de votre réservation ? Posez-nous votre question par livechat !") ?></div>
                <div class="container d-none d-md-block"><?= __("Service client en direct par livechat et mail") ?></div>
            </div>
            </div>
        </div>    
    </div>
</div>
<!-- End Section Infos -->
<div class="container shadow rounded-50 p-0 changewidth">
    <div class="row no-gutters d-flex align-items-center">        
        <div class="col-md-6">     
            <img class="img-fluid imageblocvacance h-100" alt="Ski m'arrange savoie mont blanc" src="/images/pagesavoie/SAVOIE-MONT-BLANC-SEJOUR-FLEXIBLE-SKI-M-ARRANGE.jpg"/>
        </div>
        <div class="col-md-6 p-5 text-center">
            <img class="img-fluid" alt="Ski m'arrange savoie mont blanc" src="/images/pagesavoie/vacances_flexibles.png"/>
            <p class="m-0 mt-4">
                <span class="font-weight-bold"><?= __("Les dates"); ?> :</span> <?= __("Arrivez et partez quand vous voulez."); ?><br>
                <span class="font-weight-bold"><?= __("La durée"); ?> :</span> <?= __("Break de trois jours ou semaine complète ?"); ?><br>
                <span class="font-weight-bold"><?= __("La période"); ?> :</span> <?= __("Pendant les vacances scolaires, ou pas."); ?><br>
                <span class="font-weight-bold"><?= __("La sérénité"); ?> :</span> <?= __("Terminés, les bouchons sur la route !"); ?><br>
                <span class="font-weight-bold"><?= __("Lé budget"); ?> :</span> <?= __("Adaptez votre séjour en fonction de votre budget."); ?>
            </p>
        </div>
    </div>
</div>
<section class="mt-4">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-2 ">
                <h2 class="h1"><?= __("Séjours ski en Savoie Mont Blanc : Nos top destinations") ?></h2>
            </div>
		</div> 
        <div class="row">
            <?php foreach ($listeStations as $value) { ?>
                <?php foreach ($value['lieugeos'] as $key) { 
                    if($key->name){ ?>
                            <div class="col-6 col-md-2 mb-3">
                            <a class="nolinkcolor" href="<?= $url . $urlLang . $urlvaluemulti['station']?>/<?= $key->nom_url; ?>">
                                <div class="shadow p-2 h-100 roundeddiv">
                                    <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                                        <div class="text-center mb-0">
                                            <img class="img-fluid" src="#" data-src="/images/partners/<?= $key->image; ?>.png">
                                        </div>
                                    </div>
                                </div>
                                </a>  
                            </div> 
                    <?php } ?>
                <?php } ?>                                    
            <?php } ?>
        </div>
        <div class="alert alert-success py-1 mt-4" role="alert">
            <i class="fa fa-check-circle fa-lg mr-3" aria-hidden="true"></i> <?= __("Votre séjour remboursé à 100% en cas de COVID-19") ?>
        </div>             
	</div>
</section>
<?php if($annoncesFamille->count() > 2) { ?>
<section class="mt-4">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-2 ">
                <h2 class="h1"><?= __("Vacances ski en famille en Savoie Mont Blanc") ?></h2>
            </div>
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-center d-none d-md-block">
                <a href="<?= $rechercheUrl ?>" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
		</div>
        <div class="annonce block products row">

        <?php foreach($annoncesFamille as $ann) { ?>
          <div class="col-6 col-sm-6 col-md-3" style="margin-bottom:10px">
            <div class="featured-product">
              <?php
              echo $this->element('petite_annonce', [
                  'annonce'        => $ann,
                  'photo'          => $photos,
                  'minprixannonce' => $minprixannonce,
                  'noteglobalmoy'  => $noteglobalmoytab
              ]);
              ?>
            </div>
          </div>
            <?php
            }
            ?>
        </div>
        <div class="row d-block d-md-none">
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-right sizebigger">
                <a href="<?= $rechercheUrl ?>" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
        </div>
              
	</div>
</section>
<?php } ?>
<?php if($annoncespromos->count() > 2) { ?>
<section class="mt-4">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-2 ">
                <h2 class="h1"><?= __("Bons plans séjours flexibles") ?></h2>
            </div>
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-center d-none d-md-block">
                <a href="<?= $rechercheUrl ?>" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
		</div>
        <div class="annonce block products row">

        <?php foreach($annoncespromos as $ann) { ?>
          <div class="col-6 col-sm-6 col-md-3" style="margin-bottom:10px">
            <div class="featured-product">
              <?php
              echo $this->element('petite_annonce', [
                  'annonce'        => $ann,
                  'photo'          => $photos,
                  'minprixannonce' => $minprixannonce,
                  'noteglobalmoy'  => $noteglobalmoytab
              ]);
              ?>
            </div>
          </div>
            <?php
            }
            ?>
        </div>
        <div class="row d-block d-md-none">
            <div class="col-12 mt-lg-n5 mb-5 mb-md-0 text-right sizebigger">
                <a href="<?= $rechercheUrl ?>" class="float-lg-right font-weight-500 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
        </div>
              
	</div>
</section>
<?php } ?>
<!-- Section Infos -->
<div class="container my-5">
    <h2 class="h1"><?php echo __('Comment ça marche ?'); ?></h2>
    <div class="row">
        <div class="col-sm-12 col-md-4 mb-4">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                    <img width="100" src="/images/ico/location-vacances-ski.png" class="img-responsive">
                </div>
                <div class="smalllineheight"><h3 class="m-0 smalllineheight"><?= __("Trouvez la location de vacances idéale") ?></h3><small><?= __("Parmi les centaines d'annonces vérifiées par notre équipe.") ?></small></div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-4">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0 ">
                    <img width="100" src="/images/ico/forfaits-cours-location-de-ski.png" class="img-responsive">
                </div>
                <div class="smalllineheight"><h3 class="m-0 smalllineheight"><?= __("Ajoutez des activités à prix réduit") ?></h3><small><?= __("Location, cours, forfaits de ski et bien plus encore.") ?></small></div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-4">
            <div class="shadow p-3 h-100">
            <div class="d-flex d-md-block d-lg-flex mb-4 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-0 mb-md-2 mb-lg-0">
                    <img width="100" src="/images/ico/paiement-securise-4-fois-sans-frais.png" class="img-responsive">
                </div>
                <div class="smalllineheight"><h3 class="m-0 smalllineheight"><?= __("Réglez jusqu'à 4x sans frais") ?></h3><small><?= __("Et profitez de votre séjour ski, tout simplement !") ?></small></div>
            </div>
            </div>
        </div>    
    </div>
</div>
<!-- End Section Infos -->/

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

<?php $this->Html->scriptEnd(); ?>