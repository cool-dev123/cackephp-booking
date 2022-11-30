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
  span.select2-selection.select2-selection--multiple {
    height: auto;
  }
  hr {
    border-color: #999 !important;
    margin-top: 30px !important;
  }
  footer {
    z-index: -99999;
  }
</style>
<?php $this->end(); ?>
<?php echo $this->element('menustatistiques'); ?>

<div class="row">
    <div class="col-sm-12">
	<div class="panel panel-default card-view pb-0">
            <div class="panel-heading icantSelectIt">
                <div class="pull-left mt-10">
                    <h6 class="panel-title txt-dark">Statistiques Taux de remplissage</h6>
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
                                                <form>
                                                    <?php if($InfoGes['G']['role']=='admin'){ ?>
                                                      <div class="form-group">
                                                        <label class="control-label mb-10 text-left">Gestionnaires</label>
                                                        <?= $this->Form->select('gestionnaires[]',$gestionnaires,['multiple','id'=>'gestionnaires','label'=>false,'class'=>'select2 select2-multiple']);  ?>
                                                      </div>
                                                      <hr>
                                                    <?php } ?>
                                                    <?php if($InfoGes['G']['role']=='admin'){ ?>
                                                        <div class="form-group">
                                                            <label class="control-label mb-10 text-left" for="example-email">Station</label>
                                                            <select  name="station" id="stationchoisi" class="form-control" onchange="get_village(this.value)">
                                                                <option value="tous">Tous</option>
                                                                <?php foreach ($listStat as $value) { ?>
                                                                  <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>                                                                
                                                    <?php }else{ ?>
                                                      <div class="form-group">
                                                            <label class="control-label mb-10 text-left" for="example-email">Station</label>
                                                            <select  name="station" id="stationchoisi" class="form-control" readonly disabled>
                                                                <option value="tous">Tous</option>
                                                                <?php foreach ($listStat as $value) { ?>
                                                                  <option value="<?php echo $value->id ?>" <?php if($value->id == $vilstat) echo "selected"; ?>><?php echo $value->name ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>  
                                                    <?php } ?>
                                                    <div class="form-group">
                                                            <label class="control-label mb-10 text-left" for="example-email">Village</label>
                                                            <select  name="village" id="villagechoisi" class="form-control">
                                                                <option value="tous">Tous</option>
                                                                <?php foreach ($listevillageann as $value) { ?>
                                                                  <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                                                <?php } ?>
                                                            </select>
                                                    </div>
                                                    <!-- <div class="form-group">
                                                        <button type="button" id="affichageannee" class="btn  btn-primary btn-spec">Affichage par années</button>
                                                    </div> -->
                                                    <!-- <div class="form-group">
                                                            <label class="control-label mb-10 text-left" for="example-email">Choisir une année</label>
                                                            <select class="form-control" id="anneechoisie">
                                                                <?php $annee=2011;  while ($annee <= $year2){
                                                                    ?>
                                                                    <option value="<?php echo $annee ?>"><?php echo ($annee-1)." - ".$annee ?></option>
                                                                    <?php
                                                                    $annee++;
                                                                }; ?>
                                                            </select>
                                                    </div> -->
                                                    <!-- <div class="form-group">
                                                        <button type="button" id="affichagemois" class="btn  btn-orange btn-spec">Affichage par mois</button>
                                                    </div> -->
                                                    <!-- <div class="form-group">
                                                        <label class="control-label mb-10 text-left">Choisir Un mois</label>
                                                        <select class="form-control" name="moischoisie" id="moischoisie">
                                                            <option value="9">Septembre</option>
                                                            <option value="10">Octobre</option>
                                                            <option value="11">Novembre</option>
                                                            <option value="12">Décembre</option>
                                                            <option value="1">Janvier</option>
                                                            <option value="2">Fevrier</option>
                                                            <option value="3">Mars</option>
                                                            <option value="4">Avril</option>
                                                            <option value="5">Mai</option>
                                                            <option value="6">Juin</option>
                                                            <option value="7">Juillet</option>
                                                            <option value="8">Août</option>
                                                        </select>
                                                    </div> -->
                                                    <div class="form-group">
                                                      <span class="costum_span">Du :</span>
                                                      <input class="form-control date" type="text" id="from_date" value="<?php echo date('d-m-Y')?>" />
                                                      <span class="costum_span">Au :</span>
                                                      <input class="form-control date" type="text" id="to_date" value="<?php echo date('d-m-Y', strtotime('+1 days'))?>" />
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

                    <!--- TABLEAU --->
                    <div class="panel panel-inverse card-view">
                            <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="col-sm-12 row-eq-height">
                                            <div class="col-sm-12">
                                              <table class="table table-bordered">
                                                <thead>
                                                  <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col">Gérés</th>
                                                    <th scope="col">Non gérés</th>
                                                    <th scope="col">Totaux</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <th scope="row">Nombre de lits</th>
                                                    <td id="nbreservtableau"><?php echo $nbreservtableau['total'] ?></td>
                                                    <td id="nbreservtableauNon"><?php echo $nbreservtableauNon['total'] ?></td>
                                                    <td id="totalnbreservtableau"><?php echo $nbreservtableau['total']+$nbreservtableauNon['total'] ?></td>
                                                  </tr>
                                                  <tr>
                                                    <th scope="row">Nombre de lits occupés</th>
                                                    <td id="nbrInscrAntableau"><?php echo $nbrInscrAntableau['total'] ?></td>
                                                    <td id="nbrInscrAntableauNon"><?php echo $nbrInscrAntableauNon['total'] ?></td>
                                                    <td id="totalnbrInscrAntableau"><?php echo $nbrInscrAntableau['total']+$nbrInscrAntableauNon['total'] ?></td>
                                                  </tr>                                                               
                                                  <tr>
                                                    <th scope="row">Pourcentage de remplissage</th>
                                                    <td id="pournbrInscrAntableau"><?php echo round(($nbrInscrAntableau['total']*100/$nbreservtableau['total']), 2)." %"; ?></td>
                                                    <td id="pournbrInscrAntableauNon"><?php echo round(($nbrInscrAntableauNon['total']*100/$nbreservtableauNon['total']), 2)." %"; ?></td>
                                                    <td id="pourtotal"><?php echo round((($nbrInscrAntableau['total']+$nbrInscrAntableauNon['total'])*100/($nbreservtableau['total']+$nbreservtableauNon['total'])),2)." %"; ?></td>
                                                  </tr>                                                                                                                           
                                                </tbody>
                                              </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!--- END TABLEAU --->
                    
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

<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$(".select2").select2();
/*$('.select2').on('change', function (e) {
  // Do something
  if($(".select2").find(':selected').length > 0){
    $("#stationchoisi").val("tous");
    $("#stationchoisi").prop('disabled', true);
    // $("#villagechoisi").val("tous");    
    $("#villagechoisi").val($("#villagechoisi option:first").val());
    $("#villagechoisi").prop('disabled', true);
  }else{
    $("#stationchoisi").prop('disabled', false);
    $("#villagechoisi").prop('disabled', false);
  }
});*/

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
      icons: {
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
    },
  });
});

