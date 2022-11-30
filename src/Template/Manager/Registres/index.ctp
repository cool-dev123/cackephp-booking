<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Registre'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="registres index large-9 medium-8 columns content">
    <h3><?= __('Registres') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('app') ?></th>
                <th><?= $this->Paginator->sort('bra') ?></th>
                <th><?= $this->Paginator->sort('cle') ?></th>
                <th><?= $this->Paginator->sort('val') ?></th>
                <th><?= $this->Paginator->sort('cpt') ?></th>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registres as $registre): ?>
            <tr>
                <td><?= h($registre->app) ?></td>
                <td><?= h($registre->bra) ?></td>
                <td><?= h($registre->cle) ?></td>
                <td><?= h($registre->val) ?></td>
                <td><?= $this->Number->format($registre->cpt) ?></td>
                <td><?= $this->Number->format($registre->id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $registre->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $registre->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $registre->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registre->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
