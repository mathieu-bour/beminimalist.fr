<aside class="sidebar">
    <ul>
        <li>
            <?= $this->Html->link('Gestion de la billeterie', ['controller' => 'pages', 'action' => 'ticketing']); ?>
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
            <?= $this->Html->link('Assistant',
                ['controller' => 'Tickets', 'action' => 'wizard', 'init']
            ); ?>
        </li>
    </ul>
</aside>