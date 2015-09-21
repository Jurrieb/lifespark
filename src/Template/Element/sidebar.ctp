<div class="sidebar">
    <ul>
        <?php
           echo '<li>' . $this->Html->link(
                   __d('pages', 'Overview'),
                ['controller' => 'Pages', 'action' => 'overview']
				) . '</li>';
   echo '<li>'.$this->Html->link(
				    __d('friends', 'Friends'),
				    ['controller' => 'Friends', 'action' => 'index']
				). '</li>';
   echo '<li>'.$this->Html->link(
				    __d('user', 'logout'),
				    ['controller' => 'Users', 'action' => 'logout']
				). '</li>';

            ?>
    </ul>
</div>