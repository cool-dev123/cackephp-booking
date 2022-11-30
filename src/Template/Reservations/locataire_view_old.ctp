<?php //$this->Html->css("/css/jquery.dataTables.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->css("/css/new/dataTables.bootstrap4.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/jquery.dataTables.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/new/dataTables.bootstrap4.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/moment.min.js", array('block' => 'scriptBottom')); ?>
<?php setlocale (LC_ALL, 'fr_FR.UTF8'); ?>

<?php
$modalError = $_GET['error'];
if ($modalError == 1 && $this->Session->read('Auth.User.nature') != '') {
    echo "<script type='text/javascript'>
  setTimeout(function() {
    $('#msgerrorphone').removeClass('d-none');
    $('#popup_contact').modal('show');
    // Execute recaptcha
    // grecaptcha.execute();
  }, 1000);
  </script>";
}
?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="reservations" class="container">
    <?php echo $this->Flash->render() ?>
    <div class="row flex-column-reverse flex-md-row justify-content-md-between mb-5">
        <div class="col espace-menu">
            <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/edit/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Coordonnées") ?></a></h3>
            <?php if($this->Session->read('Auth.User.nature')!='CLT'){?>
                <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Annonces") ?></a></h3>
                <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['infobancaire'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Paiements") ?></a></h3>
            <?php }?>
            <h3 class="border-bottom-menu-espace float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a></h3>
            <h3 class="float-left"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a></h3>
        </div>
        <?php if($this->Session->read('Auth.User.nature')=='CLT'){?>
            <div class="col-auto">
                <a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index'];?>" class="text-decoration-none">
                    <h3 class="text-blue espace-type"><?= __("Espace locataire") ?></h3>
                </a>
            </div>
        <?php }?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="table_id_valid" class="table table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr class="thead">
                        <th><?= __("Titre") ?></th>
                        <th><?= __("Station") ?></th>
                        <th><?= __("Période") ?></th>
                        <th class="une-ligne"><?= __("Prix") ?></th>
                        <th><?= __("Contact") ?></th>
                        <th><?= __("Statut ") ?></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($reservations->toArray())) echo "<tr><td colspan='8'>Vous n'avez aucune réservation</td></tr>" ?>
                    <?php foreach ($reservations as $enr): ?>
                        <?php
                        $date1 = new DateTime();
                        $date2 = new DateTime($enr->dbt_at->i18nFormat('dd-MM-yyyy'));
                        $date3 = new DateTime($enr->fin_at->i18nFormat('dd-MM-yyyy'));
                        ?>
                        <tr>
                            <?php
                            $annonce = $enr['annonce'];
                            $str = str_replace("é","e",$annonce["titre"]);
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
                            $str = str_replace(","," ",$str);
                            $str = str_replace("'"," ",$str);
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
                            $annonce["titre"] = htmlentities($str);
                            $natureAnnURL = array("STD"=>__("studio"),"APP"=>__("appartement"),"CHA"=>__("chalet"),"DIV"=>__("location"),"VIL"=>__("villa"),"GIT"=>__("gite"));
                            $lannonce = strtolower(str_replace(" ","-",trim($annonce["titre"])));
                            $url = $this->Url->build('/', true);
                            $hrefDetailAnn = $url.$urlvaluemulti['station'].'/'.$enr['lieugeo']['nom_url'].'/'.$natureAnnURL[$annonce['nature']].'/'.$enr->annonce_id."_".$lannonce;
                            ?>
                            <td data-title="Titre"><a title='<?= __("Détails") ?>' class='font-weight-bold' href="<?php echo $hrefDetailAnn; ?>" target="_blank" style='cursor:pointer'><?php echo $enr['annonce']['titre']; ?></a></td>
                            <td data-title="Station"><?php echo $enr['lieugeo']['name'] ?></td>
                            <td data-title="Période"><?php echo $enr->dbt_at->i18nFormat('dd/MM/YY')." - ".$enr->fin_at->i18nFormat('dd/MM/YY') ?></td>
                            <td data-title="Total à payer (€)"><?php if($enr->prixapayer != 0) echo $enr->prixapayer."€"; ?></td>
                            <td data-title="Contact">
                                <button class="btn px-2 py-0" onclick="sendmsg(<?php echo $enr->id ?>)"><i class="fa fa-envelope-o fa-lg" aria-hidden="true"></i></button>
                                <?php if($date1 <= $date2 && $enr->statut == 90){ ?><button class="btn px-2 py-0" onclick="showNumber(<?php echo $enr->id ?>)"><i class="fa fa-phone fa-lg" aria-hidden="true"></i></button><?php } ?>
                            </td>
                            <td data-title="Statut"><?php echo $l_reservationsstatuts[$enr->statut]; ?>&nbsp; </td>
                            <td><?php
                                if($date1 > $date2){

                                }else{
                                    if($enr->arrivee == 0 && $enr->statut != 100 && $enr->statut != 10 && $enr->statut != 110 && $enr->statut != 60){
                                        if($enr->statut == 90) echo "<a title='".__('Supprimer')."' style='cursor:pointer' onclick='open_dialog_delete_justif(\"".$enr->id."\", \"".$enr->dbt_at->i18nFormat('dd-MM-yyyy')."\")' src='".$this->Url->build('/',true)."images/delete.png'><i class='fa fa-times fa-lg'></i></a>";
                                        else echo "<a title='".__('Supprimer')."' style='cursor:pointer' onclick='open_dialog_delete(\"".$enr->id."\")' src='".$this->Url->build('/',true)."images/delete.png'><i class='fa fa-times fa-lg'></i></a>";
                                    }?> &nbsp;<?php if($enr->statut != 100 && $enr->statut != 10 && $enr->statut != 110 && $enr->statut != 60) echo "<a title='".__('Modifier')."' style='cursor:pointer' onclick='open_dialog(\"".$enr->id."\")' src='".$this->Url->build('/',true)."images/edit.png'><i class='fa fa-eye fa-lg'></i></a>";
                                } ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="hdreservation"/>
