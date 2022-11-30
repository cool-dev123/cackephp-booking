<?php $this->start('cssTop'); ?>
    <style>
        .panel_content div {
            margin-top: 2%;
            margin-bottom: 1%;
        }
        .input-group-addon:first-child {
            background-color: #F7F7F9;
            border-color: #F7F7F9;
        }
    </style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h5 class="txt-dark">Locataires</h5>
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
                            <form id="form_searsh" class="form-inline">
                                <div class="input-group mt-5"> <span class="input-group-addon">Date début:</span>
                                    <input class="form-control date" value="<?= isset($this->request->query["date"])?$this->request->query["date"]:"" ?>" type="text" id="from_date" autocomplete="off" />
                                </div>
                                <div class="input-group mt-5"> <span class="input-group-addon">&nbsp;&nbsp;Date fin&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <input class="form-control date" value="<?= isset($this->request->query["ToDate"])?$this->request->query["ToDate"]:"" ?>" type="text" id="to_date" autocomplete="off" />
                                </div>
                                <div class="elementOF_searchCle mt-5 input-group">
                                        <div class="input-group-addon addon-92">
                                                Rechercher :
                                        </div>
                                    <input class="form-control" type="text" id="supp-search" value="<?= $this->request->query['supp'] ?>" autocomplete="off" />
                                </div>
                                &nbsp;&nbsp;
                                <div class="form-group inline mt-5">
                                    <div class="checkbox checkbox-primary mt-10">
                                        <input id="nonArrives" type="checkbox" checked="">
                                        <label for="nonArrives">
                                                Pas arrivés
                                        </label>
                                </div>
                                <div class="checkbox checkbox-primary mt-10">
                                        <input id="arrives" type="checkbox" checked="">
                                        <label for="arrives">
                                                Arrivés
                                        </label>
                                </div>
                                </div>
                                
                                &nbsp;&nbsp;
                                <button type="button" id="rechercher" href="#" class="mt-5 btn btn-primary">Rechercher</button>
                            </form>
                        </blockquote>
                    </div>
                    <div class="table-wrap">
                        <div>
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                            <th>Date d'arrivée</th>
                                            <th>Date de départ</th>
                                            <th>Résidences</th>
                                            <th>Num app</th>
                                            <th>Gestionnaire</th>
                                            <th>Locataire</th>
                                            <th>Type</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                            <th>Date d'arrivée</th>
                                            <th>Date de départ</th>
                                            <th>Résidences</th>
                                            <th>Num app</th>
                                            <th>Gestionnaire</th>
                                            <th>Locataire</th>
                                            <th>Type</th>
                                        </tr>
                                </tfoot>
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
var table=null;

     jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-uk-pre": function ( a ) {
            if(a!=null){
                var ukDatea = a.split('-');
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


    function redraw(){
        $("#tbody_table").empty();
        $("#tbody_table").html("<tr><td style=\"text-align: center;\" colspan=\"11\">Traitement en cours...</td></tr>");
        table.ajax.reload(null, true);
    }

    $( "#rechercher" ).on( "click", function() {
                    redraw();
		});

    $(document).ready(function() {
        
            $("#form_searsh input").keypress(function(e) {
                if(e.which == 13) {
                    redraw();
                }
            });
            
            $("#from_date").datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        defaultDate:new Date(),
                        widgetPositioning:{
                            horizontal: 'right',
                            vertical: 'bottom'
                        },
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
            });
            $("#to_date" ).datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        defaultDate:new Date(),
                        widgetPositioning:{
                            horizontal: 'right',
                            vertical: 'bottom'
                        },
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
            });
            $("#from_date").on('dp.change', function(e){
            $('#to_date').data("DateTimePicker").destroy();

                $('#to_date').datetimepicker({
                                    useCurrent: false,
                                    format: 'DD-MM-YYYY',
                                    defaultDate: e.date.format("YYYY/MM/DD"),
                                    minDate: e.date.format("YYYY/MM/DD"),
                                    icons: {
                                    date: "fa fa-calendar",
                                    up: "fa fa-arrow-up",
                                    down: "fa fa-arrow-down"
                                },
                });
            });

            table = $('#datable_1').DataTable({
                "ajax": {
                            "url": "<?php echo $this->Url->build('/',true)?>manager/arrivees/arrayadminnonarrive/",
                            "data": function ( d ) {
                                d.supp = $('#supp-search').val();
                                d.from = $('#from_date').val();
                                d.to = $('#to_date').val();
                                if($('#nonArrives').is(':checked'))
                                d.nonArrives = "true";
                                if($('#arrives').is(':checked'))
                                d.arrives = "true";
                            }
                          },
                responsive: true,
                "columnDefs": [
                    { "type": 'date-uk', "targets": 0 },
                    { "type": 'date-uk', "targets": 1 },
                    { responsivePriority: 1, targets: -1 },
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 2, targets: -2 },
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
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>