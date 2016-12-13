<div class="panel">
    <div class="panel-heading">
        <h3>Tickets payés</h3>
    </div>
    <div class="panel-body">
        <div id="book-line"></div>
    </div>
</div>

<?php $this->append('script'); ?>
<script>
    var colors = ['#428bca', '#5cb85c', '#5bc0de', '#f0ad4e', '#d9534f'];

    Morris.Line({
        element: 'book-line',
        resize: true,
        data: <?= json_encode($data) ?>,
        xkey: 'date',
        ykeys: ['book', 'paypal', 'perm'],
        labels: ['Total', 'PayPal', 'Permanences'],
        lineColors: colors,
        pointFillColors: colors,
        dateFormat: function (x) {
            return 'Au ' + moment(x).format('DD/MM');
        },
        xLabelFormat: function (x) {
            return moment(x).format('DD/MM');
        }
    });
</script>
<?php $this->end(); ?>