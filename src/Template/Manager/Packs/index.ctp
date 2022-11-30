<?php $this->start('cssTop'); ?>
    <style>
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
      <li class="active"><a href="#">Packs De Services</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/parametrage/gps">Points GPS</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/index">Liste Des Gestionaires</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/8">Gestion Des Pages</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/cautions/index">Résidences de tourisme</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/stations/">Stations</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/vacances/">Vacances</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelmail">Gestion de modèles</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left mt-10">
                        <h6 class="panel-title txt-dark">Gestion des Packs de services</h6>
                </div>
                <div class="pull-right">
                    <a href="<?php echo $this->Url->build('/',true)?>manager/packs/add/" class="btn  btn-primary pull-right">Créez un nouveau pack</a>
                </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <div>
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                                <th>Titre</th>
                                                <th>Coût</th>
                                                <th>Actif</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>Titre</th>
                                                <th>Coût</th>
                                                <th>Actif</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach($packs as $enr):?>
                                        <tr>
                                                <td><?php echo $enr->titre;?></td>
                                                <td><?php echo $enr->cout?></td>
                                                <td><?php echo ($enr->actif_yn==1) ? 'Oui' : 'Non'?></td>
                                                <td>
                                                    <center>
                                                        <button class="mr-10 btn btn-sm btn-default btn-icon-anim btn-circle" onclick="location.href='<?php echo $this->Url->build('/',true)?>manager/packs/edit/<?php echo $enr->id;?>'" ><i class="fa fa-pencil"></i></button>
                                                        <button class="btn btn-sm btn-info btn-icon-anim btn-circle delete_station" data-key="<?php echo $enr->id;?>" ><i class="icon-trash"></i></button>
                                                    </center>
                                                </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    
    $(document).on('click', ".delete_station", function () {
        var id = $(this).attr("data-key");
                    swal({   
                            title: "Suppression d\'un pack",   
                            text: "Êtes-vous sûr de vouloir supprimer ce pack ?", 
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#e6b034",   
                            confirmButtonText: "OK",
                            cancelButtonText: "ANNULER",  
                            closeOnConfirm: false 
                    }, function(){
                            $('body').loadingModal({
                                position: 'auto',
                                text: '',
                                color: '#fff',
                                opacity: '0.7',
                                backgroundColor: 'rgb(0,0,0)',
                                animation: 'doubleBounce'
                            });
                            $.ajax({
                            type: "GET",
                            url: "<?php echo $this->Url->build('/',true)?>manager/packs/delete/"+id,

                            success:function(xml){
                                    $('body').loadingModal('destroy');
                                    swal("", "Vous venez de supprimer un pack", "success");
                                    setTimeout(function(){ window.location.reload(); }, 500);
                              },error: function(){
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

            $('#datable_1').DataTable({
            responsive: true,
            
            "language": language_data_table
        });
            "use strict";
	
	var SweetAlert = function() {};

    //examples 
    SweetAlert.prototype.init = function() {
    
    },
    //init
    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert;
	
	$.SweetAlert.init();
              
    } );
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>