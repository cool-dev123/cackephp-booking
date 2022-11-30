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
      <span>Alpissime.com</span>
      <div class="close_me pull-right"><a  href="javascript:void(0)" id="close_windows"  class="butAcc"><img src="<?php echo $this->base?>/manager-arr/images/icon/closeme.png" /></a></div>
  </div>
  <div class="content">
    <form>
      <div class="section">
          <p></p>
		  <p></p>
          <p><?php echo $comment?></p>
		  <p></p>
		  <p></p>
      </div>
	  <div class="section last" style=' padding: 0 0 3px;'>
        <div>
			<a title="fermer" href="javascript:void(0)" class="btn btnannuler" id="recherche_annuler">Fermer</a>
		</div>
      </div>
        
    </form>
  </div>
</div>