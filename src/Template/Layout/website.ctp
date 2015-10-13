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
    <?= $this->Assets->css('website') ?>
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
    <?= $this->Assets->script('website') ?>
</body>
</html>
