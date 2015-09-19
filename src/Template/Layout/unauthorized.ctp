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
        echo $this->Html->css('base.css');
        echo $this->Html->css('unauthorized.css');
    ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <section class="backdrop">
		<div class="backdropWrapper">
			<div class="backdropContent clearfix">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </section>
    <?= $this->fetch('script') ?>
    <?php
        if($production) {
            echo $this->Html->script('cached.js');
        } else {
            echo $this->Html->script('base.js');
        }
    ?>
</body>
</html>
