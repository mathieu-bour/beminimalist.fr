<?php $this->extend('base'); ?>

<body id="home">
    <div id="container">
        <?= $this->Flash->render(); ?>
        <?= $this->fetch('content'); ?>
    </div>

    <?= $this->Html->script('public'); ?>
</body>