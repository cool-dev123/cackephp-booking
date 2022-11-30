<?php $this->start('cssTop'); ?>
    <style>
        .fileinput.input-group.fileinput-exists {
            overflow: hidden;
        }
        div.error-message{
            color: red;
        }
    </style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12">
      <h5 class="txt-dark">Piste</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap col-sm-12 col-xs-12">
                        <?=$this->Form->create($rm,['type' => 'file','id'=>'rm','class'=> 'form-horizontal']);?>
                        <?php if(!empty($rm->invalid())): ?>
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
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Nom (Domaine skiable): <sup class='text-danger'>*</sup></label>
                                <?php echo $this->Form->input('nom',['type'=>'text','id'=>'nom','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Type: <sup class='text-danger'>*</sup></label>
                                <?php echo $this->Form->input('type',['type'=>'text','id'=>'type','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Société de Remonté Mécanique: <sup class='text-danger'>*</sup></label>
                                <?php echo $this->Form->input('societe_RM',['type'=>'text','id'=>'societe_RM','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <?php if($this->request->session()->read("Gestionnaire.info")['G']['role']!='gestionnaire'): ?>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Massif: <sup class='text-danger'>*</sup></label>
                                <?php echo $this->Form->select('massif_id',$massifs,['id'=>'massif_id','label'=>false,'class'=>'select2 form-control']);  ?>
                                <?= $this->Form->isFieldError('massif_id') ? $this->Form->error('massif_id') : '';?>
                            </div>
                            <?php endif;?>
                            <div class="col-sm-6">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Station: <sup class='text-danger'>*</sup></label>
                                <?= $this->Form->select('lieugeos[]',$lieugeos,['multiple','id'=>'lieugeos','label'=>false,'class'=>'select2 select2-multiple', 'required']);  ?>                            
                                <?php //echo $this->Form->select('lieugeo_id',$lieugeos,['id'=>'lieugeo_id','label'=>false,'class'=>'select2 form-control']);  ?>
                                <?= $this->Form->isFieldError('lieugeos') ? $this->Form->error('lieugeos') : '';?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Pistes vertes: <sup class='text-danger'>*</sup></label>
                                <?php echo $this->Form->input('nbrpistes_verte',['type'=>'number','id'=>'nbrpistes_verte','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Pistes bleus: <sup class='text-danger'>*</sup></label>
                                <?php echo $this->Form->input('nbrpistes_bleu',['type'=>'number','id'=>'nbrpistes_bleu','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Pistes rouges: <sup class='text-danger'>*</sup></label>
                                <?php echo $this->Form->input('nbrpistes_rouge',['type'=>'number','id'=>'nbrpistes_rouge','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Pistes noires: <sup class='text-danger'>*</sup></label>
                                <?php echo $this->Form->input('nbrpistes_noir',['type'=>'number','id'=>'nbrpistes_noir','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left pl-0 font-16 txt-black">Km de pistes: <sup class='text-danger'>*</sup></label>
                                <?php echo $this->Form->input('km_pistes',['type'=>'number','id'=>'km_pistes','label'=>false,'class'=>'form-control']);  ?>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label mb-10 mt-10 col-sm-12 text-left pl-0 font-16 txt-black">Prix Journé <?=date('Y')?>: <sup class='text-danger'>*</sup></label>
                                <div class="input-group mb-15">
                                    <?php echo $this->Form->input('anne_lieugeos.0.prixJourne',['type'=>'number','id'=>'prixJourne','label'=>false,'class'=>'form-control','error'=>false]);  ?>
                                    <span class="input-group-addon"><i class="fa fa-euro"></i></span>
                                </div>
                                <?= $this->Form->isFieldError('anne_lieugeos.0.prixJourne') ? $this->Form->error('anne_lieugeos.0.prixJourne') : '';?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Description:</label>
                            <div class="col-sm-12">
                                <?= $this->Form->input("descreption",[
                                        'label'=>false,
                                        'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$rm->descreption.'</textarea >'],
                                        'type'=>'textarea','rows'=>'5',]);
                                ?>
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
                                    <a href="<?php echo $this->Url->build('/',true);?>manager/Rmecanique/index" class="btn btn-default">Retour </a>
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
<!-- Jasny-bootstrap CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$(".select2").select2();
$("#massif_id").change(function() {
    if($(this).val()!=null)
    $.ajax({
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>manager/massif/getStations/"+$(this).val(),
        success:function(data){
        $('#lieugeos').empty();
        for (var stationId in data) {
            $('#lieugeos').append('<option value=' + stationId + '>' + data[stationId].toLowerCase() + '</option>');
        }
        }
    });
});
<?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
        $("body").removeAttr('class');
        $.toast({
            heading: 'Vous avez crée Une Remonté Mecanique',
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
            heading: "Anomalie au moment de l'enregistrement du Remonté Mecanique",
            text: '',
            position: 'bottom-right',
            loaderBg:'#fec107',
            icon: 'error',
            hideAfter: 7000
        });
    <?php endif;?>
<?php $this->Html->scriptEnd(); ?>