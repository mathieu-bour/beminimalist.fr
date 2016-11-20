<h2>À envoyer</h2>

<table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Adresse</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($permanencies as $permanency): ?>
            <tr>
                <td><?= $permanency->begin; ?></td>
                <td><?= $permanency->location; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>