<?php $this->start('cssTop'); ?>
    <style>
        .fileinput.input-group.fileinput-exists {
            overflow: hidden;
        }
        div.error-message{
            color: red;
        }
        .zoom{
            transition: transform .5s;
        }
        .zoom:hover {
            transform: scale(3);
        }
    </style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12">
      <h5 class="txt-dark">Modifier Massif</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
                        <?=$this->Form->create($massif,['type' => 'file','id'=>'frm_massif','class'=> 'form-horizontal']);?>
                        <div class="form-group row">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Nom: <sup class='text-danger'>*</sup></label>
                            <div class="col-sm-6">
                                <?php echo $this->Form->input('nom',['type'=>'text','id'=>'nom','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Nom À Utiliser Dans L'url: <sup class='text-danger'>*</sup></label>
                            <div class="col-sm-6">
                                <?php echo $this->Form->input('nom_url',['type'=>'text','id'=>'nom_url','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Description:</label>
                            <div class="col-sm-8">
                                <?= $this->Form->input("descreption",[
                                        'label'=>false,
                                        'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$massif->descreption.'</textarea >'],
                                        'type'=>'textarea','rows'=>'5',]);
                                ?>
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
                        <div class="form-group row">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Image:</label>
                            <div class="mb-10 col-sm-12 text-left font-12"><span>L'image sera enregistrée avec la taille (265 x 300)</span></div>
                            <div class="col-sm-6">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                    <input type="hidden"><?php echo $this->Form->file('image',['accept'=>'image/*']);?>
                                    </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a>
                                </div>
                                <?= $this->Form->isFieldError('image') ? $this->Form->error('image') : '';?>
                            </div>
                            <?php if($massif->image != ""){ ?>
                            <div style="text-align: center" class="col-sm-6">
                                <h5>Ancienne Image</h5>
                                <img class="zoom" height="100" width="100" src="<?= $this->Url->build('/',true)?>img/uploads/<?= $massif->image;?>">
                            </div>
                            <?php } ?>
                        </div> 

                        
                        <div class="form-group row">
                          <div class="col-sm-6">
                            <label class="mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Image header été <?php if($massif->image_header_ete == "") echo "<sup class='text-danger'>*</sup>"; ?> :</label>
                            <div class="mb-10 col-sm-12 text-left font-12"></div>
                            <div class="col-sm-12">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                    <input type="hidden"><?php 
                                      if($massif->image_header_ete != "") echo $this->Form->file('image_header_ete',['accept'=>'image/*']);
                                      else echo $this->Form->file('image_header_ete',['accept'=>'image/*', 'required']);
                                    ?>
                                    </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a>
                                </div>
                                <?= $this->Form->isFieldError('image_header_ete') ? $this->Form->error('image_header_ete') : '';?>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <label class="mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Image header hiver <?php if($massif->image_header_hiver == "") echo "<sup class='text-danger'>*</sup>"; ?> :</label>
                            <div class="mb-10 col-sm-12 text-left font-12"></div>
                            <div class="col-sm-12">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                    <input type="hidden"><?php 
                                      if($massif->image_header_hiver != "") echo $this->Form->file('image_header_hiver',['accept'=>'image/*']);
                                      else echo $this->Form->file('image_header_hiver',['accept'=>'image/*', 'required']);
                                    ?>
                                    </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a>
                                </div>
                                <?= $this->Form->isFieldError('image_header_hiver') ? $this->Form->error('image_header_hiver') : '';?>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <?php if($massif->image_header_ete != ""){ ?>
                            <h5>Ancienne Image header été</h5>
                            <img height="200" width="100%" src="<?= $this->Url->build('/',true)?>images/header_massif/<?= $massif->image_header_ete;?>">
                            <?php } ?>
                          </div>
                          <div class="col-sm-6">
                            <?php if($massif->image_header_hiver != ""){ ?>
                            <h5>Ancienne Image header hiver</h5>
                            <img height="200" width="100%" src="<?= $this->Url->build('/',true)?>images/header_massif/<?= $massif->image_header_hiver;?>">
                            <?php } ?>
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
                                    <a href="<?php echo $this->Url->build('/',true);?>manager/massif/index" class="btn btn-default">Retour </a>
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

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
<!-- Jasny-bootstrap CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css", array('block' => 'cssTop')); ?>
<!-- Google map -->
<?php $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&libraries=places", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
<?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
        $("body").removeAttr('class');
        $.toast({
            heading: 'Massif modifié',
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
            heading: "Anomalie au moment de la modification du Massif",
            text: '',
            position: 'bottom-right',
            loaderBg:'#fec107',
            icon: 'error',
            hideAfter: 7000
        });
    <?php endif;?>
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
              lat: <?=$massif->latitude?$massif->latitude:46.734255?>,
              lng: <?=$massif->longitude?$massif->longitude:2.418815?>
            },
            zoom:10,
        });

        var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));

        var input = document.getElementById('searchmap');
        
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);



        var marker = new google.maps.Marker({
            position: {
                lat: <?=$massif->latitude?$massif->latitude:46.734255?>,
                lng: <?=$massif->longitude?$massif->longitude:2.418815?>
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