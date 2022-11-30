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
      <span class="navbar-brand" href="#"><i class="ti-settings"></i> Configuration</span>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Publicités</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/packs/index">Packs De Services</a></li>
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
                        <h6 class="panel-title txt-dark">Publicités</h6>
                </div>
                <div class="pull-right">
                    <a href="<?php echo $this->Url->build('/',true);?>manager/annonces/addpub/" class="btn  btn-primary pull-right">Ajouter Publicité</a>
                </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                                <th>Titre</th>
                                                <th>Statut</th>
                                                <th>Gestionnaire</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>Titre</th>
                                                <th>Statut</th>
                                                <th>Gestionnaire</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach($images as $key=>$enr):?>
                                        <tr>
                                                <td><?php echo $enr->titre ?></td>
                                                <td>
								<?php if($enr->visible==1):?>
                                                                 <a class="check-circle" href="<?php echo $this->Url->build('/',true);?>manager/annonces/blockerpub/<?php echo $enr->id;?>" >
								 <i class="fa fa-check-circle"></i>
								 </a>
								 <?php else:?>
								 <a class="exclamation-circle" href="<?php echo $this->Url->build('/',true);?>manager/annonces/activerpub/<?php echo $enr->id;?>" >
								 <i class="fa fa-exclamation-circle"></i>
								 </a>
								 <?php endif; ?>
								</td>
                                                <td><?php echo $enr['G']['name']?></td>
                                                <td>
                                                    <center>
                                                        <button data-key="<?php echo $enr->id;?>" data-toggle="modal" data-target="#myModal" class="mr-10 btn btn-sm btn-warning btn-icon-anim btn-circle view_station"><i class="fa fa-search"></i></button>
                                                        <button class="mr-10 btn btn-sm btn-default btn-icon-anim btn-circle" onclick="location.href='<?php echo $this->Url->build('/',true)?>manager/annonces/editpub/<?php echo $enr->id;?>'" ><i class="fa fa-pencil"></i></button>
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

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title" id="myModalLabel">Fiche Publicité</h5>
            </div>
            <div id="modal-fiche-publicité-body" class="modal-body">
                <!-- this content loaded by jquery -->
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button>
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
    $(document).on('click', ".view_station", function () {
        $('body').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
        $('#modal-fiche-publicité-body').empty();
        var id = $(this).attr("data-key");
        $.ajax({
            type: "GET",
            url: "<?php echo $this->Url->build('/',true);?>manager/annonces/viewpub/"+id,

            success:function(xml){
                $('#modal-fiche-publicité-body').append(xml);
                $('body').loadingModal('destroy');
              },error: function(){
                    $('#myModal').modal('hide');
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
    $(document).on('click', ".delete_station", function () {
        var id = $(this).attr("data-key");
                    swal({   
                            title: "Suppression d\'une publicité",   
                            text: "Voulez-vous supprimer cette Publicité ?",   
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
                            url: "<?php echo $this->Url->build('/',true);?>manager/annonces/deletepub/"+id,

                            success:function(xml){
                                    $('body').loadingModal('destroy');
                                    swal("", "Vous venez de supprimer une publicité", "success");
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