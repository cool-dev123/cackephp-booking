<?php /*if($_SERVER["REMOTE_ADDR"]!='82.122.236.116'&&$_SERVER["REMOTE_ADDR"]!='41.226.111.134'){?>
<style>
#recherche{
line-height:12px;
padding-top:30px;
padding-left:60px;
font-weight:bold;
background-image:url('<?php echo $this->base;?>/images/menu.png');
background-repeat:no-repeat;
}
#recherche a{
color:#fff;
}
</style>
<div id="recherche">
 <div><?=$html->link("Admin packs","/admin/packs/index")?></div>

     <div>   <?=$html->link("Admin annonces","/admin/annonces/index")?></div>

     <div>   <?=$html->link("Toutes annonces","/admin/annonces/liste")?></div>

     <div>   <?=$html->link("Paramétrage","/admin/registres/edit")?></div>

    <div>    <?=$html->link("Page d'accueil","/admin/registres/pages/1")?></div>

    <div>    <?=$html->link("Page Plan station","/admin/registres/pages/2")?></div>

   <div>     <?=$html->link("Page Arc 1600","/admin/registres/pages/3")?></div>

   <div>     <?=$html->link("Page Arc 1800","/admin/registres/pages/4")?></div>
      <div>          <?=$html->link("Page Arc 1950","/admin/registres/pages/5")?></div>

     <div>   <?=$html->link("Page Arc 2000","/admin/registres/pages/6")?></div>

     <div>   <?=$html->link("Page Bourg Saint Maurice","/admin/registres/pages/7")?></div>
<div>   <?=$html->link("Votre Publicité","/admin/annonces/pub")?></div>
<div>   <?=$html->link("Newsletters","/admin/mails")?></div>
<div>   <?=$html->link("Proprietaires E-mails","/annonces/plan")?></div>
<div>   <?=$html->link("Club Alpissime","admin/utilisateurs/gestion")?></div>

</div>
<?php }else{?>
<style>
#recherche{
line-height:20px;
padding-top:30px;
padding-left:10px;
font-size:10px;
font-weight:bold;
background-image:url('<?php echo $this->base;?>/images/menu.png');
background-repeat:no-repeat;
}
#recherche a{
color:#fff;
}
#all_div a{
color:black;
}
#all_div{
	width:300px;
	float:left;
	font-size:11px;
	font-weight:normal;
}
.div_left{
	float: left;
    padding-left: 5px;
    width: 141px;
	height:21px;
	background-image:url('<?php echo $this->base;?>/images/prop_menu_2012.png');
	background-repeat:no-repeat;

}
.div_right{
	float:left;
	width:141px;
	height:21px;
	background-image:url('<?php echo $this->base;?>/images/prop_menu_2012.png');
	background-repeat:no-repeat;
	padding-left: 5px;
}
</style>
<div id="recherche">
 <div id="all_div"><div class="div_left"><?=$html->link("Admin packs","/admin/packs/index")?></div><div class="div_right"><?=$html->link("Admin annonces","/admin/annonces/index")?></div></div>
 <div id="all_div"><div class="div_left"><?=$html->link("Toutes annonces","/admin/annonces/liste")?></div><div class="div_right"><?=$html->link("Paramétrage","/admin/registres/edit")?></div></div>
 <div id="all_div"><div class="div_left"><?=$html->link("Page d'accueil","/admin/registres/pages/1")?></div><div class="div_right"><?=$html->link("Page Plan station","/admin/registres/pages/2")?></div></div>
 <div id="all_div"><div class="div_left"><?=$html->link("Page Arc 1600","/admin/registres/pages/3")?></div><div class="div_right"><?=$html->link("Page Arc 1800","/admin/registres/pages/4")?></div></div>
 <div id="all_div"><div class="div_left"><?=$html->link("Page Arc 1950","/admin/registres/pages/5")?></div><div class="div_right"><?=$html->link("Page Arc 2000","/admin/registres/pages/6")?></div></div>
 <div id="all_div"><div class="div_left"><?=$html->link("Page Bourg Saint","/admin/registres/pages/7")?></div><div class="div_right"><?=$html->link("Votre Publicité","/admin/annonces/pub")?></div></div>
 <div id="all_div"><div class="div_left"><?=$html->link("Newsletters","/admin/mails")?></div><div class="div_right"><?=$html->link("Proprietaires E-mails","/annonces/plan")?></div></div>
 <div id="all_div"><div class="div_left"><?=$html->link("Club Alpissime","admin/utilisateurs/gestion")?></div></div>
 <div class="fin"></div>
</div>-->
<?php */?>
<style>
.admin_link a{font-family:"Segoe UI";font-size:12px;width:127px;height:22px;border:1px solid #a7b7c7;background:radial-gradient(circle at 50% 50% , #dee3e7 0px, #d5e0f4 100px) repeat scroll 0 0 transparent;color:#6e6fa5;padding:2px 66px 2px 10px;
}
</style>
<!-- prefix free to deal with vendor prefixes -->
<!--<script src="http://thecodeplayer.com/uploads/js/prefixfree-1.0.7.js" type="text/javascript" type="text/javascript"></script>-->

