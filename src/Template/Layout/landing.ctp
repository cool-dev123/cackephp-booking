<!doctype html>
<html lang="<?php echo $language_header_name; ?>">
<head>
    <?php if(PROD_ON == 1){ ?>
    <!-- Google Tag Manager -->
    <script>
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PXZVFPZ');
    </script>
    <!-- End Google Tag Manager -->
    <!-- Global site tag (gtag.js) - Google Ads: 959030564 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-959030564"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-959030564');
    </script>
    <?php echo $this->fetch('headTop'); ?>
    <?php } ?>


<!-- Start cookieyes banner -->
<script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/42f3745ec212b55224e20de6.js"></script>
<!-- End cookieyes banner --> 

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= ucfirst(str_ireplace('www.', '', $_SERVER['HTTP_HOST'])) . " | " . __('Locations entre particuliers en station de ski') ?></title>
	<meta name="description" content="<?= __('Séjour ski - Réservez vos vacances sur Alpissime | 🏘 Hébergements vérifiés ⛷ Activités en station ⭐️ Services de conciergerie | Paiement en 4x sans frais') ?>">
	<meta name="keywords" content="<?= __('location, appartement, hébergement, studio, séjour, vacances, montagne, les Arcs, Bourg Saint Maurice, Savoie, Alpes, Paradiski, hiver, ski, été, vtt') ?>">
	<meta name="viewport" content="width=device-width, minimal-ui">
	
    <?php echo $this->fetch('meta'); ?>
    <meta property="og:title" content="<?= __('Alpissime.com | Locations entre particuliers en station de ski') ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />

    <?php //if($language_header_name == "en") { ?>
        <link rel="canonical" href="<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
    <?php //} ?>
    <link rel="alternate" hreflang="fr" href="<?php echo SITE_ALPISSIME; ?>" />
    <link rel="alternate" hreflang="en" href="<?php echo SITE_ALPISSIME."en/"; ?>" />

    <?php if(in_array(date("m"),array('05','06','07','08'))){
     $contentimg = $this->Url->build('/',true).'images/og_images/alpissime-locations-entre-particuliers-montagne-été-og.jpg';
        echo $this->Html->meta(null, null, ['property' => 'og:image','content' => $contentimg]); 
	 }else{ 
     $contentimg = $this->Url->build('/',true).'images/og_images/alpissime-locations-entre-particuliers-sejour-ski-vacances-hover-og.jpg';
        echo $this->Html->meta(null, null, ['property' => 'og:image','content' => $contentimg]); 
	 } ?>
	
    <meta Http-Equiv="Cache-Control" Content="no-cache">
    <meta Http-Equiv="Pragma" Content="no-cache">
    <meta Http-Equiv="Expires" Content="0">
    <meta Http-Equiv="Pragma-directive: no-cache">
    <meta Http-Equiv="Cache-directive: no-cache">
	<?php
	header("Expires: 0");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	?>

    <!-- Meta-tag facebook -->
	<meta name="facebook-domain-verification" content="apl7ssqsyov8246kdo1zntql7ovdjt" />
	
	<!-- Bootstrap CSS -->
    <style>
    @import url('https://fonts.googleapis.com/css?family=Oswald:400,700,300&display=swap');
    @import url("https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap");
    </style>
	<link rel="stylesheet" href="<?php echo $this->Url->build('/')?>css/new/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->Url->build('/')?>css/new/bootstrap-grid.min.css">
	<link href="<?php echo $this->Url->build('/')?>css/new/jquery-ui.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->Url->build('/')?>css/slick.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo $this->Url->build('/')?>css/slick-theme.min.css"/>
      <!-- UIkit CSS -->
      <link rel="stylesheet" href="<?php echo $this->Url->build('/')?>css/new/uikit.min.css" />
	<link rel="stylesheet" href="<?php echo $this->Url->build('/')?>css/new/style.min.css">
	
	<!-- <link href='https://fonts.googleapis.com/css?family=Oswald:400,700,300&display=swap' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet"> -->
	<link href="<?php echo $this->Url->build('/')?>css/new/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo $this->Url->build('/')?>css/item-quantity-dropdown.min.css" rel="stylesheet">
	
	<!-- Le fav and touch icons -->
	<link rel="shortcut icon" href="<?php echo $this->Url->build('/')?>images/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->Url->build('/')?>images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->Url->build('/')?>images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->Url->build('/')?>images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo $this->Url->build('/')?>images/ico/apple-touch-icon-57-precomposed.png">
	

	<!-- Liste cssTop -->
    <?php echo $this->fetch('cssTop'); ?>
    <?php echo $this->fetch('cssTopBlock'); ?>
	
    <style>
    .datasrc{	
        height: 191px;
	    object-fit: cover;
    }
    @media only screen and (max-width: 480px) {
        .datasrc {	
            height: 135px;
            object-fit: cover;
        }
    }
    #message {
        position: fixed;
        left: 50%;
        transform: translate(-50%, -50%);
        bottom: 0;
        z-index: 999;
    }
    .alert-reserv-attente{
        color: #0096FF;
        background: #e5f3fc;        
        border-color: #e5f3fc;
        border-radius: 0;
        z-index: 999;
        text-align: center;
        font-size: 19px;
    }
    .alert-reserv-attente a{
        color: #0096FF;
    }
    #magazine h3{
        height: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    #magazine .thumbnail .caption {
        justify-content: normal;
    }
    #villagediv{
        display: none;
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
    #partners {
        height: 150px;
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
    #magazine .thumbnail img {
        min-height: 200px;
    }
    </style>
</head>
<body>
<?php if($language_header_name == "fr") { ?>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/60001129a9a34e36b96c4e21/1es04702f';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
<?php }else{ ?>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/60001129a9a34e36b96c4e21/1gdvpfskj';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
<?php } ?>

