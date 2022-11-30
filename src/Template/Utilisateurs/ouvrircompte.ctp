<?php $this->Html->scriptStart(array('block' => 'tagmanager')); ?>
	var subok = "<?php echo $SubmitOK ?>";
  var vistype = "<?php echo $visitorType; ?>";
	if(subok == "OK") {
		dataLayer = [{ 'pageCategory': 'signup', 'submitOk': 'OK', 'visitorType': vistype }];
  }
  function goBack() {
    window.history.back();
  }

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('connexionuser');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
<?php $this->Html->scriptEnd(); ?>
<?php echo $this->Flash->render('positive') ?>
<?php $this->assign('title', __('Location vacances à la montagne - Connexion')); ?>
<?php $this->Html->meta(null, null, ['property' => 'og:title','content' => __('Alpissime Location vacances à la montagne - Connexion'),'block' => 'meta']); ?>
<?php $this->Html->meta(null, null, ['name' => 'description','content' => __("Pour vos belles vacances sur alpissime, Connectez vous sur votre compte.") ,'block' => 'meta']); ?>

<?php if($language_header_name == "en") $this->assign('canonicalUrl', SITE_ALPISSIME.'utilisateurs/ouvrircompte/'); ?>
<?php $this->assign('hreflang', SITE_ALPISSIME.'utilisateurs/ouvrircompte/'); ?>
<?php $this->assign('hreflangen', SITE_ALPISSIME.'en/users/openaccount/'); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div class="container">
	<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-6">
        <div class="border shadow-sm px-3 px-md-5 py-3 my-5">
          <h1 class="my-3 text-center pb-3"><?= __("Connexion") ?></h1>
          <?php echo $this->Form->create(null, array('class' => 'form-horizontal connexionuser','novalidate'), ["url"=>["controller"=>"utilisateurs","action"=>"connexion"]])?>
          <div class="warning">
            <?php echo $this->Flash->render('flash', [
                'element' => 'Flash/erroremailconfirmation'
            ]); ?>
          </div>
            <div class="form-group">
              <?php echo $this->Form->input("email",array('templates' => ['inputContainer' => '{{content}}'],'label' =>false,'placeholder' => __('Votre adresse email').' *', 'class' => "form-control rounded-0", 'maxlength' => 100, 'required')); ?>
						  <!-- <input type="email" id="email" name="email" class="form-control rounded-0" placeholder="Votre adresse email *" maxlength="100" required> -->
              <div class="invalid-feedback">
                <?= __("Veuillez entrer une adresse email valide.") ?>
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->input("pwd", array('type'=>'password', 'templates' => ['inputContainer' => '{{content}}'],'label' =>false, 'placeholder' => __('Votre mot de passe').' *', 'class' => "form-control rounded-0", 'maxlength' => 100, 'required')); ?>
						  <!-- <input type="password" id="pwd" name="pwd" class="form-control rounded-0" placeholder="Votre mot de passe *" maxlength="100" required> -->
              <div class="invalid-feedback">
                <?= __("Veuillez entrer votre mot de passe.") ?>
              </div>
            </div>
            <div class="form-row justify-content-between">
              <div class="col-auto">
                <a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mdpPerdu'];?>" class="paword_link text-secondary"><u><?= __("Mot de passe oublié !") ?></u></a>
              </div>
              <div class="form-group col-auto text-md-right">
                <!-- <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="souvenirmoi">
                  <label class="custom-control-label text-secondary" for="souvenirmoi">Se souvenir de moi</label>
                </div> -->
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->submit(__("Connexion"), array('class' => "btn btn-blue text-white rounded-0 px-6 mt-3 w-100")); ?>
				      <!-- <button type="submit" class="btn btn-blue text-white rounded-0 px-6 mt-3 w-100" name="Envoyer"><?= __("Connexion") ?></button> -->
            </div>
            <?php echo $this->Form->end(); ?>
            <div class="row">
              <div class="col-12">
                <p class="text-secondary"><?= __("Vous n'avez pas encore de compte ?") ?> <a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/add"  class="text-secondary"><u><?= __("Inscription") ?></u></a> </p>
                <p><a class="text-secondary cursor-pointer" onclick="goBack()"><i class="fa fa-chevron-left mr-2 text-small"></i><u><?= __("Retour") ?></u></a></p>
              </div>
            </div>
        </div>
    </div>
  </div>
</div>

<?php if($afficheEmail): ?>
<div class="modal fade" id="popup_confirm_mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h2 class="modal-title txt-black" id="myModalLabel">Information</h2>
			</div>
			<div class="modal-body text-center">
                            <p class="p-modal txt-green">
                            <?php echo __("Un email de confirmation vous a été envoyé par Alpissime (administration@alpissime.com). Veuillez consulter votre boite mail pour activer votre compte."); ?>
                            </p>
			</div>
			<div class="modal-footer">
                            <button data-dismiss="modal" aria-label="Close" class="btn btn-success hvr-sweep-to-top ">OK</button>
                        </div>
		</div>
	</div>
</div>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
    $('#popup_confirm_mail').modal('show')
<?php $this->Html->scriptEnd(); ?>

<?php endif; ?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
    /* function renvoyermail(){
      $.ajax({
          type: "POST",
          dataType : 'json',
          url: "<?php echo $this->Url->build('/',true)?>utilisateurs/renvoiemailconfirmation/",
          data: {email: '<?php echo $_SESSION['emailconfirmation']; ?>'},
          success:function(xml){                
            $('.renvoiemessage').addClass('hidden');           
          }
      });
    } */
<?php $this->Html->scriptEnd(); ?>
