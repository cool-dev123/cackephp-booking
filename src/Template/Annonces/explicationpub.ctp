<?php $this->append('cssTopBlock', '<style>
header .container-fluid {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.header-explication{
    font-size: 42px;
    color: #0099ff;
}
.line-height-0 {
    font-size: 17px;
    line-height: 1em;
}
.checked-div {
    border-radius: 10px;
    background-color: #afd39a;
}
.rounded-5{
    border-radius: 10px;
}
#partners {
    height: 150px;
}
</style>'); ?>
<!-- metas -->
<?php $this->assign('title', __("Séjour ski tout compris - Réservez vos vacances sur Alpissime.com")); ?>
<?php $this->Html->meta(null, null, ['name' => 'title','content' => __("Alpissime.com | Séjour ski tout compris - Réservez vos vacances sur Alpissime.com") ,'block' => 'meta']); ?>
<?php $this->Html->meta(null, null, ['name' => 'description','content' => __("Composez votre séjour tout compris : Locations de vacances, Activités de professionnels en station de ski | Hébergements vérifiées, Paiement jusqu'à 4x sans frais.") ,'block' => 'meta']); ?>
<?php $this->Html->meta(null, null, ['property' => 'og:title','content' => __("Séjour ski tout compris - Réservez vos vacances sur Alpissime.com"),'block' => 'meta']); ?>
<?php $this->Html->meta(null, null, ['property' => 'og:description','content' => __("Composez votre séjour tout compris : Locations de vacances, Activités de professionnels en station de ski | Hébergements vérifiées, Paiement jusqu'à 4x sans frais.") ,'block' => 'meta']); ?>
<!-- metas -->

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="header_explication_page">
    <div class="container">
        <div class="row align-items-center mt-lg-n5">
            <div class="col-md-7 col-sm-8">
                <div class="h1 header-explication mb-3"><?= __("Réservez vos plus belles vacances à la montagne avec Alpissime") ?></div>
                <div class="line-height-0"><?= __("Réservez un hébergement seul ou ajoutez des activités et services à votre réservation pour composer les vacances qui vous ressemblent.") ?></div>
            </div>
            <div class="col-md-5 p-0">
                <?php if(in_array(date("m"),array('05','06','07','08'))){?>
                    <picture>
                        <source srcset="<?php echo $this->Url->build('/',true)?>images/collage-ete.webp" type="image/webp">
                        <source srcset="<?php echo $this->Url->build('/',true)?>images/collage-ete.png" type="image/png">
                        <img class="img-fluid" src="<?php echo $this->Url->build('/')?>images/collage-ete.png" >
                    </picture> 
                <?php }else{ ?>
                    <picture>
                        <source srcset="<?php echo $this->Url->build('/',true)?>images/collage-hiver.webp" type="image/webp">
                        <source srcset="<?php echo $this->Url->build('/',true)?>images/collage-hiver.png" type="image/png">
                        <img class="img-fluid" src="<?php echo $this->Url->build('/')?>images/collage-hiver.png" >
                    </picture> 
                <?php } ?>               
            </div>
        </div>
    </div>
</div>
<!-- Composition séjour -->
<section id="composition-sejour" class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-5 ">
                <h2 class="text-center h1"><?= __("Composez votre séjour en station de ski") ?></h2>
            </div>
            <div class="col-md-4 mb-5">
                <div class="shadow-sm border-0 h-100 bg-white">
                    <div class="thumbnail">
                        <img src="#" data-src="<?php echo $this->Url->build('/',true)?>images/location-de-vacances-entre-particuliers-station-de-ski.jpg">
                        <div class="caption p-4">
                            <h3><?= __("Locations de vacances entre particuliers") ?></h3>
                            <p> <?= __("Trouvez l'hébergement parfait pour vos prochaines vacances à la montagne sur Alpissime grâce à une offre d'hébergements 100% vérifiés.") ?></p>
                            <p class="text-center mb-0">
                                <a href="<?php echo $this->Url->build('/',true).$urlLang?>">
                                    <button class="btn btn-blue text-white rounded-0 px-5 mt-3" type="button">
                                        <?= __("Réserver") ?>
                                    </button>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-5">
                <div class="shadow-sm border-0 h-100 bg-white">
                    <div class="thumbnail">
                        <?php if(in_array(date("m"),array('05','06','07','08'))){?>
                            <img src="#" data-src="<?php echo $this->Url->build('/',true)?>images/activites-a-la-montagne-ete.jpg">
                        <?php }else{ ?>
                            <img src="#" data-src="<?php echo $this->Url->build('/',true)?>images/activites-en-station-de-ski.jpg">
                        <?php } ?>
                        <div class="caption p-4">
                            <?php if(in_array(date("m"),array('05','06','07','08'))){?>
                                <h3><?= __("Activités à la montagne") ?></h3>
                            <?php }else{ ?>
                                <h3><?= __("Activités en station de ski") ?></h3>
                            <?php } ?>       
                            <p> <?= __("Forfaits, cours ou location de ski, randonnées avec des guides de haute montagne ou location de matériel...<br>Ajoutez des activités proposées par les professionnels de votre station.") ?></p>
                            <p class="text-center mb-0">
                                <a href="<?php echo BOUTIQUE_ALPISSIME; ?>">
                                    <button class="btn btn-blue text-white rounded-0 px-5 mt-3" type="button">
                                    <?= __("Découvrir") ?>
                                    </button>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-5">
                <div class="shadow-sm border-0 h-100 bg-white">
                    <div class="thumbnail">
                        <img src="#" data-src="<?php echo $this->Url->build('/',true)?>images/services-de-conciergerie-station-de-ski.jpg">
                        <div class="caption p-4">
                            <h3><?= __("Services de conciergerie") ?></h3>
                            <p><?= __("Toute une gamme de services pour faciliter vos vacances : ménage, location de linge, location de matériel de puériculture... avec Alpissime, les vacances sont plus faciles !") ?></p>
                            <p class="text-center mb-0">
                                <a href="<?php echo BOUTIQUE_ALPISSIME; ?>">
                                    <button class="btn btn-blue text-white rounded-0 px-5 mt-3" type="button">
                                    <?= __("Découvrir") ?>
                                    </button>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="mt-n5 p-3 text-white checked-div row align-items-center mx-1">
        <div class="col col-md-1">
            <img src="#" data-src="<?php echo $this->Url->build('/',true)?>images/check-sign.png">        
        </div>
        <div class="col-10 col-md-11">
            <?= __("Tous les hébergements proposés sur Alpissime.com font l'objet d'une vérification manuelle par notre équipe. Réservez sereinement votre location de vacances avec Alpissime !") ?> 
        </div>
    </div>
    <div class="row mx-1">
        <a href="<?php echo $this->Url->build('/').$urlLang; ?>">
            <?php if(in_array(date("m"),array('05','06','07','08'))){
                if($this->Session->read('Config.language') == 'fr_FR') $mediasejourimage = $mediasejour->lien_ete; else $mediasejourimage = $mediasejour->_translations[$this->Session->read('Config.language')]->lien_ete;  
            ?>
                <picture>
                    <source srcset="<?php echo $this->Url->build('/',true).$mediasejourimage;?>.webp" type="image/webp">
                    <source srcset="<?php echo $this->Url->build('/',true).$mediasejourimage;?>.jpg" type="image/jpg">
                    <img class="img-fluid" src="<?php echo $this->Url->build('/').$mediasejourimage;?>.jpg" class="w-100 my-5 rounded-5">
                </picture> 
                <!-- <img src="#" data-src="<?php // echo $this->Url->build('/')?>images/sejour-montagne-paiement-4-fois-sans-frais-ete-2.jpg" class="w-100 my-5 rounded-5"> -->
            <?php }else{
                if($this->Session->read('Config.language') == 'fr_FR') $mediasejourhiverimage = $mediasejour->lien_hiver; else $mediasejourhiverimage = $mediasejour->_translations[$this->Session->read('Config.language')]->lien_hiver;
            ?>
                <picture>
                    <source srcset="<?php echo $this->Url->build('/',true).$mediasejourhiverimage;?>.webp" type="image/webp">
                    <source srcset="<?php echo $this->Url->build('/',true).$mediasejourhiverimage;?>.jpg" type="image/jpg">
                    <img class="img-fluid" src="<?php echo $this->Url->build('/').$mediasejourhiverimage;?>.jpg" class="w-100 my-5 rounded-5">
                </picture>
                <!-- <img src="#" data-src="<?php // echo $this->Url->build('/')?>images/sejour-ski-paiement-4-fois-sans-frais.jpg" class="w-100 my-5 rounded-5"> -->
            <?php } ?>  
        </a>
    </div>
</div>
<!-- Liste Annonces -->
<section class="pb-5">
    <div class="container">
        <div class="row pb-5">
			<div class="col">
                <h2 class="text-center h1"><?= __("Les dernières locations de vacances entre particuliers") ?></h2>
			</div>
		</div>
		<div class="row">
            <div class="col-md-12 product">
                <div id="myCarousela" class="carousel slide clients">
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        <?php $test="active" ?>
                        <?php $x=7; $i=0; for($j=0;$j<=(count($annonces)/8);$j++) {?>
                        <div class="<?php echo $test?> carousel-item">
                            <?php $test="" ?>
                            <div class="products row">
                                <?php
                                while($i<=$x && $i<count($annonces)) {?>
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <?php echo $this->element('petite_annonce', array('annonce'=>$annonces[$i], 'photo'=>$photos, 'residence'=>$residence, 'minprixannonce'=>$minprixannonce, 'noteglobalmoy'=>$noteglobalmoytab, 'db'=>'', 'fn'=>'') ); ?>
                                    </div>
                                 <?php $i++;} $x=$x+8;?>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
		</div>
	</div>
</section>
<!-- Liste stations -->
<section id="composition-sejour" class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 pb-5 ">
                <h2 class="text-center h1"><?= __("Trouvez votre location de vacances dans les meilleures stations de ski") ?></h2>
            </div>
            <?php foreach ($stations as $station_liste) { 
                foreach ($station_liste['lieugeos'] as $stationdetail) { ?>
                <div class="col-md-4 mb-3">
                    <a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['station']?>/<?php echo $stationdetail->nom_url; ?>"><?php echo $stationdetail->name; ?></a>
                </div>
            <?php }
            } ?>                        
        </div>
    </div>
</section>
<!-- Section pourquoi alpissime -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
			<div class="col-md-12 text-center">
                <h1><?= __("Séjour ski tout compris - Composez facilement le séjour ski qui vous ressemble.") ?></h1>
                <h2 class="font-weight-bold mt-3"><?= __("Choisissez le séjour ski tout compris sur Alpissime pour faciliter l'organisation de vos vacances") ?></h2>
                <p class="p-3"><?= __("Vous avez comme une envie de montagne et vous désespérez d'entendre le crissement de la neige sous vos spatules ? Réservez en quelques clics votre séjour tout compris sur Alpissime ! <br>Réserver un séjour en station de ski en tout compris comporte de nombreux avantages. Réunissez en une seule commande votre hébergement, vos activités préférées et même des services pour composer le séjour qui vous ressemble. <br>Facilitez l'organisation de vos vacances en réservant votre séjour ski tout compris sur Alpissime. Que vous cherchiez à réserver des vacances en famille ou entre amis, le séjour ski qui vous convient se trouve sur Alpissime. <br>Commencez par sélectionner un hébergement. Laissez libre cours à vos envies, du chalet grand luxe pour 15 personnes skis aux pieds à l'appartement cosy situé en centre station, Alpissime vous propose une large gamme d'hébergements en station de ski : locations de particuliers, résidences de tourisme, hôtels (prochainement !), ou encore gîtes. Ajoutez ensuite à votre commande les activités qui vous conviennent : forfaits de ski des remontées mécaniques de votre station, location de matériel de ski auprès de professionnels qualifiés et experts de la glisse, cours de ski par des moniteurs certifiés de l'Ecole de Ski Français ESF ou de l'Ecole de Ski Internationale ESI. <br>Récupérez les clés de votre hébergement, votre matériel de ski et les forfaits de remontées mécaniques sans perdre un instant. Plus besoin de faire le tour de la station pour comparer les meilleures offres : composez votre séjour ski tout compris sur Alpissime en quelques clics.") ?></p>
                <button class="btn btn-blue text-white rounded-circle collapse-button-chevron p-0" type="button" data-toggle="collapse" data-target="#collapsePourquoi" aria-expanded="false" aria-controls="collapsePourquoi">
                <i class="fa fa-chevron-up font-size-small"></i>
                <i class="fa fa-chevron-down font-size-small"></i>
                </button>
			</div>
            <div class="collapse bg-white m-3 p-3 p-md-5" id="collapsePourquoi">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="font-weight-bold py-3"><?= __("Séjour ski tout compris pas cher") ?></h2>
                    <p><?= __("Une fois votre séjour ski tout compris composé, vous aurez la possibilité de régler jusqu'à 4x sans frais ! Les séjours au ski sont chers et nous en sommes conscients. C'est pour cela que chez Alpissime, nous mettons tout en œuvre pour préserver votre budget. Votre séjour ski tout compris pas cher se réserve facilement sur Alpissime grâce aux réductions négociées auprès de nos partenaires : vos forfaits, votre matériel de ski ou les cours de ski pour les enfants peuvent bénéficiez de jusqu'à 50% de réduction. Encore mieux! Votre séjour ski tout compris peut être réglé jusqu'à 4 fois sans frais. Il suffit de s'y prendre tôt ! Faîtes des économies sur la réservation de votre séjour à la carte en tout compris sur Alpissime.com et profitez pleinement des joies des stations de sport d'hiver.") ?></p>
                    
                    <h2 class="font-weight-bold py-3"><?= __("Réservez votre séjour ski en tout compris sur Alpissime") ?></h2>
                    <p><?= __("Alpissime vous propose des séjours ski à la montagne en tout compris. C'est le meilleur moyen pour faire des économies sur votre séjour, en bénéficiant en plus d'un paiement pouvant aller jusqu'à 4x sans frais ! Alpissime est le spécialiste de la location de vacances entre particuliers en station de ski. Depuis 2009, nous proposons aux vacanciers des locations d'hébergements en station de ski vérifiés par notre équipes de professionnels de la montagne. En résumé, réserver votre séjour à la montagne sur Alpissime c'est profiter d'un tout compris qui vous facilite la vie et vous fait faire des économies pour vous permettre de vous concentrer sur ce qui importe vraiment : votre famille, vos amis, vos expériences et moments de partage pour un séjour ski réussi.") ?></p>

                    <h2 class="font-weight-bold py-3"><?= __("Package séjour ski tout compris") ?></h2>
                    <p><?= __("Vous souhaitez réserver un package séjour ski tout compris ? Les packages composés seront bientôt disponibles sur Alpissime. Vous pourrez réserver en un clic votre séjour en indiquant simplement les dates pendant lesquelles vous souhaitez vous rendre en station de ski et le nombre de personnes. Vous n'aurez plus qu'à cliquer sur réserver !") ?></p>
                </div>
                <div class="col-md-6">
                    <h2 class="font-weight-bold py-3"><?= __("Choisissez votre destination préférée pour votre prochain séjour ski tout compris") ?></h2>
                    <p><?= __("Que vous soyez déjà adepte du ski ou que vous souhaitiez découvrir les sports d'hiver pour la première fois, vous pouvez réserver le séjour ski tout compris dans un domaine skiable qui vous ressemble. Des stations de sport d'hiver internationales comme <a href='{0}station/Les-Arcs'>Les Arcs</a>, <a href='{1}station/la-plagne'>La Plagne</a>, <a href='{2}station/montchavin-les-coches'>Montchavin Les Coches</a>, <a href='{3}station/val-thorens'>Val Thorens</a>, <a href='{4}station/les-menuires'>Les Ménuires</a>… aux stations villages au charme authentique comme le <a href='{5}station/val-d-allos'>Val d'Allos</a>, <a href='{6}station/risoul-domaine-de-la-foret-blanche'>Risoul</a>, ou <a href='{7}station/peisey-vallandry'>Peisey Vallandry</a>, Alpissime vous propose différentes formules de séjour ski tout compris. Choisissez votre séjour ski tout compris à la semaine dans la destination de votre choix ou opter pour un séjour ski à la carte en court séjour.", [$this->Url->build('/',true),$this->Url->build('/',true),$this->Url->build('/',true),$this->Url->build('/',true),$this->Url->build('/',true),$this->Url->build('/',true),$this->Url->build('/',true),$this->Url->build('/',true)]) ?></p>
                    
                    <h2 class="font-weight-bold py-3"><?= __("Mon séjour ski en all inclusive") ?></h2>
                    <p><?= __("Réserver votre séjour tout compris sur Alpissime en quelques clics. Vous recevrez ensuite un mail de validation. Vous serez accueilli en station par les professionnels de nos équipes de conciergerie, par le propriétaire de l'hébergement que vous avez loué ou par sa conciergerie partenaire le cas échéant. Rendez-vous directement auprès de votre magasin de ski, de la caisse des forfaits et de l'ESF. Plus besoin de perdre du temps à faire le tour de la station : votre commande vous attend et vous n'avez qu'à faire les retraits ! C'est ça la magie du séjour ski tout compris sur Alpissime : facilité et économies pour profiter de la montagne à 100% ! Pendant que les parents dévalent les pistes, les enfants apprennent avec les moniteurs partenaires Alpissime de l'ESF ou ESI.") ?></p>
                </div>
            </div>
            </div>
		</div>
    </div>
</section>
<!-- End Section pourquoi alpissime -->
<!-- Section partners -->
<section id="partners" class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center text-md-left">
                <h2 class="title-newsletter pb-3"><?= __("Nos partenaires") ?></h2>
            </div>
			<div class="col-md-12">
                <div class="regular slider">
                    <?php foreach ($stations as $station_liste) { 
                        foreach ($station_liste['lieugeos'] as $station) {
                            if($station->image != ''){ ?>
                            <div >
                                <picture>
                                    <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.webp" type="image/webp">
                                    <source srcset="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.png" type="image/png">
                                    <img alt="Partenaire <?php echo $station->name;?>" src="<?php echo $this->Url->build('/',true)?>images/partners/<?php echo $station->image; ?>.png"/>
                                </picture>
                            </div>
                        <?php } 
                        } 
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Section partners -->