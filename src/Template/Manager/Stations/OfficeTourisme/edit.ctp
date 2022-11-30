<?php $this->start('cssTop'); ?>
    <style>
        .fileinput.input-group.fileinput-exists {
            overflow: hidden;
        }
        div.error-message{
            color: red;
        }
        div.hide{
            visibility: hidden;
        }
        div.valid-message{
            color: green;
        }
    </style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12">
      <h5 class="txt-dark">Modifier Office De Tourisme</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
                        <?=$this->Form->create($office,['id'=>'station','class'=> 'form-horizontal','onsubmit'=>"return validateMyForm();"]);?>
                        <?php //print_r($office); ?>
                        <?php if(!empty($office->invalid())): ?>
                          <div class="row">
                            <div class="col-sm-8">
                              <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="zmdi zmdi-block pr-15 pull-left"></i><p class="pull-left">Vérifier les données saisies.</p>
                                <div class="clearfix"></div>
                              </div>
                            </div>
                          </div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                  <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Type: <sup class='text-danger'>*</sup></label>
                                  <div class="col-sm-12">
                                      <?php echo $this->Form->select('type',$types,['id'=>'type','label'=>false,'class'=>'select2 form-control']);  ?>
                                      <?= $this->Form->isFieldError('type') ? $this->Form->error('type') : '';?>
                                  </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Nom: <sup class='text-danger'>*</sup></label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('nom',['type'=>'text','id'=>'nom','label'=>false,'class'=>'form-control']);  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Categorie Office: <sup class='text-danger'>*</sup></label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->select('categorie',$categories,['id'=>'categorie','label'=>false,'class'=>'form-control']);  ?>
                                        <?= $this->Form->isFieldError('categorie') ? $this->Form->error('categorie') : '';?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Site Internet:</label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('lien',['type'=>'text','id'=>'lien','label'=>false,'class'=>'form-control']);  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Code Postal: <sup class='text-danger'>*</sup></label>
                                  <div class="col-sm-12">
                                      <?php echo $this->Form->input('code_postal',['type'=>'text','id'=>'code_postal','label'=>false,'class'=>'form-control','required' => true]);  ?>
                                  </div>
                              </div>
                          </div>
                          <?php if($InfoGes['G']['role']!='gestionnaire'):?>
                          <div class="col-sm-6">
                            <div class="form-group">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Departement: <sup class='text-danger'>*</sup></label>
                            <div class="col-sm-12">
                                <?php echo $this->Form->select('departement_id',$departements,['id'=>'departement_id','label'=>false,'class'=>'select2 form-control','value'=>$office['village']['frville']['departement']['id']]);  ?>
                            </div>
                            </div>
                          </div>
                          <?php endif; ?>
                        </div>
                        <div class="row">
                          <?php if($InfoGes['G']['role']!='gestionnaire'):?>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">ville: <sup class='text-danger'>*</sup></label>
                                <div class="col-sm-12">
                                    <?php echo $this->Form->select('id_ville',$villes,['id'=>'id_ville','label'=>false,'class'=>'select2 form-control','value'=>$office['village']['frville']['id']]);  ?>
                                </div>
                                </div>
                            </div>
                          <?php endif; ?>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">village: <sup class='text-danger'>*</sup></label>
                                <div class="col-sm-12">
                                    <?php echo $this->Form->select('village_id',[null=>'Pas de village']+$villages,['id'=>'village_id','label'=>false,'class'=>'select2 form-control','required' => true]);  ?>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Adresse: <sup class='text-danger'>*</sup></label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('adresse',['type'=>'text','id'=>'adresse','label'=>false,'class'=>'form-control']);  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Adresse 2:</label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('adreesse2',['type'=>'text','id'=>'adreesse2','label'=>false,'class'=>'form-control']);  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ml-5">
                            <div class="row">
                                <label class="control-label mb-10 col-sm-2 col-lg-2 text-left font-16 txt-black">Position : <sup class='text-danger'>*</sup></label>
                            </div>
                            <div class="row mt-10">
                                <div class="col-sm-3 mt-60">
                                    <div class="row mb-20">
                                        <label class="control-label col-sm-4 col-md-4 text-left font-16 txt-black">Latitude</label>
                                        <div class="col-sm-8 col-md-8">
                                            <?php echo $this->Form->input('latitude',['type'=>'text','id'=>'lat','label'=>false,'class'=>'form-control','placeholder'=>"saisir latitude"]);  ?>
                                        </div>
                                    </div>
                                    <div class="row mb-20">
                                        <label class="control-label col-sm-4 col-md-4 text-left font-16 txt-black">Longitude</label>
                                        <div class="col-sm-8 col-md-8">
                                            <?php echo $this->Form->input('longitude',['type'=>'text','id'=>'lng','label'=>false,'class'=>'form-control','placeholder'=>"saisir longitude"]);  ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <button type="button" id="search_button" class="btn btn-warning btn-anim"><i class="fa fa-search"></i><span class="btn-text">Chercher</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <input id="searchmap" class="form-control" type="text" placeholder="Chercher une adresse"  style="width: 50%; margin: 10px 0px 0px 10px; height: 38px !important;">

                                    <div id="map-canvas" style="width: 100%; height: 400px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Email: </label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('email',['type'=>'email','id'=>'email','label'=>false,'class'=>'form-control']);  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Email pro:</label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('email_pro',['type'=>'email','id'=>'email_pro','label'=>false,'class'=>'form-control']);  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Téléphone:</label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('tel',['type'=>'text','id'=>'tel','label'=>false,'class'=>'form-control']);  ?>
                                        <div id="error-msgTel" class="error-message hide">Numéro invalide</div>
                                        <div id="valid-msgTel" class="valid-message hide">Numéro valide</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Portable: </label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('portable',['type'=>'text','id'=>'portable','label'=>false,'class'=>'form-control']);  ?>
                                        <div id="error-msg" class="error-message hide">Numéro invalide</div>
                                        <div id="valid-msg" class="valid-message hide">Numéro valide</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Telephonne pro:</label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('tel_pro',['type'=>'text','id'=>'tel_pro','label'=>false,'class'=>'form-control']); ?>
                                        <div id="error-msgTelPro" class="error-message hide">Numéro invalide</div>
                                        <div id="valid-msgTelPro" class="valid-message hide">Numéro valide</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Fax:</label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('telecopie',['type'=>'text','id'=>'telecopie','label'=>false,'class'=>'form-control']); ?>
                                        <div id="error-telecopie" class="error-message hide">Numéro invalide</div>
                                        <div id="valid-telecopie" class="valid-message hide">Numéro valide</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Skype:</label>
                                <div class="col-sm-12">
                                    <?php echo $this->Form->input('skype',['type'=>'text','id'=>'skype','label'=>false,'class'=>'form-control']);  ?>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="row mb-10">
                                <div class="col-sm-12 ml-30">
                                    <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <a href="<?php echo $this->Url->build('/',true);?>manager/OfficeTourisme/index" class="btn btn-default">Retour </a>
                                </div>
                                <div class="col-sm-offset-2 col-sm-3">
                                    <button type="submit" class="btn btn-success btn-anim"><i class="fa fa-save"></i><span class="btn-text">Enregistrer</span></button>
                                </div>
                            </div>
                        </div>
                        <?=$this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Select JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js", array('block' => 'scriptBottom')); ?>

