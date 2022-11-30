<?php $this->append('cssTopBlock', '<style>
.banner{
    background-image: url('.$this->Url->build('/',true).'images/depot/bar-img.png), url('.$this->Url->build('/',true).'images/depot/banner-tampon.jpg);
    background-size: auto, cover;
    background-position: left bottom, center;
    background-repeat: no-repeat;
    height: 420px;
    border-radius: 20px;
}
.mt-n50{
    margin-top: -50%;
}
@media (min-width: 1265px){
    .mt-xl-n7{margin-top: -5rem;}
}
h2{
    font-size: calc(25px + (31 - 25) * ((100vw - 300px)/ (2000 - 300)));
}
.img-icon{
    height: 80px;
    width: 80px;
    object-fit: contain;
}
.degrade-grey{
    background: rgb(244,244,244);
    background: linear-gradient(0deg, rgba(244,244,244,1) 0%, rgba(255,255,255,1) 100%);
    padding-bottom: 115px;
}
.rounded-50{
    border-radius: 50px;
}
.rounded-20{
    border-radius: 20px;
}
.mt-n200{
    margin-top: -108px;
}
.carousel-inner{
    width: 90%;
    margin: 0 auto;
}
.carousel-control-prev-icon {
    background-image: url('.$this->Url->build('/',true).'images/depot/symbole-fleche-gauche-noir.png);
}
.carousel-control-next-icon {
    background-image: url('.$this->Url->build('/',true).'images/depot/symbole-fleche-droite-noir.png);
}
.check-icon:before{
    content: "";
    background-image: url('.$this->Url->build("/",true).'images/depot/check-icon.png);
    background-size: 75%;
    background-repeat: no-repeat;
    background-position: left bottom;
    width: 24px;
    height: 21px;
    display: inline-block;
    margin-right: 10px;
}
.bg-form{
    background-image: url('.$this->Url->build('/',true).'images/depot/bg-form.jpg);
    background-repeat: no-repeat;
    background-position: center bottom;
    background-size: cover;
    border-radius: 0 50px 50px 0;
    align-self: flex-end;
}
.bg-form form{
    width: 70%;
    margin: 0 auto;
    margin-top: 9vh;
    margin-bottom: -9vh;
}
.bg-form form.form-2{
    margin-bottom: -3vh;
}
.table-tampon thead th, .table-tampon th, .table-tampon td{
    border: none;
}
.option-yes:before{
    background-image: url('.$this->Url->build('/',true).'images/depot/checkmark.png);
    background-repeat: no-repeat;
    background-size: cover;
    width: 15px;
    height: 15px;
    content: "";
    display: inline-block;
}
.option-no:before{
    background-image: url('.$this->Url->build('/',true).'images/depot/uncheckmark.png);
    background-repeat: no-repeat;
    background-size: cover;
    width: 12px;
    height: 12px;
    content: "";
    display: inline-block;
}
.bg-bar{
    background-image: url('.$this->Url->build('/',true).'images/depot/bar-img.png);
    background-size: auto;
    background-repeat: no-repeat;
    background-position: left bottom;
}
.card  .btn-link.focus, .card .btn-link:focus, .card .btn-link:hover{
    text-decoration: none;
}
#accordionExample .card h2:after{
    content:"\f107";
    font-family: "FontAwesome";
    position: absolute;
    right: 35px;
    margin-top: -38px;
}
#magazine .thumbnail img {
    min-height: 200px;
}
.error {
    color: red;
    border-color: red;
}
.carousel-control-prev {
    left: -36px;
}
.carousel-control-next {
    right: -36px;
}
.propt {
    font-size: 23px;
    font-weight: bold;
}
.tooltipsvc{
    font-size: 70%;
}
@media (max-width: 767.98px){
    .w-50{width: 100% !important;}
    .w-25{width: 50% !important;}
    .rounded-50, .bg-form, .rounded-20{border-radius: 0;}
    .carousel-control-prev{left: -25px;}
    .carousel-control-next{right: -25px;}
    .mt-n50{margin-top: -10%;}
    #accordionExample .card h2:after{right: 15px;}
    .banner{height: 290px;background-size: 45%, cover;}
    .changewidth{width: 95%;}
    h1.text-white{font-size:28px}
    .text-header {height: 100%;
        background: rgba(0,0,0,.2);
        text-shadow: 2px 2px 4px rgb(0 0 0 / 32%);
        border-radius: 20px;
        padding-top: 17%;}
}
@media (min-width: 767.98px){
    div#carouseltampon {
        height: 175px;
    }
    .carousel-item {
        height: 170px;
    }
}

