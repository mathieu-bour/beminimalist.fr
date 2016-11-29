<?php foreach(['baptiste', 'jetaime', 'tropfort'] as $code): ?>
    <div class="ticket">
        <?= $this->Barcodes->qrcode($code, ['class' => 'qrcode']); ?>
        <?= $this->Barcodes->barcode($code, ['class' => 'barcode']); ?>
        <p class="code"><?= $code; ?></p>
    </div>
<?php endforeach; ?>

<?php /*foreach($tickets as $ticket): ?>
    <div class="ticket">
        <?= $this->Barcodes->qrcode($ticket->code, ['class' => 'qrcode']); ?>
        <?= $this->Barcodes->barcode($ticket->code, ['class' => 'barcode']); ?>
        <p class="code"><?= $ticket->code; ?></p>
    </div>
<?php endforeach;*/ ?>