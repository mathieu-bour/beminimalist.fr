<div class="row">
    <div class="col-md-3">
        <div class="panel">
            <div class="panel-heading">
                <h3>Billeterie :
                    <?php if ($settings->read('ticketing') == '1'): ?>
                        <span class="label label-success">Ouverte</span>
                    <?php else: ?>
                        <span class="label label-danger">Fermée</span>
                    <?php endif; ?>
                </h3>
            </div>
            <div class="panel-body">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Settings', 'action' => 'update']]); ?>
                <?= $this->Form->input('opening_early', [
                    'label' => 'Ouverture aux préventes',
                    'value' => $settings->read('opening_early'),
                    'append' => [
                        $this->Form->button('Valider', ['class' => 'btn-info'])
                    ]
                ]); ?>
                <?= $this->Form->end(); ?>

                <?= $this->Form->create(null, ['url' => ['controller' => 'Settings', 'action' => 'update']]); ?>
                <?= $this->Form->input('opening_early', [
                    'label' => 'Ouverture générale',
                    'value' => $settings->read('opening_global'),
                    'append' => [
                        $this->Form->button('Valider', ['class' => 'btn-info'])
                    ]
                ]); ?>
                <?= $this->Form->end(); ?>

                <?= $this->Form->create(null, ['url' => ['controller' => 'Settings', 'action' => 'update']]); ?>
                <?= $this->Form->input('tickets_left', [
                    'label' => 'Tickets restants',
                    'value' => $settings->read('tickets_left'),
                    'append' => [
                        $this->Form->button('Valider', ['class' => 'btn-info'])
                    ]
                ]); ?>
                <?= $this->Form->end(); ?>

                <?= $this->Form->create(null, ['url' => ['controller' => 'Settings', 'action' => 'update']]); ?>
                <?php if ($settings->read('ticketing') == '1'): ?>
                    <button class="btn btn-block btn-danger" name="ticketing" value="0">Fermer la billeterie</button>
                <?php else: ?>
                    <button class="btn btn-block btn-success" name="ticketing" value="1">Ouvrir la billeterie</button>
                <?php endif; ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= $this->element('Charts/tickets_map', compact('charts')); ?>
    </div>
</div>