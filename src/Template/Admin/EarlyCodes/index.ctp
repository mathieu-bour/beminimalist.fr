<div class="row">
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <h3>Codes d'accès</h3>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('code') ?></th>
                            <th><?= $this->Paginator->sort('expire', 'Date d\'expiration') ?></th>
                            <th><?= $this->Paginator->sort('remaining_uses', 'Utilisations restantes') ?></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($earlyCodes as $earlyCode): ?>
                            <tr>
                                <td><?= $earlyCode->code ?></td>
                                <td><?= $earlyCode->expire ?></td>
                                <td><?= $earlyCode->remaining_uses ?></td>
                                <td>
                                    <?= $this->Form->postLink(
                                        '<span class="label label-danger"><i class="fa fa-trash-o"></i></span>',
                                        ['action' => 'delete', $earlyCode->id],
                                        [
                                            'escape' => false,
                                            'confirm' => __('Supprimer le code {0} ?', $earlyCode->code)
                                        ]
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->prev('< Précédents') ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next('Suivants >') ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <h3>Ajouter un code d'accès</h3>
            </div>

            <div class="panel-body">
                <?= $this->Form->create(null, ['url' => ['controller' => 'EarlyCodes', 'action' => 'add']]); ?>
                <?= $this->Form->input('code', ['label' => 'Nom', 'placeholder' => 'blabla']); ?>

                <?= $this->Form->input('expire', [
                    'label' => 'Date d\'expiration',
                    'type' => 'datetime',
                    'second' => true,
                    'minYear' => date('Y'),
                    'templates' => [
                        'dateWidget' => '{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}'
                    ]
                ]); ?>
                <?= $this->Form->input('remaining_uses', ['label' => 'Utilisations maximum', 'placeholder' => '10']); ?>

                <button class="btn btn-block btn-info">Ajouter le code</button>
                <?php $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>