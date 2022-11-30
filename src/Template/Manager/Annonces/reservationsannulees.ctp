<?php $this->start('cssTop'); ?>
    <style>
        @media screen and (min-width: 768px) and (max-width: 1163px) {
            .form-inline .form-control { width: 15% !important; }
            .costum_span{ font-size: 80% !important;}
        }
        @media screen and (max-width: 767px) {
            .form-inline .btn {margin-top: 1%; padding: 8px 25px;}
        }
        .dtr-data center a:first-of-type{ margin-bottom: 3px !important;  }
        td center a:first-of-type button{ margin-right: 5px;  }
        .remboursementdate {
            color: black;
            font-style: italic;
            font-size: 17px;
            padding: 10px;
            border: 1px solid red;
            margin-top: 20px;
        }
        .fa-exclamation-circle {
            color: red !important;
            font-size: 20px !important;
        }
        .fa-check-circle {
            color: green !important;
            font-size: 20px !important;
        }
    </style>
<?php $this->end(); ?>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view mt-20">
            <div class="panel-heading icantSelectIt">
                    <div class="pull-left">
                            <h6 class="panel-title txt-dark">Demandes annulation réservation</h6>
                    </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <div>
                            <table style="width:100% !important;" id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                            <th>ID Réservation</th>
                                            <th>Début Réservation</th>
                                            <th>Fin Réservation</th>
                                            <th>ID Annonce</th>
                                            <th>Locataire</th>
                                            <th>E-mail Locataire</th>
                                            <th>Date demande</th>
                                            <th>Annulé par</th>
                                            <th>Montant</th>
                                            <th>Etat</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                            <th>ID Réservation</th>
                                            <th>Début Réservation</th>
                                            <th>Fin Réservation</th>
                                            <th>ID Annonce</th>
                                            <th>Locataire</th>
                                            <th>E-mail Locataire</th>
                                            <th>Date demande</th>
                                            <th>Annulé par</th>
                                            <th>Montant</th>
                                            <th>Etat</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                </tfoot>
                                <tbody id="tbody_table">
                                    <?php foreach ($listeAnnulReserv as $value) { ?>
                                        <tr>
                                            <td><?php echo $value['reservation']['id']; ?></td>
                                            <td><?php echo $value['reservation']['dbt_at']; ?></td>
                                            <td><?php echo $value['reservation']['fin_at']; ?></td>
                                            <td><?php echo $value['reservation']['annonce_id']; ?></td>
                                            <td><?php echo $value['reservation']['utilisateur']['prenom']." ".$value['reservation']['utilisateur']['nom_famille']; ?></td>
                                            <td><?php echo $value['reservation']['utilisateur']['email']; ?></td>
                                            <td><?php echo $value->created; ?></td>
                                            <td><?php echo $value->annulationpar; ?></td>
                                            <td><?php echo $value->montant_rembourser." €"; ?></td>
                                            <td><?php echo $value->statut; ?></td>
                                            <td>
                                                <?php if($value->justificatif == 1 && $value->statut == "Demande en attente"){ ?><button class="btn btn-sm btn-default btn-icon-anim btn-circle" style="margin-bottom:5px;" onclick="afficherdetailannulation(<?php echo $value->id; ?>, 'oui')"><i class="fa fa-pencil"></i></button><?php } ?>
                                                <?php if($value->justificatif == 1) { ?><button class="btn btn-sm btn-warning btn-icon-anim btn-circle" onclick="afficherdetailannulation(<?php echo $value->id; ?>, 'non')"><i class="fa fa-search"></i></button> <?php } ?>                                             
                                            </td>
                                            <td>
                                                <?php if($value->payer == 0){ ?>
                                                    <a onclick="payer(<?php echo $value->id; ?>)" class="check-circle" style="cursor:pointer" id="payer_<?php echo $value->id; ?>"><i class="fa fa-exclamation-circle"></i></a>
                                                <?php  }else{  ?>
                                                    <i class="fa fa-check-circle"></i>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php // print_r($value); ?>
                                    <?php } ?>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title">Demande annulation réservation</h5>
            </div>
            <div id="modal-body" class="modal-body">
                <!--content loaded by ajax-->
                <div class="form-wrap col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label class="control-label mb-10 col-sm-4 text-left font-16">Motif :</label>
                        <div class="col-sm-8 divmotif">                                           
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label mb-10 col-sm-4 text-left font-16">Commentaire :</label>
                        <div class="col-sm-8 divcommentaire">                                           
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label mb-10 col-sm-4 text-left font-16">Fichier Joint :</label>
                        <div class="col-sm-12 divfichierjoint">  
                        </div>
                    </div>  
                    <div class="form-group row">
                        <p class="remboursementdate">SI VOUS REFUSER LE JUSTIFICATIF LE LOCATAIRE AURA : <br> <span id="divSansJustification"></span></p>
                    </div>  
                    <input type="hidden" id="inputMailSansJustification" name="inputMailSansJustification" val=""></input>
                    <input type="hidden" id="inputMontantProp" name="inputMontantProp" val=""></input>
                    <input type="hidden" id="inputSansJustification" name="inputSansJustification" />
                    <input type="hidden" id="idannulation" name="idannulation" />
                </div>
            </div>
            <div class="modal-footer">
                <button id="refuserannulation" type="button" class="btn btn-danger">Refuser</button>
                <button id="validerannulation" type="button" class="btn btn-success">Accepter</button>
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
<!-- Select2 JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
 var table=null;
var oldProp=null;
var annonceForEdit=null;
var propEdited=false;
   
function afficherdetailannulation(id, statut){
    $.ajax({
        type: "POST",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>manager/annonces/detaildemandeannulationreservation/",
        data: {demandeID: id},
        success:function(xml){
            var motif = {maladie:"Maladies ou blessures graves", deces:"Décès d'un des locataires, proche ou parent", officielle:"Obligations officielles", autre:"Autres"};
            $(".divmotif").html(motif[xml.detailAnnulReserv.motif_annulation]);
            $(".divcommentaire").html(xml.detailAnnulReserv.commentaire);
            $pdfview = '<object data="<?php echo $this->Url->build('/',true)?>annulation_files/'+xml.detailAnnulReserv.file+'" type="application/pdf" width="100%" height="300"> Lien Pièce jointe</object><a href="<?php echo $this->Url->build('/',true)?>annulation_files/'+xml.detailAnnulReserv.file+'" target="_blank">Télécharger</a>';
            $(".divfichierjoint").html($pdfview);
            // console.log(xml.detailAnnulReserv.motif_annulation);
            // A faire
            var fnDiff = moment(xml.detailAnnulReserv['reservation']['dbt_at'], "DD-MM-YYYY");
            var today = new Date(xml.detailAnnulReserv.created);
            var dd = today.getDate();
            var mm = today.getMonth()+1; 
            var yyyy = today.getFullYear();
            if(dd < 10){
            dd='0'+dd;
            } 
            if(mm < 10) 
            {
            mm='0'+mm;
            } 
            today = dd+'-'+mm+'-'+yyyy;
            var dbtDiff = moment(today, "DD-MM-YYYY");    
            var Diff = fnDiff.diff(dbtDiff, 'days');
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: "<?php echo $this->Url->build('/',true)?>dispos/calculertotalprixperiodebyidreservation",
                data: {id_reservation:xml.detailAnnulReserv.reservation_id},
                success:function(xmll){
                  var prixTotal = (xmll.resultatDetail['total_price']).toFixed(2);

                  var taxeDeSejour = (xmll.resultatDetail['prixtaxeapayer']).toFixed(2);

                  var fraisAlpissime = ((xmll.resultatDetail['total_price'] - xmll.resultatDetail.automaticPromo.value)/100 * 10.6);
                  var fraisStripe = ((xmll.resultatDetail['total_price'] - xmll.resultatDetail.automaticPromo.value)/100 * 1.4);
                  var fraisService = (fraisAlpissime + fraisStripe).toFixed(2);

                  prixTotal = (parseFloat(prixTotal) -  parseFloat(xmll.resultatDetail.automaticPromo.value)).toFixed(2);
                  
                  var msgSansJustif = "";
                  var msgSansJustifp1 = "";
                  var msgSansJustifp2 = "";
                  var totalPrixPayer;
                  var tauxcommission = 3;
                  if(xmll.tauxcommissionprop != 0) tauxcommission = xmll.tauxcommissionprop;
                  $.each(xmll.listeannulation, function(index, value) {
                    if((value.interval_1 == 0 && Diff <= value.interval_2) || (value.interval_2 == 100 && Diff >= value.interval_1) || (Diff >= value.interval_1 && Diff <= value.interval_2)){
                        totalPrixPayer = (((parseFloat(prixTotal)/100)*(100-value.reservation_pourc)) + (parseFloat(taxeDeSejour))).toFixed(2);
                        if(value.reservation_pourc == 100) msgSansJustifp1 = "Aucun remboursement du montant de la location ";
                        else msgSansJustifp1 = "<p>Remboursement de "+(100-value.reservation_pourc)+"% du montant de la location ";
                        // if(value.service_pourc == 0) msgSansJustifp2 = "et aucun remboursement pour les frais de service.";
                        // else msgSansJustifp2 = "et de "+value.service_pourc+"% des frais de service.</p>";
                        msgSansJustifp2 = " Remboursement à 100% de la taxe de séjour. Les frais de service ne sont pas remboursés.";
                        msgSansJustif = msgSansJustifp1+msgSansJustifp2+"<p>Remboursement de : "+totalPrixPayer+" €</p>";
                        montantProp = ((parseFloat(prixTotal)/100)*(value.reservation_pourc)).toFixed(2) - ((parseFloat(prixTotal)/100)*tauxcommission).toFixed(2);
                        $("#inputMontantProp").val(montantProp);
                    }
                  });
                    if(msgSansJustif == ""){
                        if(Diff > 30){
                            totalPrixPayer = (parseFloat(prixTotal) + parseFloat(taxeDeSejour)).toFixed(2);
                            msgSansJustif = "<p>Aucun remboursement pour les frais de service.</p><p>Remboursement de : "+totalPrixPayer+" €</p>";
                            $("#inputMailSansJustification").val("annulationreservationlocMois");
                            montantProp = 0;
                            $("#inputMontantProp").val(montantProp);
                        }else if(Diff >= 7 && Diff <= 30){
                            totalPrixPayer = ((parseFloat(prixTotal)/2) + parseFloat(taxeDeSejour)).toFixed(2);
                            msgSansJustif = "<p>Remboursement de 50% du montant de la location.</p><p>Remboursement de : "+totalPrixPayer+" €</p>";
                            $("#inputMailSansJustification").val("annulationreservationlocSemaineMois");
                            montantProp = ((parseFloat(prixTotal)/2) - ((parseFloat(prixTotal)/100)*tauxcommission)).toFixed(2);
                            $("#inputMontantProp").val(montantProp);
                        }else if(Diff < 7){
                            totalPrixPayer = taxeDeSejour;
                            msgSansJustif = "<p>Aucun remboursement du montant de la location et des frais de service.</p><p>Remboursement Total de la taxe de séjour : "+totalPrixPayer+" €</p>";
                            $("#inputMailSansJustification").val("annulationreservationlocSemaine");
                            montantProp = (parseFloat(prixTotal) - ((parseFloat(prixTotal)/100)*tauxcommission)).toFixed(2);
                            $("#inputMontantProp").val(montantProp);
                        }
                    }
                  
                  $("#divSansJustification").html(msgSansJustif);
                  $("#inputSansJustification").val(totalPrixPayer);
                }
              });
              if(statut == 'non') {
                  $("#refuserannulation").css("display", "none");
                  $("#validerannulation").css("display", "none");
                  $(".remboursementdate").css("display", "none");
              }else{
                  $("#refuserannulation").css("display", "inline-block");
                  $("#validerannulation").css("display", "inline-block"); 
                  $(".remboursementdate").css("display", "block");
              }
              $("#idannulation").val(id); 
            $("#responsive-modal").modal('show');
        }
    });
    
}

