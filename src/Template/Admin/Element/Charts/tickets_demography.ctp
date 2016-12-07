<div class="row">
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <h3>Genres</h3>
            </div>
            <div class="panel-body">
                <div id="tickets-gender"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <h3>Majeurs/mineurs</h3>
            </div>
            <div class="panel-body">
                <div id="tickets-majority"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <h3>Référents</h3>
            </div>
            <div class="panel-body">
                <div id="tickets-referents-sales"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <h3>Types</h3>
            </div>
            <div class="panel-body">
                <div id="tickets-types"></div>
            </div>
        </div>
    </div>
</div>

<?php $this->append('script'); ?>
<script>
    Morris.Donut({
        element: 'tickets-gender',
        resize: true,
        data: <?= json_encode($genderData) ?>
    });
    Morris.Donut({
        element: 'tickets-referents-sales',
        resize: true,
        data: <?= json_encode($referentsSalesData) ?>
    });
    Morris.Donut({
        element: 'tickets-majority',
        resize: true,
        data: <?= json_encode($majorityData) ?>
    });
    Morris.Donut({
        element: 'tickets-types',
        resize: true,
        data: <?= json_encode($typesData) ?>
    });
</script>
<?php $this->end(); ?>
