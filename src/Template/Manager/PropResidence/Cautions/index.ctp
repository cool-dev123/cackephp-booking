<?php $this->start('cssTop'); ?>
    <style>
        .check-circle{ color:green; font-size: 20px; }
        .exclamation-circle{ color:red; font-size: 20px; }
        .heading-bg {
            height: 100% !important;
        }
    </style>
<?php $this->end(); ?>
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
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/8">Gestion Des Pages</a></li>
      <li class="active"><a href="#">Résidences de tourisme</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/stations/">Stations</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/vacances/">Vacances</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelmail">Gestion de modèles</a></li>
    </ul>
  </div>
</nav>

<?=
    $this->element('gestionresidencemenu');
?>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left mt-10">
                        <h6 class="panel-title txt-dark">Liste Règles Caution</h6>
                </div>
                <div class="pull-right">
                    <a href="<?php echo $this->Url->build('/',true);?>manager/cautions/add/" class="btn btn-primary pull-right">Ajouter Règle Caution</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                        <table id="datable_1" class="table table-hover display  pb-30" >
                            <thead>
                                <tr>
                                    <th>Caution</th>
                                    <th>Description</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Caution</th>
                                    <th>Description</th>
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    var table;
    $(document).on('click', ".delete_caution", function () {
        var id = $(this).attr("data-key");
        var textsupp = "";
        $.ajax({
            type: "POST",
            dataType : 'json',
            url: "<?php echo $this->Url->build('/',true)?>manager/cautions/getpropcautionrelation/"+id,
            success:function(xml){
                if(xml == "existe") textsupp = "Attention, cette caution est liée à un ou plusieurs propriétaires de résidences. Si vous supprimez cette règle, la liste des autres cautions sera disponible dans la gestion des annonce de ce/ces propriétaire(s).";
                swal({
                    title: "Êtes-vous sûr de vouloir supprimer cette Caution ?",   
                    text: textsupp,   
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
                    url: "<?php echo $this->Url->build('/',true)?>/manager/cautions/deletecaution/"+id,

                    success:function(xml){
                        $('body').loadingModal('destroy');
                        if(xml=='deleted'){
                            swal("", "Vous venez de supprimer une caution", "success");
                            table.ajax.reload();
                        }else{
                            swal({
                                title: "Erreur de suppression",   
                                text: "Vous ne pouvez pas supprimer cette caution",   
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
            }
        }); 

        
    });
    $(document).ready(function() {

        table=$('#datable_1').DataTable({
            responsive: true,
            "ajax":{
                "url": "<?= $this->Url->build('/',true)?>manager/cautions/allcautions",
            },
            "language": language_data_table
        });
    });

    <?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: '<?php echo $confirm_res ?>',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 4000
                        });
    <?php endif;?>
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>