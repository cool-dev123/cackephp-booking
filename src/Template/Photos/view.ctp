<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Photo'), ['action' => 'edit', $photo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Photo'), ['action' => 'delete', $photo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $photo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Photos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Photo'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Liste des annonces'), ['controller' => 'Annonces', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Nouvelle annonce'), ['controller' => 'Annonces', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="photos view large-9 medium-8 columns content">
    <h3><?= h($photo->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Annonce') ?></th>
            <td><?= $photo->has('annonce') ? $this->Html->link($photo->annonce->id, ['controller' => 'Annonces', 'action' => 'view', $photo->annonce->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Titre') ?></th>
            <td><?= h($photo->titre) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($photo->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Numero') ?></th>
            <td><?= $this->Number->format($photo->numero) ?></td>
        </tr>
    </table>
</div>
