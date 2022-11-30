<?php //$this->Html->css("/css/modif_datepicker.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<style>
html{
	overflow-x: visible;
}
.has-error{
    border-color: #a94442;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
}
</style>
<?php echo $this->Flash->render() ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="espace_locataire" class="container">
  <div class="row flex-column-reverse flex-md-row justify-content-md-between mb-5">
      <div class="col-12 col-md espace-menu">
        <h3 class="border-bottom-menu-espace float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/edit/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Coordonnées") ?></a></h3>
        <?php if($this->Session->read('Auth.User.nature')!='CLT'){?>
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Annonces") ?></a></h3>
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['infobancaire'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Paiements") ?></a></h3>
        <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation"><?= __("Réservations") ?></a></h3>
        <?php }else{ ?>
		    <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a></h3>
        <?php } ?>
        <h3 class="float-left"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a></h3>
      </div>
      <?php if($this->Session->read('Auth.User.nature')=='CLT'){?>
      <div class="col-auto">
      <a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index'];?>" class="text-decoration-none">
        <h3 class="text-blue espace-type"><?= __("Espace locataire") ?></h3>
      </a>
      </div>
      <?php }?>
	</div>
  <div class="row justify-content-center">
    
    <div class="col-md-9 col-lg-7">
			<div class="border shadow-sm px-3 px-lg-5 py-3 my-5">
        <div class="row my-3">
          <div class="col-md-4"><h1><?= __("Informations") ?></h1></div>
          <div class="col-md-8 text-secondary text-md-right"><p class="mb-0 mt-2"><?php if(!$possible){ ?><a href="#" class="text-secondary" onclick="show_popup();"><u><?= __("Changer votre mot de passe") ?></u></a><?php } ?></p></div>
        </div>
        <?php echo $this->Form->create($utilisateur,['class'=>'UtilisateurEditForm','novalidate']);?>
            <?php echo $this->Form->input('id');?>

        <div class="form-group">
				    <label for="nature" class="font-weight-bold"><?= __("Vous êtes") ?></label>
            <input type="text" class="form-control" name="inputdaffiche" value="<?php if($this->Session->read('Auth.User.nature')=='CLT') echo __("Locataire");if($this->Session->read('Auth.User.nature')!='CLT') echo __("Propriétaire");?>" readonly />
            <input type="hidden" name="nature" id="nature" value="<?php echo $this->Session->read('Auth.User.nature'); ?>" />
            <div class="invalid-feedback">
              <?= __("Veuillez choisir votre profil.") ?>
            </div>
        </div>
        <div class="form-row">
            <div class="col-12"><label for="information" class="font-weight-bold"><?= __("Vos informations") ?></label></div>
            <div class="form-group col-md-6">
            <?php echo $this->Form->input('email',['type'=>'text','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','required']);?>
						  
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
          <?php echo $this->Form->input('portable',['type'=>'text','class'=>'form-control validate[required]','label'=>false,'id'=>'portablenum','templates' => ['inputContainer' => "{{content}}"],'size'=>'45','required']);?>
            <span id="error-msg" class="hide"><?= __("Numéro invalide") ?></span>
          </div>
          <div class="input-group mb-2 col-md-6">
            <?php echo $this->Form->input('naissance',['type'=>'text','readonly'=>'readonly','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Date de naissance').' *','required']);?>
            <div class="input-group-append d-block">
              <div class="input-group-text"><label class="add-on mb-0" for="naissance"><i class="fa fa-calendar"></i></label></div>
            </div>
            <div class='invalid-feedback'><?= __("Merci de renseigner votre date de naissance") ?></div>
          </div>
        </div>
        <input type="password" class="full" id="password" name="password" style="visibility:hidden" value="">

        <div class="form-row justify-content-end">
          
          <div class="form-group col-md-5">
				    <button type="submit" class="btn btn-blue text-white rounded-0 px-auto mt-3 w-100"><?= __("Enregistrer") ?></button>
          </div>
        </div>
        <?php echo $this->Form->end()?>
      </div>
    </div>
  </div>

				</div>
			</div>

      <!--popup reservation-->
      <div class="modal fade" id="popup_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <?php echo $this->Form->create($utilisateur,["url"=>["controller"=>"Utilisateurs","action"=>"changemdp"],"id"=>"f2","onsubmit"=>"return submit_f2()"])?>
        <?php echo $this->Form->input("id")?>
        <input type="hidden" id="passwordOld" name="passwordOld" >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-lock"></i> <?= __("Changer votre mot de passe") ?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
      			<div class="col-md-12 gray_background block">
      				<div class="form-group">
      					<label for="mdp"><?= __("Nouveau mot de passe") ?> <span class="orange">*</span></label>
                <?php echo $this->Form->input("mdp",["class"=>"form-control rounded-0","label"=>false,"type"=>"password",'templates' => ['inputContainer' => "{{content}}"]])?>
              </div>
      				<div class="form-group">
      					<label for="mdp_compare"><?= __("Confirmez le nouveau mot de passe") ?> <span class="orange">*</span></label>
                <?php echo $this->Form->input("mdp_compare",["class"=>"form-control rounded-0","label"=>false,"type"=>"password",'templates' => ['inputContainer' => "{{content}}"]])?>
            	</div>
            </div>
            <div class="col-12 text-right"><button type="submit" class="btn btn-blue text-white rounded-0"><?= __("Sauvegarder") ?></button></div>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      <?php echo $this->Form->end();?>
      </div><!-- /.modal -->
			<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>

			<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
      //<script>
      
      // Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('UtilisateurEditForm');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        
        var telInputP = $("#portablenum");
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
            $("#portablenum").val(validNum2);
          } else {
            validNum2 = "non";
            telInputP.addClass("errorNumberTel");
          }
        }
        if(validNum2 == "non"){
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();  
			$( "#pays" ).change(function() {			  
                          
			  var monTableauJS = <?php echo json_encode($paysNum) ?>;
			  $("#portablenum").intlTelInput("setCountry", monTableauJS[$(this).val()]);
			  $("#portablenum").val('');
                          validNum2 = "non";
			});

			var validNum = "non";
			var validNum2 = "non";
			jQuery(document).ready(function() {

				var telInputP = $("#portablenum"),
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

        $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);
				// setTimeout('var telInput = $("#utiliTelephone"),	errorMsg = $("#error-msg"),	validMsg = $("#valid-msg"); if ($.trim(telInput.val())) {	if (telInput.intlTelInput("isValidNumber")) {		validMsg.removeClass("hide");		validNum = telInput.intlTelInput("getNumber");	} else {		validNum = "non";		telInput.addClass("errorNumberTel"); errorMsg.removeClass("hide");		errorMsg.addClass("errorNumberTel"); }} var telInputP = $("#portablenum"),	errorMsgP = $("#error-msg2"),	validMsg = $("#valid-msg"); if ($.trim(telInputP.val())) {	if (telInputP.intlTelInput("isValidNumber")) {		validMsg.removeClass("hide");		validNum2 = telInputP.intlTelInput("getNumber");	} else {		validNum2 = "non";		telInputP.addClass("errorNumberTel"); errorMsgP.removeClass("hide");		errorMsgP.addClass("errorNumberTel"); }}', 3000);
        $( ".intl-tel-input.allow-dropdown" ).append( "<div class='invalid-feedback'>Veuillez entrer votre numéro de téléphone.</div>" );
      });

			function submit_Utilisateur(){
				if($("#portablenum").val() == ''){
					$("#error-msg2").removeClass("hide");
                                        $("#error-msg2").addClass("errorNumberTel");
				}else{
                                    $("#error-msg2").removeClass("errorNumberTel");
                                    $("#error-msg2").addClass("hide");
                                }

			  if(validNum != "non") {
			    $("#utiliTelephone").val(validNum);
				}
				if(validNum2 != "non")
			  {
					$("#portablenum").val(validNum2);
			  }

				if(validNum2 == "non")
			  {
					return false;
			  }

				if($("#pays").val() == 0 || !$("#pays").val()){
					$("#pays").addClass("has-error");
					return false;
				}

			}

          function show_popup(){
              $("#passwordOld").val($("#password").val());
              $('#popup_password').modal('show')
          }

          function submit_f2()
          {
              if($("#mdp").val()=="") {
                  alert("<?php echo __("Mot de passe obligatoire"); ?>");
                  $("#mdp").focus();
                  return false;
              }
              if($("#mdp").val()!=$("#mdp-compare").val()) {
                  alert("<?php echo __("Mot de passe différents - recommencez"); ?>");
                  $("#mdp").val("");
                  $("#mdp-compare").val("");
                  $("#mdp").focus();
                  return false;
              }
              return true;
          }

          $('#naissance').datepicker({
        language: 'fr-FR',
        changeMonth: true,
            changeYear: true,
            yearRange :"-100:+0",
            dateFormat: 'dd/mm/yy'
    });
      <?php $this->Html->scriptEnd(); ?>
