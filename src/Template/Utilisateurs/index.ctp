
<?php $this->Html->scriptStart(array('block' => 'tagmanager')); ?>
	var subok = "<?php echo $SubmitOK ?>";
	if(subok == "OK") {
		dataLayer = [{ 'pageCategory': 'signup', 'submitOk': 'OK', 'visitorType': 'proprietaire' }];
	}	
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
$(document).ready(function () {
	var utilisateurconnecte = "<?php echo $this->Session->read('Auth.User.nature') ?>";
	var utilisateurvalid = "<?php echo $this->Session->read('Auth.User.valide_at') ?>";
	// if(utilisateurvalid != "") $(".notvalidiv").css("display", "none");
	if(utilisateurconnecte != "" && utilisateurvalid == ""){
		$(".creereserv").css("pointer-events", "none");
		$(".creereserv").css("color", "rgba(33, 150, 243, 0.49)");		
	} 
	// else $(".notvalidiv").css("display", "none");
});
<?php $this->Html->scriptEnd(); ?>

<?php $this->append('cssTopBlock', '<style>
.slick-next:before, .slick-prev:before{
	color: #878787;
}
.oneligne{
	white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #6c757d;
    font-style: italic;
}
/*.slick-slide {
    height: 240px;
}*/
.slick-track {
    display: grid;
    grid-auto-flow: column;
}
.slick-slider .slick-list{
	/* height: 275px; */
	padding-bottom: 30px;
}
</style>'); ?>

<?php $this->Html->css("/css/slick.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/slick-theme.min.css", array('block' => 'cssTop')); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="espace_proprietaire" class="container-fluid">
<?php echo $this->Flash->render() ?>
	<div class="row px-4">
			<div class="col-12 col-md">
				<h3 class="espace-type"><?= __("Heureux de vous revoir") ?>, <?php echo $this->Session->read('Auth.User.prenom'); ?></h3>
			</div>
			<div class="col-auto align-self-end">
				<h3 class="text-blue espace-type"><?= __("Espace Propriétaire") ?></h3>
			</div>
	</div>
	<div class="row mt-3 px-4">
			<div class="col-sm-12 col-md-4 mb-5">
				<div class="shadow px-3 h-100 border">
				<div class="row py-3 align-items-center h-100">
					<div class="col-12 col-lg-auto text-center">
                      <img width="65" src="<?php echo $this->Url->build('/')?>images/mes-coordonnees.png" class="">
                    </div>
					<div class="col text-center text-lg-left mt-3 mt-lg-0">
						<h4><?= __("Coordonnées") ?></h4>
						<div class="line-height-1-4 font-size-14"><?= __("Modifiez vos informations et indiquez la façon dont Alpissime ou vos locataires peuvent vous joindre.") ?></div>
						<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/edit/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Modifier mes coordonnées") ?></a></div>
					</div>
				</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-4 mb-5">
			    <div class="shadow px-3 h-100 border">
				<div class="row py-3 align-items-center h-100">
					<div class="col-12 col-lg-auto text-center">
                        <img width="65" src="<?php echo $this->Url->build('/')?>images/mes-annonces.png" class="">
                    </div>
					<div class="col text-center text-lg-left mt-3 mt-lg-0">
					<h4><?= __("Annonces") ?></h4>
					<div class="line-height-1-4 font-size-14"><?= __("Modifiez les informations de présentation de vos annonces, assurez-vous de leur visibilité et détaillez les disponibilités.") ?></div>
					<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Modifier mes annonces") ?></a></div>
					</div>
				</div>
	            </div>
			</div>
			<div class="col-sm-12 col-md-4 mb-5">
			    <div class="shadow px-3 h-100 border">
				<div class="row py-3 align-items-center h-100">
					<div class="col-12 col-lg-auto text-center">
                        <img width="65" src="<?php echo $this->Url->build('/')?>images/mes-paiements.png" class="">
                    </div>
					<div class="col text-center text-lg-left mt-3 mt-lg-0">
					<h4><?= __("Paiements") ?></h4>
					<div class="line-height-1-4 font-size-14"><?= __("Ajoutez un mode de versement et consultez les derniers paiements reçus en rémunération de vos locations.") ?></div>
					<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['infobancaire'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Mes paiements") ?></a></div>
					</div>
				</div>
	            </div>
			</div>
	</div>
	<div class="row px-4">
			<div class="col-sm-12 col-md-4 mb-5">
			    <div class="shadow px-3 h-100 border">
				<div class="row py-3 align-items-center h-100">
					<div class="col-12 col-lg-auto text-center">
                        <img width="65" src="<?php echo $this->Url->build('/')?>images/mes-reservations.png" class="">
                    </div>
					<div class="col text-center text-lg-left mt-3 mt-lg-0">
					<h4><?= __("Réservations") ?></h4>
					<div class="line-height-1-4 font-size-14"><?= __("Acceptez ou modifiez vos réservations, accédez aux coordonnées de vos locataires ou créez une réservation manuelle.") ?> </div>
					<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation" class="d-block d-xl-inline-block"><?= __("Mes réservations") ?></a>
						<a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_addres'];?>" class="float-xl-right creereserv"><?= __("Créer une réservation") ?></a></div>
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
						<div class="line-height-1-4 font-size-14"><?= __("Découvrez les demandes d'informations de vacanciers et échangez avec vos locataires.") ?><br>&nbsp; </div>
						<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Mes messages") ?></a></div>
					</div>
				</div>
	            </div>
			</div>
			<div class="col-sm-12 col-md-4 mb-5">
			    <div class="shadow px-3 h-100 border">
					<div class="row py-3 align-items-center h-100">
						<div class="col-12 col-lg-auto text-center">
							<img width="65" src="<?php echo $this->Url->build('/')?>images/marketplace.png" class="">
						</div>
						<div class="col text-center text-lg-left mt-3 mt-lg-0">
							<h4><?= __("Marketplace") ?></h4>
							<div class="line-height-1-4 font-size-14"><?= __("Retrouvez vos services de conciergerie, commandez des activités en station ou consultez l'état de vos commandes.") ?><br>&nbsp; </div>
							<div class="pt-2 font-size-14">
								<a href="<?php echo BOUTIQUE_ALPISSIME; ?>" class="d-block d-xl-inline-block" target="_black"><?= __("Marketplace") ?></a>
								<a href="<?php echo BOUTIQUE_ALPISSIME; ?>fr/sales/order/history" class="float-xl-right creereserv" target="_black"><?= __("Mes Commandes") ?></a>
							</div>
						</div>
					</div>
	            </div>
			</div>
	</div>
	<div class="row px-4">
		<div class="col-md-12">
			<h3><?= __("Pensez à renseigner ces informations"); ?></h3>
		</div>
		<div class="col-md-12">
			<div class="regularann slider">
				<?php if($informationbancaire === 0): ?>
				<div >
					<div class="shadow px-3 h-100 border">
						<div class="row p-4 align-items-center h-100">
							<div class="col text-center text-lg-left mt-3 mt-lg-0 p-0">
								<label><?= __("Mon compte"); ?></label>
								<hr class="my-1">
								<h3 class="mt-2"><?= __("Coordonnées bancaires"); ?></h3>
								<div class="line-height-1-4 font-size-14"><?= __("Renseignez vos coordonnées bancaires dans la section paiement pour recevoir les versements de vos réservations.") ?></div>
								<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['infobancaire']."/".$this->Session->read('Auth.User.id');?>"><?= __("Renseigner mon RIB") ?></a></div>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<?php foreach ($annoncesTab as $annonceTab) { 
					if($annonceTab['justificatifDom'] == ""){ ?>
						<div >
							<div class="shadow px-3 h-100 border">
								<div class="row p-4 align-items-center h-100">
									<div class="col text-center text-lg-left mt-3 mt-lg-0 p-0">
										<p class="oneligne mb-2"><?= $annonceTab['titre']; ?></p>
										<hr class="my-1">
										<h3 class="mt-2"><?= __("Justificatif de domicile"); ?></h3>
										<div class="line-height-1-4 font-size-14"><?= __("Pour rassurer les vacanciers, pensez à transmettre un justificatif de domicile à votre nom et mentionnant l'adresse de l'hébergement.") ?></div>
										<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/".$urlvaluemulti['previsualiser']."/".$annonceTab['id'];?>"><?= __("Renseigner un justificatif") ?></a></div>
									</div>
								</div>
							</div>
						</div>
					<?php }	?>	
					<?php if($annonceTab['nbrDispos'] == 0): ?>				
					<div >
						<div class="shadow px-3 h-100 border">
							<div class="row p-4 align-items-center h-100">
								<div class="col text-center text-lg-left mt-3 mt-lg-0 p-0">
									<p class="oneligne mb-2"><?= $annonceTab['titre']; ?></p>
									<hr class="my-1">
									<h3 class="mt-2"><?= __("Disponibilités"); ?></h3>
									<div class="line-height-1-4 font-size-14"><?= __("Renseignez au moins une période dans la section Tarifs et disponibilités pour permettre aux vacanciers de réserver votre hébergement.") ?></div>
									<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['dispos']."/view/".$annonceTab['id'];?>"><?= __("Renseigner mes tarifs") ?></a></div>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<?php if($annonceTab['equipements'] == 0): ?>	
					<div >
						<div class="shadow px-3 h-100 border">
							<div class="row p-4 align-items-center h-100">
								<div class="col text-center text-lg-left mt-3 mt-lg-0 p-0">
									<p class="oneligne mb-2"><?= $annonceTab['titre']; ?></p>
									<hr class="my-1">
									<h3 class="mt-2"><?= __("Equipements"); ?></h3>
									<div class="line-height-1-4 font-size-14"><?= __("Aidez les vacanciers à découvrir votre hébergement en renseignant les informations des sections Services & équipement et Situation.") ?></div>
									<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/edit/".$annonceTab['id'];?>"><?= __("Remplir les informations") ?></a></div>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<?php if($annonceTab['inventaire'] == ""): ?>
					<div >
						<div class="shadow px-3 h-100 border">
							<div class="row p-4 align-items-center h-100">
								<div class="col text-center text-lg-left mt-3 mt-lg-0 p-0">
									<p class="oneligne mb-2"><?= $annonceTab['titre']; ?></p>
									<hr class="my-1">
									<h3 class="mt-2"><?= __("Sécurité"); ?></h3>
									<div class="line-height-1-4 font-size-14"><?= __("Renseignez le montant de caution, ainsi qu’un inventaire pour assurer votre hébergement contre les dommages.") ?></div>
									<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/edit/".$annonceTab['id'];?>"><?= __("Remplir les informations") ?></a></div>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<?php if($annonceTab['photos'] < 5): ?>
					<div >
						<div class="shadow px-3 h-100 border">
							<div class="row p-4 align-items-center h-100">
								<div class="col text-center text-lg-left mt-3 mt-lg-0 p-0">
									<p class="oneligne mb-2"><?= $annonceTab['titre']; ?></p>
									<hr class="my-1">
									<h3 class="mt-2"><?= __("Images"); ?></h3>
									<div class="line-height-1-4 font-size-14"><?= __("Vous avez renseigné {0} image(s). Vous pouvez en ajouter jusqu’à 20, et nous vous conseillons d’en ajouter au moins 5.", [$annonceTab['photos']]) ?></div>
									<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/photo/".$annonceTab['id'];?>"><?= __("Ajouter des images") ?></a></div>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<?php if($annonceTab['immatriculation'] == ""): ?>
					<div >
						<div class="shadow px-3 h-100 border">
							<div class="row p-4 align-items-center h-100">
								<div class="col text-center text-lg-left mt-3 mt-lg-0 p-0">
									<p class="oneligne mb-2"><?= $annonceTab['titre']; ?></p>
									<hr class="my-1">
									<h3 class="mt-2"><?= __("Numéro d'immatriculation"); ?></h3>
									<div class="line-height-1-4 font-size-14"><?= __("Pensez à renseigner votre numéro d'immatriculation ou à faire une demande auprès de la mairie d rattachement de votre hébergement.") ?></div>
									<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/edit/".$annonceTab['id'];?>"><?= __("Remplir les informations") ?></a></div>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<?php if($annonceTab['contrat'] == 0 && $annonceTab['blocinfoarrivee'] == "" && $annonceTab['blocinfodepart'] == ""): ?>
					<div >
						<div class="shadow px-3 h-100 border">
							<div class="row p-4 align-items-center h-100">
								<div class="col text-center text-lg-left mt-3 mt-lg-0 p-0">
									<p class="oneligne mb-2"><?= $annonceTab['titre']; ?></p>
									<hr class="my-1">
									<h3 class="mt-2"><?= __("Arrivée / Départ"); ?></h3>
									<div class="line-height-1-4 font-size-14"><?= __("Renseignez les consignes d'arrivée et de départ pour aider les vacanciers à organiser leur séjour dans votre hébergement.") ?></div>
									<div class="pt-2 font-size-14"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/edit2/".$annonceTab['id'];?>"><?= __("Remplir les informations") ?></a></div>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
				<?php } ?>
				
			</div>
		</div>
	</div>
	<div class="row mt-5 px-4">
		<div class="col-sm-6 col-md-3 col-lg-2 pr-0">
			<a href="<?php echo $this->Url->build('/',true).$urlLang;?>" class="text-secondary"><u><i class="fa fa-angle-right"></i> <?= __("Retour à l'accueil") ?></u></a>
		</div>
		<div class="col-sm-6 col-md-3 col-lg-2 pr-0">
			<a href="https://help.alpissime.com/" target="_blanck" class="text-secondary"><u><i class="fa fa-angle-right"></i> <?= __("Centre d'aide") ?></u></a>
		</div>
		<div class="col-sm-6">
			<a href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout" class="text-secondary"><u><i class="fa fa-angle-right"></i> <?= __("Déconnexion") ?></u></a>
		</div>
	</div>
</div>
<div class="modal fade" id="popup_reser_creer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
			    <h4 class="modal-title" id="myModalLabel"><?= __("Information") ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<p><?= __("Vous allez créer une réservation") ?></p>
			<p><?= __("pour que cette réservation soit possible vous devez renseigner la période avant de passer celle ci sur le Statut réservé") ?></p>
			<p><?= __("si vous ne voyez pas votre semaine après avoir ouvert ce tableau") ?></p>
			<p><?= __("mettez la semaine sur libre, vous la retrouverez dans votre tableau création d'une réservation manuelle") ?></p>
			<p><?= __("une période est considérée \"réservé\" si elle est renseignée avec les coordonnées de votre locataire") ?></p>

			</div>
			<div class="modal-footer">
				<a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_addres'];?>" class="btn btn-blue text-white rounded-0"><?= __("Valider") ?></a>
			</div>
		</div>
	</div>
</div>

<?php $this->Html->script("/js/slick.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
function show_popup_creer_res(){
$('#popup_reser_creer').modal('show')
}

$('.regularann').slick({
   slidesToShow: 5,
   slidesToScroll: 1,
   autoplay: false,
   // autoplaySpeed: 1000,
   adaptiveHeight: true,
   responsive: [	
	{
       breakpoint: 1471,
       settings: {
         slidesToShow: 4,
         slidesToScroll: 1,
         infinite: true,
         dots: true
       }
     },
     {
       breakpoint: 1024,
       settings: {
         slidesToShow: 3,
         slidesToScroll: 1,
         infinite: true,
         dots: true
       }
     },
     {
       breakpoint: 600,
       settings: {
         slidesToShow: 2,
         slidesToScroll: 1
       }
     },
     {
       breakpoint: 480,
       settings: {
         slidesToShow: 1,
         slidesToScroll: 1
       }
     }
     // You can unslick at a given breakpoint now by adding:
     // settings: "unslick"
     // instead of a settings object
   ]
});
<?php $this->Html->scriptEnd(); ?>