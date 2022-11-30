<?php $this->start('cssTop'); ?>
    <style>
        .check-circle{ color:green !important; font-size: 20px !important; }
        .exclamation-circle{ color:red !important; font-size: 20px !important; }
        td center button:first-of-type{
            margin-bottom: 3px;
        }
        .dtr-data center button:first-of-type{
            margin-right: 10px !important;
        }
        @media only screen and (min-width: 768px) {
            #addContratButton{margin-top: 27px;}
        }
    </style>
<?php $this->end(); ?>
<div class="row mt-10 icantSelectIt">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    </div>
</div>
    
<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="panel card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box pt-10 pb-10">
                        <div class="container-fluid">
                            <div class="row text-center">
                                <span class="block"><span class="initial"></span><span id="totalContrats" class="txt-primary font-48 weight-300 counter-anim data-rep">0</span></span>
                                <span class="block weight-300 font-24 txt-dark">Contrats</span>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="panel card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box pt-10 pb-10">
                        <div class="container-fluid">
                            <div class="row text-center">
                                <span class="block weight-300 font-24 txt-dark">Création d'un contrat</span>
                                <a id="addContratButton" href="<?php echo $this->Url->build('/',true)?>manager/arrivees/contrat/" class="btn  btn-primary">Créer un contrat</a>
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
            <div class="panel-heading">
                <div class="pull-left">
                        <h6 class="panel-title txt-dark">Mes Contrats</h6>
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
                                        <th data-priority="1">Type Contrat</th>
                                        <th data-priority="4">ID Propriétaire</th>
                                        <th data-priority="3">E-Mail</th>
                                        <th data-priority="5">Propriétaire</th>
                                        <th data-priority="4">id annonce</th>
                                        <th data-priority="4">Num App</th>
                                        <th data-priority="4">Résidence</th>
                                        <th data-priority="4">Mise en ligne</th>
                                        <th data-priority="2">Contrat</th>
                                        <th data-priority="2"></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Type Contrat</th>
                                        <th>ID Propriétaire</th>
                                        <th>E-Mail</th>
                                        <th>Propriétaire</th>
                                        <th>id annonce</th>
                                        <th>Num App</th>
                                        <th>Residence</th>
                                        <th>Mise en ligne</th>
                                        <th>Contrat</th>
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
            <div class="panel-heading">
                <div class="pull-left">
                        <h6 class="panel-title txt-dark">Contrats à activer</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <div>
                            <table id="datable_0" class="table table-hover display  pb-30" >
                                <thead>
                                    <tr>
                                        <th data-priority="1">ID Propri&eacute;taire</th>
                                        <th data-priority="3">ID Annonce</th>
                                        <th data-priority="5">Propriétaire</th>
                                        <th data-priority="4">Email</th>
                                        <th data-priority="2">Contrat</th>
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

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
var table=null;

    $(document).on('click', ".delete_station", function () {
        var id = $(this).attr("data-key");
                    var name = $(this).attr("data-name");
                    swal({   
						title: "Suppression d\'un contrat",   
						text: "Voulez-vous supprimer le contrat de "+name,   
						type: "warning",   
						showCancelButton: true,   
						confirmButtonColor: "#e6b034",   
						confirmButtonText: "OK",
						cancelButtonText: "ANNULER",  
						closeOnConfirm: false 
					}, function(){
                                                $('body').loadingModal({
                                                    position: 'auto',
                                                    text: 'Chargement...',
                                                    color: '#fff',
                                                    opacity: '0.7',
                                                    backgroundColor: 'rgb(0,0,0)',
                                                    animation: 'doubleBounce'
                                                });
						$.ajax({
						type: "GET",
						url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/supprimercontrat/"+id,

						success:function(xml){
                                                        table.ajax.reload();
							swal("", "Vous venez de supprimer le contrat de "+name, "success");
							$('body').loadingModal('destroy');
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
                    var name = $(this).attr("data-name");
                    swal({   
						title: "Archivage d\'un contrat",   
						text: "Voulez-vous archiver le contrat de "+name,   
						type: "warning",   
						showCancelButton: true,   
						confirmButtonColor: "#e6b034",   
						confirmButtonText: "OK",
						cancelButtonText: "ANNULER",  
						closeOnConfirm: false 
					}, function(){
                                                $('body').loadingModal({
                                                    position: 'auto',
                                                    text: 'Chargement...',
                                                    color: '#fff',
                                                    opacity: '0.7',
                                                    backgroundColor: 'rgb(0,0,0)',
                                                    animation: 'doubleBounce'
                                                });
						$.ajax({
						type: "GET",
						url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/archivercontrat/"+id,

						success:function(xml){
                                                        table.ajax.reload();
							swal("", "Vous venez d'archiver le contrat de "+name, "success");
							$('body').loadingModal('destroy');
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
    
//            $('#datable_0').DataTable({
//                "info" : false,
//                "pageLength": 10,
//                "ajax": "<?php //echo $this->Url->build('/',true)?>manager/utilisateurs/gpaginategestionnaire/",
//                responsive: true,
//                "language": language_data_table
//            });
    
            table=$('#datable_1').DataTable({
                "order": [[ 7, 'desc' ]],
                columnDefs: [
                    { orderable: true, className: 'reorder', type: 'date-uk', targets: 7 },                 
                    { type: 'html', targets: 8 }                 
                     
                ],
            ajax:{
                    url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/arraycontrat/<?php echo $InfoGes['G']['id']?>",
                    async: false
                },
            "drawCallback": function (settings) { 
                        var response = settings.json;
                        if(typeof response !== "undefined")
                        {
                            $('#totalContrats').html(response.iTotalRecords);
                        }
                    }, 
            responsive: true,
            "language": language_data_table
        });

    });
    function activate(id){
            $('body').loadingModal({
                position: 'auto',
                text: 'Chargement...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'doubleBounce'
              });
            $.ajax({
                    async: true,
                    type: "POST",
                    url: "<?php echo $this->Url->build('/',true)?>manager/annonces/activer",
                    data: {id : id},
                    success:function(xml){
                            if(xml=="ok") {
                                $('#coeur_'+id).attr('class','check-circle');
                                $('.dtr-data').children('#coeur_'+id).attr('class','check-circle');
                                $('#coeur_'+id+' i').attr('class','fa fa-check-circle');
                                $.toast().reset('all');
                                $("body").removeAttr('class');
                                $.toast({
                                    heading: 'success',
                                    text: 'Vous venez d\'activer un contrat',
                                    position: 'bottom-right',
                                    loaderBg:'#fec107',
                                    icon: 'success',
                                    hideAfter: 4000
                                });
                            }
                            else {
                                $('#coeur_'+id).attr('class','exclamation-circle');
                                $('.dtr-data').children('#coeur_'+id).attr('class','exclamation-circle');
                                $('#coeur_'+id+' i').attr('class','fa fa-exclamation-circle');
                                $.toast().reset('all');
                                $("body").removeAttr('class');
                                $.toast({
                                    heading: 'success',
                                    text: 'Vous venez de désactiver un contrat',
                                    position: 'bottom-right',
                                    loaderBg:'#fec107',
                                    icon: 'success',
                                    hideAfter: 4000
                                });
                            }
                    $('body').loadingModal('destroy');
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