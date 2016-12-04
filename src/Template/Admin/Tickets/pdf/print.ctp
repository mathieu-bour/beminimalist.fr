<?php
function nice($str)
{
    $str = strtolower($str);

    foreach ([' ', '-'] as $sep) {
        $str = explode($sep, $str);
        foreach ($str as $k => $v) {
            $str[$k] = ucfirst($v);
        }
        $str = implode($sep, $str);
    }

    return $str;
}

?>

<div class="tickets">
    <?php foreach ($tickets as $key => $ticket): ?>
        <div class="ticket<?= $key % 3 == 2 ? ' ticket-bottom' : '' ?>">
            <?= $this->Barcodes->qrcode($ticket->barcode . "", ['class' => 'qrcode']); ?>
            <?= $this->Barcodes->barcode($ticket->barcode . "", ['class' => 'barcode']); ?>
            <span class="barcode-text"><?= $ticket->barcode ?></span>
        </div>
    <?php endforeach; ?>
</div>

<div class="tickets-table-container">
    <h1 class="tickets-table-title">Tableau des tickets imprimés</h1>

    <table class="tickets-table table">
        <thead>
            <tr>
                <th>Code-barre</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Code postal</th>
                <th>Ville</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($tickets as $key => $ticket): ?>
                <tr>
                    <td><?= $ticket->barcode ?></td>
                    <td><?= nice($ticket->lastname) ?></td>
                    <td><?= nice($ticket->firstname) ?></td>
                    <td><?= $ticket->address ?></td>
                    <td><?= $ticket->zip_code ?></td>
                    <td><?= nice($ticket->city) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>