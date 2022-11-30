<style>
    .fileinput.input-group.fileinput-exists {
        overflow: hidden;
    }
    div.error-message{
        color: red;
    }
</style>

<div class="row heading-bg icantSelectIt">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h5 class="txt-dark">Ajouter un point GPS</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
        <?php
                  echo $this->Form->create(null,['type' => 'file','url'=>'/manager/parametrage/gps/add','id'=>'frm_periode','class'=> 'form-horizontal']);
				 ?>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-3 col-lg-2 text-left font-16 txt-black">Titre : <sup class='text-danger'>*</sup></label>
                            <div class="col-lg-3 col-sm-9">
                                <?php echo $this->Form->input('name',['id'=>'name','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-3 col-lg-2 text-left font-16 txt-black">Bibliothèque : <sup class='text-danger'>*</sup></label>
                            <div class="col-lg-3 col-sm-7 col-xs-8 col-md-8">
                                <select name="bibliotheque_id" class="form-control" id="biblio">
                                    <?php foreach($bibliotheques as $bibliotheque):?>
                                        <option data-image="<?php echo $bibliotheque->image ?>" value="<?php echo $bibliotheque->id ?>" ><?php echo $bibliotheque->name ?></option> 
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-2 col-xs-2 col-md-2">
                                <img id="thumb" style="border-radius: 5px;" >
                            </div>
                      </div>
                        <div class="form-group nameurldiv" style="display:none;">
                            <label class="control-label mb-10 col-sm-3 col-lg-2 text-left font-16 txt-black">Nom À Utiliser Dans L'url: : <sup class='text-danger'>*</sup></label>
                            <div class="col-lg-3 col-sm-9">
                                <?php echo $this->Form->input('name_url',['id'=>'name_url','label'=>false,'class'=>'form-control']);  ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 col-lg-2 text-left font-16 txt-black">Position : <sup class='text-danger'>*</sup></label>
                            <div class="row">
                                <div class="col-sm-4 form-group row">
                                    <label class="control-label col-sm-4 col-md-4 text-left font-16 txt-black">Latitude</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input id="lat" name="latitude" class="form-control" type="text" placeholder="saisir latitude">
                                    </div>
                                </div>
                                <div class="col-sm-4 form-group row">
                                    <label class="control-label col-sm-4 col-md-4 text-left font-16 txt-black">Longitude</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input id="lng" name="longitude" class="form-control" type="text" placeholder="saisir longitude">
                                    </div>
                                </div>
                                <div class="col-sm-2 form-group row">
                                    <div class="col-sm-12">
                                        <button type="button" id="search_button" class="btn btn-warning btn-anim"><i class="fa fa-search"></i><span class="btn-text">Chercher</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 col-lg-offset-2 col-sm-offset-2 col-sm-10">
                                <input id="searchmap" class="form-control" type="text" placeholder="Chercher une adresse"  style="width: 50%; margin: 10px 0px 0px 10px; height: 38px !important;">

                                <div id="map-canvas" style="width: 100%; height: 400px"></div>
                            </div>
                        </div>
                        <!--MAP-->
                        <div class="form-group">
                            <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Village : <sup class='text-danger'>*</sup></label>
                            <div class="col-lg-3 col-sm-10">
                                <select name="id_village" class="form-control" id="id_village">
                                    <?php foreach($villages as $village):?>
					                            <option value="<?php echo $village->id ?>" ><?php echo $village->name ?></option> 
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <!-- Image header -->
                        <div class="form-group row mt-20 imageheaderdiv" style="display:none;">
                          <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Image header : </label>
                          <div class="col-lg-6 col-sm-10">
                              <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                  <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                  <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                  <input type="hidden"><?php echo $this->Form->file('image_header',['accept'=>'image/*']);?>
                                  </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a>
                              </div>
                              <?= $this->Form->isFieldError('image_header') ? $this->Form->error('image_header') : '';?>
                          </div>
                        </div>
                                 <div class="form-group mb-0">
                                     <div class="row mb-10">
                                        <div class="col-sm-12 ml-10">
                                            <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                                        </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <a href="<?php echo $this->Url->build('/',true);?>manager/parametrage/gps/" class="btn btn-default">Retour </a>
                                            </div>
                                            <div class="col-sm-offset-2 col-sm-2">
                                                <button type="submit" class="btn btn-success btn-anim"><i class="fa fa-save"></i><span class="btn-text">Enregistrer</span></button>
                                            </div>
                                        </div>
                                </div>
				<?php
				 echo $this->Form->end();
                ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Google map -->
<?php $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&libraries=places", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$( document ).ready(function() {
        var value = $( "#biblio option:first" ).attr("data-image");
        $('#thumb').attr("src","<?php echo $this->Url->build('/',true)?>images/"+value);
    });
    $('#biblio').change(function(){
        var value = $( "#biblio option:selected" ).attr("data-image");
        $('#thumb').attr("src","<?php echo $this->Url->build('/',true)?>images/"+value);
        if($(this).val() == 1){
          $(".imageheaderdiv").css("display", "block");
          $(".nameurldiv").css("display", "block");          
        }else{
          $(".imageheaderdiv").css("display", "none");
          $(".nameurldiv").css("display", "none");
        } 
    });
    $("#frm_periode").validate({
	rules: {
		name: {
                    required: true,
		},
    name_url: {
                    required: true,
		},
                latitude: {
                    required: true,
                },
                longitude: {
                    required: true,
                }       
	},
        lang: 'fr',
    });
    
    
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Un nouveau point GPS a été créé',
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
                            heading: 'Il faut remplir tous les champs!',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 7000
                        });
    <?php endif;?>
                        
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

        var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));

        var input = document.getElementById('searchmap');
        
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);



        var marker = new google.maps.Marker({
            position: {
                lat: 46.734255,
                lng: 2.418815
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
<?php $this->Html->scriptEnd(); ?>
