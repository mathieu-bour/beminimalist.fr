<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINIMALIST - Administration</title>

        <?= $this->Html->meta('icon') ?>

        <?= $this->Html->css([
            '/plugins/bootstrap/dist/css/bootstrap',
            '/plugins/font-awesome/css/font-awesome',
            'admin'
        ]); ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>

        <?= $this->Html->script([
            '/plugins/jquery/dist/jquery',
            'admin'
        ]); ?>
    </head>

    <body>
        <div id="container">
            <?= $this->element('header'); ?>
            <?= $this->element('sidebar'); ?>

            <div class="content">
                <?= $this->fetch('content'); ?>
            </div>
        </div>
    </body>
</html>
