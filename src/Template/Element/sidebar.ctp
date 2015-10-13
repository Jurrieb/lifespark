<div class="sidebar">
    <ul>
        <?php
           echo '<li><a href=""><span class="icon-menu"></span></a></li>';
           echo '<li>' . $this->Html->link(
                  '<span class="icon-home"></span>' .  __d('pages', 'Overview'),
                ['controller' => 'Pages', 'action' => 'overview'],['escape' => false]
				) . '</li>';
   echo '<li>'.$this->Html->link(
				    '<span class="icon-trending_up"></span>' . __d('Progress', 'Progress'),
				    ['controller' => 'Progress', 'action' => 'index'],['escape' => false]
				). '</li>';
   echo '<li>'.$this->Html->link(
				    '<span class="icon-group"></span>' . __d('friends', 'Friends'),
				    ['controller' => 'Friends', 'action' => 'index'],['escape' => false]
				). '</li>';
   echo '<li>'.$this->Html->link(
				    '<span class="icon-view_module"></span>' . __d('plugins', 'Plugins'),
				    ['controller' => 'Plugins', 'action' => 'index'],['escape' => false]
				). '</li>';
   echo '<li>'.$this->Html->link(
				    '<span class="icon-question_answer"></span>' . __d('messages', 'Messages'),
				    ['controller' => 'messages', 'action' => 'index'],['escape' => false]
				). '</li>';
   echo '<li>'.$this->Html->link(
				    '<span class="icon-power_settings_new"></span>' . __d('user', 'logout'),
				    ['controller' => 'Users', 'action' => 'logout'],['escape' => false]
				). '</li>';

            ?>
    </ul>
</div>