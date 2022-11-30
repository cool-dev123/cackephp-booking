
<div class="container">
    <?php echo $this->Form->create(null,['id'=>'InventaireLocForm','enctype'=>"multipart/form-data",'class'=>'InventaireLocForm','novalidate']);?>
    <?php echo $this->Flash->render() ?>
    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
    <div>
        <label for=""><?= __("Télécharger une version de votre inventaire") ?></label>
    </div>
    <!-- <div> -->
    <div class="input-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="uploadfile" name="uploadfile" accept=".pdf" aria-describedby="uploadfile" required>
            <label class="custom-file-label" id="uploadfilelabel" for="uploadfile"><?= __("Choisir fichier") ?></label>
        </div>
    </div>
    <div class="form-group mt-3">
        <label for="description"><?= __('Commentaire') ?> *</label>
        <textarea name="commentaire_inventaire" rows="5" cols="75" class="form-control" placeholder='<?= __("Votre Commentaire") ?>' id="commentaire_inventaire" required></textarea> 
        <div class="invalid-feedback"><?= __("Champs obligatoires") ?></div>
    </div>

    <!-- </div> -->
    <div class="row mt-4 justify-content-end">
        <div class="col-auto">
          <button type="submit" class="btn btn-blue text-white rounded-0 px-6" value="Enregistrer"><?= __("Enregistrer") ?></button>                              
        </div>
    </div>
    <?php echo $this->Form->end();?>
</div>


<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
jQuery(document).ready(function() {
  var fileTypes = ['jpg', 'jpeg', 'png', 'pdf'];  //acceptable file types
	$("input:file").change(function (evt) {
	    var parentEl = $(this).parent();
	    var tgt = evt.target || window.event.srcElement,
	                    files = tgt.files;

	    // FileReader support
	    if (FileReader && files && files.length) {
	        var fr = new FileReader();
	        var extension = files[0].name.split('.').pop().toLowerCase(); 
	        fr.onload = function (e) {
	        	success = fileTypes.indexOf(extension) > -1;
	        	if(success)
		        	// $(parentEl).append('<img src="' + fr.result + '" class="preview"/>');
              $(".viewfile").html('<object data="'+fr.result+'" type="application/pdf" width="100%" height="500"> <?= __("Lien Pièce jointe") ?></object>');
	        }
	        fr.onloadend = function(e){
	            console.debug("Load End");
	        }
          fr.readAsDataURL(files[0]);
          $("#uploadfilelabel").html(files[0].name);
	    }   
	});

});

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('InventaireLocForm');
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