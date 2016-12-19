<?php
use Cake\Routing\Router;

$this->start('script'); ?>
    <script>
        var dataTable = $('.dataTable').DataTable({
            "language": {
                "url": "<?= Router::url("/i18n/dataTables.fr_FR.json"); ?>"
            },
            "rowId": "id",
            "processing": true,
            "serverSide": true,
            "ajax": "<?= Router::url(['controller' => 'Tickets', 'action' => 'checkpoint']); ?>",
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
        });
    </script>
<?= $this->end(); ?>