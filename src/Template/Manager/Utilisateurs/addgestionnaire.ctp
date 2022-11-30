<script type="text/javascript">
jQuery(document).ready(function() {
        jQuery("#FrmGestionnaire").validationEngine({
                prettySelect : true,
                useSuffix: "_chzn"
        });
});
<?php if(!empty($confirm_res)): ?>
    alertMessage('success','vous avez bien créé un nouveau gestionnaire');
    setTimeout("alertHide();",5000);
<?php endif;?>
</script>
<div class="span12 clearfix">
      <div class="row-fluid">

        <!-- Widget -->
        <div class="widget  span12 clearfix" >

            <div class="widget-header">
                <span><i class="icon-align-left"></i>  Ajouter gestionnaire </span>
            </div><!-- End widget-header -->


            <div class="widget-content">
                <?php 
                 echo $form->create('Gestionnaire',array("id"=>"FrmGestionnaire","url"=>"/manager/utilisateurs/addgestionnaire/"));
                 echo $form->input('role',array('type'=>'select','label'=>"Role",'div'=>'section','options'=>array('gestionnaire'=>'Gestionnaire','admin'=>'Admin',"superAdmin"=>"Super admin")));
                 echo $form->input('name',array('label'=>'Nom du gestionnaire','div'=>'section','class'=>'validate[required]'));
                 echo $form->input('login',array('label'=>'Login','div'=>'section','class'=>'validate[required]'));
				 echo $form->input('email',array('label'=>'Courriel','div'=>'section','class'=>'validate[required,custom[email]]'));
				 ?>
				<div class="section">
				<label for="GestionnaireEmail">Adresse</label>
				<?php echo $form->textarea('adresse',array('label'=>'Adresse','div'=>'section','class'=>'validate[required]'));?>
				</div>
				<?php
				 echo $form->input('adresse',array('label'=>'Courriel','div'=>'section','class'=>'validate[required]'));
				 echo $form->input('telephone',array('label'=>'Téléphone','div'=>'section','class'=>'validate[required]'));
				 echo $form->input('password',array('label'=>'Mot de passe',"type"=>"password",'div'=>'section','class'=>'validate[required]'));
				 echo $form->input('pass2',array('label'=>'Saisissez le à nouveau',"type"=>"password",'div'=>'section','class'=>'validate[required,equals[GestionnairePassword]]'));
				 echo $form->input('commission_maint',array('label'=>'Commission maintenance','div'=>'section','class'=>'validate[required]'));
				 echo $form->input('commission_sejour',array('label'=>'Commission gestion de séjour','div'=>'section','class'=>'validate[required]'));
				 echo $form->input('commission_relation',array('label'=>'Commission mise en relation','div'=>'section','class'=>'validate[required]'));
				 echo $form->end(array('label'=>'Enregistrer','type'=>'submit','class'=>'uibutton icon add','style'=>'margin-top:10px'));
                ?>
		</div><!--  end widget-content -->
        </div><!-- widget  span12 clearfix-->

    </div><!-- row-fluid -->

</div><!-- widget  span12 clearfix-->
		