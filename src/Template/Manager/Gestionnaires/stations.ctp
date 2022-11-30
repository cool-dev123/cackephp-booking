<?php $this->start('cssTop'); ?>
    <style>
        .heading-bg {
            height: 100% !important;
        }
        @media only screen and (max-width: 498px) {
            .edit_station{ margin-right: 10px !important;}
        }
        @media only screen and (min-width: 701px) {
            .edit_station{ margin-right: 10px !important;}
        }
        @media only screen and (min-width: 508px) and (max-width: 593px) {
            .edit_station{ margin-bottom: 10px !important;}
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
                        <h5 class="txt-dark">Périodes de stations</h5>
                </div>
                <div class="pull-right">
                    <a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/addperiodestation" class="btn  btn-primary pull-right">Ajouter période</a>
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
                                                <th>Station</th>
                                                <th>Ouverture</th>
                                                <th>Fermeture</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>Station</th>
                                                <th>Ouverture</th>
                                                <th>Fermeture</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach($listestations as $key=>$enr):?>
                                        <tr>
                                                <td><?php echo $enr['Lieugeos']['name']?></td>
                                                <td><?php echo $enr->ouverture?></td>
                                                <td><?php echo $enr->fermeture?></td>
                                                <td>
                                                    <center>
                                                        <button class="btn btn-default btn-sm btn-icon-anim btn-circle edit_station" onclick="location.href='<?php echo $this->Url->build('/',true)?>manager/gestionnaires/editperiodestation/<?php echo $enr->id;?>'" ><i class="fa fa-pencil"></i></button>
                                                        <button class="btn btn-info btn-sm btn-icon-anim btn-circle delete_station" data-key="<?php echo $enr->id;?>" ><i class="icon-trash"></i></button>
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    var table=null;
    $(document).on('click', ".delete_station", function () {
        var id = $(this).attr("data-key");
                    swal({   
                                    title: "Suppression d\'une période",   
                                    text: "Êtes-vous sûr de vouloir supprimer cette période ?",   
                                    type: "warning",   
                                    showCancelButton: true,   
                                    confirmButtonColor: "#e6b034",   
                                    confirmButtonText: "OK",
                                    cancelButtonText: "ANNULER",  
                                    closeOnConfirm: false 
                            }, function(){
                                    $.ajax({
                                    type: "GET",
                                    url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/deleteperiodestation/"+id,

                                    success:function(xml){
                                      //alert(xml)
                                            swal("", "Vous venez de supprimer une période", "success");
                                            setTimeout(function(){ window.location.reload(); }, 500);
                                      }
                                    }); 
                            });
    });
    
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-uk-pre": function ( a ) {
            if(a!=null){
                var ukDatea = a.split('/');
                return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
            }
        },

        "date-uk-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-uk-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    } );
    
    $(document).ready(function() {

            table=$('#datable_1').DataTable({
            responsive: true,
            "columnDefs": [
                { "type": 'date-uk', "targets": 2 },
                { "type": 'date-uk', "targets": 1 },
            ],
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