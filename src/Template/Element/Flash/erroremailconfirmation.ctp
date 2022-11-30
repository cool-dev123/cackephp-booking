<div class="message error renvoiemessage mb-3"><?= h($message) ?>
<?php if($message != __('Votre compte est activé avec succès, vous pouvez maintenant vous connecter.')){ ?>
    <br> <a href='#' onclick="renvoyermail()" style="color:#fea;"><?= __("Renvoyer un mail de confirmation") ?></a>
<?php } ?>
</div>
