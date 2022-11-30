<?php $this->append('headTop', "<script> gtag('event', 'conversion', {'send_to': 'AW-959030564/-JJfCOiulNwDEKTKpskD'}); </script>"); ?>

<!-- select2 JS -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>
<!-- select2 CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>
<!-- jquery-steps css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery.steps/demo/css/jquery.steps.css", array('block' => 'cssTop')); ?>
<!-- Google map -->
<?php $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&libraries=places", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/dropzone.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/bootstrap-imageupload.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/css/general.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/bootstrap-imageupload.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->append('cssTopBlock', '<style>
.first a {
  border-radius: 15px 0px 0px 15px !important;
}
.last a {
  border-radius: 0px 15px 15px 0px !important;
}
.wizard > .steps a, .wizard > .steps a:hover, .wizard > .steps a:active{
  margin: 0;
  /* padding: 10px 0px 10px 0px; */
  padding: 5px;
  text-align: center;
  font-size: 13px;
}
.wizard > .steps .current a, .wizard > .steps .current a:hover, .wizard > .steps .current a:active, .wizard > .steps .done a, .wizard > .steps .done a, .wizard > .steps .done a:hover {
    background: #0099ff;
    border-radius: 0;
}
.wizard > .steps .disabled a, .wizard > .steps .disabled a:hover, .wizard > .steps .disabled a:active{
  background: #dee2e6;
  border-radius: 0;
}
.wizard > .steps .number{
    font-size: 13px;
}
.wizard > .content{
    margin: 0px;
    background: white;
}
.wizard > .content > .body {
    padding: 0px;
    width: 100%;
    height: 100%;
    position: initial;
    margin-top: 0px;
}
.wizard > .content > .body label{
    font-weight: 500;
}
button[href="#next"] {
  border-radius: 0px;
  font-size: 16px;
  padding-left: 5rem!important;
  padding-right: 5rem!important;
}
form .custom-checkbox label, form .custom-radio label{
    font-weight: 400 !important;
}
select, input {
    border-radius: 0px !important;
}
.wizard > .actions a, .wizard > .actions a:hover, .wizard > .actions a:active{
  background-color: #09f!important;
    border-color: #09f!important;
    white-space: normal;
    border-radius: 0px;
    font-size: 16px;
    padding-left: 5rem!important;
    padding-right: 5rem!important;
}
.wizard > .content{
  min-height: auto;
}
select.valid-success{
  border-color: #28a745;
}
.wizard > .steps > ul > li {
  width: 16.6%;
}
.wizard > .content > .body label.error{
  color: #dc3545;
  font-weight: normal !important;
  margin-left: 0;
}
.wizard > .content > .body input.error, .wizard > .content > .body select.error{
  background: transparent;
  border-color: #dc3545;
}
label#naissance-error {
  position: absolute;
  top: 38px;
}
label#conditiongen-error {
  position: absolute;
  top: 25px;
}
.carreGris {
  background: #f3f4f5;
  font-size: 15px;
  font-weight: bold;
}
svg.checked {
  fill: green;
}
svg.cross {
  fill: red;
}

.animated {
  -webkit-animation-duration: 2s;
  animation-duration: 2s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}
@keyframes fadeInUp {
  from {
      opacity: 0;
      -webkit-transform: translate3d(0, 100%, 0);
      transform: translate3d(0, 100%, 0);
  }
  to {
      opacity: 1;
      -webkit-transform: none;
      transform: none;
  }
}
.fadeIn {
  -webkit-animation-name: fadeInUp;
  animation-name: fadeInUp;
}
.delay2 {
  animation-delay: .5s;
}
.delay3 {
  animation-delay: 1s;
}
.delay4 {
  animation-delay: 1.5s;
}
.disabled{
  opacity: 0.5;
  pointer-events: none;
  cursor: default;
}
span.number {
    opacity: 0;
} 
.carreRose {
  background: #ff3e7a;
  font-size: 15px;
  font-weight: bold;
  color: white;
}
.carreRose p {
  font-size: 24px;
  font-weight: 500;
  text-align: center;
}
.carreRose p a {
  border: 2px solid white;
}
</style>'); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div class="modal fade" id="popup_ajout_batiment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><?= __("Ajout Nouveau Bâtiment") ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
			<div class="modal-body">      

        <input type="hidden" id="bibliotheque_id" name="bibliotheque_id" value="1">
        <div class="form-group bottom-mg">
          <label class="control-label col-sm-2" for="name"><?= __("Nom") ?> :</label>
          <div class="col-sm-10">
            <?php echo $this->Form->input('name',['id'=>'name','label'=>false,'class'=>'form-control']);  ?>
            <label id="nameLabel" style="display: none;"><span class="error_formul"> <?= __("Choix obligatoire") ?></span></label>
          </div>
        </div>
        <div class="form-group bottom-mg">
          <label class="control-label col-sm-2" for="village"><?= __("Village") ?> :</label>
          <div class="col-sm-10">
            <select name="village" class="form-control" id="id_village">
                <?php foreach($villages as $village):?>
                  <option value="<?php echo $village->id ?>" ><?php echo $village->name ?></option> 
                <?php endforeach;?>
            </select>
          </div>
        </div>
        <div class="row bottom-mg-2">
          <div class="col-md-2"><label>Position : </label></div>
          <div class="col-md-3">            
              <input id="lat" name="latitude" class="form-control" type="text" placeholder="Latitude">
              <label id="latLabel" style="display: none;"><span class="error_formul"> <?= __("Choix obligatoire") ?></span></label>
          </div>
          <div class="col-md-3">
            <input id="lng" name="longitude" class="form-control" type="text" placeholder="Longitude">
            <label id="lngLabel" style="display: none;"><span class="error_formul"> <?= __("Choix obligatoire") ?></span></label>
          </div>
          <div class="col-md-3">
            <button type="button" id="search_button" class="btn btn-warning btn-anim"><i class="fa fa-search"></i><span class="btn-text"><?= __("Chercher") ?></span></button>
          </div>
        </div>
        <div class="row">
          <!-- <input id="searchmap" class="form-control" type="text" placeholder="Chercher une adresse"  style="width: 50%; margin: 10px 0px 0px 10px; height: 38px !important;"> -->

          <div id="map-canvas" style="width: 100%; height: 400px"></div>
        </div>
        
        
			</div>
			<div class="modal-footer">
				<button class="btn btn-success hvr-sweep-to-top " id="enregisterResidence"><?= __("Enregistrer") ?></button>
			</div>
		</div>
	</div>
</div>

