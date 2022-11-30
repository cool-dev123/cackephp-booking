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
<div id="infos_station_arc_1600">
  <?php echo $this->Flash->render(); ?>
  <div class="row">
    <div class="col-md-12">

      <div class="row">
         <div class="col-md-12">
  					<h1>Informations et plans</h1>
         </div>
      </div>

      <div class="row">
          <div class="col-md-12">
            <div class="header_title">
                    <h4 class="gray-fonce">Informations et plans de la station ARC 1600</h4>
            </div><!-- end header_title-->
    </div><!-- end row -->

    <div class="row">
       <div class="col-md-12 block">
         <div class="col-md-2">
           <?php echo $this->Html->link($this->Html->image("arc1600-logo.jpg",array("alt"=>"Voir le plan et les informations sur la station des Arcs 1600","title"=>"Renseignement Arc 1600")),"/infos-station-arc-1600.html",array("escape" => false))?>
         </div><!--end col-md-3-->
        <div class="col-md-10 ">
          <div class="text-about1">
          <?php echo str_replace("\n","<br>",$registres->val)?>
          </div>
        </div><!--end col-md-9 desc-list-->

      </div><!-- end col-md-12 -->


      <div style="display:none" class="col-md-12 block">
        <div class="col-md-12 block">

        <?php echo $this->Html->link($this->Html->image("arc1800_03.png",array("alt"=>"Voir le plan et les informations sur la station des Arcs 1600","title"=>"Renseignement Arc 1600","class"=>"img-arc1600")),"/flash/360-aerien/aerien.html",array("escape" => false))?>
        </div><!--end col-md-12-->
      </div><!--end col-md-12-->

  <div class="col-sm-12">
      <div class="col-sm-12">
      		<div class="pull-right block">
      					<button class="btn btn-success hvr-sweep-to-top " onclick="location.href = '<?php echo $this->Url->build('/',true)?>infos-plans-stations.html';" type="submit" style="margin-right: 0">RETOUR AU STATIONS</button>
      		</div>
      </div>

  </div>

      <div class="row">
		       <div class="col-md-12">
              <div class="col-md-12">
		           	<hr class="dashed">
		      </div>
	   </div>

    </div><!-- end row -->

  </div>
</div>
