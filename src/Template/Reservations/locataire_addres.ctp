<?php $this->Html->scriptStart(array('block' => 'tagmanager')); ?>
	var subok = "<?php echo $_SESSION['SubmitOK']; ?>";
	if(subok == "OK") {
		dataLayer = [{ 'reservation': 'manuelle', 'submitOk': 'OK' }];
	}
  <?php $_SESSION['SubmitOK']=''; ?>
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/css/fullcalendar.css", array('block' => 'cssTop')); ?>
<link href='<?php echo $this->Url->build('/',true)?>css/fullcalendar.print.css' rel='stylesheet' media='print' />
<?php $this->Html->script("/js/moment.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/fullcalendar.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/locale/fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>
<style>
.container {
    overflow: hidden;
}
body {
    overflow: visible;
}
a.fc-day-grid-event::before {
    border-top: 17px solid rgba(241, 241, 241, 0.72);
}
.gray-fonce {
    font-size: 18px;
}

@media only screen and (min-width: 768px) {
    .floatRight{
        float: right;
    }
    .noMargin{
        margin: 0px !important;
    }
}
.LocPropLabel{
    color: black;
    font-size: larger;
}
.InfoLocContainer{
    margin-top: 1.5px;
}
.chercheperiode{
  display: none;
}

.showSweetAlert[data-animation=pop] {
  -webkit-animation: showSweetAlert 0.7s;
  animation: showSweetAlert 0.7s;
}
.hideSweetAlert[data-animation=pop] {
  -webkit-animation: hideSweetAlert 1s;
  animation: hideSweetAlert 1s;
}
.sweet-alert button {
  padding: 5px 15px;
  margin-top: 0px;
  border-radius: 0px;
}
a.fc-day-grid-event::after, a.fc-day-grid-event::before {
  border-top-width: 24px !important;
}
</style>
<?php
$mdp_en_clair = "";
$possible = "0123456789bcdfghjkmnpqrstvwxyz";
$i = 0;
while ($i < 8) {
    $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
    if (!strstr($mdp_en_clair, $char)) {
        $mdp_en_clair .= $char;
        $i++;
    }
}
$nouvMdp = $mdp_en_clair;
//echo $nouvMdp;
?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
function validateForm(){
    var block2;

    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>reservations/blockreduction/",
        data: {debut: $('#location_du').val(), fin: $('#location_au').val(), ann_id: $('#annonceid').val(), modelemail: "creationCompteManuelle"},
        success:function(xml){
            block2 = xml.blockdetail;

            $("#mdpenclair").val("<?php echo $nouvMdp ?>");
            $("#creationCompteManuelleHidden").val(block2);
        }
    });

    var block;
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>reservations/blockreduction/",
        data: {debut: $('#location_du').val(), fin: $('#location_au').val(), ann_id: $('#annonceid').val(), modelemail: "creationReservationLocManuelle"},
        success:function(xml){
            block = xml.blockdetail;

            $("#creationReservationLocManuelleHidden").val(block);
        }
    });

    $.ajax({
        async: false,
        type: "POST",
        dataType : 'json',
        url: "<?php echo $this->Url->build('/',true)?>dispos/calculertotalprixperiode",
        data: {
            annonce_id:$("#annonceid").val(),
            sel:$('#location_du').val()+"/"+$('#location_au').val(),
            nbradulte:$("#adult").val(),
            nbrenfant:$("#enfant").val()
        },
        success:function(xml){
            var prixTotal = (xml.resultatDetail['total_price']).toFixed(2);
            $("#nombretotalnuitee").html("<span class='resleft'>" +xml.resultatDetail['nights']+" <?= __('nuitées') ?> </span><span class='resright'>"+prixTotal+" €</span>");
            var taxeDeSejour = (xml.resultatDetail['prixtaxeapayer']).toFixed(2);
            $("#prixtaxesejour").val(taxeDeSejour);

            var fraisAlpissime = xml.typefraiserviceprop == "fixe" ? xml.fraiserviceprop : ((xml.resultatDetail['total_price'] - xml.resultatDetail.automaticPromo.value)/100 * xml.fraiserviceprop);
            var fraisStripe = ((xml.resultatDetail['total_price'] - xml.resultatDetail.automaticPromo.value)/100 * 1.4);
            var fraisService = (fraisAlpissime + fraisStripe).toFixed(2);
            $("#prixfraiservice").val(fraisService);

            var fraisdemenage = parseFloat(xml.fraisdemenage) != 0 ? parseFloat(xml.fraisdemenage).toFixed(2) : 0;

            var fraisanimaux = 0;
            if (xml.acceptanimal == 1) {
                if ($('#animaux').is(":checked")) {
                    $('#apporteranimauxhidden').val(1);

                    if (xml.demandefraisanimal == 1) {
                        fraisanimaux = parseFloat(xml.fraisanimaux).toFixed(2);
                    }
                } else {
                    $('#apporteranimauxhidden').val(0);
                }
            }

            $("#prixreservation").val((parseFloat(prixTotal) - parseFloat(xml.resultatDetail.automaticPromo.value)).toFixed(2));
            var totalPrixPayer = (parseFloat(prixTotal) + parseFloat(taxeDeSejour) + parseFloat(fraisService) + parseFloat(fraisdemenage) + parseFloat(fraisanimaux) - parseFloat(xml.resultatDetail.automaticPromo.value)).toFixed(2);
            $("#totalapayer").val(totalPrixPayer);
        }
    });

    var test = '';
    for (i = 1; i < $("#adult").val(); i++) {
        var telInputpp = $("#num_tel"+i),	errorMsgpp = $("#error-msg"+i),	validMsg = $("#valid-msg");

        if ($.trim(telInputpp.val())) {
            if (telInputpp.intlTelInput("isValidNumber")) {
                validMsg.removeClass("hide");
                validNumpp = telInputpp.intlTelInput("getNumber");
                errorMsgpp.addClass("hide");
                $("#num_tel"+i).val(validNumpp);
                telInputpp.removeClass("errorNumberTel");
            } else {
                test = "non";
                validNumpp = "non";
                telInputpp.addClass("errorNumberTel");
                errorMsgpp.removeClass("hide");
                errorMsgpp.addClass("errorNumberTel");
            }
        }
    }

    var isValid = true;
    var periodechoisi = $("input[name$='sel']").val();
    var nbrselect = $( "input[name$='sel']:checked" ).length;
    if (!periodechoisi || nbrselect==0) {
        isValid = false;

        $('#msg_periode').html("<?= __('Veuillez choisir une période') ?>").show();
    } else {
        isValid = true
        $('#msg_periode').html('').hide();
    }

    if (validNum == "non" || validNum2 == "non" || test == "non") {
        alert("<?= __('Merci de vérifier la saisie des numéros de téléphone.') ?>");
        return false;
    } else if(!isValid) {
        $('html, body').animate({
            scrollTop: $("#calendarResMan").offset().top
        }, 1000);

        return false;
    } else {
        $("#portable1").val(validNum);
        $("#portable2").val(validNum2);

        return true;
    }
}

function ifSelectNotEmpty(field, rules, i, options){
  if($(field).find("option:selected").val() == 0) return "* Ce champ est requis";
}

function notAirbnbEamil(field, rules, i, options){
    var pos = field.val().indexOf("@")+1;
    var val=field.val().substring(pos);
    if(val.indexOf('airbnb')!== -1   ||  val.indexOf('abritel') !== -1 ||  val.indexOf('booking') !== -1){
      return __("Les emails Airbnb, Abritel et Booking ne sont pas acceptés.")
    }
}

$('#regiondiv').css('display','none');

$( "#pays" ).change(function() {  
  if($(this).val() == 67){
    $('#regiondiv').css('display','block');
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayregionfrance/",
        success:function(xml){
          data = xml.listefrregions;
          $('#region').empty();
          for (var i = 0; i < data.length; i++) {
              $('#region').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
        }
    });
    
   $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
        data: {departementid: 182},
        success:function(xml){
          data = xml.listepville;
          $('#ville').empty();
          for (var i = 0; i < data.length; i++) {
              $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
        }
    });
  }else{
    $('#regiondiv').css('display','none');
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarraypaysvilles/",
        data: {paysid: $(this).val()},
        success:function(xml){
          data = xml.listepville;
          $('#ville').empty();
          for (var i = 0; i < data.length; i++) {
              $('#ville').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
          }
        }
    });
  }
  var monTableauJS = <?php echo json_encode($paysNum) ?>;
  $("#portablenum1").intlTelInput("setCountry", monTableauJS[$(this).val()]);
  $("#portablenum1").val('');
  $("#portablenum2").intlTelInput("setCountry", monTableauJS[$(this).val()]);
  $("#portablenum2").val('');
});

$("#region").change(function() {  
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
        data: {departementid: $(this).val()},
        success:function(xml){
          data = xml.listepville;
          $('#ville').empty();
          for (var i = 0; i < data.length; i++) {
              $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
        }
    });
});

$("#code-postal").on('input',function(e){
    if($( "#pays" ).val() == 67 && ($( "#code-postal" ).val().length == 4 || $( "#code-postal" ).val().length == 5)){
        $.ajax({
            type: "POST",
            dataType : 'json',
            url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getdetailfrancecodepostal/",
            data: {code: $("#code-postal").val()},
            success:function(xml){                
                data = xml.listepville;
                if(data.length > 0){
                  $('#ville').empty();
                  for (var i = 0; i < data.length; i++) {
                      $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                      $('#region').val(data[i].departement_id);
                  }
                }
                
            }
        });
    }
    if($( "#pays" ).val() == 67 && $( "#code-postal" ).val().length > 5){
        $("#code-postal").val($("#code-postal").val().substr(0, 5));
    }
});
//</script>
<?php $this->Html->scriptEnd(); ?>
<?php

