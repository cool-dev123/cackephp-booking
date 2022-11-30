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
                        <h6 class="panel-title txt-dark">Villages</h6>
                </div>
                <div class="pull-right">
                    <button onclick="addVill()" class="btn btn-primary pull-right">Ajouter Village</button>
                </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <table id="datable_1" class="table table-hover display  pb-30" >
                            <thead>
                                <tr>
                                    <th>Village</th>
                                    <th>Ville</th>
                                    <th>Station</th>
                                    <th>Nbr Annonces</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Village</th>
                                    <th>Ville</th>
                                    <th>Station</th>
                                    <th>Nbr Annonces</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </tfoot>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.modal -->
<div id="modal-addStation" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title">Choisir Station pour village : <span id="villageId"></span></h5>
            </div>
            <div id="modal-body" class="modal-body">
                <div class="form-group row">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Massif : <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12 mb-20">
                        <?php echo $this->Form->select('villageMassif',$massifs,['id'=>'villageMassif','label'=>false,'class'=>'select2 form-control']);  ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Station : <sup class='text-danger'>*</sup></label>
                    <div class="col-sm-12 mb-20">
                        <?php echo $this->Form->select('villageStation',$stations,['id'=>'villageStation','label'=>false,'class'=>'select2 form-control']);  ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button id="saveStation" type="button" class="btn btn-danger">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<!-- /.modal -->