<div id="dialog-error" title="<?= __('Fiche réservation') ?>">
    <div id="texte-error">

    </div>
</div>
<div style="display:none" id="dialog-res" title="Alpissime.com">
    <div id="texte-error1">
        <p><?= __("Si vous avez modifié votre date d'arrivée") ?></p>
        <p><?= __("le gestionnaire sur place est informé de cette modification") ?></p>
    </div>
</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="showNumberModal" tabindex="-1" role="dialog" aria-labelledby="showNumber" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showNumber"><?= __('Affichage numéro'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="showNumberBody">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= __("Supprimer la réservation") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>

            <div class="modal-body">
                <center><p><?= __("Voulez-vous supprimer cette reservation") ?></p></center>
                <div class="text-right">
                    <button type="button" class="btn btn-retour rounded-0 border" data-dismiss="modal" aria-label="Close"><?= __("Non") ?></button>
                    <button type="button" class="btn btn-blue rounded-0 text-white" onclick="delete_res()"><?= __("Oui") ?></button>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_justif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= __("Supprimer la réservation") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <center><p><?= __("Voulez-vous supprimer cette reservation") ?></p></center>
                <form id="formjustificatif" name="formjustificatif" method ="post" enctype="multipart/form-data">
                    <input type="hidden" name="idreservation" id="idreservation">
                    <input type="hidden" name="bdteservation" id="dbtreservation">
                    <input type="hidden" name="prixremboursement" id="prixremboursement">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="avecjustificatif" class="custom-control-input" name="justificatif" value="1">
                        <label class="custom-control-label" for="avecjustificatif"><?= __("Annulation avec justificatif") ?></label>
                    </div>
                    <div id="divJustification" class="m-3">
                        <p><strong><?= __("Expliquez-nous le motif de votre annulation") ?> : </strong></p>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="motif" value="maladie" id="motifmaladie"><label class="custom-control-label" for="motifmaladie"><?= __("Maladies ou blessures graves") ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="motif" value="deces" id="motifdeces"><label class="custom-control-label" for="motifdeces"><?= __("Décès d'un des locataires, proche ou parent") ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="motif" value="officielle" id="motifofficielle"><label class="custom-control-label" for="motifofficielle"><?= __("Obligations officielles") ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="motif" value="autre" id="motifautre"><label class="custom-control-label" for="motifautre"><?= __("Autres") ?></label>
                        </div>
                        <label id="motifobligatoire"><span class="error_formul"> <?= __("Ce champ est obligatoire") ?></span></label>
                        <!--file input example -->
                        <div class="mt-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="fileJustificatif" id="fileJustificatif" accept=".gif,.jpg,.jpeg,.png,.pdf">
                                <label for="fileJustificatif" class="custom-file-label" data-browse="Sélectionner"><?= __("Justificatif à uploader pdf/image") ?></label>
                                <label id="fileobligatoire"><span class="error_formul"> <?= __("Ce champ est obligatoire") ?></span></label>
                            </div>
                        </div>
                        <!--./file input example -->
                        <div class="form-group my-3">
                            <label for="comment"><?= __("Commentaire") ?>:</label>
                            <textarea class="form-control" rows="5" name="commentaire" id="commentaire"></textarea>
                            <label id="commentaireobligatoire"><span class="error_formul"> <?= __("Ce champ est obligatoire") ?></span></label>
                        </div>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sansjustificatif" class="custom-control-input" name="justificatif" value="0">
                        <label class="custom-control-label" for="sansjustificatif"><?= __("Annulation sans justificatif") ?></label>
                    </div>
                    <div id="divSansJustification" class="m-3">

                    </div>
                    <label id="justificatifobligatoire"><span class="error_formul"> <?= __("Ce champ est obligatoire") ?></span></label>
                    <input type="hidden" id="inputMailSansJustification" name="inputMailSansJustification"></input>
                    <input type="hidden" id="inputMontantProp" name="inputMontantProp" val=""></input>
                    <input type="hidden" id="inputSansJustification" name="inputSansJustification" />
                    <input type="hidden" id="idannulation" name="idannulation" />
                </form>

            </div>
            <div class="row justify-content-end">
                <div class="col-auto m-3">
                    <button type="button" class="btn btn-retour border rounded-0" data-dismiss="modal" aria-label="Close"><?= __("Non") ?></button>
                    <button type="button" class="btn btn-blue rounded-0 text-white" onclick="delete_res_justif()"><?= __("Oui") ?></button>
                </div></div>

        </div>
    </div>
