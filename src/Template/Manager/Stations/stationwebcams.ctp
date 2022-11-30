<?php $this->start('cssTop'); ?>
    <style>
        .check-circle{ color:green; font-size: 20px; }
        .exclamation-circle{ color:red; font-size: 20px; }
        .heading-bg {
            height: 100% !important;
        }
        div.error-message{
            color: red;
        }
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="ti-settings  mr-10"></i> Configuration</span>
    </div>
    <ul class="nav navbar-nav">
    <?php if($InfoGes['G']['role']!='gestionnaire'):?>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/pub">Publicités</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/packs/index">Packs De Services</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/parametrage/gps">Points GPS</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/index">Liste Des Gestionaires</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/8">Gestion Des Pages</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/cautions/index">Résidences de tourisme</a></li>
      <?php endif; ?>
      <li class="active"><a href="#">Stations</a></li>
      <?php if($InfoGes['G']['role']!='gestionnaire'):?>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/vacances/">Vacances</a></li>
      <?php endif; ?>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelmail">Gestion de modèles</a></li>
    </ul>
  </div>
</nav>

<?=
    $this->element('stationsmenu');
?>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left mt-10">
                        <h6 class="panel-title txt-dark">Webcams pour la station <?=$lieugeo->name?></h6>
                </div>
                <div class="button-list pull-right">
                    <button onclick="addWebcam()" class="btn btn-primary pull-right">Ajouter Webcam</button>
                </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <table id="datable_1" class="table table-hover display  pb-30" >
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Etat</th>
                                    <th>Url</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nom</th>
                                    <th>Etat</th>
                                    <th>Url</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </tfoot>
                            <tbody>

                            </tbody>
                        </table>
                        <br>
                        <a href="<?php echo $this->Url->build('/',true);?>manager/stations/index" class="btn btn-default ml-10">Retour</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.modal -->
