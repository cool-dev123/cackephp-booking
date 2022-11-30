<!doctype html>
<html lang="fr">
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
<?php } ?>

<!-- Start cookieyes banner -->
<script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/42f3745ec212b55224e20de6.js"></script>
<!-- End cookieyes banner --> 

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if($this->Session->read('Config.language') == 'fr_FR') $preposition_a = $station->preposition_a; else $preposition_a = $station->_translations[$this->Session->read('Config.language')]->preposition_a; ?>
	<title><?= __('Vacances {0} {1} | Séjour ski à la carte sur Alpissime.com', [$preposition_a, $station->name]); ?> </title>
	<meta name="description" content="<?= __('Réservez vos vacances {0} {1} sur Alpissime | 🏘 Hébergements vérifiés ⛷ Activités en station ⭐️ Services de conciergerie | Paiement 4x sans frais', [$preposition_a, $station->name]); ?>">
	<meta name="keywords" content="<?= __('location, appartement, hébergement, studio, séjour, vacances, montagne, les Arcs, Bourg Saint Maurice, Savoie, Alpes, Paradiski, hiver, ski, été, vtt') ?>">
	<meta name="viewport" content="width=device-width, minimal-ui">
	
    <?php echo $this->fetch('meta'); ?>
    
    <meta property="og:title" content="<?= __('Vacances {0} {1} | Séjour ski à la carte sur Alpissime.com', [$preposition_a, $station->name]); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
    <?php if(in_array(date("m"),array('05','06','07','08'))){
     $contentimg = $this->Url->build('/',true).'images/og_images/alpissime-locations-entre-particuliers-montagne-été-og.jpg';
        echo $this->Html->meta(null, null, ['property' => 'og:image','content' => $contentimg]); 
	 }else{ 
     $contentimg = $this->Url->build('/',true).'images/og_images/alpissime-locations-entre-particuliers-sejour-ski-vacances-hover-og.jpg';
        echo $this->Html->meta(null, null, ['property' => 'og:image','content' => $contentimg]); 
	 } ?>

<link rel="canonical" href="<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
    <?php if($language_header_name == "en"){
        $urlorig = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $urlorig = str_replace("/en/","/",$urlorig);
        $urlorig = str_replace("/resort","/station",$urlorig);
         ?>

        <link rel="alternate" hreflang="fr" href="<?php echo $urlorig; ?>" />
        <link rel="alternate" hreflang="en" href="<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
    <?php }else{ 
        $urlorig = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $urlorig = str_replace($_SERVER['SERVER_NAME'],$_SERVER['SERVER_NAME']."/en",$urlorig);
        $urlorig = str_replace("/station","/resort",$urlorig);
    ?>
        <link rel="alternate" hreflang="fr" href="<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
        <link rel="alternate" hreflang="en" href="<?php echo $urlorig; ?>" />
    <?php }  ?>
	
	<?php
	header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	?>
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo $this->Url->build('/')?>css/new/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->Url->build('/')?>css/new/bootstrap-grid.min.css">
	<link href="<?php echo $this->Url->build('/')?>css/new/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->Url->build('/')?>css/slick.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo $this->Url->build('/')?>css/slick-theme.min.css"/>
      <!-- UIkit CSS -->
      <link rel="stylesheet" href="<?php echo $this->Url->build('/')?>css/new/uikit.css" />
	<link rel="stylesheet" href="<?php echo $this->Url->build('/')?>css/new/style.css">
	
	<link href='https://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $this->Url->build('/')?>css/item-quantity-dropdown.min.css">
	
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
    .header_landing_page {
        <?php if(in_array(date("m"),array('05','06','07','08'))){
            if($station->image_header_ete != '') echo "background: url(".$this->Url->build('/')."images/header_station/".$station->image_header_ete.") no-repeat;";
        }else{ 
            if($station->image_header_hiver != '') echo "background: url(".$this->Url->build('/')."images/header_station/".$station->image_header_hiver.") no-repeat;" ;
        } ?>
        background-size: cover;
        background-position: 0 69%;
    }
    
    div#header_landing_page {
        height: 460px;
    }
    .card{
        height: 100%;
    }
    .colorblue{
        color: #0099ff;
        border-color: #0099ff!important;
    }
    .text-header{
        padding-top: 10%;
        height: 100%;
        background: rgba(0,0,0,.2);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.32);
    }  
    /* .pisteCircle{
        /* padding: 0px 11px 0px 11px; */
       /* height: 22px;
        width: 22px;
        display: inline-block;
    } */
    .pisteCircle::before{
        content: '';
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
    @media screen and (max-width: 720px) {
        .paddingMap{
            padding: 0px 10px 0px 10px;
        } 
        .domaineSki{
            margin: 0px -7px 0px -7px;
        }
    } 
    #magazine h3{
        height: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    #magazine .thumbnail .caption {
        justify-content: normal;
    }
    #partners {
        height: 150px;
    }
    </style>
	
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	
	ga('create', 'UA-30433929-1', 'auto');
	ga('send', 'pageview');
	
	</script>
