<?php
    $titreAnnonce = ucfirst(mb_strtolower($annonce["titre"]));

    $annonce["titre"] = htmlentities(str_replace(
        ["é","è","ê","à","â","ä","î","ï","ô","ö","ù","û","ü",",","'","É","%","œ","Œ","€","/","+","ç","*","?","!","°","<",">","----","---","--","²",":",],
        ["e","e","e","a","a","a","i","i","o","o","u","u","u"," "," ","e","pourcent","oe","oe","euros","-","-","c","","","","","","","-","-","-","","",],
        $annonce["titre"]
    ));

    $natureAnn = [
        "STD" => ['name' => __("Studio"), 'url'  => __("studio")],
        "APP" => ['name' => __("Appart."),   'url'  => __("appartement")],
        "CHA" => ['name' => __("Chalet"),'url'  => __("chalet")],
        "DIV" => ['name' => __("Location"),'url'  => __("location")],
        "VIL" => ['name' => __("Villa"),'url'  => __("villa")],
        "GIT" => ['name' => __("Gîte"),'url'  => __("gite")]
    ];
    $lannonce = strtolower(str_replace(" ","-", trim($annonce["titre"])));

    $url = $this->Url->build('/', true);
    $urlLang = $language_header_name != "fr" ? $language_header_name . "/" : "";
    $lieugeoUrl = $rechercheDispoLieugeo != "" ? $rechercheDispoLieugeo : $annonce['lieugeo']['nom_url'];
    $natureUrl = $natureAnn[$annonce['nature']]['url'] ? $natureAnn[$annonce['nature']]['url'] .'/' : '';
    $hrefDetailAnn = $url . $urlLang . $urlvaluemulti['station'] . '/' . $lieugeoUrl . '/' . $natureUrl . $annonce['id'] . "_" . $lannonce;

    if ($db != '' || $fn != '') {
        $hrefDetailAnn .= '/' . $db . '/' . $fn;

        if ($nbradlt != '' && $nbrenf != '') {
            $hrefDetailAnn .= '/' . $nbradlt . '/' . $nbrenf;

            if ($animaux) {
                $hrefDetailAnn .= '/' . $animaux;
            }
        }
    }

    $classe = "description-product";
    $immmg  = "alpissimeicon";
    if ($annonce['wifi_appartment'] > 0 || $annonce['wifi_payant'] > 0) {
        $classe = "description-product wifi";
        $immmg  = "wifimg";
    }

    if (in_array($annonce['nb_etoiles'], [1,2,3,4,5])) {
        $immmg = "stars" . $annonce['nb_etoiles'];
    }

    $dataLat = '';
    $dataLng = '';
    if(isset($residence) && isset($residence[$annonce['batiment']]['lat']) && isset($residence[$annonce['batiment']]['lon'])) {
        $dataLat = $residence[$annonce['batiment']]['lat'];
        $dataLng = $residence[$annonce['batiment']]['lon'];
    }

    $images    = array_slice($photo[$annonce['id']], 0, 4);
    $imagesCnt = count($images);
