<?php
use Cake\Routing\Router;

?>

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
        var dataTable = $('.dataTable').DataTable({
            "language": {
                "url": "<?= Router::url("/i18n/dataTables.fr_FR.json"); ?>"
            },
            "rowId": "id",
            "processing": true,
            "serverSide": true,
            "ajax": "<?= Router::url(['controller' => 'Tickets', 'action' => 'index']); ?>",
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
                    "data": "lastname"
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
                    },
                    "searchable": false
                },
                {
                    "title": "Adresse e-mail",
                    "name": "Tickets.email",
                    "data": "email",
                    "searchable": false
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
                    "data": "type",
                    "searchable": false
                },
                {
                    "title": "Payé",
                    "name": "Tickets.paid",
                    "data": "paid",
                    "render": function (data, type, row) {
                        if (row.paid) {
                            return '<span class="label label-success"><i class="fa fa-fw fa-check"></i></span>'
                        } else {
                            return '<span class="label label-danger"><i class="fa fa-fw fa-times"></i></span>'
                        }
                    },
                    "searchable": false
                },
                {
                    "title": "Status",
                    "name": "Tickets.state",
                    "data": "state",
                    "render": function (data, type, row) {
                        if (row.state == 'pending') {
                            return '<span class="label label-danger">En attente</span>'
                        } else if (row.state == 'printed') {
                            return '<span class="label label-warning">Imprimé</span>'
                        } else if (row.state == 'sent') {
                            return '<span class="label label-success">Envoyé</span>'
                        }
                    },
                    "searchable": false
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
                },
                {
                    "title": "Actions",
                    "render": function (data, type, row) {
                        return '<a href="<?= Router::url(['controller' => 'Tickets', 'action' => 'edit']); ?>/' + row.id + '" class="btn btn-xs btn-warning btn-action"><i class="fa fa-fw fa-edit"></i></a>' +
                            '<a href="#" class="btn btn-xs btn-danger btn-action btn-delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                    },
                    "orderable": false,
                    "searchable": false
                }
            ],
            "order": [[1, 'asc']],
            "scrollX": $(window).width() < 768
        }).on('draw.dt', function () {
            $('.btn-delete').on('click', (function () {
                console.log('lol');
                var $tr = $(this).closest('tr');
                var id = parseInt($tr.attr('id'));

                if (confirm('Confirmer la suppression ?')) {
                    $.ajax({
                        "dataType": "json",
                        "method": "post",
                        "url": "<?= Router::url(['controller' => 'Tickets', 'action' => 'delete']); ?>/" + id,
                        "success": function (json) {
                            console.log(json);
                            dataTable.draw();
                        }
                    });
                }
            }));
        });
    </script>
<?= $this->end(); ?>