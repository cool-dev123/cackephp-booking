<?php $this->Html->scriptStart(array('block' => 'tagmanager')); ?>
        dataLayer = [{ 'reservation': 'locataire', 'submitOk': 'OK' }];
<?php $this->Html->scriptEnd(); ?>
<div id="reservation_en_cours">
				<div class="row">
          <?php if($this->Session->read('Auth.User.nature')=='CLT') echo $this->element("menu_locataire");
          else echo $this->element("menu_proprietaire"); ?>

					<div class="col-md-9">
						<div class="row">
							<div class="col-md-12">
								<h1><?= __("Espace") ?> <?php if($this->Session->read('Auth.User.nature')=='CLT') echo "LOCATAIRE"; else echo "PROPRIETAIRE";?> - <span class="orange"><?php echo $this->Session->read('Auth.User.prenom')." ".$this->Session->read('Auth.User.nom_famille');  ?></span></h1>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="header_title">
									<h4 class="gray-fonce">RÉSERVATIONS EN ATTENTE DE VALIDATION</h4>
								</div>
							</div>
						</div>
						<div class="row">
              <?php echo $this->Form->create(null,['url'=>["controller"=>"annonces","action"=>"view",$this->request->data['annonce_id']]]);?>

							<div class="col-md-12">
								<div class="success-message block">
									<p>Votre demande a bien été prise en compte, <br>
									le propriétaire prendra contact avec vous prochainement </p>
								</div>
								<div class="pull-right">
									<?php if($this->Session->read('Auth.User.nature')=='CLT') $msg="Retour à l'espace locataire"; else $msg="Retour à l'espace proprietaire";?>
                  <?php echo $this->Form->submit($msg,['class'=>"btn btn-success hvr-sweep-to-top"]);?>
									<!--<a href="#"><button class="btn btn-success hvr-sweep-to-top ">Retour à l'<?= __("Espace locataire") ?></button></a>-->
								</div>
							</div>
              <?php echo $this->Form->end()?>
						</div>

					</div>

					<div class="col-md-12">
						<hr class="dashed">
					</div>

				</div>
			</div>
