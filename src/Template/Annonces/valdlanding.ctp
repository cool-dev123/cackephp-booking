<!doctype html>
<html lang="fr">
<head>
<!-- Google Tag Manager -->
<script>
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PXZVFPZ');
</script>
<!-- End Google Tag Manager -->
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window,document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '533663950730723'); 
	fbq('track', 'PageView');
	</script>
	<noscript>
	<img height="1" width="1" 
	src="https://www.facebook.com/tr?id=533663950730723&ev=PageView
	&noscript=1"/>
	</noscript>
	<!-- End Facebook Pixel Code -->
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vacances Val d'Allos | Séjour ski à la carte sur Alpissime.com</title>
	<meta name="description" content="Réservez vos vacances au Val d'Allos sur Alpissime | 🏘 Hébergements vérifiés ⛷ Activités en station ⭐️ Services de conciergerie | Paiement 4x sans frais">
	<meta name="keywords" content="<?= __('location, appartement, hébergement, studio, séjour, vacances, montagne, les Arcs, Bourg Saint Maurice, Savoie, Alpes, Paradiski, hiver, ski, été, vtt') ?>">
	<meta name="viewport" content="width=device-width, minimal-ui">
	
    <?php echo $this->fetch('meta'); ?>
    <meta property="og:title" content="Vacances Val d'Allos | Séjour ski à la carte sur Alpissime.com" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://<?php echo $_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]; ?>" />
    <?php if(in_array(date("m"),array('05','06','07','08'))){
     $contentimg = $this->Url->build('/',true).'images/og_images/alpissime-locations-entre-particuliers-montagne-été-og.jpg';
        echo $this->Html->meta(null, null, ['property' => 'og:image','content' => $contentimg]); 
	 }else{ 
     $contentimg = $this->Url->build('/',true).'images/og_images/alpissime-locations-entre-particuliers-sejour-ski-vacances-hover-og.jpg';
        echo $this->Html->meta(null, null, ['property' => 'og:image','content' => $contentimg]); 
	 } ?>
	
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
	
	<!-- Le fav and touch icons -->
	<link rel="shortcut icon" href="<?php echo $this->Url->build('/')?>images/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->Url->build('/')?>images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->Url->build('/')?>images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->Url->build('/')?>images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo $this->Url->build('/')?>images/ico/apple-touch-icon-57-precomposed.png">
	
	<link rel="stylesheet" href="<?php echo $this->Url->build('/')?>css/cookieconsent.min.css">

	<!-- Liste cssTop -->
    <?php echo $this->fetch('cssTop'); ?>
    <?php echo $this->fetch('cssTopBlock'); ?>
    <style>
    .header_landing_page {
        background: url(images/VAL-D-ALLOS-alpissime-val-d-allos-location-entre-particuliers.jpg) no-repeat;
        background-size: cover;
        background-position: 0 69%;
    }
    .header_landing_page_ete{
        background: url(images/baniere_landing_ete_VALD.jpg) no-repeat center center;
        /* height: 400px; */
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
	<header>
		<div class="container-fluid">
		<nav class="navbar navbar-expand-xl navbar-light">
		<a class="navbar-brand" href="<?php echo $this->Url->build('/'); ?>">
         <svg aria-hidden="true" width="276" height="40" viewBox="0 0 1108.26 163.66">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/logo-couleur-alpissime-baseline.svg#Calque_2"></use>
        </svg> 
          <!-- <img class="img-fluid" src="#" data-src="<?php echo $this->Url->build('/')?>images/logo_landing_page.png" alt="logo landing page alpissime" title="Acceuil landing page"> -->
        </a>
		<button class="navbar-toggler" type="button" uk-toggle="target: #navbarSupportedContent2">
		<i class="fa fa-bars"></i>
		</button>
		
		<div class="d-none d-xl-block" id="navbarSupportedContent">
		<ul class="navbar-nav ml-xl-auto">
        <?php if ($this->Session->read('Auth.User.nature')==''){ ?>
			<li class="nav-item">
			<a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="<?php echo $this->Url->build('/'); ?>fr-services-et-contrats-proprietaires-de-residences-secondaires/"><?= __("Conciergerie") ?></a>
			</li>
			
			<li class="nav-item">
			<a class="nav-link" href="<?php echo $this->Url->build('/')?>utilisateurs/add"><?= __("Inscription") ?></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="<?php echo $this->Url->build('/')?>utilisateurs/ouvrircompte"><?= __("Connexion") ?></a>
			</li>
			<li>
			<button class="btn btn-sm btn-primary btn-alpissime ml-3" type="button" onclick="location.href='<?php echo $this->Url->build('/')?>annonces/depotannonce'"><?= __("Créer une annonce") ?></button>
			</li>
			<?php 
		}else{
			if($this->Session->read('Auth.User.nature')=='CLT'){
				?>
				<li class="nav-item">
				<a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a>
				</li>
				<li class="nav-item">
				<a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a>
				</li>
				<li class="nav-item">
                <a class="nav-link ml-lg-3 mr-lg-3" href="<?php echo $this->Url->build('/',true)?>utilisateurs/mesmessages"><i class="fa fa-envelope-o"></i>
                    <span class="nbr-msg"></span>
                </a>
				</li>
				<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle nav-user mr-3" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<img class="img-responsive" src="<?php echo $this->Url->build('/')?>images/user-icon.png" >
				</a>
				<div class="dropdown-menu user-menu" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" href="<?php echo $this->Url->build('/')?>utilisateurs/locataire_index"><?= __("Profil") ?></a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="<?php echo $this->Url->build('/')?>reservations/locataire_view"><?= __("Réservations") ?></a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a>
				</div>
				</li>
				<?php 
			}else{?>
				<li class="nav-item">
				<a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a>
				</li>
				<li class="nav-item">
				<a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a>
				</li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $this->Url->build('/'); ?>fr-services-et-contrats-proprietaires-de-residences-secondaires/" target="blank"><?= __("Conciergerie") ?></a>
                </li>
				<li class="nav-item">
                <a class="nav-link ml-lg-3 mr-lg-3" href="<?php echo $this->Url->build('/',true)?>utilisateurs/mesmessages"><i class="fa fa-envelope-o"></i>
                    <span class="nbr-msg"></span>
                </a>
				</li>
				<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle nav-user mr-3" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<img class="img-responsive" src="<?php echo $this->Url->build('/')?>images/user-icon.png" >
				</a>
				<div class="dropdown-menu user-menu" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" href="<?php echo $this->Url->build('/')?>utilisateurs/"><?= __("Espace Propriétaire") ?></a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="<?php echo $this->Url->build('/')?>reservations/validation"><?= __("Réservations") ?></a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/listannonce/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Mes annonces") ?></a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/mesmessages"><?= __("Messages") ?></a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a>
				</div>
				</li>
				<li>
                	<button class="btn btn-sm btn-primary btn-alpissime" type="button" onclick="location.href='<?php echo $this->Url->build('/')?>annonces/add'"><?= __("Créer une annonce") ?></button>
				</li>
				<?php }}
				?>
				</ul>
                </div>
