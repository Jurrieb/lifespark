<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->Assets->css('app') ?>
</head>
<body>
    <div class="content">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
    <?= $this->element('sidebar') ?>
    <?= $this->element('header') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Assets->script('app') ?>
</body>
</html>
