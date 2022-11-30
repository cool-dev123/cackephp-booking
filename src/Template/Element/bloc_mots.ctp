<style>
#wrapper-bloc {
	/*width: 800px;*/
	margin-left: 10px;
	/*margin-right: auto;*/
	}
.accordion-open span { 
   display:block;
    float:left;
    background:url("../images/moins.png") no-repeat scroll center center rgba(255, 102, 0, 1);
    width:60px;
	height:60px;
	
	position:relative;
	
}
.accordion-close span {
    display:block;
    float:left;
    background:url("../images/plus.png") no-repeat scroll center center rgba(255, 102, 0, 1);
    width:60px;
	height:60px;
	
	position:relative;
	
	
}
.acc-title{float: left; background-color: rgb(255, 102, 0); width: 91%; padding-left: 9px; padding-top: 20px; height: 40px; opacity: 0.74;}
.accordionButton {	
	width: 940px;
	float: left;
	_float: none;  /* Float works in all browsers but IE6 */
	
	border-bottom: 1px solid #FFFFFF;
	cursor: pointer;
	color:#fff;
	font-weight:bold;
	font-size:1em;
	font-family:Arial,Helvetica,sans-serif;
	}
	
.accordionContent {	
	width: 925px;
	float: left;
	_float: none; /* Float works in all browsers but IE6 */
	background: none repeat scroll 0 0 #f0f0f0;
	font-size:.9em;
    line-height:1.5em;
    font-family:"Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
	}
	
/***********************************************************************************************************************
 EXTRA STYLES ADDED FOR MOUSEOVER / ACTIVE EVENTS
************************************************************************************************************************/

.on {
	background: #990000;
	}
	
.over {
	background: #CCCCCC;
	}
