<?= $this->Form->create('Ticket'); ?>

<div class="row">
    <div class="col-md-6">
        <label class="control-label">Profil</label>
        <div class="row">
            <div class="col-md-6">
                <?= $this->Form->input('lastname', [
                    'placeholder' => 'Nom',
                    'label' => false
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->input('firstname', [
                    'placeholder' => 'Prénom',
                    'label' => false
                ]); ?>
            </div>
        </div>
        <?= $this->Form->input('email', [
            'placeholder' => 'Adresse e-mail',
            'label' => false
        ]); ?>
        <div class="form-group">
            <label class="control-label">Sexe</label>
            <div>
                <label for="gender-m" class="radio-inline"><input type="radio" name="gender" value="M" id="gender-m">Homme</label>
                <label for="gender-f" class="radio-inline"><input type="radio" name="gender" value="F" id="gender-f">Femme</label>
            </div>
        </div>
        <?= $this->Form->input('birthdate', [
            'label' => 'Date de naissance',
            'type' => 'date',
            'maxYear' => 1999,
            'minYear' => 1990,
            'templates' => [
                'dateWidget' => '{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}'
            ]
        ]); ?>

        <?= $this->Form->input('address', [
            'placeholder' => 'Adresse',
            'label' => 'Adresse postale'
        ]); ?>
        <div class="row">
            <div class="col-md-4">
                <?= $this->Form->input('zip_code', [
                    'placeholder' => 'Code postal',
                    'label' => false
                ]); ?>
            </div>
            <div class="col-md-8">
                <?= $this->Form->input('city', [
                    'placeholder' => 'Ville',
                    'label' => false
                ]); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $this->Form->input('early_code', [
                    'placeholder' => 'Code de prévente',
                    'label' => false
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->input('user_code', [
                    'placeholder' => 'Code du vendeur (facultatif)',
                    'label' => false
                ]); ?>
            </div>
        </div>

        <div class="text-center">
            <label class="control-label">Choix du mode de paiement</label>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-ghost-inv">PayPal (11.00€)</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-ghost-inv">Permanence (10.00€)</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <header class="header">
            <h1>Minimalist</h1>
            <h2>Gala d'hiver</h2>
        </header>

        <?= $this->Html->image('logo-black.png', ['class' => 'logo']); ?>
    </div>
</div>

<?= $this->Form->end(); ?>
