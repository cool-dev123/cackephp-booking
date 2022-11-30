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
            width: 40%;
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
                        <h6 class="panel-title txt-dark">Statistiques Loyer Prix Moyen</h6>
                </div>
                    <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
		<div class="panel-body pb-0">
                    <!--- TAUX REMPLISSAGE PAR DATE--->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Par Dates</h6>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="col-sm-12 row-eq-height">
                                            <div class="col-sm-3 align-self-center vcenter" style="text-align:center;">
                                                <!--Form-->
                                                <form>
                                                    <div class="form-group">
                                                            <label class="control-label mb-10 text-left" for="example-email">Village</label>
                                                            <select  name="village" id="villagechoisi" class="form-control">
                                                                <option value="tous">Tous</option>
                                                                <?php foreach ($listGest as $value) { ?>
                                                                  <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                                                <?php } ?>
                                                            </select>
                                                    </div>
                                                    <div class="form-group">
                                                            <label class="control-label mb-10 text-left" for="example-email">Surface</label>
                                                            <select  name="village" id="surfacechoisie" class="form-control">
                                                                <option value="0">0 --- 19 m²</option>
                                                                <option value="1">20 --- 30 m²</option>
                                                                <option value="2">31 --- 40 m²</option>
                                                                <option value="3">41 --- 50 m²</option>
                                                                <option value="4">51 --- 70 m²</option>
                                                                <option value="5">71 --- 100 m²</option>
                                                                <option value="6">101 --- 120 m²</option>
                                                                <option value="7">121 --- 150 m²</option>
                                                                <option value="8">151 --- 180 m²</option>
                                                                <option value="9">181 --- 280 m²</option>
                                                            </select>
                                                    </div>
                                                    <div class="form-group">
                                                            <label class="control-label mb-10 text-left" for="example-email">Année</label>
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
                                                        <button type="button" id="choixsurface" class="btn btn-spec btn-orange">Affichage par mois</button>
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
                                                        <button type="button" onclick="" id="affichagesemaine" class="btn btn-warning btn-spec">Affichage statistique</button>
                                                    </div>
                                                </form>
                                                <!--end Form-->
                                            </div>
                                            <div class="col-sm-9" id="prixloyer_container">
                                                <button onclick="exportImage('prixloyer_container')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button><br>
                                                <br>
                                                <canvas class="resize" id="prixloyer" height="200"></canvas>
                                                <div  id="indexdetail" class="well well-sm card-view text-center">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- END TAUX REMPLISSAGE PAR DATE--->
                    
                    <!--- Loyer Prix Moyen --->
                    <div class="panel panel-inverse card-view">
                            <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title txt-dark">Par Surfaces</h6>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="col-sm-12 row-eq-height">
                                            <div class="col-sm-3 align-self-center vcenter" style="text-align:center;">
                                            <?php if($InfoGes['G']['role']=='admin'){?>
                                            <div class="form-group mt-30 mb-30">
                                            <label class="control-label mb-10 text-left">Gestionnaire</label>
                                                <select class="form-control" name="gestionnaireloyer" id="gestchoisiloyer">
                                                    <option value="tous">Tous</option>
                                                    <?php foreach ($listGest as $value) {
                                                        if($value->role != "admin"){ ?>
                                                        <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                                      <?php } } ?>
                                                </select>
                                            </div>
                                            <?php } ?>
                                            <?php $month = date("n");
                                                    if ($month<9){
                                                        $annee = date("Y")-1;
                                                        $annee2= date("Y");
                                                    }
                                                    else{
                                                        $annee = date("Y");
                                                        $annee2 = date("Y")+1;
                                                    } ?>
                                            <button id="anneeloyer" class="btn  btn-primary btn-spec affichageannee"><?php echo $annee." / ".$annee2; ?></button>

                                            <div class="form-group mt-30 mb-30">
                                            <label class="control-label mb-10 text-left">Choisir un mois</label>
                                                <select class="form-control" name="moischoisieloyer" id="moischoisieloyer">
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
                                            <div class="button-list mt-5">
                                                <button id="moisloyer" class="btn btn-orange btn-spec affichagemois">Statistique mois</button>
                                            </div>
                                            <div class="form-group mt-30 mb-30">
                                            <label class="control-label mb-10 text-left">Choisir une période</label>
                                                <select class="form-control" name="saisonprix" id="saisonprix">
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
                                                                    <input type="text" class="form-control date" id="datefromloyersur">
                                                            </div>
                                                            </div>
                                                            <div class="form-group">
                                                                    <label class="control-label mb-10 col-sm-2">Au:</label>
                                                            <div class="col-sm-10"> 
                                                                    <input type="text" class="form-control date" id="datetoloyersur">
                                                            </div>
                                                            </div>
                                                    </form>
                                            </div>

                                            <button id="semaineloyer" class="btn btn-warning btn-spec affichagemois">Affichage statistique</button>
                                        </div> 
                                        <div class="pl-0 pr-0 mr-0 ml-0 for_canavas col-lg-10 col-md-9 col-sm-9" id="prixloyersur_container">
                                            <button class="btn pull-right btn-success" onclick="exportImage('prixloyersur_container')">Export</button>
                                            <br>
                                            <canvas class="resize" height="300" id="prixloyersur"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!--- END Loyer Prix Moyen --->
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

