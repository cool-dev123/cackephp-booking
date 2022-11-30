<?php

 /*
 echo '<pre>';
 print_r($reservation);
 echo '</pre>';
 */
 ?>
 <script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>js/datepicker.fr.js"></script>

 <script type="text/javascript">
    $(function() {
      $.datepicker.setDefaults($.datepicker.regional['fr']);

    $("#dbt_at").datepicker({ dateFormat: "dd-mm-yy"});
	});
</script>
<div class="modal_dialog">
  <div class="header">
      <span>Envoi mail ver le propriétaire</span>
      <div class="close_me pull-right"><a  href="javascript:void(0)" id="close_windows"  class="butAcc"><img src="<?php echo $this->Url->build('/',true)?>manager-arr/images/icon/closeme.png" /></a></div>
  </div>
  <div class="content">
    <form>
	  <div class="section">
          <label style="width:20%"> De</label>
          <div>
		  	  <input type="text" class="full" id="from" value="<?php echo $mail_gest?>"  >
		  </div>
      </div>
      <div class="section">
          <label style="width:20%"> À</label>
          <div>
		  	  <input type="text" class="full" id="to" value="<?php echo $mail_prop?>"  >
		  </div>
      </div>
      <div class="section">
          <label style="width:20%"> Objet</label>
          <div>
		  <input type="text" class="full" id="sujet">
		  </div>
      </div>

	  <div class="section">
          <label style="width:20%"> Message</label>
          <div>
		  <textarea  id="comment" style="width:311px;" rows=10 cols=3></textarea>
		  </div>
      </div>
	  <div class="section last">
        <div>
		<a title="Modification" href="javascript:void(0)" class="btn" id="recherche_res">Envoyer</a>
		<a title="Modification" href="javascript:void(0)" class="btn btnannuler" id="recherche_annuler">Annuler</a>
		</div>
      </div>
    </form>
  </div>
</div>
