<div class="panel">
    <div class="panel-heading">
        <h3>Tickets enregistrés</h3>
    </div>

    <div class="panel-body">

        <table class="table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Date de naissance</th>
                    <th>Adresse e-mail</th>
                    <th>Adresse postale</th>
                    <th>Type</th>
                    <th>Payé</th>
                    <th>Status</th>
                    <th>Vendeur</th>
                </tr>
            </thead>

            <tbody>
                <?php $states = [
                    'pending' => 'À imprimer',
                    'printed' => 'Imprimé',
                    'sent' => 'Envoyé'
                ]; ?>

                <?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td><?= $ticket->barcode; ?></td>
                        <td><?= $ticket->firstname . ' ' . $ticket->lastname; ?></td>
                        <td><?= $ticket->birthdate; ?></td>
                        <td><?= $ticket->email; ?></td>
                        <td><?= $ticket->address . ' ' . $ticket->zip_code . ' ' . $ticket->city; ?></td>
                        <td><?= $ticket->type; ?></td>
                        <td>
                            <?php if ($ticket->paid): ?>
                                <span class="label label-success"><i class="fa fa-check"></i></span>
                            <?php else: ?>
                                <span class="label label-danger"><i class="fa fa-times"></i></span>
                            <?php endif; ?>
                        </td>
                        <td><?= $states[$ticket->state]; ?></td>
                        <td>
                            <?php if (!empty($ticket->user)): ?>
                                <?= $ticket->user->firstname . ' ' . $ticket->user->lastname; ?>
                            <?php else: ?>
                                Aucun
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>