</head>
<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PXZVFPZ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<div class="container-fluid notvalidiv" style="display:none;">
		<div class="row">
			<div class="col">
				<?= __("Votre compte est limité, vous devez activer votre adresse email !") ?></br><a href='#' onclick="renvoyermail()" style="color:#fea;"><?= __("Renvoyer un mail de confirmation") ?></a>
			</div>
		</div>
	</div>		
	<!--Header-->
	<?php echo $this->element('headerdiv'); ?>
	<!--End Header-->
	<!--Slide-->
	
    <?php if(in_array(date("m"),array('05','06','07','08')) && $station->image_header_ete == ''){ ?>
	    <div id="header_landing_page" class="header_landing_page_ete">
    <?php }else{ ?>
	    <div id="header_landing_page" class="header_landing_page">
	<?php } ?>

	<div id="header_landing_page" class="header_landing_page">
        <div class="text-center text-header">
            <h1 class="text-white display-4 font-weight-bold"><?php echo $station->name; ?></h1>
            <h2 class="text-white"><?php echo $station['massif']['nom']; ?> <?php if(!empty($station['domaine'])) echo "> ".$station['domaine']['nom']; ?></h2>
        </div>							
	</div>
	<!--End Slide-->
	
	<?php echo $this->fetch('content') ?>

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

