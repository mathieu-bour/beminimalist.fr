<header class="header">
    <div class="header-left">
        <h2 class="header-title"><i class="fa fa-bars sidebar-switcher"></i> <?= $title; ?></h2>
    </div>

    <div class="header-right">
        <ul>
            <li><a href="#">Connecté en tant que <?= $session->read('Auth.User.firstname'); ?> <?= $session->read('Auth.User.lastname'); ?></a></li>
            <li><?= $this->Html->link('<i class="fa fa-power-off"></i></li>', ['controller' => 'Users', 'action' => 'logout'], ['escape' => false]); ?>
        </ul>
    </div>
</header>