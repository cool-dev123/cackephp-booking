<style>
    #ajoutel .intl-tel-input, #blocajouttel1 .intl-tel-input {
        width: 90%;
        /* vertical-align: middle; */
    }
    .intl-tel-input{
        width: 90%;
    }
    #dbt_at {
        background: white;
    }
</style>

<?php setlocale (LC_ALL, 'fr_FR.UTF8'); ?>
<?php echo $this->Form->create(null,["url"=>["controller"=>"reservations","action"=>"edit_reservation_locataire"],'onsubmit'=>'return test()'])?>

<table class="table table-bordered" cellpadding="0" cellspacing="0" border="0"  class="d-info">
    <tr>
        <th class="border-bottom-0"><?= __("Date d'arrivée") ?></th>
        <td class="border-bottom-0">
            <input type="hidden" name="hdid" id="hdid" value="<?php echo $reservation->id?>" />
            <input type="hidden" name="utilisteur_id" id="utilisteur_id" value="<?php echo $reservation->utilisateur_id?>" />
            <input type="text" class="form-control calendrier" readonly='readonly' id="dbt_at" name="dbt_at" value="<?php echo $reservation->dbt_at->i18nFormat('dd-MM-yyyy') ?>"/>
            <input type="hidden" id="nbrrestel" name="nbrrestel" value="<?php echo $nbrrestel?>" />
            <input type="hidden" id="nbrrestelajout" name="nbrrestelajout" value="<?php echo $nbrrestel?>" />

        </td>
    </tr>
    <tr>
        <th class="border-top-0"><?= __("Date de départ") ?></th>
        <td class="border-top-0">
            <input type="text" class="form-control" readonly='readonly' id="dt_d" name="dt_d" value="<?php echo $reservation->fin_at->i18nFormat('dd-MM-yyyy')?>"/>
        </td>
    </tr>
    <tr>
        <th class="border-bottom-0"> <?= __("Nombre d'adultes (à partir de 18 ans)") ?></th>
        <td class="border-bottom-0"><span id="nb_adult"><?php echo $reservation->nb_adultes?></span></td>
    </tr>
    <tr>
        <th class="border-top-0"> <?= __("Nombre d'enfants de 0 à 18 ans") ?></th>
        <td class="border-top-0"><span id="nb_enf"><?php echo $reservation->nb_enfants?></span></td>
    </tr>
    <?php if($annonceContrat == 1){ ?>
        <tr>
            <th class="last"><?= __("Taxe de séjour gérée par alpissime") ?></th>
            <td class="last">
                <span id="taxe"><?php echo $reservation->taxe==0?__("Non"):__("Oui")?></span>
            </td>
        </tr>
    <?php } ?>

    <?php
    $date1 = new DateTime();
    $date2 = new DateTime($reservation->dbt_at->i18nFormat('dd-MM-yyyy'));
    $date3 = new DateTime($reservation->fin_at->i18nFormat('dd-MM-yyyy'));

    if($reservation->type != 0){ ?>
        <tr>
            <th><?= __("E-mail") ?></th>
            <td><input class="form-control" type="text" id="email" name="email" value="<?php echo $utilisateur->email?>"/></td>
        </tr>
        <tr>
            <th><?= __("Numéro de portable") ?></th>
            <td>
                <input class="form-control" type="text" id="portable" name="portable" value="<?php echo $utilisateur->portable?>" style="width:100%"/>
                <p id="error-msgl" class="hide"><?= __("Numéro invalide") ?></p>
            </td>
        </tr>
    <?php }else if($reservation->statut == 90 && $date1 < $date3){ ?>
        <tr>
            <th><?= __("Numéro de portable (propriétaire)") ?></th>
            <td>
                <input class="form-control" type="text" id="portable" name="portable" readonly='readonly' value="<?php echo $proprietaire->portable?>" style="width:100%"/>
                <?php //echo $proprietaire->portable?>
            </td>
        </tr>
    <?php } ?>
    <!-- <tr>
		<th>E-mail</th>
		<td><input class="form-control" type="text" id="email" name="email" value="<?php //echo $utilisateur->email?>"/></td>
	</tr> -->
    <!-- <tr>
		<th>Numéro de téléphone</th>
		<td><input class="form-control" type="text" id="tel" name="tel" value="<?php //echo $utilisateur->telephone?>" style="width:100%"/>
    <p id="error-msg" class="hide"><?= __("Numéro invalide") ?></p></td>
	</tr> -->
    <!-- <tr>
		<th>Numéro de portable</th>
		<td>
      <input class="form-control" type="text" id="portable" name="portable" value="<?php //echo $utilisateur->portable?>" style="width:100%"/>
      <p id="error-msgl" class="hide"><?= __("Numéro invalide") ?></p>
      </td>
	</tr> -->
    <tr>
        <th valign="top" class="last"><?= __("Commentaire") ?><br><small><?= __("Indiquer ici les commentaires relatifs à la <br>réservation. Si vous souhaitez modifier la date<br> d'arrivée ou de départ, utilisez les calendriers<br> ci-dessus.") ?></small></th>
        <td class="last" style="padding-top:5px;">
            <textarea class="form-control" name="commentlocataire" id="commentlocataire" rows=2 cols=3><?php echo html_entity_decode($reservation->commentlocataire)?></textarea>
        </td>
    </tr>
    <tr><th></th>

        <td><button type="submit" class="btn btn-blue text-white rounded-0"><?= __("Sauvegarder") ?></button></td>
    </tr>
