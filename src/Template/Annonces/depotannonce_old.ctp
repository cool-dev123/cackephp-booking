<?php $this->Html->script("//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/intlTelInput.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/manager-arr/components/validationEngine/validationEngine.jquery.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/manager-arr/components/validationEngine/jquery.validationEngine.js", array('block' => 'scriptBottom')); ?>
<?php //$this->Html->script("/manager-arr/components/validationEngine/jquery.validationEngine-en.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-".$language_header_name.".min.js", array('block' => 'scriptBottom')); ?>

<style>
.bg-pagedepot-ete{
  background: url(<?php echo $this->Url->build('/') ?>images/depot-annonce-ete.jpg) center no-repeat;
  height: 540px;
}
.bg-pagedepot{
  background: url(<?php echo $this->Url->build('/') ?>images/depot-annonce-hiver.jpg) center no-repeat;
  height: 540px;
}
</style>

<?php if(in_array(date("m"),array('05','06','07','08'))){?>
  <div class="container-fluid bg-pagedepot-ete mt-n5" id="toptampon">
<?php }else{ ?>
	<div class="container-fluid bg-pagedepot mt-n5" id="toptampon">
<?php } ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

  <div class="row justify-content-end h-100">
<div class="col-md-9 col-lg-7 mr-lg-5 my-3 align-self-center">
<div class="bg-white p-3 p-md-5">
<h1 class="mb-4"><?= __("Améliorez vos revenus en louant votre hébergement sur Alpissime") ?></h1>
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

<div class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>
                    </div>