<!-- popupjustifdomicile -->
<div class="modal fade" id="popupjustifdomicile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" style="width:650px; max-width:700px;">
        <div class="modal-content">
            <div class="modal-header">
            <h5><?= __("Télécharger une version de votre justificatif de domicile") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>   
            </div>
            <?php echo $this->Form->create(null,["url" => $this->Url->build('/',true)."annonces/uploadjustificatifdomicile/",'id'=>'JustifdomicileForm','enctype'=>"multipart/form-data",'class'=>'JustifdomicileForm','novalidate']);?>
                <input type="hidden" name="annonce_id" value="<?php echo $annonce->id ?>">
                <div class="modal-body">
                    <div class="alert alert-danger d-none" role="alert" id="msgerrorphone">
                        <?= __("Le fichier n'a pas pu etre enregistré") ?>
                    </div>
                    <div class="col-md-12 block">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="uploadfile" name="uploadfile" accept=".pdf" aria-describedby="uploadfile" required>
                                <label class="custom-file-label" id="uploadfilelabel" for="uploadfile"><?= __("mon-justificatif-de-domicile.pdf") ?></label>
                            </div>
                        </div>
                        <div class="row mt-4 justify-content-end">
                            <div class="col-auto">
                            <button type="submit" class="btn btn-blue text-white rounded-0 px-6" id="savejustif" value="Enregistrer"><?= __("Enregistrer") ?></button>                              
                            </div>
                        </div>
                    </div>
                </div>                
            <?php echo $this->Form->end(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End popupjustifdomicile -->

<div id="informations" class="container">
 <?php // echo $this->Flash->render() ?>
<?php $annonce_id = random_int(1000000000, 2147483647); ?>
<form id="AnnonceAddForm" action="#" enctype="multipart/form-data" method="POST" style="display: none;">
    <?php echo $this->Form->input('proprietaire_id',['type'=>'hidden','value'=>$this->Session->read('Auth.User.id')])?>
    <?php echo $this->Form->input('statut',['type'=>'hidden','value'=>'0'])?>
    <?php echo $this->Form->input('id_ville',['type'=>'hidden','value'=>'1'])?>
    <?php echo $this->Form->input('code_postal',['type'=>'hidden'])?>
    <?php echo $this->Form->input('region',['type'=>'hidden'])?>
    <?php echo $this->Form->input('ville',['type'=>'hidden'])?>
    <?php echo $this->Form->input('pays_annonce',['type'=>'hidden'])?>
    <?php echo $this->Form->input('annonce_id',['type'=>'hidden','value'=>$annonce_id])?>
    <?php echo $this->Form->input('nbrimages',['type'=>'hidden'])?>

   
    <h3><?= __("Localisation et agencement") ?></h3>
    <fieldset>
        <div class="row">
            <div class="col-md-12 block"> 
                <div  class="form-row mt-4">
                    <div class="col-12 col-sm">
                        <div class="form-group">
                            <label><?= __("Station") ?> *</label>	
                            <select name="lieugeo_id" class="form-control custom-select" id="lieugeo_id" onchange="get_village(this.value)" required>
                            <option value=""><?= __("Choisir station") ?></option>
                            <?php foreach ($stations as $value) { ?>
                                <optgroup label="<?php echo $value->nom; ?>"> 
                                    <?php foreach ($value['lieugeos'] as $key) { ?>
                                        <?php if($key->id){ ?><option value="<?php echo $key->id; ?>" ><?php echo $key->name; ?></option><?php } ?>
                                    <?php } ?>
                                </optgroup>                                    
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input("village",[
                            'label'=>__('Village').' *',
                            'empty'=> __('Sélectionnez votre village'),
                            'templates' => ['inputContainer' => "{{content}}"],
                            'type'=>'select','options'=>$l_village,'class'=>'form-control custom-select','onchange'=>'get_residence(this.value)','required'])?>
                    </div>
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input("batiment",[
                        'label'=>__('Bâtiment').' *',
                        'empty'=> __('Sélectionnez votre bâtiment'),
                        'templates' => ['inputContainer' => "{{content}}"],
                        'type'=>'select','options'=>$l_residence,'class'=>'form-control custom-select','required'])?>
                    </div>
                </div>
                <div  class="form-row mt-4">
                    <div class="col-12 col-sm-4">
                        <?php echo $this->Form->input('nature',['label'=> __("Type d'hébergement")." *",'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_natures_location,'class'=>'form-control custom-select','value'=>$_SESSION['nature'],'required'])?>
                    </div>
                    <div class="col-12 col-sm-4 divetage">
                        <label for="etage"><?=  __('Étage') ?> <span class="labeletage">*</span></label>
                        <input type="text" name="etage" size="60" maxlength="255" class="form-control" required="required" id="etage">
                    </div>
                    <div class="col-12 col-sm-4 divnumapp">
                        <label for="num_app"><?=  __('Numéro d\'appartement') ?> <span class="labelnumapp">*</span></label>
                        <input type="text" name="num_app" size="60" maxlength="60" class="form-control" required="required" id="num-app">
                    </div>    
                </div>
                <div  class="form-row mt-4">
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input('exposition',['label'=>__('Exposition'),'empty'=>__('Exposition de votre hébergement'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$list_exposition,'class'=>'form-control custom-select'])?>
                    </div>
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input('vue',['label'=>__('Vue'),'empty'=>__('Vue de votre hébergement'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>['1'=>__('Vallée'),'2'=>__('Pistes'),'3'=>__('Station'),'4'=>__('Autre')],'class'=>'form-control custom-select'])?>
                    </div>
                    <div class="col-12 col-sm"></div>
                </div>                 
                <div  class="form-row mt-4">    
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input('surface',['label'=>__('Superficie').' *','placeholder'=>__('Surface de votre hébergement'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'text','value'=>'','class'=>'form-control',"autocomplete"=>"off",'required'])?>
                    </div>
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input('pieces_nb',['label'=>__('Nombre de pièces').' *','empty'=>__('Sélectionnez le nombre de pièces'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_nombre_pieces,'class'=>'form-control custom-select','required'])?>
                    </div>
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input('chambres_nb',['label'=>__('Nombre de chambres'),'empty'=>__('Sélectionnez le nombre de chambres'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_nombre_pieces,'class'=>'form-control custom-select'])?>
                    </div>
                </div>
                <div  class="form-row mt-4">    
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input('lits_nb',['templates' => ['inputContainer' => "{{content}}"],'empty'=>__('Sélectionnez le nombre de lits simples'),'type'=>'select','label'=>__('Nombre de lits simples').' *','options'=>[0=>"0",1=>'1',2=>"2",3=>"3",4=>"4",5=>"5", 6=>"6", 7=>"7", 8=>"8", 9=>"9", 10=>"10", 11=>"10+"],'class'=>'form-control custom-select','required'])?>
                    </div>
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input('personnes_nb',['templates' => ['inputContainer' => "{{content}}"],'empty'=>__('Sélectionnez le nombre de personnes'),'type'=>'select','label'=>__('Nombre de personnes (maximum)').' *','options'=>$l_nombre_personnes,'class'=>'form-control custom-select','value'=>$_SESSION['personnes_nb'],'required'])?>
                    </div>
                    <div class="col-12 col-sm">
                        <label for=""></label>
                        <div class="custom-control custom-checkbox">
                            <?php echo $this->Form->input('c_montagne_yn',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'type'=>'checkbox','class'=>'custom-control-input'])?>
                            <label class="custom-control-label" for="c-montagne-yn"><?= __('Coin montagne') ?></label>
                        </div>
                    </div>
                </div>
                <div  class="form-row mt-4">
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input('sdb_nb',['label'=>__('Nombre de salles de bain'),'empty'=>__('Sélectionnez le nombre de salles de bain'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_nombre_pieces,'class'=>'form-control custom-select'])?>
                    </div>
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input('douche_nb',['label'=>__('Nombre de douches'),'empty'=>__('Sélectionnez le nombre de douches'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_nombre_pieces,'class'=>'form-control custom-select'])?>
                    </div>
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input('baignoire_nb',['label'=>__('Nombre de baignoires'),'empty'=>__('Sélectionnez le nombre de baignoires'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_nombre_pieces,'class'=>'form-control custom-select'])?>
                    </div>
                </div>
                <div  class="form-row mt-4">
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input('wc_nb',['label'=>__('Nombre de WC'),'empty'=>__('Sélectionnez le nombre de WC'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_nombre_pieces,'class'=>'form-control custom-select'])?>
                    </div>
                    <div class="col-12 col-sm">
                        <?php echo $this->Form->input('wc_sep_nb',['label'=>__('Dont WC séparés'),'empty'=>__('Sélectionnez le nombre de WC séparés'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_nombre_pieces,'class'=>'form-control custom-select'])?>
                    </div>
                    <div class="col-12 col-sm">
                        <label class="col-12 col-sm"><?= __('Extérieurs') ?></label>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <?php echo $this->Form->input('balcon_yn',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'type'=>'checkbox','class'=>'custom-control-input'])?>
                            <label class="custom-control-label" for="balcon-yn"><?= __('Balcon') ?></label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <?php echo $this->Form->input('terasse_yn',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'type'=>'checkbox','class'=>'custom-control-input'])?>
                            <label class="custom-control-label" for="terasse-yn"><?= __('Terrasse') ?></label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <?php echo $this->Form->input('jardin_yn',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'type'=>'checkbox','class'=>'custom-control-input'])?>
                            <label class="custom-control-label" for="jardin-yn"><?= __('Jardin') ?></label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <?php echo $this->Form->input('espace_plein_air',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'type'=>'checkbox','class'=>'custom-control-input'])?>
                            <label class="custom-control-label" for="espace-plein-air"><?= __('Espace pour les repas en plein air') ?></label>
                        </div>
                    </div>
                </div>
                <div  class="form-row mt-2">
                    <div class="col-12 col-sm">
                        <legend class="col-form-label"><?= __("Ascenseur") ?></legend>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="ascenseur_yn"  <?php if($annonce->ascenseur_yn==0) echo "CHECKED"?> value="0" id="ascenseur-yn-0" class="custom-control-input">
                            <label class="custom-control-label" for="ascenseur-yn-0"><?= __('Non') ?> </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="ascenseur_yn" <?php if($annonce->ascenseur_yn==1) echo "CHECKED"?> value="1" id="ascenseur-yn-1" class="custom-control-input">
                            <label class="custom-control-label" for="ascenseur-yn-1"><?= __('Oui') ?> </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm">
                        <legend class="col-form-label"><?= __('Accès personnes à mobilité réduite') ?></legend>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="personne_reduite"  <?php if($annonce->personne_reduite==0) echo "CHECKED"?> value="0" id="personne-reduite-0" class="custom-control-input">
                            <label class="custom-control-label" for="personne-reduite-0"><?= __('Non') ?> </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="personne_reduite" <?php if($annonce->personne_reduite==1) echo "CHECKED"?> value="1" id="personne-reduite-1" class="custom-control-input">
                            <label class="custom-control-label" for="personne-reduite-1"><?= __('Oui') ?> </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm">
                        <legend class="col-form-label"><?= __("Fumeurs") ?></legend>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="non_fumeur"  <?php if($annonce->non_fumeur==0) echo "CHECKED"?> value="0" id="non-fumeur-0" class="custom-control-input">
                            <label class="custom-control-label" for="non-fumeur-0"><?= __('Acceptés') ?> </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="non_fumeur" <?php if($annonce->non_fumeur==1) echo "CHECKED"?> value="1" id="non-fumeur-1" class="custom-control-input">
                            <label class="custom-control-label" for="non-fumeur-1"><?= __('Non-Fumeur') ?> </label>
                        </div>
                    </div>
                </div>
                <div  class="form-row mt-2">
                    <div class="col-12 col-sm">
                        <legend class="col-form-label"><?= __("Stationnement") ?></legend>
                        <input type="hidden" name="stationnement" value="">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"  <?php if($annonce->stationnement==0) echo "CHECKED"?>  name="stationnement" value="0" id="stationnement-0" class="custom-control-input">
                            <label class="custom-control-label" for="stationnement-0"><?= __('Garage') ?> </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"  <?php if($annonce->stationnement==1) echo "CHECKED"?>  name="stationnement" value="1" id="stationnement-1" class="custom-control-input">
                            <label class="custom-control-label" for="stationnement-1"><?= __("Parking") ?> </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"  <?php if($annonce->stationnement==2) echo "CHECKED"?>  name="stationnement" value="2" id="stationnement-2" class="custom-control-input">
                            <label class="custom-control-label" for="stationnement-2"><?= __('à Proximité') ?> </label>
                        </div>  
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"  <?php if($annonce->stationnement==3) echo "CHECKED"?>  name="stationnement" value="3" id="stationnement-3" class="custom-control-input">
                            <label class="custom-control-label" for="stationnement-3"><?= __('Réservation sur place') ?> </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"  <?php if($annonce->stationnement==4) echo "CHECKED"?>  name="stationnement" value="4" id="stationnement-4" class="custom-control-input">
                            <label class="custom-control-label" for="stationnement-4"><?= __('Aucun') ?> </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm">
                        <legend class="col-form-label"><?= __("Animaux Acceptés") ?></legend>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="ani_co_yn"  <?php if($annonce->ani_co_yn==0) echo "CHECKED"?> value="0" id="animaux-accesptes-0" class="custom-control-input">
                            <label class="custom-control-label" for="animaux-accesptes-0"><?= __('Non') ?> </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="ani_co_yn" <?php if($annonce->ani_co_yn==1) echo "CHECKED"?> value="1" id="animaux-accesptes-1" class="custom-control-input">
                            <label class="custom-control-label" for="animaux-accesptes-1"><?= __('Oui') ?> </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm"></div>
                </div> 
        </div>
        
    </fieldset>

    <h3><?= __("Décrivez votre hébergement") ?></h3>
    <fieldset>
      <div class="row mt-4 mb-5">
        <div class="col-md-12 form-group">
          <label for="titre"><?= __('Titre de votre annonce (60 caractères maximum)') ?> *</label>
          <input type="text" id="titre" name="titre" class="form-control" maxlength="60" placeholder="<?php echo __('Donnez un titre à votre annonce...'); ?>" required>
        </div>
        <div class="form-group col-md-12">
          <label for="description"><?= __('Description de l\'annonce') ?> *</label>
          <p><?= __("Donnez envie d'en savoir plus : n'hésitez pas à vanter les mérites de votre appartement, son confort, équipement, proximité avec les lieux de commerce ou encore les richesses de la station (minimum 100 caractères, maximum 1500). Selon nos conditions générales, les adresses mail, références à d'autres sites internet ou numéros de téléphone ne sont pas acceptés ici. Merci de votre compréhension.") ?></p>
          <textarea name="description" rows="10" cols="75" minlength="100" <?php if($propdetail->nature != 'PRES') { ?> maxlength="1500" <?php } ?> class="form-control <?php if($propdetail->nature == 'PRES') echo 'summernote';?>" placeholder="<?php echo __('Décrivez votre annonce...'); ?>" id="description" required></textarea> 
          </div>
      </div>
    </fieldset>

    <h3><?= __("Sécurisez vos locations") ?></h3>
    <fieldset>
      <div  class="form-row mt-4">
        <?php 
          if($propdetail->nature == 'PRES' && !empty($propdetail->cautions)){
            $listecaution = [];
            foreach ($propdetail->cautions as $caution) {
              $listecaution[$caution->id] = $caution->name;
            }
            ?>
            <!-- <div class="col-12 col-sm">
              <label for="caution"><?=  __('Caution') ?>  *</label>
              <?php echo $this->Form->input("caution_residence",[
                'label'=>false,
                'empty'=> __('Choisir la caution'),
                'templates' => ['inputContainer' => "{{content}}"],
                'type'=>'select','options'=>$listecaution,'class'=>'form-control custom-select','required'])?>
            </div> -->
            <?php 
          }else{
          ?>
        <div class="col-12 col-sm">
          <label for="caution"><?=  __('Caution') ?> <span class="tooltipsvc" data-toggle="tooltip" data-placement="right" title="<p><?= __('La caution est une empreinte bancaire du moyen de paiement utilisé par le locataire lors de sa réservation. Il est possible de prélever le montant correspondant aux dommages jusqu’à 14 jours après le départ du locataire.') ?></p><p><?= __('Attention, le locataire doit avoir une capacité de paiement correspondant à la somme de la réservation et de la caution. Un montant trop élevé peut donc rendre plus difficile la réservation de votre hébergement.') ?></p><p><?= __('Attention, il est interdit de demander une caution en dehors du site Alpissime'); ?></p>"><i class="fa fa-question-circle-o"></i></span> *</label>
          <?php echo $this->Form->input("caution",[
              'label'=>false,
              'empty'=> __('Choisir la caution'),
              'templates' => ['inputContainer' => "{{content}}"],
              'type'=>'select','options'=>array("0" => __("Pas de caution"), "500" => "500€", "1000" => "1000€", "1500" => "1500€", "2000" => "2000€"),'class'=>'form-control custom-select','required'])?>
        </div>
        <?php } ?>
        <div class="col-12 col-sm">
          <label for="num_enregistrement"><?= __("Numéro d'immatriculation") ?> <span class="tooltipsvc" data-toggle="tooltip" data-placement="right" title="<p><?= __('Numéro d\'immatriculation à 13 chiffres pour la location saisonnière d\'un meublé de tourisme. <br>Cette identification unique, commune à toutes les plateformes, est fournie par la mairie.') ?></p>"><i class="fa fa-question-circle-o"></i></span></label>
          <input type="text" name="num_enregistrement" size="13" maxlength="13" class="form-control" id="num-enregistrement">
        </div>
        <div class="col-12 col-sm">
          <legend class="col-form-label"><?= __('Sélectionnez votre statut') ?> <span class="tooltipsvc" data-toggle="tooltip" data-placement="right" title="<p><?= __('Le décret n°2020-1585 du 14 décembre 2020 relatif aux informations obligatoires pour toute offre de location en meublé de tourisme vient préciser qu\'à compter du 1er janvier 2021, toute offre de location d\'un meublé de tourisme émanant d\'un professionnel doit porter la mention \'annonce professionnelle\'. Toute offre de location d\'un meublé de tourisme n\'émanant pas d\'un professionnel porte la mention \'annonce de particulier\'. Vous êtes considéré comme loueur professionnel lorsque les recettes annuelles retirées de l\'activité de location par l\'ensemble des membres du foyer fiscal excédent 23000€. Ces recettes excédent les revenus que le foyer fiscal tire des autres revenus soumis à l\'impôt sur le revenu (traitements et salaires, bénéfices industriels).') ?></p>"><i class="fa fa-question-circle-o"></i></span></legend>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="statut_loueur"  <?php if($annonce->statut_loueur==0) echo "CHECKED"?> value="0" id="statut-loueur-0" class="custom-control-input">
            <label class="custom-control-label" for="statut-loueur-0"><?= __('Loueur particulier') ?> </label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="statut_loueur" <?php if($annonce->statut_loueur==1) echo "CHECKED"?> value="1" id="statut-loueur-1" class="custom-control-input">
            <label class="custom-control-label" for="statut-loueur-1"><?= __('Loueur professionnel') ?> </label>
          </div>                          
        </div>
      </div>
      <div  class="form-row mt-4">    
        <div class="col-12 col-sm">
          <label for="nb_etoiles"><?= __("Classement") ?> <span class="tooltipsvc" data-toggle="tooltip" data-placement="right" title="<p><?= __('Attention, il s’agît du classement délivré par l’un des organismes certifiés, donnant lieu à une modification du calcul de la taxe de séjour. Le classement étoilé d\'une résidence de tourisme ne constitue pas un classement de l\'hébergement (qui doit être évalué de manière individuelle). Pensez à bien vérifier la certification de l’organisme délivrant (les classements locaux délivrés par les stations ne sont pas nécessairement reconnus comme classements au niveau fiscal). Chaque propriétaire est tenu de vérifier la validité de son classement et est responsable de toute erreur de collecte de la taxe de séjour découlant d’une déclaration erronée.') ?></p>"><i class="fa fa-question-circle-o"></i></span> *</label>
          <?php echo $this->Form->input('nb_etoiles',['label'=>false,'empty'=>__('Sélectionnez le classement de votre hébergement'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>[0=>"0",1=>'1',2=>"2",3=>"3",4=>"4",5=>"5"],'class'=>'form-control custom-select','required'])?>
        </div>
        <div class="col-12 col-sm"></div>
        <div class="col-12 col-sm"></div>
      </div>
      <div class="row mt-4 align-items-end">
        <div class="col-md-8">
          <label for=""><?= __("Télécharger une version de votre inventaire") ?></label>
          <div class="text-medium"><?= __("Vous avez la possibilité de télécharger une version PDF de votre inventaire qui sera envoyé à vos locataires lors de leur arrivée") ?></div>
        </div>
        <div class="col-md-4">
          <div class="custom-file">
            <input type="file" id="uploadfileinventaire" name="uploadfileinventaire" class="custom-file-input" accept=".pdf" />
            <label class="custom-file-label" for="uploadfileinventaire" id="uploadfileinventairelabel" data-browse="<?= __('Parcourir'); ?>"><?= __("mon-inventaire.pdf") ?></label>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-sm-12 viewfile">                                      
        </div>
      </div>
    </fieldset>

    <h3><?= __("Photos") ?></h3>
    <fieldset>
      <div class="row mt-3">
        <div class="col-md-6">
          <img src="<?php echo $this->Url->build('/',true) ?>images/ajax-loader.gif" id="loading-indicator" style="display:none" />            
            <div class="imageupload panel panel-default" style="background:url(<?php echo $this->Url->build("/")?>images/img-notfound.jpg) no-repeat center #e8e8e8">
              <div class="file-tab panel-body">
                <div id="formImage">
                <!-- <form id="formImagef" method="post" action="<?php echo $this->Url->build("/")?>photos/uploadnumberone"  ENCTYPE="multipart/form-data"> -->
                  <label class="btn btn-file">
                    <input type="file" name="image-file" id="imagefile">
                    <input type="hidden" name="idAnnonce" value="<?php echo $annonce_id ?>" />
                  </label>
                  <div style="display: none" class="aploadpro">
                    <select class="form-control" size="1" name="pronumber">
                      <option value="<?php echo $annonce_id ?>" selected></option>
                    </select>
                  </div>                  
                  <button type="button" id="supprimeone" class="btn" style="display:none"><i class="fa fa-trash-o mr-1"></i><?= __("Supprimer") ?></button>
                <!-- </form> -->
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-6">
          <div id="dropzone" class="h-100">
            <div class="dropzone h-100" id="my">
            <!-- <form action="<?php echo $this->Url->build("/")?>photos/uploadnew"  class="dropzone h-100" id="my"> -->
              <div class="fallback">
                <input type="file" name="file" multiple="" />
                <input type="hidden" name="idAnnonce" value="<?php echo $annonce_id ?>" />
              </div>
              <div style="display: none" class="aploadpro">
                <select id="pronumber" class="form-control" size="1" name="pronumber">
                  <option value="<?php echo $annonce_id ?>" selected></option>
                </select>
              </div>
            <!-- </form> -->
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <p><?= __("Ajoutez jusqu'à 20 images pour illustrer votre annonce (Format JPEG | Taille maximum des photos 10 MO | Les dimensions minimales pour une photo sont de 700px x 525px | Résolution minimale : 72 Pixels | Format paysage : 4:3 ou 16:9)") ?></p>
          <p class="font-weight-bold font-italic"><?= __("Attention, il est interdit de communiquer des adresses mail, références à d'autres sites internet ou numéros de téléphone dans les images.") ?></p>
        </div>
      </div> 
    </fieldset>

    <h3><?= __("Inscription") ?></h3>
    <fieldset>   
      <?php if($this->Session->read('Auth.User.id') == ""){ ?>
        <h5 class="mb-0 mt-2 py-2 px-0"><?= __("A propos de vous") ?></h5>          
        <div class="form-row mt-1 mb-4">
          <div class="col-12 col-sm">
            <?php echo $this->Form->input('nom_famille',['type'=>'text','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Votre nom').' *','required']);?>
          </div>
          <div class="col-12 col-sm">
            <?php echo $this->Form->input('prenom',['type'=>'text','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Votre prénom').' *','required']);?>
          </div>
          <div class="input-group col-12 col-sm">
            <?php //echo $this->Form->input('naissance',['type'=>'text','readonly'=>'readonly','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>'Date de naissance *','required']);?>
            <input id="naissance" name="naissance" class="form-control readonly" placeholder="Date de naissance *" required />
            <div class="input-group-append d-block">
              <div class="input-group-text"><label class="add-on mb-0" for="naissance"><i class="fa fa-calendar"></i></label></div>
            </div>
          </div>
        </div>
        <h5 class="mb-0 mt-2 py-2 px-0"><?= __("Comment les vacanciers peuvent-ils vous contacter ?") ?></h5>          
        <div class="form-row mt-1 mb-4">
          <div class="col-12 col-sm listepays">
            <?php echo $this->Form->input('pays',['type'=>'select','class'=>'form-control custom-select','label'=>false,'options'=>$Paysinscr,'required']);?>
          </div>
          <div class="col-12 col-sm">
            <input type="hidden" id="portable" name="portable" />
            <input type="text" id="num_tel" name="telephoneNum" class="form-control" required />
            <span id="error-msg" class="hide">Numéro invalide</span>
          </div>
          <div class="col-12 col-sm inscriemail">
          </div>
        </div>
        <h5 class="mb-0 mt-2 py-2 px-0"><?= __("Pour finir, définissez votre mot de passe") ?></h5>          
        <div class="form-row mt-1 mb-4">
          <div class="col-12 col-sm inscrpwd">
          </div>
          <div class="col-12 col-sm inscrpwdconfirm">
            <span id="error-msg-confirm" class="hide">55555</span>
          </div>
          <div class="col-12 col-sm"></div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-7">
            <div class="custom-control custom-checkbox mt-4">
              <input type="checkbox" class="custom-control-input" id="conditiongen" name="conditiongen" required>
              <label class="custom-control-label text-secondary text-small" for="conditiongen"><?= __("J'accepte les") ?> <a class="text-secondary" href="<?php echo BLOG_ALPISSIME?>/conditions-generales-dutilisation-alpissime-com-2/" target="blanc"><u><?= __("Conditions Générales d'Utilisations") ?></u></a> * </label>
            </div>
          </div>
          <?php
            //echo $this->InvisibleReCaptcha->render();
          ?>
          <?= $this->Recaptcha->display() ?>
        </div>
      <?php } ?>   
    </fieldset>

    <h3><?= __("Vérification") ?></h3>
    <fieldset>
      <img class="img-fluid loadingimg" style="width:20%;margin-left:35%;margin-top:10%;" src="#" data-src="<?php echo $this->Url->build('/',true).'images/loading_tampon.gif'; ?>">

      <div class="row p-3 totalrow d-none">
        <div class="col-sm-12 col-md carreGris pt-4 pb-4 px-5 mb-3 mr-3 font-weight-normal animated fadeIn">
          <svg aria-hidden="true" class="cssnbrimages" width="50" height="50" viewBox="0 0 128 128">
              
          </svg> 
          <h4 class="mt-4 mb-0"><?= __("Images") ?></h4> 
            <p class="m-0 nbrmin5"><?php echo __("C'est parfait ! Vous avez ajouté {0} images", $nbrimages); ?></p>
            <p class="m-0 nbrmin0"><?php echo __("Nous vous conseillons d’ajouter au moins 5 images à votre annonce pour obtenir plus de demandes de réservation. Attention, les annonces sans images ne pourront pas être validées.")." <a href = '".$this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/photo/".$annonce_id."' class='font-italic text-secondary nbrimagehref'><u>".__("Retourner à cette étape")."</u></a>"; ?></p> 
        </div>
        <div class="col-sm-12 col-md carreGris pt-4 pb-4 px-5 mb-3 ml-2 font-weight-normal animated fadeIn delay2">
            <svg aria-hidden="true" class="cssnbrdispo" width="50" height="50" viewBox="0 0 128 128">
                
            </svg>
            <h4 class="mt-4 mb-0"><?= __("Informations complémentaires") ?></h4> 
            <p class="m-0 nbrmin0dispo"><?php echo __("Détaillez les équipements et services pour permettre aux vacanciers d'anticiper leurs vacances chez vous. Complétez également la section Situation pour indiquer les commerces et activités à proximité.")." <a href = '".$this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/edit/".$annonce_id."' class='font-italic text-secondary nbrdispohref'><u>".__("Retourner à cette étape")."</u></a>";?></p>   
        </div>
        <div class="w-100"></div>
        <div class="col-sm-12 col-md carreGris pt-4 pb-4 px-5 mb-3 mr-3 font-weight-normal animated fadeIn delay3">
            <svg aria-hidden="true" class="cssnumenreg" width="50" height="50" viewBox="0 0 128 128">
                
            </svg>          
            <h4 class="mt-4 mb-0"><?= __("Numéro d'immatriculation") ?></h4> 
            <p class="m-0 numenregnotvid"><?php echo __("Vous avez rempli votre numéro d'immatriculation"); ?>
            <p class="m-0 numenregvid"><?php echo __("Si la commune de rattachement de votre hébergement a mis en place cette mesure, merci de bien vouloir faire une demande d'immatriculation. Ce point n’est pas bloquant pour la validation de votre annonce.")." <a href = '".$this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/edit/".$annonce_id."' class='font-italic text-secondary numenreghref'><u>".__("Retourner à cette étape")."</u></a>"; ?></p>  
        </div>
        <div class="col-sm-12 col-md carreGris pt-4 pb-4 px-5 mb-3 ml-2 font-weight-normal animated fadeIn delay4">
            <svg aria-hidden="true" class="cssjustifdom" width="50" height="50" viewBox="0 0 128 128">
                
            </svg>          
            <h4 class="mt-4 mb-0"><?= __("Justificatif de domicile") ?></h4> 
            <p class="m-0 justifdomnotvid"><?php $urljustifdomicile = "justificatifdomicile/".$annonce->justificatif_domicile; echo __("Vous avez déjà renseigné votre justificatif de domicile lors du dépôt de votre annonce").". <a href = '".$this->Url->build('/',true).$urljustifdomicile."' class='font-italic text-secondary urljustifhref' target='_blank'><u>".__("Voir mon justificatif")."</u></a> - <a href = '#' onclick='openjustifdomicile()' class='font-italic text-secondary'><u>".__("Télécharger un nouveau justificatif")."</u></a>"; ?></p>
            <p class="m-0 justifdomvid"><?php echo __("Ajoutez un justificatif de domicile concernant l’hébergement que vous déposez sur Alpissime pour prouver que vous êtes bien son propriétaire. Cette étape est obligatoire pour valider votre annonce.")." <a href = '#' onclick='openjustifdomicile()' class='font-italic text-secondary'><u>".__("Télécharger mon justificatif")."</u></a>"; ?></p>  
        </div>
        <div class="w-100"></div>
        <div class="col-sm-12 col-md carreRose pt-4 pb-4 px-5 mb-3 font-weight-normal animated fadeIn delay3">
            <p class="mt-0 mb-0 text-center"><?= __("Recevez des réservations dès maintenant,<br> renseignez vos tarifs et disponibilités.") ?></p> 
            <p><a href="" id="Depot_7" class="btn text-white rounded-0 px-5 versmonplanning"><?= __("Vers mon planning"); ?></a></p>
        </div>
      </div>
    </fieldset>  
    
</form>



<!-- Summernote Plugin JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/dist/summernote.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/lang/summernote-fr-FR.js", array('block' => 'scriptBottom')); ?>

<!-- Summernote css -->
<?php $this->Html->css("/css/summernote.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery.steps/build/jquery.steps.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
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

function openjustifdomicile(){
    $('#popupjustifdomicile').modal('show');
}

$(document).ready(function(){
  // $('a[href="#finish"]').addClass("disabled");
  $('button[href="#finish"]').addClass("d-none");
      var $imageupload = $('.imageupload');
      $imageupload.imageupload();

      $("#num_tel").inputFilter(function(value) {
        return /^\d*$/.test(value);    // Allow digits only, using a RegExp
      });

      // var telInputP = $("#num_tel");
      //   telInputP.intlTelInput({
      //     utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
      //     initialCountry: 'fr',
      //     autoPlaceholder: true
      //   });
      //   var reset = function() {
      //     telInputP.removeClass("errorNumberTel");
      //   };
      //   // on blur: validate
      //   reset();
      //   var validNum2 = "non";
      //   if ($.trim(telInputP.val())) {          
      //     if (telInputP.intlTelInput("isValidNumber")) {
      //       validNum2 = telInputP.intlTelInput("getNumber");
      //       $("#portable").val(validNum2);
      //     } else {
      //       validNum2 = "non";
      //       telInputP.addClass("errorNumberTel");
      //     }
      //   }
      
      var telInputP = $("#num_tel"),
      errorMsg2 = $("#error-msg");

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
            $("#portable").val(validNum2);
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
          
  });

  $( ".intl-tel-input.allow-dropdown" ).append( "<div class='invalid-feedback'>Veuillez entrer votre numéro de téléphone.</div>" );
//additional methods to validation              
jQuery.validator.addMethod("telInputisNumber", function(value, element, param) {
  var telInputP = $("#num_tel");
  return telInputP.intlTelInput("isValidNumber")||telInputP.val()=="";
}, "Numéro invalide");

jQuery.validator.addMethod("notAirbnbEamil", function(value, element, param) {
  var pos = $("#email").val().indexOf("@")+1;
  var val=$("#email").val().substring(pos);
  if(val.indexOf('airbnb')!== -1   ||  val.indexOf('abritel') !== -1 ||  val.indexOf('booking') !== -1){
    return false;
  }else{
    return true;
  }
}, '<?php echo __("Les emails Airbnb, Abritel et Booking ne sont pas acceptés."); ?>');

jQuery.validator.addMethod("uniqueEmail", function(value, element) {
  b=false;
  $.ajax({
    async : false,
    type: "get",
    url: "<?php echo $this->Url->build('/',true)?>/annonces/checkEmailUnique/null/"+value,
    success:function(xml){
      if (xml=='true'){b=true; }
    }
  });
  return b;
}, "<?php echo __('Cette adresse email existe déjà.'); ?>" );

jQuery.validator.addMethod("uniqueAppartement", function(value, element) {
  b=false;
  $.ajax({
    async : false,
    type: "get",
    url: "<?php echo $this->Url->build('/',true)?>/annonces/checkAppartementUnique/"+value+"/"+$("#batiment").val()+"/"+$("#nature").val(),
    success:function(xml){
      if (xml=='true'){b=true; }
    }
  });
  return b;
}, "<?php echo __('Cette appartement est lié à une annonce'); ?>" );

Dropzone.options.my = {
      // autoProcessQueue: false,
      url: "<?php echo $this->Url->build("/")?>photos/uploadnew",
      params: {
        pronumber: $("#pronumber").val()
      },
      addRemoveLinks: true,
      acceptedFiles: "image/jpeg",
      maxFilesize: 10, //MB
      maxFiles: 19,
      parallelUploads: 10,
      dictDefaultMessage: "<i class='fa fa-plus'></i><br><?php echo __("Ajouter photo"); ?>",
      init: function(){
          var thisDropzone = this;

          // $('a[href="#next"]').click(function() {
          //   thisDropzone.processQueue(); 
          // });

          
          // $.ajax({
          //     url: "<?php echo $this->Url->build("/")?>photos/getId",
          //     type: 'POST',
          //     dataType : 'json',
          //     // data: {id: <?php echo $annonce_id ?> },
          //     success: function(rest){
                  
          //         $.each(rest.tab, function(key, value){
          //             //console.log(key + ": " +rest.tab[key].id);
          //             var name = "vignette-"+<?php echo $annonce_id ?>+"-"+rest.tab[key].numero;
          //             var mockfile = {
          //                 name: name,
          //                 id: rest.tab[key].id,
          //             };
          //             thisDropzone.options.addedfile.call(thisDropzone,mockfile);
          //             thisDropzone.files.push(mockfile);
          //             thisDropzone.options.thumbnail.call(thisDropzone,mockfile,"<?php echo $this->Url->build('/',true)?>images_ann/"+<?php echo $annonce_id ?>+"/"+name+".jpg?v=<?php echo (time()*1000); ?>");
          //         });
                  
                  
          //     }
          // });
          
          
          thisDropzone.on('removedfile',function(file){
              $.ajax({
                  url: "<?php echo $this->Url->build("/")?>photos/delete",
                  type: 'POST',
                  dataType : 'json',
                  data: {id: <?php echo $annonce_id ?>, photo_id: file.id },
                  success: function(data){
                      //alert(data);
                  }
              });
              
              
          });
          
      },
      success: function(file, response){
          if(response.msg == "ok"){
              file.id = response.id;
              // file.previewElement.querySelector("[data-dz-name]").textContent = response.name;
              return file.previewElement.classList.add('dz-success');
          }else if(response.msg == "overload"){
              file.previewElement.classList.add('dz-error');
              this.defaultOptions.error(file,'<?php echo __("Pas plus de vingt images"); ?>');
          }else if(response.msg == "error"){
              file.previewElement.classList.add('dz-error');
              this.defaultOptions.error(file,'<?php echo __("Ce fichier ne peut pas être gérer"); ?>');
          }else if(response.msg == "dimension"){
              file.previewElement.classList.add('dz-error');
              this.defaultOptions.error(file,'<?php echo __("Les dimensions minimales 700 x 525"); ?>');
          }else if(response.msg == "vertical"){
              file.previewElement.classList.add('dz-error');
              this.defaultOptions.error(file,'<?php echo __("Les images au format vertical non acceptés"); ?>');
          }
      },
      
  };

if($('#AnnonceAddForm').length >0){
    var form = $("#AnnonceAddForm").show();

    form.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        forceMoveForward: true,
        labels: {
          cancel: "<?= __('Annuler') ?>",
          current: "<?= __('étape en cours:') ?>",
          pagination: "Pagination",
          finish: "<?= __('Terminer') ?>",
          next: "<?= __('Suivant') ?>",
        },
        // stepsOrientation: 1,
        titleTemplate: '<span class="number">#index#</span>',
        // onInit: function (event, currentIndex) 
        // { 

        // },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex)
            {
                // To remove error styles
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }

            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex)
        {
            nbrId = currentIndex+2;
            if(nbrId != 7) $('button[href="#next"]').attr('id','Depot_'+nbrId);
            // Used to skip the "Warning" step if the user is old enough.
            if (currentIndex === 4 && $("#proprietaire-id").val() != "")
            {
                form.steps("next");
            }
            if (currentIndex === 4 && $("#proprietaire-id").val() == "") {
              $(".inscriemail").html('<input type="email" id="email" name="email" class="form-control" size="45" maxlength="255" placeholder="<?= __("Votre adresse email")." *" ?>" required>');
              $(".inscrpwd").html('<?php echo $this->Form->input('pwd',['type'=>'password','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Votre mot de passe').' *','required']);?>');
              $(".inscrpwdconfirm").html('<?php echo $this->Form->input('pwd_confirm',['type'=>'password','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Confirmez votre mot de passe').' *','required']);?>');
            }
            

            if(currentIndex === 5){
              var myForm = document.getElementById('AnnonceAddForm');              
              formData = new FormData(myForm);
              
              $.ajax({
                type: "POST",
                url: "<?php echo $this->Url->build('/',true)?>annonces/addnewsteps/",
                data: formData,
                contentType: false,
                processData: false,
                dataType : "json",
                success: function (response) {
                    // Form fields on second step
                    if(response.annonceid != 0){
                      $("#pronumber").val(response.annonceid);
                      $("#annonce-id").val(response.annonceid);
                      $(".versmonplanning").attr("href", "<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['dispos']; ?>/view/"+response.annonceid); 
                    }
                    if(response.nbrimages != 0){
                      $("#nbrimages").val(response.nbrimages);
                    }
                    if(response.nbrimages >= 5){
                      $(".cssnbrimages").html('<use xlink:href="<?php echo $this->Url->build("/")?>images/svg/reshot-icon-cross.svg#_x35__2_"></use>');
                      $(".cssnbrimages").addClass('checked');
                      $(".cssnbrimages").removeClass('cross');
                      $(".nbrmin5").addClass('d-block');
                      $(".nbrmin0").addClass('d-none');
                    }else{
                      $(".cssnbrimages").html('<use xlink:href="<?php echo $this->Url->build("/")?>images/svg/reshot-icon-cross.svg#_x34__2_"></use>');
                      $(".cssnbrimages").addClass('cross');
                      $(".cssnbrimages").removeClass('checked');                      
                      $(".nbrimagehref").attr("href", "<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/photo/"+response.annonceid);
                      $(".nbrmin5").addClass('d-none');
                      $(".nbrmin0").addClass('d-block');
                    } 

                    // if(response.nbrdispo > 0){
                    //   $(".cssnbrdispo").html('<use xlink:href="<?php echo $this->Url->build("/")?>images/svg/reshot-icon-cross.svg#_x35__2_"></use>');
                    //   $(".cssnbrdispo").addClass('checked');
                    //   $(".cssnbrdispo").removeClass('cross');
                    //   $(".nbrmindispo").addClass('d-block');
                    //   $(".nbrmin0dispo").addClass('d-none');
                    // }else{
                      $(".cssnbrdispo").html('<use xlink:href="<?php echo $this->Url->build("/")?>images/svg/reshot-icon-cross.svg#_x34__2_"></use>');
                      $(".cssnbrdispo").addClass('cross');
                      $(".cssnbrdispo").removeClass('checked');
                      $(".nbrdispohref").attr("href", "<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/edit/"+response.annonceid);
                      $(".nbrmindispo").addClass('d-none');
                      $(".nbrmin0dispo").addClass('d-block');
                    // }

                    if(response.numenregistrement != "" && response.numenregistrement != null){
                      $(".cssnumenreg").html('<use xlink:href="<?php echo $this->Url->build("/")?>images/svg/reshot-icon-cross.svg#_x35__2_"></use>');
                      $(".cssnumenreg").addClass('checked');
                      $(".cssnumenreg").removeClass('cross');
                      $(".numenregnotvid").addClass('d-block');
                      $(".numenregvid").addClass('d-none');
                    }else{
                      $(".cssnumenreg").html('<use xlink:href="<?php echo $this->Url->build("/")?>images/svg/reshot-icon-cross.svg#_x34__2_"></use>');
                      $(".cssnumenreg").addClass('cross');
                      $(".cssnumenreg").removeClass('checked');
                      $(".numenreghref").attr("href", "<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/edit/"+response.annonceid);
                      $(".numenregnotvid").addClass('d-none');
                      $(".numenregvid").addClass('d-block');
                    }

                    if(response.justifdomicile != "" && response.justifdomicile != null){
                      $(".cssjustifdom").html('<use xlink:href="<?php echo $this->Url->build("/")?>images/svg/reshot-icon-cross.svg#_x35__2_"></use>');
                      $(".cssjustifdom").addClass('checked');
                      $(".cssjustifdom").removeClass('cross');
                      $(".justifdomnotvid").addClass('d-block');
                      $(".justifdomvid").addClass('d-none');
                    }else{
                      $(".cssjustifdom").html('<use xlink:href="<?php echo $this->Url->build("/")?>images/svg/reshot-icon-cross.svg#_x34__2_"></use>');
                      $(".cssjustifdom").addClass('cross');
                      $(".cssjustifdom").removeClass('checked');                      
                      $(".urljustifhref").attr("href", "<?php echo $this->Url->build('/',true); ?>/justificatifdomicile/"+response.justifdomicile);
                      $(".justifdomnotvid").addClass('d-none');
                      $(".justifdomvid").addClass('d-block');
                    }

                    
                    $(".loadingimg").addClass("d-none");
                    $('button[href="#finish"]').removeClass("disabled");
                    $(".totalrow").removeClass("d-none");
                    $(".totalrow").addClass("d-flex");
                },
                error: function (dataerror) {
                    console.log(dataerror);
                    alert("something went wrong");
                    // return false; //this will prevent to go to next step
                }
              });
              
            }
            

            // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
            // if (currentIndex === 2 && priorIndex === 3)
            // {
            //     form.steps("previous");
            // }
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
          // my.processQueue();  
          // var myDropzone = Dropzone.forElement(".dropzone");
          // myDropzone.processQueue();
          setTimeout(function(){ 
            document.getElementById("AnnonceAddForm").submit();
          }, 2000);
          
        }
    }).validate({
      // validClass: "valid-success",
      errorPlacement: function errorPlacement(error, element) {
          if (element.attr("name") == "portable" ) {
              error.insertAfter("#error-msg");
            }else if (element.attr("name") == "pwd_confirm"){
              error.insertAfter("#error-msg-confirm");
            }else{
              element.after( error );
            }    
      },
      rules: {
        num_app: {
          uniqueAppartement:true,
        },
        email: {
          notAirbnbEamil:true,
          uniqueEmail:true,
        },
        portable:{
            required:true,
            telInputisNumber:true,
        },
        pwd_confirm: {
            equalTo: "#pwd"
        }
      },
      messages: {
        pwd_confirm:{
            equalTo:"<?php echo __("Veuillez confirmer votre mot de passe."); ?>",
        }
      },
      invalidHandler: function(form, validator) {
        if (!validator.numberOfInvalids())
            return;

        $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top - 50
        }, 1000);

        }
    });

    $('button[href="#next"]').attr('id','Depot_2'); 
}

$('#nature').change(function () {
    if($(this).val() == 'APP' || $(this).val() == 'STD'){
      $("#etage").prop('required',true);
      $(".labeletage").html("*");
      $(".divetage").css("display", "block");
      $("#num-app").prop('required',true);
      $(".labelnumapp").html("*");
      $(".divnumapp").css("display", "block");
    }else{
      $("#etage").prop('required',false);
      $("#etage").val('');
      $(".labeletage").html("");
      $(".divetage").css("display", "none");
      $("#num-app").prop('required',false);
      $("#num-app").val('');
      $(".labelnumapp").html("");
      $(".divnumapp").css("display", "none");
    }
});

  var summernoteElement = $('.summernote');
  summernoteElement.summernote({
        height: 300,
        lang:"fr-FR",
        fontNames: ["Times New Roman","Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New"],
        fontNamesIgnoreCheck: ["Times New Roman","Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New"],
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontname',['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['picture',['picture']],
            ['link',['linkDialogShow', 'unlink']],
            ['fullscreen',['fullscreen']],
            ['codeview',['codeview']],
            ['undo',['undo']],
            ['redo',['redo']],
        ],
        callbacks: {
            onChange: function (contents, $editable) {
                // Note that at this point, the value of the `textarea` is not the same as the one
                // you entered into the summernote editor, so you have to set it yourself to make
                // the validation consistent and in sync with the value.
                summernoteElement.val(summernoteElement.summernote('isEmpty') ? "" : contents);

                // You should re-validate your element after change, because the plugin will have
                // no way to know that the value of your `textarea` has been changed if the change
                // was done programmatically.
                // summernoteValidator.element(summernoteElement);
            }
        }
  });
$('.serv').click(function(){

    if($(this).is(':checked'))
        { 
         $(this).parent().find('.list-option').css('display','block');
         $(this).parent().find('.list-option').find(':input').attr('disabled',false);

        }else{
      $(this).parent().find('.list-option').css('display','none');
      $(this).parent().find('.list-option').find(':input').attr('disabled',true);
        }
});
                    
var map = new google.maps.Map(document.getElementById('map-canvas'),{
        disableDoubleClickZoom: true,
        styles:[
    {
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#f5f5f5"
        }
      ]
    },
    {
      "elementType": "labels.icon",
      "stylers": [
        {
          "visibility": "off"
        }
      ]
    },
    {
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#616161"
        }
      ]
    },
    {
      "elementType": "labels.text.stroke",
      "stylers": [
        {
          "color": "#f5f5f5"
        }
      ]
    },
    {
      "featureType": "administrative.land_parcel",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#bdbdbd"
        }
      ]
    },
    {
      "featureType": "poi",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#eeeeee"
        }
      ]
    },
    {
      "featureType": "poi",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#757575"
        }
      ]
    },
    {
      "featureType": "poi.park",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#e5e5e5"
        }
      ]
    },
    {
      "featureType": "poi.park",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#9e9e9e"
        }
      ]
    },
    {
      "featureType": "road",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#ffffff"
        }
      ]
    },
    {
      "featureType": "road.arterial",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#757575"
        }
      ]
    },
    {
      "featureType": "road.highway",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#dadada"
        }
      ]
    },
    {
      "featureType": "road.highway",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#616161"
        }
      ]
    },
    {
      "featureType": "road.local",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#9e9e9e"
        }
      ]
    },
    {
      "featureType": "transit.line",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#e5e5e5"
        }
      ]
    },
    {
      "featureType": "transit.station",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#eeeeee"
        }
      ]
    },
    {
      "featureType": "water",
      "stylers": [
        {
          "color": "#3cacff"
        },
        {
          "visibility": "on"
        }
      ]
    },
    {
      "featureType": "water",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#c9c9c9"
        }
      ]
    },
    {
      "featureType": "water",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#9e9e9e"
        }
      ]
    }
  ],
            center :{
                lat: 46.734255,
                lng: 2.418815
            },
            zoom:6,
        });

        // var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));

        // var input = document.getElementById('searchmap');
        
        // var searchBox = new google.maps.places.SearchBox(input);
        // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);



        var marker = new google.maps.Marker({
            position: {
                lat: 46.734255,
                lng: 2.418815
            },
            map :map,
            draggable: true
        });

        // google.maps.event.addListener(searchBox,'places_changed',function () {
        //     var places = searchBox.getPlaces();
        //     var bounds = new google.maps.LatLngBounds();
        //     var i,place;

        //     for(i=0;place=places[i];i++){
        //         bounds.extend(place.geometry.location);
        //         marker.setPosition(place.geometry.location);
        //     }

        //     map.fitBounds(bounds);
        //     map.setZoom(15);
        // });
        function findcords() {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();
            $('#lat').val(lat);     
            $('#lng').val(lng);
        };
        google.maps.event.addListener(map,'idle',function () {
            findcords();
        });
        
        google.maps.event.addListener(map, 'dblclick', function(e) {
        var positionDoubleclick = e.latLng;
        marker.setPosition(positionDoubleclick);
        findcords();
        });

        google.maps.event.addListener(marker,'dragend',function () {
            findcords();
        });
        
        $('#search_button').click(function(){
            var latlng = new google.maps.LatLng($('#lat').val(), $('#lng').val());
            marker.setPosition(latlng);
            map.setCenter(latlng);
        });   

