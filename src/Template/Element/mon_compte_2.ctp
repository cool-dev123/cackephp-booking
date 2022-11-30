<? /*
<style>

.loc_menu a{
color:#000000;
}
.loc_menu_admin a{
color:#000000;
}
.loc_menu{

font-weight:normal;
	width:230px;
	height:26px;
	float:left;
	position:relative;
	left:70px;
	top:88px;
}
.coord_menu{
width:105px;
height:26px;
float:left;
background-image:url('<?php echo $this->base;?>/images/connexion.png');
background-repeat:no-repeat;
padding-top:2px;
padding-left:10px;
}
.loc_menu_admin{

font-weight:normal;
	height:26px;
	float:left;
	position:relative;
	top:88px;
}
.coord_menu_admin{
width:95px;
height:26px;
float:left;
background-image:url('<?php echo $this->base;?>/images/connexion.png');
background-repeat:no-repeat;
padding-top:2px;
margin-left:2px;
}
</style>
if(isset($no_connect_information)) {} else { ?>
    <? if ($session->read('Auth.Utilisateur.id')=="") { ?>
<div id="compte">
 <?=$form->create("Utilisateur",array("action"=>"connexion"))?>
		<span id="titre-compte">Mon Compte</span>
		<div style="margin-bottom:138px;">
		<div class="left">
		<p class="client">Vous &ecirctes d&eacute;ja client:</p>
		<p><label for="email">Email</label></p>
		<p> <?=$form->input("ident",array("label"=>false,"maxlength"=>"50","size"=>"20","div"=>false))?> </p>
		<p><label for="password">Mot de Passe </label></p>
		<p><?=$form->input("pwd",array("label"=>false,"size"=>"8","div"=>false,"type"=>"password"))?></p>
		</div>
		<div class="right"><span>vous n'&ecirc;tes pas <br/>encore client</span>
		<p><a href="<?php echo $this->base?>/blog/?page_id=186" />S'inscrire</a>|<?=$html->link("Conditions","$this->base/blog/conditions-generales")?></p>
		</div></div>
		<p><input type="submit" name="connexion" value="Connexion" class="submit" style="margin-top:-5px;margin-right:80px"/><?= $html->link("mot de passe perdu","/utilisateurs/mdp_perdu")?> </p>
<?=$form->end()?>
		</div>
<? } else { ?>
<div id="compte_connectee">
<span style="color:#000; font-size:14px; margin-left:70px;">Bonjour&nbsp;</span>
        <span style="color:#3039ae; font-size:13px;"><?=ucwords($session->read('Auth.Utilisateur.prenom'))?>&nbsp;
        <?=ucwords($session->read('Auth.Utilisateur.nom_famille'))?>&nbsp;</span>

        <? switch($session->read("Auth.Utilisateur.nature")) {
            case "ADM":

				echo '<div class="loc_menu_admin" >';
				echo '<div class="coord_menu_admin"><center><a href=\'/\'><?= __("Accueil") ?></a></center></div>';
				echo '<div class="coord_menu_admin"><center><a href=\'/admin/utilisateurs\'>Espace Admin</a></center></div>';
				echo '<div class="coord_menu_admin"><center><a href=\'/utilisateurs/logout\' >D&eacute;connexion</a></center></div>';
				echo '</div>';

            break;
			case "MIXTE":
				echo '<div style="padding-top:85p;">';
				echo "<div id='loginbutton'><a href='/utilisateurs/logout' style=\"display:-moz-compact;\"><button>D&eacute;connexion</button></a>";
				echo "<a href='/utilisateurs' style='display:-moz-compact;'><button>Espace propri&eacute;taire</button></a>";
				echo "<a href='/utilisateurs/locataire_index' style='display:-moz-compact;'><button><?= __("Espace locataire") ?></button></a>";
				echo "</div></div>";
            break;
            case "CLT":

				echo '<div class="loc_menu" >';
				echo '<div class="coord_menu"><a href=\'/utilisateurs/locataire_index\'><?= __("Mon espace") ?></a></div>';
				echo '<div class="coord_menu"><a href=\'/utilisateurs/logout\' >D&eacute;connexion</a> </div>';
				echo '</div>';
              break;
            default:

				echo '<div class="loc_menu" >';
				echo '<div class="coord_menu"><a href=\'/utilisateurs\'><?= __("Mon espace") ?></a></div>';
				echo '<div class="coord_menu"><a href=\'/utilisateurs/logout\' >D&eacute;connexion</a> </div>';
				echo '</div>';



        } ?>


</div>
<? }} */?>
<?=$html->css("style2.css")?>
<? if ($session->read('Auth.Utilisateur.id')=="") { ?>
<div id="ad_compte">
	<div class='ad_compte_top'>&nbsp;</div>
	<div class='ad_compte_content'>
		<div class='frm_conn'>
			<?=$form->create("Utilisateur",array("action"=>"connexion"))?>
				<div class='lb_geo'>Vous etes deja client ?</div>
				<?=$form->input("ident",array("label"=>false,"placeholder"=>"Votre Email","div"=>false,"style"=>"width:93%"))?>
				<?=$form->input("pwd",array("label"=>false,"placeholder"=>"Votre mot de passe","div"=>false,"type"=>"password","style"=>"width:93%"))?>
				<input name="connexion" type='submit' value='&nbsp;'/>
			<?=$form->end()?>
		</div>
		<div class='frm_inscrit'>
			<div class='top_inscrit'>&nbsp;</div>
			<div class='content_inscrit'>
				<img src='<?php echo $this->base?>/imgt/icon_user.png' />
				<p>Vous n'etes pas encore client ?</p>
				<div class='link_inscrit'><a href="<?php echo $this->base?>/blog/?page_id=186" />S'inscrire</a> | <?=$html->link("Conditions","$this->base/blog/conditions-generales")?></div>
			</div>
			<div class='footer_inscrit'>&nbsp;</div>
			<div class='mot_perdu'><?= $html->link("Mot de passe perdu","/utilisateurs/mdp_perdu")?></div>
		</div>
	</div>
	<div class='ad_search_footer'>&nbsp;</div>
</div>
<?}else{?>
	<? switch($session->read("Auth.Utilisateur.nature")) {
            case "ADM":
				echo '<div id="locataire_compte">';
				echo "<div class='loc_top adm'></div>";
				echo "<div class='loc_content'>";
				echo "<div class='loc_content_txt'>";
				echo "<div style='color: #2A3F6C;'>Bonjour</div><div style='color: #5381BC;'>".ucwords($session->read('Auth.Utilisateur.prenom'))." ".ucwords($session->read('Auth.Utilisateur.nom_famille'))."</div>";
				//echo "<br/><a href='/admin/utilisateurs/animlist'>Animateur</a>";
				echo "</div>";
				echo "<div class=\"link_compte\">";
				echo "<a href='/'><img src='".$this->base."/imgt/accueil_admin.png'></a>";
                echo "<a href='/admin/utilisateurs'><img src='".$this->base."/imgt/btn_monespace_loc_esp.png'></a>";
                echo "<a href='/utilisateurs/logout'><img src='".$this->base."/imgt/btn_deconnexion_loc_esp.png'></a>";
				echo "</div>";
				echo '</div>';
				echo '<div class="loc_footer"></div>';
				echo '</div>';
				/*echo '<div class="loc_menu_admin" >';
				echo '<div class="coord_menu_admin"><center><a href=\'/\'><?= __("Accueil") ?></a></center></div>';
				echo '<div class="coord_menu_admin"><center><a href=\'/admin/utilisateurs\'>Espace Admin</a></center></div>';
				echo '<div class="coord_menu_admin"><center><a href=\'/utilisateurs/logout\' >D&eacute;connexion</a></center></div>';
				echo '</div>';*/

            break;
			case "MIXTE":
				echo '<div style="padding-top:85p;">';
				echo "<div id='loginbutton'><a href='/utilisateurs/logout' style=\"display:-moz-compact;\"><button>D&eacute;connexion</button></a>";
				echo "<a href='/utilisateurs' style='display:-moz-compact;'><button>Espace propri&eacute;taire</button></a>";
				echo "<a href='/utilisateurs/locataire_index' style='display:-moz-compact;'><button>".__("Espace locataire")."</button></a>";
				echo "</div></div>";
            break;
            case "CLT":
            	echo '<div id="locataire_compte">';
				echo "<div class='loc_top'></div>";
				echo "<div class='loc_content'>";
				echo "<div class='loc_content_txt'>";
				echo "<div style='color: #2A3F6C;'>Bonjour</div><div style='color: #5381BC;'>".ucwords($session->read('Auth.Utilisateur.prenom'))." ".ucwords($session->read('Auth.Utilisateur.nom_famille'))."</div>";
				echo "</div>";
				echo "<div class=\"link_compte\">";
                echo "<a href='/utilisateurs/locataire_index'><img src='".$this->base."/imgt/btn_monespace_loc_esp.png'></a>";
                echo "<a href='/utilisateurs/logout'><img src='".$this->base."/imgt/btn_deconnexion_loc_esp.png'></a>";
				echo "</div>";
				echo '</div>';
				echo '<div class="loc_footer"></div>';
				echo '</div>';
              break;
            default:

				echo '<div id="locataire_compte">';
				echo "<div class='loc_top clt'></div>";
				echo "<div class='loc_content'>";
				echo "<div class='loc_content_txt'>";
				echo "<div style='color: #2A3F6C;'>Bonjour</div><div style='color: #5381BC;'>".ucwords($session->read('Auth.Utilisateur.prenom'))." ".ucwords($session->read('Auth.Utilisateur.nom_famille'))."</div>";
				echo "</div>";
				echo "<div class=\"link_compte\">";
                echo "<a href='/utilisateurs/'><img src='".$this->base."/imgt/btn_monespace_loc_esp.png'></a>";
                echo "<a href='/utilisateurs/logout'><img src='".$this->base."/imgt/btn_deconnexion_loc_esp.png'></a>";
				echo "</div>";
				echo '</div>';
				echo '<div class="loc_footer"></div>';
				echo '</div>';
			}
	?>
<? }?>
<div style='width:299px;float:left;height:8px;'>&nbsp;</div>