</style>'); ?>

<div class="container-fluid mt-3 mb-4" id="toptampon">
    <div class="banner row m-0 align-items-center">
        <div class="text-center text-header d-block d-md-none">
            <h1 class="text-white mb-4 font-weight-bold"><?= __("Gagnez jusqu'à 11690€ par an en déposant votre annonce sur Alpissime"); ?><span class="tooltipsvc" data-toggle="tooltip" data-placement="right" title="<p><?= __("Moyenne constatée dans les stations de Tarentaise pendant la saison d'hiver 2021-2022 et la saison d'été 2022 pour un appartement de 41 à 50m²"); ?></p>"><i class="fa fa-question-circle-o"></i></span></h1>
        </div>
    </div>
    <div class="row align-items-end">
        <div class="col-md-3 col-sm-6 mt-3 order-2 order-md-1">
            <div class="row">
                <div class="col"><img src="<?php echo $this->Url->build('/')?>images/depot/logo-banner1.png" data-src="<?php echo $this->Url->build('/')?>images/depot/logo-banner1.png" class="img-fluid"></div>
                <div class="col"><img src="<?php echo $this->Url->build('/')?>images/depot/logo-banner2.png" data-src="<?php echo $this->Url->build('/')?>images/depot/logo-banner2.png" class="img-fluid"></div>
                <div class="col"><img src="<?php echo $this->Url->build('/')?>images/depot/logo-banner3.png" data-src="<?php echo $this->Url->build('/')?>images/depot/logo-banner3.png" class="img-fluid"></div>
            </div>
        </div>
        <div class="col-md-6 mt-n50 order-1 order-md-2">
            <div class="bg-white p-3 p-md-5 border shadow-sm">
                <h1 class="mb-4 font-weight-bold d-none d-md-block"><?= __("Gagnez jusqu'à 11690€ par an en déposant votre annonce sur Alpissime"); ?> <span class="tooltipsvc" data-toggle="tooltip" data-placement="right" title="<p><?= __("Moyenne constatée dans les stations de Tarentaise pendant la saison d'hiver 2021-2022 et la saison d'été 2022 pour un appartement de 41 à 50m²"); ?></p>"><i class="fa fa-question-circle-o"></i></span></h1>
                <?php echo $this->Form->create($annonce,['url' => SITE_ALPISSIME.$urlLang."annonces/depotannonce",'id'=>'DepotAnnonce','class'=>'DepotAnnonce','novalidate']);?>
                    <div class="form-group">
                        <select name="lieugeo_id" class="form-control custom-select rounded-0" id="lieugeo-id">
                            <option value="0"><?= __("Sélectionnez la station de votre hébergement") ?> *</option>
                            <?php foreach ($listeStations as $value) { ?>
                                <option class="font-weight-bold" value="massif_<?php echo $value->id; ?>"><?php echo $value->nom; ?></option>
                                    <?php foreach ($value['lieugeos'] as $key) { ?>
                                        <?php if($key->id){ ?><option value="<?php echo $key->id; ?>" <?php if($station->id == $key->id) echo "selected"?>>&nbsp;&nbsp;&nbsp;<?php echo $key->name; ?></option><?php } ?>
                                    <?php } ?>                                    
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group form-row">
                        <div class="col">
                            <?php echo $this->Form->input('nature',['label'=>false,'empty'=>__("Type d'hébergement")." *",'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_natures_location,'class'=>'form-control custom-select rounded-0','required'])?>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col">
                            <?php echo $this->Form->input('personnes_nb',['label'=>false,'empty'=>__("Nombre de voyageurs")." *",'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_nombre_personnes,'class'=>'form-control custom-select rounded-0','required'])?>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group form-row justify-content-end">
                    <div class="col-6"><button type="submit" id="Depot_1" class="btn btn-blue text-white rounded-0 w-100"><?= __("Commencer"); ?></button></div>
                    </div>
                <?php echo $this->Form->end();?>        
            </div>
        </div>
        <!-- <div class="col-md-3 col-sm-6 mt-3 order-3 order-md-3">
            <p class="text-right text-small mt-xl-n7"><?= __("Moyenne constatée sur un appartement de 41 à 50m²"); ?></p>
        </div> -->
    </div>
</div>
<div class="degrade-grey">
    <div class="container pt-5">
        <h2 class="text-center font-weight-bold mb-5"><?= __("Location de vacances entre particuliers en station de ski"); ?></h2>
        <div class="row">
            <div class="col-12 col-sm-4">
                <div class="card h-100 bg-transparent border-0 mb-4 mb-lg-0">
                    <div class="card-body text-center p-0">
                        <div class="bg-white shadow d-inline-block p-4 rounded-circle mb-4">
                            <img src="<?php echo $this->Url->build('/')?>images/depot/ic1.png" data-src="<?php echo $this->Url->build('/')?>images/depot/ic1.png" class="img-icon">
                        </div>
                        <h3 class="mb-3 font-weight-bold"><?= __("Attirez des vacanciers de toute l’Europe"); ?></h3>
                        <p><?= __("Les vacanciers Français, Anglais, Belges et Néerlandais utilisent Alpissime pour trouver leur location de vacances idéale"); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="card h-100 bg-transparent border-0 mb-4 mb-lg-0">
                    <div class="card-body text-center p-0">
                        <div class="bg-white shadow d-inline-block p-4 rounded-circle mb-4">
                            <img src="<?php echo $this->Url->build('/')?>images/depot/ic2.png" data-src="<?php echo $this->Url->build('/')?>images/depot/ic2.png" class="img-icon">
                        </div>
                        <h3 class="mb-3 font-weight-bold"><?= __("Augmentez vos revenus en un clin d’oeil"); ?></h3>
                        <p><?= __("Déposez votre annonce en quelques minutes et comencez à recevoir des demandes de réservation"); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="card h-100 bg-transparent border-0 mb-4 mb-lg-0">
                    <div class="card-body text-center p-0">
                        <div class="bg-white shadow d-inline-block p-4 rounded-circle mb-4">
                            <img src="<?php echo $this->Url->build('/')?>images/depot/ic3.png" data-src="<?php echo $this->Url->build('/')?>images/depot/ic3.png" class="img-icon">
                        </div>
                        <h3 class="mb-3 font-weight-bold"><?= __("Louez votre hébergement en toute sérénité"); ?></h3>
                        <p><?= __("Sécurisez vos réservations grâce à Serenity : un système ingénieux de caution et d’inventaire en ligne"); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center my-5">
            <div class="col-sm-4"><a class="btn btn-blue text-white rounded-0 w-100 scrollLink" href="#toptampon"><?= __("Commencer"); ?></a></div>
        </div>
        <h2 class="text-center font-weight-bold pt-5"><?= __("Sécurisez vos réservations, sans effort"); ?></h2>
    </div>
</div>
<div class="container bg-white shadow rounded-50 px-5 pt-5 pb-4 mt-n200">
    <div id="carouseltampon" class="carousel slide" data-ride="carousel">        
        <div class="row d-flex align-items-center">
            <div class="col-sm-6">
                <img src="<?php echo $this->Url->build('/')?>images/depot/logo-serenity.png" data-src="<?php echo $this->Url->build('/')?>images/depot/logo-serenity.png" class="img-fluid">
            </div>
            <div class="carousel-inner col-sm-6">
                <div class="carousel-item active">
                    <h4 class="font-weight-bold check-icon"><?= __("Revenus garantis en cas d'annulation"); ?></h4>
                    <p><?= __("Il est souvent difficile de louer son hébergement à la dernière minute. Aussi, si les vacanciers annulent leur venue à moins d'une semaine de la date d'arrivée, vous touchez la totalité du montant de la réservation."); ?></p>
                </div>
                <div class="carousel-item">
                    <h4 class="font-weight-bold check-icon"><?= __("Suivi de l'état de l'hébergement"); ?></h4>
                    <p><?= __("Renseignez l'inventaire de votre appartement dans votre annonce. Il sera envoyé aux vacanciers lors de leur arrivée. Une fois complété, vous le retrouverez dans votre espace réservation."); ?></p>
                </div>
                <div class="carousel-item">
                    <h4 class="font-weight-bold check-icon"><?= __("Réponse garantie sous 24h"); ?></h4>
                    <p><?= __("Parce que l'univers du voyage demande une réactivité à toute épreuve, vous bénéficiez d'un contact dédié. Fini les intervenants multiples et les délais de réponse à rallonge !"); ?></p>
                </div>
                <div class="carousel-item">
                    <h4 class="font-weight-bold check-icon"><?= __("Réponse garantie sous 24h"); ?></h4>
                    <p><?= __("Parce que l'univers du voyage demande une réactivité à toute épreuve, vous bénéficiez d'un contact dédié. Fini les intervenants multiples et les délais de réponse à rallonge !"); ?></p>
                </div>
            </div>
        </div>            
        <div class="carousel-item">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <img src="<?php echo $this->Url->build('/')?>images/depot/logo-serenity.png" data-src="<?php echo $this->Url->build('/')?>images/depot/logo-serenity.png" class="img-fluid">
                </div>
                <div class="col-sm-6">
                    <h4 class="font-weight-bold check-icon"><?= __("Suivi de l'état de l'hébergement"); ?></h4>
                    <p><?= __("Renseignez l'inventaire de votre appartement dans votre annonce. Il sera envoyé aux vacanciers lors de leur arrivée. Une fois complété, vous le retrouverez dans votre espace réservation."); ?></p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <img src="<?php echo $this->Url->build('/')?>images/depot/logo-serenity.png" data-src="<?php echo $this->Url->build('/')?>images/depot/logo-serenity.png" class="img-fluid">
                </div>
                
            </div>
        </div>
        <a class="carousel-control-prev justify-content-start w-auto opacity-1" href="#carouseltampon" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon border border-dark rounded-circle" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next justify-content-end w-auto opacity-1" href="#carouseltampon" role="button" data-slide="next">
            <span class="carousel-control-next-icon border border-dark rounded-circle" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
<div class="container py-5">
        <h2 class="text-center font-weight-bold mb-5"><?= __("Améliorez vos revenus en quelques clics"); ?></h2>
        <div class="row">
            <div class="col-12 col-sm-4">
                <div class="card h-100 bg-transparent shadow mx-lg-3 border-0 mb-4 mb-lg-0">
                    <div class="card-body text-center py-3 px-lg-5">
                        <div class="d-inline-block mt-3">
                            <img src="<?php echo $this->Url->build('/')?>images/depot/ic4.png" data-src="<?php echo $this->Url->build('/')?>images/depot/ic4.png" class="img-icon">
                        </div>
                        <h3 class="mb-3 font-weight-bold"><?= __("Je dépose mon <br>annonce"); ?></h3>
                        <p><?= __("Déposez votre annonce en 10 minutes. C’est gratuit, et sans engagement."); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="card h-100 bg-transparent shadow mx-lg-3 border-0 mb-4 mb-lg-0">
                    <div class="card-body text-center py-3 px-lg-5">
                        <div class="d-inline-block mt-3">
                            <img src="<?php echo $this->Url->build('/')?>images/depot/ic5.png" data-src="<?php echo $this->Url->build('/')?>images/depot/ic5.png" class="img-icon">
                        </div>
                        <h3 class="mb-3 font-weight-bold"><?= __("Je reçois des réservations"); ?></h3>
                        <p><?= __("Vous êtes libre d’accepter ou de refuser les demandes de réservation que vous recevez."); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="card h-100 bg-transparent shadow mx-lg-3 border-0 mb-4 mb-lg-0">
                    <div class="card-body text-center py-3 px-lg-5">
                        <div class="d-inline-block mt-3">
                            <img src="<?php echo $this->Url->build('/')?>images/depot/ic6.png" data-src="<?php echo $this->Url->build('/')?>images/depot/ic6.png" class="img-icon">
                        </div>
                        <h3 class="mb-3 font-weight-bold"><?= __("Je perçois mes <br>revenus"); ?></h3>
                        <p><?= __("Accueillez les vacanciers et percevez vos revenus de manière sécurisée."); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center my-5">
            <div class="col-sm-4"><a class="btn btn-blue text-white rounded-0 w-100 scrollLink" href="#toptampon"><?= __("Référencer mon hébergement"); ?></a></div>
        </div>
</div>
<div class="container shadow rounded-50 p-0 changewidth">
    <div class="row no-gutters">
        <div class="col-md-5 p-5">
            <h2 class="font-weight-bold"><?= __("Besoin d’assistance ?"); ?></h2>
            <p class="m-0"><?= __("Nous répondons à vos questions ou prenons en charge la rédaction de votre annonce."); ?></p>
        </div>
        <div class="col-md-7 bg-form">
            <form action="" method="post" class="bg-white shadow p-4" id="frm_contact1">
                <div class="alert alert-success d-none alertfrmcontact1" role="alert">
                    <?= __("Votre message a été bien envoyé."); ?>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control rounded-0" name="nomPrenom1" id="nomPrenom1" placeholder="<?= __('Nom et prénom'); ?>">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control rounded-0" name="portable1" id="portable1" placeholder="<?= __('Numéro de téléphone'); ?>">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-0">
                    <button type="button" id="clickdemander1" class="btn btn-blue text-white rounded-0 w-100"><?= __("Demander à être rappelé"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Bloc icon à inserer-->
<!-- Section Infos -->
<div class="container py-5 mt-0 mt-md-4">
    <div class="row mt-5 pt-5">
        <div class="col-sm-12 col-md-4 mb-5">
            <div class="shadow p-4 h-100 text-center">
            <div class="d-block mb-0 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-2 ">
                    <img width="80" src="<?php echo $this->Url->build('/')?>images/ico/location-de-vacances-entre-particulier-station-de-ski-savoie.png" class="img-responsive">
                </div>
                <div><?= __("Spécialiste français de la location de PAP à la montagne depuis 2006") ?></div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-5">
            <div class="shadow p-4 h-100 text-center">
            <div class="d-block mb-0 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-2 ">
                <img width="70" src="<?php echo $this->Url->build('/')?>images/depot/securite.png" class="img-responsive">
                </div>
                <div><?= __("Paiement sécurisé et système unique d'assurances contre les dommages") ?></div>
            </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-5">
            <div class="shadow p-4 h-100 text-center">
            <div class="d-block mb-0 align-items-center h-100">
                <div class="mr-3 mr-md-0 mr-lg-3 text-center mb-2">
                    <img width="80" src="<?php echo $this->Url->build('/')?>images/ico/service-client.png" class="img-responsive">
                </div>
                <div><?= __("Assistance dédiée en direct par livechat et sous 12h par mail") ?></div>
            </div>
            </div>
        </div>    
    </div>
</div>
<!-- End Section Infos -->
<div class="container py-5">
    <h2 class="text-center font-weight-bold mb-5"><?= __("Pourquoi choisir déposer une annnonce sur Alpissime ?") ?></h2>
    <div class="table-responsive">
        <table class="table table-striped table-tampon text-center">
            <thead>
                <tr>
                <th scope="col"></th>
                <th scope="col">Alpissime</th>
                <th scope="col">Airbnb</th>
                <th scope="col">Abritel</th>
                <th scope="col">Le Bon Coin</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row" class="text-left"><?= __("Vérification des annonces") ?></th>
                <td><span class="option-yes"></span> <?= __("Manuelle") ?></td>
                <td><span class="option-no"></span> <?= __("Algorithmique") ?></td>
                <td><span class="option-no"></span> <?= __("Algorithmique") ?></td>
                <td><span class="option-no"></span> <?= __("Algorithmique") ?></td>
                </tr>
                <tr>
                <th scope="row" class="text-left"><?= __("Sécurité des réservations") ?></th>
                <td><span class="option-yes"></span> <?= __("Inventaire + Caution") ?></td>
                <td><span class="option-yes"></span> <?= __("Aircover (traitement long)") ?></td>
                <td><span class="option-yes"></span> <?= __("Caution") ?></td>
                <td><span class="option-no"></span>  <?= __("Accompte") ?></td>
                </tr>
                <tr>
                <th scope="row" class="text-left"><?= __("Service client") ?></th>
                <td><span class="option-yes"></span> <?= __("Livechat & tel (direct), mail (12h)") ?></td>
                <td><span class="option-no"></span> <?= __("Par d’autres hôtes") ?></td>
                <td><span class="option-yes"></span> <?= __("Telephone (direct)") ?></td>
                <td><span class="option-no"></span>  <?= __("Centre d’aide") ?></td>
                </tr>
                <tr>
                <th scope="row" class="text-left"><?= __("Acceptation des réservations") ?></th>
                <td><?= __("Propriétaire") ?></td>
                <td><?= __("Propriétaire, Automatique") ?></td>
                <td><?= __("Propriétaire, Automatique") ?></td>
                <td><?= __("Propriétaire") ?></td>
                </tr>
                <tr>
                <th scope="row" class="text-left"><?= __("Contrat de location") ?></th>
                <td><span class="option-yes"></span> <?= __("Pas nécessaire") ?></td>
                <td><span class="option-yes"></span> <?= __("Pas nécessaire") ?></td>
                <td><span class="option-yes"></span> <?= __("Pas nécessaire") ?></td>
                <td><span class="option-yes"></span> <?= __("Pas nécessaire") ?></td>
                </tr>
                <tr>
                <th scope="row" class="text-left"><?= __("Frais propriétaire") ?></th>
                <td>3% TTC</td>
                <td>3% HT</td>
                <td>8% HT</td>
                <td><?= __("Gratuit") ?></td>
                </tr>
                <tr>
                <th scope="row" class="text-left"><?= __("Services de conciergerie") ?></th>
                <td><span class="option-yes"></span> <?= __("Selon destination") ?></td>
                <td><span class="option-yes"></span> <?= __("Selon destination") ?></td>
                <td><span class="option-no"></span>  <?= __("Non") ?></td>
                <td><span class="option-no"></span>  <?= __("Non") ?></td>
                </tr>
                <tr>
                <th scope="row" class="text-left"><?= __("Synchronisation des calendriers") ?></th>
                <td><span class="option-yes"></span> <?= __("Oui") ?></td>
                <td><span class="option-yes"></span> <?= __("Oui") ?></td>
                <td><span class="option-no"></span>  <?= __("Oui") ?></td>
                <td><span class="option-no"></span>  <?= __("Non") ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="container bg-blue rounded-20 py-4 bg-bar">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center text-white my-5 pt-lg-5 w-50 mx-auto"><?= __("Améliorez vos revenus en référençant votre hébergement dès maintenant") ?></h2>
        </div>
        <div class="col-12 text-center">
            <a class="btn btn-white text-blue rounded-0 mx-auto w-25 mb-5 scrollLink" href="#toptampon"><?= __("Déposer une annonce") ?></a>
        </div>
    </div>
</div>
<div class="container py-5">
    <h2 class="text-center font-weight-bold mb-5"><?= __("Ils en parlent mieux que nous") ?></h2>
    <div class="row">
        <div class="col-12 col-sm-4">
            <div class="card h-100 bg-transparent shadow mx-3 border-0 mb-4 mb-lg-0">
                <div class="card-body text-center pt-3 px-4 pb-0">
                    <div class="d-inline-block mt-5">
                        <img src="<?php echo $this->Url->build('/')?>images/depot/rating.png" data-src="<?php echo $this->Url->build('/')?>images/depot/rating.png" class="w-75">
                    </div>
                    <p><?= __("Nous louons sur Alpissime depuis la création du site en 2006. La plateforme nous apporte un complément de revenu intéressant qui nous permet de payer nos charges et d'amortir nos vacances."); ?></p>
                    
                </div>
                <div class="card-body text-center row align-items-end pt-0">
                    <h2 class="mb-0 propt col-12">Murielle S.</h2>
                    <p class="m-0 font-italic col-12"><?= __("Propriétaire aux Arcs"); ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="card h-100 bg-transparent shadow mx-3 border-0 mb-4 mb-lg-0">
                <div class="card-body text-center pt-3 px-4 pb-0">
                    <div class="d-inline-block mt-5">
                        <img src="<?php echo $this->Url->build('/')?>images/depot/rating_4.png" data-src="<?php echo $this->Url->build('/')?>images/depot/rating_4.png" class="w-75">
                    </div>
                    <p><?= __("J'utilise Alpissime en plus d'Airbnb ce qui me permet d'assurer un très bon remplissage de mon chalet à Peisey. Avant la gestion était fastidieuse mais maintenant les calendriers de mes annonces sont synchronisés."); ?></p>
                    
                </div>
                <div class="card-body text-center row align-items-end pt-0">
                    <h2 class="mb-0 propt col-12">Patrick V.</h2>
                    <p class="m-0 font-italic col-12"><?= __("Propriétaire à Peisey Vallandry"); ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="card h-100 bg-transparent shadow mx-3 border-0 mb-4 mb-lg-0">
                <div class="card-body text-center pt-3 px-4 pb-0">
                    <div class="d-inline-block mt-5">
                        <img src="<?php echo $this->Url->build('/')?>images/depot/rating.png" data-src="<?php echo $this->Url->build('/')?>images/depot/rating.png" class="w-75">
                    </div>
                    <p><?= __("Nous avons déposé notre annonce il y a 3 ans et la plateforme est simple d'utilisation. Le service client est réactif et notre conseiller nous répond toujours rapidement en cas de problème, nous en sommes très satisfaits!"); ?></p>
                    
                </div>
                <div class="card-body text-center row align-items-end pt-0">
                    <h2 class="mb-0 propt col-12">Corine N.</h2>
                    <p class="m-0 font-italic col-12"><?= __("Propriétaire à Les 2 Alpes"); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container bg-blue rounded-20 py-5 bg-bar mb-5">
    <div class="row justify-content-center flex-column">
        <div class="col text-center mt-5">
            <img src="<?php echo $this->Url->build('/')?>images/depot/logo-box.png" data-src="<?php echo $this->Url->build('/')?>images/depot/logo-box.png" class="img-fluid">
            <h2 class="text-white w-50 mx-auto"><?= __("Votre partenaire de confiance pour la gestion de votre hébergement en station de ski depuis 2006") ?></h2>
        </div>
        <div class="col text-center mt-4">
            <a class="btn btn-white text-blue rounded-0 mx-auto w-25 mb-5" target="_blank" href="<?php echo $this->Url->build('/')?>fr-services-et-contrats-proprietaires-de-residences-secondaires/"><?= __("Découvrir nos conciergeries") ?></a>
        </div>
    </div>
</div>
<div class="container py-5">
    <h2 class="text-center font-weight-bold mb-5"><?= __("Vous avez des questions ?") ?></h2>
    <div class="accordion" id="accordionExample">
        <div class="card border-0 shadow rounded-lg mb-2">
            <div class="card-header border-0 bg-white " id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left text-dark font-weight-bold pl-0" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <?= __("Dans quelle station puis-je déposer une annonce ?") ?>
                </button>
            </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <?= __("Vous pouvez proposer un hébergement à la location dans plus de 100 stations de ski en France. Vous ne trouvez pas votre station ? N'hésitez pas à nous contacter et nous l'ajouterons rapidement.") ?>
            </div>
            </div>
        </div>
        <div class="card border-0 shadow rounded-lg mb-2">
            <div class="card-header border-0 bg-white" id="headingTwo">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left text-dark font-weight-bold pl-0" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <?= __("Qui peut déposer une annonce sur Alpissime ?") ?> 
                </button>
            </h2>
            </div>

            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <?= __("Tous les propriétaires de résidences secondaires en station de ski et dans les communes environnantes peuvent déposer une annonce sur Alpissime.") ?>
            </div>
            </div>
        </div>
        <div class="card border-0 shadow rounded-lg mb-2">
            <div class="card-header border-0 bg-white" id="headingThree">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left text-dark font-weight-bold pl-0" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <?= __("Mon annonce est-elle visible directement ?") ?>
                </button>
            </h2>
            </div>

            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
                <?= __("Votre annonce sera mise en ligne dès sa validation par notre équipe (généralement sous 12h à 24h). Toutes les annonces sont vérifiées par de vrais humains, afin de garantir à nos clients vacanciers une offre réelle d'hébergements. Vous l'aurez compris, sur Alpissime il n'y a jamais eu d'arnaque à la location de vacances, et nous veillons à ce que cela continue !") ?>
            </div>
            </div>
        </div>
        <div class="card border-0 shadow rounded-lg mb-2">
            <div class="card-header border-0 bg-white" id="headingFour">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left text-dark font-weight-bold pl-0" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                <?= __("La location est-elle sécurisée ? ") ?>
                </button>
            </h2>
            </div>

            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
            <div class="card-body">
                <?= __("Lorsque vous déposez votre annonce, vous avez la possibilité de choisir un montant de caution, qui sera pris sous la forme d'une empreinte bancaire lors du paiement du vacancier. Vous avez également la possibilité de joindre à votre annonce un inventaire que le locataire devra remplir sous 48h, et qui servira de base en cas de dommage.") ?>
                <br>
                <?= __("Plus d'informations : "); ?><a target="_blank" href="https://help.alpissime.com/aide/quest-ce-que-la-garantie-serenity-pour-les-proprietaires/"><?= __("Qu'est-ce que la garantie Serenity pour les Propriétaires ?") ?></a>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="container shadow rounded-50 p-0 my-5 changewidth">
    <div class="row no-gutters">
        <div class="col-md-5 px-5 pt-4 mt-2 mb-4 align-items-center">
            <h2 class="font-weight-bold"><?= __("Vous êtes professionnel de la location ?") ?></h2>
            <p class="m-0"><?= __("Contactez-nous pour obtenir un accès à nos outils de gestion pour les conciergeries et agences immobilières.") ?></p>
        </div>
        <div class="col-md-7 bg-form">
            <form action="" method="post" class="bg-white shadow p-4 form-2" id="frm_contact2">
                <div class="alert alert-success d-none alertfrmcontact2" role="alert">
                    <?= __("Votre message a été bien envoyé."); ?>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control rounded-0" name="nomPrenom2" id="nomPrenom2" placeholder="Nom et prénom">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control rounded-0" name="portable2" id="portable2" placeholder="Numéro de téléphone">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-0">
                    <button type="button" id="clickdemander2" class="btn btn-blue text-white rounded-0 w-100"><?= __("Demander à être rappelé") ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php 
// Get the JSON
if($language_header_name == "fr") $json = file_get_contents('https://www.alpissime.com/blog/wp-json/wp/v2/posts?categories=1168&per_page=3');
else $json = file_get_contents('https://www.alpissime.com/blog/wp-json/wp/v2/posts?categories=2910&per_page=3');
// Convert the JSON to an array of posts
$posts = json_decode($json);
?>
<?php if(count($posts) > 0){ ?>
<section id="magazine">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3 py-5 ">
                <h2 class="text-center font-weight-bold mb-0"><?= __("Conseils et astuces pour les propriétaires") ?></h2>
            </div>
            <?php foreach ($posts as $p) { 
                $featured_media = $p->featured_media;
                $json_media = file_get_contents('https://www.alpissime.com/blog/wp-json/wp/v2/media/'.$featured_media);
                $media = json_decode($json_media);
                if($media->media_details->sizes->medium_large->source_url) $url_media = $media->media_details->sizes->medium_large->source_url;
                else if($media->media_details->sizes->medium->source_url) $url_media = $media->media_details->sizes->medium->source_url;
                else $url_media = $media->media_details->sizes->large->source_url;                  
                ?>
            <div class="col-md-4 mb-5">
            <div class="shadow-sm border h-100">
            <a class="magazine-link" href="<?php echo $p->link ?>" target="blanc">
                <div class="thumbnail">
                    <img src="#" data-src="<?php echo $url_media; ?>">
                    <div class="caption p-4">
                        <h3><?php echo  $p->title->rendered;?></h3>
                        <?php echo  $p->excerpt->rendered;?>
                    </div>
                </div>
            </a>
            </div>
            </div>
            <?php }?>
        </div>
    </div>
</section>
<?php } ?>
<!-- End Section magazine -->

<?php $this->Html->script("/manager-arr/jqueryValidation/dist/jquery.validate.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/jqueryValidation/dist/localization/messages_fr.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('DepotAnnonce');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
        
      }, false);
    });
  }, false);
})();

