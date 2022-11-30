<form class="form-horizontal">
    <input type="hidden" id="reservid" value="<?php echo $reservid ?>">
    <div class="form-group">
        <label class="control-label text-left col-sm-6"><h6>Position Clé:</h6></label>
        <div class="col-sm-6">
                <input type="text" value="<?php if($clepos->position_cle != 0) echo $clepos->position_cle ?>" class="form-control" id="poscle">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label text-left col-sm-6"><h6>Nombre de clés remises :</h6></label>
        <div class="col-sm-6">
            <select id='p_cle' class="form-control">
             <?php for($i=0;$i<5;$i++):?>
             <option <?php if($i==$reservation->p_cle) echo "SELECTED"?> value="<?php echo $i?>"><?php echo $i ?></option>
             <?php endfor;?>
             </select>
        </div>
    </div>
    <?php if($new == ""&& $dernierelocataire['U']['email']!=""): ?>
        <div class="form-group">
            <label class="control-label text-left col-sm-6"><h6>Dernier Locataire Arrivé :</h6></label>
            <div class="col-sm-6 mt-10">
                <p class="txt-dark font-14"><?php echo $dernierelocataire['U']['prenom']." ".$dernierelocataire['U']['nom_famille'] ?></p>
                <p class="txt-dark font-14"><?php echo $dernierelocataire['U']['email'] ?></p>
                <p class="txt-dark font-14"><?php echo $dernierelocataire['U']['portable'] ?></p>
                <p class="txt-dark font-14">Arrivée le <?php echo $dernierelocataire->dbt_at ?></p>
                <p class="txt-dark font-14">Départ le <?php echo $dernierelocataire->fin_at ?></p>
                <p class="txt-dark font-14">Nombre de Clés remises : <?php echo $dernierelocataire->p_cle ?></p>
            </div>
        </div>
    <?php endif; ?>
</form>