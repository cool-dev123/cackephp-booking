<?php echo $this->Html->css("style2.css")?>
<?php //echo $this->Session->read('Auth.User.id').'>>>>>>>>>>>>>>>>>';?>
<?php if ($this->Session->read('Auth.User.id')=="") { ?>
<div id="ad_compte">
	<div class='ad_compte_top'>&nbsp;</div>
	<div class='ad_compte_content'>
		<div class='frm_conn'>
			<?php echo $this->Form->create(null,['url' => ['controller' => 'Utilisateurs', 'action' => 'connexion']])?>
				<div class='lb_geo'>Vous êtes déjà client ?</div>
				<?php echo $this->Form->input("ident",["label"=>false,"placeholder"=>"Votre Email",'templates' => ['inputContainer' => "{{content}}"],"style"=>"width:93%"])?>
				<?php echo $this->Form->input("pwd",["label"=>false,"placeholder"=>"Votre mot de passe",'templates' => ['inputContainer' => "{{content}}"],"type"=>"password","style"=>"width:93%"])?>
				<input name="connexion" type='submit' value='&nbsp;'/>
			<?php echo $this->Form->end()?>
		</div>
		<div class='frm_inscrit'>
			<div class='top_inscrit'>&nbsp;</div>
			<div class='content_inscrit'>
				<img src='<?php echo $this->Url->build('/',true)?>imgt/icon_user.png' />
				<?php  //if(strcmp($this->params['url']['url'],'utilisateurs/add')!=0 ):?>
				<p>Vous n'êtes pas encore client ?</p>
				
				<?php //endif;?>
				<div class='link_inscrit'>
				<?php  //if(strcmp($this->params['url']['url'],'utilisateurs/add')!=0 ):?>
				<a href="<?php echo $this->Url->build('/',true)?>utilisateurs/add" />S'inscrire</a> | 
				<?php /*else:?>
				<p>&nbsp;</p>
				<?php endif;*/?>
				<a target="_blanck" href="<?php echo BLOG_ALPISSIME ?>/blog/conditions-generales">Conditions</a>
				
				</div>
			</div>
			<div class='footer_inscrit'>&nbsp;</div>
			<div class='mot_perdu'><?php echo  $this->Html->link("Mot de passe perdu","/utilisateurs/mdp_perdu")?></div>
		</div>
	</div>
	<div class='ad_search_footer'>&nbsp;</div>
</div>
<?php }else{?>
	<?php switch($this->Session->read("Auth.User.nature")) {
            case "ADM":
				echo '<div id="locataire_compte">';
				echo "<div class='loc_top adm'></div>";
				echo "<div class='loc_content'>";
				echo "<div class='loc_content_txt'>";
				echo "<div style='color: #2A3F6C;'>Bonjour</div><div style='color: #5381BC;'>".ucwords($this->Session->read('Auth.User.prenom'))." ".ucwords($this->Session->read('Auth.User.nom_famille'))."</div>";
				//echo "<br/><a href='/admin/utilisateurs/animlist'>Animateur</a>";
				echo "</div>";
				echo "<div class=\"link_compte\">";
				echo "<a href='/'><img src='".$this->Url->build('/',true)."imgt/accueil_admin.png'></a>";
                echo "<a href='".$this->Url->build('/',true)."admin/utilisateurs'><img src='".$this->Url->build('/',true)."imgt/btn_monespace_loc_esp.png'></a>";
                echo "<a href='".$this->Url->build('/',true)."utilisateurs/logout'><img src='".$this->Url->build('/',true)."imgt/btn_deconnexion_loc_esp.png'></a>";
				echo "</div>";
				echo '</div>';
				echo '<div class="loc_footer"></div>';
				echo '</div>';
			break;
			case "MIXTE":
				echo '<div style="padding-top:85p;">';
				echo "<div id='loginbutton'><a href='/utilisateurs/logout' style=\"display:-moz-compact;\"><button>D&eacute;connexion</button></a>";
				echo "<a href='".$this->Url->build('/',true)."utilisateurs' style='display:-moz-compact;'><button>Espace propri&eacute;taire</button></a>";
				echo "<a href='".$this->Url->build('/',true)."utilisateurs/locataire_index' style='display:-moz-compact;'><button>".__("Espace locataire")."</button></a>";
				echo "</div></div>"; 
            break;
            case "CLT":			
            	echo '<div id="locataire_compte">';
				echo "<div class='loc_top'></div>";
				echo "<div class='loc_content'>";
				echo "<div class='loc_content_txt'>";
				echo "<div style='color: #2A3F6C;'>Bonjour</div><div style='color: #5381BC;'>".ucwords($this->Session->read('Auth.User.prenom'))." ".ucwords($this->Session->read('Auth.User.nom_famille'))."</div>";
				echo "</div>";
				echo "<div class=\"link_compte\">";
                echo "<a href='".$this->Url->build('/',true)."utilisateurs/locataire_index'><img src='".$this->Url->build('/',true)."imgt/btn_monespace_loc_esp.png'></a>";
                echo "<a href='".$this->Url->build('/',true)."utilisateurs/logout'><img src='".$this->Url->build('/',true)."imgt/btn_deconnexion_loc_esp.png'></a>";
				echo "</div>";
				echo '</div>';
				echo '<div class="loc_footer"></div>';
				echo '</div>';
              break;
			case "ANIM":			
            	echo '<div id="locataire_compte">';
				echo "<div class='loc_top'></div>";
				echo "<div class='loc_content'>";
				echo "<div class='loc_content_txt'>";
				echo "<div style='color: #2A3F6C;'>Bonjour</div><div style='color: #5381BC;'>".ucwords($this->Session->read('Auth.User.prenom'))." ".ucwords($this->Session->read('Auth.User.nom_famille'))."</div>";
				echo "</div>";
				echo "<div class=\"link_compte\">";
                echo "<a href='".$this->Url->build('/',true)."utilisateurs/animateur'><img src='".$this->Url->build('/',true)."imgt/btn_monespace_loc_esp.png'></a>";
                echo "<a href='".$this->Url->build('/',true)."utilisateurs/logout'><img src='".$this->Url->build('/',true)."imgt/btn_deconnexion_loc_esp.png'></a>";
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
				echo "<div style='color: #2A3F6C;'>Bonjour</div><div style='color: #5381BC;'>".ucwords($this->Session->read('Auth.User.prenom'))." ".ucwords($this->Session->read('Auth.User.nom_famille'))."</div>";
				echo "</div>";
				echo "<div class=\"link_compte\">";
                echo "<a href='".$this->Url->build('/',true)."utilisateurs/'><img src='".$this->Url->build('/',true)."imgt/btn_monespace_loc_esp.png'></a>";
                echo "<a href='".$this->Url->build('/',true)."utilisateurs/logout'><img src='".$this->Url->build('/',true)."imgt/btn_deconnexion_loc_esp.png'></a>";
				echo "</div>";
				echo '</div>';
				echo '<div class="loc_footer"></div>';
				echo '</div>';
			}
	?>
<?php }?>
<div style='width:299px;float:left;height:8px;'>&nbsp;</div>