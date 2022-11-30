<?php $this->assign('title', __('Utilisateurs')); ?>

<?php $this->Html->css("/css/new/dataTables.bootstrap4.min.css", ['block' => 'cssTop']); ?>
<?php $this->Html->css("/css/messaging/main.css", ['block' => 'cssTop']); ?>
<?php $this->Html->css("/css/messaging/normalize.css", ['block' => 'cssTop']); ?>
<?php $this->Html->css("/css/messaging/default.css", ['block' => 'cssTop']); ?>
<?php $this->Html->css("/css/messaging/header.css", ['block' => 'cssTop']); ?>
<?php $this->Html->css("/css/messaging/content.css", ['block' => 'cssTop']); ?>
<?php $this->Html->css("/css/messaging/messages.css", ['block' => 'cssTop']); ?>
<?php $this->Html->script("/js/new/dataTables.bootstrap4.min.js", ['block' => 'scriptBottom']); ?>

<?php $this->Html->css("/css/bootstrap-multiselect.css", ['block' => 'cssTop']); ?>
<?php $this->Html->script("/js/bootstrap-multiselect.js", ['block' => 'scriptBottom']); ?>

<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
var nonSelectedText = '<?= __("Tous les messages") ?>';
var selectedMessageId = '<?= (!empty($selected_message_id) ? $selected_message_id : null )?>';
var nSelectedText = '<?= __("sélectionné(s)") ?>';
var allSelectedText = '<?= __("Tous sélectionnés") ?>';
var notReadText = '<?= __("Message non lu") ?>';
var readText = '<?= __("Message lu") ?>';
var notReadOptionTxt = '<?= __("Marquer comme non lu") ?>';
var readOptionTxt = '<?= __("Marquer comme lu") ?>';
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->script("/js/messaging/scripts.js", ['block' => 'scriptBottom']); ?>

<div class="wrapper">
    <div class="header">
        <div class="header__body">
            <div class="messages-burger">
                <div class="burger__line burger__line-1"></div>
                <div class="burger__line burger__line-2"></div>
                <div class="burger__line burger__line-3"></div>
            </div>
            <div class="header__title"><?= __("Messagerie") ?></div>
        </div>
    </div>
    <div class="content">
        <div class="content__body hidden">

            <div class="content__column content__column-left content-members">
                <div class="header__func">
                    <div class="header__search">
                        <span class="header__search-ic"><i class="fa fa-search" aria-hidden="true"></i></span>
                        <input id="members-search" type="text" class="header__input" placeholder="<?= __('Rechercher un utilisateur') ?>">
                    </div>

                    <div class="header__func-min">
                        <div class="header__mTitle"><?= __("Trier") ?></div>
                        <select id="chat_filter" multiple="multiple">
                            <option value="2"><?= __("Messages lus") ?></option>
                            <option value="3"><?= __("Messages non lus") ?></option>
                            <option value="4"><?= __("Actifs") ?></option>
                            <option value="5"><?= __("Archives") ?></option>
                        </select>
                    </div>

                    <div class="members-burgerClose">
                        <span class="burgerClose__lien burgerClose-line-1"></span>
                        <span class="burgerClose__lien burgerClose-line-2"></span>
                    </div>
                </div>

                <div class="chats-list">

                </div>
            </div>

            <div class="content__column content__column-right">

            </div>

            <!--div class="preloader hidden">
                <img src="<?php echo $this->Url->build('/',true) ?>images/ajax-loader.gif" />
            </div-->
            <div class="no-result hidden" style="text-align: center;"><?= __('Non résultats') ?></div>
        </div>    

    </div>
    <div class="preloader hidden">
            <img src="<?php echo $this->Url->build('/',true) ?>images/ajax-loader.gif" />
    </div>
</div>
