<div class="panel">
    <div class="panel-heading">
        <h3>Carte des invités</h3>
    </div>

    <div class="panel-body">
        <div id="tickets-map" style="height: 800px;"></div>
    </div>
</div>

<?php $this->start('script'); ?>
<script type="text/javascript">
    function initMap() {
        var ticketsMap = new google.maps.Map(document.getElementById('tickets-map'), {
            center: {lat: 48.7096442, lng: 5.1432836},
            zoom: 8
        });

        var markers = [];
        var coordinates = <?= json_encode($charts['map']); ?>;

        for (var i = 0; i < coordinates.length; i++) {
            markers.push(new google.maps.Marker({
                position: {lat: coordinates[i]['latitude'], lng: coordinates[i]['longitude']},
                map: ticketsMap
            }));
        }
    }
</script>
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7Pm8d0ueV_bpSqobLSsVdB2r084SSzJ4&callback=initMap"></script>
<?php $this->end(); ?>