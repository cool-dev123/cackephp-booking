<style>
.input-group-text{
  background-color: white;
}
#recherchelogement {
    background: #0099ff;
    color: white;
    border: none;
    width: 100%;
    padding: 9px 0px !important;
    font-size: 13px;
}
label.m-0 {
    font-size: 15px;
}
/* 992-1199 */
span.input-group-text {
    padding: 6px;
    border-right: 0;
}
input#nbCouchage_adulte {
    padding: 0;
    border-right: 0;
    border-left: 0;
}
input#nbCouchage_enfant {
    padding: 0;
    border-right: 0;
    border-left: 0;
}
@media screen and (max-width: 992px) {
    .rechercheLanding {
        margin-top: -11em!important;
    }
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
</style>
<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div class="rechercheLanding position-relative mb-0 px-3 py-3 rounded shadow mt-n5 mx-2">
  <?php echo $this->Form->create(null,['type'=>'get', 'url' => SITE_ALPISSIME.$urlLang.$urlvaluemulti['recherche'],'id'=>'annonceRechercheForm'])?>
  <?php echo $this->Form->input("nbCouchagead",["type"=>"hidden","id"=>"nbCouchage_ad","name"=>$urlvaluemulti['nbCouchage_ad'], "value"=>1])?>
  <?php echo $this->Form->input("nbCouchageenf",["type"=>"hidden","id"=>"nbCouchage_enf","name"=>$urlvaluemulti['nbCouchage_enf'],"value"=>0])?>
  <div class="form-row">
    <div class="col-sm-12 col-lg mb-2 pr-0">
      <label class="m-0 font-weight-bold" for="lieugeo"><?= __("Rechercher une location de vacances") ?></label>
      <select name="<?php echo $urlvaluemulti['lieugeo']; ?>" class="form-control custom-select" id="lieugeo">
        <option value="0"><?= __("Toutes les stations") ?></option>
        <?php foreach ($listeStations as $value) { ?>
            <option class="font-weight-bold" value="massif_<?php echo $value->id; ?>" <?php if($massif) {if($massif->id == $value->id) echo "selected"; }?>><?php echo $value->nom; ?></option>
                <?php foreach ($value['lieugeos'] as $key) { 
                  if($key->name){ ?>
                    <option value="<?php echo $key->id; ?>" <?php if($station) {if($station->id == $key->id) echo "selected"; }?>>&nbsp;&nbsp;&nbsp;<?php echo $key->name; ?></option>
                  <?php } ?>
                <?php } ?>                                    
        <?php } ?>
      </select>
    </div>
    <div class="col-sm-12 col-lg mb-2">
      <label class="m-0 font-weight-bold"><?= __("Dates") ?></label>
      <div class="d-flex">
        <div class="input-group mb-2">
            <input id="location_du" class="form-control pr-1 pl-2 border-right-0" name="<?php echo $urlvaluemulti['dbt']; ?>" placeholder="jj-mm-aaaa" readonly />
            <div class="input-group-append">
                <div class="input-group-text bg-white"><label class="add-on mb-0" for="location_du"><i class="fa fa-calendar"></i></label></div>
            </div>
        </div>
        <div class="input-group mb-2">
            <input id="location_au" class="form-control pr-1 pl-2 border-right-0" name="<?php echo $urlvaluemulti['fin']; ?>" placeholder="jj-mm-aaaa" readonly />
            <div class="input-group-append">
                <div class="input-group-text bg-white"><label class="add-on mb-0" for="location_au"><i class="fa fa-calendar"></i></label></div>
            </div>
        </div>
      </div>     
    </div>
    <div class="col-sm-12 col-lg pl-0">
      <label class="m-0 font-weight-bold"><?= __("Voyageurs") ?></label>
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
            <div class="py-3 row">
                <div class="col-9">
                    <label class="font-weight-normal" for=""><?= __("Animaux Acceptés") ?></label>
                </div>
                <label class="switch">
                    <input id="animaux" name="<?php echo $urlvaluemulti["animaux"]; ?>" type="checkbox">
                    <span class="slider round shadow-sm"></span>
                </label>
            </div>
            </div>
        </div>
      </div> 
      <!-- 
      <div class="d-flex">
        <input id="nbCouchage_ad" name="<?php echo $urlvaluemulti['nbCouchage_ad']; ?>" data-prefix="<?= __('Adultes') ?>" value="1" min="1" step="1" type="number" />
        <input id="nbCouchage_enf" name="<?php echo $urlvaluemulti['nbCouchage_enf']; ?>" data-prefix="<?= __('Enfants') ?>" value="0" min="0" step="1" type="number" />
      </div>       -->
    </div>
    <div class="col-sm-12 col-lg-1 p-0">
      <label class="m-0"></label>
      <button type="submit" class="p-1 m-0" id="recherchelogement"><?= __("Rechercher") ?></button>
    </div>
  </div>
    
  <?php echo $this->Form->end()?>
</div>