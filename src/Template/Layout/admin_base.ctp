<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINIMALIST - Administration</title>

        <?= $this->Html->meta('icon') ?>

        <?= $this->Html->css('//fonts.googleapis.com/css?family=Roboto'); ?>
        <?= $this->Html->css('admin'); ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
    </head>

    <body>
        <?= $this->fetch('content'); ?>

        <?= $this->Html->script('admin'); ?>
    </body>
</html>
