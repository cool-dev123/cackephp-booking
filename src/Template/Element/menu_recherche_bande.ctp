
<style>
@media (max-width: 768px){
  .formnotmobile{
    display: none;
  }
  .btnoptionsrecherche{
    display: block;
  }
}

@media (min-width: 768px){
  .formnotmobile, #demo{
    display: block;
  }
  .btnoptionsrecherche{
    display: none;
  }
}

#villagediv{
  display: none;
}
.iqdropdown {
      height: 40px;
  }
  .iqdropdown .iqdropdown-item-controls button{
  border: none;
  padding: 0;
  }
  .iqdropdown .iqdropdown-item-controls button:hover{
  background-color: white;
  }
  .iqdropdown .iqdropdown-item-controls .counter {
  border: none;
  padding-right: 10px;
  padding-left: 10px;
  }
  .iqdropdown .icon-decrement::after, .iqdropdown .icon-decrement.icon-increment::before {
  background: black;  
  width: 10px;
  height: 2px;
  }
  .iqdropdown-disabled button{
  pointer-events: none !important;
  cursor: not-allowed !important;
  }
  .iqdropdown-disabled .iqdropdown-item-controls{
  opacity: 0.3;
  }
  p.iqdropdown-description {
      font-size: 12px !important;
  }
  /* SWITCHER */
  .switch {
      position: relative;
      display: inline-block;
      width: 45px;
      height: 21px;
  }
  .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
  }
  .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
  }
  .slider:before {
      position: absolute;
      content: "";
      height: 15px;
      width: 15px;
      bottom: 3px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
      left: 2px;
  }
  input:checked + .slider {
      background-color: white;
  }
  input:checked + .slider:before {
      background-color: #2196F3;
  }
  input:focus + .slider {
      box-shadow: 0 0 1px white;
  }
  input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
  }
  /* Rounded sliders */
  .slider.round {
      border-radius: 34px;
  }
  .slider.round:before {
      border-radius: 50%;
  }
  .iqdropdown-menu.px-3 {
    width: 240px;
  }
</style>
<?php $this->Html->script("/js/moment.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/css/item-quantity-dropdown.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/item-quantity-dropdown.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
$.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);
    $('#location_du').datepicker({
        language: 'fr-FR',
        minDate: 1,
        dateFormat: "dd-mm-yy"
    });
    $('#location_du').on( "change", function() {
          /*$('#location_au').datepicker( "option", "minDate", $.datepicker.parseDate( "dd-mm-yy", this.value ) );*/
          var d = moment(this.value,"DD-MM-YYYY").add(1, 'd');
          $('#location_au').datepicker( "option", "minDate", d.format('DD-MM-YYYY') );
        });
    $('#location_au').datepicker({
        language: 'fr-FR',
        minDate: 1,
        dateFormat: "dd-mm-yy"
    });
    
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
  $('body').on('click',function(event){
    if(!$(event.target).is('.iqdropdown-selection') && !$(event.target).is('.iqdropdown-selection #animaux')){
      $(".iqdropdown").removeClass("menu-open")
    }
  });
  var nbradlt = "<?php echo $this->request->query['nbCouchage_ad'] ?>";
  var nbrenf = "<?php echo $this->request->query['nbCouchage_enf'] ?>";
  
  if(nbradlt != "" && nbrenf != ""){
    $("div[data-id='nbradulte']").attr("data-defaultcount",nbradlt);
    $("div[data-id='nbrenfant']").attr("data-defaultcount",nbrenf);
    $("#nbCouchage_ad").val(nbradlt);
    $("#nbCouchage_enf").val(nbrenf);
  } 
  
  //Init switchers
  let switchers = ['personne-reduite', 'wifi', 'wifi-gratuit', 'wifi-payant', 'lave-vaissel', 'lave-linge', 'espace-enfant', 'lieux-anim', 'animaux'];
  for(let i=0; i < switchers.length; i++) {
    let $switcher_selector = $('#'+switchers[i]);
    if($switcher_selector.length) {
      $switcher_selector.on('change',  function () {
        if($switcher_selector.is(":checked")){
          $switcher_selector.val(1);
        } else {
          $switcher_selector.val(0);
        }
      }); 
    }
  } 


 $(document).ready(function () {
  $('.iqdropdown').iqDropdown({
      selectionText: '<?= __("Vacancier(s)"); ?>',
      textPlural: '<?= __("Vacancier(s)"); ?>',
      onChange: (id, count, totalItems) => {
          if(id == 'nbradulte'){
              $('#nbCouchage_ad').val(count); 
          } 
          if(id == 'nbrenfant'){
              $('#nbCouchage_enf').val(count);
          } 
      },
  });
$(".navbar-header").css("display","block");

          function ChangeHauteur(){
              $("#main-slide .item img").height($(".slideIndex").parent("div").height());
          }
        ChangeHauteur();
        $(window).bind("load", ChangeHauteur);



        $('#btn-reset').click(function () {

            $('#annonceRechercheForm input[type="text"]').each(function(){
                    $(this).val("");
            });
            $("#uniform-promotions span").removeClass('checked');
            $("#uniform-parking span").removeClass('checked');
            $("#uniform-internet span").removeClass('checked');
            $("#uniform-drap span").removeClass('checked');
            $("#uniform-animaux span").removeClass('checked');

            $("#uniform-SamediAuSamedi span").removeClass('checked');
            $("#uniform-DimancheAuDimanche span").removeClass('checked');

            $("#uniform-AnnonceTypeLocationCHA span").removeClass('checked');
            $("#uniform-AnnonceTypeLocationAPP span").removeClass('checked');
            $("#uniform-AnnonceTypeLocationSTD span").removeClass('checked');
            $("#uniform-AnnonceTypeLocationGIT span").removeClass('checked');

            $("#uniform-AnnonceNbPiece1 span").removeClass('checked');
            $("#uniform-AnnonceNbPiece2 span").removeClass('checked');
            $("#uniform-AnnonceNbPiece3 span").removeClass('checked');
            $("#uniform-AnnonceNbPiece4 span").removeClass('checked');
            $("#uniform-AnnonceNbPiece5 span").removeClass('checked');

            $("#annonceRechercheForm :checkbox").removeAttr("checked");
            $("#annonceRechercheForm :radio").removeAttr("checked");
            $('#annonceRechercheForm select').each(function(){
            $(this).val("0");
            $( "#slider-range" ).slider({
                values: [ 0, 0]
            });
            $("#debutbudg").html("0€");
            $("#finbudg").html("0€");            
            $("#budgetDe").val('');
            $("#budgetA").val('');
            
            $( "#slider-range-surface" ).slider({
                values: [ 0, 0]
            });
            $("#debutsurface").html("0m²");
            $("#finsurface").html("0m²");
            $("#surfaceDe").val('');
            $("#surfaceA").val('');
            $("#nbCouchage_ad").val("0");
            $("#nbCouchage_enf").val("0");
            });
        })

    });
