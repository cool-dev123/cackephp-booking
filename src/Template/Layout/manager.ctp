<!DOCTYPE html>
<html lang="fr" >
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
                <meta name="description" content="Location de vacances à la montagne de particulier à particulier, Promotion de dernière minutes location saisonnière">
                <meta name="keywords" content="annuaire, location, montagne, ski, parapente, randonnées, appartement">
                <meta http-equiv="content-language" content="fr">
                <meta http-equiv="content-style-type" content="text/css">
                <meta http-equiv="content-script-type" content="text/javascript">
		<title>Alpissime Manager</title>
		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo $this->Url->build('/',true)?>manager-arr\images\icon\shortcut\user-admin.png">
		<link rel="icon" href="<?php echo $this->Url->build('/',true)?>manager-arr\images\icon\shortcut\user-admin.png" type="image/x-icon">
		
                <?php echo $this->fetch('cssTop'); ?>

		<!-- Summernote css -->
		<link rel="stylesheet" href="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/summernote/dist/summernote.css" />
		<link rel="stylesheet" href="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/select2/dist/css/select2.min.css" />
		<!-- multiselect CSS -->
		<link rel="stylesheet" href="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/multiselect/css/multi-select.css" />

		<!-- switchery CSS -->
		<link href="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" type="text/css"/>
	
                <!-- loadingModal CSS -->
		<link href="<?php echo $this->Url->build('/',true)?>manager-arr/Fullscreen-Loading-Modal/css/jquery.loadingModal.css" rel="stylesheet" type="text/css">
                
		<!-- Custom CSS -->
		<link href="<?php echo $this->Url->build('/',true)?>manager-arr/classic_CHOISI/dist/css/style.css" rel="stylesheet" type="text/css">
                <link href="<?php echo $this->Url->build('/',true)?>manager-arr/css/LayoutManager.css" rel="stylesheet" type="text/css">
                
	</head>
	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		
		<div class="wrapper theme-1-active navbar-top-light">
		<!-- Top Menu Items -->
		<nav class="navbar navbar-inverse navbar-fixed-top icantSelectIt">
			<div class="mobile-only-brand pull-left">
				<div class="nav-header pull-left">
					<div class="logo-wrap">
						<a href="#">
                        <svg aria-hidden="true" width="210" height="30" viewBox="0 0 1108.26 163.66">
                            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/logo-couleur-alpissime-baseline.svg#Calque_2"></use>
                        </svg>
                                                    <!-- <img id="mainLOGO" class="brand-img" src="<?php echo $this->Url->build('/',true)?>images/logo.png"/> -->
						</a>
					</div>
				</div>
				<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="ti-align-left"></i></a>
                                <a id="toggle_mobile_search" href="<?= $InfoGes['G']['role']=="admin"?$this->Url->build('/',true)."manager/arrivees/adminnonarrive/":$this->Url->build('/',true)."manager/arrivees/nonarrive/" ?>" class="mobile-only-view collapsed arrives_for_mobile" aria-expanded="false"><i class="fa fa-group"></i> <span class="top-nav-icon-badge">0</span></a>
                                <a id="toggle_mobile_search" href="<?= $InfoGes['G']['role']=="admin"?$this->Url->build('/',true)."manager/arrivees/adminnonarrive/":$this->Url->build('/',true)."manager/arrivees/nonarrive/" ?>" class="init_Button arrives_for_tablet"><button><span class="btn-text">Non Arrivés</span><sup class="supNBARRIVES"><span class="top-nav-icon-badge SupnbNonArrive">0</span></sup></button></a>
                                <a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="ti-more"></i></a>
			</div>
			<div id="mobile_only_nav" class="mobile-only-nav pull-right">
				<ul class="nav navbar-right top-nav pull-right">
                                    <li class="nb_arrives_for_large_screen dropdown alert-drp">
                                        <a class="init_Button" id="LayoutArrives" href="<?= $InfoGes['G']['role']=="admin"?$this->Url->build('/',true)."manager/arrivees/adminnonarrive/":$this->Url->build('/',true)."manager/arrivees/nonarrive/" ?>"><button>Non Arrivés</button><span class="top-nav-icon-badge SupnbNonArrive">0</span></a>
                                    </li> 
                                    <li class="dropdown alert-drp">
                                        <a href="<?php echo $this->Url->build('/',true);?>manager/gestionnaires/message"><i class="ti-email top-nav-icon"></i><span id='nbMessages' class="top-nav-icon-badge">0</span></a>
                                    </li>
                                    <?php if($InfoGes['G']['name']!=""): ?>
                                    <li>
                                        <a href="#" class="gestName"><span><?= $InfoGes['G']['name'] ?></span></a>
                                    </li>
                                    <?php endif; ?> 
					<li class="dropdown auth-drp">
                                            <a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><img src="<?php echo $this->Url->build('/',true)?>manager-arr/images/business-person-silhouette-wearing-tie.png" alt="user_auth" class="user-auth-img img-circle"/><span class="user-online-status"></span></a>
						<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                                                        <?php if($InfoGes['G']['name']!=""): ?>
                                                        <li>
                                                            <a class="gestName2" href="#"><?= $InfoGes['G']['name'] ?></a>
							</li>
                                                        <?php endif; ?>
                                                        <li class="divider"></li>
                                                        <li>
								<a href="<?php echo $this->Url->build('/',true);?>manager/arrivees/profile/"><i class="zmdi zmdi-account"></i><span>Profile</span></a>
							</li>
							<li>
								<a href="<?php echo $this->Url->build('/',true);?>manager/arrivees/logout/"><i class="zmdi zmdi-power"></i><span>Déconnexion</span></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>	
		</nav>
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
		<div class="fixed-sidebar-left icantSelectIt">
                    <ul id="main_menue_content" class="nav navbar-nav side-nav nicescroll-bar">
                                        <?php echo $this->element("menu_manager_admin"); ?>
                    </ul>
		</div>
			<!-- Main Content -->
			<div id="main-container" class="page-wrapper">
				<div class="container-fluid">
                                        <?php echo $this->fetch('content');?>
                                    <button class="btn btn-primary btn-icon-anim btn-square scrollToTop"><i class="ti-angle-up"></i></button>
				</div>
				<!-- Footer -->
				<footer class="footer container-fluid pl-30 pr-30 icantSelectIt">
					<div class="row">
						<div class="col-sm-12">
                            <p>Copyright <?php echo date('Y'); ?> <a href="https://www.alpissime.com">Alpissime.com</a></p>
						</div>
					</div>
				</footer>
				<!-- /Footer -->
			</div>
			<!-- /Main Content -->
		
		</div>
		<!-- /#wrapper -->
		
		<!-- JavaScript -->
		
		<!-- jQuery -->
		<script src="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/jquery/dist/jquery.min.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
		<!-- Slimscroll JavaScript -->
                <script src="<?php echo $this->Url->build('/',true)?>manager-arr/classic_CHOISI/dist/js/jquery.slimscroll.js" defer ></script>
                
                <!-- Fancy Dropdown JS -->
                <script src="<?php echo $this->Url->build('/',true)?>manager-arr/classic_CHOISI/dist/js/dropdown-bootstrap-extended.js" defer ></script>
		
		<!-- Switchery JavaScript -->
		<script src="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/switchery/dist/switchery.min.js"></script>
                
                <!-- loadingModal JavaScript -->
		<script src="<?php echo $this->Url->build('/',true)?>manager-arr/Fullscreen-Loading-Modal/js/jquery.loadingModal.js"></script>
                
		<!-- Init JavaScript -->
		<script src="<?php echo $this->Url->build('/',true)?>manager-arr/classic_CHOISI/dist/js/init.js"></script>
                <script>
                    var language_data_table = {
                                "processing":     "Traitement en cours...",
                                "search":         "Rechercher&nbsp;:",
                                "lengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                                "info":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                                "infoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                                "infoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                                "infoPostFix":    "",
                                "loadingRecords": "Chargement en cours...",
                                "zeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                                "emptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                                "paginate": {
                                    "first":      "Premier",
                                    "previous":   "Pr&eacute;c&eacute;dent",
                                    "next":       "Suivant",
                                    "last":       "Dernier"
                                },
                                "aria": {
                                    "sortAscending":  ": activer pour trier la colonne par ordre croissant",
                                    "sortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                                },
                                "select": {
                                        "rows": {
                                            _: "%d lignes séléctionnées",
                                            0: "Aucune ligne séléctionnée",
                                            1: "1 ligne séléctionnée"
                                        } 
                                }
                            };
                    get_nbmessage();
                    function get_nbmessage(){
                        
				$.ajax({
					type: "GET",
					url: "<?php echo $this->Url->build('/',true);?>manager/gestionnaires/getnbmessage/",
					success:function(xml){
                                            $('#nbMessages').html(xml);
                                            $('#nbMessages').attr('class',  'top-nav-icon-badge info-frame-red font-15 SupnbMessages');
					},
                                        complete:function(){
                                            setTimeout("get_nbmessage();",5000);
                                        }
				});
                    }
                    function get_arrivees(){
				$.ajax({
					type: "GET",
					url: "<?php echo $this->Url->build('/',true);?>manager/arrivees/nonarriveForLayout/",
					success:function(xml){
					 $('#LayoutArrives').children().eq(1).html(xml);
                                         $('.arrives_for_mobile').children().eq(1).html(xml);
                                         $('.arrives_for_tablet').children().eq(0).children().eq(1).html(xml);
                                         $('.init_Button').removeClass('init_Button');
                                         if(xml=='0'){
                                             $('#LayoutArrives').children().eq(1).attr('class',  'top-nav-icon-badge info-frame-red font-15 SupnbNonArrive');
                                             $('#LayoutArrives').children().eq(0).attr('class',  'btn btn-success font-15');
                                             $('.arrives_for_mobile').attr('class','arrives_for_mobile mobile-only-view collapsed greenColor');
                                             $('.arrives_for_tablet').attr('class','arrives_for_tablet mobile-only-view collapsed redColor');
                                             $('.arrives_for_tablet').children().eq(0).attr('class',  'btn btn-sm btn-success');
                                         }
                                         else {
                                             $('#LayoutArrives').children().eq(1).attr('class',  'top-nav-icon-badge info-frame-red font-15 SupnbNonArrive');
                                             $('#LayoutArrives').children().eq(0).attr('class',  'btn btn-success font-15');
                                             $('.arrives_for_mobile').attr('class','arrives_for_mobile mobile-only-view collapsed redColor');
                                             $('.arrives_for_tablet').attr('class','arrives_for_tablet mobile-only-view collapsed greenColor');
                                             $('.arrives_for_tablet').children().eq(0).attr('class',  'btn btn-sm btn-success');
                                         }
					}
				});
                    }
                    get_arrivees();
    //                $('.main_menue_button').click(function() {
    //                    $('body').loadingModal({
    //                            position: 'auto',
    //                            text: '',
    //                            color: '#fff',
    //                            opacity: '0.7',
    //                            backgroundColor: 'rgb(0,0,0)',
    //                            animation: 'chasingDots'
    //                        });
    //                });
                    $(document).ready(function(){
                        //Check to see if the window is top if not then display button
                        $(window).scroll(function(){
                            if ($(this).scrollTop() > 100) {
                                $('.scrollToTop').fadeIn();
                            } else {
                                $('.scrollToTop').fadeOut();
                            }
                        });

                        //Click event to scroll to top
                        $('.scrollToTop').click(function(){
                            $('html, body').animate({scrollTop : 0},800);
                            return false;
                        });

                    });
                </script>
                <?php echo $this->fetch('scriptBottom'); ?>
	</body>
</html>