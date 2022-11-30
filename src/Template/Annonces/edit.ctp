
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
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

  $(".menu_annon").css('display','block');
  

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
          $("#uploadfilelabel").html(files[0].name);
	    }   
	});

});
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
function get_village(id){
  if(id!='')
    {
      $('#village').empty().prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Url->build('/',true)?>manager/village/getStationVillages/"+id,
            dataType : 'json',
            success:function(data){
              $('#village').append('<option value=""><?php echo __("Sélectionnez votre village")?></option>');
              $.each(data,function(i,val){
                $('#village').append('<option value=' + i + '>' + val + '</option>');
              })
            },
            complete:function(){
              $('#village').prop('disabled', false).trigger('change');
            }
        });
    }
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
            }
        });

      // remplir champs hidden pays, ville, code_postal et region
      $.ajax({
        type: "POST",
        url: "<?php echo $this->Url->build('/',true)?>annonces/getvillefromvillage",
        dataType : 'json',
        data: {id_vil : id},
        success:function(xml){
            console.log(xml);
            $("#code-postal").val(xml.code_postal_val);
            $("#region").val(xml.region_val);
            $("#ville").val(xml.ville_val);
            $("#pays").val(xml.pays_val);
        }
      });
    }
}
var residenel = "<?php echo $l_residence; ?>";
if(residenel == "") get_residence($("#village").val());
<?php $this->Html->scriptEnd(); ?>

<div id="informations" class="container">
 <?php echo $this->Flash->render() ?>

 <?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div class="row bg-light no-gutters mb-4 mt-n3" >
  <div class="col-sm-6 col-lg-3 list-steps">
    <span class="d-block text-center ann-step active-steps">1. <?= __("Informations") ?></span>
  </div>
  <div class="col-sm-6 col-lg-3 list-steps">
    <a href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/photo/<?php echo $annonce_id ?>'><span class="d-block text-center ann-step after-active-steps">2. <?= __("Images") ?></span></a>
  </div>
  <div class="col-sm-6 col-lg-3 list-steps">
    <a  href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['dispos']; ?>/view/<?php echo $annonce->id ?>'><span class="d-block text-center ann-step">3. <?= __("Tarification") ?></span></a>
  </div>
  <div class="col-sm-6 col-lg-3 list-steps">
    <a  href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/".$urlvaluemulti['previsualiser']; ?>/<?php echo $annonce->id ?>'><span class="d-block text-center text-lg-right text-xl-center ann-step">4. <?= __("Prévisualisation") ?></span></a>
  </div>
</div><!-- end row -->
      <div class="row">
        <div class="col-md-12">
          <div class="header_title bg-light">
            <h5 class="mb-2 mt-2 py-2 px-3"><?= __("Localisation et accès") ?></h5>
          </div><!-- header_title-->
        </div> <!--end col-md-12-->
      </div> <!--end row-->

        <?php echo $this->Form->create($annonce,['id'=>'AnnonceAddForm','enctype'=>"multipart/form-data",'class'=>'AnnonceAddForm','novalidate'],['url' => ['controller' => 'Annonces', 'action' => 'edit']]);?>
        <?php echo $this->Form->input("statut",['type'=>'hidden','value'=>$annonce->statut]);?>
        <?php echo $this->Form->input("id",['type'=>'hidden','value'=>$annonce->id]);?>
        <?php echo $this->Form->input('code_postal',['type'=>'hidden','value'=>$annonce->code_postal])?>
        <?php echo $this->Form->input('region',['type'=>'hidden','value'=>$annonce->region])?>
        <?php echo $this->Form->input('ville',['type'=>'hidden','value'=>$annonce->ville])?>
        <?php echo $this->Form->input('pays',['type'=>'hidden','value'=>$annonce->pays])?>



