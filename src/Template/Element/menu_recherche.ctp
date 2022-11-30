<?php $this->Html->css("/css/update.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
    $('#location_du').datepicker({
        language: 'fr-FR',
        minDate: 0,
        dateFormat: "dd-mm-yy"
    });
    $('#location_du').on( "change", function() {
          //$('#location_du').datepicker( "option", "minDate", $.datepicker.parseDate( "dd-mm-yy", this.value ) );
          $('#location_au').datepicker( "option", "minDate", $.datepicker.parseDate( "dd-mm-yy", this.value ) );
        });
    $('#location_au').datepicker({
        language: 'fr-FR',
        minDate: 0,
        dateFormat: "dd-mm-yy"
    });
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
 $(document).ready(function () {
$(".navbar-header").css("display","block");
$.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);

          function ChangeHauteur(){
              $("#main-slide .item img").height($(".slideIndex").parent("div").height());
          }
        ChangeHauteur();
        $(window).bind("load", ChangeHauteur);



        $('#btn-reset').click(function () {

			$('#annonceRechercheForm input[type="text"]').each(function(){
				$(this).val("");
			});
			$("#uniform-promotions span").removeClass('checked');
			$("#uniform-parking span").removeClass('checked');
			$("#uniform-internet span").removeClass('checked');
			$("#uniform-drap span").removeClass('checked');
			$("#uniform-animaux span").removeClass('checked');

      $("#uniform-SamediAuSamedi span").removeClass('checked');
      $("#uniform-DimancheAuDimanche span").removeClass('checked');

			$("#uniform-AnnonceTypeLocationCHA span").removeClass('checked');
			$("#uniform-AnnonceTypeLocationAPP span").removeClass('checked');
			$("#uniform-AnnonceTypeLocationSTD span").removeClass('checked');
			$("#uniform-AnnonceTypeLocationGIT span").removeClass('checked');

			$("#uniform-AnnonceNbPiece1 span").removeClass('checked');
			$("#uniform-AnnonceNbPiece2 span").removeClass('checked');
			$("#uniform-AnnonceNbPiece3 span").removeClass('checked');
			$("#uniform-AnnonceNbPiece4 span").removeClass('checked');
			$("#uniform-AnnonceNbPiece5 span").removeClass('checked');

			$("#annonceRechercheForm :checkbox").removeAttr("checked");
			$("#annonceRechercheForm :radio").removeAttr("checked");
			$('#annonceRechercheForm select').each(function(){
				$(this).val("");
			});
        })

    });
