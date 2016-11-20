<?= $this->Form->create('Ticket', [
    'horizontal' => true,
    'columns' => [
        'label' => 3,
        'input' => 9,
        'error' => 0
    ]
]); ?>

<h3>Profil</h3>

<?= $this->Form->input('lastname', ['label' => 'Nom']); ?>
<?= $this->Form->input('firstname', ['label' => 'Prénom']); ?>
<?= $this->Form->input('gender', [
    'type' => 'radio',
    'options' => [
        ['value' => 'M', 'text' => 'Homme'],
        ['value' => 'F', 'text' => 'Femme'],
    ],
    'hiddenField' => false,
    'label' => 'Sexe'
]); ?>
<?= $this->Form->input('birthdate', [
    'label' => 'Date de naissance',
    'type' => 'date',
    'maxYear' => 2000,
    'minYear' => 1990,
    'templates' => [
        'dateWidget' => '{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}'
    ]
]); ?>
<?= $this->Form->input('email', ['label' => 'Adresse e-mail']); ?>

<?= $this->Form->input('address', ['label' => 'Adresse']); ?>
<?= $this->Form->input('zip_code', ['label' => 'Code postal']); ?>
<?= $this->Form->input('city', ['label' => 'Ville']); ?>


<h3>Paiement</h3>
<?= $this->Form->input('type', [
    'type' => 'radio',
    'options' => [
        ['value' => 'PAYPAL', 'text' => 'En ligne, avec PayPal (10,50€)'],
        ['value' => 'PERM', 'text' => 'Physiquement, à une permanence (10,00€)'],
    ],
    'hiddenField' => false,
    'label' => 'Vous souhaitez payer votre place'
]); ?>
<div class="row">
    <div class="col-md-9 col-md-offset-3">
        <p>Note: La liste des permanences est
            détaillée <?= $this->Html->link('ici', ['controller' => 'Permanencies', 'action' => 'index']); ?></p>
    </div>
</div>

<h3>Vendeur</h3>

<div class="row">
    <div class="col-md-9 col-md-offset-3">
        <p>Si un vendeur vous a communiqué son code de vente, inscrivez-le ici.</p>
    </div>
</div>
<?= $this->Form->input('user_code', ['label' => 'Code de vente']); ?>

<div class="text-center">
    <button class="btn btn-lg btn-ghost-inv">Valider ma réservation</button>
</div>

<?= $this->Form->end(); ?>