<script type="application/ld+json">
{
    "@context" : "http://schema.org",
    "@type" : "Organization",
    "name" : "Alpissime",
    "url" : "https://www.alpissime.com",
    "@id" : "https://www.alpissime.com",
    "logo" : "<?php echo $this->Url->build('/')?>images/svg/logo-couleur-alpissime-baseline.svg#Calque_2",
    "sameAs" : [
        "https://twitter.com/alpissime",
        "https://www.facebook.com/alpissime",
        "https://www.instagram.com/alpissime_vacances",
        "https://www.youtube.com/user/alpissime",   
        "https://www.linkedin.com/company/alpissime"
    ],
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "Galerie Pierra Menta à Arc 1800 - Bourg Saint Maurice",
        "addressRegion": "Savoie",
        "postalCode": "73700",
        "addressCountry": "France"
    }
}
</script>
<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<!--End of Tawk.to Script-->
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PXZVFPZ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<div class="container-fluid notvalidiv" style="display:none;">
		<div class="row">
			<div class="col">
				<?= __("Votre compte est limité, vous devez activer votre adresse email !") ?></br><a href='#' onclick="renvoyermail()" style="color:#fea;"><?= __("Renvoyer un mail de confirmation") ?></a>
                </br><?= __("Vous ne le trouvez pas ? Vérifiez votre dossier Spams et ajoutez Alpissime à vos contacts !") ?>
			</div>
		</div>
	</div>		
	<!--Header-->
	<?php echo $this->element('headerdiv'); ?>
	<!--End Header-->
	<!--Slide-->
	<?php if(in_array(date("m"),array('05','06','07','08'))){?>
	<div id="header_landing_page" class="header_landing_page_ete">
	<?php }else{ ?>
	<div id="header_landing_page" class="header_landing_page">
	<?php } ?>
	    <div class="container">
			<div class="row justify-content-start">
				<div class="col-xl-5 col-lg-6 col-md-8 col-sm-8">
					<div class="rechercheLanding">
						<h2><?= __('Trouvez l\'hébergement parfait pour vos prochaines vacances') ?></h2>
                        <!-- ['controller' => 'annonces', 'action' => 'recherche'], -->
                        <?php echo $this->Form->create(null,['type'=>'get', 'url' => SITE_ALPISSIME.$urlLang.$urlvaluemulti['recherche'],'id'=>'annonceRechercheForm'])?>
                        <?php echo $this->Form->input("nbCouchagead",["type"=>"hidden","id"=>"nbCouchage_ad","name"=>$urlvaluemulti['nbCouchage_ad'], "value"=>1])?>
                        <?php echo $this->Form->input("nbCouchageenf",["type"=>"hidden","id"=>"nbCouchage_enf","name"=>$urlvaluemulti['nbCouchage_enf'],"value"=>0])?>
                            <div class="form-group">
                                <label><?= __("Rechercher une location de vacances") ?></label>	
                                <select name="<?php echo $urlvaluemulti['lieugeo']; ?>" class="form-control custom-select" id="lieugeo" onchange="get_village(this.value)">
                                <option value="0"><?= __("Toutes les stations") ?></option>
                                <?php foreach ($stations as $value) { ?>
                                    <option class="font-weight-bold" value="massif_<?php echo $value->id; ?>"><?php echo $value->nom; ?></option>
                                        <?php foreach ($value['lieugeos'] as $key) { ?>
                                            <?php if($key->name){ ?>
                                            <option value="<?php echo $key->id; ?>">&nbsp;&nbsp;&nbsp;<?php echo $key->name; ?></option>
                                            <?php } ?>
                                        <?php } ?>                                    
                                <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group" id="villagediv">
                                <label><?= __("Sélectionnez un village") ?></label>	
                                <select name="village" class="form-control custom-select" id="village">
                                    <option value="0"><?= __("Tous les villages") ?></option>
                                    <?php foreach ($listevillageann as $keyvillage) { ?>
                                        <option value="<?php echo $keyvillage->id; ?>" <?php if($this->request->query['village'] == $keyvillage->id) echo "selected"?>><?php echo $keyvillage->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
							<div class="form-group">
								<label><?= __("Dates") ?></label>
								<div class="row">
								    <div class="col-md-6 col-sm-12 pr-md-0 location_du">
                                        <div class="input-group mb-2">
                                            <input id="location_du" class="form-control" name="<?php echo $urlvaluemulti['dbt']; ?>" placeholder="jj-mm-aaaa" readonly />
                                            <div class="input-group-append">
                                                <div class="input-group-text"><label class="add-on mb-0" for="location_du"><i class="fa fa-calendar"></i></label></div>
                                            </div>
                                        </div>
                                    </div>
							        <div class="col-md-6 col-sm-12 pl-md-0 mt-3 mt-md-0 location_au">
                                        <div class="input-group mb-2">
                                            <input id="location_au" class="form-control" name="<?php echo $urlvaluemulti['fin']; ?>" placeholder="jj-mm-aaaa" readonly />
                                            <div class="input-group-append">
                                                <div class="input-group-text"><label class="add-on mb-0" for="location_au"><i class="fa fa-calendar"></i></label></div>
                                            </div>
                                        </div>
                                    </div>
								</div>
							</div>	
							<div class="form-group nbCouchage-group">
								<label><?= __("Voyageurs") ?></label>
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
                                                <label class="font-weight-normal" for=""><?= __("Animaux Acceptés") ?></label>
                                            </div>
                                            <label class="switch ml-4">
                                                <input id="animaux" name="<?php echo $urlvaluemulti["animaux"]; ?>" type="checkbox">
                                                <span class="slider round shadow-sm"></span>
                                            </label>
                                        </div>
                                        </div>
                                    </div>
                                </div>                                
								<!-- <div class="row">
								    <div class="col-md-6 col-sm-12 pr-md-0 nbCouchage_ad">
								        <input class="p-0" id="nbCouchage_ad" name="<?php echo $urlvaluemulti['nbCouchage_ad']; ?>" data-prefix="<?= __('Adultes') ?>" value="1" min="1" step="1" type="number" />
								    </div>
								    <div class="col-md-6 col-sm-12 pl-md-0 mt-3 mt-md-0 nbCouchage_enf">
								        <input class="p-0" id="nbCouchage_enf" name="<?php echo $urlvaluemulti['nbCouchage_enf']; ?>" data-prefix="<?= __('Enfants') ?>" value="0" min="0" step="1" type="number" />
								    </div>
								</div> -->
                                <!-- <div class="p-2"> -->
                                <?php 
                                // echo $this->Form->input($urlvaluemulti["animaux"],[
                                //                     'id'=>'animaux',
                                //                     'label'=>false,
                                //                     'templates' => ['inputContainer' => "{{content}}"],
                                //                     'type'=>'checkbox',
                                //                     //'size'=>'auto',
                                //                     'hiddenField'=>false])?>
                                <!-- <label class="font-weight-normal" for="animaux"><?= __("Animaux Acceptés") ?></label>
                                </div> -->
							</div>
							<div class="form-group">
								<button type="submit" class="btn-search" id="recherchelogement"><?= __("Rechercher") ?></button>
							</div>
						<?php echo $this->Form->end()?>
					</div>
				</div>
                <div class="col-xl-7 col-lg-6 d-none d-lg-block ">
                    <?php if(in_array(date("m"),array('05','06','07','08'))){
                            if($this->Session->read('Config.language') == 'fr_FR') $mediaheaderimage = $mediaheader->lien_ete; else $mediaheaderimage = $mediaheader->_translations[$this->Session->read('Config.language')]->lien_ete;  
                        ?>
                        <picture>
                            <source srcset="<?php echo $this->Url->build('/',true).$mediaheaderimage;?>.webp" type="image/webp">
                            <source srcset="<?php echo $this->Url->build('/',true).$mediaheaderimage;?>.png" type="image/png">
                            <img class="img-fluid" src="<?php echo $this->Url->build('/').$mediaheaderimage;?>.png" >
                        </picture> 
                    <?php }else{ 
                        if($this->Session->read('Config.language') == 'fr_FR') $mediaheaderimagehiver = $mediaheader->lien_hiver; else $mediaheaderimagehiver = $mediaheader->_translations[$this->Session->read('Config.language')]->lien_hiver;  
                        ?>
                        <picture>
                            <source srcset="<?php echo $this->Url->build('/',true).$mediaheaderimagehiver;?>.webp" type="image/webp">
                            <source srcset="<?php echo $this->Url->build('/',true).$mediaheaderimagehiver;?>.png" type="image/png">
                            <img class="img-fluid" src="<?php echo $this->Url->build('/').$mediaheaderimagehiver;?>.png" >
                        </picture> 
                    <?php } ?>               
                </div>
			</div>
		</div>
							
	</div>
	<!--End Slide-->
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
                    <!-- <img width="65" src="<?php echo $this->Url->build('/')?>images/icon-home-land.png" class="img-responsive"> -->
                    </div>
					<div><?= __("Les meilleurs prix de la location de vacances de PAP en station de ski") ?></div>
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
                        <!-- <img width="65" src="<?php echo $this->Url->build('/')?>images/icon-land2.png" class="img-responsive"> -->
                    </div>
					<div><?= __("Activités et services vendus par des professionnels de la montagne vérifiés") ?></div>
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
                        <!-- <img width="65" src="<?php echo $this->Url->build('/')?>images/icon-land3.png" class="img-responsive"> -->
                    </div>
					<div><?= __("Paiement en ligne sécurisé de votre séjour montagne jusqu'à 4x sans frais") ?></div>
				</div>
	            </div>
			</div>
		
		</div>
	</div>
	<!-- End Section Infos -->
	<?= $this->fetch('content') ?>
	
<!--location_massif -->
<section class="bg-light py-5 loc-massif">
    <div class="container">
        <div class="row pb-5">
			<div class="col-12">
                <h2 class="text-center mb-5 h1"><?= __("Trouvez votre location de vacances par destination") ?></h2>
            </div>
            <div class="col-12">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">

                    <?php $i=1; foreach ($massifs as $massif) { ?>
                        <?php if($this->Session->read('Config.language') == 'fr_FR') $massifdescreption = $massif->descreption; else $massifdescreption = $massif->_translations[$this->Session->read('Config.language')]->descreption; ?>
                        <?php if($massif->image != ""){?>
                            <div class="carousel-item <?php if($i==1) echo "active"; ?>">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center">
                                        <img src="<?php echo $this->Url->build('/')?>img/uploads/<?php echo $massif->image; ?>" />
                                    </div>
                                    <div class="col-md-8">
                                        <h3 class="mb-4"><?php echo $massif->nom; ?></h3>
                                        <?php if($massifdescreption != "") ?><p class="pr-md-5"><?php echo $massifdescreption; ?></p>
                                        <?php if (in_array($massif->nom, $listeMassifStation)){
                                            if($massif->_translations[$this->Session->read('Config.language')]->nom_url) $massifUrl = $massif->_translations[$this->Session->read('Config.language')]->nom_url;
                                            else $massifUrl = $massif->nom_url;
                                            ?>
                                            <a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['massif'];?>/<?php echo $massifUrl ?>"><button type="button" class="btn btn-blue text-white rounded-0 px-5 mt-3"><?= __("Découvrir") ?></button></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; } ?>
                    <?php } ?>


                    </div>
                    <a class="carousel-control-prev text-left justify-content-start" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next text-right justify-content-end" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/location_massif -->
<section class="hebergement">
    <div class="container">
        <div class="row py-5">
            <div class="col-md-6">
                <img src="#" data-src="<?php echo $this->Url->build('/')?>images/ski-village-at-night.jpg" class="img-rounded mb-3">
                <h2 class="font-weight-bold py-3"><?= __("Location de vacances entre particuliers à la montagne") ?></h2>
                <p><?= __("Trouvez l’hébergement parfait pour vos prochaines <strong>vacances à la montagne</strong> en réservant vos prochaines <strong>vacances en station de ski</strong> sur Alpissime. Découvrez une vaste gamme d’hébergements, de l’appartement en centre de station au chalet pied des pistes. Les annonces de location proposées sur Alpissime sont vérifiées.") ?> </p>
            </div>
            <div class="col-md-6">
                <img src="#" data-src="<?php echo $this->Url->build('/')?>images/cours-de-ski-esf-alpissime.jpg" class="img-rounded mb-3">
                <h2 class="font-weight-bold py-3"><?= __("Réservez votre séjour au ski tout compris sur Alpissime") ?></h2>
                <p><?= __("Après avoir choisi l’hébergement idéal pour vos prochaines <strong>vacances en station de ski</strong>, ajoutez des activités et services vendus par les professionnels de votre station : location, cours et forfaits de ski, guides de haute montagne et bien plus encore ! Composez votre <strong>séjour à la carte</strong> pour des vacances inoubliables.") ?></p>
            </div>
        </div>
    <div>
</section>
<!--begin services section -->
<section id="services_prop" class="bg-light py-5">
    <div class="container">
        <div class="row">
			<div class="col-md-12">
				<h2 class="text-center h1"><?= __("Propriétaires - louez facilement avec les conciergeries Alpissime") ?></h2>
			</div>
		</div>
        <div class="row">
            
            <p class="w-100 text-center p-3"><?= __("Facilitez la gestion de votre hébergement en faisant confiance à des professionnels de la location - Accueil de vos locataires, remises de clés, suivi de la location durant le séjour, collecte de la taxe de séjour et vérification de l'inventaire. Les conciergeries Alpissime en station de ski représentent un intermédiaire de confiance pour vous et vos locataires.") ?></p>
        </div>
        <div class="row bloc_liste_service mt-5 mt-md-0">
            <div class="col-md-4">
                <div class="row">
                    <span class="col-auto">
                    <img src="#" data-src="<?php echo $this->Url->build('/')?>images/icon-blue.png" class="">
                    </span>
                    <div class="col">
                        <h3><?= __("Accueil et remise de clés") ?></h3>
                        <p><?= __("Check-in, check-out des locataires en station et remise de clés.") ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <span class="col-auto">
                    <img src="#" data-src="<?php echo $this->Url->build('/')?>images/icon-orange.png" class="">
                    </span>
                    <div class="col">
                        <h3><?= __("Ménages et inventaires") ?></h3>
                        <p><?= __("Ménages de départ ou de fin de saison et inventaire de contrôle.") ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <span class="col-auto">
                    <img src="#" data-src="<?php echo $this->Url->build('/')?>images/icon-rose.png" class="">
                    </span>
                    <div class="col">
                        <h3><?= __("Location de linge") ?></h3>
                        <p><?= __("Location de linge et prestations lit-fait pour faciliter la vie des locataires à l’arrivée.") ?></p>
                    </div>
                </div>
            </div>

        </div>
       
        <div class="row">
            <div class="col-md-12 col-xs-offset-3 text-center">
                <button class="btn btn-blue text-white rounded-0 px-5 mt-3" type="button" onclick="location.href='https://www.alpissime.com/fr-services-et-contrats-proprietaires-de-residences-secondaires/'">
                <?= __("En savoir plus") ?>
                </button>
            </div>
            <!-- /.col-md-12 -->
        </div>
        
    </div>
</section>
<!--end services section -->
<!-- Section magazine -->
<!-- Section conciergerie -->
<?php 
    if($this->Session->read('Config.language') == 'fr_FR') $mediabandeauimage = $mediabandeau->lien_ete; else $mediabandeauimage = $mediabandeau->_translations[$this->Session->read('Config.language')]->lien_ete;  
    if($mediabandeauimage != ""){ ?>
        <section class="concierge d-none d-md-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center"> 
                        <picture>
                            <source srcset="<?php echo $this->Url->build('/',true).$mediabandeauimage; ?>.webp" type="image/webp">
                            <source srcset="<?php echo $this->Url->build('/',true).$mediabandeauimage; ?>.jpg" type="image/jpg">
                            <img src="#" data-src="<?php echo $this->Url->build('/').$mediabandeauimage; ?>.jpg" class="w-100 my-5 img-rounded">
                        </picture>               
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section conciergerie -->
<?php
    }
?>
<?php 
// Get the JSON
$json = file_get_contents('https://www.alpissime.com/blog/wp-json/wp/v2/posts?_embed&per_page=3');
// Convert the JSON to an array of posts
$posts = json_decode($json);
?>
<?php if(count($posts) > 0 && $language_header_name == "fr"){ ?>
<section id="magazine">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-5 ">
                <h2 class="text-center h1"><?= __("Découvrez le magazine Alpissime") ?></h2>
                <a href="<?php echo BLOG_ALPISSIME ?>" class="float-right font-weight-500 mt-n4 mt-sm-3 mt-md-n4 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
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
			<div class="col-md-12 text-center">
				<h2 class="h1"><?= __("Pourquoi réserver vos vacances à la montagne avec Alpissime ?") ?></h2>
                <p class="p-3"><?= __("Alpissime vous propose un large choix de location entre particuliers ou en résidence de tourisme pour vos prochaines <strong>vacances au ski</strong>.Réservez un appartement au centre de votre station de ski préférée, un <strong>chalet au pied des pistes</strong> pour des vacances à la montagne inoubliables. Choisissez sur la marketplace Alpissime les activités qui vous correspondent : location de skis, cours de ski, forfaits, randonnées avec un guide de haute montagne et bien d’autres pour composer votre <strong>séjour au ski tout compris</strong>.") ?></p>
                <button class="btn btn-blue text-white rounded-circle collapse-button-chevron p-0" type="button" data-toggle="collapse" data-target="#collapsePourquoi" aria-expanded="false" aria-controls="collapsePourquoi">
                <i class="fa fa-chevron-up font-size-small"></i>
                <i class="fa fa-chevron-down font-size-small"></i>
                </button>
			</div>
            <div class="collapse bg-white m-3 p-3 p-md-5" id="collapsePourquoi">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="font-weight-bold py-3 h2"><?= __("Location de vacances entre particuliers - réservez vos plus belles vacances montagne sur Alpissime") ?></h3>
                    <p><?= __("Vous organisez votre location de vacances à la montagne ? Ne cherchez plus ! Alpissime vous propose une sélection vérifiée pour votre <strong>location de vacances de particuliers à particuliers à la montagne</strong>. Réservez un appartement au ski ou un chalet pied des pistes entre particuliers pour vos prochaines <strong>vacances d’hiver</strong> en famille. Que vous soyez un adepte des <strong>vacances à la montagne</strong> pour noël, d’une semaine de ski pour les vacances d’hiver ou d’un court séjour pour un week-end à la montagne, les propriétaires qui louent entre particuliers sur Alpissime vous proposent des hébergements de qualité, vérifiés et à bas prix.") ?></p>
                    <h3 class="font-weight-bold py-3 h2"><?= __("Location de vacances entre particuliers pour des vacances au ski inoubliables") ?></h3>
                    <p><?= __("Redécouvrez les joies du ski et profitez des sports d’hiver en réservant des <strong>vacances en station de ski</strong>. Alpissime vous propose des formules de location de vacances à la carte. Simplifiez l’organisation de votre séjour à la montagne : réservez votre location de vacances entre particulier et composez votre <strong>séjour au ski tout compris</strong> en réservant location de skis, cours de ski, forfaits et bien d’autres activités en station de sports d’hiver pour un séjour au ski tout compris.") ?> </p>
                    <h3 class="font-weight-bold py-3 h2"><?= __("Vacances d’hiver en famille dans les plus belles stations de ski de France") ?></h3>
                    <p><?= __("Profitez de vacances en famille dans les Alpes du Nord : rendez-vous sur Alpissime pour réserver votre location de vacances aux Arcs, à la Plagne, Peisey Vallandry ou Montchavin Les Coches pour des vacances dans le domaine Paradiski. Découvrez l’espace Killy avec les stations de Tignes et Val d’Isère. Profitez des 3 vallées dans les stations de Meribel, Courchevel ou Val Thorens. Partagez des moments inoubliables lors de vacances d’hiver en famille et retrouvez-vous dans les stations de Pralognan la Vanoise, La Clusaz. Prenez un bol d’air frais ensoleillé en découvrant le ski dans les alpes du sud avec la station du Val d’Allos, de Pra Loup, les Orres ou encore Serre-Chevalier.") ?></p>
                </div>
                <div class="col-md-6">
                    <h3 class="font-weight-bold py-3 h2"><?= __("Vacances au ski pas cher : réservez dès maintenant vos prochaines vacances à la montagne") ?></h3>
                    <p><?= __("Faîtes des économies sur la réservation de vos prochaines <strong>vacances au ski</strong> en réservant un séjour pas cher à la montagne entre particuliers. Économisez sur la réservation de vos activités grâce à nos partenariats en station de ski. Les commerçants de montagne vous proposent des activités et services à prix réduit ! Profitez de <strong>vacances au ski pas cher</strong> en réservant votre appartement entre particuliers sur Alpissime et bénéficiez de réduction sur votre location au ski : matériel, forfaits de ski et cours de ski.") ?> </p>
                    <h3 class="font-weight-bold py-3 h2"><?= __("Location ski tout compris : location de vacances, activités en station au meilleur prix") ?></h3>
                    <p><?= __("Alpissime vous propose une sélection des meilleures locations de <strong>chalet montagne entre particuliers, location d’appartements au ski</strong> pour la semaine ou le week-end pour un séjour ski tout compris réussi ! Retrouvez sur notre marketplace les produits, services et activités vendus par vos commerçants et professionnels en station. Réservez votre <strong>location au ski pas cher</strong> en ajoutant à votre réservation des cours de ski, location de skis, forfaits, randonnées avec des guides de haute montagne. L’été, profitez d’activités à la montagne avec des descentes en VTT, des activités d’eaux vives avec du rafting ou de l’hydrospeed. L’hiver, pendant que les parents profitent des pistes de ski, les enfants s’amusent avec des activités dédiées. ") ?></p>
                    <h3 class="font-weight-bold py-3 h2"><?= __("Montagne vacances - Le meilleur choix de destination pour votre prochain séjour") ?></h3>
                    <p><?= __("Découvrez ou redécouvrez les joies des stations de ski : baladez-vous sur le front de neige pendant que les enfants s’améliorent grâce aux cours de ski proposés par des moniteurs certifiés. Les vacances d’hiver en famille à la montagne vous permettent de créer des souvenirs inoubliables. Profitez d’un <strong>séjour au ski tout compris</strong> en composant à la carte vos prochaines vacances selon vos envies.") ?></p>
                </div>
            </div>
            </div>
		</div>
    </div>
</section>
<!-- End Section pourquoi alpissime -->
<!-- Section partners -->
<section id="partners" class="mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center text-md-left">
                <h2 class="title-newsletter pb-3"><?= __("Nos partenaires") ?></h2>
            </div>
			<div class="col-md-12">
                <div class="regular slider">
                    <?php foreach ($stations as $station_liste) { 
                        foreach ($station_liste['lieugeos'] as $station) {
                            if($station->image != ''){ ?>
                            <div >
                                <picture>
                                    <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.webp" type="image/webp">
                                    <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.png" type="image/png">
                                    <img alt="Partenaire <?php echo $station->name;?>" src="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.png"/>
                                </picture>
                            </div>
                        <?php } 
                        } 
                    } ?>

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
<!-- End Section partners -->
<!--Bottom first -->
<section id="bottom-first" class="mt-5 bg-light py-5 border-top">
    <!--Container-->
    <div class="container">
        <!--row-->
        <div class="row">
            <div class="col-md-5 col-lg-4">
                <div class="newsletter">
                    <h2 class="title-newsletter"><?= __("Inscrivez-vous à notre newsletter") ?></h2>
                </div>
            </div>
            <div class="col-md-7 col-lg-4">
                <div class="newsletter">

                    <?php echo $this->Form->create(null, ['url' => ['controller' => 'subscriptions', 'action' => 'subscribe'], 'class' => ['form-inline form_newsletter']]);?>
                        <div class="form-group">
                            <?php echo $this->Form->input('emailinscription',["label"=>false,'type'=>'text','templates' => ['inputContainer' => "{{content}}"],'placeholder'=>__('Email'), 'class'=>'form-control rounded-0'])?>
                        </div>
                        <button type="button" class="btn btn-blue text-white rounded-0" onclick="newslettreinscri()"><?= __("Je m'inscris !") ?></button>
                        
                    <?php echo $this->Form->end()?>
                </div>
            </div>
            <!--/newsletter-->
            <div class="col-md-12 col-lg-4">
                <ul class="list-inline float-lg-right float-left mt-3 mt-md-0 btn-sociaux">
                    <li><a href="https://www.facebook.com/Alpissime/" target="_blank"><i class="fa fa-facebook"></i></a></li>
					<li><a href="https://www.instagram.com/alpissime_vacances" target="_blank"><i class="fa fa-instagram"></i></a></li>
					<li><a href="https://twitter.com/alpissime" target="_blank"><i class="fa fa-twitter"></i></a></li>
					<li><a href="https://www.youtube.com/user/alpissime" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
					<li><a href="https://www.linkedin.com/company/alpissime" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="https://www.pinterest.com/alpissime/pins/" target="_blank"><i class="fa fa-pinterest-p"></i></a></li>
                    <!-- <li><a href="skype:alpissime?call"><img data-src="<?php echo $this->Url->build('/')?>images/ico/skype.png" src="#" alt="Skype"></a></li> -->
                  </ul>
            </div>
            <!--/social icon-->
        </div>
        <!--/row-->
    </div>
    <!--/container-->
</section>
<!--End Bottom first -->
<!-- popup newslettre -->
<div class="modal" id="popup_newslettre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      <span class="orange h1modal text-center"><?= __("Inscription Newsletter") ?></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body">
        <div class="col-md-12 text-center">          
            <p><?= __("Votre inscription à notre newletter a bien été prise en compte, nous vous remercions pour votre confiance.") ?></br></p>
        </div>
      </div>
      <div class="modal-footer">
            <div class="pull-right">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>          
            </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END popup newslettre -->
<!--Footer-->
<footer id="bottom" class="bg-light">
    <!--Container-->
    <div class="container">
	<hr class="mt-0">
        <div class="bottom">
            <!--row-->
            <div class="row py-5">
				<div class="col-md-6 col-lg-3 ">
                    <a class="d-flex align-items-center mt-4 mx-3" href="<?php echo $this->Url->build('/').$urlLang; ?>">
                    <?php if($this->Session->read('Config.language') == 'fr_FR') $medialogoimage = $medialogo->lien_ete; else $medialogoimage = $medialogo->_translations[$this->Session->read('Config.language')]->lien_ete;  ?>
                    <picture>
                        <source srcset="<?php echo $this->Url->build('/',true).$medialogoimage;?>.webp" type="image/webp">
                        <source srcset="<?php echo $this->Url->build('/',true).$medialogoimage;?>.png" type="image/png">
                        <img class="img-fluid" src="<?php echo $this->Url->build('/').$medialogoimage;?>.png" >
                    </picture> 
                    <!-- <svg aria-hidden="true" width="276" height="40" viewBox="0 0 1108.26 163.66">
                        <use xlink:href="<?php // echo $this->Url->build('/')?>images/svg/logo-couleur-alpissime-baseline.svg#Calque_2"></use>
                    </svg>  -->
					</a>
                    <img src="<?php echo $this->Url->build('/')?>images/ico/reassurance-voyage-alpissime-agent-de-voyage-apst-entreprises-du-voyage-atout-france-DESKTOP.png" class="img-fluid pb-5 pt-3 d-none d-md-block d-lg-block" alt="reassurance voyage alpissime agent de voyage apst entreprises du voyage atout france DESKTOP">
					<img src="<?php echo $this->Url->build('/')?>images/ico/reassurance-voyage-alpissime-agent-de-voyage-apst-entreprises-du-voyage-atout-france-MOBILE.png" class="img-fluid pb-5 pt-3 d-block d-md-none d-lg-none" alt="reassurance voyage alpissime agent de voyage apst entreprises du voyage atout france mobile">
				</div>


                <!--Information-->
                <div class="col-md-6 col-lg-3 mt-3 mt-md-0">
                    <h3><?= __("A propos") ?></h3>
                    <div>
                        <ul id="li_bottom_1" class="list-unstyled">
                            <?php if($this->Session->read('Config.language') == 'fr_FR') { ?>
                                <li>
                                    <a href="<?php echo BLOG_ALPISSIME ?>/qui-sommes-nous" target="_blank"><?= __("Qui sommes nous ?") ?></a>
                                </li>
                            <?php } ?>                            
                            <li>
                                <a href="<?php echo BOUTIQUE_ALPISSIME?>/" target="_blank"><?= __("Les services") ?></a>
                            </li>
                            <li>
                                <a href="<?php echo $this->Url->build('/').$urlLang;?>"><?= __("Accueil") ?></a>
                            </li>
                            <li>
                                <a href="<?php echo BLOG_ALPISSIME ?>" target="_blank"><?= __("Actualités en station") ?></a>
                            </li>
                            <li>
                                <a href="<?php echo $this->Url->build('/').$urlLang;?>recherche" target="_blank"><?= __("Les appartements") ?></a>
                            </li>
                            <?php if($this->Session->read('Config.language') == 'fr_FR') { ?>
                            <li>
                                <a href="https://marketing.alpissime.com/Publicite/" target="blank"><?= __("Publicités") ?></a>
                            </li>
                            <li>
                                <a href="<?php echo BOUTIQUE_ALPISSIME; ?>fr/devenir-partenaire" target="blank"><?= __("Devenir Vendeur") ?></a>
                            </li>
                            <?php } ?> 
                        </ul>
                    </div>
                    
                </div>
                <!--End Information-->

                <!--Services clients-->
                <div class="col-md-6 col-lg-3">
                <h3><?= __("Service client") ?></h3>
                <div>
                    <ul id="li_bottom_2" class="list-unstyled">
                        <li><a href="https://help.alpissime.com" target="_blank"><?= __("Centre d'aide") ?></a></li>
                        <li><a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['annonces']; ?>/contact" target="_blank"><?= __("Contact") ?></a></li>
                        <li><a href="<?php echo BLOG_ALPISSIME?>/conditions-generales-dutilisation-alpissime-com-2/" target="_blank"><?= __("CGU Alpissime.com") ?></a></li>
                        <li><a href="<?php echo BOUTIQUE_ALPISSIME; ?>fr/conditions-generales-de-vente-marketplace-alpissime" target="_blank"><?= __("CGV Marketplace") ?></a></li>
                        <li><a href="<?php echo BLOG_ALPISSIME?>/politique-de-confidentialite/" target="_blank"><?= __("Politique de confidentialité") ?></a></li>
                        <li><a href="<?php echo BLOG_ALPISSIME?>/mentions-legales" target="_blank"> <?= __("Mentions légales") ?></a></li>	
                        
                    </ul>
                </div>
                    
                </div>
                <!--End Services clients-->

                <!--Extras-->
                <div class="col-md-6 col-lg-3 ">
                    <h3><?= __("Informations") ?></h3>
                    <div>
                        <ul id="li_bottom_3" class="list-unstyled">
                          <li><a href="<?php  echo $this->Url->build('/'); ?>sitemap" target="_blank"><?= __("Site map Alpissime.com") ?></a></li>
                          <li><a href="<?php echo BOUTIQUE_ALPISSIME?>/fr/site-map/" target="_blank"><?= __("Site map Marketplace") ?></a></li>
                          <li><a href="<?php echo BLOG_ALPISSIME?>/lexique-de-la-location-sur-alpissime-com" target="blank"> <?= __("Lexique de la location saisonnière") ?></a></li>
						  <li>
                            <a href="<?php echo $this->Url->build('/',true).$urlLang;?>routes" target="blank"><?= __("Routes") ?></a>
                          </li>                        
                        </li>
                          </li>                        
                        </ul>
                    </div>
                </div>
                <!--Extras-->
            </div>

        </div>
        <hr class="mt-0 d-none d-md-block d-lg-block">
        <?php if($this->Session->read('Config.language') == 'fr_FR') $mediapaiementdesktopimage = $mediapaiementdesktop->lien_ete; else $mediapaiementdesktopimage = $mediapaiementdesktop->_translations[$this->Session->read('Config.language')]->lien_ete;  ?>
        <picture>
            <source srcset="<?php echo $this->Url->build('/',true).$mediapaiementdesktopimage;?>.webp" type="image/webp">
            <source srcset="<?php echo $this->Url->build('/',true).$mediapaiementdesktopimage;?>.png" type="image/png">
            <img class="img-fluid pb-5 pt-3 d-none d-md-block d-lg-block" src="#" data-src="<?php echo $this->Url->build('/').$mediapaiementdesktopimage;?>.png" >
        </picture>
		<?php if($this->Session->read('Config.language') == 'fr_FR') $mediapaiementmobileimage = $mediapaiementmobile->lien_ete; else $mediapaiementmobileimage = $mediapaiementmobile->_translations[$this->Session->read('Config.language')]->lien_ete;  ?>
        <picture>
            <source srcset="<?php echo $this->Url->build('/',true).$mediapaiementmobileimage;?>.webp" type="image/webp">
            <source srcset="<?php echo $this->Url->build('/',true).$mediapaiementmobileimage;?>.png" type="image/png">
            <img class="img-fluid pb-5 pt-3 d-block d-md-none d-lg-none" src="#" data-src="<?php echo $this->Url->build('/').$mediapaiementmobileimage;?>.png" >
        </picture>
		<!-- <img src="<?php // echo $this->Url->build('/')?>images/ico/PAIEMENT-SECURISE-DESKTOP.png" class="img-fluid pb-5 pt-3 d-none d-md-block d-lg-block" alt="paiement securise"> -->
        <!-- <img src="<?php // echo $this->Url->build('/')?>images/ico/paiement-securise-mobile.png" class="img-fluid pb-5 pt-3 d-block d-md-none d-lg-none" alt="paiement securise mobile">    -->

         </div>
        <!--/row-->
    <!--/container-->
	</footer>
<!--End Footer-->
<?php if($affiche_alert == "oui"){ ?>
<div id="message" class="container">
    <div id="inner-message" class="alert alert-warning alert-reserv-attente alert-dismissible fade show mb-0">
        <img class="img-responsive mr-2" src="#" data-src="<?php echo $this->Url->build('/')?>images/icon/alpissime_icon_png.png" /><strong><?= __("Vous avez une réservation en attente.") ?></strong> <u><a href="<?php echo BOUTIQUE_ALPISSIME.$station_annonce; ?>" target="_blank"><?= __("Cliquez ici") ?></a></u> <?= __("pour la finaliser") ?>.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>	
</div>
<?php } ?>					
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?php echo $this->Url->build('/')?>js/new/jquery-3.4.1.slim.min.js"></script>
<!-- jQuery library -->
<script src="<?php echo $this->Url->build('/')?>js/new/jquery.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/jquery-ui.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/popper.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/bootstrap.min.js"></script>

<script src="<?php echo $this->Url->build('/')?>js/slick.min.js"></script>

<!-- <script async src="//platform.twitter.com/widgets.js"></script> -->

<script src="<?php echo $this->Url->build('/')?>js/datepicker.fr.min.js" type="text/javascript"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/bootstrap-input-spinner.min.js" type="text/javascript"></script>

<?php echo $this->Html->script(['jquery.lazy.min.js', 'jquery.lazy.plugins.min.js'])?>
<!-- UIkit JS -->
<script defer src="<?php echo $this->Url->build('/')?>js/new/uikit.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/uikit-icons.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/custom.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/moment.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/item-quantity-dropdown.min.js"></script>

<script>


$(window).on('load',function() {
    $("img").Lazy();
});
</script>

<script>
function detecter_device() {
  var userAgent = navigator.userAgent || navigator.vendor || window.opera;
	  // Windows Phone must come first because its UA also contains "Android"
	// if (/windows phone/i.test(userAgent)) {
	//     return "Windows Phone";
	// }
	if (/android/i.test(userAgent)) {
		window.open(
			'https://play.google.com/store/apps/details?id=com.alpissime.app',
			'_blank' // <- This is what makes it open in a new window.
		);
		//window.location.href = "https://play.google.com/store/apps/details?id=com.alpissime.app";
		//return "Android";
	}
	// iOS detection from: http://stackoverflow.com/a/9039885/177710
	if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
		window.open(
			'https://apps.apple.com/fr/app/alpissime/id518322529',
			'_blank' // <- This is what makes it open in a new window.
		);
		//window.location.href = "https://apps.apple.com/fr/app/alpissime/id518322529";
	}
	window.open(
		'https://play.google.com/store/apps/details?id=com.alpissime.app',
		'_blank' // <- This is what makes it open in a new window.
	);
	//window.location.href = "https://play.google.com/store/apps/details?id=com.alpissime.app";
}

function newslettreinscri()
{
	$.ajax({
		type: "POST",
		dataType : 'json',
		async: true,
		url: "<?php echo $this->Url->build('/',true)?>annonces/inscriptionnewslettre",
		data: {email: $("#emailinscription").val()},
		success:function(xml){  
			$("#emailinscription").val("");          
			if(xml.result == "OK") $("#popup_newslettre").modal('show', {backdrop: 'static', keyboard: false});
		}
	});
}
function renvoyermail(){
	$.ajax({
		type: "POST",
		dataType : 'json',
		url: "<?php echo $this->Url->build('/',true)?>utilisateurs/renvoiemailconfirmation/",
		data: {email: '<?php echo $_SESSION['emailconfirmation']; ?>'},
		success:function(xml){                
		$('.renvoiemessage').addClass('hidden');           
		}
	});
}

<?php if($this->Session->read('Auth.User')){ ?>
get_nbmessage();
<?php } ?>
function get_nbmessage(){                        
	$.ajax({
		type: "POST",
		dataType : 'json',
		url: "<?php echo $this->Url->build('/',true);?>utilisateurs/getnbmessage/",
		success:function(xml){
			$('.nbr-msg').html(xml);
		},
		complete:function(){
			setTimeout("get_nbmessage();",5000);
		}
	});
}
$('#animaux').change(function () {
    if($('#animaux').is(":checked")){
        $('#animaux').val(1);
    }else{
        $('#animaux').val(0);
    }
});
$('body').on('click',function(event){
  if(!$(event.target).is('.iqdropdown-selection') && !$(event.target).is('#animaux')){
    $(".iqdropdown").removeClass("menu-open")
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
            // if(id == 'animaux'){
            //   console.log("on est la");
            //   $('#apporteranimauxhidden').val(count);
            //   calculertotalprixperiode(<?php echo $annonce->id?>, $('#location_du').val()+"/"+$('#location_au').val(), $('#nbradultehidden').val(), $('#nbrenfanthidden').val());
            // } 
        },
    });


    var utilisateurconnecte = "<?php echo $this->Session->read('Auth.User.nature') ?>";
	var utilisateurvalid = "<?php echo $this->Session->read('Auth.User.valide_at') ?>";
	if(utilisateurvalid != "") $(".notvalidiv").css("display", "none");
	else if(utilisateurconnecte != "" && utilisateurvalid == "") $(".notvalidiv").css("display", "block");
	else $(".notvalidiv").css("display", "none");

$(".hdivclick").click(function(){
        $(".collapse.in").toggle();
        $(".collapse.in").removeClass('in');
        $(this).next().toggle();
	});
	
	$('.regular').slick({
   slidesToShow: 4,
   slidesToScroll: 1,
   autoplay: true,
   autoplaySpeed: 1000,
   responsive: [
     {
       breakpoint: 1024,
       settings: {
         slidesToShow: 3,
         slidesToScroll: 1,
         infinite: true,
         dots: true
       }
     },
     {
       breakpoint: 600,
       settings: {
         slidesToShow: 2,
         slidesToScroll: 1
       }
     },
     {
       breakpoint: 480,
       settings: {
         slidesToShow: 1,
         slidesToScroll: 1
       }
     }
     // You can unslick at a given breakpoint now by adding:
     // settings: "unslick"
     // instead of a settings object
   ]
 });
		
		
		

 $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);
 $('#location_du').datepicker({
        language: 'fr-FR',
        minDate: 1,
        dateFormat: "dd-mm-yy"
    });
    $('#location_du').on( "change", function() {
        var d = moment(this.value,"DD-MM-YYYY").add(1, 'd');
        $('#location_au').datepicker( "option", "minDate", d.format('DD-MM-YYYY') );
    });
    $('#location_au').datepicker({
        language: 'fr-FR',
        minDate: 1,
        dateFormat: "dd-mm-yy"
    });

// $("#nbCouchage_ad").inputSpinner({
// 	id: "nbCouchage_adulte"
// });
// $("#nbCouchage_enf").inputSpinner({
// 	id: "nbCouchage_enfant"
// });
});

if($("#lieugeo").val() != 0) get_village($("#lieugeo").val());
function get_village(id){
  if(id!='' && id!=0)
    {
      $('#village').empty().prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Url->build('/',true)?>manager/village/getStationVillagesWithAnnonces/"+id,
            dataType : 'json',
            success:function(data){
              valvillage = 0;
              <?php if(isset($this->request->query['village'])){ ?>
                valvillage = <?php echo $this->request->query['village']; ?>;
              <?php } ?>
              if(data.length > 1){
                $('#village').append('<option value="0"><?= __("Tous les villages") ?></option>');
                $.each(data,function(i,val){
                    if(valvillage == val.id) selectedval = "selected";
                    else selectedval = "";
                    $('#village').append('<option value=' + val.id + ' ' + selectedval + '>' + val.name + '</option>');
                });
                $("#villagediv").css("display", "block");
              }else{
                $("#villagediv").css("display", "none");
              }
              
            },
            complete:function(){
              $('#village').prop('disabled', false).trigger('change');
            }
        });
    }else{
        $("#villagediv").css("display", "none");
    }
}
</script>
</body>
</html>							