<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="<?= WWW_ROOT . 'css' . DS . 'ticket.css'; ?>">
    </head>

    <body>
        <div class="tickets">
            <?= $this->fetch('content'); ?>
        </div>
    </body>
</html>