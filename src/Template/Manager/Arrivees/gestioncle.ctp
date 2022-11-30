<?php $this->start('cssTop'); ?>
    <style>
        .heading-bg {
            height: 100% !important;
        }
/*        #datable_1_filter{
            display:none !important;
        }*/
    </style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <h5 class="txt-dark">Gestion des clés</h5>
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
                            <div class="row ml-5">
                                <label>Rechercher : </label>
                                <label>Appartement&nbsp;: <input value="<?=$cleSelect=="appart"?$cleInput:'' ?>" id="appartInput" type="search"  placeholder="" aria-controls="datable_1"></label>
                                <label> /Propriétaire&nbsp;: <input value="<?=$cleSelect=="prop"?$cleInput:''?>" id="propInput" type="search"  placeholder="" aria-controls="datable_1"></label>
                            </div>
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                                <th>Résidence</th>
                                                <th>ID Appartement</th>
                                                <th>Numéro Appartement</th>
                                                <th>Propriétaire </th>
                                                <th>Email </th>
                                                <th>Position de clé</th>
                                                <th>&nbsp;</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>Résidence</th>
                                                <th>ID Appartement</th>
                                                <th>Numéro Appartement</th>
                                                <th>Propriétaire </th>
                                                <th>Email </th>
                                                <th>Position de clé</th>
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
        <div class="modal-dialog modal-md">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h5 class="modal-title">Position de clé</h5>
                        </div>
                        <div id="modal_body" class="modal-body">
                                
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="button" class="btn btn-danger" id="modifiergest">Modifier</button>
                        </div>
                </div>
        </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    var table=null;
    $(document).on('click', ".btn-circle", function () {
        $('#modal_body').empty();
        $('body').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
        var href = $(this).attr("data-href");
                    $.ajax({
                    type: "GET",
                    url: href,

                    success:function(xml){
                      $('#modal_body').html(xml);
                      $('body').loadingModal('destroy');
                      },
                    error: function(){
                        $('#responsive-modal').modal('hide');
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
    $(document).ready(function() {
        
            $("#modifiergest").on('click',function() {
                $('body').loadingModal({
                    position: 'auto',
                    text: 'Modification en cours...',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'doubleBounce'
                });
            $.ajax({
              type: "POST",
              url: "<?php echo $this->Url->build('/',true)?>manager/annonces/modifiergestioncle/",
              data:{vIdAnn:$('#cleid').val(), vCle:$('#poscle').val()},
              success:function(xml){
                //alert(xml)
                  $('#responsive-modal').modal('hide');
                  $('body').loadingModal('destroy');
                  table.ajax.reload();
                },
            error: function(){
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
        
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                input=$('#appartInput').val();
                val=data[1];
                val2=data[2];
                if (val2.toUpperCase().includes(input.toUpperCase().trim()) || val.toUpperCase().includes(input.toUpperCase().trim()) || input=="" )
                {
                    return true;
                }
                return false;
            }
        );
    
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                input=$('#propInput').val();
                val=data[3];
                val2=data[4];
                if (val2.toUpperCase().includes(input.toUpperCase().trim()) || val.toUpperCase().includes(input.toUpperCase().trim()) || input=="" )
                {
                    return true;
                }
                return false;
            }
        );

        table=$('#datable_1').DataTable({
            responsive: true,
            "ajax" :"<?php echo $this->Url->build('/',true)?>manager/arrivees/arraygestioncle/",
            "language": language_data_table
        });
        
        $('#appartInput, #propInput').keyup( function() {
            table.draw();
        });
        
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
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>