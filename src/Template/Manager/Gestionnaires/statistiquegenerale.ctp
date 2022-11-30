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
    @media screen and (max-width: 500px)  {
        .chart_for_mobile{
            height:  100px;
        }
    }
    @media screen and (max-width: 800px) and (min-width: 501px)  {
        .chart_for_mobile{
            height:  150px;
        }
        .chart_for_tablet{
            height: 300px;
        }
    }
    .txt-blue{
        color: #74B9FF !important;
    }
    .progress-bar-blue {
        background: #74B9FF !important;
    }
</style>
<?php $this->end(); ?>

<?php echo $this->element('menustatistiques'); ?>

<div class="row">
    <div class="col-sm-12">
	<div class="panel panel-default card-view pb-0">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left mt-10">
                        <h6 class="panel-title txt-dark">Statistiques Générales</h6>
                </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
		<div class="panel-body pb-0">
                    <div class="row icantSelectIt">
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="panel panel-default card-view pa-0">
                                            <div class="panel-wrapper collapse in">
                                                    <div class="panel-body pa-0">
                                                            <div class="sm-data-box">
                                                                    <div class="container-fluid">
                                                                            <div class="row">
                                                                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                                                            <span class="txt-blue block counter"><span class="counter-anim"><?php echo $utilsTotal; ?></span></span>
                                                                                            <span class="capitalize-font txt-dark font-20 block">Utilisateurs</span>
                                                                                    </div>
                                                                                    <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                                                        <i class="icon-people data-right-rep-icon txt-blue"></i>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="row pl-20 pr-20 pb-10">
                                                                                <span class="font-18 txt-dark"><span class="counter-anim txt-blue"><?php echo $nbrLoc; ?></span> locataires | <span class="counter-anim txt-blue"><?php echo $nbrProp; ?></span> propriétaires</span>
                                                                            </div>
                                                                            <div class="progress-anim">
                                                                                    <div class="progress">
                                                                                            <div class="progress-bar progress-bar-blue
                                                                                            wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemax="100"></div>
                                                                                    </div>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                        
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="panel panel-default card-view pa-0">
                                            <div class="panel-wrapper collapse in">
                                                    <div class="panel-body pa-0">
                                                            <div class="sm-data-box">
                                                                    <div class="container-fluid">
                                                                            <div class="row">
                                                                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                                                            <span class="txt-success block counter"><span class="counter-anim"><?php echo $nbrAnn; ?></span></span>
                                                                                            <span class="capitalize-font txt-dark font-20 block">Annonces</span>
                                                                                    </div>
                                                                                    <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                                                        <i class="icon-home data-right-rep-icon txt-success"></i>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="row pl-20 pr-20 pb-10">
                                                                                <span class="font-18 txt-dark">Validées sur le site depuis 2010</span>
                                                                            </div>
                                                                            <div class="progress-anim">
                                                                                    <div class="progress">
                                                                                            <div class="progress-bar progress-bar-success
                                                                                            wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemax="100"></div>
                                                                                    </div>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="panel panel-default card-view pa-0">
                                            <div class="panel-wrapper collapse in">
                                                    <div class="panel-body pa-0">
                                                            <div class="sm-data-box">
                                                                    <div class="container-fluid">
                                                                            <div class="row">
                                                                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                                                            <span class="txt-gold block counter"><span class="counter-anim"><?php echo $nbrRes; ?></span></span>
                                                                                            <span class="capitalize-font txt-dark font-20 block">Réservations</span>
                                                                                    </div>
                                                                                    <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                                                        <i class="icon-calender data-right-rep-icon txt-gold"></i>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="row pl-20 pr-20 pb-10">
                                                                                <span class="font-18 txt-dark">Depuis 2010</span>
                                                                            </div>
                                                                            <div class="progress-anim">
                                                                                    <div class="progress">
                                                                                            <div class="progress-bar progress-bar-warning
                                                                                            wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemax="100"></div>
                                                                                    </div>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
			<!-- item -->
                    </div>
                    <!--- POPULATIONS --->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Population</h6>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="col-sm-6">
                                            <a href="<?= $this->Url->build('/',true)?>manager/utilisateurs/stat_pays" class="btn btn-primary pull-left"><span class="btn-text">Voir Détails</span></a>
                                            <button onclick="exportImage('population1')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <canvas class="chart_for_mobile" id="population1" height="250"></canvas>
                                        </div>
                                        <div class="col-sm-6">
                                            <button style="z-index: 1;" onclick="printChart();" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <div id="Mapdiv" style="min-height: 400px; max-height: 400px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- END POPULATIONS --->
                    <!--- ANNONCES --->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Annonces</h6>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="col-sm-6">
                                            <button onclick="exportImage('annonce1')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <canvas class="chart_for_mobile" id="annonce1" height="250"></canvas>
                                        </div>
                                        <div class="col-sm-6">
                                            <button onclick="exportImage('annonce2')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <canvas class="chart_for_mobile" id="annonce2" height="250"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- END ANNONCES --->
                    <!--- Réservations --->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Réservations</h6>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="row pa-0 ma-0">
                                            <div class="col-lg-6 col-md-12">
                                                <button onclick="exportImage('reservation1')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                                <canvas class="chart_for_mobile chart_for_tablet" id="reservation1" height="250"></canvas>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <button onclick="exportImage('reservation2')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                                <canvas class="chart_for_mobile chart_for_tablet" id="reservation2" height="250"></canvas>
                                            </div>
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

