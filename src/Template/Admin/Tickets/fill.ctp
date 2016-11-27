<div>
    <h2>Étape 1: imprimez les tickets (trois par page)</h2>

    <?= $this->Html->link('Imprimer les tickets', [
        'action' => 'print',
        '?' => ['codes' => implode(',', $codes)],
    ], [
        'class' => 'btn btn-lg btn-primary',
        'target' => '_blank'
    ]); ?>
</div>



<div>
    <h2>Étape 3 : finalisez la proocédure de remplissage</h2>

    <?= $this->Html->link('Terminer la procédure', [
        'action' => 'print',
        '?' => ['codes' => implode(',', $codes)],
    ], [
        'class' => 'btn btn-lg btn-primary',
        'target' => '_blank'
    ]); ?>

</div>