<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Perms'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="perms form large-9 medium-8 columns content">
    <?= $this->Form->create($perm) ?>
    <fieldset>
        <legend><?= __('Add Perm') ?></legend>
        <?php
            echo $this->Form->input('address');
            echo $this->Form->input('zip_code');
            echo $this->Form->input('city');
            echo $this->Form->input('datetime', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
