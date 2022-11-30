<?php //$this->Html->script("/js/jquery-1.11.3.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/dropzone.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/bootstrap-imageupload.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/css/general.css", array('block' => 'cssTop')); ?>
<?php //$this->Html->css("/css/update.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/bootstrap-imageupload.css", array('block' => 'cssTop')); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div class="container">
<div class="row bg-light no-gutters mb-4 mt-n3" >
<div class="col-sm-6 col-lg-3 list-steps">
<a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/edit/<?php echo $annonce_id ?>"><span class="d-block text-center ann-step">1. <?= __("Informations") ?></span></a>
</div>
<div class="col-sm-6 col-lg-3 list-steps">
<span class="d-block text-center ann-step active-steps">2. <?= __("Images") ?></span>
</div>
<div class="col-sm-6 col-lg-3 list-steps">
<a  href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['dispos']; ?>/view/<?php echo $annonce_id ?>'><span class="d-block text-center ann-step after-active-steps">3. <?= __("Tarification") ?></span></a>
</div>
<div class="col-sm-6 col-lg-3 list-steps">
<a  href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/".$urlvaluemulti['previsualiser']; ?>/<?php echo $annonce_id ?>'><span class="d-block text-center text-lg-right text-xl-center ann-step">4. <?= __("Prévisualisation") ?></span></a>
</div>
</div><!-- end row -->
<div class="row">
<div class="col-md-12">
<?php echo $this->Flash->render() ?>
<div class="header_title bg-light">
<h5 class="mb-2 mt-2 py-2 px-3"><?= __("Ajouter des photos") ?></h5>
</div><!-- header_title-->
</div> <!--end col-md-12-->
</div> <!--end row-->

<?php if($annonce_id){ ?>
    <!-- bootstrap-imageupload. -->
    
    <div class="row mt-3">
        <div class="col-md-6">
        <img src="<?php echo $this->Url->build('/',true) ?>images/ajax-loader.gif" id="loading-indicator" style="display:none" />
        <?php $first = $photos->where(["Photos.numero=1"])->first();
                           if($first){
                            $url = $this->Url->build('/',true)."images_ann/".$annonce_id."/vignette-".$annonce_id."-1.P.jpg?v=".(time()*1000);   ?>
                            <!-- <img src="<?php echo $url ?>" alt="" class="thumbnail" id="imagepremier"> -->
                            <div class="imageupload panel panel-default" style="background:url(<?php echo $url ?>) no-repeat center #e8e8e8;background-size:cover;">
                           <?php }else{ ?>
                     <div class="imageupload panel panel-default" style="background:url(<?php echo $this->Url->build("/")?>images/img-notfound.jpg) no-repeat center #e8e8e8">
                     <?php } ?>
                         <div class="file-tab panel-body">
                           <form id="formImage" method="post" action="<?php echo $this->Url->build("/")?>photos/uploadnumberone"  ENCTYPE="multipart/form-data">
                             <label class="btn btn-file">
                                 <!-- The file is stored here. -->
                                 <input type="file" name="image-file">
                                 <input type="hidden" name="idAnnonce" value="<?php echo $annonce_id ?>" />
                             </label>
                             <div style="display: none" class="aploadpro">
                               <select class="form-control" size="1" name="pronumber">
                                 <option value="<?php echo $annonce_id ?>" selected></option>
                               </select>
                             </div>
                             <?php if($first){ ?>
                             <button type="button" id="supprimeone" class="btn"><i class="fa fa-trash-o mr-1"></i><?= __("Supprimer") ?></button>
                             <?php }else{ ?>
                                <button type="button" id="supprimeone" class="btn" style="display:none"><i class="fa fa-trash-o mr-1"></i><?= __("Supprimer") ?></button>
                             <?php } ?>
                            </form>
                         </div>
                     </div>
        </div>
    <div class="col-md-6">
    <div id="dropzone" class="h-100">
    <form action="<?php echo $this->Url->build("/")?>photos/uploadnew"  class="dropzone h-100" id="my">
    <div class="fallback">
    <input type="file" name="file" multiple="" />
    <input type="hidden" name="idAnnonce" value="<?php echo $annonce_id ?>" />
    </div>
    <div style="display: none" class="aploadpro">
    <select id="pronumber" class="form-control" size="1" name="pronumber">
    <option value="<?php echo $annonce_id ?>" selected></option>
    </select>
    </div>
    </form>
    </div>
    </div>
    </div>  
    
    <?php } ?>
    
    <div class="row mt-3">
    <div class="col-md-12">
        <p><?= __("Ajoutez jusqu'à 20 images pour illustrer votre annonce (Format JPEG | Taille maximum des photos 10 MO | Les dimensions minimales pour une photo sont de 700px x 525px | Résolution minimale : 72 Pixels | Format paysage : 4:3 ou 16:9)") ?></p>
        <p class="font-weight-bold font-italic"><?= __("Attention, il est interdit de communiquer des adresses mail, références à d'autres sites internet ou numéros de téléphone dans les images.") ?></p>
    </div>
</div>             
<?php if($annonce_id){ ?>
    <div class="row mt-4 justify-content-end">
        <div class="col-auto">
            <?php echo $this->Form->create(null,["url"=>"/dispos/view/$annonce_id"]);?>
            <button class="btn btn-blue text-white rounded-0 px-6"><?= __("Enregistrer") ?></button>
            <?php echo $this->Form->end()?>
        </div>
    </div>
<?php } ?>
<!-- Passage à l'écran suivant -->
<?php $valeur = $annonce_id.":".$creation;?>
</div>
        
        
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
     var form = $('#formImage').get(0);
     var formData = new FormData(form);
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

        $(document).ready(function(){
            var $imageupload = $('.imageupload');
            $imageupload.imageupload();
        });
                        
            Dropzone.options.my = {
                addRemoveLinks: true,
                acceptedFiles: "image/jpeg",
                maxFilesize: 10, //MB
                maxFiles: 19,
                parallelUploads: 1,
                dictDefaultMessage: "<i class='fa fa-plus'></i><br><?php echo __("Ajouter photo"); ?>",
                init: function(){
                    var thisDropzone = this;
                    $.ajax({
                        url: "<?php echo $this->Url->build("/")?>photos/getId",
                        type: 'POST',
                        dataType : 'json',
                        data: {id: <?php echo $annonce_id ?> },
                        success: function(rest){
                            
                            $.each(rest.tab, function(key, value){
                                //console.log(key + ": " +rest.tab[key].id);
                                var name = "vignette-"+<?php echo $annonce_id ?>+"-"+rest.tab[key].numero;
                                var mockfile = {
                                    name: name,
                                    id: rest.tab[key].id,
                                };
                                thisDropzone.options.addedfile.call(thisDropzone,mockfile);
                                thisDropzone.files.push(mockfile);
                                thisDropzone.options.thumbnail.call(thisDropzone,mockfile,"<?php echo $this->Url->build('/',true)?>images_ann/"+<?php echo $annonce_id ?>+"/"+name+".jpg?v=<?php echo (time()*1000); ?>");
                            });
                            
                            
                        }
                    });
                    
                    
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
                        
                        //var _ref;
                        //return (_ref = file.previewElement) !== null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                        
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
        
        
        <?php $this->Html->scriptEnd(); ?>
