<div class="top-block">
    <?php echo $user->name;?>
    <div class="karma">
        <span class="label"><?php echo $user->karma;?> karma</span>
    </div>
    <div class="connection">
    <?php
    echo $this->Form->create();
    echo $this->Form->hidden('slug', ['value' => $user->slug]);
    switch ($connection) {
        case 'accepted':
            echo $this->Form->hidden('action', ['value' => 'remove']);
            echo $this->Form->button('Remove friend', ['class' => 'button orange']);
            break;
        case 'requested':
            echo $this->Form->button('Request has been send', ['class' => 'button green']);
            break;
        case 'friend-request':
            echo $this->Form->hidden('action', ['value' => 'accept']);
            echo $this->Form->button('Accept friend request', ['class' => 'button green']);
            break;
        case 'self':
            break;
        default:
            echo $this->Form->hidden('action', ['value' => 'send']);
            echo $this->Form->button('Send friend request', ['class' => 'button green']);
            break;
    }
    echo $this->Form->end();
        ?>
    </div>
</div>
<div class="block">
    <div class="posts">
    <?php foreach($posts as $post) {
        echo $this->element('post', ['post' => $post]);
    }?>
    </div>
</div>