</div>
<div class="form-group form-row">
    <div class="col">
        <?php echo $this->Form->input('nature',['label'=>false,'empty'=>__("Type d'hébergement")." *",'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_natures_location,'class'=>'form-control custom-select rounded-0','required'])?>
        <div class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>
                    </div>
      </div>
    <div class="col">
        <?php echo $this->Form->input('personnes_nb',['label'=>false,'empty'=>__("Nombre de voyageurs")." *",'templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>$l_nombre_personnes,'class'=>'form-control custom-select rounded-0','required'])?>
        <div class="invalid-feedback">
                        <?= __("Champs obligatoires") ?>
                    </div>
      </div>
</div>
<div class="form-group form-row justify-content-between">
    <div class="col-auto"><a id="scrollto" href="#" class="text-secondary"><u><?= __("En savoir plus") ?></u></a></div>
<div class="col-auto"><button type="submit" id="clickcommencer" class="btn btn-blue text-white rounded-0 px-5 px-md-6"><?= __("Commencer") ?></button></div>
</div>
<?php echo $this->Form->end();?>        
</div>
</div>
</div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col bg-blue text-center">
      <h1 id="titreh1" class="text-white py-4"><?= __("Dépôt d'annonce gratuit et sans abonnement") ?> </h1>
    </div>
  </div>
</div>
<div class="container">
  <div class="row px-lg-5 my-5">
    <div class="col-12 col-md-6">
      <h1 class="mb-4"><?= __("Gardez le contrôle") ?>...</h1>
      <p><?= __("Gerez en direct vos locations et optimisez votre taux de remplissage pour une rentabilité satisfaisante.") ?></p>
      <p><?= __("La location de vacance avec Alpissime vous permet de couvrir les frais d'entretien et de rénovation de votre résidence secondaire et de la rentabiliser.") ?></p>
    </div>
    <div class="col-12 col-md-6">
      <h1 class="mb-4"><?= __("En toute simplicité!") ?></h1>
      <ol class="list-depotann">
        <li><?= __("Déposez votre annonce") ?></li>
        <li><?= __("Reçevez et acceptez des demandes de réservation") ?></li>
        <li><?= __("Percevez vos revenus") ?></li>
      </ol>
    </div>
  </div>
</div>
<div class="container-fluid bg-light py-5">
  <div class="row">
    <div class="container">
      <div class="row px-lg-5">
    <div class="col-md-4 mb-3">
      <div class="shadow bg-white p-4 h-100 text-center">
        <div class="icon-center bg-light d-inline-block rounded-circle p-3 mb-3">
          <svg class="icon-reassurance1" aria-hidden="true" width="100" viewBox="0 0 165.74 169.6">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/prix-reduits.svg#Calque_2"></use>
          </svg>
        </div>
        <div>
          <h2 class="text-blue font-weight-bold mx-lg-3"><?= __("Annonce gratuite et sans abonnement") ?></h2>
          <p><?= __("le dépôt d'annonce est gratuit et ne nécessite aucun abonnement. La commission liée à vos locations est limitée à 2%.") ?></p>
        </div>
      </div>
      </div>
      <div class="col-md-4 mb-3">
      <div class="shadow bg-white p-4 h-100 text-center">
        <div class="icon-center bg-light d-inline-block rounded-circle p-3 mb-3">
          <svg class="icon-reassurance1" aria-hidden="true" width="100" viewBox="0 0 165.74 169.6">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/paiement-securise.svg#Calque_2"></use>
          </svg>
        </div>
        <div>
          <h2 class="text-blue font-weight-bold mx-lg-3"><?= __("Paiement en ligne sécurisé") ?></h2>
          <p><?= __("Fini les paiements par chèque ou virements bancaires !<br>Profitez du paiement sécurisé de vos locations et cautions et louez l'esprit tranquille.") ?></p>
        </div>
      </div>
      </div>
      <div class="col-md-4 mb-3">
      <div class="shadow bg-white p-4 h-100 text-center">
        <div class="icon-center bg-light d-inline-block rounded-circle p-3 mb-3">
          <svg class="icon-reassurance1" aria-hidden="true" width="100" viewBox="0 0 165.74 169.6">
            <use xlink:href="<?php echo $this->Url->build('/')?>images/svg/partenaires-verifies.svg#Calque_2"></use>
          </svg>
        </div>
        <div>
          <h2 class="text-blue font-weight-bold mx-lg-3"><?= __("Des réductions en stations") ?></h2>
          <p><?= __("Grâce à nos partenariats, vous et vos locataires recevez des réductions utilisables sur la marketplace Alpissime ou directement en station.") ?></p>
        </div>
      </div>
      </div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row px-lg-5 my-5">
    <div class="col-12 col-md-6">
      <h1 class="mb-5"><?= __("Une offre de location entre particuliers pensée pour les propriétaires") ?></h1>
      <p><?= __("Né en 2009, Alpissime s'est construit autour des demandes des propriétaires de résidences secondaires en station de ski. Depuis, nos équipes améliorent sans cesse les fonctionalités de la plateforme pour apporter simplicité et facilité à la gestion des hébergements proposés à la location sur internet.") ?>
      </p>
      <p><?= __("Vous êtes à la recherche d'une conciergerie ?") ?><br><a class="text-blue" target="_blank" href="<?php echo $this->Url->build('/')?>fr-services-et-contrats-proprietaires-de-residences-secondaires/"><u><?= __("Découvrez les stations dans lesquelles nous sommes présents.") ?></u> </a></p>
    </div>
    <div class="col-12 col-md-6">
      <ul class="puce-check">
        <li><?= __("Des conditions d'utilisation pensées pour vous protéger") ?></li>
        <li><?= __("Une assistance dédiée et à l'écoute") ?></li>
        <li><?= __("La gestion de vos demandes de location en toute simplicité") ?></li>
        <li><?= __("La possibilité de choisir une caution pour votre hébergement") ?></li>
        <li><?= __("La perception et le versement de la taxe de séjour aux municipalités") ?></li>
        <li><?= __("La gestion des inventaires et des incidents") ?></li>
      </ul>
    </div>
  </div>
</div>

<div class="container-fluid mb-n10">
  <div class="row">
    <div class="col bg-blue text-center text-white">
      <div class="my-4 mx-auto block-ref">
      <h1 class="text-white py-3"><?= __("Alpissime, la référence de la location de vacances entre particuliers en station de ski") ?></h1>
      <a class="btn btn-transp font-weight-bold mb-3 text-white mt-4 rounded-0 mx-auto scrollLink" href="#toptampon"><?= __("Déposer mon annonce") ?></a>
      </div>
    </div>
  </div>
</div>
<!-- popup connexion -->
<div class="modal fade" id="popup_connexion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <span class="orange h1modal text-center"><?= __("Connectez-vous pour continuer") ?></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body pt-3">
      
        <div class="alert alert-danger alert-connexion">          
        </div>
        <div class="alert alert-success">          
        </div>
        <div class="col-md-11 mx-auto">
          <form class="form-horizontal">
            <div class="form-group">
              <div class="col-12">
                <input type="email" class="form-control rounded-0" id="email" placeholder="<?= __('Entrer votre email') ?>">
              </div>
            </div>
            <div class="form-group">
              
              <div class="col-12">
                <input type="password" class="form-control rounded-0" id="pwd" placeholder="<?= __('Entrer votre mot de passe') ?>">
              </div>
            </div>
            <div class="form-row mx-3">
              <div class="col-md-6">
                <a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mdpPerdu'];?>" class="paword_link text-secondary"><u><?= __("Mot de passe oublié !") ?></u></a>
              </div>
              <div class="form-group col-md-6 text-md-right">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="souvenirmoi">
                  <!-- <label class="custom-control-label text-secondary" for="souvenirmoi">Se souvenir de moi</label> -->
                </div>
              </div>
            </div>            
            <div class="form-group">
              <div class="col-12">
                <button type="button" class="btn btn-blue text-white rounded-0 mt-3 w-100" value="connexion" id="submitconnexion"><?= __("Connexion") ?></button>
              </div>
            </div>
          </form>
          <div class="form-group">
            <div class="col-12">
              <p class="right">  
               <span><?= __("Vous n'avez pas de compte ?") ?></span> <a href="#" class="paword_link orange" id="clickinscription"><?= __("Inscription") ?></a>
              </p>
            </div>
          </div>
        </div>
        
      </div>
      
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- popup inscription -->
<div class="modal fade" id="popup_inscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <span class="orange h1modal font-weight-bold"><?= __("Inscrivez-vous") ?> </span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger alert-inscription">
          
        </div>
        <div class="col-md-12">
        <?php echo $this->Form->create($utilisateur,['id'=>'UtilisateurAddForm']);?>
            <?php echo $this->Form->hidden('id');?>
            <?php echo $this->Form->hidden('etat',['value'=>$etat]);?>
            <?php echo $this->Form->hidden('updated',['value'=>1]);?>
            <?php echo $this->Form->hidden('nature',['value'=>'ANNO']);?>
            <!-- <input type="hidden" id="telephone" name="telephone" /> -->
            <input type="hidden" id="portable" name="portable" />
            <!-- <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label><?= __("Vous êtes") ?> <sup class="orange">*</sup></label>
                  <?php // echo $this->Form->input('nature',['type'=>'select','label'=>false,'class'=>'form-control','options'=>[''=>'Sélectionnez votre profil','CLT'=>'Locataire','ANNO'=>'Propriétaire']]);?>                           
                </div>
              </div>
            </div> -->
            <!-- /.row -->
            <div class="row">
            <!-- <div class="col-12"><label for="information"><?= __("Vos informations") ?></label></div> -->
            <div class="col-sm-6">
                    <div class="form-group">
                      <?php echo $this->Form->input('emailinscri',['type'=>'text','class'=>'form-control validate[required,custom[email]]','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45', 'placeholder'=>__('Votre adresse email').' *']);?>
                      <input type="hidden" name="ident" id="ident" value="">
                    </div>
                </div>
                <!-- /.col-sm-6 -->
                <div class="col-sm-6">
                    <div class="form-group">
                      <?php echo $this->Form->input('pays',['type'=>'select','class'=>'form-control','label'=>false,'options'=>$Pays,'default'=>'0']);?>
                    </div>
                </div>
                <!-- /.col-sm-6 -->
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo $this->Form->input('pwd2',['type'=>'password','class'=>'form-control validate[required,minSize[6]]','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Votre mot de passe').' *']);?>
                        <input type="hidden" name="pwd" id="pwd" value="">
                    </div>
                </div>
                <!-- /.col-sm-6 -->
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo $this->Form->input('pwd2_confirm',['type'=>'password','class'=>'form-control validate[required,equals[pwd2]]','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Confirmez votre mot de passe').' *']);?>
                    </div>
                </div>
                <!-- /.col-sm-6 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                      <?php echo $this->Form->input('nom_famille',['type'=>'text','class'=>'form-control validate[required]','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Votre nom').' *']);?>
                    </div>
                </div>
                <!-- /.col-sm-6 -->
                <div class="col-sm-6">
                    <div class="form-group">
                      <?php echo $this->Form->input('prenom',['type'=>'text','class'=>'form-control','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Votre prénom').' *']);?>                    
                    </div>
                </div>
                <!-- /.col-sm-6 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-6">
                    <div id="date_naissance" class="input-group mb-3">
                        <?php echo $this->Form->input('naissance',['type'=>'text','readonly'=>'readonly','class'=>'form-control calendrier validate[required]','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45','placeholder'=>__('Date de naissance').' *']);?>
                        <div class="input-group-append">
                          <div class="input-group-text"><label class="add-on mb-0" for="naissance"><i class="fa fa-calendar"></i></label></div>
                        </div>
                      </div>
                </div>
                <!-- /.col-sm-6 -->
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo $this->Form->input('portableNum',['type'=>'number','class'=>'form-control validate[required]','label'=>false,'templates' => ['inputContainer' => "{{content}}"],'size'=>'45']);?>
                        <span id="error-msg2" class="hide"><?= __("Numéro invalide") ?></span>
                    </div>
                </div>
                <!-- /.col-sm-6 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-6">
                </div>
                <!-- /.col-sm-6 -->
                <!-- <div class="col-sm-6 col-sm-offset-6">
                  <div class="form-group recaptcha-css" style="float:right">
                    
                  </div>
                </div> -->
                <!-- /.col-sm-6 -->
            </div>
            <div class="form-row">
          <div class="form-group col-md-7">
            <div class="custom-control custom-checkbox mt-md-4 mt-sm-0">
              <input type="checkbox" class="custom-control-input" id="conditiongen" name="conditiongen" required>
              <label class="custom-control-label text-secondary text-small" for="conditiongen"><?= __("J'accepte les") ?> <a class="text-secondary" href="<?php echo BLOG_ALPISSIME?>/conditions-generales-dutilisation-alpissime-com-2/" target="blanc"><u><?= __("Conditions Générales d'Utilisations") ?></u></a> * </label>
              <div class="invalid-feedback">
              <?= __("Vous devez accepter avant de valider.") ?>
              </div>
            </div>
          </div>
          <div class="form-group col-md-5">
				    <button type="submit" class="btn btn-blue text-white rounded-0 px-auto mt-md-3 mt-sm-0 w-100"><?= __("Inscription") ?></button>
          </div>
        </div>
           
          <?php echo $this->Form->end()?>
          
          <div class="form-group mb-0">
            <div class="col-12">
              <p class="right mb-0">  
               <span><?= __("Vous avez déjà un compte ?") ?></span> <a href="#" class="paword_link orange" id="clickconnexion"><?= __("Connexion") ?></a>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <div class="pull-right">
              <!-- <button type="submit" class="btn btn-success hvr-sweep-to-top " value="Envoyer"><?= __("ENVOYER") ?></button> -->
          </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Fin popup inscription -->

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
        }else{
          /* Ouvrir popup connexion */
          var utilisateur = "<?php echo $this->Session->read('Auth.User.nature') ?>";
          // if(utilisateur == ''){
          //   event.preventDefault();
          //   event.stopPropagation();
          //   $(".alert-success").css("display", "none");
          //   // $("#popup_connexion").modal('show');
          //   remplirchampsinscription();
          //   $("#popup_inscription").modal('show');
          //   $.cookie("modalshow", 1);
           
          // }
        }
        form.classList.add('was-validated');
        
      }, false);
    });
  }, false);
})();

