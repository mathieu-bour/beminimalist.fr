<div class="panel">
    <div class="panel-heading">
        <h3>Tickets enregistrés</h3>
    </div>

    <div class="panel-body">

        <table class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de naissance</th>
                    <th>Adresse e-mail</th>
                    <th>Adresse postale</th>
                    <th>Code-barre</th>
                    <th>Type</th>
                    <th>Payé</th>
                    <th>Status</th>
                    <th>Vendeur</th>
                </tr>
            </thead>

            <tbody>
            </tbody>
        </table>
    </div>
</div>

<?php $this->start('script'); ?>
<script>
    $('.dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?= \Cake\Routing\Router::url(['controller' => 'Tickets', 'action' => 'index']); ?>",
        "columns": [
            {
                "name": "lastname",
                "data": "lastname",
                "orderable": true
            },
            {
                "data": "firstname"
            },
            {
                "name": "birthdate",
                "render": function(data, type, row) {
                    return moment(row.birthdate).format('DD/MM/YYYY')
                }
            },
            {
                "data": "email"
            },
            {
                "render": function(data, type, row) {
                    return row.address + " " + row.zip_code + " " + row.city
                },
                "orderable": false
            },
            {
                "data": "barcode",
                "orderable": false
            },
            {
                "data": "type"
            },
            {
                "data": "paid"
            },
            {
                "data": "state"
            },
            {
                "data": "user_code"
            }
        ]
    });
</script>
<?= $this->end(); ?>