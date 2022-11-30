<?php 
    use Cake\I18n\Time;
    $now = Time::now();
?>
<?php $this->start('cssTop'); ?>
    <style>
        @media screen and (min-width: 768px) and (max-width: 1163px) {
            .form-inline .form-control { width: 15% !important; }
            .costum_span{ font-size: 80% !important;}
            .form-inline .btn {padding: 8px 25px;}
        }
        @media screen and (max-width: 886px) {
            .form-inline .btn {margin-top: 3%; padding: 8px 25px;}
        }
        .dt-buttons{
            padding-top: 18px;
            margin-left: 25px;
        }
        
    </style>
<?php $this->end(); ?>
<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="fa fa-euro"></i> Taxe de séjour</span>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Récapitulatif</a></li>
      <li><a href="<?php echo $this->Url->build('/',true)?>manager/arrivees/paiementtaxedesejour">Gestion des paiements</a></li>
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
                            <h6 class="panel-title txt-dark">Taxe de séjour</h6>
                    </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div>
                        <blockquote style="text-align:center;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="text-muted"><code>"REMARQUE: Pour avoir une résultat précis, veuillez choisir 'Tous / Non / Oui' dans le champ "Taxe gérée par Alpissime"</code></p><br>
                                </div>
                            </div>
                            <form class="form-inline row">
                                    <span class="costum_span">Taxe gérée par Alpissime</span>
                                    <select id="taxe_geree" class="form-control" >
                                        <option value="">Tous</option>
                                        <option value="0">Non</option>
                                        <option value="1">Oui</option>
                                    </select>
                                    <span class="costum_span">date de début :</span>
                                    <input class="form-control date" type="text" id="from_date" autocomplete="off" value="01-01-2010" />
                                    <span class="costum_span">date de fin :</span>
                                    <input class="form-control date" type="text" id="to_date" autocomplete="off" value="<?= $now->i18nFormat('dd-MM-yyyy') ?>" />
                                    <button type="button" id="rechercher" href="#" class="btn btn-primary">Rechercher</button>
                            </form>
                        </blockquote>
                    </div>
                    <div class="table-wrap">
                        <div>
                            <!-- <button id="exporter_pdf_taxe" class=" btn-sm btn-rounded btn btn-success btn-anim"><i class="fa fa-file-pdf-o"></i><span class="btn-text">Exporter PDF</span></button> -->
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                        <tr>
                                            <th width="10%">Début de Période </th>
                                            <th width="10%">Fin de Période </th>
                                            <th width="15%">Propriétaire</th>
                                            <th width="15%">Résidence</th>
                                            <th width="8%">Num app</th>
                                            <th width="7%">Nbr etoiles</th>
                                            <th width="11%">Payée par Chèque (&euro;)</th>
                                            <th width="11%">Payée en Espèce (&euro;)</th>
                                            <th width="11%">Payée par carte bancaire (&euro;)</th>
                                            <th width="9%">Total Taxe (&euro;)</th>
                                        </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                            <th width="10%"></th>
                                            <th width="10%"></th>
                                            <th width="15%"></th>
                                            <th width="15%"></th>
                                            <th width="8%"></th>
                                            <th width="7%"></th>
                                            <th width="11%">Payée par Chèque (&euro;)</th>
                                            <th width="11%">Payée en Espèce (&euro;)</th>
                                            <th width="11%">Payée par carte bancaire (&euro;)</th>
                                            <th width="9%">Total Taxe (&euro;)</th>
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/buttons/dataTables.buttons.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jszip/dist/jszip.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/buttons/buttons.html5.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/datatables/buttons/buttons.print.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
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

    function exportPDF(){
        if($("#from_date").val()=="") $("#from_date").val("01-01-2010");
        if($('#to_date').val()=="") $('#to_date').val(<?= "\"".$now->i18nFormat('dd-MM-yyyy')."\"" ?>);
        $('body').loadingModal({
            position: 'auto',
            text: 'Chargement en cours',
            color: '#fff',
            opacity: '0.7',
            backgroundColor: 'rgb(0,0,0)',
            animation: 'doubleBounce'
        });
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/generatepdftaxetableau/",
            data:{vDatedebut:$("#from_date").val(),vDatefin:$('#to_date').val(),vTaxegere:$('#taxe_geree').val(),vRechercheinput:$("#tb_nonarrive_filter label input").val()},
            success:function(xml){
                redraw();
            $('body').loadingModal('destroy');
            $.toast().reset('all');
                            $("body").removeAttr('class');
                            $.toast({
                                heading: 'PDF Exporté',
                                text: '',
                                position: 'bottom-right',
                                loaderBg:'#fec107',
                                icon: 'success',
                                hideAfter: 6000
                            });
            window.open('<?php echo $this->Url->build('/',true)?>/taxesejour/'+xml, '_blank');
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
            
    $('.date').datetimepicker({
                widgetPositioning:{
                    horizontal: 'auto',
                    vertical: 'bottom'
                },
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
                        widgetPositioning:{
                            horizontal: 'auto',
                            vertical: 'bottom'
                        },
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        minDate: e.date.add(1,'days').format("YYYY/MM/DD"),
                        viewDate: e.date.add(1,'days').format("YYYY/MM/DD"),
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });
    });

            table = $('#datable_1').DataTable({
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'excel',
                    messageTop: "TAXE DE SEJOUR Du "+$('#from_date').val()+" Au "+$('#to_date').val()+" <?=$this->request->session()->read("Gestionnaire.info")['G']['name']?>"
                },
                {
                    text: 'Exporter PDF',
                    action: function ( e, dt, node, config ) {
                        exportPDF()
                    }
                }
            ],
            responsive: true,
            "sAjaxSource": "<?php echo $this->Url->build('/',true)?>manager/arrivees/arraytaxedesejour/",
            "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
                          var total = 0;
                          var totalEspece = 0;
                          var totalCheque = 0;
                          var totalCB = 0;
                          for (var i = 0; i < aaData.length; i++) {
                              total += parseFloat(aaData[i][9]) * 1;
                              if(aaData[i][7] != "") totalEspece += parseFloat(aaData[i][7]) * 1;
                              if(aaData[i][6] != "") totalCheque += parseFloat(aaData[i][6]) * 1;
                              if(aaData[i][8] != "") totalCB += parseFloat(aaData[i][8]) * 1;
                          }

                          var page = 0;
                          var pageEspece = 0;
                          var pageCheque = 0;
                          var pageCB = 0;
                          for (var i = iStart; i < iEnd; i++) {
                              page += parseFloat(aaData[aiDisplay[i]][9]) * 1;
                              if(aaData[aiDisplay[i]][7] != "") pageEspece += parseFloat(aaData[aiDisplay[i]][7]) * 1;
                              if(aaData[aiDisplay[i]][6] != "") pageCheque += parseFloat(aaData[aiDisplay[i]][6]) * 1;
                              if(aaData[aiDisplay[i]][8] != "") pageCheque += parseFloat(aaData[aiDisplay[i]][8]) * 1;
                          }
                          test =  "Total Chèque : "+parseFloat(pageCheque).toFixed(2)+"  &euro; &nbsp;&nbsp; Total Espèce : "+parseFloat(pageEspece).toFixed(2)+"  &euro; &nbsp;&nbsp; Total Carte bancaire : "+parseFloat(pageCB).toFixed(2)+"<br><br> "+"TOTAL : "+parseFloat(page).toFixed(2)+" &euro;";
                          testcheque = "Total Chèque : "+parseFloat(pageCheque).toFixed(2)+"  &euro;";
                          testespece = "Total Espèce : "+parseFloat(pageEspece).toFixed(2)+"  &euro; ";
                          testcb = "Total Carte bancaire : "+parseFloat(pageCB).toFixed(2)+"  &euro; ";
                          testtotal = "TOTAL : "+parseFloat(page).toFixed(2)+" &euro;";
                          /* Modify the footer row to match what we want */
                          var nCells = nRow.getElementsByTagName('th');
                          nCells[6].innerHTML = "<h6>Total Chèque : "+parseFloat(totalCheque).toFixed(2)+"  &euro; </h6>";
                          nCells[7].innerHTML = "<h6>Total Espèce : "+parseFloat(totalEspece).toFixed(2)+"  &euro; </h6>";
                          nCells[8].innerHTML = "<h6>Total Carte bancaire : "+parseFloat(totalCB).toFixed(2)+"  &euro; </h6>";
                          nCells[9].innerHTML = "<h6>Total : "+parseFloat(total).toFixed(2)+" &euro;</h6>";
                          $("#texecalc").html(test);
                          //$( "<p>"+page+"</p>" ).insertAfter( 'tbody' );
            },
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