<!-- Menu Mobile-->
<div class="d-xl-none" id="navbarSupportedContent2" uk-offcanvas="mode: push; overlay: true">
<div class="uk-offcanvas-bar">
<button class="uk-offcanvas-close" type="button" uk-close></button>
<div class="d-flex justify-content-between flex-column h-100 pb-3">
    <?php if ($this->Session->read('Auth.User.nature')==''){ ?>
		<ul class="navbar-nav mb-0">
            <li class="brand-title"><?= __("Menu") ?></li>
            <li class="nav-item">
			<a class="nav-link" href="<?php echo $this->Url->build('/'); ?>" target="blank"><?= __("Hébergements") ?></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="<?php echo $this->Url->build('/'); ?>fr-services-et-contrats-proprietaires-de-residences-secondaires/"><?= __("Conciergerie") ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a>
            </li>
            <li class="nav-item">
				<a class="nav-link" href="<?php  echo $this->Url->build('/') ?>annonces/contact" target="blank"><?= __("Contact") ?></a>
            </li>
            <hr>
			<li class="nav-item">
			<a class="nav-link" href="<?php echo $this->Url->build('/')?>utilisateurs/add"><?= __("Inscription") ?></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="<?php echo $this->Url->build('/')?>utilisateurs/ouvrircompte"><?= __("Connexion") ?></a>
			</li>
			<li>
			<button class="btn btn-sm btn-primary btn-alpissime mt-3" type="button" onclick="location.href='<?php echo $this->Url->build('/')?>annonces/depotannonce'"><?= __("Créer une annonce") ?></button>
            </li>
        </ul>
        <div class="border m-3 block-menumobile">
            <img class="img-fluid" src="<?php echo $this->Url->build('/',true)?>images/publicité-menu-mobile.png" />
        </div>
			<?php 
		}else{
			if($this->Session->read('Auth.User.nature')=='CLT'){
                ?>
                <ul class="navbar-nav mb-0">
				<li class="brand-title"><?= __("Menu") ?></li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->Url->build('/'); ?>" target="blank"><?= __("Hébergements") ?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php  echo $this->Url->build('/') ?>annonces/contact" target="blank"><?= __("Contact") ?></a>
                </li>
                <hr>
                <li class="brand-title mt-n2"><?= __("Mon espace") ?></li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->Url->build('/')?>utilisateurs/locataire_index"><?= __("Espace locataire") ?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->Url->build('/')?>reservations/locataire_view"><?= __("Réservations") ?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->Url->build('/',true)?>utilisateurs/mesmessages"><?= __("Messages") ?>
                    <span class="nbr-msg"></span>
                </a>
                </li>
				<li class="nav-item">
				<a class="nav-link" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a>
                </li>
            </ul>
            <div class="border m-3 block-menumobile">
                <img class="img-fluid" src="<?php echo $this->Url->build('/',true)?>images/publicité-menu-mobile.png" />
                </div>
				<?php 
            }else{?>
            <ul class="navbar-nav mb-0">
            <li class="brand-title"><?= __("Menu") ?></li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->Url->build('/'); ?>" target="blank"><?= __("Hébergements") ?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $this->Url->build('/'); ?>fr-services-et-contrats-proprietaires-de-residences-secondaires/" target="blank"><?= __("Conciergerie") ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php  echo $this->Url->build('/') ?>annonces/contact" target="blank"><?= __("Contact") ?></a>
                </li>
                <hr>
                <li class="brand-title mt-n2"><?= __("Mon espace") ?></li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->Url->build('/')?>utilisateurs/"><?= __("Espace Propriétaire") ?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->Url->build('/',true)?>utilisateurs/listannonce/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Mes annonces") ?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->Url->build('/')?>reservations/validation"><?= __("Mes réservations") ?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->Url->build('/',true)?>utilisateurs/mesmessages"><?= __("Messages") ?>
                    <span class="nbr-msg"></span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a>
                </li>
                <li>
					<button class="btn btn-sm btn-primary btn-alpissime mt-3" type="button" onclick="location.href='<?php echo $this->Url->build('/')?>annonces/add'"><?= __("Créer une annonce") ?></button>
                </li>
                </ul>
                <div class="border p-3 m-3 block-menumobile">
                    <p><?= __("Alpissime évolue depuis de 2009, toujours porté par votre confiance.") ?></p>
                    <p><?= __("Une question, une suggestions ou une amélioration à apporter ?") ?></p>
                    <a class="text-primary" href="<?php  echo $this->Url->build('/') ?>annonces/contact"><?= __("Contactez-nous") ?></a>
                </div>
				<?php }}
                ?>
                </div>
				</div>
				</div>		
                </nav>
				</div>
	</header>
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
						<?php echo $this->Form->create(null,['type'=>'get', 'url' => ['controller' => 'annonces', 'action' => 'recherche'],'id'=>'annonceRechercheForm'])?>
							<div class="form-group">
							    <label><?= __("Selectionnez la station de vos envies") ?></label>
								<select name="lieugeo" class="form-control custom-select" id="lieugeo">
								<option value="0"><?= __("Toutes les stations") ?></option>
								<option value="5">Bourg St Maurice</option>
								<option value="12">Vallandry</option>
								<option value="100">Les Arcs</option>
								<option value="1">&nbsp;&nbsp;&nbsp;&nbsp; Arcs 1600</option>
								<option value="2">&nbsp;&nbsp;&nbsp;&nbsp; Arcs 1800</option>
								<option value="8">&nbsp;&nbsp;&nbsp;&nbsp; Arcs 1800 (Chantel)</option>
								<option value="10">&nbsp;&nbsp;&nbsp;&nbsp; Arcs 1800 (Charmettoger)</option>
								<option value="9">&nbsp;&nbsp;&nbsp;&nbsp; Arcs 1800 (Charvet)</option>
								<option value="11">&nbsp;&nbsp;&nbsp;&nbsp; Arcs 1800 (Les Villards)</option>
								<option value="3">&nbsp;&nbsp;&nbsp;&nbsp; Arcs 1950</option>
								<option value="4">&nbsp;&nbsp;&nbsp;&nbsp; Arcs 2000</option>
								<option value="200">Val d'Allos</option>
								<option value="15">&nbsp;&nbsp;&nbsp;&nbsp; Val d'Allos - La Foux</option>
								<option value="16">&nbsp;&nbsp;&nbsp;&nbsp; Val d'Allos - Le Seignus</option>
								<option value="17">&nbsp;&nbsp;&nbsp;&nbsp; Val d'Allos - Le Village</option>  
								<option value="18">&nbsp;&nbsp;&nbsp;&nbsp; Val d'Allos - Le Haut verdon</option>  
								</select>                                      
							</div>
							<div class="form-group">
								<label><?= __("Dates") ?></label>
								<div class="row">
								    <div class="col-md-6 col-sm-12 pr-md-0 location_du">
                                        <div class="input-group mb-2">
                                            <input id="location_du" class="form-control" name="dbt" placeholder="jj-mm-aaaa" readonly />
                                            <div class="input-group-append">
                                                <div class="input-group-text"><label class="add-on mb-0" for="location_du"><i class="fa fa-calendar"></i></label></div>
                                            </div>
                                        </div>
                                    </div>
							        <div class="col-md-6 col-sm-12 pl-md-0 mt-3 mt-md-0 location_au">
                                        <div class="input-group mb-2">
                                            <input id="location_au" class="form-control" name="fin" placeholder="jj-mm-aaaa" readonly />
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
								    <div class="col-md-6 col-sm-12 pr-md-0 nbCouchage_ad">
								        <input id="nbCouchage_ad" name="nbCouchage_ad" data-prefix="Adultes" value="1" min="1" step="1" type="number" />
								    </div>
								    <div class="col-md-6 col-sm-12 pl-md-0 mt-3 mt-md-0 nbCouchage_enf">
								        <input id="nbCouchage_enf" name="nbCouchage_enf" data-prefix="Enfants" value="0" min="0" step="1" type="number" />
								    </div>
								</div>
							</div>
							<div class="form-group">
								<button type="submit" class="btn-search" id="recherchelogement"><?= __("Rechercher") ?></button>
							</div>
						<?php echo $this->Form->end()?>
					</div>
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
    <section>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-5 ">
                <h2 class="text-center h1">Locations de vacances au Val d'Allos</h2>
                <a href="<?php echo $this->Url->build('/', true); ?>annonces/recherche?lieugeo=200" class="float-right font-weight-500 mt-n4 mt-sm-3 mt-md-n4 voir-plus-land"><?= __("Voir plus") ?></a>
            </div>
		</div>
        <div class="annonce block products row">

        <?php  $c=0; foreach($annonces as $ann) { ?>
          <div class="col-6 col-sm-6 col-md-3" style="margin-bottom:10px">
            <div class="featured-product">
              <?php echo $this->annonceFormater->vignetterecherche($ann,$l_distances,$this->Url->build('/', true),$photos,$residence,$minprixannonce,$noteglobalmoytab);
                $lannonce = strtolower(trim(formatStr($ann->titre)));
                $lannonce.= ".html";
                // if($debutrech != '' || $finrech != '') echo "<a href='".$this->Url->build('/', true)."detail/".$ann->id."-".$lannonce."/".$debutrech."/".$finrech."' class='btn btn-success hvr-sweep-to-top btnrecherchebande'><?= __("Voir plus") ?></a>";
                // else echo "<a href='".$this->Url->build('/', true)."detail/".$ann->id."-".$lannonce."' class='btn btn-success hvr-sweep-to-top btnrecherchebande'><?= __("Voir plus") ?></a>";
              ?>
            </div>
          </div>
            <?php
            }
            ?>
        </div><!--annonce block -->
              
	</div>
