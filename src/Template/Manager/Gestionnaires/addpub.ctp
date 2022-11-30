<script type="text/javascript">
jQuery(document).ready(function() {
        jQuery("#FrmGestionnaire").validationEngine({
                prettySelect : true,
                useSuffix: "_chzn"
        });
});
</script>
<div  class="span12 clearfix">
      <div class="row-fluid">

        <!-- Widget -->
        <div class="widget  span12 clearfix" >

            <div class="widget-header">
                <span><i class="icon-align-left"></i>  Séléctionnez votre Publicité </span>
            </div><!-- End widget-header -->


            <div class="widget-content">
				<form action="/manager/gestionnaires/addpub/" id="FrmGestionnaire" method="post" enctype="multipart/form-data">
                <?php 
                 echo $this->Form->input('image',['type'=>'file','label'=>'Image(png,jpeg,jpg,Gif):','templates' => ['inputContainer' => "<div class='section'>{{content}}</div>"],'class'=>'validate[required]']);
                 
                 echo $this->Form->input('lien',['type'=>'text','label'=>'Ajouter lien:','templates' => ['inputContainer' => "<div class='section'>{{content}}</div>"],'class'=>'validate[required]']);
				 
				echo $this->Form->input('titre',['type'=>'text','label'=>'Titre','templates' => ['inputContainer' => "<div class='section'>{{content}}</div>"],'class'=>'validate[required]']); 
				?>
				<div class="section"> 
				<label for="titre">Situation géographique :</label>
				  <select  name="lieugeo[]" class="chzn-select " multiple tabindex="4">
					<option value=""></option> 
					<?php foreach($enrs as $lieu):?>
					<option value="<?php echo $lieu->id?>"><?php echo $lieu->name?></option> 
					<?php endforeach;?>
				  </select>
				 </div>
				<input type="submit" class="uibutton icon add" style="margin-top:10px" value="Valider"/>
				<?php
				 echo $this->Form->end();
                ?>
		</div><!--  end widget-content -->
        </div><!-- widget  span12 clearfix-->

    </div><!-- row-fluid -->

</div><!-- widget  span12 clearfix-->