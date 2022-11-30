<style>
#ajoutel .intl-tel-input, #blocajouttel1 .intl-tel-input {
    width: 90%;
    /* vertical-align: middle; */
}
.intl-tel-input{
  width: 90%;
}
#dbt_at {
    background: white;
}
/* select#nb_adult_get {
    width: 20%;
} */
</style>

<script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>js/datepicker.fr.js"></script>

 <?php setlocale (LC_ALL, 'fr_FR.UTF8'); ?>
 	 <?php echo $this->Form->create(null,["url"=>["controller"=>"reservations","action"=>"editReservationProprietaire"],'onsubmit'=>'return test()'])?>

    <input type="hidden" id="editReservationPropHidden" name="editReservationPropHidden" />
    <input type="hidden" id="hdid" name="hdid" value="<?php echo $reservation->id?>" />
    <input type="hidden" id="nbrrestel" name="nbrrestel" value="<?php echo $nbrrestel?>" />
    <input type="hidden" id="nbrrestelajout" name="nbrrestelajout" value="<?php echo $nbrrestel?>" />
		<input type="hidden" id="utilisteur_id" name="utilisteur_id" value="<?php echo $reservation->utilisateur_id?>" />
    <input type="hidden" id="nbrrestel" name="nbrrestel" value="<?php echo $nbrrestel?>" />
    <input type="hidden" id="nbrrestelajout" name="nbrrestelajout" value="<?php echo $nbrrestel?>" />

