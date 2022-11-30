<?php $this->start('cssTop'); ?>
    <style>
        @media screen and (max-width: 767px) {
            #rechercher {margin-top: 1%;}
        }
        .panel_content div {
            margin-top: 2%;
            margin-bottom: 1%;
        }
    </style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h5 class="txt-dark">Les locataires arrivés</h5>
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
                                <input class="form-control date" type="text" id="searchf" placeholder="Rechercher:"/>
                                &nbsp;&nbsp;&nbsp;
                                <span>Date :</span>
                                <input class="form-control date" value="<?= isset($this->request->query["date"])?$this->request->query["date"]:"" ?>" type="text" id="from_date" autocomplete="off" />
                                <button type="button" id="rechercher" href="#" class="btn btn-primary">Rechercher</button>
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

    $('#rechercher').on('click',function() {
        table.clear();
        redraw();
    });
    $('#reset').on('click',function() {
        document.getElementById('from_date').value = "";
        document.getElementById('searchf').value = "";
        redraw();
    });

    $(document).ready(function() {
            
            $("#from_date" ).datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });

            table = $('#datable_1').DataTable({
            "ajax": {
                      "url": "<?php echo $this->Url->build('/',true)?>manager/arrivees/arrayadminarrive/",
                      "data": function ( d ) {
                        return $.extend( {}, d, {
                          "from": $('#from_date').val(),
                          "sRechercher": $('#searchf').val()
                        } );
                      }
                    },
            responsive: true,
            "columnDefs": [
                { "type": 'date-uk', "targets": 0 },
                { "type": 'date-uk', "targets": 1 },
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