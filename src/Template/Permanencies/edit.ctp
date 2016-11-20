<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $permanency->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $permanency->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Permanencies'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="permanencies form large-9 medium-8 columns content">
    <?= $this->Form->create($permanency) ?>
    <fieldset>
        <legend><?= __('Edit Permanency') ?></legend>
        <?php
            echo $this->Form->input('begin', ['empty' => true]);
            echo $this->Form->input('location');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
