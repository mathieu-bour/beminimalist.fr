<div class="panel">
    <div class="panel-heading">
        <h3>Revenus estimés</h3>
    </div>
    <div class="panel-body">
        <div id="book-line"></div>
    </div>
</div>

<?php $this->append('script'); ?>
<script>
    Morris.Line({
        element: 'book-line',
        resize: true,
        data: <?= json_encode($data) ?>,
        xkey: 'date',
        ykeys: ['book', 'paypal', 'perm'],
        labels: ['Réservations', 'Paiements PayPal', 'Paiements permanences'],
        dateFormat: function (x) {
            return 'Au ' + moment(x).format('DD/MM');
        },
        xLabelFormat: function (x) {
            return moment(x).format('DD/MM');
        }
    });
</script>
<?php $this->end(); ?>