<!-- jQuery -->


<style>


/*Basic reset*/
* {margin: 0; padding: 0;}


#accordian {

	background: #c5d6f2;
	/*background-image: -moz-linear-gradient(  top,
    #DB7306, #004050 );*/

	color: white;
	/*Some cool shadow and glow effect*/

}
/*heading styles*/
#accordian h3 {
	font-size: 12px;
	line-height: 34px;
	padding: 0 10px;
	cursor: pointer;
	/*fallback for browsers not supporting gradients*/
	background: #003040;

	/*background: linear-gradient(#003040, #002535);*/
	background:linear-gradient(#5873C4, #21387E) repeat scroll 0 0 rgba(0, 0, 0, 0);
}
/*heading hover effect*/
/*#accordian h3:hover {
	text-shadow: 0 0 1px rgba(255, 255, 255, 0.7);
}*/
/*iconfont styles*/
#accordian h3 span {
	font-size: 16px;
	margin-right: 10px;
}
/*list items*/
#accordian li {
	list-style-type: none;
}
/*links*/
#accordian ul ul li a {
	color: #6E6FA5;
	text-decoration: none;
	font-size: 11px;
	line-height: 27px;
	display: block;
	padding: 0 15px;
	/*transition for smooth hover animation*/
	transition: all 0.15s;
}
/*hover effect on links*/
#accordian ul ul li a:hover {
	background: radial-gradient(circle at 50% 50% , #DEE3E7 0px, #D5E0F4 100px) repeat scroll 0 0 rgba(0, 0, 0, 0);
	border-left: 5px solid lightgreen;
}
/*Lets hide the non active LIs by default*/
#accordian ul ul {
	display: none;
}
#accordian li.active ul {
	display: block;
}
</style>
<script>
$(document).ready(function(){
	$("#accordian h3").click(function(){
		//slide up all the link lists
		$("#accordian ul ul").slideUp();
		//slide down the link list below the h3 clicked - only if its closed
		if(!$(this).next().is(":visible"))
		{
			$(this).next().slideDown();
		}
	})
	$('.accordian').hide();
})
</script>

