<form>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10 font-16">Nom de famille:</label>
        <input type="text" class="form-control" id="nom_famille" value="<?php echo $user->nom_famille ?>">
        <input type="hidden" id="utilisateur_id"  value="<?php echo $user->id ?>">
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10 font-16">Prenom:</label>
        <input type="text" class="form-control" id="prenom" value="<?php echo $user->prenom  ?>">
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10 font-16">E-mail:</label>
        <input type="text" class="form-control" id="email" value="<?php echo $user->email  ?>">
    </div>
    <div class="form-group">
        <label for="recipient-name" class="control-label mb-10 font-16">Portable:</label>
        <input type="text" class="form-control" id="portable" value="<?php echo $user->portable  ?>">
        <span id="error-msg" class="hide" style="margin-left: 23%;">Numéro invalide</span>
    </div>
</form>

<script>
    var telInputport = $("#portable"),
          errorMsgport = $("#error-msg");
          telInputport.intlTelInput({
                        utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
                        initialCountry: 'fr',
                        autoPlaceholder: true
                      });
                      var reset = function() {
                        telInputport.removeClass("errorNumberTel");
                        errorMsgport.addClass("hide");
                      };
        // on keyup / change flag: reset
        telInputport.on("keyup change", reset);
</script>