</style>
<div id="wrapper-bloc">
		<div class="accordionButton accordion-close"><span></span><div class='acc-title'><?= __("Qui sommes nous ?") ?></div></div>
		<div class="accordionContent">
			<p>
            <strong>Alpissime.com</strong> est un site de location d'appartements en résidences de vacances, chalets, studios,  gites,  de particuliers à particuliers sur les stations de arc 1800, arc 1600, arc 1950, arc 2000, Bourg saint Maurice (73700), sur la commune de Landry (73210) hameau de la Maïtaz sur la station de Vallandry en Savoie.
			</p>
			<p>
				Alpissime recentre l'offre et permet à un propriétaire de résidence secondaire d'entrer directement en contact avec un locataire. Une véritable relation de confiance est instaurée. Les meilleurs prix du marché de la location saisonnière sur la commune de Bourg Saint Maurice - Les Arcs sont présents sur alpissime.com. Avec près de 400 appartements alpissime se positionne comme le passage incontournable pour louer un appartement avec le plus grand choix  sans intermédiaires .
			</p>
		</div>
		<div class="accordionButton accordion-close"><span></span><div class='acc-title'>Quels services apporte alpissime aux propriétaires et locataires de résidences secondaires ?</div></div>
		<div class="accordionContent">
			<p>
            Sur le site  internet mais également sur les applications mobiles pour smartphone et tablettes sur Windows Phone WP8, l’Apple App store et le Google Play d’Android et Android market alpissime propose différentes offres : location d’appartements à lesarcs avec les meilleures fonctionnalités du moment, vente en ligne  de produits et de services de conciergerie comme les services de ménage, mise à disposition de kit de bienvenue, location de linge, serviettes, draps, tapis de bains, inventaire, services techniques et d'entretien.
			</p>
			<p>
				Alpissime permettra bientôt à des partenaires d'être visibles à ses cotés et de proposer également des services en compléments de ceux de alpissime. Des partenariats avec l' ESF, école de ski français, loueurs de ski avec la location de skis, raquetttes, luges, snowboards, l'engagement d'un guide de haute montagne, la commande d'une course en taxi, d'une baby-sitter, d'un repas au restaurant, de soins et bien être, de cours sportifs, comme un cours de tennis ou de golf, ou d'un baptême en hélicoptaire sont possible avec alpissime
			</p>
			<p>
			Les futurs developpements  permettront bientôt d'ajouter aux services déjà proposés des produits vendus par les partenaires de alpissime, le mobilier de montagne, les fournitures pour votre appartement, le tissus d'ameublement, rideaux, les produits de décoration et de cadeaux,
			</p>
		</div>
		<div class="accordionButton accordion-close"><span></span><div class='acc-title'>Ou se situe alpissime ?</div></div>
		<div class="accordionContent">
			<p>
            La station de ski des Arcs est une station de sports d’hiver située en Rhône alpes, en Savoie dans les alpes du nord  face au mont blanc au-dessus de la ville de Bourg Saint Maurice, sur le domaine de Paradiski qui regroupe les stations des arcs, peisey vallandry et la Plagne.  Avec 425 km de pistes le domaines les arcs – la plagne – peisey vallandry est le 1er domaine mondial en nombre de journées skieurs. Les stations des arcs – bourg saint maurice sont proches de arêches Beaufort, Brides les bains, Courchevel, Courchevel 1350, Courchevel 1550, Courchevel 1650, Courchevel 1850, La Plagne, Aime 2000, Belle Plagne, Bellentre, Champagny, Montalbert, Montchavin les Coches, Plagne 1800, Plagne Bellecote, Plagne Centre, Plagne Soleil, Plagne Villlage, Les Menuires, Meribel, Meribel le Plantin, Meribel les Allues, Meribel Mottaret, Meribel Village, Peisey, Pralognan, Tignes, Tignes le Lac, Tignes le Lavachet, Tignes les Brévières, Tignes Val Claret, Val D' Isère, Vallandry, Valmorel la Belle et La Rosière, Peisey Nancroix.
			</p>
		</div>
		<div class="accordionButton accordion-close"><span></span><div class='acc-title'>Où s'effectue l'accueil des locataires ?</div></div>
		<div class="accordionContent">
			<p>
			En famille ou entre amis, à deux ou en groupe de plusieurs  personnes alpissime vous accueillera  tous les jours, 7 jours sur 7 en saisons d'hiver et d'été,
			</p>
			<p>
			Lors des vacances scolaires d'hiver et d'été, pour la commune de Bourg Saint Maurice - Les Arcs, alpissime est présent et accueille les locataires dans ses locaux à Arc 1800 village des Villards face au Roignaix et à l'arrêt navettes, pour les locataires ayant choisi de résider dans les résidences de ces 2 villages, Village des Villards et Village de Charmettoger, la Nova, le Vaugella, l' Armoise, le Grand Arbois, le Thuria, le Ruitor, l'Aiguille des Glaciers, le Becqui Rouge, les Arandelières, les Tournavelles 1, les Tournavelles 2, l'Alliet, le Vogel, l'Aiguille Grive 1, l'Aiguille Grive 2, l'Aiguille Grive 3, le Jardin Alpin, les Chalets du Jardin Alpin , l'Archeboc, Mirantin 1, Mirantin 2, Mirantin 3, les Chalets de la Maïtaz sur la station de Vallandry commune de Landry, et à son accueil village du Charvet galerie Pierra Menta, pour les villages du Charvet et des Alpages du Chantel dans les résidences Belles Challes, Lauzières, Pierra Menta, Bellecote, Miravidi, pour les Alpages du Chantel, proche de Edenarc et de la résidence les Souverains et de son Hôtel,  Les Alpages du Chantel chalets C et D, les Alpages du Chantel Chalet la Bergerie, les Alpages du Chantel Chalet du Golf, l'Iseran, le Saint Bernard, le Roseland. Pour nos clients de Bourg Saint Maurice, les Arcs 1600, les Arcs 1950 et Arc 2000, l'accueil se situe à Bourg Saint Maurice et dessert les résidences , les Borrainies, le Grand Cœur, le Cœur d'Or, les Résidences des Glières, le Bergentrum, le Centenaire, l'Orée des Arcs, le Solaret, les Jardins du Nantet, le Rochefort, le Planay, le Tétra Lyre, les Iris,  pour lesarcs1600, le Roc Belle Face, les Arolles, les Rouelles, la Cascade, la Rive, la Cachette, Pierre Blanche, Versant Sud, le village de Courbaton, Plan devin 1, Plan devin 2, l'Adret, les Hauts de l'Adret, village des 2 Têtes, pour Arc 1950 ,  le Chalet des Lys, l'Auberge Jérome, le Hameau des Glaciers, les Jardins de la Cascade, le Manoir Savoie, le Prince des Cimes, le Refuge des Montagnards, les Sources de Marie, pour lesarcs2000, l'Aiguille des Grands Fonds, l' AGF, l' Aiguille Rouge, le Bel Aval, le Fond Blanc, la Cime des Arcs, le Chalet Altitude, le Chalet de l'Ours, le Chalet des Neiges, les Feuillières, les Lanchettes, le Varet.. A leur arrivée les locataires disposent de pochettes d'accueil où les partenaires de alpissime  proposent des coupons de réductions.
			</p>
		</div>
		<div class="accordionButton accordion-close"><span></span><div class='acc-title'>Quel type d'informations trouve-t-on sur alpissime ?</div></div>
		<div class="accordionContent">
			 <p>
            Outre les informations déposées par les propriétaires, liées à l'accueil des vacanciers, alpissime vous propose des informations  économiques, touristiques, culturelles et sportives qui agrémentent un blog et permettent aux touristes de trouver une autre information du lieu de vacances montagne, neige, ski, pastoralisme, culture et évènements.

			</p>
		</div>
		<div class="accordionButton accordion-close"><span></span><div class='acc-title'>Quelles activités sont possibles été et hiver à la montagne en coeur de Tarentaise ?</div></div>
		<div class="accordionContent">
			<p>
            Pour Les vacances de Noel, les vacances de Fevrier, les vacances de Pâques, les vacances de printemps, les vacances d’été, appréciez les loisirs et joies des sports d’hiver, ski, surf des neiges, snowboard, ski de fond,  raquettes à neige, luge, patinage, spas, hamman, bains bouillonnants, bien être, hydrospeed, raft, canyonning, ballades en montagne, randonnées, visites culturelles  de la Chapelle Saint Graat à Vulmix, l'église de Hauteville Gondon, la Chapelle de notre Dame des Vernettes, ainsi que les architectures inscrites au patrimone du 20eme siècle pour Arc 1600 et Arc 1800 mais aussi Arc 1950 modèle pour quelques stations des derniers jeux olympiques d'hiver.
			</p>
		</div>
		<div class="accordionButton accordion-close"><span></span><div class='acc-title'>Quels appartements trouve-t-on sur alpissime ?</div></div>
		<div class="accordionContent">
			<p>
            le plus grand choix  d'appartements, du studio au chalet pour les vacances avec les meilleurs équipements sont disponibles sur alpissime. Tous les types d'appartements sont présents et peuvent accueillir de 2 à 18 personnes personnes dans des studios de 18 m² ou des appartements de  27 m ² à  280 m²
			</p>
			<p>
			Les appartements proposés à la locations sont d'abord des appartements utilisés en résidence secondaire par des propriétaires. Ces appartements de propriétaires en résidence secondaire sont généralement bien équipés. Un propriétaire aime se sentir bien chez lui, les locataires se sentiront comme chez eux !
			Bonnes vacances avec Alpissime !
	.        </p>
		</div>
	</div>
<script>
		
 $(document).ready(function() {
	 
	//ACCORDION BUTTON ACTION (ON CLICK DO THE FOLLOWING)
	$('.accordionButton').click(function() {

		//REMOVE THE ON CLASS FROM ALL BUTTONS
		
	 	
		if($(this).next().is(':hidden') == false) {
			//alert('test');
			//ADD THE ON CLASS TO THE BUTTON
			$(this).removeClass('accordion-open');
			$(this).addClass('accordion-close');
			  
			//OPEN THE SLIDE
			$(this).next().slideUp('normal');
		 }
		//IF THE NEXT SLIDE WASN'T OPEN THEN OPEN IT
		if($(this).next().is(':hidden') == true) {
			//alert('test');
			//ADD THE ON CLASS TO THE BUTTON
			$('.accordionContent').slideUp('normal');
			$('.accordionButton').removeClass('accordion-open');
			$('.accordionButton').addClass('accordion-close');
			$(this).removeClass('accordion-close');
			$(this).addClass('accordion-open');
			  
			//OPEN THE SLIDE
			$(this).next().slideDown('normal');
		 } 
		  
	 });
	
	$('.accordionContent').hide();

});
    </script>