</section>
<!--/annonces_location -->
<!--begin services section -->
<section id="services_prop" class="bg-light py-5">
    <div class="container">
        <div class="row">
			<div class="col-md-12">
				<h2 class="text-center h1"><?= __("Propriétaires - louez facilement avec les conciergeries Alpissime") ?></h2>
			</div>
		</div>
        <div class="row">
            
            <p class="w-100 text-center p-3">Facilitez la gestion de votre hébergement en faisant confiance à des professionnels de la location - Accueil de vos locataires, remises de clés, suivi de la location durant le séjour, collecte de la taxe de séjour (optionnel) et vérification de l'inventaire. Les conciergeries Alpissime en station de ski représentent un intermédiaire de confiance pour vous et vos locataires.</p>
        </div>
        <div class="row bloc_liste_service mt-5 mt-md-0">
            <div class="col-md-4">
                <div class="row">
                    <span class="col-auto">
                    <img src="<?php echo $this->Url->build('/')?>images/icon-blue.png" class="">
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
                    <img src="<?php echo $this->Url->build('/')?>images/icon-orange.png" class="">
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
                    <img src="<?php echo $this->Url->build('/')?>images/icon-rose.png" class="">
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
<section class="hebergement">
    <div class="container">
        <div class="row py-5">
            <div class="col-md-6">
                <img src="<?php echo $this->Url->build('/')?>images/ski-village-at-night.jpg" class="img-rounded mb-3">
                <h2 class="font-weight-bold py-3"><?= __("Location de vacances entre particuliers à la montagne") ?></h2>
                <p><?= __("Trouvez l’hébergement parfait pour vos prochaines <strong>vacances à la montagne</strong> en choisissant la <strong>location entre particuliers</strong> sur Alpissime. 
                    Découvrez une vaste gamme d’hébergements, de l’appartement en centre de station au chalet pied des pistes. 
                    Les annonces de location proposées sur Alpissime sont vérifiées.") ?></p>
            </div>
            <div class="col-md-6">
                <img src="<?php echo $this->Url->build('/')?>images/cours-de-ski-esf-alpissime.jpg" class="img-rounded mb-3">
                <h2 class="font-weight-bold py-3"><?= __("Réservez votre séjour au ski tout compris sur Alpissime") ?></h2>
                <p><?= __("Après avoir choisi l’hébergement idéal pour vos prochaines <strong>vacances en station de ski</strong>, ajoutez des activités et services vendus par les professionnels de votre station : location, cours et forfaits de ski, guides de haute montagne et bien plus encore ! 
                    Composez votre <strong>séjour à la carte</strong> pour des vacances inoubliables.") ?></p>
            </div>
        </div>
    <div>
</section>

<!-- Section magazine -->
<!-- Section conciergerie -->
<section class="concierge d-none d-md-block">
    <div class="container">
        <div class="row">
			<div class="col-md-12 text-center">
            <img src="<?php echo $this->Url->build('/')?>images/bandeau-conciergerie.jpg" class="w-100 my-5 img-rounded">
			</div>
        </div>
    </div>
</section>
<!-- End Section conciergerie -->
<?php 
// Get the JSON
$json = file_get_contents('https://www.alpissime.com/blog/wp-json/wp/v2/posts?categories=758&per_page=3');
// Convert the JSON to an array of posts
$posts = json_decode($json);
?>
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
<!-- End Section magazine -->
<!-- Section pourquoi alpissime -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
			<div class="col-md-12 text-center">
				<h2 class="h1">A propos du Val d'Allos</h2>                
                <h3 class="font-weight-bold pt-3 h2"><?= __("Découvrez la station") ?> du Val d’Allos</h3>
                <p class="p-3">
                Situé au cœur de la vallée du Verdon, dans les Alpes de Haute-Provence, et aux portes du parc national du Mercantour, le Val d’Allos est une commune rassemblant un charmant village (le Village d’Allos) et deux stations de ski, Le Seignus et La Foux. Les stations du Val d’Allos sont labellisées Famille Plus, ce qui signifie que la commune s’engage auprès des familles, en proposant notamment des activités pour tous les âges avec des prix adaptés et des services facilement accessibles. Le label Famille Plus certifie pendant 3 ans la démarche de la station qui oeuvre pour  offrir des moments de retrouvaille et de partage en famille. Les stations du Val d’Allos, Val d’Allos - Le Seignus et Val d’Allos - La Foux (respectivement à 1500 et 1800m d’altitude) font partie de l’espace Lumière, plus grand domaine skiable des Alpes du Sud. Le domaine skiable de l’Espace Lumière rassemble depuis 1977 les stations de Val d’Allos - La Foux et de Pra Loup.
                </p>
                <button class="btn btn-blue text-white rounded-circle collapse-button-chevron p-0" type="button" data-toggle="collapse" data-target="#collapsePourquoi" aria-expanded="false" aria-controls="collapsePourquoi">
                <i class="fa fa-chevron-up font-size-small"></i>
                <i class="fa fa-chevron-down font-size-small"></i>
                </button>
			</div>
            <div class="collapse bg-white m-3 p-3 p-md-5" id="collapsePourquoi">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="font-weight-bold py-3 h2">Val d’Allos en été</h3>
                    <p>Pour passer des vacances d’été à la montagne, il n’y a pas de plus belle destination que le Val d’Allos. C’est l'endroit idéal pour la pratique d’activités en famille comme la Luge d’Été, la randonnée (avec notamment le lac d'Allos, le plus grand lac naturel d'altitude d'Europe), et bien d’autres activités familiales. La commune d'Allos bénéficie d’un patrimoine naturel très riche, qui justifia notamment la création du parc national du Mercantour en 1979 (qui s’étend sur près d’un tiers du territoire de la commune d’Allos). Massif montagneux proche de la Méditerranée, le parc national du Mercantour offre une large diversité de paysages, de faune et de flore.</p>
                </div>
                <div class="col-md-6">
                <h3 class="font-weight-bold py-3 h2">Alpissime, plateforme officielle de locations de vacances du Val d’Allos</h3>
                    <p>Alpissime, plateforme de location entre particuliers en station de ski, a été choisi par le Val d’Allos (Office de Tourisme, Consortium Synergix regroupant la Compagnie de Remontées Mécaniques, l'association de propriétaires AIRFA ainsi que l'association des commerçants ANIMAFOUX) comme plateforme officielle de réservation de vacances de la station. Que vous préfériez pour vos vacances un appartement en centre station ou un chalet au pied des pistes, réservez vos prochaines vacances à la carte sur Alpissime. Retrouvez également sur la Marketplace les activités et services vendus par les professionnels de la station.</p>
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
                    <div >
                        <picture>
                            <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/partner11.webp" type="image/webp">
                            <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/partner11.jpg" type="image/jpg">
                            <img alt="Partenaire Val d'allos" src="<?php echo $this->Url->build('/',true)?>images/partners/partner11.jpg"/>
                        </picture>
                    </div>
                    <div >
                        <picture>
                            <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/partner9.webp" type="image/webp">
                            <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/partner9.jpg" type="image/jpg">
                            <img alt="Partenaire Val d'allos 2" src="<?php echo $this->Url->build('/',true)?>images/partners/partner9.jpg"/>
                        </picture>
                    </div>
                    <div >
                        <picture>
                            <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/partner10.webp" type="image/webp">
                            <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/partner10.jpg" type="image/jpg">
                            <img alt="Partenaire Val d'allos 2" src="<?php echo $this->Url->build('/',true)?>images/partners/partner10.jpg"/>
                        </picture>
                    </div>
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
                            <!--<input type="email" class="form-control" id="newsletter" name="newsletter" placeholder="Email">-->
                            <?php echo $this->Form->input('emailinscription',["label"=>false,'type'=>'text','templates' => ['inputContainer' => "{{content}}"],'placeholder'=>'Email', 'class'=>'form-control rounded-0'])?>
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
                    <a class="d-flex align-items-center h-100 mx-3" href="<?php echo $this->Url->build('/'); ?>">
                    <svg aria-hidden="true" width="276" height="40" viewBox="0 0 1108.26 163.66">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/logo-couleur-alpissime-baseline.svg#Calque_2"></use>
        </svg> 
						<!-- <img class="img-fluid" src="#" data-src="<?php echo $this->Url->build('/')?>images/logo_landing_page.png" alt="logo landing page alpissime" title="Acceuil landing page"> -->
					</a>
				</div>


                <!--Information-->
                <div class="col-md-6 col-lg-3 mt-3 mt-md-0">
                <h3><?= __("A propos") ?></h3>
                    <ul id="li_bottom_1" class="list-unstyled">
                        <li>
                            <a href="<?php echo BLOG_ALPISSIME ?>/qui-sommes-nous" target="_blank"><?= __("Qui sommes nous ?") ?></a>
                        </li>
                        <li>
                            <a href="<?php echo BOUTIQUE_ALPISSIME?>/" target="_blank"><?= __("Les services") ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Url->build('/')?>"><?= __("Accueil") ?></a>
                        </li>
                        <li>
                            <a href="<?php echo BLOG_ALPISSIME ?>" target="_blank"><?= __("Actualités en station") ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Url->build('/')?>recherche" target="_blank"><?= __("Les appartements") ?></a>
                        </li>
                        <li>
                            <a href="https://www.alpissime.com/annonceurs/index.html" target="blank"><?= __("Publicités") ?></a>
                        </li>
						<li>
                            <a href="<?php echo BOUTIQUE_ALPISSIME; ?>fr/devenir-partenaire" target="blank"><?= __("Devenir Vendeur") ?></a>
                        </li>
                        
                    </ul>
                </div>
                <!--End Information-->

                <!--Services clients-->
                <div class="col-md-6 col-lg-3">
                <h3><?= __("Service client") ?></h3>
                    <ul id="li_bottom_2" class="list-unstyled">
					<li><a href="<?php  echo $this->Url->build('/') ?>annonces/contact" target="_blank"><?= __("Contact") ?></a></li>
					<li><a href="<?php echo BLOG_ALPISSIME?>/conditions-generales-dutilisation-alpissime-com/" target="_blank"><?= __("CGU Alpissime.com") ?></a></li>
					<li><a href="<?php echo BOUTIQUE_ALPISSIME; ?>fr/conditions-generales-de-vente-marketplace-alpissime" target="_blank"><?= __("CGV Marketplace") ?></a></li>
                    <li><a href="<?php echo BLOG_ALPISSIME?>/politique-de-confidentialite/" target="_blank"><?= __("Politique de confidentialité") ?></a></li>
					<li><a href="<?php echo BLOG_ALPISSIME?>/mentions-legales" target="_blank"> <?= __("Mentions légales") ?></a></li>	
						<li class="mt-2">
						<img data-src="<?php echo $this->Url->build('/')?>images/ico/logos-moyen-de-paiement---pel.png" src="#" alt="Moyen de paiement" class="mr-2" width="150">
						<!-- <img data-src="<?php echo $this->Url->build('/')?>images/ico/visa_electron.png" src="#" alt="Visa Electron" class="mr-2">
						<img data-src="<?php echo $this->Url->build('/')?>images/ico/paypal.png" src="#" alt="Paypal"> -->
						</li>
                    </ul>
                </div>
                <!--End Services clients-->

                <!--Extras-->
                <div class="col-md-6 col-lg-3 ">
                    <h3><?= __("Informations") ?></h3>
                    <div>
                        <ul id="li_bottom_3" class="list-unstyled">
                          <li><a href="<?php  echo $this->Url->build('/') ?>sitemap" target="_blank"><?= __("Site map Alpissime.com") ?></a></li>
                          <li><a href="<?php echo BOUTIQUE_ALPISSIME?>/fr/site-map/" target="_blank"><?= __("Site map Marketplace") ?></a></li>
                          <li><a href="<?php echo BLOG_ALPISSIME?>/lexique-de-la-location-sur-alpissime-com" target="blank"> <?= __("Lexique de la location saisonnière") ?></a></li>
						  <li>
                            <a href="<?php echo $this->Url->build('/',true)?>routes" target="blank"><?= __("Routes") ?></a>
                        </li>
                        
                        </ul>
                    </div>
                </div>
                <!--Extras-->
            </div>

        </div>
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

<?php echo $this->Html->script(['cookieconsent.min.js'])?>
<script src="<?php echo $this->Url->build('/')?>js/datepicker.fr.js" type="text/javascript"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/bootstrap-input-spinner.js" type="text/javascript"></script>

<?php echo $this->Html->script(['jquery.lazy.min.js', 'jquery.lazy.plugins.min.js'])?>
<!-- UIkit JS -->
<script src="<?php echo $this->Url->build('/')?>js/new/uikit.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/uikit-icons.min.js"></script>
<script src="<?php echo $this->Url->build('/')?>js/new/custom.js"></script>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>
/*
window.cookieconsent.initialise({
	"palette": {
		"popup": {
		"background": "#000000"
		},
		"button": {
		"background": "#0047ff"
		}
	},
	"theme": "edgeless",
//   "position": "top",
	"content": {
		"message": "Les cookies assurent le bon fonctionnement de nos services. En utilisant ces derniers, vous acceptez l'utilisation des cookies",
		"dismiss": "Accepter !",
		"link": "En savoir plus",
		"href": "https://www.boutique.alpissime.com/fr/privacy-policy-cookie-restriction-mode"
	}
});
*/
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

$(document).ready(function () {
    $("#lieugeo").val(200);

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
		
		
		

 $.datepicker.setDefaults($.datepicker.regional['fr']);
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

$("#nbCouchage_ad").inputSpinner({
	id: "nbCouchage_adulte"
});
$("#nbCouchage_enf").inputSpinner({
	id: "nbCouchage_enfant"
});
});

</script>
</body>
</html>							