<?php
$pdf = new \mikehaertl\wkhtmlto\Pdf([
    'no-outline',
    'margin-top' => 0,
    'margin-right' => 0,
    'margin-bottom' => 0,
    'margin-left' => 0,
    'disable-smart-shrinking',
    'user-style-sheet' => WWW_ROOT . 'css' . DS . 'pdf' . DS . 'ticket.css',
]);
ob_start(); ?>
<!DOCTYPE html>
<html>
    <head>
    </head>

    <body>
        <div class="tickets">
            <?= $this->fetch('content'); ?>
        </div>
    </body>
</html>
<?php
$pdf->addPage(ob_get_clean());

ob_start(); ?>
<!DOCTYPE html>
<html>
    <head>
    </head>

    <body>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Adresse</th>
                    <th>Code postal</th>
                    <th>Ville</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tickets as $ticket): ?>
                    <tr>
                        <td><?= $ticket->lastname; ?></td>
                        <td><?= $ticket->firstname; ?></td>
                        <td><?= $ticket->address; ?></td>
                        <td><?= $ticket->zip_code; ?></td>
                        <td><?= $ticket->city; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>
<?php
$pdf->addPage(ob_get_clean());
$pdf->send();