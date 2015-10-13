<div class="friend">

    <div class="avatar big">
        <?php echo $this->Html->image('avatar.jpg');?>
        <div class="karma">
            <span class="label green"><?php echo $friend->karma;?> karma</span>
        </div>
    </div>
    <div class="name">
        <?php
        echo $this->Html->link($friend->name,
            ['controller' => 'Users', 'action' => 'profile', $friend->slug],
            ['escape' => false]
        );
        ?>
    </div>
</div>