<div class="row">
  <div class="col-md-12">
        <label for=""><?= __("Statut de votre annonce") ?> :</label>
        <?php  if($this->Session->read('Auth.User.id')!=""){?><?= __("Annonce") ?> <?php echo $l_annoncesstatuts[$annonce->statut];?>
          <?php }else{?>
              <?php echo $this->Form->input('statut',[
                    'label'=>'',
                    'templates' => ['inputContainer' => "{{content}}"],
                    'type'=>'select','options'=>$l_annoncesstatuts,'class'=>'form-control']);?>
          <?php }?>
      </div><!-- end col-md-12-->
  </div><!--end form-group col-md-12-->
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
                      <?php if($key->id){ ?><option value="<?php echo $key->id; ?>" <?php if($annonce->lieugeo_id == $key->id) echo "selected"?>><?php echo $key->name; ?></option><?php } ?>
                  <?php } ?>
            </optgroup>                                    
          <?php } ?>
        </select>
        <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>
      </div>                     
    </div>
    <div class="col-12 col-sm">
                  <?php echo $this->Form->input("village",[
                     'label'=>__('Village').' *',
                     'empty'=> __('Sélectionnez votre village'),
                     'templates' => ['inputContainer' => "{{content}}"],
                     'type'=>'select','options'=>$l_village,'class'=>'form-control custom-select','onchange'=>'get_residence(this.value)','required'])?>
                     <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>
    </div>
    <div class="col-12 col-sm">
        <?php echo $this->Form->input("batiment",[
           'label'=>__('Bâtiment').' *',
           'empty'=> __('Sélectionnez votre bâtiment'),
           'templates' => ['inputContainer' => "{{content}}"],
           'type'=>'select','options'=>$l_residence,'class'=>'form-control custom-select','required'])?>
           <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>
    </div>
  </div><!--form-row-->
  <div  class="form-row mt-4">
    <div class="col-12 col-sm-4">
      <?php echo $this->Form->input('nature',['label'=> __("Type d'hébergement")." *",'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_natures_location,'class'=>'form-control custom-select','required'])?>
      <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>  
    </div>
    <div class="col-12 col-sm-4 divetage">
    <label for="etage"><?=  __('Étage') ?> <span class="labeletage">*</span></label>
      <input type="text" name="etage" size="60" maxlength="255" class="form-control" required="required" id="etage" value="<?php echo $annonce->etage;?>">
      <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>
    </div>
    <div class="col-12 col-sm-4 divnumapp">
    <label for="num_app"><?=  __('Numéro d\'appartement') ?> <span class="labelnumapp">*</span></label>
      <input type="text" name="num_app" size="60" maxlength="60" class="form-control" required="required" id="num-app" value="<?php echo $annonce->num_app;?>">
      <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>
    </div>
    
  </div>
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
           <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>                          
      </div> -->
      <?php 
    }else{
    ?>
    <div class="col-12 col-sm">
      <label for="caution"><?= __('Caution') ?> <span class="tooltipsvc" data-toggle="tooltip" data-placement="right" title="<p><?= __('La caution est une empreinte bancaire du moyen de paiement utilisé par le locataire lors de sa réservation. Il est possible de prélever le montant correspondant aux dommages jusqu’à 14 jours après le départ du locataire.</p><p>Attention, le locataire doit avoir une capacité de paiement correspondant à la somme de la réservation et de la caution. Un montant trop élevé peut donc rendre plus difficile la réservation de votre hébergement.') ?></p><p><?= __('Attention, il est interdit de demander une caution en dehors du site Alpissime'); ?></p>"><i class="fa fa-question-circle-o"></i></span> *</label>
      <?php echo $this->Form->input("caution",[
           'label'=>false,
           'empty'=> __('Choisir la caution'),
           'templates' => ['inputContainer' => "{{content}}"],
           'type'=>'select','options'=>array("0" => __("Pas de caution"), "500" => "500€", "1000" => "1000€", "1500" => "1500€", "2000" => "2000€"),'class'=>'form-control custom-select','required'])?>
           <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>                               
    </div>
    <?php } ?>
    <div class="col-12 col-sm">
      <label for="num_enregistrement"><?= __("Numéro d'immatriculation") ?> <span class="tooltipsvc" data-toggle="tooltip" data-placement="right" title="<p><?= __('Numéro d\'immatriculation à 13 chiffres pour la location saisonnière d\'un meublé de tourisme. <br>Cette identification unique, commune à toutes les plateformes, est fournie par la mairie.') ?></p>"><i class="fa fa-question-circle-o"></i></span></label>
      <input type="text" name="num_enregistrement" size="13" maxlength="13" class="form-control" id="num-enregistrement"  value="<?php echo $annonce->num_enregistrement;?>">
      <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>                          
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
  <div class="form-row mt-4">
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
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="header_title bg-light">
        <h5 class="mb-2 mt-2 py-2 px-3"><?= __('A propos de votre hébergement') ?></h5>
      </div><!-- header_title-->
    </div> <!--end col-md-12-->
  </div> <!--end row-->
  <div  class="form-row mt-4">    
    <div class="col-12 col-sm">
    <?php echo $this->Form->input('exposition',['label'=>__('Exposition'),'empty'=>__('Exposition de votre hébergement'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$list_exposition,'class'=>'form-control custom-select'])?>
    </div>
    <div class="col-12 col-sm">
    <?php echo $this->Form->input('vue',['label'=>__('Vue'),'empty'=>__('Vue de votre hébergement'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>['1'=>__('Vallée'),'2'=>__('Pistes'),'3'=>__('Station'),'4'=>__('Autre')],'class'=>'form-control custom-select'])?>
    </div>
    <div class="col-12 col-sm">
    <?php echo $this->Form->input('pieces_nb',['label'=>__('Nombre de pièces').' *','empty'=>__('Sélectionnez le nombre de pièces'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_nombre_pieces,'class'=>'form-control custom-select','required'])?>
    <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>  
    </div>
  </div>
  <div  class="form-row mt-4">    
    <div class="col-12 col-sm">
    <?php echo $this->Form->input('surface',['label'=>__('Superficie').' *','placeholder'=>__('Surface de votre hébergement'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'text','class'=>'form-control','required'])?>
    <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>
    </div>
    <div class="col-12 col-sm">
    <label for="nb_etoiles"><?= __("Classement") ?> <span class="tooltipsvc" data-toggle="tooltip" data-placement="right" title="<p><?= __('Attention, il s’agît du classement délivré par l’un des organismes certifiés, donnant lieu à une modification du calcul de la taxe de séjour. Le classement étoilé d\'une résidence de tourisme ne constitue pas un classement de l\'hébergement (qui doit être évalué de manière individuelle). Pensez à bien vérifier la certification de l’organisme délivrant (les classements locaux délivrés par les stations ne sont pas nécessairement reconnus comme classements au niveau fiscal). Chaque propriétaire est tenu de vérifier la validité de son classement et est responsable de toute erreur de collecte de la taxe de séjour découlant d’une déclaration erronée.') ?></p>"><i class="fa fa-question-circle-o"></i></span> </label>
    <?php echo $this->Form->input('nb_etoiles',['label'=>false,'empty'=>__('Sélectionnez le classement de votre hébergement'),'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>[0=>"0",1=>'1',2=>"2",3=>"3",4=>"4",5=>"5"],'class'=>'form-control custom-select'])?>
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
    <?php echo $this->Form->input('personnes_nb',['templates' => ['inputContainer' => "{{content}}"],'empty'=>__('Sélectionnez le nombre de personnes'),'type'=>'select','label'=>__('Nombre de personnes (maximum)').' *','options'=>$l_nombre_personnes,'class'=>'form-control custom-select','required'])?>
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
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="header_title bg-light">
        <h5 class="mb-2 mt-2 py-2 px-3"><?= __('Services et équipement') ?></h5>
      </div><!-- header_title-->
    </div> <!--end col-md-12-->
  </div> <!--end row-->

  <div  class="form-row mt-4">
  <legend class="col-form-label"><?= __('Électroménager') ?></legend>
  <div class="col">
    <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('lave_linge',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="lave-linge"><?= __("Lave-linge") ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('seche_linge',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="seche-linge"><?= __("Sèche-linge") ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('Radiateur_seche',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="radiateur-seche"><?= __("Radiateur sèche-serviettes") ?></label>
    </div>
  </div>
  <div class="col">
    <div class="custom-control custom-checkbox custom-control">
    <?php if($annonce->refrigerateur_top || $annonce->refrigerateur_comp|| $annonce->refrigerateur_sup){
      echo $this->Form->input('refrigerateur',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox','checked']);
      }else{
        echo $this->Form->input('refrigerateur',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);
      }?>
      <?php ?>
      <label class="custom-control-label" for="refrigerateur"><?= __("Réfrigerateur") ?></label>
      <div class="list-option ml-3" style="<?php if(!$annonce->refrigerateur_top && !$annonce->refrigerateur_comp&& !$annonce->refrigerateur_sup){?>display:none;<?php }?>" >
        <div class="custom-control custom-checkbox custom-control-inline">
        <?php echo $this->Form->input('refrigerateur_top',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="refrigerateur-top"><?= __('Table Top 140 Litres') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control-inline">
        <?php echo $this->Form->input('refrigerateur_comp',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="refrigerateur-comp"><?= __('Table Top et Compartiment Congélateur') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control-inline">
        <?php echo $this->Form->input('refrigerateur_sup',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="refrigerateur-sup"><?= __('Supérieur à 140 litres') ?></label>
        </div>
      </div>
    </div>
    <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('micro_onde',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="micro-onde"><?= __("Micro-ondes") ?></label>
      <div class="list-option ml-3" style="<?php if(!$annonce->multi_fonction){?>display:none;<?php }?>" >
        <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('multi_fonction',['templates' => ['inputContainer' => "{{content}}"],'label'=>False,'class'=>"custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="multi-fonction"><?= __("Multi-fonctions") ?></label>
        </div>
      </div>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php if($annonce->four || $annonce->four_mini){ 
      echo $this->Form->input('four_existe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox', 'checked']); 
    }else{
      echo $this->Form->input('four_existe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);
    } ?>
      <?php ?>
      <label class="custom-control-label" for="four-existe"><?= __('Four') ?></label>
      <div class="list-option ml-3" style="<?php if(!$annonce->four && !$annonce->four_mini){?>display:none;<?php }?>" >
      <div class="custom-control custom-checkbox custom-control-inline">
        <?php echo $this->Form->input('four',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="four"><?= __('Four') ?></label>  
      </div>
        <div class="custom-control custom-checkbox custom-control-inline">
        <?php echo $this->Form->input('four_mini',['templates' => ['inputContainer' => "{{content}}"],'label'=>False,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="four-mini"><?= __('Mini Four') ?></label>  
      </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="custom-control custom-checkbox custom-control">
    <?php if($annonce->lave_vaissel_4 || $annonce->lave_vaissel_8|| $annonce->lave_vaissel_12){
        echo $this->Form->input('lave_vaissel',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox', 'checked']);
      }else{
        echo $this->Form->input('lave_vaissel',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);
      }?>
      
      <label class="custom-control-label" for="lave-vaissel"><?= __("Lave vaisselle") ?></label>
      <div class="list-option ml-3" style="<?php if(!$annonce->lave_vaissel_4 && !$annonce->lave_vaissel_8&& !$annonce->lave_vaissel_12){?>display:none;<?php }?>" >
        <div class="custom-control custom-checkbox custom-control-inline">
          <?php echo $this->Form->input('lave_vaissel_4',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="lave-vaissel-4"><?= '4 '.__('Couverts') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control-inline">
        <?php echo $this->Form->input('lave_vaissel_8',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="lave-vaissel-8"><?= '8 '.__('Couverts') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control-inline">
        <?php echo $this->Form->input('lave_vaissel_12',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="lave-vaissel-12"><?= '12 '.__('Couverts') ?></label>
        </div>
        </div>
    </div>
    <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('table_cuisson',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="table-cuisson"><?= __('Table de Cuisson') ?></label>      
      <div class="list-option ml-3" style="<?php if(!$annonce->table_cuisson && !$annonce->table_cuisson_feu){?>display:none;<?php }?>" >
      <input type="hidden" name="table_cuisson" value="">
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" name="table_cuisson"  <?php if($annonce->table_cuisson==0) echo "CHECKED"?>  value="0" id="table-cuisson-1">
          <label class="custom-control-label" for="table-cuisson-1"><?= __('Electrique') ?></label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" name="table_cuisson"  <?php if($annonce->table_cuisson==1) echo "CHECKED"?>  value="1" id="table-cuisson-2">
          <label class="custom-control-label" for="table-cuisson-2"> <?= __('Gaz') ?></label>
       </div>
       <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" name="table_cuisson"   <?php if($annonce->table_cuisson==2) echo "CHECKED"?> value="2" id="table-cuisson-3">
          <label class="custom-control-label" for="table-cuisson-3"> <?= __('Vitrocéramique') ?></label>
       </div>
       <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" name="table_cuisson" <?php if($annonce->table_cuisson==3) echo "CHECKED"?> value="3" id="table-cuisson-4">
          <label class="custom-control-label" for="table-cuisson-4"> <?= __('Induction') ?></label>
       </div>
       <br>
       <input type="hidden" name="table_cuisson_feu" value="">
       <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" name="table_cuisson_feu" <?php if($annonce->table_cuisson_feu==0) echo "CHECKED"?> value="0" id="table-cuisson-feu-1">
          <label class="custom-control-label" for="table-cuisson-feu-1"> <?= '2 '.__('feux') ?></label>
       </div>
       <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" name="table_cuisson_feu" <?php if($annonce->table_cuisson_feu==1) echo "CHECKED"?> value="1" id="table-cuisson-feu-2">
          <label class="custom-control-label" for="table-cuisson-feu-2"> <?= '3 '.__('feux') ?></label>
       </div>
       <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" name="table_cuisson_feu" <?php if($annonce->table_cuisson_feu==2) echo "CHECKED"?> value="2" id="table-cuisson-feu-3">
          <label class="custom-control-label" for="table-cuisson-feu-3"> <?= '4 '.__('feux') ?></label>
       </div>
    </div>
  </div>
    <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('hotte',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="hotte"><?= __("Hotte") ?></label>
    </div>
  </div>
  </div>
  <div  class="form-row mt-4">
    <legend class="col-form-label"><?= __('Petit Ménager') ?></legend>
    <div class="col">
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('cafetiere',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="cafetiere"><?= __('Cafetière') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('grill_pain',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="grill-pain"><?= __('Grille-pain') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('bouilloire',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="bouilloire"><?= __('Bouilloire') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('autocuiseur',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="autocuiseur"><?= __('Auto-cuiseur') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('mixeur',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="mixeur"><?= __('Mixeur') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('aspirateur',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="aspirateur"><?= __('Aspirateur') ?></label>
    </div>
    </div>
    <div class="col">    
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('raclette',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="raclette"><?= __('Raclette') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('pierrade',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="pierrade"><?= __('Pierrade') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('crepiere',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="crepiere"><?= __('Crépière') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('fondue',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="fondue"><?= __('Fondue') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('wok',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="wok"><?= __('Wok') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('seche_cheveux',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="seche-cheveux"><?= __('Sèche-cheveux') ?></label>
    </div>
    </div>
    <div class="col">
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('fer_repasser',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="fer-repasser"><?= __('Fer à repasser') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('table_repasser',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="table-repasser"><?= __('Table à repasser') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('brasero',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'type'=>'checkbox','class'=>'custom-control-input'])?>
      <label class="custom-control-label" for="brasero"><?= __('Brasero') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('barbecue',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'type'=>'checkbox','class'=>'custom-control-input'])?>
      <label class="custom-control-label" for="barbecue"><?= __('Barbecue') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('plancha',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'type'=>'checkbox','class'=>'custom-control-input'])?>
      <label class="custom-control-label" for="plancha"><?= __('Plancha') ?></label>
    </div>
    </div>
  </div>
  <div  class="form-row mt-4">
    <legend class="col-form-label"><?= __('Mobilier') ?></legend>
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('placard',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="placard"><?= __('Placards') ?></label>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('penderie',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="penderie"><?= __('Penderie') ?></label>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php if($annonce->table_120 || $annonce->table_140 || $annonce->table_160 || $annonce->table_180 ||$annonce->table_200|| $annonce->table_allonge ||$annonce->table_autre ){
        echo $this->Form->input('Table_existe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox', 'checked']);
        }else{
          echo $this->Form->input('Table_existe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);
        }?>      
        <label class="custom-control-label" for="table-existe"><?= __('Table') ?></label>
        <div class="list-option ml-3" style="<?php if(!$annonce->table_120 && !$annonce->table_140 && !$annonce->table_160 && !$annonce->table_180 && !$annonce->table_200 && !$annonce->table_allonge && !$annonce->table_autre ){?>display:none;<?php }?>" >
        <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('table_120',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="table-120">120</label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('table_140',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="table-140">140</label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('table_160',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="table-160">160</label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('table_180',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="table-180">180</label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('table_200',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="table-200">200</label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('table_allonge',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="table-allonge"><?= __('Allongé') ?></label>
        </div>
        </div>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('chaises',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="chaises"><?= __('Chaises') ?></label>
      </div>
    </div>
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
      <?php if($annonce->banquette_clic_130 || $annonce->banquette_clic_140){ 
        echo $this->Form->input('clic_clac_existe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox', 'checked']);
        }else{
          echo $this->Form->input('clic_clac_existe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);
        }?>
        <label class="custom-control-label" for="clic-clac-existe"><?= __('Banquette Clic Clac') ?></label>
        <div class="list-option ml-3" style="<?php if(!$annonce->banquette_clic_130 && !$annonce->banquette_clic_140){?>display:none;<?php }?>" >
          <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('banquette_clic_130',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="banquette-clic-130">130 x 200</label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('banquette_clic_140',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="banquette-clic-140">140 x 200</label>
        </div>
        </div>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php if($annonce->banquette_bz_80 || $annonce->banquette_bz_120 || $annonce->banquette_bz_140 || $annonce->banquette_bz_160){ 
        echo $this->Form->input('BZ_existe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox', 'checked']);
        }else{
          echo $this->Form->input('BZ_existe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);
        }?>
        <label class="custom-control-label" for="bz-existe"><?= __('Banquette BZ') ?></label>
        <div class="list-option ml-3" style="<?php if(!$annonce->banquette_bz_80 && !$annonce->banquette_bz_120 &&!$annonce->banquette_bz_140 && !$annonce->banquette_bz_160){?>display:none;<?php }?>" >
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('banquette_bz_80',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="banquette-bz-80">80</label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('banquette_bz_120',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="banquette-bz-120">120</label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('banquette_bz_140',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="banquette-bz-140">140</label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('banquette_bz_160',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox'])?>
          <label class="custom-control-label" for="banquette-bz-160">160</label>
        </div>
        </div>
      </div>
      <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('tabouret',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="tabouret"><?= __('Tabourets') ?></label>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php if($annonce->literie_70 || $annonce->literie_80 || $annonce->literie_90 || $annonce->literie_140 || $annonce->literie_160 || $annonce->literie_2_70 || $annonce->literie_2_80 || $annonce->literie_rev || $annonce->literie_cig || $annonce->literie_peign || $annonce->literie_rapido){
        echo $this->Form->input('literie_existe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox', 'checked']);
       }else{
        echo $this->Form->input('literie_existe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);
       } ?>
      <?php ?>
        <label class="custom-control-label" for="literie-existe"><?= __('Literie') ?></label>
        <div class="list-option ml-3" style="<?php if(!$annonce->literie_70 && !$annonce->literie_80 && !$annonce->literie_90 && !$annonce->literie_140 && !$annonce->literie_160 && !$annonce->literie_2_70 && !$annonce->literie_2_80 && !$annonce->literie_rev && !$annonce->literie_cig  && !$annonce->literie_peign && !$annonce->literie_rapido ){?>display:none;<?php }?>" >
          <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('literie_70',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="literie-70"><?= __('Lit') ?> 70 x 190</label>
          </div>
          <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('literie_80',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="literie-80"><?= __('Lit') ?> 80 x 190</label>
          </div>
          <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('literie_90',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="literie-90"><?= __('Lit') ?> 90 x 190</label>
          </div>
          <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('literie_140',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="literie-140"><?= __('Lit') ?> 140 x 190</label>
          </div>
          <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('literie_160',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="literie-160"><?= __('Lit') ?> 160 x 190</label>
          </div>
          <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('literie_2_70',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="literie-2-70"><?= __('Lits Superposés') ?> 2 x70 x 190</label>
          </div>
          <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('literie_sup_2_80',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="literie-sup-2-80"><?= __('Lits Superposés') ?> 2 x80 x 190</label>
          </div>
          <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('literie_rev',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="literie-rev"><?= __('Banquette Révisible') ?></label>
          </div>
          <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('literie_cig',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="literie-cig"><?= __('Banquette Gigogne') ?></label>
          </div>
          <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('literie_peign',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="literie-peign"><?= __('Banquette Lits Peignes') ?> 2 x 70 x 190</label>
          </div>
          <div class="custom-control custom-checkbox custom-control">
          <?php echo $this->Form->input('literie_rapido',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
            <label class="custom-control-label" for="literie-rapido"> <?= __('Banquette Rapido') ?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('oreillers',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="oreillers"><?= __('Oreillers') ?></label>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('couvertures',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="couvertures"><?= __('Couvertures') ?></label>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('couettes',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="couettes"><?= __('Couettes') ?></label>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('protege_matelas',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="protege-matelas"><?= __('Protèges Matelas ou Alèzes') ?></label>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('linge_lit',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="linge-lit"><?= __('Linge de lit inclus') ?></label>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('serviettes',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="serviettes"><?= __('Serviettes incluses') ?></label>
      </div>
    </div>
  </div>
  <div  class="form-row mt-4">
    <legend class="col-form-label"><?= __('Espace Ludique et multimédia') ?></legend>
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
      <?php if($annonce->tube_cathod || $annonce->cable_sat|| $annonce->decodeur_canal || $annonce->ecran_plat || $annonce->tnt || $annonce->decodeur_sky || $annonce->ecran_plasma || $annonce->chaine_etranger){
        echo $this->Form->input('televiseur', ['templates' => ['inputContainer' => "{{content}}"], 'label'=>false,'class'=>"serv custom-control-input", 'type'=>'checkbox', 'checked']);
        }else{
          echo $this->Form->input('televiseur', ['templates' => ['inputContainer' => "{{content}}"], 'label'=>false,'class'=>"serv custom-control-input", 'type'=>'checkbox']);
        }?>
        <label class="custom-control-label" for="televiseur"><?= __('Téléviseur') ?></label>
        <div class="list-option ml-3" style="<?php if(!$annonce->tube_cathod &&!$annonce->cable_sat&& !$annonce->decodeur_canal &&!$annonce->ecran_plat && !$annonce->tnt&& !$annonce->decodeur_sky &&!$annonce->ecran_plasma && !$annonce->chaine_etranger){?>display:none;<?php }?>" >
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('tube_cathod',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="tube-cathod"><?= __('Tube Cathodique') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('cable_sat',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="cable-sat"><?= __('Cable Satellite') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('decodeur_canal',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="decodeur-canal"><?= __('Décodeur Canal+') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('ecran_plat',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="ecran-plat"><?= __('Ecran Plat LCD-LED') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('tnt',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="tnt">TNT</label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('decodeur_sky',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="decodeur-sky"><?= __('Décodeur Sky') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('ecran_plasma',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="ecran-plasma"><?= __('Ecran Plasma') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('chaine_etranger',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="chaine-etranger"><?= __('Chaines Etrangères') ?></label>
        </div>
        </div>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input("cd",['label'=>false,'templates' => ['inputContainer' => "{{content}}"],'type'=>'checkbox','class'=>"custom-control-input",'size'=>'auto'])?>                                   
        <label class="custom-control-label" for="cd"><?= __('Lecteur CD') ?></label>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input("hifi",['label'=>false,'templates' => ['inputContainer' => "{{content}}"],'type'=>'checkbox','class'=>"custom-control-input",'size'=>'auto'])?>
        <label class="custom-control-label" for="hifi"><?= __('Chaine HIFI') ?></label>
      </div>
    </div>
    <div class="col">
    <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input("dvd",['label'=>false,'templates' => ['inputContainer' => "{{content}}"],'type'=>'checkbox', 'class'=>"custom-control-input",'size'=>'auto'])?>                                          
      <label class="custom-control-label" for="dvd"><?= __('Lecteur DVD') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input("wifi_appartment",[
                                  'label'=>false,
                                  'templates' => ['inputContainer' => "{{content}}"],
                                  'type'=>'checkbox', 'class'=>"custom-control-input",
                                  'size'=>'auto'])?>
        <label class="custom-control-label" for="wifi-appartment"><?= __('Wifi Gratuit (box dans l\'appartement)') ?></label>
      </div>
      <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input("wifi_gratuit",[
                                    'label'=>false,
                                    'templates' => ['inputContainer' => "{{content}}"],
                                    'type'=>'checkbox','class'=>"custom-control-input",
                                    'size'=>'auto'])?>
      <label class="custom-control-label" for="wifi-gratuit"><?= __('Wifi Gratuit (dans la résidence)') ?></label>
    </div>
    </div>
    <div class="col">
    <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input("wifi_payant",[
                                                  'label'=>false,
                                                  'templates' => ['inputContainer' => "{{content}}"],
                                                  'type'=>'checkbox', 'class'=>"custom-control-input",
                                                  'size'=>'auto'])?>
        <label class="custom-control-label" for="wifi-payant"><?= __('Wifi Payant') ?></label>
      </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input("jeux_video",[
                                                  'label'=>false,
                                                  'templates' => ['inputContainer' => "{{content}}"],
                                                  'type'=>'checkbox','class'=>"custom-control-input",
                                                  'size'=>'auto'])?>
      <label class="custom-control-label" for="jeux-video"><?= __('Jeux Vidéos') ?></label>
    </div>
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input("jeux_societe",[
                                                  'label'=>false,
                                                  'templates' => ['inputContainer' => "{{content}}"],
                                                  'type'=>'checkbox','class'=>"custom-control-input",
                                                  'size'=>'auto'])?>
        <label class="custom-control-label" for="jeux-societe"><?= __('jeux de société') ?></label>
      </div>
      <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input("quoi_lire",[
                                                  'label'=>false,
                                                  'templates' => ['inputContainer' => "{{content}}"],
                                                  'type'=>'checkbox','class'=>"custom-control-input",
                                                  'size'=>'auto'])?>
        <label class="custom-control-label" for="quoi-lire"><?= __('De quoi lire') ?></label>
      </div>
    </div>
  </div>
  <div  class="form-row mt-4">
    <legend class="col-form-label"><?= __('Espaces détente et sport') ?></legend>
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('baignoire_hydro',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="baignoire-hydro"><?= __('Baignoire Hydromassage') ?></label>
      </div>
    </div>
    <div class="col">
    <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('appart_hammam',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
      <label class="custom-control-label" for="appart-hammam"><?= __('Hammam') ?></label>
    </div>
    </div>
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('appart_sauna',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="appart-sauna"><?= __('Sauna') ?></label>
      </div>
    </div>
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('espace_piscine',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="espace-piscine"><?= __('Piscine') ?></label>
      </div>
    </div>
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('salle_fitness',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="salle-fitness"><?= __('Salle de fitness dans la résidence') ?></label>
      </div>
    </div>
    
  </div>
  <div  class="form-row mt-4">
    <legend class="col-form-label"><?= __('Équipements supplémentaires') ?></legend>    
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('poele_granule',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="poele-granule"><?= __('Poêle à granule') ?></label>
      </div>
    </div>
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('cheminee',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="cheminee"><?= __('Cheminée') ?></label>
      </div>
    </div>
  </div>
  <div  class="form-row mt-4">
    <legend class="col-form-label"><?= __('Équipements pour les enfants') ?></legend>    
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('lit_bebe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="lit-bebe"><?= __('Lit bébé') ?></label>
      </div>
    </div>
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('chaise_bebe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="chaise-bebe"><?= __('Chaise bébé') ?></label>
      </div>
    </div>
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('baigoire_bebe',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="baigoire-bebe"><?= __('Baigoire bébé') ?></label>
      </div>
    </div>
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('reserv_sur_place',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox'])?>
        <label class="custom-control-label" for="reserv-sur-place"><?= __('Réservation sur place possible') ?></label>
      </div>
    </div>
  </div>
  <div  class="form-row mt-4">
    <legend class="col-form-label"><?= __("Situation") ?></legend>
    <div class="col">
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('centre_comm',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);?>
        <label class="custom-control-label" for="centre-comm"><?= __('Proche d\'un centre commercial') ?></label>
        <div class="list-option ml-3" style="<?php if(!$annonce->centre_comm){?>display:none;<?php }?>" >
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('restaurant',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?> 
          <label class="custom-control-label" for="restaurant"><?= __('Restaurants') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('velos',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="velos"><?= __('Locations de vélos') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('loc_ski',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="loc-ski"><?= __('Locations de ski') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('remontee_caisse',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="remontee-caisse"><?= __('Caisses de remontées mécaniques') ?></label>
        </div>
        </div>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('transport_public',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
        <label class="custom-control-label" for="transport-public"><?= __('Proche des Transports publics') ?></label>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('lieux_anim',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);?>
        <label class="custom-control-label" for="lieux-anim"><?= __('Proche des lieux d\'animation') ?></label>
        <div class="list-option ml-3" style="<?php if(!$annonce->lieux_anim){?>display:none;<?php }?>" >
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('bar',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?> 
          <label class="custom-control-label" for="bar"><?= __('Bars') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('pub',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="pub"><?= __('Pubs') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('Disco',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="disco"><?= __('Discothèques') ?></label>
        </div>
      </div>
      </div>
    </div>
    <div class="col">
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('sentier_pedestre',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);?>
        <label class="custom-control-label" for="sentier-pedestre"><?= __('sentiers pédestres') ?></label>
        <div class="list-option ml-3" style="<?php if(!$annonce->sentier_pedestre){?>display:none;<?php }?>" >
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('moins_50_sentiers',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="moins-50-sentiers"><?= __("Moins de 50 m") ?></label>
        </div>
        </div>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('bien_etre',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);?>
        <label class="custom-control-label" for="bien-etre"><?= __('Proche des centres de bien etre') ?></label>
        <div class="list-option ml-3" style="<?php if(!$annonce->bien_etre){?>display:none;<?php }?>" >
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('spa',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?> 
          <label class="custom-control-label" for="spa"><?= __('Spas') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('hammam',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="hammam"><?= __('Hammam') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('sauna',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="sauna"><?= __('Sauna') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('jacuzzi',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="jacuzzi"><?= __('Jacuzzi') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('massage',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="massage"><?= __('Massage') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('accespiscine',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="accespiscine"><?= __('Acces Piscine') ?></label>
        </div> 
      </div>
      </div>
      <div class="custom-control custom-checkbox custom-control">
      <?php echo $this->Form->input('espace_enfant',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);?>
        <label class="custom-control-label" for="espace-enfant"><?= __('Proche des espaces enfants') ?></label>
        <div class="list-option ml-3" style="<?php if(!$annonce->espace_enfant){?>display:none;<?php }?>" >
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('luge',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?> 
          <label class="custom-control-label" for="luge"><?= __('Luge') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('club_enfant',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="club-enfant"><?= __('Club Enfant') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('garderie',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="garderie"><?= __('Garderie') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('ecole_ski',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="ecole-ski"><?= __('Ecole de Ski') ?></label>
        </div>       
      </div>
      </div>
    </div>
    <div class="col">
    <div class="custom-control custom-checkbox custom-control">
    <?php echo $this->Form->input('espace_sportif',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"serv custom-control-input",'type'=>'checkbox']);?>
        <label class="custom-control-label" for="espace-sportif"><?= __('Proche des espaces sportifs été/hiver') ?></label>
        <div class="list-option ml-3" style="<?php if(!$annonce->espace_sportif){?>display:none;<?php }?>" >
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('ski_pied',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="ski-pied"><?= __("Skis aux pieds") ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('moins_50_piste',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?> 
          <label class="custom-control-label" for="moins-50-piste"><?= __("Moins de 50 m") ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('cours_tennis',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="cours-tennis"><?= __('Cours de Tennis') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('golf',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="golf"><?= __('Golf') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('piscine',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="piscine"><?= __('Piscine') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('squash',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="squash"><?= __('Squash') ?></label>
        </div>
        <div class="custom-control custom-checkbox custom-control">
        <?php echo $this->Form->input('patinoire',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>"custom-control-input",'type'=>'checkbox']);?>
          <label class="custom-control-label" for="patinoire"><?= __('Patinoire') ?></label>
        </div>
      </div>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="header_title bg-light">
        <h5 class="mb-2 mt-2 py-2 px-3"><?= __('Décrivez votre annonce') ?></h5>
      </div><!-- header_title-->
    </div> <!--end col-md-12-->
  </div> <!--end row-->
  <div class="row mt-4">
    <div class="col-md-12 form-group">
      <label for="titre"><?= __('Titre de votre annonce (60 caractères maximum)') ?> *</label>
      <input type="text" id="titre" name="titre" value="<?php echo $annonce->titre;?>" class="form-control" maxlength="60" placeholder="<?php echo __('Donnez un titre à votre annonce...'); ?>" required>
      <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>
    </div>
    <div class="form-group col-md-12">
      <label for="description"><?= __('Description de l\'annonce') ?> *</label>
      <p><?= __("Donnez envie d'en savoir plus : n'hésitez pas à vanter les mérites de votre appartement, son confort, équipement, proximité avec les lieux de commerce ou encore les richesses de la station (minimum 100 caractères, maximum 1500). Selon nos conditions générales, les adresses mail, références à d'autres sites internet ou numéros de téléphone ne sont pas acceptés ici. Merci de votre compréhension.") ?></p>
      <textarea name="description" rows="10" cols="75" minlength="100" <?php if($propdetail->nature != 'PRES') { ?> maxlength="1500" <?php } ?> class="form-control <?php if($propdetail->nature == 'PRES') echo 'summernote';?>" placeholder="<?php echo __('Décrivez votre annonce...'); ?>" id="description" required><?php echo $annonce->description;?></textarea> 
      <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>
      </div>
  </div>
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="header_title bg-light">
        <h5 class="mb-2 mt-2 py-2 px-3"><?= __("Inventaire") ?></h5>
      </div><!-- header_title-->
    </div> <!--end col-md-12-->
  </div> <!--end row-->
  <div class="row mt-4 align-items-end">
    <div class="col-md-8">
      <label for=""><?= __("Télécharger une version de votre inventaire") ?></label>
      <div class="text-medium"><?= __("Vous avez la possibilité de télécharger une version PDF de votre inventaire qui sera envoyé à vos locataires lors de leur arrivée") ?></div>
    </div>
    <div class="col-md-4">
      <div class="custom-file">
        <input type="file" id="uploadfile" name="uploadfile" class="custom-file-input" accept=".pdf" />
        <label class="custom-file-label" for="uploadfile" id="uploadfilelabel" data-browse="<?= __('Parcourir'); ?>"><?= __("nom-de-fichier.pdf") ?></label>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-sm-12 viewfile">
      <?php if($annonce_inventaire) { ?>
        <object data="<?php echo $this->Url->build('/',true)?>inventaires/<?php echo $annonce_inventaire ?>" type="application/pdf" width="100%" height="500"> <?= __("Lien Pièce jointe") ?></object>
      <?php } ?>                             
    </div>
  </div>
    <div class="row mt-4 justify-content-end">
      <div class="col-auto">
      <button type="submit" class="btn btn-blue text-white rounded-0 px-6" value="Enregistrer"><?= __("Enregistrer") ?></button>                              
      </div>
    </div>
    <?php echo $this->Form->end();?>
</div><!-- end #informations -->  

<!-- Summernote Plugin JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/dist/summernote.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/lang/summernote-fr-FR.js", array('block' => 'scriptBottom')); ?>

<!-- Summernote css -->
<?php $this->Html->css("/css/summernote.min.css", array('block' => 'cssTop')); ?>


<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
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

// $(document).ready(function(){
  if($('#nature').val() == 'APP' || $('#nature').val() == 'STD'){
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
// });

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
<?php $this->Html->scriptEnd(); ?>