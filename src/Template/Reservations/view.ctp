<?php $this->Html->css("/css/new/dataTables.bootstrap4.min.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/datepicker.fr.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>
<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/jquery.dataTables.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/js/new/dataTables.bootstrap4.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>

<style>
    td {
        vertical-align: middle !important;
    }
    td a {
        color: black;
    }
    .showSweetAlert[data-animation=pop] {
        -webkit-animation: showSweetAlert 0.7s;
        animation: showSweetAlert 0.7s;
    }
    .hideSweetAlert[data-animation=pop] {
        -webkit-animation: hideSweetAlert 1s;
        animation: hideSweetAlert 1s;
    }
    .sweet-alert button {
        padding: 5px 15px;
        margin-top: 0px;
        border-radius: 0px;
    }
</style>
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
form.classList.add('was-validated');
}, false);
});
}, false);
})();

$("#dbt_at").datepicker({ dateFormat: "dd-mm-yy"});

function aPlanPistes(id_reservation){
$.ajax({
type: "POST",
dataType : 'json',
async: false,
url: "<?php echo $this->Url->build('/',true)?>reservations/getdetailreservations/",
data: {reservID: id_reservation},
success:function(xml){
console.log(xml.detailReservation.inventaire_loc);
$("#object_inventaire").html('<object data="<?php echo SITE_ALPISSIME."inventaireslocataire/"; ?>'+xml.detailReservation.inventaire_loc+'" type="application/pdf" width="100%" height="500"><span class="text-center"> <?= __("Le lien est inaccessible pour le moment. Merci de réessayer plus tard.") ?> </span></object>')
if(xml.detailReservation.commentaire_inventaire != ""){
$("#divcommentaire").css('display', "block");
$("#com_invent").html(xml.detailReservation.commentaire_inventaire);
}else{
$("#divcommentaire").css('display', "none");
}
$("#planPistes").modal("show");
}
});
}

