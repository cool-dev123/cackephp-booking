<script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>js/datepicker.fr.js"></script>

<script type="text/javascript">
jQuery(document).ready(function() {
  $.datepicker.setDefaults($.datepicker.regional['fr']);

        jQuery("#frm_model_mail").validationEngine({
                prettySelect : true,
                useSuffix: "_chzn"
        });
		$.datepicker.setDefaults({
            showOn: 'button',
            buttonImage: '<?php echo $this->Url->build('/',true)?>img/calendrier.png',
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange :"-100:+0",
            dateFormat: 'dd/mm/yy'});
        $('#UtilisateurNaissance').datepicker();
});
</script>
<div class="span12 clearfix">
      <div class="row-fluid">

        <!-- Widget -->
        <div class="widget  span12 clearfix" >

            <div class="widget-header">
                <span><i class="icon-align-left"></i>  Nouveau animateur </span>
            </div><!-- End widget-header -->


            <div class="widget-content">
                <?php
                  echo $this->Form->create($utilisateur,['url'=>'/manager/utilisateurs/edit/'.$utilisateur->id,'id'=>'frm_model_mail']);
                 echo $this->Form->input('id');
                 echo $this->Form->input('nom_famille',['label'=>'Votre nom','templates' => ['inputContainer' => "<div class='section'> {{content}}</div>"],'class'=>'validate[required]']);
				 echo $this->Form->input('prenom',['label'=>'Votre prénom','templates' => ['inputContainer' => "<div class='section'> {{content}}</div>"],'class'=>'validate[required]']);
                 echo $this->Form->input('civilite',['label'=>'Civilite','templates' => ['inputContainer' => "<div class='section'> {{content}}</div>"],'type'=>'select','options'=>$l_civilites]);
				 echo $this->Form->input('adresse',['label'=>'Votre adresse','templates' => ['inputContainer' => "<div class='section'> {{content}}</div>"],'class'=>'validate[required]']);

				 echo $this->Form->input('code_postal',['label'=>'Votre code postal','templates' => ['inputContainer' => "<div class='section'> {{content}}</div>"],'class'=>'validate[required]']);
				 echo $this->Form->input('ville',['label'=>'Votre ville','templates' => ['inputContainer' => "<div class='section'> {{content}}</div>"],'class'=>'validate[required]']);
				 echo $this->Form->input('email',['label'=>'Votre courriel','templates' => ['inputContainer' => "<div class='section'> {{content}}</div>"],'class'=>'validate[required,custom[email]]']);
				 echo $this->Form->input('telephone',['label'=>'Votre téléphone','templates' => ['inputContainer' => "<div class='section'> {{content}}</div>"],'class'=>'validate[required]']);
				 echo $this->Form->input("mdp",["label"=>"Mot de passe ","type"=>"password",'templates' => ['inputContainer' => "<div class='section'> {{content}}</div>"]]);
				 echo $this->Form->input("mdp_compare",["label"=>"Saisissez le à nouveau ","type"=>"password",'templates' => ['inputContainer' => "<div class='section'> {{content}}</div>"],'class'=>'validate[equals[mdp]]']);
				 echo $this->Form->input("naissance",["label"=>"Date de naissance","type"=>"text",'templates' => ['inputContainer' => "<div class='section'> {{content}}</div>"],'class'=>'validate[required]',"id"=>"UtilisateurNaissance"]);
				 ?>
				<input type="submit" value="Enregistrer" class="uibutton icon add" 'style'='margin-top:10px'/>
				<?php
				 echo $this->Form->end();
                ?>
		</div><!--  end widget-content -->
        </div><!-- widget  span12 clearfix-->

    </div><!-- row-fluid -->

</div><!-- widget  span12 clearfix-->
