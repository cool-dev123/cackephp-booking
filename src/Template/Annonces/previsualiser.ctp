<style>
    img.image_annonce.img-fluid {
        width: 100%;
    }
    .carreGris {
        background: #f3f4f5;
        font-size: 15px;
        font-weight: bold;
    }
    svg.checked {
        fill: green;
    }
    svg.cross {
        fill: red;
    }

    .animated {
        -webkit-animation-duration: 2s;
        animation-duration: 2s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            -webkit-transform: translate3d(0, 100%, 0);
            transform: translate3d(0, 100%, 0);
        }
        to {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
    }
    .fadeIn {
        -webkit-animation-name: fadeInUp;
        animation-name: fadeInUp;
    }
    .delay2 {
        animation-delay: .5s;
    }
    .delay3 {
        animation-delay: 1s;
    }
    .delay4 {
        animation-delay: 1.5s;
    }
</style>
<?php 
function formatStr($titre)
{
  $str = strtr($titre,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
  $str = str_replace("é","e",$titre);
  $str = str_replace("è","e",$str);
  $str = str_replace("ê","e",$str);
  $str = str_replace("à","a",$str);
  $str = str_replace("â","a",$str);
  $str = str_replace("ä","a",$str);
  $str = str_replace("î","i",$str);
  $str = str_replace("ï","i",$str);
  $str = str_replace("ô","o",$str);
  $str = str_replace("ö","o",$str);
  $str = str_replace("ù","u",$str);
  $str = str_replace("û","u",$str);
  $str = str_replace("ü","u",$str);
  $str = str_replace(",","-",$str);
  $str = str_replace("'","-",$str);
  $str = str_replace(" ","-",$str);
  $str = str_replace("(","",$str);
  $str = str_replace(")","",$str);
  $str = str_replace("É","e",$str);
  $str = str_replace("%","pourcent",$str);
  $str = str_replace("œ","oe",$str);
  $str = str_replace("Œ","oe",$str);
  $str = str_replace("€","euros",$str);
  $str = str_replace("/","-",$str);
  $str = str_replace("+","-",$str);
  $str = str_replace("ç","c",$str);
  $str = str_replace("*","",$str);
  $str = str_replace("?","",$str);
  $str = str_replace("!","",$str);
  $str = str_replace("°","",$str);
  $str = str_replace("<","",$str);
  $str = str_replace(">","",$str);
  $str = str_replace("----","-",$str);
  $str = str_replace("---","-",$str);
  $str = str_replace("--","-",$str);
  $str = str_replace("²","",$str);
  $str = str_replace(":","",$str);
  return htmlentities($str);
}
?>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
jQuery(document).ready(function() {
    $(".menu_annon").css('display','block');

    var fileTypes = ['pdf'];  //acceptable file types
	$("input:file").change(function (evt) {
	    var parentEl = $(this).parent();
	    var tgt = evt.target || window.event.srcElement,
	                    files = tgt.files;

	    // FileReader support
	    if (FileReader && files && files.length) {
	        var fr = new FileReader();
	        var extension = files[0].name.split('.').pop().toLowerCase(); 
	        fr.onloadend = function(e){
	            console.debug("Load End");
	        }
            fr.readAsDataURL(files[0]);
            $("#uploadfilelabel").html(files[0].name);
	    }   
	});
});

function openjustifdomicile(){
    $('#popupjustifdomicile').modal('show');
}

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('JustifdomicileForm');
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
<?php $this->Html->scriptEnd(); ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="etape_publier" class="container">
    <div class="row bg-light no-gutters mb-4 mt-n3" >
        <div class="col-sm-6 col-lg-3 list-steps">
            <a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/edit/<?php echo $annonce_id ?>"><span class="d-block text-center ann-step">1. <?= __("Informations") ?></span></a>
        </div>
        <div class="col-sm-6 col-lg-3 list-steps">
            <a href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']; ?>/photo/<?php echo $annonce_id ?>'><span class="d-block text-center ann-step">2. <?= __("Images") ?></span></a>
        </div>
        <div class="col-sm-6 col-lg-3 list-steps">
            <a  href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['dispos']; ?>/view/<?php echo $annonce->id ?>'><span class="d-block text-center ann-step">3. <?= __("Tarification") ?></span></a>
        </div>
        <div class="col-sm-6 col-lg-3 list-steps">
            <span class="d-block text-center text-lg-right text-xl-center ann-step active-steps">4. <?= __("Prévisualisation") ?></span>
        </div>
    </div><!-- end row -->

<div class="row">
    <div class="col-md-12">
        <?php echo $this->Flash->render() ?>
        <div class="header_title">
            <h5 class="mb-2 mt-2 py-2 px-3"><?= __("Finalisation") ?></h5>
        </div>
    </div> 
</div> 
<div class="row px-3">
    <div class="col-sm-12 col-md carreGris pt-4 pb-4 px-5 mb-3 mr-3 font-weight-normal animated fadeIn">
        <svg aria-hidden="true" class="<?php if($nbrimages >= 5) echo "checked"; else echo "cross"; ?>" width="50" height="50" viewBox="0 0 128 128">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/reshot-icon-cross.svg#<?php if($nbrimages >= 5) echo "_x35__2_"; else echo "_x34__2_"; ?>"></use>
        </svg> 
        <h4 class="mt-4 mb-0"><?= __("Images") ?></h4> 
        <p class="m-0">
            <?php 
                if($nbrimages >= 5) echo __("C'est parfait ! Vous avez ajouté {0} images", $nbrimages);
                else echo __("Nous vous conseillons d’ajouter au moins 5 images à votre annonce pour obtenir plus de demandes de réservation. Attention, les annonces sans images ne pourront pas être validées.")." <a href = '".$this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/photo/".$annonce_id."' class='font-italic text-secondary'><u>".__("Retourner à cette étape")."</u></a>";
            ?>
        </p> 
    </div>
    <div class="col-sm-12 col-md carreGris pt-4 pb-4 px-5 mb-3 ml-2 font-weight-normal animated fadeIn delay2">
        <svg aria-hidden="true" class="<?php if($nbrdispo > 0) echo "checked"; else echo "cross"; ?>" width="50" height="50" viewBox="0 0 128 128">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/reshot-icon-cross.svg#<?php if($nbrdispo > 0) echo "_x35__2_"; else echo "_x34__2_"; ?>"></use>
        </svg>
        <h4 class="mt-4 mb-0"><?= __("Tarifs et disponibilités") ?></h4> 
        <p class="m-0">
            <?php
            if($nbrdispo > 0) echo __("C'est parfait ! Les vacanciers peuvent trouver votre hébergement lors de leurs recherches");
            else echo __("Ajoutez des tarifs pour permettre aux vacanciers de trouver votre hébergement lors de vos recherches. Les annonces sans tarifs ne peuvent être validées par notre équipe.")." <a href = '".$this->Url->build('/',true).$urlLang.$urlvaluemulti['dispos']."/view/".$annonce_id."' class='font-italic text-secondary'><u>".__("Retourner à cette étape")."</u></a>";
            ?>
        </p>   
    </div>
    <div class="w-100"></div>
    <div class="col-sm-12 col-md carreGris pt-4 pb-4 px-5 mb-3 mr-3 font-weight-normal animated fadeIn delay3">
        <svg aria-hidden="true" class="<?php if($annonce->num_enregistrement != "") echo "checked"; else echo "cross"; ?>" width="50" height="50" viewBox="0 0 128 128">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/reshot-icon-cross.svg#<?php if($annonce->num_enregistrement != "") echo "_x35__2_"; else echo "_x34__2_"; ?>"></use>
        </svg>          
        <h4 class="mt-4 mb-0"><?= __("Numéro d'immatriculation") ?></h4> 
        <p class="m-0">
            <?php
            if($annonce->num_enregistrement != "") echo __("Vous avez rempli votre numéro d'immatriculation");
            else echo __("Si la commune de rattachement de votre hébergement a mis en place cette mesure, merci de bien vouloir faire une demande d'immatriculation. Ce point n’est pas bloquant pour la validation de votre annonce.")." <a href = '".$this->Url->build('/',true).$urlLang.$urlvaluemulti['annonces']."/edit/".$annonce_id."' class='font-italic text-secondary'><u>".__("Retourner à cette étape")."</u></a>";
            ?>
        </p>  
    </div>
    <div class="col-sm-12 col-md carreGris pt-4 pb-4 px-5 mb-3 ml-2 font-weight-normal animated fadeIn delay4">
        <svg aria-hidden="true" class="<?php if($annonce->justificatif_domicile != "") echo "checked"; else echo "cross"; ?>" width="50" height="50" viewBox="0 0 128 128">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/reshot-icon-cross.svg#<?php if($annonce->justificatif_domicile != "") echo "_x35__2_"; else echo "_x34__2_"; ?>"></use>
        </svg>          
        <h4 class="mt-4 mb-0"><?= __("Justificatif de domicile") ?></h4> 
        <p class="m-0">
            <?php
            $urljustifdomicile = "justificatifdomicile/".$annonce->justificatif_domicile;
            if($annonce->justificatif_domicile != "") echo __("Vous avez déjà renseigné votre justificatif de domicile lors du dépôt de votre annonce").". <a href = '".$this->Url->build('/',true).$urljustifdomicile."' class='font-italic text-secondary' target='_blank'><u>".__("Voir mon justificatif")."</u></a> - <a href = '#' onclick='openjustifdomicile()' class='font-italic text-secondary'><u>".__("Télécharger un nouveau justificatif")."</u></a>";
            else echo __("Ajoutez un justificatif de domicile concernant l’hébergement que vous déposez sur Alpissime pour prouver que vous êtes bien son propriétaire. Cette étape est obligatoire pour valider votre annonce.")." <a href = '#' onclick='openjustifdomicile()' class='font-italic text-secondary'><u>".__("Télécharger mon justificatif")."</u></a>"; 
            ?>
        </p>  
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="header_title bg-light">
            <h5 class="mb-2 mt-2 py-2 px-3"><?= __("Prévisualiser votre annonce") ?></h5>
        </div><!-- header_title-->
    </div> <!--end col-md-12-->
</div> <!--end row-->
                    
                    
                    <div class="row">
                        <div class="col-md-12 block">
                            <div class="annonce block">
                                

    <?php echo $this->annonceFormater->vignette_previsualiser($annonce,$a_lieugeos,$l_natures_location,$this->Url->build('/',true),$photos);?>


                            </div>
</div>
</div>

<div class="row mt-4">
    <div class="col-md-12 block">
        <?php 
        $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
        $lannonce = strtolower(str_replace(" ","-",trim(formatStr($annonce["titre"]))));
        $url = $this->Url->build('/', true);
        $hrefDetailAnn = $url.'station/'.$annonce['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$annonce['id']."_".$lannonce;
        $lien = $hrefDetailAnn; ?>
        <?php if($annonce['statut'] != 0){ ?>               
        <p class="text-break"><?= __("Pour créez un lien direct depuis votre site internet, copiez-collez le texte suivant") ?>: <br><i> &lt;a href="<?php echo $lien?>"<br>
										           &gt;<?= __("Tarifs et disponibilités") ?> &lt;/a&gt; </i>.</p>
        <?php }else{ ?>
            <p class="text-break"> <?= __("Merci") ?> ! <br>
                <?= __("Votre annonce a bien été enregistrée et vient d'être envoyée à la validation par nos équipes.") ?> <br>
                <?= __("En attendant, n'hésitez pas à consulter notre") ?> <a href="https://help.alpissime.com" target="_blank"><?= __("Centre d'aide") ?></a>. 
            </p>
        <?php } ?>
        <?php if($annonce->statut != 50 && $annonce['utilisateur']['valide_at'] == null){ ?>
        <div class="remarque border mt-5 py-3 px-5">
            <?= __("Pour envoyer votre annonce à la validation, <span class='text-blue'>activez votre compte grâce à l'email que vous avez reçu.</span><br>Si vous ne le trouvez pas, pensez à regarder dans dossier spams et à approuver Alpissime comme contact !") ?>
        </div>
        <?php } ?>
    </div>
</div>
<div class="row mt-4 justify-content-end">
    <div class="col-auto">
        <?php if($this->Session->read('Auth.User.id')!=""):?>
		<button class="btn btn-blue text-white rounded-0 px-6" onclick="location.href = '<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']; ?>';"><?= __("Terminer") ?></button>
<?php else:?>
<?php endif;?>
                            
    </div>
</div>

<!-- popupjustifdomicile -->
<div class="modal fade" id="popupjustifdomicile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" style="width:650px; max-width:700px;">
        <div class="modal-content">
            <div class="modal-header">
            <h5><?= __("Télécharger une version de votre justificatif de domicile") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>   
            </div>
            <?php echo $this->Form->create(null,["url" => $this->Url->build('/',true)."annonces/uploadjustificatifdomicile/",'id'=>'JustifdomicileForm','enctype'=>"multipart/form-data",'class'=>'JustifdomicileForm','novalidate']);?>
                <input type="hidden" name="annonce_id" value="<?php echo $annonce->id ?>">
                <div class="modal-body">
                    <div class="alert alert-danger d-none" role="alert" id="msgerrorphone">
                        <?= __("Le fichier n'a pas pu etre enregistré") ?>
                    </div>
                    <div class="col-md-12 block">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="uploadfile" name="uploadfile" accept=".pdf" aria-describedby="uploadfile" required>
                                <label class="custom-file-label" id="uploadfilelabel" for="uploadfile"><?= __("Choisir fichier") ?></label>
                            </div>
                        </div>
                        <div class="row mt-4 justify-content-end">
                            <div class="col-auto">
                            <button type="submit" class="btn btn-blue text-white rounded-0 px-6" id="savejustif" value="Enregistrer"><?= __("Enregistrer") ?></button>                              
                            </div>
                        </div>
                    </div>
                </div>                
            <?php echo $this->Form->end(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End popupjustifdomicile -->