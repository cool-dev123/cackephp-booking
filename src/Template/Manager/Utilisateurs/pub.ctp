<style>
#flashMessage{
margin-left:377px;
}
div.texte {
margin-left:10px;
}
div.file label{
margin-left:-75px;
} 
label{
width:122px !important;
}
</style>
<div style="padding-top:30px;">
<?$session->flash()?>


<div class="sectioncentre">
    <div class="cadrecentre" style="margin-left:126px;line-height:28px;min-height:2008px;">
    <div class="loc_bondeau_top" style='width:101%;'>
		<div class="bondeau_top"></div>
			<div class="bondeau_content">S&eacute;l&eacute;ctionnez votre Publicit&eacute;</div>
		<div class="bondeau_footer"></div>
	</div>
	<div style='width:100%;float:left;margin-top:10px'>
	<form action="" method="post" enctype="multipart/form-data">
		<fieldset>
			<ul>
				<li>
					<?php echo $form->labelTag('Image/images', 'Image(png,jpeg,jpg,Gif)/SWF:',array('style'=>'margin-left:-75px') );?>
				   <label >Image(png,jpeg,jpg,Gif)/SWF:</label>
					<?=$form->input('image',array('type'=>'file','label'=>false,'value'=>$image['Image']['image']));?>
				</li>
			</ul>
		</fieldset>
		<div style='width:100%;float:left'><label style="margin-left:20px;">Entrez votre Texte</label></div>
		<div style='width:100%;float:left;'><?=$form->input('text',array('label'=>false,'type'=>'texte','value'=>$image['Image']['text'],'id'=>'elmt'));?></div>
	   <center><label style="margin-left:1px;">Ajouter lien  :</label>
	 <?=$form->input('lien',array(
						'label'=>false,'size'=>60,'style'=>"width:485px",'value'=>$image['Image']['lien']));?>
		<p><input type="submit" name="add" value="Valider" class="submit_reserv" /></p></center>
	</form>

	<table>

	<?php foreach($images as $image){?>
	<tr><td><?php  if(preg_match('/gif/',$image['Image']['image'])||preg_match('/png/',$image['Image']['image'])||preg_match('/jpg/',$image['Image']['image'])||preg_match('/jpeg/',$image['image'])){?>
	<img src="<?php echo $this->base?>/img/uploads/<?php echo $image['Image']['image'];?>" /> 

	<?php }else{?><object  classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"><param name="allowScriptAccess" value="sameDomain" width="536" height="280" /><param name="allowFullScreen" value="false" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><param name="src" value="/img/uploads/<?php echo $image['Image']['image']?>" /><param name="pluginspage" value="http://www.macromedia.com/go/getflashplayer" /><embed  type="application/x-shockwave-flash" src="/img/uploads/<?php echo $image['Image']['image']?>" width="536" height="280" allowScriptAccess="sameDomain" allowFullScreen="false" quality="high" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object><?php }?></td></tr>
	<tr><td><a onclick="return(confirm('Êtes-vous s&ucirc;r de vouloir supprimer cette publicit&eacute;?'));" href="<?php $this->base;?>/admin/annonces/supprimerimage/<?php echo $image['Image']['id'];?>" style="float:left"><img src="<?=$this->base;?>/images/delete.png" alt="" title=""/>Supprimer</a><a  href="<?php $this->base;?>/admin/annonces/pub/<?php echo $image['Image']['id'];?>" style="float:right"><img src="<?=$this->base;?>/images/edit.png" alt="" title=""/>Modifier</a></td></tr>
	<?php }?>
	</table>
	<p style="margin-top:10px;">
    <a href="<?php echo $this->base;?>/admin/annonces/pub">     <img src="<?=$this->base;?>/images/add.png" alt="" title=""/>Ajouter Publicit&eacute;</a>
    </p>
	</div>
</div>
</div>

<div class="span12 clearfix">
      <div class="row-fluid">

        <!-- Widget -->
        <div class="widget  span12 clearfix" >

            <div class="widget-header">
                <span><i class="icon-align-left"></i> S&eacute;l&eacute;ctionnez votre Publicit&eacute;</span>
            </div><!-- End widget-header -->


            <div class="widget-content">
				<form action="" method="post" enctype="multipart/form-data">
                <?php 
                 echo $form->input('image',array('type'=>'file','label'=>'Image(png,jpeg,jpg,Gif)/SWF:','div'=>'section','value'=>$image['Image']['image']));
                 
                 echo $form->input('lien',array('type'=>'text','label'=>'Ajouter lien:','div'=>'section','value'=>$image['Image']['lien']));
				 
				 echo $form->input('text',array('label'=>'Ajouter lien:','div'=>'section','type'=>'texte','value'=>$image['Image']['text'],'id'=>'elmt')); 
				 
				 echo $form->end(array('label'=>'Valider','type'=>'submit','class'=>'uibutton icon add','style'=>'margin-top:10px'));
                ?>
		</div><!--  end widget-content -->
        </div><!-- widget  span12 clearfix-->

    </div><!-- row-fluid -->

</div><!-- widget  span12 clearfix-->