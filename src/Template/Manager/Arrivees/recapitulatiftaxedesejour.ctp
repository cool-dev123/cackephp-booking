<?php $this->start('cssTop'); ?>
    <style>
        .heading-bg {
            height: 100% !important;
        }
        th{text-align: center !important;}
        .dtr-data center button:first-of-type{ margin-bottom: 3px !important;  }
        td button:first-of-type{ margin-right: 10px;  }
        td{text-align: center;}
    </style>
<?php $this->end(); ?>

<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="fa fa-euro"></i> Taxe de séjour</span>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/taxe">Les règles de taxe de séjour</a></li>
      <li class="active"><a href="#">Récapitulatif</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Récapitulatif</h6>
                </div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div>
                        <blockquote style="text-align:center;">
                            <form class="form-inline">
                                <span class="costum_span">Date début :</span>
                                <input class="form-control date" type="text" id="from_date" autocomplete="off" />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="costum_span">Date fin :</span>
                                <input class="form-control date" type="text" id="to_date" autocomplete="off" />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="costum_span">Gestionnaire :</span>
                                <select class="form-control" id='gest'>
                                    <option value="-1">------</option>
                                    <?php foreach ($gestionnaire as $key => $value) {
                                        if($value->name != '') {?>
                                            <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                        <?php } ?>
                                    <?php }?>
                                </select>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="costum_span">Ville :</span>
                                <select class="form-control" id='ville'>
                                    <option value="-1">------</option>
                                    <?php foreach ($ville as $key => $value) {
                                        if($value->name != '') {?>
                                            <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                        <?php } ?>
                                    <?php }?>
                                </select>
                                <button type="button" id="rechercher" href="#" class="btn btn-primary">Rechercher</button>
                            </form>
                        </blockquote>
                    </div>
                    <div class="table-wrap">
                        <div>
                            <table id="datable_1" class="table table-hover display pb-30" >
                                <thead>
                                    <tr>
                                        <th>ID Réservation</th>
                                        <th>Date début</th>
                                        <th>Date fin</th>
                                        <th>Propriétaire</th>
                                        <th>Num appartement</th>
                                        <th>Bâtiment</th>
                                        <th>Station</th>
                                        <th>Classement appartement</th>
                                        <th>Nbr personnes</th>
                                        <th>Montant taxe</th>
                                        <th>Perçue par</th>
                                    </tr>
                                </thead>
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    var table=null;

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

    function resetForm(){
        $("#modal-content").html("");
    }
    
    function redraw(){
        $("#tbody_table").empty();
        $("#tbody_table").html("<tr><td style=\"text-align: center;\" colspan=\"11\">Traitement en cours...</td></tr>");
        table.ajax.reload(null, true);
    }

    $('#rechercher').on('click',function() {
        table.clear();
        redraw();
    });

    $(document).ready(function() {  
        $('.date').datetimepicker({
            useCurrent: false,
            format: 'DD-MM-YYYY',
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
                minDate: e.date.format("YYYY/MM/DD"),
                viewDate: e.date.format("YYYY/MM/DD"),
                icons: {
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
            });
        });
        
        table = $('#datable_1').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title : 'Récapitulatif taxe de séjour'
                }, 
            ],
            "ajax": "<?php echo $this->Url->build('/',true)?>manager/arrivees/listrecapitulatiftaxe/",
            "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "from", "value": $('#from_date').val() });
              aoData.push( { "name": "to", "value": $('#to_date').val() });
              aoData.push( { "name": "gestionnaire", "value": $('#gest').val() });              
              aoData.push( { "name": "ville", "value": $('#ville').val() });              
            },
            responsive: true,
            order: [[ 1, 'desc' ]],
            "columnDefs": [
                { "type": 'date-eu', "targets": 1 },
                { "type": 'date-eu', "targets": 2 },
            ],
            "language": language_data_table
        });
              
    } );
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/buttons.flash.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jszip/dist/jszip.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>