<div id='loc_menu' style="min-height:1024px;">
	<div class="loc_menu_top"></div>
	<div  id="accordian" class="">
		<ul>
		<li>
			<h3><span class="icon-dashboard"></span>Paramétrage </h3>
			<ul>
				<li><a  href='<?  echo $this->base ?>/admin/registres/edit'>Espace administrateur</a></li>
				<li><a  href='<?  echo $this->base ?>/admin/annonces/pub'>Votre Publicité</a></li>
				<li><a  href='<?  echo $this->base ?>/admin/packs/index'>Admin packs</a></li>
				<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/gestion'>Club Alpissime</a></li>
				<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/contactprop'>Contact Propriétaires</a></li>
				<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/noncontrat'>Propriétaires non contrat</a></li>
				<li><a  href='<?  echo $this->base ?>/admin/mails'>News Letters</a></li>
				<li><a  href='<?  echo $this->base ?>/annonces/plan'>Propriétaires E-mails</a></li>
				<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/animlist'>Animateur</a></li>
				<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/podcast'>Podcast</a></li>
			</ul>
		</li>
		<li>
		<h3><span class="icon-dashboard"></span>Gestionnaire des arrivées </h3>
			<ul>
				<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/addgestionnaire'>Nouveau gestionnaire</a></li>
				<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/gestionnaire'>Liste gestionnaire</a></li>
			</ul>
		</li>
		<!-- we will keep this LI open by default -->
		<li >
			<h3><span class="icon-tasks"></span>Annonces</h3>
			<ul>
				<li><a href='<?  echo $this->base ?>/admin/annonces/liste'>Toutes annonces</a></li>
				<li><a href='<?  echo $this->base ?>/admin/annonces/index'>Admin annonces</a></li>

			</ul>
		</li>
		<li>
			<h3><span class="icon-calendar"></span>Gestion de pages</h3>
			<ul>
				<li><a href='<?  echo $this->base ?>/admin/registres/pages/1'>Page d'accueil</a></li>
				<li><a href='<?  echo $this->base ?>/admin/registres/pages/2'>Page Plan Station</a></li>
				<li><a href='<?  echo $this->base ?>/admin/registres/pages/3'>Page Arc 1600</a></li>
				<li><a href='<?  echo $this->base ?>/admin/registres/pages/4'>Page Arc 1800</a></li>
				<li><a href='<?  echo $this->base ?>/admin/registres/pages/5'>Page Arc 1950</a></li>
				<li><a href='<?  echo $this->base ?>/admin/registres/pages/6'>Page Arc 2000</a></li>
				<li><a href='<?  echo $this->base ?>/admin/registres/pages/7'>Page BSM</a></li>
			</ul>
		</li>
		<li>
			<h3><span class="icon-heart"></span>Envoi sms</h3>
			<ul>
				<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/smslocataire/'>Sms Locataire</a></li>
				<!--<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/sendsms/'>Sms Filemaker</a></li>-->
			</ul>
		</li>
		<li>
			<h3><span class="icon-heart"></span>Envoi mail</h3>
			<ul>
				<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/maillocataire'>Mail Locataire</a></li>
				<!--<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/mailfilemaker'>Mail Filemaker</a></li>-->
			</ul>
		</li>
		<li>
			<h3><span class="icon-heart"></span>Gestion modèle</h3>
			<ul>
				<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/modelsms'>Modèle sms</a></li>
				<li><a  href='<?  echo $this->base ?>/admin/utilisateurs/modelmail'>Modèle mail</a></li>
			</ul>
		</li>
	</ul>
		<!--<div class='admin_link'>
			<div style='height:25px;padding-top:5px'>
			<a style='padding-right:55px' href='<?  echo $this->base ?>/admin/packs/index'>Admin packs</a>
			<a style='padding-right:26px' href='<?  echo $this->base ?>/admin/annonces/index'>Admin annonces</a>
			</div>
			<div style='height:25px;'>
			<a style='padding-right:34px' href='<?  echo $this->base ?>/admin/annonces/liste'>Toutes annonces</a>
			<a style='padding-right:49px' href='<?  echo $this->base ?>/admin/registres/edit'>Paramétrage</a>
			</div>
			<div style='height:25px;'>
			<a style='padding-right:47px' href='<?  echo $this->base ?>/admin/registres/pages/1'>Page d'accueil</a>
			<a style='padding-right:23px' href='<?  echo $this->base ?>/admin/registres/pages/2'>Page Plan Station</a>
			</div>
			<div style='height:25px;'>
			<a style='padding-right:48px' href='<?  echo $this->base ?>/admin/registres/pages/3'>Page Arc 1600</a>
			<a style='padding-right:40px' href='<?  echo $this->base ?>/admin/registres/pages/4'>Page Arc 1800</a>
			</div>
			<div style='height:25px;'>
			<a style='padding-right:48px' href='<?  echo $this->base ?>/admin/registres/pages/5'>Page Arc 1950</a>
			<a style='padding-right:40px' href='<?  echo $this->base ?>/admin/registres/pages/6'>Page Arc 2000</a>
			</div>
			<div style='height:25px;'>
			<a style='padding-right:69px' href='<?  echo $this->base ?>/admin/registres/pages/7'>Page BSM</a>
			<a style='padding-right:37px' href='<?  echo $this->base ?>/admin/annonces/pub'>Votre Publicité</a>
			</div>
			<div style='height:25px;'>
			<a style='padding-right:55px' href='<?  echo $this->base ?>/admin/mails'>News Letters</a>
			<a style='padding-right:6px' href='<?  echo $this->base ?>/annonces/plan'>Proprietaires E-mails</a>
			</div>
			<div style='height:25px;'>
			<a  style='padding-right:43px' href='<?  echo $this->base ?>/admin/utilisateurs/gestion'>Club Alpissime</a>
			<a style='padding-right:72px' href='<?  echo $this->base ?>/admin/utilisateurs/podcast'>Podcast</a>
			</div>
			<div style='height:25px'>
			<a  style='padding-right:65px' href='<?  echo $this->base ?>/admin/utilisateurs/animlist'>Animateur</a>
			<a  style='padding-right:42px' href='<?  echo $this->base ?>/admin/utilisateurs/smslocataire/'>Sms Locataire</a>
			</div>
			<div style='height:25px'>
			<a  style='padding-right:46px' href='<?  echo $this->base ?>/admin/utilisateurs/sendsms/'>Sms Filemaker</a>
			<a  style='padding-right:42px' href='<?  echo $this->base ?>/admin/utilisateurs/maillocataire'>Mail Locataire</a>
			</div>
			<div style='height:25px;'>
			<a  style='padding-right:44px;' href='<?  echo $this->base ?>/admin/utilisateurs/mailfilemaker'>Mail Filemaker</a>
			<a  style='padding-right:57px;' href='<?  echo $this->base ?>/admin/utilisateurs/modelmail'>Model mail</a>
			</div>
		</div>-->

	</div>
	<div class="loc_menu_footer"></div>
</div>
