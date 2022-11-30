<?php echo $this->Flash->render('positive') ?>

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
              <div class="invalid-feedback">
                <?= __("Veuillez entrer une adresse email valide.") ?>
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->input("pwd", array('type'=>'password', 'templates' => ['inputContainer' => '{{content}}'],'label' =>false, 'placeholder' => __('Votre mot de passe').' *', 'class' => "form-control rounded-0", 'maxlength' => 100, 'required')); ?>
              <div class="invalid-feedback">
                <?= __("Veuillez entrer votre mot de passe.") ?>
              </div>
            </div>
            <div class="form-row justify-content-between">
              <div class="col-auto">
                <a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mdpPerdu'];?>" class="paword_link text-secondary"><u><?= __("Mot de passe oublié !") ?></u></a>
              </div>
              <div class="form-group col-auto text-md-right">
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->submit("Connexion", array('class' => "btn btn-blue text-white rounded-0 px-6 mt-3 w-100")); ?>
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

    <!--popup reservation-->
    <div class="modal fade" id="popup_password">
      <div class="modal-dialog modal-dialog-centered">
        <div class="col-md-12 modal-content">
          <div class="modal-header">
            <button type="button" class="close" onclick="fermer();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-lock fa-lg"></i> <?= __("Demander un nouveau mot de passe") ?></h4>
          </div>
          <div class="modal-body">
          <div class="col-md-12 gray_background block">
            <div class="form-group">
              <p>
              <?= __("Nous vous avons envoyé un e-mail avec les instructions pour réinitialiser votre mot de passe.<br>Vérifiez votre boite de réception et cliquez sur le lien.") ?>
              </p>
            </div>
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success hvr-sweep-to-top" onclick="fermer();"><?= __("Fermer la fenetre") ?></button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>

    function fermer(){
        $('#popup_password').modal('hide');
        window.location.replace("<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['ouvrircompte']; ?>");
    }

    $(document).ready(function() {
    //  $('#myModal').modal({backdrop: 'static', keyboard: false})
      $('#popup_password').modal({backdrop: 'static', keyboard: false});
    });

    <?php $this->Html->scriptEnd(); ?>
