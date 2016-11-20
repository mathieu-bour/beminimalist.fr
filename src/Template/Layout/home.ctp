<?php $this->extend('base'); ?>

<body id="home">
    <div id="container">
        <?= $this->fetch('content'); ?>
    </div>

    <?= $this->Html->script('public'); ?>
</body>