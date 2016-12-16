<canvas></canvas>

<?php $this->append('script'); ?>
<?= $this->Html->script([
    '/plugins/WebCodeCamJS/js/qrcodelib.js',
    '/plugins/WebCodeCamJS/js/webcodecamjquery.js',
    '/js/admin/checkpoint.js'
]); ?>
<?php $this->end(); ?>
