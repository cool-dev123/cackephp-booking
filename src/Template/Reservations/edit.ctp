<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $reservation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $reservation->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('Liste des réservations'), ['action' => 'index']) ?></li>
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
<div class="reservations form large-9 medium-8 columns content">
    <?= $this->Form->create($reservation) ?>
    <fieldset>
        <legend><?= __('Modifier la réservation') ?></legend>
        <?php
            echo $this->Form->input('annonce_id', ['options' => $annonces]);
            echo $this->Form->input('utilisateur_id', ['options' => $utilisateurs]);
            echo $this->Form->input('dbt_at');
            echo $this->Form->input('fin_at');
            echo $this->Form->input('statut');
            echo $this->Form->input('created_at', ['empty' => true]);
            echo $this->Form->input('updated_at', ['empty' => true]);
            echo $this->Form->input('nb_enfants');
            echo $this->Form->input('nb_adultes');
            echo $this->Form->input('comment');
            echo $this->Form->input('taxe');
            echo $this->Form->input('menage');
            echo $this->Form->input('arrivee');
            echo $this->Form->input('p_cle');
            echo $this->Form->input('packs._ids', ['options' => $packs]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Soumettre')) ?>
    <?= $this->Form->end() ?>
</div>
