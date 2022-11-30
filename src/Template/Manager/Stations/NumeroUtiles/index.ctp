<?php $this->start('cssTop'); ?>
    <style>
        .check-circle{ color:green; font-size: 20px; }
        .exclamation-circle{ color:red; font-size: 20px; }
        .heading-bg {
            height: 100% !important;
        }
        div.error-message{
            color: red;
        }
        div.hide{
            visibility: hidden;
        }
        div.valid-message{
            color: green;
        }
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="ti-settings  mr-10"></i> Configuration</span>
    </div>
    <ul class="nav navbar-nav">
    <?php if($InfoGes['G']['role']!='gestionnaire'):?>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/pub">Publicités</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/packs/index">Packs De Services</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/parametrage/gps">Points GPS</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/index">Liste Des Gestionaires</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/registres/pages/8">Gestion Des Pages</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/cautions/index">Résidences de tourisme</a></li>
      <?php endif; ?>
      <li class="active"><a href="#">Stations</a></li>
      <?php if($InfoGes['G']['role']!='gestionnaire'):?>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/vacances/">Vacances</a></li>
      <?php endif; ?>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/utilisateurs/modelmail">Gestion de modèles</a></li>
    </ul>
  </div>
</nav>

<?=
    $this->element('stationsmenu');
?>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left mt-10">
                        <h6 class="panel-title txt-dark">Numéros Utiles</h6>
                </div>
                <div class="pull-right">
                    <a href="<?php echo $this->Url->build('/',true)?>manager/nutile/add" class="btn btn-primary pull-right">Ajouter Numéro</a>
                </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <table id="datable_1" class="table table-hover display  pb-30" >
                            <thead>
                                <tr>
                                    <th>Libellé</th>
                                    <th>Numéro</th>
                                    <th>Station</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Libellé</th>
                                    <th>Numéro</th>
                                    <th>Station</th>
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    $(".select2").select2();
    var errorMsgtel= $('#error-tel');
    var validMsgtel= $('#valid-tel');
    var edit=0;
    var table;
    function validateMyForm(){
        $('#number').val(telInput.intlTelInput("getNumber"))
        if(telInput.intlTelInput("isValidNumber")==false){
            errorMsgtel.removeClass("hide");
            return false;
        }
        return true;
    }
    var telInput = $("#number");
    telInput.intlTelInput({
                utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                initialCountry: 'fr',
                autoPlaceholder: true
                });
                var reset1 = function() {
                    errorMsgtel.addClass("hide");
                    validMsgtel.addClass("hide");
                };
                telInput.blur(function() {
                reset1();
                if ($.trim(telInput.val())) {
                if (telInput.intlTelInput("isValidNumber")) {
                    validMsgtel.removeClass("hide");
                } else {
                    errorMsgtel.removeClass("hide");
                }
                }
            });
    $(document).on('click', ".delete_n", function () {
        var id = $(this).attr("data-key");
        swal({
            title: "Suppression d\'un Numéro Utile",   
            text: "Êtes-vous sûr de vouloir supprimer ce Numéro Utile ?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#e6b034",   
            confirmButtonText: "OK",
            cancelButtonText: "ANNULER",  
            closeOnConfirm: true 
            }, function(){
            $('body').loadingModal({
                position: 'auto',
                text: 'Suppression en cours',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'doubleBounce'
                });
            $.ajax({
            type: "delete",
            url: "<?php echo $this->Url->build('/',true)?>/manager/nutile/delete/"+id,
            success:function(data){
                $('body').loadingModal('destroy');
                swal("", "Vous venez de supprimer un numéro utile", "success");
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
    });
    $(document).ready(function() {

        table=$('#datable_1').DataTable({
            responsive: true,
            "ajax":{
                "url": "<?= $this->Url->build('/',true)?>manager/nutile/allnutiles",
            },
            "language": language_data_table
        });
    });
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>