<header class="topbar">

	<div class="active-user">
        <div class="avatar">
            J
        </div>
        <div class="information">
            <div class="name">
                <?php echo $this->Html->link($currentUser->name,
                        ['controller' => 'Users', 'action' => 'profile', $currentUser->slug],
                        ['escape' => false]
                    );
                ?>
            </div>
            <div class="karma">
                <span class="label green"><?php echo $currentUser->karma;?> karma</span>
            </div>
        </div>
	</div>

	<nav class="menu">
		<ul>
            <?php
            echo '<li>'.$this->Html->link(
				    '<span class="icon-question_answer"></span>',
				    ['controller' => 'Messages', 'action' => 'index'], ['escape' => false]
				). '</li>';
            echo '<li>'.$this->Html->link(
				    '<span class="icon-public"></span>',
				    ['controller' => 'Activity', 'action' => 'index'], ['escape' => false]
				). '</li>';
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
