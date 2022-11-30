<div class="col-md-3">
	<h1 class="gray_fonce">MENU</h1>
	<ul class="menu_vertical list-unstyled">
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>utilisateurs/locataire_index"><i class="fa fa-home fa-lg"></i> <?= __("Mon espace") ?></a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>utilisateurs/edit/<?php echo $this->Session->read('Auth.User.id')?>"><i class="fa fa-user fa-lg"></i> Mes coordonnées</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>reservations/locataire_view"><i class="fa fa-calendar fa-lg"></i> <?= __("Mes réservations") ?></a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>reservations/annulationlocataire"><i class="fa fa-calendar fa-lg"></i> Mes Annulations</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>utilisateurs/mesmessages"><i class="fa fa-envelope fa-lg"></i> <?= __("Mes messages") ?></a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>annonces/contact" target="_blank"><i class="fa fa-phone fa-lg"></i>  Contacter Alpissime</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><i class="fa fa-sign-out fa-lg"></i> <?= __("Déconnexion") ?></a>
		</li>
	</ul>
</div>
