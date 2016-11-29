<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Early Code'), ['action' => 'edit', $earlyCode->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Early Code'), ['action' => 'delete', $earlyCode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $earlyCode->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Early Codes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Early Code'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="earlyCodes view large-9 medium-8 columns content">
    <h3><?= h($earlyCode->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Code') ?></th>
            <td><?= h($earlyCode->code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($earlyCode->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Remaining Uses') ?></th>
            <td><?= $this->Number->format($earlyCode->remaining_uses) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Expire') ?></th>
            <td><?= h($earlyCode->expire) ?></td>
        </tr>
    </table>
</div>
