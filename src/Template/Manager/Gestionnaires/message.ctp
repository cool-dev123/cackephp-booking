<?php $this->start('cssTop'); ?>
<style>
    .heading-bg {
            height: 100% !important;
    }
    .grab{
        cursor: pointer;
    }
    .backGroundFonce{
        background-color: #fcfcfc !important;
    }
</style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h5 class="txt-dark">Mes messages</h5>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <a data-toggle="modal" data-target="#modal_add" id="add_message_button" class="btn  btn-primary pull-right">Nouveau message</a>
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
                                                <th>&nbsp;</th>
                                                <th>De</th>
                                                <th>Rôle</th>
                                                <th>Sujet</th>
                                                <th>Date</th>                                                
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>&nbsp;</th>
                                                <th>De</th>
                                                <th>Rôle</th>
                                                <th>Sujet</th>
                                                <th>Date</th>
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

<!-- view modal content -->
<div id="View_Message" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h5 class="modal-title" id="myModalLabel">Message</h5>
                        </div>
                        <div id="View_Message_body" class="modal-body">
                            
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        </div>
                </div>
                <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- /.add modal -->
<div id="modal_add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h5 class="modal-title">Envoyer message</h5>
                        </div>
                        <div id="modal_add_body" class="modal-body">
                                <form>
                                        <div class="form-group">
                                                <label for="recipient-name" class="control-label mb-10">Recipient:</label>
                                                <input type="text" class="form-control" id="recipient-name">
                                        </div>
                                        <div class="form-group">
                                                <label for="message-text" class="control-label mb-10">Message:</label>
                                                <textarea class="form-control" id="message-text"></textarea>
                                        </div>
                                </form>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button id="send_mail" type="button" class="btn btn-danger">Envoyer</button>
                        </div>
                </div>
        </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
<!-- Select2 JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
var table=null;
    $(document).on('click', ".modifier_taxe", function () {
        $('body').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
        $("#View_Message_body").empty();
        var id = $(this).attr("data-key");
        $.ajax({
                type: "get",
                url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/viewmessage/"+id,
                success:function(xml){
                        $("#View_Message_body").html(xml);
                        table.ajax.reload(null, false);
                        $('body').loadingModal('destroy');
                        },
                error:function(){
                    $('#View_Message').modal('hide');
                    $.toast().reset('all');
                    $("body").removeAttr('class');
                    $.toast({
                        heading: 'Erreur',
                        text: '',
                        position: 'bottom-right',
                        loaderBg:'#fec107',
                        icon: 'error',
                        hideAfter: 5000
                    });
                    $('body').loadingModal('destroy');
                }
        });
    });
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-euro-pre": function ( a ) {
            var x;

            if ( $.trim(a) !== '' ) {
                var frDatea = $.trim(a).split(' ');
                var frTimea = (undefined != frDatea[1]) ? frDatea[1].split(':') : [00,00,00];
                var frDatea2 = frDatea[0].split('/');
                x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + ((undefined != frTimea[2]) ? frTimea[2] : 0)) * 1;
            }
            else {
                x = Infinity;
            }

            return x;
        },

        "date-euro-asc": function ( a, b ) {
            return a - b;
        },

        "date-euro-desc": function ( a, b ) {
            return b - a;
        }
    } );
    $(document).ready(function() {
    
        $("#send_mail").on('click',function() {
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
				url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/setmessage/",
				data:{vId:$('#de').val(),vType:$('#gestionnaire').val(),vSujet:$('#objet').val(),vMsg:$('#msg').val()},
				success:function(xml){
						$('#modal_add').modal('hide');
                                                $.toast().reset('all');
                                                $("body").removeAttr('class');
                                                $.toast({
                                                    heading: 'Message envoyé',
                                                    text: '',
                                                    position: 'bottom-right',
                                                    loaderBg:'#fec107',
                                                    icon: 'success',
                                                    hideAfter: 5000
                                                });
                                                table.ajax.reload(null, false);
                                                $('body').loadingModal('destroy');
					},
                                error:function(){
                                    $('#modal_add').modal('hide');
                                    $.toast().reset('all');
                                    $("body").removeAttr('class');
                                    $.toast({
                                        heading: 'Erreur',
                                        text: '',
                                        position: 'bottom-right',
                                        loaderBg:'#fec107',
                                        icon: 'error',
                                        hideAfter: 5000
                                    });
                                    $('body').loadingModal('destroy');
                                }
				});
	});
    
        $("#add_message_button").click(function(){
            $("#modal_add_body").empty();
            $.ajax({
                            type: "get",
                            url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/addmessage/",
                            success:function(xml){
                                    $("#modal_add_body").html(xml);
                                    },
                            error:function(){
                                $('#modal_add').modal('hide');
                                $.toast().reset('all');
                                $("body").removeAttr('class');
                                $.toast({
                                    heading: 'Erreur',
                                    text: '',
                                    position: 'bottom-right',
                                    loaderBg:'#fec107',
                                    icon: 'error',
                                    hideAfter: 5000
                                });
                                $('body').loadingModal('destroy');
                            }
                    });
        });
        
        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "date-euro-pre": function ( a ) {
                var x;

                if ( $.trim(a) !== '' ) {
                    var frDatea = $.trim(a).split(' ');
                    var frTimea = (undefined != frDatea[1]) ? frDatea[1].split(':') : [00,00,00];
                    var frDatea2 = frDatea[0].split('/');
                    x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + ((undefined != frTimea[2]) ? frTimea[2] : 0)) * 1;
                }
                else {
                    x = Infinity;
                }

                return x;
            },

            "date-euro-desc": function ( a, b ) {
                return a - b;
            },

            "date-euro-asc": function ( a, b ) {
                return b - a;
            }
        } );

            table=$('#datable_1').DataTable({
            responsive: true,
            "ajax": "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/arraymessage/",
            "createdRow": function ( row, data, index ) {
                if ( data[4].includes("data-oppened='true'") ) {
                    $(row).addClass('backGroundFonce');
                }
            },
            "columnDefs": [
                { "type": 'date-euro', "targets": 3 },
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
<!-- select2 CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>