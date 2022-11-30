<style>
    .header_landing_page {
        <?php if(in_array(date("m"),array('05','06','07','08'))){
            if($massif->image_header_ete != '') echo "background: url(".$this->Url->build('/')."images/header_massif/".$massif->image_header_ete.") no-repeat;";
        }else{ 
            if($massif->image_header_hiver != '') echo "background: url(".$this->Url->build('/')."images/header_massif/".$massif->image_header_hiver.") no-repeat;" ;
        } ?>
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
    #partners {
        height: 150px;
    }
</style>

<?php if($language_header_name == "en"){
  $urlorig = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $urlorig = str_replace("/en/","/",$urlorig);
  $urlorig = str_replace("/region","/massif",$urlorig);
  $this->assign('canonicalUrl', $urlorig);

  $this->assign('hreflang', $urlorig);
  $this->assign('hreflangen', "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}else{
    $urlorig = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $urlorig = str_replace($_SERVER['SERVER_NAME'],$_SERVER['SERVER_NAME']."/en",$urlorig);
    $urlorig = str_replace("/massif","/region",$urlorig);
    $this->assign('hreflang', "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    $this->assign('hreflangen', $urlorig);
}  ?>

<?php if($this->Session->read('Config.language') == 'fr_FR') $massifdescreption = $massif->descreption; else $massifdescreption = $massif->_translations[$this->Session->read('Config.language')]->descreption; ?>

<?php if(in_array(date("m"),array('05','06','07','08')) && $massif->image_header_ete == ''){ ?>
    <div id="header_landing_page" class="header_landing_page_ete">
<?php 
    $this->Html->meta(null, null, ['property' => 'og:image','content' => $this->Url->build('/')."images/header_massif/".$massif->image_header_ete,'block' => 'meta']);
}else{ ?>
    <div id="header_landing_page" class="header_landing_page">
<?php 
    $this->Html->meta(null, null, ['property' => 'og:image','content' => $this->Url->build('/')."images/header_massif/".$massif->image_header_hiver,'block' => 'meta']);
} 
$this->assign('title', __('Destination {0} : Stations de ski', [$massif->nom])); 
$this->Html->meta(null, null, ['property' => 'og:title','content' => __('Destination {0} : Stations de ski | Alpissime.com', [$massif->nom]), 'block' => 'meta']);
$this->Html->meta(null, null, ['name' => 'title','content' => __('Destination {0} : Stations de ski | Alpissime.com', [$massif->nom]), 'block' => 'meta']); 
$this->Html->meta(null, null, ['property' => 'og:description','content' => substr($massif->nom." ".__('Découvrez Toutes les stations de la destination.')." ".$massifdescreption, 0, 155)." ..." ,'block' => 'meta']); 
$this->Html->meta(null, null, ['name' => 'description','content' => substr($massif->nom." ".__('Découvrez Toutes les stations de la destination.')." ".$massifdescreption, 0, 155)." ..." ,'block' => 'meta']); 
?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

        <div class="text-center text-header">
            <h1 class="text-white display-4 font-weight-bold"><?php echo $massif->nom; ?></h1>
            <h2 class="text-white px-2"><u><a href="<?php echo $this->Url->build('/').$urlLang;?>" class="text-white" > <?= __("Locations de vacances") ?></a></u> > <?= __("Séjour ski par destination") ?></h2>
        </div>							
    </div>
    <!--End Slide--> 

    <div class="container p-0">
        <?php echo $this->element("menu_recherche_station")?>
    </div>

<section class="mt-5 mb-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 text-center">
                <img src="<?php echo $this->Url->build('/')?>img/uploads/<?php echo $massif->image; ?>" />
            </div>
            <div class="col-md-8">
                <h2 class="font-weight-bold mb-4"><?= __("Découvrez les stations de ski par massif") ?> : <?php echo $massif->nom; ?></h2>
                <p class="pr-md-5"><?php echo $massifdescreption; ?></p>
            </div>
        </div>
    </div>
</section>

<section class="bg-light py-5">
    <div class="container">
        <h2 class="h1 text-center col-sm-12 m-0 mb-2"><?= __("Destination montagne") ?> : <?php echo $massif->nom; ?></h2>   
        <?php foreach ($listeStation as $station) { ?>
            <!-- Boucle Station -->
            <div class="row mt-3 p-3 bg-white shadow">
                <!-- First row -->
                <div class="row px-4 py-3 align-items-center">
                    <div class="col-md-3 text-center">
                        <img src="<?php echo $this->Url->build('/')?>images/partners/<?php echo $station->image; ?>.png" />
                    </div>
                    <div class="col-md-9">
                        <h3 class="mb-4"><?php echo $station->name; ?></h3>
                        <p class="pr-md-5"><?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->descreption; else echo $station->_translations[$this->Session->read('Config.language')]->descreption; ?></p>
                        <a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['station'];?>/<?php echo $station->nom_url; ?>">
                            <button class="btn btn-blue text-white rounded-0 px-5 mb-2" type="button" >
                            <?= __("En savoir plus") ?>
                            </button>
                        </a>
                    </div>                
                </div>                         
                <!-- Second row -->
                <?php if(count($listeAnnonce[$station->id]) > 0){ ?>
                <div class="col-12"><hr></div>   
                <div class="col-12 px-5">
                    <h3 class="row mb-4"><?= __("Trouvez l'hébergement idéal") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->preposition_a; else echo $station->_translations[$this->Session->read('Config.language')]->preposition_a; ?> <?php echo $station->name; ?></h3>
                    <div class="annonce block products row">
                    <?php foreach($listeAnnonce[$station->id] as $ann) { ?>
                        <div class="col-6 col-sm-6 col-md-3 px-2" style="margin-bottom:10px">
                            <div class="featured-product">
                                <?php echo $this->element('petite_annonce', array('annonce'=>$ann, 'photo'=>$photosCont, 'residence'=>$residenceAnnonce, 'minprixannonce'=>$minprixannonce[$station->id], 'noteglobalmoy'=>$noteglobalmoytab[$station->id]) ); ?>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                    <div class="row float-right">
                        <a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['recherche'];?>?lieugeo=<?php echo $station->id; ?>">
                            <button class="btn btn-blue text-white rounded-0 px-5 mb-2" type="button" >
                                <?= __("Voir toutes les annonces") ?>
                            </button>
                        </a>
                    </div>                    
                </div>
                <?php } ?>
            </div>
            <!-- Fin Boucle Station -->
        <?php } ?>        
        <!-- Pagination -->
        <div id="mes_annonces" class="mes_annonces">
            <div class="row px-4-5">
                <div class="col-md-12 mt-4">
                    <div class="pagination mt-4">
                        <ul class="list-inline"><?php if(!empty($this->Paginator->first('<<'))){ ?>
                            <?php echo $this->Paginator->first('<<'); ?>
                        <?php } ?>
                        <?php $affichePages=$this->Paginator->numbers(); if ($affichePages=='') {} else { $affichePages=$this->Paginator->numbers(); echo ($affichePages); } ?>
                        <?php if(!empty($this->Paginator->last('>>'))){ ?>
                            <?php echo $this->Paginator->last('>>'); ?>
                        <?php } ?>
                        </ul>			
                    </div><!--end pagination-->
                </div><!--end col-md-12-->
            </div>
        </div>        
    </div>
</section>

<!-- Section partners -->
<section id="partners" class="mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center text-md-left">
                <h2 class="title-newsletter pb-3"><?= __("Nos partenaires") ?></h2>
            </div>
			<div class="col-md-12">
                <div class="regular slider">
                    <?php foreach ($stations as $station) {
                            if($station->image != ''){ ?>
                            <div >
                                <picture>
                                    <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.webp" type="image/webp">
                                    <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.png" type="image/png">
                                    <img alt="Partenaire <?php echo $station->name;?>" src="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.png"/>
                                </picture>
                            </div>
                        <?php } 
                        } ?>

                    <?php $listpartab = [];
                    foreach ($listePart as $partenaires) {
                        foreach ($partenaires as $key => $parten) {                        
                            if($parten->image != ""){
                                if(!in_array($parten->id, $listpartab)){
                                    $listpartab[] = $parten->id;                             
                                ?>
                            <div >
                                <picture>
                                    <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $parten->image; ?>.webp" type="image/webp">
                                    <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $parten->image; ?>.png" type="image/png">
                                    <img alt="Partenaire <?php echo $parten->raison_sociale; ?>" src="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $parten->image; ?>.png"/>
                                </picture>
                            </div>
                        <?php   
                                } 
                            }
                        } 
                    } ?>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Section partners -->


<?php $this->Html->css("/css/item-quantity-dropdown.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/item-quantity-dropdown.min.js", array('block' => 'scriptBottom')); ?>


<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
$('body').on('click',function(event){
    if(!$(event.target).is('.iqdropdown-selection') && !$(event.target).is('#animaux')){
      $(".iqdropdown").removeClass("menu-open")
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
});
<?php $this->Html->scriptEnd(); ?>