<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h5 class="txt-dark">Contrats en attente d'activation</h5>
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
                                        <th>ID Annonce</th>
                                        <th>Propriétaire</th>
                                        <th>Email</th>
                                        <th>Contrat</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID Propri&eacute;taire</th>
                                        <th>ID Annonce</th>
                                        <th>Propriétaire</th>
                                        <th>Email</th>
                                        <th>Contrat</th>
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    $(document).ready(function() {
        
            $('#datable_1').DataTable({
                "ajax": "<?php echo $this->Url->build('/',true)?>manager/utilisateurs/gpaginategestionnaire/",
                responsive: true,
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
                                    text: 'Vous vener activer un contrat',
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
                                    text: 'Vous vener désactiver un contrat',
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
<?php $this->Html->scriptEnd(); ?>
    
<?php $this->start('cssTop'); ?>
    <style>
        .check-circle{ color:green !important; font-size: 20px !important; }
        .exclamation-circle{ color:red !important; font-size: 20px !important; }
    </style>
<?php $this->end(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>