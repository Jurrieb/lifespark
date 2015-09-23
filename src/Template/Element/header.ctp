<?php $currentUser = $this->request->session()->read('User'); ?>
<header class="topbar">

	<div class="user">
        <div class="avatar">
            <img>
        </div>
        <div class="information">
            <div class="name"><?php echo $currentUser->name;?></div>
            <div class="karma">
                <span class="label"><?php echo $currentUser->karma;?> karma</span>
            </div>
        </div>
	</div>

	<nav class="menu">
		<ul>
            <li><a href="#"><span class="icon-mail"></span></a></li>
            <li><a href="#"><span class="icon-notifications"></span></a></li>
            <?php
            echo '<li>'.$this->Html->link(
				    '<span class="icon-settings"></span>',
				    ['controller' => 'Settings', 'action' => 'index'], ['escape' => false]
				). '</li>';
            echo '<li>'.$this->Html->link(
				    '<span class="icon-power_settings_new"></span>',
				    ['controller' => 'Users', 'action' => 'logout'], ['escape' => false]
				). '</li>';

            ?>
		</ul>
	</nav>

</header>
