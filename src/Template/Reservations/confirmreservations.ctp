<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>


<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
function validateForm(){
    var block;
    $.ajax({
      type: "POST",
      dataType : 'json',
      async: false,
      url: "<?php echo $this->Url->build('/',true)?>reservations/blockreduction/",
      data: {debut:$("#dbt_at").val(), fin:$("#dt_d").val(), ann_id: <?php echo $annonce->id ?>, modelemail: "creationReservationLocpaiementdirect"},
      success:function(xml){
        block = xml.blockdetail;
        $("#creationReservationLocpaiementdirectHidden").val(block);
      }
    });
  var test = '';
  for(i = 1; i < $("#nb-adultes").val(); i++){
    //alert($("#num_tel"+i).val());

    var telInput = $("#num_tel"+i),	errorMsg = $("#error-msg"+i),	validMsg = $("#valid-msg");
    if ($.trim(telInput.val())) {
      if (telInput.intlTelInput("isValidNumber")) {
        validMsg.removeClass("hide");
        validNum = telInput.intlTelInput("getNumber");
        $("#num_tel"+i).val(validNum);
      } else {
        test = "non";
        validNum = "non";
        telInput.addClass("errorNumberTel");
        errorMsg.removeClass("hide");
        errorMsg.addClass("errorNumberTel");
      }
    }
  }
  if(test != '') {
    alert("Vérifier la saisie des numéros");
    return false;
  }else return true;

 //return true;
}
<?php $this->Html->scriptEnd(); ?>

<div style="padding-top:30px;">
<?php
$a_adult=array();
for($i=1;$i<19;$i++){
	$a_adult[$i]=$i;
}
$a_child=array();
for($i=0;$i<17;$i++){
	$a_child[$i]=$i;
}
    /*$firstDate=""; $lastDate=""; $lesDisposID="";

        $firstDate = $dispos->dbt_at;
        $lastDate = $dispos->fin_at;
        $lesDisposID=$dispos->id;*/


?>
<?php setLocale(LC_ALL,"fr_FR.UTF8") ?>
<?php echo $this->Session->flash()?>
<div id="confirmreservation" class="container-fluid">

	<?php echo $this->Form->create(null,["url"=>["controller"=>"reservations","action"=>"add"], 'onsubmit'=>'return validateForm()']);?>

			<?php echo $this->Form->input("annonce_id",['type'=>'hidden','value'=>$annonce->id]);?>

			<?php echo $this->Form->input("proprietaire_id",['type'=>'hidden','value'=>$annonce->proprietaire_id]);?>
			<?php echo $this->Form->input("utilisateur_id",['type'=>'hidden','value'=>$this->Session->read('Auth.User.id')]);?>
			<?php 
                        if($annonce->paiement_reservation == 0) echo $this->Form->input("statut",['type'=>'hidden','value'=>'0']);
                        else echo $this->Form->input("statut",['type'=>'hidden','value'=>'90']);
                        ?>
                        <?php echo $this->Form->input("creationReservationLocpaiementdirectHidden",['type'=>'hidden','value'=>'']); ?>
			<?php echo $this->Form->input("dbt_at",['type'=>'hidden','value'=>$resultatDetail['du']->i18nFormat('dd-MM-yyyy')])?>
			<?php echo $this->Form->input("fin_at",['type'=>'hidden','value'=>$resultatDetail['au']->i18nFormat('dd-MM-yyyy')])?>
			<?php echo $this->Form->input("disposID",["type"=>"hidden","value"=>$resultatDetail['dispoID']])?>



	<div class="row">
		<div class="col-md-12">
		<center>
      <strong>
					<p class="txt-norma">
					Vous avez placé une option sur la location : <span class="orange"><?php echo html_entity_decode($annonce->titre)?></span>
				</p>
				<p class="txt-norma">
				Située à <span class="orange"><?php echo html_entity_decode($lieugeo->name)?></span></p>
        <p>
				Pour la période : <span class="orange">du <?php echo $resultatDetail['du']->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::NONE]);?> au <?php echo $resultatDetail['au']->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::NONE]);?></span>
      </p>
      </strong>
      <?php if($resultatDetail['nbrperiode'] == 1){ ?>

        <p>Prix période : <span class="orange"> <?php echo number_format($resultatDetail['prixjour'][1], 2, '.', '') ?> € / jour x <?php echo $resultatDetail['nbrsejour'][1] ?> jours</span></p>
        <strong><p class="totalper">Total : <span class="orange"> <?php echo number_format($resultatDetail['total'], 2, '.', '') ?> € </span></p></strong>
      <?php }else{ ?>
        <strong><p>Prix :</p></strong>
        <table>

            <?php for($i = 1; $i <= $resultatDetail['nbrperiode']; $i++){ ?>
              <tr>
            <td><p>Période <?php echo $i ?> : <span class="orange">du <?php echo $resultatDetail['periodedu'][$i]->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::NONE]);?> au <?php echo $resultatDetail['periodeau'][$i]->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::NONE]);?></span></p></td>
            <td><p>Prix période : <span class="orange"> <?php echo number_format($resultatDetail['prixjour'][$i], 2, '.', '') ?> € / jour x <?php echo $resultatDetail['nbrsejour'][$i] ?> jours</span></p></td>
            <td><p> = <span class="orange"> <?php echo number_format($resultatDetail['totalperiode'][$i], 2, '.', '') ?> € </span></p></td>
            </tr>
            <?php } ?>

        </table>

        <strong><p class="totalper">Total : <span class="orange"> <?php echo number_format($resultatDetail['total'], 2, '.', '') ?> € </span></p></strong>
      <?php } ?>
	  <p>Total à payer (avec taxe de séjour + frais de service) <?php echo $totalapayer; ?></p>
	  <input type="hidden" id="totalapayer" name="totalapayer" value="<?php echo $totalapayer; ?>">
      <br/>
      <p class="text-primary font-weight-bold font-italic">Vous serez rediriger vers la boutique dans 10 secondes !</p>
</center>
		</div>
	</div>

<?php echo $this->Form->end();?>
</div>
</div>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>

jQuery(document).ready(function() {
  
  /* Fonction boutique */
  $.ajax({
    type: "POST",
    dataType : 'json',
    url: "<?php echo $this->Url->build('/',true)?>reservations/ajoutreservationpanier",
    data: {IDreserv: <?php echo $IDreserv; ?>},
    success:function(xml){ 
      console.log(xml.redirectUrl);  
      window.location.href = xml.redirectUrl;
      console.log(xml);
    }
  });
document.getElementById("listenum").style.display = 'none';
  $('#nb-adultes').on( "change", function() {
    document.getElementById("listenum").style.display = 'block';
    $('#numl').html('');
    for (i = 1; i < $(this).val(); i++) {
      $('#numl').append("<input type='text' name='telephoneNum"+ i +"' id='num_tel"+ i +"' class='form-control' size='45' autocomplete='off'><span id='error-msg"+ i +"' class='hide'><?= __("Numéro invalide") ?></span><br><br>");

      var telInput = $("#num_tel"+i),
        errorMsg = $("#error-msg"+i);
        telInput.intlTelInput({
                      utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                      initialCountry: 'fr',
                      autoPlaceholder: true
                    });
                    var reset = function() {
                      telInput.removeClass("errorNumberTel");
                      errorMsg.addClass("hide");
                    };


      // on keyup / change flag: reset
      telInput.on("keyup change", reset);

    }
      //alert($(this).val());
  });



});
<?php $this->Html->scriptEnd(); ?>
