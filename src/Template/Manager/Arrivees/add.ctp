<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Arrivees'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="arrivees form large-9 medium-8 columns content">
    <?= $this->Form->create($arrivee) ?>
    <fieldset>
        <legend><?= __('Add Arrivee') ?></legend>
        <?php
            echo $this->Form->input('id_reservation');
            echo $this->Form->input('id_gestionnaire');
            echo $this->Form->input('d_create');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
