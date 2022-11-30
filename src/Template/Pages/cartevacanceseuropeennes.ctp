<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html xml:lang="fr" class="no-js"> <!--<![endif]-->
<head>
  <?php if(PROD_ON == 1){ ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PXZVFPZ');</script>
    <!-- End Google Tag Manager -->
    <?php } ?>
    <!-- Start cookieyes banner -->
    <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/42f3745ec212b55224e20de6.js"></script>
    <!-- End cookieyes banner --> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?= __("Carte des vacances européennes") ?></title>
    <meta name="description" content="Carte et calendrier des vacances scolaire européennes">
    <meta name="keywords" content="vacances, scolaires, carte, calendrier, hiver, été, noël, europe, européennes">
    <meta name="viewport" content="width=device-width, minimal-ui">
    <meta http-equiv="content-language" content="fr">
    <meta property="og:title" content="Carte des vacances européennes" />
    <meta property="og:description" content="Carte et calendrier des vacances scolaire européennes" />
    <meta property="og:image" content="https://www.alpissime.com/images/og_images/calendrier-des-vacances-scolaires-europeennes-og.jpg" />
    <meta property="og:url" content="https://www.alpissime.com/fr-carte-et-calendrier-vacances-scolaires-europe" />

    <!-- CSSMap STYLESHEET - EUROPE -->
    <?php echo $this->Html->css("/css/cssmap-europe.css"); ?>
    <!-- CSSMap SCRIPT -->

    <?php echo $this->Html->css("flags.css"); ?>
    <?php echo $this->Html->css("bootstrap.min")?>
    <?php echo $this->Html->css("font-awesome")?>
    <?php echo $this->Html->css("normalize")?>
    <?php echo $this->Html->css("bootstrap-datepicker")?>
    <?php echo $this->Html->css("main")?>
    <?php echo $this->Html->css("sl-slide")?>
    <?php echo $this->Html->css("hover-min")?>
    <?php echo $this->Html->css("component")?>
    <?php echo $this->Html->css("modifs")?>
    <?php echo $this->Html->css("media")?>
    <?php echo $this->Html->css("animation")?>
    <?php echo $this->Html->css("ui.all.css")?>
    <?php echo $this->Html->css("fullcalendar.css")?>



	<?php echo $this->Html->script(['jquery-1.11.3.min.js'])?>
  <?php echo $this->Html->script(['jquery.cssmap.min.js']); ?>


    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo $this->Url->build('/',true)?>images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->Url->build('/',true)?>images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->Url->build('/',true)?>images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->Url->build('/',true)?>images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $this->Url->build('/',true)?>images/ico/apple-touch-icon-57-precomposed.png">
    <style>
        span.title-newsletter {
            position: relative;
            top: 7px;
            margin-right: 2%;
        }
        .demo-agents2 {
         margin-top: 0px;
       }
       .col-md-9.block{
         margin-bottom: 0;
       }
       .share_this {
        margin-right: 24%;
        float: right;
        width: 70%;
      }
      .paragstyle{
        font-size: 13px;
        font-weight: 600;
        margin-top: 35px;
      }
      table.sansborder {
        font-size: 15px !important;
        letter-spacing: 1px;
    }
      @media screen and (max-width: 1023px) {
        .share_this {
         width: 90%;
       }
     }
     @media screen and (max-width: 740px) {
       .detail_ann .form-group{
        width: 50% !important;
      }
    }
    @media screen and (max-width: 665px) {
      .detail_ann .form-group{
       width: 75% !important;
     }
    }
    .legendtable td{
      padding-bottom: 15px;
    }
    h2 {
        color: #333333;
        font-size: 25px !important;
        font-weight: 400;
        letter-spacing: 2px;
    }
    .demo-agents2 {
     margin-left: 0;
     width: 100%;
   }
   img.flag {
    margin-top: -8px;
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
  <div style="height: 40px;" class="row">
    <div class="col-md-12">
      <center><a href="https://www.alpissime.com/" target="_blank">
      <!-- <img style="height: 40px;" class="img_center" src="<?php echo $this->Url->build('/',true)?>images/logo.png" alt="alpissime"> -->
      <svg aria-hidden="true" width="340" height="55" viewBox="0 0 1108.26 163.66">
        <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/logo-couleur-alpissime-baseline.svg#Calque_2"></use>
      </svg>
      </a></center>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <center><h1><span class="">Carte des vacances europeennes</span></h1></center>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <!-- CSSMap - Europe -->
      <div id="map-europe">
        <ul class="europe">
          <li class="eu1"><a href="#albania"><?php
            if (isset($drapeauvacance['Albanie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Albanie'])."' alt='".strtolower($drapeauvacance['Albanie'])."' /> Albanie".$tabzones['Albanie']."</h2></center>";
            else echo "<center><h2>Albanie".$tabzones['Albanie']."</h2></center>";
            if(isset($tabvacance['Albanie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Albanie'] as $key ) {
                echo "<tr><td>";
                echo $key;
                echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu2"><a href="#andorra"><?php
            if (isset($drapeauvacance['Andorre'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Andorre'])."' alt='".strtolower($drapeauvacance['Andorre'])."' /> Andorre".$tabzones['Andorre']."</h2></center>";
            else echo "<center><h2>Andorre".$tabzones['Andorre']."</h2></center>";
            if(isset($tabvacance['Andorre'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Andorre'] as $key ) {
                echo "<tr><td>";
                echo $key;
                echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu3"><a href="#austria"><?php
            if (isset($drapeauvacance['Autriche'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Autriche'])."' alt='".strtolower($drapeauvacance['Autriche'])."' /> Autriche".$tabzones['Autriche']."</h2></center>";
            else echo "<center><h2>Autriche".$tabzones['Autriche']."</h2></center>";
            if(isset($tabvacance['Autriche'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Autriche'] as $key ) {
                echo "<tr><td>";
                echo $key;
                echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu4"><a href="#belarus"><?php
            if (isset($drapeauvacance['Biélorussie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Biélorussie'])."' alt='".strtolower($drapeauvacance['Biélorussie'])."' /> Biélorussie".$tabzones['Biélorussie']."</h2></center>";
            else echo "<center><h2>Biélorussie".$tabzones['Biélorussie']."</h2></center>";
            if(isset($tabvacance['Biélorussie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Biélorussie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu5"><a href="#belgium"><?php
            if (isset($drapeauvacance['Belgique'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Belgique'])."' alt='".strtolower($drapeauvacance['Belgique'])."' /> Belgique".$tabzones['Belgique']."</h2></center>";
            else echo "<center><h2>Belgique".$tabzones['Belgique']."</h2></center>";
            if(isset($tabvacance['Belgique'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Belgique'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu6"><a href="#bosnia-and-herzegovina"><?php
            if (isset($drapeauvacance['Bosnie-Herzégovine'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Bosnie-Herzégovine'])."' alt='".strtolower($drapeauvacance['Bosnie-Herzégovine'])."' /> Bosnia et Herzegovina".$tabzones['Bosnie-Herzégovine']."</h2></center>";
            else echo "<center><h2>Bosnie-Herzégovine".$tabzones['Bosnie-Herzégovine']."</h2></center>";
            if(isset($tabvacance['Bosnie-Herzégovine'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Bosnie-Herzégovine'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu7"><a href="#bulgaria"><?php
            if (isset($drapeauvacance['Bulgarie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Bulgarie'])."' alt='".strtolower($drapeauvacance['Bulgarie'])."' /> Bulgarie".$tabzones['Bulgarie']."</h2></center>";
            else echo "<center><h2>Bulgarie".$tabzones['Bulgarie']."</h2></center>";
            if(isset($tabvacance['Bulgarie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Bulgarie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu8"><a href="#croatia"><?php
            if (isset($drapeauvacance['Croatie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Croatie'])."' alt='".strtolower($drapeauvacance['Croatie'])."' /> Croatie".$tabzones['Croatie']."</h2></center>";
            else echo "<center><h2>Croatie".$tabzones['Croatie']."</h2></center>";
            if(isset($tabvacance['Croatie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Croatie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu9"><a href="#cyprus"><?php
            if (isset($drapeauvacance['Chypre'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Chypre'])."' alt='".strtolower($drapeauvacance['Chypre'])."' /> Chypre".$tabzones['Chypre']."</h2></center>";
            else echo "<center><h2>Chypre".$tabzones['Chypre']."</h2></center>";
            if(isset($tabvacance['Chypre'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Chypre'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu10"><a href="#czech-republic"><?php
            if (isset($drapeauvacance['République tchèque'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['République tchèque'])."' alt='".strtolower($drapeauvacance['République tchèque'])."' /> République tchèque".$tabzones['République tchèque']."</h2></center>";
            else echo "<center><h2>République tchèque".$tabzones['République tchèque']."</h2></center>";
            if(isset($tabvacance['République tchèque'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['République tchèque'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu11"><a href="#denmark"><?php
          if (isset($drapeauvacance['Danemark'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Danemark'])."' alt='".strtolower($drapeauvacance['Danemark'])."' /> Danemark".$tabzones['Danemark']."</h2></center>";
          else echo "<center><h2>Danemark".$tabzones['Danemark']."</h2></center>";
            if(isset($tabvacance['Danemark'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Danemark'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu12"><a href="#estonia"><?php
          if (isset($drapeauvacance['Estonie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Estonie'])."' alt='".strtolower($drapeauvacance['Estonie'])."' /> Estonie".$tabzones['Estonie']."</h2></center>";
          else echo "<center><h2>Estonie".$tabzones['Estonie']."</h2></center>";
            if(isset($tabvacance['Estonie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Estonie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu13"><a href="#france"><?php
          if (isset($drapeauvacance['France'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['France'])."' alt='".strtolower($drapeauvacance['France'])."' /> France".$tabzones['France']."</h2></center>";
          else echo "<center><h2>France".$tabzones['France']."</h2></center>";
            if(isset($tabvacance['France'])) {
            echo "<table class='sansborder'>";
            foreach ($tabvacance['France'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu14"><a href="#finland"><?php
          if (isset($drapeauvacance['Finlande'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Finlande'])."' alt='".strtolower($drapeauvacance['Finlande'])."' /> Finlande".$tabzones['Finlande']."</h2></center>";
          else echo "<center><h2>Finlande".$tabzones['Finlande']."</h2></center>";
            if(isset($tabvacance['Finlande'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Finlande'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu15"><a href="#georgia"><?php
          if (isset($drapeauvacance['Géorgie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Géorgie'])."' alt='".strtolower($drapeauvacance['Géorgie'])."' /> Géorgie".$tabzones['Géorgie']."</h2></center>";
          else echo "<center><h2>Géorgie".$tabzones['Géorgie']."</h2></center>";
            if(isset($tabvacance['Géorgie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Géorgie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu16"><a href="#germany"><?php
          if (isset($drapeauvacance['Allemagne'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Allemagne'])."' alt='".strtolower($drapeauvacance['Allemagne'])."' /> Allemagne".$tabzones['Allemagne']."</h2></center>";
          else echo "<center><h2>Allemagne".$tabzones['Allemagne']."</h2></center>";
            if(isset($tabvacance['Allemagne'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Allemagne'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu17"><a href="#greece"><?php
          if (isset($drapeauvacance['Grèce'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Grèce'])."' alt='".strtolower($drapeauvacance['Grèce'])."' /> Grèce".$tabzones['Grèce']."</h2></center>";
          else echo "<center><h2>Grèce".$tabzones['Grèce']."</h2></center>";
            if(isset($tabvacance['Grèce'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Grèce'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu18"><a href="#hungary"><?php
          if (isset($drapeauvacance['Hongrie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Hongrie'])."' alt='".strtolower($drapeauvacance['Hongrie'])."' /> Hongrie".$tabzones['Hongrie']."</h2></center>";
          else echo "<center><h2>Hongrie".$tabzones['Hongrie']."</h2></center>";
            if(isset($tabvacance['Hongrie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Hongrie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu19"><a href="#iceland"><?php
          if (isset($drapeauvacance['Islande'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Islande'])."' alt='".strtolower($drapeauvacance['Islande'])."' /> Islande".$tabzones['Islande']."</h2></center>";
          else echo "<center><h2>Islande".$tabzones['Islande']."</h2></center>";
            if(isset($tabvacance['Islande'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Islande'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu20"><a href="#ireland"><?php
          if (isset($drapeauvacance['Irlande'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Irlande'])."' alt='".strtolower($drapeauvacance['Irlande'])."' /> Irlande".$tabzones['Irlande']."</h2></center>";
          else echo "<center><h2>Irlande".$tabzones['Irlande']."</h2></center>";
            if(isset($tabvacance['Irlande'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Irlande'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu21"><a href="#san-marino"><?php
          if (isset($drapeauvacance['Saint-Marin'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Saint-Marin'])."' alt='".strtolower($drapeauvacance['Saint-Marin'])."' /> Saint-Marin".$tabzones['Saint-Marin']."</h2></center>";
          else echo "<center><h2>Saint-Marin".$tabzones['Saint-Marin']."</h2></center>";
            if(isset($tabvacance['Saint-Marin'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Saint-Marin'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu22"><a href="#italy"><?php
          if (isset($drapeauvacance['Italie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Italie'])."' alt='".strtolower($drapeauvacance['Italie'])."' /> Italie".$tabzones['Italie']."</h2></center>";
          else echo "<center><h2>Italie".$tabzones['Italie']."</h2></center>";
            if(isset($tabvacance['Italie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Italie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu23"><a href="#kosovo"><?php
          if(isset($drapeauvacance['Kosovo'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Kosovo'])."' alt='".strtolower($drapeauvacance['Kosovo'])."' /> Kosovo".$tabzones['Kosovo']."</h2></center>";
          else{
            echo "<center><h2>Kosovo".$tabzones['Kosovo']."</h2></center>";
          }
          if(isset($tabvacance['Kosovo'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Kosovo'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu24"><a href="#latvia"><?php
          if (isset($drapeauvacance['Lettonie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Lettonie'])."' alt='".strtolower($drapeauvacance['Lettonie'])."' /> Lettonie".$tabzones['Lettonie']."</h2></center>";
          else echo "<center><h2>Lettonie".$tabzones['Lettonie']."</h2></center>";
            if(isset($tabvacance['Lettonie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Lettonie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu25"><a href="#liechtenstein"><?php
          if (isset($drapeauvacance['Liechtenstein'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Liechtenstein'])."' alt='".strtolower($drapeauvacance['Liechtenstein'])."' /> Liechtenstein".$tabzones['Liechtenstein']."</h2></center>";
          else echo "<center><h2>Liechtenstein".$tabzones['Liechtenstein']."</h2></center>";
            if(isset($tabvacance['Liechtenstein'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Liechtenstein'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu26"><a href="#lithuania"><?php
          if (isset($drapeauvacance['Lituanie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Lituanie'])."' alt='".strtolower($drapeauvacance['Lituanie'])."' /> Lituanie".$tabzones['Lituanie']."</h2></center>";
          else echo "<center><h2>Lituanie".$tabzones['Lituanie']."</h2></center>";
            if(isset($tabvacance['Lituanie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Lituanie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu27"><a href="#luxembourg"><?php
          if (isset($drapeauvacance['Luxembourg'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Luxembourg'])."' alt='".strtolower($drapeauvacance['Luxembourg'])."' /> Luxembourg".$tabzones['Luxembourg']."</h2></center>";
          else echo "<center><h2>Luxembourg".$tabzones['Luxembourg']."</h2></center>";
            if(isset($tabvacance['Luxembourg'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Luxembourg'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu28"><a href="#macedonia"><?php
          if (isset($drapeauvacance['ex-République yougoslave de Macédoine'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['ex-République yougoslave de Macédoine'])."' alt='".strtolower($drapeauvacance['ex-République yougoslave de Macédoine'])."' /> Ex-République yougoslave de Macédoine".$tabzones['ex-République yougoslave de Macédoine']."</h2></center>";
          else echo "<center><h2>ex-République yougoslave de Macédoine".$tabzones['ex-République yougoslave de Macédoine']."</h2></center>";
            if(isset($tabvacance['ex-République yougoslave de Macédoine'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['ex-République yougoslave de Macédoine'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu29"><a href="#malta"><?php
          if (isset($drapeauvacance['Malte'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Malte'])."' alt='".strtolower($drapeauvacance['Malte'])."' /> Malte".$tabzones['Malte']."</h2></center>";
          else echo "<center><h2>Malte".$tabzones['Malte']."</h2></center>";
            if(isset($tabvacance['Malte'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Malte'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu30"><a href="#moldova"><?php
          if (isset($drapeauvacance['Moldavie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Moldavie'])."' alt='".strtolower($drapeauvacance['Moldavie'])."' /> Moldavie".$tabzones['Moldavie']."</h2></center>";
          else echo "<center><h2>Moldavie".$tabzones['Moldavie']."</h2></center>";
            if(isset($tabvacance['Moldavie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Moldavie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu31"><a href="#monaco"><?php
          if (isset($drapeauvacance['Monaco'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Monaco'])."' alt='".strtolower($drapeauvacance['Monaco'])."' /> Monaco".$tabzones['Monaco']."</h2></center>";
          else echo "<center><h2>Monaco".$tabzones['Monaco']."</h2></center>";
            if(isset($tabvacance['Monaco'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Monaco'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu32"><a href="#montenegro"><?php
            if(isset($drapeauvacance['Monténégro'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Monténégro'])."' alt='".strtolower($drapeauvacance['Monténégro'])."' /> Monténégro".$tabzones['Monténégro']."</h2></center>";
            else{
              echo "<center><h2>Monténégro".$tabzones['Monténégro']."</h2></center>";
            }
            if(isset($tabvacance['Monténégro'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Monténégro'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu33"><a href="#netherlands"><?php
          if (isset($drapeauvacance['Pays-Bas'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Pays-Bas'])."' alt='".strtolower($drapeauvacance['Pays-Bas'])."' /> Pays-Bas".$tabzones['Pays-Bas']."</h2></center>";
          else echo "<center><h2>Pays-Bas".$tabzones['Pays-Bas']."</h2></center>";
            if(isset($tabvacance['Pays-Bas'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Pays-Bas'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu34"><a href="#norway"><?php
          if (isset($drapeauvacance['Norvège'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Norvège'])."' alt='".strtolower($drapeauvacance['Norvège'])."' /> Norvège".$tabzones['Norvège']."</h2></center>";
          else echo "<center><h2>Norvège".$tabzones['Norvège']."</h2></center>";
            if(isset($tabvacance['Norvège'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Norvège'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu35"><a href="#poland"><?php
          if (isset($drapeauvacance['Pologne'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Pologne'])."' alt='".strtolower($drapeauvacance['Pologne'])."' /> Pologne".$tabzones['Pologne']."</h2></center>";
          else echo "<center><h2>Pologne".$tabzones['Pologne']."</h2></center>";
            if(isset($tabvacance['Pologne'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Pologne'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu36"><a href="#portugal"><?php
          if (isset($drapeauvacance['Portugal'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Portugal'])."' alt='".strtolower($drapeauvacance['Portugal'])."' /> Portugal".$tabzones['Portugal']."</h2></center>";
          else echo "<center><h2>Portugal".$tabzones['Portugal']."</h2></center>";
            if(isset($tabvacance['Portugal'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Portugal'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu37"><a href="#romania"><?php
          if (isset($drapeauvacance['Roumanie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Roumanie'])."' alt='".strtolower($drapeauvacance['Roumanie'])."' /> Roumanie".$tabzones['Roumanie']."</h2></center>";
          else echo "<center><h2>Roumanie".$tabzones['Roumanie']."</h2></center>";
            if(isset($tabvacance['Roumanie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Roumanie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu38"><a href="#russian-federation"><?php
          if (isset($drapeauvacance['Russie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Russie'])."' alt='".strtolower($drapeauvacance['Russie'])."' /> Russie".$tabzones['Russie']."</h2></center>";
          else echo "<center><h2>Russie".$tabzones['Russie']."</h2></center>";
            if(isset($tabvacance['Russie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Russie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu39"><a href="#serbia"><?php
          if (isset($drapeauvacance['Serbie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Serbie'])."' alt='".strtolower($drapeauvacance['Serbie'])."' /> Serbie".$tabzones['Serbie']."</h2></center>";
          else echo "<center><h2>Serbie".$tabzones['Serbie']."</h2></center>";
            if(isset($tabvacance['Serbie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Serbie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu40"><a href="#slovakia"><?php
          if (isset($drapeauvacance['Slovaquie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Slovaquie'])."' alt='".strtolower($drapeauvacance['Slovaquie'])."' /> Slovaquie".$tabzones['Slovaquie']."</h2></center>";
          else echo "<center><h2>Slovaquie".$tabzones['Slovaquie']."</h2></center>";
            if(isset($tabvacance['Slovaquie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Slovaquie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu41"><a href="#slovenia"><?php
          if (isset($drapeauvacance['Slovénie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Slovénie'])."' alt='".strtolower($drapeauvacance['Slovénie'])."' /> Slovénie".$tabzones['Slovénie']."</h2></center>";
          else echo "<center><h2>Slovénie".$tabzones['Slovénie']."</h2></center>";
            if(isset($tabvacance['Slovénie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Slovénie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu42"><a href="#spain"><?php
          if (isset($drapeauvacance['Espagne'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Espagne'])."' alt='".strtolower($drapeauvacance['Espagne'])."' /> Espagne".$tabzones['Espagne']."</h2></center>";
          else echo "<center><h2>Espagne".$tabzones['Espagne']."</h2></center>";
            if(isset($tabvacance['Espagne'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Espagne'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu43"><a href="#sweden"><?php
            if (isset($drapeauvacance['Suède'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Suède'])."' alt='".strtolower($drapeauvacance['Suède'])."' /> Suède".$tabzones['Suède']."</h2></center>";
            else{
              echo "<center><h2>Suède".$tabzones['Suède']."</h2></center>";
            }
            if(isset($tabvacance['Suède'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Suède'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu44"><a href="#switzerland"><?php
          if (isset($drapeauvacance['Suisse'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Suisse'])."' alt='".strtolower($drapeauvacance['Suisse'])."' /> Suisse".$tabzones['Suisse']."</h2></center>";
          else echo "<center><h2>Suisse".$tabzones['Suisse']."</h2></center>";
            if(isset($tabvacance['Suisse'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Suisse'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu45"><a href="#turkey"><?php
          if (isset($drapeauvacance['Turquie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Turquie'])."' alt='".strtolower($drapeauvacance['Turquie'])."' /> Turquie".$tabzones['Turquie']."</h2></center>";
          else echo "<center><h2>Turquie".$tabzones['Turquie']."</h2></center>";
            if(isset($tabvacance['Turquie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Turquie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu46"><a href="#ukraine"><?php
          if (isset($drapeauvacance['Ukraine'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Ukraine'])."' alt='".strtolower($drapeauvacance['Ukraine'])."' /> Ukraine".$tabzones['Ukraine']."</h2></center>";
          else echo "<center><h2>Ukraine".$tabzones['Ukraine']."</h2></center>";
            if(isset($tabvacance['Ukraine'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Ukraine'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu47"><a href="#united-kingdom"><?php
          if (isset($drapeauvacance['Royaume-Uni'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Royaume-Uni'])."' alt='".strtolower($drapeauvacance['Royaume-Uni'])."' /> Royaume-Uni".$tabzones['Royaume-Uni']."</h2></center>";
          else echo "<center><h2>Royaume-Uni".$tabzones['Royaume-Uni']."</h2></center>";
            if(isset($tabvacance['Royaume-Uni'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Royaume-Uni'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu48"><a href="#england"><?php
          if (isset($drapeauvacance['Angleterre'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Angleterre'])."' alt='".strtolower($drapeauvacance['Angleterre'])."' /> Angleterre".$tabzones['Angleterre']."</h2></center>";
          else echo "<center><h2>Angleterre".$tabzones['Angleterre']."</h2></center>";
            if(isset($tabvacance['Angleterre'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Angleterre'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu49"><a href="#isle-of-man"><?php
            if(isset($drapeauvacance['Ile de Man'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Ile de Man'])."' alt='".strtolower($drapeauvacance['Ile de Man'])."' /> Île de Man".$tabzones['Ile de Man']."</h2></center>";
            else{
              echo "<center><h2>Île de Man".$tabzones['Ile de Man']."</h2></center>";
            }
            if(isset($tabvacance['Ile de Man'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Ile de Man'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
        <li class="eu50"><a href="#northern-ireland"><?php
        if (isset($drapeauvacance['Irlande du Nord'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Irlande du Nord'])."' alt='".strtolower($drapeauvacance['Irlande du Nord'])."' /> Irlande du Nord".$tabzones['Irlande du Nord']."</h2></center>";
        else echo "<center><h2>Irlande du Nord".$tabzones['Irlande du Nord']."</h2></center>";
          if(isset($tabvacance['Irlande du Nord'])) {
            echo "<table class='sansborder'>";
            foreach ($tabvacance['Irlande du Nord'] as $key ) {
            echo "<tr><td>";
            echo $key;
            echo "</td></tr>";
          }
        echo "</table>";
      }  ?></a></li>
          <li class="eu51"><a href="#scotland"><?php
            if(isset($drapeauvacance['écosse'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['écosse'])."' alt='".strtolower($drapeauvacance['écosse'])."' /> Écosse".$tabzones['écosse']."</h2></center>";
            else{
              echo "<center><h2>Écosse".$tabzones['écosse']."</h2></center>";
            }
            if(isset($tabvacance['écosse'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['écosse'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
          <li class="eu52"><a href="#wales"><?php
          if (isset($drapeauvacance['Pays de Galles'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Pays de Galles'])."' alt='".strtolower($drapeauvacance['Pays de Galles'])."' /> Pays de Galles".$tabzones['Pays de Galles']."</h2></center>";
          else echo "<center><h2>Pays de Galles".$tabzones['Pays de Galles']."</h2></center>";
            if(isset($tabvacance['Pays de Galles'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Pays de Galles'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?></a></li>
      </ul>
    </div>
    <!-- END OF THE CSSMap - Europe -->
    <div class="row">
      <div class="col-md-9 block">
        <a class="btn btn-success hvr-sweep-to-top right" href="https://www.alpissime.com/" target="_blank">VOIR</a>
  	  </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-sm-1 col-lg-3"></div>
      <div class="col-md-8 col-sm-10 col-lg-8">
        <div id="demo-agents" class="demo-agents-list wrapper demo-agents2">
          <ul>
            <li id="albania"></li>
            <li id="andorra"></li>
            <li id="austria"></li>
            <li id="belarus"></li>
            <li id="belgium"></li>
            <li id="bosnia-and-herzegovina"></li>
            <li id="bulgaria"> </li>
            <li id="croatia"></li>
            <li id="cyprus"></li>
            <li id="czech-republic"></li>
            <li id="denmark"></li>
            <li id="estonia"></li>
            <li id="france"><?php
              echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['France'])."' alt='".strtolower($drapeauvacance['France'])."' /> France".$tabzones['France']."</h2>";
              ?>
              <table class="legendtable sansborder">
                <tr>
                  <td width="140px">
                    <div class="flex margr">
                      <div id="carreorange" style="margin-bottom: 5px;"></div> <span class="indication">&nbsp;&nbsp; <?= __("Zone A") ?></span>
                    </div>
                  </td>
                  <td>
                    <?= __("Besançon, Bordeaux, Clermont-Ferrand, Dijon, Grenoble, Limoges, Lyon, Poitiers") ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="flex margr">
                      <div id="carrezoneb"></div> <span class="indication">&nbsp;&nbsp; <?= __("Zone B") ?></span>
                    </div>
                  </td>
                  <td>
                    <?= __("Aix-Marseille, Amiens, Caen, Lille, Nancy-Metz, Nantes, Nice, Orléans-Tours, Reims, Rennes, Rouen, Strasbourg") ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="flex margr">
                      <div id="carrezonec"></div> <span class="indication">&nbsp;&nbsp; <?= __("Zone C") ?></span>
                    </div>
                  </td>
                  <td>
                    <?= __("Créteil, Montpellier, Paris, Toulouse, Versailles") ?>
                  </td>
                </tr>
              </table>

           </li>
            <li id="finland"></li>
            <li id="georgia"></li>
            <li id="germany"></li>
            <li id="greece"></li>
            <li id="hungary"></li>
            <li id="iceland"></li>
            <li id="ireland"></li>
            <li id="san-marino"></li>
            <li id="italy"></li>
            <!-- NON TROUVE "Kosovo" -->
            <li id="kosovo"></li>
            <li id="latvia"></li>
            <li id="liechtenstein"></li>
            <li id="lithuania"></li>
            <li id="luxembourg"></li>
            <li id="macedonia"></li>
            <li id="malta"></li>
            <li id="moldova"></li>
            <li id="monaco"></li>
            <!-- NON TROUVE "Monténégro" -->
            <li id="montenegro"></li>
            <li id="netherlands"></li>
            <li id="norway"></li>
            <li id="poland"></li>
            <li id="portugal"></li>
            <li id="romania"></li>
            <li id="russian-federation"></li>
            <li id="serbia"></li>
            <li id="slovakia"></li>
            <li id="slovenia"></li>
            <li id="spain"></li>
            <li id="sweden"></li>
            <li id="switzerland"></li>
            <li id="turkey">  </li>
            <li id="ukraine"></li>
            <li id="united-kingdom"></li>
            <li id="england"></li>
            <!-- NON TROUVE "Île de Man" -->
            <li id="isle-of-man"></li>
            <li id="northern-ireland"></li>
            <!-- NON TROUVE "Écosse" -->
            <li id="scotland"></li>
            <!-- NON TROUVE "Pays de Galles" -->
            <li id="wales"></li>
          </ul>
        </div>
      </div>
      <div class="col-md-1 col-sm-1 col-lg-1"></div>
    </div>

    </div>
  </div>


  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <div class="parag_vac center">
        <h2>Calendrier interactif des vacances scolaires françaises,<br><span class="parag_vac2">de l'europe des 27 et de pays européens hors union européenne.</span></h2>
      </div>
    </div>
    <div class="col-md-2"></div>
  </div>
  <div class="row">
    <center>
    <div class="col-md-1"></div>
    <div class="col-md-10">
      <div class="parag_vac_pays">
        Allemagne - Autriche - Belgique - Bulgarie - Chypre - Croatie - Danemark - Espagne - Estonie - Finlande - France - Grèce
        - Hongrie - Irlande - Italie - Lettonie - Lituanie - Luxembourg - Malte - Pays-Bas - Pologne - Portugal - République Tchèque
        - Roumanie - Slovaquie - Slovénie - Suède
        <br><br>Royaume-Uni
        <br><br> Albanie - Biélorussie - Bosnie-Herzégovine - Géorgie - Islande
        - Kosovo - Liechtenstein - Macédoine - Moldavie - Monaco - Monténégro - Norvège - San Marin - Serbie - Suisse
        - Russie - Ukraine et Turquie
      </div>
      </div>
      <div class="col-md-1"></div>
    </center>
  </div>
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
    <div class="der_pag_cal">
      <span class="parag_vac2 dern_parag">l'ensemble découpé selon les administrations en Cantons - Comtés - Conseils Régionaux - Districts - Landers - Provinces - Régions - Voblast et Zones.</span>
      <br>
      <span class="parag_vac2 dern_parag">Informations prises auprès des ministères de l'éducation de chaque pays - (les informations peuvent être partielles).</span>
    </div>
    </div>
    <div class="col-md-1"></div>
  </div>
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10" style="text-align: right;">
      <span class="title-newsletter" style="letter-spacing: 2px;font-size: 20px;">PARTAGER SUR</span>
      <?php $adr = $this->Url->build('/',true)."fr-carte-et-calendrier-vacances-scolaires-europe"; ?>
      <span><a href="https://www.facebook.com/dialog/feed?app_id=145634995501895&link=<?php echo $adr ?>" target="_blank"><img src="<?php echo $this->Url->build('/',true); ?>images/ico/fb.png" alt="partage facebook"></a></span>
      <span><a href="https://twitter.com/share?url=<?php echo urlencode($adr) ?>" target="_blank"><img src="<?php echo $this->Url->build('/',true); ?>images/ico/share_twitter.png" alt="partage twitter"></a></span>
      <span><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($adr) ?>" target="_blank"><img src="<?php echo $this->Url->build('/',true); ?>images/ico/share_linkedin.png" alt="partage linkedin"></a></span>
      <span><a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($adr) ?>" target="_blank"><img src="<?php echo $this->Url->build('/',true); ?>images/ico/share_pin.png" alt="partage pin"></a></span>
    </div>
    <div class="col-md-1"></div>
  </div>


  <br><br>


<script>

$(document).ready(function() {

  // CSSMap;
  $("#map-europe").CSSMap({
    "size": 1280,
    "tooltips": "floating-top-center",
    "responsive": "auto",
    "fitHeight": true,
    "tapOnce": true,
    "agentsList": {
      "enable": true,
      "agentsListId": "#demo-agents",
      "agentsListSpeed": 0,
      "agentsListOnHover": true
    },
    "authorInfo": true,
    onHover: function(e){
      var rLink = e.children("A").eq(0).attr("href"),
      rText = e.children("A").eq(0).text(),
      rClass = e.attr("class").split(" ")[0];
      //alert(rText);
    }
  });
  // END OF THE CSSMap;
  var is_touch_device = function(){
       try{
           document.createEvent("TouchEvent");
             return "true";
            } catch(e){
                return "false";
               }
      }
      if (is_touch_device() == "true"){
        document.getElementById("albania").innerHTML = "<?php
          if (isset($drapeauvacance['Albanie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Albanie'])."' alt='".strtolower($drapeauvacance['Albanie'])."' /> Albanie".$tabzones['Albanie']."</h2>";
          else echo "<h2>Albanie".$tabzones['Albanie']."</h2>";
          if(isset($tabvacance['Albanie'])) {
            echo "<table class='sansborder'>";
            foreach ($tabvacance['Albanie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
          }
        echo "</table>";
      }  ?>";

          document.getElementById("andorra").innerHTML = "<?php
            if (isset($drapeauvacance['Andorre'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Andorre'])."' alt='".strtolower($drapeauvacance['Andorre'])."' /> Andorre".$tabzones['Andorre']."</h2>";
            else echo "<h2>Andorre".$tabzones['Andorre']."</h2>";
            if(isset($tabvacance['Andorre'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Andorre'] as $key ) {
                echo "<tr><td>";
                echo $key;
                echo "</td></tr>";
            }
          echo "</table>";
        }  ?>";

          document.getElementById("austria").innerHTML = "<?php
            if (isset($drapeauvacance['Autriche'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Autriche'])."' alt='".strtolower($drapeauvacance['Autriche'])."' /> Autriche".$tabzones['Autriche']."</h2>";
            else echo "<h2>Autriche".$tabzones['Autriche']."</h2>";
            if(isset($tabvacance['Autriche'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Autriche'] as $key ) {
                echo "<tr><td>";
                echo $key;
                echo "</td></tr>";
            }
          echo "</table>";
        }  ?>";

          document.getElementById("belarus").innerHTML = "<?php
            if (isset($drapeauvacance['Biélorussie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Biélorussie'])."' alt='".strtolower($drapeauvacance['Biélorussie'])."' /> Biélorussie".$tabzones['Biélorussie']."</h2>";
            else echo "<h2>Biélorussie".$tabzones['Biélorussie']."</h2>";
            if(isset($tabvacance['Biélorussie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Biélorussie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?>";

          document.getElementById("belgium").innerHTML = "<?php
            if (isset($drapeauvacance['Belgique'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Belgique'])."' alt='".strtolower($drapeauvacance['Belgique'])."' /> Belgique".$tabzones['Belgique']."</h2>";
            else echo "<h2>Belgique".$tabzones['Belgique']."</h2>";
            if(isset($tabvacance['Belgique'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Belgique'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?>";

          document.getElementById("bosnia-and-herzegovina").innerHTML = "<?php
            if (isset($drapeauvacance['Bosnie-Herzégovine'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Bosnie-Herzégovine'])."' alt='".strtolower($drapeauvacance['Bosnie-Herzégovine'])."' /> Bosnia et Herzegovina".$tabzones['Bosnie-Herzégovine']."</h2>";
            else echo "<h2>Bosnie-Herzégovine".$tabzones['Bosnie-Herzégovine']."</h2>";
            if(isset($tabvacance['Bosnie-Herzégovine'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Bosnie-Herzégovine'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?>";

          document.getElementById("bulgaria").innerHTML = "<?php
            if (isset($drapeauvacance['Bulgarie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Bulgarie'])."' alt='".strtolower($drapeauvacance['Bulgarie'])."' /> Bulgarie".$tabzones['Bulgarie']."</h2>";
            else echo "<h2>Bulgarie".$tabzones['Bulgarie']."</h2>";
            if(isset($tabvacance['Bulgarie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Bulgarie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?>";

          document.getElementById("croatia").innerHTML = "<?php
            if (isset($drapeauvacance['Croatie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Croatie'])."' alt='".strtolower($drapeauvacance['Croatie'])."' /> Croatie".$tabzones['Croatie']."</h2>";
            else echo "<h2>Croatie".$tabzones['Croatie']."</h2>";
            if(isset($tabvacance['Croatie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Croatie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?>";

          document.getElementById("cyprus").innerHTML = "<?php
            if (isset($drapeauvacance['Chypre'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Chypre'])."' alt='".strtolower($drapeauvacance['Chypre'])."' /> Chypre".$tabzones['Chypre']."</h2>";
            else echo "<h2>Chypre".$tabzones['Chypre']."</h2>";
            if(isset($tabvacance['Chypre'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Chypre'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?>";

          document.getElementById("czech-republic").innerHTML = "<?php
            if (isset($drapeauvacance['République tchèque'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['République tchèque'])."' alt='".strtolower($drapeauvacance['République tchèque'])."' /> République tchèque".$tabzones['République tchèque']."</h2>";
            else echo "<h2>République tchèque".$tabzones['République tchèque']."</h2>";
            if(isset($tabvacance['République tchèque'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['République tchèque'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?>";

          document.getElementById("denmark").innerHTML = "<?php
          if (isset($drapeauvacance['Danemark'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Danemark'])."' alt='".strtolower($drapeauvacance['Danemark'])."' /> Danemark".$tabzones['Danemark']."</h2>";
          else echo "<h2>Danemark".$tabzones['Danemark']."</h2>";
            if(isset($tabvacance['Danemark'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Danemark'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?>";

          document.getElementById("estonia").innerHTML = "<?php
          if (isset($drapeauvacance['Estonie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Estonie'])."' alt='".strtolower($drapeauvacance['Estonie'])."' /> Estonie".$tabzones['Estonie']."</h2>";
          else echo "<h2>Estonie".$tabzones['Estonie']."</h2>";
            if(isset($tabvacance['Estonie'])) {
              echo "<table class='sansborder'>";
              foreach ($tabvacance['Estonie'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?>";

          $("#france").append("<?php
            if(isset($tabvacance['France'])) {
            echo "<table class='sansborder'>";
            foreach ($tabvacance['France'] as $key ) {
              echo "<tr><td>";
              echo $key;
              echo "</td></tr>";
            }
          echo "</table>";
        }  ?>");

      document.getElementById("finland").innerHTML = "<?php
      if (isset($drapeauvacance['Finlande'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Finlande'])."' alt='".strtolower($drapeauvacance['Finlande'])."' /> Finlande".$tabzones['Finlande']."</h2>";
      else echo "<h2>Finlande".$tabzones['Finlande']."</h2>";
        if(isset($tabvacance['Finlande'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Finlande'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("georgia").innerHTML = "<?php
      if (isset($drapeauvacance['Géorgie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Géorgie'])."' alt='".strtolower($drapeauvacance['Géorgie'])."' /> Géorgie".$tabzones['Géorgie']."</h2>";
      else echo "<h2>Géorgie".$tabzones['Géorgie']."</h2>";
        if(isset($tabvacance['Géorgie'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Géorgie'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("germany").innerHTML = "<?php
      if (isset($drapeauvacance['Allemagne'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Allemagne'])."' alt='".strtolower($drapeauvacance['Allemagne'])."' /> Allemagne".$tabzones['Allemagne']."</h2>";
      else echo "<h2>Allemagne".$tabzones['Allemagne']."</h2>";
        if(isset($tabvacance['Allemagne'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Allemagne'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("greece").innerHTML = "<?php
      if (isset($drapeauvacance['Grèce'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Grèce'])."' alt='".strtolower($drapeauvacance['Grèce'])."' /> Grèce".$tabzones['Grèce']."</h2>";
      else echo "<h2>Grèce".$tabzones['Grèce']."</h2>";
        if(isset($tabvacance['Grèce'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Grèce'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("hungary").innerHTML = "<?php
      if (isset($drapeauvacance['Hongrie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Hongrie'])."' alt='".strtolower($drapeauvacance['Hongrie'])."' /> Hongrie".$tabzones['Hongrie']."</h2>";
      else echo "<h2>Hongrie".$tabzones['Hongrie']."</h2>";
        if(isset($tabvacance['Hongrie'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Hongrie'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("iceland").innerHTML = "<?php
      if (isset($drapeauvacance['Islande'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Islande'])."' alt='".strtolower($drapeauvacance['Islande'])."' /> Islande".$tabzones['Islande']."</h2>";
      else echo "<h2>Islande".$tabzones['Islande']."</h2>";
        if(isset($tabvacance['Islande'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Islande'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("ireland").innerHTML = "<?php
      if (isset($drapeauvacance['Irlande'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Irlande'])."' alt='".strtolower($drapeauvacance['Irlande'])."' /> Irlande".$tabzones['Irlande']."</h2>";
      else echo "<h2>Irlande".$tabzones['Irlande']."</h2>";
        if(isset($tabvacance['Irlande'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Irlande'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("san-marino").innerHTML = "<?php
      if (isset($drapeauvacance['Saint-Marin'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Saint-Marin'])."' alt='".strtolower($drapeauvacance['Saint-Marin'])."' /> Saint-Marin".$tabzones['Saint-Marin']."</h2>";
      else echo "<h2>Saint-Marin".$tabzones['Saint-Marin']."</h2>";
        if(isset($tabvacance['Saint-Marin'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Saint-Marin'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("italy").innerHTML = "<?php
      if (isset($drapeauvacance['Italie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Italie'])."' alt='".strtolower($drapeauvacance['Italie'])."' /> Italie".$tabzones['Italie']."</h2>";
      else echo "<h2>Italie".$tabzones['Italie']."</h2>";
        if(isset($tabvacance['Italie'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Italie'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("kosovo").innerHTML = "<?php
      if(isset($drapeauvacance['Kosovo'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Kosovo'])."' alt='".strtolower($drapeauvacance['Kosovo'])."' /> Kosovo".$tabzones['Kosovo']."</h2>";
      else{
        echo "<h2>Kosovo".$tabzones['Kosovo']."</h2>";
      }
      if(isset($tabvacance['Kosovo'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Kosovo'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("latvia").innerHTML = "<?php
      if (isset($drapeauvacance['Lettonie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Lettonie'])."' alt='".strtolower($drapeauvacance['Lettonie'])."' /> Lettonie".$tabzones['Lettonie']."</h2>";
      else echo "<h2>Lettonie".$tabzones['Lettonie']."</h2>";
        if(isset($tabvacance['Lettonie'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Lettonie'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("liechtenstein").innerHTML = "<?php
      if (isset($drapeauvacance['Liechtenstein'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Liechtenstein'])."' alt='".strtolower($drapeauvacance['Liechtenstein'])."' /> Liechtenstein".$tabzones['Liechtenstein']."</h2>";
      else echo "<h2>Liechtenstein".$tabzones['Liechtenstein']."</h2>";
        if(isset($tabvacance['Liechtenstein'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Liechtenstein'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("lithuania").innerHTML = "<?php
      if (isset($drapeauvacance['Lituanie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Lituanie'])."' alt='".strtolower($drapeauvacance['Lituanie'])."' /> Lituanie".$tabzones['Lituanie']."</h2>";
      else echo "<h2>Lituanie".$tabzones['Lituanie']."</h2>";
        if(isset($tabvacance['Lituanie'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Lituanie'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("luxembourg").innerHTML = "<?php
      if (isset($drapeauvacance['Luxembourg'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Luxembourg'])."' alt='".strtolower($drapeauvacance['Luxembourg'])."' /> Luxembourg".$tabzones['Luxembourg']."</h2>";
      else echo "<h2>Luxembourg".$tabzones['Luxembourg']."</h2>";
        if(isset($tabvacance['Luxembourg'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Luxembourg'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("macedonia").innerHTML = "<?php
      if (isset($drapeauvacance['ex-République yougoslave de Macédoine'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['ex-République yougoslave de Macédoine'])."' alt='".strtolower($drapeauvacance['ex-République yougoslave de Macédoine'])."' /> Ex-République yougoslave de Macédoine".$tabzones['ex-République yougoslave de Macédoine']."</h2>";
      else echo "<h2>ex-République yougoslave de Macédoine".$tabzones['ex-République yougoslave de Macédoine']."</h2>";
        if(isset($tabvacance['ex-République yougoslave de Macédoine'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['ex-République yougoslave de Macédoine'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("malta").innerHTML = "<?php
      if (isset($drapeauvacance['Malte'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Malte'])."' alt='".strtolower($drapeauvacance['Malte'])."' /> Malte".$tabzones['Malte']."</h2>";
      else echo "<h2>Malte".$tabzones['Malte']."</h2>";
        if(isset($tabvacance['Malte'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Malte'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("moldova").innerHTML = "<?php
      if (isset($drapeauvacance['Moldavie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Moldavie'])."' alt='".strtolower($drapeauvacance['Moldavie'])."' /> Moldavie".$tabzones['Moldavie']."</h2>";
      else echo "<h2>Moldavie".$tabzones['Moldavie']."</h2>";
        if(isset($tabvacance['Moldavie'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Moldavie'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("monaco").innerHTML = "<?php
      if (isset($drapeauvacance['Monaco'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Monaco'])."' alt='".strtolower($drapeauvacance['Monaco'])."' /> Monaco".$tabzones['Monaco']."</h2>";
      else echo "<h2>Monaco".$tabzones['Monaco']."</h2>";
        if(isset($tabvacance['Monaco'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Monaco'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("montenegro").innerHTML = "<?php
        if(isset($drapeauvacance['Monténégro'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Monténégro'])."' alt='".strtolower($drapeauvacance['Monténégro'])."' /> Monténégro".$tabzones['Monténégro']."</h2>";
        else{
          echo "<h2>Monténégro".$tabzones['Monténégro']."</h2>";
        }
        if(isset($tabvacance['Monténégro'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Monténégro'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("netherlands").innerHTML = "<?php
      if (isset($drapeauvacance['Pays-Bas'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Pays-Bas'])."' alt='".strtolower($drapeauvacance['Pays-Bas'])."' /> Pays-Bas".$tabzones['Pays-Bas']."</h2>";
      else echo "<h2>Pays-Bas".$tabzones['Pays-Bas']."</h2>";
        if(isset($tabvacance['Pays-Bas'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Pays-Bas'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("norway").innerHTML = "<?php
      if (isset($drapeauvacance['Norvège'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Norvège'])."' alt='".strtolower($drapeauvacance['Norvège'])."' /> Norvège".$tabzones['Norvège']."</h2>";
      else echo "<h2>Norvège".$tabzones['Norvège']."</h2>";
        if(isset($tabvacance['Norvège'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Norvège'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("poland").innerHTML = "<?php
      if (isset($drapeauvacance['Pologne'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Pologne'])."' alt='".strtolower($drapeauvacance['Pologne'])."' /> Pologne".$tabzones['Pologne']."</h2>";
      else echo "<h2>Pologne".$tabzones['Pologne']."</h2>";
        if(isset($tabvacance['Pologne'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Pologne'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("portugal").innerHTML = "<?php
      if (isset($drapeauvacance['Portugal'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Portugal'])."' alt='".strtolower($drapeauvacance['Portugal'])."' /> Portugal".$tabzones['Portugal']."</h2>";
      else echo "<h2>Portugal".$tabzones['Portugal']."</h2>";
        if(isset($tabvacance['Portugal'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Portugal'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("romania").innerHTML = "<?php
      if (isset($drapeauvacance['Roumanie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Roumanie'])."' alt='".strtolower($drapeauvacance['Roumanie'])."' /> Roumanie".$tabzones['Roumanie']."</h2>";
      else echo "<h2>Roumanie".$tabzones['Roumanie']."</h2>";
        if(isset($tabvacance['Roumanie'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Roumanie'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("russian-federation").innerHTML = "<?php
      if (isset($drapeauvacance['Russie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Russie'])."' alt='".strtolower($drapeauvacance['Russie'])."' /> Russie".$tabzones['Russie']."</h2>";
      else echo "<h2>Russie".$tabzones['Russie']."</h2>";
        if(isset($tabvacance['Russie'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Russie'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("serbia").innerHTML = "<?php
      if (isset($drapeauvacance['Serbie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Serbie'])."' alt='".strtolower($drapeauvacance['Serbie'])."' /> Serbie".$tabzones['Serbie']."</h2>";
      else echo "<h2>Serbie".$tabzones['Serbie']."</h2>";
        if(isset($tabvacance['Serbie'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Serbie'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("slovakia").innerHTML = "<?php
      if (isset($drapeauvacance['Slovaquie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Slovaquie'])."' alt='".strtolower($drapeauvacance['Slovaquie'])."' /> Slovaquie".$tabzones['Slovaquie']."</h2>";
      else echo "<h2>Slovaquie".$tabzones['Slovaquie']."</h2>";
        if(isset($tabvacance['Slovaquie'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Slovaquie'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("slovenia").innerHTML = "<?php
      if (isset($drapeauvacance['Slovénie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Slovénie'])."' alt='".strtolower($drapeauvacance['Slovénie'])."' /> Slovénie".$tabzones['Slovénie']."</h2>";
      else echo "<h2>Slovénie".$tabzones['Slovénie']."</h2>";
        if(isset($tabvacance['Slovénie'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Slovénie'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("spain").innerHTML = "<?php
      if (isset($drapeauvacance['Espagne'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Espagne'])."' alt='".strtolower($drapeauvacance['Espagne'])."' /> Espagne".$tabzones['Espagne']."</h2>";
      else echo "<h2>Espagne".$tabzones['Espagne']."</h2>";
        if(isset($tabvacance['Espagne'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Espagne'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("sweden").innerHTML = "<?php
        if (isset($drapeauvacance['Suède'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Suède'])."' alt='".strtolower($drapeauvacance['Suède'])."' /> Suède".$tabzones['Suède']."</h2>";
        else{
          echo "<h2>Suède".$tabzones['Suède']."</h2>";
        }
        if(isset($tabvacance['Suède'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Suède'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("switzerland").innerHTML = "<?php
      if (isset($drapeauvacance['Suisse'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Suisse'])."' alt='".strtolower($drapeauvacance['Suisse'])."' /> Suisse".$tabzones['Suisse']."</h2>";
      else echo "<h2>Suisse".$tabzones['Suisse']."</h2>";
        if(isset($tabvacance['Suisse'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Suisse'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("turkey").innerHTML = "<?php
      if (isset($drapeauvacance['Turquie'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Turquie'])."' alt='".strtolower($drapeauvacance['Turquie'])."' /> Turquie".$tabzones['Turquie']."</h2>";
      else echo "<h2>Turquie".$tabzones['Turquie']."</h2>";
        if(isset($tabvacance['Turquie'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Turquie'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("ukraine").innerHTML = "<?php
      if (isset($drapeauvacance['Ukraine'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Ukraine'])."' alt='".strtolower($drapeauvacance['Ukraine'])."' /> Ukraine".$tabzones['Ukraine']."</h2>";
      else echo "<h2>Ukraine".$tabzones['Ukraine']."</h2>";
        if(isset($tabvacance['Ukraine'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Ukraine'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("united-kingdom").innerHTML = "<?php
      if (isset($drapeauvacance['Royaume-Uni'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Royaume-Uni'])."' alt='".strtolower($drapeauvacance['Royaume-Uni'])."' /> Royaume-Uni".$tabzones['Royaume-Uni']."</h2>";
      else echo "<h2>Royaume-Uni".$tabzones['Royaume-Uni']."</h2>";
        if(isset($tabvacance['Royaume-Uni'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Royaume-Uni'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("england").innerHTML = "<?php
      if (isset($drapeauvacance['Angleterre'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Angleterre'])."' alt='".strtolower($drapeauvacance['Angleterre'])."' /> Angleterre".$tabzones['Angleterre']."</h2>";
      else echo "<h2>Angleterre".$tabzones['Angleterre']."</h2>";
        if(isset($tabvacance['Angleterre'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Angleterre'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("isle-of-man").innerHTML = "<?php
        if(isset($drapeauvacance['Ile de Man'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Ile de Man'])."' alt='".strtolower($drapeauvacance['Ile de Man'])."' /> Île de Man".$tabzones['Ile de Man']."</h2>";
        else{
          echo "<h2>Île de Man".$tabzones['Ile de Man']."</h2>";
        }
        if(isset($tabvacance['Ile de Man'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Ile de Man'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("northern-ireland").innerHTML = "<?php
      if (isset($drapeauvacance['Irlande du Nord'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Irlande du Nord'])."' alt='".strtolower($drapeauvacance['Irlande du Nord'])."' /> Irlande du Nord".$tabzones['Irlande du Nord']."</h2>";
      else echo "<h2>Irlande du Nord".$tabzones['Irlande du Nord']."</h2>";
        if(isset($tabvacance['Irlande du Nord'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Irlande du Nord'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("scotland").innerHTML = "<?php
        if(isset($drapeauvacance['écosse'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['écosse'])."' alt='".strtolower($drapeauvacance['écosse'])."' /> Écosse".$tabzones['écosse']."</h2>";
        else{
          echo "<h2>Écosse".$tabzones['écosse']."</h2>";
        }
        if(isset($tabvacance['écosse'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['écosse'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";

      document.getElementById("wales").innerHTML = "<?php
      if (isset($drapeauvacance['Pays de Galles'])) echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Pays de Galles'])."' alt='".strtolower($drapeauvacance['Pays de Galles'])."' /> Pays de Galles".$tabzones['Pays de Galles']."</h2>";
      else echo "<h2>Pays de Galles".$tabzones['Pays de Galles']."</h2>";
        if(isset($tabvacance['Pays de Galles'])) {
          echo "<table class='sansborder'>";
          foreach ($tabvacance['Pays de Galles'] as $key ) {
          echo "<tr><td>";
          echo $key;
          echo "</td></tr>";
        }
      echo "</table>";
    }  ?>";



      }
});
</script>
</body>
</html>
