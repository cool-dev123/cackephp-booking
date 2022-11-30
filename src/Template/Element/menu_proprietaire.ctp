<div class="col-md-3">
	<h1 class="gray_fonce">MENU</h1>
	<ul class="menu_vertical list-unstyled">
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>utilisateurs"><i class="fa fa-home fa-lg"></i> <?= __("Mon espace") ?></a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>utilisateurs/edit/<?php echo $this->Session->read('Auth.User.id')?>"><i class="fa fa-user fa-lg"></i> Mes coordonnées</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>utilisateurs/listannonce/<?php echo $this->Session->read('Auth.User.id')?>"><i class="fa fa-list-alt fa-lg"></i> <?= __("Mes annonces") ?></a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>reservations/locataire_addres"><i class="fa fa-pencil-square-o fa-lg"></i> Créer une réservation</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>reservations/view/"><i class="fa fa-calendar fa-lg"></i> Réservations en cours</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>reservations/validation/"><i class="fa fa-calendar fa-lg"></i>Réservations à valider</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>utilisateurs/mesmessages"><i class="fa fa-envelope fa-lg"></i> <?= __("Mes messages") ?></a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>annonces/contact" target="_blank"><i class="fa fa-phone fa-lg"></i> Contacter Alpissime</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><i class="fa fa-sign-out fa-lg"></i> <?= __("Déconnexion") ?></a>
		</li>
	</ul>

	<h1 class="gray_fonce menu_annon"><?= __("Annonce") ?></h1>
	<ul class="menu_vertical list-unstyled menu_annon">

		<li>
			<a href="<?php echo $this->Url->build('/',true)?>annonces/edit/<?php echo $annonce_id?>"><i class="fa fa-list-ul fa-lg"></i> <?= __("Informations générales") ?></a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>annonces/edit2/<?php echo $annonce_id?>"><i class="fa fa-list-ul fa-lg"></i> Informations détaillées</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>annonces/photo/<?php echo $annonce_id?>"><i class="fa fa-picture-o fa-lg"></i> Ajouter les images</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>dispos/view/<?php echo $annonce_id?>"><i class="fa fa-table fa-lg"></i> <?= __("Tarifs et disponibilités") ?></a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>annonces/previsualiser/<?php echo $annonce_id?>"><i class="fa fa-eye fa-lg"></i> <?= __("Prévisualiser") ?></a>
		</li>
		<li>
			<a href="#"><i class="fa fa-pencil-square-o fa-lg"></i> Déclarer incident</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>annonces/uploadinventaire/<?php echo $annonce_id?>"><i class="fa fa-pencil-square-o fa-lg"></i> Upload inventaire</a>
		</li>
	</ul>
</div>
<?php $this->append('cssTopBlock', '<style>
#popup_reser_creer .modal-body p{
	text-align: center;
	font-size: 15px;
}
</style>'); ?>
<div class="modal fade" id="popup_reser_creer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Information</h4>
			</div>
			<div class="modal-body">
				<p><?= __("Vous allez créer une réservation") ?></p>
			<p><?= __("pour que cette réservation soit possible vous devez renseigner la période avant de passer celle ci sur le Statut réservé") ?></p>
			<p><?= __("si vous ne voyez pas votre semaine après avoir ouvert ce tableau") ?></p>
			<p><?= __("mettez la semaine sur libre, vous la retrouverez dans votre tableau création d'une réservation manuelle") ?></p>
			<p><?= __("une période est considérée \"réservé\" si elle est renseignée avec les coordonnées de votre locataire") ?></p>

			</div>
			<div class="modal-footer">
				<a href="<?php echo $this->Url->build('/',true)?>reservations/locataire_addres" class="btn btn-success hvr-sweep-to-top "><?= __("Valider") ?></a>
			</div>
		</div>
	</div>
</div>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
function show_popup_creer_res(){
$('#popup_reser_creer').modal('show')
}
<?php $this->Html->scriptEnd(); ?>
