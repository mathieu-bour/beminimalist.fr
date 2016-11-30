<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $earlyCode->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $earlyCode->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Early Codes'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="earlyCodes form large-9 medium-8 columns content">
    <?= $this->Form->create($earlyCode) ?>
    <fieldset>
        <legend><?= __('Edit Early Code') ?></legend>
        <?php
            echo $this->Form->input('code');
            echo $this->Form->input('expire', ['empty' => true]);
            echo $this->Form->input('remaining_uses');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
