<style>
select#gestionnaire {
    background: #fff;
}
</style>
    <?php echo $this->Form->create($msg,['url' => ['controller' => 'utilisateurs', 'action' => 'reponsemessageprop']]);?>

<div class="col-sm-12">
    <div class="form-group">
        <label for="">Message :</label>
        <textarea name="vMsg" id="msg_message" class="form-control" rows=6 cols=10></textarea>
        <input type="hidden" name="vTo" id="to_message" class="form-control" value="<?php echo $msg->email; ?>" readonly>
        <input type="hidden" class="full" name="vFrom" id="from_message"  value="<?php echo $this->Session->read('Auth.User.email')?>" >
        <input type="hidden" name="vTitreAn" id="annonce_titre" value="<?php echo $annonce->titre ?>">
        <input type="hidden" name="vMsgID" id="msg_id" value="<?php echo $msg->id ?>">
        <input type="hidden" name="vIDAn" id="annonce_id" value="<?php echo $annonce->id ?>">        
    </div>
</div>

<div class="section last" style=' padding: 0 20px 3px;'>
  <div>
      <button type="submit" title="Modification" class="btn btn-success hvr-sweep-to-top  right" id="send_message_mail_old"><?= __("Envoyer") ?></button>
    <a title="Modification" href="javascript:void(0)" class="btn btn-retour left" id="envoi_message_annuler">Annuler</a>
  </div>
</div>
<?php echo $this->Form->end();?>

<script>
$("#send_message_mail").on('click',function() {
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Url->build('/')?>utilisateurs/setmessage/",
			data:{vTo:$('#to_message').val(), vFrom:$('#from_message').val(), vMsg:$('#msg_message').val(), vTitreAn:$('#annonce_titre').val(), vIDAn:$('#annonce_id').val(), vMsgID:$('#msg_id').val()},
			success:function(xml){
				//alert(xml)
					$('#repondremessage').modal('hide');

				}
			});
});
$("#envoi_message_annuler").on('click',function() {
  $('#objet').val('');
  $('#msg').val('');
	$('#repondremessage').modal('hide');
  // $('#plusdetails').modal('show');
});
</script>
