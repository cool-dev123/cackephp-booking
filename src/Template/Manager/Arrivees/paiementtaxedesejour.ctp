<?php 
    use Cake\I18n\Time;
?>
<?php $this->start('cssTop'); ?>
    <style>
        @media screen and (min-width: 768px) and (max-width: 1163px) {
            .form-inline .form-control { width: 15% !important; }
            .costum_span{ font-size: 80% !important;}
            .form-inline .btn {padding: 8px 25px;}
        }
        @media screen and (max-width: 886px) {
            .form-inline .btn {margin-top: 1%; padding: 8px 25px;}
        }
        
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="fa fa-euro"></i> Taxe de séjour</span>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/taxedesejour/">Récapitulatif</a></li>
      <li class="active"><a href="#">Gestion des paiements</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/envoietaxedesejour">Envoi de la taxe</a></li>
    </ul>
  </div>
</nav>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
            <div class="panel-heading icantSelectIt">
                    <div class="pull-left">
                            <h6 class="panel-title txt-dark">Paiement Taxe de séjour</h6>
                    </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div>
                        <blockquote style="text-align:center;">
                            <form class="form-inline">
                                <span class="costum_span">Taxe payée</span>
                                <select id="taxe_geree" class="form-control" >
                                    <option value="">---</option>
                                    <option value="0">Non</option>
                                    <option value="1">Oui</option>
                                </select>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="costum_span">date de début :</span>
                                <input class="form-control date" type="text" id="from_date" autocomplete="off" />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="costum_span">date de fin :</span>
                                <input class="form-control date" type="text" id="to_date" autocomplete="off" />
                                <button type="button" id="rechercher" href="#" class="btn btn-primary">Rechercher</button>
                            </form>
                        </blockquote>
                    </div>
                    <div class="table-wrap">
                        <div>
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                            <th width="10%">Début de Période </th>
                                            <th width="10%">Fin de Période </th>
                                            <th width="15%">Propriétaire</th>
                                            <th width="15%">Résidence</th>
                                            <th width="5%">Num app</th>
                                            <th width="11%">Locataire</th>
                                            <th width="5%">Nombre Adulte</th>
                                            <th width="7%">Nombre Enfant</th>
                                            <th width="7%">Taxe séjour (&euro;)</th>
                                            <th width="7%">Taxe Payée</th>
                                            <th width="7%">Méthode paiement</th>
                                            <th></th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                            <th width="10%">Début de Période </th>
                                            <th width="10%">Fin de Période </th>
                                            <th width="15%">Propriétaire</th>
                                            <th width="15%">Résidence</th>
                                            <th width="5%">Num app</th>
                                            <th width="11%">Locataire</th>
                                            <th width="5%">Nombre Adulte</th>
                                            <th width="7%">Nombre Enfant</th>
                                            <th width="7%">Taxe séjour (&euro;)</th>
                                            <th width="7%">Taxe Payée</th>
                                            <th width="7%">Méthode paiement</th>
                                            <th></th>
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

<!-- /.modal -->
<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h5 class="modal-title">Gestion Taxe de séjour</h5>
                        </div>
                    <div class="modal-body" id="modal_body">
                                
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button id="modifiergesttaxearrivee" type="button" class="btn btn-danger">Modifier</button>
                        </div>
                </div>
        </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>
    
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    var form =null;
    $(document).on('click', ".edittax", function () {
        $('body').loadingModal({
            position: 'auto',
            text: '',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
        var href = $(this).attr("data-href");
                    $.ajax({
                        type: "GET",
                        url: href,

                        success:function(xml){
                            $('#modal_body').html(xml);
                            $('body').loadingModal('destroy');
                          },
                        error:function(){
                            $('#responsive-modal').modal('hide');
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

var table=null;

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
    
    $("#modifiergesttaxearrivee").on('click',function() {
        
        if($("#frm_gestiontaxesejour").valid()){
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
            url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/modifiergesttaxearrivee/",
            data:{vTaxepaye: $('#taxe_paye').val(), vMethodepaye: $('#methode_paye').val(), vReservid: $('#reservid').val()},
            success:function(xml){
                redraw();
                $('#responsive-modal').modal('hide');
                $('body').loadingModal('destroy');
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
        }
    });

            table = $('#datable_1').DataTable({
            responsive: true,
            "sAjaxSource": "<?php echo $this->Url->build('/',true)?>manager/arrivees/arraypaiementtaxedesejour/",
            "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "from", "value": $('#from_date').val() });
              aoData.push( { "name": "to", "value": $('#to_date').val() });
              aoData.push( { "name": "taxe_geree", "value": $('#taxe_geree').val() });
            },
            "fnServerData": function ( sSource, aoData, fnCallback ) {
            $.getJSON( sSource, aoData, function (json) {
                //alert(json.iTotalRecords);
                                $('.nb_non_arrvee').html(json.iTotalRecords+" locataires <?php echo $InfoGes['G']['nom']?>");
                                 fnCallback(json);
            } );
			},
            "language": language_data_table,
        "columnDefs": [
                { "type": 'date-eu', "targets": 1 },
                { "type": 'date-eu', "targets": 0 },
            ],
        "order": [[ 0, "desc" ]],
        });
              
    } );
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
    
<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>