<div class="container p-0">
<!-- <div class="col-lg-10 offset-lg-1"> -->
<?php echo $this->element("menu_recherche_station")?>
<!-- </div> -->
</div>
<?php if(count($annonces) > 0) { ?>
<section class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-4 ">
                <h2 class="text-center h1"><?= __("Locations de vacances") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->preposition_a; else echo $station->_translations[$this->Session->read('Config.language')]->preposition_a; ?> <?php echo $station->name; ?></h2>
            </div>
            <div class="col-12 mt-lg-n5 text-center">
                <a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>?<?php echo $urlvaluemulti['lieugeo']; ?>=<?php echo $station->id; ?>" class="float-lg-right font-weight-500 mt-lg-n3 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
		</div>
        <div class="annonce block products row">

        <?php  $c=0; foreach($annonces as $ann) { ?>
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
<!--/annonces_location -->
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
        <?php if($station->description_api != ""){ ?>
        <div class="row mb-3">             
            <p class="w-100 p-3">
                <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->description_api; else echo $station->_translations[$this->Session->read('Config.language')]->description_api; ?>
                <!-- <br>Facilitez la gestion de votre hébergement en faisant confiance à des professionnels de la location - Accueil de vos locataires, remises de clés, suivi de la location durant le séjour, collecte de la taxe de séjour (optionnel) et vérification de l'inventaire. Les conciergeries Alpissime en station de ski représentent un intermédiaire de confiance pour vous et vos locataires. -->
            </p>
            <?php if(in_array(date("m"),array('05','06','07','08')) && ($station->description_ete!="" || $station->description_act_ete!="")){ ?>
            <div class="col-md-12 text-center">
                <button class="btn btn-blue text-white rounded-circle collapse-button-chevron p-0" type="button" data-toggle="collapse" data-target="#collapseDescription" aria-expanded="false" aria-controls="collapseDescription">
                    <i class="fa fa-chevron-up font-size-small"></i>
                    <i class="fa fa-chevron-down font-size-small"></i>
                </button>
            </div>
            <?php }else if($station->description_hiver != "" || $station->description_act_hiver != ""){ ?>
            <div class="col-md-12 text-center">
                <button class="btn btn-blue text-white rounded-circle collapse-button-chevron p-0" type="button" data-toggle="collapse" data-target="#collapseDescription" aria-expanded="false" aria-controls="collapseDescription">
                    <i class="fa fa-chevron-up font-size-small"></i>
                    <i class="fa fa-chevron-down font-size-small"></i>
                </button>
            </div>
            <?php } ?>
        </div>  
        <?php } ?>      
        <div class="collapse bg-white m-3 p-3 p-md-5" id="collapseDescription">
            <div class="row">
                <p class="px-2">
                <?php 
                if(in_array(date("m"),array('05','06','07','08'))){
                    if($this->Session->read('Config.language') == 'fr_FR') echo $station->description_ete."<br>".$station->description_act_ete; 
                    else echo $station->_translations[$this->Session->read('Config.language')]->description_ete."<br>".$station->_translations[$this->Session->read('Config.language')]->description_act_ete;
                }else{
                    if($this->Session->read('Config.language') == 'fr_FR') echo $station->description_hiver."<br>".$station->description_act_hiver; 
                    else echo $station->_translations[$this->Session->read('Config.language')]->description_hiver."<br>".$station->_translations[$this->Session->read('Config.language')]->description_act_hiver;
                }  
                ?>
                    <!-- <br>Alpissime, plateforme de location entre particuliers en station de ski, a été choisi par le Val d’Allos (Office de Tourisme, Consortium Synergix regroupant la Compagnie de Remontées Mécaniques, l'association de propriétaires AIRFA ainsi que l'association des commerçants ANIMAFOUX) comme plateforme officielle de réservation de vacances de la station. Que vous préfériez pour vos vacances un appartement en centre station ou un chalet au pied des pistes, réservez vos prochaines vacances à la carte sur Alpissime. Retrouvez également sur la Marketplace les activités et services vendus par les professionnels de la station. -->
                </p>
            </div>
        </div>        
        <div class="row mt-5 mt-md-0 paddingMap">
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

            <div class="col-md-8 pr-0 pl-2 pl-lg-1 pr-2 pr-md-0 pr-lg-0">
                <div class="card bg-white shadow rounded border-0">
                    <div class="card-body">
                        <h3><?= __("Accessibilité") ?> :</h3>
                        <p><?php if($this->Session->read('Config.language') == 'fr_FR') echo nl2br($station->description_acc);else echo nl2br($station->_translations[$this->Session->read('Config.language')]->description_acc); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-12 mt-5 mb-3">
                <h2 class="text-center h1"><?php echo $station->name; ?> - <?= __("Webcam et Galerie photo") ?></h2>
            </div>
            <?php 
                if(in_array(date("m"),array('05','06','07','08'))){
                    $srcWebcams = $this->Url->build('/',true)."images/webcams-ete.jpg";
                    $srcGalerie = $this->Url->build('/',true)."images/galerie-photo-ete.jpg";
                }else{
                    $srcWebcams = $this->Url->build('/',true)."images/webcams.jpg";
                    $srcGalerie = $this->Url->build('/',true)."images/galerie-photo.jpg";
                }
            ?>
            <div class="col-md-6 pl-0 pr-2 pr-lg-1 pl-2 pl-lg-0 mb-1 mb-lg-0 rounded"> 
                <div class="card shadow rounded border-0">                
                    <a href="<?php echo $this->Url->build('/',true).$urlLang; ?>webcam/<?php echo $nom_get; ?>"><img class="card-img-top rounded img-fluid" src="<?php echo $srcWebcams; ?>" alt="Webcams"></a>
                </div>
            </div>
            <div class="col-md-6 pr-0 pl-2 pl-lg-1 pr-2 pr-lg-0 mb-1 mb-lg-0 rounded">
                <div class="card shadow rounded border-0">
                    <a href="<?php echo $this->Url->build('/',true).$urlLang; ?>galery/<?php echo $nom_get; ?>"><img class="card-img-top rounded img-fluid" src="<?php echo $srcGalerie; ?>" alt="Galerie"></a>
                </div>
            </div>
        </div>       
    </div>
</section>
<!--end services section -->

<?php 
// Get the JSON
$json = file_get_contents('https://www.alpissime.com/blog/wp-json/wp/v2/posts?categories='.$station->input_blog.'&per_page=3');
// Convert the JSON to an array of posts
$posts = json_decode($json);
?>
<?php if(count($posts) > 0 && $language_header_name == "fr"){ ?>
<section id="magazine">
    <div class="container">
        <div class="row py-4">
            <div class="col-12 mt-3 pb-4 ">
                <h2 class="text-center h1"><?= __("Pour préparer vos vacances") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->preposition_a; else echo $station->_translations[$this->Session->read('Config.language')]->preposition_a; ?> <?php echo $station->name; ?></h2>
            </div>
            <div class="col-12 mt-lg-n5 text-center">
                <a href="<?php echo BLOG_ALPISSIME ?>" class="float-lg-right font-weight-500 mt-lg-n3 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
		</div>
        <div class="row">
            <?php foreach ($posts as $p) { 
                $featured_media = $p->featured_media;
                $json_media = file_get_contents('https://www.alpissime.com/blog/wp-json/wp/v2/media/'.$featured_media);
                $media = json_decode($json_media);
                $url_media = $media->media_details->sizes->medium_large->source_url;
                
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
				<h2 class="h1"><?= __("Vos prochaines vacances") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->preposition_a; else echo $station->_translations[$this->Session->read('Config.language')]->preposition_a; ?> <?php echo $station->name; ?></h2>                
                <h3 class="font-weight-bold pt-3 h2"><?= __("Découvrez la station") ?> <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->article_de; else echo $station->_translations[$this->Session->read('Config.language')]->article_de; ?> <?php echo $station->name; ?></h3>
                <p class="p-3">
                <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->descreption; else echo $station->_translations[$this->Session->read('Config.language')]->descreption; ?>
                <!-- <br>Situé au cœur de la vallée du Verdon, dans les Alpes de Haute-Provence, et aux portes du parc national du Mercantour, le Val d’Allos est une commune rassemblant un charmant village (le Village d’Allos) et deux stations de ski, Le Seignus et La Foux. Les stations du Val d’Allos sont labellisées Famille Plus, ce qui signifie que la commune s’engage auprès des familles, en proposant notamment des activités pour tous les âges avec des prix adaptés et des services facilement accessibles. Le label Famille Plus certifie pendant 3 ans la démarche de la station qui oeuvre pour  offrir des moments de retrouvaille et de partage en famille. Les stations du Val d’Allos, Val d’Allos - Le Seignus et Val d’Allos - La Foux (respectivement à 1500 et 1800m d’altitude) font partie de l’espace Lumière, plus grand domaine skiable des Alpes du Sud. Le domaine skiable de l’Espace Lumière rassemble depuis 1977 les stations de Val d’Allos - La Foux et de Pra Loup. -->
                </p>
                <?php if($this->Session->read('Config.language') == 'fr_FR'){
                if($station->sous_description != ""){ ?>
                <button class="btn btn-blue text-white rounded-circle collapse-button-chevron p-0" type="button" data-toggle="collapse" data-target="#collapsePourquoi" aria-expanded="false" aria-controls="collapsePourquoi">
                    <i class="fa fa-chevron-up font-size-small"></i>
                    <i class="fa fa-chevron-down font-size-small"></i>
                </button>
                <?php }
                }else{
                    if($station->_translations[$this->Session->read('Config.language')]->sous_description != ""){ ?>
                        <button class="btn btn-blue text-white rounded-circle collapse-button-chevron p-0" type="button" data-toggle="collapse" data-target="#collapsePourquoi" aria-expanded="false" aria-controls="collapsePourquoi">
                            <i class="fa fa-chevron-up font-size-small"></i>
                            <i class="fa fa-chevron-down font-size-small"></i>
                        </button>
                 <?php   }
                } ?>
			</div>           
		</div>
        <div class="collapse bg-white m-3 p-3 p-md-5" id="collapsePourquoi">
            <div class="row">
                <div class="col-md-12">
                    <p>
                    <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->sous_description; else echo $station->_translations[$this->Session->read('Config.language')]->sous_description; ?>
                    <!-- <br>Pour passer des vacances d’été à la montagne, il n’y a pas de plus belle destination que le Val d’Allos. C’est l'endroit idéal pour la pratique d’activités en famille comme la Luge d’Été, la randonnée (avec notamment le lac d'Allos, le plus grand lac naturel d'altitude d'Europe), et bien d’autres activités familiales. La commune d'Allos bénéficie d’un patrimoine naturel très riche, qui justifia notamment la création du parc national du Mercantour en 1979 (qui s’étend sur près d’un tiers du territoire de la commune d’Allos). Massif montagneux proche de la Méditerranée, le parc national du Mercantour offre une large diversité de paysages, de faune et de flore. -->
                    </p>
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
                    <?php if($station->image != ''){ ?>
                        <div >
                            <picture>
                                <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.webp" type="image/webp">
                                <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.png" type="image/png">
                                <img alt="Partenaire <?php echo $station->name;?>" src="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.png"/>
                            </picture>
                        </div>
                    <?php } ?>
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
                    <li><a href="https://www.facebook.com/pages/Alpissime/133882803314848" target="_blank"><i class="fa fa-facebook"></i></a></li>
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
								<a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['recherche'];?>" target="_blank"><?= __("Les appartements") ?></a>
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
						<li><a href="<?php  echo $this->Url->build('/').$urlLang.$urlvaluemulti['annonces']; ?>/contact" target="_blank"><?= __("Contact") ?></a></li>
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
		<!-- <img src="<?php // echo $this->Url->build('/')?>images/ico/PAIEMENT-SECURISE-DESKTOP.png" class="img-fluid pb-5 pt-3 d-none d-md-block d-lg-block" alt="paiement securise">
		<img src="<?php // echo $this->Url->build('/')?>images/ico/paiement-securise-mobile.png" class="img-fluid pb-5 pt-3 d-block d-md-none d-lg-none" alt="paiement securise mobile">    -->

         </div>
        <!--/row-->
    <!--/container-->
	</footer>
<!--End Footer-->						
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?php echo $this->Url->build('/')?>js/new/jquery-3.4.1.slim.min.js"></script>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/popper.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/bootstrap.min.js"></script>

<script src="<?php echo $this->Url->build('/')?>js/slick.min.js"></script>

<script async src="//platform.twitter.com/widgets.js"></script>

<script src="<?php echo $this->Url->build('/')?>js/datepicker.fr.js" type="text/javascript"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/bootstrap-input-spinner.js" type="text/javascript"></script>

<?php echo $this->Html->script(['jquery.lazy.min.js', 'jquery.lazy.plugins.min.js'])?>
<!-- UIkit JS -->
<script src="<?php echo $this->Url->build('/')?>js/new/uikit.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/uikit-icons.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/custom.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/item-quantity-dropdown.min.js"></script>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>


$(window).on('load',function() {
    $("img").Lazy();
});

$('.officedetailcl').click(function() {
  $.ajax({
    type: "POST",
    dataType : 'json',
    url: "<?php echo $this->Url->build('/',true)?>annonces/getdetailoffice",
    data: {office_id:$(this).data("id")},
    success:function(xml){
        if(xml.office.lien != null) xml.office.lien = xml.office.lien;
        else xml.office.lien = "";
        $("#nomoffice").html(xml.office.nom);
        $("#adresseoffice").html(xml.office.adresse+"<br> "+xml.office.code_postal+" - "+xml.ville);
        $("#contactoffice").html(xml.office.email+" <br>"+xml.office.portable+" <br>"+xml.office.lien);       
        $("#officedetail").modal("show"); 
    }
  });
})
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
   slidesToShow: 3,
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

// $("#nbCouchage_ad").inputSpinner({
// 	id: "nbCouchage_adulte"
// });
// $("#nbCouchage_enf").inputSpinner({
// 	id: "nbCouchage_enfant"
// });
});


var markers = [];
var map;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: <?php echo $station->latitude?$station->latitude:45.5877732; ?>, lng: <?php echo $station->longitude?$station->longitude:6.82846816; ?>},
        zoom: 6,
    });

    // IMAGE ICON
    // var imageMarqueur = {
    //     url: "<?php //echo $this->Url->build('/',true)?>images/iconegooglemap.png",
    //     //size: new google.maps.Size(44, 70),
    //     //anchor: new google.maps.Point(28, 120)
    // };
    
    latLng = new google.maps.LatLng(<?php echo $station->latitude?$station->latitude:45.5877732; ?>, <?php echo $station->longitude?$station->longitude:6.82846816; ?>);

    // Creating a marker and putting it on the map
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        // title: convertcaracterjson(data.title),
        // icon: imageMarqueur,
    });

    markers.push(marker);

}

</script>
<?php echo $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&callback=initMap&language=".$language_header_name); ?>
</body>
</html>							