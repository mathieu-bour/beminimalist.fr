<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Early Code'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="earlyCodes index large-9 medium-8 columns content">
    <h3><?= __('Early Codes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('expire') ?></th>
                <th scope="col"><?= $this->Paginator->sort('remaining_uses') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($earlyCodes as $earlyCode): ?>
            <tr>
                <td><?= $this->Number->format($earlyCode->id) ?></td>
                <td><?= h($earlyCode->code) ?></td>
                <td><?= h($earlyCode->expire) ?></td>
                <td><?= $this->Number->format($earlyCode->remaining_uses) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $earlyCode->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $earlyCode->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $earlyCode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $earlyCode->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