<!-- Google map -->
<?php $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&libraries=places", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
<!-- Jasny-bootstrap CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$(".select2").select2();
var validtel =true;
var validtelPro = true;
var validtelCopie = true;
var validportable = true;
function validateMyForm(){
    $('#tel').val(telInputrestel.intlTelInput("getNumber"))
    $('#portable').val(mobileInputport.intlTelInput("getNumber"))
    $('#tel_pro').val(telInputrestelPro.intlTelInput("getNumber"))
    $('#telecopie').val(telInputrestelecopie.intlTelInput("getNumber"))
    if (validportable==false || validtel==false || validtelPro==false || validtelCopie==false) {
        if(validportable==false)
        {
            validMsgportable.addClass("hide");
            errorMsgportable.removeClass("hide");
        }
        if(validtel==false)
        {
            validMsgtel.addClass("hide");
            errorMsgtel.removeClass("hide");
        }
        if(validtelPro==false)
        {
            validMsgtelPro.addClass("hide");
            errorMsgtelPro.removeClass("hide");
        }
        if(validtelCopie==false)
        {
            validtelCopie.addClass("hide");
            errortelCopie.removeClass("hide");
        }
        return false
    }
    return true
}
errorMsgportable = $("#error-msg"),
validMsgportable = $("#valid-msg");
var mobileInputport = $("#portable");
mobileInputport.intlTelInput({
            utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
            initialCountry: 'fr',
            autoPlaceholder: true
            });
            var reset1 = function() {
                errorMsgportable.addClass("hide");
                validMsgportable.addClass("hide");
            };
            mobileInputport.blur(function() {
            reset1();
            if ($.trim(mobileInputport.val())) {
            if (mobileInputport.intlTelInput("isValidNumber")) {
                validMsgportable.removeClass("hide");
                validportable = true;
            } else {
                errorMsgportable.removeClass("hide");
                validportable = false;
            }
            }
        });
errorMsgtel = $("#error-msgTel"),
validMsgtel = $("#valid-msgTel");
var telInputrestel = $("#tel");
telInputrestel.intlTelInput({
            utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
            initialCountry: 'fr',
            autoPlaceholder: true
            });
            var reset2 = function() {
                errorMsgtel.addClass("hide");
                validMsgtel.addClass("hide");
            };
            telInputrestel.blur(function() {
            reset2();
            if ($.trim(telInputrestel.val())) {
            if (telInputrestel.intlTelInput("isValidNumber")) {
                validMsgtel.removeClass("hide");
                validtel = true;
            } else {
                validtel = false;
                errorMsgtel.removeClass("hide");
            }
            }
        });
