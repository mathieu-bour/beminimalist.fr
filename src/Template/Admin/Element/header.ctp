<header class="header">
    <h1>Minimalist</h1>

    <div class="pull-right">
        <span>Connecté en tant que <?= $session->read('Auth.User.firstname'); ?> <?= $session->read('Auth.User.lastname'); ?></span>

        <?= $this->Html->link('Déconnexion', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn btn-danger']); ?>
    </div>
</header>