$("#lieugeo_id").change(function() { 
  $.ajax({
    type: "POST",
    url: "<?php echo $this->Url->build('/',true)?>annonces/setcenrlatlong/"+this.value,
    dataType : 'json',
    success:function(data){
      latInfo = data.latInfo;
      longInfo = data.longInfo;
      zoomInfo = 11;
      
      map.setCenter({
        lat : parseFloat(latInfo),
        lng : parseFloat(longInfo)
      });
      map.setZoom(zoomInfo);
      marker.setPosition({
        lat : parseFloat(latInfo),
        lng : parseFloat(longInfo)
      });
    }
  });
});

$("#lieugeo-id").change(function() { 
  $.ajax({
    type: "POST",
    url: "<?php echo $this->Url->build('/',true)?>annonces/setcenrlatlong/"+this.value,
    dataType : 'json',
    success:function(data){
      latInfo = data.latInfo;
      longInfo = data.longInfo;
      zoomInfo = 11;
      
      map.setCenter({
        lat : parseFloat(latInfo),
        lng : parseFloat(longInfo)
      });
      map.setZoom(zoomInfo);
      marker.setPosition({
        lat : parseFloat(latInfo),
        lng : parseFloat(longInfo)
      });
    }
  });
});
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
(function($) {
  var Defaults = $.fn.select2.amd.require('select2/defaults');
  $.extend(Defaults.defaults, {
      searchInputPlaceholder: ''
  });
  var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');
  var _renderSearchDropdown = SearchDropdown.prototype.render;
  SearchDropdown.prototype.render = function(decorated) {
      // invoke parent method
      var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));
      this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));
      return $rendered;
  };
})(window.jQuery);

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('AnnonceAddForm');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
          var errorElements = document.querySelectorAll(".form-control:invalid");          
          $('html, body').animate({
            scrollTop: $(errorElements[0]).offset().top - 50
          }, 2000);
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

