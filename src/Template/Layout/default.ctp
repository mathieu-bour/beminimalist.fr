<?php $this->extend('base'); ?>

<body>
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <header class="header text-center">
                <h1>Minimalist</h1>
                <h2>Gala d'hiver</h2>
            </header>

            <div class="content">
                <?= $this->fetch('content'); ?>
            </div>

            <footer class="footer">
                <div class="text-center">Baked with love by Mathieu Bour</div>
            </footer>
        </div>
    </div>

    <?= $this->Html->script('public'); ?>
</body>