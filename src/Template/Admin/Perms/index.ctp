<div class="row">
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <h3>Permanences</h3>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('datetime', 'Date') ?></th>
                            <th>Adresse postale</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($perms as $perm): ?>
                            <tr>
                                <td><?= $perm->datetime ?></td>
                                <td><?= $perm->address ?> <?= $perm->zip_code ?> <?= $perm->city; ?></td>
                                <td>
                                    <?= $this->Form->postLink(
                                        '<span class="label label-danger"><i class="fa fa-trash-o"></i></span>',
                                        ['action' => 'delete', $perm->id],
                                        [
                                            'escape' => false,
                                            'confirm' => __('Confirmez la suppression de la permanence {0} ?', $perm->id)
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
                <h3>Ajouter une permanence</h3>
            </div>

            <div class="panel-body">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Perms', 'action' => 'add']]); ?>
                <?= $this->Form->input('datetime', [
                    'label' => 'Date et heure',
                    'type' => 'datetime',
                    'second' => true,
                    'minYear' => date('Y'),
                    'templates' => [
                        'dateWidget' => '{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}'
                    ]
                ]); ?>
                <?= $this->Form->input('address', ['label' => 'Adresse', 'placeholder' => '6 rue de ...']); ?>
                <?= $this->Form->input('zip_code', ['label' => 'Code postal', 'placeholder' => '57000']); ?>
                <?= $this->Form->input('city', ['label' => 'Ville', 'placeholder' => 'Metz']); ?>

                <button class="btn btn-block btn-info">Ajouter la permanence</button>
                <?php $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>