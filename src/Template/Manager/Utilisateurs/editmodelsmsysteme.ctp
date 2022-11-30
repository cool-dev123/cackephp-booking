<?php $this->start('cssTop') ?>
    <style>
        .note-group-select-from-files {
            display: none;
        }
        .modal-body{
            margin-left:10px !important;
            margin-right:10px !important;
        }
        .note-btn{
            padding:10px !important;
        }
        .note-editable b, .note-editable strong { font-weight: bold; }
        .note-editable i { font-style: italic; }
        .note-editable ul { list-style: circle !important; }
        
        span.bootstrap-switch-handle-on.bootstrap-switch-primary {
            background-color: blue !important;
        }
        span.bootstrap-switch-handle-off.bootstrap-switch-default {
            background-color: red !important;
            color: white !important;
        }
        div#myTabContent {
            border: 1px solid darkgrey;
        }
    </style>
<?php $this->end() ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h5 class="txt-dark">Modifier modele sms système</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
                    
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="panel panel-info card-view">
                                <div class="panel-heading icantSelectIt">
                                        <div class="pull-left">
                                                <h6 class="panel-title txt-light">Attention</h6>
                                        </div>
                                        <div class="clearfix"></div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                        <div class="panel-body">
                                        <?php
                                            if($modelmessage->titre == "expirationdemandereservation24h"){
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{reservation}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre sms. </span>";
                                              }elseif ($modelmessage->titre == "expirationdemandereservation4h"){
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{reservation}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre sms. </span><br>";
                                              }elseif ($modelmessage->titre == "verifierCommandePourProprietaire"){
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre sms. </span><br>";
                                              }elseif ($modelmessage->titre == "confirmationDemandeReservationLoc"){
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre sms. </span><br>";
                                              }elseif ($modelmessage->titre == "acceptationReservationClt"){
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{reservation}}, {{datedebut}}, {{datefin}}, {{station}}, {{frais_menage}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre sms. </span><br>";
                                              }elseif ($modelmessage->titre == "refusReservationClt"){
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{reservation}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre sms. </span><br>";
                                              }elseif ($modelmessage->titre == "creationReservationExpiration"){
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}, {{reservation}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre sms. </span><br>";
                                              } elseif ($modelmessage->titre == "annulationreservationprop"){
                                                echo "Les variables dynamiques sont : {{prenomprop}}, {{nomprop}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre sms. </span><br>";
                                              } elseif ($modelmessage->titre == "completerInventaireLoc"){
                                                echo "Les variables dynamiques sont : {{lien}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre sms. </span><br>";
                                              } elseif ($modelmessage->titre == "inventaireRempliProp"){
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}} .<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre sms. </span><br>";
                                              } elseif ($modelmessage->titre == "creationReservationExpirationProp"){
                                                echo "Les variables dynamiques sont : {{prenom}}, {{nom}}, {{debut}}, {{fin}}.<br> <span class='red'>Veuillez garder la même forme donnée audessus dans le corp de votre sms. </span><br>";
                                              }                                     
                                              
                                              ?>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php
                  echo $this->Form->create($modelmessage,['url'=>'/manager/utilisateurs/editmodelsmsysteme/'.$modelmessage->id,'id'=>'frm_periode','class'=> 'form-horizontal']);
                  echo $this->Form->input('id');
                  echo $this->Form->hidden('destinataire',['value'=>$modelmessage->destinataire]);
                  ?>
                <div class="form-group">
                    <label id="txtmessage" class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Indication: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-10 col-sm-10">
                        <textarea type="" name="indication" rows="3" cols="120" id="indication"><?php echo $modelmessage->indication ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Titre: <sup class='text-danger'>*</sup></label>
                    <div class="col-lg-4 col-sm-10">
                        <?php echo $this->Form->input('titre',['type'=>'text','id'=>'titre','label'=>false,'class'=>'form-control','readonly']);  ?>
                    </div>
                </div>
                <div  class="pills-struct mt-40">
                    <ul role="tablist" class="nav nav-pills" id="myTabs_6">
                        <li class="active" role="presentation"><a aria-expanded="true"  data-toggle="tab" role="tab" id="home_tab_6" href="#FR">Français</a></li>
                        <li role="presentation" class=""><a  data-toggle="tab" id="profile_tab_6" role="tab" href="#EN" aria-expanded="false">Anglais</a></li>
                    </ul>
                    <div class="tab-content pa-10" id="myTabContent">
                        <div  id="FR" class="tab-pane fade active in" role="tabpanel">
                           <div class="form-group">
                               <label id="txtmessage" class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Texte en français: <sup class='text-danger'>*</sup></label>
                               <div class="col-lg-10 col-sm-12">
                                   <textarea class="textarea_editor form-control" type="" name="txtsms" rows="5" id="txtsms"><?php echo $modelmessage->txtsms ?></textarea>
                               </div>
                           </div>
                        </div>
                        <div id="EN" class="tab-pane fade" role="tabpanel">
                           <div class="form-group">
                               <label id="txtmessage" class="control-label mb-10 col-sm-2 text-left font-16 txt-black">Texte en anglais: <sup class='text-danger'>*</sup></label>
                               <div class="col-lg-10 col-sm-12">
                                   <textarea class="textarea_editor form-control" type="" name="txtsmsEn" rows="5" id="txtsmsEn"><?php echo $modelmessage->txtsmsEn ?></textarea>
                               </div>
                           </div>
                        </div>
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
                            <a href="<?php echo $this->Url->build('/',true);?>manager/utilisateurs/modelsmsysteme" class="btn btn-default">Retour </a>
                        </div>
                        <div class="col-sm-offset-8 col-sm-2">
                            <button type="submit" class="btn btn-success btn-anim"><i class="fa fa-save"></i><span class="btn-text">Enregistrer</span></button>
                        </div>
                        <?php   echo $this->Form->end();    ?>    
                        <!-- <div class="col-sm-6">
                            <form class="form-inline" action="/action_page.php">
                              <input type="text" class="form-control" id="sms" placeholder="Exp: +33612345678">
                              <button type="button" class="btn btn-primary" id="maildetest">Envoyer un sms de test</button>
                            </form>
                        </div> -->
                    </div>
                </div>                              
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Summernote Plugin JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/dist/summernote.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/lang/summernote-fr-FR.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<!-- Summernote css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/summernote/dist/summernote.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    /*$('.textarea_editor').summernote({
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
                                    ['fullscreen',['fullscreen']],
                                    ['codeview',['codeview']],
                                    ['undo',['undo']],
                                    ['redo',['redo']],
                                            ]
                        });*/
                        
    $("#frm_periode").validate({
	rules: {
                indication :{
                    required: true,
                },
                sujet: {
                    required: true,
                },
                sujetEn: {
                    required: true,
                },
	},
        lang: 'fr',
    });
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Votre Modèle a été modifié',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 7000
                        });
    <?php endif;?>
     $("#maildetest").click(function(){
      if($("#sms").val() != ''){
        if($("#FR").hasClass("active")){
          langue = "FR";
        }else{
          langue = "EN";
        }
        $.ajax({
          type: "POST",
          dataType : 'json',
          async: false,
          url: "<?php echo $this->Url->build('/',true)?>manager/utilisateurs/envoyersmsdetest/",
          data: {email: $("#sms").val(), titre: $("#titre").val(), langue: langue},
          success:function(xml){
            $("#sms").val("");
            if(xml.msgretour == 'OK'){
                $.toast({
                    heading: 'Votre Modèle a été envoyé',
                    text: '',
                    position: 'bottom-right',
                    loaderBg:'#fec107',
                    icon: 'success',
                    hideAfter: 7000
                });
            }else{
                $.toast({
                    heading: 'Vérifier le numéro saisi',
                    text: '',
                    position: 'bottom-right',
                    loaderBg:'#fec107',
                    icon: 'error',
                    hideAfter: 7000
                });
            }
            
          }
        });
      }
      
     }); 
<?php $this->Html->scriptEnd(); ?>