<div class="row">
    <label class="control-label text-left col-sm-4"><h6>Prénom:</h6></label>
    <div class="col-sm-6">
        <p class="txt-dark font-16"><?php echo $user->prenom?></p>
        <br>
    </div>
</div>

<div class="row">
    <label class="control-label text-left col-sm-4"><h6>Nom de famille:</h6></label>
    <div class="col-sm-6">
        <p class="txt-dark font-16"><?php echo $user->nom_famille?></p>
        <br>
    </div>
</div>

<div class="row">
    <label class="control-label text-left col-sm-4"><h6>Téléphone:</h6></label>
    <div class="col-sm-6">
        <p class="txt-dark font-16"><?= $user->telephone==""?"pas de numéro":$user->telephone ?></p>
        <br>
    </div>
</div>

<div class="row">
    <label class="control-label text-left col-sm-4"><h6>Portable:</h6></label>
    <div class="col-sm-6">
        <p class="txt-dark font-16"><?php echo $user->portable?></p>
        <br>
    </div>
</div>

<div class="row">
    <label class="control-label text-left col-sm-4"><h6>Email:</h6></label>
    <div class="col-sm-6">
        <p class="txt-dark font-16"><?php echo $user->email?></p>
        <br>
    </div>
</div>

<div class="row">
    <label class="control-label text-left col-sm-4"><h6>Code postal:</h6></label>
    <div class="col-sm-6">
        <p class="txt-dark font-16"><?php echo $user->code_postal?></p>
        <br>
    </div>
</div>

<div class="row">
    <label class="control-label text-left col-sm-4"><h6>Ville:</h6></label>
    <div class="col-sm-6">
        <p class="txt-dark font-16"><?= $paysname?$paysname:"non précisé" ?></p>
        <br>
    </div>
</div>

<div class="row">
    <label class="control-label text-left col-sm-4"><h6>Pays:</h6></label>
    <div class="col-sm-6">
        <p class="txt-dark font-16"><?= $user['P']['fr']?$user['P']['fr']:"non précisé" ?></p>
        <br>
    </div>
</div>