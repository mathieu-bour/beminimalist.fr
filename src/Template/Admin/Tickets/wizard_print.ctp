<?php $this->extend('wizard'); ?>

<h2>Étape 1 : imprimez les tickets</h2>
<p>Cliquez sur le bouton ci-dessous pour imprimer les trois tickets.</p>

<?= $this->Html->link('Afficher les tickets à imprimer', [
    'action' => 'print',
    '?' => [
        'codes' => implode(',', array_values($session->read('Wizard.Tickets')))
    ]
], [
    'class' => 'btn btn-lg btn-primary',
    'target' => '_blank'
]); ?>

<?= $this->Form->create('Ticket'); ?>
    <?= $this->Form->input('ok', ['type' => 'hidden', 'value' => 1]); ?>
    <button class="btn btn-lg btn-success">J'ai imprimé les tickets, continuer</button>
<?= $this->Form->end(); ?>

