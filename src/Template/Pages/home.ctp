<?= $this->html->image('logo.png', ['class' => 'logo-sm']); ?>

<header class="header header-light">
    <h1>Minimalist</h1>
    <h2>Gala d'hiver 2016</h2>
</header>

<div class="countdown">
    <div class="row">
        <div class="col-xs-3">
            <div class="countdown-square">
                <span class="countdown-value" id="countdown-days"></span>
                <span class="countdown-label" id="countdown-days-label"></span>
            </div>
        </div>

        <div class="col-xs-3">
            <div class="countdown-square">
                <span class="countdown-value" id="countdown-hours"></span>
                <span class="countdown-label" id="countdown-hours-label"></span>
            </div>
        </div>

        <div class="col-xs-3">
            <div class="countdown-square">
                <span class="countdown-value" id="countdown-minutes"></span>
                <span class="countdown-label" id="countdown-minutes-label"></span>
            </div>
        </div>

        <div class="col-xs-3">
            <div class="countdown-square">
                <span class="countdown-value" id="countdown-seconds"></span>
                <span class="countdown-label" id="countdown-seconds-label"></span>
            </div>
        </div>
    </div>

    <p class="countdown-title">Avant l'ouverture de la vente des billets</p>
</div>

<div class="text-center">
    <a href="javascript:void(0)" class="btn btn-lg btn-disabled btn-ghost">Places bientôt disponibles !</a>
</div>

<div class="socials">
    <a href="https://www.facebook.com/minimalist.france" target="_blank"><i class="fa fa-facebook-official"></i></a>
    <a href="https://twitter.com/MINIMALIST__fr" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
</div>


<?php
/*
<div class="text-center">
     <?= $this->Html->link('Réserver ma place', ['controller' => 'Tickets', 'action' => 'book'], ['class' => 'btn btn-lg btn-ghost-inv']); ?>
</div>
*/
?>