<div class="row icantSelectIt mb-15">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="panel card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box pt-10 pb-10">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12 text-center">
                                    <span class="block"><span class="initial"></span><span id="totalContrats" class="txt-primary font-48 weight-300 counter-anim data-rep">0</span></span>
                                    <span class="block weight-300 font-24 icantSelectIt">Contrats</span>
                                </div>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box pt-10 pb-10">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12 text-center">
                                    <span class="mb-10 block weight-300 font-24 icantSelectIt">Envoyer Facture Vers Le Gestionnaire</span>
                                    <a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/contrat" class="btn btn-primary mt-20">Gérer Facture Contrat</a>
                                </div>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
<!--        <div class="col-sm-12 col-lg-7">-->
        <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left">
                        <h6 class="panel-title txt-dark">Mes Contrats</h6>
                </div>
                <!-- <div class="pull-right">
                    <a href="<?php //echo $this->Url->build('/',true)?>manager/utilisateurs/gestion" class="btn btn-primary">Tous Les Contrats (relations/File Maker)</a>
                </div> -->
                <div class="clearfix"></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <div>
                            <table id="datable_1" class="table table-hover display" >
                                <thead>
                                        <tr>
                                                <th data-priority="1">ID Annonces</th>
                                                <th data-priority="2">Gestionnaire</th>
                                                <th data-priority="4">Propriétaire</th>
                                                <th data-priority="2">E-Mail</th>
                                                <th data-priority="4">File Maker</th>
                                                <th data-priority="3">Contrat</th>
                                                <th data-priority="3">Relation</th>
                                                <th data-priority="2"></th>
                                                <th data-priority="2"></th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>ID Annonces</th>
                                                <th>Gestionnaire</th>
                                                <th>Propriétaire</th>
                                                <th>E-Mail</th>
                                                <th>File Maker</th>
                                                <th>Contrat</th>
                                                <th>Relation</th>
                                                <th></th>
                                                <th></th>
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
    
<!--    <div class="col-sm-12 col-lg-5">
        - ARRIVEES -
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Contrats à activer</h6>
                </div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body mt-0 pt-0">
                    <div class="table-wrap">
                        <div>
                            <table id="datable" class="table table-hover display" >
                                <thead>
                                        <tr>
                                                <th data-priority="1">ID propriétaire</th>
                                                <th data-priority="3">id annonce</th>
                                                <th data-priority="4">nom</th>
                                                <th data-priority="4">prénom</th>
                                                <th data-priority="2">état </th>
                                        </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
</div>


<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Progressbar Animation JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery.counterup/jquery.counterup.min.js", array('block' => 'scriptBottom')); ?>

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

    table=null;
    table2=null;
//    function activate(id){
//        swal({   
//                            title: "Activation contrat",   
//                            text: "Êtes-vous sûr de vouloir activer ce contrat ?",   
//                            type: "warning",   
//                            showCancelButton: true,   
//                            confirmButtonColor: "#e6b034",   
//                            confirmButtonText: "OK",
//                            cancelButtonText: "ANNULER",  
//                            closeOnConfirm: true 
//                        }, function(){
//                                $('body').loadingModal({
//                                position: 'auto',
//                                text: '',
//                                color: '#fff',
//                                opacity: '0.7',
//                                backgroundColor: 'rgb(0,0,0)',
//                                animation: 'doubleBounce'
//                            });
//
//                            $.ajax({
//                                    type: "POST",
//                                    url: "<?php// echo $this->Url->build('/',true)?>manager/annonces/activer",
//                                    data: {id : id},
//                                    success:function(xml){
//                                            $('body').loadingModal('destroy');
//                                            if(xml=="ok") 
//                                            {
//                                                table2.ajax.reload( null, false );
//                                                table.ajax.reload( null, false );
//                                                $.toast().reset('all');
//                                                $("body").removeAttr('class');
//                                                $.toast({
//                                                    heading: 'success',
//                                                    text: 'Vous vener activer un contrat',
//                                                    position: 'bottom-right',
//                                                    loaderBg:'#fec107',
//                                                    icon: 'success',
//                                                    hideAfter: 4000
//                                                });
//                                            }
//                                    },error: function(){
//                                        $('body').loadingModal('destroy');
//                                        $.toast().reset('all');
//                                                $("body").removeAttr('class');
//                                                $.toast({
//                                                    heading: 'Erreur',
//                                                    text: '',
//                                                    position: 'bottom-right',
//                                                    loaderBg:'#fec107',
//                                                    icon: 'error',
//                                                    hideAfter: 4000
//                                                });
//                                    }
//                            });
//                    });
//    }
    
    $(document).on('click', ".delete_station", function () {
        var id = $(this).attr("data-key");
                    swal({   
                            title: "Suppression d\'un contrat",   
                            text: "Êtes-vous sûr de vouloir supprimer ce contrat ?",   
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
                            type: "delete",
                            url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/supprimercontrat/"+id,

                            success:function(xml){
                                $('body').loadingModal('destroy');
                                swal("", "Vous venez de supprimer un contrat", "success");
                                table2.ajax.reload( null, false );
                                table.ajax.reload( null, false );
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
    
    $(document).on('click', ".archive_station", function () {
        var id = $(this).attr("data-key");
                    swal({   
                            title: "Archivage d\'un contrat",   
                            text: "Êtes-vous sûr de vouloir archiver ce contrat ?",   
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
                            type: "delete",
                            url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/archivercontrat/"+id,

                            success:function(xml){
                                $('body').loadingModal('destroy');
                                swal("", "Vous venez d'archiver un contrat", "success");
                                table2.ajax.reload( null, false );
                                table.ajax.reload( null, false );
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

    var table=null;
  
    $(document).ready(function() {
    
            table = $('#datable_1').DataTable({
                responsive: true, 
                ajax:{
                    url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/arraycontratadmin/",
                    async: false
                },
                "drawCallback": function (settings) { 
                        var response = settings.json;
                        if(typeof response !== "undefined")
                        {
                            $('#totalContrats').html(response.iTotalRecords);
                        }
                },
                "fnRowCallback": function( nRow, mData, iDisplayIndex ) {
            // create link
            $('td:eq(4)', nRow).html('<a class="edddditable myeditables-class" href="#">'+mData[4]+'</a>');
            // add x-editable
            $('td:eq(4) a', nRow).editable({
                placement: 'top'
              });
              $('td:eq(4) a', nRow).on('save', function(e, params) {
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
                            data: {id : mData[0],idfilemaker : params.newValue },
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
            
//            table2 = $('#datable').DataTable({
//                "pageLength": 10,
//                responsive: true,
//                "ajax": "<?php// echo $this->Url->build('/',true)?>manager/utilisateurs/contratsDisabled/",
//                "language": language_data_table
//            });
              
    } );
<?php $this->Html->scriptEnd(); ?>

<?php $this->start('cssTop'); ?>
    <style>
        .check-circle{ color:green !important; font-size: 20px !important; }
        .exclamation-circle{ color:red !important; font-size: 20px !important; }
    </style>
<?php $this->end(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<!-- xeditable css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css", array('block' => 'cssTop')); ?>
