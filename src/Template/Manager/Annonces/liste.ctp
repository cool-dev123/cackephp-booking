<?php $this->start('cssTop'); ?>
    <style>
        .check-circle{ color:green; font-size: 20px; }
        .exclamation-circle{ color:red; font-size: 20px; }
        .dtr-data center a:first-of-type{ margin-right: 10px;  }
        td center a:first-of-type button{ margin-bottom: 3px !important;  }
    </style>
<?php $this->end(); ?>
    <div class="row heading-bg icantSelectIt">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h5 class="txt-dark">Annonces validées ou autres</h5>
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
                                                <th>ID</th>
                                                <th>Modification</th>
                                                <th>Bâtiment</th>
                                                <th>N°App</th>
                                                <th>Téléphone</th>
                                                <th>Portable</th>
                                                <th>E-mail</th>
                                                <th>Propr</th>
                                                <th>Gestionnaire</th>
                                                <th>Avis Général</th>
                                                <th>Contrat</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>ID</th>
                                                <th>Modification</th>
                                                <th>Bâtiment</th>
                                                <th>N°App</th>
                                                <th>Téléphone</th>
                                                <th>Portable</th>
                                                <th>E-mail</th>
                                                <th>Propr</th>
                                                <th>Gestionnaire</th>
                                                <th>Avis Général</th>
                                                <th>Contrat</th>
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

<!-- /.modal -->
<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title">Choisir Gestionnaire</h5>
            </div>
            <div id="modal-body" class="modal-body">
                <!--content loaded by ajax-->
            </div>
            <div class="modal-footer">
                    <button id="recherche_annuler" type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button id="modifiergest" type="button" class="btn btn-danger">Modifier</button>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    var table =null;
      $("#modifiergest").on('click',function() {

      $.ajax({
        type: "POST",
        async: true,
        url: "<?php echo $this->Url->build('/',true)?>manager/annonces/modifiergest/",
        data:{vIdGest:$('#gest').val(), vIdAnnonce:$('#annonceId').val(), vCle:$('#poscle').val()},
        success:function(xml){
            $('body').loadingModal({
                position: 'auto',
                text: 'Modification en cours...',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'doubleBounce'
            });
            table.ajax.reload(null,false);
            $('#responsive-modal').modal('hide');
          }
        });
    });
    
    $(document).on('click', ".buton_add", function () {
            var id = $(this).attr("data-key");
            $.ajax({
            type: "GET",
            url: "<?php echo $this->Url->build('/',true);?>manager/annonces/attribuergestionnaire/"+id,

            success:function(xml){
                $('#modal-body').html(xml);
              }
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

            table = $('#datable_1').DataTable({
            responsive: true,
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                $('body').loadingModal('destroy');
            },
            "columnDefs": [
                { "type": 'date-uk', "targets": 1 },
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 },
                { responsivePriority: 2, targets: -3 },
                { responsivePriority: 2, targets: -4 },
                { responsivePriority: 2, targets: -6 },
                { responsivePriority: 2, targets: 1 },
                { responsivePriority: 2, targets: 2 },
                { responsivePriority: 2, targets: 3 },
                { responsivePriority: 3, targets: 4 },
                { responsivePriority: 3, targets: 5 },
                { responsivePriority: 3, targets: -2 },
            ],
            "ajax": "<?php echo $this->Url->build('/',true)?>manager/annonces/paginateannonce",
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