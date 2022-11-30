<!--Form Annomnce + Slider-->
<div id="slide" class="main">
   <div class="row">
     <!-- <div class="col-md-12"> -->
      <div class="col-lg-12 col-md-12">
        <?php  echo $this->element("menu_recherche_bande")?>
      </div>
     <!-- </div> -->
   <!--fin col 12 -->
  </div>
 </div>

<!--app-->
<div id="app" class="hidden-xs hidden-sm">
    <div class="row">
        <div class="col-md-6">
            <a href="https://itunes.apple.com/fr/app/alpissime/id518322529?mt=8" target="_blank">
                <div class="app">
                    <div class="store">
                        <img src="<?php echo $this->Url->build('/',true)?>images/app/appstore.png" alt="Propriétaires">
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="https://play.google.com/store/apps/details?id=com.alpissime.app" target="_blank">
                <div class="app">
                    <div class="store">
                        <img src="<?php echo $this->Url->build('/',true)?>images/app/googleplay.png" alt="Google play">
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<!--/app-->
<?php echo $this->Flash->render(); ?>
<div class="row">
  <div class="col-md-12">

					<h1>Informations et plans</h1>


      <div class="header_title">
              <h4 class="gray-fonce">Informations et plans de Bourg Saint Maurice et des stations des Arcs</h4>
      </div>

      <p class="txt-norma">
        <?php echo str_replace("\n","<br>",$registres->val)?>
      </p>
      <div class="col-md-12">
        <div class="arc row">

              <?php echo $this->Html->link($this->Html->image("arc1600-logo.jpg",array("alt"=>"Voir le plan et les informations sur la station des Arcs 1600","title"=>"Renseignement Arc 1600","class"=>"img-arc")),"/infos-station-arc-1600.html",array("escape" => false))?>

                  <?php echo $this->Html->link($this->Html->image("arc1800-logo.jpg",array("alt"=>"Voir le plan et les informations sur la station des Arcs 1800","title"=>"Renseignement Arc 1800","class"=>"img-arc")),"/infos-station-arc-1800.html",array("escape" => false))?>

                  <?php echo $this->Html->link($this->Html->image("arc1950-logo.jpg",array("alt"=>"Voir le plan et les informations sur la station des Arcs 1950 Le Village","title"=>"Renseignements Arc 1950 Le Village","class"=>"img-arc")),"/infos-station-arc-1950.html",array("escape" => false))?>
                  <?php echo $this->Html->link($this->Html->image("arc2000-logo.jpg",array("alt"=>"Voir le plan et les informations sur la station des Arcs 2000","title"=>"Renseignements Arc 1950 Le Village","class"=>"img-arc")),"/infos-station-arc-2000.html",array("escape" => false))?>


                  <?php echo $this->Html->link($this->Html->image("bourg-saint-maurice-logo.jpg",array("alt"=>"Voir le plan et les informations sur la ville de Bourg St Maurice","title"=>"Renseignements Bourg-Saint-Maurice","class"=>"img-arc")),"/infos-ville-bourg-saint-maurice.html",array("escape" => false))?>

      </div>
      </div>


    </div><!--end col-md-12-->
</div><!--end row-->
