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
	<title><?= __('Vacances {0} {1} | Séjour ski à la carte sur Alpissime.com', [$preposition_a, $station->name]); ?></title>
	<meta name="description" content="Réservez vos vacances <?php if($this->Session->read('Config.language') == 'fr_FR') echo $station->preposition_a; else echo $station->_translations[$this->Session->read('Config.language')]->preposition_a; ?> <?php echo $station->name; ?> Val d'Allos sur Alpissime | 🏘 Hébergements vérifiés ⛷ Activités en station ⭐️ Services de conciergerie | Paiement 4x sans frais">
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
	

	<link rel="stylesheet" href="<?php echo $this->Url->build('/')?>js/lity-2.3.1/dist/lity.css">
    
    
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

    .row.mt-n6 > .col,
    .row.mt-n6 > [class*="col-"] {
        padding-right: 4px;
        padding-left: 4px;
        padding-top: 4px;
        padding-bottom: 4px;
    }
    .mt-n6{
        position: relative;
        margin-top: -5em;
    }

    .contentimg{
        display: none;
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
    .imageclass{
        height: 250px;
        object-fit: cover;
    }
    @media screen and (max-width: 720px) {
        .paddingMap{
            padding: 0px 10px 0px 10px;
        } 
        .domaineSki{
            margin: 0px -7px 0px -7px;
        }
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

<div class="container rounded shadow bg-white">
    <!-- <div class=""> -->
        <div class="row mt-n6 p-2">
            <?php 
            $i = 0;
            foreach ($listeWebcam as $value) {
                if($value != ""){ ?>
                    <?php 
                    $Url = $value->url;
                    $ch = curl_init($Url);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $data = curl_exec($ch);
                    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);                    
                    if($httpcode == 200){ 
                        // HEADERS  
                        $error=false;
                        $ch = curl_init();
                        $options = array(CURLOPT_URL => $Url, CURLOPT_RETURNTRANSFER => true, CURLOPT_HEADER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_ENCODING => "", CURLOPT_AUTOREFERER => true, CURLOPT_CONNECTTIMEOUT => 120, CURLOPT_TIMEOUT => 120, CURLOPT_MAXREDIRS => 10,);
                        curl_setopt_array($ch, $options);
                        $response = curl_exec($ch);
                        $httpCode = curl_getinfo($ch);
                        $headers=substr($response, 0, $httpCode['header_size']);
                        if(strpos(strtolower($headers), strtolower('X-Frame-Options: DENY'))>-1||strpos(strtolower($headers), strtolower('X-Frame-Options: SAMEORIGIN'))>-1) {
                            $error=true;
                        }
                        // print_r($error);
                        ?>
                        <div class="col-12 col-md-4 contentimg">
                        <?php if($error) { ?>
                            <a href="<?php echo $value->url; ?>" target="_blank"> <img src="#" data-src="<?php echo $this->Url->build('/')?>images/cliquez-ici.jpg" class="img-fluid imageclass rounded w-100" /></a>
                        <?php }else{ ?>
                            <iframe class="rounded" src="<?php echo $value->url; ?>" height="250" width="100%" title="<?php echo $value->nom; ?>"></iframe>
                        <?php } ?>                            
                        <?php if(!$error) { ?> <p class="text-center"><?php echo $value->nom; ?><br><a href="<?php echo $value->url; ?>" data-lity><?= __("Voir détail") ?></a></p>  <?php } ?>                      
                        </div>
                    <?php $i++; }?>
            <?php }
            }
            if($i == 0){ ?>
            <div class="col-12 p-5">
                <h1 class="text-center"><?= __("Pas de webcam à afficher pour cette station") ?></h1>
            </div>
            <?php } ?>

        </div>   
        <?php if($listeWebcam->count() > 10){ ?>
            <div class="row">
                <div class="col-md-12 text-center p-4">
                    <a class="font-weight-500 voir-plus-land" href="#" id="loadMore">
                        <?= __("Charger plus") ?>
                    </a>
                </div>
            </div> 
        <?php } ?>
                 
    <!-- </div> -->
</div>

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
<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

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

<script src="<?php echo $this->Url->build('/')?>js/lity-2.3.1/dist/lity.js"></script>


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

    $(".contentimg").slice(0, 9).show();
    $("#loadMore").on("click", function(e){
        e.preventDefault();
        $(".contentimg:hidden").slice(0, 9).slideDown();
        if($(".contentimg:hidden").length == 0) {
            $("#loadMore").css("display", "none");
        }
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
		
});
</script>
</body>
</html>							