</div>
<!-- popup_contact -->
<div class="modal fade" id="popup_contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" style="width:650px; max-width:700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5><?= __("Envoyer un message") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

            </div>
            <?php echo $this->Form->create(null,['url'=>['action'=>'prop'],'class'=>'form-horizontal propform','novalidate']); ?>

            <div class="modal-body">
                <div class="alert alert-danger d-none" role="alert" id="msgerrorphone">
                    <?= __("Votre message ne peut pas être envoyé car il viole les conditions générales de Alpissime.com.<br> Il est interdit de communiquer une adresse email ou un numéro de téléphone par la messagerie.") ?>
                </div>
                <div class="col-md-12 block">
                    <div class="form-group row">
                        <label class="col-sm-4 font-weight-bold"><?= __("Nom et prénom") ?> :</label>

                        <div class="col-sm-6">
                            <?php echo $this->Session->read('Auth.User.nom_famille')." ".$this->Session->read('Auth.User.prenom') ?>
                            <?php echo $this->Form->hidden('idUser', ['value' =>$this->Session->read('Auth.User.id')]); ?>
                            <?php echo $this->Form->hidden('name', ['value' =>$this->Session->read('Auth.User.nom_famille')]); ?>
                            <?php echo $this->Form->hidden('prenom', ['value' =>$this->Session->read('Auth.User.prenom')]); ?>
                            <?php echo $this->Form->hidden('tel', ['value' =>$this->Session->read('Auth.User.portable')]); ?>
                            <?php echo $this->Form->hidden('email', ['value' =>$this->Session->read('Auth.User.email')]); ?>
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="reservation_id" id="reservation_id">
                            <input type="hidden" name="dbt_msg" id="dbt_msg">
                            <input type="hidden" name="fin_msg" id="fin_msg">
                            <input type="hidden" name="nbCouchage_ad_msg" id="nbCouchage_ad_msg">
                            <input type="hidden" name="nbCouchage_enf_msg" id="nbCouchage_enf_msg">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 font-weight-bold"><?= __("Votre message") ?> :</label>
                        <div class="col-sm-8">
                            <?php echo $this->Form->input('message', ['label'=>false,'templates' => ['inputContainer' => "{{content}}"], 'class' => 'form-control', 'rows' => 3,'id'=>'elmt', 'required']); ?>
                            <input type="hidden" id="messagehiddensans" name="messagehiddensans" />
                        </div>
                        <span class="text-danger interditext" style="display:none;"><?= __("Votre message ne peut pas être envoyé car il viole les conditions générales de Alpissime.com.<br> Il est interdit de communiquer une adresse email ou un numéro de téléphone par la messagerie.") ?></span>
                    </div>

                    <div class="form-group row justify-content-end">
                        <!-- Captcha HTML Code-->
                        <?php
                        // echo $this->InvisibleReCaptcha->render();
                        ?>
                        <?= $this->Recaptcha->display() ?>
                        <div class="col-sm-8"><button type="submit" class="interdibtn btn btn-pink left w-100 rounded-0 text-white" value="Envoyer"><?= __("Envoyer") ?></button></div>
                    </div>
                </div>
            </div>

            <?php echo $this->Form->end(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End popup_contact -->

<div class="modal fade" id="plusdetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= __("Modifier la réservation") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <div id="reservation_list" class="col-md-12 gray_background block">

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->css("/manager-arr/components/validationEngine/validationEngine.jquery.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/manager-arr/components/validationEngine/jquery.validationEngine.js", array('block' => 'scriptBottom')); ?>
<?php //$this->Html->script("/manager-arr/components/validationEngine/jquery.validationEngine-en.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-".$language_header_name.".min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
"date-eu-pre": function ( date ) {
date = date.replace(" ", "");

if ( ! date ) {
return 0;
}

var year;
var eu_date = date.split(/[\.\-\/]/);

/*year (optional)*/
if ( eu_date[2] ) {
year = eu_date[2];
}
else {
year = 0;
}

/*month*/
var month = eu_date[1];
if ( month.length == 1 ) {
month = 0+month;
}

/*day*/
var day = eu_date[0];
if ( day.length == 1 ) {
day = 0+day;
}

return (year + month + day) * 1;
},

"date-eu-asc": function ( a, b ) {
return ((a < b) ? -1 : ((a > b) ? 1 : 0));
},

"date-eu-desc": function ( a, b ) {
return ((a < b) ? 1 : ((a > b) ? -1 : 0));
}
} );

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
'use strict';
window.addEventListener('load', function() {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.getElementsByClassName('propform');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
form.addEventListener('submit', function(event) {
if (form.checkValidity() === false) {
event.preventDefault();
event.stopPropagation();
}

var str = $('#elmt').val();
var messagesansmail = str.replace(/([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/, '');
$('#messagehiddensans').val(messagesansmail);
form.classList.add('was-validated');
}, false);
});
}, false);
})();



