<?php $this->Html->scriptStart(array('block' => 'tagmanager')); ?>
	var subok = "<?php echo $_SESSION['SubmitOK']; ?>";
	if(subok == "OK") {
		dataLayer = [{ 'annonce_creee': 'true', 'submitOk': 'OK' }];
	}
  <?php $_SESSION['SubmitOK']=''; ?>
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
jQuery(document).ready(function() {  
  $(".menu_annon").css('display','block');
  $.cookie("lieugeo_id", null);
  $.cookie("nature", null);
  $.cookie("personnes_nb", null);
});
<?php $this->Html->scriptEnd(); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>


<div class="sectiondroite container">

<div class="row bg-light no-gutters mb-4 mt-n3" >
  <div class="col-sm-6 col-lg-3 list-steps">
  <a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/edit/<?php echo $annonce_id ?>"><span class="d-block text-center ann-step active-steps">1. <?= __("Informations") ?></span></a>
  </div>
  <div class="col-sm-6 col-lg-3 list-steps">
  <a href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/photo/<?php echo $annonce_id ?>'><span class="d-block text-center ann-step after-active-steps">2. <?= __("Images") ?></span></a>
  </div>
  <div class="col-sm-6 col-lg-3 list-steps">
  <a  href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['dispos']; ?>/view/<?php echo $annonce->id ?>'><span class="d-block text-center ann-step">3. <?= __("Tarification") ?></span></a>
  </div>
  <div class="col-sm-6 col-lg-3 list-steps">
  <a  href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/".$urlvaluemulti['previsualiser']; ?>/<?php echo $annonce_id ?>'><span class="d-block text-center text-lg-right text-xl-center ann-step">4. <?= __("Prévisualisation") ?></span></a>
  </div>
</div><!-- end row -->
      <div class="row">
        <div class="col-md-12">
        <?php echo $this->Flash->render() ?>
          <div class="header_title bg-light">
            <h5 class="mb-2 mt-2 py-2 px-3"><?= __('Informations détaillées'); ?></h5>
          </div><!-- header_title-->
        </div> <!--end col-md-12-->
      </div> <!--end row-->

<div class="row mt-3">
    <div class="col-md-12 block">
          <div class="form-group">
                  <?php echo $this->Form->create($annonce,['url' => SITE_ALPISSIME.$urlLang.$urlvaluemulti['annonces']."/edit2/".$annonce_id]);?>
                  <?php //echo $this->Form->input('creation',['type'=>'hidden','value'=>$creation])?>
                  <?php echo $this->Form->input("id",['type'=>'hidden','value'=>$annonce_id]);?>
                    <label for=""><?= __('Des informations complémentaires à apporter ? Faites-le ici !'); ?></label>
                    <?php echo $this->Form->input('texte1',[
                      'label'=>'',
                      'templates' => ['inputContainer' => "{{content}}"],
                      'type'=>'textarea',
                      'rows'=>'10','cols'=>'75',
                      'maxlength'=>'255','value'=>$annonce->texte1,'class'=>'form-control mt-3 rounded-0']);?>
          </div>
    </div>
</div>
  
  <?php if($annonce->contrat == 0){ ?>
  <div class="row">
    <div class="col-md-12">
      <div class="header_title bg-light">
        <h5 class="mb-2 mt-2 py-2 px-3"><?= __('Informations Arrivée / Départ'); ?></h5>
      </div><!-- header_title-->
    </div> <!--end col-md-12-->
  </div> <!--end row-->
  <div class="row mt-3">
    <div class="col-md-12 block">
      <div class="form-group">
      <label><?= __('Renseignez ici toutes les informations que vous souhaitez communiquer à vos locataires pour faciliter leur arrivée et leur départ. Elles leur seront automatiquement envoyées par mail au moment le plus adéquat.'); ?></label>
      </div>
    </div>
  </div>
  <div class="row mt-3">
      <div class="col-md-6 block">
          <div class="form-group">
            <label for=""><?= __("Informations concernant l'arrivée"); ?></label>
              <?php echo $this->Form->input('bloc_info_arrivee',[
                'label'=>false,
                'id'=>'bloc_info_arrivee',
                'templates' => ['inputContainer' => "{{content}}"],
                'type'=>'textarea',
                'value'=>$annonce->bloc_info_arrivee,'class'=>'form-control mt-3 rounded-0']);?>
          </div>
      </div>
      <div class="col-md-6 block">
          <div class="form-group">
            <label for=""><?= __("Informations concernant le départ"); ?></label>
              <?php echo $this->Form->input('bloc_info_depart',[
                'label'=>false,
                'id'=>'bloc_info_depart',
                'templates' => ['inputContainer' => "{{content}}"],
                'type'=>'textarea',
                'value'=>$annonce->bloc_info_depart,'class'=>'form-control mt-3 rounded-0']);?>
          </div>
      </div>
  </div>

  <?php } ?>
                    <div class="row mt-4 justify-content-end">
                      <div class="col-auto">
                        <button type="submit" class="btn btn-blue text-white rounded-0 px-6" value="Enregistrer"><?= __("Enregistrer") ?></button>                              
                      </div>
                    </div>
                      <?php echo $this->Form->end();?>
</div>



