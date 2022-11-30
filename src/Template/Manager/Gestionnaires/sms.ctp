<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="ti-comment-alt"></i> SMS & MAIL</span>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/smslocataire/">Envoyer un modèle</a></li>
      <li class="active"><a href="#">SMS Gestionaires</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/smscsv">SMS Propriétaires</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left">
                        <h6 class="panel-title txt-dark">Les SMS gestionnaires</h6>
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
                                        <th>Gestionnaire</th>
                                        <th>Total sms</th>

                                        <th>Envoyé</th>
                                        <th>Reste</th>
                                        <th></th>
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
    </div>
</div>

<!-- /.modal -->
<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h5 class="modal-title">Modal Content is Responsive</h5>
                        </div>
                        <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                            <input type="text" class="form-control" id="solde-sms">
                                            <input type="hidden" id="idGest">
                                    </div>
                                </form>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button id="SubmitTheAdd" type="button" class="btn btn-danger">Ajouter</button>
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
var namegest=null;

    $(document).ready(function() {
            
            table=$('#datable_1').DataTable({
            responsive: true,
            searching: false, paging: false, info: false, "ordering": false,
            "ajax": "<?php  echo $this->Url->build('/',true) ?>manager/gestionnaires/getarraysms/",
            "language": language_data_table
        });
        $(document).on('click', ".edit_sms", function () {
            var name = $(this).attr("data-name");
            var id = $(this).attr("data-key");
            $(".modal-title").html("Ajouter solde pour "+name);
            namegest=name;
            document.getElementById('solde-sms').value = '';
            document.getElementById('idGest').value = id;
            
        });
        
        $('#SubmitTheAdd').on('click', function () {
            $('body').loadingModal({
                    position: 'auto',
                    text: '',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'doubleBounce'
            });
            var id = $("#idGest").val();
            $.ajax({
                type: "GET",
                url: "<?php  echo $this->Url->build('/',true) ?>manager/gestionnaires/addsms/"+id+"/"+$('#solde-sms').val(),

                success:function(xml){
                    table.ajax.reload( null, false );
                    $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Succès',
                            text: 'Vous avez ajouter '+$('#solde-sms').val()+' sms à '+namegest,
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 5000
                        });
                        namegest=null;
                    document.getElementById('solde-sms').value = '';
                    document.getElementById('idGest').value = id;
                    $('body').loadingModal('destroy');
                    $('#responsive-modal').modal('hide');
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
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>