<?php $this->Html->css("/css/modif_datepicker.css", array('block' => 'cssTop')); ?>

<div id="form_reservation">
		<div class="row">
				<?php echo $this->element("menu_proprietaire")?>
				<div class="col-md-9">
						<div class="row">
								<div class="col-md-12">
										<h1><?= __("Espace Propriétaire") ?> - <span class="orange">MODIFICATION DE DISPONIBILITE</span></h1>
								</div>
						</div>
						<div class="row">
								<div class="col-md-12">
										<div class="header_title">
												<h4 class="gray-fonce"><span class="">Information période</span>
										</div>
								</div>
						</div>
						<?php echo $this->Flash->render() ?>

            <?php echo $this->Form->create($dispo,['url' => ['controller' => 'Dispos', 'action' => 'edit']]);?>
            <?php echo $this->Form->input('annonce_id',['type'=>'hidden','value'=>$annonce_id]);?>
            <?php echo $this->Form->input('ids',['type'=>'hidden','value'=>$ids]);?>

								<div class="row">
										<div class="col-sm-6">
												<div class="form-group">
														<label for="">Identifiant : </label><?php echo " ".$dispo->id ?>

												</div>
										</div>
										<!-- /.col-sm-6 -->
										<div class="col-sm-6">

										</div>
										<!-- /.col-sm-6 -->
								</div>
								<!-- /.row -->
								<div class="row">
										<div class="col-sm-6">
												<div class="form-group">
														<label for="dbt_at">Date de début </label>
														<?php echo $this->Form->input('dbt_at',['label'=>false,'readonly'=>'readonly','templates' => ['inputContainer' => "{{content}}"],'class'=>'form-control datepicker select','type'=>'text','value'=>$dispo->dbt_at->i18nFormat('dd/MM/yyyy')]);?>
												</div>
										</div>
										<!-- /.col-sm-6 -->
										<div class="col-sm-6">
												<div class="form-group">
														<label for="fin_at">Date de fin </label>
														<?php echo $this->Form->input('fin_at',['label'=>false,'readonly'=>'readonly','templates' => ['inputContainer' => "{{content}}"],'class'=>'form-control datepicker select','type'=>'text','value'=>$dispo->fin_at->i18nFormat('dd/MM/yyyy')]);?>
                        </div>
										</div>
										<!-- /.col-sm-6 -->
								</div>
								<!-- /.row -->
								<div class="row">
										<div class="col-sm-6">
												<div class="form-group">
														<label for="statut">Statut </label>
														<?php echo $this->Form->input('statut',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>'form-control','type'=>'select','options'=>$l_disposstatuts])?>
												</div>
										</div>
										<!-- /.col-sm-6 -->
										<div class="col-sm-6">
                      <div class="form-group">
                          <label for="prix">Coût du séjour </label>
                          <?php echo $this->Form->input('prix',['templates' => ['inputContainer' => "{{content}}"],'label'=>false,'class'=>'form-control']);?>
                      </div>
										</div>
										<!-- /.col-sm-6 -->
								</div>
								<!-- /.row -->
								<div class="row">
										<div class="col-sm-6">
												<div class="form-group">
														<label for="promo_yn"><?= __("Promotion") ?></label>
														<br><?php echo $this->Form->input('promo_yn',['label'=>false,'templates' => ['inputContainer' => "{{content}}"],'type'=>'checkbox','class'=>'select']);?>
												</div>
										</div>
										<!-- /.col-sm-6 -->
										<div class="col-sm-6">
												<div class="form-group">
														<label for="promo_px">Prix promotion </label>
													<?php echo $this->Form->input('promo_px',['templates' => ['inputContainer' => "<div class='d1'>{{content}}</div>"],'label'=>false,'class'=>'form-control select']);?>
												</div>
										</div>
										<!-- /.col-sm-6 -->
								</div>
								<!-- /.row -->
                <div class="row">
        						<div class="col-md-12">
        								<hr class="dashed">
        						</div>
        				</div>
								<div class="row">
                  <div class="col-md-12 block">
                    <?php echo $this->Form->submit('Valider',['name'=>'valider','class'=>'btn btn-success hvr-sweep-to-top  right','value'=>'valider','onclick'=>'return doSubmit_Valider();']);?>
                    <?php echo $this->Form->submit('Annuler',['name'=>'annuler','class'=>'btn btn-retour left','value'=>'annuler']);?>
                            <!--  <button class="btn btn-retour left"><?= __("Retour") ?></button>
                              <button type="submit" class="btn btn-success hvr-sweep-to-top  right">PASSER A L'ETAPE SUIVANTE</button>-->
                          </div>

								</div>
						<?php echo $this->Form->end();?>

				</div>

		</div>
</div>
<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
    function doSubmit_Valider()
    {
        if($('#promo-yn').is(":checked"))
        {
            if ($('#promo-px').val()=="")
            {
                alert("<?php echo __("Merci de renseigner le Prix Promotion"); ?>");
                $('#promo-px').focus();
                return false;
            }
            if ($('#promo-px').val()>=$('#prix').val())
            {
                alert("<?php echo __("Le prix promotion doit être inférieur au prix tarif"); ?>");
                $('#promo-px').focus();
                return false;
            }
        }
    }
    $(document).ready(function() {
		$.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);

        $('#dbt-at').datepicker({
		       // minDate: 0,
		        dateFormat: "dd/mm/yy"
		    });
				$('#dbt-at').on( "change", function() {
							//$('#dbt-at').datepicker( "option", "minDate", $.datepicker.parseDate( "dd/mm/yy", this.value ) );
							$('#fin-at').datepicker( "option", "minDate", $.datepicker.parseDate( "dd/mm/yy", this.value ) );
						});
        $('#fin-at').datepicker({
		        minDate: "<?php echo $dispo->dbt_at->i18nFormat('dd/MM/yyyy') ?>",
		        dateFormat: "dd/mm/yy"
		    });
    });
		<?php $this->Html->scriptEnd(); ?>
