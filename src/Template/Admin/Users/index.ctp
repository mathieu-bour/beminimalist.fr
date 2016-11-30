<div class="row">
    <div class="col-md-8">
        <div class="panel">
            <div class="panel-heading">
                <h3>Utilisateurs enregistrés</h3>
            </div>

            <div class="panel-body">
                <table class="table">
                    <thead>
                        <th><?= $this->Paginator->sort('lastname', 'Nom') ?></th>
                        <th><?= $this->Paginator->sort('firstname', 'Prénom') ?></th>
                        <th><?= $this->Paginator->sort('email', 'Adresse e-mail') ?></th>
                        <th><?= $this->Paginator->sort('code', 'Code') ?></th>
                        <th><?= $this->Paginator->sort('ticket_count', 'Tickets vendus') ?></th>
                        <th>Actions</th>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user->lastname; ?></td>
                                <td><?= $user->firstname; ?></td>
                                <td><?= $user->email; ?></td>
                                <td><?= $user->code; ?></td>
                                <td><?= $user->ticket_count; ?></td>
                                <td>
                                    <?= $this->Form->postLink(
                                        '<span class="label label-danger"><i class="fa fa-trash-o"></i></span>',
                                        ['action' => 'delete', $user->id],
                                        [
                                            'escape' => false,
                                            'confirm' => __('Supprimer {0} ?', $user->firstname . ' ' . $user->lastname)
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

    <div class="col-md-4">
        <div class="panel">
            <div class="panel-heading">
                <h3>Ajouter un utilisateur</h3>
            </div>

            <div class="panel-body">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'add']]); ?>
                <?= $this->Form->input('lastname', ['label' => 'Nom', 'placeholder' => 'Martin']); ?>
                <?= $this->Form->input('firstname', ['label' => 'Prénom', 'placeholder' => 'Jean']); ?>
                <?= $this->Form->input('email', ['label' => 'Addresse e-mail', 'placeholder' => 'jean.martin@exemple.com']); ?>
                <?= $this->Form->input('password', ['label' => 'Mot de passe']); ?>
                <?= $this->Form->input('code', ['label' => 'Code', 'placeholder' => 'JEMA1']); ?>

                <button class="btn btn-block btn-info">Ajouter l'utilisateur</button>
                <?php $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>