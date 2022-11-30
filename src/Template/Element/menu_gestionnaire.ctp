
<div class="col-md-3">
	<h1 class="gray_fonce">MENU</h1>
	<ul class="menu_vertical list-unstyled">

		<li>
			<a href="<?php echo $this->Url->build('/',true)?>reservations/view/<?php echo $annonce_id?>"><i class="fa fa-calendar fa-lg"></i> Réservations en cours</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>reservations/validation/<?php echo $annonce_id?>"><i class="fa fa-calendar fa-lg"></i> Réservations à valider</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>annonces/edit/<?php echo $annonce_id?>"><i class="fa fa-list-ul fa-lg"></i> Informations générales</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>annonces/edit2/<?php echo $annonce_id?>"><i class="fa fa-list-ul fa-lg"></i> Informations détaillées</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>annonces/photo/<?php echo $annonce_id?>"><i class="fa fa-picture-o fa-lg"></i> Ajouter les images</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>dispos/view/<?php echo $annonce_id?>"><i class="fa fa-table fa-lg"></i> Tarifs et disponibilités</a>
		</li>
		<li>
			<a href="<?php echo $this->Url->build('/',true)?>annonces/previsualiser/<?php echo $annonce_id?>"><i class="fa fa-eye fa-lg"></i> Prévisualiser</a>
		</li>
	</ul>
</div>
