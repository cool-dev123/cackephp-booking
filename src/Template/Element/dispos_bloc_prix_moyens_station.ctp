<script type="text/javascript" src="<?php echo $this->Url->build('/',true);?>manager-arr/js/chart.js"></script>
<script type="text/javascript" src="<?php echo $this->Url->build('/',true);?>manager-arr/js/chartjs-plugin-datalabels.js"></script>

<?php $this->append('cssTopBlock', '<style>
#prixloyer{
    width: 50%;
}
.affichageannee {
	background: #0780f8;
	color: white;
	/*margin-left: 20%;*/
}
.affichageannee:hover {
	background: #439ffa;
	color: white !important;
}
.affichageannee:focus, .affichagemois:focus {
    outline: none !important;
    color: white !important;
}
.btnmoisbloc {
    border-right: 1px solid #ddd;
    margin-top: 20px;
}
#moischoisie {
    margin-left: 15px;
}
.affichagemois {
    background-color: #ff4d05;
    color: white;
}
.affichagemois:hover {
		background-color: #fe753d;
		color: white !important;
}
.blocsemaine {
    margin-right: 20px;
}
</style>'); ?>

<div class="col-md-12 block">
    <p><?= __("Consultez les statistiques de pricing dans votre station pour les années précédentes (hébergements de même surface)") ?> :</p>
    <canvas height="200" id="prixloyer"></canvas> 
    <div class="row mt-5">
        <p class="col-md-3 btnmoisbloc">
            <button type="button" id="affichagemois" class="btn btn_default affichageannee rounded-0"><?= __("Affichage par mois") ?></button>
        </p>
        <p class="col-md-3 blocsemaine">
            <select name="moischoisie" id="moischoisie" class="form-control custom-select rounded-0">
            <option <?php if(date('m')==9) echo "selected"; ?> value="9"><?= __("Septembre") ?></option>
            <option <?php if(date('m')==10) echo "selected"; ?> value="10"><?= __("Octobre") ?></option>
            <option <?php if(date('m')==11) echo "selected"; ?> value="11"><?= __("Novembre") ?></option>
            <option <?php if(date('m')==12) echo "selected"; ?> value="12"><?= __("Décembre") ?></option>
            <option <?php if(date('m')==1) echo "selected"; ?> value="1"><?= __("Janvier") ?></option>
            <option <?php if(date('m')==2) echo "selected"; ?> value="2"><?= __("Fevrier") ?></option>
            <option <?php if(date('m')==3) echo "selected"; ?> value="3"><?= __("Mars") ?></option>
            <option <?php if(date('m')==4) echo "selected"; ?> value="4"><?= __("Avril") ?></option>
            <option <?php if(date('m')==5) echo "selected"; ?> value="5"><?= __("Mai") ?></option>
            <option <?php if(date('m')==6) echo "selected"; ?> value="6"><?= __("Juin") ?></option>
            <option <?php if(date('m')==7) echo "selected"; ?> value="7"><?= __("Juillet") ?></option>
            <option <?php if(date('m')==8) echo "selected"; ?> value="8"><?= __("Août") ?></option>
            </select>
        </p>
        <p class="col-md-4"><button type="button" id="affichagesemaine" class="btn btn_default affichagemois rounded-0"><?= __("Affichage par semaine") ?></button></p>
    </div>