$(document).ready(function() {
$('#table_id_valid').DataTable({
language: {
"url": "<?php echo $datatable_file; ?>",
// search: "_INPUT_",
// searchPlaceholder: "Recherche"
},
'columns': [
{ 'data': 0 },
{ 'data': 1 },
{ 'data': 2 ,'type': 'date-eu'},
{ 'data': 3 },
{ 'data': 4 },
{ 'data': 5 },
{ 'data': 6 },
],
order: [2, 'desc'],
});
$("#divJustification").css("display", "none");
$("#divSansJustification").css("display", "none");

$("#motifobligatoire").css("display", "none");
$("#fileobligatoire").css("display", "none");
$("#commentaireobligatoire").css("display", "none");
$("#justificatifobligatoire").css("display", "none");

$('input[name="justificatif"]').click(function(){
//console.log($(this).val());
if($(this).val() == 0){
$("#divJustification").css("display", "none");
$("#divSansJustification").css("display", "block");
var fnDiff = moment($("#dbtreservation").val(), "DD-MM-YYYY");
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd < 10){
dd='0'+dd;
}
if(mm < 10)
{
mm='0'+mm;
}
today = dd+'-'+mm+'-'+yyyy;
var dbtDiff = moment(today, "DD-MM-YYYY");
var Diff = fnDiff.diff(dbtDiff, 'days');

$.ajax({
type: "POST",
dataType : 'json',
url: "<?php echo $this->Url->build('/',true)?>dispos/calculertotalprixperiodebyidreservation",
data: {id_reservation:$("#idreservation").val()},
success:function(xml){
nbrjour = 0;
$.each(xml.resultatDetail['nbrsejour'], function(index, value) {
nbrjour = nbrjour + value;
});
$("#blockdetailprix").css("display", "block");
var prixTotal = (xml.resultatDetail['total']).toFixed(2);

var taxeDeSejour = (xml.resultatDetail['prixtaxeapayer']).toFixed(2);

var fraisAlpissime = (xml.resultatDetail['total']/100 * 10.6);
var fraisStripe = (xml.resultatDetail['total']/100 * 1.4);
var fraisService = (fraisAlpissime + fraisStripe).toFixed(2);

var msgSansJustif = "";
var msgSansJustifp1 = "";
var msgSansJustifp2 = "";
var totalPrixPayer;
var tauxcommission = 3;
if(xml.tauxcommissionprop != 0) tauxcommission = xml.tauxcommissionprop;
$.each(xml.listeannulation, function(index, value) {
if((value.interval_1 == 0 && Diff <= value.interval_2) || (value.interval_2 == 100 && Diff >= value.interval_1) || (Diff >= value.interval_1 && Diff <= value.interval_2)){
totalPrixPayer = (((parseFloat(prixTotal)/100)*(100-value.reservation_pourc)) + (parseFloat(taxeDeSejour))).toFixed(2);
if(value.reservation_pourc == 100) msgSansJustifp1 = "<?php echo __('Aucun remboursement du montant de la location'); ?> ";
else msgSansJustifp1 = "<p><?php echo __('Remboursement de'); ?> "+(100-value.reservation_pourc)+"% <?php echo __('du montant de la location'); ?> ";
    // if(value.service_pourc == 0) msgSansJustifp2 = "et aucun remboursement pour les frais de service.";
    // else msgSansJustifp2 = "et de "+value.service_pourc+"% des frais de service.</p>";
msgSansJustifp2 = " <?php echo __('Remboursement à 100% de la taxe de séjour. Les frais de service ne sont pas remboursés.'); ?>";
msgSansJustif = msgSansJustifp1+msgSansJustifp2+"<p><?php echo __('Remboursement de'); ?> : "+totalPrixPayer+" €</p>";
montantProp = ((parseFloat(prixTotal)/100)*(value.reservation_pourc)).toFixed(2) - ((parseFloat(prixTotal)/100)*tauxcommission).toFixed(2);
$("#inputMontantProp").val(montantProp);
}
});

if(msgSansJustif == ""){
if(Diff > 30){
totalPrixPayer = (parseFloat(prixTotal) + parseFloat(taxeDeSejour)).toFixed(2);
msgSansJustif = "<p><?php echo __('Aucun remboursement pour les frais de service.'); ?></p><p><?php echo __('Remboursement de'); ?> : "+totalPrixPayer+" €</p>";
$("#inputMailSansJustification").val("annulationreservationlocMois");
montantProp = 0;
$("#inputMontantProp").val(montantProp);
}else if(Diff >= 7 && Diff <= 30){
totalPrixPayer = ((parseFloat(prixTotal)/2) + parseFloat(taxeDeSejour)).toFixed(2);
msgSansJustif = "<p><?php echo __('Remboursement de 50% du montant de la location.'); ?></p><p><?php echo __('Remboursement de'); ?> : "+totalPrixPayer+" €</p>";
$("#inputMailSansJustification").val("annulationreservationlocSemaineMois");
montantProp = ((parseFloat(prixTotal)/2) - ((parseFloat(prixTotal)/100)*tauxcommission)).toFixed(2);
$("#inputMontantProp").val(montantProp);
}else if(Diff < 7){
totalPrixPayer = taxeDeSejour;
msgSansJustif = "<p><?php echo __('Aucun remboursement du montant de la location et des frais de service.'); ?></p><p><?php echo __('Remboursement Total de la taxe de séjour'); ?> : "+totalPrixPayer+" €</p>";
$("#inputMailSansJustification").val("annulationreservationlocSemaine");
montantProp = (parseFloat(prixTotal) - ((parseFloat(prixTotal)/100)*tauxcommission)).toFixed(2);
$("#inputMontantProp").val(montantProp);
}
}

$("#divSansJustification").html(msgSansJustif);
$("#prixremboursement").val(totalPrixPayer);

}
});


}else{
$("#formjustificatif")[0].reset();
$(this).attr("checked", "checked");
$("#divJustification").css("display", "block");
$("#divSansJustification").html("");
$("#divSansJustification").css("display", "none");
}
});

$.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);

