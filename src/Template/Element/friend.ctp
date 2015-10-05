<div class="friend">

    <div class="avatar big">
        <?php echo $this->Html->image('avatar.jpg');?>
        <div class="karma">
            <span class="label"><?php echo $friend->karma;?> karma</span>
        </div>
    </div>

    <?php
    echo $this->Html->link($friend->name,
        ['controller' => 'Users', 'action' => 'profile', $friend->slug],
        ['escape' => false]
    );
    ?>
</div>