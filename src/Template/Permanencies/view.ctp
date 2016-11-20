<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Permanency'), ['action' => 'edit', $permanency->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Permanency'), ['action' => 'delete', $permanency->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permanency->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Permanencies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Permanency'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="permanencies view large-9 medium-8 columns content">
    <h3><?= h($permanency->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= h($permanency->location) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($permanency->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Begin') ?></th>
            <td><?= h($permanency->begin) ?></td>
        </tr>
    </table>
</div>
