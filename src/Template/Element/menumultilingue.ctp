<nav class="navbar navbar-deepskyblue icantSelectIt">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="navbar-brand" href="#"><i class="ti-world"></i> Multilingue</span>
    </div>
    <ul class="nav navbar-nav">
      <li <?php if($this->request->getParam('action')=='stationlanguage'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/stationlanguage">Station</a></li>
      <li <?php if($this->request->getParam('action')=='massiflanguage'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/massiflanguage">Massif</a></li>
      <li <?php if($this->request->getParam('action')=='medialanguage'):?> class="active" <?php endif; ?>><a href="<?php echo $this->Url->build('/',true)?>manager/annonces/medialanguage">Média</a></li>
      
    </ul>
  </div>
</nav>
