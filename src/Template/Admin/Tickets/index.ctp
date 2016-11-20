<h2>À envoyer</h2>

<table class="table">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Date de naissance</th>
            <th>Adresse e-mail</th>
            <th>Adresse postale</th>
            <th>Type</th>
            <th>Payé</th>
            <th>Envoyé</th>
            <th>Vendeur</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($tickets as $ticket): ?>
            <tr>
                <td><?= $ticket->firstname . ' ' . $ticket->lastname; ?></td>
                <td><?= $ticket->birthdate; ?></td>
                <td><?= $ticket->email; ?></td>
                <td><?= $ticket->address . ' ' . $ticket->zip_code . ' ' . $ticket->city; ?></td>
                <td><?= $ticket->type; ?></td>
                <td>
                    <?php if($ticket->paid): ?>
                        <span class="label label-success"><i class="fa fa-check"></i></span>
                    <?php else: ?>
                        <span class="label label-danger"><i class="fa fa-times"></i></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($ticket->sent): ?>
                        <span class="label label-success"><i class="fa fa-check"></i></span>
                    <?php else: ?>
                        <span class="label label-danger"><i class="fa fa-times"></i></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if(!empty($ticket->user)): ?>
                        <?= $ticket->user->firstname . ' ' . $ticket->user->lastname; ?>
                    <?php else: ?>
                        <span class="label label-danger"><i class="fa fa-times"></i></span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-primary" data-id="<?= $ticket->id; ?>"><i class="fa fa-paper-plane"></i></a>
                    <!--<a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>-->
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>