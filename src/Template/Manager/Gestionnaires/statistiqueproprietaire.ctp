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
        #contrats{
            width: 40%;
        }
        #chiffre{
            width: 40%;
        }
        .btn-spec{
            padding: 4px 5px 4px 5px !important;
        }
    }
    @media screen and (max-width: 800px) and (min-width: 501px)  {
        #contrats{
            width: 40%;
        }
        #chiffre{
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
                        <h6 class="panel-title txt-dark">Statistiques Propriétaires</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
		<div class="panel-body pb-0">
                    <!--- TAUX REMPLISSAGE --->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Taux remplissage des appartements</h6>
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
                                                        <label class="control-label mb-10 text-left">Propriétaire</label>
                                                        <select class="form-control select2" name="proprietaire" id="proprietairechoisi">
                                                            <?php foreach ($listProp as $value) {?>
                                                                <option value="<?php echo $value->id ?>"><?php echo $value->prenom ?> <?php echo $value->nom_famille ?> - <?php echo $value->email ?></option>
                                                            <?php } ?>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" id="affichageannee" class="btn btn-spec btn-primary">Affichage par années</button>
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
                                                    <button type="button" id="affichagemois" class="btn btn-spec btn-orange">Affichage par mois</button>
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
                                                    <button type="button" id="semaineremplissage" class="btn btn-spec btn-warning">Affichage statistique</button>
                                                </div>
                                            </form>
                                            <!--end Form-->
                                        </div>
                                        <div class="col-sm-9">
                                            <button onclick="exportImage('contrats')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <br>
                                            <canvas id="contrats" height="200"></canvas>
                                            <div id="indexdetail" class="indexdetail"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- END TAUX REMPLISSAGE --->
                    <!--- TAUX Chiffre d'affaire --->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Chiffre d'affaire</h6>
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
                                                        <label class="control-label mb-10 text-left">Propriétaire</label>
                                                        <select class="form-control select2" name="proprietairechiffre" id="proprietairechoisichiffre">
                                                            <option value="tous">Tous</option>
                                                            <?php foreach ($listProp as $value) {?>
                                                                <option value="<?php echo $value->id ?>"><?php echo $value->prenom ?> <?php echo $value->nom_famille ?> - <?php echo $value->email ?></option>
                                                            <?php } ?>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" id="affichageanneechiffre" class="btn btn-spec btn-primary">Affichage par années</button>
                                                </div>
                                                <div class="form-group">
                                                        <label class="control-label mb-10 text-left" for="example-email">Choisir une année</label>
                                                        <select class="form-control" name="anneechoisiechiffre" id="anneechoisiechiffre">
                                                            <?php $annee=2011;  while ($annee <= $year2){
                                                                ?>
                                                                <option value="<?php echo $annee ?>"><?php echo ($annee-1)." - ".$annee ?></option>
                                                                <?php
                                                                $annee++;
                                                            }; ?>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" id="affichagemoischiffre" class="btn btn-spec btn-orange">Affichage par mois</button>
                                                </div>
                                                <div class="form-group">
                                                        <label class="control-label mb-10 text-left">Choisir Une Saison</label>
                                                        <select title="Rien sélectionné" name="saisonremplissagechiffre" id="saisonremplissagechiffre" class="selectpicker" multiple data-style="form-control btn-default btn-outline">
                                                        
                                                          <?php foreach ($listeVacances as $value) { ?>
                                                            <option value="<?php echo $value->id ?>"><?php echo $value->titre ?> - <?php echo $value['Pays']['fr'] ?> - <?php echo $value->zone_champ_vac." : ".$value->dbt_vac." - ".$value->fin_vac ?></option>
                                                          <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" id="semaineremplissagechiffre" class="btn btn-warning btn-spec">Affichage statistique</button>
                                                </div>
                                            </form>
                                            <!--end Form-->
                                        </div>
                                        <div class="col-sm-9">
                                            <button onclick="exportImage('chiffre')" class="btn btn-primary btn-anim pull-right"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <br>
                                            <canvas id="chiffre" height="200"></canvas>
                                            <div id="indexdetailchiffre" class="indexdetail"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- END Chiffre d'affaire --->
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
<!-- Select2 JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Select JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/moment.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/fullcalendar.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/locale/fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
/* Select2 Init*/
$(".select2").select2();
/* Bootstrap Select Init*/
$('.selectpicker').selectpicker();

/***** Taux remplissage  *****/
    <?php $annee=2011;   while ($annee <= $year2){ $data[] = $nbrInscrAn[$annee]; $label[] = ($annee-1)." - ".$annee; $annee++; $color[] = '#3299fe';}; ?>
    var dataTab = <?php echo json_encode($data) ?>;
    var colorTab = <?php echo json_encode($color) ?>;
    var labelTab = <?php echo json_encode($label) ?>;

    var ctxannonceinsc = document.getElementById('contrats').getContext('2d');
    var chartannonceinsc = new Chart(ctxannonceinsc, {
      type: 'bar',
      data:{
        datasets: [
          {
           label: ["Taux remplissage"],
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

    var dataAnnee = {
      datasets: [
        {
          label: ["Taux remplissage"],
          data: dataTab,
          backgroundColor: colorTab
       }
    ],
      // These labels appear in the legend and in the tooltips when hovering different arcs
      labels: labelTab
    };

    $("#affichageannee").on("click", function() {
      $("#indexdetail").hide();
      var id_proprietaire = $("#proprietairechoisi").val();
      // console.log(id_proprietaire);
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/dataanneetatisoccupationprop/"+id_proprietaire,
        success:function(xml){
          var an = 2011;
          dataTabMoisAnnee = [];
          while (typeof(xml.nbrInscrAnAnnee[an])!="undefined") {
            dataTabMoisAnnee.push(xml.nbrInscrAnAnnee[an]);
            an++;
          }

          dataAnneeAN = {
            datasets: [
              {
                label: ["Taux remplissage"],
                data: dataTabMoisAnnee,
                backgroundColor: colorTab
             }
          ],
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: labelTab
          };

          title =  {
             display: true,
             padding: 0,
             text: 'Propriétaire : '+ $("#proprietairechoisi").children(':selected').text() + ' / DATE : ' + moment().format('LL'),
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
      console.log
      var id_proprietaire = $("#proprietairechoisi").val();
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datamoisstatisoccupationprop/"+id+"/"+id_proprietaire,
        success:function(xml){
          var an = 0;
          dataTabMois = [];
          colorTabMois = [];
          while (an <= 12) {
            dataTabMois.push(xml.nbrInscrAnMois[an]);
            colorTabMois.push('#ff530d');
            an++;
          }

          dataMois = {
            datasets: [
              {
                label: ["Taux remplissage / Mois"],
                data: dataTabMois,
                backgroundColor: colorTabMois
             }
          ],
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: ["Sep "+(id-1), "Oct "+(id-1), "Nov "+(id-1), "Déc "+(id-1), "Jan "+id, "Fev "+id, "Mar "+id, "Avr "+id, "Mai "+id, "Jun "+id, "Jul "+id, "Aoû "+id]
          };

          title =  {
             display: true,
             padding: 0,
             text: 'PROPRIETAIRE : ' + $("#proprietairechoisi").children(':selected').text() + ' / ANNEE : '+ $("#anneechoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL'),
           };

          }
        });
        chartannonceinsc.data = dataMois;
        chartannonceinsc.options.title = title;
        chartannonceinsc.update();

    });

    $("#semaineremplissage").on("click", function() {
      var id_proprietaire = $("#proprietairechoisi").val();
      $.ajax({
        type: "POST",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datasemaineremplissagestatisprop/"+id_proprietaire,
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
                backgroundColor: colorTabSemaineRemplissage
              }
          ],
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: listeStatSemaineRemplissageLabel
          };
          $("#indexdetail").show();
          $("#indexdetail").html(xml.nbrInscrLabelindex);

          title =  {
             display: true,
             padding: 0,
             text: 'PROPRIETAIRE : ' + $("#proprietairechoisi").children(':selected').text() + ' / DATE : ' + moment().format('LL'),
           };

        }
      });
        chartannonceinsc.data = dataSemaineRemplissage;
        chartannonceinsc.options.title = title;
        chartannonceinsc.update();
    });
/***** END Taux remplissage  *****/


/**** CHIFFRE D AFFAIRE ****/

  <?php $annee=2011;   while ($annee <= $year2){ $datachiffre[] = $nbrInscrAnchiffre[$annee]; $labelchiffre[] = ($annee-1)." - ".$annee; $annee++; $colorchiffre[] = '#3299fe';}; ?>
  var dataTabchiffre = <?php echo json_encode($datachiffre) ?>;
  var colorTabchiffre = <?php echo json_encode($colorchiffre) ?>;
  var labelTabchiffre = <?php echo json_encode($labelchiffre) ?>;

  var ctxannonceinscchiffre = document.getElementById('chiffre').getContext('2d');
  var chartannonceinscchiffre = new Chart(ctxannonceinscchiffre, {
    type: 'bar',
    data:{
      datasets: [
        {
         label: ["Chiffre d'affaire (€)"],
         data: dataTabchiffre,
         backgroundColor: '#2278dd'
       }
    ],
      // These labels appear in the legend and in the tooltips when hovering different arcs
      labels: labelTabchiffre
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
            return value + '€';
          },
          // color: 'black',
          font: {
            size: '12'
          },
          anchor: 'end',
          align: 'end',
        }
      },
      chartArea: {
        backgroundColor: '#FFFFFF'
      }
    }

  });

  var dataAnneechiffre = {
    datasets: [
      {
        label: ["Chiffre d'affaire (€)"],
        data: dataTabchiffre,
        backgroundColor: '#2278dd'
     }
  ],
    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: labelTabchiffre
  };

  $("#affichageanneechiffre").on("click", function() {
    $("#indexdetailchiffre").hide();
    var id_proprietaire = $("#proprietairechoisichiffre").val();
    $.ajax({
      type: "GET",
      async: false,
      dataType: 'json',
      url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/dataanneetatisoccupationpropchiffre/"+id_proprietaire,
      success:function(xml){
        var an = 2011;
        dataTabMoisAnneechiffre = [];
        while (typeof(xml.nbrInscrAnAnneechiffre[an])!="undefined") {
          dataTabMoisAnneechiffre.push(xml.nbrInscrAnAnneechiffre[an]);
          an++;
        }

        dataAnneeANchiffre = {
          datasets: [
            {
              label: ["Chiffre d'affaire (€)"],
              data: dataTabMoisAnneechiffre,
              backgroundColor: '#2278dd'
           }
        ],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: labelTabchiffre
        };

        title =  {
           display: true,
           padding: 0,
           text: 'PROPRIETAIRE : ' + $("#proprietairechoisichiffre").children(':selected').text() + ' / DATE : ' + moment().format('LL'),
         };

        }
      });
    chartannonceinscchiffre.data = dataAnneeANchiffre;
    chartannonceinscchiffre.options.title = title;
    chartannonceinscchiffre.update();
  });

  var dataTabMoischiffre = [];
  var colorTabMoischiffre = [];
  var dataMoischiffre;
  $("#affichagemoischiffre").on("click", function() {
    $("#indexdetailchiffre").hide();
    var id = $("#anneechoisiechiffre").val();
    var id_proprietaire = $("#proprietairechoisichiffre").val();
    $.ajax({
      type: "GET",
      async: false,
      dataType: 'json',
      url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datamoisstatisoccupationpropchiffre/"+id+"/"+id_proprietaire,
      success:function(xml){
        var an = 0;
        dataTabMoischiffre = [];
        colorTabMoischiffre = [];
        while (an <= 12) {
          dataTabMoischiffre.push(xml.nbrInscrAnMoischiffre[an]);
          colorTabMoischiffre.push('#ff530d');
          an++;
        }

        dataMoischiffre = {
          datasets: [
            {
              label: ["Chiffre d'affaire (€)"],
              data: dataTabMoischiffre,
              backgroundColor: colorTabMoischiffre
           }
        ],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: ["Sep "+(id-1), "Oct "+(id-1), "Nov "+(id-1), "Déc "+(id-1), "Jan "+id, "Fev "+id, "Mar "+id, "Avr "+id, "Mai "+id, "Jun "+id, "Jul "+id, "Aoû "+id]
        };

        title =  {
           display: true,
           padding: 0,
           text: 'PROPRIETAIRE : ' + $("#proprietairechoisichiffre").children(':selected').text() + ' / ANNEE : ' + $("#anneechoisiechiffre").children(':selected').text() + ' / DATE : ' + moment().format('LL'),
         };

        }
      });
      chartannonceinscchiffre.data = dataMoischiffre;
      chartannonceinscchiffre.options.title = title;
      chartannonceinscchiffre.update();

  });

  $("#semaineremplissagechiffre").on("click", function() {
    var id_proprietaire = $("#proprietairechoisichiffre").val();
    $.ajax({
      type: "POST",
      async: false,
      dataType: 'json',
      url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datasemaineremplissagestatispropchiffre/"+id_proprietaire,
      data: {liste: $('#saisonremplissagechiffre').val()},
      success:function(xml){
        var an = 1;
        dataTabSemainechiffre = [];
        colorTabSemainechiffre = [];
        listeStatSemainechiffreLabelchiffre = [];
        while (typeof(xml.listeStatSemainechiffre[an])!="undefined") {
          dataTabSemainechiffre.push(xml.listeStatSemainechiffre[an]);
          colorTabSemainechiffre.push('#f8b006');
          listeStatSemainechiffreLabelchiffre.push(xml.listeStatSemainechiffreLabelchiffre[an]);
          an++;
        }
        dataSemainechiffre = {
          datasets: [
            {
              label: "Chiffre d'affaire",
              data: dataTabSemainechiffre,
              backgroundColor: '#e8af48'
            }
        ],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: listeStatSemainechiffreLabelchiffre
        };
        $("#indexdetailchiffre").show();
        $("#indexdetailchiffre").html(xml.nbrInscrLabelindexchiffre);

        title =  {
           display: true,
           padding: 0,
           text: 'PROPRIETAIRE : ' + $("#proprietairechoisichiffre").children(':selected').text() + ' / DATE : ' + moment().format('LL'),
         };

      }
    });
      chartannonceinscchiffre.data = dataSemainechiffre;
      chartannonceinscchiffre.options.title = title;
      chartannonceinscchiffre.update();
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

<!-- select2 CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>
<!-- bootstrap-select CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css", array('block' => 'cssTop')); ?>