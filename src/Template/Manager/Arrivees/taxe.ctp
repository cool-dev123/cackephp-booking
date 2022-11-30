<?php $this->start('cssTop'); ?>
    <style>
        .heading-bg {
            height: 100% !important;
        }
        th{text-align: center !important;}
        .dtr-data center button:first-of-type{ margin-bottom: 3px !important;  }
        td button:first-of-type{ margin-right: 10px;  }
        td{text-align: center;}
    </style>
<?php $this->end(); ?>

<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="fa fa-euro"></i> Taxe de séjour</span>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Les règles de taxe de séjour</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/recapitulatiftaxedesejour">Récapitulatif</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Taxe de séjour</h6>
                </div>
                <div class="pull-right">
                    <a data-toggle="modal" data-target="#responsive-modal-add" id="new_taxe" class="btn  btn-primary pull-right">Nouvelle taxe</a>
                </div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <div>
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                            <th>Ville</th>
                                            <th>Du</th>
                                            <th>Au</th>
                                            <th>NB étoiles</th>
                                            <th>Taxe</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                </thead>
                                <tbody id="tbody_table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.modal add-->
<div id="responsive-modal-add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="modal-title" class="modal-title"></h5>
            </div>
            <div id="modal-content" class="modal-body">
                    <!--content loaded by ajax-->
            </div>
            <div class="modal-footer">
                <button id="Annuler_button" type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button id="validate_button" type="button" class="btn btn-danger">Valider</button>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
var table=null;

    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-uk-pre": function ( a ) {
            if(a!=null){
                var ukDatea = a.substr(8, 10).split('-');
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

    function resetForm(){
        $("#modal-content").html("");
    }
    
    jQuery.validator.addMethod("pourcentage", function(value, element) {
        if($('#nb_etoiles').val()==0){
            return (value <= 5 && value >= 0);
        }else{
            return true;
        }
      }, "Entrer une valeur entre 0 et 5");

    $(document).ready(function() {
    
            $("#Annuler_button").on('click',function(){
                $("#modal-content").html("");
            });
            
            $("#new_taxe").on('click',function(){
                $('body').loadingModal({
                    position: 'auto',
                    text: '',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'doubleBounce'
                });
                $("#modal-content").empty();
                $('#modal-title').html("Nouvelle Taxe");
                $.ajax({
                        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/addtaxe/",
                        success:function(xml){
                                $("#modal-content").html(xml);
                                $('body').loadingModal('destroy');
                                },
                        error:function (){
                            $('#responsive-modal-add').modal('hide');
                            $('body').loadingModal('destroy');
                            $.toast().reset('all');
                            $("body").removeAttr('class');
                            $.toast({
                                heading: 'Erreur chargement du popup',
                                text: '',
                                position: 'bottom-right',
                                loaderBg:'#fec107',
                                icon: 'error',
                                hideAfter: 7000
                            });
                        }
                        });
            });
            
            $("#validate_button").on('click',function() {
                    $("#frm").validate({
                        rules: {
                                du: {
                                    required: true,
                                    date: false
                                },
                                au: {
                                    required: true,
                                    date: false
                                },
                                taxe: {
                                    required: true,
                                    number: true,
                                    pourcentage:true
                                }, 
                        },
                        errorPlacement: function(error, element) {
                            if (element.attr("name") == "taxe" )
                                error.insertAfter($('#before_taxe_error'));
                            else
                                error.insertAfter(element);
                        }
                });
                if($("#frm").valid()){
                    $('body').loadingModal({
                        position: 'auto',
                        text: '',
                        color: '#fff',
                        opacity: '0.7',
                        backgroundColor: 'rgb(0,0,0)',
                        animation: 'doubleBounce'
                    });
                    var b=false;
                    if( $('#type').val() == "modifier"){b=true;}
                    $.ajax({
                            type: "POST",
                            url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/majtaxe/",
                            data:{vId:$('#id_taxe').val(),vType:$('#type').val(),vDu:$('#du').val(),vAu:$('#au').val(),vNbEtoile:$('#nb_etoiles').val(),vVille:$('#ville').val(),vTaxe:$('#taxe').val()},
                            success:function(xml){
                                    $('body').loadingModal('destroy');
                                    resetForm();
                                    table.ajax.reload();
                                    $('#responsive-modal-add').modal('hide');
                                    $.toast().reset('all');
                                        $("body").removeAttr('class');
                                        if(b==false){
                                            $.toast({
                                                heading: 'Vous avez crée une nouvelle taxe',
                                                text: '',
                                                position: 'bottom-right',
                                                loaderBg:'#fec107',
                                                icon: 'success',
                                                hideAfter: 3000
                                            });
                                        }
                                        if(b==true){
                                            $.toast({
                                                heading: 'taxe modifiée',
                                                text: '',
                                                position: 'bottom-right',
                                                loaderBg:'#fec107',
                                                icon: 'success',
                                                hideAfter: 3000
                                            });
                                        }
                                    },
                        error:function (){
                            $('body').loadingModal('destroy');
                            $.toast().reset('all');
                            $("body").removeAttr('class');
                            $.toast({
                                heading: 'Erreur',
                                text: '',
                                position: 'bottom-right',
                                loaderBg:'#fec107',
                                icon: 'error',
                                hideAfter: 7000
                            });
                        }
                            });
                }
            });
            $(document).on('click', ".edit_taxe", function () {
                    $('body').loadingModal({
                        position: 'auto',
                        text: '',
                        color: '#fff',
                        opacity: '0.7',
                        backgroundColor: 'rgb(0,0,0)',
                        animation: 'doubleBounce'
                    });
                    var id = $(this).attr("data-key");
                    resetForm();
                    $('#modal-title').html("Modifier Taxe");
                    $.ajax({
                        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/edittaxe/"+id,
                        success:function(xml){
                                $("#modal-content").html(xml);
                                $('body').loadingModal('destroy');
                                },
                        error:function (){
                            $('#responsive-modal-add').modal('hide');
                            $('body').loadingModal('destroy');
                            $.toast().reset('all');
                            $("body").removeAttr('class');
                            $.toast({
                                heading: 'Erreur chargement du popup',
                                text: '',
                                position: 'bottom-right',
                                loaderBg:'#fec107',
                                icon: 'error',
                                hideAfter: 7000
                            });
                        }
                        });
            });
            
            $(document).on('click', ".delete_taxe", function () {
                var id = $(this).attr("data-key");
                    var value = $(this).attr("data-name");
                    swal({   
						title: "Suppression de taxe séjour",   
						text: "Êtes-vous  sûr de supprimer cette taxe de séjour "+value,   
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
						url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/deletetaxe/"+id,

						success:function(xml){
                                                        $('body').loadingModal('destroy');
							swal("", "Vous venez de supprimer une taxe", "success");
							table.ajax.reload();
						  },
                                                error:function (){
                                                    $('body').loadingModal('destroy');
                                                    $.toast().reset('all');
                                                    $("body").removeAttr('class');
                                                    $.toast({
                                                        heading: 'Erreur',
                                                        text: '',
                                                        position: 'bottom-right',
                                                        loaderBg:'#fec107',
                                                        icon: 'error',
                                                        hideAfter: 7000
                                                    });
                                                }
						}); 
					});
            });

            table = $('#datable_1').DataTable({
                "ajax": "<?php echo $this->Url->build('/',true)?>manager/arrivees/listtaxe/",
                responsive: true,
                "columnDefs": [
                    { "type": 'date-uk', "targets": 2 },
                    { "type": 'date-uk', "targets": 1 },
                ],
                "language": language_data_table
        });
              
    } );
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>