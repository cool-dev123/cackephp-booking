<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Nouvelle disponibilité'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste des annonces'), ['controller' => 'Annonces', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvelle annonce'), ['controller' => 'Annonces', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste des utilisateurs'), ['controller' => 'Utilisateurs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvel utilisateur'), ['controller' => 'Utilisateurs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste des réservations'), ['controller' => 'Reservations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvelle réservation'), ['controller' => 'Reservations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="dispos index large-9 medium-8 columns content">
    <h3><?= __('Dispos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('annonce_id') ?></th>
                <th><?= $this->Paginator->sort('created_at') ?></th>
                <th><?= $this->Paginator->sort('updated_at') ?></th>
                <th><?= $this->Paginator->sort('dbt_at') ?></th>
                <th><?= $this->Paginator->sort('fin_at') ?></th>
                <th><?= $this->Paginator->sort('prix') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dispos as $dispo): ?>
            <tr>
                <td><?= $this->Number->format($dispo->id) ?></td>
                <td><?= $dispo->has('annonce') ? $this->Html->link($dispo->annonce->id, ['controller' => 'Annonces', 'action' => 'view', $dispo->annonce->id]) : '' ?></td>
                <td><?= h($dispo->created_at) ?></td>
                <td><?= h($dispo->updated_at) ?></td>
                <td><?= h($dispo->dbt_at) ?></td>
                <td><?= h($dispo->fin_at) ?></td>
                <td><?= $this->Number->format($dispo->prix) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $dispo->id]) ?>
                    <?= $this->Html->link(__('Modifier'), ['action' => 'edit', $dispo->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $dispo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dispo->id)]) ?>
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
