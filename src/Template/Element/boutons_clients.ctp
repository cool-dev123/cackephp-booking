<div id="services">
    <div class="row">
        <div class="col-md-4">
            <div class="service">
                <div class="icons">
                  <?php if ($this->Session->read('Auth.User.id')==""):?>
                    <img id="btn_add_annonce" src="<?php echo $this->Url->build('/',true)?>images/services/proprietaires.png" alt="Propriétaires">
                  <?php else :?>
                  <a href="<?php echo $this->Url->build('/',true)?>annonces/add" target="_blank"><img src="<?php echo $this->Url->build('/',true)?>images/services/proprietaires.png"/></a>
                  <?php endif;?>
                </div>
                <a href="<?php echo $this->Url->build('/',true)?>annonces/add">
                    <div class="description">
                        <div class="h2style"><?= __("Propriétaire") ?></div>
                        <span><?= __("Déposez votre annonce") ?></span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service">
                <div class="icons">
                  <a href="<?php echo $this->Url->build('/',true)?>recherche" >
                    <img src="<?php echo $this->Url->build('/',true)?>images/services/location.png" alt="Propriétaires">
                  </a>
                </div>
                <a href="<?php echo $this->Url->build('/',true)?>recherche">
                    <div class="description">
                        <div class="h2style"><?= __("Locataire") ?></div>
                        <span>Consultez les annonces Alpissime</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service">
                <div class="icons">
                  <a href="#annonces_modifiees" >
                    <img src="<?php echo $this->Url->build('/',true)?>images/services/location_vacance.png" alt="Propriétaires">
                  </a>
                </div>
                <a href="#particuliers">
                    <div class="description">
                        <div class="h2style">Location de vacances</div>
                        <span>Dernières annonces modifiées</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<!--/services-->
