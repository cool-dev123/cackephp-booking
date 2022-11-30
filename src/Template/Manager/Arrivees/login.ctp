<!DOCTYPE html>
<!DOCTYPE html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<?php  $desc="Location les Arcs - Plus de 300 appartements de particuliers à particuliers, avec accueil sur place, pour des vacances réussies à la montagne dans les Alpes, à Bourg Saint Maurice, Arc 1800, Arc 1600, Arc 1950 et Arc 2000 ";?>
    <title>Alpissime : Location vacances aux Arcs - Bourg Saint Maurice</title>
	<meta name="description" content="<?php echo (!empty($description)?$description:$desc)?>">
    <meta name="keywords" content="location, appartement, hébergement, studio, séjour, vacances, montagne, les Arcs, Bourg Saint Maurice, Savoie, Alpes, Paradiski, hiver, ski, été, vtt">
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link type="text/css" rel="stylesheet" href="<?php echo $this->Url->build('/',true)?>manager-arr/components/bootstrap/bootstrap.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo $this->Url->build('/',true)?>manager-arr/css/zice.style.css"/>
        <style type="text/css">
        html {
            background-image: none;
        }
		body{
			background-position:0 0;
			}
        label.iPhoneCheckLabelOn span {
            padding-left:0px
        }
        #versionBar {
            background-color:#212121;
            position:fixed;
            width:100%;
            height:35px;
            bottom:0;
            left:0;
            text-align:center;
            line-height:35px;
            z-index:11;
            -webkit-box-shadow: black 0px 10px 10px -10px inset;
            -moz-box-shadow: black 0px 10px 10px -10px inset;
            box-shadow: black 0px 10px 10px -10px inset;
        }
        .copyright{
            text-align:center; font-size:10px; color:#CCC;
        }
        .copyright a{
            color:#A31F1A; text-decoration:none
        }    
        </style>
        </head>
        <body >
         
        <div id="successLogin"></div>
        <div class="text_success"><img src="<?php echo $this->Url->build('/',true)?>manager-arr/images/loadder/loader_green.gif"  alt="Alpissime.com" /><span>Please wait</span></div>
        
        <div id="login" >
          
          <div class="inner clearfix">
          <div class="logo" ><img src="<?php echo $this->Url->build('/',true)?>images/headers/bg-logo.png" width="200"  alt="Alpissime.com" /></div>
          <div class="formLogin">
         <form name="formLogin"  id="formLogin" method="post">
      
                <div class="tip">
                      <input name="username" type="text"  id="username_id"  title="Utilisateur"   />
                </div>
                <div class="tip">
                      <input name="password" type="password" id="password"   title="Mot de passe"  />
                </div>
      
                <div class="loginButton">
                  <div style="float:left; margin-left:-9px;">
                      
                  </div>
                  <div class=" pull-right" style="margin-right:-8px;">
                      <div class="btn-group">
                        <button type="button" class="btn" id="but_login">Connexion</button>
                        
                      </div>
                     
                  </div>
                  <div class="clear"></div>
                </div>
      
          </form>
          
          </div>
        </div>
          <div class="shadow"></div>
        </div>
        
        <!--Login div-->
        <div class="clear"></div>
        <div id="versionBar" >
          <div class="copyright" > Copyright &copy; 2014 - Tous droits réservés <span class="tip"><a  href="https://www.alpissime.com" title="Alpissime.com" >Alpissime.com</a> </span> </div>
          <!-- // copyright-->
        </div>
        
        <!-- Link JScript-->
        <script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>manager-arr/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>manager-arr/components/ui/jquery.ui.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>manager-arr/components/form/form.js"></script>
        <script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>manager-arr/js/login.js"></script>
		<script type="text/javascript" >
        $(document).ready(function () {	 
                $('#createacc').click(function(e){
                    $('#login').animate({   height: 350, 'margin-top': '-200px' }, 300);	
                    $('.formLogin').animate({   height: 240 }, 300);
                    $('#createaccPage').fadeIn();
                    $('#formLogin').hide();
                });
                $('#backLogin').click(function(e){
                    $('#login').animate({   height: 254, 'margin-top': '-148px' }, 300);	
                    $('.formLogin').animate({   height: 150 }, 300);
                    $('#formLogin').fadeIn();
                    $('#createaccPage').hide();
                });			
        });		
        </script>
        </body>
        </html>
