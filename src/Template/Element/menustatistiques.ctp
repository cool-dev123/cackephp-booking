<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="icon-chart"></i> Statistiques</span>
    </div>
    <ul class="nav navbar-nav">
    <?php if($InfoGes['G']['role']=="admin"): ?>
      <li <?php if($this->request->getParam('action')=='statistiquegenerale'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/statistiquegenerale">Générales</a></li>
      <li <?php if($this->request->getParam('action')=='populations'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/populations">Populations</a></li>
      <li <?php if($this->request->getParam('action')=='annoncesstatis'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/annoncesstatis">Annonces</a></li>
      <li <?php if($this->request->getParam('action')=='loyerprixmoyen'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/loyerprixmoyen">Loyer Prix Moyen</a></li>
      <li <?php if($this->request->getParam('action')=='statnuitees'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/statnuitees">Nuitées</a></li>
    <?php else: ?>
      <li <?php if($this->request->getParam('action')=='annoncesstatisgest'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/annoncesstatisgest">Annonces</a></li>
      <li <?php if($this->request->getParam('action')=='loyerprixmoyengest'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/loyerprixmoyengest">Loyer Prix Moyen</a></li>
    <?php endif; ?>
      <li <?php if($this->request->getParam('action')=='statistiquesarrivee'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/statistiquesarrivee">des Arrivées</a></li>
      <li <?php if($this->request->getParam('action')=='statistiqueproprietaire'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/statistiqueproprietaire">Propriétaires</a></li>
      <li <?php if($this->request->getParam('action')=='reservationsstatis'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/reservationsstatis">Réservations</a></li>
      <li <?php if($this->request->getParam('action')=='occupationstatis'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/occupationstatis">Taux D'occupation</a></li>
      <li <?php if($this->request->getParam('action')=='remplissagestatis'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/gestionnaires/remplissagestatis">Taux de Remplissage </a></li>
    </ul>
  </div>
</nav>
