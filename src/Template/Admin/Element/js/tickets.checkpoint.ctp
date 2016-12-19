<?php
use Cake\Routing\Router;

$this->start('script'); ?>
    <script>
        $('.add-here').on('click', function (e) {
            e.preventDefault();

            $.post({
                url: '/admin/tickets/add',
                dataType: 'json',
                data: {
                    firstname: 'surplace',
                    lastname: 'surplace',
                    paid: 1,
                    type: 'here',
                    gender: 'M',
                    validated: moment().format('YYYY-MM-DD HH:mm:ss')
                }
            }, function(json) {
                if(json.code == 200) {
                    reload_stats();
                }
            });
        });

        function reload_stats() {
            $.get({
                url: '/admin/tickets/stats',
                dataType: 'json'
            }, function(json) {
                if(json.code == 200) {
                    $('#tickets-validated-count').text(json.data.validated);
                    $('#tickets-paypal-count').text(json.data.paypal);
                    $('#tickets-perm-count').text(json.data.perm);
                    $('#tickets-here-count').text(json.data.here);
                }
            });
        }

        reload_stats();

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
                    "title": "Date de naissance",
                    "name": "Tickets.validated",
                    "render": function (data, type, row) {
                        if (row.validated != null) {
                            return moment(row.validated).format('DD/MM/YYYY HH:mm:ss')
                        } else {
                            return 'Non validé'
                        }
                    },
                    "searchable": false
                },
                {
                    "title": "Actions",
                    "render": function (data, type, row) {
                        if (row.validated == null) {
                            return '<a href="#" class="btn btn-xs btn-success btn-action validate">Valider</a>';
                        } else {
                            return '<a href="#" class="btn btn-xs btn-danger btn-action unvalidate">Dévalider</a>';
                        }
                    },
                    "orderable": false,
                    "searchable": false
                }
            ],
            "order": [[1, 'asc']],
            "scrollX": $(window).width() < 768
        }).on('draw.dt', function () {
            $('.validate').on('click', function (e) {
                var $btn = $(this);
                var $row = $btn.parents('tr');
                var id = $row.attr('id');

                $.post({
                    url: '/admin/tickets/validate/' + id,
                    dataType: 'json'
                }, function (json) {
                    if (json.code == 200) {
                        dataTable.ajax.reload();
                        reload_stats();
                    }
                });
            });

            $('.unvalidate').on('click', function (e) {
                var $btn = $(this);
                var $row = $btn.parents('tr');
                var id = $row.attr('id');

                $.post({
                    url: '/admin/tickets/unvalidate/' + id,
                    dataType: 'json'
                }, function (json) {
                    if (json.code == 200) {
                        dataTable.ajax.reload();
                        reload_stats();
                    }
                });
            });
        });
    </script>
<?= $this->end(); ?>