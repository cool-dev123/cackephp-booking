<?php //$this->Html->css("/css/update.min.css", array('block' => 'cssTop')); ?>
<?php //$this->Html->css("/css/styleindexannonces.min.css", array('block' => 'cssTop')); ?>

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
<section class="pb-5">
    <div class="container">
        <div class="row pb-5">
			<div class="col">
        <h1 class="text-center"><?= __("Location de vacances entre particuliers été et hiver en station de ski") ?></h1>
        <a href="<?php echo $this->Url->build('/', true).$urlLang.$urlvaluemulti['recherche']; ?>" class="float-right font-weight-500 mt-n4 mt-lg-3 mt-xl-n4 voir-plus-land"><?= __("Voir plus") ?></a>
			</div>
		</div>
		<div class="row">
      <div class="col-md-12 product">
        <div id="myCarousela" class="carousel slide clients">
            <!-- Carousel items -->
            <div class="carousel-inner">
            <?php $test="active" ?>
            <?php $x=7; $i=0; for($j=0;$j<=(count($annonces)/8);$j++) {?>

              <div class="<?php echo $test?> carousel-item">
                <?php $test="" ?>
                  <div class="products row">
                    <?php
                    while($i<=$x && $i<count($annonces)) {?>
                        <div class="col-6 col-md-4 col-lg-3 mb-2">
                          <?php //print_r($annonces[$i]) ?>
                          <?php echo $this->element('petite_annonce', array('annonce'=>$annonces[$i], 'photo'=>$photos, 'residence'=>$residence, 'minprixannonce'=>$minprixannonce, 'noteglobalmoy'=>$noteglobalmoytab, 'db'=>'', 'fn'=>'') ); ?>
                        <?php	//echo $this->annonceFormater->vignetterecherche($annonces[$i],$l_distances,$this->Url->build('/', true),$photos,$residence,$minprixannonce,$noteglobalmoytab);
                            // $lannonce = strtolower(trim(formatStr($annonces[$i]->titre)));
                            // $lannonce.= ".html";
                            //echo "<a href='".$this->Url->build('/', true)."detail/".$annonces[$i]->id."-".$lannonce."' class='btn btn-success hvr-sweep-to-top btnrecherchebande'>Réserver</a>";
                        ?>
                       </div>
                      <?php $i++;} $x=$x+8;?>
                    </div>

              </div><!--/active item-->
              <?php }?>
            </div><!--/carousel-inner-->
        </div><!--/#myCarousela-->

      </div><!--/product-->


		</div>
        <!-- <div class="row">
            <button class="btn btn-success hvr-sweep-to-top" style="left: 39%" onclick="document.location='<?php echo $this->Url->build('/', true); ?>annonces/recherche/'">
                Voir toutes les	annonces
            </button>
        </div> -->
	</div>
</section>
<!--/annonces_location -->

