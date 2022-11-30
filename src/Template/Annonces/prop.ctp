<?php echo $this->Html->css("style2")?>
<script>
$(document).ready(function(){
	$('#refresh-captcha').click(function(){
		//alert("<?php echo $this->Url->build('/',true)?>utilisateurs/captcha/?rnd=" + Math.random());
		$('#img_captcha').attr('src',"<?php echo $this->Url->build('/',true)?>utilisateurs/captcha/" + Math.random());
	})


 });

function validateForm(){


    var nameReg = /^[A-Za-z]+$/;
    var numberReg =  /^[0-9]+$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    var names = $('#name').val();
    var company = $('#prenom').val();
    var email = $('#email').val();
    var telephone = $('#tel').val();
    var demande = $('#demande').val();
	var message = $('#elmt').val();
	var capt = $('#captcha-code').val();
	//alert(demande);
    var inputVal = new Array(names, company, email, telephone, message,demande,capt);

    var inputMessage = new Array("nom", "prénom", "email", "téléphone", "message","demande","captcha");
    var msg="";
     $('.error').hide();

        if(inputVal[0] == ""){
            $('#nameLabel').after('<span class="error"> S\'il vous plaît, entrez votre ' + inputMessage[0] + '</span>');
			msg+="nom";
        }
        if(inputVal[1] == ""){
            $('#companyLabel').after('<span class="error"> S\'il vous plaît, entrez votre ' + inputMessage[1] + '</span>');
			msg+="prenom";
        }
        if(inputVal[2] == ""){
            $('#emailLabel').after('<span class="error"> S\'il vous plaît, entrez votre ' + inputMessage[2] + '</span>');
			msg+="mail";
        }
        else if(!emailReg.test(email)){
            $('#emailLabel').after('<span class="error"> S\'il vous plaît entrer une adresse email valide</span>');
			msg+="mail";
        }

        if(inputVal[3] == ""){
            $('#telephoneLabel').after('<span class="error"> S\'il vous plaît, entrez votre ' + inputMessage[3] + '</span>');
			msg+="mail";
        }
        else if(!numberReg.test(telephone)){
            $('#telephoneLabel').after('<span class="error"> chiffres seulement</span>');
			msg+="mail";
        }

        if(inputVal[4] == ""){
            $('#messageLabel').after('<span class="error"> S\'il vous plaît, entrez votre ' + inputMessage[4] + '</span>');
			msg+="mail";
        }
		if(inputVal[5] == 0){
            $('#demandeLabel').after('<span class="error"> S\'il vous plaît, entrez votre ' + inputMessage[5] + '</span>');
			msg+="mail";
        }
		if(inputVal[6] == 0){
		$('#captLabel').after('<span class="error"> S\'il vous plaît, entrez votre ' + inputMessage[6] + '</span>');
		msg+="mail";
		}
//alert(msg);
		if(msg=="")return true;
		else return false;
}


</script>
<style> .error{color:#FF0000}</style>
<div class="cadrecontact" style='height:400px'>
     <?php echo $this->Session->flash()?>


<?php echo $this->Form->create(null,['url'=>['action'=>'prop'],'onsubmit'=>'return validateForm()']); ?>
<table style="border:none;width:100%">
	<tr>
		<td colspan='2'>
			<div class="loc_bondeau_top" style='width:101%;'>
				<div class="bondeau_top"></div>
				<div class="bondeau_content">
					Merci pour votre interet.Laissez nous un message
				</div>
				<div class="bondeau_footer"></div>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan='2' style='height:50px'><?php echo $this->Form->hidden('id', ['value' =>$id_prop]); ?></td>
	</tr>
    <tr>
        <th style='text-align:left;padding-left:10px;height:30px;width:30%;'><?= __("Nom") ?></th>
        <td>
			<?php echo $this->Form->input('name', ['label' => '','templates' => ['inputContainer' => "{{content}}"], 'maxlength' => 100, 'size' => 40]); ?>
			<label id='nameLabel'></label>
		</td>
    </tr>
	<tr>
        <th style='text-align:left;padding-left:10px;height:30px;width:30%;'><?= __("Prénom") ?></th>
        <td>
			<?php echo $this->Form->input('prenom', ['label' => '','templates' => ['inputContainer' => "{{content}}"], 'maxlength' => 100, 'size' => 40]); ?>
			<label id='companyLabel'></label>
		</td>
    </tr>
	<tr>
        <th style='text-align:left;padding-left:10px;height:30px;width:30%;'>Téléphone</th>
        <td>
			<?php echo $this->Form->input('tel', ['label' => '','templates' => ['inputContainer' => "{{content}}"], 'maxlength' => 100, 'size' => 40]); ?>
			<label id='telephoneLabel'></label>
		</td>
    </tr>
    <tr>
        <th style='text-align:left;padding-left:10px;height:30px;width:30%;'>E-Mail</th>
        <td>
			<?php echo $this->Form->input('email', ['label' => '','templates' => ['inputContainer' => "{{content}}"], 'maxlength' => 100, 'size' => 40]); ?>
			<label id='emailLabel'></label>
		</td>
    </tr>
	<tr>
        <th style='text-align:left;padding-left:10px;height:30px;width:30%;'>Demande</th>
        <td>
			<?php echo $this->Form->input('demande', ['label' => '','templates' => ['inputContainer' => "{{content}}"],'type'=>'select','options'=>["----","Location"=>"Location","Appartement près de votre"=>"Appartement près de votre","Information diverses"=>"Information diverses"]]); ?>
			<label id='demandeLabel'></label>
		</td>
    </tr>
    <tr>
        <th style="text-align:left;padding-left:10px;height:50px;width:30%;vertical-align: top;"><?= __("Votre Commentaire") ?></th>
        <td>
			<?php echo $this->Form->input('message', ['label' => '','templates' => ['inputContainer' => "{{content}}"], 'cols' => 50, 'rows' => 10,'id'=>'elmt']); ?>
			<label id='messageLabel'></label>
		</td>
    </tr>

	<tr>
		<td></td>
		<td>
			<div id="captcha-wrap-5" style="width:90%">
				<img style="cursor: pointer;" src="<?php echo $this->Url->build('/',true)?>img/refresh.jpg" alt="refresh captcha" id="refresh-captcha" /> <img src="<?php echo $this->Url->build('/',true)?>utilisateurs/captcha/" alt="" id="img_captcha" />
			</div>
			<?php echo $this->Form->input("captcha",["type"=>"text",'label' => '','templates' => ['inputContainer' => "{{content}}"],'id'=>"captcha-code"])?>
			<label id='captLabel'></label>
		</td>
	</tr>
    <tr>
        <td colspan="2" align="center"><br>
		<input type="submit" value="Envoyer"/>
		</td>
    </tr>

</table>
<?php echo $this->Form->end(); ?>
</div>
