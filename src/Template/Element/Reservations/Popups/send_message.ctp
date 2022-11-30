<!-- popup_contact -->
<div class="modal fade" id="send_message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" style="width:650px; max-width:700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5><?= __("Envoyer un message") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <?php echo $this->Form->create(null,['url'=>['action'=>'prop'],'class'=>'form-horizontal propform','novalidate']); ?>
            <div class="modal-body">
                <div class="alert alert-danger d-none" role="alert" id="msgerrorphone">
                    <?= __("Votre message ne peut pas être envoyé car il viole les conditions générales de Alpissime.com.<br> Il est interdit de communiquer une adresse email ou un numéro de téléphone par la messagerie.") ?>
                </div>
                <div class="col-md-12 block">
                    <div class="form-group row">
                        <label class="col-sm-4 font-weight-bold"><?= __("Nom et prénom") ?> :</label>
                        <div class="col-sm-6">
                            <?php echo $this->Session->read('Auth.User.nom_famille') . " " .$this->Session->read('Auth.User.prenom') ?>
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