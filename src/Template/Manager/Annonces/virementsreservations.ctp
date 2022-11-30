<?php $this->start('cssTop'); ?>
    <style>
        .heading-bg {
            height: 100% !important;
        }
        th{text-align: center !important;}
        .dtr-data center button:first-of-type{ margin-bottom: 3px !important;  }
        td center button:first-of-type{ margin-right: 10px;  }
        .input-group-addon:first-child {
            background-color: #F7F7F9;
            border-color: #F7F7F9;
        }
    </style>
<?php $this->end(); ?>
<div class="row heading-bg icantSelectIt">
    <div class="col-lg-9 col-sm-9">
      <h5 class="txt-dark">Virements réservations</h5>
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
                                <div class="input-group mt-5"> <span class="input-group-addon">Date d'arrivée:</span>
                                    <input class="form-control date" value="<?= isset($this->request->query["date"])?$this->request->query["date"]:"" ?>" type="text" id="from_date" autocomplete="off" />
                                </div>                                
                                &nbsp;&nbsp;
                                <div class="form-group inline mt-5">
                                    <div class="checkbox checkbox-primary mt-10">
                                        <input id="paye" type="checkbox" checked="">
                                        <label for="paye">
                                                Payé
                                        </label>
                                </div>
                                <div class="checkbox checkbox-primary mt-10">
                                        <input id="enattente" type="checkbox" checked="">
                                        <label for="enattente">
                                                En attente
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
                            <table id="example" class="table table-hover display pb-30" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th> 
                                        <th><?php echo 'ID Réservation';?></th> 
                                        <th width="20%"><?php echo 'Période';?></th>                                
                                        <th width="10%"><?php echo 'Locataire';?></th>                                
                                        <th><?php echo 'ID Annonce';?></th>                                
                                        <th width="15%"><?php echo 'Propriétaire';?></th>
                                        <th><?php echo 'Montant (€)';?></th>
                                        <th width="15%"><?php echo 'Etat';?></th> 
                                    </tr>
                                </thead>
                                <tbody id="tbody_table">
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-50">
                        <div class="col-sm-10">
                            <button id="send" type="button" class="btn btn-success ml-20">Valider virement</button>
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
 
function redraw(){
    $("#tbody_table").empty();
    $("#tbody_table").html("<tr><td style=\"text-align: center;\" colspan=\"11\">Traitement en cours...</td></tr>");
    table.ajax.reload(null, true);
}

$( "#rechercher" ).on( "click", function() {
    redraw();
});

$(document).ready(function () {	
    $("#from_date").datetimepicker({
        useCurrent: false,
        format: 'DD-MM-YYYY',
        // defaultDate:new Date(),
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
    															
    table = $('#example').DataTable({
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Recherche"
        },
        'columns': [
            { 'data': 0 },
            { 'data': 1 },
            { 'data': 2 ,'type': 'date-eu'},
            { 'data': 3 },
            { 'data': 4 },
            { 'data': 5 },
            { 'data': 6 },
            { 'data': 7 }
        ],
        order: [2, 'desc'],
        "ajax": {
            "url": "<?php echo $this->Url->build('/',true)?>manager/annonces/listevirementreservation",
            "data": function ( d ) {
                d.from = $('#from_date').val();
                if($('#paye').is(':checked'))
                d.paye = "true";
                if($('#enattente').is(':checked'))
                d.enattente = "true";
            }
        },
        
    });

});

$('#send').click(function(){
    var nbrselect = $( "input[name='listeres[]']:checked" ).length;
    var listevirement = [];
    
    if(nbrselect > 0){
        $( "input[name='listeres[]']:checked" ).each(function(){
            listevirement.push($(this).val());
        });
        console.log(listevirement);
        $.ajax({
            type: "POST",
            url: "<?php  echo $this->Url->build('/',true) ?>manager/annonces/validervirementreservation/",
            dataType: "json",
            data:{listevirement:listevirement},
            success:function(xml){
                $('body').loadingModal('destroy');
                $.toast().reset('all');
                $("body").removeAttr('class');
                $.toast({
                        heading: 'Virement(s) validé(s)',
                        text: '',
                        position: 'bottom-right',
                        loaderBg:'#fec107',
                        icon: 'success',
                        hideAfter: 4000
                });
                redraw();
            },error: function(){
                $('body').loadingModal('destroy');
                $.toast().reset('all');
                $("body").removeAttr('class');
                $.toast({
                    heading: 'Erreur de validation',
                    text: '',
                    position: 'bottom-right',
                    loaderBg:'#fec107',
                    icon: 'error',
                    hideAfter: 4000
                });
            }
        });
    }else{
        $.toast().reset('all');
        $("body").removeAttr('class');
        $.toast({
            heading: 'Veuillez choisir le(s) virement(s) à valider',
            text: '',
            position: 'bottom-right',
            loaderBg:'#fec107',
            icon: 'error',
            hideAfter: 4000
        }); 
    }

});
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>