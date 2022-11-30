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
                        <h6 class="panel-title txt-dark">Statistiques Populations</h6>
                </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
		<div class="panel-body pb-0">
                    <!--- PROPRIETAIRES --->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Propriétaires</h6>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="col-sm-6">
                                            <button onclick="exportImage('proprietaire1')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <canvas class="resize" id="proprietaire1" height="250"></canvas>
                                        </div>
                                        <div class="col-sm-6">
                                            <button onclick="exportImage('proprietaire2')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <canvas class="resize" id="proprietaire2" height="250"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- END PROPRIETAIRES --->
                    <!--- PROPRIETAIRES --->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Locataires</h6>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="col-sm-6">
                                            <button onclick="exportImage('locataire1')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <canvas class="resize" id="locataire1" height="250"></canvas>
                                        </div>
                                        <div class="col-sm-6">
                                            <button onclick="exportImage('locataire2')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <canvas class="resize" id="locataire2" height="250"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- END PROPRIETAIRES --->
                    <!--- Réservations --->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Inscription</h6>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body align-self-center row-eq-height">
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
                                                            <?php $annee=2011;  while ($annee <= $year2){
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
                                            <button onclick="exportImage('inscription1')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <br>
                                            <canvas class="resize" id="inscription1" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- END Réservations --->
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
/***** Proprietaires  *****/
     var ctxpopulation = document.getElementById('proprietaire1').getContext('2d');
    var chartpopulation = new Chart(ctxpopulation, {
      type: 'pie',
      data:{
        datasets: [{
            data: [<?php echo $pourHomme ?>, <?php echo $pourFemme ?>],
            backgroundColor: [
              '#2278dd',
              '#f54500',
            ]
        }],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
          'Homme',
          'Femme'
        ]
      },
      options:{
      title: {
            display: true,
            text: "Propriétaires par sexe",
            fontSize: 18,
            fontColor: '#000000',
        },
        plugins: {
            datalabels: {
            formatter: function(value, context) {
              return value + '%';
            },
            align: 'end',
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


    var ctxannonce = document.getElementById('proprietaire2').getContext('2d');
    var chartannonce = new Chart(ctxannonce, {
      type: 'bar',
      data:{
        datasets: [{
            label: 'Tranche d\'âge',
            data: [<?php echo $utilinf30 ?>,  <?php echo $utilinf40 ?>,<?php echo $utilinf50 ?>, <?php echo $utilinf60 ?>, <?php echo $utilSup60 ?> ],
            backgroundColor: ['#2278dd', '#2278dd', '#2278dd', '#2278dd', '#2278dd' ]
        }],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: ['< 30ans', '< 40ans', '< 50ans', '< 60ans', '> 60ans']
      },
      options:{
      title: {
            display: true,
            text: "Propriétaires par âge",
            fontSize: 18,
            fontColor: '#000000',
        },
        scales: {
          yAxes: [{
           ticks: {
               beginAtZero: true
           }
         }]
       },
        plugins: {
          datalabels: {
            anchor: 'end',
  					align: 'start',
            color: 'white',
            font: {
              size: '15'
            },
            formatter: function(value, context) {
              return value + '%';
            },
          }
        },
        chartArea: {
          backgroundColor: '#FFFFFF'
        }
      }

    });
    /***** END Proprietaires  *****/
    
    /***** Locataires  *****/
        var ctxpopulation2 = document.getElementById('locataire1').getContext('2d');
    var chartpopulation2 = new Chart(ctxpopulation2, {
      type: 'pie',
      data:{
        datasets: [{
          data: [<?php echo $pourHommeLoc ?>, <?php echo $pourFemmeLoc ?>],
            backgroundColor: [
              '#2278dd',
              '#f54500',
            ]
        }],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
          'Homme',
          'Femme'
        ]
      },
      options:{
      title: {
            display: true,
            text: "Locataires par sexe",
            fontSize: 18,
            fontColor: '#000000',
        },
        plugins: {
					datalabels: {
            formatter: function(value, context) {
              return value + '%';
            },
            align: 'end',
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


    var ctxannonce2 = document.getElementById('locataire2').getContext('2d');
    var chartannonce2 = new Chart(ctxannonce2, {
      type: 'bar',
      data:{
        datasets: [{
          label: 'Tranche d\'âge',
          data: [<?php echo $utilinf30Loc ?>,  <?php echo $utilinf40Loc ?>,<?php echo $utilinf50Loc ?>, <?php echo $utilinf60Loc ?>, <?php echo $utilSup60Loc ?> ],
          backgroundColor: ['#2278dd', '#2278dd', '#2278dd', '#2278dd', '#2278dd' ]
        }],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: ['< 30ans', '< 40ans', '< 50ans', '< 60ans', '> 60ans']
      },
      options:{
            title: {
            display: true,
            text: "Locataires par âge",
            fontSize: 18,
            fontColor: '#000000',
        },
        scales: {
          yAxes: [{
           ticks: {
               beginAtZero: true
           }
         }]
       },
        plugins: {
          datalabels: {
            formatter: function(value, context) {
              return value + '%';
            },
            anchor: 'end',
  					align: 'start',
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
    /***** END Locataires  *****/
    
    
    /***** END Inscription  *****/
    <?php $annee=2011;   while ($annee <= $year2){ $data[] = $nbrInscrAn[$annee]; $label[] = ($annee-1)." - ".$annee; $annee++; $color[] = '#ff530d';}; ?>
    var dataTab = <?php echo json_encode($data) ?>;
    var colorTab = <?php echo json_encode($color) ?>;
    var labelTab = <?php echo json_encode($label) ?>;
    <?php $annee=2011;   while ($annee <= $year2){ $dataLoc[] = $nbrInscrAnLoc[$annee]; $annee++; $colorLoc[] = '#46a3fe';}; ?>
    var dataTabLoc = <?php echo json_encode($dataLoc) ?>;
    var colorTabLoc = <?php echo json_encode($colorLoc) ?>;

    var ctxannonceinsc = document.getElementById('inscription1').getContext('2d');
    var chartannonceinsc = new Chart(ctxannonceinsc, {
      type: 'bar',
      data:{
        datasets: [
          {
           label: ["Propriétaire"],
           data: dataTab,
           backgroundColor: '#2278dd'
         },
         {
           label: ["Locataire"],
           data: dataTabLoc,
           backgroundColor: '#f54500'
         }
      ],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: labelTab
      },
      options:{
      title: {
            display: true,
            text: "Inscription par années",
            fontSize: 18,
            fontColor: '#000000',
        },
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
         label: ["Propriétaire"],
         data: dataTab,
         backgroundColor: '#2278dd'
       },
       {
         label: ["Locataire"],
         data: dataTabLoc,
         backgroundColor: '#f54500'
       }
    ],
      // These labels appear in the legend and in the tooltips when hovering different arcs
      labels: labelTab
    };

    $("#affichageannee").on("click", function() {
      title =  {
         display: false,
       };
    chartannonceinsc.title = {
            display: true,
            text: "Inscription par années",
            fontSize: 18,
            fontColor: '#000000',
        };
      chartannonceinsc.data = dataAnnee;
      chartannonceinsc.options.title = title;
      chartannonceinsc.update();
    });

    var dataTabMois = [];
    var dataTabLocMois = [];
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
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datamoisstatis/"+id,
        success:function(xml){
          var an = 0;
          dataTabMois = [];
          dataTabLocMois = [];
          colorTabMois = [];
          colorTabLocMois = [];
          while (an <= 12) {
            dataTabMois.push(xml.nbrInscrAnMois[an]);
            dataTabLocMois.push(xml.nbrInscrAnLocMois[an]);
            colorTabMois.push('#ff530d');
            colorTabLocMois.push('#46a3fe');
            an++;
          }

          dataMois = {
            datasets: [
              {
               label: ["Propriétaire"],
               data: dataTabMois,
               backgroundColor: '#2278dd'
             },
             {
               label: ["Locataire"],
               data: dataTabLocMois,
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
    /***** END Inscription  *****/
        
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