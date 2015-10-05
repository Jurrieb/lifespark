<div class="postWrapper">
    <div class="postHead">
        <div class="avatar"></div>
        <div class="name"><?php echo $this->Html->link($post->user->name,
            ['controller' => 'Users', 'action' => 'profile', $post->user->slug],
            ['escape' => false]
                ); ?>: <?php echo $post->content;?></div>
         <div class="date"><?php echo $post->created_at;?></div>
    </div>
    <div class="post">
        <?php echo $post->content;?>
    </div>
    <?php
    if(!empty($post->comments)) {
    ?>
        <div class="comments">
    <?php
        foreach($post->comments as $comment) {
    ?>
        <div class='comment'>
            <div class="avatar"></div>
            <?php echo $this->Html->link($comment->user->name,
                ['controller' => 'Users', 'action' => 'profile', $comment->user->slug],
                ['escape' => false]
             ); ?>: <?php echo $comment->content;?>
             <?php echo $comment->created_at;?>
        </div>
    <?php
        }
    }
    if(!empty($post->comments)) {
    ?>
    </div>
    <?php } ?>
</div>