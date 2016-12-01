<div class="panel">
    <div class="panel-heading">
        <h3>Tickets enregistrés</h3>
    </div>

    <div class="panel-body">

        <table class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de naissance</th>
                    <th>Adresse e-mail</th>
                    <th>Adresse postale</th>
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
                "name": "Ticket.barcode",
                "data": "barcode",
                "orderable": false
            },
            {
                "name": "Ticket.lastname",
                "data": "lastname"
            },
            {
                "name": "Ticket.firstname",
                "data": "firstname"
            },
            {
                "name": "Ticket.birthdate",
                "render": function(data, type, row) {
                    return moment(row.birthdate).format('DD/MM/YYYY')
                }
            },
            {
                "name": "Ticket.email",
                "data": "email"
            },
            {
                "render": function(data, type, row) {
                    return row.address + " " + row.zip_code + " " + row.city
                },
                "orderable": false
            },
            {
                "name": "Ticket.type",
                "data": "type"
            },
            {
                "name": "Ticket.paid",
                "data": "paid"
            },
            {
                "name": "Ticket.state",
                "data": "state"
            },
            {
                "data": "User.firstname"
            }
        ],
        "order": [[1, "asc"]]
    });
</script>
<?= $this->end(); ?>