$(document).ready(function(){
  $("#scrollto").click(function() {
    $('html, body').animate({
        scrollTop: $("#titreh1").offset().top
    }, 700);
  });

	$( "a.scrollLink" ).click(function( event ) {
		event.preventDefault();
		$("html, body").animate({ scrollTop: $($(this).attr("href")).offset().top }, 700);
	});
});

var validNum = "non";
var validNum2 = "non";
$(".alert-connexion").css("display", "none");
$(".alert-inscription").css("display", "none");
$(".alert-success").css("display", "none");

/* Ouvrir popup inscription  */
$("#clickinscription").click(function(){    
      $("#popup_connexion").modal('hide');
      remplirchampsinscription();
      $("#popup_inscription").modal('show');
  });
/* Ouvrir popup connexion */
$("#clickconnexion").click(function(){    
    $("#popup_inscription").modal('hide');
    $("#popup_connexion").modal('show');
});
/* Submit connexion */
  $("#submitconnexion").click(function(){    
      ajaxsubmitconnexion();
  });
/* Fermer connexion popup */
  $("#popup_connexion").on("hidden.bs.modal", function () {
    $(".alert-connexion").css("display", "none");
  });
/* Fermer connexion popup */
  $("#popup_inscription").on("hidden.bs.modal", function () {
    $(".alert-inscription").css("display", "none");
  });
