<?php $this->extend('wizard'); ?>
<h2>Étape 3 : remplissez les enveloppes</h2>
<p>Le tableau ci-dessous indique les adresses des invités. Si besoin, vérifiez à l'aide du code barre !</p>

<table class="table">
    <thead>
        <tr>
            <th>Code</th>
            <th>Adresse</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tickets as $ticket): ?>
            <tr>
                <td><?= $ticket->code; ?></td>
                <td>
                    <?= $ticket->firstname; ?> <?= $ticket->lastname; ?><br>
                    <?= $ticket->address; ?><br><?= $ticket->zip_code; ?> <?= $ticket->city; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->Form->create('Ticket'); ?>
    <?= $this->Form->input('ok', ['type' => 'hidden', 'value' => 1]); ?>
    <button class="btn btn-lg btn-success">J'ai rempli les enveloppes, continuer</button>
<?= $this->Form->end(); ?>
