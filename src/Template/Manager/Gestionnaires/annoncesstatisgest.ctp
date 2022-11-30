<?php $month = date("n");
    if ($month<9){
        $year = date("Y")-1;
        $year2= date("Y");
    }
    else{
        $year = date("Y");
        $year2 = date("Y")+1;
    } ?>
<?php $this->start('cssTop'); ?>
<style>
    @media screen and (max-width: 800px)  {
        .resize{
            width: 50%;
        }
        .btn-spec{
            padding: 4px 5px 4px 5px !important;
        }
    }
    @media screen and (min-width: 768px)  {
    .row-eq-height {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display:         flex;
    }
    .vcenter{
      display:flex;
      flex-direction:column;
      justify-content:center;
      }
  }
  .btn-orange{
      background-color: #f54500;
      border-color: #f54500;
  }
</style>
<?php $this->end(); ?>
<?php echo $this->element('menustatistiques'); ?>

<div class="row">
    <div class="col-sm-12">
	<div class="panel panel-default card-view pb-0">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left mt-10">
                        <h6 class="panel-title txt-dark">Statistiques Annonces</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
		<div class="panel-body pb-0 row-eq-height">
                    <div class="col-sm-3 align-self-center vcenter" style="text-align:center;">
                        <!--Form-->
                        <br><br><br>
                        <form>
                            <div class="form-group">
                                <button type="button" id="affichageannee" class="btn  btn-primary btn-spec">Affichage par années</button>
                            </div>
                            <div class="form-group">
                                    <label class="control-label mb-10 text-left" for="example-email">Choisir une année</label>
                                    <select class="form-control" name="anneechoisie" id="anneechoisie">
                                        <?php $annee=2014;  while ($annee <= $year2){
                                            ?>
                                            <option value="<?php echo $annee ?>"><?php echo ($annee-1)." - ".$annee ?></option>
                                            <?php
                                            $annee++;
                                        }; ?>
                                    </select>
                            </div>
                            <div class="form-group">
                                <button type="button" id="affichagemois" class="btn  btn-orange btn-spec">Affichage par mois</button>
                            </div>
                        </form>
                        <!--end Form-->
                    </div>
                    <div class="col-sm-9">
                        <button onclick="exportImage('contrats')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                        <br>
                        <canvas class="resize" id="contrats" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ChartJS JavaScript -->
<?php $this->Html->script("/manager-arr/js/chart.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/js/chartjs-plugin-datalabels.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/js/ammap.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/js/worldHigh.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/js/light.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/js/export.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/js/exportChart/jszip.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/js/exportChart/fabric.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/js/exportChart/pdfmake.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/js/exportChart/FileSaver.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/moment.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/fullcalendar.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/locale/fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
if($( window ).width()<=500){
    $('#typescontrats').attr( "height" , '200' );
}
if($( window ).width()>=500 && $( window ).width()<=800){
    $('#typescontrats').attr( "height" , '200' );
}
    
    /***** Contrats  *****/
    <?php $annee=2014;   while ($annee <= $year2){ $data[] = $nbrInscrAn[$annee]; $label[] = ($annee-1)." - ".$annee; $annee++; $color[] = '#3299fe';}; ?>
    var dataTab = <?php echo json_encode($data) ?>;
    var colorTab = <?php echo json_encode($color) ?>;
    var labelTab = <?php echo json_encode($label) ?>;
    
        var ctxannonceinsc = document.getElementById('contrats').getContext('2d');
    var chartannonceinsc = new Chart(ctxannonceinsc, {
      type: 'bar',
      data:{
        datasets: [
          {
           label: ["Contrat"],
           data: dataTab,
           backgroundColor: colorTab
         }
      ],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: labelTab
      },
      options:{
        scales: {
          yAxes: [{
           ticks: {
               beginAtZero: true
           }
         }]
       },
        plugins: {
          datalabels: {
            color: 'white',
            font: {
              size: '15'
            },
          }
        },
        chartArea: {
          backgroundColor: '#FFFFFF'
        }
      }

    });

    var dataAnnee = {
      datasets: [
        {
         label: ["Contrat"],
         data: dataTab,
         backgroundColor: colorTab
       },
    ],
      // These labels appear in the legend and in the tooltips when hovering different arcs
      labels: labelTab
    };

    $("#affichageannee").on("click", function() {

            title= {
            display: true,
            text: "Contrats par années",
            fontSize: 18,
            fontColor: '#000000',
        },

      chartannonceinsc.data = dataAnnee;
      chartannonceinsc.options.title = title;
      chartannonceinsc.update();
    });

    var dataTabMois = [];
    var colorTabMois = [];
    var colorTabLocMois = [];
    var dataMois;
    $("#affichagemois").on("click", function() {
      var id = $("#anneechoisie").val();
      //console.log(id);
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datamoisstatiscontratgest/"+id,
        success:function(xml){
          var an = 0;
          dataTabMois = [];
          colorTabMois = [];
          colorTabLocMois = [];
          while (an <= 12) {
            dataTabMois.push(xml.nbrInscrAnMois[an]);
            colorTabMois.push('#f54500');
            colorTabLocMois.push('#f8b006');
            an++;
          }

          dataMois = {
            datasets: [
              {
               label: ["Contrat"],
               data: dataTabMois,
               backgroundColor: '#f54500'
             }
          ],
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: ["Sep "+(id-1), "Oct "+(id-1), "Nov "+(id-1), "Déc "+(id-1), "Jan "+id, "Fev "+id, "Mar "+id, "Avr "+id, "Mai "+id, "Jun "+id, "Jul "+id, "Aoû "+id]
          };

          title =  {
            fontSize: 18,
            fontColor: '#000000',
             display: true,
             padding: 0,
             text: 'ANNEE : ' + $("#anneechoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL'),
           };

          }
        });
        chartannonceinsc.data = dataMois;
        chartannonceinsc.options.title = title;
        chartannonceinsc.update();

    });
    /***** END contrat  *****/
        
        function printChart(){
            map.export.capture( {}, function() {
                this.toJPG({}, function(data) {
                this.download(data, this.defaults.formats.JPG.mimeType, "amCharts.JPG");
              });
            } );
         }
         /***** Function Export AND Download Image*****/
        function exportImage(id) {
            var canvas = document.querySelector('#'+id);
            var canvasImg = canvas.toDataURL("image/png", 1.0);
            downloadURI(canvasImg, id+'.jpg');
        }
        /***** END Function Export AND Download Image*****/
        /***** Download Image *****/
        function downloadURI(uri, name) {
                  var link = document.createElement("a");
                  link.download = name;
                  link.href = uri;
                  document.body.appendChild(link);
                  link.click();
                  document.body.removeChild(link);
                  delete link;
              }
        /*****END Download Image *****/
<?php $this->Html->scriptEnd(); ?>