// if($("#stationchoisi").val() != 0) get_village($("#stationchoisi").val());
function get_village(id){
  if(id!='')
    {
      $('#villagechoisi').empty().prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Url->build('/',true)?>manager/village/getStationVillagesWithAnnonces/"+id,
            dataType : 'json',
            success:function(data){
              valvillage = 0;
              <?php if(isset($this->request->query['village'])){ ?>
                valvillage = <?php echo $this->request->query['village']; ?>;
              <?php } ?>
              $('#villagechoisi').append('<option value="0"><?= __("Tous les villages") ?></option>');
              $.each(data,function(i,val){
                if(valvillage == val.id) selectedval = "selected";
                else selectedval = "";
                $('#villagechoisi').append('<option value=' + val.id + ' ' + selectedval + '>' + val.name + '</option>');
              })
            },
            complete:function(){
              $('#villagechoisi').prop('disabled', false).trigger('change');
            }
        });
    }
}
 
/***** Taux remplissage  *****/
<?php //print_r($nbreserv); ?>
    <?php $annee=2011;   while ($annee <= $year2){ if($nbreserv[$annee] == 0) $data[] = 0; else $data[] = round($nbrInscrAn[$annee]*100/$nbreserv[$annee], 2); $label[] = ($annee-1)." - ".$annee; $annee++; $color[] = '#3299fe';}; ?>
    <?php //print_r($data); ?>
    /*var dataTab = <?php echo json_encode($data) ?>;
    var colorTab = <?php echo json_encode($color) ?>;
    var labelTab = <?php echo json_encode($label) ?>;*/
    if(typeof id_village == "undefined") chaine = 'DATE : ' + moment().format('LL');
    else 'VILLAGE : ' + $("#villagechoisi").children(':selected').text() + ' / DATE : ' + moment().format('LL');
    var ctxannonceinsc = document.getElementById('occupation').getContext('2d');
    var chartannonceinsc = new Chart(ctxannonceinsc, {
      type: 'bar',
      /*data:{
        datasets: [
          {
           label: ["Taux d'occupation"],
           data: dataTab,
           backgroundColor: '#2278dd'
         }
      ],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: labelTab
      },*/
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

    /*var dataAnnee = {
      datasets: [
        {
          label: ["Taux d'occupation"],
          data: dataTab,
          backgroundColor: '#2278dd'
       }
      ],
      // These labels appear in the legend and in the tooltips when hovering different arcs
      labels: labelTab
    };*/

    var id_station = $("#stationchoisi").val();
      if(typeof id_station == "undefined") id_station="tous";
      var id_village = $("#villagechoisi").val();
      if(typeof id_village == "undefined") id_village="tous";
      var gestionnaireliste = $("#gestionnaires").val();
      if(gestionnaireliste == null) gestionnaireliste = "tous";
      var id = $("#from_date").val();
      var id_mois = $("#to_date").val();
      
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datasemaineremplissagenew/"+id_station+"/"+id_village+"/"+id+"/"+id_mois,
        data: {gestionnairesvar : JSON.stringify(gestionnaireliste)},
        success:function(xml){
          if(gestionnaireliste == "tous"){
            var an = 0;
            dataTabMois = [];
            colorTabMois = [];
            labelTabMois = [];
            // console.log(xml.nbrInscrAnSemaine);
            while (typeof(xml.nbrInscrAnSemaine[an])!="undefined") {              
              if(xml.nbreserv[an] == 0) dataTabMois.push(0);
              else dataTabMois.push((xml.nbrInscrAnSemaine[an]*100/xml.nbreserv[an]).toFixed(2));
              colorTabMois.push('#f8b006');
              labelTabMois.push(xml.labelsemaine[an]);
              an++;
            }

            dataMois = {
              datasets: [
                {
                  label: ["Réservations / Semaine"],
                  data: dataTabMois,
                  backgroundColor: '#f8b006'
              }
            ],
              // These labels appear in the legend and in the tooltips when hovering different arcs
              labels: labelTabMois
            };

            title =  {
              display: true,
              padding: 0,
              text: 'ANNEE : ' + $("#anneechoisie").children(':selected').text() + ' / MOIS : ' + $("#moischoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL'),
            };
          }else{
            datasetvar = [];
            datacolortab = ['#2278dd', '#ff530d', '#ffb400','#0a1e32','#fe3355', '#D48E90','#AB4F93','#54B0CB','#D0332F','#22A078','#CFD6DD']
            var dataTabgest = <?php echo json_encode($gestionnaires) ?>;
            var counter = 0;
            gestionnaireliste.forEach(function(item){
              var an = 0;
              dataTabMois[item] = [];
              labelTabMois = [];
              // console.log(xml.nbrInscrAnSemaine);
              // console.log(xml.nbrInscrAnSemaine[item]);
              while (typeof(xml.nbrInscrAnSemaine[item][an])!="undefined") {
                if(xml.nbreserv[item][an] == 0) dataTabMois[item].push(0);
                else dataTabMois[item].push((xml.nbrInscrAnSemaine[item][an]*100/xml.nbreserv[item][an]).toFixed(2));
                labelTabMois.push(xml.labelsemaine[item][an]);
                an++;
              }
              datasetvar.push({
                label: [dataTabgest[item]],
                data: dataTabMois[item],
                backgroundColor: datacolortab[counter]
              });
              counter++;
            });

            dataMois = {
              datasets: datasetvar,
              // These labels appear in the legend and in the tooltips when hovering different arcs
              labels: labelTabMois
            };

            title =  {
              display: true,
              padding: 0,
              text: 'ANNEE : ' + $("#anneechoisie").children(':selected').text() + ' / MOIS : ' + $("#moischoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL'),
            };
          }


          if(!xml.nbrInscrAntableauNon.total) xml.nbrInscrAntableauNon.total = 0;
          if(!xml.nbreservtableauNon.total) xml.nbreservtableauNon.total = 0;
          if(!xml.nbrInscrAntableau.total) xml.nbrInscrAntableau.total = 0;
          if(!xml.nbreservtableau.total) xml.nbreservtableau.total = 0;

          $("#nbrInscrAntableau").html("Inventaire (Lits occupés * nuitées d'occupation) : "+xml.nbrInscrAntableau.total+"<br><br> Nbr lits : "+xml.nbrInscrAntableau.nbrpersans);
          $("#nbreservtableau").html("Inventaire (Lits * nuitées) : "+xml.nbreservtableau.total+"<br><br> Nbr lits : "+xml.nbreservtableau.nbrpersans+"<br> Nbr jours : "+xml.nbreservtableau.nbrday);
          $("#nbrInscrAntableauNon").html("Inventaire (Lits occupés * nuitées d'occupation) : "+xml.nbrInscrAntableauNon.total+"<br><br> Nbr lits : "+xml.nbrInscrAntableauNon.nbrpersans);
          $("#nbreservtableauNon").html("Inventaire (Lits * nuitées) : "+xml.nbreservtableauNon.total+"<br><br> Nbr lits : "+xml.nbreservtableauNon.nbrpersans+"<br> Nbr jours : "+xml.nbreservtableauNon.nbrday);

          var totalnbreservtableau = parseInt(xml.nbreservtableau.total)+parseInt(xml.nbreservtableauNon.total);
          $("#totalnbreservtableau").html(totalnbreservtableau);
          var totalnbrInscrAntableau = parseInt(xml.nbrInscrAntableau.total)+parseInt(xml.nbrInscrAntableauNon.total);
          $("#totalnbrInscrAntableau").html(totalnbrInscrAntableau);

          var pournbrInscrAntableau;
          if(xml.nbrInscrAntableau.total == 0 || xml.nbreservtableau.total == 0) pournbrInscrAntableau = 0;
          else pournbrInscrAntableau = (parseInt(xml.nbrInscrAntableau.total)*100/parseInt(xml.nbreservtableau.total)).toFixed(2);
          $("#pournbrInscrAntableau").html(pournbrInscrAntableau+" %");
          
          var pournbrInscrAntableauNon;
          if(xml.nbrInscrAntableauNon.total == 0 || xml.nbreservtableauNon.total == 0) pournbrInscrAntableauNon = 0;
          else pournbrInscrAntableauNon = (parseInt(xml.nbrInscrAntableauNon.total)*100/parseInt(xml.nbreservtableauNon.total)).toFixed(2);

          $("#pournbrInscrAntableauNon").html(pournbrInscrAntableauNon+" %");
          var pourtotal = (parseInt(totalnbrInscrAntableau)*100/parseInt(totalnbreservtableau)).toFixed(2);
          $("#pourtotal").html(pourtotal+" %");

        }
      });
      chartannonceinsc.data = dataMois;
      chartannonceinsc.options.title = title;
      chartannonceinsc.update();




    $("#affichageannee").on("click", function() {
      $("#indexdetail").hide();
      var id_station = $("#stationchoisi").val();
      if(typeof id_station == "undefined") id_station="tous";

      var id_village = $("#villagechoisi").val();
      if(typeof id_village == "undefined") id_village="tous";

      var gestionnaireliste = $("#gestionnaires").val();
      if(gestionnaireliste == null) gestionnaireliste = "tous";
      // console.log(gestionnaireliste);
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/dataanneetatisremplissage/"+id_station+"/"+id_village,
        data: {gestionnairesvar : JSON.stringify(gestionnaireliste)},
        success:function(xml){
          // console.log(xml.nbrInscrAn);
          dataTabMoisAnnee = [];
          if(gestionnaireliste == "tous"){
            var an = 2011;
            
            while (typeof(xml.nbrInscrAn[an])!="undefined") {
              if(xml.nbreserv[an] == 0) dataTabMoisAnnee.push(0);
              else dataTabMoisAnnee.push((xml.nbrInscrAn[an]*100/xml.nbreserv[an]).toFixed(2));
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

          }else{
            datasetvar = [];
            datacolortab = ['#2278dd', '#ff530d', '#ffb400','#0a1e32','#fe3355', '#D48E90','#AB4F93','#54B0CB','#D0332F','#22A078','#CFD6DD']
            var dataTabgest = <?php echo json_encode($gestionnaires) ?>;
            var counter = 0;
            gestionnaireliste.forEach(function(item){
              var an = 2011;
              dataTabMoisAnnee[item] = [];
              while (typeof(xml.nbrInscrAn[item][an])!="undefined") {
                if(xml.nbreserv[item][an] == 0) dataTabMoisAnnee[item].push(0);
                else dataTabMoisAnnee[item].push((xml.nbrInscrAn[item][an]*100/xml.nbreserv[item][an]).toFixed(2));
                an++;
              } 
              datasetvar.push({
                label: [dataTabgest[item]],
                data: dataTabMoisAnnee[item],
                backgroundColor: datacolortab[counter]
              });
              counter++;
            });
            
            dataAnneeAN = {
              datasets: datasetvar,
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
            // console.log(dataTabMoisAnnee);
          }

          if(!xml.nbrInscrAntableauNon) xml.nbrInscrAntableauNon = 0;
          if(!xml.nbreservtableauNon) xml.nbreservtableauNon = 0;
          if(!xml.nbrInscrAntableau) xml.nbrInscrAntableau = 0;
          if(!xml.nbreservtableau) xml.nbreservtableau = 0;

          $("#nbrInscrAntableau").html("Inventaire (Lits occupés * nuitées d'occupation) : "+xml.nbrInscrAntableau.total+"<br><br> Nbr lits : "+xml.nbrInscrAntableau.nbrpersans);
          $("#nbreservtableau").html("Inventaire (Lits * nuitées) : "+xml.nbreservtableau.total+"<br><br> Nbr lits : "+xml.nbreservtableau.nbrpersans+"<br> Nbr jours : "+xml.nbreservtableau.nbrday);
          $("#nbrInscrAntableauNon").html("Inventaire (Lits occupés * nuitées d'occupation) : "+xml.nbrInscrAntableauNon.total+"<br><br> Nbr lits : "+xml.nbrInscrAntableauNon.nbrpersans);
          $("#nbreservtableauNon").html("Inventaire (Lits * nuitées) : "+xml.nbreservtableauNon.total+"<br><br> Nbr lits : "+xml.nbreservtableauNon.nbrpersans+"<br> Nbr jours : "+xml.nbreservtableauNon.nbrday);

          var totalnbreservtableau = parseInt(xml.nbreservtableau.total)+parseInt(xml.nbreservtableauNon.total);
          $("#totalnbreservtableau").html(totalnbreservtableau);
          var totalnbrInscrAntableau = parseInt(xml.nbrInscrAntableau.total)+parseInt(xml.nbrInscrAntableauNon.total);
          $("#totalnbrInscrAntableau").html(totalnbrInscrAntableau);

          var pournbrInscrAntableau;
          if(xml.nbrInscrAntableau.total == 0 || xml.nbreservtableau.total == 0) pournbrInscrAntableau = 0;
          else pournbrInscrAntableau = (parseInt(xml.nbrInscrAntableau.total)*100/parseInt(xml.nbreservtableau.total)).toFixed(2);
          $("#pournbrInscrAntableau").html(pournbrInscrAntableau+" %");
          
          var pournbrInscrAntableauNon;
          if(xml.nbrInscrAntableauNon.total == 0 || xml.nbreservtableauNon.total == 0) pournbrInscrAntableauNon = 0;
          else pournbrInscrAntableauNon = (parseInt(xml.nbrInscrAntableauNon.total)*100/parseInt(xml.nbreservtableauNon.total)).toFixed(2);

          $("#pournbrInscrAntableauNon").html(pournbrInscrAntableauNon+" %");
          var pourtotal = (parseInt(totalnbrInscrAntableau)*100/parseInt(totalnbreservtableau)).toFixed(2);
          $("#pourtotal").html(pourtotal+" %");         

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
      var id_station = $("#stationchoisi").val();
      if(typeof id_station == "undefined") id_station="tous";
      var id_village = $("#villagechoisi").val();
      if(typeof id_village == "undefined") id_village="tous";
      var gestionnaireliste = $("#gestionnaires").val();
      if(gestionnaireliste == null) gestionnaireliste = "tous";
      //console.log(id);
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datamoisstatisremplissage/"+id+"/"+id_station+"/"+id_village,
        data: {gestionnairesvar : JSON.stringify(gestionnaireliste)},
        success:function(xml){
          dataTabMoisAnnee = [];
          if(gestionnaireliste == "tous"){            
            var an = 0;
            dataTabMois = [];
            colorTabMois = [];
            while (an <= 12) {
              if(xml.nbreserv[an] == 0) dataTabMois.push(0);
              else dataTabMois.push((xml.nbrInscrAnMois[an]*100/xml.nbreserv[an]).toFixed(2));
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
          }else{
            datasetvar = [];
            datacolortab = ['#2278dd', '#ff530d', '#ffb400','#0a1e32','#fe3355', '#D48E90','#AB4F93','#54B0CB','#D0332F','#22A078','#CFD6DD']
            var dataTabgest = <?php echo json_encode($gestionnaires) ?>;
            var counter = 0;
            gestionnaireliste.forEach(function(item){
              var an = 0;
              dataTabMois[item] = [];
              while (an <= 12) {
                if(xml.nbreserv[item][an] == 0) dataTabMois[item].push(0);
                else dataTabMois[item].push((xml.nbrInscrAnMois[item][an]*100/xml.nbreserv[item][an]).toFixed(2));
                an++;
              }
              datasetvar.push({
                label: [dataTabgest[item]],
                data: dataTabMois[item],
                backgroundColor: datacolortab[counter]
              });
              counter++;
            });

            dataMois = {
              datasets: datasetvar,
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

          if(!xml.nbrInscrAntableauNon) xml.nbrInscrAntableauNon.total = 0;
          if(!xml.nbreservtableauNon) xml.nbreservtableauNon.total = 0;
          if(!xml.nbrInscrAntableau) xml.nbrInscrAntableau.total = 0;
          if(!xml.nbreservtableau) xml.nbreservtableau.total = 0;

          $("#nbrInscrAntableau").html("Inventaire (Lits occupés * nuitées d'occupation) : "+xml.nbrInscrAntableau.total+"<br><br> Nbr lits : "+xml.nbrInscrAntableau.nbrpersans);
          $("#nbreservtableau").html("Inventaire (Lits * nuitées) : "+xml.nbreservtableau.total+"<br><br> Nbr lits : "+xml.nbreservtableau.nbrpersans+"<br> Nbr jours : "+xml.nbreservtableau.nbrday);
          $("#nbrInscrAntableauNon").html("Inventaire (Lits occupés * nuitées d'occupation) : "+xml.nbrInscrAntableauNon.total+"<br><br> Nbr lits : "+xml.nbrInscrAntableauNon.nbrpersans);
          $("#nbreservtableauNon").html("Inventaire (Lits * nuitées) : "+xml.nbreservtableauNon.total+"<br><br> Nbr lits : "+xml.nbreservtableauNon.nbrpersans+"<br> Nbr jours : "+xml.nbreservtableauNon.nbrday);

          var totalnbreservtableau = parseInt(xml.nbreservtableau.total)+parseInt(xml.nbreservtableauNon.total);
          $("#totalnbreservtableau").html(totalnbreservtableau);
          var totalnbrInscrAntableau = parseInt(xml.nbrInscrAntableau.total)+parseInt(xml.nbrInscrAntableauNon.total);
          $("#totalnbrInscrAntableau").html(totalnbrInscrAntableau);

          var pournbrInscrAntableau;
          if(xml.nbrInscrAntableau.total == 0 || xml.nbreservtableau.total == 0) pournbrInscrAntableau = 0;
          else pournbrInscrAntableau = (parseInt(xml.nbrInscrAntableau.total)*100/parseInt(xml.nbreservtableau.total)).toFixed(2);
          $("#pournbrInscrAntableau").html(pournbrInscrAntableau+" %");
          
          var pournbrInscrAntableauNon;
          if(xml.nbrInscrAntableauNon.total == 0 || xml.nbreservtableauNon.total == 0) pournbrInscrAntableauNon = 0;
          else pournbrInscrAntableauNon = (parseInt(xml.nbrInscrAntableauNon.total)*100/parseInt(xml.nbreservtableauNon.total)).toFixed(2);

          $("#pournbrInscrAntableauNon").html(pournbrInscrAntableauNon+" %");
          var pourtotal = (parseInt(totalnbrInscrAntableau)*100/parseInt(totalnbreservtableau)).toFixed(2);
          $("#pourtotal").html(pourtotal+" %");
        }
      });
      chartannonceinsc.data = dataMois;
      chartannonceinsc.options.title = title;
      chartannonceinsc.update();

    });

    $("#affichagesemaine").on("click", function() {
      var id_station = $("#stationchoisi").val();
      if(typeof id_station == "undefined") id_station="tous";
      var id_village = $("#villagechoisi").val();
      if(typeof id_village == "undefined") id_village="tous";
      var gestionnaireliste = $("#gestionnaires").val();
      if(gestionnaireliste == null) gestionnaireliste = "tous";
      var id = $("#from_date").val();
      var id_mois = $("#to_date").val();
      
      $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datasemaineremplissagenew/"+id_station+"/"+id_village+"/"+id+"/"+id_mois,
        data: {gestionnairesvar : JSON.stringify(gestionnaireliste)},
        success:function(xml){
          if(gestionnaireliste == "tous"){
            var an = 0;
            dataTabMois = [];
            colorTabMois = [];
            labelTabMois = [];
            // console.log(xml.nbrInscrAnSemaine);
            while (typeof(xml.nbrInscrAnSemaine[an])!="undefined") {              
              if(xml.nbreserv[an] == 0) dataTabMois.push(0);
              else dataTabMois.push((xml.nbrInscrAnSemaine[an]*100/xml.nbreserv[an]).toFixed(2));
              colorTabMois.push('#f8b006');
              labelTabMois.push(xml.labelsemaine[an]);
              an++;
            }

            dataMois = {
              datasets: [
                {
                  label: ["Réservations / Semaine"],
                  data: dataTabMois,
                  backgroundColor: '#f8b006'
              }
            ],
              // These labels appear in the legend and in the tooltips when hovering different arcs
              labels: labelTabMois
            };

            title =  {
              display: true,
              padding: 0,
              text: 'ANNEE : ' + $("#anneechoisie").children(':selected').text() + ' / MOIS : ' + $("#moischoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL'),
            };
          }else{
            datasetvar = [];
            datacolortab = ['#2278dd', '#ff530d', '#ffb400','#0a1e32','#fe3355', '#D48E90','#AB4F93','#54B0CB','#D0332F','#22A078','#CFD6DD']
            var dataTabgest = <?php echo json_encode($gestionnaires) ?>;
            var counter = 0;
            gestionnaireliste.forEach(function(item){
              var an = 0;
              dataTabMois[item] = [];
              labelTabMois = [];
              // console.log(xml.nbrInscrAnSemaine);
              // console.log(xml.nbrInscrAnSemaine[item]);
              while (typeof(xml.nbrInscrAnSemaine[item][an])!="undefined") {
                if(xml.nbreserv[item][an] == 0) dataTabMois[item].push(0);
                else dataTabMois[item].push((xml.nbrInscrAnSemaine[item][an]*100/xml.nbreserv[item][an]).toFixed(2));
                labelTabMois.push(xml.labelsemaine[item][an]);
                an++;
              }
              datasetvar.push({
                label: [dataTabgest[item]],
                data: dataTabMois[item],
                backgroundColor: datacolortab[counter]
              });
              counter++;
            });

            dataMois = {
              datasets: datasetvar,
              // These labels appear in the legend and in the tooltips when hovering different arcs
              labels: labelTabMois
            };

            title =  {
              display: true,
              padding: 0,
              text: 'ANNEE : ' + $("#anneechoisie").children(':selected').text() + ' / MOIS : ' + $("#moischoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL'),
            };
          }


          if(!xml.nbrInscrAntableauNon) xml.nbrInscrAntableauNon.total = 0;
          if(!xml.nbreservtableauNon) xml.nbreservtableauNon.total = 0;
          if(!xml.nbrInscrAntableau) xml.nbrInscrAntableau.total = 0;
          if(!xml.nbreservtableau) xml.nbreservtableau.total = 0;

          $("#nbrInscrAntableau").html("Inventaire (Lits occupés * nuitées d'occupation) : "+xml.nbrInscrAntableau.total+"<br><br> Nbr lits : "+xml.nbrInscrAntableau.nbrpersans);
          $("#nbreservtableau").html("Inventaire (Lits * nuitées) : "+xml.nbreservtableau.total+"<br><br> Nbr lits : "+xml.nbreservtableau.nbrpersans+"<br> Nbr jours : "+xml.nbreservtableau.nbrday);
          $("#nbrInscrAntableauNon").html("Inventaire (Lits occupés * nuitées d'occupation) : "+xml.nbrInscrAntableauNon.total+"<br><br> Nbr lits : "+xml.nbrInscrAntableauNon.nbrpersans);
          $("#nbreservtableauNon").html("Inventaire (Lits * nuitées) : "+xml.nbreservtableauNon.total+"<br><br> Nbr lits : "+xml.nbreservtableauNon.nbrpersans+"<br> Nbr jours : "+xml.nbreservtableauNon.nbrday);

          var totalnbreservtableau = parseInt(xml.nbreservtableau.total)+parseInt(xml.nbreservtableauNon.total);
          $("#totalnbreservtableau").html(totalnbreservtableau);
          var totalnbrInscrAntableau = parseInt(xml.nbrInscrAntableau.total)+parseInt(xml.nbrInscrAntableauNon.total);
          $("#totalnbrInscrAntableau").html(totalnbrInscrAntableau);

          var pournbrInscrAntableau;
          if(xml.nbrInscrAntableau.total == 0 || xml.nbreservtableau.total == 0) pournbrInscrAntableau = 0;
          else pournbrInscrAntableau = (parseInt(xml.nbrInscrAntableau.total)*100/parseInt(xml.nbreservtableau.total)).toFixed(2);
          $("#pournbrInscrAntableau").html(pournbrInscrAntableau+" %");
          
          var pournbrInscrAntableauNon;
          if(xml.nbrInscrAntableauNon.total == 0 || xml.nbreservtableauNon.total == 0) pournbrInscrAntableauNon = 0;
          else pournbrInscrAntableauNon = (parseInt(xml.nbrInscrAntableauNon.total)*100/parseInt(xml.nbreservtableauNon.total)).toFixed(2);

          $("#pournbrInscrAntableauNon").html(pournbrInscrAntableauNon+" %");
          var pourtotal = (parseInt(totalnbrInscrAntableau)*100/parseInt(totalnbreservtableau)).toFixed(2);
          $("#pourtotal").html(pourtotal+" %");

        }
      });
      chartannonceinsc.data = dataMois;
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
        
<?php $this->Html->scriptEnd(); ?>

<!-- Bootstrap Datetimepicker CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css", array('block' => 'cssTop')); ?>

<!-- bootstrap-select CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css", array('block' => 'cssTop')); ?>