errorMsgtelPro = $("#error-msgTelPro"),
validMsgtelPro = $("#valid-msgTelPro");
var telInputrestelPro = $("#tel_pro");
telInputrestelPro.intlTelInput({
            utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
            initialCountry: 'fr',
            autoPlaceholder: true
            });
            var reset3 = function() {
                errorMsgtelPro.addClass("hide");
                validMsgtelPro.addClass("hide");
            };
            telInputrestelPro.blur(function() {
            reset3();
            if ($.trim(telInputrestelPro.val())) {
            if (telInputrestelPro.intlTelInput("isValidNumber")) {
                validMsgtelPro.removeClass("hide");
                validtelPro = true;
            } else {
                validtelPro = false;
                errorMsgtelPro.removeClass("hide");
            }
            }
        });
validtelCopie = $("#valid-telecopie"),
errortelCopie = $("#error-telecopie");
var telInputrestelecopie = $("#telecopie");
telInputrestelecopie.intlTelInput({
            utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
            initialCountry: 'fr',
            autoPlaceholder: true
            });
            var reset4 = function() {
                errortelCopie.addClass("hide");
                validtelCopie.addClass("hide");
            };
            telInputrestelecopie.blur(function() {
            reset4();
            if ($.trim(telInputrestelecopie.val())) {
            if (telInputrestelecopie.intlTelInput("isValidNumber")) {
                validtelCopie.removeClass("hide");
                validtelCopie = true;
            } else {
                validtelCopie = false;
                errortelCopie.removeClass("hide");
            }
            }
        });
<?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
        $("body").removeAttr('class');
        $.toast({
            heading: 'Vous avez modifié Un Office',
            text: '',
            position: 'bottom-right',
            loaderBg:'#fec107',
            icon: 'success',
            hideAfter: 7000
        });
    <?php endif;?>
    <?php if(!empty($error_res)): ?>
        $.toast().reset('all');
        $("body").removeAttr('class');
        $.toast({
            heading: "Anomalie au moment de la modification du Office",
            text: '',
            position: 'bottom-right',
            loaderBg:'#fec107',
            icon: 'error',
            hideAfter: 7000
        });
    <?php endif;?>
  $("#departement_id").change(function() {
    $('body').loadingModal({
      position: 'auto',
      text: '',
      color: '#fff',
      opacity: '0.7',
      backgroundColor: 'rgb(0,0,0)',
      animation: 'doubleBounce'
    });
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
        data: {departementid: $(this).val()},
        success:function(xml){
          data = xml.listepville;
          $('#id_ville').empty();
          for (var i = 0; i < data.length; i++) {
              $('#id_ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
          }
          $('#id_ville').trigger('change')
          $('body').loadingModal('destroy');
        },error: function(){
          $('body').loadingModal('destroy');
        }
    });
  });

  $("#id_ville").change(function() {
    $('body').loadingModal({
      position: 'auto',
      text: '',
      color: '#fff',
      opacity: '0.7',
      backgroundColor: 'rgb(0,0,0)',
      animation: 'doubleBounce'
    });
    $.ajax({
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>/manager/village/getVillage/"+$(this).val(),
        success:function(data){
          $('#village_id').html('<option value>Pas de village</option>');
          for (var villeId in data) {
            $('#village_id').append('<option value=' + villeId + '>' + data[villeId].toLowerCase() + '</option>');
          }
          $('body').loadingModal('destroy');
        },error: function(){
          $('body').loadingModal('destroy');
        }
    });
  });

    //google map
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
              lat: <?=$office->latitude?$office->latitude:46.734255?>,
              lng: <?=$office->longitude?$office->longitude:2.418815?>
            },
            zoom:10,
        });

        var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));

        var input = document.getElementById('searchmap');
        
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);



        var marker = new google.maps.Marker({
            position: {
                lat: <?=$office->latitude?$office->latitude:46.734255?>,
                lng: <?=$office->longitude?$office->longitude:2.418815?>
            },
            map :map,
            draggable: true
        });

        google.maps.event.addListener(searchBox,'places_changed',function () {
            var places = searchBox.getPlaces();
            var bounds = new google.maps.LatLngBounds();
            var i,place;

            for(i=0;place=places[i];i++){
                bounds.extend(place.geometry.location);
                marker.setPosition(place.geometry.location);
            }

            map.fitBounds(bounds);
            map.setZoom(15);
        });
        function findcords() {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();
            //var country,region;
            //$.get("http://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng+"&sensor=false",function (data) {
            //    var resultat=data['results'][0];
             //   resultat['address_components'].forEach(function(comp) {
             //       if (comp['types']['0']=='country') country = comp['long_name'];
             //       if (typeof comp['types']['0'] != "undefined" && comp['types']['0']=='locality') region = comp['long_name'];
             //   });
             //   $('#lat').val(lat);     $('#lng').val(lng);
            //    $('#country').val(country);
            //    $('#adress').val(resultat['formatted_address']);
            //    $('#region').val(region);
                //console.log(resultat['formatted_address'],"country = "+country,"region = "+region);
            //});
            $('#lat').val(lat);     $('#lng').val(lng);
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
    //end google map
<?php $this->Html->scriptEnd(); ?>