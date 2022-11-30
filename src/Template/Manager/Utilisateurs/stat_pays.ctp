<?php $month = date("n");
    if ($month<9){
        $year2= date("Y");
        $yearinit= date("Y");
    }
    else{
        $year2 = date("Y")+1;
        $yearinit= date("Y")+1;
    } ?>
<?php $this->start('cssTop'); ?>
<style>
    .exportButton{
        z-index: 2;
    }
    @media screen and (min-width: 768px)  {
        .row-eq-height {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display:         flex;
        }
        .chartDiv{
            height: 800px;
        }
        .chartDiv2{
            height: 900px;
        }
        .vcenter{
          display:flex;
          flex-direction:column;
          justify-content:center;
        }
    }
    @media screen and (max-width: 767px)  {
        .chartDiv{
            height: 600px;
        }
        .chartDiv2{
            height: 900px;
        }
    }
</style>
<?php $this->end(); ?>

<?php echo $this->element('menustatistiques'); ?>

<div class="row">
    <div class="col-sm-12">
	<div class="panel panel-default card-view pb-0">
            <div class="panel-wrapper collapse in">
		<div class="panel-body pb-0">
                    <!--- par pays --->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Étrangers</h6>
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
                                                        <label class="control-label mb-10 text-left" for="example-email">Choisir une année</label>
                                                        <select class="form-control" name="anneechoisie" id="anneechoisie">
                                                            <option value="All">Tous : 2017 - <?=$year2?></option>
                                                            <?php $annee=2018; $year=$year2; $i=1;  while ($annee <= $year):
                                                                ?>
                                                                <option <?=$i++==1?'selected':''?> value="<?= $year ?>"><?= ($year-1)." - ".$year ?></option>
                                                                <?php
                                                                $year--;
                                                            endwhile; ?>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" id="affichageannee" class="btn  btn-primary btn-spec">Affichage par années</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!--end Form-->
                                        <div class="col-sm-9">
                                            <button onclick="exportImage(eChart_2,'Populations Par Pays Étrangers')" class="btn btn-primary btn-anim pull-right exportButton"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <div id="pays" class="chartDiv"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- end par pays --->
                    <!--- par departement --->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Français</h6>
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
                                                        <label class="control-label mb-10 text-left" for="example-email">Choisir une année</label>
                                                        <select class="form-control" name="anneechoisie2" id="anneechoisie2">
                                                            <option value="All">Tous : 2018 - <?=$year2?></option>
                                                            <?php $year=$year2; $annee=2019; $i=1;  while ($annee <= $year):
                                                                ?>
                                                                <option <?=$i++==1?'selected':''?> value="<?= $year ?>"><?= ($year-1)." - ".$year ?></option>
                                                                <?php
                                                                $year--;
                                                            endwhile; ?>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" id="affichageannee2" class="btn  btn-primary btn-spec">Affichage par années</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!--end Form-->
                                        <div class="col-sm-9">
                                            <button onclick="exportImage(eChart_1,'Populations Par Département')" class="btn btn-primary btn-anim pull-right exportButton"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <!--<canvas class="chart_for_mobile" id="regions" style="height: 100%" ></canvas>-->
                                            <div id="depart" class="chartDiv2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- end par departement --->
                    <!--- par region --->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Région</h6>
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
                                                        <label class="control-label mb-10 text-left" for="example-email">Choisir une année</label>
                                                        <select class="form-control" name="anneechoisie3" id="anneechoisie3">
                                                            <option value="All">Tous : 2018 - <?=$year2?></option>
                                                            <?php $year=$year2; $annee=2019; $i=1;  while ($annee <= $year):
                                                                ?>
                                                                <option <?=$i++==1?'selected':''?> value="<?= $year ?>"><?= ($year-1)." - ".$year ?></option>
                                                                <?php
                                                                $year--;
                                                            endwhile; ?>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" id="affichageannee3" class="btn btn-primary btn-spec">Affichage par années</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!--end Form-->
                                        <div class="col-sm-9">
                                            <button onclick="exportImage(eChart_3,'Populations Par Region')" class="btn btn-primary btn-anim pull-right exportButton"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <!--<canvas class="chart_for_mobile" id="regions" style="height: 100%" ></canvas>-->
                                            <div id="regions" class="chartDiv2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- end par region --->
                    <!--- par zone --->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-inverse card-view">
                                <div class="panel-heading icantSelectIt">
                                    <div class="pull-left">
                                            <h6 class="panel-title">Zone</h6>
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
                                                        <label class="control-label mb-10 text-left" for="example-email">Choisir une année</label>
                                                        <select class="form-control" name="anneechoisie4" id="anneechoisie4">
                                                            <option value="All">Tous : 2018 - <?=$year2?></option>
                                                            <?php $year=$year2; $annee=2019; $i=1;  while ($annee <= $year):
                                                                ?>
                                                                <option <?=$i++==1?'selected':''?> value="<?= $year ?>"><?= ($year-1)." - ".$year ?></option>
                                                                <?php
                                                                $year--;
                                                            endwhile; ?>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" id="affichageannee4" class="btn btn-primary btn-spec">Affichage par années</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!--end Form-->
                                        <div class="col-sm-9">
                                            <button onclick="exportImage(eChart_4,'Populations Par Zone')" class="btn btn-primary btn-anim pull-right exportButton"><i class="fa fa-file"></i><span class="btn-text">Export</span></button>
                                            <!--<canvas class="chart_for_mobile" id="regions" style="height: 100%" ></canvas>-->
                                            <div id="zones" class="chartDiv2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- end par zone --->
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/js/chart.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/js/chartjs-plugin-datalabels.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/echarts/dist/echarts-en.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
if( $('#depart').length > 0 ){
    var eChart_1 = echarts.init(document.getElementById('depart'));
    getpopulationregion($('#anneechoisie2').val())
}