<table class="table table-bordered" cellpadding="0" cellspacing="0" border="0"  class="d-info">
<tr>
		<th class="border-bottom-0"><?= __("Date d'arrivée") ?></th>
		<td class="border-bottom-0">
		
		<input type="text" class="form-control calendrier" readonly='readonly' id="dbt_at" name="dbt_at" value="<?php echo $reservation->dbt_at->i18nFormat('dd-MM-yyyy') ?>"/>
    
    <?php if($reservation->statut==90): ?>
    <p id="resultatdispo"></p>
        <div class="divarriveetot">
            <input type="hidden" name="location_au" id="location_au" />
            <input type="hidden" name="annonceid" id="annonceid" value="<?php echo $reservation->annonce_id?>" />
            <div class="row result_rech">
              <p id="periodedispo"></p>
            </div> 
        </div>
        
    <?php endif; ?>
    </td>
	</tr>
	<tr>
		<th class="border-top-0"><?= __("Date de départ") ?></th>
		<td class="border-top-0">
		<input type="text" readonly='readonly' id="dt_d" name="dt_d" value="<?php echo $reservation->fin_at->i18nFormat('dd-MM-yyyy')?>" class="form-control" />
        </td>
	</tr>
  <?php 
  $date1 = new DateTime();
  $date2 = new DateTime($reservation->dbt_at->i18nFormat('dd-MM-yyyy'));
  $date3 = new DateTime($reservation->fin_at->i18nFormat('dd-MM-yyyy'));

  if($reservation->type != 0){
    if($infoprop->email != $utilisateur->email){ ?>
  <tr>
		<th><?= __("E-mail") ?></th>
		<td><input type="text" name="email" class="form-control" id="email" value="<?php echo $utilisateur->email?>"/></td>
	</tr>
  <tr>
		<th><?= __("Numéro de portable") ?></th>
		<td>
      <input type="text" id="portable" name="portable" class="form-control" value="<?php echo $utilisateur->portable?>" style="width:100%"/>
      <p id="error-msgl" class="hide"><?= __("Numéro invalide") ?></p>
      </td>
	</tr>
  <?php }
  }else if($reservation->statut == 90 && $date1 < $date3){ ?>
  <tr>
		<th><?= __("Numéro de portable") ?></th>
		<td>
    <input type="text" id="portable" name="portable" class="form-control" readonly='readonly' value="<?php echo $utilisateur->portable?>" style="width:100%"/>
    </td>
	</tr>
  <?php } ?>
	<!-- <tr>
		<th>E-mail</th>
		<td><input type="text" readonly='readonly' name="email" class="form-control" id="email" value="<?php //echo $utilisateur->email?>"/></td>
	</tr> -->
	<!-- <tr>
		<th>Numéro de téléphone</th>
		<td><input type="text" name="tel" id="tel" class="form-control" value="<?php //echo $utilisateur->telephone?>" style="width:100%"/>
    <p id="error-msg" class="hide"><?= __("Numéro invalide") ?></span></p>
	</tr> -->
	<!-- <tr>
		<th>Liste numéros de portable</th>
		<td>
      <input type="text" id="portable" name="portable" class="form-control" value="<?php //echo $utilisateur->portable?>" style="width:100%"/>
      <p id="error-msgl" class="hide"><?= __("Numéro invalide") ?></p>
      <br><br>
      <?php //$itel = 1; foreach ($restel as $key => $value) { ?>
        <div id='blocajouttel<?php //echo $itel ?>'>
        <input type='text' name='telephoneNum<?php //echo $itel ?>' id='num_tel<?php //echo $itel ?>' class='form-control' size='45' autocomplete='off' value="<?php //echo $value->num_tel?>" style="width:95%">
        <input type="hidden" id="hdidtel<?php //echo $itel ?>" name="hdidtel<?php //echo $itel ?>" value="<?php //echo $value->id?>" />
        <a id="sup<?php //echo $itel ?>" title="Supprimer" style="cursor:pointer" onclick="deleteResTel(<?php //echo $value->id?>, <?php //echo $itel ?>)" src="<?php //echo $this->Url->build('/',true) ?>images/delete.png"><i class="fa fa-times fa-lg"></i></a>
        <p id='error-msg<?php //echo $itel ?>' class='hide'><?= __("Numéro invalide") ?></p>
        <br><br>
        </div>
      <?php //$itel = $itel+1;} ?>
      <div id="ajoutel"></div>
      <br>
      <div id="boutonajouttel"><button type="button" class="btn ajtnum btn-blue text-white rounded-0" onclick="ajoutertel()">Ajouter numéro</button></div>
  </td>
	</tr> -->
	<tr>
		<th class="border-bottom-0"> <?= __("Nombre d'adultes (à partir de 18 ans)") ?></th>
		<td class="border-bottom-0">
		<select class="form-control" id='nb_adult_get' name="nb_adult_get">
		<?php for($i=1;$i<19;$i++):?>
		<option <?php if($i==$reservation->nb_adultes) echo "SELECTED"?> value="<?php echo $i?>"><?php echo $i ?></option>
		<?php endfor;?>
		</select>
		</td>
	</tr>
	<tr>
		<th class="border-top-0"> <?= __("Nombre d'enfants de 0 à 18 ans") ?></th>
		<td class="border-top-0">
		<select class="form-control" id='nb_child_get' name="nb_child_get">
		<?php for($i=0;$i<17;$i++):?>
		<option <?php if($i==$reservation->nb_enfants) echo "SELECTED"?> value="<?php echo $i?>"><?php echo $i ?></option>
		<?php endfor;?>
		</select>
		</td>
	</tr>
  <?php if($annonceContrat == 1 && $reservation->type == 1){ ?>
    <tr>
      <th ><?= __("Taxe de séjour gérée par alpissime") ?></th>
      <td >
        <input type="radio" value="0" id="taxe_0" name="taxe" <?php if($reservation->taxe==0) echo "CHECKED"?>/>&nbsp;<?= __('Non'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" value="1" id="taxe_1" name="taxe" <?php if($reservation->taxe==1) echo "CHECKED"?>/>&nbsp;<?= __('Oui'); ?>
      </td>
    </tr>
  <?php } ?>	
	<tr>
		<th valign="top" class="last"><?= __("Commentaire") ?><br><small><?= __("Indiquer ici les commentaires relatifs à la <br>réservation. Si vous souhaitez modifier la date<br> d'arrivée ou de départ, utilisez les calendriers<br> ci-dessus.") ?></small></th>
		<td class="last" style="padding-top:5px;">
			<textarea class="form-control" name="comment" id="comment" rows=2 cols=3><?php echo html_entity_decode($reservation->comment)?></textarea>
		</td>
	</tr>
  <tr>
		<th valign="top" class="last"><?= __("Commentaire locataire") ?></th>
		<td class="last" style="padding-top:5px;">
			<span id="commentlocataire"><?php echo html_entity_decode($reservation->commentlocataire)?></span>
		</td>
	</tr>
  <?php if($reservation->type == 0 && $calendarsynchroid == 0){ ?>
  <tr>
		<th valign="top" class="last"><?= __("Paiement") ?></th>
		<td class="last" style="padding-top:5px;">
			<span><?php echo $EtatVirement; ?><br><?= __("Virement de {0} € le {1}", [$prixVirement, $dateVirement]) ?></span>
		</td>
	</tr>
  <?php } ?>
	<tr><th></th>

						<td><button type="submit" class="btn btn-blue text-white rounded-0" ><?= __("Sauvegarder") ?></button></td>
     </tr>

</table>
<?php echo $this->Form->end();?>
<?php if($reservation->statut==90): ?>
  <script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>js/moment.min.js"></script>
<?php endif; ?>
<script type="text/javascript">
  //var itel = <?php //echo $itel; ?>;
  function deleteResTel(id, numtel){
    var r = confirm("Vous voulez supprimer ce numéro ?");
    if(r){
      $.ajax({
        type: "POST",
        dataType : 'json',
        url: "<?php echo $this->Url->build('/',true)?>reservations/supprimertel/",
        data: {idtel:id},
        success:function(xml){
          document.getElementById("blocajouttel"+numtel).style.display = 'none';
        }
      });
    }

  }

  function ajoutertel(){

    $('#ajoutel').append("<div id='blocajouttel"+itel+"'><input type='text' name='telephoneNum"+itel+"' id='num_tel"+itel+"' class='form-control' autocomplete='off' style='width:95%'><a id='sup"+itel+"' title='<?= __("Supprimer") ?>' style='cursor:pointer' onclick='deleteTelNou("+itel+")' src='<?php echo $this->Url->build('/',true) ?>images/delete.png'><i class='fa fa-times fa-lg'></i></a><p id='error-msg"+itel+"' class='hide'><?= __("Numéro invalide") ?></p><br><br></div>");
    var telInput = $("#num_tel"+itel),
      errorMsg = $("#error-msg"+itel);
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
    itel = itel+1;
  }

  function deleteTelNou(numtel){
    document.getElementById("blocajouttel"+numtel).style.display = 'none';
  }
</script>
<script type="text/javascript">

function test(){
  var block;
  $.ajax({
    type: "POST",
    dataType : 'json',
    async: false,
    url: "<?php echo $this->Url->build('/',true)?>reservations/blockreduction/",
    data: {debut:$("#dbt_at").val(), fin:$("#dt_d").val(), ann_id: <?php echo $reservation->annonce_id ?>, modelemail: "editReservationProp"},
    success:function(xml){
      block = xml.blockdetail;
      $("#editReservationPropHidden").val(block);
    }
  });
  var test = '';
  if ($.trim(telInput.val())) {
    if (telInput.intlTelInput("isValidNumber")) {
      validMsg.removeClass("hide");
      validNum = telInput.intlTelInput("getNumber");
      $("#tel").val(validNum);
    } else {
      test = "non";
      validNum = "non";
      telInput.addClass("errorNumberTel");
      errorMsg.removeClass("hide");
      errorMsg.addClass("errorNumberTel");
    }
  }
  if ($.trim(telInputP.val())) {
    if (telInputP.intlTelInput("isValidNumber")) {
      validMsg2.removeClass("hide");
      validNum2 = telInputP.intlTelInput("getNumber");
      $("#portable").val(validNum2);
    } else {
      test = "non";
      validNum2 = "non";
      telInputP.addClass("errorNumberTel");
      errorMsg2.removeClass("hide");
      errorMsg2.addClass("errorNumberTel");
    }
  }
  for(i = 1; i < itel; i++){
    var telInputres = $("#num_tel"+i);
    var errorMsgg = $("#error-msg"+i);

    if ($.trim(telInputres.val())) {
      if (telInputres.intlTelInput("isValidNumber")) {
        validNum = telInputres.intlTelInput("getNumber");
        telInputres.val(validNum);
      } else {
        test = "non";
        validNum = "non";
        telInputres.addClass("errorNumberTel");
        errorMsgg.removeClass("hide");
        errorMsgg.addClass("errorNumberTel");
      }
    }
  }
  <?php if($reservation->statut==90): ?>
  var newDatenew = moment($('#dbt_at').val(),'DD-MM-YYYY');
  var dateReservation = moment(getMinDate(),'DD-MM-YYYY');
  var isValid = true;
  if(newDatenew.isBefore(dateReservation))
  {
      isValid = chercherdisponibilite();
      if(isValid!=false){
          $('#msg_periode').html('').hide();
          $('#resultatdispo').html('').hide();
      }
  }else{
      $('#periodedispo').html('');
  }
<?php endif; ?>
//    isValid=false;
  if(test != '')
  {
    return false;
  }
  <?php if($reservation->statut==90): ?>
  else if(!isValid){
      $('html, body').animate({
          scrollTop: $("#dbt_at").offset().top
      }, 1000);
      return false;
  }
<?php endif; ?>
  else {
    $("#nbrrestelajout").val(itel);
    return true;
  }

}
function getMinDate() {
    var minDate = '<?php echo $reservation->dbt_at->i18nFormat('dd-MM-yyyy') ?>';


    return minDate;
}
function getMaxDate() {
    var maxDate = '<?php echo $reservation->fin_at->i18nFormat('dd-MM-yyyy')?>';
	var str1= maxDate.split('-');
	var t1 = new Date(str1[2], str1[1]-1, str1[0]);
	var myNewDate = new Date(t1);
		myNewDate.setDate(myNewDate.getDate() - 1);
		myNewDate =  myNewDate.getDate() + '-' + (myNewDate.getMonth() + 1) + '-' +  myNewDate.getFullYear();

		maxDate = myNewDate;

    return maxDate;
}
<?php if($reservation->statut==90): ?>
  var arrayDate=[getMinDate()];
  function DisableToday(date){
      var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
      return [ arrayDate.indexOf(string) == -1 ];
  }
<?php endif; ?>

    $(document).ready(function() {
      $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);
<?php if($reservation->statut==90): ?>
        $("#dbt_at").datepicker({
        dateFormat: "dd-mm-yy",
        minDate: moment(getMinDate(),'DD-MM-YYYY').subtract(3,'d').format('DD-MM-YYYY'),
        maxDate: getMaxDate(),
        beforeShowDay: DisableToday
        });
        <?php else:?>
        $("#dbt_at").datepicker({
          dateFormat: "dd-mm-yy",
          minDate: getMinDate(),
          maxDate: getMaxDate()
        });
<?php endif;?>
    });
    
    <?php if($reservation->statut==90): ?>

        function chercherdisponibilite(){
        $("#location_au").val($("#dbt_at").val());
        document.getElementById("periodedispo").style.display = 'block';
        document.getElementById("resultatdispo").style.display = 'block';
        var res=true;
     $.ajax({
       type: "POST",
       dataType : 'json',
       async: false,
       url: "<?php echo $this->Url->build('/',true)?>dispos/chercherdisponibiliteTot/"+$("#annonceid").val(),
       data: {debut:$('#location_au').val(), fin:getMinDate()},
       success:function(xml){
//            console.log(xml);
        if(xml.tabDispo.length == 0){
            var deb = moment($('#location_au').val(), ["YYYY-MM-DD", "DD-MM-YYYY"]).format('YYYY-MM-DD');
            var fn = moment(getMinDate(), ["YYYY-MM-DD", "DD-MM-YYYY"]).format('YYYY-MM-DD');
            $('#periodedispo').html("<div style='visibility: hidden;display: flex;' class='form-group radios'><label class='radio-inline'><input type='radio' name='sel' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"' checked><span></span></label></div>");
        }else if(xml.tabDispo.length == 1){
          if(xml.details['statut'][1]==0){
           var deb = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
           var debCal = moment($('#location_au').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
           var fn = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
           var fnCal = moment(getMinDate(),'DD-MM-YYYY').format('YYYY-MM-DD');

            var elim = '';
            var elimCon = '';
              $.each(xml.nbrDiff[1], function(index, value) {
                if(value.toString().indexOf("_") != -1){
                  var tab = value.split("_");
                  var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var Diff = fnDiff.diff(dbtDiff, 'days');
                  var d = tab[0];
                  if(Diff < parseInt(d)){
                    if(dbtDiff.format('YYYY-MM-DD') == deb){
                      deb = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                    }else{
                      fn = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                    }
                    elim = d;
                  }
                  }else{
                    var dbtDiff = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                    var fnDiff = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                    var Diff = fnDiff.diff(dbtDiff, 'days');
                    var d = value;
                    if(Diff < parseInt(d)){
                      if(dbtDiff.format('YYYY-MM-DD') == deb){
                        deb = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                      }else{
                        fn = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                      }
                      elim = d;
                    }
                  }
              });
              if(deb < fn){
                xml.disponi[1] = 'Période : du '+moment(deb,'YYYY-MM-DD').format('DD/MM/YYYY')+' au '+moment(fn,'YYYY-MM-DD').format('DD/MM/YYYY')+' <br>';
              }else{
                xml.disponi[1] = '';
              }
            if((deb == debCal) && (fn == fnCal)){
              if(deb > fn){
                $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PÉRIODE ARRIVÉ TÔT NON DISPONIBLE</span>");
                $('#periodedispo').html('');
                res=false;
              }else{
                $('#periodedispo').html('');
                if(xml.disponi[1] != ''){
                    $('#periodedispo').html("<div style='visibility: hidden;display: flex;' class='form-group radios'><label class='radio-inline'><input type='radio' name='sel' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"' checked><span></span></label></div>");
                }
              }

             }else{
                 $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PÉRIODE ARRIVÉ TÔT NON DISPONIBLE </span><br>");
                 $('#periodedispo').html('');
                 res=false;
            }
            }else{
                $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PÉRIODE ARRIVÉ TÔT NON DISPONIBLE </span><br>");
                $('#periodedispo').html('');
                res=false;
            }
         }else{
           for (i = 0; i < xml.tabDispo.length; i++) {
             if(xml.tabDispo[i]['statut']!=0){
                $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'>PÉRIODE ARRIVÉ TÔT NON DISPONIBLE </span><br>");
                $('#periodedispo').html('');
                res=false;
                break;
             }
           }
            if(res==true){
                deb = moment($('#dbt_at').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
                fn = moment(getMinDate(), ["YYYY-MM-DD", "DD-MM-YYYY"]).format('YYYY-MM-DD');
                $('#periodedispo').html("<div style='visibility: hidden;display: flex;' class='form-group radios'><label class='radio-inline'><input type='radio' name='sel' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"' checked><span></span></label></div>");
            }
         }
        }

       });
     return res;
   }
   <?php endif;?>
</script>