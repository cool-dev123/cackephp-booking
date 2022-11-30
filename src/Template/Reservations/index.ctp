<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Nouvelle réservation'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste des annonces'), ['controller' => 'Annonces', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvelle annonce'), ['controller' => 'Annonces', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste des utilisateurs'), ['controller' => 'Utilisateurs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvel utilisateur'), ['controller' => 'Utilisateurs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste des disponibilités'), ['controller' => 'Dispos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvelle disponibilité'), ['controller' => 'Dispos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste des packs'), ['controller' => 'Packs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouveau pack'), ['controller' => 'Packs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="reservations index large-9 medium-8 columns content">
    <h3><?= __('Reservations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('annonce_id') ?></th>
                <th><?= $this->Paginator->sort('utilisateur_id') ?></th>
                <th><?= $this->Paginator->sort('dbt_at') ?></th>
                <th><?= $this->Paginator->sort('fin_at') ?></th>
                <th><?= $this->Paginator->sort('statut') ?></th>
                <th><?= $this->Paginator->sort('created_at') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?= $this->Number->format($reservation->id) ?></td>
                <td><?= $reservation->has('annonce') ? $this->Html->link($reservation->annonce->id, ['controller' => 'Annonces', 'action' => 'view', $reservation->annonce->id]) : '' ?></td>
                <td><?= $reservation->has('utilisateur') ? $this->Html->link($reservation->utilisateur->id, ['controller' => 'Utilisateurs', 'action' => 'view', $reservation->utilisateur->id]) : '' ?></td>
                <td><?= h($reservation->dbt_at) ?></td>
                <td><?= h($reservation->fin_at) ?></td>
                <td><?= $this->Number->format($reservation->statut) ?></td>
                <td><?= h($reservation->created_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $reservation->id]) ?>
                    <?= $this->Html->link(__('Modifier'), ['action' => 'edit', $reservation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reservation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reservation->id)]) ?>
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
