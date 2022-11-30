<?php echo $this->Flash->render() ?>
<?php $this->assign('title', __('Location vacances aux Arcs - Nouveau mot de passe')); ?>
<?php $this->Html->meta(null, null, ['property' => 'og:title','content' => __('Alpissime Location vacances aux Arcs - Nouveau mot de passe'),'block' => 'meta']); ?>
<?php $this->Html->meta(null, null, ['name' => 'description','content' => __("Un nouveau mot de passe sera généré et vous sera envoyé par email à l'adresse indiquée dans ce formulaire.") ,'block' => 'meta']); ?>
<?php if($language_header_name == "en") $this->assign('canonicalUrl', SITE_ALPISSIME.'utilisateurs/mdpPerdu/'); ?>
<?php $this->assign('hreflang', SITE_ALPISSIME.'utilisateurs/mdpPerdu/'); ?>
<?php $this->assign('hreflangen', SITE_ALPISSIME.'en/users/pwLost/'); ?>

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
function validateForm(){
  $("#mdpenclair").val("<?php echo $nouvMdp ?>");
  $("#nouveauMdpHidden").val(html);
 return true;
}
<?php $this->Html->scriptEnd(); ?>



<div class="container">
<div class="row">
  <div class="col-md-12">
    <?php echo $this->Form->create(null,['url'=>["action"=>"nouveauMdp"],'onsubmit'=>'return validateForm()'])?>
    <input type="hidden" id="nouveauMdpHidden" name="nouveauMdpHidden" />
    <input type="hidden" id="mdpenclair" name="mdpenclair" />


        <h1><?= __("Nouveau mot de passe") ?></h1>
        <div class="header_title">
          <span class="gray-fonce"><?= __("Demander un nouveau mot de passe") ?></span>
        </div>
        <p class="txt-norma">
          <?= __("Merci de préciser votre identifiant. Un nouveau mot de passe sera généré et vous sera envoyé par email à l'adresse indiquée dans votre fiche.") ?>
          </p>
<div class="form-horizontal col-md-8">
          <div class="form-group form-row">
            <label class="col-md-4"><?= __("Votre e-mail") ?> <sup class="orange">*</sup></label>
             <div class="col-md-8">
               <?php echo $this->Form->input("ident",['class' => 'form-control rounded-0','label' => false])?>
            </div>
          </div>
          </div>

<div class="form-row">
        <div class="col-md-12">
        <div class="pull-right block">
          <button type="submit" class="btn btn-blue text-white rounded-0" value="Demander un nouveau mot de passe" name="Demander un nouveau mot de passe" ><?= __("Demander un nouveau mot de passe") ?></button>
        </div>
        </div>
        </div>
        <?php echo $this->Form->end();?>
        
        </div>
</div>
</div>