$(document).ready(function() {
$.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);

var table = $('#example').DataTable({
language:{
"url": "<?php echo $datatable_file; ?>"
},
//"bJQueryUI": true,
"iDisplayLength": 10,

'ajax': '<?php echo $this->Url->build('/',true)?>reservations/reservations_proprietaire',
/*'responsive': {
'details': {
'type': 'column',
'target': 0
}
},*/
'columnDefs': [
{
'data': null,
'defaultContent': '',
'className': 'control',
'orderable': false,
'targets': 0,

},
{
targets: 5,
className: 'text-center'
}
],
'columns': [
/*{ 'data': null },*/
{ 'data': 0 },
{ 'data': 1 },
{ 'data': 2 },
{ 'data': 3 ,'type': 'date-eu'},
{ 'data': 4 },
{ 'data': 5 },
{ 'data': 6 },
{ 'data': 7 },
{ 'data': 8 },
{ 'data': 9 }
],
order: [3, 'desc'],
'select': {
'style': 'multi',
'selector': 'td:not(.control)'
}
});

$( "#dialog:ui-dialog" ).dialog( "destroy" );
$( "#dialog-res" ).dialog({
autoOpen: false,
modal: true,
width:550});
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
a_data+='&vPortable='+$('#portable').val();
a_data+='&vAdult='+$('#nb_adult').val();
a_data+='&vChild='+$('#nb_child').val();
/*if($('#menage1').is(':checked'))
a_data+='&vMenage=1';
else
a_data+='&vMenage=0';*/
if($('#taxe_1').is(':checked'))
a_data+='&vTaxe=1';
else
a_data+='&vTaxe=0';
/*if($('#palanning_1').is(':checked'))
a_data+='&vArrive=1';
else
a_data+='&vArrive=0';*/
a_data+='&vComment='+$('#comment').val();
/*$('select[id^=nb_drap_]').each(function(){
//alert($(this).val());
if($(this).val()!=0){
a_data+='&vDrap_'+$(this).attr('data-key')+"="+$(this).val();
}
})*/
$('#listUtilisateur_processing').attr('style','visibility: visible;');

$.ajax({
type: "POST",
url: "<?php echo $this->Url->build('/',true)?>reservations/editReservationProprietaire",
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
type: "POST",
dataType : 'json',
async: false,
url: "<?php echo $this->Url->build('/',true)?>reservations/getdetailreservations/",
data: {reservID: $('#hdreservation').val()},
success:function(xml){
detailRes = xml.detailReservation;
console.log(detailRes);
detailProp = xml.detailProp;
console.log(detailProp);

/*$.ajax({
type: "GET",
url: "<?php //echo $this->Url->build('/',true)?>reservations/deletereservation/"+$('#hdreservation').val(),
success:function(xml){
oTable.fnDraw();
$('#listUtilisateur_processing').attr('style','visibility: hidden;');

}
});*/
}
});


}
}
});

});
function open_dialog(id_a){

$('#listUtilisateur_processing').attr('style','visibility: visible;');

$.ajax({
type: "POST",
url: "<?php echo $this->Url->build('/',true)?>reservations/getReservationProprietaire/",
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

function activate(id){
$('#listUtilisateur_processing').attr('style','visibility: visible;');
$.ajax({
type: "POST",
url: "<?php echo $this->Url->build('/',true)?>admin/utilisateurs/activer",
data: {id : id},
success:function(xml){
if(xml=="ok") $('#coeur_'+id).attr('src','<?php echo $this->Url->build('/',true)?>images/pass-icon.png');
else $('#coeur_'+id).attr('src','<?php echo $this->Url->build('/',true)?>images/fail-icon.png');
$('#listUtilisateur_processing').attr('style','visibility: hidden;');
}
});
}

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

function showNumber(idres){
$.ajax({
type: "POST",
dataType : 'json',
url: "<?php echo $this->Url->build('/',true)?>reservations/shownumber/",
data: {id : idres},
success:function(xml){
$('#showNumberBody').html("<?= __('Portable'); ?> : "+xml.num_utilisateur);
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
if(xml.redirect_url) {
window.location.href = xml.redirect_url;
} else {
$("#idUser").val(xml.utilisateur_id);
$('#id').val(xml.id);
$('#reservation_id').val(idres);
$('#dbt_msg').val(xml.dbt_msg);
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

function validateForm(){
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

}

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

<?php $this->Html->scriptEnd(); ?>
<!-- popup_contact -->
<div class="modal fade" id="popup_contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" style="width:650px; max-width:700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5><?= __("Envoyer un message") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

            </div>
            <?php echo $this->Form->create(null,['url'=>['action'=>'prop'],'class'=>'form-horizontal propform','onsubmit'=>'return validateForm()','novalidate']); ?>
            <?php //echo $this->Form->hidden('id', ['value' =>$annonce->id]); ?>

            <div class="modal-body">
                <div class="alert alert-danger d-none" role="alert" id="msgerrorphone">
                    <?= __("Votre message ne peut pas être envoyé car il viole les conditions générales de Alpissime.com.<br> Il est interdit de communiquer une adresse email ou un numéro de téléphone par la messagerie.") ?>
                </div>
                <div class="col-md-12 block">
                    <div class="form-group row">
                        <label class="col-sm-4 font-weight-bold"><?= __("Nom et prénom") ?> :</label>

                        <div class="col-sm-6">
                            <?php echo $this->Session->read('Auth.User.nom_famille')." ".$this->Session->read('Auth.User.prenom') ?>
                            <?php echo $this->Form->hidden('idUser', ['value' =>$this->Session->read('Auth.User.id'), 'id' => 'idUser']); ?>
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

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="reservation_en_cours" class="reservation_en_cours container">
    <div class="row justify-content-between mb-5">
        <div class="col espace-menu">
            <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs'];?>/edit/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Coordonnées") ?></a></h3>
            <?php if($this->Session->read('Auth.User.nature')!='CLT'){?>
                <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['listannonce'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Annonces") ?></a></h3>
                <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['infobancaire'];?>/<?php echo $this->Session->read('Auth.User.id')?>"><?= __("Paiements") ?></a></h3>
                <h3 class="border-bottom-menu-espace float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation"><?= __("Réservations") ?></a></h3>
            <?php }else{ ?>
                <h3 class="float-left mr-3 mr-lg-5"><a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_view']; ?>"><?= __("Réservations") ?></a></h3>
            <?php } ?>
            <h3 class="float-left"><a href="<?php echo $this->Url->build('/',true).$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>"><?= __("Messages") ?></a></h3>
        </div>
        <?php if($this->Session->read('Auth.User.nature')=='CLT'){?>
            <div class="col-auto align-self-end">
                <h3 class="text-blue"><?= __("Espace") ?> <?php if($this->Session->read('Auth.User.nature')=='CLT') echo "Locataire"; else echo "Propriétaire";?></h3>
            </div>
        <?php }?>
    </div>
    <div class="row">
        <div class="col-12 col-sm-4 col-md px-0">
            <a class="text-white btn-grey rounded-0 py-2 w-100 d-block text-decoration-none text-center" href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/validation"><?= __("Réservations en attente") ?></a>
        </div>
        <div class="col-12 col-sm-4 col-md px-0">
            <a class="text-white btn-blue rounded-0 py-2 w-100 d-block text-decoration-none text-center py-2" href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/view"><?= __("Réservations validées") ?></a>
        </div>
        <div class="col-12 col-sm-4 col-md px-0">
            <a class="text-white btn-grey rounded-0 py-2 w-100 d-block text-decoration-none text-center py-2" href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/reservationcalendar"><?= __("Réservations Synchronisées") ?></a>
        </div>
        <div class="col pr-0 pl-0 pl-md-2  text-center text-md-right mt-3 mt-md-0">
            <a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_addres'];?>"><span class="btn text-white bg-orange px-5 px-md-3 px-lg-5"><?= __("Créer une réservation") ?></span></a>
        </div>
    </div>

    <?php setlocale (LC_ALL, 'fr_FR.UTF8'); ?>
    <div class="row mt-5">
        <div class="table-responsive">

            <table id="example" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <!-- <th></th> -->
                    <th><?php echo __('Annonce');?></th>
                    <th><?php echo __('Station');?></th>
                    <th><?php echo __('Locataire');?></th>
                    <th><?php echo __('Période');?></th>
                    <th><?php echo __('Prix');?></th>
                    <th width="10%"><?php echo __('Inventaire rempli');?></th>
                    <th width="10%"><?php echo __('Facture commission');?></th>
                    <th><?php echo __('Contact');?></th>
                    <th><?php echo __('Statut');?></th>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<input type="hidden" id="hdreservation"/>
<div id="dialog-error" title="Fiche réservation">
    <div id="texte-error">
    </div>
</div>
<div style="display:none" id="dialog-res" title="Alpissime.com">
    <div id="texte-error1">
        <p>Vous avez modifié la fiche d'arrivée de votre futur locataire</p>
        <p>dès que vous aurez passé la reservation du stade option au stade reservation celle ci rejoindra le planning des arrivées de votre gestionnaire</p>
        <p>à bientôt sur alpissime.com</p>
    </div>
</div>


<!-- Modal Plan Pistes -->
<div class="modal fade" id="planPistes" tabindex="-1" role="dialog" aria-labelledby="planPistes">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header p-3">
                <span class="orange h1modal text-center"><h2 class="font-weight-bold"><?= __("Inventaire") ?></h2></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body p-1">
                <div class="row">
                    <div class="col-md-12 ml-3" id="divcommentaire">
                        <label for=""><u>Commentaire :</u> </label>
                        <p id="com_invent" class="mt-0"></p>
                    </div>
                    <div class="col-md-12" id="object_inventaire">

                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal Plan Pistes -->

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
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Fermer'); ?></button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo __('Annuler la réservation'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">

                <p class="msgannul"><?php echo $msgannul; ?></p>
                <p class="popupannul"><?php echo __('Souhaitez-vous annuler cette réservation ?'); ?></p>

                <div class="float-right"><button type="button" class="btn btn-retour" data-dismiss="modal" aria-label="Close"><?= __("Non") ?></button>
                    <button type="button" class="btn btn-blue text-white rounded-0" onclick="delete_res();"><?= __("Oui") ?></button></div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="plusdetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= __("Modifier la réservation") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <div id="reservation_list" class="col-md-12 gray_background block"></div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="popup_reser_creer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?= __("Vous allez créer une réservation") ?></p>
                <p><?= __("pour que cette réservation soit possible vous devez renseigner la période avant de passer celle ci sur le Statut réservé") ?></p>
                <p><?= __("si vous ne voyez pas votre semaine après avoir ouvert ce tableau") ?></p>
                <p><?= __("mettez la semaine sur libre, vous la retrouverez dans votre tableau création d'une réservation manuelle") ?></p>
                <p><?= __("une période est considérée \"réservé\" si elle est renseignée avec les coordonnées de votre locataire") ?></p>
                <a href="<?php echo $this->Url->build('/',true).$urlLang;?>reservations/<?php echo $urlvaluemulti['locataire_addres'];?>" class="btn btn-blue text-white rounded-0 float-right"><?= __("Valider") ?></a>
            </div>

        </div>
    </div>
</div>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
function open_dialog_delete(id, type, textannul, calendarsynchro_id){
if(type != 0) $(".msgannul").html("");
$('#hdreservation').val(id);
$('#hdreservation_1').val(id);
if(type == 0 && calendarsynchro_id == 0){
swal({
title: "<?php echo __("Annuler la réservation") ?>",
text: textannul.replaceAll("`", "'"),
type: "error",
showCancelButton: true,
confirmButtonColor: "#e6b034",
confirmButtonText: "<?php echo __("Confirmer l'annulation"); ?>",
cancelButtonText: "<?php echo __("Annuler"); ?>",
closeOnConfirm: true
}, function(){
delete_res();
});
}else{
swal({
title: "<?php echo __("Annuler la réservation") ?>",
text: "<?php echo __('Souhaitez-vous annuler cette réservation ?'); ?>",
type: "error",
showCancelButton: true,
confirmButtonColor: "#e6b034",
confirmButtonText: "<?php echo __("Confirmer l'annulation"); ?>",
cancelButtonText: "<?php echo __("Annuler"); ?>",
closeOnConfirm: true
}, function(){
delete_res();
});
}

}

function delete_res(){
$('#delete').modal( "hide" );
$.ajax({
type: "POST",
dataType : 'json',
async: false,
url: "<?php echo $this->Url->build('/',true)?>reservations/getdetailreservations/",
data: {reservID: $('#hdreservation').val()},
success:function(xml){

$.ajax({
async: false,
type: "POST",
url: "<?php echo $this->Url->build('/',true)?>reservations/deletereservation/"+$('#hdreservation').val(),
success:function(xml){
table.fnDraw();
}
});
}
});

//window.location.href = "<?php echo $this->Url->build('/',true)?>reservations/view";
}


function open_dialog(id_a){
var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
$('#reservation_list').html('<center><img src="<?php echo $this->Url->build('/',true)?>/images/loading.gif"/></center>');
$('#plusdetails').modal('show');
$.ajax({
type: "POST",
url: "<?php echo $this->Url->build('/',true)?>reservations/getReservationProprietaire/",
data: {id : id_a},
headers: {
'X-CSRF-Token': csrfToken
},
success:function(xml){
$('#reservation_list').html(xml)

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
function show_popup_creer_res(){
$('#popup_reser_creer').modal('show')
}

<?php $this->Html->scriptEnd(); ?>