<?php $this->Html->scriptEnd(); ?>
    <span class="search_titre"><?= __("Recherche") ?></span>
    <?php echo $this->Form->create(null,['type' => 'get','url' => ['controller' => 'annonces', 'action' => 'recherche'],'id'=>'annonceRechercheForm'])?>

        <div class='ad_search_content'>
        <div class="form-group">
        <label for="situation_geo"><?= __("Situation géographique") ?> :</label>
            <?php echo $this->Form->input("lieugeo",[
                    'label'=>false,
                    'div'=>false,
                    'type'=>'select',
					'options'=>$l_lieugeos,
					'size'=>'auto', 'class'=>'form-control', 'value'=>$this->request->query['lieugeo']])?>
        </div>
        <div class="form-group">
            <label for="location_du">Location : Du</label>
            <?php echo $this->Form->input('dbt',['value'=>$this->request->query['dbt'],'label'=>false,'readonly'=>'readonly','type'=>'text','templates' => ['inputContainer' => "{{content}}"],'id'=>'location_du', 'class'=>'form-control inline-block location'])?>
            <label for="location_au">Au</label>
            <?php echo $this->Form->input('fin',['value'=>$this->request->query['fin'],'label'=>false,'readonly'=>'readonly','type'=>'text','templates' => ['inputContainer' => "{{content}}"],'id'=>'location_au', 'class'=>'form-control inline-block location'])?>
        </div>
        <!-- <div class="form-group radios">
            <label for="type_loction">Condition :</label><br>
                <label class="radio-inline">
					      <input type="radio" value="1" id="SamediAuSamedi" <?php if($this->request->query["conditionSemaine"]==1) echo "CHECKED"?> name="conditionSemaine" style="opacity: 0;">
                  <span><?= __("samedi au samedi") ?></span>
				        </label>

                <label class="radio-inline">
					      <input type="radio" value="2" id="DimancheAuDimanche" <?php if($this->request->query["conditionSemaine"]==2) echo "CHECKED"?> name="conditionSemaine" style="opacity: 0;">
                  <span><?= __("dimanche au dimanche") ?></span>
				        </label>
        </div> -->
        <div class="form-group radios">
		<?php //print_r($this->request->query["typeLocation"]); ?>
            <label for="type_loction">Type de location :</label><br>

              <label class="radio-inline">
                  <input type="radio" value="CHA" id="AnnonceTypeLocationCHA" <?php if($this->request->query["typeLocation"]=="CHA") echo "CHECKED"?> name="typeLocation" style="opacity: 0;"/>
                  <span><?= __("Chalet") ?></span>
              </label>

                <label class="radio-inline">
					      <input type="radio" value="APP" id="AnnonceTypeLocationAPP"  <?php if($this->request->query["typeLocation"]=="APP") echo "CHECKED"?> name="typeLocation" style="opacity: 0;">
                  <span><?= __("Appartement") ?></span>
				        </label>

                <label class="radio-inline">
					      <input type="radio" value="STD" id="AnnonceTypeLocationSTD" <?php if($this->request->query["typeLocation"]=="STD") echo "CHECKED"?> name="typeLocation" style="opacity: 0;">
                  <span><?= __("Studio") ?></span>
				        </label>

                <label class="radio-inline">
					      <input type="radio" value="GIT" id="AnnonceTypeLocationGIT" <?php if($this->request->query["typeLocation"]=="GIT") echo "CHECKED"?> name="typeLocation" style="opacity: 0;">
                  <span><?= __("Gite") ?></span>
				        </label>

        </div>
        <div id="coche" class="form-group">
            <label id="label_coche" for="nbCouchage">Nombre de couchage :</label>
				<?php echo $this->Form->input("nbCouchage",[
									'label'=>false,
									'div'=>false,
									'type'=>'select',
									'options'=>[0=>"",1=>"1",2=>"2",3=>"3",4=>"4",5=>"5",6=>"6",7=>"7",8=>"8",9=>"9",10=>"10",11=>"11",12=>"12",13=>"13",14=>"14",15=>"15"],
									'size'=>'auto', 'class'=>'form-control ', 'value'=>$this->request->query['nbCouchage']])?>
        </div>
        <div class="form-group">
            <label for="surface_de">Surface (m<sup>2</sup>) : De</label>
            <?php echo $this->Form->input('surfaceDe',['value'=>$this->request->query['surfaceDe'],'label'=>false,'type'=>'text','templates' => ['inputContainer' => "{{content}}"],'id'=>'surfaceDe', 'class'=>'form-control inline-block surface'])?>
            <label for="surface_a">A</label>
            <?php echo $this->Form->input('surfaceA',['value'=>$this->request->query['surfaceDe'],'label'=>false,'type'=>'text','templates' => ['inputContainer' => "{{content}}"],'id'=>'surfaceA', 'class'=>'form-control inline-block surface'])?>
        </div>
        <div class="form-group radios">
            <label for="nombre_pieces"><?= __("Nombre de pièces") ?> :</label>
            <label class="radio-inline">
                <input type="radio" value="1" id="AnnonceNbPiece1"  <?php if($this->request->query["nbPiece"]==1) echo "CHECKED"?> name="nbPiece" style="opacity: 0;">
                <span>1 </span>
            </label>
            <label class="radio-inline">
                <input type="radio" value="2" id="AnnonceNbPiece2"  <?php if($this->request->query["nbPiece"]==2) echo "CHECKED"?> name="nbPiece" style="opacity: 0;">
                <span>2 </span>
            </label>
            <label class="radio-inline">
                <input type="radio" value="3" id="AnnonceNbPiece3"  <?php if($this->request->query["nbPiece"]==3) echo "CHECKED"?> name="nbPiece" style="opacity: 0;">
                <span>3 </span>
            </label>
            <label class="radio-inline">
                <input type="radio" value="4" id="AnnonceNbPiece4"  <?php if($this->request->query["nbPiece"]==4) echo "CHECKED"?> name="nbPiece" style="opacity: 0;">
                <span>4</span>
            </label>
            <label class="radio-inline">
                <input type="radio" value="5" id="AnnonceNbPiece5"  <?php if($this->request->query["nbPiece"]==5) echo "CHECKED"?> name="nbPiece" style="opacity: 0;">
                <span>5</span>
            </label>
        </div>
        <div class="form-group radios">
            <label for="type_loction">Budget : </label><br>
                <label class="radio-inline">
					      <input type="radio" value="1" id="prixnuitee" <?php if($this->request->query["prixbudget"]==1) echo "CHECKED"?> name="prixbudget" style="opacity: 0;">
                  <span><?= __("Prix par Nuitée") ?></span>
				        </label>

                <label class="radio-inline">
					      <input type="radio" value="2" id="prixperiode" <?php if($this->request->query["prixbudget"]==2) echo "CHECKED"?> name="prixbudget" style="opacity: 0;">
                  <span><?= __("Prix Période") ?></span>
				        </label>
                <br>
                <label for="budget"><?= __("De") ?></label>
                <?php echo $this->Form->input('budgetDe',['value'=>$this->request->query["budgetDe"],'label'=>false,'type'=>'text','templates' => ['inputContainer' => "{{content}}"],'id'=>'budgetDe', 'class'=>'form-control inline-block budget'])?>
                <label for="budget_a">A</label>
                <?php echo $this->Form->input('budgetA',['value'=>$this->request->query["budgetA"],'label'=>false,'type'=>'text','templates' => ['inputContainer' => "{{content}}"],'id'=>'budgetA', 'class'=>'form-control inline-block budget'])?>
        </div>
          <!-- <div class="form-group">
                    </div> -->
        <div class="form-group checkboxs">
          <label class="checkbox-inline">
            <?php echo $this->Form->input("promotions",[
                        'label'=>false,
                        'templates' => ['inputContainer' => "{{content}}"],
                        'type'=>'checkbox',
                        'size'=>'auto',
                        'checked'=>$this->request->query['promotions']])?>
                         <span><?= __("Promotion") ?></span>
          </label>
          <label class="checkbox-inline">
            <?php echo $this->Form->input("parking",[
    									'label'=>false,
    									'templates' => ['inputContainer' => "{{content}}"],
    									'type'=>'checkbox',
    									'size'=>'auto',
                      'checked'=>$this->request->query['parking']])?>
                         <span><?= __("Parking") ?></span>
          </label>
          <label class="checkbox-inline">
            <?php echo $this->Form->input("internet",[
    									'label'=>false,
    									'templates' => ['inputContainer' => "{{content}}"],
    									'type'=>'checkbox',
    									'size'=>'auto',
                      'checked'=>$this->request->query['internet']])?>
                         <span><?= __("Internet") ?></span>
          </label>
          <label class="checkbox-inline">
            <?php echo $this->Form->input("drap",[
    									'label'=>false,
    									'templates' => ['inputContainer' => "{{content}}"],
    									'type'=>'checkbox',
    									'size'=>'auto',
                      'checked'=>$this->request->query['drap']])?>
                         <span><?= __("Draps et linge fournis") ?></span>
          </label>
          <label class="checkbox-inline">
            <?php echo $this->Form->input("animaux",[
    									'label'=>false,
    									'templates' => ['inputContainer' => "{{content}}"],
    									'style'=>'margin-left:5px',
    									'type'=>'checkbox',
    									'size'=>'auto',
                      'checked'=>$this->request->query['animaux']])?>
                         <span><?= __("Animaux Acceptés") ?></span>
          </label>
        </div>
        <div class="form-group">
            <label for="reference_annonce">Référence annonce</label>
            <?php echo $this->Form->input("reference",['value'=>$this->request->query["reference"],'label'=>false,'templates' => ['inputContainer' => "{{content}}"],'type'=>'text', 'class'=>'form-control inline-block', 'style'=>'width: 241px'])?>
        </div>
        <div class="form-group">
            <label for="surface_a"><?= __("Mots clés") ?></label>
            <?php echo $this->Form->input("motcle",['value'=>$this->request->query["motcle"],'label'=>false,'templates' => ['inputContainer' => "{{content}}"],'type'=>'text', 'class'=>'form-control inline-block', 'style'=>'width: 300px'])?>
        </div>
        <button type="submit" class="btn btn-warning left hvr-sweep-to-top"><?= __("Valider") ?></button>
        <button type="button" class="btn btn-default right" id='btn-reset'>Vider les champs</button>
        <div class="clearfix"></div>
      <!--  <div class='select_geo'>
            <div class='geo-btn-search'><input type="button" id='btn-reset' class='btn-search' value="Reset" /></div>
			      <div class='geo-btn-search'><input type="submit" class='btn-search' value="Valider" /></div>
        </div>-->

    </div>
    <?php echo $this->Form->end()?>
