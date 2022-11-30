<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Registre'), ['action' => 'edit', $registre->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Registre'), ['action' => 'delete', $registre->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registre->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Registres'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registre'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="registres view large-9 medium-8 columns content">
    <h3><?= h($registre->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('App') ?></th>
            <td><?= h($registre->app) ?></td>
        </tr>
        <tr>
            <th><?= __('Bra') ?></th>
            <td><?= h($registre->bra) ?></td>
        </tr>
        <tr>
            <th><?= __('Cle') ?></th>
            <td><?= h($registre->cle) ?></td>
        </tr>
        <tr>
            <th><?= __('Val') ?></th>
            <td><?= h($registre->val) ?></td>
        </tr>
        <tr>
            <th><?= __('Cpt') ?></th>
            <td><?= $this->Number->format($registre->cpt) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($registre->id) ?></td>
        </tr>
    </table>
</div>
