<div class="panel">
    <div class="panel-heading">
        <h3>Tickets enregistrés</h3>
    </div>

    <div class="panel-body">
        <table class="table table-striped table-bordered table-hover dataTable"></table>
    </div>
</div>

<?php $this->start('script'); ?>
<script>
    $('.dataTable').DataTable({
        "language": {
            "url": "<?= \Cake\Routing\Router::url("/i18n/dataTables.fr_FR.json"); ?>"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "<?= \Cake\Routing\Router::url(['controller' => 'Tickets', 'action' => 'index']); ?>",
        "columns": [
            {
                "title": "Code-barre",
                "name": "Tickets.barcode",
                "data": "barcode",
                "orderable": false
            },
            {
                "title": "Nom",
                "name": "Tickets.lastname",
                "data": "lastname",
                "orderable": true
            },
            {
                "title": "Prénom",
                "name": "Tickets.firstname",
                "data": "firstname"
            },
            {
                "title": "Date de naissance",
                "name": "Tickets.birthdate",
                "render": function (data, type, row) {
                    return moment(row.birthdate).format('DD/MM/YYYY')
                }
            },
            {
                "title": "Adresse e-mail",
                "name": "Tickets.email",
                "data": "email"
            },
            {
                "title": "Adresse",
                "name": "Tickets.address",
                "render": function (data, type, row) {
                    return row.address + " " + row.zip_code + " " + row.city
                },
                "orderable": false
            },
            {
                "title": "Type",
                "data": "type"
            },
            {
                "title": "Payé",
                "data": "paid",
                "render": function(data, type, row) {
                    if(row.paid) {
                        return '<span class="label label-success"><i class="fa fa-fw fa-check"></i></span>'
                    } else {
                        return '<span class="label label-danger"><i class="fa fa-fw fa-times"></i></span>'
                    }
                }
            },
            {
                "title": "Status",
                "data": "state",
                "render": function(data, type, row) {
                    if(row.state == 'pending') {
                        return '<span class="label label-danger">En attente</span>'
                    } else if(row.state == 'printed') {
                        return '<span class="label label-warning">Imprimé</span>'
                    } else if(row.state == 'sent') {
                        return '<span class="label label-success">Envoyé</span>'
                    }
                }
            },
            {
                "name": "Tickets.user_code",
                "title": "Vendeur",
                "render": function (data, type, row) {
                    if (row.user !== null) {
                        return row.user.lastname + " " + row.user.firstname;
                    } else {
                        return 'Aucun';
                    }
                }
            }
        ],
        "order": [[1, 'asc']]
    });
</script>
<?= $this->end(); ?>