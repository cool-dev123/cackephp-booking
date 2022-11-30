<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<style>
#location_au.form-control[readonly], #location_au_msg.form-control[readonly], #location_du.form-control[readonly], #location_du_msg.form-control[readonly] {
    background: #f7f7f9;
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

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('propform');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }   
        // Execute recaptcha
        // grecaptcha.execute();     
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

$(document).ready(function() {
    $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);

    $( "#dialog:ui-dialog" ).dialog( "destroy" );
			
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

function validateForm(){
    erreurmsg = "";
    $("#erreurpays").css("display", "none");
    $("#erreuremail").css("display", "none");
    $("#erreurnom").css("display", "none");
    $("#erreurprenom").css("display", "none");
    $("#erreurportablenum1").css("display", "none");
    $("#mdpenclair").val("<?php echo $nouvMdp ?>");

    if($("#pays").val() == 0){
        $("#erreurpays").css("display", "block");
        erreurmsg = "oui";
    }

    if($("#email").val() == ""){
        $("#erreuremail").css("display", "block");
        erreurmsg = "oui";
    }

    if($("#nom").val() == ""){
        $("#erreurnom").css("display", "block");
        erreurmsg = "oui";
    }

    if($("#prenom").val() == ""){
        $("#erreurprenom").css("display", "block");
        erreurmsg = "oui";
    }

    if($("#portablenum1").val() == ""){
        $("#erreurportablenum1").css("display", "block");
        erreurmsg = "oui";
    }

    if(erreurmsg == "oui"){
        return false;
    }

    if(validNum == "non" || validNum2 == "non" || test == "non")
    {
        alert("Merci de vérifier la saisie des numéros de téléphone.");
        return false;
    }else if(!isValid){
        $('html, body').animate({
            scrollTop: $("#calendarResMan").offset().top
        }, 1000);

        return false;
    }else {
        $("#portable1").val(validNum);
        $("#portable2").val(validNum2);
        return true;
    }
}
    
<?php $this->Html->scriptEnd(); ?>

<?php
    $a_adult=array();
    for($i=1;$i<19;$i++){
        $a_adult[$i]=$i;
    }
    $a_child=array();
    for($i=0;$i<17;$i++){
        $a_child[$i]=$i;
    }
?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="reservation_en_cours" class="reservation_en_cours container">
  <div class="row justify-content-between mb-5">
      <div class="col espace-menu">
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/edit/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Coordonnées") ?></a></h3>
        <?php if($this->Session->read('Auth.User.nature')!='CLT'){?>
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Annonces") ?></a></h3>
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['infobancaire'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Paiements") ?></a></h3>
		<h3 class="border-bottom-menu-espace float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation"><?= __("Réservations") ?></a></h3>
        <?php }else{ ?>
		<h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a></h3>
		<?php } ?>
        <h3 class="float-left"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a></h3>
      </div>
      <?php if($this->Session->read('Auth.User.nature')=='CLT'){?>
      <div class="col-auto align-self-end">
        <h3 class="text-blue"><?= __("Espace") ?> <?php if($this->Session->read('Auth.User.nature')=='CLT') echo "Locataire"; else echo "Propriétaire";?></h3>
      </div>
	  <?php }?>
  </div>
  <div class="row">
    <div class="col-12 col-sm-4 col-md px-0">
      <a class="text-white btn-grey rounded-0 py-2 w-100 d-block text-decoration-none text-center" href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation"><?= __("Réservations en attente") ?></a>
    </div>
    <div class="col-12 col-sm-4 col-md px-0">
        <a class="text-white btn-grey rounded-0 py-2 w-100 d-block text-decoration-none text-center py-2" href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/view"><?= __("Réservations validées") ?></a>
    </div>
    <div class="col-12 col-sm-4 col-md px-0">
        <a class="text-white btn-blue rounded-0 py-2 w-100 d-block text-decoration-none text-center py-2" href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/reservationcalendar"><?= __("Réservations Synchronisées") ?></a>
    </div>
    <div class="col pr-0 pl-0 pl-md-2  text-center text-md-right mt-3 mt-md-0">
    <a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_addres'];?>"><span class="btn text-white bg-orange px-5 px-md-3 px-lg-5"><?= __("Créer une réservation") ?></span></a>
    </div>
  </div>
            
    <?php setlocale (LC_ALL, 'fr_FR.UTF8'); ?>
    <div class="row mt-5">
    <?php echo $this->Flash->render() ?>
        <?php echo $this->Form->create($reservation,['id'=>'FormReservation','url'=>['controller'=>'reservations','action'=>'editreservationcalendar', $reservation->id] , 'onsubmit'=>'return validateForm()']);?>
        <input type="hidden" id="mdpenclair" name="mdpenclair" />
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="location_du"><?= __("Date d'arrivée") ?></label>
                    <?php echo $this->Form->input('dbt',['label'=>false,'readonly'=>'readonly','type'=>'text','value'=>$reservation->dbt_at,'templates' => ['inputContainer' => "{{content}}"],'id'=>'location_du', 'class'=>'form-control inline-block location calendrier '])?>                
                </div>												
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="location_au"><?= __("Date de départ") ?></label>
                    <?php echo $this->Form->input('fin',['label'=>false,'readonly'=>'readonly','type'=>'text','value'=>$reservation->fin_at,'templates' => ['inputContainer' => "{{content}}"],'id'=>'location_au', 'class'=>'form-control inline-block location calendrier '])?>
                </div> 												
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="enfant"><?= __("Nombre d'enfants") ?> </label>
                    <?php echo $this->Form->input('enfant',[
                                    'label'=>'',
                                    'templates' => ['inputContainer' => "{{content}}"],
                                    'type'=>'select',
                                    'options'=>$a_child,'class'=>'form-control select custom-select'])?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="adult"><?= __("Nombre d'adultes à partir de 18 ans") ?></label>
                    <?php echo $this->Form->input('adult',[
                                'label'=>false,
                                'templates' => ['inputContainer' => "{{content}}"],
                                'type'=>'select',
                                'options'=>$a_adult,'class'=>'form-control select custom-select'])?>
                </div>
            </div>
        </div> 
        <div class="row py-4">
            <div class="col-md-12">
                <h3 class=""><u><?= __("Info locataire") ?></u></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for=""><?= __("Pays") ?> <sup class="orange">*</sup></label>
                    <?php echo $this->Form->input('pays',['type'=>'select','class'=>'form-control custom-select','label'=>false,'options'=>$Pays,'default'=>'0', 'required']);?>
                    <div id="erreurpays" class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>.
                    </div>
                </div>												
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="email"><?= __("Adresse e-mail") ?> *</label>
                    <?php echo $this->Form->input("email",[
                    'label'=>false,
                    'size'=>'45',
                    'id'=>'email',
                    'maxlength'=>'100','class'=>'form-control select custom-select validate[required,custom[email],funcCall[notAirbnbEamil]]'])?>
                    <div id="erreuremail" class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>.
                    </div>
                </div>												
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="nom">Nom *</label>
                    <?php echo $this->Form->input("nom",['label'=>false,'size'=>'45','type'=>'text','maxlength'=>'60','class'=>'form-control select custom-select validate[required]'])?>
                    <div id="erreurnom" class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>.
                    </div>
                </div>		
            </div>
			<div class="col-sm-6">
                <div class="form-group">
                    <label for="prenom"><?= __("Prénom") ?> *</label>
                    <?php echo $this->Form->input("prenom",[
                        'label'=>false,
                        'size'=>'45',
                        'maxlength'=>'60','class'=>'form-control select custom-select validate[required]'])?>
                    <div id="erreurprenom" class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>.
                    </div>
                </div>
            </div>
		</div>
        <div class="row">
            <div class="col-sm-6" id="NumContainer">
                <div class="form-group" id="portableNum1Container">
                    <label for="portable1"><?= __("Numéro portable") ?> *</label>
                    <?php echo $this->Form->input("portableNum1",[
                        'label'=>false,
                        'type' => 'number',
                        'size'=>'45',
                        'maxlength'=>'40','class'=>'form-control select custom-select validate[required]'])?>
                    <span id="error-msg" class="hide"><?= __("Numéro invalide") ?></span>
                    <div id="erreurportableNum1" class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>.
                    </div>
                </div>
            </div>
            <input type="hidden" id="portable1" name="portable1" />
            <input type="hidden" id="portable2" name="portable2" />
			<div class="col-sm-6">
				<div class="form-group">
					<label for="portable2"><?= __("2éme numéro portable") ?></label>
                    <?php echo $this->Form->input("portableNum2",[
                        'label'=>false,
                        'size'=>'45',
                        'type' => 'number',
                        'maxlength'=>'40','class'=>'form-control select custom-select'])?>
                    <span id="error-msg2" class="hide"><?= __("Numéro invalide") ?></span>
                </div>
            </div>
        </div>            
        <div class="row py-4">
            <div class="col-md-12">
                <h3 class=""><u><?= __("Votre commentaire") ?></u></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for=""><?= __("Commentaire") ?><br><small><?= __("Indiquer ici les commentaires relatifs à la réservation. Si vous souhaitez modifier la date d'arrivée ou de départ, utilisez les calendriers ci-dessus.") ?></small></label>
                    <textarea class="form-control" name="comment" id="comment" rows=2 cols=3></textarea>
                </div>												
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-md-auto">
                <button type="submit" class="btn btn-blue text-white rounded-0"><?= __("Modifier la réservation") ?>
                </button>
            </div>
        </div>

        <?php echo $this->Form->end();?>                                            

    </div>
</div>
