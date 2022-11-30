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
                        <h6 class="panel-title txt-dark">Statistiques Nuitées</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
		<div class="panel-body pb-0">
                    <!--- NOMBRE NUITEES --->
                    <div class="panel panel-inverse card-view">
                            <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title txt-dark">Nombre de nuitées</h6>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="row pa-0 mt-90 ml-0 mr-0">
                                            <div class="col-lg-6 col-md-12">  
                                                <button onclick="exportImage('nombrenuitees')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                                <canvas class="chart_for_mobile chart_for_tablet" id="nombrenuitees" height="250"></canvas>                                          
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <button onclick="exportImage('nombrepersonnes')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                                <canvas class="chart_for_mobile chart_for_tablet" id="nombrepersonnes" height="250"></canvas>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!--- END NOMBRE NUITEES --->                    
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

<!-- Bootstrap Select JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>

/***** Taux remplissage  *****/
var dataTab = [];
    var labelTab = [];
    <?php foreach ($reservationsAns as $label=>$value): ?>
        dataTab.push(<?=$value?>);
        labelTab.push('<?=$label?>');
    <?php endforeach; ?>
    var ctxreservation = document.getElementById('nombrenuitees').getContext('2d');
    var chartreservation = new Chart(ctxreservation, {
      type: 'bar',
      data:{
        datasets: [{
            label: 'Nombre de nuités par an',
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
    
    var dataTab=[];
    var dataTabLoc=[];
    var labelTab=[];
    <?php foreach ($reservationsAge as $label=>$element): ?>
        dataTab.push(<?=$element->nb_adultes?>);
        dataTabLoc.push(<?=$element->nb_enfants?>)
        labelTab.push('<?=$label?>');
    <?php endforeach; ?>
    
    var ctxannonceinsc = document.getElementById('nombrepersonnes').getContext('2d');
    var chartannonceinsc = new Chart(ctxannonceinsc, {
      type: 'bar',
      data:{
        datasets: [
          {
           label: ["Nombre D'adultes"],
           data: dataTab,
           backgroundColor: '#2278dd'
         },
         {
           label: ["Nombre D'enfants"],
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
              size: '8'
            },
          }
        },
        chartArea: {
          backgroundColor: '#FFFFFF'
        }
      }

    });
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

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>

<!-- bootstrap-select CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css", array('block' => 'cssTop')); ?>