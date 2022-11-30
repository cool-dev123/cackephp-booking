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
                        <h6 class="panel-title txt-dark">Statistiques Taux d'occupation</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
		<div class="panel-body pb-0">
                    <!--- TAUX REMPLISSAGE --->
                    <div class="panel panel-inverse card-view">
                            <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title txt-dark">Par Dates</h6>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="col-sm-12 row-eq-height">
                                                        <div class="col-sm-3 align-self-center vcenter" style="text-align:center;">
                                                            <!--Form-->
                                                            <br><br><br>
                                                            <form>
                                                                <?php if($InfoGes['G']['role']=='admin'): ?>
                                                                <div class="form-group">
                                                                        <label class="control-label mb-10 text-left" for="example-email">Village</label>
                                                                        <select  name="village" id="villagechoisi" class="form-control" id="anneechoisie">
                                                                            <option value="tous">Tous</option>
                                                                            <?php foreach ($listGest as $value) { ?>
                                                                              <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                </div>
                                                                <?php endif; ?>
                                                                <div class="form-group">
                                                                    <button type="button" id="affichageannee" class="btn  btn-primary btn-spec">Affichage par années</button>
                                                                </div>
                                                                <div class="form-group">
                                                                        <label class="control-label mb-10 text-left" for="example-email">Choisir une année</label>
                                                                        <select class="form-control" id="anneechoisie">
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
                                                                <div class="form-group">
                                                                        <label class="control-label mb-10 text-left">Choisir Une Saison</label>
                                                                        <select title="Rien sélectionné" name="saisonremplissage" id="saisonremplissage" class="selectpicker" multiple data-style="form-control btn-default btn-outline">

                                                                          <?php foreach ($listeVacances as $value) { ?>
                                                                            <option value="<?php echo $value->id ?>"><?php echo $value->titre ?> - <?php echo $value['Pays']['fr'] ?> - <?php echo $value->zone_champ_vac." : ".$value->dbt_vac." - ".$value->fin_vac ?></option>
                                                                          <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <button type="button" id="affichagesemaine" class="btn btn-warning btn-spec">Affichage Statistique</button>
                                                                </div>
                                                            </form>
                                                            <!--end Form-->
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <button onclick="exportImage('occupation')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                                            <br>
                                                            <canvas class="resize" id="occupation" height="200"></canvas>
                                                            <div class="indexdetail" id="indexdetail">
                                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!--- END TAUX REMPLISSAGE --->
                    
                    <!--- TAUX REMPLISSAGE --->
                    <div class="panel panel-inverse card-view">
                            <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title txt-dark">Par Surfaces</h6>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                    <div class="panel-body row-eq-height">
                                        <div class="pl-0 pr-0 mr-0 ml-0 col-sm-3 text-center vcenter">
                                            <?php if($InfoGes['G']['role']=='admin'){?>
                                            <div class="form-group mt-30 mb-30">
                                            <label class="control-label mb-10 text-left">Gestionnaire</label>
                                                <select class="form-control" name="gestionnaireremplissage" id="gestchoisiremplissage2">
                                                    <option value="tous">Tous</option>
                                                    <?php foreach ($listGestionaires as $value) {
                                                        if($value->role != "admin"){ ?>
                                                        <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                                      <?php } } ?>
                                                </select>
                                            </div>
                                            <?php } ?>

                                            <button id="anneeremplissage2" class="btn  btn-primary btn-spec affichageannee">Statistique <?php echo $year." / ".$year2; ?></button>

                                            <div class="form-group mt-30 mb-30">
                                            <label class="control-label mb-10 text-left">Choisir un mois</label>
                                                <select class="form-control" name="moischoisie" id="moischoisieremplissage2">
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
                                                <button id="moisremplissage2" class="btn btn-orange btn-spec">Statistique mois</button>
                                            </div>
                                            <div class="form-group mt-30 mb-30">
                                            <label class="control-label mb-10 text-left">Choisir une période</label>
                                                <select class="form-control" name="saisonremplissage" id="saisonremplissage2">
                                                    <option value="0">-------</option>
                                                    <?php foreach ($listeVacances as $value) { ?>
                                                      <option value="<?php echo $value->id ?>"><?php echo $value->titre ?> - <?php echo $value['Pays']['fr'] ?> - <?php echo $value->zone_champ_vac ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-wrap">
                                                    <form class="form-horizontal">
                                                            <div class="form-group">
                                                                    <label class="control-label mb-10 col-sm-2">Du:</label>
                                                            <div class="col-sm-10">
                                                                    <input type="text" class="form-control date" id="datefromremplissage2">
                                                            </div>
                                                            </div>
                                                            <div class="form-group">
                                                                    <label class="control-label mb-10 col-sm-2">Au:</label>
                                                            <div class="col-sm-10"> 
                                                                    <input type="text" class="form-control date" id="datetoremplissage2">
                                                            </div>
                                                            </div>
                                                    </form>
                                            </div>

                                            <button id="semaineremplissage2" class="btn btn-warning  btn-spec">Affichage statistique</button>
                                        </div>
                                        <div class="pl-0 pr-0 mr-0 ml-0 for_canavas col-lg-10 col-md-9 col-sm-9">
                                            <button class="btn pull-right btn-success" onclick="exportImage('tauxremplissage2')">Export</button>
                                            <br>
                                            <canvas class="height_for_phones" height="180" id="tauxremplissage2"></canvas>
                                        </div>
                                    </div>
                                </div>
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

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Select JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
    
    $('.date').datetimepicker({
                        useCurrent: false,
                        format: 'DD-MM-YYYY',
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });
    $("#datefromremplissage2").on('dp.change', function(e){
    $('#datetoremplissage2').data("DateTimePicker").destroy();

        $('#datetoremplissage2').datetimepicker({
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
/* Bootstrap Select Init*/
$('.selectpicker').selectpicker();

/***** Taux remplissage  *****/
    <?php $annee=2011;   while ($annee <= $year2){ $data[] = $nbrInscrAn[$annee]; $label[] = ($annee-1)." - ".$annee; $annee++; $color[] = '#3299fe';}; ?>
    var dataTab = <?php echo json_encode($data) ?>;
    var colorTab = <?php echo json_encode($color) ?>;
    var labelTab = <?php echo json_encode($label) ?>;
    if(typeof id_village == "undefined") chaine = 'DATE : ' + moment().format('LL');
    else 'VILLAGE : ' + $("#villagechoisi").children(':selected').text() + ' / DATE : ' + moment().format('LL');
    var ctxannonceinsc = document.getElementById('occupation').getContext('2d');
    var chartannonceinsc = new Chart(ctxannonceinsc, {
      type: 'bar',
      data:{
        datasets: [
          {
           label: ["Taux d'occupation"],
           data: dataTab,
           backgroundColor: '#2278dd'
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
        },
        title: {
           display: true,
           padding: 0,
           text: chaine,
         }
      }

    });

    var dataAnnee = {
      datasets: [
        {
          label: ["Taux d'occupation"],
          data: dataTab,
          backgroundColor: '#2278dd'
       }
    ],
      // These labels appear in the legend and in the tooltips when hovering different arcs
      labels: labelTab
    };

    $("#affichageannee").on("click", function() {
      $("#indexdetail").hide();
      var id_village = $("#villagechoisi").val();
      if(typeof id_village == "undefined") id_village="tous";
      //console.log(id);
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/dataanneetatisoccupation/"+id_village,
        success:function(xml){
          //console.log(xml.nbrInscrAnAnnee);

          var an = 2011;
          dataTabMoisAnnee = [];
          while (typeof(xml.nbrInscrAnAnnee[an])!="undefined") {
            dataTabMoisAnnee.push(xml.nbrInscrAnAnnee[an]);
            an++;
          }

          dataAnneeAN = {
            datasets: [
              {
                label: ["Taux d'occupation"],
                data: dataTabMoisAnnee,
                backgroundColor: '#2278dd'
             }
          ],
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: labelTab
          };

          if(id_village == "tous") chaine = ' DATE : ' + moment().format('LL');
          else chaine = 'VILLAGE : ' + $("#villagechoisi").children(':selected').text() + ' / DATE : ' + moment().format('LL');

          title =  {
             display: true,
             padding: 0,
             text: chaine,
           };

          }
        });
      chartannonceinsc.data = dataAnneeAN;
      chartannonceinsc.options.title = title;
      chartannonceinsc.update();
    });

    var dataTabMois = [];
    var colorTabMois = [];
    var dataMois;
    $("#affichagemois").on("click", function() {
      $("#indexdetail").hide();
      var id = $("#anneechoisie").val();
      var id_village = $("#villagechoisi").val();
      if(typeof id_village == "undefined") id_village="tous";
      //console.log(id);
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datamoisstatisoccupation/"+id+"/"+id_village,
        success:function(xml){
          var an = 0;
          dataTabMois = [];
          colorTabMois = [];
          while (an <= 12) {
            dataTabMois.push(xml.nbrInscrAnMois[an]);
            colorTabMois.push('#f54500');
            an++;
          }

          dataMois = {
            datasets: [
              {
                label: ["Taux d'occupation / Mois"],
                data: dataTabMois,
                backgroundColor: colorTabMois
             }
          ],
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: ["Sep "+(id-1), "Oct "+(id-1), "Nov "+(id-1), "Déc "+(id-1), "Jan "+id, "Fev "+id, "Mar "+id, "Avr "+id, "Mai "+id, "Jun "+id, "Jul "+id, "Aoû "+id]
          };

          if(id_village == "tous") chaine = ' ANNEE : ' + $("#anneechoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL');
          else chaine = 'VILLAGE : ' + $("#villagechoisi").children(':selected').text() + ' / ANNEE : ' + $("#anneechoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL');

          title =  {
             display: true,
             padding: 0,
             text: chaine,
           };

          }
        });
        chartannonceinsc.data = dataMois;
        chartannonceinsc.options.title = title;
        chartannonceinsc.update();

    });

    $("#affichagesemaine").on("click", function() {
      var id_village = $("#villagechoisi").val();
      if(typeof id_village == "undefined") id_village="tous";
      $.ajax({
        type: "POST",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datasemaineremplissagestatisoccupation/"+id_village,
        data: {liste: $('#saisonremplissage').val()},
        success:function(xml){
          var an = 1;
          dataTabSemaineRemplissage = [];
          colorTabSemaineRemplissage = [];
          listeStatSemaineRemplissageLabel = [];
          while (typeof(xml.listeStatSemaineRemplissage[an])!="undefined") {
            dataTabSemaineRemplissage.push(xml.listeStatSemaineRemplissage[an]);
            colorTabSemaineRemplissage.push('#f8b006');
            listeStatSemaineRemplissageLabel.push(xml.listeStatSemaineRemplissageLabel[an]);
            an++;
          }
          // console.log(listeStatSemaineRemplissageLabel);
          dataSemaineRemplissage = {
            datasets: [
              {
                label: 'Taux Remplissage',
                data: dataTabSemaineRemplissage,
                backgroundColor: '#f8b006'
              }
          ],
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: listeStatSemaineRemplissageLabel
          };
          $("#indexdetail").show();
          $("#indexdetail").html(xml.nbrInscrLabelindex);

          if(id_village == "tous") chaine = ' DATE : ' + moment().format('LL');
          else chaine = 'VILLAGE : ' + $("#villagechoisi").children(':selected').text() + ' / DATE : ' + moment().format('LL');

          title =  {
             display: true,
             padding: 0,
             text: chaine,
           };

        }
      });
      chartannonceinsc.data = dataSemaineRemplissage;
      chartannonceinsc.options.title = title;
      chartannonceinsc.update();

    });
/***** END Taux remplissage  *****/

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
        
          /******Taux Remplissage******/
          <?php
  $i = 0;
  $dataRemplissage=[];
  $colorRemplissage=[];
  while ($i <= 9){
      $dataRemplissage[] = $listeRemplissage[$i];
      $colorRemplissage[] = '#2278dd';
      $i++;
    }
  ?>
  var dataTabRemplissage = <?php echo json_encode($dataRemplissage) ?>;
  var colorTabRemplissage = <?php echo json_encode($colorRemplissage) ?>;
  if(typeof id_gest == "undefined") chaine = 'Taux Remplissage, DATE : ' + moment().format('LL');
  else chaine = 'Taux Remplissage, GESTIONNAIRE : ' + $("#gestchoisiremplissage2").children(':selected').text() + ' / DATE : ' + moment().format('LL');

  var ctxremplissage2 = document.getElementById('tauxremplissage2').getContext('2d');
  var chartremplissage2 = new Chart(ctxremplissage2, {
    type: 'bar',
    data:{
      datasets: [
        {
         label: ["Taux Remplissage"],
         data: dataTabRemplissage,
         backgroundColor: colorTabRemplissage
       }
    ],
      // These labels appear in the legend and in the tooltips when hovering different arcs
      labels: ['de 0 à 19 m²','de 20 à 30 m²','de 31 à 40 m²','de 41 à 50 m²','de 51 à 70 m²','de 71 à 100 m²','de 101 à 120 m²','de 121 à 150 m²','de 151 à 180 m²','de 181 à 280 m²']
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
          formatter: function(value, context) {
            return value + ' %';
          },
          /*anchor: 'end',
					align: 'start',*/
          color: 'white',
          font: {
            size: '15'
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

// $("#moischoisieremplissage2").change(function(){
//   var d = new Date();
//   var annee = d.getFullYear();
//   var mois = $("#moischoisieremplissage2").val();
//   if(mois >= 9 && mois <= 12){
//     annee = annee-1;
//   }
//   $.ajax({
//     type: "GET",
//     async: false,
//     dataType: 'json',
//     url: "<?php //echo $this->Url->build('/',true)?>manager/arrivees/listesemaine/"+annee+"/"+mois,
//     success:function(xml){
//       var html = '';
//       for (var i = 0; i < xml.nbrInscrLabel.length; i++) {
//         html += '<option value="'+xml.nbrInscrLabel[i]+'"> '+xml.nbrInscrLabel[i]+' </option>';
//         }
//       $("#semainechoisieremplissage").selectBox('options', html);
//       }
//     });
//   });

  $("#anneeremplissage2").on("click", function() {
    var id_gest = $("#gestchoisiremplissage2").val();
    if(typeof id_gest == "undefined") id_gest="tous";
    $.ajax({
      type: "GET",
      async: false,
      dataType: 'json',
      url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/dataanneeremplissagestatisindex/"+id_gest,
      success:function(xml){
        var an = 0;
        dataTabAnneeRemplissage = [];
        colorTabAnneeRemplissage = [];
        while (typeof(xml.listeStatAnneeRemplissage[an])!="undefined") {
          dataTabAnneeRemplissage.push(xml.listeStatAnneeRemplissage[an]);
          colorTabAnneeRemplissage.push('#2278dd');
          an++;
        }
        dataAnneeRemplissage = {
          datasets: [
            {
              label: 'Taux Remplissage',
              data: dataTabAnneeRemplissage,
              backgroundColor: colorTabAnneeRemplissage
            }
        ],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: ['de 0 à 19 m²','de 20 à 30 m²','de 31 à 40 m²','de 41 à 50 m²','de 51 à 70 m²','de 71 à 100 m²','de 101 à 120 m²','de 121 à 150 m²','de 151 à 180 m²','de 181 à 280 m²']
        };
        if(id_gest == "tous") chaine = 'Taux Remplissage, DATE : ' + moment().format('LL');
        else chaine = 'Taux Remplissage, GESTIONNAIRE : ' + $("#gestchoisiremplissage2").children(':selected').text() + ' / DATE : ' + moment().format('LL');

        title =  {
           display: true,
           padding: 0,
           text: chaine,
         };

      }
    });
      chartremplissage2.data = dataAnneeRemplissage;
      chartremplissage2.options.title = title;
      chartremplissage2.update();
  });

  $("#moisremplissage2").on("click", function() {
    var d = new Date();
    var annee = d.getFullYear();
    var id_gest = $("#gestchoisiremplissage2").val();
    if(typeof id_gest == "undefined") id_gest="tous";
    var mois = $("#moischoisieremplissage2").val();
    if(mois >= 1 && mois <= 8){
      annee = annee+1;
    }
    $.ajax({
      type: "GET",
      async: false,
      dataType: 'json',
      url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/datamoisremplissagestatisindex/"+id_gest+"/"+annee+"/"+mois,
      success:function(xml){
        var an = 0;
        dataTabMoisRemplissage = [];
        colorTabMoisRemplissage = [];
        while (typeof(xml.listeStatMoisRemplissage[an])!="undefined") {
          dataTabMoisRemplissage.push(xml.listeStatMoisRemplissage[an]);
          colorTabMoisRemplissage.push('#f54500');
          an++;
        }
        dataMoisRemplissage = {
          datasets: [
            {
              label: 'Taux Remplissage',
              data: dataTabMoisRemplissage,
              backgroundColor: colorTabMoisRemplissage
            }
        ],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: ['de 0 à 19 m²','de 20 à 30 m²','de 31 à 40 m²','de 41 à 50 m²','de 51 à 70 m²','de 71 à 100 m²','de 101 à 120 m²','de 121 à 150 m²','de 151 à 180 m²','de 181 à 280 m²']
        };
        if(id_gest == "tous") chaine = 'Taux Remplissage, MOIS : ' + $("#moischoisieremplissage2").children(':selected').text() + ' / DATE : ' + moment().format('LL');
        else chaine = 'Taux Remplissage, GESTIONNAIRE : ' + $("#gestchoisiremplissage2").children(':selected').text() + ' / MOIS : ' + $("#moischoisieremplissage2").children(':selected').text() + ' / DATE : ' + moment().format('LL');

        title =  {
           display: true,
           padding: 0,
           text: chaine,
         };

      }
    });
      chartremplissage2.data = dataMoisRemplissage;
      chartremplissage2.options.title = title;
      chartremplissage2.update();
  });

  $("#semaineremplissage2").on("click", function() {
    var id_gest = $("#gestchoisiremplissage2").val();
    if(typeof id_gest == "undefined") id_gest="tous";
    var from = $("#datefromremplissage2").val();
    var to = $("#datetoremplissage2").val();
    $.ajax({
      type: "GET",
      async: false,
      dataType: 'json',
      url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/datasemaineremplissagestatisindex/"+id_gest+"/"+from+"/"+to,
      success:function(xml){
        var an = 0;
        dataTabSemaineRemplissage = [];
        colorTabSemaineRemplissage = [];
        while (typeof(xml.listeStatSemaineRemplissage[an])!="undefined") {
          dataTabSemaineRemplissage.push(xml.listeStatSemaineRemplissage[an]);
          colorTabSemaineRemplissage.push('#f8b006');
          an++;
        }
        dataSemaineRemplissage = {
          datasets: [
            {
              label: 'Taux Remplissage',
              data: dataTabSemaineRemplissage,
              backgroundColor: colorTabSemaineRemplissage
            }
        ],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: ['de 0 à 19 m²','de 20 à 30 m²','de 31 à 40 m²','de 41 à 50 m²','de 51 à 70 m²','de 71 à 100 m²','de 101 à 120 m²','de 121 à 150 m²','de 151 à 180 m²','de 181 à 280 m²']
        };
        if(id_gest == "tous") chaine = 'Taux Remplissage, PERIODE : du ' + from + ' au ' + to + ' / DATE : ' + moment().format('LL');
        else chaine = 'Taux Remplissage, GESTIONNAIRE : ' + $("#gestchoisiremplissage2").children(':selected').text() + ' / PERIODE : du ' + from + ' au ' + to + ' / DATE : ' + moment().format('LL');

        title =  {
           display: true,
           padding: 0,
           text: chaine,
         };

      }
    });
      chartremplissage2.data = dataSemaineRemplissage;
      chartremplissage2.options.title = title;
      chartremplissage2.update();
  });
    /****End Taux Remplissage****/
    
    $('#saisonremplissage2').on( "change", function() {
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/datasaisonremplissage/"+this.value,
        success:function(xml){
          if(xml.dbt != ""){
            var fromdd = moment(xml.dbt);
            $('#datefromremplissage2').data("DateTimePicker").destroy();
            $('#datefromremplissage2').datetimepicker({viewDate:fromdd.format('DD-MM-YYYY'),format: 'DD-MM-YYYY',date:fromdd.format('DD-MM-YYYY')});
            $('#datefromremplissage2').val(fromdd.format('DD-MM-YYYY'));
          }else{
            $('#datefromremplissage2').val("");
          }
          if(xml.fin != ""){
            var todd = moment(xml.fin);
            $('#datetoremplissage2').data("DateTimePicker").destroy();
            $('#datetoremplissage2').datetimepicker({viewDate:todd.format('DD-MM-YYYY'),format: 'DD-MM-YYYY',date:todd.format('DD-MM-YYYY')});
            $('#datetoremplissage2').val(todd.format('DD-MM-YYYY'));
          }else{
            $('#datetoremplissage2').val("");
          }
        }
      });
    });
<?php $this->Html->scriptEnd(); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>

<!-- bootstrap-select CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css", array('block' => 'cssTop')); ?>