$("#dbt_at").datepicker({ dateFormat: "dd-mm-yy"});
$( "#dialog:ui-dialog" ).dialog( "destroy" );
$( "#dialog-res" ).dialog({
autoOpen: false,
modal: true,
width:350});
$( "#dialog-error" ).dialog({
autoOpen: false,
modal: true,
width:500,
buttons: {
"Annuler": function() {
$( this ).dialog( "close" );
},
"Valider":function(){
$( this ).dialog( "close" );
//alert($('#id_prop').val());
a_data="";
a_data+='vDate='+$('#dbt_at').val();
a_data+='&vID='+$('#hdid').val();
a_data+='&vUtil='+$('#utilisteur_id').val();
a_data+='&vEmail='+$('#email').val();
a_data+='&vTelephone='+$('#tel').val();

$('#listUtilisateur_processing').attr('style','visibility: visible;');
//a_data['vDrap']=new Array();
/*$('select[id^=nb_drap_]').each(function(){
//alert($(this).val());
if($(this).val()!=0){
a_data+='&vDrap_'+$(this).attr('data-key')+"="+$(this).val();
}
})*/
$.ajax({
type: "POST",
url: "<?php echo $this->Url->build('/',true)?>reservations/edit_reservation_locataire",
data: a_data,
success:function(xml){
//alert(xml);
$('#dialog-res').dialog('open');
oTable.fnDraw();
$('#listUtilisateur_processing').attr('style','visibility: hidden;');

}
});

}
}
});

