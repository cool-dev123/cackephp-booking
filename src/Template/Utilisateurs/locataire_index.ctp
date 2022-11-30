<?php $this->Html->scriptStart(array('block' => 'tagmanager')); ?>
	var subok = "<?php echo $SubmitOK ?>";
	if(subok == "OK") {
		dataLayer = [{ 'pageCategory': 'signup', 'submitOk': 'OK', 'visitorType': 'locataire' }];
	}
<?php $this->Html->scriptEnd(); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="espace_locataire" class="container-fluid mt-md-5">

	<?php echo $this->Flash->render() ?>
	<div class="row px-4">
		<div class="col">
			<h3 class="espace-type"><?= __("Heureux de vous revoir") ?>, <?php echo $this->Session->read('Auth.User.prenom'); ?></h3>
		</div>
		<div class="col-auto align-self-end">
			<a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index'];?>" class="text-decoration-none"><h3 class="text-blue espace-type"><?= __("Espace locataire") ?></h3></a>
		</div>
	</div>
	<div class="row mt-3 px-4">
			<div class="col-sm-12 col-md-4 mb-5">
				<div class="shadow px-3 h-100 border">
				<div class="row py-3 align-items-center h-100">
					<div class="col-12 col-lg-auto text-center">
                      <img width="65" src="<?php echo $this->Url->build('/')?>images/mes-coordonnees.png" class="img-fluid">
                    </div>
					<div class="col text-center text-lg-left mt-3 mt-lg-0"> 
						<h4><?= __("Coordonnées") ?></h4>
						<div class="line-height-1-4 font-size-14"><?= __("Modifiez vos informations et indiquez la façon dont Alpissime ou les propriétaires peuvent vous joindre.") ?> </div>
						<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/edit/<?php echo $utilisateur->id?>"><?= __("Modifier mes coordonnées") ?></a></div>
					</div>
				</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-4 mb-5">
			    <div class="shadow px-3 h-100 border">
				<div class="row py-3 align-items-center h-100">
					<div class="col-12 col-lg-auto text-center">
                        <img width="65" src="<?php echo $this->Url->build('/')?>images/mes-reservations.png" class="">
                    </div>
					<div class="col text-center text-lg-left mt-3 mt-lg-0">
					<h4><?= __("Réservations") ?></h4>
						<div class="line-height-1-4 font-size-14"><?= __("Accédez aux informations des hébergements que vous avez loués, consultez ou modifiez vos réservations.") ?></div>
						<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Mes réservations") ?></a></div>
					</div>
				</div>
	            </div>
			</div>
			<div class="col-sm-12 col-md-4 mb-5">
			    <div class="shadow px-3 h-100 border">
				<div class="row py-3 align-items-center h-100">
					<div class="col-12 col-lg-auto text-center">
						<img width="65" src="<?php echo $this->Url->build('/')?>images/mes-messages.png" class="">
                    </div>
					<div class="col text-center text-lg-left mt-3 mt-lg-0">
					    <h4><?= __("Messages") ?></h4>
						<div class="line-height-1-4 font-size-14"><?= __("Si vous avez posé une question à un propriétaire à propos d'une réservation, sa réponse se trouve  ici.") ?></div>
						<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Mes messages") ?></a></div>
					</div>
				</div>
	            </div>
			</div>
	</div>
	<div class="row mt-5 px-4">
		<div class="col-sm-6 col-md-3 col-lg-2 pr-0">
		<a href="<?php echo $this->Url->build('/',true).$urlLang;?>" class="text-secondary"><u><i class="fa fa-angle-right"></i> <?= __("Retour à l'accueil") ?></u></a>
		</div>
		<div class="col-sm-6">
		<a href="<?php echo $this->Url->build('/',true).$urlLang;?>utilisateurs/logout" class="text-secondary"><u><i class="fa fa-angle-right"></i> <?= __("Déconnexion") ?></u></a>
		</div>
	</div>
	</div>	
