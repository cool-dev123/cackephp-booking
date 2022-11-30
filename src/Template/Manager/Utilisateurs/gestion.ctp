<?php $this->start('cssTop'); ?>
    <style>
        .check-circle{ color:green !important; font-size: 20px !important; }
        .exclamation-circle{ color:red !important; font-size: 20px !important; }
        .heading-bg {
            height: 100% !important;
        }
    </style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
      <h5 class="txt-dark">Tous Les Contrats</h5>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/admincontrat/" class="btn  btn-primary pull-right"><i class="fa fa-arrow-left"></i> Contrats</a>
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
                                                <th>ID Propri&eacute;taire</th>
                                                <th>File maker</th>
                                                <th>ID Annonce</th>
                                                <th>Nom</th>
                                                <th>Pr&eacute;nom</th>
                                                <th>Contrat</th>
                                                <th>Relation</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>ID Propri&eacute;taire</th>
                                                <th>File maker</th>
                                                <th>ID Annonce</th>
                                                <th>Nom</th>
                                                <th>Pr&eacute;nom</th>
                                                <th>Contrat</th>
                                                <th>Relation</th>
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
</div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title" id="myModalLabel">Fiche Utilisateur</h5>
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
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
			function activate(id){
                            $('body').loadingModal({
                                position: 'auto',
                                text: '',
                                color: '#fff',
                                opacity: '0.7',
                                backgroundColor: 'rgb(0,0,0)',
                                animation: 'doubleBounce'
                            });
                            //$('#listUtilisateur_processing').attr('style','visibility: visible;');
			$.ajax({
                                    type: "POST",
                                    url: "<?php echo $this->Url->build('/',true)?>manager/annonces/activer",
                                    data: {id : id},
                                    success:function(xml){
                                            $('body').loadingModal('destroy');
                                            if(xml=="ok") 
                                            {   $('#coeur_'+id).attr('class','check-circle');
                                                $('#coeur_'+id).empty(); $('#coeur_'+id).append( "<i class='fa fa-check-circle'></i>" );
                                                
                                                $('.dtr-data').children('#coeur_'+id).attr('class','check-circle');
                                                $('.dtr-data').children('#coeur_'+id).empty(); $('.dtr-data').children('#coeur_'+id).append( "<i class='fa fa-check-circle'></i>" );
                                                $.toast().reset('all');
                                                $("body").removeAttr('class');
                                                $.toast({
                                                    heading: 'success',
                                                    text: 'Vous vener activer un contrat',
                                                    position: 'bottom-right',
                                                    loaderBg:'#fec107',
                                                    icon: 'success',
                                                    hideAfter: 4000
                                                });
                                            }
                                            else {
                                                $('#coeur_'+id).attr('class','exclamation-circle');
                                                $('#coeur_'+id).empty(); $('#coeur_'+id).append( "<i class='fa fa-exclamation-circle'></i>" );
                                                $('.dtr-data').children('#coeur_'+id).attr('class','exclamation-circle');
                                                $('.dtr-data').children('#coeur_'+id).empty(); $('.dtr-data').children('#coeur_'+id).append( "<i class='fa fa-exclamation-circle'></i>" );
                                                $.toast().reset('all');
                                                $("body").removeAttr('class');
                                                $.toast({
                                                    heading: 'success',
                                                    text: 'Vous vener désactiver un contrat',
                                                    position: 'bottom-right',
                                                    loaderBg:'#fec107',
                                                    icon: 'success',
                                                    hideAfter: 4000
                                                });
                                            }

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
		}

		function activate_relation(id){
                        $('body').loadingModal({
                                position: 'auto',
                                text: '',
                                color: '#fff',
                                opacity: '0.7',
                                backgroundColor: 'rgb(0,0,0)',
                                animation: 'doubleBounce'
                            });
			//$('#listUtilisateur_processing').attr('style','visibility: visible;');
			
			$.ajax({
						type: "POST",
						url: "<?php echo $this->Url->build('/',true)?>manager/annonces/activate_relation",
						data: {id : id},
						success:function(xml){
                                                    $('body').loadingModal('destroy');
                                                    //table.ajax.reload( null, false );
							if(xml=="ok") {
                                                            $('#coeur_re_'+id).attr('class','check-circle');
                                                            $('#coeur_re_'+id).empty(); $('#coeur_re_'+id).append( "<i class='fa fa-check-circle'></i>" );
                                                            $('.dtr-data').children('#coeur_re_'+id).attr('class','check-circle');
                                                            $('.dtr-data').children('#coeur_re_'+id).empty(); $('.dtr-data').children('#coeur_re_'+id).append( "<i class='fa fa-check-circle'></i>" );
                                                            $.toast().reset('all');
                                                            $("body").removeAttr('class');
                                                            $.toast({
                                                                heading: 'success',
                                                                text: 'Vous vener activer une relation',
                                                                position: 'bottom-right',
                                                                loaderBg:'#fec107',
                                                                icon: 'success',
                                                                hideAfter: 4000
                                                            });
                                                        }
							else {
                                                            $('#coeur_re_'+id).attr('class','exclamation-circle');
                                                            $('#coeur_re_'+id).empty(); $('#coeur_re_'+id).append( "<i class='fa fa-exclamation-circle'></i>" );
                                                            $('.dtr-data').children('#coeur_re_'+id).attr('class','exclamation-circle');
                                                            $('.dtr-data').children('#coeur_re_'+id).empty(); $('.dtr-data').children('#coeur_re_'+id).append( "<i class='fa fa-exclamation-circle'></i>" );
                                                            $.toast().reset('all');
                                                            $("body").removeAttr('class');
                                                            $.toast({
                                                                heading: 'success',
                                                                text: 'Vous vener désactiver une relation',
                                                                position: 'bottom-right',
                                                                loaderBg:'#fec107',
                                                                icon: 'success',
                                                                hideAfter: 4000
                                                            });
                                                        }
							 
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
		}
                
    var table=null;
        
    $(document).ready(function() {
            table = $('#datable_1').DataTable({
            responsive: true,
            "ajax": "<?php echo $this->Url->build('/',true)?>manager/utilisateurs/gpaginate/",
            "fnRowCallback": function( nRow, mData, iDisplayIndex ) {
            // create link
            $('td:eq(1)', nRow).html('<a class="edddditable myeditables-class" href="#">'+mData[1]+'</a>');
            // add x-editable
            $('td:eq(1) a', nRow).editable({
                placement: 'top'
              });
              $('td:eq(1) a', nRow).on('save', function(e, params) {
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
                            url: "<?php echo $this->Url->build('/',true)?>manager/annonces/idfilemaker",
                            data: {id : mData[2],idfilemaker : params.newValue },
                            success:function(xml){
                                $('body').loadingModal('destroy');
                                $.toast().reset('all');
                                        $("body").removeAttr('class');
                                        $.toast({
                                            heading: 'Success',
                                            text: '',
                                            position: 'bottom-right',
                                            loaderBg:'#fec107',
                                            icon: 'success',
                                            hideAfter: 4000
                                        });
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
            return nRow;
            },
            "language": language_data_table
        });
       
              
    } );
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
<!-- xeditable css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>