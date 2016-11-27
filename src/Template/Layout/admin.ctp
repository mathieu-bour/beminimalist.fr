<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINIMALIST - Administration</title>

        <?= $this->Html->meta('icon') ?>

        <?= $this->Html->css('admin'); ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
    </head>

    <body>
        <div id="container">
            <?= $this->element('header'); ?>
            <?= $this->element('sidebar'); ?>

            <div class="content">
                <div class="container-fluid">
                    <?= $this->Flash->render(); ?>
                    <?= $this->fetch('content'); ?>
                </div>
            </div>
        </div>

        <?= $this->Html->script('admin'); ?>
    </body>
</html>
