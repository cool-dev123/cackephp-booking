<div class="row icantSelectIt">
    <div class="col-sm-12">
        <!--- ARRIVEES --->
        <div class="panel panel-default card-view mt-0 pt-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="text-center button-list">
                        <a class="btn btn-<?= $this->request->getParam('controller')=='Cautions' && $this->request->getParam('action')=='index'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/cautions/index">Cautions</a>
                        <a class="btn btn-<?= $this->request->getParam('controller')=='Paiements' && $this->request->getParam('action')=='index'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/paiements/index">Paiements</a>
                        <a class="btn btn-<?= $this->request->getParam('controller')=='Annulations' && $this->request->getParam('action')=='index'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/annulations/index">Annulations</a>

                        <a class="btn btn-<?= $this->request->getParam('controller')=='Propresidence' && $this->request->getParam('action')=='index'?'success':'default' ?> mt-5" href="<?php echo $this->Url->build('/',true)?>manager/propresidence/index">Gestion Règle-Propriétaire</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>