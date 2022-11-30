<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Liste des disponibilités'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Liste des annonces'), ['controller' => 'Annonces', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvelle annonce'), ['controller' => 'Annonces', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste des utilisateurs'), ['controller' => 'Utilisateurs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvel utilisateur'), ['controller' => 'Utilisateurs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Liste des réservations'), ['controller' => 'Reservations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Nouvelle réservation'), ['controller' => 'Reservations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="dispos form large-9 medium-8 columns content">
    <?= $this->Form->create($dispo) ?>
    <fieldset>
        <legend><?= __('Add Dispo') ?></legend>
        <?php
            echo $this->Form->input('annonce_id', ['options' => $annonces, 'empty' => true]);
            echo $this->Form->input('created_at', ['empty' => true]);
            echo $this->Form->input('updated_at', ['empty' => true]);
            echo $this->Form->input('dbt_at');
            echo $this->Form->input('fin_at');
            echo $this->Form->input('prix');
            echo $this->Form->input('statut');
            echo $this->Form->input('utilisateur_id', ['options' => $utilisateurs, 'empty' => true]);
            echo $this->Form->input('promo_yn');
            echo $this->Form->input('reservation_id', ['options' => $reservations, 'empty' => true]);
            echo $this->Form->input('promo_px');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Soumettre')) ?>
    <?= $this->Form->end() ?>
</div>