/* Enter action for connexion popup */
  $('#pwd').keypress(function(e){
    if(e.keyCode == 13)
    {
      ajaxsubmitconnexion();
    }
  });
/* Fonction remplir champs inscription popup */
var monTableauJS;
function remplirchampsinscription(){
  $("#UtilisateurAddForm")[0].reset();
  /* remplir pays, ville, région */
  $.ajax({
    type: "POST",
    dataType : 'json',
    url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarraypays",
    data: {},
    success:function(xml){   
      $('#regiondiv').css('display','none');
      $("#ville").empty();
      data = xml.listepays;
      monTableauJS = xml.paysNum;      
      $('#pays').empty();
      $('#pays').append('<option value=0> Choisir votre pays </option>');
      for (var i = 0; i < data.length; i++) {
          $('#pays').append('<option value=' + data[i].id_pays + '>' + data[i].fr + '</option>');
      }
    }
  });

  $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);

  /* remplir date naissance */
  $('#naissance').datepicker({
      language: 'fr-FR',
      changeMonth: true,
      changeYear: true,
      yearRange :"-100:+0",
      dateFormat: 'dd/mm/yy'
  });

  

  /* remplir portable */
  
  var telInputP = $("#portablenum"),
  errorMsg2 = $("#error-msg2");
  telInputP.intlTelInput({
    utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
    initialCountry: 'fr',
    autoPlaceholder: true
  });
  var reset = function() {
    telInputP.removeClass("errorNumberTel");
    errorMsg2.addClass("hide");
  };
  reset();
  // on blur: validate
  telInputP.blur(function() {
    reset();
    if ($.trim(telInputP.val())) {
      if (telInputP.intlTelInput("isValidNumber")) {
        validNum2 = telInputP.intlTelInput("getNumber");
      } else {
        validNum2 = "non";
        telInputP.addClass("errorNumberTel");
        errorMsg2.removeClass("hide");
        errorMsg2.addClass("errorNumberTel");
      }
    }
  });
}

