<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="ti-settings  mr-10"></i> Configuration</span>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/pub">Publicités</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/packs/index">Packs De Services</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/parametrage/gps">Points GPS</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/index">Liste Des Gestionaires</a></li>
      <li class="active"><a href="#">Gestion Des Pages</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/cautions/index">Résidences de tourisme</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/stations/">Stations</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/vacances/">Vacances</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelmail">Gestion de modèles</a></li>
    </ul>
  </div>
</nav>

<div class="row icantSelectIt">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view mt-0 pt-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body mt-0 mb-0">
                    <div class="text-center button-list">
                        <a class="btn btn-<?php  if($this->request->getParam('pass')[0]=="8") echo 'success'; else echo 'default'?> mt-5 mr-0 ml-0" href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/8">Page D'accueil</a>
                        <a class="btn btn-<?php  if($this->request->getParam('pass')[0]=="12") echo 'success'; else echo 'default'?> mt-5 mr-0 ml-0" href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/12">Page Plan Station</a>
                        <a class="btn btn-<?php  if($this->request->getParam('pass')[0]=="10") echo 'success'; else echo 'default'?> mt-5 mr-0 ml-0" href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/10">Page Arc 1600</a>
                        <a class="btn btn-<?php  if($this->request->getParam('pass')[0]=="13") echo 'success'; else echo 'default'?> mt-5 mr-0 ml-0" href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/13">Page Arc 1800</a>
                        <a class="btn btn-<?php  if($this->request->getParam('pass')[0]=="14") echo 'success'; else echo 'default'?> mt-5 mr-0 ml-0" href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/14">Page Arc 1950</a>
                        <a class="btn btn-<?php  if($this->request->getParam('pass')[0]=="15") echo 'success'; else echo 'default'?> mt-5 mr-0 ml-0" href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/15">Page Arc 2000</a>
                        <a class="btn btn-<?php  if($this->request->getParam('pass')[0]=="16") echo 'success'; else echo 'default'?> mt-5 mr-0 ml-0" href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/16">Page BSM</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
        <?php
            echo $this->Form->create($registre,['url'=>'/manager/registres/pages/'.$registre->id,'id'=>'frm_periode','class'=> 'form-horizontal']);
            echo $this->Form->input("id")
        ?>
            <div class="form-group">
                <div class="col-lg-1 col-sm-0"></div>
                    <div class="col-lg-10 col-sm-12">
                        <textarea style="max-width: 100%" name="val" class="textarea_editor form-control" rows="15"><?php echo $registre->val ?></textarea>
                    </div>    
            </div>
            <div class="form-group mb-0">
                <div class="row">
                    <div class="text-center">
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
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Summernote Plugin JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/dist/summernote.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/lang/summernote-fr-FR.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<!-- Summernote css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/summernote/dist/summernote.css", array('block' => 'cssTop')); ?>


<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    $('.textarea_editor').summernote({
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
                                            ]
                        });
    $('.fa-pencil').attr('class','fa fa-code');
    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Texte modfier',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 7000
                        });
    <?php endif;?>
        
<?php $this->Html->scriptEnd(); ?>
    
<?php $this->start('cssTop'); ?>
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
    </style>
<?php $this->end(); ?>