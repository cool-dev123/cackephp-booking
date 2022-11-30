<?php $this->start('cssTop'); ?>
    <style>
        .heading-bg {
            height: 100% !important;
        }
        .modal-dialog.modal-dialog-centered {
            width: 80%;
        }
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="icon-home"></i> Annonces</span>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/mesannonces/">Toutes les annonces</a></li>
      <li class="active"><a href="#">Annonces en attente de validation</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/commentaires/">Valider Commentaires</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Annonces en attente de validation</h6>
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
                                                <th>Création</th>
                                                <th>Modification</th>
                                                <th>Situation géo</th>
                                                <th>Propriétaire</th>
                                                <th>E-mail</th>
                                                <th>Justificatif de domicile</th>
                                                <th></th>
                                                <th></th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>Création</th>
                                                <th>Modification</th>
                                                <th>Situation géo</th>
                                                <th>Propriétaire</th>
                                                <th>E-mail</th>
                                                <th>Justificatif de domicile</th>
                                                <th></th>
                                                <th></th>
                                        </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach($annonces as $key=>$enr) {?>
                                        <tr>
                                                <td>
                                                        <?php if($enr->created_at != null) echo $enr->created_at->i18nFormat('dd-MM-yyyy'); else echo $enr->created_at;?>
                                                </td>
                                                <td>
                                                        <?php if($enr->updated_at != null) echo $enr->updated_at->i18nFormat('dd-MM-yyyy'); else echo $enr->updated_at;?>
                                                </td>
                                                <td><?php echo $enr['L']['name']?></td>


                                                <td><?php echo $enr['U']['nom_famille']." ".$enr['U']['prenom']?></td>


                                                <td><a href="mailto:<?php echo $enr['U']['email']?>" class="<?php if($enr['U']['valide_at'] != null) echo "text-success"; else echo "text-danger"; ?>"><?php echo $enr['U']['email']?></a></td>
                                                <td>
                                                    <?php if($enr->justificatif_domicile != ""){ ?>
                                                        <button onclick="aPlanPistes('<?php echo $enr->justificatif_domicile;?>')" class="btn btn-sm btn-default btn-icon-anim btn-circle"><i class="fa fa-file-pdf-o"></i></button>
                                                    <?php } ?>
                                                    <!-- <a onclick="aPlanPistes(<?php // echo $enr->justificatif_domicile;?>)" id="aPlanPistes"><i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i></a> -->
                                                 </td>
                                                <td><center>
                                                    <button onclick="window.open('<?php echo $this->Url->build('/',true)?>annonces/edit/<?php echo $enr->id;?>','_blank');" class="btn btn-sm btn-default btn-icon-anim btn-circle"><i class="fa fa-pencil"></i></button>
                                                    <button onclick="window.open('<?php echo $this->Url->build('/',true)?>annonces/view/<?php echo $enr->id;?>','_blank');" class="btn btn-sm btn-warning btn-icon-anim btn-circle"><i class="fa fa-search"></i></button>
                                                </center></td>
                                                <td><center>
                                                    <div class="btn-group">
                                                        <button alt="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/accepter/<?php echo $enr->id;?>" data-id="<?php echo $enr->id;?>" class="btn btn-sm btn-success btn-rounded btn-icon left-icon accept"> <i class="icon-like"></i> <span>Accepter</span></button>
                                                        <button alt="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/refuser/<?php echo $enr->id;?>" data-id="<?php echo $enr->id;?>" class="btn btn-sm btn-danger btn-rounded btn-icon left-icon refus"> <i class="icon-dislike"></i> <span>&nbsp;&nbsp;Refuser&nbsp;&nbsp;</span></button>
                                                    </div>
                                                </center></td>

                                        </tr>
                                  <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Plan Pistes -->
<div class="modal fade" id="planPistes" tabindex="-1" role="dialog" aria-labelledby="planPistes">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header p-3">
                <span class="orange h1modal text-center"><h2 class="font-weight-bold">Justificatif de domicile</h2></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
            </div>
            <div class="modal-body p-1">                              
                <div class="row">
                    <div class="col-md-12" id="object_inventaire">
                        
                    </div>                    
                </div>                          
            </div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal Plan Pistes -->

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
function aPlanPistes(id_reservation){
    $("#object_inventaire").html('<object data="<?php echo SITE_ALPISSIME."justificatifdomicile/"; ?>'+id_reservation+'" type="application/pdf" width="100%" height="500"><span class="text-center"> <?= __("Le lien est inaccessible pour le moment. Merci de réessayer plus tard.") ?> </span></object>');
    $("#planPistes").modal("show");
}
    $( window ).resize(function() {
        resizeButtons();
    });
    function resizeButtons(){
        if($( window ).width()>= 924 && $( window ).width()<= 1246){
            $('.btn-group').addClass('btn-group-vertical');
        }
        else{
            $('.btn-group').removeClass('btn-group-vertical');
        }
    }
    resizeButtons();
    $(document).on('click', ".accept", function () {
        var url=$(this).attr("alt");
                    var id_a=$(this).attr("data-id");
                    swal({   
						title: "Acceptation de l'annonce",   
                                                text: "Vous allez valider l'annonce "+id_a+".Avez vous verifié que cette annonce soit complète en termes de description, images, tarifs ?  sinon annuler et ouvrir la loupe",   
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
                                                        type: "POST",
                                                        dataType : 'json',
                                                        url: url,
                                                        success:function(xml){
                                                            location.reload();
                                                        }
                                                    });
                                                }
                        );
    });
    
    $(document).on('click', ".refus", function () {
        var url=$(this).attr("alt");
                    var id_a=$(this).attr("data-id");
                    swal({   
						title: "Refus de l'annonce",   
                                                text: "Vous allez refuser cette annonce",   
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
                                                        type: "POST",
                                                        dataType : 'json',
                                                        url: url,
                                                        success:function(xml){
                                                            location.reload();
                                                        }
                                                    });
					});
    });
    
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-eu-pre": function ( date ) {
            if(date == null) date = "";

              date = date.replace(" ", "");

              if ( ! date ) {
                  return 0;
              }

              var year;
              var eu_date = date.split(/[\.\-\/]/);

              /*year (optional)*/
              if ( eu_date[2] ) {
                  year = eu_date[2];
              }
              else {
                  year = 0;
              }

              /*month*/
              var month = eu_date[1];
              if ( month.length == 1 ) {
                  month = 0+month;
              }

              /*day*/
              var day = eu_date[0];
              if ( day.length == 1 ) {
                  day = 0+day;
              }

              return (year + month + day) * 1;
          },

          "date-eu-asc": function ( a, b ) {
              return ((a < b) ? -1 : ((a > b) ? 1 : 0));
          },

          "date-eu-desc": function ( a, b ) {
              return ((a < b) ? 1 : ((a > b) ? -1 : 0));
          }
      } );
    
    $(document).ready(function() {

            $('#datable_1').DataTable({
            responsive: true,
            "columnDefs": [
                { "type": 'date-eu', "targets": 1 },
                { "type": 'date-eu', "targets": 0 },
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
