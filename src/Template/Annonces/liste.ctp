<!--Form Annomnce -->
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
 <!--************* End Form Annomnce-->
 
<?php  $idStation=$this->request->query["annonce"]["lieugeo"]; //recuperer identifiant de la station afin de pouvoir faire afficher un message special pour chaque station//echo $idStation;?>

<?php $paginatorInformation = $this->Paginator->params(); $totalPageCount = $paginatorInformation['count']; ?>

<div id="mes_annonces" class="mes_annonces"> <!--mes_annonces-->
	<div class="row test_pin"><!--row-->
		<div class="col-md-12"><!--col-md-6-->
			<?php foreach($annonces as $enr){ $id=$a_lieugeos[$enr->lieugeo_id];}?>
			<h2 class="gray_fonce">LOCATION <?php echo $nom_lieugeo ?> <span class="right blue"><?php echo $totalPageCount ?> resultats</span></h2>
			  <div class="annonce block col-md-12 col-sm-12" style="padding: 0;"><!--annonce block-->

          <?php  if ($this->Paginator->counter()>0)
        { //foreach($annonces as $enr) {
          $annonces = $annonces->toArray();
          //print_r ($annonces);

		  //if(!empty($enr->id)){
         ?>
        <?php $x=3; $i=0; for($j=0;$j<=(count($annonces)/4);$j++) {?>
        <div class="row product">
                <div class="col-sm-12">
                    <div class="list-inline products row">
	                     <?php while($i<=$x && $i<count($annonces)) {?>
                            <div class="col-sm-12 col-md-3" id="<?php echo $annonces[$i]->id ?>">
                                    <div class="featured-product">
                                      <?php //print_r ($annonces[$i]->id); ?>
                                        <?php
                                        if($avecdispoval != 'oui'){
                                          // echo "<script> chercherdisponibilite(".$annonces[$i]->id."); </script>";
                                          //print_r($residenceAnnonce[$annonces[$i]->batiment]);
                                          //print_r($marqueurMaps[$annonces[$i]->id]);
                                        	echo $this->annonceFormater->vignette($annonces[$i],$l_distances,$this->Url->build('/',true),$photos,$residenceAnnonce);
                                       }else{
                                         /** CAS A TRAITER POUR LISTE MARQUEURS **/
                                         $annonces[$i] = $annonces[$i]->toArray();
                                         //print_r($a_lieugeos);
                                       echo $this->annonceFormater->vignette_avec_dispo($annonces[$i]['Annonces'],$a_lieugeos,$l_distances,$this->Url->build('/',true),$photos,$residenceAnnonce);

                                     }?>
                                    </div>
                                </div>
	                  <?php $i++;} $x=$x+4;?>
                    </div>
                  </div>
        </div>
        <?php }
        //print_r($marqueurMaps);?>
<?php
  /*  }else{
			//echo $this->annonceFormater->vignette_recherche_avec_dispo($enr['Annonces'],$a_lieugeos,$l_natures_location,$this->Url->build('/',true));
    }*/
  //}
  }
    ?>
			  </div><!-- end annances block-->
       
		</div><!--end col-md-6-->



  </div><!--end row-->
  <div class="row">
    <div class="col-md-12">
			<div class="pagination">
                    <ul class="list-inline"><?php if(!empty($this->Paginator->first('<<'))){ ?>
                 <li><button class="btn btn-default"><?php echo $this->Paginator->first('<<'); ?></button></li>
                            <?php } ?>
                     <?php $affichePages=$this->Paginator->numbers(); if ($affichePages=='') {} else { $affichePages=$this->Paginator->numbers(); echo ($affichePages); } ?>
                 <?php if(!empty($this->Paginator->last('>>'))){ ?>
                 <li><button class="btn btn-default"><?php echo $this->Paginator->last('>>'); ?></button></li>
                   <?php } ?>
                            </ul>			</div><!--end pagination-->
	      </div><!--end col-md-12-->
  </div>
</div> <!-- end mes_annonces-->