<div class="row heading-bg icantSelectIt">
    <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
      <h5 class="txt-dark">Facture Contrat</h5>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/admincontrat/" class="btn  btn-primary pull-right"><i class="fa fa-arrow-left"></i> Contrats</a>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div>
                        <blockquote style="text-align:center;">
                            <form class="form-inline">
                                <span>Gestionnaire :</span>
                                <select class="form-control date" type="text" id="id_gestionnaire">
                                    <option value="0">Tous</option>
                                    <?php foreach($a_gest as $k=>$v):?>
                                    <option value="<?php echo $k?>"><?php echo $v?></option>
                                    <?php endforeach;?>
                                </select>
                                &nbsp;&nbsp;&nbsp;
                                <span>Mois :</span>
                                <select class="form-control date" type="text" id="from_date">
                                    <option value="1">Janvier</option>
                                    <option value="2">Février</option>
                                    <option value="3">Mars</option>
                                    <option value="4">Avril</option>
                                    <option value="5">Mai</option>
                                    <option value="6">Juin</option>
                                    <option value="7">Juillet</option>
                                    <option value="8">Août</option>
                                    <option value="9">Septembre</option>
                                    <option value="10">Octobre</option>
                                    <option value="11">Nouvembre</option>
                                    <option value="12">Décembre</option>
                                </select>
                                <button type="button" id="btn_suivi" href="#" class="btn btn-primary">Valider</button>
                            </form>
                        </blockquote>
                    </div>
                    <div class="table-wrap">
                        <div>
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                            <th>Gestionnaire</th>
                                            <th>Station</th>
                                            <!-- <th>Village</th> -->
                                            <!-- <th>Résidence</th> -->
                                            <th>Num App</th>
                                            <th>Propriétaire</th>
                                            <th>Type Contrat</th>
                                            <th>Prix</th>
                                            <th>Commission</th>
                                            <th>Date paiement</th>
                                            <th>Date Mise En Route</th>
                                            <th></th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                            <th>Gestionnaire</th>
                                            <th>Station</th>
                                            <!-- <th>Village</th> -->
                                            <!-- <th>Résidence</th> -->
                                            <th>Num App</th>
                                            <th>Propriétaire</th>
                                            <th>Type Contrat</th>
                                            <th>Prix</th>
                                            <th>Commission</th>
                                            <th>Date paiement</th>
                                            <th>Date Mise En Route</th>
                                            <th></th>
                                        </tr>
                                </tfoot>
                                <tbody id="tbody_table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="button-list mt-25">
                                <button id="gererfacture" class="btn btn-warning btn-anim"><i class="fa fa-spin fa-gear"></i><span class="btn-text">Gerer facture</span></button>

                                <button id="envoyerfacture" class="btn btn-success btn-anim"><i class="fa fa-send"></i><span class="btn-text">Envoyer facture vers le gestionnaire</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
