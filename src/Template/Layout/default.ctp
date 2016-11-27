<?php $this->extend('base'); ?>

<body>
    <div class="container" id="container">
        <div class="content">
            <?= $this->fetch('content'); ?>
        </div>

        <footer class="footer">
            <div class="text-center">Baked with love by Mathieu Bour</div>
        </footer>
    </div>

    <?= $this->Html->script('public'); ?>
</body>