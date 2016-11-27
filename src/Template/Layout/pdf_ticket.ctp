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
$pdf->send();