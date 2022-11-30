<?php $this->assign('title', __('Contact - Alpissime | Vos plus belles vacances à la montagne')); ?>
<?php $this->Html->meta(null, null, ['name' => 'description','content' => __("Vous avez une question pour Alpissime? Envoyez votre question ou votre commentaire via notre formulaire en ligne.") ,'block' => 'meta']); ?>
<?php $this->Html->meta(null, null, ['property' => 'og:title','content' => __('Alpissime Location vacances aux Arcs - Contact'),'block' => 'meta']); ?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {	
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('FormReservation');
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
// setTimeout(function(){ grecaptcha.execute(); }, 5000);
<?php $this->Html->scriptEnd(); ?>

<?php if($language_header_name == "en") $this->assign('canonicalUrl', SITE_ALPISSIME.'annonces/contact/'); ?>
<?php $this->assign('hreflang', SITE_ALPISSIME.'annonces/contact/'); ?>
<?php $this->assign('hreflangen', SITE_ALPISSIME.'en/listings/contact/'); ?>

<div class="container">
	<div class="row justify-content-center">
	<?php echo $this->Flash->render() ?>
		<div class="col-md-8 col-lg-6">
			<div class="border shadow-sm px-3 px-xl-5 py-3 my-5">
				<h1 class="my-3"><?= __("Contact") ?></h1>
				<?php echo $this->Form->create(null, array('class' => 'form-horizontal FormReservation','id'=>'FormReservation','novalidate'), ['url'=>['controller'=>'annonces','action' => 'contact']]); ?>
				<div class="form-group">
				    <label for="gestionnaire"><?= __("Qui souhaitez-vous contacter ?") ?></label>
				    <?php echo $this->Form->input('gestionnaire',['type'=>'select','label'=>false,'class'=>'form-control rounded-0 custom-select','options'=>$listegestionnaires]);?>
				</div>
				<div class="form-row">
				    <div class="col-12"><label for="information"><?= __("Vos informations") ?></label></div>
				    <div class="form-group col-md-6">
						<input type="email" id="email" name="email" class="form-control rounded-0" placeholder="<?= __('Adresse email').' *'; ?>" required>
						<div class="invalid-feedback">
							<?= __("Veuillez entrer une adresse email valide.") ?>
						</div>
					</div>
					<div class="form-group col-md-6">
						<input type="text" id="name" name="name" class="form-control rounded-0" placeholder="<?= __('Nom et prénom').' *'; ?>" required>
						<div class="invalid-feedback">
						    <?= __("Veuillez entrer votre nom.") ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<textarea class="form-control rounded-0" id="elmt" name="message" rows="3" placeholder="<?= __('Votre message').' *'; ?>" required></textarea>
					<div class="invalid-feedback">
						    <?= __("Veuillez entrer votre message.") ?>
						</div>
				</div>
				<div class="form-group">
				<?php
					// echo $this->InvisibleReCaptcha->render();
				?>
				<?= $this->Recaptcha->display() ?>
				</div>
				<div class="form-group text-right">
				    <button type="submit" class="btn btn-blue text-white rounded-0 px-6 mt-3"><?= __("Envoyer") ?></button>
				</div>
				<?php echo $this->Form->end()?>
			</div>
		</div>
	</div>
</div>