<!-- animer conteur -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery.counterup/jquery.counterup.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>

    var ctxpopulation = document.getElementById('population1').getContext('2d');
    var chartpopulation = new Chart(ctxpopulation, {
      type: 'pie',
      data:{
        datasets: [{
            data: [<?php echo $pourcETR; ?>, <?php echo $pourcFR; ?>],
            backgroundColor: [
              '#2278dd',
              '#f54500',
            ]
        }],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
          'Etranger',
            'Français'
        ]
      },
      options:{
        title: {
            display: true,
            text: "Population <?php echo $year." - ".$year2; ?>",
            fontSize: 18,
            fontColor: '#000000',
        },
        plugins: {
            datalabels: {
            formatter: function(value, context) {
              return value + '%';
            },
            //align: 'end',
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
    
    var area = <?php echo json_encode($listePays) ?>;
    var map = AmCharts.makeChart( "Mapdiv", {
    "titles": [
        {
        "text": "Liste des pays",
        "size": 18
        }
    ],
    "type": "map",
    "theme": "light",
    "dataProvider": {
      "map": "worldHigh",
      "zoomLevel": 1,
      "areas": area
    },

    "areasSettings": {
      "rollOverOutlineColor": "#FFFFFF",
      "rollOverColor": "#2278dd",
      "alpha": 0.8,
      "unlistedAreasAlpha": 0.1,
    },
    "export": {
      "enabled": true,
      "menu": [],
    }

    });
    
    var ctxannonce = document.getElementById('annonce1').getContext('2d');
    var chartannonce = new Chart(ctxannonce, {
      type: 'doughnut',
      data:{
        datasets: [{
            data: [<?php echo $annApp ?>, <?php echo $annStd ?>, <?php echo $annCha ?>, <?php echo 100-($annApp+$annStd+$annCha)?>],
            backgroundColor: [
              '#f54500',
              '#2278dd',
              '#001c38',
              '#f8b006'
            ]
        }],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
          'Appartements',
          'Studios',
          'Chalets',
          'Autres'
        ]
      },
      options:{
        title: {
            display: true,
            text: "Types de bâtiments",
            fontSize: 18,
            fontColor: '#000000',
        },
        rotation: Math.PI * 0.001,
        plugins: {
          datalabels: {
            formatter: function(value, context) {
              return value + '%';
            },
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
    
    var ctxannonce2 = document.getElementById('annonce2').getContext('2d');
    var chartannonce2 = new Chart(ctxannonce2, {
      type: 'doughnut',
      data:{
        datasets: [{
            data: [<?php echo $annCont ?>, <?php echo $annMise ?>, <?php echo 100-($annCont+$annMise) ?>],
            backgroundColor: [
              '#2278dd',
              '#f8b006',
              '#f54500',
            ]
        }],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
            'Contrats',
            'Mise en relation',
            'Sans contrats'
        ]
      },
      options:{
        title: {
            display: true,
            text: "Types de relations",
            fontSize: 18,
            fontColor: '#000000',
        },
        rotation: Math.PI * 0.5,
        plugins: {
          datalabels: {
            formatter: function(value, context) {
              return value + '%';
            },
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
    
    <?php $annee=2011;   while ($annee <= $year2){ $data[] = $nbrReAn[$annee]; $label[] = ($annee-1).'-'.$annee; $annee++; $color[] = '#46a3fe';}; ?>
    var dataTab = <?php echo json_encode($data) ?>;
    var colorTab = <?php echo json_encode($color) ?>;
    var labelTab = <?php echo json_encode($label) ?>;
    var ctxreservation = document.getElementById('reservation1').getContext('2d');
    var chartreservation = new Chart(ctxreservation, {
      type: 'bar',
      data:{
        datasets: [{
            label: 'Réservations par Année',
            data: dataTab,
            backgroundColor: '#006BE6'
        }],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: labelTab
      },
      options:{
        rotation: Math.PI * 0.5,
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
    
    var ctxreservation2 = document.getElementById('reservation2').getContext('2d');
    var chartreservation2 = new Chart(ctxreservation2, {
      type: 'pie',
      data:{
        datasets: [{
            data: [<?php echo $pouArc1800 ?>, <?php echo $pouArcChantel ?>, <?php echo $pouArcCharvet ?>, <?php echo $pouArcCharm ?>, <?php echo $pouArcVil ?>, <?php echo 100-($pouArc1800+$pouArcChantel+$pouArcCharvet+$pouArcCharm+$pouArcVil) ?>],
//            backgroundColor: [
//              '#2278dd',
//              '#f54500',
//              '#47b8e0',
//              '#34314c',
//              '#a79c8e',
//              '#f1bbba',
//            ]
            backgroundColor: [
              '#0a1e32',
              '#fe3355',
              '#2278dd',
              '#ff530d',
              '#ffb400',
              '#028a9e',
            ]
        }],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
          'Arc 1800',
          'Arc 1800 (Chantel)',
          'Arc 1800 (Charvet)',
          'Arc 1800 (Charmettoger)',
          'Arc 1800 (Villard)',
          'Autre'
        ]
      },
      options:{
        title: {
            display: true,
            text: "Réservations par Arc",
            fontSize: 18,
            fontColor: '#000000',
        },
        rotation: Math.PI * -0.1,
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