//echo "test";
$a_adult=array();
for($i=1;$i<19;$i++){
	$a_adult[$i]=$i;
}
$a_child=array();
for($i=0;$i<17;$i++){
	$a_child[$i]=$i;
}
?>
<?php $this->Html->script("/manager-arr/components/validationEngine/jquery.validationEngine_new.js", array('block' => 'scriptBottom')); ?>
<?php // $this->Html->script("/manager-arr/components/validationEngine/jquery.validationEngine-en.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-".$language_header_name.".min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/js/jquery.simpletooltip-min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/jquery.colorbox.js", array('block' => 'scriptTop')); ?>


<?php $this->Html->css("/manager-arr/components/validationEngine/validationEngine.jquery.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/colorbox.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
jQuery(document).ready(function() {
        jQuery("#FormReservation").validationEngine({
                prettySelect : true,
                useSuffix: "_chzn"
        });

       /* $('#FormReservation').submit(function() {
         

        });*/
});
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptTop')); ?>
//<script>
$(function() {
	/*$( "#dialog:ui-dialog" ).dialog( "destroy" );
   $( "#dialog-confirm" ).dialog({
            autoOpen:<?php //echo !empty($confirm_res)?'true':'false';?>,
            modal: true,
			width:520,

    });*/

	var cboxOptions = {
  width: '90%',
  height: '90%',
  maxWidth: '960px',
  maxHeight: '960px',
  }

$('#tarif_dispo').colorbox(cboxOptions);

$(window).resize(function(){
    $.colorbox.resize({
      width: window.innerWidth > parseInt(cboxOptions.maxWidth) ? cboxOptions.maxWidth : cboxOptions.width,
      height: window.innerHeight > parseInt(cboxOptions.maxHeight) ? cboxOptions.maxHeight : cboxOptions.height
    });
});


	$(document).on('click', '#btn_dispo_valider', function() {
		$("#debut").val($("input[type=radio][id^=dispo_]:checked").attr('data-dbt'));
 	 $("#fin").val($("input[type=radio][id^=dispo_]:checked").attr('data-fin'));
 	 $("#annonceid").val($("input[type=radio][id^=dispo_]:checked").val());
 		$.colorbox.close();
	});



   });
   //</script>
	 <?php $this->Html->scriptEnd(); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="form_reservation" class="container">
<?php echo $this->Flash->render() ?>
		<div class="row">
				<div class="col-md-12">		
										<h1><?= __("Espace Propriétaire") ?> - <span class="orange"><?= __("Créer une réservation") ?></span></h1>
            						<?php echo $this->Form->create(null,['id'=>'FormReservation','url'=>SITE_ALPISSIME.$urlLang."reservations/locataireAddres", 'onsubmit'=>'return validateForm()']);?>
            						<?php echo $this->Form->input('proprietaire_id',['type'=>'hidden','value'=>$this->Session->read('Auth.User.id')]);?>
            						<?php echo $this->Form->input('manuelle',['type'=>'hidden','value'=>'reservation']);?>
            						<input type="hidden" id="creationCompteManuelleHidden" name="creationCompteManuelleHidden" />
            						<input type="hidden" id="creationReservationLocManuelleHidden" name="creationReservationLocManuelleHidden" />
            						<input type="hidden" id="mdpenclair" name="mdpenclair" />

            								<div class="row">
            										<div class="col-md-12">
            												<div class="header_title">
            														<h4 class="gray-fonce"><?= __("Réservation") ?></h4>
            												</div>
            										</div>
            								</div>
                            <div class="row">
                              <div class="col-md-12">
  															<p>
                                <?= __("Vous pouvez créer une réservation afin d'indiquer les coordonnées de vos locataires et informations sur les séjours réservés sur d'autres plateformes à votre conciergerie.") ?><br><br>
  															</p>
  														</div>
                            </div>
            								<div class="row">
            										<div class="col-sm-6 col-md-6">
                                  <div class="form-group">
                                      <label for="annonce" class="orange"><?= __("Choisir une annonce") ?> <sup>*</sup></label>
                                      <?php echo $this->Form->input('annonceid',[
                                                    'label'=>false,
                                                    'templates' => ['inputContainer' => "{{content}}"],
                                                    'type'=>'select',
                                                    'class'=>'validate[required]',
                                                    'disabled'=>'disabled',
                                                    'options'=>$annoncesids,'class'=>'form-control select '])?>
                                  </div>
            										</div>
            								</div>
                            <div class="row">
                              <div class="col-md-12">
                  										<p class="note">
                  												<span class="bonjour"><?= __("Veuillez choisir une annonce afin d'afficher le calendrier de réservation") ?> </span>
                  										</p>
                  								</div>
                            </div>
          <div class="row chercheperiode">
            <label id="msg_periode" class="red" style="width:100%;font-size: 15px;"></label>
            <div class="col-md-12"><label><?= __("Choisir une période") ?> :</label></div>
            <div class="col-md-12 d-flex">
              <div class="col-md-4">
                <label for="location_du"><?= __("Date d'arrivée") ?></label>
                <?php echo $this->Form->input('dbt',['label'=>false,'readonly'=>'readonly','type'=>'text','templates' => ['inputContainer' => "{{content}}"],'id'=>'location_du', 'class'=>'form-control inline-block location calendrier '])?>
              </div>
              <div class="col-md-4">
                <label for="location_au"><?= __("Date de départ") ?></label>
                <?php echo $this->Form->input('fin',['label'=>false,'readonly'=>'readonly','type'=>'text','templates' => ['inputContainer' => "{{content}}"],'id'=>'location_au', 'class'=>'form-control inline-block location calendrier '])?>
              </div>
              <div class="col-md-4">
                <button type="button" class="submit_reserv btn btn-success hvr-sweep-to-top right rec_per" onclick="chercherdisponibilite()"><?= __("Chercher") ?></button>
              </div>
            </div>
          </div>
          <br>                
          <div class="row result_rech">
            <p id="resultatdispo"></p>
            <p id="periodedispo"></p>
          </div>
          <div class="row">
            <div id="calendarResMan" class="col-md-12 block calendarResMan calendarinit">
              <div class="col-sm-10 col-md-10 block">                
                <div id='calendar3'></div>
                
              </div>
              <div class="col-md-2 indic block">
                <p><b><?= __("Indication") ?> :</b></p>
                <div class="botmar">
                  <div class="flex">
                    <div id="carreorange"></div> <span class="indication">&nbsp;&nbsp; <?= __("Option") ?></span>
                  </div>
                  <div class="flex">
                    <div id="carrevert"></div> <span class="indication">&nbsp;&nbsp; <?= __("Disponible") ?></span>
                  </div>
                  <div class="flex">
                    <div id="carrerouge"></div> <span class="indication">&nbsp;&nbsp; <?= __("Réservé") ?></span>
                  </div>
                  <div class="flex">
                    <div id="carrerose"></div> <span class="indication">&nbsp;&nbsp; <?= __("Promotion") ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>

						<div class="row">
								<div class="col-md-12">
										<div class="header_title">
                                                                                            <h4 class="gray-fonce">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-6 col-xs-12 InfoLocContainer">
                                                                                                        <span id="propName" class=""><?= __("Info locataire") ?></span>
                                                                                                    </div>
                                                                                                    <div class="col-sm-6 col-xs-12">
                                                                                                        <span class="floatRight">
                                                                                                            <div class="checkbox noMargin">
                                                                                                                <label for="LocProp" class="LocPropLabel">
                                                                                                                <input type="checkbox" id="LocProp"> 
                                                                                                                <?= __("Occupation propriétaire") ?>
                                                                                                                </label>
                                                                                                            </div>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </h4>
										</div>
								</div>
						</div>
                                                            <div id="infoUser">
								<div class="row">
										<div class="col-sm-6">
                                                                                    <div class="form-group">
                                                                                        <label for=""><?= __("Pays") ?> <sup class="orange">*</sup></label>
                                                                                        <?php echo $this->Form->input('pays',['type'=>'select','class'=>'form-control validate[funcCall[ifSelectNotEmpty]]','label'=>false,'options'=>$Pays]);?>
                                                                                    </div>
										<input type="hidden" id="occupationcheck" name="occupationcheck" value="0">		
										</div>
										<!-- /.col-sm-6 -->
										<div class="col-sm-6">
                    <div class="form-group">
                          <label for="email"><?= __("Adresse e-mail") ?> *</label>
                          <?php echo $this->Form->input("email",[
                            'label'=>false,
                            'size'=>'45',
                            'maxlength'=>'100','class'=>'form-control select  validate[required,custom[email],funcCall[notAirbnbEamil]]'])?>
                        </div> 
												
										</div>
										<!-- /.col-sm-6 -->
								</div>
								<!-- /.row -->
								<div class="row">
										<div class="col-sm-6">
                                                                                    <div class="form-group">
														<label for="nom"><?= __("Nom") ?> *</label>
														<?php echo $this->Form->input("nom",['label'=>false,'size'=>'45','type'=>'text','maxlength'=>'60','class'=>'form-control select  validate[required]'])?>
												</div>
												
										</div>
										<!-- /.col-sm-6 -->
										<div class="col-sm-6">
                                                                                    <div class="form-group">
														<label for="prenom"><?= __("Prénom") ?> *</label>
														<?php echo $this->Form->input("prenom",[
															'label'=>false,
															'size'=>'45',
															'maxlength'=>'60','class'=>'form-control select  validate[required]'])?>
												</div>
                                                                                   
                      
										</div>
										<!-- /.col-sm-6 -->
								</div>
								<!-- /.row -->
								
								<div class="row">
                                                                    <div class="col-sm-6" id="NumContainer">
                                                                                    <div class="form-group" id="portableNum1Container">
														<label for="portable1"><?= __("Numéro portable") ?> *</label>
														<?php echo $this->Form->input("portableNum1",[
															'label'=>false,
                                                                                                                        'type' => 'number',
															'size'=>'45',
															'maxlength'=>'40','class'=>'form-control select  validate[required]'])?>
                                                        <span id="error-msg" class="hide"><?= __("Numéro invalide") ?></span>
                                                                                                                          </div>
                                                                                                          </div>
                                                                      <input type="hidden" id="portable1" name="portable1" />
                                                                      <input type="hidden" id="portable2" name="portable2" />
										<!-- /.col-sm-6 -->
										<div class="col-sm-6">
												<div class="form-group">
														<label for="portable2"><?= __("2éme numéro portable") ?></label>
														<?php echo $this->Form->input("portableNum2",[
															'label'=>false,
															'size'=>'45',
                              'type' => 'number',
															'maxlength'=>'40','class'=>'form-control select '])?>
                              <span id="error-msg2" class="hide"><?= __("Numéro invalide") ?></span>
												</div>
										</div>
										<!-- /.col-sm-6 -->
								</div>
                                                            </div>
								<!-- /.row -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="enfant"><?= __("Nombre d'enfants") ?> </label>
                            <?php echo $this->Form->input('enfant',[
                                          'label'=>'',
                                          'templates' => ['inputContainer' => "{{content}}"],
                                          'type'=>'select',
                                          'options'=>$a_child,'class'=>'form-control select '])?>
                        </div>
                        <div id="DefaultNumContainer">
                        
                        </div>
                    </div>
                    <!-- /.col-sm-6 -->
                    <div class="col-sm-6">
                      <div class="form-group">
                          <label for="adult"><?= __("Nombre d'adultes à partir de 18 ans") ?></label>
                          <?php echo $this->Form->input('adult',[
                                        'label'=>false,
                                        'templates' => ['inputContainer' => "{{content}}"],
                                        'type'=>'select',
                                        'options'=>$a_adult,'class'=>'form-control select '])?>
                      </div>
                      <div id="listenum" >
                          <div class="form-group">
                          <label for=""><?= __("Ajouter des numéros de téléphone") ?> : </label>
                          <div id="numl">

                          </div>
                          </div>
                      </div>
										</div>
										<!-- /.col-sm-6 -->
								</div>
                <input type="hidden" id="totalapayer" name="totalapayer" />
                <input type="hidden" id="prixreservation" name="prixreservation" />
                <input type="hidden" id="prixtaxesejour" name="prixtaxesejour" />
                <input type="hidden" id="prixfraiservice" name="prixfraiservice" />
                <input type="hidden" id="apporteranimauxhidden" name="apporteranimauxhidden" />
								<!-- /.row -->
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group visibletaxe">
                        <label for="taxe"><?= __("Je souhaite que la taxe de séjour soit collectée en mon nom par ma conciergerie") ?> <sup>*</sup></label><br>
                        <label class="radio-inline">
                            <input type="radio" value="1" id="TaxeOui" name="taxe" class='validate[required]'/>
                            <span><?= __("Oui") ?><span class="tooltipsvc ml-1 mr-2" data-toggle="tooltip" data-placement="right" title="<p><?= __('La conciergerie pourra collecter la taxe de séjour par chèque à l\'ordre du Trésor Public ou en espèce. Elle sera par la suite reversée à la commune.') ?></p>"><i class="fa fa-question-circle-o"></i></span></span>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" id="TaxeNon" name="taxe" class='validate[required]'/>
                            <span><?= __("Non") ?></span>
                        </label>
                    </div>

                  </div>
                  <div class="col-md-6 col-sm-6 rowanimaux" style="display:none;">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="animaux" name="apporteranimaux">
                      <label class="form-check-label" for="animaux">
                        <?= __('Apporter animal'); ?>
                      </label>
                    </div>
                  </div>
                </div>
                <!-- /.row -->
                <div class="row">
										<div class="col-sm-12">
												<div class="form-group">
														<label for="code_postal"><?= __("Commentaire") ?></label>
														<?php echo $this->Form->input("comment",[
															'label'=>false,
															'templates' => ['inputContainer' => "{{content}}"],
															'type'=>'textarea','class'=>'form-control','rows'=>'5','cols'=>'40','maxlength'=>'1000'])?>
												</div>
										</div>

								</div>

								<div class="row justify-content-end">
										<div class="col-md-auto">
												<!-- <button type="submit" class="btn btn-blue text-white rounded-0"><?= __("Créer une réservation") ?> -->
												<button id="creereservation" type="button" class="btn btn-blue text-white rounded-0"><?= __("Créer une réservation") ?>
												</button>
										</div>
								</div>
						<?php echo $this->Form->end();?>
						<div class="row">
								<div class="col-md-12">
										<p class="note">
												<span class="bonjour"><?= __("Lors de votre prochaine location demandez à votre futur locataire de réserver par alpissime.com de façon à alimenter automatiquement votre tableau de réservations") ?></span>
										</p>
								</div>
						</div>
				</div>
				<div class="row">
						<div class="col-md-12">
								<hr class="dashed">
						</div>
				</div>
		</div>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalEdit2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">

  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel"><?= __("Détails période") ?></h4>
  </div>
  <div class="modal-body">
    <label for="title" class="col-sm-6 control-label"><?= __("Statut ") ?> : </label>
    <div class="col-sm-6">
      <p id="statut"></p>
    </div>
    <label for="end" class="col-sm-6 control-label"><?= __("Durée minimum de séjour") ?></label>
    <div class="col-sm-6">
      <p id="nbr_jour"></p>
    </div>
    <label for="end" class="col-sm-6 control-label"><?= __("Prix /nuitée") ?> (€)</label>
    <div class="col-sm-6">
      <p id="prix_jour"></p>
    </div>
    <div id="divpromojour">
    <label for="end" class="col-sm-6 control-label"><?= __("Prix promotion /nuitée") ?> (€)</label>
    <div class="col-sm-6">
      <p id="promo_jour"></p>
    </div>
  </div>
  </div>
  <br><br>
  <div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Fermer") ?></button>
  </div>
</div>
</div>
</div>

<!-- Modal Ajout periode-->
<div class="modal fade" id="Modaladd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <?php echo $this->Form->create(null,['id'=>'addModel','class'=>'form-horizontal','url' => ['controller' => 'Dispos', 'action' => 'calendarAdd'],'onsubmit'=>'return validateFormnew()']);?>
      <input type="hidden" name="annonce_id" id="annonce_id" >

      <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel"><?= __("Ajouter nuitée ou période (ex: semaine)") ?></h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      
      </div>
      <center><span id='erreurLabel' class="error_formul"><?= __("Veuillez saisir un prix par nuitée !") ?></span></center>
      <center><span id='erreurLabeldebut' class="error_formul"><?= __("Le début d'une période valide ne doit pas être à une date passée !") ?></span></center>
      <center><span id='erreurLabeladdnul' class="error_formul"><?= __("Veuillez saisir un prix par nuitée > 0€ !") ?></span></center>

      <div class="modal-body">

        <div class="form-row form-group">
        <label for="title" class="col-sm-4 control-label"><?= __("Statut ") ?></label>
        <div class="col-sm-8">
          <select name="statut" class="form-control " id="statut">
              <option value="0"><?= __("Libre") ?></option>
              <option value="50"><?= __("Option") ?></option>
              <option value="90"><?= __("Réservé") ?></option>
          </select>
        </div>
        </div>
        <div class="form-row form-group" id="formdebut">
        <label for="start" class="col-sm-4 control-label"><?= __("Début") ?></label>
        <div class="col-sm-8">
          <input type="text" name="dbt_at" class="form-control calendrier" id="dbtat" readonly="readonly">
        </div>
        </div>
        <div class="form-row form-group">
        <label for="end" class="col-sm-4 control-label"><?= __("Fin") ?></label>
        <div class="col-sm-8">
          <input type="text" name="fin_at" class="form-control calendrier" id="finat" readonly="readonly">
        </div>
        </div>
        <div class="form-row form-group">
        <label for="end" class="col-sm-4 control-label"><?= __("Durée minimum séjour (nuitée)") ?></label>
        <div class="col-sm-8">
          <input type="number" name="nbr_jour" class="form-control" min="1" value="1" id="nbr_jour" >
        </div>
        </div>
        <div class="form-row form-group text-medium" id="condition7add">
          
          <label class="col-md-2 control-label" ><?= __("Condition") ?></label>
          <div class="col-sm-3 form-check ml-3 ml-md-0">
              
                <input type="radio" class="form-check-input" name="condition7" id="_0" value="0" size="auto" checked>
                <label class="form-check-label"><span><?= __("durée minimum") ?></span>
              </label>
          </div>
          <!-- <div class="col-sm-4 form-check ml-3 ml-md-0">
              
                <input type="radio" class="form-check-input" name="condition7" value="1" size="auto">
                <label class="form-check-label"><span><?= __("samedi au samedi") ?></span>
              </label>
          </div> -->
  		<!-- <div class="col-sm-4 col-md-3 form-check ml-3 ml-md-0">
              
                <input type="radio" class="form-check-input" name="condition7" value="2" size="auto">
                <label class="form-check-label"><span><?= __("dimanche au dimanche") ?></span>
              </label>
          </div> -->
        </div>
        <div id="formprixjour" class="form-row form-group">
        <label for="end" class="col-sm-4 control-label"><?= __("Prix /nuitée") ?> (€)</label>
        <div class="col-sm-8">
          <input type="text" name="prix_jour" class="form-control" id="prix_jour" autocomplete="off" onKeyUp='CalculerMontant()' onchange='this.value=(number_format(this.value, 2, ".", "")).replace(" €", "")+" €"'>
        </div>
        </div>
        <div id="formpromojour" class="form-row form-group">
        <label for="end" class="col-sm-4 control-label"><?= __("Prix promotion /nuitée") ?> (€)</label>
        <div class="col-sm-8">
          <input type="text" name="promo_jour" class="form-control" id="promo_jour" autocomplete="off" onKeyUp='CalculerMontantPromo()' onchange='this.value=(number_format(this.value, 2, ".", "")).replace(" €", "")+" €"'>
        </div>
        </div>
        <div class="form-row form-group">
        <label for="end" class="col-sm-4 control-label"><?= __("Prix /période") ?> (€)</label>
        <div class="col-sm-8">
          <input type="text" name="prix" class="form-control" id="prix" autocomplete="off" onKeyUp='CalculerMontantPeriode()' onchange='this.value=(number_format(this.value, 2, ".", "")).replace(" €", "")+" €"'>
        </div>
        </div>
        <div class="form-row form-group">
        <label for="end" class="col-sm-4 control-label"><?= __("Prix promotion /période") ?> (€)</label>
        <div class="col-sm-8">
          <input type="text" name="promo_px" class="form-control" id="promo_px" autocomplete="off" onKeyUp='CalculerMontantPromoPeriode()' onchange='this.value=(number_format(this.value, 2, ".", "")).replace(" €", "")+" €"'>
        </div>
        </div>

      </div>
      <div class="row justify-content-end m-3">
      <button type="button" class="btn btn-default rounded-0 mr-3" data-dismiss="modal"><?= __("Fermer") ?></button>
      <button type="button" name="valider" value="Valider" id="valideradd" class="btn btn-blue text-white rounded-0"><?= __("Ajouter") ?></button>
      </div>
      <?php echo $this->Form->end();?>
    </div>
    </div>
  </div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>

$("#creereservation").click(function(){    
  if($("#LocProp").prop('checked') == true){
    swal({   
			title: '<?= __("Attention"); ?>',   
			text: '<?= __("Vous vous apprêtez à créer une arrivée pour votre compte. Vous ne pourrez plus la modifier. Pour créer une réservation pour des locataires, décochez la case \"Occupation Propriétaire\". Vous voulez continuer la création de votre réservation ?"); ?>',
			// type: "warning",   
			showCancelButton: true,   
			confirmButtonColor: "#09f",   
			confirmButtonText: "<?= __('Oui'); ?>",
			cancelButtonText: '<?= __("Annuler"); ?>',  
			closeOnConfirm: false,
			customClass: 'rounded-0'
		}, function(){
			$(".sweet-alert button").prop('disabled', true);
			$('#FormReservation').submit();
		});
  }else{
    $('#FormReservation').submit();
  }	
});

var validNum = "non";
var validNum2 = "";

$(window).on('load', function () {
  $('#annonceid').attr("disabled", false);
});

jQuery(document).ready(function() {
  $(".tooltipsvc").tooltip({
    html: true
    });

  $("#dbtat" ).datepicker({
    dateFormat: "dd-mm-yy",
  });

  $("#finat" ).datepicker({
    dateFormat: "dd-mm-yy"
  });

  $('#calendar3').fullCalendar({
    locale: '<?php echo $language_header_name; ?>',
        header: {
          left: 'prev',
          center: 'title',
          right: 'next'
        },
           editable: false,
       eventLimit: false, // allow "more" link when too many events
       firstDay: 1,
       events: {
         url: '<?php echo $this->Url->build('/',true) ?>dispos/calendarDispoLoc/'+$("#annonceid").val(),
         type: 'POST', // Send post data
         error: function() {
           alert('There was an error while fetching events.');
         }
       },
       eventRender: function (event, element) {
         if(event.nbrpersonnes){
           element.find(".fc-title").append(" <i class='fa fa-user'></i> "+event.nbrpersonnes);
         }
         if(event.nbrnuitees){
           element.find(".fc-title").append(" <img class='iconnight' src='<?php echo $this->Url->build('/',true) ?>images/icon/night.png' /> "+event.nbrnuitees);
         }
         if (event.promotion == 1) {
           var start = moment(event.start);
           var end = moment(event.end);
           while( start.format('YYYY-MM-DD') != end.format('YYYY-MM-DD') ){
             var dataToFind = start.format('YYYY-MM-DD');
             $("td[data-date='"+dataToFind+"'].fc-widget-content").addClass('promotion');
             start.add(1, 'd');
           }
           //element.addClass('promosbefore');
         }
         if(event.statut == 50){
           element.addClass('optionafter');
         }

         if(event.statut == 90 || event.statut == 100){
           element.addClass('reserverafter');
         }
       },

       eventClick:  function(event, jsEvent, view) {
         var cond;
        //  if(event.conditionnbr == 1){
        //    cond = " <i><b> (<?= __('semaine commence le samedi'); ?>)</b></i>" ;
        //  }else if (event.conditionnbr == 2){
        //    cond = " <i><b> (<?= __('semaine commence le dimanche'); ?>)</b></i>" ;
        //  }else{
           cond = "";
        //  }
         if(event.statut == 50) $('#ModalEdit2 #statut').html("<?= __('Option') ?>");
         else if(event.statut == 0) $('#ModalEdit2 #statut').html("<?= __('Libre') ?>");
         else if(event.statut == 90 || event.statut == 100) $('#ModalEdit2 #statut').html("<?= __('Réservé') ?>");
         $('#ModalEdit2 #nbr_jour').html(event.nbr_jour + cond);
         $('#ModalEdit2 #prix_jour').html(event.prix_jour);
         if(event.promotion == 0 ){
           document.getElementById('divpromojour').style.display = 'none';
           document.getElementById("prix_jour").style.textDecoration = "none";
           document.getElementById("prix_jour").style.color = "black";
         }else{
           document.getElementById('divpromojour').style.display = 'block';
           $('#ModalEdit2 #promo_jour').html(event.promo_jour);
           document.getElementById("prix_jour").style.textDecoration = "line-through";
           document.getElementById("prix_jour").style.color = "red";
         }

         $('#ModalEdit2').modal('show');
       },
       eventMouseover: function (data, event, view) {
         var cond;
        //  if(data.conditionnbr == 1){
        //    cond = "<strong> (<?= __('semaine commence le samedi'); ?>)</strong>" ;
        //  }else if (data.conditionnbr == 2){
        //    cond = "<strong> (<?= __('semaine commence le dimanche'); ?>)</strong>" ;
        //  }else{
           cond = "";
        //  }

         var labeljour;
         if(data.nbr_jour == 1){
           labeljour = " <?= __('nuitée') ?> ";
         }else{
           labeljour = " <?= __('nuitées') ?> ";
         }

         if(data.color == "#ff8800" || data.color == "#f54f4f"){
           if(data.promotion == 0){
             tooltip = '<div class="tooltiptopicevent">' + '<?= __("Locataire") ?> ' + ': <span class="nouveauprix">' + data.locataire + '</span><br><?= __("Durée minimum de séjour") ?> ' + ': <span class="nouveauprix">' + data.nbr_jour +labeljour+ cond + '</span></br>' + '<?= __("Prix/nuitée") ?> ' + ': <span class="nouveauprix">' + data.prix_jour + '€</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
           }else{
             tooltip = '<div class="tooltiptopicevent">' + '<?= __("Locataire") ?> ' + ': <span class="nouveauprix">' + data.locataire + '</span><br><?= __("Durée minimum de séjour") ?> ' + ': <span class="nouveauprix">' + data.nbr_jour +labeljour+ cond +'</span></br>' + '<?= __("Prix/nuitée") ?> ' + ': <span class="ancienprix">' + data.prix_jour + '€</span></br>' + '<?= __("Prix promotion/nuitée") ?> ' + ': <span class="nouveauprix">' + data.promo_jour +'€</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
           }
         }else{
           if(data.promotion == 0){
             tooltip = '<div class="tooltiptopicevent">' + '<?= __("Durée minimum de séjour") ?> ' + ': <span class="nouveauprix">' + data.nbr_jour +labeljour+ cond + '</span></br>' + '<?= __("Prix/nuitée") ?> ' + ': <span class="nouveauprix">' + data.prix_jour + '€</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
           }else{
             tooltip = '<div class="tooltiptopicevent">' + '<?= __("Durée minimum de séjour") ?> ' + ': <span class="nouveauprix">' + data.nbr_jour +labeljour+ cond +'</span></br>' + '<?= __("Prix/nuitée") ?> ' + ': <span class="ancienprix">' + data.prix_jour + '€</span></br>' + '<?= __("Prix promotion/nuitée") ?> ' + ': <span class="nouveauprix">' + data.promo_jour +'€</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
           }
         }


          $("body").append(tooltip);
          $(this).mouseover(function (e) {
              //$(this).css('z-index', 10000);
              $('.tooltiptopicevent').fadeIn('500');
              $('.tooltiptopicevent').fadeTo('10', 1.9);
          }).mousemove(function (e) {
              $('.tooltiptopicevent').css('top', e.pageY + 10);
              $('.tooltiptopicevent').css('left', e.pageX + 20);
          });


      },
      eventMouseout: function (data, event, view) {
          //$(this).css('z-index', 8);

          $('.tooltiptopicevent').remove();

      },
      viewRender : function ( view, element ){
        if($("#annonceid").val() != 0){
          $('#calendar3').fullCalendar('removeEventSources');
          var source = {
            url: '<?php echo $this->Url->build('/',true) ?>dispos/calendarDispoLoc/'+$("#annonceid").val(),
            type: 'POST', // Send post data
                  };
            $('#calendar3').fullCalendar('addEventSource', source);
        }

      }

  });


  $(".chercheperiode").css("display", "none");
  $('#annonceid').on( "change", function() {
    document.getElementById("periodedispo").style.display = 'none';
    document.getElementById("resultatdispo").style.display = 'none';
    $("#location_du").val('');
    $("#location_au").val('');
    if($(this).val() != 0){
      document.getElementById("calendarResMan").style.display = 'flex';
      $(".chercheperiode").css("display", "block");
      $('#calendarResMan').removeClass('calendarinit');
      $('#calendarResMan').addClass('calendarinitinvers');
      $("td").removeClass('promotion');
      var source = {
        url: '<?php echo $this->Url->build('/',true) ?>dispos/calendarDispoLoc/'+$(this).val(),
        type: 'POST', // Send post data
              };
              $('#calendar3').fullCalendar('removeEvents');
              $('#calendar3').fullCalendar('addEventSource', source);
      $("#annonce_id").val($(this).val());
      $.ajax({
       type: "POST",
       dataType : 'json',
       url: "<?php echo $this->Url->build('/',true)?>annonces/getcontratinfo/",
       data: {annonceId:$(this).val()},
       success:function(xml){
        console.log(xml.contratinfo);
        if(xml.contratinfo == 0){
          $('#TaxeNon').prop('checked', true);
          $(".visibletaxe").css('visibility', 'hidden');
        }else{
          $(".visibletaxe").css('visibility', 'visible');
        }
        if(xml.acceptanimaux == 1){
          $(".rowanimaux").css('display', 'block');
        }else{
          $(".rowanimaux").css('display', 'none');
        }
       }
      });
    } else{
      document.getElementById("calendarResMan").style.display = 'none';
      $(".chercheperiode").css("display", "none");
    }

  });

  var telInput = $("#portablenum1"),
    errorMsg = $("#error-msg"),
    validMsg = $("#valid-msg");
    telInput.intlTelInput({
                  utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                  initialCountry: 'fr',
                  autoPlaceholder: true
                });
                var reset = function() {
                  telInput.removeClass("errorNumberTel");
                  errorMsg.addClass("hide");
                  validMsg.addClass("hide");
                };
                // on blur: validate
  telInput.blur(function() {
    reset();
    if ($.trim(telInput.val())) {
      if (telInput.intlTelInput("isValidNumber")) {
        validMsg.removeClass("hide");
        validNum = telInput.intlTelInput("getNumber");

      } else {
        validNum = "non";
        telInput.addClass("errorNumberTel");
        errorMsg.removeClass("hide");
        errorMsg.addClass("errorNumberTel");
      }
    }
  });

  // on keyup / change flag: reset
  telInput.on("keyup change", reset);

  var telInputP = $("#portablenum2"),
    errorMsg2 = $("#error-msg2");

    telInputP.intlTelInput({
                  utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                  initialCountry: 'fr',
                  autoPlaceholder: true
                });
                var reset = function() {
                  telInputP.removeClass("errorNumberTel");
                  errorMsg2.addClass("hide");
                };
                // on blur: validate
  telInputP.blur(function() {
    reset();
    if ($.trim(telInputP.val())) {
      if (telInputP.intlTelInput("isValidNumber")) {
        validNum2 = telInputP.intlTelInput("getNumber");

      } else {
        validNum2 = "non";
        telInputP.addClass("errorNumberTel");
        errorMsg2.removeClass("hide");
        errorMsg2.addClass("errorNumberTel");
      }
    }
  });

  // on keyup / change flag: reset
  telInputP.on("keyup change", reset);


  });

<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
 $(document).ready(function () {
  $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);
$('#location_du').datepicker({
    language: 'fr-FR',
    minDate: 1,
    dateFormat: "dd-mm-yy"
});
$('#location_du').on( "change", function() {
      var d = moment(this.value,"DD-MM-YYYY").add(1, 'd');
      $('#location_au').datepicker( "option", "minDate", d.format('DD-MM-YYYY') );
        });
$('#location_au').datepicker({
    language: 'fr-FR',
    minDate: 1,
    dateFormat: "dd-mm-yy"
});
});


   function chercherdisponibilite(){
      $("#Modaladd .close").click();
      $.ajax({
        type: "POST",
        dataType : 'json',
        url: "<?php echo $this->Url->build('/',true)?>dispos/chercherdisponibilitebloque/"+$("#annonceid").val(),
        data: {debut:$('#location_du').val(), fin:$('#location_au').val()},
        success:function(xml){
          if(xml.periodebloque > 0){
            swal({   
              title: "<?php echo __("Débloquer la période") ?>",   
              text: "<?php echo __("La période choisie contient une période que vous avez bloqué. Vous voulez la débloquer pour créer votre réservation ?") ?>", 
              type: "error",   
              showCancelButton: true,   
              confirmButtonColor: "#e6b034",   
              confirmButtonText: "<?php echo __("Confirmer déblocage"); ?>",
              cancelButtonText: "<?php echo __("Annuler"); ?>",  
              closeOnConfirm: true 
            }, function(){
              $.ajax({
                type: "POST",
                dataType : 'json',
                url: "<?php echo $this->Url->build('/',true)?>dispos/debloquerperiode/"+$("#annonceid").val(),
                data: {debut:$('#location_du').val(), fin:$('#location_au').val()},
                success:function(xml){
                  $('#calendar3').fullCalendar( 'refetchEvents' );
                  $.ajax({
                    type: "POST",
                    dataType : 'json',
                    url: "<?php echo $this->Url->build('/',true)?>dispos/chercherdisponibilite/"+$("#annonceid").val(),
                    data: {debut:$('#location_du').val(), fin:$('#location_au').val()},
                    success:function(xml){
                      document.getElementById("resultatdispo").style.display = 'block';
                      if(xml.nbrperiode == 1){
                        var deb = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                        var debCal = moment($('#location_du').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
                        var fn = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                        var fnCal = moment($('#location_au').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
                        var elim = '';
                        var elimCon = '';
                        var dureemin = [];
                        $.each(xml.nbrDiff[1], function(index, value) {
                          if(value.toString().indexOf("_") != -1){
                            var tab = value.split("_");
                            var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                            var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                            var Diff = fnDiff.diff(dbtDiff, 'days');
                            var d = tab[0];
                            dureemin.push(parseInt(d));
                          }else{
                            var dbtDiff = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                            var fnDiff = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                            var Diff = fnDiff.diff(dbtDiff, 'days');
                            var d = value;
                            dureemin.push(parseInt(d));
                          }
                        });

                        var maxMinduree = Math.max(...dureemin);
                        var debutdiffmin = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
                        var findiffmin = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
                        var DiffDateCal = findiffmin.diff(debutdiffmin, 'days');
                        if(DiffDateCal < maxMinduree){
                          if(debutdiffmin.format('YYYY-MM-DD') == deb){
                            deb = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                          }else{
                            fn = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                          }
                          elim = maxMinduree;
                        } 

                        if(deb < fn){
                          xml.disponi[1] = 'Période : du '+moment(deb,'YYYY-MM-DD').format('DD/MM/YYYY')+' au '+moment(fn,'YYYY-MM-DD').format('DD/MM/YYYY')+' <br>';
                        }else{
                          xml.disponi[1] = '';
                        }

                        if( elimCon == ''){
                          if((deb == debCal) && (fn == fnCal)){
                            document.getElementById("periodedispo").style.marginBottom = '0';

                            if(deb > fn){
                              if(xml.totalperiodecount == 0) $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('La période recherchée n\'existe pas, souhaitez-vous la créer ?') ?> <a class='btn btn-blue text-white rounded-0 p-1 ml-4' onclick='ajouterperiode()'><?= __("Ajouter une période") ?></a></span>");
                              else $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('PERIODE NON DISPONIBLE') ?> </span><br>");
                              $('#periodedispo').html('');
                            }else{
                              $('#resultatdispo').html("<span style='color: #106710;font-size: 15px;font-weight: 600;'><?= __('PERIODE DISPONIBLE') ?></span>");
                              $('#periodedispo').html('');
                              if(xml.disponi[1] != ''){
                                $('#periodedispo').append("<div style='visibility: hidden;' class='form-group radios'><label class='radio-inline'><input type='radio' name='sel' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"' checked><span></span></label></div>");
                              }
                            }
                          }else{
                            if(elim != ''){
                              $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('PERIODE NON DISPONIBLE') ?> (<?= __('Minimum séjour') ?>: "+elim+" <?= __('nuitées') ?>)</span><br>");
                              $('#periodedispo').html('');
                            }else{
                              if(xml.totalperiodecount == 0) $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('La période recherchée n\'existe pas, souhaitez-vous la créer ?') ?> <a class='btn btn-blue text-white rounded-0 p-1 ml-4' onclick='ajouterperiode()'><?= __("Ajouter une période") ?></a></span><br>");
                              else $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('PERIODE NON DISPONIBLE') ?> </span><br>");
                              $('#periodedispo').html('');
                            }

                            $.each(xml.disponi, function(index, value) {
                              if(xml.disponi[index] != ''){
                                $('#periodedispo').append("<div class='form-group radios'><label class='radio-inline'><input type='radio' name='sel' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"'><span> "+value+"</span></label></div>");
                              }
                            });
                          }
                        }else{
                          if(xml.totalperiodecount == 0) $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('La période recherchée n\'existe pas, souhaitez-vous la créer ?') ?> <a class='btn btn-blue text-white rounded-0 p-1 ml-4' onclick='ajouterperiode()'><?= __("Ajouter une période") ?></a></span>");
                          else $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('PERIODE NON DISPONIBLE') ?> </span><br>");
                          $('#periodedispo').html('');
                        }
                      }else{
                        for (i = 1; i <= xml.nbrperiode; i++) {
                          var elimCon = '';
                          $.each(xml.nbrDiff[i], function(index, value) {
                            var deb = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                            var debCal = moment($('#location_du').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
                            var fn = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                            var fnCal = moment($('#location_au').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
                            var elim = '';var elimCon = '';var dureemin = [];
                            $.each(xml.nbrDiff[i], function(index, value) {
                              if(value.toString().indexOf("_") != -1){
                                var tab = value.split("_");
                                var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                                var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                                var Diff = fnDiff.diff(dbtDiff, 'days');
                                var d = tab[0];
                                dureemin.push(parseInt(d));
                              }else{
                                var dbtDiff = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                                var fnDiff = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                                var Diff = fnDiff.diff(dbtDiff, 'days');
                                var d = value;
                                dureemin.push(parseInt(d));
                              }
                            });
                            var maxMinduree = Math.max(...dureemin);
                            var debutdiffmin = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
                            var findiffmin = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
                            var DiffDateCal = findiffmin.diff(debutdiffmin, 'days');
                            if(DiffDateCal < maxMinduree){
                              if(debutdiffmin.format('YYYY-MM-DD') == deb){
                                deb = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                              }else{
                                fn = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                              }
                              elim = maxMinduree;
                            }
                            if(deb < fn){
                              xml.disponi[i] = 'Période  : du '+moment(deb,'YYYY-MM-DD').format('DD/MM/YYYY')+' au '+moment(fn,'YYYY-MM-DD').format('DD/MM/YYYY')+' <br>';
                            }else{
                              xml.disponi[i] = '';
                            }
                          });
                        }
                        if( elimCon == ''){
                          if(xml.totalperiodecount == 0) $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('La période recherchée n\'existe pas, souhaitez-vous la créer ?') ?> <a class='btn btn-blue text-white rounded-0 p-1 ml-4' onclick='ajouterperiode()'><?= __("Ajouter une période") ?></a></span><br>");
                          else $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('PERIODE NON DISPONIBLE') ?> </span><br>");
                          $('#periodedispo').html('');
                          $.each(xml.disponi, function(index, value) {
                            var deb = moment(xml.details['debut'][index], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                            var fn = moment(xml.details['fin'][index], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                            if(xml.disponi[index] != ''){
                              $('#periodedispo').append("<div class='form-group radios'><label class='radio-inline'><input type='radio' name='sel' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"'><span> "+value+"</span></label></div>");
                            }
                          });
                        }else{
                          if(xml.totalperiodecount == 0) $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('La période recherchée n\'existe pas, souhaitez-vous la créer ?') ?> <a class='btn btn-blue text-white rounded-0 p-1 ml-4' onclick='ajouterperiode()'><?= __("Ajouter une période") ?></a></span>");
                          else $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('PERIODE NON DISPONIBLE') ?> </span><br>");
                          $('#periodedispo').html('');
                        }
                      }
                    }
                  });
                }
              });
            });
          }
        }
      });
     document.getElementById("periodedispo").style.display = 'block';
     document.getElementById("resultatdispo").style.display = 'block';
     $.ajax({
       type: "POST",
       dataType : 'json',
       url: "<?php echo $this->Url->build('/',true)?>dispos/chercherdisponibilite/"+$("#annonceid").val(),
       data: {debut:$('#location_du').val(), fin:$('#location_au').val()},
       success:function(xml){
         document.getElementById("resultatdispo").style.display = 'block';
         if(xml.nbrperiode == 1){
           var deb = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
           var debCal = moment($('#location_du').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
           var fn = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
           var fnCal = moment($('#location_au').val(),'DD-MM-YYYY').format('YYYY-MM-DD');

            var elim = '';
            var elimCon = '';
            var dureemin = [];
              $.each(xml.nbrDiff[1], function(index, value) {
                if(value.toString().indexOf("_") != -1){
                  var tab = value.split("_");
                  var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                  var Diff = fnDiff.diff(dbtDiff, 'days');
                  var d = tab[0];
                  dureemin.push(parseInt(d));
                  // if(Diff < parseInt(d)){
                  //   if(dbtDiff.format('YYYY-MM-DD') == deb){
                  //     deb = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                  //   }else{
                  //     fn = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                  //   }
                  //   elim = d;
                  // }
                  // if(Diff == 7){
                  //   if(xml.details['condition'][1] == 1 && moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi'){
                  //       elimCon = "ui";
                  //   }else if (xml.details['condition'][1] == 2 && moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche'){
                  //     elimCon = "ui";
                  //   }
                  // }

                  }else{
                    var dbtDiff = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                    var fnDiff = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                    var Diff = fnDiff.diff(dbtDiff, 'days');
                    var d = value;
                    dureemin.push(parseInt(d));
                    // if(Diff < parseInt(d)){
                    //   if(dbtDiff.format('YYYY-MM-DD') == deb){
                    //     deb = moment(xml.details['fin'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                    //   }else{
                    //     fn = moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                    //   }
                    //   elim = d;
                    // }
                    // if(Diff == 7){
                    //   if(xml.details['condition'][1] == 1 && moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi'){
                    //       elimCon = "ui";
                    //   }else if (xml.details['condition'][1] == 2 && moment(xml.details['debut'][1], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche'){
                    //     elimCon = "ui";
                    //   }
                    // }

                  }
              });

              var maxMinduree = Math.max(...dureemin);
              var debutdiffmin = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
              var findiffmin = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
              var DiffDateCal = findiffmin.diff(debutdiffmin, 'days');
              if(DiffDateCal < maxMinduree){
                if(debutdiffmin.format('YYYY-MM-DD') == deb){
                  deb = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                }else{
                  fn = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                }
                elim = maxMinduree;
              } 

              if(deb < fn){
                xml.disponi[1] = 'Période : du '+moment(deb,'YYYY-MM-DD').format('DD/MM/YYYY')+' au '+moment(fn,'YYYY-MM-DD').format('DD/MM/YYYY')+' <br>';
              }else{
                xml.disponi[1] = '';
              }

              if( elimCon == ''){
                if((deb == debCal) && (fn == fnCal)){
                  document.getElementById("periodedispo").style.marginBottom = '0';

                  if(deb > fn){
                    if(xml.totalperiodecount == 0) $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('La période recherchée n\'existe pas, souhaitez-vous la créer ?') ?> <a class='btn btn-blue text-white rounded-0 p-1 ml-4' onclick='ajouterperiode()'><?= __("Ajouter une période") ?></a></span>");
                    else $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('PERIODE NON DISPONIBLE') ?> </span><br>");
                    $('#periodedispo').html('');
                  }else{
                    $('#resultatdispo').html("<span style='color: #106710;font-size: 15px;font-weight: 600;'><?= __('PERIODE DISPONIBLE') ?></span>");
                    $('#periodedispo').html('');
                    if(xml.disponi[1] != ''){
                    $('#periodedispo').append("<div style='visibility: hidden;' class='form-group radios'><label class='radio-inline'><input type='radio' name='sel' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"' checked><span></span></label></div>");
                  }
                  }

                 }else{
                   if(elim != ''){
                     $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('PERIODE NON DISPONIBLE') ?> (<?= __('Minimum séjour') ?>: "+elim+" <?= __('nuitées') ?>)</span><br>");
                     $('#periodedispo').html('');
                   }else{
                    if(xml.totalperiodecount == 0) $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('La période recherchée n\'existe pas, souhaitez-vous la créer ?') ?> <a class='btn btn-blue text-white rounded-0 p-1 ml-4' onclick='ajouterperiode()'><?= __("Ajouter une période") ?></a></span><br>");
                    else $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('PERIODE NON DISPONIBLE') ?> </span><br>");
                     $('#periodedispo').html('');
                   }

                  $.each(xml.disponi, function(index, value) {
                    if(xml.disponi[index] != ''){
                    $('#periodedispo').append("<div class='form-group radios'><label class='radio-inline'><input type='radio' name='sel' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"'><span> "+value+"</span></label></div>");
                  }
                  });
                }
              }else{
                if(xml.totalperiodecount == 0) $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('La période recherchée n\'existe pas, souhaitez-vous la créer ?') ?> <a class='btn btn-blue text-white rounded-0 p-1 ml-4' onclick='ajouterperiode()'><?= __("Ajouter une période") ?></a></span>");
                else $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('PERIODE NON DISPONIBLE') ?> </span><br>");
                $('#periodedispo').html('');
              }

         }else{
           //var i = 1;
           for (i = 1; i <= xml.nbrperiode; i++) {
             var elimCon = '';
               $.each(xml.nbrDiff[i], function(index, value) {

                 var deb = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                 var debCal = moment($('#location_du').val(),'DD-MM-YYYY').format('YYYY-MM-DD');
                 var fn = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
                 var fnCal = moment($('#location_au').val(),'DD-MM-YYYY').format('YYYY-MM-DD');

                  var elim = '';var elimCon = '';var dureemin = [];
                    $.each(xml.nbrDiff[i], function(index, value) {
                      if(value.toString().indexOf("_") != -1){
                        var tab = value.split("_");
                        var dbtDiff = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                        var fnDiff = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                        var Diff = fnDiff.diff(dbtDiff, 'days');
                        var d = tab[0];
                        dureemin.push(parseInt(d));
                        // if(Diff < parseInt(d)){
                        //   if(dbtDiff.format('YYYY-MM-DD') == deb){
                        //     deb = moment(tab[2], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                        //   }else{
                        //     fn = moment(tab[1], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                        //   }
                        //   elim = "ui";
                        // }
                        // if(Diff == 7){
                        //   if(xml.details['condition'][i] == 1 && moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi'){
                        //       elimCon = "ui";
                        //   }else if (xml.details['condition'][i] == 2 && moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche'){
                        //     elimCon = "ui";
                        //   }
                        // }

                        }else{
                          var dbtDiff = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                          var fnDiff = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]);
                          var Diff = fnDiff.diff(dbtDiff, 'days');
                          var d = value;
                          dureemin.push(parseInt(d));
                          // if(Diff < parseInt(d)){
                          //   if(dbtDiff.format('YYYY-MM-DD') == deb){
                          //     deb = moment(xml.details['fin'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                          //   }else{
                          //     fn = moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                          //   }
                          //   elim = "ui";
                          // }
                          // if(Diff == 7){
                          //   if(xml.details['condition'][i] == 1 && moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'samedi'){
                          //       elimCon = "ui";
                          //   }else if (xml.details['condition'][i] == 2 && moment(xml.details['debut'][i], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('dddd') != 'dimanche'){
                          //     elimCon = "ui";
                          //   }
                          // }

                        }

                    });
                    var maxMinduree = Math.max(...dureemin);
                    var debutdiffmin = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
                    var findiffmin = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]);
                    var DiffDateCal = findiffmin.diff(debutdiffmin, 'days');
                    if(DiffDateCal < maxMinduree){
                      if(debutdiffmin.format('YYYY-MM-DD') == deb){
                        deb = moment(fnCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).add(1, 'd').format('YYYY-MM-DD');
                      }else{
                        fn = moment(debCal, ["YYYY-MM-DD", "DD/MM/YYYY"]).subtract(1, 'd').format('YYYY-MM-DD');
                      }
                      elim = maxMinduree;
                    }
                    if(deb < fn){
                      xml.disponi[i] = 'Période  : du '+moment(deb,'YYYY-MM-DD').format('DD/MM/YYYY')+' au '+moment(fn,'YYYY-MM-DD').format('DD/MM/YYYY')+' <br>';
                    }else{
                      xml.disponi[i] = '';
                    }

               });

           }

           if( elimCon == ''){
            if(xml.totalperiodecount == 0) $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('La période recherchée n\'existe pas, souhaitez-vous la créer ?') ?> <a class='btn btn-blue text-white rounded-0 p-1 ml-4' onclick='ajouterperiode()'><?= __("Ajouter une période") ?></a></span><br>");
            else $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('PERIODE NON DISPONIBLE') ?> </span><br>");
             $('#periodedispo').html('');
             $.each(xml.disponi, function(index, value) {
               var deb = moment(xml.details['debut'][index], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
               var fn = moment(xml.details['fin'][index], ["YYYY-MM-DD", "DD/MM/YYYY"]).format('YYYY-MM-DD');
               if(xml.disponi[index] != ''){
                 $('#periodedispo').append("<div class='form-group radios'><label class='radio-inline'><input type='radio' name='sel' value='"+deb+"/"+fn+"' size='auto' id='"+deb+"/"+fn+"'><span> "+value+"</span></label></div>");
               }
             });
           }else{
            if(xml.totalperiodecount == 0) $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('La période recherchée n\'existe pas, souhaitez-vous la créer ?') ?> <a class='btn btn-blue text-white rounded-0 p-1 ml-4' onclick='ajouterperiode()'><?= __("Ajouter une période") ?></a></span>");
            else $('#resultatdispo').html("<span style='color: red;font-size: 15px;font-weight: 600;'><?= __('PERIODE NON DISPONIBLE') ?> </span><br>");
            //  console.log(elimCon);
             $('#periodedispo').html('');
           }
         }
        }

    });
     
   }
//</script>
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
jQuery(document).ready(function() {
document.getElementById("listenum").style.display = 'none';
  $('#adult').on( "change", function() {
    document.getElementById("listenum").style.display = 'block';
    $('#numl').html('');
    for (i = 1; i < $(this).val(); i++) {
      $('#numl').append("<input type='text' name='telephoneNum"+ i +"' id='num_tel"+ i +"' class='form-control' size='45' autocomplete='off'><span id='error-msg"+ i +"' class='hide'><?= __("Numéro invalide") ?></span><br><br>");

      var telInputdd = $("#num_tel"+i),
        errorMsgdd = $("#error-msg"+i);
        telInputdd.intlTelInput({
                      utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                      initialCountry: 'fr',
                      autoPlaceholder: true
                    });
                    var reset = function() {
                      telInputdd.removeClass("errorNumberTel");
                      errorMsgdd.addClass("hide");
                    };


      // on keyup / change flag: reset
      telInputdd.on("keyup change", reset);

    }
      //alert($(this).val());
  });
  
    $('#LocProp').on( "change", function() {
        if ($(this).is(':checked')) {
            $("#occupationcheck").val(1);
            getUser();
        }
        else{
            $("#occupationcheck").val(0);
            resetUserForm();
        }
    });
  
});
    
    function getUser(){
        $.ajax({
            url : '<?php echo $this->Url->build('/',true)?>utilisateurs/getuserinfos/<?=$this->Session->read('User.id')?>',
            type : 'GET',
            success : function(data, statut){
                if(data.user.pays==67)
                    setUser(data.user);
                else
                    setUser(data.user);
            },

            error : function(resultat, statut, erreur){

            }
        });
    }
    function setUser(user){
        $('#infoUser').hide();
        $('#regiondiv').css('display','none');
        $('#pays').val(user.pays);
        if(user.civilite=='Mr'||user.civilite=='M.')
            $('#CiviliteMr').prop("checked", true);
        else if(user.civilite=='Mme')
            $('#CiviliteMme').prop("checked", true);
        else if(user.civilite=='Melle')
            $('#CiviliteMlle').prop("checked", true);
        $('#nom').val(user.nom_famille);
        $('#prenom').val(user.prenom);
        $('#email').val(user.email);
        $('#code-postal').val(user.code_postal);
        
        $('#region').empty();
        $('#region').append('<option value=' + user.region + '></option>');
        $('#ville').empty();
        $('#ville').append('<option value=' + user.ville + '></option>');
        
        $("#portablenum1").attr('type','text');
        $("#portablenum1").intlTelInput('setNumber',user.portable);
        $("#portablenum1").val(user.portable);
        if ($("#portablenum1").intlTelInput("isValidNumber")) {
          $("#valid-msg").removeClass("hide");
          validNum = $("#portablenum1").intlTelInput("getNumber");
        } else {
          validNum = "non";
          $("#portablenum1").addClass("errorNumberTel");
          $("#error-msg").removeClass("hide");
          $("#error-msg").addClass("errorNumberTel");
        }
        
        $('#DefaultNumContainer').append($('#portableNum1Container'));

        $("#portablenum2").intlTelInput('destroy');
        $("#portablenum2").attr('type','text').val(user.portable2);
        
        $('#propName').html(user.nom_famille+' '+user.prenom);
        
        $("#TaxeNon").prop("checked", true);
    }
    function resetUserForm(){
        $('#infoUser').show();
        $('#pays').val('');
        $('#CiviliteMr').prop("checked", false);
        $('#CiviliteMme').prop("checked", false);
        $('#CiviliteMlle').prop("checked", false);
        $('#nom').val('');
        $('#prenom').val('');
        $('#email').val('');
        $('#code-postal').val('');
        $("#ville").html("");
        $("#region").html("");
        $('#regiondiv').css('display','none');
        $('#NumContainer').append($('#portableNum1Container'));
        $('#portablenum1').attr('type','text').val('').attr('type','number');
        $("#portablenum1").intlTelInput('setCountry','fr');
        
        $('#portablenum2').attr('type','text').val('').attr('type','number');
        $("#portablenum2").intlTelInput({
                      utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                      initialCountry: 'fr',
                      autoPlaceholder: true
                    });
                    
        $('#propName').html("<?= __('Info locataire') ?>");
        $("#TaxeNon").prop("checked", false);
    }

function ajouterperiode(){
  document.getElementById("erreurLabel").style.display = 'none';
  document.getElementById("erreurLabeladdnul").style.display = 'none';
  document.getElementById("erreurLabeldebut").style.display = 'none';  

  document.getElementById("erreurLabel").style.display = 'none';
  $('#addModel #formprixjour').removeClass('has-error');
  $('#Modaladd #prix_jour').val('');
  $('#Modaladd #prix').val('');
  $('#Modaladd #promo_jour').val('');
  $('#Modaladd #promo_px').val('');
  $('#Modaladd #finat').val('');
  $('#dbtat').datepicker('setDate', $("#location_du").val());
  $('#finat').datepicker('setDate', $("#location_au").val());
  $('#Modaladd').modal('show');
}

$("#valideradd").on("click", function(){
  // alert("OK");
  $('#addModel #formprixjour').removeClass('has-error');
  $('#addModel #formdebut').removeClass('has-error');
  // console.log(document.getElementById("addModel").elements["prix_jour"].value);
  if(document.getElementById("addModel").elements["prix_jour"].value == ''){
      $('#addModel #formprixjour').addClass('has-error');
    document.getElementById("erreurLabel").style.display = 'inline-block';
    document.getElementById("erreurLabeldebut").style.display = 'none';
    document.getElementById("erreurLabeladdnul").style.display = 'none';
    return false;
  }else if(document.getElementById("addModel").elements["prix_jour"].value == '0.00 €'){
    $('#addModel #formprixjour').addClass('has-error');
    document.getElementById("erreurLabeladdnul").style.display = 'inline-block';
    document.getElementById("erreurLabel").style.display = 'none';
    document.getElementById("erreurLabeldebut").style.display = 'none';
    return false;
  }else if(parseFloat(document.getElementById("addModel").elements["prix_jour"].value) <= parseFloat(document.getElementById("addModel").elements["promo_jour"].value)){
    alert("<?php echo __("Le prix promotionnel doit etre inférieur au prix initial !"); ?>");
    document.getElementById("erreurLabel").style.display = 'none';
    document.getElementById("erreurLabeladdnul").style.display = 'none';
    document.getElementById("erreurLabeldebut").style.display = 'none';
    return false;
  }

  var dbt = document.getElementById("addModel").elements["dbtat"].value;
  var fin = document.getElementById("addModel").elements["finat"].value;
  var debut = moment(dbt,"DD-MM-YYYY");
  var fin = moment(fin,"DD-MM-YYYY");

  if($("#addModel #statut").val() == 0 && debut < moment() ){
    $('#addModel #formdebut').addClass('has-error');
    document.getElementById("erreurLabel").style.display = 'none';
    document.getElementById("erreurLabeladdnul").style.display = 'none';
    document.getElementById("erreurLabeldebut").style.display = 'inline-block';
    return false;
  }

  // if($('#condition7add input[type=radio]:checked').val() == 1){
  //   if(moment($('#dbtat').val(),"DD-MM-YYYY").format('dddd') != "samedi"){
  //     alert("<?php echo __("Suivant la condition choisie, la date début doit être Samedi"); ?>");
  //     return false;
  //   }
  //   if(moment($('#finat').val(),"DD-MM-YYYY").format('dddd') != "samedi"){
  //     alert("<?php echo __("Suivant la condition choisie, la date fin doit être Samedi"); ?>");
  //     return false;
  //   }
  // }

  // if($('#condition7add input[type=radio]:checked').val() == 2){
  //   if(moment($('#dbtat').val(),"DD-MM-YYYY").format('dddd') != "dimanche"){
  //     alert("<?php echo __("Suivant la condition choisie, la date début doit être Dimanche"); ?>");
  //     return false;
  //   }
  //   if(moment($('#finat').val(),"DD-MM-YYYY").format('dddd') != "dimanche"){
  //     alert("<?php echo __("Suivant la condition choisie, la date fin doit être Dimanche"); ?>");
  //     return false;
  //   }
  // }

  if(debut.isSame(fin)){
    alert("<?php echo __("La date fin doit être différente de la date début !"); ?>");
    document.getElementById("erreurLabel").style.display = 'none';
    document.getElementById("erreurLabeladdnul").style.display = 'none';
    document.getElementById("erreurLabeldebut").style.display = 'none';
    return false;
  }else{
    var formData = {
      'dbt_at' : $('#Modaladd #dbtat').val(),
      'fin_at' : $('#Modaladd #finat').val(),
      'annonce_id' : $('#Modaladd #annonce_id').val(),
      'promo_jour' : $('#Modaladd #promo_jour').val(),
      'promo_px' : $('#Modaladd #promo_px').val(),
      'condition7' : $("#Modaladd input[name='condition7']").val(),
      'prix' : $('#Modaladd #prix').val(),
      'statut' : $('#Modaladd #statut').val(),
      'nbr_jour' : $('#Modaladd #nbr_jour').val(),
      'prix_jour' : $('#Modaladd #prix_jour').val(),     
    };
    $.ajax({
      type: "POST",
      async: false,
      dataType: 'json',
      encode : true,
      data : formData,
      url: "<?php echo $this->Url->build('/',true)?>dispos/calendarAddResMan",
      success:function(xml){
        
      }
    });
    var source = {
      url: '<?php echo $this->Url->build('/',true) ?>dispos/calendarDispoLoc/'+$('#Modaladd #annonce_id').val(),
      type: 'POST', // Send post data
    };
    $('#calendar3').fullCalendar('removeEvents');
    $('#calendar3').fullCalendar('addEventSource', source);
    $('#Modaladd').modal('hide');
    chercherdisponibilite();
    // return true;
  }
});

$('#condition7add input[type=radio]').change(function() {
  if(this.value != 0){
    var rest = parseInt($('#Modaladd #nbr_jour').val()) % 7;
    if(rest != 0){
      $('#Modaladd #nbr_jour').val(7);
      var dbt = document.getElementById("addModel").elements["dbtat"].value;
      var fin = document.getElementById("addModel").elements["finat"].value;
      var debut = moment(dbt,"DD-MM-YYYY");
      var fin = moment(fin,"DD-MM-YYYY");
      var differencedays = parseInt(fin.diff(debut, 'days'));
      if(differencedays <= parseInt($('#Modaladd #nbr_jour').val())){
        $('#finat').datepicker('setDate', debut.add(parseInt($('#Modaladd #nbr_jour').val()), 'd').format('DD-MM-YYYY'));
      }
    }
    CalculerMontant();
    CalculerMontantPromo();
  }
}); 

$('#Modaladd #nbr_jour').change(function() {
    var rest = parseInt($('#Modaladd #nbr_jour').val()) % 7;
    if(rest != 0){
      $('#_0').prop("checked", true);
    }

    var dbt = document.getElementById("addModel").elements["dbtat"].value;
    var fin = document.getElementById("addModel").elements["finat"].value;
    var debut = moment(dbt,"DD-MM-YYYY");
    var fin = moment(fin,"DD-MM-YYYY");
    var differencedays = parseInt(fin.diff(debut, 'days'));
    if(differencedays <= parseInt($('#Modaladd #nbr_jour').val())){
      $('#finat').datepicker('setDate', debut.add(parseInt($('#Modaladd #nbr_jour').val()), 'd').format('DD-MM-YYYY'));
    }
    CalculerMontant();
    CalculerMontantPromo();
});

$('#dbtat').on( "change", function() {
  var d = moment(this.value,"DD-MM-YYYY").add(1, 'd');
  $('#finat').datepicker( "option", "minDate", d.format('DD-MM-YYYY') );
  var rest = parseInt($('#Modaladd #nbr_jour').val()) % 7;
  if(rest != 0){
    $('#_0').prop("checked", true);
  }

  var dbt = document.getElementById("addModel").elements["dbtat"].value;
  var fin = document.getElementById("addModel").elements["finat"].value;
  var debut = moment(dbt,"DD-MM-YYYY");
  var fin = moment(fin,"DD-MM-YYYY");
  var differencedays = parseInt(fin.diff(debut, 'days'));
  if(differencedays <= parseInt($('#Modaladd #nbr_jour').val())){
    $('#finat').datepicker('setDate', debut.add(parseInt($('#Modaladd #nbr_jour').val()), 'd').format('DD-MM-YYYY'));
  }
    CalculerMontant();
    CalculerMontantPromo();
});

$('#finat').on( "change", function() {
  $("#Modaladd #prix_jour").attr('title','');
  $("#Modaladd #prix_jour").css('cursor','text');
  document.getElementById("addModel").elements["prix_jour"].disabled = false;
  $("#Modaladd #promo_jour").attr('title','');
  $("#Modaladd #promo_jour").css('cursor','text');
  document.getElementById("addModel").elements["promo_jour"].disabled = false;
  $("#Modaladd #prix").attr('title','');
  $("#Modaladd #prix").css('cursor','text');
  document.getElementById("addModel").elements["prix"].disabled = false;
  $("#Modaladd #promo_px").attr('title','');
  $("#Modaladd #promo_px").css('cursor','text');
  document.getElementById("addModel").elements["promo_px"].disabled = false;
  $("#Modaladd #nbr_jour").css('cursor','text');
  $("#Modaladd #nbr_jour").attr('title','');
  document.getElementById("addModel").elements["nbr_jour"].disabled = false;
  var rest = parseInt($('#Modaladd #nbr_jour').val()) % 7;
  if(rest != 0){
    $('#_0').prop("checked", true);
  }

  var dbt = document.getElementById("addModel").elements["dbtat"].value;
  var fin = document.getElementById("addModel").elements["finat"].value;
  var debut = moment(dbt,"DD-MM-YYYY");
  var fin = moment(fin,"DD-MM-YYYY");
  var differencedays = parseInt(fin.diff(debut, 'days'));
  if(differencedays <= parseInt($('#Modaladd #nbr_jour').val())){
    $('#finat').datepicker('setDate', debut.add(parseInt($('#Modaladd #nbr_jour').val()), 'd').format('DD-MM-YYYY'));
  }
  if($("#Modaladd #prix_jour").val() != ''){
    CalculerMontant();
  }
  if($("#Modaladd #promo_jour").val() != ''){
    CalculerMontantPromo();
  }

});

function CalculerMontant(){
  var prix = (document.getElementById("addModel").elements["prix_jour"].value).replace(" €", "");
  if(prix != '') {
    var dbt = document.getElementById("addModel").elements["dbtat"].value;
    var fin = document.getElementById("addModel").elements["finat"].value;
    var debut = moment(dbt,"DD-MM-YYYY");
    var fin = moment(fin,"DD-MM-YYYY");
    document.getElementById("addModel").elements["prix"].value = number_format(prix*(parseInt(fin.diff(debut, 'days'))), 2, '.', '')+ " €";
  }
}

function CalculerMontantPromo(){
  var prix = (document.getElementById("addModel").elements["promo_jour"].value).replace(" €", "");
  if(prix != '') {
  var dbt = document.getElementById("addModel").elements["dbtat"].value;
  var fin = document.getElementById("addModel").elements["finat"].value;
  var debut = moment(dbt,"DD-MM-YYYY");
  var fin = moment(fin,"DD-MM-YYYY");
  document.getElementById("addModel").elements["promo_px"].value = number_format(prix*(parseInt(fin.diff(debut, 'days'))), 2, '.', '')+ " €";
  }
}

function number_format (number, decimals, decPoint, thousandsSep) {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
  var n = !isFinite(+number) ? 0 : +number
  var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
  var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
  var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
  var s = ''
  var toFixedFix = function (n, prec) {
    var k = Math.pow(10, prec)
    return '' + (Math.round(n * k) / k)
      .toFixed(prec)
  }
  // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || ''
    s[1] += new Array(prec - s[1].length + 1).join('0')
  }
  return s.join(dec)
}
//</script>
<?php $this->Html->scriptEnd(); ?>
