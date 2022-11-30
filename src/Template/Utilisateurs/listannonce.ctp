<style>
	img.thumb-detail-annonce.img-fluid {
		height: 220px;
		object-fit: cover;
	}
</style>
<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="mes_annonces" class="container">
<div class="row justify-content-between mb-5">
      <div class="col espace-menu">
        <h3 class="float-left  mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/edit/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Coordonnées") ?></a></h3>
        <?php if($this->Session->read('Auth.User.nature')!='CLT'){?>
        <h3 class="border-bottom-menu-espace float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Annonces") ?></a></h3>
        <h3 class="float-left  mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['infobancaire'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Paiements") ?></a></h3>
		<h3 class="float-left  mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation"><?= __("Réservations") ?></a></h3>
        <?php }else{ ?>
		<h3 class="float-left  mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a></h3>
		<?php } ?>
        <h3 class="float-left"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a></h3>
      </div>
      <?php if($this->Session->read('Auth.User.nature')=='CLT'){?>
      <div class="col-auto align-self-end">
        <h3 class="text-blue"><?= __("Espace") ?> <?php if($this->Session->read('Auth.User.nature')=='CLT') echo  __("Locataire"); else echo  __("Propriétaire");?></h3>
      </div>
	  <?php }?>
	  <?php echo $this->Flash->render() ?>
	</div>
	
<?php if(empty($annonces->toArray())) echo  __("<center>Vous n'avez aucune annonce</center>"); ?>
<?php foreach($annonces as $ann):?>
	<?php 	                                
	$str = str_replace("é","e",$ann->titre);
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
	$str = str_replace("²","",$str); ?>
<div class="row mb-3">
    <div class="col-md-12">
		<div class="row border mx-0">
			<div class="col-md-4 p-0 img-detail-annonce">
				<a href="<?php echo $this->Url->build('/',true).$urlLang;?>detail/<?php echo $ann->id ?>-<?php echo strtolower($str) ?>">
				<?php if($firstphoto[$ann->id]){ ?><img src="<?php echo $this->Url->build('/',true)?>images_ann/<?php echo $ann->id?>/vignette-<?php echo $ann->id?>-<?php echo $firstphoto[$ann->id]->numero; ?>.P.jpg?v=<?php echo (time()*1000); ?>" alt="" class="img-fluid thumb-detail-annonce w-100"><?php }else{ ?>
				<img src="<?php echo $this->Url->build('/',true)?>images_ann/no_annonce_image.jpg" alt="" class="img-fluid thumb-detail-annonce w-100"><?php } ?>
				</a>
			</div>
			<div class="col-md-8 my-3 align-self-center content-detail-annonce">
			<div class="row justify-content-between">
			<div class="col"><span><?= __("Annonce N°") ?> </span> <?php echo $ann->id?></div>
			<div class="col-auto"><span class="btn text-white bg-orange px-4 cursor-auto py-0"><?php echo $l_annoncesstatuts[$ann->statut];?></span></div>
			</div>
			<div class="row my-3">
				<div class="col">
					<a class="text-body" href="<?php echo $this->Url->build('/',true).$urlLang;?>detail/<?php echo $ann->id ?>-<?php echo strtolower($str) ?>".html">
						<h2><?php echo $ann->titre?></h2>
					</a>
				</div>
			</div>
			<div class="row mt-3">
				<div class="col-auto">
					<button class="btn btn-blue rounded-0 text-white px-2 px-md-4" onclick="window.location.href='<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces'];?>/edit/<?php echo $ann->id?>'"><?= __("Modifier mon annonce") ?></button>
				</div>
				<div class="col">
					<button class="btn btn-blue rounded-0 text-white px-2 px-md-3 px-lg-6" onclick="window.location.href='<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['dispos'];?>/view/<?php echo $ann->id?>'"><?= __("Planning") ?></button>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
<?php endforeach;?>                                              
</div>
<div class="modal fade" id="plusdetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel"><?= __("Détails de votre message") ?></h4>
			      </div>
			      <div class="modal-body">
							<div id="reservation_list" class="col-md-12 gray_background block">

							</div>
			      </div>
			      <div class="modal-footer">
			      </div>
			    </div>
			  </div>
			</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><?= __("Supprimer l'annonce") ?></h4>
        </div>
<div class="modal-body">
                  <center><p><?= __("Voulez-vous supprimer cette annonce") ?></p></center>

        </div>
        <div class="modal-footer">
                  <button type="button" class="btn btn-retour" data-dismiss="modal" aria-label="Close"><?= __("Non") ?></button>
                  <button type="button" class="btn btn-success hvr-sweep-to-top" onclick="deleteAnnonce();"><?= __("Oui") ?></button>
        </div>

      </div>
    </div>
</div>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
var idAnnonce=0;
function show_popup(id_annonce){
    $('#reservation_list').html('<center><img src="<?php echo $this->Url->build('/',true)?>/images/loading.gif"/></center>');
    $('#plusdetails').modal('show');
    $.ajax({
        type: "GET",
        url: "<?php echo $this->Url->build('/',true)?>annonces/statistique/"+id_annonce,
        success:function(xml){
            $('#reservation_list').html(xml)
        }
    });
}
$('.deleteAnnonce').click(function(){
    idAnnonce=$(this).attr('data-key');
});
function deleteAnnonce(){
    $.ajax({
        type: "POST",
        url: "<?php echo $this->Url->build('/',true)?>annonces/annonce_delete",
        data: {annonceId : idAnnonce},
        success : function(data)
        {
            if(typeof data.error !== 'undefined')
                {
                    alert("<?php echo __("erreur de suppression"); ?>");
                    $('#deleteModal').modal('hide');
                }
            else
                location.reload();
        },
        error : function(){
            $('#deleteModal').modal('hide');
            alert("<?php echo __("erreur de suppression"); ?>");
        },
        complete:function(){
            idAnnonce=0;
        }
    });
}
<?php $this->Html->scriptEnd(); ?>
