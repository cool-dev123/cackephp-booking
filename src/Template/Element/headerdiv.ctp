<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<style>
    .flagdiv:after {
    content: '';
    display: block;
    width: 1px;
    height: 20px;
    background-color: #5c5c5c;
    position: absolute;
    right: 0;
    top: 50%;
    margin-top: -10px;
}
</style>
<header>
    <div class="container-fluid">  
		<nav class="navbar navbar-expand-xl navbar-light">
		    <a class="navbar-brand" href="<?php echo $this->Url->build('/').$urlLang; ?>">
                <?php if($this->Session->read('Config.language') == 'fr_FR') $medialogoimage = $medialogo->lien_ete; else $medialogoimage = $medialogo->_translations[$this->Session->read('Config.language')]->lien_ete;  ?>
                <picture>
                    <source srcset="<?php echo $this->Url->build('/',true).$medialogoimage;?>.webp" type="image/webp">
                    <source srcset="<?php echo $this->Url->build('/',true).$medialogoimage;?>.png" type="image/png">
                    <img class="img-fluid" src="<?php echo $this->Url->build('/').$medialogoimage;?>.png" >
                </picture> 

                <!-- <svg aria-hidden="true" width="276" height="40" viewBox="0 0 1108.26 163.66">
                    <use xlink:href="<?php // echo $this->Url->build('/')?>images/svg/logo-couleur-alpissime-baseline.svg#Calque_2"></use>
                </svg>  -->
	        </a>
            <button class="navbar-toggler" type="button" uk-toggle="target: #navbarSupportedContent2">
                <i class="fa fa-bars"></i>
            </button>
		    <div class="d-none d-xl-block" id="navbarSupportedContent">
		        <ul class="navbar-nav ml-xl-auto">
                    <!-- <li class="nav-item dropdown dropdown09">
                        <a class="nav-link" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-globe fa-lg mr-2" aria-hidden="true"></i><?php // echo ucfirst($language_header_name); ?></a>
                        <div class="dropdown-menu dropdown09-menu" aria-labelledby="dropdown09">
                            <?php // foreach ($languages as $language) { ?>
                                <a class="dropdown-item <?php // if($this->Session->read('Config.language') == $language->code) echo "active"; ?>" href="<?php // echo $this->Url->build('/')?>App/changelanguage/<?php // echo $language->url_code; ?>">
                                <img
                                    src="https://flagcdn.com/20x15/<?php // echo $language->flag_code; ?>.png"
                                    srcset="https://flagcdn.com/40x30/<?php // echo $language->flag_code; ?>.png 2x,
                                        https://flagcdn.com/60x45/<?php // echo $language->flag_code; ?>.png 3x"
                                    width="20"
                                    height="15"
                                    alt="South Africa">
                                <?php // echo __($language->name) ?></a>
                            <?php // } ?>
                        </div>
                    </li> -->
                    <li class="nav-item d-flex">
                        <?php foreach ($languages as $language) { ?>
                            <a class="nav-link" href="<?php echo $this->Url->build('/')?>App/changelanguage/<?php echo $language->url_code; ?>" >
                            <img
                                src="https://flagcdn.com/<?php if($this->Session->read('Config.language') == $language->code) echo "24x18"; else echo "16x12"; ?>/<?php echo $language->flag_code; ?>.png"
                                srcset="https://flagcdn.com/<?php if($this->Session->read('Config.language') == $language->code) echo "48x36"; else echo "32x24"; ?>/<?php echo $language->flag_code; ?>.png 2x,
                                    https://flagcdn.com/<?php if($this->Session->read('Config.language') == $language->code) echo "72x54"; else echo "48x36"; ?>/<?php echo $language->flag_code; ?>.png 3x"
                                width="<?php if($this->Session->read('Config.language') == $language->code) echo "24"; else echo "16"; ?>"
                                height="<?php if($this->Session->read('Config.language') == $language->code) echo "18"; else echo "12"; ?>"
                                >
                            </a>
                        <?php } ?>
                    </li>
                    <?php if ($this->Session->read('Auth.User.nature')==''){ ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $this->Url->build('/'); ?>fr-services-et-contrats-proprietaires-de-residences-secondaires/"><?= __("Conciergerie") ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs'];?>/add"><?= __("Inscription") ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['ouvrircompte']?>"><?= __("Connexion") ?></a>
                        </li>
                        <li>
                            <button class="btn btn-sm btn-primary btn-alpissime ml-3" type="button" onclick="location.href='<?php echo $this->Url->build('/').$urlLang?>annonces/depotannonce'"><?= __("Créer une annonce") ?></button>
                        </li>
                    <?php }else{
			            if($this->Session->read('Auth.User.nature')=='CLT'){ ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ml-lg-3 mr-lg-3" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><i class="fa fa-envelope-o"></i>
                                    <span class="nbr-msg"></span>
                                </a>
                            </li>
                            <li class="nav-item dropdown dropdown-user">
                                <a class="nav-link dropdown-toggle nav-user mr-3" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <img class="img-responsive" src="#" data-src="<?php echo $this->Url->build('/')?>images/user-icon.png" >
                                </a>
                                <div class="dropdown-menu user-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index']?>"><?= __("Profil") ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a>
                                </div>
                            </li>
				        <?php }else{ ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $this->Url->build('/'); ?>fr-services-et-contrats-proprietaires-de-residences-secondaires/" target="blank"><?= __("Conciergerie") ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ml-lg-3 mr-lg-3" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><i class="fa fa-envelope-o"></i>
                                    <span class="nbr-msg"></span>
                                </a>
                            </li>
                            <li class="nav-item dropdown dropdown-user">
                                <a class="nav-link dropdown-toggle nav-user mr-3" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <img class="img-responsive" src="#" data-src="<?php echo $this->Url->build('/')?>images/user-icon.png" >
                                </a>
                                <div class="dropdown-menu user-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']?>"><?= __("Espace Propriétaire") ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang?>reservations/validation"><?= __("Réservations") ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Mes annonces") ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a>
                                </div>
                            </li>
                            <li>
                                <button class="btn btn-sm btn-primary btn-alpissime" type="button" onclick="location.href='<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['annonces']?>/add'"><?= __("Créer une annonce") ?></button>
                            </li>
				        <?php }
                    }?>
				</ul>
            </div>
            <!-- Menu Mobile-->
            <div class="d-xl-none" id="navbarSupportedContent2" uk-offcanvas="mode: push; overlay: true">
                <div class="uk-offcanvas-bar">
                    <button class="uk-offcanvas-close" type="button" uk-close></button>
                    <div class="d-flex justify-content-between flex-column h-100 pb-3">
                        <?php if ($this->Session->read('Auth.User.nature')==''){ ?>
		                    <ul class="navbar-nav mb-0">
                                <li class="nav-item d-flex">
                                    <?php foreach ($languages as $language) { ?>
                                        <a class="nav-link mr-2" href="<?php echo $this->Url->build('/')?>App/changelanguage/<?php echo $language->url_code; ?>" >
                                        <img
                                            src="https://flagcdn.com/<?php if($this->Session->read('Config.language') == $language->code) echo "24x18"; else echo "16x12"; ?>/<?php echo $language->flag_code; ?>.png"
                                            srcset="https://flagcdn.com/<?php if($this->Session->read('Config.language') == $language->code) echo "48x36"; else echo "32x24"; ?>/<?php echo $language->flag_code; ?>.png 2x,
                                                https://flagcdn.com/<?php if($this->Session->read('Config.language') == $language->code) echo "72x54"; else echo "48x36"; ?>/<?php echo $language->flag_code; ?>.png 3x"
                                            width="<?php if($this->Session->read('Config.language') == $language->code) echo "24"; else echo "16"; ?>"
                                            height="<?php if($this->Session->read('Config.language') == $language->code) echo "18"; else echo "12"; ?>"
                                            alt="South Africa">
                                        </a>
                                    <?php } ?>
                                </li>
                                <li class="brand-title"><?= __("Menu") ?></li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $this->Url->build('/').$urlLang; ?>" target="blank"><?= __("Hébergements") ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $this->Url->build('/'); ?>fr-services-et-contrats-proprietaires-de-residences-secondaires/"><?= __("Conciergerie") ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php  echo $this->Url->build('/').$urlLang.$urlvaluemulti['annonces']; ?>/contact" target="blank"><?= __("Contact") ?></a>
                                </li>
                                <hr>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs'];?>/add"><?= __("Inscription") ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['ouvrircompte'];?>"><?= __("Connexion") ?></a>
                                </li>
                                <li>
                                    <button class="btn btn-sm btn-primary btn-alpissime mt-3" type="button" onclick="location.href='<?php echo $this->Url->build('/').$urlLang;?>annonces/depotannonce'"><?= __("Créer une annonce") ?></button>
                                </li>
                            </ul>
                            <div class="border m-3 block-menumobile">
                                <a href="<?php echo $this->Url->build('/',true).$urlLang;?>sejour-ski-tout-compris" target="_blanck">
                                    <?php if(in_array(date("m"),array('05','06','07','08'))){?>
                                        <?php if($this->Session->read('Config.language') == 'fr_FR') $mediacarremobileimage = $mediacarremobile->lien_ete; else $mediacarremobileimage = $mediacarremobile->_translations[$this->Session->read('Config.language')]->lien_ete;  ?>
                                        <picture>
                                            <source srcset="<?php echo $this->Url->build('/',true).$mediacarremobileimage;?>.webp" type="image/webp">
                                            <source srcset="<?php echo $this->Url->build('/',true).$mediacarremobileimage;?>.jpg" type="image/jpg">
                                            <img class="img-fluid" src="#" data-src="<?php echo $this->Url->build('/').$mediacarremobileimage;?>.jpg" >
                                        </picture>
                                    <?php }else{ ?>
                                        <?php if($this->Session->read('Config.language') == 'fr_FR') $mediacarremobileimage = $mediacarremobile->lien_hiver; else $mediacarremobileimage = $mediacarremobile->_translations[$this->Session->read('Config.language')]->lien_hiver;  ?>
                                        <picture>
                                            <source srcset="<?php echo $this->Url->build('/',true).$mediacarremobileimage;?>.webp" type="image/webp">
                                            <source srcset="<?php echo $this->Url->build('/',true).$mediacarremobileimage;?>.jpg" type="image/jpg">
                                            <img class="img-fluid" src="#" data-src="<?php echo $this->Url->build('/').$mediacarremobileimage;?>.jpg" >
                                        </picture>
                                    <?php } ?>
                                </a> 
                            </div>
			            <?php }else{
			                if($this->Session->read('Auth.User.nature')=='CLT'){ ?>
                                <ul class="navbar-nav mb-0">
                                    <li class="nav-item d-flex">
                                        <?php foreach ($languages as $language) { ?>
                                            <a class="nav-link mr-2" href="<?php echo $this->Url->build('/')?>App/changelanguage/<?php echo $language->url_code; ?>" >
                                            <img
                                                src="https://flagcdn.com/<?php if($this->Session->read('Config.language') == $language->code) echo "24x18"; else echo "16x12"; ?>/<?php echo $language->flag_code; ?>.png"
                                                srcset="https://flagcdn.com/<?php if($this->Session->read('Config.language') == $language->code) echo "48x36"; else echo "32x24"; ?>/<?php echo $language->flag_code; ?>.png 2x,
                                                    https://flagcdn.com/<?php if($this->Session->read('Config.language') == $language->code) echo "72x54"; else echo "48x36"; ?>/<?php echo $language->flag_code; ?>.png 3x"
                                                width="<?php if($this->Session->read('Config.language') == $language->code) echo "24"; else echo "16"; ?>"
                                                height="<?php if($this->Session->read('Config.language') == $language->code) echo "18"; else echo "12"; ?>"
                                                alt="South Africa">
                                            </a>
                                        <?php } ?>
                                    </li>
				                    <li class="brand-title"><?= __("Menu") ?></li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $this->Url->build('/').$urlLang; ?>" target="blank"><?= __("Hébergements") ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php  echo $this->Url->build('/').$urlLang.$urlvaluemulti['annonces']; ?>/contact" target="blank"><?= __("Contact") ?></a>
                                    </li>
                                    <hr>
                                    <li class="brand-title mt-n2"><?= __("Mon espace") ?></li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index'];?>"><?= __("Espace locataire") ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $this->Url->build('/').$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?>
                                            <span class="nbr-msg"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a>
                                    </li>
                                </ul>
                                <div class="border m-3 block-menumobile">
                                    <a href="<?php echo $this->Url->build('/',true).$urlLang;?>sejour-ski-tout-compris" target="_blanck">
                                        <?php if(in_array(date("m"),array('05','06','07','08'))){?>
                                            <?php if($this->Session->read('Config.language') == 'fr_FR') $mediacarremobileimage = $mediacarremobile->lien_ete; else $mediacarremobileimage = $mediacarremobile->_translations[$this->Session->read('Config.language')]->lien_ete;  ?>
                                            <picture>
                                                <source srcset="<?php echo $this->Url->build('/',true).$mediacarremobileimage;?>.webp" type="image/webp">
                                                <source srcset="<?php echo $this->Url->build('/',true).$mediacarremobileimage;?>.jpg" type="image/jpg">
                                                <img class="img-fluid" src="#" data-src="<?php echo $this->Url->build('/').$mediacarremobileimage;?>.jpg" >
                                            </picture>
                                        <?php }else{ ?>
                                            <?php if($this->Session->read('Config.language') == 'fr_FR') $mediacarremobileimage = $mediacarremobile->lien_hiver; else $mediacarremobileimage = $mediacarremobile->_translations[$this->Session->read('Config.language')]->lien_hiver;  ?>
                                            <picture>
                                                <source srcset="<?php echo $this->Url->build('/',true).$mediacarremobileimage;?>.webp" type="image/webp">
                                                <source srcset="<?php echo $this->Url->build('/',true).$mediacarremobileimage;?>.jpg" type="image/jpg">
                                                <img class="img-fluid" src="#" data-src="<?php echo $this->Url->build('/').$mediacarremobileimage;?>.jpg" >
                                            </picture>
                                        <?php } ?>
			                        </a>   
                                </div>
				            <?php }else{ ?>
                                <ul class="navbar-nav mb-0">
                                    <li class="nav-item d-flex">
                                        <?php foreach ($languages as $language) { ?>
                                            <a class="nav-link mr-2" href="<?php echo $this->Url->build('/')?>App/changelanguage/<?php echo $language->url_code; ?>" >
                                            <img
                                                src="https://flagcdn.com/<?php if($this->Session->read('Config.language') == $language->code) echo "24x18"; else echo "16x12"; ?>/<?php echo $language->flag_code; ?>.png"
                                                srcset="https://flagcdn.com/<?php if($this->Session->read('Config.language') == $language->code) echo "48x36"; else echo "32x24"; ?>/<?php echo $language->flag_code; ?>.png 2x,
                                                    https://flagcdn.com/<?php if($this->Session->read('Config.language') == $language->code) echo "72x54"; else echo "48x36"; ?>/<?php echo $language->flag_code; ?>.png 3x"
                                                width="<?php if($this->Session->read('Config.language') == $language->code) echo "24"; else echo "16"; ?>"
                                                height="<?php if($this->Session->read('Config.language') == $language->code) echo "18"; else echo "12"; ?>"
                                                alt="South Africa">
                                            </a>
                                        <?php } ?>
                                    </li>
                                    <li class="brand-title"><?= __("Menu") ?></li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $this->Url->build('/').$urlLang; ?>" target="blank"><?= __("Hébergements") ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $this->Url->build('/'); ?>fr-services-et-contrats-proprietaires-de-residences-secondaires/" target="blank"><?= __("Conciergerie") ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php  echo $this->Url->build('/').$urlLang.$urlvaluemulti['annonces']; ?>/contact" target="blank"><?= __("Contact") ?></a>
                                    </li>
                                    <hr>
                                    <li class="brand-title mt-n2"><?= __("Mon espace") ?></li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs'];?>"><?= __("Espace Propriétaire") ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Mes annonces") ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $this->Url->build('/').$urlLang;?>reservations/validation"><?= __("Mes réservations") ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?>
                                            <span class="nbr-msg"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a>
                                    </li>
                                    <li>
                                        <button class="btn btn-sm btn-primary btn-alpissime mt-3" type="button" onclick="location.href='<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['annonces'];?>/add'"><?= __("Créer une annonce") ?></button>
                                    </li>
                                </ul>
                                <div class="border p-3 m-3 block-menumobile">
                                    <p><?= __("Alpissime évolue depuis de 2009, toujours porté par votre confiance.") ?></p>
                                    <p><?= __("Une question, une suggestions ou une amélioration à apporter ?") ?></p>
                                    <a class="text-primary" href="<?php  echo $this->Url->build('/').$urlLang.$urlvaluemulti['annonces']; ?>/contact"><?= __("Contactez-nous") ?></a>
                                </div>
				            <?php }
                        } ?>
                    </div>
				</div>
            </div>		
        </nav>
    </div>
</header>