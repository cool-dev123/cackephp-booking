<?php $this->assign('title', __('Location vacances aux Arcs - Bourg Saint Maurice')); ?>
<?php $this->Html->meta(null, null, ['property' => 'og:title','content' => __('Alpissime Location vacances aux Arcs - Bourg Saint Maurice'),'block' => 'meta']); ?>
<?php $this->Html->meta(null, null, ['name' => 'description','content' => __("Location les Arcs - Plus de 400 appartements en location de particuliers à particuliers stations les arcs 1600,arcs 1800,arcs 1950,arcs 2000,bourg saint maurice") ,'block' => 'meta']); ?>

<?php //$this->Html->css("/css/modif_datepicker.min.css", array('block' => 'cssTop')); ?>
<?php //$this->Html->css("/css/styleindexannonces.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/css/newstyleindexannonces.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
var validNum = "non";
jQuery(document).ready(function() {
    /*if (window.matchMedia("(max-width: 767px)").matches) {
      $(".featured-product").height($(".featured-product").width()+150);      
    }*/
    /* if (window.matchMedia("(min-width: 364px) and (max-width: 767px)").matches) {
        $(".datasrc").each(function(){ 
            $(this).attr("src", $(this).attr("data-src"));
        });
    } */
    
    
  $('#popup_password').modal('hide');
  var updated = "<?php echo $this->Session->read('Auth.User.updated') ?>";
  //alert(updated);
  if(updated){
    if(updated == 0){
      $('#popup_password').modal('show');
    }
  }

  });
  function fermer(){
      $('#popup_password').modal('hide');
  }
