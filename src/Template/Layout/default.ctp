<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?php
        if($production) {
            echo $this->Html->css('cached.css');
            echo $this->Html->script('cached.js');
        } else {
            echo $this->Html->css('base.css');
            echo $this->Html->css('application.css');
            echo $this->Html->css('icons.css');

            echo $this->Html->script('base.js');
            echo $this->Html->script('application.js');
        }
    ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <div class="content">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
    <?= $this->element('sidebar') ?>
    <?= $this->element('header') ?>
    <?= $this->fetch('script') ?>
    <?php
        if($production) {
            echo $this->Html->script('cached.js');
        } else {
            echo $this->Html->script('base.js');
            echo $this->Html->script('application.js');
        }
    ?>
</body>
</html>
