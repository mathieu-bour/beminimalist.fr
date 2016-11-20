<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINIMALIST - Gala d'hiver 2016</title>

        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css('public'); ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
    </head>

    <?= $this->fetch('content'); ?>
</html>
