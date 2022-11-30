<div class="row heading-bg icantSelectIt">
    <div class="col-sm-12">
      <h5 class="txt-dark">Liste de contact des propriétaires</h5>
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
                                                <th>Annonce</th>
                                                <th>Date</th>
                                                <th>Nom</th>
                                                <th>T&eacute;l&eacute;phone</th>
                                                <th>E-mail</th>
                                                <th>Demande</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>Annonce</th>
                                                <th>Date</th>
                                                <th>Nom</th>
                                                <th>T&eacute;l&eacute;phone</th>
                                                <th>E-mail</th>
                                                <th>Demande</th>
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
    </div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title" id="myModalLabel">Alpissime.com</h5>
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
                        async: true,
                        type: "GET",
                        url: "<?php echo $this->Url->build('/',true);?>manager/utilisateurs/getmessage/"+id,

                        success:function(xml){
                            $('#modal-fiche-publicité-body').append(xml);
                          },
                        error: function(){
                        $('#myModal').modal('hide'); 
                        $('body').loadingModal('destroy');
                        $.toast().reset('all');
                                $("body").removeAttr('class');
                                $.toast({
                                    heading: 'Erreur',
                                    text: 'erreur chargement du message',
                                    position: 'bottom-right',
                                    loaderBg:'#fec107',
                                    icon: 'error',
                                    hideAfter: 4000
                                });
                    }
                    });
        $('body').loadingModal('destroy');
    });
    
    $(document).ready(function() {

            $('#datable_1').DataTable({
            responsive: true,
            "ajax": "<?php echo $this->Url->build('/',true)?>manager/utilisateurs/paginatecontactgestionnaire/",
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
                        
<?php $this->Html->scriptEnd(); ?>
    
<?php $this->start('cssTop'); ?>
    <style>
        .check-circle{ color:green; font-size: 20px; }
        .exclamation-circle{ color:red; font-size: 20px; }
    </style>
<?php $this->end(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>