<?php foreach($codes as $code): ?>
    <div class="ticket">
        <?= $this->Barcodes->qrcode($code, ['class' => 'qrcode']); ?>
        <?= $this->Barcodes->barcode($code, ['class' => 'barcode']); ?>
        <p class="code"><?= $code; ?></p>
    </div>
<?php endforeach; ?>