/* Ajax submit connexion function */
function ajaxsubmitconnexion(){
  $(".alert-success").css("display", "none");
  if($("#email").val() == ''){
    $(".alert-connexion").css("display", "block");
    $(".alert-connexion").html("Le champ Email ne doit pas être vide !");
  }else if($("#pwd").val() == ''){
    $(".alert-connexion").css("display", "block");
    $(".alert-connexion").html("Le champ Mot de passe ne doit pas être vide !");
  }else{
    $.ajax({
      type: "POST",
      dataType : 'json',
      url: "<?php echo $this->Url->build('/',true)?>utilisateurs/ouvrircompteajax",
      data: {email: $("#email").val(), pwd: $("#pwd").val()},
      success:function(xml){
        //console.log(xml.retourmessage);
        if(xml.retourmessage == "erreurconnexion"){
          $(".alert-connexion").css("display", "block");
          $(".alert-connexion").html("Erreur au moment de la connexion ! Vérifier vos données");          
        }else if(xml.retourmessage == "confirmationcompte"){
          $(".alert-connexion").css("display", "block");
          $(".alert-connexion").html("<?php echo __('Un email de confirmation vous a été envoyé par Alpissime (administration@alpissime.com). Veuillez consulter votre boite mail pour activer votre compte.'); ?>");
        }else{
          $(".alert-connexion").css("display", "none");
          $("#popup_connexion").modal('hide');
          if($.cookie("modalshow") == 1){
            var pageURL = $(location).attr("href");
            pageURL = pageURL.replace("#", "");
            window.location.href = pageURL+'?modal='+$.cookie("modalshow");
          }
          if($.cookie("modalshow") == 2){
            // console.log(xml.retouruser.nature);
            // console.log(xml.retouruser.valide_at);
            var utilisateurconnecte = xml.retouruser.nature;
            var utilisateurvalid = xml.retouruser.valide_at;
            if(utilisateurconnecte != "" && utilisateurvalid == null){
              $('#valider').prop('disabled', true);
              $('#valider').after("<span class='text-danger'>Vous devez activer votre adresse email pour réserver</span>");
              // console.log("ddd");
              if(utilisateurconnecte == "CLT"){
                $('#navbarSupportedContent .navbar-nav').html('<li class="nav-item"><a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a></li><li class="nav-item"><a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a></li><li class="nav-item"><a class="nav-link ml-lg-3 mr-lg-3" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><i class="fa fa-envelope-o"></i></a></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle nav-user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><img class="img-responsive" src="<?php echo $this->Url->build('/')?>images/user-icon.png" ></a><div class="dropdown-menu user-menu" aria-labelledby="navbarDropdown"><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index'];?>"><?= __("Profil") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a></div></li>');
              }else{
                $('#navbarSupportedContent .navbar-nav').html('<li class="nav-item"><a class="nav-link" href="<?php echo BLOG_ALPISSIME ?>" target="blank"><?= __("Magazine") ?></a></li><li class="nav-item"><a class="nav-link" href="<?php echo BOUTIQUE_ALPISSIME?>" target="blank"><?= __("Marketplace") ?></a></li><li class="nav-item"><a class="nav-link ml-lg-3 mr-lg-3" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><i class="fa fa-envelope-o"></i></a></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle nav-user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><img class="img-responsive" src="<?php echo $this->Url->build('/')?>images/user-icon.png" ></a><div class="dropdown-menu user-menu" aria-labelledby="navbarDropdown"><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs'];?>"><?= __("Espace Propriétaire") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/').$urlLang;?>reservations/validation"><?= __("Réservations") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Mes annonces") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo $this->Url->build('/',true)?>utilisateurs/logout"><?= __("Déconnexion") ?></a></div></li><li><button class="btn btn-sm btn-primary btn-alpissime ml-3" type="button" onclick="location.href=\'<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['ouvrircompte'];?>\'"><?= __("Créer une annonce") ?></button></li>');
              } 
              $(".notvalidiv").css("display", "block");
            }else{
              $('#valider').prop('disabled', false);
              $('#reserverform').submit();
              // console.log("555");
            }
            
          }
          
          //$("#popup_contact").modal('show');
          
        }
      }
    });
  } 
}