<?php $this->Html->scriptEnd(); ?>
<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div class="row btnoptionsrecherche">
  <div class="ad_search_content text-center mb-3">
    <button data-toggle="collapse" data-target="#demo" class="btn btn-blue text-white rounded-0 validerbtn"><?= __('Modifier ma recherche') ?> </button>
  </div>
</div>

<div id="demo" class="collapse">
<?php echo $this->Form->create(null,['type' => 'get','url' => SITE_ALPISSIME.$urlLang.$urlvaluemulti['recherche'],'id'=>'annonceRechercheForm', 'class'=>'formmobile'])?>
        <?php echo $this->Form->input("nbCouchagead",["type"=>"hidden","id"=>"nbCouchage_ad","name"=>$urlvaluemulti['nbCouchage_ad'], "value"=>1])?>
        <?php echo $this->Form->input("nbCouchageenf",["type"=>"hidden","id"=>"nbCouchage_enf","name"=>$urlvaluemulti['nbCouchage_enf'],"value"=>0])?>
        <div class="row px-4-5">
          <div class="col-md-6 col-lg-2  destinationdiv">
            <div class="form-group">
              <select name="<?php echo $urlvaluemulti['lieugeo']; ?>" class="form-control custom-select" id="lieugeo" onchange="get_village(this.value)">
                <option value="0"><?= __("Toutes les stations") ?></option>
                <?php foreach ($stations as $value) { ?>
                    <option class="font-weight-bold" value="massif_<?php echo $value->id; ?>" <?php if($this->request->query['lieugeo'] == "massif_".$value->id) echo "selected"?>><?php echo $value->nom; ?></option>
                        <?php foreach ($value['lieugeos'] as $key) { ?>
                            <?php if($key->name){ ?>
                            <option value="<?php echo $key->id; ?>" <?php if($this->request->query['lieugeo'] == $key->id) echo "selected"?>>&nbsp;&nbsp;&nbsp;<?php echo $key->name; ?></option>
                            <?php } ?>
                        <?php } ?>                                    
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6 col-lg-2  destinationdiv" id="villagediv">
            <div class="form-group">
              <select name="village" class="form-control custom-select" id="village">
                <option value="0"><?= __("Tous les villages") ?></option>
                <?php foreach ($listevillageann as $keyvillage) { ?>
                    <option value="<?php echo $keyvillage->id; ?>" <?php if($this->request->query['village'] == $keyvillage->id) echo "selected"?>><?php echo $keyvillage->name; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6 col-lg-15 dateclass">
            <div class="input-group mb-2">
                <?php echo $this->Form->input($urlvaluemulti['dbt'],['value'=>$this->request->query['dbt'],'label'=>false,'placeholder'=>__('Arrivée'),'readonly'=>'readonly','type'=>'text','templates' => ['inputContainer' => "{{content}}"],'id'=>'location_du', 'class'=>'form-control inline-block location'])?>
                <div class="input-group-append">
                  <div class="input-group-text"><label class="add-on mb-0" for="location_du"><i class="fa fa-calendar"></i></label></div>
                </div>
              </div>
          </div>
          <div class="col-md-6 col-lg-15 dateclass">
          <div class="input-group mb-2">
            <?php echo $this->Form->input($urlvaluemulti['fin'],['value'=>$this->request->query['fin'],'label'=>false,'placeholder'=>__('Départ'),'readonly'=>'readonly','type'=>'text','templates' => ['inputContainer' => "{{content}}"],'id'=>'location_au', 'class'=>'form-control inline-block location'])?>
            <div class="input-group-append">
                  <div class="input-group-text"><label class="add-on mb-0" for="location_au"><i class="fa fa-calendar"></i></label></div>
                </div>
          </div></div>
          <div class="col-md-6 col-lg couchagediv">
            <div class="row">
                <div class="iqdropdown mx-3">
                    <p class="iqdropdown-selection"></p>
                    <div class="iqdropdown-menu px-3">
                      <div class="iqdropdown-menu-option border-bottom p-0" data-defaultcount="1" data-id="nbradulte">
                          <div>
                          <p class="iqdropdown-item"><?= __('Adultes') ?></p>
                          <p class="iqdropdown-description"><?= __('Vacanciers de plus de 18 ans') ?></p>
                          </div>
                      </div>
                      <div class="iqdropdown-menu-option border-bottom p-0" data-id="nbrenfant">
                          <div>
                          <p class="iqdropdown-item"><?= __('Enfants') ?></p>
                          <p class="iqdropdown-description"><?= __('Vacanciers de moins de 18 ans') ?></p>
                          </div>
                      </div>
                    </div>
                </div>
            </div>  

          </div>
          <div class="col-md-12 col-lg optionsdiv">
            <label id="optionslabel" class="btn btn-input w-100"><?= __("Options") ?></label>
          </div>
          <!-- START OPTIONS POPUP -->
          <div class="ui-tooltip-options ui-tooltip ui-corner-all ui-widget-shadow ui-widget ui-widget-content  shadow-sm" style="display:none">
            <div class="ui-tooltip-content">
                <div class="otions-section">
                  <h3><?php echo  __("Type d'hébergement") ?></h3>
                  <div class="form-group checkboxs">
                    <?php echo $this->Form->input("cha",[
                                'label'=>false,
                                'templates' => ['inputContainer' => "{{content}}"],
                                'type'=>'checkbox',
                                //'size'=>'auto',
                                'hiddenField'=>false,
                                'checked'=>$this->request->query['cha']])?>
                    <label for="cha"><?= __("Chalet") ?></label>
                                    
                    <?php echo $this->Form->input("app",[
                                  'label'=>false,
                                  'templates' => ['inputContainer' => "{{content}}"],
                                  'type'=>'checkbox',
                                  //'size'=>'auto',
                                  'hiddenField'=>false,
                                  'checked'=>$this->request->query['app']])?>
                    <label for="app"><?= __("Appartement") ?></label>
                    
                    <?php echo $this->Form->input("std",[
                                  'label'=>false,
                                  'templates' => ['inputContainer' => "{{content}}"],
                                  'type'=>'checkbox',
                                  //'size'=>'auto',
                                  'hiddenField'=>false,
                                  'checked'=>$this->request->query['std']])?>
                    <label for="std"><?= __("Studio") ?></label>
                    
                    <?php echo $this->Form->input("git",[
                                  'label'=>false,
                                  'templates' => ['inputContainer' => "{{content}}"],
                                  'type'=>'checkbox',
                                  //'size'=>'auto',
                                  'hiddenField'=>false,
                                  'checked'=>$this->request->query['git']])?>
                    <label for="git"><?= __("Gite") ?></label>                  
                    
                  </div>
                </div><!--  END OF SECTION -->
                <hr/>
                
                <div class="options-section">
                  <h3><?php echo  __("Equipements préférés des vacanciers") ?></h3>
                  <div class="form-group ">
                    <div class="py-3">
                      <label><?= __("WIFI") ?> :</label>
                      <div class="col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-sm-4 col-md-5">
                                <label class="font-weight-normal" for=""><?= __("Wifi gratuit: box dans l'appartement") ?></label>
                            </div>
                            <label class="switch">
                                <?php echo $this->Form->input(isset($urlvaluemulti['wifi_appartment'])?$urlvaluemulti['wifi_appartment']:'wifi_appartment',[
                                    'label'=>false,
                                    'templates' => ['inputContainer' => "{{content}}"],
                                    'type'=>'checkbox',
                                    'hiddenField'=>false,
                                    'checked'=>$this->request->query['wifi_appartment']])?>
                                <span class="slider round shadow-sm"></span>
                            </label>
                          </div>
                          <div class="row">
                            <div class="col-sm-4 col-md-5">
                                <label class="font-weight-normal" for=""><?= __("Wifi gratuit: dans la résidence") ?></label>
                            </div>
                            <label class="switch">
                                <?php echo $this->Form->input(isset($urlvaluemulti['wifi_gratuit'])?$urlvaluemulti['wifi_gratuit']:'wifi_gratuit',[
                                    'label'=>false,
                                    'templates' => ['inputContainer' => "{{content}}"],
                                    'type'=>'checkbox',
                                    'hiddenField'=>false,
                                    'checked'=>$this->request->query['wifi_gratuit']])?>
                                <span class="slider round shadow-sm"></span>
                            </label>
                          </div>
                          <div class="row">
                            <div class="col-sm-4 col-md-5">
                                <label class="font-weight-normal" for=""><?= __("Wifi Payant") ?></label>
                            </div>
                            <label class="switch">
                                <?php echo $this->Form->input(isset($urlvaluemulti['wifi_payant'])?$urlvaluemulti['wifi_payant']:'wifi_payant',[
                                    'label'=>false,
                                    'templates' => ['inputContainer' => "{{content}}"],
                                    'type'=>'checkbox',
                                    'hiddenField'=>false,
                                    'checked'=>$this->request->query['wifi_payant']])?>
                                <span class="slider round shadow-sm"></span>
                            </label>
                          </div>
                      </div>
                    </div>
                    
                    <div class="py-3">
                      <div class="row">
                          <div class="col-3">
                              <label class="font-weight-normal" for=""><?= __("Machine à laver") ?></label>
                          </div>
                          <label class="switch">
                              <?php echo $this->Form->input(isset($urlvaluemulti['lave_linge'])?$urlvaluemulti['lave_linge']:'lave_linge',[
                                  'label'=>false,
                                  'templates' => ['inputContainer' => "{{content}}"],
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'checked'=>$this->request->query['lave_linge']])?>
                              <span class="slider round shadow-sm"></span>
                          </label>
                      </div>
                      
                      <div class="row">
                          <div class="col-3">
                              <label class="font-weight-normal" for=""><?= __("Lave vaisselle") ?></label>
                          </div>
                          <label class="switch">
                              <?php echo $this->Form->input(isset($urlvaluemulti['lave_vaissel'])?$urlvaluemulti['lave_vaissel']:'lave_vaissel',[
                                  'label'=>false,
                                  'templates' => ['inputContainer' => "{{content}}"],
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'checked'=>$this->request->query['lave_vaissel']])?>
                              <span class="slider round shadow-sm"></span>
                          </label>
                      </div>
                    </div>
                    
                  </div>
                </div><!--  END OF SECTION -->
                <hr/>

                <div class="options-section">
                  <h3><?php echo  __("Localisation") ?></h3>
                  <div class="form-group">
                    <label for="surfaceDe"><?= __("Proximité avec les pistes") ?></label>
                    <?php echo $this->Form->select(isset($urlvaluemulti['tours_localisations'])?$urlvaluemulti['tours_localisations']:'tours_localisations',
                         [
                            'all' => __('Tous'),
                            'ski_pied' => __('Skis aux pieds'),
                            'moins_50_piste' => __('Moins de 50 mètres'),
                         ], [
                        'id'=>'tours_localisations',
                        'label'=>false,
                        'class'=>'form-control',
                        'value' => $this->request->query['tours_localisations']
                      ]);?>
                  </div>

                  <div class="form-group">
                    <div class="py-3">
                      <label><?= __("Autres") ?> :</label>
                      <div class="col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-sm-4 col-md-5">
                                <label class="font-weight-normal" for=""><?= __("Proche des espaces enfants") ?></label>
                            </div>
                            <label class="switch">
                                <?php echo $this->Form->input(isset($urlvaluemulti['espace_enfant'])?$urlvaluemulti['espace_enfant']:'espace_enfant',[
                                    'label'=>false,
                                    'templates' => ['inputContainer' => "{{content}}"],
                                    'type'=>'checkbox',
                                    'hiddenField'=>false,
                                    'checked'=>$this->request->query['espace_enfant']])?>
                                <span class="slider round shadow-sm"></span>
                            </label>
                          </div>
                          <div class="row">
                            <div class="col-sm-4 col-md-5">
                                <label class="font-weight-normal" for=""><?= __("Proche des lieux d'animation") ?></label>
                            </div>
                            <label class="switch">
                                <?php echo $this->Form->input(isset($urlvaluemulti['lieux_anim'])?$urlvaluemulti['lieux_anim']:'lieux_anim',[
                                    'label'=>false,
                                    'templates' => ['inputContainer' => "{{content}}"],
                                    'type'=>'checkbox',
                                    'hiddenField'=>false,
                                    'checked'=>$this->request->query['lieux_anim']])?>
                                <span class="slider round shadow-sm"></span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div><!--  END OF SECTION -->
                <hr/>
                
                <div class="options-section">
                  <h3><?php echo  __("Extérieurs") ?></h3>
                  <div class="form-group">
                    <label><?= __("Espaces extérieurs") ?> :</label>
                    <div class="row">
                      <div class="col-md-6 col-lg-6">
                        <?php echo $this->Form->input(isset($urlvaluemulti['balcon'])?$urlvaluemulti['balcon']:'balcon',[
                                  'label'=> __('Balcon'),
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'class' => 'mr-sm-1',
                                  'checked'=>$this->request->query['balcon']])?>
                        
                        <?php echo $this->Form->input(isset($urlvaluemulti['terasse'])?$urlvaluemulti['terasse']:'terasse',[
                                  'label'=> __('Terrasse'),
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'class' => 'mr-sm-1',
                                  'checked'=>$this->request->query['terasse']])?>
                      </div>
                      
                      <div class="col-md-6 col-lg-6">
                        <?php echo $this->Form->input(isset($urlvaluemulti['jardin'])?$urlvaluemulti['jardin']:'jardin',[
                                  'label'=> __('Jardin'),
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'class' => 'mr-sm-1',
                                  'checked'=>$this->request->query['jardin']])?>

                        <?php echo $this->Form->input(isset($urlvaluemulti['espace_plein_air'])?$urlvaluemulti['espace_plein_air']:'espace_plein_air',[
                                  'label'=> __('Espace pour les repas en plein air'),
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'class' => 'mr-sm-1',
                                  'checked'=>$this->request->query['espace_plein_air']])?>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label><?= __("Equipements") ?> :</label>
                    <div class="row">
                      <div class="col-md-6 col-lg-6">
                        <?php echo $this->Form->input(isset($urlvaluemulti['baignoire_hydro'])?$urlvaluemulti['baignoire_hydro']:'baignoire_hydro',[
                                  'label'=> __('Baignoire Hydromassage'),
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'class' => 'mr-sm-1',
                                  'checked'=>$this->request->query['baignoire_hydro']])?>
                        
                        <?php echo $this->Form->input(isset($urlvaluemulti['appart_hammam'])?$urlvaluemulti['appart_hammam']:'appart_hammam',[
                                  'label'=> __('Hammam'),
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'class' => 'mr-sm-1',
                                  'checked'=>$this->request->query['appart_hammam']])?>

                        <?php echo $this->Form->input(isset($urlvaluemulti['appart_sauna'])?$urlvaluemulti['appart_sauna']:'appart_sauna',[
                                  'label'=> __('Sauna'),
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'class' => 'mr-sm-1',
                                  'checked'=>$this->request->query['appart_sauna']])?>
                      </div>
                      
                      <div class="col-md-6 col-lg-6">
                        <?php echo $this->Form->input(isset($urlvaluemulti['espace_piscine'])?$urlvaluemulti['espace_piscine']:'espace_piscine',[
                                  'label'=> __('Piscine'),
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'class' => 'mr-sm-1',
                                  'checked'=>$this->request->query['espace_piscine']])?>

                        <?php echo $this->Form->input(isset($urlvaluemulti['salle_fitness'])?$urlvaluemulti['salle_fitness']:'salle_fitness',[
                                  'label'=> __('Salle de fitness'),
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'class' => 'mr-sm-1',
                                  'checked'=>$this->request->query['salle_fitness']])?>
                      </div>
                    </div>
                  </div>
                </div><!--  END OF SECTION -->
                <hr/>

                <div class="options-section">
                  <h3><?php echo  __("Accessibilité") ?></h3>
                
                  <div class="form-group">
                    <label for="surfaceDe"><?= __("Parking") ?></label>
                    <?php echo $this->Form->select($urlvaluemulti['parking'], $parking_types, [
                        'id'=>'parking',
                        'label'=>false,
                        'class'=>'form-control',
                        'value' => $this->request->query['parking']
                      ]);?>
                  </div>

                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4 col-md-5">
                              <label class="font-weight-normal" for=""><?= __("Personne à mobilité réduite") ?></label>
                          </div>
                          <label class="switch">
                              <?php echo $this->Form->input(isset($urlvaluemulti['personne_reduite'])?$urlvaluemulti['personne_reduite']:'personne_reduite',[
                                  'label'=>false,
                                  'templates' => ['inputContainer' => "{{content}}"],
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'checked'=>$this->request->query['personne_reduite']])?>
                              <span class="slider round shadow-sm"></span>
                          </label>
                      </div>
                  </div>
                </div><!--  END OF SECTION -->
                <hr/>

                
                <div class="options-section">
                  <h3><?php echo  __("Autres") ?></h3>
                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4 col-md-5">
                              <label class="font-weight-normal" for=""><?= __("Animaux Acceptés") ?></label>
                          </div>
                          <label class="switch">
                              <?php echo $this->Form->input(isset($urlvaluemulti['animaux'])?$urlvaluemulti['animaux']:'animaux',[
                                  'label'=>false,
                                  'templates' => ['inputContainer' => "{{content}}"],
                                  'type'=>'checkbox',
                                  'hiddenField'=>false,
                                  'checked'=>$this->request->query['animaux']])?>
                              <span class="slider round shadow-sm"></span>
                          </label>
                      </div>
                      <div class="form-group">
                        <label><?= __("Classement") ?> :</label>
                        <?php echo $this->Form->select(isset($urlvaluemulti['nb_etoiles'])?$urlvaluemulti['nb_etoiles']:'nb_etoiles',
                         [
                            '' => __('Tous'),
                            '1' => '1 '. __("et plus"),
                            '2' => '2 '. __("et plus"),
                            '3' => '3 '. __("et plus"),
                            '4' => '4 '. __("et plus"),
                            '5' => '5',
                         ], [
                        'id'=>'nb_etoiles',
                        'label'=>false,
                        'class'=>'form-control',
                        'value' => $this->request->query['nb_etoiles']
                      ]);?>
                      </div>
                      <div class="form-group">
                        <label><?= __("Note des vacanciers") ?> :</label>
                        <?php echo $this->Form->select(isset($urlvaluemulti['average_rating'])?$urlvaluemulti['average_rating']:'average_rating',
                         [
                            '' => __('Tous'),
                            '4' => '4 '. __("et plus"),
                            '5' => '5',
                         ], [
                        'id'=>'average_rating',
                        'label'=>false,
                        'class'=>'form-control',
                        'value' => $this->request->query['average_rating']
                      ]);?>
                      </div>
                  </div>
                </div><!--  END OF SECTION -->
                <hr/>


                <div class="surfaceinterval row px-3 mt-3">
                    <label id="debutsurface" class="col-2  mt-n1 font-weight-bold"><?php echo $this->request->query["surfaceDe"]?$this->request->query["surfaceDe"]:0 ?>m²</label>
                    <div id="slider-range-surface" class="col-8 "></div>
                    <label id="finsurface" class="col-2 mt-n1 font-weight-bold"><?php echo $this->request->query["surfaceA"]?$this->request->query["surfaceA"]:0 ?>m²</label>
                </div> 
                <div class="hidden">
                    <label for="surfaceDe"><?= __("De") ?></label>
                    <?php echo $this->Form->input($urlvaluemulti['surfaceDe'],['value'=>$this->request->query['surfaceDe'],'label'=>false,'type'=>'number','templates' => ['inputContainer' => "{{content}}"],'id'=>'surfaceDe', 'class'=>'form-control inline-block surface'])?>
                    <label for="surfaceA"><?= __("A") ?></label>
                    <?php echo $this->Form->input($urlvaluemulti['surfaceA'],['value'=>$this->request->query['surfaceA'],'label'=>false,'type'=>'number','templates' => ['inputContainer' => "{{content}}"],'id'=>'surfaceA', 'class'=>'form-control inline-block surface'])?>
                </div>
              <br>
              <hr>
                <!-- <input type="radio" value="1" id="SamediAuSamedi" <?php if($this->request->query["conditionSemaine"]==1) echo "CHECKED"?> name="<?php echo $urlvaluemulti['conditionSemaine']; ?>">
                <label for="SamediAuSamedi"> <?= __("Du Samedi au Samedi") ?> </label>
                <br>
                <input type="radio" value="2" id="DimancheAuDimanche" <?php if($this->request->query["conditionSemaine"]==2) echo "CHECKED"?> name="<?php echo $urlvaluemulti['conditionSemaine']; ?>">
                <label for="DimancheAuDimanche"><?= __("Du Dimanche au Dimanche") ?></label>
              <hr> -->
              <!-- 
              <div class="form-group radios">
                <label><?= __("Nombre de pièces") ?> :</label>
                <input type="radio" value="1" id="AnnonceNbPiece1"  <?php if($this->request->query["nbPiece"]==1) echo "CHECKED"?> name="<?php echo $urlvaluemulti['nbPiece']; ?>">
                <label for="AnnonceNbPiece1">1 </label>
                <input type="radio" value="2" id="AnnonceNbPiece2"  <?php if($this->request->query["nbPiece"]==2) echo "CHECKED"?> name="<?php echo $urlvaluemulti['nbPiece']; ?>">
                <label for="AnnonceNbPiece2">2 </label>
                <input type="radio" value="3" id="AnnonceNbPiece3"  <?php if($this->request->query["nbPiece"]==3) echo "CHECKED"?> name="<?php echo $urlvaluemulti['nbPiece']; ?>">
                <label for="AnnonceNbPiece3">3 </label>
                <input type="radio" value="4" id="AnnonceNbPiece4"  <?php if($this->request->query["nbPiece"]==4) echo "CHECKED"?> name="<?php echo $urlvaluemulti['nbPiece']; ?>">
                <label for="AnnonceNbPiece4">4 </label>
                <input type="radio" value="5" id="AnnonceNbPiece5"  <?php if($this->request->query["nbPiece"]==5) echo "CHECKED"?> name="<?php echo $urlvaluemulti['nbPiece']; ?>">
                <label for="AnnonceNbPiece5">5 <?= __("et plus") ?></label>
              </div>
              <hr>
              -->
              <div class="form-group checkboxs">
                <?php echo $this->Form->input("promotions",[
                              'label'=>false,
                              'templates' => ['inputContainer' => "{{content}}"],
                              'type'=>'checkbox',
                              //'size'=>'auto',
                              'hiddenField'=>false,
                              'checked'=>$this->request->query['promotions']])?>
                <label for="promotions"><?= __("Promotion") ?></label>
                
                
                <?php echo $this->Form->input($urlvaluemulti['drap'],[
                                  'id'=>'drap',
                                  'label'=>false,
                                  'templates' => ['inputContainer' => "{{content}}"],
                                  'type'=>'checkbox',
                                  //'size'=>'auto',
                                  'hiddenField'=>false,
                                  'checked'=>$this->request->query['drap']])?>
                <label for="drap"><?= __("Draps et linge fournis") ?></label>
                 
              </div>
              <hr>
              <!-- Num annonce -->
              <div class="form-group">
                  <label for="motcle"><?= __("Référence de l'annonce") ?></label>
                  <?php echo $this->Form->input("reference",['value'=>$this->request->query["reference"],'label'=>false,'templates' => ['inputContainer' => "{{content}}"],'type'=>'text', 'class'=>'form-control inline-block'])?>
              </div>
              <hr>              
              <div class="form-group">
                  <label for="motcle"><?= __("Mots clés") ?></label>
                  <?php echo $this->Form->input($urlvaluemulti["motcle"],['id'=>'motcle','value'=>$this->request->query["motcle"],'label'=>false,'templates' => ['inputContainer' => "{{content}}"],'type'=>'text', 'class'=>'form-control inline-block'])?>
              </div>
              <hr>
              <!-- budget -->
              <div class="center text-center">
                    <input type="radio" value="1" id="prixnuitee" <?php if($this->request->query["prixbudget"]==1) echo "checked='checked'"?> name="<?php echo $urlvaluemulti['prixbudget']; ?>">
                    <label for="prixnuitee" class="font-weight-bold"> <?= __("Prix par Nuitée") ?></label>
                    <input type="radio" value="2" id="prixperiode" <?php if($this->request->query["prixbudget"]==2) echo "checked='checked'"?> name="<?php echo $urlvaluemulti['prixbudget']; ?>">
                    <label for="prixperiode" class="font-weight-bold"> <?= __("Prix Période") ?></label>
              </div>
              <div class="budgetinterval row px-3">
                <label id="debutbudg" class="col-2 col-sm-1 mt-n1 font-weight-bold"><?php echo $this->request->query["budgetDe"]?$this->request->query["budgetDe"]:0 ?>€</label>
                <div id="slider-range" class="col-8 col-sm-10"></div>
                <label id="finbudg" class="col-2 col-sm-1 mt-n1 font-weight-bold"><?php echo $this->request->query["budgetA"]?$this->request->query["budgetA"]:0 ?>€</label>
              </div>
              <br/>
              <div class="hidden">
                <label for="budgetDe"><?= __("De") ?></label>
                <?php echo $this->Form->input($urlvaluemulti['budgetDe'],['value'=>$this->request->query["budgetDe"],'label'=>false,'type'=>'number','templates' => ['inputContainer' => "{{content}}"],'id'=>'budgetDe', 'class'=>'form-control inline-block budget'])?>
                <label for="budgetA"><?= __("A") ?></label>
                <?php echo $this->Form->input($urlvaluemulti['budgetA'],['value'=>$this->request->query["budgetA"],'label'=>false,'type'=>'number','templates' => ['inputContainer' => "{{content}}"],'id'=>'budgetA', 'class'=>'form-control inline-block budget'])?>
              </div> 
              <button type="button" class="btn btn-default rounded-0 left" id="valideroptions"><?= __("Réinitialiser") ?></button>              
              <button type="submit" class="btn btn-blue text-white right rounded-0 validerbtn"><?= __("Valider") ?></button>
            </div>
            <div class="arrow top center"></div>
          </div>
          
          <!-- END OPTIONS POPUP -->
          <div class="col-md-6 col-lg validerdiv mr-lg-2 mb-3">
            <button type="button" class="btn btn-default btn-white left w-100" id='btn-reset'><?= __("Réinitialiser") ?></button>
          </div>
          <div class="col-md-6 col-lg validerdiv">
            <button type="submit" class="btn btn-warning left btn-blue validerbtn text-white w-100"><?= __("Recherche") ?></button>
          </div>
        <div class="clearfix"></div>
    </div>
    <?php echo $this->Form->end()?>
</div>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>

    $( "#slider-range" ).slider({
            range: true,
            tooltips: true,
            min: 0,
            max: 10100,
            values: [ '<?php echo $this->request->query["budgetDe"] ?>', '<?php echo $this->request->query["budgetA"] ?>' ],
            slide: function( event, ui ) {
            //console.log(ui);                
                $("#debutbudg").html(ui.values[ 0 ] + "€");
                $("#budgetDe").val(ui.values[ 0 ]);
                $("#finbudg").html(ui.values[ 1 ] + "€");
                $("#budgetA").val(ui.values[ 1 ]);
            }
    });
    $( "#slider-range-surface" ).slider({
            range: true,
            tooltips: true,
            min: 10,
            max: 310,
            values: [ '<?php echo $this->request->query["surfaceDe"] ?>', '<?php echo $this->request->query["surfaceA"] ?>' ],
            slide: function( event, ui ) {
                $("#debutsurface").html(ui.values[ 0 ] + "m²");
                $("#surfaceDe").val(ui.values[ 0 ]);
                $("#finsurface").html(ui.values[ 1 ] + "m²");
                $("#surfaceA").val(ui.values[ 1 ]);
            }
    });
   
$(".ui-tooltip-budget").hide();
var budgetdiv = $(".budgetdiv").position();
var offsetcontenupos = $(".ui-tooltip-budget").position();
/* Autres options */
$(".ui-tooltip-options").hide();
var optionsdiv = $(".optionsdiv").position();
var offsetcontenuposoptions = $(".ui-tooltip-options").position();
/* Autres Voyageurs */
$(".ui-tooltip-voyageurs").hide();
var couchagediv = $(".couchagediv").position();
var offsetcontenuposvoyageurs = $(".ui-tooltip-voyageurs").position();

$("#budgetlabel").on("click", function (e) {
    if (window.matchMedia("(max-width: 767px)").matches) {
      $(".ui-tooltip-options").hide();
      $(".ui-tooltip-voyageurs").hide();
      $(".ui-tooltip-budget").toggle();
    } else {
      $(".ui-tooltip-options").hide();
      $(".ui-tooltip-voyageurs").hide();
      $(".ui-tooltip-budget").css("left", budgetdiv.left-($(".ui-tooltip-budget").width()/2.5 + 23));
      //$(".ui-tooltip").css("top", $("#annonceRechercheForm").height() + offsetcontenupos.top);
      $(".ui-tooltip-budget").css("top", budgetdiv.top + $("#annonceRechercheForm").height()/2 + 22);
      $(".ui-tooltip-budget").toggle();
    }
  
});
/* Click Options */
$("#optionslabel").on("click", function (e) {
    if (window.matchMedia("(max-width: 767px)").matches) {
      $(".ui-tooltip-budget").hide();
      $(".ui-tooltip-voyageurs").hide();
      $(".ui-tooltip-options").toggle();
    } else {
      $(".ui-tooltip-budget").hide();
      $(".ui-tooltip-voyageurs").hide();
      $(".ui-tooltip-options").css("left", ($(".optionsdiv").position()).left-($(".ui-tooltip-options").width()/3 + 25));
      //$(".ui-tooltip").css("top", $("#annonceRechercheForm").height() + offsetcontenuposoptions.top);
      $(".ui-tooltip-options").css("top", optionsdiv.top + $("#annonceRechercheForm").height()/2 + 22);
      $(".ui-tooltip-options").toggle();
    }
  
});
/* Click nbcouchage */
$("#couchagelabel").on("click", function (e) {
  if (window.matchMedia("(max-width: 767px)").matches) {
    $(".ui-tooltip-budget").hide();   
    $(".ui-tooltip-options").hide();
    $(".ui-tooltip-voyageurs").toggle();
  } else {
      $(".ui-tooltip-budget").hide();
      $(".ui-tooltip-options").hide();
      $(".ui-tooltip-voyageurs").css("left", ($(".couchagediv").position()).left);
      //$(".ui-tooltip").css("top", $("#annonceRechercheForm").height() + offsetcontenuposvoyageurs.top);
      $(".ui-tooltip-voyageurs").css("top", couchagediv.top + $("#annonceRechercheForm").height()/2 + 22);
      $(".ui-tooltip-voyageurs").toggle();
    }
});
/* Click location_au */
$("#location_au").on("click", function (e) {
    $(".ui-tooltip-budget").hide();   
    $(".ui-tooltip-options").hide();
    $(".ui-tooltip-voyageurs").hide();
});
/* Click location_du */
$("#location_du").on("click", function (e) {
    $(".ui-tooltip-budget").hide();   
    $(".ui-tooltip-options").hide();
    $(".ui-tooltip-voyageurs").hide();
});
/* Click lieugeo */
$("#lieugeo").on("click", function (e) {
    $(".ui-tooltip-budget").hide();   
    $(".ui-tooltip-options").hide();
    $(".ui-tooltip-voyageurs").hide();
});
/* Click validerbudget */
$("#validerbudget").on("click", function (e) {
    $(".ui-tooltip-budget").hide(); 
    $("html, body").animate({ scrollTop: 0 }, "slow");
});
/* Click valideroptions */
$("#valideroptions").on("click", function (e) {
    $(".ui-tooltip-options").hide(); 
    $("html, body").animate({ scrollTop: 0 }, "slow");
});


if($("#lieugeo").val() == 0) $("#villagediv").css("display", "none");
if($("#lieugeo").val() != 0) get_village($("#lieugeo").val());
setcenterlatlong($("#lieugeo").val());
function setcenterlatlong(id)
{
  if(id!='')
  {
    $.ajax({
        type: "POST",
        url: "<?php echo $this->Url->build('/',true)?>annonces/setcenrlatlong/"+id,
        dataType : 'json',
        success:function(data){
          latInfo = data.latInfo;
          longInfo = data.longInfo;
          zoomInfo = data.zoomInfo;
          
          map.setCenter({
            lat : parseFloat(latInfo),
            lng : parseFloat(longInfo)
          });
          map.setZoom(zoomInfo);
        }
    });
  }else{
      map.setCenter({
        lat : 46.5782742,
        lng : 4.8072428
      });
      map.setZoom(6.5);
  }
}
function get_village(id){
  if(id!='')
    {
      $('#village').empty().prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Url->build('/',true)?>manager/village/getStationVillagesWithAnnonces/"+id,
            dataType : 'json',
            success:function(data){
              valvillage = 0;
              <?php if(isset($this->request->query['village'])){ ?>
                valvillage = <?php echo $this->request->query['village']; ?>;
              <?php } ?>
              if(data.length > 1){
                $('#village').append('<option value="0"><?= __("Tous les villages") ?></option>');
                $.each(data,function(i,val){
                    if(valvillage == val.id) selectedval = "selected";
                    else selectedval = "";
                    $('#village').append('<option value=' + val.id + ' ' + selectedval + '>' + val.name + '</option>');
                });
                $("#villagediv").css("display", "block");
              }else{
                $("#villagediv").css("display", "none");
              }
            },
            complete:function(){
              $('#village').prop('disabled', false).trigger('change');
            }
        });
    }else{
        $("#villagediv").css("display", "none");
    }
}
<?php $this->Html->scriptEnd(); ?>
