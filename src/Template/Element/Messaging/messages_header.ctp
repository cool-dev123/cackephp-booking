<?php
    use Cake\I18n\Date;

    list($fromTxt, $toTxt, $adultsTxt, $childrenTxt) = explode(' -- ', $premiermessage->commentaire);
    $fromDate    = end(explode(' : ', $fromTxt));
    $toDate      = end(explode(' : ', $toTxt));
    $adultsNum   = end(explode(' : ', $adultsTxt));
    $childrenNum = end(explode(' : ', $childrenTxt));

    $reservationUrl = $this->Session->read('Auth.User.nature')=='CLT' ? $urlvaluemulti['locataire_view'] : 'view';

    try {
        $infoTxt = __('Du') . ' ' . (new Date($fromDate))->format('d-m-Y') . ' ' . strtolower(__('Au')) . ' ' . (new Date($toDate))->format('d-m-Y') . ' ';
    } catch(\Exception $e) {
        $infoTxt = '';
    }

    $otherInfoArr = [];
    if ($adultsNum > 0) {
        $otherInfoArr[] = $adultsNum . ' ' . strtolower(__('Adulte(s)'));
    }

    if ($childrenNum > 0) {
        $otherInfoArr[] = $childrenNum . ' ' . strtolower(__('Enfant(s)'));
    }

    if (!empty($otherInfoArr)) {
        $infoTxt .= '| ' . implode(' , ', $otherInfoArr);
    }

?>
<div class="messages__top">
    <div class="message__info">
        <div class="message__info__all">
            <div class="message__title"></div>
            <div><?= $infoTxt ?></div>
        </div>

    </div>
    <div class="actions-block">
        <?php if ($premiermessage->reservation_id) { ?>
        <div class="content__block message__subtitle view-reservation">
            <a href="<?= $this->Url->build('/').$urlLang?>reservations/<?= $reservationUrl; ?>?res_id=<?= $premiermessage->reservation_id ?>"><?= __("Voir la réservation") ?></a>
        </div>
        <?php } ?>
        <div class="header__search">
            <span class="header__search-ic"><i class="fa fa-search" aria-hidden="true"></i></span>
            <input id="messages-search" type="text" class="header__input" placeholder="<?= __('Rechercher dans la conversation') ?>" value="<?= $searchTerm ?>">
        </div>
    </div>

</div>
