<h1>Tickets réservés à cette adresse e-mail</h1>

<table class="table text-left">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Type de réservation</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= $ticket->lastname; ?></td>
                <td><?= $ticket->firstname; ?></td>
                <td><?= $ticket->address; ?></td>
                <td><?= $ticket->zip_code; ?></td>
                <td><?= $ticket->city; ?></td>
                <td><?= $ticket->type; ?></td>
                <td>
                    <?php if($ticket->type == 'paypal'): ?>
                        <?php if(!$ticket->paid): ?>
                            <?= $this->Form->create(); ?>
                                <button name="id" value="<?= $ticket->id; ?>" class="btn btn-primary">Terminer le paiement PayPal</button>
                            <?= $this->Form->end(); ?>
                        <?php else: ?>
                            <button class="btn">Paiement PayPal effectué</button>
                        <?php endif; ?>
                    <?php else: ?>
                        <button class="btn btn-success" data-toggle="modal" data-target="#perms-modal">Paiement lors d'une permanence</button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->element('Modal/perms'); ?>