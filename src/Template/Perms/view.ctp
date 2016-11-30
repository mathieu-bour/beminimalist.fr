<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Perm'), ['action' => 'edit', $perm->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Perm'), ['action' => 'delete', $perm->id], ['confirm' => __('Are you sure you want to delete # {0}?', $perm->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Perms'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Perm'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="perms view large-9 medium-8 columns content">
    <h3><?= h($perm->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($perm->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= h($perm->city) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($perm->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Zip Code') ?></th>
            <td><?= $this->Number->format($perm->zip_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Datetime') ?></th>
            <td><?= h($perm->datetime) ?></td>
        </tr>
    </table>
</div>