$( "#dialog-delete" ).dialog({
autoOpen: false,
modal: true,
width:500,
buttons: {
"Non": function() {
$( this ).dialog( "close" );
},
"Oui":function(){
$( this ).dialog( "close" );

$('#listUtilisateur_processing').attr('style','visibility: visible;');
$.ajax({
type: "GET",
url: "<?php echo $this->Url->build('/',true)?>reservations/deletereservation/"+$('#hdreservation').val(),
success:function(xml){
oTable.fnDraw();
$('#listUtilisateur_processing').attr('style','visibility: hidden;');

}
});

}
}
});

});

function showNumber(idres){
$.ajax({
type: "POST",
dataType : 'json',
url: "<?php echo $this->Url->build('/',true)?>reservations/shownumber/",
data: {id : idres},
success:function(xml){
$('#showNumberBody').html("Portable : "+xml.num_utilisateur);
$('#showNumberModal').modal('show');
}
});
}

function sendmsg(idres){
$.ajax({
type: "POST",
dataType : 'json',
url: "<?php echo $this->Url->build('/',true)?>reservations/sendmessagefromreservation/",
data: {id : idres},
success:function(xml){
if (xml.id_message != 0) {
window.location.href = "<?php echo SITE_ALPISSIME . $urlLang . $urlvaluemulti['utilisateurs'] . '/' . $urlvaluemulti['mesmessages']; ?>?message_id=" + xml.id_message;
} else {
$('#id').val(xml.id);
$('#dbt_msg').val(xml.dbt_msg);
$('#reservation_id').val(idres);
$('#fin_msg').val(xml.fin_msg);
$('#nbCouchage_ad_msg').val(xml.nbCouchage_ad_msg);
$('#nbCouchage_enf_msg').val(xml.nbCouchage_enf_msg);
$('#msgerrorphone').removeClass('d-none');
$('#msgerrorphone').addClass('d-none');
$('#popup_contact').modal('show');
// Execute recaptcha
// grecaptcha.execute();
}
}
});
}

/*function validateForm(){
var msg="";
if(msg==""){
var str = $('#elmt').val();
var messagesansmail = str.replace(/([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/, '');
//messagesansmail = messagesansmail.replace(new RegExp(/([0-9]+[\- ]?[0-9]+)/, "g"), '');
$('#messagehiddensans').val(messagesansmail);
return true;
}else{
return false;
}

}*/

$('#elmt').on('keyup', function (event) {
var VAL = $(this).val();
var result = false;

var pattschaine = ["zéro", "zero", "z e r o", "zero.", "zéro.", "0six", "0sept", "z€ro", "z € r o", "pointcom", " om ", "il.c", "gma", "arobase", "(arobase)", "(at)", "(pointcom)", "(point)com", "yahoo", "gmail", "outlook", "hotmail", ". f r", ". b e", ". c h", "deux", "d e u x", "trois", "t r o i s", "quatre", "q u a t r e", "cinq", "c i n q", "six", "s i x", "sept", "s e p t", "huit", "h u i t", "neuf", "n e u f", "dix", "d i x", "vingt", "v i n g t", '@', ' tel', 'téléphone', 'telephone', 'portable', 'fixe', ' port.', 'adresse', '.com', '.fr', 'point com', 'point fr', '{at}', '{a}', 'mail', 'email', 'skype', '$kype', 'zero un', 'zero deux', 'zero trois', 'zero quatre', 'zero cinq', 'zero six', 'zero sept', 'zero huit', 'zero neuf', 'contacter au zero', 'contacter au 0', 'z e r o', 't e l', 'T-e-l', 'Z-e-ro', 'gmail', 'yahoo', 'hotmail', 'protonmail', 'outlook', 'orange', 'free', 'sfr', 'bouygues', 'icloud', 'gmx', 'caramail', 'tutanota', 'advalvas', 'aol', 'bluemail', 'bluewin', 'bbox', 'cyberposte', 'emailasso', 'fastmail', 'francite', 'hashmail', 'icqmail', 'iiiha', 'iname', 'juramail', 'katamail', 'laposte', 'libero', 'mailfence', 'mailplazza', 'mixmail', 'myway', 'No-log', 'openmailbox', 'peru', 'Safe-mail', 'tranquille.ch', 'vmail', 'vivalvi.net', 'webmail', 'webmails', 'yandex', 'zoho', '.com', '.fr', '.co.uk', '.ch', '.be', '.nl', '.at', '.es', '.cz', '.eu', '.de', '.gr', '.gal', '.it', '.li', '.lt', '.lu', '.pt', '.nl', '.se', '.eu', '.org', '.net', '.es', '.ee', '.fi', '(a)', '(at)', '[a]', '[at]', '+336', '+337', '06', '07', '+355', '+49', '+376', '+374', '+43', '+32', '+375', '+387', '+359', '+357', '+385', '+45', '+32', '+372', '+358', '+33', '+350', '+30', '+36', '+353', '+354', '+39', '+371', '+370', '+423', '+352', '+389', '+356', '+373', '+377', '+382', '+47', '+31', '+48', '+351', '+420', '+40', '+44', '+378', '+421', '+386', '+46', '+41', '+380', '+379']
pattschaine.forEach(function(pattchaine, index){
if (VAL.indexOf(pattchaine) != -1) {
result = true;
}
});

if (result) {
$(".interdibtn").attr("disabled","disabled");
$(".interditext").css("display", "block");
}else{
$(".interdibtn").removeAttr("disabled");
$(".interditext").css("display", "none");
}

});

