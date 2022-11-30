<?php
    $patterns = ["zéro", "zero", "z e r o", "zero.", "zéro.", "0six", "0sept", "z€ro", "z € r o", "pointcom", " om ", "il.c", "gma", "arobase", "(arobase)", "(at)", "(pointcom)", "(point)com", "yahoo", "gmail", "outlook", "hotmail", ". f r", ". b e", ". c h", "deux", "d e u x", "trois", "t r o i s", "quatre", "q u a t r e", "cinq", "c i n q", "six", "s i x", "sept", "s e p t", "huit", "h u i t", "neuf", "n e u f", "dix", "d i x", "vingt", "v i n g t", '@', ' tel', 'téléphone', 'telephone', 'portable', 'fixe', ' port.', 'adresse', '.com', '.fr', 'point com', 'point fr', '{at}', '{a}', 'skype', '$kype', 'zero un', 'zero deux', 'zero trois', 'zero quatre', 'zero cinq', 'zero six', 'zero sept', 'zero huit', 'zero neuf', 'contacter au zero', 'contacter au 0', 'z e r o', 't e l', 'T-e-l', 'Z-e-ro', 'gmail', 'yahoo', 'hotmail', 'protonmail', 'outlook', 'orange', 'free', 'sfr', 'bouygues', 'icloud', 'gmx', 'caramail', 'tutanota', 'advalvas', 'aol', 'bluemail', 'bluewin', 'bbox', 'cyberposte', 'emailasso', 'fastmail', 'francite', 'hashmail', 'icqmail', 'iiiha', 'iname', 'juramail', 'katamail', 'laposte', 'libero', 'mailfence', 'mailplazza', 'mixmail', 'myway', 'No-log', 'openmailbox', 'peru', 'Safe-mail', 'tranquille.ch', 'vmail', 'vivalvi.net', 'webmail', 'webmails', 'yandex', 'zoho', '.com', '. com', '.fr', '.co.uk', '.ch', '.be', '.nl', '.at', '.es', '.cz', '.eu', '.de', '.gr', '.gal', '.it', '.li', '.lt', '.lu', '.pt', '.nl', '.se', '.eu', '.org', '.net', '.es', '.ee', '.fi', '(a)', '(at)', '[a]', '[at]', '+336', '+337', '06', '07', '+355', '+49', '+376', '+374', '+43', '+32', '+375', '+387', '+359', '+357', '+385', '+45', '+32', '+372', '+358', '+33', '+350', '+30', '+36', '+353', '+354', '+39', '+371', '+370', '+423', '+352', '+389', '+356', '+373', '+377', '+382', '+47', '+31', '+48', '+351', '+420', '+40', '+44', '+378', '+421', '+386', '+46', '+41', '+380', '+379', '+3'];
    $emailPattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
    $phonePattern = '!([^@\s]\b\+?[0-9()\[\]./ -]{7,17}\b|\b\+?[0-9()\[\]./ -]{7,17}\s+(extension|x|#|-|code|ext)\s+[0-9]{1,6})!i';
?>
<?php if (!empty($premiermessage)) {
    $arrMessage = explode(' -- ', nl2br($premiermessage->commentaire));
    $arrMessage = array_slice($arrMessage, 4);
    $message = implode(' -- ', $arrMessage);

    if ($premiermessage->locataire_id != $this->Session->read('Auth.User.id')) {
?>
    <div class="message__content _sent">
        <div class="message__line">
            <div class="grid-message"><?= $message ?></div>
            <span class="time_date"><?= $premiermessage->date_insert; ?></span>
        </div>
    </div>
    <?php } else {
        $message = preg_replace($emailPattern, "***", $message); // hide email
        $message = preg_replace($phonePattern,"***", $message); // hide phone
        $message = str_replace($patterns, '***', $message); // hide other chains
    ?>
    <div class="message__content _received">
        <div class="incoming_msg_img">
            <img width="50" class="img-fluid" src="<?php echo $this->Url->build('/')?>images/user-icon.png" >
        </div>
        <div class="message__line">
            <div class="grid-message"><?=  $message ?></div>
            <span class="time_date"><?= $premiermessage->date_insert; ?></span>
        </div>
    </div>
    <?php } ?>
<?php } ?>

<?php foreach ($listeresponses as $response) {
    if ($response->locataire_id == $this->Session->read('Auth.User.id')) {
            $response->commentaire = preg_replace($emailPattern, "***", $response->commentaire); // hide email
            $response->commentaire = preg_replace($phonePattern,"***", $response->commentaire); // hide phone
            $response->commentaire = str_replace($patterns, '***', $response->commentaire); // hide other chains
?>
       <div class="message__content _received">
            <div class="incoming_msg_img">
                <img width="50" class="img-fluid" src="<?php echo $this->Url->build('/')?>images/user-icon.png" >
            </div>
            <div class="message__line">
                <div class="grid-message"><?= nl2br($response->commentaire) ?></div>
                <span class="time_date"><?= $response->date_insert; ?></span>
            </div>
       </div>
       <?php } else { ?>
       <div class="message__content _sent">
            <div class="message__line">
                <div class="grid-message"><?= nl2br($response->commentaire) ?></div>
                <span class="time_date"><?= $response->date_insert; ?></span>
            </div>
       </div>
       <?php } ?>
<?php } ?>