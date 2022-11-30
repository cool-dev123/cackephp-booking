<?php $this->start('cssTop'); ?>
    <style>
        .heading-bg {
            height: 100% !important;
        }
        @media only screen and (max-width: 624px) {
            .edit_station{ margin-right: 10px !important;}
        }
        @media only screen and (min-width: 735px) {
            .edit_station{ margin-right: 10px !important;}
        }
    </style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-9 col-sm-9">
      <h5 class="txt-dark">Codes de Réductions</h5>
    </div>
    <div class="col-lg-3 col-sm-3">
      <a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/addcodereduction" class="btn  btn-primary pull-right">Ajouter code réduction</a>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap">
                                <div>
                                        <table id="datable_1" class="table table-hover display  pb-30" >
                                                <thead>
                                                        <tr>
                                                                <th>Code Réduction</th>
                                                                <th>Début de validité</th>
                                                                <th>Fin de validité</th>
                                                                <th>Valeur</th>
                                                                <th>&nbsp;</th>
                                                        </tr>
                                                </thead>
                                                <tfoot>
                                                        <tr>
                                                                <th>Code Réduction</th>
                                                                <th>Début de validité</th>
                                                                <th>Fin de validité</th>
                                                                <th>Valeur</th>
                                                                <th>&nbsp;</th>
                                                        </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php foreach($codes as $value):?>
                                                        <tr>
                                                                <td><?php echo $value->code_reduction; ?></td>
                                                                <td><?php echo $value->dbt_validite; ?></td>
                                                                <td><?php echo $value->fin_validite; ?></td>
                                                                <td><?php echo $value->valeur; ?></td>
                                                                <td>
                                                                    <center>
                                                                        <button onclick="location.href='<?php echo $this->Url->build('/',true)?>manager/gestionnaires/editcodereduction/<?php echo $value->id;?>'" class="edit_station btn btn-default btn-icon-anim btn-circle"><i class="fa fa-pencil"></i></button>
                                                                        <button class="btn btn-info btn-icon-anim btn-circle delete_station" data-key="<?php echo $value->id;?>" ><i class="icon-trash"></i></button>
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
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
    
    $(document).on('click', ".delete_station", function () {
        var id = $(this).attr("data-key");
        swal({   
                title: "Suppression d\'un code réduction",   
                text: "Êtes-vous sûr de vouloir supprimer ce code de réduction ?",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#e6b034",   
                confirmButtonText: "OK",
                cancelButtonText: "ANNULER",  
                closeOnConfirm: false 
        }, function(){
                $.ajax({
                type: "GET",
                url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/deletecodereduction/"+id,

                success:function(xml){
                  //alert(xml)
                        swal("", "Vous venez de supprimer un code de réduction", "success");
                        setTimeout(function(){ window.location.reload(); }, 500);
                  }
                }); 
        });
    });
    
    $(document).ready(function() {

            $('#datable_1').DataTable({
            "columnDefs": [
                { "type": 'date-uk', "targets": 2 },
                { "type": 'date-uk', "targets": 1 },
            ],
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