jQuery(document).ready(function() {
  $(".tooltipsvc").tooltip({
    html: true
    });  
        $('#batiment').select2({  
          searchInputPlaceholder: '<?= __("Entrez le nom complet de votre bâtiment") ?>',       
          language: {
            noResults: function() {
              $("#name").val($(".select2-search__field").val());
              return "<?= __('Vous ne trouvez pas votre bâtiment ! Ajouter le'); ?> : <button id='no-results-btn' onclick='noResultsButtonClicked()' class='btn-blue text-white rounded-0'> <?= __('Ajouter'); ?> </button>";
            },
          },
          escapeMarkup: function(markup) {
            return markup;
          }
        });

  var fileTypes = ['jpg', 'jpeg', 'png', 'pdf'];  //acceptable file types
	$("input:file").change(function (evt) {
	    var parentEl = $(this).parent();
	    var tgt = evt.target || window.event.srcElement,
	                    files = tgt.files;

	    // FileReader support
	    if (FileReader && files && files.length) {
	        var fr = new FileReader();
	        var extension = files[0].name.split('.').pop().toLowerCase(); 
	        fr.onload = function (e) {
	        	success = fileTypes.indexOf(extension) > -1;
	        	if(success)
		        	// $(parentEl).append('<img src="' + fr.result + '" class="preview"/>');
              $(".viewfile").html('<object data="'+fr.result+'" type="application/pdf" width="100%" height="500"> <?= __("Lien Pièce jointe") ?></object>');
	        }
	        fr.onloadend = function(e){
	            console.debug("Load End");
	        }
          fr.readAsDataURL(files[0]);
          $("#uploadfileinventairelabel").html(files[0].name);
	    }   
	});

});

