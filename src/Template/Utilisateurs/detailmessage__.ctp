<style>
	#table_id_valid th{
		text-align: left;
    }
    
    .inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%;
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  /* width: 6%; */
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 70%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin-bottom:26px}
.received_msg{ overflow:hidden; margin-bottom:26px}

.incoming_msg{ overflow:hidden;}
.sent_msg {
  float: right;
  width: 60%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  max-height: 516px; 
  overflow-y: auto;
}
</style>

<?php 
$modalError = $_GET['error'];
if ($modalError == 1 && $this->Session->read('Auth.User.nature') != '') {
  echo "<script type='text/javascript'>
  setTimeout(function() {
    $('#msgerrorphone').removeClass('d-none');
  }, 1000);
  </script>";
}
?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>

<?php $this->Html->scriptEnd(); ?>
<?php echo $this->Flash->render() ?>

<?php if($language_header_name != "fr") $urlLang = $language_header_name."/"; else $urlLang = ""; ?>

<div id="messages" class="container">
<div class="row justify-content-between mb-5">
  <div class="col espace-menu">
  <h3><a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['mesmessages'];?>" class="text-decoration-none"><?= __("Messages") ?></a></h3>
  </div>
  <?php if($this->Session->read('Auth.User.nature')=='CLT'){?>
      <div class="col-auto align-self-end">
      <a href="<?php echo $this->Url->build('/').$urlLang.$urlvaluemulti['utilisateurs']."/".$urlvaluemulti['locataire_index'];?>" class="text-decoration-none">
        <h3 class="text-blue espace-type"><?= __("Espace locataire") ?></h3>
      </a>
      </div>
      <?php }?>
