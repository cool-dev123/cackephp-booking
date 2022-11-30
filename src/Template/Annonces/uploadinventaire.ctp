
<style>
html{
	overflow-x: visible;
}
.has-error{
    border-color: #a94442;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
}
.classwidth {
    width: 60px;
    margin: 0px 10px 0px 10px;
}
.dateexpire{
    display: flex;
}
.mt-30 {
    margin-top: 30px;
}
</style>
<?php echo $this->Flash->render() ?>

<div id="espace_locataire">
    <div class="row">
        <?php if($this->Session->read('Auth.User.nature')=='CLT') echo $this->element("menu_locataire");
            else echo $this->element("menu_proprietaire"); ?>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <h1><?= __("Espace") ?> <?php if($this->Session->read('Auth.User.nature')=='CLT') echo "Locataire"; else echo "Propriétaire";?> - <span class="orange">Upload Inventaire</span><h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="header_title">
                        <h4 class="gray-fonce"><i class="fa fa-user fa-lg"></i>&nbsp; Upload Inventaire</h4>
                    </div>
                </div>
            </div>
            <?php echo $this->Form->create($inventaire,['id'=>'uploadinventaire', 'enctype'=>"multipart/form-data"],['url' => ['controller' => 'Annonces', 'action' => 'uploadinventaire']]);?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Upload fichier PDF/Image</label>
                            <input type="file" id="uploadfile" name="uploadfile" accept=".gif,.jpg,.jpeg,.png,.pdf" />
                        </div>                                
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 viewfile">
                      <?php if($annonce_inventaire) { ?>
                        <object data="<?php echo $this->Url->build('/',true)?>inventaires/<?php echo $annonce_inventaire ?>" type="application/pdf" width="100%" height="500"> <?= __("Lien Pièce jointe") ?></object>
                      <?php } ?>                             
                    </div>
                </div>
                

                <div class="row mt-30">
                    <div class="col-md-12">
                        <div class="pull-right block">
                            <button type="submit" class="btn btn-success hvr-sweep-to-top"> Valider </button>
                        </div>
                    </div>
                </div>
            <?php echo $this->Form->end();?>

        </div>
        <div class="col-md-12">
                <hr class="dashed block">
        </div>

    </div>
</div>
      

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
jQuery(document).ready(function() {
	$(".menu_annon").css('display','block');

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
	    }   
	});
});
<?php $this->Html->scriptEnd(); ?>
