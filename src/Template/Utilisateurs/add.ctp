<?php //echo $this->Url->build('/',true);?>
<?php $this->assign('title', __('Inscription | Alpissime.com - Vos plus belles vacances à la montagne')); ?>
<?php $this->Html->meta(null, null, ['property' => 'og:title','content' => __('Inscription | Alpissime.com - Vos plus belles vacances à la montagne'),'block' => 'meta']); ?>
<?php $this->Html->meta(null, null, ['name' => 'description','content' => __("Inscrivez-vous pour réserver vos vacances à la montagne sur Alpissime et composer votre séjour à la carte.") ,'block' => 'meta']); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php if($language_header_name == "en") $this->assign('canonicalUrl', SITE_ALPISSIME.'utilisateurs/add/'); ?>
<?php $this->assign('hreflang', SITE_ALPISSIME.'utilisateurs/add/'); ?>
<?php $this->assign('hreflangen', SITE_ALPISSIME.'en/users/add/'); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
// Restricts input for the set of matched elements to the given inputFilter function.
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
}(jQuery));



/*function validateForm(){
    $("#portable").val(validNum2);
    $("#ident").val($("#email").val());
    $("#pwd").val($("#pwd").val());

    return false;
}*/

jQuery(document).ready(function() {

  $("#num_tel").inputFilter(function(value) {
    return /^\d*$/.test(value);    // Allow digits only, using a RegExp
  });

  /*$("#num_tel").on('input', function() {
    $("#portable").val(validNum2);
    console.log(validNum2);
  });*/
  
  //$("select#pays option[value='0']").val("");

  $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);
  $('#naissance').datepicker({
        language: 'fr-FR',
        changeMonth: true,
            changeYear: true,
            yearRange :"-100:+0",
            dateFormat: 'dd/mm/yy'
    });

  //$( ".gj-datepicker" ).append( "<div class='invalid-feedback'><?= __("Merci de renseigner votre date de naissance") ?></div>" );
  $( ".listepays .input.select" ).append( "<div class='invalid-feedback'>Veuillez choisir votre pays.</div>" );

  $(".readonly").on('keydown paste', function(e){
        e.preventDefault();
    });
 
  var telInput = $("#num_tel"),
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
        //alert(telInput.intlTelInput("getNumber"));
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

  var telInputP = $("#num_tel"),
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
        $( ".intl-tel-input.allow-dropdown" ).append( "<div class='invalid-feedback'>Veuillez entrer votr.</div>" );
      }
    }
  });

  // on keyup / change flag: reset
  telInputP.on("keyup change", reset);

  $( ".intl-tel-input.allow-dropdown" ).append( "<div class='invalid-feedback'>Veuillez entrer votre numéro de téléphone.</div>" );

  $( "#pays" ).change(function() {  
    var monTableauJS = <?php echo json_encode($paysNum) ?>;
    $("#num_tel").intlTelInput("setCountry", monTableauJS[$(this).val()]);
    $("#num_tel").val('');
    $("#num_tel").intlTelInput("setCountry", monTableauJS[$(this).val()]);
    $("#num_tel").val('');
  });

  /*$( "#UtilisateurAddForm" ).submit(function( event ) {
    alert( "Handler for .submit() called." );
    console.log(validNum2);
    return false;
    event.preventDefault();
  });*/

});

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('UtilisateurAddForm');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {          
          event.preventDefault();
          event.stopPropagation();
        }

        var telInputP = $("#num_tel");
        telInputP.intlTelInput({
          utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
          initialCountry: 'fr',
          autoPlaceholder: true
        });
        var reset = function() {
          telInputP.removeClass("errorNumberTel");
        };
        // on blur: validate
        reset();
        var validNum2 = "non";
        if ($.trim(telInputP.val())) {          
          if (telInputP.intlTelInput("isValidNumber")) {
            validNum2 = telInputP.intlTelInput("getNumber");
            $("#portable").val(validNum2);
          } else {
            validNum2 = "non";
            telInputP.addClass("errorNumberTel");
          }
        }
        if(validNum2 == "non"){
          event.preventDefault();
          event.stopPropagation();
        }
        //grecaptcha.execute();
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
// setTimeout(function(){ grecaptcha.execute(); }, 5000);
<?php $this->Html->scriptEnd(); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div class="container">
	<div class="row justify-content-center">
    
    <div class="col-md-10 col-lg-8 col-xl-7">
			<div class="border shadow-sm px-3 px-xl-5 py-3 my-5">
        <div class="error">
          <?php echo $this->Flash->render(); ?>
        </div>
        <div class="row my-3">
          <div class="col-md-4"><h1><?= __("Inscription") ?></h1></div>
          <div class="col-md-8 text-secondary text-md-right"><p class="mb-0 mt-2"><?= __("Vous avez déjà un compte ?") ?> <a class="text-secondary" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['ouvrircompte'];?>"><u><?= __("Connexion") ?></u></a></p></div>
        </div>
        <?php echo $this->Form->create($utilisateur,['url' => SITE_ALPISSIME.$urlLang.$urlvaluemulti['utilisateurs']."/add/", 'id'=>'UtilisateurAddForm','class'=>'UtilisateurAddForm','oninput'=>'pwd_confirm.setCustomValidity(pwd_confirm.value != pwd.value ? "Passwords do not match." : "")','novalidate']);?>
        <?php echo $this->Form->input('id');?>
        <?php echo $this->Form->hidden('etat',['value'=>$etat]);?>
        <?php echo $this->Form->hidden('updated',['value'=>1]);?>
        <input type="hidden" id="telephone" name="telephone" />
        <input type="hidden" id="portable" name="portable" />
        <div class="form-group">
				    <label for="nature"><?= __("Vous êtes") ?></label>
				    <?php //echo $this->Form->input('nature',['type'=>'select','label'=>false,'class'=>'form-control custom-select','options'=>[''=>'Sélectionnez votre profil *','CLT'=>'Locataire','ANNO'=>'Propriétaire'],'required']);?>
            <select class="custom-select" name="nature" id="nature" required>
              <option value=""><?= __("Sélectionnez votre profil") ?> *</option>
              <option value="CLT"><?= __("Locataire") ?></option>
              <option value="ANNO"><?= __("Propriétaire") ?></option>
            </select>
            <div class="invalid-feedback">
              <?= __("Veuillez choisir votre profil.") ?>
            </div>
        </div>
        <div class="form-row">
            <div class="col-12"><label for="information"><?= __("Vos informations") ?></label></div>
            <div class="form-group col-md-6">
						  <input type="email" id="email" name="email" class="form-control" size="45" maxlength="255" placeholder="<?= __('Votre adresse email').' *' ?>" required>
              <div class="invalid-feedback">
                <?= __("Veuillez entrer une adresse email valide.") ?>
              </div>
					  </div>
					  <div class="form-group col-md-6 listepays">
              <?php echo $this->Form->input('pays',['type'=>'select','class'=>'form-control custom-select','label'=>false,'options'=>$Pays,'required']);?>
            </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <?php echo $this->Form->input('pwd',['type'=>'password','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Votre mot de passe').' *','required']);?>
            <!-- <input type="hidden" name="pwd" id="pwd" value=""> -->
            <div class="invalid-feedback">
              <?= __("Veuillez entrer votre mot de passe.") ?>
            </div>
          </div>
          <div class="form-group col-md-6">
            <?php echo $this->Form->input('pwd_confirm',['type'=>'password','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Confirmez votre mot de passe').' *','required']);?>
            <div class="invalid-feedback">
              <?= __("Veuillez confirmer votre mot de passe.") ?>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <?php echo $this->Form->input('nom_famille',['type'=>'text','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Votre nom').' *','required']);?>
            <div class="invalid-feedback">
              <?= __("Veuillez entrer votre nom.") ?>
            </div>
          </div>
          <div class="form-group col-md-6">
            <?php echo $this->Form->input('prenom',['type'=>'text','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Votre prénom').' *','required']);?>
            <div class="invalid-feedback">
              <?= __("Veuillez entrer votre prénom.") ?>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <?php //echo $this->Form->input('telephoneNum',['type'=>'number','id'=>'num_tel','class'=>'form-control ','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','required']);?>
            <input type="text" id="num_tel" name="telephoneNum" class="form-control" required />
            <span id="error-msg" class="hide"><?= __("Numéro invalide") ?></span>
          </div>
          <div class="input-group mb-2 col-md-6">
            <?php //echo $this->Form->input('naissance',['type'=>'text','readonly'=>'readonly','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>'Date de naissance *','required']);?>
            <input id="naissance" name="naissance" class="form-control readonly" placeholder="Date de naissance *" required />
            <div class="input-group-append d-block">
              <div class="input-group-text"><label class="add-on mb-0" for="naissance"><i class="fa fa-calendar"></i></label></div>
            </div>
            <div class='invalid-feedback'><?= __("Merci de renseigner votre date de naissance") ?></div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-7">
            <div class="custom-control custom-checkbox mt-4">
              <input type="checkbox" class="custom-control-input" id="conditiongen" name="conditiongen" required>
              <label class="custom-control-label text-secondary text-small" for="conditiongen"><?= __("J'accepte les") ?> <a class="text-secondary" href="<?php echo BLOG_ALPISSIME?>/conditions-generales-dutilisation-alpissime-com-2/" target="blanc"><u><?= __("Conditions Générales d'Utilisations") ?></u></a> * </label>
              <div class="invalid-feedback">
              <?= __("Vous devez accepter avant de valider.") ?>
              </div>
            </div>
          </div>
          <?php
            //echo $this->InvisibleReCaptcha->render();
          ?>
          <?= $this->Recaptcha->display() ?>
          <div class="form-group col-md-5">
				    <button type="submit" class="btn btn-blue text-white rounded-0 px-auto mt-3 w-100"><?= __("Inscription") ?></button>
          </div>
        </div>
        <?php echo $this->Form->end()?>
      </div>
    </div>
  </div>
</div>