?>
<div class='featured-product hoverdiv' data-lat="<?= $dataLat ?>" data-lng="<?= $dataLng ?>">
    <div class="featured-image landing_img">
        <div id="carousel_annonce<?= $annonce['id'] ?>" class="carousel slide" data-interval="false">
            <ol class="carousel-indicators">
                <?php if ($imagesCnt == 0) { ?>
                <li data-target="#carousel_annonce<?= $annonce['id'] ?>" data-slide-to="0" class="active"></li>
                <?php } else if($imagesCnt > 1) {
                    for ($i = 0; $i < $imagesCnt; ++$i) {
                        $activeClass = $i == 0 ? "active" : "";
                ?>
                <li data-target="#carousel_annonce<?= $annonce['id'] ?>" data-slide-to="<?= $i ?>" class="<?= $activeClass ?>"></li>
                <?php }
                }
                ?>
            </ol>
            <div class="carousel-inner">
            <?php if ($imagesCnt == 0) { ?>
                <div class="carousel-item active">
                    <a target="_blank" href="<?= $hrefDetailAnn ?>">
                        <img class="datasrc" src="/images_ann/no_annonce_image.jpg" alt="Annonce <?= $annonce['id'] ?>" style="width:100%; height: 191px">
                    </a>
                </div>
            </div>
            <?php } else {
                for ($i = 0; $i < $imagesCnt; ++$i) {
                    $img = $images[$i];
                    $activeClass = $i == 0 ? " active" : "";
                    $imgUrl = '/images_ann/' . $annonce['id'] . '/' . "vignette-" . $annonce['id'] . "-" .$images[$i] . ".P.jpg?v=".(time()*1000);
            ?>
                <div class="carousel-item<?= $activeClass ?>">
                    <a target="_blank" href="<?= $hrefDetailAnn ?>">
                        <img class="datasrc" src="<?= $imgUrl ?>" alt="Image <?= $images[$i] ?> Annonce <?= $annonce['id'] ?>" style="width:100%; height: 191px">
                    </a>
                </div>
            <?php } // End of loop ?>
            <?php if ($imagesCnt > 1) { ?>
            <a class="carousel-control-prev" href="#carousel_annonce<?= $annonce['id'] ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel_annonce<?= $annonce['id'] ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
                <?php } // End of if ($imagesCnt > 1) ?>
            <?php } // End of else ?>
            </div>
        </div>
        <img src="#" data-src='/images/icon/img_trans.gif' alt='stars' class='product-etat <?= $immmg; ?>'>
        <?php if($minprixannonce[$annonce['id']]['promo'] == 1) echo '<span class="product-etat-btn mr-1">'.__("Promotion").'</span>'; ?>
        <?php if(isset($annonce['new_annonce']) && $annonce['new_annonce']) echo '<span class="ml-1 product-new-badge'.(($language_header_name == 'fr')?'-fr':'-en').'"></span>'; ?>
    </div>
    <div class="<?= $classe; ?>">
        <p>
            <?php
                if($rechercheDispoVillage != '') $annonce['village']["name"] = $rechercheDispoVillage;
                echo $natureAnn[$annonce['nature']]['name']." ".$annonce['personnes_nb']." ".__('pers.')." - ".$annonce['village']["name"];
            ?>
        </p>
        <p><a class='text' target='_blank' href='<?= $hrefDetailAnn ?>'><?= $titreAnnonce ?></a></p>
        <div class="d-flex flex-wrap my-0">
            <?php
                if ($minprixannonce[$annonce['id']]['prixmin'] !== '') {
                    if($db != '' && $fn != '') $minprixannonce[$annonce['id']]['prixmin'] = $minprixannonce[$annonce['id']]['prixmin']." / ".__("Nuitée");
                    else $minprixannonce[$annonce['id']]['prixmin'] = __("Dès ")." ".$minprixannonce[$annonce['id']]['prixmin']." / ".__("Nuitée");
                }
            ?>
            <span class="my-auto pr-1 size-md"><?= $minprixannonce[$annonce['id']]['prixmin']; ?></span>
            <?php if($db != '' && $fn != '' && $prixtotalpourpetiteannonce[$annonce['id']]['totalPrixPayer'] != 0 && $prixtotalpourpetiteannonce[$annonce['id']]['nbrjour'] != 0){ ?>
                <span id="spanprix<?= $annonce['id'] ?>">
                    <ul class='pl-4 my-0'>
                        <li>
                            <div class="btn-group dropright">
                                <u class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?=$prixtotalpourpetiteannonce[$annonce['id']]['totalPrixPayer']."€ total"; ?>
                                </u>
                                <div class="dropdown-menu detailtolat p-3">
                                    <h3><?= __("Prix de réservation"); ?></h3>

                                    <p class="border-bottom pb-3">
                                        <span class="resleft"><?= $prixtotalpourpetiteannonce[$annonce['id']]['nbrjour']; ?> <?= __("nuitées"); ?> </span>
                                        <?php if($prixtotalpourpetiteannonce[$annonce['id']]['totalSanspromo'] != 0) { ?>
                                        <span class="float-right">
                                            <span class="totalSpromo mr-2">
                                                <?= number_format($prixtotalpourpetiteannonce[$annonce['id']]['totalSanspromo'],2)." €"; ?>
                                            </span>
                                            <span class="totalWpromo">
                                                <?= number_format($prixtotalpourpetiteannonce[$annonce['id']]['prixTotal'],2)." €"; ?>
                                            </span>
                                        </span>
                                        <?php } else { ?>
                                        <span class="float-right">
                                            <?= number_format($prixtotalpourpetiteannonce[$annonce['id']]['prixTotal'],2)." €"; ?>
                                        </span>
                                        <?php } ?>
                                    </p>

                                    <p class="border-bottom pb-3">
                                        <span class="resleft"><?= __("Taxe de séjour"); ?> </span>
                                        <span class="float-right">
                                            <?= number_format($prixtotalpourpetiteannonce[$annonce['id']]['taxeDeSejour'],2); ?> €
                                        </span>
                                    </p>

                                    <p class="border-bottom pb-3">
                                        <span class="resleft tooltipservice"><?= __("Frais de service"); ?> </span>
                                        <span class="float-right">
                                            <?= number_format($prixtotalpourpetiteannonce[$annonce['id']]['fraisService'],2); ?> €
                                        </span>
                                    </p>

                                    <p>
                                        <span class="resleft tooltipservice"><?= __("Total"); ?></span>
                                        <span class="float-right">
                                            <?= number_format($prixtotalpourpetiteannonce[$annonce['id']]['totalPrixPayer'],2); ?> €
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </span>
            <?php } ?>

            <?php
                if ($noteglobalmoy[$annonce['id']] > 0) {
                    $etoile1 = '';
                    $etoile2 = '';
                    $etoile3 = '';
                    $etoile4 = '';
                    $etoile5 = '';
                    $fastar1 = 'fa-star-o';
                    $fastar2 = 'fa-star-o';
                    $fastar3 = 'fa-star-o';
                    $fastar4 = 'fa-star-o';
                    $fastar5 = 'fa-star-o';

                    if (round($noteglobalmoy[$annonce['id']]) >= 1) {
                        $etoile1 = "gold";
                        $fastar1 = "fa-star";
                    }

                    if(round($noteglobalmoy[$annonce['id']]) >= 2){
                        $etoile2 = "gold";
                        $fastar2 = "fa-star";
                    }

                    if(round($noteglobalmoy[$annonce['id']]) >= 3){
                        $etoile3 = "gold";
                        $fastar3 = "fa-star";
                    }

                    if(round($noteglobalmoy[$annonce['id']]) >= 4){
                        $etoile4 = "gold";
                        $fastar4 = "fa-star";
                    }

                    if(round($noteglobalmoy[$annonce['id']]) >= 5){
                        $etoile5 = "gold";
                        $fastar5 = "fa-star";
                    }

                    echo "<span class='stars ml-auto my-auto'>
                        <i class='fa ".$fastar1." newnote ".$etoile1."'></i>
                        <i class='fa ".$fastar2." newnote ".$etoile2."'></i>
                        <i class='fa ".$fastar3." newnote ".$etoile3."'></i>
                        <i class='fa ".$fastar4." newnote ".$etoile4."'></i>
                        <i class='fa ".$fastar5." newnote ".$etoile5."'></i>
                    </span>";
                }
            ?>
        </div>
    </div>
</div>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$(document).ready(function () {
    $(".tooltipsvc").tooltip({
        html: true
    });
    // .tooltip('show');
});
<?php $this->Html->scriptEnd(); ?>