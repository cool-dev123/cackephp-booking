<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Registres'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="registres form large-9 medium-8 columns content">
    <?= $this->Form->create($registre) ?>
    <fieldset>
        <legend><?= __('Add Registre') ?></legend>
        <?php
            echo $this->Form->input('app');
            echo $this->Form->input('bra');
            echo $this->Form->input('cle');
            echo $this->Form->input('val');
            echo $this->Form->input('cpt');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
