<?php $this->start('cssTop'); ?>
    <style>
        @media screen and (min-width: 768px) and (max-width: 1163px) {
            .form-inline .form-control { width: 15% !important; }
            .costum_span{ font-size: 80% !important;}
            .form-inline .btn {padding: 8px 25px;}
        }
        @media screen and (max-width: 767px) {
            .form-inline .btn {margin-top: 1%; padding: 8px 25px;}
        }
        
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="ti-stats-up"></i> Informations détaillées</span>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/statistique">Taux De Remplissage</a></li>
      <li class="active"><a href="#">Rapport Statistiques</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left mt-10">
                        <h6 class="panel-title txt-dark">Rapport Statistiques</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div>
                        <blockquote style="text-align:center;">
                            <form class="form-inline">
                                        <span>Station :</span>
                                        <select class="form-control date" type="text" id="id_station">
                                            <option value="0">Choisir une station</option>
                                            <?php foreach($stations as $v):?>
                                            <option value="<?php echo $v->id?>"><?php echo $v->name?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <span>Date debut :</span>
                                        <input type="text" value="01-01-2010" id="from_date_arr" class="form-control datePicker">
                                    <span>Date fin :</span>
                                    <input type="text" value="<?= date('d-m-Y')  ?>" id="to_date_arr" class="form-control datePicker">
                                    <button type="button" id="btn_suivi" href="#" class="btn btn-primary">Valider</button>
                            </form>
                        </blockquote>
                                </div>
                    </div>
                    <div class="row text-center">
                        <button id="exporter_excel_statistique" class="btn btn-success btn-anim"><i class="fa fa-table"></i><span class="btn-text">Exporter Excel</span></button>
                        <br><br>
                    </div>
                    <div class="row text-center">
                        <div class="col-sm-0 col-lg-2 col-md-2"></div>
                        <div class="col-sm-12 col-lg-8 col-md-8">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped info_general" >
                            <thead>
                              <tr>
                                  <th colspan="2" class="text-center"><span style="font-size:16px">Information Générale</span></th>
                              </tr>
                            </thead>
                            <tbody>
                               <tr>
                                 <td><span style="font-size:14px"><strong>Total Annonces Brouillons du site : </strong></span></td>
                                 <td width="40%"><span style="color:green"><?php echo $annbrouillon->nbr ?></span></td>
                               </tr>
                               <tr>
                                 <td><span style="font-size:14px"><strong>Total Annonces Validées du site : </strong></span></td>
                                 <td><span style="color:green"><?php echo $annvalide->nbr ?></span></td>
                               </tr>
                            </tbody>
                        </table>
                        </div>
                        <div class="col-sm-0 col-lg-2 col-md-2"></div>
                    </div>
                    <div class="row text-center">
                        <div class="col-sm-12">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table id="myTablescroll" data-toggle="#myTablescroll" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped info_general">
                                        <thead>
                                          <tr>
                                              <th colspan="5" class="text-center"><span style="font-size:16px">Information Détaillée</span></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                           <tr>
                                             <td><span id="stationname" style="font-size:14px"></span></td>
                                             <td>Total Annonces : <span id="annstation" style="color:green"></span></td>
                                             <td>Total Annonces de Surface 0 à 30 m² : <span id="nbrsurf1" style="color:green"></span></td>
                                             <td>Total Annonces de Surface 31 à 90 m² : <span id="nbrsurf2" style="color:green"></span></td>
                                             <td>Total Annonces de Surface supérieur à 91 m² : <span id="nbrsurf3" style="color:green"></span></td>
                                           </tr>
                                           <tr>
                                             <td><span id="stationperiode" style="font-size:14px"></span></td>
                                             <td>Total Réservations : <span id="nbrtotreservation" style="color:green"></span></td>
                                             <td>Total Annonces Réservées : <span id="nbrAnnoncesRes" style="color:green"></span></td>
                                             <td>Total Annonces Créées : <span id="nbrAnnoncescree" style="color:green"></span></td>
                                             <td>Total Personnes : <span id="totalpersonne" style="color:green"></span></td>
                                           </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-wrap">
                        <div>
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                            <th width="12%"></th>
                                            <th width="12%">NB Réservations</th>
                                            <th>NB An Surface (0 à 30 m²)</th>
                                            <th>NB An Surface (31 à 90 m²)</th>
                                            <th>NB An Surface (supérieur à 91 m²)</th>
                                            <th width="10%">NB Adultes</th>
                                            <th width="10%">NB Enfants</th>
                                            <th width="10%">NB Personnes</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                            <th width="12%"></th>
                                            <th width="12%">NB Réservations</th>
                                            <th>NB An Surface (0 à 30 m²)</th>
                                            <th>NB An Surface (31 à 90 m²)</th>
                                            <th>NB An Surface (supérieur à 91 m²)</th>
                                            <th width="10%">NB Adultes</th>
                                            <th width="10%">NB Enfants</th>
                                            <th width="10%">NB Personnes</th>
                                        </tr>
                                </tfoot>
                                <tbody id="tbody_table">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!--//  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Data table JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap-table JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-table/dist/bootstrap-table.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