function open_dialog(id_a){

$('#listUtilisateur_processing').attr('style','visibility: visible;');
$.ajax({
type: "POST",
url: "<?php echo $this->Url->build('/',true)?>reservations/get_reservation_locataire/",
data: {id : id_a},
success:function(xml){
$('#texte-error').html(xml);
$('#dialog-error').dialog('open');
$('#listUtilisateur_processing').attr('style','visibility: hidden;');
}
});
}
function open_dialog_delete(id){
$('#hdreservation').val(id);
$('#dialog-delete').dialog('open');
}
/*function open_dialog_delete(id_a){
//$('#filemakertxt').val(id_f);
$('#id_annonce').val(id_a);
$('#dialog-error').dialog('open');
}*/

function activate_relation(id){
$('#listUtilisateur_processing').attr('style','visibility: visible;');
$.ajax({
type: "POST",
url: "<?php echo $this->Url->build('/',true)?>reservations/reservations_locataire",
data: {id : id},
success:function(xml){
if(xml=="ok") $('#coeur_re_'+id).attr('src','<?php echo $this->Url->build('/',true)?>images/pass-icon.png');
else $('#coeur_re_'+id).attr('src','<?php echo $this->Url->build('/',true)?>images/fail-icon.png');
$('#listUtilisateur_processing').attr('style','visibility: hidden;');
}
});
}

function open_dialog_delete_justif(id, dbt){
$('#hdreservation').val(id);
$('#hdreservation_1').val(id);
$('#idreservation').val(id);
$('#dbtreservation').val(dbt);
$("#formjustificatif")[0].reset();
$('#delete_justif').modal('show');
}
function open_dialog_delete(id){
$('#hdreservation').val(id);
$('#hdreservation_1').val(id);
$('#delete').modal('show');
}

function delete_res_justif(){
var msg = "";
console.log();
if(!$("input[name='justificatif']:checked").val()){
$("#justificatifobligatoire").css("display", "block");
msg = "non";
}
if($('input:radio[name="justificatif"]:checked').val() == 1){
$("#justificatifobligatoire").css("display", "none");
if($('input[name="justificatif"]').val() == 1){
if(!$("input[name='motif']:checked").val()){
$("#motifobligatoire").css("display", "block");
msg = "non";
}else{
$("#motifobligatoire").css("display", "none");
}
if($('input[name="fileJustificatif"]').val() == ""){
$("#fileobligatoire").css("display", "block");
msg = "non";
}else{
$("#fileobligatoire").css("display", "none");
}
if($('#commentaire').val() == ""){
$("#commentaireobligatoire").css("display", "block");
msg = "non";
}else{
$("#commentaireobligatoire").css("display", "none");
}
}
}else{
$("#motifobligatoire").css("display", "none");
$("#fileobligatoire").css("display", "none");
$("#commentaireobligatoire").css("display", "none");
}


if(msg == ""){
var formData = new FormData($("#formjustificatif")[0]);

$.ajax({
async: false,
type: "POST",
processData: false,
contentType: false,
url: "<?php echo $this->Url->build('/',true)?>reservations/deletereservationlocatairejustif/"+$('#hdreservation').val(),
data: formData,
success:function(xml){
$("#formjustificatif")[0].reset();
$('#delete_justif').modal( "hide" );
location.reload();
}
});

}

}

function delete_res(){
$('#delete').modal( "hide" );

$.ajax({
async: false,
type: "POST",
url: "<?php echo $this->Url->build('/',true)?>reservations/deletereservationlocataire/"+$('#hdreservation').val(),
success:function(xml){

}
});

var nat = "<?php echo $this->Session->read('Auth.User.nature')?>";
if(nat == "CLT") {window.location.href = "<?php echo $this->Url->build('/',true)?>reservations/locataire_view";}
else{window.location.href = "<?php echo $this->Url->build('/',true)?>reservations/view";}

}


