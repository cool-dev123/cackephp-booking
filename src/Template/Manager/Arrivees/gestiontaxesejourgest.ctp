<form id="frm_gestiontaxesejour" class="form-horizontal">
    <input type="hidden" id="reservid" value="<?php echo $reservid ?>">
    <div class="form-group">
            <label class="col-sm-4 control-label font-16">Taxe payé :</label>
            <div class="col-sm-7">
                <select id='taxe_paye' class="form-control">
                    <option <?php if($reservation->taxe_paye == 1) echo "SELECTED"?> value="1">Oui</option>
                    <option <?php if($reservation->taxe_paye == 0) echo "SELECTED"?> value="0">Non</option>
                </select>
            </div>
    </div>
    <div class="form-group">
            <label class="col-sm-4 control-label font-16">Méthode payement :</label>
            <div class="col-sm-7">
                <select name="methode_paye" id='methode_paye' class="form-control">
                    <option <?php if($reservation->methode_paye == 0) echo "SELECTED"?> value="0">----</option>
                    <option <?php if($reservation->methode_paye == 1) echo "SELECTED"?> value="1">Espèce</option>
                    <option <?php if($reservation->methode_paye == 2) echo "SELECTED"?> value="2">Chèque</option>
                    <option <?php if($reservation->methode_paye == 3) echo "SELECTED"?> value="3">Carte Bancaire</option>
                </select>
            </div>
    </div>
</form>

<script>
    $.validator.addMethod("costumrule",
            function(value, element) {
                if($('#taxe_paye').val()=="1" && value=="0")
                    return false;
                else
                    return true;
            },
            "Choisir une méthode de paiement."
        );
    
    form = $("#frm_gestiontaxesejour").validate({
            rules: {
                    methode_paye: {
                        costumrule:true
                    }      
            },
            lang: 'fr',
        });
</script>