<!doctype html>
<html lang="<?php echo $language_header_name; ?>">
<head>
<?php echo $this->fetch('tagmanager'); ?>
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
	<title><?= ucfirst(str_ireplace('www.', '', $_SERVER['HTTP_HOST'])) . " | ".$this->fetch('title'); ?></title>
	<!-- <meta name="description" content="Location les Arcs - Plus de 400 appartements en location de particuliers à particuliers stations les arcs 1600,arcs 1800,arcs 1950,arcs 2000,bourg saint maurice"> -->
	<meta name="keywords" content="<?= __('location, appartement, hébergement, studio, séjour, vacances, montagne, les Arcs, Bourg Saint Maurice, Savoie, Alpes, Paradiski, hiver, ski, été, vtt') ?>">
	<meta name="viewport" content="width=device-width, minimal-ui">
	
	<?php echo $this->fetch('meta'); ?>
	<!-- <meta property="og:title" content="Alpissime : Location vacances aux Arcs - Bourg Saint Maurice" /> -->
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />

    <?php //if($language_header_name == "en") {  ?>
	    <link rel="canonical" href="<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
    <?php //} ?>
    <link rel="alternate" hreflang="fr" href="<?php echo $this->fetch('hreflang'); ?>" />
    <link rel="alternate" hreflang="en" href="<?php echo $this->fetch('hreflangen'); ?>" />
	
	<meta Http-Equiv="Cache-Control" Content="no-cache">
    <meta Http-Equiv="Pragma" Content="no-cache">
    <meta Http-Equiv="Expires" Content="0">
    <meta Http-Equiv="Pragma-directive: no-cache">
    <meta Http-Equiv="Cache-directive: no-cache">
	<?php
	header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
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
    </style>
</head>
<body>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    BASE_URL = '<?= $this->Url->build('/',true); ?>';
    //Hide for now the support chat for messages page
    if (window.location.href.toLowerCase().indexOf('mymessages') == -1 && window.location.href.toLowerCase().indexOf('mesmessages') == -1) {
        <?php if($language_header_name == "fr") { ?>
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/60001129a9a34e36b96c4e21/1es04702f';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
        <?php }else{ ?>
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/60001129a9a34e36b96c4e21/1gdvpfskj';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
        <?php } ?>
    }
</script>

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
	<?php echo $this->Flash->render() ?>
    <section class="main border-top py-5">
        <?= $this->fetch('content') ?>	
    </section>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="orange h1modal"><?= __("Inscription Newsletter") ?></span>        
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
<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

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
<div class="modal fade" id="popup_confirm_mail_renvoie" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h2 class="modal-title txt-black" id="myModalLabel">Information</h2>
			</div>
			<div class="modal-body text-center">
                            <p class="p-modal txt-green">
                               <?php echo __("Un email de confirmation vous a été envoyé par Alpissime (administration@alpissime.com). Veuillez consulter votre boite mail pour activer votre compte."); ?>
                            </p>
			</div>
			<div class="modal-footer">
                            <button data-dismiss="modal" aria-label="Close" class="btn btn-success hvr-sweep-to-top ">OK</button>
                        </div>
		</div>
	</div>
</div>							
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

<?php echo $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js"); ?>



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
		data: {email: '<?php echo $this->Session->read('Auth.User.email'); ?>'},
		success:function(xml){                
			$('.renvoiemessage').addClass('hidden');  
			$("#popup_confirm_mail_renvoie").modal("show");
		}
	});
}
<?php if($this->Session->read('Auth.User') && $this->Session->read('Auth.User.id') != ''){ ?>
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
		
});
</script>
<?php echo $this->fetch('scriptBottom'); ?>
</body>
</html>							