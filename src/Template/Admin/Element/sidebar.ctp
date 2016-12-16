<aside class="sidebar">
    <div class="sidebar-header">
        <h1>Minimalist</h1>
    </div>

    <div class="sidebar-content">
        <div class="menu-container">
            <ul class="menu">
                <li class="current">
                    <?= $this->Html->link(
                        'Tableau de bord',
                        ['controller' => 'Pages', 'action' => 'dashboard']
                    ); ?>
                </li>
                <li>
                    <a href="#">Tickets</a>
                    <ul class="sub-menu">
                        <li>
                            <?= $this->Html->link(
                                'Tous les tickets',
                                ['controller' => 'Tickets', 'action' => 'index'],
                                ['escape' => false]
                            ); ?>
                        </li>
                        <li>
                            <?= $this->Html->link(
                                'Tickets à imprimer',
                                ['controller' => 'Tickets', 'action' => 'print'],
                                ['escape' => false]
                            ); ?>
                        </li>
                    </ul>
                </li>
                <li>
                    <?= $this->Html->link('Codes d\'accès',
                        ['controller' => 'EarlyCodes', 'action' => 'index']
                    ); ?>
                </li>
                <li>
                    <?= $this->Html->link('Permanences',
                        ['controller' => 'Perms', 'action' => 'index']
                    ); ?>
                </li>
                <li>
                    <?= $this->Html->link('Utilisateurs',
                        ['controller' => 'Users', 'action' => 'index']
                    ); ?>
                </li>
                <li>
                    <?= $this->Html->link('Checkpoint',
                        ['controller' => 'Tickets', 'action' => 'checkpoint']
                    ); ?>
                </li>
            </ul>
        </div>
    </div>
</aside>