$('body').on('keyup', '.select2-search__field', function() {
  if($(".select2-search__field").val().length >= 2 && !$(".select2-results__message").length){
    $("#name").val($(".select2-search__field").val());
    $(".select2-results__options").append("<li class='select2-results__option select2-results__message'><?= __('Vous ne trouvez pas votre bâtiment ! Ajouter le'); ?> : <button id='no-results-btn' onclick='noResultsButtonClicked()' class='btn-blue text-white rounded-0'> <?= __('Ajouter'); ?> </button></li>");
  }
});

function noResultsButtonClicked(){
  $("#batiment").select2("close");
  $("#id_village").val($("#village").val());
  $('#popup_ajout_batiment').modal('show');
}
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
function get_village(id){
  if(id!='')
    {
      $('#village').empty().prop('disabled', true);
      $('#id_village').empty();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Url->build('/',true)?>manager/village/getStationVillages/"+id,
            dataType : 'json',
            success:function(data){
              $('#village').append('<option value=""><?php echo __("Sélectionnez votre village")?></option>');
              $('#id_village').append('<option value=""><?php echo __("Sélectionnez votre village")?></option>');
              if(Object.keys(data).length == 1) selectedval = "selected";
              else selectedval = "";
              $.each(data,function(i,val){
                $('#village').append('<option value=' + i + ' ' + selectedval + '>' + val + '</option>');
                $('#id_village').append('<option value=' + i + ' ' + selectedval + '>' + val + '</option>');
              })
            },
            complete:function(){
              $('#village').prop('disabled', false).trigger('change');
            }
        });
    }else{
      $("#village").val("");
      $('#village').prop('disabled', true);
      $("#batiment").empty();
      $('#batiment').prop('disabled', true);
    }
}

