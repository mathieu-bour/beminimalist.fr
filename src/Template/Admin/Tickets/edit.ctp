<div class="panel">
    <div class="panel-heading">
        <h3>Éditer le ticket au nom de <?= $ticket->lastname ?> <?= $ticket->firstname; ?></h3>
    </div>

    <div class="panel-body">
        <?= $this->Form->create($ticket); ?>

        <h3>Données du ticket</h3>
        <div class="row">
            <div class="col-md-3">
                <?= $this->Form->input('barcode', [
                    'label' => 'Code-barre'
                ]); ?></div>
            <div class="col-md-3">
                <?= $this->Form->input('type', [
                    'label' => 'Type',
                    'options' => ['paypal' => 'PayPal', 'perm' => 'Permanence']
                ]); ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->input('paid', [
                    'label' => 'Paiement',
                    'options' => ['0' => 'Non payé', '1' => 'Payé']
                ]); ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->input('state', [
                    'label' => 'État',
                    'options' => ['pending' => 'En attente', 'printed' => 'Imprimé', 'sent' => 'Envoyé']
                ]); ?>
            </div>
        </div>


        <h3>Données de l'invité</h3>
        <div class="row">
            <div class="col-md-3">
                <?= $this->Form->input('lastname', [
                    'label' => 'Nom'
                ]); ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->input('firstname', [
                    'label' => 'Prénom'
                ]); ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->input('gender', [
                    'label' => 'Sexe',
                    'options' => ['M' => 'Homme', 'F' => 'Femme']
                ]); ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->input('birthdate', [
                    'label' => 'Date de naissance',
                    'maxYear' => 1999,
                    'minYear' => 1990,
                    'templates' => [
                        'dateWidget' => '{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}'
                    ]
                ]); ?>
            </div>
        </div>


        <h3>Cooordonnées de l'invité</h3>
        <div class="row">
            <div class="col-md-3">
                <?= $this->Form->input('email', [
                    'label' => 'Adresse e-mail'
                ]); ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->input('address', [
                    'label' => 'Adresse'
                ]); ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->input('zip_code', [
                    'label' => 'Code postal'
                ]); ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->input('city', [
                    'label' => 'Ville'
                ]); ?>
            </div>
        </div>

        <button class="btn btn-primary">Enregistrer</button>
        <?= $this->Form->end(); ?>
    </div>
</div>