function payer(id)
{

    swal({   
        title: "Paiement annulation réservation",   
        text: "Vous venez de valider le paiement de cette annulation",   
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
            type: "POST",
            dataType : 'json',
            async: false,
            url: "<?php echo $this->Url->build('/',true)?>manager/annonces/payerannulationreservation/",
            data: {annulationID: id},
            success:function(xml){
                $('body').loadingModal('destroy');
                swal("", "Vous venez de valider le paiement de cette annulation", "success");
                location.reload();
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
            // table.ajax.reload();
            
        }); 

    });

   
}

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-eu-pre": function ( date ) {
        date = date.replace(" ", "");

        if ( ! date ) {
            return 0;
        }

        var year;
        var eu_date = date.split(/[\.\-\/]/);

        /*year (optional)*/
        if ( eu_date[2] ) {
            year = eu_date[2];
        }
        else {
            year = 0;
        }

        /*month*/
        var month = eu_date[1];
        if ( month.length == 1 ) {
            month = 0+month;
        }

        /*day*/
        var day = eu_date[0];
        if ( day.length == 1 ) {
            day = 0+day;
        }

        return (year + month + day) * 1;
    },

    "date-eu-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "date-eu-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );


jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-euro-pre": function ( a ) {
        var x;
 
        if ( a.trim() !== '' ) {
            var frDatea = a.trim().split(' ');
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

        $("#refuserannulation").click(function(){
            $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>manager/annonces/refusdemandeannulationreservation/",
                data: {prixremboursement: $("#inputSansJustification").val(), idDemande: $("#idannulation").val()},
                success:function(xml){
                    $("#responsive-modal").modal('hide');
                    window.location.reload();
                }
            });
        });

        $("#validerannulation").click(function(){
            $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>manager/annonces/acceptationdemandeannulationreservation/",
                data: {idDemande: $("#idannulation").val()},
                success:function(xml){
                    $("#responsive-modal").modal('hide');
                    window.location.reload();
                }
            });
        });
    
            var table = $('#datable_1').DataTable({
            responsive: true,
            'columns': [
            { 'data': 0 },
            { 'data': 1 ,'type': 'date-eu'},
            { 'data': 2 ,'type': 'date-eu'},
            { 'data': 3 },
            { 'data': 4 },
            { 'data': 5 },
            { 'data': 6 ,'type': 'date-euro'},
            { 'data': 7 },
            { 'data': 8 },
            { 'data': 9 },
            { 'data': 10 },
            { 'data': 11 },
        ],
        // order: [1, 'asc'],   
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
<!-- select2 CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>