function open_dialog(id_a){
$('#reservation_list').html('<center><img src="<?php echo $this->Url->build('/',true)?>/images/loading.gif"/></center>');
$('#plusdetails').modal('show');
var validNum = "non";
$.ajax({
type: "POST",
url: "<?php echo $this->Url->build('/',true)?>reservations/get_reservation_locataire_old/",
data: {id : id_a},
success:function(xml){
$('#reservation_list').html(xml);

for (i = 1; i <= $("#nbrrestel").val(); i++) {
var telInput = $("#num_tel"+i),
errorMsg = $("#error-msg"+i);
telInput.intlTelInput({
utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
initialCountry: 'fr',
autoPlaceholder: true
});
var reset = function() {
telInput.removeClass("errorNumberTel");
errorMsg.addClass("hide");
};
// on keyup / change flag: reset
telInput.on("keyup change", reset);
setTimeout('var telInput = $("#num_tel"+i),	errorMsg = $("#error-msg"+i),	validMsg = $("#valid-msg"); if ($.trim(telInput.val())) {	if (telInput.intlTelInput("isValidNumber")) {		validMsg.removeClass("hide");		validNum = telInput.intlTelInput("getNumber");	} else {		validNum = "non";		telInput.addClass("errorNumberTel"); errorMsg.removeClass("hide");		errorMsg.addClass("errorNumberTel"); }}', 500);
}

var telInput = $("#tel"),
errorMsg = $("#error-msg"),
validMsg = $("#valid-msg");
telInput.intlTelInput({
utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
initialCountry: 'fr',
autoPlaceholder: true
});
//telInput.intlTelInput("setNumber", telInput.val());
var reset = function() {
telInput.removeClass("errorNumberTel");
errorMsg.addClass("hide");
validMsg.addClass("hide");
};


// on blur: validate
telInput.blur(function() {
reset();
if ($.trim(telInput.val())) {
if (telInput.intlTelInput("isValidNumber")) {
validMsg.removeClass("hide");
validNum = telInput.intlTelInput("getNumber");
//alert(telInput.intlTelInput("getNumber"));
} else {
validNum = "non";
telInput.addClass("errorNumberTel");
errorMsg.removeClass("hide");
errorMsg.addClass("errorNumberTel");
}
}
});

// on keyup / change flag: reset
telInput.on("keyup change", reset);

setTimeout('var telInput = $("#tel"),	errorMsg = $("#error-msg"),	validMsg = $("#valid-msg"); if ($.trim(telInput.val())) {	if (telInput.intlTelInput("isValidNumber")) {		validMsg.removeClass("hide");		validNum = telInput.intlTelInput("getNumber");	} else {		validNum = "non";		telInput.addClass("errorNumberTel"); errorMsg.removeClass("hide");		errorMsg.addClass("errorNumberTel"); }}', 500);

var telInputP = $("#portable"),
errorMsg2 = $("#error-msgl"),
validMsg2 = $("#valid-msg2");
telInputP.intlTelInput({
utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
initialCountry: 'fr',
autoPlaceholder: true
});
//telInput.intlTelInput("setNumber", telInput.val());
var reset = function() {
telInputP.removeClass("errorNumberTel");
errorMsg2.addClass("hide");
validMsg2.addClass("hide");
};


// on blur: validate
telInputP.blur(function() {
reset();
if ($.trim(telInputP.val())) {
if (telInputP.intlTelInput("isValidNumber")) {
validMsg2.removeClass("hide");
validNum2 = telInputP.intlTelInput("getNumber");
//alert(telInput.intlTelInput("getNumber"));
} else {
validNum2 = "non";
telInputP.addClass("errorNumberTel");
errorMsg2.removeClass("hide");
errorMsg2.addClass("errorNumberTel");
}
}
});

// on keyup / change flag: reset
telInputP.on("keyup change", reset);

setTimeout('var telInputP = $("#portable"),	errorMsg2 = $("#error-msgl"),	validMsg2 = $("#valid-msg2"); if ($.trim(telInputP.val())) {	if (telInputP.intlTelInput("isValidNumber")) {		validMsg2.removeClass("hide");		validNum2 = telInputP.intlTelInput("getNumber");	} else {		validNum2 = "non";		telInputP.addClass("errorNumberTel"); errorMsg2.removeClass("hide");		errorMsg2.addClass("errorNumberTel"); }}', 500);


}
});

}

<?php $this->Html->scriptEnd(); ?>
