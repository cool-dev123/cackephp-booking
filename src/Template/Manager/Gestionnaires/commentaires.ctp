<?php $this->start('cssTop'); ?>
    <style>
        .check-circle{ color:green !important; font-size: 20px !important; }
        .exclamation-circle{ color:red !important; font-size: 20px !important; }
        td center button:first-of-type{
            margin-right: 5px;
        }
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="icon-home"></i> Annonces</span>
    </div>
    <ul class="nav navbar-nav">
    <!-- AJOUTER TEST SI ADMIN OU GEST -->
    <?php if($InfoGes['G']['role'] != "admin"){ ?>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/mesannonces/">Toutes les annonces</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/annonce/">Annonces en attente de validation</a></li>
    <?php }else{ ?>
        <li><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/periodeannonces">Toutes les annonces</a></li>
        <li><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/index">Annonces en attente de validation</a></li>
    <?php } ?>
      <li class="active"><a href="#">Valider Commentaires</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Listes des commentaires</h6>
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
                                                <th>#</th>
                                                <th>Locataire</th>
                                                <th>Annonce ID</th>
                                                <th>Propriétaire</th>
                                                <th>Contact Propriétaire</th>
                                                <th>Titre</th>
                                                <th>Note Globale</th>
                                                <th>&nbsp;</th>
                                                <th>Valider</th>
                                                <th></th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                                <th>#</th>
                                                <th>Locataire</th>
                                                <th>Annonce ID</th>
                                                <th>Propriétaire</th>
                                                <th>Contact Propriétaire</th>
                                                <th>Titre</th>
                                                <th>Note Globale</th>
                                                <th>&nbsp;</th>
                                                <th>Valider</th>
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
</div>

<!-- /.modal -->
<div id="send_mail_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h5 class="modal-title">Contacter Propriétaire</h5>
                        </div>
                        <div id="send_mail_modal_body" class="modal-body">
                                
                        </div>
                        <div class="modal-footer">
                                <button id="cancel_send_mail" type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="button" id="send_mail" class="btn btn-danger">Envoyer</button>
                        </div>
                </div>
        </div>
</div>

<!-- sample modal content -->
<div id="comment_details" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h5 class="modal-title" id="myModalLabel">Détails commentaire</h5>
                        </div>
                        <div id="comment_details_body" class="modal-body">
                            
                        </div>
                        <div class="modal-footer">
                            <button id="cancel_comment_details" type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
                        </div>
                </div>
                <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/star-rating.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    var table=null;
    $(document).on('click', ".contacterProp", function () {
        $('body').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
        $('#send_mail_modal_body').empty();
        var href = $(this).attr("data-href");
                    $.ajax({
                            type: "GET",
                            url: href,
                            async: true,
                            success:function(xml){
                                $('#send_mail_modal_body').html(xml);
                                $('body').loadingModal('destroy');
                              },
                            error: function(){
                                $('#send_mail_modal').modal('hide');
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
                    $('body').loadingModal('destroy');
    });
    $(document).on('click', ".edit_loca", function () {
        $('body').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
        $('#comment_details_body').empty();
        var href = $(this).attr("data-href");
                    $.ajax({
                            type: "GET",
                            url: href,
                            async: true,
                            success:function(xml){
                                $('#comment_details_body').html(xml);
                                $('body').loadingModal('destroy');
                              },
                            error: function(){
                                $('#comment_details').modal('hide');
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
        $('body').loadingModal('destroy');
    });
    $(document).on('click', ".delete_loc", function () {
        var id = $(this).attr("data-key");
                    swal({   
                                title: "Suppression d'un commentaire",   
                                text: "Êtes-vous sûr de vouloir supprimer ce commentaire ?",   
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
                                url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/deletecommentaire/"+id,

                                success:function(xml){
                                        swal("", "Vous venez de supprimer un commentaire", "success");
                                        table.ajax.reload();
                                        $('body').loadingModal('destroy');
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
    });
    $(document).on('click', "a[id^='activate']", function () {
        $('body').loadingModal({
                                            position: 'auto',
                                            text: '',
                                            color: '#fff',
                                            opacity: '0.7',
                                            backgroundColor: 'rgb(0,0,0)',
                                            animation: 'doubleBounce'
                                          });
                    var id = $(this).attr("data-key");
                    var type = $(this).attr("data-type");
                    if (type == "activate"){
                        $.ajax({
                            type: "GET",
                            url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/activatecommentaire/"+id,
                            success:function(xml){
                                $.toast().reset('all');
                                $("body").removeAttr('class');
                                $.toast({
                                    heading: 'Vous venez d\'activer un commentaire',
                                    text: '',
                                    position: 'bottom-right',
                                    loaderBg:'#fec107',
                                    icon: 'success',
                                    hideAfter: 5000
                                });
                                //modifier style a
                                $('#activate_'+id).attr('class','check-circle');
                                $('.dtr-data').children('#activate_'+id).attr('class','check-circle');
                                
                                $('#activate_'+id).attr('data-type','desactivate');
                                $('.dtr-data').children('#activate_'+id).attr('data-type','desactivate');
                                
                                $('#activate_'+id+' i').attr('class','fa fa-check-circle');
                                $('body').loadingModal('destroy');
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
                    }else if(type == "desactivate"){
                        $.ajax({
                                type: "GET",
                                url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/desactivatecommentaire/"+id,
                                success:function(xml){
                                    $.toast().reset('all');
                                    $("body").removeAttr('class');
                                    $.toast({
                                        heading: 'Vous venez de désactiver un commentaire',
                                        text: '',
                                        position: 'bottom-right',
                                        loaderBg:'#fec107',
                                        icon: 'success',
                                        hideAfter: 5000
                                    });
                                    //modifier style a
                                    $('#activate_'+id).attr('class','exclamation-circle');
                                    $('.dtr-data').children('#activate_'+id).attr('class','exclamation-circle');
                                    
                                    $('#activate_'+id).attr('data-type','activate');
                                    $('.dtr-data').children('#activate_'+id).attr('data-type','activate');
                                    
                                    $('#activate_'+id+' i').attr('class','fa fa-exclamation-circle');
                                    $('body').loadingModal('destroy');
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
                    }
    });
    
    $(document).ready(function() {
        
        $("#cancel_comment_details").click(function(){
            $("comment_details_body").html("");
        });
        
        $("#cancel_send_mail").click(function(){
            $("send_mail_modal_body").html("");
        });
        
        $("#send_mail").on('click',function() {
                        $('body').loadingModal({
                            position: 'auto',
                            text: 'envoi message...',
                            color: '#fff',
                            opacity: '0.7',
                            backgroundColor: 'rgb(0,0,0)',
                            animation: 'doubleBounce'
                        });

			$.ajax({
				type: "POST",
				url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/confirmsendmailCommentaire/",
				data:{vFrom:$('#from').val(),vTo:$('#to').val(),vObjet:$('#objet').val(),vMsg:$('#msg').val()},
				success:function(xml){
						$('body').loadingModal('destroy');
                                                $('#send_mail_modal').modal('hide');
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

            table=$('#datable_1').DataTable({
            responsive: true,
            "ajax": "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/arraycommentaires/",
            "language": language_data_table,
            "order": []
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
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/css/star-rating.min.css", array('block' => 'cssTop')); ?>