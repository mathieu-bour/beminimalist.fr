<?php $this->extend('wizard'); ?>
<h2>Étape 2 : remplissez les tickets</h2>
<p>Le tableau ci-dessous indique les nom et prénom de l'invité. Si besoin, vérifiez à l'aide du code barre !</p>

<table class="table">
    <thead>
        <tr>
            <th>Code</th>
            <th>Nom</th>
            <th>Prénom</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= $ticket->code; ?></td>
                <td><?= $ticket->lastname; ?></td>
                <td><?= $ticket->firstname; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->Form->create('Ticket'); ?>
    <?= $this->Form->input('ok', ['type' => 'hidden', 'value' => 1]); ?>
    <button class="btn btn-lg btn-success">J'ai rempli les tickets, continuer</button>
<?= $this->Form->end(); ?>
