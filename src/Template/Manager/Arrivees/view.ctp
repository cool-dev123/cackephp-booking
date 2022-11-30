<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Arrivee'), ['action' => 'edit', $arrivee->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Arrivee'), ['action' => 'delete', $arrivee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $arrivee->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Arrivees'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Arrivee'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="arrivees view large-9 medium-8 columns content">
    <h3><?= h($arrivee->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($arrivee->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Id Reservation') ?></th>
            <td><?= $this->Number->format($arrivee->id_reservation) ?></td>
        </tr>
        <tr>
            <th><?= __('Id Gestionnaire') ?></th>
            <td><?= $this->Number->format($arrivee->id_gestionnaire) ?></td>
        </tr>
        <tr>
            <th><?= __('D Create') ?></th>
            <td><?= h($arrivee->d_create) ?></td>
        </tr>
    </table>
</div>