/* Ajax submit inscription */
jQuery("#UtilisateurAddForm").validationEngine({
  prettySelect : true,
  useSuffix: "_chzn"
});
$('#UtilisateurAddForm').submit(function(event) {  
    var valreturn = '';
  if(validNum2 == "non")
  {
    valreturn="non";
  }
  else {
    $("#portable").val(validNum2);
    //$("#telephone").val(validNum);
    $("#ident").val($("#email").val());
    $("#pwd").val($("#pwd2").val());

    valreturn="oui";
  }
  //alert(valreturn);
  // get the form data
  // there are many ways to get this data using jQuery (you can use the class or id also)
  var formData = {
      'nature' : $('#nature').val(),
      'email' : $('#emailinscri').val(),
      'pwd2' : $('#pwd2').val(),
      'pays' : $('#pays').val(),
      //'civilite' : $('#civilite').val(),
      'nom_famille' : $('#nom-famille').val(),
      'prenom' : $('#prenom').val(),
      //'adresse' : $('#adresse').val(),
      //'code_postal' : $('#code-postal').val(),
      //'ville' : $('#ville').val(),
      //'telephone' : $('#telephone').val(),
      'naissance' : $('#naissance').val(),
      'portable' : $('#portable').val(),
      //'g-recaptcha-response' : grecaptcha.getResponse()
      //'g-recaptcha-response' : $('.recaptcha-css #g-recaptcha-response').val()      
  };
  var testvalid = $("#UtilisateurAddForm").validationEngine('validate'); 

  if (testvalid && valreturn === "oui"){
    $.ajax({
      type : 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url : '<?php echo $this->Url->build('/',true)?>utilisateurs/addajax', // the url where we want to POST
      data : formData, // our data object
      dataType : 'json', // what type of data do we expect back from the server
      encode : true
    })
      // using the done promise callback
    .done(function(data) {
      if(data.message == "mailairbnb"){
        $(".alert-inscription").css("display", "block");
        $(".alert-inscription").html("<?= __('Les emails Airbnb, Abritel et Booking ne sont pas acceptés.') ?>");
        $("#popup_inscription .modal-dialog .modal-content .modal-body").animate({
            scrollTop: 0
        }, 1000);
      }else if(data.message == "erreur"){
        $(".alert-inscription").css("display", "block");
        $(".alert-inscription").html("Votre inscription n'a pas pu être terminée.");
        $("#popup_inscription .modal-dialog .modal-content .modal-body").animate({
            scrollTop: 0
        }, 1000);
      }else if(data.message == "mailexiste"){
        $(".alert-inscription").css("display", "block");
        $(".alert-inscription").html("Cette adresse email existe déjà.");
        $("#popup_inscription .modal-dialog .modal-content .modal-body").animate({
            scrollTop: 0
        }, 1000);
      }else if(data.message == "robot"){
        $(".alert-inscription").css("display", "block");
        $(".alert-inscription").html("Veuillez prouver que vous n'êtes pas un robot ! ");
        $("#popup_inscription .modal-dialog .modal-content .modal-body").animate({
            scrollTop: 0
        }, 1000);
      }else{
        $.ajax({
          type: "POST",
          dataType : 'json',
          url: "<?php echo $this->Url->build('/',true)?>utilisateurs/ouvrircompteajax",
          data: {email: $('#emailinscri').val(), pwd: $('#pwd2').val()},
          success:function(xml){
            $(".alert-inscription").css("display", "none");
            $("#popup_inscription").modal('hide');
            window.location.href = "<?php echo $this->Url->build('/',true)?>utilisateurs/connectionwithajax";
          }
        });
        // $(".alert-inscription").css("display", "none");
        // $("#popup_inscription").modal('hide');
        // $("#popup_connexion").modal('show');
        // $(".alert-success").css("display", "block");
        // $(".alert-success").html("Votre inscription a été effectuée avec success.");
        
      }
        //mailairbnb
        //erreur
        //mailexiste
        //robot

        // log data to the console so we can see
        //console.log(data); 

        // here we will handle errors and validation messages
    });
  }


  // stop the form from submitting the normal way and refreshing the page
  event.preventDefault();
});

// Since confModal is essentially a nested modal it's enforceFocus method
// must be no-op'd or the following error results 
// "Uncaught RangeError: Maximum call stack size exceeded"
// But then when the nested modal is hidden we reset modal.enforceFocus
var enforceModalFocusFn = $.fn.modal.Constructor.prototype._enforceFocus;
$.fn.modal.Constructor.prototype._enforceFocus = function() {};

<?php $this->Html->scriptEnd(); ?>