</table>
<?php if($reservation->type != 0){ ?>
    <p><?= __("Merci de vérifier vos coordonnées (adresse email et numéro de téléphone) afin de nous permettre de vous accueillir au mieux lors de votre arrivée.") ?></p>
<?php } ?>

<?php echo $this->Form->end();?>
<script type="text/javascript" src="<?php echo $this->Url->build('/',true)?>js/datepicker.fr.js"></script>
<script type="text/javascript">
    var itel = <?php echo $itel; ?>;
    function deleteResTel(id, numtel){
        var r = confirm("Vous voulez supprimer ce numéro ?");
        if(r){
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: "<?php echo $this->Url->build('/',true)?>reservations/supprimertel/",
                data: {idtel:id},
                success:function(xml){
                    document.getElementById("blocajouttel"+numtel).style.display = 'none';
                }
            });
        }

    }

    function ajoutertel(){

        $('#ajoutel').append("<div id='blocajouttel"+itel+"'><input type='text' name='telephoneNum"+itel+"' id='num_tel"+itel+"' class='form-control' autocomplete='off' style='width:95%'><a id='sup"+itel+"' title='<?= __("Supprimer")?>' style='cursor:pointer' onclick='deleteTelNou("+itel+")' src='<?php echo $this->Url->build('/',true) ?>images/delete.png'><i class='fa fa-times fa-lg'></i></a><p id='error-msg"+itel+"' class='hide'><?= __("Numéro invalide") ?></p><br><br></div>");
        var telInput = $("#num_tel"+itel),
            errorMsg = $("#error-msg"+itel);
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
        itel = itel+1;
    }

    function deleteTelNou(numtel){
        document.getElementById("blocajouttel"+numtel).style.display = 'none';
    }
</script>
<script type="text/javascript">
    function test(){
        var test = '';
        if ($.trim(telInput.val())) {
            if (telInput.intlTelInput("isValidNumber")) {
                validMsg.removeClass("hide");
                validNum = telInput.intlTelInput("getNumber");
                $("#tel").val(validNum);
            } else {
                validNum = "non";
                telInput.addClass("errorNumberTel");
                errorMsg.removeClass("hide");
                errorMsg.addClass("errorNumberTel");
            }
        }

        if ($.trim(telInputP.val())) {
            if (telInputP.intlTelInput("isValidNumber")) {
                validMsg2.removeClass("hide");
                validNum2 = telInputP.intlTelInput("getNumber");
                $("#portable").val(validNum2);
            } else {
                test = "non";
                validNum2 = "non";
                telInputP.addClass("errorNumberTel");
                errorMsg2.removeClass("hide");
                errorMsg2.addClass("errorNumberTel");
            }
        }

        for(i = 1; i < itel; i++){
            var telInputres = $("#num_tel"+i);
            var errorMsgg = $("#error-msg"+i);

            if ($.trim(telInputres.val())) {
                if (telInputres.intlTelInput("isValidNumber")) {
                    validNum = telInputres.intlTelInput("getNumber");
                    $("#num_tel"+i).val(validNum);
                } else {
                    test = "non";
                    validNum = "non";
                    telInputres.addClass("errorNumberTel");
                    errorMsgg.removeClass("hide");
                    errorMsgg.addClass("errorNumberTel");
                }
            }
        }

        if(test != '')
        {
            return false;
        }
        else {
            $("#nbrrestelajout").val(itel);
            return true;
        }

    }
    function getMaxDate() {
        var t1 = '<?php echo $reservation->fin_at->i18nFormat('dd-MM-yyyy')?>';
        var t2 = '<?php echo $reservation->dbt_at->i18nFormat('dd-MM-yyyy') ?>';



        var str1= t1.split('-');
        var str2= t2.split('-');

        //                yyyy   , mm       , dd
        var t1 = new Date(str1[2], str1[1]-1, str1[0]);
        var t2 = new Date(str2[2], str2[1]-1, str2[0]);


        var diffMS = t1 - t2;
        var diffS = diffMS / 1000;
        var diffM = diffS / 60;
        var diffH = diffM / 60;
        var diffD = diffH / 24;


        var maxDate;
        if(diffD < 15){
            var myNewDate = new Date(t1);
            myNewDate.setDate(myNewDate.getDate() - 1);
            myNewDate =  myNewDate.getDate() + '-' + (myNewDate.getMonth() + 1) + '-' +  myNewDate.getFullYear();
            maxDate = myNewDate;
        }else{
            var myNewDate = new Date(t2);
            myNewDate.setDate(myNewDate.getDate() + 13);
            myNewDate =  myNewDate.getDate() + '-' + (myNewDate.getMonth() + 1) + '-' +  myNewDate.getFullYear();
            maxDate = myNewDate;


        }


        return maxDate;
    }

    function getMinDate() {
        var minDate = '<?php echo $reservation->dbt_at->i18nFormat('dd-MM-yyyy') ?>';

        return minDate;
    }



    $(document).ready(function() {
        $.datepicker.setDefaults($.datepicker.regional['<?php echo $language_header_name; ?>']);

        $("#dbt_at").datepicker({
            dateFormat: "dd-mm-yy",
            minDate: getMinDate(),
            maxDate: getMaxDate()

        });
    });
</script>