<?php $this->Html->scriptEnd(); ?>
<?php $this->append('cssTopBlock', '<style>
html {
  height: 100%;
  overflow-x: hidden;
}
.buttonheight{
  height: 50px;
}
@media (max-width: 768px){
.description-product p {
    height: 31px!important;
}
}
</style>'); ?>


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
<?php echo $this->element("boutons_clients")?>



<div id="annonces" class="annonce-home">
	<div class="row">
			<div class="col-md-10">
					<h1><?= __("Les dernières annonces de locations de vacances à la montagne") ?></h1>
			</div>
			<div class="col-md-2">
					<div class="pull-right arrows">
							<a class="prev" href="#myCarousela" data-slide="prev"><i class="fa fa-angle-left fa-lg"></i></a>
							<a class="next" href="#myCarousela" data-slide="next"><i class="fa fa-angle-right fa-lg"></i></a>
							<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
			</div>
			<div class="col-md-12 product">
                            <div id="myCarousela" class="carousel slide clients">
                                <!-- Carousel items -->
                                <div class="carousel-inner">

                                <?php  $test1="active"; $c=0; $y=0; foreach($annonces as $annonce) {
                                   $classe="";
                                    if($annonce['wifi'] > 0 )$classe="pres_annonce_index_2 wifi";else $classe="pres_annonce_index_2 not-wifi";
    //															      if($c++==0) continue;
                                      //for($i=0;$i<27;$i++):
                                    if(fmod($y, 4)==0  ){
                                            echo "<div class='$test1 item'>";
                                            $test1="";
                                            echo " <div class=''>";
                                            echo "<ul class='list-inline products row'>";
                                    }
                                    //for($i=0;$i<27;$i++):
                                      $y++;
                                        echo "<li class='$classe"." col-xs-4 col-sm-6 col-md-3'>";

                                        echo  $this->annonceFormater->vignette2($annonce,$l_distances,$this->Url->build('/',true),$photos,$residence,$minprixannonce,$noteglobalmoytab);
                                        $lannonce = strtolower(trim(formatStr($annonce->titre)));
                                        $lannonce.= ".html";
                                    echo "</li>";
                                        //endfor;
                                    if(fmod($y, 4)==0 ){
                                            echo" </ul>";
                                            echo"</div>";
                                            echo "</div>";
                                                }
                                           }
                                        ?>
                                </div>
                            </div>
                        </div>
            <!--/product-->
			
	</div><!--/row-->
</div><!--/#annonces-->
<div id="slide_pub" class="main annonce-home">
  <div class="row">
      <div class="col-md-12">
<!--           <div class="col-lg-4 col-md-4 search" id="search">
         <?php  //echo $this->element("mon_compte")?>
         <?php  //echo $this->element("menu_recherche")?>
        </div>-->
     <div class="col-lg-12 col-md-12 slideIndex">

              <div id="main-slide" class="carousel slide" data-ride="carousel">
     <!-- Indicators -->
     <ol class="carousel-indicators">
        <?php if($images){$j = 0; foreach($images as $image){if(preg_match('/gif/',$image['image'])||preg_match('/png/',$image['image'])||preg_match('/jpg/',$image['image'])||preg_match('/jpeg/',$image['image'])){?>
         <li data-target="#main-slide" data-slide-to="<?php echo $j; ?>" class="<?php if($j==0) { echo 'active'; }?>"></li>
        <?php }$j = $j+1;}} ?>
     </ol>
     <!--/ Indicators end-->
     <!-- Carousel inner -->
     <div class="carousel-inner">
       <?php if($images){$i = 0; foreach($images as $image){if(preg_match('/gif/',$image['image'])||preg_match('/png/',$image['image'])||preg_match('/jpg/',$image['image'])||preg_match('/jpeg/',$image['image'])){?>
         <div class="item <?php if($i==0) { echo 'active'; } ?>">
             <a href="<?php echo $image['lien']?>" target="blank">
             <img class="img-responsive hidden-xs" src="<?php echo $this->Url->build('/',true)?>img/uploads/<?php echo $image['image']?>" alt="pub <?php echo $image['titre']?>">
             <img class="img-responsive visible-xs" src="<?php echo $this->Url->build('/',true)?>img/uploads/<?php echo $image['image']?>" alt="pub <?php echo $image['titre']?>">
             </a>
             <?php if(!empty($image['text'])){ ?>
             <div class="slider-content">
                 <div class="col-md-12 text-center">
                     <?php echo html_entity_decode($image['text'])?>
                 </div>
             </div>
             <?php } ?>
         </div>
         <?php }$i = $i+1;}}?>
         <!--/ Carousel item end -->
       </div>
       <!-- Carousel inner end-->
       <!-- Controls -->
       <a class="left carousel-control" href="#main-slide" data-slide="prev">
           <span><i class="fa fa-angle-left"></i></span>
       </a>
       <a class="right carousel-control" href="#main-slide" data-slide="next">
           <span><i class="fa fa-angle-right"></i></span>
       </a>
     </div>


          </div>
      </div>
      <!--fin col 12 -->
     </div>
    <div class="col-md-12">
        <hr>
    </div>
</div>
<!--************* End Form Annomnce + Slider-->
<div id="about">
	<div class="row">
<?php foreach($registres as $re):?>
<div class="col-lg-9 col-md-8 border"><div class="text-about"><h2>À propos d'alpissime</h2><?php
echo str_ireplace(array("\r","\n",'\r','\n'),'<br>', $re->val);
//echo $re->val;
?>
	<div class="pull-right">
		<button onclick="window.open('<?php echo $this->Url->build('/',true); ?>infos-plans-stations.html');" class="btn btn-success">Je découvre ma station !</button>

  </div>
</div></div>
<?php endforeach;?>
<div class="col-lg-3 col-md-4">
		<div class="promotion" style="margin-top: 20px;">
				<h3>Service aux <span class="orange">propriétaires</span>
				</h3>
				<div class="carousel slide clients">
						<!-- Carousel items -->
						<div class="carousel-inner">
								<div class="active item">
										<div class="row-fluid">
												<ul class="list-inline">
														<li>
																<div class="featured-slide">
																		<div class=" promos_img">
																				<a href="<?php echo BOUTIQUE_ALPISSIME?>/fr/contrat-de-gestion-de-cles.html" target="blank">
                                          <picture>
                                              <source srcset="<?php echo $this->Url->build('/',true)?>images/products/CONTRAT_DE_GESTION_DE_SEJOUR.webp" type="image/webp">
                                              <source srcset="<?php echo $this->Url->build('/',true)?>images/products/CONTRAT_DE_GESTION_DE_SEJOUR.jpg" type="image/jpeg"> 
                                              <img src="<?php echo $this->Url->build('/',true)?>images/products/CONTRAT_DE_GESTION_DE_SEJOUR.jpg" alt="Promotion" class="produit-annonce-home">
                                          </picture>																								 
																						<div class="view">
																								<span><i
																												class="fa fa-search fa-2x"></i> <?= __("Voir plus") ?></span>
																						</div>
																				</a>
																		</div>
																		<div class="title-slide">
																				<span class="left">Contrat de gestion de séjour</span>
																				<span class="right"><span class="blue">319€</span></span>
																		</div>
																</div>
														</li>
												</ul>
										</div>
								</div>

						</div>
						<!-- /Carousel items -->
				</div>

		</div>
</div>
  </div><!--/row-->
</div><!--/#about-->

<!--/#services-->
<div id="particuliers" class="particuliers-home">
		<div class="row">
				<div class="col-md-10">
						<h2>Les dernières annonces de locations entre particuliers aux Arcs</h2>
				</div>
				<div class="col-md-2">
						<div class="pull-right arrows">
								<a class="prev" href="#myCarousel" data-slide="prev"><i class="fa fa-angle-left fa-lg"></i></a>
								<a class="next" href="#myCarousel" data-slide="next"><i class="fa fa-angle-right fa-lg"></i></a>
								<div class="clearfix"></div>
						</div>
						<div class="clearfix"></div>
				</div>
				<div class="col-md-12 product">
						<div id="myCarousel" class="carousel slide clients">
								<!-- Carousel items -->
								<div class="carousel-inner">

															<?php  $test1="active"; $c=0; $y=0; foreach($annonces as $annonce) {
															   $classe="";
															    if($annonce['wifi'] > 0)$classe="pres_annonce_index_2 wifi";else $classe="pres_annonce_index_2 not-wifi";
//															      if($c++==0) continue;
															      //for($i=0;$i<27;$i++):
                                    if(fmod($y, 4)==0  ){
    																	echo "<div class='$test1 item'>";
    																	$test1="";
    																	echo " <div class=''>";
                                      echo "<ul class='list-inline products row'>";
                                      
    																}
    															      //for($i=0;$i<27;$i++):
    																$y++;
																  echo "<li class='$classe"." col-xs-4 col-sm-6 col-md-3'>";

															      echo  $this->annonceFormater->vignette2($annonce,$l_distances,$this->Url->build('/',true),$photos,$residence,$minprixannonce,$noteglobalmoytab);
                                    $lannonce = strtolower(trim(formatStr($annonce->titre)));
                                    $lannonce.= ".html";
															      echo "</li>";
																  //endfor;
                                  if(fmod($y, 4)==0 ){
  																	            echo" </ul>";
                                                echo"</div>";
  																	       echo "</div>";
  																}
															   }
															?>
												</div>
										</div>
								</div>
						</div>
					<!--</div>-->
          <div class="row">
				<div class="col-md-10">
						<h2>Les dernières annonces de locations entre particuliers au Val d'Allos</h2>
				</div>
				<div class="col-md-2">
						<div class="pull-right arrows">
								<a class="prev" href="#myCarouselval" data-slide="prev"><i class="fa fa-angle-left fa-lg"></i></a>
								<a class="next" href="#myCarouselval" data-slide="next"><i class="fa fa-angle-right fa-lg"></i></a>
								<div class="clearfix"></div>
						</div>
						<div class="clearfix"></div>
				</div>
				<div class="col-md-12 product">
						<div id="myCarouselval" class="carousel slide clients">
								<!-- Carousel items -->
								<div class="carousel-inner">

															<?php  $test1="active"; $c=0; $y=0; foreach($annoncesvaldallos as $annonce) {
															   $classe="";
															    if($annonce['wifi'] > 0)$classe="pres_annonce_index_2 wifi";else $classe="pres_annonce_index_2 not-wifi";
//															      if($c++==0) continue;
															      //for($i=0;$i<27;$i++):
                                    if(fmod($y, 4)==0  ){
    																	echo "<div class='$test1 item'>";
    																	$test1="";
    																	echo " <div class=''>";
                                      echo "<ul class='list-inline products row'>";
                                      
    																}
    															      //for($i=0;$i<27;$i++):
    																$y++;
																  echo "<li class='$classe"." col-xs-4 col-sm-6 col-md-3'>";

															      echo  $this->annonceFormater->vignette2($annonce,$l_distances,$this->Url->build('/',true),$photos,$residence,$minprixannonce,$noteglobalmoytab);
                                    $lannonce = strtolower(trim(formatStr($annonce->titre)));
                                    $lannonce.= ".html";
															      echo "</li>";
																  //endfor;
                                  if(fmod($y, 4)==0 ){
  																	            echo" </ul>";
                                                echo"</div>";
  																	       echo "</div>";
  																}
															   }
															?>
												</div>
										</div>
								</div>
						</div>

					<div class="col-md-12 buttonheight">
							<button class="btn btn-success hvr-sweep-to-top  right" onclick="document.location='<?php echo $this->Url->build('/',true); ?>annonces/recherche/'">Voir toutes les
									annonces
							</button>
					</div>
		<!--</div>/row-->
		<!-- <div class="row">
				<div class="col-md-12">
						<hr>
				</div>
		</div> -->
	</div><!--/#particuliers-->
<!--app-->
<!-- <div id="appdiv" >
    <div class="row">
        <div class="col-md-6">
            <a href="https://itunes.apple.com/fr/app/alpissime/id518322529?mt=8" target="blank">
                <div class="app">
                    <div class="store">
                      <picture>
                          <source srcset="<?php echo $this->Url->build('/',true)?>images/app/appstore.webp" type="image/webp">
                          <source srcset="<?php echo $this->Url->build('/',true)?>images/app/appstore.png" type="image/png"> 
                          <img data-src="<?php echo $this->Url->build('/',true)?>images/app/appstore.png" alt="Propriétaires">
                      </picture>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="https://play.google.com/store/apps/details?id=com.alpissime.app" target="blank">
                <div class="app">
                    <div class="store">
                      <picture>
                          <source srcset="<?php echo $this->Url->build('/',true)?>images/app/googleplay.webp" type="image/webp">
                          <source srcset="<?php echo $this->Url->build('/',true)?>images/app/googleplay.png" type="image/png"> 
                          <img data-src="<?php echo $this->Url->build('/',true)?>images/app/googleplay.png" alt="Google play">
                      </picture>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div> -->
<!--/app-->
  <!--popup update profil-->
  <div class="modal fade" id="popup_password" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="col-md-12 modal-content">
        <div class="modal-header">
          <span class="modal-title h4style"><i class="fa fa-lock fa-lg"></i> Vérification de votre profil</span>
        </div>
        <div class="modal-body">
        <div class="col-md-12 gray_background block">
          <div class="form-group">
            <p class="text-center">
              Dans le cadre de l'amélioration de nos services, Veuillez vérifier vos informations personnelles et ressaisir votre numéro de téléphone.<br><br>
              L'équipe d'Alpissime vous remercie pour votre fidélité .
            </p>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <a class="btn btn-success hvr-sweep-to-top" href="<?php echo $this->Url->build('/',true)?>utilisateurs/edit/<?php echo $this->Session->read('Auth.User.id')?>">Modifier vos coordonnées</a>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