</div>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
    //<script>
    var dataTabPrix = <?php echo json_encode($dataArrPrix) ?>;
    var colorTabPrix = <?php echo json_encode($colorArrPrix) ?>;
    var dataTabPrixTotal = <?php echo json_encode($dataArrPrixTotal) ?>;
    var colorTabPrixTotal = <?php echo json_encode($colorArrPrixTotal) ?>;
    var total = <?php echo json_encode($listeTotal) ?>;
    var id = <?php echo json_encode($anneechoix) ?>;
    
    var ctxprixloyer = document.getElementById('prixloyer').getContext('2d');
    var chartprixloyer = new Chart(ctxprixloyer, {
        type: 'bar',
        data:{
            datasets: [
                {
                    label: '<?= __("Loyer Prix Moyen Appartements Réservés (€/Nuitée)"); ?>',
                    data: dataTabPrix,
                    backgroundColor: colorTabPrix
                },
                {
                    label: '<?= __("Loyer Prix Moyen Tous Les Appartements (€/Nuitée)"); ?>',
                    data: dataTabPrixTotal,
                    backgroundColor: colorTabPrixTotal
                },
            ],
            labels: ["<?= __('Sep'); ?> "+(id-1), "<?= __('Oct'); ?> "+(id-1), "<?= __('Nov'); ?> "+(id-1), "<?= __('Déc'); ?> "+(id-1), "<?= __('Jan'); ?> "+id, "<?= __('Fev'); ?> "+id, "<?= __('Mar'); ?> "+id, "<?= __('Avr'); ?> "+id, "<?= __('Mai'); ?> "+id, "<?= __('Jun'); ?> "+id, "<?= __('Jul'); ?> "+id, "<?= __('Aoû'); ?> "+id]
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
            tooltips: {
                callbacks: {
                    afterBody: function(data) {
                    var lab = '';
                    if(data[0].datasetIndex == 0) lab = "<?= __('Total Annonce Réservé'); ?> : ";
                    else lab = "<?= __('Total Annonce'); ?> : ";
                    var multistringText = ["    "+lab+total[data[0].index][data[0].datasetIndex]];
                    return multistringText;
                    }
                }
            },
            title: {
                display: true,
                padding: 0,
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
    
    $("#affichagemois").on("click", function(){
        annee = <?php echo $anneechoix; ?>;
        $.ajax({
            type: "GET",
            async: false,
            dataType: 'json',
            url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/dataloyerstatischoixsurface/<?php echo $villageannonce; ?>/<?php echo $anneechoix; ?>/<?php echo $setsurfaceid; ?>",
            success:function(xml){
              var an = 0;
              dataTabMoisLoyer = [];
              colorTabMoisLoyer = [];
              dataTabMoisLoyerTotal = [];
              colorTabMoisLoyerTotal = [];
              
              while (typeof(xml.listeStatMoisLoyer[an])!="undefined") {
                dataTabMoisLoyer.push(xml.listeStatMoisLoyer[an]);
                colorTabMoisLoyer.push('#46a3fe');
                dataTabMoisLoyerTotal.push(xml.listeStatMoisLoyerTotal[an]);
                colorTabMoisLoyerTotal.push('#ff530d');
                an++;
              }
              dataMoisLoyer = {
                datasets: [
                  {
                    label: '<?= __("Loyer Prix Moyen Appartements Réservés (€/Nuitée)"); ?>',
                    data: dataTabMoisLoyer,
                    backgroundColor: colorTabMoisLoyer
                  },
                  {
                    label: '<?= __("Loyer Prix Moyen Tous Les Appartements (€/Nuitée)"); ?>',
                    data: dataTabMoisLoyerTotal,
                    backgroundColor: colorTabMoisLoyerTotal
                  },
              ],
                labels: ["<?= __('Sep'); ?> "+(annee-1), "<?= __('Oct'); ?> "+(annee-1), "<?= __('Nov'); ?> "+(annee-1), "<?= __('Déc'); ?> "+(annee-1), "<?= __('Jan'); ?> "+annee, "<?= __('Fev'); ?> "+annee, "<?= __('Mar'); ?> "+annee, "<?= __('Avr'); ?> "+annee, "<?= __('Mai'); ?> "+annee, "<?= __('Jun'); ?> "+annee, "<?= __('Jul'); ?> "+annee, "<?= __('Aoû'); ?> "+annee]
              };

              total = xml.listeTotal;
              tooltips = function(data) {
                    var lab = '';
                    if(data[0].datasetIndex == 0) lab = "<?= __('Total Annonce Réservé'); ?> : ";
                    else lab = "<?= __('Total Annonce'); ?> : ";
                    var multistringText = ["    "+lab+total[data[0].index][data[0].datasetIndex]];
                    return multistringText;
              };
            }
        });
        chartprixloyer.data = dataMoisLoyer;
        chartprixloyer.options.tooltips.callbacks.afterBody = tooltips;
        chartprixloyer.update();
    });
    
    $("#affichagesemaine").on("click", function(){
     annee = <?php echo $anneechoix; ?>;
        var id_mois = $("#moischoisie").val(); 
        var dataMoisLoyersemaine;
        $.ajax({
            type: "POST",
            async: false,
            dataType: 'json',
            url: "<?php echo $this->Url->build('/',true)?>manager/gestionnaires/datasemaineloyerprix/"+id_mois+"/<?php echo $villageannonce; ?>",
            data: {wheresurface: "<?php echo $wheresurface; ?>"},
            success:function(xml){
              var an = 0;
              dataTabPrix = [];
              colorTabPrix = [];
              dataTabPrixTotal = [];
              colorTabPrixTotal = [];
              labelTab = [];
              
              while (typeof(xml.listePrixSurface[an])!="undefined") {
                dataTabPrix.push(xml.listePrixSurface[an]);
                colorTabPrix.push('#46a3fe');
                dataTabPrixTotal.push(xml.listePrixSurfaceTotalNnReser[an]);
                colorTabPrixTotal.push('#ff530d');
                labelTab.push(xml.nbrInscrLabel[an]);
                an++;
              }
              
              dataMoisLoyersemaine = {
                datasets: [
                  {
                    label: '<?= __("Loyer Prix Moyen Appartements Réservés (€/Nuitée)"); ?>',
                    data: dataTabPrix,
                    backgroundColor: colorTabPrix
                  },
                  {
                    label: '<?= __("Loyer Prix Moyen Tous Les Appartements (€/Nuitée)"); ?>',
                    data: dataTabPrixTotal,
                    backgroundColor: colorTabPrixTotal
                  },
              ],
                labels: labelTab
              };
              
              total = xml.listeTotal;
              tooltips = function(data) {
                    var lab = '';
                    if(data[0].datasetIndex == 0) lab = "<?= __('Total Annonce Réservé'); ?> : ";
                    else lab = "<?= __('Total Annonce'); ?> : ";
                    var multistringText = ["    "+lab+total[data[0].index][data[0].datasetIndex]];
                    return multistringText;
              };
            }
        });
        
        chartprixloyer.data = dataMoisLoyersemaine;
        chartprixloyer.options.tooltips.callbacks.afterBody = tooltips;
        chartprixloyer.update();
    });
<?php $this->Html->scriptEnd(); ?>