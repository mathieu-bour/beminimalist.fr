<div class="panel user-login-box">
    <div class="panel-heading">
        <h1 class="text-center">Minimalist</h1>
    </div>

    <div class="panel-body">
        <?= $this->Flash->render(); ?>

        <p>Entrez ici l'e-mail utilisé pour la réservation de vos tickets pour en consulter leur status.</p>

        <?= $this->Form->create(); ?>
            <?= $this->Form->input('email', ['label' => false, 'placeholder' => 'Adresse e-mail']); ?>
            <button class="btn btn-block btn-ghost-inv">Voir mes tickets</button>
        <?= $this->Form->end(); ?>
    </div>
</div>