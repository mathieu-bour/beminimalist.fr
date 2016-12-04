<div class="panel">
    <div class="panel-heading">
        <h3>Assistant d'impression des tickets - <?= $stats['tickets']['pending']; ?> tickets à imprimer</h3>
    </div>

    <div class="panel-body">
        <h3>Utilisation de l'assistant d'impression</h3>

        <blockquote>
            <h4>Étape 1</h4>
            <p>Choisir le nombre de tickets à imprimer (par défauts, tous les tickets payés et non imprimés) et cliquer
                sur "Valider".</p>

            <h4>Étape 2</h4>
            <p>Cliquer sur "Imprimer", puis imprimé le document PDF ouvert dans l'onglet créé.</p>

            <h4>Étape 3</h4>
            <p>Une fois les tickets imprimés, cliquer sur "Terminer" pour confirmer l'impression.</p>
        </blockquote>

        <?php
        echo $this->Form->create(null, ['horizontal' => true]);

        // Generate count select choices
        $pending = $stats['tickets']['pending'];
        $extra = $pending % 3;
        $options = [$pending => 'Tous (' . ((int)($pending / 3) + ($extra == 0 ? 0 : 1)) . ' page' . ($pending / 3 > 1 ? 's' : '') . ')'];
        for ($i = 3; $i < $pending; $i += 3) {
            $options[$i] = $i . ' (' . ($i / 3) . ' page' . ($i / 3 > 1 ? 's' : '') . ')';
        }
        echo $this->Form->input('count', [
            'type' => 'select',
            'options' => $options,
            'label' => 'Nombre de tickets à imprimer',
            'append' => [
                $this->Form->button('Valider', ['class' => 'btn-primary', 'id' => 'ticket-print-validate-btn', 'name' => 'action', 'value' => 'validate']),
                $this->Form->button('Imprimer', ['class' => 'btn btn-primary disabled', 'id' => 'ticket-print-print-btn']),
                $this->Form->button('Terminer', ['class' => 'btn-primary disabled', 'id' => 'ticket-print-finish-btn', 'name' => 'action', 'value' => 'finish'])
            ]
        ]);

        echo $this->Form->end();
        ?>
    </div>
</div>