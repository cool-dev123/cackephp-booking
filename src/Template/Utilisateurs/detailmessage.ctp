<?php
        echo $this->element('Messaging/messages_header', [
            'premiermessage' => $premiermessage,
            'searchTerm'     => $searchTerm,
            'urlLang'        => $urlLang,
        ]);
    ?>

<div class="messages__body">
    <div class="messages-grid">
        <?php
            echo $this->element('Messaging/messages_content', [
                'premiermessage' => $premiermessage,
                'listeresponses' => $listeresponses,
            ]);
        ?>
    </div>
</div>

<div class="messages__bottom">
    <div class="messages__func">
        <textarea style="resize: none;" class="input" id="textarea"></textarea>
        <div class="messages__func-line">
            <button class="messages__btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
        </div>
    </div>
</div>
