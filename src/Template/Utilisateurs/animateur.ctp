<script>
function reset_frm(){
$('#trackName').val("");
$('#trackdescription').val("");
$('#fileName').val("");
$('#trackImageURL').val("");
}
</script>
<div style="padding-top:30px;">

<div class="sectiondroite ">
	<?php echo $this->element("mon_compte")?>
	
</div>
<div class="sectioncentre">
    <div class="cadrecentre adm_right">
        <div id="content_left" >
			<div class="loc_bondeau_top" style='width:101%;'>
				<div class="bondeau_top"></div>
				<div class="bondeau_content">
					Podcast alpissime
				</div>
				<div class="bondeau_footer"></div>
			</div>
		</div>
		<div><?php echo $this->Flash->render()?></div>
		<div style='width:80%;float:left;margin-top:10px'>
			<form action="" method="post" enctype="multipart/form-data">
				<fieldset>
					<ul>
						<li style='padding:5px 0;'>
							<label style="margin-left:-31px;width:48px;padding:5px 0;">Titre :</label>
							<?php echo $this->Form->input('trackName',['label'=>false,'id'=>'trackName']);?>
						</li>
						<li style='padding:5px 0;'>
							<label style="margin-left:-40px;width:100px;">Description :</label>
							<?php echo $this->Form->textarea('trackdescription',['label'=>false,'id'=>'trackdescription']);?>
						</li>
						<li style='padding:5px 0;'>
							<label style="margin-left:-35px;width:100px;padding:5px 0;">Fichier mp3 :</label>
							<?php echo $this->Form->input('fileName',['type'=>'file','label'=>false,'id'=>'fileName']);?>
						</li>
						<li style='padding:5px 0;'>
							<label style="margin-left:-35px;width:100px;padding:5px 0;">Logo :</label>
							<?php echo $this->Form->input('trackImageURL',['type'=>'file','label'=>false,'id'=>'trackImageURL']);?>
						</li>
					</ul>
				</fieldset>
				<p><input type="button" name="annuler" value="Reset" onclick="reset_frm();" class="submit_reserv" /> <input type="submit" name="add" value="Valider" class="submit_reserv" /></p>
			</form>
		</div>
    </div>
	
	
</div>
</div>