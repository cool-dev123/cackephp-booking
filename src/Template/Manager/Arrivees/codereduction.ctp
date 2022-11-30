<div class="row heading-bg icantSelectIt">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h5 class="txt-dark">Codes de Réductions</h5>
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
                                                                <th>Code de Réduction</th>
                                                                <th>Début de validité</th>
                                                                <th>Fin de validité</th>
                                                                <th>Valeur</th>
                                                                <th>Gestionnaire</th>
                                                                <th>&nbsp;</th>
                                                        </tr>
                                                </thead>
                                                <tfoot>
                                                        <tr>
                                                                <th>Code de Réduction</th>
                                                                <th>Début de validité</th>
                                                                <th>Fin de validité</th>
                                                                <th>Valeur</th>
                                                                <th>Gestionnaire</th>
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
                                                                <td><?php echo $value['G']['name']; ?></td>
                                                                <td>
                                                                    <center>
                                                                        <button class="btn btn-info btn-sm btn-icon-anim btn-circle delete_station" data-key="<?php echo $value->id;?>" ><i class="icon-trash"></i></button>
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
    //<script>
        
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
						url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/deletecodereduction/"+id,
						success:function(xml){
                                                        $('body').loadingModal('destroy');
							swal("", "Vous venez de supprimer un code de réduction", "success");
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