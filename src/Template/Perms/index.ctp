<h3>Permanences</h3>

<table class="table text-left">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('datetime', 'Date') ?></th>
            <th>Adresse postale</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($perms as $perm): ?>
            <tr>
                <td><?= $perm->datetime ?></td>
                <td><?= $perm->address ?> <?= $perm->zip_code ?> <?= $perm->city; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>