$("section.main").removeClass('py-5');

$(document).ready(function(){
    $(".tooltipsvc").tooltip({
        html: true,
        trigger : "manual"
    });
    $( ".banner" ).mouseleave(function() {
        $(".tooltip").tooltip('hide');
    });    
    $('[data-toggle="tooltip"]').on('click', function () {
        $(this).tooltip('show');
    });

  $("#scrollto").click(function() {
    $('html, body').animate({
        scrollTop: $("#titreh1").offset().top
    }, 700);
  });

	$( "a.scrollLink" ).click(function( event ) {
		event.preventDefault();
		$("html, body").animate({ scrollTop: $($(this).attr("href")).offset().top }, 700);
	});

    $("#frm_contact1").validate({
      // validClass: "valid-success",
      errorPlacement: function errorPlacement(error, element) {
        //   if (element.attr("name") == "portable" ) {
        //       error.insertAfter("#error-msg");
        //     }else if (element.attr("name") == "pwd_confirm"){
        //       error.insertAfter("#error-msg-confirm");
        //     }else{
              element.after( error );
            // }    
      },
      rules: {
        nomPrenom1: {
            required:true,
        },
        portable1:{
            required:true,
            // telInputisNumber:true,
        }
      },
      invalidHandler: function(form, validator) {
        if (!validator.numberOfInvalids())
            return;

        // $('html, body').animate({
        //     scrollTop: $(validator.errorList[0].element).offset().top - 50
        // }, 1000);

        }
    });
    $("#clickdemander1").on('click',function() {
        if($("#frm_contact1").valid()){
            $.ajax({
                url: "<?php echo $this->Url->build("/")?>annonces/sendmailtobecontact",
                type: 'POST',
                dataType : 'json',
                data: {nomprenom: $("#nomPrenom1").val(), portable: $("#portable1").val() },
                success: function(data){
                    $(".alertfrmcontact1").removeClass("d-none");
                    $("#nomPrenom1").val("");
                    $("#portable1").val("");
                    setTimeout(function(){ 
                        $(".alertfrmcontact1").addClass("d-none");
                    }, 4000);
                }
            });
        }
    });

    $("#frm_contact2").validate({
        errorPlacement: function errorPlacement(error, element) {
            element.after( error );
        },
        rules: {
            nomPrenom2: {
                required:true,
            },
            portable2:{
                required:true,
                // telInputisNumber:true,
            }
        },
        invalidHandler: function(form, validator) {
            if (!validator.numberOfInvalids())
                return;
        }
    });
    $("#clickdemander2").on('click',function() {
        if($("#frm_contact2").valid()){
            $.ajax({
                url: "<?php echo $this->Url->build("/")?>annonces/sendmailtobecontact",
                type: 'POST',
                dataType : 'json',
                data: {nomprenom: $("#nomPrenom2").val(), portable: $("#portable2").val() },
                success: function(data){
                    $(".alertfrmcontact2").removeClass("d-none");
                    $("#nomPrenom2").val("");
                    $("#portable2").val("");
                    setTimeout(function(){ 
                        $(".alertfrmcontact2").addClass("d-none");                        
                    }, 4000);
                }
            });
        }
    });
});

<?php $this->Html->scriptEnd(); ?>