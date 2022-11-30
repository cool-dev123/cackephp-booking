<?php
/*
 *
 
 echo '<pre>';
 print_r($user);
 echo '</pre>';
 */
 ?>
<div class="modal_dialog">
  <div class="header">
      <span>Fiche Publicité</span>
      <div class="close_me pull-right"><a  href="javascript:void(0)" id="close_windows"  class="butAcc"><img src="<?php echo $this->Url->build('/',true)?>manager-arr/images/icon/closeme.png" /></a></div>
  </div>
  <div class="content">
    <form>
      <div class="section">
          <label> Titre</label>
          <div><?php echo $image->titre?></div>
      </div>
      <div class="section">
          <label> Lien</label>
          <div><?php echo $image->lien?></div>
      </div>
	  <div class="section">
          <label> Lieu geographique</label>
          <div>&nbsp;<?php echo $station?></div>
      </div>
	  <div class="section last">
          
          <img width="450px" src="<?php echo $this->Url->build('/',true)?>img/uploads/<?php echo $image->image;?>" /> 
      </div>
	  
    </form>
  </div>
</div>