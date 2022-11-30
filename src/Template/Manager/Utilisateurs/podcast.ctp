<script>
jQuery(document).ready(function() {
        jQuery("#frm_model_mail").validationEngine({
                prettySelect : true,
                useSuffix: "_chzn"
        });
});
function reset_frm(){
$('#trackName').val("");
$('#trackdescription').val("");
$('#fileName').val("");
$('#trackImageURL').val("");
}
<?php if(!empty($confirm_res)): ?>
    alertMessage('success','podcast envoyé avec succès');
    setTimeout("alertHide();",5000);
<?php endif;?>
<?php if(!empty($confirm_error)): ?>
    alertMessage('error','Veuillez vérifier les input erreur d\'envoi le podcast');
    setTimeout("alertHide();",5000);
<?php endif;?>
</script>
<div class="span12 clearfix">
      <div class="row-fluid">

        <!-- Widget -->
        <div class="widget  span12 clearfix" >

            <div class="widget-header">
                <span><i class="icon-align-left"></i> Podcast alpissime </span>
            </div><!-- End widget-header -->
            <div class="widget-content">
                <?php 
                 echo $this->Form->create(null,['url'=>'/manager/utilisateurs/podcast/','id'=>'frm_model_mail','type' => 'file']);
				 
                 echo $this->Form->input('trackName',['label'=>'Titre','id'=>'trackName','templates' => ['inputContainer' => "<div class='section'>{{content}}</div>"],'class'=>'validate[required]']);
                 
				 ?>
				<div class="section">
					<label id='txtmessage'>Description :</label>
					<textarea id="trackdescription" rows="6" cols="30" name="trackdescription"  ></textarea>
				</div>
				<?php
				echo $this->Form->input('fileName',['label'=>'Fichier mp3','type'=>'file','id'=>'fileName','templates' => ['inputContainer' => "<div class='section'>{{content}}</div>"],'class'=>'validate[required]']);
				echo $this->Form->input('trackImageURL',['label'=>'Logo','type'=>'file','id'=>'trackImageURL','templates' => ['inputContainer' => "<div class='section'>{{content}}</div>"]]);
				?>
				<div class="submit">
					<input type="submit" value="Valider" style="margin-top:10px" class="uibutton icon add">
					<a class="uibutton icon special answer" href="javascript:reset_frm()">Reset</a>
				</div>
				<?php echo $this->Form->end(); ?>
		</div><!--  end widget-content -->
        </div><!-- widget  span12 clearfix-->

    </div><!-- row-fluid -->

</div><!-- widget  span12 clearfix-->
