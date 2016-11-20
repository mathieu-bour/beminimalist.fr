<aside class="sidebar">
    <ul>
        <li>

            <?= $this->Html->link(
                'Tous les tickets <span class="badge pull-right">' . $counters['Tickets']['all'] . '</span>',
                ['controller' => 'Tickets', 'action' => 'index'],
                ['escape' => false]
            ); ?>
        </li>
        <li>
            <?= $this->Html->link(
                'Tickets à envoyer <span class="badge pull-right">' . $counters['Tickets']['to_send'] . '</span>',
                ['controller' => 'Tickets', 'action' => 'to_send'],
                ['escape' => false]
            ); ?>
        </li>
        <li>
            <?= $this->Html->link('Permanences', ['controller' => 'Permanencies', 'action' => 'index']); ?>
        </li>
        <li>
            <?= $this->Html->link('Ajouter une permanence', ['controller' => 'Permanencies', 'action' => 'add']); ?>
        </li>
        <li>
            <?= $this->Html->link('Utilisateur', ['controller' => 'Users', 'action' => 'index']); ?>
        </li>
        <li>
            <?= $this->Html->link('Ajouter un utilisateur', ['controller' => 'Users', 'action' => 'add']); ?>
        </li>
    </ul>
</aside>