var table=null;
    function showLoader(){
        $('body').loadingModal({
                    position: 'auto',
                    text: '',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'doubleBounce'
                });
    }
    $('.datePicker').datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });

    $("#from_date_arr").on('dp.change', function(e){
    $('#to_date_arr').data("DateTimePicker").destroy();

        $('#to_date_arr').datetimepicker({
                            useCurrent: false,
                            format: 'DD-MM-YYYY',
                            minDate: e.date.format("YYYY/MM/DD"),
                            icons: {
                            date: "fa fa-calendar",
                            up: "fa fa-arrow-up",
                            down: "fa fa-arrow-down"
                        },
                        });
        });

    $(document).ready(function() {
                $('#btn_suivi').click(function() {
                    infodetailles();
                    $("#tbody_table").empty();
                    $("#tbody_table").html("<tr><td style=\"text-align: center;\" colspan=\"11\">Traitement en cours...</td></tr>");
                    table.ajax.reload(null, true);
                    table.columns.adjust().draw();
                });
        
              $("#exporter_excel_statistique").on('click',function() {
                $('body').loadingModal({
                    position: 'auto',
                    text: '',
                    color: '#fff',
                    opacity: '0.7',
                    backgroundColor: 'rgb(0,0,0)',
                    animation: 'doubleBounce'
                });
                if($("#from_date_arr").val()=="") $("#from_date_arr").val("01-01-2010");
                if($('#to_date_arr').val()=="") $('#to_date_arr').val("<?= date('d-m-Y') ?>");
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/generateexcelrapportstat/",
                    data:{vDatedebut:$("#from_date_arr").val(),vDatefin:$('#to_date_arr').val(),vStation:$('#id_station').val()},
                    success:function(xml){
                      $('body').loadingModal('destroy');
                      $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Excel Exporté',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'success',
                            hideAfter: 6000 
                        });
                      window.open('<?php echo $this->Url->build('/',true)?>gestionnaire/'+xml, '_blank');
                      },error: function(){
                        $('body').loadingModal('destroy');
                        $.toast().reset('all');
                                $("body").removeAttr('class');
                                $.toast({
                                    heading: 'Erreur',
                                    text: 'erreur d\'exportation',
                                    position: 'bottom-right',
                                    loaderBg:'#fec107',
                                    icon: 'error',
                                    hideAfter: 4000
                                });
                    }
                    });

              });
            infodetailles();

            table = $('#datable_1').DataTable({
                "ajax": {
                      "url": "<?php  echo $this->Url->build('/',true) ?>manager/gestionnaires/arrayrapportstat",
                      "data": function ( d ) {
                        return $.extend( {}, d, {
                          "from": $('#from_date_arr').val(),
                          "to": $('#to_date_arr').val(),
                          "station": $('#id_station').val()
                        } );
                      }
                    },
                "pageLength": 25,
                responsive: true,
                "order": [[ 0, "desc" ]],
                "columnDefs": [
                    { "width": '30%', "targets": 0},
                    { "type": 'date-eu', "targets": 0 }
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

function infodetailles(){
  if($("#from_date_arr").val()=="") $("#from_date_arr").val("01-01-2010");
  if($('#to_date_arr').val()=="") $('#to_date_arr').val("<?= date('d-m-Y') ?>");
  $.ajax({
    type: "GET",
    dataType : 'json',
    url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/arrayinfodetailles",
    data: {from:$('#from_date_arr').val(), to:$('#to_date_arr').val(), station:$('#id_station').val()},
    success:function(xml){
      $("#annstation").html(xml.annstation['nbr']);
      $("#nbrsurf1").html(xml.nbrsurf1['nbr']);
      $("#nbrsurf2").html(xml.nbrsurf2['nbr']);
      $("#nbrsurf3").html(xml.nbrsurf3['nbr']);
      $("#stationname").html("<strong>"+xml.stationname+"</strong>");
      $("#stationperiode").html("<strong>"+xml.stationperiode+"</strong>");
      $("#nbrtotreservation").html(xml.nbrtotreservation['nbr']);
      $("#nbrAnnoncesRes").html(xml.nbrAnnoncesRes);
      $("#nbrAnnoncescree").html(xml.nbrAnnoncescree['nbr']);
      $("#totalpersonne").html(xml.totalpersonne);

    }
  });
}
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>

<!-- Bootstrap table CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-table/dist/bootstrap-table.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>