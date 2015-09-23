<div class="karma">
    <span class="label"><?php echo $friend->karma;?> karma</span>
</div>
<?php
echo $this->Html->link($friend->name,
    ['controller' => 'Users', 'action' => 'profile', $friend->slug],
    ['escape' => false]
);
?>
<?php echo $friend->name;?>