var cookielieugeos = "<?php echo $_SESSION['lieugeo_id']; ?>";
if(cookielieugeos){
  $("#lieugeo_id").val(cookielieugeos);
  get_village(cookielieugeos);
}

function get_residence(id)
{
$('#uniform-batiment span').html("");
   $('#batiment option[value!=""]').remove();
    if(id!='')
    {

        $.ajax({
            type: "POST",
            url: "<?php echo $this->Url->build('/',true)?>annonces/getresidence",
            dataType : 'json',
            data: {id_vil : id},
            success:function(xml){
                data = xml.listeresidences;
                $('#batiment').empty();
                for (var i = 0; i < data.length; i++) {
                    $('#batiment').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
                }
            },
            complete:function(){
              $('#batiment').prop('disabled', false).trigger('change');
            }
        });
      
      // remplir champs hidden pays, ville, code_postal et region
      $.ajax({
        type: "POST",
        url: "<?php echo $this->Url->build('/',true)?>annonces/getvillefromvillage",
        dataType : 'json',
        data: {id_vil : id},
        success:function(xml){
            $("#code-postal").val(xml.code_postal_val);
            $("#region").val(xml.region_val);
            $("#ville").val(xml.ville_val);
            $("#pays-annonce").val(xml.pays_val);
        }
      });
    }else{
      $('#batiment').prop('disabled', true);
    }
}