<div id="modal-addWebcam" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title">Ajouter webcam</h5>
            </div>
            <div id="modal-body" class="modal-body">
                <form id="addWebcam-form">
                    <div class="form-group row">
                        <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Nom: <sup class='text-danger'>*</sup></label>
                        <div class="col-sm-12 mb-20">
                            <?php echo $this->Form->input('nom',['type'=>'text','id'=>'nom','label'=>false,'class'=>'form-control']);  ?>
                            <div id="nomError" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Url : <sup class='text-danger'>*</sup></label>
                        <div class="col-sm-12 mb-20">
                        <?php echo $this->Form->input('url',['type'=>'text','id'=>'url','label'=>false,'class'=>'form-control']);  ?>
                            <div id="urlError" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Etat : <sup class='text-danger'>*</sup></label>
                        <div class="col-sm-12 mb-20">
                        <?php echo $this->Form->select('etat',[1=>'Fonctionnelle',0=>'Non Fonctionnelle'],['id'=>'etat','label'=>false,'class'=>'form-control']);  ?>
                            <div id="etatError" class="error-message"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button id="saveWebcam" type="button" class="btn btn-danger">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    var edit=0;
    $(".select2").select2();
    var table;
    var villageId;
    function addWebcam(){
        $('#modal-addWebcam').modal('toggle');
        $('#modal-addWebcam').modal('show');
        $('#addWebcam-form')[0].reset();
        $('#nomError').hide(); $('#urlError').hide(); $('#etatError').hide();
        edit=0;
    }
    $('#saveWebcam').click(function(){
        $('#nomError').hide(); $('#urlError').hide(); $('#etatError').hide();
        $('body').loadingModal({
                position: 'auto',
                text: '',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'doubleBounce'
        });
        if(edit==0){
            var heading='Vous avez ajouté une webcam';
            var url="<?php echo $this->Url->build('/',true)?>/manager/stations/addwebcam/<?=$lieugeo->id?>";
        }
        else{
            var heading='Vous avez modifié une webcam';
            var url=edit;
        }
        $.ajax({
            type: "post",
            url: url,
            data :{
                nom:$('#nom').val(),
                url:$('#url').val(),
                etat:$('#etat').val(),
            },
            success:function(data){
                $('body').loadingModal('destroy');
                if(data.res=='error')
                {
                    firstProp="";
                    for(var key in data.errors.nom) {
                        if(data.errors.nom.hasOwnProperty(key)) {
                            firstProp = data.errors.nom[key];
                            break;
                        }
                    }
                    $('#nomError').show().html(firstProp)

                    firstProp="";
                    for(var key in data.errors.url) {
                        if(data.errors.url.hasOwnProperty(key)) {
                            firstProp = data.errors.url[key];
                            break;
                        }
                    }
                    $('#urlError').show().html(firstProp)

                    firstProp="";
                    for(var key in data.errors.etat) {
                        if(data.errors.etat.hasOwnProperty(key)) {
                            firstProp = data.errors.etat[key];
                            break;
                        }
                    }
                    $('#etatError').show().html(firstProp)
                }
                else if(data=='webcam added')
                {
                    edit=0
                    table.ajax.reload();
                    $('#modal-addWebcam').modal('toggle');
                    $('#modal-addWebcam').modal('hide');
                    $.toast().reset('all');
                    $("body").removeAttr('class');
                    $.toast({
                        heading: heading,
                        text: '',
                        position: 'bottom-right',
                        loaderBg:'#fec107',
                        icon: 'success',
                        hideAfter: 7000
                    });
                }
            },
            error: function(){
                $('body').loadingModal('destroy');
                $.toast().reset('all');
                $("body").removeAttr('class');
                $.toast({
                    heading: 'Erreur',
                    text: '',
                    position: 'bottom-right',
                    loaderBg:'#fec107',
                    icon: 'error',
                    hideAfter: 4000
                });
            }
        });
    });
    $(document).on('click', ".editWebcam", function () {
        edit=$(this).attr("data-href");
        $('#modal-addWebcam').modal('toggle');
        $('#modal-addWebcam').modal('show');
        $('#addWebcam-form')[0].reset();
        $('#nomError').hide(); $('#urlError').hide(); $('#etatError').hide();
        $('#nom').val($(this).attr("data-nom"))
        $('#url').val($(this).attr("data-url"))
        $('#etat').val($(this).attr("data-etat"))
    });

    $(document).on('click', ".delete_webcam", function () {
        var id = $(this).attr("data-key");
        swal({
            title: "Suppression d\'une Webcam",   
            text: "Êtes-vous sûr de vouloir supprimer cette webcam ?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#e6b034",   
            confirmButtonText: "OK",
            cancelButtonText: "ANNULER",  
            closeOnConfirm: true 
            }, function(){
            $('body').loadingModal({
                position: 'auto',
                text: 'Suppression en cours',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'doubleBounce'
                });
            $.ajax({
            type: "delete",
            url: "<?php echo $this->Url->build('/',true)?>/manager/stations/deletewebcam/"+id,
            success:function(xml){
                $('body').loadingModal('destroy');
                swal("", "Vous venez de supprimer une webcam", "success");
                table.ajax.reload();
                },
                error: function(){
                    $('body').loadingModal('destroy');
                    $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Erreur',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 4000
                        });
                }
            }); 
        });
    });
    $(document).ready(function() {

        table=$('#datable_1').DataTable({
            responsive: true,
            // "columnDefs": [
            //     {
            //         "render": function ( data, type, row ) {
            //             if(data!=null&&data.length>70)
            //                 return data.substr(0, 69)+'...'
            //             return data
            //         },
            //         "targets": [1]
            //     },
            //     { "width": "15%", "targets": 4 },
            //     { responsivePriority: 1, targets: 4 },
            //     { responsivePriority: 2, targets: [0,3] },
            //     { responsivePriority: 3, targets: [1,2] }
            // ],
            "ajax":{
                "url": "<?= $this->Url->build('/',true)?>manager/stations/allwebcams/<?=$lieugeo->id?>",
            },
            "language": language_data_table
        });
    });
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>