<!-- Bootstrap Select JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js", array('block' => 'scriptBottom')); ?>

<!-- Bootstrap Datetimepicker JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/moment/min/moment-with-locales.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js", array('block' => 'scriptBottom')); ?>

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
                    
    $("#datefromloyer").on('dp.change', function(e){
    $('#datetoloyer').data("DateTimePicker").destroy();

        $('#datetoloyer').datetimepicker({
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

/***** Prix Moyen  *****/
    <?php
    $i = 0;
    while ($i <= 12){
        $dataArrPrix[] = $listePrixSurface[$i];
        $dataArrPrixTotal[] = $listePrixSurfaceTotalNnReser[$i];
        $colorArrPrix[] = '#2278dd';
        $colorArrPrixTotal[] = '#f54500';
        $i++;
      }
    ?>
    var dataTabPrix = <?php echo json_encode($dataArrPrix) ?>;
    var colorTabPrix = <?php echo json_encode($colorArrPrix) ?>;
    var dataTabPrixTotal = <?php echo json_encode($dataArrPrixTotal) ?>;
    var colorTabPrixTotal = <?php echo json_encode($colorArrPrixTotal) ?>;
    var total = <?php echo json_encode($listeTotal) ?>;

    var id = $("#anneechoisie").val();
    var chaine = 'VILLAGE : ' + $("#villagechoisi").children(':selected').text() + ' / ANNEE : ' + $("#anneechoisie").children(':selected').text() + ' / SURFACE : ' + $("#surfacechoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL');

    var ctxprixloyer = document.getElementById('prixloyer').getContext('2d');
    var chartprixloyer = new Chart(ctxprixloyer, {
      type: 'bar',
      data:{
        datasets: [
          {
            label: 'Loyer Prix Moyen Appartements Réservés (€/Nuitée)',
            data: dataTabPrix,
            backgroundColor: "#2278dd"
          },
          {
            label: 'Loyer Prix Moyen Tous Les Appartements (€/Nuitée)',
            data: dataTabPrixTotal,
            backgroundColor: "#f54500"
          },
      ],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: ["Sep "+(id-1), "Oct "+(id-1), "Nov "+(id-1), "Déc "+(id-1), "Jan "+id, "Fev "+id, "Mar "+id, "Avr "+id, "Mai "+id, "Jun "+id, "Jul "+id, "Aoû "+id]
      },
      options:{
        plugins: {
					datalabels: {
            // formatter: function(value, context) {
            //   return value + ' €/N';
            // },
            color: 'white',
						font: {
              size: '9'
						},
					}
				},
        chartArea: {
          backgroundColor: '#FFFFFF'
        },
        tooltips: {
          callbacks: {
            afterBody: function(data) {
              // console.log(data[0]);
              // console.log(total);
              var lab = '';
              if(data[0].datasetIndex == 0) lab = "Total Annonce Réservé : ";
              else lab = 'Total Annonce : ';
              var multistringText = ["    "+lab+total[data[0].index][data[0].datasetIndex]];
              return multistringText;
            }
          }
        },
        title: {
           display: true,
           padding: 0,
           text: chaine,
         },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
      }
    });


  $("#choixsurface").on("click", function() {
    $('#indexdetail').hide();
    var id_village = $("#villagechoisi").val();
    var annee = $("#anneechoisie").val();
    var surface = $("#surfacechoisie").val();

    $.ajax({
      type: "GET",
      async: false,
      dataType: 'json',
      url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/dataloyerstatischoixsurface/"+id_village+"/"+annee+"/"+surface,
      success:function(xml){
        var an = 0;
        dataTabMoisLoyer = [];
        colorTabMoisLoyer = [];
        dataTabMoisLoyerTotal = [];
        colorTabMoisLoyerTotal = [];
        total = xml.listeTotal;
        while (typeof(xml.listeStatMoisLoyer[an])!="undefined") {
          dataTabMoisLoyer.push(xml.listeStatMoisLoyer[an]);
          colorTabMoisLoyer.push('#2278dd');
          dataTabMoisLoyerTotal.push(xml.listeStatMoisLoyerTotal[an]);
          colorTabMoisLoyerTotal.push('#f54500');
          an++;
        }
        dataMoisLoyer = {
          datasets: [
            {
              label: 'Loyer Prix Moyen Appartements Réservés (€/Nuitée)',
              data: dataTabMoisLoyer,
              backgroundColor: colorTabMoisLoyer
            },
            {
              label: 'Loyer Prix Moyen Tous Les Appartements (€/Nuitée)',
              data: dataTabMoisLoyerTotal,
              backgroundColor: colorTabMoisLoyerTotal
            },
        ],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: ["Sep "+(annee-1), "Oct "+(annee-1), "Nov "+(annee-1), "Déc "+(annee-1), "Jan "+annee, "Fev "+annee, "Mar "+annee, "Avr "+annee, "Mai "+annee, "Jun "+annee, "Jul "+annee, "Aoû "+annee]
        };

        tooltips = function(data) {
              var lab = '';
              if(data[0].datasetIndex == 0) lab = "Total Annonce Réservé : ";
              else lab = 'Total Annonce : ';
              var multistringText = ["    "+lab+total[data[0].index][data[0].datasetIndex]];
              return multistringText;
        };
        chaine = 'VILLAGE : ' + $("#villagechoisi").children(':selected').text() + ' / ANNEE : ' + $("#anneechoisie").children(':selected').text() + ' / SURFACE : ' + $("#surfacechoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL');

        title =  {
           display: true,
           padding: 0,
           text: chaine,
         };

      }
    });
      chartprixloyer.data = dataMoisLoyer;
      chartprixloyer.options.tooltips.callbacks.afterBody = tooltips;
      chartprixloyer.options.title = title;
      chartprixloyer.update();
  });

  $("#affichagesemaine").on("click", function() {
    var id_village = $("#villagechoisi").val();
    var surface = $("#surfacechoisie").val();

    $.ajax({
      type: "POST",
      async: false,
      dataType: 'json',
      url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datasaisonloyerstatis/"+id_village+"/"+surface,
      data: {liste: $('#saisonremplissage').val()},
      success:function(xml){
        var an = 0;
        dataTabSemaineLoyer = [];
        colorTabSemaineLoyer = [];
        dataTabSemaineLoyerTotal = [];
        colorTabSemaineLoyerTotal = [];
        total = xml.listeTotal;
        listeStatSemaineRemplissageLabel = [];
        while (typeof(xml.listeStatSemaineLoyer[an])!="undefined") {
          dataTabSemaineLoyer.push(xml.listeStatSemaineLoyer[an]);
          colorTabSemaineLoyer.push('#2278dd');
          dataTabSemaineLoyerTotal.push(xml.listeStatSemaineLoyerTotal[an]);
          colorTabSemaineLoyerTotal.push('#f54500');
          listeStatSemaineRemplissageLabel.push(xml.listeStatSemaineRemplissageLabel[an+1]);
          an++;
        }
        dataSemaineLoyer = {
          datasets: [
            {
              label: 'Loyer Prix Moyen Appartements Réservés (€/Nuitée)',
              data: dataTabSemaineLoyer,
              backgroundColor: colorTabSemaineLoyer
            },
            {
              label: 'Loyer Prix Moyen Tous Les Appartements (€/Nuitée)',
              data: dataTabSemaineLoyerTotal,
              backgroundColor: colorTabSemaineLoyerTotal
            },
        ],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: listeStatSemaineRemplissageLabel
        };

        tooltips = function(data) {
              var lab = '';
              if(data[0].datasetIndex == 0) lab = "Total Annonce Réservé : ";
              else lab = 'Total Annonce : ';
              var multistringText = ["    "+lab+total[data[0].index][data[0].datasetIndex]];
              return multistringText;
        };

        $("#indexdetail").show();
        $("#indexdetail").html(xml.nbrInscrLabelindex);

        chaine = 'VILLAGE : ' + $("#villagechoisi").children(':selected').text() + ' / SURFACE : ' + $("#surfacechoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL');

        title =  {
           display: true,
           padding: 0,
           text: chaine,
         };

      }
    });
      chartprixloyer.data = dataSemaineLoyer;
      chartprixloyer.options.tooltips.callbacks.afterBody = tooltips;
      chartprixloyer.options.title = title;
      chartprixloyer.update();
  });
/***** END Prix Moyen  *****/
        function printChart(){
            map.export.capture( {}, function() {
                this.toJPG({}, function(data) {
                this.download(data, this.defaults.formats.JPG.mimeType, "amCharts.JPG");
              });
            } );
         }
         /***** Function Export AND Download Image*****/
        function exportImage(id) {
            var canvas = document.querySelector('#'+id+' canvas');
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
        
        /******Loyer Prix Moyen******/
        <?php
    $i = 0;
    $dataArrPrix=[];
    $dataArrPrixTotal=[];
    while ($i <= 9){
        $dataArrPrix[] = $listePrixSurface2[$i];
        $dataArrPrixTotal[] = $listePrixSurfaceTotalNnReser2[$i];
        $colorArrPrix[] = '#f54500';
        $colorArrPrixTotal[] = '#2278dd';
        $i++;
      }
    ?>
    var dataTabPrix = <?php echo json_encode($dataArrPrix) ?>;
    var colorTabPrix = <?php echo json_encode($colorArrPrix) ?>;
    var dataTabPrixTotal = <?php echo json_encode($dataArrPrixTotal) ?>;
    var colorTabPrixTotal = <?php echo json_encode($colorArrPrixTotal) ?>;
    var total = <?php echo json_encode($listeTotal2) ?>;
    if(typeof id_gest == "undefined") chaine = 'Loyer Prix Moyen, DATE : ' + moment().format('LL');
    else chaine = 'Loyer Prix Moyen, GESTIONNAIRE : ' + $("#gestchoisiloyer").children(':selected').text() + ' / DATE : ' + moment().format('LL');

    var ctxprixloyersur = document.getElementById('prixloyersur').getContext('2d');
    var chartprixloyersur = new Chart(ctxprixloyersur, {
      type: 'bar',
      data:{
        datasets: [
          {
            label: 'Loyer Prix Moyen Appartements Réservés (€/Nuitée)',
            data: dataTabPrix,
            backgroundColor: '#f54500'
          },
          {
            label: 'Loyer Prix Moyen Tous Les Appartements (€/Nuitée)',
            data: dataTabPrixTotal,
            backgroundColor: '#2278dd'
          },
      ],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: ['de 0 à 19 m²','de 20 à 30 m²','de 31 à 40 m²','de 41 à 50 m²','de 51 à 70 m²','de 71 à 100 m²','de 101 à 120 m²','de 121 à 150 m²','de 151 à 180 m²','de 181 à 280 m²']
      },
      options:{
        plugins: {
					datalabels: {
            // formatter: function(value, context) {
            //   return value + ' €/N';
            // },
            color: 'white',
						font: {
              size: '9'
						},
					}
				},
        chartArea: {
          backgroundColor: '#FFFFFF'
        },
        tooltips: {
          callbacks: {
            afterBody: function(data) {
              // console.log(data[0]);
              // console.log(total);
              var lab = '';
              if(data[0].datasetIndex == 0) lab = "Total Annonce Réservé : ";
              else lab = 'Total Annonce : ';
              var multistringText = ["    "+lab+total[data[0].index][data[0].datasetIndex]];
              return multistringText;
            }
          }
        },
        title: {
           display: true,
           padding: 0,
           text: chaine,
         }
      }
    });

  /*$("#moischoisieloyer").change(function(){
    var d = new Date();
    var annee = d.getFullYear();
    var mois = $("#moischoisieloyer").val();
    if(mois >= 9 && mois <= 12){
      annee = annee-1;
    }
    $.ajax({
      type: "GET",
      async: false,
      dataType: 'json',
      url: "<?php //echo $this->Url->build('/')?>manager/arrivees/listesemaine/"+annee+"/"+mois,
      success:function(xml){
        var html = '';
        for (var i = 0; i < xml.nbrInscrLabel.length; i++) {
          html += '<option value="'+xml.nbrInscrLabel[i]+'"> '+xml.nbrInscrLabel[i]+' </option>';
        }
        $("#semainechoisieloyer").selectBox('options', html);
      }
    });
  });*/

  $("#moisloyer").on("click", function() {
    var d = new Date();
    var annee = d.getFullYear();
    var id_gest = $("#gestchoisiloyer").val();
    if(typeof id_gest == "undefined") id_gest="tous";
    var mois = $("#moischoisieloyer").val();
    if(mois >= 1 && mois <= 8){
      annee = annee+1;
    }
    $.ajax({
      type: "GET",
      async: false,
      dataType: 'json',
      url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/datamoisloyerstatisindex/"+id_gest+"/"+annee+"/"+mois,
      success:function(xml){
        var an = 0;
        dataTabMoisLoyer = [];
        colorTabMoisLoyer = [];
        dataTabMoisLoyerTotal = [];
        colorTabMoisLoyerTotal = [];
        total = xml.listeTotal;
        while (typeof(xml.listeStatMoisLoyer[an])!="undefined") {
          dataTabMoisLoyer.push(xml.listeStatMoisLoyer[an]);
          colorTabMoisLoyer.push('#f54500');
          dataTabMoisLoyerTotal.push(xml.listeStatMoisLoyerTotal[an]);
          colorTabMoisLoyerTotal.push('#2278dd');
          an++;
        }
        dataMoisLoyer = {
          datasets: [
            {
              label: 'Loyer Prix Moyen Appartements Réservés (€/Nuitée)',
              data: dataTabMoisLoyer,
              backgroundColor: colorTabMoisLoyer
            },
            {
              label: 'Loyer Prix Moyen Tous Les Appartements (€/Nuitée)',
              data: dataTabMoisLoyerTotal,
              backgroundColor: colorTabMoisLoyerTotal
            },
        ],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: ['de 0 à 19 m²','de 20 à 30 m²','de 31 à 40 m²','de 41 à 50 m²','de 51 à 70 m²','de 71 à 100 m²','de 101 à 120 m²','de 121 à 150 m²','de 151 à 180 m²','de 181 à 280 m²']
        };

        tooltips = function(data) {
              var lab = '';
              if(data[0].datasetIndex == 0) lab = "Total Annonce Réservé : ";
              else lab = 'Total Annonce : ';
              var multistringText = ["    "+lab+total[data[0].index][data[0].datasetIndex]];
              return multistringText;
        };
        if(id_gest == "tous") chaine = 'Loyer Prix Moyen, MOIS : ' + $("#moischoisieloyer").children(':selected').text() + ' / DATE : ' + moment().format('LL');
        else chaine = 'Loyer Prix Moyen, GESTIONNAIRE : ' + $("#gestchoisiloyer").children(':selected').text() + ' / MOIS : ' + $("#moischoisieloyer").children(':selected').text() + ' / DATE : ' + moment().format('LL');

        title =  {
           display: true,
           padding: 0,
           text: chaine,
         };

      }
    });
      chartprixloyersur.data = dataMoisLoyer;
      chartprixloyersur.options.tooltips.callbacks.afterBody = tooltips;
      chartprixloyersur.options.title = title;
      chartprixloyersur.update();
  });

  $("#semaineloyer").on("click", function() {
    var id_gest = $("#gestchoisiloyer").val();
    if(typeof id_gest == "undefined") id_gest="tous";
    var from = $("#datefromloyersur").val();
    var to = $("#datetoloyersur").val();
    $.ajax({
      type: "GET",
      async: false,
      dataType: 'json',
      url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/datasemaineloyerstatisindex/"+id_gest+"/"+from+"/"+to,
      success:function(xml){
        var an = 0;
        dataTabSemaineLoyer = [];
        colorTabSemaineLoyer = [];
        dataTabSemaineLoyerTotal = [];
        colorTabSemaineLoyerTotal = [];
        total = xml.listeTotal;
        while (typeof(xml.listeStatSemaineLoyer[an])!="undefined") {
          dataTabSemaineLoyer.push(xml.listeStatSemaineLoyer[an]);
          colorTabSemaineLoyer.push('#f54500');
          dataTabSemaineLoyerTotal.push(xml.listeStatSemaineLoyerTotal[an]);
          colorTabSemaineLoyerTotal.push('#2278dd');
          an++;
        }
        dataSemaineLoyer = {
          datasets: [
            {
              label: 'Loyer Prix Moyen Appartements Réservés (€/Nuitée)',
              data: dataTabSemaineLoyer,
              backgroundColor: colorTabSemaineLoyer
            },
            {
              label: 'Loyer Prix Moyen Tous Les Appartements (€/Nuitée)',
              data: dataTabSemaineLoyerTotal,
              backgroundColor: colorTabSemaineLoyerTotal
            },
        ],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: ['de 0 à 19 m²','de 20 à 30 m²','de 31 à 40 m²','de 41 à 50 m²','de 51 à 70 m²','de 71 à 100 m²','de 101 à 120 m²','de 121 à 150 m²','de 151 à 180 m²','de 181 à 280 m²']
        };

                tooltips = function(data) {
                      var lab = '';
                      if(data[0].datasetIndex == 0) lab = "Total Annonce Réservé : ";
                      else lab = 'Total Annonce : ';
                      var multistringText = ["    "+lab+total[data[0].index][data[0].datasetIndex]];
                      return multistringText;
                };
                if(id_gest == "tous") chaine = 'Loyer Prix Moyen, PERIODE : du ' + from + ' au ' + to + ' / DATE : ' + moment().format('LL');
                else chaine = 'Loyer Prix Moyen, GESTIONNAIRE : ' + $("#gestchoisiloyer").children(':selected').text() + ' / PERIODE : du ' + from + ' au ' + to + ' / DATE : ' + moment().format('LL');

                title =  {
                   display: true,
                   padding: 0,
                   text: chaine,
                 };

      }
    });
      chartprixloyersur.data = dataSemaineLoyer;
      chartprixloyersur.options.tooltips.callbacks.afterBody = tooltips;
      chartprixloyersur.options.title = title;
      chartprixloyersur.update();
  });

  $("#anneeloyer").on("click", function() {
    var id_gest = $("#gestchoisiloyer").val();
    if(typeof id_gest == "undefined") id_gest="tous";
    $.ajax({
      type: "GET",
      async: false,
      dataType: 'json',
      url: "<?php echo $this->Url->build('/',true)?>manager/arrivees/dataanneeloyerstatisindex/"+id_gest,
      success:function(xml){
        var an = 0;
        dataTabAnneeLoyer = [];
        colorTabAnneeLoyer = [];
        dataTabAnneeLoyerTotal = [];
        colorTabAnneeLoyerTotal = [];
        total = xml.listeTotal;
        while (typeof(xml.listeStatAnneeLoyer[an])!="undefined") {
          dataTabAnneeLoyer.push(xml.listeStatAnneeLoyer[an]);
          colorTabAnneeLoyer.push('#f54500');
          dataTabAnneeLoyerTotal.push(xml.listeStatAnneeLoyerTotal[an]);
          colorTabAnneeLoyerTotal.push('#2278dd');
          an++;
        }
        dataAnneeLoyer = {
          datasets: [
            {
              label: 'Loyer Prix Moyen Appartements Réservés (€/Nuitée)',
              data: dataTabAnneeLoyer,
              backgroundColor: colorTabAnneeLoyer
            },
            {
              label: 'Loyer Prix Moyen Tous Les Appartements (€/Nuitée)',
              data: dataTabAnneeLoyerTotal,
              backgroundColor: colorTabAnneeLoyerTotal
            },
        ],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: ['de 0 à 19 m²','de 20 à 30 m²','de 31 à 40 m²','de 41 à 50 m²','de 51 à 70 m²','de 71 à 100 m²','de 101 à 120 m²','de 121 à 150 m²','de 151 à 180 m²','de 181 à 280 m²']
        };

                tooltips = function(data) {
                      var lab = '';
                      if(data[0].datasetIndex == 0) lab = "Total Annonce Réservé : ";
                      else lab = 'Total Annonce : ';
                      var multistringText = ["    "+lab+total[data[0].index][data[0].datasetIndex]];
                      return multistringText;
                };
                if(id_gest == "tous") chaine = 'Loyer Prix Moyen, DATE : ' + moment().format('LL');
                else chaine = 'Loyer Prix Moyen, GESTIONNAIRE : ' + $("#gestchoisiloyer").children(':selected').text() + ' / DATE : ' + moment().format('LL');

                title =  {
                   display: true,
                   padding: 0,
                   text: chaine,
                 };

      }
    });
      chartprixloyersur.data = dataAnneeLoyer;
      chartprixloyersur.options.tooltips.callbacks.afterBody = tooltips;
      chartprixloyersur.options.title = title;
      chartprixloyersur.update();
  });
    /****End Loyer Prix Moyen****/
<?php $this->Html->scriptEnd(); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>
<!-- bootstrap-select CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css", array('block' => 'cssTop')); ?>