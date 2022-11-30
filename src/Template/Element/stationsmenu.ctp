<div class="row icantSelectIt">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view mt-0 pt-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="text-center button-list">
                        <a class="btn btn-<?= $this->request->getParam('action')=='stations'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/stations">Dates on/off stations</a>
                        <?php if($this->request->session()->read("Gestionnaire.info")['G']['role']!='gestionnaire'): ?>
                        <a class="btn btn-<?= $this->request->getParam('controller')=='Massif' && $this->request->getParam('action')=='index'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/massif">Gestion des Massifs</a>
                        <a class="btn btn-<?= $this->request->getParam('controller')=='Domaine' && $this->request->getParam('action')=='index'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/domaine">Gestion des Domaines</a>
                        <a class="btn btn-<?= $this->request->getParam('controller')=='Ville' && $this->request->getParam('action')=='index'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/ville/index">Gestion des Villes</a>
                        <a class="btn btn-<?= $this->request->getParam('controller')=='Stations' && in_array($this->request->getParam('action'),['index','webcams'])?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/stations/index">Gestion des Stations</a>
                        <?php endif; ?>
                        <?php if($this->request->session()->read("Gestionnaire.info")['G']['role']!='gestionnaire'): ?>
                            <a class="btn btn-<?= $this->request->getParam('controller')=='Village' && $this->request->getParam('action')=='index'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/village/index">Gestion des Villages</a>
                        <?php endif; ?>
                        <a class="btn btn-<?= $this->request->getParam('controller')=='OfficeTourisme' && $this->request->getParam('action')=='index'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/OfficeTourisme/index">Gestion des Offices</a>
                        <?php if($this->request->session()->read("Gestionnaire.info")['G']['role']!='gestionnaire'): ?>
                        <a class="btn btn-<?= $this->request->getParam('controller')=='Rmecanique' && $this->request->getParam('action')=='index'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/Rmecanique/index">Gestion des pistes</a>
                        <?php endif; ?>
                        <a class="btn btn-<?= $this->request->getParam('controller')=='Nutile' && $this->request->getParam('action')=='index'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/nutile/index">Gestion Numéros Utiles</a>
                        <?php if($this->request->session()->read("Gestionnaire.info")['G']['role']!='gestionnaire'): ?>
                            <a class="btn btn-<?= $this->request->getParam('controller')=='Partenaire' && $this->request->getParam('action')=='index'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/partenaire/index">Gestion Des Partenaires</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>