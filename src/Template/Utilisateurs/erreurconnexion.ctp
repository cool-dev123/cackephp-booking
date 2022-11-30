<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<?php if($language_header_name == "en") $this->assign('canonicalUrl', SITE_ALPISSIME.'utilisateurs/erreurconnexion/'); ?>
<?php $this->assign('hreflang', SITE_ALPISSIME.'utilisateurs/erreurconnexion/'); ?>
<?php $this->assign('hreflangen', SITE_ALPISSIME.'en/users/erreurconnexion/'); ?>

<div class="warning">
<?php echo $this->Flash->render() ?>
</div>
<center>
<div class="cadrecontact"><?= __("Vous devez vous connecter pour accéder à votre espace client") ?>
<br/>
<span style="font-size: 9pt;"><?php echo $this->Html->link(__("Retourner à la connexion"), SITE_ALPISSIME.$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['ouvrircompte'])?></span>
</div></center>
