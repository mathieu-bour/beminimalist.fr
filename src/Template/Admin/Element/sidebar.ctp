<aside class="sidebar">
    <ul>
        <li>
            <?= $this->Html->link(
                'Tableau de bord',
                ['controller' => 'Pages', 'action' => 'dashboard']
            ); ?>
        </li>
        <li>
            <?= $this->Html->link(
                'Tous les tickets <span class="badge pull-right">' . $counters['Tickets']['all'] . '</span>',
                ['controller' => 'Tickets', 'action' => 'index'],
                ['escape' => false]
            ); ?>
        </li>
        <li>
            <?= $this->Html->link('Codes d\'accès',
                ['controller' => 'EarlyCodes', 'action' => 'index']
            ); ?>
        </li>
        <li>
            <?= $this->Html->link('Utilisateurs',
                ['controller' => 'Users', 'action' => 'index']
            ); ?>
        </li>
    </ul>
</aside>