</div>
      
			<div class="row">
				<div class="col-md-12">
          <div class="alert alert-danger d-none" role="alert" id="msgerrorphone">
            <?= __("Votre message ne peut pas être envoyé car il viole les conditions générales de Alpissime.com.<br> Il est interdit de communiquer une adresse email ou un numéro de téléphone par la messagerie.") ?>
          </div>
					<div class="header_title">
						<h5 class="text-secondary"><i class="fa fa-list-alt"></i> <?= __("Message venant de") ?> <strong><?php echo $premiermessage->prenom." ".$premiermessage->nom; ?></strong></h5>
						<div style="text-align: right;position: relative;top: -17px;height: 0px;">
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12 block">
            <div class="inbox_msg">
                <div class="mesgs col-md-12">
                    <div class="msg_history">
                        <div class="incoming_msg">                            
                            <?php if($premiermessage->locataire_id == $this->Session->read('Auth.User.id')){ ?>
                                <div class="outgoing_msg">
                                    <div class="sent_msg">
                            <?php }else{ ?>
                              <div class="incoming_msg_img">
                                  <img width="50" class="img-fluid" src="<?php echo $this->Url->build('/')?>images/user-icon.png" >
                              </div>
                              <div class="received_msg">
                                  <div class="received_withd_msg">
                            <?php } ?>                                        
                                <p><?php echo nl2br($premiermessage->commentaire); ?></p>
                                <span class="time_date"><?php echo $premiermessage->date_insert; ?></span></div>
                            </div>
                        </div>
                        <?php foreach($listereponses as $reponse){ ?>
                            <?php if($premiermessage->locataire_id == $this->Session->read('Auth.User.id')){ ?>
                                <?php if($reponse->locataire_id == 0) { ?>
                                  <div class="incoming_msg_img"> 
                                  <img width="50"  class="img-fluid" src="<?php echo $this->Url->build('/')?>images/user-icon.png" >
                                  </div>
                                    <div class="received_msg">
                                        <div class="received_withd_msg">
                                <?php }else{ ?>
                                    <div class="outgoing_msg">
                                        <div class="sent_msg">                                                
                                <?php } ?>
                            <?php }else{ ?>
                                <?php if($reponse->locataire_id == 0) { ?>
                                    <div class="outgoing_msg">
                                        <div class="sent_msg">
                                <?php }else{ ?>
                                  <div class="incoming_msg_img"> 
                                  <img width="50" class="img-responsive" src="<?php echo $this->Url->build('/')?>images/user-icon.png" >
                                  </div>
                                    <div class="received_msg">
                                        <div class="received_withd_msg">                                                                                                
                                <?php } ?>
                            <?php } ?>                                        
                                <p><?php echo nl2br($reponse->commentaire); ?></p>
                                <span class="time_date"> <?php echo $reponse->date_insert; ?></span> 
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                        <?php echo $this->Form->create(null, ['url' => ['controller' => 'Utilisateurs', 'action' => 'repondremessageprop']]); ?>
                        <div class="type_msg">
                            <div class="input_msg_write">
                                <textarea name="reponse" rows="4" cols="100%" class="write_msg" placeholder="Rédiger un message"> </textarea>
                                <input type="hidden" name="idmessage" value="<?php echo $premiermessage->id ?>">
                                <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>                        
            </div>
				</div>
        <span class="text-danger interditext" style="display:none;"><?= __("Votre message ne peut pas être envoyé car il viole les conditions générales de Alpissime.com.<br> Il est interdit de communiquer une adresse email ou un numéro de téléphone par la messagerie.") ?></span>
			</div>
		</div>
<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$('textarea').on('keyup', function (event) {
  $('#msgerrorphone').removeClass('d-none');
  $('#msgerrorphone').addClass('d-none');
  
  var VAL = $(this).val();
  var result = false;  
  // var patts = [];
  // patts.forEach(function(patt, index){    
  //   if (patt.test(VAL)) {
  //     result = patt.test(VAL);
  //   }
  // });

  var pattschaine = ["zéro", "zero", "z e r o", "zero.", "zéro.", "0six", "0sept", "z€ro", "z € r o", "pointcom", " om ", "il.c", "gma", "arobase", "(arobase)", "(at)", "(pointcom)", "(point)com", "yahoo", "gmail", "outlook", "hotmail", ". f r", ". b e", ". c h", "deux", "d e u x", "trois", "t r o i s", "quatre", "q u a t r e", "cinq", "c i n q", "six", "s i x", "sept", "s e p t", "huit", "h u i t", "neuf", "n e u f", "dix", "d i x", "vingt", "v i n g t", '@', ' tel', 'téléphone', 'telephone', 'portable', 'fixe', ' port.', 'adresse', '.com', '.fr', 'point com', 'point fr', '{at}', '{a}', 'mail', 'email', 'skype', '$kype', 'zero un', 'zero deux', 'zero trois', 'zero quatre', 'zero cinq', 'zero six', 'zero sept', 'zero huit', 'zero neuf', 'contacter au zero', 'contacter au 0', 'z e r o', 't e l', 'T-e-l', 'Z-e-ro', 'gmail', 'yahoo', 'hotmail', 'protonmail', 'outlook', 'orange', 'free', 'sfr', 'bouygues', 'icloud', 'gmx', 'caramail', 'tutanota', 'advalvas', 'aol', 'bluemail', 'bluewin', 'bbox', 'cyberposte', 'emailasso', 'fastmail', 'francite', 'hashmail', 'icqmail', 'iiiha', 'iname', 'juramail', 'katamail', 'laposte', 'libero', 'mailfence', 'mailplazza', 'mixmail', 'myway', 'No-log', 'openmailbox', 'peru', 'Safe-mail', 'tranquille.ch', 'vmail', 'vivalvi.net', 'webmail', 'webmails', 'yandex', 'zoho', '.com', '.fr', '.co.uk', '.ch', '.be', '.nl', '.at', '.es', '.cz', '.eu', '.de', '.gr', '.gal', '.it', '.li', '.lt', '.lu', '.pt', '.nl', '.se', '.eu', '.org', '.net', '.es', '.ee', '.fi', '(a)', '(at)', '[a]', '[at]', '+336', '+337', '06', '07', '+355', '+49', '+376', '+374', '+43', '+32', '+375', '+387', '+359', '+357', '+385', '+45', '+32', '+372', '+358', '+33', '+350', '+30', '+36', '+353', '+354', '+39', '+371', '+370', '+423', '+352', '+389', '+356', '+373', '+377', '+382', '+47', '+31', '+48', '+351', '+420', '+40', '+44', '+378', '+421', '+386', '+46', '+41', '+380', '+379']
  pattschaine.forEach(function(pattchaine, index){    
    if (VAL.indexOf(pattchaine) != -1) {
      result = true;
    }
  });
  
  if (result) {
    $(".msg_send_btn").attr("disabled","disabled");
    $(".interditext").css("display", "block");
  }else{
    $(".msg_send_btn").removeAttr("disabled");
    $(".interditext").css("display", "none");
  }
  
});
<?php $this->Html->scriptEnd(); ?>