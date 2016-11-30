<?php $this->extend('admin_base'); ?>

<div class="layout-default">
    <div id="container">
        <?= $this->element('header', compact('session')); ?>
        <?= $this->element('sidebar'); ?>

        <div class="content">
            <div class="container-fluid">
                <?= $this->Flash->render(); ?>
                <?= $this->fetch('content'); ?>
            </div>
        </div>
    </div>
</div>