$("#enregisterResidence").click(function(){
  if($("#name").val() === ''){
    document.getElementById("nameLabel").style.display = 'block';
    document.getElementById("latLabel").style.display = 'none';
    document.getElementById("lngLabel").style.display = 'none';
  }else if($("#lat").val() === ''){
    document.getElementById("latLabel").style.display = 'block';
    document.getElementById("lngLabel").style.display = 'none';
    document.getElementById("nameLabel").style.display = 'none';
  }else if($("#lng").val() === ''){
    document.getElementById("lngLabel").style.display = 'block';
    document.getElementById("latLabel").style.display = 'none';
    document.getElementById("nameLabel").style.display = 'none';
  }else{
    $.ajax({
      type: "POST",
      url: "<?php echo $this->Url->build('/',true)?>manager/gps/addajax",
      dataType : 'json',
      data: {name : $("#name").val(), latitude: $("#lat").val(), longitude: $("#lng").val(), id_village: $("#id_village").val(), bibliotheque_id: $("#bibliotheque_id").val()},
      success:function(xml){
        residenceact = xml.residence_id;
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Url->build('/',true)?>annonces/getresidence",
            dataType : 'json',
            data: {id_vil : $("#village").val()},
            success:function(xml){
                data = xml.listeresidences;
                $('#batiment').empty();
                for (var i = 0; i < data.length; i++) {
                    $('#batiment').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
                }
                $('#batiment').val(residenceact);
            }
        });
        $('#popup_ajout_batiment').modal('hide');
      }
    });
    
  }
});

