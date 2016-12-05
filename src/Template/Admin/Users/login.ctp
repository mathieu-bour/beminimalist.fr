<div class="panel">
    <div class="panel-heading">
        <h1 class="text-center">Minimalist</h1>
        <h4 class="text-center">Administration</h4>
    </div>

    <div class="panel-body">
        <?= $this->Flash->render(); ?>

        <?= $this->Form->create('User'); ?>
            <?= $this->Form->input('email', ['label' => false, 'placeholder' => 'Adresse e-mail']); ?>
            <?= $this->Form->input('password', ['label' => false, 'placeholder' => 'Mot de passe']); ?>

            <button class="btn btn-block btn-ghost-inv">Connexion</button>
        <?= $this->Form->end(); ?>
    </div>
</div>