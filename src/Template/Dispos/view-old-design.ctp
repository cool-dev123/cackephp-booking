<?php //$this->Html->css("/css/update.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/modif_datepicker.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>

<!-- CSSMap STYLESHEET - EUROPE -->
<?php $this->Html->css("/css/cssmap-europe.css", array('block' => 'cssTop')); ?>

<!-- CSSMap SCRIPT -->
<?php $this->Html->script("/js/jquery.cssmap.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/css/flags.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/fullcalendar.css", array('block' => 'cssTop')); ?>
<link href='<?php echo $this->Url->build('/',true)?>css/fullcalendar.print.css' rel='stylesheet' media='print' />
<?php $this->Html->script("/js/moment.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/fullcalendar.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/locale/fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/jquery.dataTables.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("https://cdnjs.cloudflare.com/ajax/libs/ical.js/1.3.0/ical.min.js", array('block' => 'scriptBottom')); ?>
<script type="text/javascript" src="<?php echo $this->Url->build('/',true);?>manager-arr/js/chart.js"></script>
<script type="text/javascript" src="<?php echo $this->Url->build('/',true);?>manager-arr/js/chartjs-plugin-datalabels.js"></script>

<?php $this->append('cssTopBlock', '<style>
.fc-event:hover{
  box-shadow: 0 1px 0px 0 #999, 0 8px 5px 0 #999;
}
a.fc-day-grid-event {
    height: 30px;
}
.fc-event .fc-content {
    padding-top: 8px;
}
a.fc-day-grid-event::after {
    border-top: 32px solid #4cc075;
}
a.fc-day-grid-event::before {
    border-top: 32px solid rgba(241, 241, 241, 0.72);
}
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
/*.importexport {
    font-size: 17px;
    margin-right: 10px;
}*/
.col-md-12.text-right {
    margin-bottom: 30px;
}
#ui-datepicker-div {
  z-index: 2147483647 !important;
}
</style>'); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="tarif_disp" class="container">
<?php echo $this->Flash->render(); ?>
<div class="row bg-light no-gutters mb-4 mt-n3" >
<div class="col-sm-6 col-lg-3 list-steps">
<a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/edit/<?php echo $annonce_id ?>"><span class="d-block text-center ann-step">1. <?= __("Informations") ?></span></a>
</div>
<div class="col-sm-6 col-lg-3 list-steps">
<a href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/photo/<?php echo $annonce_id ?>'><span class="d-block text-center ann-step">2. <?= __("Images") ?></span></a>
</div>
<div class="col-sm-6 col-lg-3 list-steps">
<span class="d-block text-center ann-step active-steps">3. <?= __("Tarification") ?></span>
</div>
<div class="col-sm-6 col-lg-3 list-steps">
<a  href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/".$urlvaluemulti['previsualiser']; ?>/<?php echo $annonce->id ?>'><span class="d-block text-center text-lg-right text-xl-center ann-step after-active-steps">4. <?= __("Prévisualisation") ?></span></a>
</div>
</div><!-- end row -->
<div class="row">
<div class="col-md-12">
<?php echo $this->Flash->render() ?>
<div class="header_title bg-light">
<h5 class="mb-2 mt-2 py-2 px-3"><?= __("Planning des disponibilités et tarifs") ?></h5>
</div><!-- header_title-->
</div> <!--end col-md-12-->
</div> <!--end row-->

                                  
                      <div class="row">
                          <div class="col-md-10 block">
                            <div id='calendar' style="overflow:auto;"></div>
                          </div>
                          <div class="col-md-2 indic block">
                            <p><b><?= __("Indication") ?> :</b></p>
                            <div class="botmar">
                            <div class="flex">
                            <div id="carrebleu"></div> <span class="indication">&nbsp;&nbsp; <?= __("Vacances") ?></span>
                            </div>
                            <div class="flex">
                            <div id="carreorange"></div> <span class="indication">&nbsp;&nbsp; <?= __("Option") ?></span>
                            </div>
                            <div class="flex">
                            <div id="carrevert"></div> <span class="indication">&nbsp;&nbsp; <?= __("Disponible") ?></span>
                            </div>
                            <div class="flex">
                            <div id="carrerouge"></div> <span class="indication">&nbsp;&nbsp; <?= __("Réservé") ?></span>
                            </div>
                            <div class="flex">
                            <div id="carreblanc"></div> <span class="indication">&nbsp;&nbsp; <?= __("Station ouverte") ?></span>
                            </div>
                            <div class="flex">
                            <div id="carregris"></div> <span class="indication">&nbsp;&nbsp; <?= __("Station fermée") ?></span>
                            </div>
                            <!-- <div class="flex">
                            <div id="carrerosesynchro"></div> <span class="indication">&nbsp;&nbsp; <?= __("Réservé importé") ?></span>
                            </div> -->
                            </div>
                            <?php if(!$possible){ ?><a class="btn btn-blue text-white rounded-0 btnajoutper" onclick="ajouterperiode()"><?= __("Ajouter une période") ?></a><?php } ?>
                          </div>
                      </div>
                    <div class="col-md-10 shadow-sm border p-3 mt-3 text-center" style="display: none;">
                      <h4><?= __("Synchronisation du calendrier") ?></h4>
                      <p class="mb-0 mt-2"><span style="font-size: 15px">
                        <i class="fa fa-download mr-2"></i> <u><a href="#" class="importexport text-dark" onclick="importerCalendar()"><?= __("Importer le calendrier") ?></a></u>                                
                        <br>
                        <i class="fa fa-upload mr-2"></i> <u><a href="#" class="importexport text-dark" onclick="expoterCalendar()"><?= __("Exporter le calendrier") ?></a></u>   
                      </p>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-12 pr-0">
                      <i class="fa fa-angle-right"></i> <?= __("Une question ? Consultez notre") ?> <a href="https://help.alpissime.com/" target="_blanck"><u> <?= __("Centre d'aide") ?></u></a>
                    </div>
                       <div class="col-md-12 block">
                           <p><b><?= __("Consultez les statistiques de pricing dans votre station pour les années précédentes (hébergements de même surface)") ?> :</b></p>
                           <canvas height="200" id="prixloyer"></canvas> 
                           <div class="row mt-5">
                           <p class="col-md-3 btnmoisbloc"><button type="button" id="affichagemois" class="btn btn_default affichageannee rounded-0"><?= __("Affichage par mois") ?></button></p>
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
                    </div>
                    <hr>
                 <div class="row">                     
                      <div class="col-md-12 block">
                        <p><b><?= __("Carte des vacances européennes") ?> :</b></p>
                        <!-- CSSMap - Europe -->
                        <div id="map-europe">
                          <ul class="europe">
                            <li class="eu1"><a href="#albania"><?php
                              if (isset($drapeauvacance['Albanie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Albanie'])."' alt='".strtolower($drapeauvacance['Albanie'])."' /> Albanie".$tabzones['Albanie']."</h2></center>";
                              else echo "<center><h2>Albanie".$tabzones['Albanie']."</h2></center>";
                              if(isset($tabvacance['Albanie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Albanie'] as $key ) {
                                  echo "<tr><td>";
                                  echo $key;
                                  echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu2"><a href="#andorra"><?php
                              if (isset($drapeauvacance['Andorre'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Andorre'])."' alt='".strtolower($drapeauvacance['Andorre'])."' /> Andorre".$tabzones['Andorre']."</h2></center>";
                              else echo "<center><h2>Andorre".$tabzones['Andorre']."</h2></center>";
                              if(isset($tabvacance['Andorre'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Andorre'] as $key ) {
                                  echo "<tr><td>";
                                  echo $key;
                                  echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu3"><a href="#austria"><?php
                              if (isset($drapeauvacance['Autriche'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Autriche'])."' alt='".strtolower($drapeauvacance['Autriche'])."' /> Autriche".$tabzones['Autriche']."</h2></center>";
                              else echo "<center><h2>Autriche".$tabzones['Autriche']."</h2></center>";
                              if(isset($tabvacance['Autriche'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Autriche'] as $key ) {
                                  echo "<tr><td>";
                                  echo $key;
                                  echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu4"><a href="#belarus"><?php
                              if (isset($drapeauvacance['Biélorussie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Biélorussie'])."' alt='".strtolower($drapeauvacance['Biélorussie'])."' /> Biélorussie".$tabzones['Biélorussie']."</h2></center>";
                              else echo "<center><h2>Biélorussie".$tabzones['Biélorussie']."</h2></center>";
                              if(isset($tabvacance['Biélorussie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Biélorussie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu5"><a href="#belgium"><?php
                              if (isset($drapeauvacance['Belgique'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Belgique'])."' alt='".strtolower($drapeauvacance['Belgique'])."' /> Belgique".$tabzones['Belgique']."</h2></center>";
                              else echo "<center><h2>Belgique".$tabzones['Belgique']."</h2></center>";
                              if(isset($tabvacance['Belgique'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Belgique'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu6"><a href="#bosnia-and-herzegovina"><?php
                              if (isset($drapeauvacance['Bosnie-Herzégovine'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Bosnie-Herzégovine'])."' alt='".strtolower($drapeauvacance['Bosnie-Herzégovine'])."' /> Bosnia et Herzegovina".$tabzones['Bosnie-Herzégovine']."</h2></center>";
                              else echo "<center><h2>Bosnie-Herzégovine".$tabzones['Bosnie-Herzégovine']."</h2></center>";
                              if(isset($tabvacance['Bosnie-Herzégovine'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Bosnie-Herzégovine'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu7"><a href="#bulgaria"><?php
                              if (isset($drapeauvacance['Bulgarie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Bulgarie'])."' alt='".strtolower($drapeauvacance['Bulgarie'])."' /> Bulgarie".$tabzones['Bulgarie']."</h2></center>";
                              else echo "<center><h2>Bulgarie".$tabzones['Bulgarie']."</h2></center>";
                              if(isset($tabvacance['Bulgarie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Bulgarie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu8"><a href="#croatia"><?php
                              if (isset($drapeauvacance['Croatie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Croatie'])."' alt='".strtolower($drapeauvacance['Croatie'])."' /> Croatie".$tabzones['Croatie']."</h2></center>";
                              else echo "<center><h2>Croatie".$tabzones['Croatie']."</h2></center>";
                              if(isset($tabvacance['Croatie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Croatie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu9"><a href="#cyprus"><?php
                              if (isset($drapeauvacance['Chypre'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Chypre'])."' alt='".strtolower($drapeauvacance['Chypre'])."' /> Chypre".$tabzones['Chypre']."</h2></center>";
                              else echo "<center><h2>Chypre".$tabzones['Chypre']."</h2></center>";
                              if(isset($tabvacance['Chypre'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Chypre'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu10"><a href="#czech-republic"><?php
                              if (isset($drapeauvacance['République tchèque'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['République tchèque'])."' alt='".strtolower($drapeauvacance['République tchèque'])."' /> République tchèque".$tabzones['République tchèque']."</h2></center>";
                              else echo "<center><h2>République tchèque".$tabzones['République tchèque']."</h2></center>";
                              if(isset($tabvacance['République tchèque'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['République tchèque'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu11"><a href="#denmark"><?php
                            if (isset($drapeauvacance['Danemark'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Danemark'])."' alt='".strtolower($drapeauvacance['Danemark'])."' /> Danemark".$tabzones['Danemark']."</h2></center>";
                            else echo "<center><h2>Danemark".$tabzones['Danemark']."</h2></center>";
                              if(isset($tabvacance['Danemark'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Danemark'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu12"><a href="#estonia"><?php
                            if (isset($drapeauvacance['Estonie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Estonie'])."' alt='".strtolower($drapeauvacance['Estonie'])."' /> Estonie".$tabzones['Estonie']."</h2></center>";
                            else echo "<center><h2>Estonie".$tabzones['Estonie']."</h2></center>";
                              if(isset($tabvacance['Estonie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Estonie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu13"><a href="#france"><?php
                            if (isset($drapeauvacance['France'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['France'])."' alt='".strtolower($drapeauvacance['France'])."' /> France".$tabzones['France']."</h2></center>";
                            else echo "<center><h2>France".$tabzones['France']."</h2></center>";
                              if(isset($tabvacance['France'])) {
                              echo "<table class='sansborder'>";
                              foreach ($tabvacance['France'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu14"><a href="#finland"><?php
                            if (isset($drapeauvacance['Finlande'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Finlande'])."' alt='".strtolower($drapeauvacance['Finlande'])."' /> Finlande".$tabzones['Finlande']."</h2></center>";
                            else echo "<center><h2>Finlande".$tabzones['Finlande']."</h2></center>";
                              if(isset($tabvacance['Finlande'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Finlande'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu15"><a href="#georgia"><?php
                            if (isset($drapeauvacance['Géorgie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Géorgie'])."' alt='".strtolower($drapeauvacance['Géorgie'])."' /> Géorgie".$tabzones['Géorgie']."</h2></center>";
                            else echo "<center><h2>Géorgie".$tabzones['Géorgie']."</h2></center>";
                              if(isset($tabvacance['Géorgie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Géorgie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu16"><a href="#germany"><?php
                            if (isset($drapeauvacance['Allemagne'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Allemagne'])."' alt='".strtolower($drapeauvacance['Allemagne'])."' /> Allemagne".$tabzones['Allemagne']."</h2></center>";
                            else echo "<center><h2>Allemagne".$tabzones['Allemagne']."</h2></center>";
                              if(isset($tabvacance['Allemagne'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Allemagne'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu17"><a href="#greece"><?php
                            if (isset($drapeauvacance['Grèce'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Grèce'])."' alt='".strtolower($drapeauvacance['Grèce'])."' /> Grèce".$tabzones['Grèce']."</h2></center>";
                            else echo "<center><h2>Grèce".$tabzones['Grèce']."</h2></center>";
                              if(isset($tabvacance['Grèce'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Grèce'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu18"><a href="#hungary"><?php
                            if (isset($drapeauvacance['Hongrie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Hongrie'])."' alt='".strtolower($drapeauvacance['Hongrie'])."' /> Hongrie".$tabzones['Hongrie']."</h2></center>";
                            else echo "<center><h2>Hongrie".$tabzones['Hongrie']."</h2></center>";
                              if(isset($tabvacance['Hongrie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Hongrie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu19"><a href="#iceland"><?php
                            if (isset($drapeauvacance['Islande'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Islande'])."' alt='".strtolower($drapeauvacance['Islande'])."' /> Islande".$tabzones['Islande']."</h2></center>";
                            else echo "<center><h2>Islande".$tabzones['Islande']."</h2></center>";
                              if(isset($tabvacance['Islande'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Islande'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu20"><a href="#ireland"><?php
                            if (isset($drapeauvacance['Irlande'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Irlande'])."' alt='".strtolower($drapeauvacance['Irlande'])."' /> Irlande".$tabzones['Irlande']."</h2></center>";
                            else echo "<center><h2>Irlande".$tabzones['Irlande']."</h2></center>";
                              if(isset($tabvacance['Irlande'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Irlande'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu21"><a href="#san-marino"><?php
                            if (isset($drapeauvacance['Saint-Marin'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Saint-Marin'])."' alt='".strtolower($drapeauvacance['Saint-Marin'])."' /> Saint-Marin".$tabzones['Saint-Marin']."</h2></center>";
                            else echo "<center><h2>Saint-Marin".$tabzones['Saint-Marin']."</h2></center>";
                              if(isset($tabvacance['Saint-Marin'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Saint-Marin'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu22"><a href="#italy"><?php
                            if (isset($drapeauvacance['Italie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Italie'])."' alt='".strtolower($drapeauvacance['Italie'])."' /> Italie".$tabzones['Italie']."</h2></center>";
                            else echo "<center><h2>Italie".$tabzones['Italie']."</h2></center>";
                              if(isset($tabvacance['Italie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Italie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu23"><a href="#kosovo"><?php
                            if(isset($drapeauvacance['Kosovo'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Kosovo'])."' alt='".strtolower($drapeauvacance['Kosovo'])."' /> Kosovo".$tabzones['Kosovo']."</h2></center>";
                            else{
                              echo "<center><h2>Kosovo".$tabzones['Kosovo']."</h2></center>";
                            }
                            if(isset($tabvacance['Kosovo'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Kosovo'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu24"><a href="#latvia"><?php
                            if (isset($drapeauvacance['Lettonie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Lettonie'])."' alt='".strtolower($drapeauvacance['Lettonie'])."' /> Lettonie".$tabzones['Lettonie']."</h2></center>";
                            else echo "<center><h2>Lettonie".$tabzones['Lettonie']."</h2></center>";
                              if(isset($tabvacance['Lettonie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Lettonie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu25"><a href="#liechtenstein"><?php
                            if (isset($drapeauvacance['Liechtenstein'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Liechtenstein'])."' alt='".strtolower($drapeauvacance['Liechtenstein'])."' /> Liechtenstein".$tabzones['Liechtenstein']."</h2></center>";
                            else echo "<center><h2>Liechtenstein".$tabzones['Liechtenstein']."</h2></center>";
                              if(isset($tabvacance['Liechtenstein'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Liechtenstein'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu26"><a href="#lithuania"><?php
                            if (isset($drapeauvacance['Lituanie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Lituanie'])."' alt='".strtolower($drapeauvacance['Lituanie'])."' /> Lituanie".$tabzones['Lituanie']."</h2></center>";
                            else echo "<center><h2>Lituanie".$tabzones['Lituanie']."</h2></center>";
                              if(isset($tabvacance['Lituanie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Lituanie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu27"><a href="#luxembourg"><?php
                            if (isset($drapeauvacance['Luxembourg'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Luxembourg'])."' alt='".strtolower($drapeauvacance['Luxembourg'])."' /> Luxembourg".$tabzones['Luxembourg']."</h2></center>";
                            else echo "<center><h2>Luxembourg".$tabzones['Luxembourg']."</h2></center>";
                              if(isset($tabvacance['Luxembourg'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Luxembourg'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu28"><a href="#macedonia"><?php
                            if (isset($drapeauvacance['ex-République yougoslave de Macédoine'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['ex-République yougoslave de Macédoine'])."' alt='".strtolower($drapeauvacance['ex-République yougoslave de Macédoine'])."' /> Ex-République yougoslave de Macédoine".$tabzones['ex-République yougoslave de Macédoine']."</h2></center>";
                            else echo "<center><h2>ex-République yougoslave de Macédoine".$tabzones['ex-République yougoslave de Macédoine']."</h2></center>";
                              if(isset($tabvacance['ex-République yougoslave de Macédoine'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['ex-République yougoslave de Macédoine'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu29"><a href="#malta"><?php
                            if (isset($drapeauvacance['Malte'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Malte'])."' alt='".strtolower($drapeauvacance['Malte'])."' /> Malte".$tabzones['Malte']."</h2></center>";
                            else echo "<center><h2>Malte".$tabzones['Malte']."</h2></center>";
                              if(isset($tabvacance['Malte'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Malte'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu30"><a href="#moldova"><?php
                            if (isset($drapeauvacance['Moldavie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Moldavie'])."' alt='".strtolower($drapeauvacance['Moldavie'])."' /> Moldavie".$tabzones['Moldavie']."</h2></center>";
                            else echo "<center><h2>Moldavie".$tabzones['Moldavie']."</h2></center>";
                              if(isset($tabvacance['Moldavie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Moldavie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu31"><a href="#monaco"><?php
                            if (isset($drapeauvacance['Monaco'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Monaco'])."' alt='".strtolower($drapeauvacance['Monaco'])."' /> Monaco".$tabzones['Monaco']."</h2></center>";
                            else echo "<center><h2>Monaco".$tabzones['Monaco']."</h2></center>";
                              if(isset($tabvacance['Monaco'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Monaco'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu32"><a href="#montenegro"><?php
                              if(isset($drapeauvacance['Monténégro'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Monténégro'])."' alt='".strtolower($drapeauvacance['Monténégro'])."' /> Monténégro".$tabzones['Monténégro']."</h2></center>";
                              else{
                                echo "<center><h2>Monténégro".$tabzones['Monténégro']."</h2></center>";
                              }
                              if(isset($tabvacance['Monténégro'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Monténégro'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu33"><a href="#netherlands"><?php
                            if (isset($drapeauvacance['Pays-Bas'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Pays-Bas'])."' alt='".strtolower($drapeauvacance['Pays-Bas'])."' /> Pays-Bas".$tabzones['Pays-Bas']."</h2></center>";
                            else echo "<center><h2>Pays-Bas".$tabzones['Pays-Bas']."</h2></center>";
                              if(isset($tabvacance['Pays-Bas'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Pays-Bas'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu34"><a href="#norway"><?php
                            if (isset($drapeauvacance['Norvège'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Norvège'])."' alt='".strtolower($drapeauvacance['Norvège'])."' /> Norvège".$tabzones['Norvège']."</h2></center>";
                            else echo "<center><h2>Norvège".$tabzones['Norvège']."</h2></center>";
                              if(isset($tabvacance['Norvège'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Norvège'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu35"><a href="#poland"><?php
                            if (isset($drapeauvacance['Pologne'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Pologne'])."' alt='".strtolower($drapeauvacance['Pologne'])."' /> Pologne".$tabzones['Pologne']."</h2></center>";
                            else echo "<center><h2>Pologne".$tabzones['Pologne']."</h2></center>";
                              if(isset($tabvacance['Pologne'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Pologne'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu36"><a href="#portugal"><?php
                            if (isset($drapeauvacance['Portugal'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Portugal'])."' alt='".strtolower($drapeauvacance['Portugal'])."' /> Portugal".$tabzones['Portugal']."</h2></center>";
                            else echo "<center><h2>Portugal".$tabzones['Portugal']."</h2></center>";
                              if(isset($tabvacance['Portugal'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Portugal'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu37"><a href="#romania"><?php
                            if (isset($drapeauvacance['Roumanie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Roumanie'])."' alt='".strtolower($drapeauvacance['Roumanie'])."' /> Roumanie".$tabzones['Roumanie']."</h2></center>";
                            else echo "<center><h2>Roumanie".$tabzones['Roumanie']."</h2></center>";
                              if(isset($tabvacance['Roumanie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Roumanie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu38"><a href="#russian-federation"><?php
                            if (isset($drapeauvacance['Russie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Russie'])."' alt='".strtolower($drapeauvacance['Russie'])."' /> Russie".$tabzones['Russie']."</h2></center>";
                            else echo "<center><h2>Russie".$tabzones['Russie']."</h2></center>";
                              if(isset($tabvacance['Russie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Russie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu39"><a href="#serbia"><?php
                            if (isset($drapeauvacance['Serbie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Serbie'])."' alt='".strtolower($drapeauvacance['Serbie'])."' /> Serbie".$tabzones['Serbie']."</h2></center>";
                            else echo "<center><h2>Serbie".$tabzones['Serbie']."</h2></center>";
                              if(isset($tabvacance['Serbie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Serbie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu40"><a href="#slovakia"><?php
                            if (isset($drapeauvacance['Slovaquie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Slovaquie'])."' alt='".strtolower($drapeauvacance['Slovaquie'])."' /> Slovaquie".$tabzones['Slovaquie']."</h2></center>";
                            else echo "<center><h2>Slovaquie".$tabzones['Slovaquie']."</h2></center>";
                              if(isset($tabvacance['Slovaquie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Slovaquie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu41"><a href="#slovenia"><?php
                            if (isset($drapeauvacance['Slovénie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Slovénie'])."' alt='".strtolower($drapeauvacance['Slovénie'])."' /> Slovénie".$tabzones['Slovénie']."</h2></center>";
                            else echo "<center><h2>Slovénie".$tabzones['Slovénie']."</h2></center>";
                              if(isset($tabvacance['Slovénie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Slovénie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu42"><a href="#spain"><?php
                            if (isset($drapeauvacance['Espagne'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Espagne'])."' alt='".strtolower($drapeauvacance['Espagne'])."' /> Espagne".$tabzones['Espagne']."</h2></center>";
                            else echo "<center><h2>Espagne".$tabzones['Espagne']."</h2></center>";
                              if(isset($tabvacance['Espagne'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Espagne'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu43"><a href="#sweden"><?php
                              if (isset($drapeauvacance['Suède'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Suède'])."' alt='".strtolower($drapeauvacance['Suède'])."' /> Suède".$tabzones['Suède']."</h2></center>";
                              else{
                                echo "<center><h2>Suède".$tabzones['Suède']."</h2></center>";
                              }
                              if(isset($tabvacance['Suède'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Suède'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu44"><a href="#switzerland"><?php
                            if (isset($drapeauvacance['Suisse'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Suisse'])."' alt='".strtolower($drapeauvacance['Suisse'])."' /> Suisse".$tabzones['Suisse']."</h2></center>";
                            else echo "<center><h2>Suisse".$tabzones['Suisse']."</h2></center>";
                              if(isset($tabvacance['Suisse'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Suisse'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu45"><a href="#turkey"><?php
                            if (isset($drapeauvacance['Turquie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Turquie'])."' alt='".strtolower($drapeauvacance['Turquie'])."' /> Turquie".$tabzones['Turquie']."</h2></center>";
                            else echo "<center><h2>Turquie".$tabzones['Turquie']."</h2></center>";
                              if(isset($tabvacance['Turquie'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Turquie'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu46"><a href="#ukraine"><?php
                            if (isset($drapeauvacance['Ukraine'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Ukraine'])."' alt='".strtolower($drapeauvacance['Ukraine'])."' /> Ukraine".$tabzones['Ukraine']."</h2></center>";
                            else echo "<center><h2>Ukraine".$tabzones['Ukraine']."</h2></center>";
                              if(isset($tabvacance['Ukraine'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Ukraine'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu47"><a href="#united-kingdom"><?php
                            if (isset($drapeauvacance['Royaume-Uni'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Royaume-Uni'])."' alt='".strtolower($drapeauvacance['Royaume-Uni'])."' /> Royaume-Uni".$tabzones['Royaume-Uni']."</h2></center>";
                            else echo "<center><h2>Royaume-Uni".$tabzones['Royaume-Uni']."</h2></center>";
                              if(isset($tabvacance['Royaume-Uni'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Royaume-Uni'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu48"><a href="#england"><?php
                            if (isset($drapeauvacance['Angleterre'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Angleterre'])."' alt='".strtolower($drapeauvacance['Angleterre'])."' /> Angleterre".$tabzones['Angleterre']."</h2></center>";
                            else echo "<center><h2>Angleterre".$tabzones['Angleterre']."</h2></center>";
                              if(isset($tabvacance['Angleterre'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Angleterre'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu49"><a href="#isle-of-man"><?php
                              if(isset($drapeauvacance['Ile de Man'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Ile de Man'])."' alt='".strtolower($drapeauvacance['Ile de Man'])."' /> Île de Man".$tabzones['Ile de Man']."</h2></center>";
                              else{
                                echo "<center><h2>Île de Man".$tabzones['Ile de Man']."</h2></center>";
                              }
                              if(isset($tabvacance['Ile de Man'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Ile de Man'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu50"><a href="#northern-ireland"><?php
                            if (isset($drapeauvacance['Irlande du Nord'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Irlande du Nord'])."' alt='".strtolower($drapeauvacance['Irlande du Nord'])."' /> Irlande du Nord".$tabzones['Irlande du Nord']."</h2></center>";
                            else echo "<center><h2>Irlande du Nord".$tabzones['Irlande du Nord']."</h2></center>";
                              if(isset($tabvacance['Irlande du Nord'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Irlande du Nord'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu51"><a href="#scotland"><?php
                              if(isset($drapeauvacance['écosse'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['écosse'])."' alt='".strtolower($drapeauvacance['écosse'])."' /> Écosse".$tabzones['écosse']."</h2></center>";
                              else{
                                echo "<center><h2>Écosse".$tabzones['écosse']."</h2></center>";
                              }
                              if(isset($tabvacance['écosse'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['écosse'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                            <li class="eu52"><a href="#wales"><?php
                            if (isset($drapeauvacance['Pays de Galles'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Pays de Galles'])."' alt='".strtolower($drapeauvacance['Pays de Galles'])."' /> Pays de Galles".$tabzones['Pays de Galles']."</h2></center>";
                            else echo "<center><h2>Pays de Galles".$tabzones['Pays de Galles']."</h2></center>";
                              if(isset($tabvacance['Pays de Galles'])) {
                                echo "<table class='sansborder'>";
                                foreach ($tabvacance['Pays de Galles'] as $key ) {
                                echo "<tr><td>";
                                echo $key;
                                echo "</td></tr>";
                              }
                            echo "</table>";
                          }  ?></a></li>
                        </ul>
                      </div>
                      <!-- END OF THE CSSMap - Europe -->
                      <div id="demo-agents" class="demo-agents-list wrapper">
                        <ul>
                          <li id="albania"></li>
                          <li id="andorra"></li>
                          <li id="austria"></li>
                          <li id="belarus"></li>
                          <li id="belgium"></li>
                          <li id="bosnia-and-herzegovina"></li>
                          <li id="bulgaria"> </li>
                          <li id="croatia"></li>
                          <li id="cyprus"></li>
                          <li id="czech-republic"></li>
                          <li id="denmark"></li>
                          <li id="estonia"></li>
                          <li id="france"><?php
                            echo "<h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['France'])."' alt='".strtolower($drapeauvacance['France'])."' /> France".$tabzones['France']."</h2>";
                            ?>
                            <table class="legendtable">
                              <tr>
                                <td  width="20%">
                                  <div class="flex margr">
                                    <div id="carreorange" style="margin-bottom: 5px;"></div> <span class="indication">&nbsp;&nbsp; <?= __("Zone A") ?></span>
                                  </div>
                                </td>
                                <td>
                                  <?= __("Besançon, Bordeaux, Clermont-Ferrand, Dijon, Grenoble, Limoges, Lyon, Poitiers") ?>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="flex margr">
                                    <div id="carrezoneb"></div> <span class="indication">&nbsp;&nbsp; <?= __("Zone B") ?></span>
                                  </div>
                                </td>
                                <td>
                                  <?= __("Aix-Marseille, Amiens, Caen, Lille, Nancy-Metz, Nantes, Nice, Orléans-Tours, Reims, Rennes, Rouen, Strasbourg") ?>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="flex margr">
                                    <div id="carrezonec"></div> <span class="indication">&nbsp;&nbsp; <?= __("Zone C") ?></span>
                                  </div>
                                </td>
                                <td>
                                  <?= __("Créteil, Montpellier, Paris, Toulouse, Versailles") ?>
                                </td>
                              </tr>
                            </table>

                         </li>
                          <li id="finland"></li>
                          <li id="georgia"></li>
                          <li id="germany"></li>
                          <li id="greece"></li>
                          <li id="hungary"></li>
                          <li id="iceland"></li>
                          <li id="ireland"></li>
                          <li id="san-marino"></li>
                          <li id="italy"></li>
                          <!-- NON TROUVE "Kosovo" -->
                          <li id="kosovo"></li>
                          <li id="latvia"></li>
                          <li id="liechtenstein"></li>
                          <li id="lithuania"></li>
                          <li id="luxembourg"></li>
                          <li id="macedonia"></li>
                          <li id="malta"></li>
                          <li id="moldova"></li>
                          <li id="monaco"></li>
                          <!-- NON TROUVE "Monténégro" -->
                          <li id="montenegro"></li>
                          <li id="netherlands"></li>
                          <li id="norway"></li>
                          <li id="poland"></li>
                          <li id="portugal"></li>
                          <li id="romania"></li>
                          <li id="russian-federation"></li>
                          <li id="serbia"></li>
                          <li id="slovakia"></li>
                          <li id="slovenia"></li>
                          <li id="spain"></li>
                          <li id="sweden"></li>
                          <li id="switzerland"></li>
                          <li id="turkey">  </li>
                          <li id="ukraine"></li>
                          <li id="united-kingdom"></li>
                          <li id="england"></li>
                          <!-- NON TROUVE "Île de Man" -->
                          <li id="isle-of-man"></li>
                          <li id="northern-ireland"></li>
                          <!-- NON TROUVE "Écosse" -->
                          <li id="scotland"></li>
                          <!-- NON TROUVE "Pays de Galles" -->
                          <li id="wales"></li>
                        </ul>
                      </div>
                      </div>
                    </div>
                    
                    <div class="row mt-4 justify-content-end">
                        <div class="col-auto">
                        <?php if(!$possible){ ?>
                            <!-- <a  href = '<?php echo $this->Url->build('/',true); ?>annonces/photo/<?php echo $annonce_id ?>' class="btn btn-retour left"><?= __("Retour") ?></a> -->
                           <?php if($this->Session->read('Auth.User.id')!="" || $this->Session->read('Gestionnaire.info.G.id') != ""):?>
                           <button class="btn btn-blue text-white rounded-0 px-6" onclick="location.href = '<?php echo $this->Url->build('/',true); ?>annonces/previsualiser/<?php echo $annonce_id ?>';"><?= __("Prévisualiser") ?></button>
                        

<?php else:?>
<?php //echo $this->element("menu_gestionnaire")?>
<?php endif;?>
<?php } ?>


					 </div>
                    </div>
                </div>
                
                

            
		<input type="hidden" id="hdreservation"/>
		<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><?= __("Supprimer les semaines de locations") ?></h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        
			      </div>

			      <div class="modal-body">
					<center><p><?= __("Vous allez supprimer toutes les semaines de locations") ?></p></center>

			      </div>
			      <div >
					<button type="button" class="btn btn-retour" data-dismiss="modal" aria-label="Close"><?= __("Non") ?></button>
					<button type="button" class="btn btn-blue text-white rounded-0" onclick="delete_res()"><?= __("Oui") ?></button>
			      </div>

			    </div>
			  </div>
			</div>
      <!-- Modal -->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div  class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
        <?php echo $this->Form->create(null,['id'=>'editModel','class'=>'form-horizontal','url' => ['controller' => 'Dispos', 'action' => 'calendarEdit'],'onsubmit'=>'return validateFormEdit()']);?>
        <input type="hidden" name="annonce_id" id="annonce_id" value="" >
        <input type="hidden" name="ids" id="ids" value="" >
        <input type="hidden" name="locatairehidden" id="locatairehidden" value="" >
        <input type="hidden" name="defaultstatuthidden" id="defaultstatuthidden" value="" >

			  <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><?= __("Modifier nuitée ou période (ex: semaine)") ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				
			  </div>
        <center><span id='erreurLabelEdit' class="error_formul"><?= __("Veuillez saisir un prix par nuitée !") ?></span></center>
        <center><span id='erreurLabelEditnul' class="error_formul"><?= __("Veuillez saisir un prix par nuitée > 0€ !") ?></span></center>
			  <div class="modal-body">
				  <div class="form-group form-row">
					<label for="title" class="col-sm-4 control-label"><?= __("Statut ") ?></label>
					<div class="col-sm-8">
            <select name="statut" class="form-control custom-select" id="statut">
                <option value="0"><?= __("Libre") ?></option>
                <option value="50"><?= __("Option") ?></option>
                <option value="90"><?= __("Réservé") ?></option>
            </select>
					</div>
				  </div>
          <div class="form-group form-row">
 					<label for="start" class="col-sm-4 control-label"><?= __("Début") ?></label>
 					<div class="col-sm-8">
 					  <input type="text" name="dbt_at" class="form-control calendrier" id="dbt_at" readonly="readonly">
 					</div>
 				  </div>
 				  <div class="form-group form-row">
 					<label for="end" class="col-sm-4 control-label"><?= __("Fin") ?></label>
 					<div class="col-sm-8">
 					  <input type="text" name="fin_at" class="form-control calendrier" id="fin_at" readonly="readonly">
 					</div>
 				  </div>
          <div class="form-group form-row">
          <label for="end" class="col-sm-4 control-label"><?= __("Durée minimum séjour (nuitée)") ?></label>
          <div class="col-sm-8">
            <input type="number" name="nbr_jour" class="form-control" min="1" value="1" id="nbr_jour" >
          </div>
          </div>
          <div class="form-group form-row text-medium" id="condition7edit">
            
            <label class="col-md-2 control-label" ><?= __("Condition") ?></label>
            <div class="col-sm-3 form-check ml-3 ml-md-0">
                
                  <input type="radio" class="form-check-input" name="condition7" id="_0edit" value="0" size="auto">
                  <label class="form-check-label"><span><?= __("durée minimum") ?></span>
                </label>
            </div>
            <div class="col-sm-4 form-check ml-3 ml-md-0">
                
                  <input type="radio" class="form-check-input" name="condition7" value="1" size="auto" id="condition1">
                  <label class="form-check-label"><span><?= __("samedi au samedi") ?></span>
                </label>
            </div>
    		<div class="col-sm-4 col-md-3 form-check ml-3 ml-md-0">
                
                  <input type="radio" class="form-check-input" name="condition7" value="2" size="auto" id="condition2">
                  <label class="form-check-label"><span><?= __("dimanche au dimanche") ?></span>
                </label>
            </div>
          </div>
          <div id="formprixjour" class="form-group form-row">
          <label for="end" class="col-sm-4 control-label"><?= __("Prix /nuitée") ?> (€)</label>
          <div class="col-sm-8">
            <input type="text" name="prix_jour" class="form-control" id="prix_jour" autocomplete="off" onKeyUp='CalculerMontantEdit()' onchange='this.value=(number_format(this.value, 2, ".", "")).replace(" €", "")+" €"' >
          </div>
          </div>
          <div id="formpromojour" class="form-group form-row">
          <label for="end" class="col-sm-4 control-label"><?= __("Prix promotion /nuitée") ?> (€)</label>
          <div class="col-sm-8">
            <input type="text" name="promo_jour" class="form-control" id="promo_jour" autocomplete="off" onKeyUp='CalculerMontantPromoEdit()' onchange='this.value=(number_format(this.value, 2, ".", "")).replace(" €", "")+" €"'>
          </div>
          </div>
          <div class="form-group form-row">
 					<label for="end" class="col-sm-4 control-label"><?= __("Prix /période") ?> (€)</label>
 					<div class="col-sm-8">
 					  <input type="text" name="prix" class="form-control" id="prix" autocomplete="off" onKeyUp='CalculerMontantPeriodeEdit()' onchange='this.value=(number_format(this.value, 2, ".", "")).replace(" €", "")+" €"' >
 					</div>
 				  </div>
          <div class="form-group form-row">
 					<label for="end" class="col-sm-4 control-label"><?= __("Prix promotion /période") ?> (€)</label>
 					<div class="col-sm-8">
 					  <input type="text" name="promo_px" class="form-control" id="promo_px" autocomplete="off" onKeyUp='CalculerMontantPromoPeriodeEdit()' onchange='this.value=(number_format(this.value, 2, ".", "")).replace(" €", "")+" €"'>
 					</div>
 				  </div>

			  </div>
			  <div class="row justify-content-end m-3">
        <button type="button" id="supprimebtn" class="btn btn-danger left" onclick="supprimerCalend()"><?= __("Supprimer") ?></button>
        <div class="right">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Fermer") ?></button>
				<button type="submit" name="valider" value="Valider" id="valider" class="btn btn-blue text-white rounded-0"><?= __("Modifier") ?></button>
      </div>
			  </div>
        <?php echo $this->Form->end();?>
			</div>
		  </div>
		</div>

    <!-- Modal Ajout periode-->
    <div class="modal fade" id="Modaladd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <?php echo $this->Form->create(null,['id'=>'addModel','class'=>'form-horizontal','url' => ['controller' => 'Dispos', 'action' => 'calendarAdd'],'onsubmit'=>'return validateForm()']);?>
      <input type="hidden" name="annonce_id" id="annonce_id" value="<?php echo $annonce_id ?>" >

      <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel"><?= __("Ajouter nuitée ou période (ex: semaine)") ?></h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      
      </div>
      <center><span id='erreurLabel' class="error_formul"><?= __("Veuillez saisir un prix par nuitée !") ?></span></center>
      <center><span id='erreurLabeldebut' class="error_formul"><?= __("Le début d'une période valide ne doit pas être à une date passée !") ?></span></center>
      <center><span id='erreurLabeladdnul' class="error_formul"><?= __("Veuillez saisir un prix par nuitée > 0€ !") ?></span></center>

      <div class="modal-body">

        <div class="form-row form-group">
        <label for="title" class="col-sm-4 control-label"><?= __("Statut ") ?></label>
        <div class="col-sm-8">
          <select name="statut" class="form-control custom-select" id="statut">
              <option value="0"><?= __("Libre") ?></option>
              <option value="50"><?= __("Option") ?></option>
              <option value="90"><?= __("Réservé") ?></option>
          </select>
        </div>
        </div>
        <div class="form-row form-group" id="formdebut">
        <label for="start" class="col-sm-4 control-label"><?= __("Début") ?></label>
        <div class="col-sm-8">
          <input type="text" name="dbt_at" class="form-control calendrier" id="dbtat" readonly="readonly">
        </div>
        </div>
        <div class="form-row form-group">
        <label for="end" class="col-sm-4 control-label"><?= __("Fin") ?></label>
        <div class="col-sm-8">
          <input type="text" name="fin_at" class="form-control calendrier" id="finat" readonly="readonly">
        </div>
        </div>
        <div class="form-row form-group">
        <label for="end" class="col-sm-4 control-label"><?= __("Durée minimum séjour (nuitée)") ?></label>
        <div class="col-sm-8">
          <input type="number" name="nbr_jour" class="form-control" min="1" value="1" id="nbr_jour" >
        </div>
        </div>
        <div class="form-row form-group text-medium" id="condition7add">
          
          <label class="col-md-2 control-label" ><?= __("Condition") ?></label>
          <div class="col-sm-3 form-check ml-3 ml-md-0" style="">
              
                <input type="radio" class="form-check-input" name="condition7" id="_0" value="0" size="auto" checked>
                <label class="form-check-label"><span><?= __("durée minimum") ?></span>
              </label>
          </div>
          <div class="col-sm-4 form-check ml-3 ml-md-0">
              
                <input type="radio" class="form-check-input" name="condition7" value="1" size="auto">
                <label class="form-check-label"><span><?= __("samedi au samedi") ?></span>
              </label>
          </div>
  		<div class="col-sm-4 col-md-3 form-check ml-3 ml-md-0">
              
                <input type="radio" class="form-check-input" name="condition7" value="2" size="auto">
                <label class="form-check-label"><span><?= __("dimanche au dimanche") ?></span>
              </label>
          </div>
        </div>
        <div id="formprixjour" class="form-row form-group">
        <label for="end" class="col-sm-4 control-label"><?= __("Prix /nuitée") ?> (€)</label>
        <div class="col-sm-8">
          <input type="text" name="prix_jour" class="form-control" id="prix_jour" autocomplete="off" onKeyUp='CalculerMontant()' onchange='this.value=(number_format(this.value, 2, ".", "")).replace(" €", "")+" €"'>
        </div>
        </div>
        <div id="formpromojour" class="form-row form-group">
        <label for="end" class="col-sm-4 control-label"><?= __("Prix promotion /nuitée") ?> (€)</label>
        <div class="col-sm-8">
          <input type="text" name="promo_jour" class="form-control" id="promo_jour" autocomplete="off" onKeyUp='CalculerMontantPromo()' onchange='this.value=(number_format(this.value, 2, ".", "")).replace(" €", "")+" €"'>
        </div>
        </div>
        <div class="form-row form-group">
        <label for="end" class="col-sm-4 control-label"><?= __("Prix /période") ?> (€)</label>
        <div class="col-sm-8">
          <input type="text" name="prix" class="form-control" id="prix" autocomplete="off" onKeyUp='CalculerMontantPeriode()' onchange='this.value=(number_format(this.value, 2, ".", "")).replace(" €", "")+" €"'>
        </div>
        </div>
        <div class="form-row form-group">
        <label for="end" class="col-sm-4 control-label"><?= __("Prix promotion /période") ?> (€)</label>
        <div class="col-sm-8">
          <input type="text" name="promo_px" class="form-control" id="promo_px" autocomplete="off" onKeyUp='CalculerMontantPromoPeriode()' onchange='this.value=(number_format(this.value, 2, ".", "")).replace(" €", "")+" €"'>
        </div>
        </div>

      </div>
      <div class="row justify-content-end m-3">
      <button type="button" class="btn btn-default rounded-0 mr-3" data-dismiss="modal"><?= __("Fermer") ?></button>
      <button type="submit" name="valider" value="Valider" id="valider" class="btn btn-blue text-white rounded-0"><?= __("Ajouter") ?></button>
      </div>
      <?php echo $this->Form->end();?>
    </div>
    </div>
    </div>

    <!-- Modal ExportCalendar -->
    <div class="modal fade" id="ModalExportCalendar" tabindex="-1" role="dialog" aria-labelledby="ModalExportCalendarLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header"><h4 class="modal-title" id="myModalLabel"><?= __("Exporter le calendrier") ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            
          </div>
          <div class="modal-body">
            <label for="basic-url"><?= __("Copier l'URL suivant") ?> :</label>
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon3">URL</span> 
              <input type="text" class="form-control" id="urlExport" value="<?php echo $this->Url->build('/',true)?>dispos/exportical/<?php echo base64_encode($annonce_id) ?>" readonly>
            </div>
          </div>
          <div class="row justify-content-end m-3">
            <button type="button" class="btn btn-default rounded-0" data-dismiss="modal"><?= __("Fermer") ?></button>
          </div>
        </div>
      </div>
    </div>
    <!-- END Modal ExportCalendar -->
    <!-- Modal ImportCalendar -->
    <div class="modal fade" id="ModalImportCalendar" tabindex="-1" role="dialog" aria-labelledby="ModalImportCalendarLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header"><h4 class="modal-title" id="myModalLabel"><?= __("Importer un calendrier") ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            
          </div>
          <div class="modal-body">
            <label for="basic-url" class="mb-4"><?= __("Coller l'URL du calendrier à importer : <br><small>Veuillez importer le calendrier au format iCal</small>") ?></label>
            <div class="input-group mb-3">
              <span class="input-group-addon col-3" id="basic-addon3"><?= __("Nom du calendrier") ?></span> 
              <input type="text" class="form-control col-9" id="nomImport" value="">
            </div>
            <div class="input-group">
              <span class="input-group-addon col-3" id="basic-addon3">URL</span> 
              <input type="text" class="form-control col-9" id="urlImport" value="">
            </div>
          </div>
          <div class="row justify-content-end m-3">
            <button type="button" class="btn btn-default rounded-0 mr-3" data-dismiss="modal"><?= __("Fermer") ?></button>
            <button type="button" name="importer" value="importer" id="importer" class="btn btn-blue text-white rounded-0"><?= __("Importer") ?></button>
          </div>
          <?php //echo $this->Form->end();?>
        </div>
      </div>
    </div>
    <!-- END Modal ImportCalendar -->
      <?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>
<?php
    $i = 0;
    while ($i <= 12){
        $dataArrPrix[] = $listePrixSurface[$i];
        $dataArrPrixTotal[] = $listePrixSurfaceTotalNnReser[$i];
        $colorArrPrix[] = '#46a3fe';
        $colorArrPrixTotal[] = '#ff530d';
        $i++;
      }
    ?>
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
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: ["<?= __('Sep'); ?> "+(id-1), "<?= __('Oct'); ?> "+(id-1), "<?= __('Nov'); ?> "+(id-1), "<?= __('Déc'); ?> "+(id-1), "<?= __('Jan'); ?> "+id, "<?= __('Fev'); ?> "+id, "<?= __('Mar'); ?> "+id, "<?= __('Avr'); ?> "+id, "<?= __('Mai'); ?> "+id, "<?= __('Jun'); ?> "+id, "<?= __('Jul'); ?> "+id, "<?= __('Aoû'); ?> "+id]
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
           //text: chaine,
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
        //alert("teteet");
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
                // These labels appear in the legend and in the tooltips when hovering different arcs
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
              //chaine = 'VILLAGE : ' + $("#villagechoisi").children(':selected').text() + ' / ANNEE : ' + $("#anneechoisie").children(':selected').text() + ' / SURFACE : ' + $("#surfacechoisie").children(':selected').text() + ' / DATE : ' + moment().format('LL');

//              title =  {
//                 display: true,
//                 padding: 0,
//                 text: chaine,
//               };

            }
        });
        chartprixloyer.data = dataMoisLoyer;
        chartprixloyer.options.tooltips.callbacks.afterBody = tooltips;
//        chartprixloyer.options.title = title;
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
                // These labels appear in the legend and in the tooltips when hovering different arcs
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
//        chartprixloyer.options.title = title;
        chartprixloyer.update();
    });
    //chartprixloyer.height = 500;
        function validateForm(){
          $('#addModel #formprixjour').removeClass('has-error');
          $('#addModel #formdebut').removeClass('has-error');
          console.log(document.getElementById("addModel").elements["prix_jour"].value);
          if(document.getElementById("addModel").elements["prix_jour"].value == ''){
              $('#addModel #formprixjour').addClass('has-error');
            document.getElementById("erreurLabel").style.display = 'inline-block';
            document.getElementById("erreurLabeldebut").style.display = 'none';
            document.getElementById("erreurLabeladdnul").style.display = 'none';
            return false;
          }else if(document.getElementById("addModel").elements["prix_jour"].value == '0.00 €'){
            $('#addModel #formprixjour').addClass('has-error');
            document.getElementById("erreurLabeladdnul").style.display = 'inline-block';
            document.getElementById("erreurLabel").style.display = 'none';
            document.getElementById("erreurLabeldebut").style.display = 'none';
            return false;
          }else if(parseFloat(document.getElementById("addModel").elements["prix_jour"].value) <= parseFloat(document.getElementById("addModel").elements["promo_jour"].value)){
            alert("<?php echo __("Le prix promotionnel doit etre inférieur au prix initial !"); ?>");
            document.getElementById("erreurLabel").style.display = 'none';
            document.getElementById("erreurLabeladdnul").style.display = 'none';
            document.getElementById("erreurLabeldebut").style.display = 'none';
            return false;
          }

          var dbt = document.getElementById("addModel").elements["dbtat"].value;
          var fin = document.getElementById("addModel").elements["finat"].value;
          var debut = moment(dbt,"DD-MM-YYYY");
          var fin = moment(fin,"DD-MM-YYYY");

          if($("#addModel #statut").val() == 0 && debut < moment() ){
            $('#addModel #formdebut').addClass('has-error');
            document.getElementById("erreurLabel").style.display = 'none';
            document.getElementById("erreurLabeladdnul").style.display = 'none';
            document.getElementById("erreurLabeldebut").style.display = 'inline-block';
            return false;
          }

          if($('#condition7add input[type=radio]:checked').val() == 1){
            if(moment($('#dbtat').val(),"DD-MM-YYYY").format('dddd') != "samedi"){
              alert("<?php echo __("Suivant la condition choisie, la date début doit être Samedi"); ?>");
              return false;
            }
            if(moment($('#finat').val(),"DD-MM-YYYY").format('dddd') != "samedi"){
              alert("<?php echo __("Suivant la condition choisie, la date fin doit être Samedi"); ?>");
              return false;
            }
          }

          if($('#condition7add input[type=radio]:checked').val() == 2){
            if(moment($('#dbtat').val(),"DD-MM-YYYY").format('dddd') != "dimanche"){
              alert("<?php echo __("Suivant la condition choisie, la date début doit être Dimanche"); ?>");
              return false;
            }
            if(moment($('#finat').val(),"DD-MM-YYYY").format('dddd') != "dimanche"){
              alert("<?php echo __("Suivant la condition choisie, la date fin doit être Dimanche"); ?>");
              return false;
            }
          }

          if(debut.isSame(fin)){
            alert("<?php echo __("La date fin doit être différente de la date début !"); ?>");
            document.getElementById("erreurLabel").style.display = 'none';
            document.getElementById("erreurLabeladdnul").style.display = 'none';
            document.getElementById("erreurLabeldebut").style.display = 'none';
            return false;
          }else{
            return true;
          }

        }

        function validateFormEdit(){
          $('#editModel #formprixjour').removeClass('has-error');
          console.log(document.getElementById("editModel").elements["prix_jour"].value);
          if(document.getElementById("editModel").elements["prix_jour"].value == ''){
              $('#editModel #formprixjour').addClass('has-error');
            document.getElementById("erreurLabelEdit").style.display = 'inline-block';
            return false;
          }else if(document.getElementById("editModel").elements["prix_jour"].value == '0.00 €'){
            $('#editModel #formprixjour').addClass('has-error');
            document.getElementById("erreurLabelEditnul").style.display = 'inline-block';
            return false;
          }else if(parseFloat(document.getElementById("editModel").elements["prix_jour"].value) <= parseFloat(document.getElementById("editModel").elements["promo_jour"].value)){
            document.getElementById("erreurLabelEdit").style.display = 'none';
            document.getElementById("erreurLabelEditnul").style.display = 'none';
            alert("<?php echo __("Le prix promotionnel doit etre inférieur au prix initial !"); ?>");
            return false;
          }
          var dbt = document.getElementById("editModel").elements["dbt_at"].value;
          var fin = document.getElementById("editModel").elements["fin_at"].value;
          var debut = moment(dbt,"DD-MM-YYYY");
          var fin = moment(fin,"DD-MM-YYYY");

          if($('#condition7edit input[type=radio]:checked').val() == 1){
            if(moment($('#dbt_at').val(),"DD-MM-YYYY").format('dddd') != "samedi"){
              alert("<?php echo __("Suivant la condition choisie, la date début doit être Samedi"); ?>");
              return false;
            }
            if(moment($('#fin_at').val(),"DD-MM-YYYY").format('dddd') != "samedi"){
              alert("<?php echo __("Suivant la condition choisie, la date fin doit être Samedi"); ?>");
              return false;
            }
          }

          if($('#condition7edit input[type=radio]:checked').val() == 2){
            if(moment($('#dbt_at').val(),"DD-MM-YYYY").format('dddd') != "dimanche"){
              alert("<?php echo __("Suivant la condition choisie, la date début doit être Dimanche"); ?>");
              return false;
            }
            if(moment($('#fin_at').val(),"DD-MM-YYYY").format('dddd') != "dimanche"){
              alert("<?php echo __("Suivant la condition choisie, la date fin doit être Dimanche"); ?>");
              return false;
            }
          }

          if(debut.isSame(fin)){
            alert("<?php echo __("La date fin doit être différente de la date début !"); ?>");
            document.getElementById("erreurLabel").style.display = 'none';
            document.getElementById("erreurLabeladdnul").style.display = 'none';
            return false;
          }else{
            return true;
          }

        }

        function CalculerMontant(){
          var prix = (document.getElementById("addModel").elements["prix_jour"].value).replace(" €", "");
          if(prix != '') {
            var dbt = document.getElementById("addModel").elements["dbtat"].value;
            var fin = document.getElementById("addModel").elements["finat"].value;
            var debut = moment(dbt,"DD-MM-YYYY");
            var fin = moment(fin,"DD-MM-YYYY");
            document.getElementById("addModel").elements["prix"].value = number_format(prix*(parseInt(fin.diff(debut, 'days'))), 2, '.', '')+ " €";
          }
        }

        function CalculerMontantPeriode(){
          var prix = (document.getElementById("addModel").elements["prix"].value).replace(" €", "");
          if(prix != '') {
            var dbt = document.getElementById("addModel").elements["dbtat"].value;
            var fin = document.getElementById("addModel").elements["finat"].value;
            var debut = moment(dbt,"DD-MM-YYYY");
            var fin = moment(fin,"DD-MM-YYYY");
            document.getElementById("addModel").elements["prix_jour"].value = number_format(prix/(parseInt(fin.diff(debut, 'days'))), 2, '.', '')+ " €";
          }
        }

        function CalculerMontantPromo(){
          var prix = (document.getElementById("addModel").elements["promo_jour"].value).replace(" €", "");
          if(prix != '') {
          var dbt = document.getElementById("addModel").elements["dbtat"].value;
          var fin = document.getElementById("addModel").elements["finat"].value;
          var debut = moment(dbt,"DD-MM-YYYY");
          var fin = moment(fin,"DD-MM-YYYY");
          document.getElementById("addModel").elements["promo_px"].value = number_format(prix*(parseInt(fin.diff(debut, 'days'))), 2, '.', '')+ " €";
          }
        }

        function CalculerMontantPromoPeriode(){
          var prix = (document.getElementById("addModel").elements["promo_px"].value).replace(" €", "");
          if(prix != '') {
          var dbt = document.getElementById("addModel").elements["dbtat"].value;
          var fin = document.getElementById("addModel").elements["finat"].value;
          var debut = moment(dbt,"DD-MM-YYYY");
          var fin = moment(fin,"DD-MM-YYYY");
          document.getElementById("addModel").elements["promo_jour"].value = number_format(prix/(parseInt(fin.diff(debut, 'days'))), 2, '.', '')+ " €";
          }
        }

        function CalculerMontantEdit(){
          var prix = (document.getElementById("editModel").elements["prix_jour"].value).replace(" €", "");
          if(prix != '') {
          var dbt = document.getElementById("editModel").elements["dbt_at"].value;
          var fin = document.getElementById("editModel").elements["fin_at"].value;
          var debut = moment(dbt,"DD-MM-YYYY");
          var fin = moment(fin,"DD-MM-YYYY");
          document.getElementById("editModel").elements["prix"].value = number_format(prix*(parseInt(fin.diff(debut, 'days'))), 2, '.', '')+ " €";
          }
        }

        function CalculerMontantPeriodeEdit(){
          var prix = (document.getElementById("editModel").elements["prix"].value).replace(" €", "");
          if(prix != '') {
          var dbt = document.getElementById("editModel").elements["dbt_at"].value;
          var fin = document.getElementById("editModel").elements["fin_at"].value;
          var debut = moment(dbt,"DD-MM-YYYY");
          var fin = moment(fin,"DD-MM-YYYY");
          document.getElementById("editModel").elements["prix_jour"].value = number_format(prix/(parseInt(fin.diff(debut, 'days'))), 2, '.', '')+ " €";
          }
        }

        function CalculerMontantPromoEdit(){
          var prix = (document.getElementById("editModel").elements["promo_jour"].value).replace(" €", "");
          if(prix != '') {
          var dbt = document.getElementById("editModel").elements["dbt_at"].value;
          var fin = document.getElementById("editModel").elements["fin_at"].value;
          var debut = moment(dbt,"DD-MM-YYYY");
          var fin = moment(fin,"DD-MM-YYYY");
          document.getElementById("editModel").elements["promo_px"].value = number_format(prix*(parseInt(fin.diff(debut, 'days'))), 2, '.', '')+ " €";
          }
        }

        function CalculerMontantPromoPeriodeEdit(){
          var prix = (document.getElementById("editModel").elements["promo_px"].value).replace(" €", "");
          if(prix != '') {
          var dbt = document.getElementById("editModel").elements["dbt_at"].value;
          var fin = document.getElementById("editModel").elements["fin_at"].value;
          var debut = moment(dbt,"DD-MM-YYYY");
          var fin = moment(fin,"DD-MM-YYYY");
          document.getElementById("editModel").elements["promo_jour"].value = number_format(prix/(parseInt(fin.diff(debut, 'days'))), 2, '.', '')+ " €";
          }
        }

        function supprimerCalend(){
          var id = document.getElementById("editModel").elements["ids"].value;
          var annonceID = document.getElementById("editModel").elements["annonce_id"].value;
          var r = confirm("<?php echo __('Voulez-vous supprimer cette période ?'); ?>");
          if(r){
            window.location.href = "<?php echo $this->Url->build('/',true)?>dispos/supprimerCalend/"+id+"/"+annonceID;
          }
        }

		function open_dialog_delete(id){

			$('#hdreservation').val(id);
			$('#delete').modal('show');
			}
			function delete_res(){
				$('#delete').modal( "hide" );
									$.ajax({
												async: false,
												type: "GET",
												url: "<?php echo $this->Url->build('/',true)?>dispos/delAll/"+$('#hdreservation').val(),
												success:function(xml){
													//oTable.fnDraw();
													//$('#listUtilisateur_processing').attr('style','visibility: hidden;');

												}
											});
				window.location.href = "<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['dispos']?>/view/"+$('#hdreservation').val();
			}


				    function doSubmit_Ajouter()
				    {
				        if($('#promo-yn').is(":checked"))
				        {
				            if ($('#promo-px').val()=="")
				            {
				                alert("<?php echo __("Merci de renseigner le Prix Promotion"); ?>");
				                $('#promo-px').focus();
				                return false;
				            }
							//alert($('#promo-px').val()+" "+$('#prix').val());
				            if (parseInt($('#promo-px').val())>=parseInt($('#prix').val()))
				            {
				                alert("<?php echo __("Le prix promotion doit être inférieur au prix tarif"); ?>");
				                $('#promo-px').focus();
				                return false;
				            }
				        }
				    }

            function ajouterperiode(){
              document.getElementById("erreurLabel").style.display = 'none';
              document.getElementById("erreurLabeladdnul").style.display = 'none';

              $("#Modaladd #prix_jour").css('cursor','not-allowed');
              $("#Modaladd #prix_jour").attr('title','Date fin non saisie');
              document.getElementById("addModel").elements["prix_jour"].disabled = true;
              $("#Modaladd #promo_jour").css('cursor','not-allowed');
              $("#Modaladd #promo_jour").attr('title','Date fin non saisie');
              document.getElementById("addModel").elements["promo_jour"].disabled = true;
              $("#Modaladd #nbr_jour").css('cursor','not-allowed');
              $("#Modaladd #nbr_jour").attr('title','Date fin non saisie');
              document.getElementById("addModel").elements["nbr_jour"].disabled = true;
              document.getElementById("erreurLabel").style.display = 'none';
              $('#addModel #formprixjour').removeClass('has-error');
              $('#Modaladd #prix_jour').val('');
              $('#Modaladd #prix').val('');
              $('#Modaladd #promo_jour').val('');
              $('#Modaladd #promo_px').val('');
              $('#Modaladd #finat').val('');
              $('#dbtat').datepicker('setDate', moment().add(1, 'd').format('DD-MM-YYYY'));
              $('#dbtat').datepicker('option', 'minDate', moment().add(1, 'd').format('DD-MM-YYYY'));
              $('#finat').datepicker('option', 'minDate', moment().add(1, 'd').format('DD-MM-YYYY'));
              $('#Modaladd').modal('show');
            }

            function expoterCalendar(){
              $('#ModalExportCalendar').modal('show');
            }

            function importerCalendar(){
              $('#ModalImportCalendar').modal('show');
            }


          $(document).ready(function() {

              // CSSMap;
              $("#map-europe").CSSMap({
                "size": 1280,
                "tooltips": "floating-top-center",
                "responsive": "auto",
                "fitHeight": true,
                "tapOnce": true,
                "agentsList": {
                  "enable": true,
                  "agentsListId": "#demo-agents",
                  "agentsListSpeed": 0,
                  "agentsListOnHover": true
                },
                "authorInfo": true,
                onHover: function(e){
                  var rLink = e.children("A").eq(0).attr("href"),
                  rText = e.children("A").eq(0).text(),
                  rClass = e.attr("class").split(" ")[0];
                  //alert(rText);
                }
              });
              // END OF THE CSSMap;
              var is_touch_device = function(){
                   try{
                       document.createEvent("TouchEvent");
                         return "true";
                        } catch(e){
                            return "false";
                           }
              }
              if (is_touch_device() == "true"){
                    document.getElementById("albania").innerHTML = "<?php
                      if (isset($drapeauvacance['Albanie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Albanie'])."' alt='".strtolower($drapeauvacance['Albanie'])."' /> Albanie".$tabzones['Albanie']."</h2></center>";
                      else echo "<center><h2>Albanie".$tabzones['Albanie']."</h2></center>";
                      if(isset($tabvacance['Albanie'])) {
                        echo "<table class='sansborder'>";
                        foreach ($tabvacance['Albanie'] as $key ) {
                          echo "<tr><td>";
                          echo $key;
                          echo "</td></tr>";
                      }
                    echo "</table>";
                  }  ?>";

                      document.getElementById("andorra").innerHTML = "<?php
                        if (isset($drapeauvacance['Andorre'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Andorre'])."' alt='".strtolower($drapeauvacance['Andorre'])."' /> Andorre".$tabzones['Andorre']."</h2></center>";
                        else echo "<center><h2>Andorre".$tabzones['Andorre']."</h2></center>";
                        if(isset($tabvacance['Andorre'])) {
                          echo "<table class='sansborder'>";
                          foreach ($tabvacance['Andorre'] as $key ) {
                            echo "<tr><td>";
                            echo $key;
                            echo "</td></tr>";
                        }
                      echo "</table>";
                    }  ?>";

                      document.getElementById("austria").innerHTML = "<?php
                        if (isset($drapeauvacance['Autriche'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Autriche'])."' alt='".strtolower($drapeauvacance['Autriche'])."' /> Autriche".$tabzones['Autriche']."</h2></center>";
                        else echo "<center><h2>Autriche".$tabzones['Autriche']."</h2></center>";
                        if(isset($tabvacance['Autriche'])) {
                          echo "<table class='sansborder'>";
                          foreach ($tabvacance['Autriche'] as $key ) {
                            echo "<tr><td>";
                            echo $key;
                            echo "</td></tr>";
                        }
                      echo "</table>";
                    }  ?>";

                      document.getElementById("belarus").innerHTML = "<?php
                        if (isset($drapeauvacance['Biélorussie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Biélorussie'])."' alt='".strtolower($drapeauvacance['Biélorussie'])."' /> Biélorussie".$tabzones['Biélorussie']."</h2></center>";
                        else echo "<center><h2>Biélorussie".$tabzones['Biélorussie']."</h2></center>";
                        if(isset($tabvacance['Biélorussie'])) {
                          echo "<table class='sansborder'>";
                          foreach ($tabvacance['Biélorussie'] as $key ) {
                          echo "<tr><td>";
                          echo $key;
                          echo "</td></tr>";
                        }
                      echo "</table>";
                    }  ?>";

                      document.getElementById("belgium").innerHTML = "<?php
                        if (isset($drapeauvacance['Belgique'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Belgique'])."' alt='".strtolower($drapeauvacance['Belgique'])."' /> Belgique".$tabzones['Belgique']."</h2></center>";
                        else echo "<center><h2>Belgique".$tabzones['Belgique']."</h2></center>";
                        if(isset($tabvacance['Belgique'])) {
                          echo "<table class='sansborder'>";
                          foreach ($tabvacance['Belgique'] as $key ) {
                          echo "<tr><td>";
                          echo $key;
                          echo "</td></tr>";
                        }
                      echo "</table>";
                    }  ?>";

                      document.getElementById("bosnia-and-herzegovina").innerHTML = "<?php
                        if (isset($drapeauvacance['Bosnie-Herzégovine'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Bosnie-Herzégovine'])."' alt='".strtolower($drapeauvacance['Bosnie-Herzégovine'])."' /> Bosnia et Herzegovina".$tabzones['Bosnie-Herzégovine']."</h2></center>";
                        else echo "<center><h2>Bosnie-Herzégovine".$tabzones['Bosnie-Herzégovine']."</h2></center>";
                        if(isset($tabvacance['Bosnie-Herzégovine'])) {
                          echo "<table class='sansborder'>";
                          foreach ($tabvacance['Bosnie-Herzégovine'] as $key ) {
                          echo "<tr><td>";
                          echo $key;
                          echo "</td></tr>";
                        }
                      echo "</table>";
                    }  ?>";

                      document.getElementById("bulgaria").innerHTML = "<?php
                        if (isset($drapeauvacance['Bulgarie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Bulgarie'])."' alt='".strtolower($drapeauvacance['Bulgarie'])."' /> Bulgarie".$tabzones['Bulgarie']."</h2></center>";
                        else echo "<center><h2>Bulgarie".$tabzones['Bulgarie']."</h2></center>";
                        if(isset($tabvacance['Bulgarie'])) {
                          echo "<table class='sansborder'>";
                          foreach ($tabvacance['Bulgarie'] as $key ) {
                          echo "<tr><td>";
                          echo $key;
                          echo "</td></tr>";
                        }
                      echo "</table>";
                    }  ?>";

                      document.getElementById("croatia").innerHTML = "<?php
                        if (isset($drapeauvacance['Croatie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Croatie'])."' alt='".strtolower($drapeauvacance['Croatie'])."' /> Croatie".$tabzones['Croatie']."</h2></center>";
                        else echo "<center><h2>Croatie".$tabzones['Croatie']."</h2></center>";
                        if(isset($tabvacance['Croatie'])) {
                          echo "<table class='sansborder'>";
                          foreach ($tabvacance['Croatie'] as $key ) {
                          echo "<tr><td>";
                          echo $key;
                          echo "</td></tr>";
                        }
                      echo "</table>";
                    }  ?>";

                      document.getElementById("cyprus").innerHTML = "<?php
                        if (isset($drapeauvacance['Chypre'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Chypre'])."' alt='".strtolower($drapeauvacance['Chypre'])."' /> Chypre".$tabzones['Chypre']."</h2></center>";
                        else echo "<center><h2>Chypre".$tabzones['Chypre']."</h2></center>";
                        if(isset($tabvacance['Chypre'])) {
                          echo "<table class='sansborder'>";
                          foreach ($tabvacance['Chypre'] as $key ) {
                          echo "<tr><td>";
                          echo $key;
                          echo "</td></tr>";
                        }
                      echo "</table>";
                    }  ?>";

                      document.getElementById("czech-republic").innerHTML = "<?php
                        if (isset($drapeauvacance['République tchèque'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['République tchèque'])."' alt='".strtolower($drapeauvacance['République tchèque'])."' /> République tchèque".$tabzones['République tchèque']."</h2></center>";
                        else echo "<center><h2>République tchèque".$tabzones['République tchèque']."</h2></center>";
                        if(isset($tabvacance['République tchèque'])) {
                          echo "<table class='sansborder'>";
                          foreach ($tabvacance['République tchèque'] as $key ) {
                          echo "<tr><td>";
                          echo $key;
                          echo "</td></tr>";
                        }
                      echo "</table>";
                    }  ?>";

                      document.getElementById("denmark").innerHTML = "<?php
                      if (isset($drapeauvacance['Danemark'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Danemark'])."' alt='".strtolower($drapeauvacance['Danemark'])."' /> Danemark".$tabzones['Danemark']."</h2></center>";
                      else echo "<center><h2>Danemark".$tabzones['Danemark']."</h2></center>";
                        if(isset($tabvacance['Danemark'])) {
                          echo "<table class='sansborder'>";
                          foreach ($tabvacance['Danemark'] as $key ) {
                          echo "<tr><td>";
                          echo $key;
                          echo "</td></tr>";
                        }
                      echo "</table>";
                    }  ?>";

                      document.getElementById("estonia").innerHTML = "<?php
                      if (isset($drapeauvacance['Estonie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Estonie'])."' alt='".strtolower($drapeauvacance['Estonie'])."' /> Estonie".$tabzones['Estonie']."</h2></center>";
                      else echo "<center><h2>Estonie".$tabzones['Estonie']."</h2></center>";
                        if(isset($tabvacance['Estonie'])) {
                          echo "<table class='sansborder'>";
                          foreach ($tabvacance['Estonie'] as $key ) {
                          echo "<tr><td>";
                          echo $key;
                          echo "</td></tr>";
                        }
                      echo "</table>";
                    }  ?>";

                      $("#france").append("<?php
                        if(isset($tabvacance['France'])) {
                        echo "<table class='sansborder'>";
                        foreach ($tabvacance['France'] as $key ) {
                          echo "<tr><td>";
                          echo $key;
                          echo "</td></tr>";
                        }
                      echo "</table>";
                    }  ?>");

                  document.getElementById("finland").innerHTML = "<?php
                  if (isset($drapeauvacance['Finlande'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Finlande'])."' alt='".strtolower($drapeauvacance['Finlande'])."' /> Finlande".$tabzones['Finlande']."</h2></center>";
                  else echo "<center><h2>Finlande".$tabzones['Finlande']."</h2></center>";
                    if(isset($tabvacance['Finlande'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Finlande'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("georgia").innerHTML = "<?php
                  if (isset($drapeauvacance['Géorgie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Géorgie'])."' alt='".strtolower($drapeauvacance['Géorgie'])."' /> Géorgie".$tabzones['Géorgie']."</h2></center>";
                  else echo "<center><h2>Géorgie".$tabzones['Géorgie']."</h2></center>";
                    if(isset($tabvacance['Géorgie'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Géorgie'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("germany").innerHTML = "<?php
                  if (isset($drapeauvacance['Allemagne'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Allemagne'])."' alt='".strtolower($drapeauvacance['Allemagne'])."' /> Allemagne".$tabzones['Allemagne']."</h2></center>";
                  else echo "<center><h2>Allemagne".$tabzones['Allemagne']."</h2></center>";
                    if(isset($tabvacance['Allemagne'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Allemagne'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("greece").innerHTML = "<?php
                  if (isset($drapeauvacance['Grèce'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Grèce'])."' alt='".strtolower($drapeauvacance['Grèce'])."' /> Grèce".$tabzones['Grèce']."</h2></center>";
                  else echo "<center><h2>Grèce".$tabzones['Grèce']."</h2></center>";
                    if(isset($tabvacance['Grèce'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Grèce'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("hungary").innerHTML = "<?php
                  if (isset($drapeauvacance['Hongrie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Hongrie'])."' alt='".strtolower($drapeauvacance['Hongrie'])."' /> Hongrie".$tabzones['Hongrie']."</h2></center>";
                  else echo "<center><h2>Hongrie".$tabzones['Hongrie']."</h2></center>";
                    if(isset($tabvacance['Hongrie'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Hongrie'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("iceland").innerHTML = "<?php
                  if (isset($drapeauvacance['Islande'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Islande'])."' alt='".strtolower($drapeauvacance['Islande'])."' /> Islande".$tabzones['Islande']."</h2></center>";
                  else echo "<center><h2>Islande".$tabzones['Islande']."</h2></center>";
                    if(isset($tabvacance['Islande'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Islande'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("ireland").innerHTML = "<?php
                  if (isset($drapeauvacance['Irlande'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Irlande'])."' alt='".strtolower($drapeauvacance['Irlande'])."' /> Irlande".$tabzones['Irlande']."</h2></center>";
                  else echo "<center><h2>Irlande".$tabzones['Irlande']."</h2></center>";
                    if(isset($tabvacance['Irlande'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Irlande'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("san-marino").innerHTML = "<?php
                  if (isset($drapeauvacance['Saint-Marin'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Saint-Marin'])."' alt='".strtolower($drapeauvacance['Saint-Marin'])."' /> Saint-Marin".$tabzones['Saint-Marin']."</h2></center>";
                  else echo "<center><h2>Saint-Marin".$tabzones['Saint-Marin']."</h2></center>";
                    if(isset($tabvacance['Saint-Marin'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Saint-Marin'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("italy").innerHTML = "<?php
                  if (isset($drapeauvacance['Italie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Italie'])."' alt='".strtolower($drapeauvacance['Italie'])."' /> Italie".$tabzones['Italie']."</h2></center>";
                  else echo "<center><h2>Italie".$tabzones['Italie']."</h2></center>";
                    if(isset($tabvacance['Italie'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Italie'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("kosovo").innerHTML = "<?php
                  if(isset($drapeauvacance['Kosovo'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Kosovo'])."' alt='".strtolower($drapeauvacance['Kosovo'])."' /> Kosovo".$tabzones['Kosovo']."</h2></center>";
                  else{
                    echo "<center><h2>Kosovo".$tabzones['Kosovo']."</h2></center>";
                  }
                  if(isset($tabvacance['Kosovo'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Kosovo'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("latvia").innerHTML = "<?php
                  if (isset($drapeauvacance['Lettonie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Lettonie'])."' alt='".strtolower($drapeauvacance['Lettonie'])."' /> Lettonie".$tabzones['Lettonie']."</h2></center>";
                  else echo "<center><h2>Lettonie".$tabzones['Lettonie']."</h2></center>";
                    if(isset($tabvacance['Lettonie'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Lettonie'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("liechtenstein").innerHTML = "<?php
                  if (isset($drapeauvacance['Liechtenstein'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Liechtenstein'])."' alt='".strtolower($drapeauvacance['Liechtenstein'])."' /> Liechtenstein".$tabzones['Liechtenstein']."</h2></center>";
                  else echo "<center><h2>Liechtenstein".$tabzones['Liechtenstein']."</h2></center>";
                    if(isset($tabvacance['Liechtenstein'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Liechtenstein'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("lithuania").innerHTML = "<?php
                  if (isset($drapeauvacance['Lituanie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Lituanie'])."' alt='".strtolower($drapeauvacance['Lituanie'])."' /> Lituanie".$tabzones['Lituanie']."</h2></center>";
                  else echo "<center><h2>Lituanie".$tabzones['Lituanie']."</h2></center>";
                    if(isset($tabvacance['Lituanie'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Lituanie'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("luxembourg").innerHTML = "<?php
                  if (isset($drapeauvacance['Luxembourg'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Luxembourg'])."' alt='".strtolower($drapeauvacance['Luxembourg'])."' /> Luxembourg".$tabzones['Luxembourg']."</h2></center>";
                  else echo "<center><h2>Luxembourg".$tabzones['Luxembourg']."</h2></center>";
                    if(isset($tabvacance['Luxembourg'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Luxembourg'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("macedonia").innerHTML = "<?php
                  if (isset($drapeauvacance['ex-République yougoslave de Macédoine'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['ex-République yougoslave de Macédoine'])."' alt='".strtolower($drapeauvacance['ex-République yougoslave de Macédoine'])."' /> Ex-République yougoslave de Macédoine".$tabzones['ex-République yougoslave de Macédoine']."</h2></center>";
                  else echo "<center><h2>ex-République yougoslave de Macédoine".$tabzones['ex-République yougoslave de Macédoine']."</h2></center>";
                    if(isset($tabvacance['ex-République yougoslave de Macédoine'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['ex-République yougoslave de Macédoine'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("malta").innerHTML = "<?php
                  if (isset($drapeauvacance['Malte'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Malte'])."' alt='".strtolower($drapeauvacance['Malte'])."' /> Malte".$tabzones['Malte']."</h2></center>";
                  else echo "<center><h2>Malte".$tabzones['Malte']."</h2></center>";
                    if(isset($tabvacance['Malte'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Malte'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("moldova").innerHTML = "<?php
                  if (isset($drapeauvacance['Moldavie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Moldavie'])."' alt='".strtolower($drapeauvacance['Moldavie'])."' /> Moldavie".$tabzones['Moldavie']."</h2></center>";
                  else echo "<center><h2>Moldavie".$tabzones['Moldavie']."</h2></center>";
                    if(isset($tabvacance['Moldavie'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Moldavie'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("monaco").innerHTML = "<?php
                  if (isset($drapeauvacance['Monaco'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Monaco'])."' alt='".strtolower($drapeauvacance['Monaco'])."' /> Monaco".$tabzones['Monaco']."</h2></center>";
                  else echo "<center><h2>Monaco".$tabzones['Monaco']."</h2></center>";
                    if(isset($tabvacance['Monaco'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Monaco'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("montenegro").innerHTML = "<?php
                    if(isset($drapeauvacance['Monténégro'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Monténégro'])."' alt='".strtolower($drapeauvacance['Monténégro'])."' /> Monténégro".$tabzones['Monténégro']."</h2></center>";
                    else{
                      echo "<center><h2>Monténégro".$tabzones['Monténégro']."</h2></center>";
                    }
                    if(isset($tabvacance['Monténégro'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Monténégro'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("netherlands").innerHTML = "<?php
                  if (isset($drapeauvacance['Pays-Bas'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Pays-Bas'])."' alt='".strtolower($drapeauvacance['Pays-Bas'])."' /> Pays-Bas".$tabzones['Pays-Bas']."</h2></center>";
                  else echo "<center><h2>Pays-Bas".$tabzones['Pays-Bas']."</h2></center>";
                    if(isset($tabvacance['Pays-Bas'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Pays-Bas'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("norway").innerHTML = "<?php
                  if (isset($drapeauvacance['Norvège'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Norvège'])."' alt='".strtolower($drapeauvacance['Norvège'])."' /> Norvège".$tabzones['Norvège']."</h2></center>";
                  else echo "<center><h2>Norvège".$tabzones['Norvège']."</h2></center>";
                    if(isset($tabvacance['Norvège'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Norvège'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("poland").innerHTML = "<?php
                  if (isset($drapeauvacance['Pologne'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Pologne'])."' alt='".strtolower($drapeauvacance['Pologne'])."' /> Pologne".$tabzones['Pologne']."</h2></center>";
                  else echo "<center><h2>Pologne".$tabzones['Pologne']."</h2></center>";
                    if(isset($tabvacance['Pologne'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Pologne'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("portugal").innerHTML = "<?php
                  if (isset($drapeauvacance['Portugal'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Portugal'])."' alt='".strtolower($drapeauvacance['Portugal'])."' /> Portugal".$tabzones['Portugal']."</h2></center>";
                  else echo "<center><h2>Portugal".$tabzones['Portugal']."</h2></center>";
                    if(isset($tabvacance['Portugal'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Portugal'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("romania").innerHTML = "<?php
                  if (isset($drapeauvacance['Roumanie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Roumanie'])."' alt='".strtolower($drapeauvacance['Roumanie'])."' /> Roumanie".$tabzones['Roumanie']."</h2></center>";
                  else echo "<center><h2>Roumanie".$tabzones['Roumanie']."</h2></center>";
                    if(isset($tabvacance['Roumanie'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Roumanie'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("russian-federation").innerHTML = "<?php
                  if (isset($drapeauvacance['Russie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Russie'])."' alt='".strtolower($drapeauvacance['Russie'])."' /> Russie".$tabzones['Russie']."</h2></center>";
                  else echo "<center><h2>Russie".$tabzones['Russie']."</h2></center>";
                    if(isset($tabvacance['Russie'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Russie'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("serbia").innerHTML = "<?php
                  if (isset($drapeauvacance['Serbie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Serbie'])."' alt='".strtolower($drapeauvacance['Serbie'])."' /> Serbie".$tabzones['Serbie']."</h2></center>";
                  else echo "<center><h2>Serbie".$tabzones['Serbie']."</h2></center>";
                    if(isset($tabvacance['Serbie'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Serbie'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("slovakia").innerHTML = "<?php
                  if (isset($drapeauvacance['Slovaquie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Slovaquie'])."' alt='".strtolower($drapeauvacance['Slovaquie'])."' /> Slovaquie".$tabzones['Slovaquie']."</h2></center>";
                  else echo "<center><h2>Slovaquie".$tabzones['Slovaquie']."</h2></center>";
                    if(isset($tabvacance['Slovaquie'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Slovaquie'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("slovenia").innerHTML = "<?php
                  if (isset($drapeauvacance['Slovénie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Slovénie'])."' alt='".strtolower($drapeauvacance['Slovénie'])."' /> Slovénie".$tabzones['Slovénie']."</h2></center>";
                  else echo "<center><h2>Slovénie".$tabzones['Slovénie']."</h2></center>";
                    if(isset($tabvacance['Slovénie'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Slovénie'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("spain").innerHTML = "<?php
                  if (isset($drapeauvacance['Espagne'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Espagne'])."' alt='".strtolower($drapeauvacance['Espagne'])."' /> Espagne".$tabzones['Espagne']."</h2></center>";
                  else echo "<center><h2>Espagne".$tabzones['Espagne']."</h2></center>";
                    if(isset($tabvacance['Espagne'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Espagne'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("sweden").innerHTML = "<?php
                    if (isset($drapeauvacance['Suède'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Suède'])."' alt='".strtolower($drapeauvacance['Suède'])."' /> Suède".$tabzones['Suède']."</h2></center>";
                    else{
                      echo "<center><h2>Suède".$tabzones['Suède']."</h2></center>";
                    }
                    if(isset($tabvacance['Suède'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Suède'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("switzerland").innerHTML = "<?php
                  if (isset($drapeauvacance['Suisse'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Suisse'])."' alt='".strtolower($drapeauvacance['Suisse'])."' /> Suisse".$tabzones['Suisse']."</h2></center>";
                  else echo "<center><h2>Suisse".$tabzones['Suisse']."</h2></center>";
                    if(isset($tabvacance['Suisse'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Suisse'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("turkey").innerHTML = "<?php
                  if (isset($drapeauvacance['Turquie'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Turquie'])."' alt='".strtolower($drapeauvacance['Turquie'])."' /> Turquie".$tabzones['Turquie']."</h2></center>";
                  else echo "<center><h2>Turquie".$tabzones['Turquie']."</h2></center>";
                    if(isset($tabvacance['Turquie'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Turquie'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("ukraine").innerHTML = "<?php
                  if (isset($drapeauvacance['Ukraine'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Ukraine'])."' alt='".strtolower($drapeauvacance['Ukraine'])."' /> Ukraine".$tabzones['Ukraine']."</h2></center>";
                  else echo "<center><h2>Ukraine".$tabzones['Ukraine']."</h2></center>";
                    if(isset($tabvacance['Ukraine'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Ukraine'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("united-kingdom").innerHTML = "<?php
                  if (isset($drapeauvacance['Royaume-Uni'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Royaume-Uni'])."' alt='".strtolower($drapeauvacance['Royaume-Uni'])."' /> Royaume-Uni".$tabzones['Royaume-Uni']."</h2></center>";
                  else echo "<center><h2>Royaume-Uni".$tabzones['Royaume-Uni']."</h2></center>";
                    if(isset($tabvacance['Royaume-Uni'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Royaume-Uni'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("england").innerHTML = "<?php
                  if (isset($drapeauvacance['Angleterre'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Angleterre'])."' alt='".strtolower($drapeauvacance['Angleterre'])."' /> Angleterre".$tabzones['Angleterre']."</h2></center>";
                  else echo "<center><h2>Angleterre".$tabzones['Angleterre']."</h2></center>";
                    if(isset($tabvacance['Angleterre'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Angleterre'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("isle-of-man").innerHTML = "<?php
                    if(isset($drapeauvacance['Ile de Man'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Ile de Man'])."' alt='".strtolower($drapeauvacance['Ile de Man'])."' /> Île de Man".$tabzones['Ile de Man']."</h2></center>";
                    else{
                      echo "<center><h2>Île de Man".$tabzones['Ile de Man']."</h2></center>";
                    }
                    if(isset($tabvacance['Ile de Man'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Ile de Man'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("northern-ireland").innerHTML = "<?php
                  if (isset($drapeauvacance['Irlande du Nord'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Irlande du Nord'])."' alt='".strtolower($drapeauvacance['Irlande du Nord'])."' /> Irlande du Nord".$tabzones['Irlande du Nord']."</h2></center>";
                  else echo "<center><h2>Irlande du Nord".$tabzones['Irlande du Nord']."</h2></center>";
                    if(isset($tabvacance['Irlande du Nord'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Irlande du Nord'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("scotland").innerHTML = "<?php
                    if(isset($drapeauvacance['écosse'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['écosse'])."' alt='".strtolower($drapeauvacance['écosse'])."' /> Écosse".$tabzones['écosse']."</h2></center>";
                    else{
                      echo "<center><h2>Écosse".$tabzones['écosse']."</h2></center>";
                    }
                    if(isset($tabvacance['écosse'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['écosse'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";

                  document.getElementById("wales").innerHTML = "<?php
                  if (isset($drapeauvacance['Pays de Galles'])) echo "<center><h2><img src='".$this->Url->build('/',true)."css/blank.gif' class='flag flag-".strtolower($drapeauvacance['Pays de Galles'])."' alt='".strtolower($drapeauvacance['Pays de Galles'])."' /> Pays de Galles".$tabzones['Pays de Galles']."</h2></center>";
                  else echo "<center><h2>Pays de Galles".$tabzones['Pays de Galles']."</h2></center>";
                    if(isset($tabvacance['Pays de Galles'])) {
                      echo "<table class='sansborder'>";
                      foreach ($tabvacance['Pays de Galles'] as $key ) {
                      echo "<tr><td>";
                      echo $key;
                      echo "</td></tr>";
                    }
                  echo "</table>";
                }  ?>";


            }

              $('#condition7add input[type=radio]').change(function() {
                if(this.value != 0){
                  var rest = parseInt($('#Modaladd #nbr_jour').val()) % 7;
                  if(rest != 0){
                    $('#Modaladd #nbr_jour').val(7);
                    var dbt = document.getElementById("addModel").elements["dbtat"].value;
                    var fin = document.getElementById("addModel").elements["finat"].value;
                    var debut = moment(dbt,"DD-MM-YYYY");
                    var fin = moment(fin,"DD-MM-YYYY");
                    var differencedays = parseInt(fin.diff(debut, 'days'));
                    if(differencedays <= parseInt($('#Modaladd #nbr_jour').val())){
                      $('#finat').datepicker('setDate', debut.add(parseInt($('#Modaladd #nbr_jour').val()), 'd').format('DD-MM-YYYY'));
                    }
                  }
                  CalculerMontant();
                  CalculerMontantPromo();
                }
              });
              $('#condition7edit input[type=radio]').change(function() {
                if(this.value != 0){
                  var rest = parseInt($('#ModalEdit #nbr_jour').val()) % 7;
                  if(rest != 0){
                    $('#ModalEdit #nbr_jour').val(7);
                    var dbt = document.getElementById("editModel").elements["dbt_at"].value;
                    var fin = document.getElementById("editModel").elements["fin_at"].value;
                    var debut = moment(dbt,"DD-MM-YYYY");
                    var fin = moment(fin,"DD-MM-YYYY");
                    var differencedays = parseInt(fin.diff(debut, 'days'));
                    if(differencedays <= parseInt($('#ModalEdit #nbr_jour').val())){
                      $('#fin_at').datepicker('setDate', debut.add(parseInt($('#ModalEdit #nbr_jour').val()), 'd').format('DD-MM-YYYY'));
                    }
                  }
                  CalculerMontantEdit();
                  CalculerMontantPromoEdit();
                }
              });

              $('#Modaladd #nbr_jour').change(function() {
                  var rest = parseInt($('#Modaladd #nbr_jour').val()) % 7;
                  if(rest != 0){
                    $('#_0').prop("checked", true);
                  }

                  var dbt = document.getElementById("addModel").elements["dbtat"].value;
                  var fin = document.getElementById("addModel").elements["finat"].value;
                  var debut = moment(dbt,"DD-MM-YYYY");
                  var fin = moment(fin,"DD-MM-YYYY");
                  var differencedays = parseInt(fin.diff(debut, 'days'));
                  if(differencedays <= parseInt($('#Modaladd #nbr_jour').val())){
                    $('#finat').datepicker('setDate', debut.add(parseInt($('#Modaladd #nbr_jour').val()), 'd').format('DD-MM-YYYY'));
                  }
                  CalculerMontant();
                  CalculerMontantPromo();
              });

              $('#ModalEdit #nbr_jour').change(function() {
                  var rest = parseInt($('#ModalEdit #nbr_jour').val()) % 7;
                  if(rest != 0){
                    $('#_0edit').prop("checked", true);
                  }

                  var dbt = document.getElementById("editModel").elements["dbt_at"].value;
                  var fin = document.getElementById("editModel").elements["fin_at"].value;
                  var debut = moment(dbt,"DD-MM-YYYY");
                  var fin = moment(fin,"DD-MM-YYYY");
                  var differencedays = parseInt(fin.diff(debut, 'days'));
                  if(differencedays <= parseInt($('#ModalEdit #nbr_jour').val())){
                    $('#fin_at').datepicker('setDate', debut.add(parseInt($('#ModalEdit #nbr_jour').val()), 'd').format('DD-MM-YYYY'));
                  }
                  CalculerMontantEdit();
                  CalculerMontantPromoEdit();
              });

              //document.getElementById("condition7edit").style.display = 'none';
              //document.getElementById("condition7add").style.display = 'none';
              document.getElementById("erreurLabel").style.display = 'none';
              document.getElementById("erreurLabeladdnul").style.display = 'none';
              document.getElementById("erreurLabelEdit").style.display = 'none';
              document.getElementById("erreurLabelEditnul").style.display = 'none';
              document.getElementById("erreurLabeldebut").style.display = 'none';
              <?php if(!$possible){ ?>
              $('#calendar').fullCalendar({
                locale: '<?php echo $language_header_name; ?>',
                    header: {
                      left: 'prev',
                      center: 'title',
                      right: 'next'
                    },
			             editable: false,
			             eventLimit: false, // allow "more" link when too many events
                   firstDay: 1,
                   events: {
                     url: '<?php echo $this->Url->build('/',true) ?>dispos/calendarDispo/<?php echo $annonce_id ?>/<?php echo $annonce->lieugeo_id ?>',
                     type: 'POST', // Send post data
                     error: function() {
                       alert('There was an error while fetching events.');
                     }
                   },
                   eventRender: function (event, element) {
                     if(event.nbrpersonnes){
                       element.find(".fc-title").append(" <i class='fa fa-user'></i> "+event.nbrpersonnes);
                     }
                     if(event.nbrnuitees){
                       element.find(".fc-title").append(" <img class='iconnight' src='<?php echo $this->Url->build('/',true) ?>images/icon/night.png' /> "+event.nbrnuitees);
                     }
                     if (event.title == 'Vacance') {
                       element.css({
                         'display': 'none'
                       });
                       var start = moment(event.start);
                       var end = moment(event.end);
                       while( start.format('YYYY-MM-DD') != end.format('YYYY-MM-DD') ){
                         var dataToFind = start.format('YYYY-MM-DD');
                         $("td[data-date='"+dataToFind+"'].fc-widget-content").addClass('vacance');
                         start.add(1, 'd');
                       }
                     }else if(event.title == 'Station'){
                       element.css({
                         'display': 'none'
                       });
                       var start = moment(event.start);
                       var end = moment(event.end);
                       while( start.format('YYYY-MM-DD') != end.format('YYYY-MM-DD') ){
                         var dataToFind = start.format('YYYY-MM-DD');
                         $("td[data-date='"+dataToFind+"']").addClass('Station');
                         start.add(1, 'd');
                       }
                     }
                     if(event.statut == 50){
                       element.addClass('optionafterannview');
                     }

                     if(event.statut == 90){
                       element.addClass('reserverafterannview');
                     }
                     
                     if(event.calendarsynchro_id != 0){
                       element.addClass('reservercalendarafterannview');
                     }
                   },
                   dayClick: function(date, jsEvent, view) {
                     document.getElementById("erreurLabel").style.display = 'none';
                     document.getElementById("erreurLabeladdnul").style.display = 'none';

                     $("#Modaladd #prix_jour").css('cursor','not-allowed');
                 		 $("#Modaladd #prix_jour").attr('title','Date fin non saisie');
                     document.getElementById("addModel").elements["prix_jour"].disabled = true;
                     $("#Modaladd #promo_jour").css('cursor','not-allowed');
                 		 $("#Modaladd #promo_jour").attr('title','Date fin non saisie');
                     document.getElementById("addModel").elements["promo_jour"].disabled = true;
                     $("#Modaladd #prix").css('cursor','not-allowed');
                 		 $("#Modaladd #prix").attr('title','Date fin non saisie');
                     document.getElementById("addModel").elements["prix"].disabled = true;
                     $("#Modaladd #promo_px").css('cursor','not-allowed');
                 		 $("#Modaladd #promo_px").attr('title','Date fin non saisie');
                     document.getElementById("addModel").elements["promo_px"].disabled = true;
                     $("#Modaladd #nbr_jour").css('cursor','not-allowed');
                 		 $("#Modaladd #nbr_jour").attr('title','Date fin non saisie');
                     document.getElementById("addModel").elements["nbr_jour"].disabled = true;
                     document.getElementById("erreurLabel").style.display = 'none';
                     $('#addModel #formprixjour').removeClass('has-error');
                     $('#Modaladd #prix_jour').val('');
                     $('#Modaladd #prix').val('');
                     $('#Modaladd #promo_jour').val('');
                     $('#Modaladd #promo_px').val('');
                     $('#Modaladd #finat').val('');
                     $('#finat').datepicker( "option", "minDate",moment(date.format()).add(1, 'd').format('DD-MM-YYYY'));
                     $('#dbtat').datepicker('setDate', moment(date.format()).format('DD-MM-YYYY'));
                     $('#Modaladd').modal('show');

                     /*var ch = $("td[data-date='"+date.format()+"']").attr('class');
                     var test = ch.indexOf("Station");
                     if(test == -1){
                       $('#ModalStation').modal('show');
                     }else{
                       $('#dbtat').datepicker('setDate', moment(date.format()).format('DD-MM-YYYY'));
                       $('#Modaladd').modal('show');
                     }*/

                   },
                   eventClick:  function(event, jsEvent, view) {
                     if(event.type == "extrat") return false;

                     if(event.statut == 0){
                       $('#ModalEdit #locatairehidden').val('');
                       $('#ModalEdit #defaultstatuthidden').val('');
                       $("#ModalEdit #_0edit" ).attr('disabled', false);
                       $("#ModalEdit #condition1" ).attr('disabled', false);
                       $("#ModalEdit #condition2" ).attr('disabled', false);
                       $("#ModalEdit #dbt_at").css('cursor','auto');
                       $("#dbt_at" ).datepicker({
         				                    dateFormat: "dd-mm-yy",
         				            });
                       $("#ModalEdit #fin_at").css('cursor','auto');
                       $("#fin_at" ).datepicker({
         				                    dateFormat: "dd-mm-yy",
         				            });
                       $("#ModalEdit #_0edit").css('cursor','auto');
                       $("#ModalEdit #condition1").css('cursor','auto');
                       $("#ModalEdit #condition2").css('cursor','auto');
                       $("#ModalEdit #prix_jour").css('cursor','auto');
                       document.getElementById("editModel").elements["prix_jour"].readOnly = false;
                       $("#ModalEdit #promo_jour").css('cursor','auto');
                       document.getElementById("editModel").elements["promo_jour"].readOnly = false;
                       $("#ModalEdit #nbr_jour").css('cursor','auto');
                       document.getElementById("editModel").elements["nbr_jour"].readOnly = false;
                       $("#ModalEdit #prix").css('cursor','auto');
                       document.getElementById("editModel").elements["prix"].readOnly = false;
                       $("#ModalEdit #promo_px").css('cursor','auto');
                       document.getElementById("editModel").elements["promo_px"].readOnly = false;
                       

                     document.getElementById("erreurLabelEdit").style.display = 'none';
                     document.getElementById("erreurLabelEditnul").style.display = 'none';

                     $('#ModalEdit #statut').val(event.statut);
                     $('#ModalEdit #annonce_id').val(event.annonce);
                     $('#ModalEdit #ids').val(event.id+"_"+event.annonce);
                     $('#ModalEdit #dbt_at').val(moment(event.start).format('DD-MM-YYYY'));
                     $('#fin_at').datepicker( "option", "minDate",moment(event.start).format('DD-MM-YYYY'));

                     $('#ModalEdit #fin_at').val(moment(event.end).format('DD-MM-YYYY'));
                     $('#ModalEdit #prix').val(number_format(event.prix, 2, '.', '')+" €");
                     $('#ModalEdit #promotion').val(event.promotion);
                     $('#ModalEdit #promo_px').val(number_format(event.prix_promo, 2, '.', '')+" €");
                     $('#ModalEdit #nbr_jour').val(event.nbr_jour);
                     if(event.conditionnbr == 0){
                       $('#ModalEdit #_0edit').prop('checked',true);
                     }else if(event.conditionnbr == 1){
                       $('#ModalEdit #condition1').prop('checked',true);
                     }else if(event.conditionnbr == 2){
                       $('#ModalEdit #condition2').prop('checked',true);
                     }
                     if(event.nbr_jour == 7){
                       document.getElementById("condition7edit").style.display = 'flex';
                     }
                     if(event.prix_jour == 0 && event.prix != 0){
                       var prix = (document.getElementById("editModel").elements["prix"].value).replace(" €", "");
                       var dbt = document.getElementById("editModel").elements["dbt_at"].value;
                       var fin = document.getElementById("editModel").elements["fin_at"].value;
                       var debut = moment(dbt,"DD-MM-YYYY");
                       var fin = moment(fin,"DD-MM-YYYY");
                       var resultat = prix/(parseInt(fin.diff(debut, 'days')));
                       document.getElementById("editModel").elements["prix_jour"].value = number_format(Math.round(resultat*100)/100, 2, '.', '')+" €";
                     }else{
                       $('#ModalEdit #prix_jour').val(number_format(event.prix_jour, 2, '.', '')+" €");
                     }

                     if(event.promo_jour == 0 && event.prix_promo != 0 && event.prix_promo != null){
                       var prix = (document.getElementById("editModel").elements["promo_px"].value).replace(" €", "");
                       var dbt = document.getElementById("editModel").elements["dbt_at"].value;
                       var fin = document.getElementById("editModel").elements["fin_at"].value;
                       var debut = moment(dbt,"DD-MM-YYYY");
                       var fin = moment(fin,"DD-MM-YYYY");
                       var resultat = prix/(parseInt(fin.diff(debut, 'days')));
                       $('#ModalEdit #promo_jour').val(number_format(Math.round(resultat*100)/100, 2, '.', '')+" €");
                     }else{
                       $('#ModalEdit #promo_jour').val(number_format(event.promo_jour, 2, '.', '')+" €");
                     }

                     if($('#ModalEdit #promo_jour').val() == "0.00 €"){
                       $('#ModalEdit #promo_jour').val('');
                     }
                     if($('#ModalEdit #promo_px').val() == "0.00 €"){
                       $('#ModalEdit #promo_px').val('');
                     }
                     $("#supprimebtn" ).attr('disabled', false);
                     $('#ModalEdit').modal('show');
                   }else{
                     document.getElementById("erreurLabelEdit").style.display = 'none';
                     document.getElementById("erreurLabelEditnul").style.display = 'none';

                     $('#ModalEdit #locatairehidden').val(event.locataire);
                     if($('#ModalEdit #locatairehidden').val() != ''){
                       $("#supprimebtn" ).attr('disabled', true);
                     }else{
                       $("#supprimebtn" ).attr('disabled', false);
                     }
                     $('#ModalEdit #defaultstatuthidden').val(event.statut);
                     $('#ModalEdit #statut').val(event.statut);
                     $('#ModalEdit #annonce_id').val(event.annonce);
                     $('#ModalEdit #ids').val(event.id+"_"+event.annonce);
                     $('#ModalEdit #dbt_at').val(moment(event.start).format('DD-MM-YYYY'));
                     $('#fin_at').datepicker( "option", "minDate",moment(event.start).format('DD-MM-YYYY'));

                     $('#ModalEdit #fin_at').val(moment(event.end).format('DD-MM-YYYY'));
                     $('#ModalEdit #prix').val(number_format(event.prix, 2, '.', '')+" €");
                     $('#ModalEdit #promotion').val(event.promotion);
                     $('#ModalEdit #promo_px').val(number_format(event.prix_promo, 2, '.', '')+" €");
                     $('#ModalEdit #nbr_jour').val(event.nbr_jour);
                     if(event.conditionnbr == 0){
                       $("#ModalEdit #_0edit" ).attr('disabled', false);
                       $('#ModalEdit #_0edit').prop('checked',true);
                       $("#ModalEdit #condition1" ).attr('disabled', true);
                       $("#ModalEdit #condition2" ).attr('disabled', true);
                     }else if(event.conditionnbr == 1){
                       $("#ModalEdit #condition1" ).attr('disabled', false);
                       $('#ModalEdit #condition1').prop('checked',true);
                       $("#ModalEdit #_0edit" ).attr('disabled', true);
                       $("#ModalEdit #condition2" ).attr('disabled', true);
                     }else if(event.conditionnbr == 2){
                       $("#ModalEdit #condition2" ).attr('disabled', false);
                       $('#ModalEdit #condition2').prop('checked',true);
                       $("#ModalEdit #condition1" ).attr('disabled', true);
                       $("#ModalEdit #_0edit" ).attr('disabled', true);
                     }
                     if(event.nbr_jour == 7){
                       document.getElementById("condition7edit").style.display = 'flex';
                     }
                     if(event.prix_jour == 0 && event.prix != 0){
                       var prix = (document.getElementById("editModel").elements["prix"].value).replace(" €", "");
                       var dbt = document.getElementById("editModel").elements["dbt_at"].value;
                       var fin = document.getElementById("editModel").elements["fin_at"].value;
                       var debut = moment(dbt,"DD-MM-YYYY");
                       var fin = moment(fin,"DD-MM-YYYY");
                       var resultat = prix/(parseInt(fin.diff(debut, 'days')));
                       document.getElementById("editModel").elements["prix_jour"].value = number_format(Math.round(resultat*100)/100, 2, '.', '')+" €";
                     }else{
                       $('#ModalEdit #prix_jour').val(number_format(event.prix_jour, 2, '.', '')+" €");
                     }

                     if(event.promo_jour == 0 && event.prix_promo != 0 && event.prix_promo != null){
                       var prix = (document.getElementById("editModel").elements["promo_px"].value).replace(" €", "");
                       var dbt = document.getElementById("editModel").elements["dbt_at"].value;
                       var fin = document.getElementById("editModel").elements["fin_at"].value;
                       var debut = moment(dbt,"DD-MM-YYYY");
                       var fin = moment(fin,"DD-MM-YYYY");
                       var resultat = prix/(parseInt(fin.diff(debut, 'days')));
                       $('#ModalEdit #promo_jour').val(number_format(Math.round(resultat*100)/100, 2, '.', '')+" €");
                     }else{
                       $('#ModalEdit #promo_jour').val(number_format(event.promo_jour, 2, '.', '')+" €");
                     }

                     if($('#ModalEdit #promo_jour').val() == "0.00 €"){
                       $('#ModalEdit #promo_jour').val('');
                     }
                     if($('#ModalEdit #promo_px').val() == "0.00 €"){
                       $('#ModalEdit #promo_px').val('');
                     }

                     $("#ModalEdit #dbt_at").css('cursor','not-allowed');
                     $("#dbt_at").datepicker("destroy");
                     $("#dbt_at").attr('readonly', 'readonly');
                     $("#ModalEdit #fin_at").css('cursor','not-allowed');
                     $("#fin_at").datepicker("destroy");
                     $("#fin_at").attr('readonly', 'readonly');
                     $("#ModalEdit #_0edit").css('cursor','not-allowed');
                     $("#ModalEdit #condition1").css('cursor','not-allowed');
                     $("#ModalEdit #condition2").css('cursor','not-allowed');
                     $("#ModalEdit #prix_jour").css('cursor','not-allowed');
                     document.getElementById("editModel").elements["prix_jour"].readOnly = true;
                     $("#ModalEdit #promo_jour").css('cursor','not-allowed');
                     document.getElementById("editModel").elements["promo_jour"].readOnly = true;
                     $("#ModalEdit #nbr_jour").css('cursor','not-allowed');
                     document.getElementById("editModel").elements["nbr_jour"].readOnly = true;
                     $("#ModalEdit #prix").css('cursor','not-allowed');
                     document.getElementById("editModel").elements["prix"].readOnly = true;
                     $("#ModalEdit #promo_px").css('cursor','not-allowed');
                     document.getElementById("editModel").elements["promo_px"].readOnly = true;

                     $('#ModalEdit').modal('show');
                   }
                   },
                   eventMouseover: function (data, event, view) {
                    if(data.type == "extrat") return false;

                     var cond;
                     if(data.conditionnbr == 1){
                       cond = "<strong> (<?= __('semaine commence le samedi'); ?>)</strong>" ;
                     }else if (data.conditionnbr == 2){
                       cond = "<strong> (<?= __('semaine commence le dimanche'); ?>)</strong>" ;
                     }else{
                       cond = "";
                     }

                     var labeljour;
                     if(data.nbr_jour == 1){
                       labeljour = " <?= __('nuitée'); ?> ";
                     }else{
                       labeljour = " <?= __('nuitées'); ?> ";
                     }
                     if(data.statutreservation == 0) $msginfoptionapayer = "Un locataire est en train de réserver cette période. Vous n'avez rien à faire. Vous recevrez une notification dès que le paiement aura été finalisé. Si le locataire ne finalise pas sa demande de réservation, cette option sera automatiquement libérée dans 30 minutes.<br>";
                     else $msginfoptionapayer = "";
                     if(data.color == "#ff8800" || data.color == "#f54f4f"){
                       if(data.promotion == 0){
                         tooltip = '<div class="tooltiptopicevent">' + $msginfoptionapayer + '<?= __("Locataire") ?> ' + ': <span class="nouveauprix">' + data.locataire + '</span><br><?= __("Durée minimum de séjour") ?> ' + ': <span class="nouveauprix">' + data.nbr_jour +labeljour+ cond + '</span></br>' + '<?= __("Prix/nuitée") ?> ' + ': <span class="nouveauprix">' + data.prix_jour + '€</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
                       }else{
                         tooltip = '<div class="tooltiptopicevent">' + $msginfoptionapayer + '<?= __("Locataire") ?> ' + ': <span class="nouveauprix">' + data.locataire + '</span><br><?= __("Durée minimum de séjour") ?> ' + ': <span class="nouveauprix">' + data.nbr_jour +labeljour+ cond +'</span></br>' + '<?= __("Prix/nuitée") ?> ' + ': <span class="ancienprix">' + data.prix_jour + '€</span></br>' + '<?= __("Prix promotion/nuitée") ?> ' + ': <span class="nouveauprix">' + data.promo_jour +'€</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
                       }
                     }else if(data.color == "#ff3e7a9e"){
                        tooltip = '<div class="tooltiptopicevent">' + '<?= __("Nom du calendrier") ?> ' + ': <span class="nouveauprix">' + data.calendarsynchro_nom +'</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
                     }else{
                       if(data.promotion == 0){
                         tooltip = '<div class="tooltiptopicevent">' + '<?= __("Durée minimum de séjour") ?> ' + ': <span class="nouveauprix">' + data.nbr_jour +labeljour+ cond + '</span></br>' + '<?= __("Prix/nuitée") ?> ' + ': <span class="nouveauprix">' + data.prix_jour + '€</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
                       }else{
                         tooltip = '<div class="tooltiptopicevent">' + '<?= __("Durée minimum de séjour") ?> ' + ': <span class="nouveauprix">' + data.nbr_jour +labeljour+ cond +'</span></br>' + '<?= __("Prix/nuitée") ?> ' + ': <span class="ancienprix">' + data.prix_jour + '€</span></br>' + '<?= __("Prix promotion/nuitée") ?> ' + ': <span class="nouveauprix">' + data.promo_jour +'€</span><br><?= __("Date de départ") ?> ' + ': <span class="nouveauprix">' + data.end.format('DD-MM-YYYY') +'</span></div>';
                       }
                     }


                      $("body").append(tooltip);
                      $(this).mouseover(function (e) {
                          //$(this).css('z-index', 10000);
                          $('.tooltiptopicevent').fadeIn('500');
                          $('.tooltiptopicevent').fadeTo('10', 1.9);
                      }).mousemove(function (e) {
                          $('.tooltiptopicevent').css('top', e.pageY + 10);
                          $('.tooltiptopicevent').css('left', e.pageX + 20);
                      });
                  },
                  eventMouseout: function (data, event, view) {
                    if(data.type == "extrat") return false;
                      //$(this).css('z-index', 8);

                      $('.tooltiptopicevent').remove();

                  }
		          });
            <?php }else{ ?>
              $('#calendar').fullCalendar({
                locale: '<?php echo $language_header_name; ?>',
                header: {
                      left: 'prev',
                      center: 'title',
                      right: 'next'
                    },
			             editable: false,
			             eventLimit: false, // allow "more" link when too many events
                   firstDay: 1,
              });
            <?php } ?>
              /** END Fullcalendar */
              /** Afficher Import URLs Function */
              /*function afficherimporturl(url, nom = null){                
                $.ajax({
                  type: "POST",
                  async: false,
                  dataType: 'json',
                  url: "<?php // echo $this->Url->build('/',true)?>dispos/iCalDecoder",
                  data: {iCalNom: nom, iCalUrl: url, annonce_id: <?php // echo $annonce_id ?>},
                  success:function(xml){
                    //code
                    
                  }
                });                
              }*/
              /** END Afficher Import URLs Function */
              /** Importer Urls de la base de données */
              /*$.ajax({
                type: "POST",
                async: false,
                dataType: 'json',
                url: "<?php // echo $this->Url->build('/',true)?>dispos/importical",
                data: {annonce_id: <?php // echo $annonce_id ?>},
                success:function(xml){
                  //code
                  
                }
              });*/
              /** END Importer Urls de la base de données */
              /** Click Importer */
              var events = [];
              $('#importer').click(function () {  
                  if($('#nomImport').val() != "" && $("#urlImport").val() != ""){
                    $.ajax({
                      type: "POST",
                      async: false,
                      dataType: 'json',
                      url: "<?php echo $this->Url->build('/',true)?>dispos/iCalDecoder",
                      data: {iCalNom: $('#nomImport').val(), iCalUrl: $("#urlImport").val(), annonce_id: <?php echo $annonce_id ?>},
                      success:function(xml){
                        //code
                        
                      }
                    }); 
                  }                  

                  /*$.ajax({
                    type: "POST",
                    async: false,
                    dataType: 'json',
                    url: "<?php // echo $this->Url->build('/',true)?>dispos/importical",
                    data: {urlimport: $("#urlImport").val(), annonce_id: <?php // echo $annonce_id ?>},
                    success:function(xml){
                      //code
                      console.log("xml.nouveau");
                      console.log(xml.nouveau);
                      if(xml.nouveau == 1)
                      {
                        afficherimporturl($('#urlImport').val(), $('#nomImport').val());
                      }
                    }
                  });*/

                  $('#ModalImportCalendar').modal('hide'); 
                  $("#urlImport").val("");
                  $("#nomImport").val("");
                  location.reload(true);
              });
              /** END Click Importer */

              var datelien = "<?php echo $datedajout; ?>";
              if(datelien != ""){
                datelien = moment(datelien, 'DD-MM-YYYY');
                $('#calendar').fullCalendar('gotoDate', datelien);
              }

              $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);

                    $(".menu_annon").css('display','block');

							$("#dbt_at" ).datepicker({
				                    dateFormat: "dd-mm-yy",
				            });

							$("#fin_at" ).datepicker({
				          dateFormat: "dd-mm-yy"
							});

              $("#dbtat" ).datepicker({
				                    dateFormat: "dd-mm-yy",
				            });

							$("#finat" ).datepicker({
				          dateFormat: "dd-mm-yy"
							});

              $('#dbt_at').on( "change", function() {
                  $('#fin_at').datepicker( "option", "minDate", $.datepicker.parseDate( "dd-mm-yy", this.value ) );
                  var rest = parseInt($('#ModalEdit #nbr_jour').val()) % 7;
                  if(rest != 0){
                    $('#_0edit').prop("checked", true);
                  }

                  var dbt = document.getElementById("editModel").elements["dbt_at"].value;
                  var fin = document.getElementById("editModel").elements["fin_at"].value;
                  var debut = moment(dbt,"DD-MM-YYYY");
                  var fin = moment(fin,"DD-MM-YYYY");
                  var differencedays = parseInt(fin.diff(debut, 'days'));
                  if(differencedays <= parseInt($('#ModalEdit #nbr_jour').val())){
                    $('#fin_at').datepicker('setDate', debut.add(parseInt($('#ModalEdit #nbr_jour').val()), 'd').format('DD-MM-YYYY'));
                  }

                  CalculerMontantEdit();
                  CalculerMontantPromoEdit();
      						});

              $('#fin_at').on( "change", function() {
                var rest = parseInt($('#ModalEdit #nbr_jour').val()) % 7;
                if(rest != 0){
                  $('#_0edit').prop("checked", true);
                }

                var dbt = document.getElementById("editModel").elements["dbt_at"].value;
                var fin = document.getElementById("editModel").elements["fin_at"].value;
                var debut = moment(dbt,"DD-MM-YYYY");
                var fin = moment(fin,"DD-MM-YYYY");
                var differencedays = parseInt(fin.diff(debut, 'days'));
                if(differencedays <= parseInt($('#ModalEdit #nbr_jour').val())){
                  $('#fin_at').datepicker('setDate', debut.add(parseInt($('#ModalEdit #nbr_jour').val()), 'd').format('DD-MM-YYYY'));
                }

                CalculerMontantEdit();
                CalculerMontantPromoEdit();
          			});

              $('#dbtat').on( "change", function() {
                var d = moment(this.value,"DD-MM-YYYY").add(1, 'd');
                $('#finat').datepicker( "option", "minDate", d.format('DD-MM-YYYY') );
                var rest = parseInt($('#Modaladd #nbr_jour').val()) % 7;
                if(rest != 0){
                  $('#_0').prop("checked", true);
                }

                var dbt = document.getElementById("addModel").elements["dbtat"].value;
                var fin = document.getElementById("addModel").elements["finat"].value;
                var debut = moment(dbt,"DD-MM-YYYY");
                var fin = moment(fin,"DD-MM-YYYY");
                var differencedays = parseInt(fin.diff(debut, 'days'));
                if(differencedays <= parseInt($('#Modaladd #nbr_jour').val())){
                  $('#finat').datepicker('setDate', debut.add(parseInt($('#Modaladd #nbr_jour').val()), 'd').format('DD-MM-YYYY'));
                }
                  CalculerMontant();
                  CalculerMontantPromo();
      						});

              $('#finat').on( "change", function() {
                $("#Modaladd #prix_jour").attr('title','');
                $("#Modaladd #prix_jour").css('cursor','text');
                document.getElementById("addModel").elements["prix_jour"].disabled = false;
                $("#Modaladd #promo_jour").attr('title','');
                $("#Modaladd #promo_jour").css('cursor','text');
                document.getElementById("addModel").elements["promo_jour"].disabled = false;
                $("#Modaladd #prix").attr('title','');
                $("#Modaladd #prix").css('cursor','text');
                document.getElementById("addModel").elements["prix"].disabled = false;
                $("#Modaladd #promo_px").attr('title','');
                $("#Modaladd #promo_px").css('cursor','text');
                document.getElementById("addModel").elements["promo_px"].disabled = false;
                $("#Modaladd #nbr_jour").css('cursor','text');
                $("#Modaladd #nbr_jour").attr('title','');
                document.getElementById("addModel").elements["nbr_jour"].disabled = false;
                var rest = parseInt($('#Modaladd #nbr_jour').val()) % 7;
                if(rest != 0){
                  $('#_0').prop("checked", true);
                }

                var dbt = document.getElementById("addModel").elements["dbtat"].value;
                var fin = document.getElementById("addModel").elements["finat"].value;
                var debut = moment(dbt,"DD-MM-YYYY");
                var fin = moment(fin,"DD-MM-YYYY");
                var differencedays = parseInt(fin.diff(debut, 'days'));
                if(differencedays <= parseInt($('#Modaladd #nbr_jour').val())){
                  $('#finat').datepicker('setDate', debut.add(parseInt($('#Modaladd #nbr_jour').val()), 'd').format('DD-MM-YYYY'));
                }
                if($("#Modaladd #prix_jour").val() != ''){
                  CalculerMontant();
                }
                if($("#Modaladd #promo_jour").val() != ''){
                  CalculerMontantPromo();
                }

      						});

                  oTable = $('#table_id_valid').DataTable({
                    language:{
                        "url": "<?php echo $datatable_file; ?>"
                    },
                  "iDisplayLength": 10
                  });
				    });



function number_format (number, decimals, decPoint, thousandsSep) {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
  var n = !isFinite(+number) ? 0 : +number
  var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
  var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
  var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
  var s = ''
  var toFixedFix = function (n, prec) {
    var k = Math.pow(10, prec)
    return '' + (Math.round(n * k) / k)
      .toFixed(prec)
  }
  // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || ''
    s[1] += new Array(prec - s[1].length + 1).join('0')
  }
  return s.join(dec)
}
            <?php $this->Html->scriptEnd(); ?>
