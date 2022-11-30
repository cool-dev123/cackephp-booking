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
                        <h6 class="panel-title txt-dark">Stations</h6>
                </div>
                <?php if($InfoGes['G']['role']!='gestionnaire'):?>
                <div class="pull-right">
                    <a href="<?php echo $this->Url->build('/',true);?>manager/stations/add/" class="btn btn-primary pull-right">Ajouter Station</a>
                </div>
                    <div class="clearfix"></div>
                <?php endif; ?>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                        <table id="datable_1" class="table table-hover display  pb-30" >
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Etat</th>
                                    <th>codes insee</th>
                                    <th>domaine</th>
                                    <th>massif</th>
                                    <th>depuis api</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nom</th>
                                    <th>Etat</th>
                                    <th>codes insee</th>
                                    <th>domaine</th>
                                    <th>massif</th>
                                    <th>depuis api</th>
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
    $(document).on('click', ".delete_station", function () {
        var id = $(this).attr("data-key");
        swal({
            title: "Êtes-vous sûr de vouloir supprimer cette Station ?",   
            text: "Toutes les webcams et tous les lits de cette station seront supprimés",   
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
            url: "<?php echo $this->Url->build('/',true)?>/manager/stations/delete/"+id,

            success:function(xml){
                $('body').loadingModal('destroy');
                if(xml=='deleted'){
                    swal("", "Vous venez de supprimer une Station", "success");
                    table.ajax.reload();
                }else{
                    swal({
                        title: "Erreur de suppression",   
                        text: "Vous ne pouvez pas supprimer cette station",   
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
                "url": "<?= $this->Url->build('/',true)?>manager/stations/allstations",
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