<div id="modal-addVillage" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 id="modal-title" class="modal-title">Ajouter village</h5>
            </div>
            <div id="modal-body" class="modal-body">
                <form id="addVillage-form">
                    <div class="form-group row">
                        <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Village: <sup class='text-danger'>*</sup></label>
                        <div class="col-sm-12 mb-20">
                            <?php echo $this->Form->input('name',['type'=>'text','id'=>'name','label'=>false,'class'=>'form-control']);  ?>
                            <div id="nameError" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Départements : <sup class='text-danger'>*</sup></label>
                        <div class="col-sm-12 mb-20">
                            <?php echo $this->Form->select('id_departement',$departements,['id'=>'id_departement','label'=>false,'class'=>'select2 form-control']);  ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Ville : <sup class='text-danger'>*</sup></label>
                        <div class="col-sm-12 mb-20">
                            <?php echo $this->Form->select('id_ville',$villes,['id'=>'id_ville','label'=>false,'class'=>'select2 form-control']);  ?>
                            <div id="villeError" class="error-message"></div>
                        </div>
                    </div>
                    <?php if($this->request->session()->read("Gestionnaire.info")['G']['role']!='gestionnaire'): ?>
                        <div class="form-group row">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Massif : <sup class='text-danger'>*</sup></label>
                            <div class="col-sm-12 mb-20">
                                <?php echo $this->Form->select('massif_id',$massifs,['id'=>'massif_id','label'=>false,'class'=>'select2 form-control']);  ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Station : <sup class='text-danger'>*</sup></label>
                            <div class="col-sm-12 mb-20">
                                <?php echo $this->Form->select('lieugeo_id',$stations,['id'=>'lieugeo_id','label'=>false,'class'=>'select2 form-control']);  ?>
                                <div id="stationError" class="error-message"></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="form-group row">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Station</label>
                            <div class="col-sm-12 mb-20">
                                <?php echo $this->Form->input('lieugeo_name',['type'=>'text','value'=>$this->request->session()->read("Gestionnaire.info")['G']['stationName'],'label'=>false,'class'=>'form-control','readonly']);  ?>
                                <?= $this->Form->hidden('lieugeo_id',['value'=>$this->request->session()->read("Gestionnaire.info")['G']['station'],'id'=>'lieugeo_id']) ?>
                            </div>
                        </div>
                    <?php endif;?>
                    <div class="form-group row">
                        <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Correspondance Boutique: <sup class='text-danger'>*</sup></label>
                        <div class="col-sm-12 mb-20">
                            <?php echo $this->Form->input('input_boutique',['type'=>'text','id'=>'input_boutique','label'=>false,'class'=>'form-control','placeholder'=>'Exp : arc_1600_fr', 'required']);  ?>
                            <div id="boutiqueError" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Correspondance Boutique (Anglais): <sup class='text-danger'>*</sup></label>
                        <div class="col-sm-12 mb-20">
                            <?php echo $this->Form->input('input_boutique_EN',['type'=>'text','id'=>'input_boutique_EN','label'=>false,'class'=>'form-control','placeholder'=>'Exp : arc_1600_fr', 'required']);  ?>
                            <div id="boutiqueENError" class="error-message"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button id="saveVillage" type="button" class="btn btn-danger">Enregistrer</button>
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
    function addVill(){
        $('#modal-addVillage').modal('toggle');
        $('#modal-addVillage').modal('show');
        $('#addVillage-form')[0].reset();
        $('#nameError').hide();$('#stationError').hide();$('#villeError').hide();
        $('#id_departement').val(null).trigger('change').select2('destroy').select2()
        $("#id_ville").html('')
        $('#massif_id').val($("#target option:first").val()).trigger('change').select2('destroy').select2()
        $('#lieugeo_id').html('')
        $('#modal-title').html('Ajouter village')
        edit=0;
    }
    $('#saveVillage').click(function(){
        $('#nameError').hide();$('#stationError').hide();$('#villeError').hide();$('#boutiqueError').hide();$('#boutiqueENError').hide();
        $('body').loadingModal({
                position: 'auto',
                text: '',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'doubleBounce'
        });
        if(edit==0){
            var heading='Vous avez crée Une village';
            var url="<?php echo $this->Url->build('/',true)?>/manager/village/add";
        }
        else{
            var heading='Vous avez modifié Une village';
            var url=edit;
        }
        $.ajax({
            type: "post",
            url: url,
            data :{
                name:$('#name').val(),
                lieugeo_id:$('#lieugeo_id').val(),
                id_ville:$('#id_ville').val(),
                input_boutique:$('#input_boutique').val(),
                input_boutique_EN:$('#input_boutique_EN').val(),
            },
            success:function(data){
                $('body').loadingModal('destroy');
                if(data.res=='error')
                {
                    for(var key in data.errors.name)
                        if(data.errors.name.hasOwnProperty(key)) {
                            $('#nameError').show().html(data.errors.name[key])
                            break;
                        }
                    for(var key in data.errors.id_ville)
                        if(data.errors.id_ville.hasOwnProperty(key)) {
                            $('#villeError').show().html(data.errors.id_ville[key])
                            break;
                        }
                    for(var key in data.errors.lieugeo_id)
                        if(data.errors.lieugeo_id.hasOwnProperty(key)) {
                            $('#stationError').show().html(data.errors.lieugeo_id[key])
                            break;
                        }
                    for(var key in data.errors.input_boutique)
                        if(data.errors.input_boutique.hasOwnProperty(key)) {
                            $('#boutiqueError').show().html(data.errors.input_boutique[key])
                            break;
                        }
                    for(var key in data.errors.input_boutique_EN)
                        if(data.errors.input_boutique_EN.hasOwnProperty(key)) {
                            $('#boutiqueENError').show().html(data.errors.input_boutique_EN[key])
                            break;
                        }
                }
                else if(data=='village added')
                {
                    edit=0
                    table.ajax.reload();
                    $('#modal-addVillage').modal('toggle');
                    $('#modal-addStation').modal('hide');
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
    $(document).on('click', ".editVillage", function () {
        edit=$(this).attr("data-href");
        $('#modal-addVillage').modal('toggle');
        $('#modal-addVillage').modal('show');
        $('#addVillage-form')[0].reset();
        $('#nameError').hide();$('#stationError').hide();$('#villeError').hide();
        $('#name').val($(this).attr("data-name"))
        $('#input_boutique').val($(this).attr("data-input_boutique"))
        $('#input_boutique_EN').val($(this).attr("data-input_boutique_EN"))
        $('#id_departement').val($(this).attr("data-departement_id")).trigger('change')
        $('#id_ville').val($(this).attr("data-ville_id")).trigger('change')
        $('#massif_id').val($(this).attr("data-massif_id")).trigger('change')
        $('#lieugeo_id').val($(this).attr("data-lieugeo_id")).trigger('change')
        $('#modal-title').html('Modifier village')
    });
    
    $(document).on('click', ".buton_add", function () {
        $('#villageMassif').val(null).trigger('change');
        $('#villageStation').val(null).trigger('change');
        $('#villageId').html($(this).attr("data-name"));
        villageId=$(this).attr("data-key");
    });
    $('#saveStation').click(function(){
        $.ajax({
            type: "delete",
            url: "<?php echo $this->Url->build('/',true)?>/manager/village/setStationToVillage/"+villageId+'/'+$('#villageStation').val(),
            success:function(xml){
                $('body').loadingModal('destroy');
                swal("", "Vous venez reliez la station", "success");
                table.ajax.reload();
                $('#modal-addStation').modal('hide');
                villageId=null;
                $('#villageStation').prop('selectedIndex',0);
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
    $("#id_departement").change(function() {
        if($(this).val()!=null){
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
                    $('body').loadingModal('destroy');
                },error: function(){
                    $('body').loadingModal('destroy');
                }
            });
        }
    });
    $("#massif_id").change(function() {
        if($(this).val()!=null){
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
                url: "<?php echo $this->Url->build('/',true)?>manager/massif/getStations/"+$(this).val(),
                success:function(data){
                    $('#lieugeo_id').empty();
                    for (var stationId in data) {
                        $('#lieugeo_id').append('<option value=' + stationId + '>' + data[stationId].toLowerCase() + '</option>');
                    }
                    $('body').loadingModal('destroy');
                },error: function(){
                    $('body').loadingModal('destroy');
                }
            });
        }
    });
    $("#villageMassif").change(function() {
        if($(this).val()!=null){
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
                url: "<?php echo $this->Url->build('/',true)?>manager/massif/getStations/"+$(this).val(),
                success:function(data){
                    $('#villageStation').empty();
                    for (var stationId in data) {
                        $('#villageStation').append('<option value=' + stationId + '>' + data[stationId].toLowerCase() + '</option>');
                    }
                    $('body').loadingModal('destroy');
                },error: function(){
                    $('body').loadingModal('destroy');
                }
            });
        }
    });
    $(document).on('click', ".delete_village", function () {
        var id = $(this).attr("data-key");
        swal({
            title: "Suppression d\'une Village",   
            text: "Êtes-vous sûr de vouloir supprimer cette village ?",   
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
            url: "<?php echo $this->Url->build('/',true)?>/manager/village/delete/"+id,
            success:function(data){
                $('body').loadingModal('destroy');
                if(data=='deleted'){
                    swal("", "Vous venez de supprimer une village", "success");
                    table.ajax.reload();
                }
                else{
                    swal({
                        title: "Erreur de suppression",   
                        text: 'Cette village contient des offices de tourisme, Vous ne pouvez pas le supprimer',   
                        type: "error",
                        confirmButtonColor: "#FF0000",   
                        confirmButtonText: "OK",
                        closeOnConfirm: true 
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
    });
    $(document).ready(function() {

        table=$('#datable_1').DataTable({
            responsive: true,
            "ajax":{
                "url": "<?= $this->Url->build('/',true)?>manager/village/allvillages",
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