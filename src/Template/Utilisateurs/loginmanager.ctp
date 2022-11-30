<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>Connectez-vous</title>
		<meta name="description" content="Winkle is a Dashboard & Admin Site Responsive Template by hencework." />
		<meta name="keywords" content="admin, admin dashboard, admin template, cms, crm, Winkle Admin, Winkleadmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
		<meta name="author" content="hencework"/>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo $this->Url->build('/',true)?>images/ico/favicon.ico">
		<link rel="icon" href="<?php echo $this->Url->build('/',true)?>images/ico/favicon.ico" type="image/x-icon">
		
		<!-- vector map CSS -->
                <link href="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>
                
                
                <link href="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
		
		<link href="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" type="text/css"/>
		
		<!-- Custom CSS -->
                <link href="<?php echo $this->Url->build('/',true)?>manager-arr/classic_CHOISI/dist/css/style.css" rel="stylesheet" type="text/css"/>
                <!-- loadingModal CSS -->
		<link href="<?php echo $this->Url->build('/',true)?>manager-arr/Fullscreen-Loading-Modal/css/jquery.loadingModal.css" rel="stylesheet" type="text/css">
                <style>
                    @keyframes slideInFromLeft {
                        0% {
                          transform: translateX(-100%);
                          opacity: 0.5;
                        }
                        100% {
                          transform: translateX(0);
                          opacity: 1;
                        }
                    }
                    @keyframes slideLogo {
                        0% {
                          transform: translateX(100%);
                          transform: translateY(100%);
                          opacity: 0;
                        }
                        100% {
                          transform: translateX(0);
                          transform: translateY(0%);
                          opacity: 1;
                        }
                    }

                    #main_log {  
                        /* This section calls the slideInFromLeft animation we defined above */
                        animation: 1.5s ease-out 0s 1 slideInFromLeft;
                    }
                    #logo_img {
                        animation: 3s ease-out 0s 1 slideLogo;
                    }
                    #btn_login{
                        background-color: #f9a455 !important ;
                    }
                    .sp-logo-wrap{text-align: center!important;}
                </style>
	</head>
        <body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		
		<div class="wrapper  pa-0">
			<header id="logo_img" class="sp-header">
                            <div class="sp-logo-wrap">
                                        <!-- <a href="#"> -->
                                        <svg aria-hidden="true" width="335" height="55" viewBox="0 0 1108.26 163.66">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/logo-couleur-alpissime-baseline.svg#Calque_2"></use>
        </svg>
						<!-- <img class="brand-img mr-10" src="<?php echo $this->Url->build('/',true)?>images/logo.png"/> -->
					<!-- </a> -->
				</div>
				<div class="clearfix"></div>
			</header>
			
			<!-- Main Content -->
                        <div class="page-wrapper pa-0 ma-0 auth-page" style="background-color: #f7f7f7">
				<div class="container-fluid">
					<!-- Row -->
                                        <div id="main_log" class="table-struct full-width full-height">
						<div class="table-cell vertical-align-middle auth-form-wrap">
							<div class="auth-form  ml-auto mr-auto no-float card-view pt-30 pb-30">
								<div class="row">
									<div class="col-sm-12 col-xs-12">
										<div class="mb-30">
                                                                                    <h3 style="color: #224f77 !important;" class="text-center txt-dark mb-10">Connectez-vous</h3>
                                                                                    <h6 style="color: #5d6f8e !important;" class="text-center nonecase-font txt-grey">Entrez vos coordonnées ci-dessous</h6>
										</div>	
										<div class="form-wrap">
											<form name="formLogin"  id="formLogin" method="post">
												<div class="form-group">
													<label class="control-label mb-10" for="exampleInputEmail_2">Nom utilisateur</label>
                                                                                                        <div class="input-group tip">
                                                                                                            <div class="input-group-addon"><i class="icon-user"></i></div>
                                                                                                            <input name="username" type="text" class="form-control" required="" id="username_id" placeholder="Enter nom utilisateur">
													</div>
												</div>
												<div class="form-group">
													<label class="pull-left control-label mb-10" for="exampleInputpwd_2">Mot de passe</label>
													<div class="clearfix"></div>
                                                                                                        <div class="input-group tip">
                                                                                                            <div class="input-group-addon"><i class="icon-lock"></i></div>
                                                                                                            <input name="password" type="password" class="form-control" required="" id="password" placeholder="Enter mot de passe">
													</div>
												</div>
												<div class="form-group text-center">
                                                                                                    <button type="button" id="btn_login" class="btn btn-anim btn-rounded"><i class="fa fa-sign-in"></i><span class="btn-text">Connexion</span></button>
												</div>
											</form>
										</div>
									</div>	
								</div>
							</div>
						</div>
					</div>
					<!-- /Row -->	
				</div>
			</div>
			<!-- /Main Content -->
		</div>
		<!-- /#wrapper -->
		
		<!-- JavaScript -->
		
		<!-- jQuery -->
                <script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/jquery/dist/jquery.min.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
                <script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
                <script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll JavaScript -->
		<script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>manager-arr/classic_CHOISI/dist/js/jquery.slimscroll.js"></script>
                
                <script src="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
                
                <script src="<?php echo $this->Url->build('/',true)?>manager-arr/vendors/bower_components/switchery/dist/switchery.min.js"></script>
                
		<!-- Init JavaScript -->
                <script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>manager-arr/classic_CHOISI/dist/js/init.js"></script>
                
                <!-- loadingModal JavaScript -->
		<script src="<?php echo $this->Url->build('/',true)?>manager-arr/Fullscreen-Loading-Modal/js/jquery.loadingModal.js"></script>
                
                <script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>manager-arr/js/login.js"></script>
                
                <script>
                    function erreur(){
                        $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'ERREUR',
                            text: 'Vérifier votre nom administrateur ou mot de passe',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 3500
                        });
                      return false;
                    };
                    function showloading(){
                        $('body').loadingModal({
                            position: 'auto',
                            text: 'Connexion en cours...',
                            color: '#f9a455',
                            opacity: '0.7',
                            backgroundColor: 'rgb(0,0,0)',
                            animation: 'chasingDots'
                        });
                    }
                    function hide_loading(){
                        $('body').loadingModal('destroy');
                    }
                </script>
	</body>
</html>
