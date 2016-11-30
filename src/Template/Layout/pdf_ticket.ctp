<?php
$pdf = new \mikehaertl\wkhtmlto\Pdf([
    'no-outline',
    'margin-top' => 0,
    'margin-right' => 0,
    'margin-bottom' => 0,
    'margin-left' => 0,
    'disable-smart-shrinking'
]);
ob_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="<?= WWW_ROOT . 'css' . DS . 'pdf' . DS . 'ticket.css'; ?>">
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
debug($pdf->getError());
?>