var table=null;
//        $(document).on('click', ".suspendu", function () {
//		var id = $(this).attr("data-key");
//		var val = $(this).attr("data-val");
//                swal({   
//                            title: "Valider ou suspendre la visibilité de l'annonce",   
//                            text: "Voulez-vous valider ou suspendre la visibilité de l'annonce dans la liste de non arrivées ?",   
//                            type: "warning",   
//                            showCancelButton: true,   
//                            confirmButtonColor: "#e6b034",   
//                            confirmButtonText: "OK",
//                            cancelButtonText: "ANNULER",  
//                            closeOnConfirm: true 
//                    }, function(){
//                            $('body').loadingModal({
//                                position: 'auto',
//                                text: 'Chargement...',
//                                color: '#fff',
//                                opacity: '0.9',
//                                backgroundColor: 'rgb(0,0,0)',
//                                animation: 'doubleBounce'
//                            });
//                            $.ajax({
//                                    type: "GET",
//                                    url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/editvisble/"+id+"/"+val,
//
//                                    success:function(xml){
//                                        $.toast().reset('all');
//                                        $("body").removeAttr('class');
//                                        $.toast({
//                                            heading: 'success',
//                                            text: 'Vous vener suspendre la visibilité de l\'annonce',
//                                            position: 'bottom-right',
//                                            loaderBg:'#fec107',
//                                            icon: 'success',
//                                            hideAfter: 4000
//                                        });
//                                        $('body').loadingModal('destroy');
//                                        redraw();
//
//                                            }
//                            });
//                    });
//	});

    function redraw(){
        $("#tbody_table").empty();
        $("#tbody_table").html("<tr><td style=\"text-align: center;\" colspan=\"11\">Traitement en cours...</td></tr>");
        table.ajax.reload(null, true);
    }

    $('#btn_suivi').on('click',function() {
        table.clear();
        redraw();
    });

    $(document).ready(function() {
                $("#gererfacture").on('click',function() {
                    if($('#id_gestionnaire').val()==0){
                        $.toast().reset('all');
                                    $("body").removeAttr('class');
                                    $.toast({
                                        heading: 'Veuillez choisir un gestionnaire',
                                        text: '',
                                        position: 'bottom-right',
                                        loaderBg:'#fec107',
                                        icon: 'error',
                                        hideAfter: 4000
                                    });
                    }
                    else{
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
                            url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/gererfacture/",
                            data:{vGest:$('#id_gestionnaire').val(),vMois:$('#from_date').val()},
                            success:function(xml){
                                        $('body').loadingModal('destroy');
                                        window.open("https://www.alpissime.com/gestionnaire/facture_"+xml+".pdf");

                                    },
                            error:function(){
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
            	$("#envoyerfacture").on('click',function() {
                                if($('#id_gestionnaire').val()==0){
                                    $.toast().reset('all');
                                    $("body").removeAttr('class');
                                    $.toast({
                                        heading: 'Veuillez choisir un gestionnaire',
                                        text: '',
                                        position: 'bottom-right',
                                        loaderBg:'#fec107',
                                        icon: 'error',
                                        hideAfter: 4000
                                    });
                                }
                                else{
                                $('body').loadingModal({
                                    position: 'auto',
                                    text: '',
                                    color: '#fff',
                                    opacity: '0.7',
                                    backgroundColor: 'rgb(0,0,0)',
                                    animation: 'doubleBounce'
                                });

                    var liste, listeDate, texte, texteDate;
                    liste = document.getElementById("id_gestionnaire");
                    texte = liste.options[liste.selectedIndex].text;

                    listeDate = document.getElementById("from_date");
                    texteDate = listeDate.options[listeDate.selectedIndex].text;
                    var today=new Date();
                    var annee = today.getFullYear();
                    var DateFacture = texteDate+" "+annee;


                                $.ajax({
                                        type: "POST",
                                        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/sendmail/",
                                        data:{vGest:$('#id_gestionnaire').val(),vMois:$('#from_date').val()},
                                        success:function(xml){
                                                        $('body').loadingModal('destroy');
                                                        $.toast().reset('all');
                                                            $("body").removeAttr('class');
                                                            $.toast({
                                                                heading: 'Facture envoyée au gestionnaire',
                                                                text: '',
                                                                position: 'bottom-right',
                                                                loaderBg:'#fec107',
                                                                icon: 'success',
                                                                hideAfter: 5000
                                                        });
                                                },
                                        error:function(){
                                            $('body').loadingModal('destroy');
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
                                        }
                                        });
                                }
                });

            table = $('#datable_1').DataTable({
            responsive: true,
            "ajax": {
                      "url": "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/arraycontrat/",
                      "data": function ( d ) {
                        return $.extend( {}, d, {
                          "gestionnaire": $('#id_gestionnaire').val(),
                          "from": $('#from_date').val()
                        } );
                      }
                    },
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
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>