if( $('#pays').length > 0 ){
    var eChart_2 = echarts.init(document.getElementById('pays'));
    getpopulation($('#anneechoisie').val())
}

if( $('#regions').length > 0 ){
    var eChart_3 = echarts.init(document.getElementById('regions'));
    getpopulationGrandregion($('#anneechoisie3').val())
}

if( $('#zones').length > 0 ){
    var eChart_4 = echarts.init(document.getElementById('zones'));
    getpopulationzone($('#anneechoisie4').val())
}

$('#affichageannee').click(function(){
    getpopulation($('#anneechoisie').val())
});

$('#affichageannee2').click(function(){
    getpopulationregion($('#anneechoisie2').val())
});
$('#affichageannee3').click(function(){
    getpopulationGrandregion($('#anneechoisie3').val())
});
$('#affichageannee4').click(function(){
    getpopulationzone($('#anneechoisie4').val())
});
$( document ).ready(function() {
    getpopulationregion($('#anneechoisie2').val())
    getpopulation($('#anneechoisie').val())
    getpopulationGrandregion($('#anneechoisie3').val())
    getpopulationzone($('#anneechoisie4').val())
});

function getpopulationregion(anne){
    titrestat = '';
    if(anne == 'All') titrestat = "2018 - <?=$yearinit?>";
    else titrestat = (anne-1)+' - '+anne;
    
    $.ajax({
        type: "GET",
        async: true,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/utilisateurs/populationfrancais/"+anne,
        success:function(res){
            var labels=[];
            var data=[];
            var tot=0;
            res.totalFrance.forEach(function(element) {
                var name=element.D.name.toLowerCase().charAt(0).toUpperCase() + element.D.name.toLowerCase().slice(1);
                labels.push(name);
                data.push({name: name, value: element.total});
                tot+=element.total;
            });
            data.sort(desc);
            labels.push('Autres');
            data.push({name: "Autres", value: res.franceStats-tot});
            option = {
                color:['#55efc4','#00b894', '#81ecec', '#00cec9', '#74b9ff','#0984e3','#a29bfe','#6c5ce7','#ffeaa7','#fdcb6e','#fab1a0', '#e17055', '#ff7675', '#d63031', '#fd79a8', '#e84393', '#dfe6e9', '#b2bec3', '#636e72', '#2d3436'],
                title : {
                    text: 'Populations Par Départements '+titrestat,
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{b} : {d}%"
                },
                legend: {
                    selectedMode: false,
                    type: 'plain',
                    orient: 'horizontal',
                    top: 40,
                    bottom: 40,
                    data: labels,
                },
                series : [
                    {
                        type: 'pie',
                        radius : '65%',
                        center: ['50%', '60%'],
                        data: data,
                        itemStyle: {
                            normal : {
                                label: {
                                    formatter: '{b} : {d}%'
                                },
                            },
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ],
            };
            eChart_1.setOption(option,true);
            eChart_1.resize();
        }
    });
}

function getpopulationGrandregion(anne){
    titrestat = '';
    if(anne == 'All') titrestat = "2018 - <?=$yearinit?>";
    else titrestat = (anne-1)+' - '+anne;
    
    $.ajax({
        type: "GET",
        async: true,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/utilisateurs/populationparregion/"+anne,
        success:function(res){
            var labels=[];
            var data=[];
            var tot=0;
            res.forEach(function(element) {
                var name=element.R.name.toLowerCase().charAt(0).toUpperCase() + element.R.name.toLowerCase().slice(1);
                labels.push(name);
                data.push({name: name, value: element.total});
                tot+=element.total;
            });
            data.sort(desc);
            option = {
                color:['#55efc4','#00b894', '#74b9ff','#0984e3','#a29bfe','#6c5ce7','#ffeaa7','#fdcb6e','#fab1a0', '#e17055', '#ff7675', '#d63031', '#fd79a8', '#e84393', '#dfe6e9', '#b2bec3', '#636e72', '#2d3436'],
                title : {
                    text: 'Populations Par Région '+titrestat,
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{b} : {d}%"
                },
                legend: {
                    selectedMode: false,
                    type: 'plain',
                    orient: 'horizontal',
                    top: 40,
                    bottom: 40,
                    data: labels,
                },
                series : [
                    {
                        type: 'pie',
                        radius : '65%',
                        center: ['50%', '60%'],
                        data: data,
                        itemStyle: {
                            normal : {
                                label: {
                                    formatter: '{b} : {d}%'
                                },
                            },
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ],
            };
            eChart_3.setOption(option,true);
            eChart_3.resize();
        }
    });
}

function getpopulationzone(anne){
    titrestat = '';
    if(anne == 'All') titrestat = "2018 - <?=$yearinit?>";
    else titrestat = (anne-1)+' - '+anne;
    
    $.ajax({
        type: "GET",
        async: true,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/utilisateurs/populationparzone/"+anne,
        success:function(res){
            var labels=[];
            var data=[];
            var tot=0;
            res.forEach(function(element) {
                var name=element.zone
                labels.push(name);
                data.push({name: name, value: element.total});
                tot+=element.total;
            });
            data.sort(desc);
            option = {
                color:['#0a1e32','#fe3355', '#2278dd', '#ff530d', '#ffb400','#D48E90','#AB4F93','#54B0CB','#D0332F','#22A078','#CFD6DD'],
                title : {
                    text: 'Populations Par Zone '+titrestat,
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{b} : {d}%"
                },
                legend: {
                    selectedMode: false,
                    type: 'plain',
                    orient: 'horizontal',
                    top: 40,
                    bottom: 40,
                    data: labels,
                },
                series : [
                    {
                        type: 'pie',
                        radius : '65%',
                        center: ['50%', '60%'],
                        data: data,
                        itemStyle: {
                            normal : {
                                label: {
                                    formatter: '{b} : {d}%'
                                },
                            },
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ],
            };
            eChart_4.setOption(option,true);
            eChart_4.resize();
        }
    });
}

function desc(a,b) {
  if (a.value > b.value)
    return -1;
  if (a.value < b.value)
    return 1;
  return 0;
}

function getpopulation(anne){
    titrestat = '';
    if(anne == 'All') titrestat = "2017 - <?=$yearinit?>";
    else titrestat = (anne-1)+' - '+anne;

    $.ajax({
        type: "GET",
        async: false,
        dataType: 'json',
        url: "<?php echo $this->Url->build('/',true)?>manager/utilisateurs/populationetrangers/"+anne,
        success:function(res){
            var labels = [];
            var data= [];
            var tot=0;
            res.paysStats.forEach(function(element) {
                labels.push(element.Country);
                data.push({name: element.Country, value: element.total});
                tot+=element.total;
            });
            data.sort(desc);
            labels.push('Autres');
            data.push({name: "Autres", value: res.total-tot});
                option = {
                    color:['#55efc4','#00b894', '#74b9ff','#0984e3','#a29bfe','#6c5ce7','#ffeaa7','#fdcb6e','#fab1a0', '#e17055', '#ff7675', '#d63031', '#fd79a8', '#e84393', '#dfe6e9', '#b2bec3', '#636e72', '#2d3436'],
                    title : {
                        text: 'Populations Par Pays Étrangers '+titrestat,
                        x:'center'
                    },
                    tooltip : {
                        trigger: 'item',
                        formatter: "{b} : {d}%"
                    },
                    legend: {
                        selectedMode: false,
                        type: 'plain',
                        orient: 'horizontal',
                        top: 40,
                        bottom: 40,
                        data: labels,
                    },
                    series : [
                        {
                            type: 'pie',
                            radius : '65%',
                            center: ['50%', '60%'],
                            data: data,
                            itemStyle: {
                                normal : {
                                    label: {
                                        formatter: '{b} : {d}%'
                                    },
                                },
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }
                    ]
                };
        }
    });
    eChart_2.setOption(option,true);
    eChart_2.resize();
}

/***** Function Export AND Download Image*****/
function exportImage(chart,title) {
    var img = new Image();
    img.src = chart.getDataURL({
        pixelRatio: 2,
        backgroundColor: '#fff'
    });
    downloadURI(img.src, title+'.png');
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

function resize() {
    eChart_1.resize();
    eChart_2.resize();
    eChart_3.resize();
    eChart_4.resize();
  }

  window.onresize = resize;
<?php $this->Html->scriptEnd(); ?>