if($("#lieugeo_id").val() == ""){
  $('#village').prop('disabled', true);
  $('#batiment').prop('disabled', true);
}else{
  if($("#village").val() == "") $('#batiment').prop('disabled', true);
}

<?php $this->Html->scriptEnd(); ?>

<!-- javascript PHOTO -->
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
function resetFileTab($fileTab) {
    $fileTab.find('.alert').remove();
    $fileTab.find('img').remove();
    $fileTab.find('.btn span').text('Choisir la première image');
    $fileTab.find('input').val('');
    //$("#supprimeone").css('display', 'none');
}

  function getImageThumbnailHtml(src) {
    // var form = $('#formImagef').get(0);
    var formData = new FormData();
    formData.append('pronumber', $("#pronumber").val());
    formData.append('image-file', $("#imagefile")[0].files[0], $("#imagefile")[0].files[0].name);
    var img = "";
    $.ajax({
        url: "<?php echo $this->Url->build("/")?>photos/uploadnumberone",
        type: 'POST',
        //async: false,
        dataType : 'json',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data){
          $('#loading-indicator').hide();
            $(".imageupload.panel.panel-default").find('.file-tab').find('img').css('display', 'none');
            //$("#supprimeone").css('display', 'inline-block');
          //  $( '<img id="imagepreview" src="' + src + '" alt="Image preview" class="thumbnail" style="width: 180px; height: 130px">' ).insertBefore( $( "#formImage" ) );
          $(".imageupload").css("background", "url(" + src + ") no-repeat");
          $(".imageupload").css("background-size", "cover");
          $("#supprimeone").css('display', 'block');
        }
    });
  }

  $("#supprimeone").on('click', function() {
      $.ajax({
          url: "<?php echo $this->Url->build("/")?>photos/deletefirst",
          type: 'POST',
          dataType : 'json',
          data: {id: $("#pronumber").val() },
          success: function(data){
              resetFileTab($(".imageupload.panel.panel-default").find('.file-tab'));
              $("#supprimeone").css('display', 'none');
              $(".imageupload").css("background", "url(<?php echo $this->Url->build("/")?>images/img-notfound.jpg) no-repeat center #e8e8e8");
          }
      });

  });

        // Do this outside of jQuery

  

  $( "#pays" ).change(function() {  
    var monTableauJS = <?php echo json_encode($paysNum) ?>;
    $("#num_tel").intlTelInput("setCountry", monTableauJS[$(this).val()]);
    $("#num_tel").val('');
    $("#num_tel").intlTelInput("setCountry", monTableauJS[$(this).val()]);
    $("#num_tel").val('');
  });
                        

  
  $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);
  $('#naissance').datepicker({
    language: 'fr-FR',
    changeMonth: true,
    changeYear: true,
    yearRange :"-100:+0",
    dateFormat: 'dd/mm/yy'
  });
<?php $this->Html->scriptEnd(); ?>