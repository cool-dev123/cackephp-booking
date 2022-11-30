<?php $this->start('cssTop'); ?>
    <style>
        @media screen and (min-width: 768px) and (max-width: 1163px) {
            .form-inline .form-control { width: 15% !important; }
            .costum_span{ font-size: 80% !important;}
            .form-inline .btn {padding: 8px 25px;}
        }
        @media screen and (min-width: 1162px) and (max-width: 1307px) {
            .form-inline .btn {margin-top: 1%; padding: 8px 25px;}
        }
        @media screen and (max-width: 888px) {
            .form-inline .btn {margin-top: 1%; padding: 8px 25px;}
        }
        @media screen and (min-width: 1204px) and (max-width: 1307px) {
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
      <li class="active"><a href="#">Taux De Remplissage</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/rapportstatistique">Rapport Statistiques</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left mt-10">
                        <h6 class="panel-title txt-dark">Statistiques de remplissage</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div>
                        <blockquote style="text-align:center;">
                            <form class="form-inline">
                                        <span class="costum_span">Date début d'arrivée :</span>
                                        <input type="text" id="from_date_arr" class="form-control datePicker">
                                    <span class="costum_span">Date fin d'arrivée :</span>
                                    <input type="text" id="to_date_arr" class="form-control datePicker">
                                        <span class="costum_span">ID Annonce :</span>
                                        <input type="text" class="form-control" id="annonce_id"/>
                                <button type="button" id="btn_suivi" href="#" class="btn btn-primary">Valider</button>
                            </form>
                        </blockquote>
                    </div>
                    <div class="table-wrap">
                        <div>
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                            <th width="6%">ID App</th>
                                            <th width="6%">N°App</th>
                                            <th>Locataire</th>
                                            <th>Ville</th>
                                            <th>Code postal</th>
                                            <th>Portable</th>
                                            <th>Du</th>
                                            <th>Au</th>
                                            <th>NB Enfants</th>
                                            <th>NB Adultes</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                            <th>ID App</th>
                                            <th>N°App</th>
                                            <th>Locataire</th>
                                            <th>Ville</th>
                                            <th>Code postal</th>
                                            <th>Portable</th>
                                            <th width="12%">Du</th>
                                            <th width="12%">Au</th>
                                            <th width="7%">NB Enfants</th>
                                            <th width="7%">NB Adultes</th>
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
</div>
<!-- Data table JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/buttons.flash.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jszip/dist/jszip.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/pdfmake/build/pdfmake.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/pdfmake/build/vfs_fonts.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
var table=null;
    $("#btn_suivi").on('click',function() {
                redraw();
    });
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
                            viewDate: e.date.format("YYYY/MM/DD"),
                            icons: {
                            date: "fa fa-calendar",
                            up: "fa fa-arrow-up",
                            down: "fa fa-arrow-down"
                        },
                        });
        });
	
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

            table = $('#datable_1').DataTable({
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'csv',
                            title : 'Statistiques de remplissage'
                        },
                        {
                            extend: 'excel',
                            title : 'Statistiques de remplissage'
                        }, 
                        {
                    extend: "print",
                    title : 'Statistiques de remplissage',
                    customize: function(win)
                    {

                        var last = null;
                        var current = null;
                        var bod = [];

                        var css = '@page { size: landscape; }',
                            head = win.document.head || win.document.getElementsByTagName('head')[0],
                            style = win.document.createElement('style');

                        style.type = 'text/css';
                        style.media = 'print';

                        if (style.styleSheet)
                        {
                          style.styleSheet.cssText = css;
                        }
                        else
                        {
                          style.appendChild(win.document.createTextNode(css));
                        }

                        head.appendChild(style);
                 }
              },
                    ],
                    "ajax": {
                      "url": "<?php  echo $this->Url->build('/',true) ?>manager/gestionnaires/arraystat",
                      "data": function ( d ) {
                        return $.extend( {}, d, {
                          "from": $('#from_date_arr').val(),
                          "to": $('#to_date_arr').val(),
                          "id_a": $('#annonce_id').val()
                        } );
                      }
                    },
                    "footerCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
                          var totalenfant = 0;
                          for (var i = 0; i < aaData.length; i++) {
                              totalenfant += parseInt(aaData[i][8]) * 1;
                          }

                          var page = 0;
                          for (var i = iStart; i < iEnd; i++) {
                              page += parseInt(aaData[aiDisplay[i]][8]) * 1;
                          }
                          test = "Total : "+parseInt(page);
                          /* Modify the footer row to match what we want */
                          var nCells = nRow.getElementsByTagName('th');
                          nCells[8].innerHTML = "Total : "+parseInt(totalenfant);
                          //$("#texecalc").html(test);

                          var totaladlt = 0;
                          for (var i = 0; i < aaData.length; i++) {
                              totaladlt += parseInt(aaData[i][9]) * 1;
                          }

                          var page2 = 0;
                          for (var i = iStart; i < iEnd; i++) {
                              page2 += parseInt(aaData[aiDisplay[i]][9]) * 1;
                          }
                          test2 = "Total : "+parseInt(page2);
                          /* Modify the footer row to match what we want */
                          var nCells = nRow.getElementsByTagName('th');
                          nCells[9].innerHTML = "Total : "+parseInt(totaladlt);
                          $("#datable_1_info").html("Total enfants : "+parseInt(page)+"  "+" Total adultes : "+parseInt(page2));

                    },
                    "columnDefs": [
                        { "type": 'date-uk', "targets": 6 },
                        { "type": 'date-uk', "targets": 7 },
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
        "date-uk-pre": function ( a ) {
            if(a!=null){
                var ukDatea = a.split('/');
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

<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>