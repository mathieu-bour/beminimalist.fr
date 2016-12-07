<?php $this->extend('admin_base'); ?>

<div class="layout-default">
    <div id="container">
        <?= $this->element('header', compact('session')); ?>
        <?= $this->element('sidebar'); ?>

        <div class="content">
            <?= $this->Flash->render(); ?>
            <?= $this->fetch('content'); ?>
        </div>
    </div>
</div>