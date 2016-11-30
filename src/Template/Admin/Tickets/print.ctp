<?php foreach($tickets as $ticket): ?>
    <div class="ticket">
        <?= $this->Barcodes->qrcode($ticket->barcode . "", ['class' => 'qrcode']); ?>
        <?= $this->Barcodes->barcode($ticket->barcode . "", ['class' => 'barcode']); ?>
        <p class="code"><?= $ticket->code; ?></p>
    </div>
<?php endforeach; ?>