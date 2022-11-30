<?php $month = date("n");
    if ($month<9){
        $year = date("Y")-1;
        $year2= date("Y");
    }
    else{
        $year = date("Y");
        $year2 = date("Y")+1;
    }
?>
<?php $this->start('cssTop'); ?>
<style>
    @media screen and (max-width: 400px)  {
        .height_for_phones{
            width: 50%;
        }
    }
    @media screen and (max-width: 800px) and (min-width: 401px)  {
        .height_for_phones{
            width: 30%;
        }
    }
    @media screen and (max-width: 800px) and (min-width: 501px)  {
        .btn-spec{
            padding: 4px 5px 4px 5px !important;
            font-size: 13px !important;
        }
    }
    @media screen and (max-width: 990px)  {
        .for_canavas{ margin-top: 5% !important;}
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
    border: solid 1px #f54500 !important;
  }
</style>
<?php $this->end(); ?>
<?php echo $this->element('menustatistiques'); ?>

<div class="row">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view">
                <div class="panel-heading icantSelectIt">
                        <div class="pull-left">
                                <h6 class="panel-title txt-dark">Nombre d'arrivées</h6>
                        </div>
                        <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                        <div class="panel-body row-eq-height">
                            <div class="pl-0 pr-0 mr-0 ml-0 col-sm-3 text-center vcenter">
                                <?php if($InfoGes['G']['role']=='admin'){?>
                                <div class="form-group mt-30 mb-10">
                                <label class="control-label mb-10 text-left">Gestionnaire</label>
                                    <select class="form-control mb-10" name="gestionnaire" id="gestchoisi">
                                        <option value="tous">Tous</option>
                                        <?php foreach ($listGest as $value) {
                                          if($value->role != "admin"){ ?>
                                          <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <?php } ?>
                                <div class="form-group mb-30">
                                <label class="control-label mb-10 text-left">Choisir une année</label>
                                    <select class="form-control" name="annee" id="annee">
                                        <?php $annee=2011; $i=1;  while ($annee <= $year2){
                                                                ?>
                                        <option <?php if($annee==$year2):?>selected<?php endif; ?> value="<?php echo $annee ?>"><?php echo ($annee-1)." - ".$annee ?></option>
                                                                <?php
                                                                $annee++;
                                                            }; ?>
                                    </select>
                                </div>

                                <button id="affichageannee" class="btn btn-spec btn-primary affichageannee">Affichage par mois</button>

                                <div class="form-group mt-30 mb-30">
                                <label class="control-label mb-10 text-left">Choisir un mois</label>
                                    <select class="form-control" name="moischoisie" id="moischoisie">
                                        <option <?php if(date('m')==9) echo "selected"; ?> value="9">Septembre</option>
                                        <option <?php if(date('m')==10) echo "selected"; ?> value="10">Octobre</option>
                                        <option <?php if(date('m')==11) echo "selected"; ?> value="11">Novembre</option>
                                        <option <?php if(date('m')==12) echo "selected"; ?> value="12">Décembre</option>
                                        <option <?php if(date('m')==1) echo "selected"; ?> value="1">Janvier</option>
                                        <option <?php if(date('m')==2) echo "selected"; ?> value="2">Fevrier</option>
                                        <option <?php if(date('m')==3) echo "selected"; ?> value="3">Mars</option>
                                        <option <?php if(date('m')==4) echo "selected"; ?> value="4">Avril</option>
                                        <option <?php if(date('m')==5) echo "selected"; ?> value="5">Mai</option>
                                        <option <?php if(date('m')==6) echo "selected"; ?> value="6">Juin</option>
                                        <option <?php if(date('m')==7) echo "selected"; ?> value="7">Juillet</option>
                                        <option <?php if(date('m')==8) echo "selected"; ?> value="8">Août</option>
                                    </select>
                                </div>
                                <div class="button-list mt-25">
                                    <button id="affichagemois" class="btn btn-orange btn-spec affichagemois">Affichage par semaine</button>
                                    <button id="affichagesemaine" class="btn btn-warning btn-spec affichagesemaine">Affichage par jour</button>
                                </div>
                            </div>
                            <div class="pl-0 pr-0 mr-0 ml-0 for_canavas col-lg-10 col-md-9 col-sm-9">
                                <button id="exportCahrt_arrivees" class="btn pull-right btn-success" onclick="exportImage('arrivees')">Export</button>
                                <br>
                                <canvas class="height_for_phones" height="180" id="arrivees"></canvas>
                            </div>
                        </div>
                </div>
        </div>
    </div>
</div>

<!-- ChartJS JavaScript -->
<?php $this->Html->script("/manager-arr/js/chart.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/js/chartjs-plugin-datalabels.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
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
    /*****END Download Image*****/
    $( document ).ready(function() {
        affichagesemaine();
    });
    /*****Nombre D'arrivées******/
  <?php
    $dernierjour = mktime(0, 0, 0, (date("m")+1), 1, date("Y"));
    $dernierjour--;
    $dateDernierJour = strftime("%d", $dernierjour);
    $i = 1;
    while ($i <= $dateDernierJour){
      $dataArr[] = $listeStatArri[$i];
      $colorArr[] = '#2278dd';
      $dataNnArr[] = $listeStatNnArri[$i];
      $colorNnArr[] = '#f54500';
      $dataLabel[] = $i.date("M");
      $i++;
    }
  ?>

    $('#exportCahrt_arrivees').click(function(){

    });
    var dataTabArr = <?php echo json_encode($dataArr) ?>;
    var colorTabArr = <?php echo json_encode($colorArr) ?>;
    var dataTabNnArr = <?php echo json_encode($dataNnArr) ?>;
    var colorTabNnArr = <?php echo json_encode($colorNnArr) ?>;
    var dataLabel = <?php echo json_encode($dataLabel) ?>;
    if(typeof id_gest == "undefined") chaine = 'Nombre D\'arrivées, MOIS : ' + $("#moischoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL');
    else chaine = 'Nombre D\'arrivées, GESTIONNAIRE : ' + $("#gestchoisi").children(':selected').text() + ' / MOIS : ' + $("#moischoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL');

    var ctxreservation = document.getElementById('arrivees').getContext('2d');
    var chartreservation = new Chart(ctxreservation, {
      type: 'bar',
      data:{
        datasets: [
          {
            label: 'Nombre arrivée',
            data: dataTabArr,
            backgroundColor: '#2278dd'
          },
          {
            label: 'Nombre non arrivée',
            data: dataTabNnArr,
            backgroundColor: '#f54500'
          },
      ],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: dataLabel
      },
      options:{
        plugins: {
            datalabels: {
                color: 'white',
                    font: {
                size: '9'
                    },
            }
        },
        chartArea: {
          backgroundColor: '#FFFFFF'
        },
        title: {
           display: true,
           padding: 0,
           text: chaine,
         }
      }
    });

    $("#affichageannee").on("click", function() {
      var d = new Date();
      var id = parseInt($("#annee").val());
      var id_gest = $("#gestchoisi").val();
      if(typeof id_gest == "undefined") id_gest="tous";
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/datamoisstatisindex/"+id_gest+'/'+id,
        success:function(xml){
          var an = 0;
          dataTabArrMois = [];
          colorTabArrMois = [];
          dataTabNnArrMois = [];
          colorTabNnArrMois = [];
          while (an <= 12) {
            dataTabArrMois.push(xml.listeStatArriMois[an]);
            dataTabNnArrMois.push(xml.listeStatNnArriMois[an]);
            colorTabArrMois.push('#2278dd');
            colorTabNnArrMois.push('#f54500');
            an++;
          }

          dataMois = {
            datasets: [
              {
                label: 'Nombre arrivée',
                data: dataTabArrMois,
                backgroundColor: colorTabArrMois
              },
              {
                label: 'Nombre non arrivée',
                data: dataTabNnArrMois,
                backgroundColor: colorTabNnArrMois
              },
          ],
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: ["Sep "+(id-1), "Oct "+(id-1), "Nov "+(id-1), "Déc "+(id-1), "Jan "+id, "Fev "+id, "Mar "+id, "Avr "+id, "Mai "+id, "Jun "+id, "Jul "+id, "Aoû "+id]
          };
          if(id_gest == "tous") chaine = 'Nombre D\'arrivées, DATE : ' + moment().format('LL');
          else chaine = 'Nombre D\'arrivées, GESTIONNAIRE : ' + $("#gestchoisi").children(':selected').text() + ' / DATE : ' + moment().format('LL');

          title =  {
             display: true,
             padding: 0,
             text: chaine,
           };

        }
      });
        chartreservation.data = dataMois;
        chartreservation.options.title = title;
        chartreservation.update();
    });

    $("#affichagemois").on("click", function() {
      var d = new Date();
      var id = parseInt($("#annee").val());
      var id_gest = $("#gestchoisi").val();
      if(typeof id_gest == "undefined") id_gest="tous";
      var id_mois = $("#moischoisie").val();
      if(!(id_mois >= 1 && id_mois <= 8)){
        id = id-1;
      }
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/datasemainestatisindex/"+id_gest+"/"+id+"/"+id_mois,
        success:function(xml){
          var an = 0;
          dataTabArrSem = [];
          colorTabArrSem = [];
          dataTabNnArrSem = [];
          colorTabNnArrSem = [];
          labelTabSem = [];
          while (typeof(xml.listeStatArriSem[an])!="undefined") {
            dataTabArrSem.push(xml.listeStatArriSem[an]);
            dataTabNnArrSem.push(xml.listeStatNnArriSem[an]);
            labelTabSem.push(xml.listeStatLabelSem[an]);
            colorTabArrSem.push('#2278dd');
            colorTabNnArrSem.push('#f54500');
            an++;
          }

          dataSemaine = {
            datasets: [
              {
                label: 'Nombre arrivée',
                data: dataTabArrSem,
                backgroundColor: colorTabArrSem
              },
              {
                label: 'Nombre non arrivée',
                data: dataTabNnArrSem,
                backgroundColor: colorTabNnArrSem
              },
          ],
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: labelTabSem
          };
          if(id_gest == "tous") chaine = 'Nombre D\'arrivées, MOIS : ' + $("#moischoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL');
          else chaine = 'Nombre D\'arrivées, GESTIONNAIRE : ' + $("#gestchoisi").children(':selected').text() + ' / MOIS : ' + $("#moischoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL');

          title =  {
             display: true,
             padding: 0,
             text: chaine,
           };

        }
      });
        chartreservation.data = dataSemaine;
        chartreservation.options.title = title;
        chartreservation.update();
    });

    $("#affichagesemaine").on("click", function() {
        affichagesemaine();
    });

    function affichagesemaine(){
      var d = new Date();
      var id = parseInt($("#annee").val());
      var id_gest = $("#gestchoisi").val();
      if(typeof id_gest == "undefined") id_gest="tous";
      var id_mois = $("#moischoisie").val();
      if(!(id_mois >= 1 && id_mois <= 8)){
        id = id-1;
      }
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/datajourstatisindex/"+id_gest+"/"+id+"/"+id_mois,
        success:function(xml){
          var an = 0;
          dataTabArrJour = [];
          colorTabArrJour = [];
          dataTabNnArrJour = [];
          colorTabNnArrJour = [];
          labelTabJour = [];
          while (typeof(xml.listeStatArriJour[an])!="undefined") {
            dataTabArrJour.push(xml.listeStatArriJour[an]);
            dataTabNnArrJour.push(xml.listeStatNnArriJour[an]);
            labelTabJour.push(xml.listeStatLabelJour[an]);
            colorTabArrJour.push('#2278dd');
            colorTabNnArrJour.push('#f54500');
            an++;
          }

          dataJour = {
            datasets: [
              {
                label: 'Nombre arrivée',
                data: dataTabArrJour,
                backgroundColor: colorTabArrJour
              },
              {
                label: 'Nombre non arrivée',
                data: dataTabNnArrJour,
                backgroundColor: colorTabNnArrJour
              },
          ],
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: labelTabJour
          };
          if(id_gest == "tous") chaine = 'Nombre D\'arrivées, MOIS : ' + $("#moischoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL');
          else chaine = 'Nombre D\'arrivées, GESTIONNAIRE : ' + $("#gestchoisi").children(':selected').text() + ' / MOIS : ' + $("#moischoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL');
          title =  {
             display: true,
             padding: 0,
             text: chaine,
           };

        }
      });
        chartreservation.data = dataJour;
        chartreservation.options.title = title;
        chartreservation.update();
    }
    /***End Nombre D'arrivées****/
<?php $this->Html->scriptEnd(); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>